<?php

//namespace App\Controllers;

class C_pasphoto extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('simpeg/m_pasphoto', 'simpeg');
	}

	public function pasPhoto()
	{

		// $this->setLayout('simpeg/V_pasphoto');
		$data['id_pasphoto']		 = $this->simpeg->getIDPasPhoto();
		$data['nip_baru']		 = $this->simpeg->getNipbaru();
		$data['pesan']           = '';
		render('simpeg/V_pasphoto', '', '', $data);
	}


	public function update()
	{

		if ($_FILES['filePengantar']['name'] == NULL) {
			$data['response']		= FALSE;
			$data['pesan']			= '<div class="alert alert-danger" role="alert">!!! Foto Tidak Boleh Kosong, Format File Foto harus jpg atau jpeg!!!</div>';
		} else {


			if ($_FILES['filePengantar']['name'] != NULL) {
				$nip_baru		 = $this->simpeg->getNipbaru();
				$target_dir  				= './uploads/' . $nip_baru;

				// buat folder baru jika tidak ada
				if (!is_dir($target_dir)) {
					mkdir($target_dir, 0777, TRUE);
				}

				$config['upload_path'] 	    = $target_dir;
				$config['allowed_types']    = 'jpg|jpeg|png';
				$config['max_size'] 		= '1024';
				$config['encrypt_name']		= TRUE;
				$config['overwrite']		= TRUE;

				// load upload lib
				$this->load->library('upload', $config);

				// validasi upload
				// dd($this->upload->do_upload('filePengantar'));
				if (!$this->upload->do_upload('filePengantar')) {
					$error = strip_tags($this->upload->display_errors());
					$data['pesan']				= '<div class="alert alert-danger" role="alert">' . $error . '</div>';
				} else {

					$fileupload       				= $this->upload->data();
				}

				$db_debug 			= $this->db->db_debug;
				$this->db->db_debug = FALSE;

				if (!$this->simpeg->updateUsulWithFile($fileupload)) {
					$error = $this->db->error();
					if (!empty($error)) {
						$data['response']		= FALSE;
						$data['pesan']			= '<div class="alert alert-danger" role="alert">' . $error['message'] . '</div>';

						// remove file
						if (file_exists($target_dir . "/" . $fileupload['file_name'])) {
							@unlink($target_dir . "/" . $fileupload['file_name']);
						}
					}
				} else {
					$data['response']		= TRUE;
					$data['pesan']			= '<div class="alert alert-success" role="alert">Berhasil diupdate!</div>';

					// remove old file
					if (file_exists($target_dir . "/" . $this->input->post('oldFile'))) {
						@unlink($target_dir . "/" . $this->input->post('oldFile'));
					}
				}

				$this->db->db_debug = $db_debug; //restore setting	
			} else {
				$db_debug 			= $this->db->db_debug;
				$this->db->db_debug = FALSE;

				if (!$this->simpeg->updateUsul()) {
					$error = $this->db->error();
					if (!empty($error)) {
						$data['response']		= FALSE;
						$data['pesan']			        = '<div class="alert alert-danger" role="alert">' . $error['message'] . '</div>';
					}
				} else {
					$data['response']		= TRUE;
					$data['pesan']			= '<div class="alert alert-success" role="alert">Berhasil diupdate!</div>';
				}

				$this->db->db_debug = $db_debug; //restore setting	
			}
		}

		// $this->setLayout('simpeg/V_pasphoto');
		$data['id_pasphoto']		 = $this->simpeg->getIDPasPhoto();
		$data['nip_baru']		 = $this->simpeg->getNipbaru();
		$data['show']           = FALSE;
		render('simpeg/V_pasphoto', '', '', $data);

		//$id_pasphoto		 = $this->simpeg->getIDPasPhoto();
		//$nip_baru		 = $this->simpeg->getNipbaru();
		//$show			 = FALSE;

		//$this->setLayout('simpeg/pasPhoto');
		//$this->render('', ['show' => $show, 'pesan' => $pesan, 'pasphoto' => $id_pasphoto, 'nip_baru' => $nip_baru]);
	}



	//-------------------------------------------------------------------------------------------
	//tambah usul idcard
	public function tambahUsulIDCard()
	{

		// header menu message
		$nip_baru		 = $this->simpeg->getNipbaru();
		$nm_pangkat		 = $this->simpeg->getPangkat();
		$jabatan		 = $this->simpeg->getJabatan();
		$nm_unitkerja		 = $this->simpeg->getNamaPerangkatDaerah();
		$id_pasphoto		 = $this->simpeg->getIDPasPhoto();
		$query      =  $this->simpeg->getNama();
		$asn            = $query->row();
		$dokumen         	= $this->simpeg->getDokumen();
		$pesan           = '';

		$this->setLayout('simpeg/tambah');

		$this->render('', ['nip_baru' => $nip_baru, 'asn' => $asn, 'nm_pangkat' => $nm_pangkat, 'nama_jabatan' => $jabatan, 'nm_unitkerja' => $nm_unitkerja, 'pesan' => $pesan, 'pasphoto' => $id_pasphoto, 'dokumen' => $dokumen]);
	}


	public function kirimUsul()
	{

		$cekSudahUsul		 = $this->simpeg->cekSudahUsul();

		if ($cekSudahUsul == NULL) {

			$this->simpeg->tambahUsulIDCard();
			// header menu message
			$nip_baru		 = $this->simpeg->getNipbaru();
			$nm_pangkat		 = $this->simpeg->getPangkat();
			$jabatan		 = $this->simpeg->getJabatan();
			$nm_unitkerja		 = $this->simpeg->getNamaPerangkatDaerah();
			$id_pasphoto		 = $this->simpeg->getIDPasPhoto();
			$query      =  $this->simpeg->getNama();
			$asn            = $query->row();
			$dokumen         	= $this->simpeg->getDokumen();
			$pesan           = '!!! BERHASIL DITAMBAH !!!';

			$this->setLayout('simpeg/tambah');

			$this->render('', ['nip_baru' => $nip_baru, 'asn' => $asn, 'nm_pangkat' => $nm_pangkat, 'nama_jabatan' => $jabatan, 'nm_unitkerja' => $nm_unitkerja, 'pesan' => $pesan, 'pasphoto' => $id_pasphoto, 'dokumen' => $dokumen]);
		} else {

			// header menu message
			$nip_baru		 = $this->simpeg->getNipbaru();
			$nm_pangkat		 = $this->simpeg->getPangkat();
			$jabatan		 = $this->simpeg->getJabatan();
			$nm_unitkerja		 = $this->simpeg->getNamaPerangkatDaerah();
			$id_pasphoto		 = $this->simpeg->getIDPasPhoto();
			$query      =  $this->simpeg->getNama();
			$asn            = $query->row();
			$dokumen         	= $this->simpeg->getDokumen();
			$pesan           = '!!! SUDAH ADA YANG DIUSUL !!!';

			$this->setLayout('simpeg/tambah');

			$this->render('', ['nip_baru' => $nip_baru, 'asn' => $asn, 'nm_pangkat' => $nm_pangkat, 'nama_jabatan' => $jabatan, 'nm_unitkerja' => $nm_unitkerja, 'pesan' => $pesan, 'pasphoto' => $id_pasphoto, 'dokumen' => $dokumen]);
		}
	}


	public function deleteUsul()
	{
		$id   = $this->uri->segment(3);

		$this->simpeg->delete($id);

		redirect('simpeg/tambahUsulIDCard');
	}


	public function pasPhotoBKPSDM()
	{

		$this->setLayout('simpeg/pasPhotoBKPSDM');
		$dokumen         	= $this->simpeg->getDokumenBKPSDM();
		$pesan           = '';

		$this->render('', ['pesan' => $pesan, 'dokumen' => $dokumen]);
	}


	//tambah usul idcard
	public function prosesPasPhoto()
	{
		$id   = $this->uri->segment(3);
		// header menu message
		$nip_baru		 = $this->simpeg->getNipbaruAdminIdCard($id);
		$id_pasphoto		 = $this->simpeg->getIDPasPhotoAdminIdCard($id);
		$query      =  $this->simpeg->getNamaAdminIdCard($id);
		$asn            = $query->row();
		$dokumen         	= $this->simpeg->getDokumen();
		$pesan           = '';

		$this->setLayout('simpeg/prosesPasPhoto');

		$this->render('', ['nip_baru' => $nip_baru, 'asn' => $asn, 'pesan' => $pesan, 'pasphoto' => $id_pasphoto, 'dokumen' => $dokumen, 'idusul' => $id]);
	}


	public function kirimProsesPasPhoto()
	{
		$id   = $this->uri->segment(3);

		$this->simpeg->updateUsulIdCard($id);

		redirect('simpeg/pasPhotoBKPSDM');
	}

	public function usulPasPhotoSelesai()
	{

		$this->setLayout('simpeg/usulPasPhotoSelesai');
		$dokumen         	= $this->simpeg->getDokumenBKPSDMSelesai();
		$pesan           = '';

		$this->render('', ['pesan' => $pesan, 'dokumen' => $dokumen]);
	}
}
