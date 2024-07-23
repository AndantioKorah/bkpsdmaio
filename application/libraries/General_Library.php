<?php
        
date_default_timezone_set("Asia/Singapore");
// date_default_timezone_set("America/Chicago");

class General_library
{
    protected $nikita;
    public $userLoggedIn;
    public $hakAkses;
    public $params;
    public $bios_serial_num;

    public function __construct()
    {
        // dd(date('Y-m-d H:i:s'));
        $this->nikita = &get_instance();
        if($this->nikita->session->userdata('user_logged_in')){
            $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in')[0];
            $this->hakAkses = $this->nikita->session->userdata('list_hak_akses');
        }
        $this->params = $this->nikita->session->userdata('params');
        $this->bios_serial_num = shell_exec('wmic bios get serialnumber 2>&1');
        date_default_timezone_set("Asia/Singapore");
        $this->nikita->load->model('general/M_General', 'm_general');
        $this->nikita->load->model('user/M_User', 'm_user');
        $this->nikita->load->model('kinerja/M_Kinerja', 'm_kinerja');
        $this->nikita->load->model('rekap/M_Rekap', 'm_rekap');
    }

    public function listHakAkses(){
        $result = null;
        if(count($this->hakAkses) > 0){
            foreach($this->hakAkses as $hk){
                $result[] = $hk['meta_name'];
            }
        }
        return $result;
    }

    public function isHakAksesVerifLayanan(){
        if(count($this->hakAkses) > 0){
            foreach($this->hakAkses as $hk){
                if(stringStartWith('layanan', $hk['meta_name'])){
                    return true;
                }
            }
        } else {
            return false;
        }
        return false;
    }

    public function isHavingHakAkses(){
        $flag_ada = 0;
        $exclude_layanan = ['rekap_absen_pd'];
        if(count($this->hakAkses) > 0){
            $flag_ada = 1;
            foreach($this->hakAkses as $hk){
                if(in_array($hk, $exclude_layanan)){
                    $flag_ada = 0;
                    break;
                }
            }
        } else {
            return false;
        }
        return $flag_ada == 1 ? true : false;
    }

    public function isHakAkses($meta_name){
        if(count($this->hakAkses) > 0){
            foreach($this->hakAkses as $hk){
                if($hk['meta_name'] == $meta_name){
                    return true;
                }
            }
        }
        return false;
    }

    public function getServerDateTime(){
        return date('Y-m-d H:i:s');
    }

    public function logErrorTelegram($data){
        $this->nikita->m_general->logErrorTelegram($data);
    }

    public function getBiosSerialNum(){
        $info = $this->bios_serial_num;
        return trim($info);
    }

    public function refreshUserLoggedInData(){
        $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in')[0];
    }

    public function refreshParams(){
        $params = $this->nikita->m_general->getAll('m_parameter');
        $this->nikita->session->set_userdata('params', null);
        $this->nikita->session->set_userdata([
            'params' => $params
        ]);
        if($params){
            foreach($params as $p){
                $this->nikita->session->set_userdata([$p['parameter_name'] => $p]);
            }
        }
        $this->params = $this->nikita->session->userdata('params');
        if($this->params){
            foreach($this->params as $p){
                $this->nikita->session->set_userdata([$p['parameter_name'] => null]);
                $this->nikita->session->set_userdata([$p['parameter_name'] => $p]);
            }
        }
    }

    public function getProfilePicture(){
        $photo = 'assets/img/user-icon.png';
        $photo_saved = 'assets/fotopeg/'.$this->userLoggedIn['fotopeg'];
        if(file_exists($photo_saved)){
            $photo = 'assets/fotopeg/'.$this->userLoggedIn['fotopeg'];
            // $photo = 'assets/img/user-icon.png';
        }
        return base_url().$photo;
    }

    public function getFotoPegawai($url){
        $photo = 'assets/img/user-icon.png';
        if(file_exists($url)){
            $photo = $url;
        }
        return base_url().$photo;
    }

    public function getParams($parameter_name = ''){
        return $this->nikita->session->userdata($parameter_name);
        // $this->params = $this->nikita->session->userdata('params');
        // if($parameter_name != ''){
        //     foreach($this->params as $p){
        //         if($p['parameter_name'] == $parameter_name){
        //             return $p;
        //         }
        //     }
        // } else {
        //     return $this->params;
        // }
    }

    public function getListMenu($id_role = 0, $role_name = 0, $id_bidang = 0){
        if($id_role == 0){
            $id_role = $this->nikita->session->userdata('active_role_id');
        }
        if($role_name == 0){
            $role_name = $this->nikita->session->userdata('active_role_name');
        }
        return $this->nikita->m_user->getListMenu($id_role, $role_name, $id_bidang);
    }

