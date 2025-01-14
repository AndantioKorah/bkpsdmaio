<?php
	class M_Kinerja extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->load->model('master/M_Master', 'master');
            $this->load->model('rekap/M_Rekap', 'rekap');
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

        public function insertKomponenKinerja($data_komponen){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;
            $this->db->trans_begin();

            $cek = $this->db->select('a.*')
                            ->from('t_komponen_kinerja a')
                            ->where('a.id_m_user', $data_komponen['id_m_user'])
                            ->where('a.tahun', $data_komponen['tahun'])
                            ->where('a.bulan', $data_komponen['bulan'])
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
                'id_m_user' => $data_komponen['id_m_user'],
                'bulan' => $data_komponen['bulan'],
                'tahun' => $data_komponen['tahun'],
                'created_by' => $data_komponen['id_m_user']
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
        // dd($this->input->post());
        $month = date('m', strtotime($this->input->post('tanggal_kegiatan')));
        $year = date('Y', strtotime($this->input->post('tanggal_kegiatan')));
        $id_peg = $this->general_library->getId();
        $data_komponen['bulan'] = $month;
        $data_komponen['tahun'] = $year;
        $data_komponen['id_m_user'] = $id_peg;
        $this->insertKomponenKinerja($data_komponen);
        
        // dd($countfiles);
        // dd($this->input->post());
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

            $tanggal = new DateTime($this->input->post('tanggal_kegiatan'));
            $tahun = $tanggal->format("Y");
            $bulan = $tanggal->format("m");
            if (!is_dir('./assets/bukti_kegiatan/'.$tahun.'/'.$bulan)) {
                mkdir('./assets/bukti_kegiatan/'.$tahun.'/'.$bulan, 0777, TRUE);
            }
            
              // Set preference
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $config['upload_path'] = './assets/bukti_kegiatan/'.$tahun.'/'.$bulan; 
            $config['allowed_types'] = '*';
         
              //Load upload library
              $this->load->library('upload',$config); 

              if ( ! $this->upload->do_upload('file'))
              {
                      $error = array('error' => $this->upload->display_errors());
                      $res = array('msg' => $error, 'success' => false);
                      return $res;
              }
            $data = $this->upload->data(); 
             
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

        public function insertPeninjauanAbsensi(){
           
            $countfiles = count($_FILES['files']['name']);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            $ress = 1;
            // dd($this->input->post());
            $month = date('m', strtotime($this->input->post('tanggal_kegiatan')));
            $year = date('Y', strtotime($this->input->post('tanggal_kegiatan')));
            $id_peg = $this->general_library->getId();
            $data_komponen['bulan'] = $month;
            $data_komponen['tahun'] = $year;
            $data_komponen['id_m_user'] = $id_peg;
            
          
            $this->db->trans_begin();
           
            if(implode($_FILES['files']['name']) == ""){
                
                $nama_file = '[""]';
                $image = $nama_file;
                $dataPost = $this->input->post();
                $this->createPeninjauanAbsensi($dataPost,$image);
            } else {
    
            for($i=0;$i<$countfiles;$i++){
             
                if(!empty($_FILES['files']['name'][$i])){
          
                  // Define new $_FILES array - $_FILES['file']
                  $_FILES['file']['name'] = $this->general_library->getUserName().'_'.$_FILES['files']['name'][$i];
                  $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                  $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                  $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                  
    
                //   if($_FILES['file']['type'] != "image/png"  AND $_FILES['file']['type'] != "image/jpeg") {
                //     $ress = 0;
                //     $res = array('msg' => 'Hanya bisa upload file gambar', 'success' => false);
                //     break;
                //   }
                   
                //   if($_FILES['file']['size'] > 1048576){
                //     $ress = 0;
                //     $res = array('msg' => 'File tidak boleh lebih dari 1 MB', 'success' => false);
                //     break;
                //   }
    
                $tanggal = new DateTime($this->input->post('tanggal_kegiatan'));
                $tahun = $tanggal->format("Y");
                $bulan = $tanggal->format("m");
                if (!is_dir('./assets/peninjauan_absen/'.$tahun.'/'.$bulan)) {
                    mkdir('./assets/peninjauan_absen/'.$tahun.'/'.$bulan, 0777, TRUE);
                }
                
                  // Set preference
                $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
                $config['upload_path'] = './assets/peninjauan_absen/'.$tahun.'/'.$bulan; 
                $config['allowed_types'] = '*';
             
                  //Load upload library
                  $this->load->library('upload',$config); 
    
                  if ( ! $this->upload->do_upload('file'))
                  {
                          $error = array('error' => $this->upload->display_errors());
                          $res = array('msg' => $error, 'success' => false);
                          return $res;
                  }
                $data = $this->upload->data(); 
                 
                }
                $nama_file[] = $data['file_name'];
               }
               if($ress == 1){
                $image = json_encode($nama_file); 
                $dataPost = $this->input->post();
                $this->createPeninjauanAbsensi($dataPost,$image);
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

            public function pengajuanKembaliPeninjauanAbsensi(){
           
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
              
                $this->db->trans_begin();

                $tanggal_absensi = $this->input->post('p_tanggal_absensi');
                $explode = explode("-", $tanggal_absensi);
                
                $tahun = $explode[0];
                $bulan = $explode[1];

                $target_dir = './assets/peninjauan_absen/'.$tahun.'/'.$bulan; 
                $filename = str_replace(' ', '', $_FILES['file']['name']); 
               
            
                    $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
                    $filename = $random_number.$filename;
                   
                    $config['upload_path']          = $target_dir;
                    $config['allowed_types']        = '*';
                    $config['encrypt_name']			= FALSE;
                    $config['overwrite']			= TRUE;
                    $config['detect_mime']			= TRUE; 
                    $config['file_name']            = "$filename"; 
        
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
        
                    $data['error']    = strip_tags($this->upload->display_errors());            
                    $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
                    return $res;
        
                } else {
                    $dataFile = $this->upload->data();
                    $nama_file[] = $filename;
                    $image = json_encode($nama_file);
                    $id = $this->input->post('id_peninjauan');
                    $data["status"] = 0;
                    $data["bukti_kegiatan"] = $image;

                    

                    $this->db->where('id', $id)
                            ->update('db_efort.t_peninjauan_absensi', $data);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                }
                
        
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    $res = array('msg' => 'Data gagal disimpan', 'success' => false);
                } else {
                    $this->db->trans_commit();
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
        $bulan = date("n",strtotime($dataPost['tanggal_kegiatan']));
        $tahun = date("Y",strtotime($dataPost['tanggal_kegiatan']));
        // $bulan = date('n');
        // $tahun = date('Y');
        // dd($year);

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
        
       
       
        if($cek){
           $this->db->where('id',  $cek[0]['id'])
                     ->update('t_rencana_kinerja', [
                    //  'updated_by' => $this->general_library->getId(),
                     'total_realisasi' => $cek[0]['realisasi_target_kuantitas']
            ]);
        }



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


        public function createPeninjauanAbsensi($dataPost,$image){
            $this->db->trans_begin();
            // $data = array('tanggal_absensi' => $dataPost['tanggal_absensi'], 
            //             //   'keterangan' => $dataPost['keterangan'],
            //               'jenis_absensi' => $dataPost['jenis_absensi'],
            //               'jenis_bukti' => $dataPost['jenis_bukti'],
            //               'bukti_kegiatan' => $image,
            //               'id_m_user' => $this->general_library->getId(),
            //               if($dataPost['jenis_bukti'] == 1){
            //                 'teman_absensi' => $dataPost['teman_absensi'],
            //               }
            // );
            $dataInsert['tanggal_absensi']      = $dataPost['tanggal_absensi'];
            $dataInsert['jenis_absensi']      = $dataPost['jenis_absensi'];
            $dataInsert['jenis_bukti']      = $dataPost['jenis_bukti'];
            $dataInsert['bukti_kegiatan']      = $image;
            $dataInsert['id_m_user']      = $this->general_library->getId();
            if($dataPost['jenis_bukti'] == 1){
            $dataInsert['teman_absensi']      = $dataPost['teman_absensi'];
              }
           
            $result = $this->db->insert('t_peninjauan_absensi', $dataInsert);
           
           
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
                // ->where('year(a.tanggal_kegiatan)', $tahun)
                // ->where('month(a.tanggal_kegiatan)', $bulan)
                ->where('b.tahun', $tahun)
                ->where('b.bulan', $bulan)
                ->where('a.flag_active', 1)
                ->where('b.flag_active', b)
                ->order_by('a.id', 'desc')
                ->get()->result_array();
           
        }

        public function loadPeninjauanAbsensi(){
            $id =  $this->general_library->getId();
            return $this->db->select('a.*,c.gelar1,c.nama,c.gelar2')
                ->from('t_peninjauan_absensi a')
                ->join('m_user b', 'a.teman_absensi = b.id', 'left')
                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws','left')
                ->where('a.id_m_user', $id)
                ->where('a.flag_active', 1)
                // ->where('b.flag_active', 1)
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
        $this->db->select('*, , (select  sum(realisasi_target_kuantitas) from t_kegiatan where t_kegiatan.id_t_rencana_kinerja = a.id and t_kegiatan.status_verif = 1 and t_kegiatan.flag_active = 1) as total_realisasi_kuantitas,
        ( SELECT sum( realisasi_target_kuantitas ) FROM t_kegiatan WHERE t_kegiatan.id_t_rencana_kinerja = a.id AND t_kegiatan.status_verif = 0 and t_kegiatan.flag_active = 1 ) AS total_belum_verif ')
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
        return $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan, b.handphone,
            a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, g.nama_bidang, a.id_m_sub_bidang, d.nama_jabatan, d.kepalaskpd, f.id_eselon, 
            h.nama_jabatan as nama_jabatan_tambahan, h.kepalaskpd as kepalaskpd_tambahan, c.id_asisten_grouping, b.id_jabatan_tambahan')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws', 'left')
            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja', 'left')
            ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
            ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat', 'left')
            ->join('db_pegawai.eselon f', 'd.eselon = f.nm_eselon', 'left')
            ->join('m_bidang g', 'a.id_m_bidang = g.id', 'left')
            ->join('db_pegawai.jabatan h', 'b.id_jabatan_tambahan = h.id_jabatanpeg', 'left')
            ->where('a.flag_active', 1)
            ->where('b.id_m_status_pegawai', 1);
            // ->where('b.flag_terima_tpp', 1);
    }

    public function recursiveAtasan($pegawai, $params){
        
    }

    public function getAtasanPegawai($pegawai, $id_m_user = null, $flag_cuti = 0){
        if($id_m_user != null){
            $pegawai = $this->db->select('b.gelar1, b.gelar2, b.nama, d.id_unitkerja, g.id_eselon, c.kepalaskpd, c.nama_jabatan, d.nm_unitkerja,
                        d.id_unitkerjamaster, f.nama_sub_bidang, e.nama_bidang, a.id_m_bidang, a.id_m_sub_bidang, c.jenis_jabatan, c.flag_uptd,
                        d.id_asisten_grouping')
                                ->from('m_user a')
                                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                                ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg', 'left')
                                ->join('db_pegawai.unitkerja d', 'b.skpd = d.id_unitkerja')
                                ->join('m_bidang e', 'a.id_m_bidang = e.id', 'left')
                                ->join('m_sub_bidang f', 'f.id = a.id_m_sub_bidang', 'left')
                                ->join('db_pegawai.eselon g', 'c.eselon = g.nm_eselon', 'left')
                                ->where('a.id', $id_m_user)
                                ->where('a.flag_active', 1)
                                ->get()->row_array();
        }

        $atasan = null;
        $kepala = null;
        $jenis_skpd = 0;

        // jenis_skpd 1 kelurahan
        // jenis_skpd 2 kecamatan
        // jenis_skpd 3 sekolah
        // jenis_skpd 4 puskes
        // dd($pegawai['id_unitkerja']);
        
        if($pegawai['kepalaskpd'] != 1){ //bukan kepala skpd
            if($pegawai['id_unitkerjamaster'] == 4000000 || // 
            $pegawai['id_unitkerjamaster'] == 3000000 || $pegawai['id_unitkerjamaster'] == 1000000 || 
            stringStartWith('Bagian', $pegawai['nm_unitkerja'])){ // dinas, badan & bagian
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] == "JFU" && $pegawai['id_m_bidang'] != null){ //cari kepala sub bidang
                    if($flag_cuti != 1){ // kalau cuti, ambil langsung eselon 3
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
                                    ->get()->row_array();
                    }
                    if(!$atasan){ //cari kepala bidang
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
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
                        if($pegawai['flag_uptd'] == 1 && $pegawai['id_eselon'] == 8){ // jika uptd dan kepala UPTD, cari kaban
                            $atasan = $kepala;
                        } else {
                            $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
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
                        }
                    } else if($pegawai['id_eselon'] == 6 || $pegawai['id_eselon'] == 7){ // ESELON III, kabid atau sek
                        $atasan = $kepala;
                    } else {
                        if($atasan == null){
                            $atasan = $kepala;
                        }
                    }
                } else if($pegawai['jenis_jabatan'] == 'JFT'){ //jika JFT
                    // $atasan = $kepala;
                    if($pegawai['nama_jabatan'] == "Pengawas TK/SD" || $pegawai['nama_jabatan'] == "Pengawas SMP" || $pegawai['nama_jabatan'] == "Pengawas SMA" ||  $pegawai['nama_jabatan'] == "Pengawas Sekolah Ahli Muda" || $pegawai['nama_jabatan'] == "Pengawas Sekolah Ahli Madya" || $pegawai['nama_jabatan'] == "Pengawas Sekolah Ahli Utama"){
                        $atasan = $this->baseQueryAtasan()
                        ->where('b.skpd', 3010000)
                        ->where('d.nama_jabatan', 'Kepala '.$pegawai['nm_unitkerja'])
                        ->get()->row_array();
                    } else {
                        $atasan = $this->baseQueryAtasan()
                        ->where('b.skpd', $pegawai['id_unitkerja'])
                        ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
                        ->get()->row_array();
                    }

                    if(!$atasan){ //cari kepala bidang
                       
                        $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
                                        ->get()->row_array();
                        
                        if(!$atasan){ //cari sek
                            if(stringStartWith('Inspektorat', $pegawai['nm_unitkerja'])){
                                $atasan = $this->baseQueryAtasan()
                                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                                // ->where('a.id_m_bidang', 202)
                                                ->where('a.id_m_bidang',$pegawai['id_m_bidang'])
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
                    
                }
            } else if(in_array($pegawai['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){
                if(stringStartWith('Kepala Sekolah', $pegawai['nama_jabatan']) || stringStartWith('Kepala Taman', $pegawai['nama_jabatan'])){ //jika kepsek
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
                } else { //jika bukan kepsek
                    
                    $atasan = $this->baseQueryAtasan()
                    ->where('b.skpd', $pegawai['id_unitkerja'])
                    ->where('d.nama_jabatan LIKE', 'Kepala%')
                    ->get()->row_array();
                    if(!$atasan){
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('h.nama_jabatan LIKE', 'Kepala%')
                                    ->get()->row_array();
                    }
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
                }
               
            } else if($pegawai['id_unitkerjamaster'] == 6000000){ //puskesmas
                $atasan = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.nama_jabatan LIKE', 'Kepala%')
                                ->get()->row_array();
                if(!$atasan){
                    $atasan = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('h.nama_jabatan LIKE', 'Kepala%')
                                ->get()->row_array();
                }
                $atasan = $this->baseQueryAtasan()
                                        ->where('b.skpd', $pegawai['id_unitkerja'])
                                        ->where('d.kepalaskpd', 1)
                                        ->get()->row_array(); //kapus
                $kepala = $atasan;
            } else if(stringStartWith('Kecamatan', $pegawai['nm_unitkerja'])){ // kecamatan
              
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($kepala == null){
                     $kepala = $this->db->select('c.*, CONCAT(a.jenis," ",d.nama_jabatan) as nama_jabatan')
                                ->from('t_plt_plh a')
                                ->join('m_user b', 'a.id_m_user = b.id')
                                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                ->join('db_pegawai.jabatan d', 'a.id_jabatan = d.id_jabatanpeg', 'left')
                                ->where('a.id_unitkerja', $pegawai['id_unitkerja'])
                                ->order_by('a.tanggal_akhir', 'desc')
                                ->limit(1)
                                ->get()->row_array();
                }
                // dd($kepala);
                if($pegawai['jenis_jabatan'] != "Struktural"){ //cari kepala sub
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
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
                } else if ($pegawai['jenis_jabatan'] == "Struktural"){
                    if($pegawai['id_eselon'] == 7 || $pegawai['id_eselon'] == 8){ // sekcam, cari camat
                        // $atasan = $this->baseQueryAtasan()
                        //             ->where('b.skpd', $pegawai['id_unitkerja'])
                        //             ->where('f.id_eselon', 6)
                        //             ->get()->row_array();
                        // if(!$atasan){ //cari kepala
                        //     $atasan = $kepala;
                        // }
                        $atasan = $kepala;
                    } else if($pegawai['id_eselon'] == 9){ // kepala seksi, cari sek
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('f.id_eselon', 7)
                                    ->get()->row_array();
                        if(!$atasan){ //cari kepala
                            $atasan = $kepala;
                        }
                    }
                }
            } else if(stringStartWith('Kelurahan', $pegawai['nm_unitkerja'])){ // kelurahan
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] != "Struktural"){ //cari kepala sub
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
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
            } else if($pegawai['id_unitkerja'] == 7005020 || $pegawai['id_unitkerja'] == 7005010){ // rumah sakit
                $kepala = $this->baseQueryAtasan()
                                ->where('b.skpd', $pegawai['id_unitkerja'])
                                ->where('d.kepalaskpd', 1)
                                ->get()->row_array();
                if($pegawai['jenis_jabatan'] != "Struktural"){ //cari kepala sub
                    $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_sub_bidang'])
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
                } else if ($pegawai['jenis_jabatan'] == "Struktural"){ // kabid
                    if($pegawai['id_eselon'] == 7){ // ESELON III B, cari direktur
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('f.id_eselon', 6)
                                    ->get()->row_array();
                        if(!$atasan){ //cari kepala
                            $atasan = $kepala;
                        }
                    } else if($pegawai['id_eselon'] == 9){ // kasub, cari kabid
                        $atasan = $this->baseQueryAtasan()
                                    ->where('b.skpd', $pegawai['id_unitkerja'])
                                    ->where('d.nama_jabatan', 'Kepala '.$pegawai['nama_bidang'])
                                    ->get()->row_array();
                        if(!$atasan){ //cari kepala
                            $atasan = $kepala;
                        }
                    }
                }
            } 
            if(stringStartWith('Bagian', $pegawai['nm_unitkerja'])){
                $atasan = $this->baseQueryAtasan()
                ->where('b.skpd', $pegawai['id_unitkerja'])
                ->where('d.nama_jabatan', 'Kepala '.$pegawai['nm_unitkerja'])
                ->get()->row_array();
            }
            // dd($pegawai['nm_unitkerja']);
            
        } else if($pegawai['kepalaskpd'] == 1){
            if(stringStartWith('Kelurahan', $pegawai['nm_unitkerja'])){ // jika lurah
                $atasan = $this->baseQueryAtasan()
                                ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                                ->where('f.id_eselon', 6)
                                ->get()->row_array(); //cari camat
                $kepala = $atasan;
            } else if(stringStartWith('Puskesmas', $pegawai['nm_unitkerja'])
            || $pegawai['id_unitkerja'] == 7005020 
            || $pegawai['id_unitkerja'] == 7005010){// jika kapus, atau direktur rumah sakit
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
            } else if(stringStartWith('Bagian', $pegawai['nm_unitkerja'])) {
                $atasan = $this->baseQueryAtasan()
                                ->where('d.id_jabatanpeg', $pegawai['id_asisten_grouping'])
                                ->get()->row_array(); // cari asisten sesuai group
                if(!$atasan){ // jika definitif tidak ada, cari PLT atau PLH
                    $atasan = $this->baseQueryAtasan()
                                ->where('b.id_jabatan_tambahan', $pegawai['id_asisten_grouping'])
                                ->get()->row_array(); // cari asisten sesuai group
                }
                $kepala = $atasan;
            } else {
                $atasan = $this->baseQueryAtasan()
                                ->where('f.id_eselon', 4)
                                ->get()->row_array(); // cari setda
                $kepala = $atasan;
            }
        }

        $kadis = null;
        $sek = null;
        if($flag_cuti == 1){
            if(stringStartWith('Puskesmas', $pegawai['nm_unitkerja'])
            || $pegawai['id_unitkerja'] == 7005020 
            || $pegawai['id_unitkerja'] == 7005010
            || $pegawai['id_unitkerja'] == 6160000
            ){ // jika puskes, rumah sakit, gudang farmasi, ambil kadis dan sek dinkes 
                $kadis = $this->baseQueryAtasan()
                            ->where('b.skpd', 3012000)
                            ->where('d.eselon', 'II B')
                            ->get()->row_array(); // kadis
                
                $sek = $this->baseQueryAtasan()
                            ->where('b.skpd', 3012000)
                            ->where('d.eselon', 'III A')
                            ->get()->row_array(); // sek
            } else if (in_array($pegawai['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){ // jika sekolah, ambil kadis dan sek diknas
                $kadis = $this->baseQueryAtasan()
                            ->where('b.skpd', 3010000)
                            ->where('d.eselon', 'II B')
                            ->get()->row_array(); // kadis
                
                $sek = $this->baseQueryAtasan()
                            ->where('b.skpd', 3010000)
                            ->where('d.eselon', 'III A')
                            ->get()->row_array(); // sek
            } else if(stringStartWith('Kelurahan', $pegawai['nm_unitkerja'])){ // jika di kelurahan
                $kadis = $this->baseQueryAtasan()
                            ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                            ->where('d.eselon', 'III A')
                            ->get()->row_array(); // camat
                
                $sek = $this->baseQueryAtasan()
                            ->where('c.id_unitkerjamaster', $pegawai['id_unitkerjamaster'])
                            ->where('d.eselon', 'III B')
                            ->get()->row_array(); // sekcam
            }
        }

        return ['atasan' => $atasan, 'kepala' => $kepala, 'sek' => $sek, 'kadis' => $kadis];
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

        $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan, d.flag_uptd,
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
                            // ->where('b.nipbaru_ws', '197405122009022003')
                            ->where('a.id',$this->general_library->getId())
                            ->get()->row_array();
        
        $data_atasan = $this->getAtasanPegawai($pegawai);
        // dd($data_atasan);
        $kepala_pd = $data_atasan['kepala'];
        $atasan_pegawai = $data_atasan['atasan'];
        
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
        $pegawai = $this->db->select('a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan, d.flag_uptd,
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
                            ->where('a.id', $data['id_user'])
                            ->get()->row_array();

        // $pegawai = $this->db->select('h.role_name,a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, 
        // a.id_m_bidang, c.id_unitkerja, c.id_unitkerjamaster, f.nama_bidang, a.id_m_sub_bidang,
        // (SELECT aa.nm_jabatan FROM db_pegawai.pegjabatan aa WHERE b.id_peg = aa.id_pegawai ORDER BY aa.tmtjabatan DESC LIMIT 1) as nama_jabatan')
        //                     ->from('m_user a')
        //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //                     ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
        //                     // ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg', 'left')
        //                     ->join('db_pegawai.pangkat e', 'b.pangkat = e.id_pangkat')
        //                     ->join('m_bidang f', 'a.id_m_bidang = f.id', 'left')
        //                     ->join('m_user_role g', 'g.id_m_user = a.id')
        //                     ->join('m_role h', 'g.id_m_role = h.id')
        //                     ->where('a.flag_active', 1)
        //                     ->where('h.id !=', 5)
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->where('a.id', $data['id_user'])
        //                     ->get()->row_array();
      
        $data_atasan = $this->getAtasanPegawai($pegawai);
        // dd($data_atasan);
        $kepala_pd = $data_atasan['kepala'];
        $atasan_pegawai = $data_atasan['atasan'];

        $rencana_kinerja = $this->db->select('a.*,
                                (SELECT SUM(b.realisasi_target_kuantitas)
                                FROM t_kegiatan b
                                WHERE b.id_t_rencana_kinerja = a.id
                                AND b.status_verif = 1
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

    public function cekSkbpBulanSekarang(){
        return $this->db->select('a.tugas_jabatan')
                        ->from('t_rencana_kinerja as a ')
                        ->where('a.id_m_user',$this->general_library->getId())
                        ->where('a.flag_active', 1)
                        ->where('a.tahun', date('Y'))
                        ->where('a.bulan', date('m'))
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
        $uksearch = null;
        if(in_array($this->general_library->getUnitKerjaPegawai(), LIST_UNIT_KERJA_KECAMATAN_NEW) 
        && isKasubKepegawaian($this->general_library->getNamaJabatan())){
            $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerja', $this->general_library->getUnitKerjaPegawai())
                                    ->get()->row_array();
        }

        $this->db->select('f.nama_jenis_disiplin_kerja,c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user,
        d.status as status_dokumen, e.nama as nama_verif, a.random_string')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->join('m_jenis_disiplin_kerja f', 'a.id_m_jenis_disiplin_kerja = f.id')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('a.flag_active', 1)
        ->where('id_m_status_pegawai', 1)
        ->order_by('a.created_date', 'desc');
        // dd($this->general_library->getNamaJabatan());
        if(isKasubKepegawaian($this->general_library->getNamaJabatan())
        || $this->general_library->isProgrammer()){
            if(in_array($this->general_library->getUnitKerjaPegawai(), LIST_UNIT_KERJA_KECAMATAN_NEW) 
            && isKasubKepegawaian($this->general_library->getNamaJabatan())){
                $this->db->join('db_pegawai.unitkerja f', 'f.id_unitkerja = c.skpd')
                        ->where('f.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
            } else if(isKasubKepegawaian($this->general_library->getNamaJabatan())) {
                $this->db->where('c.skpd', $this->general_library->getUnitKerjaPegawai()); 
            } else {
                $this->db->where('c.skpd', $id_unitkerja); 
            }
        } 
        // else if($this->general_library->isProgrammer ) {
        //     $this->db->where('a.id_m_user', $this->general_library->getId());
        // } 
        else {
            $this->db->where('a.id_m_user', $this->general_library->getId());
        }

        $result = $this->db->get()->result_array();
        $id_count = $this->general_library->getId();
        if($this->general_library->isProgrammer() || isKasubKepegawaian($this->general_library->getNamaJabatan())){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        } 

        if($result){
            $temp = $result;
            $result = null;
            foreach($temp as $t){
                if(isset($result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']])){
                    //jika tanggal kurang dari tanggal "dari_tanggal", maka tanggal di data $t yang baru akan menjadi data "dari_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) < formatDateOnly($result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['dari_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }

                    //jika tanggal lebih dari tanggal "sampai_tanggal", maka tanggal di data $t yang baru akan menjadi data "sampai_tanggal" yang baru
                    if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) > formatDateOnly($result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['sampai_tanggal'])){
                        $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    }

                    $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['list_id'][] = $t['id'];
                } else {
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']] = $t;
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['list_id'][] = $t['id'];
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                    $result[$t['nip'].$t['dokumen_pendukung'].$t['random_string']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                }

                // if($result[$t['nip'].$t['dokumen_pendukung']]['dari_tanggal'] == $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal']){
                //     $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal'] = null;
                // }

                // if(isset($result[$t['nip'].$t['id']])){
                //     //jika tanggal kurang dari tanggal "dari_tanggal", maka tanggal di data $t yang baru akan menjadi data "dari_tanggal" yang baru
                //     if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) < formatDateOnly($result[$t['nip'].$t['id']]['dari_tanggal'])){
                //         $result[$t['nip'].$t['id']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                //     }

                //     //jika tanggal lebih dari tanggal "sampai_tanggal", maka tanggal di data $t yang baru akan menjadi data "sampai_tanggal" yang baru
                //     if(formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']) > formatDateOnly($result[$t['nip'].$t['id']]['sampai_tanggal'])){
                //         $result[$t['nip'].$t['id']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                //     }

                //     $result[$t['nip'].$t['id']]['list_id'][] = $t['id'];
                // } else {
                //     $result[$t['nip'].$t['id']] = $t;
                //     $result[$t['nip'].$t['id']]['list_id'][] = $t['id'];
                //     $result[$t['nip'].$t['id']]['dari_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                //     $result[$t['nip'].$t['id']]['sampai_tanggal'] = formatDateOnly($t['tahun'].'-'.$t['bulan'].'-'.$t['tanggal']);
                // }

                // if($result[$t['nip'].$t['dokumen_pendukung']]['dari_tanggal'] == $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal']){
                //     $result[$t['nip'].$t['dokumen_pendukung']]['sampai_tanggal'] = null;
                // }
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

    public function getDataForReuploadDisiplinKerja($random_string){
        $data = $this->db->select('*')
                        ->from('t_dokumen_pendukung')
                        ->where('flag_active', 1)
                        ->where('random_string', $random_string)
                        ->order_by('id')
                        ->get()->result_array();
        if($data){
            $result = $data[0];
            $i = 0;
            if(count($data) == 1){
                $tanggal_awal = $data[0]['tanggal'] < 10 ? '0'.$data[0]['tanggal'] : $data[0]['tanggal'];
                $bulan_awal = $data[0]['bulan'] < 10 ? '0'.$data[0]['bulan'] : $data[0]['bulan'];
                $result['tanggal_awal'] = $data[0]['tahun'].'-'.$bulan_awal.'-'.$tanggal_awal;

                $tanggal_akhir = $data[0]['tanggal'] < 10 ? '0'.$data[0]['tanggal'] : $data[0]['tanggal'];
                $bulan_akhir = $data[0]['bulan'] < 10 ? '0'.$data[0]['bulan'] : $data[0]['bulan'];
                $result['tanggal_akhir'] = $data[0]['tahun'].'-'.$bulan_akhir.'-'.$tanggal_akhir;
            } else {
                foreach($data as $d){
                    if($i == 0){
                        $tanggal_awal = $d['tanggal'] < 10 ? '0'.$d['tanggal'] : $d['tanggal'];
                        $bulan_awal = $d['bulan'] < 10 ? '0'.$d['bulan'] : $d['bulan'];
                        $result['tanggal_awal'] = $d['tahun'].'-'.$bulan_awal.'-'.$tanggal_awal; 
                    } else if($i == count($data) - 1){
                        $tanggal_akhir = $d['tanggal'] < 10 ? '0'.$d['tanggal'] : $d['tanggal'];
                        $bulan_akhir = $d['bulan'] < 10 ? '0'.$d['bulan'] : $d['bulan'];
                        $result['tanggal_akhir'] = $d['tahun'].'-'.$bulan_akhir.'-'.$tanggal_akhir;
                    }
                    $i++;
                }
            }
        }
        return $result;
    }

    public function searchDisiplinKerja($data){
        $result = null;

        if(!isset($data['id_unitkerja'])){
            if($this->general_library->isProgrammer()) {
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

    public function batchRandomString($bulan, $tahun, $nip = 0){
        $id_m_user = 0;
        $this->db->select('a.*')
                ->from('t_dokumen_pendukung a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->where('a.random_string IS NULL')
                ->where_in('a.status', [3])
                ->where('a.bulan', $bulan)
                ->where('a.tahun', $tahun)
                ->where('a.flag_active', 1)
                ->where('b.flag_active', 1);
        if($nip != 0){
            $this->db->where('b.username', $nip);
        }

        $result = $this->db->get()->result_array();

        if($result){
            $before = null;
            $curr = null;
            $list_id = null;

            $meta = null;
            foreach($result as $t){
                if($id_m_user != 0){
                    if($t['id_m_user'] == $id_m_user){
                        $meta[$id_m_user.';'.$t['id_m_jenis_disiplin_kerja']]['name'] = $id_m_user.';'.$t['id_m_jenis_disiplin_kerja'];
                        $meta[$id_m_user.';'.$t['id_m_jenis_disiplin_kerja']]['random_string'] = generateRandomString(10, null, 't_dokumen_pendukung');
                    }
                } else {
                    $meta[$t['id_m_user'].';'.$t['id_m_jenis_disiplin_kerja']]['name'] = $t['id_m_user'].';'.$t['id_m_jenis_disiplin_kerja'];
                    $meta[$t['id_m_user'].';'.$t['id_m_jenis_disiplin_kerja']]['random_string'] = generateRandomString(10, null, 't_dokumen_pendukung');
                }
            }

            if($meta){
                foreach($meta as $m){
                    $explode = explode(";", $m['name']);
                    $this->db->where('id_m_user', $explode[0])
                            ->where('id_m_jenis_disiplin_kerja', $explode[1])
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->update('t_dokumen_pendukung', [
                                'random_string' => $m['random_string']
                            ]);
                }
            }
        }
    }

    public function insertDisiplinKerja($data, $filename){
        $res['code'] = 0;
        $res['message'] = '';

        $this->db->trans_begin();

        $param_lock_upload_dokpen = $this->general->getOne('m_parameter', 'parameter_name', 'PARAM_LOCK_UPLOAD_DOKPEN', 1)['parameter_value'];

        $tanggal = explodeRangeDateNew($data['range_periode']);
        $jenis_disiplin = explode(';', $data['jenis_disiplin']);
        $tanggal_akhir = $tanggal[1];

        $batasHari = countMaxDateUpload(formatDateOnlyForEdit($tanggal_akhir), $jenis_disiplin[3], "plus");

        // $batas_waktu = date('Y-m-d');
        // $date = new DateTime($batas_waktu);
        // $date->sub(new DateInterval('P3D'));
        // $expirydate = $date->format('Y-m-d');
        // if(($tanggal_akhir < $expirydate) && $param_lock_upload_dokpen == 1 &&
        
        if(($tanggal_akhir > $batasHari['max_date']) && $param_lock_upload_dokpen == 1 &&
        (!$this->general_library->isProgrammer()) && // bukan role programmer
        $jenis_disiplin[4] == 1){ // flag_lock == 1
            if($this->general_library->isAdminAplikasi() && $this->getBidangUser() == ID_BIDANG_PEKIN){ // jika admin aplikasi dan dari bidang pekin

            } else {
                $res['code'] = 1;
                $res['message'] = 'Tidak dapat melakukan upload dokumen pendukung karena melebihi batas waktu upload dokumen pendukung. Batas waktu upload adalah '.$jenis_disiplin[3].' hari';
                return $res;
            }
        }

        $list_tanggal = getDateBetweenDates($tanggal[0], $tanggal[1]);
        
        $explode_tanggal_awal = explode('-', $tanggal[0]);
        $explode_tanggal_akhir = explode('-', $tanggal[1]);

        $list_pegawai = null;
        foreach($data['pegawai'] as $dp){
            $list_pegawai[] = $dp;
        }

        $list_nama_pegawai = $this->db->select('*')
                                    ->from('m_user')
                                    ->where_in('id', $list_pegawai)
                                    ->where('flag_active', 1)
                                    ->get()->result_array();

        $data['pegawai'] = $list_nama_pegawai;

        $list_exist = null;
        $exist = $this->db->select('*')
                        ->from('t_dokumen_pendukung')
                        ->where_in('id_m_user', $list_pegawai)
                        ->where('tahun >=', $explode_tanggal_awal[0])
                        ->where('tahun <=', $explode_tanggal_akhir[0])
                        ->where('bulan >=', $explode_tanggal_awal[1])
                        ->where('bulan <=', $explode_tanggal_akhir[1])
                        ->where('status !=', 3)
                        ->where('flag_active', 1)
                        ->get()->result_array();
        if($exist){
            foreach($exist as $e){
                $tanggal = $e['tanggal'] >= 10 ? $e['tanggal'] : '0'.$e['tanggal'];
                $bulan = $e['bulan'] >= 10 ? $e['bulan'] : '0'.$e['bulan'];
                $list_exist[$e['id_m_user'].$tanggal.$bulan.$e['tahun']] = $e;
            }
        }
        // if($this->general_library->getId() == 16){
        //     dd($list_exist);
        // }
        // dd($list_exist);
        // $batchId = generateRandomString(10, 1, 't_dokumen_pendukung');
        $insert_data = null;
        $i = 0;
        $batchId = null;
        foreach($data['pegawai'] as $d){
            $disiplin = explode(';', $data['jenis_disiplin']);
            foreach($list_tanggal as $l){
                if(getNamaHari($l) != 'Sabtu' && getNamaHari($l) != 'Minggu'){
                    $date = explode('-', $l);
                    // dd($list_exist[$d['id'].$date[2].$date[1].$date[0]]);
                    
                    if(isset($list_exist[$d['id'].$date[2].$date[1].$date[0]]) // jika ada dokumen pendukung pada tanggal tersebut
                    ){  
                        $tolak = 1;
                        if($list_exist[$d['id'].$date[2].$date[1].$date[0]]['id_m_jenis_disiplin_kerja'] == 5 ||
                        $list_exist[$d['id'].$date[2].$date[1].$date[0]]['id_m_jenis_disiplin_kerja'] == 6){ // jika sidak atau kenegaraan, hanya TLP dan TLS yang diterima
                            if($disiplin[0] != 19 && $disiplin[0] != 20){
                                $tolak = 1;
                            } else {
                                $tolak = 0;
                            }
                        } else {
                            $tolak = 1;
                        }
                        
                        // if($this->general_library->getId() == 16){
                        //     dd($tolak);
                        // }

                        if($tolak == 1){
                            $this->db->trans_rollback();
                            $res['code'] = 1;
                            $res['message'] = 'Gagal mengisi Dokumen Pendukung Presensi. Pegawai atas nama '.$d['nama'].' memiliki Dokumen Pendukung Presensi pada tanggal yang sama yaitu '.$date[2].'-'.$date[1].'-'.$date[0];
                            $res['data'] = null;
                            return $res;                        
                        }
                    }
                    // else {
                    //     $this->db->trans_rollback();
                    //     $res['code'] = 1;
                    //     $res['message'] = 'Sistem sedang maintenance. Silahkan dicoba kembali pada beberapa saat lagi. Mohon maaf atas ketidaknyamanannya.';
                    //     $res['data'] = null;
                    //     return $res;
                    // }
                    // $batchId = generateRandomString(10, 1, 't_dokumen_pendukung');
                    if(!isset($batchId[$d['id']])){
                    // } else {
                        $batchId[$d['id']] = generateRandomString(10, 1, 't_dokumen_pendukung');
                    }


                    $insert_data[$i]['id_m_user'] = $d['id'];
                    $insert_data[$i]['tahun'] = $date[0];
                    $insert_data[$i]['bulan'] = $date[1];
                    $insert_data[$i]['tanggal'] = $date[2];
                    $insert_data[$i]['id_m_jenis_disiplin_kerja'] = $disiplin[0];
                    if($disiplin[0] == 14){
                        if(isset($data['jenis_tugas_luar'])){
                            if($data['jenis_tugas_luar'] == 'Tugas Luar Pagi'){
                                $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 19;
                            } else if($data['jenis_tugas_luar'] == 'Tugas Luar Sore'){
                                $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 20;
                            }
                            $insert_data[$i]['keterangan'] = $data['jenis_tugas_luar'];
                        }
                    } else {
                        $insert_data[$i]['keterangan'] = $disiplin[1];
                    }
                   
                    $insert_data[$i]['pengurangan'] = $disiplin[2];
                    $insert_data[$i]['dokumen_pendukung'] = $filename;
                    $insert_data[$i]['created_by'] = $this->general_library->getId();
                    if($this->general_library->isProgrammer() 
                    || $this->general_library->isAdminAplikasi() || $this->general_library->getUnitKerjaPegawai() == ID_BIDANG_PEKIN) {
                        $insert_data[$i]['status'] = 2;
                    }
                    $insert_data[$i]['random_string'] = $batchId[$d['id']];
                    $i++;
                }
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

        return $res;
    }

    public function reuploadDisiplinKerja($data, $filename, $random_string){
        $res['code'] = 0;
        $res['message'] = '';

        $this->db->trans_begin();

        $temp_filename = json_decode($filename, true);
        if($temp_filename && $temp_filename[0] != ""){
            $temp_filename = $filename;
        } else {
            $temp_filename = null;
        }
        // dd($data);
        $tanggal = explodeRangeDateNew($data['range_periode']);
        $jenis_disiplin = explode(';', $data['jenis_disiplin']);

        $list_tanggal = getDateBetweenDates($tanggal[0], $tanggal[1]);
        
        $explode_tanggal_awal = explode('-', $tanggal[0]);
        $explode_tanggal_akhir = explode('-', $tanggal[1]);

        $list_pegawai = null;
        
        $temp_data = $this->db->select('*')
                            ->from('t_dokumen_pendukung')
                            ->where('flag_active', 1)
                            ->where('random_string', $random_string)
                            ->get()->row_array();

        // foreach($data['pegawai'] as $dp){
        //     $list_pegawai[] = $dp;
        // }
        $list_pegawai[] = $temp_data['id_m_user'];
        $list_nama_pegawai = $this->db->select('*')
                                    ->from('m_user')
                                    ->where_in('id', $list_pegawai)
                                    ->where('flag_active', 1)
                                    ->get()->result_array();

        $data['pegawai'] = $list_nama_pegawai;

        $list_exist = null;
        $exist = $this->db->select('*')
                        ->from('t_dokumen_pendukung')
                        ->where_in('id_m_user', $list_pegawai)
                        ->where('tahun >=', $explode_tanggal_awal[0])
                        ->where('tahun <=', $explode_tanggal_akhir[0])
                        ->where('bulan >=', $explode_tanggal_awal[1])
                        ->where('bulan <=', $explode_tanggal_akhir[1])
                        ->where('status !=', 3)
                        ->where('flag_active', 1)
                        ->get()->result_array();
        if($exist){
            foreach($exist as $e){
                $tanggal = $e['tanggal'] > 10 ? $e['tanggal'] : '0'.$e['tanggal'];
                $bulan = $e['bulan'] > 10 ? $e['bulan'] : '0'.$e['bulan'];
                $list_exist[$e['id_m_user'].$tanggal.$bulan.$e['tahun']] = $e;
            }
        }
        // dd($list_exist);
        $batchId = generateRandomString(10, 1, 't_dokumen_pendukung');
        $insert_data = null;
        $i = 0;
        foreach($data['pegawai'] as $d){
            $disiplin = explode(';', $data['jenis_disiplin']);
            foreach($list_tanggal as $l){
                // if(getNamaHari($l) != 'Sabtu' && getNamaHari($l) != 'Minggu'){
                    $date = explode('-', $l);
                    // dd($list_exist[$d['id'].$date[2].$date[1].$date[0]]);
                    if(isset($list_exist[$d['id'].$date[2].$date[1].$date[0]])){ // jika ada dokumen pendukung pada tanggal tersebut
                        $this->db->trans_rollback();
                        $res['code'] = 1;
                        $res['message'] = 'Gagal mengisi dokumen pendukung. Pegawai atas nama '.$d['nama'].' memiliki dokumen pendukung pada tanggal yang sama yaitu '.$date[2].'-'.$date[1].'-'.$date[0];
                        $res['data'] = null;
                        return $res;                        
                    }
                    $insert_data[$i]['id_m_user'] = $d['id'];
                    $insert_data[$i]['tahun'] = $date[0];
                    $insert_data[$i]['bulan'] = $date[1];
                    $insert_data[$i]['tanggal'] = $date[2];
                    $insert_data[$i]['id_m_jenis_disiplin_kerja'] = $disiplin[0];
                    if($disiplin[0] == 14){
                        if(isset($data['jenis_tugas_luar'])){
                            if($data['jenis_tugas_luar'] == 'Tugas Luar Pagi'){
                                $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 19;
                            } else if($data['jenis_tugas_luar'] == 'Tugas Luar Sore'){
                                $insert_data[$i]['id_m_jenis_disiplin_kerja'] = 20;
                            }
                            $insert_data[$i]['keterangan'] = $data['jenis_tugas_luar'];
                        }
                    } else {
                        $insert_data[$i]['keterangan'] = $disiplin[1];
                    }
                   
                    $insert_data[$i]['pengurangan'] = $disiplin[2];
                    $insert_data[$i]['dokumen_pendukung'] = $temp_filename ? $temp_filename : $temp_data['dokumen_pendukung'];
                    $insert_data[$i]['created_by'] = $this->general_library->getId();
                    if($this->general_library->isProgrammer() 
                    || $this->general_library->isAdminAplikasi() || $this->general_library->getUnitKerjaPegawai() == ID_BIDANG_PEKIN) {
                        $insert_data[$i]['status'] = 2;
                    }
                    $insert_data[$i]['random_string'] = $batchId;
                    $insert_data[$i]['random_string_reupload'] = $random_string;
                    $i++;
                // }
            }
        }
        $this->db->insert_batch('t_dokumen_pendukung', $insert_data);

        $this->db->where('random_string', $random_string)
                ->update('t_dokumen_pendukung', 
                [
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

        if($this->general_library->isProgrammer() ||
        ($this->general_library->getBidangUser() == ID_BIDANG_PEKIN && $flag_verif == 1) ||
        isKasubKepegawaian($this->general_library->getNamaJabatan())){
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

        // $this->db->where_in('id', $this->input->post('list_id'))
        //         ->update('t_dokumen_pendukung', ['flag_active' => 0]);
        
        $tmp = $this->db->select('*')
                        ->from('t_dokumen_pendukung')
                        ->where('id', $id)
                        ->get()->row_array();

        if($tmp['random_string']){
            if($this->input->post('list_id')){
                $this->db->where_in('id', $this->input->post('list_id'))
                        ->update('t_dokumen_pendukung', ['flag_active' => 0]);    
            } else {
                $this->db->where('random_string', $tmp['random_string'])
                        ->update('t_dokumen_pendukung', ['flag_active' => 0]);
            }
        } else {
            $this->db->where_in('id', $this->input->post('list_id'))
                        ->update('t_dokumen_pendukung', ['flag_active' => 0]);
        }

        $id_count = $tmp['id_m_user'];
        if($this->general_library->isProgrammer()){
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
            // ->where('c.skpd', $data['id_unitkerja'])
            ->where('a.flag_active', 1)
            ->where('id_m_status_pegawai', 1)
            ->order_by('a.created_date', 'desc');
            if($data['id_unitkerja'] != "0"){
                $this->db->where('c.skpd', $data['id_unitkerja']);
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
    }

    public function searchVerifTinjauAbsensi($data){
        // dd($data);
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user')
            ->from('t_peninjauan_absensi a')
            ->join('m_user b', 'a.id_m_user = b.id')
            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
            ->where('a.flag_active', 1)
            ->where('c.id_m_status_pegawai', 1)
            ->order_by('a.tanggal_absensi', 'desc');
            if($data['id_unitkerja'] != "0"){
                $this->db->where('c.skpd', $data['id_unitkerja']);
            }

            // if($data['bulan'] != "0"){
            //     $this->db->where('month(a.tanggal_absensi)', 6);
            // }

            // if($data['tahun'] != "0"){
            //     $this->db->where('year(a.tanggal_absensi)', $data['tahun']);
            // }


        $result = $this->db->get()->result_array();
        return $result;
    }

    public function loadSearchVerifDokumen($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('g.nama_jenis_disiplin_kerja,a.id_m_jenis_disiplin_kerja, c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user,
        d.status as status_dokumen, e.nama as nama_verif, f.nm_unitkerja, c.nipbaru')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->join('db_pegawai.unitkerja f', 'c.skpd = f.id_unitkerja')
        ->join('m_jenis_disiplin_kerja g', 'a.id_m_jenis_disiplin_kerja = g.id')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('id_m_status_pegawai', 1)
        ->where('a.flag_active', 1);

        if($id_unitkerja != 0){
            $this->db->where('c.skpd', $id_unitkerja);
        }

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

    public function loadSearchVerifPeninjauanAbsensi($status, $bulan, $tahun, $id_unitkerja = 0){
        $this->db->select('c.fotopeg,g.nama as teman_nama, g.nipbaru_ws as teman_nip, g.gelar1 as teman_gelar1, g.gelar2 as teman_gelar2, c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, e.nama as nama_verif, f.nm_unitkerja, c.nipbaru,
        (select count(*) from t_peninjauan_absensi as h where h.id_m_user = a.id_m_user and h.flag_active = 1 and h.status = 1 and month(h.tanggal_absensi) = '.$bulan.' and year(h.tanggal_absensi) = '.$tahun.'  limit 1) as total_diverif')
        ->from('t_peninjauan_absensi a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_user e', 'a.teman_absensi = e.id', 'left')
        ->join('db_pegawai.unitkerja f', 'c.skpd = f.id_unitkerja')
        ->join('db_pegawai.pegawai g', 'e.username = g.nipbaru_ws','left')
        ->where('a.status', floatval($status))
        ->where('c.id_m_status_pegawai', 1)
        ->where('a.flag_active', 1)
        ->order_by('a.tanggal_absensi', 'asc');
        if($id_unitkerja != 0){
            $this->db->where('c.skpd', $id_unitkerja);
        }

        
        if($bulan != 0){
            $this->db->where('month(a.tanggal_absensi)', $bulan);
        }

        if($tahun != 0){
            $this->db->where('year(a.tanggal_absensi)', $tahun);
        }


        if($status == 1){
            $this->db->order_by('created_date', 'desc');
        } else {
            $this->db->order_by('a.updated_date', 'desc');
        }

        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function verifDokumen($id, $status){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';        
        $this->db->trans_begin();

        $temp = $this->input->post();
        
        $data_verif['status'] = $status;
        $data_verif['id_m_user_verif'] = $this->general_library->getId();
        $data_verif['updated_by'] = $this->general_library->getId();
        $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
        $data_verif['flag_fix_tanggal'] = isset($temp['flag_fix_tanggal']) ? $temp['flag_fix_tanggal'] == "true" ? 1 : 0 : 0;
        $data_verif['flag_fix_jenis_disiplin'] = isset($temp['flag_fix_jenis_disiplin']) ? $temp['flag_fix_jenis_disiplin'] == "true" ? 1 : 0 : 0;
        $data_verif['flag_fix_dokumen_upload'] = isset($temp['flag_fix_dokumen_upload']) ? $temp['flag_fix_dokumen_upload'] == "true" ? 1 : 0 : 0;
        if($status == 2 || $status == 3){
            $data_verif['keterangan_verif'] = $this->input->post('keterangan');
        }

        $temp = $this->db->select('c.skpd, a.bulan, a.tahun, a.random_string, c.handphone')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.id', $id)
                        ->where('id_m_status_pegawai', 1)
                        ->get()->row_array();

        $id_unitkerja = $temp['skpd'];
        $uksearch = $this->db->select('*')
                        ->from('db_pegawai.unitkerja')
                        ->where('id_unitkerja', $temp['skpd'])
                        ->get()->row_array();
                        
        if(in_array($uksearch['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)){ // jika kelurahan atau kecamatan
            $uker = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerjamaster', $temp['id_unitkerjamaster'])
                            ->where('nm_unitkerja LIKE ', '"Kecamatan%"')
                            ->get()->row_array();
            $id_unitkerja = $uker['id_unitkerja'];
        } else if($uksearch['id_unitkerjamaster_kecamatan']){ // jika sekolah kecamatan
            $id_unitkerja = 'sekolah_'.$uksearch['id_unitkerjamaster_kecamatan'];
        }

        $lockTpp = $this->db->select('*')
                            ->from('t_lock_tpp')
                            ->where('flag_active', 1)
                            ->where('id_unitkerja', $id_unitkerja)
                            ->where('bulan', $temp['bulan'])
                            ->where('tahun', $temp['tahun'])
                            ->get()->row_array();

        if($lockTpp){
            $rs['code'] = 1;        
            $rs['message'] = 'Berkas TPP '.$lockTpp['nama_param_unitkerja'].' periode '.getNamaBulan($lockTpp['bulan']).' '.$lockTpp['tahun'].' telah direkap. Verifikasi tidak dapat dilanjutkan.';
        } else {
            if($temp['random_string']){
                $this->db->where('random_string', $temp['random_string'])
                    ->update('t_dokumen_pendukung', $data_verif);

                $list_dokumen = $this->db->select('c.skpd, a.tanggal, a.bulan, a.tahun, a.random_string, c.handphone, d.nama_jenis_disiplin_kerja, c.gelar1, c.nama, c.gelar2')
                                    ->from('t_dokumen_pendukung a')
                                    ->join('m_user b', 'a.id_m_user = b.id')
                                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                    ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                                    ->where('a.random_string', $temp['random_string'])
                                    ->order_by('a.id', 'asc')
                                    ->get()->result_array();

                if($list_dokumen && $list_dokumen[0]['handphone'] != null){
                    $bulan_awal = $list_dokumen[0]['bulan'] < 10 ? '0'.$list_dokumen[0]['bulan'] : $list_dokumen[0]['bulan'];
                    $tanggal_awal = $list_dokumen[0]['tanggal'] < 10 ? '0'.$list_dokumen[0]['tanggal'] : $list_dokumen[0]['tanggal'];
                    $tanggal_awal = $list_dokumen[0]['tahun'].'-'.$bulan_awal.'-'.$tanggal_awal;

                    $bulan_akhir = $list_dokumen[count($list_dokumen)-1]['bulan'] < 10 ? '0'.$list_dokumen[count($list_dokumen)-1]['bulan'] : $list_dokumen[count($list_dokumen)-1]['bulan'];
                    $tanggal_akhir = $list_dokumen[count($list_dokumen)-1]['tanggal'] < 10 ? '0'.$list_dokumen[count($list_dokumen)-1]['tanggal'] : $list_dokumen[count($list_dokumen)-1]['tanggal'];
                    $tanggal_akhir = $list_dokumen[count($list_dokumen)-1]['tahun'].'-'.$bulan_akhir.'-'.$tanggal_akhir;

                    $tanggal = formatDateNamaBulan($tanggal_awal);
                    if($tanggal_awal != $tanggal_akhir){
                        $tanggal .= " sampai ".formatDateNamaBulan($tanggal_akhir);
                    }

                    $hasil_verif = "DISETUJUI";
                    $kata_verifikasi = "";

                    if($status == 3){
                        $hasil_verif = "DITOLAK (".$this->input->post('keterangan').")";
                    } else if($status == 4){
                        $hasil_verif = "DIBATALKAN";
                        $kata_verifikasi = " verifikasi ";
                    }

                    $message = "*[DOKUMEN PENDUKUNG ABSENSI]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($list_dokumen[0]).$kata_verifikasi." dokumen *".$list_dokumen[0]['nama_jenis_disiplin_kerja']."* Anda pada tanggal ".$tanggal." telah *".$hasil_verif."*";

                    if($status == 3 || $status == 4){
                        $this->db->insert('t_cron_wa', [
                            'type' => 'text',
                            'sendTo' => convertPhoneNumber($list_dokumen[0]['handphone']),
                            'message' => $message.FOOTER_MESSAGE_CUTI,
                            'jenis_layanan' => 'Dokumen Pendukung Absensi',
                            'created_by' => $this->general_library->getId()
                        ]);
                    }
                }

            } else {
                $this->db->where_in('id', $this->input->post('list_id'))
                    ->update('t_dokumen_pendukung', $data_verif);
            }
            


            $rs['data'] = $this->countTotalDataPendukung($temp['skpd'], $temp['bulan'], $temp['tahun'], 1);
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;        
            $rs['message'] = 'Terjadi Kesalahan';
        }else{
            $this->db->trans_commit();
        }
        
        return $rs;
    }

    public function verifPeninjauanAbsensi($id, $status){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';        
        $this->db->trans_begin();

        $bulan = date("m",strtotime($this->input->post('tanggal_absensi')));
        $tahun = date("Y",strtotime($this->input->post('tanggal_absensi')));
        $this->db->select('
        (select count(*) from t_peninjauan_absensi as h where h.id_m_user = a.id_m_user and h.flag_active = 1  and month(h.tanggal_absensi) = '.$bulan.' and year(h.tanggal_absensi) = '.$tahun.'  limit 1) as total_pengajuan,
        (select count(*) from t_peninjauan_absensi as h where h.id_m_user = a.id_m_user and h.flag_active = 1 and h.status = 1  and month(h.tanggal_absensi) = '.$bulan.' and year(h.tanggal_absensi) = '.$tahun.'  limit 1) as total_verif')
        ->from('t_peninjauan_absensi a')
        ->where('a.flag_active', 1)
        ->where('a.id_m_user',$this->input->post('id_user'))
        ->group_by('a.id_m_user')
        ->order_by('a.tanggal_absensi', 'asc');
        $result = $this->db->get()->result_array();
        
        if($status == 3){
            $data_verif['status'] = $status;
            $data_verif['id_m_user_verif'] = $this->general_library->getId();
            $data_verif['updated_by'] = $this->general_library->getId();
            $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
            
            $this->db->where_in('id', $id)
            ->update('t_peninjauan_absensi', $data_verif);
        } else {

        
        if($result[0]['total_verif'] >= 5) {
            $rs['code'] = 1;        
            $rs['message'] = 'Sudah ada 5 Pengajuan yang diterima';        
        } else {     

            $data_verif['status'] = $status;
            $data_verif['id_m_user_verif'] = $this->general_library->getId();
            $data_verif['updated_by'] = $this->general_library->getId();
            $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
            if($status == 1 || $status == 2){
                $data_verif['keterangan_verif'] = $this->input->post('keterangan');
            }

            
            if($this->input->post('jenis_bukti') == 1){
               $absen = $this->db->select('*')
                            ->from('db_sip.absen a')
                            ->where('a.user_id', $this->input->post('teman_absensi'))
                            ->where('a.tgl', $this->input->post('tanggal_absensi'))
                            ->get()->row_array();
                             
                if($absen){
    
                    $absenUser = $this->db->select('*')
                    ->from('db_sip.absen a')
                    ->where('a.user_id', $this->input->post('id_user'))
                    ->where('a.tgl', $this->input->post('tanggal_absensi'))
                    ->get()->row_array();
                   
                    if($absenUser) {
                        if($this->input->post('jenis_absensi') == 1){
                            $dataUpdate['masuk'] = $absen['masuk'];
                            $this->db->where('user_id', $this->input->post('id_user'))
                            ->where('tgl', $this->input->post('tanggal_absensi'))
                            ->update('db_sip.absen', $dataUpdate);
                        } else {
                            $dataUpdate['pulang'] = $absen['pulang'];
                            $this->db->where('user_id', $this->input->post('id_user'))
                            ->where('tgl', $this->input->post('tanggal_absensi'))
                            ->update('db_sip.absen', $dataUpdate);
                        }
                    } else {
                    // $this->db->insert('db_sip.absen', [
                    //                     'user_id' => $this->input->post('id_user'),
                    //                     'masuk' => $absen['masuk'],
                    //                     'pulang' => $absen['pulang'],
                    //                     'lat' => $absen['lat'],
                    //                     'lang' => $absen['lang'],
                    //                     'tgl' => $absen['tgl'],
                    //                     'status' => $absen['status'],
                    //                     'aktivitas' => $absen['aktivitas']
                    //                 ]);

                    if($this->input->post('jenis_absensi') == 1){
                       $this->db->insert('db_sip.absen', [
                                        'user_id' => $this->input->post('id_user'),
                                        'masuk' => $absen['masuk'],
                                        // 'pulang' => $absen['pulang'],
                                        'lat' => $absen['lat'],
                                        'lang' => $absen['lang'],
                                        'tgl' => $absen['tgl'],
                                        'status' => $absen['status'],
                                        'aktivitas' => $absen['aktivitas']
                                    ]);
                    } else {
                       $this->db->insert('db_sip.absen', [
                                        'user_id' => $this->input->post('id_user'),
                                        // 'masuk' => $absen['masuk'],
                                        'pulang' => $absen['pulang'],
                                        'lat' => $absen['lat'],
                                        'lang' => $absen['lang'],
                                        'tgl' => $absen['tgl'],
                                        'status' => $absen['status'],
                                        'aktivitas' => $absen['aktivitas']
                                    ]);
                    }

                    }
                    $this->db->where_in('id', $id)
                    ->update('t_peninjauan_absensi', $data_verif);
                } 
            } else {
               

                    $absenUser = $this->db->select('*')
                    ->from('db_sip.absen a')
                    ->where('a.user_id', $this->input->post('id_user'))
                    ->where('a.tgl', $this->input->post('tanggal_absensi'))
                    ->get()->row_array();

                    // dd($absenUser);
                
                    if($absenUser) {
                    if($status == 1){
                    if($this->input->post('jenis_absensi') == 1){
                                $dataUpdate['masuk'] = $this->input->post('jam_absen');
                                $this->db->where('user_id', $this->input->post('id_user'))
                                ->where('tgl', $this->input->post('tanggal_absensi'))
                                ->update('db_sip.absen', $dataUpdate);
                            } else {
                                $dataUpdate['pulang'] = $this->input->post('jam_absen');
                                $this->db->where('user_id', $this->input->post('id_user'))
                                ->where('tgl', $this->input->post('tanggal_absensi'))
                                ->update('db_sip.absen', $dataUpdate);
                            }
                        }
                    } else {
                        if($this->input->post('jenis_absensi') == 1){
                            $this->db->insert('db_sip.absen', [
                                'user_id' => $this->input->post('id_user'),
                                'masuk' => $this->input->post('jam_absen'),
                                'tgl' => $this->input->post('tanggal_absensi')
                            ]);
                        } else {
                            $this->db->insert('db_sip.absen', [
                                'user_id' => $this->input->post('id_user'),
                                'pulang' => $this->input->post('jam_absen'),
                                'tgl' => $this->input->post('tanggal_absensi')
                            ]);
                        }

                    
                    }


                    $this->db->where_in('id', $id)
                    ->update('t_peninjauan_absensi', $data_verif);
        }

        }
    }

       

    
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;        
            $rs['message'] = 'Terjadi Kesalahan';
        }else{
            $this->db->trans_commit();
        }
        
        return $rs;
    }

    public function verifPeninjauanAbsensiKolektif(){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';        
        $this->db->trans_begin();

       
        $data_verif['status'] = 1;
        $data_verif['id_m_user_verif'] = $this->general_library->getId();
        $data_verif['updated_by'] = $this->general_library->getId();
        $data_verif['tanggal_verif'] = date('Y-m-d H:i:s');
       
        $peninjauan = $this->db->select('*')
                        ->from('db_efort.t_peninjauan_absensi a')
                        ->where('a.tanggal_absensi', $this->input->post('tanggal_kolektif'))
                        ->where('a.jenis_absensi', $this->input->post('jenis_absensi'))
                        ->where('a.status', 0)
                        ->get()->result_array();
        foreach ($peninjauan as $rs) {
            $absen = $this->db->select('*')   
            ->from('db_sip.absen a')
            ->where('a.user_id', $rs['id_m_user'])
            ->where('a.tgl', $this->input->post('tanggal_kolektif'))
            ->get()->row_array();
            if($absen){
                if($rs['jenis_absensi'] == 1){
                    $dataUpdate['masuk'] = "07:00:00";
                    $this->db->where('user_id', $rs['id_m_user'])
                    ->where('tgl', $this->input->post('tanggal_kolektif'))
                    ->update('db_sip.absen', $dataUpdate);
                } else {
                    $dataUpdate['pulang'] = "17:00:01";
                    $this->db->where('user_id', $rs['id_m_user'])
                    ->where('tgl', $this->input->post('tanggal_kolektif'))
                    ->update('db_sip.absen', $dataUpdate);
                }
                $this->db->where('id', $rs['id'])
                ->update('t_peninjauan_absensi', $data_verif);
            } 
            else {
                if($this->input->post('jenis_absensi') == 1){
                    $this->db->insert('db_sip.absen', [
                        'user_id' => $rs['id_m_user'],
                        'masuk' => "07:00:00",
                        // 'pulang' => $absen['pulang'],
                        // 'lat' => $absen['lat'],
                        // 'lang' => $absen['lang'],
                        'tgl' => $this->input->post('tanggal_kolektif'),
                        'status' => "1",
                        'aktivitas' => 0,
                        'created_at' => $this->input->post('tanggal_kolektif'),
                        'updated_at' => $this->input->post('tanggal_kolektif')
                    ]);
                } else {
                    $this->db->insert('db_sip.absen', [
                        'user_id' => $rs['id_m_user'],
                        // 'masuk' => "07:00:00",
                        'pulang' => "17:00:00",
                        // 'lat' => $absen['lat'],
                        // 'lang' => $absen['lang'],
                        'tgl' => $this->input->post('tanggal_kolektif'),
                        'status' => "1",
                        'aktivitas' => 0,
                        'created_at' => $this->input->post('tanggal_kolektif'),
                        'updated_at' => $this->input->post('tanggal_kolektif')
                    ]);
                }
            }
        }
       

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
        dd($list_tpp_kelas_jabatan);
        $j = 1;
        foreach($list_tpp_kelas_jabatan as $lt){
            $result[$j]['jft'] = $lt;
            $result[$j]['jfu'] = $lt;
            $result[$j]['eselon_4'] = $lt;
            $result[$j]['kepala_skpd'] = $lt;
            $result[$j]['semua'] = $lt;
            $j++;
        }

        dd($result);
    }

    public function getPaguTppUnitKerjaBu($id_unitkerja, $unitkerja){
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

    public function getBebanKerjaJfuSkpd($id_unitkerja){
        $beban_kerja = 0;
        if($id_unitkerja == '4011000'){ // jika INSPEKTORAT
            $beban_kerja = "28.87";
        } else if($id_unitkerja == '4026000'){ // jika BKAD
            $beban_kerja = "23.94";
        } else if($id_unitkerja == '4018000' || $id_unitkerja == '3030000' || $id_unitkerja == '4012000' ){ // jika BKPSDM atau PTSP atau bapelitbang
            $beban_kerja = "19.014023292059";
        } else if($id_unitkerja == '3015000'){ //jika DISDUKCAPIL
            $beban_kerja = "23.94";
        } else if($id_unitkerja == '1010400' || $id_unitkerja == '1030750' || $id_unitkerja == '1020500'){ // jika BAGIAN HUKUM / BPK / BARJAS
            $beban_kerja = "23.94";
        } else if($id_unitkerja == '7005010' || $id_unitkerja == '7005020'){ // jika RSUD atau RSKDGM
            $beban_kerja = "19.014023292059";
        }
        return $beban_kerja;
    }

    public function checkLockTpp(){
        $result['code'] = 0;
        $result['message'] = '';
        $result['data'] = '';

        $param = $this->input->post();
        $id_unitkerja = $this->general_library->getUnitKerjaPegawai();
        $bulan = date('m');
        $tahun = date('Y');
        if(isset($param['periode'])){
            $periode = explodeRangeDate($param['periode']);
            $periode_awal = explode("-", $periode[0]);
            $bulan = $periode_awal[2];
            $tahun = $periode_awal[0];
        } else if(isset($param['tanggal'])){
            $explode = explode('-', $param['tanggal']);
            $bulan = $explode[1];
            $tahun = $explode[0];
        } else if(isset($param['bulan']) && isset($param['tahun'])){
            $bulan = $param['bulan'];
            $tahun = $param['tahun'];
        }
        
        $uk = $this->db->select('*')
                    ->from('db_pegawai.unitkerja')
                    ->where('id_unitkerja', $this->general_library->getUnitKerjaPegawai())
                    ->get()->row_array();
        if($uk){
            if(in_array($uk['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_KECAMATAN)){ // kelurahan, ambil kecamatan pe id_unitkerja
                $uk_kec = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerjamaster', $uk['id_unitkerjamaster'])
                            ->like('nm_unitkerja', 'Kecamatan%')
                            ->get()->row_array();
                if($uk_kec){
                    $uk = $uk_kec;
                    $id_unitkerja = $uk_kec['id_unitkerja'];
                }
            }
        }

        $exist = $this->db->select('*')
                        ->from('t_lock_tpp')
                        ->where('id_unitkerja', $id_unitkerja)
                        ->where('bulan', floatval($bulan)) 
                        ->where('tahun', floatval($tahun))
                        ->where('flag_active', 1)
                        ->get()->row_array(); 
        if($exist){
            $result['code'] = 1;
            $result['message'] = 'Berkas TPP '.$uk['nm_unitkerja'].' untuk periode '.getNamaBulan($bulan).' tahun '.$tahun.' sudah dilakukan rekapitulasi. Proses ini tidak dapat dilanjutkan.';
            $result['data'] = $uk;
        }

        return $result;
    }

    public function countPaguTpp($data, $id_pegawai = null, $flag_profil = 0, $flag_rekap_tpp = 0, $flag_sekolah_kecamatan = 0){
        $result = null;
        $bulan = isset($data['bulan']) ? $data['bulan'] : null;
        $tahun = isset($data['tahun']) ? $data['tahun'] : null;
        // $data['bulan'] = '3';
        // $data['tahun'] = '2024';
        // if(isset($data['bulan']) && isset($data['tahun'])){
        //     $pegawai = $this->master->getNomitaifPegawaiBySkpd($data);
        // } else {
            $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $data['id_unitkerja'])
                            ->get()->row_array();

            $id_unitkerja = $data['id_unitkerja'];
            if(stringStartWith("sekolah_", $data['id_unitkerja'])){
                $expl = explode("_", $data['id_unitkerja']);
                $id_unitkerja = $expl[1];
                $flag_sekolah_kecamatan = 1;
            }
            
            if($flag_sekolah_kecamatan == 1){
                $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerjamaster_kecamatan', $id_unitkerja)
                            ->get()->row_array();
            }
            $pagu_tpp = $this->session->userdata('list_tpp_kelas_jabatan');

            $nama_unit_kerja = explode(" ", $unitkerja['nm_unitkerja']);
                                
            $this->db->select('a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, f.id as id_m_user, b.kelas_jabatan_jfu, b.kelas_jabatan_jft, b.id_pangkat,
                        c.nama_jabatan,
                        c.kepalaskpd, c.prestasi_kerja, c.beban_kerja, c.kondisi_kerja, c.kelas_jabatan, c.jenis_jabatan, c.id_jabatanpeg, a.skpd,
                        a.flag_terima_tpp, a.kelas_jabatan_hardcode, e.id_unitkerjamaster, g.prestasi_kerja AS prestasi_kerja_tambahan, a.id_jabatan_tambahan,
                        g.beban_kerja AS beban_kerja_tambahan, g.kelas_jabatan as kelas_jabatan_tambahan, a.flag_bendahara,
                        g.kondisi_kerja AS kondisi_kerja_tambahan, a.statuspeg, e.id_unitkerja,
                        g.nama_jabatan AS nama_jabatan_tambahan, a.besaran_gaji')
                        ->from('db_pegawai.pegawai a')
                        ->join('m_pangkat b', 'a.pangkat = b.id_pangkat')
                        ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                        // ->join('db_pegawai.eselon d', 'c.eselon = d.nm_eselon')
                        ->join('db_pegawai.unitkerja e', 'a.skpd = e.id_unitkerja')
                        ->join('m_user f', 'a.nipbaru_ws = f.username')
                        ->join('db_pegawai.jabatan g', 'a.id_jabatan_tambahan = g.id_jabatanpeg', 'left')
                        // ->where('a.skpd', $data['id_unitkerja'])
                        ->order_by('c.eselon')
                        ->where('f.flag_active', 1)
                        ->where('id_m_status_pegawai', 1);
                        // ->get()->result_array();
            if($flag_profil == 1){
                $this->db->where('id_m_status_pegawai', 1);
            }
            if(isset($data['from_list_tpp']) && $data['from_list_tpp'] == 1){
                if($this->general_library->getUnitKerjaPegawai() == 3010000){
                    if($data['id_unitkerja'] == 0){
                        $this->db->where_in('e.id_unitkerjamaster', LIST_UNIT_KERJA_MASTER_SEKOLAH);
                    }
                }
            } else if($flag_rekap_tpp == 1 && in_array($data['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN_NEW) && $flag_sekolah_kecamatan == 0){
                $this->db->join('db_pegawai.unitkerja h', 'a.skpd = h.id_unitkerja')
                            ->where('h.id_unitkerjamaster', $unitkerja['id_unitkerjamaster']);
            } else if($flag_sekolah_kecamatan == 1){
                $this->db->join('db_pegawai.unitkerja h', 'a.skpd = h.id_unitkerja')
                            ->where('h.id_unitkerjamaster_kecamatan', $unitkerja['id_unitkerjamaster_kecamatan']);
            } else {
                $this->db->where('a.skpd', $data['id_unitkerja']);
            }
            if($id_pegawai != null){
                $this->db->where('f.id', $id_pegawai);
            }
            $pegawai = $this->db->get()->result_array();
            // if($data['id_unitkerja'] == 3021000){
                // dd($pegawai);
            // }
        // }
        if($id_pegawai == null){
            $pegawai = $this->rekap->getNominatifPegawaiHardCode($data['id_unitkerja'], $bulan, $tahun, $pegawai);
        }

        if($flag_sekolah_kecamatan == 0){
            // ambil jika ada pegawai PLT / PLH, BAGIAN INI HARUS MENJADI YANG PALING TERAKHIR
            $pegawai = $this->rekap->getPltPlhTambahan($data['id_unitkerja'], $bulan, $tahun, $pegawai);
        }
        
        if($pegawai){
            $i = 0;
            $temp = null;
            $temp_plt = null;
            foreach($pegawai as $p){
                // if(isset($result[$p['id_m_user']])){
                //     $temp[$p['id_m_user']] = $result[$p['id_m_user']];
                //     // if($p['id_m_user'] == '1806'){
                //     //     dd($temp);
                //     // }
                // }
                $result[$p['id_m_user']] = $p;

                $result[$p['id_m_user']]['kepala_skpd'] = $p['kepalaskpd'];
                $result[$p['id_m_user']]['count'] = isset($result[$p['id_m_user']]['count']) 
                ? $result[$p['id_m_user']]['count']++ 
                : 1;

                $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jfu'];
                $result[$p['id_m_user']]['prestasi_kerja'] = $p['prestasi_kerja'];
                $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                $result[$p['id_m_user']]['kondisi_kerja'] = $p['kondisi_kerja'];
                
                if($p['jenis_jabatan'] == 'JFT'){ // jika JFT
                    $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan'];
                    $namaunitkerja = null;
                    if($unitkerja){
                        $namaunitkerja = explode(" ", $unitkerja['nm_unitkerja']);
                    }
                    if($unitkerja && $namaunitkerja[0] == 'Puskesmas'){
                        // $result[$p['id_m_user']]['kelas_jabatan'] = $p['kepalaskpd'] == 1 ? $p['kelas_jabatan'] : $p['kelas_jabatan_jft'];
                        $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan'];
                        $explode_nama_jabatan = explode(" ", $p['nama_jabatan']);
                        $list_selected_jf = ['Pertama', 'Muda', 'Penyelia', 'Terampil', 'Madya', 'Utama', 'Lanjutan', 'Pelaksana', 'Mahir'];
                        if(!in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], $list_selected_jf) && $p['kepalaskpd'] != 1){
                            $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jft'];
                            if($p['kelas_jabatan_jft'] > 7){
                                $result[$p['id_m_user']]['kelas_jabatan'] = 7;
                            }
                        }
                    }
                    // if(isContainSeq($p['nama_jabatan'], "Ahli Utama")){
                    //     $result[$p['id_m_user']]['kelas_jabatan'] = 11;
                    // } else if(isContainSeq($p['nama_jabatan'], "Ahli Madya")){
                    //     $result[$p['id_m_user']]['kelas_jabatan'] = 10;
                    // } else if(isContainSeq($p['nama_jabatan'], "Ahli Muda")){
                    //     $result[$p['id_m_user']]['kelas_jabatan'] = 9;
                    // } else if(isContainSeq($p['nama_jabatan'], "Ahli Pertama")){
                    //     $result[$p['id_m_user']]['kelas_jabatan'] = 8;
                    // }

                    // penentuan besaran presentasi
                    if($data['id_unitkerja'] == '4011000'){ // jika INSPEKTORAT
                        if(isContainSeq($p['nama_jabatan'], "Ahli Utama")){
                            // $result[$p['id_m_user']]['beban_kerja'] = "99";
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                        } else if(isContainSeq($p['nama_jabatan'], "Ahli Madya")){
                            // $result[$p['id_m_user']]['beban_kerja'] = "99";
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                        } else if(isContainSeq($p['nama_jabatan'], "Ahli Muda")){
                            // $result[$p['id_m_user']]['beban_kerja'] = "93.50";
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                        } else if(isContainSeq($p['nama_jabatan'], "Ahli Pertama")){
                            // $result[$p['id_m_user']]['beban_kerja'] = "41";
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                        }  else if(isContainSeq($p['nama_jabatan'], "Mahir") || isContainSeq($p['nama_jabatan'], "Terampil") || isContainSeq($p['nama_jabatan'], "Penyelia")){
                            // $result[$p['id_m_user']]['beban_kerja'] = "41";
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja'];
                        }
                    } else if($data['id_unitkerja'] == '4026000'){ // jika BKAD
                        if(isContainSeq($p['nama_jabatan'], "Ahli Utama")){
                            $result[$p['id_m_user']]['beban_kerja'] = "97.89";
                        } else {
                            $result[$p['id_m_user']]['beban_kerja'] = "38.73";
                        }
                    } else if($data['id_unitkerja'] == '4018000' || $data['id_unitkerja'] == '3030000' || $data['id_unitkerja'] == '4012000'){ // jika BKPSDM atau PTSP atau bapelitbang
                        if($result[$p['id_m_user']]['beban_kerja'] == "0" || $result[$p['id_m_user']]['beban_kerja'] == 0){
                            $result[$p['id_m_user']]['beban_kerja'] = "19.014023292059";
                        }
                    } else if($data['id_unitkerja'] == '3015000'){ //jika DISDUKCAPIL
                        if($result[$p['id_m_user']]['beban_kerja'] == "0" || $result[$p['id_m_user']]['beban_kerja'] == 0){
                            $result[$p['id_m_user']]['beban_kerja'] = "23.94";
                        }
                    } else if($data['id_unitkerja'] == '1010400' || $data['id_unitkerja'] == '1030750' || $data['id_unitkerja'] == '1020500'){ // jika BAGIAN HUKUM / BPK / BARJAS
                        if($result[$p['id_m_user']]['beban_kerja'] == "0" || $result[$p['id_m_user']]['beban_kerja'] == 0){
                            $result[$p['id_m_user']]['beban_kerja'] = "23.94";
                        }
                    } else if($data['id_unitkerja'] == '7005010' || $data['id_unitkerja'] == '7005020'){ // jika RSUD atau RSKDGM
                        if($result[$p['id_m_user']]['kondisi_kerja'] == "0" || $result[$p['id_m_user']]['kondisi_kerja'] == 0){
                            $result[$p['id_m_user']]['kondisi_kerja'] = "19.014023292059";
                        }
                    }
                    
                    if(in_array($p['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){ //jika guru
                        $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan'];
                        $explode_nama_jabatan = explode(" ", $p['nama_jabatan']);
                        $list_selected_jf = ['Pertama', 'Muda', 'Penyelia', 'Terampil', 'Madya', 'Utama', 'Lanjutan', 'Pelaksana', 'Mahir'];
                        if(!in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], $list_selected_jf) ){
                            $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jft'];
                            if($p['kelas_jabatan_jft'] > 7){
                                $result[$p['id_m_user']]['kelas_jabatan'] = 7;
                            }
                        }
                        
                        // $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jft'];
                    }

                    // if($this->general_library->isProgrammer()){
                    //     if(!isset($p['skpd'])){
                    //         dd($p);
                    //     }
                    // }

                    if($p['id_unitkerja'] == 6170000 || // if puskes bunaken
                    $unitkerja['id_unitkerjamaster_kecamatan'] == 5011001 || // sekolah di bunaken kepulauan
                    $p['id_unitkerja'] == 8020096){  // smp bunaken kepulauan
                        if($result[$p['id_m_user']]['kondisi_kerja'] == "0" || $result[$p['id_m_user']]['kondisi_kerja'] == 0){
                            $result[$p['id_m_user']]['kondisi_kerja'] = "19.014023292059";
                        }
                    }
                    // else if($p['id_unitkerjamaster'] == 5011001){ // if kecamatan bunaken kepulauan

                    // }

                    if(isset($p['id_jabatan_tambahan']) && $p['id_jabatan_tambahan']){ // jika ada jabatan tambahan
                        if(stringStartWith("Kepala Puskesmas", $p['nama_jabatan_tambahan'])){ // jika Kepala Puskesmas
                            $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_tambahan'];
                            $result[$p['id_m_user']]['prestasi_kerja'] = $p['prestasi_kerja_tambahan'];
                            $result[$p['id_m_user']]['beban_kerja'] = $p['beban_kerja_tambahan'];
                            $result[$p['id_m_user']]['kondisi_kerja'] = $p['kondisi_kerja_tambahan'];
                        }
                    }

                    // $substr = substr($p['nipbaru_ws'], 8, 6);
                    // if($substr == '202203'){ // JFT PNS baru kelas jabatan di revert karena belum ada anggaran TPP naik  
                    //     $result[$p['id_m_user']]['kelas_jabatan'] = 7;
                    // }

                    if(isset($p['statuspeg']) && $p['statuspeg'] == 1){ // jika CPNS
                        $result[$p['id_m_user']]['kelas_jabatan'] = 7;
                    }

                    if(isset($p['kelas_jabatan_hardcode']) && ($p['kelas_jabatan_hardcode'] != null || $p['kelas_jabatan_hardcode'] != 0)){
                        $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_hardcode'];
                    }
                } else if($p['jenis_jabatan'] == 'Struktural'){ // jika struktural
                    $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan'];
                }  else if($p['jenis_jabatan'] == 'JFU'){ // jika JFU
                    if($data['id_unitkerja'] == '7005010' || $data['id_unitkerja'] == '7005020'){ // jika RSUD atau RSKDGM
                        $result[$p['id_m_user']]['kondisi_kerja'] = $this->getBebanKerjaJfuSkpd($data['id_unitkerja']);
                    } else {
                        $result[$p['id_m_user']]['beban_kerja'] = $this->getBebanKerjaJfuSkpd($data['id_unitkerja']);
                    }

                    if(in_array($p['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){ //jika guru
                        $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_jfu'];
                    }
                }

                // if($data['id_unitkerja'] == 1030550){
                //     // dd($p);
                // }
                if(isset($p['kelas_jabatan_hardcode']) && ($p['kelas_jabatan_hardcode'] != null || $p['kelas_jabatan_hardcode'] != 0)){
                    $result[$p['id_m_user']]['kelas_jabatan'] = $p['kelas_jabatan_hardcode'];
                }
                
                $result[$p['id_m_user']]['nama_jabatan'] = $p['nama_jabatan'];
                
                $result[$p['id_m_user']]['jenis_jabatan'] = $p['jenis_jabatan'];
                
                $total_beban_prestasi = (floatval($result[$p['id_m_user']]['prestasi_kerja']) 
                + floatval($result[$p['id_m_user']]['beban_kerja']) 
                + floatval($result[$p['id_m_user']]['kondisi_kerja'])) 
                / 100;
                
                $result[$p['id_m_user']]['pagu_tpp'] = floatval($pagu_tpp[$result[$p['id_m_user']]['kelas_jabatan']]) * floatval($total_beban_prestasi);
                $result[$p['id_m_user']]['total_beban_prestasi'] = $total_beban_prestasi;
                
                if(isset($p['presentasi_tpp']) || ($temp_plt && in_array($p['id_m_user'], $temp_plt))){
                    $uk_asal = $this->db->select('*')
                                        ->from('db_pegawai.pegawai')
                                        ->where('nipbaru_ws', $p['nipbaru_ws'])
                                        ->get()->row_array();

                    // if($uk_asal['skpd'] == $data['id_unitkerja']){
                        // jika pegawai plt / plh di unitkerja yang sama, maka tambah presentasi tambahan
                        if(isset($temp[$p['id_m_user']])){
                        // if(isset($p['flag_timpa_tpp']) && $p['flag_timpa_tpp'] == 1){

                            //ambil TPP plt nya saja
                            if(isset($p['flag_timpa_tpp']) && $p['flag_timpa_tpp'] == 1){
                                $result[$p['id_m_user']]['pagu_tpp'] = $result[$p['id_m_user']]['pagu_tpp'];
                            } else {
                            // tambahkan dengan tpp plt
                                $temp_tpp = $temp[$p['id_m_user']]['pagu_tpp'];
                                $result[$p['id_m_user']]['tambahan_raw'] = $result[$p['id_m_user']]['pagu_tpp'];
                                $result[$p['id_m_user']]['tambahan'] = $result[$p['id_m_user']]['pagu_tpp'] * ($p['presentasi_tpp'] / 100);
                                $result[$p['id_m_user']]['pagu_sebelum'] = $temp_tpp;
                                $result[$p['id_m_user']]['pagu_tpp'] = $result[$p['id_m_user']]['pagu_tpp'] * ($p['presentasi_tpp'] / 100);
                                $result[$p['id_m_user']]['pagu_tpp'] += $temp_tpp;
                                // dd(json_encode($result[$p['id_m_user']]));
                            }
                            // $result[$p['id_m_user']]['pagu_tpp'] += $temp_tpp;
                            // if($this->general_library->isProgrammer()){
                            //     dd($result[$p['id_m_user']]);
                            // }
                        }
                    // }
                    else {
                        // jika pegawai plt / plh bukan di unitkerja yang sama, maka hanya presentasi tambahan
                        // if(isset($result[$p['id_m_user']]['pagu_tpp'])){
                        //     dd($result[$p['id_m_user']]);
                        // }
                        $result[$p['id_m_user']]['pagu_tpp'] = $result[$p['id_m_user']]['pagu_tpp'] * ($p['presentasi_tpp'] / 100);
                        $temp_plt[] = $p['id_m_user'];
                        // dd(in_array("1806", $temp_plt));
                    }
                }

                $explode = explode(".", $result[$p['id_m_user']]['pagu_tpp']);
                $minus = substr($explode[0], -3);
                $result[$p['id_m_user']]['pagu_tpp'] = intval($explode[0]) - intval($minus);
                // if($p['kepalaskpd'] == 1){
                //     echo(floatval($pagu_tpp[$result[$p['id_m_user']]['kelas_jabatan']]));
                //     dd($result[$p['id_m_user']]);
                // }
                // if($p['nipbaru_ws'] == '198101212005011011'){
                //     echo(floatval($pagu_tpp[$result[$p['id_m_user']]['kelas_jabatan']]));
                //     echo "<br>";
                //     echo($total_beban_prestasi);
                //     echo "<br>";
                //     dd($result[$p['id_m_user']]);
                // }

                if($result[$p['id_m_user']]['statuspeg'] == 1){ //pegawai CPNS
                    $result[$p['id_m_user']]['pagu_tpp'] = $result[$p['id_m_user']]['pagu_tpp'] * 0.8;
                } else if($result[$p['id_m_user']]['statuspeg'] == 3 && $p['flag_terima_tpp'] == 0){ //PPPK dan tidak trima TPP
                    $result[$p['id_m_user']]['pagu_tpp'] = 0;
                }

                if($p['flag_terima_tpp'] == 0){
                    $result[$p['id_m_user']]['pagu_tpp'] = 0;
                }

                if(in_array($p['nipbaru_ws'], EXCLUDE_NIP)){
                    $result[$p['id_m_user']]['pagu_tpp'] = 0;
                }
                
                if($id_pegawai != null && $id_pegawai == $p['id_m_user']){
                    return $result[$p['id_m_user']];
                }

                $temp[$p['id_m_user']] = $result[$p['id_m_user']];

                $i++;
            }
        }

        // function comparator1($object1, $object2) {
        //     return $object1['kelas_jabatan'] < $object2['kelas_jabatan'];
        // }

        // usort($result, 'comparator1');
        return $result;
    }

    public function countPaguTppBu($data, $id_pegawai = null, $flag_profil = 0, $flag_rekap_tpp = 0){
        $result = null;

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $data['id_unitkerja'])
                            ->get()->row_array();

        $pagu_tpp = $this->getPaguTppUnitKerja($data['id_unitkerja'], $unitkerja);

        $nama_unit_kerja = explode(" ", $unitkerja['nm_unitkerja']);
                            
        $this->db->select('a.nipbaru_ws, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, e.id as id_m_user,
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
                    
                    // ->where('a.skpd', $data['id_unitkerja'])
                    ->order_by('c.eselon, a.nama')
                    ->where('e.flag_active', 1);
                    // ->where('id_m_status_pegawai', 1)
                    // ->get()->result_array();
        if($flag_profil == 1){
            $this->db->where('id_m_status_pegawai', 1);
        }
        if($flag_rekap_tpp == 1 && in_array($data['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN)){
            $this->db->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja')
                    ->where('f.id_unitkerjamaster', substr($data['id_unitkerja'], 0, 7));
        }
        $pegawai = $this->db->get()->result_array();
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
        dd(json_encode($result));
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

    function getPegawaiPeninjauanAbsensi(){
        $id_peg = $this->general_library->getIdPegSimpeg();
        $this->db->select('a.*, b.id')
        ->where('a.id_m_status_pegawai', 1)
        ->where('b.flag_active', 1)
        ->where('a.skpd', $this->general_library->getUnitKerjaPegawai())
        ->where_not_in('a.id_peg', [$id_peg])
        ->join('m_user b', 'b.username = a.nipbaru_ws')
        ->from('db_pegawai.pegawai a');
        return $this->db->get()->result_array(); 
    }

    function getDataPengajuanAbsensiPegawai()
{        
    
    $bulan = date("m",strtotime($this->input->post('tanggal')));
    $tahun = date("Y",strtotime($this->input->post('tanggal')));
    $this->db->select('
    (select count(*) from t_peninjauan_absensi as h where h.id_m_user = a.id_m_user and h.flag_active = 1  and month(h.tanggal_absensi) = '.$bulan.' and year(h.tanggal_absensi) = '.$tahun.'  limit 1) as total_pengajuan,
    (select count(*) from t_peninjauan_absensi as h where h.id_m_user = a.id_m_user and h.flag_active = 1 and h.status = 2  and month(h.tanggal_absensi) = '.$bulan.' and year(h.tanggal_absensi) = '.$tahun.'  limit 1) as total_tolak')
    ->from('t_peninjauan_absensi a')
    ->where('a.flag_active', 1)
    ->where('a.id_m_user', $this->general_library->getId())
    ->group_by('a.id_m_user')
    ->order_by('a.tanggal_absensi', 'asc');
    $result = $this->db->get()->result_array();
    return $result;
}

    public function getStatusLockKinerja($menu){
        return $this->db->select('a.status')
                        ->from('t_lock_kinerja as a ')
                        ->where('a.flag_active', 1)
                        ->where('a.menu', $menu)
                        ->get()->result_array();
    }


    public function rekapPenilaianSearch2($data){
        //    dd($data);
            $result = null;
            $skpd = explode(";",$data['skpd']);

            $uksearch = $this->db->select('*')
            ->from('db_pegawai.unitkerja')
            ->where('id_unitkerja', $skpd[0])
            ->get()->row_array();
            
            $this->db->select('a.statuspeg,b.username as nip, a.nama, a.gelar1, a.gelar2, b.id, c.nama_jabatan, c.eselon, c.kelas_jabatan')
            ->from('db_pegawai.pegawai a')
            ->join('m_user b', 'a.nipbaru_ws = b.username')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
            ->where('b.flag_active', 1)
            ->order_by('c.eselon, b.username')
            ->where('a.id_m_status_pegawai', 1);
            // ->where('a.flag_terima_tpp', 1);
            
            if(stringStartWith('sekolah_', $data['skpd'])){
                // dd(1);
                $skpd = explode(";",$data['skpd']);
                $expluk = explode("_",$skpd[0]);
            $this->db->where('id_unitkerjamaster_kecamatan', $expluk[1]);
            } else if(in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
            $this->db->where('id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
            }  else {
                $this->db->where('a.skpd', $skpd[0]);
            }
            $list_pegawai =  $this->db->get()->result_array();

            $temp_pegawai = null;
            if($list_pegawai){
                $i = 0;
                $j = 0;
                foreach($list_pegawai as $p){
                    $temp = $p;
                    $bobot_komponen_kinerja = 0;
                    $bobot_skp = 0;
                    $temp['komponen_kinerja'] = $this->getKomponenKinerja($p['id'], $data['bulan'], $data['tahun']);
                    if($temp['komponen_kinerja']){
                        list($temp['komponen_kinerja']['capaian'], $temp['komponen_kinerja']['bobot']) = countNilaiKomponen($temp['komponen_kinerja']);
                        $bobot_komponen_kinerja = $temp['komponen_kinerja']['bobot'];

                    }
                    $temp['kinerja'] = $this->getKinerjaPegawai2($p['id'], $data['bulan'], $data['tahun']);
                    if($temp['kinerja']){
                        $temp['nilai_skp'] = countNilaiSkp2($temp['kinerja']);
                        $bobot_skp = $temp['nilai_skp']['bobot'];
                    }
                    $temp['bobot_capaian_produktivitas_kerja'] = floatval($bobot_komponen_kinerja) + floatval($bobot_skp);
                    
                    if(isset($data['kriteria'])){

                    if($data['kriteria'] == 2){
                        if($temp['bobot_capaian_produktivitas_kerja'] == 60){
                            $result[$i] = $temp;
                            $i++;  
                        }
                    } else if($data['kriteria'] == 3){
                        if($temp['bobot_capaian_produktivitas_kerja'] >= 48 && $temp['bobot_capaian_produktivitas_kerja'] < 60){
                            $result[$i] = $temp;
                            $i++;  
                        }
                    } else if($data['kriteria'] == 4){
                        if($temp['bobot_capaian_produktivitas_kerja'] <= 47){
                            $result[$i] = $temp;
                            $i++;  
                        }
                    } else {
                        $result[$i] = $temp;
                        $i++;
                    } 
                    } else {
                        $result[$i] = $temp;
                        $i++;
                    }

                   
                }
                
            }
            // dd($result);
            return $result;
        }

        public function getKinerjaPegawai2($id_m_user, $bulan, $tahun){
            // return $this->db->select('*,
            //                 (SELECT SUM(b.realisasi_target_kuantitas)
            //                 FROM t_kegiatan b
            //                 WHERE b.id_t_rencana_kinerja = t_rencana_kinerja.id
            //                 AND b.flag_active = 1 and b.status_verif = 1) as realisasi')
            //                 ->from('t_rencana_kinerja')
            //                 ->where('id_m_user', $id_m_user)
            //                 ->where('bulan', $bulan)
            //                 ->where('tahun', $tahun)
            //                 ->where('flag_active', 1)
            //                 ->get()->result_array();
            return $this->db->select('id,sum(target_kuantitas) as target, sum(total_realisasi) as realisasi')
                            ->from('t_rencana_kinerja')
                            ->where('id_m_user', $id_m_user)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->group_by('id')
                            ->get()->result_array();
        }


        public function getKomponenKinerja($id_m_user, $bulan, $tahun){
            return $this->db->select('*')
                            ->from('t_komponen_kinerja as a')
                            ->where('id_m_user', $id_m_user)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->get()->row_array();
        }


        public function inputSasaranPrevMonth()
        {
    
            $this->db->trans_begin();
                
         
            $currentMonth = date('m');
            $currentYear = date('Y');
           
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');

                // $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
                // $dataInsert['nilai_assesment']      = $this->input->post('nilai_assesment');
                // $dataInsert['tahun']      = $this->input->post('tahun');
                // $dataInsert['created_by']      = $this->general_library->getId();
                // $dataInsert['updated_by']      = $this->general_library->getId();
                // if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                //     $dataInsert['status']      = 2;
                //     $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                //     $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                //     }
                // $result = $this->db->insert('db_pegawai.pegassesment', $dataInsert);

                $sasaranLM = $this->db->select('*')
                            ->from('t_rencana_kinerja')
                            ->where('id_m_user', $this->general_library->getId())
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->get()->result_array();
            //    dd($sasaranLM);
                
                $sasaran = null;
                foreach($sasaranLM as $h){
                    $i = 0;
                    $sasaran[] = [
                        'id_m_user' => $h['id_m_user'],
                        'tugas_jabatan' => $h['tugas_jabatan'],
                        'bulan' => $currentMonth,
                        'tahun' => $currentYear,
                        'target_kuantitas' => $h['target_kuantitas'],
                        'satuan' => $h['satuan'],
                        'sasaran_kerja' => $h['sasaran_kerja'],
                        'target_kualitas' => $h['target_kualitas'],
                        'created_by' => $h['id_m_user']
                    ];
                    $i++;
                }
                // dd($sasaran);
                if($sasaran){
                    $this->db->insert_batch('t_rencana_kinerja', $sasaran);
                }

                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            
            
        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }
    
        return $res;
            
        }

        function getDataPengajuanAbsensiTemanPegawai()
        {        
            $res = null;
            $this->db->select('*')
            ->from('db_sip.absen a')
            ->where('a.tgl', $this->input->post('tanggal_absensi'))
            ->where('a.user_id', $this->input->post('id_user'));
            $result = $this->db->get()->result_array();
            // print_r($this->input->post());
            if($result){
                if($this->input->post('jenis_absensi') == 2){
                    if($result[0]['pulang']){
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    } else {
                    $res = array('msg' => 'Pegawai yang bersangkutan belum melakukan presensi', 'success' => false);
                    }
                } else {
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                }
            } else {
                $res = array('msg' => 'Pegawai yang bersangkutan belum melakukan presensi', 'success' => false);
            }
            return $res;
        }

    
}