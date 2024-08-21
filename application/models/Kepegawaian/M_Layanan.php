<?php

// require "../vendor/pdfcrowd/pdfcrowd.php";

class M_Layanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        // $this->db = $this->load->database('main', true);
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

        $skcpnspns = $this->db->select('a.nipbaru_ws, b.*')
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
                                'tanggal_verfi' => date('Y-m-d H:i:s')
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

    public function createDpcp($data){
        $rs['code'] = 0;
        $rs['message'] = '';
        $rs['data'] = null;

        $this->db->trans_begin();

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
            $path = 'arsipdpcp/DPCP_'.$data['profil_pegawai']['nipbaru_ws'].'_'.date('Ymd').'.pdf';
            $html = $this->load->view('kepegawaian/V_CetakDpcp', $data, true);
            // dd($html);
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                // 'debug' => true
            ]);
            // $html = $this->load->view('kepegawaian/V_SKPermohonanCuti', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output($path, 'F');

            $rs['data'] = $path;

            $this->db->where('id', $data['id_t_checklist_pensiun'])
                    ->update('t_checklist_pensiun', [
                        'url_file_dpcp' => $path
                    ]);


            $kepalabkpsdm = $this->db->select('a.*, b.id as id_m_user, c.nama_jabatan')
                    ->from('db_pegawai.pegawai a')
                    ->join('m_user b', 'a.nipbaru_Ws = b.username')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg')
                    ->where('c.kepalaskpd', 1)
                    ->where('a.skpd', '4018000')
                    ->where('b.flag_active', 1)
                    ->get()->row_array();

            $randomString = generateRandomString(30, 1, 't_file_ds'); 
            $contentQr = trim(base_url('verifPdf/'.str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $randomString)));
            // dd($contentQr);
            $qr = generateQr($contentQr);
            $image_ds = explode("data:image/png;base64,", $qr);

            $dataQr['user'] = $kepalabkpsdm;
            $dataQr['qr'] = $qr;

            $qr_page = $this->load->view('adminkit/partials/V_QrTte', $dataQr, true);
            
            $qr_path = "arsipdpcp/qr/qr_dpcp_".$data['profil_pegawai']['nipbaru_ws']."_".date('Ymd').".png";

            $client = new \Pdfcrowd\HtmlToImageClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");
            // configure the conversion
            $client->setOutputFormat("png");
            // run the conversion and write the result to a file
            $client->convertStringToFile('<html>haloo</html>', $qr_path);

            $qrImageBase64 = convertToBase64(base_url($qr_path));
            // $qrImageBase64 = convertToBase64(base_url($qr_page));

            dd($qrImageBase64);

            $fileBase64 = convertToBase64(base_url($path));

            $request_ws = [
                'signatureProperties' => [
                    "tampilan" => "VISIBLE",
                    // "imageBase64" => $qrImageBase64,
                    "tag_koordinat" => "^",
                    "width" => 100,
                    "height" => 100,
                    "page" => 1,
                ],
                // 'file' => convertToBase64(($path))
            ];

            $this->db->insert('t_request_ds', [
                'ref_id' => $data['id_t_checklist_pensiun'],
                'table_ref' => 't_checklist_pensiun',
                'id_m_jenis_ds' => 1,
                'nama_jenis_ds' => 'DPCP',
                'request' => json_encode($request_ws),
                'url_file' => $path,
                'url_image_ds' => $qrImageBase64,
                'created_by' => $this->general_library->getId(),
                'nip' => $data['nip']
            ]);
        }

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
        }
            
        return $rs;
    }
}
