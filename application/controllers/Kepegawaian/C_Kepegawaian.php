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
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('simata/M_Simata', 'simata');
		$this->load->model('siasn/M_Siasn', 'siasn');
		       
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
		// $data['list'] = $this->general->getAllWithOrder('m_jenis_ds', 'nama_jenis_ds', 'asc');
		$data['list'] = $this->general->getAllWithOrder('m_jenis_layanan', 'nama_layanan', 'asc');
		render('kepegawaian/V_DigitalSignature', null, null, $data);
	}

	public function loadDataForDs(){
		$data['jenis_layanan'] = $this->input->post('jenis_layanan');
		$data['result'] = $this->kepegawaian->loadDataForDs($this->input->post());
		$this->load->view('kepegawaian/V_DigitalSignatureData', $data);
	}

	public function loadDetailCutiForDs($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiVerif($id);
		$data['progress'] = $this->kepegawaian->loadProgressCuti($id);
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

	public function doUploadKeluarga()
	{ 
		echo json_encode( $this->kepegawaian->doUploadKeluarga());
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
		// dd($jd);
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
            } else if($jd == "penugasan"){
				$data['path'] = 'arsippenugasan/'.$data['result']['gambarsk'];
            } else if($jd == "keluarga"){
				$data['file'] = $data['result']['gambarsk'];
				$data['path'] = 'arsipkeluarga/'.$data['result']['gambarsk'];
            }         else {
				$data['path'] = null;
			}
			$data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
			
			
		
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
		$data['list_eselon'] = $this->general->getAll('db_pegawai.eselon', 0);
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
		&& !$this->general_library->isHakAkses('akses_profil_pegawai')
		&& !$this->general_library->isKasubagKepegawaianDiknas()){
			$this->session->set_userdata('apps_error', 'Anda tidak memiliki Hak Akses untuk menggunakan Menu tersebut');
			redirect('welcome');
		} else {
		    $data['bidang'] = null;
			$data['page'] = null;

			$id_peg = $this->general_library->getIDPegawaiByNip($nip);
			// $this->kepegawaian->updatePangkat($id_peg['id_peg']);
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
			// dd($data['profil_pegawai']['id_peg']);
			
			render('kepegawaian/V_ProfilPegawai', '', '', $data);
		}
	}

	public function changeFlagSertifikasi($status, $nip){
		$this->kepegawaian->changeFlagSertifikasi($status, $nip);
	}

	public function changeFlagBerakala($status, $nip){
		$this->kepegawaian->changeFlagBerakala($status, $nip);
	}

	public function uploadDokumen($page = null){
		
        // $this->kepegawaian->copyfoto();
		
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
		$id_peg = $this->general_library->getIDPegawaiByNip($this->general_library->getUserName());
		$this->kepegawaian->updatePangkat($id_peg['id_peg']);
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
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
		$data['unor_siasn'] = $this->general->getAllWithOrderGeneral('db_siasn.m_ref_unor', 'nama_unor', 'asc');
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
		$data['sinkronSiasn'] = $this->kepegawaian->getDataSinkronWsSiasn('t_cron_sync_jabatan_siasn', $data['profil_pegawai']['id_m_user']);

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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}

		$data['sinkronSiasn'] = $this->kepegawaian->getDataSinkronWsSiasn('t_cron_sync_skp_siasn', $data['profil_pegawai']['id_m_user']);
        
		$this->load->view('kepegawaian/V_FormUploadSkp', $data);
    }

	public function loadFormBerkasPns($nip){
		$data['nip'] = $nip;
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 2);
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'cpns_pns');
		
		$id_peg = $this->general->getIdPeg($this->general_library->getUserName());
		$data['dok'] = $this->kepegawaian->getDataDok('db_pegawai.pegberkaspns', $id_peg );
	
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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
	
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

		
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_FormUploadArsipLainnya', $data);
    }



	public function LoadViewTalenta($nip){
		$data['nip'] = $nip;
		$data['jenis_arsip'] = $this->kepegawaian->getJenisArsip();
		$data['pdm'] = $this->kepegawaian->getDataPdmBerkas('t_pdm', 'id', 'desc', 'data_lainnya');

		
		if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('akses_profil_pegawai') || isKasubKepegawaian($this->general_library->getNamaJabatan())){
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($nip);
			
		} else {
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		}
        $this->load->view('kepegawaian/V_ProfilTalenta', $data);
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
		$data['result'] = $this->kepegawaian->getAllUsulLayananOld();
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
		// $paper = array(0,0,645,990);
		$paper = array(0,0,645,820);

        
		if($jenis_layanan == 3){
			// $html = $this->load->view('kepegawaian/surat/V_SuratCuti',$data, true);	
			$html = $this->load->view('kepegawaian/surat/V_SuratPidana',$data, true);	    	
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
        $file_pdf = "surat_pidana_".$data['result'][0]['nip'];
        // setting paper
        // $paper = 'F4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

		$paper = array(0,0,645,820);
        
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
		$this->load->view('kepegawaian/layanan/V_FormCuti', $data);
		} else {
			$data['jenis_layanan'] = $id;
			$this->load->view('kepegawaian/layanan/V_FormUsulLayanan', $data);
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

	public function deletePengajuanKarisKarsu($id){
        $this->general->delete('id', $id, 't_layanan');
    }

	public function deletePengajuanPensiun($id){
        $this->general->delete('id', $id, 't_pensiun');
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

	public function updateTmBerkala()
	{ 
		echo json_encode( $this->kepegawaian->updateTmBerkala());
	}

	public function updateTmBerkalaPPPK()
	{ 
		echo json_encode( $this->kepegawaian->updateTmBerkalaPPPK());
	}

	public function mergeBerkala()
	{ 
		echo json_encode( $this->kepegawaian->mergeBerkala());
	}
	
	public function updateJenisKelamin()
	{ 
		echo json_encode( $this->kepegawaian->updateJenisKelamin());
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

	public function checkListIjazahCpns($id, $id_pegawai)
    {
        echo json_encode($this->kepegawaian->checkListIjazahCpns($id, $id_pegawai));
    }

	public function checkListIjazahSP($id, $id_pegawai)
    {
        echo json_encode($this->kepegawaian->checkListIjazahSP($id, $id_pegawai));
    }
	public function checkListIjazahP($id, $id_pegawai)
    {
        echo json_encode($this->kepegawaian->checkListIjazahP($id, $id_pegawai));
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

	public function getJenisHd()
    {
        $id = $this->input->post('id');
        $response   = $this->kepegawaian->getJenisHd($id);
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
		// $data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['jenis_jabatan'] = $this->kepegawaian->getJenisJabatan();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['unor_siasn'] = $this->general->getAllWithOrderGeneral('db_siasn.m_ref_unor', 'nama_unor', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$data['jabatan'] = $this->kepegawaian->getJabatanPegawaiEdit($id);
		$data['jabatan_siasn'] = null;
		$data['list_jabatan_siasn'] = null;
		$jenis_jabatan = 'JFU';
		// dd($data['jabatan'][0]['unitkerja_id']);
		if($data['jabatan']) {
			$data['jabatan_siasn'] = json_decode($data['jabatan'][0]['meta_data_siasn'], true);
			$jenis_jabatan = $data['jabatan'][0]['jenis_jabatan'];
			if($data['jabatan'][0]['jenis_jabatan'] == "JFT") {
				$data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEditJFT();
			} else if($data['jabatan'][0]['jenis_jabatan'] == "Struktural") {
				$data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEditStruktural($data['jabatan'][0]['unitkerja_id']);
			} else {
				$data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEditPelaksana($data['jabatan'][0]['unitkerja_id']);
			}
	    } else {
		$data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEditPelaksana($data['jabatan'][0]['unitkerja_id']);
		}
		// $data['nama_jabatan'] = $this->kepegawaian->getSelectJabatanEdit();
		$data['list_jabatan_siasn'] = $this->kepegawaian->getListJabatanSiasn($jenis_jabatan);
		
		// dd($data['nama_jabatan']);
        $this->load->view('kepegawaian/V_EditJabatan', $data);
    }

	public function tesUploadDokumenRiwayat(){
		$this->kepegawaian->tesUploadDokumenRiwayat();
	}

	public function syncSiasnJabatan($id){
		echo json_encode($this->kepegawaian->syncSiasnJabatan($id));
	}

	public function loadListJabatanSiasn($id){
		echo null;
		// echo json_encode($this->kepegawaian->getListJabatanSiasn($id));
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

	public function loadEditSkp($id)
    {
		// $data['pemberi'] = $this->kepegawaian->getPemberiPenghargaan();
		// $data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 49);
		$data['skp'] = $this->kepegawaian->getSkpEdit($id);
		$this->load->view('kepegawaian/V_EditSkp', $data);
    }

	public function loadEditSumjan($id)
    {
		$data['jenis_sumpah'] = $this->kepegawaian->getAllWithOrder('db_pegawai.sumpah', 'id_sumpah', 'asc');
		$data['sumjan'] = $this->kepegawaian->getSumpahJanjiEdit($id);
		$this->load->view('kepegawaian/V_EditSumjan', $data);
    }

	public function loadEditTimKerja($id)
    {
		$data['lingkup_tim'] = $this->kepegawaian->getLingkupTimKerja();
		$data['timkerja'] = $this->kepegawaian->getTimKerjaEdit($id);
		$this->load->view('kepegawaian/V_EditTimKerja', $data);
    }

	public function loadEditKeluarga($id)
    {
		$data['hubungan_keluarga'] = $this->kepegawaian->getAllWithOrder('db_pegawai.keluarga', 'id_keluarga', 'asc');
		$data['keluarga'] = $this->kepegawaian->getKeluargaEdit($id);
		$this->load->view('kepegawaian/V_EditKeluarga', $data);
    }

	public function permohonanCuti(){
		$data['sisa_cuti'] = $this->kepegawaian->getSisaCuti();
		
		$id_m_user = $this->general_library->getId();
		$data['atasan'] = $this->kinerja->getAtasanPegawai(null, $id_m_user);
		
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

		$explTanggalMulai = explode("-", $data['tanggal_mulai']);
		$explTanggalAkhir = explode("-", $data['tanggal_akhir']);

		$tanggalMulai = $explTanggalMulai[2].'-'.$explTanggalMulai[1].'-'.$explTanggalMulai[0];
		$tanggalAkhir = $explTanggalAkhir[2].'-'.$explTanggalAkhir[1].'-'.$explTanggalAkhir[0];

		// $res['data'] = countHariKerjaDateToDate($tanggalMulai, $tanggalAkhir);
		$res['data'] = countHariKerjaDateToDate($data['tanggal_mulai'], $data['tanggal_akhir']);
		// dd(json_encode($res));
		echo json_encode($res);
	}

	public function loadRiwayatPermohonanCuti(){
		$data['result'] = $this->kepegawaian->loadRiwayatPermohonanCuti();
		$this->session->set_userdata('riwayat_cuti', $data['result']);
		$this->load->view('kepegawaian/V_PermohonanCutiItem', $data);
	}

	public function getProgressCutiAktif($id){
		return $this->kepegawaian->getProgressCutiAktif($id);
	}

	public function loadDetailCuti($id){
		$data['result'] = $this->session->userdata('riwayat_cuti')[$id];
		$data['progress'] = $this->kepegawaian->loadProgressCuti($id);
		$data['flag_only_see'] = 0;
		$this->load->view('kepegawaian/V_PermohonanCutiDetail', $data);
	}

	public function penomoranSkCuti(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        render('kepegawaian/V_PenomoranSkCuti', '', '', $data);
	}

	public function searchPenomoranSkCuti(){
		$data['result'] = $this->kepegawaian->searchPenomoranSkCuti($this->input->post());
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/V_PenomoranSkCutiData', $data);
	}

	public function downloadAllSkCutiNew(){
		// $data = $this->input->post();
		$data = $this->session->userdata('data_penomoranskcuti');

		$filenames = null;
		foreach($data as $d){
			if($d['flag_ds_manual'] == 0){
				$filenames[] = $d['url_sk'];
			} else {
				$filenames[] = $d['url_sk_manual'];
			}
		}
		$zip = new ZipArchive;
		$zipname = "siladen/SK_PERMOHONANCUTI_".date('ymdhis').".zip";
		$zip->open($zipname, ZipArchive::OVERWRITE || ZipArchive::CREATE);
		// dd($zip);
		foreach ($filenames as $file) {
			$expl = explode("/", $file);
			$fileName = trim($expl[1]);

			$fileContent = file_get_contents($file);
			$zip->addFromString($fileName, $fileContent);
		}
		$zip->close();

		header('location: /'.($zipname));

		// unlink("siladen/".$zipname);
	}

	public function downloadAllSkCuti(){
		$data = $this->input->post();
		$decodedData = json_decode($data['filenames'], true);

		$zip = new ZipArchive;
		$zipname = "SK_PERMOHONANCUTI_".date('ymdhis').".zip";
		$zip->open($zipname, ZipArchive::CREATE);
		// dd($zip);
		foreach ($decodedData as $file) {
			$expl = explode("/", $file);
			$fileName = trim($expl[1]);

			$fileContent = file_get_contents($file);
			$zip->addFromString($fileName, $fileContent);
		}
		$zip->close();

		header('location: /'."siladen/".($zipname));

		// unlink("siladen/".$zipname);
	}

	public function openModalPenomoranSkCuti($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiForPenomoranSkCuti($id);
		$this->load->view('kepegawaian/V_PenomoranSkCutiDetail', $data);
	}
	
	public function saveUploadFileDsPenomoranSkCuti($id){
        echo json_encode($this->kepegawaian->saveUploadFileDsPenomoranSkCuti($id));
	}

	public function deleteFileDsManual($id){
        echo json_encode($this->kepegawaian->deleteFileDsManual($id));
	}

	public function deletePermohonanCuti($id){
		$this->kepegawaian->deletePermohonanCuti($id);
		// $this->general->delete('id', $id, 't_pengajuan_cuti');
	}

	public function deleteOperatorPermohonanCuti($id){
		$this->kepegawaian->deleteOperatorPermohonanCuti($id);
		// $this->general->delete('id', $id, 't_pengajuan_cuti');
	}

	public function verifikasiOperatorPermohonanCuti(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        render('kepegawaian/V_VerifOperatorPermohonanCuti', '', '', $data);
	}

	public function searchOperatorPermohonanCuti(){
		$data['result'] = $this->kepegawaian->searchOperatorPermohonanCuti();
		// $data['sisa_cuti'] = $this->kepegawaian->getSisaCuti();
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/V_VerifOperatorPermohonanCutiItem', $data);
	}

	public function verifikasiPermohonanCuti(){
		// $data['unitkerja'] = $this->general->getGroupUnitKerja($this->general_library->getIdUnitKerjaPegawai());
		$data['unitkerja'] = null;
		// if($this->general_library->isKepalaBkpsdm() 
        // 	|| $this->general_library->isAdminAplikasi() 
        //     || $this->general_library->isHakAkses('verifikasi_permohonan_cuti') 
        //     || $this->general_library->isProgrammer()){
			$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
		// }
        render('kepegawaian/V_VerifPermohonanCuti', '', '', $data);
	}

	public function updateSisaCuti($id, $operand){
		$this->kepegawaian->updateSisaCuti($id, $operand);
	}

	public function searchPermohonanCuti(){
		$data['result'] = $this->kepegawaian->searchPermohonanCuti();
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/V_VerifPermohonanCutiItem', $data);
	}

	public function saveNohpVerifikatorCuti($id){
		echo json_encode($this->kepegawaian->saveNohpVerifikatorCuti($id));
	}

	public function loadDetailStatusPengajuanCuti($id){
		$data['progress'] = $this->kepegawaian->getProgressCutiAktif($id);
		$this->load->view('kepegawaian/V_DetailStatusPermohonanCuti', $data);
	}

	public function resendMessage($id){
		echo json_encode($this->kepegawaian->resendMessage($id));
	}

	public function loadDetailCutiVerifOperator($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiVerifOperator($id);
		$data['sisa_cuti'] = $this->kepegawaian->getSisaCuti($data['result']['id_m_user']);
		$this->load->view('kepegawaian/V_VerifOperatorPermohonanCutiDetail', $data);
	}

	public function submitVerifOperatorCuti($status){
		echo json_encode($this->kepegawaian->submitVerifOperatorCuti($status));
	}

	public function loadDetailCutiVerif($id){
		$data['result'] = $this->kepegawaian->loadDetailCutiVerif($id);
		$data['progress'] = $this->kepegawaian->loadProgressCuti($id);
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

	public function cronDsBulkTte(){
		$this->kepegawaian->cronDsBulkTte();
	}

	public function loadBatchDs(){
		$data['result'] = $this->kepegawaian->loadBatchDs();
		$this->load->view('kepegawaian/V_DataProgressBatch', $data);
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

	public function saveNomorSuratManual($id, $flagGenerateNomorSurat = 0){
		echo json_encode($this->kepegawaian->saveNomorSuratManual($id, "t_checklist_pensiun", $flagGenerateNomorSurat));
	}

	public function saveNomorSuratManualSkCuti($id, $flagGenerateNomorSurat = 0){
		echo json_encode($this->kepegawaian->saveNomorSuratManual($id, "t_pengajuan_cuti", $flagGenerateNomorSurat));
	}

	public function deleteNomorSuratManual($id){
		echo json_encode($this->kepegawaian->deleteNomorSuratManual($id));
	}

	public function deleteNomorSuratManualSkCuti($id){
		echo json_encode($this->kepegawaian->deleteNomorSuratManual($id, "t_pengajuan_cuti"));
	}

	public function loadNomorSurat(){
		$data['result'] = $this->kepegawaian->loadNomorSurat();
		$this->load->view('kepegawaian/V_NomorSuratRiwayat', $data);
	}

	public function loadListFileInputManualNomorSurat(){
		$data['result'] = $this->kepegawaian->loadListFileInputManualNomorSurat();
		$this->load->view('kepegawaian/V_NomorSuratInputManual', $data);
	}

	public function openModalNomorSuratManual($id){
		$data['result'] = $this->kepegawaian->loadListFileInputManualNomorSuratById($id);
		$this->load->view('kepegawaian/V_NomorSuratManualModal', $data);
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

	public function submitEditDisiplin()
	{ 
		echo json_encode($this->kepegawaian->submitEditDisiplin());
	}

	public function submitEditOrganisasi()
	{ 
		echo json_encode($this->kepegawaian->submitEditOrganisasi());
	}

	public function submitEditPenghargaan()
	{ 
		echo json_encode($this->kepegawaian->submitEditPenghargaan());
	}

	public function submitEditSkp()
	{ 
		echo json_encode($this->kepegawaian->submitEditSkp());
	}

	public function submitEditSumjan()
	{ 
		echo json_encode($this->kepegawaian->submitEditSumjan());
	}

	public function submitEditTimKerja()
	{ 
		echo json_encode($this->kepegawaian->submitEditTimKerja());
	}

	public function submitEditKeluarga()
	{ 
		echo json_encode($this->kepegawaian->submitEditKeluarga());
	}

	public function submitEditArsipLain()
	{ 
		echo json_encode($this->kepegawaian->submitEditArsipLain());
	}

	public function loadDataDrh($nip){
		$data['result'] = $this->kepegawaian->loadDataDrh($nip);
		$this->load->view('kepegawaian/V_DrhPegawai', $data);
	}

	public function loadDataDrhSatyalencana($nip){
		$data['result'] = $this->kepegawaian->loadDataDrhSatyalencana($nip);
		$data['atasan_pegawai'] = $this->kepegawaian->getDataAtasanPegawai($nip);
		// dd($data['atasan_pegawai']);
		// $data['result'] = $this->kepegawaian->getProfilPegawai($nip);
		
		$this->load->view('kepegawaian/V_DrhPegawaiSatyalencana', $data);
	}

	public function downloadDrhSatyalencana($nip){
		$data['result'] = $this->kepegawaian->loadDataDrhSatyalencana($nip);
		$data['atasan_pegawai'] = $this->kepegawaian->getDataAtasanPegawai($nip);	

		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );
	
		$html = $this->load->view('kepegawaian/V_DrhPegawaiSatyalencana', $data, true); 
		// dd($html);
		$file_pdf = "DRH_SL_".$nip;  	
		
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($file_pdf.'.pdf','d');
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

	public function LayananKarisKarsu(){
		$data['daftar_keluarga'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','58','0');
		$data['akte_nikah'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','24','0');
		$data['pas_foto'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','53','0');
		$data['laporan_perkawinan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','52','0');
		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
		// dd($data);
		$this->load->view('kepegawaian/layanan/V_KarisKarsu', $data);
		// render('kepegawaian/layanan/V_KarisKarsu', '', '', $data);
	}

	public function lakukan_download(){                                                          
		$this->load->helper(array('url','download'));
		force_download('./dokumen_layanan/FORMAT RENCANA TAHUNAN KEBUTUHAN PENGEMBANGAN DIRI.pdf',NULL);
	}  
	
	public function insertUsulLayananKarisKarsu($id_m_layanan)
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayananKarisKarsu($id_m_layanan));
	}

	public function insertUsulLayananPensiun()
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayananPensiun());
	}

	public function loadListRiwayatKarisKarsu(){
		$data['result'] = $this->kepegawaian->getRiwayatKarisKarsu();
		// dd($data);
		$this->load->view('kepegawaian/layanan/V_KarisKarsuItem', $data);
	}

	public function loadListRiwayatPensiun($jenis_pensiun){
		$data['result'] = $this->kepegawaian->loadListRiwayatPensiun($jenis_pensiun);
		// dd($data);
		$this->load->view('kepegawaian/layanan/V_LayananPensiunItem', $data);
	}

	public function verifikasiKarisKarsu(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
		render('kepegawaian/layanan/V_VerfikasiKarisKarsu', '', '', $data);
	}

	public function verifikasiPensiun(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
		render('kepegawaian/layanan/V_VerfikasiPensiun', '', '', $data);
	}


	public function searchPengajuanKarisKarsu(){
		$data['result'] = $this->kepegawaian->searchPengajuanKarisKarsu();
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/layanan/V_VerfikasiKarisKarsuItem', $data);
	}


	public function searchPengajuanPensiun(){
		$data['result'] = $this->kepegawaian->searchPengajuanPensiun();
		$data['param'] = $this->input->post();
		$this->load->view('kepegawaian/layanan/V_VerfikasiPensiunItem', $data);
	}

	public function verifikasiKarisKarsuDetail($id){
		$data['result'] = $this->kepegawaian->getPengajuanLayananKarisKarsu($id);
		render('kepegawaian/layanan/V_VerfikasiKarisKarsuDetail', '', '', $data);
	}

	public function verifikasiPenisunDetail($id,$jenis_pensiun){
		$data['result'] = $this->kepegawaian->getPengajuanLayananPensiun($id);
		$id_peg = $data['result'][0]['id_peg'];
		$data['jenis_layanan'] = $jenis_pensiun;

		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','1',$id_peg);
		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','2',$id_peg);        
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($id_peg); 
		$data['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiunAdmin($id_peg); 
		$data['akte_nikah'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','24','0',$id_peg);
		$data['hd'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','18','0',$id_peg);
		$data['pidana'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','19','0',$id_peg);
		$data['dpcp'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','30','0',$id_peg);
		$data['pmk'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','29','0',$id_peg);
		$data['skp'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegskp','29','0',$id_peg);
		$data['surat_ket_kematian'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','56','0',$id_peg);
		$data['surat_laporan_kronologis'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','57','0',$id_peg);
		$data['aktecerai'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','25','0',$id_peg);
		$data['aktekematian'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','26','0',$id_peg);
		$data['akteanak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','58','0',$id_peg);
		$data['kk'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','28','0',$id_peg);
		$data['ktp'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','37','0',$id_peg);
		$data['jandaduda'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','59','0',$id_peg);
		$data['spt'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','60','0',$id_peg);
		$data['surat_berhenti'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','61','0',$id_peg);
		$data['surat_rekom_sakit'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','62','0',$id_peg);
		$data['visum'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','63','0',$id_peg);
		$data['berita_acara'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','64','0',$id_peg);
		$data['npwp'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','38','0',$id_peg);
		$data['buku_rekening'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','39','0',$id_peg);


		$data['list_layanan_skcpns'] = array(22,1,2,3,4,5);
		$data['list_layanan_skpns'] = array(22,1,2,3,4,5);
		$data['list_layanan_skpangak'] = array(22,1,2,3,4,5);
		$data['list_layanan_skjabatan'] = array(22,1,2,3,4);
		$data['list_layanan_aktenikah'] = array(22,1,2,3,4,5);
		$data['list_layanan_hd'] = array(1,2,3,4,5);
		$data['list_layanan_pidana'] = array(1,2,3,4,5);
		$data['list_layanan_dpcp'] = array(1,2,3,4,5);
		$data['list_layanan_pmk'] = array(22,1,2,3,4);
		$data['list_layanan_skp'] = array(22,1,2,3,4);
		$data['list_layanan_surat_ket_kematian'] = array(5);
		$data['list_layanan_surat_laporan_kronologis'] = array(5);
		$data['list_layanan_aktercerai'] = array(22,1,2,3,4,5);
		$data['list_layanan_aktekematian'] = array(22,1,2,3,4,5);
		$data['list_layanan_akteanak'] = array(22,1,2,3,4,5);
		$data['list_layanan_kk'] = array(22,1,2,3,4,5);
		$data['list_layanan_ket_janda_duda'] = array(22,2,5);
		$data['list_layanan_spt'] = array(5);
		$data['list_layanan_visum'] = array(5);
		$data['list_layanan_berita_acara'] = array(5);
		$data['list_layanan_ktp'] = array(22,1,2,3,4,5);
		$data['list_layanan_npwp'] = array(22,1,2,3,4,5);
		$data['list_layanan_buku_rek'] = array(22,1,2,3,4,5);
		$data['list_layanan_surat_rekom_sakit'] = array(4);
		$data['list_layanan_surat_berhenti'] = array(3,4);
		
		if($jenis_pensiun == 7){
		$data['nama_layanan'] = "BUP";
		} else if($jenis_pensiun == 2){
		$data['nama_layanan'] = "JANDA/DUDA";
		} else if($jenis_pensiun == 3){
		$data['nama_layanan'] = "ATAS PERMINTAAN SENDIRI";
		} else if($jenis_pensiun == 4){
		$data['nama_layanan'] = "SAKIT/UZUR";
		} else if($jenis_pensiun == 5){
		$data['nama_layanan'] = "TEWAS	";
		}

		// $this->load->view('kepegawaian/layanan/V_VerfikasiKarisKarsuDetail', $data);
		render('kepegawaian/layanan/V_VerfikasiPensiunDetail', '', '', $data);
	}

	public function getFileForKarisKarsu()
    {
        $data = $this->kepegawaian->getFileForKarisKarsu();
		// dd($data);
        echo json_encode($data);
    }

	public function submitVerifikasiPengajuanKarisKarsu()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiPengajuanKarisKarsu());
	}

	public function batalVerifikasiPengajuanKarisKarsu()
	{ 
		echo json_encode( $this->kepegawaian->batalVerifikasiPengajuanKarisKarsu());
	}

	public function submitVerifikasiPengajuanPensiun()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiPengajuanPensiun());
	}

	public function batalVerifikasiPengajuanPensiun()
	{ 
		echo json_encode( $this->kepegawaian->batalVerifikasiPengajuanPensiun());
	}

	public function LayananPensiun($jenis_layanan){
		$data['jenis_layanan'] = $jenis_layanan;
		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
		$data['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiun(); 
		// $data['akte_nikah'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','24','0');
		$data['akte_nikah'] = $this->kepegawaian->getDokumenAkteNikahForPensiun();
		$data['hd'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','18','0');
		$data['pidana'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','19','0');
		$data['dpcp'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','30','0');
		$data['pmk'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','29','0');
		$data['skp'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegskp','29','0');
		$data['surat_ket_kematian'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','56','0');
		$data['surat_laporan_kronologis'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','57','0');
		$data['aktecerai'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','25','0');
		$data['aktekematian'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','26','0');
		// $data['akteanak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','58','0');
		$data['akteanak'] = $this->kepegawaian->getDokumenAkteAnakForPensiun();
		$data['kk'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','28','0');
		$data['ktp'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','37','0');
		$data['jandaduda'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','59','0');
		$data['spt'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','60','0');
		$data['surat_berhenti'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','61','0');
		$data['surat_rekom_sakit'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','62','0');
		$data['visum'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','63','0');
		$data['berita_acara'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','64','0');
		$data['npwp'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','38','0');
		$data['buku_rekening'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','39','0');

		$data['list_layanan_skcpns'] = array(22,17,2,3,4,5);
		$data['list_layanan_skpns'] = array(22,17,2,3,5,5);
		$data['list_layanan_skpangak'] = array(22,17,2,3,4,5);
		$data['list_layanan_skjabatan'] = array(22,17,2,3,4);
		$data['list_layanan_aktenikah'] = array(22,17,2,3,4,5);
		$data['list_layanan_hd'] = array(2,4,5);
		$data['list_layanan_pidana'] = array(2,4,5);
		$data['list_layanan_dpcp'] = array(2,4,5);
		$data['list_layanan_pmk'] = array(22,17,2,3,4);
		$data['list_layanan_skp'] = array(22,17,2,3,4);
		$data['list_layanan_surat_ket_kematian'] = array(5);
		$data['list_layanan_surat_laporan_kronologis'] = array(5);
		$data['list_layanan_aktercerai'] = array(22,17,2,3,4,5);
		$data['list_layanan_aktekematian'] = array(22,17,2,3,4,5);
		$data['list_layanan_akteanak'] = array(22,17,2,3,4,5);
		$data['list_layanan_kk'] = array(22,17,2,3,4,5);
		$data['list_layanan_ket_janda_duda'] = array(22,2,5);
		$data['list_layanan_spt'] = array(5);
		$data['list_layanan_visum'] = array(5);
		$data['list_layanan_berita_acara'] = array(5);
		$data['list_layanan_ktp'] = array(22,17,2,3,4,5);
		$data['list_layanan_npwp'] = array(22,17,2,3,4,5);
		$data['list_layanan_buku_rek'] = array(22,17,2,3,4,5);
		$data['list_layanan_surat_rekom_sakit'] = array(4);
		$data['list_layanan_surat_berhenti'] = array(3,4);
		
		if($jenis_layanan == 17){
		$data['nama_layanan'] = "BUP";
		} else if($jenis_layanan == 2){
		$data['nama_layanan'] = "JANDA/DUDA";
		} else if($jenis_layanan == 3){
		$data['nama_layanan'] = "ATAS PERMINTAAN SENDIRI";
		} else if($jenis_layanan == 4){
		$data['nama_layanan'] = "SAKIT/UZUR";
		} else if($jenis_layanan == 5){
		$data['nama_layanan'] = "TEWAS";
		} else if($jenis_layanan == 22){
		$data['nama_layanan'] = "Meninggal";
		}
		// $data['dokumen_layanan'] = $this->kepegawaian->getDokumenLayanan($jenis_layanan);

		$this->load->view('kepegawaian/layanan/V_LayananPensiun', $data);
		// render('kepegawaian/layanan/V_LayananPensiun', '', '', $data);
	}

	public function getFileLayanan()
    {
        $data = $this->kepegawaian->getFileLayanan();
		// dd($data);
        echo json_encode($data);
    }


	public function profilPegawaiForKasub($id_peg){

			$getNip = $this->general_library->getIdPegawai($id_peg);
			// dd($getNip['nipbaru_ws']);
		    $nip = $getNip[0]['nipbaru_ws'];
		
		    $data['bidang'] = null;
			$data['page'] = null;
		    $data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
			$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
			$data['nip'] = $nip;
			$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiForKasub($nip);
			$data['agama'] = $this->kepegawaian->getAllWithOrder('db_pegawai.agama', 'id_agama', 'asc');
			$data['status_kawin'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuskawin', 'id_sk', 'asc');
			$data['status_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statuspeg', 'id_statuspeg', 'asc');
			$data['jenis_pegawai'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispeg', 'id_jenispeg', 'asc');
			$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
			$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
			$data['pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'asc');
			$data['pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
			$data['satyalencana'] = $this->kepegawaian->getDataSatyalencanaPegawai($nip);
			// dd($data['nip']);
			render('kepegawaian/V_ProfilPegawai', '', '', $data);
		
	}

	public function getSearchPegawai()
    {
        $id = $this->input->post('id');
        $response   = $this->kepegawaian->getSearchPegawai($id);
        echo json_encode($response);
    }

	public function loadListProfilTalenta($nip,$jenis_pengisian){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$id_peg = $data['profil_pegawai']['id_peg'];
		// dd($data['profil_pegawai']['eselon']);
		// $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,1);
		if($data['profil_pegawai']['eselon'] == "III A" || $data['profil_pegawai']['eselon'] == "III B"){
			$id = 1;
			$this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,$id);
			$this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,$id);
			} else if($data['profil_pegawai']['eselon'] == "II A" || $data['profil_pegawai']['eselon'] == "II B") {
			$id = 2;
			$this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,$id);
			} else if($data['profil_pegawai']['eselon'] == "IV A" || $data['profil_pegawai']['eselon'] == "IV B" || $data['profil_pegawai']['kelas_jabatan'] == "9") {
			$id = 3;
			$this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,$id);
			} else {
			$id = 4;
			$this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,$jenis_pengisian,$id);
			}

        $data['result'] = $this->kepegawaian->loadListProfilTalenta( $id_peg,$jenis_pengisian);  
        $data['jenis_pengisian'] = $jenis_pengisian;

	 if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() != $data['profil_pegawai']['nipbaru_ws']) {
        $this->load->view('simata/V_ProfilTalentaAdmList', $data);
	 } else {
        $this->load->view('simata/V_ProfilTalentaItem', $data);

	 }

        
    }


	public function loadDetailProfilTalenta($nip,$jt)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
       
        $id_peg = $data['profil_pegawai']['id_peg'];
        // $data['id_t_penilaian'] = $id;
        $data['jabatan_target'] = $jt;
        $data['nilai_potensial'] = $this->simata->getPegawaiNilaiPotensialPT($nip,$jt);
        $data['nilai_kinerja'] = $this->simata->getPegawaiNilaiKinerjaPT($nip);
        $data['nilai_assesment'] = $this->simata->getNilaiAssesment($id_peg);
        // $data['kode'] = $kode; 
		$data['nip'] = $nip; 
        $this->load->view('kepegawaian/V_DetailProfilTalenta', $data);
    }

	public function automationJabatanFungsional(){
		$this->kepegawaian->automationJabatanFungsional();
	}

	public function openFileDs($id){
		$data['result'] = $this->general->getOne('t_request_ds', 'id', $id);
		$this->load->view('kepegawaian/V_DigitalSignatureShowFile', $data);
	}

	public function suratPidanaHukdis($nip,$jenis){
		// $this->load->library('pdf');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		// dd($data['profil_pegawai']);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		// dd($data['profil_pegawai']);
		$data['nomorsurat'] = "123";
		// $this->load->view('kepegawaian/surat/V_SuratHukdis',$data);	

		// $this->load->library('pdfgenerator');
        // // filename dari pdf ketika didownload
        // // setting paper
        // $paper = 'Legal';
        // //orientasi paper potrait / landscape
        // $orientation = "portrait";
		// // $paper = array(0,0,645,820);
		// if($jenis == 1){
		// 	$file_pdf = "surat_hukdis_".$data['profil_pegawai']['nipbaru_ws'];
		// 	$html = $this->load->view('kepegawaian/surat/V_SuratHukdis',$data, true);	    	
		// }
		// if($jenis == 2){
		// 	$file_pdf = "surat_pidana_".$data['profil_pegawai']['nipbaru_ws'];
		// 	$html = $this->load->view('kepegawaian/surat/V_SuratPidana',$data, true);	    	
		// } 
        // $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);


		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );
		if($jenis == 1){
		$html = $this->load->view('kepegawaian/surat/V_SuratHukdis', $data, true); 
		$file_pdf = "surat_hukdis_".$data['profil_pegawai']['nipbaru_ws'];  	
		}
		if($jenis == 2){
		$html = $this->load->view('kepegawaian/surat/V_SuratPidana', $data, true); 
		$file_pdf = "surat_pidana_".$data['profil_pegawai']['nipbaru_ws'];  	
		} 
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($file_pdf.$data['profil_pegawai']['nipbaru_ws'].'.pdf', 'D');
    }

	public function suratFormulirCuti($id_cuti){
		$data['cuti'] = $this->kepegawaian->getDataCutiPegawai($id_cuti);
		$nip = $data['cuti']['nipbaru_ws'];
		$unitkerja = $data['cuti']['nm_unitkerja'];
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($unitkerja);
		$data['atasan_pegawai'] = $this->kepegawaian->getDataAtasanPegawai($nip);
		
		
		$data['nomorsurat'] = "123";
		$this->load->view('kepegawaian/surat/V_FormulirCuti',$data);	

		$mpdf = new \Mpdf\Mpdf([
			'format' => 'Legal',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );

		$html = $this->load->view('kepegawaian/surat/V_FormulirCuti', $data, true); 
		$file_pdf = "formulir_cuti_".$data['cuti']['nipbaru_ws'];  	
		
		// $html = $this->load->view('kepegawaian/surat/V_SuratHukdis', $data, true);
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		// $mpdf->Output('Draf SK Pangkat.pdf', 'D');
		$mpdf->Output($file_pdf.'.pdf');
    }

	public function verifDokumenPdm($id, $status)
    {
        echo json_encode($this->kepegawaian->verifDokumenPdm($id, $status));
    }


	public function pltPlh(){
        $data['layanan'] = $this->master->getAllMasterLayanan();
		$data['unit_kerja'] = $this->kepegawaian->getUnitKerja();
        $data['nama_jabatan'] = $this->kepegawaian->getNamaJabatanStruktural();
		// dd($data['nama_jabatan']);
		$data['list_pegawai'] = $this->session->userdata('list_pegawai');
        if(!$data['list_pegawai']){
            $this->session->set_userdata('list_pegawai', $this->master->getAllPegawai());
            $data['list_pegawai'] = $this->session->userdata('list_pegawai');
        }
        render('kepegawaian/V_MasterPltPlh', '', '', $data);
    }

	public function loadListPltPlh(){
        $data['list_pltplh'] = $this->kepegawaian->getPltPlh();
      
        $this->load->view('kepegawaian/V_MasterPltPlhItem', $data);
    }

	public function loadEditPltPlh($id){
        $data['nama_jabatan'] = $this->kepegawaian->getNamaJabatanStruktural();
		$data['result'] = $this->kepegawaian->loadDataPltPlhById($id);
        $this->load->view('kepegawaian/V_MasterPltPlhEdit', $data);
	}

	public function submitEditPltPlh($id){
		echo json_encode( $this->kepegawaian->submitEditPltPlh($id));
	}

	public function submitPltPlh()
	{ 
		echo json_encode( $this->kepegawaian->submitPltPlh());
	}

	public function deleteTpltPlh($id){
        $this->general->delete('id', $id, 't_plt_plh');
    }


	public function rekapVerifPeninjauanAbsensi(){
        render('rekap/V_RekapVerifikasiPeninjauanAbsensi', '', '', null);
    }

	public function searchRekapVerifPeninjauanAbsensi(){
        $data['result'] = $this->kepegawaian->searchRekapVerifPeninjauanAbsensi($this->input->post());
        $this->load->view('rekap/V_RekapVerifikasiPeninjauanAbsensiResult', $data);
    }


	public function layananPangkat($id_layanan){
		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
		$currentYear = date('Y'); 
		$previous1Year = $currentYear - 1;   
		$previous2Year = $currentYear - 2; 
		$data['tahun_1_lalu'] = $previous1Year;
		$data['tahun_2_lalu'] = $previous2Year;
		$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
		$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous2Year); 
		$data['pmk'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','29','0');	
		$data['stlud'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','10','0');	
		$data['id_m_layanan'] = $id_layanan;
		$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
		// dd($data['skp2']);
	

		if($id_layanan == 6 || $id_layanan == 7 || $id_layanan == 8 || $id_layanan == 9){
			if($id_layanan == 7){
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
				$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','13','0');	
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','65','0');	
				$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','12','0');	
				$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayanan(); 
				$data['petajabatan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','66','0');	
			
			}
			if($id_layanan == 8){
				$data['diklat'] = $this->kepegawaian->getDokumenDiklatForVerifLayanan();	
				$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','12','0');	
				$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','13','0');	
				$data['skjabterusmenerus'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','67','0');	
			}
			if($id_layanan == 9){
				$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir(); 
				$data['uraiantugas'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','15','0');	
				$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','12','0');	
				$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','13','0');	
				$data['stlud'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','10','0');	
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','65','0');	
				$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayanan(); 
				$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','68','0');	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
			}
		$this->load->view('kepegawaian/layanan/V_LayananPangkat', $data);
		} 
		// else if($id_layanan == 7){
		// $data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');
		// $this->load->view('kepegawaian/layanan/V_LayananPangkatFungsional', $data);
		// }
	}

	public function layananJabatanFungsional($id_layanan){
		     
		$currentYear = date('Y'); 
		$previous1Year = $currentYear - 1;   
		$previous2Year = $currentYear - 2; 
		$data['tahun_1_lalu'] = $previous1Year;
		$data['tahun_2_lalu'] = $previous2Year;
		$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
		$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous2Year); 
		$data['pmk'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','29','0');	
		$data['id_m_layanan'] = $id_layanan;
		$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
		$data['dok_lain'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','75','0');	
		$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayanan();
		$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayanan();

		

			if($id_layanan == 12){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','69','0');	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
				$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','65','0');
				$data['tangkap_layar_myasn'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','91','0');
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','66','0');	
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','22','0');
                if($data['str_serdik'] == null){
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','21','0');
				}


			}
			if($id_layanan == 13){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','69','0');	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','65','0');
				$data['tangkap_layar_myasn'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','91','0');

				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','66','0');	
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','22','0');
                if($data['str_serdik'] == null){
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','21','0');
				}
				$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir(); 

			}
			if($id_layanan == 14){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','69','0');	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','66','0');	
				$data['rekom_instansi_pembina'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','70','0');	
			
			}
			if($id_layanan == 15){
				$data['surat_usul_pyb'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','71','0');	
				$data['pengunduran_diri'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','72','0');	
				$data['rekom_kepala_pd'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','79','0');	
			
			}
			if($id_layanan == 16){
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');	
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','66','0');	
				$data['sk_pemberhentian_dari_jabfung'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','73','0');	
				$data['sk_pengaktifan_kembali'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','74','0');	
				$data['cltn'] = $this->kepegawaian->getCutiCltn(); 
				$data['sk_mutasi_instansi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','82','0');	

			}

		$this->load->view('kepegawaian/layanan/V_LayananJabatanFungsional', $data);
		// else if($id_layanan == 7){
		// $data['pak'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','11','0');
		// $this->load->view('kepegawaian/layanan/V_LayananPangkatFungsional', $data);
		// }
	}

	public function layananPerbaikanData($id_layanan){
		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
		$data['sk_pppk'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','3');

		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
		$data['ijazah_cpns'] = $this->kepegawaian->getIjazahCpns(); 
		$data['id_m_layanan'] = $id_layanan;
		$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
		$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
		
		if($data['sk_pppk']){
			$data['sk_cpns'] = $data['sk_pppk'];
		} 

		$this->load->view('kepegawaian/layanan/V_LayananPerbaikanData', $data);
	
	}

	public function loadListRiwayatPerbaikanData(){
		$data['result'] = $this->kepegawaian->getRiwayatPerbaikanData();
		$this->load->view('kepegawaian/layanan/V_LayananPerbaikanDataItem', $data);
	}

	public function loadListRiwayatPeningkatanPenambahanGelar(){
		$data['result'] = $this->kepegawaian->getRiwayatPerbaikanData();
		$this->load->view('kepegawaian/layanan/V_LayananPerbaikanDataItem', $data);
	}


	public function loadListRiwayatLayanan($id){
		$data['result'] = $this->kepegawaian->getRiwayatLayanan($id);
		$data['m_layanan'] = $id;
		$this->load->view('kepegawaian/layanan/V_RiwayatLayananItem', $data);
	}

	public function insertUsulLayananPangkat($id)
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayananNew2($id));
	}

	public function insertUsulLayananNew($id)
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayananNew2($id));
	}

	public function insertUsulLayananTubel($id)
	{ 
		echo json_encode( $this->kepegawaian->insertUsulLayananTubel($id));
	}

	

	public function deleteRiwayatLayanan($id){
        $this->general->delete('id', $id, 't_layanan');
    }

	public function ajukanKembaliLayananPangkat($id){
        $this->kepegawaian->ajukanKembaliLayananPangkat('id', $id, 't_layanan');
    }
	

	

	public function verifikasiLayananNew($id_m_layanan){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
		if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9){
			$data['nm_layanan'] = "KENAIKAN PANGKAT";
		} else {
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_m_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
		}
		if($id_m_layanan == 18 || $id_m_layanan == 19 || $id_m_layanan == 20){
			$data['nm_layanan'] = "UJIAN DINAS DAN UJIAN PENYESUAIAN KENAIKAN PANGKAT";
		}
		if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16){
			$data['nm_layanan'] = "JABATAN FUNGSIONAL";
		}
		
		$data['id_m_layanan'] = $id_m_layanan;

		render('kepegawaian/layanan/V_VerifikasiLayanan', '', '', $data);
	}

	public function searchPengajuanLayanan($id_m_layanan){
		if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16 ){
			$data['result'] = $this->kepegawaian->searchPengajuanLayananFungsional($id_m_layanan);
		} else if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9){
			$data['result'] = $this->kepegawaian->searchPengajuanLayananPangkat($id_m_layanan);
		} else {
			$data['result'] = $this->kepegawaian->searchPengajuanLayanan($id_m_layanan);
		}
		$data['param'] = $this->input->post();
		$data['id_m_layanan'] = $id_m_layanan;
		if($id_m_layanan == 1){
			$this->load->view('kepegawaian/layanan/V_VerfikasiKarisKarsuItem', $data);
		} else if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9){
			$this->load->view('kepegawaian/layanan/V_VerfikasiLayananPangkatItem', $data);
		} else if($id_m_layanan == 10 || $id_m_layanan == 11){
			$this->load->view('kepegawaian/layanan/V_VerfikasiLayananPerbaikanDataItem', $data);
		} else if($id_m_layanan == 18 || $id_m_layanan == 19 || $id_m_layanan == 20){
			$this->load->view('kepegawaian/layanan/V_VerfikasiLayananUjianDinasItem', $data);
		} else if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananJabFungItem', $data);
		} else if($id_m_layanan == 21){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananpeningkatanPenambahanGelarItem', $data);
		} else if($id_m_layanan == 23){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananSuratPidanaHukdisItem', $data);
		} else if($id_m_layanan == 24){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananSuratKetTidakTubelItem', $data);
		} else if($id_m_layanan == 27){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananSuratRekomMasukPtItem', $data);
		} else if($id_m_layanan == 25 || $id_m_layanan == 26){
			$this->load->view('kepegawaian/layanan/V_VerifikasiLayananTugasBelajarItem', $data);
		}
	}

	public function verifikasiLayananDetail($id,$layanan){
		
		$data['result'] = $this->kepegawaian->getPengajuanLayanan($id,$layanan);
		$id_peg = $data['result'][0]['id_peg'];
		$currentYear = date('Y'); 
		$previous1Year = $currentYear - 1;   
		$previous2Year = $currentYear - 2; 
		$data['tahun_1_lalu'] = $previous1Year;
		$data['tahun_2_lalu'] = $previous2Year;
		$data['id_m_layanan'] = $layanan;
		$data['id_usul'] = $id;
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($id_peg);
		$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','1',$id_peg);
		$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','2',$id_peg);      
		
		if($layanan == 1){
			render('kepegawaian/layanan/V_VerfikasiKarisKarsuDetail', '', '', $data);
		} else if($layanan == 6 || $layanan == 7 || $layanan == 8 || $layanan == 9){
		// $data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','1',$id_peg);
		// $data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegberkaspns','0','2',$id_peg);        
		// $data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($id_peg);
		 
		$currentYear = date('Y'); 
		$previous1Year = $currentYear - 1;   
		$previous2Year = $currentYear - 2; 
		$data['tahun_1_lalu'] = $previous1Year;
		$data['tahun_2_lalu'] = $previous2Year;
		$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
		$data['stlud'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','10','0',$id_peg);	
		$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous2Year,$id_peg); 
		$data['pmk'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','29','0',$id_peg);	
		if($layanan == 7){
			$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','11','0',$id_peg);	
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','13','0',$id_peg);	
			$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','65','0',$id_peg);	
			$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','12','0',$id_peg);	
			$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayananAdmin($id_peg); 
			$data['petajabatan'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','66','0',$id_peg);	
		
		}
		if($layanan == 8){
			$data['diklat'] = $this->kepegawaian->getDokumenDiklatForVerifLayanan();
			$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','12','0',$id_peg);	
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','13','0',$id_peg);	
			$data['skjabterusmenerus'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','67','0',$id_peg);	
		}
		if($layanan == 9){
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg);
			$data['uraiantugas'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','15','0',$id_peg);	
			$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','12','0',$id_peg);	
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','13','0',$id_peg);	
			$data['stlud'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','10','0',$id_peg);	
			$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','65','0',$id_peg);	
			$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayananAdmin($id_peg);
			$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','68','0',$id_peg);	
			$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','11','0',$id_peg);	
		}
			render('kepegawaian/layanan/V_VerifikasiLayananPangkatDetail', '', '', $data);
		} else if($layanan == 10 || $layanan == 11){
			$data['ijazah_cpns'] = $this->kepegawaian->getIjazahCpnsAdmin($id_peg);
			render('kepegawaian/layanan/V_VerifikasiLayananPerbaikanDataDetail', '', '', $data);
		} else if($layanan == 18 || $layanan == 19 || $layanan == 20){
			$data['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanTerakhirForLayananAdmin($id_peg);
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg);
			$data['ijazah_s_penyesuaian'] = $this->kepegawaian->getIjazahSPAdmin($id_peg);
			$data['ijazah_penyesuaian'] = $this->kepegawaian->getIjazahPAdmin($id_peg);
			$data['karya_tulis'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','43','0',$id_peg);	
			render('kepegawaian/layanan/V_VerifikasiLayananUjianDinasDetail', '', '', $data);
		} else if($layanan == 12 || $layanan == 13 || $layanan == 14 || $layanan == 15 || $layanan == 16){
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
			$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous2Year,$id_peg); 
			$data['dok_lain'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','75','0',$id_peg);	
			$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayananAdmin($id_peg); 
			$data['tahun_1_lalu'] = $previous1Year;
			$data['tahun_2_lalu'] = $previous2Year;

			if($layanan == 12){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','69','0',$id_peg);	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','11','0',$id_peg);	
				$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','65','0',$id_peg);
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','66','0',$id_peg);	
				$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayananAdmin($id_peg); 
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','76','0',$id_peg);
				
			}
			if($layanan == 13){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','69','0',$id_peg);	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','11','0',$id_peg);	
				$data['sertiukom'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','65','0',$id_peg);
				$data['tangkap_layar_myasn'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','91','0',$id_peg);
				
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','66','0',$id_peg);	
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','76','0',$id_peg);
				if($data['str_serdik'] == null){
				$data['str_serdik'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','21','0',$id_peg);
				}
				// dd($data['str_serdik']);
				$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg); 
				$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayananAdmin($id_peg); 
			}
			if($layanan == 14){
				$data['formasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','69','0',$id_peg);	
				$data['pak'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','11','0',$id_peg);	
				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','66','0',$id_peg);	
				$data['rekom_instansi_pembina'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','70','0',$id_peg);	
				$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayananAdmin($id_peg); 
			
			}
			if($layanan == 15){
				$data['surat_usul_pyb'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','71','0',$id_peg);	
				$data['pengunduran_diri'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','72','0',$id_peg);	
				$data['rekom_kepala_pd'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','79','0',$id_peg);	
				$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayananAdmin($id_peg); 
			
			}
			if($layanan == 16){
				$data['sk_jabatan_fungsional'] = $this->kepegawaian->getDokumenJabatanFungsionalForLayananAdmin($id_peg); 
				$data['sk_jabatan_fungsional_pertama'] = $this->kepegawaian->getDokumenJabatanFungsionalPertamaForLayananAdmin($id_peg); 

				$data['peta_jabatan'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','66','0',$id_peg);	
				$data['sk_pemberhentian_dari_jabfung'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','73','0',$id_peg);	
				$data['sk_pengaktifan_kembali'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','74','0',$id_peg);	
				$data['cltn'] = $this->kepegawaian->getCutiCltnAdmin($id_peg); 
			}
			render('kepegawaian/layanan/V_VerifikasiLayananJabFungDetail', '', '', $data);
		} else if($layanan == 21){
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir2Admin($id_peg);
			// dd($data['ijazah']);
			render('kepegawaian/layanan/V_VerifikasiLayananPeningkatanPenambahanGelarDetail', '', '', $data);
		} else if($layanan == 23){
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg);
			render('kepegawaian/layanan/V_VerifikasiLayananSuratPidanaHukdisDetail', '', '', $data);
		} else if($layanan == 24){
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
			render('kepegawaian/layanan/V_VerifikasiLayananSuratKetTidakTubelDetail', '', '', $data);
		} else if($layanan == 27){
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
			$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous2Year,$id_peg);
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg); 
			$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','68','0',$id_peg);	
			$data['transkrip_nilai'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','77','0',$id_peg);	
			$data['surat_rencana_kompetensi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','86','0',$id_peg);	
			$data['surat_pemberitahuan_mhs_baru'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','92','0',$id_peg);	
			render('kepegawaian/layanan/V_VerifikasiLayananSuratRekomMasukPtDetail.php', '', '', $data);
		} else if($layanan == 25 || $layanan == 26){
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous1Year,$id_peg);
			$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkatAdmin('db_pegawai.pegskp',$previous2Year,$id_peg);
			
			$data['surat_permohonan_walikota'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','83','0',$id_peg);	
			$data['surat_rekom_masuk_pt'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','84','0',$id_peg);	
			$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
			$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','68','0',$id_peg);	
			$data['transkrip_nilai'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','77','0',$id_peg);	
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhirAdmin($id_peg); 
			$data['surat_ket_lulus_mhs'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','85','0',$id_peg);	
			$data['surat_rencana_kompetensi'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','86','0',$id_peg);	
			$data['suket_kuliah_online'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','86','0',$id_peg);	
			$data['krs'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','89','0',$id_peg);	
			$data['suket_beasiswa'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','87','0',$id_peg);	
			$data['rencana_pengembangan_diri'] = $this->kepegawaian->getDokumenForKarisKarsuAdmin('db_pegawai.pegarsip','90','0',$id_peg);

			render('kepegawaian/layanan/V_VerifikasiLayananTubelDetail.php', '', '', $data);
		}  
		

		
	}

	public function getFileForVerifLayanan()
    {
        $data = $this->kepegawaian->getFileForVerifLayanan();
		// dd($data);
        echo json_encode($data);
    }


	public function submitVerifikasiPengajuanLayanan()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiPengajuanLayanan());
	}

	public function submitVerifikasiPengajuanLayananPangkat()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiPengajuanLayananPangkat());
	}

	public function submitVerifikasiPengajuanLayananFungsional()
	{ 
		echo json_encode( $this->kepegawaian->submitVerifikasiPengajuanLayananFungsional());
	}

	


	public function batalVerifikasiPengajuanLayanan()
	{ 
		echo json_encode( $this->kepegawaian->batalVerifikasiPengajuanLayanan());
	}

	public function kerjakanPengajuanLayanan()
	{ 
		echo json_encode( $this->kepegawaian->kerjakanPengajuanLayanan());
	}

	public function loadModalUploadSK($id_usul,$id_m_layanan)
    {
		$data['id_usul']= $id_usul;
        if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9 ){
		$data['jenis_pengangkatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispengangkatan', 'id_jenispengangkatan', 'desc');
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 4);
		$data['result'] = $this->kepegawaian->getPengajuanLayanan($id_usul,$id_m_layanan);
		$this->load->view('kepegawaian/layanan/V_UploadSKPangkat', $data);
		} else if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16){
		$data['result'] = $this->kepegawaian->getPengajuanLayanan($id_usul,$id_m_layanan);
		$data['unor_siasn'] = $this->general->getAllWithOrderGeneral('db_siasn.m_ref_unor', 'nama_unor', 'asc');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiByAdmin($data['result'][0]['nipbaru_ws']);		
		$data['jenis_jabatan'] = $this->kepegawaian->getJenisJabatan();
		$data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
		$data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
		$data['status_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.statusjabatan', 'id_statusjabatan', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$this->load->view('kepegawaian/layanan/V_UploadSKJabatan', $data);

		}
    }

	public function uploadSKLayanan()
	{ 
		echo json_encode( $this->kepegawaian->uploadSKLayanan());
	}

	public function uploadSuratLayananPidanaHukdis()
	{ 
		echo json_encode( $this->kepegawaian->uploadSuratLayananPidanaHukdis());
	}

	public function uploadSuratLayananSuketTidakTubel()
	{ 
		echo json_encode( $this->kepegawaian->uploadSuratLayananSuketTidakTubel());
	}

	public function uploadSuratLayananRekomSeleksiPT()
	{ 
		echo json_encode( $this->kepegawaian->uploadSuratLayananRekomSeleksiPT());
	}

	


	public function deleteFileLayanan($id,$reference_id_dok,$id_m_layanan, $id_pegawai=null)
    {
        $this->kepegawaian->deleteFileLayanan($id,$reference_id_dok,$id_m_layanan,$id_pegawai);
    }

	public function kirimBkad($id,$status)
    {
        $this->kepegawaian->kirimBkad($id,$status);
    }

	public function kirimBerkalaBkad($id,$status)
    {
        $this->kepegawaian->kirimBerkalaBkad($id,$status);
    }

	

	public function downloadDrafSKPangkat($id_usul,$id_m_layanan){
		$data['result'] = $this->kepegawaian->getPengajuanLayanan($id_usul,$id_m_layanan);	
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($data['result'][0]['nipbaru_ws']);
		$data['nomorsurat'] = $this->input->post('nomor_sk');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		$data['tanggal_pertek'] = $this->input->post('tanggal_pertek');
		$data['nomor_urut'] = $this->input->post('nomor_urut');
        // $this->load->view('kepegawaian/layanan/V_DrafSkPangkat', $data);

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-P',
				// 'format' => [215, 330],
				'default_font_size' => 9,
				'default_font' => 'times',
                'debug' => true
            ]);
            $html = $this->load->view('kepegawaian/layanan/V_DrafSkPangkat', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output('Draf SK Pangkat.pdf', 'D');
		
        } 

		public function verifikasiPangkatBkad(){
			$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
			render('kepegawaian/layanan/V_VerifikasiPangkatBkad', '', '', $data);
		}
    
		public function searchUsulPangkatBkad(){
			$data['result'] = $this->kepegawaian->searchUsulPangkatBkad();
			$data['param'] = $this->input->post();
			$this->load->view('kepegawaian/layanan/V_VerifikasiPangkatBkadItem', $data);
		}
	
		public function submitVerifikasiPangkatBkad()
		{ 
			echo json_encode( $this->kepegawaian->submitVerifikasiPangkatBkad());
		}

		public function submitVerifikasiBerkalaBkad()
		{ 
			echo json_encode( $this->kepegawaian->submitVerifikasiBerkalaBkad());
		}


		public function submitEditSPLayanan()
		{ 
			echo json_encode($this->kepegawaian->submitEditSPLayanan());
		}

			public function submitEditSuketLayanan()
		{ 
			echo json_encode($this->kepegawaian->submitEditSuketLayanan());
		}

	public function prosesGajiBerkala($nip,$tahun){
		
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiForDrafSK($nip);
		$id_pegawai = $data['profil_pegawai']['id_peg'];
		$data['result'] = $this->kepegawaian->cekProsesKenaikanBerkala($id_pegawai,$tahun);
		$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($id_pegawai); 
		$data['sk_kgb'] = $this->kepegawaian->getDokumenGajiBerkala($id_pegawai); 
		$data['tahun'] = $tahun;
		// dd($data['sk_kgb']);
		render('kepegawaian/layanan/V_ProsesGajiBerkala', '', '', $data);
	}

	public function submitProsesKenaikanGajiBerkala()
	{ 
		echo json_encode( $this->kepegawaian->submitProsesKenaikanGajiBerkala());
	}

	public function batalVerifikasiProsesKgb()
	{ 
		echo json_encode( $this->kepegawaian->batalVerifikasiProsesKgb());
	}

	public function downloadDrafSKKgb(){
		// $data['result'] = $this->kepegawaian->getPengajuanLayanan($id_usul,$id_m_layanan);	
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$nip = $this->input->post('nip');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawaiForDrafSK($nip);
		$data['gaji_lama'] = $this->input->post('gajilama');
		$data['gaji_baru'] = $this->input->post('gajibaru');
		$data['masa_kerja'] = $this->input->post('edit_gb_masa_kerja');
		$data['tmt_kgb_baru'] = $this->input->post('edit_tmt_gaji_berkala');
		
		$data['tglsk'] = $this->input->post('edit_gb_tanggal_sk');
		$data['pangkat_pejabat'] = $this->input->post('pangkat_pejabat');
		$data['pangkat_tmt'] = formatDateNamaBulan($this->input->post('pangkat_tmt'));
		$data['pangkat_nosk'] = $this->input->post('pangkat_nosk');
		$data['pangkat_mkg'] = $this->input->post('pangkat_mkg');
		$data['pangkat_tglsk'] = $this->input->post('pangkat_tglsk');
		
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['skpd']);
        $nama = str_replace('.', '', $data['profil_pegawai']['nipbaru_ws']);

		$nominal = str_replace('.', '', $this->input->post('gajibaru'));
		// $nominal = 50;

		$data['terbilang']= terbilang($nominal);

		
		$bulan = getNamaBulan(date('m'));
		$tahun = date('Y');
		
		if(!file_exists('arsipusulds/'.$tahun)){
                mkdir('arsipusulds/'.$tahun, 0777);
            }

        if(!file_exists('arsipusulds/'.$tahun.'/'.$bulan)){
                mkdir('arsipusulds/'.$tahun.'/'.$bulan, 0777);
            }

		$dataNomorSurat = getNomorSuratSiladen([
                'jenis_layanan' => 64,
                'tahun' => 2025,
                'perihal' => "usul DS"
            ], 0);
		$data['nosk'] = $dataNomorSurat['data']['nomor_surat'];
		$dataPost = $this->input->post();
		$id_usul = $this->input->post('id');  
		$this->kepegawaian->simpanDataDrafKgb();
		
		

        $this->load->view('kepegawaian/layanan/V_DrafSkKgb', $data);

				 $mpdf = new \Mpdf\Mpdf([
					'format' => 'Legal-P',
					// 'format' => [215, 330],
					'default_font_size' => 10,
					'default_font' => 'times',
					'debug' => true
				]);
				$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );

				$file_pdf = $random_number.'_SK_Kenaikan_Gaji_Berkala_'.$nama.'.pdf';

				$url1 = 'arsipusulds/'.$tahun.'/'.$bulan.'/'.$file_pdf;
	            $url2 = 'dokumen_layanan/gajiberkala/'.$file_pdf;

				$html = $this->load->view('kepegawaian/layanan/V_DrafSkKgb', $data, true);
				$mpdf->WriteHTML($html);
				$mpdf->showImageErrors = true;
				$mpdf->Output($url1, 'F');
				$mpdf->Output($url2, 'F');
				$mpdf->Output($file_pdf, 'D');
				$dataPost['nomor_surat_siladen'] = $data['nosk'];
				$this->kepegawaian->uploadFileUsulDsBerkala($id_usul,$dataPost,$url1,$url2,$file_pdf);
        }

		public function loadListGajiBerkalaSelesai(){
			$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
			render('kepegawaian/layanan/V_GajiBerkalaSelesai', '', '', $data);
		}
	
		public function loadListGajiBerkalaSelesaiItem(){
			$data['result'] = $this->kepegawaian->loadListGajiBerkalaSelesai();
			$data['param'] = $this->input->post();
			$data['tahun'] = $this->input->post('gb_tahun');
			$this->load->view('kepegawaian/layanan/V_GajiBerkalaSelesaiItem', $data);
		}


		public function verifikasiBerkalaBkad(){
			$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
			render('kepegawaian/layanan/V_VerifikasiBerkalaBkad', '', '', $data);
		}
    
		public function verifikasiBerkalaBkadItem(){
			$data['result'] = $this->kepegawaian->verifikasiBerkalaBkadItem();
			$data['param'] = $this->input->post();
			$this->load->view('kepegawaian/layanan/V_VerifikasiBerkalaBkadItem', $data);
		}

		public function updateStatusLayananPangkat($id){
			$this->kepegawaian->updateStatusLayananPangkat($id);
		}
		public function hitungMasaKerja(){
			echo countDiffDateLengkap($this->input->post('tmtberkala'), $this->input->post('tmtcpns'), ['tahun', 'bulan']);
		}

		public function catatanGajiBerkala()
		{ 
			
			echo json_encode($this->kepegawaian->catatanGajiBerkala());
		}


		public function layananUjianDinas($id_layanan){


			$currentYear = date('Y'); 
			$previous1Year = $currentYear - 1;   
			$previous2Year = $currentYear - 2; 
			$data['tahun_1_lalu'] = $previous1Year;
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
			$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
			$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
			$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
			$data['karya_tulis'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','43','0');	
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir(); 
			$data['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiun();
			$data['ijazah_s_penyesuaian'] = $this->kepegawaian->getIjazahSP(); 
			$data['ijazah_penyesuaian'] = $this->kepegawaian->getIjazahP(); 
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','13','0');	
			
			if($data['ibel'] == null || $data['ibel'] == ""){
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','14','0');	
			}

			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$this->load->view('kepegawaian/layanan/V_LayananUjianDinas', $data);
		
		}

		public function layananPeningkatanPenambahanGelar($id_layanan){
			$data['sk_cpns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','1');
			$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
			$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
			$data['ibel'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','13','0');	
			$data['transkrip'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','77','0');	
			$data['akreditasi_prodi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','68','0');	
			$data['pangkalandata'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','12','0');	
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir2(); 
			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$this->load->view('kepegawaian/layanan/V_LayananPeningkatanPenambahanGelar', $data);
		
		}

		public function layananSuratPidanaHukdis($id_layanan){
			$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$this->load->view('kepegawaian/layanan/V_LayananSuratPidanaHukdis', $data);
		}

		public function layananSuratKeteranganTidakTubel($id_layanan){
			$currentYear = date('Y'); 
			$previous1Year = $currentYear - 1;   
			$previous2Year = $currentYear - 2; 
			$data['tahun_1_lalu'] = $previous1Year;
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
			$data['sk_pns'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegberkaspns','0','2');        
			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$this->load->view('kepegawaian/layanan/V_LayananSuratKeteranganTidakTubel', $data);
		}

	
		public function downloadDraftPidanaHukdis(){

		$nip = $this->input->post('nip');
		$jenis = $this->input->post('jenis');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		// $this->load->library('pdf');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		// dd($data['profil_pegawai']);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		// dd($data['profil_pegawai']);
		$data['nomor_surat'] = $this->input->post('nomor_surat');
		// $this->load->view('kepegawaian/surat/V_SuratHukdis2',$data);	
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );
		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		if($jenis == 1){
		$mpdf->adjustFontDescLineheight = 1.80;
		$html = $this->load->view('kepegawaian/surat/V_SuratHukdis2', $data, true); 
		$file_pdf = $random_number."surat_hukdis_".$data['profil_pegawai']['nipbaru_ws'];  	
		}
		if($jenis == 2){
		$html = $this->load->view('kepegawaian/surat/V_SuratPidana', $data, true); 
		$file_pdf = $random_number."surat_pidana_".$data['profil_pegawai']['nipbaru_ws'];  	
		} 
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($file_pdf.$data['profil_pegawai']['nipbaru_ws'].'.pdf', 'D');
    }

	public function previewDraftSuketTidakTubel(){
		$nip = $this->input->post('nip');
		$id_usul = $this->input->post('id_usul');
		$jenis = $this->input->post('jenis');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		$data['nomor_surat'] = $this->input->post('nomor_surat');
		$data['instansi_tujuan'] = $this->input->post('instansi_tujuan');
		$html = $this->load->view('kepegawaian/surat/V_SuratKetTidakTubel', $data, true); 
		$mpdf = new \Mpdf\Mpdf();
			$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );

		$mpdf->WriteHTML($html);
		$mpdf->Output();
    }

	public function usulDSSuketTidakTubel(){

		$nip = $this->input->post('nip');
		$id_usul = $this->input->post('id_usul');
		$jenis = $this->input->post('jenis');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		$data['nomor_surat'] = $this->input->post('nomor_surat');
		$data['instansi_tujuan'] = $this->input->post('instansi_tujuan');
		// $this->load->view('kepegawaian/surat/V_SuratKetTidakTubel',$data);	
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );

		$bulan = getNamaBulan(date('m'));
		$tahun = date('Y');
		
		if(!file_exists('arsipusulds/'.$tahun)){
                mkdir('arsipusulds/'.$tahun, 0777);
            }

        if(!file_exists('arsipusulds/'.$tahun.'/'.$bulan)){
                mkdir('arsipusulds/'.$tahun.'/'.$bulan, 0777);
            }

		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		$html = $this->load->view('kepegawaian/surat/V_SuratKetTidakTubel', $data, true); 
		$file_pdf = $random_number."surat_ket_tidak_tubel_".$data['profil_pegawai']['nipbaru_ws'].'.pdf';  	
	    $url1 = 'arsipusulds/'.$tahun.'/'.$bulan.'/'.$file_pdf;
	    $url2 = 'dokumen_layanan/suratkettidaktubel/arsipsuket/'.$file_pdf;
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($url1, 'F');
		$mpdf->Output($url2, 'F');
		$dataPost = $this->input->post();
		$this->kepegawaian->uploadFileUsulDs($id_usul,$dataPost,$url1,$url2,$file_pdf);

    }

	public function downloadDraftSuketTidakTubel(){
		$nip = $this->input->post('nip');
		$id_usul = $this->input->post('id_usul');
		$jenis = $this->input->post('jenis');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		$data['nomor_surat'] = $this->input->post('nomor_surat');
		$data['instansi_tujuan'] = $this->input->post('instansi_tujuan');
		$mpdf = new \Mpdf\Mpdf();
			$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );

		
		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		$html = $this->load->view('kepegawaian/surat/V_SuratKetTidakTubel', $data, true); 
		$file_pdf = $random_number."surat_ket_tidak_tubel_".$data['profil_pegawai']['nipbaru_ws'].'.pdf';  	
	    $url = 'dokumen_layanan/suratkettidaktubel/arsipsuket/'.$file_pdf;
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($file_pdf, 'D');
    }


	public function LoadFormKp4($nip){
		$data['nip'] = $nip;
		$data['kp4'] = $this->kepegawaian->getKp4($nip);
		// dd($data['kp4']);
		// $data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		$data['pasangan'] = $this->kepegawaian->getKeluargaPegawai($nip,1);
		$data['anak'] = $this->kepegawaian->getKeluargaPegawai($nip,2);
        $this->load->view('kepegawaian/V_FormKp4', $data);
    }

	 public function simpanKp4()
    {
		echo json_encode($this->kepegawaian->simpanKp4());
        // for ($count = 0; $count < count($dataPost['anak']); $count++) {
        //     // $id_anak = $dataPost['id_t_tindakan'][$count];
        //     $data = null;
        //     if(isset($dataPost['hasil_'.$id_t_tindakan])){
        //         $data['hasil'] = $dataPost['hasil_'.$id_t_tindakan];
        //     }
        //     if($data){
        //         $this->kepegawaian->createHasil($id_t_tindakan, $data, $id_pendaftaran);
        //     }
        // }

    }

	public function downloadkp4(){
		$nip = $this->input->post('nip');
		$data['nip'] = $nip;
		$data['kp4'] = $this->kepegawaian->getKp4($nip);
		$data['pasangan'] = $this->kepegawaian->getKeluargaPegawai($nip,1);
		$data['anak'] = $this->kepegawaian->getKeluargaPegawai($nip,2);

		$this->load->view('kepegawaian/surat/V_kp4', $data);
		$mpdf = new \Mpdf\Mpdf([
			'debug' => true,
			// 'default_font_size' => 14,
			'mode' => 'utf-8', 
			'format' => [210, 330],
			'default_font_size' => 10,
			'orientation' => 'P'
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            20, // margin bottom
            18, // margin header
            12
        );
		$mpdf->shrink_tables_to_fit;
		$mpdf->use_kwt = true;
		$mpdf->shrink_tables_to_fit = 1;
		$mpdf->defaultPageNumStyle = 'slice';
		$mpdf->autoPageBreak = false;
		// $mpdf->adjustFontDescLineheight = 1.80;
		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		$html = $this->load->view('kepegawaian/surat/V_kp4', $data, true); 
		$file_pdf = $random_number."kp4".$data['kp4']['nipbaru_ws'].'.pdf';  	
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($file_pdf, 'D');
    }

	public function layananTugasBelajar($id_layanan){
			$currentYear = date('Y'); 
			$previous1Year = $currentYear - 1;   
			$previous2Year = $currentYear - 2; 
			$data['tahun_1_lalu'] = $previous1Year;
			$data['tahun_2_lalu'] = $previous2Year;
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
			$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous2Year);
			$data['surat_permohonan_walikota'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','83','0');	
			$data['surat_rekom_masuk_pt'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','84','0');	
			$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
			$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','68','0');	
			$data['transkrip_nilai'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','77','0');	
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir(); 
			$data['surat_ket_lulus_mhs'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','85','0');	
			$data['surat_rencana_kompetensi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','86','0');	
			$data['suket_kuliah_online'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','86','0');	
			$data['krs'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','89','0');	
			$data['suket_beasiswa'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','87','0');	
			$data['rencana_pengembangan_diri'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','90','0');	
			
			
			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$this->load->view('kepegawaian/layanan/V_LayananTugasBelajar', $data);
		}

		public function layananSuratMasukPt($id_layanan){
			$currentYear = date('Y'); 
			$previous1Year = $currentYear - 1;   
			$previous2Year = $currentYear - 2; 
			$data['tahun_1_lalu'] = $previous1Year;
			$data['tahun_2_lalu'] = $previous2Year;
			$data['skp1'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous1Year);
			$data['skp2'] = $this->kepegawaian->getDokumenForLayananPangkat('db_pegawai.pegskp',$previous2Year);
			$data['id_m_layanan'] = $id_layanan;
			$data['m_layanan'] = $this->kepegawaian->getMlayanan($id_layanan);
			$data['nm_layanan'] = $data['m_layanan']['nama_layanan'];
			$data['status_layanan'] = $this->kepegawaian->getStatusLayananPangkat($id_layanan);
			$data['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiun(); 
			$data['akreditasi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','68','0');	
			$data['transkrip_nilai'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','77','0');	
			
			$data['ijazah'] = $this->kepegawaian->getIjazahTerakhir(); 
			$data['surat_rencana_kompetensi'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','86','0');	
			$data['surat_pemberitahuan_mhs_baru'] = $this->kepegawaian->getDokumenForKarisKarsu('db_pegawai.pegarsip','92','0');	

			$this->load->view('kepegawaian/layanan/V_LayananSuratMasukPt', $data);
		}


		public function usulDShd(){
		
		$nip = $this->input->post('nip');
		$id_usul = $this->input->post('id_usul_layanan');
		$jenis = $this->input->post('jenis');
		$id_m_layanan = $this->input->post('id_m_layanan');
		$data['nomor_pertek'] = $this->input->post('nomor_pertek');
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
		$data['pimpinan_opd'] = $this->kepegawaian->getDataKepalaOpd($data['profil_pegawai']['nm_unitkerja']);
		
		$dataNomorSurat = getNomorSuratSiladen([
                'jenis_layanan' => 39,
                'tahun' => 2025,
                'perihal' => "Usul DS"
            ], 0);
		$data['nomor_surat'] = $dataNomorSurat['data']['nomor_surat'];
		$data['instansi_tujuan'] = $this->input->post('instansi_tujuan');
		// $this->load->view('kepegawaian/surat/V_SuratHukdis2', $data, true); 
		$mpdf = new \Mpdf\Mpdf([
			'format' => 'A4',
			'debug' => true
		]);
		$mpdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        );

		$bulan = getNamaBulan(date('m'));
		$tahun = date('Y');
		
		if(!file_exists('arsipusulds/'.$tahun)){
                mkdir('arsipusulds/'.$tahun, 0777);
            }

        if(!file_exists('arsipusulds/'.$tahun.'/'.$bulan)){
                mkdir('arsipusulds/'.$tahun.'/'.$bulan, 0777);
            }
		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		
		// $html = $this->load->view('kepegawaian/surat/V_SuratHukdis2', $data, true); 
		// $file_pdf = $random_number."surat_ket_tidak_hd_".$data['profil_pegawai']['nipbaru_ws'].'.pdf';  	
	    
		if($jenis == 1){
		$mpdf->adjustFontDescLineheight = 1.80;
		$html = $this->load->view('kepegawaian/surat/V_SuratHukdis2', $data, true); 
		$file_pdf = $random_number."surat_ket_tidak_hd_".$data['profil_pegawai']['nipbaru_ws'].'.pdf';  	 	
		}
		if($jenis == 2){
		$html = $this->load->view('kepegawaian/surat/V_SuratPidana', $data, true); 
		$file_pdf = $random_number."surat_ket_pidana_".$data['profil_pegawai']['nipbaru_ws'].'.pdf';  	 	
		} 
		
		$url1 = 'arsipusulds/'.$tahun.'/'.$bulan.'/'.$file_pdf;
	    $url2 = 'dokumen_layanan/suratpidanahukdis/arsipsuket/'.$file_pdf;
		$mpdf->WriteHTML($html);
		$mpdf->showImageErrors = true;
		$mpdf->Output($url1, 'F');
		$mpdf->Output($url2, 'F');
		$mpdf->Output($file_pdf, 'D');
		$dataPost = $this->input->post();
		$dataPost['nomor_surat_siladen'] = $data['nomor_surat'];
		$dataPost['jenis'] = $jenis;
		$this->kepegawaian->uploadFileUsulDs($id_usul,$dataPost,$url1,$url2,$file_pdf);

    }




}
