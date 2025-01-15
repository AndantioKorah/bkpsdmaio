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
                        'log' => isset($cron['data']) ? $cron['data'] : json_encode($cron['data']),
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
                        'log' => isset($cron['data']) ? $cron['data'] : json_encode($cron['data']),
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
                                if($d['path']){
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
                                if($d['path']){
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
    }

?>