    public function getListUrl($id_role){
        if($id_role == 0){
            $id_role = $this->nikita->session->userdata('active_role_name');
        }

        return $this->nikita->m_user->getListUrl($id_role);
    }

    public function getRole(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->nikita->session->userdata('active_role_name');
    }

    public function getListRole(){
        return $this->nikita->session->userdata('list_role');
    }

    public function getActiveRoleId(){
        return $this->nikita->session->userdata('active_role_id');
    }

    public function getActiveRoleName(){
        return $this->nikita->session->userdata('active_role_name');
    }

    public function getActiveRole(){
        return $this->nikita->session->userdata('active_role');
    }

    public function isProgrammer(){
        return $this->getActiveRoleName() == 'programmer';
    }

    public function isManajemenTalenta(){
        return $this->getActiveRoleName() == 'manajemen_talenta';
    }

    public function isAdminAplikasi(){
        return $this->getActiveRoleName() == 'admin_aplikasi';
    }

    public function isAdministrator(){
        return $this->getActiveRoleName() == 'administrator';
    }

    public function isKaban(){
        return $this->getActiveRoleName() == 'kepalabadan';
    }

    public function isKabid(){
        return $this->getActiveRoleName() == 'kepalabidang';
    }

    public function isSetda(){
        return $this->getActiveRoleName() == 'setda';
    }

    public function isWalikota(){
        return $this->getActiveRoleName() == 'walikota' || $this->getActiveRoleName() == 'wakilwalikota';
    }

    public function isGuest(){
        return $this->getActiveRoleName() == 'guest';
    }

    public function isKepalaSekolah(){
        return $this->getActiveRoleName() == 'kepalasekolah';
    }

    public function isGuruStaffSekolah(){
        return $this->getActiveRoleName() == 'gurusekolah';
    }

    public function isPelaksana(){
        return $this->getActiveRoleName() == 'staffpelaksana';
    }

    public function isKasub(){
        return $this->getActiveRoleName() == 'subkoordinator';
    }

    public function isSekban(){
        return $this->getActiveRoleName() == 'sekretarisbadan';
    }

    public function isCamat(){
        return $this->getActiveRoleName() == 'camat';
    }

    public function isLurah(){
        return $this->getActiveRoleName() == 'lurah';
    }

    public function getUnitKerjaPegawai(){
        return $this->nikita->session->userdata('pegawai')['skpd'];
    }

    public function isPegawaiBkpsdm(){
        return $this->getUnitKerjaPegawai() == ID_UNITKERJA_BKPSDM;
    }

    public function getDataUnitKerjaPegawai(){
        $result['id_unitkerja'] = $this->nikita->session->userdata('pegawai')['id_unitkerja'];
        $result['nm_unitkerja'] = $this->nikita->session->userdata('pegawai')['nm_unitkerja'];
        $result['id_unitkerjamaster'] = $this->nikita->session->userdata('pegawai')['id_unitkerjamaster'];
        return $result;
    }

    public function isPejabatEselon(){
        return $this->userLoggedIn['id_eselon'] != 1;
    }

    public function setActiveRole($id_role){
        $this->nikita->session->set_userdata([
            'active_role_id' => null,
            'active_role_name' => null,
            'active_role' => null
        ]);
        
        $role = $this->nikita->m_general->getOne('m_role', 'id', $id_role, 1);
        
        $this->nikita->session->set_userdata([
            'active_role_id' => $role['id'],
            'active_role_name' => $role['role_name'],
            'landing_page' => $role['landing_page'],
            'active_role' => $role
        ]);

        $this->refreshMenu();
    }
    
    public function refreshMenu(){
        $list_menu = $this->nikita->user->getListMenu($this->nikita->session->userdata('active_role_id'), $this->nikita->session->userdata('active_role_name'));
        $list_url = null;
        $urls = $this->getListUrl($this->nikita->session->userdata('active_role_id'));
        foreach($urls as $u){
            $list_url[$u['url']] = $u['url'];
        }
        
        $this->nikita->session->set_userdata('list_menu', null);
        $this->nikita->session->set_userdata('list_url', null);
        
        $this->nikita->session->set_userdata([
            'list_url' => $list_url,
            'list_menu' => $list_menu
        ]);
    }

