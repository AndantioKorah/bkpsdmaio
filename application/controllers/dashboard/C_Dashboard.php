<?php

class C_Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard/M_Dashboard', 'dashboard');
        $this->load->model('master/M_Master', 'master');
        $this->load->model('general/M_General', 'general');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function dashboard(){
        $data['list_skpd'] = $this->master->getAllUnitKerja();
        render('dashboard/V_Dashboard', '', '', $data);
    }

    public function loadDataSkpdDashboard($id_skpd = '4018000'){
        if(!$this->general_library->isWalikota() && !$this->general_library->isSetda()){
            $id_skpd = $this->general_library->getUnitKerjaPegawai();
        }
        $this->session->set_userdata('dashboard_id_skpd', $id_skpd);
        $data['list_bidang'] = $this->dashboard->getBidangBySkpd($id_skpd);
        $data['data_skpd'] = $this->dashboard->getDataSkpd($id_skpd);
        if($this->general_library->isKabid()){
            $data['bidang'] = $this->master->getBidangById($this->general_library->getBidangUser());
        }
        $this->load->view('dashboard/V_DataSkpdDashboard', $data);
    }

    public function searchDataDashboard(){
        $params = $this->input->post();
        $params['skpd'] = $this->session->userdata('dashboard_id_skpd');
        if(!$this->general_library->isWalikota() && !$this->general_library->isSetda()){
            $params['skpd'] = $this->general_library->getUnitKerjaPegawai();
        }
        $data['data_dashboard'] = $this->dashboard->getDataDashboard($params);
        $this->load->view('dashboard/V_DataDashboard', $data);
    }

    public function loadSubBidangByBidang($id){
        echo json_encode($this->dashboard->loadSubBidangByBidang($id));
    }

    public function loadBidangByUnitKerja($id){
        echo json_encode($this->dashboard->loadBidangByUnitKerja($id));
    }

    public function dashboardWalikota(){
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        $data['agenda'] = $this->general->getOne('db_sip.agenda', 'id', 11, 0);
        $data['golongan'] = [
            1 => [
                'id_golongan' => 'golongan_1',
                'nm_golongan' => 'Golongan I'
            ],
            2 => [
                'id_golongan' => 'golongan_2',
                'nm_golongan' => 'Golongan II'
            ],
            3 => [
                'id_golongan' => 'golongan_3',
                'nm_golongan' => 'Golongan III'
            ],
            4 => [
                'id_golongan' => 'golongan_4',
                'nm_golongan' => 'Golongan IV'
            ],
            5 => [
                'id_golongan' => 'golongan_5',
                'nm_golongan' => 'Golongan V'
            ],
            6 => [
                'id_golongan' => 'golongan_7',
                'nm_golongan' => 'Golongan VII'
            ],
            7 => [
                'id_golongan' => 'golongan_9',
                'nm_golongan' => 'Golongan IX'
            ],
            8 => [
                'id_golongan' => 'golongan_10',
                'nm_golongan' => 'Golongan X'
            ],
        ];
        $data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['unitkerja'] = $this->m_general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        render('dashboard/V_DashboardWalikota', '', '', $data);
    }

    public function getDataLiveAbsen($id_agenda){
        list($data['result'], $data['agenda']) = $this->dashboard->getDataLiveAbsen($id_agenda);
        $this->load->view('dashboard/V_DashboardLiveAbsen', $data);
    }

    public function dashboardPdm(){
        if(isKasubKepegawaian($this->general_library->getNamaJabatan())){
            $data['unitkerja'] = $this->m_general->getGroupUnitKerja($this->general_library->getUnitKerjaPegawai());
        } else {
            $data['unitkerja'] = $this->m_general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        }
        render('dashboard/V_DashboardPdm', '', '', $data);
    }

    public function searchDataPdm(){
        $uk = $this->input->post('unitkerja');
        $data['result'] = $this->dashboard->getDataDetailDashboardPdm($this->input->post());
        if($uk == 0){
            $this->session->set_userdata('data_dashboard_pdm', $data['result']);
            $this->load->view('dashboard/V_DashboardPdmDetailAll', $data);
        } else {
            $this->load->view('dashboard/V_DashboardPdmDetail', $data);
        }
    }

    public function getDashboardPdmAll(){
        $param['unitkerja'] = 0;
        $data['result'] = $this->dashboard->getDataDetailDashboardPdm($param);
        $this->session->set_userdata('data_dashboard_pdm', $data['result']);
        $this->load->view('dashboard/V_DashboardPdmDetailAll', $data);
    }

    public function downloadDataPdm(){
        $data['result'] = $this->session->userdata('data_dashboard_pdm');
        function sortByPresentase($a, $b) {
            if ($a['presentase'] < $b['presentase']) {
                return 1;
            } elseif ($a['presentase'] > $b['presentase']) {
                return -1;
            }
            return 0;
        }
        usort($data['result'], 'sortByPresentase');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'Legal-P',
            'debug' => true
        ]);
        $html = $this->load->view('dashboard/V_DashboardPdmDetailAllPdf', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->showImageErrors = true;
        $mpdf->Output('Data Progress PDM Siladen ASN Kota Manado '.date('dmyhis').'.pdf', 'D');
        // $this->load->view('dashboard/V_DashboardPdmDetailAllPdf', $data);
    }

    public function downloadDataPdmExcel()
    {
        $data['result']  = $this->session->userdata('data_dashboard_pdm');
        $this->load->view('dashboard/V_DashboardPdmDetailAllExcel', $data);

    }

    public function dashboardKepegawaian(){
        $data['chart'] = $this->m_general->getDataChartDashboardAdmin();
        dd($data);
        render('dashboard/V_DashboardKepegawaian', '', '', $data);
	}

}
