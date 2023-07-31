<?php
class M_Kepegawaian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function get_datatables_lihat_dokumen_pns($cariBy,$cariName,$unor)
        {
            
            // $idunor  = $this->arsip->getIdPerangkatDaerah();
            $idunor  = $this->general_library->getUnitKerjaPegawai();
       
            $this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, m_user.nama,dokumen_status.nama_status ');
            // $this->db->from('dokumen_upload');
            $this->db->join('db_pegawai.pegawai ', 'REPLACE(TRIM(pegawai.nipbaru)," ","") = dokumen_upload.nip', 'left');
            $this->db->join('db_siladen.dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
            // $this->db->join('db_siladen.users', 'users.id = dokumen_upload.upload_by', 'left');
            $this->db->join('m_user', 'm_user.id = dokumen_upload.upload_by', 'left');
            $this->db->join('db_siladen.dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');	
            $this->db->or_where('dokumen_upload.nip',$cariName);
            if ($idunor <> NULL)
            {
            $this->db->where('pegawai.skpd',$idunor);
            }
            if ($idunor =='4018000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "0000000" AND "9900000"');
            }
            else if ($idunor =='3010000')
            {
            $this->db->where('pegawai.skpd',"3010000");
            $this->db->or_where('pegawai.skpd BETWEEN "7000000" AND "8400000"');
    
            }
            else if ($idunor =='3012000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "6000000" AND "7900000"');
            }
            else if ($idunor =='1030525')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "1000000" AND "2900000"');
            }
            else if ($idunor =='5001001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5001000" AND "5001100"');
            }	
            else if ($idunor =='5002001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5002000" AND "5002100"');
            }
            else if ($idunor =='5003001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5003000" AND "5003100"');
            }
            else if ($idunor =='5004001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5004000" AND "5004100"');
            }
            else if ($idunor =='5005001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005009" AND "5005013"');
            }
            else if ($idunor =='5006001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5006000" AND "5006100"');
            }
            else if ($idunor =='5007001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5007000" AND "5007100"');
            }
            else if ($idunor =='5008001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5008000" AND "5008100"');
            }
            else if ($idunor =='5009001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5009000" AND "5009100"');
            }
            else if ($idunor =='5010001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005002" AND "5005008"');
            }	
            else if ($idunor =='5011001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5011001" AND "5011101"');
            }
    
            $i = 0;		
        
            
            if($cariBy == 1)
            {
                $this->db->where('dokumen_upload.nip',$cariName);	
            }
            
            if(!empty($unor))
            {
                $this->db->where('dokumen_upload.last_unor',$unor);
            }
            $query = $this->db->get('db_siladen.dokumen_upload');
            return $query->result();
            
        }

        public function openDetailDokumen($id, $jd){
            if($jd == 'pangkat'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegpangkat a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                                ->join('db_pegawai.jenispengangkatan d', 'a.jenispengangkatan = d.id_jenispengangkatan')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'gajiberkala'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.peggajiberkala a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'jabatan'){
                return $this->db->select('*, a.skpd as unit_kerja, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegjabatan a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.jabatan c','a.id_jabatan = c.id_jabatanpeg')
                                ->join('db_pegawai.eselon d','a.eselon = d.id_eselon')
                                ->join('db_pegawai.jenisjab e','a.jenisjabatan = e.id_jenisjab')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'diklat'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegdiklat a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.diklat c','a.jenisdiklat = c.id_diklat')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'organisasi'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegorganisasi a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.organisasi c','a.jenis_organisasi = c.id_organisasi')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'penghargaan'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegpenghargaan a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'sumpahjanji'){
                return $this->db->select('*, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegsumpah a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.sumpah c', 'a.sumpahpeg = c.id_sumpah')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'keluarga'){
                return $this->db->select('*,a.pendidikan as pendidikan_kel, a.tptlahir as tempat_lahir, a.tgllahir as tanggal_lahir, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegkeluarga a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.keluarga c', 'a.hubkel = c.id_keluarga')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'penugasan'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegdatalain a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.jenistugas c', 'a.jenispenugasan = c.id_jenistugas')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'cuti'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegcuti a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.cuti c', 'a.jeniscuti = c.id_cuti')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'skp'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegskp a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'assesment'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegassesment a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'arsip'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen,
                                        CONCAT(c.nama_dokumen, '.' , " / ", c.keterangan) AS name')
                                ->from('db_pegawai.pegarsip a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_siladen.dokumen c', 'a.id_dokumen = c.id_dokumen')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'berkaspns'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegberkaspns a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'pendidikan'){
                return $this->db->select('*,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegpendidikan a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.tktpendidikanb c', 'a.tktpendidikan = c.id_tktpendidikanb')

                                ->where('a.id', $id)
                                ->get()->row_array();
            }
            

            
            
            
        }

        public function searchDokumenUsul($data){
            $tanggal = explodeRangeDate($data['tanggal']);
            $tanggal_awal = explode("-", $tanggal[0]);
            $taw = $tanggal_awal[0].'-'.$tanggal_awal[2].'-'.$tanggal_awal[1];

            $tanggal_akhir = explode("-", $tanggal[1]);
            $tak = $tanggal_akhir[0].'-'.$tanggal_akhir[2].'-'.$tanggal_akhir[1];
            $this->db->select('*, a.id as id_dokumen')
                        ->from('db_pegawai.'.$data['jenisdokumen'].' a')
                        ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                        ->where('a.flag_active', 1)
                        ->where('a.created_date >=', $taw.' 00:00:00')
                        ->where('a.created_date <=', $tak.' 23:59:59')
                        ->order_by('a.created_date', 'desc');

            if($data['status'] != '0'){
                $this->db->where('a.status', $data['status']);
            }

            if($data['unitkerja'] != '0'){
                $this->db->where('b.skpd', $data['unitkerja']);
            }

            // if($data['status'] != '0'){
            //     $this->db->where('b.status', $data['status']);
            // }

            if($data['nama']){
                $this->db->like('b.nama', $data['nama']);
            }

            if($data['nip']){
                $this->db->like('b.nipbaru_ws', $data['nip']);
            }

            // $res = $this->db->get()->result_array();
            return $this->db->get()->result_array();
        }


        function getDokumen()
        {
            $this->db->where('aktif',1);
            $this->db->ORDER_BY('nama_dokumen');
            return $this->db->get('db_siladen.dokumen');
        }


        function getProfilPegawaiByAdmin($username){
            $this->db->select('a.*, g.nm_statusjabatan, b.nm_agama, c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja')
                ->join('db_pegawai.statusjabatan g', 'a.statusjabatan = g.id_statusjabatan')
                ->where('a.nipbaru_ws', $username)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getProfilPegawai($nip = ''){
            $username = $this->general_library->getUserName();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $username = $nip;
                if(!$username){
                    $username = $this->general_library->getUserName();
                }
            }
            $this->db->select('c.id_tktpendidikan,d.id_pangkat,k.id_statusjabatan,j.id_jenisjab,id_jenispeg,h.id_statuspeg,
            g.id_sk,b.id_agama,e.eselon,j.nm_jenisjab,i.nm_jenispeg,h.nm_statuspeg,g.nm_sk,a.*, b.nm_agama, 
            c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja, l.id as id_m_user, k.nm_statusjabatan')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja')
                ->join('db_pegawai.statuskawin g', 'a.status = g.id_sk')
                ->join('db_pegawai.statuspeg h', 'a.statuspeg = h.id_statuspeg')
                ->join('db_pegawai.jenispeg i', 'a.jenispeg = i.id_jenispeg')
                ->join('db_pegawai.jenisjab j', 'a.jenisjabpeg = j.id_jenisjab')
                ->join('db_pegawai.statusjabatan k', 'a.statusjabatan = k.id_statusjabatan')
                ->join('m_user l', 'a.nipbaru_ws = l.username')
                ->where('a.nipbaru_ws', $username)
                ->where('l.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getPangkatPegawai($nip,$kode){
             $this->db->select('c.keterangan,c.created_date,c.gambarsk,c.id,c.status,e.nm_jenispengangkatan, c.masakerjapangkat, d.nm_pangkat, c.tmtpangkat, c.pejabat,
                            c.nosk, c.tglsk, c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpangkat c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.pangkat d','c.pangkat = d.id_pangkat')
                            ->join('db_pegawai.jenispengangkatan e','c.jenispengangkatan = e.id_jenispengangkatan')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->where('c.flag_active', 1)
                            ->order_by('c.tglsk', 'desc');

                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }

                            $query = $this->db->get()->result_array();
                            return $query;
        }

       

        function getPendidikan($nip,$kode){
             $this->db->select('c.id,c.status,e.nm_tktpendidikanb,c.namasekolah,c.fakultas,c.pimpinansekolah,c.tahunlulus,c.noijasah,c.tglijasah,c.gambarsk,c.jurusan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpendidikan c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.tktpendidikan d','b.pendidikan = d.id_tktpendidikan')
                            ->join('db_pegawai.tktpendidikanb e','c.tktpendidikan = e.id_tktpendidikanb')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->where('c.flag_active', 1)
                            ->order_by('c.tglijasah','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }

                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getJabatan($nip,$kode){
              $this->db->select('c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                            // ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.eselon e','c.eselon = e.id_eselon','left')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->where('c.flag_active', 1)
                            ->order_by('c.tmtjabatan','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }

                            $query = $this->db->get()->result_array();
                            return $query;
        }


        function getDiklat($nip,$kode){
             $this->db->select('c.created_date,c.keterangan,c.id,c.status,d.nm_jdiklat,c.nm_diklat,c.tptdiklat,c.penyelenggara,c.angkatan,c.jam,c.tglmulai,c.tglselesai,c.tglsttpp,c.nosttpp,c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegdiklat c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.diklat d','c.jenisdiklat = d.id_diklat')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc')
                            ->where('c.flag_active', 1);
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }

                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getGajiBerkala($nip,$kode){
             $this->db->select('c.created_date,c.id,c.status,c.masakerja,d.nm_pangkat,c.pejabat,c.nosk,c.tglsk,c.tmtgajiberkala,c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.peggajiberkala c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.pangkat d', 'b.pangkat = d.id_pangkat')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->where('c.flag_active', 1)
                            ->order_by('c.tglsk','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getSkp($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegskp c', 'b.id_peg = c.id_pegawai')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getBerkasPns($nip,$kode){
            $this->db->select('*')
                           ->from('m_user a')
                           ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                           ->join('db_pegawai.pegberkaspns c', 'b.id_peg = c.id_pegawai')
                           ->where('a.username', $nip)
                           ->where('c.flag_active', 1)
                           ->where('a.flag_active', 1)
                           ->order_by('c.created_date','desc');
                           if($kode == 1){
                               $this->db->where('c.status', 2);
                           }
                           $query = $this->db->get()->result_array();
                           return $query;
       }

        function getPenugasan($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegdatalain c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.jenistugas d', 'c.jenispenugasan = d.id_jenistugas')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getAssesment($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegassesment c', 'b.id_peg = c.id_pegawai')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1);
                            // ->order_by('c.tglsk','desc')
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getKeluarga($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegkeluarga c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.keluarga d', 'c.hubkel = d.id_keluarga')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getOrganisasi($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegorganisasi c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.organisasi d', 'c.jenis_organisasi = d.id_organisasi')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getPenghargaan($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpenghargaan c', 'b.id_peg = c.id_pegawai')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getCuti($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegcuti c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.cuti d', 'c.jeniscuti = d.id_cuti')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getArsip($nip,$kode){
             $this->db->select('*,CONCAT(d.nama_dokumen, '.' , " / ", d.keterangan) AS name')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegarsip c', 'b.id_peg = c.id_pegawai')
                            ->join('db_siladen.dokumen d', 'c.id_dokumen = d.id_dokumen', 'left')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getSumpahJanji($nip,$kode){
             $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegsumpah c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.sumpah d', 'c.sumpahpeg = d.id_sumpah')
                            ->where('a.username', $nip)
                            ->where('c.flag_active', 1)
                            ->where('a.flag_active', 1)
                            ->order_by('c.created_date','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function isArsip($data, $id_dok)
	{
	    $r = FALSE;
		$find    = $data;
		
	    $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from db_siladen.dokumen ) a
            WHERE a.result = 1 and a.id_dokumen = $id_dok AND a.aktif IS NOT NULL"); 
            
		if($query->num_rows() > 0){
		    $r 		= TRUE;
		}
        return $r;
    }

    function isFormatOK($file)
    {
        $r = FALSE;
        $raw_file          = str_replace('.pdf', '', $file);
        $format_file     = explode("_", $raw_file);

        $sql = "SELECT panjang FROM (SELECT *,locate(nama_dokumen,'$file') result from db_siladen.dokumen ) a
        WHERE a.result = 1 AND a.aktif IS NOT NULL";
        $row = $this->db->query($sql)->row();
        if (count($format_file) === intval($row->panjang)) {
            $r = TRUE;
        }

        return $r;
    }

    function isMinorOK($file)
    {
        $raw_file          = str_replace('.pdf', '', $file);
        $format_file     = explode("_", $raw_file);
        $arr1            = array('KODE', 'TAHUN');

        $r = TRUE;
        if (count($format_file) == 4) {
            $number  = $this->_extract_numbers($format_file[3]);
            if (count($number) > 0) {
                $r = TRUE;
            } else {
                $r = FALSE;
            }
        }


        return $r;
    }

    function isAllowSize($file, $id_dok)
    {
        $file_name  = $file['name'];
        $file_size  = $file['size'];

        $query = $this->db->query("SELECT * FROM  db_siladen.dokumen  a
        WHERE a.id_dokumen = $id_dok  AND a.aktif IS NOT NULL");
        // dd($query->num_rows());

        if ($query->num_rows() > 0) {

            $row             = $query->row();
            $file_size      = round($file_size / 1024, 2);
            if ($file_size > $row->file_size) {
                $data['pesan']          = " File Dokumen Hanya diizinkan Maksimal " . round($row->file_size / 1024, 2) . " MB";
                $data['response']         = FALSE;
            } else {
                $data['pesan']     = " File diizinkan";
                $data['response']  = TRUE;
            }
        } else {
            $data['pesan']     = " File bukan arsip kepegawaian yang disyaratkan";
            $data['response']  = FALSE;
        }

        return $data;
    }

    function insertUpload($data)
    {
            // $query = $this->db->select('b.id_peg')
            // ->from('m_user a')
            // ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            // ->where('a.id', $this->general_library->getId())
            // ->get()->row_array();
            $id_peg =  $this->input->post('id_pegawai');
        $id_dok  = $this->input->post('id_dokumen');
        // dd($id_dok);
        if($id_dok == 4){
             //PANGKAT   
        $tgl_sk = date("Y-m-d", strtotime($this->input->post('tanggal_sk')));
        $tmt_pangkat = date("Y-m-d", strtotime($this->input->post('tmt_pangkat')));
        $dataInsert['id_pegawai']     = $id_peg;
        $dataInsert['jenispengangkatan']      = $this->input->post('jenis_pengangkatan');
        $dataInsert['pangkat']      = $this->input->post('pangkat');
        $dataInsert['masakerjapangkat']     =$this->input->post('masa_kerja');
        $dataInsert['pejabat']      = $this->input->post('pejabat');
        $dataInsert['nosk']      = $this->input->post('no_sk');
        $dataInsert['tglsk']      = $tgl_sk;
        $dataInsert['gambarsk']      = $data['nama_file'];
        $dataInsert['tmtpangkat']      = $tmt_pangkat;
        $dataInsert['created_by']      = $this->general_library->getId();
        if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
            $dataInsert['status']      = 2;
            $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
        }
        $result = $this->db->insert('db_pegawai.pegpangkat', $dataInsert);
          // PANGKAT
        } else if($id_dok == 7){
            $tgl_sk = date("Y-m-d", strtotime($this->input->post('gb_tanggal_sk')));
            $tmt_gaji_berkala = date("Y-m-d", strtotime($this->input->post('tmt_gaji_berkala')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['pangkat']      = $this->input->post('gb_pangkat');
            $dataInsert['masakerja']     =$this->input->post('gb_masa_kerja');
            $dataInsert['pejabat']      = $this->input->post('gb_pejabat');
            $dataInsert['nosk']      = $this->input->post('gb_no_sk');
            $dataInsert['tglsk']      = $tgl_sk;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['tmtgajiberkala']      = $tmt_gaji_berkala;
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->db->insert('db_pegawai.peggajiberkala', $dataInsert);
        } else if($id_dok == 6){
            $tgl_ijazah = date("Y-m-d", strtotime($this->input->post('pendidikan_tanggal_ijazah')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['tktpendidikan']      = $this->input->post('pendidikan_tingkat');
            $dataInsert['jurusan']      = $this->input->post('pendidikan_jurusan');
            $dataInsert['fakultas']     =$this->input->post('pendidikan_fakultas');
            $dataInsert['namasekolah']      = $this->input->post('pendidikan_nama_sekolah_universitas');
            $dataInsert['pimpinansekolah']      = $this->input->post('pendidikan_nama_pimpinan');
            $dataInsert['tahunlulus']      = $this->input->post('pendidikan_tahun_lulus');
            $dataInsert['noijasah']      = $this->input->post('pendidikan_tahun_lulus');
            $dataInsert['tglijasah']      = $tgl_ijazah;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->db->insert('db_pegawai.pegpendidikan', $dataInsert);
        } else if($id_dok == 8){

            $str = $this->input->post('jabatan_nama');
            $newStr = explode(",", $str);
            $id_jabatan = $newStr[0];
            $nama_jabatan = $newStr[1];

            $skpd = $this->input->post('jabatan_unitkerja');
            $newSkpd = explode(",", $skpd);
            $id_skpd = $newSkpd[0];
            $nama_skpd = $newSkpd[1];

            $tgl_sk = date("Y-m-d", strtotime($this->input->post('jabatan_tanggal_sk')));
            $tmt_jabatan = date("Y-m-d", strtotime($this->input->post('jabatan_tmt')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['nm_jabatan']      = $nama_jabatan;
            $dataInsert['id_jabatan']      = $id_jabatan;
            $dataInsert['tmtjabatan']     =$tmt_jabatan;
            $dataInsert['jenisjabatan']      = $this->input->post('jabatan_jenis');
            $dataInsert['pejabat']      = $this->input->post('jabatan_pejabat');
            $dataInsert['eselon']      = $this->input->post('jabatan_eselon');
            $dataInsert['nosk']      = $this->input->post('jabatan_no_sk');
            $dataInsert['tglsk']      = $tgl_sk;
            $dataInsert['skpd']      = $nama_skpd;
            $dataInsert['alamatskpd']      = "";
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
           

            $getJabatan = $this->db->select('*')
            ->from('db_pegawai.pegjabatan a')
            ->where('a.id_pegawai', $id_peg)
            ->order_by('tmtjabatan', 'desc')
            ->limit(1)
            ->get()->row_array();

           
            if(strtotime($tmt_jabatan) > strtotime($getJabatan['tmtjabatan'])){
                $dataUpdate["skpd"] =  $id_skpd;
                $dataUpdate["tmtjabatan"] =  $tmt_jabatan;
                $dataUpdate["jabatan"] =   $id_jabatan;
                $dataUpdate["jenisjabpeg"] =  $this->input->post('jabatan_jenis');
                $this->db->where('id_peg', $id_peg)
                        ->update('db_pegawai.pegawai', $dataUpdate);
            } 

          $result = $this->db->insert('db_pegawai.pegjabatan', $dataInsert);
        } else if($id_dok == 20){            
            $tgl_sttpp = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_sttpp')));
            $tgl_mulai = date("Y-m-d", strtotime($this->input->post('diklat_tangal_mulai')));
            $tgl_selesai = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_selesai')));
           
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['jenisdiklat']      = $this->input->post('diklat_jenis');
            $dataInsert['nm_diklat']      = $this->input->post('diklat_nama');
            $dataInsert['tptdiklat']     = $this->input->post('diklat_tempat');
            $dataInsert['penyelenggara']      = $this->input->post('diklat_penyelenggara');
            $dataInsert['angkatan']      = $this->input->post('diklat_angkatan');
            $dataInsert['jam']      = $this->input->post('diklat_jam');
            $dataInsert['tglmulai']      = $tgl_mulai;
            $dataInsert['tglselesai']      = $tgl_selesai;
            $dataInsert['nosttpp']      =$this->input->post('diklat_no_sttpp');
            $dataInsert['tglsttpp']      = $tgl_sttpp;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->db->insert('db_pegawai.pegdiklat', $dataInsert);
        } else if($id_dok == 5){   
            // dd(1);         
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['tahun']      = $this->input->post('skp_tahun');
            $dataInsert['predikat']      = $this->input->post('skp_predikat');
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->db->insert('db_pegawai.pegskp', $dataInsert);
        } else if($id_dok == 17){   
                 
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['jeniscuti']      = $this->input->post('cuti_jenis');
            $dataInsert['lamacuti']      = "0";
            $dataInsert['tglmulai']      = $this->input->post('cuti_tglmulai');
            $dataInsert['tglselesai']      = $this->input->post('cuti_tglselesai');
            $dataInsert['nosttpp']      = $this->input->post('cuti_nosurat');
            $dataInsert['tglsttpp']      = $this->input->post('cuti_tglsurat');
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            // dd($dataInsert);
            $result = $this->db->insert('db_pegawai.pegcuti', $dataInsert);
        } else if($id_dok == 2){   
                 
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['jenissk']         = $this->input->post('jenissk');
            $dataInsert['gambarsk']            = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            // dd($dataInsert);
            $result = $this->db->insert('db_pegawai.pegberkaspns', $dataInsert);
        }
      

        return $result;
    }

    function  updateFile($data)
    {
        $this->db->where('raw_name', $data['raw_name']);
        $this->db->set('flag_update', 1);
        $this->db->set('update_by', $this->general_library->getId());
        $this->db->set('update_date', 'NOW()', FALSE);
        return $this->db->update('db_siladen.dokumen_upload');
    }

    function _getIdDokumen($data)
    {
        $r = NULL;
        $find    = $data['raw_name'];


        $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from db_siladen.dokumen) a
         WHERE a.result = 1 AND a.aktif IS NOT NULL ");

        // $query = $this->db->select('*')
        // ->from('db_siladen.dokumen a')
        // ->where('a.aktif is not null')
        // ->like('a.nama_dokumen', $find)
        // ->get()->num_rows();

        if ($query->num_rows() > 0) {
            $row     = $query->row();
            $r         = $row->id_dokumen;
        }

        return $r;
    }

    // function _getIdPeg()
    // {

    //         $username = $this->general_library->getUserName();
    //         $this->db->select('a.id')
    //             ->from('db_siladen.users as a')
    //             ->where('a.username', $username)
    //             ->where('a.active', 1)
    //             ->limit(1);
    //             $query = $this->db->get();
    //             foreach ($query->result() as $row)
    //                 {
    //                         $idPeg = $row->id;

    //                 }
    //             return $idPeg;

    // }


    // function getLastSKPDByIdPegawai()
    // {
    // 	$id_peg  = $this->session->userdata('id_peg');

    // 	$sql="SELECT skpd FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";

    // 	$query    = $this->db->query($sql);

    // 	if($query->num_rows() > 0)
    // 	{
    // 		$row    			= $query->row();
    // 		$skpd        		= $row->skpd;			
    // 	}
    // 	else
    // 	{
    // 		$skpd           = NULL;	
    // 	}		

    // 	return $skpd;
    // }

    function _extract_numbers($string)
    {
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }

    public function getAllWithOrder($tableName, $orderBy = 'created_date', $whatType = 'desc')
    {
        $this->db->select('*')
        // ->where('id !=', 0)
        // ->where('flag_active', 1)
        ->order_by($orderBy, $whatType)
        ->from($tableName);
        return $this->db->get()->result_array(); 
    }

    public function getOne($tableName, $fieldName, $fieldValue)
    {
        $this->db->select('*')
        ->from($tableName)
        ->where($fieldName, $fieldValue);
        return $this->db->get()->row_array();
    }

    public function doUpload()
	{

        $this->db->trans_begin();
        if($_FILES){         
        $id_dok = $this->input->post('id_dokumen');
        $nama_file =  $this->prosesName($id_dok);
        
       
		// cek file size apa diperbolehkan		
		$cekFile	= $this->isAllowSize($_FILES['file'], $id_dok);
		$response   = $cekFile['response'];
		if (!$response) {
                $res = array('msg' => $cekFile['pesan'], 'success' => false);
                return $res;
		}

        $target_dir = null;
        if($this->input->post('id_dokumen') == 4){
            $target_dir						= './arsipelektronik/';
        } else if($this->input->post('id_dokumen') == 7){
            $target_dir						= './arsipgjberkala/';
        } else if($this->input->post('id_dokumen') == 5){
            $target_dir						= './arsipskp/';
        } else if($this->input->post('id_dokumen') == 20){
            $target_dir						= './arsipdiklat/';
        } else if($this->input->post('id_dokumen') == 8){
            $target_dir						= './arsipjabatan/';
        } else if($this->input->post('id_dokumen') == 17){
            $target_dir						= './arsipcuti/';
        } else if($this->input->post('id_dokumen') == 6){
            $target_dir						= './arsippendidikan/';
        } else if($this->input->post('id_dokumen') == 2){
            $target_dir						= './arsipberkaspns/';
        }  

       

        // else {
        //     $target_dir						= './uploads/';
        // }

		
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = '*';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        $config['file_name']            = "$nama_file.pdf";


		$this->load->library('upload', $config);

		// if (!file_exists($target_dir)) {
		// 	mkdir($target_dir, 0777);
		// }

		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            return $res;

		} else {
			$dataFile 			= $this->upload->data();
            // dd($dataFile);
            // $base64 = $this->fileToBase64($dataFile['full_path']);
            
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            $res = $this->dokumenlib->setDokumenWs('POST',[
                'username' => $this->general_library->getUsername(),
                'password' => $this->general_library->getPassword(),
                'filename' => $path.$dataFile['file_name'],
                'docfile'  => $base64
            ]);
            // dd($res);
            

            $dataFile['nama_file'] =  "$nama_file.pdf";
            $dataFile['base64'] =  $base64;
			$result		        = $this->insertUpload($dataFile);
            
            // if($tableName == "db_pegawai.pegpangkat"){
            //     $path = './arsipelektronik/'.$file;
            // } else if($tableName == "db_pegawai.peggajiberkala"){
            //     $path = './arsipgjberkala/'.$file;
            // } else if($tableName == "db_pegawai.pegpendidikan"){
            //     $path = './arsippendidikan/'.$file;
            // } else if($tableName == "db_pegawai.pegjabatan"){
            //     $path = './arsipjabatan/'.$file;
            // } else if($tableName == "db_pegawai.pegdiklat"){
            //     $path = './arsipdiklat/'.$file;
            // } else if($tableName == "db_pegawai.pegorganisasi"){
            //     $path = null;
            // } else if($tableName == "db_pegawai.pegpenghargaan"){
            //     $path = null;
            // } else if($tableName == "db_pegawai.pegsumpah"){
            //     $path = null;
            // } else if($tableName == "db_pegawai.pegkeluarga"){
            //     $path = null;
            // } else if($tableName == "db_pegawai.pegdatalain"){
            //     $path = null;
            // } else if($tableName == "db_pegawai.pegcuti"){
            //     $path = './arsipcuti/'.$file;
            // } else if($tableName == "db_pegawai.pegskp"){
            //     $path = './arsipskp/'.$file;
            // } else if($tableName == "db_pegawai.pegassesment"){
            //     $path = './arsipassesment/'.$file;
            // } else if($tableName == "db_pegawai.pegarsip"){
            //     $path = './arsiplain/'.$file;
            // }

         
           
            if($target_dir != null){
                unlink($target_dir."$nama_file.pdf");
            }

            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
   
		}
        
    } else {
        $dataPost = $this->input->post();
        if($this->input->post('jenis_organisasi')){
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
            $dataPost['status']      = 2;
            $dataPost['tanggal_verif']      = date('Y-m-d H:i:s');
            $dataPost['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->insert('db_pegawai.pegorganisasi',$dataPost);
        } else if($this->input->post('nm_pegpenghargaan')){
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataPost['status']      = 2;
                $dataPost['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataPost['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->insert('db_pegawai.pegpenghargaan',$dataPost);
        } else if($this->input->post('hubkel')){
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
            $dataPost['status']      = 2;
            $dataPost['tanggal_verif']      = date('Y-m-d H:i:s');
            $dataPost['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->insert('db_pegawai.pegkeluarga',$dataPost);
            
        } else if($this->input->post('jenispenugasan')){
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataPost['status']      = 2;
                $dataPost['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataPost['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->insert('db_pegawai.pegdatalain',$dataPost);
        } else if($this->input->post('sumpahpeg')){
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataPost['status']      = 2;
                $dataPost['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataPost['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->insert('db_pegawai.pegsumpah',$dataPost);
        } 
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
      
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

    function fileToBase64($pathfile){
        if(file_exists($pathfile)){
            $type = pathinfo($pathfile, PATHINFO_EXTENSION);
            $data = file_get_contents($pathfile);
            // $base64 = 'data:image/jpeg;base64,' . base64_encode($data);
            $base64 = 'data:file/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        } 
        return null;
    }
    

    public function doUploadAssesment()
	{

        $this->db->trans_begin();
            
        $target_dir						= './arsipassesment/';
        
		
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;

		$this->load->library('upload', $config);

	
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            return $res;
		} else {
			$dataFile 			= $this->upload->data();

            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            $res = $this->dokumenlib->setDokumenWs('POST',[
                'username' => $this->general_library->getUsername(),
                'password' => $this->general_library->getPassword(),
                'filename' => $path.$dataFile['file_name'],
                'docfile'  => $base64
            ]);

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nm_assesment']      = $this->input->post('nm_assesment');
            $dataInsert['gambarsk']         = $dataFile['file_name'];
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegassesment', $dataInsert);

            if($target_dir != null){
                unlink($target_dir.$dataFile['file_name']);
            }

            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
   
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


    public function doUploadArsipLainnya()
	{

        $this->db->trans_begin();
            
        $target_dir						= './arsiplain/';
        		
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;

		$this->load->library('upload', $config);

		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            return $res;
	
		} else {
			$dataFile 			= $this->upload->data();
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            $res = $this->dokumenlib->setDokumenWs('POST',[
                'username' => $this->general_library->getUsername(),
                'password' => $this->general_library->getPassword(),
                'filename' => $path.$dataFile['file_name'],
                'docfile'  => $base64
            ]);

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['id_dokumen']      = $this->input->post('jenis_arsip');
            $dataInsert['gambarsk']         = $dataFile['file_name'];
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegarsip', $dataInsert);

            if($target_dir != null){
                unlink($target_dir.$dataFile['file_name']);
            }
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
   
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

    function _isAdaNIP($string)
	{
		$number = $this->_extract_numbers($string);
		$cek  = 0;
		foreach ($number as $value) {
			if (strlen($value) == 18) {
				$cek |= TRUE;
			} else {
				$cek |= FALSE;
			}
		}

		return boolval($cek);
	}

    function _isAdaNIPSaya($string)
	{


		$user_id  = $this->general_library->getUserName();

		$number = $this->_extract_numbers($string);
		$cek  = 0;
		foreach ($number as $value) {
			if ($value == $user_id) {
				$cek |= TRUE;
			} else {
				$cek |= FALSE;
			}
		}

		return boolval($cek);
	}

    function _getNip($string)
	{
		$number = $this->_extract_numbers($string);
		$r      = 0;
		foreach ($number as $value) {
			if (strlen($value) == 18) {
				$r  = $value;
			}
		}

		return $r;
	}

    function prosesName($id_dok)
    {
       
        $query = $this->db->select('*')
        ->from('db_siladen.dokumen a')
        ->where('a.id_dokumen', $id_dok)
        ->get()->row_array();
        
        $name = null;
        if($query){
            $format = $query['format'];
            $nip = $this->general_library->getUserName();
        if($id_dok == 4){
            $pangkat = $this->input->post('pangkat');
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("KODE",$pangkat,$name);
        } else if($id_dok == 7){
            $date = $this->input->post('tmt_gaji_berkala');
            $tahun = explode('-', $date);
            $tahun = $tahun[2];
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$tahun,$name);
        } else if($id_dok == 6){
            $tkt_pendidikan = $this->input->post('pendidikan_tingkat');
            if($tkt_pendidikan == "0000"){
                $kode = "05";
            } else if($tkt_pendidikan == "1000"){
                $kode = "10";
            } else if($tkt_pendidikan == "2000"){
                $kode = "15";
            } else if($tkt_pendidikan == "3000"){
                $kode = "20";
            } else if($tkt_pendidikan == "4000"){
                $kode = "25";
            } else if($tkt_pendidikan == "5000"){
                $kode = "30";
            } else if($tkt_pendidikan == "6000"){
                $kode = "35";
            } else if($tkt_pendidikan == "7000"){
                $kode = "40";
            } else if($tkt_pendidikan == "8000"){
                $kode = "45";
            } else if($tkt_pendidikan == "9000"){
                $kode = "50";
            } else {
                $kode = "99";
            }
            
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("KODE",$kode,$name);
        } else if($id_dok == 8){
            $date = $this->input->post('jabatan_tmt');
            $tahun = explode('-', $date);
            $tahun = $tahun[2];
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$tahun,$name);
        } else if($id_dok == 20){
            $name = str_replace("NIP",$nip,$format);
        } else if($id_dok == 5){
            $tahun = $this->input->post('skp_tahun');
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$tahun,$name);
        }  else if($id_dok == 17){
            $date = $this->input->post('cuti_tglmulai');
            $tahun = explode('-', $date);
            $tahun = $tahun[0];
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$this->input->post('cuti_tglmulai'),$name);
            
        }  else if($id_dok == 2){
            $jenissk = $this->input->post('jenissk');
            if($jenissk == 1){
                $name = "SK_CPNS_".$nip;
            } else if($jenissk){
                $name = "SK_PNS_".$nip;
            }
        } 

        

       }
    return $name;
    }


    public function getJenisLayanan()
    {
        $this->db->select('*')
        ->where('aktif', 'YA')
        ->from('db_siladen.jenis_layanan');
        return $this->db->get()->result_array(); 
    }

    public function insertUsulLayanan(){
     
        $this->db->trans_begin();
        $nip = $this->general_library->getUserName();
        $tanggal_usul = $this->input->post('tanggal_mulai');

        // dd($_FILES['surat_keterangan']);
    

        if($_FILES){
        if($this->input->post('jenis_layanan') == 3){
            $nama_file = "pengantar_$nip"."_$tanggal_usul";
            $target_dir						= '../siladen/dokumen_layanan/cuti/' . $this->general_library->getUserName();
        } else {
            $nama_file = "pengantar_$nip"."_$tanggal_usul";
            $target_dir						= '../siladen/dokumen_layanan/' . $this->general_library->getUserName();
        } 

        $config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        // $config['file_name']            = "$nama_file.pdf";

        if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777);
		}
        

		$this->load->library('upload', $config);
        $nama_file = [];
        $jumlah_berkas = count($_FILES['berkas']['name']);
        for($i = 0; $i < $jumlah_berkas;$i++)
		{
            if(!empty($_FILES['berkas']['name'][$i])){
 
				$_FILES['file']['name'] = $_FILES['berkas']['name'][$i];
                // $nama_file[] = $_FILES['berkas']['name'][$i];
                
				$_FILES['file']['type'] = $_FILES['berkas']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['berkas']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['berkas']['error'][$i];
				$_FILES['file']['size'] = $_FILES['berkas']['size'][$i];
	   
				if(!$this->upload->do_upload('file')){
                    $res = array('msg' => 'Data gagal disimpan', 'error' => $this->upload->display_errors(), 'success' => false);
                    return $res;
					// $uploadData = $this->upload->data();
					// $data['nama_berkas'] = $uploadData['file_name'];
					// $data['keterangan_berkas'] = $keterangan_berkas[$i];
					// $data['tipe_berkas'] = $uploadData['file_ext'];
					// $data['ukuran_berkas'] = $uploadData['file_size'];
					// $this->db->insert('tb_berkas',$data);
				} else {
                    $uploadData = $this->upload->data();
					$data['nama_berkas'] = $uploadData['file_name'];
                    $nama_file[] = $data['nama_berkas'];
					$data['tipe_berkas'] = $uploadData['file_ext'];
					$data['ukuran_berkas'] = $uploadData['file_size'];
                }
                
			}
          
           
		}
        

       
			$dataFile 			= $this->upload->data();
            $dataUsul['nomor_usul']     = $this->input->post('nomor_usul');
            $dataUsul['tanggal_usul']      = $this->input->post('tanggal_usul');
            $dataUsul['unit_organisasi']     =$this->general_library->getUnitKerjaPegawai();
            $dataUsul['jenis_layanan']      = $this->input->post('jenis_layanan');
            if($this->input->post('jenis_layanan') == 3){
            $dataUsul['file_pengantar']      = $nama_file[0];
            if(isset($nama_file[1])){
                $dataUsul['surat_keterangan']      = $nama_file[1];
            }
           
            } else  {
            $dataUsul['file_pengantar']      = $nama_file[0];
            }
           
            $dataUsul['usul_by']      = $this->general_library->getId();
            $this->db->insert('db_siladen.usul_layanan', $dataUsul);
            $id_usul =  $this->db->insert_id();
          
            if($this->input->post('jenis_layanan') == 3){
                // dd($nama_file[0]);
            $datacuti['id_usul']     = $id_usul;
            // $datacuti['nomor_usul']     = $this->input->post('nomor_usul');
            // $datacuti['tanggal_usul']      = $this->input->post('tanggal_usul');

            // $datacuti['lama_cuti']      = $this->input->post('lama_cuti');
            // $datacuti['tahun1']      = $this->input->post('tahun1');
            // $datacuti['tahun2']      = $this->input->post('tahun2');
            // $datacuti['tahun3']      = $this->input->post('tahun3');
            // $datacuti['jenis_lama_cuti']      = $this->input->post('jenis_lama_cuti');
            // $datacuti['tanggal_mulai']      = $this->input->post('tanggal_mulai');
            // $datacuti['tanggal_selesai']      = $this->input->post('tanggal_selesai');
            // $datacuti['jenis_cuti']      = $this->input->post('jenis_cuti');
            $datacuti['file_pengantar']      = $nama_file[0];
            if(isset($nama_file[1])){
                $datacuti['surat_keterangan']      = $nama_file[1];
            }
           
            $datacuti['id_user']      = $this->general_library->getId();
            $datacuti['created_by']      = $this->general_library->getId();
            $this->db->insert('db_siladen.t_cuti', $datacuti);
            } 
            // else {
            // $datacuti['id_usul']     = $id_usul;
            // $datacuti['file_pengantar']      = $nama_file[0];
            // $datacuti['id_user']      = $this->general_library->getId();
            // $datacuti['created_by']      = $this->general_library->getId();
            // $this->db->insert('db_siladen.t_perbaikan_data_pegawai', $datacuti);
            // }
        
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
           
		
        } else {
            $dataUsul['nomor_usul']     = $this->input->post('nomor_usul');
            $dataUsul['tanggal_usul']      = $this->input->post('tanggal_usul');
            $dataUsul['unit_organisasi']     =$this->general_library->getUnitKerjaPegawai();
            $dataUsul['jenis_layanan']      = $this->input->post('jenis_layanan');
            $dataUsul['file_pengantar']      = "";
            $dataUsul['usul_by']      = $this->general_library->getId();
            $this->db->insert('db_siladen.usul_layanan', $dataUsul);
            $id_usul =  $this->db->insert_id();
          
            if($this->input->post('jenis_layanan') == 12){
                $dataPerbaikan['id_usul']     = $id_usul;
                $dataPerbaikan['keterangan_perbaikan']      = $this->input->post('keterangan_perbaikan');
                $dataPerbaikan['created_by']      = $this->general_library->getId();
                $dataPerbaikan['id_user']      = $this->general_library->getId();
                $this->db->insert('db_siladen.t_perbaikan_data_pegawai', $dataPerbaikan);
            }
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true); 
        }

        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
        }
        else
        {
                $this->db->trans_commit();
        }
        return $res;

       
    }


    function getListUsulLayanan($id,$id_peg){

        if($id == 3){
            return $this->db->select('g.nm_cuti,c.status,c.jenis_layanan,c.id_usul,f.status_verif,c.usul_status,e.nama,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,c.file_pengantar')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
            ->join('db_siladen.t_cuti d', 'c.id_usul = d.id_usul')
            ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
            ->join('m_status_verif f', 'c.status = f.id')
            ->join('db_siladen.m_cuti g', 'g.id_cuti = d.jenis_cuti')
            ->where('c.jenis_layanan', $id)
            ->where('b.id_peg', $id_peg)
            ->where('c.flag_active', 1)
            ->order_by('c.id_usul','desc')
            ->get()->result_array();
        } else {
            return $this->db->select('c.status,c.jenis_layanan,c.id_usul,f.status_verif,c.usul_status,e.nama,c.tanggal_usul,c.file_pengantar')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
            // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
            ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
            ->join('db_efort.m_status_verif f', 'c.status = f.id')
            ->where('c.jenis_layanan', $id)
            ->where('b.id_peg', $id_peg)
            ->where('c.flag_active', 1)
            ->order_by('c.id_usul','desc')
            ->get()->result_array();
        }

    }


    function getAllUsulLayanan(){
        // return $this->db->select('f.nm_unitkerja,b.nama as nama_pegawai,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,c.file_pengantar,a.username as nip')
        return $this->db->select('f.nm_unitkerja,b.nama as nama_pegawai,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,c.file_pengantar,a.username as nip')

                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
                        // ->join('db_siladen.nominatif_usul d', 'c.id_usul = d.id_usul')
                        ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
                        ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
                        ->where('c.jenis_layanan', 3)
                        ->order_by('c.id_usul', 'desc')
                        ->get()->result_array();
    }

    // function getDataUsulLayanan($id_usul,$jenis_layanan){
    //     if($jenis_layanan == 3){
    //         return $this->db->select('j.nm_cuti,d.jenis_lama_cuti,d.jenis_cuti,d.nomor_surat,d.tanggal_surat,j.nm_cuti,b.gelar1,b.gelar2,c.status,b.id_peg,c.jenis_layanan,h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,c.file_pengantar,a.username as nip')
    //         ->from('m_user a')
    //         ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    //         ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
    //         ->join('db_siladen.nominatif_usul d', 'c.id_usul = d.id_usul')
    //         ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
    //         ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
    //         ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
    //         ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
    //         ->join('db_siladen.m_cuti j', 'd.jenis_cuti = j.id_cuti')
    //         ->where('c.id_usul', $id_usul)
    //         ->get()->result_array();
    //     }
    // }
        
    function getDataUsulLayanan($id_usul,$jenis_layanan){
        // if($jenis_layanan == 3){
        //     return $this->db->select('c.surat_keterangan,d.jenis_lama_cuti,d.jenis_cuti,d.nomor_surat,d.tanggal_surat,
        //     j.nm_cuti,b.gelar1,b.gelar2,c.status,b.id_peg,c.jenis_layanan, b.nik, i.nm_agama,
        //     h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama as nama_pegawai, b.tptlahir, b.tgllahir,
        //     c.id_usul,e.nama as nama_layanan,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,
        //     c.file_pengantar,a.username as nip, b.statuspeg, b.fotopeg, b.nipbaru_ws, b.tmtpangkat, b.tmtjabatan,
        //     a.id as id_m_user, b.jk, b.alamat')
        //     ->from('m_user a')
        //     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //     ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
        //     ->join('db_siladen.t_cuti d', 'c.id_usul = d.id_usul')
        //     ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
        //     ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
        //     ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
        //     ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
        //     ->join('db_siladen.m_cuti j', 'd.jenis_cuti = j.id_cuti')
        //     ->join('db_pegawai.agama i', 'b.agama = id_agama')
        //     ->where('c.id_usul', $id_usul)
        //     ->get()->result_array();
        // } else {
        //     return $this->db->select('c.surat_keterangan,
        //     b.gelar1,b.gelar2,c.status,b.id_peg,c.jenis_layanan, b.nik, i.nm_agama,
        //     h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama as nama_pegawai, b.tptlahir, b.tgllahir,
        //     c.id_usul,e.nama as nama_layanan,c.tanggal_usul,
        //     c.file_pengantar,a.username as nip, b.statuspeg, b.fotopeg, b.nipbaru_ws, b.tmtpangkat, b.tmtjabatan,
        //     a.id as id_m_user, b.jk, b.alamat, j.id_unitkerjamaster,j.nm_unitkerjamaster,c.tanggal_surat,c.nomor_surat')
        //     ->from('m_user a')
        //     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //     ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
        //     // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
        //     ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
        //     ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
        //     ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
        //     ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
        //     ->join('db_pegawai.agama i', 'b.agama = id_agama')
        //     ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
        //     ->where('c.id_usul', $id_usul)
        //     ->get()->result_array();
        // }

        return $this->db->select('c.surat_keterangan,
        b.gelar1,b.gelar2,c.status,b.id_peg,c.jenis_layanan, b.nik, i.nm_agama,
        h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama as nama_pegawai, b.tptlahir, b.tgllahir,
        c.id_usul,e.nama as nama_layanan,c.tanggal_usul,
        c.file_pengantar,a.username as nip, b.statuspeg, b.fotopeg, b.nipbaru_ws, b.tmtpangkat, b.tmtjabatan,
        a.id as id_m_user, b.jk, b.alamat, j.id_unitkerjamaster,j.nm_unitkerjamaster,c.tanggal_surat,c.nomor_surat')
        ->from('m_user a')
        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
        // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
        ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
        ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
        ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
        ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
        ->join('db_pegawai.agama i', 'b.agama = id_agama')
        ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
        ->where('c.id_usul', $id_usul)
        ->get()->result_array();

        
        
    }


    public function getFile()
    {      
        $id_peg = $this->input->post('id_peg');
        if($this->input->post('file') == "pangkat"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegpangkat as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tglsk', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "jabatan"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegjabatan as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tglsk', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "pendidikan"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegpendidikan as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tglijasah', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skcpns"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 1)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skpns"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 2)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "gajiberkala"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.peggajiberkala as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tmtgajiberkala', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skp"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegskp as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tahun', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "drp"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 42)
                // ->order_by('a.tahun', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "honor"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 33)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "suket_lain"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 16)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "ibel"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 13)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "forlap"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 12)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "diklat"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegdiklat as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tglsttpp', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "karya_tulis"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 43)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "tubel"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 14)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "mutasi"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 23)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "serkom"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 9)
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "pak"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->where('a.id_dokumen', 11)
                ->limit(1);
                return $this->db->get()->result_array();
        }  else {
         return [''];
        }
        
        
    }

    // function getAllUsulLayananAdmin($id){
    //     return $this->db->select('d.*,g.nm_cuti,d.nomor_surat,d.tanggal_surat,c.jenis_layanan,c.status,f.nm_unitkerja,b.nama,b.gelar1,b.gelar2,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,c.file_pengantar,a.username as nip')
    //                     ->from('m_user a')
    //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    //                     ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
    //                     ->join('db_siladen.t_cuti d', 'c.id_usul = d.id_usul')
    //                     ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
    //                     ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
    //                     ->join('db_siladen.m_cuti g', 'd.jenis_cuti = g.id_cuti')
    //                     ->where('c.jenis_layanan', 3)
    //                     ->where('c.status', $id)
    //                     ->order_by('c.id_usul', 'desc')
    //                     ->get()->result_array();
    // }

    function getAllUsulLayananAdmin($id){
        return $this->db->select('c.jenis_layanan,c.status,f.nm_unitkerja,b.nama,b.gelar1,b.gelar2,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,c.file_pengantar,a.username as nip')
                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
                        ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
                        ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
                        // ->where('c.jenis_layanan', 3)
                        ->where('c.status', $id)
                        ->where('c.flag_active', 1)
                        ->order_by('c.id_usul', 'desc')
                        ->get()->result_array();
    }

    public function submitVerifikasiLayanan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_usul = $datapost['id_usul'];
        $data["status"] = $datapost["status"];
        $this->db->where('id_usul', $id_usul)
                ->update('db_siladen.usul_layanan', $data);

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


    public function batalVerifikasiLayanan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_usul = $datapost['id_batal'];
        $data["status"] = 0;
        $this->db->where('id_usul', $id_usul)
                ->update('db_siladen.usul_layanan', $data);

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



    public function submitNomorTglSurat(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        $this->db->trans_begin();
        $id_usul = $datapost['id_usul'];
        $data["nomor_surat"] = $datapost["nomor_surat"];
        $data["tanggal_surat"] = $datapost["tanggal_surat"];

        if( $datapost['jenis_layanan'] == 3){
            $this->db->where('id_usul', $id_usul)
            ->update('db_siladen.t_cuti', $data);
        } else {
            $this->db->where('id_usul', $id_usul)
            ->update('db_siladen.usul_layanan', $data);
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

    public function getNomorTanggalSurat()
    {      
        $id = $this->input->post('id');
        $this->db->select('*')
            ->from('db_siladen.t_cuti as a')
            ->where('a.id_usul', $id)
            ->limit(1);
            return $this->db->get()->result_array();
    }


    function getDataJabatan($id_unitkerja, $searchTerm = "")
    {        
        $this->db->select('*');
        $this->db->where('id_unitkerja', $id_unitkerja);
        // $this->db->where("nama like '%" . $searchTerm . "%' ");    
        $this->db->order_by('id_unitkerja', 'asc');
        $fetched_records = $this->db->get('db_pegawai.jabatan');
        $datajab = $fetched_records->result_array();
 
        $data = array();
        foreach ($datajab as $jab) {
            $data[] = array("id" => $jab['id_jabatanpeg'], "text" => $jab['nama_jabatan']);
        }
        return $data;
    }

     
function getNamaJabatan(){
    $this->db->select('*')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 

}


public function delete($fieldName, $fieldValue, $tableName,$file)
{
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;
   
    $this->db->trans_begin();

    if($tableName == "db_pegawai.pegpangkat"){
        $path = './arsipelektronik/'.$file;
    } else if($tableName == "db_pegawai.peggajiberkala"){
        $path = './arsipgjberkala/'.$file;
    } else if($tableName == "db_pegawai.pegpendidikan"){
        $path = './arsippendidikan/'.$file;
    } else if($tableName == "db_pegawai.pegjabatan"){
        $path = './arsipjabatan/'.$file;
    } else if($tableName == "db_pegawai.pegdiklat"){
        $path = './arsipdiklat/'.$file;
    } else if($tableName == "db_pegawai.pegorganisasi"){
        $path = null;
    } else if($tableName == "db_pegawai.pegpenghargaan"){
        $path = null;
    } else if($tableName == "db_pegawai.pegsumpah"){
        $path = null;
    } else if($tableName == "db_pegawai.pegkeluarga"){
        $path = null;
    } else if($tableName == "db_pegawai.pegdatalain"){
        $path = null;
    } else if($tableName == "db_pegawai.pegcuti"){
        $path = './arsipcuti/'.$file;
    } else if($tableName == "db_pegawai.pegskp"){
        $path = './arsipskp/'.$file;
    } else if($tableName == "db_pegawai.pegassesment"){
        $path = './arsipassesment/'.$file;
    } else if($tableName == "db_pegawai.pegarsip"){
        $path = './arsiplain/'.$file;
    }

   
    $path = substr($path,2);

    $res = $this->dokumenlib->delDokumenWs('POST',[
        'username' => $this->general_library->getUsername(),
        'password' => $this->general_library->getPassword(),
        'filename' => $path
    ]);
    

    $this->db->where($fieldName, $fieldValue)
         ->update($tableName, ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);

    if($tableName == "db_pegawai.pegjabatan"){
        $getJabatan = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->where('a.id', $fieldValue)
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->get()->row_array();

        if(strtotime($tmt_jabatan) > strtotime($getJabatan['id_pegawai'])){
            $dataUpdate["skpd"] =  $id_skpd;
            $dataUpdate["tmtjabatan"] =  $tmt_jabatan;
            $dataUpdate["jabatan"] =   $id_jabatan;
            $dataUpdate["jenisjabpeg"] =  $this->input->post('jabatan_jenis');
            $this->db->where('id_peg', $id_peg)
                    ->update('db_pegawai.pegawai', $dataUpdate);
        } 
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

public function submitVerifikasiDokumen(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;
    $datapost = $this->input->post();
   
    $this->db->trans_begin();
    $id = $datapost['id'];
    $data["status"] = $datapost["verif"];
    $data["keterangan"] = $datapost["keterangan"];
    $data["tanggal_verif"] = date('Y-m-d h:i:s');
    $data["id_m_user_verif"] = $this->general_library->getId();
    
   
     if(trim($datapost["jenis_dokumen"]) == "jabatan"){
        $getJabatan = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->where('a.id_pegawai', $datapost["id_pegawai"])
        ->where('a.flag_active', 1)
        ->where('a.status', 2)
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->get()->row_array();

        $getJabatanPost = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->where('a.id', $datapost["id"])
        ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
        ->limit(1)
        ->get()->row_array();
      
        if(strtotime($getJabatanPost['tmtjabatan']) > strtotime($getJabatan['tmtjabatan'])){
            $dataUpdate["skpd"] =  $getJabatanPost['id_unitkerja'];
            $dataUpdate["tmtjabatan"] =  $getJabatanPost['tmtjabatan'];
            $dataUpdate["jabatan"] =   $getJabatanPost['id_jabatan'];
            $dataUpdate["jenisjabpeg"] =  $getJabatanPost['jenisjabatan'];
            $this->db->where('id_peg', $datapost["id_pegawai"])
                    ->update('db_pegawai.pegawai', $dataUpdate);
        } 
        }

    $this->db->where('id', $id)
        ->update('db_pegawai.'.$datapost['db_dokumen'], $data);


    // if(trim($datapost["jenis_dokumen"]) == "pangkat"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegpangkat', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "gajiberkala"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.peggajiberkala', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "jabatan"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegjabatan', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "diklat"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegdiklat', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "organisasi"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegorganisasi', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "penghargaan"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegpenghargaan', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "sumpahjanji"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegsumpah', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "keluarga"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegkeluarga', $data);
    // } else if(trim($datapost["jenis_dokumen"]) == "penugasan"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegpenugasan', $data);
    // }
   

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





public function batalSubmitVerifikasiDokumen(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;
    $datapost = $this->input->post();
   
    $this->db->trans_begin();
    $id = $datapost['id_batal'];
    $data["status"] = 1;
    $data["keterangan"] = "";
    // $data["tanggal_verif"] = date('Y-m-d h:i:s');
    // $data["id_m_user_verif"] = $this->general_library->getId();
    // dd($datapost);

    // if(trim($datapost["jenis_dokumen_batal"]) == "pangkat"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegpangkat', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "gajiberkala"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.peggajiberkala', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "jabatan"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegjabatan', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "diklat"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegdiklat', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "organisasi"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegorganisasi', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "penghargaan"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegpenghargaan', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "sumpahjanji"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegsumpah', $data);
    // } else if(trim($datapost["jenis_dokumen_batal"]) == "keluarga"){
    //     $this->db->where('id', $id)
    //     ->update('db_pegawai.pegkeluarga', $data);
    // }
 
   
    if(trim($datapost["jenis_dokumen_batal"]) == "jabatan"){
      

        $getJabatanPost = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->where('a.id', $datapost["id_batal"])
        ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
        ->limit(1)
        ->get()->row_array();

       
        $getJabatan = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
        ->where('a.id_pegawai', $datapost["id_pegawai_batal"])
        ->where('a.flag_active', 1)
        ->where('a.status', 2)
        ->where('a.tmtjabatan <', $getJabatanPost['tmtjabatan'])
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->get()->row_array();

            $dataUpdate["skpd"] =  $getJabatan['id_unitkerja'];
            $dataUpdate["tmtjabatan"] =  $getJabatan['tmtjabatan'];
            $dataUpdate["jabatan"] =   $getJabatan['id_jabatan'];
            $dataUpdate["jenisjabpeg"] =  $getJabatan['jenisjabatan'];
            $this->db->where('id_peg', $datapost["id_pegawai_batal"])
                    ->update('db_pegawai.pegawai', $dataUpdate);
        
    }

       
   
    $this->db->where('id', $id)
    ->update('db_pegawai.'.$datapost['db_dokumen_batal'], $data);

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

public function getDetailLayanan()
{      
    $id = $this->input->post('id_usul');
    if($this->input->post('layanan') == "Cuti"){
        $this->db->select('a.id_usul,c.jenis_layanan,a.nomor_surat,a.tanggal_surat')
        ->from('db_siladen.t_cuti as a')
        ->join('db_siladen.m_cuti b', 'b.id_cuti = a.jenis_cuti')
        ->join('db_siladen.usul_layanan c', 'c.id_usul = a.id_usul')
        ->where('a.id_usul', $id)
        ->limit(1);
        return $this->db->get()->result_array();
    } else if($this->input->post('layanan') == "Surat Keterangan Tidak Hukdis dan Pidana") {
        $this->db->select('*')
        ->from('db_siladen.usul_layanan as a')
        ->where('a.id_usul', $id)
        ->limit(1);
        return $this->db->get()->result_array();
    } 

}


public function getJenisArsip()
{
    $ignore = array(1,2,3,4,5,6,7,8,17,20,47);


    $this->db->select('*, CONCAT(nama_dokumen, '.' , " / ", keterangan) AS name')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->order_by('id_dokumen', 'asc')
    ->where_not_in('id_dokumen', $ignore)
    ->from('db_siladen.dokumen');
    return $this->db->get()->result_array(); 
}




public function submitEditProfil(){
    
    $datapost = $this->input->post();
    
    $this->db->trans_begin();
    $id_pegawai = $datapost['edit_id_pegawai'];
    $data["gelar1"] = $datapost["edit_gelar1"];
    $data["nama"] = $datapost["edit_nama"];
    $data["gelar2"] = $datapost["edit_gelar2"];
    $data["nipbaru"] = $datapost["edit_nip_baru"];
    $data["tptlahir"] = $datapost["edit_tptlahir"];
    $data["tgllahir"] = $datapost["edit_tgllahir"];
    $data["alamat"] = $datapost["edit_alamat"];
    $data["jk"] = $datapost["edit_jkelamin"];
    $data["goldarah"] = $datapost["edit_goldar"];
    $data["agama"] = $datapost["edit_agama"];
    $data["skpd"] = $datapost["edit_unit_kerja"];
    // $data["jabatan"] = $datapost["edit_gelar1"];
    // $data["tmtjabatan"] = $datapost["edit_gelar1"];
    $data["statusjabatan"] = $datapost["edit_status_jabatan"];
    $data["jenisjabpeg"] = $datapost["edit_jenis_jabatan"];
    $data["pangkat"] = $datapost["edit_pangkat"];
    $data["tmtpangkat"] = $datapost["edit_tmt_pangkat"];
    $data["tmtcpns"] = $datapost["edit_tmt_cpns"];
    $data["tmtgjberkala"] = $datapost["edit_tmt_gjberkala"];
    // $data["pendidikan"] = $datapost["edit_gelar1"];
    $data["statuspeg"] = $datapost["edit_status_pegawai"];
    $data["jenispeg"] = $datapost["edit_jenis_pegawai"];
    $data["nik"] = $datapost["edit_nik"];
    $data["taspen"] = $datapost["edit_taspen"];
    $data["handphone"] = $datapost["edit_no_hp"];
    $data["email"] = $datapost["edit_email"];

    // dd($data);
    $this->db->where('id_peg', $id_pegawai)
            ->update('db_pegawai.pegawai', $data);

    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);


    if($this->db->trans_status() == FALSE){
        $this->db->trans_rollback();
        // $res['code'] = 1;
        // $res['message'] = 'Terjadi Kesalahan';
        // $res['data'] = null;
        $res = array('msg' => 'Data gagal disimpan', 'success' => false);
    } else {
        $this->db->trans_commit();
    }

    return $res;
} 

public function copyfoto(){
    

                // $this->db->select('a.fotopeg')
                // ->from('db_pegawai.pegawai as a')
                // ->where('a.fotopeg is not null');
                // $query = $this->db->get();
                // foreach ($query->result() as $row)
                //     {
                        
                //             $des = './assets/bukti_kegiatan/tes/'.$row->fotopeg; 
                //             $from = 'http://simpegserver/adm/fotopeg/'.$row->fotopeg; 
                //             $files = copy($from, $des);

                //     }
       

		dd('selesai');
}

public function getDataKabanBkd()
{
    $this->db->select('*')
    ->from('db_pegawai.pegawai a')
    ->join('db_pegawai.pangkat f', 'a.pangkat = f.id_pangkat')
    ->join('db_pegawai.jabatan g', 'a.jabatan = g.id_jabatanpeg')
    ->where('a.jabatan', '4018000JS01');
    
    return $this->db->get()->result_array(); 
}

    


}
