<?php

class C_Simata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('simata/M_Simata', 'simata');
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
		$data['kriteria'] = $this->simata->getKriteriaPenilaian($id);
        $this->load->view('simata/V_KriteriaPenilaian', $data);
    }

    public function deleteData($id)
    {
        $this->simata->delete('id', $id, "db_simata.m_indikator_penilaian");
    }


   
}
