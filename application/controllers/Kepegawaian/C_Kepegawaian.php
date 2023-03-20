<?php

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

	public function loadListPangkat(){
		$data['result'] = $this->kepegawaian->getPangkatPegawai();
		$this->load->view('kepegawaian/V_ListPangkat', $data);
	}

	public function uploadDokumenOld(){
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
        $data['dokumen']         	= $this->kepegawaian->getDokumen();
        render('kepegawaian/V_UploadDokumen', '', '', $data);
    }


	public function profil()
	{
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
		$data['pangkat'] = $this->kepegawaian->getPangkatPegawai();
		$data['pendidikan'] = $this->kepegawaian->getPendidikan();
		$data['jabatan'] = $this->kepegawaian->getJabatan();
		// $data['tes'] = $this->general_library->getId();
		// dd($data);
		render('kepegawaian/V_LihatPNS', '', '', $data);
	}

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

	

	function _extract_numbers($string)
	{
		preg_match_all('/([\d]+)/', $string, $match);
		return $match[0];
	}

	


	


	public function uploadDokumen(){
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
        $data['dokumen']         	= $this->kepegawaian->getDokumen();
        render('kepegawaian/V_UploadDokumenNew', '', '', $data);
    }

	public function LoadFormDokPangkat(){
        // $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja($tahun,$bulan);
		$data['jenis_pengangkatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenispengangkatan', 'id_jenispengangkatan', 'desc');
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 4);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadPangkat', $data);
    }

	public function LoadFormGajiBerkala(){
		$data['list_pangkat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.pangkat', 'id_pangkat', 'desc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 7);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadGajiBerkala', $data);
    }

	public function LoadFormPendidikan(){
		$data['list_tingkat_pendidikan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.tktpendidikan', 'id_tktpendidikan', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 6);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadPendidikan', $data);
    }

	public function LoadFormJabatan(){
		$data['jenis_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jenisjab', 'id_jenisjab', 'asc');
		$data['nama_jabatan'] = $this->kepegawaian->getAllWithOrder('db_pegawai.jabatan', 'id_jabatanpeg', 'asc');
		$data['eselon'] = $this->kepegawaian->getAllWithOrder('db_pegawai.eselon', 'id_eselon', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 8);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadJabatan', $data);
    }

	public function LoadFormDiklat(){
		$data['jenis_diklat'] = $this->kepegawaian->getAllWithOrder('db_pegawai.diklat', 'id_diklat', 'asc');
		$data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', 20);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadDiklat', $data);
    }

	public function LoadFormOrganisasi(){
		$data['jenis_organisasi'] = $this->kepegawaian->getAllWithOrder('db_pegawai.organisasi', 'id_organisasi', 'asc');
		// $data['format_dok'] = $this->kepegawaian->getOne('db_siladen.dokumen', 'id_dokumen', null);
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadOrganisasi', $data);
    }

	public function LoadFormPenghargaan(){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        $this->load->view('kepegawaian/V_FormUploadPenghargaan', $data);
    }


	public function layanan(){
        // $data['dokumen'] = $this->kepegawaian->get_datatables_query_lihat_dokumen_pns()
        $data['dokumen']         	= $this->kepegawaian->getDokumen();
        render('kepegawaian/V_layanan', '', '', $data);
    }


	


}
