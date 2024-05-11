<?php
class M_Kepegawaian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
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
                $this->db->where('b.skpd', $data['unitkerja']);
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
            $this->db->select('a.*, g.nm_statusjabatan, b.nm_agama, c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja,
            h.nama_kabupaten_kota,i.nama_kecamatan,j.nama_kelurahan')
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
                ->where('a.nipbaru_ws', $username)
                ->limit(1);
            return $this->db->get()->row_array();
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
            $this->db->select('q.nama_status_pegawai,f.id_unitkerjamaster,l.id as id_m_user,l.id_m_sub_bidang,o.nama_bidang,p.nama_sub_bidang,n.nama_kelurahan,m.nama_kecamatan,c.id_tktpendidikan,d.id_pangkat,k.id_statusjabatan,j.id_jenisjab,id_jenispeg,h.id_statuspeg,
            g.id_sk,b.id_agama,e.eselon,j.nm_jenisjab,i.nm_jenispeg,h.nm_statuspeg,g.nm_sk,a.*, b.nm_agama, a.id_m_status_pegawai,
            c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja, l.id as id_m_user, k.nm_statusjabatan,
            (SELECT CONCAT(aa.nm_jabatan,"|",aa.tmtjabatan,"|",aa.statusjabatan) from db_pegawai.pegjabatan as aa where a.id_peg = aa.id_pegawai and aa.flag_active in (1,2) and aa.status = 2 and aa.statusjabatan not in (2,3) ORDER BY aa.tmtjabatan desc limit 1) as data_jabatan,
            (SELECT CONCAT(cc.nm_pangkat,"|",bb.tmtpangkat,"|",bb.status) from db_pegawai.pegpangkat as bb
            join db_pegawai.pangkat as cc on bb.pangkat = cc.id_pangkat where a.id_peg = bb.id_pegawai and bb.flag_active = 1 and bb.status = 2  ORDER BY bb.tmtpangkat desc limit 1) as data_pangkat,
            r.nama_kabupaten_kota,m.nama_kecamatan,n.nama_kelurahan')
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
                // ->where('l.flag_active', 1)
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
                // ->where('l.flag_active', 1)
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
             $this->db->select('e.nm_tktpendidikanb as nm_tktpendidikan,c.id,c.status,c.namasekolah,c.fakultas,c.pimpinansekolah,c.tahunlulus,c.noijasah,c.tglijasah,c.gambarsk,c.jurusan,c.keterangan')
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
              $this->db->select('c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk,c.keterangan')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                            // ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
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
          
            $this->db->select('c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk')
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
             $this->db->select('e.jenjang_diklat,c.created_date,c.keterangan,c.id,c.status,d.nm_jdiklat,c.nm_diklat,c.tptdiklat,c.penyelenggara,c.angkatan,c.jam,c.tglmulai,c.tglselesai,c.tglsttpp,c.nosttpp,c.gambarsk,c.keterangan')
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
            $this->db->select('c.id,d.nama,e.nama_jhd,c.jp,c.status,c.nosurat,c.tglsurat,c.gambarsk')
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
             $this->db->select('c.created_date,c.id,c.status,c.masakerja,d.nm_pangkat,c.pejabat,c.nosk,c.tglsk,c.tmtgajiberkala,c.gambarsk,c.keterangan')
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
                            ->where('a.flag_active', 1);
                            // ->order_by('c.tglsk','desc')
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
        $this->db->select('*')
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
                $newStr = explode(",", $str);
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

          $result = $this->db->insert('db_pegawai.pegjabatan', $dataInsert);
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
            $dataInsert['id_pegawai']      = $id_peg;
            $dataInsert['hd']         = $this->input->post('disiplin_hd');
            $dataInsert['jhd']         = $this->input->post('disiplin_jhd');
            $dataInsert['jp']         = $this->input->post('disiplin_jp');
            // $dataInsert['tgl_mulai']         = $this->input->post('disiplin_tglmulai');
            // $dataInsert['tgl_selesai']         = $this->input->post('disiplin_tglselesai');
            $dataInsert['nosurat']         = $this->input->post('disiplin_nosurat');
            $dataInsert['tglsurat']         = $this->input->post('disiplin_tglsurat');
            $dataInsert['gambarsk']            = $data['nama_file'];
            $dataInsert['created_by']      = $this->general_library->getId();
            if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){
                $dataInsert['status']      = 2;
                $dataInsert['tanggal_verif']      = date('Y-m-d H:i:s');
                $dataInsert['id_m_user_verif']      = $this->general_library->getId();
            }
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
        $filename = $random_number.$create_nama_file;
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

            $dataInsert['id_pegawai']     = $this->input->post('id_pegawai');
            $dataInsert['nilai_assesment']      = $this->input->post('nilai_assesment');
            $dataInsert['tahun']      = $this->input->post('tahun');
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
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$dataFile['file_name'];
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

    public function doUploadInovasi()
	{

        $this->db->trans_begin();
            
        $target_dir						= './arsipinovasi/';
        
		
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
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $filename = $random_number.$dataFile['file_name'];
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
        $this->db->select('c.jenis_layanan,c.status,f.nm_unitkerja,b.nama,b.gelar1,b.gelar2,c.id_usul,e.nama as nama_layanan,c.tanggal_usul,c.file_pengantar,a.username as nip')
                        ->from('m_user a')
                        ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                        ->join('db_siladen.usul_layanan c', 'a.id = c.usul_by')
                        ->join('db_siladen.jenis_layanan e', 'c.jenis_layanan = e.kode')
                        ->join('db_pegawai.unitkerja f', 'b.skpd = f.id_unitkerja')
                        // ->where('c.jenis_layanan', 3)
                        ->where('c.status', $id)
                        ->where('c.flag_active', 1)
                        ->order_by('c.id_usul', 'desc');

        // if(!$this->general_library->isProgrammer() && !$this->general_library->isAdminAplikasi()){
        //     $this->db->where_in('e.kode', $this->general_library->listHakAkses());
        // }

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
    // ->where('flag_active', 1)
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
    if(trim($datapost["jenis_dokumen"]) == "jabatan"){
    $data["tmtjabatan"] = $datapost["edit_tmt_jabatan_verif"];
    }

 
    
   
    //  if(trim($datapost["jenis_dokumen"]) == "jabatan"){
    //     $this->updateJabatan($id_peg);
    //     $getJabatan = $this->db->select('*')
    //     ->from('db_pegawai.pegjabatan a')
    //     ->where('a.id_pegawai', $datapost["id_pegawai"])
    //     ->where('a.flag_active', 1)
    //     ->where('a.status', 2)
    //     ->order_by('tmtjabatan', 'desc')
    //     ->limit(1)
    //     ->get()->row_array();

    //     $getJabatanPost = $this->db->select('*')
    //     ->from('db_pegawai.pegjabatan a')
    //     ->where('a.id', $datapost["id"])
    //     ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
    //     ->limit(1)
    //     ->get()->row_array();
      
    //     if($getJabatanPost['statusjabatan'] == 1){
    //     if(strtotime($getJabatanPost['tmtjabatan']) > strtotime($getJabatan['tmtjabatan'])){
    //         $dataUpdate["skpd"] =  $getJabatanPost['id_unitkerja'];
    //         $dataUpdate["tmtjabatan"] =  $getJabatanPost['tmtjabatan'];
    //         $dataUpdate["jabatan"] =   $getJabatanPost['id_jabatan'];
    //         $dataUpdate["jenisjabpeg"] =  $getJabatanPost['jenisjabatan'];
    //         $this->db->where('id_peg', $datapost["id_pegawai"])
    //                 ->update('db_pegawai.pegawai', $dataUpdate);
    //     } 
    //     }
    //     }

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

    if(trim($datapost["jenis_dokumen"]) == "jabatan"){
        $this->updateJabatan($id_peg);
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
 
    $this->db->where('id', $id)
    ->update('db_pegawai.'.$datapost['db_dokumen_batal'], $data);
   
    // if(trim($datapost["jenis_dokumen_batal"]) == "jabatan"){
    //     $this->updateJabatan($id_peg);
    //     $getJabatanPost = $this->db->select('*')
    //     ->from('db_pegawai.pegjabatan a')
    //     ->where('a.id', $datapost["id_batal"])
    //     ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
    //     ->limit(1)
    //     ->get()->row_array();

       
    //     $getJabatan = $this->db->select('*')
    //     ->from('db_pegawai.pegjabatan a')
    //     ->join('db_pegawai.unitkerja b', 'a.skpd = b.nm_unitkerja')
    //     ->where('a.id_pegawai', $datapost["id_pegawai_batal"])
    //     ->where('a.flag_active', 1)
    //     ->where('a.status', 2)
    //     ->where('a.tmtjabatan <', $getJabatanPost['tmtjabatan'])
    //     ->order_by('tmtjabatan', 'desc')
    //     ->limit(1)
    //     ->get()->row_array();

    //         $dataUpdate["skpd"] =  $getJabatan['id_unitkerja'];
    //         $dataUpdate["tmtjabatan"] =  $getJabatan['tmtjabatan'];
    //         $dataUpdate["jabatan"] =   $getJabatan['id_jabatan'];
    //         $dataUpdate["jenisjabpeg"] =  $getJabatan['jenisjabatan'];
    //         $this->db->where('id_peg', $datapost["id_pegawai_batal"])
    //                 ->update('db_pegawai.pegawai', $dataUpdate);
        
    // }

       
   
   

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
    $data["handphone"] = $datapost["edit_no_hp"];
    $data["email"] = $datapost["edit_email"];

    $data["id_m_provinsi"] = 71;
    if(isset($datapost['edit_kab_kota'])){
    $data["id_m_kabupaten_kota"] = $datapost["edit_kab_kota"];
    $data["id_m_kecamatan"] = $datapost["edit_kecamatan"];
    $data["id_m_kelurahan"] = $datapost["edit_kelurahan"];
    }
    $data["id_m_status_pegawai"] = $datapost["edit_id_m_status_pegawai"];
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
    
    return $this->db->get()->result_array(); 
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
        $fetched_records = $this->db->get('db_pegawai.jabatan');
        $datajab = $fetched_records->result_array();
    } else {
        if($jnsfung == "1"){
            $this->db->select('id_jabatanpeg, nama_jabatan');
            $this->db->or_where('jenis_jabatan', "JFT");
            $this->db ->where_not_in('nama_jabatan', ['Pelaksana']);
            $this->db->group_by('nama_jabatan');
            $fetched_records = $this->db->get('db_pegawai.jabatan');
            $datajab = $fetched_records->result_array();
        } else {
            $this->db->select('id_jabatanpeg, nama_jabatan');
            $this->db->where('jenis_jabatan', "JFU");
            $this->db->where('id_unitkerja', $id_skpd);
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

        function getJabatanPegawaiEdit($id){
            $this->db->select('b.skpd,c.eselon,c.pejabat,c.jenisjabatan,c.id_jabatan,c.statusjabatan,c.id_pegawai,c.created_date,c.id,c.status,c.nm_jabatan as nama_jabatan,c.tmtjabatan,c.angkakredit, e.nm_eselon,c.skpd,c.nosk,c.tglsk,c.ket,c.gambarsk,c.keterangan')
                          ->from('m_user a')
                          ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                          ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                          // ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
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


public function submitEditJabatan(){

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
            $newStr = explode(",", $str);
            $id_jabatan = $newStr[0];
            $nama_jabatan = $newStr[1]; 

            $id = $datapost['id'];
            // $data['nm_jabatan']      = $this->input->post('edit_jabatan_nama');
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
            $data['updated_by']      = $this->general_library->getId();
            $data["gambarsk"] = $filename;
             $this->db->where('id', $id)
                ->update('db_pegawai.pegjabatan', $data);
    

        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

    }
    } else {
        $str = $this->input->post('jabatan_nama');
        if($str){
            $newStr = explode(",", $str);
            $id_jabatan = $newStr[0];
            $nama_jabatan = $newStr[1];
            $data['id_jabatan']      = $id_jabatan; 
        }
       
        
        $id = $datapost['id'];
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
        $data['updated_by']      = $this->general_library->getId();
        $this->db->where('id', $id)
                ->update('db_pegawai.pegjabatan', $data);
    
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);

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
            $data["pejabat"] = $datapost["edit_gb_pejabat"];
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

        $rs['data_pegawai'] = $this->db->select('a.*, b.nm_unitkerja, c.nama_jabatan, d.nm_pangkat, e.nm_agama,
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

            $rs['riwayat_pangkat'] = $this->db->select('a.*, c.nm_pangkat, d.nm_jenispengangkatan')
                                            ->from('db_pegawai.pegpangkat a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                                            ->join('db_pegawai.jenispengangkatan d', 'a.jenispengangkatan = d.id_jenispengangkatan')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->order_by('tmtpangkat', 'asc')
                                            ->get()->result_array();

            $rs['riwayat_diklat'] = $this->db->select('a.*, c.nm_jdiklat')
                                            ->from('db_pegawai.pegdiklat a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_pegawai.diklat c', 'a.jenisdiklat = c.id_diklat')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->order_by('tglsttpp', 'asc')
                                            ->get()->result_array();

            $rs['riwayat_jabatan'] = $this->db->select('a.*')
                                            ->from('db_pegawai.pegjabatan a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            // ->join('db_pegawai.jabatan c', 'a.id_jabatan = c.id_jabatanpeg')
                                            // ->join('db_pegawai.unitkerja d', 'c.id_unitkerja = d.id_unitkerja')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->order_by('tmtjabatan', 'asc')
                                            ->get()->result_array();

            $rs['riwayat_keluarga'] = $this->db->select('a.*, c.nm_keluarga')
                                            ->from('db_pegawai.pegkeluarga a')
                                            ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                                            ->join('db_pegawai.keluarga c', 'a.hubkel = c.id_keluarga')
                                            ->where('b.id_peg', $rs['data_pegawai']['id_peg'])
                                            ->order_by('tgllahir', 'asc')
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

    public function submitPermohonanCuti(){
        $data = $this->input->post();
        $res['code'] = 0;
        $res['message'] = "Pengajuan Cuti Berhasil";
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
                $data['surat_pendukung'] = $filename;
                $data['created_by'] = $this->general_library->getId();
                $data['id_m_user'] = $this->general_library->getId();
                $data['tanggal_mulai'] = date('Y-m-d', strtotime($data['tanggal_mulai']));
                $data['tanggal_akhir'] = date('Y-m-d', strtotime($data['tanggal_akhir']));
                $data['lama_cuti'] = floatval($data['lama_cuti']);
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

                $atasan = $this->db->select('a.*')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                ->where('c.kepalaskpd', 1)
                                ->where('a.skpd', $this->general_library->getIdUnitKerjaPegawai())
                                ->get()->row_array();

                if($atasan){
                    $master = $this->db->select('*')
                                    ->from('db_pegawai.cuti')
                                    ->where('id_cuti', $data['id_cuti'])
                                    ->get()->row_array();

                    $encrypt = simpleEncrypt($atasan['nipbaru_ws'].'-'.$insert_id);
                    $link = base_url('whatsapp-verification/cuti/'.$encrypt);
                    $message = "*[PENGAJUAN CUTI]*\n\nSelamat ".greeting().", pegawai atas nama: ".$this->general_library->getNamaUser()." telah mengajukan Permohonan ".$master['nm_cuti'].". Mohon segera diverifikasi dengan klik link dibawah ini. \n\n".$link;
                    $sendTo = convertPhoneNumber($atasan['handphone']);
                    // $this->maxchatlibrary->sendText($sendTo, $message, 0, 0);
                    $cronWa = [
                        'sendTo' => $sendTo,
                        'message' => $message.FOOTER_MESSAGE_CUTI,
                        'type' => 'text'
                    ];
                    $this->general->saveToCronWa($cronWa);
                } else {
                    $res['code'] = 1;
                    $res['message'] = "Terjadi Kesalahan";
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
        $riwayat = $this->db->select('a.*, b.nama_status, c.nm_cuti')
                    ->from('t_pengajuan_cuti a')
                    ->join('m_status_pengajuan_cuti b', 'a.id_m_status_pengajuan_cuti = b.id')
                    ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti')
                    ->where('id_m_user', $this->general_library->getId())
                    ->where('a.flag_active', 1)
                    ->order_by('created_date', 'desc')
                    ->get()->result_array();

        $list_id = null;
        if($riwayat){
            foreach($riwayat as $rw){
                $list_id[] = $rw['id'];
                if($rw['id_m_status_pengajuan_cuti'] == 4 && $rw['url_sk'] == null){
                    $rw['nama_status'] .= ', menuggu DS SK';
                }

                if($rw['url_sk'] != null){
                    $rw['id_m_status_pengajuan_cuti'] = 6;
                    $rw['nama_status'] = 'Selesai';
                }

                $result[$rw['id']] = $rw;
                $result[$rw['id']]['detail'] = null;
                $progress[0]['keterangan'] = "PENGAJUAN, menunggu Verifikasi Atasan";
                $progress[0]['icon'] = "fa fa-spin fa-spinner";
                $progress[0]['color'] = "yellow";
                $progress[0]['font-color'] = "black";
                if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 2){
                    $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
                    $progress[1]['icon'] = "fa fa-spin fa-spinner";
                    $progress[1]['color'] = "yellow";
                    $progress[1]['font-color'] = "black";
                } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 3){
                    $progress[1]['keterangan'] = "DITOLAK OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan'])." : ".$result[$rw['id']]['keterangan_verifikasi_atasan'];
                    $progress[1]['icon'] = "fa fa-times";
                    $progress[1]['color'] = "red";
                    $progress[1]['font-color'] = "white";
                }

                if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 4){
                    $progress[1]['icon'] = "fa fa-check";
                    $progress[1]['color'] = "green";
                    $progress[1]['font-color'] = "white";
                    $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
                    if($result[$rw['id']]['url_sk']){
                        $progress[2]['keterangan'] = "VERIFIKASI KEPALA BKPSDM SELESAI pada ".formatDateNamaBulanWT($result[$rw['id']]['updated_date']).". SK Cuti sudah dapat diunduh.";
                        $progress[2]['icon'] = "fa fa-check";
                        $progress[2]['color'] = "green";
                        $progress[2]['font-color'] = "white";
                    } else {
                        $progress[2]['keterangan'] = "DITERIMA OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
                        $progress[2]['icon'] = "fa fa-spin fa-spinner";
                        $progress[2]['color'] = "yellow";
                        $progress[2]['font-color'] = "black";
                    }
                } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 5){
                    $progress[2]['keterangan'] = "DITOLAK OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm'])." : ".$result[$rw['id']]['keterangan_verifikasi_kepala_bkpsdm'];
                    $progress[2]['icon'] = "fa fa-times";
                    $progress[2]['color'] = "red";
                    $progress[2]['font-color'] = "white";
                } else if($result[$rw['id']]['id_m_status_pengajuan_cuti'] == 6){
                    $progress[1]['icon'] = "fa fa-check";
                    $progress[1]['color'] = "green";
                    $progress[1]['font-color'] = "white";
                    $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_atasan']).". Menunggu Verifikasi BKPSDM";
        
                    $progress[2]['keterangan'] = "SELESAI VERIFIKASI BKPSDM pada ".formatDateNamaBulanWT($result[$rw['id']]['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
                    $progress[2]['icon'] = "fa fa-check";
                    $progress[2]['color'] = "green";
                    $progress[2]['font-color'] = "white";
        
                    $progress[3]['keterangan'] = "SK SUDAH SELESAI DS PADA ".formatDateNamaBulanWT($result[$rw['id']]['updated_date']);
                    $progress[3]['icon'] = "fa fa-check";
                    $progress[3]['color'] = "green";
                    $progress[3]['font-color'] = "white";
                }

                if($result[$rw['id']]['id_m_status_pengajuan_cuti'] != 1){
                    $progress[0]['icon'] = "fa fa-check";
                    $progress[0]['color'] = "green";
                    $progress[0]['font-color'] = "white";
                }
                
                $result[$rw['id']]['progress'] = $progress;
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
		$res['message'] = 'Pengajuan Cuti Berhasil';
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
        $this->db->select('a.*, b.nama_status, c.nm_cuti, e.gelar1, e.nama, e.gelar2, e.nipbaru_ws, f.nm_unitkerja')
                ->from('t_pengajuan_cuti a')
                ->join('m_status_pengajuan_cuti b', 'a.id_m_status_pengajuan_cuti = b.id')
                ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti')
                ->join('m_user d', 'a.id_m_user = d.id')
                ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                ->where('a.flag_active', 1)
                ->order_by('a.id_m_status_pengajuan_cuti', 'asc')
                ->order_by('created_date', 'asc');

        if(isset($data['id_unitkerja']) && $data['id_unitkerja'] != "0"){
            $this->db->where('e.skpd', $data['id_unitkerja']);
        }

        if(isset($data['id_m_status_pengajuan_cuti']) && $data['id_m_status_pengajuan_cuti'] != "0"){
            $this->db->where('a.id_m_status_pengajuan_cuti', $data['id_m_status_pengajuan_cuti']);
        }

        if($this->general_library->isKepalaPd() && !$this->general_library->isKepalaBkpsdm()){
            $this->db->where('e.skpd', $this->general_library->getUnitKerjaPegawai());
        }
        return $this->db->get()->result_array();
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
        $result = $this->db->select('a.*, b.nama_status, c.nm_cuti, e.gelar1, e.nama, e.gelar2, e.nipbaru_ws, f.nm_unitkerja,
                g.nama_jabatan, h.nm_pangkat, d.id as id_m_user, g.eselon, f.id_unitkerja')
                ->from('t_pengajuan_cuti a')
                ->join('m_status_pengajuan_cuti b', 'a.id_m_status_pengajuan_cuti = b.id')
                ->join('db_pegawai.cuti c', 'a.id_cuti = c.id_cuti')
                ->join('m_user d', 'a.id_m_user = d.id')
                ->join('db_pegawai.pegawai e', 'd.username = e.nipbaru_ws')
                ->join('db_pegawai.unitkerja f', 'e.skpd = f.id_unitkerja')
                ->join('db_pegawai.jabatan g', 'e.jabatan = g.id_jabatanpeg')
                ->join('db_pegawai.pangkat h', 'e.pangkat = h.id_pangkat')
                ->join('m_user i', 'a.id_m_user_verifikasi_atasan = i.id', 'left')
                ->join('m_user j', 'a.id_m_user_verifikasi_kepala_bkpsdm = j.id', 'left')
                ->where('a.flag_active', 1)
                ->where('a.id', $id)
                ->get()->row_array();

        if($result){
            $progress[0]['keterangan'] = "PENGAJUAN, menunggu Verifikasi Atasan";
            $progress[0]['icon'] = "fa fa-spin fa-spinner";
            $progress[0]['color'] = "yellow";
            $progress[0]['font-color'] = "black";
            if($result['id_m_status_pengajuan_cuti'] == 2){
                $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
                $progress[1]['icon'] = "fa fa-spin fa-spinner";
                $progress[1]['color'] = "yellow";
                $progress[1]['font-color'] = "black";
            } else if($result['id_m_status_pengajuan_cuti'] == 3){
                $progress[1]['keterangan'] = "DITOLAK OLEH ATASAN pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_atasan'])." : ".$result['keterangan_verifikasi_atasan'];
                $progress[1]['icon'] = "fa fa-times";
                $progress[1]['color'] = "red";
                $progress[1]['font-color'] = "white";
            }

            if($result['id_m_status_pengajuan_cuti'] == 4){
                $progress[1]['icon'] = "fa fa-check";
                $progress[1]['color'] = "green";
                $progress[1]['font-color'] = "white";
                $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_atasan']).". Menunggu Verifikasi Kepala BKPSDM";
                if($result['url_sk']){
                    $progress[2]['keterangan'] = "VERIFIKASI KEPALA BKPSDM SELESAI pada ".formatDateNamaBulanWT($result['updated_date']).". SK Cuti sudah dapat diunduh.";
                    $progress[2]['icon'] = "fa fa-check";
                    $progress[2]['color'] = "green";
                    $progress[2]['font-color'] = "white";
                } else {
                    $progress[2]['keterangan'] = "DITERIMA OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
                    $progress[2]['icon'] = "fa fa-spin fa-spinner";
                    $progress[2]['color'] = "yellow";
                    $progress[2]['font-color'] = "black";
                }
            } else if($result['id_m_status_pengajuan_cuti'] == 5){
                $progress[2]['keterangan'] = "DITOLAK OLEH KEPALA BKPSDM pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_kepala_bkpsdm'])." : ".$result['keterangan_verifikasi_kepala_bkpsdm'];
                $progress[2]['icon'] = "fa fa-times";
                $progress[2]['color'] = "red";
                $progress[2]['font-color'] = "white";
            } else if($result['id_m_status_pengajuan_cuti'] == 6){
                $progress[1]['icon'] = "fa fa-check";
                $progress[1]['color'] = "green";
                $progress[1]['font-color'] = "white";
                $progress[1]['keterangan'] = "DITERIMA OLEH ATASAN pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_atasan']).". Menunggu Verifikasi BKPSDM";
    
                $progress[2]['keterangan'] = "SELESAI VERIFIKASI BKPSDM pada ".formatDateNamaBulanWT($result['tanggal_verifikasi_kepala_bkpsdm']).". Menunggu penerbitan SK Cuti";
                $progress[2]['icon'] = "fa fa-check";
                $progress[2]['color'] = "green";
                $progress[2]['font-color'] = "white";
    
                $progress[3]['keterangan'] = "SK SUDAH SELESAI DS PADA ".formatDateNamaBulanWT($result['updated_date']);
                $progress[3]['icon'] = "fa fa-check";
                $progress[3]['color'] = "green";
                $progress[3]['font-color'] = "white";
            }

            if($result['id_m_status_pengajuan_cuti'] != 1){
                $progress[0]['icon'] = "fa fa-check";
                $progress[0]['color'] = "green";
                $progress[0]['font-color'] = "white";
            }
            
            $result['progress'] = $progress;

            $meta = $this->db->select('a.*')
                        ->from('t_meta_cuti a')
                        ->where('a.id_t_penggunaan_cuti', $result['id'])
                        // ->where('flag_active', 1)
                        ->order_by('tahun', 'desc')
                        ->get()->result_array();
            if($meta){
                $result['detail'] = $meta;
            }
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
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $res['status'] = null;
        $data_verif = $this->input->post();
        $update['id_m_status_pengajuan_cuti'] = 0;
        
        $data = $this->db->select('a.*, b.nm_cuti, d.handphone, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat,
                        f.nama_jabatan, g.nm_unitkerja, g.id_unitkerja')
                        ->from('t_pengajuan_cuti a')
                        ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                        ->join('m_user c', 'c.id = a.id_m_user')
                        ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                        ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                        ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg')
                        ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                        ->where('a.id', $id)
                        ->get()->row_array();

        $res['data'] = $data;

        if($kepalabkpsdm == 1 || $this->general_library->isKepalaBkpsdm()){
            if($data['id_m_status_pengajuan_cuti'] != 2){
                if($data['id_m_status_pengajuan_cuti'] == 1 && $data['id_unitkerja'] == $this->general_library->getIdUnitKerjaPegawai()){
                    $update['id_m_status_pengajuan_cuti'] = $status == 0 ? 5 : 4;
                    $update['id_m_user_verifikasi_atasan'] = $this->general_library->getId();
                    $update['tanggal_verifikasi_atasan'] = date('Y-m-d H:i:s');
                    $update['keterangan_verifikasi_atasan'] = $data_verif['keterangan_verif'];
                    $update['id_m_user_verifikasi_kepala_bkpsdm'] = $this->general_library->getId();
                    $update['tanggal_verifikasi_kepala_bkpsdm'] = date('Y-m-d H:i:s');
                    $update['keterangan_verifikasi_kepala_bkpsdm'] = $data_verif['keterangan_verif'];
                } else {
                    $res['code'] = 1;
                    $res['message'] = "Tidak bisa melakukan Verifikasi pada tahap ini";
                }
            } else {
                $update['id_m_status_pengajuan_cuti'] = $status == 0 ? 5 : 4;
                $update['id_m_user_verifikasi_kepala_bkpsdm'] = $this->general_library->getId();
                $update['tanggal_verifikasi_kepala_bkpsdm'] = date('Y-m-d H:i:s');
                $update['keterangan_verifikasi_kepala_bkpsdm'] = $data_verif['keterangan_verif'];
            }
        } else if($kepalapd == 1 || $this->general_library->isKepalaPd()){
            if($data['id_m_status_pengajuan_cuti'] != 1){
                $res['code'] = 1;
                $res['message'] = "Tidak bisa melakukan Verifikasi pada tahap ini";
            } else {
                $update['id_m_status_pengajuan_cuti'] = $status == 0 ? 3 : 2;
                $update['id_m_user_verifikasi_atasan'] = $this->general_library->getId();
                $update['tanggal_verifikasi_atasan'] = date('Y-m-d H:i:s');
                $update['keterangan_verifikasi_atasan'] = $data_verif['keterangan_verif'];
            }
        }

        if($res['code'] == 0){
            $message_to_pegawai = "*[PENGAJUAN CUTI]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($data)."\nPermohonan Pengajuan ".$data['nm_cuti']." Anda ";
            $send_to_pegawai = $data['handphone'];
            $path_file = null;
            if(($res['code'] == 0 && $res['data']['id_m_status_pengajuan_cuti'] == 2 && $status == 1) ||
            (($kepalabkpsdm == 1 || $this->general_library->isKepalaBkpsdm()) && $status == 1)){
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
            }
            $this->db->where('id', $id)
                        ->update('t_pengajuan_cuti', $update);

            $kepala_bkpsdm = $this->db->select('a.*')
                                        ->from('db_pegawai.pegawai a')
                                        ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                        ->where('c.kepalaskpd', 1)
                                        ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                                        ->get()->row_array();

            if($update['id_m_status_pengajuan_cuti'] == 2){ //disetujui atasan, kirim whatsapp ke pegawai dan ke kepala bkpsdm untuk verif
                $message_to_pegawai .= "telah *disetujui oleh Kepala PD Anda* dan saat ini sedang menunggu Verifikasi oleh Keplaa BKPSDM. Terima kasih.";
                $encrypt = simpleEncrypt($kepala_bkpsdm['nipbaru_ws'].'-'.$id);
                $link = base_url('whatsapp-verification/cuti/'.$encrypt);
                $message_to_kepala_bkpsdm = "*[PENGAJUAN CUTI]*\n\nSelamat ".greeting().", Permohonan Pengajuan ".$data['nm_cuti']." pegawai atas nama ".getNamaPegawaiFull($data)." telah diverifikasi oleh Kepala PD dan membutuhkan verifikasi Kepala BKPSDM. Mohon segera diverifikasi dengan klik link dibawah ini. \n\n".$link;
                
                // $this->maxchatlibrary->sendText($kepala_bkpsdm['handphone'], $message_to_kepala_bkpsdm.FOOTER_MESSAGE_CUTI, 0, 0);
                $cronWa = [
                    'sendTo' => $kepala_bkpsdm['handphone'],
                    'message' => $message_to_kepala_bkpsdm.FOOTER_MESSAGE_CUTI,
                    'type' => 'text'
                ];
                $this->general->saveToCronWa($cronWa);

            } else if($update['id_m_status_pengajuan_cuti'] == 3){ //ditolak atasan
                $message_to_pegawai .= '*ditolak oleh Kepala PD* Anda dengan keterangan: *"'.$update['keterangan_verifikasi_atasan'].'"*';
                $this->deletePermohonanCuti($id, 0);
            } else if($update['id_m_status_pengajuan_cuti'] == 4){ //diterima kepala bkpsdm dan menunggu DS
                $message_to_pegawai .= 'telah *disetujui oleh Kepala BKPSDM* dan saat ini sedang menunggu untuk proses *DS (Digital Sign)*. Terima kasih.';
            } else if($update['id_m_status_pengajuan_cuti'] == 5){ //ditolak oleh kepala BKPSDM
                $message_to_pegawai .= '*ditolak oleh Kepala BKPSDM* dengan keterangan: *"'.$update['keterangan_verifikasi_kepala_bkpsdm'].'"*';
                $this->deletePermohonanCuti($id, 0);
            }
            $cronWa = [
                'sendTo' => convertPhoneNumber($send_to_pegawai),
                'message' => $message_to_pegawai.FOOTER_MESSAGE_CUTI,
                'type' => 'text'
            ];
            $this->general->saveToCronWa($cronWa);
            // $this->maxchatlibrary->sendText($send_to_pegawai, $message_to_pegawai.FOOTER_MESSAGE_CUTI, 0, 0);

            // if($this->general_library->isKepalaBkpsdm() && $status == 1){
            //     //pembuatan file SK simpan di url_sk_temp sebelum DS
            //     $res['status'] = $status;
            //     $res['data'] = $data;
            // }
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
                        
        $message_to_pegawai = "*[PENGAJUAN CUTI]*\n\nSelamat ".greeting().", Yth. ".getNamaPegawaiFull($result)."\nVerifikasi Permohonan Pengajuan ".$result['nm_cuti']." Anda telah dibatalkan oleh ";

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
        $this->db->trans_begin();
        $list_checked_data = null;

        $list_data = $this->db->select('a.*, b.nm_cuti, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat, f.nama_jabatan, g.nm_unitkerja,
                g.id_unitkerja, b.id_cuti, c.id as id_m_user, d.id_peg, d.handphone')
                ->from('t_pengajuan_cuti a')
                ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                ->join('m_user c', 'c.id = a.id_m_user')
                ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg')
                ->join('db_pegawai.unitkerja g', 'd.skpd = g.id_unitkerja')
                ->where_in('a.id', $params['list_checked'])
                ->where('a.flag_active', 1)
                ->order_by('a.id')
                ->get()->result_array(); 

        if(!$list_data){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = 'Terjadi Kesalahan';
            return $res;
        } else {
            $fileBase64 = null;

            $kepala_bkpsdm = $this->db->select('a.*, d.id as id_m_user')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                    ->join('m_user d', 'a.nipbaru_ws = d.username')
                                    ->where('c.kepalaskpd', 1)
                                    ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                                    ->get()->row_array();

            $i = 0;
            foreach($list_data as $ld){
                $list_checked_data[$i] = $ld;
                $explode = explode("-", $ld['created_date']);
                $tahun = $explode[0];
                $counter = 1;
                $master = $this->db->select('*')
                                ->from('m_jenis_layanan')
                                ->where('integrated_id', $ld['id_cuti'])
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

                $nomor_surat = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;

                $res['data'][$i] = $ld;
                $res['data'][$i]['ds'] = 1;
                $res['data'][$i]['nomor_surat'] = $nomor_surat;

                $filename = 'CUTI_'.$res['data'][$i]['nipbaru_ws'].'_'.date("Y", strtotime($res['data'][$i]['created_date']))."_".date("m", strtotime($res['data'][$i]['created_date'])).'_'.date("d", strtotime($res['data'][$i]['created_date'])).'_signed.pdf';
                $path_file = 'arsipcuti/'.$filename;
                $list_checked_data[$i]['path_file'] = $path_file;

                // dd($path_file);
                // $encUrl = simpleEncrypt($path_file);
                $randomString = generateRandomString(30, 1, 't_file_ds'); 
                $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
                $list_checked_data[$i]['randomString'] = $randomString;
                // dd($contentQr);
                $res['data'][$i]['qr'] = generateQr($contentQr);
                // dd($path_file);
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'Legal-P',
                    // 'debug' => true
                ]);
                $passing_data['data'] = $res['data'][$i];
                $html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $passing_data, true);
                // dd($res);
                $mpdf->WriteHTML($html);
                $mpdf->showImageErrors = true;
                $mpdf->Output($path_file, 'F');

                $fileBase64[] = convertToBase64($path_file);

                // save untuk cron WA
                $caption = "*[SK PENGAJUAN ".strtoupper($ld["nm_cuti"])."]*\n\n"."Selamat ".greeting().", Yth. ".getNamaPegawaiFull($ld).",\nBerikut kami lampirkan SK ".$ld["nm_cuti"]." Anda. Terima kasih.".FOOTER_MESSAGE_CUTI;
                // $this->maxchatlibrary->sendDocument(convertPhoneNumber($ld['handphone']), @$path_file, $filename, $caption);
                $cronWa = [
                    'sendTo' => convertPhoneNumber($ld['handphone']),
                    'message' => $caption,
                    'filename' => $filename,
                    'fileurl' => $path_file,
                    'type' => 'document'
                ];
                $this->general->saveToCronWa($cronWa);

                // save untuk t_file_ds agar bisa terbaca saat QR Code
                $this->db->insert('t_file_ds', [
                    'url' => $path_file,
                    'random_string' => $randomString,
                    'created_by' => $this->general_library->getId()
                ]);

                // save nomor surat
                $this->db->insert('t_nomor_surat', [
                    'perihal' => 'SURAT IZIN '.strtoupper($ld['nm_cuti']).' PEGAWAI a.n. '.getNamaPegawaiFull($ld),
                    'counter' => $counter,
                    'nomor_surat' => $nomor_surat,
                    'created_by' => $kepala_bkpsdm['id_m_user'],
                    'tanggal_surat' => $ld['created_date'],
                    'id_m_jenis_layanan' => $master['id']
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
            $hariKerja = countHariKerjaDateToDate($ld['tanggal_mulai'], $ld['tanggal_akhir']);
            if($hariKerja){
                $j = 0;
                foreach($hariKerja[2] as $h){
                    $explode = explode("-", $h);
                    $dokumen_pendukung[$j] = [
                        'id_m_user' => $ld['id_m_user'],
                        'id_m_jenis_disiplin_kerja' => 17,
                        'tanggal' => $explode[2],
                        'bulan' => $explode[1],
                        'tahun' => $explode[0],
                        'keterangan' => 'Cuti',
                        'pengurangan' => 0,
                        'status' => 2,
                        'keterangan_verif' => $ld['keterangan_verifikasi_kepala_bkpsdm'],
                        'tanggal_verif' => $ld['tanggal_verifikasi_kepala_bkpsdm'],
                        'id_m_user_verif' => $kepala_bkpsdm['id_m_user'],
                        'flag_outside' => 1,
                        'url_outside' => json_encode([$path_file]),
                        'created_by' => $kepala_bkpsdm['id_m_user']
                    ];
                    $j++;
                }
            }
            if($dokumen_pendukung){
                $this->db->insert_batch('t_dokumen_pendukung', $dokumen_pendukung);
            }

            // save di pegcuti agar muncul di profil cuti
            $this->db->insert('db_pegawai.pegcuti', [
                'id_pegawai' => $ld['id_peg'],
                'jeniscuti' => $ld['id_cuti'],
                'lamacuti' => $ld['lama_cuti'],
                'tglmulai' => $ld['tanggal_mulai'],
                'tglselesai' => $ld['tanggal_akhir'],
                'nosttpp' => $nomor_surat,
                'tglsttpp' => date('Y-m-d'),
                'gambarsk' => $filename,
                'status' => 2
            ]);

                $i++;
            }
            $signatureProperties = array();
            $signatureProperties = [
                'tampilan' => 'INVISIBLE',
                'reason' => REASON_TTE
            ];

            $request_tte = [
                'id_ref' => $params['list_checked'],
                'table_ref' => $params['table_ref'],
                'nik' => $params['nik'],
                'passphrase' => $params['passphrase'],
                'signatureProperties' => [$signatureProperties],
                'file' => ($fileBase64)
            ];
            $request_sign = $this->ttelib->signPdfNikPass($request_tte);
            $dec_resp = json_decode($request_sign, true);
            if(!isset($dec_resp['file'])){
                $this->db->trans_rollback();
                $res['data'] = null;
                $res['code'] = 2;
                $res['message'] = isset($dec_resp['error']) ? $dec_resp['error'] : $request_sign;
                return $res;
            } else {
                $j = 0;
                foreach($dec_resp['file'] as $result_file){
                    // dd($result_file);
                    base64ToFile($result_file, $list_checked_data[$j]['path_file']);
                    $this->db->where('id', $list_checked_data[$j]['id'])
                            ->update('t_pengajuan_cuti',
                            [
                                'url_sk' => $list_checked_data[$j]['path_file']
                            ]);

                    $this->db->insert('t_file_ds', [
                        'url' => $list_checked_data[$j]['path_file'],
                        'random_string' => $list_checked_data[$j]['randomString'],
                        'created_by' => $this->general_library->getId()
                    ]);

                    if(!file_exists($list_checked_data[$j]['path_file'])){
                        $res['code'] = 3;
                        $res['message'] = "Terjadi Kesalahan saat menyimpan PDF.";
                        $res['data'] = null;
                        $this->db->trans_rollback();
                        return $res;
                    }
                    $j++;
                }
            }
        }
        
        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 4;
            $res['message'] = 'Terjadi Kesalahan';
            $res['data'] = null;
        } else {
            if($res['code'] == 0){
                $this->db->trans_commit();
            } else {
                $res['code'] = 5;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            }
        }

        return $res;
    }

    public function dsCuti($id){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $input_post = $this->input->post();

        $this->db->trans_begin();

            $data = $this->db->select('a.*, b.nm_cuti, b.nomor_cuti, d.gelar1, d.nama, d.gelar2, d.nipbaru_ws, e.nm_pangkat, f.nama_jabatan, g.nm_unitkerja,
                g.id_unitkerja, b.id_cuti, c.id as id_m_user, d.id_peg, d.handphone')
                ->from('t_pengajuan_cuti a')
                ->join('db_pegawai.cuti b', 'a.id_cuti = b.id_cuti')
                ->join('m_user c', 'c.id = a.id_m_user')
                ->join('db_pegawai.pegawai d', 'd.nipbaru_ws = c.username')
                ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                ->join('db_pegawai.jabatan f', 'd.jabatan = f.id_jabatanpeg')
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

            $nomor_surat = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;

            $res['data'] = $data;
            $res['data']['ds'] = 1;
            $res['data']['nomor_surat'] = $nomor_surat;

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
            if(isset($request_sign['file'])){
                unlink($path_file);
                base64ToFile($request_sign['file'][0], $path_file);
                if(!file_exists($path_file)){
                    $res['code'] = 1;
                    $res['message'] = "Terjadi Kesalahan saat menyimpan PDF.";
                    $res['data'] = null;
                    $this->db->trans_rollback();
                    return $res;
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
                'type' => 'document'
            ];
            $this->general->saveToCronWa($cronWa);

            $this->db->insert('t_file_ds', [
                'url' => $path_file,
                'random_string' => $randomString,
                'created_by' => $this->general_library->getId()
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
                        'keterangan_verif' => $data['keterangan_verifikasi_kepala_bkpsdm'],
                        'tanggal_verif' => $data['tanggal_verifikasi_kepala_bkpsdm'],
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

        return $res;
    }

    public function loadDataDsPengajuanCuti(){
        return $this->db->select('a.*, c.gelar1, c.gelar2, c.nama, c.nipbaru_ws, a.created_date as tanggal_pengajuan, c.nipbaru_ws as nip, d.nm_unitkerja')
                    ->from('t_pengajuan_cuti a')
                    ->join('m_user b', 'a.id_m_user = b.id')
                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                    ->join('db_pegawai.unitkerja d', 'd.id_unitkerja = c.skpd')
                    ->where('a.id_m_status_pengajuan_cuti', 4)
                    ->where('a.url_sk', null)
                    ->where('a.flag_active', 1)
                    ->order_by('a.created_date', 'asc')
                    ->get()->result_array();
    }

    public function loadDataForDs($data){
        $result = null;
        if($data['jenis_layanan'] == 'permohonan_cuti'){
            $result = $this->loadDataDsPengajuanCuti();
        }

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

        $last_data = $this->db->select('*')
                            ->from('t_nomor_surat')
                            ->where('YEAR(tanggal_surat)', $tahun)
                            ->order_by('created_date', 'desc')
                            ->limit(1)
                            ->get()->row_array();
        if($last_data){
            $counter = floatval($last_data['counter'])+1;
        }
        $counter = $counter.".".$master['id'];
        $data['counter'] = $counter;
        $data['nomor_surat'] = $master['nomor_surat']."/BKPSDM/SK/".$counter."/".$tahun;
        $data['created_by'] = $this->general_library->getId();

        $this->db->insert('t_nomor_surat', $data);
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

    public function updateJabatan($id_peg){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();
        
            $getJabatan = $this->db->select('a.id_unitkerja,a.tmtjabatan,a.id_jabatan,a.jenisjabatan')
            ->from('db_pegawai.pegjabatan a')
            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.id_jabatan')
            ->where('a.id_pegawai', $id_peg)
            ->where_in('a.flag_active', [1,2])
            // ->where('a.statusjabatan !=', 2)
            ->where_not_in('a.statusjabatan', [2,3])
            ->where('a.status', 2)
            // ->where('a.flag_active', 1)
            ->order_by('tmtjabatan', 'desc')
            ->limit(1)
            ->get()->row_array();
        
            if($getJabatan) {
            if($getJabatan['id_unitkerja']){
                $dataUpdate["skpd"] =  $getJabatan['id_unitkerja'];
            }
                $dataUpdate["tmtjabatan"] =  $getJabatan['tmtjabatan'];
                $dataUpdate["jabatan"] =   $getJabatan['id_jabatan'];
                $dataUpdate["jenisjabpeg"] =  $getJabatan['jenisjabatan'];
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

    function getSelectJabatanEdit(){
        $this->db->select('*')
            ->from('db_pegawai.jabatan a')
            ->group_start()
            // ->where('a.jenis_jabatan', 'JFU')
            ->where("FIND_IN_SET(a.jenis_jabatan,'JFU,Struktural')!=",0)
            // ->where('a.id_unitkerja', '4018000')
            ->group_end()
            ->or_where('a.jenis_jabatan', 'JFT');
        return $this->db->get()->result_array();
    }

    public function getDokumenForKarisKarsu($table,$id_dokumen,$jenissk)
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        ->where('status', 2)
        
        ->from($table);

        if($table == "db_pegawai.pegarsip"){
            $this->db->where('id_dokumen', $id_dokumen);
        }

        if($table == "db_pegawai.pegberkaspns"){
            $this->db->where('jenissk', $jenissk);
        }
    
    
        $query = $this->db->get()->row_array();
    
        return $query;  

    }

    public function insertUsulLayananKarisKarsu(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        $this->db->trans_begin();
            $dataUsul['id_m_user']      = $this->general_library->getId();
            $dataUsul['created_by']      = $this->general_library->getId();
            $this->db->insert('db_efort.t_karis_karsu', $dataUsul);
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
                       ->from('t_karis_karsu a')
                       ->where('a.id_m_user', $this->general_library->getId())
                       ->where('a.flag_active', 1)
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

function getPengajuanLayananKarisKarsu($id){
    // $this->db->select('*')
    //                 ->from('t_karis_karsu a')
    //                 ->where('a.id', $id)
    //                 ->where('a.flag_active', 1);
    // return $this->db->get()->result_array();
    return $this->db->select('c.*, c.id as id_pengajuan,
    b.gelar1,b.gelar2,b.id_peg, b.nik, i.nm_agama,
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
                ->where('a.id_dokumen', 27)
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

    public function getDokumenPangkatForPensiun()
    {
        $this->db->select('*')
        ->where('id_pegawai', $this->general_library->getIdPegSimpeg())
        ->where('flag_active', 1)
        ->where('status', 2)
        ->order_by('tmtpangkat', 'desc')
        ->limit(1)
        ->from('db_pegawai.pegpangkat');
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




}
