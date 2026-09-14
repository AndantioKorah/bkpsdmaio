<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegramlib extends CI_Model{
  protected $telegramlib;

  public function __construct(){
      $this->telegramlib = &get_instance();
      $this->telegramlib->load->model('general/M_General', 'general');
  }

  public function hashTelegram()
  {
    //   $token = "1827474004:AAH8TDfeAh8WR_iXIG-vL0CDuF0KZbwtNUk";
      $token = "8906586989:AAHy421Xp2cBYCfbOZyyPDQPutcyILKg0iw";
      $url = "https://api.telegram.org/bot$token/";
      return [
          'token' => $token,
          'url' => $url
      ];
  }

  
  public function xrequest($url, $hashsignature, $uid, $timestmp)
  {
      $session = curl_init($url);
      $arrheader =  array(
          'X-Cons-ID: '.$uid,
          'X-Timestamp: '.$timestmp,
          'X-Signature: '.$hashsignature,
          'Accept: application/json'
      );
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE); 
      curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($session, CURLOPT_SSL_VERIFYHOST, FALSE);


      if (curl_exec($session) === false)
        {
         $result = curl_error($session);
        }
        else
        {
         $result = curl_exec($session);
        }

      //$response = curl_exec($session);
      return $result;
  }

  public function send_curl_exec($method, $method_telegram, $send_to, $data = [])
  {
    $url = $this->hashTelegram()['url'];

    $listMethodForDataPost = [
      "sendMessageInlineKeyboard",
      "sendMessageReplyKeyboard"
    ];

    if($method_telegram == 'sendMessage'){
      $message = isset($data['message']) ? $data['message'] : $data['text'];
      $url = $url.$method_telegram.'?chat_id='.$send_to.'&text='.urlencode($message);
    } else if($method_telegram == 'setWebhook'){
      $url = $url.$method_telegram.'?url='.$data['url_webhook'];
    } else if(in_array($method_telegram, $listMethodForDataPost)){
      $url = $url."sendMessage";
    } else {
      $url = $url.$method_telegram;
    }


    $session = curl_init();

    $header[] = "Content-Type: application/json";

    curl_setopt($session, CURLOPT_HTTPHEADER, $header);
    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 100);
    curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

    // dd(in_array($method_telegram, $listMethodForDataPost));
    if(in_array($method_telegram, $listMethodForDataPost)){
      curl_setopt($session, CURLOPT_POST, true);
      curl_setopt($session, CURLOPT_POSTFIELDS, $data);
    }
    
    $result = curl_exec($session);

    $message = null;
    if(!$result){
        $message = curl_error($session);
    }
    curl_close($session);

    $this->telegramlib->general->insert('t_log_ws_telegram', [
      'url' => $url,
      'request' => is_array($data) ? json_encode($data) : $data,
      'method' => $method,
      'response' => ($result),
      ]);
    
    return ['result' => $result, 'message' => $message];
  }
}

