<?php

class C_VerifTte extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
		// if (!$this->general_library->isNotMenu()) {
		// 	redirect('logout');
		// };
	}

	public function verifPdf($randomString){
		$exists = $this->general->getOne('t_file_ds', 'random_string', $randomString);
		$data['filepath'] = null;
		$data['filename'] = null;
		if($exists){
			$data['filepath'] = $exists['url'];
			$explode = explode("/", $data['filepath']);

			$data['filename'] = $explode[1];
		}
		renderVerifWhatsapp('kepegawaian/verif_pdf/V_VerifPdfQrResult', null, null, $data);
	}

	public function verifByFilePath(){
		$data['filePath'] = $this->input->post('filepath');
		$data['file_exists'] = 0;
		$data['result'] = null;
		// $data['result'] = json_decode('{"conclusion":"VALID","description":"Dokumen valid, Sertifikat yang digunakan terpercaya","signatureInformations":[{"id":"S-7293C9208A44C9D59DB39DB9EF891925EB4920422126F268869F279834314C90","signatureFormat":"PAdES-BASELINE-LT","signerName":"Hantek Production","signatureDate":"2024-03-23T06:56:15.000+00:00","fieldName":"bcs_ecs_1711176975957","reason":"Dokumen ini telah ditandatangani secara elektronik oleh Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado (Donald Franky Supit, SH, MH - NIP. 197402061998031008)","location":null,"certLevelCode":0,"signatureAlgorithm":null,"digestAlgorithm":null,"timestampInfomation":{"id":"T-2B8B0AB7E2DFAAE85DE9ACB74DB90981DEE59AA621B62B5F3E56EFC2D96DB3C3","signerName":"Timestamp Authority Badan Siber dan Sandi Negara","timestampDate":"2024-03-23T06:56:19.000+00:00"},"certificateDetails":[{"id":"C-8FB4AA74248B71653E0D1CC39E35E8E01BD0367544336BF001CCD83255693004","commonName":"Hantek Production","issuerName":"C=ID,O=Lembaga Sandi Negara,CN=OSD LU Kelas 2","serialNumber":"144656301014400895597368180697408544897187243902","notAfterDate":"2025-03-06T03:41:43.000+00:00","notBeforeDate":"2023-03-07T03:41:44.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","nonRepudiation"]},{"id":"C-2178095B3CC0F6FACB9E6F07FEECEE6327A89C6681AF43BA95126B68867D02B2","commonName":"OSD LU Kelas 2","issuerName":"C=ID,O=Lembaga Sandi Negara,CN=OSD LU Kelas 2","serialNumber":"7864311585651982248","notAfterDate":"2026-08-18T05:05:39.000+00:00","notBeforeDate":"2016-08-18T05:05:39.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","keyCertSign","crlSign"]}],"integrityValid":true,"certificateTrusted":true,"lastSignature":false}],"signatureCount":1}', true);
		$data['file_exists'] = 1;
		if(file_exists($data['filePath'])){
			$data['file_exists'] = 1;
			$base64file = convertToBase64($data['filePath']);
			$req = [
				'file' => $base64file
			];
			$data['result'] = json_decode($this->ttelib->verifPdf($req), true);
		}

		$this->load->view('kepegawaian/verif_pdf/V_VerifByFilePathResult', $data);
	}
}
