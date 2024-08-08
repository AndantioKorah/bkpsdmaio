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
		$data['berkas']['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($data['profil_pegawai']['id_peg']); 
		$data['berkas']['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiunAdmin($data['profil_pegawai']['id_peg']);
		$data['nip'] = $nip; 
		$data['id_t_checklist_pensiun'] = $this->layanan->updateChecklistPensiun($nip, $data['berkas'], 1);
		$this->session->set_userdata('berkas_pensiun', $data);
		// dd($data);
		render('kepegawaian/V_KelengkapanBerkasPensiun', '', '', $data);
	}

	public function loadBerkasPensiun($berkas){
		$temp = $this->session->userdata('berkas_pensiun');
		$data['nip'] = $temp['nip'];
		$data['id_t_checklist_pensiun'] = $temp['id_t_checklist_pensiun'];
		$data['result'] = null;

		if($berkas == 'akte_anak'){
			$data['result'] = $temp['berkas'][$berkas];
		} else {
			$data['result'][] = $temp['berkas'][$berkas];
		}
		
		$data['url'] = null;
		$data['jenis_berkas'] = $berkas;
		if($data['result']){
			foreach($data['result'] as $dr){
				if($berkas == 'cpns' || $berkas == 'pns'){
					$data['url'][] = base_url()."arsipberkaspns/".$dr['gambarsk'];
				} else if($berkas == 'skp'){
					$data['url'][] = base_url()."arsipskp/".$dr['gambarsk'];
				} else if($berkas == 'sk_pangkat') {
					$data['url'][] = base_url()."arsipelektronik/".$dr['gambarsk'];
				} else if($berkas == 'sk_jabatan') {
					$data['url'][] = base_url()."arsipjabatan/".$dr['gambarsk'];
				} else {
					$data['url'][] = base_url()."arsiplain/".$dr['gambarsk'];
				}
			}
		}
		$this->load->view('kepegawaian/V_KelengkapanBerkasPensiunShowFile', $data);
	}

	public function validasiBerkas($nip, $berkas, $id){
		echo json_encode($this->layanan->validasiBerkas($nip, $berkas, $id));
	}
}
