<?php

// require 'vendor/autoload.php';
require FCPATH . 'vendor/autoload.php';
// use PhpOffice\PhpSpreadSheet\Spreadsheet;
// use PhpOffice\PhpSpreadSheet\IOFactory;
require FCPATH . '/vendor/autoload.php';

// use mpdf\mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function cronRekapAbsen()
    {
        $this->rekap->cronRekapAbsen();
    }
}
