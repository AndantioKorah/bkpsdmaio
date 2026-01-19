<?php

class C_Bacirita extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('bacirita/M_Bacirita', 'bacirita');
    }

    public function manageKegiatan(){
        render('bacirita/V_ManageKegiatan', null, null, null);
    }

    public function saveDataKegiatan(){
        echo json_encode($this->bacirita->saveDataKegiatan($this->input->post()));
    }

    public function loadListKegiatan(){
        $data['result'] = $this->bacirita->loadListKegiatan();
        $this->load->view('bacirita/V_ListKegiatanAdmin', $data);
    }

    public function modalLoadDetailKegiatan($id){
        $data['result'] = $this->bacirita->modalLoadDetailKegiatan($id);
        $this->load->view('bacirita/V_ModalEditKegiatan', $data);
    }

}
