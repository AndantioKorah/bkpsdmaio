<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apilib extends CI_Model{

    public $api_key;
    public $api_secret;
    public $base_url;
    public $from;

    public function __construct(){
        $this->api_key = "b9e13f92";
        $this->api_secret = "d9b1754f4da78a5a";
        $this->base_url = "https://rest.nexmo.com/";
        $this->from = "BKPSDM MDO";
    }

    public function hashTelegram(){
        $api_key = "b9e13f92";
        $api_secret = "d9b1754f4da78a5a";
        $url = "https://rest.nexmo.com/";
        return [
            'api_key' => $api_key,
            'api_secret' => $api_secret,
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

    public function getAllNoHpFromSiladen($method = 'POST', $data = []){   
        $data_body  =   "username=".$data['username'].
                        "&password=".$data['password'];

        // dd($data_body);

        $session = curl_init();

        $header =  array(
            'Content-Type: application/x-www-form-urlencoded'
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $header);
        curl_setopt($session, CURLOPT_URL, "http://siladen.manadokota.go.id/bidik/api/siladen/hp/getAll");
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($session, CURLOPT_POSTFIELDS, $data_body);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 100);
        
        $result = curl_exec($session);

        $message = "OK";
        if(!$result){
            $message = curl_error($session);
        }
        curl_close($session);
        
        return ['request' => $data_body, 'response' => $result, 'message' => $message];
    }

    function asyncPost($url, $data, $method = "POST") {
        $request_json = json_encode($data, JSON_UNESCAPED_SLASHES); 
        
        $curl = curl_init();
        $url = $url;
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $request_json,
        // CURLOPT_TIMEOUT => 90,
        CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json; charset=utf-8",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err){
            $response = $err;
        }
        curl_close($curl);

        return $response;
    }

}


