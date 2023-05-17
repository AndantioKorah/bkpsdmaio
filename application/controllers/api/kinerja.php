<?php

use chriskacerguis\RestServer\RestController;

class kinerja extends RestController 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('user/M_User', 'user');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
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

    public function getSasaranKerja_get(){
        $list_key = ['id_m_user', 'bulan', 'tahun'];
        foreach($list_key as $lk){
            if(!$this->get($lk)){
                $this->response([
                    'status' => false,
                    'data' => null,
                    'message' => "Key '".$lk."' tidak ditemukan"
                ], 400);
            }
        }

        $id = $this->get('id_m_user');
        $bulan = $this->get('bulan');
        $tahun = $this->get('tahun');
        
        $result = $this->kinerja->loadRencanaKinerja($bulan, $tahun, $id);
        if($result){
            $this->response([
                'status' => true,
                'data' => $result,
                'message' => ''
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'data' => null,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }
        
    }

    public function createSasaranKerja_post(){
        $data = $this->input->post();
        $list_key = ['tugas_jabatan', 'sasaran_kerja', 'tahun', 'bulan', 'target_kuantitas', 'satuan', 'target_kualitas', 'id_m_user'];
        if($data){
            $arrkey = array_keys($data);
            $valkey = $this->validateKey($list_key, 'POST');
            if($valkey['code'] == 1){
                $this->response([
                    'status' => false,
                    'data' => null,
                    'message' => $valkey['message']
                ], 400);    
            } else {
                foreach($list_key as $lk){
                    $data_insert[$lk] = $this->input->post($lk);
                    $data_insert['created_by'] = $this->input->post('id_m_user');
                }

                if($this->kinerja->insert('t_rencana_kinerja', $data_insert) > 0){
                    $this->response([
                        'status' => true,
                        'data' => null,
                        'message' => 'created'
                    ], 201);
                } else {
                    $this->response([
                        'status' => false,
                        'data' => null,
                        'message' => "failed to create"
                    ], 400);
                }
            }
        } else {
            $this->response([
                'status' => false,
                'data' => null,
                'message' => "Request Body not found"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteSasaranKerja_delete(){
        $list_key = ['id_m_user', 'id'];
        $data = null;
        $valkey = $this->validateKey($list_key, 'DELETE');
        if($valkey['code'] == 1){
            $this->response([
                'status' => false,
                'data' => null,
                'message' => $valkey['message']
            ], 400);    
        } else {
            foreach($list_key as $lk){
                $data[$lk] = $this->delete($lk);
            }

            if($this->kinerja->deleteRencanaKerja($data['id'], $data['id_m_user']) > 0){
                $this->response([
                    'status' => true,
                    'data' => null,
                    'message' => 'deleted'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'data' => null,
                    'message' => "failed to delete"
                ], 404);
            }
        }
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];

        $id = $this->get( 'id' );

        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $users )
            {
                // Set the response and exit
                $this->response( $users, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], 404 );
            }
        }
        else
        {
            if ( array_key_exists( $id, $users ) )
            {
                $this->response( $users[$id], 200 );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], 404 );
            }
        }
    }
}
