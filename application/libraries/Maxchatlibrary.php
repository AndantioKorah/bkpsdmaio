<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Maxchatlibrary{
    // ganti dg url api dan token sesuai di admin panel
    public $API_URL;
    public $TOKEN;
    protected $maxchat;

    public function __construct()
    {
        $this->API_URL = "https://user.maxchat.id/bkdmdo/api";
        $this->TOKEN = "LUWtKp21RbXyK3j7DEpGX1";
        $this->maxchat = &get_instance();
        $this->maxchat->load->model('general/M_General', 'general');
    }

    function webhookCapture() {
        $webhookContent = '';

        $webhook = fopen('php://input' , 'rb');
        
        while (!feof($webhook)) {
            $webhookContent .= fread($webhook, 4096);
        }

        fclose($webhook);

        error_log($webhookContent);

        return json_decode($webhookContent);
    }

    function replyText($to, $text, $chatId) {
        // kirim pesan ke kontak yang sudah disimpan
        $url = $this->API_URL . "/chats"."/".$to."/reply";

        $data = array(
        "msgId" => $chatId, 
        "text" => $text
        );

        return $this->postCurl($url, $data);
    }

    function sendText($to, $text) {
        // kirim pesan ke kontak yang sudah disimpan
        $url = $this->API_URL . "/messages";

        $data = array(
        "to" => $to, 
        "text" => $text
        );

        return $this->postCurl($url, $data);
    }

    function pushText($to, $text) {
        // kirim pesan ke kontak yang tidak dikenali
        $url = $this->API_URL . "/messages/push";
        
        $data = array(
        "to" => $to, 
        "text" => $text
        );

        $this->postCurl($url, $data);
    }

    function replyImage($data) {
        // kirim pesan ke kontak yang sudah disimpan
        $url = $this->API_URL . "/chats"."/".$data['to']."/messages/image";

        $send = array(
            "image" => $data['image'],
            "url" => $data['url'],
            "caption" => $data['caption'],
            "filename" => $data['filename']
        );
        return $this->postCurl($url, $send);
    }

    function replyFile($data) {
        // kirim pesan ke kontak yang sudah disimpan
        $url = $this->API_URL . "/chats"."/".$data['to']."/messages/file";

        $send = array(
            "file" => $data['file'],
            "url" => $data['url'],
            "caption" => $data['caption'],
            "filename" => $data['filename']
        );

        return $this->postCurl($url, $send);
    }

    function sendImg($to, $url, $caption, $filename) {
        // jika kontak belum dikenali pakai "/api/messages/push/image"
        $url = $this->API_URL . "/messages/image";
        
        $data = array(
        "to" => $to, 
        "url" => $url,
        "filename" => $filename
        );

        $this->postCurl($url, $data);
    }

    function getMessageById($id){
        $url = $this->API_URL."/messages"."/".$id;
        return $this->postCurl($url, null, "GET");
    }

    function getMessageMediaById($id){
        $url = $this->API_URL."/messages"."/".$id."/media";
        return $this->postCurl($url, null, "GET");
    }

    function sendFile($to, $fileurl, $filename, $caption) {
        // jika kontak belum dikenali pakai "/api/messages/push/file"
        $url = $this->API_URL . "/messages/file";
        
        $data = array(
        "to" => $to,
        "file" => fileToBase64($fileurl),
        "url" => $fileurl,
        "filename" => $filename,
        "caption" => $caption
        );

        return $this->postCurl($url, $data);
    }

    function sendLink($to, $text, $url) {
        // jika kontak belum dikenali pakai "/api/messages/push/link"
        $url = $this->API_URL . "/messages/link";

        $data = array(
            "to" => $to, 
            "text" => $text,
            "url" => $url
        );

        $this->postCurl($url, $data);
    }

    public function saveLog($data){
        $this->maxchat->general->insert('t_log_maxchat', $data);
    }

    function postCurl($url, $data, $method = "POST") {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $this->TOKEN,
            "Content-Type: application/json",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $this->saveLog([
            'request' => json_encode($data),
            'response' => $response,
            'url' => $url
        ]);

        if ($err) {
        echo "cURL Error #:" . $err;
        return $err;
        } else {
        echo $response;
        return $response;
        }
    }
}