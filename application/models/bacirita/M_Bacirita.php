<?php
class M_Bacirita extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('simata/M_Simata', 'simata');
        // $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function loadListKegiatan(){
        return $this->db->select('a.*, c.nama_tipe_kegiatan, a.id as id_kegiatan')
                    ->from('db_bacirita.t_kegiatan a')
                    ->join('m_user b', 'a.created_by = b.id')
                    ->join('db_bacirita.m_tipe_kegiatan c', 'a.id_m_tipe_kegiatan = c.id')
                    ->order_by('a.tanggal', 'desc')
                    ->where('a.flag_active', 1)
                    ->get()->result_array();
    }

    public function saveDataKegiatan($data){
        $res = [
            'code' => 0,
            'message' => null
        ];

        $data['topik'] = trim($data['topik']);
        $data['link_url'] = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $data['topik']);
        $data['link_url'] = strtolower(str_replace(" ", "-", $data['link_url']));

        if(!$data['jam_mulai']){
            $res['message'] = "Jam Mulai belum diinput";
        }

        if(!isset($data['chck_selesai']) && !$data['jam_selesai']){
            $res['message'] = "Jam Selesai belum diinput";
        }

        if(isset($data['chck_selesai']) && $data['chck_selesai'] == "on"){
            unset($data['chck_selesai']);
            $data['jam_selesai'] = 0;
        }

        if(!$data['jam_batas_absensi']){
            $res['message'] = "Jam Batas Absensi belum diinput";
        }

        if(!$data['jam_buka_absensi']){
            $res['message'] = "Jam Buka Absensi belum diinput";
        }

        if(!$data['jam_batas_pendaftaran']){
            $res['message'] = "Jam Batas Pendaftaran belum diinput";
        }

        $data['id_m_tipe_kegiatan'] = $data['tipe_kegiatan'];
        unset($data['tipe_kegiatan']);
        $data['created_by'] = $this->general_library->getId();
        
        $target_dir = 'arsipbkpsdmbacirita/banner_kegiatan/';
        
        // dd($this->input->post());
        // dd($_FILES['file']['name']);
        $nama_file = str_replace(' ', '',$_FILES['file']['name']); 

        if($_FILES['file']['name'] != ""){
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = $nama_file;

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('file')) {
                $data['error']    = strip_tags($this->upload->display_errors());
                $res['code'] = 1;
                $res['message'] = "Terjadi Kesalahan";
                return $res;

            } else {
                $dataFile 			= $this->upload->data();
                $data['url_banner'] = $target_dir.$nama_file;

            }
            $this->insert('db_bacirita.t_kegiatan', $data);
        } else {
            $this->insert('db_bacirita.t_kegiatan', $data);
        }
        return $res;
    }

    public function inputDefaultCoordinateSertifikat($data = null, $id = null){
        if(!$data){
            $data = $this->db->select('*')
                        ->from('db_bacirita.t_kegiatan')
                        ->where('id', $id)
                        ->get()->row_array();
        }

        if(!$data['meta_coordinate'] && $data['template_sertifikat']){
            $contentQr = trim(base_url('login'), generateRandomString());
    		$res['qr'] = generateQr($contentQr);
            
            $meta = [
                'url_template' => base_url('arsipbkpsdmbacirita/sertifikat/'.$data['template_sertifikat']),
                'nomor_surat' => [
                    'flag_show' => 1,
                    'content' => "*nomor_surat*",
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'font-size' => "4",
                ],
                'nama_lengkap' => [
                    'flag_show' => 1,
                    'content' => "*nama_pegawai*",
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'font-size' => "4",
                ],
                'nip' => [
                    'flag_show' => 1,
                    'content' => "*nip_pegawai*",
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'font-size' => "4",
                ],
                'jabatan' => [
                    'flag_show' => 1,
                    'content' => "*jabatan_pegawai*",
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'font-size' => "4",
                ],
                'unit_kerja' => [
                    'flag_show' => 1,
                    'content' => "*unit_kerja_pegawai*",
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'font-size' => "4",
                ],
                'qr' => [
                    'flag_show' => 1,
                    'src' => $res['qr'],
                    'margin-top' => "0",
                    'margin-left' => "0",
                    'width' => 200,
                ],
            ];

            $this->db->where('id', $data['id'])
                    ->update('db_bacirita.t_kegiatan', [
                        'meta_coordinate' => json_encode($meta)
                    ]);
        }
    }

    public function toggleFieldPreview($field, $flag_show, $id){
        $data = $this->db->select('*')
                                ->from('db_bacirita.t_kegiatan')
                                ->where('id', $id)
                                ->get()->row_array();

        $meta = json_decode($data['meta_coordinate'], true);
        $meta[$field]['flag_show'] = $flag_show;

        $this->db->where('id', $id)
                ->update('db_bacirita.t_kegiatan', [
                    'meta_coordinate' => json_encode($meta),
                    'updated_by' => $this->general_library->getId()
                ]);

        $data['result'] = $meta;
        $this->regeneratePreviewSertifikat($data);

        return ['code' => 0, 'message' => 'ok'];
    }

    public function regeneratePreviewSertifikat($data, $id = ""){
        if(!isset($data['template_sertifikat'])){
            $res = $this->db->select('*')
                            ->from('db_bacirita.t_kegiatan')
                            ->where('id', $id)
                            ->get()->row_array();

            $data['template_sertifikat'] = $res['template_sertifikat'];
        }
        $explode = explode(".", $data['template_sertifikat']);
        $inputFile = $data['template_sertifikat'];
        $previewFile = "arsipbkpsdmbacirita/sertifikat/".$explode[0]."_preview.pdf";
        if(file_exists(base_url($previewFile))){
            unlink(base_url($previewFile));
        }
        $html = $this->load->view('bacirita/V_TemplateSertifikatBkpsdmBacirita', $data, true);
        $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
        $this->mpdf->AddPage(
            'L', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            0, // margin_left
            0, // margin right
            0, // margin top
            0, // margin bottom
            0, // margin header
            12
        ); 

        $this->mpdf->WriteHTML($html);
        foreach($data['result'] as $k => $v){
            if($k != "url_template"){
                if($v['flag_show'] == 1){
                    $this->mpdf->setY($v['margin-top']);
                    if($k != "qr"){
                        if($v['margin-left'] == 0){
                            $this->mpdf->writeHtml("<p style='
                                font-family: Tahoma;
                                text-align: center;
                                font-size: ".$v['font-size'].";
                            '>".$v['content']."</p>");
                        } else {
                            $this->mpdf->setX($v['margin-left']);
                            $this->mpdf->writeHtml("<p style='
                                font-family: Tahoma;
                                font-size: ".$v['font-size'].";
                            '>".$v['content']."</p>");
                        }
                    } else {
                        $this->mpdf->writeHtml(
                            "<p style='text-align: center;'><img style='
                                width: ".$v['width']."px;
                            ' src='".$v['src']."' /></p>"
                        );
                    }
                }
            }
        }
        $this->mpdf->showImageErrors = true;
        $this->mpdf->OutputFile($previewFile);
    }

    public function generatePreviewSertifikat($data = null, $id = null){
        if(!$data){
            $data = $this->db->select('*')
                        ->from('db_bacirita.t_kegiatan')
                        ->where('id', $id)
                        ->get()->row_array();
        }

        if($data['template_sertifikat']){
            $explode = explode(".", $data['template_sertifikat']);
            $inputFile = $data['template_sertifikat'];
            $previewFile = "arsipbkpsdmbacirita/sertifikat/".$explode[0]."_preview.pdf";
            if(file_exists(base_url($previewFile))){
                unlink(base_url($previewFile));
            }
            $outputFile = $previewFile;
            $data['meta_coordinate'] = json_decode($data['meta_coordinate'], true);

            $data['meta_coordinate']['url_template'] = $inputFile;
            $result['result'] = $data['meta_coordinate'];
            $result['result']['url_template'] = $inputFile;

            $html = $this->load->view('bacirita/V_TemplateSertifikatBkpsdmBacirita', $result, true);
            $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
            $this->mpdf->AddPage(
                'L', // L - landscape, P - portrait
                '',
                '',
                '',
                '',
                0, // margin_left
                0, // margin right
                0, // margin top
                0, // margin bottom
                0, // margin header
                12
            ); 

            $this->mpdf->WriteHTML($html);
            foreach($result['result'] as $k => $v){
                if($k != "url_template"){
                    if($v['flag_show'] == 1){
                        $this->mpdf->setX($v['margin-left']);
                        $this->mpdf->setY($v['margin-top']);
                        if($k != "qr"){
                            $this->mpdf->writeHtml("<p style='
                                font-family: Tahoma;
                                text-align: center;
                                font-size: ".$v['font-size'].";
                            '>".$v['content']."</p>");
                        } else {
                            $this->mpdf->writeHtml(
                                "<p style='text-align: center;'><img style='
                                    width: ".$v['width']."px;
                                ' src='".$v['src']."' /></p>"
                            );
                        }
                    }
                }
            }
            $this->mpdf->showImageErrors = true;
            $this->mpdf->OutputFile($outputFile);
        }
    }

    public function modalLoadDetailKegiatan($id){
        $data = $this->db->select('a.*, c.nama_tipe_kegiatan')
                    ->from('db_bacirita.t_kegiatan a')
                    ->join('m_user b', 'a.created_by = b.id')
                    ->join('db_bacirita.m_tipe_kegiatan c', 'a.id_m_tipe_kegiatan = c.id')
                    ->order_by('a.created_date', 'desc')
                    ->where('a.id', $id)
                    ->where('a.flag_active', 1)
                    ->get()->row_array();

        if(!$data['meta_coordinate'] && $data['template_sertifikat']){
            $this->inputDefaultCoordinateSertifikat($data);
            $this->generatePreviewSertifikat($data);
        }
        return $data;
    }


    public function editDataKegiatan($data){
        $res = [
            'code' => 0,
            'message' => null
        ];

        $id = $data['id_kegiatan'];
        unset($data['id_kegiatan']);
        $data['topik'] = trim($data['topik']);
        $data['link_url'] = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $data['topik']);
        $data['link_url'] = strtolower(str_replace(" ", "-", $data['link_url']));

        if(!$data['jam_mulai']){
            $res['message'] = "Jam Mulai belum diinput";
        }

        if(!isset($data['chck_selesai']) && !$data['jam_selesai']){
            $res['message'] = "Jam Selesai belum diinput";
        }

        if(isset($data['chck_selesai']) && $data['chck_selesai'] == "on"){
            unset($data['chck_selesai']);
            $data['jam_selesai'] = 0;
        }

        if(!$data['jam_batas_absensi']){
            $res['message'] = "Jam Batas Absensi belum diinput";
        }

        if(!$data['jam_buka_absensi']){
            $res['message'] = "Jam Buka Absensi belum diinput";
        }

        if(!$data['jam_batas_pendaftaran']){
            $res['message'] = "Jam Batas Pendaftaran belum diinput";
        }

        $data['id_m_tipe_kegiatan'] = $data['tipe_kegiatan'];
        unset($data['tipe_kegiatan']);
        $data['created_by'] = $this->general_library->getId();
        
        $target_dir = 'arsipbkpsdmbacirita/banner_kegiatan/';
        
        $nama_file = str_replace(' ', '',$_FILES['file']['name']); 

        if($_FILES['file']['name'] != ""){

            $banner_lama = $this->db->select('a.url_banner')
                    ->from('db_bacirita.t_kegiatan a')
                    ->where('a.id', $id)
                    ->where('a.flag_active', 1)
                    ->get()->row_array();
            if($banner_lama['url_banner']){
            unlink($banner_lama['url_banner']);
            }
            
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = $nama_file;

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('file')) {
                $data['error']    = strip_tags($this->upload->display_errors());
                $res['code'] = 1;
                $res['message'] = "Terjadi Kesalahan";
                return $res;

            } else {
                $dataFile 			= $this->upload->data();
                 $data['url_banner'] = $target_dir.$nama_file;

            }

            $this->db->where('id', $id)
                    ->update('db_bacirita.t_kegiatan', $data);

        
        } else {
            $this->db->where('id', $id)
                    ->update('db_bacirita.t_kegiatan', $data);
        }
        return $res;
    }

    public function loadDetailWebinar($id){
        return $this->db->select('a.*, d.flag_absen, c.nama_tipe_kegiatan, a.id as id_kegiatan, d.id as id_daftar')
                    ->from('db_bacirita.t_kegiatan a')
                    ->join('m_user b', 'a.created_by = b.id')
                    ->join('db_bacirita.m_tipe_kegiatan c', 'a.id_m_tipe_kegiatan = c.id')
                    ->join('db_bacirita.t_peserta_kegiatan d', '(a.id = d.id_t_kegiatan  and d.id_m_user = "'.$this->general_library->getId().'" and d.flag_active = 1)', 'left')
                    ->order_by('a.created_date', 'desc')
                    ->where('a.flag_active', 1)
                    ->where('a.id', $id)
                    ->get()->row_array();
    }

    public function submitDaftarKegiatan($id_kegiatan,$id_m_user){
        $res['code'] = 0;
        $res['message'] = 'Pendaftaran Webinar Berhasil';
        $res['success'] = true;

        $datapost = $this->input->post();
        $this->db->trans_begin();
       
        $data["id_t_kegiatan"] = $id_kegiatan;
        $data["id_m_user"] = $id_m_user;

        $this->insert('db_bacirita.t_peserta_kegiatan', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['success'] = false;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

     public function presensiKegiatan($id_kegiatan,$id_m_user){
        $res['code'] = 0;
        $res['message'] = 'Presensi Webinar Berhasil';
        $res['success'] = true;

        $datapost = $this->input->post();
        $this->db->trans_begin();
     
        $data["flag_absen"] = 1;
        $this->db->where('id_t_kegiatan', $id_kegiatan)
                 ->where('id_m_user', $id_m_user)
                 ->update('db_bacirita.t_peserta_kegiatan', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['success'] = false;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

     public function updloadTemplateSertifikat($data){
        $res = [
            'code' => 0,
            'message' => null
        ];

        $id = $data['id_kegiatan_template'];
        $target_dir = 'arsipbkpsdmbacirita/sertifikat/';
        $nama_file = str_replace(' ', '',$_FILES['file']['name']); 
        if($_FILES['file']['name'] != ""){
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = $nama_file;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                $data['error']    = strip_tags($this->upload->display_errors());
                $res['code'] = 1;
                $res['message'] = "Terjadi Kesalahan";
                return $res;

            } else {
                $dataFile 			= $this->upload->data();
                $dataUpdate['template_sertifikat'] = $nama_file;
                $this->db->where('id', $id)
                    ->update('db_bacirita.t_kegiatan', $dataUpdate);
            }
        } 
        return $res;
    }

    public function saveCoordinateSertifikat($id){
        $data['result'] = $this->input->post();
        $kegiatan = $this->db->select('*')
                        ->from('db_bacirita.t_kegiatan')
                        ->where('id', $id)
                        ->get()->row_array();

        $explode = explode(".", $kegiatan['template_sertifikat']);
        $outputFile = "arsipbkpsdmbacirita/sertifikat/".$explode[0]."_preview.pdf";
        if(file_exists($outputFile)){
            unlink($outputFile);
        }

        $meta = json_decode($kegiatan['meta_coordinate'], true);
        
        $temp = $meta;
        
        foreach($data['result'] as $k => $v){
            if($k != "qr"){
                $temp[$k]['margin-top'] = $data['result'][$k]['margin-top'];
                $temp[$k]['margin-left'] = $data['result'][$k]['margin-left'];
                $temp[$k]['font-size'] = $data['result'][$k]['font-size'];
            } else {
                $temp[$k]['margin-top'] = $data['result'][$k]['margin-top'];
                $temp[$k]['margin-left'] = $data['result'][$k]['margin-left'];
                $temp[$k]['width'] = $data['result'][$k]['width'];
            }
        }
        $temp['url_template'] = $kegiatan['template_sertifikat'];
        $data['result'] = $temp;

        $this->regeneratePreviewSertifikat($data, $id);

        $this->db->where('id', $id)
                ->update('db_bacirita.t_kegiatan', [
                    'meta_coordinate' => json_encode($data['result']) 
                ]);

        return ['code' => 0, 'message' => "", 'random_string' => generateRandomNumber(5)];
    }

}