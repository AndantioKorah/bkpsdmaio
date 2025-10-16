<?php

use chriskacerguis\RestServer\RestController;

class C_ApiLayanan extends RestController 
// class C_Api extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('kepegawaian/M_Layanan', 'layanan');
        $this->load->model('user/M_User', 'user');
    }

    public function getDataTpp_post(){
        // validasi parameter
        $parameter = validateParameter(['nip']);

        // validasi token
        validateToken($parameter['token'], $parameter['publicKey']);
        
        $bulan = date('m');
        if(isset($parameter['bulan'])){
            $bulan = $parameter['bulan'];
        }

        $tahun = date('Y');
        if(isset($parameter['tahun'])){
            $tahun = $parameter['tahun'];
        }

        $pegawai = $this->m_general->getOne('m_user', 'username', $parameter['nip'], 1);
        if(!$pegawai){
            $this->response([
                'code' => RC_NIP_NOT_FOUND['rc_code'],
                'status' => false, 
                'message' => RC_NIP_NOT_FOUND['message'],
                "data" => null
            ], RC_NIP_NOT_FOUND['code']);
        }

        $data = $this->general_library->getPaguTppPegawaiByIdPegawai($pegawai['id'], $bulan, $tahun, 0);

        $this->response([
            'code' => RC_PROCESS_SUCCESS['rc_code'],
            'status' => true,
            'message' => RC_PROCESS_SUCCESS['message'],
            "data" => $data
        ], RC_PROCESS_SUCCESS['code']);
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
