<?php

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class C_Kepegawaian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
		if (!$this->general_library->isNotMenu()) {
			redirect('logout');
		};
	}

	public function autocuti($year){
		$path = 'assets/autocuti/'.$year;
		$files = array_diff(scandir($path), array('.', '..'));
		$i = 0;
		foreach($files as $file){
			$filename = $path.'/'.$file;
			$text = pdf2text($filename);
			$string = trim(preg_replace('!\s+!', ' ', $text));
			$explode = explode(" ", $string);
			$validate = isSuratCutiTahunan($explode); 
			if($validate['result']){
				dd($validate);
			} else {
				dd('alkdmsakdl');
			}
			$i++;
		}
	}

	public function digitalSignature(){
		render('kepegawaian/V_DigitalSignature', null, null, null);
	}

	public function loadDataForDs(){
		$data['jenis_layanan'] = $this->input->post('jenis_layanan');
		$data['result'] = $this->kepegawaian->loadDataForDs($this->input->post());
		$this->load->view('kepegawaian/V_DigitalSignatureData', $data);
	}

	public function loadDetailCutiForDs($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiVerif($id);
		$data['flag_only_see'] = 1;
		$this->load->view('kepegawaian/V_PermohonanCutiDetail', $data);
	}

	public function fetchDokumenWs(){
		$res = $this->dokumenlib->getDokumenWs('POST', $this->input->post());
		$response = json_decode($res['response'], true);
		echo json_encode($response);
	}

	public function loadListPangkat($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getPangkatPegawai($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListPangkat', $data);
	}

	public function loadListSkp($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getSkp($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListSkp', $data);
	}

	public function loadListBerkasPns($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getBerkasPns($nip,$kode);
		// dd($data);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListBerkasPns', $data);
	}


	public function loadListOrganisasi($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getOrganisasi($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListOrganisasi', $data);
	}


	public function loadListAssesment($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getAssesment($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListAssesment', $data);
	}

	public function loadListTimKerja($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getTimKerja($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListTimKerja', $data);
	}

	public function loadListInovasi($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getInovasi($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListInovasi', $data);
	}

	public function loadListKeluarga($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getKeluarga($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListKeluarga', $data);
	}
	

	public function loadListPendidikan($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getPendidikan($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListPendidikan', $data);
	}

	public function loadListDiklat($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getDiklat($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListDiklat', $data);
	}

	
	public function loadListDisiplin($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getDisiplin($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListDisiplin', $data);
	}


	public function loadListJabatan($nip,$kode = null,$statusjabatan){
		
		$data['nip'] = $nip;
		$data['kode'] = $kode;
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		if($statusjabatan == 'def'){
			$data['result'] = $this->kepegawaian->getJabatan($nip,$kode);
			$this->load->view('kepegawaian/V_ListJabatan', $data);
		} else {
			$data['result'] = $this->kepegawaian->getJabatanPlt($nip,$kode);
			$this->load->view('kepegawaian/V_ListJabatanPlt', $data);
		}
		
	}


	public function loadListGajiBerkala($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getGajiBerkala($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListGajiBerkala', $data);
	}

	
	public function loadListPenghargaan($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getPenghargaan($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListPenghargaan', $data);
	}

	public function loadListCuti($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getCuti($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListCuti', $data);
	}

	public function loadListArsip($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getArsip($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListArsip', $data);
	}

	public function loadListSumpahJanji($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getSumpahJanji($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListSumpahJanji', $data);
	}

	public function loadListPelanggaran($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getAllPelanggaranByNip($nip);
		$data['kode'] = $kode;
		$this->load->view('kepegawaian/V_ListPelanggaran', $data);
	}

	public function loadListPenugasan($nip,$kode = null){
		$data['result'] = $this->kepegawaian->getPenugasan($nip,$kode);
		$data['kode'] = $kode;
		$data['nip'] = $nip;
		$this->load->view('kepegawaian/V_ListPenugasan', $data);
	}

	public function uploadDokumenOld(){
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
        $data['dokumen']         	= $this->kepegawaian->getDokumen();
        render('kepegawaian/V_UploadDokumen', '', '', $data);
    }


	public function profil()
	{
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		$data['result'] = $this->kepegawaian->getPendidikan();
		$data['results'] = $this->kepegawaian->getPangkatPegawai();
		// $data['tes'] = $this->general_library->getId();
		// dd($data);
		render('kepegawaian/V_LihatPNS', '', '', $data);
	}


	public function loadListProfil(){
		$data['result'] = $this->kepegawaian->getProfilPegawai();
		$this->load->view('kepegawaian/V_ListProfil', $data);
	}

	// public function loadListBerkala(){
	// 	$data['result'] = $this->kepegawaian->getGajiBerkala();
	// 	$this->load->view('kepegawaian/V_ListGajiBerkala', $data);
	// }



	public function loadDokumenPns()
	{

		// dd($this->general_library->getUserName());

		$cariBy = 1;
		$cariName = $this->general_library->getUserName();
		$unor  = null;

		$data['list_dokumen'] = $this->kepegawaian->get_datatables_lihat_dokumen_pns($cariBy, $cariName, $unor);
		//    var_dump($list);
		//    die();
		$this->load->view('kepegawaian/V_UploadDokumenItem', $data);
	}

	public function getInline()
	{
		$nip       =  $this->input->get('id');
		$file      =  $this->input->get('f');
		$flok      =  base_url() . 'uploads/' . $nip . '/' . $file;
		// var_dump($flok);
		// die();		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/pdf');
		header('Content-Disposition:inline; filename=' . $file);
		header('Expires:0');
		ob_end_clean();
		readfile($flok);
	}

	public function doUpload2()
	{ 
		echo json_encode( $this->kepegawaian->doUpload());
	}

	public function doUploadAssesment()
	{ 
		echo json_encode( $this->kepegawaian->doUploadAssesment());
	}

	public function doUploadTk()
	{ 
		echo json_encode( $this->kepegawaian->doUploadTk());
	}

	public function doUploadInovasi()
	{ 
		echo json_encode( $this->kepegawaian->doUploadInovasi());
	}


	public function doUploadSk()
	{ 
		echo json_encode( $this->kepegawaian->doUploadSk());
	}


	public function doUploadArsipLainnya()
	{ 
		echo json_encode( $this->kepegawaian->doUploadArsipLainnya());
	}

	public function doUpload()
	{

		// dd($_FILES['file']['name']);	
		// validasi NIP
		if (!$this->_isAdaNIP($_FILES['file']['name'])) {
			// $data['error']    = 'Dokumen harus terdapat NIP';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
			// return FALSE;
			$res = array('msg' => 'Hanya bisa upload file gambar', 'success' => false);
			return $res;
		}

		// validasi NIP apakah terdapat nip saya
		if (!$this->_isAdaNIPSaya($_FILES['file']['name'])) {
			$data['error']    = 'Dokumen harus  NIP Saya, cek ulang NIP di nama Dokumen';
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
			return FALSE;
		}
		// dd($_FILES['file']['name']);
		// cek apakah ada dalam daftar arsip

		if (!$this->kepegawaian->isArsip($_FILES['file']['name'])) {

			$data['error']    = 'File ini tidak ada dalam daftar arsip';
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
			return FALSE;
		}


		// cek apakah sudah sesuai format
		if (!$this->kepegawaian->isFormatOK($_FILES['file']['name'])) {

			$data['error']    = 'File ini belum sesuai format';
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
			return FALSE;
		}


		// cek minor tidak ada kode atau tahun
		if (!$this->kepegawaian->isMinorOK($_FILES['file']['name'])) {
			$data['error']    = 'File ini KODE atau TAHUN belum sesuai format';
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
			return FALSE;
		}

		// cek file size apa diperbolehkan		
		$cekFile	= $this->kepegawaian->isAllowSize($_FILES['file']);
		$response   = $cekFile['response'];
		if (!$response) {
			$data['error']    = $cekFile['pesan'];
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
			return FALSE;
		}

		$target_dir						= './uploads/' . $this->_getNip($_FILES['file']['name']);
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		//$config['max_size']             = 2048;
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;

		$this->load->library('upload', $config);

		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777);
		}

		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
		} else {
			$dataFile 			= $this->upload->data();
			$result		        = $this->kepegawaian->insertUpload($dataFile);
			$result['token']    = $this->security->get_csrf_hash();

			if ($result['response']) {
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
			} else {
				$result['updated']  = $this->kepegawaian->updateFile($result);
				$result['error'] 	= 'File ini sudah ada, update file';
				$result['token']    = $this->security->get_csrf_hash();
				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
			}
		}
	}

	public function openDetailDokumen($id, $jd){
		$data['result'] = $this->kepegawaian->openDetailDokumen($id, $jd);
		$data['param']['jenisdokumen'] = $this->session->userdata('list_dokumen_selected');
		// dd($data['param']['jenisdokumen']);
		    if($jd == "jabatan"){
			$data['path'] = 'arsipjabatan/'.$data['result']['gambarsk'];
            } else if($jd == "pangkat"){
				$data['path'] = 'arsipelektronik/'.$data['result']['gambarsk'];
            } else if($jd == "gajiberkala"){
				$data['path'] = 'arsipgjberkala/'.$data['result']['gambarsk'];
            } else if($jd == "pendidikan"){
				$data['path'] = 'arsippendidikan/'.$data['result']['gambarsk'];
            } else if($jd == "diklat"){
				$data['path'] = 'arsipdiklat/'.$data['result']['gambarsk'];
            } else if($jd == "cuti"){
				$data['path'] = 'arsipcuti/'.$data['result']['gambarsk'];
            } else if($jd == "skp"){
				$data['path'] = 'arsipskp/'.$data['result']['gambarsk'];
            } else if($jd == "assesment"){
				$data['path'] = 'arsipassesment/'.$data['result']['gambarsk'];
            } else if($jd == "berkaspns"){
				$data['path'] = 'arsipberkaspns/'.$data['result']['gambarsk'];
            } else if($jd == "arsip"){
				$data['path'] = 'arsiplain/'.$data['result']['gambarsk'];
            } else if($jd == "timkerja"){
				$data['path'] = 'arsiptimkerja/'.$data['result']['gambarsk'];
            }  else if($jd == "sumpahjanji"){
				$data['path'] = 'arsipsumpah/'.$data['result']['gambarsk'];
            } else if($jd == "organisasi"){
				$data['path'] = 'arsiporganisasi/'.$data['result']['gambarsk'];
            } else if($jd == "penghargaan"){
				$data['path'] = 'arsippenghargaan/'.$data['result']['gambarsk'];
            }else if($jd == "inovasi"){
				$data['path'] = 'arsipinovasi/'.$data['result']['gambarsk'];
            }       else {
				$data['path'] = null;
			}
			
		
		$this->load->view('kepegawaian/V_VerifikasiDokumenDetail', $data);
	}

	public function searchDokumenUsul(){
		$data['result'] = $this->kepegawaian->searchDokumenUsul($this->input->post());
		$ld = $this->session->userdata('list_dokumen');
		$jenis_dok = $ld[$this->input->post('jenisdokumen')];
		$data['param'] = $this->input->post();
		$data['param']['jenisdokumen'] = $jenis_dok;
		$this->session->set_userdata('list_dokumen_selected', $jenis_dok);

		$this->load->view('kepegawaian/V_VerifikasiDokumenSearch', $data);
	}

	public function verifikasiDokumen(){
		$data['list_skpd'] = $this->general->getAll('db_pegawai.unitkerja', 0);
		$data['list_dokumen']['pegpangkat']['db'] = 'pegpangkat';
		$data['list_dokumen']['pegpangkat']['nama'] = 'Pangkat';
		$data['list_dokumen']['pegpangkat']['value'] = 'pangkat';

		$data['list_dokumen']['pegjabatan']['db'] = 'pegjabatan';
		$data['list_dokumen']['pegjabatan']['nama'] = 'Jabatan';
		$data['list_dokumen']['pegjabatan']['value'] = 'jabatan';

		$data['list_dokumen']['pegpendidikan']['db'] = 'pegpendidikan';
		$data['list_dokumen']['pegpendidikan']['nama'] = 'Pendidikan';
		$data['list_dokumen']['pegpendidikan']['value'] = 'pendidikan';

		$data['list_dokumen']['peggajiberkala']['db'] = 'peggajiberkala';
		$data['list_dokumen']['peggajiberkala']['nama'] = 'Gajiberkala';
		$data['list_dokumen']['peggajiberkala']['value'] = 'gajiberkala';

		$data['list_dokumen']['pegdiklat']['db'] = 'pegdiklat';
		$data['list_dokumen']['pegdiklat']['nama'] = 'Diklat';
		$data['list_dokumen']['pegdiklat']['value'] = 'diklat';

		$data['list_dokumen']['pegorganisasi']['db'] = 'pegorganisasi';
		$data['list_dokumen']['pegorganisasi']['nama'] = 'Organisasi';
		$data['list_dokumen']['pegorganisasi']['value'] = 'organisasi';

		$data['list_dokumen']['pegpenghargaan']['db'] = 'pegpenghargaan';
		$data['list_dokumen']['pegpenghargaan']['nama'] = 'Penghargaan';
		$data['list_dokumen']['pegpenghargaan']['value'] = 'penghargaan';

		$data['list_dokumen']['pegsumpah']['db'] = 'pegsumpah';
		$data['list_dokumen']['pegsumpah']['nama'] = 'Sumpah / Janji';
		$data['list_dokumen']['pegsumpah']['value'] = 'sumpahjanji';

		$data['list_dokumen']['pegkeluarga']['db'] = 'pegkeluarga';
		$data['list_dokumen']['pegkeluarga']['nama'] = 'Keluarga';
		$data['list_dokumen']['pegkeluarga']['value'] = 'keluarga';

		$data['list_dokumen']['pegdatalain']['db'] = 'pegdatalain';
		$data['list_dokumen']['pegdatalain']['nama'] = 'Penugasan';
		$data['list_dokumen']['pegdatalain']['value'] = 'penugasan';

		$data['list_dokumen']['pegcuti']['db'] = 'pegcuti';
		$data['list_dokumen']['pegcuti']['nama'] = 'Cuti';
		$data['list_dokumen']['pegcuti']['value'] = 'cuti';

		$data['list_dokumen']['pegskp']['db'] = 'pegskp';
		$data['list_dokumen']['pegskp']['nama'] = 'SKP';
		$data['list_dokumen']['pegskp']['value'] = 'skp';

		$data['list_dokumen']['pegassesment']['db'] = 'pegassesment';
		$data['list_dokumen']['pegassesment']['nama'] = 'Assesment';
		$data['list_dokumen']['pegassesment']['value'] = 'assesment';


		$data['list_dokumen']['pegarsip']['db'] = 'pegarsip';
		$data['list_dokumen']['pegarsip']['nama'] = 'Arsip Lainnya';
		$data['list_dokumen']['pegarsip']['value'] = 'arsip';

		$data['list_dokumen']['pegberkaspns']['db'] = 'pegberkaspns';
		$data['list_dokumen']['pegberkaspns']['nama'] = 'SK CPNS & PNS';
		$data['list_dokumen']['pegberkaspns']['value'] = 'berkaspns';

		$data['list_dokumen']['pegtimkerja']['db'] = 'pegtimkerja';
		$data['list_dokumen']['pegtimkerja']['nama'] = 'Tim Kerja';
		$data['list_dokumen']['pegtimkerja']['value'] = 'timkerja';

		$data['list_dokumen']['peginovasi']['db'] = 'peginovasi';
		$data['list_dokumen']['peginovasi']['nama'] = 'Inovasi';
		$data['list_dokumen']['peginovasi']['value'] = 'inovasi';

		
		$this->session->set_userdata('list_dokumen', $data['list_dokumen']);
        render('kepegawaian/V_VerifikasiDokumen', '', '', $data);
	}

	function _extract_numbers($string)
	{
		preg_match_all('/([\d]+)/', $string, $match);
		return $match[0];
	}
	
	public function profilPegawai($nip){
		if(!$this->general_library->isProgrammer() 
		&& !$this->general_library->isAdminAplikasi() 
		&& !$this->general_library->isHakAkses('akses_profil_pegawai') ){
			$this->session->set_userdata('apps_error', 'Anda tidak memiliki Hak Akses untuk menggunakan Menu tersebut');
			redirect('welcome');
		} else {
		    $data['bidang'] = null;
			$data['page'] = null;
		    $data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
			$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
			$data['nip'] = $nip;
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
			$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
			$data['status_kawin'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuskawin', 'id_sk', 'asc');
			$data['status_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuspeg', 'id_statuspeg', 'asc');
			$data['jenis_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispeg', 'id_jenispeg', 'asc');
			$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
			$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
			$data['pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'asc');
			$data['pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
			$data['satyalencana'] = $this->kepegawaian->getDataSatyalencanaPegawai($nip);
			// dd($data['profil_pegawai']);
			render('kepegawaian/V_ProfilPegawai', '', '', $data);
		}
	}

	public function uploadDokumen($page = null){
		
        // $this->kepegawaian->copyfoto();
		
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
		$data['page'] = $page;
        $data['dokumen']         	= $this->kepegawaian->getDokumen();
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
		$data['status_kawin'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuskawin', 'id_sk', 'asc');
		$data['status_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuspeg', 'id_statuspeg', 'asc');
		$data['jenis_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispeg', 'id_jenispeg', 'asc');
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'asc');
		$data['pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
		$data['kabkota'] = $this->kepegawaian->getAllWithOrder('db_efort.m_kabupaten_kota', 'id', 'asc');
		$data['bidang'] = $this->kepegawaian->getBidang($this->general_library->getId());
		$data['nip'] = $this->general_library->getUserName();
		$data['mbidang'] = $this->kepegawaian->getMasterBidang($data['profil_pegawai']['skpd']);
        render('kepegawaian/V_ProfilPegawai', '', '', $data);
    }

	

	// public function LoadFormDokPangkat($jenis_user,$nip=null){
	// 	$data['result'] = $this->kepegawaian->getPendidikan();
	// 	$data['results'] = $this->kepegawaian->getPangkatPegawai();
    //     render('kepegawaian/V_UploadDokumenNew', '', '', $data);
    // }

	public function LoadFormDokPenugasan($nip){
		
		$data['nip'] = $nip;
        // $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja($tahun,$bulan);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'penugasan');

		$data['jenis_penugasan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenistugas', 'id_jenistugas', 'desc');
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadPenugasan', $data);
    }

	public function LoadFormDokPangkat($nip){
        // $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja($tahun,$bulan);
		$data['jenis_pengangkatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispengangkatan', 'id_jenispengangkatan', 'desc');
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 4);
		$data['pdm_pangkat'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'pangkat');
		$data['nip'] = $nip;
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegpangkat', $id_peg );
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
			
		}
		
		
        $this->load->view('kepegawaian/V_FormUploadPangkat', $data);
    }

	public function LoadFormGajiBerkala($nip){
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 7);
		$data['pdm_gajiberkala'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'kgb');
		$data['nip'] = $nip;
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadGajiBerkala', $data);
    }

	public function LoadFormPendidikan($nip){
		// $data['list_tingkat_pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
		// $data['list_tingkat_pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikanb', 'id_tktpendidikanb', 'asc');
		$data['list_tingkat_pendidikan'] = $this->kepegawaian->getTingkatPendidikan();
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 6);
		$data['pdm_pendidikan'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'ijazah');

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadPendidikan', $data);
    }

	public function LoadFormJabatan($nip,$statusjab){
		$data['nip'] = $nip;
		$data['jenis_jabatan'] = $this->kepegawaian->getJenisJabatan();
		$data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'jabatan');
		$data['statusjabatan'] = $statusjab;
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegjabatan', $id_peg );
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadJabatan', $data);
    }

	public function LoadFormJabatanPlt($nip){
		$data['nip'] = $nip;
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'jabatan');

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadJabatanPlt', $data);
    }

	public function LoadFormDiklat($nip){
		$data['jenis_diklat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.diklat', 'id_diklat', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 20);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'diklat');
		$data['nip'] = $nip;
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadDiklat', $data);
    }

	public function LoadFormOrganisasi($nip){
		$data['nip'] = $nip;
		$data['jenis_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.organisasi', 'no_urut', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 48);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'organisasi');
		$data['lingkup_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.lingkup_organisasi', 'id', 'asc');
		// $data['jabatan_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jabatan_organisasi', 'id', 'asc');
		$data['jabatan_organisasi'] = $this->kepegawaian->getJabatanOrganisasi();

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadOrganisasi', $data);
    }

	public function LoadFormPenghargaan($nip){
		$data['nip'] = $nip;
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'penghargaan');
		$data['pemberi'] = $this->kepegawaian->getPemberiPenghargaan();
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 49);
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadPenghargaan', $data);
    }

	public function loadFormSkp($nip){
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 5);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'skp_tahunan');
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegskp', $id_peg );
	
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadSkp', $data);
    }

	public function loadFormBerkasPns($nip){
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 2);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'cpns_pns');
		
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegberkaspns', $id_peg );
	
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
		} else {
			
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadBerkasPns', $data);
    }

	
	public function loadFormDisiplin($nip){
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 18);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'disiplin');
		
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		// $data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegdisiplin', $id_peg );
		$data['hd'] = $this->kepegawaian->getAllWithOrder('db_pegawai.hd', 'idk', 'asc');
		$data['jhd'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jhd', 'id_jhd', 'asc');
	
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
		} else {
			
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadDisiplin', $data);
    }

	public function loadFormAssesment($nip){
		$data['nip'] = $nip;
		// $data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 5);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'assesment');

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadAssesment', $data);
    }

	public function loadFormKeluarga($nip){
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 5);
		$data['hubungan_keluarga'] = $this->kepegawaian->getAllWithOrder('db_pegawai.keluarga', 'id_keluarga', 'asc');
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'keluarga');

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadKeluarga', $data);
    }

	public function LoadFormCuti($nip){
		$data['nip'] = $nip;
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 17);
		$data['jenis_cuti'] = $this->kepegawaian->getAllWithOrder('db_pegawai.cuti', 'id_cuti', 'asc');
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'cuti');

		
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadCuti', $data);
    }

	public function LoadFormSumpahJanji($nip){
		$data['nip'] = $nip;
		$data['jenis_sumpah'] = $this->kepegawaian->getAllWithOrder('db_pegawai.sumpah', 'id_sumpah', 'asc');
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'sumpah_janji');

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadSumpahJanji', $data);
    }

	public function loadFormPelanggaran($nip){
		$data['list_pelanggaran'] = $this->kepegawaian->getAllPelanggaranByNip($nip);
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadPelanggaran', $data);
	}

	public function LoadFormArsip($nip){
		$data['nip'] = $nip;
		$data['jenis_arsip'] = $this->kepegawaian->getJenisArsip();
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'data_lainnya');

		
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadArsipLainnya', $data);
    }




	public function layanan(){
		$data['jenis_layanan'] = $this->kepegawaian->getJenisLayanan();
        render('kepegawaian/V_Layanan', '', '', $data);
    }


	public function insertUsulLayanan()
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayanan());
	}

	public function loadListUsulLayanan(){
		// dd($jenis_layanan);
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['result'] = $this->kepegawaian->getListUsulLayanan($id_peg);
		// dd($data['result']);
		$this->load->view('kepegawaian/V_ListUsulLayanan', $data);
	}

	public function Adminlayanan(){
		$data['result'] = $this->kepegawaian->getAllUsulLayanan();
        render('kepegawaian/V_AllUsulLayanan', '', '', $data);
    }

	public function CetakSurat($id_usul,$jenis_layanan){
		// $this->load->library('pdf');
		$data['result'] = $this->kepegawaian->getDataUsulLayanan($id_usul,$jenis_layanan);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$this->load->view('kepegawaian/surat/V_SuratHukdis', $data);
  			

		$this->load->library('pdfgenerator');
        
        // filename dari pdf ketika didownload
        $file_pdf = "surat_cuti_".$data['result'][0]['nip'];
        // setting paper
        $paper = 'F4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
		$paper = array(0,0,645,990);
        
		if($jenis_layanan == 3){
			$html = $this->load->view('kepegawaian/surat/V_SuratCuti',$data, true);	    	
		}
		if($jenis_layanan == 8){
			$html = $this->load->view('kepegawaian/surat/V_SuratHukdis',$data, true);	    	
		}
        
        
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);


    }


	public function CetakSuratPidana($id_usul,$jenis_layanan){
		// $this->load->library('pdf');
		$data['result'] = $this->kepegawaian->getDataUsulLayanan($id_usul,$jenis_layanan);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$this->load->view('kepegawaian/surat/V_SuratPidana', $data);
  			

		$this->load->library('pdfgenerator');
        
        // filename dari pdf ketika didownload
        $file_pdf = "surat_cuti_".$data['result'][0]['nip'];
        // setting paper
        $paper = 'F4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

		$paper = array(0,0,645,990);
        
		if($jenis_layanan == 3){
			$html = $this->load->view('kepegawaian/surat/V_SuratCuti',$data, true);	    	
		}
		if($jenis_layanan == 8){
			$html = $this->load->view('kepegawaian/surat/V_SuratPidana',$data, true);	    	
		}
        
        
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);


    }


	public function verifikasiLayanan($id_usul,$jenis_layanan){
		$data['result'] = $this->kepegawaian->getDataUsulLayanan($id_usul,$jenis_layanan);
		// dd($data['result']);
		$data['pangkat'] = array(1,3,7,10,12,13,15,16,17,20);
		$data['gaji_berkala'] =  array(1);
		$data['pendidikan'] = array(7,10,12,14,15,16);
		$data['jabatan'] = array(3,15,16,17,20);
		$data['diklat'] = array(14);
		$data['organisasi'] = array(0);
		$data['penghargaan'] = array(0);
		$data['sj'] = array(0);
		$data['keluarga'] = array(0);
		$data['penugasan'] = array(0);
		$data['cuti'] = array(0);
		$data['skpns'] = array(7,8,9,12,13,14,15,16);
		$data['skcpns'] = array(7,10,12,13,14,15,16);
		$data['skp'] = array(7,9,14,15,16,17,20);
		$data['drp'] = array(7);
		$data['honor'] = array(7);
		$data['suket_lain'] = array(7);
		$data['ibel'] = array(10,15,16);
		$data['forlap'] = array(10);
		$data['karya_tulis'] = array(10,15,16);
		$data['tubel'] = array(15,16,20);
		$data['mutasi'] = array(17);
		$data['serkom'] = array(17);
		$data['pak'] = array(17,20);
		$data['jenis_layanan'] = $jenis_layanan;
		if($jenis_layanan == 3){
			$data['folder'] = "cuti";
		} else if($jenis_layanan){
			$data['folder'] = "perbaikan_data";
		}
		
	

		render('kepegawaian/V_Verifikasi_Layanan', '', '', $data);
	}

	public function openPresensiTab($id){
		$data['id_pegawai'] = $id;
		$this->load->view('kepegawaian/V_VerifikasiLayananPresensi', $data);
	}
	
	public function getDataPresensiPegawai($id)
	{
		$data['result'] = $this->general_library->getPaguTppPegawaiByIdPegawai($id, $this->input->post('bulan'), $this->input->post('tahun'));
		$data['result']['param']['bulan'] = $this->input->post('bulan');
		$data['result']['param']['tahun'] = $this->input->post('tahun');
        return $this->load->view('kepegawaian/V_DetailAbsensiPegawai', $data);
		// $this->load->view('kepegawaian/V_DetailPresensiPegawai', $data);
	}

	public function loadFormLayanan($id){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();

		if($id == 3){
		$data['jenis_cuti'] = $this->kepegawaian->getAllWithOrder('db_siladen.m_cuti', 'id_cuti', 'asc');
		$this->load->view('kepegawaian/form_layanan/V_FormCuti', $data);
		} else {
			$data['jenis_layanan'] = $id;
			$this->load->view('kepegawaian/form_layanan/V_FormUsulLayanan', $data);
		}
    }

	public function getFile()
    {
        $data = $this->kepegawaian->getFile();
		// dd($data);
        echo json_encode($data);
    }

	public function deleteUsulLayanan($id){
        $this->general->delete('id_usul', $id, 'db_siladen.usul_layanan');
    }


	public function getAllUsulLayananAdmin($id){
		$data['result'] = $this->kepegawaian->getAllUsulLayananAdmin($id);
		// dd($data);
		$this->load->view('kepegawaian/V_LayananItem', $data);
	}

	public function submitVerifikasiLayanan()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiLayanan());
	}


	

	public function batalVerifikasiLayanan()
	{ 
		echo json_encode( $this->kepegawaian->batalVerifikasiLayanan());
	}

	public function submitNomorTglSurat()
	{ 
		echo json_encode( $this->kepegawaian->submitNomorTglSurat());
	}


	public function getNomorTanggalSurat()
    {
        $data = $this->kepegawaian->getNomorTanggalSurat();
        echo json_encode($data);
    }

	public function getDataJabatan($id_unitkerja)
    {
        $searchTerm = $this->input->post('searchTerm');
        $response   = $this->kepegawaian->getDataJabatan($id_unitkerja, $searchTerm);
        echo json_encode($response);
    }

	public function deleteData($id,$table,$file = null)
    {
        $this->kepegawaian->delete('id', $id, "db_pegawai.".$table,$file);
    }

	public function submitVerifikasiDokumen()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiDokumen());
	}

	public function batalSubmitVerifikasiDokumen()
	{ 
		echo json_encode( $this->kepegawaian->batalSubmitVerifikasiDokumen());
	}

	public function getDetailLayanan()
    {
        $data = $this->kepegawaian->getDetailLayanan();
        echo json_encode($data);
    }

	public function submitEditProfil()
	{ 
		echo json_encode( $this->kepegawaian->submitEditProfil());
	}

	public function updateStatusBerkas()
	{ 
		echo json_encode( $this->kepegawaian->updateStatusBerkas());
	}

	// public function deleteData(){
    //     $photo = $_FILES['profilePict']['name'];
	// 	$nip = $this->input->post('nip');
    //     $upload = $this->general_library->uploadImageAdmin('fotopeg','profilePict',$nip);
	
    //     if($upload['code'] != 0){
    //         $this->session->set_flashdata('message', $upload['message']);
    //     } else {
    //         $message = $this->kepegawaian->updateProfilePicture($upload);
    //         $this->session->set_flashdata('message', $message['message']);
    //     }

	// 	if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
    //     redirect('kepegawaian/profil-pegawai/'.$nip);
	// 	} else {
	// 	redirect('kepegawaian/profil');
	// 	}

    // }

	public function updateJabatanPeg()
	{ 
		echo json_encode( $this->kepegawaian->updateJabatanPeg());
	}


	public function LoadFormTambahPegawai(){
		// dd($nip);
		$data['jenis_pengangkatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispengangkatan', 'id_jenispengangkatan', 'desc');
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['status_kawin'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuskawin', 'id_sk', 'asc');
		$data['status_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuspeg', 'id_statuspeg', 'asc');
		$data['jenis_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispeg', 'id_jenispeg', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'asc');
		$data['pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
		$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
		
		render('kepegawaian/V_FormTambahPegawai', '', '', $data);
        // $this->load->view('kepegawaian/V_FormTambahPegawai', $data);
    }

	public function tambahPegawai()
	{ 
		echo json_encode( $this->kepegawaian->tambahPegawai());
	}

	public function loadEditProfilPegawai($id)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($id);
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
		$data['status_kawin'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuskawin', 'id_sk', 'asc');
		$data['status_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuspeg', 'id_statuspeg', 'asc');
		$data['jenis_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispeg', 'id_jenispeg', 'asc');
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['list_status_pegawai'] = $this->kepegawaian->getAllWithOrder('m_status_pegawai', 'id', 'asc');
		$data['pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'asc');
		$data['pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
		$data['kabkota'] = $this->kepegawaian->getKabKota('db_efort.m_kabupaten_kota', 'id', 'asc');
		$data['nip'] = $this->general_library->getUserName();
		$data['bidang'] = $this->kepegawaian->getBidang($data['profil_pegawai']['id_m_user']);
		$data['mbidang'] = $this->kepegawaian->getMasterBidang($data['profil_pegawai']['skpd']);

        $this->load->view('kepegawaian/V_EditProfilPegawai', $data);
    }

	public function getJenjangDiklat()
    {
        $id = $this->input->post('id');
        $response   = $this->kepegawaian->getJenjangDiklat($id);
        echo json_encode($response);
    }


	public function getdatakec()
    {
        $id_kab = $this->input->post('id');
        $response   = $this->kepegawaian->getkec($id_kab);
        echo json_encode($response);
    }

	public function getdatajab()
    {
        
        $response   = $this->kepegawaian->getdatajab();
        echo json_encode($response);
    }


	
	public function getdatakel()
    {
        $id_kec = $this->input->post('id');
        $response   = $this->kepegawaian->getkel($id_kec);
        echo json_encode($response);
    }

	public function LoadFormTimKerja($nip){
		$data['nip'] = $nip;
		// $data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 5);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'tim_kerja');
		$data['lingkup_tim'] = $this->kepegawaian->getLingkupTimKerja();
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadTimKerja', $data);
    }

	public function LoadFormInovasi($nip){
		$data['nip'] = $nip;
		// $data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 5);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'inovasi');
		$data['kriteria_inovasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.inovasi', 'id', 'asc');
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai')){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadInovasi', $data);
    }

	
	public function loadEditJabatanPegawai($id)
    {
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$data['jabatan'] = $this->kepegawaian->getJabatanPegawaiEdit($id);
		// dd($data['jabatan']);
		$data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEdit();
		// dd($data['nama_jabatan']);
        $this->load->view('kepegawaian/V_EditJabatan', $data);
    }


	public function loadEditPangkaPegawai($id)
    {
		$data['jenis_pengangkatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispengangkatan', 'id_jenispengangkatan', 'desc');
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 4);
		$data['pdm_pangkat'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'pangkat');
		$data['pangkat'] = $this->kepegawaian->getPangkatPegawaiEdit($id);
        // dd($data['pangkat']);
        $this->load->view('kepegawaian/V_EditPangkat', $data);
    }

	public function loadEditGajiBerkala($id)
    {
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 4);
		$data['berkala'] = $this->kepegawaian->getGajiBerkalaEdit($id);
        // dd($data['pangkat']);
        $this->load->view('kepegawaian/V_EditGajiBerkala', $data);
    }

	public function loadEditArsipLain($id)
    {
		$data['arsip'] = $this->kepegawaian->getArsipLainEdit($id);
        $this->load->view('kepegawaian/V_EditArsipLain', $data);
    }

	public function loadEditPendidikan($id)
    {
		$data['list_tingkat_pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikanb', 'id_tktpendidikanb', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 6);
		$data['pendidikan'] = $this->kepegawaian->getPendidikanEdit($id);
        // dd($data['pangkat']);
        $this->load->view('kepegawaian/V_EditPendidikan', $data);
    }

	public function loadEditCuti($id)
    {
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 17);
		$data['jenis_cuti'] = $this->kepegawaian->getAllWithOrder('db_pegawai.cuti', 'id_cuti', 'asc');
		$data['cuti'] = $this->kepegawaian->getCutiEdit($id);
        // dd($data['pangkat']);
        $this->load->view('kepegawaian/V_EditCuti', $data);
    }

	public function loadEditDiklat($id)
    {
		$data['jenis_diklat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.diklat', 'id_diklat', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 20);
		$data['diklat'] = $this->kepegawaian->getDiklatEdit($id);
		$data['jenjang_diklat'] = $this->kepegawaian->getJenjangDiklatEdit($data['diklat'][0]['jenisdiklat']);
        $this->load->view('kepegawaian/V_EditDiklat', $data);
    }

	public function loadEditDisiplin($id)
    {
		$data['hd'] = $this->kepegawaian->getAllWithOrder('db_pegawai.hd', 'idk', 'asc');
		$data['jhd'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jhd', 'id_jhd', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 18);
		$data['disiplin'] = $this->kepegawaian->getDisiplinEdit($id);
        $this->load->view('kepegawaian/V_EditDisiplin', $data);
    }

	public function loadEditOrganisasi($id)
    {
		$data['jenis_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.organisasi', 'no_urut', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 48);
		$data['lingkup_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.lingkup_organisasi', 'id', 'asc');
		$data['jabatan_organisasi'] = $this->kepegawaian->getJabatanOrganisasi();
		$data['organisasi'] = $this->kepegawaian->getOrganisasiEdit($id);
       
		$this->load->view('kepegawaian/V_EditOrganisasi', $data);
    }

	public function loadEditPenghargaan($id)
    {
		$data['pemberi'] = $this->kepegawaian->getPemberiPenghargaan();
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 49);
		$data['penghargaan'] = $this->kepegawaian->getPenghargaanEdit($id);
		$this->load->view('kepegawaian/V_EditPenghargaan', $data);
    }

	public function loadEditSumjan($id)
    {
		$data['jenis_sumpah'] = $this->kepegawaian->getAllWithOrder('db_pegawai.sumpah', 'id_sumpah', 'asc');
		$data['sumjan'] = $this->kepegawaian->getSumpahJanjiEdit($id);
		$this->load->view('kepegawaian/V_EditSumjan', $data);
    }

	public function permohonanCuti(){
		$data['sisa_cuti'] = $this->kepegawaian->getSisaCuti();
		$data['master_jenis_cuti'] = $this->general->getAllWithOrderGeneral('db_pegawai.cuti', 'id_cuti', 'asc');
        render('kepegawaian/V_PermohonanCuti', '', '', $data);
	}

	public function submitPermohonanCuti(){
		echo json_encode($this->kepegawaian->submitPermohonanCuti());
	}

	public function countJumlahHariCuti(){
		$data = $this->input->post();
		$res['code'] = 0;
		$res['message'] = 'OK';
		$res['data'] = countHariKerjaDateToDate($data['tanggal_mulai'], $data['tanggal_akhir']);
		echo json_encode($res);
	}

	public function loadRiwayatPermohonanCuti(){
		$data['result'] = $this->kepegawaian->loadRiwayatPermohonanCuti();
		$this->session->set_userdata('riwayat_cuti', $data['result']);
		$this->load->view('kepegawaian/V_PermohonanCutiItem', $data);
	}

	public function loadDetailCuti($id){
		$data['result'] = $this->session->userdata('riwayat_cuti')[$id];
		$this->load->view('kepegawaian/V_PermohonanCutiDetail', $data);
	}

	public function deletePermohonanCuti($id){
		$this->kepegawaian->deletePermohonanCuti($id);
		// $this->general->delete('id', $id, 't_pengajuan_cuti');
	}

	public function verifikasiPermohonanCuti(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
		$data['master_status'] = $this->general->getAllWithOrder('m_status_pengajuan_cuti', 'id', 'asc');
        render('kepegawaian/V_VerifPermohonanCuti', '', '', $data);
	}

	public function searchPermohonanCuti(){
		$data['result'] = $this->kepegawaian->searchPermohonanCuti();
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/V_VerifPermohonanCutiItem', $data);
	}

	public function loadDetailCutiVerif($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiVerif($id);
        $data['list_disiplin_kerja'] = $this->general->getAllWithOrder('m_jenis_disiplin_kerja', 'keterangan', 'asc');
		$count = (count($data['list_disiplin_kerja']));
		$tambahan = ["TK", "TMK1", "TMK2", "TMK3", "PKSW1", "PKSW2", "PKSW3"];
		$tambahan = [
			0 => [
				'keterangan' => 'tmk1',
				'nama_jenis_disiplin_kerja' => 'Terlambat Masuk Kerja kategori 1'
			],
			1 => [
				'keterangan' => 'tmk2',
				'nama_jenis_disiplin_kerja' => 'Terlambat Masuk Kerja kategori 2'
			],
			2 => [
				'keterangan' => 'tmk3',
				'nama_jenis_disiplin_kerja' => 'Terlambat Masuk Kerja kategori 3'
			],
			3 => [
				'keterangan' => 'pksw1',
				'nama_jenis_disiplin_kerja' => 'Pulang Kerja Sebelum Wakti kategori 1'
			],
			4 => [
				'keterangan' => 'pksw2',
				'nama_jenis_disiplin_kerja' => 'Pulang Kerja Sebelum Wakti kategori 2'
			],
			5 => [
				'keterangan' => 'pksw3',
				'nama_jenis_disiplin_kerja' => 'Pulang Kerja Sebelum Wakti kategori 3'
			],
		];

		foreach($tambahan as $t){
			$data['list_disiplin_kerja'][$count] = $t;
			$count++;
		}
		$this->load->view('kepegawaian/V_VerifPermohonanCutiDetail', $data);
	}

	public function saveVerifikasiPermohonanCuti($status, $id){
		$data['result'] = null;
		if($status == 1 || $status == 0){
			$data['result'] = $this->kepegawaian->saveVerifikasiPermohonanCuti($status, $id);
		}
		// if($data['result']['code'] == 0 && $data['result']['data']['id_m_status_pengajuan_cuti'] == 2 && $status == 1){
		// 	$path_file = 'arsipcuti/nods/CUTI_'.$data['result']['data']['nipbaru_ws'].'_'.date("Y", strtotime($data['result']['data']['created_date'])).'.pdf';
		// 	// dd($path_file);
		// 	$mpdf = new \Mpdf\Mpdf([
		// 		'format' => 'Legal-P',
		// 		// 'debug' => true
		// 	]);
		// 	$html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $data, true);
		// 	$mpdf->WriteHTML($html);
		// 	$mpdf->showImageErrors = true;
		// 	$mpdf->Output($path_file, 'F');
		// }
		
		echo json_encode($data['result']);
	}

	public function loadAuthModalTte($id){
		$data['user'] = $this->general->getDataPegawai($this->general_library->getUserName());
		$data['id'] = $id;
		$this->load->view('kepegawaian/V_ModalAuthTte', $data);
	}

	public function loadAuthModalTteBulk(){
		$data['user'] = $this->general->getDataPegawai($this->general_library->getUserName());
		$this->load->view('kepegawaian/V_ModalAuthTteBulk', $data);
	}

	public function dsCuti($id){
		echo json_encode($this->kepegawaian->dsCuti($id));
	}

	public function dsBulk(){
		echo json_encode($this->kepegawaian->dsBulk($this->input->post()));
		// dd($this->input->post());
	}

	public function batalVerifikasiPermohonanCuti($id){
		echo json_encode($this->kepegawaian->batalVerifikasiPermohonanCuti($id));
	}

	public function nomorSurat(){
		$data['jenis_layanan'] = $this->general->getAllWithOrder('m_jenis_layanan', 'nomor_surat', 'asc');
        render('kepegawaian/V_NomorSurat', '', '', $data);
	}

	public function saveNomorSurat(){
		echo json_encode($this->kepegawaian->saveNomorSurat());
	}

	public function loadNomorSurat(){
		$data['result'] = $this->kepegawaian->loadNomorSurat();
		$this->load->view('kepegawaian/V_NomorSuratRiwayat', $data);
	}

	public function submitEditJabatan()
	{ 
		echo json_encode($this->kepegawaian->submitEditJabatan());
	}
	
	public function submitEditPangkat()
	{ 
		echo json_encode($this->kepegawaian->submitEditPangkat());
	}

	public function submitEditBerkala()
	{ 
		echo json_encode($this->kepegawaian->submitEditBerkala());
	}

	public function submitEditPendidikan()
	{ 
		echo json_encode($this->kepegawaian->submitEditPendidikan());
	}

	public function submitEditCuti()
	{ 
		echo json_encode($this->kepegawaian->submitEditCuti());
	}

	public function submitEditDiklat()
	{ 
		echo json_encode($this->kepegawaian->submitEditDiklat());
	}

	public function submitEditOrganisasi()
	{ 
		echo json_encode($this->kepegawaian->submitEditOrganisasi());
	}

	public function submitEditPenghargaan()
	{ 
		echo json_encode($this->kepegawaian->submitEditPenghargaan());
	}

	public function submitEditSumjan()
	{ 
		echo json_encode($this->kepegawaian->submitEditSumjan());
	}

	public function submitEditArsipLain()
	{ 
		echo json_encode($this->kepegawaian->submitEditArsipLain());
	}

	public function loadDataDrh($nip){
		$data['result'] = $this->kepegawaian->loadDataDrh($nip);
		$this->load->view('kepegawaian/V_DrhPegawai', $data);
	}
	public function getMasterSubBidang()
    {
        $id = $this->input->post('id');
        $response   = $this->kepegawaian->getMasterSubBidang($id);
        echo json_encode($response);
    }

	public function submiDataBidang(){
     $this->kepegawaian->submiDataBidang();
	 redirect('kepegawaian/profil');
    }

	public function submiDataBidang2(){
		$this->kepegawaian->submiDataBidang();
		redirect('welcome');
	}


	public function updateProfilePict(){
        $photo = $_FILES['profilePict']['name'];
        $upload = $this->general_library->uploadImage('fotopeg','profilePict');
		$upload['nip'] = $this->input->post('nip');
        if($upload['code'] != 0){
            $this->session->set_flashdata('message', $upload['message']);
        } else {
            $message = $this->kepegawaian->updateProfilePicture($upload);
            $this->session->set_flashdata('message', $message['message']);
        }
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
        redirect('kepegawaian/profil-pegawai/'.$this->input->post('nip'));
        } else {
		redirect('kepegawaian/profil');
		}

    }
	



	








}
