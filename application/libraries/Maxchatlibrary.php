<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Maxchatlibrary{
    // ganti dg url api dan token sesuai di admin panel
    public $API_URL;
    public $TOKEN;
    protected $maxchat;

    public function __construct()
    {
        // $this->API_URL = "https://user.maxchat.id/bkdmdo/api";
        $this->API_URL = "https://core.maxchat.id/bkdmdo/api";
        $this->TOKEN = "JKDBaV2T4DvWsony";
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

    function sendText($to, $text, $replyId = "0", $flag_no_feedback = 0) {
        // kirim pesan ke kontak yang sudah disimpan
        $url = $this->API_URL . "/messages";
        $text = str_replace("U+", "&#x", $text);
        // $text = preg_replace(
        //     '/[\x{1F600}-\x{1F64F}\x{2700}-\x{27BF}\x{1F680}-\x{1F6FF}\x{24C2}-\x{1F251}\x{1F30D}-\x{1F567}\x{1F900}-\x{1F9FF}\x{1F300}-\x{1F5FF}]/u',
        //     '[emoji]$0[/emoji]',
        //     $text
        // );
        $data = array(
            "to" => $to,
            "type" => 'text',
            "text" => $text
        );

        if($replyId != "0"){
            $data = array(
                "to" => $to,
                "type" => 'text',
                "text" => $text,
                "replyId" => $replyId
            );
        }

        $resp = $this->postCurl($url, $data);

        if($flag_no_feedback == 1){
            return $resp;
        }
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

    function sendImg($to, $caption, $filename, $fileurl) {
        // jika kontak belum dikenali pakai "/api/messages/push/image"
        $url = $this->API_URL . "/messages/image";
        
        $data = array(
            "to" => $to,
            "type" => "image",
            "caption" => $caption,
            "url" => $fileurl,
            "filename" => $filename
        );

        return $this->postCurl($url, $data);
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
        $url = $this->API_URL . "/messages";
        
        $data = array(
            "to" => $to,
            'type' => 'document',
            "caption" => $caption,
            // "file" => fileToBase64($fileurl),
            "url" => (base_url().str_replace(' ', '%20', $filename)),
            // "url" => ("https://presensi.manadokota.go.id/siladen/assets/arsipabsensibulanan/".rawurlencode($filename)),
            "fileName" => $filename,
            "useTyping" => true
        );

        $response = $this->postCurl($url, $data);

        $this->maxchat->general->insert('t_log_maxchat', [
            'url' => $url,
            'request' => json_encode($data),
            'response' => ($response),
        ]);

        return $response;
    }

    function sendDocument($to, $fileurl, $filename, $caption) {
        // jika kontak belum dikenali pakai "/api/messages/push/file"
        $url = $this->API_URL . "/messages";

        $data = array(
            "to" => $to,
            'type' => 'document',
            "caption" => $caption,
            // "file" => fileToBase64($fileurl),
            "url" => base_url(str_replace(' ', '%20', $fileurl)),
            // "url" => (base_url().str_replace(' ', '%20', $fileurl)),
            "fileName" => $filename,
            "useTyping" => true
        );
        // dd(json_encode($data));
        $response = $this->postCurl($url, $data);

        $this->maxchat->general->insert('t_log_maxchat', [
            'url' => $url,
            'request' => json_encode($data),
            'response' => ($response),
        ]);

        return $response;
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
        $url = $url."?skipBusy=true";

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
            "Content-Type: application/json; charset=utf-8",
            "cache-control: no-cache",
            // 'Content-Type: text/html; charset=utf-8'
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
        // echo "cURL Error #:" . $err;
        return $err;
        } else {
        // echo $response;
        return $response;
        }
    }
}