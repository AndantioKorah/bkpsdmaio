<?php
	class M_General extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->bios_serial_num = shell_exec('wmic bios get serialnumber 2>&1');
        }

        public function validateApps(){
            $flag_valid = 1;
            // $param_last_login = $this->getOne('m_parameter', 'parameter_name', 'PARAM_LAST_LOGIN');
            // if(date('Y-m-d H:i:s') < $param_last_login['parameter_value']){
            //     $this->session->set_flashdata('message', 'Back Date detected. Make sure Your Date and Time is not less than today. If this message occur again, call '.PROGRAMMER_PHONE.'');
            //     $flag_valid = 0;
            //     return $flag_valid;
            // }
            // $param_exp_app = $this->getOne('m_parameter', 'parameter_name', 'PARAM_EXP_APP');
            // if(date('Y-m-d H:i:s') >= $param_exp_app['parameter_value']){
            //     $this->session->set_flashdata('message', 'Masa Berlaku Aplikasi Anda sudah habis');
            //     $flag_valid = 0;
            //     return $flag_valid;
            // }
            // $param_bios_serial_number = $this->getOne('m_parameter', 'parameter_name', 'PARAM_BIOS_SERIAL_NUMBER');
            // $info = encrypt('nikita', $this->general_library->getBiosSerialNum());
            // if($info != trim($param_bios_serial_number['parameter_value'])){
            //     $this->session->set_flashdata('message', 'Device tidak terdaftar');
            //     if(DEVELOPMENT_MODE == 0){
            //         $flag_valid = 0;
            //     }
            //     return $flag_valid;
            // }
            return $flag_valid;
        }

        public function getAll($tableName, $use_flag_active = 1)
        {
            $this->db->select('*')
            // ->where('id !=', 0)
            ->from($tableName);

            if($use_flag_active == 1){
                $this->db->where('flag_active', 1);
            }
            
            return $this->db->get()->result_array(); 
        }

        public function getAllWithOrder($tableName, $orderBy = 'created_date', $whatType = 'desc')
        {
            $this->db->select('*')
            ->where('id !=', 0)
            ->where('flag_active', 1)
            ->order_by($orderBy, $whatType)
            ->from($tableName);
            return $this->db->get()->result_array(); 
        }

        public function getAllWithOrderGeneral($tableName, $orderBy = 'created_date', $whatType = 'desc')
        {
            $this->db->select('*')
            ->order_by($orderBy, $whatType)
            ->from($tableName);
            return $this->db->get()->result_array(); 
        }

        public function authenticate($username, $password, $flagSwitchAcc = 0)
        {
            $exclude_username = ['prog', '001'];

            $this->db->select('a.*, b.*, c.*, a.nama as nama_user, d.nama_jabatan, e.id_eselon, d.kepalaskpd, d.eselon, f.nama_jabatan as nama_jabatan_tambahan, b.id_m_status_pegawai')
                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                        ->join('db_pegawai.eselon e', 'd.eselon = e.nm_eselon', 'left')
                        ->join('db_pegawai.jabatan f', 'b.id_jabatan_tambahan = f.id_jabatanpeg', 'left')
                        ->where('a.username', $username)
                        // ->where('a.password', $password)
                        // ->where('id_m_status_pegawai', 1)
                        ->where('a.flag_active', 1);

            if($flagSwitchAcc == 0){
                $this->db->where('a.password', $password);
            }

            $result = $this->db->get()->result_array();
            if(!$result){
                $this->session->set_flashdata('message', 'Kombinasi Username dan Password tidak ditemukan');
                return null;
            } else {
                if($result[0]['id_m_status_pegawai'] == '1'){
                    if($result[0]['username'] == 'prog'){
                        return $result;
                    } else {
                        if($this->validateApps() == 1){
                            $this->db->where('parameter_name', 'PARAM_LAST_LOGIN')
                                    ->update('m_parameter', ['parameter_value' => date('Y-m-d H:i:s')]);
                            return $result;
                        } else {
                            return null;
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', 'Akun Anda telah dinonaktifkan oleh BKPSDM');
                    return null;
                }
            }
        }

        public function get($tableName, $fieldName, $fieldValue, $use_flag_active = 0)
        {
            $this->db->select('*')
            ->from($tableName)
            ->where($fieldName, $fieldValue);
            if($use_flag_active == 1){
                $this->db->where('flag_active', $use_flag_active);
            }
            return $this->db->get()->result_array();
        }
        
        public function getOne($tableName, $fieldName, $fieldValue, $use_flag_active = 0)
        {
            $this->db->select('*')
            ->from($tableName)
            ->where($fieldName, $fieldValue);
            if($use_flag_active == 1){
                $this->db->where('flag_active', $use_flag_active);
            }
            return $this->db->get()->row_array();
        }

        public function getBulk($tableName, $fieldName, $fieldValue)
        {
            $this->db->select('*')
            ->from($tableName)
            ->where_in($fieldName, $fieldValue);
            return $this->db->get()->result_array();
        }

        public function getWithOrder($tableName, $fieldName, $fieldValue, $byWhat, $whatType)
        {
            $this->db->select('*')
            ->from($tableName)
            ->where($fieldName, $fieldValue)
            ->order_by($byWhat, $whatType);
            return $this->db->get()->result_array();
        }

        public function getBulkWithOrder($tableName, $fieldName, $fieldValue, $byWhat, $whatType)
        {
            $this->db->select('*')
            ->from($tableName)
            ->where_in($fieldName, $fieldValue)
            ->order_by($byWhat, $whatType);
            return $this->db->get()->result_array();
        }

        public function insert($tableName, $data)
        {
            $this->db->insert($tableName, $data);
            return $this->db->insert_id();
        }

        public function insertBulk($tableName, $data)
        {
            $this->db->insert_batch($tableName, $data);
            return $this->db->insert_id();
        }

        public function update($fieldName, $fieldValue, $tableName, $data)
        {
            $this->db->where($fieldName, $fieldValue)
            ->update($tableName, $data);
        }

        public function deleteBulk($fieldName, $fieldValue, $tableName)
        {
            $this->db->where_in($fieldName, $fieldValue)
            ->delete($tableName);
        }

        public function delete($fieldName, $fieldValue, $tableName)
        {
            $this->db->where($fieldName, $fieldValue)
                        ->update($tableName, ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
        }

        public function otentikasiUser($data, $jenis_transaksi){
            $username = $data['username'];
            $password = $this->general_library->encrypt($username, $data['password']);
            $otentikasi = $this->db->select('*')
                                    ->from('m_user')
                                    ->where('username', $username)
                                    ->where('password', $password)
                                    ->where_in('id_m_role', [1,2])
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
            if($otentikasi){
                return ['code' => $jenis_transaksi];
            }
            return ['code' => 0];
        }

        public function getDataPegawai($nip){
            return $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->where('id_m_status_pegawai', 1)
                            ->where('nipbaru_ws', $nip)
                            ->get()->row_array();
        }

        public function getUserForSetting($id){
            return $this->db->select('*, a.id as id_m_user')
                            ->from('m_user a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id', 'left')
                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
                            ->where('id_m_status_pegawai', 1)
                            ->where('a.flag_active',1)
                            ->where('a.id', $id)
                            ->get()->row_array();
        }

        public function getAllSubBidang(){
            return $this->db->select('b.*, a.nama_bidang, b.id as id_m_sub_bidang')
                        ->from('m_bidang a')
                        ->join('m_sub_bidang b', 'a.id = b.id_m_bidang')
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        }

        public function getRoleByUnitKerjaMaster($id_m_user){
            $unitkerja = $this->db->select('*')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                                ->join('m_user c', 'a.nipbaru_ws = c.username')
                                ->where('c.id', $id_m_user)
                                ->where('id_m_status_pegawai', 1)
                                ->get()->row_array();
            $ukmsekolah = ['8000000', '8010000', '8020000', '8030000'];
            $explodeuk = explode(" ", $unitkerja['nm_unitkerja']);
            
            $include_role = [];
            
            $this->db->select('*')
                    ->from('m_role')
                    ->where('flag_active', 1);
            
            if(in_array($unitkerja['id_unitkerjamaster'], $ukmsekolah)){ //role untuk sekolah
                $include_role = ['gurusekolah', 'kepalasekolah', 'administrator'];
            } else if($explodeuk[0] == 'Kecamatan') { //role untuk kecamatan
                $include_role = ['administrator', 'camat', 'sekretarisbadan', 'staffpelaksana', 'kepalabidang', 'subkoordinator'];
            } else if($explodeuk[0] == 'Kelurahan') { //role untuk kelurahan
                $include_role = ['administrator', 'lurah', 'sekretarisbadan', 'staffpelaksana', 'kepalabidang', 'subkoordinator'];
            } else { //role untuk badan, dinas dsb
                $include_role = ['administrator', 'kepalabadan', 'sekretarisbadan', 'staffpelaksana', 'kepalabidang', 'subkoordinator'];
            }

            if(!$this->general_library->isProgrammer()){
                $this->db->where_in('role_name', $include_role);
            }

            return $this->db->get()->result_array();
        }

        public function logErrorTelegram($data){
            // dd($data);
            $data_telegram['message'] = '';
            $req = $this->telegramlib->send_curl_exec('GET', 'sendMessage', '713399901', $data_telegram);
        }


        public function getIdPeg($username){
            $query = $this->db->select('b.id_peg')
            // ->from('db_pegawai.pegawai a')
            // ->where('nipbaru_ws', $username)
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->where('a.id', $this->general_library->getId())
            // ->where('id_m_status_pegawai', 1)u
            ->get()->row_array();
            return $query['id_peg'];
        }

        public function getListPegawaiGajiBerkalaByYear($data){
            $tahun = $data['tahun'] - 2;
            if(isset($data['bulan'])){
                $bulan = $data['bulan'];
            }
            $result = null;
            $this->db->select('a.catatan_berkala,e.nm_statuspeg,a.statuspeg,a.id_peg,a.tmtpangkat,a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.tmtgjberkala,
            (select CONCAT(aa.nm_m_user_verif,"|",aa.status,"|",aa.keterangan) from t_gajiberkala as aa where a.id_peg = aa.id_pegawai and tahun = '.$data['tahun'].' and aa.flag_active = 1 limit 1) as tberkala')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->join('db_pegawai.statuspeg e', 'a.statuspeg = e.id_statuspeg')
            ->where_in('a.statuspeg', [1, 2, 3])
            ->where('id_m_status_pegawai', 1)
            ->where('flag_terima_berkala', 1)
            // ->where('c.jenis_jabatan !=', 'JFT')
            ->where('year(a.tmtgjberkala) <=', $tahun) 
            // ->where('year(a.tmtgjberkala) ', $tahun)

            // ->where('a.tmtgjberkala !=', '0000-00-00')
            ->where_not_in('b.id_unitkerjamaster', [0000000, 7000000, 9050000])
            ->order_by('a.tmtgjberkala');

            if($data['eselon'] != "0"){
                $this->db->where('c.eselon', $data['eselon']);
            }

            if(isset($bulan)){
            if($data['bulan'] != "0"){
                $this->db->where('month(a.tmtgjberkala)', $bulan);
            }
            }


            if($data['pangkat'] != "0"){
                $this->db->where('d.id_pangkat', $data['pangkat']);
            }

            if(isset($data['skpd'])){
                $this->db->where('a.skpd', $data['skpd']);
            }
            $query = $this->db->get()->result_array();

            // if($query){
            //     foreach($query as $q){
            //         if($q['tmtgjberkala'] && $q['tmtgjberkala'] != '0000-00-00'){
            //             // $diff = countDiffDateLengkap($data['tahun'], $q['tmtgjberkala'], ['tahun']);
            //             $explode = explode("-", $q['tmtgjberkala']);
            //             $tahuntmtgajiberkala = $explode[0];
            //             $diff = $data['tahun'] - $tahuntmtgajiberkala;
            //             if($diff == 2){
            //                 $result[] = $q;
            //             }
            //         }
            //     }
            // }
            return $query;
            // return $result;
        }

        public function getListPegawaiNaikPangkatByYear($data){
            $result = null;
            $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan, a.jabatan, a.pangkat,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.tmtpangkat, a.pendidikan')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->where_in('a.statuspeg', [1, 2])
            ->where('id_m_status_pegawai', 1)
            ->where('c.jenis_jabatan !=', 'JFT')
            ->where_not_in('b.id_unitkerjamaster', LIST_UNIT_KERJA_MASTER_EXCLUDE)
            ->order_by('a.tmtpangkat');

            if($data['eselon'] != "0"){
                $this->db->where('c.eselon', $data['eselon']);
            }

            if($data['pangkat'] != "0"){
                $this->db->where('d.id_pangkat', $data['pangkat']);
            }

            if(isset($data['skpd'])){
                $this->db->where('a.skpd', $data['skpd']);
            }
            $query = $this->db->get()->result_array();

            $list_pensiun = null;
            $pensiun = $this->getListPegawaiPensiunByYear($data);
            // dd($pensiun);
            if($pensiun){
                foreach($pensiun as $p){
                    if(isset($p['nipbaru_ws'])){
                        $list_pensiun[$p['nipbaru_ws']] = $p;
                    }
                }
            }

            if($query){
                foreach($query as $q){
                    if($q['tmtpangkat'] && $q['tmtpangkat'] != '0000-00-00'){
                        // $diff = countDiffDateLengkap($data['tahun'], $q['tmtpangkat'], ['tahun']);
                        $explode = explode("-", $q['tmtpangkat']);
                        $tahuntmtpangkat = $explode[0];
                        $diff = $data['tahun'] - $tahuntmtpangkat;
                        if($diff >= 4 && !isset($list_pensiun[$q['nipbaru_ws']])){
                            $flag_valid = 1;
                            if($q['pendidikan'] == "0000" && $q['pangkat'] >= 21 ){ //SD dan II A ke atas
                                $flag_valid = 0;
                            } else if($q['pendidikan'] == "1000" && $q['pangkat'] >= 23){ // SMP dan II C ke atas
                                $flag_valid = 0;
                            } else if($q['pendidikan'] == "2000" && $q['pangkat'] >= 32){ // SMA dan III B ke atas
                                $flag_valid = 0;
                            } else if($q['pendidikan'] == "7000" && $q['pangkat'] >= 34){ // S1 dan III D ke atas
                                $flag_valid = 0;
                            } else if($q['pendidikan'] == "8000" && $q['pangkat'] >= 41){ // S2 dan IV A ke atas
                                $flag_valid = 0;
                            } else if($q['pendidikan'] == "9000" && $q['pangkat'] >= 42){ // S3 dan IV B ke atas
                                $flag_valid = 0;
                            }

                            if($q['eselon'] == "III B" && $q['pangkat'] >= 41){ // eselon III B dan pangkat IV A ke atas
                                $flag_valid = 0;
                            } else if($q['eselon'] == "III A" && $q['pangkat'] >= 42){ // eselon III A dan pangkat IV B ke atas
                                $flag_valid = 0;
                            } else if($q['eselon'] == "II B" && $q['pangkat'] >= 43){ // eselon II B dan pangkat IV C ke atas
                                $flag_valid = 0;
                            } else if($q['eselon'] == "II A" && $q['pangkat'] >= 44){ // eselon II A dan pangkat IV D ke atas
                                $flag_valid = 0;
                            }
                            if($flag_valid == 1){
                                $result[] = $q;
                            }
                        }
                    }
                }
            }
            
            return $result;
        }

        public function getListPegawaiPensiunByYear($data){
            // dd($data);
            $list_checklist_pensiun = null;
            $checklist_pensiun = $this->db->select('a.*, c.nama')
                                        ->from('t_checklist_pensiun a')
                                        // ->join('t_checklist_pensiun_detail b', 'a.id = b.id_t_checklist_pensiun')
                                        ->join('m_user c', 'a.created_by = c.id')
                                        ->where('a.flag_active', 1)
                                        ->where('c.flag_active', 1)
                                        ->get()->result_array();
            if($checklist_pensiun){
                foreach($checklist_pensiun as $cp){
                    $list_checklist_pensiun[$cp['nip']] = $cp;
                    $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#e79898";
                    $list_checklist_pensiun[$cp['nip']]['txt-color'] = "black";

                    if($cp['created_by'] == 110){ // bu merry
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#82e4e7";
                        // $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white";
                    } else if($cp['created_by'] == 89){ // pak azwar
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#74fdab";
                        // $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white";
                    } else if($cp['created_by'] == 77){ // mawar
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#da7ff7";
                        // $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white";
                    } 
                }
            }

            $this->db->select('a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
                    d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, c.jenis_jabatan')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                    ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat', 'left')
                    ->where('a.statuspeg', 2)
                    // ->where_in('id_m_status_pegawai', [1,2])
                    ->group_by('a.nipbaru_ws')
                    ->order_by('a.nipbaru_ws', 'asc');

            if($data['tahun'] == date('Y')){
                $this->db->where_in('id_m_status_pegawai', [1,2,3]);
            } else if($data['tahun'] > date('Y')) {
                $this->db->where_in('id_m_status_pegawai', [1]);
            }

            if($data['eselon'] != "0"){
                $this->db->where('c.eselon', $data['eselon']);
            }

            if($data['pangkat'] != "0"){
                $this->db->where('d.id_pangkat', $data['pangkat']);
            }

            if(isset($data['jenis_jabatan']) && $data['jenis_jabatan'] != "0"){
                $this->db->where('c.jenis_jabatan', $data['jenis_jabatan']);
            }

            if(isset($data['skpd'])){
                $this->db->where('a.skpd', $data['skpd']);
            }
            $query = $this->db->get()->result_array();

            $result = null;
            if($query){
                $id_pangkat_ahli_madya = [41, 42, 43];
                $id_pangkat_ahli_utama = [44, 45];
                foreach($query as $d){
                    $temp = null;
                    if($d['tgllahir'] != null){
                        $tgl_lahir = explode("-", $d['tgllahir']);
                        $umur = floatval($data['tahun']) - $tgl_lahir[0];
                        $bup = 0;
                        $crit = 0;
                        if($umur >= 58){
                            if(($d['jenis_jabatan'] == 'JFU' && $umur == 58) || ($d['eselon'] == null)){ //jika 58 dan JFU
                                $crit = 1;
                                $temp = $d;
                                $bup = 58;
                            } 
                            // else if($d['jenis_jabatan'] == 'JFT' && $umur == 60 && in_array($d['id_pangkat'], $id_pangkat_ahli_madya)){ //jika 60 dan JFT dan golongan IV
                            //     $crit = 2;
                            //     $temp = $d;
                            //     $bup = 60;
                            // } 
                            else if($d['jenis_jabatan'] == 'JFT'){
                                $explode_nama_jabatan = explode(" ", $d['nama_jabatan']);
                                // $list_selected_madya = ['Madya'];
                                // $list_selected_utama = ['Utama'];
                                if((stringStartWith('Kepala Sekolah', $d['nama_jabatan'])) || (stringStartWith('Kepala Taman', $d['nama_jabatan']))){
                                    $crit = 2;
                                    $temp = $d;
                                    $bup = 60;
                                } else 
                                if(in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], ['Madya'])){
                                    $crit = 2;
                                    $temp = $d;
                                    $bup = 60;
                                } else 
                                if(stringStartWith('Guru', $d['nama_jabatan'])){
                                    $crit = 2;
                                    $temp = $d;
                                    $bup = 60;
                                } 
                                // else if(in_array($d['id_pangkat'], $id_pangkat_ahli_utama)){
                                //     $crit = 4;
                                //     $temp = $d;
                                //     $bup = 65;
                                // } 
                                else if(in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], ['Utama'])){
                                    $crit = 4;
                                    $temp = $d;
                                    $bup = 65;
                                } 
                                
                                else {
                                    $crit = 2;
                                    $temp = $d;
                                    $bup = 58;
                                }
                            } else if($umur == 60 && ($d['eselon'] == 'II A' || $d['eselon'] == 'II B' || $d['jenis_jabatan'] == 'JFT')){
                                $crit = 3;
                                $temp = $d;
                                $bup = 60;
                            } else if($d['eselon'] == 'III A' || $d['eselon'] == 'III B'){
                                $crit = 2;
                                $temp = $d;
                                $bup = 58;
                            } else if($umur == 65 && in_array($d['id_pangkat'], $id_pangkat_ahli_utama)){
                                $crit = 4;
                                $temp = $d;
                                $bup = 65;
                            } else if($umur == 58 &&
                            !in_array($d['id_pangkat'], $id_pangkat_ahli_utama) &&
                            !in_array($d['id_pangkat'], $id_pangkat_ahli_madya) &&
                            ($d['eselon'] != 'II A' && $d['eselon'] != 'II B')){
                                $crit = 5;
                                $temp = $d;
                                $bup = 58;
                            }
                            if($temp){
                                $temp['tmt_pensiun'] = countTmtPensiun($d['nipbaru_ws'], $bup);
                               
                                $explode = explode("-", $temp['tmt_pensiun']);
                                
                                // dd($temp['tmt_pensiun']);
                                $temp['umur'] = $bup;
                                // if($d['nipbaru_ws'] == '196501271985022001'){
                                    // $temp['umur'] .= '  '.$crit;
                                    // dd($crit);
                                // }
                                // if(date("Y-m-d", strtotime($temp['tmt_pensiun'])) < date("Y-m-d")){
                                if($crit == 5 && $d['jenis_jabatan'] == 'JFT'){
                                    // $temp['umur'] = "harusnya belum";
                                //     // dd($temp);
                                //     // $temp['umur'] .= 'ssss';
                                    // $this->db->where('nipbaru_ws', $temp['nipbaru_ws'])
                                    //     ->update('db_pegawai.pegawai', [
                                    //         'id_m_status_pegawai' => 1
                                    //     ]);
                                }
                                // if($explode[0] == $data['tahun']){
                                //     $result[] = $temp;
                                // }
                          
                                if($explode[0] == $data['tahun'] && $explode[1] != '01'){
                                    $result[] = $temp;
                                }
                                $nextyear = $data['tahun']+1;
                                if($explode[0] == $nextyear && $explode[1] == '01'){
                                    $result[] = $temp;
                                }
                            }
                        }


                        // if(floatval($data['tahun']) - $tgl_lahir[0] >= 58){ //pejabat berumur lebih dari 58 tahun pada saat $data['tahun']
                        //     $id_pangkat_ahli_madya = [41, 42, 43];
                        //     $id_pangkat_ahli_utama = [44, 45];
                        //     if(floatval($data['tahun']) - $tgl_lahir[0] >= 60){ //jika berumur 60 tahun
                        //         if($d['eselon'] == 'II A' || $d['eselon'] == 'II B'){ // pejabat pimpinan tinggi
                        //             $temp = $d;
                        //         } else if(in_array($d['id_pangkat'], $id_pangkat_ahli_madya)){ //fungsional ahli madya
                        //             $temp = $d;
                        //         } else if((stringStartWith('Guru', $d['nama_jabatan'])) && (stringStartWith('Dokter', $d['nama_jabatan']))){ //jika guru atau dokter
                        //             $temp = $d;
                        //         }
                        //     } else if((floatval($data['tahun']) - $tgl_lahir[0] >= 65) &&
                        //         (in_array($d['id_pangkat'], $id_pangkat_ahli_madya))){ //umur 65 dan pejabat fungsional ahli utama
                        //             $temp = $d;
                        //     } else if($d['eselon'] != 'II A' && $d['eselon'] != 'II B' &&
                        //         (!stringStartWith('Guru', $d['nama_jabatan']) &&
                        //         !stringStartWith('Dokter', $d['nama_jabatan']))){ //umur 58, bukan guru dan bukan dokter
                        //             $temp = $d;
                        //     }
                        //     $umur = floatval($data['tahun']) - $tgl_lahir[0];
                        //     if($temp){
                        //         $temp['umur'] = floatval($data['tahun']) - $tgl_lahir[0];
                        //         $result[] = $temp;
                        //     }
                        // }
                    }
                }
            }

            $result['list_checklist_pensiun'] = $list_checklist_pensiun;

            return $result;
        }

        public function logCron($nama_cron){
            $exists = $this->db->select('*')
                            ->from('t_log_cron')
                            ->where('nama_cron', $nama_cron)
                            ->where('flag_active', 1)
                            ->get()->row_array();
            if($exists){
                $this->db->where('nama_cron', $nama_cron)
                    ->update('t_log_cron', [
                        'last_hit' => date('Y-m-d H:i:s')
                    ]);
            } else {
                $this->db->insert('t_log_cron', [
                    'nama_cron' => $nama_cron,
                    'last_hit' => date('Y-m-d H:i:s')
                ]);
            }
        }

        public function getDataChartDashboardAdmin(){
            $result['total'] = null;
            $result['pangkat'] = null;
            $result['eselon'] = null;
            $result['agama'] = null;
            $result['pendidikan'] = null;
            $result['jenis_kelamin']['laki']['nama'] = 'Laki-Laki';
            $result['jenis_kelamin']['laki']['jumlah'] = 0;
            $result['jenis_kelamin']['perempuan']['nama'] = 'Perempuan';
            $result['jenis_kelamin']['perempuan']['jumlah'] = 0;
            $result['statuspeg'] = null;
            $result['jenis_jabatan']['jft']['jumlah'] = 0;
            $result['jenis_jabatan']['jfu']['jumlah'] = 0;
            $result['jenis_jabatan']['struktural']['jumlah'] = 0;


            $result['golongan'][1]['nama'] = 'Golongan I';
            $result['golongan'][1]['jumlah'] = 0;

            $result['golongan'][2]['nama'] = 'Golongan II';
            $result['golongan'][2]['jumlah'] = 0;

            $result['golongan'][3]['nama'] = 'Golongan III';
            $result['golongan'][3]['jumlah'] = 0;

            $result['golongan'][4]['nama'] = 'Golongan IV';
            $result['golongan'][4]['jumlah'] = 0;

            $result['golongan'][5]['nama'] = 'Golongan V';
            $result['golongan'][5]['jumlah'] = 0;

            $result['golongan'][6]['nama'] = 'Golongan X';
            $result['golongan'][6]['jumlah'] = 0;

          
           
            // $temp_pangkat = $this->db->select('*')
            //                     ->from('db_pegawai.pangkat')
            //                     ->get()->result_array();

            // foreach($temp_pangkat as $p){
            //     $result['pangkat'][$p['id_pangkat']] = $p;
            //     $result['pangkat'][$p['id_pangkat']]['nama'] = $p['nm_pangkat'];
            //     $result['pangkat'][$p['id_pangkat']]['jumlah'] = 0;
            // }

            $temp_eselon = $this->db->select('*')
                                ->from('db_pegawai.eselon')
                                ->get()->result_array();
            foreach($temp_eselon as $e){
                $result['eselon'][$e['nm_eselon']] = $e;
                $result['eselon'][$e['nm_eselon']]['nama'] = $e['nm_eselon'];
                $result['eselon'][$e['nm_eselon']]['jumlah'] = 0;
            }

            $temp_agama = $this->db->select('*')
                                ->from('db_pegawai.agama')
                                ->get()->result_array();
            foreach($temp_agama as $a){
                $result['agama'][$a['id_agama']] = $a;
                $result['agama'][$a['id_agama']]['nama'] = $a['nm_agama'];
                $result['agama'][$a['id_agama']]['jumlah'] = 0;
            }

            $temp_pendidikan = $this->db->select('*')
                                ->from('db_pegawai.tktpendidikan')
                                ->get()->result_array();
                                
            foreach($temp_pendidikan as $pend){
                $result['pendidikan'][$pend['id_tktpendidikan']] = $pend;
                $result['pendidikan'][$pend['id_tktpendidikan']]['nama'] = $pend['nm_tktpendidikan'];
                $result['pendidikan'][$pend['id_tktpendidikan']]['jumlah'] = 0;
            }
            // dd($result['pendidikan']);

            $temp_statuspeg = $this->db->select('*')
                                ->from('db_pegawai.statuspeg')
                                ->get()->result_array();
            foreach($temp_statuspeg as $sp){
                $result['statuspeg'][$sp['id_statuspeg']] = $sp;
                $result['statuspeg'][$sp['id_statuspeg']]['nama'] = $sp['nm_statuspeg'];
                $result['statuspeg'][$sp['id_statuspeg']]['jumlah'] = 0;
            }

            $pegawai = $this->db->select('c.jenis_jabatan,a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir,  c.eselon, d.id_pangkat, a.pendidikan, a.jk, a.statuspeg, a.agama')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->where('id_m_status_pegawai', 1)
            // ->where('a.jk', "Perempuan")
            // ->where('a.jk', "Laki-Laki")
            ->where_not_in('c.id_unitkerja', [5, 9050030])
            ->get()->result_array();

            $result['total'] = count($pegawai);

            foreach($pegawai as $peg){
                // $result['pangkat'][$peg['id_pangkat']]['jumlah']++;

                // if(substr($peg['nipbaru'], 9, 6) == '202321'){
                    // dd(substr($peg['id_pangkat'], 0, 1));\
                    // if($peg['id_pangkat'] == '59') {
                    //     $result['golongan'][6]['nama'] = 'Golongan IX';
                    //     $result['golongan'][6]['jumlah'] = 0;
                    // }
                    // if($peg['id_pangkat'] == '60') {
                    //     $result['golongan'][6]['nama'] = 'Golongan X';
                    //     $result['golongan'][6]['jumlah'] = 0;
                    // }
                   
                // }
                
                $result['golongan'][substr($peg['id_pangkat'], 0, 1)]['jumlah']++;
                // $gol1 = [11, 12, 13, 14];
                // $gol2 = [21, 22, 23, 24];
                // $gol3 = [31, 32, 33, 34];
                // $gol4 = [41, 42, 43, 44, 45];
                if($peg['eselon'] == 'Non Eselon'){
                    $result['eselon']['Non Eselon']['jumlah']++;
                } else {
                    if(isset($result['eselon'][$peg['eselon']])){
                        $result['eselon'][$peg['eselon']]['jumlah']++;
                    } else {
                        $result['eselon']['Non Eselon']['jumlah']++;
                    }
                }
                if($peg['pendidikan']){
                    $result['pendidikan'][$peg['pendidikan']]['jumlah']++;
                }

                if($peg['agama'] != null){
                    $result['agama'][$peg['agama']]['jumlah']++;
                }
                
                if($peg['jk'] == 'Laki-Laki' || $peg['jk'] == 'Laki-laki'){
                    $result['jenis_kelamin']['laki']['jumlah']++;
                } else {
                    $result['jenis_kelamin']['perempuan']['jumlah']++;
                }

                if($peg['statuspeg'] != null){
                    $result['statuspeg'][$peg['statuspeg']]['jumlah']++;
                }

                if($peg['jenis_jabatan'] == 'JFT'){
                    $result['jenis_jabatan']['jft']['jumlah']++;
                } else if($peg['jenis_jabatan'] == 'JFU'){
                    $result['jenis_jabatan']['jfu']['jumlah']++;
                } else if($peg['jenis_jabatan'] == 'Struktural'){
                    $result['jenis_jabatan']['struktural']['jumlah']++;
                } 
               
            }
            // dd($result);
            return $result;
        }

        public function saveLogWebhook($request, $response){
            $dc_request = json_decode($request, true);
            $dc_response = json_decode($response, true);

            $this->db->insert('t_log_webhook', [
                'chat_id' => $dc_request['data']['id'],
                'sender' => $dc_request['data']['sender'],
                'pesan' => $dc_request['data']['text'],
                'reply' => $dc_response['text'],
                'request' => $request,
                'response' => $response,
            ]);
        }

        public function getAllPegawai(){
            return $this->db->select('a.gelar1, a.gelar2, a.nama, a.nipbaru_ws as nip, h.id as id_m_user')
                        ->from('db_pegawai.pegawai a')
                        ->join('m_user h', 'a.nipbaru_ws = h.username')
                        ->where('h.flag_active', 1)
                        ->where('id_m_status_pegawai', 1)
                        ->group_by('h.id')
                        ->order_by('a.nama')
                        ->get()->result_array();
        }

        public function getGroupUnitKerja($id_unitkerja){
            $id_unitkerjamaster = null;
            $unitkerja = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where('id_unitkerja', $id_unitkerja)
                                ->get()->row_array();
            if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)){
                $id_unitkerjamaster = [$unitkerja['id_unitkerjamaster']]; // Kelurahan di bawah kecamatan
            } else if($id_unitkerja == 3012000){ // dinas kesehatan
                $id_unitkerjamaster = [7005000, 6000000]; // Puskesmas & RS
            } else if($id_unitkerja == 3010000){ //diknas
                $id_unitkerjamaster = [8000000, 8010000, 8020000]; // TK, SD, SMP
            }
            $result = null;
            if($id_unitkerjamaster){
                $result = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where_in('id_unitkerjamaster', $id_unitkerjamaster)
                                ->order_by('nm_unitkerja')
                                ->get()->result_array();
            }
            if($result && ($result[0]['id_unitkerja'] != $unitkerja['id_unitkerja'])){
                $result[] = $unitkerja;
            } else if($result == null){
                $result[] = $unitkerja;
            }

            return $result;
        }

        public function getLoginBackground(){
            $data = $this->db->select('*')
                            ->from('t_login_background')
                            // ->where('tanggal_mulai >=', date('Y-m-d'))
                            // ->where('tanggal_akhir <=', date('Y-m-d'))
                            ->where('flag_active', 1)
                            ->get()->result_array();
            
            if($data){
                foreach($data as $d){
                    // $listHari = getDateBetweenDates($d['tanggal_mulai'], $d['tanggal_akhir']);
                    if(date('Y-m-d') >= $d['tanggal_mulai'] && date('Y-m-d') <= $d['tanggal_akhir']){
                        return $d['url'];
                    }
                    // if(date('Y-m-d'))
                    // if()
                }
                
                return "assets/new_login/images/bg-02.png";
            } else {
                return "assets/new_login/images/bg-02.png";
            }
        }

        public function saveToCronWa($data){
            $data['message'] = ($data['message']);
            $this->db->insert('t_cron_wa', $data);
        }

        public function cronSendWa(){
            $list = $this->db->select('*')
                            ->from('t_cron_wa')
                            // ->where('flag_sending', 0)
                            ->where('flag_sent', 0)
                            ->where('flag_active', 1)
                            ->where('temp_count <=', 2)
                            ->where('sendTo IS NOT NULL')
                            // ->where_not_in('status', ['pending', 'sent', 'read'])
                            ->order_by('created_date', 'asc')
                            ->order_by('flag_prioritas', 'desc')
                            ->limit(10)
                            ->get()->result_array();

            if($list){
                // dd($list);
                foreach($list as $l){
                    if($l['type'] == 'text'){
                        if($l['replyId']){
                            $req = $this->maxchatlibrary->sendText($l['sendTo'], $l['message'], $l['replyId'], 1);
                        } else {
                            $req = $this->maxchatlibrary->sendText($l['sendTo'], $l['message'], 0, 1);
                        }
                    } else if($l['type'] == 'document'){
                        $req = $this->maxchatlibrary->sendDocument($l['sendTo'], $l['fileurl'], $l['filename'], $l['message']);
                    }
                    $req = json_decode($req, true);
                    $temp_count = $l['temp_count'] == null ? 0 : $l['temp_count']+1;
                    if(!isset($req['error'])){
                        if($l['sendTo'] == GROUP_CHAT_HELPDESK || $l['sendTo'] == GROUP_CHAT_PRAKOM){
                            $this->db->where('id', $l['id'])
                                    ->update('t_cron_wa', 
                                    [
                                        'chatId' => $req['id'],
                                        'flag_sending' => 1,
                                        'date_sending' => date('Y-m-d H:i:s'),
                                        'flag_sent' => 1,
                                        'date_sent' => date('Y-m-d H:i:s'),
                                        'log' => json_encode($req),
                                        'status' => 'sent'
                                    ]);
                        } else {
                            $make_sent = 0;
                            if($temp_count >=2 && $req['status'] == 'pending'){
                                $make_sent = 1;
                            }

                            $updateCronWa['chatId'] = isset($req['id']) ? $req['id'] : null;
                            $updateCronWa['flag_sending'] = 1;
                            $updateCronWa['date_sending'] = date('Y-m-d H:i:s');
                            $updateCronWa['log'] = json_encode($req);
                            $updateCronWa['status'] = isset($req['status']) ? $req['status'] : null;
                            $updateCronWa['temp_count'] = $temp_count;
                            if($make_sent == 1){
                                $updateCronWa['flag_sent'] = 1;
                                $updateCronWa['date_sent'] = date('Y-m-d H:i:s');
                                $updateCronWa['status'] = 'pending, consider its done';
                            } else if(isset($req['success']) && $req['success'] == true){
                                $updateCronWa['flag_sent'] = 1;
                                $updateCronWa['date_sent'] = date('Y-m-d H:i:s');
                                $updateCronWa['status'] = $req['success'];
                            }

                            $this->db->where('id', $l['id'])
                                    ->update('t_cron_wa', $updateCronWa);
                            
                            // if($req['id']){
                                // set chat id di column_state agar reply harus sesuai dengan pesan yang dikirim
                                $cronWa = $this->db->select('*')
                                            ->from('t_cron_wa')
                                            ->where('id', $l['id'])
                                            ->get()->row_array();

                                if($cronWa && $cronWa['id_state']){
                                    $this->db->where('id', $cronWa['id_state'])
                                            ->update($cronWa['table_state'],
                                                [
                                                    $cronWa['column_state'] => $req['id']
                                                ] 
                                            );
                                }
                            // }
                        }
                    } else {
                        $this->db->where('id', $l['id'])
                                ->update('t_cron_wa', 
                                [
                                    'flag_sending' => 1,
                                    'date_sending' => date('Y-m-d H:i:s'),
                                    'log' => json_encode($req),
                                    'status' => $req['message'],
                                    // 'temp_count' => $temp_count
                                ]);
                    }
                }
            }
        }

        public function updateCronWa($resp){
            $data = $this->db->select('*')
                            ->from('t_cron_wa')
                            ->where('chatId', $resp->id)
                            ->get()->row_array();
            if($data){
                $update = [];
                if($resp->status == 'delivered' || $resp->status == 'read' || $resp->status == 'pending'){
                    $update['flag_sent'] = 1;
                    $update['date_sent'] = date('Y-m-d H:i:s');
                }
                
                // else if($resp->status == 'pending' && $data['temp_count'] >= 3){
                //     $update['flag_sent'] = 1;
                //     $update['date_sent'] = date('Y-m-d H:i:s');
                // }

                $update['status'] = $resp->status;
                $update['log'] = json_encode($resp);

                $this->db->where('id', $data['id'])
                        ->update('t_cron_wa', $update);
            }
        }

        public function getOauthToken(){
            $token = null;
            $exists = $this->getOne('m_parameter', 'parameter_name', 'PARAM_OAUTH_TOKEN');
           
            if($exists){
                $now = date('Y-m-d H:i:s');
                if($now <= $exists['created_date'] && $exists['parameter_value']){
                    $value = json_decode($exists['parameter_value'], true);
                    $token = $value['access_token'];
                } else {
                    $res = $this->siasnlib->getOauthToken();
                    if($res['code'] == 0 && isset($res['data'])){
                        $data = json_decode($res['data'], true);
                        $token = $data['access_token']; 
    
                        $batas_waktu = date('Y-m-d H:i:s');
                        $date = new DateTime($batas_waktu);
                        $date->add(new DateInterval('PT'.$data['expires_in'].'S'));
    
                        $this->update('parameter_name', 'PARAM_OAUTH_TOKEN', 'm_parameter', [
                            'parameter_value' => ($res['data']),
                            'created_date' => $date->format('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            // echo $token;
            return $token;
        }
    
        public function getSsoToken(){
            $token = null;
            $exists = $this->getOne('m_parameter', 'parameter_name', 'PARAM_SSO_TOKEN');
            if($exists){
                $now = date('Y-m-d H:i:s');
                if($now <= $exists['created_date'] && $exists['parameter_value']){
                    $value = json_decode($exists['parameter_value'], true);
                    $token = $value['access_token'];
                } else {
                    $res = $this->siasnlib->getSsoToken();
                    if($res['code'] == 0 && isset($res['data'])){
                        $data = json_decode($res['data'], true);
                        $token = $data['access_token']; 
    
                        $batas_waktu = date('Y-m-d H:i:s');
                        $date = new DateTime($batas_waktu);
                        $date->add(new DateInterval('PT'.$data['expires_in'].'S'));
    
                        $this->update('parameter_name', 'PARAM_SSO_TOKEN', 'm_parameter', [
                            'parameter_value' => ($res['data']),
                            'created_date' => $date->format('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            // echo $token;
            return $token;
        }

        public function mappingUnor($percent){
            $uker = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unor_siasn IS NULL')
                            ->get()->result_array();

            $unorSiasn = $this->db->select('*')
                            ->from('db_siasn.m_unor_perencanaan')
                            ->where('row_level', '2')
                            ->get()->result_array();

            $list_uker = null;
            $i = 0;
            foreach($uker as $uk){
                // $list_uker[$uk['nm_unitkerja']] = $uk;

                foreach($unorSiasn as $us){
                    $nama_unor = substr($us['nama_unor'], 2);
                    $sim = similar_text(strtoupper($uk['nm_unitkerja']), strtoupper($nama_unor), $sim);
                    if($sim >= $percent){
                        $this->db->where('id_unitkerja', $uk['id_unitkerja'])
                                ->update('db_pegawai.unitkerja', [
                                    'id_unor_siasn' => $us['id']
                                ]);
                    }
                }
                $i++;
            }
            dd($unorSiasn);
        }

        public function revertMappingUnor($percent){
            $uker = $this->db->select('a.id_unitkerja, a.id_unor_siasn, a.nm_unitkerja, b.nama_unor')
                            ->from('db_pegawai.unitkerja a')
                            ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id')
                            ->where('a.id_unor_siasn IS NOT NULL')
                            ->get()->result_array();

            $i = 0;

            foreach($uker as $uk){
                $nama_unor = substr($uk['nama_unor'], 2);
                $sim = similar_text(strtoupper($uk['nm_unitkerja']), strtoupper($nama_unor), $sim);
                if($sim < $percent){
                    $this->db->where('id_unitkerja', $uk['id_unitkerja'])
                                ->update('db_pegawai.unitkerja', [
                                    'id_unor_siasn' => null
                                ]);
                }
                $i++;
            }
        }

        public function getDataMappingUnor(){
            $data = $this->db->select('a.id_unitkerja, a.id_unor_siasn, a.nm_unitkerja, b.nama_unor')
                            ->from('db_pegawai.unitkerja a')
                            ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id', 'left')
                            ->group_by('a.id_unitkerja')
                            ->get()->result_array();
            return $data;
        }

        public function editMappingUnor($id){
            return $this->db->select('a.id_unitkerja, a.id_unor_siasn, a.nm_unitkerja, b.nama_unor')
                            ->from('db_pegawai.unitkerja a')
                            ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id', 'left')
                            ->where('a.id_unitkerja', $id)
                            ->get()->row_array();
        }

        public function saveEditMappingUnor(){
            $data = $this->input->post();
            $this->db->where('id_unitkerja', $data['id_unitkerja'])
                    ->update('db_pegawai.unitkerja', [
                        'id_unor_siasn' => $data['id_unor_siasn']
                    ]);

            $rs = $this->db->select('*')
                            ->from('db_siasn.m_unor_perencanaan')
                            ->where('id', $data['id_unor_siasn'])
                            ->get()->row_array();
            return $rs;
        }

        public function deleteMappingUnor($id){
            $this->db->where('id_unitkerja', $id)
                    ->update('db_pegawai.unitkerja', [
                        'id_unor_siasn' => null
                    ]);
        }

        public function deleteMappingSubBidang($id){
            $this->db->where('id', $id)
                    ->update('m_sub_bidang', [
                        'id_unor_siasn' => null
                    ]);
        }

        public function deleteMappingBidang($id){
            $this->db->where('id', $id)
                    ->update('m_bidang', [
                        'id_unor_siasn' => null
                    ]);
        }

        public function loadMasterBidangByUnitKerjaForMappingUnor($id_unitkerja){
            return $this->db->select('a.*, b.nama_unor')
                            ->from('m_bidang a')
                            ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id', 'left')
                            ->where('a.id_unitkerja', $id_unitkerja)
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama_bidang', 'asc')
                            ->get()->result_array();
        }

        public function getDataForEditUnorBidang($id){
            return $this->db->select('a.*, a.id as id_m_bidang, b.nama_unor, b.id')
                            ->from('m_bidang a')
                            ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id', 'left')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        }
        
        public function getUnorSiasnByUnitKerja($id_unitkerja){
            return $this->db->select('*')
                        ->from('db_pegawai.unitkerja a')
                        ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.diatasan_id')
                        ->where('a.id_unitkerja', $id_unitkerja)
                        ->get()->result_array();
        }

        public function getUnorSiasnByBidang($id_m_bidang){
            $data = $this->db->select('*')
                        ->from('m_bidang a')
                        ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                        ->join('db_siasn.m_unor_perencanaan b', 'c.id_unor_siasn = b.diatasan_id')
                        ->where('a.id', $id_m_bidang)
                        ->get()->result_array();

            $tambahan = $this->db->select('*')
                                ->from('m_bidang a')
                                ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.diatasan_id')
                                ->where('a.id', $id_m_bidang)
                                ->get()->result_array();
            if($data && (stringStartWith('Kecamatan', $data[0]['nm_unitkerja']) || stringStartWith('Kelurahan', $data[0]['nm_unitkerja']))){
                $result = null;
                foreach($data as $d){
                    $result[] = $d;
                }

                if($tambahan){
                    foreach($tambahan as $t){
                        $result[] = $t;
                    }
                }
                return $result;
            } else {
                return $tambahan;
            }
        }

        public function saveEditMappingBidang(){
            $data = $this->input->post();
            $this->db->where('id', $data['id_m_bidang'])
                    ->update('m_bidang', [
                        'id_unor_siasn' => $data['id_unor_siasn']
                    ]);

            $rs = $this->db->select('*')
                            ->from('db_siasn.m_unor_perencanaan')
                            ->where('id', $data['id_unor_siasn'])
                            ->get()->row_array();
            return $rs;
        }

        public function saveEditMappingSubBidang($id){
            $data = $this->input->post();
            $this->db->where('id', $id)
                    ->update('m_sub_bidang', [
                        'id_unor_siasn' => $data['id_unor_siasn']
                    ]);

            $rs = $this->db->select('*')
                            ->from('db_siasn.m_unor_perencanaan')
                            ->where('id', $data['id_unor_siasn'])
                            ->get()->row_array();
            return $rs;
        }

        public function getListSubBidangByIdBidang($id_m_bidang){
            return $this->db->select('a.*, b.nama_unor')
                        ->from('m_sub_bidang a')
                        ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.id', 'left')
                        ->where('a.id_m_bidang', $id_m_bidang)
                        ->where('a.flag_active', 1)
                        ->group_by('a.id')
                        ->get()->result_array();
        }
        
        public function loadJabatanForMappingSiasn($jenis, $skpd){
            $this->db->select('a.*')
                        ->from('db_pegawai.jabatan a');
            if($jenis == 'struktural'){
                $this->db->select('b.nama_jabatan as nama_jabatan_siasn')
                        ->join('db_siasn.m_ref_jabatan_struktural b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $jenis)
                        ->where('a.id_unitkerja', $skpd);
            } else if($jenis == 'JFU'){
                $this->db->select('b.nama as nama_jabatan_siasn')
                        ->join('db_siasn.m_ref_jabatan_pelaksana b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $jenis);
            } else if($jenis == 'JFT'){
                $this->db->select('b.nama as nama_jabatan_siasn')
                        ->join('db_siasn.m_ref_jabatan_fungsional b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $jenis);
            }

            return $this->db->get()->result_array();
        }

        public function loadDetailJabatanMapping($id){
            $result = null;

            $temp = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatanpeg', $id)
                                ->get()->row_array();
            $list_unor_siasn = null;
            
            if($temp['jenis_jabatan'] == 'Struktural'){
                $this->db->select('a.*, b.nama_jabatan as nama_jabatan_siasn')
                        ->from('db_pegawai.jabatan a')
                        ->join('db_siasn.m_ref_jabatan_struktural b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $temp['jenis_jabatan']);
                $result = $this->db->get()->row_array();

                $list_unor_siasn = $this->db->select('*, nama_jabatan as nama_jabatan_siasn')
                                                ->from('db_siasn.m_ref_jabatan_struktural')
                                                ->get()->result_array();
            } else if($temp['jenis_jabatan'] == 'JFU'){
                $this->db->select('a.*, b.nama as nama_jabatan_siasn')
                        ->from('db_pegawai.jabatan a')
                        ->join('db_siasn.m_ref_jabatan_pelaksana b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $temp['jenis_jabatan'])
                        ->where('a.id_unitkerja', $skpd);
                $result = $this->db->get()->row_array();

                // $list_unor_siasn = $this->db->select('*, nama as nama_jabatan_siasn')
                //                                 ->from('db_siasn.m_ref_jabatan_pelaksana')
                //                                 ->get()->result_array();
            } else if($temp['jenis_jabatan'] == 'JFT'){
                $this->db->select('a.*, b.nama as nama_jabatan_siasn')
                        ->from('db_pegawai.jabatan a')
                        ->join('db_siasn.m_ref_jabatan_fungsional b', 'a.id_jabatan_siasn = b.id', 'left')
                        ->where('a.jenis_jabatan', $temp['jenis_jabatan']);
                $result = $this->db->get()->row_array();
                
                // $list_unor_siasn = $this->db->select('*, nama as nama_jabatan_siasn')
                //                                 ->from('db_siasn.m_ref_jabatan_fungsional')
                //                                 ->get()->result_array();
            }
            
            return [$result, $list_unor_siasn];
        }

        public function downloadRekapAbsenRequest(){
            $bulan = ['1', '2', '3', '4', '5', '6'];
            $list_bulan = null;
            foreach($bulan as $b){
                $list_bulan[$b] = $b;
            }

            $tahun = ['2024'];
            $list_tahun = null;
            foreach($tahun as $t){
                $list_bulan[$t] = $t;
            }

            $unitkerja = [
                'Puskesmas Bahu',
                'Puskesmas Bailang',
                'Puskesmas Bengkol',
                'Puskesmas Kombos',
                'Puskesmas Minanga',
                'Puskesmas Paniki Bawah',
                'Puskesmas Ranomuut',
                'Puskesmas Ranotana Weru',
                'Puskesmas Sario',
                'Puskesmas Teling Atas',
                'Puskesmas Tikala Baru',
                'Puskesmas Tongkaina',
                'Puskesmas Tuminting',
                'Puskesmas Wawonasa',
                'Puskesmas Wenang',
                'Puskesmas Bunaken',
                'Rumah Sakit Khusus Daerah Gigi dan Mulut',
                'Rumah Sakit Umum Daerah',
                'Sekretariat DPRD',
                'Dinas Pekerjaan Umum dan Penataan Ruang'
            ];

            $folder_name = 'request_kasub_erik_19_juli_2024';
            $folder_name = 'temp_pdf_from_api_siasn/temp_pdf_request/'.$folder_name;

            if (!file_exists($folder_name) && !is_dir($folder_name) ) {
                mkdir($folder_name);
            }

            $folder_name .= '/';

            $total = 0;
            $exists = 0;
            $not_found = 0;
            $failed = 0;
            $success = 0;
            $absen = 0;
            $tpp = 0;

            $list_nama = [];
            foreach($unitkerja as $u){
                foreach($bulan as $b){
                    foreach($tahun as $t){
                        $flag_cari_rekap_tpp = 0;
                        $list_nama[$u.$b.$t]['nama'] = 'Rekap Absensi '.$u.' Bulan '.getNamaBulan($b).' '.$t.'.pdf';
                        // $list_nama[$u.$b.$t]['url'] = base_url('assets/arsipabsensibulanan/'.str_replace(' ', '%20', $list_nama[$u.$b.$t]['nama']));
                        // $list_nama[$u.$b.$t]['url'] = ('assets/arsipabsensibulanan/'.str_replace(' ', '%20', $list_nama[$u.$b.$t]['nama']));
                        $list_nama[$u.$b.$t]['url'] = ('assets/arsipabsensibulanan/'.$list_nama[$u.$b.$t]['nama']);
                        $total++;

                        $flag_cari_rekap_tpp = $this->moveFile($list_nama[$u.$b.$t]['url'], $list_nama[$u.$b.$t]['nama'], $folder_name, $u);

                        // if(file_exists($list_nama[$u.$b.$t]['url'])){
                        //     if(!file_exists($folder_name.$list_nama[$u.$b.$t]['nama'])){
                        //         if (file_put_contents($folder_name.$list_nama[$u.$b.$t]['nama'], file_get_contents($list_nama[$u.$b.$t]['url']))){ 
                        //             $success++;
                        //             echo $list_nama[$u.$b.$t]['nama']." successfully"."<br>"; 
                        //         } else { 
                        //             $flag_cari_rekap_tpp = 1;
                        //             $failed++;
                        //             echo $list_nama[$u.$b.$t]['nama']." failed"."<br>"; 
                        //         }
                        //     } else {
                        //         $exists++;
                        //         echo $list_nama[$u.$b.$t]['nama']." EXISTS"."<br>"; 
                        //     }
                        // } else {
                        //     $flag_cari_rekap_tpp = 1;
                        //     $not_found++;
                        //     echo $list_nama[$u.$b.$t]['nama']." NOT FOUND"."<br>"; 
                        // }

                        if($flag_cari_rekap_tpp == 1){
                            $nama_rekap_tpp = 'Rekap TPP '.$u.' '.getNamaBulan($b).' '.$t.'.pdf';
                            // $url_rekap_tpp = 'arsiptpp/'.$t.'/'.getNamaBulan($b).'/'.str_replace(' ', '%20', $nama_rekap_tpp);
                            $url_rekap_tpp = 'arsiptpp/'.$t.'/'.getNamaBulan($b).'/'.$nama_rekap_tpp;
                            $last = $this->moveFile($url_rekap_tpp, $nama_rekap_tpp, $folder_name, $u);
                            if($last == 1){
                                echo "memang so nda dapa ".$u.' Bulan '.getNamaBulan($b).' '.$t.'<br>';
                            }
                        }
                    }
                }
            }
            dd(count($list_nama));
        }

        public function moveFile($url, $name, $folder, $unitkerja){
            $folder_per_uk = null;
            if (!file_exists($folder.$unitkerja) && !is_dir($folder.$unitkerja)){
                $folder_per_uk = $folder.$unitkerja.'/';
                mkdir($folder.$unitkerja);
            } else {
                $folder_per_uk = $folder.$unitkerja.'/';
            }

            $flag_cari_rekap_tpp = 0;
            if(file_exists(($url))){
                if(!file_exists($folder.$name)){
                    if (file_put_contents($folder.$name, file_get_contents($url))){ 
                        file_put_contents($folder_per_uk.$name, file_get_contents($url));
                        echo $name." successfully"."<br>"; 
                    } else { 
                        $flag_cari_rekap_tpp = 1;
                        echo $name." failed"."<br>"; 
                    }
                } else {
                    echo $name." EXISTS"."<br>"; 
                }
            } else {
                $flag_cari_rekap_tpp = 1;
                echo $name." NOT FOUND"."<br>"; 
            }

            return $flag_cari_rekap_tpp;
        }

        public function getlastNomorSurat($tahun){
            $qounter = null;
            $last_data = $this->db->select('*')
                                ->from('t_nomor_surat')
                                ->where('YEAR(tanggal_surat)', $tahun)
                                ->order_by('created_date', 'desc')
                                ->limit(1)
                                ->get()->row_array();

            if($last_data){
                $counter = floatval($last_data['counter'])+1;
            } else {
                $counter = 1;
            }
            
            return $counter;
        }

        public function cronSyncJabatanSiasn(){
            
        }

        public function queryInsertTppKelasJabatan(){
            $kelasJabatan = null;
            for($i = 1; $i <= 15; $i++){
                $kelasJabatan[$i] = $i;
            }

            $unitkerja = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->get()->result_array();

            $dataInsert = null;

            foreach($unitkerja as $uk){
                for($i = 1; $i <= 15; $i++){
                    $exists = $this->db->select('*')
                                    ->from('m_presentase_tpp')
                                    ->where('kelas_jabatan', $i)
                                    ->where('id_unitkerja', $uk['id_unitkerja'])
                                    ->where('flag_active', 1)
                                    ->get()->row_array();

                    if(!$exists){ // jika belum ada, isi
                        $dataInsert[$uk['id_unitkerja']][$i]['id_unitkerja'] = $uk['id_unitkerja'];
                        $dataInsert[$uk['id_unitkerja']][$i]['kelas_jabatan'] = $i;
                        $dataInsert[$uk['id_unitkerja']][$i]['prestasi_kerja'] = 50;
                        $dataInsert[$uk['id_unitkerja']][$i]['beban_kerja'] = 0;
                        $dataInsert[$uk['id_unitkerja']][$i]['kondisi_kerja'] = 0;
                        $dataInsert[$uk['id_unitkerja']][$i]['total_presentase'] = 50;
                    } else {
                        echo "exists ".$uk['nm_unitkerja']." kelas jabatan ".$i."<br>";
                    }
                }

                if($dataInsert[$uk['id_unitkerja']]){
                    $this->db->insert_batch('m_presentase_tpp', $dataInsert[$uk['id_unitkerja']]);
                    echo "done ".$uk['nm_unitkerja']."<br>";
                }
            }

            dd('done');
        }

        public function cronAsync(){
            $data = $this->db->select('*')
                            ->from('t_cron_async')
                            ->where('flag_done', 0)
                            ->where('flag_active', 1)
                            ->limit(5)
                            ->get()->result_array();
            if($data){
                foreach($data as $d){
                    $res = $this->apilib->asyncPost(base_url($d['url']), json_decode($d['param'], $d['method']));
                    $jsonRes = json_decode($res, true);
                    $update = null;
                    if(!$jsonRes || ($jsonRes && $jsonRes['code'] == 0)){
                        $update['flag_done'] = 1;
                        $update['date_done'] = date('Y-m-d H:i:s');
                    }
                    $update['flag_executed'] = 1;
                    $update['date_executed'] = date('Y-m-d H:i:s');
                    $update['log'] = $res;
                    $this->db->where('id', $d['id'])
                            ->update('t_cron_async', $update);
                }
            }
        }
	}
?>