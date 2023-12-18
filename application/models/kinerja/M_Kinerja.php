<?php
	class M_Kinerja extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
            return $this->db->affected_rows();
        }

        public function deleteRencanaKerja($id, $id_m_user){
            $this->db->where('id', $id)
                    ->update('t_rencana_kinerja', ['flag_active' => 0, 'updated_by' => $id_m_user]);
            return $this->db->affected_rows();
        }

        public function insertKomponenKinerja($dataPost){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;
            $this->db->trans_begin();

            $cek = $this->db->select('a.*')
                            ->from('t_komponen_kinerja a')
                            ->where('a.id_m_user', $dataPost['id_m_user'])
                            ->where('a.tahun', $dataPost['tahun'])
                            ->where('a.bulan', $dataPost['bulan'])
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
            
            if(!$cek){
                $data = array('berorientasi_pelayanan' => 97, 
                'akuntabel' => 97,
                'kompeten' => 97,
                'harmonis' => 97,
                'loyal' => 97,
                'adaptif' => 97,
                'kolaboratif' => 97,
                'id_m_user' => $dataPost['id_m_user'],
                'bulan' => $dataPost['bulan'],
                'tahun' => $dataPost['tahun']
                );
                $result = $this->db->insert('t_komponen_kinerja', $data);
            }
           
        
             if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
                        $res['code'] = 1;
                        $res['message'] = 'Terjadi Kesalahan';
                        $res['data'] = null;
                }
                else
                {
                        $this->db->trans_commit();
                }
                return $res;
            }

        public function insertLaporanKegiatan(){
           
        $countfiles = count($_FILES['files']['name']);
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        $ress = 1;

        $this->db->trans_begin();
       
        if(implode($_FILES['files']['name']) == ""){
            
            $nama_file = '[""]';
            $image = $nama_file;
            $dataPost = $this->input->post();
            $this->createLaporanKegiatan($dataPost,$image);
        } else {
        for($i=0;$i<$countfiles;$i++){
         
            if(!empty($_FILES['files']['name'][$i])){
      
              // Define new $_FILES array - $_FILES['file']
              $_FILES['file']['name'] = $this->general_library->getUserName().'_'.$_FILES['files']['name'][$i];
              $_FILES['file']['type'] = $_FILES['files']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
              $_FILES['file']['error'] = $_FILES['files']['error'][$i];
              $_FILES['file']['size'] = $_FILES['files']['size'][$i];
              

              if($_FILES['file']['type'] != "image/png"  AND $_FILES['file']['type'] != "image/jpeg") {
                $ress = 0;
                $res = array('msg' => 'Hanya bisa upload file gambar', 'success' => false);
                break;
              }
            
                
            //   if($_FILES['file']['size'] > 1048576){
            //     $ress = 0;
            //     $res = array('msg' => 'File tidak boleh lebih dari 1 MB', 'success' => false);
            //     break;
            //   }
           
              // Set preference
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            //   $config['upload_path'] = '../siladen/assets/bukti_kegiatan';
            $config['upload_path'] = './assets/bukti_kegiatan'; 
            //   $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
              $config['allowed_types'] = '*';
            //   $config['max_size'] = '5000'; // max_size in kb
            //   $config['file_name'] = $this->getUserName().'_'.$_FILES['file']['name'];
             
              //Load upload library
              $this->load->library('upload',$config); 
            //   $res = array('msg' => 'something went wrong', 'success' => false);
              // File upload

            //   dd($this->upload->do_upload('file'));
              if ( ! $this->upload->do_upload('file'))
              {
                      $error = array('error' => $this->upload->display_errors());
                      $res = array('msg' => $error, 'success' => false);
                      return $res;
                    //   dd($error);
              }

              if($this->upload->do_upload('file')){
               
               $data = $this->upload->data(); 
                 //    kompress
            //    if($data['file_type'] == "image/png" || $data['file_type'] == "image/jpeg") {
            //    $insert['name'] = $data['file_name'];
            //    $config['image_library'] = 'gd2';
            //    $config['source_image'] = './assets/bukti_kegiatan/'.$data["file_name"];
            //    $config['create_thumb'] = FALSE;
            //    $config['maintain_ratio'] = FALSE;
               
            //    if($data['file_size'] > 1000) {
               
            //     // $imgdata=exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');
            //     $tinggi = $data['image_height'] * 50 / 100;
            //     $lebar  = $data['image_width'] * 50 / 100;
            //     $config['height'] = round($tinggi);
            //     $config['width'] = round($lebar);
              
            //    } 
            // //    else {
            // //     $config['height'] =600;  
            // //     $config['width'] = 600;
               
            // //    }
            //    $config['master_dim'] = 'auto';
            //    $config['quality'] = "50%";


            //    $this->load->library('image_lib');
            //             $this->image_lib->initialize($config);
            //             if (!$this->image_lib->resize()) {
            //                 echo $this->image_lib->display_errors();
            //             }
            //     $this->image_lib->clear();
            // tutup kompress
            // }
            
              }
            }
            $nama_file[] = $data['file_name'];
           }
           if($ress == 1){
            $image = json_encode($nama_file); 
            $dataPost = $this->input->post();
            $this->createLaporanKegiatan($dataPost,$image);
           }   
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }

        return $res;
        }

        public function createLaporanKegiatan($dataPost,$image){
  
        $this->db->trans_begin();
        $data = array('tanggal_kegiatan' => $dataPost['tanggal_kegiatan'], 
                      'deskripsi_kegiatan' => $dataPost['deskripsi_kegiatan'],
                      'realisasi_target_kuantitas' => $dataPost['target_kuantitas'],
                      'satuan' => $dataPost['satuan'],
                      'target_kualitas' => 100,
                      'id_t_rencana_kinerja' => $dataPost['tugas_jabatan'],
                      'bukti_kegiatan' => $image,
                      'id_m_user' => $this->general_library->getId(),
                      'status_verif' => 1,
                      'tanggal_verif' => date('Y-m-d H:i:s')
        );
        $result = $this->db->insert('t_kegiatan', $data);
       
        //cek 
        $id =  $this->general_library->getId();
        $bulan = date('n');
        $tahun = date('Y');

        $cek = $this->db->select('a.id,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.id', $dataPost['tugas_jabatan'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
       

           $this->db->where('id',  $cek[0]['id'])
                     ->update('t_rencana_kinerja', [
                    //  'updated_by' => $this->general_library->getId(),
                     'total_realisasi' => $cek[0]['realisasi_target_kuantitas']
            ]);



        // if($cek){          
        //  if($cek['0']['realisasi_target_kuantitas'] > $cek['0']['target_kuantitas']){
        //     $this->db->where('id',  $dataPost['tugas_jabatan'])
        //              ->update('t_rencana_kinerja', [
        //              'updated_by' => $this->general_library->getId(),
        //              'target_kuantitas' => $cek['0']['realisasi_target_kuantitas']
        //     ]);
        //  }
        // }
         if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
            }
            else
            {
                    $this->db->trans_commit();
            }
      

        }

        public function loadKegiatan($tahun,$bulan){
            $id =  $this->general_library->getId();
            return $this->db->select('a.*, b.tugas_jabatan,c.status_verif, a.status_verif as id_status_verif')
                ->from('t_kegiatan a')
                ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                ->join('m_status_verif c', 'a.status_verif = c.id')
                ->where('a.id_m_user', $id)
                ->where('year(a.tanggal_kegiatan)', $tahun)
                ->where('month(a.tanggal_kegiatan)', $bulan)
                ->where('a.flag_active', 1)
                ->order_by('a.id', 'desc')
                ->get()->result_array();
           
        }


        public function loadRencanaKinerja($bulan, $tahun, $id = null){
            if($id == null){
                $id =  $this->general_library->getId();
            }
            return $this->db->select('a.*,
            (select count(b.id) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1) as count')
                            ->from('t_rencana_kinerja a')
                            ->where('a.id_m_user', $id)
                            ->where('a.flag_active', 1)
                            ->where('a.bulan', $bulan)
                            ->where('a.tahun', $tahun)
                            ->get()->result_array();
        }


        public function getRencanaKinerja($bulan, $tahun){
            $id =  $this->general_library->getId();
            return $this->db->select('*')
                            ->from('t_rencana_kinerja as a')
                            ->where('a.id_m_user', $id)
                            ->where('a.tahun', $tahun)
                            ->where('a.bulan', $bulan)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function getSatuan()
    {      
        $id = $this->input->post('id_t_rencana_kinerja');
        $this->db->select('*, , (select  sum(realisasi_target_kuantitas) from t_kegiatan where t_kegiatan.id_t_rencana_kinerja = a.id and t_kegiatan.status_verif = 1) as total_realisasi_kuantitas,
        ( SELECT sum( realisasi_target_kuantitas ) FROM t_kegiatan WHERE t_kegiatan.id_t_rencana_kinerja = a.id AND t_kegiatan.status_verif = 0 ) AS total_belum_verif ')
            ->from('t_rencana_kinerja as a')
            ->where('a.id', $id)
            ->where('a.flag_active', 1)
            ->limit(1);
            return $this->db->get()->result_array();
    }

    public function loadRekapKinerjaBU(){

        
        $id =  $this->general_library->getId();
        if($this->input->post()) {
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
        } else {
            $bulan = date('n');
            $tahun = date('Y');
        }
       
       
        $query = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        // dd($query);
        return $query;  
    }

    public function loadRekapKinerja($tahun,$bulan){

        
        $id =  $this->general_library->getId();
        if($tahun) {
            $bulan = $bulan;
            $tahun = $tahun;
        } else {
            $bulan = date('n');
            $tahun = date('Y');
        }
       
       
        $query = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        // dd($query);
        return $query;  
    }

    public function loadRekapKinerjaByIdPegawai($tahun, $bulan, $id){

        if($tahun) {
            $bulan = $bulan;
            $tahun = $tahun;
        } else {
            $bulan = date('n');
            $tahun = date('Y');
        }
       
       
        $query = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1 and b.status_verif = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        // dd($query);
        return $query;  
    }


    function getRencanaKerja(){
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $query = $this->db->get_where('t_rencana_kinerja', array('flag_active' => 1, 'bulan' => $bulan, 'tahun' => $tahun, 'id_m_user' => $this->general_library->getId()));
        return $query;
    }

    
    public function getReaslisasiKinerjaEdit($id){
        return $this->db->select('a.*, b.tugas_jabatan')
                        ->from('t_kegiatan a')
                        ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->limit(1)
                        ->get()->row_array();
    }


    public function editRealisasiKinerja(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_kegiatan = $datapost['id_kegiatan'];

        $data["realisasi_target_kuantitas"] = $datapost["edit_realisasi_target_kuantitas"];
        $data["deskripsi_kegiatan"] = $datapost["edit_deskripsi_kegiatan"];
        $data["tanggal_kegiatan"] = $datapost["edit_tanggal_kegiatan"];


        $this->db->where('id', $id_kegiatan)
                ->update('t_kegiatan', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }


    public function editRencanaKinerja(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_rencana_kinerja = $datapost['id_rencana_kinerja'];

    
        $data["target_kuantitas"] = $datapost["edit_target_kuantitas"];
        $data["total_realisasi"] = $datapost["edit_total_realisasi"];
        $data["satuan"] = $datapost["edit_satuan"];
        $data["sasaran_kerja"] = $datapost["edit_sasaran_kerja"];

        $this->db->where('id', $id_rencana_kinerja)
                ->update('t_rencana_kinerja', $data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }


    public function getRencanaKinerjaEdit($id){
        return $this->db->select('a.*')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->limit(1)
                        ->get()->row_array();
    }

    public function baseQueryAtasan(){
        return $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan,
            a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, g.nama_bidang, a.id_m_sub_bidang, d.nama_jabatan, d.kepalaskpd, f.id_eselon')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
            ->join('db_pegawai.eselon f', 'd.eselon = f.nm_eselon')
            ->join('m_bidang g', 'a.id_m_bidang = g.id', 'left')
            ->where('a.flag_active', 1)
            ->where('b.id_m_status_pegawai', 1);
    }

    public function recursiveAtasan($pegawai, $params){
        
    }

    public function getAtasanPegawai($pegawai){
        $atasan = null;
        $kepala = null;
        $jenis_skpd = 0;

        // jenis_skpd 1 kelurahan
        // jenis_skpd 2 kecamatan
        // jenis_skpd 3 sekolah
        // jenis_skpd 4 puskes
        // dd($pegawai);

        if($pegawai['kepalaskpd'] != 1){ //bukan kepala skpd
            if($pegawai['id_unitkerjamaster'] == 4000000 || 
            $pegawai['id_unitkerjamaster'] == 3000000 || 
            stringStartWith('Bagian', $pegawai['nm_unitkerja'])){ // dinas, badan & bagian
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] == "JFU" && $pegawai['id_m_bidang'] != null){ //cari kepala sub bidang
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
                                    ->get()->row_array();
                    if(!$atasan){ //cari kepala bidang
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
                                        ->get()->row_array();
                        if(!$atasan){ //cari sek
                            if(stringStartWith('Inspektorat', $pegawai['nm_unitkerja'])){
                                $atasan = $this->baseQueryAtasan()
                                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                                ->where('a.id_m_bidang', 202)
                                                ->where('f.id_eselon', 6)
                                                ->get()->row_array();
                            } else {
                                $atasan = $this->baseQueryAtasan()
                                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                                ->where('f.id_eselon', 6)
                                                ->get()->row_array();
                            }
                            if(!$atasan){ //cari kepala
                                $atasan = $kepala;
                            }
                        }
                    }
                } else if ($pegawai['jenis_jabatan'] == "Struktural"){ // kasub atau kabid
                    if($pegawai['id_eselon'] == 8 || $pegawai['id_eselon'] == 9){ // ESELON IV, cari kabid
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
                                        ->get()->row_array();
                        if(!$atasan){ //cari sek
                            $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('f.id_eselon', 6)
                                        ->get()->row_array();
                            if(!$atasan){ //cari kepala
                                $atasan = $kepala;
                            }
                        }
                    } else if($pegawai['id_eselon'] == 6 || $pegawai['id_eselon'] == 7){ // ESELON III, kabid atau sek
                        $atasan = $kepala;
                    }
                } else if($pegawai['jenis_jabatan'] == 'JFT'){ //jika JFT
                    $atasan = $kepala;
                }
            } else if(in_array($pegawai['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){
                if(!stringStartWith('Kepala Sekolah', $pegawai['nama_jabatan']) || !stringStartWith('Kepala Taman', $pegawai['nama_jabatan'])){ //bukan kepsek
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->like('nama_jabatan', 'Kepala%')
                                    ->get()->row_array();
                    if($pegawai['id_unitkerjamaster'] == 8000000){ //TK
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 59)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid TK
                    } else if($pegawai['id_unitkerjamaster'] == 8010000) { //SD
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 57)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid SD
                    } else if($pegawai['id_unitkerjamaster'] == 8020000) { //SMP
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 58)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid SMP
                    }
                    if(!$atasan){
                        $atasan = $kepala;
                    }
                } else { //jika kepsek
                    if($pegawai['id_unitkerjamaster'] == 8000000){ //TK
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 59)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid TK
                    } else if($pegawai['id_unitkerjamaster'] == 8010000) { //SD
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 57)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid SD
                    } else if($pegawai['id_unitkerjamaster'] == 8020000) { //SMP
                        $kepala = $this->baseQueryAtasan()
                                        ->where('a.id_m_bidang', 58)
                                        ->where('d.jenis_jabatan', 'Struktural')
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array(); //kabid SMP
                    }
                    $atasan = $kepala;   
                }
            } else if($pegawai['id_unitkerjamaster'] == 6000000){ //puskesmas
                $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('d.kepalaskpd', 1)
                                        ->get()->row_array(); //kapus
                $kepala = $atasan;
            } else if(stringStartWith('Kecamatan', $pegawai['nm_unitkerja'])){
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] != "Struktural"){ //cari kepala sub
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
                                    ->get()->row_array();
                    if(!$atasan){ //cari sek
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('f.id_eselon', 7)
                                        ->get()->row_array();
                        if(!$atasan){ //cari camat
                            $atasan = $kepala;
                        }
                    }
                } else if ($pegawai['jenis_jabatan'] == "Struktural"){ // seklur
                    if($pegawai['id_eselon'] == 7){ // ESELON III, cari camat
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('f.id_eselon', 6)
                                    ->get()->row_array();
                        if(!$atasan){ //cari kepala
                            $atasan = $kepala;
                        }
                    } else if($pegawai['id_eselon'] == 7){ // ESELON III, kabid atau sek
                        $atasan = $kepala;
                    }
                }
            } else if(stringStartWith('Kelurahan', $pegawai['nm_unitkerja'])){
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] != "Struktural"){ //cari kepala sub
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
                                    ->get()->row_array();
                    if(!$atasan){ //cari sek
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('f.id_eselon', 8)
                                        ->get()->row_array();
                        if(!$atasan){ //cari lurah
                            $atasan = $kepala;
                        }
                    }
                } else if ($pegawai['jenis_jabatan'] == "Struktural"){ // seklur
                    if($pegawai['id_eselon'] == 9){ // ESELON IV, cari lurah
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('f.id_eselon', 8)
                                    ->get()->row_array();
                        if(!$atasan){ //cari kepala
                            $atasan = $kepala;
                        }
                    } else if($pegawai['id_eselon'] == 9){ // ESELON III, kabid atau sek
                        $atasan = $kepala;
                    }
                }
            }
        } else if($pegawai['kepalaskpd'] == 1){
            if(stringStartWith('Kelurahan', $pegawai['nm_unitkerja'])){ // jika lurah
                $atasan = $this->baseQueryAtasan()
                                ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                ->where('f.id_eselon', 6)
                                ->get()->row_array(); //cari camat
                $kepala = $atasan;
            } else if(stringStartWith('Puskesmas', $pegawai['nm_unitkerja'])) {// jika kapus
                $atasan = $this->baseQueryAtasan()
                                ->where('c.id_unitkerja', 3012000)
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array(); // cari kadis dinas kesehatan
                if(!$atasan){
                    $atasan = $this->baseQueryAtasan()
                                ->where('c.id_unitkerja', 3012000)
                                ->where('f.id_eselon', 6)
                                ->get()->row_array(); // cari sekdis dinas kesehatan
                }
                $kepala = $atasan;
            } else {
                $atasan = $this->baseQueryAtasan()
                                ->where('f.id_eselon', 4)
                                ->get()->row_array(); // cari setda
                $kepala = $atasan;
            }
        }
        return ['atasan' => $atasan, 'kepala' => $kepala];
    }

    public function createSkpBulanan($data){
        // $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        // a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang,
        // (SELECT aa.nm_jabatan FROM db_pegawai.pegjabatan aa WHERE b.id_peg = aa.id_pegawai ORDER BY aa.tmtjabatan DESC LIMIT 1) as nama_jabatan')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->where('a.id',$this->general_library->getId())
        //                     ->get()->row_array();

        $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan,
        a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, g.nama_sub_bidang, a.id_m_sub_bidang, d.nama_jabatan, d.kepalaskpd, f.id_eselon')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('db_pegawai.eselon f', 'd.eselon = f.nm_eselon')
                            ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
                            ->join('m_sub_bidang g', 'g.id = a.id_m_sub_bidang', 'left')
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->where('b.nipbaru_ws', '197405122009022003')
                            // ->where('a.id',$this->general_library->getId())
                            ->get()->row_array();

        $data_atasan = $this->getAtasanPegawai($pegawai);
        // dd($data_atasan);
        $kepala_pd = $data_atasan['kepala'];
        $atasan_pegawai = $data_atasan['atasan'];
        // dd($pegawai);
        // $atasan = "";
        // $flag_sekolah = false;
        // $flag_kelurahan = false;
        // $flag_kecamatan = false;
        // $explodeuk = explode(" ", $pegawai['nm_unitkerja']);
        // $kepala_pd = "kepalabadan";

        // if($this->general_library->isPelaksana() || $this->general_library->isKasub()){
        //     $atasan = 'kepalabidang';
          
        //     if($explodeuk[0] == 'Kelurahan'){
        //         $flag_kelurahan = true;
        //         $atasan = 'sekretarisbadan';
        //         $kepala_pd = "lurah";
        //     } else if($explodeuk[0] == 'Kecamatan'){
        //         $flag_kecamatan = true;
        //         $atasan = 'sekretarisbadan';
        //         $kepala_pd = "camat";
        //     }

        //     if($pegawai['nama_bidang'] == 'Sekretariat'){
        //         $atasan = 'subkoordinator';
        //     }
             
        // } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
            
        //     $atasan = 'kepalabadan';
        //     if($explodeuk[0] == 'Kelurahan'){
        //         $flag_kelurahan = true;
        //         $atasan = 'lurah';
        //         $kepala_pd = "camat";
        //     } else if($explodeuk[0] == 'Kecamatan'){
        //         $flag_kecamatan = true;
        //         $atasan = 'camat';
        //         $kepala_pd = "setda";
        //     }
             
        // } else if($this->general_library->isKaban()){
        //     $atasan = 'setda';
        // } else if($this->general_library->isSetda()){
        //     $atasan = 'walikota';
        // } else if($this->general_library->isGuruStaffSekolah()){
        //     $atasan = 'kepalasekolah';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isKepalaSekolah()){
        //     $atasan = 'kepalabidang';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isLurah()){
        //     $atasan = 'camat';
        //     $kepala_pd = "setda";
        //     $flag_kelurahan = true;
        // } else if($this->general_library->isCamat()){
        //     $atasan = 'setda';
        //     $kepala_pd = "setda";
        //     $flag_kecamatan = true;
        // }
        

        // $flag_sekolah = false;
        // if($this->general_library->isPelaksana()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKaban()){
        //     $kepala_pd = 'setda';
        // } else if($this->general_library->isSetda()){
        //     $kepala_pd = 'walikota';
        // } else if($this->general_library->isGuruStaffSekolah()){
        //     $kepala_pd = 'kepalasekolah';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isKepalaSekolah()){
        //     $kepala_pd = 'kepalabidang';
        //     $flag_sekolah = true;
        // }

    
        // dd($kepala_pd);
        // $atasan_pegawai = null;
        // if($flag_sekolah){
        //     //kepala pd guru dan kepsek adalah kadis pendidikan
        //     $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('b.skpd', ID_UNITKERJA_DIKBUD)
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $kepala_pd)
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //     if($this->general_library->isGuruStaffSekolah()){
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     // ->where('a.id_m_bidang', $pegawai['id_m_bidang'])
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $atasan)
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //     } else if ($this->general_library->isKepalaSekolah()){
        //         $id_role_kabid = '58'; //kepsek SMP
        //         if($pegawai['id_unitkerjamaster'] == '8010000'){
        //             $id_role_kabid = '57'; //kepsek SD
        //         }
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('a.id_m_bidang', $id_role_kabid)
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $atasan)
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //     }
        // } else if($flag_kecamatan || $flag_kelurahan){
        //     //jika pegawai kecamatan atau kelurahan
        //     // $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, f.id_m_bidang')
        //     //                             ->from('m_user a')
        //     //                             ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //     //                             ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //     //                             ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //     //                             ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //     //                             ->join('m_sub_bidang f', 'a.id_m_sub_bidang = f.id')
        //     //                             ->join('m_user_role g', 'a.id = g.id_m_user')
        //     //                             ->join('m_role h', 'g.id_m_role = h.id')
        //     //                             ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
        //     //                             ->where('a.id !=', $this->general_library->getId())
        //     //                             ->where('h.role_name', $atasan)
        //     //                             ->where('a.flag_active', 1)
        //     //                             ->where('g.flag_active', 1)
        //     //                             ->group_by('a.id')
        //     //                             ->limit(1)
        //     //                             ->get()->row_array();

        //     if($atasan == 'lurah' || $atasan == 'sekretarisbadan'){
        //         //jika atasan lurah, maka kepala_pd camat
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $atasan)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();

        //         $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $kepala_pd)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();
        //     } else if($atasan == 'camat') {
        //         //jika atasan camat, maka kepala_pd setda
        //         if($flag_kelurahan){
        //             $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $atasan)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();
        //         } else {
        //             $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $atasan)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();
        //         }

        //         $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 // ->where('b.skpd', $pegawai['id_unitkerja'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $kepala_pd)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();
        //     } else if ($atasan == 'setda'){
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 // ->where('b.skpd', $pegawai['id_unitkerja'])
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $kepala_pd)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)
        //                                 ->get()->row_array();
        //         $kepala_pd = $atasan_pegawai;
        //     }
        // } else {
        //     $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('b.skpd', $pegawai['id_unitkerja'])
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $kepala_pd)
        //                     ->where('g.flag_active', 1)
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //     if($atasan == 'kepalabadan'){
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $atasan)
        //                                 ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1)->get()->row_array();
        //     } else {
        //         $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                                 ->from('m_user a')
        //                                 ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                                 ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                                 ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                                 ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                                 ->join('m_user_role g', 'a.id = g.id_m_user')
        //                                 ->join('m_role h', 'g.id_m_role = h.id')
        //                                 ->where('a.id !=', $this->general_library->getId())
        //                                 ->where('h.role_name', $atasan)
        //                                 ->where('a.flag_active', 1)
        //                                 ->where('g.flag_active', 1)
        //                                 ->where('id_m_status_pegawai', 1)
        //                                 ->group_by('a.id')
        //                                 ->limit(1);

        //         if($atasan != 'setda'){
        //             $this->db->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
        //                     ->where('a.id_m_bidang', $pegawai['id_m_bidang']);
        //         }

        //         if($pegawai['nama_bidang'] == 'Sekretariat' && $atasan == 'subkoordinator'){
        //             $this->db->where('a.id_m_sub_bidang', $pegawai['id_m_sub_bidang'])
        //                     ->where('d.eselon !=', "Non Eselon");
        //         }

        //         $atasan_pegawai = $this->db->get()->row_array();
        //     }
        //     if(!$atasan_pegawai){
        //         $atasan = 'sekretarisbadan';
        //         $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $atasan)
        //                     ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //         if(!$atasan_pegawai){
        //             $atasan = 'kepalabadan';
        //             $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_user_role g', 'a.id = g.id_m_user')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('a.id !=', $this->general_library->getId())
        //                     ->where('h.role_name', $atasan)
        //                     ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
        //                     ->where('g.flag_active', 1)
        //                     ->where('a.flag_active', 1)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->group_by('a.id')
        //                     ->limit(1)
        //                     ->get()->row_array();
        //         }
        //     }
        // }

        $rencana_kinerja = $this->db->select('a.*,
                                (SELECT SUM(b.realisasi_target_kuantitas)
                                FROM t_kegiatan b
                                WHERE b.id_t_rencana_kinerja = a.id
                                AND b.flag_active = 1 and b.status_verif = 1) as realisasi')
                                ->from('t_rencana_kinerja a')
                                ->where('a.id_m_user', $pegawai['id'])
                                ->where('a.bulan', floatval($data['bulan']))
                                ->where('a.tahun', floatval($data['tahun']))
                                ->where('a.flag_active', 1)
                                ->order_by('a.created_date')
                                ->get()->result_array();
        
        $komponen_kinerja = $this->db->select('*')
                                    ->from('t_komponen_kinerja a')
                                    ->where('a.id_m_user', $pegawai['id'])
                                    ->where('a.bulan', floatval($data['bulan']))
                                    ->where('a.tahun', floatval($data['tahun']))
                                    ->where('a.flag_active', 1)
                                    ->get()->row_array();

        return [$pegawai, $atasan_pegawai, $rencana_kinerja, $kepala_pd, $komponen_kinerja];
    }

    public function createSkpBulananVerif($data){
        $pegawai = $this->db->select('h.role_name,a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang,
        (SELECT aa.nm_jabatan FROM db_pegawai.pegjabatan aa WHERE b.id_peg = aa.id_pegawai ORDER BY aa.tmtjabatan DESC LIMIT 1) as nama_jabatan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
                            ->join('m_user_role g', 'g.id_m_user = a.id')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.flag_active', 1)
                            ->where('h.id !=', 5)
                            ->where('id_m_status_pegawai', 1)
                            ->where('a.id', $data['id_user'])
                            ->get()->row_array();
        // dd($pegawai);
        $atasan = "";
        $flag_sekolah = false;
        $flag_kelurahan = false;
        $flag_kecamatan = false;
        $explodeuk = explode(" ", $pegawai['nm_unitkerja']);
        $kepala_pd = "kepalabadan";
        $role = $pegawai['role_name'];
        // dd($role);
      

        if($role == "staffpelaksana" || $role ==  "subkoordinator"){
            $atasan = 'kepalabidang';
          
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "lurah";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "camat";
            }

            if($pegawai['nama_bidang'] == 'Sekretariat'){
                $atasan = 'subkoordinator';
            }
             
        } else if( $role =="kepalabidang" || $role == "sekretarisbadan"){
            
            $atasan = 'kepalabadan';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'lurah';
                $kepala_pd = "camat";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'camat';
                $kepala_pd = "setda";
            }
             
        } else if($this->general_library->isKaban()){
            $atasan = 'setda';
        } else if($this->general_library->isSetda()){
            $atasan = 'walikota';
        } else if($this->general_library->isGuruStaffSekolah()){
            $atasan = 'kepalasekolah';
            $flag_sekolah = true;
        } else if($this->general_library->isKepalaSekolah()){
            $atasan = 'kepalabidang';
            $flag_sekolah = true;
        } else if($this->general_library->isLurah()){
            $atasan = 'camat';
            $kepala_pd = "setda";
            $flag_kelurahan = true;
        } else if($this->general_library->isCamat()){
            $atasan = 'setda';
            $kepala_pd = "setda";
            $flag_kecamatan = true;
        }
        // dd($atasan);

        // $flag_sekolah = false;
        // if($this->general_library->isPelaksana()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKaban()){
        //     $kepala_pd = 'setda';
        // } else if($this->general_library->isSetda()){
        //     $kepala_pd = 'walikota';
        // } else if($this->general_library->isGuruStaffSekolah()){
        //     $kepala_pd = 'kepalasekolah';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isKepalaSekolah()){
        //     $kepala_pd = 'kepalabidang';
        //     $flag_sekolah = true;
        // }

    
        // dd($kepala_pd);
        $atasan_pegawai = null;
        if($flag_sekolah){
            //kepala pd guru dan kepsek adalah kadis pendidikan
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', ID_UNITKERJA_DIKBUD)
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $kepala_pd)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($this->general_library->isGuruStaffSekolah()){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            // ->where('a.id_m_bidang', $pegawai['id_m_bidang'])
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            } else if ($this->general_library->isKepalaSekolah()){
                $id_role_kabid = '58'; //kepsek SMP
                if($pegawai['id_unitkerjamaster'] == '8010000'){
                    $id_role_kabid = '57'; //kepsek SD
                }
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id_m_bidang', $id_role_kabid)
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            }
        } else if($flag_kecamatan || $flag_kelurahan){
            //jika pegawai kecamatan atau kelurahan
            // $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, f.id_m_bidang')
            //                             ->from('m_user a')
            //                             ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            //                             ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
            //                             ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
            //                             ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
            //                             ->join('m_sub_bidang f', 'a.id_m_sub_bidang = f.id')
            //                             ->join('m_user_role g', 'a.id = g.id_m_user')
            //                             ->join('m_role h', 'g.id_m_role = h.id')
            //                             ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
            //                             ->where('a.id !=', $this->general_library->getId())
            //                             ->where('h.role_name', $atasan)
            //                             ->where('a.flag_active', 1)
            //                             ->where('g.flag_active', 1)
            //                             ->group_by('a.id')
            //                             ->limit(1)
            //                             ->get()->row_array();

            if($atasan == 'lurah' || $atasan == 'sekretarisbadan'){
                //jika atasan lurah, maka kepala_pd camat
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if($atasan == 'camat') {
                //jika atasan camat, maka kepala_pd setda
                if($flag_kelurahan){
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                } else {
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                }

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if ($atasan == 'setda'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                $kepala_pd = $atasan_pegawai;
            }
        } else {
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('a.id !=', $pegawai['id'])
                            ->where('h.role_name', $kepala_pd)
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($atasan == 'kepalabadan'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $pegawai['id'])
                                        ->where('h.role_name', $atasan)
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)->get()->row_array();
            } else {
                $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $pegawai['id'])
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1);

                if($atasan != 'setda'){
                    $this->db->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('a.id_m_bidang', $pegawai['id_m_bidang']);
                }

                if($pegawai['nama_bidang'] == 'Sekretariat' && $atasan == 'subkoordinator'){
                    $this->db->where('a.id_m_sub_bidang', $pegawai['id_m_sub_bidang'])
                            ->where('d.eselon !=', "Non Eselon");
                }

                $atasan_pegawai = $this->db->get()->row_array();
            }
            if(!$atasan_pegawai){
                $atasan = 'sekretarisbadan';
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                if(!$atasan_pegawai){
                    $atasan = 'kepalabadan';
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                }
            }
        }

        $rencana_kinerja = $this->db->select('a.*,
                                (SELECT SUM(b.realisasi_target_kuantitas)
                                FROM t_kegiatan b
                                WHERE b.id_t_rencana_kinerja = a.id
                                AND b.flag_active = 1) as realisasi')
                                ->from('t_rencana_kinerja a')
                                ->where('a.id_m_user', $pegawai['id'])
                                ->where('a.bulan', floatval($data['bulan']))
                                ->where('a.tahun', floatval($data['tahun']))
                                ->where('a.flag_active', 1)
                                ->order_by('a.created_date')
                                ->get()->result_array();
        
        $komponen_kinerja = $this->db->select('*')
                                    ->from('t_komponen_kinerja a')
                                    ->where('a.id_m_user', $pegawai['id'])
                                    ->where('a.bulan', floatval($data['bulan']))
                                    ->where('a.tahun', floatval($data['tahun']))
                                    ->where('a.flag_active', 1)
                                    ->get()->row_array();

        return [$pegawai, $atasan_pegawai, $rencana_kinerja, $kepala_pd, $komponen_kinerja];
    }


    public function getListRencanaKinerjaTugas(){
        return $this->db->select('a.tugas_jabatan')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.flag_active', 1)
                        ->group_by('a.tugas_jabatan')
                        ->get()->result_array();
    }

    public function getListRencanaKinerjaSasaran(){
        return $this->db->select('a.sasaran_kerja')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.flag_active', 1)
                        ->group_by('a.sasaran_kerja')
                        ->get()->result_array();
    }

    public function loadDataPendukungByStatus($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('a.flag_active', 1)
        ->where('id_m_status_pegawai', 1)
        ->order_by('a.created_date', 'desc');
        
        if($this->general_library->isAdministrator()){
           $this->db->where('c.skpd', $this->general_library->getUnitKerjaPegawai()); 
        } 
        // else if($this->general_library->isProgrammer ) {
        //     $this->db->where('a.id_m_user', $this->general_library->getId());
        // } 
        else {
            $this->db->where('a.id_m_user', $this->general_library->getId());
        }

        $result = $this->db->get()->result_array();

        $id_count = $this->general_library->getId();
        if($this->general_library->isAdministrator() || $this->general_library->isProgrammer()){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        } 

        if($result){
            $temp = $result;
            $result = null;
            foreach($temp as $t){
                if(isset($result[$t['nip'].$t['dokumen_pendukung']])){
                    //jika tanggal kurang dari tanggal "dari_tanggal", maka tanggal di data $t yang baru akan menjadi data "dari_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) < formatDateOnly($result[$t['nip'].$t['dokumen_pendukung']]['dari_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }

                    //jika tanggal lebih dari tanggal "sampai_tanggal", maka tanggal di data $t yang baru akan menjadi data "sampai_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) > formatDateOnly($result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }

                    $result[$t['nip'].$t['dokumen_pendukung']]['list_id'][] = $t['id'];
                } else {
                    $result[$t['nip'].$t['dokumen_pendukung']] = $t;
                    $result[$t['nip'].$t['dokumen_pendukung']]['list_id'][] = $t['id'];
                    $result[$t['nip'].$t['dokumen_pendukung']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                }
            }
        }

        $count = $this->countTotalDataPendukung($id_count, $bulan, $tahun);
        // if($status == 1){
        //     $count['pengajuan'] = count($result);
        // } else if($status == 2){
        //     $count['diterima'] = count($result);
        // } else if($status == 3){
        //     $count['ditolak'] = count($result);
        // } else if($status == 4){
        //     $count['batal'] = count($result);
        // }
        return [$result, $count];
    }

    public function searchDisiplinKerja($data){
        $result = null;

        if(!isset($data['id_unitkerja'])){
            if($this->general_library->isProgrammer() || $this->general_library->isAdministrator()) {
                $data['id_unitkerja'] = $this->general_library->getUnitKerjaPegawai();
            }
        }

        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
            ->from('t_dokumen_pendukung a')
            ->join('m_user b', 'a.id_m_user = b.id')
            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
            ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
            ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
            ->where('a.bulan', floatval($data['bulan']))
            ->where('a.tahun', floatval($data['tahun']))
            ->where('a.flag_active', 1)
            ->where('id_m_status_pegawai', 1)
            ->order_by('a.created_date', 'desc');
        if(isset($data['id_unitkerja'])){
            $this->db->where('c.skpd', $data['id_unitkerja']);
        } else {
            $this->db->where('a.id_m_user', $this->general_library->getId());
        }
        $disiplin_kerja = $this->db->get()->result_array();
        // if(!isset($data['id_unitkerja'])){
            $result['pengajuan'] = [];
            $result['diterima'] = [];
            $result['ditolak'] = [];
            $result['batal'] = [];
            if($disiplin_kerja){
                foreach($disiplin_kerja as $d){
                    if($d['status'] == 1){
                        $result['pengajuan'][] = $d;
                    } else if($d['status'] == 2){
                        $result['diterima'][] = $d;
                    } else if($d['status'] == 3){
                        $result['ditolak'][] = $d;
                    } else if($d['status'] == 4){
                        $result['batal'][] = $d;
                    }
                }
            }
            return $result;
        // }

        // if($disiplin_kerja){
        //     foreach($disiplin_kerja as $dk){
        //         $result[$dk['nip']]['nip'] = $dk['nip'];
        //         $result[$dk['nip']]['nama'] = getNamaPegawaiFull($dk);
        //         $result[$dk['nip']]['id_m_user'] = $dk['id_m_user'];
                
        //         if(isset($result[$dk['nip']]['jenis_disiplin'])){
        //             if(!in_array($dk['keterangan'], $result[$dk['nip']]['jenis_disiplin'])){
        //                 $result[$dk['nip']]['jenis_disiplin'][] = $dk['keterangan'];
        //             }
        //         } else {
        //             $result[$dk['nip']]['jenis_disiplin'][] = $dk['keterangan'];
        //         }
        //     }
        // }

        // return $result;
    }

    public function insertDisiplinKerja($data, $filename){
        $rs['code'] = 0;
        $rs['message'] = '';

        $this->db->trans_begin();

        $tanggal = explodeRangeDateNew($data['range_periode']);
        $jenis_disiplin = explode(';', $data['jenis_disiplin']);

        $list_tanggal = getDateBetweenDates($tanggal[0], $tanggal[1]);
        
        $insert_data = null;
        $i = 0;
        foreach($data['pegawai'] as $d){
            $disiplin = explode(';', $data['jenis_disiplin']);
            foreach($list_tanggal as $l){
                // if(getNamaHari($l) != 'Sabtu' && getNamaHari($l) != 'Minggu'){
                    $date = explode('-', $l);
                    $insert_data[$i]['id_m_user'] = $d;
                    $insert_data[$i]['tahun'] = $date[0];
                    $insert_data[$i]['bulan'] = $date[1];
                    $insert_data[$i]['tanggal'] = $date[2];
                    $insert_data[$i]['id_m_jenis_disiplin_kerja'] = $disiplin[0];
                    if($disiplin[0] == 14){
                        if($data['jenis_tugas_luar'] == 'Tugas Luar Pagi'){
                            $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 19;
                        } else if($data['jenis_tugas_luar'] == 'Tugas Luar Sore'){
                            $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 20;
                        }
                        $insert_data[$i]['keterangan'] = $data['jenis_tugas_luar'];
                    } else {
                        $insert_data[$i]['keterangan'] = $disiplin[1];
                    }
                   
                    $insert_data[$i]['pengurangan'] = $disiplin[2];
                    $insert_data[$i]['dokumen_pendukung'] = $filename;
                    $insert_data[$i]['created_by'] = $this->general_library->getId();

                    $i++;
                // }
            }
        }
        $this->db->insert_batch('t_dokumen_pendukung', $insert_data);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $rs;
    }

    public function countTotalDataPendukung($id, $bulan, $tahun, $flag_verif = 0){
        $rs['pengajuan'] = 0;
        $rs['diterima'] = 0;
        $rs['ditolak'] = 0;
        $rs['batal'] = 0;

        $this->db->select('a.*')
                ->from('t_dokumen_pendukung a')
                ->join('m_status_dokumen_pendukung b', 'a.status = b.id')
                ->join('m_user c', 'a.id_m_user = c.id')
                ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                ->where('a.bulan', floatval($bulan))
                ->where('a.tahun', floatval($tahun))
                ->where('a.flag_active', 1)
                ->where('id_m_status_pegawai', 1)
                ->group_by('a.status, a.dokumen_pendukung, a.id_m_jenis_disiplin_kerja, a.id_m_user');

        if($this->general_library->isProgrammer() || $this->general_library->isAdministrator() || ($this->general_library->getBidangUser() == ID_BIDANG_PEKIN && $flag_verif == 1)){
            $this->db->where('d.skpd', $id);
        } else {
            $this->db->where('a.id_m_user', $id);
        }
        
        $tempdata = $this->db->get()->result_array(); 
        $rs['pengajuan'] = 0;
        $rs['diterima'] = 0;
        $rs['ditolak'] = 0;
        $rs['batal'] = 0;
        
        if($tempdata){
            foreach($tempdata as $t){
                if($t['status'] == 1){
                    $rs['pengajuan']++;
                } else if($t['status'] == 2){
                    $rs['diterima']++;
                } else if($t['status'] == 3){
                    $rs['ditolak']++;
                } else if($t['status'] == 4){
                    $rs['batal']++;
                }
            }
        }
        // if($count){
        //     foreach($count as $c){
        //         if($c['status'] == 1){
        //             $rs['pengajuan'] = $c['total'];
        //         } else if($c['status'] == 2){
        //             $rs['diterima'] = $c['total'];
        //         } else if($c['status'] == 3){
        //             $rs['ditolak'] = $c['total'];
        //         } else if($c['status'] == 4){
        //             $rs['batal'] = $c['total'];
        //         }
        //     }
        // }

        return $rs;
    }

    public function deleteDataDisiplinKerja($id){
        $res['code'] = 0;
        $res['message'] = 'OK';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where_in('id', $this->input->post('list_id'))
                ->update('t_dokumen_pendukung', ['flag_active' => 0]);
        
        $tmp = $this->db->select('*')
                        ->from('t_dokumen_pendukung', $id)
                        ->get()->row_array();

        $id_count = $tmp['id_m_user'];
        if($this->general_library->isProgrammer() || $this->general_library->isAdministrator()){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        }
        $res['data'] = $this->countTotalDataPendukung($id_count, $tmp['bulan'], $tmp['tahun']);

        if(!$res['data']){
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan Saat Menghapus Data';
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }
        
        return $res;
    }

    public function deleteDataDisiplinKerjaByIdUser($data){
        $this->db->where('id_m_user', $data['id_m_user'])
                ->where('bulan', $data['bulan'])
                ->where('tahun', $data['tahun'])
                ->update('t_dokumen_pendukung', ['flag_active' => 0]);
    }

    public function cekRencanaKinerjaApelPagi(){

        $this->db->trans_begin();
        $bulan = date('n');
        $kegiatan = "Mengikuti Apel Pagi";
         $cekApelPagi = $this->db->select('*')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.bulan', $bulan)
                        ->where('a.tugas_jabatan', $kegiatan)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();
                       
        if(!$cekApelPagi) {
            $data["id_m_user"] = $this->general_library->getId();
            $data["tugas_jabatan"] = "Mengikuti Apel Pagi";
            $data["sasaran_kerja"] = "Terciptanya Disiplin Pegawai";
            $data["tahun"] = 2022;
            $data["bulan"] = 6;
            $data["target_kuantitas"] = 1;
            $data["satuan"] = "Kegiatan";
            $data["target_kualitas"] = 100;
            $this->db->insert('t_rencana_kinerja', $data);
        } 

        if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
            }
            else
            {
                    $this->db->trans_commit();
            }        
    }
    
    public function openModalDetailDisiplinKerja($id, $bulan, $tahun){
        return $this->db->select('a.*, c.nama, c.gelar1, c.gelar2, b.username as nip, b.id as id_m_user')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'c.nipbaru_ws = b.username')
                        ->where('b.id', $id)
                        ->where('a.bulan', $bulan)
                        ->where('a.tahun', $tahun)
                        ->where('a.flag_active', 1)
                        ->order_by('a.created_date', 'desc')
                        ->where('id_m_status_pegawai', 1)
                        ->get()->result_array();
    }

    public function searchVerifDokumen($data){
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen')
            ->from('t_dokumen_pendukung a')
            ->join('m_user b', 'a.id_m_user = b.id')
            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
            ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
            ->where('a.bulan', floatval($data['bulan']))
            ->where('a.tahun', floatval($data['tahun']))
            ->where('c.skpd', $data['id_unitkerja'])
            ->where('a.flag_active', 1)
            ->where('id_m_status_pegawai', 1)
            ->order_by('a.created_date', 'desc');

        $disiplin_kerja = $this->db->get()->result_array();
        // if(!isset($data['id_unitkerja'])){
            $result['pengajuan'] = [];
            $result['diterima'] = [];
            $result['ditolak'] = [];
            $result['batal'] = [];
            if($disiplin_kerja){
                foreach($disiplin_kerja as $d){
                    if($d['status'] == 1){
                        $result['pengajuan'][] = $d;
                    } else if($d['status'] == 2){
                        $result['diterima'][] = $d;
                    } else if($d['status'] == 3){
                        $result['ditolak'][] = $d;
                    } else if($d['status'] == 4){
                        $result['batal'][] = $d;
                    }
                }
            }
            return $result;
    }

    public function loadSearchVerifDokumen($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('a.id_m_jenis_disiplin_kerja, c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('c.skpd', $id_unitkerja)
        ->where('id_m_status_pegawai', 1)
        ->where('a.flag_active', 1);

        if($status == 1){
            $this->db->order_by('created_date', 'asc');
        } else {
            $this->db->order_by('a.updated_date', 'desc');
        }

        $result = $this->db->get()->result_array();
        if($result){
            $temp = $result;
            $result = null;
            foreach($temp as $t){
                if(isset($result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']])){
                    //jika tanggal kurang dari tanggal "dari_tanggal", maka tanggal di data $t yang baru akan menjadi data "dari_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) < formatDateOnly($result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['dari_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }

                    //jika tanggal lebih dari tanggal "sampai_tanggal", maka tanggal di data $t yang baru akan menjadi data "sampai_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) > formatDateOnly($result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['sampai_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['list_id'][] = $t['id'];
                } else {
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']] = $t;
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['list_id'][] = $t['id'];
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['id_m_jenis_disiplin_kerja']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                }
            }
        }
        $id_count = $id_unitkerja;
        $count = $this->countTotalDataPendukung($id_count, $bulan, $tahun, 1);
        return [$result, $count];
    }
    
    public function verifDokumen($id, $status){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';        
        $this->db->trans_begin();

        $data_verif['status'] = $status;
        $data_verif['id_m_user_verif'] = $this->general_library->getId();
        $data_verif['updated_by'] = $this->general_library->getId();
        $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
        if($status == 2 || $status == 3){
            $data_verif['keterangan_verif'] = $this->input->post('keterangan');
        }

        $this->db->where_in('id', $this->input->post('list_id'))
                ->update('t_dokumen_pendukung', $data_verif);

        $temp = $this->db->select('c.skpd, a.bulan, a.tahun')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.id', $id)
                        ->where('id_m_status_pegawai', 1)
                        ->get()->row_array();

        $rs['data'] = $this->countTotalDataPendukung($temp['skpd'], $temp['bulan'], $temp['tahun'], 1);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;        
            $rs['message'] = 'Terjadi Kesalahan';
        }else{
            $this->db->trans_commit();
        }
        
        return $rs;
    }


    public function getPaguTppUnitKerja($id_unitkerja, $unitkerja){
        $result = null;
        $list_tpp_kelas_jabatan = $this->session->userdata('list_tpp_kelas_jabatan');
        $j = 1;
        foreach($list_tpp_kelas_jabatan as $lt){
            $result[$j]['jft'] = $lt;
            $result[$j]['jfu'] = $lt;
            $result[$j]['eselon_4'] = $lt;
            $result[$j]['kepala_skpd'] = $lt;
            $result[$j]['semua'] = $lt;
            $j++;
        }

        $flag_kec_kel_puskes = 0;
        if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)){
            $flag_kec_kel_puskes = 1;
        }

        if($flag_kec_kel_puskes == '0'){
            $explode_nama = explode(" ", $unitkerja['nm_unitkerja']);
            if($explode_nama[0] == 'Puskesmas'){
                $flag_kec_kel_puskes = 1;
            }
        }

        $presentase_tpp = $this->db->select('*')
                                ->from('m_presentase_tpp')
                                ->where('id_unitkerja', $id_unitkerja)
                                ->where('flag_active', 1)
                                ->get()->result_array();

        $presentase_semua = $this->db->select('*')
                            ->from('m_presentase_tpp')
                            ->where('id_unitkerja', $id_unitkerja)
                            ->where('kelas_jabatan', 0)
                            ->where('jenis_jabatan', 'semua')
                            ->where('flag_active', 1)
                            ->get()->result_array();

        if($presentase_tpp || $flag_kec_kel_puskes == 1){
            $temp_presentase_tpp = null;

            if($flag_kec_kel_puskes == 1 && !$presentase_tpp){ //jika unit kerja adalah kecamatan / kelurahan / puskesmas
                if(in_array($unitkerja['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN)){ // kecamatan
                    $presentase_tpp[0]['kelas_jabatan'] = 12;
                    $presentase_tpp[0]['presentase'] = 160;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                } else if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)) { // kelurahan
                    $presentase_tpp[0]['kelas_jabatan'] = 9;
                    $presentase_tpp[0]['presentase'] = 170;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                } else if($explode_nama[0] == 'Puskesmas'){ //puskesmas
                    $presentase_tpp[0]['kelas_jabatan'] = 9;
                    $presentase_tpp[0]['presentase'] = 290;
                    $presentase_tpp[0]['jenis_jabatan'] = 'kepala_skpd';
                }
            }

            $list_exclude = [];
            if($presentase_semua && (count($presentase_tpp) > 1)){ //jika ada syarat TPP untuk semua pegawai dan syarat TPP lebih dari 1 syarat di unit kerja tersebut
                $j = 1;
                foreach($presentase_tpp as $p){ //exclude jenis jabatan dan kelas jabatan tertentu dari presentase yang mewakili semua pegawai dalam PD
                    if($p['kelas_jabatan'] != '0' && $p['jenis_jabatan'] == 'semua'){
                        $list_exclude[$p['kelas_jabatan']] = ['jft', 'jfu', 'eselon_4', 'kepala_skpd'];
                    } else if($p['kelas_jabatan'] == '0' && $p['jenis_jabatan'] != 'semua'){
                        array_push($list_exclude[0], $p['jenis_jabatan']);
                    } else if($p['kelas_jabatan'] != '0' && $p['jenis_jabatan'] != 'semua'){
                        // $list_exclude[[$p['kelas_jabatan']]] = 1;
                        if(!isset($list_exclude[$p['kelas_jabatan']])){
                            $list_exclude[$p['kelas_jabatan']] = [];
                        }
                        array_push($list_exclude[$p['kelas_jabatan']], $p['jenis_jabatan']);
                    } 
                    $j++;
                }
            }

            foreach($presentase_tpp as $prt){
                if($prt['kelas_jabatan'] == '0' && $prt['jenis_jabatan'] == 'semua'){ // semua pegawai
                    $j = 1;
                    foreach($list_tpp_kelas_jabatan as $ltj){
                        if(!isset($list_exclude[$j])){
                            if(!isset($list_exclude[0]['jft'])){
                                $result[$j]['jft'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['jfu'])){
                                $result[$j]['jfu'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['eselon_4'])){
                                $result[$j]['eselon_4'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            if(!isset($list_exclude[0]['kepala_skpd'])){
                                $result[$j]['kepala_skpd'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                            }
                            $result[$j]['semua'] = floatval($ltj) * floatval($prt['presentase'] / 100);
                        }
                        $j++;
                    }
                } else if($prt['kelas_jabatan'] == '0'){ // semua kelas jabatan
                    $j = 1;
                    foreach($list_tpp_kelas_jabatan as $ltj){
                        $result[$j][$prt['jenis_jabatan']] = floatval($ltj) * floatval($prt['presentase'] / 100);
                        $j++;
                    }
                } else if($prt['jenis_jabatan'] == '0'){// semua jenis jabatan
                    // $j = 1;
                    // foreach($list_tpp_kelas_jabatan as $ltj){
                        $result[$prt['kelas_jabatan']]['jft'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['jfu'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['eselon_4'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['semua'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        $result[$prt['kelas_jabatan']]['kepala_skpd'] = floatval($list_tpp_kelas_jabatan[$prt['kelas_jabatan']]) * floatval($prt['presentase'] / 100);
                        // $j++;
                    // }
                    // if($prt['kelas_jabatan'] == 12){
                    //     dd($result[$prt['kelas_jabatan']]);
                    // }
                } else {
                    $result[$prt['kelas_jabatan']][$prt['jenis_jabatan']] = $list_tpp_kelas_jabatan[$prt['kelas_jabatan']] * ($prt['presentase'] / 100);
                }
            }
        }
        // dd(json_encode($result));
        return $result;
    }

    public function countPaguTpp($data, $id_pegawai = null){

        $result = null;

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $data['id_unitkerja'])
                            ->get()->row_array();

        $pagu_tpp = $this->getPaguTppUnitKerja($data['id_unitkerja'], $unitkerja);

        $nama_unit_kerja = explode(" ", $unitkerja['nm_unitkerja']);
                            
        $pegawai = $this->db->select('a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, e.id as id_m_user,
                            b.kelas_jabatan_jfu, b.kelas_jabatan_jft, b.id_pangkat, a.statuspeg,
                            (SELECT CONCAT(
                                IF( c.nama_jabatan IS NULL, "", c.nama_jabatan ),
                                    ";",
                                IF( c.kepalaskpd IS NULL, "", c.kepalaskpd ),
                                    ";",
                                IF( aa.jenisjabatan IS NULL, "", aa.jenisjabatan ),
                                    ";",
                                IF( d.id_eselon IS NULL, "", d.id_eselon ) 
                                ) 
                            FROM db_pegawai.pegjabatan aa
                            WHERE aa.id_pegawai = a.id_peg
                            ORDER BY tmtjabatan DESC
                            LIMIT 1) as jabatan')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                            ->join('db_pegawai.eselon d', 'c.eselon = d.nm_eselon')
                            ->join('m_user e', 'a.nipbaru_ws = e.username')
                            ->where('a.skpd', $data['id_unitkerja'])
                            ->order_by('c.eselon, a.nama')
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();
        // dd($pegawai);
        if($pegawai){
            $i = 0;
            foreach($pegawai as $p){
                $result[$p['id_m_user']] = $p;
                $result[$p['id_m_user']]['kepala_skpd'] = 0;
                $concat = explode(";", $p['jabatan']);
                $nama_jabatan = explode(" ", $concat[0]);
                $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jfu'];
                $result[$p['id_m_user']]['nama_jabatan'] = $concat[0];
                $result[$p['id_m_user']]['jenis_jabatan'] = 'jfu';
                // if($p['nipbaru_ws'] == '198701072011021001'){
                //     dd($nama_jabatan);
                //     // dd(
                //     //     (
                //     //         (
                //     //             isset($nama_jabatan[1]) && ($nama_jabatan[1] == 'Kepala')
                //     //         ) &&
                //     //         (
                //     //             isset($nama_jabatan[2]) && ($nama_jabatan[2] == 'Bagian') 
                //     //             || ($nama_jabatan[2] == 'Puskesmas')
                //     //         )
                //     //     )
                //     // );
                // }
                if((isset($concat[2]) && $concat[2] == '00') 
                || ((isset($nama_jabatan[0]) && ($nama_jabatan[0] == 'Kepala'))
                && (isset($nama_jabatan[1]) && ($nama_jabatan[1] == 'Bagian' || $nama_jabatan[1] == 'Puskesmas')))){ // pejabat struktural atau kepala puskesmas
                    if($concat[1] == 1){ // kepala skpd
                        $result[$p['id_m_user']]['kepala_skpd'] = 1;
                        $result[$p['id_m_user']]['jenis_jabatan'] = 'kepala_skpd';
                        $result[$p['id_m_user']]['kelas_jabatan'] = 14;
                        if($data['id_unitkerja'] == 1000001){ //setda
                            $result[$p['id_m_user']]['kelas_jabatan'] = 15;
                        } else if($nama_unit_kerja[0] == 'Kelurahan'){ // lurah
                            $result[$p['id_m_user']]['kelas_jabatan'] = 9;
                        } else if($nama_unit_kerja[0] == 'Kecamatan'){ // camat
                            $result[$p['id_m_user']]['kelas_jabatan'] = 12;
                        } else if($nama_unit_kerja[0] == 'Puskesmas'){ // kepala puskesmas
                            $result[$p['id_m_user']]['kelas_jabatan'] = 9;
                        } else if($nama_unit_kerja[0] == 'Bagian'){ // kepala bagian
                            $result[$p['id_m_user']]['kelas_jabatan'] = 12;
                        } else if($unitkerja['id_unitkerja'] == '7005020' || $unitkerja['id_unitkerja'] == '7005010'){ // RSUD & RSKDGDM
                            $result[$p['id_m_user']]['kelas_jabatan'] = 12;
                        }
                    } else {
                        $eselon_jabatan = explode(" ", $concat[3]);
                        // if($p['nipbaru_ws'] == '197504272000122003'){
                        //     dd($concat);
                        // }
                        if($concat[3] == 6 || $concat[3] == 7){ // pejabat eselon 3
                            if($concat[3] == 6){ // sekretaris, inspektur pembantu
                                $result[$p['id_m_user']]['kelas_jabatan'] = 12;
                            } else { //kabag, kabid
                                $result[$p['id_m_user']]['kelas_jabatan'] = 11;
                                if($nama_unit_kerja[0] == 'Kecamatan'){ // sekretaris kecamatan 
                                    $result[$p['id_m_user']]['kelas_jabatan'] = 11;
                                }
                            }
                            $result[$p['id_m_user']]['jenis_jabatan'] = 'semua';
                        } else if($concat[3] == 8 || $concat[3] == 9){ //eselon 4, kasubag, kasubid, seklur
                            $result[$p['id_m_user']]['kelas_jabatan'] = 9;
                            if($nama_unit_kerja[0] == 'Kelurahan' || $nama_unit_kerja[0] == 'Kecamatan'){
                                $result[$p['id_m_user']]['kelas_jabatan'] = 8;
                            }
                            $result[$p['id_m_user']]['jenis_jabatan'] = 'eselon_4';
                        } else if(($concat[3] == 4 || $concat[3] == 5) && $data['id_unitkerja'] == 1000001){ //asisten setda
                            $result[$p['id_m_user']]['kelas_jabatan'] = 14;
                        }
                    }
                } else if (isset($concat[2]) && $concat[2] == '10'){ // pejabat fungsional
                    $list_jfu = ['Pelaksana', 'Staff', 'Staf'];
                    $result[$p['id_m_user']]['jenis_jabatan'] = 'jfu';
                    // dd($p);
                    if(!in_array($concat[0], $list_jfu)){ // jft
                        $result[$p['id_m_user']]['jenis_jabatan'] = 'jft';
                        $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jft'];
                    }
                }

                unset($result[$p['id_m_user']]['kelas_jabatan_jfu']);
                unset($result[$p['id_m_user']]['kelas_jabatan_jft']);
                
                $result[$p['id_m_user']]['pagu_tpp'] = $pagu_tpp[$result[$p['id_m_user']]['kelas_jabatan']][$result[$p['id_m_user']]['jenis_jabatan']]; // pasang pagu tpp
                if($result[$p['id_m_user']]['statuspeg'] == 1){ //pegawai CPNS
                    $result[$p['id_m_user']]['pagu_tpp'] = $result[$p['id_m_user']]['pagu_tpp'] * 0.8;
                } else if($result[$p['id_m_user']]['statuspeg'] == 3){ //PPPK
                    $result[$p['id_m_user']]['pagu_tpp'] = 0;
                }
                // if($id_pegawai != null && $p['nipbaru_ws'] == $this->general_library->getUserName()){
                if($id_pegawai != null && $id_pegawai == $p['id_m_user']){
                    return $result[$p['id_m_user']];
                }
                $i++;
            }
        }

        function comparator($object1, $object2) {
            return $object1['kelas_jabatan'] < $object2['kelas_jabatan'];
        }

        usort($result, 'comparator');
        // dd($result);
        return $result;
    }

    function getAtasanPegawaiOld($id_m_user){
        $id_m_user = 203;
        $user = $this->db->select('a.*, b.*, d.role_name, e.nm_unitkerja, e.id_unitkerjamaster, g.nama_bidang')
                        ->from('db_pegawai.pegawai a')
                        ->join('m_user b', 'a.nipbaru_ws = b.username')
                        ->join('m_user_role c', 'b.id = c.id_m_user')
                        ->join('m_role d', 'c.id_m_role = d.id')
                        ->join('db_pegawai.unitkerja e', 'a.skpd = e.id_unitkerja')
                        // ->join('db_pegawai.unitkerjamaster f', 'e.id_unitkerjamaster = f.id_unitkerjamaster')
                        ->join('m_bidang g', 'b.id_m_bidang = g.id', 'left')
                        // ->join('m_sub_bidang h', 'b.id_m_sub_bidang = h.id')
                        ->where('b.id', $id_m_user)
                        ->where('b.flag_active', 1)
                        ->where('c.flag_active', 1)
                        ->where('id_m_status_pegawai', 1)
                        ->where_not_in('c.id_m_role', EXCLUDE_ID_ROLE_ATASAN)
                        ->get()->row_array();

        $atasan = "";
        $flag_sekolah = false;
        $flag_kelurahan = false;
        $flag_kecamatan = false;
        $explodeuk = explode(" ", $user['nm_unitkerja']);
        $kepala_pd = "kepalabadan";

        if($user['role_name'] == 'staffpelaksana' || $user['role_name'] == 'subkoordinator'){ //jika pelaksana atau kasub
            $atasan = 'kepalabidang';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "lurah";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "camat";
            }
        }

        if($user['nama_bidang'] == 'Sekretariat'){
            $atasan = 'subkoordinator';
        } else if($user['role_name'] == 'kepalabidang' || $user['role_name'] == 'sekretarisbadan'){
            $atasan = 'kepalabadan';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'lurah';
                $kepala_pd = "camat";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'camat';
                $kepala_pd = "setda";
            }
        } else if($user['role_name'] == 'kepalabadan'){
            $atasan = 'setda';
        } else if($user['role_name'] == 'setda'){
            $atasan = 'walikota';
        } else if($user['role_name'] == 'gurusekolah'){
            $atasan = 'kepalasekolah';
            $flag_sekolah = true;
        } else if($user['role_name'] == 'kepalasekolah'){
            $atasan = 'kepalabidang';
            $flag_sekolah = true;
        } else if($user['role_name'] == 'lurah'){
            $atasan = 'camat';
            $kepala_pd = "setda";
            $flag_kelurahan = true;
        } else if($user['role_name'] == 'camat'){
            $atasan = 'setda';
            $kepala_pd = "setda";
            $flag_kecamatan = true;
        }

        $this->db->select('a.*, b.*, d.role_name, e.nm_unitkerja, e.id_unitkerjamaster, g.nama_bidang')
            ->from('db_pegawai.pegawai a')
            ->join('m_user b', 'a.nipbaru_ws = b.username')
            ->join('m_user_role c', 'b.id = c.id_m_user')
            ->join('m_role d', 'c.id_m_role = d.id')
            ->join('db_pegawai.unitkerja e', 'a.skpd = e.id_unitkerja')
            // ->join('db_pegawai.unitkerjamaster f', 'e.id_unitkerjamaster = f.id_unitkerjamaster')
            ->join('m_bidang g', 'b.id_m_bidang = g.id')
            // ->join('m_sub_bidang h', 'b.id_m_sub_bidang = h.id')
            ->where('d.role_name', $atasan)
            ->where('a.skpd', $user['skpd'])
            // ->where('g.id', $user['id_m_bidang'])
            ->where('b.flag_active', 1)
            ->where('c.flag_active', 1)
            ->where('id_m_status_pegawai', 1)
            ->where_not_in('c.id_m_role', EXCLUDE_ID_ROLE_ATASAN);

        if(!$flag_sekolah){
            if(($flag_kelurahan && $user['role_name'] != 'lurah') || //bukan lurah
            ($flag_kecamatan && $user['role_name'] != 'camat')){
                $this->db->where('g.id', $user['id_m_bidang']);
            }
        }

        $atasan_pegawai = $this->db->get()->row_array();

        dd($atasan_pegawai);
    }

    public function getDataAtasan($id_pegawai){
        $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang,
        (SELECT aa.nm_jabatan FROM db_pegawai.pegjabatan aa WHERE b.id_peg = aa.id_pegawai ORDER BY aa.tmtjabatan DESC LIMIT 1) as nama_jabatan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id_pegawai)
                            ->where('id_m_status_pegawai', 1)
                            ->get()->row_array();
        // dd($pegawai);
        $atasan = "";
        $flag_sekolah = false;
        $flag_kelurahan = false;
        $flag_kecamatan = false;
        $explodeuk = explode(" ", $pegawai['nm_unitkerja']);
        $kepala_pd = "kepalabadan";

        if($this->general_library->isPelaksana() || $this->general_library->isKasub()){
            $atasan = 'kepalabidang';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "lurah";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'sekretarisbadan';
                $kepala_pd = "camat";
            }

            if($pegawai['nama_bidang'] == 'Sekretariat'){
                $atasan = 'subkoordinator';
            }
        } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
            $atasan = 'kepalabadan';
            if($explodeuk[0] == 'Kelurahan'){
                $flag_kelurahan = true;
                $atasan = 'lurah';
                $kepala_pd = "camat";
            } else if($explodeuk[0] == 'Kecamatan'){
                $flag_kecamatan = true;
                $atasan = 'camat';
                $kepala_pd = "setda";
            }
        } else if($this->general_library->isKaban()){
            $atasan = 'setda';
        } else if($this->general_library->isSetda()){
            $atasan = 'walikota';
        } else if($this->general_library->isGuruStaffSekolah()){
            $atasan = 'kepalasekolah';
            $flag_sekolah = true;
        } else if($this->general_library->isKepalaSekolah()){
            $atasan = 'kepalabidang';
            $flag_sekolah = true;
        } else if($this->general_library->isLurah()){
            $atasan = 'camat';
            $kepala_pd = "setda";
            $flag_kelurahan = true;
        } else if($this->general_library->isCamat()){
            $atasan = 'setda';
            $kepala_pd = "setda";
            $flag_kecamatan = true;
        }

        // $flag_sekolah = false;
        // if($this->general_library->isPelaksana()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKabid() || $this->general_library->isSekban()){
        //     $kepala_pd = 'kepalabadan';
        // } else if($this->general_library->isKaban()){
        //     $kepala_pd = 'setda';
        // } else if($this->general_library->isSetda()){
        //     $kepala_pd = 'walikota';
        // } else if($this->general_library->isGuruStaffSekolah()){
        //     $kepala_pd = 'kepalasekolah';
        //     $flag_sekolah = true;
        // } else if($this->general_library->isKepalaSekolah()){
        //     $kepala_pd = 'kepalabidang';
        //     $flag_sekolah = true;
        // }

    
        // dd($kepala_pd);
        $atasan_pegawai = null;
        if($flag_sekolah){
            //kepala pd guru dan kepsek adalah kadis pendidikan
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', ID_UNITKERJA_DIKBUD)
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $kepala_pd)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($this->general_library->isGuruStaffSekolah()){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            // ->where('a.id_m_bidang', $pegawai['id_m_bidang'])
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            } else if ($this->general_library->isKepalaSekolah()){
                $id_role_kabid = '58'; //kepsek SMP
                if($pegawai['id_unitkerjamaster'] == '8010000'){
                    $id_role_kabid = '57'; //kepsek SD
                }
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id_m_bidang', $id_role_kabid)
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $atasan)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            }
        } else if($flag_kecamatan || $flag_kelurahan){
            //jika pegawai kecamatan atau kelurahan
            // $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, f.id_m_bidang')
            //                             ->from('m_user a')
            //                             ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            //                             ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
            //                             ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
            //                             ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
            //                             ->join('m_sub_bidang f', 'a.id_m_sub_bidang = f.id')
            //                             ->join('m_user_role g', 'a.id = g.id_m_user')
            //                             ->join('m_role h', 'g.id_m_role = h.id')
            //                             ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
            //                             ->where('a.id !=', $id_pegawai)
            //                             ->where('h.role_name', $atasan)
            //                             ->where('a.flag_active', 1)
            //                             ->where('g.flag_active', 1)
            //                             ->group_by('a.id')
            //                             ->limit(1)
            //                             ->get()->row_array();

            if($atasan == 'lurah' || $atasan == 'sekretarisbadan'){
                //jika atasan lurah, maka kepala_pd camat
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if($atasan == 'camat') {
                //jika atasan camat, maka kepala_pd setda
                if($flag_kelurahan){
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $atasan)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                } else {
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('c.id_unitkerja', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                }

                $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
            } else if ($atasan == 'setda'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        // ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $kepala_pd)
                                        ->where('g.flag_active', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)
                                        ->get()->row_array();
                $kepala_pd = $atasan_pegawai;
            }
        } else {
            $kepala_pd = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $kepala_pd)
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
            if($atasan == 'kepalabadan'){
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $atasan)
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1)->get()->row_array();
            } else {
                $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                                        ->from('m_user a')
                                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                                        ->join('m_user_role g', 'a.id = g.id_m_user')
                                        ->join('m_role h', 'g.id_m_role = h.id')
                                        ->where('a.id !=', $id_pegawai)
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
                                        ->where('id_m_status_pegawai', 1)
                                        ->group_by('a.id')
                                        ->limit(1);

                if($atasan != 'setda'){
                    $this->db->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('a.id_m_bidang', $pegawai['id_m_bidang']);
                }

                if($pegawai['nama_bidang'] == 'Sekretariat' && $atasan == 'subkoordinator'){
                    $this->db->where('a.id_m_sub_bidang', $pegawai['id_m_sub_bidang'])
                            ->where('d.eselon !=', "Non Eselon");
                }

                $atasan_pegawai = $this->db->get()->row_array();
            }
            if(!$atasan_pegawai){
                $atasan = 'sekretarisbadan';
                $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                if(!$atasan_pegawai){
                    $atasan = 'kepalabadan';
                    $atasan_pegawai = $this->db->select('a.id, b.nipbaru_ws, b.gelar1, b.nama, b.gelar2, c.nm_unitkerja, d.nama_jabatan, e.nm_pangkat, a.id_m_bidang')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
                            ->join('m_user_role g', 'a.id = g.id_m_user')
                            ->join('m_role h', 'g.id_m_role = h.id')
                            ->where('a.id !=', $id_pegawai)
                            ->where('h.role_name', $atasan)
                            ->where('b.skpd', $pegawai['id_unitkerja'])
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
                }
            }
        }
        return [$pegawai, $atasan_pegawai, $kepala_pd];
    }

    public function loadListSkbpPegawai($id_pegawai){
        $temp = null;
        $finalrs = null;
        $kinerja =  $this->db->select('a.*')
                    ->from('t_rencana_kinerja a')
                    ->where('a.id_m_user', $id_pegawai)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();

        $komponen_kinerja = $this->db->select('*')
                    ->from('t_komponen_kinerja a')
                    ->where('a.id_m_user', $id_pegawai)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();

        if($kinerja){
            foreach($kinerja as $rs){
                $temp[$rs['bulan'].$rs['tahun']]['bulan'] = floatval($rs['bulan']);
                $temp[$rs['bulan'].$rs['tahun']]['tahun'] = floatval($rs['tahun']);
                $temp[$rs['bulan'].$rs['tahun']]['kinerja']['nilai'] = null;
                $temp[$rs['bulan'].$rs['tahun']]['kinerja']['data'][] = $rs;
            }
        }

        if($komponen_kinerja){
            foreach($komponen_kinerja as $kk){
                $temp[$kk['bulan'].$kk['tahun']]['bulan'] = floatval($kk['bulan']);
                $temp[$kk['bulan'].$kk['tahun']]['tahun'] = floatval($kk['tahun']);
                $temp[$kk['bulan'].$kk['tahun']]['komponen']['data'] = $kk;
                $temp[$kk['bulan'].$kk['tahun']]['komponen']['nilai'] = null;
            }
        }

        if($temp){
            $i = 0;
            foreach($temp as $t){
                $finalrs[$i] = $t;
                if(isset($t['kinerja'])){
                    $finalrs[$i]['kinerja']['nilai'] = countNilaiSkp($finalrs[$i]['kinerja']['data']);
                }
                if(isset($t['komponen'])){
                    $finalrs[$i]['komponen']['nilai'] = countNilaiKomponen($finalrs[$i]['komponen']['data']);
                }
                $i++;
            }
        }

        return $finalrs;
    }

    public function loadSkbpPegawai($id, $bulan, $tahun){
        $kinerja =  $this->db->select('a.*')
                    ->from('t_rencana_kinerja a')
                    ->where('a.id_m_user', $id)
                    ->where('a.bulan', $bulan)
                    ->where('a.tahun', $tahun)
                    ->where('a.flag_active', 1)
                    ->get()->result_array();

        $komponen_kinerja = $this->db->select('*')
                    ->from('t_komponen_kinerja a')
                    ->where('a.id_m_user', $id)
                    ->where('a.bulan', $bulan)
                    ->where('a.tahun', $tahun)
                    ->where('a.flag_active', 1)
                    ->get()->row_array();

        return [$kinerja, $komponen_kinerja];
    }

    public function updateKomponenKinerja($data, $id, $bulan, $tahun, $id_komponen){
        $res['code'] = 0;
        $res['message'] = 'Komponen Kinerja berhasil diupdate';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id_komponen)
                ->update('t_komponen_kinerja', [
                    'berorientasi_pelayanan' => $data['berorientasi_pelayanan'],
                    'akuntabel' => $data['akuntabel'],
                    'kompeten' => $data['kompeten'],
                    'harmonis' => $data['harmonis'],
                    'loyal' => $data['loyal'],
                    'adaptif' => $data['adaptif'],
                    'kolaboratif' => $data['kolaboratif'],
                    'updated_by' => $id
                ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function inputKomponenKinerja($data, $id, $bulan, $tahun){
        $res['code'] = 0;
        $res['message'] = 'Komponen Kinerja berhasil ditambahkan';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->insert('t_komponen_kinerja', [
            'id_m_user' => $id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'berorientasi_pelayanan' => $data['berorientasi_pelayanan'],
            'akuntabel' => $data['akuntabel'],
            'kompeten' => $data['kompeten'],
            'harmonis' => $data['harmonis'],
            'loyal' => $data['loyal'],
            'adaptif' => $data['adaptif'],
            'kolaboratif' => $data['kolaboratif'],
            'created_by' => $id
        ]);

        $res['data'] = $this->db->insert_id();

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }
    
    public function inputRowSkbp($data){
        $res['code'] = 0;
        $res['message'] = 'Kinerja berhasil ditambahkan';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->insert('t_rencana_kinerja', [
            'id_m_user' => $data['id'],
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'sasaran_kerja' => $data['uraian_tugas'],
            'tugas_jabatan' => $data['tugas_jabatan'],
            'target_kuantitas' => $data['target_kuantitas'],
            'satuan' => $data['satuan'],
            'target_kualitas' => 100,
            'total_realisasi' => $data['target_kuantitas'],
            'created_by' => $data['id']
        ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    } 

    public function updateRowSkbp($data, $id){
        $res['code'] = 0;
        $res['message'] = 'Kinerja berhasil diupdate';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id)
            ->update('t_rencana_kinerja', [
            'sasaran_kerja' => $data['uraian_tugas'],
            'tugas_jabatan' => $data['tugas_jabatan'],
            'target_kuantitas' => $data['target_kuantitas'],
            'satuan' => $data['satuan'],
            'total_realisasi' => $data['realisasi'],
            'updated_by' => $data['id']
        ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function deleteRowSkbp($id){
        $res['code'] = 0;
        $res['message'] = 'Kinerja berhasil dihapus';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id)
            ->update('t_rencana_kinerja', [
            'flag_active' => 0,
            'updated_by' => $this->general_library->getId()
        ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function deleteKomponenKinerja($id){
        $res['code'] = 0;
        $res['message'] = 'Komponen Kinerja berhasil dihapus';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id)
            ->update('t_komponen_kinerja', [
            'flag_active' => 0,
            'updated_by' => $this->general_library->getId()
        ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function deleteSkbp($bulan, $tahun){
        $res['code'] = 0;
        $res['message'] = 'Data SKBP berhasil dihapus';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('bulan', $bulan)
                ->where('tahun', $tahun)
            ->update('t_komponen_kinerja', [
            'flag_active' => 0,
            'updated_by' => $this->general_library->getId()
        ]);

        $this->db->where('bulan', $bulan)
                ->where('tahun', $tahun)
            ->update('t_rencana_kinerja', [
            'flag_active' => 0,
            'updated_by' => $this->general_library->getId()
        ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function saveKeteranganVerif($id, $data){
        $this->db->where('id', $id)
                ->update('t_kegiatan', [
                    'keterangan_verif' => $data['keterangan_verif'],
                    'id_m_user_verif' => $this->general_library->getId(),
                    'tanggal_verif' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->general_library->getId()
                ]);
    }
}