<?php
	class M_Dashboard extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function getAllSkpd(){
            return $this->db->select('id_unitkerja, nm_unitkerja')
                            ->from('db_pegawai.unitkerja')
                            ->order_by('nm_unitkerja', 'asc')
                            ->get()->result_array();
        }

        public function getDataSkpdOld($id_skpd){
            return $this->db->select('*')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_user b', 'a.nipbaru_ws = b.username')
                            ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                            ->where('a.skpd', $id_skpd)
                            ->where('b.flag_active', 1)
                            ->get()->row_array();
        }

        public function getDataSkpd($id_skpd){
            return $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $id_skpd)
                            ->get()->row_array();
        }

        public function getDataDashboard($data){
            $result['belum_verif']  = 0;
            $result['batal_verif'] = 0;
            $result['verif_diterima'] = 0;
            $result['verif_ditolak'] = 0;
            $result['nilai_capaian'] = 0;
            $result['total_progress'] = 0;
            $result['total_target'] = 0;
            $result['total_realisasi_target'] = 0;
            $id_skpd = $this->general_library->getUnitKerjaPegawai();
            if(isset($data['skpd'])){
                $id_skpd = $data['skpd'];
            }
            
            if($this->general_library->isKabid()){
                $bidang = $this->db->select('a.id, a.nama_bidang')
                                ->from('m_bidang a')
                                ->where('a.id', $this->general_library->getBidangUser())
                                ->get()->row_array();
            }

            $this->db->select('*')
                    ->from('t_rencana_kinerja a')
                    ->join('m_user b', 'a.id_m_user = b.id')
                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                    ->where('c.skpd', $id_skpd)
                    ->where('a.bulan', $data['bulan'])
                    ->where('a.tahun', $data['tahun'])
                    ->where('a.flag_active', 1);
            if(isset($data['bidang']) && $data['bidang'] != 0){
                $this->db->where('b.id_m_bidang', $data['bidang']);
            }
            
            $result['rencana_kinerja'] = $this->db->get()->result_array();

            $this->db->select('*')
                    ->from('t_kegiatan a')
                    ->join('t_rencana_kinerja b', 'b.id = a.id_t_rencana_kinerja', 'left')
                    ->join('m_user c', 'b.id_m_user = c.id')
                    ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                    ->where('d.skpd', $id_skpd)
                    ->where('a.flag_active', 1)
                    ->where('b.flag_active', 1)
                    ->where('b.bulan', $data['bulan'])
                    ->where('b.tahun', $data['tahun']);
            if(isset($data['bidang']) && $data['bidang'] != 0){
                $this->db->where('c.id_m_bidang', $data['bidang']);
            }
            
            $result['realisasi'] = $this->db->get()->result_array();
            
            if($result['rencana_kinerja']){
                $total_realisasi = 0;
                $total_target = 0;
                foreach($result['rencana_kinerja'] as $rk){
                    $total_realisasi += $rk['total_realisasi'];
                    $total_target += $rk['target_kuantitas'];
                }
                $result['total_progress'] = ($total_realisasi / $total_target) * 100;
            }

            if($result['realisasi']){
                foreach($result['realisasi'] as $k){
                    $result['total_target'] += $k['target_kuantitas'];
                    if($k['status_verif'] == 0){
                        $result['belum_verif']++;
                    } else if($k['status_verif'] == 1){
                        $result['total_realisasi_target'] += $k['realisasi_target_kuantitas'];
                        $result['verif_diterima']++;
                    } else if($k['status_verif'] == 2){
                        $result['verif_ditolak']++;
                    } else if($k['status_verif'] == 3){
                        $result['batal_verif']++;
                    }
                }
            }
            return $result;
        }

        public function getBidangBySkpd($id){
            return $this->db->select('*')
                            ->from('m_bidang a')
                            ->where('a.id_unitkerja', $id)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function loadSubBidangByBidang($id){
            return $this->db->select('*')
                            ->from('m_bidang a')
                            ->join('m_sub_bidang b', 'a.id = b.id_m_bidang')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        // public function loadBidangByUnitKerja($id){
        //     return $this->db->select('*')
        //                     ->from('m_bidang a')
        //                     ->where('a.id_unitkerja', $id)
        //                     ->where('a.flag_active', 1)
        //                     ->get()->result_array();
        // }

        public function getDataLiveAbsen($id){
            $data = $this->input->post();
            $agenda = $this->db->select('*')
                                ->from('db_sip.agenda')
                                ->where('id', $id)
                                ->get()->row_array();
            $absen = null;
            if($agenda){
                $this->db->select('a.masuk, a.pulang, a.tgl, c.gelar1, c.nama, c.gelar2, d.nama_jabatan, d.eselon, e.nm_pangkat, f.nm_unitkerja,
                    c.nipbaru_ws as nip')
                    ->from('db_sip.absen a')
                    ->join('m_user b', 'a.user_id = b.id')
                    ->join('db_pegawai.pegawai c', 'c.nipbaru_ws = b.username')
                    ->join('db_pegawai.jabatan d', 'c.jabatan = d.id_jabatanpeg')
                    ->join('db_pegawai.pangkat e', 'c.pangkat = e.id_pangkat')
                    ->join('db_pegawai.unitkerja f', 'c.skpd = f.id_unitkerja')
                    ->join('db_pegawai.eselon g', 'd.eselon = g.nm_eselon')
                    ->where('a.tgl', $agenda['tgl'])
                    ->where('(a.masuk >= "'.$agenda['buka_masuk'].'" OR a.pulang >= "'.$agenda['buka_pulang'].'")') //komen ini
                    // ->where('a.pulang >=', $agenda['buka_pulang']) //buka ini
                    ->group_by('a.id')
                    ->where_in('a.aktivitas', [1,2,3]) //buka ini
                    // ->order_by('a.masuk', 'desc'); //komen ini
                    ->order_by('a.pulang', 'desc'); //buka ini

                if(isset($data['unitkerja']) && $data['unitkerja'] != 0){
                    $this->db->where('c.skpd', $data['unitkerja']);
                }
                if(isset($data['eselon'])){
                    $this->db->where_in('g.id_eselon', $data['eselon']);
                }
                if(isset($data['pangkat'])){
                    $this->db->where_in('c.pangkat', $data['pangkat']);
                }
                if(isset($data['golongan'])){
                    $golongan = [];
                    foreach($data['golongan'] as $g){
                        if($g == 1){
                            array_push($golongan, 11, 12, 13, 14);
                        }
                        if($g == 2){
                            array_push($golongan, 21, 22, 23, 24);
                        }
                        if($g == 3){
                            array_push($golongan, 31, 32, 33, 34);
                        }
                        if($g == 4){
                            array_push($golongan, 41, 42, 43, 44);
                        }
                        if($g == 5){
                            array_push($golongan, 55);
                        }
                        if($g == 7){
                            array_push($golongan, 57);
                        }
                        if($g == 9){
                            array_push($golongan, 59);
                        }
                        if($g == 10){
                            array_push($golongan, 60);
                        }
                    }
                    $this->db->where_in('e.id_pangkat', $golongan);
                }
                $absen = $this->db->get()->result_array();
            }
            $result = $absen;
            return array($result, $agenda);
        }

        public function getDataDetailDashboardPdm($data){
            $rs = null;
            $rs['progress_keseluruhan'] = 0;
            $master = $this->db->select('*')
                                    ->from('m_pdm')
                                    ->where('flag_active', 1)
                                    ->get()->result_array();

            foreach($master as $m){
                $rs['master'][$m['singkatan']] = $m;
                $rs['master'][$m['singkatan']]['progress']['total'] = 0;
            }


            $list_pegawai = $this->db->select('a.*, c.nm_pangkat, b.nama_jabatan')
                                        ->from('db_pegawai.pegawai a')
                                        ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                                        ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                                        ->where('a.skpd', $data['unitkerja'])
                                        ->order_by('b.eselon', 'asc')
                                        ->group_by('a.nipbaru')
                                        ->get()->result_array();

            foreach($list_pegawai as $lp){
                $rs['list_pegawai'][$lp['nipbaru_ws']] = $lp;
                $rs['list_pegawai'][$lp['nipbaru_ws']]['progress']['total'] = 0;
                $rs['list_pegawai'][$lp['nipbaru_ws']]['progress']['detail'] = null;
                foreach($master as $ms){
                    $rs['list_pegawai'][$lp['nipbaru_ws']]['progress']['detail'][$ms['singkatan']] = 0;
                }
                if($lp['fotopeg'] != null && $lp['fotopeg'] != ''){
                    $path = './assets/fotopeg/'.$lp['fotopeg'];
                    if (file_exists($path)) {
                        $rs['list_pegawai'][$lp['nipbaru_ws']]['progress']['total']++;
                        $rs['list_pegawai'][$lp['nipbaru_ws']]['progress']['detail']['pas_foto'] = 1;
                        $rs['master']['pas_foto']['progress']['total']++;
                        $rs['progress_keseluruhan']++;
                    }
                }
                // if($lp['nipbaru_ws'] == '199011042022032007'){
                //     dd(json_encode($rs['list_pegawai'][$lp['nipbaru_ws']]));
                // }
            }

            $rs['data_pdm'] = $this->db->select('a.*, b.username, c.nama')
                                    ->from('t_pdm a')
                                    ->join('m_user b', 'a.id_m_user = b.id')
                                    ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->where('c.skpd', $data['unitkerja'])
                                    ->get()->result_array();
            foreach($rs['data_pdm'] as $pd){
                $rs['list_pegawai'][$pd['username']]['progress']['total']++;
                // if(!isset($rs['list_pegawai'][$pd['username']]['progress']['detail'][$pd['jenis_berkas']])){
                //     dd($pd);
                // }
                $rs['list_pegawai'][$pd['username']]['progress']['detail'][$pd['jenis_berkas']] = 1;
                $rs['master'][$pd['jenis_berkas']]['progress']['total']++;
                $rs['progress_keseluruhan']++;
            }

            $rs['total_keseluruhan'] = count($rs['master']) * count($rs['list_pegawai']);
            // $rs['progress_keseluruhan'] = count($rs['data_pdm']);
            $rs['total_progress'] = ($rs['progress_keseluruhan'] / $rs['total_keseluruhan']) * 100;

            return $rs;
        }
	}
?>