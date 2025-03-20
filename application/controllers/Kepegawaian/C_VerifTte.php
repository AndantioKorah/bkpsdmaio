<?php

class C_VerifTte extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
		$this->load->model('layanan/M_Layanan', 'layanan');
		// if (!$this->general_library->isNotMenu()) {
		// 	redirect('logout');
		// };
	}

	public function verifPdf($randomString){
		$exists = $this->general->getOne('t_file_ds', 'random_string', $randomString, 1);
		$data['filepath'] = null;
		$data['filename'] = null;
		if($exists){
			$data['filepath'] = $exists['url'];
			$explode = explode("/", $data['filepath']);

			$data['filename'] = $explode[count($explode)-1];
		}
		renderVerifWhatsapp('kepegawaian/verif_pdf/V_VerifPdfQrResult', null, null, $data);
	}

	public function createQr(){
		$data = $this->general_library->createQrTtePortrait();
		echo "<img src='data:image/png;base64, ".$data['data']['qrBase64']."' />";
	}

	public function verifByFilePath(){
		$data['filePath'] = $this->input->post('filepath');
		$data['file_exists'] = 0;
		$data['result'] = null;

		// comment 2 baris ini untuk testing
		// $data['result'] = json_decode('{"description":"Dokumen valid, Sertifikat yang digunakan terpercaya","conclusion":"VALID","signatureInformations":[{"location":null,"id":"S-DA488459670BC24346FC6D34383BBCFEABAEA72674485853F22A234E77099CDA","fieldName":"Signature2","signerName":"Anita Marlyneke Rorong","digestAlgorithm":null,"signatureAlgorithm":null,"signatureFormat":"PAdES-BASELINE-LT","certificateDetails":[{"id":"C-146CB0DEA8982C0ACB26F8BA423446530817BDFE225B8F36567559F0E61FCE4B","issuerName":"CN=BSRE CA DS G1,O=Badan Siber dan Sandi Negara,C=ID","notBeforeDate":"2025-02-11T03:47:41.000+00:00","notAfterDate":"2027-02-11T03:47:40.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","nonRepudiation"],"serialNumber":"103469054407937895595824792577336680464709350472","commonName":"Anita Marlyneke Rorong"},{"id":"C-4A3AB062C4D24F60417FA28F6543AC7151C9F1FDE5817BBE67F49C55CE5FFED5","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2022-11-21T04:01:16.000+00:00","notAfterDate":"2032-11-18T04:01:16.000+00:00","signatureAlgoritm":"RSA with SHA384","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"3606829878392572131","commonName":"BSRE CA DS G1"},{"id":"C-B5F36672FD7CFD401E01EF640B2FE61F816F32F447B280B76F536244CF42FCDF","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2018-08-28T04:55:22.000+00:00","notAfterDate":"2038-08-23T04:55:22.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"7979107799150453422","commonName":"Root CA Indonesia DS G1"}],"signatureDate":"2025-03-18T12:03:45.000+00:00","certLevelCode":0,"integrityValid":true,"certificateTrusted":true,"timestampInfomation":{"id":"T-FB43FC6BC351D3B06712C08B1B7FBA0314A5F7F23A83736075E2703194E3FEEA","signerName":"Timestamp Authority Badan Siber dan Sandi Negara","timestampDate":"2025-03-18T12:03:46.000+00:00"},"ltv":true,"lastSignature":false,"reason":"Dokumen ini telah ditandatangani secara elektronik oleh Plt. Sekretaris Badan Kepegawaian dan Pengembangan Sumber Daya Manusia melalui apikasi Siladen."},{"location":null,"id":"S-294543806FA2D63858AA3867700B7C58D7BD58B355E6A9A00769C6287170A8D2","fieldName":"esc_1742299503055","signerName":"Donald Franky Supit","digestAlgorithm":null,"signatureAlgorithm":null,"signatureFormat":"PAdES-BASELINE-LT","certificateDetails":[{"id":"C-E6C3F79CDDAF807DFAE6A7505D700737F3225350A998A6E31B1C145F35404976","issuerName":"CN=BSRE CA DS G1,O=Badan Siber dan Sandi Negara,C=ID","notBeforeDate":"2024-12-09T02:24:00.000+00:00","notAfterDate":"2026-12-09T02:23:59.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","nonRepudiation"],"serialNumber":"5224232783686818519337103963734102068745812172","commonName":"Donald Franky Supit"},{"id":"C-4A3AB062C4D24F60417FA28F6543AC7151C9F1FDE5817BBE67F49C55CE5FFED5","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2022-11-21T04:01:16.000+00:00","notAfterDate":"2032-11-18T04:01:16.000+00:00","signatureAlgoritm":"RSA with SHA384","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"3606829878392572131","commonName":"BSRE CA DS G1"},{"id":"C-B5F36672FD7CFD401E01EF640B2FE61F816F32F447B280B76F536244CF42FCDF","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2018-08-28T04:55:22.000+00:00","notAfterDate":"2038-08-23T04:55:22.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"7979107799150453422","commonName":"Root CA Indonesia DS G1"}],"signatureDate":"2025-03-18T12:05:03.000+00:00","certLevelCode":0,"integrityValid":true,"certificateTrusted":true,"timestampInfomation":{"id":"T-8C83E46CAFCFBE092C6DF5B3E55FC6B438E8E711FF8F03E7B7F7A003C0E575FB","signerName":"Timestamp Authority Badan Siber dan Sandi Negara","timestampDate":"2025-03-18T12:18:07.000+00:00"},"ltv":true,"lastSignature":false,"reason":"Dokumen ini telah ditandatangani secara elektronik oleh Kepala BKPSDM Kota Manado melalui apikasi Siladen."},{"location":null,"id":"S-0D137A055D5A176E58806EA33B96DD931D7AADC4F0A9CAAFF209A9265B6060C8","fieldName":"Signature1","signerName":"Heskia Elia Paulus","digestAlgorithm":null,"signatureAlgorithm":null,"signatureFormat":"PAdES-BASELINE-LT","certificateDetails":[{"id":"C-731A0D8B0661B45ACF668BA01816F8518B6DD6EAD411B55098433626384F1FA0","issuerName":"CN=BSRE CA DS G1,O=Badan Siber dan Sandi Negara,C=ID","notBeforeDate":"2025-03-03T03:09:24.000+00:00","notAfterDate":"2027-03-03T03:09:23.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","nonRepudiation"],"serialNumber":"496507347028026231055984307949052195904065105942","commonName":"Heskia Elia Paulus"},{"id":"C-4A3AB062C4D24F60417FA28F6543AC7151C9F1FDE5817BBE67F49C55CE5FFED5","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2022-11-21T04:01:16.000+00:00","notAfterDate":"2032-11-18T04:01:16.000+00:00","signatureAlgoritm":"RSA with SHA384","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"3606829878392572131","commonName":"BSRE CA DS G1"},{"id":"C-B5F36672FD7CFD401E01EF640B2FE61F816F32F447B280B76F536244CF42FCDF","issuerName":"C=ID,O=Kementerian Komunikasi dan Informatika,CN=Root CA Indonesia DS G1","notBeforeDate":"2018-08-28T04:55:22.000+00:00","notAfterDate":"2038-08-23T04:55:22.000+00:00","signatureAlgoritm":"RSA with SHA256","keyUsages":["digitalSignature","keyCertSign","crlSign"],"serialNumber":"7979107799150453422","commonName":"Root CA Indonesia DS G1"}],"signatureDate":"2025-03-18T12:02:21.000+00:00","certLevelCode":0,"integrityValid":true,"certificateTrusted":true,"timestampInfomation":{"id":"T-55DDC6BC969162C7A4BE4CEEA58CE5E40BC6FAC6513F42442D2711D0EFAA0F86","signerName":"Timestamp Authority Badan Siber dan Sandi Negara","timestampDate":"2025-03-18T12:15:29.000+00:00"},"ltv":true,"lastSignature":false,"reason":"Dokumen ini telah ditandatangani secara elektronik oleh Kepala Bidang Pengadaan, Pemberhentian dan Informasi melalui apikasi Siladen."}],"signatureCount":3}', true);
		// $data['file_exists'] = 1;

		if(file_exists($data['filePath'])){
			// comment ini untuk live
			$data['file_exists'] = 1;
			$base64file = convertToBase64($data['filePath']);
			$req = [
				'file' => $base64file
			];
			$data['result'] = json_decode($this->ttelib->verifPdf($req), true);

			if(isset($data['result']['signatureInformations'])){
				usort($data['result']['signatureInformations'], function($a,$b) {
					return $a['signatureDate'] <=> $b['signatureDate'];
				});
			}
		}

		$this->load->view('kepegawaian/verif_pdf/V_VerifByFilePathResult', $data);
	}
}
