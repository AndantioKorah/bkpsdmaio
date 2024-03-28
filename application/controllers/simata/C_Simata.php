<?php

class C_Simata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('simata/M_Simata', 'simata');
        $this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('general/M_General', 'general');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function masterIndikator(){
        $data['unsur'] = $this->simata->getMasterUnsurPenilaian();
        render('simata/V_MasterIndikator', '', '', $data);
    }

    public function getDataSubUnsurPenilaian()
    {
        $id = $this->input->post('id');
        $response   = $this->simata->getDataSubUnsurPenilaian($id);
        echo json_encode($response);
    }

    public function submitTambahIndikator()
	{ 
		echo json_encode( $this->simata->submitTambahIndikator());
	}

    public function loadListIndikator(){
        $data['sub_unsur'] = $this->simata->getMasterSubUnsurPenilaian();
        $data['result'] = $this->simata->getMasterIndikator();
        // dd($data['result']);
        $this->load->view('simata/V_MasterIndikatorItem', $data);
    }

    public function loadEditIndikator($id)
    {
		$data['indikator'] = $this->simata->getIndikator($id);
        $this->load->view('simata/V_EditIndikatorPenilaian', $data);
    }

    public function loadKriteriaPenilaian($id)
    {
		// $data['kriteria'] = $this->simata->getKriteriaPenilaian($id);
        $data['id_indikator'] = $id;
        $this->load->view('simata/V_KriteriaPenilaian', $data);
    }

    public function deleteData($id)
    {
        $this->simata->delete('id', $id, "db_simata.m_indikator_penilaian");
    }

    public function updateIndikator()
	{ 
		echo json_encode($this->simata->updateIndikator());
	}

    public function loadListKriteria($id){
        $data['result'] = $this->simata->getKriteriaPenilaian($id);
        $this->load->view('simata/V_KriteriaPenilaianItem', $data);
    }

    public function submitTambahKriteria()
	{ 
		echo json_encode( $this->simata->submitTambahKriteria());
	}


    public function updateKriteria()
    {
        // dd($_POST['id']);
        for ($count = 0; $count < count($_POST['id']); $count++) {
            $id = $_POST['id'][$count];
            $data = null;
            // dd($id);
            // dd($_POST['nm_kriteria'][$count]);
            if(isset($_POST['nm_kriteria'][$count])){
                $data['nm_kriteria'] = $_POST['nm_kriteria'][$count];
            }
            if(isset($_POST['skor'][$count])){
                $data['skor'] = $_POST['skor'][$count];
            }
           
            if($data){
                $result = $this->simata->updateKriteria($id, $data);
            }

        }

        echo json_encode($result);
    }

    public function deleteDataKriteria($id)
    {
        $this->simata->delete('id', $id, "db_simata.m_kriteria_penilaian");
    }


    public function masterInterval(){
        $data['unsur'] = $this->simata->getMasterUnsurPenilaian();
        render('simata/V_MasterInterval', '', '', $data);
    }


    public function submitTambahInterval()
	{ 
		echo json_encode( $this->simata->submitTambahInterval());
	}


    public function loadListInterval(){
        $data['sub_unsur'] = $this->simata->getMasterSubUnsurPenilaian();
        $data['result'] = $this->simata->getMasterInterval();
        // dd($data['result']);
        $this->load->view('simata/V_MasterIntervalItem', $data);
    }

    public function deleteDataInterval($id)
    {
        $this->simata->delete('id', $id, "db_simata.m_interval_penilaian");
    }

    public function updateInterval()
	{ 
		echo json_encode($this->simata->updateInterval());
	}

    public function jabatanTarget(){
     
        $data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
    
        render('simata/V_JabatanTarget', '', '', $data);

    }

    public function jabatanKosong(){
        $data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
        render('simata/V_JabatanKosong', '', '', $data);
    }

    public function loadListJabatanTarget(){
        $data['sub_unsur'] = $this->simata->getMasterSubUnsurPenilaian();
        $data['result'] = $this->simata->getMasterIndikator();
        
      
        $this->load->view('simata/V_MasterIndikatorItem', $data);
    }

    public function loadListPegawaiDinilai($id,$tab=null){
        $data['jabatan_adm'] = $this->simata->getNamaJabatanAdministrator();
        $data['jabatan_jpt'] = $this->simata->getNamaJabatanJpt();
        
       
        $data['jabatan_target'] = $this->simata->getJabatanTargetPegawai();
        // if($id == 0){
        //     $data['result_jpt'] = $this->simata->getPegawaiDinilaiToJpt($id=4018000);
        //     $data['result_adm'] = $this->simata->getPegawaiDinilaiToAdministrator($id=4018000);
        // } else {
            $data['result_jpt'] = $this->simata->getPegawaiDinilaiToJpt($id);
            $data['result_adm'] = $this->simata->getPegawaiDinilaiToAdministrator($id);
        
        $data['tab'] = $tab;
        $this->load->view('simata/V_JabatanTargetItem', $data);
    }
    

    public function loadListJabatanKosong($id){
        $tab=null;
        $data['tab'] = $tab;
        $data['result_jpt'] = $this->simata->loadListTalentaIx($id);
        $data['result_adm'] = $this->simata->loadListTalentaIx($id);
        $data['jabatan_target'] = $this->simata->getJabatanTargetPegawai();
        $data['jabatan_adm'] = $this->simata->getNamaJabatanAdministrator();
        $data['jabatan_jpt'] = $this->simata->getNamaJabatanJpt();
        // dd($data);
        $this->load->view('simata/V_JabatanKosongItem', $data);
    }

        public function submitJabatanTarget(){
           
    //    dd($this->input->post());
        // $this->simata->submitJabatanTarget();
        // redirect('mt/jabatan-target');
        echo json_encode( $this->simata->submitJabatanTarget());
        }

        public function deleteDataJabatanTarget($id)
        {
            $this->simata->delete('id', $id, "db_simata.t_penilaian");
        }


    
    public function penilaianKinerja(){
        $data['result'] = null;
        render('simata/V_PenilaianKinerja', '', '', $data);
    }

    public function loadListPegawaiPenilainKinerjaAdm($id=2){
        
        // $data['result'] = $this->simata->getPegawaiPenilaianKinerjaAdministratorGroupBy();  
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJpt($id); 
        
        $this->load->view('simata/V_PenilaianKinerjaItemJpt', $data);
    }

    public function loadListPegawaiPenilainKinerjaJpt($id){
        
        // $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJptGroupBy();  
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJpt($id); 
        $data['kode'] = $id;  
        $this->load->view('simata/V_PenilaianKinerjaItemJpt', $data);
    }

    public function loadModalPenilaianKinerja($id,$nip,$kode)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
        $data['kriteria_kinerja_1'] = $this->simata->getKriteriaKinerja1();
        $data['kriteria_kinerja_2'] = $this->simata->getKriteriaKinerja2();
        $data['kriteria_kinerja_3'] = $this->simata->getKriteriaKinerja3();
        $data['kriteria_kinerja_4'] = $this->simata->getKriteriaKinerja4();
        $data['kriteria_kinerja_5'] = $this->simata->getKriteriaKinerja5();
        // $data['id_t_penilaian'] = $id;
        $data['nilai_kinerja'] = $this->simata->getPegawaiNilaiKinerjaPegawai($nip);
        $data['kode'] = $kode; 
        $currentYear = date('Y'); 
        $previous1Year = $currentYear - 1;   
        $previous2Year = $currentYear - 2;                     
        $id_peg = $data['profil_pegawai']['id_peg'];
        $data['kinerja_n_1'] = $this->simata->getPenilaianKinerja($id_peg,$previous1Year,1);
        $data['kinerja_n_2'] = $this->simata->getPenilaianKinerja($id_peg,$previous2Year,2);
        $data['inovasi'] = $this->simata->getInovasiPegawai($id_peg);
        $data['timkerja'] = $this->simata->getPengalamanTimPegawai($id_peg);
        $eselonpegawai = $data['profil_pegawai']['eselon']; 
        $data['penugasan'] = $this->simata->getPenugasanPengawai($id_peg,$eselonpegawai);

        $this->load->view('simata/V_ModalPenilaianKinerja', $data);
    }


    public function submitPenilaianKinerja()
	{ 
		echo json_encode( $this->simata->submitPenilaianKinerja());
	}

    public function nineBox(){
        
       
        $data['post']=null;
        $data['result']=null;
        $data['jt_adm'] = null;
        $data['jt_jpt'] = null;
        // $data['jabatan_target_adm'] = $this->simata->getJabatanTargetNineBoxAdm();
        $data['jabatan_target_adm'] = $this->simata->getJabatanTargetNineBoxJpt();
        $data['jabatan_target_jpt'] = $this->simata->getJabatanTargetNineBoxJpt();
        if($_POST) {
        $data['post'] = $_POST;
       
        if($_POST['jenis_jabatan'] == 2){
            $data['result'] = $this->simata->getPenilaianPegawaiJpt();
            $data['jt_jpt'] = $_POST['jabatan_target_jpt'];
            $data['jabatan_target'] = $this->simata->getJabatanTargetNineBoxJpt();
        } else {
            $data['jt_jpt'] = $_POST['jabatan_target_jpt'];
            $data['result'] = $this->simata->getPenilaianPegawaiAdm();
            // $data['result'] = $this->simata->getPenilaianPegawaiAdm();
            $data['jabatan_target'] = $this->simata->getJabatanTargetNineBoxAdm();
        }
        }
        // dd($data['result']);      
        render('simata/V_ChartNineBox', '', '', $data);
    }

    public function getPenilaianPegawai()
	{ 
		echo json_encode($this->simata->getPenilaianPegawai());
	}


    public function penilaianPotensial(){
        $data['result'] = null;
        render('simata/V_PenilaianPotensial', '', '', $data);
    }


    public function loadListPegawaiPenilainPotensialAdm(){
        
        $data['result'] = $this->simata->getPegawaiPenilaianPotensialAdministrator();  
        $this->load->view('simata/V_PenilaianPotensialItem', $data);
    }

    public function loadListPegawaiPenilainPotensialJpt($id){
       
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJpt($id);  
        $data['kode'] = $id;  
        $this->load->view('simata/V_PenilaianPotensialItemJpt', $data);
    }

    public function loadModalPenilaianPotensial($id,$nip,$kode)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
        $data['list_pendidikan_formal'] = $this->simata->getKriteriaPotensial(26);
        $data['pangkat_gol'] = $this->simata->getKriteriaPotensial(27);
        $data['masa_kerja_jabatan'] = $this->simata->getKriteriaPotensial(28);
        $data['diklat'] = $this->simata->getKriteriaPotensial(29);
        $data['kompetensi20_jp'] = $this->simata->getKriteriaPotensial(30);
        $data['penghargaan'] = $this->simata->getKriteriaPotensial(31);
        $data['riwayat_hukdis'] = $this->simata->getKriteriaPotensial(32);
        $data['pengalaman_org'] = $this->simata->getKriteriaPotensial(33);
        $data['aspirasi_karir'] = $this->simata->getKriteriaPotensial(34);
        $data['asn_ceria'] = $this->simata->getKriteriaPotensial(35);
      
        $id_peg = $data['profil_pegawai']['id_peg'];
        $eselonpegawai = $data['profil_pegawai']['eselon']; 
        $jabatanpegawai = $data['profil_pegawai']['nama_jabatan']; 
        $eselonidpegawai = $data['profil_pegawai']['eselon']; 
       
        $data['id_t_penilaian'] = $id;
        $data['jabatan_target'] = null;
        $data['nilai_potensial'] = $this->simata->getPegawaiNilaiPotensialPegawai($nip);
        $data['nilai_assesment'] = $this->simata->getNilaiAssesment($id_peg);
        $data['pendidikan_formal'] = $this->simata->getPendidikanFormal($id_peg);
        $data['id_penghargaan'] = $this->simata->getPenghargaan($id_peg);
        $data['jp_kompetensi'] = $this->simata->getJPKompetensi($id_peg);
        // $eselonjt = $this->simata->getEselonJT($jt);
        $data['pangkatgol'] = $this->simata->getPangkatGolPengawai($id_peg,$kode);
        $data['porganisasi'] = $this->simata->getPengalamanOrganisasiPengawai($id_peg);
        $data['dklt'] = $this->simata->getDiklatPengawai($id_peg,$kode,$eselonpegawai,$jabatanpegawai);
        $data['hukdis'] = $this->simata->getHukdisPengawai($id_peg);
        $data['masa_kerja'] = $this->simata->getMasaKerjaJabatan($id_peg,$kode,$eselonpegawai);
        // dd($data['masa_kerja']);
        $data['kode'] = $kode;  
       
        $this->load->view('simata/V_ModalPenilaianPotensial', $data);
    }

    public function submitPenilaianPotensialCerdas()
	{ 
		echo json_encode( $this->simata->submitPenilaianPotensialCerdas());
	}

    public function submitPenilaianPotensialRj()
	{ 
		echo json_encode( $this->simata->submitPenilaianPotensialRj());
	}

    public function submitPenilaianPotensialLainnya()
	{ 
		echo json_encode( $this->simata->submitPenilaianPotensialLainnya());
	}

    public function loadChartNineBox(){

        $data['result'] = $this->simata->getPenilaianPegawai();
        $this->load->view('simata/V_ChartNineBox', $data);
    }


    public function loadDetailNineBox($jenis_jab,$jt,$box,$jumlah)
    {
      
        $data['result'] = null;
        $data['kotak']=null;
        if($jumlah > 0){
        $data['result'] = $this->simata->getPegawaiPenilaianDetailNinebox($jenis_jab,$jt,$box,$jumlah);  
        $data['kotak']=$box;    
        } 
        $data['jt'] = $jt;
        
        $this->load->view('simata/V_DetailNineBox', $data);
    }

    public function profilTalenta(){
        $data['result'] = null;
        render('simata/V_ProfilTalenta', '', '', $data);
    }


    public function loadListProfilTalentaAdm($id){
        $data['result'] = $this->simata->loadListProfilTalentaAdm($id);  
        $data['jenis_jabatan'] = $id;
        if($id == 1){
            $this->load->view('simata/V_ProfilTalentaAdmList', $data);
        } else {
            $this->load->view('simata/V_ProfilTalentaJptList', $data);

        }
        
    }


    public function loadModalDetailProfilTalenta($id,$nip,$kode,$jt)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
       
       
        $id_peg = $data['profil_pegawai']['id_peg'];
             
        $data['id_t_penilaian'] = $id;
        $data['jabatan_target'] = $jt;
        $data['nilai_potensial'] = $this->simata->getPegawaiNilaiPotensialPT($nip,$jt);
        $data['nilai_kinerja'] = $this->simata->getPegawaiNilaiKinerjaPT($nip);
        $data['nilai_assesment'] = $this->simata->getNilaiAssesment($id_peg);
        $data['kode'] = $kode;  
        $this->load->view('simata/V_ModalDetailProfilTalenta', $data);
    }



    public function masterJabatan(){
        $data['unit_kerja'] = $this->kepegawaian->getAllWithOrder('db_pegawai.unitkerja', 'id_unitkerja', 'asc');        
        render('simata/V_MasterJabatan', '', '', $data);
    }

    public function loadListMasterJabatan($id){
        $data['jabatan'] = $this->simata->getMasterJabatan($id);
        // dd($data);
        $this->load->view('simata/V_MasterJabatanItem', $data);
    }

    public function loadFormTambahRumpun($id)
    {
        $data['id_jabatan'] = $id;
        $data['rumpun_jabatan'] = $this->kepegawaian->getAllWithOrder('db_simata.m_rumpun_jabatan', 'id', 'asc');
        $this->load->view('simata/V_ModalFormTambahRumpun', $data);
    }

    public function submitTambahRumpunJabatan()
	{ 
		echo json_encode( $this->simata->submitTambahRumpunJabatan());
	}

    public function loadListRumpunJabatan($id){
        $data['result'] = $this->simata->getListRumpunJabatan($id);
        $this->load->view('simata/V_ListRumpunJabatan', $data);
    }

    public function deleteRumpunJabatan($id)
    {
        $this->simata->delete('id', $id, "db_simata.t_rumpun_jabatan");
    }

    public function rumpun($search = ''){
        $data['search'] = urldecode($search);
        $data['rumpun'] = $this->kepegawaian->getAllWithOrder('db_simata.m_rumpun_jabatan', 'id', 'asc');        
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        render('simata/V_RumpunJabatan', '', '', $data);
    }

    public function searchRumpunJabatan(){
        $data['result']= $this->simata->searchRumpunJabatan($this->input->post());
        $this->session->set_userdata('data_search_database', $data);
        $this->load->view('simata/V_RumpunJabatanResult', $data);
    }


    public function penilaianKompetensi(){
        $data['post']=null;
        $data['result']=null;
        $data['jt_adm'] = null;
        $data['jt_jpt'] = null;
        $data['jabatan_target_adm'] = $this->simata->getJabatanTargetNineBoxAdm();
        $data['jabatan_target_jpt'] = $this->simata->getJabatanTargetNineBoxJpt();
        if($_POST) {
        $data['post'] = $_POST;
        if($_POST['jenis_jabatan'] == 1){
            $data['result'] = $this->simata->getPenilaianPegawaiAdm();
            $data['jt_adm'] = $_POST['jabatan_target_adm'];
            $data['jabatan_target'] = $this->simata->getJabatanTargetNineBoxAdm();
        } else {
            $data['jt_jpt'] = $_POST['jabatan_target_jpt'];
            $data['result'] = $this->simata->getPenilaianPegawaiJpt();
            $data['jabatan_target'] = $this->simata->getJabatanTargetNineBoxJpt();
        }
        }
        render('simata/V_PenilaianKompetensi', '', '', $data);
    }

    public function loadListSuksesor($jenis_jabatan,$jabatan_target_jpt,$jabatan_target_adm,$jp){
        $data['result'] = $this->simata->getSuksesor($jenis_jabatan,$jabatan_target_jpt,$jabatan_target_adm,$jp);
        $data['jenis_jabatan'] = $jenis_jabatan;
        $this->session->set_userdata('data_rencana_suksesi', $data);
        $this->load->view('simata/V_PenilaianKompetensiItem', $data);
    }

    public function loadModalPenilaianKompetensi($id,$nip,$kode,$jt)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
        $data['kriteria_potensi_1'] = $this->simata->getKriteriaKompetensi1();
        $data['kriteria_potensi_2'] = $this->simata->getKriteriaKompetensi2();
        $data['jabatan_target'] = $jt;
        $data['id_t_penilaian'] = $id;
        $id_peg = $data['profil_pegawai']['id_peg'];
        $data['nilai_kompetensi'] = $this->simata->getPegawaiNilaiKompetensiPegawai($id_peg,$jt);
        $data['kode'] = $kode; 
                        
       
        
        $this->load->view('simata/V_ModalPenilaianKompetensi', $data);
    }

    public function submitPenilaianKompetensi()
	{ 
		echo json_encode( $this->simata->submitPenilaianKompetensi());
	}

    public function downloadDataSearch($flag_excel = 0){
        $data = $this->session->userdata('data_rencana_suksesi');
        // $this->load->view('simata/V_RencanaSuksesiPdf', $data);
        if($flag_excel == 0){
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-P',
                'debug' => true
            ]);
            $html = $this->load->view('simata/V_RencanaSuksesiPdf', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output('Rencana Suksesi '.$data['result'][0]['nama_jabatan'].' Kota Manado .pdf', 'D');
        } else {
            $this->load->view('user/V_RencanaSuksesiExcel', $data);
        }
    }

    

    






    

   
}
