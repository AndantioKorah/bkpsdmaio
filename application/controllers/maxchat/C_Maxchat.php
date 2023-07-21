<?php

class C_Maxchat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'm_general');
        $this->load->model('rekap/M_Rekap', 'rekap');
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

            $pegawai = $this->user->getProfilUserByNoHp($data->sender);
            if(!$pegawai){
                $reply = "Layanan ini hanya tersedia bagi ASN Pemerintah Kota Manado. Nomor HP ".$data->sender." belum terdaftar. Silahkan update data Nomor HP dengan menggunakan Aplikasi Siladen.";
            }
            if($reply == null){
                $explode = explode("_", $data->text);
                if(strcasecmp($data->text, "#info") == 0 || strcasecmp($data->text, "tabea") == 0){
                    $reply = "Selamat Datang ".$data->senderName.
                    " Silahkan memilih jenis layanan melalui perintah di bawah ini: \n\n".
                    "1. *#cek_profil*: untuk melihat data pegawai yang terdaftar dengan nomor HP ini. \n\n".
                    "2. *#rekap_absensi_(bulan)_(tahun)*: untuk melihat rekapan absensi SKPD pada bulan dan tahun yang Anda pilih. \nContoh: #rekap_absensi_07_2023 adalah untuk melihat rekap absensi pada bulan Juli tahun 2023 \n\n";

                } else if(count($explode) > 1){
                    if($explode[0] == '#rekap'){
                        $kasubagkepeg = $this->m_user->checkIfKasubagKepeg($pegawai['nipbaru_ws']);
                        if($kasubagkepeg){
                            if(count($explode) != 4){
                                $reply = "Mohon maaf, permintaan Anda tidak dapat diproses. Harap menggunakan format yang ditentukan. \nKetik '#info' untuk melihat pilihan yang tersedia.";
                            } else {
                                if(is_numeric($explode[2]) && is_numeric($explode[3])){
                                    $reply = "Permintaan Anda untuk Rekap Absensi ".$pegawai['nm_unitkerja']." Bulan ".getNamaBulan($explode[2])." Tahun ".$explode[3].' akan dikirimkan. Mohon menunggu.';
                                    $data_cron = [
                                        'id_unitkerja' => $pegawai['skpd'],
                                        'no_hp' => $data->sender,
                                        'bulan' => $explode[2],
                                        'tahun' => $explode[3],
                                        'created_by' => $kasubagkepeg['id_m_user']
                                    ];
                                    $this->rekap->saveToCronRekapAbsen($data_cron);
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
                } else {
                    // $reply = "Mohon maaf, permintaan Anda belum tersedia.";
                }
            }

            if($reply != null && $reply != ""){
                $reply .= "\n";
                $this->maxchatlibrary->sendText($data->sender, $reply);
            }

            $response['text'] = $reply;
            $response['to'] = $data->sender;

            $this->m_general->saveLogWebhook(json_encode($result), json_encode($response));
        }
    }

    public function sendMessage($param){
        $pegawai = $this->user->checkIfKasubagKepeg($param);
        dd($pegawai);
    }


}