    public function isNotMenu(){
        // return true;
        $res = 0;
        if($this->isSessionExpired()){
            if($this->isProgrammer()){
                return true;
            }
            
            // $current_url = substr($_SERVER["REDIRECT_QUERY_STRING"], 1, strlen($_SERVER["REDIRECT_QUERY_STRING"])-1);
            $current_url = substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"])-1);
            $url_exist = $this->nikita->session->userdata('list_exist_url');
            $list_url = $this->nikita->session->userdata('list_url');
            // dd($list_url);
            if($this->getBidangUser() == ID_BIDANG_PEKIN){
                if(isset($list_url[$current_url])){
                    $res = 1;
                }
            }

            if($res == 0){
                if(isset($url_exist[$current_url]) && $url_exist[$current_url] == 0){
                    if(isset($list_url[$current_url])){
                        $res = 1;
                    } else {
                        $this->nikita->session->set_userdata('apps_error', 'Anda tidak memiliki Hak Akses untuk menggunakan Menu tersebut');
                    }
                } else {
                    return true;
                }
            }
        }
        return $res == 0 ? false : true;
        // return $this->isSessionExpired();
    }

    public function getDataProfilePicture(){
        return $this->userLoggedIn['profile_picture'];
    }

    public function getPassword(){
        return $this->userLoggedIn['password'];
    }

    public function isNotAppExp(){
        // $exp_app = $this->getParams('PARAM_EXP_APP');
        // if(date('Y-m-d H:i:s') <= $exp_app['parameter_value']){
        //     return true;
        // } else {
        //     return false;
        // }
        return true;
    }

    public function isNotBackDateLogin(){
        // $login_param = $this->getParams('PARAM_LAST_LOGIN');
        // if(date('Y-m-d H:i:s') >= $login_param['parameter_value']){
        //     return true;
        // } else {
        //     return false;
        // }
        return true;
    }

    public function isNotThisDevice(){
        // $param_bios = $this->getParams('PARAM_BIOS_SERIAL_NUMBER');
        // if(DEVELOPMENT_MODE == 0){
        //     $info = encrypt('nikita', trim($this->getBiosSerialNum()));
        //     if($info != trim($param_bios['parameter_value'])){
        //         return true;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
        return false;
    }

    public function isSessionExpired(){
        if(!$this->userLoggedIn){
            $this->nikita->session->set_userdata(['apps_error' => 'Sesi Anda telah habis. Silahkan Login kembali']);
            return null;
        }
        return $this->userLoggedIn;
    }

    public function isLoggedIn($exclude_role = []){
        if(!$this->userLoggedIn){
            $this->nikita->session->set_userdata(['apps_error' => 'Sesi Anda telah habis. Silahkan Login kembali']);
            return null;
        }
        if(!$this->isNotBackDateLogin()){
            $this->nikita->session->set_userdata(['apps_error' => 'Back Date detected. Make sure Your Date and Time is not less than today. If this message occur again, call '.PROGRAMMER_PHONE.'']);
            return null;
        }
        if(!$this->isNotAppExp()){
            $this->nikita->session->set_userdata(['apps_error' => 'Masa Berlaku Aplikasi Anda sudah habis']);
            return null;
        }
        if($this->isNotThisDevice()){
            $this->nikita->session->set_userdata(['apps_error' => 'Device tidak terdaftar']);
            return null;
        }
        // if(count($exclude_role) > 1 && in_array($this->getRole(), $exclude_role)){
        //     $this->nikita->session->set_userdata(['apps_error' => 'Role User tidak diizinkan untuk masuk ke menu tersebut']);
        //     return null;
        // }
        return $this->userLoggedIn;
    }

    public function getUserName(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['username'];
    }

    public function getNamaUser(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // return $this->userLoggedIn['nama_user'];
        return getNamaPegawaiFull($this->userLoggedIn);
    }

    public function isVerifPermohonanCuti(){
        return stringStartWith('Kepala', $this->userLoggedIn['nama_jabatan']) ||
        stringStartWith('Kepala', $this->userLoggedIn['nama_jabatan_tambahan'])
        ? true : false;
    }

    public function getNamaJabatan(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['nama_jabatan'];
    }

    public function getIdJabatan(){
        return isset($this->userLoggedIn['jabatan']) ? $this->userLoggedIn['jabatan'] : null;
        // return $this->userLoggedIn['jabatan'];
    }

    public function isKepalaBkpsdm(){
        return $this->getIdJabatan() == ID_JABATAN_KABAN_BKPSDM;
    }

    public function getEselon(){
        return $this->userLoggedIn['eselon'];
    }

    public function getIdEselon(){
        return $this->userLoggedIn['id_eselon'];
    }

