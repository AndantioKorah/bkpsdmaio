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

                                $this->db->insert('t_log_update_telegram', [
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

	}
?>