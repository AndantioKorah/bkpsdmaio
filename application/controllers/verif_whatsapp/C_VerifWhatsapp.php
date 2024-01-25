<?php

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;

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
}
