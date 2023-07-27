<?php

class C_Maxchat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->model('user/M_User', 'user');
        // $this->load->library('MaxchatLibrary', 'maxchat');
    }

    public function webhook(){
        $result = $this->maxchatlibrary->webhookCapture();
        $data = $result->data;
        $this->general->insert('t_chat_group', [
            'text' => json_encode($resp)
        ]);

        if ($result->event == "new" && $result->type == "message" && $data->type == "text" && $data->fromMe == false && $data->from != GROUP_CHAT_HELPDESK) {
            $this->chatBotLayanan($result, $data);
        } else if($data->from == GROUP_CHAT_HELPDESK){
            if(!isset($data->originalMsg)){
                $this->forwardToPegawai($result, $data);
            } else {
                $this->chatHelpdeskSiladen($result, $data);
            }
        }
    }

    public function forwardToPegawai($result, $data){
        $reply = null;
        $sendTo = $data->sender;
        $log = null;

        if(isset($data->originalId)){
            if($data->type == "image"){
                $ori = json_decode($this->maxchatlibrary->getMessageById($data->originalId), true);
                $explode = explode("\n", $ori['text']);
                $chatId = $explode[1];
            }
            $sender = $this->general->getOne('t_log_webhook', 'chat_id', $chatId, 0);
            if($sender){
                $media = json_decode($this->maxchatlibrary->getMessageMediaById($data->id), true);
                $sendTo = $sender['sender'];
                if($media){
                    $reply = "data:".$media['mimetype'].";base64,".$media['data'];
                    $filename = date('Ymdhis').'.'.getFileTypeFromWaBot($media['mimetype']);
                    $log = $this->maxchatlibrary->replyImage([
                        'image' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($data->caption) ? $data->caption : "mengirimkan Anda gambar", 
                        'filename' => date('Ymdhis').'.'.getFileTypeFromWaBot($media['mimetype']),
                        'to' => $sender['sender']
                    ]);
                }
            }

            $response['text'] = $reply;
            $response['to'] = $sendTo;
            $response['log'] = $log;
    
            $this->general->saveLogWebhook(json_encode($result), json_encode($response));
        }
    }

    public function chatHelpdeskSiladen($result, $data){
        $reply = null;
        $sendTo = $data->sender;
        
        if(isset($data->originalId)){
            if($data->type == "image"){
                $ori = json_decode($this->maxchatlibrary->getMessageById($data->originalId), true);
                $explode = explode("\n", $ori['text']);
                $chatId = $explode[1];
            } else if ($data->type == "text"){
                $explode = explode("\n", $data->originalMsg->text);
                $chatId = $explode[1];
            }
            $sender = $this->general->getOne('t_log_webhook', 'chat_id', $chatId, 0);
            if($sender){
                $sendTo = $sender['sender'];
                if($data->type == "image"){
                    $reply = $data->thumbnail;
                    $log = $this->maxchatlibrary->replyImage([
                        'image' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($data->caption) ? $data->caption : "mengirimkan Anda gambar", 
                        'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                        'to' => WA_BOT
                    ]);
                } else if($data->type == "document"){
                    $reply = $data->thumbnail;
                    $log = $this->maxchatlibrary->replyFile([
                        'file' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($data->caption) ? $data->caption : "mengirimkan Anda dokumen", 
                        'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                        'to' => WA_BOT
                    ]);
                } else if ($data->type == "text"){
                    $reply = $data->text;
                    if($reply != null && $reply != ""){
                        $reply .= "\n";
                        $log = $this->maxchatlibrary->replyText($sender['sender'], $reply, $chatId);
                    }
                }
        
                $response['text'] = $reply;
                $response['to'] = $sendTo;
                $response['log'] = $log;
        
                $this->general->saveLogWebhook(json_encode($result), json_encode($response));
            }
        }
    }

    public function chatBotLayanan($result, $data){
        $reply = null;
        $sendTo = $data->sender;

        $pegawai = null;
        // $nohp = "0".substr($data->sender, 2);
        $ws = $this->dokumenlib->getPegawaiSiladen($data->sender);
        if($ws){
            $resp = json_decode($ws['response'], true);
            if($resp['code'] == 200){
                $pegawai = $resp['data'];
            }
        }
        if(!$pegawai){
            $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$data->sender." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        }
        if($reply == null){
            $pegawai_simpeg = $this->user->getProfilUserByNip($pegawai['username']);
            $explode = explode("_", $data->text);
            if(strcasecmp($data->text, "#info") == 0 || strcasecmp($data->text, "tabea") == 0){
                $reply = "Selamat Datang ".$data->senderName.
                " Silahkan memilih jenis layanan melalui perintah di bawah ini: \n\n".
                "1. *#cek_profil*: untuk melihat data pegawai yang terdaftar dengan nomor HP ini. \n\n".
                "2. *#rekap_absensi_(bulan)_(tahun)*: untuk melihat rekapan absensi SKPD pada bulan dan tahun yang Anda pilih. \nContoh: #rekap_absensi_07_2023 adalah untuk melihat rekap absensi pada bulan Juli tahun 2023 \n\n";
            } else if(strcasecmp("#", substr($data->text, 0, 1)) == 0 && count($explode) > 1){
                // count($explode) > 1
                if($explode[0] == '#rekap'){
                    $aksespegawai = $this->m_user->cekAksesPegawaiRekapAbsen($pegawai_simpeg['nipbaru_ws']);
                    if($aksespegawai){
                        if(count($explode) != 4){
                            $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                        } else {
                            if(is_numeric($explode[2]) && is_numeric($explode[3])){
                                if(checkIfValidDate($explode[2], $explode[3])){
                                    $data_cron = [
                                        'id_unitkerja' => $pegawai_simpeg['skpd'],
                                        'no_hp' => $data->sender,
                                        'bulan' => $explode[2],
                                        'tahun' => $explode[3],
                                        'created_by' => $aksespegawai['id_m_user']
                                    ];
                                    $this->rekap->saveToCronRekapAbsen($data_cron);
                                    $this->rekap->cronRekapAbsen();
                                } else {
                                    $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan Bulan dan Tahun yang tidak melewati tanggal berjalan.";
                                }
                            } else {
                                $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format bulan dan tahun yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                            }
                        }
                    } else {
                        $reply = "Mohon maaf, layanan ini hanya tersedia bagi Kepala Sub Bagian Umum dan Kepegawaian Perangkat Daerah masing-masing.";
                    }
                } else if ($explode[0] == '#cek' && $explode[1] == 'profil'){
                    $pegawai = $this->user->getProfilUserByNoHp($data->sender);
                    if($pegawai){
                        $reply = "Pegawai dengan Nomor HP ".$data->sender." sudah terdaftar dengan data sebagai berikut. \nUnit Kerja: ".$pegawai['nm_unitkerja'].". \nNama: ".getNamaPegawaiFull($pegawai)." \nNIP: ".formatNip($pegawai['nipbaru_ws']);
                    } else {
                        $reply = "Pegawai dengan Nomor HP ".$data->sender." belum terdaftar.";
                    }
                }
            }
        }

        if($reply == null || $reply == ""){
            $sendTo = GROUP_CHAT_HELPDESK;
            $reply = $data->senderName."\n".$data->id."\n\n".$data->text;
        }

        if($reply != null && $reply != ""){
            $reply .= "\n";
            $log = $this->maxchatlibrary->sendText($sendTo, $reply);
        }

        $response['text'] = $reply;
        $response['to'] = $sendTo;
        $response['log'] = $log;

        $this->general->saveLogWebhook(json_encode($result), json_encode($response));
    }

    public function sendMessage($id){
        $kasubagkepeg = $this->m_user->cekAksesPegawaiRekapAbsen($id);
        dd($kasubagkepeg);
    }

}
