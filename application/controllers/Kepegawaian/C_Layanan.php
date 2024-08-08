<?php

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class C_Layanan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_Layanan', 'layanan');
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('simata/M_Simata', 'simata');
		$this->load->model('siasn/M_Siasn', 'siasn');
		       
		if (!$this->general_library->isNotMenu()) {
			redirect('logout');
		};
	}

	public function kelengkapanBerkas($nip){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['berkas'] = $this->layanan->getKelengkapanBerkas($nip);
		$data['berkas']['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
		$data['berkas']['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiun();
		$this->session->set_userdata('berkas_pensiun', $data);
		// dd($data);
		render('kepegawaian/V_KelengkapanBerkasPensiun', '', '', $data);
	}

	public function loadBerkasPensiun($berkas){
		$temp = $this->session->userdata('berkas_pensiun');
		$data['result'] = $temp['berkas'][$berkas];
		$data['url'] = base_url();
		if($data['result']){
			if($berkas == 'cpns' || $berkas == 'pns'){
				$data['url'] .= "arsipberkaspns/".$data['result']['gambarsk'];
			} else if($berkas == 'skp'){
				$data['url'] .= "arsipskp/".$data['result']['gambarsk'];
			} else if($berkas == 'sk_pangkat') {
				$data['url'] .= "arsipelektronik/".$data['result']['gambarsk'];
			} else if($berkas == 'sk_jabatan') {
				$data['url'] .= "arsipjabatan/".$data['result']['gambarsk'];
			} else {
				$data['url'] .= "arsiplainnya/".$data['result']['gambarsk'];
			}
		}
		$this->load->view('kepegawaian/V_KelengkapanBerkasPensiunShowFile', $data);
	}

}
