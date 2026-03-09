<?php
    require FCPATH . '/vendor/autoload.php';

    class M_General extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
    		$this->load->model('bacirita/M_Bacirita', 'bacirita');
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

        public function getAllUnorSiasn(){
            return $this->db->select('a.nama_unor, a.id, c.nama_unor as nama_unor_atasan')
                        ->from('db_siasn.m_ref_unor a')
                        ->join('db_siasn.m_unor_perencanaan b', 'a.id = b.id', 'left')
                        ->join('db_siasn.m_ref_unor c', 'b.diatasan_id = c.id')
                        ->group_by('a.id')
                        ->order_by('a.nama_unor', 'asc')
                        ->get()->result_array();
        }

        public function authenticate($username, $password, $flagSwitchAcc = 0)
        {
            $exclude_username = ['prog', '001'];

            $this->db->select('a.*, b.*, c.*, a.nama as nama_user, d.nama_jabatan, e.id_eselon, d.kepalaskpd, d.eselon,
                f.nama_jabatan as nama_jabatan_tambahan, b.id_m_status_pegawai')
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
                            // $this->db->where('parameter_name', 'PARAM_LAST_LOGIN')
                            //         ->update('m_parameter', ['parameter_value' => date('Y-m-d H:i:s')]);

                            $hardcodeKepalaSkpd = $this->db->select('*')
                                                        ->from('db_pegawai.unitkerja')
                                                        ->where('nip_kepalaskpd_hardcode', $result[0]['nipbaru_ws'])
                                                        ->get()->row_array();
                            $result[0]['flag_kepalaskpdhardcode'] = $hardcodeKepalaSkpd ? 1 : 0;
                            
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

        public function getListTppKelasJabatan(){
            $tpp_kelas_jabatan = $this->m_general->getAll('m_tpp_kelas_jabatan');
            if($tpp_kelas_jabatan){
                foreach($tpp_kelas_jabatan as $tpp){
                    $list_tpp_kelas_jabatan[$tpp['kelas_jabatan']] = $tpp['nominal'];
                }
            }
            return $list_tpp_kelas_jabatan;
        }

        public function getListTppKelasJabatanNew(){
            $tpp_kelas_jabatan_new = $this->m_general->getAll('m_tpp_kelas_jabatan_new');
            if($tpp_kelas_jabatan_new){
                foreach($tpp_kelas_jabatan_new as $tpp){
                    $list_tpp_kelas_jabatan_new[$tpp['kelas_jabatan']] = $tpp['nominal'];
                }
            }
            return $list_tpp_kelas_jabatan_new;
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
            $tahun = $data['tahun'];
            if(isset($data['bulan'])){
                $bulan = $data['bulan'];
            }
            $result = null;
            $this->db->select('a.tmtgjberkalaberikut,a.catatan_berkala,e.nm_statuspeg,a.statuspeg,a.id_peg,a.tmtpangkat,a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
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
            ->where('year(a.tmtgjberkalaberikut) <=', $tahun) 
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
            $checklist_pensiun = $this->db->select('a.*, c.nama as nama_verifikator, e.gelar1, e.gelar2, e.nama')
                                        ->from('t_checklist_pensiun a')
                                        // ->join('t_checklist_pensiun_detail b', 'a.id = b.id_t_checklist_pensiun')
                                        ->join('m_user c', 'a.created_by = c.id')
                                        ->join('m_user d', 'a.id_m_user_flag_selesai = d.id', 'left')
                                        ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws', 'left')
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
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#fc83eaff";
                        // $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white";
                    } else if($cp['created_by'] == 77){ // mawar
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#da7ff7";
                        // $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white";
                    }

                    if($cp['flag_selesai'] == 1){
                        // $list_checklist_pensiun[$cp['nip']] = $cp;
                        $list_checklist_pensiun[$cp['nip']]['bg-color'] = "#004701ff";
                        $list_checklist_pensiun[$cp['nip']]['txt-color'] = "white"; 
                    }
                }
            }

            $this->db->select('a.jabatan,a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
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
                                else if(in_array($d['jabatan'],  ['3010000J085','3010000J086','3010000J088','3010000J089','3010000J090'])){
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
                if($peg['pendidikan'] == "0"){
                    $peg['pendidikan'] = "0000"; 
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
                            ->where('sendTo != 62')
                            ->where('sendTo NOT LIKE "%@%"')
                            // ->where_not_in('status', ['pending', 'sent', 'read'])
                            // ->where('type', 'text') // hanya text saja 
                            ->order_by('flag_prioritas', 'desc')
                            ->order_by('created_date', 'asc')
                            ->limit(10)
                            ->get()->result_array();

            if($list){
                // dd($list);
                foreach($list as $l){
                    if($l['type'] == null){
                        $l['type'] = 'text';
                    }
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
                    $temp_count = $l['temp_count'] == null ? 0 : $l['temp_count'];
                    $temp_count++;
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
                            ->from('db_siasn.m_ref_unor')
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
                            ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id')
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
                            ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id', 'left')
                            ->group_by('a.id_unitkerja')
                            ->get()->result_array();
            return $data;
        }

        public function editMappingUnor($id){
            return $this->db->select('a.id_unitkerja, a.id_unor_siasn, a.nm_unitkerja, b.nama_unor')
                            ->from('db_pegawai.unitkerja a')
                            ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id', 'left')
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
                            ->from('db_siasn.m_ref_unor')
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
                            ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id', 'left')
                            ->where('a.id_unitkerja', $id_unitkerja)
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama_bidang', 'asc')
                            ->get()->result_array();
        }

        public function getDataForEditUnorBidang($id){
            return $this->db->select('a.*, a.id as id_m_bidang, b.nama_unor, b.id')
                            ->from('m_bidang a')
                            ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id', 'left')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        }
        
        public function getUnorSiasnByUnitKerja($id_unitkerja){
            return $this->db->select('a.*, c.*')
                        ->from('db_pegawai.unitkerja a')
                        ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.diatasan_id')
                        ->join('db_siasn.m_ref_unor c', 'b.id = c.id')
                        ->where('a.id_unitkerja', $id_unitkerja)
                        ->get()->result_array();
        }

        public function getUnorSiasnByBidang($id_m_bidang){
            $data = $this->db->select('a.*, c.*, d.*')
                        ->from('m_bidang a')
                        ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                        ->join('db_siasn.m_unor_perencanaan b', 'c.id_unor_siasn = b.diatasan_id', 'left')
                        ->join('db_siasn.m_ref_unor d', 'b.id = d.id')
                        ->where('a.id', $id_m_bidang)
                        ->get()->result_array();

            $tambahan = $this->db->select('a.*, c.*')
                                ->from('m_bidang a')
                                ->join('db_siasn.m_unor_perencanaan b', 'a.id_unor_siasn = b.diatasan_id')
                                ->join('db_siasn.m_ref_unor c', 'b.id = c.id', 'left')
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
                            ->from('db_siasn.m_ref_unor')
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
                            ->from('db_siasn.m_ref_unor')
                            ->where('id', $data['id_unor_siasn'])
                            ->get()->row_array();
            return $rs;
        }

        public function getListSubBidangByIdBidang($id_m_bidang){
            return $this->db->select('a.*, b.nama_unor')
                        ->from('m_sub_bidang a')
                        ->join('db_siasn.m_ref_unor b', 'a.id_unor_siasn = b.id', 'left')
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
            $temp = null;
            $data = $this->db->select('*')
                            ->from('t_cron_async')
                            ->where('flag_done', 0)
                            ->where('flag_active', 1)
                            ->limit(5)
                            ->get()->result_array();
            if($data){
                foreach($data as $d){
                    $res = $this->apilib->asyncPost(base_url($d['url']), json_decode($d['param'], $d['method']));
                    $temp[] = $res;
                    $jsonRes = json_decode($res, true);
                    $update = null;
                    if($jsonRes && isset($jsonRes['code']) && $jsonRes['code'] == 0){
                    // if(!$jsonRes || ($jsonRes && $jsonRes['code'] == 0)){
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
            // dd("done ".count($temp));
        }

        public function removeLog($batasHari){
            $now = date('H:i');
            $expl = explode(":", $now);
            if($expl[0] == "22" && $expl[1] == "00"){ // jika jam 10 malam, jalankan ini
                $this->logCron('cronRemoveLog');
                $date = date('Y-m-d', strtotime('-'.$batasHari.' days', strtotime(date('Y-m-d'))));
                $arrTable = [
                    "t_log_maxchat",
                    "t_log_webhook",
                    "t_log_tte",
                    "t_log_ws_siasn",
                ];

                foreach($arrTable as $ar){
                    $this->db->where('created_date <', formatDateOnlyForEdit($date))
                            ->delete($ar);
                    echo "deleted ".$this->db->affected_rows()." from ".$ar."<br>";
                }

                //dihapus bulanan
                $dateBulanan = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))));
                $arrTableBulanan = [
                    "t_image_message"
                ];
                foreach($arrTableBulanan as $arTb){
                    $this->db->where('created_date <', formatDateOnlyForEdit($dateBulanan))
                            ->delete($arTb);
                    echo "deleted ".$this->db->affected_rows()." from ".$arTb."<br>";
                }

                $arrTableCron = [
                    [
                        'name' => "t_cron_async",
                        'col_done' => "flag_done",
                        'col_done_state' => 1
                    ],
                    [
                        'name' => "t_cron_rekap_absen",
                        'col_done' => "flag_sent",
                        'col_done_state' => 1
                    ],
                    [
                        'name' => "t_cron_wa",
                        'col_done' => "flag_sent",
                        'col_done_state' => 1
                    ],[
                        'name' => "t_cron_tte_bulk_ds",
                        'col_done' => "flag_done",
                        'col_done_state' => 1
                    ]
                ];

                foreach($arrTableCron as $atc){
                    $this->db->where('created_date <', formatDateOnlyForEdit($date))
                            ->where($atc['col_done'] == $atc['col_done_state'])
                            ->delete($atc['name']);
                    echo "deleted ".$this->db->affected_rows()." from ".$atc['name']."<br>";
                }
            }
        }

        public function notifVerifikatorPeninjauanAbsensi(){
            $this->logCron('notifVerifikatorPeninjauanAbsensi');

            $data = $this->db->select('a.id, d.nm_unitkerja, c.nama, c.nipbaru_ws, d.id_unitkerja, d.id_unitkerjamaster, a.tanggal_absensi')
                            ->from('t_peninjauan_absensi a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            // ->where('MONTH(a.created_date)', date('m'))
                            ->where('a.status', 0)
                            ->order_by('a.tanggal_absensi', 'ASC')
                            ->group_by('a.id')
                            ->get()->result_array();

            $listVerifikator = $this->db->select('*')
                                ->from('db_pegawai.pegawai')
                                ->where_in('nipbaru_ws', [
                                    199502182020121013, // tio
                                    198504202010011009, // kasub erik
                                    199611292022031012, // bob
                                    198910272022031003, // onal
                                    199401042020121011, // youri
                                    199110212022031006, // harun
                                ])
                                ->get()->result_array();
            
            $verifikator = null;
            foreach($listVerifikator as $lv){
                $verifikator[$lv['nipbaru_ws']] = $lv;                
                $verifikator[$lv['nipbaru_ws']]['data_count'] = 0;                
                $verifikator[$lv['nipbaru_ws']]['data'] = null;                
                $verifikator[$lv['nipbaru_ws']]['data_count_not_mapping'] = 0;                
            }
            $nipAdmin = "199401042020121011";

            if($data){
                foreach($data as $d){
                    $nipVerifikator = null;
                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_HARUN)){ //harun
                        if(!in_array($d['id_unitkerja'], VERIF_PA_SKPDNOTIN_HARUN) && in_array($d['id_unitkerja'], VERIF_PA_SKPDIN_HARUN)){
                            $nipVerifikator = "199110212022031006";
                        }
                    }

                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_ONAL)){ //ONAL
                        if(!in_array($d['id_unitkerja'], VERIF_PA_SKPDNOTIN_ONAL) && in_array($d['id_unitkerja'], VERIF_PA_SKPDIN_ONAL)){
                            $nipVerifikator = "198910272022031003";
                        }
                    }

                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_TIO)){ //TIO
                        $nipVerifikator = "199502182020121013";
                    }

                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_YOURI)){ //YOURI
                        $nipVerifikator = "199401042020121011";
                    }

                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_ERICK)){ //ERICK
                        $nipVerifikator = "198504202010011009";
                    }

                    if(in_array($d['id_unitkerjamaster'], VERIF_PA_SKPDMASTER_BOB)){ //BOB
                        $nipVerifikator = "199611292022031012";
                    }

                    if(!$nipVerifikator){ // jika null, tambahkan ke not mapping youri
                        $nipVerifikator = $nipAdmin;
                        $verifikator[$nipVerifikator]['data_count_not_mapping']++;
                        $verifikator[$nipVerifikator]['not_mapping_data'][] = $d;
                    } else {
                        $expl = explode("-", trim($d['tanggal_absensi']));
                        // $verifikator[$nipVerifikator]['data'][getNamaBulan($expl[1]).$expl[0]]['list'][] = $d;
                        if(isset($verifikator[$nipVerifikator]['data'][getNamaBulan($expl[1])." ".$expl[0]])){
                            $verifikator[$nipVerifikator]['data'][getNamaBulan($expl[1])." ".$expl[0]]['count']++;
                        } else {
                            $verifikator[$nipVerifikator]['data'][getNamaBulan($expl[1])." ".$expl[0]]['count'] = 1;
                        }
                    }
                }
                // dd($verifikator);
                $cronWa = null;
                foreach($verifikator as $verif){
                    $message = "*[VERIFIKATOR PENINJAUAN ABSENSI]*\n\nTotal belum verif: \n";

                    if($verif['data']){
                        foreach($verif['data'] as $k => $v){
                            if($k != "0000"){
                                $message .= $k.": *".$v['count']."* data\n";
                            }
                        }
                    }

                    if($verif['nipbaru_ws'] == $nipAdmin && $verifikator[$nipAdmin]['data_count_not_mapping'] > 0){ // youri
                        $message .= "\nTotal belum mapping: *".$verifikator[$nipAdmin]['data_count_not_mapping']."* data";
                    }
                    $message .= "\nLast Rekap: ".formatDateNamaBulanWithTime(date('Y-m-d H:i:s'));

                    $cronWa[$verif['nipbaru_ws']] = [
                        'type' => 'text',
                        'sendTo' => convertPhoneNumber($verif['handphone']),
                        'message' => $message,
                        'jenis_layanan' => "Verifikator Peninjauan Absensi",
                    ];
                }
                if($cronWa){
                    $this->db->insert_batch('t_cron_wa', $cronWa);
                }
            }
        }

        public function cronCheckVerifCuti(){
            // dd('asd');
            // $this->removeLog(3);
            // $this->notifVerifikatorPeninjauanAbsensi();

            $timeNow = date("H:i:s");
            $expl = explode(":", $timeNow);
            $flag_cek = 0;
            if($expl[0] == "11" && $expl[1] == "00"){
                // $flag_cek = 1;
            } else if($expl[0] == "22" && $expl[1] == "00"){
                $this->removeLog(10);
            } else if($expl[0] == "08" && $expl[1] == "30"){
                $this->notifVerifikatorPeninjauanAbsensi();
            } else {
                // dd("belum jam, ini masih ".$expl[0].":".$expl[1]);
            }
            // else if($expl[0] == "11" && $expl[1] == "45"){
            //     $flag_cek = 1;
            // }
            // if($this->general_library->isProgrammer()){
            //     $flag_cek = 1;
            // }
            if($flag_cek == 1){
                $this->logCron('cronCheckVerifCuti');
                
                $progressCuti = $this->db->select('a.*, b.id_m_user, c.flag_sent, c.temp_count, c.date_sent')
                                    ->from('t_progress_cuti a')
                                    ->join('t_pengajuan_cuti b', 'a.id_t_pengajuan_cuti = b.id')
                                    ->join('t_cron_wa c', 'a.chatId = c.chatId')
                                    // ->where('a.id_m_user_verifikasi !=', 527)
                                    ->where('a.nohp !=', NOMOR_HP_KABAN)
                                    ->where('a.flag_verif', 0)
                                    ->where('a.chatId IS NOT NULL')
                                    ->where('b.flag_active', 1)
                                    ->where('a.flag_active', 1)
                                    // ->where('flag_resend !=', 1)
                                    ->group_by('a.id')
                                    ->get()->result_array();

                $listProgressCuti = null;
                $listChatIdResend = null;
                if($progressCuti){
                    foreach($progressCuti as $pc){
                        $date1 = formatDateOnlyForEdit($pc['date_sent']);
                        $date2 = (date("Y-m-d"));
                        $diff = trim(countDiffDateLengkap($date1, $date2, ['hari']));
                        $diffCount = explode(" ", $diff);
                        if($diffCount[0] > 1){ // jika lebih dari 1 hari, resend
                            $listChatIdResend[] = $pc['chatId'];
                        }

                        if(isset($listProgressCuti[$pc['id_m_user_verifikasi']])){
                            $listProgressCuti[$pc['id_m_user_verifikasi']]['count']++;
                        } else {
                            $listProgressCuti[$pc['id_m_user_verifikasi']] = $pc;
                            $listProgressCuti[$pc['id_m_user_verifikasi']]['count'] = 1;
                        }
                    }
                }
                // dd($listChatIdResend);
                if($listChatIdResend){
                    $this->db->where_in('chatId', $listChatIdResend)
                            ->update('t_cron_wa', [
                                'temp_count' => 0,
                                'flag_sent' => 0,
                                'flag_resend' => 1,
                                'date_resend' => date('Y-m-d H:i:s')
                            ]);
                    // dd("Resend ".count($listChatIdResend)." pesan");
                } else {
                    // dd("no resend message");
                }
                $cronWaNextVerifikator = null;
                $listNip = [
                    199110282022042001,
                    198311012008032003
                ];
                $progressCutiWithoutChatId = $this->db->select('a.*, b.id_m_user, b.random_string, b.tanggal_mulai, b.tanggal_akhir, b.lama_cuti,
                                    c.nm_cuti, e.nama, e.gelar1, e.gelar2, e.skpd, b.id as id_t_pengajuan_cuti, e.nipbaru_ws,
                                    (
                                        SELECT aa.nama_jabatan
                                        FROM t_progress_cuti aa
                                        WHERE aa.urutan = (a.urutan)-1
                                        AND aa.id_t_pengajuan_cuti = b.id
                                        AND aa.flag_active = 1
                                        LIMIT 1
                                    ) as nm_jabatan_verifikator_sebelum
                                    ')
                                    ->from('t_progress_cuti a')
                                    ->join('t_pengajuan_cuti b', 'a.id = b.id_t_progress_cuti')
                                    ->join('db_pegawai.cuti c', 'b.id_cuti = c.id_cuti')
                                    ->join('m_user d', 'd.id = b.id_m_user')
                                    ->join('db_pegawai.pegawai e', 'e.nipbaru_ws = d.username')
                                    ->where('a.flag_verif', 0)
                                    ->where('a.chatId IS NULL')
                                    ->where('a.nohp !=', NOMOR_HP_KABAN)
                                    ->where('b.flag_active', 1)
                                    ->where('b.flag_ditolak', 0)
                                    ->group_by('a.id')
                                    ->where('b.flag_ds_cuti', 0)
                                    ->where('a.flag_active', 1)
                                    // ->where_in('e.nipbaru_ws', $listNip)
                                    // ->where('flag_resend !=', 1)
                                    // ->order_by('a.urutan', 'asc')
                                    // ->group_by('b.id')
                                    ->get()->result_array();

                $tempExists = null;
                if($progressCutiWithoutChatId){
                    // dd($progressCutiWithoutChatId);
                    $cronWaNextVerifikator = null;
                    foreach($progressCutiWithoutChatId as $pcw){
                        if(!isset($tempExists[$pcw['id_t_pengajuan_cuti']])){
                            if($pcw['tanggal_akhir'] > date('Y-m-d')){
                                $tempExists[$pcw['id_t_pengajuan_cuti']] = $pcw;

                                $pada_tanggal = formatDateNamaBulan($pcw['tanggal_mulai']);
                                if($pcw['tanggal_mulai'] != $pcw['tanggal_akhir']){
                                    $pada_tanggal .= " sampai ".formatDateNamaBulan($pcw['tanggal_akhir']);
                                }

                                $replyToNextVerifikator = "*[PERMOHONAN CUTI - ".$pcw['random_string']."]*\n\nSelamat ".greeting().
                                        ", pegawai atas nama: ".getNamaPegawaiFull($pcw)." telah mengajukan Permohonan ".
                                        $pcw['nm_cuti']." selama ".$pcw['lama_cuti']." hari pada ".$pada_tanggal;

                                if($pcw['nm_jabatan_verifikator_sebelum']){
                                    $replyToNextVerifikator .=  ". Permohonan Cuti ini telah disetujui sebelumnya oleh ".$pcw['nm_jabatan_verifikator_sebelum'];
                                }

                                $replyToNextVerifikator .= ". \n\nBalas dengan cara mereply pesan ini, kemudian ketik *YA* untuk menyetujui atau *Tidak* untuk menolak.";

                                $cronWaNextVerifikator[] = [
                                    'sendTo' => convertPhoneNumber($pcw['nohp']),
                                    'message' => trim($replyToNextVerifikator.FOOTER_MESSAGE_CUTI),
                                    'type' => 'text',
                                    'ref_id' => $pcw['id_t_pengajuan_cuti'],
                                    'jenis_layanan' => 'Cuti',
                                    'table_state' => 't_progress_cuti',
                                    'column_state' => 'chatId',
                                    'id_state' => $pcw['id']
                                ];
                            }
                        }
                    }

                    if($cronWaNextVerifikator){
                        // dd($cronWaNextVerifikator);
                        $this->db->insert_batch('t_cron_wa', $cronWaNextVerifikator);
                    }
                }
            }

            $paramZipSkCuti = $this->db->select('a.*, c.handphone')
                                    ->from('m_parameter a')
                                    ->join('m_user b', 'a.updated_by = b.id')
                                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                    ->where('parameter_name', "PARAM_ZIP_NAME_SK_CUTI")
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    // ->where('flag_sent', 0)
                                    ->get()->row_array();

            if($paramZipSkCuti){
                if($paramZipSkCuti['flag_sent'] == 0){
                    $this->db->insert('t_cron_wa', [
                        'sendTo' => convertPhoneNumber($paramZipSkCuti['handphone']),
                        'message' => "REKAP SK CUTI per ".formatDateNamaBulanWithTime(date('Y-m-d H:i:s')),
                        'filename' => $paramZipSkCuti['parameter_value'],
                        'fileurl' => ($paramZipSkCuti['parameter_value']),
                        'type' => 'document',
                        'jenis_layanan' => 'ZIP SK Cuti'
                    ]);

                    $this->db->where('id', $paramZipSkCuti['id'])
                                ->update('m_parameter', [
                                    'flag_sent' => 1,
                                    'date_sent' => date('Y-m-d H:i:s')
                                ]);
                } else {
                    if(file_exists($paramZipSkCuti['parameter_value'])){
                        // unlink(($paramZipSkCuti['parameter_value']));
                    }
                }
            }
        }

        public function getListPengadaan($tahun){
            // $result = $this->siasnlib->getListPengadaan($tahun);
            // dd($result);
            // $res = json_decode($result['data'], true)['data'];
            // dd($res);
            // $pns = null;
            // $pppk = null;
            // foreach($res as $r){
            //     if($r['jenis_formasi_id'] == "0101"){
            //         $pns[] = $r;
            //     } else if($r['jenis_formasi_id'] == "0101"){
            //         $pppk[] = $r;
            //     }
            // }

            // $listExists = null;
            // $i = 0;
            // foreach($exists as $e){
            //     $listExists['nip'] = $e;
            //     $i++;
            // }

            //0208 pppk teknis

            $tNip = null;
            $tempNip = $this->db->select('*')
                                ->from('t_temp_data_pppk_pw')
                                ->get()->result_array();
            foreach($tempNip as $tn){
                $tNip[$tn['nip']] = $tn;
            }

            $dataPppk = null;
            $resultJson = $this->db->select('*')
                            ->from('m_parameter')
                            ->where('parameter_name', 'TEMP_PPPK_PW')
                            ->get()->row_array();
            $result = json_decode("[".$resultJson['parameter_value']."]", true);
            $exists = null;
            $double = null;
            foreach($result as $rs){
                if(isset($tNip[$rs['nip']]) && !isset($dataPppk[$rs['nip']])){
                    $dataPppk[$rs['nip']] = $rs;
                }

                if(!isset($exists[$rs['nip']])){
                    $exists[$rs['nip']] = $rs;
                    $double[$rs['nip']] = 1;
                } else {
                    $double[$rs['nip']]++;
                }
            }
            // dd($double);
            // dd(($exists));
            // echo "total_data_m_parameter: ".count($result);
            dd($dataPppk);

        }

        public function retrieveImageMessage($rs){
            $expl = explode(".", $rs->url);
            $filename = "arsipimagemessagewa/".date('Ymd')."_".generateRandomString().".".$expl[count($expl)-1];
            $ch = curl_init($rs->url);
            $fp = fopen($filename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            
            date_default_timezone_set("Asia/Singapore");
            // $rs->time = 1749795765000;
            $formattedDt = substr(strval($rs->time), 0, strlen(strval($rs->time))-3);

            $dateTimeObj = new DateTime();
            $dateTimeObj->setTimestamp($formattedDt);
            $dateTime = $dateTimeObj->format("Y-m-d H:i:s");
            
            $pegawai = $this->db->select('*')
                                ->from('db_pegawai.pegawai')
                                ->where('handphone', "0".substr($rs->from, 2, strlen($rs->from)))
                                ->get()->row_array();

            $namaFile = date('ymdhis');
            if($pegawai){
                $namaFile = $pegawai['nipbaru_ws']."_".$namaFile; 
            }
            $namaFile .= ".jpg";

            $ch = curl_init($rs->url);
            $fp = fopen('arsipimagewa/'.$namaFile, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            $this->db->insert('t_image_message', [
                'sender' => $rs->from,
                'nip' => $pegawai ? $pegawai['nipbaru_ws'] : null,
                'url' => 'arsipimagewa/'.$namaFile,
                'date_received' => $dateTime
            ]);
        }

        public function syncUnor(){
            $res = $this->siasnlib->getAllDataUnor();
            if($res['code'] == 0){
                $listUnorPerencanaan = null; 
                $mUnorPerencanaan = $this->db->select('*')
                                        ->from('db_siasn.m_unor_perencanaan')
                                        ->get()->result_array();
                if($mUnorPerencanaan){
                    foreach($mUnorPerencanaan as $mup){
                        $listUnorPerencanaan[$mup['id']] = $mup;
                    }
                }

                $listRefUnor = null; 
                $mRefUnor = $this->db->select('*')
                                        ->from('db_siasn.m_ref_unor')
                                        ->get()->result_array();
                if($mRefUnor){
                    foreach($mRefUnor as $mru){
                        $listRefUnor[$mru['id']] = $mru;
                        $listRefUnor[strtoupper($mru['nama_unor'])] = $mru;
                    }
                }

                // $unitKerjaNotMapping = $this->db->select('*')
                //                             ->from('db_pegawai.unitkerja')
                //                             ->where('id_unor_siasn', null)
                //                             ->get()->result_array();

                // foreach($unitKerjaNotMapping as $uknm){
                //     if(isset($listRefUnor[strtoupper($uknm['nm_unitkerja'].' MANADO')])){
                //         $this->db->where('id_unitkerja', $uknm['id_unitkerja'])
                //                 ->update('db_pegawai.unitkerja', [
                //                     'id_unor_siasn' => $listRefUnor[strtoupper($uknm['nm_unitkerja'].' MANADO')]['id']
                //                 ]);
                //         echo "update unor siasn ".$uknm['nm_unitkerja']." => ".$listRefUnor[strtoupper($uknm['nm_unitkerja'].' MANADO')]['id']."<br>";
                //     }
                // }

                // batas here

                $list = json_decode($res['data'], true);
                $insertMUnorPerencanaan = null;
                $insertMRefUnor = null;

                foreach($list['data'] as $l){
                    // dd($list['data']);
                    if(isset($listUnorPerencanaan[$l['Id']])){
                        $this->db->where('id', $l['Id'])
                                ->update('db_siasn.m_unor_perencanaan', [
                                    'nama_unor' => $l['NamaUnor'],
                                    'diatasan_id' => $l['DiatasanId'],
                                    'induk_unor_id' => $l['IndukUnorId'],
                                    'jenis_unor_id' => $l['JenisUnorId'],
                                ]);
                        echo "update unor perencanaan ".$l['NamaUnor']." id: ".$l['Id']."<br>";
                    } else {
                        echo "put in insert unor perencanaan ".$l['NamaUnor']." id: ".$l['Id']."<br>";
                        $insertMUnorPerencanaan[$l['Id']] = [
                            'id' => $l['Id'],
                            'nama_unor' => $l['NamaUnor'],
                            'diatasan_id' => $l['DiatasanId'],
                            'induk_unor_id' => $l['IndukUnorId'],
                            'jenis_unor_id' => $l['JenisUnorId'],
                        ];
                    }

                    if(isset($listRefUnor[$l['Id']])){
                        $this->db->where('id', $l['Id'])
                                ->update('db_siasn.m_ref_unor', [
                                    'nama_unor' => $l['NamaUnor'],
                                    'id' => $l['Id']
                                ]);
                        echo "update unor ".$l['NamaUnor']."id: ".$l['Id']."<br>";
                    } else {
                        echo "put in insert unor ".$l['NamaUnor']."id: ".$l['Id']."<br>";
                        $insertMRefUnor[$l['Id']] = [
                            'id' => $l['Id'],
                            'nama_unor' => $l['NamaUnor'],
                        ];
                    }
                }

                if($insertMUnorPerencanaan){
                    $this->db->insert_batch('db_siasn.m_unor_perencanaan', $insertMUnorPerencanaan);
                    echo "insert unor perencanaan ".count($insertMUnorPerencanaan)."<br>";
                }

                if($insertMRefUnor){
                    $this->db->insert_batch('db_siasn.m_ref_unor', $insertMRefUnor);
                    echo "insert unor perencanaan ".count($insertMRefUnor)."<br>";
                }
            }
        }

        public function getLastFormatNomorSurat($nomorSuratLayanan = "800", $tahun = 0){
            if($tahun == 0){
                $tahun = date('Y');
            }

            $counter = 1;
            $this->db->select('*')
                ->from('t_nomor_surat')            
                ->order_by('counter', 'desc')
                ->where('flag_active', 1)
                ->limit(1);

            if(FLAG_CONTINUE_NOMOR_SURAT == 0){ // jika tetap lanjut walaupun ada perubahan format baru format baru
                $this->db->where('nomor_surat LIKE "'.FORMAT_NOMOR_SURAT.$tahun.'"');
            }
            $data = $this->db->get()->row_array();

            if($data){
                $counter = $data['counter']+1;
            }

            // format [0] harus dicek agar pas dengan parameter yang akan dimasukkan pada format nomor surat
            $format[0] = $nomorSuratLayanan;
            $format[4] = $counter;

            $expl = explode("/", FORMAT_NOMOR_SURAT);
            $i = 0;
            $generatedNomorSurat = "";
            foreach($expl as $e){
                if(isset($format[$i])){
                    $generatedNomorSurat .= $format[$i];
                } else {
                    $generatedNomorSurat .= $e;
                }
                if($i < count($expl)-1){
                    $generatedNomorSurat .= "/";
                }
                $i++;
            }
            $generatedNomorSurat .= $tahun;

            return [
                'nomor_surat' => $generatedNomorSurat,
                'counter' => $counter
            ];
        }

        public function updateDataPPPK($nip, $flag_save = 0){
            if($flag_save == 1 && $nip == 0){
                dd("harus mengisi nip jika ingin melakukan penyimpanan data");
            }

            $tempMetaData = $this->db->select('*')
                                    ->from('t_temp_meta_data')
                                    ->where('nama', 'DATA_PPPK_T1_2024')
                                    ->get()->row_array();
            if($tempMetaData){
                $result = json_decode($tempMetaData['meta_data'], true);

                $tNip = null;
                $tempNip = null;
                $selectedPegawai = null;

                $this->db->select('*')
                        ->from('t_temp_data_pppk2024');
                if($nip != 0){
                    $this->db->where('nip', $nip);
                }
                $tempNip = $this->db->get()->result_array();
                
                if($tempNip){
                    foreach($tempNip as $tn){
                        $tNip[$tn['nip']] = $tn;
                    }

                    $listPegawai = null;
                    foreach($result as $rs){
                        if(isset($tNip[$rs['nip']])){
                            $listPegawai[$rs['nip']] = $rs;
                            // if($flag_save == 1){
                                $selectedPegawai = $rs;
                            // }
                        }
                    }

                    if($nip == 0){
                        dd($listPegawai);
                    } else {
                        $dataPegawai = $this->db->select('a.gelar1, a.gelar2, a.nama, a.nipbaru_ws, a.id_peg,
                                            b.gambarsk as url_jabatan, c.gambarsk as url_berkas,
                                            d.gambarsk as url_arsip')
                                            ->from('db_pegawai.pegawai a')
                                            ->join('db_pegawai.pegjabatan b', 'a.id_peg = b.id_pegawai AND b.flag_active = 1')
                                            ->join('db_pegawai.pegberkaspns c', 'a.id_peg = c.id_pegawai AND c.flag_active = 1')
                                            ->join('db_pegawai.pegarsip d', 'a.id_peg = d.id_pegawai AND d.flag_active = 1')
                                            ->where('nipbaru_ws', $selectedPegawai['nip'])
                                            ->get()->row_array();
                        if($dataPegawai){
                            $agama = 1;
                            if($selectedPegawai['agama_nama'] == 'Katholik'){
                                $agama = 2;
                            } else if($selectedPegawai['agama_nama'] == 'Islam'){
                                $agama = 3;
                            } else if($selectedPegawai['agama_nama'] == 'Hindu'){
                                $agama = 4;
                            } else if($selectedPegawai['agama_nama'] == 'Buddha'){
                                $agama = 5;
                            }

                            if($flag_save == 1){
                                $this->db->where('id_peg', $dataPegawai['id_peg'])
                                        ->update('db_pegawai.pegawai', [
                                            'nama' => $selectedPegawai['nama'],
                                            'gelar1' => $selectedPegawai['gelar_depan'],
                                            'gelar2' => $selectedPegawai['gelar_belakang'],
                                            'jk' => $selectedPegawai['jenis_kelamin'] == "M" ? "Laki-Laki" : "Perempuan",
                                            'tptlahir ' => $selectedPegawai['tempat_lahir'],
                                            'tgllahir ' => $selectedPegawai['tanggal_lahir'],
                                        ]);

                                $this->db->where('id_pegawai', $dataPegawai['id_peg'])
                                        ->update('db_pegawai.pegjabatan', [
                                            'gambarsk' => "SK_".$selectedPegawai['nip']."_".$selectedPegawai['nama']."_sign_sign.pdf"
                                        ]);
                                
                                $this->db->where('id_pegawai', $dataPegawai['id_peg'])
                                        ->update('db_pegawai.pegberkaspns', [
                                            'gambarsk' => "SK_".$selectedPegawai['nip']."_".$selectedPegawai['nama']."_sign_sign.pdf"
                                        ]);
                                
                                $temp['gelar1'] = $selectedPegawai['gelar_depan'];
                                $temp['gelar2'] = $selectedPegawai['gelar_belakang'];
                                $temp['nama'] = $selectedPegawai['nama'];

                                $this->db->where('id_pegawai', $dataPegawai['id_peg'])
                                        ->where('id_dokumen', 34)
                                        ->update('db_pegawai.pegarsip', [
                                            'gambarsk' => getNamaPegawaiFull($temp, 1)."_sign.pdf"
                                        ]);
                            }
                        }
                        return [
                            'temp' => $selectedPegawai,
                            'db' => $dataPegawai 
                        ];
                    }

                } else {
                    dd("nip null ".$nip);
                }
            }
        }

        public function cekSidak(){
            $this->db->trans_begin();

            $agenda = $this->db->select('a.id, a.judul, a.buka_masuk, a.tgl, d.id_unitkerja')
                            ->from('db_sip.agenda a')
                            ->join('db_sip.peserta_agenda b', 'a.id = b.agenda_id')
                            ->join('db_sip.skpd c', 'b.skpd_id = c.id')
                            ->join('db_pegawai.unitkerja d', 'c.unit_id = d.id_unitkerja')
                            ->where('a.flag_sidak', 1)
                            ->where('a.flag_rekap_sidak', 0)
                            // ->where('a.id', 160) // ini untuk testing, comment untuk sidak semua
                            ->get()->result_array();

            $listAgendaTanggal = null;
            $listAgendaUker = null;
            $listAgenda = null;
            if($agenda){
                foreach($agenda as $a){
                    $listAgenda[$a['id']] = [
                        'id_agenda' => $a['id'],
                        'id_unitkerja' => $a['id_unitkerja'],
                        'tanggal' => $a['tgl'],
                        'jam_absen' => $a['buka_masuk'],
                        'judul' => $a['judul']
                    ];
                }
                
                if($listAgenda){
                    $dataSidak = null;
                    foreach($listAgenda as $la){
                        // update flag_rekap_sidak jadi 1
                        $this->db->where('id', $la['id_agenda'])
                                ->update('db_sip.agenda', [
                                    'flag_rekap_sidak' => 1
                                ]);

                        $dataAbsenAgenda = $this->db->select('b.id as id_m_user')
                                                ->from('db_sip.absen_event a')
                                                ->join('m_user b', 'a.user_id = b.id')
                                                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                                ->where('b.flag_active', 1)
                                                ->where('c.skpd', $la['id_unitkerja'])
                                                ->where('a.tgl', $la['tanggal'])
                                                ->get()->result_array();
                        $listAbsenAgenda = null;
                        if($dataAbsenAgenda){
                            foreach($dataAbsenAgenda as $daa){
                                $listAbsenAgenda[$daa['id_m_user']] = $daa; // buat list data absen
                            }
                        }
                        
                        $dataAbsenReguler = $this->db->select('b.id as id_m_user, c.gelar1, c.gelar2, c.nama, c.handphone')
                                                ->from('db_sip.absen a')
                                                ->join('m_user b', 'a.user_id = b.id')
                                                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                                ->where('b.flag_active', 1)
                                                ->where('c.skpd', $la['id_unitkerja'])
                                                ->where('a.tgl', $la['tanggal'])
                                                ->get()->result_array();
                        $listAbsenReguler = null;
                        if($dataAbsenReguler){
                            foreach($dataAbsenReguler as $dar){
                                if(!isset($listAbsenAgenda[$dar['id_m_user']])){ // cek jika ada absen biasa dan tidak ada di absen agenda maka kena sidak
                                    $dataSidak[] = [
                                        'id_m_user' => $dar['id_m_user'],
                                        'keterangan' => "Tidak melakukan presensi Sidak pada ".$la['judul']." tanggal ".formatDateNamaBulan($la['tanggal'])." ".$la['jam_absen'],
                                        'nama_pegawai' => getNamaPegawaiFull($dar),
                                        'handphone' => $dar['handphone'],
                                        'tanggal' => $la['tanggal']
                                    ];
                                }
                            }
                        }
                    }

                    if($dataSidak){
                        $dokpenSidak = null;
                        $cronWa = null;
                        $mSidak = $this->db->select('*')
                                        ->from('m_jenis_disiplin_kerja')
                                        ->where('keterangan', 'SIDAK')
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                        
                        foreach($dataSidak as $ds){
                            $explTgl = explode("-", $ds['tanggal']);
                            $dokpenSidak[] = [
                                'id_m_user' => $ds['id_m_user'],
                                'tanggal' => $explTgl[2],
                                'bulan' => $explTgl[1],
                                'tahun' => $explTgl[0],
                                'id_m_jenis_disiplin_kerja' => $mSidak['id'],
                                'keterangan' => $mSidak['keterangan'],
                                'pengurangan' => $mSidak['pengurangan'],
                                'status' => 2,
                                'tanggal_verif' => date('Y-m-d H:i:s'),
                                'id_m_user_verif' => 1,
                                'random_string' => generateRandomString(),
                                'flag_fix_tanggal' => 0,
                                'flag_fix_jenis_disiplin' => 0,
                                'flag_fix_dokumen_upload' => 0,
                                'keterangan_sistem' => $ds['keterangan']
                            ];

                            // $cronWa[] = [
                            //     'sendTo' => convertPhoneNumber($ds['handphone']),
                            //     'message' => "*[SIDAK]*\n\nSelamat ".greeting()." ".$ds['nama_pegawai'].", berdasarkan data di sistem kami bahwa pada ".formatDateNamaBulan($ds['tanggal']).", Anda dikenakan pelanggaran *SIDAK* dengan keterangan: *".$ds['keterangan']."*",
                            //     'flag_prioritas' => 0,
                            //     'type' => 'text'
                            // ];
                        }
                        if($dokpenSidak){
                            $this->db->insert_batch('t_dokumen_pendukung', $dokpenSidak);
                            echo "done insert: ".count($dokpenSidak)."\n";
                        }

                        // if($cronWa){
                        //     $this->db->insert_batch('t_cron_wa', $cronWa);
                        //     echo "done insert: ".count($cronWa);
                        // }
                    }
                }
            }
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        public function getNotifikasiPegawai(){
            $data = $this->db->select('*')
                        ->from('t_notifikasi')
                        ->where('id_m_user', $this->general_library->getId())
                        ->where('flag_active', 1)
                        ->order_by('created_date', 'desc')
                        ->get()->result_array();

            $notif['show'] = null;
            $notif['read'] = null;
            $notif['total'] = 0;
            if($data){
                $notif['total'] = count($data);
                foreach($data as $d){
                    if($d['flag_read'] == 0){
                        $notif['show'][] = $d;
                    } else {
                        $notif['read'][] = $d;
                    }
                }
            }

            return $notif;
        }

        public function cronCheckDataBangkom($nip = ""){
            $this->db->select('nipbaru_ws')
                    ->from('db_pegawai.pegawai')
                    ->where('id_m_status_pegawai', 1);

            if($nip != ""){
                $this->db->where('nipbaru_ws', $nip);
            } else {
                $this->db->where('flag_cek_bangkom', 0)
                        ->limit(200);
            }
            $pegawai = $this->db->get()->result_array();

            if($pegawai){
                $listNipPegawai = null;
                foreach($pegawai as $p){
                    $listNipPegawai[] = $p['nipbaru_ws'];
                }
                $minDatePengecekan = "2026-02-28";
                
                $dateNow = date('Y-m-d');
                $listDate = getMonthsBetweenDate($minDatePengecekan, $dateNow);

                $dataCekBangkom = $this->db->select('*')
                                ->from('t_cek_bangkom')
                                ->where('flag_active', 1)
                                ->where('flag_exception', 0)
                                ->order_by('bulan_tahun', 'asc');
                if($nip != ""){
                    $this->db->where('nip', $nip);
                } else {
                    $this->db->where_in('nip', $listNipPegawai);
                }
                $dataCekBangkom = $this->db->get()->result_array();
                if($dataCekBangkom){
                    $dataPerPegawai = null;
                    $dpp = null;
                    $wajibCapaiJumlahJp = 3;
                    foreach($dataCekBangkom as $dc){
                        $dpp[$dc['nip']][] = $dc;
                        $jumlah_jp = $dc['jumlah_jp'] ? $dc['jumlah_jp'] : 0;
                        if(!isset($dataPerPegawai[$dc['nip']])){ // jika belum ada maka set data
                            $dataPerPegawai[$dc['nip']] = $dc;
                            $dataPerPegawai[$dc['nip']]['utang'] = $wajibCapaiJumlahJp - $jumlah_jp;
                            $dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom'] = null;
                            if($dataPerPegawai[$dc['nip']]['utang'] > 0){
                                $dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom'][] = $dc['id'];
                            } else {
                                $dataPerPegawai[$dc['nip']]['utang'] = 0;
                            }
                            // dd($dataCekBangkom);
                        } else { // jika sudah ada maka cek utang
                            $dataPerPegawai[$dc['nip']]['bulan'] = $dc['bulan'];
                            $dataPerPegawai[$dc['nip']]['tahun'] = $dc['tahun'];
                            $dataPerPegawai[$dc['nip']]['bulan_tahun'] = $dc['bulan_tahun'];
                            $dataPerPegawai[$dc['nip']]['jumlah_jp'] = $dc['jumlah_jp'];
                            $dataPerPegawai[$dc['nip']]['flag_terpenuhi'] = $dc['flag_terpenuhi'];
                            $dataPerPegawai[$dc['nip']]['flag_ditebus'] = 0;
                            
                            $dataPerPegawai[$dc['nip']]['utang'] += $wajibCapaiJumlahJp;
                            $dataPerPegawai[$dc['nip']]['utang'] -= $jumlah_jp;

                            // $dataPerPegawai[$dc['nip']]['utang'] += $jumlah_jp;
                            // $dataPerPegawai[$dc['nip']]['utang'] -= $wajibCapaiJumlahJp;
                            // $perhitunganJp = $jumlah_jp - $dataPerPegawai[$dc['nip']]['utang'];
                            if($dataPerPegawai[$dc['nip']]['utang'] <= 0){
                                $dataPerPegawai[$dc['nip']]['utang'] = 0;
                                if($dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom']){
                                    $this->db->where_in('id', $dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom'])
                                        ->update('t_cek_bangkom', [
                                            'flag_ditebus' => 1
                                        ]);
                                    $dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom'] = null;
                                }
                            } else {
                                $dataPerPegawai[$dc['nip']]['list_id_t_cek_bangkom'][] = $dc['id'];
                            }
                        }
                    }
                    $this->db->where_in('nipbaru_ws', $listNipPegawai)
                            ->update('db_pegawai.pegawai', [
                                'flag_cek_bangkom' => 1
                            ]);
                } else {
                    $this->db->where_in('nipbaru_ws', $listNipPegawai)
                            ->update('db_pegawai.pegawai', [
                                'flag_cek_bangkom' => 1
                            ]);
                }
            } else { // jika semua sudah dicek, reset jadi 0 lagi
                // dd("all done");
                $this->db->where('id_m_status_pegawai', 1)
                        ->update('db_pegawai.pegawai', [
                            'flag_cek_bangkom' => 0
                        ]);
            }
        }

        public function cronCheckBangkom($bulan = 0, $tahun = 0, $nip = "", $id_unitkerja = 0){
            if($nip == ""){
                $exists = $this->db->select('*')
                                ->from('t_cek_bangkom')
                                ->where('flag_active', 1)
                                ->where('tahun', $tahun)
                                ->where('bulan', $bulan)
                                ->limit(1)
                                ->get()->row_array();
                if($exists){
                    dd('exists');
                    return;
                }
            }

            if($bulan == 0){
                $bulan = date('m');
            }

            if($tahun == 0){
                $tahun = date('Y');
            }

            if($tahun == null){
                return;
            }
            $this->db->select('a.nipbaru_ws, c.id as id_t_cek_bangkom,
                                sum(b.jam) as total_jp
                            ')
                            ->from('db_pegawai.pegawai a')
                            ->join("db_pegawai.pegdiklat b", "a.id_peg = b.id_pegawai AND b.flag_active = 1 AND b.status = 2 AND MONTH(b.tglsttpp) ='".$bulan."' AND YEAR(b.tglsttpp) = '".$tahun."'", "left")
                            ->join("t_cek_bangkom c", "a.nipbaru_ws = c.nip AND c.flag_active = 1 AND c.bulan = '".$bulan."' AND c.tahun = '".$tahun."'", "left")
                            ->where('a.id_m_status_pegawai', 1)
                            // ->where("a.nipbaru_ws NOT IN (
                            //     SELECT aa.nip
                            //     FROM t_cek_bangkom aa
                            //     WHERE aa.bulan = '".$bulan."'
                            //     AND aa.tahun = '".$tahun."'
                            //     AND aa.flag_active = 1
                            // )")
                            // ->where('b.flag_active', 1)
                            // ->where('b.status', 2)
                            // ->where('MONTH(b.tglsttpp)', $bulan)
                            // ->where('YEAR(b.tglsttpp)', $tahun)
                            // ->limit(1000)
                            ->group_by('a.nipbaru_ws');
                            // ->get()->result_array();
            if($nip != ""){
                $this->db->where('a.nipbaru_ws', $nip);
            }

            if($id_unitkerja != 0){
                $this->db->where('a.skpd', $id_unitkerja);
            }

            $pegawai = $this->db->get()->result_array();
            // dd($pegawai);
            if($pegawai){
                foreach($pegawai as $p){
                    $updateData['jumlah_jp'] = $p['total_jp'] ? $p['total_jp'] : 0;
                    $updateData['nip'] = $p['nipbaru_ws'];

                    $updateData['bulan'] = $bulan < 10 ? "0".intval($bulan) : $bulan;
                    $updateData['tahun'] = $tahun;
                    $updateData['bulan_tahun'] = $tahun."-".$updateData['bulan']."-01";

                    $updateData['flag_terpenuhi'] = $updateData['jumlah_jp'] >= 3 ? 1 : 0;
                    // dd($updateData);
                    if($p['id_t_cek_bangkom']){
                        $updateData['updated_by'] = $this->general_library->getId();
                        $this->db->where('id', $p['id_t_cek_bangkom'])
                                ->update('t_cek_bangkom', $updateData);
                    } else {
                        $updateData['created_by'] = $this->general_library->getId();
                        $this->db->insert('t_cek_bangkom', $updateData);
                    }
                }
            }

            if($nip != ""){
                $this->cronCheckDataBangkom($nip);
            }
        }

        public function editPdf(){
            $data = json_decode('{"result":{"url_template":"arsipbkpsdmbacirita/sertifikat/_SERTIKAT9MARET2026.png","nomor_surat":{"flag_show":"1","content":"*nomor_surat*","margin-top":"0","margin-left":"0","font-size":"0"},"nama_lengkap":{"flag_show":"1","content":"*nama_pegawai*","margin-top":"0","margin-left":"0","font-size":"0"},"nip":{"flag_show":"0","content":"*nip_pegawai*","margin-top":"0","margin-left":"0","font-size":"0"},"jabatan":{"flag_show":"0","content":"*jabatan_pegawai*","margin-top":"0","margin-left":"0","font-size":"0"},"unit_kerja":{"flag_show":"0","content":"*unit_kerja_pegawai*","margin-top":"0","margin-left":"0","font-size":"0"},"qr":{"flag_show":"1","src":"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAA1IAAANSCAIAAADgRGhQAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nOzdd3wUdf7H8c\/M9t30QiD0EiB0SIBQ7R1FFE89\/d1ZsHt27+x3FrA37AU7ytl7ARUBRZCSBELvpBDS62b7\/P5Y5BAIJGHHFef1\/MNHmJ19z3eXzfJ2vlOURQLoy5yUlFVZqUdywfDhjUuX6pF8eBne1KTa7RGPXT9xYvWnn0Y8Nu2qq7o9\/XTEYz0bN+ZnZEQ8VkSGbNpk69FDj2Rgt6WJicGammiPAn9miqqOCAbVaA8DAAAAvwdqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAIZp1yO0+b5srK0ikcOqn74YeS+++P9ijwR9HxP\/9Ju+qqiMdaO3eOeKaIWNPT+37zjR7Jlg4d9IjVSf3ChcV33x3xWNVu7\/3JJxGP1U\/l22+Xv\/56xGMdfft2ffLJiMfqJ\/222+KOOCLao0DrNCxZUnTHHTqF61X7XFlZ8ccfr1M4dBKoqor2EPAH4ho6NNpDaAXV6eQ7R0QCO3fWzp4d8VjV6Yx4pq48mzbp8T4Ea2sjnqkr5+DB\/F4cdrRgUL9wJnkBAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQzBHewCt07hsWd28edEeRfQlnHCCo3\/\/aI\/iTyt27NiYESMiHusrKqp8992Ix4pI6ZNPKhZLxGMTJ0609+wZ8Vh3Xl7t999HPNackJB60UURjxWR8hkzArW1eiTroWnlSj1itUBgx2OP6ZGsl1Coww03RDzV2rVrxDMPR+6CgtrZs6M9iuiLO\/JI17Bh0R5F6xxmta9u3rztN94Y7VFEnzkpidqnn4STTkq\/7baIx9bPn69T7Su85RY9Yu29eulR++p\/+kmP32J7r1461b7iadO8mzfrkXwY0Xy+w+u7t+Odd3Z59NFoj+JPq3Hx4sPr86CTro8\/ftjVPiZ5AQAADIHaBwAAYAjUPgAAAEOg9gEAABgCtQ8AAMAQqH0AAACGQO0DAAAwBGofAACAIVD7AAAADIHaBwAAYAjUPgAAAEOg9gEAABgCtQ8AAMAQqH0AAACGQO0DAAAwBGofAACAIVD7AAAADIHaBwAAYAjUPgAAAEOg9gEAABgCtQ8AAMAQqH0AAACGQO0DAAAwBGofAACAIVD7AAAADIHaBwAAYAjUPgAAAEMwR3sAwB+Of+dOd0GBHrHOAQMiHisi7lWrRNP0SNaDOTlZj\/fB0r69Hn9rIqL5fHrE6sQUF2fr0iXao4g+S7t20R4C8EdE7QP2Vjp9eun06RGPjR0\/fuDKlRGPFZElDkfI49EjWQ\/J55yTfM45EY\/1bNyYn5ER8djDTtwxx\/T+8MNojwLAHxSTvAAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMwRztAQBt1\/fLL0N+f7RH0VKq1apT8pDNmzVNi3isOSkp4pkiUv7aa0W33x7xWC0QiHgmfgfrJ01q\/OWXaI+ipZxDh\/b5\/PNojwJoO2ofDmPm1NRoD+EPwdKhQ7SH0AqhxkZfSUm0R4E\/ikBFxWH0ebB27hztIQCHhEleAAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBDM0R5A6ySccII5KSnao4i+2LFjoz2EP4Tie+7xbtkS8dikM89MmDAh4rH62XLppZrfH+1RtFTT2rXRHsIfQsrf\/hZ31FERjw1UVGy+8MKIxyo2W\/fnn494rH4STzstcdKkiMdaUlIinnk4ih0\/vserr0Z7FNEXM2JEtIfQaodZ7XP07+\/o3z\/ao8AfRfVnnzUuXRrxWHtGxuFV+yrefDPk8UR7FGid2FGjUi+4IOKx1R99tP3mmyMeqzqdh1ftcw4erMfbizB7RoY9IyPao0BbMMkLAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGIJZp9y6H34IVFXpFA6d1C9cGO0h\/Jn5y8rqvv9ej+SkM8\/UgsGIx9YvWOArLo54rD0jw5WVFfHYYENDzeefRzxWRBJPPVV1uSIeG6ipqZw1K+Kx\/h07ks85J+Kxitmsx2hFxDl4sLVTp8jnqqoeAzYnJcUff3zEY\/XT8NNPEgpFexRoHXdenn7hetW+kvvv1ykZOEx51q7deO65eiQPb2pS7faIx66fOFGP2hd\/\/PHdnn464rGejRt1qn1dn3jC1qNHxGO3XHFF4a23Rjw2cdKk3h9+GPHYkNu9RIfuKyL9FiyIHTs24rHF996rx69bzMiRh1ftK50+XaZPj\/Yo8AfCJC8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCGZzUlK0x4A\/OXNiok7Jpvh4PT7AmqYFqqoiHhtyu\/X6dVMUXWKhJ5PLpcfnwRQTE\/HMMJ0+vSG3W49fN9FnwKa4uIhnhpkTExWVHTHQk6qKiDmrsjLaAwHaKPPbb\/WILbz99mXJyRGPjR0\/nl837NblkUe6PPJItEfRUqrTqdOnd\/W4cfU\/\/hjx2I533nl4\/boN2bw52kOAIfD\/FgAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMwVwwfHi0x9AKKeed1\/6666I9ilZYd\/LJ\/vLyaI8iykzx8ZnffhvtUbRC2pVXJk2aFPFYU2xsxDPDVo8ZE\/L5Ih6bdsUVHe+8M+KxdfPm6fG1o3m9Ec\/UVckDD1R98EHEY+OOPLLLww9HPDbk8aweNy7isSLiWbtWj1iEFd52W+2cORGPTZw4seMdd0Q81r9z57oJEyIeizBFVfsvXmxuXLo02iNphbjx46M9hNZx5+f7SkqiPYooMyclRXsIrWPt2NHasWO0R9EKjcuXhzyeiMeaU1Jc2dkRj21YvPjw+trRiXfbNj3eB2vnzhHPFBEJhfhbOxx5N23S4y\/OOXhwxDNFRPP7+ZjpR1FVYZIXAADAIKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARz56lToz2GVnCNHKlHrH\/nztLp0\/VIbnfllYqi6JF8GNE0rfD22\/VITrvySmvHjhGPrZ0zp+6HHyIeq5+Od9whOnzMGpcta1i8OOKxisVyeH3tmJKS9IhNnDjR1rlzxGPtvXtHPFP0\/Fsre\/FF77ZtEY+tmztXj68dW+fO7S6\/POKxIlJ8332hpqaIx7pXrox4pn5McXE6fcxKn3zSX1YW8diEk0+OHTMm4rF6URQRUTRNi\/ZAos9dULBy4EA9kocWF1vT0\/VIPowEqqqWJSfrkTxgyRJXdnbEYwtvv71k2rSIx+pneFOTardHPHb9xInVn34a8di0q67q9vTTEY\/FYWr1uHH1P\/4Y7VG0VMzIkf0XLdIjeWliYrCmRo9kPaRefHGPl1+O9ihaYUX\/\/k2rV0c8tuvjj7e\/7rqIx+qKSV4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEKh9AAAAhkDtAwAAMARqHwAAgCFQ+wAAAAyB2gcAAGAI1D4AAABDoPYBAAAYArUPAADAEMz18+dHewzR59m8OdpDaB3PunX+nTujPYqWCtbVRXsIrWPr3j12\/Phoj6IVGhYuVMzmiMcGKisjnikivpKSw+trxzVihGq3RzzWs2GDf8eOiMeak5Md\/ftHPFYLBht++inisSISrK3VI1Ynwbo6vT69gYAusfrwl5YeXr\/FIbc72kNohUBVVVNBgR7JsePHK4v0CMavhhYXW9PTIx67+cILy197LeKxh50BS5a4srOjPYroW+JwhDyeaI\/iT2vIpk22Hj0iHrvliivKnn8+4rGJkyb1\/vDDiMeG3O4lLlfEY4HDWtfHH29\/3XURj6356qt1J58c8VhFVUcEg0zyAgAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEah8AAIAhUPsAAAAMgdoHAABgCNQ+AAAAQ6D2AQAAGAK1DwAAwBCofQAAAIZA7QMAADAEZZE+uX0++yzu2GP1yY68plWrCrKz9UhWbTZRlIjHdnvmmeS\/\/jXisToJVlcvT0\/XI3nAkiUuff7i9FD\/449rjztOj+SQx6NHbMZ77yVMmBDx2LIXXth23XURj7X37DmwoCDisaLbb7Hm92vBYMRjFZNJsVgiHiu6fczWHnNM\/cKFEY9Nv\/XWjnfdFfHYw86m88+v+uCDiMemXnBBt+eei3isr7g4v1eviMeKyMDcXHvfvhGPVSwWxWSKeKyEQiGfL\/KxIqrdbtYjV0QUq1W123UKjzjFZtMpOeT16pKrqofR2xvS7e09zIRCOv3DqROdfosVsz5fO4pyGP1SSPgfDH36mU70entVXSadFLP58Po86ESXUiIiJpMeb6+q2z8Wh1cn0fWfeCZ5AQAADIHaBwAAYAjUPgAAAEOg9gEAABgCtQ8AAMAQqH0AAACGQO0DAAAwBGofAACAIVD7AAAADIHaBwAAYAjUPgAAAEPQ6568ANCcy9ol10T8zrzueunYPsKZOrvr7nsvmnJJtEcBwECofQCiICUl5ehjj4v2KKKmorz8++++jfYoABgOtQ9AFHTt1v2hRx+P9iiiZskvv1D7APz+qH0AounO227xer3hCvjdnNmvvTKjb79+t9x2h6IoM998\/fNPP62oKE9P7zj5L2efdvqk4qKiW\/95055P10RenPGq0+l8YNp9q1auvPmWWwcNHrLnCl9\/+eXMN19XFOXp51+Ii4v\/7ts5r814WRN54qlnUlJSROSXRYueevLx7BEjrr3+xvBTXnn5pbnfffvve+7tldFb07SrLr900OAhl195VfjRB++fWrBixe4N+f2+KRdeEAoGRcRms\/Xu0\/fSK65ISEgUEbfb\/ezT0xfMm9fY2NizV6+LplwyMmeU7m8oADSPUzoARFPu8uXLli4RkbnffXvFZZdUV1dfdfU1JpPp7rvuuPO2Wx0Ox2mnT\/L7\/ddefeXTTz5hsVq79+zZvWfP3OXL1q5Z071nzx49eqqqsqOk5OUXnl8wf95LLzy\/V35JcdGC+fPmz\/vhpx9\/FJFPPvpwwfx5C+b94PV6wiu8+PyzC+bPe\/ap6RUV5eElmzZsWDB\/3r9uujEYDIrI4p9\/Xr9ubfihHSUlLz3\/3J4bCoW0nxbMLy4u7t6jh81un\/HSC+dMPtPj8QQDgb+ff+5zTz\/VKyPj5AkTtmze9Ne\/TP529jf6v6MA0CxqH4Domz\/vh8svnTJgwICZs95NSEzcvm3rm6+\/dtIpE159c+a119\/49rvvj8wZ9fRTTzoc9nvum3bPfdMSEhM7d+lyz33T7pk6zW53vP3WG5qmHXvc8V9\/+cWOHSX75qemps6b+30gEPhx\/rz27TvsXl5UWDj3+++OP+FEr9f7zsy3di9XFGXZ0iWvvfLyXjlvv\/Xmfjc0eMiQe6be\/8zzL\/77nvvWrlk9++uvvp0ze8nixTfc9M9Hn5h+w03\/\/PDTz5OSkx96YJqmaZF+8wCgpah9AKKsbOfOSy+60OvxHHfCifEJCSKyZvXqUCg0\/ogjFUUREVVVx44f7\/V4Nm7YsO\/TfV7vrLffHnfEkdfecJPf73\/7zTf3XSdn9Jh5P8zNz8utrKwcM25cOFZEZr75uojcdfc9g4cMmfnmG36\/L7w8Jibm6GOOfeTBB7Zu2fy\/Dfl8s96ZOXb8+Otvutnv97\/1xuv7bmjosCwRWbNm9aqCAhE58uhjfg2MHZaVvXHDBrfb3fZ3CgAODbUPQJTV19ePHjsmZ9Toxx95ePWqVSKimkwi4vf7d6\/j8\/lExGTaz+HIX335RXl5WVJSUkHBiuTk5HdmvunxePZaZ9z4I3aUlLz0wnMJiYkDBg4ML\/R4PP+d9U6H9PQfFyzokN6xdMeOr774IvyQoihTH3jIYrXe8s+bQloovPDrL78oLytLTk5ZsSI\/OTl51tsz991QeF7YpJpMu16Cb8+XoKqqqvKtCyBq+AICEGXp6ekvvPzq1AcfUhTlhmuv9no8Q4YMtVgsH3\/4gdfrFZHGhoYvP\/8sLi6ud+\/e+zxbe\/P118xmy\/fffvvg1Kk+v7+iouKzTz7ea6Xs4cNtNvs3X301avQYi8USXvjFZ59WVVbW1dY+MPW+RQsXmkym116ZIbJrErZDevqd\/7578c8\/V1dViYimaW+89qrZbN61IZ+\/cn8b+mnBfBEZOmzY8BEjRGTW2zPDs7rbtm39ZdHPAwcNdjgckXzvAKA1qH0AoszhdFoslp49e111zbVr16x56MH7U9u1+9dtt+cuX3bskeOuuvzSY48cv3XLln\/fc5\/D6dzruasKCpYu+eWSyy7LLVidW7B60dLchISE1199Za9D6JxOV9bwbE3Txo0\/YtciTd58\/dXU1HZL8laGn\/t\/f79g+bKlK\/Lzdz9r8l\/OPurXWdo1q1ctXfLLxZfu2tDi5XkJiYmvvTJD00IismD+vHMmn3HqSSc8eP\/UI486+sijjxk1ZuzpZ5w56+2Zp550wuWXXDzhxONVk+k\/996n39sIAAfFBVwARNPESZP8vl2TuZdfeZW70R0IBOrqaqdcevnAQYO\/+OzTsrKyk06ZMOnMyQMHDdr9rL+cfW5MbKyIlJWVXTTlkr+e\/7fw4Xoul+uuu+8tWLmyuro6KSlJRPoNGHDRlEtcLtfFl1zWt2+\/Y449rqiw8KIplwRDwWFZwy+8+BKbzRbOvPDiS1RVLdu5c\/TYseFDDBVFmfbgwy+98PygwYPDGzrv\/3ZtyOl03nX3PQUrVtbV1V1w0cWhkCYidrvtsiuvOvGkk8MzvI89+dRxJ5w4b+73DQ0NF1x48Tl\/Pa9jp06\/53sLAHuh9gGIgsbGxvB+tZE5o0Vk9z62kyecKiJbt2wVEYfDOfkv54SXa5q253648KkSK\/Lzk5NTTj9jcnV1dXV1dfihXhm9e2X0LiosLCosFBGn03X6GZO3bNmSmtru9DPOLCsrs9psp58xuaa65vQzztxz0yJy+hmTwz907tJ19\/LwauFHa6praqprdm2oV+9evXqX7ig97fQz9nxp4cMTd+V07nL+3y4I\/1xZWVlZWRn+efOmjW173wDgUFD7APyuKhoamhRl7ZrVp518QrTHEmWVv14pEAB+H9Q+AL8fj8dzywfvek0mEdnz8LvdV1RpGUVEUxQl\/Kz9\/hBOPMAPsvsJiqIoivrb\/yiKou7x0x6rqaIo6q9L9kpR1T1W3PNHCcepokg4trq6au2aNTNefmnipDN79+kTmTcXAA6G2gfgdxIKhW66\/tqVxcVms\/mZ51\/s13\/AHh1pv5XptwtFkd2FTX6tintWvfCf9rdwr\/9GXVNT06knHb9xw4arLr\/048+\/cLlioj0iAIZA7QPwO7nn33d+\/uknInLP1PtPOOnkvR6tqalZv26t3+\/v179\/YmJSNAb4+3E4HE89+8KkU0\/ZsH7ddf+4+oWXX+F6fgB+B+ben3yiR271xx\/vfOYZPZL1YE5M1Ol92HzhhYGqqojHlk6fXv3RRxGP1Ym2x0V3I2vbjTeaExIiHpty\/vlJZ50V8Vj9ZLz3nmK1Rjy2ds6c8hkzIpX2enHhzB0lInL1Ndf99fz\/271c07Tvv53z\/XffJienZPbrZ7FaH3v4oTPPOnvI0KGR2nS01NfXf\/TB+9u3bdU0LTk5JWf06CFDh+2ud5n9+t3\/0MM3XPuPOd98fWPW0Cu6dIvIRmNyctJvvTUiUYe1yv\/+173HyTqRYu\/du8vDD0c8FnrbevXVptjYaI+ipVxZWR3vukuncHPiaafpkbvzmWdqZ8\/WI1kPzgEDerz2mh7Jqt2uR6w7N9edm6tH8uGlfv58PWJjRo7UI1Y\/CRMm6PFJK58xo\/rTTyMS9W6M64O4GBE57\/\/+duM\/\/7V7eV1t7YP3Tx01esy90x7Y3Ye6duv2+aeftGvXLiKbbo4mmuh5d9xQKPTYIw9ddsWV4Wu+lJeXLZg3b9bbM886+5zhI3Z9wCadOXnL5s3Tn3jso7Kdpo0bz2qIxH3bTKYIhBz+POvXe9avj3jsYfflgLC6uXOjPYRW0G9fiTDJC0BXIZGZsa7PY2NE5Kyzz7l32v27j64LBAL33v3vm\/55S1r79rvX9\/t99z72zMeNaf\/Of0Pfkel8jJ8S8N8+qFPfzH7hP6altZ\/8l7PPmDx5+uOP+f3+0WPGhpdff9PNFRUVb7\/1xvtxsUFRzmlo1HdYAIyN2gdAL0GRF+Njf3A5ReTsc8+b9uBDqvq\/fVE\/zp93wokn7dn51q9fd\/P9T37V5Qx\/ao8oDDfSnvr5pVHz5\/3vviAiqmq65vob\/3PnHbtrn6Io90673+\/3vfffWR\/FxTSoyoV1DeyvA6ATah8AXbgV5YmEuHyHXUQuuezyW++4a6+zFtp3SH\/n7bc6pKeLyNo1a\/Jyl2ua9p2l35+j84lIUc6UCa9\/fM7MmWdMmjRsWFZcfHx9fd3nn3zSNzNzz9VMJtODjzzmcDjeeO3VOTGuCpPpmpo6p6bnDDQAo6L2AYi8HSb14cSEYqtFVdVbbr\/j0suukH2unNI3M3PKJZct+nlhbW3tV198NuO1N50u1+vn3\/LnmeZUlIa+x3QPeJ1O5xWXTskaPjwmJmb8EUcOHrL32Sqqqt5937TU1HaPPfJQrsN+m9l0Y1Vt52AwKqMG8CfGJQMARNgym\/X21ORiq8XhcDz9\/AuXXn7lvp1PRBoaGn76cf6SD9\/f+tDUgfnLVxUUWK3W7OQ\/1QyntWRVTk7OmLHjgk3uhPj4Y487ftDgIftdU1GUf1x3\/VPPPu90OndYLLenJn3n0OWEMABGxt4+ABHjF3kv1vVpjEtTlI6dOr3w8isDBg7ad7XysrLXnn+27N13jmhqnGJSFVWqzabFy5aOGTcup1vyp576kF3\/Sy1oIUtVoT+5q64bce5YPWToyTtKSkasWz1407pvHn3w5a7de5x+5lnn\/rVdWtq+6084bWKvjN5XXnbJ5k0bX0yMX2a3TamtTwqFdB0kAONgbx+AyNhpUu9OTvgkNkZTlPFHHPnZl9\/s2\/l8Pt\/zTz35yJFjxr0x41JfUx+TGt4NmKgqO3KXicjwrCxryerfYbS28g1Hel\/VeyuZ9qb4+IS8vNw+JjVVVU6xmC4v2T7o6ceeHJdz3y3\/LN2xY9+n9M3M\/Oyrb84+968issxhv7Fd8jdOB9O9ACKC2gfgUIVE5jjt\/0pN3mCzmc3mG\/\/5r1ffnJmUnLzXahs3bLjhtJO7PPHwlIA3Wd172te3Imx6vrUAACAASURBVC8YDA7NynbsWPU7jDnLMu+C7Lmi6bgjTQkFRqU7FUUpyF3ea4\/X215VLpDgCR+888TR42Y8\/1xwn2P4XC7Xg4889vJrb7Tv0MGtqq8kxN2akrjSatFvqAAMgtoH4JCUmdRpSfEvJ8Q3qWqXLl3\/+\/5H\/7j2etM+Fw2e+\/13L5x+yhWb1meY9v+1k1ZdtX3b1sTExExbJK5afDAnd\/7h2KwSe9k6\/TZhKd88fFB\/EanOz3Psc3RjgqJcHPQlPzz1pnPOKi8r2\/fpxx53\/Jzv511w0cVms3mb1XpfStK0xPj1Fo7MAdB21D4AbRQU+cLluCk1eaXdrijKueed\/+Wc77KGD993za+++PzHyy66xO+xNn+R5H4mdfmyZSIyqoNTQvrOaqqNVSf3zWuXGsq2zdNvK9aildnDR\/j9\/uCaZvdf9jep5+ctuXviKRs3bNj30di4uP\/cO\/WLb+YcceRRIpLvsN+VknRvUkK+1crhfgDagNoHoC3WWMy3piS+ER\/nVdUuXbu+8fas+x96JCYmZt81f1740+Lrrz5H0Q58X4weqrJm+TIRGT4o01K+WZ9R79KlbuGg\/l4ROaXzD\/ptJb2ppFv37ps3berY2HCA1eIU5YqK0unnTt6yef+vuk\/fzNdnvj3rvQ9G5ozSFKXAbpuWknhjatIXLkfd\/k6RBoDmMF8AoHUqVfWdWNePToemKBaL5aIpl1x7w01Op3O\/K+\/YUfLfKy+7Ug6+c8qsKPW5y0UkK3uEbfYn\/rSMSA1Y8bnHbH1gWP9aEdFEFZHBQ9eEZ6EnZ+WV\/HidKIoimohWXy\/\/LTnH3WNURLY7sp1FVdX8vNy+zcxr72ZVlEtrqx654Pypn36ZkJCw3xeRM3rMrFGjf1m86MXnn5v73bclFssb8ZYPYlxPl1VybWcALUTtA9BSXpFPY5yfxbi8qioiI3NG3T11Wt++mc2tr2naozfd8PfGWqVlO6VMG9c3NNT36NmzQ1PxfqY820qzOpe1u\/Cc2H9cOXHNXgPp1cM\/vcdn4Z\/XbbKd\/f5t7u45Edmoqb5iREZHEVmXlzt5n\/NX9mVTlP8rKXzg5hvuf3FGc2+Xoigjc0aNzBm1eNHPZ585SUQmNLrpfABajkleAC0VUmSew+FVVbvd\/tSzz896\/8MDdD4R+eKzTwf+vCCmxRORGaHAyhUrVFXNSbNGYrz\/05TQ\/Zods6Y8N8Ht3v9gPpvffswHb+Snnr\/fK0u3ga2kIDsrW0QaVuSZW5aZrCp9v\/vms08+Puian3z0oYgkBwKnNPwep78A+NOg9gFoKYcmF9XVi4jH44mPjz\/wPrxAIDDnkQdHmVt6141GTWvUJHxWx8heHU31FYc+4D2FbDGv2J44+ul\/bt3+myuhBINyz1vZZy7\/oDIlO4Kbi9m5duDgIU1ut7JhfcufNcZs+u7++5qamg6wTlFh4Xv\/nSUiZ9U32A51mACMhdoHoBWGeX1Dmzwicv\/U+0IHvHvEl198Nrpo+0F3cxWFtP\/6Qy927z3775cMmPHGzp2lIpKVlW0rXhmxQe+mKItTLvl6efc9lzV5lMe2XO+Pax\/ZTQ2JD7lcrtWrV22y2d\/3BzcFW3qrjRMrdr7z1psHWOH5Z5\/2+\/3t\/f7xTd6IDBWAcVD7ALTOeXUNqqatWb3q6y+\/OMBq8998Y6i52W+YgCZz\/MHnumdsuvm2Cxcsevibb\/95x11HHn2Mqiiapg0cPDhGnyvqWaoKjx+yac8lMS7tyKQfIrsVJeDN6RQrIvl5uQ9\/9tX583+uuffBN4449iWzLS9wkP7Xy6SueG3GvtdwDquqrHz\/vXdF5LQG95\/q7sUAfhfUPgCt0zkYHNXkEZFnn56uNXM+QXFRYfzyJc3t6lscCL40JDvrnfcf\/frbKZdd0bFTp\/+Fd+5SuH2by+UaEq\/Lpfv6Bed37xoUkY9+SL\/s2RMaGxUROaXLDxLREyOspeuyhwwWkcLt27t07dK5c5dz\/nre1JdeuXtpvuOJZ2Zkjfo4EPI2v8XBO4oW\/vTjfh\/676y3PU1N8YHAuCZPBAcMwCCofQBa7fSGRkXTClauXLzo5\/2uMPubr8c08+0yS0yW+x589N0PRuaM2vfowGFZ2bsu2twpXglEfhJzQufvQyH5z1sj\/pL\/wYu2Z456+pYt2y3HD9lsrdwawa3YiguGZWWLSCgUUtX\/7ZVzOJ0TTpv40Dv\/PemTr17NHr0ssP8dfyNM6ncff7Tv8lAoNOvtmSJytNsT4XNeABgDtQ9Aq3UJBPt7fSLy1huv73eFDfPndVL38\/UyLxAc\/NBjZ\/\/1\/OZOB+k3oP\/qVQUikj1ssHXH2pYMxlRfbt\/yS0vWVD31o9stnTz9\/HvcrwVi24miLEmdMvqdlzeUJAxSDna7Dk1TPfUt2YqIdAtVpnfsWFNdnZCQuN8VBgwc+Mjbsxr+educ\/TU\/q6LUz5u77zzvksWLt23dqmjaUQc85wMAmkPtA9AWx7rdIjLnm69ramr2eigYDPrylu+31q3LHHDqxNMPEGuz2b1er4iWlTW8hWd1ONZ9bi15qSX3c7MX59+w6I6P4\/+jmf93Cmxp6tgJP73vLi4\/8HOda2fHLHmmJeMRTctpb1MUZcWK\/IGDBze3lqIoUy6\/suGCKSWh\/cz2dqoq3\/d2bZ98\/KGI9PX60oLcmw1AW1D7ALRFlsfnCga9Xu\/sr7\/a66GiwsLU2r27oIhoIq4+mQe9dLPD4WhyN7Xv0KGHVLdkJIq2sqmPuyU7\/Nw9x65L\/4vI3gPwJnRZPejmAz0zFDTVvReKyVX8B9\/NZq4pGZnZQ0Ty83IHDxl64JUvuPyKucH91L7+qpq7fNmeS4LB4JxvvhaRMR6O6gPQRtQ+AG1hFcn2eEVk39q3YcP67vub4VVEgge8O21Y\/4EDCwpWKoqS097ekjMtNKXMn2wzV+e1bOBtYSsu8HZp9KWplrJNLVh5ZVbWcBGpKC9PSUk58MopKanu\/d3XrrOqbFq1as8l+Xm55eXlqqZleXytGTsA\/A+1D0AbhWvfwoU\/eb2\/Ofdi29at6c3cjsy9bKnff5DWMmxYdu6yZSIyIrOnubr4IIPQNFECIiKys4XDbgNL+VpfO3vQZTa597MXcy8JVZsy+\/fTNE1RlIPu2nS7Gy37O1DPrCjuzb+Z5J33w1wR6erzJ7X0CoAAsDdqH4A26u\/zmzTN3diYl7t8z+XlpTsSm2k7R1VXPD99+oFj0zt2LCkpFpHs4cNtxSsOMghFEc0mIqLoOfWp1YiqKCFNUw9+H\/OsJMVqte3YUdK+Q4eDrjzvh7kDZf97NP2FhbLHQ4sWLhSRQT529QFoO2ofgDZyaVoXn19Elv7ym+PqPJUVlmb2cvUxqY5nnrj75huLi4qaiw3vIQuFQn0z+yVVb2nBQBJEROdvs5CImBoCIdf+z8zdTfU25nRNFpEVeXkHPbCvvLzs6wemNXdRa62iPPjrqRs+n3dFfp6IZHqpfQDa7uD\/5woAzenl92+xWfPzf3NcXbCu7gBTm0eY1aqP353xwbsNAweljRqbnZOTlZUdExu75zrp6R1LSoo7deo8PEUtPPgoEkXqRXbdaddSvtm+9VNN3akEOzT1nhxISG\/dS9I0684NpoZyf0r3PZ5rFhFTfcDT7SD3cLOWrM4+fqiIrFy54vIrr25utcaGhs8+\/eTnJx69sLpcbaYiW72epiZ3TEysiGxYv76pqUnRtJ7+QOteDgDsQa\/al3jqqfaMjIjHuvPy6n\/6KeKx+km54IJgbW20R4HW0fz+nc+07FIdrRFyu9OuuirisSKimHS5TVfCySdbO3c+8DpDtm6ek7t83Zo14UPZwgu1g51qmqQo55pF1qysX71i1YvPzFZNgQGDOh951PEnndK7Tx8RGZqVlbd8eadOnXO6pXzsqQ\/ZYw8Up7hEExGriLhWfhiyvFuf5RRFRCuNyV3kT73Z2+Uge912M1cXOVc\/6u28w5disZZ5naszGwdcGYxLE7GLiOoxhewxB06wl6walnWNiDTUN8T+tst6vd683OW\/\/PxzyeKftdxlowK+q02qNH\/wn0PT3I27at+a1atFJCUQjIvo3URaTgsEyl54QY\/kmJwcZ\/OXufmjUR0OPb4cRKTdlCmKzXbw9Vop\/oQTzKmpEY81JSTo8T5ogYBOX5KVb78dqG7RlQFaJXbsWD0+vY5+\/SKeuZtetS\/t6mb\/N\/dQ7HjsscOr9nWeOjXaQ0CrFd5++1YdPsCx48f3m3ewawL\/kbS77LKDrjNq2VI5bUJxcZHX67Xb7buWNnM\/2X3FKkqOWckRTVbnVxTkffLko6X9Bo78v7+fePLJ3307Z8JpE7Oysqyfr\/L0zNnriaa6neaakkBCejAuTTSfKCKiuvJm+dt\/6ktzioi11GMrTNBMRwddyS19wVooZtnMQPKOQIIlGGtpirc09does+xmX+fbRLGIJqKpohxkKrmPtSE5JTkQCJjMu7q42+2e883Xv3z5uX\/hj72bGkeqamL4fBfTQaJsojT9erbHhvXrRKRTIGq7+jSfT49fChHpt2BB7NixeiTroWHx4lU5e38aIyLlvPNMOtS+1IsuSr3ooojHls+YsXnKlIjHWjt1GlrYgv37rVc3d64etS\/pzDPbX3ddxGN1xSQvgLbr0qWriAQCgR07Srp377FrqbktXywpqnK6apINq1fefvPtL73g7tRZRIYOG+Z86bHf1L5QMHbJ08G4n\/wpFmuJz7yqh6g7RVRr2YrG\/it8aQ5Tvd9VkORLv6J+ePYB9qXth6LWHPsvxdfk2LjAVDfb26XE18HekG2OyZtqKe8jioQcAVvxSmvpYk02iIRE6dc48BzNusflV0LBUR0cIsqWzZt6dO9RXV014+mnSt99Z5S74W8mVRURcyv2yyqK7L5Rx5YtW0QkPaDLfYoBGAe1D0DbJSQmOp1Ot9tdumPH7tpnio8\/lMyBJrV\/4eYnt2\/zeDyJiUmZdveee\/hjcl9z91sWjIkREX+KTaRcCSgiUn20TbOq5iqvY9O4+hEXqk11qqc+5Ihr7dY1q8Pd73iR4+2bF8UuebE+S2sYYoldvEQk2dPDad90d\/3QOFEVEVF88+MWL68f8WDI5go\/11K5Lbt\/HxHJz8vbtHHjvUeNm9xQl6oqB92xt19+TbPZbCKiaVpJcZGIpLZ4NyoA7Be1D0Dbmc3mpKRkt9tdWVGxe2FMx84eTbO3ak\/bb6kigwO+VQUrs7KHj+4YszAUCF85xVRfHrLOCcY4RcRU69esashh0syKiGhWVTRJ+MHv7VTiWvH3YExQ9WlqQ7q\/\/f95ug1v6XbdNc5130hwqygh0doFXefE\/jKrPkfqRyaLSMhmcvf7X6PVrGrdyIaY3JfrR14bXmIrWpl1zokisjovt9esN0eYTdLM9QtbokFR4xPCJylL2c6dIpLUghvQAcABUPsAHJLYuDgRqd3j1KU+AwZsCmn9TW1vPCKSaVJyly3Lyh6ePTDTsmqzL623iDg2fNM40K4EtNgldn\/K303u8qDrw6Zevx5TqEj1sbZgXJHI7onXBvuWRx3rpjT1OfagW7Rv+dlc\/UzjALNmCe+c22Ap81jKG5RgsrbHa3GsazI3ZGhS2DhQ06xq0LXQ1HBeMCZFRNo1bO+VkSEi7hX5I1ozn7tf3qQkl8slIsFgMPz2xnErXgCHhuv2ATgkrhiXiDQ1uXcvGT16zPJ97nvbWu1VdVvuchHJyh5uLdx10WYlmCeKErcormHYQ57uI4OuNOfqJFPj\/050CMZZ9srxdHeq3hnmmpIDb85askrxTG8Yav2184mI+NvZa49I2bPzuVa4g3F31Gff0zjo2dglPU0NgaYMh33j3PCjI9pZzGazx9OkrV97CC\/91yH1GxA+Odrj8YTvg+KK0mm8AP40qH0ADolJNYmI3+cXkYDfr2laSmqqd9yR\/kPrKIqIJz9X07Ru3bune0pERAn4NNkWt8hZn3W3Y+N3rvxL\/CkvVJ7mDrr2M2thrvElzi6N\/7HSvqmhqafFsXbmgTYWCtq3Pt3U1yEi5lq\/c02d6t3\/dGrQFbLuuC\/2l3\/bti+vG32ba2V\/1RtU\/StFRHXX5PRoLyJrVq\/ufrAb0B1UYSiUccRRIqJpms\/n0zRNRGzUPgCHhtoH4JCoqioimmiapp1wzFGLFv4kIuddf9PHhzwhGV9asnNnqclkymlnFRFTfZm5Lrs++wHn6nd97d9ryLIEEqzNPTeQYK0+Ni0Q6zLXnuXYcq7qtSlBf3MrO9f9oDZVxi7tkDinc+Kc8kC8JWTb\/xStp2dMwzBH\/fDCYOwzcT9Prc++xrlutLVkrWiarbhgWFaWiOTn5fY5tAluEZljsp468fRHH37w4Qem+f3hK9SImdYH4NBQ+wAckvBFRswms6Zp5eXl4UP9Bg0eHHflNbmBQ6p+maqSu2yZiIzs3dlUXx5I7FRzzL+spWv9aXP9yTb7Nnfs0oTYZZlJX1XuZ+dcSBNVaRxs16wfejv0rz3iGs209\/zvbp7uI2qOnuXpepE\/ZVP55HRfumO\/q5krvc7VdY6N9aon6G9nb8jaFLv0sfrhl9eNfVg0zVm6Onw3ti15eenqIX21bg+FUv9+UUpqqsVsKSoq0jStmdv2AkDrUPsAHBK\/3y8iNrvN5\/PV19clJiaFl191w02FF106OxBqc2PJUJUVy5aKSPbw4bbileGFltL3\/Km2uIWOkPWupoybFE9x7Zi4vXbOqZ5gu3dqYhd3tm1vauxvd2x6\/8AbCtljRRTHxukNQ62KL+Rc1RC\/oFoJ7j1wa5nXUj4oEDfNsf702CWqiHi6Fdi3LPEndxVVHejyxcbGimhNK\/MP5Yu1RtM+7jPgyhtuEpHEpKSK8nKzadcsNid0ADhE1D4Ah6SurkZEXDGxtTU1mqYlJCaGlyuKcuMdd\/V98dWn07suDAQDrW9\/DkWpzlsuIgMHDoopWy8ipvpyzboxZknX+hGPamarfeMtdaPr9j2NI2Q3VZ4WI1qCol3vXO3X1PUH3Zalcquvfal9a1NM\/mjVP9nXwa7tM1HrzoyrG7PZvuUBf\/v+DUOfjskdrJkVS9kXIqIE\/aM6xiqKUldbZ922pdUv9VdrgqG3Bg67+823w7c8SU5Orqgot1h3vUD\/IVwTBwCE2gfgENVU14pIfHx8VVWV3W7\/3y3aRETkmGOPe\/y7H7q89Pqskyc+H5f0oS+4MhhqaPGpCaHVq3w+r8PpHBofFBFb0QpLRWb96DtVn9u+5b6GYSbnOnfq+7XmWr+IKL6QpcIbfmIw1uLJWGqqLwnFXGPbXiUHO7PYXFVkqg8q\/kv9yZmB+I+aeu1nnjd2aZWpMVA\/UrPsuNtSsbVu1A22klMtFXlKwGsp2zh8yAARWbEiP6P1M7JBTfICoWdj4iv+deej736QlLRrj2lScnJlRYXVajNbLCLipvYBODRctw9A2\/l8voaGehFJTk6prq6Ki483mfY+GcJkMh11zLFHHXNsKBQqLNy+uqBg3po1levWeteudhYXDlakn6nZQ+G6ez1rVq8ZPGRITuf42X6PP7VnU68xmsnsyn+6YXAobmGiP+3ixsxnAvEWc7Wvw9dN91z6j2u+f6J+eJKI+JNttsJ3fanPyOAb5GBVTLM61NrTPT0G2Dde1zhkV+czNQTGlbbbWF1UPMyhmZSQ3erKGxVyLm8YYonJfTAQ\/0TDkHNjPZqprsxWtHLYpeeISH5ublYLDuzTRCpD2paQtknTatPau0aMGnHc8fcfd\/xepTklJaW2tlZVVYfd3tDQ0HAIF38GAKH2ATgUVVVV4UvKpaW1y8vLS0xMFNGa27WmqmrXrt26du120ikTwksqKip++nHBKx99kLbghwnm\/ZSaTJOSu3zp4CFDhg8dYl2w1ttliIhYiwsCiSticgfW59wSs+SB+pEOxRdyrh1Y17XdmNFjrW\/McTq3uvvbRKSxv9VV8HXDsHMP+kI83bI93bJjFz9Rn73r7GBzlS\/pq+DLbz142s0P1v+8s3Z0XeOAmLiFaxoHPh77y+PuzPWulTPqR95Qn\/NXEem05qPOnbuISEl+7nHNl7PSkPZjMFTdqYt90JAO\/fr17dvvmAH927VLU5rZjZeUnBIIBBrq6xMTkxoaGuoP7UwRAOBLBEDbhe8VazabU1Lb1VRXJyYlHXQ6dU8pKSkTT5\/04OtvjXzjnQ\/2d8JCuqpuXrZMRLKyh9tLCsILHZs\/M1f0rxt9u6mxKpC4ShSJWaHUZ\/8jEJfmdjfakjuIep650isimkWVUIuvnBwKaqalv95vN+RcN8jf5ai4uPhSc1LDsH\/H5IZExN2vxr7tl7oxdzo2jlICC0y1pSIimpaTZlNVVdM078oV+3399Zr2vCtuxT9uOH\/ezw8t+PmeZ5674qp\/HHXMMWlp7ZvrfCISFxdnsVqrq6tT27UTkep99qQCQKtQ+wC03fZt20QkLa291Wqtra1JSkpuW07fzMzG\/fVFRaQpf7mmaWnt2\/eQahGRUNBaUl6fc5uoZtuWhZ4eTtUdCNlO06zOQHyHHTt2pDsUd+ZJzg1pv0a4DzrDG2Zy1wRjPOGfY\/JN9dn\/SFF9NTXVvrj2QVdSyHmuucYXSLCa6r4XRa0fcZXIka6Cr0TEVF82oncXEdm5szShrHS\/4bMcMbd88\/1V117fuUuXlr8tJpMpISGhuro6PT1dRCpNfGMDOCR8iQBou82bN4lI127dFEWpqanZfS5Ca73+4gsnNHN9kpiiovLyMkVRRnWwi6aJaqo48wHNYhMRJbBRs6jOtUF33xNFJBjfobiosFucWRTF126ypdwrIqLFtXAHpKaalaCIiLnaF4w9W7M6usWaCgsLA\/HpIuLue5xjvVNEQpaNit8rilI3+h\/+dhkiYisuyM4eLiIr8vL6NDMPa\/Z6zeZWH1SjKEpKSmpNdVWnzl1EpOyQ7\/MLwOCofQDabtOGDSLSo2dPEamqrIyPT2hDyM7S0rI3X2vfzCFxmaqSt3y5iAzP7GWuKhQRzbz75hyVomlKcIRmdYhIMDZlW9GOnglWCYU8PXLsW12qJ6hZBrRwGCFnnKkxQUQcGx3uPseIaL3izdu3bg0kdhQRUU0h23GqJxhIVs3VhSIiitqUMVZE4srXDxg0UERW5OZmNHN\/jhOD\/jdmvNTCkewpITGxvLy8a7duIlLKJC+AQ0PtA9B269atFZHeffqISMWvt+holVAo9Mi\/bj7L72luhd4mJX\/5rsP7dl+0WURENFG8tqImb6fjd\/1ZNW+u8fTo1MHUUCGKqqmjXQWBpj7HtXgsimYaZ2oMaOajRDWpnoaMDsmbC4uCcbvmi5v6nuhY5w26zKbGqj2fNixBs9sdIlK5ItfVzIF6HVSl+PVXysp2tngwu8THx5WV7ezZq5eIlJvNh3qvXwDGRu0D0EZNbve2rVtFJLNffxEpLy+3Wpu9Se5+aVro4bv\/PerHuXHNn9bgUpSq3OUi0jezb3LNXldCNll3pPo69N395401\/p69MiyVW0XE2\/UIzXRGyB7T8vG4B5yZ+JWvKeM4EbFUbO2VkbGhsknbfZMMe6zqzQqPe\/dTFH\/TyM7xIhIMBv2rCg4QfpbX\/cgt\/wyFWnevjdjYuJ2lpb0yeiuK4leUUuZ5ARwCah+ANlq7dq3f7zeZTJmZ\/TRNKy\/bOXvqPf\/623mffPRhfX39QZ9eUVF+66VTer756sCDnakQWLXS7\/dbLNbhKXuWHsXU4Ay6TpA9KuNWt3Tr1s1SvllE\/KndG4ae0apXFLLF1BzzSDA2VUQs5Zv69Omzrtq\/5wqebhOda+v2rJLWHWuzhw4Rka1bNneoqz1AeIKi5Mz77qH\/3NWq5ud0OvNycxMSEtLS2ovIttYfIAgAu\/ENAqCNVq7IE5Fu3XvExMZ4vb6qqqqrTdrIRQtW\/zRvmsmsDRveefTYoVlZfTMzExMTFWVXt\/M0Na1cueLbzz+r+eDdM31NieaD\/89n1yb3urVrBgwclNOj3UdNdSHHrqlkX4fjPT1H7blmY0z7UEhL9pTvap2tv61FIKlT+If4uuJ2aWnbfL+585s\/rXfc4oENQ9J3L7EXFwzLvlRE8vPy+hysvw40qcrM1\/61bdv10x5I79jxAGtWVVbOnv318o8\/Klj08wZRfD5fZv9+paU7Nlks4zze1r4oAAij9gFoo+XLlonI4CFDRJTKigq\/3283WVSRASZ1gIRk+eLKpYvWhrTZmtYYE2tKSFQslmBjo6myokcwcIJZjVWUFtayTJOyfNmyAQMHZQ8bZv1s1e6q19R7\/F5rBpK7btmyeVCSeeshv7qBicr2bdu8iXtfb6Vywr2yx+m6PdWa8H64NXm5k1pwF40BJrXrwh+eO3qscsIpI48\/YcCAgant2pnNZk9T086dpRs3bFiVn1e+eJGtYMVICU0xqe8p2mp\/sKS4eNCgwXO\/+26zlS9tAG3HNwiANgrXvqHDskSkpKRYURTbb2tPsqqMUZUxIuJ1y073rqWqiNq6A9Q6Ker85cvkgguHDBvmfOHhvfbw7cmf0m3Txl+Gpcd+5vdoFntzqx2UEvBld4jZsH69P6X73o\/teYkWLTSqvSN8veX6FfmWlrXYWEX5mxb0f\/XJmi8+fjcYqlHVoKJYQ6Ekkc6qcqyquBRFTBI+CMehKCKybdvWIcOyRGSrxeIXsRx4AwDQDGofgLYoLS0t3L5NRLKHjxCR4qIiEbHps60m0VbmLhfR4uMT+jk8Pza\/ZtCVvG77jqNHZVsXrfd2GtTmLVp2rs8aPnDVmrX+lEkHWM1cVTSiXy8R8Xq9ZWtWt+YGJWJRlEEmZdDueeFmLs4Sfku3bd1y+hlnqqrqFdlqMWf4A63YEgD8ilM6ALTFkl8Wa5qWkJAQvnpL4fbtImJp9aF0B6eJvBqb0GfU6KrKKkVRRnV0RUnwwQAAIABJREFUKcHmS4+irKryZWVn24oPdFLtQdmLVmSPGLFqZ92BdxnailYOy84WkbVr1rgHDl4eaN1Zui0R3rG3beu2hISEjN59RGStlZ19ANqI2gegLRYt\/ElEho8YaTKZRGTbtq0iYmnV\/q6WeUdTz33mhRNPPiU3d7mIDB\/U31K+6QDrr60Ntktr30OrbG4F1dvo2LTQufZ71V3T3DoZWmV6escVFf7mVghLrt3Sp2+miOTnLb\/3gYeWHXFMZahFN4JrOasiIrJt2xYRZcTIkSKyqpVXyQGA3ah9ANri54U\/iUjO6NHhP27ZvFkTifg15b4MhAY98EjOqNFDhgzNz80VkezhI2xFKw\/wlBpXh+3bth3R0Smh4L6PulZ8ET\/\/75o8EXS9GP\/jFOfaufuuowQDR3aJqagoL5KDXH06O8VksVhEZMuWLT169rz9ielvduzq1SLZ\/MJvafj6iDmjx4jIWqvlIG0UAJph9mzcGO0xtEKgvFyP2JDPd3i9D4cXRVVtPXrokewrLAx5I38xi2B1dcQzRURratLpY2bv2bMNVyo5FMVFRVs2bxaR0WPGiUgoFArfnDeytW92IJR05z2TzpwsIvEJCbW1NSLStVu3dO+Odc0\/y98uY83qVeOyBz2Xu96XnrnnQzG5H2qmmdXHxof\/6O0kMblPxSwtb8j+y56rWYsLjhiTtbqgwJeWcYDhqZ76nG6pIiKihYJBk8kUHx9\/02tvPHHmxCsaaiP1VphEEZHioqJAwD9q1GiTydQkstli7vNnObzPV1Skx++FOTHRnJwc8Vj9eDZvNrX+JjcH9f\/s3XV8VMf6MPDnyPpu3N0TQhIghgV3dyjuRWq00GItFCnQIqVYoVhLKe7uFA9JCFECcdeNrcuR948NISSbELjwu29v59v76d3MOTvn7AndPp2Z5xmOnR0hfouK5f9dLEV9oC9JVvdBNrjRS6Uf4oZxoZDr4PDm894JGe\/d1Pfav4QmNRU9hw+HtLAIKW90xu0\/kTp8uDIm5kP0\/CEooqM\/0B+zMLUa57971uo7uH\/vLsuy1jY2vr6+AFAulVZWlGPwPke5LlKM1bJVE6ZMrW0hSJKiKJIk29lyX7BsY5Gu3sbjWcqlSZOnCE\/\/Wjfs42dFYbqDivDXdg1WtDETPj9m8kAm6zgdXs5QS3KiIxZ\/c\/DAHzq7iCbukFeQHDooBADkcrlYIjE0urt7zPj94O7xYz7Wqt7XZIpEwshk6pLiEkcnp5YBgQnxcfE83v9M2Jc+duyH6Nbxu++cVq78ED1\/IEkhIR+iW6+jRy1Hj37zef9\/0BcX\/7P+XVz4ww+FP\/zw3rs169fP99Kl996tAZrkRRDkrd39+zYARER0wgkCAFKeJTvYUyT5fmY3GYC\/WMxt\/ea6MR8AeHt7p6elAkC4lxOhkL46wLKYXoPp1MAwAMDwxPEFlXa2tiF8We0p3OJUfsZ6edhrMZ+Bys9EZ3\/N7MY6jKoZD+hkrjM3N4\/LLqKF5k3cp6AouU2bYABISkgMDHyVNRwY1GrCH4d28URG5pjfHgtgZ0dbWDBZWZkA0LlrVwCI56HlfQiCvAtUwAVBkLdDUdTDhw8AoEu37oaWpKTEgACq7G9uBcta\/WdZHQUMe8LWYcrPW0PDw+sdahMcGvskxq+Ff2hYGO9AotqrgyjxMkf6gMVzWY4GMMD0BMZYAjg\/k5exAAMCnP5WlNNCM1HyVU7p\/qpu4sZuTeMupk2SzK98ogqcTYutBob6sSz7pEwPnhgwDLc0jZ8dTcifAVYCLLC4rzxsMm1i24KvNjMzA4C4uKdDhw9\/\/VaDuUeOb588flp1hfg\/m39ngOVwIDCQSn3xIqJT565du2\/bvDmTy6nGMdP3nT6CIMj\/PBT2IQjyduKexlZWVOA43qlzF0NLfFxc61b6u\/e4Vzv1SLh7axAOvLePdSpZ9hxOmk+d9uO8r0QiUcMTvLy9jx09DACBQa0snq1XZe5TBDOKNnwAMUDt6iUG2BzmQVlpaUnv3n3Wzv5Eb6nReDHKAEnTV9db8ir6UaKUNeZ\/a\/ucuSYtKyt58dhMngNYjt6aUrYQ0SY1ZVNwbbLZrS\/kbX9sZy80TDSXFBfZ2dnX67Bly4Cl56\/89OXnYVEPQ8l3X+mnZYHLYUOD9U9jnwDMbNWmjbmFRWVlRRyP20WNdmlDEOTtoEleBEHezu2bNwAgMCjI0soKABiGeRr7JDhYz+XA7AVfDzl3+a8uvQ7RbEnzxqJogDia2cUT3h4\/9ZPbD+Yv\/c5ozAcAJEnSFMWyrEAgaOVCV\/Tj6OyMrWjEQOskTIiP9\/f3d3cjq3oKNG7GO6wPx5QtTUNbt3R0dIp7GlvVWVfVs7yqh1gZZFYb8wEAwyMqe\/JN73wVFtQCAFiWBQDMWJhrZ2+\/4dBRcs2G7aaW6fRbl\/TTs3CWYi64uHO50DZMF\/U4kmEYDofTpVs3AHjC+0C1sREE+V+Gwj4EQd7OrZs3AaBb956GH7OzMmXVRUEBlFDIatQa\/5YBa\/fsm\/73w8Qvvt7jH7SPwW7p6VSaKWdYDctqWVbOsnkME00xJ3T0LlPLQ30GCjfvWPU4duH3K+3flLxmbm5RVVUJAOFerTCq0bBSZ8tPiI\/DcHxkq16E8i1SH7glmjGdBwFA7NNYnX2jWTIsB9e4MiGhYQBQVlpqbW3T2Jk4jo\/6aOzauw9Kl67Y4eh6VU\/LmrEAspBhD9PsgYiuPU+eGzFthlDItm5NyWWFaWmpANCzV28ASOTzPkhqIoIg\/9PQJC+CIG+hID\/\/ecozAOjesybsu3fnTkiwns9jhSJGJq\/JonBydp7z2efw2edKpfLF85TsrKy40hKlQskwDI\/Ps7CwdHRy6uzj4+DgiONv8R+fPr6+8XFPu3brEdomlHvnstZFaPQ0RkDEvEgGgGFDh69efUgWatHM\/i3TtAMXDAaAqJxExr+pmVl7tcDD0wsAEuLjglq3brpbgUA4edr0iVOmxsc9vXX1alnkA\/Z5iq1Oa4NhEgxIAD2AjIVilpUKRURQK\/fO3aYNHOTk7AwADx88MJEwPC7bvp3u1vXrvr5+Xbp243K5Kp0umcdto0WxH4IgbwGFfQiCvIVbN2+wLGtrZxfwMnf19q2bXTrrMAxMTVlZdXW980UiUXBIaHBI6H9+6Yvnz83\/ffXHHUZ17dYjOCSUf1jdWNgHAE+kqTRNe3l5dyA8rkCju3HUhemZES4RpmZmer0+ujwVoKnlgO1sWxgC1ri4p5aWlrXLHJuA43ib4JA2wSEAoNPp8nJziwoLq2XVlF7P5XC8zMy7ODk5OTkR5Gtfy1WVFWbmLAD06qk9fOzSnE8\/lZiYtOvQ8e7ft6N5PBT2IQjyVlDYhyDIW7h54xoAdOvewxD0yGSyRw8fLF+iBQBLC0Yqlb7h\/e9EKi37bs3yA5pIVReT6LREALC1s\/PErGIbrxRYxFPl5ua4u3tM6D781rPtOnvBG68ifCGfOG08ALx4\/rzCtKnqK4SCCvdsZXgdk5t8Pic5uyD3uyXLSbK536hcLtfTy8vTy+uNZ5aVlXm4MADQp5du+YqnOTk5rq5uvfv0vfv37Rg+d7rs\/e+MgiDI\/zC0tg9BkOZSKhWPHj4EgO49exlarl+74uWpcHejAcDWlikpLnq\/V2QY5tjRw+3nDvzNJkHVwgQwiCp9TtM0hmHt7QOg8XVyOkfB09gnADBk6HD7jGZV0GuncQwLbwsAMdGPtU6NjiMCALdAZRi\/pGn6SVmqys9kne762DkTpB9gG6GiokI7OxoAzM2YLp00p44fB4A+ffsRBFFNki84nDd1gCAI8goK+xAEaa77d+9qNRqBQBAR0cnQcu706UEDNYbXjg50QUHBe7xcQnz80OmjJj\/emN5JwIhqBtJKRdqMjHQACG8ZTFY0OsWpt+E\/iY8FALFYPNG\/D65+Q+THy1PN6j\/BkJAbmfyEMm+qHrK4hApq1RoAcnOyi\/lqANDZ8k95F3T\/ZOjjR4\/e7kO+AZufl+fsVHPzo0aqTxw7StO0tY1NSFgYADwWoHxeBEHeAgr7EARprhvXrwFAh44RQpEIAMql0kcP7w0aUBP2OTnR+fl57+VCebm5X3zzeZdNky60kmrcX9tRVOsgiH0SAwAhoaG8fHVjPbAE9ig\/0fB6yvipJomyxs408MnlDhk6DAAYhrlfmNh0zelWpu5isRgA4uPidA4108eMgEiM4PTbOWf9xh\/1ev0bP2NzaLXa4qIiV5easK9rF51Ol\/Pw\/n0A6NuvPwBE83lvXRgGQZB\/MRT2IQjSLBRF3b55EwB69u5taLly+WJggMrRoSbwcHWmkxMTz54+9Z9cJTc3Z8myRaELB2+zeloVas4S9eMvvTXvSeJTAPDx9bOUNbWWLlGRK5fJAMDTy2uYeWgTBV84pZrPe0zg8ngAkJOdncttKkbEKKa9c6DhdVxinN6mzngbBpWhZt9Wnh4wbVhyUmLTn7Q5srOzeVydjU3NE+aQMGyI5sTxowDQp29\/DMPKSTKdg5ZoIwjSXCjsQxCkWRLi46TSMhzHu\/WoKd1y8fz5gS+H+gDA1ZXWU7qJZ1cs+m6hId5qPpZlo6Mez5k\/N3jR4B\/FD0o7mDGCRnIVcCyq6BnLshwOJ9zKp4k+lXacp09jDa8\/nTxHlFQ\/y7iWZyo2btxEw+vHkY80zk0u7CvRhLYKMbyOKUxhyfrfojpb\/o0QeZd1E1etWSGXv91zqKuiovzrBV+6udFEnSuMHK6+duWyTCZzdHJq1boNADzmo3leBEGaC4V9CII0y\/WrVwEgIDDI1tYOAKRlZdFRj\/r2frU\/mImEtTRntA78jbz74TP77P5tp0zWaKRlwLJs6osXv2zeFDGpT7e9s3c5JZW3N2804HspWZUnl8sBoKWNJ0Y3OoandRLExEQZXgcHh\/Qj\/Y2ezC3RfNVjsvDl1iCP4qP01k0FUrx8dXBoKADodLq4igzjn4vAytuaraSvhs\/o8\/v+vVrtW++i9iw5qd+ckffxLE\/P18pNe3vTnp7Vly9eAIB+\/QcAQJSAj+Z5EQRpJhT2IQjSLLdu3gCAnr16GfIebly\/FhCgtrd7FXJgGLi50WSFjjLlPI\/gfZL\/R4uZ3abNm7Fvz+5HDx9kZ2WVl0vLysrS0lLv3vl7\/57dny\/8ImRCt9B1o+erTj4M1ykDTBuOnBkl9xRu2PRTauqL62mRDWeBazEC8lFGXO3NfT39C6MDfv7p3ImTphhesyx7Jz8O8KZW9rEYRtM0ANy4drXSpqkzKTPu8wjerNTfwif33LVzR2Vl5Rs+GAAAqFWqzZs3dlszMbo9g6tob6\/Xwj4MYOhg7bkzpwGgb\/8BGIaVkmR2swvHIAjyL4e+LBAEebO83NzUF88BoEevPoaW69eu9O5ZfxDLzY3mlNRk1+qteYXWvP1s+p+FzzjxWlJOYTqaxTCWj9MSjt6CSzlywAkDMH\/bm9HZC9ZJb\/689rwqUNL0l1ik9LlOq+VwuQAQGhY2ZH\/QIX02y3kVXPKzFEtHfM3n1+zDlpOdlUlWAjS1q4fKT7Jl+y8hQcELLm9WtTN58906CBIc4LOiP1fM3j3Eqf2ALn06RESYm1vU28aXZdmc7Oyz507\/9uhkmg+jb2cKAJxynZdX\/RzkAf00P65\/KC0rc3F19W\/ZMjkp6TGf56F4iz3oEAT510JhH4Igb3b71g2WZe0dHFr4+wOARqN5eP\/Boq\/qh33ubhT5\/PWiKhhQ5tym66G8A70VT2\/15jVtUic8dGpPChgdrdcDo9HrOJZCne3LzXYZ1u6hLNMmffOmjTwul8vlpqQ80zS+84cBbcLZqovEkh7q2jW1jUfDGy6K4O1kkvffixEeUvvy7FpYuNmJrYRcnlqvLZSXJZRlpOPlSl8J3fFlKT6G5VTofLzqx3P2dkxQoPr6tStjx0\/s139gclJSlIA3RqFEczcIgrwRCvsQBHmzG9evQ53NOWKio8zNZV6e9QeiXF1oTtX7qV3yXmjcxYnuAEAAGCtrjGM5H9kvYq5iNIspWZCxmAVLmfKNnPm65kScxuGY1kWodRFGgj4S0oBNxVhgMQBrDDyg3igjoaB4LO3sZGTlXq+e2uvXro0dP7HfwIEbflpXyOHkk4QL1ayq1AiC\/JuhsA9BkDdQKhVRjyMBoFuPHoaWRw8etGurxxosbHNyYohq42EfoaDM7pSygAEGNf8DAEMXGLBQ2wIAGGDAvn4CALAY0BKOIvitJ4VrbkBJmd0qNVqQj+Hilb3t3q1bslKHq2mMhZotQxgWWKj5kQXMELMxbG1LTTsLwLIYC8AAsKzOjt9w+ziySmdvz3C5RtJQunXRbdn2UKvVenh4+vj6pb54\/pjPc1Go3u0jIAjy74HCPgRB3uDxo0iNWs3j8Tp0jDC0PImJHjLQyA4Z9nY0rqIximXJ+uGVJKp85cDP2nfowLIsywLLsizLsE2rOc4wL9+zbesvl8uqms60bYwgTf5Z+zHDho9oeGjdD6tPlOXrrd88zlcPp1wbcp3q2LYjBkAQBI7jOEngBE7gBoThb4YfMfz19pf\/T1HUyv0bCyY41+ucrKYcHY0P4Hl7UUKhLDEhPjQsvE\/fvqkvnkfzeaNQ2IcgyJugsA9BkDe4e+c2AIS3bScSiQGApulnyUnfLTaSQ2BqypLAYjqafT23FFfTflLJzI9nGbIr3hmPz3+wcmb5UMd3eK8gXTFmwTi\/Fi0aHho8dOjFc+veOuxjWOsrpVu3Hg4NC3+H+6nrceSjg0Wp9Qb8CCVlZWm8NguOQ3Ab\/dMnT0LDwvv067\/1l825HE4JgdvSqJYLgiBNQWEfgiBv8PftWwDQuWtXw4+lpSUqZbWnu5GBKD6PJUjAdQzzel6EJKZi9rT5\/2HMBwCdOneJEPncSCxgeATGsoYZUowFYF9OpNbMsRqmU1\/NrmIM+IKNr5+f0W579Optsv472uTl+j+szt\/htdd1JlwxXoHqkwGT\/\/OYDwAmTJpyZv3citfDPkzHiG0brUrY0p9KSXkGAC1bBjg5Oefn5z3h8fqrGt2tDkEQBFDYhyBI0\/Jyc3OyswGgc5euhpaC\/HxrG4bPbzQiqQfXMh55nNEfjf3PbwbDsOXfr2p35ZJhJpUgCIIgcJwgCNzwAsdxDMNwQxNeewJOEISjkxPWcDUiAABYW9ts+GZ1VWUVC3X\/AqjzgmVrf6z5i2hBzPh41n\/+oQCgc5euft+bRWpohv+qVDX2cmWjUW5u1J37WQCA4XjP3r1\/37c3ho\/CPgRB3gCFfQiCNOXhg\/ssy9ra2nr7+BpaKisqLMyNTyaq1BhFAcN7bZsN8dPKmeM\/Fgjqpyy8mzbBwW2Cg99LV3WNGTv+vffZfARBjBs1PjFmjzz0VTIvw8XlikbjPmsrRiotY1kWw7Cevfv8vm\/vcx5XjmHvmPCCIMi\/Awr7EARpyoP79wCgQ8cIQ+kWANBTFIdjfKgvv4CgSRyjGELx8gSGtYiX+05rER31+P\/kfv+pPDw8JHurVX6v6j8zPDwnp9GvaAGf1et0huHAsPC2EolELpcn8Lgu\/wf3iiDIPxYK+xAEaRTDMIbSLR0iOtU2CgQClcr4KFR0DIcydRMl961dDIdpFDLXqlGbjn\/4m\/3nc+wrjrNmOTxgaEnS5f5hwbefl1RXY6amRoJshRLn8wUsCxgGPB6vY6fOVy5dfMrjDvy\/v20EQf45UNiHIEijsrMyi4uKAKBt+\/a1jY6OjgWFBE0D8dpcLrAA587zNW5hsvbNnTDFAeyFhLcZx0lMWgkIMQcjMNAxINMxpSo6T0FlVOulGqa5qwj\/h8jbjs149FPLgDanz92ZMtHIir3cXMLR2bl2tWK37j2uXLqYxOcy7L\/waSEI0lwo7EMQpFGPIyMBwN7Bwdn5VVU5dw9PHDdNeV4Z0PK1Gi6PIrnPX1j16ag\/SmlZstHSemZcPMyW196O19aWH2LDsxEQ2Ot5snUHEhkWipTUk1LtgyLNrQJNXJmWeteohsSghQW3tRXXWUyKObieYYtVdEqF7kmZVq5\/P6ESiYEFn7AXEdZ8wpSHC0iMxDGWBQ3NyLRMqZrJV1BSNd3MzTTCvZ06tx+2fEnMsCEaU5P6dxj5mBMSElL7Y6cuXTAMqyTITJXSeLoygiAIANk6I+ND9JsxZYr83r0P0fM\/S8uHDzm2tu+929xvvqk4efK9d2s+aJDr5s3vvVvA0WahAADi8HCvw4c\/RM847133CmtS1qxZ1y5dAIDQsHAMe\/VL5HA43Xv2OnH6z4CWitrGqmps0VLJvPlfh4SEXtx6UR48vG5X9kKiiwO\/s6Ogoz3f34JD4hgAqCgmrkx3Il2RUqHPkVNSDS3TMTQLPAIz5eK2QsJVQvqac1pZ8Xq7CAd7iACgREVfyVGdSFdez1dr6WbFahhAJ3v+5BaSge5CGwHR8AQtzT4o1JzIUBxLU5Zr36LuHQbgICLCbHitrXgBllxfc46bCSni4I1n3wILUKlhUip00SXaO4Xq2wWaap3xK3ILkiI6hfTtN+D40b5fLzr\/69bqumOrUil+4xb\/zFeDa1vs7R08Pb3S09OeOzs7eHo2\/1M0E87jfaB\/WaSNGaOMifkQPX8IwtatP9Bz+EAKVq\/OW7z4vXdr1rfvP+s5fCAFq1eX7d\/\/376Lt0PyPDw+RL\/4e8ra+6fjurpyHRzee7eE5C32gG8+XCT6QH8eEADA+Px\/1uPVFxc\/12qAwwkNC6t3aOas2aOHn546Se3qQgOAXIFNn2XWouXgKdOm4zg+VHjw4MsBv0FuwkHuwun+EhzDWIBcGXUsTRlZrIks0SZIddoG87c4AGHYuo0FqqZ4CggILMyW19NJ0M9NONFPMrmFpFxDH0tT\/pEijyrVNhb9WfPxUV7ijwMkrax4DAuxpdrdSbInpdpMGSXTMzwccxQTgZbcLo6CHs6C7s6CjRFWJ9MVe57J7xVqmoj+XMRkT2dBN0d+J0eBi6RmNxINzWZV6\/\/OV+fIqQIlXaamq7WMkmIZhgUAPomZ8XBbAeEiIb3NOEFWvA4O\/HltTDU0ez1X9XuK\/Hy2Sv\/6JU1zoiKWLsYwbNPmLaOG5SxYFP\/jGhn3ZWHBNT+JO3fpX7cMIYZhHSIi0tPTorOzOmZmNvFrfTe4UPih\/mXBf+vNUf6LcB7vn\/VPMaNUaj\/AnwdGq\/1nPYcPhDA1\/W\/fwltDk7wIghgno\/QlJAkAbYJD6x0KCAwaM3b63M9+PXKwsrIKn\/WJqa1931+2bTdk+y6cPeXc+tPVYR8BwFAP4R\/P5Bwcu5WvvluoyZW\/NkmLA7ibkG3t+KE2vAALjpsJx1pACEgMx4BmQaFjSlR0lkyfUqmPLdPuS5Evj6p0lZAjPEXjfMSzA01mB5okSLX7n8lv5WvyFBTDshZ8wtuME2bD6+ks6GjP5xJYhYbe9LRqV7I8tapms2ACAwGBMSykVulv5ms2x8vEJDbYQzTdXzLOVzLBT5JWpT+aprico4or06lplgXg4RBkxRvkLhzsLgy05OEYUAz7rEK\/M1sWVaKJLdOlVum1dHNX1eEAHqZkDyfBYHdRbxfhIHdRtkz\/U2z13mdynSEOZpm23HIOhwsAZubmh46dmDZpwvhJMT9vlDk50L\/tFd6953zhypp63XboGHHg9\/1J2Vl6AE7DqyIIgqCwD0GQxmSoVAyG8fh8vxZGVost+W7ZzGmZw8dcKy4mRo6eueS75RxOTbCRlppq+vAPecu+jNBs1m0pxcLd4rLaNxIYBFhyOzvwO9nzO9jzHcQkBsACVGuZbJk+vVov1zEUCzwcM+Ph9iKim5NggLsIA2BZyJTpr+WqzmapOpwo8DXjTPU3megn3tzZCgAMG3NgWM3SQJmOuZitOpamOJ+tUlIsn8CGuAv7uwrb2fHdTUgRB2NYqNYxLyr1D4o057NUR9MUh1IVPqacqf6S8b7ib8PMvw0z19KsVE3TLBiCUQAoUlL7U+RXclR3CtRlGgYATDi4vwVnrI\/Iy5TjIibtRKQlHxdzcA6OYRjoaFapZ0rVdK6cSq\/Sx5Xroku0FVomvZpKr5bvSpbbCoipLSSftTLZ0dWqREWdylQBAD\/7SXrkrRPHjkyaMg0ArG1sjp0+u+r7Zf0GHujQXhsd4\/D7wb\/s7O3r\/UbC27XDcVyuVueSpCdlZOs8BEEQFPYhCGJcmlIJAL6+vlyukbWDZ06dcHF84OqoNTNji8viKsrLbe3sDIfMzS0wVbXZnV0V\/RbWDu6Z8fBh7sJ+rsKuTgJrAQEAOoZNkOpOpCsfFWuiS7TZcsro1CoHA3cTTqgNr6M9r7uzcHag6ZxA0zI1fSJd+cdz+dJHFd2dBGG2PDshgWFQrWUyq6lYqTaurGYG2VFELAk1mdHSxEZAsCxkyfR\/F2ikaprAwUFEBllyO9jzvw42y5JR+5\/J9jyTL35U8W1kRZgNr7uTIMiKay8iCQxiSrUJUt31PNXjEi3DgpcpZ6iHqKM9P9yO521as1QRAGiWrdQy5WpGpmM0NMuywCcwCRcPs+X0csYNmSsUwz4t053LUh5JVaTLqBI1vS62aktC9ShP0elMlaEfSexJlUrl5e1T+xBUKiWHLB81QltcAkOHVFw6f9Dbx6deBWwLCwsPT6\/0tNQXXA4K+xAEMQqFfQiCGJehUgKAf8uAhodKiotzM+auXFZt+FEmv7R5x8plK3YYfvQPaAkAls+vKQP6aZ2DDI3nBtheyVYN9RQ9KdXuSZb9XaB5VKyV11nRRmLgZcLxNec4iUlzHs4nMZoBpZ4pUdPZMupGnvpwmgKg3MuUM8xD+JGPeHagyZxAk3ipdmeibMPTqnrZuOZcfIiLcKyPuL+rkEtgzyp062KqTmYq8xrMMgdackd4iib6SVa2s1gaZn4qQ7k7WXa3UBNZoq3bIQeHzg6CnyMs+7sXohKoAAAgAElEQVQJPUw5GADNgmE6OEGqe1ahT6vW5ykoNWVkqhcDMOPhvmacYGtehD2\/h4tgVTuLFW0trueqfoqtul2gUVHsHy9q8mM4ZZmCtPsEQfi3bFnbw9bNC7+Y+8fLzVGqM7N+3rXDbN78pfWuExwSkp6WmsrloF3aEAQxCoV9CIIYl6VWA4BfC\/+GhzAMo6hXub0MA3idVF8rK2tPLy+WZbmRO5\/ZbWI5fABYFVX1okq\/M1leUSdbVkBgwda8Lo78zg78cDu+Ge9VGixbk9dRM2nLsJCnoB4Uqm\/maw6+UKx\/Wh1oyZ3mL5ngK\/61m\/WPHS3vFKizZBTNsrYC0t+C09KSy8ExPcNey1XtSJRdyVEzAHZCYoi70M+ca8HHKYYtUtEJUl10iXZZVOXK6Mr+bsJPAk1Ge4vH+ogLFNTNfHWCVFelZUx5eGsrbh9XoY2AYAHSqvTbE6pv5qsfFGoMNQVxADMe7igmO9rzzXm4iIOThrWJeqZCwxQoqRw5VallIku0kSXaHUkyDgZdHAXT\/CUjPEW9XYVXc1TDLpVoXiYmm979LTAggGFoU1OzV0+YVgkEr+JJiYTVapUNfy+t2wQfO3I4k4O+2BEEMQ59OyAIYoROpyvUagDAx8en4VGCIJKeuX67nPLwoGRy\/OlTcsSYHrVHMQwLb9vO3MLizKmT9pH7CjvNBYDr+TXjTzgGra24vZ0FPZyE7ex5Yg4OAEo9E12qjSrWJlfocuRUhYZRUQyJYxIObickPE3JlpbccFveaG\/xOF8JzUJkkeZwqmJ1dOXSRxUfeYsn+Yl7OgsNy+8ohs1XUKcylDfy1BeyVMVqmk9gU1qIp7UwaWfPJxqUV1HomcvZqn0p8ovZqnNZKm9TcoKvZKiHaLyvZNLLNY00C\/FS7ea46jMZyudVegzAy4zT300YasNrZcnzs+BY8okmCrfoaDatSh9ZrLmRr76So67SMTfy1Tfy1a5i8rtwMw6G1cZ8\/Kxos+zIPvO+rKyorC3FDACtg4fPmH2la2edrQ2Tm4c\/juIOGh7Y8EKtWrcGgFKSlGOYBNVtRhCkART2IQhiREFBvo5lAcDT20jYd\/TwobWrEuzsmKJiQiRiv\/iE+XbFjsFDh9We0LtP3+vXrvbo2etJTEzV89sqv26G9s8CTbo6CYZ7igBArmPuF2ruFKjvFGieSnWa1+vwkRhwcAwDiJeytfO3ljy8h5NgsIdooLtwm4PVhgjLUxnKHYnVXU8XcXCw4BM4QJWOUb2cyLUXEouDzT5tZeIgImU65kiq\/HquOrFCV65mSBycxGSoDa+\/m3CYp2iUt\/hFpX5rfPWBF\/LlUZXLoyotebiXKUfMxZV6Jr1aL9UwFjy8j4tgcahZdyeBo5gEABagTE0nV+jSq\/Q5cqpISVdqabme1TMsiWEmXMySTziLSV9zThtr3lR\/k+ktTdQUey5LuSNBdq9Ik6OgZtyS1saLmE5lceWnL778Kj0tbez4CbWPgmXZqEfr\/9xXVVhElEnxdm11n85RLVn29fARo0jyte9wL28fHo+n1WpzOWRLnf4\/+P0jCPK\/CYV9CIIYkZOVBQBiscTKyqrh0c5du2742eyT2dUuLkx1Nbb3d4GH99C6J3Ts1Hn1yhUnzpydNO6jDpmn71i56a3cgYX29rxdibLUSv3lXNXjYm3dun02fLyjPb+DPb+1Nc\/LlLQWEDwCwzBMR7NVWjpbTj2r0MeUaO4XaU5eV\/JIbLC7cLq\/yRgf8ThfcXSpdmei7F6hWqpmzLh4sDUn3JbX11XQ1VHAwbEsmf6Lu9L9KXLD+j8OBkIOTjFsloy6U6jZGFftIiZn+Es+DjDZ1tVqdXuLI6mKExnKx8Wax6VaDMBGQPR3FX7kI+7uJOARGM1CglR7LE1xv0gbXarNV7y+b0i9yek6HEVEHxfhGG\/RSC\/xaG\/xnXz11w\/KY8p0tc\/A4vrPnVu6TZg4efTwoaFh4bVvxDDM1r7vqbOJfXtrHR1otRa7ep0HRHeSqF99msfjuXt4PE9JySVR2IcgiBEo7EMQxIi8vDwAcHJ2JhrEFgBw\/eqJ\/n2Vj6O4p8\/gYjHr6Uk\/inla9wQul9uzV+\/rV69u2b5z6qQJrR9tedJ9GSMyn3C9jGHh2ssJXwkH6+TA7+Us7OYkCLDkEhiwAFVaJr1KnyDVyfQMw4KYg9sICA8Tsq0tf7q\/hAUoUFAXslRH0xV9zxZ5mnI+CTKZ0kKyt4d1bfhliLgUeuZCluqP5\/JL2SqKhQ52vFHe4q6OAm8zDp\/AGBYqNHRsmfZKrup4mnJZVOW6J1Uf+YjmBprOCjSZHWiiY1jDoKAFnyAw0FDstVzVqQzV1VxVkYrGARxERGtr3lgfkbcpx1lM2ggJc56hbgump9lKLV2kpDNk+nipLrJYk1KpL1DS+1Lk+1LkXibkgmCzqf6SPT2sg48WGMI+cewpv4qErX9ePnn82OBhw19\/7GxVZb6TLez8TajRYFwOGxBA6TRRxcXFDcu4eHv7PE9JKSCN\/NYQBEFQ2IcgiBGFBQUA4Ojo2PAQy7LS0shec7R11p7BnfsPWZY1LEfLzEi3trGZOn3G1Enjh40Y+dPGTfM+\/cTr2qr0\/qsYnggArPj4R97iIe6ijg58AYkZIrlDL+R\/F2juF2oyZPqG+65hAFZ8PNSG19VR0N9NaIjMsmT6\/c\/k655ULXtc0c9F2MqKZ8rDtTSbK6fipNrHJVoVxRIYDPMQLQ4xC7bhsQC5cup6rqpETfNwzMOU08mB39dV+FNHy7MZyo1x1ftSFPtSFC3NOX1dhcE2PAcRQTOQJdPfK9RcyFZVahk3E3KIu7Cbk6CDPd9RTNamm8h1TImaLlHTWoplAXgEZsEnOjly+roJDefkK6izmcrfnytiSrXpMmr239Jf4qt5BGaI+QSp97xj\/\/z9+AmRUHjk8F\/HT5\/LzclJTk7q138AAOh1eoy5OGqEpu4DkUiy4p7G9rUfUO9BeXh6AkAxCvsQBDEGhX0IghhRUlIMALWl+OrCMGzQsO8\/nhs7fJjCwZ6WSvFz5\/nhHRfWpiBs37qFw+GsW7+xU+cuhw4emDx1+o8bNn7+6Vy7U4uKRvzIcoTnB9qdzVC2s+fdyFNdzVXfzFO\/qNI3nYDAApRpmMu56su56oWPKlqYccb6iCe1qKm6ciRVsfFp9ZH015JbPUzIUZ6i6S1NvM04Mh3z89Oq\/SmKxApd3XMEJNbXWTC9pclwL\/FIb\/GdfPUv8dUXc1TJcdV1T\/M353zRynSYpyjAkosB6Bg2vkx3JkMZW6Z7VqFLq9ZXNtxmDgDHwEFItLbmdbLn93cTzg0y\/STI9F6h5vvHFbcKNCmVNZOwgrT7Le7\/8udff3l5e\/+8cf2wESMlEvGcj6e7u3sYwj4Ol2vrtHjZiu8G9Nc62DNyBfY4ipOQ3G\/dhp4NH5STswsASEn03Y4giBHoqwFBECPKpVIAsLa2Nno0KfHp1EkyDIfsbMLCgl38jWLT1gPjJkwyRH5BrVqvXrG8hX\/Lz+Z9NWLIoO49e3Xq0nXP\/j8+njaVPvJl2aj1ix\/yU6v0WxJlKuods01TqvS1VVc+DzKd6CeZ6CeJLtHESXVamrUTEm2seZ6mHByDQiX1\/eOKbYmycmMb7aop9nSW6nSWqoU556vWpuN9JaedBMUq+mqOKqFcp6ZYFzHZy0UQbM3DMChQULuTZJdyVH8XaKp1TWzbW4NhIV9J5ytVF7JVix5VBFlx5waYTPST3Bjm8GeKfMrNMhZA\/PRsaMaZfSdPuLt7JCcl3bpx\/ejJM0sXLnyWnDx8xKiafmg6\/cXJWdPVGZlkcgopEbHBrfWJyaksY+QebGxsAKAKxxseQhAEQWEfgiBGVFRUAIC5hYXRo9VV5e7utL1dTdjBMICBtPZo5y5dA4OC7ty+lZaaOufTz7787NO\/jh4PCQ07e+nyp7NnRR2cc3\/UBsqs\/qK0d0CxcC5LdS5LFWzN\/TzItJ+bMNyWDxjoaDajWr87WXYuS3kjT\/0qQmNZXCMnFOWYTonRFEtwGKEZLbFmSW5KpX7mbel3kZVTWog\/8hFP8JPgWE1uhlRN73kmO\/hC8bBI865hKrAA8VLdrL+la2KqfuxoESfVYmqZxfWfR7qSP509Z2JqWl1d9cWnc4cOGzZp3EftO3RwdXXr0rUm\/VlP6QX8DB9v2sebru3Q5lq+Qqnkv75RBwCYmpkDgBqFfQiCGIPCPgRBjJDLZQBgYmJq9KiFhc2qNWIvL9rVha6qwpKSSUubQbWTvO7u7jhOLF22PCY6+sD+vSnPUhbM+\/yX7b86OTkfP312+9Zftu6dW9T7G7Vn+\/d1t7Fluik3y3AAcx5O4li1ltHUmXQlqwqFL+60wMpDbXle9lY23jYmpqYEwaP0+vLyF7kFt5OKFVFSqszSt9S97bpYel1stRUf9zTh8EisVEWnV+vfOdprKEdBjb1cKEq4GJB0ctn8z4aPHI1hGMuym9avNzExKS0tXfnDGq1Wm5ycbGNra3gLj8en4aOvF+8JC9Fb2zAVFXhcPJmR5cPlchr2z+cb2UkPQRDEAIV9CIIYoVIqAUAsFjc8pNfrszO+37FFVlmFFxTipibstMnqVWt2aTTf8vl8AGABZs6evW3LLz9v2TZm7DidTqfR1KQjcDiceV8tGDx02NrVq84fPlLdfpLGNRiwxisdvw0GoLzOFiDAMoK0+4HlTya19+m5dHhJSUnc09jKikpZdRUAAGAssMCyQpFo2oAuO8LDszIzr9+8fCay+JnAs8K3q1Rj5LP\/hzC9RpR01Sb+1JSB3T5bf97M3LymHcNWrP6h5q5ZduK4j76cv6CoqNDezh4wrLS0xMJk31dfyF+kkeXluI83NXiAplQas2\/PznlfLax3CRyN8yEI0jgU9iEIYoRWpwMALtfI0BFBEEqVp1xRam7GmJsxAKBUYdVyDw6HAwB6vX5An55\/HT3+x759Dx\/c79Axgsvlcrlcw3tVKpVQKPTw8Ny97\/fEhPjffv313IFtlS36qFr0oCXG1xG+A1yrECVe6cMrnD2qv0joc+XyxRPHjrVt1278hEkWlpZ1d79gWVapUCQkxO\/fs0cmq+7Vp++ibzolJiacPnf2eIw0y7qVxrM9S\/6n42cYQ3HzEoQpN9ykieOGDZq09oSNTc1I3rPkJF8\/P4J49VV86sRxKysrsVjcq1uXpwnJHC5XKBRKy80Zttrfj6o9LSOTtLa2bXgtHSrXhyBI41DYhyCIETRFAQBhrA5IRXm5Mh77vq+1WQ+1qQ1dUkowMPDLr380lJrjcDgYhn27aOHanzbMnDb5wF+H7ewdDG9kWXb+vM+HDR\/Ru28\/AAgMarX1153LSkvPnT198cIPUUVKpUuIxqWNzt6PERifXH4DhubnxdnlPhrrazLxm1EcLnfPrp3BIaGLv13G4xkP3TAME0skHTpGdOgYQVHU5YsXFi\/8evrMWd8v++5binr04MG5a4fPZcjyLfw17uGMwKT594KrZZyyTG5RCi8\/wVmd3719aP95Izp13sJ5GQHTNH3syOFbN2\/s2r239l3JSYm7d+3cd+DPGVMmeXv7GE4WiyWTZ5z\/Zul8G8uHTk60UonlFbh4en8+ZfqkhtdVq1UAgKOd2RAEMQaFfQiCGGEIOPQ6XcNDG5csnFGQY4Lx6DM8FbBX9HRRO8qqTs5vx4hON2\/c2PPbzqXLvp85bcr+A38ZjmIYFhbe1srKetuWzb379PPx9QUAaxub6TNnTZ85SyqVPnpwPyY6KuHeXymFlZU8C8rMgZbY0CJzhm\/CcgUMyQWMAGAxmsIoLaZTERoFrq7GVZWEvMyK1HcP9OzfrVP3nqsFAuGpE8fT01KXr1wtaJD00BiSJAcNGdq7T98tv\/zs7uExctSYTl26dOrSZS1FxcbE3L5z5eTZe\/nVWkpgxghMGZ6I5QpYgsPiBMayQOtxvQbTKghVFakst8K1nrbmvr6+Ab2CQsOGefv41i2\/TNP07Vs3U188HzhoiEIhx18eevH8+Zeff7p6zbr5X3wuEok7RETUvb2yx9IB5aYkhilYNr1d6ynrZhmdz5VVVwOAyEg9GQRBEBT2IQhijLW1dWVFRXFxcb325ynPzG9cM+HgAEBgIAFMxUK\/6Ic\/LPhq5dbthvnTgYOH5OfniyWSX7dt7dGz96TxH237dZeHpxcADBw0+NrVK3M\/\/fz2rZt3\/r5lamYWEhLm6uZKkhwrK6tBQ4YOGjIUABiaLiktycvJLSouKpdKq6oq1Cq1RquhKRrDgMPnCvh8gUBoamZubu556uTxL1cubhkQULtB7aGDfxIE8c3ipe\/wwXl8\/tcLFx8\/euSP\/fsmT50GACRJhrdrF9a2bVV5+eJvv60or6iqqpLLZGqNWqfV0jSNYRiXy+Xx+SYmphYWFtY21iKRGHt9wWJ1dXV+Xm5mRkZZWSkA1rlLl569ev\/5x\/5Bg4cYTrh\/987CBfO79eixdPGiefPnH\/h9\/+AhNXscp6el\/jZutFVlpSvfkMOBKR7dO3Pq5PCRoxref2VlJQCIGLrhIQRBEBT2IQhihJ29Q+qLF4WFBfXar1250pV4LaBhAZxw3OfS2eMdI0aPHQcAbYJDykpLFi1Z2rNX721bNufk5AwZ0O\/w8ZMBgUE2trZu7u6XL14YMGhwj569ZNXVcU9jIx894PMFI0aNru0TJwh7ewf7l7PDTUtMiPfy9q6N+WKio3Jzshcu+fbdPjhN02mpqQzDHD96xNfPr137Dob2B\/fuhoWHm5iYNpbd3LSC\/DylUtmuQwcrK2tD6u6RQ3\/5+fkbZsCzMjOmTprg5u5uaWV15MTJrMxMoUDo6eUFACqVavPHM+ao5HvrPPVgEt\/1+95hI0ZiDbJhKirKAUBirKQfgiAICvsQBDHC2dkZAPLz8uq1azVqUb1IAwMMoB1J7Fy7umefPhYWlhiGzZv\/9ZrVK3fv+2P\/gb+qqiqTk5KcXVwMp0d06hz3NHbHtq3Dho+wd3Do\/LI6XWN0Oq3RzJJaI0aN2bf7t8\/mfWn4kc\/nm5iYrlj2LY7jbYJDuvXoIRZLmvORnyUnnTl9SqvV+vr6tW7T5vjps4bEZABQq9VnTp\/6ccOmpnsoLCwQCATm5kaKHfq3DDC8YFn2SUz0o4cPevbq7dfC39Do5u4Rl5QiFIkwDKMo6oeVK35Y96Ph0PYNP43Iy+TiOFZn2hYDIJMSNRpNwynsstIyADCjUdiHIIgRKOxDEMQIFxdXAMjNya7XzjbIFWABDHHgcJV8\/6+\/zl\/6LcMwHTtGnDx+7MSxI6PGjDUzM+8Y0anuW27fuung4Hji2NGSkpLP531ZW6DOqIUL5gcFtRoweHBt9ms9fi1aRD56ePXK5T59+wFAQGBQQGAQAFCU\/klMzJafN+kpatToMbWBV0OZGRl7d+\/y8vb57It5Ekn9vA2GodesWvHp51\/UXZ9XT1Zm5s0b16OjHn+\/cjWYN\/pZGIaZPWOapZWVp5f3ls0\/79i129COYZjoZa2cXzZtaNe+g5WVdVVlZXV1teLP\/U44DgD1njsBbMPfBQCUFBcBgAUa7UMQxBgU9iEIYoSbuzsAZGVmMgxTN3XA6IZghrjPBscKjx\/Wff3N2dOnzp05vebH9bNnTnd1cw9v267e6R06dCwqKgoIDIzo3MWqkf3fao0cPUar1Ty8f7+8XMrl8pycnGxs7bg8rpubu6FkDABMmTptw\/ofLS2tQsPCat9Ikpy27dq3bddepVQePnTw+NEjn3z2RYPLsYcOHiwoyF+6bLlQKGp4dcPY2\/CRo9zcPeq2R0c9zkhP1+l0NE2zLOvi6tqrd28Oh7R3aGpiGsfxnbv3KpXKp09j\/fz8Gp5w6sTxp7GxCxYuGj5k4Jfzv06JfTIEmJdx9etdGQvBAaCgoAAArNBoH4IgxqDCngiCGOHp5Q0AlZWV5eXSuu0sw9aLQVj2VVQSKKs68tfBAQMHZWVmjhk5bMSoUd8uXhT58EG9ztu274BhmFqtbtW69RvLC3eM6CSrlvEFgmkzPv5o3HgPT0+1WlVWWkrTdbIWMOyrBd8cO3JIrVZDg3hIqVQ6Ojr1Hzho4\/ofY5\/E1LlzdtOG9XwB38rSauf2bVmZGfUuzTDM6hXLh48c2SY4pN6hNsEhw0aMHD9x0tTpM6ZOn4Fj2K2bNydOntL0ZwEAlVp97uwZtUoV0blLvUNHDx\/auWObp5fX+DGjrKysBwwaVHnhnOTl6r16y\/gwoyOvLJuXlwsA1jRK6UAQxAg02ocgiBEurq48HNMy7Ivnz62tbWrbWbb+MBJbZzCqI0ncW\/Xd+qTEFat\/WLVi+dPY2MrKiknjx65YvWbs+Al139VvwMCc7Kx9u38jSNLB0dHNzd3H17dhgoLB0OEj4uPifvt1h7mFRXi7dqFh4Q3PwXF8xKjR169eGTx02IHf9\/fp28\/O3h4AkpOS1v2wauDgIRfOne3Vt+\/F8+dJkhPUqhUA7Ny+LSQ07PBfB4cMHRYSGvbdksXrN202DNdVVlbm5+W+eP68e4+egUGtGl6OJEmSJFNfPH9w\/75WqzUzM5s6fbrRYTmDG9ev5efmMizL5\/N79emj09avjPPT2jU7tm1xcXW1traxd3Bct37D9o0bQ5UyeFU68bUgDzP2u1Ao5NKyMgCwpVDYhyCIEWi0D0EQI7hcrhNPAADPkpNeO8A2GO17\/cdOJBFx9vi5nb9GdOpsZ2d39uLlbxYteZ6SUm9oKic7a89vu4QikZm5eWxM9PGjh+kmB6iKiwozMzNKS0p+37uH0hvfiMLX1y8rMxMAiouKzC1q8ioOHvh9zU\/rx4wdt3nbjjMnTy7+9rs\/\/9ivUqn+vnVTYiIJCQ0lSbLfgIFBrVuPnTDh\/r27hndRev29u3eTk5Iajsm9\/pR4BIFTFJWUmNBEzAcAtra2FE3jOK7TaXfv2pmUlFjvhDbBwSfOnLt5515iQvy4CRP3\/rjWe9\/O0DrlstkG\/bMNivPVTMqzrB0a7UMQxBg02ocgiHHeQlGGWpWYkFC3kWWMLDWr97MLjo+NjzmgVFSIJVcvX54xa3bDzj29vB2dnIaPGKnRaoYMHfbGqd4+\/fpVVFSIxeKZs+eQL5f01aNSq4QioeE2axutrKyys7KcnV1KS0oEQiFJkjNnzd61Y3tJSfHanzawLFtZUVFYUGBlZXX96tWZL2+VZVkcw0QikUqlbCwRmGEYoUgokZhotdrvlq9o+v4Dg1oZRg1pmt6+5Zdu3bvXO6FXn74syy5butjC0jLu4rnRiXG2RFPPBANgGkzyvnj+HAAsKFqIdulAEMSYf1jYZ9qzp8WIEe+9W11hYcGqVe+92w\/HatIkcdu2771bqqoqa86c994tIRK5bNjw3rsFAIdFi6iysvfebeXZs1VXrrz3bj+c7M8\/ZxsZAPtPtGrV6sqtG\/FPn7IsWzv9yrJsIzOxr7HEsckZz\/d5+1++eAEApk6fUe8EHMeHDhux+7edgwYPNTMza8btYGPHT4iNiTl25DBN0zJZNYbhn30xr+4ZsupqQ1E9B0fH3Jwcbx8fAJg155PFC7\/+fd9ehqa\/X\/UDAPj4+m3Z\/POX87\/GMAzDsNVr1\/249geVSjl8xKiWAYGGrjIy0l3c3Mql0pKSkoZhX25uzoJ5XwQGBfm18Le1s2sTHMx7WeqlCVqtJvLRo8SE+JGjx\/B49c+naXr5t0tVKiWVnzc2Mc4Kb\/iUG0zyNkivMQzNtvD3d\/9o3Bvv562wDPMhvhwAQJNRf0nle1F16ZL+A3w5fDiumzbhzd5RpvmsZ8ww6faGGknvgKqo+EB\/Hv5ZFA8f\/rdv4a39w8I+YVCQzWwjIwf\/IVVS0j8r7DPp1u1D\/JNcfuRI3uLF771b0sLiA4V9H+K\/AQBAm5f3zwr7ynbvZjSa995t8PZtcOtGXl5uaWmJra2dobFhqME2MrtpgWFjUpOv9uz38MH9osLChUuW1iuA4uLqOueTz27euH7r5nUcJ3Ac43K5I0aN4TQymAcAx44e9vL2IUnS3t6hb7\/+9Y5SFGW4RK\/efQ\/8vv+bxUsAQCyRbN2xk2FoHH919W2\/7qp97e7h+cu2HfW6unbl8lcLvrl547pCLm94Gy4urr8fPBT56GFpScmJY0e\/+35lYzcMAAcP\/KHTaXGc4HA4oWFhHSM61VaWrqWQy7\/64jM3d3eQy7rHx1i9aewTGknpSEpMAICQQYPf+\/cko1JFi4xkOv9\/S\/nkifLJk\/\/2XbwFl7Vr4QOEfaa9ekGvXu+927K9e\/OWvssuOMh\/HVrbhyCIcR72DqZmZizLRkVG1jayDdb2Ga8vAgAAzjjuf+1S9+49cBybPGFcSYOt3qTSsr9v3eTx+C6urjweD8OwJmI+AJj\/zUK9TkeSJJ\/Pv33r5tHDh86cOll7VCQSq1QqALCzt3dwdDh29HDtobox3xsd\/uugf8sAiUn9An4AkJebu+6H1X\/s23vsyOHcnByFQjHnk0+tm6xB06t3H61Wi2GYTqfdsW3rg5fLB2slJsSPHjGsZ+8+Ls4uLS6ddW5GzAcAOADzekqHXq9LTkoCgKBWrZvTA4Ig\/0L\/sNE+BEH+z5AEERYWfuP6tQf37xm2ygUAMFa3r4lZ3w4ksWftqs+v3nrxPGXiuDEfz547fOSo2pV8dnb2oWHhZubmHh6eIaFhpqZv2PfM2tpmzqefabUahUKp1+lu3bxRNzizsrYuKy0xvJ4wacrF8+eWf7vkqwXfmDZrEhkAoCA\/79ft2zp0jOg\/cBAAVFVVmZq+9l5nFxc3d3eSJINataJp2tPLm8vlNt2nrZ3dnE8+Yxjm+rWrpqZmXbq9WtWnUqm2bdn84P69TVu2crncPf17TyWNh6dGn3C9lI7kpGSVSoUDtG7TplmfFkGQfx802ocgSKMiOncGgHt376gX0ZsAACAASURBVDAvoz0WAHt9avGNuQMf6dRbv\/+ue8+eR0+eiYmOHjNiWHTU49qjI0aNFovEVy9finocKZfJmnNXB37\/\/ZdNG27euB7RqXOPnq8msMRisaxODwMGDZ776ecrln+n1Wqb021iQvyuX3d8vWiJIeYDgIL8vIbllz8aN75bj54ZGRlbN\/+sf9OSSrVaHfc09uCBP\/b8tsvFxWX4yFGGdoqijh89MnRgP1NTsxOnz\/n6+m1fsmgsXb+qS62GDxlvkNLx6OF9AHARCCwsLd\/4YREE+XdCo30IgjSqS7fuGIYV5Oenpb7w9WsBAMAwDYeems7xEGOY\/c1rUZGPw9u1W7d+Q3JS0oaf1lH6TbPmftIxIgLD8Lbt27dt3z4nJ\/vK5UsKhVwoFI0Z21RGwoyPZ508fkyv15mbv7YPGoZhXC5PqVSIRDUbndna2Q0eMvTYkcM2NjYYjge1amVnZ1+vN4ZhiouK1GrVkUOHvl+1unaWmWUZjUbD49XfDrikuPjWzRtqtXrTlm38JjM5oh5HZqSn+7VoMWrMR7X9KJXKUyeO\/\/XnH+07dDx09IRh15Ab1676P37I5zQ1E91gJ+T66yzv370LAK1M3jBiiiDIvxkK+xAEaZS7u4eXl1daWtq1q1dqwr4Ga\/uaow+H2L1pfdjRExiGtQwI2H\/gYGJCwu5dv65dvWrYiJGDhw6zsbFxdXVzdXVrTm8Yho0cPaaysvLSxQsqlRIDrF2HDn4t\/AFg0JAhJ44dnTx1eu3Jbu7uqS9emJqZswx97Mjhcqn00y\/mGQpQKxSKvbt3lUulTs4uIpHIwsIC6oyf\/X37dtt27ete99yZ0xUV5dY2tgMGDTYxtvKvnvC27Wo3pmMY5mnsk1MnTzx+9GjAoEEHjxyzsrKuPXR+4\/pPmoz5jDyE11M6FApFTHQUAISZNb4lMIIg\/3oo7EMQpCm9+\/ZLS0u7dOHCp5\/PwzBMaGGxx9YRwzDAAMNwnV6fmpPzxk4IAMfoyMSE+Npsg8CgoC3bfy0rKztz6sSMKZMkEknvvv26de\/h7OLS2F4d9ZibmzccFAxq1frMqZP5+XlOTs6GFjd3j4\/nzDW8bt8xoqKiYu3qVbPnzmUYdtev2z\/7Yp6rm3vDzmXV1ZcunP9xw8a6jYOHDmvOjdWlUiqjoh7fvnnj4YMHPr6+w0aM\/H7l6nppK3f+vt0qNQVrRthnSJquTZ2um9Jx787fWq2Wx9BBkjfHowiC\/GuhsA9BkKYMHDxk+9YtKc+SU1889\/VrsWDxUlj8qnADw9CfTJlc9vCOtZE6c6\/pSeJH9+8N\/HlL3ajO2tp65qw5M2fNycrMuH7t6uKFC6RlZa3bBIeGhbcJDjEkT7ztDc\/\/euGyb5d8OX+Bk7NLw6MWFhar165buugbDoe75sf1RhMyysvL16xa8c2iJW+V\/2vAMHRBQUFSYsLT2NjYJzFKuSI0PLxrt+4Ll3wrFAqNvuXqH\/unNJLJUVcyT3h40OCa8UiW0bKsQPCqw0sXzgNAkEbHJ976nhEE+fdAYR+CIE1p4d\/S16\/Fi+cpJ08cX\/LtsnpHcZz4afuvS8aMnJz2zLTJUbochr10\/HhyaurEqdMHDBpcb1Wcu4fnx7Pnfjx7riEH4kl09I9rVmdnZ4klEm9vHw9PL3cPDxcXFwdHR4nEpOktPURi8cof1m78aZ2nl\/foj8Y2rAjD4\/G++34Fj8trGPMxDHPh3NnIRw+XfLfM0tKqiaswDKNSKqVSaVFRYWFBQX5eXk5OdlZmpkIut3NwCAgICA4OmTFzlo2tbWM96PX6x48eXrp4ofruHYLzhqD5NsXM\/HHNiFFjjB5VyOU3b1wHgA6aZiWvIAjyr4XCPgRB3mDUmI9Wr1h++sTxBd8sahgqSSSSlQcPL5s4bsyLZNvGx\/z26OjlfNIy9dmFBfO2rfy+2\/ARI0aN8W\/Zst6UrkAgaN+hY\/sOHQGAZdmqqqr0tNSM9PSnT56cO3O6qLBALlcQBC4SiS0sLEzNzCQSE4lEwhcIhEIhl8vlcDgkSRIE0SY4JCY6qk+PrsOGjxw6fISzy2sjf\/XKsgBAVVXVuTOn\/\/xjv06ri+jcefPGDQDAMCzD0BRF6XQ6rUajVqsVCoVGo9bp9BiGCYUCC0srOzt7B0cHN3f3Lt26ubt7mJiaNj1JXV1dde\/u3ZvXr8Xduuknq2pP4nv1NMPhNhHJxlG0csacjxuJ+QDg0sULKpWKT9NtmpezjCDIvxYK+xAEeYPhI0Zu+GldWVnZpQvnhw43sjOKuYXF2qMnfvhqXsCNK+GkkQDmMUWbALQkcACYwSMnaxSP\/ty3cv8epY9fvyFD+w8Y6Obu0TBawjDM3Nw8LLxtWPirrQhZlqVpWqGQV1ZUVFVVyeVyhUKhVinVao1GrZbJqmmKphn6\/7V333FSVff\/xz\/n3pnZne2NIr13K6ISKYJGBA2KxhaTrwnBQiTGlhg1JvlpEk3sUWMDjS0GCwRjYmyogAWRJi0iS13a7rK9zcy95\/z+IComCqy5N+NyXs+Hf\/kY3hxmCy\/m7syIkeLiktPPONNxnWefnllZWdl\/wIBvTDy1sKhoz99C+\/6C+fNee+3VrHjW6DFjfnvr7Z7n+b6\/+9kSjlJuJBKJRDMyYrFYLJ6VlZOTk5kZj0aju9\/YbT\/vQM\/zVq1csWDevHlvvl61ZPHh2h8ZcS5yHTczKiKve3qNrwd\/wTvwLvT8rd\/+3k+u2ds7Ijz15BMiMrwlEeedeAHsFdkHYB+KiosnnHzKrGefmfHQg6dOOv1zcycnJ+c3Dzw0809PPvDb30xqqm+\/x8N+vsijSf\/azKiIJIxpFClSalTEHRVxazetm3\/776685eaWPv2PO\/HEscefcNjhR+z95\/mUUpFIpKCgsKA1T1k1xvxzzZoH7v+D9vXkCy7o2PEgY\/Sc2bPffeftUceNue76X+zzVZdbK5VKrl616r2F7y585511i97rUV871HUudZ32UfXJN14t4oiMjjhvep+Tfb7Ic1o6\/uS6n1w0dS+JuXzZ0qVLFovICY3Nwf4RABx4yD4A+\/b9Cy6c\/dyzKz5Y\/taC+SNGjvrc2yilzjnv2+PGT3j4vnu3\/\/nJUU0NA11HRF5N+YNcp4uj1vr6uhavRuRYV\/0sIxpRkq\/UKVH3lKhbv6V00QP33veHu0tz8voeM3z41449+pjh\/QcM+BJP6fiisw0cNGjgoEG7du269+67BgwYuHTJ4q+PO+nmW27d18sO7i+t9batWz9Yvmz5sqXLli4tX\/FBz5amIa5zjqu6OY7K\/PRHDH0RV2SL1lc3ezOyoke6zsPJlP7sq+ev8PXrPft877e3HjH0yL3\/vg\/ef5+I9E0k+nheIH8QAAcwsg\/Avg0ecvDoMWPemDv3rttvO3bEyL08+FRYVHTlddc3XnbFVSePG7htc8KYZ1L+rfGoiNyd8EZGnJ6O+n3SX+r7CRFHZHjEVSK5So2NumOjrvGaN857dfnrr9zs6y3ZuV0OPezQww4\/+JBDBg0Z0rlzF\/e\/fppqcXHxz395w3PPPH3pZVf85ztw7D9jTH19\/Yb1pWs\/\/PCf\/1zzz9Wrtq1eXVRT3c9R\/V1njKOKHSV7pp6RpJi4Ust8\/fuENz0r1kkpT+Q9T4+Oun0dtdrXQ1xHRJb7ekG3nsMvnHrHmWfts3pL1637x9\/\/JiITG5q+9J8FgD3IPgD75dLLrnjz9dcXvbfwjbmvjTn+hL3fODMzM6eyQkRmpfyxEadAKd+YUiOHipwUcR5O+jGR6Ul\/bMT5U1Oys6OOiThHuk6uUkqkp+P0dOS0qGv8lvL33\/nwvbde9810bSpzcov69u3Tt1\/vPn179uzZrXuPzl265OTk7P\/P2H3ijDPP2v8be55XU1OzbWtZ2ZYtW7Zs3rRx4\/r168s3rI9V7OxsTA9H9XTU8Y5T4igV\/\/dnDdcbk6PUfM+\/M+E3iZzgqimxyA4j\/\/T1INcZGVFv+np01B0dcd\/w\/N3Zt8LXP39uTtFnfwbxi9xx6+983++aTB2Z+MI3dgOAT5B9APbLEUOPPOHEca+89I+bfn3jiFGj\/\/OFUfa0q7Iyv76+Juq+5ul741ERcZU63FEzPZ2v5KmsaKk2m42Mjji7jLzh67kJ3xX\/8ph7XMRZr01XR+2uuQ6O6uC4o3Z\/o\/Jb6tZ8sHnV8jJt5mqzzZhyUYm8\/KyOHUs6HtS+ffvi4uKi4uLCwqK8\/Py8vLzs7Jzs7OzMeGZGRkY0GotGIspxdr\/c8cfPz00lEi2JlpbGxqbGxoaG+vq6urqa6uqamuqqXVWVlRWVlRW15eW6siK7pbmDUh2UOshRQx01UalCRzkZn\/\/9s9aYdzy92tertdls5L7MyO0Jf6Cjhrrqzymdl\/KHOmqepwe5zuiIe22L12zMUFdNT5rdF3\/jIk2NjfuTfUuXLP7bC38VkbPqG3h7dQD7g+wDsL+uvua6N+a+tvbDDx995OEpF160l1vW1dflOPJkyj8z6mYotcLXa33908zItc2p6Sl9YsR9KeV\/zVUdHecHGc6apuRxEadESY7I95pTFUayRG7IiBwacT7ydQ\/X+SQw85Qa4qohe17pTTYmNpXWbFxXZUyNMTVG1hrTYKRRpMmYFiMJMSkRT8Qz8snzXB0RV0lEJCYSExVXElcqSyRbSa5ShUp6KFWgVKGSbKUcJRL\/wid8eEZcJUpkTtLv7aohrlOpzW0JL65UpsglUafOmAZjLsuIdnBUJ8f\/dcKfHHWeS+kLM2Sw62SLvOfr0RG3v6NW+vpQ12kSlZObu8+Phe\/7v7z+Z8aYAS0JHuoDsJ\/IPgD7q0\/fvpOnXPjAfffecdstJ42f0KVr1y+6ZW5O7lrfrNNmakZMRN7z9Cqtz4hFLsqIXN7sNRjzuq9\/mREVkUptPtTmJ5nOQcq5sDnZQ6krY+4TKX96yv+tq37Y7N0Tj\/RxnTlJv6+rBrmOb8RRn3kWRoaSDkp12NczM\/7ttU2+9PM4Go15zdMpkRMiTlzkzKbkbZnRPq6zROtKo4a4Tk\/X+XNWbKM2Nya8U6KRHUaLyO5yPcZ1c8R3RWpEdr9oy9GuWujp0RF3dMR5M+Uf6jpN7drn5+fv8xiPP\/rI8mVLHWPOr+OhPgD7i28XAFrh0ssv79q1W2NDw9VXXaG1\/qKblbRrNy8z6\/zYv16VJF\/JGi0PJ7yHkv5QVy3zTYFSh0ccEXnH110d1cVx3vb8KiPXZkaGRpxvRp2N2qz1dVRJD0cZkadS\/i5jROTplHdaY\/KCpuR1zal7Et5iT6\/w9TZtSn2d2uvJ1Wf\/+1zm4zrcqU2VMfM8f2bSMyIbfX1JU\/LRhOeL\/KQ5dU\/SfyjpX9qcahEpVmq9NiLSU6kNu1\/tT6TYUQNd1SKyQesOSmUrtUZrEXGUDHRUmTFfc9WslG9EXKXKjIjIEa67XJtmY3JGjNrnTytu3LD+lptvEpETG5t68QReAPuN7APQCtnZOTffeptS6q0F8x964P4vupkxZtyEk5\/yZamnReSUqHucq2Z72ohcmRH5u+efFPnXO6y95emvuY4SedvXx7gqRykRSRrJElmjTT9HIkpVaLPLyADHEZFDXGdSxNlsZJcxa7X5u+e\/6+mnkv7FLd5qXzcZc3Zj8hfNKRF5w\/N\/1Jy6rjm1wdcicncitcrXIvL3lP+XpCciRuTG5tSPm1OXNCcnNyVnJr0zG5OlvhaROxPeiyl\/TkpPT+lSX+80Zq2RDcYs9\/Q6LXdnRp6KR12RPyf9Xo4q1UZEermq1P\/0IcUspXopWeHriFJHu+ofqX8lshJpMXJO1H3HN6c3Jl\/w9BBHiUhUyQBH3Z3wJpxz7t4\/BMlk4tJLftDY2NghlTqnvuHLfiQB2IjsA9A6x44Y+b3vTxGRW26+6b2F737ubSKRyG13\/v62l159\/fhxVyb8D3zzk8zonOzY7+PRJmNKtRkXcUWk3pjlvh4RcURkg5F+H7\/Z7gfa9HfVGt8MdBwRWaN1O0dKHCUig11nUszVxvwyM\/r7eLTCSDulqo0RkWptPvB1lUhCZKWvb0r4UZGtxlzb4rUYs8Q3lcaISKk2a7URESXiiTQbs17LEEd1c5QWqTMiInlKao2UKHGMvOvreiNRYyqNbNK6uyP9XafQUZOizgJf93L+9Whfb0dVGlNnPi2\/g11nhTYicmbUXaTNgwnvpZS\/SJuejurjOrdkRr4eca6Kud\/PiIhI0ph8pcoPPnTPtyT5XDf84ucfLF\/mGjOtpo635QDQKmQfgFb76XXXH3b4EZ6X+sGFF5Rt2fJFN+s\/YOB9D8249eXXFn9j0jRPXkr5CWO6u84jWbHdDfeepwuV6us6IuIZaRYjInXGvOHpka6zVpsBrhKRNb4Z4Hx64XOHNhGRYiUiUmlMiSPVxuSJqTbyvm\/iRgqVzEn5R7nq1nj07ni0SWSR9\/nXo\/9fPHpJRsQV86OM6PCIm6Ok1hgRyVOq3pgSpdo7stDTdcZ0c1SFNlElnwz1d5wd2hyk1AZtjEhHpTKUbNafhtgQV63yjRHp6zqXx9w5nr416fdx1PioKyKDXecHGZFxUXeDr\/+Q8KZl5RddMPX2u+7Z+xXeRx+Z8cRjj4rIeXX1\/VJc3gXQOmQfgFaLxWL3PTi9ffv2lZUV3\/u\/86qrq\/dy4379B9x+192PvbUwefEPL80puC\/htXz8\/Irerrok418\/\/zfIkVkp\/aek99Nmr1jJUFftMtLDcURkpa8H7\/FubzuNKVYqqpRnTI2REqWqjXRXqtqYxb7u5kihUh9pc4zriEiuUn0ctdl84cNimSIJI54YEckXqRcRkVwl9UZKlHRSapORzdp0d1StMe2U2m4kaYyI5CilRTopVWdMmdauUrmiKj6TfU6VMVu1FpFxUXdmVvSReOSOeDRLKRHZqc3MpHdJyjw7YszX\/\/DAS4uWXPOz63v36bOXe\/LvL\/z1hl\/8XERGNjadzFuxAWg9sg\/Al3FQp04PPfJYVlbWR2vXfvfb36qvr9v77TsedNBVV\/\/0HwsXj73n\/ieOGnFpUs9Kenmijo386+VYJsci3Rz1WEpHlPwqM+oqpZTM9fw3Uv5H2gzb4y1rd2jTwVEiUiuSNFKkpNaYXo76p9a1xpQoVaikzkjhx6HoiuzlYbEcpYxIsxERyVWq3hgRyRVVL1KiVJ0xBztqvm+6OkpEDlLKEZnraREp1doV6eaqgY66ocX7VUuqUqTdHnlaqNTt8Wh75XzyG3VxnO3aPJP0Lkv4dw05vOsvbvzToiUzHn18wsnf2OebAr\/8jxd\/NO0Hvu8PbklcWFu\/9xsDwOfiBVwAfEmHHnbYHx546ILJ312+bOl3zj3nj48\/WVBYuPdfEovFTvnGxFO+MXHHju1\/\/ctffjNntqxaeawjX4u4HRx1RzyaNCb28VXOE131eEqLyAkRp9ue2Wek4+4rvNpElUREkiLdHfXXlPma49SKKVBOlpJaIyJiRHYYM0o5rohnRES0mD3\/vZupRIlqEikQKVJSqY2IxJSkjClx1C4j4yLqPW0KlcpXqkHk9Ihzd9Jf5Oulvjkq4sSVujIz8ruEv1ab70Sdwe5n\/i198MfXr9dovdDTS5xIu2FHjxs\/fsZJEzoedND+39Wzn3v2x1dc7nmpPonkVdW1+yhEAPgCZB+AL++4scffc98D06ZetGzpkrPOOO3hx57o0uULX8xvTx07HnTBxVMvuHjq5k2bXn7pxXteeqlq8fuHG\/9I1xnkyu7yuzIzerqvm0QGfbaldn78M3+VxhSINBrJUNLRUVrkCNeZ5fmFSvo56hVPnxBxFvt6uzZDHPWaUh9pM1akTEu\/PR6TiyvlKtNojIjq46gnUvrglP+6p\/OVaqdUrTGHuo6kdJZIiZJKbc7PiBjlvevpYa76QUZERLo5zj3xf79yokU2+nq5Nks9vbN9hyNGjT5uzNhrR43OLyho1T2stb7nrjvvuO0WY0zfROKaqtqsL75gDQB7R\/YB+K+MGz\/hgekPT5t60doPPzztlAn3PfDQsKOP2f9f3q179ykXXjzlwotrqqsXLJi\/YN6bD761IKds88GOOth1+jkq6z+e4jA55mYrJSK5osZGnBaRPo4qVEoZOdxVM1KmUKkzo+6VLd4ZTakWkbERp4frHOvqB1L6JS\/ZIPLt6Kdv9OGKREXt\/kG5r0fdv3n6pqSfKfL\/MiL5SkZFnHaOmhZ1B7tOD0cVO8oRmRyLTP68B9yajPlImzW+XqXNzsKifsOOPmb48F8eO6Jvv\/6O82V+oqa2pubHV1z28kv\/EJHDm1t+VFPLU3cB\/DfIPgD\/rbEnfP3Jmc9eOPn8ioqKc88+86qfXH3hxVMdx933r9xDQWHh7uu\/xpitZWULF77z\/nvv\/XHJ4uS6j3prv6\/r9HZUD0dlK9X74wf\/Dok4h0QcEbkzHhORv2RH40r9NjPa1XFiSm7PjMz3dMePnzl7eiwSV\/4mbQ531aGRTyNMifwsw+3uKBHJVuq+rNg2rUvUv3LzusyoiJwacz++7aeMSJU2G7XZoPU6bTa6kXiffkMOO+zwI4aeO2xYr169v1zqfWL+vDevvuqKbVu3KmMmNDSdV9\/QujsUAP5DpHr27DB2U+XlYcwiVLEuXQonTQp81onFQvo0yx0zJtLKS2YHpMKJE3Vq729R8WUkNm3a\/w9cD5HHLr38x9MfXLlp482\/\/tUbc+fefMttPXr2\/BK\/r1KqS9euXbp2PeObZ4mYhobGNatWrly54q2Vqx5es7p+Q2lJU1MXR3VxVCelOjrSTqkMpURkd6j1\/zgKB7jOgD2uDjsiJ0c\/P5yOjnz6\/yMi3f4j13wjdcbsNGaHNtuM2arNVlFNRUUd+vTt13\/AwEGDJwwe3K\/\/gHg8\/iX+vP+porz85t\/8atazzxhjsrW+oLp2eNrfddd1w\/jmICL18+Z5u3aFsdy2VP\/tb25WVuCz2UcdFevcOfBZ7JZ18MEZe332\/ZcT69QplL80lSo87bTI2tNPD34abVPuiBG5I0YEPutVVS0uLg58VkSGLFoUOfLIMJbblj4zZ4Yxu\/bUU6uff75Vv+SnIn\/Ozf5bTva777x90gljLr5k2kUX\/yD+X\/1lpnJycoYdfcwnF449z9u+bVtp6bqNGzZ8tGnj3M2bt5VtadqxPVpbW2h0oeMUiOQplaskR6lskbiSTJGYUjERV8T9+P18jYg24oukRJJiWow0izQZaRRTb6TOmFojNcZUG2nKjLvt2hV36ty5S5eu3bod0r3HN3r06Nmrd0FBwT7fRa21GurrH5kx\/YH7\/tDQUC8iB7e0XFRT3+6L3wTvf8bJyOg3a1YYy6tHjqxfsCCM5bal9NvfDmO2z8yZxWedFcYyRKTd5MkdL7ss8NmaF1\/8cMKEwGeV4xzl+1zkBRCYqMh36huHJpIP5uduF7nztlv\/\/OSTP7zssjPPPnefL1CynyKRSNdu3bp26yZjPv2fxpjm5ubKioqKivJdlZXV1dW1tTWVNbWbGhvq6+tbWlpaWloSiYTveb7vG62NGMdxHMd1I5FYLJaZmRnPjGdlZ+fk5OTm5XXKzxtcWFRUXFxSUlJS0i4vP991Q7++WlFe\/vijf3zs0UdqqqtFpMj3v1Vbf2xLghfZAhAgsg9AwAYlU7+rqHohJ+v5nOwdO7Zf99Or777rzvO\/N\/nsc88rKioK43dUSmVlZXXr3r1b9+5h7IcnmUwumPfms888\/erLLyWTSRHJ1vrkhsYJjU08ewNA4Mg+AMGLiZze0DSmqfkvOdlzs7J2bN\/+29\/8+s7bbxs37qTTTj\/j2JGjMjIy0n3GdKqsqHjn7bden\/va66+9+sl7nBT5\/okNTSc2NWfzEi0AwkH2AQhLoTbfq2s4raHxpaysV7Pi9S0tz8\/5y\/Nz\/pKXlzdy9HGjjxsz\/Gtf69K1W+A\/IfdVo7WuqtpVum7dP9esXvHBB8uWLCldX2o+\/ok915hDWhJjm5oPTySj6T0ogAMd2QcgXIXanNPQeHpD4+LMjPnxzBXZWXV1dX\/76\/N\/++vzItKhQ4eDDzl00OAh\/fr379W7T7du3bJzctpQCBpjPM9raGioq6utqa6pra2pqa6uqqqq2rWroqJ8544d27Zt27a1rK7u39+8LkvrwS2JYYnk4S2JPB7eA\/A\/QfYB+F+IiQxvSQxvScS\/eeb6k0564\/W5b7+1oHznzp07d+585eVXX3l5982UUvkFBR07dCxp3764uLiwsCgvPy8vLy8rKzs3NzeetVt2PB7Pzc2Nx+PZ2dmRaPS\/fIW8fWpubt68adPmTRvLyrbs2L6jvHxnZWVldVVVTU11XW1dY2OD7\/vm317W7z9Ejenoed2TXu9Uqn8y1cPzeB0+AP9jZB+A\/6m8WMZpp59x2ulnaK03bdq4dPHilSs+WLN6dWnpul2Vlb7v11RX11RXyz\/X7H3HGKOUciOReDxeUFBQUlLSvkPHzp07d+\/eo0\/ffgMGDSouLv7SjxpqrT\/6aO27b7+9dPH7K1eu2Lhhg+d5e\/8ljjFKJMOYHG2ytZ\/v6zyti31drHU73+\/g+SW+z3vpAkgvsg9AejiO07Nnr549e53+zTNFRGtdX19ftmXz9u3bd+7YUVFeXlVVVVW1q6Ghvq62rrGxsaG+vrm5ubm5OZlM6I9\/MM73vIb6+ob6+rItW\/YcV0p1795j+LHHnnDiuJEjR8X27xkkxpgli9+fM3vWKy+\/tH3bts8MGpOtdTvPL9a60PcLtM7VJkfrHG1yjI5rk611pjFREV5yBcBXFtkH4CvBcZz8\/Pz8\/IMHDzl4LzfTWnuel0i0NDY2NTU21NXV1dbW1tbUVFZWbt++bdvWsk0bN6xbV9rS3Lxx44aNGzc89eQTRUVF3zzr7MlTLux40EFfNJtIJJ575uk\/zpi+du2Hn\/zPnr16DT1yWPGs2Z22b+\/sk+CcPAAAE8NJREFU+dnGkHQA2jSyD0Bb4jhOLBaLxWK5uXlfdJtkMlm67qOF777zxutz33nrraqqqgfvv++xPz4y5aKLp136o8zMz7yFmtZ61rPP3H7r77Zt3SoiSqmhw4ad8o2Jx59wYtdu3URk2fMvJFL7uMILAG0C2QfgQBOLxQYOGjxw0ODvTp5SXV393DNPPzL9oa1by+65686XXvz7vQ881K9f\/923XL++9Oorr1j03kIRyYzHzzr73O9Ontyrd\/BvsgkAXwVcsgBwICssLJxy4UWvzVtw9bXXZcbjH61de8bEU959520Rmf3cs6eM+\/qi9xYqpc4+91tvLHjnhl\/\/huYDcADj0T4AB77MzMypl\/xwzNgTLvz+9zZv2jj5\/O+cfPI3nnn6zyLSo2fPW++468hhR6X7jAAQOh7tA2CLAQMHPvuXOb16925qbNzdfONPPuWvL75M8wGwBNkHwCLt23d49ImnioqKReSCi6fee\/+Dubm56T4UAPyPcJEXgF26dut2212\/X7pk8RVX\/STdZwGA\/ymyD4B1xow9fszY49N9CgD4X+MiLwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArRJysrHSfoTUcRzc1Bb5qmpsD39xNNzeHceC2RTc3h\/Vp5oTy7xYnFgvjwE4s1rY+GYzvhzKbSrWt+8HJyAjj88Ekk8bzAp8NT0gfNRWNhnL3plImlQp8FtiTSSZDaZJEIvDNTyhjTHjrgdt+++2br7wy3adA60SKiobu2pXuU6Rf\/bx5q0ePTvcp0GqHlZZm9OoV+OyGqVPL778\/8NnCSZP6zZoV+KxualqUnR34rIgMmj8\/d8SIwGe33nhj2c9\/Hvhsm9Nn5szis84KfLZixoz1U6YEPotQKcc5yve5yAsAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArRNJ9gK+EjF69ej\/6aBjLaydN8iorw1gOQ\/4JJ3T+xS8Cn9VNTatHjgx8NjztL7ig5P\/+L\/DZrEMPHTR\/fuCzIrLm+ONNMhn4bNebbsodMSLw2apZs3bccUfgs7EuXfo89VTgsyIS7dQpjNmDrrqq5LzzAp9tXrUqjC83FY2G9Nlb\/sADW665JvDZvLFjQzpw27Lrqad23n134LPZRx7Ztu7e0u98J7FxY7pPsb9yjjmm2y23BL+rlJB9u7lZWWH89SYiTiwWxmxIIiUlYdwPXlVV\/YIFgc+Gp2D8+DBm3fz8kD7NlOOYEGbjgwaFceCm5csD3xQRJzMzpLs3JJm9e2f27h34rFdREcaXmxPaN8kt11wTxoHzxoxpW58PIdl5991h3L2Z\/fu3rbvXycpK9xFaIVJYGN7dy0VeAAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArBDZeuON6T5DK9S\/\/XYYs6mKipDuB7++PozZkDSvWhXS\/dD5+uvDmA1J7ogRYcwmNm2qfOyxMJYP+vGPw5htWrasafnywGcb3nsv8E18InPAgDC+3FQ0GvhmqOrnz29bf7uFpGn16lBmly5tW3dv0Te\/Kcak+xT7K7Nv3\/DG1bvhbQMiIhIpKhq6a1e6T5F+9fPmrR49OozlYc3NTmZm4LNrTz21+vnnA58NSWafPod+9FG6T4FWWz1yZP2CBek+BQ5wh6xaFR80KN2n+ErgIi8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWiOQcfXS6z4ADnJuXF9Jy86pVfkNDSOOBS5aVhfTlppxQ\/v2W2a9fGAdO7dyZ2Lgx8FmdSDQsXBj4rIhkHXaYk5ER+Gxi48bUzp2Bz0aKijL79g18VrRuWLQo+FmRWNeuYXyaJbduTZaVBT7r5uTEBw8OfLbNSZWXJzZsSPcpWqFpxQq\/vj7w2Yzu3aMdOwY+GypljEn3GYAvaeWwYY3vv5\/uU+yv3FGjBr35ZrpPkX47771347Rp6T5FKxxWWprRq1fgsxumTi2\/\/\/7AZwsnTeo3a1bgs7qpaVF2duCzIjJo\/vzcESMCn916441lP\/954LM5Rx89+N13A59tcypmzFg\/ZUq6T5F+3e+4o+Nll6X7FK3DRV4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYIfJ+YWG6z4ADXKSw8LD168NYHjh3rvh+4LNbf\/Wr7bfdFvgsdms\/ZUrJeeel+xSt4OblpfsIOPAt69HDq60NfLb3ww8XTpoU+GxIYp07H7JyZRjLK485puXDD8NYDkPtq69+dOaZgc8qxxm6a1fEr6kJfBrYk3LCelDZzc0NY1ZlZIQxi91URobLPQx8lldbG8ZfxzqVCnwzREq5BQWhDLtuGLMhMalUGJ8Mu\/8u5iIvAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAVoiEtNvp2muzDj00pHGEpOGtt3b8\/vfpPkUrbLn22kRpaeCz8cGD+8ycGfisV1m57uyzA58Vkd5PPKGi0cBnt99yS+P77wc+mz9uXLvJkwOfTe3YselHPwp8VkS63313tH37wGfbT5mSN2ZM4LOpbdtC+TRz3TC+KEQkPmBAGLNtTu+HH9apVOCzucOHB74ZHq+qKqRvksmysjBmKx59tOGddwKfjXbsGMaXm1JKwsu+vNGj8088MaRxhEVraVPZV\/vKK2F0Sddf\/7r4rLMCn62fN2\/jJZcEPisivR59NIzsq1+woPr55wOfjbRrF0b2+Q0Nu55+OvBZEel6000SQvZlDx2aPXRo4LPVs2dvuvzywGedrKw+f\/pT4LP4ROGkSek+QvrppqaQvopD0rRsWdOyZYHPFowf3\/2uuwKf3Y2LvAAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFghku4DtE7TypWNCxem+xTplztqVGbfvuk+xQGr8f33K2bMCHy2ee3awDd3q\/zjH1U0GvhsZr9+7b7\/\/cBn3YKCMO7eVHl54Juhqn\/77ZY1awKf9aqqwvioObFY4Ju71bzwQmrnzsBnG5csCXxTRFLl5WF89rY59QsWhDHrZGcXn3NOGMttSyScb5KiVLvJk9tY9tW+\/PLmK69M9ynSr9cjj5B94amaPbtq9ux0n6IVNkydGsZsvzlzCidODHx25733rp8yJfDZNqfy8cfL778\/8NnCSZP6zZoV+Gx4tv32tyE1RBgSGzbw2RueSGFhr+nT032K9Kt58cUPJ0wIfFY5TrvJk7nICwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBUi6T4A8OVFO3SIdemS7lMcsHRjY7KsLPBZ43lt66OWqqhQsVjgs7qxMfDNtijavn0b+nwwyWSqvDyM5VjnzqJUGMttSLRDhzC+57Q5uqEhjC8K5bpC9qFN6\/\/CC+k+woFs7amnrvvWtwKf7XDJJYdv2RL4bHiW9e6dWL8+3ac4YPV97rl0H6EVGhYuXHXMMWEsH7JypVtQEMZyG5IsK1vatWu6T5F+BePHh\/dNkou8AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsEIk3QcAvnJ23HVX+YMPpvsU6ZfcsiWM2V1\/+lPd66+HsRySXtOnRzt0CHx26w037Jo5M\/DZkOjm5pVHHhnGcu\/HH88+4ogwlsOQdcghh6xaFcbymq9\/XTc1hbEchqLTT+9y442Bz0Y7dAjp7l07cWJLaWkYy2Gonz\/\/g8GDg991nENWrCD7gH+XKi9vXr063ac4YHnV1V51dbpP0QoZ3btn9OoV+KxbWBj4ZoiMCemLog21jog48Xh80KAwllvWrfNrasJYDkNy+PAwZlU0GtLdqzIywpgNid\/QEMaXm3Ic4SIvAACAJcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAVoik+wCtk3fccd3vuCPdp0i\/nKOOSvcRvhK23357csuWwGcb3n478E0Ryezdu8O0aWEsb\/7xj43nBT7b7vvfzxoyJPDZ+gULqp57LvDZSElJ5+uuC3xWRCLFxWHMti0qGg3pe29Gr15hzNa+\/HLNiy+GsRwS3dwcxmzJ+ednH3ZY4LN+Q8Omyy8PfDY8qR07wpgtPO20vNGjw1gOhVLS5rIv+4gjso84It2nwFfFrqeeanz\/\/XSfYn9FO3fueNllYSxvueaaMLKvcOLEwokTA59V0Wgo2VdQENLdCxFR0WjbunsbFi7cceed6T5F+hVMmFB81lmBz1bMmFF2\/fWBz7Y5eaNHt62vC+EiLwAAgCXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFaIhLTbsGiR8f2QxhGSpmXL0n2Er4TMfv0ye\/cOfDY+ZEjgm7vln3iiSaUCn02WldW8+GLgs82rVwe+2RZlDR5cMH584LOxTp3C+Kgp180\/8cTAZ8OT2adPGHdveGpfecV4XrpPkWZOZmbemDHpPkUr6ObmML7cou3aZR95ZOCzu4WVfWU\/+1lIy0DY2p1\/fqdrr033KVqh35w5YcyuPfXU6uefD2MZItJh2rQO06YFPls9e\/aHEyYEPutkZQ1rbAx8NjzF555bfO656T5FK7xfWOjX1KT7FGkWKSnp\/\/e\/p\/sUrbDp8svD+HIrGD8+vPuBi7wAAABWIPsAAACsQPYBAABYgewDAACwAtkHAABgBbIPAADACmQfAACAFcg+AAAAK5B9AAAAViD7AAAArED2AQAAWIHsAwAAsALZBwAAYAWyDwAAwApkHwAAgBXIPgAAACuQfQAAAFYg+wAAAKxA9gEAAFiB7AMAALAC2QcAAGAFsg8AAMAKZB8AAIAVyD4AAAArkH0AAABWIPsAAACsQPYBAABYIaIcyg8hC+1zTDlOKJ\/ASgW\/2RaFdPeGpA0dNVRKhfFRU64b+Cb2FNJ3MxXSdzM+zXYL534I9e8gZYwJbx0AAABfEf8f5BI9uUyEKeIAAAAASUVORK5CYII=","margin-top":"0","margin-left":"0","width":"100"}},"template_sertifikat":"arsipbkpsdmbacirita/sertifikat/_SERTIKAT9MARET2026.png"}', true);
            // dd($data);
            $this->bacirita->regeneratePreviewSertifikat($data, "");

            // $inputFile = '_SERTIKAT9MARET2026.png';
            // $outputFile = '_SERTIKAT9MARET2026_preview.pdf';

            // $randomString = generateRandomString(30, 1, 't_file_ds'); 
            // $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
            // // dd($contentQr);
    		// $res['qr'] = generateQr($contentQr);

            // $data['result'] = [
            //     'url_template' => $inputFile,
            //     'nomor_surat' => [
            //         'content' => "*contoh_nomor_surat*",
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'font-size' => "2rem",
            //     ],
            //     'nama_lengkap' => [
            //         'content' => "*contoh_nama_pegawai*",
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'font-size' => "5rem",
            //     ],
            //     'nama_lengkap' => [
            //         'content' => "*contoh_nip*",
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'font-size' => "5rem",
            //     ],
            //     'jabatan' => [
            //         'content' => "*contoh_jabatan*",
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'font-size' => "3rem",
            //     ],
            //     'unit_kerja' => [
            //         'content' => "*contoh_unit_kerja*",
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'font-size' => "3rem",
            //     ],
            //     'qr' => [
            //         'src' => $res['qr'],
            //         'margin-top' => "0",
            //         'margin-left' => "0",
            //         'width' => 50,
            //     ],
            // ];
            
            // $html = $this->load->view('bacirita/V_TemplateSertifikatBkpsdmBacirita', $data, true);
            // // dd($html);
            // $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
            // $this->mpdf->AddPage(
            //     'L', // L - landscape, P - portrait
            //     '',
            //     '',
            //     '',
            //     '',
            //     0, // margin_left
            //     0, // margin right
            //     0, // margin top
            //     0, // margin bottom
            //     0, // margin header
            //     12
            // ); 

            // $this->mpdf->WriteHTML($html);
            // foreach($data['result'] as $k => $v){
            //     if($k != "url_template"){
            //         $this->mpdf->setX($v['margin-left']);
            //         $this->mpdf->setY($v['margin-top']);
            //         if($k != "qr"){
            //             $this->mpdf->writeHtml("<p style='
            //                 font-family: Tahoma;
            //                 text-align: center;
            //                 font-size: ".$v['font-size'].";
            //             '>".$v['content']."</p>");
            //         } else {
            //             $this->mpdf->writeHtml(
            //                 "<p style='text-align: center;'><img style='
            //                     width: ".$v['width']."px;
            //                 ' src='".$v['src']."' /></p>"
            //             );
            //         }
            //     }
            // }
            // $this->mpdf->showImageErrors = true;
            // $this->mpdf->Output($outputFile, 'I');

            // $this->db->insert('t_file_ds', [
            //     'url' => $outputFile,
            //     'random_string' => $randomString,
            //     'flag_bkpsdm_bacirita' => 1,
            //     'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
            // ]);

            // Output a success message (optional)
            echo "<iframe src='".$outputFile."' style='width: 100vw;'></iframe>";
            // echo "Text replaced and new PDF saved to $outputFile";
        }
	}
?>