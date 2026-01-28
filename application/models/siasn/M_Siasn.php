<?php
    // require 'vendor/autoload.php';
    // require FCPATH . 'vendor/autoload.php';
    // use PhpOffice\PhpSpreadSheet\Spreadsheet;
    // use PhpOffice\PhpSpreadSheet\IOFactory;
    // require FCPATH . '/vendor/autoload.php';

    // use mpdf\mpdf;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	class M_Siasn extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function sinkronIdSiasn($id_siladen, $id_siasn, $data){
            $this->db->where('id', $id_siladen)
                    ->update('db_pegawai.pegjabatan', [
                        'updated_by' => $this->general_library->getId(),
                        'id_siasn' => $id_siasn,
                        'id_unor_siasn' => $data['siasn'][$id_siasn]['unorId'],
                        'meta_data_siasn' => json_encode($data['siasn'][$id_siasn]),
                    ]);
        }

        public function mappingJabatanFungsional($flag_only_show){
            $siladen = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatan_siasn IS NULL')
                                ->where('jenis_jabatan', 'JFT')
                                ->order_by('nama_jabatan', 'asc')
                                ->get()->result_array();

            $jenjang1 = ['Mahir', 'Pemula', 'Penyelia', 'Terampil', 'Pelaksana', 'Lanjutan', 'Pelaksana Lanjutan', 'Pertama', 'Muda', 'Madya', 'Utama'];
            $jenjang2 = ['Ahli Pertama', 'Ahli Muda', 'Ahli Madya', 'Ahli Utama'];

            $list_jabatan = null;
            foreach($siladen as $sil){
                $new = "";
                foreach($jenjang2 as $j){
                    $new = str_replace($j, "", $sil['nama_jabatan']);
                    if($new != $sil['nama_jabatan']){
                        break;
                    }
                }
                $new2 = "";
                foreach($jenjang1 as $j2){
                    $new2 = str_replace($j2, "", $new);
                    if($new2 != $new){
                        break;
                    }
                }

                $list_jabatan[trim($new2)] = $new2;
            }

            foreach($list_jabatan as $lj){
                foreach($jenjang2 as $jj){
                    $nama_jabatan = strtoupper($lj.' '.$jj);
                }
            }

            // $siasn = null;
            // if($jenis == 'struktural'){
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_struktural')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // } else if($jenis == 'JFT'){
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_fungsional')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // } else {
            //     $siasn = $this->db->select('*')
            //                     ->from('db_siasn.m_ref_jabatan_pelaksana')
            //                     ->order_by('nama_asc')
            //                     ->get()->result_array();
            // }
        }

        public function mappingJabatanOld($jenis, $percent, $flag_only_show){
            $siladen = $this->db->select('*')
                                ->from('db_pegawai.jabatan')
                                ->where('id_jabatan_siasn IS NULL')
                                ->where('jenis_jabatan', $jenis)
                                ->get()->result_array();

            $siasn = null;
            if($jenis == 'struktural'){
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_struktural')
                                ->get()->result_array();
            } else if($jenis == 'JFT'){
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_fungsional')
                                ->get()->result_array();
            } else {
                $siasn = $this->db->select('*')
                                ->from('db_siasn.m_ref_jabatan_pelaksana')
                                ->get()->result_array();
            }

            foreach($siladen as $sil){
                foreach($siasn as $sia){
                    $sim = similar_text(strtoupper($sil['nama_jabatan']), strtoupper($sia['nama']), $sim);
                    if($sim >= $percent){
                        if($flag_only_show == 0){
                            $this->db->where('id_jabatanpeg', $sil['id_jabatanpeg'])
                                    ->update('db_pegawai.jabatan', [
                                        'id_jabatan_siasn' => $sia['id']
                                    ]);
                        }
                        echo $sil['nama_jabatan'].' -> '.$sia['nama'].'<br>';
                        break;
                    }
                }
            }
        }

        public function revertMappingJabatan($jenis, $percent, $flag_only_show){
            $this->db->select('a.*, b.nama')
                                ->from('db_pegawai.jabatan a')
                                ->where('id_jabatan_siasn IS NOT NULL')
                                ->where('jenis_jabatan', $jenis);
                                // ->get()->result_array();

            // $siasn = null;
            if($jenis == 'struktural'){
                $this->db->join('db_siasn.m_ref_jabatan_struktural b', 'a.id_jabatan_siasn = b.id');
            } else if($jenis == 'JFT'){
                $this->db->join('db_siasn.m_ref_jabatan_fungsional b', 'a.id_jabatan_siasn = b.id');
            } else {
                $this->db->join('db_siasn.m_ref_jabatan_pelaksana b', 'a.id_jabatan_siasn = b.id');
            }

            $siladen = $this->db->get()->result_array();

            foreach($siladen as $sil){
                $sim = similar_text(strtoupper($sil['nama_jabatan']), strtoupper($sil['nama']), $sim);
                if($sim < $percent){
                    if($flag_only_show == 0){
                        $this->db->where('id_jabatanpeg', $sil['id_jabatanpeg'])
                                ->update('db_pegawai.jabatan', [
                                    'id_jabatan_siasn' => null
                                ]);
                    }
                    echo $sil['nama_jabatan'].' -> '.$sil['nama'].'<br>';
                }
            }
        }

        public function cronRiwayatSkpSiasn(){
            $listPegawai = $this->db->select('a.*, b.id as id_m_user')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_ws = b.username')
                                ->where('b.flag_active', 1)
                                ->where('b.id NOT IN (
                                    SELECT aa.id_m_user
                                    FROM t_cron_sync_skp_siasn aa
                                    WHERE aa.flag_active = 1
                                )')
                                // ->where('a.nipbaru_ws', '199502182020121013')
                                ->where('a.id_m_status_pegawai', 1)
                                ->limit(100)
                                // ->limit(1)
                                ->get()->result_array();
            // dd($listPegawai);
            if($listPegawai){
                foreach($listPegawai as $lp){
                    $this->db->insert('t_cron_sync_skp_siasn', [
                        'id_m_user' => $lp['id_m_user']
                    ]);
                }
            }

            $data = $this->db->select('*')
                            ->from('t_cron_sync_skp_siasn')
                            ->where('flag_active', 1)
                            ->where('flag_done', 0)
                            ->where('temp_count <', 3)
                            ->limit(10)
                            ->get()->result_array();
            if($data){
                foreach($data as $d){
                    $cron = $this->syncRiwayatSkpSiasn($d['id_m_user']);
                    
                    $udpate = [
                        'temp_count' => $d['temp_count'] += 1,
                        'last_try_date' => date('Y-m-d H:i:s'),
                        'log' => $cron && isset($cron['data']) ? $cron['data'] : json_encode($cron),
                        'flag_done' => 0
                    ];

                    if($cron['code'] == 0){
                        $udpate['flag_done'] = 1;
                        $udpate['done_date'] = date('Y-m-d H:i:s');
                    }

                    $this->db->where('id', $d['id'])
                            ->update('t_cron_sync_skp_siasn', $udpate);
                }
            }
        }

        public function syncRiwayatSkpSiasn($id_m_user){
            $rs['code'] = 0;
            $rs['message'] = 'Sinkronisasi Riwayat SKP dengan SIASN sudah berhasil';
            $rs['data'] = null;

            $user = $this->db->select('b.*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->where('a.id', $id_m_user)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();

            $this->db->trans_begin();

            if($user){
                $reqSiasn = $this->siasnlib->getRiwayatSkp22($user['nipbaru_ws']);
                $rs['data'] = json_encode($reqSiasn);
                if($reqSiasn && $reqSiasn['code'] == 0){
                    $resSiasn = json_decode($reqSiasn['data'], true);
                    if(isset($resSiasn['data'])){
                        $listSkpPegawai = $this->db->select('*')
                                                ->from('db_pegawai.pegskp')
                                                ->where('id_pegawai', $user['id_peg'])
                                                ->where('flag_active', 1)
                                                ->get()->result_array();
                        $dataSkpPegawai = null;
                        if($listSkpPegawai){
                            foreach($listSkpPegawai as $lsp){
                                $dataSkpPegawai[$lsp['tahun']] = $lsp;
                            }
                        }

                        foreach($resSiasn['data'] as $rsd){
                            if(isset($dataSkpPegawai[$rsd['tahun']])){
                                $dataSkpPegawai[$rsd['tahun']]['id_siasn'] = $rsd['id'];
                                $dataSkpPegawai[$rsd['tahun']]['meta_data_siasn'] = json_encode($rsd);
                                $dataSkpPegawai[$rsd['tahun']]['predikat'] = strtoupper(getPredikatSkp($rsd));
                                $dataSkpPegawai[$rsd['tahun']]['nilai'] = intval($rsd['hasilKinerjaNilai']).''.intval($rsd['PerilakuKerjaNilai']);
                                $dataSkpPegawai[$rsd['tahun']]['status'] = 2;
                                
                                $this->db->where('id', $dataSkpPegawai[$rsd['tahun']]['id'])
                                        ->update('db_pegawai.pegskp', $dataSkpPegawai[$rsd['tahun']]);
                            } else {
                                $pegskp = [
                                    'id_pegawai' => $user['id_peg'],
                                    'tahun' => $rsd['tahun'],
                                    'predikat' => strtoupper(getPredikatSkp($rsd)),
                                    'nilai' => intval($rsd['hasilKinerjaNilai']).''.intval($rsd['PerilakuKerjaNilai']),
                                    'status' => 2,
                                    'tanggal_verif' => date('Y-m-d H:i:s'),
                                    'id_siasn' => $rsd['id'],
                                    'flag_from_siasn' => 1,
                                    'meta_data_siasn' => json_encode($rsd),
                                ];
                                $this->db->insert('db_pegawai.pegskp', $pegskp);
                            }
                        }                        
                    } else {
                        $rs['code'] = 1;
                        $rs['message'] = json_encode($resSiasn);    
                    }
                } else {
                    $rs['code'] = $reqSiasn['code'];
                    $rs['message'] = isset($reqSiasn['message']) ? $reqSiasn['message'] : json_encode($reqSiasn);
                }
            }

            if($rs['code'] != 0){
                $this->db->trans_rollback();
                return $rs;
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = "Terjadi Kesalahan";
            } else {
                $this->db->trans_commit();
                return $rs;
            }
        }

        public function cronRiwayatJabatanSiasn(){
            $listPegawai = $this->db->select('a.*, b.id as id_m_user')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_ws = b.username')
                                ->where('b.flag_active', 1)
                                ->where('b.id NOT IN (
                                    SELECT aa.id_m_user
                                    FROM t_cron_sync_jabatan_siasn aa
                                    WHERE aa.flag_active = 1
                                )')
                                // ->where('a.nipbaru_ws', '199502182020121013')
                                ->where('a.id_m_status_pegawai', 1)
                                ->limit(100)
                                // ->limit(1)
                                ->get()->result_array();
            // dd($listPegawai);
            if($listPegawai){
                foreach($listPegawai as $lp){
                    $this->db->insert('t_cron_sync_jabatan_siasn', [
                        'id_m_user' => $lp['id_m_user']
                    ]);
                }
            }

            $data = $this->db->select('*')
                            ->from('t_cron_sync_jabatan_siasn')
                            ->where('flag_active', 1)
                            ->where('flag_done', 0)
                            ->where('temp_count <', 3)
                            ->limit(10)
                            ->get()->result_array();
            if($data){
                foreach($data as $d){
                    $cron = $this->syncRiwayatJabatanSiasn($d['id_m_user']);
                    
                    $udpate = [
                        'temp_count' => $d['temp_count'] += 1,
                        'last_try_date' => date('Y-m-d H:i:s'),
                        'log' => $cron && isset($cron['data']) ? $cron['data'] : json_encode($cron),
                        'flag_done' => 0
                    ];

                    if($cron['code'] == 0){
                        $udpate['flag_done'] = 1;
                        $udpate['done_date'] = date('Y-m-d H:i:s');
                    }

                    $this->db->where('id', $d['id'])
                            ->update('t_cron_sync_jabatan_siasn', $udpate);
                }
            }
        }

        public function syncDataUtamaPns(){
            $listPegawai = $this->db->select('*')
                                ->from('t_temp_data_pppk2024')
                                // ->where('flag_sinkron_done', 0)
                                ->where('log IS NOT NULL')
                                // ->where('nip', '197302092025211006')
                                // ->where_in('nip', [
                                //     '199208072025212029',
                                //     '198810232025212035',
                                //     '199506262025211031',
                                //     '199503162025211014',
                                //     '199402022025211003'
                                // ])
                                // ->limit(5)
                                ->get()->result_array();

            $list_jabatan = null;
            $jabatan = $this->db->select('*')
                            ->from('db_pegawai.jabatan')
                            ->get()->result_array();
            foreach($jabatan as $j){
                $list_jabatan[$j['id_jabatan_siasn']] = $j;
            }

            $list_unitkerja = null;
            $uker = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->get()->result_array();
            foreach($uker as $u){
                $list_unitkerja[$u['id_unor_siasn']] = $u;
            }

            $success = null;
            $unmappingUnor = null;
            if($listPegawai){
                $i = 0;
                foreach($listPegawai as $lp){
                    $res = json_decode($lp['log'], true);
                    echo "trying ".$lp['nip']."<br>";
                    if(!$res){
                        echo "res null<br>";
                    } else {
                        // <<PANGKAT>>
                        // 35 => D-IV, 40 => S-1, 30 => D-III, 15 => SLTA, 10 => SLTP
                        $pangkat[35] = 59;
                        $pangkat[40] = 59;
                        $pangkat[30] = 57;
                        $pangkat[15] = 55;
                        $pangkat[10] = 53;
                        $this->db->where('nipbaru_ws', $lp['nip'])
                                ->update('db_pegawai.pegawai', [
                                    'pangkat' => $pangkat[$res['tkPendidikanTerakhirId']]
                                ]);
                        // if($res['tkPendidikanTerakhirId'] != 35 &&
                        //     $res['tkPendidikanTerakhirId'] != 40 && 
                        //     $res['tkPendidikanTerakhirId'] != 30 &&
                        //     $res['tkPendidikanTerakhirId'] != 15 &&
                        //     $res['tkPendidikanTerakhirId'] != 10
                        // ){
                        //     if()
                        // }


                        // <<JABATAN>>
                        // dd($res['jenisJabatan']);
                        // $idJabatanSiasn = $res['jenisJabatan'] == "FUNGSIONAL_UMUM" ? $res['jabatanFungsionalUmumId'] : $res['jabatanFungsionalId'];
                        // $namaJabatanSiasn = $res['jabatanNama'];
                        // $jenisJabtanSiasn = $res['jenisJabatan'] == "FUNGSIONAL_UMUM" ? "JFU" : "JFT";
                        // $selectedJabatan = isset($list_jabatan[$idJabatanSiasn]) ? $list_jabatan[$idJabatanSiasn] : null;

                        // // dd($idJabatanSiasn);

                        // $selectedUnor = null;
                        // $selectedUnorJabatan = null;
                        // if(isset($list_unitkerja[$res['unorId']])){
                        //     $selectedUnor = $list_unitkerja[$res['unorId']];
                        // } else {
                        //     $unmappingUnor[$i]['id'] = $res['unorId'];
                        //     $unmappingUnor[$i]['nama'] = $res['unorNama'];
                        // }

                        // if(!$selectedJabatan){
                        //     $selectedJabatan = isset($list_jabatan[$res['jabatanFungsionalUmumId']]) ? $list_jabatan[$res['jabatanFungsionalUmumId']] : null;
                        //     if(!$selectedJabatan){
                        //         $idUnitKerjaDummy = "9999000";
                        //         $selectedJabatan = [
                        //             'id_jabatanpeg' => $idUnitKerjaDummy.generateRandomString(4),
                        //             'id_unitkerja' => $idUnitKerjaDummy,
                        //             'id_jabatan_siasn' => $idJabatanSiasn,
                        //             'nama_jabatan' => $namaJabatanSiasn,
                        //             'jenis_jabatan' => $jenisJabtanSiasn,
                        //             'eselon' => "Non Eselon",
                        //             'kepalaskpd' => null,
                        //             'prestasi_kerja' => 50,
                        //             'beban_kerja' => 0,
                        //             'kondisi_kerja' => 0, 
                        //         ];
                        //         // echo "JABATAN TIDAK ADA DI DATABASE<br>";
                        //         // dd(json_encode($selectedJabatan));
                        //         $this->db->insert('db_pegawai.jabatan', $selectedJabatan);
                        //     }
                        // }
                        // // dd($selectedJabatan);
                        // if($selectedJabatan){
                        //     $pegjabatan = $this->db->select('a.*')
                        //                         ->from('db_pegawai.pegjabatan a')
                        //                         ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                        //                         ->where('b.nipbaru_ws', $lp['nip'])
                        //                         ->where('a.tmtjabatan', '2025-09-01')
                        //                         ->get()->row_array();
                        //     if($pegjabatan){
                        //         $this->db->where('id', $pegjabatan['id'])
                        //                 ->update('db_pegawai.pegjabatan', [
                        //                     'nm_jabatan' => $selectedJabatan['nama_jabatan'],
                        //                     'id_jabatan' => $selectedJabatan['id_jabatanpeg'],
                        //                 ]);

                        //         $this->db->where('nipbaru_ws', $lp['nip'])
                        //                 ->update('db_pegawai.pegawai', [
                        //                     'jabatan' => $pegjabatan['id_jabatan']
                        //                 ]);

                        //         $this->db->where('nip', $lp['nip'])
                        //                 ->update('t_temp_data_pppk2024', [
                        //                     'flag_sinkron_done' => 1
                        //                 ]);
                        //     }
                        // } else {
                        //     echo "JABATAN NULL<br>";
                        //     dd(json_encode($res));
                        // }
                        
                        echo "done ".$lp['nip']."<br>";
                    }
                    $i++;
                }
            }
            dd("done");
        }

        public function cronSyncJabatanSiasn(){
            $rs['code'] = 0;
            $rs['message'] = 'Sinkronisasi Riwayat Jabatan dengan SIASN sudah berhasil';

            $listPegawai = $this->db->select('a.*, b.nip as nip_done, d.id_unor_siasn as id_unor_siasn_bidang, e.id_unor_siasn as id_unor_siasn_subbidang')
                                ->from('db_pegawai.pegawai a')
                                ->join('t_log_sync_jabatan b', 'a.nipbaru_ws = b.nip AND b.flag_active = 1', 'left')
                                ->join('m_user c', 'a.nipbaru_ws = c.username')
                                ->join('m_bidang d', 'c.id_m_bidang = d.id', 'left')
                                ->join('m_sub_bidang e', 'c.id_m_sub_bidang = e.id', 'left')
                                ->where('id_m_status_pegawai', 1)
                                ->where_not_in('a.nipbaru_ws', ['001', '002'])
                                // ->where('(b.nip IS NULL OR b.flag_success = 0)') // jika sudah pernah sinkron dan gagal, akan dicoba sinkron lagi
                                ->where('b.nip IS NULL') // hanya yg belum pernah disinkron yg akan disinkron
                                // ->where('a.skpd', 6130000)
                                ->where_in('a.statuspeg', [2,1]) // cpns dan pns
                                // ->where('a.nipbaru_ws', "197909272009032001")
                                ->where('c.flag_active', 1)
                                ->group_by('a.nipbaru_ws')
                                ->where_not_in('a.skpd', [
                                    9000001 // mahasiswa tugas belajar
                                ])
                                ->limit(10)
                                ->get()->result_array();

            if($listPegawai){
                foreach($listPegawai as $lp){
                    $log = "";
                    $dataSync = null;
                    $listJabatan = $this->db->select('a.*, b.id_unor_siasn as id_unor_siasn_pegjabatan, c.id_jabatan_siasn,
                                        d.kel_jabatan_id, e.id_unor_siasn as id_unor_siasn_unitkerja, f.id_jabatan_siasn as id_jabatan_siasn_profil')
                                        ->from('db_pegawai.pegjabatan a')
                                        ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja', 'left')
                                        ->join('db_pegawai.jabatan c', 'a.id_jabatan = c.id_jabatanpeg', 'left')
                                        ->join('db_siasn.m_ref_jabatan_fungsional d', 'c.id_jabatan_siasn = d.id', 'left')
                                        ->join('db_pegawai.unitkerja e', $lp['skpd'].' = e.id_unitkerja')
                                        ->join('db_pegawai.jabatan f', '"'.$lp['jabatan'].'" = f.id_jabatanpeg', 'left')
                                        ->where('statusjabatan', 1)
                                        ->where('a.flag_active', 1)
                                        ->where('a.id_pegawai', $lp['id_peg'])
                                        ->order_by('a.tmtjabatan', 'desc')
                                        ->limit(2)
                                        ->get()->result_array();

                    $flagProceed = 0;
                    $log = "";
                    if($listJabatan){
                        $flagProceed = 1;
                        if($listJabatan[0]['id_pegjabatan'] == null){
                            $this->db->where('id', $listJabatan[0]['id'])
                                    ->update('db_pegawai.pegjabatan', [
                                        'id_jabatan' => $lp['jabatan']
                                    ]);
                        }

                        $dataSync['id_jabatan_siasn'] = $listJabatan[0]['id_jabatan_siasn'];
                        if($listJabatan[0]['id_jabatan_siasn'] == null) { // jika id_jabatan_siasn null harus mapping dulu
                            $dataSync['id_jabatan_siasn'] = $listJabatan[0]['id_jabatan_siasn_profil'];
                            if($listJabatan[0]['id_jabatan_siasn_profil'] == null){
                                $flagProceed = 0;
                                $log = "ID JABATAN SIASN belum dimapping ".$lp['jabatan']." ".$listJabatan[0]['nm_jabatan'];
                            }
                        }
                        // dd($dataSync);

                        $dataSync['id_unor_siasn'] = $lp['id_unor_siasn_subbidang']; // ambil id_unor_siasn subbidang
                        if($dataSync['id_unor_siasn'] == null){ // jika null, ambil id_unor_siasn bidang
                            $dataSync['id_unor_siasn'] = $lp['id_unor_siasn_bidang'];
                        }

                        if($dataSync['id_unor_siasn'] == null){ // jika masih null, ambil id_unor_siasn di pegjabatan
                            $dataSync['id_unor_siasn'] = $listJabatan[0]['id_unor_siasn_pegjabatan'];
                        }

                        if($dataSync['id_unor_siasn'] == null){ // jika masih null, ambil id_unor_siasn unitkerja
                            $dataSync['id_unor_siasn'] = $listJabatan[0]['id_unor_siasn_unitkerja'];
                        }

                        if($dataSync['id_unor_siasn'] == null){ // jika masih null, masukkan di log
                            $flagProceed = 0;
                            $log = "ID UNOR SIASN belum dimapping";
                        }
                    } else {
                        $log = "LIST JABATAN KOSONG";
                    }

                    if($flagProceed == 1){
                        if(!isset($listJabatan[0])){
                            dd($listJabatan);
                        }

                        $dataSync['subJabatanId'] = $listJabatan[0]['id_m_ref_sub_jabatan_siasn'];
                        if(in_array($listJabatan[0]['kel_jabatan_id'], LIST_ID_NEED_SUB_JABATAN)){
                            if($listJabatan[0]['id_m_ref_sub_jabatan_siasn'] == null){ // jika null ambil default
                                $dataSync['subJabatanId'] = getDefaultSubJabatan($listJabatan[0]['kel_jabatan_id']);
                                $this->db->where('id', $listJabatan[0]['id'])
                                        ->update('db_pegawai.pegjabatan', [
                                            'id_m_ref_sub_jabatan_siasn' => $dataSync['subJabatanId']
                                        ]);
                            }
                        }

                        $dataSync['jenisMutasiId'] = "MJ";
                        if(isset($listJabatan[1])){
                            if($listJabatan[0]['id_unitkerja'] != $listJabatan[1]['id_unitkerja']){
                                $dataSync['jenisMutasiId'] = "MU";
                            }
                        }

                        $dataSync['jenisPenugasanId'] = "D";
                        
                        $rs = $this->kepegawaian->syncSiasnJabatan($listJabatan[0]['id'], 1, $dataSync);
                        if($rs['code'] == 1){
                            $flagProceed = 0;
                        }
                        $log = json_encode($rs);
                    }

                    $this->db->insert('t_log_sync_jabatan', [
                        'nip' => $lp['nipbaru_ws'],
                        'log' => $log,
                        'flag_success' => $flagProceed
                    ]);

                    echo $lp['nipbaru_ws']." => ".$log."<br><br>";
                }
            }
        }

        public function syncRiwayatJabatanSiasn($id_m_user){
            $rs['code'] = 0;
            $rs['message'] = 'Sinkronisasi Riwayat Jabatan dengan SIASN sudah berhasil';

            $user = $this->db->select('b.*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->where('a.id', $id_m_user)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();

            $this->db->trans_begin();

            if($user){
                $reqWs = $this->siasnlib->getJabatanByNip($user['nipbaru_ws']);
                if($reqWs['code'] == 0){
                    $riwayatJabatanSiasn = json_decode($reqWs['data'], true);

                    $listJabatanSiladen = null;
                    $riwayatJabatanSiladen = $this->db->select('*')
                                                    ->from('db_pegawai.pegjabatan')
                                                    ->where('id_pegawai', $user['id_peg'])
                                                    ->where('flag_active', 1)
                                                    ->get()->result_array();
                    if($riwayatJabatanSiladen){
                        foreach($riwayatJabatanSiladen as $rw){
                            // if($rw['id_siasn'] == null){
                                $listJabatanSiladen[$rw['nosk'].formatDateOnlyForEdit2($rw['tmtjabatan'])]['id'] = $rw['id'];
                            // }
                            // $listJabatanSiladen[$rw['nosk']]['meta_data_siasn'] = $rw['meta_data_siasn'];
                        }
                    }

                    if($riwayatJabatanSiasn['data']){
                        foreach($riwayatJabatanSiasn['data'] as $d){
                            if($d['nomorSk'] && isset($listJabatanSiladen[$d['nomorSk'].formatDateOnlyForEdit2($d['tmtJabatan'])])){
                                // kalo ada nomor SK yang sama dengan riwayat, update meta_data_siasn
                                $fileName = null;
                                if($d['path'] && isset($d['path'][872])){
                                    $file = $this->siasnlib->downloadDokumen($d['path'][872]['dok_uri']);
                                    if($file['code'] == 0){
                                        $fileName = 'SK_JABATAN_'.$d['id'].'_'.date('ymdhis').'.pdf';
                                        file_put_contents('arsipjabatan/'.$fileName, $file['data']);
                                    }
                                }

                                $this->db->where('id', $listJabatanSiladen[$d['nomorSk'].formatDateOnlyForEdit2($d['tmtJabatan'])]['id'])
                                        ->update('db_pegawai.pegjabatan', [
                                            'meta_data_siasn' => json_encode($d),
                                            'id_siasn' => $d['id'],
                                            'id_unor_siasn' => $d['unorId'],
                                            'gambarsk' => $fileName,
                                            'created_by' => $this->general_library->getId(),
                                        ]);
                            } else {
                                // kalo tidak ada, buat baru dan kasih tanda flag_from_siasn
                                $id_jabatan_siasn = '';
                                $nama_jabatan_siasn = '';

                                if(isset($d['jabatanFungsionalId']) && $d['jabatanFungsionalId'] != null && $d['jabatanFungsionalId'] != ""){
                                    $id_jabatan_siasn = $d['jabatanFungsionalId'];
                                    $nama_jabatan_siasn = $d['jabatanFungsionalNama'];
                                } else if(isset($d['jabatanFungsionalUmumId']) && $d['jabatanFungsionalUmumId'] != null && $d['jabatanFungsionalUmumId'] != ""){
                                    $id_jabatan_siasn = $d['jabatanFungsionalId'];
                                    $nama_jabatan_siasn = $d['jabatanFungsionalUmumNama'];
                                } else if(isset($d['jabatanStrukturalId']) && $d['jabatanStrukturalId'] != null && $d['jabatanStrukturalId'] != ""){
                                    $id_jabatan_siasn = $d['jabatanFungsionalId'];
                                    $nama_jabatan_siasn = $d['jabatanStrukturalNama'];
                                }
                                $unor = $this->db->select('*, b.id as id_m_bidang, c.id as id_m_sub_bidang')
                                                ->from('db_pegawai.unitkerja a')
                                                ->join('m_bidang b', 'a.id_unitkerja = b.id_unitkerja')
                                                ->join('m_sub_bidang c', 'c.id_m_bidang = b.id')
                                                ->where('(a.id_unor_siasn = "'.$d['unorId'].'" OR b.id_unor_siasn = "'.$d['unorId'].'" OR c.id_unor_siasn = "'.$d['unorId'].'")')
                                                ->get()->row_array();

                                $eselon = $this->db->select('*')
                                                ->from('db_pegawai.eselon')
                                                ->where('id_eselon_siasn', $d['eselonId'])
                                                ->get()->row_array();

                                $jabatanSiladen = $this->db->select('*')
                                                        ->from('db_pegawai.jabatan')
                                                        ->where('id_jabatan_siasn', $id_jabatan_siasn)
                                                        ->get()->row_array();

                                $insert_data['id_pegawai'] = $user['id_peg'];
                                $insert_data['nm_jabatan'] = $jabatanSiladen ? $jabatanSiladen['nama_jabatan'] : $nama_jabatan_siasn;
                                $insert_data['id_jabatan'] = $jabatanSiladen ? $jabatanSiladen['id_jabatanpeg'] : null;
                                $insert_data['tmtjabatan'] = formatDateOnlyForEdit($d['tmtJabatan']);
                                $insert_data['jenisjabatan'] = isset($d['jabatanStrukturalId']) && $d['jabatanStrukturalId'] != null && $d['jabatanStrukturalId'] != "" ? "00" : "10";
                                $insert_data['eselon'] = $eselon ? $eselon['id_eselon'] : 1;
                                $insert_data['nosk'] = $d['nomorSk'];
                                $insert_data['tglsk'] = formatDateOnlyForEdit($d['tanggalSk']);
                                $insert_data['skpd'] = $unor ? $unor['nm_unitkerja'] : "";
                                $insert_data['alamatskpd'] = $unor ? $unor['alamat_unitkerja'] : "";
                                // $insert_data['gambarsk'] = $fileName;
                                $insert_data['status'] = "2";
                                $insert_data['created_by'] = $this->general_library->getId();
                                $insert_data['statusjabatan'] = "1";
                                $insert_data['id_unitkerja'] = $unor ? $unor['id_unitkerja'] : "";
                                $insert_data['id_siasn'] = $d['id'];
                                $insert_data['id_unor_siasn'] = $d['unorId'];
                                $insert_data['meta_data_siasn'] = json_encode($d);
                                $insert_data['flag_from_siasn'] = 1;

                                // $this->db->insert('db_pegawai.pegjabatan', $insert_data);
                                $fileName = null;
                                if($d['path'] && isset($d['path'][872])){
                                    $file = $this->siasnlib->downloadDokumen($d['path'][872]['dok_uri']);
                                    if($file['code'] == 0){
                                        $fileName = 'SK_JABATAN_'.$d['id'].'_'.date('ymdhis').'.pdf';
                                        file_put_contents('arsipjabatan/'.$fileName, $file['data']);
                                        $insert_data['gambarsk'] = $fileName;
                                        $this->db->insert('db_pegawai.pegjabatan', $insert_data);
                                    } else {
                                        $rs['code'] = 1;
                                        $rs['message'] = "Gagal menyimpan file. Sinkronisasi Gagal. ".$file['data'];
                                    }
                                }
                            }
                        }
                    }
                    
                } else {
                    $rs['code'] = 1;
                    $rs['message'] = $reqWs['data'];
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan. User tidak ditemukan.';
            }

            if($rs['code'] == 1){
                $this->db->trans_rollback();
                return $rs;
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = "Terjadi Kesalahan";
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function addDataForSyncBangkom(){
            $data = $this->db->select('nipbaru_ws as nip')
                            ->from('db_pegawai.pegawai')
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();

            foreach($data as $d){
                $this->db->insert('t_cron_sync_bangkom_siasn', [
                    'nip' => $d['nip'],
                    'temp_count' => 0,
                ]);
            }
        }

        public function cronSyncBangkom(){
            $list = $this->db->select('a.*, b.id_peg')
                            ->from('t_cron_sync_bangkom_siasn a')
                            ->join('db_pegawai.pegawai b', 'a.nip = b.nipbaru_ws')
                            ->where('a.flag_active', 1)
                            ->where('a.temp_count < 3')
                            ->where('a.flag_done', 0)
                            // ->where('nip', '199502182020121013')
                            ->limit(3)
                            ->get()->result_array();

            if($list){
                foreach($list as $l){
                    $saveLog = null;
                    $rwSerti = $this->siasnlib->getRiwayatKursus($l['nip']);
                    if($rwSerti['code'] == 0){
                        $rs = json_decode($rwSerti['data'], true);
                        if($rs['data']){
                            // dd($rs['data']);
                            // set data diklat dari siasn
                            $siasn = null;
                            foreach($rs['data'] as $dSiasn){
                                $siasn[$dSiasn['noSertipikat']] = $dSiasn;
                                $siasn[$dSiasn['noSertipikat']]['flag_synced'] = 0;
                            }

                            $mDiklat = null;
                            $masterDiklat = $this->db->select('*')
                                                ->from('db_pegawai.diklat')
                                                ->get()->result_array();
                            foreach($masterDiklat as $mDik){
                                $mDiklat[$mDik['id_diklat_siasn']] = $mDik;
                            }

                            // set data diklat dari siladen
                            $diklat = null;
                            $pegdiklat = $this->db->select('a.*, b.id_diklat_siasn')
                                                ->from('db_pegawai.pegdiklat a')
                                                ->join('db_pegawai.diklat b', 'a.jenisdiklat = b.id_diklat')
                                                ->where('a.id_pegawai', $l['id_peg'])
                                                ->where('a.flag_active', 1)
                                                ->where('a.status != 3')
                                                ->get()->result_array();
                            if($pegdiklat){
                                foreach($pegdiklat as $dPegdiklat){
                                    $diklat[$dPegdiklat['nosttpp']] = $dPegdiklat;
                                }
                            }

                            $uploadToSiasn = null;
                            // jika ada data diklat dari siladen, cek yang sama dengan di siasn
                            if($diklat){
                                $syncedSiasn = null;
                                foreach($diklat as $dik){
                                    if(isset($siasn[$dik['nosttpp']])){
                                        $syncedSiasn[$dik['nosttp']] = $dik;

                                        $this->db->where('id', $dik['id'])
                                                ->update('db_pegawai.pegdiklat', [
                                                    'flag_sync_siasn' => 1,
                                                    'id_siasn' => $siasn[$dik['nosttpp']]['id']
                                                ]);

                                        $siasn[$dik['nosttpp']]['flag_synced'] = 1;
                                        unset($siasn[$dik['nosttpp']]);
                                    } else {
                                        // jika tidak ada di siasn, masukkan di sini untuk diupload
                                        $uploadToSiasn[] = $dik;
                                    }
                                }
                                // jika tidak ada di siasn, masukkan di tabel untuk sync ke SIASN
                                if($uploadToSiasn){
                                    $this->db->insert('t_cron_sync_bangkom_to_siasn', [
                                        'nip' => $l['nip'],
                                        'data' => json_encode($uploadToSiasn)
                                    ]);
                                }
                            }

                            // semua data dari SIASN yang flag_synced = 0, inputkan ke siladen
                            foreach($siasn as $sia){
                                if($sia['flag_synced'] == 0){
                                    $tanggalMulaiExpl = explode("-", $sia['tanggalKursus']);
                                    $tanggalAkhirExpl = explode("-", $sia['tanggalSelesaiKursus']);
                                    $tanggaKursusExpl = explode("-", $sia['tanggalKursus']);

                                    $fileName = null;
                                    if($sia['path'] && isset($sia['path'][874])){
                                        $file = $this->siasnlib->downloadDokumen($sia['path'][874]['dok_uri']);
                                        if($file['code'] == 0){
                                            $fileName = 'DIKLAT_'.$sia['id'].'_'.date('ymdhis').'.pdf';
                                            file_put_contents('arsipdiklat/'.$fileName, $file['data']);
                                        }
                                    }

                                    $this->db->insert('db_pegawai.pegdiklat', [
                                        'id_pegawai' => $l['id_peg'],
                                        'jenisdiklat' => isset($mDiklatp[$sia['jenisDiklatId']]) ? $mDiklatp[$sia['jenisDiklatId']]['id_diklat'] : "50", // 50 => seminar
                                        'nm_diklat' => $sia['namaKursus'],
                                        'tptdiklat' => 'Tatap Muka dan / atau Online',
                                        'penyelenggara' => $sia['institusiPenyelenggara'],
                                        'angkatan' => "",
                                        'jam' => $sia['jumlahJam'],
                                        'tglmulai' => $tanggalMulaiExpl[2].'-'.$tanggalMulaiExpl[1].'-'.$tanggalMulaiExpl[0],
                                        'tglselesai' => $tanggalAkhirExpl[2].'-'.$tanggalAkhirExpl[1].'-'.$tanggalAkhirExpl[0],
                                        'nosttpp' => $sia['noSertipikat'],
                                        'tglsttpp' => $tanggaKursusExpl[2].'-'.$tanggaKursusExpl[1].'-'.$tanggaKursusExpl[0],
                                        'gambarsk' => $fileName ? $fileName : '',
                                        'status' => 2,
                                        'flag_siasn' => 1,
                                        'flag_sync_siasn' => 1,
                                        'id_siasn' => $sia['id']
                                    ]);
                                }
                            }

                            $this->db->where('nip', $l['nip'])
                                    ->update('t_cron_sync_bangkom_siasn', [
                                        'flag_done' => 1,
                                        'temp_count' => $l['temp_count']++,
                                        'done_date' => date('Y-m-d H:i:s'),
                                    ]);
                        } else {
                            $saveLog['flag_done'] = 2;
                            $saveLog['temp_count'] = $l['temp_count']++;
                            $saveLog['done_date'] = date('Y-m-d H:i:s');
                        }
                    } else {
                        $saveLog['flag_done'] = 2;
                        $saveLog['temp_count'] = $l['temp_count']++;
                        $saveLog['done_date'] = date('Y-m-d H:i:s');
                    }
                    
                    $saveLog['last_try_date'] = date('Y-m-d H:i:s');
                    $saveLog['temp_count'] = $l['temp_count']++;
                    $saveLog['log'] = json_encode($rwSerti);

                    $this->db->where('nip', $l['nip'])
                            ->update('t_cron_sync_bangkom_siasn', $saveLog);
                }
            }
        }

        public function cronSyncBangkomToSiasn(){
            $masterDiklat = $this->db->select('a.*')
                                    ->from('db_pegawai.diklat a')
                                    ->get()->result_array();
            $mDiklat = null;
            foreach($masterDiklat as $md){
                $mDiklat[$md['id_diklat']] = $md;
            }

            $list = $this->db->select('a.*, b.id_pns_siasn')
                            ->from('t_cron_sync_bangkom_to_siasn a')
                            ->join('db_pegawai.pegawai b', 'a.nip = b.nipbaru_ws')
                            ->where('a.flag_done', 0)
                            ->where('a.temp_count < 3')
                            ->where('a.flag_active', 1)
                            ->limit(3)
                            ->get()->result_array();

            if($list){
                foreach($list as $l){
                    $updateCron['temp_count'] = $l['temp_count']++;
                    $updateCron['last_try_date'] = date('Y-m-d H:i:s');
                    $dataDiklat = json_decode($l['data'], true);
                    if($dataDiklat){
                        $idPnsSiasn = $l['id_pns_siasn'];
                        if(!$idPnsSiasn){
                            $dataPegawaiSiasn = $this->siasnlib->getDataUtamaPnsByNip($l['nip']);
                            if($dataPegawaiSiasn && $dataPegawaiSiasn['code'] == 0){
                                $decData = json_decode($dataPegawaiSiasn['data'], true);
                                $idPnsSiasn = $decData['data']['id'];
                                $this->db->where('nipbaru_ws', $l['nip'], [
                                    'id_pns_siasn' => $idPnsSiasn
                                ]);
                            } else {
                                $updateCron['flag_done'] = 2;
                                $updateCron['done_date'] = date('Y-m-d H:i:s');
                                $updateCron['log'] = json_encode($dataPegawaiSiasn);
                            }
                        }

                        if($idPnsSiasn){ // jika masih kosong, taruh di log
                            $res = null;
                            foreach($dataDiklat as $dDik){
                                if($dDik['jenisdiklat'] != "00"){
                                    $res = $this->syncBangkomToSiasn($dDik['id'], $mDiklat, $idPnsSiasn, 0);
                                }
                            }
                            $updateCron['log'] = json_encode($res);
                            $updateCron['flag_done'] = 1;
                        }
                    } else {
                        $updateCron['flag_done'] = 2;
                        $updateCron['log'] = "data tidak bisa didecode";
                    }

                    $this->db->where('id', $l['id'])
                            ->update('t_cron_sync_bangkom_to_siasn', $updateCron);
                }
            }
        }

        public function syncBangkomToSiasn($id, $mDiklat, $idPnsSiasn, $flag_update = 0){
            $updateDataDiklat = null;

            $data = $this->db->select('a.*, b.id_pns_siasn')
                        ->from('db_pegawai.pegdiklat a')
                        ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                        ->where('id', $id)
                        ->where('flag_active', 1)
                        ->get()->row_array();

            if(!$mDiklat){
                $masterDiklat = $this->db->select('a.*')
                                    ->from('db_pegawai.diklat a')
                                    ->get()->result_array();
                $mDiklat = null;
                foreach($masterDiklat as $md){
                    $mDiklat[$md['id_diklat']] = $md;
                }
            }

            if($data){
                $explodeTanggal = explode("-", $data['tglsttpp']);
                $upload = null;
                $uploadRwBangkom = null;
                if($data['jenisdiklat'] == "00"){
                    $upload = [
                        // "bobot": 0,
                        // "id": "string",
                        "JenisDiklatId" => $mDiklat[$data['jenisdiklat']]['id_diklat_siasn'],
                        "institusiPenyelenggara" => $data['penyelenggara'],
                        "jenisKompetensi" => "",
                        "jumlahJam" => intval($data['jam']),
                        "latihanStrukturalId" => "",
                        "nomor" => $data['nosttpp'],
                        "NomorSertipikat" => $data['nosttpp'],
                        // "path": [
                        //     {
                        //     "dok_id": "string",
                        //     "dok_nama": "string",
                        //     "dok_uri": "string",
                        //     "object": "string",
                        //     "slug": "string"
                        //     }
                        // ],
                        "pnsOrangId" => $idPnsSiasn ? $idPnsSiasn : $data['id_pns_siasn'],
                        "Tahun" => intval($explodeTanggal[0]),
                        "tahun" => intval($explodeTanggal[0]),
                        "tanggal" => formatDateOnlyForEdit2($data['tglmulai']),
                        "tanggalSelesai" => formatDateOnlyForEdit2($data['tglselesai'])
                    ];
                    // dd($upload);
                    // $uploadRwBangkom = $this->siasnlib->createBangkomStruktural($upload);
                } else {
                    $upload = [
                        // "id": "string",
                        // "id_rumpun_jabatan": [
                        //     {
                        //     "rumpun_id": "string"
                        //     }
                        // ],
                        "instansiId" => ID_INSTANSI_SIASN,
                        "institusiPenyelenggara" => $data['penyelenggara'],
                        "jenisDiklatId" => $mDiklat[$data['jenisdiklat']]['id_diklat_siasn'],
                        "jenisKursus" => "",
                        "jenisKursusSertipikat" => $mDiklat[$data['jenisdiklat']]['jenis_kursus_sertipikat_siasn'],
                        "jumlahJam" => intval($data['jam']),
                        "lokasiId" => $data['tptdiklat'],
                        "namaKursus" => $data['nm_diklat'],
                        "nomorSertipikat" => $data['nosttpp'],
                        // "path": [
                        //     {
                        //     "dok_id": "string",
                        //     "dok_nama": "string",
                        //     "dok_uri": "string",
                        //     "object": "string",
                        //     "slug": "string"
                        //     }
                        // ],
                        "pnsOrangId" => $idPnsSiasn ? $idPnsSiasn : $data['id_pns_siasn'],
                        "tahunKursus" => intval($explodeTanggal[0]),
                        "tanggalKursus" => formatDateOnlyForEdit2($data['tglmulai']),
                        "tanggalSelesaiKursus" => formatDateOnlyForEdit2($data['tglselesai'])
                    ];
                    $uploadRwBangkom = $this->siasnlib->createBangkom($upload);
                }

                if($data['id_siasn']){
                    if($flag_update == 0){ // jika sudah sinkron dan flag_update = 0, langsung return karena request bukan untuk update
                        return $updateDataDiklat;
                    }
                    $uploadRwBangkom['id'] = $data['id_siasn'];
                }

                if($uploadRwBangkom){
                    $res = json_decode($uploadRwBangkom['data'], true);
                    if($res['success'] == true){
                        $idDiklatSiasn = $res['mapData']['rwKursusId'];
                        $updateDataDiklat['flag_sync_siasn'] = 1;
                        $updateDataDiklat['id_siasn'] = $idDiklatSiasn;
                        $updateDataDiklat['log_sync_siasn'] = json_encode($uploadRwBangkom);
                        
                        $url = ('arsipdiklat/'.$data['gambarsk']);
                        if(file_exists($url)){
                            $request = [
                                'id_riwayat' => $idDiklatSiasn,
                                'id_ref_dokumen' => 874,
                                'file' => new CURLFile ($url)
                            ];
                            // dd($request);
                            $reqUploadDokumen = $this->siasnlib->uploadRiwayatDokumen($request);
                        }
                    }
                }

                $updateDataDiklat['sync_siasn_try_date'] = date('Y-m-d H:i:s');

                $this->db->where('id', $data['id'])
                                ->update('db_pegawai.pegdiklat', $updateDataDiklat);

                return $uploadRwBangkom;
            }
        }

    }

?>