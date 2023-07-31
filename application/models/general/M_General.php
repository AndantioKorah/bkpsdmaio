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

        public function authenticate($username, $password)
        {
            $this->db->select('*, a.nama as nama_user')
                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                        ->where('a.username', $username)
                        ->where('a.password', $password)
                        ->where('a.flag_active', 1);
            $result = $this->db->get()->result_array();
            if(!$result){
                $this->session->set_flashdata('message', 'Kombinasi Username dan Password tidak ditemukan');
                return null;
            } else {
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
                            ->where('nipbaru_ws', $nip)
                            ->get()->row_array();
        }

        public function getUserForSetting($id){
            return $this->db->select('*, a.id as id_m_user')
                            ->from('m_user a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id', 'left')
                            ->join('db_pegawai.pegawai d', 'a.username = d.nipbaru_ws')
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
            dd($data);
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
            ->get()->row_array();
            return $query['id_peg'];
        }

        public function getListPegawaiGajiBerkalaByYear($data){
            $result = null;
            $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.tmtgjberkala')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->order_by('a.tmtgjberkala');

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

            if($query){
                foreach($query as $q){
                    $diff = countDiffDateLengkap($data['tahun'], $q['tmtgjberkala'], ['tahun']);
                    $angka = explode(" ",$diff);
                    if($diff >= 2){
                        $result[] = $q;
                    }
                }
            }
            
            return $result;
        }

        public function getListPegawaiNaikPangkatByYear($data){
            $result = null;
            $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.tmtpangkat')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
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

            if($query){
                foreach($query as $q){
                    $diff = countDiffDateLengkap($data['tahun'], $q['tmtpangkat'], ['tahun']);
                    $angka = explode(" ",$diff);
                    if($diff >= 4){
                        $result[] = $q;
                    }
                }
            }
            
            return $result;
        }

        public function getListPegawaiPensiunByYear($data){
            // dd($data);
            $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
                    d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                    ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                    ->order_by('c.eselon');

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

            $result = null;
            if($query){
                foreach($query as $d){
                    $temp = null;
                    if($d['tgllahir'] != null){
                    $tgl_lahir = explode("-", $d['tgllahir']);
                    if(floatval($data['tahun']) - $tgl_lahir[0] >= 58){ //pejabat berumum lebih dari 58 tahun pada saat $data['tahun']
                        $id_pangkat_ahli_madya = [41, 42, 43];
                        $id_pangkat_ahli_utama = [44, 45];
                        if(floatval($data['tahun']) - $tgl_lahir[0] >= 60){ //jika berumur 60 tahun
                            if($d['eselon'] == 'II A' || $d['eselon'] == 'II B'){ // pejabat pimpinan tinggi
                                $temp = $d;
                            } else if(in_array($d['id_pangkat'], $id_pangkat_ahli_madya)){ //fungsional ahli madya
                                $temp = $d;
                            } else if((stringStartWith('Guru', $d['nama_jabatan'])) && (stringStartWith('Dokter', $d['nama_jabatan']))){ //bukan guru atau dokter
                                $temp = $d;
                            }
                        } else if((floatval($data['tahun']) - $tgl_lahir[0] >= 65) &&
                            (in_array($d['id_pangkat'], $id_pangkat_ahli_madya))){ //umur 65 dan pejabat fungsional ahli utama
                                $temp = $d;
                        } else if($d['eselon'] != 'II A' && $d['eselon'] != 'II B' &&
                            (!stringStartWith('Guru', $d['nama_jabatan']) &&
                            !stringStartWith('Dokter', $d['nama_jabatan']))){ //umur 58, bukan guru dan bukan dokter
                                $temp = $d;
                        }
                        $umur = floatval($data['tahun']) - $tgl_lahir[0];
                        if($temp){
                            $temp['umur'] = floatval($data['tahun']) - $tgl_lahir[0];
                            $result[] = $temp;
                        }
                    }
                }
            }
            }
            return $result;
        }

        public function getDataChartDashboardAdmin(){
            $result['total'] = null;
            $result['pangkat'] = null;
            $result['eselon'] = null;
            $result['agama'] = null;
            $result['pendidikan'] = null;
            $result['jenis_kelamin']['laki']['nama'] = 'Laki-laki';
            $result['jenis_kelamin']['laki']['jumlah'] = 0;
            $result['jenis_kelamin']['perempuan']['nama'] = 'Perempuan';
            $result['jenis_kelamin']['perempuan']['jumlah'] = 0;
            $result['statuspeg'] = null;

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

            $temp_statuspeg = $this->db->select('*')
                                ->from('db_pegawai.statuspeg')
                                ->get()->result_array();
            foreach($temp_statuspeg as $sp){
                $result['statuspeg'][$sp['id_statuspeg']] = $sp;
                $result['statuspeg'][$sp['id_statuspeg']]['nama'] = $sp['nm_statuspeg'];
                $result['statuspeg'][$sp['id_statuspeg']]['jumlah'] = 0;
            }

            $pegawai = $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.pendidikan, a.jk, a.statuspeg, a.agama')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->get()->result_array();

            $result['total'] = count($pegawai);

            foreach($pegawai as $peg){
                // $result['pangkat'][$peg['id_pangkat']]['jumlah']++;

                if(substr($peg['nipbaru'], 9, 6) == '202321'){
                    // dd(substr($peg['id_pangkat'], 0, 1));\
                    // if($peg['id_pangkat'] == '59') {
                    //     $result['golongan'][6]['nama'] = 'Golongan IX';
                    //     $result['golongan'][6]['jumlah'] = 0;
                    // }
                    // if($peg['id_pangkat'] == '60') {
                    //     $result['golongan'][6]['nama'] = 'Golongan X';
                    //     $result['golongan'][6]['jumlah'] = 0;
                    // }
                   
                }
                
                $result['golongan'][substr($peg['id_pangkat'], 0, 1)]['jumlah']++;
                // $gol1 = [11, 12, 13, 14];
                // $gol2 = [21, 22, 23, 24];
                // $gol3 = [31, 32, 33, 34];
                // $gol4 = [41, 42, 43, 44, 45];
                if(!$peg['eselon']){
                    $result['eselon']['Non Eselon']['jumlah']++;
                } else {
                    $result['eselon'][$peg['eselon']]['jumlah']++;
                }
                if($peg['pendidikan']){
                    $result['pendidikan'][$peg['pendidikan']]['jumlah']++;
                }

                if($peg['agama'] != null){
                    $result['agama'][$peg['agama']]['jumlah']++;
                }
                
                if($peg['jk'] == 'Laki-Laki'){
                    $result['jenis_kelamin']['laki']['jumlah']++;
                } else {
                    $result['jenis_kelamin']['perempuan']['jumlah']++;
                }

                if($peg['statuspeg'] != null){
                    $result['statuspeg'][$peg['statuspeg']]['jumlah']++;
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

	}
?>