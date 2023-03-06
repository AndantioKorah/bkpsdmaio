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
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
        render('kepegawaian/V_UploadDokumen', '', '', null);
    }

    public function loadDokumenPns(){
        $cariBy = 1;
        $cariName = "199401042020121011";
        $unor  = null;
        $list = $this->kepegawaian->get_datatables_lihat_dokumen_pns($cariBy,$cariName,$unor);
       var_dump($list);
       die();
        $this->load->view('kepegawaian/V_UploadDokumenItem', null);
    }


    
    


}
