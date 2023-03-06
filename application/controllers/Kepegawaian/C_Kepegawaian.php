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

        // dd($this->general_library->getUserName());
        
        $cariBy = 1;
        $cariName = $this->general_library->getUserName();
        $unor  = null;

        $data['list_dokumen'] = $this->kepegawaian->get_datatables_lihat_dokumen_pns($cariBy,$cariName,$unor);
    //    var_dump($list);
    //    die();
        $this->load->view('kepegawaian/V_UploadDokumenItem', $data);
    }

    public function getInline()
	{
		$nip       =  $this->input->get('id');
		$file      =  $this->input->get('f');
		$flok      =  base_url().'uploads/'.$nip.'/'.$file;
        // var_dump($flok);
        // die();		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/pdf');
		header('Content-Disposition:inline; filename='.$file);                      
		header('Expires:0'); 
		ob_end_clean();
		readfile($flok); 
	}


    
    


}