    public function isKepalaPd(){
        return $this->userLoggedIn['kepalaskpd'] == "1";
    }

    public function getIdUnitKerjaPegawai(){
        return $this->userLoggedIn['id_unitkerja'];
    }

    public function getId(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn ? $this->userLoggedIn['id'] : '';
    }

    // public function getSubBidangUser(){
    //     // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
    //     // $this->refreshUserLoggedInData();
    //     return $this->userLoggedIn['id_m_sub_bidang'];
    // }

    public function getBidangUser(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // $this->refreshUserLoggedInData();
        return $this->userLoggedIn['id_m_bidang'];
    }

    public function getNamaSKPDUser(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // $this->refreshUserLoggedInData();
        return $this->userLoggedIn['nm_unitkerja'];
    }

    public function getIdPegSimpeg(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // $this->refreshUserLoggedInData();
        return $this->userLoggedIn['id_peg'];
    }

    public function getIdPegawai($id_peg){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // $this->refreshUserLoggedInData();
        return $this->nikita->m_user->getNipPegawai($id_peg);
    }

    public function getEselonPegawai($id_peg){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        // $this->refreshUserLoggedInData();
        return $this->nikita->m_user->getEselonPegawai($id_peg);
    }

    public function getAbsensiPegawai($id_pegawai, $bulan, $tahun){
        $params['bulan'] = $bulan;
        $params['tahun'] = $tahun;
        $params['id_pegawai'] = $id_pegawai;
        return $this->nikita->m_user->getAbsensiPegawai($params, 0);
    }

    public function getProduktivitasKerjaPegawai($id, $bulan, $tahun){
        return $this->nikita->m_rekap->getProduktivitasKerjaPegawai($id, $bulan, $tahun);
    }

    public function countHariKerjaBulanan($bulan, $tahun){
        return $this->nikita->m_user->countHariKerjaBulanan($bulan, $tahun);
    }

    public function getPaguTppPegawai($bulan, $tahun){
        $unitkerja = $this->nikita->m_user->getUnitKerjaByPegawai($this->getId(),1);
        $data['id_unitkerja'] = $this->userLoggedIn['skpd'];
        $pagu_tpp = $this->nikita->m_kinerja->countPaguTpp($data, $this->getId());
        // $jumlahharikerja = $this->countHariKerjaBulanan($bulan, $tahun);
        $produktivitas_kerja = $this->getProduktivitasKerjaPegawai($this->getId(), $bulan, $tahun);
        return $this->nikita->m_user->getTppPegawai($this->getId(), $pagu_tpp, $produktivitas_kerja, $bulan, $tahun, $unitkerja);
    }

    public function getPaguTppPegawaiByIdPegawai($id_m_user, $bulan, $tahun, $flag_profil = null){
        $unitkerja = $this->nikita->m_user->getUnitKerjaByPegawai($id_m_user,$flag_profil);
        $data['id_unitkerja'] = $unitkerja['id_unitkerja'];
        $pagu_tpp = $this->nikita->m_kinerja->countPaguTpp($data, $id_m_user,$flag_profil);
        if(!isset($pagu_tpp['pagu_tpp'])){
            $temp = $pagu_tpp;
            $pagu_tpp = null;
            $pagu_tpp = $temp[$id_m_user];
        }
        // $jumlahharikerja = $this->countHariKerjaBulanan($bulan, $tahun);
        $produktivitas_kerja = $this->getProduktivitasKerjaPegawai($id_m_user, $bulan, $tahun);
        return $this->nikita->m_user->getTppPegawai($id_m_user, $pagu_tpp, $produktivitas_kerja, $bulan, $tahun, $unitkerja);
    }

    public function test(){
        return 'tiokors';
    }

    public function encrypt($username, $password)
    {
        $key = 'nikitalab';
        $userKey = substr($username, -3);
        $passKey = substr($password, -3);
        $generatedForHash = strtoupper($userKey).$username.$key.strtoupper($passKey).$password;
       
        return md5($generatedForHash);
    }

