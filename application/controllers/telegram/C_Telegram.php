<?php

class C_Telegram extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('telegram/M_Telegram', 'telegram');
    }

    public function getWebhook(){
        $data = file_get_contents('php://input');
        $resp['response'] = json_encode($data);
        $this->telegram->log($resp);
    }

    public function setWebhook(){
        $data['url_webhook'] = base_url().'telegram/webhook';
        $req = $this->telegramlib->send_curl_exec('GET', 'setWebhook', '', $data);
        dd($req);
    }

    public function cronGetUpdates(){
        $this->telegram->cronGetUpdates();
    }
}
