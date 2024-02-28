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
        $this->general->updateCronWa($result);
        if (($result->type == "text" || $result->type == "image") && 
            $result->chatType != "story" &&
            $result->from != GROUP_CHAT_HELPDESK && !isset($result->replyId)) {
                $this->chatBotLayanan($result);
        } else if($result->to == GROUP_CHAT_HELPDESK){
            // if(!isset($result->replyId)){
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

        if(isset($result->replyId)){
            // if($result->type == "image"){
            //     $ori = json_decode($this->maxchatlibrary->getMessageById($result->originalId), true);
            //     $explode = explode("\n", $ori['text']);
            //     $chatId = $explode[1];
            // }
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
    
            // $this->general->saveLogWebhook(json_encode($result), json_encode($response));
        }
    }

    public function chatHelpdeskSiladen($result){
        $reply = null;
        $sendTo = $result->from;
        $chatId = 0;
        if(isset($result->replyId)){
            if($result->type == "image"){
                $ori = json_decode($this->maxchatlibrary->getMessageById($result->originalId), true);
                $explode = explode("\n", $ori['text']);
                $chatId = $explode[1];
            } else if ($result->type == "text"){
                $reply = $result->text;
                $ori = json_decode($this->maxchatlibrary->getMessageById($result->replyId), true);
                if($ori){
                    $explode = explode("\n", $ori['data']['text']);
                    $chatId = $explode[2];
                }
            }
            $sender = json_decode($this->maxchatlibrary->getMessageById($chatId), true);
            if($sender){
                $sendTo = $sender['data']['from'];
                // if($result->type == "image"){
                //     $reply = $result->thumbnail;
                //     $log = $this->maxchatlibrary->replyImage([
                //         'image' => $reply, 
                //         'url' => "http://someweb.com/image.png",
                //         'caption' => isset($result->caption) ? $result->caption : "mengirimkan Anda gambar", 
                //         'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                //         'to' => WA_BOT
                //     ]);
                // } else if($result->type == "document"){
                //     $reply = $result->thumbnail;
                //     $log = $this->maxchatlibrary->replyFile([
                //         'file' => $reply, 
                //         'url' => "http://someweb.com/image.png",
                //         'caption' => isset($result->caption) ? $result->caption : "mengirimkan Anda dokumen", 
                //         'filename' => date('Ymdhis').'.'.getBase64FileType($reply),
                //         'to' => WA_BOT
                //     ]);
                // } else 
                if ($result->type == "text"){
                    $reply = $result->text;
                    if($reply != null && $reply != ""){
                        $reply .= "\n";
                        // $log = $this->maxchatlibrary->sendText($sender['data']['from'], trim($reply), $sender['data']['id']);
                        $cronWa = [
                            'sendTo' => $sender['data']['from'],
                            'message' => trim($reply),
                            'replyId' => $sender['data']['id'],
                            'type' => 'text'
                        ];
                        $this->general->saveToCronWa($cronWa);
                    }
                }
        
                // $response['text'] = $reply;
                // $response['to'] = $sendTo;
                // $response['log'] = $log;
        
                // $this->general->saveLogWebhook(json_encode($result), json_encode($response));
            }
        }
    }

    public function chatBotLayanan($result){
        $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        $sendTo = $result->from;

        $pegawai = null;
        $ws = $this->user->getProfilUserByNoHp($result->from);
        if($ws){
            $reply = NULL;
            $pegawai = $ws;
        } else {
            $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        }
        if(!$pegawai){
            $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$result->from." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
        }
        if($reply == null){
            $pegawai_simpeg = $this->user->getProfilUserByNip($pegawai['username']);
            $explode = explode("_", $result->text);
            if(strcasecmp($result->text, "info") == 0 || strcasecmp($result->text, "tabea") == 0 || strcasecmp($result->text, "halo") == 0 || strcasecmp($result->text, "hai") == 0){
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
                                    if($pegawai_simpeg['skpd'] == 3027000){
                                        $reply = "Mohon maaf, untuk sementara absensi Dinas Kebakaran belum bisa ditarik secara otomatis dari sistem. Silahkan menghubungi BKPSDM untuk melakukan penarikan absen secara manual.";
                                    } else {
                                        $data_cron = [
                                            'id_unitkerja' => $pegawai_simpeg['skpd'],
                                            'no_hp' => $result->from,
                                            'bulan' => clearString($explode[2]),
                                            'tahun' => clearString($explode[3]),
                                            'created_by' => $aksespegawai['id_m_user']
                                        ];
                                        $this->rekap->saveToCronRekapAbsen($data_cron);
                                        $this->rekap->cronRekapAbsen();
                                    }
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
                if($result->type == "text"){
                    $reply = getNamaPegawaiFull($pegawai_simpeg)."\n".$pegawai_simpeg['nipbaru_ws']."\n".$result->id."\n\n".$result->text;
                } else {
                    $reply = getNamaPegawaiFull($pegawai_simpeg)."\n".$pegawai_simpeg['nipbaru_ws']."\n".$result->id."\n\n".$result->caption;
                }
            } else {
                $reply = $result->fromName."\n".$result->id."\n\n".$result->text;
            }
        }

        if($reply != null && $reply != ""){
            if($result->type == "text"){
                // $log = $this->maxchatlibrary->sendText($sendTo, $reply);
                $cronWa = [
                    'sendTo' => $sendTo,
                    'message' => $reply,
                    'type' => 'text'
                ];
                $this->general->saveToCronWa($cronWa);
            } else if($result->type == "image"){
                $filename = explode("/", $str);
                $log = $this->maxchatlibrary->sendImg($sendTo, $reply, $filename[5], $result->url);
                // $this->general->insert('t_chat_group', [
                //     'text' => json_encode($filename)
                // ]);
            }
        }

        // $response['text'] = $reply;
        // $response['to'] = $sendTo;
        // $response['log'] = $log;

        // $this->general->saveLogWebhook(json_encode($result), json_encode($response));
    }

    public function sendMessage($id){
        // $str = "https://core.maxchat.id/bkdmdo/download/3EB00C36EF71C52A66B404.jpeg";
        // dd(explode("/", $str)[5]);
        // $result = null;
        // $data = new \stdClass();
        // $data->from = $id;
        // $data->text = '#rekap_absen_07_2023';
        // $this->chatBotLayanan($result, $data);
        // dd(!isset($data->asd));
        // dd(property_exists($data, 'asd'));
        // $pegawai = null;
        $ws = $this->dokumenlib->getPegawaiSiladen($id);
        dd($ws);
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

    public function runCronRekapAbsen(){
        $this->rekap->cronRekapAbsen(1);
    }

}
