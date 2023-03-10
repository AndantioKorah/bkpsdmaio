<?php

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('master/M_Master', 'master');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function jenisPesan(){
        render('master/V_MasterJenispesan', '', '', null);
    }

    public function createMasterJenisPesan(){
        $data = $this->input->post();
        $data['created_by'] = $this->general_library->getId();
        $this->master->insert('m_jenis_pesan', $data);
    }

    public function loadJenisPesan(){
        $data['list_jenis_pesan'] = $this->general->getAllWithOrder('m_jenis_pesan');
        $this->load->view('master/V_MasterJenisPesanItem', $data);
    }

    public function deleteJenisPesan($id){
        $this->general->delete('id', $id, 'm_jenis_pesan');
    }

    public function masterBidang(){
        $data['list_unit_kerja'] = $this->master->getAllUnitKerja();
        $data['unit_kerja']['id_unitkerja'] = 0;
        $data['unit_kerja']['nm_unitkerja'] = '';
        if($this->general_library->getRole() != 'programmer'){
            $pegawai = $this->session->userdata('pegawai');
            foreach($data['list_unit_kerja'] as $duk){
                if($duk['id_unitkerja'] == $pegawai['skpd']){
                    $data['unit_kerja']['id_unitkerja'] = $duk['id_unitkerja'];
                    $data['unit_kerja']['nm_unitkerja'] = $duk['nm_unitkerja'];
                }
            }
        }
        render('master/V_MasterBidang', '', '', $data);
    }

    public function createMasterBidang(){
        $data = $this->input->post();
        $data['created_by'] = $this->general_library->getId();
        $this->master->insert('m_bidang', $data);
    }

    public function loadMasterBidang($id_unitkerja){
        $data['list_master_bidang'] = $this->master->loadMasterBidangByUnitKerja($id_unitkerja);
        $this->load->view('master/V_MasterBidangItem', $data);
    }

    public function deleteMasterBidang($id){
        $this->general->delete('id', $id, 'm_bidang');
    }

    public function loadBidangByUnitKerja($id_unitkerja){
        echo json_encode($this->master->loadMasterBidangByUnitKerja($id_unitkerja));
    }

    public function masterSubBidang(){
        $data['list_unit_kerja'] = $this->master->getAllUnitKerja();
        $data['unit_kerja']['id_unitkerja'] = 0;
        $data['unit_kerja']['nm_unitkerja'] = '';
        if($this->general_library->getRole() != 'programmer'){
            $pegawai = $this->session->userdata('pegawai');
            foreach($data['list_unit_kerja'] as $duk){
                if($duk['id_unitkerja'] == $pegawai['skpd']){
                    $data['unit_kerja']['id_unitkerja'] = $duk['id_unitkerja'];
                    $data['unit_kerja']['nm_unitkerja'] = $duk['nm_unitkerja'];
                }
            }
            $data['list_master_bidang'] = $this->master->loadMasterBidangByUnitKerja($pegawai['skpd']);
        } else {
            $data['list_master_bidang'] = $this->master->loadMasterBidang();
        }        
        render('master/V_MasterSubBidang', '', '', $data);
    }

    public function createMasterSubBidang(){
        $data = $this->input->post();
        unset($data['id_unitkerja']);
        $data['created_by'] = $this->general_library->getId();
        $this->master->insert('m_sub_bidang', $data);
    }

    public function loadMasterSubBidangByUnitKerja($id_unitkerja){
        $data['list_master_sub_bidang'] = $this->master->loadMasterSubBidangByUnitKerja($id_unitkerja);
        $this->load->view('master/V_MasterSubBidangItem', $data);
    }

    public function deleteMasterSubBidang($id){
        $this->general->delete('id', $id, 'm_sub_bidang');
    }

    public function rekapPegawaiBySkpd(){
        $data['list_unit_kerja'] = $this->master->getAllUnitKerja();
        render('master/V_RekapPegawaiBySkpd', '', '', $data);
    }

    public function rekapPegawaiSubmit(){
        $data['result'] = $this->master->searchPegawaiBySkpd($this->input->post());
      
        $this->load->view('master/V_RekapPegawaiItem', $data);
    }
    
    public function importBidangSubBidangByUnitKerja($id_unitkerja){
        list($data['result'], $data['skpd'], $data['id_skpd']) = $this->master->importBidangSubBidangByUnitKerja($id_unitkerja);
        $this->session->set_userdata('save_import_bidang', $data['result']);
        $this->session->set_userdata('id_save_import_bidang', $data['id_skpd']);
        $this->load->view('master/V_MasterImportBidang', $data);
    }

    public function saveImportBidang(){
        echo json_encode($this->master->saveImportBidang($this->session->userdata('save_import_bidang'), $this->session->userdata('id_save_import_bidang')));
    }

    public function importAllBidangByUnitKerja($page){
        $this->master->importAllBidangByUnitKerja($page);
    }

    public function hariLibur(){
        render('master/V_HariLibur', '', '', null);
    }

    public function downloadApiHariLibur(){
        echo json_encode($this->master->downloadApiHariLibur());
    }

    public function loadHariLibur(){
        $data['result'] = $this->general->getAllWithOrder('t_hari_libur', 'tanggal', 'asc');
        $this->load->view('master/V_HariLiburResult', $data);
    }

    public function deleteApiHariLibur($id){
        echo json_encode($this->master->deleteApiHariLibur($id));
    }

    public function tambahHariLibur(){
        echo json_encode($this->master->tambahHariLibur());
    }

    public function jamKerja(){
        render('master/V_JamKerja', '', '', null);
    }

    public function loadJamKerja(){
        $data['result'] = $this->master->getAllJamKerja();
        $this->load->view('master/V_JamKerjaResult', $data);
    }

    public function deleteJamKerja(){
        echo json_encode($this->master->deleteJamKerja($id));
    }

    public function tpp(){
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        $data['role'] = $this->general->getAll('m_role');
        $data['pangkat'] = $this->general->getAll('db_pegawai.pangkat', 0);
        $data['jabatan'] = $this->general->getAll('db_pegawai.jabatan', 0);
        render('master/V_Tpp', '', '', $data);
    }

    public function getJabatanByUnitKerja($id){
        echo json_encode($this->master->getJabatanByUnitKerja($id));
    }

    public function loadTpp(){
        $data['result'] = $this->master->loadMasterTpp();
        $this->load->view('master/V_TppData', $data);
    }

    public function inputMasterTpp(){
        $this->master->inputMasterTpp($this->input->post());

        // $data = $this->input->post();
        // $data['nominal'] = clearString($data['nominal']);
        // $data['created_by'] = $this->general_library->getId();
        // $this->general->insert('m_besaran_tpp', $data);
    }

    public function inputMasterPresentaseTpp(){
        echo json_encode($this->master->inputMasterPresentaseTpp($this->input->post()));

        // $data = $this->input->post();
        // $data['nominal'] = clearString($data['nominal']);
        // $data['created_by'] = $this->general_library->getId();
        // $this->general->insert('m_besaran_tpp', $data);
    }
    
    public function loadDataTppById($id){
        $data['result'] = $this->master->loadDataTppById($id);
        $this->load->view('master/V_TppEdit', $data);
    }

    public function hapusMasterTpp($id){
        $this->general->delete('id', $id, 'm_besaran_tpp');
    }

    public function presentaseTpp(){
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        $data['role'] = $this->general->getAll('m_role');
        $data['pangkat'] = $this->general->getAll('db_pegawai.pangkat', 0);
        $data['jabatan'] = $this->general->getAll('db_pegawai.jabatan', 0);
        render('master/V_PresentaseTpp', '', '', $data);
    }

    public function loadPresentaseTpp(){
        $data['result'] = $this->master->loadPresentaseTpp();
        $this->load->view('master/V_PresentaseTppData', $data);
    }

    public function hapusMasterPresentaseTpp($id){
        $this->general->delete('id', $id, 'm_presentase_tpp');
    }
}
