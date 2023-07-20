<?php

class C_Maxchat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('user/M_User', 'user');
        // $this->load->library('MaxchatLibrary', 'maxchat');
    }

    public function webhook(){
        $result = $this->maxchatlibrary->webhookCapture();
        $data = $result->data;
        
        // balas pengirim dg teksnya sendiri, khusus jenis pesan teks
        if ($result->event == "new" && $result->type == "message" && $data->type == "text" && $data->fromMe == false) {
            // $this->maxchatlibrary->sendText($data->sender, $data->text);
            $reply = null;
            $explode = explode("_", $data->text);
            if(strcasecmp($data->text, "#info") == 0 || strcasecmp($data->text, "tabea") == 0){
                $reply = "Selamat Datang ".$data->senderName.
                " Silahkan memilih jenis layanan melalui perintah di bawah ini: \n\n".
                "1. *#cek_profil*: untuk melihat data pegawai yang terdaftar dengan nomor HP ini. \n\n".
                "2. *#rekap_absensi_(bulan)_(tahun)*: untuk melihat rekapan absensi SKPD pada bulan dan tahun yang Anda pilih. \nContoh: #rekap_absensi_07_2023 adalah untuk melihat rekap absensi pada bulan Juli tahun 2023 \n\n";

            } else if(count($explode) > 1){
                if($explode[0] == '#rekap'){
                    if(count($explode) != 4){
                        $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                    } else {
                        if(is_numeric($explode[2]) && is_numeric($explode[3])){
                            $reply = "Rekap Absensi Bulan ".getNamaBulan($explode[2])." Tahun ".$explode[3];
                        } else {
                            $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format bulan dan tahun yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                        }
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

            if($reply != null && $reply != ""){
                $this->maxchatlibrary->sendText($data->sender, $reply);
            }

            $response['text'] = $reply;
            $response['to'] = $data->sender;

            $this->m_general->saveLogWebhook(json_encode($result), json_encode($response));
        }
    }

    public function sendMessage($nomor){
        $pegawai = $this->user->getProfilUserByNoHp($nomor);
        dd($pegawai);
    }


}
