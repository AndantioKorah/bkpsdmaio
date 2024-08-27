<?php

include "vendor/html-to-jpeg-php-master/HtmlToJpeg.php";

class M_Layanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
		$this->load->model('user/M_User', 'user');
        $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function getKelengkapanBerkas($nip){
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
                        $result['data_hukdis'] = $dh;
                    }
                }
            }
        }

        // dd($result['data_hukdis']);

        $skcpnspns = $this->db->select('a.nipbaru_ws, b.*, a.tmtcpns')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegberkaspns b', 'a.id_peg = b.id_pegawai')
                        ->where('a.nipbaru_ws', $nip)
                        ->where('b.status', 2)
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

        $result['akte_anak'] = $this->db->select('a.nipbaru_ws, b.*')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegkeluarga b', 'a.id_peg = b.id_pegawai')
                        ->where('a.nipbaru_ws', $nip)
                        ->where_in('b.status', [1,2])
                        ->where_in('flag_active', [1,2])
                        ->where('b.hubkel', '40')
                        ->order_by('b.tgllahir', 'desc')
                        ->get()->result_array();

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
                        ->order_by('b.tahun, b.created_date')
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
			$data_berkas = $temp['berkas'][$berkas];
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
                        'udpated_by' => $this->general_library->getId(),
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
                    'tanggal_validasi' => date('Y-m-d H:i:s')
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
                        ->where('ref_id', $data['id_t_checklist_pensiun'])
                        ->where('table_ref', 't_checklist_pensiun')
                        ->where('flag_active', 1)
                        ->get()->row_array();

        if($exists){
            $rs['code'] = 1;
            $rs['message'] = 'DPCP sudah diajukan';
        } else {
            ///////////////////////////////// DPCP
            $pathDpcp = 'arsippensiunotomatis/arsipdpcp/DPCP_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
            $html = $this->load->view('kepegawaian/V_CetakDpcp', $data, true);
            // dd($html);
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                // 'debug' => true
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($pathDpcp, 'F');

            $rs['data'] = $pathDpcp;

            $this->db->where('id', $data['id_t_checklist_pensiun'])
                    ->update('t_checklist_pensiun', [
                        'url_file_dpcp' => $pathDpcp
                    ]);

            $fileBase64 = convertToBase64(base_url($pathDpcp));

            $tteTemplateDpcp = $this->createQrTte();
            $request_ws = [
                'signatureProperties' => [
                    "tampilan" => "VISIBLE",
                    "imageBase64" => $tteTemplateDpcp['data']['qrBase64'],
                    "tag" => "^",
                    "width" => 100,
                    "height" => 100,
                    "page" => 1,
                ],
                // 'file' => convertToBase64(($pathDpcp))
            ];
            $this->db->insert('t_request_ds', [
                'ref_id' => $data['id_t_checklist_pensiun'],
                'table_ref' => 't_checklist_pensiun',
                'id_m_jenis_ds' => 1,
                'nama_jenis_ds' => 'DPCP',
                'request' => json_encode($request_ws),
                'url_file' => $pathDpcp,
                'url_image_ds' => $tteTemplateDpcp['data']['qrBase64'],
                'random_string' => $tteTemplateDpcp['data']['randomString'],
                'created_by' => $this->general_library->getId(),
                'nama_kolom_flag' => 'flag_ds_dpcp',
                'nip' => $data['nip']
            ]);

            ///////////////////////////////// SP HUKDIS
    		$data['kaban'] = $this->kepegawaian->getDataKabanBkd();
            $pathHukdis = 'arsippensiunotomatis/arsipskhukdis/SPHUKDIS_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
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
                        'url_file_hukdis' => $pathHukdis
                    ]);

            $fileBase64 = convertToBase64(base_url($pathHukdis));

            $tteTemplateHukdis = $this->createQrTte();
            $request_ws = [
                'signatureProperties' => [
                    "tampilan" => "VISIBLE",
                    "imageBase64" => $tteTemplateHukdis['data']['qrBase64'],
                    "tag" => "^",
                    "width" => 100,
                    "height" => 100,
                    "page" => 1,
                ],
                // 'file' => convertToBase64(($pathHukdis))
            ];
            $this->db->insert('t_request_ds', [
                'ref_id' => $data['id_t_checklist_pensiun'],
                'table_ref' => 't_checklist_pensiun',
                'id_m_jenis_ds' => 2,
                'nama_jenis_ds' => 'SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR',
                'request' => json_encode($request_ws),
                'url_file' => $pathHukdis,
                'url_image_ds' => $tteTemplateHukdis['data']['qrBase64'],
                'random_string' => $tteTemplateHukdis['data']['randomString'],
                'created_by' => $this->general_library->getId(),
                'nama_kolom_flag' => 'flag_ds_hukdis',
                'nip' => $data['nip']
            ]);

            ///////////////////////////////// SP PIDANA
            $pathPidana = 'arsippensiunotomatis/arsipskpidana/SPPIDANA_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
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
                        'url_file_pidana' => $pathPidana
                    ]);

            $fileBase64 = convertToBase64(base_url($pathPidana));

            $tteTemplatePidana = $this->createQrTte();
            $request_ws = [
                'signatureProperties' => [
                    "tampilan" => "VISIBLE",
                    "imageBase64" => $tteTemplatePidana['data']['qrBase64'],
                    "tag" => "^",
                    "width" => 100,
                    "height" => 100,
                    "page" => 1,
                ],
                // 'file' => convertToBase64(($pathPidana))
            ];
            $this->db->insert('t_request_ds', [
                'ref_id' => $data['id_t_checklist_pensiun'],
                'table_ref' => 't_checklist_pensiun',
                'id_m_jenis_ds' => 3,
                'nama_jenis_ds' => 'SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR',
                'request' => json_encode($request_ws),
                'url_file' => $pathPidana,
                'url_image_ds' => $tteTemplatePidana['data']['qrBase64'],
                'random_string' => $tteTemplatePidana['data']['randomString'],
                'created_by' => $this->general_library->getId(),
                'nama_kolom_flag' => 'flag_ds_pidana',
                'nip' => $data['nip']
            ]);
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

        $data = $this->db->select('a.*, d.nama as nama_ds, c.created_date as tanggal_ds, b.flag_selected, e.keterangan, e.meta_name')
                        ->from('t_checklist_pensiun a')
                        ->join('t_request_ds b', 'a.id = b.ref_id AND b.table_ref = "t_checklist_pensiun"')
                        ->join('t_cron_request_ds c', 'b.id = c.id_t_request_ds AND c.flag_active = 1', 'left')
                        ->join('m_user d', 'c.created_by = d.id AND d.flag_active = 1', 'left')
                        ->join('m_jenis_ds e', 'b.id_m_jenis_ds = e.id')
                        ->where('a.id', $id)
                        ->where('b.flag_active', 1)
                        // ->where('d.flag_active', 1)
                        ->group_by('b.id')
                        ->get()->result_array();
        if($data){
            foreach($data as $d){
                if($d['meta_name'] == 'dpcp'){
                    $result['dpcp'] = $d;
                } else if($d['meta_name'] == 'sp_hukdis'){
                    $result['hukdis'] = $d;
                } else if($d['meta_name'] == 'sp_pidana'){
                    $result['pidana'] = $d;
                }
            }
        }

        return $result;
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
        $data = $this->db->select('a.*, b.request, b.url_image_ds, b.url_file, b.ref_id, b.table_ref,
                        b.nama_kolom_flag, b.random_string, b.id as id_t_request_ds')
                        ->from('t_cron_request_ds a')
                        ->join('t_request_ds b', 'a.id_t_request_ds = b.id')
                        ->where('a.flag_active', 1)
                        ->where('a.flag_sent', 0)
                        // ->where('a.flag_send', 0)
                        // ->where('b.url_sk IS NULL')
                        ->limit(3)
                        ->get()->result_array();
        if($data){
            foreach($data as $d){
                $request = json_decode($d['request'], true);
                $request['signatureProperties']['imageBase64'] = $d['url_image_ds'];

                $base64File = base64_encode(file_get_contents(base_url().$d['url_file']));
                $jsonRequest['file'][] = $base64File;

                $credential = json_decode($d['credential'], true);
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
                }
            }
        }
    }

    public function resizeImage($image, $w, $h){
        imagealphablending( $image, FALSE );
        imagesavealpha( $image, TRUE );
        $oldw = imagesx($image);
        $oldh = imagesy($image);
        $temp = imagecreatetruecolor($w, $h);
        imagealphablending( $temp, FALSE );
        imagesavealpha( $temp, TRUE );
        imagecopyresampled($temp, $image, 0, 0, 0, 0, $w, $h, $oldw, $oldh);

        return $temp;
    }

    public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
        $transparency = imagecolorallocatealpha($cut, 0, 0, 0, 127);
        imagefill($cut, 0, 0, $transparency);
        imagesavealpha($cut, true);
        
        // copying relevant section from background to the cut resource
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

        // copying relevant section from watermark to the cut resource
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        
        // insert cut resource to destination image
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
        
    }

    public function createQrTte($nip = null, $randomString = null){
		$rs['code'] = 0;
		$rs['message'] = "";
		$rs['data'] = null;

		$user = null;
		if($nip != null){
			$user = $this->user->getProfilUserByNip($nip);
		} else {
			$user = $this->layanan->getKepalaBkpsdm();
		}

		if(!$user){
			$rs['code'] = 0;
			$rs['message'] = "User Tidak Ditemukan";
			return $rs;
		}
        if($randomString == null){
            $randomString = generateRandomString(30, 1, 't_file_ds'); 
        }
		$contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
		// dd($contentQr);
		$qr = generateQr($contentQr);
		// $image_ds = explode("data:image/png;base64,", $qr);
		$data['user'] = $user;
		$data['qr'] = $qr;

		list($type, $qr) = explode(';', $qr);
		list(, $qr)      = explode(',', $qr);
		$qrDecode = base64_decode($qr);

		$qrPath = 'arsippensiunotomatis/qr/'.$randomString.'.png';
		file_put_contents($qrPath, $qrDecode);

		$image = imagecreatetruecolor(500, 500);   

		// $background_color = imagecolorallocate($image, 255, 255, 255);
		$transparency = imagecolorallocatealpha($image, 255,255,255, 127);
		imagefill($image, 0, 0, $transparency);
		imagesavealpha($image, true);

		$text_color = imagecolorallocate($image, 0, 0, 0);    
		$fonts = "assets/fonts/tahoma.ttf";

		imagettftext($image, 20, 0, 110, 380, $text_color, $fonts, getNamaPegawaiFull($data['user']));
		imagettftext($image, 20, 0, 110, 420, $text_color, $fonts, "NIP. ".$data['user']['nipbaru_ws']);

		$logoBsre = imagecreatefrompng("assets/img/logo-kunci-bsre-custom.png");
		$logoBsreHeight = 60;
		$logoBsreWidth = 60;
		imagealphablending( $logoBsre, FALSE );
		imagesavealpha( $logoBsre, TRUE );
		$resizedLogo = $this->resizeImage($logoBsre, $logoBsreHeight, $logoBsreWidth);
		$this->imagecopymerge_alpha($image, $resizedLogo, 45, 360, 0, 0, $logoBsreWidth, $logoBsreHeight, 100);

		$container_height = imagesy($image);
		$container_width = imagesx($image);
		$qrImage = imagecreatefrompng($qrPath);
		$qrImageMerge_height = imagesy($qrImage);
		$qrImageMerge_width = imagesx($qrImage);
		$qrImagePosX = ($container_width/2)-($qrImageMerge_width/2);
		$qrImagePosY = ($container_height/2)-($qrImageMerge_height/2)-70;
		// imagefilter($qrImage, IMG_FILTER_GRAYSCALE);
		// imagefilter($qrImage, IMG_FILTER_CONTRAST, -100);
		$this->imagecopymerge_alpha($image, $qrImage, $qrImagePosX, $qrImagePosY, 0, 0, $qrImageMerge_width, $qrImageMerge_height, 100);

		ob_start();
		imagepng($image);
		$png = ob_get_clean();
		// $uri = "data:image/png;base64," . base64_encode($png);
		imagedestroy($image);
		$rs['data'] = [
			'qrBase64' => base64_encode($png),
			'randomString' => $randomString
		];

		return $rs;
		// echo "<img src='".$uri."' />";
	}
}
