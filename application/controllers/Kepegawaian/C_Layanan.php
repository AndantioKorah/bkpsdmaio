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
		list($data['id_t_checklist_pensiun'], $data['data_checklist_pensiun']) = $this->layanan->updateChecklistPensiun($nip, $data['berkas'], 1);
		$data['progress'] = $this->layanan->getProgressChecklistPensiun($data['id_t_checklist_pensiun']);

		$kepalabkpsdm = $this->layanan->getKepalaBkpsdm();
		$randomString = generateRandomString(30, 1, 't_file_ds'); 
		$contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
		// dd($contentQr);
		$qr = generateQr($contentQr);
		$image_ds = explode("data:image/png;base64,", $qr);

		$data['dataQr']['user'] = $kepalabkpsdm;
		$data['dataQr']['qr'] = $qr;

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
		$data['berkas'] = $this->layanan->getKelengkapanBerkas($nip);
		$data['berkas']['sk_pangkat'] = $this->kepegawaian->getDokumenPangkatForPensiunAdmin($data['profil_pegawai']['id_peg']); 
		$data['berkas']['sk_jabatan'] = $this->kepegawaian->getDokumenJabatanForPensiunAdmin($data['profil_pegawai']['id_peg']);
		$data['nip'] = $nip; 
		list($data['id_t_checklist_pensiun'], $data['data_checklist_pensiun']) = $this->layanan->updateChecklistPensiun($nip, $data['berkas'], 1);
		$data['progress'] = $this->layanan->getProgressChecklistPensiun($data['id_t_checklist_pensiun']);

		echo json_encode($this->layanan->createDpcp($data));
	}

	public function tesQr(){
		function resizeImage($image, $w, $h){
			imagealphablending( $image, FALSE );
			imagesavealpha( $image, TRUE );
			$oldw = imagesx($image);
			$oldh = imagesy($image);
			$temp = imagecreatetruecolor($w, $h);
			imagealphablending( $temp, FALSE );
			imagesavealpha( $temp, TRUE );
			imagecopyresampled($temp, $image, 0, 0, 0, 0, $w, $h, $oldw, $oldh);

			return $temp;
		}

		function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
			// creating a cut resource
			$cut = imagecreatetruecolor($src_w, $src_h);
			$transparency = imagecolorallocatealpha($cut, 0, 0, 0, 127);
			imagefill($cut, 0, 0, $transparency);
			imagesavealpha($cut, true);
			
			// copying relevant section from background to the cut resource
			imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	
			// copying relevant section from watermark to the cut resource
			imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
			
			// insert cut resource to destination image
			imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
			
		}

		$kepalabkpsdm = $this->layanan->getKepalaBkpsdm();
		$randomString = generateRandomString(30, 1, 't_file_ds'); 
		$contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
		// dd($contentQr);
		$qr = generateQr($contentQr);
		// $image_ds = explode("data:image/png;base64,", $qr);
		$data['user'] = $kepalabkpsdm;
		$data['qr'] = $qr;

		list($type, $qr) = explode(';', $qr);
		list(, $qr)      = explode(',', $qr);
		$qrDecode = base64_decode($qr);

		$qrPath = 'arsipdpcp/qr/'.$randomString.'.png';
		file_put_contents($qrPath, $qrDecode);

		$image = imagecreatetruecolor(500, 500);   

		// $background_color = imagecolorallocate($image, 255, 255, 255);
		$transparency = imagecolorallocatealpha($image, 255,255,255, 127);
		imagefill($image, 0, 0, $transparency);
		imagesavealpha($image, true);

		$text_color = imagecolorallocate($image, 0, 0, 0);    
		$fonts = "assets/fonts/tahoma.ttf";

		imagettftext($image, 20, 0, 110, 380, $text_color, $fonts, getNamaPegawaiFull($data['user']));
		imagettftext($image, 20, 0, 110, 420, $text_color, $fonts, "NIP. ".$data['user']['nipbaru_ws']);

		$logoBsre = imagecreatefrompng("assets/img/logo-kunci-bsre-custom.png");
		$logoBsreHeight = 60;
		$logoBsreWidth = 60;
		imagealphablending( $logoBsre, FALSE );
		imagesavealpha( $logoBsre, TRUE );
		$resizedLogo = resizeImage($logoBsre, $logoBsreHeight, $logoBsreWidth);
		imagecopymerge_alpha($image, $resizedLogo, 45, 360, 0, 0, $logoBsreWidth, $logoBsreHeight, 100);

		$container_height = imagesy($image);
		$container_width = imagesx($image);
		$qrImage = imagecreatefrompng($qrPath);
		$qrImageMerge_height = imagesy($qrImage);
		$qrImageMerge_width = imagesx($qrImage);
		$qrImagePosX = ($container_width/2)-($qrImageMerge_width/2);
		$qrImagePosY = ($container_height/2)-($qrImageMerge_height/2)-70;
		// imagefilter($qrImage, IMG_FILTER_GRAYSCALE);
		// imagefilter($qrImage, IMG_FILTER_CONTRAST, -100);
		imagecopymerge_alpha($image, $qrImage, $qrImagePosX, $qrImagePosY, 0, 0, $qrImageMerge_width, $qrImageMerge_height, 100);

		ob_start();
		imagepng($image);
		$png = ob_get_clean();
		$uri = "data:image/png;base64," . base64_encode($png);
		echo "<img src='".$uri."' />";
	}
}
