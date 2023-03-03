<?php

class C_Kepegawaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function uploadDokumen(){
        render('kepegawaian/V_UploadDokumen', '', '', null);
    }

}
