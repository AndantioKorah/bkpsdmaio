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

        $skcpnspns = $this->db->select('a.nipbaru_ws, b.gambarsk, b.jenissk')
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
                        // ->where('b.status', 2)
                        ->order_by('b.tahun, b.created_date')
                        ->where_in('flag_active', [1,2])
                        ->get()->result_array();
                        
        $arsip = $this->db->select('a.nipbaru_ws, b.*, c.keterangan')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.pegarsip b', 'a.id_peg = b.id_pegawai')
                        ->join('m_dokumen c', 'b.id_dokumen = c.id_dokumen')
                        ->where('a.nipbaru_ws', $nip)
                        // ->where('b.status', 2)
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
                } else if($a['id_dokumen'] == 58){
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
}
