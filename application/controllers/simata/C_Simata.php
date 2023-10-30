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

    public function loadListPegawaiPenilainKinerjaAdm(){
        
        // $data['result'] = $this->simata->getPegawaiPenilaianKinerjaAdministratorGroupBy();  
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaAdministrator();  
        $this->load->view('simata/V_PenilaianKinerjaItem', $data);
    }

    public function loadListPegawaiPenilainKinerjaJpt(){
        
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJptGroupBy();  
        $data['result2'] = $this->simata->getPegawaiPenilaianKinerjaJpt();  
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
        $data['id_t_penilaian'] = $id;
        $data['nilai_kinerja'] = $this->simata->getPegawaiNilaiKinerjaPegawai($nip);
        $data['kode'] = $kode;  
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
        render('simata/V_NineBoxNew', '', '', $data);
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

    public function loadListPegawaiPenilainPotensialJpt(){
        
        $data['result'] = $this->simata->getPegawaiPenilaianKinerjaJpt();  
        $this->load->view('simata/V_PenilaianPotensialItemJpt', $data);
    }

    public function loadModalPenilaianPotensial($id,$nip,$kode,$jt)
    {
		$data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai($nip);
        $data['list_pendidikan_formal'] = $this->simata->getKriteriaPotensial(26);
        $data['pangkat_gol'] = $this->simata->getKriteriaPotensial(27);
        $data['masa_kerja_jabatan'] = $this->simata->getKriteriaPotensial(28);
        $data['diklat'] = $this->simata->getKriteriaPotensial(29);
        $data['kompetensi20_jp'] = $this->simata->getKriteriaPotensial(30);
        $data['penghargaan'] = $this->simata->getKriteriaPotensial(31);
        $data['riwayat_hukdis'] = $this->simata->getKriteriaPotensial(32);
        $id_peg = $data['profil_pegawai']['id_peg'];
             
        $data['id_t_penilaian'] = $id;
        $data['jabatan_target'] = $jt;
        $data['nilai_potensial'] = $this->simata->getPegawaiNilaiPotensialPegawai($nip,$jt);
        $data['nilai_assesment'] = $this->simata->getNilaiAssesment($id_peg);
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

    public function loadChartNineBox(){

        $data['result'] = $this->simata->getPenilaianPegawai();
        $this->load->view('simata/V_ChartNineBox', $data);
    }

    


    






    

   
}
