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
        $this->general->insert('t_chat_group', [
            'text' => json_encode($result)
        ]);
        if ($result->type == "text" && 
            $result->chatType != "story" &&
            $result->from != GROUP_CHAT_HELPDESK) {
                $this->chatBotLayanan($result);
        } else if($result->from == GROUP_CHAT_HELPDESK){
            // if(!isset($result->originalMsg)){
            //     $this->forwardToPegawai($result);
            // } else {
                $this->chatHelpdeskSiladen($result);
            // }
        }
    }

    public function forwardToPegawai($result){
        $reply = null;
        $sendTo = $result->from;
        $log = null;

        if(isset($result->originalId)){
            if($result->type == "image"){
                $ori = json_decode($this->maxchatlibrary->getMessageById($result->originalId), true);
                $explode = explode("\n", $ori['text']);
                $chatId = $explode[1];
            }
            $sender = $this->general->getOne('t_log_webhook', 'chat_id', $chatId, 0);
            if($sender){
                $media = json_decode($this->maxchatlibrary->getMessageMediaById($result->id), true);
                $sendTo = $sender['sender'];
                if($media){
                    $reply = "data:".$media['mimetype'].";base64,".$media['data'];
                    $filename = date('Ymdhis').'.'.getFileTypeFromWaBot($media['mimetype']);
                    $log = $this->maxchatlibrary->replyImage([
                        'image' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($result->caption) ? $result->caption : "mengirimkan Anda gambar", 
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

    public function chatHelpdeskSiladen($result){
        $reply = null;
        $sendTo = $result->from;
        
        if(isset($result->originalId)){
            if($result->type == "image"){
                $ori = json_decode($this->maxchatlibrary->getMessageById($result->originalId), true);
                $explode = explode("\n", $ori['text']);
                $chatId = $explode[1];
            } else if ($result->type == "text"){
                $explode = explode("\n", $result->originalMsg->text);
                $chatId = $explode[2];
            }
            $sender = $this->general->getOne('t_log_webhook', 'chat_id', $chatId, 0);
            if($sender){
                $sendTo = $sender['sender'];
                if($result->type == "image"){
                    $reply = $result->thumbnail;
                    $log = $this->maxchatlibrary->replyImage([
                        'image' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($result->caption) ? $result->caption : "mengirimkan Anda gambar", 
                        'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                        'to' => WA_BOT
                    ]);
                } else if($result->type == "document"){
                    $reply = $result->thumbnail;
                    $log = $this->maxchatlibrary->replyFile([
                        'file' => $reply, 
                        'url' => "http://someweb.com/image.png",
                        'caption' => isset($result->caption) ? $result->caption : "mengirimkan Anda dokumen", 
                        'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                        'to' => WA_BOT
                    ]);
                } else if ($result->type == "text"){
                    $reply = $result->text;
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

    public function chatBotLayanan($result){
        $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        $sendTo = $result->from;

        $pegawai = null;
        // $nohp = "0".substr($result->from, 2);
        $ws = $this->dokumenlib->getPegawaiSiladen($result->from);
        if($ws){
            $resp = json_decode($ws['response'], true);
            if($resp['code'] == 200){
                $pegawai = $resp['data'];
                $reply = null;
            }
            else {
                $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
            }
        } else {
            $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        }
        if(!$pegawai){
            $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        }
        if($reply == null){
            $pegawai_simpeg = $this->user->getProfilUserByNip($pegawai['username']);
            $explode = explode("_", $result->text);
            if(strcasecmp($result->text, "#info") == 0 || strcasecmp($result->text, "tabea") == 0){
                $reply = "Selamat Datang ".getNamaPegawaiFull($pegawai_simpeg).
                ", Silahkan memilih jenis layanan melalui perintah di bawah ini: \n\n".
                "1. *#cek_profil*: untuk melihat data pegawai yang terdaftar dengan nomor HP ini. \n\n".
                "2. *#rekap_absensi_(bulan)_(tahun)*: untuk melihat rekapan absensi SKPD pada bulan dan tahun yang Anda pilih. \nContoh: #rekap_absensi_07_2023 adalah untuk melihat rekap absensi pada bulan Juli tahun 2023 \n\n";
            } else if(substr($result->text, 0, 1) == "#" && count($explode) > 1){
                if(strcasecmp($explode[0], "#rekap") == 0 && strcasecmp($explode[1], "absensi") == 0){
                    $aksespegawai = $this->m_user->cekAksesPegawaiRekapAbsen($pegawai_simpeg['nipbaru_ws']);
                    if($aksespegawai){
                        if(count($explode) != 4){
                            $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                        } else {
                            if(is_numeric($explode[2]) && is_numeric($explode[3])){
                                if(checkIfValidDate($explode[2], $explode[3])){
                                    $data_cron = [
                                        'id_unitkerja' => $pegawai_simpeg['skpd'],
                                        'no_hp' => $result->from,
                                        'bulan' => clearString($explode[2]),
                                        'tahun' => clearString($explode[3]),
                                        'created_by' => $aksespegawai['id_m_user']
                                    ];
                                    $this->rekap->saveToCronRekapAbsen($data_cron);
                                    $this->rekap->cronRekapAbsen();
                                } else {
                                    $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan Bulan dan Tahun yang tidak melewati Bulan dan Tahun berjalan.";
                                }
                            } else {
                                $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format bulan dan tahun yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                            }
                        }
                    } else {
                        $reply = "Mohon maaf, Anda tidak memiliki akses untuk menggunakan layanan ini. Layanan ini hanya tersedia bagi Kasubag Umum & Kepeg masing-masing PD, Lurah, Kepala Sekolah, Kepala TK dan pegawai yang diberikan tugas khusus untuk melakukan rekap absensi.";
                    }
                } else if ($explode[0] == '#cek' && $explode[1] == 'profil'){
                    $pegawai = $this->user->getProfilUserByNoHp($result->from);
                    if($pegawai){
                        $reply = "Pegawai dengan Nomor HP ".$result->from." sudah terdaftar dengan data sebagai berikut. \nUnit Kerja: ".$pegawai['nm_unitkerja'].". \nNama: ".getNamaPegawaiFull($pegawai)." \nNIP: ".formatNip($pegawai['nipbaru_ws']);
                    } else {
                        $reply = "Pegawai dengan Nomor HP ".$result->from." belum terdaftar.";
                    }
                }
            }
        } 
        if($reply == null || $reply == ""){
            $sendTo = GROUP_CHAT_HELPDESK;
            if($pegawai_simpeg){
                $reply = getNamaPegawaiFull($pegawai_simpeg)."\n".$pegawai_simpeg['nipbaru_ws']."\n".$result->id."\n\n".$result->text;
            } else {
                $reply = $result->fromName."\n".$result->id."\n\n".$result->text;
            }
        }

        if($reply != null && $reply != ""){
            $log = $this->maxchatlibrary->sendText($sendTo, $reply);
        }

        $response['text'] = $reply;
        $response['to'] = $sendTo;
        $response['log'] = $log;

        $this->general->saveLogWebhook(json_encode($result), json_encode($response));
    }

    public function sendMessage($id){
        // $result = null;
        // $data = new \stdClass();
        // $data->from = $id;
        // $data->text = '#rekap_absen_07_2023';
        // $this->chatBotLayanan($result, $data);
        // dd(!isset($data->asd));
        // dd(property_exists($data, 'asd'));
        $pegawai = null;
        $ws = $this->dokumenlib->getPegawaiSiladen($id);
        if($ws){
            $resp = json_decode($ws['response'], true);
            if($resp['code'] == 200){
                $pegawai = $resp['data'];
            }
        }
        $pegawai_simpeg = $this->user->getProfilUserByNip($pegawai['username']);
        $aksespegawai = $this->m_user->cekAksesPegawaiRekapAbsen($pegawai_simpeg['nipbaru_ws']);
        dd($aksespegawai);
    }

}
