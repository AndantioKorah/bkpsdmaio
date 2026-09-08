<?php
    require FCPATH . '/vendor/autoload.php';

    class M_Telegram extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function log($data){
            $this->db->insert('t_log_webhook_telegram', [
                'response' => $data['response']
            ]);
        }

        public function cronGetUpdates(){
            $mParam = null;
            $param = $this->db->select('*')
                            ->from('m_parameter')
                            ->where('flag_active', 1)
                            ->like('parameter_name', 'PARAM_TELEGRAM')
                            ->get()->result_array();
            foreach($param as $p){
                $mParam[$p['parameter_name']] = $p;
            }

            $now = (date('Y-m-d H:i:s'));
            $lastHit = ($mParam['PARAM_TELEGRAM_LAST_HIT_GETUPDATES']['parameter_value']);
            $diff = strtotime($now) - strtotime($lastHit);

            // jika lebih dari waktu yang ditentukan, lakukan hit
            if(intval($diff) >= $mParam['PARAM_TELEGRAM_SECONDS_INTERVAL_GETUPDATES']['parameter_value']){
                $this->db->trans_begin();
                $url = 'getUpdates'."?limit=20";
                // jika ada data untuk last_id, maka offset dari data tersebut
                if($mParam['PARAM_TELEGRAM_LAST_ID_GETUPDATES']['parameter_value'] != null){
                    $lastId = intval($mParam['PARAM_TELEGRAM_LAST_ID_GETUPDATES']['parameter_value']);
                    $url = $url."&offset=".($lastId+1);
                    // dd($url);
                }

                $req = $this->telegramlib->send_curl_exec('GET', $url, '', null);
                if($req){
                    $lastMessageId = null; 
                    $res = json_decode($req['result'], true);
                    if($res && $res['ok'] == true){
                        foreach($res['result'] as $r){
                            $lastMessageId = $r['update_id'];
                            // dd($r['text']);
                            if(isset($r['message']['text'])){
                                $dateSend = new DateTime();
                                $dateSend->setTimestamp($r['message']['date']);

                                $this->db->insert('t_data_updates_telegram', [
                                    'update_id' => $r['update_id'],
                                    'message_id' => $r['message']['message_id'],
                                    'flag_bot' => $r['message']['from']['is_bot'] == false ? 0 : 1,
                                    'sender_name' => $r['message']['from']['first_name']." ".$r['message']['from']['last_name'],
                                    'username' => $r['message']['from']['username'],
                                    'user_id' => $r['message']['from']['id'],
                                    'date_sent' => $dateSend->format('Y-m-d H:i:s'),
                                    'type' => "text",
                                    'text' => $r['message']['text']
                                ]);
                            }
                        }
                    }

                    if($lastMessageId != null){
                        $this->db->where('parameter_name', 'PARAM_TELEGRAM_LAST_ID_GETUPDATES')
                                ->update('m_parameter', [
                                    'parameter_value' => $lastMessageId
                                ]);
                    }
                }

                $this->db->where('parameter_name', 'PARAM_TELEGRAM_LAST_HIT_GETUPDATES')
                                ->update('m_parameter', [
                                    'parameter_value' => date('Y-m-d H:i:s')
                                ]);

                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            } else {
                echo "belum waktunya";
            }
        }

        public function cronSetReplyTelegram(){
            $data = $this->db->select('*')
                        ->from('t_data_updates_telegram')
                        ->where('flag_active', 1)
                        ->where('flag_set_reply', 0)
                        ->where('flag_bot', 0)
                        ->order_by('date_sent', 'asc')
                        ->limit(10)
                        ->get()->result_array(0);
                        
            if($data){
                foreach($data as $d){
                    $reply = null;
                    if(strcasecmp($d['text'], "/start") == 0){
                        $reply = "Selamat datang di Bot Telegram SILADEN. Untuk mengakses menu yang tersedia, silahkan pilih tombol Menu yang terdapat di samping kiri bawah";
                    } else if(strcasecmp($d['text'], "/integrasi_siladen") == 0){
                        // cek user yang sudah terdaftar
                        $user = $this->db->select('a.id, b.gelar1, b.gelar2, b.nama')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->where('a.user_id_telegram', $d['user_id'])
                                        ->get()->row_array();
                        if($user){ // jika sudah terintegrasi
                            $reply = "Akun Telegram Anda saat ini sudah terintegrasi dengan Akun SILADEN.";
                        } else {
                            $reply = "Silahkan masukkan NIP Anda tanpa menggunakan spasi dan tanpa teks lainnya (contoh: 197502302006071007).";
                        }
                    } else if(strcasecmp($d['text'], "/reset_siladen") == 0){

                    } else {
                        // ambil chat sebelumnya dari user yang sama
                        $chatBefore = $this->db->select('*')
                                            ->from('t_data_updates_telegram')
                                            ->where('user_id', $d['user_id'])
                                            ->where('id !=', $d['id'])
                                            ->where('update_id <', $d['update_id'])
                                            ->order_by('update_id', 'desc')
                                            ->get()->row_array();
                        if($chatBefore){
                            if(strcasecmp($chatBefore['text'], "/integrasi_siladen") == 0){
                                //jika integrasi_siladen, maka cek text yang dimasukkan apakah NIP yang valid
                                $userExists = $this->db->select('*')
                                                    ->from('m_user')
                                                    ->where('username', $d['text'])
                                                    ->where('flag_active', 1)
                                                    ->get()->row_array();
                                if($userExists){
                                    if($userExists['user_id_telegram']){
                                        // jika sudah ada user_id_telegram, reply agar harus dihapus terlebih dahulu 
                                        $reply = "Akun Telegram Anda saat ini sudah terintegrasi dengan Akun SILADEN.";
                                    } else {
                                        $this->db->insert('t_notifikasi', [
                                            'jenis_notifikasi' => "integrasi_akun_telegram",
                                            'judul_notifikasi' => "Integrasi Akun Telegram",
                                            'pesan' => ""
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

	}
?>