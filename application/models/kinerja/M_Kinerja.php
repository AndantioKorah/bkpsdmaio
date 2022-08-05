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
                      'id_m_user' => $this->general_library->getId()
        );
        $result = $this->db->insert('t_kegiatan', $data);
       
        //cek 
        $id =  $this->general_library->getId();
        $bulan = date('n');
        $tahun = date('Y');
        $cek = $this->db->select('a.*,
        (select sum(b.realisasi_target_kuantitas) from t_kegiatan as b where a.id = b.id_t_rencana_kinerja and b.flag_active = 1) as realisasi_target_kuantitas
        ')
                        ->from('t_rencana_kinerja a')
                        ->where('a.id_m_user', $id)
                        ->where('a.tahun', $tahun)
                        ->where('a.bulan', $bulan)
                        ->where('a.id', $dataPost['tugas_jabatan'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();

        if($cek){          
         if($cek['0']['realisasi_target_kuantitas'] > $cek['0']['target_kuantitas']){
            $this->db->where('id',  $dataPost['tugas_jabatan'])
                     ->update('t_rencana_kinerja', [
                     'updated_by' => $this->general_library->getId(),
                     'target_kuantitas' => $cek['0']['realisasi_target_kuantitas']
            ]);
         }
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


        public function loadRencanaKinerja($bulan, $tahun){
            $id =  $this->general_library->getId();
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
        $this->db->select('*')
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
        $data["satuan"] = $datapost["edit_satuan"];


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

    public function createSkpBulanan($data){
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
                            ->where('a.id', $this->general_library->getId())
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
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $kepala_pd)
                            ->where('a.flag_active', 1)
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
                            ->where('a.id !=', $this->general_library->getId())
                            ->where('h.role_name', $kepala_pd)
                            ->where('g.flag_active', 1)
                            ->where('a.flag_active', 1)
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
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('b.skpd', $this->general_library->getUnitKerjaPegawai())
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
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
                                        ->where('a.id !=', $this->general_library->getId())
                                        ->where('h.role_name', $atasan)
                                        ->where('a.flag_active', 1)
                                        ->where('g.flag_active', 1)
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
        if($this->general_library->isAdministrator()){
            $id_count = $this->general_library->getUnitKerjaPegawai();
        } 
        $count = $this->countTotalDataPendukung($id_count, $bulan, $tahun);
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
                    $insert_data[$i]['keterangan'] = $disiplin[1];
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

        $this->db->select('COUNT(a.id) as total, a.status')
                ->from('t_dokumen_pendukung a')
                ->join('m_status_dokumen_pendukung b', 'a.status = b.id')
                ->join('m_user c', 'a.id_m_user = c.id')
                ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                ->where('a.bulan', floatval($bulan))
                ->where('a.tahun', floatval($tahun))
                ->where('a.flag_active', 1)
                ->group_by('a.status');

        if($this->general_library->isProgrammer() || $this->general_library->isAdministrator() || ($this->general_library->getBidangUser() == ID_BIDANG_PEKIN && $flag_verif == 1)){
            $this->db->where('d.skpd', $id);
        } else {
            $this->db->where('a.id_m_user', $id);
        }
        
        $count = $this->db->get()->result_array(); 

        if($count){
            
            foreach($count as $c){
                if($c['status'] == 1){
                    $rs['pengajuan'] = $c['total'];
                } else if($c['status'] == 2){
                    $rs['diterima'] = $c['total'];
                } else if($c['status'] == 3){
                    $rs['ditolak'] = $c['total'];
                } else if($c['status'] == 4){
                    $rs['batal'] = $c['total'];
                }
            }
        }

        return $rs;
    }

    public function deleteDataDisiplinKerja($id){
        $res['code'] = 0;
        $res['message'] = 'OK';
        $res['data'] = null;

        $this->db->trans_begin();

        $this->db->where('id', $id)
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
        $this->db->select('c.nama, c.gelar1, c.gelar2, a.*, b.username as nip, b.id as id_m_user, d.status as status_dokumen, e.nama as nama_verif')
        ->from('t_dokumen_pendukung a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('m_status_dokumen_pendukung d', 'a.status = d.id')
        ->join('m_user e', 'a.id_m_user_verif = e.id', 'left')
        ->where('a.bulan', floatval($bulan))
        ->where('a.tahun', floatval($tahun))
        ->where('a.status', floatval($status))
        ->where('c.skpd', $id_unitkerja)
        ->where('a.flag_active', 1);

        if($status == 1){
            $this->db->order_by('created_date', 'asc');
        } else {
            $this->db->order_by('a.updated_date', 'desc');
        }

        $result = $this->db->get()->result_array();

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

        $this->db->where('id', $id)
                ->update('t_dokumen_pendukung', $data_verif);

        $temp = $this->db->select('c.skpd, a.bulan, a.tahun')
                        ->from('t_dokumen_pendukung a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.id', $id)
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
}
?>