<?php

include "vendor/html-to-jpeg-php-master/HtmlToJpeg.php";

class M_Layanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
		$this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
		$this->load->model('user/M_User', 'user');
        $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function getKelengkapanBerkas($nip, $flag_create_dpcp = 0){
        $result['cpns'] = null;
        $result['pns'] = null;
        $result['akte_nikah'] = null;
        $result['hukdis'] = null;
        $result['pidana'] = null;
        $result['dpcp'] = null;
        $result['pmk'] = null;
        $result['akte_cerai'] = null;
        $result['akte_anak'] = null;
        $result['kartu_keluarga'] = null;
        $result['ktp'] = null;
        $result['npwp'] = null;
        $result['rekening'] = null;
        $result['akte_kematian'] = null;
        $result['list_pasangan'] = null;
        $result['list_anak'] = null;
        $result['data_hukdis'] = null;

        // $hubkel = $this->db->select('a.*')
        //                     ->from('db_pegawai.pegkeluarga a')
        //                     ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
        //                     ->where('b.nipbaru_ws', $nip)
        //                     ->where('a.status', 2)
        //                     ->where('a.flag_active', 1)
        //                     ->get()->result_array();
        // if($hubkel){
        //     foreach($hubkel as $h){
        //         if($h['hubkel'] == 20 || $h['hubkel'] == 30){
        //             $result['akte_nikah'][] = $h;
        //         } else if($h['hubkel'] == 40){
        //             $result['akte_anak'][] = $h;
        //         }
        //     }
        // }

        $data_hukdis = $this->db->select('a.nipbaru_ws, b.*')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pegdisiplin b', 'a.id_peg = b.id_pegawai')
                                    ->where('a.nipbaru_ws', $nip)
                                    ->where('b.status', 2)
                                    ->where_in('hd', [20,30])
                                    ->where_in('flag_active', [1,2])
                                    ->get()->result_array();
        if($data_hukdis){
            foreach($data_hukdis as $dh){
                if(date('Y-m-d', $dh['tglsurat'] < date('Y-m-d'))){
                    $diff = trim(countDiffDateLengkap($dh['tglsurat'], date('Y-m-d'), ['tahun']));
                    $expl = explode(" ", $diff);
                    // dd($diff[0] < 1)
                    if($expl[0] < 1){ // dibawah 1 tahun
                        $until_date = date('Y-m-d', strtotime($dh['tmt'].'+ '.$dh['lama_potongan'].' months'));
                        $result['data_hukdis'] = $dh;
                        $result['data_hukdis']['tmt_akhir'] = $until_date;
                    }
                }
            }
        }

        // dd($result['data_hukdis']);

        $skcpnspns = $this->db->select('a.nipbaru_ws, b.*, a.tmtcpns')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegberkaspns b', 'a.id_peg = b.id_pegawai')
                        ->where('a.nipbaru_ws', $nip)
                        // ->where('b.status', 2)
                        ->order_by('b.created_date')
                        ->where_in('flag_active', [1,2])
                        ->get()->result_array();
        
        if($skcpnspns){
            foreach($skcpnspns as $sk){
                if($sk['jenissk'] == 1 && $result['cpns'] == null){
                    $result['cpns'] = $sk;
                } else if($sk['jenissk'] == 2 && $result['pns'] == null){
                    $result['pns'] = $sk;
                }
            }
        }

        if($flag_create_dpcp == 1){
            $result['akte_anak'] = null;

            $temp_anak = $this->db->select('a.*')
                        ->from('t_checklist_pensiun_detail a')
                        ->join('t_checklist_pensiun b', 'a.id_t_checklist_pensiun = b.id')
                        ->where('b.nip', $nip)
                        ->where('a.id_m_berkas', 13)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();

            if($temp_anak){
                foreach($temp_anak as $ta){
                    $result['akte_anak'][] = json_decode($ta['metadata'], true);
                }
            }

            function sortByOrder($a, $b) {
                if ($a['tgllahir'] > $b['tgllahir']) {
                    return 1;
                } elseif ($a['tgllahir'] < $b['tgllahir']) {
                    return -1;
                }
                return 0;
            }

            if(isset($result['anak']) && $result['anak'] != null){
                usort($result['akte_anak'], 'sortByOrder');
            }

        } else {
            $result['akte_anak'] = $this->db->select('a.nipbaru_ws, b.*, c.nm_keluarga')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegkeluarga b', 'a.id_peg = b.id_pegawai')
                        ->join('db_pegawai.keluarga c', 'b.hubkel = c.id_keluarga')
                        ->where('a.nipbaru_ws', $nip)
                        ->where_in('b.status', [1,2])
                        ->where_in('flag_active', [1,2])
                        ->where('b.hubkel', '40')
                        ->order_by('b.tgllahir', 'asc')
                        ->get()->result_array();
        }

        $result['akte_nikah'] = $this->db->select('a.nipbaru_ws, b.*')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegkeluarga b', 'a.id_peg = b.id_pegawai')
                        ->where('a.nipbaru_ws', $nip)
                        ->where_in('b.status', [1,2])
                        ->where_in('flag_active', [1,2])
                        ->where_in('b.hubkel', [20,30])
                        ->order_by('b.tgllahir', 'desc')
                        ->get()->result_array();
        

        $result['skp'] = $this->db->select('a.nipbaru_ws, b.*')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegskp b', 'a.id_peg = b.id_pegawai')
                        ->where('a.nipbaru_ws', $nip)
                        ->where_in('b.status', [1,2])
                        ->order_by('b.tahun', 'desc')
                        ->where_in('flag_active', [1,2])
                        ->get()->row_array();
                        
        $arsip = $this->db->select('a.nipbaru_ws, b.*, c.keterangan')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegarsip b', 'a.id_peg = b.id_pegawai')
                        ->join('m_dokumen c', 'b.id_dokumen = c.id_dokumen')
                        ->where('a.nipbaru_ws', $nip)
                        ->where_in('b.status', [1,2])
                        ->order_by('b.created_date')
                        ->where_in('flag_active', [1,2])
                        ->get()->result_array();
        if($arsip){
            foreach($arsip as $a){
                if($a['id_dokumen'] == 24){
                    // $result['akte_nikah'] = $a;
                } else if($a['id_dokumen'] == 18){
                    $result['hukdis'] = $a;
                } else if($a['id_dokumen'] == 19){
                    $result['pidana'] = $a;
                } else if($a['id_dokumen'] == 30){
                    $result['dpcp'] = $a;
                } else if($a['id_dokumen'] == 29){
                    $result['pmk'] = $a;
                } else if($a['id_dokumen'] == 25){
                    $result['akte_cerai'] = $a;
                }
                // else if($a['id_dokumen'] == 27){
                //     $result['akte_anak'][] = $a;
                // }
                else if($a['id_dokumen'] == 28){
                    $result['kartu_keluarga'] = $a;
                } else if($a['id_dokumen'] == 37){
                    $result['ktp'] = $a;
                } else if($a['id_dokumen'] == 38){
                    $result['npwp'] = $a;
                } else if($a['id_dokumen'] == 39){
                    $result['rekening'] = $a;
                }  else if($a['id_dokumen'] == 26){
                    $result['akte_kematian'] = $a;
                }
            }
        }
        return $result;
    }

    public function updateChecklistPensiun($nip, $data, $id_m_jenis_pensiun){
        $this->db->trans_begin();
        $last_id = null;
        $result = null;

        $pegawai = $this->db->select('*')
                            ->from('db_pegawai.pegawai')
                            ->where('nipbaru_ws', $nip)
                            ->get()->row_array();

        $exists = $this->db->select('*')
                        ->from('t_checklist_pensiun')
                        ->where('nip', $nip)
                        ->where('id_m_jenis_pensiun', $id_m_jenis_pensiun)
                        ->where('flag_active', 1)
                        ->get()->row_array();
        if($exists){
            $last_id = $exists['id'];
            $result = $exists;
        } else {
            $this->db->insert('t_checklist_pensiun', [
                'id_m_jenis_pensiun' => $id_m_jenis_pensiun,
                'nip' => $nip,
                'alamat_sekarang' => $pegawai['alamat'],
                'alamat_setelah_pensiun' => $pegawai['alamat'],
                'created_by' => $this->general_library->getId()
            ]);

            $last_id = $this->db->insert_id();
            $result = $this->db->select('*')
                                ->from('t_checklist_pensiun')
                                ->where('flag_active', 1)
                                ->where('id', $last_id)
                                ->get()->row_array();
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return [$last_id, $result];
    }

    public function getProgressChecklistPensiun($id_t_checklist_pensiun){
        $result = null;

        $progress = $this->db->select('a.*, b.nama as verifikator, c.meta_name, a.created_date')
                            ->from('t_checklist_pensiun_detail a')
                            ->join('m_user b', 'a.id_m_user_validasi = b.id')
                            ->join('m_dokumen_pensiun c', 'a.id_m_berkas = c.id')
                            ->where('a.id_t_checklist_pensiun', $id_t_checklist_pensiun)
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            // ->group_by('a.id')
                            ->get()->result_array();
        if($progress){
            foreach($progress as $p){
                $result[$p['meta_name']] = $p;
            }
        }

        $result['data'] = $this->db->select('*')
                                    ->from('t_checklist_pensiun')
                                    ->where('id', $id_t_checklist_pensiun)
                                    ->get()->row_array();

        return $result;
    }

    public function batalValidasiBerkas($berkas, $id_t_checklist_pensiun){
        $rs['code'] = 0;
        $rs['message'] = "";

        $master = $this->db->select('*')
                        ->from('m_dokumen_pensiun')
                        ->where('meta_name', $berkas)
                        ->where('flag_active', 1)
                        ->get()->row_array();

        $this->db->where('id_t_checklist_pensiun', $id_t_checklist_pensiun)
                ->where('id_m_berkas', $master['id'])
                ->update('t_checklist_pensiun_detail', [
                    'flag_active' => 0,
                    'updated_by' => $this->general_library->getId()
                ]);

        return $rs;
    }

    public function validasiBerkas($nip, $berkas, $id_t_checklist_pensiun){
        $rs['code'] = 0;
        $rs['message'] = "";
        
		$temp = $this->session->userdata('berkas_pensiun');

        if($berkas == 'akte_anak' || $berkas == 'akte_nikah'){
            $tempAnak = $temp['berkas'][$berkas];
			$data_berkas = null;

            $selectedAnak = null;
            $input_post = $this->input->post();
            if($input_post && isset($input_post['list_anak'])){
                foreach($input_post['list_anak'] as $ip){
                    $selectedAnak[$ip] = $ip;
                }
            }

            if($selectedAnak){
                $i = 0;
                foreach($tempAnak as $ta){
                    if(isset($selectedAnak[$ta['id']])){
                        $data_berkas[$i] = $ta;
                        $data_berkas[$i]['metadata'] = json_encode($ta);
                    }
                    $i++;
                }
            }
		} else {
			$data_berkas[] = $temp['berkas'][$berkas];
		}

        $master = $this->db->select('*')
                        ->from('m_dokumen_pensiun')
                        ->where('meta_name', $berkas)
                        ->where('flag_active', 1)
                        ->get()->row_array();

        $exists = $this->db->select('*, a.id as id_t_checklist_pensiun_detail, c.id as id_t_checklist_pensiun')
                        ->from('t_checklist_pensiun_detail a')
                        ->join('m_dokumen_pensiun b', 'a.id_m_berkas = b.id')
                        ->join('t_checklist_pensiun c', 'a.id_t_checklist_pensiun = c.id')
                        ->where('b.meta_name', $berkas)
                        ->where('c.nip', $nip)
                        ->where('c.flag_active', 1)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();
        if($exists){
            $this->db->where('id_t_checklist_pensiun', $exists['id_t_checklist_pensiun'])
                    ->where('id_m_berkas', $master['id'])
                    ->update('t_checklist_pensiun_detail', [
                        'flag_active' => 0,
                        'created_by' => $this->general_library->getId(),
                        'updated_by' => $this->general_library->getId(),
                        // 'tanggal_validasi' => date('Y-m-d H:i:s')
                    ]);
        }

        $list_input = null;
        if($data_berkas){
            $i = 0;
            foreach($data_berkas as $d){
                $list_input[$i] = [
                    'id_t_checklist_pensiun' => $id_t_checklist_pensiun,
                    'id_m_berkas' => $master['id'],
                    'nama_berkas' => $master['nama_dokumen'],
                    'gambarsk' => $d ? $d['gambarsk'] : null,
                    'id_ref' => $d ? $d['id'] : null,
                    'flag_validasi' => 1,
                    'id_m_user_validasi' => $this->general_library->getId(),
                    'tanggal_validasi' => date('Y-m-d H:i:s'),
                    'metadata' => isset($d['metadata']) ? $d['metadata'] : null
                ];

                if($d && $d['status'] == 1){ // jika belum diverif
                    $this->db->where('id', $d['id'])
                            ->where('status', 1)
                            ->update($master['table_ref'], [
                                'status' => 2,
                                'id_m_user_verif' => $this->general_library->getId(),
                                'tanggal_verif' => date('Y-m-d H:i:s')
                            ]);
                }

                $i++;
            }
        } else {
            $list_input[] = [
                'id_t_checklist_pensiun' => $id_t_checklist_pensiun,
                'id_m_berkas' => $master['id'],
                'nama_berkas' => $master['nama_dokumen'],
                'gambarsk' => null,
                'id_ref' => null,
                'flag_validasi' => 1,
                'id_m_user_validasi' => $this->general_library->getId(),
                'tanggal_validasi' => date('Y-m-d H:i:s')
            ];
        }

        $this->db->insert_batch('t_checklist_pensiun_detail', $list_input);

        $rs['message'] = "Telah divalidasi oleh ".strtoupper($this->general_library->getNamaUser())." pada ".formatDateNamaBulanWT(date('Y-m-d H:i:s'));
        
        return $rs;
    }

    public function simpanDataLainnya($id){
        $rs['code'] = 0;
        $rs['message'] = "";

        $data = $this->input->post();
        $data['updated_by'] = $this->general_library->getId();

        $this->db->where('id', $id)
                ->update('t_checklist_pensiun', $data);

        return $rs;
    }

    public function searchPenomoranDokumenPensiun($data){
        $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.nipbaru_ws, h.nomor_surat, f.id_m_jenis_layanan, f.nama_kolom_ds,
                g.nama_layanan, f.id as id_t_usul_ds, f.keterangan')
                ->from('t_checklist_pensiun a')
                ->join('m_user b', 'a.nip = b.username')
                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                // ->join('t_request_ds d', 'a.id = d.ref_id')
                // ->join('t_nomor_surat e', 'a.id_t_nomor_surat = e.id', 'left')
                ->join('t_usul_ds f', 'a.id = f.ref_id AND f.table_ref = "t_checklist_pensiun" AND f.flag_active = 1')
                ->join('m_jenis_layanan g', 'f.id_m_jenis_layanan = g.id')
                ->join('t_nomor_surat h', 'f.id_t_nomor_surat = h.id', 'left')
                ->where('a.flag_active', 1)
                ->where('MONTH(f.created_date)', $data['bulan'])
                ->where('YEAR(f.created_date)', $data['tahun'])
                // ->where_in('d.id_m_jenis_ds', [1,2,3])
                // ->where('d.flag_selected', 0)
                ->group_by('f.id')
                ->order_by('a.created_date', 'asc')
                ->where('a.flag_active', 1);
                // ->where('d.flag_active', 1);

        if($data['id_unitkerja'] != 0){
            $this->db->where('c.skpd', $data['id_unitkerja']);
        }

        return $this->db->get()->result_array();
    }

    public function loadDetailPenomoranDokumenPensiun($id){
        return $this->db->select('a.*, a.id as id_t_usul_ds, b.nomor_surat, b.counter, d.*, e.url, e.url_done, e.flag_done as flag_done_detail')
                    ->from('t_usul_ds a')
                    ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                    // ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
                    ->join('t_checklist_pensiun d', 'a.ref_id = d.id')
                    ->join('t_usul_ds_detail e', 'e.id_t_usul_ds = a.id')
                    // ->join('t_pengajuan_cuti d', 'a.ref_id = d.id')
                    ->where('a.flag_active', 1)
                    ->where('a.id', $id)
                    // ->where('a.table_ref', 't_pengajuan_cuti')
                    ->get()->row_array();

        // return $this->db->select('a.*, a.id as id_t_request_ds, b.nomor_surat, c.id as id_t_cron_request_ds, b.counter, d.*')
        //             ->from('t_request_ds a')
        //             ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
        //             ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
        //             ->join('t_checklist_pensiun d', 'a.ref_id = d.id')
        //             // ->join('t_pengajuan_cuti d', 'a.ref_id = d.id')
        //             ->where('a.flag_active', 1)
        //             ->where('a.id', $id)
        //             // ->where('a.table_ref', 't_pengajuan_cuti')
        //             ->get()->row_array();
    }

    public function getKepalaBkpsdm(){
        return $this->db->select('a.*, b.id as id_m_user, c.nama_jabatan')
        ->from('db_pegawai.pegawai a')
        ->join('m_user b', 'a.nipbaru_Ws = b.username')
        ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
        ->where('c.kepalaskpd', 1)
        ->where('a.skpd', '4018000')
        ->where('b.flag_active', 1)
        ->get()->row_array();
    }

    

    public function createDpcp($data){
        $rs['code'] = 0;
        $rs['message'] = '';
        $rs['data'] = null;

        $this->db->trans_begin();
        // dd($data);
        $exists = $this->db->select('*')
                        ->from('t_request_ds')
                        // ->from('t_request_ds')
                        ->where('ref_id', $data['id_t_checklist_pensiun'])
                        ->where('table_ref', 't_checklist_pensiun')
                        ->where('flag_active', 1)
                        ->get()->row_array();

        if($exists){
            $rs['code'] = 1;
            $rs['message'] = 'DPCP sudah diajukan';
        } else {
            $bulan = getNamaBulan(date('m'));
            $tahun = date('Y');

            ///////////////////////////////// DPCP
            $fileNameDpcp = 'DPCP_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
            $pathDpcp = 'arsippensiunotomatis/arsipdpcp/'.$fileNameDpcp;
            $html = $this->load->view('kepegawaian/V_CetakDpcp', $data, true);
            // dd($html);
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                // 'debug' => true
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($pathDpcp, 'F');
            $data['kaban'] = $this->kepegawaian->getDataKabanBkd();

            $metaData = $data;
            unset($metaData['progress']);
            
            $rs['data'] = $pathDpcp;
            $this->db->where('id', $data['id_t_checklist_pensiun'])
                    ->where('flag_active', 1)
                    ->update('t_checklist_pensiun', [
                        'url_file_dpcp' => $pathDpcp,
                        'flag_ajukan_ds_dpcp' => 1,
                        'meta_data' => json_encode($metaData),
                        'updated_by' => $this->general_library->getId()
                    ]);

            $usulDsDpcp['table_ref'] = "t_checklist_pensiun";
            $usulDsDpcp['ref_id'] = $data['id_t_checklist_pensiun'];
            $usulDsDpcp['nama_kolom_ds'] = 'flag_ds_dpcp';
            $usulDsDpcp['ds_code'] = "^";
            $usulDsDpcp['page'] = 1;
            $usulDsDpcp['flag_use_nomor_surat'] = 0;
            $usulDsDpcp['keterangan'] = "DPCP pegawai a/n. ".getNamaPegawaiFull($data['profil_pegawai']);
            $usulDsDpcp['id_m_jenis_layanan'] = 104;
            $usulDsDpcp['url_ds'] = $pathDpcp;
            $usulDsDpcp['files'][0]['url'] = $pathDpcp;
            $usulDsDpcp['files'][0]['name'] = generateRandomString()."_".$fileNameDpcp;

            $this->submitUploadFileUsulDs($usulDsDpcp, 1);

            // $fileBase64 = convertToBase64(base_url($pathDpcp));

            // $tteTemplateDpcp = $this->general_library->createQrTte();
            // $request_ws = [
            //     'signatureProperties' => [
            //         "tampilan" => "VISIBLE",
            //         "imageBase64" => $tteTemplateDpcp['data']['qrBase64'],
            //         "tag" => "^",
            //         "width" => 150,
            //         "height" => 150,
            //         "page" => 1,
            //     ],
            //     // 'file' => convertToBase64(($pathDpcp))
            // ];
            // $this->db->insert('t_request_ds', [
            //     'ref_id' => $data['id_t_checklist_pensiun'],
            //     'table_ref' => 't_checklist_pensiun',
            //     'id_m_jenis_ds' => 1,
            //     'nama_jenis_ds' => 'DPCP',
            //     'request' => json_encode($request_ws),
            //     'url_file' => $pathDpcp,
            //     'url_image_ds' => $tteTemplateDpcp['data']['qrBase64'],
            //     'random_string' => $tteTemplateDpcp['data']['randomString'],
            //     'created_by' => $this->general_library->getId(),
            //     'nama_kolom_flag' => 'flag_ds_dpcp',
            //     'nip' => $data['nip'],
            //     'meta_view' => 'kepegawaian/V_CetakDpcp',
            //     'meta_data' => json_encode($data),
            //     'id_m_jenis_layanan' => '104'
            // ]);

            ///////////////////////////////// SP HUKDIS
            if(!$data['berkas']['data_hukdis']){ // jika ada tidak ada data hukdis, buat SP Hukdis
                $fileNameHukdis = 'SPHUKDIS_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
                $pathHukdis = 'arsippensiunotomatis/arsipskhukdis/'.$fileNameHukdis;
                $html = $this->load->view('kepegawaian/surat/V_SuratHukdis', $data, true); 
                // $html = $this->load->view('kepegawaian/V_CetakDpcp', $data, true); // sementara pake ini dlu untuk generate file
                // dd($html);
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'Legal-L',
                    // 'debug' => true
                ]);
                $mpdf->AddPage(
                    'P'
                );
                $mpdf->WriteHTML($html);
                $mpdf->showImageErrors = true;
                $mpdf->Output($pathHukdis, 'F');

                $rs['data'] = $pathHukdis;

                $this->db->where('id', $data['id_t_checklist_pensiun'])
                        ->update('t_checklist_pensiun', [
                            'url_file_hukdis' => $pathHukdis,
                            'flag_ajukan_ds_hukdis' => 1,
                        ]);

                $usulDsHukdis['table_ref'] = "t_checklist_pensiun";
                $usulDsHukdis['ref_id'] = $data['id_t_checklist_pensiun'];
                $usulDsHukdis['nama_kolom_ds'] = 'flag_ds_hukdis';
                $usulDsHukdis['ds_code'] = "^";
                $usulDsHukdis['page'] = 1;
                $usulDsHukdis['meta_view'] = 'kepegawaian/surat/V_SuratHukdis';
                $usulDsHukdis['flag_use_nomor_surat'] = 1;
                $usulDsHukdis['keterangan'] = 'SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR a.n. '.getNamaPegawaiFull($data['profil_pegawai']);
                $usulDsHukdis['id_m_jenis_layanan'] = 39;
                $usulDsHukdis['url_ds'] = $pathHukdis;
                $usulDsHukdis['files'][0]['url'] = $pathHukdis;
                $usulDsHukdis['files'][0]['name'] = generateRandomString()."_".$fileNameHukdis;
    
                $this->submitUploadFileUsulDs($usulDsHukdis, 1);

                // $fileBase64 = convertToBase64(base_url($pathHukdis));

                // $tteTemplateHukdis = $this->general_library->createQrTte();
                // $request_ws = [
                //     'signatureProperties' => [
                //         "tampilan" => "VISIBLE",
                //         "imageBase64" => $tteTemplateHukdis['data']['qrBase64'],
                //         "tag" => "^",
                //         "width" => 150,
                //         "height" => 150,
                //         "page" => 1,
                //     ],
                //     // 'file' => convertToBase64(($pathHukdis))
                // ];
                // $this->db->insert('t_request_ds', [
                //     'ref_id' => $data['id_t_checklist_pensiun'],
                //     'table_ref' => 't_checklist_pensiun',
                //     'id_m_jenis_ds' => 2,
                //     'nama_jenis_ds' => 'SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR',
                //     'perihal' => 'SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR a.n. '.getNamaPegawaiFull($data['profil_pegawai']),
                //     'request' => json_encode($request_ws),
                //     'url_file' => $pathHukdis,
                //     'url_image_ds' => $tteTemplateHukdis['data']['qrBase64'],
                //     'random_string' => $tteTemplateHukdis['data']['randomString'],
                //     'created_by' => $this->general_library->getId(),
                //     'nama_kolom_flag' => 'flag_ds_hukdis',
                //     'nip' => $data['nip'],
                //     'meta_view' => 'kepegawaian/surat/V_SuratHukdis',
                //     'meta_data' => json_encode($data),
                //     'id_m_jenis_layanan' => 39
                // ]);
            } else { // jika ada hukdis, masuk di sini
                
                $this->db->where('id', $data['id_t_checklist_pensiun'])
                        ->update('t_checklist_pensiun', [
                            'url_file_hukdis' => 'arsipdisiplin/'.$data['berkas']['data_hukdis']['gambarsk']
                        ]);
            }


            ///////////////////////////////// SP PIDANA
            $fileNamePidana = 'SPPIDANA_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
            $pathPidana = 'arsippensiunotomatis/arsipskpidana/'.$fileNamePidana;
    		$html = $this->load->view('kepegawaian/surat/V_SuratPidana', $data, true); 
            // $html = $this->load->view('kepegawaian/V_CetakDpcp', $data, true); // sementara pake ini dlu untuk generate file
            // dd($html);
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                // 'debug' => true
            ]);
            $mpdf->AddPage(
                'P'
            );
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($pathPidana, 'F');

            $rs['data'] = $pathPidana;

            $this->db->where('id', $data['id_t_checklist_pensiun'])
                    ->update('t_checklist_pensiun', [
                        'url_file_pidana' => $pathPidana,
                        'flag_ajukan_ds_pidana' => 1
                    ]);

            $usulDsPidana['table_ref'] = "t_checklist_pensiun";
            $usulDsPidana['ref_id'] = $data['id_t_checklist_pensiun'];
            $usulDsPidana['nama_kolom_ds'] = 'flag_ds_pidana';
            $usulDsPidana['ds_code'] = "^";
            $usulDsPidana['page'] = 1;
            $usulDsPidana['meta_view'] = 'kepegawaian/surat/V_SuratPidana';
            $usulDsPidana['flag_use_nomor_surat'] = 1;
            $usulDsPidana['keterangan'] = 'SURAT PERNYATAAN TIDAK SEDANG MENJALANI PROSES PIDANA ATAU PERNAH DIPIDANA PENJARA BERDASARKAN PUTUSAN PENGADILAN YANG TELAH BERKEKUATAN HUKUM TETAP a.n. '.getNamaPegawaiFull($data['profil_pegawai']);
            $usulDsPidana['id_m_jenis_layanan'] = 39;
            $usulDsPidana['url_ds'] = $pathPidana;
            $usulDsPidana['files'][0]['url'] = $pathPidana;
            $usulDsPidana['files'][0]['name'] = generateRandomString()."_".$fileNamePidana;

            $this->submitUploadFileUsulDs($usulDsPidana, 1);

            // $fileBase64 = convertToBase64(base_url($pathPidana));

            // $tteTemplatePidana = $this->general_library->createQrTte();
            // $request_ws = [
            //     'signatureProperties' => [
            //         "tampilan" => "VISIBLE",
            //         "imageBase64" => $tteTemplatePidana['data']['qrBase64'],
            //         "tag" => "^",
            //         "width" => 150,
            //         "height" => 150,
            //         "page" => 1,
            //     ],
            //     // 'file' => convertToBase64(($pathPidana))
            // ];
            // $this->db->insert('t_request_ds', [
            //     'ref_id' => $data['id_t_checklist_pensiun'],
            //     'table_ref' => 't_checklist_pensiun',
            //     'id_m_jenis_ds' => 3,
            //     'nama_jenis_ds' => 'SURAT PERNYATAAN TIDAK SEDANG MENJALANI PROSES PIDANA ATAU PERNAH DIPIDANA PENJARA BERDASARKAN PUTUSAN PENGADILAN YANG TELAH BERKEKUATAN HUKUM TETAP',
            //     'perihal' => 'SURAT PERNYATAAN TIDAK SEDANG MENJALANI PROSES PIDANA ATAU PERNAH DIPIDANA PENJARA BERDASARKAN PUTUSAN PENGADILAN YANG TELAH BERKEKUATAN HUKUM TETAP a.n. '.getNamaPegawaiFull($data['profil_pegawai']),
            //     'request' => json_encode($request_ws),
            //     'url_file' => $pathPidana,
            //     'url_image_ds' => $tteTemplatePidana['data']['qrBase64'],
            //     'random_string' => $tteTemplatePidana['data']['randomString'],
            //     'created_by' => $this->general_library->getId(),
            //     'nama_kolom_flag' => 'flag_ds_pidana',
            //     'nip' => $data['nip'],
            //     'meta_view' => 'kepegawaian/surat/V_SuratPidana',
            //     'meta_data' => json_encode($data),
            //     'id_m_jenis_layanan' => 39
            // ]);
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            // $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }
            
        return $rs;
    }

    public function getDpcpData($id){
        $result = [
            'dpcp' => null,
            'hukdis' => null,
            'pidana' => null
        ];

        $data = $this->db->select('a.*, b.created_date as tanggal_ds, b.keterangan, b.nama_kolom_ds, c.flag_done as flag_done_detail, c.url_done,
                        b.status as status_usul_ds, c.keterangan as keterangan_usul_detail_ds')
                        ->from('t_checklist_pensiun a')
                        ->join('t_usul_ds b', 'a.id = b.ref_id AND b.table_ref = "t_checklist_pensiun" AND b.flag_active = 1')
                        ->join('t_usul_ds_detail c', 'b.id = c.id_t_usul_ds')
                        // ->join('t_cron_request_ds c', 'b.id = c.id_t_request_ds AND c.flag_active = 1', 'left')
                        // ->join('m_user d', 'c.created_by = d.id AND d.flag_active = 1', 'left')
                        // ->join('m_jenis_ds e', 'b.id_m_jenis_ds = e.id')
                        ->where('a.id', $id)
                        ->where('b.flag_active', 1)
                        // ->where('d.flag_active', 1)
                        ->group_by('b.id')
                        ->get()->result_array();
        if($data){
            // dd(json_encode($data));
            foreach($data as $d){
                if($d['nama_kolom_ds'] == 'flag_ds_dpcp'){
                    $result['dpcp'] = $d;
                } else if($d['nama_kolom_ds'] == 'flag_ds_hukdis'){
                    $result['hukdis'] = $d;
                } else if($d['nama_kolom_ds'] == 'flag_ds_pidana'){
                    $result['pidana'] = $d;
                }
            }
        }

        if(!$result['hukdis']){ // jika data hukdis tidak ada, dikarenakan ybs sedang dalam hukdis. ambil data hukdisnya
            $result['hukdis'] = $this->db->select('a.*')
                                        ->from('t_checklist_pensiun a')
                                        ->where('a.id', $id)
                                        ->where('a.flag_active', 1)
                                        ->get()->row_array();

            $result['hukdis']['flag_sedang_hukdis'] = 1;
        }

        return $result;
    }

    public function deleteFileDsManual($id){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();

        $data = $this->db->select('a.*, b.nomor_surat, b.counter, d.*, c.url, c.url_done, c.flag_done as flag_done_detail, c.flag_status, c.id as id_t_usul_ds_detail,
                            d.id as id_t_checklist_pensiun, e.nipbaru_ws, f.id as id_t_request_ds, f.flag_selected')
                            ->from('t_usul_ds a')
                            ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                            ->join('t_usul_ds_detail c', 'a.id = c.id_t_usul_ds')
                            ->join('t_checklist_pensiun d', 'a.ref_id = d.id')
                            ->join('db_pegawai.pegawai e', 'd.nip = e.nipbaru_ws')
                            ->join('t_request_ds f', 'c.id = f.ref_id AND f.table_ref = "t_usul_ds_detail" AND f.flag_active = 1', 'left')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();

        // $data = $this->db->select('a.*, a.id as id_t_request_ds, b.nomor_surat, c.id as id_t_cron_request_ds, b.counter, d.*,
        //                     d.id as id_t_checklist_pensiun, e.nipbaru_ws')
        //                     ->from('t_request_ds a')
        //                     ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
        //                     ->join('t_cron_request_ds c', 'a.id = c.id_t_request_ds', 'left')
        //                     ->join('t_checklist_pensiun d', 'a.ref_id = d.id')
        //                     ->join('db_pegawai.pegawai e', 'd.nip = e.nipbaru_ws')
        //                     // ->join('t_pengajuan_cuti d', 'a.ref_id = d.id')
        //                     ->where('a.flag_active', 1)
        //                     ->where('a.id', $id)
        //                     // ->where('a.table_ref', 't_pengajuan_cuti')
        //                     ->get()->row_array();

        if($data){
            $expl = explode("_", $data['nama_kolom_ds']);

            $this->db->where('id', $data['id_t_checklist_pensiun'])
                    ->update('t_checklist_pensiun', [
                        'flag_ds_'.$expl[2] => 0,
                        'url_ds_manual_'.$expl[2] => null,
                        'updated_by' => $this->general_library->getId(),
                    ]);

            $this->db->where('id', $data['id'])
                    ->update('t_usul_ds', [
                        'flag_done' => 0,
                        'keterangan' => "",
                        'updated_by' => $this->general_library->getId(),
                    ]);

            if($data['id_t_request_ds'] && $data['flag_selected'] == 1){
                $this->db->where('id', $data['id_t_request_ds'])
                        ->update('t_request_ds', [
                            'flag_selected' => 0
                        ]);
            }

            $this->db->where('id', $data['id_t_usul_ds_detail'])
                    ->update('t_usul_ds_detail', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_done' => 0,
                        'flag_status' => 0,
                        'url_done' => null,
                        'keterangan' => ""
                    ]);
                    
            if($data['id_last_active_progress']){
                $this->db->where('id', $data['id_last_active_progress'])
                        ->update('t_usul_ds_detail_progress', [
                            'flag_ds_now' => 0,
                            'flag_selected' => 0,
                        ]);
            }        

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

    public function saveUploadFileDsPenomoranDokumenPensiun($id){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
       
        $this->db->trans_begin();

        $data = $this->db->select('a.*, b.nomor_surat, b.counter, d.*, c.url, c.url_done, c.flag_done as flag_done_detail, c.flag_status,
                            c.id as id_t_usul_ds_detail, d.id as id_t_checklist_pensiun, e.nipbaru_ws, f.id as id_t_request_ds,
                            f.flag_selected, a.id as id_t_usul_ds')
                            ->from('t_usul_ds a')
                            ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                            ->join('t_usul_ds_detail c', 'a.id = c.id_t_usul_ds')
                            ->join('t_checklist_pensiun d', 'a.ref_id = d.id')
                            ->join('db_pegawai.pegawai e', 'd.nip = e.nipbaru_ws')
                            ->join('t_request_ds f', 'c.id = f.ref_id AND f.table_ref = "t_usul_ds_detail" AND f.flag_active = 1', 'left')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();

        // $data = $this->db->select('a.*, c.gelar1, c.nama, c.gelar2, c.nipbaru_ws, c.id_peg, c.handphone, d.nm_cuti, e.id_t_nomor_surat, f.nomor_surat')
        //                     ->from('t_pengajuan_cuti a')
        //                     ->join('m_user b', 'a.id_m_user = b.id')
        //                     ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        //                     ->join('db_pegawai.cuti d', 'a.id_cuti = d.id_cuti')
        //                     ->join('t_request_ds e', 'a.id = e.ref_id AND table_ref = "t_pengajuan_cuti" AND e.flag_active = 1')
        //                     ->join('t_nomor_surat f', 'e.id_t_nomor_surat = f.id', 'left')
        //                     ->where('a.id', $id)
        //                     ->where('a.flag_active', 1)
        //                     ->get()->row_array();
            
        if($data && $data['id_t_nomor_surat'] == null){
            $res['code'] = 1;
            $res['message'] = "SK Belum memiliki Nomor Surat. Harap mengisi Nomor Surat terlebih dahulu.";
            return $res;
        } else if($data && $data['id_t_request_ds'] && $data['flag_selected'] == 1){
            $res['code'] = 1;
            $res['message'] = "File sementara / sudah dilakukan Digital Signature oleh Kepala BKPSDM. Proses tidak dapat dilanjutkan.";
            return $res;
        } else if($data && $data['flag_done'] == 1){
            $res['code'] = 1;
            $res['message'] = "Tidak dapat mengupload file karena proses DS sudah selesai";
            return $res;
        }

        if($_FILES && $data){
            $allowed_extension = ['pdf'];
            $file_array = explode(".", $_FILES["file_ds_manual"]["name"]);
            $file_extension = end($file_array);

            $filename = 'DPCP_DSM_'.$data['nipbaru_ws'].date('Ymd');
            $path = 'arsippensiunotomatis/arsipdpcp/';

            if($data['nama_kolom_ds'] == "flag_ds_hukdis"){
                $filename = 'SPHUKDIS_DSM_'.$data['nipbaru_ws'].date('Ymd').'.pdf';
                $path = 'arsippensiunotomatis/arsipskhukdis/';
            } else if($data['nama_kolom_ds'] == "flag_ds_pidana"){
                $filename = 'SPPIANA_DSM_'.$data['nipbaru_ws'].date('Ymd').'.pdf';
                $path = 'arsippensiunotomatis/arsipskpidana/';
            }

            if(in_array($file_extension, $allowed_extension)){
                if(file_exists($path.$filename)){
                    unlink($path.$filename);
                }

                $config['upload_path'] = $path;
                $config['allowed_types'] = '*';
                $config['file_name'] = ($filename);
                $this->load->library('upload', $config);
                // if(file_exists($config['upload_path'])."/".$file_name){
                //     move_uploaded_file('overwrited_file', ($config['upload_path']."/".$file_name));
                //     unlink(($config['upload_path'])."/".$file_name);
                // }
                $uploadfile = $this->upload->do_upload('file_ds_manual');
                
                $filepath = $path.$filename;
                if($uploadfile){
                    $updateChecklistPensiun = null;
                    if($data['nama_kolom_ds'] == "flag_ds_hukdis"){ //hukdis
                        $updateChecklistPensiun['url_ds_manual_hukdis'] = $filepath;
                        $updateChecklistPensiun['flag_ds_hukdis'] = 1;
                    } else if($data['nama_kolom_ds'] == "flag_ds_pidana"){ //pidana
                        $updateChecklistPensiun['url_ds_manual_pidana'] = $filepath;
                        $updateChecklistPensiun['flag_ds_pidana'] = 1;
                    } else { //dpcp
                        $updateChecklistPensiun['url_ds_manual_dpcp'] = $filepath;
                        $updateChecklistPensiun['flag_ds_dpcp'] = 1;
                    }
                    $updateChecklistPensiun['updated_by'] = $this->general_library->getId();

                    $this->db->where('id', $data['id_t_checklist_pensiun'])
                            ->update('t_checklist_pensiun', $updateChecklistPensiun);

                    if($data['id_t_request_ds']){
                        $this->db->where('id', $data['id_t_request_ds'])
                            ->update('t_request_ds', [
                                'flag_selected' => 1,
                                'updated_by' => $this->general_library->getId()
                            ]);
                    }

                    $bulan = getNamaBulan(date('m'));
                    $tahun = date('Y');

                    copy($filepath, "arsipusulds/".$tahun."/".$bulan."/".$filename);

                    $this->db->where('id', $data['id_t_usul_ds_detail'])
                            ->update('t_usul_ds_detail', [
                                'updated_by' => $this->general_library->getId(),
                                'flag_done' => 1,
                                'flag_status' => 1,
                                'url_done' => "arsipusulds/".$tahun."/".$bulan."/".$filename,
                                'flag_ds_manual' => 1
                                // 'keterangan' => "File DS telah diupload secara manual"
                            ]);
                    
                    $this->db->where('id', $data['id_t_usul_ds'])
                            ->update('t_usul_ds', [
                                'flag_done' => 1,
                                // 'keterangan' => "File DS telah diupload secara manual",
                                'flag_ds_manual' => 1,
                                'updated_by' => $this->general_library->getId(),
                            ]);

                    $usulDsProgres = $this->db->select('*')
                                            ->from('t_usul_ds_detail_progress')
                                            ->where('id_t_usul_ds_detail', $data['id_t_usul_ds_detail'])
                                            ->where('flag_active', 1)
                                            ->where('flag_ds_now', 0)
                                            ->get()->row_array();
                    if($usulDsProgres){
                        $this->db->where('id_t_usul_ds_detail', $data['id_t_usul_ds_detail'])
                                ->update('t_usul_ds_detail_progress', [
                                    'flag_ds_now' => 1,
                                    'flag_selected' => 1,
                                ]);
                    
                        $this->db->where('id', $data['id'])
                                ->update('t_usul_ds', [
                                    'id_last_active_progress' => $usulDsProgres['id']
                                ]);
                    }
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

    public function deleteBerkasPensiun($id){
        $rs = [
            'code' => 0,
            'message' => '',
            'data' => null
        ];

        $this->db->trans_begin();

        $data = $this->db->select('*')
                    ->from('t_checklist_pensiun')
                    ->where('id', $id)
                    ->get()->row_array();

        if(!$data){
            $rs['code'] = 1;
            $rs['message'] = 'Data tidak ditemukan. Data gagal dihapus';
        } else {
            $this->db->where('id', $id)
                    ->update('t_checklist_pensiun', [
                        'flag_ds_dpcp' => 0,
                        'url_file_dpcp' => null,
                        'flag_ds_hukdis' => 0,
                        'url_file_hukdis' => null,
                        'flag_ds_pidana' => 0,
                        'url_file_pidana' => null,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $requestDs = $this->db->select('*')
                                ->from('t_request_ds')
                                ->where('ref_id', $id)
                                ->where('table_ref', 't_checklist_pensiun')
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $this->db->where('ref_id', $id)
                    ->where('table_ref', 't_checklist_pensiun')
                    ->where('flag_active', 1)
                    ->update('t_request_ds', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            if($requestDs){
                $this->db->where('id_t_request_ds', $requestDs['id'])
                        ->where('flag_sent', 0)
                        ->update('t_cron_request_ds', [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]);
                        
                if($requestDs['id_t_nomor_surat']){
                    $this->db->where('id', $requestDs['id_t_nomor_surat'])
                            ->update('t_request_ds', [
                                'flag_active' => 0,
                                'updated_by' => $this->general_library->getId()
                            ]);
                }
            }

            $usulDs = $this->db->select('*')
                            ->from('t_usul_ds')
                            ->where('ref_id', $id)
                            ->where('table_ref', 't_checklist_pensiun')
                            ->where('flag_active', 1)
                            ->get()->result_array();

            if($usulDs){
                foreach($usulDs as $u){
                    $this->db->where('id', $u['id'])
                            ->update('t_usul_ds', [
                                'flag_active' => 0,
                                'updated_by' => $this->general_library->getId()
                            ]);

                    if($u['id_t_nomor_surat']){
                        $this->db->where('id', $u['id_t_nomor_surat'])
                                ->update('t_nomor_surat', [
                                    'flag_active' => 0,
                                    'updated_by' => $this->general_library->getId()
                                ]);
                    }
                }
            }
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }

        return $rs;
    }

    public function cronBulkDs(){
        $data = $this->db->select('a.*, b.request, b.url_image_ds, b.url_file, b.ref_id, b.table_ref, c.url_file as url_progress,
                        b.nama_kolom_flag, b.random_string, b.id as id_t_request_ds, b.id_m_jenis_ds')
                        ->from('t_cron_request_ds a')
                        ->join('t_request_ds b', 'a.id_t_request_ds = b.id')
                        ->join('t_usul_ds_detail_progress c', 'b.ref_id = c.id AND b.table_ref = "t_usul_ds_detail_progress"', 'left')
                        ->where('a.flag_active', 1)
                        ->where('a.flag_sent', 0)
                        // ->where('a.flag_send', 0)
                        // ->where('b.url_sk IS NULL')
                        ->limit(5)
                        ->get()->result_array();
        // dd($data);
        $this->db->trans_begin();

        if($data){
            foreach($data as $d){
                $request = json_decode($d['request'], true);
                if($d['url_image_ds']){
                    $request['signatureProperties']['imageBase64'] = $d['url_image_ds'];
                }
                $base64File = null;
                $urlFile = $d['url_file'];
                if(!file_exists($d['url_file']) && $d['table_ref'] == 't_usul_ds_detail_progress'){
                    $urlFile = $d['url_progress'];
                }
                copy($urlFile, $d['url_file']);

                $base64File = base64_encode(file_get_contents(base_url().$urlFile));

                $jsonRequest['file'] = null;
                $jsonRequest['file'][] = $base64File;
                // dd($base64File);

                $credential = json_decode($d['credential'], true);

                $jsonRequest['signatureProperties'] = null;
                $jsonRequest['signatureProperties'][] = $request['signatureProperties'];
                
                $jsonRequest['nik'] = $credential['nik'];
                $jsonRequest['passphrase'] = $credential['passphrase'];
                // dd(json_encode($jsonRequest));
                
                $ws = $this->ttelib->signPdfNikPass($jsonRequest);
                $response = json_decode($ws, true);
                if($response == null || !isset($response['file'])){ // jika gagal
                    $this->db->where('id', $d['id'])
                            ->update('t_cron_request_ds', [
                                'flag_send' => 1,
                                'date_send' => date('Y-m-d H:i:s'),
                                'response' => $ws
                            ]);    
                } else {
                    $this->db->where('id', $d['ref_id'])
                            ->update($d['table_ref'], [
                                $d['nama_kolom_flag'] => 1
                            ]);

                    $this->db->insert('t_file_ds', [
                        'random_string' => $d['random_string'],
                        'url' => $d['url_file'],
                        'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0
                    ]);

                    $this->db->where('id', $d['id'])
                            ->update('t_cron_request_ds', [
                                'flag_send' => 1,
                                'date_send' => date('Y-m-d H:i:s'),
                                'flag_sent' => 1,
                                'date_sent' => date('Y-m-d H:i:s'),
                                'response' => $ws
                            ]);

                    base64ToFile($response['file'][0], $d['url_file']); //simpan ke file

                    if($d['id_m_jenis_ds'] == 4){
                        $this->kepegawaian->tteCuti($d['id_t_request_ds']);
                    }

                    if($d['table_ref'] == 't_usul_ds_detail'){
                        $this->db->insert('t_cron_async', [
                            'url' => 'api/C_Api/proceedNextVerifikatorUsulDs',
                            'ref_id' => $d['id'],
                            'table_ref' => 't_usul_ds_detail',
                            'param' => json_encode([
                                            'id' => $d['ref_id'],
                                            'flag_progress' => 0,
                                            'selectedData' => $d
                                        ]),
                            'created_by' => $this->general_library->getId()
                        ]);                      
                        // $this->proceedNextVerifikatorUsulDs($d['ref_id'], 0, null);
                    } else if($d['table_ref'] == 't_usul_ds_detail_progress'){
                        $this->db->insert('t_cron_async', [
                            'url' => 'api/C_Api/proceedNextVerifikatorUsulDs',
                            'ref_id' => $d['id'],
                            'table_ref' => 't_usul_ds_detail_progress',
                            'param' => json_encode([
                                            'id' => $d['ref_id'],
                                            'flag_progress' => 1,
                                            'selectedData' => $d
                                        ]),
                            'created_by' => $this->general_library->getId()
                        ]);                      
                        // $this->proceedNextVerifikatorUsulDs($d['ref_id'], 1, $d);
                    }
                }
            }
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function sendNotif(){
        $data = $this->input->post();
        $this->db->insert('t_cron_wa', [
            'type' => 'text',
            'sendTo' => convertPhoneNumber($data['nohp']),
            'message' => $data['pesan'],
            'jenis_layanan' => 'Administrasi Kepegawaian - Pensiun',
            'created_by' => $this->general_library->getId()
        ]);
    }

    public function removeUploadedFileDs($filename){
        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');

        if(!file_exists("arsipusulds/".$tahun) && !is_dir("arsipusulds/".$tahun)) {
            mkdir("arsipusulds/".$tahun, 0777, TRUE);       
        }

        if(!file_exists("arsipusulds/".$tahun."/".$bulan) && !is_dir("arsipusulds/".$tahun."/".$bulan)) {
            mkdir("arsipusulds/".$tahun."/".$bulan, 0777, TRUE);       
        }

        if($filename == "0"){
            unlink("arsipusulds/".$tahun."/".$bulan."/".$filename);
        } else {
    		$uploadedFile = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());
            if($uploadedFile){
                foreach($uploadedFile as $uf){
                    if(file_exists("arsipusulds/".$tahun."/".$bulan."/".$uf['name'])){
                        unlink("arsipusulds/".$tahun."/".$bulan."/".$uf['name']);
                    }
                }
            }
        }
    }

    public function uploadFileUsulDs(){
        $res['code'] = 0;
        $res['message'] = "";
        $res['data'] = "";

        $file = $_FILES['file'];
		$uploadedFile = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());

        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');
        
        if(!file_exists("arsipusulds/".$tahun) && !is_dir("arsipusulds/".$tahun)) {
            mkdir("arsipusulds/".$tahun, 0777, TRUE);       
        }

        if(!file_exists("arsipusulds/".$tahun."/".$bulan) && !is_dir("arsipusulds/".$tahun."/".$bulan)) {
            mkdir("arsipusulds/".$tahun."/".$bulan, 0777, TRUE);       
        }

        if($file){
            $newFileName = generateRandomString()."_".str_replace(' ', '_', $_FILES['file']['name']);
            $config['upload_path'] = 'arsipusulds/'.$tahun.'/'.$bulan.'/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $newFileName;
            $this->load->library('upload', $config);

            // $newFileName = generateRandomString()."_".str_replace(' ', '_', $file['name']);
            $file['name'] = $newFileName;

            $_FILES['file_usul_ds']['name'] = $newFileName;
            $_FILES['file_usul_ds']['type'] = $file['type'];
            $_FILES['file_usul_ds']['tmp_name'] = $file['tmp_name'];
            $_FILES['file_usul_ds']['error'] = $file['error'];
            $_FILES['file_usul_ds']['size'] = $file['size'];

            if(!file_exists("arsipusulds/".$tahun."/".$bulan."/".$newFileName)){
                if(!$this->upload->do_upload('file_usul_ds')){ // jika gagal upload
                    $res['code'] = 1;
                    $res['message'] = $this->upload->display_errors();
                } else { // jika berhasil upload
                    $uploadedFile[$newFileName] = $file;
                    $this->session->set_userdata('uploaded_file_usul_ds_'.$this->general_library->getId(), $uploadedFile);
                    $res['message'] = "Berhasil";
                }
            }
        }

        $res['data'] = $uploadedFile ? count($uploadedFile) : 0;
        return $res;
    }

    public function getPegawaiByIdJabatan($idJabatan){
        $pegawai = $this->db->select('a.*, b.id as id_m_user, c.nama_jabatan')
                            ->from('db_pegawai.pegawai a')
                            ->join('m_user b', 'a.nipbaru_Ws = b.username')
                            ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                            // ->where('c.kepalaskpd', 1)
                            ->where('a.jabatan', $idJabatan)
                            ->where('b.flag_active', 1)
                            ->where('a.id_m_status_pegawai', 1)
                            ->get()->row_array();
        // dd($pegawai);
        // if(!$pegawai){
            $plt = $this->db->select('*')
                            ->from('t_plt_plh')
                            ->where('id_jabatan', $idJabatan)
                            ->where('tanggal_mulai <= ', date('Y-m-d'))
                            ->where('tanggal_akhir >= ', date('Y-m-d'))
                            ->where('flag_active', 1)
                            ->get()->row_array();

            if($plt){
                $pegawai = $this->db->select('a.*, b.id as id_m_user, c.nama_jabatan')
                                ->from('db_pegawai.pegawai a')
                                ->join('m_user b', 'a.nipbaru_Ws = b.username')
                                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                                // ->where('c.kepalaskpd', 1)
                                ->where('b.id', $plt['id_m_user'])
                                ->where('b.flag_active', 1)
                                ->where('a.id_m_status_pegawai', 1)
                                ->get()->row_array();
                if($pegawai){
                    $pegawai['nama_jabatan'] = $plt['jenis'].". ".$pegawai['nama_jabatan'];
                }
            }
        // }

        return $pegawai;
    }

    public function submitUploadFileUsulDs($dataInput, $flagIntegrasi = 0){
        $result = [
            'code' => 0,
            'message' => ''
        ];

        $this->db->trans_begin();

        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');

		$uploadedFile = $this->session->userdata('uploaded_file_usul_ds_'.$this->general_library->getId());
        if(!$uploadedFile && $flagIntegrasi == 0){
            $result['code'] = 1;
            $result['message'] = "Belum ada file yang dipilih";
        } else {
            $userInputer = $this->general_library->getId();
            if(isset($dataInput['id_m_user'])){
                $userInputer = $dataInput['id_m_user'];
            }

            $createdBy = $userInputer;
            if(isset($dataInput['table_ref']) && $dataInput['table_ref'] == 't_pengajuan_cuti'){
                $createdBy = 101; // jika cuti, pak cliff jadi created by untuk usul DS
            }

            $pegawai = $this->kinerja->getAtasanPegawai(0, $createdBy, 1);
            
            // $kepalabkpsdm = $this->getPegawaiByIdJabatan(ID_JABATAN_KABAN_BKPSDM);

            $sekbkpsdm = $this->getPegawaiByIdJabatan(ID_JABATAN_SEKBAN_BKPSDM);

            $kabidMutasiBkpsdm = $this->getPegawaiByIdJabatan('4018000JS10');

            $batchId = generateRandomString();
            $data['id_m_user'] = $userInputer;
            $data['created_by'] = $createdBy; // pak cliff
            $data['keterangan'] = $dataInput['keterangan'];
            $data['ds_code'] = $dataInput['ds_code'];
            $data['page'] = $dataInput['page'];
            $data['table_ref'] = isset($dataInput['table_ref']) ? $dataInput['table_ref'] : null;
            $data['ref_id'] = isset($dataInput['ref_id']) ? $dataInput['ref_id'] : null;
            $data['meta_view'] = isset($dataInput['meta_view']) ? $dataInput['meta_view'] : null;
            $data['nama_kolom_ds'] = isset($dataInput['nama_kolom_ds']) ? $dataInput['nama_kolom_ds'] : null;
            $data['url_ds'] = isset($dataInput['url_ds']) ? $dataInput['url_ds'] : null;
            $data['batch_id'] = $batchId;
            $data['id_m_jenis_layanan'] = $dataInput['id_m_jenis_layanan'];
            $data['status'] = "Menunggu DS oleh ".$pegawai['atasan']['nama_jabatan'];

            if($data['table_ref'] == 't_pengajuan_cuti'){
                $data['status'] = "Menunggu DS oleh Kepala Bidang Mutasi dan Promosi";
            }

            if($flagIntegrasi == 1){
                $data['flag_use_nomor_surat'] = isset($dataInput['flag_use_nomor_surat']) ? $dataInput['flag_use_nomor_surat'] : 0;
            }

            $this->db->insert('t_usul_ds', $data);
            $id_t_usul_ds = $this->db->insert_id();

            if($flagIntegrasi == 1){
                $uploadedFile = $dataInput['files'];
            }

            $usulDetail = null;
            $i = 0;
            foreach($uploadedFile as $uf){
                $usulDetail[$i]['id_t_usul_ds'] = $id_t_usul_ds;
                $usulDetail[$i]['url'] = "arsipusulds/".$tahun."/".$bulan."/".$uf['name'];
                $usulDetail[$i]['created_by'] = $userInputer;
                $usulDetail[$i]['filename'] = $uf['name'];
                $usulDetail[$i]['batch_id_detail'] = generateRandomString();

                if($flagIntegrasi == 1){
                    copy($uf['url'], $usulDetail[$i]['url']);
                }

                $this->db->insert('t_usul_ds_detail', $usulDetail[$i]);
                $id_t_usul_ds_detail = $this->db->insert_id();

                $progress[1]['urutan'] = 1;
                $progress[1]['id_t_usul_ds_detail'] = $id_t_usul_ds_detail;
                $progress[1]['id_m_user_verif'] = $pegawai['atasan']['id'];
                $progress[1]['nama_jabatan'] = $pegawai['atasan']['nama_jabatan'];
                $progress[1]['flag_ds_now'] = 1;

                if($data['table_ref'] == 't_pengajuan_cuti'){
                    $progress[1]['nama_jabatan'] = $kabidMutasiBkpsdm ? $kabidMutasiBkpsdm['nama_jabatan'] : 'Kepala Bidang Mutasi dan Promosi';
                    $progress[1]['id_m_user_verif'] = $kabidMutasiBkpsdm['id_m_user'];
                }
                
                $progress[2]['urutan'] = 2;
                $progress[2]['id_t_usul_ds_detail'] = $id_t_usul_ds_detail;
                $progress[2]['id_m_user_verif'] = $sekbkpsdm['id_m_user'];
                $progress[2]['nama_jabatan'] = $sekbkpsdm['nama_jabatan'];
                $progress[2]['flag_ds_now'] = 0;

                $this->db->insert_batch('t_usul_ds_detail_progress', $progress);

                $i++;
            }
        }
        // else {
        //     $result['code'] = 1;
        //     $result['message'] = "Terjadi Kesalahan";
        // }

        if($this->db->trans_status() == FALSE && $result['code'] != 0){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $result;
    }

    public function loadDetailUsulDsFile($id_t_usul_ds_detail){
        $res['code'] = 0;
        $res['message'] = "";
        $res['result'] = null;

        $tRequestDs = $this->db->select('*')
                            ->from('t_request_ds')
                            ->where('ref_id', $id_t_usul_ds_detail)
                            ->where('table_ref', 't_usul_ds_detail')
                            ->where('flag_active', 1)
                            ->get()->row_array();

        if($tRequestDs){
            $res['code'] = 1;
            $res['message'] = "Data tidak dapat ditolak karena sudah masuk dalam antrian untuk ditandatangani secara digital oleh Kepala BKPSDM.";
        } else {
            $res['result'] = $this->db->select('a.*, b.keterangan as keterangan_t_usul_ds, trim(c.nama) as user_inputer, d.url_file')
                                    ->from('t_usul_ds_detail a')
                                    ->join('t_usul_ds b', 'a.id_t_usul_ds = b.id')
                                    ->join('m_user c', 'a.created_by = c.id')
                                    ->join('t_usul_ds_detail_progress d', 'a.id = d.id_t_usul_ds_detail')
                                    ->where('c.flag_active', 1)
                                    ->where('a.flag_active', 1)
                                    ->where('a.id', $id_t_usul_ds_detail)
                                    ->get()->row_array();
            if($res['result']){
                if($res['result']['flag_status'] != 0){
                    $res['code'] = 1;
                    $res['message'] = "Data sudah dilakukan verifikasi dan tidak dapat diverifikasi lagi untuk saat ini.";    
                }
            } else {
                $res['code'] = 1;
                $res['message'] = "Data tidak ditemukan.";
            }
        }

        return $res;
    }

    public function verifUsulDsDetail($id, $flag_verif, $id_t_usul_ds_progress){
        $res['code'] = 0;
        $res['message'] = "";
        $res['result'] = null;

        $tRequestDs = $this->db->select('*')
                            ->from('t_request_ds')
                            ->where('ref_id', $id)
                            ->where('table_ref', 't_usul_ds_detail')
                            ->where('flag_active', 1)
                            ->get()->row_array();

        if($tRequestDs){
            $res['code'] = 1;
            $res['message'] = "Data tidak dapat ditolak karena sudah masuk dalam antrian untuk ditandatangani secara digital oleh Kepala BKPSDM.";
        } else {
            $dsDetail = $this->db->select('a.*, b.keterangan as keterangan_t_usul_ds, trim(c.nama) as user_inputer, b.table_ref, b.id as id_t_usul_ds')
                                    ->from('t_usul_ds_detail a')
                                    ->join('t_usul_ds b', 'a.id_t_usul_ds = b.id')
                                    ->join('m_user c', 'a.created_by = c.id')
                                    ->where('c.flag_active', 1)
                                    ->where('a.flag_active', 1)
                                    ->where('a.id', $id)
                                    ->get()->row_array();
            if($dsDetail){
                if($dsDetail['flag_status'] != 0){
                    $res['code'] = 1;
                    $res['message'] = "Data sudah dilakukan verifikasi dan tidak dapat diverifikasi lagi untuk saat ini.";    
                } else {
                    $dsProgress = $this->db->select('*')
                                        ->from('t_usul_ds_detail_progress')
                                        ->where('id', $id_t_usul_ds_progress)
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                                        
                    $this->db->where('id', $dsDetail['id'])
                        ->update('t_usul_ds_detail', [
                            'flag_done' => 2,
                            'keterangan' => 'Ditolak oleh '.$dsProgress['nama_jabatan'].' '.formatDateNamaBulanWT(date('Y-m-d H:i:s')),
                            // 'keterangan' => $this->input->post('keterangan_verifikasi'),
                    ]);

                    $this->db->where('id', $dsDetail['id'])
                            ->update('t_usul_ds_detail', [
                                'flag_status' => 2,
                                'keterangan' => 'Ditolak oleh '.$dsProgress['nama_jabatan'].' '.formatDateNamaBulanWT(date('Y-m-d H:i:s')),
                                // 'keterangan' => $this->input->post('keterangan_verifikasi'),
                            ]);

                    $this->db->where('id', $dsProgress['id'])
                            ->update('t_usul_ds_detail_progress', [
                                'flag_verif' => 2,
                                'keterangan' => $this->input->post('keterangan_verifikasi'),
                            ]);

                    if($dsDetail['table_ref']){
                        $this->db->where('id', $dsDetail['id_t_usul_ds'])
                                ->update('t_usul_ds', [
                                    'flag_done' => 2,
                                    'status' => 'Ditolak oleh '.$dsProgress['nama_jabatan'].' '.formatDateNamaBulanWT(date('Y-m-d H:i:s'))." (".$this->input->post('keterangan_verifikasi').")"
                                ]);
                    }
                }
            } else {
                $res['code'] = 1;
                $res['message'] = "Data tidak ditemukan.";
            }
        }

        return $res;
    }

    public function deleteUsulDs($id){
        $usulDs = $this->db->select('a.id as id_t_usul_ds, b.id as id_t_usul_ds_detail')
                        ->from('t_usul_ds a')
                        ->join('t_usul_ds_detail b', 'a.id = b.id_t_usul_ds')
                        ->join('t_usul_ds_detail_progress c', 'b.id = c.id_t_usul_ds_detail')
                        ->where('a.id', $id)
                        ->group_by('a.id')
                        ->get()->row_array();

        if($usulDs){
            $this->db->where('id', $id)
                    ->update('t_usul_ds', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id_t_usul_ds', $id)
                    ->update('t_usul_ds_detail', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id_t_usul_ds_detail', $usulDs['id_t_usul_ds_detail'])
                    ->update('t_usul_ds_detail_progress', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);
        }
    }

    public function searchVerifUsulDs(){
        $data = $this->input->post();
        
        $result = null;

        $this->db->select('a.keterangan, d.nama as user_inputer, c.created_date, b.filename, b.url, c.id, c.url_file,
                e.nama_layanan, a.id_m_jenis_layanan, b.id as id_t_usul_ds_detail, a.flag_use_nomor_surat, a.id_t_nomor_surat')
                ->from('t_usul_ds a')
                ->join('t_usul_ds_detail b', 'a.id = b.id_t_usul_ds')
                ->join('t_usul_ds_detail_progress c', 'b.id = c.id_t_usul_ds_detail')
                ->join('m_user d', 'a.created_by = d.id')
                ->join('m_jenis_layanan e', 'a.id_m_jenis_layanan = e.id')
                ->where('c.flag_active', 1)
                ->where('a.flag_active', 1)
                ->where('a.flag_done', 0)
                ->where('c.flag_verif', 0)
                ->where('b.flag_done', 0)
                ->where('b.flag_status', 0)
                ->where('YEAR(c.created_date)', $data['tahun'])
                ->where('c.id_m_user_verif', $this->general_library->getId())
                ->where('flag_ds_now', 1)
                ->where('c.flag_selected', 0)
                // ->where('(a.flag_use_nomor_surat = 1 AND (a.id_t_nomor_surat is NOT NULL OR a.id_t_nomor_surat != 0)) OR (a.flag_use_nomor_surat = 0 AND (a.id_t_nomor_surat IS NULL OR a.id_t_nomor_surat = 0))')
                ->order_by('c.created_date', 'desc');

        if($data['bulan'] != 0){
            $this->db->where('MONTH(c.created_date)', $data['bulan']);
        }

        $rs = $this->db->get()->result_array();

        if($rs){
            foreach($rs as $r){
                if($r['flag_use_nomor_surat'] == 1){
                    if($r['id_t_nomor_surat']){
                        $result[] = $r;
                    }
                } else {
                    $result[] = $r;
                }
            }
        }

        return $result;
    }

    public function proceedNextVerifikatorUsulDs($params = null){
        $res['code'] = 0;
        $res['message'] = "";

        if(!$params){
            $params = $this->input->post();
        }

        $nextVerifikator = null;
        if($params['flag_progress'] == 0){
            $nextVerifikator = $this->db->select('a.*, b.ds_code, c.urutan, c.nama_jabatan, c.id as id_t_usul_ds_detail_progress')
                                ->from('t_usul_ds_detail a')
                                ->join('t_usul_ds b', 'a.id_t_usul_ds = b.id')
                                ->join('t_usul_ds_detail_progress c', 'a.id = c.id_t_usul_ds_detail')
                                ->where('a.flag_active', 1)
                                ->where('a.id', $params['id'])
                                ->where('c.flag_verif', 0)
                                ->order_by('c.urutan', 'asc')
                                ->group_by('c.id')
                                ->get()->row_array();
        } else {
            $progress = $this->db->select('*')
                                ->from('t_usul_ds_detail_progress')
                                ->where('id', $params['id'])
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $this->db->where('id', $progress['id'])
                    ->update('t_usul_ds_detail_progress', [
                        'date_verif' => date('Y-m-d'),
                        'url_file' => $params['selectedData']['url_file'],
                        'keterangan' => "Telah ditandatangani oleh ".$progress['nama_jabatan'].' pada '.formatDateNamaBulanWT(date('Y-m-d H:i:s'))
                    ]);

            $nextVerifikator = $this->db->select('a.*, b.ds_code, c.urutan, c.nama_jabatan, c.id as id_t_usul_ds_detail_progress')
                                ->from('t_usul_ds_detail a')
                                ->join('t_usul_ds b', 'a.id_t_usul_ds = b.id')
                                ->join('t_usul_ds_detail_progress c', 'a.id = c.id_t_usul_ds_detail')
                                ->where('a.flag_active', 1)
                                ->where('a.id', $progress['id_t_usul_ds_detail'])
                                ->where('c.flag_verif', 0)
                                ->order_by('c.urutan', 'asc')
                                ->group_by('c.id')
                                ->get()->row_array();
        }
        // dd('asdsad');
        // jika masih ada urutan selanjutnya, ubah flag_ds_now jadi 1
        // dd($nextVerifikator);

        $this->db->trans_begin();
        if($nextVerifikator){
            $currVerifikator = $this->db->select('a.*, b.url_done')
                                    ->from('t_usul_ds_detail_progress a')
                                    ->join('t_usul_ds_detail b', 'a.id_t_usul_ds_detail = b.id')
                                    ->where('a.id_t_usul_ds_detail', $nextVerifikator['id'])
                                    ->where('urutan', intval($nextVerifikator['urutan']-1))
                                    ->where('a.flag_active', 1)
                                    ->get()->row_array();

            $this->db->where('id', $nextVerifikator['id_t_usul_ds_detail_progress'])
                    ->update('t_usul_ds_detail_progress', [
                        'flag_ds_now' => 1,
                        'url_file' => $currVerifikator['url_file'],
                        'updated_by' => $this->general_library->getId()
                    ]);

            // copy($params['selectedData']['url_file'], $currVerifikator['url_file']);
            
            // update status t_usul_ds_detail
            $detail['keterangan'] = 'Menunggu DS oleh '.$nextVerifikator['nama_jabatan'];
            $detail['updated_by'] = $this->general_library->getId();
            
            //jika hasil dari cron dan adalah progress, update url_done di detail ambil dari data yang sudah di DS
            if($params['flag_progress'] == 1 && $currVerifikator['url_done']){
                $detail['url_done'] = $params['selectedData']['url_file'];
                copy($params['selectedData']['url_file'], $currVerifikator['url_done']);
            }

            $this->db->where('id', $nextVerifikator['id'])
                    ->update('t_usul_ds_detail', $detail);

        } else { // jika tidak ada, insert di t_request_ds untuk di DS kaban
            $this->db->select('a.*, b.ds_code, c.nama_jabatan, d.username as nip, b.id as id_t_usul_ds, c.url_file, b.id_t_nomor_surat,
                            b.keterangan as keterangan_ds, b.id_m_jenis_layanan, b.page, b.ref_id, b.table_ref, b.nama_kolom_ds')
                        ->from('t_usul_ds_detail a')
                        ->join('t_usul_ds b', 'a.id_t_usul_ds = b.id')
                        ->join('t_usul_ds_detail_progress c', 'a.id = c.id_t_usul_ds_detail')
                        ->join('m_user d', 'b.created_by = d.id')
                        ->where('a.flag_active', 1)
                        // ->where('a.id', $params['id'])
                        ->where('c.flag_verif', 1)
                        ->order_by('c.urutan', 'desc')
                        ->limit(1)
                        ->group_by('a.id');

            if($params['flag_progress'] == 1){
                $this->db->where('c.id', $params['id']);
            } else {
                $this->db->where('a.id', $params['id']);
            }

            $dataUsul = $this->db->get()->row_array();

            $existsReqDs = $this->db->select('a.*, b.nomor_surat')
                                    ->from('t_request_ds a')
                                    ->join('t_nomor_surat b', 'a.id_t_nomor_surat = b.id', 'left')
                                    ->where('a.table_ref', 't_usul_ds_detail')
                                    ->where('a.ref_id', $dataUsul['id'])
                                    ->where('a.flag_active', 1)
                                    ->limit(1)
                                    // ->where('flag_selected', 0)
                                    ->get()->row_array();

            if(!$existsReqDs){ // jika tidak ada, input di t_request_ds
                $this->db->where('id', $dataUsul['id'])
                                    ->update('t_usul_ds_detail', [
                                        'keterangan' => 'Menunggu DS oleh Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado',
                                        'updated_by' => $this->general_library->getId()
                                    ]);

                $randomString = generateRandomString(30, 1, 't_file_ds'); 
                $qrTemplate = $this->general_library->createQrTte(null, $randomString);
                $request_ws = [
                    'signatureProperties' => [
                        "tampilan" => "VISIBLE",
                        "imageBase64" => $qrTemplate['data']['qrBase64'],
                        "tag" => $dataUsul['ds_code'],
                        "width" => 150,
                        "height" => 150,
                        "page" => $dataUsul['page'],
                        "reason" => "Dokumen ini telah ditandatangani secara elektronik oleh Kepala BKPSDM Kota Manado melalui apikasi Siladen."
                    ],
                    // 'file' => convertToBase64(($pathHukdis))
                ];

                $urlFile = $dataUsul['url_done'];
                if($params['flag_progress'] == 1){
                    $urlFile = $params['selectedData']['url_file'];
                }

                $requestDs = [
                    'created_by' => $this->general_library->getId(),
                    'id_t_nomor_surat' => $dataUsul['id_t_nomor_surat'],
                    'ref_id' => $dataUsul['id'],
                    'table_ref' => 't_usul_ds_detail',
                    'id_m_jenis_ds' => 5,
                    'random_string' => $randomString,
                    'request' => json_encode($request_ws),
                    'url_file' => $urlFile,
                    'url_image_ds' => $qrTemplate['data']['qrBase64'],
                    'nama_kolom_flag' => 'flag_done',
                    'nip' => $dataUsul['nip'],
                    'id_m_jenis_layanan' => $dataUsul['id_m_jenis_layanan'],
                    'nama_jenis_ds' => $dataUsul['keterangan_ds']
                ];
                $this->db->insert('t_request_ds', $requestDs);
            } else { // jika sudah ada, berarti kaban sudah DS
                $bulan = getNamaBulan(date('m'));
                $tahun = date('Y');
                $newFileName = "SIGNED_".$dataUsul['filename'];
                $newFullPath = "arsipusulds/".$tahun."/".$bulan."/".$newFileName;

                $this->db->where('id', $dataUsul['id'])
                        ->update('t_usul_ds_detail', [
                            'url_done' => $newFullPath,
                            'keterangan' => "Telah ditandatangani secara elektronik oleh Kepala BKPSDM Kota Manado pada ".formatDateNamaBulanWT(date('Y-m-d H:i:s')). " melalui aplikasi Siladen",
                            'flag_status' => 1,
                            'updated_by' => $this->general_library->getId()
                        ]);

                if($dataUsul['ref_id']){ // jika usul DS integrasi
                    $this->db->where('id', $dataUsul['ref_id'])
                            ->update($dataUsul['table_ref'], [
                                $dataUsul['nama_kolom_ds'] => 1
                            ]);

                    if($dataUsul['table_ref'] == 't_pengajuan_cuti'){ // jika cuti, kirim SK Cuti ke pegawai ybs
                        $pegawaiYbs = $this->db->select('c.*, d.nm_cuti, a.tanggal_mulai, a.tanggal_akhir, a.lama_cuti, b.id as id_m_user,
                                            a.id_cuti, a.url_sk, a.id as id_t_pengajuan_cuti')
                                            ->from('t_pengajuan_cuti a')
                                            ->join('m_user b', 'a.id_m_user = b.id')
                                            ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                                            ->join('db_pegawai.cuti d', 'a.id_cuti = d.id_cuti')
                                            ->where('a.id', $dataUsul['ref_id'])
                                            ->get()->row_array();

                        $caption = "*[SK PENGAJUAN ".strtoupper($pegawaiYbs["nm_cuti"])."]*\n\n"."Selamat ".greeting().", Yth. ".getNamaPegawaiFull($pegawaiYbs).",\nBerikut kami lampirkan SK ".$pegawaiYbs["nm_cuti"]." Anda. Terima kasih.".FOOTER_MESSAGE_CUTI;
                        $cronWa = [
                            'sendTo' => convertPhoneNumber($pegawaiYbs['handphone']),
                            'message' => $caption,
                            'filename' => "CUTI_".strtoupper($pegawaiYbs["nipbaru_ws"]).'_'.$pegawaiYbs['tanggal_mulai'].'.pdf',
                            'fileurl' => $newFullPath,
                            'type' => 'document',
                            'jenis_layanan' => 'Cuti'
                        ];
                        $this->db->insert('t_cron_wa', $cronWa); // insert cron WA untuk krim file

                        $explodeFileName = explode("/", $newFullPath);
                        $filePathCuti = 'arsipcuti/'.$explodeFileName[count($explodeFileName)-1];

                        if(isset($params['selectedData']['url_file'])){
                            copy($params['selectedData']['url_file'], $filePathCuti);

                            $this->db->where('id', $pegawaiYbs['id_t_pengajuan_cuti'])
                                    ->update('t_pengajuan_cuti', [
                                        'url_sk' => $filePathCuti
                                    ]);
                        }
                        
                        // insert di pegcuti
                        $this->db->insert('db_pegawai.pegcuti', [
                            'id_pegawai' => $pegawaiYbs['id_peg'],
                            'jeniscuti' => $pegawaiYbs['id_cuti'],
                            'lamacuti' => $pegawaiYbs['lama_cuti'],
                            'tglmulai' => $pegawaiYbs['tanggal_mulai'],
                            'tglselesai' => $pegawaiYbs['tanggal_akhir'],
                            'nosttpp' => $existsReqDs['nomor_surat'],
                            'tglsttpp' => date('Y-m-d'),
                            'gambarsk' => $newFileName,
                            'status' => 2
                        ]);

                        //simpan di dokumen pendukung agar tersinkron dengan rekap absen
                        $dokumen_pendukung = null;
                        $hariKerja = countHariKerjaDateToDate($pegawaiYbs['tanggal_mulai'], $pegawaiYbs['tanggal_akhir']);
                        if($hariKerja){
                            $i = 0;
                            $randomString = generateRandomString();
                            foreach($hariKerja[3] as $h){
                                $explode = explode("-", $h);
                                $dokumen_pendukung[$i] = [
                                    'id_m_user' => $pegawaiYbs['id_m_user'],
                                    'id_m_jenis_disiplin_kerja' => 17,
                                    'tanggal' => $explode[2],
                                    'bulan' => $explode[1],
                                    'tahun' => $explode[0],
                                    'keterangan' => 'Cuti',
                                    'pengurangan' => 0,
                                    'status' => 2,
                                    'keterangan_verif' => '',
                                    'tanggal_verif' => date('Y-m-d H:i:s'),
                                    'id_m_user_verif' => 1,
                                    'flag_outside' => 1,
                                    'random_string' => $randomString,
                                    'url_outside' => $filePathCuti,
                                    'created_by' => 0
                                ];
                                $i++;
                            }
                        }
                        if($dokumen_pendukung){
                            $this->db->insert_batch('t_dokumen_pendukung', $dokumen_pendukung);
                        }
                    }
                }

                // update t_file_ds untuk scan QR
                $this->db->where('random_string', $params['selectedData']['random_string'])
                        ->where('flag_active', 1)
                        ->update('t_file_ds', [
                            'url' => $newFullPath
                        ]);

                $tUsulDs = $this->db->select('*')
                                ->from('t_usul_ds_detail')
                                ->where('flag_active', 1)
                                ->where('id_t_usul_ds', $dataUsul['id_t_usul_ds'])
                                ->where('flag_done', 0)
                                ->get()->row_array();

                if(!$tUsulDs){ // jika di t_usul_ds flag_done sudah 1 semua, update flag_done di t_usul_ds
                    $this->db->where('id', $dataUsul['id_t_usul_ds'])
                            ->update('t_usul_ds', [
                                'flag_done' => 1,
                                'status' => "Selesai",
                            ]);
                }

                // simpan newfullpath ke dalam t_usul_ds_detail beserta keterangannya

                copy($params['selectedData']['url_file'], $newFullPath);
            }
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = "Terjadi Kesalahan";
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function dsBulk($params){
        $res['code'] = 0;
        $res['message'] = null;
        $res['data'] = null;

        $this->db->trans_begin();

        $list_data = $this->db->select('a.*, b.batch_id_detail, b.url, b.filename, b.id as id_t_usul_ds_detail, b.url_done,
                        c.id_m_jenis_layanan, c.keterangan as keterangan_ds')
                        ->from('t_usul_ds_detail_progress a')
                        ->join('t_usul_ds_detail b', 'a.id_t_usul_ds_detail = b.id')
                        ->join('t_usul_ds c', 'b.id_t_usul_ds = c.id')
                        ->where_in('a.id', $params['list_checked'])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();

        // jika urutan = 2, ambil url file dari urutan sebelumnya agar DS menjadi 2 orang

        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');

        if($list_data){
            $selected = $list_data[0];

            $request['signatureProperties'] = [
                'tampilan' => 'INVISIBLE',
                'reason' => 'Dokumen ini telah ditandatangani secara elektronik oleh '.$selected['nama_jabatan']." melalui apikasi Siladen."
            ];

            $selectedUrl = $selected['url_done'];
            if(!file_exists($selectedUrl)){
                $selectedUrl = $selected['url'];    
            }

            $namaFolder = "arsipusulds";
            $bulan = getNamaBulan(date('m'));
            $tahun = date('Y');
            
            if(!file_exists($namaFolder."/".$tahun) && !is_dir($namaFolder."/".$tahun)) {
                mkdir($namaFolder."/".$tahun, 0777, TRUE);       
            }

            if(!file_exists($namaFolder."/".$tahun."/".$bulan) && !is_dir($namaFolder."/".$tahun."/".$bulan)) {
                mkdir($namaFolder."/".$tahun."/".$bulan, 0777, TRUE);       
            }

            $base64File = null;
            $base64File = base64_encode(file_get_contents(base_url().$selectedUrl));
            $jsonRequest['file'] = null;
            $jsonRequest['file'][] = $base64File;
            // dd($base64File);

            $jsonRequest['signatureProperties'][] = $request['signatureProperties'];
            $jsonRequest['nik'] = $params['nik'];
            $jsonRequest['passphrase'] = $params['passphrase'];
            // dd(json_encode($jsonRequest));

            $oneData = $this->ttelib->signPdfNikPass($jsonRequest);
            $response = json_decode($oneData, true);

            // $response['file'] = 'asd'; // buka comment ini untuk testing

            if($response == null || !isset($response['file'])){ // jika gagal
                $res['code'] = 1;
                $res['message'] = $oneData;
                $res['data'] = null;
            } else { // jika berhasil
                $explFn = explode(".pdf", $selected['filename']);
                $newFileName = $explFn[0]."_signed_".$selected['id_m_user_verif'].".pdf";
                $filepath = "arsipusulds/".$tahun."/".$bulan;
                $fullpath = $filepath."/".$newFileName;
                // $fullpath = $filepath."/".$selected['filename'];

                base64ToFile($response['file'][0], $fullpath); //simpan ke file, comment ini untuk testing

                // update t_usul_ds_detail_progress
                $dateNow = date('Y-m-d H:i:s');
                $this->db->where('id', $selected['id'])
                        ->update('t_usul_ds_detail_progress', [
                            'date_verif' => $dateNow,
                            'flag_verif' => 1,
                            'flag_selected' => 1,
                            'url_file' => $fullpath,
                            'updated_by' => $this->general_library->getId(),
                            'keterangan' => 'Telah ditandatangani secara elektronik oleh '.$selected['nama_jabatan'].' pada '.formatDateNamaBulanWT($dateNow). " melalui aplikasi Siladen"
                        ]);

                $this->db->where('id', $selected['id_t_usul_ds_detail'])
                        ->update('t_usul_ds_detail', [
                            'url_done' => $fullpath,
                            'keterangan' => 'Telah ditandatangani secara elektronik oleh '.$selected['nama_jabatan'].' pada '.formatDateNamaBulanWT($dateNow). " melalui aplikasi Siladen",
                            'updated_by' => $this->general_library->getId()
                        ]);

                // $this->proceedNextVerifikatorUsulDs($selected['id_t_usul_ds_detail'], 0, $selected);
                $this->db->insert('t_cron_async', [
                    'url' => 'api/C_Api/proceedNextVerifikatorUsulDs',
                    'ref_id' => $selected['id_t_usul_ds_detail'],
                    'table_ref' => 't_usul_ds_detail',
                    'param' => json_encode([
                                    'id' => $selected['id_t_usul_ds_detail'],
                                    'flag_progress' => 0,
                                    'selectedData' => $selected
                                ]),
                    'created_by' => $this->general_library->getId()
                ]);
                // $this->proceedNextVerifikatorUsulDs([
                //     'id' => $selected['id_t_usul_ds_detail'],
                //     'flag_progress' => 0,
                //     'selectedData' => $selected
                // ]);
                
                $batchId = generateRandomString(10);
                foreach($list_data as $ld){
                    if($ld['id'] != $selected['id']){
                        $oldFileName = "arsipusulds/".$tahun."/".$bulan."/".$ld['filename'];
                        if($ld['url_done']){
                            $oldFileName = $ld['url_done'];
                        }

                        if(!file_exists($oldFileName)){
                            $oldFileName = $ld['url'];
                        }

                        $explFn = explode(".pdf", $oldFileName);
                        $new_file_name = $explFn[0].'_signed_'.$ld['id_m_user_verif'].'.pdf';
                        $newFullPath = $new_file_name;
                        
                        // dd($oldFileName.'<br>'.$newFullPath);
                        copy($oldFileName, $newFullPath); // comment ini untuk testing
                        
                        $this->db->where('id', $ld['id'])
                                ->update('t_usul_ds_detail_progress', [
                                    'flag_selected' => 1,
                                    'url_file' => $newFullPath,
                                    'updated_by' => $this->general_library->getId()
                                ]);

                        $randomString = generateRandomString(30, 1, 't_file_ds'); 

                        $requestLd['signatureProperties'] = [
                            'tampilan' => 'INVISIBLE',
                            'reason' => 'Dokumen ini telah ditandatangani secara elektronik oleh '.$ld['nama_jabatan']." melalui apikasi Siladen."
                        ];

                        $this->db->insert('t_request_ds', [
                            'created_by' => $this->general_library->getId(),
                            'id_t_nomor_surat' => 0,
                            'ref_id' => $ld['id'],
                            'table_ref' => 't_usul_ds_detail_progress',
                            'id_m_jenis_ds' => 5,
                            'random_string' => $randomString,
                            'request' => json_encode($requestLd),
                            'url_file' => $newFullPath,
                            'nama_kolom_flag' => 'flag_verif',
                            'flag_selected' => 1,
                            'id_m_jenis_layanan' => $ld['id_m_jenis_layanan'],
                            'nama_jenis_ds' => $ld['keterangan_ds'],
                        ]);
                        $id_t_request_ds = $this->db->insert_id();


                        $this->db->insert('t_cron_request_ds', [
                            'credential' => json_encode([
                                'nik' => $params['nik'],
                                'passphrase' => $params['passphrase'],
                            ]),
                            'batchId' => $batchId,
                            'request' => json_encode($requestLd),
                            'flag_send' => 0,
                            'date_send' => null,
                            'flag_sent' => 0,
                            'date_sent' => null,
                            'created_by' => $this->general_library->getId() ? $this->general_library->getId() : 0,
                            'id_t_request_ds' => $id_t_request_ds
                        ]);
                    }
                }
            }
        } else {
            $res['code'] = 1;
            $res['message'] = "List Data Tidak Ditemukan";
        }


        if($this->db->trans_status() == FALSE || $res['code'] != 0){
            $this->db->trans_rollback();
        } else {
            if($res['code'] == 0){
                $this->db->trans_commit();
            } else {
                $res['code'] = 5;
                $res['message'] = $res['message'] ? $res['message'] : 'Terjadi Kesalahan';
                $res['data'] = null;
                $this->db->trans_rollback();
            }
        }

        return $res;
    }

    public function loadRiwayatUsulDs(){
        $data = $this->input->post();

        $this->db->select('a.*, b.nama as nama_pegawai, c.nama_layanan,
                (
                    SELECT COUNT(aa.id)
                    FROM t_usul_ds_detail aa
                    WHERE aa.id_t_usul_ds = a.id
                    AND aa.flag_active = 1
                ) as jumlah_dokumen
                ')
                ->from('t_usul_ds a')
                ->join('m_user b', 'a.created_by = b.id')
                ->join('m_jenis_layanan c', 'a.id_m_jenis_layanan = c.id')
                ->where('a.flag_active', 1)
                ->order_by('a.created_date', 'desc');

        if(!$this->general_library->isProgrammer()){
            $this->db->where('b.id', $this->general_library->getId());
        }

        if(isset($data['bulan'])){
            $this->db->where('MONTH(a.created_date)', $data['bulan']);
        }

        if(isset($data['tahun'])){
            $this->db->where('YEAR(a.created_date)', $data['tahun']);
        }

        return $this->db->get()->result_array();
    }

    public function loadDetailUsulDs($id){
        $detail = null;
        $result = $this->db->select('a.*, b.nama_layanan')
                            ->from('t_usul_ds a')
                            ->join('m_jenis_layanan b', 'a.id_m_jenis_layanan = b.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();

        if($result){
            $detail = $this->db->select('a.id, a.url, a.url_done, a.flag_done, a.flag_status, a.keterangan, a.filename')
                            ->from('t_usul_ds_detail a')
                            ->where('a.id_t_usul_ds', $result['id'])
                            ->where('a.flag_active', 1)
                            ->order_by('a.id')
                            ->group_by('a.id')
                            ->get()->result_array();

            $result['detail'] = $detail;
        }

        return $result;
    }

    public function loadProgressUsulDs($id){
        return $this->db->select('a.*, b.filename')
                        ->from('t_usul_ds_detail_progress a')
                        ->join('t_usul_ds_detail b', 'a.id_t_usul_ds_detail = b.id')
                        ->where('a.id_t_usul_ds_detail', $id)
                        ->where('a.flag_active', 1)
                        ->order_by('a.urutan')
                        ->get()->result_array();
    }

    public function ajukanKembaliUsulDs($id){
        $res['code'] = 0;
        $res['message'] = "";
        
        $data = $this->db->select('a.*, b.id as id_t_usul_ds_detail, c.nama_jabatan, c.id as id_t_usul_ds_detail_progress')
                        ->from('t_usul_ds a')
                        ->join('t_usul_ds_detail b', 'a.id = b.id_t_usul_ds')
                        ->join('t_usul_ds_detail_progress c', 'b.id = c.id_t_usul_ds_detail AND urutan = 1')
                        ->group_by('a.id')
                        ->where('a.id', $id)
                        ->get()->row_array();

        $this->db->trans_begin();
        
            $this->db->where('id', $data['id'])
                ->update('t_usul_ds', [
                    'flag_done' => 0,
                    'status' => "Menunggu Digital Signature oleh ".$data['nama_jabatan'],
                    'updated_by' => $this->general_library->getId()
                ]);

            $this->db->where('id', $data['id_t_usul_ds_detail'])
                    ->update('t_usul_ds_detail', [
                        'flag_done' => 0,
                        'flag_status' => 0,
                        'keterangan' => "Menunggu Digital Signature oleh ".$data['nama_jabatan'],
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id_t_usul_ds_detail', $data['id_t_usul_ds_detail'])
                    ->update('t_usul_ds_detail_progress', [
                        'date_verif' => null,
                        'flag_verif' => 0,
                        'flag_selected' => 0,
                        'keterangan' => null,
                        'url_file' => null,
                        'flag_ds_now' => 0,
                        'updated_by' => $this->general_library->getId()
                    ]);

            $this->db->where('id', $data['id_t_usul_ds_detail_progress'])
                    ->update('t_usul_ds_detail_progress', [
                        'flag_ds_now' => 1,
                        'updated_by' => $this->general_library->getId()
                    ]);
                

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = "Terjadi Kesalahan";
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    public function getListUnitKerjaBerjenjang(){
        $result = null;

        $id_unitkerja = $this->general_library->getUnitKerjaPegawai();
        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->order_by('nm_unitkerja')
                            ->get()->result_array();

        foreach($unitkerja as $u){
            if($id_unitkerja == 3010000){ //jika diknas, ambil sekolah2
                if($u['id_unitkeraj'] == 3010000 ||
                in_array($u['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){
                    $result[] = $u;
                }
            } else {
                if($u['id_unitkerja'] = $id_unitkerja){
                    $result[] = $u;
                    break;
                }
            }
        }
        return $result;
    }

    public function getListPegawaiSuratTugasEvent($unitkerja){
        $listUnitKerja = null;
        foreach($unitkerja as $u){
            $listUnitKerja[] = $u['id_unitkerja'];
        }

        return $this->db->select('a.*, b.nama_jabatan, c.nm_pangkat, d.id as id_m_user')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                        ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                        ->join('m_user d', 'a.nipbaru_ws = d.username')
                        ->where_in('a.skpd', $listUnitKerja)
                        ->order_by('b.eselon', 'asc')
                        // ->order_by('c.id_pangkat', 'desc')
                        ->order_by('a.nama', 'asc')
                        ->where('a.id_m_status_pegawai', 1)
                        ->where('d.flag_active', 1)
                        ->get()->result_array();
    }

    public function uploadFileSuratTugasEvent(){
        $res['code'] = 0;
        $res['message'] = "";
        $res['data'] = "";

        $file = $_FILES['file'];
		$uploadedFile = $this->session->userdata('upload_surat_tugas_event_'.$this->general_library->getId());

        $namaFolder = "arsipsurattugasevent";
        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');
        
        if(!file_exists($namaFolder."/".$tahun) && !is_dir($namaFolder."/".$tahun)) {
            mkdir($namaFolder."/".$tahun, 0777, TRUE);       
        }

        if(!file_exists($namaFolder."/".$tahun."/".$bulan) && !is_dir($namaFolder."/".$tahun."/".$bulan)) {
            mkdir($namaFolder."/".$tahun."/".$bulan, 0777, TRUE);       
        }

        if($file){
            $newFileName = generateRandomString()."_".str_replace(' ', '_', $_FILES['file']['name']);
            $config['upload_path'] = $namaFolder.'/'.$tahun.'/'.$bulan.'/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $newFileName;
            $this->load->library('upload', $config);

            // $newFileName = generateRandomString()."_".str_replace(' ', '_', $file['name']);
            $file['name'] = $newFileName;

            $_FILES['file_usul_ds']['name'] = $newFileName;
            $_FILES['file_usul_ds']['type'] = $file['type'];
            $_FILES['file_usul_ds']['tmp_name'] = $file['tmp_name'];
            $_FILES['file_usul_ds']['error'] = $file['error'];
            $_FILES['file_usul_ds']['size'] = $file['size'];

            if(!file_exists($namaFolder."/".$tahun."/".$bulan."/".$newFileName)){
                if(!$this->upload->do_upload('file_usul_ds')){ // jika gagal upload
                    $res['code'] = 1;
                    $res['message'] = $this->upload->display_errors();
                } else { // jika berhasil upload
                    $uploadedFile[$newFileName] = $file;
                    $this->session->set_userdata('upload_surat_tugas_event_'.$this->general_library->getId(), $uploadedFile);
                    $res['message'] = "Berhasil";
                }
            }
        }

        $res['data'] = $uploadedFile ? count($uploadedFile) : 0;
        return $res;
    }

    public function removeuploadSuratTugasEvent($filename){
        $namaFolder = "arsipsurattugasevent";
        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');

        if(!file_exists($namaFolder."/".$tahun) && !is_dir($namaFolder."/".$tahun)) {
            mkdir($namaFolder."/".$tahun, 0777, TRUE);       
        }

        if(!file_exists($namaFolder."/".$tahun."/".$bulan) && !is_dir($namaFolder."/".$tahun."/".$bulan)) {
            mkdir($namaFolder."/".$tahun."/".$bulan, 0777, TRUE);       
        }

        if($filename == "0"){
            unlink($namaFolder."/".$tahun."/".$bulan."/".$filename);
        } else {
    		$uploadedFile = $this->session->userdata('upload_surat_tugas_event_'.$this->general_library->getId());
            if($uploadedFile){
                foreach($uploadedFile as $uf){
                    if(file_exists($namaFolder."/".$tahun."/".$bulan."/".$uf['name'])){
                        unlink($namaFolder."/".$tahun."/".$bulan."/".$uf['name']);
                    }
                }
            }
        }
    }

    public function submitUploadSuratTugasEvent(){
        $rs['code'] = 0;
        $rs['message'] = "";

        $this->db->trans_begin();

        $dataInput = $this->input->post();
        
        $event = $this->db->select('*')
                        ->from('db_sip.event')
                        ->where('id', $dataInput['list_event'])
                        ->get()->row_array();

        if(date('Y-m-d') > $event['max_input_date']){
            $rs['code'] = 1;
            $rs['message'] = "Tidak bisa mengupload Surat Tugas Event karena sudah melewati batas upload Surat Tugas Event yaitu pada ".formatDateNamaBulan($event['max_input_date']);
            $this->db->trans_rollback();
            return $rs;
        }
        
        $uploadedFile = $this->session->userdata('upload_surat_tugas_event_'.$this->general_library->getId());
        $selectedFile = null;
        foreach($uploadedFile as $uf){
            $selectedFile = $uf['name'];
        }

        $bulan = getNamaBulan(date('m'));
        $tahun = date('Y');
        
        $dataEvent = null;
        $dataEventDetail = null;
        $insertId = null;

        $idMUser = [];
        $idUnitKerja = null;
        $explTglEvent = explode("-", $event['tgl']);
        $tanggalEvent = $explTglEvent[2];
        $bulanEvent = $explTglEvent[1];
        $tahunEvent = $explTglEvent[0];

        foreach($dataInput['list_pegawai'] as $di){
            $expl = explode(";", $di);
            $idMUser[] = $expl[2];
            $idUnitKerja = $expl[0];
        }

        $exists = $this->db->select('a.*, b.nm_unitkerja, c.judul')
                            ->from('t_pegawai_event a')
                            ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                            ->join('db_sip.event c', 'a.id_event = c.id')
                            ->where('a.id_unitkerja', $idUnitKerja)
                            ->where('a.id_event', $dataInput['list_event'])
                            ->where('a.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();

        if($exists){
            $rs['code'] = 1;
            $rs['message'] = "Surat Tugas Event ".$exists['judul']." untuk ".$exists['nm_unitkerja']." tidak bisa diinput karena sudah ada.";
            $this->db->trans_rollback();
            return $rs;
        }

        $existsDokpen = $this->db->select('a.*, b.nama')
                                    ->from('t_dokumen_pendukung a')
                                    ->join('m_user b', 'a.id_m_user = b.id')
                                    ->where('a.id_m_user', $expl[2])
                                    ->where_not_in('a.id_m_jenis_disiplin_kerja', [19, 20])
                                    ->where_in('a.status', [1,2])
                                    ->where('a.flag_active', 1)
                                    ->where('a.tanggal', floatval($tanggalEvent))
                                    ->where('a.bulan', floatval($bulanEvent))
                                    ->where('a.tahun', $tahunEvent)
                                    ->where('b.flag_active', 1)
                                    ->limit(1)
                                    ->get()->row_array();
            if($existsDokpen){
                $rs['code'] = 1;
                $rs['message'] = "Tidak dapat menginput Surat Tugas Event karena pegawai atas nama ".$existsDokpen['nama']." memiliki Dokumen Pendukung pada tanggal ".formatDateNamaBulan($event['tgl']);
                $this->db->trans_rollback();
                return $rs;
            }

        foreach($dataInput['list_pegawai'] as $d){
            $expl = explode(";", $d);

            if(!isset($dataEvent[$expl[0]])){
                $dataEvent[$expl[0]]['id_unitkerja'] = $expl[0];
                $dataEvent[$expl[0]]['id_event'] = $dataInput['list_event'];
                $dataEvent[$expl[0]]['url_file'] = "arsipsurattugasevent/".$tahun."/".$bulan."/".$selectedFile;
                $dataEvent[$expl[0]]['created_by'] = $this->general_library->getId();

                $this->db->insert('t_pegawai_event', $dataEvent[$expl[0]]);
                $insertId[$expl[0]] = $this->db->insert_id();
            }

            $dataEventDetail[$expl[1]]['id_t_pegawai_event'] = $insertId[$expl[0]];
            $dataEventDetail[$expl[1]]['nip'] = $expl[1];
            $dataEventDetail[$expl[1]]['id_m_user'] = $expl[2];
            $dataEventDetail[$expl[1]]['created_by'] = $this->general_library->getId();
        }

        if($dataEventDetail){
            $this->db->insert_batch('t_pegawai_event_detail', $dataEventDetail);
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $rs;
    }

    public function loadListSuratTugas(){
        $unitkerja = $this->getListUnitKerjaBerjenjang();
        $listUk = null;
        foreach($unitkerja as $u){
            $listUk[] = $u['id_unitkerja'];
        }

        return $this->db->select('a.*, b.judul, b.tgl, c.nama as inputer, d.nm_unitkerja')
                    ->from('t_pegawai_event a')
                    ->join('db_sip.event b', 'a.id_event = b.id')
                    ->join('m_user c', 'a.created_by = c.id')
                    ->join('db_pegawai.unitkerja d', 'a.id_unitkerja = d.id_unitkerja')
                    ->where('c.flag_active', 1)
                    ->where_in('a.id_unitkerja', $listUk)
                    ->where('a.flag_active', 1)
                    ->order_by('b.tgl', 'desc')
                    ->order_by('a.created_date', 'desc')
                    ->get()->result_array();
    }

    public function deleteSuratTugasEvent($id){
        $this->db->where('id', $id)
                ->update('t_pegawai_event', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

        $this->db->where('id_t_pegawai_event', $id)
                ->update('t_pegawai_event_detail', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);
    }

    public function getListPegawaiEventDetail($id){
        return $this->db->select('a.id as id_t_pegawai_event_detail, b.*, c.nama_jabatan, d.nm_pangkat, f.max_change_date')
                            ->from('t_pegawai_event_detail a')
                            ->join('db_pegawai.pegawai b', 'a.nip = b.nipbaru_ws')
                            ->join('db_pegawai.jabatan c', 'b.jabatan = c.id_jabatanpeg')
                            ->join('db_pegawai.pangkat d', 'b.pangkat = d.id_pangkat')
                            ->join('t_pegawai_event e', 'a.id_t_pegawai_event = e.id')
                            ->join('db_sip.event f', 'e.id_event = f.id')
                            ->where('a.id_t_pegawai_event', $id)
                            ->where('a.flag_active', 1)
                            ->order_by('b.nama')
                            ->get()->result_array();
    }

    public function loadDetailSuratTugasEvent($id){
        $tEvent = $this->db->select('a.*, c.nama as inputer, b.*, a.id as id_t_pegawai_event, b.id as id_event')
                        ->from('t_pegawai_event a')
                        ->join('db_sip.event b', 'a.id_event = b.id')
                        ->join('m_user c', 'a.created_by = c.id')
                        ->where('a.id', $id)
                        ->where('a.flag_active', 1)
                        ->get()->row_array();

        // $tEventDetail = $this->getListPegawaiEventDetail($tEvent['id_t_pegawai_event']);

        return [
            'data' => $tEvent,
            // 'detail' => $tEventDetail
        ];
    }

    public function deletePegawaiSuratTugasEvent($id){
        $res['code'] = 0;
        $res['message'] = "";

        $dataEvent = $this->db->select('a.*')
                            ->from('t_pegawai_event a')
                            ->join('t_pegawai_event_detail b', 'a.id = b.id_t_pegawai_event')
                            ->where('flag_active', 1)
                            ->where('b.id', $id)
                            ->get()->row_array();

        if(date('Y-m-d') > $dataEvent['max_change_date']){
            $res['code'] = 1;
            $res['message'] = "Data tidak dapat diubah karena sudah melewati Batas Waktu Edit yaitu ".formatDateNamaBulan($dataEvent['max_change_date']);
        } else {
            $this->db->where('id', $id)
                ->update('t_pegawai_event_detail', [
                    'flag_active' => 0,
                    'updated_by' => $this->general_library->getId()
                ]);
        }

        return $res;
    }

    public function editSuratTugasEvent($id){
        $res['code'] = 0;
        $res['message'] = "";

        $dataEvent = $this->db->select('b.*, a.id as id_t_pegawai_event')
                            ->from('t_pegawai_event a')
                            ->join('db_sip.event b', 'a.id_event = b.id')
                            ->where('a.flag_active', 1)
                            ->where('a.id', $id)
                            ->get()->row_array();
        if($dataEvent){
            if(date('Y-m-d') > $dataEvent['max_change_date']){
                $res['code'] = 1;
                $res['message'] = "Tidak dapat mengubah data karena sudah melewati batas waktu penggantian data yaitu pada tanggal ".formatDateNamaBulan($dataEvent['max_change_date']);
                return $res;
            }
        }

        $this->db->trans_begin();

        $data = $this->input->post();
        $newUrl = "";
        $flagNoChange = 1;

        if($_FILES['file_st']['name'] != ""){
            $flagNoChange = 0;
            $namaFolder = "arsipsurattugasevent";
            $bulan = getNamaBulan(date('m'));
            $tahun = date('Y');
            
            if(!file_exists($namaFolder."/".$tahun) && !is_dir($namaFolder."/".$tahun)) {
                mkdir($namaFolder."/".$tahun, 0777, TRUE);       
            }

            if(!file_exists($namaFolder."/".$tahun."/".$bulan) && !is_dir($namaFolder."/".$tahun."/".$bulan)) {
                mkdir($namaFolder."/".$tahun."/".$bulan, 0777, TRUE);       
            }

            $newFileName = generateRandomString()."_".str_replace(' ', '_', $_FILES['file_st']['name']);
            $_FILES['file_st']['name'] = $newFileName;
            $config['upload_path'] = $namaFolder.'/'.$tahun.'/'.$bulan.'/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $newFileName;
            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('file_st')){ // jika gagal upload
            $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = $this->upload->display_errors();
                return $res;
            } else { // jika berhasil upload
                $newUrl = $config['upload_path'].$newFileName;
                $this->db->where('id', $id)
                        ->update('t_pegawai_event', [
                            'url_file' => $newUrl,
                            'updated_by' => $this->general_library->getId()
                        ]);
            }
        }

        if(isset($data['list_pegawai_edit'])){
            $flagNoChange = 0;
            $dataEdit = null;
            foreach($data['list_pegawai_edit'] as $lpe){
                $expl = explode(";", $lpe);
                $dataEdit[$expl[2]]['id_t_pegawai_event'] = $id;
                $dataEdit[$expl[2]]['id_m_user'] = $expl[2];
                $dataEdit[$expl[2]]['nip'] = $expl[1];
                $dataEdit[$expl[2]]['created_by'] = $this->general_library->getId();

                $listId[] = $expl[2];
            }

            if($dataEdit){
                $existsPegawai = $this->db->select('*')
                                        ->from('t_pegawai_event_detail')
                                        ->where_in('id_m_user', $listId)
                                        ->where('flag_active', 1)
                                        ->where('id_t_pegawai_event', $id)
                                        ->get()->result_array();
                if($existsPegawai){
                    foreach($existsPegawai as $ep){
                        unset($dataEdit[$ep['id_m_user']]);
                    }
                }

                if($dataEdit){
                    $this->db->insert_batch('t_pegawai_event_detail', $dataEdit);
                } else {
                    $this->db->trans_rollback();
                    $res['code'] = 1;
                    $res['message'] = "Pegawai yang dipilih sudah ada dalam daftar pegawai";
                    return $res;
                }
            }
        }

        if($flagNoChange == 1){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = "Tidak ada perubahan data, silahkan memilih data yang ingin diubah";
            return $res;   
        }

        if($this->db->trans_status() == FALSE || $res['code'] != 0){
            $this->db->trans_rollback();
            $res['code'] = 1;
            $res['message'] = "Terjadi Kesalahan";
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }
}
