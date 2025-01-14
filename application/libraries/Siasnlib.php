<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siasnlib{
    // ganti dg url api dan token sesuai di admin panel
    public $URL;
    public $API_URL;
    public $URL_OAUTH;
    public $URL_SSO;
    public $CONSUMER_KEY;
    public $CONSUMER_SECRET;
    public $CLIENT_ID;
    public $USERNAME_SSO;
    public $PASSWORD_SSO;
    public $SSO_TOKEN;
    protected $siasnlib;

    public function __construct()
    {
        $this->URL = "https://core.siasnlib.id/bkdmdo/api";
        $this->API_URL = "https://apimws.bkn.go.id:8243/apisiasn/1.0/";
        $this->URL_OAUTH = "https://apimws.bkn.go.id/oauth2/token";
        $this->URL_SSO = "https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token";
        $this->CONSUMER_KEY = "1Bwdhd4h99RBEec87M3LB1f3n94a";
        $this->CONSUMER_SECRET = "DyewOwEpg_podG6SbEuPZ7J0OVca";
        $this->USERNAME_SSO = "199502182020121013";
        $this->PASSWORD_SSO = "742141189Mysapk.";
        $this->CLIENT_ID = "kotamanadoservice";
        $this->siasnlib = &get_instance();
        $this->siasnlib->load->model('general/M_General', 'general');
        $this->SSO_TOKEN = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzY3NzM5OTAsImlhdCI6MTczNjczMDc5MCwianRpIjoiOGFlM2MzMGMtYWFmNS00ZWNjLWI0MzAtNTQxZjBlOWNmZjA1IiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiJiYjc4NDlmMi04NTkzLTQ4YTQtOWE4My1iMmQ0MTM4NmE5YzIiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrb3RhbWFuYWRvc2VydmljZSIsInNlc3Npb25fc3RhdGUiOiI3NzNmODhjMS0yMDQwLTQ1MjAtOGZkZS04ZDc5ZDBhYjA4NDkiLCJhY3IiOiIxIiwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1zb3RrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1pbmZvamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOnVub3I6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46dW5vcjphcHByb3ZhbCIsInJvbGU6bWFuYWplbWVuLXdzOmRldmVsb3BlciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsIm9mZmxpbmVfYWNjZXNzIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXBlbWVudWhhbi1rZWItcGVnYXdhaSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6cHJvZmlsYXNuOnZpZXdwcm9maWwiXX0sInJlc291cmNlX2FjY2VzcyI6eyJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJBTkRBTlRJTyBBTEZJVVMgRU5SSVFVRSBLT1JBSCIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5OTUwMjE4MjAyMDEyMTAxMyIsImdpdmVuX25hbWUiOiJBTkRBTlRJTyIsImZhbWlseV9uYW1lIjoiQUxGSVVTIEVOUklRVUUgS09SQUgiLCJlbWFpbCI6ImFuZGFudGlva29yYWhAZ21haWwuY29tIn0.RHZqUInS1kPIynYArRZQ6urqf0NMNExH0Zmp84M-UmzX_c92w7hFcTRhlQm8qkIKdacPKM-Q2-tHQOyXz_d1SKPqrNboDL53zwwY2DR2hWGOth4P62U_GW45u9p1woa_ThspM-Mp17S010am5FWuT5w3GAQH-J1102z2-mO9TCo0iBF11aIlKplLmwmf_pj3I9MD00K2UDeaDlI1c8CxF7wJnC-Qs7SV39P4DGUee5ZOrpRFhqac7eVgFPOKLCa9Ml-kRwXuAjLJG9i1izPPvJHYKvDGw7vVv2ao1LyG8kqJiP-enChsrhhLpKkRj_5WmkHwh5c3K0ngS__fiIKdvw";
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

    function getJabatanByNip($nip){
        return $this->postCurl(
            $this->API_URL.'jabatan/pns/'.$nip,
            null,
            "GET",
            0,
            1
        );
    }

    function getJabatanByIdRiwayat($id){
        return $this->postCurl(
            $this->API_URL.'jabatan/id/'.$id,
            null,
            "GET",
            0,
            1
        );
    }

    function getRiwayatSkp($nip){
        return $this->postCurl(
            $this->API_URL.'pns/rw-skp/'.$nip,
            null,
            "GET",
            0,
            1
        );
    }

    function getRiwayatSkp22($nip){
        return $this->postCurl(
            $this->API_URL.'pns/rw-skp22/'.$nip,
            null,
            "GET",
            0,
            1
        );
    }

    function downloadDokumen($url){
        return $this->postCurl(
            $this->API_URL.'download-dok?filePath='.$url,
            null,
            "GET",
            0,
            1
        );
    }

    function saveJabatan($data){
        return $this->postCurl(
            $this->API_URL.'jabatan/save',
            json_encode($data),
            "POST",
            0,
            1
        );
    }

    function deleteJabatanByIdRiwayat($id){
        return $this->postCurl(
            $this->API_URL.'jabatan/delete/'.$id,
            null,
            "DELETE",
            0,
            1
        );
    }

    function uploadRiwayatDokumen($data){
        return $this->postCurl(
            $this->API_URL.'upload-dok-rw',
            ($data),
            "POST",
            0,
            1,
            1
        );
    }

    function postCurl($url, $data, $method = "POST", $flag_use_auth = 1, $flag_use_bearer = 0, $flag_form_data_type = 0) {
        // $data = json_encode($data);
        $content_type = "application/json";
        if($flag_form_data_type == 1){
            $content_type = "multipart/form-data";
        }

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
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                    "Content-Type: ".$content_type,
                    "cache-control: no-cache",
                ),
            )
        );

        if($flag_use_auth == 1){
            curl_setopt($curl, CURLOPT_USERPWD, $this->CONSUMER_KEY . ":" . $this->CONSUMER_SECRET);
        } else {
            // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if($flag_use_bearer != null){
                $headers = array();
                $headers[] = 'Accept: application/json';
                if($flag_form_data_type == 0){
                    $headers[] = 'Content-Type: application/json; charset=utf-8';
                } else {
                    $headers[] = 'Content-Type: multipart/form-data';
                }
                // $headers[] = 'Auth: bearer '.$this->siasnlib->general_library->getSsoSiasnApiToken();
                $headers[] = 'Auth: bearer '.$this->SSO_TOKEN;
                $headers[] = 'Authorization: Bearer '.$this->siasnlib->general_library->getOauthSiasnApiToken();
                // dd($headers);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            } else {
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "cache-control: no-cache"
                    )
                );
            }
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            // return $err;
            $res['data'] = $err;
            $res['code'] = 1;
        } else {
            $res['data'] = $response;
            // return $response;
        }

        $dec_resp = json_decode($response, true);
        
        $decode_resp = null;
        if(isset($dec_resp['data'])){
            // $decode_resp = json_decode($dec_resp['data'], true);
        }

        if(isset($dec_resp['error']) 
        || isset($dec_resp['error_description'])
        || (isset($dec_resp['success']) && $dec_resp['success'] == false) 
        || ($decode_resp && $decode_resp['code'] != 1
        || isset($dec_resp['code']) && $dec_resp['code'] != '1')
        || $response == "0"
        || $response == ""){
            $res['code'] = 1;
            $res['data'] = isset($dec_resp['message']) ? $dec_resp['message'] : $response;
        }
        
        $this->siasnlib->general->insert('t_log_ws_siasn', [
            'url' => $url,
            'request' => is_array($data) ? json_encode($data) : $data,
            'method' => $method,
            'response' => ($response),
            'created_by' => $this->siasnlib->general_library->getId()
        ]);

        return $res;
    }
}