    public function uploadImage($path, $input_file_name){
        if (!file_exists(URI_UPLOAD.$path)) {
            mkdir(URI_UPLOAD.$path, 0777, true);
        }
        $file = $_FILES["$input_file_name"];
        $fileName = $this->getUserName().'_profile_pict_'.date('ymdhis').'_'.$file['name'];
        
        $_FILES[$input_file_name]['name'] = $file['name'];
        $_FILES[$input_file_name]['type'] = $file['type'];
        $_FILES[$input_file_name]['tmp_name'] = $file['tmp_name'];
        $_FILES[$input_file_name]['error'] = $file['error'];
        $_FILES[$input_file_name]['size'] = $file['size'];
        
        $config['upload_path'] = URI_UPLOAD.$path; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = '*';
        $config['max_size'] = '2000';

        $this->nikita->load->library('upload', $config);

        if(!$this->nikita->upload->do_upload($input_file_name)){
            $this->nikita->upload->display_errors();
        }
        if($this->nikita->upload->error_msg){
            return ['code' => '500', 'message' => $this->nikita->upload->error_msg[0]];
        }
        $image = $this->nikita->upload->data();
        // dd($image);
        // $width_size = 160;
        // $filesave = base_url('assets/profile_picture/').$image['file_name'];

        // // menentukan nama image setelah dibuat
        // $resize_image = 'resize_'.$image['file_name'];

        // // mendapatkan ukuran width dan height dari image
        // list( $width, $height ) = getimagesize($filesave);

        
        // // mendapatkan nilai pembagi supaya ukuran skala image yang dihasilkan sesuai dengan aslinya
        // $k = $width / $width_size;

        // // menentukan width yang baru
        // $newwidth = $width / $k;

        // // menentukan height yang baru
        // $newheight = $height / $k;

        // // fungsi untuk membuat image yang baru
        // $thumb = imagecreatetruecolor($newwidth, $newheight);
        // $source = imagecreatefromjpeg($filesave);

        // // men-resize image yang baru
        // imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        // // menyimpan image yang baru
        // imagejpeg($thumb, $resize_image);

        // imagedestroy($thumb);
        // imagedestroy($source);
        // $image['file_name'] = $resize_image;
        return ['code' => '0', 'data' => $image];
    }

    // <?php if($result['0']['id_unitkerjamaster'] =="8010000" || $result['0']['id_unitkerjamaster'] == "8020000" || $result['0']['id_unitkerjamaster'] == "8000000") 
    // echo "Kepala Dinas Pendidikan dan Kebudayaan Kota Manadoa"; 
    // else echo "B";

    public function getTembusanHukdis($id_unitkerjamaster,$nm_unitkerjamaster,$nm_unitkerja){

        $tembusan = null;

        if($id_unitkerjamaster =="8010000" || $id_unitkerjamaster == "8020000" || $id_unitkerjamaster == "8000000"){
            $tembusan = "Kepala Dinas Pendidikan dan Kebudayaan Kota Manado";
        } else if($id_unitkerjamaster == "4000000"){
            $tembusan = "Kepala ".$nm_unitkerja." Kota Manado";
        } else if($id_unitkerjamaster =="6000000"){
            $tembusan = "Kepala Dinas Kesehatan Kota Manado";
        } else if($id_unitkerjamaster =="5009000" || $id_unitkerjamaster == "5003000"|| $id_unitkerjamaster == "5004000" || $id_unitkerjamaster == "5005000" || $id_unitkerjamaster == "5006000" || $id_unitkerjamaster == "5007000" || $id_unitkerjamaster == "5008000" || $id_unitkerjamaster == "5009000" || $id_unitkerjamaster == "5001000" || $id_unitkerjamaster == "5010001" || $id_unitkerjamaster == "5011001"){
            $namaskpd = substr($nm_unitkerjamaster,10);
            $tembusan = "Camat ".$namaskpd;
        } 

        return $tembusan;
    }


    public function uploadImageAdmin($path, $input_file_name,$nip){
        if (!file_exists(URI_UPLOAD.$path)) {
            mkdir(URI_UPLOAD.$path, 0777, true);
        }
        $file = $_FILES["$input_file_name"];
        $fileName = $nip.'_profile_pict_'.date('ymdhis').'_'.$file['name'];
        
        $_FILES[$input_file_name]['name'] = $file['name'];
        $_FILES[$input_file_name]['type'] = $file['type'];
        $_FILES[$input_file_name]['tmp_name'] = $file['tmp_name'];
        $_FILES[$input_file_name]['error'] = $file['error'];
        $_FILES[$input_file_name]['size'] = $file['size'];
        
        $config['upload_path'] = URI_UPLOAD.$path; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = '*';
        $config['max_size'] = '2000';

        $this->nikita->load->library('upload', $config);

        if(!$this->nikita->upload->do_upload($input_file_name)){
            $this->nikita->upload->display_errors();
        }
        if($this->nikita->upload->error_msg){
            return ['code' => '500', 'message' => $this->nikita->upload->error_msg[0]];
        }
        $image = $this->nikita->upload->data();
      
        return ['code' => '0', 'data' => $image, 'nip' => $nip];
    }


}
