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
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
		$data['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiun();
		dd($data);
		render('kepegawaian/V_KelengkapanBerkasPensiun', '', '', $data);
	}

}
