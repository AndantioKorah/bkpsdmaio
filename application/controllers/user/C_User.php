<?php

class C_User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->model('master/M_Master', 'master');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function roles(){
        render('user/V_Roles', 'user_management', 'roles', null);
    }

    public function createRole(){
        $this->user->insert('m_role', $this->input->post());
    }

    public function loadRoles(){
        $data['result'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        $this->load->view('user/V_RolesItem', $data);
    }

    public function users(){
        // $data['roles'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['pegawai'] = $this->session->userdata('pegawai');
        render('user/V_Users', 'user_management', 'users', $data);
    }

    public function loadPegawaiBySkpd($id_unitkerja){
       
        $data['list_pegawai'] = $this->user->getListPegawaiByUnitKerja($id_unitkerja);
        $this->load->view('user/V_ListPegawaiBySkpd', $data);
    }

    public function userChangePassword(){
        echo json_encode($this->user->userChangePassword($this->input->post()));
    }

    public function resetPassword($id){
        $this->user->resetPassword($id);
    }

    public function tambahVerifBidang(){
        echo json_encode($this->user->tambahVerifBidang($this->input->post()));
    }

    public function tambahVerifPegawai(){
        echo json_encode($this->user->tambahVerifPegawai($this->input->post()));
    }

    public function getVerifBidang($id){
        $data['result'] = $this->user->getVerifBidang($id);
        $this->load->view('user/V_VerifBidangItem', $data);
    }

    public function getVerifPegawai($id){
        $data['result'] = $this->user->getVerifPegawai($id);
        $this->load->view('user/V_VerifPegawaiItem', $data);
    }

    public function deleteVerifBidang($id){
        $this->general->update('id', $id, 't_verif_tambahan', ['flag_active' => 0]);
    }

    public function deleteVerifPegawai($id){
        $this->general->update('id', $id, 't_verif_tambahan', ['flag_active' => 0]);
    }

    public function sinkronNoHp(){
        $params['username'] = $this->general_library->getUserName();
        $params['password'] = $this->general_library->getPassword();
        $result = $this->apilib->getAllNoHpFromSiladen('POST', $params);
        dd($result);
    }

    // public function importPegawaiByUnitKerja(){
    //     $this->user->importPegawaiByUnitKerja(IMPORT_UNIT_KERJA);
    // }

    public function importPegawaiByUnitKerja($id_unitkerja){
        // dd($id_unitkerja);
        echo json_encode ($this->user->importPegawaiByUnitKerja($id_unitkerja));
    }

    public function importAllPegawai($ukmaster){
        // $ukmaster = '1000000';
        $unitkerja = $this->master->getAllUnitKerjaByIdUnitKerjaMaster($ukmaster);
        foreach($unitkerja as $u){
            echo 'working '.$u['id_unitkerja'].' '.$u['nm_unitkerja'].'<br>';
            $this->importPegawaiByUnitKerja($u['id_unitkerja']);
            echo '<br>';
            echo 'done '.$u['id_unitkerja'].' '.$u['nm_unitkerja'].'<br><br><br>';
        }
    }

    public function tambahBidangUser(){
        $data = $this->input->post();
        $update_user['id_m_bidang'] = $data['id_m_bidang'];
        $update_user['id_m_sub_bidang'] = isset($data['id_m_sub_bidang']) ? $data['id_m_sub_bidang'] : '0';
        $update_user['updated_by'] = $this->general_library->getId();
        $this->general->update('id', $data['id_m_user'], 'm_user', $update_user);
        echo json_encode($this->user->getBidanguser($data['id_m_user']));
    }

    public function refreshBidang($id_m_user){
        $data['rs'] = $this->user->getBidanguser($id_m_user);
        $this->load->view('user/V_UserBidangItem', $data);
    }

    public function deleteUserBidang($id_m_user){
        $update_user['id_m_bidang'] = 0;
        $update_user['updated_by'] = $this->general_library->getId();
        $this->general->update('id', $id_m_user, 'm_user', $update_user);
    }

    public function openAddRoleModal($id_m_user){
        $data['user'] = $this->general->getUserForSetting($id_m_user);
        $data['roles'] = $this->general->getRoleByUnitKerjaMaster($id_m_user);
        $data['bidang'] = $this->master->loadMasterBidangByUnitKerja($data['user']['skpd']);
        $data['subbidang'] = $this->master->getSubBidangByBidang($data['user']['id_m_bidang']);
        $data['pegawai'] = $this->user->getListPegawaiSkpd($data['user']['skpd'], $id_m_user);
        $data['hak_akses'] = $this->general->getAllWithOrder('m_hak_akses', 'nama_hak_akses', 'asc');
        $this->load->view('user/V_AddRoleModal', $data);
    }

    public function refreshHakAkses($id){
        $data['result'] = $this->user->getHakAksesUser($id);
        $this->load->view('user/V_ListHakAkses', $data);
    }

    public function tambahHakAkses(){
        $this->user->tambahHakAkses($this->input->post());
    }

    public function deleteHakAkses($id){
        $this->user->deleteHakAkses($id);
    }

    public function loadRoleForUser($id_m_user){
        $data['list_user_role'] = $this->user->getUserRole($id_m_user);
        $data['id_m_user'] = $id_m_user;
        $this->load->view('user/V_RoleItemModal', $data);
    }

    public function deleteRoleForUser($id_m_user){
        $this->general->delete('id', $id_m_user, 'm_user_role');
    }

    public function addRoleForUser(){
        echo json_encode($this->user->addRoleForUser($this->input->post()));
    }

    public function loadUsers($id_unitkerja){
        $data['result'] = $this->user->getAllUsersBySkpd($id_unitkerja);
        // dd($data['result']);
        $this->load->view('user/V_UsersItem', $data);
    }

    public function createUser(){
        $data = $this->input->post();
        echo json_encode($this->user->createUser($data));
    }

    public function deleteUser($id_m_user){
        $this->user->deleteUser($id_m_user);
    }

    public function userSetting(){
        render('user/V_UserSetting', null, null, null);
    }

    public function personalChangePassword(){
        $data['otp'] = $this->user->sendOtpResetPassword();
        render('user/V_UserChangePassword', null, null, $data);
    }

    public function requestSendOtp(){
        echo json_encode($this->user->requestSendOtp());
    }

    public function personalChangePasswordSubmit(){
        echo json_encode($this->user->changePassword($this->input->post()));
        
        // $this->session->set_flashdata('message', $message['message']);
        // redirect('user/setting');
    }

    public function changePassword(){
        $message = $this->user->changePassword($this->input->post());
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }

    public function updateProfile(){
        $message = $this->user->updateProfile($this->input->post());
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }

    public function updateProfilePict(){
        $photo = $_FILES['profilePict']['name'];
        $upload = $this->general_library->uploadImage('profile_picture','profilePict');
        if($upload['code'] != 0){
            $this->session->set_flashdata('message', $upload['message']);
        } else {
            $message = $this->user->updateProfilePicture($upload);
            $this->session->set_flashdata('message', $message['message']);
        }
        redirect('user/setting');
    }

    public function deleteProfilePict(){
        $message = $this->user->deleteProfilePict();
        $this->session->set_flashdata('message', $message['message']);
        redirect('user/setting');
    }

    public function menu(){
        $this->general_library->refreshMenu();
        $data['list_menu'] = $this->general->getAllWithOrder('m_menu', 'nama_menu', 'asc');
        render('user/V_Menu', 'user_management', 'menu', $data);
    }

    public function createMenu(){
        echo json_encode($this->user->createMenu($this->input->post()));
        $this->general_library->refreshMenu();
    }

    public function loadMenu(){
        $data['result'] = $this->user->loadAllMenu();
        $this->load->view('user/V_MenuItem', $data);
    }

    public function deleteMenu($id_m_menu){
        $this->general->delete('id', $id_m_menu, 'm_menu');
        $this->general_library->refreshMenu();
    }

    public function addRoleForMenu($id){
        $data['menu'] = $this->general->getOne('m_menu', 'id', $id, 1);
        $data['roles'] = $this->general->getAllWithOrder('m_role', 'nama', 'asc');
        $this->load->view('user/V_AddRoleForMenu', $data);
    }

    public function loadRoleForMenu($id){
        $data['list_menu_role'] = $this->user->getMenuRole($id);
        $data['id_menu'] = $id;
        $this->load->view('user/V_RoleForMenuItem', $data);
    }

    public function getListMenu(){
        dd($this->user->getListMenu());
    }

    public function insertRoleForMenu(){
        echo json_encode($this->user->insertRoleForMenu($this->input->post()));
    }

    public function deleteRoleForMenu($id){
        $this->general->delete('id', $id, 'm_menu_role');
    }

    public function setDefaultRoleForUser($id_role, $id_m_user){
        echo json_encode($this->user->setDefaultRoleForUser($id_role, $id_m_user));
    }

    public function setActiveRole($id_role){
        $this->general_library->setActiveRole($id_role);
        echo (base_url($this->session->userdata('landing_page')));
    }

    public function deleteRole($id){
        echo json_encode($this->user->deleteRole($id));
    }

    public function importPegawaiNewUser(){
        $data['result'] = ($this->user->importPegawaiNewUser());
        $this->load->view('user/V_ResultSearchImport', $data);
    }

    public function createUserImport($nip){
        echo json_encode($this->user->createUserImport($nip));
    }

    public function setGeneralMenu($id){
        $update = ['flag_general_menu' => 1];
        $this->general->update('id', $id, 'm_menu', $update);
    }

    public function cancelGeneralMenu($id){
        $update = ['flag_general_menu' => 0];
        $this->general->update('id', $id, 'm_menu', $update);
    }
    
    public function mutasiPegawai(){

        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['pegawai'] = $this->session->userdata('pegawai');

        render('user/V_MutasiPegawai', 'user_management', 'users', $data);
    }


    public function loadPegawai($id_unitkerja){
        // $data['result'] = $this->user->getAllUsersBySkpd($id_unitkerja);
        $data['result'] = $this->user->getAllPegawaiBySkpd($id_unitkerja);
        $this->load->view('user/V_UsersItemMutasi', $data);
    }

    public function openMutasiPegawaiModal($id_peg){
        
        $data['pegawai'] = $this->user->getListPegawaiSkpdMutasi($id_peg);
        $data['list_skpd'] = $this->user->getAllSkpd();
        // dd($data['pegawai']);
        $this->load->view('user/V_MutasiPegawaiModal', $data);
    }

    public function mutasiPegawaiSubmit(){
        echo json_encode($this->user->mutasiPegawaiSubmit($this->input->post()));
    }

    public function openRiwayatMutasiModal($id_peg){
        $data['riwayat'] = $this->user->getRiwayatMutasiPegawai($id_peg);
        $this->load->view('user/V_RiwayatMutasiModal', $data);
    }
    public function loadDataPegawaiFromNewDb(){
        $data['list_pegawai_export'] = $this->user->loadDataPegawaiFromNewDb();
        // $this->session->set_userdata(['list_pegawai_export' => $data['list_pegawai_export']]);
        $this->load->view('user/V_ImportPegawaiFromNewDb', $data);
    }

    public function loadUnregisteredPegawai(){
        $data['list_pegawai_export'] = $this->user->loadUnregisteredPegawai();
        // $this->session->set_userdata(['list_pegawai_export' => $data['list_pegawai_export']]);
        $this->load->view('user/V_ImportUnregisteredPegawai', $data);
    }

    public function exportOne($id){
        echo json_encode($this->user->exportOne($id));
    }

    public function exportAllUnregisteredPegawai(){
        echo json_encode($this->user->exportAllUnregisteredPegawai());
    }

    public function exportAll(){
        echo json_encode($this->user->exportAll());
    }

    public function runQuery(){
        $this->user->runQuery();
    }

    public function getSubBidangByBidang($id){
        echo json_encode($this->master->getSubBidangByBidang($id));
    }

    public function setRolesBulk(){
        $this->user->setRolesBulk(null);
    }

    public function importPegawaiByUnitKerjaMaster($id_unitkerjamaster){
        echo json_encode($this->user->importPegawaiByUnitKerjaMaster($id_unitkerjamaster));
    }

    public function detailTppPegawai(){
        render('user/V_TppPegawai', null, null, null);
    }

    public function searchDetailTppPegawai(){
        $data = $this->input->post();
        $data['tpp'] = $this->general_library->getPaguTppPegawai($data['bulan'], $data['tahun']);
        $this->session->set_userdata('search_detail_tpp_pegawai', $data['tpp']);
        if($data['bulan'] == date('m') && $data['tahun'] == date('Y')){
            $this->session->set_userdata('live_tpp', $data['tpp']);
        }
        $this->load->view('user/V_DetailTppPegawai', $data);
    }

    public function absensiPegawai(){
        render('user/V_AbsensiPegawai', null, null, null);
    }

    public function searchDetailAbsenPegawai($flag_edit = 0, $id_user = 0){
        $dt = $this->input->post();
        $data['flag_edit'] = $flag_edit;
        if($flag_edit == 1){
            $data['result'] = $this->general_library->getPaguTppPegawaiByIdPegawai($id_user, $dt['bulan'], $dt['tahun'], 0);
        } else {
            $data['result'] = $this->general_library->getPaguTppPegawai($dt['bulan'], $dt['tahun']);
        }
        $data['nip'] = $data['result']['pagu_tpp']['nipbaru_ws'];
        $data['result']['param'] = $dt;
        if($dt['bulan'] == date('m') && $dt['tahun'] == date('Y') && ($id_user == $this->general_library->getId())){
            $this->session->set_userdata('live_tpp', $data['result']);
        }
        // if($this->general_library->getUserName() == '196705151994031003'){
        //     dd(json_encode($data));
        // }
        return $this->load->view('user/V_DetailAbsensiPegawai', $data);
    }

    public function editDataPresensi($nip, $date){
        $data['result'] = $this->user->getPresensiPegawaiByNipAndDate($nip, $date);
        $data['nip'] = $nip;
        $data['date'] = $date;
        return $this->load->view('user/V_EditPresensiPegawai', $data);
    }

    public function saveEditPresensi($nip, $date){
        $data = $this->input->post();
        $this->user->saveEditPresensi($data, $nip, $date);
    }

    public function loadHeaderCetakan(){
        $this->load->view('adminkit/partials/V_HeaderRekapAbsen', null);
    }

    public function searchPegawaiNavbar(){
        $data['result_pegawai'] = $this->user->searchPegawai($this->input->post());

        $data['result_skpd'] = null;
        if($this->general_library->getRole() == 'programmer' 
        || $this->general_library->getRole() == 'admin_aplikasi' 
        || $this->general_library->isHakAkses('akses_profil_pegawai') 
        || $this->general_library->isKasubagKepegawaianDiknas() 
        || $this->general_library->getRole() == 'walikota'){
            $data['result_skpd'] = $this->user->searchSkpd($this->input->post());
        }
        $this->load->view('user/V_ResultSearchPegawaiNavbar', $data);
    }

    public function profilPegawai(){
        
    }

    public function pegawaiPensiun(){
        $data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        render('user/V_PegawaiPensiun', '', '', $data);
    }

    public function getListPegawaiPensiunByYear($flag_welcome_view = 0){
        $data['result'] = $this->m_general->getListPegawaiPensiunByYear($this->input->post());
        if($flag_welcome_view == 0){
            $temp['result'] = $data['result'];
            $temp['param'] = $this->input->post();
            $data['list_checklist_pensiun'] = $data['result']['list_checklist_pensiun'];
            unset($data['result']['list_checklist_pensiun']);
            $this->session->set_userdata('data_pensiun', $temp);
            $this->load->view('user/V_PegawaiPensiunItem', $data);
        } else {
            $count['total'] = $data['result'] ? count($data['result']) : 0;
            echo json_encode($count);
        }
    }

    public function pegawaiNaikPangkat(){
        $data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        render('user/V_PegawaiNaikpangkat', '', '', $data);
    }

    public function getListPegawaiNaikPangkatByYear($flag_welcome_view = 0){
        $data['result'] = $this->m_general->getListPegawaiNaikPangkatByYear($this->input->post());
        if($flag_welcome_view == 0){
            $temp['result'] = $data['result'];
            $temp['param'] = $this->input->post();
            $this->session->set_userdata('data_naik_pangkat', $temp);
            $this->load->view('user/V_PegawaiNaikpangkatItem', $data);
        } else {
            $count['total'] = count($data['result']);
            echo json_encode($count);
        }
    }

    public function pegawaiGajiBerkala(){
        $data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        render('user/V_PegawaiGajiBerkala', '', '', $data);
    }

    public function pegawaiList($search = ''){
        $data['search'] = urldecode($search);
        $data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        $data['statuspeg'] = $this->m_general->getAll('db_pegawai.statuspeg', 0);
        $data['tktpendidikan'] = $this->m_general->getAll('db_pegawai.tktpendidikan', 0);
        $data['agama'] = $this->m_general->getAll('db_pegawai.agama', 0);
        $data['keteranganpegawai'] = $this->m_general->getAll('m_status_pegawai', 0);
        $data['unitkerja'] = $this->m_general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        $data['jft'] = $this->user->getListJabatanByJenis('JFT');
        $data['satyalencana'] = $this->m_general->getAllWithOrderGeneral('m_satyalencana', 'nama_satya_lencana', 'asc');
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
        $data['jenis_kelamin'] = [
            1 => [
                'id_jenis_kelamin' => 'Laki-laki',
                'nm_jenis_kelamin' => 'Laki-Laki'
            ],
            2 => [
                'id_jenis_kelamin' => 'Perempuan',
                'nm_jenis_kelamin' => 'Perempuan'
            ]
        ];
        $data['jenis_jabatan'] = [
            'Struktural' => [
                'id_jenis_jabatan' => 'Struktural',
                'nm_jenis_jabatan' => 'Struktural'
            ],
            'JFT' => [
                'id_jenis_jabatan' => 'JFT',
                'nm_jenis_jabatan' => 'JFT'
            ],
            'JFU' => [
                'id_jenis_jabatan' => 'JFU',
                'nm_jenis_jabatan' => 'JFU'
            ],
        ];
        render('user/V_Database', '', '', $data);
    }

    public function searchAllPegawai(){
        list($data['result'], $data['use_masa_kerja']) = $this->user->searchAllPegawai($this->input->post());
        $this->session->set_userdata('data_search_database', $data);
        $this->load->view('user/V_PegawaiAllResult', $data);
    }

    public function downloadDataSearch($flag_excel = 0){
        $data = $this->session->userdata('data_search_database');
        if($flag_excel == 0){
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                'debug' => true
            ]);
            $html = $this->load->view('user/V_PegawaiAllResultPdf', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output('DATA ASN Kota Manado.pdf', 'D');
        } else {
            $this->load->view('user/V_PegawaiAllResultExcel', $data);
        }
    }

    public function getListPegawaiGajiBerkalaByYear($flag_welcome_view = 0){
        $data['result'] = $this->m_general->getListPegawaiGajiBerkalaByYear($this->input->post());
        if($flag_welcome_view == 0){
            $temp['result'] = $data['result'];
            $temp['param'] = $this->input->post();
            $data['tahun'] = $this->input->post('tahun');
            $this->session->set_userdata('data_gaji_berkala', $temp);
            $this->load->view('user/V_PegawaiGajiBerkalaItem', $data);
        } else {
            $count['total'] = $data['result'] ? count($data['result']) : 0;
            echo json_encode($count);
        }
    }

    public function cetakNaikPangkat(){
        $temp = $this->session->userdata('data_naik_pangkat');
        $data['result'] = $temp['result'];
        $data['param'] = $temp['param'];
        $this->load->view('user/V_PrintNaikpangkat', $data);
    }

    public function cetakPensiun(){
        $temp = $this->session->userdata('data_pensiun');
        $data['result'] = $temp['result'];
        $data['param'] = $temp['param'];
        $this->load->view('user/V_PrintPensiun', $data);
    }

    public function cetakGajiBerkala(){
        $temp = $this->session->userdata('data_gaji_berkala');
        $data['result'] = $temp['result'];
        $data['param'] = $temp['param'];
        $this->load->view('user/V_PrintGajiBerkala', $data);
    }

    public function getDataChartDashboardAdmin(){
        $result = $this->general->getDataChartDashboardAdmin();
        echo json_encode($result);
    }

    public function detailPdmUser(){
        $data['result'] = $this->user->loadDetailPdmUser();
        $data['foto'] =  $this->user->getFotoPegawai();
        $this->load->view('user/V_PdmDetail', $data);
    }

    public function rekapKehadiranPersonal($bulan, $tahun, $id_m_user){
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['id_m_user'] = $id_m_user;
        $result = $this->rekap->buildDataAbsensi($data, 1, 0, 1);
        echo json_encode($result);
    }

    public function tess()
    {
        $x= 1;
       
        while($x <= 2){
            $data['tes'] = "nomor".$x;
            $this->load->view('user/V_tes', $data);
            $x++;
        }
        
    }

    public function tes2()
    {
                                                         
		// dd($this->input->post('gambar'));
        
    }
}
