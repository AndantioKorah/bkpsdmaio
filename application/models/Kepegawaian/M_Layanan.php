<?php
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
                    $result['akte_nikah'] = $a;
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
                } else if($a['id_dokumen'] == 27){
                    $result['akte_anak'][] = $a;
                } else if($a['id_dokumen'] == 28){
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
        $exists = $this->db->select('*')
                        ->from('t_checklist_pensiun')
                        ->where('nip', $nip)
                        ->where('id_m_jenis_pensiun', $id_m_jenis_pensiun)
                        ->where('flag_active', 1)
                        ->get()->row_array();
        if($exists){
            $last_id = $exists['id'];
        } else {
            $this->db->insert('t_checklist_pensiun', [
                'id_m_jenis_pensiun' => $id_m_jenis_pensiun,
                'nip' => $nip,
                'created_by' => $this->general_library->getId()
            ]);

            $last_id = $this->db->insert_id();
        }

        return $last_id;

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
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

        if($berkas == 'akte_anak'){
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
}
