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
		$this->load->model('user/M_User', 'user');
		       
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
		list($data['id_t_checklist_pensiun'], $data['data_checklist_pensiun']) = $this->layanan->updateChecklistPensiun($nip, $data['berkas'], 1);
		$data['progress'] = $this->layanan->getProgressChecklistPensiun($data['id_t_checklist_pensiun']);

		$this->session->set_userdata('berkas_pensiun', $data);
		render('kepegawaian/V_KelengkapanBerkasPensiun', '', '', $data);
	}

	public function loadBerkasPensiun($berkas){
		$temp = $this->session->userdata('berkas_pensiun');
		$data['nip'] = $temp['nip'];
		$data['id_t_checklist_pensiun'] = $temp['id_t_checklist_pensiun'];
		$data['result'] = null;
		$data['berkas'] = $berkas;
		$data['progress'] = $this->layanan->getProgressChecklistPensiun($data['id_t_checklist_pensiun']);
		if($temp['berkas'][$berkas]){
			if($berkas == 'akte_anak' || $berkas == 'akte_nikah'){
				$data['result'] = $temp['berkas'][$berkas];
			} else {
				$data['result'][] = $temp['berkas'][$berkas];
			}
		}

		$data['url'] = null;
		$data['jenis_berkas'] = $berkas;
		if($data['result']){
			foreach($data['result'] as $dr){
				if($dr['gambarsk']){
					if($berkas == 'cpns' || $berkas == 'pns'){
						$data['url'][] = base_url()."arsipberkaspns/".$dr['gambarsk'];
					} else if($berkas == 'skp'){
						$data['url'][] = base_url()."arsipskp/".$dr['gambarsk'];
					} else if($berkas == 'sk_pangkat') {
						$data['url'][] = base_url()."arsipelektronik/".$dr['gambarsk'];
					} else if($berkas == 'sk_jabatan') {
						$data['url'][] = base_url()."arsipjabatan/".$dr['gambarsk'];
					} else if($berkas == 'akte_anak') {
						$data['url'][] = base_url()."arsipkeluarga/".$dr['gambarsk'];
					} else {
						$data['url'][] = base_url()."arsiplain/".$dr['gambarsk'];
					}
				}
			}
		}
		$this->load->view('kepegawaian/V_KelengkapanBerkasPensiunShowFile', $data);
	}

	public function validasiBerkas($nip, $berkas, $id){
		echo json_encode($this->layanan->validasiBerkas($nip, $berkas, $id));
	}

	public function batalValidasiBerkas($berkas, $id){
		echo json_encode($this->layanan->batalValidasiBerkas($berkas, $id));
	}

	public function simpanDataLainnya($id){
		echo json_encode($this->layanan->simpanDataLainnya($id));
	}

	public function createDpcp($nip){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['berkas'] = $this->layanan->getKelengkapanBerkas($nip, 1);
		$data['berkas']['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($data['profil_pegawai']['id_peg']); 
		$data['berkas']['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiunAdmin($data['profil_pegawai']['id_peg']);
		$data['nip'] = $nip; 
		list($data['id_t_checklist_pensiun'], $data['data_checklist_pensiun']) = $this->layanan->updateChecklistPensiun($nip, $data['berkas'], 1);
		$data['progress'] = $this->layanan->getProgressChecklistPensiun($data['id_t_checklist_pensiun']);
		
		echo json_encode($this->layanan->createDpcp($data));
	}

	public function showDpcp($id){
		// $data['result'] = $this->layanan->getDpcpData($id);
		$data['id'] = $id;
		$this->load->view('kepegawaian/V_ShowDpcpData', $data);
	}

	public function loadBerkasPensun($id, $jenis){
		$data['jenis_file'] = $jenis;
		$data['result'] = $this->layanan->getDpcpData($id);
		$this->load->view('kepegawaian/V_ShowDpcpDataDetail', $data);
	}

	public function deleteBerkasPensiun($id){
		echo json_encode($this->layanan->deleteBerkasPensiun($id));
	}

	public function penomoranDokumenPensiun(){
		$data['unitkerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        render('kepegawaian/layanan/V_PenomoranDokumenPensiun', '', '', $data);
	}

	public function searchPenomoranDokumenPensiun(){
		$data['result'] = $this->layanan->searchPenomoranDokumenPensiun($this->input->post());
		$this->load->view('kepegawaian/layanan/V_PenomoranDokumenPensiunData', $data);
	}

	public function openModalPenomoranDokumenPensiun($id){
		$data['result'] = $this->layanan->loadDetailPenomoranDokumenPensiun($id);
		$this->load->view('kepegawaian/layanan/V_PenomoranDokumenPensiunDetail', $data);
	}
	
	public function saveUploadFileDsPenomoranDokumenPensiun($id){
        echo json_encode($this->layanan->saveUploadFileDsPenomoranDokumenPensiun($id));
	}

	public function deleteFileDsManual($id){
        echo json_encode($this->layanan->deleteFileDsManual($id));
	}
	
	public function openModalNotifPegawaiDpcp($nip){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		
		$data['message'] = "*[ADMINISTRASI KEPEGAWAIAN - PENSIUN]*"."\nSelamat ".greeting().",\nYth. ".getNamaPegawaiFull($data['profil_pegawai']).
					", silahkan mendatangi Kantor BKPSDM untuk melakukan penandatanganan dokumen Data Perorangan Calon Penerima Pensiun (DPCP) .".FOOTER_MESSAGE_CUTI;
		
		$this->load->view('kepegawaian/V_KelengkapanBerkasModalNotif', $data);
	}

	public function openModalNotifPegawai($nip){
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
		$data['berkas'] = $this->layanan->getKelengkapanBerkas($nip, 1);
		
		$messages = "*[ADMINISTRASI KEPEGAWAIAN - PENSIUN]*"."\nSelamat ".greeting().",\nYth. ".getNamaPegawaiFull($data['profil_pegawai']).
					", saat ini operator sedang melakukan verifikasi dokumen-dokumen kepegawaian Anda untuk keperluan pensiun. ";
		
		$listBerkasKosong = null;

		if(!$data['berkas']['cpns']){
			$listBerkasKosong[] = "SK CPNS";
		}

		if(!$data['berkas']['pns']){
			$listBerkasKosong[] = "SK PNS";
		}

		if(!$data['berkas']['pmk']){
			$listBerkasKosong[] = "SK Peninjauan Masa Kerja (jika ada)";
		}

		if(!$data['berkas']['skp']){
			$listBerkasKosong[] = "Sasaran Kerja Pegawai";
		}

		if(!$data['berkas']['akte_nikah']){
			$listBerkasKosong[] = "Akte Perkawinan";
		}

		if(!$data['berkas']['akte_cerai']){
			$listBerkasKosong[] = "Akte Cerai";
		}

		if(!$data['berkas']['akte_anak']){
			$listBerkasKosong[] = "Akte Anak";
		}

		if(!$data['berkas']['akte_kematian']){
			$listBerkasKosong[] = "Akte Kematian";
		}

		if(!$data['berkas']['kartu_keluarga']){
			$listBerkasKosong[] = "Kartu Keluarga";
		}

		if(!$data['berkas']['ktp']){
			$listBerkasKosong[] = "Kartu Tanda Penduduk (KTP)";
		}

		if(!$data['berkas']['npwp']){
			$listBerkasKosong[] = "NPWP";
		}

		if($listBerkasKosong){
			$messages .= "\n\n*Silahkan lengkapi dokumen-dokumen berikut agar proses pengurusan dokumen pensiun Anda tidak terhambat*";
			foreach($listBerkasKosong as $lb){
				$messages .= "\n"."- ".$lb;
			}
		}

		$messages .= FOOTER_MESSAGE_CUTI;

		$data['message'] = $messages;
		$this->load->view('kepegawaian/V_KelengkapanBerkasModalNotif', $data);
	}

	public function sendNotif(){
		echo json_encode($this->layanan->sendNotif());
	}

	public function usulDs(){
		$data['layanan_ds'] = $this->general->getAllWithOrder('m_jenis_layanan', 'nama_layanan', 'asc');
        render('kepegawaian/layanan/V_UsulDs', '', '', $data);
    }

	public function removeAllUploadedFileDs(){
		$this->layanan->removeUploadedFileDs("0");
		$this->session->set_userdata('uploaded_file_usul_ds_'.$this->general_library->getId(), null);
	}

	public function getSelectedFile(){
		$result['data'] = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());
		$result['count'] = $result['data'] ? count($result['data']) : 0;

		echo json_encode($result);
	}

	public function removeUploadedFileDs(){
		$filename = $this->input->post('filename');
		$this->layanan->removeUploadedFileDs($filename);
		$uploadedFile = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());
		unset($uploadedFile[$filename]);
	}

	public function uploadFileUsulDs(){
		// $file = $_FILES['file'];
		// // $data = $this->input->post();
		// $uploadedFile = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());

		// $uploadedFile[$file['name']] = $file;
		// $this->session->set_userdata('uploaded_file_usul_ds_'.$this->general_library->getId(), $uploadedFile);
		
		echo json_encode($this->layanan->uploadFileUsulDs());

		// echo count($uploadedFile);
	}

	public function submitUploadFileUsulDs(){
		echo json_encode($this->layanan->submitUploadFileUsulDs($this->input->post()));
	}

	public function verifUsulDs(){
        render('kepegawaian/layanan/V_VerifUsulDs', '', '', null);
	}

	public function searchVerifUsulDs(){
		$data['result'] = $this->layanan->searchVerifUsulDs();
		$this->load->view('kepegawaian/layanan/V_VerifUsulDsData', $data);
	}

	public function loadAuthModalTteBulk(){
		$data['user'] = $this->general->getDataPegawai($this->general_library->getUserName());
		$data['jenis_layanan'] = 'Lainnya';
		$data['table_ref'] = 't_usul_ds_detail_progress';
		$this->load->view('kepegawaian/layanan/V_ModalAuthTteBulk', $data);
	}

	public function dsBulk(){
		echo json_encode($this->layanan->dsBulk($this->input->post()));
		// dd($this->input->post());
	}

	public function loadRiwayatUsulDs(){
		$this->load->view('kepegawaian/layanan/V_UsulDsRiwayat', null);
	}

	public function loadRiwayatUsulDsData(){
		$data['result'] = $this->layanan->loadRiwayatUsulDs();
		$this->load->view('kepegawaian/layanan/V_UsulDsRiwayatItem', $data);
	}

	public function tesCopy(){
		copy("arsipusulds/2025/Maret/yPeLwFNJMZ_Format_Surat_Pernyataan_Melaksanakan_Kegiatan_Tugas_JF.pdf", "arsipusulds/2025/Maret/yPeLwFNJMZ_Format_Surat_Pernyataan_Melaksanakan_Kegiatan_Tugas_JF_signed.pdf");
	}

	public function cronBulkDs(){
		$this->layanan->cronBulkDs();
	}

	public function loadDetailUsulDs($id){
		$data['result'] = $this->layanan->loadDetailUsulDs($id);
		$data['id'] = $id;
		$this->load->view('kepegawaian/layanan/V_UsulDsRiwayatDetail', $data);
	}

	public function downloadDoneFileUsulDs($id){
		$result = $this->layanan->loadDetailUsulDs($id);
		$listUrl = [];

		$zipName = "siladen/Usul_DS_".$result['batch_id'].".zip";

		$zip = new ZipArchive;
		$zip->open($zipName, ZipArchive::CREATE);
		if($result){
			foreach($result['detail'] as $rd){
				if($rd['flag_done'] == 1){
					$fileName = "SIGNED";

					$expl1 = explode("/", $rd['url_done']); 
					$expl2 = explode("_", $expl1[count($expl1)-1]);

					unset($expl2[0]);
					unset($expl2[1]);

					foreach($expl2 as $e){
						$fileName .= "_".$e;
					}

					$fileContent = file_get_contents($rd['url_done']);
					$zip->addFromString($fileName, $fileContent);
				}
			}
		}
		$zip->close();

		header('location: /'.$zipName);
	}

	public function loadProgressUsulDs($id){
		$data['result'] = $this->layanan->loadProgressUsulDs($id);
		$this->load->view('kepegawaian/layanan/V_UsulDsRiwayatDetailProgress', $data);
	}

	public function loadDetailUsulDsFile($id_t_usul_ds_detail, $id_t_usul_ds_detail_progress){
		$data['result'] = $this->layanan->loadDetailUsulDsFile($id_t_usul_ds_detail);
		$data['id_t_usul_ds_detail_progress'] = ($id_t_usul_ds_detail_progress);
		$this->load->view('kepegawaian/layanan/V_VerifUsulDsVerifikasi', $data);
	}

	public function verifUsulDsDetail($id, $flag_verif, $id_t_usul_ds_progress){
		echo json_encode($this->layanan->verifUsulDsDetail($id, $flag_verif, $id_t_usul_ds_progress));
	}

	public function deleteUsulDs($id){
		($this->layanan->deleteUsulDs($id));
		//hapus t_usul_ds, t_usul_ds_detail, t_usul_ds_detail_progress, t_request_ds, t_cron_request_ds
	}
	
	public function ajukanKembaliUsulDs($id){
		echo json_encode($this->layanan->ajukanKembaliUsulDs($id));
	}

	public function suratTugasEvent(){
		$data['list_unitkerja'] = $this->layanan->getListUnitKerjaBerjenjang();
		$data['list_pegawai'] = $this->layanan->getListPegawaiSuratTugasEvent($data['list_unitkerja']);
		$data['list_event'] = $this->general->getAllWithOrder('db_sip.event', 'tgl', 'asc');
		$this->session->set_userdata('upload_surat_tugas_event_'.$this->general_library->getId(), null);
		render('kepegawaian/layanan/V_SuratTugasEvent', '', '', $data);
	}

	public function uploadFileSuratTugasEvent(){
		echo json_encode($this->layanan->uploadFileSuratTugasEvent());
	}

	public function removeuploadSuratTugasEvent(){
		$filename = $this->input->post('filename');
		$this->layanan->removeuploadSuratTugasEvent($filename);
		$uploadedFile = $this->session->userdata('upload_surat_tugas_event_'.$this->general_library->getId());
		unset($uploadedFile[$filename]);
	}

	public function removeAllUploadFileSuratTugasEvent(){
		$this->layanan->removeuploadSuratTugasEvent("0");
		$this->session->set_userdata('upload_surat_tugas_event_'.$this->general_library->getId(), null);
	}

	public function getSelectedFileSuratTugasEvent(){
		$result['data'] = $this->session->userdata('upload_surat_tugas_event_'.$this->general_library->getId());
		$result['count'] = $result['data'] ? count($result['data']) : 0;

		echo json_encode($result);
	}
	
	public function submitUploadSuratTugasEvent(){
		echo json_encode($this->layanan->submitUploadSuratTugasEvent());
	}

	public function loadListSuratTugas(){
		$data['result'] = $this->layanan->loadListSuratTugas();
		$this->load->view('kepegawaian/layanan/V_SuratTugasEventList', $data);
	}

	public function deleteSuratTugasEvent($id){
		$this->layanan->deleteSuratTugasEvent($id);
	}

	public function loadDetailSuratTugasEvent($id){
		$data['result'] = $this->layanan->loadDetailSuratTugasEvent($id);
		$data['list_unitkerja'] = $this->layanan->getListUnitKerjaBerjenjang();
		$data['list_pegawai'] = $this->layanan->getListPegawaiSuratTugasEvent($data['list_unitkerja']);
		$this->load->view('kepegawaian/layanan/V_SuratTugasEventDetail', $data);
	}

	public function getListPegawaiEventDetail($id){
		$data['list_pegawai'] = $this->layanan->getListPegawaiEventDetail($id);
		$this->load->view('kepegawaian/layanan/V_SuratTugasEventDetailListPegawai', $data);
	}

	public function deletePegawaiSuratTugasEvent($id){
		echo json_encode($this->layanan->deletePegawaiSuratTugasEvent($id));
	}

	public function editSuratTugasEvent($id){
		echo json_encode($this->layanan->editSuratTugasEvent($id));
	}

}
