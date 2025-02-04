<?php
class M_Kepegawaian extends CI_Model
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

    public function getDataSinkronWsSiasn($tableName, $id_m_user){
        return $this->db->select('*')
                    ->from($tableName)
                    ->where('id_m_user', $id_m_user)
                    ->get()->row_array();
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
                return $this->db->select('*, a.tmtpangkat as tmt_pangkat, a.id as id_dokumen, a.status as status_dokumen')
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
                return $this->db->select('*, a.skpd as unit_kerja, a.id as id_dokumen, a.tmtjabatan as tmt_jabatan, a.status as status_dokumen')
                                ->from('db_pegawai.pegjabatan a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.jabatan c','a.id_jabatan = c.id_jabatanpeg', 'left')
                                ->join('db_pegawai.eselon d','a.eselon = d.id_eselon')
                                ->join('db_pegawai.jenisjab e','a.jenisjabatan = e.id_jenisjab')
                                ->join('db_pegawai.statusjabatan f','a.statusjabatan = f.id_statusjabatan')
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
                return $this->db->select('a.*,b.*,c.*, d.nm_jabatan_organisasi, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegorganisasi a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.organisasi c','a.jenis_organisasi = c.id_organisasi')
                                ->join('db_pegawai.jabatan_organisasi d','a.id_jabatan_organisasi = d.id')

                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'penghargaan'){
                return $this->db->select('a.*,b.*, c.nm_pemberipenghargaan, a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.pegpenghargaan a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.pemberipenghargaan c', 'a.pemberi = c.id')
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
                                ->join('m_dokumen c', 'a.id_dokumen = c.id_dokumen')
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
            } else if($jd == 'timkerja'){
                return $this->db->select('a.*,b.*,c.nm_lingkup_timkerja,a.id as id_dokumen, a.status as status_dokumen, a.jabatan as jabatan_tim')
                                ->from('db_pegawai.pegtimkerja a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.lingkup_timkerja c', 'a.lingkup_timkerja = c.id')

                                ->where('a.id', $id)
                                ->get()->row_array();
            } else if($jd == 'inovasi'){
                return $this->db->select('a.*,b.*,c.kriteria_inovasi,a.id as id_dokumen, a.status as status_dokumen')
                                ->from('db_pegawai.peginovasi a')
                                ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                ->join('db_pegawai.inovasi c', 'a.kriteria_inovasi = c.id')

                                ->where('a.id', $id)
                                ->get()->row_array();
            }
            

            
            
            
        }

        public function searchDokumenUsul($data){
            // $tanggal = explodeRangeDate($data['tanggal']);
            // $tanggal_awal = explode("-", $tanggal[0]);
            // $taw = $tanggal_awal[0].'-'.$tanggal_awal[2].'-'.$tanggal_awal[1];

            // $tanggal_akhir = explode("-", $tanggal[1]);
            // $tak = $tanggal_akhir[0].'-'.$tanggal_akhir[2].'-'.$tanggal_akhir[1];

            $this->db->select('a.*, b.*, c.nm_unitkerja, a.id as id_dokumen')
                        ->from('db_pegawai.'.$data['jenisdokumen'].' a')
                        ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                        ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                        ->join('db_pegawai.jabatan d', 'b.jabatan = d.id_jabatanpeg','left')
                        ->where('a.flag_active', 1)
                        // ->where('a.created_date >=', $taw.' 00:00:00')
                        // ->where('a.created_date <=', $tak.' 23:59:59')
                        ->order_by('a.created_date', 'desc');

            if($data['status'] != '0'){
                $this->db->where('a.status', $data['status']);
            }

            if($data['unitkerja'] != '0'){
                if($data['unitkerja'] == '3010000'){
                $this->db->where_in('c.id_unitkerjamaster', ['8000000','8010000','8020000']);
                } else {
                $this->db->where('b.skpd', $data['unitkerja']);
                }
            }
            

            if($data['eselon'] != '0'){
                $this->db->where('d.eselon', $data['eselon']);
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
            $this->db->select('e.kelas_jabatan,e.eselon,a.*, g.nm_statusjabatan, b.nm_agama, c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja,
            h.nama_kabupaten_kota,i.nama_kecamatan,j.nama_kelurahan, k.id as id_m_user')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama','left')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan', 'left')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat','left')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja','left')
                ->join('db_pegawai.statusjabatan g', 'a.statusjabatan = g.id_statusjabatan','left')
                ->join('m_kabupaten_kota h', 'a.id_m_kabupaten_kota = h.id','left')
                ->join('m_kecamatan i', 'a.id_m_kecamatan = i.id','left')
                ->join('m_kelurahan j', 'a.id_m_kelurahan = j.id','left')
                ->join('m_user k', 'a.nipbaru_ws = k.username')
                ->where('a.nipbaru_ws', $username)
                ->where('k.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        public function changeFlagSertifikasi($status, $nip){
            $data['flag_sertifikasi'] = 0;
            $data['flag_terima_tpp'] = 1;
            if($status == "true"){
                $data['flag_sertifikasi'] = 1;
                $data['flag_terima_tpp'] = 0;
            }

            $this->db->where('nipbaru_ws', $nip)
                    ->update('db_pegawai.pegawai', $data);
        }

        function getProfilPegawai($nip = ''){
            $username = $this->general_library->getUserName();
            if($this->general_library->isProgrammer() 
            || $this->general_library->isAdminAplikasi()
            || $this->general_library->isManajemenTalenta()
            || $this->general_library->isHakAkses('akses_profil_pegawai')
            ||  isKasubKepegawaian($this->general_library->getNamaJabatan())){
                $username = $nip;
                if(!$username){
                    $username = $this->general_library->getUserName();
                }
            }
            $this->db->select('a.tmtpangkat,e.kelas_jabatan,e.jenis_jabatan,a.flag_terima_tpp,q.nama_status_pegawai,f.id_unitkerjamaster,l.id as id_m_user,l.id_m_sub_bidang,o.nama_bidang,p.nama_sub_bidang,n.nama_kelurahan,m.nama_kecamatan,c.id_tktpendidikan,d.id_pangkat,k.id_statusjabatan,j.id_jenisjab,id_jenispeg,h.id_statuspeg,
            g.id_sk,b.id_agama,e.eselon,j.nm_jenisjab,i.nm_jenispeg,h.nm_statuspeg,g.nm_sk,a.*, b.nm_agama, a.id_m_status_pegawai,
            c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja, l.id as id_m_user, k.nm_statusjabatan,
            (SELECT CONCAT(aa.nm_jabatan,"|",aa.tmtjabatan,"|",aa.statusjabatan) from db_pegawai.pegjabatan as aa where a.id_peg = aa.id_pegawai and aa.flag_active in (1,2) and aa.status = 2 and aa.statusjabatan not in (2,3) ORDER BY aa.tmtjabatan desc limit 1) as data_jabatan,
            (SELECT CONCAT(cc.nm_pangkat,"|",bb.tmtpangkat,"|",bb.status,"|",bb.pejabat,"|",bb.nosk,"|",bb.masakerjapangkat) from db_pegawai.pegpangkat as bb
            join db_pegawai.pangkat as cc on bb.pangkat = cc.id_pangkat where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2  ORDER BY bb.tmtpangkat desc limit 1) as data_pangkat,
             (SELECT jurusan from db_pegawai.pegpendidikan as dd where a.id_peg = dd.id_pegawai and dd.flag_active in (1,2) and dd.status = 2  ORDER BY dd.id desc limit 1) as jurusan,
            r.nama_kabupaten_kota,m.nama_kecamatan,n.nama_kelurahan, a.flag_sertifikasi, a.flag_terima_tpp')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama', 'left')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan', 'left')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat', 'left')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja', 'left')
                ->join('db_pegawai.statuskawin g', 'a.status = g.id_sk', 'left')
                ->join('db_pegawai.statuspeg h', 'a.statuspeg = h.id_statuspeg', 'left')
                ->join('db_pegawai.jenispeg i', 'a.jenispeg = i.id_jenispeg', 'left')
                ->join('db_pegawai.jenisjab j', 'a.jenisjabpeg = j.id_jenisjab', 'left')
                ->join('db_pegawai.statusjabatan k', 'a.statusjabatan = k.id_statusjabatan','left')
                ->join('m_user l', 'a.nipbaru_ws = l.username', 'left')
                ->join('m_kecamatan m', 'a.id_m_kecamatan = m.id','left')
                ->join('m_kelurahan n', 'a.id_m_kelurahan = n.id','left')
                ->join('m_bidang o', 'l.id_m_bidang = o.id','left')
                ->join('m_sub_bidang p', 'l.id_m_sub_bidang = p.id','left')
                ->join('m_status_pegawai q', 'a.id_m_status_pegawai = q.id','left')
                ->join('m_kabupaten_kota r', 'a.id_m_kabupaten_kota = r.id','left')
                ->where('a.nipbaru_ws', $username)
                ->where('l.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getProfilPegawaiForDrafSK($nip){
           
            $this->db->select('a.statuspeg,a.tmtpangkat,e.kelas_jabatan,e.jenis_jabatan,a.flag_terima_tpp,q.nama_status_pegawai,f.id_unitkerjamaster,l.id as id_m_user,l.id_m_sub_bidang,o.nama_bidang,p.nama_sub_bidang,n.nama_kelurahan,m.nama_kecamatan,c.id_tktpendidikan,d.id_pangkat,k.id_statusjabatan,j.id_jenisjab,id_jenispeg,h.id_statuspeg,
            g.id_sk,b.id_agama,e.eselon,j.nm_jenisjab,i.nm_jenispeg,h.nm_statuspeg,g.nm_sk,a.*, b.nm_agama, a.id_m_status_pegawai,
            c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja, l.id as id_m_user, k.nm_statusjabatan,
            (SELECT CONCAT(aa.nm_jabatan,"|",aa.tmtjabatan,"|",aa.statusjabatan) from db_pegawai.pegjabatan as aa where a.id_peg = aa.id_pegawai and aa.flag_active in (1,2) and aa.status = 2 and aa.statusjabatan not in (2,3) ORDER BY aa.tmtjabatan desc limit 1) as data_jabatan,
            (SELECT CONCAT(cc.nm_pangkat,"|",bb.tmtpangkat,"|",bb.status,"|",bb.pejabat,"|",bb.nosk,"|",bb.masakerjapangkat,"|",bb.tglsk) from db_pegawai.pegpangkat as bb
            join db_pegawai.pangkat as cc on bb.pangkat = cc.id_pangkat where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2  ORDER BY bb.tmtpangkat desc limit 1) as data_pangkat,
             (SELECT jurusan from db_pegawai.pegpendidikan as dd where a.id_peg = dd.id_pegawai and dd.flag_active in (1,2) and dd.status = 2  ORDER BY dd.id desc limit 1) as jurusan,
            r.nama_kabupaten_kota,m.nama_kecamatan,n.nama_kelurahan, a.flag_sertifikasi, a.flag_terima_tpp')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama', 'left')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan', 'left')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat', 'left')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja', 'left')
                ->join('db_pegawai.statuskawin g', 'a.status = g.id_sk', 'left')
                ->join('db_pegawai.statuspeg h', 'a.statuspeg = h.id_statuspeg', 'left')
                ->join('db_pegawai.jenispeg i', 'a.jenispeg = i.id_jenispeg', 'left')
                ->join('db_pegawai.jenisjab j', 'a.jenisjabpeg = j.id_jenisjab', 'left')
                ->join('db_pegawai.statusjabatan k', 'a.statusjabatan = k.id_statusjabatan','left')
                ->join('m_user l', 'a.nipbaru_ws = l.username', 'left')
                ->join('m_kecamatan m', 'a.id_m_kecamatan = m.id','left')
                ->join('m_kelurahan n', 'a.id_m_kelurahan = n.id','left')
                ->join('m_bidang o', 'l.id_m_bidang = o.id','left')
                ->join('m_sub_bidang p', 'l.id_m_sub_bidang = p.id','left')
                ->join('m_status_pegawai q', 'a.id_m_status_pegawai = q.id','left')
                ->join('m_kabupaten_kota r', 'a.id_m_kabupaten_kota = r.id','left')
                ->where('a.nipbaru_ws', $nip)
                ->where('l.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getProfilPegawaiForKasub($nip){
          
            $this->db->select('q.nama_status_pegawai,f.id_unitkerjamaster,l.id as id_m_user,l.id_m_sub_bidang,o.nama_bidang,p.nama_sub_bidang,n.nama_kelurahan,m.nama_kecamatan,c.id_tktpendidikan,d.id_pangkat,k.id_statusjabatan,j.id_jenisjab,id_jenispeg,h.id_statuspeg,
            g.id_sk,b.id_agama,e.eselon,j.nm_jenisjab,i.nm_jenispeg,h.nm_statuspeg,g.nm_sk,a.*, b.nm_agama, a.id_m_status_pegawai,
            c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja, l.id as id_m_user, k.nm_statusjabatan,
            (SELECT CONCAT(aa.nm_jabatan,"|",aa.tmtjabatan,"|",aa.statusjabatan) from db_pegawai.pegjabatan as aa where a.id_peg = aa.id_pegawai and aa.flag_active in (1,2) and aa.status = 2 and aa.statusjabatan not in (2,3) ORDER BY aa.tmtjabatan desc limit 1) as data_jabatan,
            (SELECT CONCAT(cc.nm_pangkat,"|",bb.tmtpangkat,"|",bb.status) from db_pegawai.pegpangkat as bb
            join db_pegawai.pangkat as cc on bb.pangkat = cc.id_pangkat where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2  ORDER BY bb.tmtpangkat desc limit 1) as data_pangkat')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama', 'left')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan', 'left')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat', 'left')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja', 'left')
                ->join('db_pegawai.statuskawin g', 'a.status = g.id_sk', 'left')
                ->join('db_pegawai.statuspeg h', 'a.statuspeg = h.id_statuspeg', 'left')
                ->join('db_pegawai.jenispeg i', 'a.jenispeg = i.id_jenispeg', 'left')
                ->join('db_pegawai.jenisjab j', 'a.jenisjabpeg = j.id_jenisjab', 'left')
                ->join('db_pegawai.statusjabatan k', 'a.statusjabatan = k.id_statusjabatan','left')
                ->join('m_user l', 'a.nipbaru_ws = l.username', 'left')
                ->join('m_kecamatan m', 'a.id_m_kecamatan = m.id','left')
                ->join('m_kelurahan n', 'a.id_m_kelurahan = n.id','left')
                ->join('m_bidang o', 'l.id_m_bidang = o.id','left')
                ->join('m_sub_bidang p', 'l.id_m_sub_bidang = p.id','left')
                ->join('m_status_pegawai q', 'a.id_m_status_pegawai = q.id','left')
                ->where('a.nipbaru_ws', $nip)
                ->where('l.flag_active', 1)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getPangkatPegawai($nip,$kode){
             $this->db->select('b.id_peg,c.keterangan,c.created_date,c.gambarsk,c.id,c.status,e.nm_jenispengangkatan, c.masakerjapangkat, d.nm_pangkat, c.tmtpangkat, c.pejabat,
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
             $this->db->select('c.ijazah_cpns,b.id_peg,e.nm_tktpendidikanb as nm_tktpendidikan,c.id,c.status,c.namasekolah,c.fakultas,c.pimpinansekolah,c.tahunlulus,c.noijasah,c.tglijasah,c.gambarsk,c.jurusan,c.keterangan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpendidikan c', 'b.id_peg = c.id_pegawai')
                            // ->join('db_pegawai.tktpendidikan d','c.tktpendidikan = d.id_tktpendidikan')
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
              $this->db->select('f.nm_unitkerja,b.id_peg,c.pejabat,c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan, c.id_siasn,
              c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk,c.keterangan, c.flag_from_siasn, c.meta_data_siasn')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                            // ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
                            ->join('db_pegawai.unitkerja f','c.id_unitkerja = f.id_unitkerja','left')
                            ->join('db_pegawai.eselon e','c.eselon = e.id_eselon','left')
                            ->where('a.username', $nip)
                            ->where('a.flag_active', 1)
                            ->where_in('c.flag_active', [1,2])
                            ->order_by('c.tmtjabatan','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }

                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getJabatanPlt($nip,$kode){
          
            $this->db->select('b.id_peg,c.pejabat,c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk')
                          ->from('m_user a')
                          ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                          ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                          // ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
                          ->join('db_pegawai.eselon e','c.eselon = e.id_eselon','left')
                          ->where('a.username', $nip)
                          ->where('a.flag_active', 1)
                          ->where('c.flag_active', 1)
                          ->group_start() //this will start grouping
                          ->where("FIND_IN_SET(c.ket,'Plt,Plh')!=",0)
                          ->or_where('c.statusjabatan in (2,3)')
                          ->group_end() //this will end grouping
                         
                          ->order_by('c.tmtjabatan','desc');
                          if($kode == 1){
                              $this->db->where('c.status', 2);
                          }

                          $query = $this->db->get()->result_array();
                          return $query;
      }


        function getDiklat($nip,$kode){
             $this->db->select('b.id_peg,e.jenjang_diklat,c.created_date,c.keterangan,c.id,c.status,d.nm_jdiklat,c.nm_diklat,c.tptdiklat,c.penyelenggara,c.angkatan,c.jam,c.tglmulai,c.tglselesai,c.tglsttpp,c.nosttpp,c.gambarsk,c.keterangan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegdiklat c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.diklat d','c.jenisdiklat = d.id_diklat')
                            ->join('db_pegawai.jenjang_diklat e','c.jenjang_diklat = e.id')
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

        function getDisiplin($nip,$kode){
            $this->db->select('c.tgl_mulaiberlaku,c.tgl_selesaiberlaku,c.tmt,c.id,d.nama,e.nama_jhd,c.jp,c.status,c.nosurat,c.tglsurat,c.gambarsk')
                           ->from('m_user a')
                           ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                           ->join('db_pegawai.pegdisiplin c', 'b.id_peg = c.id_pegawai')
                           ->join('db_pegawai.hd d','c.hd = d.idk')
                           ->join('db_pegawai.jhd e','c.jhd = e.id_jhd')
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
             $this->db->select('b.id_peg,c.created_date,c.id,c.status,c.masakerja,d.nm_pangkat,c.pejabat,c.nosk,c.tglsk,c.tmtgajiberkala,c.gambarsk,c.keterangan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.peggajiberkala c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.pangkat d', 'c.pangkat = d.id_pangkat')
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
                            ->where('a.flag_active', 1)
                            ->order_by('c.id','desc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getTimKerja($nip,$kode){
            $this->db->select('*, c.id as id_pegtimkerja')
                           ->from('m_user a')
                           ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                           ->join('db_pegawai.pegtimkerja c', 'b.id_peg = c.id_pegawai')
                           ->join('db_pegawai.lingkup_timkerja d', 'c.lingkup_timkerja = d.id')
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


       function getInovasi($nip,$kode){
        $this->db->select('*, c.id as id_peginovasi')
                       ->from('m_user a')
                       ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                       ->join('db_pegawai.peginovasi c', 'b.id_peg = c.id_pegawai')
                       ->join('db_pegawai.inovasi d', 'c.kriteria_inovasi = d.id')
                       ->where('a.username', $nip)
                       ->where('c.flag_active', 1)
                       ->where('a.flag_active', 1)
                       ->order_by('c.id','desc');
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
                            ->order_by('d.id_keluarga','asc');
                            if($kode == 1){
                                $this->db->where('c.status', 2);
                            }
                            $query = $this->db->get()->result_array();
                            return $query;
        }

        function getOrganisasi($nip,$kode){
            //  $this->db->select('b.*,c.*,b.*,d.*,e.nm_jabatan_organisasi')
             $this->db->select('*, c.id as id_pegorganisasi')

                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegorganisasi c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.organisasi d', 'c.jenis_organisasi = d.id_organisasi')
                            ->join('db_pegawai.jabatan_organisasi e', 'c.id_jabatan_organisasi = e.id')

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
             $this->db->select('a.*, b.*,c.*,d.nm_pemberipenghargaan,d.id as id_pemberi')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpenghargaan c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.pemberipenghargaan d', 'c.pemberi = d.id','left')
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
                            ->join('m_dokumen d', 'c.id_dokumen = d.id_dokumen', 'left')
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
        $this->updatePangkat($id_peg);
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
            $this->updateBerkala($id_peg);
        } else if($id_dok == 6){
            $tgl_ijazah = date("Y-m-d", strtotime($this->input->post('pendidikan_tanggal_ijazah')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['tktpendidikan']      = $this->input->post('pendidikan_tingkat');
            $dataInsert['jurusan']      = $this->input->post('pendidikan_jurusan');
            $dataInsert['fakultas']     =$this->input->post('pendidikan_fakultas');
            $dataInsert['namasekolah']      = $this->input->post('pendidikan_nama_sekolah_universitas');
            $dataInsert['pimpinansekolah']      = $this->input->post('pendidikan_nama_pimpinan');
            $dataInsert['tahunlulus']      = $this->input->post('pendidikan_tahun_lulus');
            $dataInsert['noijasah']      = $this->input->post('pendidikan_no_ijazah');
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

            if($this->input->post('myCheck')) {
                $id_jabatan = "";
                $nama_jabatan = $this->input->post('jabatan_lama');
            } else {
                $str = $this->input->post('jabatan_nama');
                $newStr = explode(";", $str);
                $id_jabatan = $newStr[0];
                $nama_jabatan = $newStr[1];
            }

            $skpd = $this->input->post('jabatan_unitkerja');
            $newSkpd = explode("/", $skpd);
            $id_skpd = $newSkpd[0];
            $nama_skpd = $newSkpd[1];

            $tgl_sk = date("Y-m-d", strtotime($this->input->post('jabatan_tanggal_sk')));
            $tmt_jabatan = date("Y-m-d", strtotime($this->input->post('jabatan_tmt')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['nm_jabatan']      = $nama_jabatan;
            $dataInsert['id_jabatan']      = $id_jabatan;
            $dataInsert['tmtjabatan']     =$tmt_jabatan;
            $dataInsert['jenisjabatan']      = $this->input->post('jabatan_jenis');
            $dataInsert['statusjabatan']      = $this->input->post('jabatan_status');
            $dataInsert['pejabat']      = $this->input->post('jabatan_pejabat');
            $dataInsert['eselon']      = $this->input->post('jabatan_eselon');
            $dataInsert['nosk']      = $this->input->post('jabatan_no_sk');
            $dataInsert['angkakredit']      = $this->input->post('jabatan_angka_kredit');
            $dataInsert['ket']      = $this->input->post('jabatan_keterangan');
            $dataInsert['id_unor_siasn']      = $this->input->post('id_unor_siasn');
            $dataInsert['tglsk']      = $tgl_sk;
            $dataInsert['skpd']      = $nama_skpd;
            $dataInsert['id_unitkerja']      = $id_skpd;
            $dataInsert['alamatskpd']      = "";
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }

            // if($dataInsert['statusjabatan'] == 1) { 
            // dd(1);
            // } else {
            // dd(2);
            // }
           
            $getJabatan = $this->db->select('*')
            ->from('db_pegawai.pegjabatan a')
            ->where('a.id_pegawai', $id_peg)
            ->where('a.flag_active', 1)
            ->order_by('tmtjabatan', 'desc')
            ->limit(1)
            ->get()->row_array();

            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
           
                if($dataInsert['statusjabatan'] == 1) { 
                if($getJabatan){
                    if(strtotime($tmt_jabatan) > strtotime($getJabatan['tmtjabatan'])){
                    
                        if($dataInsert['statusjabatan'] == '1'){
                            $dataUpdate["skpd"] =  $id_skpd;
                            // $dataUpdate['id_unitkerja']      = $id_skpd;
                            $dataUpdate["tmtjabatan"] =  $tmt_jabatan;
                            $dataUpdate["jabatan"] =   $id_jabatan;
                            $dataUpdate["jenisjabpeg"] =  $this->input->post('jabatan_jenis');
                            $this->db->where('id_peg', $id_peg)
                                    ->update('db_pegawai.pegawai', $dataUpdate);
                        }
                    
                    } 
                } else {
                
                    if($dataInsert['statusjabatan'] == '1'){
                    $dataUpdate["skpd"] =  $id_skpd;
                    // $dataUpdate['id_unitkerja']      = $id_skpd;
                    $dataUpdate["tmtjabatan"] =  $tmt_jabatan;
                    $dataUpdate["jabatan"] =   $id_jabatan;
                    $dataUpdate["jenisjabpeg"] =  $this->input->post('jabatan_jenis');
                    $this->db->where('id_peg', $id_peg)
                            ->update('db_pegawai.pegawai', $dataUpdate);
                    }
                }
                }
            }
            /// insert jabatan di sini
          $result = $this->db->insert('db_pegawai.pegjabatan', $dataInsert);
          $id_pegjabatan = $this->db->insert_id();
          if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
            $inputPost = $this->input->post();
            if(isset($inputPost['flag_upload_siasn'])){
                $this->syncSiasnJabatan($id_pegjabatan);
            }
          }

        } else if($id_dok == 20){            
            $tgl_sttpp = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_sttpp')));
            $tgl_mulai = date("Y-m-d", strtotime($this->input->post('diklat_tangal_mulai')));
            $tgl_selesai = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_selesai')));
            $jenjang_diklat = $this->input->post('diklat_jenjang');
            if($jenjang_diklat == null) {
                $jenjang_diklat = 0;
            }
           
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['jenisdiklat']      = $this->input->post('diklat_jenis');
            $dataInsert['jenjang_diklat']      = $jenjang_diklat;
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
                   
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['tahun']      = $this->input->post('skp_tahun');
            $dataInsert['predikat']      = $this->input->post('skp_predikat');
            $dataInsert['nilai']      = $this->input->post('skp_nilai');
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
        } else if($id_dok == 41){   
                 
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['sumpahpeg']         = $this->input->post('sumpahpeg');
            $dataInsert['pejabat']         = $this->input->post('pejabat');
            $dataInsert['noba']         = $this->input->post('noba');
            $dataInsert['tglba']         = $this->input->post('tglba');
            $dataInsert['gambarsk']            = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            // dd($dataInsert);
            $result = $this->db->insert('db_pegawai.pegsumpah', $dataInsert);
        } else if($id_dok == 18){

            $getJhd = $this->db->select('*')
            ->from('db_pegawai.jhd a')
            ->where('a.id_jhd',$this->input->post('disiplin_jhd'))
            ->limit(1)
            ->get()->row_array();
            

            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['hd']         = $this->input->post('disiplin_hd');
            $dataInsert['jhd']         = $this->input->post('disiplin_jhd');
            $dataInsert['jp']         = $this->input->post('disiplin_jp');
            $dataInsert['tgl_mulaiberlaku']         = $this->input->post('disiplin_tglmulai');
            $dataInsert['tgl_selesaiberlaku']         = $this->input->post('disiplin_tglselesai');
            $dataInsert['nosurat']         = $this->input->post('disiplin_nosurat');
            $dataInsert['tglsurat']         = $this->input->post('disiplin_tglsurat');
            $dataInsert['tmt']         = $this->input->post('disiplin_tmt');
            $dataInsert['gambarsk']            = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['besar_potongan']      =$getJhd['besar_potongan'];
            $dataInsert['lama_potongan']      = $getJhd['lama_potongan'];
            // if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            // }
            // dd($dataInsert);
            $result = $this->db->insert('db_pegawai.pegdisiplin', $dataInsert);
        } else if($this->input->post('jenis_organisasi')){ 
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['id_pegorganisasi']      = $this->input->post('id_pegorganisasi');
            $dataInsert['jenis_organisasi']      = $this->input->post('jenis_organisasi');
            $dataInsert['nama_organisasi']      = $this->input->post('nama_organisasi');
            $dataInsert['id_jabatan_organisasi']      = $this->input->post('id_jabatan_organisasi');
            $dataInsert['tglmulai']      = $this->input->post('tglmulai');
            $dataInsert['tglselesai']      = $this->input->post('tglselesai');
            $dataInsert['pemimpin']      = $this->input->post('pemimpin');
            $dataInsert['tempat']      = $this->input->post('tempat');
            $dataInsert['gambarsk']            = $data['nama_file'];
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
                $result = $this->insert('db_pegawai.pegorganisasi',$dataInsert);
        } else if($this->input->post('pegpenghargaan')){
            $pegpenghargaan = $this->input->post('pegpenghargaan');

            if($pegpenghargaan == 4) {
            $dataInsert['nm_pegpenghargaan'] = $this->input->post('nm_pegpenghargaan');
            } else if($pegpenghargaan == 1) {
            $dataInsert['nm_pegpenghargaan'] = "Satyalencana Karya Satya 10 tahun";
            }  else if($pegpenghargaan == 2) {
            $dataInsert['nm_pegpenghargaan'] = "Satyalencana Karya Satya 20 tahun";
            } else if($pegpenghargaan == 3) {
            $dataInsert['nm_pegpenghargaan'] = "Satyalencana Karya Satya 30 tahun";
            }
            
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['id_m_satyalencana']      = $this->input->post('pegpenghargaan');
          
            $dataInsert['nosk']      = $this->input->post('nosk');
            $dataInsert['tglsk']      = $this->input->post('tglsk');
            $dataInsert['tahun_penghargaan']      = $this->input->post('tahun_penghargaan');
            $dataInsert['pemberi']      = $this->input->post('pemberi');
            $dataInsert['gambarsk']            = $data['nama_file'];
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
                $result = $this->insert('db_pegawai.pegpenghargaan',$dataInsert);
        } else if($this->input->post('jenispenugasan')){
            
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['jenispenugasan']      = $this->input->post('jenispenugasan');
            $dataInsert['tujuan']      = $this->input->post('tujuan');
            $dataInsert['pejabat']      = $this->input->post('pejabat');
            $dataInsert['nosk']      = $this->input->post('nosk');
            $dataInsert['tglsk']      = $this->input->post('tglsk');
            $dataInsert['lamanya']            = $this->input->post('lamanya');
            $dataInsert['gambarsk']            = $data['nama_file'];
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
                $result = $this->insert('db_pegawai.pegdatalain',$dataInsert);
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

    public function getDataDok($tableName, $id_peg)
    {
        $this->db->select('count(id) as total')
        ->where('id_pegawai',$id_peg)
        ->where_in('flag_active', [1,2])
        ->where_in('status', [1,2])
        ->from($tableName);
        return $this->db->get()->row_array(); 
    }


    public function getDataPdmBerkas($tableName, $orderBy = 'created_date', $whatType = 'desc', $jberkas)
    {
        $this->db->select('*')
        // ->where('id !=', 0)
        // ->where('flag_active', 1)
        ->where('id_m_user', $this->general_library->getId())
        ->where('jenis_berkas', $jberkas)
        ->order_by($orderBy, $whatType)
        ->limit(1)
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
        $create_nama_file =  $this->prosesName($id_dok);
       
		// cek file size apa diperbolehkan		
		// $cekFile	= $this->isAllowSize($_FILES['file'], $id_dok);
		// $response   = $cekFile['response'];
		// if (!$response) {
        //         $res = array('msg' => $cekFile['pesan'], 'success' => false);
        //         return $res;
		// }

       

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
        } else if($this->input->post('id_dokumen') == 41){
            $target_dir						= './arsipsumpah/';
        } else if($this->input->post('id_dokumen') == 18){
            $target_dir						= './arsipdisiplin/';
        } else if($this->input->post('jenis_organisasi')){
            $target_dir						= './arsiporganisasi/';
        } else if($this->input->post('pegpenghargaan')){
            $target_dir						= './arsippenghargaan/';
        } else if($this->input->post('jenispenugasan')){
            $target_dir						= './arsippenugasan/';
        }     

        // dd($this->input->post());

        // else {
        //     $target_dir						= './uploads/';
        // }

		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $filename = str_replace(' ', '', $random_number.$create_nama_file);
        $nama_file =  $filename;

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
			// $data['token']    = $this->security->get_csrf_hash();
            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'eror' => $data['error']);
            return $res;

		} else {
			$dataFile 			= $this->upload->data();
            // dd($dataFile);
            // $base64 = $this->fileToBase64($dataFile['full_path']);

            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);

            // if($this->input->post('id_dokumen') != 18) {
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$dataFile['file_name'],
            //     'docfile'  => $base64
            // ]);
            // }

            

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

        
            // if($target_dir != null){
            //     unlink($target_dir."$nama_file.pdf");
            // }

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
            
        // $target_dir						= './arsipassesment/';
        
		
		// $config['upload_path']          = $target_dir;
		// $config['allowed_types']        = 'pdf';
		// $config['encrypt_name']			= FALSE;
		// $config['overwrite']			= TRUE;
		// $config['detect_mime']			= TRUE;

		// $this->load->library('upload', $config);

	
		// // coba upload file		
		// if (!$this->upload->do_upload('file')) {

		// 	$data['error']    = strip_tags($this->upload->display_errors());
		// 	$data['token']    = $this->security->get_csrf_hash();
        //     $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        //     return $res;
		// } else {
		// 	$dataFile 			= $this->upload->data();

        //     $file_tmp = $_FILES['file']['tmp_name'];
        //     $data_file = file_get_contents($file_tmp);
        //     $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
        //     $path = substr($target_dir,2);
        //     $res = $this->dokumenlib->setDokumenWs('POST',[
        //         'username' => $this->general_library->getUsername(),
        //         'password' => $this->general_library->getPassword(),
        //         'filename' => $path.$dataFile['file_name'],
        //         'docfile'  => $base64
        //     ]);

        //     $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
        //     $dataInsert['nm_assesment']      = $this->input->post('nm_assesment');
        //     $dataInsert['gambarsk']         = $dataFile['file_name'];
        //     $dataInsert['created_by']      = $this->general_library->getId();
        //     $dataInsert['updated_by']      = $this->general_library->getId();
        //     if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
        //         $dataInsert['status']      = 2;
        //         $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
        //         $dataInsert['id_m_user_verif']      = $this->general_library->getId();
        //         }
        //     $result = $this->db->insert('db_pegawai.pegassesment', $dataInsert);

        //     if($target_dir != null){
        //         unlink($target_dir.$dataFile['file_name']);
        //     }

        //     $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
   
		// }

            $tahun = explode('-', $this->input->post('assesment_tglmulai'));
            $tahun = $tahun[0];

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nilai_assesment']      = $this->input->post('nilai_assesment');
            $dataInsert['tahun']      = $tahun;
            $dataInsert['tgl_mulaiberlaku']      = $this->input->post('assesment_tglmulai');
            $dataInsert['tgl_selesaiberlaku']      = $this->input->post('assesment_tglselesai');
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegassesment', $dataInsert);
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


    public function doUploadTk()
	{

        $this->db->trans_begin();
            
        $target_dir						= './arsiptimkerja/';
        
        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $filename = str_replace(' ', '', $random_number.$_FILES['file']['name']);

		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
      
	    
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' =>$data['error']);
            return $res;
		} else {
			$dataFile 			= $this->upload->data();
           
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nm_timkerja']      = $this->input->post('nm_timkerja');
            $dataInsert['jabatan']      = $this->input->post('jabatan');
            $dataInsert['lingkup_timkerja']      = $this->input->post('lingkup_timkerja');
            $dataInsert['gambarsk']         = $filename;
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegtimkerja', $dataInsert);

            // if($target_dir != null){
            //     unlink($target_dir.$dataFile['file_name']);
            // }

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

    public function doUploadKeluarga()
	{

        $this->db->trans_begin();
            

        if($_FILES['file']['name'] != ""){
            $target_dir						= './arsipkeluarga/';
        
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = str_replace(' ', '', $random_number.$_FILES['file']['name']);
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE;
            $config['file_name']            = "$filename";
    
            $this->load->library('upload', $config);
          
            // coba upload file		
            if (!$this->upload->do_upload('file')) {
    
                $data['error']    = strip_tags($this->upload->display_errors());
                $data['token']    = $this->security->get_csrf_hash();
                $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' =>$data['error']);
                return $res;
            } else {
                $dataFile 			= $this->upload->data();
               
                $file_tmp = $_FILES['file']['tmp_name'];
                $data_file = file_get_contents($file_tmp);
                $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
                $path = substr($target_dir,2);
               
    
                $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
                $dataInsert['hubkel']      = $this->input->post('hubkel');
                $dataInsert['namakel']      = $this->input->post('namakel');
                $dataInsert['tptlahir']      = $this->input->post('tptlahir');
                $dataInsert['tgllahir']      = $this->input->post('tgllahir');
                $dataInsert['pendidikan']      = $this->input->post('pendidikan');
                $dataInsert['pekerjaan']      = $this->input->post('pekerjaan');
    
                 if($this->input->post('hubkel') == 20 || $this->input->post('hubkel') || 30){
                    $dataInsert['pasangan_ke']      = $this->input->post('pasangan_ke');
                    $dataInsert['tglnikah']      = $this->input->post('tglnikah');
                    $dataInsert['gambarsk']         = $filename;
                 }
    
                 if($this->input->post('hubkel') == 40){
                    $dataInsert['statusanak']      = $this->input->post('statusanak');
                    $dataInsert['nama_ortu_anak']      = $this->input->post('nama_ortu_anak');
                    $dataInsert['gambarsk']         = $filename;
                 }
                
    
                $dataInsert['created_by']      = $this->general_library->getId();
                $dataInsert['updated_by']      = $this->general_library->getId();
                
                if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                    $dataInsert['status']      = 2;
                    $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                    $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                    }
                $result = $this->db->insert('db_pegawai.pegkeluarga', $dataInsert);
    
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
       
            }
        } else {
            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['hubkel']      = $this->input->post('hubkel');
            $dataInsert['namakel']      = $this->input->post('namakel');
            $dataInsert['tptlahir']      = $this->input->post('tptlahir');
            $dataInsert['tgllahir']      = $this->input->post('tgllahir');
            $dataInsert['pendidikan']      = $this->input->post('pendidikan');
            $dataInsert['pekerjaan']      = $this->input->post('pekerjaan');
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
            $result = $this->db->insert('db_pegawai.pegkeluarga', $dataInsert);

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

    public function doUploadInovasi()
	{

        $this->db->trans_begin();
            
        $target_dir						= './arsipinovasi/';
        
        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $filename = str_replace(' ', '', $random_number.$_FILES['file']['name']);
		
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        $config['file_name']            = "$filename";
        

       
		$this->load->library('upload', $config);
      
	
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' =>$data['error']);
            return $res;
		} else {
			$dataFile 			= $this->upload->data();
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);

            

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nm_inovasi']      = $this->input->post('nm_inovasi');
            $dataInsert['kriteria_inovasi']      = $this->input->post('kriteria_inovasi');
            $dataInsert['gambarsk']         = $filename;
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.peginovasi', $dataInsert);

            // if($target_dir != null){
            //     unlink($target_dir.$dataFile['file_name']);
            // }

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

    public function doUploadSk()
	{

      
        $this->db->trans_begin();
            
        $target_dir						= './arsipsosialkultural/';
        
		
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
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' =>$data['error']);
            return $res;
		} else {
			$dataFile 			= $this->upload->data();

            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $this->general_library->getId().$random_number.$dataFile['file_name'];
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);

           

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nm_timkerja']      = $this->input->post('nm_timkerja');
            $dataInsert['jabatan']      = $this->input->post('jabatan');
            $dataInsert['lingkup_timkerja']      = $this->input->post('lingkup_timkerja');
            $dataInsert['gambarsk']         = $filename;
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegtimkerja', $dataInsert);

            // if($target_dir != null){
            //     unlink($target_dir.$dataFile['file_name']);
            // }

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
        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $nama_dok =  str_replace(' ', '', $_FILES['file']['name']);
        $filename = $this->general_library->getId().$random_number.$nama_dok;
        $target_dir						= './arsiplain/';
        		
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = '*';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        $config['file_name']            = $filename;
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
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path. $filename,
            //     'docfile'  => $base64
            // ]);

            

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['id_dokumen']      = $this->input->post('jenis_arsip');
            $dataInsert['gambarsk']         = $filename;
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['updated_by']      = $this->general_library->getId();
            $dataInsert['status']      = 2;
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
                }
            $result = $this->db->insert('db_pegawai.pegarsip', $dataInsert);

            // if($target_dir != null){
            //     unlink($target_dir.$dataFile['file_name']);
            // }
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
            if($this->input->post('tmt_gaji_berkala')){
                $date = $this->input->post('tmt_gaji_berkala');
                $tahun = explode('-', $date);
                $tahun = $tahun[2];
            } else {
                $tahun = date('Y');
            }
          
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
        }  else if($id_dok == 41){
                $name = "SUMJAN_".$nip;
        } else if($id_dok == 49){
                $name = "PENGHARGAAN_".$nip;
        } else if($id_dok == 18){
            $name = "HD_".$nip;
        } 
       } else {
        $name = $_FILES['file']['name'];
       }
    return $name;
    }


    public function getJenisLayanan()
    {
        $this->db->select('*')
        ->where('flag_active', 1)
        ->from('m_layanan');
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
            $target_dir						= './dokumen_layanan/cuti/' . $this->general_library->getUserName();
            // $target_dir						= './siladen/dokumen_layanan/cuti/' . $this->general_library->getUserName();
        } else {
            $nama_file = "pengantar_$nip"."_$tanggal_usul";
            $target_dir						= './dokumen_layanan/' . $this->general_library->getUserName();
            // $target_dir						= '../siladen/dokumen_layanan/' . $this->general_library->getUserName();
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


    function getListUsulLayanan($id_peg){

        // if($id == 3){
        //     return $this->db->select('g.nm_cuti,c.status,c.jenis_layanan,c.id_usul,f.status_verif,c.usul_status,e.nama,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,c.file_pengantar')
        //     ->from('m_user a')
        //     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        //     ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
        //     ->join('db_siladen.t_cuti d', 'c.id_usul = d.id_usul')
        //     ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
        //     ->join('m_status_verif f', 'c.status = f.id')
        //     ->join('db_siladen.m_cuti g', 'g.id_cuti = d.jenis_cuti')
        //     // ->where('c.jenis_layanan', $id)
        //     ->where('b.id_peg', $id_peg)
        //     ->where('c.flag_active', 1)
        //     ->order_by('c.id_usul','desc')
        //     ->get()->result_array();
        // } else {
            return $this->db->select('c.status,c.jenis_layanan,c.id_usul,f.status_verif,c.usul_status,e.nama,c.tanggal_usul,c.file_pengantar')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
            // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
            ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
            ->join('db_efort.m_status_verif f', 'c.status = f.id')
            // ->where('c.jenis_layanan', $id)
            ->where('b.id_peg', $id_peg)
            ->where('c.flag_active', 1)
            ->order_by('c.id_usul','desc')
            ->get()->result_array();
        // }

    }


    function getAllUsulLayananOld(){
        // return $this->db->select('f.nm_unitkerja,b.nama as nama_pegawai,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,d.lama_cuti,d.tanggal_mulai,d.tanggal_selesai,c.file_pengantar,a.username as nip')
        return $this->db->select('*')

                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
                        // ->join('db_siladen.nominatif_usul d', 'c.id_usul = d.id_usul')
                        // ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
                        ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
                        ->where('c.jenis_layanan', 3)
                        ->order_by('c.id_usul', 'desc')
                        ->get()->result_array();
    }

    function getAllUsulLayanan(){
        return $this->db->select('f.nm_unitkerja,b.nama as nama_pegawai,c.*')
                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('t_layanan c', 'a.id = c.id_m_user')
                        ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
                        ->order_by('c.id', 'desc')
                        ->get()->result_array();
    }

    
        
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

        // return $this->db->select('*,c.id as id_usul')
        // ->from('m_user a')
        // ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
        // ->join('t_layanan c', 'a.id = c.id_m_user')
        // ->join('m_layanan d', 'c.id_m_layanan = d.id')
        // ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
        // ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
        // ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
        // ->join('db_pegawai.agama i', 'b.agama = id_agama')
        // ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
        // ->where('c.id', $id_usul)
        // ->get()->result_array();

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
    //     $this->db->select('c.jenis_layanan,c.status,f.nm_unitkerja,b.nama,b.gelar1,b.gelar2,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,c.file_pengantar,a.username as nip')
    //                     ->from('m_user a')
    //                     ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    //                     ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
    //                     ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
    //                     ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
    //                     // ->where('c.jenis_layanan', 3)
    //                     ->where('c.status', $id)
    //                     ->where('c.flag_active', 1)
    //                     ->order_by('c.id_usul', 'desc');

    //     // if(!$this->general_library->isProgrammer() && !$this->general_library->isAdminAplikasi()){
    //     //     $this->db->where_in('e.kode', $this->general_library->listHakAkses());
    //     // }

    //     return $this->db->get()->result_array();
    // }

    function getAllUsulLayananAdmin($id){
            $this->db->select('c.*,f.nm_unitkerja,b.nama,b.gelar1,b.gelar2,e.nama_layanan, c.created_date as tanggal_usul')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->join('t_layanan c', 'a.id = c.id_m_user')
            ->join('m_layanan e', 'c.id_m_layanan = e.id')
            ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
            ->where('c.status', $id)
            ->where('c.flag_active', 1)
            ->order_by('c.id', 'desc');
    

        if($this->general_library->isHakAkses('manajemen_talenta')){
            $this->db ->where('c.id_m_layanan', 6);
        } else {
            $this->db ->where('c.id_m_layanan', 99);
        }

        return $this->db->get()->result_array();
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
    ->where_not_in('id_jabatanpeg', ['0000005J001','0000005J002'])
    ->where('flag_active', 1)
    ->group_by('a.nama_jabatan')
    ->from('db_pegawai.jabatan a');
    return $this->db->get()->result_array(); 
}

function getJenisJabatan(){
    $this->db->select('*')
    ->where_in('id_jenisjab', ['00','10'])
    // ->where('flag_active', 1)
    ->from('db_pegawai.jenisjab a');
    return $this->db->get()->result_array(); 
}

function getTingkatPendidikan(){
    $this->db->select('*')
    ->where_not_in('id_tktpendidikanb', [2004,2005,2027])
    // ->where('flag_active', 1)
    ->from('db_pegawai.tktpendidikanb a');
    return $this->db->get()->result_array(); 
}

function getNamaJabatanEdit(){
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
    } else if($tableName == "db_pegawai.pegtimkerja"){
        $path = './arsiptimkerja/'.$file;
    }

   
    // $path = substr($path,2);

    // $res = $this->dokumenlib->delDokumenWs('POST',[
    //     'username' => $this->general_library->getUsername(),
    //     'password' => $this->general_library->getPassword(),
    //     'filename' => $path
    // ]);
    

    $this->db->where($fieldName, $fieldValue)
         ->update($tableName, ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);


    if($tableName == "db_pegawai.pegpangkat"){
        $getPangkat = $this->db->select('*')
        ->from('db_pegawai.pegpangkat a')
        ->where('a.id', $fieldValue)
        ->order_by('tmtpangkat', 'desc')
        ->limit(1)
        ->get()->row_array();
 
        $id_peg = $getPangkat['id_pegawai'];
        $this->updatePangkat($id_peg);
    }

    if($tableName == "db_pegawai.pegjabatan"){
        $getJabatan = $this->db->select('*')
        ->from('db_pegawai.pegjabatan a')
        ->where('a.id', $fieldValue)
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->get()->row_array();

        if($getJabatan['id_siasn']){
            $delete = $this->siasnlib->deleteJabatanByIdRiwayat($getJabatan['id_siasn']);
        }

        // dd($getJabatan['statusjabatan']);

        if($getJabatan['statusjabatan'] == 1){
            $id_peg = $getJabatan['id_pegawai'];
            $this->updateJabatan($id_peg);
    //     $getJabatanOld = $this->db->select('*')
    //     ->from('db_pegawai.pegjabatan a')
    //     ->where('a.id_pegawai', $getJabatan['id_pegawai'])
    //     ->where_in('a.flag_active', [1,2])
    //     ->where_not_in('a.statusjabatan', [2,3])
    //     ->order_by('tmtjabatan', 'desc')
    //     ->limit(1)
    //     ->get()->row_array();

      
    //    if($getJabatanOld){
    //     if($getJabatanOld['id_unitkerja'] != null){
    //         $dataUpdate["skpd"] =  $getJabatanOld['id_unitkerja'];
    //     }
    //     $dataUpdate["tmtjabatan"] =  $getJabatanOld['tmtjabatan'];
    //     $dataUpdate["jabatan"] =   $getJabatanOld['id_jabatan'];
    //     $dataUpdate["jenisjabpeg"] =  $getJabatanOld['jenisjabatan'];
    //     $this->db->where('a.id_peg', $getJabatan['id_pegawai'])
    //             ->update('db_pegawai.pegawai as a', $dataUpdate);
    //    } else {
    //     $dataUpdate2["tmtjabatan"] =  "";
    //     $dataUpdate2["jabatan"] =   0;
    //     $dataUpdate2["jenisjabpeg"] =  0;
    //     $this->db->where('a.id_peg', $getJabatan['id_pegawai'])
    //             ->update('db_pegawai.pegawai as a', $dataUpdate2);
    //    }
    }
           
    }

    if($tableName == "db_pegawai.peggajiberkala"){
        $getBerkala = $this->db->select('*')
        ->from('db_pegawai.peggajiberkala a')
        ->where('a.id', $fieldValue)
        ->limit(1)
        ->get()->row_array();
        $id_peg = $getBerkala['id_pegawai'];
        $this->updateBerkala($id_peg);
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
    $id_peg = $datapost["id_pegawai"];
    $data["status"] = $datapost["verif"];
    $data["keterangan"] = $datapost["keterangan"];
    $data["tanggal_verif"] = date('Y-m-d h:i:s');
    $data["id_m_user_verif"] = $this->general_library->getId();

    // if($this->general_library->isProgrammer()){
    //     // dd(base_url($datapost['file_path']));
    //     $base64 = convertToBase64(($datapost['file_path']));
    //     $bulan = date('m');
        
    //     if(!file_exists('assets/bukti_kegiatan/'.date('Y')) && !is_dir('assets/bukti_kegiatan/'.date('Y'))) {
    //         mkdir('assets/bukti_kegiatan/'.date('Y'), 0777);       
    //     }

    //     if(!file_exists('assets/bukti_kegiatan/'.date('Y').'/'.$bulan) && !is_dir('assets/bukti_kegiatan/'.date('Y').'/'.$bulan)) {
    //         mkdir('assets/bukti_kegiatan/'.date('Y').'/'.$bulan, 0777);       
    //     }

    //     $file_name = 'VERIF_PDM_'.$this->general_library->getUserName().'_'.date('Ymdhis').'.jpg';
    //     $urlFile = 'assets/bukti_kegiatan/'.date('Y').'/'.$bulan.'/'.$file_name;
    //     $img = imagegrabscreen();
    //     imagepng($im, $urlFile);
    //     base64ToFile($base64, $urlFile);

    //     $peg = $this->db->select('b.id as id_m_user, a.*')
    //                     ->from('db_pegawai.pegawai a')
    //                     ->join('m_user b', 'a.nipbaru_ws = b.username')
    //                     ->where('b.flag_active', 1)
    //                     ->where('a.id_peg', $datapost['id_pegawai'])
    //                     ->get()->row_array();
    //     if($peg){
    //         $list_tugas_jabatan = [
    //             'Melakukan Verifikasi Data PDM di Siladen',
    //             'Melakukan Verifikasi Data PDM',
    //             'Memverifikasi Data PDM di Siladen',
    //             'Memverifikasi Data PDM',
    //         ];
    //         $exists = $this->db->select('*')
    //                         ->from('t_rencana_kinerja')
    //                         ->where('bulan', floatval(date('m')))
    //                         ->where('tahun', floatval(date('Y')))
    //                         ->where_in('tugas_jabatan', $list_tugas_jabatan)
    //                         ->where('flag_active', 1)
    //                         ->where('id_m_user', $this->general_library->getId())
    //                         ->order_by('created_date', 'desc')
    //                         ->get()->row_array();
    //         $realisasi = null;
    //         if($exists){
    //             $realisasi = [
    //                 'id_t_rencana_kinerja' => $exists['id'],
    //                 'tanggal_kegiatan' => date('Y-m-d H:i:s'),
    //                 'deskripsi_kegiatan' => 'Melakukan Verifikasi Data PDM '.strtoupper($datapost['jenis_dokumen']).' untuk pegawai atas nama '.getNamaPegawaiFull($peg),
    //                 'bukti_kegiatan' => json_encode([$file_name]),
    //                 'realisasi_target_kuantitas' => 1,
    //                 'satuan' => 'Data',
    //                 'target_kualitas' => 100,
    //                 'id_m_user' => $this->general_library->getId(),
    //                 'status_verif' => 1,
    //                 'tanggal_verif' => date('Y-m-d H:i:s'),
    //                 'created_by' => $this->general_library->getId(),
    //             ];
    //         } else {
    //             $this->db->insert('t_rencana_kinerja', [
    //                 'id_m_user' => $this->general_library->getId(),
    //                 'tugas_jabatan' => 'Melakukan Verifikasi Data PDM di Siladen',
    //                 'tahun' => date('Y'),
    //                 'bulan' => floatval($bulan),
    //                 'satuan' => 'Data',
    //                 'sasaran_kerja' => 'Terverifikasinya Data PDM di Siladen',
    //                 'target_kualitas' => 100,
    //                 'target_kuantitas' => 1,
    //                 'created_by' => $this->general_library->getId()
    //             ]);
    //             $insertId = $this->db->insert_id();

    //             $realisasi = [
    //                 'id_t_rencana_kinerja' => $insertId,
    //                 'tanggal_kegiatan' => date('Y-m-d H:i:s'),
    //                 'deskripsi_kegiatan' => 'Melakukan Verifikasi Data PDM '.strtoupper($datapost['jenis_dokumen']).' untuk pegawai atas nama '.getNamaPegawaiFull($peg),
    //                 'bukti_kegiatan' => json_encode([$file_name]),
    //                 'realisasi_target_kuantitas' => 1,
    //                 'satuan' => 'Data',
    //                 'target_kualitas' => 100,
    //                 'id_m_user' => $this->general_library->getId(),
    //                 'status_verif' => 1,
    //                 'tanggal_verif' => date('Y-m-d H:i:s'),
    //                 'created_by' => $this->general_library->getId(),
    //             ];
    //         }

    //         if($realisasi){
    //             $this->db->insert('t_kegiatan', $realisasi);
    //         }
    //     }
    // }
    
    if(trim($datapost["jenis_dokumen"]) == "jabatan"){
    $data["tmtjabatan"] = $datapost["edit_tmt_jabatan_verif"];
    // $data["id_jabatan"] = $datapost["edit_nama_jabatan_verif"];
    $str = $datapost["edit_nama_jabatan_verif"];
    if($str){
        $newStr = explode(",", $str);
        $id_jabatan = $newStr[0];
        $nama_jabatan = $newStr[1];
        $data['id_jabatan']      = $id_jabatan; 
        $data['nm_jabatan']      = $nama_jabatan; 
    }
    }
    if(trim($datapost["jenis_dokumen"]) == "skp"){
        $data["predikat"] = $datapost["edit_predikat"];
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

    if(trim($datapost["jenis_dokumen"]) == "pangkat"){
        $this->updatePangkat($id_peg);
    }

    if(trim($datapost["jenis_dokumen"]) == "gajiberkala"){
        $this->updateBerkala($id_peg);
    }


    $eselonPeg = $this->general_library->getEselonPegawai($id_peg);           
    if($eselonPeg['eselon'] == "III A" || $eselonPeg['eselon'] == "III B"){
    $id = 1; 
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
    } else if($eselonPeg['eselon'] == "II A" || $eselonPeg['eselon'] == "II B") {
    $id = 2;
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
    } else {
    $id = 3;
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,1,$id);
    }


    return $res;
}


public function batalSubmitVerifikasiDokumen(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;
    $datapost = $this->input->post();
   
   
    $id = $datapost['id_batal'];
    $id_peg = $datapost["id_pegawai_batal"];
    $data["status"] = 1;
    $data["keterangan"] = "";
    $this->db->trans_begin();
    
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

    if(trim($datapost["jenis_dokumen_batal"]) == "jabatan"){
        $this->updateJabatan($id_peg);
    }

    if(trim($datapost["jenis_dokumen_batal"]) == "pangkat"){
        $this->updatePangkat($id_peg);
    }

    if(trim($datapost["jenis_dokumen_batal"]) == "gajiberkala"){
        $this->updateBerkala($id_peg);
    }


    $eselonPeg = $this->general_library->getEselonPegawai($id_peg);           
    if($eselonPeg['eselon'] == "III A" || $eselonPeg['eselon'] == "III B"){
    $id = 1;
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
    } else if($eselonPeg['eselon'] == "II A" || $eselonPeg['eselon'] == "II B") {
    $id = 2;
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
    } else {
    $id = 3;
    $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
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
    $ignore = array(1,2,3,4,5,6,7,8,9,17,20,23,41,47,48,49);


    $this->db->select('*, CONCAT(nama_dokumen, '.' , " / ", keterangan) AS name')
    // ->where('id !=', 0)
    // ->where('flag_active', 1)
    ->order_by('id_dokumen', 'asc')
    ->where_not_in('id_dokumen', $ignore)
    ->from('m_dokumen');
    return $this->db->get()->result_array(); 
}

public function updateTmBerkala()
{
  


    // // $this->db->select('a.id_peg,a.tmtgjberkala,
    // // (SELECT bb.tmtgajiberkala from db_pegawai.peggajiberkala as bb
    // //   where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2 ORDER BY bb.tmtgajiberkala desc limit 1) as tmt_peggajiberkala')
    // $this->db->select('a.id_peg,a.tmtgjberkala')
    // ->from('db_pegawai.pegawaix as a')
    // ->join('db_pegawa.peggajiberkala b', 'b.id_pegawai = a.id_peg')
    // ->where('a.id_m_status_pegawai', 1)
    // ->order_by('b.tmtgajiberkala', 'desc')
    // ->where('a.skpd', '5006004')
    // ->where('a.statuspeg', 2)
    // ->group_by('a.id_peg');
    // $result = $this->db->get()->result_array(); 

        $this->db->select('a.id_pegawai,
                            b.tmtgjberkala as kgbprofil,
	                        max(a.tmtgajiberkala) as kgbpeg')
    ->from('db_pegawai.peggajiberkala as a')
    ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
    // ->where('a.status', 2)
    ->where('a.flag_active', 1)
    // ->where('b.nip_baruws', '196809121995031005')
    ->order_by('a.id', 'desc')
    ->group_by('a.id_pegawai');
    $result = $this->db->get()->result_array(); 
    foreach($result as $res){
        if($res['kgbpeg'] > $res['kgbprofil']){
            $data["tmtgjberkala"] = $res['kgbpeg'];
            $this->db->where('id_peg', $res['id_pegawai'])
            ->update('db_pegawai.pegawai', $data);
        }
    }
    

}

public function updateJenisKelamin()
{
  
        $this->db->select('*')
    ->from('db_pegawai.pegawai as a')
    ->where('a.id_m_status_pegawai',1)
    ->where('a.jk is null');
    $result = $this->db->get()->result_array(); 
   
    foreach($result as $res){

        // dd($res['nipbaru_ws']);
        // dd(substr($res['nipbaru_ws'],14,1));
        // dd(substr("199503222020122021",14,1));

        if(substr($res['nipbaru_ws'],14,1) == 1){
            $data["jk"] = "Laki-Laki";
        } else {
            $data["jk"] = "Perempuan";
        }


           
            $this->db->where('id_peg', $res['id_peg'])
            ->update('db_pegawai.pegawai', $data);
    }
    

}




public function submitEditProfil(){
    
    $datapost = $this->input->post();
    
    $this->db->trans_begin();

    if(isset($datapost["edit_goldar"])){
        $goldar = $datapost["edit_goldar"];
    } else {
        $goldar = null;
    } 

    $id_pegawai = $datapost['edit_id_pegawai'];
    $data["gelar1"] = $datapost["edit_gelar1"];
    $data["nama"] = $datapost["edit_nama"];
    $data["gelar2"] = $datapost["edit_gelar2"];
    $data["nipbaru"] = $datapost["edit_nip_baru"];
    $data["tptlahir"] = $datapost["edit_tptlahir"];
    $data["tgllahir"] = $datapost["edit_tgllahir"];
    $data["alamat"] = $datapost["edit_alamat"];
    $data["jk"] = $datapost["edit_jkelamin"];
    $data["goldarah"] = $goldar;
    $data["agama"] = $datapost["edit_agama"];
    $data["skpd"] = $datapost["edit_unit_kerja"];
    $data["pendidikan"] = $datapost["edit_pendidikan"];
    // $data["tmtjabatan"] = $datapost["edit_gelar1"];
    $data["statusjabatan"] = $datapost["edit_status_jabatan"];
    $data["jenisjabpeg"] = $datapost["edit_jenis_jabatan"];
    $data["pangkat"] = $datapost["edit_pangkat"];
    // $data["tmtpangkat"] = $datapost["edit_tmt_pangkat"];
    $data["tmtcpns"] = $datapost["edit_tmt_cpns"];
    // $data["tmtgjberkala"] = $datapost["edit_tmt_gjberkala"];
    $data["status"] = $datapost["edit_status_kawin"];
    $data["statuspeg"] = $datapost["edit_status_pegawai"];
    $data["jenispeg"] = $datapost["edit_jenis_pegawai"];
    $data["nik"] = $datapost["edit_nik"];
    $data["taspen"] = $datapost["edit_taspen"];
    $data["karpeg"] = $datapost["edit_karpeg"];
    $data["handphone"] = $datapost["edit_no_hp"];
    $data["email"] = $datapost["edit_email"];
    if(isset($datapost["edit_flag_terima_tpp"])){
        $data["flag_terima_tpp"] = $datapost["edit_flag_terima_tpp"];
    }

    $data["id_m_provinsi"] = 71;
    if(isset($datapost['edit_kab_kota'])){
    $data["id_m_kabupaten_kota"] = $datapost["edit_kab_kota"];
    $data["id_m_kecamatan"] = $datapost["edit_kecamatan"];
    $data["id_m_kelurahan"] = $datapost["edit_kelurahan"];
    }

    if(isset($datapost["edit_id_m_status_pegawai"])){
        $data["id_m_status_pegawai"] = $datapost["edit_id_m_status_pegawai"];
    }
    $idUser = $datapost["edit_id_m_user"];
    $dataUser["id_m_bidang"] = $datapost["edit_id_m_bidang"];
    $dataUser["id_m_sub_bidang"] = $datapost["edit_id_m_sub_bidang"];

    // dd($data);
    $this->db->where('id_peg', $id_pegawai)
            ->update('db_pegawai.pegawai', $data);

    $this->db->where('id', $idUser)
            ->update('m_user', $dataUser);

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
    return $this->db->get()->row_array(); 
}

public function getDataCutiPegawai($id)
{
    $this->db->select('*,a.alamat as alamat_cuti')
    ->from('db_efort.t_pengajuan_cuti a')
    ->join('db_efort.m_user b', 'a.id_m_user = b.id')
    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
    ->join('db_pegawai.jabatan d', 'c.jabatan = d.id_jabatanpeg')
    ->join('db_pegawai.unitkerja e', 'c.skpd = e.id_unitkerja')
    ->where('b.flag_active', 1)
    ->where('a.id', $id);
    return $this->db->get()->row_array(); 
}


public function getDataKepalaOpd($unitkerja)
{
    $this->db->select('*')
    ->from('db_pegawai.pegjabatan a')
    ->where('a.nm_jabatan', 'Kepala '.$unitkerja)
    ->order_by('a.tmtjabatan', 'desc');
    return $this->db->get()->row_array(); 
  
}

public function updateStatusBerkas(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;

    $this->db->trans_begin();

    $datapost = $this->input->post();
    $id_m_user = $this->general_library->getId();
    $data["jenis_berkas"] = $datapost["jenis_berkas"];


     $query = $this->db->select('*')
        ->from('t_pdm a')
        ->where('a.id_m_user', $id_m_user)
        ->where('a.flag_active', 1)
        ->where('a.jenis_berkas', $datapost["jenis_berkas"])
        ->get()->row_array();

    
        if($query) {
            $this->db->where('id_m_user', $id_m_user)
            ->where('jenis_berkas', $datapost["jenis_berkas"])
            ->update('t_pdm', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
            $res = array('msg' => 'Berhasil Update Status', 'success' => true);
        } else {  
    
            $dataInsert['id_m_user']      = $this->general_library->getId();
            $dataInsert['created_by']      = $this->general_library->getId();
            $dataInsert['jenis_berkas']      = $datapost["jenis_berkas"];
            $this->db->insert('t_pdm', $dataInsert);

            $res = array('msg' => 'Berhasil Update Status', 'success' => true);
            
 
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

public function updateProfilePicture($data){ 
   
                $getFP = $this->db->select('fotopeg')
                ->from('db_pegawai.pegawai a')
                ->where('a.nipbaru_ws', $data['nip'])
                ->limit(1)
                ->get()->result_array();
                
                $path = './assets/fotopeg/';
                unlink($path.$getFP[0]['fotopeg']);



                $this->db->where('nipbaru_ws', $data['nip'])
                ->update('db_pegawai.pegawai', ['fotopeg' => $data['data']['file_name']]);


 

                return ['message' => '0'];
}


public function updateJabatanPeg(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;

    $this->db->trans_begin();

    $datapost = $this->input->post();
    // dd([$datapost['edit_jabatan_nama']]);
    $this->db->where('id', $datapost['edit_jabatan_id'])
            ->update('db_pegawai.pegjabatan', ['nm_jabatan' => $datapost['edit_jabatan_nama'], 
                                                'tmtjabatan' => $datapost['edit_jabatan_tmt'], 
                                                'skpd' => $datapost['edit_jabatan_skpd'], 
                                                 'updated_by' => $this->general_library->getId()]);
            $res = array('msg' => 'Berhasil Update Status', 'success' => true);
      
        
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



public function tambahPegawai(){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;

    $this->db->trans_begin();
    
    $datapost = $this->input->post();
    $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );

    $datapost['id_peg'] = "PEG00".$random_number;
    $datapost['nipbaru_ws'] = $datapost['nipbaru'];
    $this->db->insert('db_pegawai.pegawai', $datapost);
    $res = array('msg' => 'Berhasil Tambah Data Pegawai', 'success' => true, 'nip' =>  $datapost['nipbaru_ws']);

    $nip = $datapost['nipbaru_ws'];

    $exist = $this->db->select('*')
                            ->from('m_user')
                            ->where('username', $nip)
                            ->where('flag_active', 1)
                            ->get()->row_array();
            $pegawai = $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->where('nipbaru_ws', $nip)
                            ->get()->row_array();

            if($exist){
                $rs['code'] = 1;
                $rs['message'] = 'User sudah terdaftar';
                // $this->db->where('nipbaru_ws', $nip)
                //         ->update('db_pegawai.pegawai', ['flag_user_created' => 1]);
            } else if(!$pegawai){
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $user['username'] = $pegawai['nipbaru_ws'];
                $user['nama'] = getNamaPegawaiFull($pegawai);
                $nip_baru = explode(" ", $pegawai['nipbaru']);
                $password = $nip_baru[0];
                $pass_split = str_split($password);
                $new_password = $pass_split[6].$pass_split[7].$pass_split[4].$pass_split[5].$pass_split[0].$pass_split[1].$pass_split[2].$pass_split[3];
                $user['password'] = $this->general_library->encrypt($user['username'], $new_password);
                $this->db->insert('m_user', $user);
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


function getJenjangDiklat($id)
{        
    $this->db->select('*');
    $this->db->where('id_jenisdiklat', $id);
    $this->db->order_by('id', 'asc');
    $fetched_records = $this->db->get('db_pegawai.jenjang_diklat');
    $datajd = $fetched_records->result_array();

    $data = array();
    foreach ($datajd as $jd) {
        $data[] = array("id" => $jd['id'], "jenjang_diklat" => $jd['jenjang_diklat']);
    }
    return $data;
}

function getJenisHd($id)
{        
    $this->db->select('*');
    $this->db->where('id_hd', $id);
    // $this->db->order_by('id', 'asc');
    $fetched_records = $this->db->get('db_pegawai.jhd');
    $datajd = $fetched_records->result_array();

    $data = array();
    foreach ($datajd as $jd) {
        $data[] = array("id" => $jd['id_jhd'], "nama_jhd" => $jd['nama_jhd']);
    }
    return $data;
}


public function getKabKota($tableName, $orderBy = 'created_date', $whatType = 'desc')
{
    $this->db->select('*')
    // ->where('id !=', 0)
    ->where('id_m_provinsi', 71)
    ->order_by($orderBy, $whatType)
    ->from($tableName);
    return $this->db->get()->result_array(); 
}


function getkec($id_kab)
{        
    $this->db->select('id, nama_kecamatan');
    $this->db->where('id_m_kabupaten_kota', $id_kab);
    $this->db->order_by('id', 'asc');
    $fetched_records = $this->db->get('m_kecamatan');
    $datakec = $fetched_records->result_array();

    $data = array();
    foreach ($datakec as $kec) {
        $data[] = array("id" => $kec['id'], "nama_kecamatan" => $kec['nama_kecamatan']);
    }
    return $data;
}



function getdatajab()
{        
    $id = $this->input->post('id');
    $skpd = $this->input->post('skpd');
    $newSkpd = explode("/", $skpd);
    $id_skpd = $newSkpd[0];
    $nama_skpd = $newSkpd[1];
    $jnsfung = $this->input->post('jnsfung');

    if($id == "00"){
        $this->db->select('id_jabatanpeg, nama_jabatan');
        $this->db->where('jenis_jabatan', "Struktural");
        $this->db->where('id_unitkerja', $id_skpd);
        $this->db->where('flag_active', 1);
        $fetched_records = $this->db->get('db_pegawai.jabatan');
        $datajab = $fetched_records->result_array();
    } else if($id == "40"){
        $this->db->select('id_jabatanpeg, nama_jabatan');
        $this->db->where('jenis_jabatan', "Lainnya");
        $this->db->where('id_unitkerja', $id_skpd);
        $this->db->where('flag_active', 1);
        $fetched_records = $this->db->get('db_pegawai.jabatan');
        $datajab = $fetched_records->result_array();
    } else {
        if($jnsfung == "1"){
            $this->db->select('id_jabatanpeg, nama_jabatan');
            $this->db->where('flag_active', 1);
            $this->db->where('jenis_jabatan', "JFT");
            $this->db ->where_not_in('nama_jabatan', ['Pelaksana']);
            $this->db->group_by('nama_jabatan');
            $fetched_records = $this->db->get('db_pegawai.jabatan');
            $datajab = $fetched_records->result_array();
        } else {
            $this->db->select('id_jabatanpeg, nama_jabatan');
            $this->db->where('jenis_jabatan', "JFU");
            $this->db->where('id_unitkerja', $id_skpd);
            $this->db->where('flag_active', 1);
            $fetched_records = $this->db->get('db_pegawai.jabatan');
            $datajab = $fetched_records->result_array();
        }
       
    }
    

    $data = array();
    foreach ($datajab as $jab) {
        $data[] = array("id" => $jab['id_jabatanpeg'], "nama_jabatan" => $jab['nama_jabatan']);
    }
    return $data;
}



function getkel($id_kec)
{        
    $this->db->select('id, nama_kelurahan');
    $this->db->where('id_m_kecamatan', $id_kec);
    $this->db->order_by('id', 'asc');
    $fetched_records = $this->db->get('m_kelurahan');
    $datakec = $fetched_records->result_array();

    $data = array();
    foreach ($datakec as $kec) {
        $data[] = array("id" => $kec['id'], "nama_kelurahan" => $kec['nama_kelurahan']);
    }
    return $data;
}

public function getAllPelanggaranByNip($nip){
    return $this->db->select('b.id as id_m_user, a.*, c.nama_pelanggaran_detail')
                    ->from('t_pelanggaran a')
                    ->join('m_user b', 'a.id_m_user = b.id')
                    ->join('m_pelanggaran_detail c', 'a.id_m_pelanggaran_detail = c.id')
                    ->where('a.flag_active', 1)
                    ->order_by('a.created_date', 'desc')
                    ->get()->result_array();
}
            
        function getLingkupTimKerja(){
            $this->db->select('*')
            // ->where('id !=', 0)
            // ->group_by('a.nama_jabatan')
            ->from('db_pegawai.lingkup_timkerja a');
            return $this->db->get()->result_array(); 

        }

        function getPemberiPenghargaan(){
            $this->db->select('*')
            // ->where('id !=', 0)
            // ->group_by('a.nama_jabatan')
            ->from('db_pegawai.pemberipenghargaan a');
            return $this->db->get()->result_array(); 

        }

        function getJenjangDiklatEdit($id){
            $this->db->select('*')
            ->where('id_jenisdiklat', $id)
            ->from('db_pegawai.jenjang_diklat a');
            return $this->db->get()->result_array(); 

        }

        function getJabatanOrganisasi(){
            $this->db->select('*')
            ->where('id !=', 0)
            ->order_by('a.no_urut','asc')
            ->from('db_pegawai.jabatan_organisasi a');
            return $this->db->get()->result_array(); 

        }

        function syncSiasnJabatan($id){
            $siasn = null;
            $data = $this->getJabatanPegawaiEdit($id)[0];
            if($data['meta_data_siasn']){
                $siasn = json_decode($data['meta_data_siasn'], true);
            }

            $data_siasn = null;
            if($siasn){
                $data_siasn = $siasn;
            }

            $update = null;

            // $path = null;
            // if($data_siasn && isset($data_siasn['path'][872])){
            //     $path[] = $data_siasn['path'][872];
            // }

            $jenis_jabatan = "4";
            if($data['jenis_jabatan'] == "Struktural"){
                $jenis_jabatan = "1";
            } else if($data['jenis_jabatan'] == "JFT"){
                $jenis_jabatan = "2";
            }
            
            $update = [
                "eselonId" => $data['id_eselon_siasn'],
                "id" => $data_siasn ? $data_siasn['id'] : null,
                "instansiIndukId" => ID_INSTANSI_SIASN, 
                "instansiId" => ID_INSTANSI_SIASN,
                "jabatanFungsionalId" => $data['jenis_jabatan'] == 'JFT' ? $data['id_jabatan_siasn'] : null,
                "jabatanFungsionalUmumId" => $data['jenis_jabatan'] == 'JFU' ? $data['id_jabatan_siasn'] : null,
                "jabatanStrukturalId" => $data['jenis_jabatan'] == 'Struktural' ? $data['id_jabatan_siasn'] : null,
                "jenisJabatan" => $jenis_jabatan,
                "nomorSk" => $data['nosk'],
                // "path" => $path,
                "pnsId" => $data['id_pns_siasn'],
                "satuanKerjaId" => ID_SATUAN_KERJA_SIASN,
                "tanggalSk" => formatDateOnlyForEdit2($data['tglsk']),
                "tmtJabatan" => formatDateOnlyForEdit2($data['tmtjabatan']),
                "tmtPelantikan" => formatDateOnlyForEdit2($data['tmtjabatan']),
                "unorId" => $data['id_unor_siasn']
            ];
            $ws = $this->siasnlib->saveJabatan($update);
            
            if($ws['code'] == 0){
                $data_success = json_decode($ws['data'], true);
                $id_jabatan_siasn = $data_success['mapData']['rwJabatanId'];

                $url = ('arsipjabatan/'.$data['gambarsk']);
                $request = [
                    'id_riwayat' => $id_jabatan_siasn,
                    'id_ref_dokumen' => 872,
                    'file' => new CURLFile ($url)
                ];
                // dd($request);
                $reqUploadDokumen = $this->siasnlib->uploadRiwayatDokumen($request);

                $updatedJabatan = $this->siasnlib->getJabatanByIdRiwayat($id_jabatan_siasn);
                if($updatedJabatan['code'] == 0){
                    $newMeta = json_decode($updatedJabatan['data'], true);
                    $this->db->where('id', $data['id'])
                            ->update('db_pegawai.pegjabatan', [
                                'meta_data_siasn' => json_encode($newMeta['data']),
                                'id_siasn' => $newMeta['data']['id'],
                                'id_unor_siasn' => $newMeta['data']['unorId'],
                                'gambarsk' => $data['gambarsk'],
                                // 'gambarsk' => isset($newMeta['data']['path'][872]['dok_uri']) ? $newMeta['data']['path'][872]['dok_uri'] : null,
                                'updated_by' => $this->general_library->getId()
                            ]);
                }
            }

            return $ws;
        }

        function getJabatanPegawaiEdit($id){
            $this->db->select('d.jenis_jabatan,c.id_unitkerja,b.skpd as unitkerja_id,c.eselon,c.pejabat,c.jenisjabatan, b.id_pns_siasn, c.id_siasn,
            c.id_jabatan,c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan, d.id_jabatan_siasn, b.nipbaru_ws,
            c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk,c.keterangan, c.id_unor_siasn, c.meta_data_siasn, e.id_eselon, e.id_eselon_siasn')
                          ->from('m_user a')
                          ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                          ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                          ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg','left')
                          ->join('db_pegawai.eselon e','c.eselon = e.id_eselon','left')
                          ->where('a.flag_active', 1)
                          ->where('c.id', $id);
                          $query = $this->db->get()->result_array();
                          return $query;
      }

        function getPangkatPegawaiEdit($id){
            $this->db->select('b.id_peg,c.id,e.id_jenispengangkatan,c.keterangan,c.created_date,c.gambarsk,c.id,c.status,e.nm_jenispengangkatan, c.masakerjapangkat, d.nm_pangkat, c.tmtpangkat, c.pejabat,
                           c.nosk, c.tglsk, c.gambarsk,c.pangkat')
                           ->from('m_user a')
                           ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                           ->join('db_pegawai.pegpangkat c', 'b.id_peg = c.id_pegawai')
                           ->join('db_pegawai.pangkat d','c.pangkat = d.id_pangkat')
                           ->join('db_pegawai.jenispengangkatan e','c.jenispengangkatan = e.id_jenispengangkatan')
                           ->where('c.id', $id)
                           ->where('a.flag_active', 1)
                           ->where('c.flag_active', 1);

                           $query = $this->db->get()->result_array();
                           return $query;
       }

       function getGajiBerkalaEdit($id){
        $this->db->select('*')
                       ->from('m_user a')
                       ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                       ->join('db_pegawai.peggajiberkala c', 'b.id_peg = c.id_pegawai')
                       ->join('db_pegawai.pangkat d', 'b.pangkat = d.id_pangkat')
                       ->where('c.id', $id)
                       ->where('a.flag_active', 1)
                       ->where('c.flag_active', 1);
                    
                       $query = $this->db->get()->result_array();
                       return $query;
   }

   function getArsipLainEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegarsip c', 'b.id_peg = c.id_pegawai')
                   ->where('c.id', $id);                
                   $query = $this->db->get()->result_array();
                   return $query;
}

   function getPendidikanEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegpendidikan c', 'b.id_peg = c.id_pegawai')
                   // ->join('db_pegawai.tktpendidikan d','c.tktpendidikan = d.id_tktpendidikan')
                   ->join('db_pegawai.tktpendidikanb e','c.tktpendidikan = e.id_tktpendidikanb')
                   ->where('c.id', $id)
                   ->where('a.flag_active', 1)
                   ->where('c.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}

function getCutiEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegcuti c', 'b.id_peg = c.id_pegawai')
                   ->join('db_pegawai.cuti d', 'c.jeniscuti = d.id_cuti')
                   ->where('c.id', $id)
                   ->where('c.flag_active', 1)
                   ->where('a.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}

function getDiklatEdit($id){
    $this->db->select('c.*,b.*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegdiklat c', 'b.id_peg = c.id_pegawai')
                   ->join('db_pegawai.diklat d','c.jenisdiklat = d.id_diklat')
                   ->join('db_pegawai.jenjang_diklat e','c.jenjang_diklat = e.id')
                   ->where('c.id', $id)
                   ->where('a.flag_active', 1)
                   ->where('c.flag_active', 1);

                   $query = $this->db->get()->result_array();
                   return $query;
}

function getDisiplinEdit($id){
    $this->db->select('c.*,b.*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegdisiplin c', 'b.id_peg = c.id_pegawai')
                   ->join('db_pegawai.hd d','c.hd = d.idk')
                   ->join('db_pegawai.jhd e','c.jhd = e.id_jhd')
                   ->where('c.id', $id)
                   ->where('a.flag_active', 1)
                   ->where('c.flag_active', 1);

                   $query = $this->db->get()->result_array();
                   return $query;
}


function getOrganisasiEdit($id){
    //  $this->db->select('b.*,c.*,b.*,d.*,e.nm_jabatan_organisasi')
     $this->db->select('*, c.id as id_pegorganisasi')

                    ->from('m_user a')
                    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                    ->join('db_pegawai.pegorganisasi c', 'b.id_peg = c.id_pegawai')
                    ->join('db_pegawai.organisasi d', 'c.jenis_organisasi = d.id_organisasi')
                    ->join('db_pegawai.jabatan_organisasi e', 'c.id_jabatan_organisasi = e.id')

                    ->where('c.id', $id)
                    ->where('c.flag_active', 1)
                    ->where('a.flag_active', 1);
                    $query = $this->db->get()->result_array();
                    return $query;
}

function getPenghargaanEdit($id){
    $this->db->select('a.*, b.*,c.*,d.nm_pemberipenghargaan,d.id as id_pemberi')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegpenghargaan c', 'b.id_peg = c.id_pegawai')
                   ->join('db_pegawai.pemberipenghargaan d', 'c.pemberi = d.id', 'left')
                   ->where('c.id', $id)
                   ->where('c.flag_active', 1)
                   ->where('a.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}

function getSumpahJanjiEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegsumpah c', 'b.id_peg = c.id_pegawai')
                   ->join('db_pegawai.sumpah d', 'c.sumpahpeg = d.id_sumpah')
                   ->where('c.id', $id)
                   ->where('c.flag_active', 1)
                   ->where('a.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}

function getTimKerjaEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegtimkerja c', 'b.id_peg = c.id_pegawai')
                   ->where('c.id', $id)
                   ->where('c.flag_active', 1)
                   ->where('a.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}

function getKeluargaEdit($id){
    $this->db->select('*')
                   ->from('m_user a')
                   ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                   ->join('db_pegawai.pegkeluarga c', 'b.id_peg = c.id_pegawai')
                   ->where('c.id', $id)
                   ->where('c.flag_active', 1)
                   ->where('a.flag_active', 1);
                   $query = $this->db->get()->result_array();
                   return $query;
}


public function submitEditJabatan(){
    $nama_jabatan = null;
    $id_jabatan = null;
    $datapost = $this->input->post();
    $this->db->trans_begin();
    $target_dir = './arsipjabatan/';
    $filename = str_replace(' ', '', $this->input->post('gambarsk')); 

    if($_FILES['file']['name'] != ""){
      
        if($filename == ""){
            $filename = $_FILES['file']['name'];
        } 

    $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
    $filename = $random_number.$filename;

    $config['upload_path']          = $target_dir;
    $config['allowed_types']        = 'pdf';
    $config['encrypt_name']			= FALSE;
    $config['overwrite']			= TRUE;
    $config['detect_mime']			= TRUE; 
    $config['file_name']            = "$filename";

    $this->load->library('upload', $config);

    // coba upload file		
    if (!$this->upload->do_upload('file')) {

        $data['error']    = strip_tags($this->upload->display_errors());
        // $data['token']    = $this->security->get_csrf_hash();
        
        $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
        return $res;

    } else {
        $dataFile = $this->upload->data();
 

        // $file_tmp = $_FILES['file']['tmp_name'];
        // $data_file = file_get_contents($file_tmp);
        // $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        // $filename = $random_number.$filename;

        // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
        // $path = substr($target_dir,2);
        // $res = $this->dokumenlib->setDokumenWs('POST',[
        //     'username' => "199401042020121011",
        //     'password' => "039945c6ccf8669b8df44612765a492a",
        //     'filename' => $path.$filename,
        //     'docfile'  => $base64
        // ]);
       
            $str = $this->input->post('jabatan_nama');
            if($str){
                $newStr = explode(";", $str);
                $id_jabatan = $newStr[0];
                $nama_jabatan = $newStr[1];
                $data['id_jabatan']      = $id_jabatan; 
            }
           
            if($nama_jabatan == null){
                $nama_jabatan = $this->input->post('teks_jabatan');
            } 

            $skpd = explode("/", $this->input->post('edit_jabatan_unit_kerja'));
            $id_skpd = $skpd[0];
            $nama_skpds = $skpd[1];
               

            $id = $datapost['id'];
            // $data['nm_jabatan']      = $this->input->post('edit_jabatan_nama');
            $data['id_unitkerja']     = $id_skpd;
            $data['skpd']     = $nama_skpds;
            $data['nm_jabatan']      = $nama_jabatan;
            $data['id_jabatan']      = $id_jabatan;
            $data['tmtjabatan']     = $this->input->post('edit_jabatan_tmt');
            $data['jenisjabatan']      = $this->input->post('edit_jabatan_jenis');
            $data['statusjabatan']      = $this->input->post('edit_jabatan_status');
            $data['pejabat']      = $this->input->post('edit_jabatan_pejabat');
            $data['eselon']      = $this->input->post('edit_jabatan_eselon');
            $data['nosk']      = $this->input->post('edit_jabatan_no_sk');
            $data['angkakredit']      = $this->input->post('edit_jabatan_angka_kredit');
            $data['ket']      = $this->input->post('edit_jataban_keterangan');
            $data['tglsk']      = $this->input->post('edit_jabatan_tanggal_sk');
            $data['id_unor_siasn']      = $this->input->post('id_unor_siasn');
            $data['updated_by']      = $this->general_library->getId();
            $data["gambarsk"] = $filename;
             $this->db->where('id', $id)
                ->update('db_pegawai.pegjabatan', $data);

        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

    }
    } else {
        $str = $this->input->post('jabatan_nama');
        if($str){
            $newStr = explode(";", $str,2);
            // dd($newStr);
            $id_jabatan = $newStr[0];
            $nama_jabatan = $newStr[1];
            $data['id_jabatan']      = $id_jabatan; 
        }
        if($nama_jabatan == null){
            $nama_jabatan = $this->input->post('teks_jabatan');
        } 

        $skpd = explode("/", $this->input->post('edit_jabatan_unit_kerja'));
            $id_skpd = $skpd[0];
            $nama_skpds = $skpd[1];


        $id = $datapost['id'];
        $data['id_unitkerja']     = $id_skpd;
        $data['skpd']     = $nama_skpds;
        $data['nm_jabatan']      =  $nama_jabatan;
        $data['tmtjabatan']     = $this->input->post('edit_jabatan_tmt');
        $data['jenisjabatan']      = $this->input->post('edit_jabatan_jenis');
        $data['statusjabatan']      = $this->input->post('edit_jabatan_status');
        $data['pejabat']      = $this->input->post('edit_jabatan_pejabat');
        $data['eselon']      = $this->input->post('edit_jabatan_eselon');
        $data['nosk']      = $this->input->post('edit_jabatan_no_sk');
        $data['angkakredit']      = $this->input->post('edit_jabatan_angka_kredit');
        $data['ket']      = $this->input->post('edit_jataban_keterangan');
        $data['tglsk']      = $this->input->post('edit_jabatan_tanggal_sk');
        $data['id_unor_siasn']      = $this->input->post('id_unor_siasn');
        $data['updated_by']      = $this->general_library->getId();
        $this->db->where('id', $id)
                ->update('db_pegawai.pegjabatan', $data);
    
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

    }

    if($res['success']){
        $input_post = $this->input->post();
        $pegjabatan = $this->getJabatanPegawaiEdit($datapost['id']);

        if($pegjabatan && isset($pegjabatan[0]['id_siasn']) && $pegjabatan[0]['id_siasn']){
            $pegjabatan = $pegjabatan[0];

            // $jenis_jabatan = "4";
            // if($input_post['edit_jabatan_jenis'] == "00"){
            //     $jenis_jabatan = "1";
            // } else if($input_post['edit_jabatan_jenis'] == "10"){
            //     $jenis_jabatan = "2";
            // }

            $mEselon = $this->db->select('*')
                        ->from('db_pegawai.eselon')
                        ->where('id_eselon', $input_post['edit_jabatan_eselon'])
                        ->get()->row_array();

            if($id_jabatan){
                $dataJabatan = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatanpeg', $id_jabatan)
                                ->get()->row_array();

                if($dataJabatan && $dataJabatan['id_jabatan_siasn']){
                    $jenis_jabatan = "4";
                    if($dataJabatan['jenis_jabatan'] == "JFT"){
                        $jenis_jabatan = "2";
                    } else if($dataJabatan['jenis_jabatan'] == "Struktural"){
                        $jenis_jabatan = "1";
                    } else {
                        $jenis_jabatan = "4";
                    }

                    $update = [
                        "eselonId" => $mEselon ? $mEselon['id_eselon_siasn'] : null,
                        "id" => $pegjabatan['id_siasn'],
                        "instansiIndukId" => ID_INSTANSI_SIASN, 
                        "instansiId" => ID_INSTANSI_SIASN,
                        "jabatanFungsionalId" => $dataJabatan['jenis_jabatan'] == 'JFT' ? $dataJabatan['id_jabatan_siasn'] : null,
                        "jabatanFungsionalUmumId" => $dataJabatan['jenis_jabatan'] == 'JFU' ? $dataJabatan['id_jabatan_siasn'] : null,
                        "jabatanStrukturalId" => $dataJabatan['jenis_jabatan'] == 'Struktural' ? $dataJabatan['id_jabatan_siasn'] : null,
                        "jenisJabatan" => $jenis_jabatan,
                        "nomorSk" => $input_post['edit_jabatan_no_sk'],
                        // "path" => $path,
                        "pnsId" => $pegjabatan['id_pns_siasn'],
                        "satuanKerjaId" => ID_SATUAN_KERJA_SIASN,
                        "tanggalSk" => formatDateOnlyForEdit2($input_post['edit_jabatan_tanggal_sk']),
                        "tmtJabatan" => formatDateOnlyForEdit2($input_post['edit_jabatan_tmt']),
                        "tmtPelantikan" => formatDateOnlyForEdit2($input_post['edit_jabatan_tmt']),
                        "unorId" => $input_post['id_unor_siasn']
                    ];

                    // $reqWs = $this->siasnlib->saveJabatan($update);
                    // if($reqWs['code'] == 1){
                    //     $res = array('msg' => 'Gagal menyimpan data di SIASN. '.$reqWs['data'], 'success' => false);
                    //     $this->db->trans_rollback();
                    //     return $res;    
                    // } else {
                    //     if($_FILES['file']['name'] != ""){
                    //         $url = ('arsipjabatan/'.$filename);
                    //         $request = [
                    //             'id_riwayat' => $pegjabatan['id_siasn'],
                    //             'id_ref_dokumen' => 872,
                    //             'file' => new CURLFile ($url)
                    //         ];
                    //         $reqWsDokumen = $this->siasnlib->uploadRiwayatDokumen($request);
                    //     }
                    // }
                    
                    $updatedJabatan = $this->siasnlib->getJabatanByIdRiwayat($pegjabatan['id_siasn']);
                    if($updatedJabatan['code'] == 0){
                        $newMeta = json_decode($updatedJabatan['data'], true);
                        $this->db->where('id', $pegjabatan['id'])
                                ->update('db_pegawai.pegjabatan', [
                                    'meta_data_siasn' => json_encode($newMeta['data']),
                                    'updated_by' => $this->general_library->getId()
                                ]);
                    }
                } else {
                    $res = array('msg' => 'Data gagal disimpan. Data Jabatan belum tersinkron dengan SIASN', 'success' => false);
                    $this->db->trans_rollback();
                    return $res;
                }
            } else {
                $res = array('msg' => 'Data gagal disimpan. Gagal menyimpan data di SIASN', 'success' => false);
                $this->db->trans_rollback();
                return $res;
            }  
        } else {
            // $res = array('msg' => 'Data gagal disimpan. Gagal menyimpan data di SIASN', 'success' => false);
            // $this->db->trans_rollback();
            // return $res;
        }   
    }

    if($this->db->trans_status() == FALSE){
        $this->db->trans_rollback();
        $res = array('msg' => 'Data gagal disimpan', 'success' => false);
    } else {
        $this->db->trans_commit();
    }
    $id_peg = $datapost['id_peg'];
    $this->updateJabatan($id_peg);
    return $res;

   }

    public function tesUploadDokumenRiwayat(){
        $pegjabatan = $this->getJabatanPegawaiEdit('25113')[0];

        $url = ('arsipjabatan/'.$pegjabatan['gambarsk']);
        
        $request = [
            'id_riwayat' => $pegjabatan['id_siasn'],
            'id_ref_dokumen' => 872,
            'file' => new CURLFile ($url)
        ];
        // dd($request);
        $reqWs = $this->siasnlib->uploadRiwayatDokumen($request);
        dd($reqWs);
    }



       public function submitEditPangkat(){

        $datapost = $this->input->post();
        $this->db->trans_begin();
        $target_dir = './arsipelektronik/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
          
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 

        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $filename = $random_number.$filename;

		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE; 
        $config['file_name']            = "$filename";

		$this->load->library('upload', $config);

	

		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			// $data['token']    = $this->security->get_csrf_hash();
            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $dataFile 			= $this->upload->data();
            // $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            // $filename = $random_number.$filename;

            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            // if($target_dir != null){
            //     unlink($target_dir."$nama_file");
            // }

            $id = $datapost['id'];
            $data["jenispengangkatan"] = $datapost["edit_jenis_pengangkatan"];
            $data["pangkat"] = $datapost["edit_pangkat"];
            $data["tmtpangkat"] = $datapost["edit_tmt_pangkat"];
            $data["masakerjapangkat"] = $datapost["edit_masa_kerja"];
            $data["pejabat"] = $datapost["edit_pejabat"];
            $data["nosk"] = $datapost["edit_no_sk"];
            $data["tglsk"] = $datapost["edit_tanggal_sk"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpangkat', $data);
        

            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
   
		}
        } else {

            $id = $datapost['id'];
            $data["jenispengangkatan"] = $datapost["edit_jenis_pengangkatan"];
            $data["pangkat"] = $datapost["edit_pangkat"];
            $data["tmtpangkat"] = $datapost["edit_tmt_pangkat"];
            $data["masakerjapangkat"] = $datapost["edit_masa_kerja"];
            $data["pejabat"] = $datapost["edit_pejabat"];
            $data["nosk"] = $datapost["edit_no_sk"];
            $data["tglsk"] = $datapost["edit_tanggal_sk"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpangkat', $data);
        
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            // $res['code'] = 1;
            // $res['message'] = 'Terjadi Kesalahan';
            // $res['data'] = null;
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }

        $id_peg = $datapost['id_peg'];
        $this->updatePangkat($id_peg);
    
        return $res;

       }


       public function submitEditBerkala(){

        $datapost = $this->input->post();
        $this->db->trans_begin();
        $target_dir = './arsipgjberkala/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
          
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } else {
                
            }

            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename";
    
		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            // $filename = $random_number.$filename;

            
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["pangkat"] = $datapost["edit_gb_pangkat"];
            $data["masakerja"] = $datapost["edit_gb_masa_kerja"];
            $data["pejabat"] = "WALI KOTA";
            $data["nosk"] = $datapost["edit_gb_no_sk"];
            $data["tglsk"] = $datapost["edit_gb_tanggal_sk"];
            $data["tmtgajiberkala"] = $datapost["edit_tmt_gaji_berkala"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.peggajiberkala', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["pangkat"] = $datapost["edit_gb_pangkat"];
            $data["masakerja"] = $datapost["edit_gb_masa_kerja"];
            $data["pejabat"] = $datapost["edit_gb_pejabat"];
            $data["nosk"] = $datapost["edit_gb_no_sk"];
            $data["tglsk"] = $datapost["edit_gb_tanggal_sk"];
            $data["tmtgajiberkala"] = $datapost["edit_tmt_gaji_berkala"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.peggajiberkala', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }



       public function submitEditPendidikan(){

        $datapost = $this->input->post();
        $this->db->trans_begin();
        $target_dir = './arsippendidikan/';
        $filename = $this->input->post('gambarsk');
       
        if($_FILES['file']['name'] != ""){
          
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 

            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
        
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE; 
        $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["tktpendidikan"] = $datapost["edit_pendidikan_tingkat"];
            $data["jurusan"] = $datapost["edit_pendidikan_jurusan"];
            $data["fakultas"] = $datapost["edit_pendidikan_fakultas"];
            $data["namasekolah"] = $datapost["edit_pendidikan_nama_sekolah_universitas"];
            $data["pimpinansekolah"] = $datapost["edit_pendidikan_nama_pimpinan"];
            $data["tahunlulus"] = $datapost["edit_pendidikan_tahun_lulus"];
            $data["noijasah"] = $datapost["edit_pendidikan_no_ijazah"];
            $data["tglijasah"] = $datapost["edit_pendidikan_tanggal_ijazah"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpendidikan', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["tktpendidikan"] = $datapost["edit_pendidikan_tingkat"];
            $data["jurusan"] = $datapost["edit_pendidikan_jurusan"];
            $data["fakultas"] = $datapost["edit_pendidikan_fakultas"];
            $data["namasekolah"] = $datapost["edit_pendidikan_nama_sekolah_universitas"];
            $data["pimpinansekolah"] = $datapost["edit_pendidikan_nama_pimpinan"];
            $data["tahunlulus"] = $datapost["edit_pendidikan_tahun_lulus"];
            $data["noijasah"] = $datapost["edit_pendidikan_no_ijazah"];
            $data["tglijasah"] = $datapost["edit_pendidikan_tanggal_ijazah"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpendidikan', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }


       public function submitEditCuti(){

        $datapost = $this->input->post();
       
        $this->db->trans_begin();
        $target_dir = './arsipcuti/';
        $filename = $this->input->post('gambarsk');
       
        if($_FILES['file']['name'] != ""){
            
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            $res = $this->dokumenlib->setDokumenWs('POST',[
                'username' => "199401042020121011",
                'password' => "039945c6ccf8669b8df44612765a492a",
                'filename' => $path.$filename,
                'docfile'  => $base64
            ]);
           
            $id = $datapost['id'];
            $data["jeniscuti"] = $datapost["edit_cuti_jenis"];
            // $data["lamacuti"] = $datapost["edit_pendidikan_jurusan"];
            $data["tglmulai"] = $datapost["edit_cuti_tglmulai"];
            $data["tglselesai"] = $datapost["edit_cuti_tglselesai"];
            $data["nosttpp"] = $datapost["edit_cuti_nosurat"];
            $data["tglsttpp"] = $datapost["edit_cuti_tglsurat"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegcuti', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
          
            $id = $datapost['id'];
            $data["jeniscuti"] = $datapost["edit_cuti_jenis"];
            // $data["lamacuti"] = $datapost["edit_pendidikan_jurusan"];
            $data["tglmulai"] = $datapost["edit_cuti_tglmulai"];
            $data["tglselesai"] = $datapost["edit_cuti_tglselesai"];
            $data["nosttpp"] = $datapost["edit_cuti_nosurat"];
            $data["tglsttpp"] = $datapost["edit_cuti_tglsurat"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegcuti', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }


       public function submitEditDiklat(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsipdiklat/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["jenisdiklat"] = $datapost["edit_diklat_jenis"];
            if(isset($datapost["edit_diklat_jenjang"])){
                $data["jenjang_diklat"] = $datapost["edit_diklat_jenjang"];
            }
            $data["nm_diklat"] = $datapost["edit_diklat_nama"];
            $data["tptdiklat"] = $datapost["edit_diklat_tempat"];
            $data["penyelenggara"] = $datapost["edit_diklat_penyelenggara"];
            $data["angkatan"] = $datapost["edit_diklat_angkatan"];
            $data["jam"] = $datapost["edit_diklat_jam"];
            $data["tglmulai"] = $datapost["edit_diklat_tangal_mulai"];
            $data["tglselesai"] = $datapost["edit_diklat_tanggal_selesai"];
            $data["nosttpp"] = $datapost["edit_diklat_no_sttpp"];
            $data["tglsttpp"] = $datapost["edit_diklat_tanggal_sttpp"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegdiklat', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["jenisdiklat"] = $datapost["edit_diklat_jenis"];
            if(isset($datapost["edit_diklat_jenjang"])){
                $data["jenjang_diklat"] = $datapost["edit_diklat_jenjang"];
            }
            $data["nm_diklat"] = $datapost["edit_diklat_nama"];
            $data["tptdiklat"] = $datapost["edit_diklat_tempat"];
            $data["penyelenggara"] = $datapost["edit_diklat_penyelenggara"];
            $data["angkatan"] = $datapost["edit_diklat_angkatan"];
            $data["jam"] = $datapost["edit_diklat_jam"];
            $data["tglmulai"] = $datapost["edit_diklat_tangal_mulai"];
            $data["tglselesai"] = $datapost["edit_diklat_tanggal_selesai"];
            $data["nosttpp"] = $datapost["edit_diklat_no_sttpp"];
            $data["tglsttpp"] = $datapost["edit_diklat_tanggal_sttpp"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegdiklat', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitEditDisiplin(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsipdisiplin/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
           
           
            $id = $datapost['id'];

            $data['hd']         = $this->input->post('edit_disiplin_jenis');
            $data['jhd']         = $this->input->post('edit_disiplin_jenjang');
            $data['jp']         = $this->input->post('edit_disiplin_nama');
            $data['nosurat']         = $this->input->post('edit_disiplin_nosurat');
            $data['tglsurat']         = $this->input->post('edit_disiplin_tglsurat');
            $data['tmt']         = $this->input->post('edit_disiplin_tmt');

            $data['tgl_mulaiberlaku']         = $this->input->post('edit_disiplin_tgl_mulaiberlaku');
            $data['tgl_selesaiberlaku']         = $this->input->post('edit_disiplin_tgl_selesaiberlaku');
            
            $data["gambarsk"]     = $filename;
            $data['created_by']      = $this->general_library->getId();
            $data['status']      = 2;
            $data['tanggal_verif']      = date('Y-m-d H:i:s');
            $data['id_m_user_verif']      = $this->general_library->getId();
            
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegdisiplin', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data['hd']         = $this->input->post('edit_disiplin_jenis');
            $data['jhd']         = $this->input->post('edit_disiplin_jenjang');
            $data['jp']         = $this->input->post('edit_disiplin_nama');
            $data['nosurat']         = $this->input->post('edit_disiplin_nosurat');
            $data['tglsurat']         = $this->input->post('edit_disiplin_tglsurat');
            $data['tmt']         = $this->input->post('edit_disiplin_tmt');
            $data['tgl_mulaiberlaku']         = $this->input->post('edit_disiplin_tgl_mulaiberlaku');
            $data['tgl_selesaiberlaku']         = $this->input->post('edit_disiplin_tgl_selesaiberlaku');
            $data['created_by']      = $this->general_library->getId();
            $data['status']      = 2;
            $data['tanggal_verif']      = date('Y-m-d H:i:s');
            $data['id_m_user_verif']      = $this->general_library->getId();
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegdisiplin', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }


       public function submitEditOrganisasi(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsiporganisasi/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["jenis_organisasi"] = $datapost["edit_jenis_organisasi"];
            $data["nama_organisasi"] = $datapost["edit_nama_organisasi"];
            $data["id_jabatan_organisasi"] = $datapost["edit_id_jabatan_organisasi"];
            $data["tglmulai"] = $datapost["edit_tglmulai"];
            $data["tglselesai"] = $datapost["edit_tglselesai"];
            $data["pemimpin"] = $datapost["edit_pemimpin"];
            $data["tempat"] = $datapost["edit_tempat"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegorganisasi', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["jenis_organisasi"] = $datapost["edit_jenis_organisasi"];
            $data["nama_organisasi"] = $datapost["edit_nama_organisasi"];
            $data["id_jabatan_organisasi"] = $datapost["edit_id_jabatan_organisasi"];
            $data["tglmulai"] = $datapost["edit_tglmulai"];
            $data["tglselesai"] = $datapost["edit_tglselesai"];
            $data["pemimpin"] = $datapost["edit_pemimpin"];
            $data["tempat"] = $datapost["edit_tempat"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegorganisasi', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }


       public function submitEditPenghargaan(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsippenghargaan/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename";

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["nm_pegpenghargaan"] = $datapost["edit_nm_pegpenghargaan"];
            $data["nosk"] = $datapost["edit_nosk"];
            $data["tglsk"] = $datapost["edit_tglsk"];
            $data["tahun_penghargaan"] = $datapost["edit_tahun_penghargaan"];
            $data["pemberi"] = $datapost["edit_pemberi"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpenghargaan', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["nm_pegpenghargaan"] = $datapost["edit_nm_pegpenghargaan"];
            $data["nosk"] = $datapost["edit_nosk"];
            $data["tglsk"] = $datapost["edit_tglsk"];
            $data["tahun_penghargaan"] = $datapost["edit_tahun_penghargaan"];
            $data["pemberi"] = $datapost["edit_pemberi"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegpenghargaan', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitEditSumjan(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsipsumpah/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename"; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["sumpahpeg"] = $datapost["edit_sumpahpeg"];
            $data["pejabat"] = $datapost["edit_pejabat"];
            $data["noba"] = $datapost["edit_noba"];
            $data["tglba"] = $datapost["edit_tglba"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegsumpah', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["sumpahpeg"] = $datapost["edit_sumpahpeg"];
            $data["pejabat"] = $datapost["edit_pejabat"];
            $data["noba"] = $datapost["edit_noba"];
            $data["tglba"] = $datapost["edit_tglba"];
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegsumpah', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitEditTimKerja(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsiptimkerja/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename"; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["nm_timkerja"] = $datapost["edit_nama_timkerja"];
            $data["jabatan"] = $datapost["edit_jabatan_timkerja"];
            $data["lingkup_timkerja"] = $datapost["edit_ruanglingkup"];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegtimkerja', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $data["nm_timkerja"] = $datapost["edit_nama_timkerja"];
            $data["jabatan"] = $datapost["edit_jabatan_timkerja"];
            $data["lingkup_timkerja"] = $datapost["edit_ruanglingkup"];
           
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegtimkerja', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitEditKeluarga(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsipkeluarga/';
        // $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
       
        if($this->input->post('hubkel_edit') == 20 || $this->input->post('hubkel_edit') == 30 || $this->input->post('hubkel_edit') == 40 ){
        if($_FILES['file']['name'] != ""){
            $filename = str_replace(' ', '', $_FILES['file']['name']);
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename"; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            
           
            $id = $datapost['id'];
           
                $data['hubkel']      = $this->input->post('hubkel_edit');
                $data['namakel']      = $this->input->post('namakel_edit');
                $data['tptlahir']      = $this->input->post('tptlahir_edit');
                $data['tgllahir']      = $this->input->post('tgllahir_edit');
                $data['pendidikan']      = $this->input->post('pendidikan_edit');
                $data['pekerjaan']      = $this->input->post('pekerjaan_edit');
    
                 if($this->input->post('hubkel_edit') == 20 || $this->input->post('hubkel_edit') || 30){
                    $data['pasangan_ke']      = $this->input->post('pasangan_ke_edit');
                    $data['tglnikah']      = $this->input->post('tglnikah_edit');
                    $data['gambarsk']         = $filename;
                 }
    
                 if($this->input->post('hubkel') == 40){
                    $data['statusanak']      = $this->input->post('statusanak_edit');
                    $data['nama_ortu_anak']      = $this->input->post('nama_ortu_anak_edit');
                    $data['gambarsk']         = $filename;
                 }
                

            $this->db->where('id', $id)
                    ->update('db_pegawai.pegkeluarga', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
                $data['hubkel']      = $this->input->post('hubkel_edit');
                $data['namakel']      = $this->input->post('namakel_edit');
                $data['tptlahir']      = $this->input->post('tptlahir_edit');
                $data['tgllahir']      = $this->input->post('tgllahir_edit');
                $data['pendidikan']      = $this->input->post('pendidikan_edit');
                $data['pekerjaan']      = $this->input->post('pekerjaan_edit');
    
                 if($this->input->post('hubkel_edit') == 20 || $this->input->post('hubkel_edit') || 30){
                    $data['pasangan_ke']      = $this->input->post('pasangan_ke_edit');
                    $data['tglnikah']      = $this->input->post('tglnikah_edit');
                 }
    
                 if($this->input->post('hubkel_edit') == 40){
                    $data['statusanak']      = $this->input->post('statusanak_edit');
                    $data['nama_ortu_anak']      = $this->input->post('nama_ortu_anak_edit');
                 }
                

            $this->db->where('id', $id)
                    ->update('db_pegawai.pegkeluarga', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        }
           
        } else {
            $id = $datapost['id'];
            $data['hubkel']      = $this->input->post('hubkel_edit');
            $data['namakel']      = $this->input->post('namakel_edit');
            $data['tptlahir']      = $this->input->post('tptlahir_edit');
            $data['tgllahir']      = $this->input->post('tgllahir_edit');
            $data['pendidikan']      = $this->input->post('pendidikan_edit');
            $data['pekerjaan']      = $this->input->post('pekerjaan_edit');
           
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegkeluarga', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitEditArsipLain(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './arsiplain/';
        $filename = str_replace(' ', '', $this->input->post('gambarsk')); 
        
       
        if($_FILES['file']['name'] != ""){
       
            if($filename == ""){
                $filename = $_FILES['file']['name'];
            } 
           
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename"; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            // $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            // $filename = $this->general_library->getId().$random_number.$filename;

            // $file_tmp = $_FILES['file']['tmp_name'];
            // $data_file = file_get_contents($file_tmp);
            // $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            // $path = substr($target_dir,2);
            // $res = $this->dokumenlib->setDokumenWs('POST',[
            //     'username' => "199401042020121011",
            //     'password' => "039945c6ccf8669b8df44612765a492a",
            //     'filename' => $path.$filename,
            //     'docfile'  => $base64
            // ]);
           
            $id = $datapost['id'];
            $data["gambarsk"] = $filename;
            $this->db->where('id', $id)
                    ->update('db_pegawai.pegarsip', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        } else {
            $id = $datapost['id'];
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

    public function getDataSatyalencanaPegawai($nip){
        return $this->db->select('a.*, c.nama_satya_lencana')
                        ->from('db_pegawai.pegpenghargaan a')
                        ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                        ->join('m_satyalencana c', 'a.id_m_satyalencana = c.id')
                        ->where('b.nipbaru_ws', $nip)
                        ->where('a.flag_active', 1)
                        ->where('a.status = 2')
                        ->where('a.id_m_satyalencana IS NOT NULL')
                        ->order_by('a.id_m_satyalencana', 'asc')
                        ->get()->result_array();
    }

    public function loadDataDrh($nip){
        $rs['riwayat_pendidikan'] = null;
        $rs['riwayat_pangkat'] = null;
        $rs['riwayat_diklat'] = null;
        $rs['riwayat_jabatan'] = null;
        $rs['riwayat_keluarga'] = null;

        $rs['data_pegawai'] = $this->db->select('a.*, j.nm_tktpendidikan, b.nm_unitkerja, c.nama_jabatan, d.nm_pangkat, e.nm_agama,
                                f.nama_kelurahan, g.nama_kecamatan, h.nama_kabupaten_kota, i.nm_sk')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                                ->join('db_pegawai.agama e', 'a.agama = e.id_agama')
                                ->join('m_kelurahan f', 'a.id_m_kelurahan = f.id', 'left')
                                ->join('m_kecamatan g', 'a.id_m_kecamatan = g.id', 'left')
                                ->join('m_kabupaten_kota h', 'a.id_m_kabupaten_kota = h.id', 'left')
                                ->join('db_pegawai.statuskawin i', 'a.status = i.id_sk')
                                ->join('db_pegawai.tktpendidikan j', 'a.pendidikan = j.id_tktpendidikan', 'left')
                                ->where('a.nipbaru_ws', $nip)
                                ->get()->row_array();

        if($rs['data_pegawai']){
            $rs['riwayat_pendidikan'] = $this->db->select('a.*, c.nm_tktpendidikanb')
                                            ->from('db_pegawai.pegpendidikan a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_pegawai.tktpendidikanb c', 'a.tktpendidikan = c.id_tktpendidikanb')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->order_by('tahunlulus', 'asc')
                                            ->get()->result_array();

           
        }
        return $rs;
    }

    public function loadDataDrhSatyalencana($nip){
        $rs['riwayat_pendidikan'] = null;
        $rs['riwayat_pangkat'] = null;
        $rs['riwayat_diklat'] = null;
        $rs['riwayat_jabatan'] = null;
        $rs['riwayat_keluarga'] = null;

        $rs['data_pegawai'] = $this->db->select('a.*, j.nm_tktpendidikan, b.nm_unitkerja, c.nama_jabatan, d.nm_pangkat, e.nm_agama,
                                f.nama_kelurahan, g.nama_kecamatan, h.nama_kabupaten_kota, i.nm_sk,
                                (SELECT CONCAT(aa.nm_jabatan,"|",aa.nosk,"|",aa.tglsk) from db_pegawai.pegjabatan as aa where a.id_peg = aa.id_pegawai and aa.flag_active in (1,2) and aa.status = 2 and aa.statusjabatan not in (2,3) ORDER BY aa.tmtjabatan desc limit 1) as data_jabatan,
                                (SELECT CONCAT(cc.nm_pangkat,"|",bb.nosk,"|",bb.tglsk) from db_pegawai.pegpangkat as bb
                                 join db_pegawai.pangkat as cc on bb.pangkat = cc.id_pangkat where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2  ORDER BY bb.tmtpangkat desc limit 1) as data_pangkat')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                                ->join('db_pegawai.agama e', 'a.agama = e.id_agama')
                                ->join('m_kelurahan f', 'a.id_m_kelurahan = f.id', 'left')
                                ->join('m_kecamatan g', 'a.id_m_kecamatan = g.id', 'left')
                                ->join('m_kabupaten_kota h', 'a.id_m_kabupaten_kota = h.id', 'left')
                                ->join('db_pegawai.statuskawin i', 'a.status = i.id_sk')
                                ->join('db_pegawai.tktpendidikan j', 'a.pendidikan = j.id_tktpendidikan', 'left')
                                ->where('a.nipbaru_ws', $nip)
                                ->get()->row_array();

        if($rs['data_pegawai']){
            $rs['riwayat_satyalencana'] = $this->db->select('a.*,c.*')
                                            ->from('db_pegawai.pegpenghargaan a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_efort.m_satyalencana c', 'a.id_m_satyalencana = c.id')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->where('a.status', 2)
                                            ->where('a.flag_active', 1)
                                            ->order_by('a.tglsk', 'desc')
                                            ->get()->result_array();

            $rs['riwayat_disiplin'] = $this->db->select('a.*,c.nama, a.tgl_selesaiberlaku')
                                            ->from('db_pegawai.pegdisiplin a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_pegawai.hd c', 'a.hd = c.idk')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->where('a.status', 2)
                                            ->where('a.flag_active', 1)  
                                            ->where('a.hd !=', 10)
                                            ->order_by('a.tglsurat', 'desc')
                                            ->get()->result_array();
            $rs['riwayat_cuti'] = $this->db->select('a.*')
                                            ->from('db_pegawai.pegcuti a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->where('a.status', 2)
                                            ->where('a.flag_active', 1)  
                                            ->where('a.jeniscuti', 50)
                                            ->order_by('a.tglsttpp', 'desc')
                                            ->get()->result_array();
           
        }
        return $rs;
    }
       function getMasterBidang($skpd){
        $this->db->select('*')
        ->where('id_unitkerja',$skpd)
        ->where('flag_active',1)
        ->from('db_efort.m_bidang');
        return $this->db->get()->result_array(); 
       }

            function getMasterSubBidang($id)
            {        
                $this->db->select('id, nama_sub_bidang');
                $this->db->where('id_m_bidang', $id);
                $this->db->where('flag_active', 1);
                $this->db->order_by('id', 'asc');
                $fetched_records = $this->db->get('m_sub_bidang');
                $datasub = $fetched_records->result_array();

                $data = array();
                foreach ($datasub as $sub) {
                    $data[] = array("id" => $sub['id'], "nama_sub_bidang" => $sub['nama_sub_bidang']);
                }
                return $data;
            }

       function getBidang($id){
            $this->db->select('a.id_m_bidang,a.id_m_sub_bidang, b.id_unitkerja')
                ->join('db_efort.m_bidang as b', 'a.id_m_bidang = b.id','left')
                ->from('db_efort.m_user a')
                ->where('a.id', $id);
            return $this->db->get()->row_array();
       }




       public function submiDataBidang(){
    
        $datapost = $this->input->post();
        
        $this->db->trans_begin();
    
        $id = $this->general_library->getId();
        
        $data["id_m_bidang"] = $datapost["id_m_bidang"];
        $data["id_m_sub_bidang"] = $datapost["id_m_sub_bidang"];
    
        $this->db->where('id', $id)
                ->update('m_user', $data);
    
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

    public function getSisaCuti(){
        $total_year = 3;
        $tahunIni = date('Y');
        $yearlist = null;
        for($i = $total_year-1; $i >= 0; $i--){
            $tahun = $tahunIni-$i;
            $yearlist[$tahun] = null;
            $dataSisaCuti = $this->db->select('*')
                                    ->from('t_sisa_cuti')
                                    ->where('tahun', $tahun)
                                    ->where('id_m_user', $this->general_library->getId())
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
            if($dataSisaCuti){
                $yearlist[$tahun] = $dataSisaCuti;
            } else {
                $jatah = 12;
                if($tahun != $tahunIni){
                    $jatah = 6;
                    $dataInsert = [
                        'id_m_user' => $this->general_library->getId(),
                        'tahun' => $tahun,
                        'jatah' => $jatah,
                        'sisa' => $jatah,
                        'created_by' => $this->general_library->getId(),
                    ];
                } else {
                    $cuti_bersama = $this->db->select('*')
                                ->from('t_hari_libur')
                                ->where('tahun', $tahun)
                                ->where('flag_active', 1)
                                ->where('flag_potong_cuti', 1)
                                ->get()->result_array();

                    $dataInsert = [
                        'id_m_user' => $this->general_library->getId(),
                        'tahun' => $tahun,
                        'jatah' => $jatah,
                        'sisa' => $jatah - count($cuti_bersama),
                        'created_by' => $this->general_library->getId(),
                    ];
                }
                $this->db->insert('t_sisa_cuti', $dataInsert);
                $yearlist[$tahun] = $dataInsert;
            }
        }
        return $yearlist;
    }

    public function getProgressCutiAktif($id){
        // $nomor = '6282115407812';
        // dd('0'.substr($nomor, 2, strlen($nomor)-1));
        $progress = $this->loadProgressCuti($id);
        $result['before'] = null;
        $result['current'] = null;
        $result['next'] = null;
        $result['list'] = null;
        $result['indexAktif'] = 0;
        if($progress){
            $i = 0;
            foreach($progress as $pr){
                if($pr['flag_verif'] == 0 && $result['current'] == null){
                    $result['current'] = $progress[$i];
                    $result['indexAktif'] = $pr['urutan'];
                }
                $result['list'][$pr['urutan']] = $pr;
                $i++;
            }

            if($result['current'] == null){
                // $result['before'] = null;
                // $result['current'] = $progress[0];
            } else {
                if(isset($result['list'][$result['indexAktif']-1])){
                    $result['before'] = $result['list'][$result['indexAktif']-1]; // ambil next dari current
                }
            }

            if($result['current'] && isset($progress[$result['current']['urutan']])){
                $result['next'] = $progress[$result['current']['urutan']]; // ambil next dari current
            }
        }

        return $result;
    }

    public function verifPermohonanCutiFromWa($resp, $chat){
        $this->db->trans_begin();
        $dataCuti = $this->db->select('*')
                            ->from('t_pengajuan_cuti')
                            ->where('id', $resp['cuti']['id'])
                            ->get()->row_array();

        $progress = $this->getProgressCutiAktif($resp['cuti']['id']);
        $flag_reply_thankyou = 1;

        $nomor_sender = '0'.substr($chat->from, 2, strlen($chat->from)-1);

        // cek jika pengirim adalah progress yang aktif
        if($progress['indexAktif'] == 0){ // verifikasi sudah selesai
            $exists = $this->db->select('*')
                            ->from('t_pengajuan_cuti')
                            ->where('id', $resp['cuti']['id'])
                            ->get()->row_array();

            $ket_tambahan = '';
            if($exists){
                $ket_tambahan = 'Proses Cuti saat ini sedang menunggu Digital Signature oleh Kepala BKPSDM Kota Manado.';
                if($exists['url_sk']){
                    $ket_tambahan = 'SK Cuti sudah ditandatangani secara digital oleh Kepala BKPSDM Kota Manado.';
                }
            }

            $replyToVerifikator = 'Mohon maaf, Proses Verifikasi sudah selesai. '.$ket_tambahan;
            $cronWaVerifikator = [
                'sendTo' => ($chat->from),
                'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                'type' => 'text',
                'ref_id' => $resp['cuti']['id'],
                'jenis_layanan' => 'Cuti'
            ];
            $this->db->insert('t_cron_wa', $cronWaVerifikator);
        } else if($progress['current']['nohp'] != $nomor_sender){ // nomor hp tidak sesuai
            $replyToVerifikator = 'Mohon maaf, Anda tidak memiliki akses untuk melakukan verifikasi pada tahapan ini. Progress Cuti saat ini: "'.$progress['current']['keterangan'].'"';
            $cronWaVerifikator = [
                'sendTo' => ($chat->from),
                'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                'type' => 'text',
                'ref_id' => $resp['cuti']['id'],
                'jenis_layanan' => 'Cuti'
            ];
            $this->db->insert('t_cron_wa', $cronWaVerifikator);
        } else if($progress['current']['chatId'] != $chat->replyId){ // salah reply pesan
            $replyToVerifikator = 'Mohon maaf, pesan ini tidak dapat direply untuk verifikasi cuti. Silahkan mereply pesan yang benar untuk verifikasi.';
            $cronWaVerifikator = [
                'sendTo' => ($chat->from),
                'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                'type' => 'text',
                'ref_id' => $resp['cuti']['id'],
                'jenis_layanan' => 'Cuti'
            ];
            $this->db->insert('t_cron_wa', $cronWaVerifikator);
        } else if(!$progress){
            $replyToVerifikator = 'Mohon maaf, progress cuti ini tidak dapat dilakukan verifikasi.';
            $cronWaVerifikator = [
                'sendTo' => ($chat->from),
                'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                'type' => 'text',
                'ref_id' => $resp['cuti']['id'],
                'jenis_layanan' => 'Cuti'
            ];
            $this->db->insert('t_cron_wa', $cronWaVerifikator);
        } else {
            //kirim pemberitahuan kepada pegawai
            $reply = "*[PERMOHONAN CUTI - ".$dataCuti['random_string']."]*\n\nSelamat ".greeting().", \nYth. ".getNamaPegawaiFull($resp['cuti']).", permohonan ".$resp['cuti']['nm_cuti']." Anda telah ";
            if($resp['response']['flag_diterima'] == 1){
                $reply .= '*DITERIMA*';

                if(!$progress['next']){ // jika kaban melakukan verif, kirim pesan harus melakukan DS
                    $flag_reply_thankyou = 0;
                    $replyToVerifikator = "*[PERMOHONAN CUTI - ".$dataCuti['random_string']."]*\n\nTerima Kasih, balasan Anda sudah kami terima. Silahkan melakukan *_Digital Signature (DS)_* melalui aplikasi Siladen.";
                    $cronWaVerifikator = [
                        'sendTo' => ($chat->from),
                        'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                        'type' => 'text',
                        // 'ref_id' => $resp['cuti']['id'],
                        'jenis_layanan' => 'Cuti'
                    ];
                    $this->db->insert('t_cron_wa', $cronWaVerifikator);
                } else {
                    $pada_tanggal = formatDateNamaBulan($resp['cuti']['tanggal_mulai']);
                        if($resp['cuti']['tanggal_mulai'] != $resp['cuti']['tanggal_akhir']){
                            $pada_tanggal .= " sampai ".formatDateNamaBulan($resp['cuti']['tanggal_akhir']);
                        }
                    $replyToNextVerifikator = "*[PERMOHONAN CUTI - ".$dataCuti['random_string']."]*\n\nSelamat ".greeting().", pegawai atas nama: ".getNamaPegawaiFull($resp['cuti'])." telah mengajukan Permohonan ".$resp['cuti']['nm_cuti']." selama ".$resp['cuti']['lama_cuti']." hari pada ".$pada_tanggal.". \n\nBalas pesan ini dengan *'YA'* untuk menyetujui atau *'Tidak'* untuk menolak.";
                    
                    // $replyToNextVerifikator = "*[PERMOHONAN CUTI - ".$dataCuti['random_string']."]*\n\nSelamat ".greeting().", pegawai atas nama: ".getNamaPegawaiFull($resp['cuti'])." telah mengajukan Permohonan ".$resp['cuti']['nm_cuti'].". \n\nBalas pesan ini dengan *'YA'* untuk menyetujui atau *'Tidak'* untuk menolak.";
                    $cronWaNextVerifikator = [
                        'sendTo' => convertPhoneNumber($progress['next']['nohp']),
                        'message' => trim($replyToNextVerifikator.FOOTER_MESSAGE_CUTI),
                        'type' => 'text',
                        'ref_id' => $resp['cuti']['id'],
                        'jenis_layanan' => 'Cuti',
                        'table_state' => 't_progress_cuti',
                        'column_state' => 'chatId',
                        'id_state' => $progress['next']['id']
                    ];
                    $this->db->insert('t_cron_wa', $cronWaNextVerifikator);

                    // update t_pengajuan_cuti
                    if($progress['next']){
                        $this->db->where('id', $resp['cuti']['id'])
                                ->update('t_pengajuan_cuti', [
                                    'id_t_progress_cuti' => $progress['next']['id'],
                                    'status_pengajuan_cuti' => $progress['next']['keterangan']
                                ]);
                    }
                }

                if(!$progress['next'] || $progress['next']['id_m_user_verifikasi'] == '193'){ // jika kaban yang verif atau selanjutnya kaban, input di request untuk DS
                    $dataCuti = $this->db->select('a.*, b.nm_cuti, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat, f.nama_jabatan, g.nm_unitkerja,
                            g.id_unitkerja, b.id_cuti, c.id as id_m_user, d.id_peg, d.handphone, d.nipbaru_ws')
                            ->from('t_pengajuan_cuti a')
                            ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                            ->join('m_user c', 'c.id = a.id_m_user')
                            ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                            ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                            ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg', 'left')
                            ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                            ->where('a.id', $resp['cuti']['id'])
                            ->get()->row_array();

                    $master = $this->db->select('*')
                            ->from('m_jenis_layanan')
                            ->where('integrated_id', $dataCuti['id_cuti'])
                            ->get()->row_array();

                    $resCuti['data'] = $dataCuti;
                    $resCuti['data']['ds'] = 1;
                    $resCuti['data']['nomor_surat'] = $nomor_surat;

                    $nomor_surat = "";
                    if(FLAG_INPUT_MANUAL_NOMOR_SURAT_CUTI == 0){
                        $tahun = date('Y');
                        $counter = qounterNomorSurat($tahun);
                        $nomor_surat = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;
                        $resCuti['data']['nomor_surat'] = $nomor_surat;
                    }

                    $filename = 'CUTI_'.$resCuti['data']['nipbaru_ws'].'_'.date("Y", strtotime($resCuti['data']['tanggal_mulai']))."_".date("m", strtotime($resCuti['data']['tanggal_mulai'])).'_'.date("d", strtotime($resCuti['data']['tanggal_mulai'])).'.pdf';
                    $path_file = 'arsipcuti/'.$filename;

                    // $encUrl = simpleEncrypt($path_file);
                    $randomString = generateRandomString(30, 1, 't_file_ds'); 
                    $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
                    // dd($contentQr);
                    $resCuti['qr'] = generateQr($contentQr);

                    // dd($path_file);
                    $mpdf = new \Mpdf\Mpdf([
                        'format' => 'Legal-P',
                        // 'debug' => true
                    ]);
                    $html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $resCuti, true);
                    $mpdf->WriteHTML($html);
                    $mpdf->showImageErrors = true;
                    $mpdf->Output($path_file, 'F');

                    $fileBase64 = convertToBase64(($path_file));
                    $signatureProperties = array();
                    $signatureProperties = [
                        'signatureProperties' => [
                            'tampilan' => 'INVISIBLE',
                            'reason' => REASON_TTE
                        ]
                    ];

                    $perihal = 'SURAT IZIN '.strtoupper($dataCuti['nm_cuti']).' PEGAWAI a.n. '.getNamaPegawaiFull($dataCuti);

                    if(FLAG_INPUT_MANUAL_NOMOR_SURAT_CUTI == 0){
                        $this->db->insert('t_nomor_surat', [
                            'perihal' => $perihal,
                            'counter' => $counter,
                            'nomor_surat' => $nomor_surat,
                            // 'created_by' => $kepala_bkpsdm['id_m_user'],
                            'tanggal_surat' => $dataCuti['created_date'],
                            'id_m_jenis_layanan' => $master['id']
                        ]);
                        $last_insert_nomor_surat = $this->db->insert_id();
                    }

                    $this->db->insert('t_request_ds', [
                        'ref_id' => $dataCuti['id'],
                        'table_ref' => 't_pengajuan_cuti',
                        'id_m_jenis_ds' => 4,
                        'nama_jenis_ds' => 'PERMOHONAN CUTI',
                        'id_m_jenis_layanan' => $master['id'],
                        'request' => json_encode($signatureProperties),
                        'url_file' => $path_file,
                        'url_image_ds' => null,
                        'random_string' => $randomString,
                        'created_by' => $this->general_library->getId(),
                        'nama_kolom_flag' => 'flag_ds_cuti',
                        'nip' => $dataCuti['nipbaru_ws'],
                        'id_t_nomor_surat' => $last_insert_nomor_surat,
                        'meta_data' => json_encode($resCuti),
                        'meta_view' => 'kepegawaian/V_SKPermohonanCuti',
                        'perihal' => $perihal,
                    ]);

                    $request_tte = [
                        'id_ref' => [$dataCuti['id']],
                        'table_ref' => 't_pengajuan_cuti',
                        // 'nik' => $input_post['nik'],
                        // 'passphrase' => $input_post['passphrase'],
                        'signatureProperties' => [$signatureProperties],
                        'file' => [
                            $fileBase64
                        ]
                    ];

                    $this->db->update('t_pengajuan_cuti', [
                        'url_sk' => $path_file,
                        'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                    ]);
                    
                    $this->db->insert('t_file_ds', [
                        'random_string' => $randomString,
                        'url' => $path_file,
                        'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                    ]);
                }
            } else {
                $reply .= '*DITOLAK*';
            }

            $reply .= ' oleh '.$progress['current']['nama_jabatan'].' pada '.formatDateNamaBulanWT($resp['response']['tanggal_verif']); // pilih dari progress untuk progress yang aktif
            // update progress cuti
            $this->db->where('id', $progress['current']['id'])
                    ->update('t_progress_cuti', $resp['response']);

            // send message to pegawai
            $cronWaPegawai = [
                'sendTo' => convertPhoneNumber($resp['cuti']['handphone']),
                'message' => trim($reply.FOOTER_MESSAGE_CUTI),
                'type' => 'text',
                'jenis_layanan' => 'Cuti'
            ];
            $this->db->insert('t_cron_wa', $cronWaPegawai);

            if($flag_reply_thankyou == 1){
               // balasan ucapan terima kasih
                $replyToVerifikator = "*[PERMOHONAN CUTI - ".$dataCuti['random_string']."]* \n\nTerima Kasih, balasan Anda sudah kami terima.";
                $cronWaVerifikator = [
                    'sendTo' => ($chat->from),
                    'message' => trim($replyToVerifikator.FOOTER_MESSAGE_CUTI),
                    'type' => 'text',
                    // 'ref_id' => $resp['cuti']['id'],
                    'jenis_layanan' => 'Cuti'
                ];
                $this->db->insert('t_cron_wa', $cronWaVerifikator);
            }
        }

        if($this->db->trans_status() == TRUE){
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
        }
    }

    public function checkIfReplyCuti($chat){
        $cuti = null;
        $result = null;
        $result['wa'] = $this->db->select('*')
                        ->from('t_cron_wa')
                        ->where('chatId', $chat->replyId)
                        ->where('jenis_layanan', 'Cuti')
                        ->order_by('created_date', 'desc')
                        ->limit(1)
                        ->get()->row_array();
        if($result['wa']){
            $result['cuti'] = $this->db->select('a.*, c.handphone, c.gelar1, c.gelar2, c.nama, d.nm_cuti, a.tanggal_mulai, a.tanggal_akhir')
                            ->from('t_pengajuan_cuti a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->join('db_pegawai.cuti d', 'a.id_cuti = d.id_cuti')
                            ->where('a.id', $result['wa']['ref_id'])
                            ->where('a.flag_active', 1)
                            ->get()->row_array();

            $result['progress'] = $this->loadProgressCuti($result['wa']['ref_id']);
        }
        return $result;
    }

    public function saveNohpVerifikatorCuti($id){
        $rs['code'] = 0;
        $rs['message'] = "";

        $data = $this->input->post();
        $this->db->where('id', $id)
                ->update('t_progress_cuti', [
                    'nohp' => $data['nohp']
                ]);

        return $rs;
    }

    public function resendMessage($id){
        $rs['code'] = 0;
        $rs['message'] = "";

        $this->db->trans_begin();

        $data = $this->db->select('a.*, b.id as id_t_cron_wa, b.message')
                        ->from('t_progress_cuti a')
                        ->join('t_cron_wa b', 'a.chatId = b.chatId')
                        ->join('t_pengajuan_cuti c', 'a.id_t_pengajuan_cuti = c.id')
                        ->where('a.id', $id)
                        ->get()->row_array();
        if($data){
            // $this->db->where('id', $data['id_t_cron_wa'])
            //         ->update('t_cron_wa', [
            //             'sendTo' => convertPhoneNumber($data['nohp']),
            //             'status' => null,
            //             'date_sending' => null,
            //             'date_sent' => null,
            //             'flag_sending' => 0,
            //             'flag_sent' => 0,
            //         ]);

            $this->db->where('id', $data['id'])
                    ->update('t_progress_cuti', [
                        'chatId' => null
                    ]);

            $this->db->insert('t_cron_wa', [
                'ref_id' => $data['id_t_pengajuan_cuti'],
                'type' => 'text',
                'sendTo' => convertPhoneNumber($data['nohp']),
                'message' => ($data['message']),
                'jenis_layanan' => 'Cuti',
                'table_state' => 't_progress_cuti',
                'column_state' => 'chatId',
                'id_state' => $data['id'],
            ]);

        } else {
            $rs['code'] = 1;
            $rs['message'] = "Data Tidak Ditemukan";
        }

        if($rs['code'] == 0){
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
        }

        return $rs;
    }

    public function loadProgressCuti($id){
        $result = null;
        $progress = $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.jabatan, c.id_jabatan_tambahan, d.date_sending, d.date_sent')
                        ->from('t_progress_cuti a')
                        ->join('m_user b', 'a.id_m_user_verifikasi = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->join('t_cron_wa d', 'a.chatId = d.chatId', 'left')
                        ->where('a.flag_active', 1)
                        ->where('a.id_t_pengajuan_cuti', $id)
                        ->order_by('a.urutan')
                        ->get()->result_array();
        if($progress){
            $i = 0;
            $flag_ditolak = 0;
            foreach($progress as $p){
                if($flag_ditolak == 1){
                    break;
                }
                $result[$i] = $p;
                // if($p['flag_verif'] == 0){
                //     $result[$i]['keterangan'] = 'Menunggu ';
                // }
                $result[$i]['keterangan'] = 'Verifikasi '.$p['nama_jabatan'];
                if($p['flag_diterima'] == 2){ //diterima
                    $result[$i]['keterangan'] = 'Ditolak oleh '.$p['nama_jabatan'];
                }
                if($i == count($progress)-1){
                    $result[$i]['keterangan'] = 'Digital Signature oleh '.$p['nama_jabatan'];
                }

                if($p['flag_verif'] == 1){
                    $result[$i]['keterangan'] .= ' pada '.formatDateNamaBulanWT($p['tanggal_verif']);
                }

                $result[$i]['bg-color'] = 'yellow';
                $result[$i]['font-color'] = 'black';
                $result[$i]['icon'] = 'fa-spin fa-spinner';
                if($p['flag_diterima'] == 1){ //diterima
                    $result[$i]['bg-color'] = 'green';
                    $result[$i]['font-color'] = 'white';
                    $result[$i]['icon'] = 'fa-check';
                } else if($p['flag_diterima'] == 2){ //ditolak
                    $flag_ditolak = 1;
                    $result[$i]['keterangan'] .= '<br>(Keterangan: "'.$p['keterangan_verif'].'")';
                    $result[$i]['bg-color'] = 'red';
                    $result[$i]['font-color'] = 'white';
                    $result[$i]['icon'] = 'fa-times';
                }

                $i++;
            }
        }

        return $result;
    }

    public function submitPermohonanCuti(){
        $data = $this->input->post();
        $res['code'] = 0;
        $res['message'] = "Permohonan Cuti Berhasil";
        $res['data'] = null;
        $total_year = 3;
        $tahunIni = date('Y');
        $count = 0;
        $this->db->trans_begin();
        if($data['id_cuti'] == "00"){
            for($i = $total_year-1; $i >= 0; $i--){
                $tahun = $tahunIni - $i;
                if($data['sisa_cuti'][$tahun] < floatval($data['keterangan_cuti'][$tahun])){
                    $res['code'] = 1;
                    $res['message'] = "Keterangan Cuti tahun ".$tahun." melebihi Sisa Cuti";
                    break;
                } else {
                    $count += floatval($data['keterangan_cuti'][$tahun]);
                    if($count > floatval($data['lama_cuti'])){
                        $res['code'] = 1;
                        $res['message'] = "Akumulasi Keterangan Cuti melebihi jumlah Lama Cuti";
                        break;
                    } else if($tahun == $tahunIni && $count != floatval($data['lama_cuti'])){
                        $res['code'] = 1;
                        $res['message'] = "Akumulasi Keterangan Cuti kurang dari jumlah Lama Cuti";
                        break;
                    }
                }

                $new_sisa = $data['sisa_cuti'][$tahun] - floatval($data['keterangan_cuti'][$tahun]);
                $this->db->where('id_m_user', $this->general_library->getId())
                        ->where('tahun', $tahun)
                        ->update('t_sisa_cuti', ['sisa' => $new_sisa]);
            }
            if($res['code'] != 0){
                $this->db->trans_rollback();
                return $res;
            }
        }
        $res = $this->countJumlahHariCuti($data);
        if($res['code'] == 0){
            $filename = null;
            if($data['id_cuti'] != "00" && $data['id_cuti'] != "10"){
                if($_FILES['surat_pendukung']['type'] != "application/pdf"){
                    $res['code'] = 0;
                    $res['message'] = "Surat Pendukung yang diupload harus dalam format Pdf";
                } else {
                    $config['upload_path'] = './assets/dokumen_pendukung_cuti';
                    $config['allowed_types'] = '*';
                    $_FILES['surat_pendukung']['name'] = $this->general_library->getUserName().'_'.date('Ymdhis').'.pdf'; 
                    $this->load->library('upload',$config);
                    if($this->upload->do_upload('surat_pendukung')){
                        $upload = $this->upload->data();
                        $filename = $upload['file_name'];
                    } else {
                        $res['code'] = 1;
                        $res['message'] = "Data Gagal Disimpan.\n".$this->upload->display_errors();
                    }
                }
            }
            if($res['code'] == 0){
                $randomString = generateRandomString(10, 1, 't_pengajuan_cuti');

                $data['surat_pendukung'] = $filename;
                $data['created_by'] = $this->general_library->getId();
                $data['id_m_user'] = $this->general_library->getId();
                $data['tanggal_mulai'] = date('Y-m-d', strtotime($data['tanggal_mulai']));
                $data['tanggal_akhir'] = date('Y-m-d', strtotime($data['tanggal_akhir']));
                $data['lama_cuti'] = floatval($data['lama_cuti']);
                $data['random_string'] = $randomString;
                $keterangan_cuti = $data['keterangan_cuti'];
                unset($data['keterangan_cuti']);
                unset($data['sisa_cuti']);
                $this->db->insert('t_pengajuan_cuti', $data);
                $insert_id = $this->db->insert_id();
                $total_year = 3;
                $tahunIni = date('Y');
                for($i = $total_year-1; $i >= 0; $i--){
                    $tahun = $tahunIni - $i;
                    $this->db->insert('t_meta_cuti',
                        [
                            'id_t_penggunaan_cuti' => $insert_id,
                            'tahun' => $tahun,
                            'jumlah' => $keterangan_cuti[$tahun],
                            'created_by' => $this->general_library->getId()
                        ]
                    );
                }

                // $atasan = $this->db->select('a.*')
                //                 ->from('db_pegawai.pegawai a')
                //                 ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                //                 ->where('c.kepalaskpd', 1)
                //                 ->where('a.skpd', $this->general_library->getIdUnitKerjaPegawai())
                //                 ->get()->row_array();

                $id_m_user = $this->general_library->getId();
                // $id_m_user = 555;
                
                $pegawai = $this->kinerja->getAtasanPegawai(null, $id_m_user, 1);
                $progressCuti = $this->buildProgressCuti($pegawai, $insert_id, $id_m_user);
                // dd(json_encode($progressCuti));
                // kirim pesan yang bisa langsung direply untuk persetujuan
                // simpan dpe messageId untuk reply
                if($progressCuti){
                    foreach($progressCuti as $pc){
                        $this->db->insert('t_progress_cuti', $pc);
                        if($pc['urutan'] == '1'){
                            $last_id = $this->db->insert_id();
                            $this->db->where('id', $insert_id)
                            ->update('t_pengajuan_cuti', [
                                'status_pengajuan_cuti' => 'Verifikasi '.$pc['nama_jabatan'],
                                'id_t_progress_cuti' => $last_id
                            ]);

                            $master = $this->db->select('*')
                                            ->from('db_pegawai.cuti')
                                            ->where('id_cuti', $data['id_cuti'])
                                            ->get()->row_array();

                            $pada_tanggal = formatDateNamaBulan($data['tanggal_mulai']);
                            if($data['tanggal_mulai'] != $data['tanggal_akhir']){
                                $pada_tanggal .= " sampai ".formatDateNamaBulan($data['tanggal_akhir']);
                            }
                            $message = "*[PERMOHONAN CUTI - ".$randomString."]*\n\nSelamat ".greeting().", pegawai atas nama: ".$this->general_library->getNamaUser()." telah mengajukan Permohonan ".$master['nm_cuti']." selama ".$data['lama_cuti']." hari pada ".$pada_tanggal.". \n\nBalas pesan ini dengan *'YA'* untuk menyetujui atau *'Tidak'* untuk menolak.";
                            $sendTo = convertPhoneNumber($progressCuti[0]['nohp']);
                            // $this->maxchatlibrary->sendText($sendTo, $message, 0, 0);
                            $cronWa = [
                                'sendTo' => $sendTo,
                                'message' => $message.FOOTER_MESSAGE_CUTI,
                                'type' => 'text',
                                'ref_id' => $insert_id,
                                'jenis_layanan' => 'Cuti',
                                'table_state' => 't_progress_cuti',
                                'column_state' => 'chatId', 
                                'id_state' => $last_id
                            ];
                            $this->db->insert('t_cron_wa', $cronWa);
                        }
                    }
                } else {
                    $res['code'] = 1;
                    $res['message'] = "Terjadi Kesalahan, Data Atasan tidak ditemukan.";
                }
            }
        }
        if($res['code'] == 0){
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
        }
        return $res;
    }

    public function buildProgressCuti($pegawai, $insert_id, $id_m_user){
        $result = [];
        $kepalabkpsdm = $this->db->select('a.*, b.id as id_m_user, c.nama_jabatan')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_Ws = b.username')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                ->where('c.kepalaskpd', 1)
                                ->where('a.skpd', '4018000')
                                ->where('b.flag_active', 1)
                                ->get()->row_array();

        $thisuser = $this->db->select('a.*, b.id as id_m_user, d.id_unitkerja, d.id_unitkerjamaster, d.nm_unitkerja, c.nama_jabatan, a.handphone')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_Ws = b.username', 'left')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                                ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja', 'left')
                                ->where('b.id', $id_m_user)
                                ->get()->row_array();

        $progress = null;
        if($pegawai['atasan']['id_unitkerja'] == '4018000' && stringStartWith('Kepala', $thisuser['nama_jabatan'])){ // jika kabid di bkpsdm
            unset($pegawai['atasan']);
            unset($pegawai['kepala']);
            unset($pegawai['kadis']);
            unset($pegawai['sek']);
        } else if($pegawai['kepala']['id_unitkerja'] == '4018000'){ // jika pegawai bkpsdm
            unset($pegawai['kepala']);
            unset($pegawai['sek']);
        } else {
            // if($pegawai['atasan']['id'] == $thisuser['id_m_user']){ //jika atasan sama dengan id userloggedin, hapus atasan
            //     unset($pegawai['atasan']);
            // }
            if($pegawai['atasan']['id'] == $pegawai['kepala']['id'] && $pegawai['kepala']['id'] == $pegawai['kadis']['id']){
                //jika atasan sama dengan kepala sama dengan kadis, hapus atasan dan kepala
                unset($pegawai['atasan']);
                unset($pegawai['kepala']);
            } else if($pegawai['atasan']['id'] == $pegawai['kepala']['id']){
                //jika atasan dan sama dengan kepala, hapus atasan
                unset($pegawai['atasan']);
            } else if($pegawai['atasan']['id'] == $pegawai['kadis']['id']){
                //jika atasan dan sama dengan kadis, hapus atasan
                unset($pegawai['atasan']);
            } else if($pegawai['atasan']['id'] == $pegawai['sek']['id']){
                //jika atasan dan sama dengan sek, hapus atasan
                unset($pegawai['atasan']);
            }
        }

        $new_progress = null;
        if($pegawai){
            foreach($pegawai as $peg){
                if($peg && $peg['id'] != $thisuser['id_m_user'] && $peg['id'] != $kepalabkpsdm['id_m_user']){
                    $new_progress[] = $peg;
                }
            }

            $i = 0;
            if($new_progress){
                foreach($new_progress as $np){
                    $result[$i]['id_m_user_verifikasi'] = $np['id'];
                    $result[$i]['nama_jabatan'] = $np['nama_jabatan_tambahan'] ? $np['nama_jabatan_tambahan'] : $np['nama_jabatan'];
                    $result[$i]['nohp'] = $np['handphone'];
                    $i++;
                }
            }
        }

        return $this->pelengkapDataProgressCuti($result, $insert_id, $kepalabkpsdm);
    }

    public function pelengkapDataProgressCuti($list, $insert_id, $kepalabkpsdm){
        $result = null;
        $urutan = 1;
        $i = 0;
        foreach($list as $l){
            $result[$i] = $l;
            $result[$i]['created_by'] = $this->general_library->getId();
            $result[$i]['id_t_pengajuan_cuti'] = $insert_id;
            $result[$i]['urutan'] = $urutan++;
            $i++;
        }

        $last = $i++;
        $result[$last]['id_m_user_verifikasi'] = $kepalabkpsdm['id_m_user'];
        $result[$last]['nama_jabatan'] = $kepalabkpsdm['nama_jabatan'];
        $result[$last]['id_t_pengajuan_cuti'] = $insert_id;
        $result[$last]['nohp'] = $kepalabkpsdm['handphone'];
        $result[$last]['created_by'] = $this->general_library->getId();
        $result[$last]['urutan'] = $urutan++;

        return $result;
    }


    public function deletePermohonanCuti($id, $flag_delete_record = 1){
        $res['code'] = 0;
        $res['message'] = 'OK';
        $res['data'] = null; 
        
        $this->db->trans_begin();

        $data = $this->db->select('*')
                        ->from('t_pengajuan_cuti')
                        ->where('id', $id)
                        ->get()->row_array();

        $meta_cuti = null;
        $list_meta_cuti = $this->db->select('*')
                            ->from('t_meta_cuti')
                            ->where('id_t_penggunaan_cuti', $id)
                            ->get()->result_array();

        // if($list_meta_cuti){
            foreach($list_meta_cuti as $lmc){
                $meta_cuti[$lmc['tahun']] = $lmc;
            }
        // }
        $sisa_cuti = $this->db->select('*')
                            ->from('t_sisa_cuti')
                            ->where('id_m_user', $data['id_m_user'])
                            ->where('flag_active', 1)
                            ->get()->result_array();
        // if($sisa_cuti){
            foreach($sisa_cuti as $sc){
                $this->db->where('id', $sc['id'])
                        ->update('t_sisa_cuti', [
                            'sisa' => floatval($sc['sisa']) + floatval($meta_cuti[$sc['tahun']]['jumlah']),
                            'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                        ]);
            }
        // }

        if($flag_delete_record == 1){
            $this->db->where('id', $id)
                ->update('t_pengajuan_cuti', ['flag_active' => 0, 'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0]);
        }

        // $this->db->where('id_t_penggunaan_cuti', $id)
        //         ->update('t_meta_cuti', ['flag_active' => 0, 'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0]);

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

    public function loadRiwayatPermohonanCuti(){
        $result = null;
        $riwayat = $this->db->select('a.*, a.status_pengajuan_cuti, c.nm_cuti, d.id as id_progress_cuti')
                    ->from('t_pengajuan_cuti a')
                    // ->join('m_status_pengajuan_cuti b', 'a.id_m_status_pengajuan_cuti = b.id')
                    ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti')
                    ->join('t_progress_cuti d', 'd.id_t_pengajuan_cuti = a.id AND d.flag_verif = 1', 'left')
                    ->where('id_m_user', $this->general_library->getId())
                    ->where('a.flag_active', 1)
                    ->order_by('created_date', 'desc')
                    ->group_by('a.id')
                    ->get()->result_array();

        $list_id = null;
        if($riwayat){
            foreach($riwayat as $rw){
                $list_id[] = $rw['id'];
        //         if($rw['id_m_status_pengajuan_cuti'] == 4 && $rw['url_sk'] == null){
        //             $rw['nama_status'] .= ', menuggu DS SK';
        //         }

        //         if($rw['url_sk'] != null){
        //             // $rw['id_m_status_pengajuan_cuti'] = 6;
        //             $rw['nama_status'] = 'Selesai';
        //         }

                $result[$rw['id']] = $rw;
        //         $result[$rw['id']]['detail'] = null;
        //         $progress[0]['keterangan'] = "PENGAJUAN, menunggu Verifikasi Atasan";
        //         $progress[0]['icon'] = "fa fa-spin fa-spinner";
        //         $progress[0]['color'] = "yellow";
        //         $progress[0]['font-color'] = "black";
        //         if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 2){
        //             $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
        //             $progress[1]['icon'] = "fa fa-spin fa-spinner";
        //             $progress[1]['color'] = "yellow";
        //             $progress[1]['font-color'] = "black";
        //         } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 3){
        //             $progress[1]['keterangan'] = "DITOLAK OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan'])." : ".$result[$rw['id']]['keterangan_verifikasi_atasan'];
        //             $progress[1]['icon'] = "fa fa-times";
        //             $progress[1]['color'] = "red";
        //             $progress[1]['font-color'] = "white";
        //         }

        //         if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 4){
        //             $progress[1]['icon'] = "fa fa-check";
        //             $progress[1]['color'] = "green";
        //             $progress[1]['font-color'] = "white";
        //             $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
        //             if($result[$rw['id']]['url_sk']){
        //                 $progress[2]['keterangan'] = "VERIFIKASI KEPALA BKPSDM SELESAI pada ".formatDateNamaBulanWT($result[$rw['id']]['updated_date']).". SK Cuti sudah dapat diunduh.";
        //                 $progress[2]['icon'] = "fa fa-check";
        //                 $progress[2]['color'] = "green";
        //                 $progress[2]['font-color'] = "white";
        //             } else {
        //                 $progress[2]['keterangan'] = "DITERIMA OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
        //                 $progress[2]['icon'] = "fa fa-spin fa-spinner";
        //                 $progress[2]['color'] = "yellow";
        //                 $progress[2]['font-color'] = "black";
        //             }
        //         } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 5){
        //             $progress[2]['keterangan'] = "DITOLAK OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm'])." : ".$result[$rw['id']]['keterangan_verifikasi_kepala_bkpsdm'];
        //             $progress[2]['icon'] = "fa fa-times";
        //             $progress[2]['color'] = "red";
        //             $progress[2]['font-color'] = "white";
        //         } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 6){
        //             $progress[1]['icon'] = "fa fa-check";
        //             $progress[1]['color'] = "green";
        //             $progress[1]['font-color'] = "white";
        //             $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi BKPSDM";
        
        //             $progress[2]['keterangan'] = "SELESAI VERIFIKASI BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
        //             $progress[2]['icon'] = "fa fa-check";
        //             $progress[2]['color'] = "green";
        //             $progress[2]['font-color'] = "white";
        
        //             $progress[3]['keterangan'] = "SK SUDAH SELESAI DS PADA ".formatDateNamaBulanWT($result[$rw['id']]['updated_date']);
        //             $progress[3]['icon'] = "fa fa-check";
        //             $progress[3]['color'] = "green";
        //             $progress[3]['font-color'] = "white";
        //         }

        //         if($result[$rw['id']]['id_m_status_pengajuan_cuti'] != 1){
        //             $progress[0]['icon'] = "fa fa-check";
        //             $progress[0]['color'] = "green";
        //             $progress[0]['font-color'] = "white";
        //         }
                
        //         $result[$rw['id']]['progress'] = $progress;
            }
        }
        $meta = null;
        if($list_id){
            $meta = $this->db->select('a.*')
                        ->from('t_meta_cuti a')
                        ->where_in('a.id_t_penggunaan_cuti', $list_id)
                        ->where('flag_active', 1)
                        ->order_by('tahun', 'desc')
                        ->get()->result_array();
            if($meta){
                foreach($meta as $m){
                    if(isset($result[$m['id_t_penggunaan_cuti']])){
                        $result[$m['id_t_penggunaan_cuti']]['detail'][$m['tahun']] = $m;
                    }
                }
            }
        }

        return $result;
    }

    public function countJumlahHariCuti($data){
		$res['code'] = 0;
		$res['message'] = 'Permohonan Cuti Berhasil';
		$res['data'] = null;
        if($data['id_cuti'] == "00"){
            $startDate = strtotime($data['tanggal_mulai']);
            $endDate = strtotime($data['tanggal_akhir']);
            $today = strtotime(date('d-m-Y'));
            if($endDate < $startDate){
                $res['code'] = 1;
                $res['message'] = 'Tanggal Akhir tidak boleh melebihi Tanggal Mulai';
            } else if($data['id_cuti'] == 0 && $startDate < $today){
                $res['code'] = 1;
                $res['message'] = 'Tanggal Mulai tidak boleh kurang dari hari ini';
            } else if($startDate == $today){
                $res['code'] = 1;
                $res['message'] = 'Tanggal Mulai tidak boleh sama dengan tanggal hari ini';
            } else {
                $res['data'] = countHariKerjaDateToDate($data['tanggal_mulai'], $data['tanggal_akhir']);
            }
        }
		return $res;
	}

    public function searchPermohonanCuti(){
        $data = $this->input->post();
        if(!isset($data['id_unitkerja'])){
            // $data['id_unitkerja'] = $this->general_library->getIdUnitKerjaPegawai();
            $data['id_unitkerja'] = 0;
        }

        // if(!$this->general_library->isKepalaBkpsdm() 
        // || !$this->general_library->isAdminAplikasi() 
        // || !$this->general_library->isHakAkses('verifikasi_permohonan_cuti') 
        // || !$this->general_library->isProgrammer()){
    	// 	$data['unitkerja'] = $this->general->getGroupUnitKerja($this->general_library->getIdUnitKerjaPegawai());
        // }

        $this->db->select('a.*, c.nm_cuti, e.gelar1, e.nama, e.gelar2, e.nipbaru_ws, f.nm_unitkerja, a.status_pengajuan_cuti, h.id_m_user_verifikasi')
                ->from('t_pengajuan_cuti a')
                ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti')
                ->join('m_user d', 'a.id_m_user = d.id')
                ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                ->join('t_progress_cuti g', 'a.id = g.id_t_pengajuan_cuti', 'left')
                ->join('t_progress_cuti h', 'a.id_t_progress_cuti = h.id', 'left')
                ->where('a.flag_active', 1)
                ->where('MONTH(a.created_date)', $data['bulan'])
                ->where('YEAR(a.created_date)', $data['tahun'])
                ->group_by('a.id')
                ->order_by('created_date', 'asc');

        if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
            $this->db->where('e.skpd', $data['id_unitkerja']);
        }

        if(!$this->general_library->isProgrammer() && !$this->general_library->isKepalaBkpsdm()){ 
            // jika bukan programmer ato bukan kaban, cari yang hanya bisa diverifikasi
            $this->db->where('g.id_m_user_verifikasi', $this->general_library->getId());
        }

        $result = $this->db->get()->result_array();
        // dd($result);
        
        usort($result, function($a, $b) {
            if ($a['id_m_user_verifikasi'] != $this->general_library->getId()) {
                return 1;
            } elseif ($a['id_m_user_verifikasi'] == $this->general_library->getId()) {
                return -1;
            }
            return 0;
        });
        // if(isset($data['id_m_status_pengajuan_cuti']) && $data['id_m_status_pengajuan_cuti'] != "0"){
        //     $this->db->where('a.id_m_status_pengajuan_cuti', $data['id_m_status_pengajuan_cuti']);
        // }

        // if($this->general_library->isKepalaPd() && !$this->general_library->isKepalaBkpsdm()){
        //     $this->db->where('e.skpd', $this->general_library->getUnitKerjaPegawai());
        // }

        if($this->general_library->isProgrammer()){ // jika programmer, kirim semua data
            return $result;
        }

        if($result){
            $temp = $result;
            $result = null;
            $result['list_bisa_verif'] = null;
            $result['list_tidak_bisa_verif'] = null;

            foreach($temp as $t){
                if($t['id_m_user_verifikasi'] == $this->general_library->getId()){
                    $result['list_bisa_verif'][] = $t;
                } else {
                    $result['list_tidak_bisa_verif'][] = $t;
                }
            }
        }

        return $result;
    }

    public function authVerifEncryptCuti($enc_string){
        $res['code'] = 0;
        $res['message'] = "ok";
        $res['data'] = null;
        $res['kepalapd'] = false;
        $res['kepalabkpsdm'] = false;
        $res['id_unitkerja'] = null;
        $decrypt = simpleDecrypt($enc_string);
        $explode = explode("-", $decrypt);
        // dd($decrypt);
        if(count($explode) <= 1){
            $res['code'] = 1;
            $res['message'] = 'Link yang Anda gunakan tidak valid';
        } else {
            $res['data'] = $this->loadDetailCutiVerif($explode[1]);
            if(!$res['data']){
                $res['code'] = 1;
                $res['message'] = 'Link yang Anda gunakan tidak valid';
            } else {
                $user = $this->db->select('a.*, c.kepalaskpd')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                ->where('a.nipbaru_ws', $explode[0])
                                ->get()->row_array();
                if((($user['skpd'] == $res['data']['id_unitkerja']) || ($user['skpd'] == ID_UNITKERJA_BKPSDM)) && $user['kepalaskpd'] == 1){
                    //jika kepala PD atau kepala BKPSDM maka valid
                    if($user['skpd'] == $res['data']['id_unitkerja'] && $user['kepalaskpd'] == 1){
                        $res['kepalapd'] = true;
                    }

                    if($user['skpd'] == ID_UNITKERJA_BKPSDM && $user['kepalaskpd'] == 1){
                        $res['kepalabkpsdm'] = true;
                    }

                    $res['id_unitkerja'] = $user['skpd'];
                } else {
                    $res['code'] = 1;
                    $res['message'] = 'Link yang Anda gunakan tidak valid';
                }
            }
        }
        
        return $res;
    }

    public function loadDetailCutiVerif($id){
        $result['detail'] = null;
        $meta = null;
        $result = $this->db->select('a.*, c.nm_cuti, e.gelar1, e.nama, e.gelar2, e.nipbaru_ws, f.nm_unitkerja,
                g.nama_jabatan, h.nm_pangkat, d.id as id_m_user, g.eselon, f.id_unitkerja, i.id_m_user_verifikasi')
                ->from('t_pengajuan_cuti a')
                ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti', 'left')
                ->join('m_user d', 'a.id_m_user = d.id', 'left')
                ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws', 'left')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja', 'left')
                ->join('db_pegawai.jabatan g', 'e.jabatan = g.id_jabatanpeg', 'left')
                ->join('db_pegawai.pangkat h', 'e.pangkat = h.id_pangkat', 'left')
                ->join('t_progress_cuti i', 'a.id_t_progress_cuti = i.id', 'left')
                ->where('a.flag_active', 1)
                ->where('a.id', $id)
                ->get()->row_array();

        if($result){
            $meta = $this->db->select('a.*')
                        ->from('t_meta_cuti a')
                        ->where('a.id_t_penggunaan_cuti', $result['id'])
                        // ->where('flag_active', 1)
                        ->order_by('tahun', 'desc')
                        ->get()->result_array();
        }

        if($meta){
            $result['detail'] = $meta;
        }

        return $result;
    }

    public function getDetailCuti(){
        $data = $this->db->select('a.*, b.nm_cuti, d.handphone, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat,
                        f.nama_jabatan, g.nm_unitkerja, g.id_unitkerja')
                        ->from('t_pengajuan_cuti a')
                        ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                        ->join('m_user c', 'c.id = a.id_m_user')
                        ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                        ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                        ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg')
                        ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                        ->where('a.id', 7)
                        ->get()->row_array();
        return $data;
    }

    public function saveVerifikasiPermohonanCuti($status, $id, $kepalapd = 0, $kepalabkpsdm = 0){
        $this->db->trans_begin();

        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $res['status'] = null;
        $data_verif = $this->input->post();
        
        $data = $this->db->select('a.*, b.nm_cuti, d.handphone, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat,
                        f.nama_jabatan, g.nm_unitkerja, g.id_unitkerja, a.tanggal_mulai, a.tanggal_akhir')
                        ->from('t_pengajuan_cuti a')
                        ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                        ->join('m_user c', 'c.id = a.id_m_user')
                        ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username', 'left')
                        ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat', 'left')
                        ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg', 'left')
                        ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja', 'left')
                        ->where('a.id', $id)
                        ->get()->row_array();

        $res['data'] = $data;
        $res['progress'] = $this->getProgressCutiAktif($id);

        if($res['progress']){
            $update_data_pengajuan = null;
            if($res['progress']['current']['jabatan'] == ID_JABATAN_KABAN_BKPSDM){
                $res['code'] = 1;
                $res['message'] = "Silahkan melakukan Digital Signature untuk Verifikasi Permohonan Cuti berikut.";
            } else if($res['progress']['current']['id_m_user_verifikasi'] == $this->general_library->getId()){
                $reply = "*[PERMOHONAN CUTI - ".$data['random_string']."]*\n\nSelamat ".greeting().", \nYth. ".getNamaPegawaiFull($data).", permohonan ".$data['nm_cuti']." Anda telah ";
                if($status == 1){ // jika diterima
                    $reply .= "*DITERIMA*";
                    $update_data_pengajuan = [
                        'status_pengajuan_cuti' => $res['progress']['next']['keterangan'],
                        'id_t_progress_cuti' => $res['progress']['next']['id']
                    ];
                    // jika masih ada next verifikator
                    if($res['progress']['next']){
                        $pada_tanggal = formatDateNamaBulan($data['tanggal_mulai']);
                        if($data['tanggal_mulai'] != $data['tanggal_akhir']){
                            $pada_tanggal .= " sampai ".formatDateNamaBulan($data['tanggal_akhir']);
                        }
                        $replyToNextVerifikator = "*[PERMOHONAN CUTI - ".$data['random_string']."]*\n\nSelamat ".greeting().", pegawai atas nama: ".getNamaPegawaiFull($data)." telah mengajukan Permohonan ".$data['nm_cuti']." selama ".$data['lama_cuti']." hari pada ".$pada_tanggal.". \n\nBalas pesan ini dengan *'YA'* untuk menyetujui atau *'Tidak'* untuk menolak.";
                        // $replyToNextVerifikator = "*[PERMOHONAN CUTI - ".$data['random_string']."]*\n\nSelamat ".greeting().", pegawai atas nama: ".getNamaPegawaiFull($data)." telah mengajukan Permohonan ".$data['nm_cuti'].". \n\nBalas pesan ini dengan *'YA'* untuk menyetujui atau *'Tidak'* untuk menolak.";
                        if($res['progress']['next']['jabatan'] == ID_JABATAN_KABAN_BKPSDM){ // jika next kaban, buat nods SK Cuti
                            $path_file = 'arsipcuti/nods/CUTI_'.$res['data']['nipbaru_ws'].'_'.date("Y", strtotime($res['data']['created_date'])).'_'.date("m", strtotime($res['data']['created_date'])).'_'.date("d", strtotime($res['data']['created_date'])).'.pdf';
                            $update['url_sk_temp'] = $path_file;
                            // dd($path_file);
                            $mpdf = new \Mpdf\Mpdf([
                                'format' => 'Legal-P',
                                // 'debug' => true
                            ]);
                            $html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $res, true);
                            $mpdf->WriteHTML($html);
                            $mpdf->showImageErrors = true;
                            $mpdf->Output($path_file, 'F');
                            $this->db->where('id', $data['id'])
                                        ->update('t_pengajuan_cuti', $update);
                        }

                        $cronWaNextVerifikator = [
                            'sendTo' => convertPhoneNumber($res['progress']['next']['nohp']),
                            'message' => trim($replyToNextVerifikator.FOOTER_MESSAGE_CUTI),
                            'type' => 'text',
                            'ref_id' => $data['id'],
                            'jenis_layanan' => 'Cuti',
                            'table_state' => 't_progress_cuti',
                            'column_state' => 'chatId',
                            'id_state' => $res['progress']['next']['id']
                        ];
                        $this->db->insert('t_cron_wa', $cronWaNextVerifikator);
                    }
                } else if($status == 0){ // jika ditolak
                    $reply .= "*DITOLAK*";
                    $update_data_pengajuan = [
                        'status_pengajuan_cuti' => 'Ditolak oleh'.$res['progress']['current']['nama_jabatan']
                    ];
                }
                $reply .= ' oleh '.$res['progress']['current']['nama_jabatan'].' pada '.formatDateNamaBulanWT(date('Y-m-d H:i:s')); // pilih dari progress untuk progress yang aktif
                if($res['code'] == 0){
                    if($update_data_pengajuan){
                        $this->db->where('id', $data['id'])
                                ->update('t_pengajuan_cuti', $update_data_pengajuan);
                    }

                    $cronWaPegawai = [
                        'sendTo' => convertPhoneNumber($data['handphone']),
                        'message' => trim($reply.FOOTER_MESSAGE_CUTI),
                        'type' => 'text',
                        'ref_id' => $data['id'],
                        'jenis_layanan' => 'Cuti'
                    ];
                    $this->db->insert('t_cron_wa', $cronWaPegawai);

                    $this->db->where('id', $res['progress']['current']['id'])
                                ->update('t_progress_cuti', [
                                    'flag_verif' => 1,
                                    'flag_diterima' => $status,
                                    'tanggal_verif' => date('Y-m-d H:i:s'),
                                    'keterangan_verif' => trim($data_verif['keterangan_verif'])
                                ]);
                }
            } else {
                $res['code'] == 1;
                $res['message'] == 'Maaf, Anda tidak dapat melakukan verifikasi pada tahap ini'; 
                $res['data'] == null;
            }
        } else {
            $res['code'] == 1;
            $res['message'] == 'Terjadi Kesalahan';
            $res['data'] == null;
        }

        if($res['code'] == 1){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function batalVerifikasiPermohonanCuti($id, $kepalapd = 0, $kepalabkpsdm = 0){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $flag_kurang_jatah_cuti = 0;

        $result = $this->db->select('a.*, b.nm_cuti, d.handphone, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat,
                        f.nama_jabatan, g.nm_unitkerja, g.id_unitkerja, c.id as id_m_user')
                        ->from('t_pengajuan_cuti a')
                        ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                        ->join('m_user c', 'c.id = a.id_m_user')
                        ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                        ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                        ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg')
                        ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                        ->where('a.id', $id)
                        ->get()->row_array();
                        
        $message_to_pegawai = "*[PERMOHONAN CUTI - ".$result['random_string']."]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($result)."\nVerifikasi Permohonan Pengajuan ".$result['nm_cuti']." Anda telah dibatalkan oleh ";

        // $result = $this->db->select('*')
        //                 ->from('t_pengajuan_cuti')
        //                 ->where('id', $id)
        //                 ->get()->row_array();

        if($this->general_library->isKepalaBkpsdm() || $kepalabkpsdm == 1){
            if($result['id_m_status_pengajuan_cuti'] == 4 || $result['id_m_status_pengajuan_cuti'] == 5){
                $update['id_m_status_pengajuan_cuti'] = 2;
                $update['id_m_user_verifikasi_kepala_bkpsdm'] = null;
                $update['tanggal_verifikasi_kepala_bkpsdm'] = null;
                $update['keterangan_verifikasi_kepala_bkpsdm'] = "Pembatalan Verifikasi";
                $message_to_pegawai .= "*Kepala BKPSDM*";
                if($result['id_m_status_pengajuan_cuti'] == 5){
                    $flag_kurang_jatah_cuti = 1;
                }
            } else {
                $res['code'] = 1;
                $res['message'] = 'Pembatalan Verifikasi tidak dapat dilakukan pada tahap ini';
            }
        } else if($this->general_library->isKepalaPd() || $kepalapd == 1){
            if($result['id_m_status_pengajuan_cuti'] == 2 || $result['id_m_status_pengajuan_cuti'] == 3){
                $update['id_m_status_pengajuan_cuti'] = 1;
                $update['id_m_user_verifikasi_atasan'] = null;
                $update['tanggal_verifikasi_atasan'] = null;
                $update['keterangan_verifikasi_atasan'] = "Pembatalan Verifikasi";
                $message_to_pegawai .= "*Kepala PD Anda*";
                if($result['id_m_status_pengajuan_cuti'] == 5){
                    $flag_kurang_jatah_cuti = 1;
                }
            } else {
                $res['code'] = 1;
                $res['message'] = 'Pembatalan Verifikasi tidak dapat dilakukan pada tahap ini';
            }
        }

        if($res['code'] == 0){
            if($flag_kurang_jatah_cuti == 1){
                $list_meta_cuti = null;
                $meta_cuti = $this->db->select('*')
                                ->from('t_meta_cuti')
                                ->where('id_t_penggunaan_cuti', $id)
                                ->get()->result_array();

                $list_sisa_cuti = null;
                $sisa_cuti = $this->db->select('*')
                                ->from('t_sisa_cuti')
                                ->where('id_m_user', $result['id_m_user'])
                                ->get()->result_array();

                foreach($sisa_cuti as $sc){
                    $list_sisa_cuti[$sc['tahun']] = $sc;
                }

                foreach($meta_cuti as $mc){
                    $new_sisa_cuti = floatval($list_sisa_cuti[$mc['tahun']]['sisa']) - floatval($mc['jumlah']);
                    $this->db->where('id', $list_sisa_cuti[$mc['tahun']]['id'])
                                ->update('t_sisa_cuti', [
                                    'sisa' => $new_sisa_cuti
                                ]);
                }
            }

            $this->db->where('id', $id)
                    ->update('t_pengajuan_cuti', $update);

            // $this->maxchatlibrary->sendText($result['handphone'], $message_to_pegawai.FOOTER_MESSAGE_CUTI, 0, 0);
            $cronWa = [
                'sendTo' => convertPhoneNumber($result['handphone']),
                'message' => $message_to_pegawai.FOOTER_MESSAGE_CUTI,
                'type' => 'text'
            ];
            $this->general->saveToCronWa($cronWa);
        }

        return $res;
    }

    public function dsBulk($params){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        // $params['list_checked'] = [10, 13];
        // dd('asd');
        
        $list_checked_data = null;
        $this->db->trans_begin();

        // if($params['jenis_layanan'] == 4){ // permohonan cuti
        //     $batchId = generateRandomString(10, 1, 't_cron_tte_bulk_ds'); 
        //     // $hash_tte = $this->ttelib->hash();
            
        //     $list_data = $this->db->select('a.*, b.nm_cuti, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat, f.nama_jabatan, g.nm_unitkerja,
        //             g.id_unitkerja, b.id_cuti, c.id as id_m_user, d.id_peg, d.handphone, a.id as id_t_pengajuan_cuti')
        //             ->from('t_pengajuan_cuti a')
        //             ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
        //             ->join('m_user c', 'c.id = a.id_m_user')
        //             ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
        //             ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
        //             ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg', 'left')
        //             ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
        //             ->where_in('a.id', $params['list_checked'])
        //             ->where('a.flag_active', 1)
        //             ->order_by('a.id')
        //             ->get()->result_array(); 

        //     if(!$list_data){
        //         $res['code'] = 1;
        //         $res['message'] = 'Terjadi Kesalahan';
        //         return $res;
        //     } else {
        //         $fileBase64 = null;

        //         // $kepala_bkpsdm = $this->db->select('a.*, d.id as id_m_user')
        //         //                         ->from('db_pegawai.pegawai a')
        //         //                         ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
        //         //                         ->join('m_user d', 'a.nipbaru_ws = d.username')
        //         //                         ->where('c.kepalaskpd', 1)
        //         //                         ->where('a.skpd', ID_UNITKERJA_BKPSDM)
        //         //                         ->get()->row_array();

        //         //langkah ini untuk tes jika nik dan passphrase benar
        //         $one_file = $this->dsCuti($list_data[0]['id_t_pengajuan_cuti']);
        //         if($one_file['code'] == 1){
        //             $res = $one_file;   
        //             return $res;
        //         } else {
        //             // unset($list_data[0]);
        //         }
        //         // dd($one_file);

        //         $this->db->trans_begin();
        //         $i = 0;
        //         $cron_tte = null;
        //         foreach($list_data as $ld){
        //             $this->db->where('id', $ld['id_t_pengajuan_cuti'])
        //                     ->update('t_pengajuan_cuti', [
        //                         'batchId' => $batchId
        //                     ]);
                    
        //             // if($list_data[0]['id_t_pengajuan_cuti'] != $ld['id_t_pengajuan_cuti']){
        //                 $credential['nik'] = $params['nik'];
        //                 $credential['passphrase'] = $params['passphrase'];

        //                 $cron_tte[$i]['id_t_pengajuan_cuti'] = $ld['id_t_pengajuan_cuti'];
        //                 $cron_tte[$i]['random_string'] = $batchId;
        //                 $cron_tte[$i]['credential'] = json_encode($credential);
        //                 $cron_tte[$i]['created_by'] = $this->general_library->getId();
        //             // }

        //             $i++;
        //         }
                
        //         if($cron_tte){
        //             //insert ke dalam cron tte ds bulk
        //             $this->db->insert_batch('t_cron_tte_bulk_ds', $cron_tte);
        //         }
        //     }
        // } else {
            $batchId = generateRandomString(10, 1, 't_request_ds'); 
            $list_data = $this->db->select('*')
                                ->from('t_request_ds')
                                ->where_in('id', $params['list_checked'])
                                ->where('flag_active', 1)
                                ->get()->result_array();
            if(!$list_data){
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan. Data tidak ditemukan.';
                return $res;
            } else {
                $selected = $list_data[0];
                $selectedId = $list_data[0]['id'];

                $request = json_decode($selected['request'], true);
                $request['signatureProperties']['imageBase64'] = $selected['url_image_ds'];

                $base64File = base64_encode(file_get_contents(base_url().$selected['url_file']));
                $jsonRequest['file'][] = $base64File;
                // dd($base64File);

                $jsonRequest['signatureProperties'][] = $request['signatureProperties'];
                $jsonRequest['nik'] = $params['nik'];
                $jsonRequest['passphrase'] = $params['passphrase'];
                // dd(json_encode($jsonRequest));

                $oneData = $this->ttelib->signPdfNikPass($jsonRequest);
                $response = json_decode($oneData, true);

                if($response == null || !isset($response['file'])){ // jika gagal
                    $res['code'] = 1;
                    $res['message'] = $oneData;
                    $res['data'] = null;
                } else { // jika berhasil                    
                    $this->db->where('id', $selected['ref_id'])
                            ->update($selected['table_ref'], [
                                $selected['nama_kolom_flag'] => 1
                            ]);

                    $this->db->where_in('id', $params['list_checked'])
                            ->update('t_request_ds', [
                                'batchId' => $batchId,
                                'flag_selected' => 1,
                                'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                            ]);

                    $this->db->insert('t_file_ds', [
                        'random_string' => $selected['random_string'],
                        'url' => $selected['url_file'],
                        'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                    ]);

                    $cronRequest[$selectedId] = [];

                    $this->db->insert('t_cron_request_ds', [
                        'credential' => json_encode([
                            'nik' => $params['nik'],
                            'passphrase' => $params['passphrase'],
                        ]),
                        'batchId' => $batchId,
                        'request' => $selected['request'],
                        'response' => $oneData,
                        'flag_send' => 1,
                        'date_send' => date('Y-m-d H:i:s'),
                        'flag_sent' => 1,
                        'date_sent' => date('Y-m-d H:i:s'),
                        'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0,
                        'id_t_request_ds' => $selectedId
                    ]);

                    foreach($list_data as $ld){
                        if($ld['id'] != $selectedId){
                            // $cronRequest[$ld['id']] = [
                            //     'credential' => json_encode([
                            //         'nik' => $params['nik'],
                            //         'passphrase' => $params['passphrase'],
                            //     ]),
                            //     'batchId' => $batchId,
                            //     'request' => $ld['request'],
                            //     'flag_send' => 0,
                            //     'date_send' => null,
                            //     'flag_sent' => 0,
                            //     'date_sent' => null,
                            //     'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0,
                            //     'id_t_request_ds' => $ld['id']
                            // ];
                            $this->db->insert('t_cron_request_ds', [
                                'credential' => json_encode([
                                    'nik' => $params['nik'],
                                    'passphrase' => $params['passphrase'],
                                ]),
                                'batchId' => $batchId,
                                'request' => $ld['request'],
                                'flag_send' => 0,
                                'date_send' => null,
                                'flag_sent' => 0,
                                'date_sent' => null,
                                'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0,
                                'id_t_request_ds' => $ld['id']
                            ]);

                            $this->db->insert('t_file_ds', [
                                'random_string' => $ld['random_string'],
                                'url' => $ld['url_file'],
                                'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                            ]);
                        }
                    }
                    // dd(json_encode($cronRequest));
                    // $this->db->insert_batch('t_cron_request_dssadasd', $cronRequest);

                    base64ToFile($response['file'][0], $selected['url_file']); //simpan ke file
                    
                    if($selected['id_m_jenis_ds'] == 4){ // jika cuti, kirim SK cuti ke pegawai ybs
                        $this->tteCuti($selected['id']);
                    }
                    // dd(json_encode($cronRequest));
                    // $this->db->insert_batch('t_cron_request_dssadasd', $cronRequest);

                    base64ToFile($response['file'][0], $selected['url_file']); //simpan ke file

                    $res['code'] = 0;
                    $res['message'] = "Berhasil";
                    $res['data'] = null;
                }
            }    
        // }
        
        if($this->db->trans_status() == FALSE || $res['code'] != 0){
            $this->db->trans_rollback();
            $res['code'] = 4;
            // $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            if($res['code'] == 0){
                $this->db->trans_commit();
            } else {
                $res['code'] = 5;
                $res['message'] = $res['message'] ? $res['message'] : 'Terjadi Kesalahan';
                $res['data'] = null;
            }
        }

        return $res;
    }

    public function tteCuti($id){
        $selected = $this->db->select('*')
                            ->from('t_request_ds')
                            ->where_in('id', $id)
                            ->where('flag_active', 1)
                            ->get()->row_array();

        $pegawai = $this->db->select('a.*, d.nm_cuti, c.tanggal_mulai, d.id_cuti, c.lama_cuti, c.tanggal_mulai, c.tanggal_akhir, b.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_user b', 'a.nipbaru_ws = b.username')
                            ->join('t_pengajuan_cuti c', 'b.id = c.id_m_user')
                            ->join('db_pegawai.cuti d', 'c.id_cuti = d.id_cuti')
                            ->where('a.nipbaru_ws', $selected['nip'])
                            ->where('c.id', $selected['ref_id'])
                            ->get()->row_array();

        $caption = "*[SK PENGAJUAN ".strtoupper($pegawai["nm_cuti"])."]*\n\n"."Selamat ".greeting().", Yth. ".getNamaPegawaiFull($pegawai).",\nBerikut kami lampirkan SK ".$pegawai["nm_cuti"]." Anda. Terima kasih.".FOOTER_MESSAGE_CUTI;
        $cronWa = [
            'sendTo' => convertPhoneNumber($pegawai['handphone']),
            'message' => $caption,
            'filename' => "CUTI_".strtoupper($pegawai["nipbaru_ws"]).'_'.$pegawai['tanggal_mulai'].'.pdf',
            'fileurl' => $selected['url_file'],
            'type' => 'document',
            'jenis_layanan' => 'Cuti'
        ];
        // $this->general->saveToCronWa($cronWa);
        $this->db->insert('t_cron_wa', $cronWa); // insert cron WA untuk krim file

        $explode_url = explode("arsipcuti/", $selected['url_file']);

        $this->db->insert('db_pegawai.pegcuti', [
            'id_pegawai' => $pegawai['id_peg'],
            'jeniscuti' => $pegawai['id_cuti'],
            'lamacuti' => $pegawai['lama_cuti'],
            'tglmulai' => $pegawai['tanggal_mulai'],
            'tglselesai' => $pegawai['tanggal_akhir'],
            'nosttpp' => "",
            'tglsttpp' => date('Y-m-d'),
            'gambarsk' => $explode_url[1],
            'status' => 2
        ]); // input di arsip cuti

        
        $kepala_bkpsdm = $this->db->select('a.*, d.id as id_m_user')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                    ->join('m_user d', 'a.nipbaru_ws = d.username')
                    ->where('c.kepalaskpd', 1)
                    ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                    ->get()->row_array();

        $dokumen_pendukung = null;
        $hariKerja = countHariKerjaDateToDate($pegawai['tanggal_mulai'], $pegawai['tanggal_akhir']);
        if($hariKerja){
            $i = 0;
            foreach($hariKerja[2] as $h){
                $explode = explode("-", $h);
                $dokumen_pendukung[$i] = [
                    'id_m_user' => $pegawai['id_m_user'],
                    'id_m_jenis_disiplin_kerja' => 17,
                    'tanggal' => $explode[2],
                    'bulan' => $explode[1],
                    'tahun' => $explode[0],
                    'keterangan' => 'Cuti',
                    'pengurangan' => 0,
                    'status' => 2,
                    'keterangan_verif' => '',
                    'tanggal_verif' => date('Y-m-d H:i:s'),
                    'id_m_user_verif' => $kepala_bkpsdm['id_m_user'],
                    'flag_outside' => 1,
                    'url_outside' => $selected['url_file'],
                    'created_by' => $kepala_bkpsdm['id_m_user']
                ];
                $i++;
            }
        }

        if($dokumen_pendukung){
            // input di dokumen pendukung
            $this->db->insert_batch('t_dokumen_pendukung', $dokumen_pendukung);
        }
    }

    public function loadBatchDs(){
        $res = null;

        $data = $this->db->select('id, id_t_pengajuan_cuti, flag_send, flag_sent, date_send, date_sent, random_string')
                        ->from('t_cron_tte_bulk_ds')
                        ->where('flag_active', 1)
                        ->order_by('created_date', 'asc')
                        ->get()->result_array();

        if($data){
            foreach($data as $d){
                $res[$d['random_string']][] = $d;
                $res[$d['random_string']]['random_string'] = $d['random_string'];
                
                //hitung total
                if(isset($res[$d['random_string']]['total'])){
                    $res[$d['random_string']]['total']++;
                } else {
                    $res[$d['random_string']]['total'] = 1;
                }

                //hitung berapa yang selesai
                if($d['flag_sent'] == 1){
                    if(isset($res[$d['random_string']]['done'])){
                        $res[$d['random_string']]['done']++;
                    } else {
                        $res[$d['random_string']]['done'] = 1;
                    }
                } else {
                    if(!isset($res[$d['random_string']]['done'])){
                        $res[$d['random_string']]['done'] = 0;
                    }
                }
            }
        }

        return $res;
    }

    public function cronDsBulkTte(){
        $data = $this->db->select('a.*, b.url_sk')
                        ->from('t_cron_tte_bulk_ds a')
                        ->join('t_pengajuan_cuti b', 'a.id_t_pengajuan_cuti = b.id')
                        ->where('a.flag_active', 1)
                        ->where('a.flag_sent', 0)
                        // ->where('a.flag_send', 0)
                        // ->where('b.url_sk IS NULL')
                        ->limit(3)
                        ->get()->result_array();
                        // dd($data);
        if($data){
            foreach($data as $d){
                if($d['url_sk'] != null){
                    $this->db->where('id', $d['id'])
                            ->update('t_cron_tte_bulk_ds', [
                                'flag_sent' => 1,
                                'date_sent' => date('Y-m-d H:i:s'),
                                'flag_send' => 1,
                                'date_send' => date('Y-m-d H:i:s')
                            ]);
                } else {
                    $credential = json_decode($d['credential'], true);
                    $data_input['nik'] = $credential['nik'];
                    $data_input['passphrase'] = $credential['passphrase'];
                    
                    $send = $this->dsCuti($d['id_t_pengajuan_cuti'], 1, $data_input);
                    $this->db->where('id', $d['id'])
                            ->update('t_cron_tte_bulk_ds',
                            [
                                // 'request' => $send? $send['data']['request'] : null, 
                                'response' => json_encode($send),
                                'flag_send' => 1,
                                'date_send' => date('Y-m-d H:i:s') 
                            ]);
                }
            }
        }
    }

    public function dsCuti($id, $flag_from_bulk = 0, $data_input = null){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $input_post = $this->input->post();
        if($flag_from_bulk == 1){
            $input_post = $data_input;
        }

        $request = null;

        $this->db->trans_begin();

            $data = $this->db->select('a.*, b.nm_cuti, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat, f.nama_jabatan, g.nm_unitkerja,
                g.id_unitkerja, b.id_cuti, c.id as id_m_user, d.id_peg, d.handphone, d.nipbaru_ws')
                ->from('t_pengajuan_cuti a')
                ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                ->join('m_user c', 'c.id = a.id_m_user')
                ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg', 'left')
                ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                ->where('a.id', $id)
                ->get()->row_array();

            $explode = explode("-", $data['created_date']);
            $tahun = $explode[0];
            $counter = 1;
            $master = $this->db->select('*')
                            ->from('m_jenis_layanan')
                            ->where('integrated_id', $data['id_cuti'])
                            ->get()->row_array();

            $last_data = $this->db->select('*')
                            ->from('t_nomor_surat')
                            ->where('YEAR(tanggal_surat)', $tahun)
                            ->order_by('created_date', 'desc')
                            ->limit(1)
                            ->get()->row_array();
            if($last_data){
                $counter = floatval($last_data['counter'])+1;
            }
            $counter = $counter.'.'.$master['id'];

            // $nomor_surat = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;

            $res['data'] = $data;
            $res['data']['ds'] = 1;
            // $res['data']['nomor_surat'] = $nomor_surat;

            $filename = 'CUTI_'.$res['data']['nipbaru_ws'].'_'.date("Y", strtotime($res['data']['created_date']))."_".date("m", strtotime($res['data']['created_date'])).'_'.date("d", strtotime($res['data']['created_date'])).'_signed.pdf';
            $path_file = 'arsipcuti/'.$filename;

            // $encUrl = simpleEncrypt($path_file);
            $randomString = generateRandomString(30, 1, 't_file_ds'); 
            $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
            // dd($contentQr);
    		$res['qr'] = generateQr($contentQr);

            // dd($path_file);
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-P',
                // 'debug' => true
            ]);
            $html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $res, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($path_file, 'F');

            $fileBase64 = convertToBase64(($path_file));
            $signatureProperties = array();
            $signatureProperties = [
                'tampilan' => 'INVISIBLE',
                'reason' => REASON_TTE
            ];

            $request_tte = [
                'id_ref' => [$data['id']],
                'table_ref' => 't_pengajuan_cuti',
                'nik' => $input_post['nik'],
                'passphrase' => $input_post['passphrase'],
                'signatureProperties' => [$signatureProperties],
                'file' => [
                    $fileBase64
                ]
            ];

            $request_sign = json_decode($this->ttelib->signPdfNikPass($request_tte), true);

            $request = json_encode($request_tte);
            $response = json_encode($request_sign);

            if(isset($request_sign['file'])){
                unlink($path_file);
                base64ToFile($request_sign['file'][0], $path_file);
                if(!file_exists($path_file)){
                    $res['code'] = 1;
                    $res['message'] = "Terjadi Kesalahan saat menyimpan PDF.";
                    $res['data'] = null;
                    $this->db->trans_rollback();
                    return $res;
                } else {
                    if($flag_from_bulk == 1){
                        $this->db->where('id_t_pengajuan_cuti', $data['id'])
                                ->update('t_cron_tte_bulk_ds', [
                                    'flag_sent' => 1,
                                    'date_sent' => date('Y-m-d H:i:s')
                                ]);
                    }
                }
                // readfile($path_file);
                // dd($request_sign['file'][0]);
            } else {
                $error_message = isset($request_sign['error']) ? $request_sign['error'] : $request_sign;
                $res['code'] = 1;
                $res['message'] = "Terjadi Kesalahan saat Sign Pdf, error: ".$error_message;
                $res['data'] = null;
                $this->db->trans_rollback();
                return $res;
            }
            // dd(json_decode($request_sign));

            $path_file = $path_file;
            $caption = "*[SK PENGAJUAN ".strtoupper($data["nm_cuti"])."]*\n\n"."Selamat ".greeting().", Yth. ".getNamaPegawaiFull($data).",\nBerikut kami lampirkan SK ".$data["nm_cuti"]." Anda. Terima kasih.".FOOTER_MESSAGE_CUTI;
            // $this->maxchatlibrary->sendDocument(convertPhoneNumber($data['handphone']), @$path_file, $filename, $caption);
            $cronWa = [
                'sendTo' => convertPhoneNumber($data['handphone']),
                'message' => $caption,
                'filename' => $filename,
                'fileurl' => $path_file,
                'type' => 'document',
                'jenis_layanan' => 'Cuti'
            ];
            // $this->general->saveToCronWa($cronWa);
            $this->db->insert('t_cron_wa', $cronWa);

            $this->db->insert('t_file_ds', [
                'url' => $path_file,
                'random_string' => $randomString,
                'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
            ]);

            $this->db->where('id', $id)
                    ->update('t_pengajuan_cuti', [
                                'url_sk' => $path_file
                    ]);

            
            $kepala_bkpsdm = $this->db->select('a.*, d.id as id_m_user')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                    ->join('m_user d', 'a.nipbaru_ws = d.username')
                                    ->where('c.kepalaskpd', 1)
                                    ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                                    ->get()->row_array();

            //simpan di dokumen pendukung agar tersinkron dengan rekap absen
            $dokumen_pendukung = null;
            $hariKerja = countHariKerjaDateToDate($data['tanggal_mulai'], $data['tanggal_akhir']);
            if($hariKerja){
                $i = 0;
                foreach($hariKerja[2] as $h){
                    $explode = explode("-", $h);
                    $dokumen_pendukung[$i] = [
                        'id_m_user' => $data['id_m_user'],
                        'id_m_jenis_disiplin_kerja' => 17,
                        'tanggal' => $explode[2],
                        'bulan' => $explode[1],
                        'tahun' => $explode[0],
                        'keterangan' => 'Cuti',
                        'pengurangan' => 0,
                        'status' => 2,
                        'keterangan_verif' => '',
                        'tanggal_verif' => date('Y-m-d H:i:s'),
                        'id_m_user_verif' => $kepala_bkpsdm['id_m_user'],
                        'flag_outside' => 1,
                        'url_outside' => $path_file,
                        'created_by' => $kepala_bkpsdm['id_m_user']
                    ];
                    $i++;
                }
            }

            if($dokumen_pendukung){
                $this->db->insert_batch('t_dokumen_pendukung', $dokumen_pendukung);
            }

            $this->db->insert('t_nomor_surat', [
                'perihal' => 'SURAT IZIN '.strtoupper($data['nm_cuti']).' PEGAWAI a.n. '.getNamaPegawaiFull($data),
                'counter' => $counter,
                'nomor_surat' => $nomor_surat,
                'created_by' => $kepala_bkpsdm['id_m_user'],
                'tanggal_surat' => $data['created_date'],
                'id_m_jenis_layanan' => $master['id']
            ]);

            $this->db->insert('db_pegawai.pegcuti', [
                'id_pegawai' => $data['id_peg'],
                'jeniscuti' => $data['id_cuti'],
                'lamacuti' => $data['lama_cuti'],
                'tglmulai' => $data['tanggal_mulai'],
                'tglselesai' => $data['tanggal_akhir'],
                'nosttpp' => $nomor_surat,
                'tglsttpp' => date('Y-m-d'),
                'gambarsk' => $filename,
                'status' => 2
            ]);

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            if($res['code'] == 0){
                $this->db->trans_commit();
            } else {
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            }
        }

        if($flag_from_bulk == 1){
            $res['data']['request'] = $request;
            $res['data']['response'] = $response;
        }

        return $res;
    }

    public function loadDataDsPengajuanCuti(){
        return $this->db->select('a.*, c.gelar1, c.gelar2, c.nama, c.nipbaru_ws, a.created_date as tanggal_pengajuan, c.nipbaru_ws as nip, d.nm_unitkerja, 
                    d.keterangan as jenis_ds')
                    ->from('t_pengajuan_cuti a')
                    ->join('m_user b', 'a.id_m_user = b.id')
                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                    ->join('db_pegawai.unitkerja d', 'd.id_unitkerja = c.skpd')
                    ->join('t_progress_cuti e', 'a.id_t_progress_cuti = e.id')
                    ->join('m_user f', 'e.id_m_user_verifikasi = f.id')
                    ->join('db_pegawai.pegawai g', 'f.username = g.nipbaru_ws')
                    ->join('m_jenis_ds d', 'd.id = 4')
                    ->where('g.jabatan', ID_JABATAN_KABAN_BKPSDM)
                    ->where('a.url_sk', null)
                    ->where('a.flag_active', 1)
                    ->where('a.batchId IS NULL')
                    ->order_by('a.created_date', 'asc')
                    ->get()->result_array();
    }

    public function loadDataForDs($data){
        $result = null;
        // if($data['jenis_layanan'] == 4){
        //     $result = $this->loadDataDsPengajuanCuti();
        // } else {
            $this->db->select('a.*, a.created_date as tanggal_pengajuan, b.gelar1, b.gelar2, b.nipbaru_ws, b.nama, c.nm_unitkerja, d.keterangan as jenis_ds')
                            ->from('t_request_ds a')
                            ->join('db_pegawai.pegawai b', 'a.nip = b.nipbaru_ws')
                            ->join('db_pegawai.unitkerja c', 'b.skpd = c.id_unitkerja')
                            ->join('m_jenis_ds d', 'a.id_m_jenis_ds = d.id')
                            ->where('a.flag_selected', 0)
                            ->where('a.flag_active', 1)
                            ->where('a.id_t_nomor_surat !=', 0)
                            ->group_by('a.id')
                            // ->where('id_m_jenis_ds', $data['jenis_layanan'])
                            ->order_by('a.created_date', 'desc');
                            // ->get()->result_array();
            if($data['jenis_layanan'] != 0){
                $this->db->where('id_m_jenis_ds', $data['jenis_layanan']);
            } else {
                // $this->db->where('id_m_jenis_ds !=', 4);
            }

            $result = $this->db->get()->result_array();
        // }

        return $result;
    }

    public function saveNomorSurat(){
        $data = $this->input->post();
        $explode = explode("-", $data['tanggal_surat']);
        $tahun = $explode[0];
        $counter = 1;
        $master = $this->db->select('*')
                        ->from('m_jenis_layanan')
                        ->where('id', $data['id_m_jenis_layanan'])
                        ->get()->row_array();

        // $last_data = $this->db->select('*')
        //                     ->from('t_nomor_surat')
        //                     ->where('YEAR(tanggal_surat)', $tahun)
        //                     ->order_by('created_date', 'desc')
        //                     ->limit(1)
        //                     ->get()->row_array();
        // if($last_data){
        //     $counter = floatval($last_data['counter'])+1;
        // }
        // $counter = $counter.".".$master['id'];
        $counter = qounterNomorSurat($tahun);

        $data['counter'] = $counter;
        $data['nomor_surat'] = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;
        $data['created_by'] = $this->general_library->getId();

        $this->db->insert('t_nomor_surat', $data);
    }

    public function deleteNomorSuratManual($id){
        $res['code'] = 0;
        $res['message'] = '';

        $this->db->trans_begin();

        $request_ds = $this->db->select('a.*')
                        ->from('t_request_ds a')
                        ->join('m_jenis_layanan b', 'a.id_m_jenis_layanan = b.id')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();

        //buat file baru dengan nomor surat manual
        $meta_data = json_decode($request_ds['meta_data'], true);
        $meta_data['data']['nomor_surat'] = null;
        unset($meta_data['data']['nomor_surat']);

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'Legal-P',
            // 'debug' => true
        ]);

        $html = $this->load->view($request_ds['meta_view'], $meta_data, true);
        $mpdf->WriteHTML($html);
        $mpdf->showImageErrors = true;
        $mpdf->Output($request_ds['url_file'], 'F');

        $this->db->where('id', $id)
                ->update('t_request_ds', [
                    'id_t_nomor_surat' => null,
                    'updated_by' => $this->general_library->getId()
                ]);

        $this->db->where('id', $request_ds['id_t_nomor_surat'])
                ->update('t_nomor_surat', [
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

    public function saveNomorSuratManual($id){
        $res['code'] = 0;
        $res['message'] = '';

        $this->db->trans_begin();

        $data = $this->input->post();
        $explode_data = explode("/", $data['nomor_surat']);
        $tahun = $explode_data[count($explode_data)-1];

        $exists = $this->db->select('*')
                        ->from('t_nomor_surat')
                        ->where('(counter = "'.$data['counter_nomor_surat'].'" OR nomor_surat = "'.$data['nomor_surat'].'")')
                        ->where('flag_active', 1)
                        ->where('YEAR(tanggal_surat)', $tahun)
                        ->get()->row_array();

        $request_ds = $this->db->select('a.*')
                        ->from('t_request_ds a')
                        // ->join('m_jenis_layanan b', 'a.id_m_jenis_layanan = b.id')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();
        
        if($exists){
            if($exists['id'] == $request_ds['id_t_nomor_surat']){
                $res['code'] = 1;
                $res['message'] = 'Nomor Surat tidak berubah';
            } else {
                $res['code'] = 1;
                $res['message'] = 'Nomor Surat atau Counter Nomor Surat telah digunakan';
            }
        } else {
            //insert nomor surat manual
            $data_input['counter'] = $data['counter_nomor_surat'];
            $data_input['nomor_surat'] = $data['nomor_surat'];
            $data_input['id_m_jenis_layanan'] = $request_ds['id_m_jenis_layanan'];
            $data_input['perihal'] = $request_ds['perihal'];
            $data_input['tanggal_surat'] = formatDateOnlyForEdit($request_ds['created_date']);
            $data_input['created_by'] = $this->general_library->getId();

            $this->db->insert('t_nomor_surat', $data_input);
            $last_insert = $this->db->insert_id();

            //buat file baru dengan nomor surat manual
            $meta_data = json_decode($request_ds['meta_data'], true);
            $meta_data['data']['nomor_surat'] = $data_input['nomor_surat'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-P',
                // 'debug' => true
            ]);

            $html = $this->load->view($request_ds['meta_view'], $meta_data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($request_ds['url_file'], 'F');

            $this->db->where('id', $id)
                    ->update('t_request_ds', [
                        'id_t_nomor_surat' => $last_insert,
                        'updated_by' => $this->general_library->getId()
                    ]);
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

    public function loadNomorSurat(){
        return $this->db->select('a.*, c.gelar1, c.nama, c.gelar2')
                        ->from('t_nomor_surat a')
                        ->join('m_user b', 'a.created_by = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.flag_active', 1)
                        ->order_by('a.tanggal_surat', 'desc')
                        ->order_by('a.created_date', 'desc')
                        ->get()->result_array();
    }

    public function loadListFileInputManualNomorSurat(){
        return $this->db->select('a.*, b.nomor_surat, c.id as id_t_cron_request_ds')
                    ->from('t_request_ds a')
                    ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                    ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
                    ->where('a.flag_active', 1)
                    ->order_by('a.created_date', 'desc')
                    ->group_by('a.id')
                    ->get()->result_array();
    }

    public function loadListFileInputManualNomorSuratById($id){
        return $this->db->select('a.*, b.nomor_surat, c.id as id_t_cron_request_ds, b.counter')
                    ->from('t_request_ds a')
                    ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                    ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
                    ->where('a.flag_active', 1)
                    ->where('a.id', $id)
                    ->get()->row_array();
    }

    public function loadDetailCutiForPenomoranSkCuti($id){
        return $this->db->select('a.*, b.nomor_surat, c.id as id_t_cron_request_ds, b.counter, d.flag_ds_cuti, d.flag_ds_manual, d.id as id_t_pengajuan_cuti,
                    d.flag_ds_cuti, d.flag_ds_manual, d.url_sk, d.url_sk_manual')
                    ->from('t_request_ds a')
                    ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                    ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
                    ->join('t_pengajuan_cuti d', 'a.ref_id = d.id')
                    ->where('a.flag_active', 1)
                    ->where('a.ref_id', $id)
                    ->where('a.table_ref', 't_pengajuan_cuti')
                    ->get()->row_array();
    }

    public function deleteFileDsManual($id){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();

        $data = $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.nipbaru_ws, c.id_peg, c.handphone, d.nm_cuti, e.id_t_nomor_surat, f.nomor_surat')
                            ->from('t_pengajuan_cuti a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->join('db_pegawai.cuti d', 'a.id_cuti = d.id_cuti')
                            ->join('t_request_ds e', 'a.id = e.ref_id AND table_ref = "t_pengajuan_cuti"')
                            ->join('t_nomor_surat f', 'e.id_t_nomor_surat = f.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        if($data){
            $this->db->where('random_string', $data['random_string'])
                    ->update('t_dokumen_pendukung', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id', $id)
                    ->update('t_pengajuan_cuti', [
                        'url_sk_manual' => null,
                        'flag_ds_cuti' => 0,
                        'flag_ds_manual' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('nosttpp', $data['nomor_surat'])
                    ->update('db_pegawai.pegcuti', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id', $data['id_t_progress_cuti'])
                    ->update('t_progress_cuti', [
                            'flag_diterima' => 0,
                            'flag_verif' => 0,
                            'tanggal_verif' => null,
                            'updated_by' => $this->general_library->getId()
                    ]);

        } else {
            $rs['code'] = 1;
            // $rs['message'] = 'File yang diupload tidak ditemukan';
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

    public function saveUploadFileDsPenomoranSkCuti($id){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();

        $data = $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.nipbaru_ws, c.id_peg, c.handphone, d.nm_cuti, e.id_t_nomor_surat, f.nomor_surat')
                            ->from('t_pengajuan_cuti a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->join('db_pegawai.cuti d', 'a.id_cuti = d.id_cuti')
                            ->join('t_request_ds e', 'a.id = e.ref_id AND table_ref = "t_pengajuan_cuti" AND e.flag_active = 1')
                            ->join('t_nomor_surat f', 'e.id_t_nomor_surat = f.id', 'left')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
                            
        if($data && $data['id_t_nomor_surat'] == null){
            $res['code'] = 1;
            $res['message'] = "SK Belum memiliki Nomor Surat. Harap mengisi Nomor Surat terlebih dahulu.";
            return $res;
        }

        if($_FILES && $data){
            $allowed_extension = ['pdf'];
            $file_array = explode(".", $_FILES["file_ds_manual"]["name"]);
            $file_extension = end($file_array);

            $filename = 'CUTI_DSM_'.$data['nipbaru_ws'].'_'.date("Y", strtotime($data['tanggal_mulai']))."_".date("m", strtotime($data['tanggal_mulai'])).'_'.date("d", strtotime($data['tanggal_mulai'])).'.pdf';

            if(in_array($file_extension, $allowed_extension)){
                $config['upload_path'] = 'arsipcuti/';
                $config['allowed_types'] = '*';
                $config['file_name'] = ($filename);
                $this->load->library('upload', $config);
                // if(file_exists($config['upload_path'])."/".$file_name){
                //     move_uploaded_file('overwrited_file', ($config['upload_path']."/".$file_name));
                //     unlink(($config['upload_path'])."/".$file_name);
                // }
                $uploadfile = $this->upload->do_upload('file_ds_manual');
                
                $filepath = 'arsipcuti/'.$filename;
                if($uploadfile){
                    $this->db->where('id', $id)
                            ->update('t_pengajuan_cuti', [
                                'url_sk_manual' => $filepath,
                                'flag_ds_cuti' => 1,
                                'flag_ds_manual' => 1,
                                'updated_by' => $this->general_library->getId(),
                            ]);

                    $kepala_bkpsdm = $this->db->select('a.*, d.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                            ->join('m_user d', 'a.nipbaru_ws = d.username')
                            ->where('c.kepalaskpd', 1)
                            ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                            ->get()->row_array();

                    //upload di dokumen pendukung
                    $dokumen_pendukung = null;
                    $hariKerja = countHariKerjaDateToDate($data['tanggal_mulai'], $data['tanggal_akhir']);
                    if($hariKerja){
                        $i = 0;
                        foreach($hariKerja[2] as $h){
                            $explode = explode("-", $h);
                            $dokumen_pendukung[$i] = [
                                'id_m_user' => $data['id_m_user'],
                                'id_m_jenis_disiplin_kerja' => 17,
                                'tanggal' => $explode[2],
                                'bulan' => $explode[1],
                                'tahun' => $explode[0],
                                'keterangan' => 'Cuti',
                                'pengurangan' => 0,
                                'status' => 2,
                                'keterangan_verif' => '',
                                'tanggal_verif' => date('Y-m-d H:i:s'),
                                // 'id_m_user_verif' => $kepala_bkpsdm['id_m_user'],
                                'id_m_user_verif' => $this->general_library->getId(),
                                'flag_outside' => 1,
                                'url_outside' => $filepath,
                                // 'created_by' => $kepala_bkpsdm['id_m_user'],
                                'created_by' => $this->general_library->getId(),
                                'random_string' => $data['random_string']
                            ];
                            $i++;
                        }
                    }
                    
                    if($dokumen_pendukung){
                        $this->db->insert_batch('t_dokumen_pendukung', $dokumen_pendukung);
                    }

                    // upload pegcuti
                    $this->db->insert('db_pegawai.pegcuti', [
                        'id_pegawai' => $data['id_peg'],
                        'jeniscuti' => $data['id_cuti'],
                        'lamacuti' => $data['lama_cuti'],
                        'tglmulai' => $data['tanggal_mulai'],
                        'tglselesai' => $data['tanggal_akhir'],
                        'nosttpp' => $data['nomor_surat'],
                        'tglsttpp' => $data['created_date'],
                        'gambarsk' => $filename,
                        'status' => 2,
                        'created_by' => $this->general_library->getId()
                    ]);

                    //update t_progress_cuti
                    $this->db->where('id', $data['id_t_progress_cuti'])
                            ->update('t_progress_cuti', [
                                'flag_diterima' => 1,
                                'flag_verif' => 1,
                                'tanggal_verif' => date('Y-m-d H:i:s'),
                                'updated_by' => $this->general_library->getId()
                            ]);

                    //send WA dokumen ke pegawai
                    $caption = "*[SK PENGAJUAN ".strtoupper($data["nm_cuti"])." - ".$data['random_string']."]*\n\n"."Selamat ".greeting().", Yth. ".getNamaPegawaiFull($data).",\nBerikut kami lampirkan SK ".$data["nm_cuti"]." Anda. Terima kasih.".FOOTER_MESSAGE_CUTI;
                    $cronWa = [
                        'sendTo' => convertPhoneNumber($data['handphone']),
                        'message' => $caption,
                        'filename' => $filename,
                        'fileurl' => $filepath,
                        'type' => 'document',
                        'jenis_layanan' => 'Cuti'
                    ];
                    $this->db->insert('t_cron_wa', $cronWa);

                } else {
                    $rs['code'] = 1;
                    $rs['message'] = 'Gagal upload file';
                }
            }
        } else {
            $rs['code'] = 1;
            // $rs['message'] = 'File yang diupload tidak ditemukan';
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            // $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            $this->db->trans_commit();
        }
    
        return $res;
    }

    public function updateJabatan($id_peg){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();
        
            $getJabatan = $this->db->select('a.statusjabatan,a.id_unitkerja,a.tmtjabatan,a.id_jabatan,a.jenisjabatan')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.id_jabatan')
            ->where('a.id_pegawai', $id_peg)
            ->where_in('a.flag_active', [1,2])
            // ->where('a.statusjabatan !=', 2)
            ->where_not_in('a.statusjabatan', [2,3])
            ->where('a.status', 2)
            // ->where('a.flag_active', 1)
            ->order_by('tmtjabatan', 'desc')
            ->order_by('a.id', 'desc')
            ->limit(1)
            ->get()->row_array();
        
            if($getJabatan) {
            if($getJabatan['id_unitkerja']){
                $dataUpdate["skpd"] =  $getJabatan['id_unitkerja'];
            }
                $dataUpdate["tmtjabatan"] =  $getJabatan['tmtjabatan'];
                $dataUpdate["jabatan"] =   $getJabatan['id_jabatan'];
                $dataUpdate["jenisjabpeg"] =  $getJabatan['jenisjabatan'];
                $dataUpdate["statusjabatan"] =  $getJabatan['statusjabatan'];
                $this->db->where('id_peg', $id_peg)
                        ->update('db_pegawai.pegawai', $dataUpdate);
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

    public function updatePangkat($id_peg){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        
       
        $this->db->trans_begin();
        
            $getPangkat = $this->db->select('*')
            ->from('db_pegawai.pegpangkat a')
            ->join('db_pegawai.pangkat b', 'b.id_pangkat = a.pangkat')
            ->where('a.id_pegawai', $id_peg)
            ->where_in('a.flag_active', [1,2])
            ->where('a.status', 2)
            ->where('a.flag_active', 1)
            ->order_by('a.tmtpangkat', 'desc')
            ->limit(1)
            ->get()->row_array();
        
            if($getPangkat) {
  
                $dataUpdate["tmtpangkat"] =  $getPangkat['tmtpangkat'];
                $dataUpdate["pangkat"] =   $getPangkat['pangkat'];
                $this->db->where('id_peg', $id_peg)
                        ->update('db_pegawai.pegawai', $dataUpdate);
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

    public function updateBerkala($id_peg){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        
       
        $this->db->trans_begin();
        
            $getBerkala = $this->db->select('*')
            ->from('db_pegawai.peggajiberkala a')
            ->where('a.id_pegawai', $id_peg)
            ->where_in('a.flag_active', [1,2])
            ->where('a.status', 2)
            ->where('a.flag_active', 1)
            ->order_by('a.tmtgajiberkala', 'desc')
            ->limit(1)
            ->get()->row_array();
        
            if($getBerkala) {
  
                $dataUpdate["tmtgjberkala"] =  $getBerkala['tmtgajiberkala'];
                $this->db->where('id_peg', $id_peg)
                        ->update('db_pegawai.pegawai', $dataUpdate);
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

    function getListJabatanSiasn($id = null){
        $jenis = 'JFU';
        if($id != null){
            $jabatan = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatanpeg', $id)
                                ->get()->row_array();
            if($jabatan){
                $jenis = $jabatan['jenis_jabatan'];
            }
        }
        
        if($jenis == 'Struktural'){
            return $this->db->select('*, nama_jabatan as nama')
                            ->from('db_siasn.m_ref_jabatan_struktural')
                            ->get()->result_array();
        } else if($jenis == 'JFT'){
            return $this->db->select('*')
                            ->from('db_siasn.m_ref_jabatan_fungsional')
                            ->get()->result_array();
        } else if($jenis == 'JFU'){
            return $this->db->select('*')
                            ->from('db_siasn.m_ref_jabatan_pelaksana')
                            ->get()->result_array();
        }
    }

    function getSelectJabatanEdit(){
        $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->group_start()
            ->where('a.jenis_jabatan', 'JFU')
            // ->where("FIND_IN_SET(a.jenis_jabatan,'JFU,Struktural')!=",0)
            ->where_in('a.jenis_jabatan', ['JFU','Struktural'])
            // ->where('a.id_unitkerja', '4018000')
            ->group_end()
              ->where('a.flag_active', 1)
            ->or_where('a.jenis_jabatan', 'JFT');
        return $this->db->get()->result_array();
    }

    function getSelectJabatanEditJFT(){
        $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->where('a.flag_active', 1)
            ->where('a.jenis_jabatan', 'JFT');
        return $this->db->get()->result_array();
    }

    function getSelectJabatanEditStruktural($id_unitkerja){
        $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->where('a.jenis_jabatan', 'Struktural')
            ->where('a.flag_active', 1)
            ->where('a.id_unitkerja', $id_unitkerja);
        return $this->db->get()->result_array();
    }
    
    
    function getSelectJabatanEditPelaksana($id_unitkerja){
        $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->where('a.jenis_jabatan', 'JFU')
            ->where('a.flag_active', 1)
            ->where('a.id_unitkerja', $id_unitkerja);
        return $this->db->get()->result_array();
    }

    public function getDokumenForKarisKarsu($table,$id_dokumen,$jenissk)
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        // ->where('status', 2)
        ->from($table);

        if($table == "db_pegawai.pegarsip"){
            $this->db->where('id_dokumen', $id_dokumen);
        }

        if($table == "db_pegawai.pegberkaspns"){
            $this->db->where('jenissk', $jenissk);
        }

        if($table == "db_pegawai.pegskp"){
            $currentYear = date('Y'); 
            $previous1Year = $currentYear - 1;
            $this->db->where('tahun', $previous1Year); 
        }
    
    
        $query = $this->db->get()->row_array();
    
        return $query;  

    }

    public function getDokumenForKarisKarsuAdmin($table,$id_dokumen,$jenissk,$id_peg)
    {
        $this->db->select('*')
        ->where('id_pegawai', $id_peg)
        ->where('flag_active', 1)
        ->where('status', 2)
        ->from($table);

        if($table == "db_pegawai.pegarsip"){
            $this->db->where('id_dokumen', $id_dokumen);
        }

        if($table == "db_pegawai.pegberkaspns"){
            $this->db->where('jenissk', $jenissk);
        }

        if($table == "db_pegawai.pegskp"){
            $currentYear = date('Y'); 
            $previous1Year = $currentYear - 1;
            $this->db->where('tahun', $previous1Year); 
        }
    
    
        $query = $this->db->get()->row_array();
    
        return $query;  

    }

    public function searchPenomoranSkCuti($data){
        $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.nipbaru_ws')
                ->from('t_pengajuan_cuti a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                ->join('t_request_ds d', 'a.id = d.ref_id')
                ->where('a.flag_active', 1)
                ->where('MONTH(a.created_date)', $data['bulan'])
                ->where('YEAR(a.created_date)', $data['tahun'])
                ->where('d.id_m_jenis_layanan', 3)
                ->order_by('a.created_date', 'asc');

        if($data['id_unitkerja'] != 0){
            $this->db->where('c.skpd', $data['id_unitkerja']);
        }

        return $this->db->get()->result_array();
    }

    public function insertUsulLayananKarisKarsu($id_m_layanan){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $this->db->trans_begin();
            // $dataUsul['id_m_user']      = $this->general_library->getId();
            // $dataUsul['created_by']      = $this->general_library->getId();
            // $dataUsul['id_m_layanan']      = 1;
            // $this->db->insert('db_efort.t_layanan', $dataUsul);
            // $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            $cek =  $this->db->select('*')
            ->from('t_layanan a')
            ->where('a.id_m_user', $this->general_library->getId())
            ->where('a.flag_active', 1)
            ->where('a.id_m_layanan', $id_m_layanan)
            ->where('a.status', 0)
            ->get()->result_array();
        
            if($cek){
                $res = array('msg' => 'Masih ada usul layanan yang belum disetujui', 'success' => false);
            } else {
                $dataUsul['id_m_user']      = $this->general_library->getId();
                $dataUsul['created_by']      = $this->general_library->getId();
                $dataUsul['id_m_layanan']      = $id_m_layanan;
                $this->db->insert('db_efort.t_layanan', $dataUsul);
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

    public function insertUsulLayananPensiun(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $this->db->trans_begin();
   
            $dataUsul['id_m_user']      = $this->general_library->getId();
            $dataUsul['created_by']      = $this->general_library->getId();
            $dataUsul['jenis_pensiun']      = $this->input->post('jenis_pensiun');
            $this->db->insert('db_efort.t_pensiun', $dataUsul);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
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

    function getRiwayatKarisKarsu(){
        $this->db->select('*')
                       ->from('t_layanan a')
                       ->where('a.id_m_user', $this->general_library->getId())
                       ->where('a.flag_active', 1)
                       ->where('a.id_m_layanan', 1)
                       ->order_by('a.id','desc');
                       $query = $this->db->get()->result_array();
                       return $query;
   }

       function loadListRiwayatPensiun($jenis_pensiun){
        $this->db->select('*')
                       ->from('t_pensiun a')
                       ->where('a.id_m_user', $this->general_library->getId())
                       ->where('a.flag_active', 1)
                       ->where('a.jenis_pensiun', $jenis_pensiun)
                       ->order_by('a.id','desc');
    
                       $query = $this->db->get()->result_array();
                       return $query;
   }

   public function searchPengajuanKarisKarsu(){
    $data = $this->input->post();
    $this->db->select('*, a.created_date as tanggal_pengajuan, a.id as id_pengajuan, a.status as status_pengajuan, a.created_date as tanggal_pengajuan')
            ->from('t_karis_karsu a')
            ->join('m_user d', 'a.id_m_user = d.id')
            ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
            ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
            ->where('a.flag_active', 1)
            ->order_by('a.created_date', 'desc');

    if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
        $this->db->where('e.skpd', $data['id_unitkerja']);
    }

    if(isset($data['status_pengajuan']) && $data['status_pengajuan'] != ""){
        $this->db->where('a.status', $data['status_pengajuan']);
    }

    return $this->db->get()->result_array();
}

public function searchPengajuanPensiun(){
    $data = $this->input->post();
    $this->db->select('*, a.created_date as tanggal_pengajuan, a.id as id_pengajuan, a.status as status_pengajuan, a.created_date as tanggal_pengajuan')
            ->from('t_pensiun a')
            ->join('m_user d', 'a.id_m_user = d.id')
            ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
            ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
            ->where('a.flag_active', 1)
            ->order_by('a.created_date', 'desc');

    if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
        $this->db->where('e.skpd', $data['id_unitkerja']);
    }

    if(isset($data['status_pengajuan']) && $data['status_pengajuan'] != ""){
        $this->db->where('a.status', $data['status_pengajuan']);
    }

    return $this->db->get()->result_array();
}

function getPengajuanLayananKarisKarsu($id){
    // $this->db->select('*')
    //                 ->from('t_karis_karsu a')
    //                 ->where('a.id', $id)
    //                 ->where('a.flag_active', 1);
    // return $this->db->get()->result_array();
    return $this->db->select('c.*, c.id as id_pengajuan,b.nama,
    b.gelar1,b.gelar2,b.id_peg, b.nik, i.nm_agama, b.handphone,
    h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama as nama_pegawai, b.tptlahir, b.tgllahir,
    a.username as nip, b.statuspeg, b.fotopeg, b.nipbaru_ws, b.tmtpangkat, b.tmtjabatan,
    a.id as id_m_user, b.jk, b.alamat, j.id_unitkerjamaster,j.nm_unitkerjamaster')
    ->from('m_user a')
    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    ->join('t_karis_karsu c', 'a.id = c.id_m_user')
    // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
   
    ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
    ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
    ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
    ->join('db_pegawai.agama i', 'b.agama = id_agama')
    ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
    ->where('c.id', $id)
    ->get()->result_array();
}

function getPengajuanLayananPensiun($id){
    // $this->db->select('*')
    //                 ->from('t_karis_karsu a')
    //                 ->where('a.id', $id)
    //                 ->where('a.flag_active', 1);
    // return $this->db->get()->result_array();
    return $this->db->select('b.email,k.nm_statuspeg,c.*, c.id as id_pengajuan,
    b.gelar1,b.gelar2,b.id_peg, b.nik, i.nm_agama, b.handphone,
    h.nm_unitkerja,g.nama_jabatan,f.nm_pangkat,b.nama as nama_pegawai, b.tptlahir, b.tgllahir,
    a.username as nip, b.statuspeg, b.fotopeg, b.nipbaru_ws, b.tmtpangkat, b.tmtjabatan,
    a.id as id_m_user, b.jk, b.alamat, j.id_unitkerjamaster,j.nm_unitkerjamaster')
    ->from('m_user a')
    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    ->join('t_pensiun c', 'a.id = c.id_m_user')
    // ->join('db_siladen.t_perbaikan_data_pegawai d', 'c.id_usul = d.id_usul')
    ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
    ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
    ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
    ->join('db_pegawai.agama i', 'b.agama = id_agama')
    ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
    ->join('db_pegawai.statuspeg k', 'b.statuspeg = k.id_statuspeg')
    ->where('c.id', $id)
    ->get()->result_array();
}

public function getFileForKarisKarsu()
    {      
        $id_peg = $this->input->post('id_peg');
        if($this->input->post('file') == "skcpns"){
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
        } else if($this->input->post('file') == "laporan_perkawinan"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 52)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "daftar_keluarga"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 58)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "akte_nikah"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 24)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "pas_foto"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 53)
                ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        }   else {
         return [''];
        }
        
        
    }


    public function submitVerifikasiPengajuanKarisKarsu(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_pengajuan = $datapost['id_pengajuan'];
        $data["status"] = $datapost["status"];
        $data["keterangan"] = $datapost['keterangan'];
        $this->db->where('id', $id_pengajuan)
                ->update('t_layanan', $data);

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

    public function submitVerifikasiPengajuanPensiun(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();
        $id_pengajuan = $datapost['id_pengajuan'];
        $data["status"] = $datapost["status"];
        $data["keterangan"] = $datapost['keterangan'];
        $this->db->where('id', $id_pengajuan)
                ->update('t_pensiun', $data);

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


    public function batalVerifikasiPengajuanKarisKarsu(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $id_usul = $datapost['id_batal'];
        $data["status"] = 0; 
        $data["keterangan"] = "";
        $this->db->where('id', $id_usul)
                ->update('t_karis_karsu', $data);

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

    public function batalVerifikasiPengajuanPensiun(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $id_usul = $datapost['id_batal'];
        $data["status"] = 0; 
        $data["keterangan"] = "";
        $this->db->where('id', $id_usul)
                ->update('t_pensiun', $data);

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

    public function getDokumenLayanan($jenis_layanan)
    {
        $this->db->select('*,CONCAT(b.nama_dokumen," / ", b.keterangan) AS dokumen,
        (SELECT count(b.id) 
        FROM db_pegawai.pegberkaspns b
        WHERE b.id_pegawai = "'.$this->general_library->getIdPegSimpeg().'"
        AND b.flag_active = 1 and b.status = 2 AND jenissk = 1) as skcpns')
        ->where('a.jenis_layanan', $jenis_layanan)
        ->where('a.flag_active', 1)
        // ->where('b.flag_active', 1)
        // ->where('b.id_pegawai', $this->general_library->getIdPegSimpeg())   
        // ->join('db_pegawai.pegarsip b', 'a.dokumen_persyaratan = b.id_dokumen','left')  
        ->join('m_dokumen b', 'a.dokumen_persyaratan = b.id_dokumen')     

        ->from('m_syarat_layanan as a');
        $query = $this->db->get()->result_array();
        return $query;  

    }

    public function getFileLayanan()
    {      
        $id_peg = $this->general_library->getIdPegSimpeg();
        $id_dokumen = $this->input->post('id_dokumen');
        if($id_dokumen == "2"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 1)
                ->where('a.status', 2)
                ->order_by('a.id', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($id_dokumen == "3"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 2)
                ->where('a.status', 2)
                ->order_by('a.id', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($id_dokumen == "4"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegpangkat as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->order_by('a.tmtpangkat', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($id_dokumen == "18"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.id_dokumen', $id_dokumen)
                ->where('a.flag_active', 1)
                ->where('a.status', 2)
                ->limit(1);
                return $this->db->get()->result_array();
        } else {
         return [''];
        }
        
        
    }

    public function loadListProfilTalenta($id_peg,$jenis_pengisian){
        // $this->db->select('f.flag_active as fa,a.*,b.*,e.nama_jabatan,e.eselon as es_jabatan,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
        // where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang,
        // (SELECT y.nama_jabatan from db_pegawai.jabatan as y
        // where f.jabatan_target = y.id_jabatanpeg limit 1) as jabatan_target,')
        $this->db->select('a.*,b.*,e.nama_jabatan,e.eselon as es_jabatan,(SELECT d.nama_jabatan from db_pegawai.jabatan as d
        where a.jabatan = d.id_jabatanpeg limit 1) as jabatan_sekarang')
                       ->from('db_pegawai.pegawai a')
                       ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg','left')
                    //    ->join('db_simata.t_jabatan_target f', 'f.id_peg = b.id_peg', 'left')
                       ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg','left')
                       ->where('a.id_peg', $id_peg)
                       ->where('b.jenjang_jabatan', $jenis_pengisian);
       return $this->db->get()->result_array();
   }

   public function setPenilaianManajemenTalentaPerPegawai($id_pegawai,$jenis_pengisian,$id){
    // dd("tes");
    $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
    (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = a.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan,
    (select id_m_kriteria_penilaian from db_simata.t_penilaian_sejawat bb where bb.id_peg = a.id_peg and bb.flag_active = 1 limit 1) as id_kriteria_penilaian')
                   ->from('db_pegawai.pegawai a')
                   ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                   ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                   ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                   ->where('a.id_m_status_pegawai', 1)
                   ->where('a.id_peg', $id_pegawai)
                //    ->where('b.jenjang_jabatan', $jenis_pengisian)
                   ->order_by('c.eselon', 'asc')
                   ->group_by('a.id_peg');
    $query = $this->db->get()->result_array();
    // dd($query);
    if($query){

        // kinerja 
        $currentYear = date('Y'); 
        $previous1Year = $currentYear - 1;   
        $previous2Year = $currentYear - 2;  

        $total_kinerja = 0;
               $kriteria1 = $this->getPenilaianKinerja($id_pegawai,$previous1Year,1); 
               $kriteria2 = $this->getPenilaianKinerja($id_pegawai,$previous2Year,2); 
               $kriteria3 = $this->getInovasiPegawai($id_pegawai); 
               $kriteria4 = $this->getPengalamanTimPegawai($id_pegawai); 
               $kriteria5 = $this->getPenugasanPengawai($id_pegawai); 

            //   if($id_pegawai == 'PEG0000000eh992'){
            //     dd($kriteria4);
            //    }




               $data["id_peg"] = $id_pegawai;
               $data["kriteria1"] = $kriteria1;
               $data["kriteria2"] = $kriteria2;
               $data["kriteria3"] = $kriteria3;
               $data["kriteria4"] = $kriteria4;
               $data["kriteria5"] = $kriteria5;
               $data["kriteria5"] = $kriteria5;
             

               $skor1 =  $this->getSkor($kriteria1); 
               $bobot1 = $this->getBobot($kriteria1); 
               $total_kinerja1 = $skor1  * $bobot1 / 100;   
                  
               $skor2 =  $this->getSkor($kriteria2); 
               $bobot2 = $this->getBobot($kriteria2); 
               $total_kinerja2 = $skor2  * $bobot2 / 100; 

               $skor3 =  $this->getSkor($kriteria3); 
               $bobot3 = $this->getBobot($kriteria3); 
               $total_kinerja3 = $skor3  * $bobot3 / 100;   
                  
               $skor4 =  $this->getSkor($kriteria4); 
               $bobot4 = $this->getBobot($kriteria4); 
               $total_kinerja4 = $skor4  * $bobot4 / 100; 

               $skor5 =  $this->getSkor($kriteria5); 
               $bobot5 = $this->getBobot($kriteria5); 
               $total_kinerja5 = $skor5  * $bobot5 / 100;
               

               $total_kinerja = $total_kinerja1 + $total_kinerja2 + $total_kinerja3 + $total_kinerja4 + $total_kinerja5;
           

            $cek =  $this->db->select('*')
            ->from('db_simata.t_penilaian_kinerja a')
            ->where('a.id_peg', $id_pegawai)
            ->where('a.flag_active', 1)
            ->get()->result_array();

            if($cek){
                $this->db->where('id_peg', $id_pegawai)
                ->update('db_simata.t_penilaian_kinerja', 
                ['kriteria1' => $kriteria1,
                'kriteria2' => $kriteria2,
                'kriteria3' => $kriteria3,
                'kriteria4' => $kriteria4,
                'kriteria5' => $kriteria5,
                    ]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            } else {
                $this->db->insert('db_simata.t_penilaian_kinerja', $data);
                $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

            }

            
    $cekPenilaian =  $this->db->select('*')
    ->from('db_simata.t_penilaian a')
    ->where('a.id_peg', $id_pegawai)
    ->where('a.jenjang_jabatan', $jenis_pengisian)
    ->where('a.flag_active', 1)
    ->get()->result_array();
    


    if($cekPenilaian){
        $this->db->where('id_peg', $id_pegawai)
        ->where('jenjang_jabatan', $jenis_pengisian)
        ->update('db_simata.t_penilaian', 
        ['res_kinerja' => $total_kinerja]);
    } else {
        $datapenilaian["id_peg"] = $id_pegawai;
        $datapenilaian["created_by"] = $this->general_library->getId();
        $datapenilaian["res_kinerja"] = $total_kinerja;
        $datapenilaian["jenjang_jabatan"] = $jenis_pengisian;
        $this->db->insert('db_simata.t_penilaian', $datapenilaian);
        
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

    }
        // tutup kinerja 
                     //    assesment
                     $nilaiassesment = $this->getNilaiAssesment($id_pegawai); 
                     if($nilaiassesment){
                     $nilaiass = $nilaiassesment['nilai_assesment'];
                     } else {
                     $nilaiass = 0;
                     }
                     $total_nilai =  $nilaiass * 50 / 100;

                     $cekceass =  $this->db->select('*')
                         ->from('db_simata.t_penilaian_potensial a')
                         ->where('a.id_peg', $id_pegawai)
                         ->where('jenjang_jabatan', $jenis_pengisian)
                         ->where('a.nilai_assesment is not null')
                         ->where('a.flag_active', 1)
                         ->get()->row_array();

                     
                     if($cekceass){
                         $this->db->where('id_peg', $id_pegawai)
                         ->where('jenjang_jabatan', $jenis_pengisian)
                         ->update('db_simata.t_penilaian_potensial', 
                         ['nilai_assesment' => $nilaiass
                             ]);
                             $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                     } else {

                         $dataInsert['id_peg']      = $id_pegawai;
                         $dataInsert['nilai_assesment']      = $nilaiass;
                         $dataInsert['jenjang_jabatan']      = $jenis_pengisian;
                         $this->db->insert('db_simata.t_penilaian_potensial', $dataInsert);
                         $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                     }


                     $getAllNilaiPotensial =  $this->db->select('*')
                                 ->from('db_simata.t_penilaian a')
                                 ->where('a.id_peg', $id_pegawai)
                                 ->where('jenjang_jabatan', $jenis_pengisian)
                                 ->where('a.flag_active', 1)
                                 ->get()->result_array();

                     if($getAllNilaiPotensial){
                         foreach ($getAllNilaiPotensial as $rs2) {
                     
                             $total_potensial = $total_nilai + $rs2['res_potensial_rj'] + $rs2['res_potensial_lainnya'];
                         
                             $this->db->where('id_peg', $id_pegawai)
                             ->where('jenjang_jabatan', $jenis_pengisian)
                             ->update('db_simata.t_penilaian', 
                             ['res_potensial_total' => $total_potensial,
                             'res_potensial_cerdas' => $total_nilai
                             ]);
                                     
                         }
                     } else {
                         $dataInsert2['id_peg']      = $id_pegawai;
                         $dataInsert2['res_potensial_cerdas']      = $total_nilai;
                         $dataInsert2['res_potensial_total']      = $total_nilai;
                         $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                         $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                     }
                     
                     //   tutup assesment
                     
                    // rekam jejak
                        $updateMasakerja = $this->updateMasakerja($id_pegawai);

                        // testing
                        $id_rekamjjk1 = $this->getPendidikanFormal($id_pegawai); 
                        $id_rekamjjk2 = $this->getPangkatGolPengawai($id_pegawai,$id,$jenis_pengisian);
                        $id_rekamjjk3 = $this->getMasaKerjaJabatan($id_pegawai,$id,$query[0]['nm_eselon'],$jenis_pengisian); 
                        $id_rekamjjk4 = $this->getDiklatPengawai($id_pegawai,$jenis_pengisian,$query[0]['nm_eselon'],$jenis_pengisian); 
                        $id_rekamjjk5 = $this->getJPKompetensi($id_pegawai); 
                        $id_rekamjjk6 = $this->getPenghargaan($id_pegawai); 
                        $id_rekamjjk7 = $this->getHukdisPengawai($id_pegawai); 
                            
                        $id_pertimbangan1 = $this->getPengalamanOrganisasiPengawai($id_pegawai);
                        // dd($id_pertimbangan1);
                        $id_pertimbangan2 = $query[0]['pertimbangan_pimpinan'];
                        $id_pertimbangan3 = $query[0]['id_kriteria_penilaian'];
                        

                    $skor1 =  $this->getSkor($id_rekamjjk1); 
                    $bobot1 = $this->getBobot($id_rekamjjk1); 
                    $total_rj1 = $skor1  * $bobot1 / 100;   
                        
                    $skor2 =  $this->getSkor($id_rekamjjk2); 
                    $bobot2 = $this->getBobot($id_rekamjjk2); 
                    $total_rj2 = $skor2  * $bobot2 / 100; 

                    $skor3 =  $this->getSkor($id_rekamjjk3); 
                    $bobot3 = $this->getBobot($id_rekamjjk3); 
                    $total_rj3 = $skor3  * $bobot3 / 100;   
                        
                    $skor4 =  $this->getSkor($id_rekamjjk4); 
                    $bobot4 = $this->getBobot($id_rekamjjk4); 
                    $total_rj4 = $skor4  * $bobot4 / 100; 

                    $skor5 =  $this->getSkor($id_rekamjjk5); 
                    $bobot5 = $this->getBobot($id_rekamjjk5); 
                    $total_rj5 = $skor5  * $bobot5 / 100;

                    $skor6 =  $this->getSkor($id_rekamjjk6); 
                    $bobot6 = $this->getBobot($id_rekamjjk6); 
                    $total_rj6 = $skor6  * $bobot6 / 100;

                    $skor7 =  $this->getSkor($id_rekamjjk7); 
                    $bobot7 = $this->getBobot($id_rekamjjk7); 
                    $total_rj7 = $skor7  * $bobot7 / 100;

                    $skor8 =  $this->getSkor($id_pertimbangan1); 
                    $bobot8 = $this->getBobot($id_pertimbangan1); 
                    $total_pertimbangan_lainnya1 = $skor8  * $bobot8 / 100;

                    $skor9 =  $this->getSkor($id_pertimbangan2); 
                    $bobot9 = $this->getBobot($id_pertimbangan2); 
                    $total_pertimbangan_lainnya2 = $skor9  * $bobot9 / 100;

                    $skor10 =  $this->getSkor($id_pertimbangan3); 
                    $bobot10 = $this->getBobot($id_pertimbangan3); 
                    $total_pertimbangan_lainnya3 = $skor10  * $bobot10 / 100;
                    
                    $total_rj = $total_rj1 + $total_rj2 + $total_rj3 + $total_rj4 + $total_rj5  + $total_rj6  + $total_rj7;
                    $total_pertimbangan_lainnya = $total_pertimbangan_lainnya1 + $total_pertimbangan_lainnya2 + $total_pertimbangan_lainnya3;
                        $data["id_peg"] = $id_pegawai;
                        $data["pendidikan_formal"] = $id_rekamjjk1;
                        $data["pangkat_gol"] = $id_rekamjjk2;
                        $data["masa_kerja_jabatan"] = $id_rekamjjk3;
                        $data["diklat"] = $id_rekamjjk4;
                        $data["kompetensi20_jp"] = $id_rekamjjk5;
                        $data["penghargaan"] = $id_rekamjjk6;
                        $data["riwayat_hukdis"] = $id_rekamjjk7;
                        $data["pengalaman_organisasi"] = $id_pertimbangan1;
                        $data["aspirasi_karir"] = $id_pertimbangan2;
                        $data["asn_ceria"] = $id_pertimbangan3;
                        $data["jenjang_jabatan"] = $jenis_pengisian;

                        

            $cekkrj =  $this->db->select('*')
                                    ->from('db_simata.t_penilaian_potensial a')
                                    ->where('a.id_peg', $id_pegawai)
                                    ->where('jenjang_jabatan', $jenis_pengisian)
                                    ->where('a.flag_active', 1)
                                    ->where('a.nilai_assesment is not null')
                                    ->get()->result_array();

            if($cekkrj){
                $this->db->where('id_peg', $id_pegawai)
                ->where('jenjang_jabatan', $jenis_pengisian)
                ->update('db_simata.t_penilaian_potensial', 
                ['pendidikan_formal' => $id_rekamjjk1,
                'pangkat_gol' => $id_rekamjjk2,
                'masa_kerja_jabatan' => $id_rekamjjk3,
                'diklat' => $id_rekamjjk4,
                'kompetensi20_jp' => $id_rekamjjk5,
                'penghargaan' => $id_rekamjjk6,
                'riwayat_hukdis' => $id_rekamjjk7,
                'pengalaman_organisasi' => $id_pertimbangan1,
                'aspirasi_karir' => $id_pertimbangan2,
                'asn_ceria' => $id_pertimbangan3,
                'jenjang_jabatan' => $jenis_pengisian]);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
                    } else {
                        $this->db->insert('db_simata.t_penilaian_potensial', $data);
                        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

                    }


                         $getAllNilaiPotensial =  $this->db->select('*')
                        ->from('db_simata.t_penilaian a')
                        ->where('a.id_peg', $id_pegawai)
                        ->where('a.jenjang_jabatan', $jenis_pengisian)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
            
                        if($getAllNilaiPotensial){

                            foreach ($getAllNilaiPotensial as $rs2) {
                            $total_potensial = $total_nilai + $total_rj + $total_pertimbangan_lainnya;
                            $this->db->where('id_peg', $id_pegawai)
                            ->where('jenjang_jabatan', $jenis_pengisian)
                            ->update('db_simata.t_penilaian', 
                            ['res_potensial_total' => $total_potensial,
                            'res_potensial_rj' => $total_rj,
                            'res_potensial_lainnya' => $total_pertimbangan_lainnya,
                            'jenjang_jabatan' => $jenis_pengisian]);
                                        
                            }
                        } else {
                            $dataInsert2['id_peg']      = $id_pegawai;
                            $dataInsert2['res_potensial_rj']      = $total_rj;
                            $dataInsert2['jenjang_jabatan']      = $jenis_pengisian;
                            $dataInsert2['res_potensial_total']      = $total_rj;
                            $dataInsert2['res_potensial_lainnya']      = $total_pertimbangan_lainnya;
                            $this->db->insert('db_simata.t_penilaian', $dataInsert2);  
                        }

                    // tutup rekam jejak
            }  
            
            $this->db->select('*, a.id_peg as id_pegawai, c.nama_jabatan as jabatan_sekarang,
            (select pertimbangan_pimpinan from db_simata.t_penilaian_pimpinan aa where aa.id_peg = a.id_peg and aa.flag_active = 1 limit 1) as pertimbangan_pimpinan,
            (select id_m_kriteria_penilaian from db_simata.t_penilaian_sejawat bb where bb.id_peg = a.id_peg and bb.flag_active = 1 limit 1) as id_kriteria_penilaian')
                           ->from('db_pegawai.pegawai a')
                           ->join('db_simata.t_penilaian b', 'a.id_peg = b.id_peg', 'left')
                           ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                           ->join('db_pegawai.eselon h', 'c.eselon = h.nm_eselon')
                           ->where('a.id_m_status_pegawai', 1)
                           ->where('a.id_peg', $id_pegawai)
                           ->where('b.jenjang_jabatan', $jenis_pengisian)
                           ->order_by('c.eselon', 'asc')
                           ->group_by('a.id_peg');
            $query = $this->db->get()->result_array();

           return $query;
           }

    public function getDokumenPangkatForPensiun()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        // ->where('status', 2)
        ->order_by('tmtpangkat', 'desc')
        ->order_by('id', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegpangkat');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getIjazahCpns()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        ->where('ijazah_cpns', 1)
        ->from('db_pegawai.pegpendidikan');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getDokumenJabatanForLayanan()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        ->where('jenisjabatan', 10)
        // ->where('status', 2)
        ->order_by('tmtjabatan', 'desc')
        ->order_by('id', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegjabatan');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getDokumenJabatanFungsionalForLayanan()
    {
        $this->db->select('*')
        ->from('db_pegawai.pegjabatan as a')
        ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.id_jabatan')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('a.flag_active', 1)
        ->where('a.jenisjabatan', 10)
        ->where('b.jenis_jabatan', "JFT")
        ->order_by('a.tmtjabatan', 'desc')
        ->order_by('id', 'desc')
        ->limit(1);
       
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getDokumenPangkatForPensiunAdmin($id_peg)
    {
        $this->db->select('a.*, b.nm_pangkat')
        ->where('a.id_pegawai', $id_peg)
        ->where('a.flag_active', 1)
        ->where('a.status', 2)
        ->order_by('a.tmtpangkat', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegpangkat a')
        ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getDokumenJabatanForPensiun()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        ->where('status', 2)
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegjabatan');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    public function getDokumenJabatanForPensiunAdmin($id_peg)
    {
        $this->db->select('*')
        ->where('id_pegawai', $id_peg)
        ->where('flag_active', 1)
        ->where('status', 2)
        ->order_by('tmtjabatan', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegjabatan');
        $query = $this->db->get()->row_array();
        return $query;  
    }

    function getSearchPegawai($id)
{        
    $this->db->select('a.*,b.id as id_m_user');
    $this->db->where('a.skpd', $id);
    $this->db->join('m_user b', 'a.nipbaru_ws = b.username');
    $this->db->where('b.flag_active', 1);

    // $this->db->order_by('id', 'asc');
    $fetched_records = $this->db->get('db_pegawai.pegawai as a');
    $datajd = $fetched_records->result_array();
    //  dd($datajd)
    $data = array();
    foreach ($datajd as $jd) {
        $data[] = array("id" => $jd['id_m_user'], "nama" => getNamaPegawaiFull($jd));
    }
    return $data;
}

    public function automationJabatanFungsional(){
        $jabatan_siladen = $this->db->select('*')
                                    ->from('db_pegawai.jabatannew a')
                                    ->where('a.jenis_jabatan', 'JFT')
                                    ->where('a.id_jabatan_siasn IS NOT NULL')
                                    ->get()->result_array();

        $list_jabatan_siladen = null;
        foreach($jabatan_siladen as $jsil){
            $list_jabatan_siladen[$jsil['nama_jabatan']] = $jsil;
        }

        $jabatan_siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_fungsional')
                                ->get()->result_array();

        foreach($jabatan_siasn as $jsia){
            if(!isset($list_jabatan_siladen[$jsia['nama']])){
                $kelas_jabatan = "7";

                $explode_nama_jabatan = explode(" ", $jsia['nama']);
                $kategori = $explode_nama_jabatan[count($explode_nama_jabatan)-1];

                switch($kategori){
                    case "Pertama":
                        $kelas_jabatan = "8";
                        break;
                    case "Muda":
                        $kelas_jabatan = "9";
                        break;
                    case "Madya":
                        $kelas_jabatan = "10";
                        break;
                    case "Utama":
                        $kelas_jabatan = "11";
                        break;
                    case "Penyelia":
                        $kelas_jabatan = "8";
                        break;
                    case "Terampil":
                        $kelas_jabatan = "6";
                        break;
                    case "Pelaksana":
                        $kelas_jabatan = "7";
                        break;
                    default:
                        $kelas_jabatan = "6";
                }
                $data = [
                    'id_jabatanpeg' => $jsia['id'],
                    'id_unitkerja' => "9999000",
                    'id_jabatan_siasn' => $jsia['id'],
                    'nama_jabatan' => $jsia['nama'],
                    'nama_jabatan_pendek' => $jsia['nama'],
                    'jenis_jabatan' => 'JFT',
                    'eselon' => 'Non Eselon',
                    'kepalaskpd' => '0',
                    'prestasi_kerja' => '0',
                    'beban_kerja' => '0',
                    'kondisi_kerja' => '0',
                    'kelas_jabatan' => $kelas_jabatan,
                    'flag_uptd' => 0,
                    'flag_from_siasn' => 1,
                ];
                // if($kategori == "Pertama"){
                //     dd($data);
                // }
                $this->db->insert('db_pegawai.jabatannew', $data);
                echo $jsia['nama'].'<br>';
            }
        }
    }

    public function verifDokumenPdm($id, $status){
        $rs['code'] = 0;        
        $rs['message'] = 'OK';

        $this->db->trans_begin();

        $tabel = $this->input->post('tabel');
        $id_peg = $this->input->post('id_pegawai');
        $data_verif['status'] = $status;
        $data_verif['keterangan'] = $this->input->post('keterangan');
                

        $this->db->where('id', $id)
            ->update($tabel, $data_verif);
        
        // insert bidik disini

        if($tabel == "db_pegawai.pegjabatan"){
            $this->updateJabatan($id_peg);
        }

        if($tabel == "db_pegawai.pegpangkat"){
            $this->updatePangkat($id_peg);
        }

        if($tabel == "db_pegawai.peggajiberkala"){
            $this->updateBerkala($id_peg);
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;        
            $rs['message'] = 'Terjadi Kesalahan';
        }else{
            $this->db->trans_commit();
        }

        $eselonPeg = $this->general_library->getEselonPegawai($id_peg);  
        if($eselonPeg['eselon'] == "III A" || $eselonPeg['eselon'] == "III B"){
            $id = 1;
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
        } else if($eselonPeg['eselon'] == "II A" || $eselonPeg['eselon'] == "II B") {
            $id = 2;
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,3,$id);
        } else if($eselonPeg['eselon'] == "IV A" || $eselonPeg['eselon'] == "IV B") {
        $id = 3;
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,2,$id);
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,1,$id);
        } else {
            $id = 4;
            $this->simata->getPegawaiPenilaianPotensialPerPegawai($id_peg,1,$id);
        }
        
        return $rs;
    }

    public function getDataAtasanPegawai($nip){
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

        $pegawai = $this->db->select('c.id_asisten_grouping,a.id, b.gelar1, b.nipbaru_ws, b.nama, b.gelar2, c.nm_unitkerja, e.nm_pangkat, d.jenis_jabatan, d.flag_uptd,
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
                            ->where('b.nipbaru_ws', $nip)
                            ->get()->row_array();
        
        $data_atasan = $this->kinerja->getAtasanPegawai($pegawai);
        // dd($data_atasan);
        $kepala_pd = $data_atasan['kepala'];
        $atasan_pegawai = $data_atasan['atasan'];
        
        

        return $atasan_pegawai;
    }

    public function getPltPlh()
    {
        $this->db->select('*, a.id as id_pltplh')
        ->from('db_efort.t_plt_plh as a')
        ->join('db_efort.m_user b', 'a.id_m_user  = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('db_pegawai.unitkerja d', 'a.id_unitkerja = d.id_unitkerja')
        ->join('db_pegawai.jabatan e', 'a.id_jabatan = e.id_jabatanpeg')
        ->where('a.flag_active', 1)
        ->order_by('a.id', 'desc');
     
        return $this->db->get()->result_array(); 
    }

    public function loadDataPltPlhById($id)
    {
        $this->db->select('*, a.id as id_pltplh, a.id_jabatan as id_jabatan_plt_plh')
        ->from('db_efort.t_plt_plh as a')
        ->join('db_efort.m_user b', 'a.id_m_user  = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->join('db_pegawai.unitkerja d', 'a.id_unitkerja = d.id_unitkerja')
        ->join('db_pegawai.jabatan e', 'a.id_jabatan = e.id_jabatanpeg')
        ->where('a.flag_active', 1)
        ->where('a.id', $id);
     
        return $this->db->get()->row_array(); 
    }

    function getNamaJabatanStruktural(){
        $this->db->select('*, CONCAT(a.nama_jabatan," | ",b.nm_unitkerja) as jabatan')
        ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
        ->where_not_in('id_jabatanpeg', ['0000005J001','0000005J002'])
        ->where('flag_active', 1)
        ->where('jenis_jabatan', 'Struktural')
        ->group_by('a.id_jabatanpeg')
        ->order_by('a.eselon')
        ->from('db_pegawai.jabatan a');
        return $this->db->get()->result_array(); 
    }

    function getUnitKerja(){
        $this->db->select('*')
        ->where_not_in('id_unitkerja', [5])
        ->from('db_pegawai.unitkerja a');
        return $this->db->get()->result_array(); 
    }

    public function submitEditPltPlh($id){
        $this->db->trans_begin();

        if($this->input->post('pltplh_jabatan_edit')){

        $jabatan = explode(",", $this->input->post('pltplh_jabatan_edit'));
        $id_jabatan = $jabatan[0];
        $id_unitkerja = $jabatan[1];

        
            $dataEdit['jenis']     = $this->input->post('pltplh_jenis_edit');
            $dataEdit['id_unitkerja']     = $id_unitkerja;
            $dataEdit['id_jabatan']     = $id_jabatan;
            $dataEdit['tanggal_mulai']     = $this->input->post('pltplh_tgl_mulai_edit');
            $dataEdit['tanggal_akhir']     = $this->input->post('pltplh_tgl_akhir_edit');
            $dataEdit['presentasi_tpp']     = $this->input->post('pltplh_presentasi_tpp_edit');
            $dataEdit['flag_use_bpjs']     = $this->input->post('pltplh_bpjs_edit');
            // $dataEdit['id_m_user']     = $this->input->post('pltplh_id_m_user_edit');
            // dd($dataEdit);

            $this->db->where('id', $id)
                    ->update('t_plt_plh', $dataEdit);

            // $result = $this->db->insert('db_efort.t_plt_plh', $dataEdit);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        } else {
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        }
        
        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }

        return $res;
        
	}

    public function submitPltPlh()
	{

        $this->db->trans_begin();

        if($this->input->post('pltplh_jabatan')){

        $jabatan = explode(",", $this->input->post('pltplh_jabatan'));
        $id_jabatan = $jabatan[0];
        $id_unitkerja = $jabatan[1];

        
            $dataInsert['jenis']     = $this->input->post('pltplh_jenis');
            $dataInsert['id_unitkerja']     = $id_unitkerja;
            $dataInsert['id_jabatan']     = $id_jabatan;
            $dataInsert['tanggal_mulai']     = $this->input->post('pltplh_tgl_mulai');
            $dataInsert['tanggal_akhir']     = $this->input->post('pltplh_tgl_akhir');
            $dataInsert['presentasi_tpp']     = $this->input->post('pltplh_presentasi_tpp');
            $dataInsert['flag_use_bpjs']     = $this->input->post('pltplh_bpjs');
            $dataInsert['id_m_user']     = $this->input->post('pltplh_id_m_user');
            
            $result = $this->db->insert('db_efort.t_plt_plh', $dataInsert);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
        } else {
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        }
        
		
    if($this->db->trans_status() == FALSE){
        $this->db->trans_rollback();
        $res = array('msg' => 'Data gagal disimpan', 'success' => false);
    } else {
        $this->db->trans_commit();
    }

    return $res;
        
	}


    public function searchRekapVerifPeninjauanAbsensi($data){
        $result = null;
        $tanggal = explodeRangeDateNew($data['tanggal']);
      
            $this->db->select('b.nama, (select count(a.id) from db_efort.t_peninjauan_absensi as aa where a.id_m_user_verif = aa.id_m_user_verif limit 1) as total_verif ')
                    ->from('db_efort.t_peninjauan_absensi a')
                    ->join('db_efort.m_user b', 'a.id_m_user_verif = b.id')
                    ->where('a.flag_active', 1)
                    // ->where('a.status', 2)
                    ->where('a.id_m_user_verif !=', 0)
                    ->group_by('a.id_m_user_verif')
                    ->order_by('total_verif','desc');
            if(!isset($data['all'])){
                $this->db->where('DATE(a.tanggal_absensi) >=', $tanggal[0])
                            ->where('DATE(a.tanggal_absensi) <=', $tanggal[1]);
            }

            $dataresult = $this->db->get()->result_array();

           
        return $dataresult;
    }

  


    public function getPersyaratanLayanan()
    {
        $this->db->select('*')
        ->from('db_siladen.m_dokumen_layanan');
        return $this->db->get()->result_array(); 
    }


    public function getDokumenForLayananPangkat($table,$tahun)
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        // ->where('status', 2)
        ->order_by('id', 'desc')
        ->from($table);

        if($table == "db_pegawai.pegskp"){
            $this->db->where('tahun', $tahun); 
        }
        $query = $this->db->get()->row_array();
        return $query;  

    }


    function getRiwayatLayanan($id){
        $this->db->select('*')
                       ->from('t_layanan a')
                       ->where('a.id_m_user', $this->general_library->getId())
                       ->where('a.id_m_layanan', $id)
                       ->where('a.flag_active', 1)
                       ->order_by('a.id','desc');
                       $query = $this->db->get()->result_array();
                       return $query;
   }


   public function insertUsulLayananNew($id_m_layanan){
    $res['code'] = 0;
    $res['message'] = 'ok';
    $res['data'] = null;
    $this->db->trans_begin();

    $cek =  $this->db->select('*')
    ->from('t_layanan a')
    ->where('a.id_m_user', $this->general_library->getId())
    ->where('a.flag_active', 1)
    ->where('a.id_m_layanan', $id_m_layanan)
    ->where('a.status', 0)
    ->get()->result_array();

    if($cek){
        $res = array('msg' => 'Masih ada usul layanan yang belum disetujui', 'success' => false);
    } else {
        $dataUsul['id_m_user']      = $this->general_library->getId();
        $dataUsul['created_by']      = $this->general_library->getId();
        $dataUsul['id_m_layanan']      = $id_m_layanan;
        $this->db->insert('db_efort.t_layanan', $dataUsul);
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

public function searchPengajuanLayanan($id_m_layanan){
    $data = $this->input->post();
    $this->db->select('*, a.keterangan as ket_layanan, e.nama as verifikator, a.status as status_layanan, a.created_date as tanggal_pengajuan, a.id as id_pengajuan, a.status as status_pengajuan, a.created_date as tanggal_pengajuan,
     (select aa.nama from m_user as aa where a.id_m_user_verif = aa.id limit 1) as verifikator')
            ->from('t_layanan a')
            ->join('m_user d', 'a.id_m_user = d.id')
            ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
            ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
            
            ->where('a.flag_active', 1)
            ->order_by('a.created_date', 'desc');

            // if($this->general_library->isAdminAplikasi()){
            //     $this->db->where_in('a.id_m_layanan', [1,6,7]);
            //     $this->db->join('db_pegawai.pegpangkat g', 'g.id = a.reference_id_dok','left');
            // } else 
            if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9 ){
                $this->db->where_in('a.id_m_layanan', [6,7,8,9]);
                $this->db->join('db_pegawai.pegpangkat g', 'g.id = a.reference_id_dok','left');
            }  else if($id_m_layanan == 1){ 
                $this->db->where('a.id_m_layanan', 1);
            } else {
                $this->db->where('a.id_m_layanan', 99);
            }

    if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
        $this->db->where('e.skpd', $data['id_unitkerja']);
    }

    if(isset($data['status_pengajuan']) && $data['status_pengajuan'] != ""){
        $this->db->where('a.status', $data['status_pengajuan']);
    }

    return $this->db->get()->result_array();
}

function getPengajuanLayanan($id,$id_m_layanan){
    // $this->db->select('*')
    //                 ->from('t_karis_karsu a')
    //                 ->where('a.id', $id)
    //                 ->where('a.flag_active', 1);
    // return $this->db->get()->result_array();
     $this->db->select('*, c.id_m_user_verif as verifikator, b.tmtpangkat as tmt_pangkat, c.id as id_pengajuan, c.status as status_layanan')
    ->from('m_user a')
    ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
    ->join('t_layanan c', 'a.id = c.id_m_user')
    ->join('db_pegawai.pangkat f', 'b.pangkat = f.id_pangkat')
    ->join('db_pegawai.jabatan g', 'b.jabatan = g.id_jabatanpeg')
    ->join('db_pegawai.unitkerja h', 'b.skpd = h.id_unitkerja')
    ->join('db_pegawai.agama i', 'b.agama = id_agama')
    ->join('db_pegawai.unitkerjamaster j', 'h.id_unitkerjamaster = j.id_unitkerjamaster')
    ->where('c.id', $id);

    if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9){
        $this->db->join('db_pegawai.pegpangkat k', 'k.id = c.reference_id_dok','left');
    }
    
    return $this->db->get()->result_array();
}


public function getFileForVerifLayanan()
    {      
        $id_peg = $this->input->post('id_peg');
        $id_usul = $this->input->post('id_usul');
        $currentYear = date('Y'); 
		$previous1Year = $currentYear - 1;   
		$previous2Year = $currentYear - 2; 

        if($this->input->post('file') == "skcpns"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 1)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skpns"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegberkaspns as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenissk', 2)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "pak"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 11)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skpangkat"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegpangkat as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                // ->where('a.status', 2)
                ->order_by('a.tmtpangkat', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skp1"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegskp as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.tahun', $previous1Year)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skp2"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegskp as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.tahun', $previous2Year)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "ibel"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 13)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "sertiukom"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 65)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "forlap"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 12)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "diklat"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegdiklat as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenisdiklat', "00")
                ->where('a.jenjang_diklat', 2)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "suratpengantar"){
            $this->db->select('a.file_pengantar')
                ->from('t_layanan as a')
                ->where('a.id', $id_usul)
                ->where('a.flag_active', 1)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "stlud"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 10)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "uraiantugas"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 15)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "pmk"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 29)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skjabterusmenerus"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 67)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "peta"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 66)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skjabatan"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegjabatan as a')
                ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.id_jabatan')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.jenisjabatan', "10")
                ->where('b.jenis_jabatan', "JFT")
                ->order_by('a.tmtjabatan', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "akreditasi"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.pegarsip as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                ->where('a.id_dokumen', 68)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        } else if($this->input->post('file') == "skkgb"){
            $this->db->select('a.gambarsk')
                ->from('db_pegawai.peggajiberkala as a')
                ->where('a.id_pegawai', $id_peg)
                ->where('a.flag_active', 1)
                // ->where('a.status', 2)
                ->order_by('a.created_date', 'desc')
                ->limit(1);
                return $this->db->get()->result_array();
        }  else {
         return [''];
        }
        
        
    }


    public function submitVerifikasiPengajuanLayanan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        // dd($datapost);
        $this->db->trans_begin();


          
        $id_pengajuan = $datapost['id_pengajuan'];
        $data["status"] = $datapost["status"];
        $data["keterangan"] = $datapost['keterangan'];
        $data["id_m_user_verif"] = $this->general_library->getId();

       
        $this->db->where('id', $id_pengajuan)
                ->update('t_layanan', $data);

        $dataPengajuan = $this->db->select('*, c.id as id_pengajuan, c.created_date as tanggal_usul')
                ->from('m_user a')
                ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                ->join('t_layanan c', 'a.id = c.id_m_user')
                ->where('c.id', $id_pengajuan)
                ->get()->result_array();

        if($dataPengajuan[0]['status'] == 1){
            $status = "ACC";
            $statusForMessage = "disetujui";

            if($datapost['skp1']){
                $this->verifBerkas($datapost['skp1'], "db_pegawai.pegskp");
            }
            if($datapost['skp2']){
                $this->verifBerkas($datapost['skp2'], "db_pegawai.pegskp");
            }
            if($datapost['sk_cpns']){
                $this->verifBerkas($datapost['sk_cpns'], "db_pegawai.pegberkaspns");
            }
            if($datapost['sk_pns']){
                $this->verifBerkas($datapost['sk_pns'], "db_pegawai.pegberkaspns");
            }
            if(isset($datapost['diklat'])){
                $this->verifBerkas($datapost['diklat'], "db_pegawai.pegdiklat");
            }
            if($datapost['sk_pangkat']){
                $this->verifBerkas($datapost['sk_pangkat'], "db_pegawai.pegpangkat");
                $this->updatePangkat($dataPengajuan[0]['id_peg']);
            }
            if(isset($datapost['sk_jabatan'])){

                $this->verifBerkas($datapost['sk_jabatan'], "db_pegawai.pegjabatan");
                $this->updateJabatan($dataPengajuan[0]['id_peg']);
            }

            
          

        } else if($dataPengajuan[0]['status'] == 2){
            $status = "Ditolak";
            $statusForMessage = "ditolak";
        }

        $message = "*[ADMINISTRASI KEPEGAWAIAN - LAYANAN PANGKAT]*\n\nSelamat ".greeting()." ".getNamaPegawaiFull($dataPengajuan[0]).".\n\nUsul Layanan Kenaikan Pangkat anda tanggal ".formatDateNamaBulan($dataPengajuan[0]['tanggal_usul'])." telah ".$statusForMessage.".\n\nStatus: ".$status."\nCatatan Verifikator : ".$dataPengajuan[0]['keterangan']."\n\nTerima Kasih\n*BKPSDM Kota Manado*";
       
        $cronWaNextVerifikator = [
                    'sendTo' => convertPhoneNumber($dataPengajuan[0]['handphone']),
                    'message' => trim($message.FOOTER_MESSAGE_CUTI),
                    'type' => 'text',
                    'jenis_layanan' => 'Pangkat',
                    'created_by' => $this->general_library->getId()
                ];
        $this->db->insert('t_cron_wa', $cronWaNextVerifikator);

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

    function verifBerkas($id,$tabel){
        $data["status"] = 2;
        $this->db->where('id', $id)
        ->update($tabel, $data);
    }

   


    public function batalVerifikasiPengajuanLayanan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $id_usul = $datapost['id_batal'];
        $data["status"] = 0; 
        $data["keterangan"] = "";
        $this->db->where('id', $id_usul)
                ->update('t_layanan', $data);

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

    public function kerjakanPengajuanLayanan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        $this->db->trans_begin();
        $id_usul = $datapost['id_usul'];
        $id = $datapost['id'];
        if($id == 1){
            $data["id_m_user_verif"] = $this->general_library->getId();
        } else {
            $data["id_m_user_verif"] = 0;
        }
        $this->db->where('id', $id_usul)
                ->update('t_layanan', $data);
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


    public function uploadSKLayanan()
	{

        $this->db->trans_begin();
        $id_dok = $this->input->post('id_dokumen');
        $create_nama_file =  $this->prosesName($id_dok);
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
        } else if($this->input->post('id_dokumen') == 41){
            $target_dir						= './arsipsumpah/';
        } else if($this->input->post('id_dokumen') == 18){
            $target_dir						= './arsipdisiplin/';
        } else if($this->input->post('jenis_organisasi')){
            $target_dir						= './arsiporganisasi/';
        } else if($this->input->post('pegpenghargaan')){
            $target_dir						= './arsippenghargaan/';
        } else if($this->input->post('jenispenugasan')){
            $target_dir						= './arsippenugasan/';
        }     

		$random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
        $filename = str_replace(' ', '', $random_number.$create_nama_file);
        $nama_file =  $filename;
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = '*';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE; 
        $config['file_name']            = "$nama_file.pdf";

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('file')) {
			$data['error']    = strip_tags($this->upload->display_errors());
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'eror' => $data['error']);
            return $res;
		} else {
			$dataFile 			= $this->upload->data();
            $file_tmp = $_FILES['file']['tmp_name'];
            $data_file = file_get_contents($file_tmp);
            $base64 = 'data:file/pdf;base64,' . base64_encode($data_file);
            $path = substr($target_dir,2);
            $dataFile['nama_file'] =  "$nama_file.pdf";
            $dataFile['base64'] =  $base64;
			$result		        = $this->insertUploadSkLayanan($dataFile);
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

    function insertUploadSkLayanan($data)
    {
          
        $id_peg =  $this->input->post('id_pegawai');
        $id_dok  = $this->input->post('id_dokumen');
        $id_usul  = $this->input->post('id_usul');


       

        // $pegawai = $this->db->select('*')
        //         ->from('db_pegawai.pegawai a')
        //         ->where('a.id_peg', $id_peg)
        //         ->get()->row_array();
        
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
        $dataInsert['status']      = 2;
        $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
        $result = $this->db->insert('db_pegawai.pegpangkat', $dataInsert);
        $id_insert_dok = $this->db->insert_id();
        $this->updatePangkat($id_peg);

        $dataUpdate['status'] = 3;
        $dataUpdate["tanggal_usul_bkad"] =  date("Y-m-d h:i:s");
        $dataUpdate['reference_id_dok'] = $id_insert_dok;
        $url_file = "arsipelektronik/".$data['nama_file'];
      
        $this->db->where('id', $id_usul)
                ->update('t_layanan', $dataUpdate);

        $dataLayanan = $this->db->select('c.*,a.*')
                ->from('t_layanan a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                // ->join('db_pegawai.pegpangkat d', 'a.reference_id_dok = d.id')
                // ->join('db_pegawai.pangkat e', 'd.id_pegpangkat = e.id_pangkat')
                ->where('a.id', $id_usul)
                ->get()->row_array();
        
        

        $caption = "Selamat ".greeting().", Yth. ".getNamaPegawaiFull($dataLayanan).",\nBerikut kami lampirkan SK Kenaikan Pangkat Anda, File SK ini telah tersimpan dan bisa didownload pada Aplikasi Siladen anda serta telah diteruskan ke BKAD Kota Manado. Apabila terjadi kesalahan pada SK ini,silahkan kirim pesan dinomor WA ini.\n\nPosisi Usulan : BKAD\nStatus  : *Proses Di BKAD*\n\nStatus BKPSDM : *Selesai*\n\nTerima kasih.\n*BKPSDM Kota Manado*".FOOTER_MESSAGE_CUTI;
        $cronWa = [
                    'sendTo' => convertPhoneNumber($dataLayanan['handphone']),
                    'message' => $caption,
                    'filename' => "SK KENAIKAN PANGKAT.pdf",
                    'fileurl' => $url_file,
                    'type' => 'document',
                    'jenis_layanan' => 'Pangkat'
                ];
                $this->db->insert('t_cron_wa', $cronWa);
        // PANGKAT
        // GAJI BERKALA
        } else if($id_dok == 7){
            $id  = $this->input->post('id_tkgb');
            $dataKgb = $this->db->select('*')
                ->from('t_gajiberkala a')
                ->where('a.id', $id)
                ->get()->result_array();
            
            $datainsKgb["id_pegawai"] = $dataKgb[0]['id_pegawai'];
            $datainsKgb["pangkat"] = $dataKgb[0]['pangkat'];
            $datainsKgb["masakerja"] =$dataKgb[0]['masakerja'];
            $datainsKgb["pejabat"] = "Wali Kota Manado";
            $datainsKgb["nosk"] = $dataKgb[0]['nosk'];
            $datainsKgb["tglsk"] = $dataKgb[0]['tglsk'];
            $datainsKgb["tmtgajiberkala"] = $dataKgb[0]['tmtgajiberkala'];
            $datainsKgb["gajilama"] = $dataKgb[0]['gajilama'];
            $datainsKgb["gajibaru"] = $dataKgb[0]['gajibaru'];
            $datainsKgb["status"] = 3;
            $datainsKgb["gambarsk"] = $data['file_name'];
          
            $this->db->insert('db_pegawai.peggajiberkala', $datainsKgb);
            $id_peggajiberkala = $this->db->insert_id();
            $datainsKgb["id_peggajiberkala"] = $id_peggajiberkala;
            $this->db->where('id', $id)
            ->update('t_gajiberkala', $datainsKgb);
            
            $this->updateBerkala($dataKgb[0]['id_pegawai']);
            $result = array('msg' => 'Data berhasil disimpan', 'success' => true);
        }
        // GAJI BERKALA
        return $result;
    }


    public function deleteFileLayanan($id_usul,$reference_id_dok,$id_m_layanan, $id_pegawai){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $this->db->trans_begin();
       
        $dataLayanan = $this->db->select('c.*,a.*')
        ->from('t_layanan a')
        ->join('m_user b', 'a.id_m_user = b.id')
        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        ->where('a.id', $id_usul)
        ->get()->row_array();

        // PANGKAT 
        if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 0){
        $data["reference_id_dok"] = null; 
        $this->db->where('id', $id_usul)
                    ->update('t_layanan', $data);
                  
        $this->db->where('id', $reference_id_dok)
                    ->update('db_pegawai.pegpangkat', ['flag_active' => 0, 'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0]);
        $this->updatePangkat($dataLayanan['id_peg']);
        }
         // PANGKAT

        // GAJI BERKALA 
        if($id_m_layanan == 90){
            $data["id_peggajiberkala"] = null; 
            $data["status"] = 1;
            $this->db->where('id', $id_usul)
                        ->update('t_gajiberkala', $data);
                      
            $this->db->where('id', $reference_id_dok)
                        ->update('db_pegawai.peggajiberkala', ['flag_active' => 0, 'updated_by' => $this->general_library->getId() ? $this->general_library->getId() : 0]);
            $this->updateBerkala($id_pegawai);
            }
        // GAJI BERKALA
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

    public function getDokumenDiklatForVerifLayanan()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('jenisdiklat', "00")
        ->where('jenjang_diklat', 2)
        ->where('flag_active', 1)
        ->where('status', 1)
        ->order_by('id', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegdiklat');
        $query = $this->db->get()->row_array();
        return $query;  
    }
    

    public function kirimBkad($id_usul,$status){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $this->db->trans_begin();

            $data["status"] = $status; 
            $data["tanggal_usul_bkad"] =  date("Y-m-d h:i:s");

            $this->db->where('id', $id_usul)
                    ->update('t_layanan', $data);
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

    public function kirimBerkalaBkad($id_usul,$status){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $this->db->trans_begin();

            $data["status"] = $status; 
            $data["tanggal_usul_bkad"] =  date("Y-m-d");
            $this->db->where('id', $id_usul)
                    ->update('t_gajiberkala', $data);
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

    public function searchUsulPangkatBkad(){
        $data = $this->input->post();
        $this->db->select('*, a.status as status_layanan, a.created_date as tanggal_pengajuan, a.id as id_pengajuan, a.status as status_pengajuan, a.created_date as tanggal_pengajuan')
                ->from('t_layanan a')
                ->join('m_user d', 'a.id_m_user = d.id')
                ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                ->join('db_pegawai.pegpangkat g', 'g.id = a.reference_id_dok','left')
                ->where('a.flag_active', 1)
                // ->where('a.status', 3)
                ->where_in('a.id_m_layanan', [6,7,8,9])
                ->order_by('g.tmtpangkat', 'desc');
                if(isset($data['status_pengajuan']) && $data['status_pengajuan'] != ""){
                    $this->db->where('a.status', $data['status_pengajuan']);
                } else {
                    $this->db->where_in('a.status', [3,4,5]);
                }
               
        return $this->db->get()->result_array();
    }

    public function verifikasiBerkalaBkadItem(){
        $data = $this->input->post();
        $this->db->select('*, a.status as status_berkala, a.id as id_berkala')
                ->from('t_gajiberkala a')
                ->join('db_pegawai.pegawai e', 'a.id_pegawai = e.id_peg')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                ->join('db_pegawai.peggajiberkala g', 'g.id = a.id_peggajiberkala','left')
                ->where('a.flag_active', 1)
                // ->where('a.status', 3)
                ->order_by('a.created_date', 'desc');
                if(isset($data['status_berkala']) && $data['status_berkala'] != ""){
                    $this->db->where('a.status', $data['status_berkala']);
                } else {
                    $this->db->where_in('a.status', [3,4,5]);
                }
               
        return $this->db->get()->result_array();
    }


    public function submitVerifikasiPangkatBkad(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();

          
        $id_pengajuan = $datapost['id_pengajuan'];
        $data["status"] = $datapost["status"];
        $data["keterangan_bkad"] = $datapost['keterangan'];
        $this->db->where('id', $id_pengajuan)
                ->update('t_layanan', $data);


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

    public function submitVerifikasiBerkalaBkad(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();

          
        $id_berkala = $datapost['id_berkala'];
        $data["status"] = $datapost["status"];
        $data["keterangan_bkad"] = $datapost['keterangan'];
        $this->db->where('id', $id_berkala)
                ->update('t_gajiberkala', $data);


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

    public function insertUsulLayananNew2($id_m_layanan)
	{

        $this->db->trans_begin();

        $cek =  $this->db->select('*')
        ->from('t_layanan a')
        ->where('a.id_m_user', $this->general_library->getId())
        ->where('a.flag_active', 1)
        ->where('a.id_m_layanan', $id_m_layanan)
        ->where_in('a.status', [0,2])
        ->get()->result_array();

        if($cek){
            $res = array('msg' => 'Sudah ada usul layanan Pangkat', 'success' => false);
        } else {
            $nip = $this->input->post('nip');
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9){
                $nama_file = "pengantar_$nip"."_$random_number";
                $target_dir	= './dokumen_layanan/pangkat';
            } else {
                $nama_file = "pengantar_$nip"."_$random_number";
            } 


            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE;
            $config['file_name']            = "$nama_file.pdf";
            
            $this->load->library('upload', $config);
          
            // coba upload file		
            if (!$this->upload->do_upload('file')) {
                $data['error']    = strip_tags($this->upload->display_errors());
                $data['token']    = $this->security->get_csrf_hash();
                $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' =>$data['error']);
                return $res;
            } else {
                $dataFile 			= $this->upload->data();
                    $dataUsul['id_m_user']      = $this->general_library->getId();
                    $dataUsul['created_by']      = $this->general_library->getId();
                    $dataUsul['id_m_layanan']      = $id_m_layanan;
                    $dataUsul['file_pengantar']      = "$nama_file.pdf";
                    $this->db->insert('db_efort.t_layanan', $dataUsul);
                    $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
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

    public function ajukanKembaliLayananPangkat($fieldName, $fieldValue, $tableName)
    {
        $this->db->where($fieldName, $fieldValue)
                    ->update($tableName, ['status' => 0, 'updated_by' => $this->general_library->getId()]);
    }

    public function submitEditSPLayanan(){

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $target_dir = './dokumen_layanan/pangkat/';
        $filename = str_replace(' ', '', $this->input->post('file_pengantar')); 
    
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$filename;
    
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'pdf';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = "$filename"; 

		$this->load->library('upload', $config);
		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());            
            $res = array('msg' => 'Data gagal disimpan', 'success' => false, 'error' => $data['error']);
            return $res;

		} else {
			$dataFile = $this->upload->data();
            $id = $datapost['id_pengajuan'];
            $data["file_pengantar"] = $filename;
            $this->db->where('id', $id)
                    ->update('t_layanan', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
		}
        

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       public function submitProsesKenaikanGajiBerkala(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
        
        $this->db->trans_begin();

          
        $data["status"] = $datapost["status"];
        $data["keterangan"] = $datapost['keterangan'];
        $data["id_m_user_verif"] = $this->general_library->getId();

       $nama = $this->general_library->getNamaUser();
    
        $dataPegawai = $this->db->select('*')
                ->from('db_pegawai.pegawai a')
                ->where('id_peg', $datapost["id_pegawai"])
                ->get()->row_array();

        $dataKgb = [
            'id_pegawai' => $datapost["id_pegawai"],
            // 'masakerja' => "6",
            // 'pejabat' => 'text',
            // 'nosk' => 'Pangkat',
            // 'tglsk' => 'Pangkat',
            // 'gajilama' => 'Pangkat',
            // 'gajibaru' => 'Pangkat',
            // 'tmtgajiberkala' => 'Pangkat',
            'status' =>$datapost["status"],
            'keterangan' =>$datapost["keterangan"],
            'tahun' =>$datapost["tahun"],
            'created_by' => $this->general_library->getId(),
            'id_m_user_verif' => $this->general_library->getId(),
            'nm_m_user_verif' => $this->general_library->getNamaUser()
        ];
         $this->db->insert('t_gajiberkala', $dataKgb);

         if($datapost["status"] == 1){
        $message = "*[ADMINISTRASI KEPEGAWAIAN - LAYANAN KENAIKAN GAJI BERKALA]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($dataPegawai).",\n\nSK Kenaikan Gaji Berkala anda telah diproses. \n\nTerima kasih.";

         } else {
        $message = "*[ADMINISTRASI KEPEGAWAIAN - LAYANAN KENAIKAN GAJI BERKALA]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($dataPegawai).",\n\n".$datapost['keterangan'].". \n\nTerima kasih.";
            
         }
        $cronWaNextVerifikator = [
                    'sendTo' => convertPhoneNumber($dataPegawai['handphone']),
                    'message' => trim($message.FOOTER_MESSAGE_CUTI),
                    'type' => 'text',
                    'jenis_layanan' => 'Gaji Berkala',
                    'created_by' => $this->general_library->getId()
                ];
        $this->db->insert('t_cron_wa', $cronWaNextVerifikator);

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

    public function cekProsesKenaikanBerkala($id_pegawai,$tahun){
        $this->db->select('*')
                ->from('t_gajiberkala a')
                ->where('a.tahun', $tahun)
                ->where('a.id_pegawai', $id_pegawai)
                ->where('a.flag_active', 1);
        return $this->db->get()->result_array();
    }

    public function batalVerifikasiProsesKgb(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;

        $datapost = $this->input->post();
      
        $this->db->trans_begin();
        $id_usul = $datapost['id_batal'];
        $data["flag_active"] = 0; 
        $data["keterangan"] = "";
        $this->db->where('id', $id_usul)
                ->update('t_gajiberkala', $data);

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

    public function simpanDataDrafKgb(){

        $datapost = $this->input->post();
        $this->db->trans_begin();
      
        // dd($datapost);
            $id = $datapost['id'];
            $data["pangkat"] = $datapost["edit_gb_pangkat"];
            $data["masakerja"] = $datapost["edit_gb_masa_kerja"];
            $data["pejabat"] = "Wali Kota Manado";
            $data["nosk"] = $datapost["edit_gb_no_sk"];
            $data["tglsk"] = $datapost["edit_gb_tanggal_sk"];
            $data["tmtgajiberkala"] = $datapost["edit_tmt_gaji_berkala"];
            $data["gajilama"] = $datapost["gajilama"];
            $data["gajibaru"] = $datapost["gajibaru"];
            $this->db->where('id', $id)
                    ->update('t_gajiberkala', $data);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

        

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
        } else {
            $this->db->trans_commit();
        }
    
        return $res;

       }

       function getStatusLayananPangkat($id){
        $this->db->select('a.status')
                       ->from('m_layanan a')
                       ->where('a.id', $id)
                       ->where('a.flag_active', 1);
                       $query = $this->db->get()->row_array();
                       return $query;
   }

   public function loadListGajiBerkalaSelesai(){
    $data = $this->input->post();
    $this->db->select('*, a.id as id_t_berkala, a.status as status_berkala')
            ->from('t_gajiberkala a')
            ->join('db_pegawai.pegawai e', 'a.id_pegawai = e.id_peg')
            ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
            ->join('db_pegawai.peggajiberkala g', 'g.id = a.id_peggajiberkala')
            ->where('a.flag_active', 1)
            // ->where('a.status', 2)
            ->where('year(a.tmtgajiberkala)', $data['gb_tahun']);
            if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
                $this->db->where('e.skpd', $data['id_unitkerja']);
            }
            if(isset($data['status']) && $data['status'] != "0"){
                $this->db->where('a.status', $data['status']);
            }
         

    return $this->db->get()->result_array();
}

public function checkListIjazahCpns($id, $id_pegawai){
    $rs['code'] = 0;        
    $rs['message'] = 'OK';

    $this->db->trans_begin();

    $data['ijazah_cpns'] = 0;
    $dataCheck['ijazah_cpns'] = 1;
            
    $this->db->where('id_pegawai', $id_pegawai)
        ->update('db_pegawai.pegpendidikan', $data);
    
    $this->db->where('id', $id)
        ->update('db_pegawai.pegpendidikan', $dataCheck);
    
   

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
