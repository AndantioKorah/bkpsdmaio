<?php

// use chriskacerguis\RestServer\RestController;

class User extends CI_Controller
{
    public $response;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->response = null;
    }

    public function validateKey($arr, $method){
        if($method == 'POST'){
            foreach($arr as $a){
                if(!$this->input->post($a)){
                    return ['code' => 1, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        } else if($method == 'DELETE'){
            foreach($arr as $a){
                if(!$this->delete($a)){
                    return ['code' => 1, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        } else if($method == 'GET'){
            foreach($arr as $a){
                if(!$this->get($a)){
                    return ['code' => 1, 'message' => "Key '".$a."' Tidak Ditemukan"];
                }
            }
        }

        return ['code' => 0, 'message' => ""];
    }

    public function getRekapAbsenPersonal(){
        $list_key = ['id_m_user', 'bulan', 'tahun'];
        foreach($list_key as $lk){
            if(!$this->input->post($lk)){
                $this->response = [
                    'status' => false,
                    'data' => null,
                    'message' => "Key '".$lk."' tidak ditemukan"
                ];
            }
        }


        $data['id_m_user'] = $this->input->post('id_m_user');
        $data['bulan'] = $this->input->post('bulan');
        $data['tahun'] = $this->input->post('tahun');
        $result = $this->rekap->buildDataAbsensi($data, 1, 0, 1);
        if($result){
            $this->response = [
                'status' => true,
                'data' => $result,
                'message' => ''
            ];
        } else {
            $this->response = [
                'status' => false,
                'data' => null,
                'message' => 'Data Tidak Ditemukan'
            ];
        }
        echo json_encode($this->response);
    }
}
