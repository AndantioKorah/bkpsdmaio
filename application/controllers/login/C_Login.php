<?php

class C_Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        // $this->load->library('libraries/Dokumenlib', 'doklib');
        $this->load->model('user/M_User', 'user');
        $this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
    }

    public function login(){
        $data['background'] = $this->general->getLoginBackground();
        $this->session->set_userdata(['user_logged_in' => null, 'test' => null, 'params' => null]);
        $this->load->view('login/V_Login', $data);
    }

    public function logout(){
        $this->session->set_flashdata('message', $this->session->userdata('apps_error'));
        $this->session->set_userdata(['apps_error' => null]);
        $this->session->set_userdata(['user_logged_in' => null, 'test' => null, 'params' => null]);
        redirect('login');
    }

    public function welcomePage(){
        // $res = $this->dokumenlib->getDokumenWs('POST',[
        //     'username' => 'prog',
        //     'password' => '742141189Bidik.',
        //     'filename' => 'arsipcuti/12155151SIC_Tahunan_2022_Marcelino_Lametige_sign.pdf'
        // ]);
        // file_get_contents(base64ToFile($res['response'], 'test.pdf'));
        // dd($res);
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };

     

      

        // $data['tpp'] = $this->general_library->getPaguTppPegawai(date('m'), date('Y'));
        $data['chart'] = $this->m_general->getDataChartDashboardAdmin();
        // dd($data);
        // $this->session->set_userdata('live_tpp', null);
        // $data = null;
       
        $data['bidang'] = $this->kepegawaian->getBidang($this->general_library->getId());
        $data['nip'] = $this->general_library->getUserName();
        $data['profil_pegawai'] = $this->kepegawaian->getProfilPegawai();
        
        $temp = $this->m_general->getAll('t_announcement', 1);
        $data['announcement'] = null;
        $data['flag_show_announcement'] = 0;

        if($temp){
            foreach($temp as $t){
                if($t['flag_show'] == 1){
                // if($t['flag_show'] == 1 && in_array($this->general_library->getUserName(), EXCLUDE_NIP)){
                    $data['announcement'][] = $t;
                    $data['flag_show_announcement'] = 1;
                }
            }
        }

        if(isset($data['profil_pegawai']['skpd'])){
         $data['mbidang'] = $this->kepegawaian->getMasterBidang($data['profil_pegawai']['skpd']);
        //  dd($data['mbidang']);
        }

        
          if($this->general_library->cekKinerja() == null) {
            redirect('kinerja/realisasi');
          }

        render('login/V_Welcome', '', '', $data);
    }

    public function loadAnnouncement(){
        $temp = $this->m_general->getAll('t_announcement', 1);
        $data['announcement'] = null;
        $data['flag_show_announcement'] = 0;
        if($temp){
            foreach($temp as $t){
                if($t['flag_show'] == 1){
                // if($t['flag_show'] == 1 && in_array($this->general_library->getUserName(), EXCLUDE_NIP)){
                    $data['announcement'][] = $t;
                    $data['flag_show_announcement'] = 1;
                }
            }
        }
        // if($this->general_library->isProgrammer()){
        //     dd($data);
        // }

        $this->load->view('login/V_Announcement', $data);
    }

    public function loadLiveTpp(){
        if($this->general_library->getUserLoggedIn()['flag_terima_tpp'] == 1){
            if(!$this->session->userdata('live_tpp')){
                $data['tpp'] = $this->general_library->getPaguTppPegawai(date('m'), date('Y'));
                $this->session->set_userdata('live_tpp', $data['tpp']);
            } else {
                $data['tpp'] = $this->session->userdata('live_tpp');
            }
            $data['tpp']['capaian_tpp'] = formatCurrencyWithoutRp($data['tpp']['capaian_tpp']);
            $data['tpp']['pagu_tpp']['pagu_tpp'] = formatCurrencyWithoutRp($data['tpp']['pagu_tpp']['pagu_tpp']);
            echo json_encode($data['tpp']);
        } else {
            echo json_encode([
                'capaian_tpp' => "Rp 0",
                'pagu_tpp' => [
                    'pagu_tpp' => "Rp 0"
                ]
            ]);
        }
    }

    public function switchToAdmin(){
        $progSession = $this->session->userdata('programmer_session');
        if($progSession){
            $this->session->set_userdata([
                'user_logged_in' => null,
                'params' => null,
                'list_menu' => null,
                'list_exist_url' => null,
                'list_role' => null,
                'list_hak_akses' => null,
                'list_url' => null,
                'active_role' => null,
                'active_role_id' => null,
                'active_role_name' => null,
                'landing_page' => null,
                // 'pegawai' => null,
            ]);

            $this->session->set_userdata('programmer_session', null);
            
            $this->session->set_userdata([
                'user_logged_in' => $progSession['user_logged_in'],
                'params' => $progSession['params'],
                // 'test' => $progSession['test'],
                'list_menu' => $progSession['list_menu'],
                'list_exist_url' => $progSession['list_exist_url'],
                'list_role' => $progSession['list_role'],
                'list_hak_akses' => $progSession['list_hak_akses'],
                'list_url' => $progSession['list_url'],
                'active_role' => $progSession['active_role'],
                'active_role_id' => $progSession['active_role_id'],
                'active_role_name' => $progSession['active_role_name'],
                'landing_page' => $progSession['landing_page'],
                // 'pegawai' => $progSession['pegawai'],
            ]);
        } else {
            $this->session->set_flashdata('message', "FORBIDDEN. PROGRAMMERS ONLY.");
            redirect('logout');
        }
    }

    public function authenticateAdmin($flagSwitchAccount = 0, $nip = 0)
    { 
        if($this->input->post('username') == 'prog' && $this->input->post('password') == '123Tes.'){
            redirect('developer');
        }

        $username = $this->input->post('username');
        $password = $this->general_library->encrypt($username, $this->input->post('password'));
        // dd($password);
        if($flagSwitchAccount == 1){
            if($this->general_library->isProgrammer() ||
            $this->general_library->isHakAkses('login_another_user')){
                $username = $nip;
                $password = null;

                $progSession['user_logged_in'] = $this->session->userdata('user_logged_in');
                $progSession['list_exist_url'] = $this->session->userdata('list_exist_url');
                $progSession['list_role'] = $this->session->userdata('list_role');
                $progSession['list_admin_layanan'] = $this->session->userdata('list_admin_layanan');
                $progSession['list_hak_akses'] = $this->session->userdata('list_hak_akses');
                $progSession['list_url'] = $this->session->userdata('list_url');
                $progSession['active_role'] = $this->session->userdata('active_role');
                $progSession['active_role_id'] = $this->session->userdata('active_role_id');
                $progSession['active_role_name'] = $this->session->userdata('active_role_name');
                $progSession['landing_page'] = $this->session->userdata('landing_page');

                $this->session->set_userdata('programmer_session', $progSession);

                $this->session->set_userdata([
                    'user_logged_in' => null,
                    'params' => null,
                    'test' => null,
                    'list_menu' => null,
                    'list_exist_url' => null,
                    'list_role' => null,
                    'list_admin_layanan' => null,
                    'list_hak_akses' => null,
                    'list_url' => null,
                    'active_role' => null,
                    'active_role_id' => null,
                    'active_role_name' => null,
                    'landing_page' => null,
                    'pegawai' => null,
                    'list_tpp_kelas_jabatan' => null,
                    'list_tpp_kelas_jabatan_new' => null,
                    'live_tpp' => null,
                ]);

            } else {
                $this->session->set_flashdata('message', "FORBIDDEN. PROGRAMMERS ONLY.");
                redirect('logout');
            }
        }


        $result = $this->m_general->authenticate($username, $password, $flagSwitchAccount);
        // dd($result);
        if($result != null){
           
            // $params = $this->m_general->getAll('m_parameter');
            // $all_menu = $this->m_general->getAll('m_menu');
            $list_menu = null;
            $list_role = $this->user->getListRoleForUser($result[0]['id']);
            // 
            // dd($list_admin_layanan);
            $list_hak_akses = $this->user->getHakAksesUser($result[0]['id']);
         
            $active_role = null;
            $list_exist_url = null;
            $pegawai = $this->m_general->getDataPegawai($result[0]['username']);
            // $tpp_kelas_jabatan = $this->m_general->getAll('m_tpp_kelas_jabatan');
            // $tpp_kelas_jabatan_new = $this->m_general->getAll('m_tpp_kelas_jabatan_new');
            // $sub_bidang = $this->m_general->getAllSubBidang();
            $list_sub_bidang = null;
          
            if($list_role){
                $active_role = $list_role[0];
                $list_menu = $this->general_library->getListMenu($active_role['id'], $active_role['role_name'], $result[0]['id_m_bidang']);
                $urls = $this->general_library->getListUrl($active_role['id']);
                foreach($urls as $u){
                    $list_url[$u['url']] = $u['url'];
                }
                if($result[0]['id_m_bidang'] == ID_BIDANG_PEKIN){
                    $url_pekin = URL_MENU_PEKIN;
                    foreach($url_pekin as $u){
                        $list_url[$u] = $u;
                    }
                }
            }
            // dd($all_menu);
            // if($all_menu){
            //     foreach($all_menu as $m){
            //         $list_exist_url[$m['url']] = $m['flag_general_menu'];
            //     }
            // }

            // if(!$active_role){
            //     $this->session->set_flashdata('message', 'Akun Anda belum memiliki Role. Silahkan menghubungi Administrator.');
            //     redirect('login');
            // }

            // $list_tpp_kelas_jabatan = null;
            // $list_tpp_kelas_jabatan_new = null;
            // if($tpp_kelas_jabatan){
            //     foreach($tpp_kelas_jabatan as $tpp){
            //         $list_tpp_kelas_jabatan[$tpp['kelas_jabatan']] = $tpp['nominal'];
            //     }
            // }

            // if($tpp_kelas_jabatan_new){
            //     foreach($tpp_kelas_jabatan_new as $tpp){
            //         $list_tpp_kelas_jabatan_new[$tpp['kelas_jabatan']] = $tpp['nominal'];
            //     }
            // }
            
            if($active_role) {
                $landing_page = $active_role['landing_page'];
            } else {
                $landing_page = 'welcome';
            }
            // dd($result);
            $this->session->set_userdata([
                'user_logged_in' => $result,
                // 'params' => $params,
                'test' => 'tiokors',
                // 'list_menu' =>  $list_menu,
                'list_exist_url' =>  $list_exist_url,
                'list_role' =>  $list_role,
                'list_hak_akses' =>  $list_hak_akses,
                'list_url' =>  $list_url,
                'active_role' =>  $active_role,
                'active_role_id' =>  $active_role['id'],
                'active_role_name' =>  $active_role['role_name'],
                'landing_page' =>  $landing_page,
                // 'pegawai' => $pegawai,
                // 'list_tpp_kelas_jabatan' =>  $list_tpp_kelas_jabatan,
                // 'list_tpp_kelas_jabatan_new' =>  $list_tpp_kelas_jabatan_new,
                'live_tpp' => null
            ]);
            // if($params){
            //     foreach($params as $p){
            //         $this->session->set_userdata([$p['parameter_name'] => $p]);
            //     }
            // }
        //    dd($this->session->userdata());

            redirect(base_url($landing_page));   
            // redirect(base_url($this->session->userdata('landing_page')));                
        } else {
            $this->session->set_flashdata('message', $this->session->flashdata('message'));
            redirect('login');
        }
    }

    public function openAuthModal($id, $id_t_transaksi, $jenis_transaksi){
        $data['id'] = $id;
        $data['id_t_transaksi'] = $id_t_transaksi;
        $data['jenis_transaksi'] = $jenis_transaksi;
        $this->load->view('admin/V_Auth', $data);
    }

    public function otentikasiUser($jenis_transaksi){
        $result = $this->m_general->otentikasiUser($this->input->post(), $jenis_transaksi);
        echo json_encode($result);
    }

    public function injectBidang(){
        $this->user->injectBidang();
    }

 
}
