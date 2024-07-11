<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siasnlib{
    // ganti dg url api dan token sesuai di admin panel
    public $URL;
    public $URL_OAUTH;
    public $URL_SSO;
    public $CONSUMER_KEY;
    public $CONSUMER_SECRET;
    public $CLIENT_ID;
    public $USERNAME_SSO;
    public $PASSWORD_SSO;
    protected $siasnlib;

    public function __construct()
    {
        $this->URL = "https://core.siasnlib.id/bkdmdo/api";
        $this->URL_OAUTH = "https://apimws.bkn.go.id/oauth2/token";
        $this->URL_SSO = "https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token";
        $this->CONSUMER_KEY = "1Bwdhd4h99RBEec87M3LB1f3n94a";
        $this->CONSUMER_SECRET = "DyewOwEpg_podG6SbEuPZ7J0OVca";
        $this->USERNAME_SSO = "199502182020121013";
        $this->PASSWORD_SSO = "742141189Mysapk.";
        $this->CLIENT_ID = "kotamanadoservice";
        $this->siasnlib = &get_instance();
        $this->siasnlib->load->model('general/M_General', 'general');
    }

    function getOauthToken(){
        return $this->postCurl(
            $this->URL_OAUTH,
            json_encode([
                'grant_type' => 'client_credentials'
            ]),
            'POST',
            1
        );
    }

    function getSsoToken(){
        $data_request = [
            'grant_type' => 'password',
            'client_id' => $this->CLIENT_ID,
            'username' => $this->USERNAME_SSO,
            'password' => $this->PASSWORD_SSO,
        ];
        $data_request = jsonToUrlEncode($data_request);
        return $this->postCurl(
            $this->URL_SSO,
            $data_request,
            'POST',
            0
        );
    }

    function postCurl($url, $data, $method = "POST", $flag_use_auth = 1) {
        $res['code'] = 0;
        $res['data'] = null;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => ($data),
            CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                ),
            )
        );

        if($flag_use_auth == 1){
            curl_setopt($curl, CURLOPT_USERPWD, $this->CONSUMER_KEY . ":" . $this->CONSUMER_SECRET);
        } else {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "cache-control: no-cache",
                )
            );
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            // return $err;
            $res['data'] = $err;
        } else {
            $res['data'] = $response;
            // return $response;
        }

        $dec_resp = json_decode($response, true);
        if(isset($dec_resp['error']) || isset($dec_resp['error_description'])){
            $res['code'] = 1;
        }

        $this->siasnlib->general->insert('t_log_ws_siasn', [
            'url' => $url,
            'request' => ($data),
            'method' => $method,
            'response' => ($response),
            'created_by' => $this->siasnlib->general_library->getId()
        ]);

        return $res;
    }
}