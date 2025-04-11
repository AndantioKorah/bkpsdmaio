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
        $this->load->model('general/M_General', 'general');
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('kepegawaian/M_Layanan', 'layanan');
		$this->load->model('siasn/M_Siasn', 'siasn');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function cronRekapAbsen()
    {
        $this->rekap->cronRekapAbsen();
    }

    public function cronRekapAbsenPD(){
        $this->rekap->cronRekapAbsenPD(date('m'), date('Y'));
    }

    public function cronSendWa(){
        $this->general->logCron('cronSendWa');
        $this->general->cronSendWa();
        // dd('asdd');
        // echo date('d-m-Y H:i:s')." asd \n";
    }

    public function cronDsBulkTte(){
        $this->general->logCron('cronDsBulkTte');
		$this->kepegawaian->cronDsBulkTte();
		$this->layanan->cronBulkDs();
	}

    public function updateSisaCuti($id, $operand){
		$this->kepegawaian->updateSisaCuti($id, $operand);
	}

    public function cronSyncJabatanSiasn(){
        // $this->general->logCron('cronSyncJabatanSiasn');
        // $this->siasn->cronRiwayatJabatanSiasn();

        $this->cronAsync();
    }

    public function cronSyncSkpSiasn(){
        $this->general->logCron('cronSyncSkpSiasn');
        $this->siasn->cronRiwayatSkpSiasn();
    }

    public function cronUpdateGajiBkad(){
        $this->general->logCron('cronUpdateGajiBkad');
        $this->rekap->cronUpdateGajiBkad();
    }

    public function cronAsync(){
        $this->general->logCron('cronAsync');
        $this->general->cronAsync();
    }

    public function getOauthToken(){
        return dd($this->general->getOauthToken());
    }

    public function getSsoToken(){
        return dd($this->general->getSsoToken());
    }

    public function mappingUnor($percent = 100){
        return $this->general->mappingUnor($percent);
    }

    public function revertMappingUnor($percent){
        return $this->general->revertMappingUnor($percent);
    }

    public function downloadRekapAbsenRequest(){
        $this->general->downloadRekapAbsenRequest();
    }

    public function testWsSiasn($nip){
        $data = $this->siasnlib->getRiwayatSkp22($nip);
        // $data = $this->siasnlib->getJabatanByNip($nip);
        dd($data);
    }

    public function queryInsertTppKelasJabatan(){
        return $this->general->queryInsertTppKelasJabatan();
    }

    public function cekKenegaraan(){
        return $this->user->cekKenegaraan();
    }

    public function cekProgressCuti($id_m_user){
        $insert_id = 0;
        $pegawai = $this->kinerja->getAtasanPegawai(null, $id_m_user, 1);
        $progressCuti = $this->kepegawaian->buildProgressCuti($pegawai, $insert_id, $id_m_user);
        if(isset($progressCuti['code']) && $progressCuti['code'] == 1){
            dd(($progressCuti));
        }
        dd(($progressCuti));
    }
}
