<?php

class C_Kinerja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('master/M_Master', 'master');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->model('kinerja/M_VerifKinerja', 'verifkinerja');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        if (!$this->general_library->isNotMenu()) {
            redirect('logout');
        };
    }

    public function Kinerja()
    {
        $data['list_rencana_kinerja'] = $this->kinerja->getRencanaKinerja(date('m'), date('Y'));
        render('kinerja/V_RealisasiKinerja', '', '', $data);
    }

    public function tesUpload()
    {
        $data['list_rencana_kinerja'] = $this->kinerja->getRencanaKinerja();
        render('kinerja/V_TesUpload', '', '', $data);
    }

    public function rencanaKinerja()
    {
        $data['list_rencana_kerja'] = "";
        $data['list_rencana_kinerja'] = $this->kinerja->getListRencanaKinerjaTugas();
        $data['list_sasaran_kerja'] = $this->kinerja->getListRencanaKinerjaSasaran();
        // dd($data['list_rencana_kinerja']);
        // $data['apel-pagi'] = $this->kinerja->cekRencanaKinerjaApelPagi();
        render('kinerja/V_RencanaKinerja', '', '', $data);
    }

    public function rekapKinerja()
    {
        $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerjaBU();
        render('kinerja/V_RekapKinerja', '', '', $data);
    }

    public function loadRekapKinerjaUser($bulan, $tahun){
        $data['tpp'] = $this->session->userdata('search_detail_tpp_pegawai');
        $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja($tahun, $bulan);
        $data['list_rekap_komponen_kinerja'] = $this->rekap->getKomponenKinerja($this->general_library->getId(), $bulan, $tahun);
        $this->load->view('user/V_RekapKinerjaUser', $data);
    }

    public function loadRekapDisiplinKerjaUser($bulan, $tahun){
        // $data['result'] = $this->general_library->getPaguTppPegawai($bulan, $tahun);
        $data['result'] = $this->session->userdata('search_detail_tpp_pegawai');
        $data['list_disiplin_kerja'] = $this->general->getAllWithOrder('m_jenis_disiplin_kerja', 'keterangan', 'asc');
        $this->load->view('user/V_RekapDisiplinKerjaUser', $data);
    }

    public function LoadRekapKinerja($tahun, $bulan)
    {
        $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja($tahun, $bulan);
        $this->load->view('kinerja/V_RekapKinerjaItem', $data);
    }

    public function createRencanaKinerja()
    {
        $data = $this->input->post();
        $data['id_m_user'] = $this->general_library->getId();
        $this->kinerja->insert('t_rencana_kinerja', $data);
        // $this->kinerja->insertKomponenKinerja($data);


    }

    public function insertLaporanKegiatan()
    {

        //   $countfiles = count($_FILES['files']['name']);
        //   $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        //   $ress = 1;
        //   if(implode($_FILES['files']['name']) == ""){

        //     $nama_file = '[""]';
        //     $image = $nama_file;
        //     $dataPost = $this->input->post();
        //     $this->kinerja->createLaporanKegiatan($dataPost,$image);
        //   } else {
        //     for($i=0;$i<$countfiles;$i++){

        //         if(!empty($_FILES['files']['name'][$i])){

        //           // Define new $_FILES array - $_FILES['file']
        //           $_FILES['file']['name'] = $this->getUserName().'_'.$_FILES['files']['name'][$i];
        //           $_FILES['file']['type'] = $_FILES['files']['type'][$i];
        //           $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
        //           $_FILES['file']['error'] = $_FILES['files']['error'][$i];
        //           $_FILES['file']['size'] = $_FILES['files']['size'][$i];


        //         //   if($_FILES['file']['size'] > 1048576){
        //         //     $ress = 0;
        //         //     $res = array('msg' => 'File tidak boleh lebih dari 1 MB', 'success' => false);
        //         //     break;
        //         //   }

        //           // Set preference
        //           $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        //           $config['upload_path'] = './assets/bukti_kegiatan'; 
        //         //   $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        //           $config['allowed_types'] = '*';
        //         //   $config['max_size'] = '5000'; // max_size in kb
        //         //   $config['file_name'] = $this->getUserName().'_'.$_FILES['file']['name'];

        //           //Load upload library
        //           $this->load->library('upload',$config); 
        //         //   $res = array('msg' => 'something went wrong', 'success' => false);
        //           // File upload
        //           if($this->upload->do_upload('file')){

        //            $data = $this->upload->data(); 
        //            if($data['file_type'] == "image/png" || $data['file_type'] == "image/jpeg") {
        //            $insert['name'] = $data['file_name'];
        //            $config['image_library'] = 'gd2';
        //            $config['source_image'] = './assets/bukti_kegiatan/'.$data["file_name"];
        //            $config['create_thumb'] = FALSE;
        //            $config['maintain_ratio'] = FALSE;

        //            if($data['file_size'] > 1000) {
        //             // $imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
        //             $config['height'] = $data['image_height'] * 50 / 100;
        //             $config['width'] = $data['image_width'] * 50 / 100;

        //            } 
        //         //    else {
        //         //     $config['height'] =600;  
        //         //     $config['width'] = 600;

        //         //    }
        //            $config['master_dim'] = 'auto';
        //            $config['quality'] = "50%";



        //            $this->load->library('image_lib');
        //                     $this->image_lib->initialize($config);
        //                     if (!$this->image_lib->resize()) {
        //                         echo $this->image_lib->display_errors();
        //                     }
        //             $this->image_lib->clear();
        //         }

        //           }
        //         }
        //         $nama_file[] = $data['file_name'];
        //        }
        //        if($ress == 1){
        //         $image = json_encode($nama_file); 
        //         $dataPost = $this->input->post();
        //         $this->kinerja->createLaporanKegiatan($dataPost,$image);
        //        }   
        //   }

        //     echo json_encode($res);
        echo json_encode($this->kinerja->insertLaporanKegiatan());
    }

    public function insertPeninjauanAbsensi()
    {
        echo json_encode($this->kinerja->insertPeninjauanAbsensi());
    }


    public function createLaporanKegiatan()
    {

        $fileName = $this->general_library->getUserName() . '_bukti_kegiatan_' . date('ymdhis') . '_' . $_FILES['image_file']['name'];
        $config['upload_path'] = "./assets/bukti_kegiatan";
        $config['allowed_types'] = '*';
        $config['file_name'] = $fileName;
        // $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $data = array('upload_data' => $this->upload->data());

            $dataPost = $this->input->post();

            $image = $fileName;

            $result = $this->kinerja->createLaporanKegiatan($dataPost, $image);


            echo json_decode($result);
        } else {
            $dataPost = $this->input->post();

            $image = "";

            $result = $this->kinerja->createLaporanKegiatan($dataPost, $image);
        }
    }


    public function loadKegiatan($tahun, $bulan)
    {

        $data['list_kegiatan'] = $this->kinerja->loadKegiatan($tahun, $bulan);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $this->load->view('kinerja/V_RealisasiKinerjaItem', $data);
    }

    public function loadPeninjauanAbsensi()
    {

        $data['list_peninjauan'] = $this->kinerja->loadPeninjauanAbsensi();
        $this->load->view('kinerja/V_PeninjauanAbsensiItem', $data);
    }

    public function deleteKegiatan($id)
    {
        $this->general->delete('id', $id, 't_kegiatan');
    }

    public function deletePeninjauanAbsensi($id)
    {
        $this->general->delete('id', $id, 't_peninjauan_absensi');
    }

    public function deleteRencanaKinerja($id)
    {
        $this->general->delete('id', $id, 't_rencana_kinerja');
    }

    public function loadRencanaKinerja($bulan = null, $tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$bulan) {
            $bulan = date('m');
        }
        $data['list_rencana_kinerja'] = $this->kinerja->loadRencanaKinerja($bulan, $tahun);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $this->load->view('kinerja/V_RencanaKinerjaItem', $data);
    }

    // public function loadRekapKinerja(){

    //     $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerja();
    //     $this->load->view('kinerja/V_RekapKinerja', $data);
    // }



    public function getSatuan()
    {
        $data = $this->kinerja->getSatuan();
        echo json_encode($data);
    }

    public function searchRekapKinerja()
    {

        $data['list_rekap_kinerja'] = $this->kinerja->searchRekapKinerja();
        $this->load->view('kinerja/V_RekapKinerja', $data);
    }

    function getRencanaKerja()
    {

        $data = $this->kinerja->getRencanaKerja()->result();
        echo json_encode($data);
    }

    public function getUserName()
    {
        $this->userLoggedIn = $this->session->userdata('user_logged_in');
        return $this->userLoggedIn[0]['username'];
    }


    public function loadEditRealisasiKinerja($id)
    {
        $data['realisasi'] = $this->kinerja->getReaslisasiKinerjaEdit($id);
        // dd($data['realisasi']);
        $this->load->view('kinerja/V_EditRealisasiKinerja', $data);
    }


    public function editRealisasiKinerja()
    {
        echo json_encode($this->kinerja->editRealisasiKinerja());
    }



    public function loadEditRencanaKinerja($id)
    {
        $data['rencana'] = $this->kinerja->getRencanaKinerjaEdit($id);
        // dd($data['realisasi']);
        $this->load->view('kinerja/V_EditRencanaKinerja', $data);
    }

    public function editRencanaKinerja()
    {
        echo json_encode($this->kinerja->editRencanaKinerja());
    }

    public function skpBulanan()
    {
        render('kinerja/V_SkpBulanan', '', '', null);
    }

    public function createSkpBulanan()
    {
        $data['periode'] = $this->input->post();

        list($data['pegawai'], $data['atasan_pegawai'], $data['rencana_kinerja'], $data['kepala_pd'], $data['nilai_komponen']) = $this->kinerja->createSkpBulanan($this->input->post());
        $this->session->set_userdata(['data_skp' => $data]);
        $id = $this->general_library->getId();
        $dataa = $this->input->post();
        // dd($data['tahun']);
        $data['list_perilaku_kerja'] = $this->verifkinerja->loadPerilakuKerja($id, $dataa);
        $this->load->view('kinerja/V_SkpBulananCreate', $data);
    }

    public function openKomponenKinerjaPegawai($id, $bulan, $tahun){
        list($temp, $data['komponen_kinerja']) = $this->kinerja->loadSkbpPegawai($id, $bulan, $tahun);
        $data['id'] = $id;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->view('kinerja/V_VerifSkbpKomponenKinerja', $data);
    }

    public function openListKegiatanKinerjaPegawai($id, $bulan = 0, $tahun = 0){
        $data['id_rencana_kegiatan'] = $id;
        $data['result'] = $this->verifkinerja->loadListKegiatanRencanaKinerja($id);
        $data['param']['bulan'] = $bulan;
        $data['param']['tahun'] = $tahun;
        $this->load->view('kinerja/V_VerifSkbpListKegiatan', $data);
    }

    public function openRekapKinerjaPegawai($id, $bulan, $tahun){
        $data['list_rekap_kinerja'] = $this->kinerja->loadRekapKinerjaByIdPegawai($tahun, $bulan, $id);
        $data['param']['bulan'] = $bulan;
        $data['param']['tahun'] = $tahun;
        $this->load->view('kinerja/V_VerifSkbpRekapKinerja', $data);
    }

    public function openVerifPegawai()
    {
        $data['periode'] = $this->input->post();
        $data['pegawai'] = $this->user->getPegawaiById($this->input->post('id_user'));
        $this->load->view('kinerja/V_VerifSkbp', $data);
    }

    public function createSkpBulananVerifNew($id, $bulan, $tahun)
    {
        // $data['periode'] = $this->input->post();
        // dd($data['periode']);
        $data['id_user'] = $id;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['periode'] = $data;

        list($data['pegawai'], $data['atasan_pegawai'], $data['rencana_kinerja'], $data['kepala_pd'], $data['nilai_komponen']) = $this->kinerja->createSkpBulananVerif($data);
        $this->load->view('kinerja/V_SkpBulananCreateNew', $data);
    }

    public function saveKeteranganVerif($id){
        $this->kinerja->saveKeteranganVerif($id, $this->input->post());
    }

    public function createSkpBulananVerif()
    {
        $data['periode'] = $this->input->post();
        // dd($data['periode']);

        list($data['pegawai'], $data['atasan_pegawai'], $data['rencana_kinerja'], $data['kepala_pd'], $data['nilai_komponen']) = $this->kinerja->createSkpBulananVerif($this->input->post());
        $this->session->set_userdata(['data_skp' => $data]);
        $id = $this->input->post('id_user');
        $dataa = $this->input->post();
        // dd($id);
        $data['list_perilaku_kerja'] = $this->verifkinerja->loadPerilakuKerja($id, $dataa);
        $this->load->view('kinerja/V_SkpBulananCreateNew', $data);
    }

    public function komponenKinerja()
    {
        render('kinerja/V_KomponenKinerja', '', '', null);
    }

    public function deleteNilaiKomponen($id)
    {
        echo json_encode($this->verifkinerja->deleteNilaiKomponen($id));
    }

    public function skbpPd(){
        $data['skpd'] = $this->master->getAllUnitKerja();
        render('kinerja/V_SkbpPd', '', '', $data);
    }

    public function searchSkbpPd(){
        $data['param'] = $this->input->post();
        $data['result'] = $this->user->getListPegawaiByUnitKerjaNew($data['param']['id_unitkerja']);
        $this->load->view('kinerja/V_SkbpPdListPegawai', $data);
    }

    public function loadPegawaiKomponenKinerja()
    {
        $data['periode'] = $this->input->post();
        $data['list_pegawai'] = $this->verifkinerja->loadPegawaiKomponenKinerja($this->input->post());
        $this->load->view('kinerja/V_ListPegawaiKomponenKinerja', $data);
    }

    public function loadPegawaiKinerja()
    {
        $data['periode'] = $this->input->post();
        $data['list_pegawai'] = $this->verifkinerja->loadPegawaiKomponenKinerja($this->input->post());
        $this->load->view('kinerja/V_ListPegawaiKomponenKinerjaNew', $data);
    }

    public function editNilaiKomponen($id, $bulan, $tahun)
    {
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        list($data['pegawai'], $data['result']) = $this->verifkinerja->loadNilaiKomponen($id, $bulan, $tahun);
        $data['list_perilaku_kerja'] = $this->verifkinerja->loadPerilakuKerja($id, $data);
        // dd( $data['list_perilaku_kerja']);
        $this->load->view('kinerja/V_EditKomponenKinerja', $data);
    }

    public function saveNilaiKomponenKinerja()
    {
        // dd($_POST);
        // echo json_encode($this->verifkinerja->saveNiliKomponenKinerja($this->input->post()));
        // for ($count = 0; $count < count($_POST['id_m_sub_perilaku_kerja']); $count++) {
        //     $id_m_sub_perilaku_kerja = $_POST['id_m_sub_perilaku_kerja'][$count];
        //     $data = null;
        //     if(isset($_POST['hasil_'.$id_m_sub_perilaku_kerja])){
        //         $data['nilai'] = $_POST['nilai'.$id_m_sub_perilaku_kerja];
        //     }

        // $data = array(
        //     'hasil' => $_POST['hasil'][$count],
        //     'nilai_normal' => $_POST['nilai_normal'][$count],
        //     'satuan' => $_POST['satuan'][$count],
        //     'keterangan' => $_POST['keterangan'][$count],
        // );
        // var_dump($data);
        // die();


        // }

        echo json_encode($this->verifkinerja->createNilaiKomponenKinerja());
    }

    public function hukdis(){
        $data['pegawai'] = $this->master->getAllOnlyPegawai();
        $data['hukdis'] = $this->general->getAllWithOrder('m_disiplin_kerja', 'id', 'asc');
        // dd($data);
        render('kinerja/V_Hukdis', '', '', $data);
    }

    public function disiplinKerja()
    {
        $data['skpd'] = $this->master->getAllUnitKerja();
        render('kinerja/V_DisiplinKerja', '', '', $data);
    }

    public function tinjauABsensi()
    {
        $data['skpd'] = $this->master->getAllUnitKerja();
        $data['pegawai'] = $this->kinerja->getPegawaiPeninjauanAbsensi();
        render('kinerja/V_PeninjauanAbsensi', '', '', $data);
    }

    public function verifikasiTinjauAbsensi()
    {
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        render('kinerja/V_VerifPeninjauanAbsensi', '', '', $data);
    }

    public function searchVerifTinjauAbsensi()
    {
        $data['result'] = $this->kinerja->searchVerifTinjauAbsensi($this->input->post());
        // dd($data['result']);
        $this->load->view('kinerja/V_VerifPeninjauanAbsensiItem', $data);
    }

    public function searchDisiplinKerja()
    {
        $data['result'] = $this->kinerja->searchDisiplinKerja($this->input->post());
        $data['skpd'] = 0;
        if(($this->input->post('id_unitkerja'))){
        $data['skpd'] = $this->input->post('id_unitkerja');
        }
        $this->load->view('kinerja/V_DisiplinKerjaResult', $data);
    }

    public function loadDataPendukungByStatus($status, $bulan, $tahun, $id_unitkerja)
    {
        list($data['result'], $data['count']) = $this->kinerja->loadDataPendukungByStatus($status, $bulan, $tahun, $id_unitkerja);
        $data['status'] = $status;
        $this->load->view('kinerja/V_DisiplinKerjaResultData', $data);
    }

    public function insertDisiplinKerja()
    {
        
        $this->load->library('image_lib');
        $countfiles = count($_FILES['files']['name']);

        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        $ress = 1;
        if (implode($_FILES['files']['name']) == "") {
            $nama_file = '[""]';
            $image = $nama_file;
            // $dataPost = $this->input->post();
            echo json_encode($this->kinerja->insertDisiplinKerja($this->input->post(), $image));
            // $this->kinerja->createLaporanKegiatan($dataPost,$image);
        } else {
            for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['files']['name'][$i])) {
                    $data = null;
                    $_FILES['file']['name'] = date('ymdhis') . '_' . $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    // Set preference
                    $random_number = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
                    $config['upload_path'] = './assets/dokumen_pendukung_disiplin_kerja';
                    //   $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '5000'; // max_size in kb

                    //Load upload library
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('file'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                            $res = array('msg' => $error, 'success' => false);
                            return $res;
                    }

                  
                    if ($this->upload->do_upload('file')) {

                        $data = $this->upload->data();
                        $insert['name'] = $data['file_name'];
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/dokumen_pendukung_disiplin_kerja/' . $data["file_name"];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;

                        if ($data['image_height'] > 1000 || $data['image_width'] > 1000) {
                            // $imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
                            $config['width'] = $data['image_width'] * 50 / 100;
                            $config['height'] = $data['image_height'] * 50 / 100;
                        }
                        // else {
                        //     $config['width'] = 600;
                        //     $config['height'] = 600;  
                        // }
                        $config['master_dim'] = 'auto';
                        $config['quality'] = "50%";

                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }
                }
                $nama_file[] = $data['file_name'];
            }
            if ($ress == 1) {
                $image = json_encode($nama_file);
                echo json_encode($this->kinerja->insertDisiplinKerja($this->input->post(), $image));
                // $dataPost = $this->input->post();
                // $this->kinerja->createLaporanKegiatan($dataPost,$image);
            }
            // echo json_encode($this->kinerja->insertDisiplinKerja($this->input->post()));
        }
    }

    public function reuploadDisiplinKerja($random_string)
    {
        
        $this->load->library('image_lib');
        $countfiles = count($_FILES['files']['name']);

        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        $ress = 1;
        if (implode($_FILES['files']['name']) == "") {
            $nama_file = '[""]';
            $image = $nama_file;
            // $dataPost = $this->input->post();
            echo json_encode($this->kinerja->reuploadDisiplinKerja($this->input->post(), $image, $random_string));
            // $this->kinerja->createLaporanKegiatan($dataPost,$image);
        } else {
            for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['files']['name'][$i])) {
                    $data = null;
                    $_FILES['file']['name'] = date('ymdhis') . '_' . $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    // Set preference
                    $random_number = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
                    $config['upload_path'] = './assets/dokumen_pendukung_disiplin_kerja';
                    //   $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '5000'; // max_size in kb

                    //Load upload library
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('file'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                            $res = array('msg' => $error, 'success' => false);
                            return $res;
                    }

                  
                    if ($this->upload->do_upload('file')) {

                        $data = $this->upload->data();
                        $insert['name'] = $data['file_name'];
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/dokumen_pendukung_disiplin_kerja/' . $data["file_name"];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;

                        if ($data['image_height'] > 1000 || $data['image_width'] > 1000) {
                            // $imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
                            $config['width'] = $data['image_width'] * 50 / 100;
                            $config['height'] = $data['image_height'] * 50 / 100;
                        }
                        // else {
                        //     $config['width'] = 600;
                        //     $config['height'] = 600;  
                        // }
                        $config['master_dim'] = 'auto';
                        $config['quality'] = "50%";

                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }
                }
                $nama_file[] = $data['file_name'];
            }
            if ($ress == 1) {
                $image = json_encode($nama_file);
                echo json_encode($this->kinerja->reuploadDisiplinKerja($this->input->post(), $image, $random_string));
                // $dataPost = $this->input->post();
                // $this->kinerja->createLaporanKegiatan($dataPost,$image);
            }
            // echo json_encode($this->kinerja->reuploadDisiplinKerja($this->input->post()));
        }
    }

    public function checkLockTpp(){
        echo json_encode($this->kinerja->checkLockTpp());
    }

    public function modalTambahDataDisiplinKerja($id_unitkerja)
    {
        $data['pegawai'] = $this->master->getPegawaiBySkpd($id_unitkerja);
        $data['skpd'] = $this->master->getAllUnitKerja();
        $data['jenis_disiplin'] = $this->general->getAllWithOrder('m_jenis_disiplin_kerja', 'nama_jenis_disiplin_kerja', 'asc');
        $data['meta_jenis_disiplin'] = null;
        foreach($data['jenis_disiplin'] as $jd){
            $data['meta_jenis_disiplin'][$jd['id']] = $jd;
        }
        $data['param_lock_upload_dokpen'] = $this->general->getOne('m_parameter', 'parameter_name', 'PARAM_LOCK_UPLOAD_DOKPEN', 1)['parameter_value'];
        $this->load->view('kinerja/V_ModalTambahDataDisiplinKerja', $data);
    }

    public function reuploadDataDisiplinKerja($random_string)
    {
        $data['data'] = $this->kinerja->getDataForReuploadDisiplinKerja($random_string);
        // $id_unitkerja = "4018000";
        // $data['pegawai'] = $this->master->getPegawaiBySkpd($id_unitkerja);
        // $data['skpd'] = $this->master->getAllUnitKerja();
        $data['jenis_disiplin'] = $this->general->getAllWithOrder('m_jenis_disiplin_kerja', 'nama_jenis_disiplin_kerja', 'asc');
        $data['meta_jenis_disiplin'] = null;
        foreach($data['jenis_disiplin'] as $jd){
            $data['meta_jenis_disiplin'][$jd['id']] = $jd;
        }
        $this->load->view('kinerja/V_ModalReuploadDataDisiplinKerja', $data);
    }

    public function deleteDataDisiplinKerja($id)
    {
        echo json_encode($this->kinerja->deleteDataDisiplinKerja($id));
    }

    public function deleteDataDisiplinKerjaByIdUser()
    {
        $this->kinerja->deleteDataDisiplinKerjaByIdUser($this->input->post());
    }

    public function openModalDetailDisiplinKerja($id, $bulan, $tahun)
    {
        $data['result'] = $this->kinerja->openModalDetailDisiplinKerja($id, $bulan, $tahun);
        $this->load->view('kinerja/V_DisiplinKerjaDetailModal', $data);
    }

    public function verifikasiDokumenPendukung()
    {
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        render('kinerja/V_VerifDokumenPendukungAbsensi', '', '', $data);
    }

    public function searchVerifDokumen()
    {
        $data['result'] = $this->kinerja->searchVerifDokumen($this->input->post());
        $this->load->view('kinerja/V_VerifDokumenSearch', $data);
    }

    public function batchRandomString($bulan, $tahun, $id_m_user = 0){
        $this->kinerja->batchRandomString($bulan, $tahun, $id_m_user);
    }

    public function loadSearchVerifDokumen($status, $bulan, $tahun, $id_unitkerja)
    {
        list($data['result'], $data['count']) = $this->kinerja->loadSearchVerifDokumen($status, $bulan, $tahun, $id_unitkerja);
        $data['status'] = $status;
        // dd($data);
        $this->load->view('kinerja/V_VerifDokumenData', $data);
    }

    public function loadSearchVerifPeninjauanAbsensi($status, $bulan, $tahun, $id_unitkerja)
    {
        $data['result'] = $this->kinerja->loadSearchVerifPeninjauanAbsensi($status, $bulan, $tahun, $id_unitkerja);
        $data['status'] = $status;
    //    dd($data);    
        $this->load->view('kinerja/V_VerifPeninjauanAbsensiData', $data);
    }

    public function verifDokumen($id, $status)
    {
        echo json_encode($this->kinerja->verifDokumen($id, $status));
    }

    public function verifPeninjauanAbsensi($id, $status)
    {
        echo json_encode($this->kinerja->verifPeninjauanAbsensi($id, $status));
    }


    public function paguTpp()
    {
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        render('kinerja/V_PaguTpp', '', '', $data);
    }

    public function countPaguTpp()
    {
        $data['result'] = $this->kinerja->countPaguTpp($this->input->post());
        $this->load->view('kinerja/V_PaguTppData', $data);
    }

    public function disker()
    {
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        $data['disker'] = $this->general->getAll('m_disiplin_kerja');
        render('kinerja/V_Disker', '', '', $data);
    }

    public function getListPegawaiByUnitKerja($id_unitkerja)
    {
        echo json_encode($this->user->getListPegawaiByUnitKerja($id_unitkerja));
    }

    public function loadModalTambahDataDisker()
    {
        $data['unitkerja'] = $this->master->getAllUnitKerja();
        $data['disker'] = $this->general->getAll('m_disiplin_kerja');
        $this->load->view('kinerja/V_ModalTambahDataDisker', $data);
    }

    public function skbp(){
        // list($data['pegawai'], $data['atasan'], $data['kepala_pd']) = $this->kinerja->getAtasanPegawai($this->general_library->getId());
        render('kinerja/V_InputSkbp', '', '', null);
    }

    public function loadListSkbpPegawai($id_pegawai){
        $data['result'] = $this->kinerja->loadListSkbpPegawai($id_pegawai);
        $this->load->view('kinerja/V_ListSkbp', $data);
    }

    public function inputSkbp($id, $bulan, $tahun){
        $data['id'] = $id;
        $data['bulan'] = $bulan;
        $data['nama_bulan'] = strtoupper(getNamaBulan($bulan));
        $data['tahun'] = $tahun;
        $data['id_komponen'] = null;
        list($data['kinerja'], $data['komponen_kinerja']) = $this->kinerja->loadSkbpPegawai($id, $bulan, $tahun);
        $this->load->view('kinerja/V_InputSkbpDetail', $data);
    }

    public function loadSkbpDetailPegawai($id, $bulan, $tahun){
        list($data['kinerja'], $data['komponen_kinerja']) = $this->kinerja->loadSkbpPegawai($id, $bulan, $tahun);
        $data['id'] = $id;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->view('kinerja/V_InputSkbpRow', $data);
    }

    public function updateRowSkbp($id){
        echo json_encode($this->kinerja->updateRowSkbp($this->input->post(), $id));
    }

    public function inputRowSkbp(){
        echo json_encode($this->kinerja->inputRowSkbp($this->input->post()));
    }

    public function inputKomponenKinerja($id, $bulan, $tahun){
        echo json_encode($this->kinerja->inputKomponenKinerja($this->input->post(), $id, $bulan, $tahun));
    }

    public function updateKomponenKinerja($id, $bulan, $tahun, $id_komponen){
        echo json_encode($this->kinerja->updateKomponenKinerja($this->input->post(), $id, $bulan, $tahun, $id_komponen));
    }

    public function deleteKomponenKinerja($id){
        echo json_encode($this->kinerja->deleteKomponenKinerja($id));
    }

    public function deleteRowSkbp($id){
        echo json_encode($this->kinerja->deleteRowSkbp($id));
    }

    public function deleteSkbp($bulan, $tahun){
        echo json_encode($this->kinerja->deleteSkbp($bulan, $tahun));
    }

    public function pelanggaran(){
        $data['result'] = $this->general->getAllWithOrder('m_pelanggaran', 'nama_pelanggaran', 'asc');
        $data['list_pegawai'] = $this->general->getAllPegawai();
        // dd($data['list_pegawai']);
        render('kinerja/V_Pelanggaran', '', '', $data);
    }

    public function exportExcel(){
        
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
  
    $excel = new PHPExcel();
    
    $excel->getProperties()->setCreator('Bee Technology')
                 ->setLastModifiedBy('Bee Technology')
                 ->setTitle("Data Siswa")
                 ->setSubject("Siswa")
                 ->setDescription("Laporan Semua Data Siswa")
                 ->setKeywords("Data Siswa");
    
    $style_col = array(
      'font' => array('bold' => true), 
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
      )
    );
    
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
      )
    );

    // sheet 1
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); 
    $excel->getActiveSheet()->mergeCells('A1:E1'); 
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); 
    $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIS"); 
    $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); 
    $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); 
    $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); 
    
    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
    

  
      $excel->setActiveSheetIndex(0)->setCellValue('A4', 1);
      $excel->setActiveSheetIndex(0)->setCellValue('B4', "tes");
      $excel->setActiveSheetIndex(0)->setCellValue('C4', "tes");
      $excel->setActiveSheetIndex(0)->setCellValue('D4', "tes");
      $excel->setActiveSheetIndex(0)->setCellValue('E4', "tes");
      
      
      $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_row);
      
   
    
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
    
    
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    
    $excel->getActiveSheet(0)->setTitle("Tes Sheet 1");
    $excel->setActiveSheetIndex(0);
    // tutup sheet 1
    $excel->createSheet();
      // sheet 2
      $excel->setActiveSheetIndex(1)->setCellValue('A1', "DATA SISWA 2"); 
      $excel->getActiveSheet()->mergeCells('A1:E1'); 
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $excel->setActiveSheetIndex(1)->setCellValue('A3', "NO"); 
      $excel->setActiveSheetIndex(1)->setCellValue('B3', "NIS"); 
      $excel->setActiveSheetIndex(1)->setCellValue('C3', "NAMA"); 
      $excel->setActiveSheetIndex(1)->setCellValue('D3', "JENIS KELAMIN"); 
      $excel->setActiveSheetIndex(1)->setCellValue('E3', "ALAMAT"); 
      
      $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
      
  
    
        $excel->setActiveSheetIndex(1)->setCellValue('A4', 1);
        $excel->setActiveSheetIndex(1)->setCellValue('B4', "tes");
        $excel->setActiveSheetIndex(1)->setCellValue('C4', "tes");
        $excel->setActiveSheetIndex(1)->setCellValue('D4', "tes");
        $excel->setActiveSheetIndex(1)->setCellValue('E4', "tes");
        
        
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_row);
        
     
      
      $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
      $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
      $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
      $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
      $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
      
      
      $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
      
      $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      
      $excel->getActiveSheet(0)->setTitle("Tes Sheet 2");
      $excel->setActiveSheetIndex(0);
     // tutup sheet 2

    
    $filename="datasiswa.xls";
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    ob_end_clean();
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$filename);
    $objWriter->save('php://output');
    }
}
