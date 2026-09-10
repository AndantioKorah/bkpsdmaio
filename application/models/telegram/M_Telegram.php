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
                                $firstName = isset($r['message']['from']['first_name']) ? $r['message']['from']['first_name'] : "";
                                $lastName = isset($r['message']['from']['last_name']) ? $r['message']['from']['last_name'] : "";
                                $senderName = $firstName." ".$lastName;
                                
                                $dataUpdates = null;
                                $dataUpdates = [
                                    'update_id' => $r['update_id'],
                                    'message_id' => $r['message']['message_id'],
                                    'flag_bot' => $r['message']['from']['is_bot'] == false ? 0 : 1,
                                    'sender_name' => $senderName,
                                    'username' => $r['message']['from']['username'],
                                    'user_id' => $r['message']['from']['id'],
                                    'date_sent' => $dateSend->format('Y-m-d H:i:s'),
                                    'type' => "text",
                                    'text' => $r['message']['text']
                                ];

                                if(isset($r['message']['reply_to_message'])){
                                    $dataUpdates['reply_to_message_id'] = $r['message']['reply_to_message']['message_id'];
                                }

                                $this->db->insert('t_data_updates_telegram', $dataUpdates);
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
            // $keyboard = [
            //     'inline_keyboard' => [
            //         [
            //             // Button 1: Opens a URL
            //             [
            //                 'text' => '🌐 Open Google', 
            //                 'url' => 'https://google.com'
            //             ],
            //             // Button 2: Sends data back to your bot backend
            //             [
            //                 'text' => '👍 Like', 
            //                 'callback_data' => 'like_clicked'
            //             ]
            //         ]
            //     ]
            // ];

            // $data = [
            //     'chat_id' => 713399901,
            //     'text' => 'Click one of the inline buttons below:',
            //     'reply_markup' => ($keyboard)
            // ];

            // $this->db->insert('t_cron_telegram', [
            //     'type' => "text",
            //     'sendTo' => 713399901,
            //     'data_post' => json_encode($data),
            //     'method' => 'sendMessageInclineKeyboard'
            // ]);

            $data = $this->db->select('*')
                        ->from('t_data_updates_telegram')
                        ->where('flag_active', 1)
                        ->where('id_t_cron_telegram IS NULL')
                        ->where('flag_bot', 0)
                        ->order_by('date_sent', 'asc')
                        ->limit(10)
                        ->get()->result_array(0);
            if($data){
                foreach($data as $d){
                    $reply = null;
                    // cek user yang sudah terdaftar
                    $user = $this->db->select('a.id, b.gelar1, b.gelar2, b.nama')
                                    ->from('m_user a')
                                    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                    ->where('a.user_id_telegram', $d['user_id'])
                                    ->get()->row_array();

                    if(strcasecmp($d['text'], "/start") == 0){
                        if($user){
                            $reply = "Selamat ".greeting().", ".getNamaPegawaiFull($user). "\nSelamat datang di SILADEN, Official Telegram Bot BKPSDM Kota Manado.";
                        } else {
                            $reply = "Selamat ".greeting().", ".$d['sender_name'].". Akun Telegram Anda belum terintegrasi dengan akun SILADEN. Silahkan ikuti langkah-langkah berikut untuk mengintegrasikan akun SILADEN dan akun Telegram Anda.\n\n1. Login ke dalam Akun SILADEN,\n2. Klik menu Profile yang ada di samping kiri,\n3. Klik tab Data Pribadi,\n4. Klik tombol yang ada pada data Telegram,\n5. Masukkan kode ".$d['user_id']." pada kolom Input Kode Integrasi,\n6.Klik simpan.";
                        }
                    } else {
                        $reply = "";
                    }
                    // else if(strcasecmp($d['text'], "/integrasi_siladen") == 0){
                    //     if($user){ // jika sudah terintegrasi
                    //         $reply = "Akun Telegram Anda saat ini sudah terintegrasi dengan Akun SILADEN. Jika ingin mengganti akun SILADEN yang terintegrasi, silahkan klik tombol Menu yang terdapat di samping kiri bawah dan pilih /reset_siladen.";
                    //     } else {
                    //         $reply = "Silahkan masukkan NIP Anda tanpa menggunakan spasi dan tanpa teks lainnya (contoh: 197502302006071007).";
                    //     }
                    // } else if(strcasecmp($d['text'], "/reset_siladen") == 0){

                    // } else {
                    //     if($user){
                    //         // ambil chat sebelumnya dari user yang sama
                    //         $chatBefore = $this->db->select('*')
                    //                             ->from('t_data_updates_telegram')
                    //                             ->where('user_id', $d['user_id'])
                    //                             ->where('id !=', $d['id'])
                    //                             ->where('update_id <', $d['update_id'])
                    //                             ->order_by('update_id', 'desc')
                    //                             ->get()->row_array();
                    //         if($chatBefore){
                    //             if(strcasecmp($chatBefore['text'], "/integrasi_siladen") == 0){
                    //                 //jika integrasi_siladen, maka cek text yang dimasukkan apakah NIP yang valid
                    //                 $userExists = $this->db->select('*')
                    //                                     ->from('m_user')
                    //                                     ->where('username', $d['text'])
                    //                                     ->where('flag_active', 1)
                    //                                     ->get()->row_array();
                    //                 if($userExists){
                    //                     if($userExists['user_id_telegram']){
                    //                         // jika sudah ada user_id_telegram, reply agar harus dihapus terlebih dahulu 
                    //                         $reply = "Akun Telegram Anda saat ini sudah terintegrasi dengan Akun SILADEN. Jika ingin mengganti akun SILADEN yang terintegrasi, silahkan klik tombol Menu yang terdapat di samping kiri bawah dan pilih /reset_siladen";
                    //                     } else {
                    //                         $existsToken = $this->db->select('*')
                    //                                             ->from('t_token_telegram')
                    //                                             ->where('id_m_user', $userExists['id'])
                    //                                             ->where('jenis_transaksi', '/integrasi_siladen')
                    //                                             ->where('flag_active', 1)
                    //                                             ->where('date_use IS NULL')
                    //                                             ->where('date_expired <= ', date('Y-m-d H:i:s'))
                    //                                             ->get()->row_array();
                    //                         if($existsToken){
                    //                             // jika masih ada token yang aktif
                    //                             $reply = "Mohon maaf, permintaan ditolak karena masih ada token yang aktif sebelumnya.";
                    //                         } else {
                    //                             $token = generateRandomNumber(6);
                    //                             $dateExpiredToken = new DateTime(date('Y-m-d H:i:s'));
                    //                             $dateExpiredToken->modify("+10 minutes");
                    //                             $dateExpiredToken = $dateExpiredToken->format('Y-m-d H:i:s');

                    //                             $this->db->insert('t_token_telegram', [
                    //                                 'id_m_user' => $userExists['id'],
                    //                                 'jenis_transaksi' => "/integrasi_siladen",
                    //                                 'date_expired' => $dateExpiredToken,
                    //                             ]);
                    //                             $reply = "Token Integrasi SILADEN Anda adalah: <strong>".$token."</strong>. Token akan sampai ".formatDateNamaBulanWithTime($dateExpiredToken)."\n\n
                    //                                 1. Login ke dalam Akun SILADEN,\n
                    //                                 2. Klik menu Profile yang ada di samping kiri,\n
                    //                                 3. Klik tab Data Pribadi,\n
                    //                                 4. Klik tombol yang ada pada data Telegram,\n
                    //                                 5. Masukkan Token Integrasi SILADEN di atas pada kolom Input Token sebelum batas waktu dan klik submit.
                    //                             ";
                    //                         }
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     } else {

                    //     }
                    // }
                    if($reply != null){
                        $this->db->insert('t_cron_telegram', [
                            'id_t_data_updates_telegram' => $d['id'],
                            'type' => 'text',
                            'sendTo' => $d['user_id'],
                            'message' => $reply
                        ]);
                        $insert_id = $this->db->insert_id();

                        $this->db->where('id', $d['id'])
                                ->update('t_data_updates_telegram', [
                                    'id_t_cron_telegram' => $insert_id
                                ]);
                    }
                }
            }
        }

        public function cronSendReplyTelegram(){
            $data = $this->db->select('*')
                            ->from('t_cron_telegram')
                            ->where('flag_sent', 0)
                            ->where('flag_active', 1)
                            ->where('temp_count <', 3)
                            ->order_by('id', 'asc')
                            ->order_by('flag_prioritas', 'desc')
                            ->limit(10)
                            ->get()->result_array();
            if($data){
                foreach($data as $d){
                    if($d['type'] == "text"){
                        $tempCount = intval($d['temp_count']);
                        $tempCount += 1;
                        $updateCronSend = null;
                        $updateCronSend['temp_count'] = $tempCount;
                        $updateCronSend['flag_sending'] = 1;
                        $updateCronSend['date_sending'] = date('Y-m-d H:i:s');

                        $dataPost = $d['data_post'] ? $d['data_post'] : ["message" => $d['message']];

                        $reqSend = $this->telegramlib->send_curl_exec(
                            "",
                            $d['method'] ? $d['method'] : "sendMessage",
                            $d['sendTo'],
                            $dataPost
                        );
                        
                        if($reqSend){
                            $res = json_decode($reqSend['result'], true);
                            if($res['ok'] == true){
                                $updateCronSend['flag_sent'] = 1;
                                $updateCronSend['date_sent'] = date('Y-m-d H:i:s');
                                $updateCronSend['messageId'] = $res['result']['message_id'];
                            }
                        }
                        $updateCronSend['log'] = json_encode($reqSend);

                        $this->db->where('id', $d['id'])
                                ->update('t_cron_telegram', $updateCronSend);

                    }
                }
            }
        }

	}
?>