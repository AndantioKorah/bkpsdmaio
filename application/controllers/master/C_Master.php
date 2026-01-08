<?php

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('master/M_Master', 'master');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('user/M_User', 'user');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function masterSkpd(){
        $data['master'] = $this->master->getAllMasterSkpd();
        render('master/V_MasterSkpd', '', '', $data);
    }

    public function detailMasterSkpd($id_unitkerja){
        $data['id_unitkerja'] = $id_unitkerja;
        $data['result'] = $this->master->getDetailMasterSkpd($id_unitkerja);
        $this->session->set_userdata('list_pegawai_detail_skpd', $data['result']);
      
        render('master/V_MasterSkpdDetail', '', '', $data);
    }

    public function loadSkpdDetailPegawai(){
        $data['result'] = $this->session->userdata('list_pegawai_detail_skpd');
        // $this->session->set_userdata('list_pegawai_detail_skpd', null);
        $this->load->view('master/V_MasterSkpdPegawaiItem', $data);
    }

      public function loadSkpdDetailPegawaiMenu(){
        $data['result'] = $this->session->userdata('list_pegawai_detail_skpd');
        // $this->session->set_userdata('list_pegawai_detail_skpd', null);
        render('master/V_MasterSkpdPegawaiItem', '', '', $data);

    }

    public function refactorIdJabatanToMasterBidang(){
        $this->master->refactorIdJabatanToMasterBidang();
    }

    public function openStrukturOrganisasiSkpd($id_unitkerja){
        $data['result'] = $this->master->loadStrukturOrganisasiSkpd($id_unitkerja);
        // dd(json_encode($data['result']));
        $this->load->view('master/V_MasterSkpdStrukturOrganisasi', $data);
        // render('master/V_MasterSkpdStrukturOrganisasi', '', '', $data);

    }

      public function openStrukturOrganisasiSkpdMenu($id_unitkerja){
        $data['result'] = $this->master->loadStrukturOrganisasiSkpd($id_unitkerja);
        // dd(json_encode($data['result']));
        // $this->load->view('master/V_MasterSkpdStrukturOrganisasi', $data);
        render('master/V_MasterSkpdStrukturOrganisasi', '', '', $data);

    }

    public function searchPegawaiSkpdByFilter(){
        $data['result']['list_pegawai'] = $this->master->searchPegawaiSkpdByFilter($this->input->post());
        return $this->load->view('master/V_MasterSkpdPegawaiItem', $data);
    }

    public function openListPegawaiDetailSkpd(){
        $data['result'] = $this->session->userdata('list_pegawai_detail_skpd');
        $this->load->view('master/V_MasterSkpdDetailPegawai', $data);
        
    }

     public function openListPegawaiDetailSkpdMenu(){
        $data['result'] = $this->session->userdata('list_pegawai_detail_skpd');
        render('master/V_MasterSkpdDetailPegawai', '', '', $data);

    }

    public function loadUnitKerjaByIdUnitKerjaMaster($ukmaster){
        $data['ukmaster'] = $ukmaster;
        $data['result'] = $this->master->getAllUnitKerjaByIdUnitKerjaMasterNew($ukmaster);
        $this->load->view('master/V_MasterSkpdItem', $data);
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

    public function deleteAnnouncement($id){
        $this->general->delete('id', $id, 't_announcement');
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
        $data['jenis_skpd'] = $this->general->getAll('m_jenis_skpd');
        render('master/V_JamKerja', '', '', $data);
    }

    public function loadJamKerja(){
        $data['result'] = $this->master->getAllJamKerja();
        $this->load->view('master/V_JamKerjaResult', $data);
    }

    public function deleteJamKerja($id){
        echo json_encode($this->master->deleteJamKerja($id));
    }

    public function editJamKerja($id){
        $data['result'] = $this->general->getOne('t_jam_kerja', 'id', $id, 1);
        $data['jenis_skpd'] = $this->general->getAll('m_jenis_skpd');
        $this->load->view('master/V_JamKerjaEdit', $data);
    }

    public function tambahJamKerja(){
        echo json_encode($this->master->tambahJamKerja($this->input->post()));
    }

    public function saveEditJamKerja($id){
        echo json_encode($this->master->saveEditJamKerja($id, $this->input->post()));
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

    public function getAllJabatanAndJabatanEselonByUnitKerja($id){
        echo json_encode($this->master->getAllJabatanAndJabatanEselonByUnitKerja($id));
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
        render('master/V_PresentaseTpp', '', '', $data);
    }

    public function loadMasterPresentaseTppNew($id){
        $data['result'] = $this->master->loadMasterPresentaseTppNew($id);
        $this->load->view('master/V_PresentaseTppData', $data);
    }

    public function savePresentaseTpp($id_unitkerja){
        echo json_encode($this->master->savePresentaseTpp($id_unitkerja));
    }

    public function loadPresentaseTpp(){
        $data['result'] = $this->master->loadPresentaseTpp();
        $this->load->view('master/V_PresentaseTppData', $data);
    }

    public function hapusMasterPresentaseTpp($id){
        $this->general->delete('id', $id, 'm_presentase_tpp');
    }

    public function listTpp(){
		$data['unit_kerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
        render('master/V_ListTpp', '', '', $data);
	}

    public function nominatifPegawai(){
		$data['unit_kerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
        render('master/V_nominatifPegawai', '', '', $data);
	}

    public function loadListNominatifPegawai(){
        $data['result'] = $this->master->loadListNominatifPegawai($this->input->post());
        $this->load->view('master/V_nominatifPegawaiList', $data);
    }

    public function loadListTpp(){
        $params = $this->input->post();
        if($this->general_library->getUnitKerjaPegawai() == 3010000){
            $params['from_list_tpp'] = 1;
        }
        $data['result'] = $this->kinerja->countPaguTpp($params);
        $this->load->view('master/V_ListTppData', $data);
    }

    public function lockTpp(){
        $data['unit_kerja'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
        render('master/V_LockTpp', '', '', $data);
    }

    public function loadLockTpp($bulan, $tahun){
        $data['result'] = $this->master->loadLockTppData($bulan, $tahun);
        $this->load->view('master/V_LockTppData', $data);
    }

    public function updateLockTpp($id){
        $this->master->updateLockTpp($id);
    }

    public function inputLockTpp(){
        $this->master->inputLockTpp($this->input->post());
    }

    public function inputGaji(){
        $data['list_skpd'] = $this->general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'id_unitkerja', 'asc');
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('master/V_InputGaji', '', '', $data);
    }

    public function loadInputGaji(){
        list($data['result'], $data['flag_show_unitkerja']) = $this->master->loadInputGajiData($this->input->post());
        $this->load->view('master/V_InputGajiData', $data);
    }

    public function saveInputGaji(){
        return $this->master->saveInputGaji($this->input->post());
    }

    public function inputMasterJenisLayanan(){
        $data = $this->input->post();
        $input['nama'] = $data['nama'];
        if(isset($data['aktif'])){
            $input['aktif'] = "YA";
        } else {
            $input['aktif'] = "TIDAK";
        }
        $this->general->insert('db_siladen.jenis_layanan', $input);
    }

    public function jenisLayanan(){
        render('master/V_MasterJenisLayanan', '', '', null);
    }

    public function loadJenisLayanan(){
        $data['result'] = $this->general->getAllWithOrderGeneral('db_siladen.jenis_layanan', 'nama', 'asc');
        $this->load->view('master/V_MasterJenisLayananList', $data);
    }

    public function loadListAnouncement(){
        $data['list_announcement'] = $this->general->getAllWithOrder('db_efort.t_announcement', 'id', 'desc');
        $this->load->view('master/V_MasterAnnouncementItem', $data);
    }

    public function loadAnnouncement($id){
        $data['announcement'] = $this->master->getAnnoucementById($id);
        $this->load->view('login/V_Announcement', $data);
    }

    public function toggleShowAnnouncement($id){
        $this->master->toggleShowAnnouncement($id);
    }

    public function editMasterJenisLayanan($id, $state){
        $this->master->editMasterJenisLayanan($id, $state);
    }

    public function masterHakAkses(){
        render('master/V_MasterHakAkses', '', '', null);
    }

    public function loadMasterHakAkses(){
        $data['result'] = $this->general->getAllWithOrder('m_hak_akses', 'nama_hak_akses', 'asc');
        $this->load->view('master/V_MasterHakAksesList', $data);
    }

    public function inputMasterHakAkses(){
        $data = $this->input->post();
        $data['created_by'] = $this->general_library->getId();
        $this->general->insert('m_hak_akses', $data);
    }

    public function loadUserHakAkses($id){
        $data['list_pegawai'] = $this->session->userdata('list_pegawai');
        if(!$data['list_pegawai']){
            $this->session->set_userdata('list_pegawai', $this->master->getAllPegawai());
            $data['list_pegawai'] = $this->session->userdata('list_pegawai');
        }
        $data['hak_akses'] = $this->general->getOne('m_hak_akses', 'id', $id, 1);
        $data['result'] = $this->master->loadUserHakAkses($id);
        $this->load->view('master/V_MasterHakAksesListUser', $data);
    }

    public function deleteUserAkses($id){
        $this->master->deleteUserAkses($id);
    }

    public function tambahHakAksesUser($id_m_user, $id_hak_akses){
        echo json_encode($this->master->tambahHakAksesUser($id_m_user, $id_hak_akses));
    }

    public function deleteMasterHakAkses($id){
        $this->general->delete('id', $id, 'm_hak_akses');
    }

    public function masterPelanggaran(){
        render('master/V_MasterPelanggaran', '', '', null);
    }

    public function inputMasterPelanggaran(){
        $data = $this->input->post();
        $this->master->insert('m_pelanggaran', $data);
    }

    public function loadMasterPelanggaran(){
        $data['result'] = $this->general->getAllWithOrder('m_pelanggaran', 'nama_pelanggaran', 'asc');
        $this->load->view('master/V_MasterPelanggaranList', $data);
    }

    public function loadDetailPelanggaran($id){
        $data['id_m_pelanggaran'] = $id;
        $data['result'] = $this->master->loadDetailPelanggaran($id);
        $this->load->view('master/V_MasterPelanggaranDetailList', $data);
    }

    public function deletePelanggaranDetail($id){
        $this->general->delete('id', $id, 'm_pelanggaran_detail');
    }

    public function deletePelanggaran($id){
        $this->general->delete('id', $id, 'm_pelanggaran');
    }

    public function insertPelanggaranDetail($id){
        $data_input = $this->input->post();
        $data_input['id_m_pelanggaran'] = $id;
        $this->general->insert('m_pelanggaran_detail', $data_input);
    }

    public function masterSyaratLayanan(){
        $data['layanan'] = $this->master->getAllMasterLayanan();
        $data['dokumen'] = $this->master->getAllMasterDokumen();
        // dd($data['dokumen']);
        render('master/V_MasterSyaratLayanan', '', '', $data);
    }

    public function masterKlasifikasiArsip(){
        $data['layanan'] = $this->master->getAllMasterLayanan();
        $data['dokumen'] = $this->master->getAllMasterDokumen();
        // dd($data['dokumen']);
        render('master/V_MasterKlasifikasiArsip', '', '', $data);
    }

    public function loadMasterSyaratLayanan(){  
        $data['result'] = $this->master->getAllSyaratLayananItem();
        $this->load->view('master/V_MasterSyaratLayananItem', $data);
    }

    public function loadMasterKlasifikasiArsip(){  
        $data['result'] = $this->master->getAllKlasifikasiArsip();
        $this->load->view('master/V_MasterKlasifikasiArsipItem', $data);
    }

    public function inputMasterSyaratLayanan(){
        $data = $this->input->post();
        $data['created_by'] = $this->general_library->getId();
        $this->general->insert('m_syarat_layanan', $data);
    }

    public function inputMasterKlasifikasiArsip(){
        $data = $this->input->post();
        $data['created_by'] = $this->general_library->getId();
        $this->general->insert('m_jenis_layanan', $data);
    }

    public function masterAnnouncement(){
        $data['layanan'] = $this->master->getAllMasterLayanan();
        $data['dokumen'] = $this->master->getAllMasterDokumen();
        // dd($data['dokumen']);
        render('master/V_MasterAnnouncement', '', '', $data);
    }

    public function deleteMasterSyaratLayanan($id){
        $this->general->delete('id', $id, 'm_syarat_layanan');
    }

    public function deleteMasterKlasifikasiArsip($id){
        $this->general->delete('id', $id, 'm_jenis_layanan');
    }

    public function mappingUnor(){
        // $data['list_skpd'] = $this->general->getAll('db_pegawai.unitkerja', 0);
        // $data['list_unor_siasn'] = $this->general->getAll('db_siasn.m_ref_unor', 0);
        $data['result'] = $this->general->getDataMappingUnor();
        render('master/V_SiasnMappingUnor', '', '', $data);
    }

    public function editMappingUnor($id){
        $data['result'] = $this->general->editMappingUnor($id);
        $data['list_unor_siasn'] = $this->general->getAll('db_siasn.m_ref_unor', 0);
        $data['id_unitkerja'] = $id;
        $this->load->view('master/V_SiasnEditMappingUnor', $data);
    }

    public function saveEditMappingUnor(){
        echo json_encode($this->general->saveEditMappingUnor());
    }

    public function deleteMappingUnor($id){
        $this->general->deleteMappingUnor($id);
    }

    public function mappingBidang(){
        $data['list_skpd'] = $this->general->getAll('db_pegawai.unitkerja', 0);
        render('master/V_SiasnMappingBidang', '', '', $data);
    }

    public function loadBidangForMappingUnor($id_unitkerja){
        $data['list_master_bidang'] = $this->general->loadMasterBidangByUnitKerjaForMappingUnor($id_unitkerja);
        $this->load->view('master/V_SiasnListBidangMapping', $data);
    }

    public function deleteMappingBidang($id){
        $this->general->deleteMappingBidang($id);
    }

    public function deleteMappingSubBidang($id){
        $this->general->deleteMappingSubBidang($id);
    }

    public function editUnorBidang($id){
        $data['id_unitkerja'] = $id;
        $data['result'] = $this->general->getDataForEditUnorBidang($id);
        $data['list_unor_siasn'] = $this->general->getUnorSiasnByUnitKerja($data['result']['id_unitkerja']);
        $data['list_sub_bidang'] = $this->general->getListSubBidangByIdBidang($data['result']['id_m_bidang']);
        $data['list_unor_siasn_sub_bidang'] = $this->general->getUnorSiasnByBidang($data['result']['id_m_bidang']);

        $this->load->view('master/V_SiasnEditMappingBidang', $data);
    }

    public function saveEditMappingBidang(){
        echo json_encode($this->general->saveEditMappingBidang());
    }

    public function saveEditMappingSubBidang($id){
        echo json_encode($this->general->saveEditMappingSubBidang($id));
    }

    public function mappingJabatan(){
        // $data['jenis_jabatan'][0]['jenis'] = 'semua';
        // $data['jenis_jabatan'][0]['nama'] = 'Semua';

        $data['jenis_jabatan'][3]['jenis'] = 'JFT';
        $data['jenis_jabatan'][3]['nama'] = 'JFT';
        
        $data['jenis_jabatan'][1]['jenis'] = 'JFU';
        $data['jenis_jabatan'][1]['nama'] = 'JFU';

        $data['jenis_jabatan'][2]['jenis'] = 'struktural';
        $data['jenis_jabatan'][2]['nama'] = 'Struktural';

        $data['list_skpd'] = $this->general->getAll('db_pegawai.unitkerja', 0);
        render('master/V_SiasnMappingJabatan', '', '', $data);
    }

    public function loadJabatanForMappingSiasn($jenis, $skpd){
        $data['result'] = $this->general->loadJabatanForMappingSiasn($jenis, $skpd);
        $this->load->view('master/V_SiasnMappingJabatanList', $data);
    }

    public function loadDetailJabatanMapping($id){
        list($data['result'], $data['list_jabatan_siasn']) = $this->general->loadDetailJabatanMapping($id);
        $this->load->view('master/V_SiasnMappingJabatanDetail', $data);
    }

    public function getRefJabatanFungsional(){
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->master->getRefJabatanFungsional($searchTerm);
		echo json_encode($response);
	}

    public function doUploadAnnouncement()
	{ 
		echo json_encode( $this->master->doUploadAnnouncement());
	}

    public function masterEvent(){
        render('master/V_MasterEvent', '', '', null);
    }

    public function loadListEvent(){
        $data['result'] = $this->master->loadListEvent();
        $this->load->view('master/V_MasterEventList', $data);
    }

    public function inputDataEvent(){
        echo json_encode($this->master->inputDataEvent($this->input->post()));
    }

    public function editDataEvent($id){
        $data['result'] = $this->general->getOne('db_sip.event', 'id', $id);
        $this->load->view('master/V_MasterEventEdit', $data);
    }

    public function saveEditDataEvent($id){
        echo json_encode($this->master->saveEditDataEvent($this->input->post(), $id));
    }

    public function deleteDataEvent($id){
        echo json_encode($this->master->deleteDataEvent($id));
    }

    public function hardcodeNominatif(){
		$data['unit_kerja'] = $this->kepegawaian->getUnitKerja();
        $data['nama_jabatan'] = $this->kepegawaian->getNamaJabatan();
        $data['list_pegawai'] = $this->master->getAllPegawai();
        render('master/V_MasterHardcodeNominatif', '', '', $data);
    }

    public function loadListHardcodeNominatif(){
        $data['result'] = $this->master->loadListHardcodeNominatif();
        $this->load->view('master/V_MasterHardcodeNominatifList', $data);
    }

    public function inputHardcodeNominatif(){
        echo json_encode($this->master->inputHardcodeNominatif($this->input->post()));
    }

    public function deleteHardcodeNominatif($id){
        echo json_encode($this->master->deleteHardcodeNominatif($id));
    }

}
