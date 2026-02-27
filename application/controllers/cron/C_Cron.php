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
        $this->cronSyncBangkomPerData();
        // $this->general->logCron('cronSendWa');
        // $this->general->cronSendWa();
        // dd('asdd');
        // echo date('d-m-Y H:i:s')." asd \n";
    }

    public function cronDsBulkTte(){
        // $this->cronCheckDataBangkom();

        // $this->general->logCron('cronDsBulkTte');
		// $this->layanan->cronBulkDs();
	}

    public function updateSisaCuti($id, $operand){
		$this->kepegawaian->updateSisaCuti($id, $operand);
	}

    public function cronTestSyncJabatan(){
        // $this->siasn->cronSyncJabatanSiasn();
    }

    public function cronSyncJabatanSiasn(){
        $this->general->logCron('cronSyncJabatanSiasn');
        // $this->siasn->cronRiwayatJabatanSiasn();
        $this->siasn->cronSyncJabatanSiasn();
    }

    public function cronCheckBangkom(){
        $this->general->cronCheckBangkom();
        $this->general->logCron('cronCheckBangkom');
    }

    public function cronCheckDataBangkom($nip = ""){
        $this->general->cronCheckDataBangkom($nip);
        $this->general->logCron('cronCheckDataBangkom');
    }

    public function removeLog($batasHari = 30){
        $this->general->removeLog($batasHari);
    }

    public function cronCheckVerifCuti(){
        $this->cronCheckBangkom();
        // $this->general->cronCheckVerifCuti();
    }

    public function cronJafungCpns(){
        $this->user->cronJafungCpns();
        $this->general->logCron('cronJafungCpns');
    }

    public function cronHashFileBangkom(){
        $this->user->cronHashFileBangkom();
        $this->general->logCron('cronHashFileBangkom');
    }

    public function cronSyncBangkomPerDataDownload(){
        $this->siasn->cronSyncBangkomPerDataDownload();
        $this->general->logCron('cronSyncBangkomPerDataDownload');
    }

    public function cronSyncBangkomPerData(){
        $this->siasn->cronSyncBangkomPerData();
        $this->general->logCron('cronSyncBangkomPerData');
    }

    public function cronSyncSkpSiasn(){
        $this->cronHashFileBangkom();
        $this->cronSyncBangkom();
        // $this->general->logCron('cronSyncSkpSiasn');
        // $this->siasn->cronRiwayatSkpSiasn();
    }

    public function cronSyncBangkom(){
        $this->general->logCron('cronSyncBangkom');
        $this->siasn->cronSyncBangkom();
    }

    public function cronSyncBangkomToSiasn(){
        $this->general->logCron('cronSyncBangkomToSiasn');
        $this->siasn->cronSyncBangkomToSiasn();
    }

    public function addDataForSyncBangkom(){
        $this->siasn->addDataForSyncBangkom();
    }

    public function cronUpdateGajiBkad(){
        $this->general->logCron('cronUpdateGajiBkad');
        $this->rekap->cronUpdateGajiBkad();

        $this->cronSyncBangkomToSiasn();
    }

    public function cronAsync(){
        $this->general->logCron('cronAsync');
        $this->general->cronAsync();

        // $this->rekap->rekapKehadiranPeriodik();
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
        // $data = $this->siasnlib->getRiwayatSkp22($nip);
        // $data = $this->siasnlib->getJabatanByNip($nip);
        $data = $this->siasnlib->getDataUtamaPnsByNip($nip);
        dd($data);
    }

    public function queryInsertTppKelasJabatan(){
        return $this->general->queryInsertTppKelasJabatan();
    }

    public function cekKenegaraan(){
        return $this->user->cekKenegaraan();
        // return $this->user->cekKenegaraanCustom();
    }

    public function cekSidak(){
        return $this->general->cekSidak();
        // return $this->user->cekKenegaraanCustom();
    }

    public function inputSertiBkpsdmBacirita(){
        return $this->user->inputSertiBkpsdmBacirita();
        // return $this->user->cekKenegaraanCustom();
    }

    public function cekProgressCuti($nip, $flagFixProgress = 0){
        $insert_id = 0;
        $peg = $this->general->getOne('m_user', 'username', $nip, 1);
        $pegawai = $this->kinerja->getAtasanPegawai(null, $peg['id'], 1);
        // dd($pegawai);
        $progressCuti = $this->kepegawaian->buildProgressCuti($pegawai, $insert_id, $peg['id']);
        // if(isset($progressCuti['code']) && $progressCuti['code'] == 1){
        //     dd(($progressCuti));
        // }
        if($flagFixProgress == 1){
            $this->kepegawaian->flagFixProgress($progressCuti, $nip);
        }
        dd(($progressCuti));
    }

    public function fixProgressCutiDinkes($nip = null){
        $this->kepegawaian->fixProgressCutiDinkes($nip);
    }

    public function fixProgressCutiDinkesWNip(){
        $this->kepegawaian->fixProgressCutiDinkesWNip();
    }

    public function createQr(){
        $content = "https://drive.google.com/drive/folders/1tDKJgd4_OFD5Nbhio9-phzA9zL_TlG2F";
		$data = $this->general_library->createQrTtePortrait(null, null, $content);
		echo "<img src='data:image/png;base64, ".$data['data']['qrBase64']."' />";
	}

    public function getPengadaanInstansiWs($tahun = 0){
        if($tahun == 0){
            $tahun = date('Y');
        }
        return $this->general->getListPengadaan($tahun);
    }

    public function addUserCpns(){
        return $this->user->addUserCpns();
    }

    public function addGelarUserCpns(){
        return $this->user->addGelarUserCpns();
    }

    public function addFileSkJabatanCpns(){
        return $this->user->addFileSkJabatanCpns();
    }

    public function addFileSpmtCpns(){
        return $this->user->addFileSpmtCpns();
    }

    public function addFileSkPPPK(){
        return $this->user->addFileSkPPPK();
    }

    public function updateJabatanPegBaru(){
        return $this->user->updateJabatanPegBaru();
    }

    public function cekUnor(){
        return $this->user->cekUnor();
    }

    public function cekHariKerja($tanggal_awal, $tanggal_akhir){
        $hariKerja = countHariKerjaDateToDate($tanggal_awal, $tanggal_akhir);
        dd($hariKerja);
    }

    public function cekMaxDateUpload($tgl, $max, $operand){
        dd(countMaxDateUpload(formatDateOnlyForEdit($tgl), 3, "plus"));
    }

    public function getDataUtamaPnsByNip($nip){
        $res = $this->siasnlib->getDataUtamaPnsByNip($nip);
        dd(json_decode($res['data'], true));
    }

    public function syncUnor(){
        $this->general->syncUnor();
    } 

    public function manageDokpen($bulan, $tahun){
        $this->kinerja->manageDokpen($bulan, $tahun);
    }

    public function deleteBackuppedDokpen($bulan, $tahun){
        $this->kinerja->deleteBackuppedDokpen($bulan, $tahun);
    }

    public function customManageDokpen(){
        $this->kinerja->customManageDokpen();
    }

    public function syncDataUtamaPns(){
        $this->siasn->syncDataUtamaPns();
    }

    public function updateDataPPPK($nip = 0, $flag_save = 0){
        $data['result'] = $this->general->updateDataPPPK($nip, $flag_save);
        $this->load->view('master/V_TempUpdateDataPPPK', $data);
    }

    public function rekapKehadiranPeriodik($bulan = 0, $tahun = 0){
        $this->rekap->rekapKehadiranPeriodik();
    }

    public function funcTest($str = ""){
        phpinfo();
        $this->user->rekapCutiDesember();

        // $this->kepegawaian->cekErrorCuti();

        dd($this->kepegawaian->getProgressCutiAktif(2637));

        // dd($this->general_library->getDataKabanBkpsdm());
        // $randomString = generateRandomString(30, 1, 't_file_ds'); 
        // $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
        $contentQr = "https://docs.google.com/spreadsheets/d/1ksMYI1i0duXJOQCb46yIB-RmSK-CDNf5oQRvpsOYjDo/edit?gid=0#gid=0";
        $res['qr'] = generateQr($contentQr);
        echo "<img style='width: 300px; height: 300px;' src='".$res['qr']."'></img>";
        // $this->load->view('adminkit/partials/V_TemplateTte', $res);

        // dd(generateRandomString(16));

        // $date = date("Y-m-d H:i:s");
        // $nip = "199502182020121013";
        // $publickKey = "AARS_251016378";
        // $secretKey = "mb8V34s8xtxqEFVP";
        // $string = $date.";".$secretKey;

        // $encrypted = AESEncrypt($string, $publickKey, $secretKey);
        // dd("token: ".$encrypted);
        // dd(AESDecrypt($encrypted, $secretKey));
    }

    public function testNomorSurat($data = null){
        $data['jenis_layanan'] = isset($data['jenis_layanan']) ? $data['jenis_layanan'] : 104;
        $data['tahun'] = isset($data['tahun']) ? $data['tahun'] : date('Y');
        $data['perihal'] = isset($data['perihal']) ? $data['perihal'] : "";
        dd(getNomorSuratSiladen($data, 0));
    }

    public function hapusKenegaraan(){
        $this->user->hapusKenegaraan();
    }
}
