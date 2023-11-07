<?php
	class M_Master extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->load->library('Webservicelib', 'webservicelib');
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function getAllUnitKerjaByIdUnitKerjaMasterNew($ukmaster){
            return $this->db->select('*,
            (SELECT count(aa.nipbaru_ws)
            FROM db_pegawai.pegawai aa
            WHERE aa.skpd = a.id_unitkerja) as total,
            (SELECT count(bb.nipbaru_ws)
            FROM db_pegawai.pegawai bb
            WHERE bb.skpd = a.id_unitkerja
            AND bb.jk = "Laki-laki") as total_laki')
                            ->from('db_pegawai.unitkerja a')
                            ->where('a.id_unitkerjamaster', $ukmaster)
                            ->order_by('a.nm_unitkerja', 'asc')
                            ->get()->result_array();
        }

        public function getAllUnitKerjaByIdUnitKerjaMaster($ukmaster = '0000000'){
            return $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerjamaster', $ukmaster)
                            ->order_by('nm_unitkerja', 'asc')
                            ->get()->result_array();
        }

        public function getAllUnitKerja(){
            return $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->order_by('nm_unitkerja', 'asc')
                            ->get()->result_array();
        }

        public function loadMasterBidang(){
            return $this->db->select('*')
                            ->from('m_bidang a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama_bidang', 'asc')
                            ->get()->result_array();
        }

        public function loadMasterBidangByUnitKerja($id_unitkerja){
            return $this->db->select('*')
                            ->from('m_bidang a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->where('a.id_unitkerja', $id_unitkerja)
                            ->where('a.flag_active', 1)
                            ->order_by('a.nama_bidang', 'asc')
                            ->get()->result_array();
        }

        public function loadMasterSubBidang(){
            return $this->db->select('*, a.id as id_m_sub_bidang')
                            ->from('m_sub_bidang a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id')
                            ->join('db_pegawai.unitkerja c', 'b.id_unitkerja = c.id_unitkerja')
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function loadMasterSubBidangByUnitKerja($id_unitkerja){
            return $this->db->select('*, a.id as id_m_sub_bidang')
                            ->from('m_sub_bidang a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id')
                            ->join('db_pegawai.unitkerja c', 'b.id_unitkerja = c.id_unitkerja')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('b.id_unitkerja', $id_unitkerja)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function searchPegawaiBySkpd($data){
            return $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
            (select c.nm_jabatan from db_pegawai.pegjabatan as c where c.id_pegawai = a.id_peg ORDER BY tglsk desc limit 1) as jabatan')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                            ->where('a.skpd', $data)
                            ->order_by('a.nama', 'asc')
                            ->get()->result_array();
        }

        public function getPegawaiBySkpd($data){
            return $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws, e.id as id_m_user')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                            ->join('m_user e', 'a.nipbaru_ws = e.username')
                            ->where('e.flag_active', 1)
                            ->where('a.skpd', $data)
                            ->order_by('a.nama', 'asc')
                            ->get()->result_array();
        }

        public function getSubBidangByBidang($id){
            return $this->db->select('*')
                            ->from('m_sub_bidang')
                            ->where('id_m_bidang', $id)
                            ->where('flag_active', 1)
                            ->get()->result_array();
        }

        public function getBidangBySubBidang($id){
            return $this->db->select('*, b.id as id_m_bidang')
                            ->from('m_sub_bidang a')
                            ->join('m_bidang b', 'a.id_m_bidang = b.id')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();
        }

        public function getBidangById($id){
            return $this->db->select('*')
                            ->from('m_bidang a')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();
        }

        public function importBidangSubBidangByUnitKerja($id_unitkerja){
            $data = $this->db->select('a.*, b.nm_unitkerja, b.id_unitkerja')
                            ->from('db_pegawai.jabatan a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->where('a.id_unitkerja', $id_unitkerja)
                            ->get()->result_array();

            $rs = null;
            $skpd = null;
            $id_skpd = null;
            $counter_kabid = 0;
            $counter_sub = 0;
            $rs[0]['nama_bidang'] = "Sekretariat";
            if($data){
                $skpd = $data[0]['nm_unitkerja'];
                $id_skpd = $data[0]['id_unitkerja'];
                foreach($data as $d){
                    $explode = explode(" ", $d['eselon']);
                    $bidang = explode(" ", $d['nama_jabatan']);
                    if(strcasecmp($explode[0], "III") == 0){
                        if(strcasecmp($bidang[0], "sekretaris") == 0){
                            $rs[$counter_kabid]['sub_bidang'][$counter_sub] = $bidang[0]." ".$bidang[1];
                        } else {
                            $counter_kabid += 1;
                            $counter_sub = 0;
                            $i = 0;
                            $rs[$counter_kabid]['nama_bidang'] = '';
                            foreach($bidang as $b){
                                if($i != 0){
                                    $rs[$counter_kabid]['nama_bidang'] .= " ".$b;
                                }
                                $i++;
                            }
                            $rs[$counter_kabid]['nama_bidang'] = trim($rs[$counter_kabid]['nama_bidang']);
                            if($counter_sub == 0){
                                $rs[$counter_kabid]['sub_bidang'][$counter_sub] = $rs[$counter_kabid]['nama_bidang'];
                            }
                        }
                        $counter_sub ++;
                    } else if(strcasecmp($explode[0], "IV") == 0){
                        // if($counter_sub == 0){
                        //     $rs[$counter_kabid]['sub_bidang'] = [];
                        // }
                        $i = 0;
                        $rs[$counter_kabid]['sub_bidang'][$counter_sub] = '';
                        foreach($bidang as $sb){
                            if($i != 0){
                                $rs[$counter_kabid]['sub_bidang'][$counter_sub] .= " ".$sb;
                            }
                            $i++;
                        }
                        $rs[$counter_kabid]['sub_bidang'][$counter_sub] = trim($rs[$counter_kabid]['sub_bidang'][$counter_sub]);
                        $counter_sub++;
                    }
                }
            }
            return [$rs, $skpd, $id_skpd];
        }

        public function saveImportBidang($data, $id_skpd){
            $res['code'] = 0;
            $res['message'] = 'SELESAI';

            $this->db->trans_begin();

            $exists = $this->db->select('*')
                                ->from('m_bidang a')
                                ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                                ->where('a.id_unitkerja', $id_skpd)
                                ->where('a.flag_active', 1)
                                ->get()->row_array();
            if($exists){
                $res['code'] = 2;
                $res['message'] = $exists['nm_unitkerja'].' sudah memiliki Bidang/Sub Bidang';
                echo $exists['nm_unitkerja']." sudah memiliki Bidang/Sub Bidang <br> \n";
            } else {
                foreach($data as $d){
                    $input['id_unitkerja'] = $id_skpd;
                    $input['nama_bidang'] = $d['nama_bidang'];
                    $input['created_by'] = $this->general_library->getId();
                    
                    $this->db->insert('m_bidang', $input);
                    
                    $last_id = $this->db->insert_id();
                    $sub_bidang = [];
                    $i = 0;
                    if(isset($d['sub_bidang'])){
                        foreach($d['sub_bidang'] as $sb){
                            $sub_bidang[$i]['id_m_bidang'] = $last_id;
                            $sub_bidang[$i]['created_by'] = $this->general_library->getId();
                            $sub_bidang[$i]['nama_sub_bidang'] = $sb;
                            $i++;
                        }
                        $this->db->insert_batch('m_sub_bidang', $sub_bidang);   
                    }
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

        public function importAllBidangByUnitKerja($page){
            // $unitkerja = $this->db->select('id_unitkerja, nm_unitkerja')
            //                         ->from('db_pegawai.unitkerja')
            //                         // ->limit($page, 10)
            //                         ->get()->result_array();
            $unitkerja = $this->db->get('db_pegawai.unitkerja', 50, $page)->result_array();
            // dd($unitkerja);
            foreach($unitkerja as $u){
                if($u['id_unitkerja'] != '1000001'){
                    echo "on working ".$u['nm_unitkerja']."\n <br>";
                    list($data, $skpd, $id) = $this->importBidangSubBidangByUnitKerja($u['id_unitkerja']);
                    // dd(json_encode($data));
                    $res = $this->saveImportBidang($data, $u['id_unitkerja']);
                    if($res['code'] == 1){
                        echo "canceled <br> \n";
                        echo $res['message']."<br> \n";
                        break;
                    }
                }
                echo "done ".$u['nm_unitkerja']. "\n <br><br> \n";
            }
            echo "selesai";
        }

        public function downloadApiHariLibur(){
            $res['code'] = 0;
            $res['message'] = '';

            $req = $this->webservicelib->request_ws(URL_API_HARI_LIBUR);
            if($req){
                $insert_data = null;
                $i = 0;
                foreach($req['result'] as $r){
                    $explode = explode('-', $r['holiday_date']);
                    $exists = $this->db->select('*')
                                        ->from('t_hari_libur')
                                        ->where('bulan', floatval($explode[1]))
                                        ->where('tahun', $explode[0])
                                        ->where('tanggal', $r['holiday_date'])
                                        ->where('keterangan', $r['holiday_name'])
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                    if(!$exists){
                        $insert_data[$i]['tanggal'] = $r['holiday_date'];
                        $insert_data[$i]['tahun'] = $explode[0];
                        $insert_data[$i]['bulan'] = floatval($explode[1]);
                        $insert_data[$i]['keterangan'] = $r['holiday_name']; 
                        $insert_data[$i]['flag_hari_libur_nasional'] = $r['is_national_holiday'] ? 1 : 0; 
                        $i++;
                    }
                }
                if($insert_data){
                    $this->db->insert_batch('t_hari_libur', $insert_data);
                }
            }
            return $res;
        }

        public function deleteApiHariLibur($id){
            $this->db->where('id', $id)
                    ->update('t_hari_libur', ['flag_active' => 0]);
        }

        public function tambahHariLibur(){
            $data = $this->input->post();
            $explode = explode("-", $data['range_periode']);
            $list_tanggal = getDateBetweenDates(trim($explode[0]), trim($explode[1]));
            if($list_tanggal){
                $insert_data = null;
                $i = 0;
                foreach($list_tanggal as $l){
                    $explode = explode('-', $l);
                    $exists = $this->db->select('*')
                                        ->from('t_hari_libur')
                                        ->where('bulan', floatval($explode[1]))
                                        ->where('tahun', $explode[0])
                                        ->where('tanggal', $l)
                                        ->where('keterangan', $data['keterangan'])
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                    if(!$exists){
                        $insert_data[$i]['tanggal'] = $l;
                        $insert_data[$i]['tahun'] = $explode[0];
                        $insert_data[$i]['bulan'] = floatval($explode[1]);
                        $insert_data[$i]['keterangan'] = $data['keterangan']; 
                        $i++;
                    }
                }
                if($insert_data){
                    $this->db->insert_batch('t_hari_libur', $insert_data);
                }
            }
        }

        public function deleteJamKerja($id){
            $this->db->where('id', $id)
                    ->update('t_jam_kerja', ['flag_active' => 0]); 
        }

        public function tambahJamKerja($data){
            $res['code'] = 0;
            $res['message'] = '';
            
            $this->db->trans_begin();

            $this->db->insert('t_jam_kerja', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }
            return $res;
        }

        public function saveEditJamKerja($id, $data){
            $res['code'] = 0;
            $res['message'] = '';
            
            $this->db->trans_begin();

            $this->db->where('id', $id)
                    ->update('t_jam_kerja', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }
            return $res;
        }

        public function getAllJamKerja(){
            return $this->db->select('a.*, b.jenis_skpd')
                            ->from('t_jam_kerja a')
                            ->join('m_jenis_skpd b', 'a.id_m_jenis_skpd = b.id')
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function getJabatanByUnitKerja($id){
            return $this->db->select('*')
                            ->from('db_pegawai.jabatan')
                            ->where('id_unitkerja', $id)
                            ->order_by('eselon')
                            ->get()->result_array();
        }

        public function loadMasterTpp(){
            return $this->db->select('a.nominal, b.nm_unitkerja, c.nm_pangkat, a.id, a.id_jabatan,
                            (SELECT (d.nama_jabatan) FROM db_pegawai.jabatan d WHERE d.id_jabatanpeg = a.id_jabatan LIMIT 1) as nama_jabatan')
                            ->from('m_besaran_tpp a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->join('db_pegawai.pangkat c', 'a.id_pangkat = c.id_pangkat')
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function loadDataTppById($id){
            return $this->db->select('a.nominal, b.nm_unitkerja, c.nm_pangkat, a.id, a.id_jabatan,
                            (SELECT (d.nama_jabatan) FROM db_pegawai.jabatan d WHERE d.id_jabatanpeg = a.id_jabatan LIMIT 1) as nama_jabatan')
                            ->from('m_besaran_tpp a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->join('db_pegawai.pangkat c', 'a.id_pangkat = c.id_pangkat')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();
        }

        public function inputMasterTpp($data){
            $insert_data = null;
            $i = 0;
            foreach($data['id_pangkat'] as $p){
                $insert_data[$i]['id_unitkerja'] = $data['id_unitkerja'];
                $insert_data[$i]['id_jabatan'] = $data['id_jabatan'];
                $insert_data[$i]['id_pangkat'] = $p;
                $insert_data[$i]['nominal'] = clearString($data['nominal']);
                $insert_data[$i]['created_by'] = $this->general_library->getId();
                $i++;
            }

            $this->db->insert_batch('m_besaran_tpp', $insert_data);
        }

        public function loadPresentaseTpp(){
            return $this->db->select('a.*, b.nm_unitkerja')
                            ->from('m_presentase_tpp a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function inputMasterPresentaseTpp(){
            $data = $this->input->post();
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $exists = $this->db->select('*')
                                ->from('m_presentase_tpp')
                                ->where('flag_active', 1)
                                ->where('id_unitkerja', $data['id_unitkerja'])
                                ->where('kelas_jabatan', $data['kelas_jabatan'])
                                ->where('jenis_jabatan', $data['jenis_jabatan'])
                                ->get()->row_array();
            if($exists){
                $rs['code'] = 1;
                $rs['message'] = 'Data Presentase dengan SKPD dan Kelas Jabatan sudah ada';
            } else {
                $this->db->insert('m_presentase_tpp', $data);
            }

            return $rs;
        }

        public function getAllMasterSkpd(){
            return $this->db->select('*')
                            ->from('db_pegawai.unitkerjamaster')
                            // ->where_not_in('id_unitkerjamaster', LIST_UNIT_KERJA_MASTER_SEKOLAH)
                            ->where_not_in('id_unitkerjamaster', LIST_UNIT_KERJA_MASTER_EXCLUDE)
                            ->order_by('id_unitkerjamaster', 'asc')
                            ->get()->result_array();
        }

        public function getDetailMasterSkpd($id_unitkerja){
            $result['total'] = null;
            $result['kepala_skpd'] = null;
            $result['list_pegawai'] = null;
            $result['pangkat'] = null;
            $result['eselon'] = null;
            $result['agama'] = null;
            $result['pendidikan'] = null;
            $result['jenis_kelamin']['laki']['nama'] = 'Laki-laki';
            $result['jenis_kelamin']['laki']['jumlah'] = 0;
            $result['jenis_kelamin']['perempuan']['nama'] = 'Perempuan';
            $result['jenis_kelamin']['perempuan']['jumlah'] = 0;
            $result['statuspeg'] = null;

            $result['golongan'][1]['nama'] = 'Golongan I';
            $result['golongan'][1]['jumlah'] = 0;
            $result['golongan'][1]['id_golongan'] = 1;

            $result['golongan'][2]['nama'] = 'Golongan II';
            $result['golongan'][2]['jumlah'] = 0;
            $result['golongan'][2]['id_golongan'] = 2;

            $result['golongan'][3]['nama'] = 'Golongan III';
            $result['golongan'][3]['jumlah'] = 0;
            $result['golongan'][3]['id_golongan'] = 3;

            $result['golongan'][4]['nama'] = 'Golongan IV';
            $result['golongan'][4]['jumlah'] = 0;
            $result['golongan'][4]['id_golongan'] = 4;

            $result['golongan'][5]['nama'] = 'Golongan V';
            $result['golongan'][5]['jumlah'] = 0;
            $result['golongan'][5]['id_golongan'] = 5;

            $result['golongan'][6]['nama'] = 'Golongan X';
            $result['golongan'][6]['jumlah'] = 0;
            $result['golongan'][6]['id_golongan'] = 5;

            // $temp_pangkat = $this->db->select('*')
            //                     ->from('db_pegawai.pangkat')
            //                     ->get()->result_array();

            // foreach($temp_pangkat as $p){
            //     $result['pangkat'][$p['id_pangkat']] = $p;
            //     $result['pangkat'][$p['id_pangkat']]['nama'] = $p['nm_pangkat'];
            //     $result['pangkat'][$p['id_pangkat']]['jumlah'] = 0;
            // }

            $temp_eselon = $this->db->select('*')
                                ->from('db_pegawai.eselon')
                                ->get()->result_array();
            foreach($temp_eselon as $e){
                $result['eselon'][$e['nm_eselon']] = $e;
                $result['eselon'][$e['nm_eselon']]['nama'] = $e['nm_eselon'];
                $result['eselon'][$e['nm_eselon']]['jumlah'] = 0;
            }

            $temp_agama = $this->db->select('*')
                                ->from('db_pegawai.agama')
                                ->get()->result_array();
            foreach($temp_agama as $a){
                $result['agama'][$a['id_agama']] = $a;
                $result['agama'][$a['id_agama']]['nama'] = $a['nm_agama'];
                $result['agama'][$a['id_agama']]['jumlah'] = 0;
            }

            $temp_pendidikan = $this->db->select('*')
                                ->from('db_pegawai.tktpendidikan')
                                ->get()->result_array();
            foreach($temp_pendidikan as $pend){
                $result['pendidikan'][$pend['id_tktpendidikan']] = $pend;
                $result['pendidikan'][$pend['id_tktpendidikan']]['nama'] = $pend['nm_tktpendidikan'];
                $result['pendidikan'][$pend['id_tktpendidikan']]['jumlah'] = 0;
            }

            $temp_statuspeg = $this->db->select('*')
                                ->from('db_pegawai.statuspeg')
                                ->get()->result_array();
            foreach($temp_statuspeg as $sp){
                $result['statuspeg'][$sp['id_statuspeg']] = $sp;
                $result['statuspeg'][$sp['id_statuspeg']]['nama'] = $sp['nm_statuspeg'];
                $result['statuspeg'][$sp['id_statuspeg']]['jumlah'] = 0;
            }

            $pegawai = $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.pendidikan, a.jk, a.statuspeg,
            a.agama, c.kepalaskpd, b.notelp as notelp_uk, b.alamat_unitkerja as alamat_uk, b.emailskpd as email_uk,
            a.fotopeg, b.id_unitkerja')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->where('a.skpd', $id_unitkerja)
            ->order_by('c.eselon')
            ->get()->result_array();

            $result['total'] = count($pegawai);

            foreach($pegawai as $peg){
                if($peg['kepalaskpd'] == 1){
                    $result['kepala_skpd'] = $peg;
                }
                $result['list_pegawai'][] = $peg;
                // $result['pangkat'][$peg['id_pangkat']]['jumlah']++;
                $result['golongan'][substr($peg['id_pangkat'], 0, 1)]['jumlah']++;
                // $gol1 = [11, 12, 13, 14];
                // $gol2 = [21, 22, 23, 24];
                // $gol3 = [31, 32, 33, 34];
                // $gol4 = [41, 42, 43, 44, 45];
                if(!$peg['eselon']){
                    $result['eselon']['Non Eselon']['jumlah']++;
                } else {
                    $result['eselon'][$peg['eselon']]['jumlah']++;
                }
                if($peg['pendidikan']){
                    $result['pendidikan'][$peg['pendidikan']]['jumlah']++;
                }
                $result['agama'][$peg['agama']]['jumlah']++;
                if($peg['jk'] == 'Laki-Laki'){
                    $result['jenis_kelamin']['laki']['jumlah']++;
                } else {
                    $result['jenis_kelamin']['perempuan']['jumlah']++;
                }
                $result['statuspeg'][$peg['statuspeg']]['jumlah']++;
            }
            // dd($result);
            return $result;
        }

        public function searchPegawaiSkpdByFilter($data){
            $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan,
            d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.pendidikan, a.jk, a.statuspeg,
            a.agama, c.kepalaskpd, b.notelp as notelp_uk, b.alamat_unitkerja as alamat_uk, b.emailskpd as email_uk,
            a.fotopeg, b.id_unitkerja')
            ->from('db_pegawai.pegawai a')
            ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
            ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
            ->where('a.skpd', $data['id_unitkerja'])
            ->order_by('c.eselon');

            if($data['eselon'] != "0"){
                $this->db->where('c.eselon', $data['eselon']);
            }

            if($data['jenis_kelamin'] != "0"){
                $this->db->where('a.jk', $data['jenis_kelamin']);
            }

            if($data['agama'] != "0"){
                $this->db->where('a.agama', $data['agama']);
            }

            if($data['status_pegawai'] != "0"){
                $this->db->where('a.statuspeg', $data['status_pegawai']);
            }

            if($data['pendidikan'] != "0"){
                $this->db->where('a.pendidikan', $data['pendidikan']);
            }

            if($data['golongan'] != "0"){
                $this->db->where('substr(d.id_pangkat,1,1) = ', $data['golongan']);
            }

            if($data['nama_pegawai']){
                // $this->db->like('a.nama', $data['nama_pegawai']);
                $this->db->where('(a.nama LIKE "%'.$data['nama_pegawai'].'%" OR a.nipbaru_ws LIKE "%'.$data['nama_pegawai'].'%")');
            }

            // $result = $this->db->get()->result_array();
            // dd($result);
            return $this->db->get()->result_array();
        }

        public function editMasterJenisLayanan($id, $state){
            $this->db->where('id', $id)
                    ->update('db_siladen.jenis_layanan', [
                        'aktif' => $state
                    ]);
        }

        public function loadUserHakAkses($id){
            return $this->db->select('a.*, c.*, d.nm_unitkerja, f.nama_hak_akses, e.nama_jabatan')
                            ->from('t_hak_akses a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                            ->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
                            ->join('db_pegawai.jabatan e', 'c.jabatan = e.id_jabatanpeg')
                            ->join('m_hak_akses f', 'a.id_m_hak_akses = f.id')
                            ->where('a.id_m_hak_akses', $id)
                            ->where('a.flag_active', 1)
                            ->order_by('c.nama')
                            ->get()->result_array();
        }

        public function deleteUserAkses($id){
            $this->db->where('id', $id)
                    ->update('t_hak_akses', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);
        }

        public function getAllPegawai(){
            return $this->db->select('a.*, b.id as id_m_user')
                    ->from('db_pegawai.pegawai a')
                    ->join('m_user b', 'a.nipbaru_ws = b.username')
                    ->where('b.flag_active', 1)
                    ->order_by('a.nama')
                    ->get()->result_array();
        }

        public function tambahHakAksesUser($id_m_user, $id_hak_akses){
            $rs['code'] = 0;
            $rs['message'] = "";

            $exists = $this->db->select('*')
                                ->from('t_hak_akses')
                                ->where('id_m_hak_akses', $id_hak_akses)
                                ->where('id_m_user', $id_m_user)
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if(!$exists){
                $this->db->insert('t_hak_akses', [
                    'id_m_user' => $id_m_user,
                    'id_m_hak_akses' => $id_hak_akses,
                    'created_by' => $this->general_library->getId()
                ]);
            } else {
                $rs['code'] = 1;
                $rs['message'] = "User Sudah Terdaftar";   
            }

            return $rs;
        }

        public function loadDetailPelanggaran($id){
            return $this->db->select('*')
                            ->from('m_pelanggaran_detail')
                            ->where('id_m_pelanggaran', $id)
                            ->where('flag_active', 1)
                            ->get()->result_array();
        }

	}
?>