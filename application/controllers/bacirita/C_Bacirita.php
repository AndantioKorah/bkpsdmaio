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

}
