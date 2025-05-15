<?php
	class M_User extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function getUnitKerjaKecamatanDiknas(){
            return $this->db->select('id_unitkerjamaster as id_unitkerja, concat("Sekolah ", nm_unitkerjamaster) as nm_unitkerja')
                                ->from('db_pegawai.unitkerjamaster')
                                ->where('nm_unitkerjamaster LIKE', 'Kecamatan%')
                                ->order_by('nm_unitkerjamaster', 'asc')
                                ->get()->result_array();
        }

        public function getAllSkpd(){
            return $this->db->select('id_unitkerja, nm_unitkerja')
                            ->from('db_pegawai.unitkerja')
                            ->order_by('nm_unitkerja', 'asc')
                            ->get()->result_array();
        }

        public function getAllSkpd2(){
            return $this->db->select('id_unitkerja, nm_unitkerja')
                            ->from('db_pegawai.unitkerja as a')
                            ->join('db_pegawai.unitkerjamaster b', 'a.id_unitkerjamaster = b.id_unitkerjamaster')
                            ->order_by('a.nm_unitkerja', 'asc')
                            ->where_not_in('b.id_unitkerjamaster', ['8000000','8010000'] )
                            ->get()->result_array();
        }

        public function getAllUsers(){
            return $this->db->select('a.*, a.nama as nama_user, b.nama_sub_bidang')
                            ->from('m_user a')
                            ->join('m_sub_bidang b', 'a.id_m_sub_bidang = b.id', 'left')
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama')
                            ->get()->result_array();
        }

        public function getAllUsersBySkpd($id_unitkerja){
            return $this->db->select('a.*, a.nama as nama_user, b.nama_bidang, c.nama_sub_bidang')
                            ->from('m_user a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id', 'left')
                            ->join('db_pegawai.pegawai c', 'a.username = c.nipbaru_ws')
                            ->join('m_sub_bidang c', 'a.id_m_sub_bidang = c.id', 'left')
                            ->where('c.skpd', $id_unitkerja)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->order_by('a.nama')
                            ->get()->result_array();
        }

        public function createUser($data){
            if($data['password'] != $data['konfirmasi_password']){
                return ['message' => 'Password dan Konfirmasi Password harus sama'];
            }
            if(strlen($data['password']) < 6){
                return ['message' => 'Panjang Password harus lebih dari 6 karakter'];
            }
            $exist = $this->db->select('username')
                                ->from('m_user')
                                ->where('username', $data['username'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if($exist){
                return ['message' => 'Username sudah digunakan'];
            }
            unset($data['konfirmasi_password']);
            $data['password'] = $this->general_library->encrypt($data['username'], $data['password']);
            $this->db->insert('m_user', $data);
            return ['message' => '0'];
        }

        public function searchPegawai($data){
            $result = null;

            if($data['search_param'] != ''){
                $this->db->select('b.gelar1, b.nama, b.gelar2, a.id, a.username, c.nm_unitkerja, b.fotopeg, b.id_m_status_pegawai,
                                b.statuspeg, d.nama_status_pegawai, e.nm_statuspeg, f.nama_jabatan')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja','left')
                                ->join('m_status_pegawai d', 'b.id_m_status_pegawai = d.id','left')
                                ->join('db_pegawai.statuspeg e', 'b.statuspeg = e.id_statuspeg','left')
                                ->join('db_pegawai.jabatan f', 'b.jabatan = f.id_jabatanpeg')
                                ->like('a.nama', $data['search_param'])
                                ->where('a.flag_active', 1)
                                ->order_by('b.id_m_status_pegawai')
                                ->group_by('a.id')
                                ->limit(5);
                                
                if($this->general_library->isKasubagKepegawaianDiknas()){
                    $this->db->where('(c.id_unitkerja = "3010000" OR c.id_unitkerjamaster IN ('.implode(", ", LIST_UNIT_KERJA_MASTER_SEKOLAH).'))');
                }

                $nama = $this->db->get()->result_array();

                $this->db->select('b.gelar1, b.nama, b.gelar2, a.id, a.username, c.nm_unitkerja, b.fotopeg, b.id_m_status_pegawai,
                                b.statuspeg, d.nama_status_pegawai, e.nm_statuspeg, f.nama_jabatan')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja','left')
                                ->join('m_status_pegawai d', 'b.id_m_status_pegawai = d.id','left')
                                ->join('db_pegawai.statuspeg e', 'b.statuspeg = e.id_statuspeg','left')
                                ->join('db_pegawai.jabatan f', 'b.jabatan = f.id_jabatanpeg')
                                ->like('a.username', $data['search_param'])
                                ->where('a.flag_active', 1)
                                ->order_by('b.id_m_status_pegawai')
                                ->group_by('a.id')
                                ->limit(5);

                if($this->general_library->isKasubagKepegawaianDiknas()){
                    $this->db->where('(c.id_unitkerja = "3010000" OR c.id_unitkerjamaster IN ('.implode(", ", LIST_UNIT_KERJA_MASTER_SEKOLAH).'))');
                }

                $nip = $this->db->get()->result_array();

                foreach($nama as $nm){
                    $result[] = $nm;
                }

                foreach($nip as $np){
                    $result[] = $np;
                }

            }

            return $result;
        }

        public function searchSkpd($data){
            $result = null;

            if($data['search_param'] != ''){
                $result = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->like('nm_unitkerja', $data['search_param'])
                                ->order_by('nm_unitkerja', 'asc')
                                ->limit(5)
                                ->get()->result_array();
            }

            return $result;
        }

        public function deleteUser($id_m_user){
            $this->db->where('id', $id_m_user)
                ->update('m_user', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
        }

        public function getUserRole($id_m_user){
            return $this->db->select('a.*, b.nama as nama_role, b.keterangan, b.role_name as role')
                            ->from('m_user_role a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id_m_user', $id_m_user)
                            ->where('a.flag_active', 1)
                            ->order_by('a.is_default', 'desc')
                            ->order_by('b.nama', 'asc')
                            ->get()->result_array();
        }

        public function addRoleForUser($data){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            $exist = $this->db->select('*')
                            ->from('m_user_role')
                            ->where('id_m_user', $data['id_m_user'])
                            ->where('id_m_role', $data['id_m_role'])
                            ->where('flag_active', 1)
                            ->get()->row_array();

            $default_role = $this->db->select('*')
                                ->from('m_user_role')
                                ->where('id_m_user', $data['id_m_user'])
                                ->where('is_default', 1)
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if(!$exist){
                $data['created_by'] = $this->general_library->getId();
                if(!$default_role){
                    $data['is_default'] = 1;
                }
                $this->db->insert('m_user_role', $data);
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'User sudah memiliki Role tersebut';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function requestSendOtp(){
            $res['code'] = 0;
            $res['message'] = "";

            if(FLAG_RESET_PASSWORD_USE_OTP == 0){
                $res['code'] = 1;
                $res['message'] = "";
                return $res;
            }

            $this->db->trans_begin();

            $user = $this->db->select('a.kode_otp, a.date_otp, b.*, a.id')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->where('a.id', $this->general_library->getId())
                                ->where('a.flag_active', 1)
                                ->get()->row_array();
            $diff = strtotime($user['date_otp']) - strtotime(date('Y-m-d H:i:s'));
            $diffMin = $diff/60;
            if($diffMin > 0){
                $res['code'] = 1;
                $res['message'] = "Kode OTP yang lama masih berlaku sampai ".formatDateNamaBulanWT($user['date_otp']).". Request Kode OTP hanya bisa dilakukan setelah Kode OTP yang lama sudah tidak berlaku.";
            } else {
                $randomString = generateRandomNumber(6);
                $res['otp'] = $randomString;
                $res['date_otp'] = date('Y-m-d H:i:s', strtotime(OTP_RESET_PASSWORD_TIME));
                $this->db->where('id', $user['id'])
                            ->update('m_user', [
                                'kode_otp' => $randomString,
                                'date_otp' => $res['date_otp'],
                                'flag_valid_otp' => 1
                            ]);
                $this->db->insert('t_cron_wa', [
                    'type' => 'text',
                    'sendTo' => convertPhoneNumber($user['handphone']),
                    'message' => "*[OTP RESET PASSWORD]*\nSelamat ".greeting()." ".getNamaPegawaiFull($user)."\nBerikut adalah kode OTP reset password Anda:\n\n"."*".$res['otp']."* berlaku sampai *".formatDateNamaBulanWT($res['date_otp'])."*\n\nKarena alasan keamanan, mohon agar kode OTP ini tidak diberikan kepada orang lain maupun pegawai BKPSDM. Terima kasih.".FOOTER_MESSAGE_CUTI
                ]);
            }

            if($this->db->trans_status() == FALSE || $res['code'] == 1){
                $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = $res['message'] ? $res['message'] : 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

        public function sendOtpResetPassword(){
            $res['otp'] = null;
            $res['date_otp'] = null;
            $res['message'] = null;

            if(FLAG_RESET_PASSWORD_USE_OTP == 0){
                return $res;
            }

            if(FLAG_RESET_PASSWORD_USE_OTP == 1){
                $this->db->trans_begin();
                $user = $this->db->select('a.kode_otp, a.date_otp, b.*, a.id, a.flag_valid_otp')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->where('a.id', $this->general_library->getId())
                                ->where('a.flag_active', 1)
                                ->get()->row_array();
                if($user){
                    if($user['handphone']){
                        $randomString = (generateRandomNumber(6));
                        if($user['kode_otp'] == null){
                            $res['otp'] = $randomString;
                            $res['date_otp'] = date('Y-m-d H:i:s', strtotime(OTP_RESET_PASSWORD_TIME));
                            $this->db->where('id', $user['id'])
                                    ->update('m_user', [
                                        'kode_otp' => $randomString,
                                        'date_otp' => $res['date_otp'],
                                        'flag_valid_otp' => 1
                                    ]);
                            $this->db->insert('t_cron_wa', [
                                'type' => 'text',
                                'sendTo' => convertPhoneNumber($user['handphone']),
                                'message' => "*[OTP RESET PASSWORD]*\nSelamat ".greeting()." ".getNamaPegawaiFull($user)."\nBerikut adalah kode OTP reset password Anda:\n\n"."*".$res['otp']."* berlaku sampai *".formatDateNamaBulanWT($res['date_otp'])."*\n\nKarena alasan keamanan, mohon agar kode OTP ini tidak diberikan kepada orang lain maupun pegawai BKPSDM. Terima kasih.".FOOTER_MESSAGE_CUTI
                            ]);
                            $res['message'] = "Kode OTP sedang dikirimkan ke nomor Anda melalui WhatsApp. Mohon menunggu.";
                        } else {
                            if($user['flag_valid_otp'] == 0){
                                $res['otp'] = $user['kode_otp'];
                                $res['date_otp'] = $user['date_otp'];
                                $res['message'] = "Kode OTP sedang dikirimkan ke nomor Anda melalui WhatsApp. Mohon menunggu.";
                                // $diff = countDiffDateLengkap(date('Y-m-d H:i:s'), $user['date_otp'], ['menit', 'detik']);
                                $diff = strtotime($user['date_otp']) - strtotime(date('Y-m-d H:i:s'));
                                $diffMin = $diff/60;
                                // if($diffMin < 0){ // otp habis masa berlaku, kirim lagi kode
                                    $res['otp'] = $randomString;
                                    $res['date_otp'] = date('Y-m-d H:i:s', strtotime(OTP_RESET_PASSWORD_TIME));
                                    $this->db->where('id', $user['id'])
                                        ->update('m_user', [
                                            'kode_otp' => $randomString,
                                            'date_otp' => $res['date_otp'],
                                            'flag_valid_otp' => 1
                                        ]);

                                    $this->db->insert('t_cron_wa', [
                                        'type' => 'text',
                                        'sendTo' => convertPhoneNumber($user['handphone']),
                                        'message' => "*[OTP RESET PASSWORD]*\nSelamat ".greeting()." ".getNamaPegawaiFull($user).",\nberikut adalah kode OTP reset password Anda:\n\n"."*".$res['otp']."* berlaku sampai *".formatDateNamaBulanWT($res['date_otp'])."*\n\nKarena alasan keamanan, mohon agar kode OTP ini tidak diberikan kepada orang lain maupun pegawai BKPSDM. Terima kasih.".FOOTER_MESSAGE_CUTI
                                    ]);
                                // }
                            } else {
                                $diff = strtotime($user['date_otp']) - strtotime(date('Y-m-d H:i:s'));
                                if($diff < 0){ // jika sudah kadaluarsa, buat lagi
                                    $res['otp'] = $randomString;
                                    $res['date_otp'] = date('Y-m-d H:i:s', strtotime(OTP_RESET_PASSWORD_TIME));
                                    $this->db->where('id', $user['id'])
                                        ->update('m_user', [
                                            'kode_otp' => $randomString,
                                            'date_otp' => $res['date_otp'],
                                            'flag_valid_otp' => 1
                                        ]);
                                    $this->db->insert('t_cron_wa', [
                                        'type' => 'text',
                                        'sendTo' => convertPhoneNumber($user['handphone']),
                                        'message' => "*[OTP RESET PASSWORD]*\nSelamat ".greeting()." ".getNamaPegawaiFull($user).",\nberikut adalah kode OTP reset password Anda:\n\n"."*".$res['otp']."* berlaku sampai *".formatDateNamaBulanWT($res['date_otp'])."*\n\nKarena alasan keamanan, mohon agar kode OTP ini tidak diberikan kepada orang lain maupun pegawai BKPSDM. Terima kasih.".FOOTER_MESSAGE_CUTI
                                    ]);
                                    $res['message'] = "Kode OTP sedang dikirimkan ke nomor Anda melalui WhatsApp. Mohon menunggu.";
                                } else {
                                    $res['message'] = "Kode OTP Anda sudah dikirimkan melalui WhatsApp. Jika belum ada, silahkan menunggu atau klik tombol Resend OTP.";
                                }
                            }
                        }
                    } else {
                        $this->session->set_userdata('apps_error', 'Nomor Handphone belum diinput, silahkan hubungi Admin untuk input Nomor Handphone agar proses Reset Password dapat dilanjutkan.');
                        redirect('logout');
                    }
                } else {
                    $this->session->set_userdata('apps_error', 'Terjadi Kesalahan. Silahkan Login kembali.');
                    redirect('logout');
                }

                if($this->db->trans_status() == FALSE || $res['otp'] == null){
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }

            return $res;
        }

        public function changePassword($data){
            if($data['password_baru'] != $data['konfirmasi_password']){
                return ['message' => 'Password Baru dan Konfirmasi Password Baru tidak sama'];
            }
            $password_lama = $this->general_library->encrypt($this->general_library->getUserName(), $data['password_lama']);
            $user = $this->db->select('*, a.nama as nama_user, a.kode_otp')
                                ->from('m_user a')
                                ->where('a.username', $this->general_library->getUserName())
                                ->where('a.password', $password_lama)
                                ->get()->result_array();
            if(!$user){
                return ['message' => 'Password Lama salah'];                
            } else {
                if(strlen($data['password_baru']) < 6){
                    return ['message' => 'Panjang Password harus lebih dari 6 karakter'];
                }

                if(FLAG_RESET_PASSWORD_USE_OTP == 1){
                    if($data['kode_otp'] != $user[0]['kode_otp']){
                        return ['message' => 'Kode OTP yang Anda masukkan salah.'];
                    } else {
                        $diff = strtotime($user[0]['date_otp']) - strtotime(date('Y-m-d H:i:s'));
                        $diffMin = $diff/60;
                        if($diffMin < 0){
                            return ['message' => 'Kode OTP yang Anda masukkan sudah tidak berlaku. Silahkan request untuk kirim kode OTP yang baru.'];
                        }
                    }
                }

                $password_baru = $this->general_library->encrypt($this->general_library->getUserName(), $data['password_baru']);
                $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['password' => $password_baru, 'flag_valid_otp' => 0]);
                if($this->db->affected_rows() > 0){
                    // $this->session->set_userdata(['user_logged_in' => null]);
                    // $user[0]['password'] = $password_baru;
                    // $this->session->set_userdata([
                    //     'user_logged_in' => $user,
                    //     'test' => 'tiokors'
                    // ]);
                    // $this->general_library->refreshUserLoggedInData();
                    return ['message' => 0];
                }
            }
            return ['message' => 0];
        }

        public function updateProfile($data){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', $data);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);

                $user = $this->db->select('*, a.nama as nama_user, c.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_user_role b', 'a.id = b.id_m_user')
                            ->join('m_role c', 'b.id_m_role = c.id')
                            ->where('a.id', $this->general_library->getId())
                            ->where('c.id', $this->general_library->getActiveRoleId())
                            ->limit(1)
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function getListJabatanByJenis($jenis = 'Struktural'){
            return $this->db->select('*')
                            ->from('db_pegawai.jabatan')
                            ->where('jenis_jabatan', $jenis)
                            ->order_by('nama_jabatan', 'asc')
                            ->get()->result_array();
        }

        public function deleteProfilePict(){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['profile_picture' => null]);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);

                $user = $this->db->select('*, a.nama as nama_user, c.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_user_role b', 'a.id = b.id_m_user')
                            ->join('m_role c', 'b.id_m_role = c.id')
                            ->where('a.id', $this->general_library->getId())
                            ->where('c.id', $this->general_library->getActiveRoleId())
                            ->limit(1)
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function updateProfilePicture($data){
            $this->db->where('id', $this->general_library->getId())
                        ->update('m_user', ['profile_picture' => $data['data']['file_name']]);

            if($this->db->affected_rows() > 0){
                $this->session->set_userdata(['user_logged_in' => null]);

                $user = $this->db->select('*, a.nama as nama_user, c.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_user_role b', 'a.id = b.id_m_user')
                            ->join('m_role c', 'b.id_m_role = c.id')
                            ->where('a.id', $this->general_library->getId())
                            ->where('c.id', $this->general_library->getActiveRoleId())
                            ->limit(1)
                            ->get()->result_array();

                $this->session->set_userdata([
                    'user_logged_in' => $user,
                    'test' => 'tiokors'
                ]);
                $this->general_library->refreshUserLoggedInData();
                return ['message' => '0'];
            }

            return ['message' => 'Terjadi Kesalahan'];
        }

        public function updateExpDateApp($data){
            $user = $this->db->select('*, a.nama as nama_user, b.nama as nama_role')
                            ->from('m_user a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.username', 'prog')
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
            if($user){
                if($data['username'] != $user['username']){
                    return ['message' => 'Bukan User untuk Programmer'];
                }
                $password = $this->general_library->encrypt($data['username'], $data['password']);
                if($user['password'] != $password){
                    return ['message' => 'Password yang dimasukkan salahsssss'];
                }
                $second_password = $this->general_library->encrypt($data['username'], $data['second_password']);
                if($second_password != SECOND_PASSWORD){
                    return ['message' => 'Password yang dimasukkan salah'];
                }
                $this->db->where('parameter_name', $data['param_name'])
                            ->update('m_parameter', ['parameter_value' => $data['parameter_value_new'].' 23:59:59', 'updated_by' => $this->general_library->getId()]);
                if($this->db->affected_rows() > 0){
                    $this->session->set_userdata(['params' => null]);
                    
                    $params = $this->db->select('*')
                                ->from('m_parameter')
                                ->where('flag_active', 1)
                                ->get()->result_array();
                    // dd($params);
                    $this->session->set_userdata([
                        'params' => $params
                    ]);
                    // dd($this->session);
                    // $this->general_library->refreshParams();
                    return ['message' => 0];
                } else {
                    return ['message' => 'Terjadi Kesalahan'];
                }
            }
            return ['message' => 'Terjadi Kesalahan'];
        }

        public function createMenu($data){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            $exist = null;
            if($data['url'] != '#' && $data['url'] != ''){
                $exist = $this->db->select('*')
                            ->from('m_menu')
                            ->where('url', $data['url'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
            }

            if(!$exist){
                $data['created_by'] = $this->general_library->getId();
                $this->db->insert('m_menu', $data);
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'URL sudah terpakai untuk Menu lain';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function loadAllMenu(){
            return $this->db->select('a.*, b.nama_menu as nama_menu_parent')
                            ->from('m_menu a')
                            ->join('m_menu b', 'a.id_m_menu_parent = b.id', 'left')
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama_menu')
                            ->group_by('a.id')
                            ->get()->result_array();
        }

        public function getListMenu($id_role, $role_name, $id_bidang = 0){
            $this->db->select('a.*')
                    ->from('m_menu a')
                    ->where('a.id_m_menu_parent', 0)
                    ->where('a.flag_active', 1)
                    // ->or_where('a.flag_general_menu = 1 AND a.id_m_menu_parent = 0')
                    ->order_by('a.created_date', 'desc')
                    ->group_by('a.id');
            if($role_name != 'programmer'){
                $this->db->join('m_menu_role b', 'b.id_m_menu = a.id')
                        ->where('b.id_m_role', $id_role)    
                        ->where('b.flag_active', 1);    
            }

            $list_menu = $this->db->get()->result_array();
            
            if($list_menu){
                $i = 0;
                foreach($list_menu as $l){
                    $list_menu[$i]['child'] = null;
                    $child = null;
                    $this->db->select('*, a.id as id_m_menu')
                        ->from('m_menu a')
                        ->where('a.id_m_menu_parent', $l['id'])
                        ->where('a.flag_active', 1)
                        // ->or_where('a.flag_general_menu = 1 AND a.id_m_menu_parent = "'.$l["id"].'"')
                        ->group_by('a.id')
                        ->order_by('a.created_date', 'asc');
                    if($role_name != 'programmer'){
                        $this->db->join('m_menu_role b', 'b.id_m_menu = a.id')
                                ->where('b.id_m_role', $id_role)    
                                ->where('b.flag_active', 1);    
                    }
                    $child = $this->db->get()->result_array();
                    if($role_name != 'programmer'){
                        $list_id_child = null;
                        if($child){
                            foreach($child as $c){
                                $list_id_child[] = $c['id_m_menu'];
                            }
                        }

                        $general_menu_child = $this->db->select('*, a.id as id_m_menu')
                                            ->from('m_menu a')
                                            ->join('m_menu_role b', 'b.id_m_menu = a.id')
                                            ->where('a.id_m_menu_parent', $l['id'])
                                            ->where('a.flag_active', 1)
                                            ->where('a.flag_general_menu = 1 AND a.id_m_menu_parent = "'.$l["id"].'"')
                                            ->where('b.id_m_role', $id_role)    
                                            ->where('b.flag_active', 1)
                                            ->where_not_in('a.id', $list_id_child)
                                            ->group_by('a.id')
                                            ->order_by('a.created_date', 'asc')
                                            ->get()->result_array();
                        if($general_menu_child){
                            $i = count($child);
                            foreach($general_menu_child as $gm){
                                $child[$i] = $gm;
                                $i++;
                            }
                        }
                    } 
                    $list_menu[$i]['child'] = $child;
                    $i++;
                }
                // dd(json_encode($list_menu));
            }
            $menu_pekin = null;
            if($id_bidang == ID_BIDANG_PEKIN){
                $menu_pekin = $this->getMenuPekin();
                if($menu_pekin){
                    $tmp_menu_pekin;
                    foreach($menu_pekin as $mp){
                        $tmp_menu_pekin[$mp['id_m_menu']] = $mp;
                    }

                    $flag_parent_found = 0;
                    if($list_menu){
                        $list_menu = $list_menu;
                        // $list_menu = [];
                        $i = 0;
                        foreach($list_menu as $t){
                            foreach($menu_pekin as $mp){
                                if($mp['id_m_menu_parent'] == $t['id']){
                                    $list_menu[$i]['child'][] = $mp;
                                    unset($tmp_menu_pekin[$mp['id_m_menu']]);
                                    if(!$tmp_menu_pekin){
                                        break;
                                    }
                                }
                            }
                            $i++;
                        }
                    }

                    if($tmp_menu_pekin){
                        $lp = [];
                        $temp = [];
                        foreach($tmp_menu_pekin as $tm){
                            $lp[] = $tm['id_m_menu_parent'];
                            $temp[$tm['id_m_menu_parent']][] = $tm;
                        }

                        $parent = $this->db->select('*, id as id_m_menu')
                                    ->from('m_menu')
                                    ->where_in('id', $lp)
                                    ->where('flag_active', 1)
                                    ->get()->result_array();
                        $tambahan_menu = [];
                        if($parent){
                            $i = count($list_menu);
                            foreach($parent as $p){
                                $list_menu[$i] = $p;
                                $list_menu[$i]['child'] = $temp[$p['id_m_menu']];
                                $i++;
                            }
                        }
                    }
                }
            }

            $menu_name = array_column($list_menu, 'nama_menu');
            
            array_multisort($menu_name, SORT_ASC, $list_menu);

            return $list_menu;
        }

        public function getMenuPekin(){
            $list_menu = [];
            $child = $this->db->select('*, id as id_m_menu')
                            ->from('m_menu')
                            ->where('flag_active', 1)
                            ->where_in('url', URL_MENU_PEKIN)
                            ->get()->result_array();
            return $child;
        }

        public function getMenuRole($id){
            return $this->db->select('a.*, b.nama as nama_role, b.keterangan, b.role_name as role')
                            ->from('m_menu_role a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id_m_menu', $id)
                            ->where('a.flag_active', 1)
                            ->order_by('b.nama')
                            ->group_by('b.id')
                            ->get()->result_array();
        }

        public function insertRoleForMenu($data){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            $exist = $this->db->select('*')
                            ->from('m_menu_role')
                            ->where('id_m_menu', $data['id_m_menu'])
                            ->where('id_m_role', $data['id_m_role'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
            if(!$exist){
                $data['created_by'] = $this->general_library->getId();
                $this->db->insert('m_menu_role', $data);
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Menu sudah memiliki Role tersebut';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getListRoleForUser($id){
            return $this->db->select('a.is_default, b.*')
                            ->from('m_user_role a')
                            ->join('m_role b', 'a.id_m_role = b.id')
                            ->where('a.id_m_user', $id)
                            ->where('a.flag_active', 1)
                            ->order_by('a.is_default', 'desc')
                            ->order_by('b.nama', 'asc')
                            ->get()->result_array();
        }

        public function setDefaultRoleForUser($id_user_role, $id_user){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            $this->db->where('id_m_user', $id_user)
                    ->update('m_user_role',
                    [
                        'is_default' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);
            
            $this->db->where('id', $id_user_role)
                    ->update('m_user_role',
                    [
                        'is_default' => 1,
                        'updated_by' => $this->general_library->getId()
                    ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function deleteRole($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            if($id == 5 || $id == $this->session->userdata('active_role_id')){
                $rs['code'] = 1;
                $rs['message'] = 'Untuk sementara, Role ini tidak dapat dihapus';
            } else {
                $this->db->where('id', $id)
                        ->update('m_role',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getListUrl($id_role){
            $this->db->select('a.url')
                    ->from('m_menu a')
                    ->join('m_menu_role b', 'b.id_m_menu = a.id')
                    ->where('b.id_m_role', $id_role)    
                    ->where('a.flag_active', 1)
                    ->where('b.flag_active', 1)    
                    ->order_by('a.nama_menu', 'asc')
                    ->group_by('a.id');
                    
            return $this->db->get()->result_array();
        }

        public function getListPegawaiByUnitKerja($id_unitkerja){
            return $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->where('skpd', $id_unitkerja)
                            ->order_by('nama', 'asc')
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();
        }

        public function getListPegawaiByUnitKerjaNew($id_unitkerja){
            return $this->db->select('a.*, b.nama_jabatan, c.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                            ->join('m_user c', 'a.nipbaru_ws = c.username')
                            ->where('a.skpd', $id_unitkerja)
                            ->where('a.id_m_status_pegawai', 1)
                            ->where('c.flag_active', 1)
                            ->order_by('b.eselon', 'asc')
                            ->order_by('a.nama', 'asc')
                            ->group_by('a.nipbaru_ws')
                            ->get()->result_array();
        }

        public function importPegawaiNewUser(){
            $data = $this->input->post();
            if(!$data['search_value']){
                return null;
            }
            return $this->db->select('*')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                            ->or_like('a.nipbaru_ws', $data['search_value'])
                            ->or_like('a.nama', $data['search_value'])
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();
        }

        public function importPegawaiByUnitKerja($unitkerja, $list_pegawai_export = null, $flag_import_new_db = 0){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            if($flag_import_new_db == 1){
                $list_pegawai = $list_pegawai_export;
                $this->session->set_userdata(['list_pegawai_export' => null]);
            } else {
                $list_pegawai = $this->db->select('*')
                                    ->from('db_pegawai.pegawai')
                                    ->where('id_m_status_pegawai', 1)
                                    ->where('skpd', $unitkerja)
                                    ->get()->result_array();
            }

            if($list_pegawai){
                $bulkuser = null;
                $list_id_pegawai = null;
                foreach($list_pegawai as $lp){
                    $exist = $this->db->select('*')
                            ->from('m_user')
                            ->where('username', $lp['nipbaru_ws'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
                    if($exist){
                        $list_id_pegawai[] = $lp['id_peg'];
                        // echo 'username '.$lp['nipbaru_ws'].' sudah terdaftar'.'<br>';
                    } else {
                        $user['username'] = $lp['nipbaru_ws'];
                        $user['nama'] = trim(getNamaPegawaiFull($lp));
                        $nip_baru = explode(" ", $lp['nipbaru']);
                        $password = $nip_baru[0];
                        $pass_split = str_split($password);
                        $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                        $user['password'] = $this->general_library->encrypt($user['username'], $new_password);
                        $bulkuser[] = $user;
                        $list_id_pegawai[] = $lp['id_peg'];
                        // echo 'masukkan '.$lp['nipbaru_ws'].' ke dalam list<br>';
                    }
                }
                // if($list_id_pegawai){
                //     $this->db->where_in('id_peg', $list_id_pegawai)
                //             ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
                // }
                if($bulkuser){
                    $this->db->insert_batch('m_user', $bulkuser);
                } else {
                    $rs['code'] = 2;
                    $rs['message'] = 'Import Selesai';
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function createUserImport($nip){
            $rs['code'] = 0;
            $rs['message'] = 'User berhasil ditambahkan';

            $this->db->trans_begin();

            $exist = $this->db->select('*')
                            ->from('m_user')
                            ->where('username', $nip)
                            ->where('flag_active', 1)
                            ->get()->row_array();
            $pegawai = $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->where('nipbaru_ws', $nip)
                            ->get()->row_array();
            if($exist){
                $rs['code'] = 1;
                $rs['message'] = 'User sudah terdaftar';
                // $this->db->where('nipbaru_ws', $nip)
                //         ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
            } else if(!$pegawai){
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $user['username'] = $pegawai['nipbaru_ws'];
                $user['nama'] = getNamaPegawaiFull($pegawai);
                $nip_baru = explode(" ", $pegawai['nipbaru']);
                $password = $nip_baru[0];
                $pass_split = str_split($password);
                $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                $user['password'] = $this->general_library->encrypt($user['username'], $new_password);
                $this->db->insert('m_user', $user);
                // $this->db->where('id_peg', $pegawai['id_peg'])
                //         ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function submitForgetPassword(){
            $res['code'] = 0;
            $res['message'] = "";
            $data = $this->input->post();

            $pegawai = $this->db->select('a.*, b.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_user b', 'a.nipbaru_ws = b.username')
                            ->where('a.nipbaru_ws', trim($data['form_nip']))
                            ->where('a.handphone', trim($data['form_no_hp']))
                            ->where('b.flag_active', 1)
                            ->get()->row_array();
            if($pegawai){
                if($pegawai['skpd'] == ID_UNITKERJA_BKPSDM){
                    $res['code'] = 1;
                    $res['message'] = "Reset Password untuk User dengan NIP berikut hanya dapat dilakukan oleh Admin";
                } else {
                    $this->resetPassword($pegawai['id_m_user']);
                }
            } else {
                $res['code'] = 1;
                $res['message'] = "Kombinasi NIP dan Nomor Handphone yang Anda masukkan tidak ditemukan. Jika Anda belum menginputkan Nomor Handphone Anda di Siladen, silahkan menghubungi Admin.";
            }

            return $res;
        }

        public function resetPassword($id){
            $user = $this->db->select('*')
                            ->from('m_user')
                            ->where('id', $id)
                            ->get()->row_array();
            $password = $user['username'];
            $pass_split = str_split($password);
            $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
            $new_password = $this->general_library->encrypt($user['username'], $new_password);
            $update['password'] = $new_password;
            $update['updated_by'] = $this->general_library->getId();
            $this->db->where('id', $id)
                            ->update('m_user', $update);
        }

        public function getListPegawaiSkpd($idskpd, $iduser){
            return $this->db->select('*, a.id as id_m_user, a.nama as nama_pegawai')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->where('b.skpd', $idskpd)
                            ->where('a.id !=', $iduser)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->order_by('b.nama', 'asc')
                            ->get()->result_array();
        }

        public function tambahVerifPegawai($data){
            $rs['code'] = 0;
            $rs['message'] = '';

            $exist = $this->db->select('*')
                            ->from('t_verif_tambahan')
                            ->where('id_m_user', $data['id_m_user'])
                            ->where('id_m_user_verif', $data['id_m_user_verif'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
            if($exist){
                $rs['code'] = 1;
                $rs['message'] = 'Pegawai sudah ditambahkan sebelumnya';
            } else {
                $this->db->insert('t_verif_tambahan',
                    [
                        'id_m_user' => $data['id_m_user'],
                        'id_m_user_verif' => $data['id_m_user_verif'],
                        'created_by' => $this->general_library->getId()
                    ]);
            }

            return $rs;
        }

        public function tambahVerifBidang($data){
            $rs['code'] = 0;
            $rs['message'] = '';

            $exist = $this->db->select('*')
                            ->from('t_verif_tambahan')
                            ->where('id_m_user', $data['id_m_user'])
                            ->where('id_m_sub_bidang', $data['id_m_sub_bidang'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
            if($exist){
                $rs['code'] = 1;
                $rs['message'] = 'Bidang sudah ditambahkan sebelumnya';
            } else {
                $this->db->insert('t_verif_tambahan',
                    [
                        'id_m_user' => $data['id_m_user'],
                        'id_m_sub_bidang' => $data['id_m_sub_bidang'],
                        'created_by' => $this->general_library->getId()
                    ]);
            }

            return $rs;
        }

        public function getVerifPegawai($id){
            return $this->db->select('*, a.id as id_t_verif_tambahan')
                            ->from('t_verif_tambahan a')
                            ->join('m_user b', 'a.id_m_user_verif = b.id')
                            ->join('m_sub_bidang c', 'b.id_m_sub_bidang = c.id', 'left')
                            ->where('a.id_m_user', $id)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function getVerifBidang($id){
            return $this->db->select('*, a.id as id_t_verif_tambahan')
                            ->from('t_verif_tambahan a')
                            ->join('m_sub_bidang b', 'a.id_m_sub_bidang = b.id')
                            ->where('a.id_m_user', $id)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function getSubBidangUser($id_m_user){
            return $this->db->select('*, a.id as id_m_user')
                            ->from('m_user a')
                            ->join('m_sub_bidang b', 'a.id_m_sub_bidang = b.id')
                            ->join('m_bidang c', 'b.id_m_bidang = c.id')
                            ->where('a.id', $id_m_user)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        }

        public function getBidangUser($id_m_user){
            return $this->db->select('a.*, b.*, a.id as id_m_user, c.nama_sub_bidang')
                            ->from('m_user a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id')
                            ->join('m_sub_bidang c', 'a.id_m_sub_bidang = c.id', 'left')
                            ->where('a.id', $id_m_user)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        }

        public function userChangePassword($data){
            $rs['code'] = 0;
            $rs['message'] = '';
            $user = $this->db->select('*')
                            ->from('m_user')
                            ->where('id', $data['id_m_user'])
                            ->get()->row_array();
            if($user){
                if($data['new_password'] != $data['confirm_new_password']){
                    $rs['code'] = 2;
                    $rs['message'] = 'Password Baru dan Konfirmasi Password Baru tidak sama !';    
                } else {
                    $new_password = $this->general_library->encrypt($user['username'], $data['new_password']);
                    $update['password'] = $new_password;
                    $update['updated_by'] = $this->general_library->getId();
                    $this->db->where('id', $data['id_m_user'])
                            ->update('m_user', $update);
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan ; Error Code : 1';
            }

            return $rs;
        }


        public function getAllPegawaiBySkpd($id_unitkerja){
            return $this->db->select('a.*, a.nama as nama_user, b.nm_unitkerja')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja', 'left')
                            ->where('a.skpd', $id_unitkerja)
                            ->where('id_m_status_pegawai', 1)
                            // ->where('a.flag_active', 1)
                            ->order_by('a.nama')
                            ->get()->result_array();
        }

        public function mutasiPegawaiSubmit($data){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();


            $nip = str_replace(' ', '', $data['nip']);

            $id_m_user = $this->db->select('id')
            ->from('m_user')
            ->where('username', $nip)
            ->where('flag_active', 1)
            ->get()->row_array();

            // dd($data['tmt_mutasi']);

    
            $update['skpd'] = $data['select_search_skpd_modal'];
            $dataInsert['id_pegawai'] = $data['id_peg'];
            $dataInsert['id_unit_kerja_asal'] = $data['skpd'];
            $dataInsert['id_unit_kerja_tujuan'] = $data['select_search_skpd_modal'];
            $dataInsert['tmt_mutasi'] = $data['tmt_mutasi'];
            $dataInsert['id_user_inputer'] = $this->general_library->getId();
            $dataInsert['created_by'] = $this->general_library->getId();
                    $this->db->where('id_peg', $data['id_peg'])
                            ->update('db_pegawai.pegawai', $update);

            $this->db->insert('t_riwayat_unit_kerja_pegawai', $dataInsert);


            $this->db->where('id_m_user', $id_m_user['id'])
                             ->update('m_user_role', ['flag_active' => 0]);

            $this->db->where('id', $id_m_user['id'])
                             ->update('m_user', ['id_m_sub_bidang' => null]);



            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }


        public function getListPegawaiSkpdMutasi($id_peg){
            return $this->db->select('a.nama as nama_pegawai, a.id_peg, a.skpd, a.nipbaru')
                            ->from('db_pegawai.pegawai a')
                            ->where('id_m_status_pegawai', 1)
                            // ->where('a.skpd', $idskpd)
                            ->where('a.id_peg ', $id_peg)
                            // ->where('a.flag_active', 1)
                            // ->order_by('b.nama', 'asc')
                            ->get()->result_array();
        }

        public function getRiwayatMutasiPegawai($id_peg){
            return $this->db->select('a.*, b.nama,
            (select nm_unitkerja from db_pegawai.unitkerja where unitkerja.id_unitkerja = a.id_unit_kerja_asal) as unit_kerja_asal,
            (select nm_unitkerja from db_pegawai.unitkerja where unitkerja.id_unitkerja = a.id_unit_kerja_tujuan) as unit_kerja_tujuan
            ')
                            ->from('t_riwayat_unit_kerja_pegawai a')
                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                            ->where('a.id_pegawai', $id_peg)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                              ->order_by('a.id', 'desc')
                            ->get()->result_array();
        }



        public function loadDataPegawaiFromNewDb(){
            return $this->db->select('a.*, c.nm_unitkerja')
                            ->from('db_pegawai_new.pegawai a')
                            ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja', 'left')
                            ->where('a.id_peg NOT IN (SELECT b.id_peg FROM db_pegawai.pegawai b)')
                            
                            ->get()->result_array();
        }

        public function loadUnregisteredPegawai(){
            return $this->db->query("SELECT
            `a`.*,
            `c`.`nm_unitkerja` 
            FROM
            `db_pegawai`.`pegawai` `a`
            LEFT JOIN `db_pegawai`.`unitkerja` `c` ON `a`.`skpd` = `c`.`id_unitkerja` 
            WHERE a.nipbaru_ws NOT IN (SELECT aa.username FROM m_user aa WHERE aa.flag_active = 1)
            GROUP BY a.id_peg")->result_array();
        }

        public function exportOne($id){
            $res['code'] = 0;
            $res['message'] = '';

            $pegawai = $this->db->select('*')
                                ->from('db_pegawai_new.pegawai')
                                ->where('id_peg', $id)
                                ->get()->result_array();
            if($pegawai){
                $pegawai[0]['nipbaru_ws'] = str_replace(' ', '', $pegawai[0]['nipbaru']);
                $this->db->insert('db_pegawai.pegawai', $pegawai[0]);
                $res = $this->importPegawaiByUnitKerja(0, $pegawai, 1);
            }
            return $res;
        }

        public function exportOneUnregisteredPegawai($id){
            $res['code'] = 0;
            $res['message'] = '';

            $pegawai = $this->db->select('*')
                                ->from('db_pegawai.pegawai')
                                ->where('id_peg', $id)
                                ->get()->result_array();
            if($pegawai){
                $pegawai[0]['nipbaru_ws'] = str_replace(' ', '', $pegawai[0]['nipbaru']);
                // $this->db->insert('db_pegawai.pegawai', $pegawai[0]);
                $res = $this->importPegawaiByUnitKerja(0, $pegawai, 1);
            }
            return $res;
        }


        public function exportAll(){
            $res['code'] = 0;
            $res['message'] = '';

            $pegawai = $this->loadDataPegawaiFromNewDb();
            $list_pegawai = null;
            if($pegawai){
                $i = 0;
                foreach($pegawai as $p){
                    $list_pegawai[$i] = $p;
                    $list_pegawai[$i]['nipbaru_ws'] = str_replace(' ', '', $p['nipbaru']);
                    unset($list_pegawai[$i]['nm_unitkerja']);
                    $i++;
                }
                $this->db->insert_batch('db_pegawai.pegawai', $list_pegawai);
                $res = $this->importPegawaiByUnitKerja(0, $list_pegawai, 1);
            }

            return $res;
        }

        public function exportAllUnregisteredPegawai(){
            $res['code'] = 0;
            $res['message'] = '';

            $this->db->trans_begin();

            $list_pegawai = $this->loadUnregisteredPegawai();
            if($list_pegawai){
                $bulkuser = null;
                $list_id_pegawai = null;
                foreach($list_pegawai as $lp){
                    $user = null;
                    $exist = $this->db->select('*')
                            ->from('m_user')
                            ->where('username', $lp['nipbaru_ws'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
                    if($exist){
                        $list_id_pegawai[] = $lp['id_peg'];
                        // echo 'username '.$lp['nipbaru_ws'].' sudah terdaftar'.'<br>';
                    } else {
                        $user['username'] = $lp['nipbaru_ws'];
                        $user['nama'] = trim(getNamaPegawaiFull($lp));
                        $nip_baru = explode(" ", $lp['nipbaru']);
                        $password = $nip_baru[0];
                        $pass_split = str_split($password);
                        $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                        $user['password'] = $this->general_library->encrypt($user['username'], $new_password);
                        // $bulkuser[] = $user;
                        $list_id_pegawai[] = $lp['id_peg'];
                        if($user){
                            $this->db->insert('m_user', $user);
                            $last_id = $this->db->insert_id();

                            $this->db->insert('m_user_role',[
                                'id_m_user' => $last_id,
                                'id_m_role' => 10,
                                'is_default' => 1
                            ]);
                        }
                        // echo 'masukkan '.$lp['nipbaru_ws'].' ke dalam list<br>';
                    }
                }
                // if($list_id_pegawai){
                //     $this->db->where_in('id_peg', $list_id_pegawai)
                //             ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
                // }
                // if($bulkuser){
                //     $this->db->insert_batch('m_user', $bulkuser);
                // } else {
                //     $rs['code'] = 2;
                //     $rs['message'] = 'Import Selesai';
                // }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

        public function runQuery(){
            $data = $this->db->query("SELECT a.nama_bidang, a.id
            FROM m_bidang a
            JOIN db_pegawai.unitkerja b ON a.id_unitkerja = b.id_unitkerja
            WHERE b.nm_unitkerja LIKE 'Kec%'
            AND a.nama_bidang != 'Sekretariat'")->result_array();

            $list_id = [];
            foreach($data as $d){
                $list_id[] = $d['id'];
            }
            // dd($list_id);
            // $this->db->where_in('id', $list_id)
            //         ->update('m_bidang', ['nama_bidang' => 'Sekretariat']);
        }

        public function importPegawaiByUnitKerjaMaster($unitkerjamaster){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();

            // if($flag_import_new_db == 1){
            //     $list_pegawai = $list_pegawai_export;
            //     $this->session->set_userdata(['list_pegawai_export' => null]);
            // } else {
                $list_pegawai = $this->db->select('a.*')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                                    ->where('b.id_unitkerjamaster', $unitkerjamaster)
                                    ->get()->result_array();
            // }

            if($list_pegawai){
                $bulkuser = null;
                $list_id_pegawai = null;
                echo "jumlah pegawai yang ada ". count($list_pegawai).'<br>';
                foreach($list_pegawai as $lp){
                    $exist = $this->db->select('*')
                            ->from('m_user')
                            ->where('username', $lp['nipbaru_ws'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
                    if($exist){
                        $list_id_pegawai[] = $lp['id_peg'];
                        echo $lp['nama'].' sudah terdaftar'.'<br>';
                    } else {
                        $user['username'] = $lp['nipbaru_ws'];
                        $user['nama'] = trim(getNamaPegawaiFull($lp));
                        $nip_baru = explode(" ", $lp['nipbaru']);
                        $password = $nip_baru[0];
                        $pass_split = str_split($password);
                        $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                        $user['password'] = $this->general_library->encrypt($user['username'], $new_password);
                        $bulkuser[] = $user;
                        $list_id_pegawai[] = $lp['id_peg'];
                        echo "building data .... ".$user['nama'].'<br>';
                        // echo 'masukkan '.$lp['nipbaru_ws'].' ke dalam list<br>';
                    }
                }
                // if($list_id_pegawai){
                //     $this->db->where_in('id_peg', $list_id_pegawai)
                //             ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
                // }
                if($bulkuser){
                    $this->db->insert_batch('m_user', $bulkuser);
                    echo "jumlah pegawai yang didaftarkan ". count($bulkuser).'<br>';
                } else {
                    $rs['code'] = 2;
                    $rs['message'] = 'Import Selesai';
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function setRolesBulk($id_unitkerja){
            $list_pegawai = $this->db->select('a.nama, c.nama_jabatan, b.id as id_m_user,
                                    c.kepalaskpd, c.eselon, d.id as id_role, a.nipbaru_ws as nip')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('m_user b', 'a.nipbaru_ws = b.username')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                    ->join('m_user_role d', 'b.id = d.id_m_user', 'left')
                                    ->where('b.flag_active', 1)
                                    ->where('id_m_status_pegawai', 1)
                                    ->group_by('a.nipbaru_ws')
                                    ->get()->result_array();
            $bulkroles = null;
            $i = 0;
            $temp_list_pegawai = null;
            foreach($list_pegawai as $lp){
                if(!$lp['id_role'] && 
                    !stringStartWith('Pegawai Tidak Terlacak', $lp['nama_jabatan']) &&
                    !stringStartWith('Pegawai Lewat BUP', $lp['nama_jabatan'])){
                    echo "building data ... ".$lp['nama'].'<br>';    
                    
                    if(stringStartWith('Kepala Bidang', $lp['nama_jabatan']) ||
                        stringStartWith('Kepala Bagian', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 11;
                        $bulkroles[$i]['is_default'] = 1;
                        if($lp['kepalaskpd'] == 1){
                            $bulkroles[$i]['id_m_role'] = 13;
                        }
                    } else if(stringStartWith('Kepala Sub', $lp['nama_jabatan']) || 
                        stringStartWith('Kepala Seksi', $lp['nama_jabatan']) ||
                        stringStartWith('Kasubag', $lp['nama_jabatan']) ||
                        stringStartWith('Kepala Tata Usaha', $lp['nama_jabatan']) ||
                        stringStartWith('Kepala Unit Pelaksana', $lp['nama_jabatan']) ||
                        stringStartWith('Kepala UPTD', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 15;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Sekretaris', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['is_default'] = 1;
                        if(stringStartWith('Sekretaris DPRD', $lp['nama_jabatan'])){
                            $bulkroles[$i]['id_m_role'] = 13;
                        } else if(stringStartWith('Sekretaris Daerah', $lp['nama_jabatan'])){
                            $bulkroles[$i]['id_m_role'] = 18;
                        } else {
                            $bulkroles[$i]['id_m_role'] = 12;
                        }
                    } else if(stringStartWith('Lurah', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_role'] = 21;
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Camat', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_role'] = 22;
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Guru', $lp['nama_jabatan']) ||
                        stringStartWith('Pengawas TK/SD', $lp['nama_jabatan']) ||
                        stringStartWith('Penjaga Sekolah', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 20;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Kepala Sekolah', $lp['nama_jabatan']) ||
                        stringStartWith('Kepala Taman Kanak-Kanak', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 19;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Asisten', $lp['nama_jabatan']) && $lp['eselon'] == 'II B'){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 23;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Staf Ahli', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 24;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if(stringStartWith('Pelaksana', $lp['nama_jabatan']) ||
                        stringStartWith('Dokter', $lp['nama_jabatan'])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 10;
                        $bulkroles[$i]['is_default'] = 1;
                    } else if($lp['kepalaskpd'] == 1 
                        && ($lp['eselon'] == 'II B' || stringStartWith('Kepala Puskesmas', $lp['nama_jabatan']))){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 13;
                        $bulkroles[$i]['is_default'] = 1;
                    }

                    if(!isset($bulkroles[$i])){
                        $bulkroles[$i]['id_m_user'] = $lp['id_m_user'];
                        $bulkroles[$i]['id_m_role'] = 10;
                        $bulkroles[$i]['is_default'] = 1;
                        $temp_list_pegawai[] = $lp;
                    }
                    $i++;
                }
            }

            if($bulkroles){
                $this->db->insert_batch('m_user_role', $bulkroles);
                echo "done insert bulk ...";
            } else {
                echo "nothing to insert";
            }
        }

        public function getUnitKerjaByPegawai($id_pegawai,$flag_profil){
            $this->db->select('c.*')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
            ->where('a.id', $id_pegawai);

            if($flag_profil == 1){
                $this->db->where('id_m_status_pegawai', 1);
            }
            return $this->db->get()->row_array();
            $this->db->get()->row_array();

        }

        public function getNipPegawai($id_pegawai){
            $this->db->select('a.nipbaru_ws')
            ->from('db_pegawai.pegawai a')
            ->where('a.id_peg', $id_pegawai);
            return $this->db->get()->result_array();
           

        }

        public function getIDPegawaiByNip($nip){
            $this->db->select('a.id_peg')
            ->from('db_pegawai.pegawai a')
            ->where('a.nipbaru_ws', $nip);
            return $this->db->get()->row_array();
           

        }

        public function getEselonPegawai($id_pegawai){
            $this->db->select('b.eselon')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
            ->where('a.id_peg', $id_pegawai);
            return $this->db->get()->row_array();
           

        }

        public function getListHariLibur($tanggal_awal, $tanggal_akhir){
            $new_tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
            $new_tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

            $explode_awal = explode("-", $new_tanggal_awal);
            $explode_akhir = explode("-", $new_tanggal_akhir);
            
            return $this->db->select('*')
                        ->from('t_hari_libur')
                        // ->where('bulan >=', floatval($explode_awal[1]))
                        // ->where('bulan <=', floatval($explode_akhir[1]))
                        // ->where('tahun >=', floatval($explode_awal[0]))
                        // ->where('tahun <=', floatval($explode_akhir[0]))
                        ->where('tanggal >= ', $new_tanggal_awal)
                        ->where('tanggal <= ', $new_tanggal_akhir)
                        ->where('flag_active', 1)
                        ->where('flag_hari_libur_nasional', 1)
                        ->order_by('tanggal', 'asc')
                        ->get()->result_array();
        }

        public function countHariKerjaBulanan($bulan, $tahun){
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            // $bulan = floatval($bulan) < 10 ? '0'.$bulan : $bulan;
            $tanggal_awal = $tahun.'-'.$bulan.'-'.'01';
            $tanggal_akhir = $tahun.'-'.$bulan.'-'.$jumlah_hari;

            $list_hari_libur = $this->db->select('*')
                                        ->from('t_hari_libur')
                                        ->where('bulan', floatval($bulan))
                                        ->where('tahun', floatval($tahun))
                                        ->where('flag_active', 1)
                                        ->where('flag_hari_libur_nasional', 1)
                                        ->get()->result_array();
            $hari_libur = null;
            if($list_hari_libur){
                foreach($list_hari_libur as $lhl){
                    $hari_libur[$lhl['tanggal']] = $lhl;
                }
            }

            $list_hari = getDateBetweenDates($tanggal_awal, $tanggal_akhir);
            $list_hari_kerja = null;

            $jhk = 0;
            $hk = 0;
            foreach($list_hari as $lh){
                if(!isset($hari_libur[$lh]) && getNamaHari($lh) != 'Sabtu' && getNamaHari($lh) != 'Minggu'){
                    $list_hari_kerja[$lh] = $lh;
                    $jhk++;
                    if($lh <= date('Y-m-d')){
                        $hk++;
                    }
                }
            }
            return [$jhk, $hari_libur, $list_hari, $list_hari_kerja, $hk];
        }

        public function getTppPegawai($id_pegawai, $tpp, $pk, $bulan, $tahun, $unitkerja){
            $result = null;
            $result['pagu_tpp'] = $tpp;
            $result['pagu_pk'] = (floatval(TARGET_BOBOT_PRODUKTIVITAS_KERJA) / 100) * floatval($tpp['pagu_tpp']); 
            $result['pagu_dk'] = (floatval(TARGET_BOBOT_DISIPLIN_KERJA) / 100) * floatval($tpp['pagu_tpp']); 
            list($result['jhk'], $result['hari_libur'], $result['list_hari'], $result['list_hari_kerja'], $result['hari_kerja']) = $this->countHariKerjaBulanan($bulan, $tahun); //get jumlah hari kerja bulanan

            $params['id_pegawai'] = $id_pegawai;
            $params['bulan'] = $bulan;
            $params['tahun'] = $tahun;
            $params['unitkerja'] = $unitkerja;
            $params['pk'] = $pk;
            $params['tpp'] = $tpp;
            $params['pagu_tpp'] = $result['pagu_tpp'];
            $params['pagu_pk'] = $result['pagu_pk'];
            $params['pagu_dk'] = $result['pagu_dk'];

            $result = $this->getAbsensiPegawai($params, 1);

            if($this->general_library->getId() == 16){
                // dd($result);
            }

            $result['capaian_dk_tanpa_pengurangan'] = $result['capaian_dk'];
            $result['capaian_dk'] = $result['capaian_dk'] - ((($result['pengurangan_dk'] / 100) * $result['pagu_dk']));
            if($result['capaian_dk'] < 0){
                $result['capaian_dk'] = 0;
            }
            $result['rupiah_pengurangan_dk'] = ((($result['pengurangan_dk'] / 100) * $result['pagu_dk']));
            $result['capaian_tpp'] = $result['capaian_dk'] + $result['capaian_pk'];
            if($result['pagu_tpp']['pagu_tpp'] == '0' || $result['pagu_tpp']['pagu_tpp'] == 0){
                $result['presentase_capaian_tpp'] = 0;    
                $result['presentase_pk'] = 0;
                $result['presentase_dk'] = 0;
            } else {
                $result['presentase_capaian_tpp'] = ($result['capaian_tpp'] / $result['pagu_tpp']['pagu_tpp']) * 100;
                $result['presentase_pk'] = ($result['capaian_pk'] / $result['pagu_pk']) * 100;
                $result['presentase_dk'] = ($result['capaian_dk'] / $result['pagu_dk']) * 100;
            }

            return $result;
        }

        public function getAbsensiPegawai($params, $flag_count_tpp = 0){
            $result = null;
            $id_pegawai = isset($params['id_pegawai']) ? $params['id_pegawai'] : null;
            $bulan = isset($params['bulan']) ? $params['bulan'] : date('m');
            $tahun = isset($params['tahun']) ? $params['tahun'] : date('Y');
            $unitkerja = isset($params['unitkerja']) ? $params['unitkerja'] : null;
            $pk = isset($params['pk']) ? $params['pk'] : null;
            $tpp = isset($params['tpp']) ? $params['tpp'] : null;
            $result['pagu_tpp'] = isset($params['pagu_tpp']) ? $params['pagu_tpp'] : null;
            $result['pagu_dk'] = isset($params['pagu_dk']) ? $params['pagu_dk'] : null;
            $result['pagu_pk'] = isset($params['pagu_pk']) ? $params['pagu_pk'] : null;
            
            if(!$id_pegawai){
                $id_pegawai = $this->general_library->getId();
            }
            if(!$bulan){
                $bulan = date('m');
            }
            if(!$tahun){
                $tahun = date('Y');
            }
            list($result['jhk'], $result['hari_libur'], $result['list_hari'], $result['list_hari_kerja'], $result['hari_kerja']) = $this->countHariKerjaBulanan($bulan, $tahun); //get jumlah hari kerja bulanan
            if(!$unitkerja){
                $unitkerja = $this->db->select('a.*')
                                        ->from('db_pegawai.unitkerja a')
                                        ->join('db_pegawai.pegawai b', 'a.id_unitkerja = b.skpd')
                                        ->join('m_user c', 'b.nipbaru_ws = c.username')
                                        ->where('c.id', $id_pegawai)
                                        ->get()->row_array();
            }
            if($flag_count_tpp == 1){
                $bobot_komponen_kinerja = 0;
                if($pk['komponen_kinerja']){
                    list($pk['komponen_kinerja']['capaian'], $pk['komponen_kinerja']['bobot']) = countNilaiKomponen($pk['komponen_kinerja']);
                    $bobot_komponen_kinerja = $pk['komponen_kinerja']['bobot'];
                }
                
                $bobot_skp = 0;
                if($pk['kinerja']){
                    $pk['nilai_skp'] = countNilaiSkp($pk['kinerja']);
                    $bobot_skp = $pk['nilai_skp']['bobot'];
                }
                $bobot_pk = floatval($bobot_komponen_kinerja) + floatval($bobot_skp); //bobot produktivitas kerja
                $result['capaian_pk'] = ($bobot_pk * $result['pagu_tpp']['pagu_tpp']) / 100;
                $result['capaian_komponen_kinerja'] = ($bobot_komponen_kinerja * $result['pagu_tpp']['pagu_tpp']) / 100;
                $result['capaian_skp'] = ($bobot_skp * $result['pagu_tpp']['pagu_tpp']) / 100;
                $result['capaian_dk'] = 0;
                $result['pagu_harian'] = $result['pagu_dk'] / $result['jhk'];
                $result['capaian_harian'] = $result['pagu_harian'] * $result['hari_kerja'];
            }

            //data absen
            $list_data_absen = $this->db->select('*')
                                    ->from('db_sip.absen a')
                                    ->where('a.user_id', $id_pegawai)
                                    ->where('MONTH(tgl)', $bulan)
                                    ->where('YEAR(tgl)', $tahun)
                                    ->order_by('tgl')
                                    ->get()->result_array(0);

            $data_absen = null;
            if($list_data_absen){
                foreach($list_data_absen as $lda){
                    $data_absen[$lda['tgl']] = $lda;
                }
            }
            $result['data_absen'] = $data_absen;

            //get jam kerja
            $jskpd = 1;
            if(in_array($unitkerja['id_unitkerja'], LIST_UNIT_KERJA_KHUSUS)){
                $jskpd = 2;
            } else if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){
                $jskpd = 4;
            }
            $jam_kerja = $this->db->select('*')
                    ->from('t_jam_kerja')
                    ->where('id_m_jenis_skpd', $jskpd)
                    ->where('flag_event', 0)
                    ->where('flag_active', 1)
                    ->get()->row_array();
            $result['jam_kerja'] = $jam_kerja;

            //cek jika ada jam kerja event
            $jam_kerja_event = $this->db->select('*')
                    ->from('t_jam_kerja')
                    ->where('id_m_jenis_skpd', $jskpd)
                    // ->where('(MONTH(berlaku_dari) = '.$bulan.' OR
                    //         MONTH(berlaku_sampai) = '.$bulan.')')
                    // ->where('(YEAR(berlaku_dari) = '.$tahun.' OR
                    //         YEAR(berlaku_sampai) = '.$tahun.')')
                    ->where_in('flag_event', [1,2])
                    ->where('flag_active', 1)
                    ->get()->result_array();

            $result['jam_kerja_event'] = null;
            $result['list_jam_kerja_event'] = null;;
            if($jam_kerja_event){
                // $result['jam_kerja_event'][0] = $jam_kerja_event[0];
                // $result['list_jam_kerja_event'] = $jam_kerja_event;
                foreach($jam_kerja_event as $jke){
                    foreach($result['list_hari'] as $rlh){
                        if((($rlh) >= ($jke['berlaku_dari'])) &&
                            ($rlh) <= ($jke['berlaku_sampai'])){  //cek jika tanggal masuk dalam jam kerja event
                                // $jam_kerja_event[] = $jke;
                                $result['jam_kerja_event'][$rlh] = $jke;
                                if(!isset($result['list_jam_kerja_event'][$jke['id']])){
                                    $result['list_jam_kerja_event'][$jke['id']] = $jke;
                                }
                        }
                    }
                    // $list_hari_kerja_event = getDateBetweenDates($jke['berlaku_dari'], $jke['berlaku_sampai']);
                    // foreach($list_hari_kerja_event as $lhke){
                    //     $result['jam_kerja_event'][$lhke] = $jke;
                    // }
                }
            }

            //get dokumen pendukung
            $result['dokpen'] = null;
            $list_dokpen = $this->db->select('a.*, b.keterangan as kode_dokpen, b.nama_jenis_disiplin_kerja')
                                ->from('t_dokumen_pendukung a')
                                ->join('m_jenis_disiplin_kerja b', 'a.id_m_jenis_disiplin_kerja = b.id')
                                ->where('a.id_m_user', $id_pegawai)
                                ->where('a.status', 2)
                                ->where('a.bulan', $bulan)
                                ->where('a.tahun', $tahun)
                                ->where('a.flag_active', 1)
                                ->get()->result_array();

            $result['list_dokpen'] = null;

            if($list_dokpen){
                foreach($list_dokpen as $ld){
                    $tanggal_dok = $ld['tanggal'] < 10 ? '0'.$ld['tanggal'] : $ld['tanggal'];
                    $bulan_dok = $ld['bulan'] < 10 ? '0'.$ld['bulan'] : $ld['bulan'];
                    $date_dok = $ld['tahun'].'-'.$bulan_dok.'-'.$tanggal_dok;

                    $result['dokpen'][$date_dok] = $ld;
                    $result['dokpen'][$date_dok]['keterangan'] = $ld['nama_jenis_disiplin_kerja'];
                    $result['rincian_pengurangan_dk'][$ld['kode_dokpen']] = 0;

                    if(isset($result['dokpen'][$date_dok])){
                        $result['list_dokpen'][] = $ld;    
                    }
                }
            }

            if($this->general_library->getId() == 16){
                // dd($result['rincian_pengurangan_dk']);
                // dd(json_encode($result['dokpen']));
            }

            $result['hadir'] = 0;
            $result['pengurangan_dk'] = 0;
            $result['rincian_pengurangan_dk']['TK'] = 0;
            $result['rincian_pengurangan_dk']['tmk1'] = 0;
            $result['rincian_pengurangan_dk']['tmk2'] = 0;
            $result['rincian_pengurangan_dk']['tmk3'] = 0;
            $result['rincian_pengurangan_dk']['pksw1'] = 0;
            $result['rincian_pengurangan_dk']['pksw2'] = 0;
            $result['rincian_pengurangan_dk']['pksw3'] = 0;
            foreach($result['list_hari'] as $tga){
                $keterangan = null;
                // echo $result['pengurangan_dk'].';'.$tga.'<br>';
                if($tga <= date('Y-m-d') && isset($result['list_hari_kerja'][$tga])){
                    if(isset($data_absen[$tga])){
                        // set waktu jam masuk dan jam pulang
                        $jam_masuk = $result['jam_kerja']['wfo_masuk'];
                        $jam_pulang = $result['jam_kerja']['wfo_pulang'];
                        if(getNamaHari($tga) == 'Jumat'){ //jika hari jumat, ambil jam kerja wfoj
                            $jam_masuk = $result['jam_kerja']['wfoj_masuk'];
                            $jam_pulang = $result['jam_kerja']['wfoj_pulang'];
                            if(isset($result['jam_kerja_event'][$tga])){ //jika ada event, ambil jam kerja event
                                $jam_masuk = $result['jam_kerja_event'][$tga]['wfoj_masuk'];
                                $jam_pulang = $result['jam_kerja_event'][$tga]['wfoj_pulang'];
                            }
                        } else if(isset($result['jam_kerja_event'][$tga])) { //jika ada event, ambil jam kerja event
                            $jam_masuk = $result['jam_kerja_event'][$tga]['wfo_masuk'];
                            $jam_pulang = $result['jam_kerja_event'][$tga]['wfo_pulang'];
                        }

                        if(isset($result['dokpen'][$tga]) && //cek jika ada data dokumen pendukung
                        !in_array($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'], ['20', '19'])){ // dan bukan tugas luar pagi atau sore
                            // echo("dokpen_before: ".$result['pengurangan_dk']);
                            if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 3){ //cek jika dokumen pendukung bukan Tidak Kerja
                                // tambah capaian disiplin kerja
                                $result['hadir']++;
                                if($flag_count_tpp == 1){
                                    $result['capaian_dk'] += $result['pagu_harian'];
                                }
                            }

                            // if($this->general_library->getId() == '1348'){
                            //     if($tga == '2024-09-09'){
                            //         dd($result['dokpen'][$tga]);
                            //     }
                            // }

                            // if(!in_array($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'], ['18', '19'])){ //cek jika dokumen pendukung bukan Tugas Luar Pagi atau Sore
                                $result['pengurangan_dk'] = floatval($result['pengurangan_dk']) + floatval($result['dokpen'][$tga]['pengurangan']);
                                $result['rincian_pengurangan_dk'][$result['dokpen'][$tga]['kode_dokpen']]++;
                                $keterangan[] = $result['dokpen'][$tga]['kode_dokpen'];
                            // }
                        } else {
                            if(($data_absen[$tga]['masuk'] == '00:00:00' || $data_absen[$tga]['masuk'] == null)){ //cek jika tidak ada data absen masuk
                                if(!isset($result['dokpen'][$tga])){ //tidak ada dokumen pendukung
                                    $result['pengurangan_dk'] += 10;
                                    $result['rincian_pengurangan_dk']['TK']++;
                                    
                                    // tambah capaian disiplin kerja
                                    if($flag_count_tpp == 1){
                                        $result['capaian_dk'] += $result['pagu_harian'];
                                    }
                                    $keterangan[] = "TK";
                                } else {
                                    if(isset($result['dokpen'][$tga])){ // cek jika ada dokpen
                                        if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == '19'){ // jika TLP
                                            if($data_absen[$tga]['pulang'] == '00:00:00' || $data_absen[$tga]['pulang'] == null){ //jika tidak ada absen pulang
                                                $result['pengurangan_dk'] += 3;
                                                $result['rincian_pengurangan_dk']['pksw3']++;
                                                $keterangan[] = "pksw3";
                                            } else { // kalo ada, cek keterlambatan
                                                $diff_pulang = strtotime($jam_pulang) - strtotime($data_absen[$tga]['pulang']);
                                                $ket_pulang = floatval($diff_pulang / 1800);
                                                if($ket_pulang <= 1 && $ket_pulang > 0){
                                                    $result['pengurangan_dk'] += 1;
                                                    $result['rincian_pengurangan_dk']['pksw1']++;
                                                    $keterangan[] = "pksw1";
                                                } else if($ket_pulang > 1 && $ket_pulang <= 2){
                                                    $result['pengurangan_dk'] += 2;
                                                    $result['rincian_pengurangan_dk']['pksw2']++;
                                                    $keterangan[] = "pksw2";
                                                } else if($ket_pulang > 2) {
                                                    $result['pengurangan_dk'] += 3;
                                                    $result['rincian_pengurangan_dk']['pksw3']++;
                                                    $keterangan[] = "pksw3";
                                                }
                                            }
                                        } if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == '20'){ // jika TLS
                                            if($data_absen[$tga]['masuk'] == '00:00:00' || $data_absen[$tga]['masuk'] == null){ //jika tidak ada absen masuk
                                                $result['pengurangan_dk'] += 3;
                                                $result['rincian_pengurangan_dk']['pksw3']++;
                                                $keterangan[] = "pksw3";
                                            } else { // kalo ada, cek keterlambatan
                                                $diff_masuk = strtotime($jam_masuk) - strtotime($data_absen[$tga]['masuk']);
                                                $ket_masuk = floatval($diff_masuk / 1800);
                                                if($ket_masuk <= 1 && $ket_masuk > 0){
                                                    $result['pengurangan_dk'] += 1;
                                                    $result['rincian_pengurangan_dk']['tmk1']++;
                                                    $keterangan[] = "tmk1";
                                                } else if($ket_masuk > 1 && $ket_masuk <= 2){
                                                    $result['pengurangan_dk'] += 2;
                                                    $result['rincian_pengurangan_dk']['tmk2']++;
                                                    $keterangan[] = "tmk2";
                                                } else if($ket_masuk > 2) {
                                                    $result['pengurangan_dk'] += 3;
                                                    $result['rincian_pengurangan_dk']['tmk3']++;
                                                    $keterangan[] = "tmk3";
                                                }
                                            }
                                        }
                                    }
                                    // $result['pengurangan_dk'] += 3;
                                    // $result['rincian_pengurangan_dk']['tmk3']++;
                                    // $keterangan[] = "tmk3";
                                }
                            } else { //kalau ada, cek keterlambatan
                                $result['hadir']++;
                                if($flag_count_tpp == 1){
                                    $result['capaian_dk'] += $result['pagu_harian'];
                                }
                                if(!isset($result['dokpen'][$tga]) || //cek kalo tidak ada dokpen, cek keterlambatan
                                    (isset($result['dokpen'][$tga]) && $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == 20)){ // kalo ada dokpen dan dokpen tugas luar sore, cek keterlambatan
                                        $diff_masuk = strtotime($data_absen[$tga]['masuk']) - strtotime($jam_masuk.'+ 59 seconds');
                                        $ket_masuk = floatval($diff_masuk / 1800);
                                        if($ket_masuk <= 1 && $ket_masuk > 0){
                                            $result['pengurangan_dk'] += 1;
                                            $result['rincian_pengurangan_dk']['tmk1']++;
                                            $keterangan[] = "tmk1";
                                            $data_absen['keterangan'][$tga][] = 'tmk1';
                                            // echo $result['pengurangan_dk'].'<br>';
                                            // dd($result['_dkrincian_pengurangan']);
                                        } else if($ket_masuk > 1 && $ket_masuk <= 2){
                                            $result['pengurangan_dk'] += 2;
                                            $result['rincian_pengurangan_dk']['tmk2']++;
                                            $keterangan[] = "tmk2";
                                            $data_absen['keterangan'][$tga][] = 'tmk2';
                                        } else if($ket_masuk > 2) {
                                            $result['pengurangan_dk'] += 3;
                                            $result['rincian_pengurangan_dk']['tmk3']++;
                                            $keterangan[] = "tmk3";
                                            $data_absen['keterangan'][$tga][] = 'tmk3';
                                        }
                                }
    
                                if($data_absen[$tga]['pulang'] == '00:00:00' || $data_absen[$tga]['pulang'] == null){ //cek jika tidak absen pulang
                                    if((isset($result['dokpen'][$tga]) &&
                                        $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == 19)){ //kalo ada dokpen dan dokpen tugas luar pagi, pksw3
                                            if($tga != date('Y-m-d')){
                                                $result['pengurangan_dk'] += 3;
                                                $result['rincian_pengurangan_dk']['pksw3']++;
                                                $keterangan[] = "pksw3";
                                            }
                                    } else if (isset($result['dokpen'][$tga]) //cek kalo ada surat tugas
                                        && $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 19){ //bukan surat tugas pagi, tambah dokpen
                                            $result['rincian_pengurangan_dk'][$result['dokpen'][$tga]['kode_dokpen']]++;
                                            $keterangan[] = $result['dokpen'][$tga]['kode_dokpen'];
                                    } else { // klo tidak ada dokpen
                                        $result['pengurangan_dk'] += 3;
                                        $result['rincian_pengurangan_dk']['pksw3']++;
                                        $keterangan[] = "pksw3";
                                        // $data_absen['keterangan'][$tga][] = 'pksw3';
                                    }
                                } else {
                                    if(!isset($result['dokpen'][$tga]) || //cek kalo tidak ada dokpen, cek keterlambatan
                                       (isset($result['dokpen'][$tga]) && $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == 19)){ // kalo ada dokpen dan dokpen tugas luar pagi, cek keterlambatan
                                        $diff_pulang = strtotime($jam_pulang) - strtotime($data_absen[$tga]['pulang']);
                                        $ket_pulang = floatval($diff_pulang / 1800);
                                        if($ket_pulang <= 1 && $ket_pulang > 0){
                                            $result['pengurangan_dk'] += 1;
                                            $result['rincian_pengurangan_dk']['pksw1']++;
                                            $keterangan[] = "pksw1";
                                            $data_absen['keterangan'][$tga][] = 'pksw1';
                                        } else if($ket_pulang > 1 && $ket_pulang <= 2){
                                            $result['pengurangan_dk'] += 2;
                                            $result['rincian_pengurangan_dk']['pksw2']++;
                                            $keterangan[] = "pksw2";
                                            $data_absen['keterangan'][$tga][] = 'pksw2';
                                        } else if($ket_pulang > 2) {
                                            $result['pengurangan_dk'] += 3;
                                            $result['rincian_pengurangan_dk']['pksw3']++;
                                            $keterangan[] = "pksw3";
                                            $data_absen['keterangan'][$tga][] = 'pksw3';
                                        }
                                    }
    
                                    if(isset($result['dokpen'][$tga]) && $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 19){ //cek kalo dokpen bukan tugas luar pagi
                                        $result['rincian_pengurangan_dk'][$result['dokpen'][$tga]['kode_dokpen']]++;
                                        $keterangan[] = $result['dokpen'][$tga]['kode_dokpen'];
                                    }
                                }
                            }
                        }
                    } else if(isset($result['dokpen'][$tga])){ //cek jika ada data dokumen pendukung
                        if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 3//cek jika dokumen pendukung bukan Tidak Kerja
                            // $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 17 && // jika dokumen pendukung bukan Cuti 
                            // $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 15 // jika dokumen pendukung bukan Cuti 
                        ){
                            // tambah capaian disiplin kerja

                            if($result['pagu_tpp']['nipbaru_ws'] == '197003161990101002' && $tga == '2025-03-14'){
                            }

                            if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 17 // jika bukan cuti
                                && $result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] != 15 // jika bukan dispensasi
                                && !isset($data_absen[$tga]) // dan ada data absen
                            ){
                                $result['hadir']++;
                            }
                            if($flag_count_tpp == 1){
                                $result['capaian_dk'] += $result['pagu_harian'];
                            }
                        }
                        // if(!in_array($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'], ['18', '19'])){ //cek jika dokumen pendukung bukan Tugas Luar Pagi atau Sore
                            if($flag_count_tpp == 1){
                                $result['pengurangan_dk'] = $result['pengurangan_dk'] + $result['dokpen'][$tga]['pengurangan'];
                            }
                            $result['rincian_pengurangan_dk'][$result['dokpen'][$tga]['kode_dokpen']]++;
                            $keterangan[] = $result['dokpen'][$tga]['kode_dokpen'];

                            if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == 19){ // jika TLP, maka PKSW 3
                                $data_absen[$tga]['masuk'] = '00:00:00';
                                $data_absen[$tga]['pulang'] = '00:00:00';
                                $data_absen['keterangan'][$tga][] = 'pksw3';
                                $result['pengurangan_dk'] += 3;
                                $result['rincian_pengurangan_dk']['pksw3']++;
                                $keterangan[] = "pksw3";
                            } else if($result['dokpen'][$tga]['id_m_jenis_disiplin_kerja'] == 20){ // jika TLS, maka TMK 3
                                if(!isset($data_absen[$tga]) || ($data_absen[$tga]['masuk'] == "" || !$data_absen[$tga]['masuk'])){
                                    $result['dokpen'][$tga] = null;
                                    $result['pengurangan_dk'] += 10;
                                    $result['rincian_pengurangan_dk']['TK']++;
                                    $keterangan = null;
                                    $keterangan[] = "TK";
                                } else {
                                    $data_absen[$tga]['masuk'] = '00:00:00';
                                    $data_absen[$tga]['pulang'] = '00:00:00';
                                    $data_absen['keterangan'][$tga][] = 'tmk3';
                                    $result['pengurangan_dk'] += 3;
                                    $result['rincian_pengurangan_dk']['tmk3']++;
                                    $keterangan[] = "tmk3";
                                }
                            }

                            // if($this->general_library->getId() == '1348'){
                            //     if($tga == '2024-09-17'){
                            //         // dd($result['dokpen'][$tga]);
                            //         // dd(json_encode($data_absen));
                            //     }
                            // }
                        // }
                    } else if(isset($result['hari_libur'][$tga])){ //cek jika hari libur
                        
                    } else { // asumsi tidak masuk kerja
                        // tambah capaian disiplin kerja
                        if($flag_count_tpp == 1){
                            $result['capaian_dk'] += $result['pagu_harian'];
                        }
                        $result['pengurangan_dk'] += 10;
                        $result['rincian_pengurangan_dk']['TK']++;
                        $keterangan[] = "TK";
                    }
                }
                // echo $tga.'  ';
                // dd($keterangan);
                // if($tga == '2023-06-06'){
                //     dd($result['pengurangan_dk']);
                //     // dd($result['']);
                // }
                // if($this->general_library->isProgrammer()){
                //     if($tga == '2024-10-15'){
                //         dd($keterangan);
                //         // dd($data_absen[$tga]);
                //     }
                // }
                // if($tga == '2025-03-14'){
                //     dd($keterangan);
                // }
                $data_absen['keterangan'][$tga] = $keterangan;
                // $result['data_absen']['keterangan'][$tga] = $keterangan;
                // if($tga == '2024-05-10'){
                //     dd($result['data_absen']['keterangan']);
                // }

                // echo $data_absen[$tga]['masuk'].'<br>';
                // dd($result['pengurangan_dk']);
            }
            
            $result['data_absen'] = $data_absen;

            if($result['list_dokpen']){
                $temp_rincian_pengurangan_dk = $result['rincian_pengurangan_dk'];
                // if($result['rincian_pengurangan_dk']){
                //     foreach($result['rincian_pengurangan_dk'] as $rpd){
                //         dd($result['rincian_pengurangan_dk']);
                //         $temp_rincian_pengurangan_dk[$rpd] = $rpd;
                //     }
                // }
                $temp_pengurangan_dk = $result['pengurangan_dk'];

                $mDisker = null;
                $list_disker = $this->db->select('*')
                                    ->from('m_jenis_disiplin_kerja')
                                    ->where('flag_active', 1)
                                    ->get()->result_array();

                if($list_disker){
                    foreach($list_disker as $ldis){
                        $mDisker[$ldis['keterangan']] = $ldis;
                    }
                }

                $exclude = ['TK', 'tmk1', 'tmk2', 'tmk3', 'pksw1', 'pksw2', 'pksw3'];
                $result['pengurangan_dk'] = 0;
                foreach($result['rincian_pengurangan_dk'] as $k => $v){
                    if(!in_array($k, $exclude)){
                        $result['rincian_pengurangan_dk'][$k] = 0;
                    } else {
                        $pengurangan = 0;
                        if($v != 0){
                            if($k == 'TK'){
                                $pengurangan = floatval($v) * 10;
                            } else if($k == 'tmk1'){
                                $pengurangan = floatval($v) * 1;
                            } else if($k == 'tmk2'){
                                $pengurangan = floatval($v) * 2;
                            } else if($k == 'tmk3'){
                                $pengurangan = floatval($v) * 3;
                            } else if($k == 'pksw1'){
                                $pengurangan = floatval($v) * 1;
                            } else if($k == 'pksw2'){
                                $pengurangan = floatval($v) * 2;
                            } else if($k == 'pksw3'){
                                $pengurangan = floatval($v) * 3;
                            }
                        }
                        $result['pengurangan_dk'] += $pengurangan;
                    }
                }

                // if($this->general_library->getId() == 16){
                //     dd($result['pengurangan_dk']);
                // }

                foreach($result['list_dokpen'] as $ldk){
                    if(!isset($result['rincian_pengurangan_dk'][$ldk['kode_dokpen']])){
                        $result['rincian_pengurangan_dk'][$ldk['kode_dokpen']] = 1;
                    } else {
                        $result['rincian_pengurangan_dk'][$ldk['kode_dokpen']]++;
                    }
                    $result['pengurangan_dk'] += $mDisker[$ldk['kode_dokpen']]['pengurangan'];
                }

                // dd($result['list_dokpen']);

                if($this->general_library->getId() == 16){
                    // dd(json_encode($result['rincian_pengurangan_dk']));
                }
            }

            if($this->general_library->getId() == 16){
                // dd(json_encode($result));
                // if($result['list_dokpen'][$tga]){
                //     foreach($result['list_dokpen'][$tga] as $ldt){
                        
                //     }
                // }
            }

            return $result;
        }

        public function getPegawaiById($id){
            $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang, g.nama_jabatan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
                            ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();
            return $pegawai;
        }

        public function tambahHakAkses($data){
            $exist = $this->db->select('*')
                                ->from('t_hak_akses')
                                ->where('id_m_user', $data['id_m_user'])
                                ->where('id_m_hak_akses', $data['id_m_hak_akses'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if(!$exist){
                $data['created_by'] = $this->general_library->getId();
                $this->db->insert('t_hak_akses', $data);
            }
        }

        public function deleteHakAkses($id){
            $this->db->where('id', $id)
                    ->update('t_hak_akses', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);
        }

        public function getHakAksesUser($id){
            return $this->db->select('b.*, a.id as id_t_hak_akses')
                            ->from('t_hak_akses a')
                            ->join('m_hak_akses b', 'a.id_m_hak_akses = b.id')
                            ->where('a.flag_active', 1)
                            ->where('a.id_m_user', $id)
                            ->order_by('b.nama_hak_akses', 'asc')
                            ->get()->result_array();
        }

        public function getPresensiPegawaiByNipAndDate($nip, $date){
            return $this->db->select('a.*, c.path_masuk, c.path_pulang')
                            ->from('db_sip.absen a')
                            ->join('m_user b', 'a.user_id = b.id')
                            ->join('db_sip.gambar c', 'b.id = c.user_id AND c.tgl = a.tgl', 'LEFT')
                            ->where('a.tgl', $date)
                            ->where('username', $nip)
                            ->get()->row_array();
        }

        public function saveEditPresensi($data_input, $nip, $date){
            $data = $this->db->select('a.*')
                            ->from('db_sip.absen a')
                            ->join('m_user b', 'a.user_id = b.id')
                            ->where('a.tgl', $date)
                            ->where('username', $nip)
                            ->get()->row_array();
            $new_absensi_masuk = $data_input['jam_masuk'].':'.$data_input['menit_masuk'].':'.$data_input['detik_masuk'];
            $new_absensi_pulang = $data_input['jam_pulang'].':'.$data_input['menit_pulang'].':'.$data_input['detik_pulang'];
            $old_pulang = null;
            $old_masuk = null;
            if($data){
                $old_pulang = $data['pulang'];
                $old_masuk = $data['masuk'];
                $this->db->where('id', $data['id'])
                        ->update('db_sip.absen', [
                            'masuk' => $new_absensi_masuk,
                            'pulang' => $new_absensi_pulang == "00:00:00" ? null : $new_absensi_pulang,
                        ]);
            } else {
                $user = $this->db->select('*')
                                ->from('m_user')
                                ->where('username', $nip)
                                ->where('flag_active', 1)
                                ->get()->row_array();

               
                $this->db->insert('db_sip.absen', [
                    'masuk' => $new_absensi_masuk,
                    'pulang' => $new_absensi_pulang == "00:00:00" ? null : $new_absensi_pulang,
                    'user_id' => $user['id'],
                    'tgl' => $date 
                ]);
            }
            $this->db->insert('t_log_edit_presensi', [
                'nip' => $nip,
                'date' => $date,
                'new_absen_masuk' => $new_absensi_masuk,
                'new_absen_pulang' => $new_absensi_pulang,
                'old_absen_masuk' => $old_masuk,
                'old_absen_pulang' => $old_pulang,
                'created_by' => $this->general_library->getId()
            ]);
        }

        public function getProfilUserByNoHp($nohp){
            $nohp = "0".substr($nohp, 2);
            return $this->db->select('a.*, b.nm_unitkerja, c.username')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                        ->join('m_user c', 'a.nipbaru_ws = c.username')
                        ->where('a.handphone', $nohp)
                        ->where('id_m_status_pegawai', 1)
                        ->get()->row_array();
        }

        public function getProfilUserByNip($nip){
            return $this->db->select('a.*, b.nm_unitkerja')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                        ->where('a.nipbaru_ws', $nip)
                        ->where('id_m_status_pegawai', 1)
                        ->get()->row_array();
        }

        public function checkIfKasubagKepeg($nip){
            $hak_akses = $this->db->select('*')
                                ->from('t_hak_akses a')
                                ->join('m_user b', 'a.id_m_user = b.id')
                                ->join('m_hak_akses c', 'a.id_m_hak_akses = c.id')
                                ->where('b.username', $nip)
                                ->where('c.meta_name', 'rekap_absen_pd')
                                ->where('a.flag_active', 1)
                                ->get()->row_array();


            $this->db->select('a.*, b.*, c.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                            ->join('m_user c', 'a.nipbaru_ws = c.username')
                            // ->like('b.nama_jabatan', 'kepegawaian')
                            // ->where_in('b.eselon', ['IV A', 'IV B'])
                            // ->where('a.nipbaru_ws', $nip)
                            ->where('id_m_status_pegawai', 1)
                            ->where('c.flag_active', 1);

            if(!$hak_akses){
                $this->db->where_in('b.eselon', ['IV A', 'IV B'])
                ->where('(b.nama_jabatan LIKE ("Kepala Sub Bagian Umum%") OR b.nama_jabatan LIKE ("Kasubag. Umum%"))')
                ->where('a.nipbaru_ws', $nip);
            }

            return $this->db->get()->row_array();
        }

        public function checkRandomStringFileDs($string){
            return $this->db->select('*')
                            ->from('t_file_ds')
                            ->where('random_string', $string)
                            ->get()->row_array();
        }

        public function cekAksesPegawaiRekapAbsen($nip){
            $hak_akses = $this->db->select('*')
                                ->from('t_hak_akses a')
                                ->join('m_user b', 'a.id_m_user = b.id')
                                ->join('m_hak_akses c', 'a.id_m_hak_akses = c.id')
                                ->where('b.username', $nip)
                                ->where('c.meta_name', 'rekap_absen_pd')
                                ->where('a.flag_active', 1)
                                ->get()->row_array();


            $this->db->select('a.*, b.*, c.id as id_m_user, d.*')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                            ->join('m_user c', 'a.nipbaru_ws = c.username')
                            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                            // ->like('b.nama_jabatan', 'kepegawaian')
                            // ->where_in('b.eselon', ['IV A', 'IV B'])
                            // ->where('a.nipbaru_ws', $nip)
                            ->where('c.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->where('a.nipbaru_ws', $nip);

            if(!$hak_akses){
                $this->db->where(
                    '(b.nama_jabatan LIKE ("Kepala Sub Bagian UMUM%") OR
                    b.nama_jabatan LIKE ("Kasubag. Umum%") OR
                    b.nama_jabatan LIKE ("Kepala Sekolah%") OR
                    b.nama_jabatan LIKE ("Kepala Taman%") OR
                    b.nama_jabatan LIKE ("Kepala Sub Bagian Tata Usaha%") OR
                    b.nama_jabatan LIKE ("Lurah%"))'
                );
            }
            return $this->db->get()->row_array();
        }

        public function loadDetailPdmUser(){
            $result = null;
            $data = $this->db->select('a.*,c.fotopeg')
                            ->from('t_pdm as a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->where('a.id_m_user', $this->general_library->getId())
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();
                            
            if($data){
                foreach($data as $d){
                    $result[$d['jenis_berkas']] = $d;
                     $result[$d['jenis_berkas']] = $d;
                }
            }
            return $result;
        }

        public function searchAllPegawai($data){
            // dd($data);
            $result = null;
            $flag_use_masa_kerja = 0;
            $this->db->select('a.id_peg,e.id_pangkat,c.jenis_jabatan,a.tgllahir,a.gelar1, a.gelar2, a.nama, c.nama_jabatan, b.nm_unitkerja, c.eselon, d.nm_agama, e.nm_pangkat,
                    a.nipbaru_ws, f.nm_statuspeg, a.statuspeg, f.id_statuspeg, a.tmtpangkat, a.tmtjabatan, a.id_m_status_pegawai,
                    h.nama_status_pegawai, f.nm_statuspeg')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                    ->join('db_pegawai.agama d', 'a.agama = d.id_agama')
                    ->join('db_pegawai.pangkat e', 'a.pangkat = e.id_pangkat')
                    ->join('db_pegawai.statuspeg f', 'a.statuspeg = f.id_statuspeg')
                    ->join('db_pegawai.eselon g', 'c.eselon = g.nm_eselon', 'left')
                    ->join('m_status_pegawai h', 'a.id_m_status_pegawai = h.id')
                    ->where_not_in('c.id_unitkerja', [5, 9050030])
                    ->order_by('c.eselon, a.nama');
            if($data['nama_pegawai'] != "" || $data['nama_pegawai'] != null){
                $this->db->like('a.nama', $data['nama_pegawai']);
            }
            if($data['unitkerja'] != 0){
                if($data['unitkerja'] == 991){
                    $this->db->where('b.id_unitkerjamaster', '8010000');
                } else if($data['unitkerja'] == 992){
                    $this->db->where('b.id_unitkerjamaster', '8020000');
                } else if($data['unitkerja'] == 990){
                    $this->db->where('b.id_unitkerjamaster', '8000000');
                } else if($data['unitkerja'] == 993){
                    $this->db->where_in('b.id_unitkerjamaster', ['6000000','7005000']);
                } else if($data['unitkerja'] == 994){
                    $this->db->where_not_in('b.id_unitkerjamaster', ['6000000','7005000','8010000','8020000','8000000']);
                }   else {
                    $this->db->where('a.skpd', $data['unitkerja']);
                }
                
            }
        
            if($data['jft'][0] != '0'){
                if($data['jft'][0] == '991'){
                    $this->db->like('c.nama_jabatan', 'Utama');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '992') {
                    $this->db->like('c.nama_jabatan', 'Madya');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '993') {
                    $this->db->like('c.nama_jabatan', 'Muda');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '994') {
                    $this->db->like('c.nama_jabatan', 'Pertama');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '995') {
                    $this->db->like('c.nama_jabatan', 'Penyelia');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '996') {
                    $this->db->like('c.nama_jabatan', 'Mahir');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '997') {
                    $this->db->like('c.nama_jabatan', 'Terampil');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else if($data['jft'][0] == '998') {
                    $this->db->like('c.nama_jabatan', 'Pemula');
                    $this->db->where('c.jenis_jabatan', 'JFT');
                } else {
                    $list_jft = null;
                    foreach($data['jft'] as $jft){
                        $list_jft[] = $jft;
                    }
                $this->db->where_in('c.id_jabatanpeg', $list_jft);
                }
                
            }
            if(isset($data['eselon'])){
                $this->db->where_in('g.id_eselon', $data['eselon']);
            }
            if(isset($data['jenis_jabatan'])){
                $this->db->where_in('c.jenis_jabatan', $data['jenis_jabatan']);
                if(in_array('JFT', $data['jenis_jabatan'])){
                    // $this->db->where('f.id_statuspeg != 1');
                }
            }
            if(isset($data['statuspeg'])){
                $this->db->where_in('f.id_statuspeg', $data['statuspeg']);
            }
            if(isset($data['tktpendidikan'])){
                $this->db->where_in('a.pendidikan', $data['tktpendidikan']);
            }
            if(isset($data['jeniskelamin'])){
                $this->db->where_in('a.jk', $data['jeniskelamin']);
            }
            if(isset($data['pangkat'])){
                $this->db->where_in('a.pangkat', $data['pangkat']);
            }
            if(isset($data['agama'])){
                $this->db->where_in('a.agama', $data['agama']);
            }
            if(isset($data['keteranganpegawai'])){
                    $this->db->where_in('a.id_m_status_pegawai', $data['keteranganpegawai']);
            }
            if(isset($data['golongan'])){
                $golongan = [];
                foreach($data['golongan'] as $g){
                    if($g == 1){
                        array_push($golongan, 11, 12, 13, 14);
                    }
                    if($g == 2){
                        array_push($golongan, 21, 22, 23, 24);
                    }
                    if($g == 3){
                        array_push($golongan, 31, 32, 33, 34);
                    }
                    if($g == 4){
                        array_push($golongan, 41, 42, 43, 44);
                    }
                    if($g == 5){
                        array_push($golongan, 55);
                    }
                    if($g == 7){
                        array_push($golongan, 57);
                    }
                    if($g == 9){
                        array_push($golongan, 59);
                    }
                    if($g == 10){
                        array_push($golongan, 60);
                    }
                }
                $this->db->where_in('e.id_pangkat', $golongan);
            }

            $result = $this->db->get()->result_array();

            $id_pangkat_ahli_madya = [41, 42, 43];
            $id_pangkat_ahli_utama = [44, 45];

            if(isset($data['satyalencana'])){
                $flag_use_masa_kerja = 1;
                $masa_kerja_satyalencana = $data['satyalencana'][0];
                $batas_atas = floatval($masa_kerja_satyalencana) + 10;
                if($batas_atas > 30){
                    $batas_atas = 100;
                }
                $temp = $result;
                if($temp){
                    $result = null;
                    foreach($temp as $t){
                        $tahun = substr($t['nipbaru_ws'], 8, 4);
                        $bulan = substr($t['nipbaru_ws'], 12, 2);
                        $tmt = $tahun.'-'.$bulan.'-01';
                        $masa_kerja = countDiffDateLengkap(date('Y-m-d'), $tmt, ['tahun']);
                        $explode_masa_kerja = explode(" ", trim($masa_kerja));
                        
                        if($explode_masa_kerja[0] != '' && $explode_masa_kerja[0]){
                            if(floatval($explode_masa_kerja[0] >= $masa_kerja_satyalencana && floatval($explode_masa_kerja[0]) < $batas_atas)){
                                if(!isset($result[$t['nipbaru_ws']])){
                                    $result[$t['nipbaru_ws']] = $t;
                                    $result[$t['nipbaru_ws']]['masa_kerja'] = countDiffDateLengkap(date('Y-m-d'), $tmt, ['tahun', 'bulan']);
                                }
                            }
                        }
                       
                    }
                }
            }
            $temp2 = $result;
           
                $result = null;              
                foreach($temp2 as $d){
                $tahun = date('Y');
                    
                $temp = null;
                if($d['tgllahir'] != null){
                    $tgl_lahir = explode("-", $d['tgllahir']);
                    $tanggal_lahir = new DateTime($d['tgllahir']);
                    $sekarang = new DateTime("today");
                    $umur = $sekarang->diff($tanggal_lahir)->y;
                   
                    $tgl_pensiun = date('Y-m-d', strtotime('+58 year', strtotime( $d['tgllahir'] ))); //tambah tanggal sebanyak 6 tahun

                    $bup = 0;
                    $crit = 0;
                        if(($d['jenis_jabatan'] == 'JFU' || $d['jenis_jabatan'] == 'Lainnya')){ //jika 58 dan JFU
                            $bup = 58;
                        } 
                        else if($d['jenis_jabatan'] == 'JFT'){
                            $explode_nama_jabatan = explode(" ", $d['nama_jabatan']);
                            if((stringStartWith('Kepala Sekolah', $d['nama_jabatan'])) || (stringStartWith('Kepala Taman', $d['nama_jabatan']))){
                                $bup = 60;
                            } else 
                            if(in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], ['Madya'])){
                                $bup = 60;
                            } else 
                            if(stringStartWith('Guru', $d['nama_jabatan'])){
                                $bup = 60;
                            } 
                            
                            else if(in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], ['Utama'])){
                                $bup = 65;
                            } 
                            
                            else {
                                $bup = 58;
                            }
                        } else if($d['eselon'] == 'II A' || $d['eselon'] == 'II B'){
                            $bup = 60;
                        } else if($d['eselon'] == 'III A' || $d['eselon'] == 'III B' || $d['eselon'] == 'IV A' || $d['eselon'] == 'IV B'){
                            $bup = 58;
                        } else if($umur == 65 && in_array($d['id_pangkat'], $id_pangkat_ahli_utama)){
                            $bup = 65;
                        } else if($umur == 58 &&
                        !in_array($d['id_pangkat'], $id_pangkat_ahli_utama) &&
                        !in_array($d['id_pangkat'], $id_pangkat_ahli_madya) &&
                        ($d['eselon'] != 'II A' && $d['eselon'] != 'II B')){
                            $bup = 58;
                        }
                        $temp = $d;
                        if($temp){
                            $temp['tmt_pensiun'] = countTmtPensiun($d['nipbaru_ws'], $bup);
                            $explode = explode("-", $temp['tmt_pensiun']);
                            $temp['umur'] = $umur;
                            $temp['bup'] = $bup;

                            if(isset($data['keteranganpegawai'])){
                            if(in_array("9", $data['keteranganpegawai'])) {
                                    // if($umur >= $bup){
                                    //         $result[] = $temp;
                                    //  }
                                  
                                    $date_now = date("Y-m-d");
                                    $tmt_pensiun = date("Y-m-d", strtotime($temp['tmt_pensiun']));
                                    
                                    if($date_now > $tmt_pensiun){
                                            $result[] = $temp;
                                    }
                                } else {
                                    $result[] = $temp; 
                                }
                            } else {
                                $result[] = $temp; 
                            }
                                                      
                            }
                            }
                            }   
                            
            return [$result, $flag_use_masa_kerja];
        }

        public function getFotoPegawai(){
            $username = $this->general_library->getUserName();
            $this->db->select('a.fotopeg')
                ->from('db_pegawai.pegawai a')
                ->where('a.nipbaru_ws', $username)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        public function injectBidang(){
            $bidang = $this->db->select('*')
                                ->from('m_bidang')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            $list_bidang = null;
            foreach($bidang as $b){
                if(stringStartWith('Bidang', $b['nama_bidang'])){
                    $list_bidang['Kepala '.$b['nama_bidang']] = $b['id'];
                }
            }
            // dd($list_bidang);

            $jabatan = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->get()->result_array();

            $pegawai = $this->db->select('a.*, a.id as id_m_user, d.nama_jabatan, c.nm_unitkerja')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'b.nipbaru_ws = a.username')
                                ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                ->where_in('c.id_unitkerjamaster', [4000000, 3000000])
                                ->where('d.eselon', 'III B')
                                ->where('a.id_m_bidang IS NULL')
                                ->where('a.id_m_sub_bidang IS NULL')
                                ->group_by('b.nipbaru_ws')
                                ->get()->result_array();
            dd($pegawai);
            $no = 1;
            foreach($pegawai as $p){
                if(isset($list_bidang[$p['nama_jabatan']])){
                    echo $no++.'<br>';
                    echo 'inserting '.$list_bidang[$p['nama_jabatan']].' ke '.$p['username'].'<br><br>';
                    $this->db->where('id', $p['id_m_user'])
                            ->update('m_user', [
                                'id_m_bidang' => $list_bidang[$p['nama_jabatan']]
                            ]);        
                } else {
                    dd($p);
                }
            }
            // dd('done');
        }
        
        public function cekKenegaraan(){
            $tanggal = 9;
            $bulan = 4;
            $tahun = 2025;
            $tanggalLengkap = $tanggal < 10 ? "0".$tanggal : $tanggal;
            $bulanLengkap = $bulan < 10 ? "0".$bulan : $bulan;
            $dateLengkap = $tahun."-".$bulanLengkap."-".$tanggalLengkap;

            $list_pegawai = $this->db->select('b.id as user_id, a.nipbaru_ws, a.nama, b.id, c.nm_unitkerja')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_ws = b.username')
                                ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                                ->where('b.flag_active', 1)
                                ->where('a.id_m_status_pegawai', 1)
                                ->where_not_in('c.id_unitkerja', [9000001, 7005010, 7005020]) // exclude tubel, RSUD, RSKDGM
                                ->where_not_in('c.id_unitkerjamaster', [9000000, 8010000, 8020000, 8030000, 8000000, 6000000]) // exclude guru, puskes
                                ->get()->result_array();

            $event = $this->db->select('*')
                            ->from('db_sip.absen_event')
                            ->where('tgl', $dateLengkap)
                            ->get()->result_array();

            $absenReguler = $this->db->select('a.user_id, a.masuk, a.pulang, b.username, d.nm_unitkerja')
                                    ->join('m_user b', 'b.id = a.user_id AND b.flag_active = 1')
                                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                    ->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
                                    ->from('db_sip.absen a')
                                    ->where('a.tgl', $dateLengkap)
                                    ->where('c.id_m_status_pegawai', 1)
                                    ->where_not_in('d.id_unitkerja', [9000001, 7005010, 7005020]) // exclude tubel, RSUD, RSKDGM
                                    ->where_not_in('d.id_unitkerjamaster', [9000000, 8010000, 8020000, 8030000, 8000000, 6000000]) // exclude guru, puskes
                                    ->get()->result_array();

            $list_dokpen = $this->db->select('id_m_user, keterangan')
                                ->from('t_dokumen_pendukung')
                                ->where('tanggal', $tanggal)
                                ->where('bulan', $bulan)
                                ->where('tahun', $tahun)
                                ->where('flag_active', 1)
                                ->where('status', 2)
                                ->get()->result_array();

            $absenEvent = null;
            $dokpen = null;
            $tidakAdaAbsenEvent = null;
            $tidakAbsenPulangEvent = null;
            $absenRegulerTidakAbsenEvent = null;
            $absenRegulerTidakAbsenEventFix = null;
            $kenegaraan = null;
            $kenegaraanFix = null;
            $dokpenKenegaraan;

            foreach($list_dokpen as $ld){
                $dokpen[$ld['id_m_user']] = $ld;
            }

            foreach($event as $e){
                $absenEvent[$e['user_id']] = $e;
            }

            foreach($absenReguler as $ar){
                if(!isset($absenEvent[$ar['user_id']])){ // melakukan absen reguler tapi tidak absen event
                    $absenRegulerTidakAbsenEvent[] = $ar;
                }
            }
            
            foreach($absenRegulerTidakAbsenEvent as $artae){
                if(!isset($dokpen[$artae['user_id']])){
                    $absenRegulerTidakAbsenEventFix[] = $artae;
                    $kenegaraan[$artae['user_id']] = $artae;
                    $kenegaraan[$artae['user_id']]['keterangan_sistem'] = "Melakukan presensi tapi tidak presensi event Apel Perdana Bulan ".getNamaBulan($bulan)." Tahun ".$tahun;
                }
            }

            foreach($list_pegawai as $lp){
                if(isset($absenEvent[$lp['user_id']]) && $absenEvent[$lp['user_id']]['pulang'] == null){
                    $tidakAdaAbsenPulangEvent[] = $lp;
                    if(isset($kenegaraan[$lp['user_id']])){
                        dd($lp);
                    }
                    $kenegaraan[$lp['user_id']] = $lp;
                    $kenegaraan[$lp['user_id']]['keterangan_sistem'] = "Tidak melakukan presensi pulang untuk event Apel Perdana Bulan ".getNamaBulan($bulan)." Tahun ".$tahun;
                }
            }

            $peninjauanAbsensi = null;
            $listPeninjauan = $this->db->select('*')
                                    ->from('t_peninjauan_absensi')
                                    ->where('tanggal_absensi', $dateLengkap)
                                    ->where('flag_active', 1)
                                    ->where('status', 1)
                                    ->get()->result_array();
            if($listPeninjauan){
                foreach($listPeninjauan as $lPnj){
                    $peninjauanAbsensi[$lPnj['id_m_user']] = $lPnj; 
                }
            }
            
            $out = null;
            foreach($kenegaraan as $k){
                if(!isset($dokpen[$k['user_id']]) && !isset($peninjauanAbsensi[$k['user_id']])){
                    //jika tidak ada dokpen dan tidak melakukan peninjauan absensi
                    $kenegaraanFix[$k['user_id']] = $k;
                    $dokpenKenegaraan = null;
                    $dokpenKenegaraan['id_m_user'] = $k['user_id'];
                    $dokpenKenegaraan['tanggal'] = $tanggal;
                    $dokpenKenegaraan['bulan'] = $bulan;
                    $dokpenKenegaraan['tahun'] = $tahun;
                    $dokpenKenegaraan['id_m_jenis_disiplin_kerja'] = 6;
                    $dokpenKenegaraan['keterangan'] = "Kenegaraan";
                    $dokpenKenegaraan['pengurangan'] = "5";
                    $dokpenKenegaraan['status'] = "2";
                    $dokpenKenegaraan['id_m_user_verif'] = "0";
                    $dokpenKenegaraan['random_string'] = generateRandomString();
                    $dokpenKenegaraan['flag_fix_tanggal'] = 0;
                    $dokpenKenegaraan['flag_fix_jenis_disiplin'] = 0;
                    $dokpenKenegaraan['flag_fix_dokumen_upload'] = 0;
                    $dokpenKenegaraan['keterangan_sistem'] = $k['keterangan_sistem'];
                    $this->db->insert('t_dokumen_pendukung', $dokpenKenegaraan);

                    echo "input ".$k['user_id']."\n <br>";
                } else {
                    $out[] = $k;
                }
            }
            // dd($kenegaraan);
            dd("done ".count($kenegaraanFix));
        }

        public function addUserCpns(){
            $unitKerja = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->get()->result_array();
            $listUnitKerja = null;
            foreach($unitKerja as $u){
                $listUnitKerja[$u['id_unor_siasn']] = $u;
            }

            $mBidang = $this->db->select('*')
                                ->from('m_bidang')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            $listBidang = null;
            foreach($mBidang as $bid){
                $listBidang[$bid['id_unor_siasn']] = $bid;
            }

            $mSubBidang = $this->db->select('*')
                                ->from('m_sub_bidang')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            $listSubBidang = null;
            foreach($mSubBidang as $subBid){
                $listSubBidang[$subBid['id_unor_siasn']] = $subBid;
            }

            $mUser = $this->db->select('*')
                                ->from('m_user')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            $listUser = null;
            foreach($mUser as $us){
                $listUser[$us['username']] = $us;
            }

            $pegawai = $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->get()->result_array();

            $listPegawai = null;
            foreach($pegawai as $p){
                $listPegawai[$p['nipbaru_ws']] = $p;
            }

            $jabatanPelaksana = $this->db->select('*')
                                    ->from('db_pegawai.jabatan')
                                    ->where('nama_jabatan LIKE', 'Pelaksana%')
                                    ->where('eselon', 'Non Eselon')
                                    ->where('jenis_jabatan', 'JFU')
                                    ->get()->result_array();
            $listJabatanPelaksana = null;
            foreach($jabatanPelaksana as $jp){
                $listJabatanPelaksana[$jp['id_unitkerja']] = $jp;
            }

            $resultJson = $this->db->select('*')
                                ->from('m_parameter')
                                ->where('parameter_name', 'TEMP_CPNS_2024')
                                ->get()->row_array();
            $result = json_decode($resultJson['parameter_value'], true);

            $this->db->trans_begin();

            foreach($result as $rs){
                // dd($result);%
                $agama = 1;
                if($rs['agama_nama'] == 'Katholik'){
                    $agama = 2;
                } else if($rs['agama_nama'] == 'Islam'){
                    $agama = 3;
                } else if($rs['agama_nama'] == 'Hindu'){
                    $agama = 4;
                } else if($rs['agama_nama'] == 'Buddha'){
                    $agama = 5;
                }
                $keyUk = 'unor_induk_id';
                if(!isset($listUnitKerja[$rs['unor_induk_id']])){
                    $keyUk = 'unor_id';
                } else {
                    if($listUnitKerja[$rs[$keyUk]]['id_unitkerja'] == 1000001){ //jika sekda, ambil unor_id
                        $keyUk = 'unor_id';
                    }
                }

                $bidang = isset($listBidang[$rs['unor_id']]) ? $listBidang[$rs['unor_id']] : null;

                $password = $rs['nip'];
                $pass_split = str_split($password);
                $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                $newEncPassword = $this->general_library->encrypt($rs['nip'], $new_password);

                // $tesspass = '08092001';
                // $encTesPass = $this->general_library->encrypt($rs['nip'], $tesspass);

                if(!isset($listUser[$rs['nip']])){
                    $insertUser =  [
                        'username' => $rs['nip'],
                        'password' => $newEncPassword,
                        // 'tessPass' => $encTesPass,
                        'id_m_bidang' => $bidang ? $bidang['id'] : 0,
                        'nama' => $rs['nama']
                    ];
                    echo "inserting user ...".$rs['nip']."<br>";
                    $this->db->insert('m_user', $insertUser);
                    $insertIdMUser = $this->db->insert_id();

                    $this->db->insert('m_user_role', [
                        'id_m_user' => $insertIdMUser,
                        'id_m_role' => 10,
                        'is_default' => 1
                    ]);
                } else {
                    echo "skip user because exists ".$rs['nip']."<br>";
                }

                if(!isset($listPegawai[$rs['nip']])){
                    $uker = null;
                    $jabatan = null;
                    if(isset($listUnitKerja[$rs[$keyUk]])){
                        $uker = $listUnitKerja[$rs[$keyUk]];
                    }

                    if(!$uker){
                        echo "uker tidak ada";
                        dd($rs);
                        $this->db->trans_rollback();
                    } else {
                        if(!isset($listJabatanPelaksana[$uker['id_unitkerja']])){
                            echo "jabatan tidak ada ".$uker['id_unitkerja'];
                            dd($rs);
                            $this->db->trans_rollback();
                        } else {
                            $jabatan = $listJabatanPelaksana[$uker['id_unitkerja']];   
                        }
                    }

                    $idpeg = "PEG202503".generateRandomNumber(5);

                    $insertPegawai =  [
                        'id_peg' => $idpeg,
                        'niplama' => "",
                        'nipbaru' => $rs['nip'],
                        'nipbaru_ws' => $rs['nip'],
                        'nama' => $rs['nama'],
                        'tptlahir' => $rs['tempat_lahir'],
                        'tgllahir' => $rs['tanggal_lahir'],
                        'jk' => $rs['jenis_kelamin'] == "F" ? "Perempuan" : "Laki-laki",
                        'agama' => $agama,
                        'skpd' => $uker['id_unitkerja'],
                        'jabatan' => $jabatan['id_jabatanpeg'],
                        'statusjabatan' => 1,
                        'jenisjabpeg' => 10,
                        'pangkat' => $rs['golongan_id'],
                        'tmtpangkat' => "2025-05-01",
                        'tmtcpns' => "2025-05-01",
                        'tmtgjberkala' => "2025-05-01",
                        'golawal' => $rs['golongan_id'],
                        'statuspeg' => 1,
                        'jenispeg' => 1,
                        'id_m_status_pegawai' => 1,
                        'flag_terima_tpp' => 1,
                        'besaran_gaji' => $rs['gaji_pokok'],
                        'id_pns_siasn' => $rs['orang_id']
                    ];
                    echo "inserting pegawai ...".$rs['nip']."<br>";
                    $this->db->insert('db_pegawai.pegawai', $insertPegawai);

                    $pegjabatan = [
                        'id_pegawai' => $idpeg,
                        'nm_jabatan' => "Pelaksana",
                        'id_jabatan' => $jabatan['id_jabatanpeg'],
                        'tmtjabatan' => "2025-05-01",
                        'jenisjabatan' => 10,
                        'pejabat' => "Wali Kota Manado",
                        'eselon' => 1,
                        'nosk' => "800.1.2.5/BKPSDM/SK/02/2025",
                        'tglsk' => '2025-05-05',
                        'skpd' => $uker['nm_unitkerja'],
                        'status' => 2,
                        'tanggal_verif' => date('Y-m-d H:i:s')
                    ];

                    echo "inserting pegjabatan ...".$rs['nip']."<br>";
                    $this->db->insert('db_pegawai.pegjabatan', $pegjabatan);
                } else {
                    echo "skip pegawai because exists ".$rs['nip']."<br>";
                }
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

	}
?>