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

    public function loadListPegawaiDinilai($id){
        $data['jabatan'] = $this->simata->getNamaJabatanAdministrator();
        // $data['result'] = $this->simata->getPegawaiDinilaiToAdministrator();
        $data['jabatan_target'] = $this->simata->getJabatanTargetPegawai();
        if($id == 0){
            $data['result'] = $this->simata->getPegawaiDinilaiToAdministrator($id=4018000);
           
        } else {
            $data['result'] = $this->simata->getPegawaiDinilaiToAdministrator($id);
        }
        $this->load->view('simata/V_JabatanTargetItem', $data);
    }

    public function submitJabatanTarget(){
    $this->simata->submitJabatanTarget();
    redirect('mt/jabatan-target');
    // echo json_encode( $this->simata->submitJabatanTarget());
    }

    public function deleteDataJabatanTarget($id)
    {
        $this->simata->delete('id', $id, "db_simata.t_penilaian");
    }


    

   
}
