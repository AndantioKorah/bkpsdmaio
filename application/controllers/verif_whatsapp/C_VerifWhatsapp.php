<?php

// require 'vendor/autoload.php';

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;

use Endroid\QrCode\QrCode;

// include dirname(__FILE__)."\..\..\libraries\phpqrcode\qrlib.php";

class C_VerifWhatsapp extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
	}

	public function tes($string = ""){
		echo "string: ".$string."<br>"; 
		$encrypt = simpleEncrypt($string);
		echo "encrypt: ".$encrypt."<br>"; 
		echo "decrypt: ".simpleDecrypt($encrypt)."<br>"; 
		// var_dump('asd');
		// renderVerifWhatsapp('verif_whatsapp/V_VerifWhatsapp', '', '', null);
	}

	public function verifWhatsapp($enc_string){
		$data['result'] = $this->kepegawaian->authVerifEncryptCuti($enc_string);
        $data['list_disiplin_kerja'] = $this->general->getAllWithOrder('m_jenis_disiplin_kerja', 'keterangan', 'asc');
		renderVerifWhatsapp('verif_whatsapp/V_VerifWhatsapp', '', '', $data);
	}

	public function surveyKepuasan($enc_string){
		dd(simpleDecrypt($enc_string));
	}

	public function saveVerifikasiPermohonanCuti($status, $id, $kepalapd = 0, $kepalabkpsdm = 0){
		if($status == 1 || $status == 0){
			$data['result'] = $this->kepegawaian->saveVerifikasiPermohonanCuti($status, $id, $kepalapd, $kepalabkpsdm);
		}
		echo json_encode($data['result']);
	}

	public function batalVerifikasiPermohonanCuti($id, $kepalapd = 0, $kepalabkpsdm = 0){
		echo json_encode($this->kepegawaian->batalVerifikasiPermohonanCuti($id, $kepalapd, $kepalabkpsdm));
	}

	public function dsCuti($id){
		echo json_encode($this->kepegawaian->dsCuti($id));
	}

	public function tesSkCuti(){
		$data['data'] = $this->kepegawaian->getDetailCuti();
		$data['data']['ds'] = 1;

		// $filepath = ('assets/new_login/images/generatedQr.png');
		$path_file = 'arsipcuti;CUTI_199502182020121013_2024_03_22_signed.pdf';
		$encUrl = simpleEncrypt($path_file);
		$contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $encUrl)));
		// $content = 'https://presensi.manadokota.go.id/siladen';
		$data['qr'] = generateQr($contentQr);
		
		$this->load->view('kepegawaian/V_SKPermohonanCuti', $data);
	}

	public function qr(){
		$filepath = ('assets/new_login/images/generatedQr.png');

		$logo = (base_url('assets/img/logopemkot.png'));
		$url = 'http://localhost/bkpsdmaio/verifPdf/YXJzaXBjdXRpO0NVVElfMTk5NTAyMTgyMDIwMTIxMDEzXzIwMjRfMDNfMjJfc2lnbmVkLnBkZg';

		$qr = new QrCode();
		$qr->setText($url)
			->setLogoPath('assets/img/logopemkot.png')
			->setLogoWidth(50)
			->setSize(300)
			->setMargin(0)
			->setValidateResult(false)
			->setForegroundColor(['r' => 148, 'g' => 0, 'b' => 0]); 
		echo '<img src='.$qr->writeDataUri().' />';
	}
}
