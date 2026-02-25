<?php
    // require 'vendor/autoload.php';
    // require FCPATH . 'vendor/autoload.php';
    // use PhpOffice\PhpSpreadSheet\Spreadsheet;
    // use PhpOffice\PhpSpreadSheet\IOFactory;
    // require FCPATH . '/vendor/autoload.php';

    // use mpdf\mpdf;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	class M_Rekap extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->load->model('kinerja/M_Kinerja', 'm_kinerja');
            $this->load->model('general/M_General', 'm_general');
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function searchDataHukdis($data){
            $this->db->select('a.*, b.*, e.nm_unitkerja, c.nama as nama_hd, d.nama_jhd')
                    ->from('db_pegawai.pegdisiplin a')
                    ->join('db_pegawai.pegawai b', 'a.id_pegawai = b.id_peg')
                    ->join('db_pegawai.hd c', 'a.hd = c.idk')
                    ->join('db_pegawai.jhd d', 'a.jhd = d.id_jhd')
                    ->join('db_pegawai.unitkerja e', 'b.skpd = e.id_unitkerja')
                    ->where('a.flag_active', 1)
                    ->where('YEAR(a.tglsurat)', $data['tahun'])
                    ->where('a.status', 2)
                    ->order_by('a.tglsurat', 'desc');

            if($data['bulan'] != 0){
                $this->db->where('MONTH(a.tglsurat)', $data['bulan']);
            }
            
            if($data['unitkerja'] != 0){
                $this->db->where('b.skpd', $data['unitkerja']);
            }

            return $this->db->get()->result_array();
        }

        public function getKomponenKinerja($id_m_user, $bulan, $tahun){
            return $this->db->select('*')
                            ->from('t_komponen_kinerja as a')
                            ->where('id_m_user', $id_m_user)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->get()->row_array();
        }

        public function getKinerjaPegawai($id_m_user, $bulan, $tahun){
            return $this->db->select('*,
                            (SELECT SUM(b.realisasi_target_kuantitas)
                            FROM t_kegiatan b
                            WHERE b.id_t_rencana_kinerja = t_rencana_kinerja.id
                            AND b.flag_active = 1 and b.status_verif = 1) as realisasi')
                            ->from('t_rencana_kinerja')
                            ->where('id_m_user', $id_m_user)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->get()->result_array();
            // return $this->db->select('*')
            //                 ->from('t_rencana_kinerja')
            //                 ->where('id_m_user', $id_m_user)
            //                 ->where('bulan', $bulan)
            //                 ->where('tahun', $tahun)
            //                 ->where('flag_active', 1)
            //                 ->get()->result_array();
        }

        public function getKinerjaPegawai2($id_m_user, $bulan, $tahun){
            // return $this->db->select('*,
            //                 (SELECT SUM(b.realisasi_target_kuantitas)
            //                 FROM t_kegiatan b
            //                 WHERE b.id_t_rencana_kinerja = t_rencana_kinerja.id
            //                 AND b.flag_active = 1 and b.status_verif = 1) as realisasi')
            //                 ->from('t_rencana_kinerja')
            //                 ->where('id_m_user', $id_m_user)
            //                 ->where('bulan', $bulan)
            //                 ->where('tahun', $tahun)
            //                 ->where('flag_active', 1)
            //                 ->get()->result_array();
            return $this->db->select('id,sum(target_kuantitas) as target, sum(total_realisasi) as realisasi')
                            ->from('t_rencana_kinerja')
                            ->where('id_m_user', $id_m_user)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->where('flag_active', 1)
                            ->group_by('id')
                            ->get()->result_array();
        }

        public function getProduktivitasKerjaPegawai($id, $bulan, $tahun){
            $result['komponen_kinerja'] = $this->getKomponenKinerja($id, $bulan, $tahun);
            $result['kinerja'] = $this->getKinerjaPegawai($id, $bulan, $tahun);
            return $result;
        }

        public function rekapProduktivitasKerja($data, $flag_rekap_tpp = 0){
            $skpd = explode(";", $data['skpd']);

            $uksearch = null;
            if($flag_rekap_tpp == 1){
                $uksearch = $this->db->select('*')
                                        ->from('db_pegawai.unitkerja')
                                        ->where('id_unitkerja', $skpd[0])
                                        ->get()->row_array();
            }

            $this->db->select('a.nipbaru_ws as nip, a.gelar1, a.gelar2, a.nama, c.nm_unitkerja, c.id_unitkerja, d.kelas_jabatan_jfu, d.kelas_jabatan_jft,
            b.kelas_jabatan, b.jenis_jabatan, b.nama_jabatan, b.eselon, c.id_unitkerjamaster, a.kelas_jabatan_hardcode, a.id_jabatan_tambahan, a.statuspeg,
            a.pangkat')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.jabatan')
                            ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                            ->join('m_pangkat d', 'a.pangkat = d.id_pangkat')
                            ->join('db_pegawai.jabatan e', 'a.id_jabatan_tambahan = e.id_jabatanpeg', 'left')
                            ->where('id_m_status_pegawai', 1)
                            // ->where('a.skpd', $skpd[0])
                            ->order_by('b.eselon')
                            ->order_by('a.nama')
                            ->group_by('a.nipbaru_ws');
            if($flag_rekap_tpp == 1 && in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
                $this->db->where('c.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
            } else {
                $this->db->where('a.skpd', $skpd[0]);
            }

            $list_pegawai = $this->db->get()->result_array();
            $pegawai = null;
            if($list_pegawai){
                $list_pegawai = $this->getKelasJabatanPegawai($list_pegawai);
                foreach($list_pegawai as $lp){
                    $pegawai['result'][$lp['nip']] = $lp;
                }
                $pegawai = $this->getDaftarPenilaianTpp($pegawai, $data, $flag_rekap_tpp);
            }
            return $pegawai['result'];
        }

        public function rekapPenilaianSearch($data){
        //    dd($data);
            $result = null;
            $skpd = explode(";",$data['skpd']);
           
            $list_pegawai = $this->db->select('a.nama,a.gelar1,a.gelar2,b.username as nip, trim(b.nama) as nama_pegawai, b.id, c.nama_jabatan, c.eselon,c.kelas_jabatan')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('m_user b', 'a.nipbaru_ws = b.username')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                                    ->where('a.skpd', $skpd[0])
                                    ->where('b.flag_active', 1)
                                    ->order_by('c.eselon, b.username')
                                    ->where('id_m_status_pegawai', 1)
                                    // ->where('b.id', 78)
                                    ->get()->result_array();
            $temp_pegawai = null;
            if($list_pegawai){
                $i = 0;
                $j = 0;
                foreach($list_pegawai as $p){
                    $temp = $p;
                    $bobot_komponen_kinerja = 0;
                    $bobot_skp = 0;
                    $temp['komponen_kinerja'] = $this->getKomponenKinerja($p['id'], $data['bulan'], $data['tahun']);
                    if($temp['komponen_kinerja']){
                        list($temp['komponen_kinerja']['capaian'], $temp['komponen_kinerja']['bobot']) = countNilaiKomponen($temp['komponen_kinerja']);
                        $bobot_komponen_kinerja = $temp['komponen_kinerja']['bobot'];

                    }
                    $temp['kinerja'] = $this->getKinerjaPegawai($p['id'], $data['bulan'], $data['tahun']);
                    if($temp['kinerja']){
                        $temp['nilai_skp'] = countNilaiSkp($temp['kinerja']);
                        $bobot_skp = $temp['nilai_skp']['bobot'];
                    }
                    $temp['bobot_capaian_produktivitas_kerja'] = floatval($bobot_komponen_kinerja) + floatval($bobot_skp);
                    
                    if($p['eselon'] != null){
                        $result[$i] = $temp;
                        $i++;
                    } else {
                        $temp_pegawai[$j] = $temp;
                        $result[$j] = $temp;
                        $j++;
                    }
                   
                }
                if($temp_pegawai){
                    foreach($temp_pegawai as $t){
                        $result[$i] = $t;
                        $i++;
                    }
                }
            }
            // dd($result);
            return $result;
        }

       

        public function rekapDisiplinSearch($data){
            $result = null;
            $rs = null;
            $skpd = explode(";",$data['skpd']);
            // $data_jam_kerja['wfo_masuk'] = "07:45:00";
            // $data_jam_kerja['wfo_pulang'] = "17:00";
            // $data_jam_kerja['wfoj_masuk'] = "07:30:00";
            // $data_jam_kerja['wfoj_pulang'] = "15:30";
            $data_jam_kerja = null;
            $id_unitkerja = null;
            $list_disiplin_kerja = null;

            $list_pegawai = $this->db->select('b.username as nip, trim(b.nama) as nama_pegawai, b.id, c.nama_jabatan, c.eselon, f.role_name, d.id_unitkerja, d.id_unitkerjamaster')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('m_user b', 'a.nipbaru_ws = b.username')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('m_user_role e', 'b.id = e.id_m_user', 'left')
                                    ->join('m_role f', 'f.id = e.id_m_role', 'left')
                                    ->where('a.skpd', $skpd[0])
                                    ->where('b.flag_active', 1)
                                    ->where('id_m_status_pegawai', 1)
                                    ->group_by('b.id')
                                    ->order_by('c.eselon, b.username')
                                    ->get()->result_array();
                                    
            $data_disiplin_kerja = $this->db->select('a.*, b.username as nip, d.keterangan')
                        ->from('t_disiplin_kerja a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                        ->where('a.bulan', $data['bulan'])
                        ->where('a.tahun', $data['tahun'])
                        ->where('c.skpd', $skpd[0])
                        ->where('id_m_status_pegawai', 1)
                        ->where('a.flag_active', 1)
                        ->where_in('a.id_m_jenis_disiplin_kerja', [1,2,14,15,16,17])
                        ->get()->result_array();
                
            if($data_disiplin_kerja){
                foreach($data_disiplin_kerja as $ddk){
                    $tanggal = $ddk['tanggal'] < 10 ? '0'.$ddk['tanggal'] : $ddk['tanggal'];
                    $bulan = $ddk['bulan'] < 10 ? '0'.$ddk['bulan'] : $ddk['bulan'];
                    $date = $tanggal.'-'.$bulan.'-'.$ddk['tahun'];

                    $list_disiplin_kerja[$ddk['nip']][$date] = $ddk['keterangan'];
                    // if(isset($list_pegawai[$ddk['nip']]) && isset($list_pegawai[$ddk['nip']]['absensi'][$date])){ // cek jika ada data absensi pada tanggal tersebut
                    //     $list_pegawai[$ddk['nip']]['absensi'][$date]['masuk']['data'] = $ddk['keterangan'];
                    // }
                }
            }
                                    
            if($list_pegawai){
                $temp = $list_pegawai;

                $id_unitkerja = $list_pegawai[0]['id_unitkerja'];
                $id_unitkerjamaster = $list_pegawai[0]['id_unitkerjamaster'];

                $jenis_skpd = 1;
                if(in_array($id_unitkerja, LIST_UNIT_KERJA_KHUSUS)){
                    $jenis_skpd = 2;
                } else if(in_array($id_unitkerjamaster, LIST_UNIT_KERJA_MASTER_SEKOLAH)){
                    $jenis_skpd = 4;
                }

                $jam_kerja_skpd = $this->db->select('*')
                                            ->from('t_jam_kerja')
                                            ->where('id_m_jenis_skpd', $jenis_skpd)
                                            ->where('flag_active', 1)
                                            ->get()->row_array();

                // get data jam kerja khusus jika bukan SKPD Khusus. untuk kebutuhan data absensi lurah/camat
                if($jenis_skpd != 2){
                    $jam_kerja_khusus = $this->db->select('*')
                                            ->from('t_jam_kerja')
                                            ->where('id_m_jenis_skpd', 2)
                                            ->where('flag_active', 1)
                                            ->get()->row_array();
                }

                $list_pegawai = null;
                foreach($temp as $t){
                    $list_pegawai[$t['nip']] = $t;
                    $list_pegawai[$t['nip']]['jam_kerja'] = $jam_kerja_skpd;
                    if(in_array($t['role_name'], LIST_ROLE_KHUSUS)){
                        $list_pegawai[$t['nip']]['jam_kerja'] = $jam_kerja_khusus;
                    }
                }
            }

            $hari_libur = $this->db->select('tanggal')
                                ->from('t_hari_libur')
                                ->where('bulan', $data['bulan'])
                                ->where('tahun', $data['tahun'])
                                ->where('flag_active', 1)
                                ->get()->result_array();
            $list_hari_libur = null;
            if($hari_libur){
                foreach($hari_libur as $h){
                    $list_hari_libur[] = $h['tanggal'];
                }
            }
            // echo(strtotime($data_jam_kerja['wfo_masuk'].'+ 1 minute')).';';
            // echo(strtotime($data_jam_kerja['wfo_masuk']));
            // die();
            // $absen = "07:46:00";
            // $diff = strtotime($absen) - strtotime($data_jam_kerja['wfo_masuk']);
            // dd($diff/60);

            if($_FILES["file_rekap"]["name"] != ''){
                $allowed_extension = ['xls', 'csv', 'xlsx'];
                $file_array = explode(".", $_FILES["file_rekap"]["name"]);
                $file_extension = end($file_array);
    
                if(in_array($file_extension, $allowed_extension)){
                    $config['upload_path'] = 'assets/upload_rekap_absen/new_format'; 
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '5000'; // max_size in kb
                    $config['file_name'] = $_FILES['file_rekap']['name'];
    
                    $this->load->library('upload', $config); 
    
                    $uploadfile = $this->upload->do_upload('file_rekap');
    
                    if($uploadfile){
                        $upload_data = $this->upload->data(); 
                        $file_rekap['name'] = $upload_data['file_name'];
    
                        $filename = $_FILES["file_rekap"]["name"];
                        libxml_use_internal_errors(true);
                        // $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES["file_rekap"]["name"]);
                        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($config['upload_path'].'/'.$file_rekap['name']);
                        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
    
                        $spreadsheet = $reader->load($_FILES["file_rekap"]["tmp_name"]);
                        // $data = $spreadsheet->getActiveSheet()->toArray();
                        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
                        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

                        for($row = 6; $row <= $highestRow; $row++){
                            $nip = null;
                            $value_tanggal = null;
                            $flag_jumat = false;
                            $flag_libur = false;
                            for($col = 2; $col <= $highestColumnIndex; $col++){
                                $value = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
                                if($value){
                                    if($col == 2){ //nip
                                        $nip = clearstring($value);
                                    //     $list_pegawai[$nip]['nip'] = $nip;
                                    // } else if($col == 3) {//nama pegawai
                                    //     $list_pegawai[$nip]['nama_pegawai'] = $value;
                                    }
                                    if(isset($list_pegawai[$nip])){
                                        $data_jam_kerja = $list_pegawai[$nip]['jam_kerja'];
                                        if($col == 4){ //tanggal absen
                                            $tanggal = explode("/", $value);
                                            if($tanggal[1] == $data['bulan'] && $tanggal[2] == $data['tahun']){
                                                $value_tanggal = $value;
                                                $date_ymd = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
                                                if(in_array($date_ymd, $list_hari_libur)){
                                                    $flag_libur = true;
                                                }
                                                $value_tanggal = $tanggal[0].'-'.$tanggal[1].'-'.$tanggal[2];
                                                $date = date('d-m-Y', strtotime($value_tanggal));
                                                $hari = getNamaHari($date);
                                                if($hari == 'Jumat'){
                                                    $flag_jumat = true;
                                                } else if($hari == 'Sabtu' || $hari == 'Minggu'){
                                                    $flag_libur = true;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['hadir'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['hadir'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['jhk'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['jhk'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['tmk1'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['tmk1'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['tmk2'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['tmk2'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['tmk3'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['tmk3'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['pksw1'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['pksw1'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['pksw2'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['pksw2'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['pksw3'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['pksw3'] = 0;
                                                }
                                                if(!isset($list_pegawai[$nip]['rekap_absensi']['tk'])){
                                                    $list_pegawai[$nip]['rekap_absensi']['tk'] = 0;
                                                }
                                                $list_pegawai[$nip]['absensi'][$value_tanggal] = null;
                                                $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['data'] = null;
                                                $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['data'] = null;
                                                $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['keterangan'] = null;
                                                $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['keterangan'] = null;
                                            }
                                        } else if($col == 6 && $value_tanggal && !$flag_libur){ //absen masuk
                                            $list_pegawai[$nip]['rekap_absensi']['jhk']++;

                                            // if($nip == '197402061998031008' && $value_tanggal == '29-05-2022'){
                                            //     echo $value_tanggal.';'.$flag_libur.';'.json_encode($list_hari_libur);
                                            //     die();
                                            // }
                                            $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['data'] = $value;
                                            if($value == "00:00:00"){
                                                // if($nip == '197402061998031008'){
                                                //     echo $value_tanggal.' ; ';
                                                // }
                                                if(isset($list_disiplin_kerja[$nip][$value_tanggal])){
                                                    $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['data'] = $list_disiplin_kerja[$nip][$value_tanggal];
                                                } else {
                                                    $list_pegawai[$nip]['rekap_absensi']['tk']++;
                                                    $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['data'] = 'A';   
                                                }
                                                break;
                                                // $list_pegawai[$nip]['rekap_absensi']['tmk3']++;
                                                // $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['keterangan'] = 'tmk3';
                                            } else {
                                                $list_pegawai[$nip]['rekap_absensi']['hadir']++;
                                                if($flag_jumat){
                                                    $jam_masuk = $data_jam_kerja['wfoj_masuk'];
                                                } else {
                                                    $jam_masuk = $data_jam_kerja['wfo_masuk'];
                                                }
                                                $diff = strtotime($value) - strtotime($jam_masuk);
                                                if($diff > 0){
                                                    $keterangan = floatval($diff) / 1800; // setengah jam lebih 59 detik
                                                    if($keterangan <= 1){
                                                        $list_pegawai[$nip]['rekap_absensi']['tmk1']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['keterangan'] = 'tmk1';
                                                    } else if($keterangan > 1 && $keterangan <= 2){
                                                        $list_pegawai[$nip]['rekap_absensi']['tmk2']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['keterangan'] = 'tmk2';
                                                    } else if($keterangan > 2){
                                                        $list_pegawai[$nip]['rekap_absensi']['tmk3']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['masuk']['keterangan'] = 'tmk3';
                                                    }
                                                }
                                            }
                                        } else if($col == 9 && $value_tanggal && !$flag_libur){ //absen keluar
                                            $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['data'] = $value;
                                            if($value == "00:00:00"){
                                                $list_pegawai[$nip]['rekap_absensi']['pksw3']++;
                                                $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['keterangan'] = 'pksw3';
                                            } else {
                                                if($flag_jumat){
                                                    $jam_keluar = $data_jam_kerja['wfoj_pulang'];
                                                } else {
                                                    $jam_keluar = $data_jam_kerja['wfo_pulang'];
                                                }
                                                $diff = strtotime($jam_keluar) - strtotime($value);
                                                if($diff > 0){
                                                    $keterangan = floatval($diff) / 1800; // setengah jam lebih 59 detik
                                                    if($keterangan <= 1){
                                                        $list_pegawai[$nip]['rekap_absensi']['pksw1']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['keterangan'] = 'pksw1';
                                                    } else if($keterangan > 1 && $keterangan <= 2){
                                                        $list_pegawai[$nip]['rekap_absensi']['pksw2']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['keterangan'] = 'pksw2';
                                                    } else if($keterangan > 2){
                                                        $list_pegawai[$nip]['rekap_absensi']['pksw3']++;
                                                        $list_pegawai[$nip]['absensi'][$value_tanggal]['pulang']['keterangan'] = 'pksw3';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                    }
                } else {
                    $rs['code'] = 1;
                    $rs['message'] = "File yang dipilih bukan file Excel atau CSV !";    
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = "Tidak ada file yang dipilih";
            }
            
            $temp_pegawai = null;
            $result = null;
            if($list_pegawai){
                $i = 0;
                $j = 0;
                foreach($list_pegawai as $p){
                    $temp = $p;
                    if($p['eselon'] != null){
                        $result[$i] = $temp;
                        $i++;
                    } else {
                        $temp_pegawai[$j] = $temp;
                        $j++;
                    }
                }
                if($temp_pegawai){
                    foreach($temp_pegawai as $t){
                        $result[$i] = $t;
                        $i++;
                    }
                }
                $list_pegawai = $result;
            }
            return $list_pegawai;
        }
    
    public function readAbsensiExcel(){
        $rs['code'] = 0;
        $rs['message'] = 0;
        $file_excel = array();
        $temp_data = null;
        $data = array();
        $jam_kerja = $this->db->select('*')
                            ->from('t_jam_kerja')
                            ->where('id', $this->input->post('jam_kerja'))
                            ->where('flag_active', 1)
                            ->get()->row_array();
        $data['jam_kerja'] = $jam_kerja;

        $hari_libur = $this->db->select('*')
                            ->from('t_hari_libur')
                            ->where('flag_active', 1)
                            ->where('flag_hari_libur_nasional', 1)
                            ->get()->result_array();
        $tmp_hari_libur = $hari_libur;
        if($tmp_hari_libur){
            $hari_libur = null;
            foreach($tmp_hari_libur as $h){
                $hari_libur[$h['tanggal']] = $h;
            }
        }

        $data['disiplin_kerja'] = $this->db->select('keterangan')
                                        ->from('m_jenis_disiplin_kerja')
                                        ->where('flag_active', 1)
                                        ->where_not_in('id', [7, 8, 9, 10, 11, 12])
                                        ->get()->result_array();

        if($_FILES["file_excel"]["name"] != ''){
            $allowed_extension = ['xls', 'csv', 'xlsx'];
            $file_array = explode(".", $_FILES["file_excel"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $config['upload_path'] = 'assets/upload_rekap_absen'; 
                $config['allowed_types'] = '*';
                $config['max_size'] = '5000'; // max_size in kb
                $config['file_name'] = $_FILES['file_excel']['name'];

                $this->load->library('upload', $config); 

                $uploadfile = $this->upload->do_upload('file_excel');

                if($uploadfile){
                    $upload_data = $this->upload->data(); 
                    $file_excel['name'] = $upload_data['file_name'];

                    $filename = $_FILES["file_excel"]["name"];
                    libxml_use_internal_errors(true);
                    // $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES["file_excel"]["name"]);
                    $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($config['upload_path'].'/'.$file_excel['name']);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                    $spreadsheet = $reader->load($_FILES["file_excel"]["tmp_name"]);
                    // $data = $spreadsheet->getActiveSheet()->toArray();

                    $data['skpd'] = $spreadsheet->getActiveSheet()->getCell(SKPD_CELL)->getValue();
                    $data['periode'] = $spreadsheet->getActiveSheet()->getCell(PERIODE_CELL)->getValue();
                    $data['nama_file'] = "Rekap Absensi ".$data['skpd']." ".$data['periode'].".xls";
                    $data['header'] = $spreadsheet->getActiveSheet()->rangeToArray(HEADER_CELL);
                    $start_cell = $spreadsheet->getActiveSheet()->getCell(START_CELL)->getValue();
                    $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                    $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                    
                    $periode = explode(" ", $data['periode']);
                    $date = explode("-", $periode[0]);
                    $bulan = $date[1];
                    $tahun = $date[2];
                    $list_hari = getDateBetweenDates($periode[0], $periode[2]);
                    $format_hari = null;
                    $uk = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where('nm_unitkerja', $data['skpd'])
                                ->get()->row_array(0);

                    $this->db->select('b.username as nip, a.tanggal, a.bulan, a.tahun, a.pengurangan, d.keterangan')
                            ->from('t_dokumen_pendukung a')
                            ->join('m_user b', 'a.id_m_user = b.id')
                            ->join('db_pegawai.pegawai c','b.username = c.nipbaru_ws')
                            ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                            ->where('a.bulan', floatval($bulan))
                            ->where('a.tahun', floatval($tahun))
                            ->where('a.flag_active', 1)
                            ->where('id_m_status_pegawai', 1)
                            ->where('a.status', 2);
                    if($uk){
                        $this->db->where('c.skpd', $uk['id_unitkerja']);
                    }
                    $tmp_dokpen = $this->db->get()->result_array();
                    $dokpen = null;
                    if($tmp_dokpen){
                        foreach($tmp_dokpen as $dok){
                            $tanggal_dok = $dok['tanggal'] < 10 ? '0'.$dok['tanggal'] : $dok['tanggal'];
                            $bulan_dok = $dok['bulan'] < 10 ? '0'.$dok['bulan'] : $dok['bulan'];
                            $date_dok = $dok['tahun'].'-'.$bulan_dok.'-'.$tanggal_dok;

                            $dokpen[$dok['nip']]['nip'] = $dok['nip'];
                            $dokpen[$dok['nip']][$date_dok] = $dok['keterangan'];
                        }
                    }

                    if($list_hari){
                        $i = 0;
                        foreach($list_hari as $lh){
                            $format_hari[$i]['tanggal'] = $lh;
                            $format_hari[$i]['jam_masuk'] = '';
                            $format_hari[$i]['jam_pulang'] = '';
                            if(getNamaHari($lh) != 'Jumat' && getNamaHari($lh) != 'Sabtu' && getNamaHari($lh) != 'Minggu'){
                                $format_hari[$i]['jam_masuk'] = $jam_kerja['wfo_masuk'];
                                $format_hari[$i]['jam_pulang'] = $jam_kerja['wfo_pulang'];
                            } else if(getNamaHari($lh) == 'Jumat'){
                                $format_hari[$i]['jam_masuk'] = $jam_kerja['wfoj_masuk'];
                                $format_hari[$i]['jam_pulang'] = $jam_kerja['wfoj_pulang'];
                            } 
                            $i++;
                        }
                    }
                    for($row = START_ROW_NUM; $row <= $highestRow; $row++){
                        $i = 0;
                        $temp_data[$row]['rekap']['tmk1'] = 0;
                        $temp_data[$row]['rekap']['tmk2'] = 0;
                        $temp_data[$row]['rekap']['tmk3'] = 0;
                        $temp_data[$row]['rekap']['pksw1'] = 0;
                        $temp_data[$row]['rekap']['pksw2'] = 0;
                        $temp_data[$row]['rekap']['pksw3'] = 0;
                        $temp_data[$row]['rekap']['TK'] = 0;
                        $temp_data[$row]['rekap']['jhk'] = 0;
                        $temp_data[$row]['rekap']['hadir'] = 0;
                        if($data['disiplin_kerja']){
                            foreach($data['disiplin_kerja'] as $dk){
                                $temp_data[$row]['rekap'][$dk['keterangan']] = 0;
                            }
                        }
                        for($col = 2; $col <= $highestColumnIndex; $col++){
                            $value = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
                            if($value){
                                if($col == 2){
                                    $temp_data[$row]['nama_pegawai'] = $value; 
                                } else if($col == 3){
                                    $temp_data[$row]['nip'] = $value;
                                    $nip = $value;
                                } else {
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_pulang'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_masuk'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = '';
                                    $tanggal = $format_hari[$i]['tanggal'];
                                    if($value == 'A'){
                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = 'A';
                                        if(isset($dokpen[$temp_data[$row]['nip']][$format_hari[$i]['tanggal']])){
                                            $text = $dokpen[$temp_data[$row]['nip']][$format_hari[$i]['tanggal']];
                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = $text;
                                            if(isset($temp_data[$row]['rekap'][$text])){
                                                $temp_data[$row]['rekap'][$text]++;
                                            }
                                        }
                                    } else if(isset($hari_libur[$format_hari[$i]['tanggal']])){
                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = '-';
                                    } else if(getNamaHari($format_hari[$i]['tanggal']) == 'Sabtu' || getNamaHari($format_hari[$i]['tanggal']) == 'Minggu'){
                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = '-';
                                    } else {
                                        $temp_data[$row]['rekap']['jhk']++;
                                        $jam_absen = explode(" ", $value);
                                        if(count($jam_absen) > 1){
                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = $jam_absen[0];
                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_pulang'] = $jam_absen[2];
                                            if($jam_absen[0] == '00:00'){
                                                $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = 'A';
                                                $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = 'A';
                                                $temp_data[$row]['rekap']['TK']++;
                                            } else {
                                                $temp_data[$row]['rekap']['hadir']++;
                                                $diff_masuk = strtotime(trim($jam_absen[0])) - strtotime($format_hari[$i]['jam_masuk'].'+ 59 seconds');
                                                if($diff_masuk > 0){
                                                    $ket_masuk = floatval($diff_masuk) / 1800;
                                                    if($ket_masuk <= 1){
                                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_masuk'] = 'tmk1';
                                                        $temp_data[$row]['rekap']['tmk1']++;
                                                    } else if($ket_masuk > 1 && $ket_masuk <= 2){
                                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_masuk'] = 'tmk2';
                                                        $temp_data[$row]['rekap']['tmk2']++;
                                                    } else if($ket_masuk > 2) {
                                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_masuk'] = 'tmk3';
                                                        $temp_data[$row]['rekap']['tmk3']++;
                                                    }
                                                }
                                                
                                                if($jam_absen[2] == "00:00"){
                                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = 'pksw3';
                                                    $temp_data[$row]['rekap']['pksw3']++;
                                                } else {
                                                    $diff_pulang = strtotime($format_hari[$i]['jam_pulang']) - strtotime($jam_absen[2]);
                                                    if($diff_pulang > 0){
                                                        $ket_pulang = floatval($diff_pulang) / 1800;
                                                        if($ket_pulang <= 1){
                                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = 'pksw1';
                                                            $temp_data[$row]['rekap']['pksw1']++;
                                                        } else if($ket_pulang > 1 && $ket_pulang <= 2){
                                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = 'pksw2';
                                                            $temp_data[$row]['rekap']['pksw2']++;
                                                        } else if($ket_pulang > 2) {
                                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = 'pksw3';
                                                            $temp_data[$row]['rekap']['pksw3']++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $i++;
                                }
                            } else {
                                unset($temp_data[$row]);
                                break;
                            }
                        }
                    }
                    $data['result'] = $temp_data;
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = "File yang dipilih bukan file Excel atau CSV !";    
            }
        } else {
            $rs['code'] = 1;
            $rs['message'] = "Tidak ada file yang dipilih";
        }
        return $data;
    }

    public function readAbsensiExcelNew(){
        $rs['code'] = 0;
        $rs['message'] = 0;
        $file_excel = array();
        $temp_data = null;
        $data = array();

        if($_FILES["file_excel"]["name"] != ''){
            $allowed_extension = ['xls', 'csv', 'xlsx'];
            $file_array = explode(".", $_FILES["file_excel"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $config['upload_path'] = 'assets/upload_rekap_absen'; 
                $config['allowed_types'] = '*';
                $config['max_size'] = '5000'; // max_size in kb
                $config['file_name'] = $_FILES['file_excel']['name'];

                $this->load->library('upload', $config); 

                $uploadfile = $this->upload->do_upload('file_excel');

                if($uploadfile){
                    $upload_data = $this->upload->data(); 
                    $file_excel['name'] = $upload_data['file_name'];

                    $filename = $_FILES["file_excel"]["name"];
                    libxml_use_internal_errors(true);
                    // $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES["file_excel"]["name"]);
                    $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($config['upload_path'].'/'.$file_excel['name']);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                    $spreadsheet = $reader->load($_FILES["file_excel"]["tmp_name"]);
                    // $data = $spreadsheet->getActiveSheet()->toArray();

                    $data['skpd'] = $spreadsheet->getActiveSheet()->getCell(SKPD_CELL)->getValue();
                    $data['periode'] = $spreadsheet->getActiveSheet()->getCell(PERIODE_CELL)->getValue();
                    $data['nama_file'] = "Rekap Absensi ".$data['skpd']." ".$data['periode'].".xls";
                    $data['header'] = $spreadsheet->getActiveSheet()->rangeToArray(HEADER_CELL);
                    $start_cell = $spreadsheet->getActiveSheet()->getCell(START_CELL)->getValue();
                    $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                    $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                    
                    $periode = explode(" ", $data['periode']);
                    $date = explode("-", $periode[0]);
                    $bulan = $date[1];
                    $tahun = $date[2];
                    $data['bulan'] = $bulan;
                    $data['tahun'] = $tahun;
                    $list_hari = getDateBetweenDates($periode[0], $periode[2]);
                    $format_hari = null;
                    $data['unitkerja'] = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where('nm_unitkerja', $data['skpd'])
                                ->get()->row_array(0);

                    if($list_hari){
                        $i = 0;
                        foreach($list_hari as $lh){
                            $format_hari[$i]['tanggal'] = $lh;
                            $i++;
                        }
                    }
                    for($row = START_ROW_NUM; $row <= $highestRow; $row++){
                        $i = 0;
                        for($col = 2; $col <= $highestColumnIndex; $col++){
                            $value = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
                            if($value){
                                if($col == 2){
                                    $temp_data[$row]['nama_pegawai'] = $value; 
                                } else if($col == 3){
                                    $temp_data[$row]['nip'] = $value;
                                    $nip = $value;
                                } else {
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_pulang'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_masuk'] = '';
                                    $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket_pulang'] = '';
                                    $tanggal = $format_hari[$i]['tanggal'];
                                    if($value == 'A'){
                                        $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = 'A';
                                    } else {
                                        $jam_absen = explode(" ", $value);
                                        if(count($jam_absen) > 1){
                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = $jam_absen[0];
                                            $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_pulang'] = $jam_absen[2];
                                            if($jam_absen[0] == '00:00'){
                                                $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['ket'] = 'A';
                                                $temp_data[$row]['absen'][$format_hari[$i]['tanggal']]['jam_masuk'] = 'A';
                                            } 
                                        }
                                    }
                                    $i++;
                                }
                            } else {
                                unset($temp_data[$row]);
                                break;
                            }
                        }
                    }
                    $data['result'] = $temp_data;
                }
            } else {
                $rs['code'] = 1;
                $rs['message'] = "File yang dipilih bukan file Excel atau CSV !";    
            }
        } else {
            $rs['code'] = 1;
            $rs['message'] = "Tidak ada file yang dipilih";
        }
        return $data;
    }

    public function getKelasJabatanPegawai($data){
        $i = 0;
        $result = null;
        foreach($data as $d){
            $result[$i] = $d;
            $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_jfu'];
            if($d['jenis_jabatan'] == 'JFT'){ // jika JFT
                if($this->general_library->isProgrammer()){
                    if(!isset($d['nm_unitkerja'])){
                        dd($d);
                    }
                }
                $result[$i]['kelas_jabatan'] = $d['kelas_jabatan'];
                if(stringStartWith('Puskesmas', $d['nm_unitkerja'])){
                    $result[$i]['kelas_jabatan'] = $d['kelas_jabatan'];
                    $explode_nama_jabatan = explode(" ", $d['nama_jabatan']);
                    $list_selected_jf = ['Pertama', 'Muda', 'Penyelia', 'Terampil', 'Madya', 'Utama', 'Lanjutan', 'Pelaksana', 'Mahir'];
                    if(!in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], $list_selected_jf) 
                    && (!stringStartWith('Kepala Puskesmas', $d['nama_jabatan']) && !stringStartWith('Plh. Kepala Puskesmas', $d['nama_jabatan']) && !stringStartWith('Plt. Kepala Puskesmas', $d['nama_jabatan']))){
                        // $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_jft'];
                        $result[$i]['kelas_jabatan'] = 7;
                    }
                } else if(in_array($d['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){ //jika guru
                    $result[$i]['kelas_jabatan'] = $d['kelas_jabatan'];
                    $explode_nama_jabatan = explode(" ", $d['nama_jabatan']);
                    $list_selected_jf = ['Pertama', 'Muda', 'Penyelia', 'Terampil', 'Madya', 'Utama', 'Lanjutan', 'Pelaksana', 'Mahir'];
                    if(!in_array($explode_nama_jabatan[count($explode_nama_jabatan)-1], $list_selected_jf) ){
                        $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_jft'];
                        if($d['kelas_jabatan_jft'] > 7){
                            $result[$i]['kelas_jabatan'] = 7;
                        }
                    }
                }

                if(isset($d['id_jabatan_tambahan']) && $d['id_jabatan_tambahan']){ // jika ada jabatan tambahan
                    if(isset($d['nama_jabatan_tambahan'])){
                        if(stringStartWith("Kepala Puskesmas", $d['nama_jabatan_tambahan'])){ // jika Kepala Puskesmas
                            $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_tambahan'];
                        }

                        if(stringStartWith("Kepala Sekolah", $d['nama_jabatan_tambahan'])){
                            $result[$i]['kelas_jabatan'] = $d['kelas_jabatan'];
                        }
                    }
                }
    
                if(isset($d['statuspeg']) && $d['statuspeg'] == 1){ // jika CPNS
                    $result[$i]['kelas_jabatan'] = 7;
                }
            } else if($d['jenis_jabatan'] == 'Struktural'){
                $result[$i]['kelas_jabatan'] = $d['kelas_jabatan'];
            } else if($d['jenis_jabatan'] == 'JFU'){
                $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_jfu'];
                if($result[$i]['kelas_jabatan'] > 7){
                    $result[$i]['kelas_jabatan'] = 7; // tahun 2025, semua JFU kelas jabatan 7
                }
            }

            if(isset($d['kelas_jabatan_hardcode']) && $d['kelas_jabatan_hardcode'] != null && $d['kelas_jabatan_hardcode'] != 0){
                $result[$i]['kelas_jabatan'] = $d['kelas_jabatan_hardcode'];
            }
            
            // if($this->general_library->isProgrammer()){
            //     if($d['nip'] == '198204182011022001'){
            //         dd($result[$i]);
            //     }
            // }

            $i++;
        }
        return $result;
    }

    public function lockTpp($param, $data){
        // if($this->general_library->isProgrammer()){
        //     dd($data);
        // }

        $skpd = explode(";", $data['orgiginal_id_unitkerja']);
        $param['id_unitkerja'] = $skpd[0];

        unset($param['nm_unitkerja']);
        $param['created_by'] = $this->general_library->getId();

        $today = date("Y-m-d");
        $explode = explode('-', $today);
        $date_param = date("Y-m-01", strtotime($param['tahun'].'-'.$param['bulan'].'-01'));
        $date_today = date("Y-m-01", strtotime($explode[0].'-'.$explode[1].'-01'));
        // jika tanggal hari ini belum lewat bulan tarik TPP, maka jangan dulu lock. khusus desember 2025, di comment dulu untuk dilock.
        // if($date_param >= $date_today){
        //     return null;
        // }
        
        $param['meta_data'] = json_encode($data);
        $param['nama_param_unitkerja'] = $data['param']['nm_unitkerja'];

        $exists = $this->db->select('*')
                        ->from('t_lock_tpp')
                        ->where('id_unitkerja', $param['id_unitkerja'])
                        ->where('bulan', $param['bulan'])
                        ->where('tahun', $param['tahun'])
                        // ->where('flag_active', 1)
                        ->get()->row_array();

        if($exists){
            // ganti created_by jadi updated_by supaya dapa tau sapa yang tarek dan yg tarek pertama tetap dapa tau
            $param['updated_by'] = $param['created_by'];
            $param['flag_active'] = 1;
            unset($param['created_by']);
            if($exists['flag_use_this'] == 0){
                $this->db->where('id', $exists['id'])
                        ->update('t_lock_tpp', $param);
            }
            // dd($param);
        } else {
            $this->db->insert('t_lock_tpp', $param);
        }
    }

    public function getDataPenandatangananBerkasTpp($id_unitkerja, $bulan, $tahun){
        $result['kepalaskpd'] = null;
        $result['kasubag'] = null;
        $result['bendahara'] = null;
        $result['kepsek'] = null;
        $result['kapus'] = null;
        $result['sek'] = null;
        $result['flag_sekolah'] = 0;
        $result['flag_puskesmas'] = 0;
        $result['flag_bagian'] = 0;
        $result['setda'] = 0;
        $result['bendahara_setda'] = 0;
        $result['kadis'] = 0;
        $result['flag_rs'] = 0;

        if($id_unitkerja == '7000096'){ // Sanggar Kegiatan Belajar
            $id_unitkerja = '3010000';
        }

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $id_unitkerja)
                            ->get()->row_array();

        // if($unitkerja['nip_kepalaskpd_hardcode']){
        //     $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
        //                         e.nama_jabatan, e.kepalaskpd, e.eselon, d.id_unitkerjamaster')
        //                         ->from('db_pegawai.pegawai a')
        //                         ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
        //                         ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
        //                         ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
        //                         ->join('m_user e', 'a.nipbaru_ws = e.username')
        //                         ->where('a.nipbaru_ws', $unitkerja['nip_kepalaskpd_hardcode'])
        //                         ->get()->row_array();

        //     $result['kepalaskpd']['nama_jabatan'] = $unitkerja['nama_jabatan_kepalaskpd_hardcode'];
        // }

        // $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
        // g.id as id_m_user, a.flag_bendahara, e.flag_uptd,
        // TRIM(
        //     CONCAT(
        //     IF( a.statusjabatan = 2, "Plt. ", IF(a.statusjabatan = 3, "Plh. ", "")) 
        //     ," ", e.nama_jabatan)
        // ) AS nama_jabatan,
        // e.kepalaskpd, e.eselon, d.id_unitkerjamaster, f.nama_jabatan as nama_jabatan_tambahan, f.kelas_jabatan as kelsa_jabatan_tambahan, f.kepalaskpd as kepalaskpd_tambahan')
        $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
        g.id as id_m_user, a.flag_bendahara, e.flag_uptd, e.nama_jabatan,
        e.kepalaskpd, e.eselon, d.id_unitkerjamaster, f.nama_jabatan as nama_jabatan_tambahan, f.kelas_jabatan as kelas_jabatan_tambahan, f.kepalaskpd as kepalaskpd_tambahan')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                            ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                            ->join('db_pegawai.jabatan f', 'a.id_jabatan_tambahan = f.id_jabatanpeg', 'left')
                            ->join('m_user g', 'a.nipbaru_ws = g.username')
                            ->where('g.flag_active', 1)
                            // ->where('e.kepalaskpd', 1)
                            ->where('a.skpd', $id_unitkerja)
                            ->where('id_m_status_pegawai', 1)
                            ->order_by('a.nama', 'asc');
        // if(in_array($id_unitkerja, LIST_UNIT_KERJA_KECAMATAN_NEW)){
        //     $this->db->where('d.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else {
        //     $this->db->where('a.skpd', $id_unitkerja);
        // }
        $list_pegawai = $this->db->get()->result_array();

        foreach($list_pegawai as $lp){
            if(stringStartWith('Kepala Sekolah', $lp['nama_jabatan']) ||
                stringStartWith('Kepala Sekolah', $lp['nama_jabatan_tambahan'])
            ){ // jika sekolah
                $result['kepsek'] = $lp;
                $result['kepsek']['nama_jabatan'] = $lp['nama_jabatan_tambahan'];
                $result['flag_sekolah'] = 1;
            }

            if($lp['kepalaskpd'] == 1 && $result['kepalaskpd'] == null){
                if(stringStartWith('Puskesmas', $unitkerja['nm_unitkerja'])){ // jika puskes
                    $result['kapus'] = $lp;
                    $result['flag_puskesmas'] = 1;
                } else if(stringStartWith('Rumah Sakit', $unitkerja['nm_unitkerja'])){ // jika RS
                    $result['kadis'] = $lp;
                    $result['flag_rs'] = 1;
                } else {
                    $result['kepalaskpd'] = $lp;
                }
            }

            if($lp['flag_bendahara'] == 1){
                $result['bendahara'] = $lp;
            }

            if(isKasubKepegawaian($lp['nama_jabatan'], $lp['eselon']) && $lp['flag_uptd'] == 0){
                // if($id_unitkerja == 3014000){
                //     if($lp['nipbaru_ws'] == '198304212010012005'){
                //         $result['kasubag'] = $lp;
                //         // dd($result['kasubag']);
                //     }
                // } else {
                    $result['kasubag'] = $lp;
                // }
            }

            if(stringStartWith('Sekretaris', $lp['nama_jabatan'])){
                $result['sek'] = $lp;
            }
        }

        $list_pegawai_unor_induk = null;
        if(in_array($unitkerja['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){ // jika sekolah, cari kepalaskpd, bendahara dan kasubag umum di diknas
            $result['flag_sekolah'] = 1;
            $list_pegawai_unor_induk = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                f.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                ->join('m_user f', 'a.nipbaru_ws = f.username')
                                ->where('f.flag_active', 1)
                                ->where('a.skpd', 3010000)
                                ->order_by('a.nama', 'asc')
                                ->where('id_m_status_pegawai', 1)
                                ->get()->result_array();
        } else if(stringStartWith('Puskesmas', $unitkerja['nm_unitkerja'])){ // jika puskes, cari kepalaskpd, bendahara dan kasubag umum di dinkes
            $result['flag_puskesmas'] = 1;
            $list_pegawai_unor_induk = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                f.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                ->join('m_user f', 'a.nipbaru_ws = f.username')
                                ->where('e.flag_active', 1)
                                ->where('a.skpd', 3012000)
                                ->order_by('a.nama', 'asc')
                                ->where('id_m_status_pegawai', 1)
                                ->get()->result_array();
        } else if($unitkerja['id_unitkerjamaster'] == 2000000 || $unitkerja['id_unitkerjamaster'] == 1000000){ // jika bagian, flag_bagian = 1
            $result['flag_bagian'] = 1;
                $result['setda'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                    f.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                        ->from('db_pegawai.pegawai a')
                                        ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                        ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                        ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                        ->join('m_user f', 'a.nipbaru_ws = f.username')
                                        // ->where('e.nama_jabatan', 'Sekretaris Daerah')
                                        ->where('a.nipbaru_ws', '197409262002121007')
                                        ->where('id_m_status_pegawai', 1)
                                        ->get()->row_array();

                $result['setda']['nama_jabatan'] = "Sekretaris Daerah";

                // $result['setda'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                //     f.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                //                         ->from('db_pegawai.pegawai a')
                //                         ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                //                         ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                //                         ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                //                         ->join('m_user f', 'a.nipbaru_ws = f.username')
                //                         ->where('e.nama_jabatan', 'Sekretaris Daerah')
                //                         ->where('id_m_status_pegawai', 1)
                //                         ->get()->row_array();

                $result['bendahara_setda'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                    f.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user f', 'a.nipbaru_ws = f.username')
                                    ->where('a.nipbaru_ws', '197403302007012022')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

            if($unitkerja['id_unitkerja'] == 1000001  //jika staf ahli / setda / prtokol, bendaharanya Marie Marce Kolopita 
            || $unitkerja['id_unitkerja'] == 2000100
            || $unitkerja['id_unitkerja'] == 1010500){
                $result['bendahara'] = $result['bendahara_setda'];
                if($unitkerja['id_unitkerja'] == 2000100){ //jika staf ahli, cari setda
                    $result['kepalaskpd'] = $result['setda'];
                }
            }
        } else { //jika dinas atau badan
            if(!$result['kasubag'] || !$result['kepalaskpd']){ // jika kasubag atau kepalaskpd kosong
                // cek di plt plh
                $list_plt =  $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                        f.id as id_m_user, a.flag_bendahara, h.nama_jabatan, h.kepalaskpd, h.eselon, g.jenis')
                                        ->from('db_pegawai.pegawai a')
                                        ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                        ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                        ->join('m_user f', 'a.nipbaru_ws = f.username')
                                        ->join('t_plt_plh g', 'f.id = g.id_m_user')
                                        ->join('db_pegawai.jabatan h', 'g.id_jabatan = h.id_jabatanpeg')
                                        ->where('a.skpd', $unitkerja['id_unitkerja'])
                                        // ->where('e.nama_jabatan', 'Sekretaris Daerah')
                                        ->where('id_m_status_pegawai', 1)
                                        ->where('g.tanggal_akhir >=', $tahun.'-'.$bulan.'-30')
                                        // ->where('g.tanggal_mulai <=', date('Y-m-d'))
                                        ->get()->result_array();
                // dd($list_plt);
                if($list_plt){
                    foreach($list_plt as $plt){
                        if(isKasubKepegawaian($plt['nama_jabatan'], $plt['eselon'])){
                            $result['kasubag'] = $plt;
                            $result['kasubag']['nama_jabatan'] = $plt['jenis'].'. '.$plt['nama_jabatan'];
                        } else if($plt['kepalaskpd'] == 1 && !$result['kepalaskpd']){
                            $result['kepalaskpd'] = $plt;
                            $result['kepalaskpd']['nama_jabatan'] = $plt['jenis'].'. '.$plt['nama_jabatan'];
                        }
                    }
                }
                
                if(!$result['kasubag']){ //jika masih kosong, ambil sek
                    $result['kasubag'] = $result['sek'];
                }
            }
        }

        // khusus dinkes, rs dan puskes
        if($id_unitkerja == 3012000 
        || stringStartWith('Puskesmas', $unitkerja['nm_unitkerja'])
        || $id_unitkerja == 6160000
        || $id_unitkerja == 7005020
        || $id_unitkerja == 7005010){
            if(stringStartWith('Puskesmas', $unitkerja['nm_unitkerja'])){
                $result['flag_puskesmas'] = 1;
            } 
            // jika dinkes, puskes dan instalasi farmasi, ambil bendahara hardocde yang ada
            $result['bendahara'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    ->where('a.nipbaru_ws', '198811072010012001')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array(); 

            $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                f.id as id_m_user, a.flag_bendahara,
                e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user f', 'a.nipbaru_ws = f.username')
                                    ->where('a.nipbaru_ws', '198505302005011001')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();
            $result['kepalaskpd']['nama_jabatan'] = "Kepala Dinas Kesehatan";
            // kasubag ambil sek krna kasubag smntra cuti
            if($id_unitkerja != 7005020
            && $id_unitkerja != 7005010){
                $result['kasubag'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    // ->where('a.nipbaru_ws', '197205032000032006')
                                    ->where('a.nipbaru_ws', '198604132010012005')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

            }
        }

        //coding ini untuk mengubah penandatangan menjadi hardcode
        if($id_unitkerja == 3016000 || // dishub, kasub sudah pensiun
        $id_unitkerja == 3015000 || // capil, kasub sudah pensiun 
        // $id_unitkerja == 3017000 || // kominfo, kasub cuti
        $id_unitkerja == 3020000){ //diskop, kasub sudah pensiun
            $result['kasubag'] = $result['sek'];
        } else if($id_unitkerja == 4014000){
            $result['kasubag'] = $result['sek']; // kesbang, kasub ubah jadi sek karena kasubnya ba jadi
        } else if($id_unitkerja == 3028000){ // dinas pangan, kasub dan sek sudah pensiun ganti jadi kabid
            $result['kasubag'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                    e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    ->where('a.nipbaru_ws', '196903102002122007')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

        } else if($id_unitkerja == 5004001){ // wenang
            $result['sek'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                    e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    ->where('a.nipbaru_ws', '199404082016091003')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

            $result['sek']['nama_jabatan'] = "Sekretaris Kecamatan";
        } else if($id_unitkerja == 5007001){ // kec. wanea
            $result['kasubag'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                    e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    ->where('a.nipbaru_ws', '198111192006041012')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

            $result['kasubag']['nama_jabatan'] = "Kepala Sub Bagian Umum dan Kepegawaian"; 
        } else if($id_unitkerja == 1010200){ // kesra
            $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                    e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                    ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                    ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                    ->join('m_user e', 'a.nipbaru_ws = e.username')
                                    ->where('a.nipbaru_ws', '197101032009021001')
                                    ->where('id_m_status_pegawai', 1)
                                    ->get()->row_array();

            $result['kepalaskpd']['nama_jabatan'] = "Kepala Bagian Kerja Sama"; 
        } else if($result['flag_sekolah'] == 1){ // sekolah
            $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                            e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                            ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                            ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                            ->join('m_user e', 'a.nipbaru_ws = e.username')
                            ->where('a.nipbaru_ws', '196705151994031003')
                            ->where('id_m_status_pegawai', 1)
                            ->get()->row_array();
            $result['kepalaskpd']['nama_jabatan'] = "Kepala Dinas Pendidikan dan Kebudayaan"; 
        }
        // else if($id_unitkerja == 3012000){ // dinkes
        //     $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
        //                     e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
        //                     ->from('db_pegawai.pegawai a')
        //                     ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
        //                     ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
        //                     ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
        //                     ->join('m_user e', 'a.nipbaru_ws = e.username')
        //                     ->where('a.nipbaru_ws', '198505302005011001')
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->get()->row_array();
        //     $result['kepalaskpd']['nama_jabatan'] = "Plt. Kepala Dinas Kesehatan";
        // } else if($result['flag_puskesmas'] == 1){ // puskes
        //     $result['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
        //                     e.id as id_m_user, a.flag_bendahara, e.nama_jabatan, e.kepalaskpd')
        //                     ->from('db_pegawai.pegawai a')
        //                     ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
        //                     ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
        //                     ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
        //                     ->join('m_user e', 'a.nipbaru_ws = e.username')
        //                     ->where('a.nipbaru_ws', '198505302005011001')
        //                     ->where('id_m_status_pegawai', 1)
        //                     ->get()->row_array();
        //     $result['kepalaskpd']['nama_jabatan'] = "Plt. Kepala Dinas Kesehatan";
        // }
        
        $listUkerTempKasubKepeg = [
            5004001,
            // 5007001,
            4014000,
            3028000,
            // 3014000,
            // 3010000
        ];
        if(in_array($id_unitkerja, $listUkerTempKasubKepeg)){
            $result['kasubag'] = $result['sek'];
        }

        if($list_pegawai_unor_induk){
            foreach($list_pegawai_unor_induk as $lpd){
                if($lpd['kepalaskpd'] == 1 && $result['kepalaskpd'] == null){
                    $result['kepalaskpd'] = $lpd;
                }
                if($lpd['flag_bendahara'] == 1){
                    $result['bendahara'] = $lpd;
                }
                if(isKasubKepegawaian($lpd['nama_jabatan'])){
                    if($id_unitkerja == 3012000 
                    || stringStartWith('Puskesmas', $unitkerja['nm_unitkerja'])
                    || $id_unitkerja == 6160000
                    // || $id_unitkerja == 7005020
                    // || $id_unitkerja == 7005010
                    ){ 

                    } else {
                        $result['kasubag'] = $lpd;
                    }
                }
            }
        }

        if($unitkerja['nip_kepalaskpd_hardcode']){
            $tempresult['kepalaskpd'] = $this->db->select('a.nipbaru, a.nama, a.gelar1, a.gelar2, b.nm_pangkat, a.tmtpangkat, a.tmtcpns, d.nm_unitkerja, a.nipbaru_ws,
                                e.nama_jabatan, e.kepalaskpd, e.eselon, d.id_unitkerjamaster')
                                ->from('db_pegawai.pegawai a')
                                ->join('db_pegawai.pangkat b', 'a.pangkat = b.id_pangkat')
                                ->join('db_pegawai.unitkerja d', 'a.skpd = d.id_unitkerja')
                                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                                ->join('m_user e', 'a.nipbaru_ws = e.username')
                                ->where('a.nipbaru_ws', $unitkerja['nip_kepalaskpd_hardcode'])
                                ->get()->row_array();

            $tempresult['kepalaskpd']['nama_jabatan'] = $unitkerja['nama_jabatan_kepalaskpd_hardcode'];

            if($result['flag_puskesmas'] == 1){
                $result['kapus'] = $tempresult['kepalaskpd'];
                $result['kapus']['nama_jabatan'] = $tempresult['kepalaskpd']['nama_jabatan'];
            } else if($result['flag_sekolah'] == 1){
                $result['kepsek'] = $tempresult['kepalaskpd'];
                $result['kepsek']['nama_jabatan'] = $tempresult['kepalaskpd']['nama_jabatan'];
            } else {
                if(!$result['kepalaskpd']){
                    $result['kepalaskpd'] = $tempresult['kepalaskpd'];
                    $result['kepalaskpd']['nama_jabatan'] = $tempresult['kepalaskpd']['nama_jabatan'];
                }
            }
        }

        if($this->general_library->isProgrammer()){
            // dd($result);
        }

        return $result;
    }

    public function getDaftarPenilaianTpp($data_disiplin, $param, $flag_rekap_tpp = 0){
        $result = null;
        $skpd = explode(";", $param['skpd']);
        $uksearch = null;

        $temp_list_nip = null;
        foreach($data_disiplin['result'] as $dd){
            $temp_list_nip[] = isset($dd['nip']) ? $dd['nip'] : $dd['nipbaru_ws'];
        }
        
        if($flag_rekap_tpp == 1){
            $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerja', $skpd[0])
                                    ->get()->row_array();
        }
        $this->db->select('a.*, c.nipbaru_ws')
                ->from('t_komponen_kinerja as a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                ->where('a.bulan', $param['bulan'])
                ->where('a.tahun', $param['tahun'])
                ->where('c.id_m_status_pegawai', '1')
                ->where_in('c.nipbaru_ws', $temp_list_nip)
                ->where('a.flag_active', 1);
        // if($flag_rekap_tpp == 1 && in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
        //     $this->db->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
        //                 ->where('d.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else {
        //     $this->db->where('c.skpd', $skpd[0]);
        // }         
        $list_komponen_kinerja = $this->db->get()->result_array();
        $komponen_kinerja = null;
        if($list_komponen_kinerja){
            foreach($list_komponen_kinerja as $lkk){
                if(isset($data_disiplin['result'][$lkk['nipbaru_ws']])){
                    $data_disiplin['result'][$lkk['nipbaru_ws']]['komponen_kinerja'] = countNilaiKomponen($lkk);
                    $data_disiplin['result'][$lkk['nipbaru_ws']]['komponen_kinerja']['list'] = $lkk;
                }
                // $komponen_kinerja[$lkk['nipbaru_ws']] = countNilaiKomponen($lkk);
            }
        }
        // $result['komponen_kinerja'] = $komponen_kinerja;
        // $list_kinerja = $this->db->select('c.nipbaru_ws, d.realisasi_target_kuantitas, b.id as id_m_user, a.total_realisasi, a.id, a.target_kuantitas')
        $this->db->select('c.nipbaru_ws, b.id, a.*, a.id as id_t_rencana_kinerja')
                        ->from('t_rencana_kinerja a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('a.bulan', $param['bulan'])
                        ->where('a.tahun', $param['tahun'])
                        // ->where('c.skpd', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->where('c.id_m_status_pegawai', '1')
                        ->where_in('c.nipbaru_ws', $temp_list_nip)
                        ->group_by('a.id');

        // if($flag_rekap_tpp == 1 && in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
        //     $this->db->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
        //                 ->where('d.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else {
        //     $this->db->where('c.skpd', $skpd[0]);
        // } 
        
        $list_rencana_kinerja = $this->db->get()->result_array();
        $list_kinerja = null;
        if($list_rencana_kinerja){
            foreach($list_rencana_kinerja as $lrk){
                $list_kinerja[$lrk['id_t_rencana_kinerja']] = $lrk;
                $list_kinerja[$lrk['id_t_rencana_kinerja']]['total_realisasi_kinerja'] = 0;
            }
        }

        $this->db->select('a.*')
                        ->from('t_kegiatan a')
                        ->join('t_rencana_kinerja b', 'a.id_t_rencana_kinerja = b.id')
                        ->join('m_user c', 'a.id_m_user = c.id')
                        ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                        ->where('b.bulan', $param['bulan'])
                        ->where('b.tahun', $param['tahun'])
                        ->where('b.flag_active', 1)
                        ->where('d.id_m_status_pegawai', '1')
                        // ->where('b.id', 37851)
                        ->where('a.status_verif', 1)
                        ->where('b.flag_active', 1)
                        ->where('a.flag_active', 1)
                        ->where_in('d.nipbaru_ws', $temp_list_nip)
                        ->group_by('a.id');
        // if($flag_rekap_tpp == 1 && in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
        //     $this->db->join('db_pegawai.unitkerja e', 'd.skpd = e.id_unitkerja')
        //                 ->where('e.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else {
        //     $this->db->where('d.skpd', $skpd[0]);
        // }
        $list_realisasi = $this->db->get()->result_array();        
        if($list_realisasi){
            foreach($list_realisasi as $lr){
                // $list_kinerja[$lr['id_t_rencana_kinerja']]['kinerja'][] = $lr;
                $list_kinerja[$lr['id_t_rencana_kinerja']]['total_realisasi_kinerja'] += $lr['realisasi_target_kuantitas'];
            }
        }

        $kinerja = null;
        if($list_kinerja){
            foreach($list_kinerja as $lk){
                if(!isset($kinerja[$lk['nipbaru_ws']])){
                    $kinerja[$lk['nipbaru_ws']] = $lk;
                }

                if(!isset($kinerja[$lk['nipbaru_ws']]['kinerja'][$lk['id']])){
                    $kinerja[$lk['nipbaru_ws']]['kinerja'][$lk['id']] = $lk;

                    $kinerja[$lk['nipbaru_ws']]['kinerja'][$lk['id']]['target_kuantitas'] = $lk['target_kuantitas'];
                    $kinerja[$lk['nipbaru_ws']]['kinerja'][$lk['id']]['realisasi'] = $lk['total_realisasi_kinerja'];
                }

                $kinerja[$lk['nipbaru_ws']]['rekap_kinerja'] = countNilaiSkp($kinerja[$lk['nipbaru_ws']]['kinerja']);

                $data_disiplin['result'][$lk['nipbaru_ws']]['kinerja'] = $kinerja[$lk['nipbaru_ws']];
            }
        }
        // if($skpd[0] == 5010001){
        //     dd($data_disiplin);
        // }
        return $data_disiplin;
    }

    public function getNominatifPegawaiHardCode($id_unitkerja, $bulan, $tahun, $list_pegawai){
    // dd($id_unitkerja);
        $firstSixCharacters = substr($id_unitkerja, 0, 6);
         if($firstSixCharacters == 'sekola'){
           $id_unitkerja = substr($id_unitkerja, 8);
         }
         
        $flag_sekolah_kecamatan = 0;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        if($bulan == null){
            $bulan = date('m');
        }

        if($tahun == null){
            $tahun = date('Y');
        }

        $temp_list_pegawai = null;
        foreach($list_pegawai as $lp){
            $nip = isset($lp['nipbaru_ws']) ? $lp['nipbaru_ws'] : $lp['nip'];
            $temp_list_pegawai[$nip] = $lp;
        }

        $uk = $this->db->select('*')
                    ->from('db_pegawai.unitkerja')
                    ->where('id_unitkerja', $id_unitkerja)
                    ->get()->row_array();
        
        if(!$uk){
            $uk = $this->db->select('*')
                            ->from('db_pegawai.unitkerjamaster')
                            ->where('id_unitkerjamaster', $id_unitkerja)
                            ->get()->row_array();
            if($uk){
                $flag_sekolah_kecamatan = 1;
            }
        }

        $this->db->select('d.nipbaru_ws, d.nama, d.gelar1, d.gelar2, e.nm_pangkat, g.kelas_jabatan_jfu, g.kelas_jabatan_jft, i.nm_statuspeg,
            b.kelas_jabatan, e.id_pangkat, b.kepalaskpd, b.prestasi_kerja, b.beban_kerja, b.kondisi_kerja, d.statuspeg, f.id_unitkerja,
            b.jenis_jabatan, d.flag_terima_tpp, f.id_unitkerjamaster, d.besaran_gaji, d.nipbaru_ws as nip, h.id as id_m_user, f.nm_unitkerja,
            a.nama_jabatan, b.eselon, e.id_pangkat as pangkat, a.flag_add, a.bulan, a.tahun, b.flag_override_tpp, d.tmt_hitung_absen')
                                ->from('t_hardcode_nominatif a')
                                ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg', 'left')
                                ->join('db_pegawai.pegawai d', 'a.nip = d.nipbaru_ws')
                                ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                                ->join('db_pegawai.unitkerja f', 'a.id_unitkerja = f.id_unitkerja')
                                ->join('m_pangkat g', 'd.pangkat = g.id_pangkat')
                                ->join('m_user h', 'a.nip = h.username')
                                ->join('db_pegawai.statuspeg i', 'd.statuspeg = i.id_statuspeg')
                                // ->where('a.bulan <=', floatval($bulan))
                                // ->where('a.tahun <=', floatval($tahun))
                                // ->where('a.id_unitkerja', $id_unitkerja)
                                ->where('a.flag_active', 1)
                                ->where('h.flag_active', 1)
                                ->group_by('a.id');

        if($uk && $flag_sekolah_kecamatan == 1){ // jika sekolah
            $this->db->where('f.id_unitkerjamaster_kecamatan', $id_unitkerja);
        } else if(stringStartWith('Kecamatan', $uk['nm_unitkerja'])){ // jika kecamatan
            $this->db->where('f.id_unitkerjamaster', $uk['id_unitkerjamaster']);
        } else {
            $this->db->where('a.id_unitkerja', $id_unitkerja);
        }
        $pegawai = $this->db->get()->result_array();
        

        // if($id_unitkerja == '4011000'){
        //     dd($pegawai);
        // }
        if($pegawai){
            foreach($pegawai as $peg){
                // if($peg['nipbaru_ws'] == "198302282003121005"){
                // var_dump($peg);
                // }
                
                if(floatval($bulan) == $peg['bulan'] && floatval($tahun) == $peg['tahun']){
                    if($peg['flag_add'] == 1){
                        $temp_list_pegawai[$peg['nipbaru_ws']] = $peg;
                       
                    }

                    if($peg['flag_add'] == 0){
                        unset($temp_list_pegawai[$peg['nipbaru_ws']]);
                    }
                }
            }
        }

        $list_pegawai = null;
        if($temp_list_pegawai){
            foreach($temp_list_pegawai as $tlp){
                $list_pegawai[] = $tlp;
            }
        }
        
        return $list_pegawai;
    }

    public function getPltPlhTambahan($id_unitkerja, $bulan, $tahun, $list_pegawai){
        if($bulan == null){
            $bulan = date('m');
        }

        if($tahun == null){
            $tahun = date('Y');
        }

        $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerja', $id_unitkerja)
                                    ->get()->row_array();
        
        $result = null;
        $pegawai = $this->db->select('d.nipbaru_ws, d.nama, d.gelar1, d.gelar2, e.nm_pangkat, g.kelas_jabatan_jfu, g.kelas_jabatan_jft, a.flag_timpa_tpp, d.kelas_jabatan_hardcode, h.nm_statuspeg,
            b.kelas_jabatan, e.id_pangkat, b.kepalaskpd, b.prestasi_kerja, b.beban_kerja, b.kondisi_kerja, d.statuspeg, f.id_unitkerja, c.id as id_m_user, d.id_jabatan_tambahan,
            b.jenis_jabatan, d.flag_terima_tpp, f.id_unitkerjamaster, d.besaran_gaji, a.presentasi_tpp, d.nipbaru_ws as nip, a.flag_use_bpjs, f.nm_unitkerja, d.tmt_hitung_absen,
            concat(a.jenis, ". ", b.nama_jabatan) as nama_jabatan, a.tanggal_mulai, a.tanggal_akhir, b.eselon, e.id_pangkat as pangkat, b.flag_override_tpp, a.flag_use_presentase_tpp_plt')
                                ->from('t_plt_plh a')
                                ->join('db_pegawai.jabatan b', 'a.id_jabatan = b.id_jabatanpeg')
                                ->join('m_user c', 'a.id_m_user = c.id')
                                ->join('db_pegawai.pegawai d', 'c.username = d.nipbaru_ws')
                                ->join('db_pegawai.pangkat e', 'd.pangkat = e.id_pangkat')
                                ->join('db_pegawai.unitkerja f', 'a.id_unitkerja = f.id_unitkerja')
                                ->join('m_pangkat g', 'd.pangkat = g.id_pangkat')
                                ->join('db_pegawai.statuspeg h', 'd.statuspeg = h.id_statuspeg')
                                // ->where('a.id_unitkerja', $id_unitkerja)
                                ->where('a.flag_active', 1);
                                // ->get()->result_array();

        if(in_array($id_unitkerja, LIST_UNIT_KERJA_KECAMATAN_NEW)){
            $this->db->where('f.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        } 
        // else if(stringStartWith('sekolah_', $data['id_unitkerja'])){
        //     $this->db->where('c.id_unitkerjamaster_kecamatan', $uksearch['id_unitkerjamaster_kecamatan']);
        // } 
        else {
            $this->db->where('a.id_unitkerja', $id_unitkerja);
        }
        $pegawai = $this->db->get()->result_array();

        // if($this->general_library->isProgrammer()){
        //     dd($pegawai);
        // }

        $list_hari_kerja = null;
        $hari_kerja = getHariKerjaByBulanTahun($bulan, $tahun);
        if($hari_kerja){
            foreach($hari_kerja[3] as $hk){
                $list_hari_kerja[$hk] = $hk;
            }
        }
        // cari tanggal kerja dari tanggal awal s/d tanggal akhir PLT dan cocokkan dengan hari kerja di bulan yang dicari.
        // jika presentasi >= 50%, maka masuk dalam pegawai tambahan tersebut
        if($pegawai){
            foreach($pegawai as $p){
                // $bulan = $bulan;
                // if($bulan < 10){
                //     $bulan = "0".intval($bulan);
                // }
                // if()
                $hari_kerja_tmt = countHariKerjaDateToDate($p['tanggal_mulai'], $p['tanggal_akhir']);   
                $jumlah_hari_kerja_tmt = 0;
                foreach($hari_kerja_tmt[3] as $hkt){
                    if(isset($list_hari_kerja[$hkt])){
                        $jumlah_hari_kerja_tmt++;
                    }
                }
                $presentase = ($jumlah_hari_kerja_tmt / $hari_kerja[0]) * 100;
                if($presentase >= 50){
                    $list_pegawai[] = $p;
                }
            }
        }

        return $list_pegawai;
    }

    public function cekBangkomBulanan($param, $unitkerja = 0, $list_pegawai = null){
        if($list_pegawai){
            dd($list_pegawai);
        }
    }

    public function buildDataAbsensi($data, $flag_absen_aars = 0, $flag_alpha = 0, $flag_rekap_personal = 0, $flag_rekap_tpp = 0, $flag_penerima_tpp = 1){
        // if($this->general_library->isProgrammer()){
        //     dd($flag_absen_aars.$flag_penerima_tpp);
        // }
        $batasHitungAbsen = "2025-12-19"; // tahun 2025, batas hitung absen hanya sampai 19 desember 2025
        $startExcludeCuti = "2025-12-01";
        $endExcludeCuti = "2025-12-19";
        // dd($flag_alpha);
        $rs = null;
        $periode = null;
        $list_hari = null;
        $raw_data_excel = json_encode($data);
        $expluk = null;
        $uksearch = null;
        // if($flag_rekap_tpp == 1){
            if(stringStartWith('sekolah_', $data['id_unitkerja'])){
                $expluk = explode("_",$data['id_unitkerja']);
                $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerjamaster_kecamatan', $expluk[1])
                                    ->get()->row_array();
            } else {
                $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerja', $data['id_unitkerja'])
                                    ->get()->row_array();
            }         
        // }
        if($flag_absen_aars == 1){
            $this->db->select('a.nipbaru_ws as nip, a.gelar1, a.gelar2, a.nama, c.nm_unitkerja, c.id_unitkerja, d.kelas_jabatan_jfu, d.kelas_jabatan_jft,
            b.kelas_jabatan, b.jenis_jabatan, a.statuspeg, d.id_pangkat, b.nama_jabatan, f.nm_statuspeg,
            b.eselon, c.id_unitkerjamaster, a.kelas_jabatan_hardcode, a.id_jabatan_tambahan, a.statuspeg,
            a.pangkat, a.flag_terima_tpp, a.flag_sertifikasi, a.statuspeg, a.tmt_hitung_absen')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.jabatan')
                            ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                            ->join('m_pangkat d', 'a.pangkat = d.id_pangkat')
                            ->join('db_pegawai.jabatan e', 'a.id_jabatan_tambahan = e.id_jabatanpeg', 'left')
                            ->join('db_pegawai.statuspeg f', 'a.statuspeg = f.id_statuspeg')
                            ->where('id_m_status_pegawai', 1)
                            ->order_by('b.eselon')
                            ->order_by('a.nama')
                            ->group_by('a.nipbaru_ws');
            if($flag_alpha == 0 && $flag_rekap_personal == 0){
                if((($flag_rekap_tpp == 1 || ($flag_rekap_tpp == 0 && $flag_absen_aars == 1)) && in_array($data['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN_NEW))){
                    $this->db->where('c.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
                } else if(stringStartWith('sekolah_', $data['id_unitkerja'])){
                    $this->db->where('c.id_unitkerjamaster_kecamatan', $uksearch['id_unitkerjamaster_kecamatan']);
                } else {
                    $this->db->where('a.skpd', $data['id_unitkerja']);
                }
            } else if($flag_alpha == 1){
                $this->db->where('c.id_unitkerjamaster', 8010000);
            }

            if($flag_penerima_tpp == 1){
                $this->db->where('a.flag_terima_tpp', 1);
            }

            if($flag_rekap_personal == 1){
                $this->db->join('m_user d', 'a.nipbaru_ws = d.username')
                        ->where('d.id', $data['id_m_user']);
            }
            $list_pegawai = $this->db->get()->result_array();
            
            $list_pegawai = $this->getPltPlhTambahan($data['id_unitkerja'], $data['bulan'], $data['tahun'], $list_pegawai);

            $list_pegawai = $this->getNominatifPegawaiHardCode($data['id_unitkerja'], $data['bulan'], $data['tahun'], $list_pegawai);
        }

        if($flag_rekap_tpp == 1 && $this->general_library->isProgrammer()){
            if($data['tahun'].'-'.$data['bulan'].'01' >= '2026-02-01'){
                $rs = $this->cekBangkomBulanan($data, 0, $list_pegawai);
            }
        }

        $list_tanggal_exclude = null;
        $temp_list_nip = null;
        if($flag_absen_aars == 1){
            if($flag_rekap_personal == 1){
                $temp['skpd'] = $list_pegawai[0]['nm_unitkerja'];
                $temp['id_unitkerja'] = $list_pegawai[0]['id_unitkerja'];
                $data['unitkerja'] = $temp['id_unitkerja'].';'.$temp['skpd'];
            } else {
                $temp['skpd'] = $data['nm_unitkerja'];
                $temp['id_unitkerja'] = $data['id_unitkerja'];
            }
            // $temp['skpd'] = $data['nm_unitkerja'];
            $temp['bulan'] = $data['bulan'];
            $temp['tahun'] = $data['tahun'];
            // $temp['id_unitkerja'] = $data['id_unitkerja'];
            $temp['periode'] = getNamaBulan($data['bulan']).' '.$data['tahun'];
            $periode = $temp['periode'];
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $data['bulan'], $data['tahun']);
            $tanggal_awal = $data['tahun'].'-'.$data['bulan'].'-'.'01';
            $tanggal_akhir = $data['tahun'].'-'.$data['bulan'].'-'.$jumlah_hari;
            $list_hari = getDateBetweenDates($tanggal_awal, $tanggal_akhir);

            $tlp = null;
            //ambil kelas jabatan tiap pegawai
            $list_pegawai = $this->getKelasJabatanPegawai($list_pegawai);
            foreach($list_pegawai as $lpw){
                $temp_list_nip[] = $lpw['nip'];
                $tlp[$lpw['nip']]['nama_pegawai'] = getNamaPegawaiFull($lpw);
                $tlp[$lpw['nip']]['nip'] = ($lpw['nip']);
                $tlp[$lpw['nip']]['nama_jabatan'] = ($lpw['nama_jabatan']);
                $tlp[$lpw['nip']]['eselon'] = ($lpw['eselon']);
                $tlp[$lpw['nip']]['kelas_jabatan'] = ($lpw['kelas_jabatan']);
                $tlp[$lpw['nip']]['statuspeg'] = ($lpw['statuspeg']);
                $tlp[$lpw['nip']]['nm_statuspeg'] = ($lpw['nm_statuspeg']);
                // $tlp[$lpw['nip']]['golongan'] = $lpw['statuspeg'] == 1 || $lpw['statuspeg'] == 2 ? numberToRoman(substr($lpw['pangkat'], 0, 1)) : '';
                $tlp[$lpw['nip']]['golongan'] = getGolonganByIdPangkat($lpw['id_pangkat']);
                $tlp[$lpw['nip']]['tmt_hitung_absen'] = $lpw['tmt_hitung_absen'];
                $tlp[$lpw['nip']]['absen'] = null;
                $tlp[$lpw['nip']]['jumlah_anulir'] = null;
                foreach($list_hari as $lh){
                    $tlp[$lpw['nip']]['absen'][$lh]['tanggal'] = $lh;
                    $tlp[$lpw['nip']]['absen'][$lh]['jam_masuk'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['jam_pulang'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['ket'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['ket_status_absensi'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['status_absensi'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['ket_masuk'] = "";
                    $tlp[$lpw['nip']]['absen'][$lh]['ket_pulang'] = "";

                    if(getNamaHari($lh) == 'Sabtu' || getNamaHari($lh) == 'Minggu'){
                        $expl = explode("-", $lh);
                        $list_tanggal_exclude[$lh] = $expl[2];
                    }
                }
            }

            $this->db->select('a.status as status_absensi, a.*, c.*, b.username as nip')
                        ->from('db_sip.absen a')
                        ->join('m_user b', 'a.user_id = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->where('MONTH(a.tgl)', $data['bulan'])
                        ->where('YEAR(a.tgl)', $data['tahun'])
                        ->where('id_m_status_pegawai', 1)
                        // ->where('c.skpd', $data['id_unitkerja'])
                        ->group_by('a.id');

            if($flag_rekap_personal == 1){
                $this->db->where('b.id', $data['id_m_user']); 
            } else {
                $this->db->where_in('c.nipbaru_ws', $temp_list_nip);
            }
            // else if($flag_rekap_tpp == 1 && in_array($data['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN_NEW)){
            //     $this->db->join('db_pegawai.unitkerja d', 'c.skpd = d.id_unitkerja')
            //             ->where('d.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
            // } else {
            //     $this->db->where('c.skpd', $data['id_unitkerja']); 
            // }

            $list_data_absen = $this->db->get()->result_array();
            
            $data_absen = null;
            if($list_data_absen){
                foreach($list_data_absen as $lda){
                    $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_masuk'] = formatTimeAbsen($lda['masuk']);
                    $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_pulang'] = formatTimeAbsen($lda['pulang']);
                    $tlp[$lda['nip']]['absen'][$lda['tgl']]['status_absensi'] = $lda['status_absensi'];
                    $tlp[$lda['nip']]['absen'][$lda['tgl']]['ket_status_absensi'] = $lda['alasan'];
                    if($lda['status_absensi'] == 4){
                        $tlp[$lda['nip']]['jumlah_anulir']++;
                        $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_masuk'] = "Invalid";
                    } else if($lda['status_absensi'] == 5){
                        $tlp[$lda['nip']]['jumlah_anulir']++;
                        $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_pulang'] = "Invalid";
                    } else if($lda['status_absensi'] == 6){
                        $tlp[$lda['nip']]['jumlah_anulir'] += 2;
                        $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_masuk'] = "Invalid";
                        $tlp[$lda['nip']]['absen'][$lda['tgl']]['jam_pulang'] = "Invalid";
                    }
                }
                $data_absen = $tlp;
                // dd(json_encode($data_absen));
            } else {
                $temp_tlp = $tlp;
                $tlp = null;

                foreach($temp_tlp as $tmplp){
                    foreach($list_hari as $lhtemp){
                        $tlp[$tmplp['nip']] = $tmplp;
                        $tlp[$tmplp['nip']]['absen'][$lhtemp]['jam_masuk'] = ""; 
                        $tlp[$tmplp['nip']]['absen'][$lhtemp]['jam_pulang'] = ""; 
                    }
                }
                $data_absen = $tlp;
            }

            if($data_absen){
                $data = $temp;
                $data['result'] = $data_absen;
                $data['list_hari'] = $list_hari;
                // $raw_data_excel = json_encode($data);
            } else {
                return null;
            }

        } else {
            if(!$data['unitkerja']){
                return $data;
            }
            $periode = explode(" ", $data['periode']);
            $list_hari = getDateBetweenDates($periode[0], $periode[2]);
        }
        $rs['id_unitkerja'] = $flag_absen_aars == 0 ? $data['unitkerja']['id_unitkerja'] : $data['id_unitkerja'];
        $rs['bulan'] = $data['bulan'];
        $rs['tahun'] = $data['tahun'];
        $rs['created_by'] = $this->general_library->getId();

        $uker = $this->db->select('a.*')
                        ->from('db_pegawai.unitkerja a')
                        ->where('a.id_unitkerja', $rs['id_unitkerja'])
                        ->get()->row_array();

        if($flag_absen_aars == 0){
            $list_pegawai = $this->db->select('a.nipbaru_ws as nip, a.gelar1, a.gelar2, a.nama')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.jabatan')
                            ->where('a.skpd', $rs['id_unitkerja'])
                            ->order_by('b.eselon, a.nama')
                            ->where('id_m_status_pegawai', 1)
                            ->get()->result_array();
        }
        $lp = null;
        if($list_pegawai){
            foreach($list_pegawai as $l){
                $lp[$l['nip']] = $l;
            }
        }
        
        $jskpd = 1;
        if(in_array($uker['id_unitkerja'], LIST_UNIT_KERJA_KHUSUS) && stringStartWith('Sekolah', $uker['nm_unitkerja'])){
            $jskpd = 2;
        } else if(in_array($uker['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH) || stringStartWith('sekolah_', $data['id_unitkerja'])){
            $jskpd = 4;
        }
        $jam_kerja = $this->db->select('*')
                ->from('t_jam_kerja')
                ->where('id_m_jenis_skpd', $jskpd)
                ->where('flag_event', 0)
                ->where('flag_active', 1)
                ->order_by('created_date')
                ->get()->row_array();

        $data['jam_kerja'] = $jam_kerja;

        $jam_kerja_event = null;
        $temp_jam_kerja_event = $this->db->select('*')
                ->from('t_jam_kerja')
                ->where('id_m_jenis_skpd', $jskpd)
                // ->where('(MONTH(berlaku_dari) = '.$data['bulan'].' OR
                //         MONTH(berlaku_sampai) = '.$data['bulan'].')')
                // ->where('(YEAR(berlaku_dari) = '.$data['tahun'].' OR
                //         YEAR(berlaku_sampai) = '.$data['tahun'].')')
                ->where_in('flag_event', [1,2])
                ->where('flag_active', 1)
                ->get()->result_array();

        if($temp_jam_kerja_event){
            foreach($temp_jam_kerja_event as $tjke){
                $i = 0;
                foreach($list_hari as $lhr){
                    $i++;
                    // if($lhr == $tjke['berlaku_dari'] || $lhr == $tjke['berlaku_sampai']){ //cek jika tanggal masuk dalam range tanggal jam kerja event
                    if($lhr >= $tjke['berlaku_dari'] && $lhr <= $tjke['berlaku_sampai']){ //cek jika tanggal masuk dalam range tanggal jam kerja event
                        $jam_kerja_event[] = $tjke;
                        break;
                    }
                }
                // if((($list_hari[0]) >= ($tjke['berlaku_dari'])) &&
                //     ($list_hari[0]) <= ($tjke['berlaku_sampai'])){  //cek jika tanggal awal masuk dalam jam kerja event
                //         $jam_kerja_event[] = $tjke;
                // } else if((($list_hari[count($list_hari)-1]) >= ($tjke['berlaku_dari'])) &&
                //     ($list_hari[count($list_hari)-1]) <= ($tjke['berlaku_sampai'])){  //cek jika tanggal akhir masuk dalam jam kerja event
                //     $jam_kerja_event[] = $tjke;
                // }
            }
        }
        $data['jam_kerja_event'] = null;
        if($jam_kerja_event){
            $data['jam_kerja_event'] = $jam_kerja_event;
        }

        $hari_libur = $this->db->select('*')
                ->from('t_hari_libur')
                ->where('flag_active', 1)
                ->where('flag_hari_libur_nasional', 1)
                ->where('bulan', $data['bulan'])
                ->where('tahun', $data['tahun'])
                ->order_by('tanggal')
                ->get()->result_array();
        $tmp_hari_libur = $hari_libur;
        $data['info_libur'] = null;
        if($tmp_hari_libur){
            $hari_libur = null;
            foreach($tmp_hari_libur as $h){
                if(!isset($data['info_libur'][$h['keterangan']])){
                    $data['info_libur'][$h['keterangan']]['keterangan'] = $h['keterangan'];
                    $data['info_libur'][$h['keterangan']]['tanggal_awal'] = $h['tanggal'];
                    $data['info_libur'][$h['keterangan']]['tanggal_akhir'] = $h['tanggal'];
                } else {
                    $data['info_libur'][$h['keterangan']]['tanggal_akhir'] = $h['tanggal'];
                }
                $hari_libur[$h['tanggal']] = $h;

                $expl = explode("-", $h['tanggal']);
                $list_tanggal_exclude[$h['tanggal']] = $expl[2];
            }
        }
        $data['hari_libur'] = $hari_libur;

        $data['disiplin_kerja'] = $this->db->select('keterangan')
                ->from('m_jenis_disiplin_kerja')
                ->where('flag_active', 1)
                // ->where_not_in('id', [7, 8, 9, 10, 11, 12])
                ->where_not_in('id', [11, 12])
                ->get()->result_array();

        $this->db->select('b.username as nip, a.tanggal, a.bulan, a.tahun, a.pengurangan, d.keterangan, a.keterangan as keterngn, e.id_cuti')
                ->from('t_dokumen_pendukung a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->join('db_pegawai.pegawai c','b.username = c.nipbaru_ws')
                ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                ->join('t_pengajuan_cuti e', 'a.random_string = e.random_string AND a.id_m_user = e.id_m_user', 'left')
                ->where('a.bulan', floatval($data['bulan']))
                ->where('a.tahun', floatval($data['tahun']))
                ->where('a.flag_active', 1)
                ->where_in('c.nipbaru_ws', $temp_list_nip)
                // ->where_not_in('a.tanggal', $list_tanggal_exclude)
                // ->where('c.skpd', $uker['id_unitkerja'])
                ->where('id_m_status_pegawai', 1)
                ->where('a.status', 2);

        // if($flag_rekap_tpp == 1 && in_array($data['id_unitkerja'], LIST_UNIT_KERJA_KECAMATAN_NEW)){
        //     $this->db->join('db_pegawai.unitkerja e', 'c.skpd = e.id_unitkerja')
        //             ->where('e.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else {
        //     $this->db->where('c.skpd', $uker['id_unitkerja']);
        // }
        $tmp_dokpen = $this->db->get()->result_array();
        $dokpen = null;

        $data['list_dokpen'] = null;
        $excludeCuti = null;

        if($tmp_dokpen){
            foreach($tmp_dokpen as $dok){
                $flagIgnoreAbsen = 0;
               
                $tanggal_dok = $dok['tanggal'] < 10 ? '0'.$dok['tanggal'] : $dok['tanggal'];
                $bulan_dok = $dok['bulan'] < 10 ? '0'.$dok['bulan'] : $dok['bulan'];
                $date_dok = $dok['tahun'].'-'.$bulan_dok.'-'.$tanggal_dok;
               
                if(intval($data['bulan']) == 12 && $data['tahun'] == 2025 && $flag_rekap_tpp == 1 && $date_dok > $batasHitungAbsen){ // jika rekap desember 2025 dan flag rekap tpp == 1
                    $flagIgnoreAbsen = 1;
                }

                if($flagIgnoreAbsen == 0){
                    $dokpen[$dok['nip']]['nip'] = $dok['nip'];
                    $dokpen[$dok['nip']][$date_dok] = $dok['keterangan'];
                    $dokpen[$dok['nip']]["ket_".$date_dok]= $dok['keterngn'];

                    $data['list_dokpen'][$dok['nip']][] = $dok;
                    $data['list_dokpen_per_date'][$dok['nip']][$date_dok][] = $dok;

                    if($date_dok >= $startExcludeCuti && $date_dok <= $endExcludeCuti && ($dok['id_cuti'] == "00" || $dok['id_cuti'] == "20")){
                        if(isset($excludeCuti[$dok['nip']])){
                            $excludeCuti[$dok['nip']]++;
                        } else {
                            $excludeCuti[$dok['nip']] = 1;
                        }
                    }
                    
                }
            }
        }

        $tempresult = $data['result'];
        $data['result'] = null;
        
        $i = 0;
        $format_hari = null;
        foreach($list_hari as $lh){
            $data_jam_kerja[$lh] = $jam_kerja;
            if($jam_kerja_event){
                foreach($jam_kerja_event as $jke){
                    if((($lh) >= ($jke['berlaku_dari'])) &&
                        ($lh) <= ($jke['berlaku_sampai'])){  
                        $data_jam_kerja[$lh] = $jke;
                    }
                }
            }
            
            $format_hari[$lh]['tanggal'] = $lh;
            $format_hari[$lh]['jam_masuk'] = '';
            $format_hari[$lh]['jam_pulang'] = '';
            if(getNamaHari($lh) != 'Jumat' && getNamaHari($lh) != 'Sabtu' && getNamaHari($lh) != 'Minggu'){
                $format_hari[$lh]['jam_masuk'] = $data_jam_kerja[$lh]['wfo_masuk'];
                $format_hari[$lh]['jam_pulang'] = $data_jam_kerja[$lh]['wfo_pulang'];
                // if($jam_kerja_event){
                //     if((($lh) >= ($jam_kerja_event['berlaku_dari'])) &&
                //         ($lh) <= ($jam_kerja_event['berlaku_sampai'])){

                //         $format_hari[$lh]['jam_masuk'] = $jam_kerja_event['wfo_masuk'];
                //         $format_hari[$lh]['jam_pulang'] = $jam_kerja_event['wfo_pulang'];
                //     }
                // }
            } else if(getNamaHari($lh) == 'Jumat'){
                $format_hari[$lh]['jam_masuk'] = $data_jam_kerja[$lh]['wfoj_masuk'];
                $format_hari[$lh]['jam_pulang'] = $data_jam_kerja[$lh]['wfoj_pulang'];

                // if($jam_kerja_event){
                //     if((($lh) >= ($jam_kerja_event['berlaku_dari'])) &&
                //         ($lh) <= ($jam_kerja_event['berlaku_sampai'])){

                //         $format_hari[$lh]['jam_masuk'] = $jam_kerja_event['wfo_masuk'];
                //         $format_hari[$lh]['jam_pulang'] = $jam_kerja_event['wfo_pulang'];
                //     }
                // }
            } 
            // $i++;
        }

        $list_alpha = [];
        // function comparatorTempResult($object1, $object2) {
        //     return $object1['kelas_jabatan'] < $object2['kelas_jabatan'];
        // }
        // usort($tempresult, 'comparatorTempResult');
        // dd($tempresult);

        foreach($tempresult as $tr){
            // if(!isset($tr['nip'])){
            //     dd($tr);
            // }
            if(isset($tr['nip']) && isset($lp[$tr['nip']])){
                $lp[$tr['nip']] = $tr;
                $lp[$tr['nip']]['rekap']['tmk1'] = 0;
                $lp[$tr['nip']]['rekap']['tmk2'] = 0;
                $lp[$tr['nip']]['rekap']['tmk3'] = 0;
                $lp[$tr['nip']]['rekap']['pksw1'] = 0;
                $lp[$tr['nip']]['rekap']['pksw2'] = 0;
                $lp[$tr['nip']]['rekap']['pksw3'] = 0;
                $lp[$tr['nip']]['rekap']['TK'] = 0;
                $lp[$tr['nip']]['rekap']['jhk'] = 0;
                $lp[$tr['nip']]['rekap']['hadir'] = 0;
                $lp[$tr['nip']]['rekap']['KENEG 2'] = 0;
                if($data['disiplin_kerja']){
                    foreach($data['disiplin_kerja'] as $dk){
                        $lp[$tr['nip']]['rekap'][$dk['keterangan']] = 0;
                    }
                }
                $lp[$tr['nip']]['rekap']['exclude_cuti'] = isset($excludeCuti[$tr['nip']]) ? $excludeCuti[$tr['nip']] : 0;
                foreach($list_hari as $l){
                    $isNotTmtAbsen = 0;
                    $flagIgnoreAbsen = 0;
                    if(isset($tr['tmt_hitung_absen']) && $l < $tr['tmt_hitung_absen']){ // cek jika sudah masuk dalam tmt hitung absen
                        $isNotTmtAbsen = 1;
                    }
                    if($this->general_library->isProgrammer()){
                        // dd(intval($data['bulan']) == 6 && $data['tahun'] == 2025);
                    }
                    if(intval($data['bulan']) == 12 && $data['tahun'] == 2025 && $flag_rekap_tpp == 1 && $l > $batasHitungAbsen){ // jika rekap desember 2025 dan flag rekap tpp == 1
                        $flagIgnoreAbsen = 1;
                    }
                    if($flagIgnoreAbsen == 0){
                        if($l <= date('Y-m-d') && $isNotTmtAbsen == 0){
                            // if($format_hari[$l]['jam_masuk'] != '' && !isset($hari_libur[$l])){ //bukan hari libur atau hari sabtu / minggu
                            if($format_hari[$l]['jam_masuk'] != '' || isset($dokpen[$tr['nip']][$l])){ //ada jam kerja atau ada dokpen di hari libur
                                if($format_hari[$l]['jam_masuk'] != '' && !isset($hari_libur[$l])){ // jhk bertambah jika hari kerja saja
                                    $lp[$tr['nip']]['rekap']['jhk']++;
                                }
                                // Surat Tugas
                                if(isset($dokpen[$tr['nip']][$l])){
                                    if($dokpen[$tr['nip']][$l] == "TLS"){
                                        if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "00:00" 
                                        || $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "" 
                                        || !$lp[$tr['nip']]['absen'][$l]['jam_masuk']){
                                            // if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "00:00"){
                                            //     $flag_check = 1;                                        
                                            // } else {
                                                $lp[$tr['nip']]['absen'][$l]['ket'] = "TK";
                                            // }
                                        } else {
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = $dokpen[$tr['nip']][$l];
                                            $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLS';
                                            $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                        }
                                    } else if($dokpen[$tr['nip']][$l] == "TLP"){
                                        $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = $dokpen[$tr['nip']][$l];
                                        $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = '';
                                        $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLP';
                                        $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                    } else if(($data['list_dokpen_per_date'][$tr['nip']][$l])) {
                                        foreach($data['list_dokpen_per_date'][$tr['nip']][$l] as $dokperdate){
                                            if($dokperdate['keterangan'] == 'TLP'){
                                                $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = $dokpen[$tr['nip']][$l];
                                                $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = '';
                                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLP';
                                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                            } else if ($dokperdate['keterangan'] == 'TLS'){
                                                $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = $dokpen[$tr['nip']][$l];
                                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLS';
                                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                            }
                                        }
                                    } else {
                                        $lp[$tr['nip']]['absen'][$l]['ket'] = "TK";
                                    } 
                                }
                                
                                // Tutup Surat Tugas
                                $flag_check = 1;
                                if($lp[$tr['nip']]['absen'][$l]['ket'] == 'TK' && $flag_absen_aars == 0){
                                    if(isset($dokpen[$tr['nip']][$l])){  
                                        $lp[$tr['nip']]['absen'][$l]['ket'] = $dokpen[$tr['nip']][$l];
                                        $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                    } else {
                                        // if($this->general_library->isProgrammer() &&
                                        // $tr['nip'] == 199502182020121013 &&
                                        // $l == '2025-05-31'){
                                        //     dd('asd');
                                        // }
                                        if($lp[$tr['nip']]['rekap']['TK'] > 10 && !isset($list_alpha[$tr['nip']])){
                                            $list_alpha[$tr['nip']] = $tr['nip'];
                                        }
                                    }
                                    $flag_check = 0;
                                } else if($flag_absen_aars == 1){
                                    if(isset($dokpen[$tr['nip']][$l]) &&
                                        $dokpen[$tr['nip']][$l] != "TLS" && $dokpen[$tr['nip']][$l] != "TLP"){
                                            $flag_check = 0;
                                            $lp[$tr['nip']]['absen'][$l]['ket'] = $dokpen[$tr['nip']][$l];
                                            // disini ba tambah dokpen
                                            if($dokpen[$tr['nip']][$l] == "KENEG 2"){
                                                $dokpen[$tr['nip']][$l] = "KENEG";
                                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]] += 2;
                                            } else {
                                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                            }
                                            if($dokpen[$tr['nip']][$l] == "MTTI" || $dokpen[$tr['nip']][$l] == "KENEG"){
                                                $flag_check = 1;
                                            } else {
                                                $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = "";
                                                $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = "";
                                            }
                                            if($dokpen[$tr['nip']][$l] == "TL"){
                                                $lp[$tr['nip']]['rekap']['hadir']++;
                                            }
                                    } else {
                                        if((!$lp[$tr['nip']]['absen'][$l]['jam_masuk'] || 
                                            $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "")){
                                            if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == 'TLS'){ // cek jika TLS dan tidak ada absen masuk
                                                // $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = "00:00";
                                                // $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk3';
                                                // $lp[$tr['nip']]['rekap']['tmk3']++;
                                                $flag_check = 1;
                                            } else {
                                                $lp[$tr['nip']]['absen'][$l]['ket'] = 'TK';
                                                $lp[$tr['nip']]['rekap']['TK']++;
                                                if($lp[$tr['nip']]['rekap']['TK'] > 10 && !isset($list_alpha[$tr['nip']])){
                                                    $list_alpha[$tr['nip']] = $tr['nip'];
                                                }
                                                $flag_check = 0;
                                            }
                                        } else if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "00:00" || $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "00:00:00"){
                                            $flag_check = 1;
                                        }
                                    }
                                }

                                if($flag_check == 1 && $format_hari[$l]['jam_masuk'] != '' && !isset($hari_libur[$l])) {
                                    $flag_check_done = 0;
                                    $lp[$tr['nip']]['rekap']['hadir']++;
                                    // if(isset($dokpen[$tr['nip']][$l]) && $dokpen[$tr['nip']][$l] == 'TLP'){
                                    //     dd($lp[$tr['nip']]['absen'][$l]);
                                    // }
                                    if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] != "TLP" && $lp[$tr['nip']]['absen'][$l]['jam_masuk'] != "Invalid"){
                                        $diff_masuk = strtotime($lp[$tr['nip']]['absen'][$l]['jam_masuk']) - strtotime($format_hari[$l]['jam_masuk'].'+ 59 seconds');
                                        if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == '' || $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == '00:00' || $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == '00:00:00'){
                                            $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = '00:00';
                                            $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk3';
                                            $lp[$tr['nip']]['rekap']['tmk3']++;
                                        }
                                        if($diff_masuk > 0){
                                            $ket_masuk = floatval($diff_masuk) / 1800;
                                            if($ket_masuk <= 1){
                                                $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk1';
                                                $lp[$tr['nip']]['rekap']['tmk1']++;
                                            } else if($ket_masuk > 1 && $ket_masuk <= 2){
                                                $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk2';
                                                $lp[$tr['nip']]['rekap']['tmk2']++;
                                            } else if($ket_masuk > 2) {
                                                $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk3';
                                                $lp[$tr['nip']]['rekap']['tmk3']++;
                                            }
                                        }
                                        
                                        if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == ""){
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = "00:00";
                                        }
                                        $flag_check_done = 1;
                                    }

                                    if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] != "TLS" && $lp[$tr['nip']]['absen'][$l]['jam_pulang'] != "Invalid"){
                                        $diff_keluar = strtotime($format_hari[$l]['jam_pulang']) - strtotime($lp[$tr['nip']]['absen'][$l]['jam_pulang']);
                                        if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == ''){
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = '00:00';
                                        }
                                        if(isset($dokpen[$tr['nip']][$l]) && $dokpen[$tr['nip']][$l] == "TLS"){
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = 'TLS';
                                            $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;

                                            if($lp[$tr['nip']]['absen'][$l]['ket'] == "TK"){
                                                $lp[$tr['nip']]['absen'][$l]['ket'] = "";
                                            }
                                            // if($this->general_library->isProgrammer() &&
                                            // $tr['nip'] == 198805152011022001 &&
                                            // $l == "2025-05-20"){
                                            //     dd($lp[$tr['nip']]['absen'][$l]);
                                            // }
                                        }
                                        else if($diff_keluar > 0){
                                            $ket_pulang = floatval($diff_keluar) / 1800;
                                            if($ket_pulang <= 1){
                                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw1';
                                                $lp[$tr['nip']]['rekap']['pksw1']++;
                                            } else if($ket_pulang > 1 && $ket_pulang <= 2){
                                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw2';
                                                $lp[$tr['nip']]['rekap']['pksw2']++;
                                            } else if($ket_pulang > 2) {
                                                // if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] != "TL"){
                                                    $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw3';
                                                    $lp[$tr['nip']]['rekap']['pksw3']++;
                                                // }
                                            
                                            }
                                        }
                                        $flag_check_done = 1;
                                    }
                                    
                                    if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "Invalid"){
                                        // $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = 'tmk3';
                                        $lp[$tr['nip']]['rekap']['tmk3']++;
                                    }
                                    if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == "Invalid"){
                                        // $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw3';
                                        $lp[$tr['nip']]['rekap']['pksw3']++;
                                    }
                                    
                                    if($flag_check_done == 0){
                                        if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == 'TLP' 
                                        && $lp[$tr['nip']]['absen'][$l]['jam_pulang'] != 'Invalid'
                                        && ($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == '' || $lp[$tr['nip']]['absen'][$l]['jam_pulang'] == '00:00')){
                                            // jika TLP dan tidak absen pulang
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = '00:00';
                                            $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw3';
                                            $lp[$tr['nip']]['rekap']['pksw3']++;
                                        } else if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] == 'TLS' 
                                        && $lp[$tr['nip']]['absen'][$l]['jam_masuk'] != 'Invalid'
                                        && ($lp[$tr['nip']]['absen'][$l]['jam_masuk'] == '' || $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == '00:00')){
                                            // jika TLS dan tidak absen masuk
                                            $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = '00:00';
                                            $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'pksw3';
                                            $lp[$tr['nip']]['rekap']['pksw3']++;
                                        }
                                    }

                                    if(isset($dokpen[$tr['nip']][$l])){
                                        if($dokpen[$tr['nip']][$l] == "TLS"){

                                        } else if ($dokpen[$tr['nip']][$l] == "TLP"){

                                        }
                                    }    
                                }   
                            }
                            // else {
                            //     if($l == '2025-05-31' && $this->general_library->isProgrammer()){
                            //         dd($dokpen[199502182020121013]);
                            //     }
                            // }
                        }
                        if(isset($hari_libur[$l]) &&
                            isset($lp[$tr['nip']]['absen'][$l]) &&
                            $lp[$tr['nip']]['absen'][$l]['ket'] == "TK"){ // jika hari libur ket TK, maka hapus
                                $lp[$tr['nip']]['absen'][$l]['ket'] = "";
                                $lp[$tr['nip']]['rekap']['TK']--;
                        }

                        if((getNamaHari($l) == "Sabtu" || getNamaHari($l) == "Minggu") &&
                            isset($lp[$tr['nip']]['absen'][$l]) &&
                            $lp[$tr['nip']]['absen'][$l]['ket'] == "TK"){ // jika hari libur ket TK, maka hapus
                                $lp[$tr['nip']]['absen'][$l]['ket'] = "";
                                $lp[$tr['nip']]['rekap']['TK']--;
                        }
                    }
                }

                if(isset($data['list_dokpen'][$tr['nip']])){
                    if($data['disiplin_kerja']){
                        foreach($data['disiplin_kerja'] as $dk){
                            if($dk['keterangan'] != 'TK'){
                                $lp[$tr['nip']]['rekap'][$dk['keterangan']] = 0;
                            }
                        }
                        
                        foreach($data['list_dokpen'][$tr['nip']] as $ldok){
                            $lp[$tr['nip']]['rekap'][$ldok['keterangan']]++;
                        }
                    }
                }
            }
        }
        $data['result'] = $lp;
        // if($tr['nip'] == 197612142009022002){
        //     dd($tr);
        // }
        // dd(json_encode($lp));
        $rs['json_result'] = json_encode($lp);
        if($flag_absen_aars == 0){
            $data['raw_data_excel'] = $raw_data_excel;
        }
        if($flag_alpha == 1){
            return $list_alpha;
        }

        $data['temp_list_nip'] = $temp_list_nip;
        // if($this->general_library->getId() == 16){ // checkpoint
        //     dd($data);
        // }
        return $data;
    }

    public function saveDbRekapAbsensi($data){
        $insert_data['json_result'] = json_encode($data);
        $insert_data['bulan'] = $data['bulan'];
        $insert_data['tahun'] = $data['tahun'];
        $insert_data['raw_data_excel'] = $data['raw_data_excel'];
        $insert_data['id_unitkerja'] = $data['unitkerja']['id_unitkerja'];
        $insert_data['created_by'] = $this->general_library->getId();
        $this->db->where('bulan', $insert_data['bulan'])
            ->where('tahun', $insert_data['tahun'])
            ->where('id_unitkerja', $insert_data['id_unitkerja'])
            ->update('t_rekap_absen', ['flag_active' => 0]);

        $this->db->insert('t_rekap_absen', $insert_data);
    }

    public function readAbsensiFromDb($param){
        $result = null;

        $data_absen = $this->db->select('*')
                    ->from('t_rekap_absen')
                    ->where('bulan', $param['bulan'])
                    ->where('tahun', $param['tahun'])
                    ->where('id_unitkerja', $param['skpd'])
                    ->where('flag_active', 1)
                    ->get()->row_array();
        if($data_absen){
            // dd($data_absen['raw_data_excel']);
            $result = $this->buildDataAbsensi(json_decode($data_absen['raw_data_excel'], true));
           
        }
       
        return $result;
    }

    public function saveDbRekapDisiplin($data){
        $skpd = explode(";", $data['parameter']['skpd']);
        $insert_data['json_result'] = json_encode($data['result']);
        $insert_data['bulan'] = $data['parameter']['bulan'];
        $insert_data['tahun'] = $data['parameter']['tahun'];
        $insert_data['id_unitkerja'] = $skpd[0];
        $insert_data['created_by'] = $this->general_library->getId();

        $this->db->where('bulan', $insert_data['bulan'])
            ->where('tahun', $insert_data['tahun'])
            ->where('id_unitkerja', $insert_data['id_unitkerja'])
            ->update('t_rekap_absen', ['flag_active' => 0]);

        $this->db->insert('t_rekap_absen', $insert_data);
    }

    public function getRekapAbsen($parameter){
        $skpd = explode(";", $parameter['skpd']);

        $data_disiplin_kerja = $this->db->select('a.*, b.username as nip, d.keterangan')
                        ->from('t_disiplin_kerja a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                        ->where('a.bulan', $parameter['bulan'])
                        ->where('a.tahun', $parameter['tahun'])
                        ->where('c.skpd', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->where_in('a.id_m_jenis_disiplin_kerja', [1,2,14,15,16,17])
                        ->where('id_m_status_pegawai', 1)
                        ->get()->result_array();

        $data_rekap =  $this->db->select('*')
                        ->from('t_rekap_absen a')
                        ->where('id_unitkerja', $skpd[0])
                        ->where('bulan', floatval($parameter['bulan']))
                        ->where('tahun', floatval($parameter['tahun']))
                        ->where('flag_active', 1)
                        ->order_by('created_date', 'desc')
                        ->limit(1)
                        ->get()->row_array();

        $tempdk = null;
        $result = null;
        if($data_disiplin_kerja){
            foreach($data_disiplin_kerja as $dk){
                $tanggal = $dk['tanggal'] < 10 ? '0'.$dk['tanggal'] : $dk['tanggal'];
                $bulan = $dk['bulan'] < 10 ? '0'.$dk['bulan'] : $dk['bulan'];
                $tempdk[$dk['nip']][$tanggal.'-'.$bulan.'-'.$dk['tahun']] = $dk['keterangan'];
            }

            if($data_rekap){
                $i = 0;
                $tmp_data_rekap = json_decode($data_rekap['json_result'], true);
                foreach($tmp_data_rekap as $d){
                    if(isset($tempdk[$d['nip']])){
                        $tempdk_keys = array_keys($tempdk[$d['nip']]);
                        foreach($tempdk_keys as $t){
                            $d['absensi'][$t]['masuk']['data'] = $tempdk[$d['nip']][$t];
                        }
                    }
                    $result[$i] = $d;
                    $i++;
                }
            }
            $data_rekap['json_result'] = json_encode($result);
        }
        return $data_rekap;
    }

    public function rekapPenilaianDisiplinSearch($data, $flag_rekap_tpp = 0, $flag_penerima_tpp = 1){
        $result = null;
        $flag_sekolah_kecamatan = 0;

        $disiplin_kerja = $this->db->select('*')
                            ->from('m_jenis_disiplin_kerja')
                            ->where('flag_active', 1)
                            ->get()->result_array();

        $mdisker = null;

        $mdisker['tmk1']['nama'] = "Terlambat Masuk Kerja K1";
        $mdisker['tmk1']['keterangan'] = 'tmk1';
        $mdisker['tmk1']['pengurangan'] = 1;

        $mdisker['tmk2']['nama'] = "Terlambat Masuk Kerja K2";
        $mdisker['tmk2']['keterangan'] = 'tmk2';
        $mdisker['tmk2']['pengurangan'] = 2;

        $mdisker['tmk3']['nama'] = "Terlambat Masuk Kerja K3";
        $mdisker['tmk3']['keterangan'] = 'tmk3';
        $mdisker['tmk3']['pengurangan'] = 3;

        $mdisker['pksw1']['nama'] = "Pulang Kerja Sebelum Waktu K1";
        $mdisker['pksw1']['keterangan'] = 'pksw1';
        $mdisker['pksw1']['pengurangan'] = 1;

        $mdisker['pksw2']['nama'] = "Pulang Kerja Sebelum Waktu K2";
        $mdisker['pksw2']['keterangan'] = 'pksw2';
        $mdisker['pksw2']['pengurangan'] = 2;

        $mdisker['pksw3']['nama'] = "Pulang Kerja Sebelum Waktu K3";
        $mdisker['pksw3']['keterangan'] = 'pksw3';
        $mdisker['pksw3']['pengurangan'] = 3;

        $mdisker['hukdis']['nama'] = "Hukuman Disiplin";
        $mdisker['hukdis']['keterangan'] = 'hukdis';
        $mdisker['hukdis']['pengurangan'] = 0;

        foreach($disiplin_kerja as $dk){
            $mdisker[$dk['keterangan']]['nama'] = $dk['nama_jenis_disiplin_kerja'];
            $mdisker[$dk['keterangan']]['keterangan'] = $dk['keterangan'];
            $mdisker[$dk['keterangan']]['pengurangan'] = $dk['pengurangan'];
        }
                    
        $skpd = explode(";", $data['skpd']);
        if(stringStartWith('sekolah_', $skpd[0])){ // jika sekolah per kecamatan, ambil dinas pendidikan punya penandatanganan
            $flag_sekolah_kecamatan = 1;
            $expl = explode('_', $skpd[0]);
            $skpd[0] = $expl[1];
        }
        $param['bulan'] = $data['bulan'];
        $param['tahun'] = $data['tahun'];
        $param['skpd'] = $skpd[0];
        $temp = $this->readAbsensiAars($data, $flag_alpha = 0, 1, $flag_penerima_tpp);

        if($temp){
            $result['skpd'] = $temp['skpd'];
            $result['periode'] = $temp['periode'];
            $result['bulan'] = $temp['bulan'];
            $result['tahun'] = $temp['tahun'];
            $result['mdisker'] = $mdisker;
            $list_akumulasi_tidak_berkinerja = ['S', 'I', 'TK', 'DISP', 'C'];
            
            //cek jika ada hukdis
            if($flag_sekolah_kecamatan == 1){
                $uksearch = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerjamaster_kecamatan', $skpd[0])
                                    ->get()->row_array();
            } else {
                $uksearch = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $skpd[0])
                            ->get()->row_array();
            }

            $this->db->select('a.*, c.nama as nama_hd, b.nipbaru_ws, d.nama_jhd, b.nipbaru_ws, b.nama, b.gelar1, b.gelar2, f.nama_jabatan, g.nm_pangkat, b.statuspeg')
                    ->from('db_pegawai.pegdisiplin a')
                    ->join('db_pegawai.pegawai b', 'a.id_pegawai = b. id_peg')
                    ->join('db_pegawai.hd c', 'a.hd = c.idk')
                    ->join('db_pegawai.jhd d', 'a.jhd = d.id_jhd')
                    ->join('db_pegawai.jabatan f', 'b.jabatan = f.id_jabatanpeg')
                    ->join('db_pegawai.pangkat g', 'b.pangkat = g.id_pangkat')
                    // ->where('b.flag_terima_tpp', 1)
                    ->where('b.id_m_status_pegawai', 1)
                    ->where('a.tmt IS NOT NULL')
                    ->where('a.tmt !=', null)
                    ->where('a.tmt !=', '0000-00-00')
                    ->where_in('b.nipbaru_ws', $temp['temp_list_nip'])
                    ->where('a.flag_active', 1);

            // if($flag_rekap_tpp == 1 && in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)){
            //     $this->db->join('db_pegawai.unitkerja e', 'b.skpd = e.id_unitkerja')
            //             ->where('e.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
            // } else {
            //     $this->db->where('b.skpd', $skpd[0]); 
            // }
            $list_hukdis = $this->db->get()->result_array();
            $hukdis = null;
            if($list_hukdis){
                foreach($list_hukdis as $l){
                    if($l['tmt']){
                        $l['lama_potongan'] = floatval($l['lama_potongan']) - 1;
                        $valid_date = date('Y-m-t', strtotime($l['tmt'].'+ '.$l['lama_potongan'].' months'));
                        $list_date = getListDateByMonth($temp['bulan'], $temp['tahun']);
                        $last_date = $list_date[count($list_date)-1];
                        $expl = explode("-", $l['tmt']);
                        $bulan = $expl[1];
                        $min_date = $expl[0]."-".$bulan."-01"; // min. tanggal penarikan agar terbaca hukdis
                        $rekap_date = $temp['tahun']."-".$temp['bulan']."01";
                        
                        // if($this->general_library->isProgrammer() && $l['nipbaru_ws'] == "197401312010012002"){
                        //     dd($temp['bulan']." ; ".$temp['tahun']." ; ".$min_date." ; ".$valid_date);
                        // // //     dd($valid_date." ; ".$last_date);
                        // }
                        if($last_date <= $valid_date && $rekap_date >= $min_date){ // jika tanggal penarikan rekap TPP lebih dari min_date untuk terbaca hukdis
                            $hukdis[$l['nipbaru_ws']] = $l;
                        }
                    }
                }
            }
            // dd($list_hukdis);
            foreach($temp['result'] as $tr){
                if(isset($tr['nama_pegawai'])){
                    $result['result'][$tr['nip']]['nama_pegawai'] = $tr['nama_pegawai'];
                    $result['result'][$tr['nip']]['nip'] = $tr['nip'];
                    $result['result'][$tr['nip']]['eselon'] = $tr['eselon'];
                    $result['result'][$tr['nip']]['kelas_jabatan'] = $tr['kelas_jabatan'];
                    $result['result'][$tr['nip']]['nama_jabatan'] = $tr['nama_jabatan'];
                    $result['result'][$tr['nip']]['golongan'] = $tr['golongan'];
                    $result['result'][$tr['nip']]['rekap']['jhk'] = $tr['rekap']['jhk'];
                    
                    $result['result'][$tr['nip']]['rekap']['hadir'] = $tr['rekap']['hadir'];
                    $result['result'][$tr['nip']]['rekap']['tidak_hadir'] = 0;
                    
                    // $result['result'][$tr['nip']]['rekap']['hadir'] = $tr['rekap']['hadir'] + $tr['rekap']['exclude_cuti'];
                    // if($result['result'][$tr['nip']]['rekap']['hadir'] > $tr['rekap']['jhk']){
                    //     $result['result'][$tr['nip']]['rekap']['hadir'] = $tr['rekap']['jhk'];
                    // }
                    // $result['result'][$tr['nip']]['rekap']['tidak_hadir'] = 0 - $tr['rekap']['exclude_cuti'];
                    $result['result'][$tr['nip']]['rekap']['presentase_kehadiran'] = $tr['rekap']['hadir'] != 0 ? (($tr['rekap']['hadir'] +  $tr['rekap']['exclude_cuti']) / $tr['rekap']['jhk']) * 100 : 0;
                    if($result['result'][$tr['nip']]['rekap']['presentase_kehadiran'] > 100){
                        $result['result'][$tr['nip']]['rekap']['presentase_kehadiran'] = 100;
                    }
                    $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] = 0;
                    $result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja'] = 0;
                    $total_pengurangan = 0;
                    foreach($mdisker as $m){
                        if(isset($tr['rekap'][$m['keterangan']])){
                            $total = $tr['rekap'][$m['keterangan']];
                            if(in_array($m['keterangan'], $list_akumulasi_tidak_berkinerja) && $total > 0){
                                $result['result'][$tr['nip']]['rekap']['tidak_hadir'] += $total;
                            }
                            $pengurangan = floatval($total) * floatval($m['pengurangan']);
                            $total_pengurangan += $pengurangan;

                            $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['total'] = $total;
                            $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['pengurangan'] = $pengurangan;
                        } else {
                            $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['total'] = 0;
                            $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['pengurangan'] = 0;
                        }
                    }
                    
                    if(isset($hukdis[$tr['nip']])){
                        $mdisker['hukdis']['nama'] = 'Hukuman Disiplin '.$hukdis[$tr['nip']]['nama'].', '.$hukdis[$tr['nip']]['nama_jhd'];
                        $mdisker['hukdis']['keterangan'] = 'hukdis';
                        $mdisker['hukdis']['pengurangan'] = $hukdis[$tr['nip']]['besar_potongan'];

                        $result['result'][$tr['nip']]['rekap']['hukdis']['total'] = 1;
                        $result['result'][$tr['nip']]['rekap']['hukdis']['pengurangan'] = $hukdis[$tr['nip']]['besar_potongan'];

                        $total_pengurangan += $hukdis[$tr['nip']]['besar_potongan'];
                    }

                    if($total_pengurangan <= 100){
                        $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] = 100 - $total_pengurangan;
                        $result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja'] = $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] * floatval(TARGET_BOBOT_DISIPLIN_KERJA/100);
                        $result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja'] = formatTwoMaxDecimal($result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja']);
                    }
                }
                // if($tr['nip'] == '196809261988031001'){
                //     dd($result['result']['196809261988031001']);
                // }
            }
        }
        $result['hukdis'] = $hukdis;

        // function comparator($object1, $object2) {
        //     return $object1['kelas_jabatan'] < $object2['kelas_jabatan'];
        // }

        // usort($result['result'], 'comparator');

        // $this->db->where('id', $data_absen['id'])
        //         ->update('t_rekap_absen', [
        //             'json_rekap_penilaian_disiplin_kerja' => json_encode($result)
        //         ]);
        return $result;
    }

    public function rekapTppSearch($data){
        $result = null;
        $skpd = explode(";", $data['skpd']);
        $param['bulan'] = $data['bulan'];
        $param['tahun'] = $data['tahun'];
        $param['skpd'] = $skpd[0];

        $data_absen = $this->db->select('*')
                    ->from('t_rekap_absen')
                    ->where('bulan', $param['bulan'])
                    ->where('tahun', $param['tahun'])
                    ->where('id_unitkerja', $param['skpd'])
                    ->where('flag_active', 1)
                    ->get()->row_array();

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $param['skpd'])
                            ->get()->row_array();

        $data_absen['skpd'] = $unitkerja['nm_unitkerja'];
        $data_absen['bulan'] = $param['bulan'];
        $data_absen['tahun'] = $param['tahun'];
                            
        $this->session->set_userdata('data_absen_rekap_tpp', $data_absen);

        return $data_absen;
    }

    public function rekapPenilaianDisiplinSearchOld($data){
        $skpd = explode(";", $data['skpd']);

        $data_disiplin_kerja = $this->db->select('a.*, b.username as nip, d.keterangan')
                        ->from('t_disiplin_kerja a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                        ->where('a.bulan', $data['bulan'])
                        ->where('a.tahun', $data['tahun'])
                        ->where('c.skpd', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->where_in('a.id_m_jenis_disiplin_kerja', [1,2,14,15,16,17])
                        ->where('id_m_status_pegawai', 1)
                        ->get()->result_array();

        $data_rekap =  $this->db->select('*')
                        ->from('t_rekap_absen a')
                        ->where('id_unitkerja', $skpd[0])
                        ->where('bulan', floatval($data['bulan']))
                        ->where('tahun', floatval($data['tahun']))
                        ->where('flag_active', 1)
                        ->order_by('created_date', 'desc')
                        ->limit(1)
                        ->get()->row_array();

        $tempdk = null;
        $result = null;
        if($data_disiplin_kerja){
            foreach($data_disiplin_kerja as $dk){
                $tanggal = $dk['tanggal'] < 10 ? '0'.$dk['tanggal'] : $dk['tanggal'];
                $bulan = $dk['bulan'] < 10 ? '0'.$dk['bulan'] : $dk['bulan'];
                $tempdk[$dk['nip']][$tanggal.'-'.$bulan.'-'.$dk['tahun']] = $dk['keterangan'];
            }
        }

        if($data_rekap){
            $i = 0;
            $tmp_data_rekap = json_decode($data_rekap['json_result'], true);
            foreach($tmp_data_rekap as $d){
                if(isset($tempdk[$d['nip']])){
                    $tempdk_keys = array_keys($tempdk[$d['nip']]);
                    foreach($tempdk_keys as $t){
                        $d['absensi'][$t]['masuk']['data'] = $tempdk[$d['nip']][$t];
                    }
                }

                $result[$i]['nama_pegawai'] = $d['nama_pegawai'];
                $result[$i]['nip'] = $d['nip'];
                $result[$i]['rekap_absensi'] = $d['rekap_absensi'];
                $result[$i]['rekap_absensi']['sakit'] = 0;
                $result[$i]['rekap_absensi']['izin'] = 0;
                $result[$i]['rekap_absensi']['cuti'] = 0;
                $result[$i]['rekap_absensi']['sidak'] = 0;
                $result[$i]['rekap_absensi']['mtti'] = 0;
                $result[$i]['rekap_absensi']['keneg'] = 0;
                $result[$i]['rekap_absensi']['tl'] = 0;
                $result[$i]['rekap_absensi']['dispensasi'] = 0;
                $result[$i]['rekap_absensi']['tb'] = 0;

                foreach($d['absensi'] as $a){
                    switch ($a) {
                        case "S" : $result[$i]['sakit']++;
                        case "I" : $result[$i]['i']++;
                        case "C" : $result[$i]['cuti']++;
                        case "SIDAK" : $result[$i]['sidak']++;
                        case "MTTI" : $result[$i]['mtti']++;
                        case "KENEG" : $result[$i]['keneg']++;
                        case "TL" : $result[$i]['tl']++;
                        case "DISP" : $result[$i]['dispensasi']++;
                        case "TB" : $result[$i]['tb']++;
                    }

                    dd($a);
                }
                $i++;
            }
        }
        return $result;
    }

    public function rekapKehadiran($data, $parameter){
        $skpd = explode(";", $parameter['skpd']);

        $data_disiplin_kerja = $this->db->select('a.*, b.username as nip, d.keterangan')
                        ->from('t_disiplin_kerja a')
                        ->join('m_user b', 'a.id_m_user = b.id')
                        ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
                        ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                        ->where('a.bulan', $parameter['bulan'])
                        ->where('a.tahun', $parameter['tahun'])
                        ->where('c.skpd', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->where('id_m_status_pegawai', 1)
                        ->where_in('a.id_m_jenis_disiplin_kerja', [1,2,14,15,16,17])
                        ->get()->result_array();

        $tempdk = null;
        $result = null;
        if($data_disiplin_kerja){
            foreach($data_disiplin_kerja as $dk){
                $tanggal = $dk['tanggal'] < 10 ? '0'.$dk['tanggal'] : $dk['tanggal'];
                $bulan = $dk['bulan'] < 10 ? '0'.$dk['bulan'] : $dk['bulan'];
                $tempdk[$dk['nip']][$tanggal.'-'.$bulan.'-'.$dk['tahun']] = $dk['keterangan'];
            }
        }

        $data_rekap = $data;
        if($data_rekap){
            $i = 0;
            $tmp_data_rekap = $data_rekap;
            foreach($tmp_data_rekap as $d){
                if(isset($tempdk[$d['nip']])){
                    $tempdk_keys = array_keys($tempdk[$d['nip']]);
                    foreach($tempdk_keys as $t){
                        $d['absensi'][$t]['masuk']['data'] = $tempdk[$d['nip']][$t];
                    }
                }

                $result[$i]['nama_pegawai'] = $d['nama_pegawai'];
                $result[$i]['nip'] = $d['nip'];
                $ra = null;
                if(isset($d['rekap_absensi'])){
                    $ra = $d['rekap_absensi'];
                } else {
                    $ra['tmk1'] = 0;
                    $ra['tmk2'] = 0;
                    $ra['tmk3'] = 0;
                    $ra['pksw1'] = 0;
                    $ra['pksw2'] = 0;
                    $ra['pksw3'] = 0;
                }
                $result[$i]['rekap_absensi'] = $ra;
                $result[$i]['rekap_absensi']['sakit'] = 0;
                $result[$i]['rekap_absensi']['izin'] = 0;
                $result[$i]['rekap_absensi']['cuti'] = 0;
                $result[$i]['rekap_absensi']['sidak'] = 0;
                $result[$i]['rekap_absensi']['mtti'] = 0;
                $result[$i]['rekap_absensi']['keneg'] = 0;
                $result[$i]['rekap_absensi']['tl'] = 0;
                $result[$i]['rekap_absensi']['dispensasi'] = 0;
                $result[$i]['rekap_absensi']['tb'] = 0;

                if(isset($d['absensi'])){
                    foreach($d['absensi'] as $a){
                        switch ($a) {
                            case "S" : $result[$i]['rekap_absensi']['sakit']++;
                            case "I" : $result[$i]['rekap_absensi']['izin']++;
                            case "C" : $result[$i]['rekap_absensi']['cuti']++;
                            case "SIDAK" : $result[$i]['rekap_absensi']['sidak']++;
                            case "MTTI" : $result[$i]['rekap_absensi']['mtti']++;
                            case "KENEG" : $result[$i]['rekap_absensi']['keneg']++;
                            case "TL" : $result[$i]['rekap_absensi']['tl']++;
                            case "DISP" : $result[$i]['rekap_absensi']['dispensasi']++;
                            case "TB" : $result[$i]['rekap_absensi']['tb']++;
                        }
                    }
                }
                $i++;
            }
        }
        // dd(json_encode($result));
        return $result;
    }
    
    public function getDaftarPerhitunganTppNewOld($data, $param){
        $list_pegawai = null;
        foreach($data as $d){
            $list_pegawai['result'][$d['nipbaru_ws']] = $d;
        }
        $list_pegawai = $this->getDaftarPenilaianTpp($list_pegawai, $param);
        dd($list_pegawai);
    }

    public function getTppTambahan($data){
        $result = null;
        $skpd = explode(";", $data['skpd']);
        $exists = $this->db->select('*')
                        ->from('t_tpp_tambahan a')
                        ->where('a.id_unitkerja', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        $list_exists = null;
        if($exists){
            foreach($exists as $e){
                $list_exists[$e['id_m_tpp_tambahan']] = $e;
            }
        }

        $master = $this->db->select('*')
                        ->from('m_tpp_tambahan a')
                        ->where('a.flag_show', 1)
                        ->where('a.flag_active', 1)
                        ->get()->result_array();
        if($master){
            foreach($master as $m){
                if(!isset($list_exists[$m['id']])){
                    $result[] = $m;
                }
            }
        }

        return $result;
    }

    public function getDaftarPerhitunganTppNew($pagu_tpp, $param, $flag_rekap_tpp = 0){
        $exists = $this->db->select('*')
                            ->from('t_lock_tpp')
                            ->where('id_unitkerja', $param['id_unitkerja'])
                            ->where('flag_active', 1)
                            ->get()->row_array();

        if($exists && $exists['flag_use_this'] == 1){
            $result = json_decode($exists['meta_data'], true);
            $result['flag_use_this'] = 1;
            // dd($result);
            return $result;
        } else {
            $list_nip = null;
            $list_gaji = null;
            $list_pegawai = null;
            foreach($pagu_tpp as $pt){
                $list_pegawai['result'][$pt['nipbaru_ws']] = $pt;
                $list_nip[] = $pt['nipbaru_ws'];
            }

            $gaji = null;
            if($param['tahun'] >= 2025){
                $gaji = $this->db->select('*')
                                ->from('t_bkad_upload_gaji_detail')
                                ->where('bulan', $param['bulan'])
                                ->where('tahun', $param['tahun'])
                                ->where_in('nip', $list_nip)
                                ->where('flag_active', 1)
                                ->get()->result_array();
                if($gaji){
                    foreach($gaji as $g){
                        $list_gaji[$g['nip']] = $g;
                    }
                }
            }

            $list_pegawai = $this->getDaftarPenilaianTpp($list_pegawai, $param, $flag_rekap_tpp);

            $data_rekap = $this->rekapPenilaianDisiplinSearch($param, $flag_rekap_tpp);

            $hukdis = isset($data_rekap['hukdis']) ? $data_rekap['hukdis'] : null;

            foreach($data_rekap['result'] as $dr){
                $list_pegawai['result'][$dr['nip']]['rekap_kehadiran'] = $dr;
            }
            
            $rekap['jumlah_pegawai'] = 0;
            $rekap['rata_rata_presentase_kehadiran'] = 0;
            $rekap['total_presentase_kehadiran'] = 0;
            $rekap['rata_rata_bobot_disiplin_kerja'] = 0;
            $rekap['total_bobot_disiplin_kerja'] = 0;
            $rekap['rata_rata_bobot_produktivitas_kerja'] = 0;
            $rekap['total_bobot_produktivitas_kerja'] = 0;
            $rekap['pagu_tpp'] = 0;
            $rekap['selisih_capaian_pagu'] = 0;
            $rekap['jumlah_pajak_pph'] = 0;
            $rekap['bpjs'] = 0;
            $rekap['jumlah_yang_diterima'] = 0;
            $rekap['tpp_final'] = 0;

            $rekap['unitkerja'] = $this->db->select('*')
                                        ->from('db_pegawai.unitkerja')
                                        ->where('id_unitkerja', $param['id_unitkerja'])
                                        ->get()->result_array();

            $rekap_pppk['jumlah_pegawai'] = 0;
            $rekap_pppk['rata_rata_presentase_kehadiran'] = 0;
            $rekap_pppk['total_presentase_kehadiran'] = 0;
            $rekap_pppk['rata_rata_bobot_disiplin_kerja'] = 0;
            $rekap_pppk['total_bobot_disiplin_kerja'] = 0;
            $rekap_pppk['rata_rata_bobot_produktivitas_kerja'] = 0;
            $rekap_pppk['total_bobot_produktivitas_kerja'] = 0;
            $rekap_pppk['pagu_tpp'] = 0;
            $rekap_pppk['selisih_capaian_pagu'] = 0;
            $rekap_pppk['jumlah_pajak_pph'] = 0;
            $rekap_pppk['bpjs'] = 0;
            $rekap_pppk['jumlah_yang_diterima'] = 0;
            $rekap_pppk['tpp_final'] = 0;

            $result = null;

            $result['hukdis'] = isset($data_rekap['hukdis']) ? $data_rekap['hukdis'] : [];

            foreach($list_pegawai['result'] as $l){
                if(isset($l['nipbaru_ws'])){
                    $result[$l['nipbaru_ws']]['nama_pegawai'] = getNamaPegawaiFull($l);
                    $result[$l['nipbaru_ws']]['nip'] = $l['nipbaru_ws'];
                    $result[$l['nipbaru_ws']]['pangkat'] = $l['nm_pangkat'];
                    $result[$l['nipbaru_ws']]['id_pangkat'] = $l['id_pangkat'];
                    $result[$l['nipbaru_ws']]['nama_jabatan'] = $l['nama_jabatan'];
                    $result[$l['nipbaru_ws']]['kelas_jabatan'] = $l['kelas_jabatan'];
                    $result[$l['nipbaru_ws']]['flag_terima_tpp'] = $l['flag_terima_tpp'];
                    $result[$l['nipbaru_ws']]['statuspeg'] = $l['statuspeg'];
                    if(isset($l['flag_use_bpjs'])){
                        $result[$l['nipbaru_ws']]['flag_use_bpjs'] = $l['flag_use_bpjs'];
                    }
                    
                    // $result[$l['nipbaru_ws']]['nomor_golongan'] = $l['rekap_kehadiran']['golongan'];
                    $result[$l['nipbaru_ws']]['nomor_golongan'] = getGolonganByIdPangkat($l['id_pangkat']);
                    $result[$l['nipbaru_ws']]['eselon'] = isset($l['rekap_kehadiran']) ? $l['rekap_kehadiran']['eselon'] : null;
                    $result[$l['nipbaru_ws']]['pagu_tpp'] = $l['pagu_tpp'];
                    // if($l['nipbaru_ws'] == '197801302003122003'){
                    //     dd($param);
                    // }
                    if(isset($param['id_m_tpp_tambahan']) && $param['id_m_tpp_tambahan'] != 0){
                        $result[$l['nipbaru_ws']]['pagu_tpp'] = $l['pagu_tpp'] * ($param['presentasi_tpp_tambahan'] / 100);
                    }

                    // if(in_array($l['nipbaru_ws'], EXCLUDE_NIP)){
                    //     $result[$l['nipbaru_ws']]['pagu_tpp'] = 0;
                    // }

                    $result[$l['nipbaru_ws']]['bobot_komponen_kinerja'] = isset($l['komponen_kinerja']) ? $l['komponen_kinerja'][1] : 0;
                    $result[$l['nipbaru_ws']]['bobot_skp'] = isset($l['kinerja']) ? $l['kinerja']['rekap_kinerja']['bobot'] : 0;
                    $result[$l['nipbaru_ws']]['bobot_produktivitas_kerja'] = $result[$l['nipbaru_ws']]['bobot_komponen_kinerja'] + $result[$l['nipbaru_ws']]['bobot_skp'];
                    $result[$l['nipbaru_ws']]['bobot_produktivitas_kerja'] = formatTwoMaxDecimal($result[$l['nipbaru_ws']]['bobot_produktivitas_kerja']);

                    $result[$l['nipbaru_ws']]['bobot_disiplin_kerja'] = isset($l['rekap_kehadiran']) ? $l['rekap_kehadiran']['rekap']['capaian_bobot_disiplin_kerja'] : 0;
                    $result[$l['nipbaru_ws']]['bobot_disiplin_kerja'] = formatTwoMaxDecimal($result[$l['nipbaru_ws']]['bobot_disiplin_kerja']);

                    $result[$l['nipbaru_ws']]['presentase_kehadiran'] = isset($l['rekap_kehadiran']) ? ($l['rekap_kehadiran']['rekap']['presentase_kehadiran']) : 0;
                    $result[$l['nipbaru_ws']]['jhk'] = isset($l['rekap_kehadiran']) ? ($l['rekap_kehadiran']['rekap']['jhk']) : 0;
                    $rekap['jhk'] = $result[$l['nipbaru_ws']]['jhk'];
                    $rekap_pppk['jhk'] = $result[$l['nipbaru_ws']]['jhk'];
                    $result[$l['nipbaru_ws']]['hadir'] = isset($l['rekap_kehadiran']) ? ($l['rekap_kehadiran']['rekap']['hadir']) : 0;
                    $result[$l['nipbaru_ws']]['tidak_hadir'] = isset($l['rekap_kehadiran']) ? ($l['rekap_kehadiran']['rekap']['tidak_hadir']) : 0;

                    if(PERHITUNGAN_TPP_TESTING == 1){
                        $result[$l['nipbaru_ws']]['bobot_produktivitas_kerja'] = 60;
                        $result[$l['nipbaru_ws']]['bobot_disiplin_kerja'] = 40;
                        // $result[$p['nipbaru_ws']]['presentase_kehadiran'] = 100;
                    }

                    $result[$l['nipbaru_ws']]['presentase_tpp'] = formatTwoMaxDecimal(
                        floatval($result[$l['nipbaru_ws']]['bobot_produktivitas_kerja']) + 
                        floatval($result[$l['nipbaru_ws']]['bobot_disiplin_kerja']));
                    

                    // untuk desember tahun 2025, cek yang cuti tahunan dan menyebabkan kehadiran < 50%, agar dibuatkan kehadirannya menjadi 100%
                    // if($param['bulan'] != 12 && $param['tahun'] != 2025){
                    // if($this->general_library->isProgrammer() && $l['nipbaru_ws'] == '197608072003122009'){
                    //     dd($result[$l['nipbaru_ws']]);
                    // }

                        if($result[$l['nipbaru_ws']]['presentase_kehadiran'] < 25){
                            $result[$l['nipbaru_ws']]['presentase_tpp'] = 0;
                        } else if($result[$l['nipbaru_ws']]['presentase_kehadiran'] >= 25 && $result[$l['nipbaru_ws']]['presentase_kehadiran'] < 50){
                            $result[$l['nipbaru_ws']]['presentase_tpp'] *= 0.5;
                        }
                    // } else {
                        // if($this->general_library->isProgrammer()){
                        //     dd(json_encode($data_rekap));
                        // }
                    // }

                    // if($this->general_library->getId() == 16){
                    //     dd(json_encode($data_rekap));
                    // }
                    if($l['nipbaru_ws'] == '199502182020121013'){
                        // dd($list_gaji);
                    }

                    $result[$l['nipbaru_ws']]['presentase_tpp'] = formatTwoMaxDecimal($result[$l['nipbaru_ws']]['presentase_tpp']);

                    $result[$l['nipbaru_ws']]['besaran_tpp'] = pembulatan((floatval($result[$l['nipbaru_ws']]['presentase_tpp']) * floatval($result[$l['nipbaru_ws']]['pagu_tpp'])) / 100);
                    // $result[$l['nipbaru_ws']]['besaran_tpp'] = pembulatan($result[$l['nipbaru_ws']]['besaran_tpp']);
                    // if($this->general_library->isProgrammer()){
                    //     if($l['nipbaru_ws'] == '198110262009022003'){
                    //         dd($result[$l['nipbaru_ws']]);
                    //     }
                    // }

                    // yang lama pakai perhitungan pajak yang ini
                    $result[$l['nipbaru_ws']]['pph'] = getPphByIdPangkat($l['id_pangkat']);

                    // yang baru pakai perhitungan pajak yang ini
                    // if($param['tahun'] >= 2025){
                    //     $result[$l['nipbaru_ws']]['pph'] = getPphByPenghasilanBruto($result[$l['nipbaru_ws']]['besaran_tpp']);
                    // }

                    $result[$l['nipbaru_ws']]['nominal_pph'] = pembulatan((floatval($result[$l['nipbaru_ws']]['pph']) / 100) * $result[$l['nipbaru_ws']]['besaran_tpp']);
                    // $rounded = floor($result[$l['nipbaru_ws']]['nominal_pph']);
                    // $whole = $result[$l['nipbaru_ws']]['nominal_pph'] - $rounded;
                    // if($whole != 0){
                    //     // pembulatan angka belakang comma, jika 0.5 ke atas, tambahkan 1
                    //     $result[$l['nipbaru_ws']]['nominal_pph'] = $whole >= 0.5 ? $rounded + 1 : $rounded;
                    // }
                    
                    $result[$l['nipbaru_ws']]['prestasi_kerja'] = formatTwoMaxDecimal($l['prestasi_kerja']); 
                    $result[$l['nipbaru_ws']]['beban_kerja'] = formatTwoMaxDecimal($l['beban_kerja']);  
                    $result[$l['nipbaru_ws']]['kondisi_kerja'] = formatTwoMaxDecimal($l['kondisi_kerja']);
                    $result[$l['nipbaru_ws']]['total_presentase_kriteria'] = formatTwoMaxDecimal(
                        floatval($result[$l['nipbaru_ws']]['prestasi_kerja']) +
                        floatval($result[$l['nipbaru_ws']]['beban_kerja']) + 
                        floatval($result[$l['nipbaru_ws']]['kondisi_kerja'])
                    );

                    if($this->general_library->isProgrammer()){
                        if($result[$l['nipbaru_ws']]['total_presentase_kriteria'] == 0){
                            // dd($result[$l['nipbaru_ws']]);
                        }
                    }

                    // decimal presentasi kerja
                    $result[$l['nipbaru_ws']]['presentasi_prestasi_kerja'] = ($result[$l['nipbaru_ws']]['prestasi_kerja'] /
                            $result[$l['nipbaru_ws']]['total_presentase_kriteria']);
                    $result[$l['nipbaru_ws']]['presentasi_beban_kerja'] = ($result[$l['nipbaru_ws']]['beban_kerja'] /
                            $result[$l['nipbaru_ws']]['total_presentase_kriteria']);
                    $result[$l['nipbaru_ws']]['presentasi_kondisi_kerja'] = ($result[$l['nipbaru_ws']]['kondisi_kerja'] /
                            $result[$l['nipbaru_ws']]['total_presentase_kriteria']);

                    $result[$l['nipbaru_ws']]['tpp_diterima'] = 
                        pembulatan($result[$l['nipbaru_ws']]['besaran_tpp']) -
                        pembulatan($result[$l['nipbaru_ws']]['nominal_pph']);
                    // if($l['nipbaru_ws'] == '197707042010011005'){
                    //     $result[$l['nipbaru_ws']]['besaran_tpp'] = 5118036;
                    // }

                    if(isset($list_gaji[$l['nipbaru_ws']])){
                        $result[$l['nipbaru_ws']]['besaran_gaji'] = $list_gaji[$l['nipbaru_ws']]['gaji'];
                    } else {
                        $result[$l['nipbaru_ws']]['besaran_gaji'] = $l['besaran_gaji'];
                    }

                    $result[$l['nipbaru_ws']]['bpjs'] = (0.01 * $result[$l['nipbaru_ws']]['besaran_tpp']);

                    // capaian tpp presentasi kerja
                    $result[$l['nipbaru_ws']]['capaian_tpp_prestasi_kerja'] = ($result[$l['nipbaru_ws']]['besaran_tpp'] *
                        ($result[$l['nipbaru_ws']]['prestasi_kerja'] /
                        $result[$l['nipbaru_ws']]['total_presentase_kriteria']));
                    $result[$l['nipbaru_ws']]['capaian_tpp_beban_kerja'] = ($result[$l['nipbaru_ws']]['besaran_tpp'] *
                        ($result[$l['nipbaru_ws']]['beban_kerja'] /
                        $result[$l['nipbaru_ws']]['total_presentase_kriteria']));
                    $result[$l['nipbaru_ws']]['capaian_tpp_kondisi_kerja'] = ($result[$l['nipbaru_ws']]['besaran_tpp'] *
                        ($result[$l['nipbaru_ws']]['kondisi_kerja'] /
                        $result[$l['nipbaru_ws']]['total_presentase_kriteria']));

                    // pph presentasi kerja
                    $result[$l['nipbaru_ws']]['pph_prestasi_kerja'] = 
                        (floatval($result[$l['nipbaru_ws']]['pph'] / 100) *
                        ($result[$l['nipbaru_ws']]['capaian_tpp_prestasi_kerja']));
                    $result[$l['nipbaru_ws']]['pph_beban_kerja'] = 
                        (floatval($result[$l['nipbaru_ws']]['pph'] / 100) *
                        ($result[$l['nipbaru_ws']]['capaian_tpp_beban_kerja']));
                    $result[$l['nipbaru_ws']]['pph_kondisi_kerja'] = 
                        (floatval($result[$l['nipbaru_ws']]['pph'] / 100) *
                        ($result[$l['nipbaru_ws']]['capaian_tpp_kondisi_kerja']));

                    // bpjs presentasi kerja
                    $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'] = 
                        (($result[$l['nipbaru_ws']]['capaian_tpp_prestasi_kerja'] * 1) / 100);
                    $result[$l['nipbaru_ws']]['bpjs_beban_kerja'] = 
                        (($result[$l['nipbaru_ws']]['capaian_tpp_beban_kerja'] * 1) / 100);
                    $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'] = 
                        (($result[$l['nipbaru_ws']]['capaian_tpp_kondisi_kerja'] * 1) / 100);
                    
                    // jumlah setelah pph presentasi kerja
                    $result[$l['nipbaru_ws']]['jumlah_setelah_pph_prestasi_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_prestasi_kerja'] - ($result[$l['nipbaru_ws']]['pph_prestasi_kerja']));
                    $result[$l['nipbaru_ws']]['jumlah_setelah_pph_beban_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_beban_kerja'] - ($result[$l['nipbaru_ws']]['pph_beban_kerja']));
                    $result[$l['nipbaru_ws']]['jumlah_setelah_pph_kondisi_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_kondisi_kerja'] - ($result[$l['nipbaru_ws']]['pph_kondisi_kerja']));

                    if($l['nipbaru_ws'] == '198112202010011004'){
                        // dd($result[$l['nipbaru_ws']]);
                    }

                    if(floatval($result[$l['nipbaru_ws']]['besaran_tpp']) + floatval($result[$l['nipbaru_ws']]['besaran_gaji']) >= 12000000){
                        $bpjs_gaji = (0.01 * $result[$l['nipbaru_ws']]['besaran_gaji']);
                        $bpjs_12 = (0.01 * 12000000);
                        $result[$l['nipbaru_ws']]['bpjs_gaji'] = $bpjs_gaji;
                        $result[$l['nipbaru_ws']]['bpjs_12'] = $bpjs_12;
                        $result[$l['nipbaru_ws']]['bpjs'] = ($bpjs_12 - $bpjs_gaji);
                        $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'] = 
                            ($result[$l['nipbaru_ws']]['bpjs'] * $result[$l['nipbaru_ws']]['presentasi_prestasi_kerja']);
                        $result[$l['nipbaru_ws']]['bpjs_beban_kerja'] = 
                            ($result[$l['nipbaru_ws']]['bpjs'] * $result[$l['nipbaru_ws']]['presentasi_beban_kerja']);
                        $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'] = 
                            ($result[$l['nipbaru_ws']]['bpjs'] * $result[$l['nipbaru_ws']]['presentasi_kondisi_kerja']);
                    }

                    // if($this->general_library->isProgrammer()){
                    //     dd($l);
                    // }

                    // $result[$l['nipbaru_ws']]['bpjs'] = round($result[$l['nipbaru_ws']]['bpjs'], 2);
                    // $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'] = round($result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'], 2);
                    // $result[$l['nipbaru_ws']]['bpjs_beban_kerja'] = round($result[$l['nipbaru_ws']]['bpjs_beban_kerja'], 2);
                    // $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'] = round($result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'], 2);

                    if(isset($result[$l['nipbaru_ws']]['flag_use_bpjs']) && $result[$l['nipbaru_ws']]['flag_use_bpjs'] == 0){
                        $data_pegawai_plt = $this->db->select('*')
                                                    ->from('db_pegawai.pegawai')
                                                    ->where('nipbaru_ws', $l['nipbaru_ws'])
                                                    ->get()->row_array();
                        if($data_pegawai_plt){
                            $skpd = explode(";", $param['skpd']);
                            if($data_pegawai_plt['skpd'] != $skpd[0]){
                                //jika PLT / PLH di PD lain
                                $result[$l['nipbaru_ws']]['bpjs'] = 0;
                                $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'] = 0;
                                $result[$l['nipbaru_ws']]['bpjs_beban_kerja'] = 0;
                                $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'] = 0;
                            } else {
                                
                            }
                        }
                    }

                    //TPP Final
                    // $result[$l['nipbaru_ws']]['tpp_final'] = 
                    //     ($result[$l['nipbaru_ws']]['tpp_diterima'] - 
                    //     $result[$l['nipbaru_ws']]['bpjs']);
                    $result[$l['nipbaru_ws']]['tpp_final_prestasi_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_prestasi_kerja'] -
                        $result[$l['nipbaru_ws']]['pph_prestasi_kerja'] -
                        $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja']);
                    $result[$l['nipbaru_ws']]['tpp_final_beban_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_beban_kerja'] -
                        $result[$l['nipbaru_ws']]['pph_beban_kerja'] -
                        $result[$l['nipbaru_ws']]['bpjs_beban_kerja']);
                    $result[$l['nipbaru_ws']]['tpp_final_kondisi_kerja'] = 
                        ($result[$l['nipbaru_ws']]['capaian_tpp_kondisi_kerja'] -
                        $result[$l['nipbaru_ws']]['pph_kondisi_kerja'] -
                        $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja']);
                    
                    $result[$l['nipbaru_ws']]['tpp_final_permintaan_bkad'] = 
                        ($result[$l['nipbaru_ws']]['tpp_final_prestasi_kerja']) +
                        ($result[$l['nipbaru_ws']]['tpp_final_beban_kerja']) +
                        ($result[$l['nipbaru_ws']]['tpp_final_kondisi_kerja']);

                    $result[$l['nipbaru_ws']]['tpp_final'] = 
                        ($result[$l['nipbaru_ws']]['tpp_final_prestasi_kerja']) +
                        ($result[$l['nipbaru_ws']]['tpp_final_beban_kerja']) +
                        ($result[$l['nipbaru_ws']]['tpp_final_kondisi_kerja']);
                    
                    $result[$l['nipbaru_ws']]['formatted_tpp_final_permintaan_bkad'] = formatCurrencyWithoutRp($result[$l['nipbaru_ws']]['tpp_final_permintaan_bkad'], 0);
                    $result[$l['nipbaru_ws']]['formatted_tpp_final'] = formatCurrencyWithoutRp($result[$l['nipbaru_ws']]['tpp_final'], 0);

                    $result[$l['nipbaru_ws']]['nominal_pph'] = 
                        $result[$l['nipbaru_ws']]['pph_prestasi_kerja'] +
                        $result[$l['nipbaru_ws']]['pph_beban_kerja'] +
                        $result[$l['nipbaru_ws']]['pph_kondisi_kerja'];
                        
                    // $result[$l['nipbaru_ws']]['tpp_diterima'] =
                    //     $result[$l['nipbaru_ws']]['jumlah_setelah_pph_prestasi_kerja'] +
                    //     $result[$l['nipbaru_ws']]['jumlah_setelah_pph_beban_kerja'] +
                    //     $result[$l['nipbaru_ws']]['jumlah_setelah_pph_kondisi_kerja'];

                    $result[$l['nipbaru_ws']]['bpjs'] =
                        $result[$l['nipbaru_ws']]['bpjs_prestasi_kerja'] +
                        $result[$l['nipbaru_ws']]['bpjs_beban_kerja'] +
                        $result[$l['nipbaru_ws']]['bpjs_kondisi_kerja'];

                    $result[$l['nipbaru_ws']]['tpp_final'] = 
                        pembulatan($result[$l['nipbaru_ws']]['besaran_tpp']) -
                        pembulatan($result[$l['nipbaru_ws']]['nominal_pph']) -
                        pembulatan($result[$l['nipbaru_ws']]['bpjs']);

                    if($this->general_library->isProgrammer()){
                        // dd(pembulatan($result[$l['nipbaru_ws']]['besaran_tpp']).' ; '.pembulatan($result[$l['nipbaru_ws']]['nominal_pph']).' ; '.pembulatan($result[$l['nipbaru_ws']]['bpjs']).' ; '.$result[$l['nipbaru_ws']]['tpp_final']);
                        // dd($result[$l['nipbaru_ws']]);
                    }

                    if($result[$l['nipbaru_ws']]['statuspeg'] == 3){ //jika PPPK
                        if($result[$l['nipbaru_ws']]['flag_terima_tpp'] == 1){ //jika terima TPP
                            $rekap_pppk['jumlah_pegawai']++;
                            $rekap_pppk['total_presentase_kehadiran'] += $result[$l['nipbaru_ws']]['presentase_kehadiran'];
                            $rekap_pppk['total_bobot_disiplin_kerja'] += $result[$l['nipbaru_ws']]['bobot_disiplin_kerja'];
                            $rekap_pppk['total_bobot_produktivitas_kerja'] += $result[$l['nipbaru_ws']]['bobot_produktivitas_kerja'];
                            $rekap_pppk['pagu_tpp'] += $result[$l['nipbaru_ws']]['pagu_tpp'];
                            $rekap_pppk['jumlah_yang_diterima'] += $result[$l['nipbaru_ws']]['tpp_final_permintaan_bkad'];
                            $rekap_pppk['jumlah_pajak_pph'] += $result[$l['nipbaru_ws']]['nominal_pph'];
                            $rekap_pppk['bpjs'] += ($result[$l['nipbaru_ws']]['bpjs']);
                            $rekap_pppk['tpp_final'] += $result[$l['nipbaru_ws']]['tpp_final'];

                            $result['pppk'][$l['nipbaru_ws']] = $result[$l['nipbaru_ws']];
                            unset($result[$l['nipbaru_ws']]);
                        }
                    } else {
                        if($result[$l['nipbaru_ws']]['flag_terima_tpp'] == 1){ //jika terima TPP
                            $rekap['jumlah_pegawai']++;
                            $rekap['total_presentase_kehadiran'] += $result[$l['nipbaru_ws']]['presentase_kehadiran'];
                            $rekap['total_bobot_disiplin_kerja'] += $result[$l['nipbaru_ws']]['bobot_disiplin_kerja'];
                            $rekap['total_bobot_produktivitas_kerja'] += $result[$l['nipbaru_ws']]['bobot_produktivitas_kerja'];
                            $rekap['pagu_tpp'] += $result[$l['nipbaru_ws']]['pagu_tpp'];
                            $rekap['jumlah_yang_diterima'] += $result[$l['nipbaru_ws']]['tpp_final_permintaan_bkad'];
                            $rekap['jumlah_pajak_pph'] += $result[$l['nipbaru_ws']]['nominal_pph'];
                            $rekap['bpjs'] += ($result[$l['nipbaru_ws']]['bpjs']);
                            $rekap['tpp_final'] += $result[$l['nipbaru_ws']]['tpp_final'];
                        }
                    }
                }
            }

            $rekap['rata_rata_presentase_kehadiran'] = ($rekap['total_presentase_kehadiran'] / $rekap['jumlah_pegawai']);
            $rekap['rata_rata_bobot_disiplin_kerja'] = ($rekap['total_bobot_disiplin_kerja'] / $rekap['jumlah_pegawai']);
            $rekap['rata_rata_bobot_produktivitas_kerja'] = ($rekap['total_bobot_produktivitas_kerja'] / $rekap['jumlah_pegawai']);
            $rekap['selisih_capaian_pagu'] = ($rekap['pagu_tpp'] - $rekap['jumlah_yang_diterima']);
            $result['rekap'] = $rekap;
            
            if($rekap_pppk['jumlah_pegawai'] > 0){
                $rekap_pppk['rata_rata_presentase_kehadiran'] = ($rekap_pppk['total_presentase_kehadiran'] / $rekap_pppk['jumlah_pegawai']);
                $rekap_pppk['rata_rata_bobot_disiplin_kerja'] = ($rekap_pppk['total_bobot_disiplin_kerja'] / $rekap_pppk['jumlah_pegawai']);
                $rekap_pppk['rata_rata_bobot_produktivitas_kerja'] = ($rekap_pppk['total_bobot_produktivitas_kerja'] / $rekap_pppk['jumlah_pegawai']);
                $rekap_pppk['selisih_capaian_pagu'] = ($rekap_pppk['pagu_tpp'] - $rekap_pppk['jumlah_yang_diterima']);
            }
            $result['rekap_pppk'] = $rekap_pppk;

            $result['kepalabkpsdm'] = $this->db->select('a.*, b.nama_jabatan, c.nm_pangkat')
                                            ->from('db_pegawai.pegawai a')
                                            ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                                            ->join('db_pegawai.pangkat c', 'a.pangkat = c.id_pangkat')
                                            ->where('b.kepalaskpd', 1)
                                            ->where('a.skpd', ID_UNITKERJA_BKPSDM)
                                            ->get()->row_array();
            if($this->general_library->isProgrammer()){
                // dd($result);
            }
            return $result;
        }
    }

    public function getDaftarPerhitunganTpp($pagu_tpp, $rekap, $param, $flag_rekap_tpp = 0){
        $data_disiplin_kerja = null;
        // if(isset($data_rekap['penilaian_disiplin_kerja'])){
        //     $data_disiplin_kerja = null;
        //     $data_disiplin_kerja = $data_rekap['penilaian_disiplin_kerja'];
        // } else {
            $data_disiplin_kerja = $this->rekapPenilaianDisiplinSearch($param, $flag_rekap_tpp);
            $data_disiplin_kerja['flag_print'] = 0;
            $data_disiplin_kerja['use_header'] = 0;
            $temp['penilaian_disiplin_kerja'] = $data_disiplin_kerja;
            // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $data_disiplin_kerja);
        // }
        $temp_disiplin_kerja = $data_disiplin_kerja;
        $data_disiplin_kerja = null;
        $list_akumulasi_disiplin_kerja = ['S', 'I', 'TK', 'DISP', 'C'];
        foreach($temp_disiplin_kerja['result'] as $tdk){
            if(isset($tdk['nip'])){
                $tdk['rekap']['presentasi_kehadiran'] = 0;
                foreach($tdk['rekap'] as $tdkr){
                    if(in_array($tdkr, $list_akumulasi_disiplin_kerja)){
                        $tdk['rekap']['hadir']--;
                    }
                }
                $tdk['rekap']['presentasi_kehadiran'] = (floatval($tdk['rekap']['hadir']) / floatval($tdk['rekap']['jhk'])) * 100;
                $data_disiplin_kerja[$tdk['nip']] = $tdk;
            }
        }
        // dd($data_disiplin_kerja);
        $data_kinerja = null;
        // if(isset($data_rekap['produktivitas_kerja'])){
        //     $data_kinerja = null;
        //     $data_kinerja = $data_rekap['produktivitas_kerja'];
        // } else {
            $data_kinerja = $this->rekapPenilaianSearch($param);
            $data_kinerja['parameter'] = $param;
            $data_kinerja['flag_print'] = 0;
            $data_kinerja['use_header'] = 0;
            $temp['produktivitas_kerja'] = $data_kinerja;
            // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $data_kinerja);
        // }
        $temp_kinerja = $data_kinerja;
        $data_kinerja = null;
        foreach($temp_kinerja as $tdk){
            if(isset($tdk['nip'])){
                $data_kinerja[$tdk['nip']] = $tdk;
            }
        }
        
        $result = null;
        foreach($pagu_tpp as $p){
            if(isset($data_disiplin_kerja[$p['nipbaru_ws']]) && isset($data_kinerja[$p['nipbaru_ws']])){
                $explode_golongan_all = explode(", ", $p['nm_pangkat']);
                if(isset($explode_golongan_all[1])){
                    $explode_golongan_number = explode("/", $explode_golongan_all[1]);
                }
                $result[$p['nipbaru_ws']]['nama_pegawai'] = getNamaPegawaiFull($p);
                $result[$p['nipbaru_ws']]['nip'] = $p['nipbaru_ws'];
                $result[$p['nipbaru_ws']]['pangkat'] = $p['nm_pangkat'];
                $result[$p['nipbaru_ws']]['id_pangkat'] = $p['id_pangkat'];
                $result[$p['nipbaru_ws']]['nama_jabatan'] = $p['nama_jabatan'];
                $result[$p['nipbaru_ws']]['kelas_jabatan'] = $p['kelas_jabatan'];
                // $result[$p['nipbaru_ws']]['nomor_golongan'] = !isset($explode_golongan_all[1]) ? 0 : $explode_golongan_number[0];
                $result[$p['nipbaru_ws']]['nomor_golongan'] = getGolonganByIdPangkat($p['id_pangkat']);
                $result[$p['nipbaru_ws']]['eselon'] = $data_kinerja[$p['nipbaru_ws']]['eselon'];
                $result[$p['nipbaru_ws']]['pagu_tpp'] = $p['pagu_tpp'];
                
                $result[$p['nipbaru_ws']]['bobot_produktivitas_kerja'] = $data_kinerja[$p['nipbaru_ws']]['bobot_capaian_produktivitas_kerja'];
                $result[$p['nipbaru_ws']]['bobot_disiplin_kerja'] = $data_disiplin_kerja[$p['nipbaru_ws']]['rekap']['capaian_bobot_disiplin_kerja'];
                
                $result[$p['nipbaru_ws']]['presentasi_kehadiran'] = $data_disiplin_kerja[$p['nipbaru_ws']]['rekap']['presentasi_kehadiran'];

                // if($p['nipbaru_ws'] == '199502182020121013'){
                //     dd($result[$p['nipbaru_ws']]);
                // }

                if(PERHITUNGAN_TPP_TESTING == 1){
                    $result[$p['nipbaru_ws']]['bobot_produktivitas_kerja'] = 60;
                    $result[$p['nipbaru_ws']]['bobot_disiplin_kerja'] = 40;
                    // $result[$p['nipbaru_ws']]['presentasi_kehadiran'] = 100;
                }

                $result[$p['nipbaru_ws']]['presentase_tpp'] = floatval($result[$p['nipbaru_ws']]['bobot_produktivitas_kerja']) + $result[$p['nipbaru_ws']]['bobot_disiplin_kerja'];
              
                if($result[$p['nipbaru_ws']]['presentasi_kehadiran'] < 25){
                    $result[$p['nipbaru_ws']]['presentase_tpp'] = 0;
                } else if($result[$p['nipbaru_ws']]['presentasi_kehadiran'] >= 25 && $result[$p['nipbaru_ws']]['presentasi_kehadiran'] < 50){
                    $result[$p['nipbaru_ws']]['presentase_tpp'] *= 0.5;
                }

                $result[$p['nipbaru_ws']]['besaran_tpp'] = (floatval($result[$p['nipbaru_ws']]['presentase_tpp']) * floatval($p['pagu_tpp'])) / 100;
                // $result[$p['nipbaru_ws']]['besaran_tpp'] = roundDown($result[$p['nipbaru_ws']]['besaran_tpp'], 3);
                $result[$p['nipbaru_ws']]['pph'] = getPphByIdPangkat($p['id_pangkat']);
                $result[$p['nipbaru_ws']]['nominal_pph'] = ((floatval($result[$p['nipbaru_ws']]['pph']) / 100) * $result[$p['nipbaru_ws']]['besaran_tpp']);
                $result[$p['nipbaru_ws']]['tpp_diterima'] = pembulatan($result[$p['nipbaru_ws']]['besaran_tpp']) - pembulatan($result[$p['nipbaru_ws']]['nominal_pph']);
            
                // if($result[$p['nipbaru_ws']]['nip'] == "199510092019031001") {
                //     dd($result[$p['nipbaru_ws']]);
                // }
            
            }
        }
        
        return $result;
    }

    public function readAbsensiAars($param, $flag_alpha = 0, $flag_rekap_tpp = 0, $flag_penerima_tpp = 1){
        $result = null;
        $skpd = explode(";", $param['skpd']);
        // dd($skpd);
        $param['id_unitkerja'] = $skpd[0];
        $param['nm_unitkerja'] = $skpd[1];
        return $this->buildDataAbsensi($param, 1, $flag_alpha, 0, $flag_rekap_tpp, $flag_penerima_tpp);
        
        // $list_data_absen = $this->db->select('a.*, c.*, b.username as nip')
        //                 ->from('db_sip.absen a')
        //                 ->join('m_user b', 'a.user_id = b.id')
        //                 ->join('db_pegawai.pegawai c', 'b.username = c.nipbaru_ws')
        //                 ->where('MONTH(a.tgl)', $param['bulan'])
        //                 ->where('YEAR(a.tgl)', $param['tahun'])
        //                 ->where('c.skpd', $skpd[0])
        //                 ->order_by('a.tgl')
        //                 ->get()->result_array();

        // if($list_data_absen){
        //     foreach($list_data_absen as $ld){
        //         $result['data_absen'][$ld['nip']][$ld['tgl']] = $ld;
        //     }
        // }
        // dd($result['data_absen']);
    }

    public function cronRekapAbsen($flag_send_wa = 1){
        $cron = $this->db->select('*')
                        ->from('t_cron_rekap_absen')
                        ->where('flag_sent', 0)
                        ->where('flag_active', 1)
                        // ->limit(1)
                        ->get()->result_array();
        if($cron){
            foreach($cron as $c){
                $fileurl = "";
                if($c['url_file'] && file_exists($c['url_file'])){
                    $explode = explode("/", $c['url_file']);
                    $filename = $explode[2];
                    $fileurl = $c['url_file'];
                } else {
                    $unitkerja = $this->db->select('*')
                                    ->from('db_pegawai.unitkerja')
                                    ->where('id_unitkerja', $c['id_unitkerja'])
                                    ->get()->row_array();
                    if($unitkerja){
                        $params = [
                            'skpd' => $unitkerja['id_unitkerja'].';'.$unitkerja['nm_unitkerja'],
                            'bulan' => $c['bulan'],
                            'tahun' => $c['tahun']
                        ];
                        $data['result'] = $this->rekap->readAbsensiAars($params,0,0,0);
                        $data['flag_print'] = 1;
                        if($data['result']){
                            $data['skpd'] = $data['result']['skpd'];
                            $data['jam_kerja'] = $data['result']['jam_kerja'];
                            $data['jam_kerja_event'] = $data['result']['jam_kerja_event'];
                            $data['hari_libur'] = $data['result']['hari_libur'];
                            $data['info_libur'] = $data['result']['info_libur'];
                            $data['periode'] = $data['result']['periode'];
                            $data['disiplin_kerja'] = $data['result']['disiplin_kerja'];
                            $data['list_hari'] = $data['result']['list_hari'];
                            $data['flag_rekap_aars'] = true;
                            $data['nama_file'] = 'Rekap Absensi '.$data['skpd'].' Bulan '.$data['periode'].'.xls';
                            $this->session->set_userdata('rekap_absen_aars', $data);
                            $data = null;
                            $data = $this->session->userdata('rekap_absen_aars');
                            $data['flag_print'] = 1;
                            $data['flag_pdf'] = 1;
                            $mpdf = new \Mpdf\Mpdf([
                                'format' => 'Legal-L',
                                'debug' => true
                            ]);
                            $html = $this->load->view('rekap/V_RekapAbsensiResultNew', $data, true);
                            $mpdf->WriteHTML($html);
                            $mpdf->showImageErrors = true;
                            // $mpdf->Output('assets/arsipabsensibulanan' . 'Rekap Absensi '.$data['skpd'].' Bulan '.$data['periode'].'.pdf', \Mpdf\Output\Destination::FILE);
                            
                            $filename = 'Rekap Absensi '.$data['skpd'].' Bulan '.$data['periode'].'.pdf';
                            if($flag_send_wa == 1){
                                $fileurl = 'assets/arsipabsensibulanan/'.$filename;
                            } else {
                                $foldernametahun = 'assets/arsipabsensibulanan/cron/'.$params['tahun'];
                                if(!file_exists($foldernametahun) && !is_dir($foldernametahun)) {
                                    mkdir($foldernametahun, 0777);       
                                }

                                $foldernamebulan = $foldernametahun.'/'.$params['bulan'].' - '.getNamaBulan($params['bulan']);
                                if(!file_exists($foldernamebulan) && !is_dir($foldernamebulan)) {
                                    mkdir($foldernamebulan, 0777);       
                                }
                                
                                $fileurl = $foldernamebulan.'/'.$filename;
                            }
                            $mpdf->Output($fileurl, 'F');

                            if(file_exists($fileurl)){
                                $this->db->where('id', $c['id'])
                                        ->update('t_cron_rekap_absen', [
                                            'url_file' => $fileurl
                                        ]);
                                
                            }
                        }
                    }
                }

                if($flag_send_wa == 1){
                    // $sendWa = $this->maxchatlibrary->sendFile($c['no_hp'], $fileurl, $filename, $filename);
                    $cronWa = [
                        'sendTo' => $c['no_hp'],
                        'message' => $filename,
                        'filename' => $filename,
                        'fileurl' => $fileurl,
                        'type' => 'document'
                    ];
                    $this->general->saveToCronWa($cronWa);
                    // if($sendWa == true){
                        $this->db->where('id', $c['id'])
                            ->update('t_cron_rekap_absen', [
                                'flag_sent' => 1,
                                'done_date' => date('Y-m-d H:i:s'),
                                'response' => 'success'
                            ]);
                    // } else {
                    //     $this->db->where('id', $c['id'])
                    //         ->update('t_cron_rekap_absen', [
                    //             'response' => $sendWa
                    //         ]);
                    // }
                } else {
                    $this->db->where('id', $c['id'])
                            ->update('t_cron_rekap_absen', [
                                'flag_sent' => 1,
                                'done_date' => date('Y-m-d H:i:s'),
                                'response' => 'success'
                            ]);
                }
            }
        }
    }

    public function saveToCronRekapAbsen($data){
        $this->db->insert('t_cron_rekap_absen', $data);
    }

    public function cronRekapAbsenPD($bulan, $tahun){
        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja a')
                            ->where('a.id_unitkerja NOT IN (SELECT id_unitkerja FROM t_cron_rekap_absen WHERE flag_active = 1 AND bulan = '.$bulan.' AND tahun = '.$tahun.')')
                            ->get()->result_array();
        $cron = null;
        $i = 0;
        if($unitkerja){
            foreach($unitkerja as $u){
                $cron[$i]['id_unitkerja'] = $u['id_unitkerja'];
                $cron[$i]['bulan'] = $bulan;
                $cron[$i]['tahun'] = $tahun;
                $cron[$i]['created_by'] = 1;
                // if($i == 5){
                //     break;
                // }
                $i++;
            }
        }

        if($cron){
            $this->db->insert_batch('t_cron_rekap_absen', $cron);
        }
        $this->cronRekapAbsen(0);

    }

    public function searchRekapVerifPdm($data){
        $result = null;
        $list_master = null;
        $tanggal = explodeRangeDateNew($data['tanggal']);
        $master = $this->db->select('*')
                        ->from('m_pdm')
                        ->where('flag_active', 1)
                        ->where('id !=', 15) //pas foto
                        ->get()->result_array();

        foreach($master as $m){
            $list_master[$m['singkatan']]['id'] = $m['id'];
            $list_master[$m['singkatan']]['nama_berkas'] = $m['nama_berkas'];
            $list_master[$m['singkatan']]['singkatan'] = $m['singkatan'];
            $list_master[$m['singkatan']]['total'] = 0;
        }

        $users = $this->db->select('c.*, a.id as id_m_user')
                        ->from('m_user a')
                        ->join('t_hak_akses b', 'a.id = b.id_m_user')
                        ->join('db_pegawai.pegawai c', 'a.username = c.nipbaru_ws')
                        ->where('b.flag_active', 1)
                        ->where('b.id_m_hak_akses', 5)
                        ->get()->result_array();
        if($users){
            foreach($users as $u){
                $result[$u['id_m_user']]['nama_pegawai'] = getNamaPegawaiFull($u);
                $result[$u['id_m_user']]['nip'] = $u['nipbaru_ws'];
                $result[$u['id_m_user']]['total_verif'] = 0;
                $result[$u['id_m_user']]['detail_verif'] = $list_master;
            }
        }

        foreach($master as $mst){
            $this->db->select('a.*')
                    ->from('db_pegawai.'.$mst['table'].' a')
                    ->where('flag_active', 1)
                    // ->where('a.status', 2)
                    ->where('a.id_m_user_verif !=', 0);
            if(!isset($data['all'])){
                $this->db->where('DATE(a.tanggal_verif) >=', $tanggal[0])
                            ->where('DATE(a.tanggal_verif) <=', $tanggal[1]);
            }

            $dataresult = $this->db->get()->result_array();
            if($dataresult){
                foreach($dataresult as $dr){
                    if(isset($result[$dr['id_m_user_verif']])){
                        $result[$dr['id_m_user_verif']]['total_verif'] ++;
                        $result[$dr['id_m_user_verif']]['detail_verif']['pangkat']['total'] ++;
                    } else {
                        $user = $this->db->select('c.*, a.id as id_m_user')
                                        ->from('m_user a')
                                        ->join('t_hak_akses b', 'a.id = b.id_m_user')
                                        ->join('db_pegawai.pegawai c', 'a.username = c.nipbaru_ws')
                                        ->where('b.flag_active', 1)
                                        ->where('a.id', $dr['id_m_user_verif'])
                                        ->get()->row_array();
                        if($user){
                            $result[$u['id_m_user']]['nama_pegawai'] = getNamaPegawaiFull($user);
                            $result[$u['id_m_user']]['nip'] = $user['nipbaru_ws'];
                            $result[$u['id_m_user']]['total_verif'] = 0;
                            $result[$u['id_m_user']]['detail_verif'] = $list_master;
                            $this->db->insert('t_hak_akses',
                            [
                                'id_m_user' => $user['id_m_user'],
                                'id_m_hak_akses' => 5,
                                'created_by' => 0
                            ]);
                        }
                    }
                }
            }
        }
        function cmp($a, $b) {
            return $b['total_verif'] > $a['total_verif'];
        }
        usort($result, "cmp");
        return $result;
    }

    public function rekapPegawaiPerjabatan($id_unitkerja){
        $result = null;
        $this->db->select('*')
                ->from('db_pegawai.unitkerja')
                ->where('id_unitkerja != ',0)
                ->order_by('nm_unitkerja');
        if($id_unitkerja != 0){
            $this->db->where('id_unitkerja', $id_unitkerja);
        }
        $unitkerja = $this->db->get()->result_array();

        foreach($unitkerja as $u){
            $result[$u['id_unitkerja']] = $u;
            $result[$u['id_unitkerja']]['nm_unikeraj'] = $u['nm_unitkerja'];
            $result[$u['id_unitkerja']]['eselon_2'] = 0;
            $result[$u['id_unitkerja']]['eselon_3'] = 0;
            $result[$u['id_unitkerja']]['eselon_4'] = 0;
            $result[$u['id_unitkerja']]['jf_utama'] = 0;
            $result[$u['id_unitkerja']]['jf_madya'] = 0;
            $result[$u['id_unitkerja']]['jf_muda'] = 0;
            $result[$u['id_unitkerja']]['jf_pertama'] = 0;
            $result[$u['id_unitkerja']]['jf_terampil'] = 0;
            $result[$u['id_unitkerja']]['pelaksana'] = 0;
            $result[$u['id_unitkerja']]['total'] = 0;
            $result[$u['id_unitkerja']]['anonym'] = null;
        }

        $this->db->select('a.gelar1, a.gelar2, a.nama, c.nama_jabatan, b.nm_unitkerja, c.eselon, d.nm_agama, e.nm_pangkat,
                    a.nipbaru_ws, f.nm_statuspeg, a.statuspeg, f.id_statuspeg, a.tmtpangkat, a.tmtjabatan, a.id_m_status_pegawai,
                    h.nama_status_pegawai, f.nm_statuspeg, b.id_unitkerja, c.jenis_jabatan, e.id_pangkat, a.statuspeg')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                    ->join('db_pegawai.agama d', 'a.agama = d.id_agama')
                    ->join('db_pegawai.pangkat e', 'a.pangkat = e.id_pangkat')
                    ->join('db_pegawai.statuspeg f', 'a.statuspeg = f.id_statuspeg')
                    ->join('db_pegawai.eselon g', 'c.eselon = g.nm_eselon', 'left')
                    ->join('m_status_pegawai h', 'a.id_m_status_pegawai = h.id')
                    ->where('a.id_m_status_pegawai', 1)
                    ->where('a.statuspeg', 2)
                    ->where('b.id_unitkerja !=', 5)
                    ->order_by('c.eselon, a.nama');
        if($id_unitkerja != 0){
            $this->db->where('a.skpd', $id_unitkerja);
        }
        $list_pegawai = $this->db->get()->result_array();

        foreach($list_pegawai as $l){
            $result[$l['id_unitkerja']]['total']++;
            if($l['eselon'] == "II A" || $l['eselon'] == "II B"){
                $result[$l['id_unitkerja']]['eselon_2']++;
            } else if($l['eselon'] == "III A" || $l['eselon'] == "III B"){
                $result[$l['id_unitkerja']]['eselon_3']++;
            } else if($l['eselon'] == "IV A" || $l['eselon'] == "IV B"){
                $result[$l['id_unitkerja']]['eselon_4']++;
            } else if($l['jenis_jabatan'] == "JFT"){
                if($l['id_pangkat'] == 45 || $l['id_pangkat'] == 44){
                    $result[$l['id_unitkerja']]['jf_utama']++;
                } else if($l['id_pangkat'] == 43 || $l['id_pangkat'] == 42 || $l['id_pangkat'] == 41){
                    $result[$l['id_unitkerja']]['jf_madya']++;
                } else if($l['id_pangkat'] == 34 || $l['id_pangkat'] == 33){
                    $result[$l['id_unitkerja']]['jf_muda']++;
                } else if($l['id_pangkat'] == 32 || $l['id_pangkat'] == 31){
                    $result[$l['id_unitkerja']]['jf_pertama']++;
                } else if($l['id_pangkat'] == 24 || $l['id_pangkat'] == 23){
                    $result[$l['id_unitkerja']]['jf_terampil']++;
                }
            } else if($l['jenis_jabatan'] == "JFU"){
                $result[$l['id_unitkerja']]['pelaksana']++;
            } else {
                // dd($l);
                $result[$l['id_unitkerja']]['anonym'][] = $l;
            }
        }

        return $result;
    }

    public function loadFormatTppBkadData(){
        $data = $this->input->post();

        return $this->db->select('a.id, a.bulan, a.tahun, b.nm_unitkerja, a.nama_param_unitkerja')
                    ->from('t_lock_tpp a')
                    ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                    ->where('a.flag_active', 1)
                    ->where('a.meta_data IS NOT NULL')
                    ->where('bulan', $data['bulan'])
                    ->where('tahun', $data['tahun'])
                    ->order_by('a.created_date', 'desc')
                    ->get()->result_array();
    }

    public function loadGajiPegawai(){
        $input_post = $this->input->post();

        $this->db->select('a.gelar1, a.gelar2, a.nama, a.nipbaru_ws, a.besaran_gaji, b.nama_jabatan, c.nm_unitkerja, d.created_date')
                    ->from('db_pegawai.pegawai a')
                    ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                    ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                    ->join('t_bkad_upload_gaji d', 'a.id_t_bkad_upload_gaji = d.id', 'left')
                    ->where('a.id_m_status_pegawai', 1)
                    ->where('a.nipbaru_ws NOT IN ("guest", "walikota", "wakilwalikota")')
                    ->order_by('b.eselon, a.skpd')
                    ->group_by('a.nipbaru_ws');
                    // ->get()->result_array();
                    
        if(isset($input_post['skpd']) && $input_post['skpd'] != 0){
            $this->db->where('a.skpd', $input_post['skpd']);
        }
        $data = $this->db->get()->result_array();

        $result = null;
        if($data){
            foreach($data as $d){
                $result[$d['nipbaru_ws']] = $d;
            }
        }
        $this->session->set_userdata('list_gaji_pegawai', $result);

        return $result;
    }

    public function readUploadGaji(){
        $rs['code'] = 0;
        $rs['message'] = '';
        $rs['flag_not_found'] = 0;

        $temp_not_found = null;
        $filename = "";
        $list_exec = null;
        $input_post = $this->input->post(); 

        if($_FILES){
            $allowed_extension = ['xls', 'csv', 'xlsx'];
            $file_array = explode(".", $_FILES["file_gaji"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $config['upload_path'] = 'arsipbkad/uploadgaji'; 
                $config['allowed_types'] = '*';
                // $config['max_size'] = '5000'; // max_size in kb
                $config['file_name'] = "LIST_GAJI_BKAD_".generateRandomString(10).'_'.date('dMYHis').'.xls';
                $filename = $config['file_name'];

                $this->load->library('upload', $config); 

                $uploadfile = $this->upload->do_upload('file_gaji');

                if($uploadfile){
                    $this->db->trans_begin();

                    $this->db->insert('t_bkad_upload_gaji', [
                        'bulan' => $input_post['bulan'],
                        'tahun' => $input_post['tahun'],
                        'url_file' => $config['upload_path'].'/'.$config['file_name'],
                        'created_by' => $this->general_library->getId()
                    ]);

                    $last_insert = $this->db->insert_id();

                    $upload_data = $this->upload->data(); 
                    $file_gaji['name'] = $upload_data['file_name'];

                    libxml_use_internal_errors(true);
                    // $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES["file_gaji"]["name"]);
                    $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($config['upload_path'].'/'.$file_gaji['name']);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                    $spreadsheet = $reader->load($_FILES["file_gaji"]["tmp_name"]);
                    // $data = $spreadsheet->getActiveSheet()->toArray();

                    $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                    $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

                    $list_gaji_exist = $this->session->userdata('list_gaji_pegawai');
                    // dd($list_gaji_exist);

                    for($row = 1; $row <= $highestRow; $row++){
                        $nip = 0;
                        $gaji = 0;
                        for($col = 1; $col <= $highestColumnIndex; $col++){
                            $value = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
                            if($col == 1){ // nip
                                $nip = $value;
                            } else if($col == 2){ // nominal gaji
                                $gaji = $value;
                            }
                        }
                        if(isset($list_gaji_exist[$nip])){
                            $exec = null;
                            $exec['nip'] = $nip;
                            $exec['besaran_gaji'] = $gaji;
                            $exec['id_t_bkad_upload_gaji'] = $last_insert;
                            $exec['created_by'] = $this->general_library->getId();

                            $list_exec[] = $exec;

                            // $this->db->where('nipbaru_ws', $nip)
                            //         ->update('db_pegawai.pegawai', [
                            //             'besaran_gaji' => $gaji,
                            //             'id_t_bkad_upload_gaji' => $last_insert,
                            //         ]);
                        } else {
                            $temp_not_found[$nip]['nip'] = $nip;
                            $temp_not_found[$nip]['gaji'] = $gaji;
                            $temp_not_found[$nip]['keterangan'] = "Data Tidak Ditemukan";
                        }
                    }

                    if($list_exec){
                        $this->db->insert_batch('t_cron_bkad_upload_gaji', $list_exec);
                    }
                } else {
                    $rs['code'] = 1;
                    $rs['message'] = 'Gagal upload file';
                }
            }
        } else {
            $rs['code'] = 1;
            $rs['message'] = 'File yang diupload tidak ditemukan';
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            // $rs['code'] = 1;
            $rs['message'] = 'Terjadi Kesalahan';
        } else {
            $this->db->trans_commit();
            if($temp_not_found){
                $data_not_found['result'] = $temp_not_found;
                $data_not_found['filename'] = "NOT_FOUND_".$filename;
                $rs['flag_not_found'] = 1;
                $this->session->set_userdata('data_not_found', $data_not_found);
                // $this->load->view('rekap/V_UploadGajiBkadNotFoundExcel', $data);
            }
        }
        return $rs;
    }

    public function loadUploadGajiHistory(){
        return $this->db->select('a.*, b.nama')
                        ->from('t_bkad_upload_gaji a')
                        ->join('m_user b', 'a.created_by = b.id')
                        ->where('a.flag_active', 1)
                        ->order_by('a.created_date', 'desc')
                        ->get()->result_array(); 
    }

    public function cronUpdateGajiBkad(){
        $data = $this->db->select('a.*, b.bulan, b.tahun')
                        ->from('t_cron_bkad_upload_gaji a')
                        ->join('t_bkad_upload_gaji b', 'a.id_t_bkad_upload_gaji = b.id')
                        ->where('a.flag_active', 1)
                        ->where('a.flag_update', 0)
                        ->limit(1000)
                        ->get()->result_array();

        if($data){
            foreach($data as $d){
                $this->db->where('nipbaru_ws', $d['nip'])
                        ->update('db_pegawai.pegawai', [
                            'besaran_gaji' => $d['besaran_gaji'],
                            'id_t_bkad_upload_gaji' => $d['id_t_bkad_upload_gaji']
                        ]);

                $exists = $this->db->select('a.*')
                                ->from('t_bkad_upload_gaji_detail a')
                                ->where('a.flag_active', 1)
                                ->where('a.bulan', $d['bulan'])
                                ->where('a.tahun', $d['tahun'])
                                ->where('a.nip', $d['nip'])
                                ->get()->row_array();

                if($exists){
                    $this->db->where('id', $exists['id'])
                            ->update('t_bkad_upload_gaji_detail', [
                                'gaji' => $d['besaran_gaji']
                            ]);
                } else {
                    $this->db->insert('t_bkad_upload_gaji_detail', [
                        'nip' => $d['nip'],
                        'gaji' => $d['besaran_gaji'],
                        'id_t_bkad_upload_gaji' => $d['id_t_bkad_upload_gaji'],
                        'bulan' => $d['bulan'],
                        'tahun' => $d['tahun'],
                    ]);
                }
                
                $this->db->where('id', $d['id'])
                        ->update('t_cron_bkad_upload_gaji', [
                            'flag_update' => 1,
                            'exec_time' => date('Y-m-d H:i:s')
                        ]);
            }
        }
    }

    public function getDataLockTpp($data){
        // dd($data);
        $skpd = explode(";", $data['skpd']);

        return $this->db->select('*')
                        ->from('t_lock_tpp')
                        ->where('bulan', $data['bulan'])
                        ->where('tahun', $data['tahun'])
                        ->where('id_unitkerja', $skpd[0])
                        ->where('flag_active', 1)
                        ->get()->row_array();
    }

    public function checkStatusUploadBerkasTpp(){
        $rs['code'] = 0;
        $rs['message'] = "";

        // $this->db->trans_begin();

        $data = $this->input->post();
        $skpd = explode(";", $data['skpd']);
        
        
        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $skpd[0])
                            ->get()->row_array();

        $berkas = $this->db->select('a.*, b.nm_unitkerja')
                        ->from('t_lock_tpp a')
                        ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                        ->where('a.bulan', $data['bulan'])
                        ->where('a.tahun', $data['tahun'])
                        ->where('a.id_unitkerja', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->get()->row_array();

        if(!$berkas){
            $rs['code'] = 1;
            $rs['message'] = "Berkas TPP ".$unitkerja['nm_unitkerja'].' periode '.getNamaBulan($data['bulan']).' '.$data['tahun'].' belum didownload.<br> Silahkan download terlebih dahulu untuk mengupload pengajuan verifikasi berkas TPP.';
        }

        // if($this->db->trans_status() == FALSE || $rs['code'] != 0){
        //     $this->db->trans_rollback();
        //     $rs['message'] = 'Terjadi Kesalahan';
        // } else {
        //     $this->db->trans_commit();
        // }

        return $rs;
    }

    public function saveUploadBerkasTppBalasan($id){
        $rs['code'] = 0;
        $rs['message'] = '';

        $this->db->trans_begin();

        $input_post = $this->input->post();
        $data = $this->db->select('a.*, b.bulan, b.tahun, b.nama_param_unitkerja as nm_unitkerja, trim(d.nama) as nama_verifikator, d.id as id_m_user_verifikator,
                        e.nama as nama_uploader, f.handphone')
                        ->from('t_upload_berkas_tpp a')
                        ->join('t_lock_tpp b', 'a.id_t_lock_tpp = b.id')
                        ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                        ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                        ->join('m_user e', 'a.created_by = e.id')
                        ->join('db_pegawai.pegawai f', 'e.username = f.nipbaru_ws')
                        ->where('a.flag_active', 1)
                        ->where('a.id', $id)
                        ->get()->row_array();

        if($_FILES && $data){
            $allowed_extension = ['pdf'];
            $file_array = explode(".", $_FILES["file_balasan"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $fullPath = $data['url_upload_file'];
                $explFullPath = explode("/", $fullPath);
                $fileName = $explFullPath[count($explFullPath) - 1];
                
                $uploadPath = 'arsiptpp/usultpp/'.$data['tahun'].'/'.getNamaBulan($data['bulan']);
                if(!file_exists('arsiptpp/usultpp/'.$data['tahun'])){ //create if not exists
                    $oldmask = umask(0);
                    mkdir('arsiptpp/usultpp/'.$data['tahun'], 0777);
                    umask($oldmask);
                }

                if(!file_exists($uploadPath)){ //create if not exists
                    $oldmask = umask(0);
                    mkdir($uploadPath, 0777);
                    umask($oldmask);
                }

                $file_name = "Balasan_".$fileName;

                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $config['file_name'] = date('Ymdhis')."_".($file_name);
                $this->load->library('upload', $config);
                // if(file_exists($config['upload_path'])."/".$file_name){
                //     move_uploaded_file('overwrited_file', ($config['upload_path']."/".$file_name));
                //     unlink(($config['upload_path'])."/".$file_name);
                // }
                $uploadfile = $this->upload->do_upload('file_balasan');
                
                if($uploadfile){
                    $this->db->where('id', $data['id'])
                            ->update('t_upload_berkas_tpp', [
                                'url_file_balasan' => $config['upload_path'].'/'.$config['file_name'],
                                'tanggal_balasan' => date('Y-m-d H:i:s'),
                                'updated_by' => $this->general_library->getId()
                            ]);

                } else {
                    $rs['code'] = 1;
                    $rs['message'] = 'Gagal upload file';
                }
            }
        } else {
            $rs['code'] = 1;
            // $rs['message'] = 'File yang diupload tidak ditemukan';
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            // $rs['code'] = 1;
            $rs['message'] = $rs['message'] == "" ? 'Terjadi Kesalahan' : $rs['message'];
        } else {
            $this->db->trans_commit();
        }
        return $rs;
    }

    public function deleteBerkasTppBalasan($id){
        $rs['code'] = 0;
        $rs['message'] = '';

        $this->db->trans_begin();

        $this->db->where('id', $id)
                ->update('t_upload_berkas_tpp', [
                    'tanggal_balasan' => null,
                    'url_file_balasan' => null
                ]);

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            // $rs['code'] = 1;
            $rs['message'] = $rs['message'] == "" ? 'Terjadi Kesalahan' : $rs['message'];
        } else {
            $this->db->trans_commit();
        }
        return $rs;
    }

    public function saveUploadBerkasTpp(){
        $rs['code'] = 0;
        $rs['message'] = '';

        $this->db->trans_begin();

        $input_post = $this->input->post();
        if(!$input_post){
            $rs['code'] = 2;
            $rs['message'] = 'Terjadi Kesalahan';
            return $rs;
        }
        $skpd = explode(";", $input_post['skpd']);

        $unitkerja = $this->db->select('*')
                            ->from('db_pegawai.unitkerja')
                            ->where('id_unitkerja', $skpd[0])
                            ->get()->row_array();

        $lockTpp = $this->db->select('a.*, b.nm_unitkerja')
                        ->from('t_lock_tpp a')
                        ->join('db_pegawai.unitkerja b', 'a.id_unitkerja = b.id_unitkerja')
                        ->where('a.bulan', $input_post['bulan'])
                        ->where('a.tahun', $input_post['tahun'])
                        ->where('a.id_unitkerja', $skpd[0])
                        ->where('a.flag_active', 1)
                        ->get()->row_array();

        if(!$unitkerja || !$lockTpp){
            $rs['code'] = 1;
            $rs['message'] = $rs['message'] ? $rs['message'] : 'Terjadi Kesalahan' ;
        } else {
            //  flag_verif: 0-belum verif, 1-diterima, 2-ditolak
            $exists = $this->db->select('*')
                        ->from('t_upload_berkas_tpp')
                        ->where('id_t_lock_tpp', $lockTpp['id'])
                        ->where('flag_active', 1)
                        // ->where('flag_verif != ', 2)
                        ->get()->row_array();
            if($exists){
                if($exists['flag_verif'] == 2){ // jika ditolak, hapus data yang ditolak
                    $this->db->where('id', $exists['id'])
                            ->update('t_upload_berkas_tpp',[
                                'flag_active' => 0,
                                'updated_by' => $this->general_library->getId()
                            ]);
                } else {
                    $rs['code'] = 1;
                    $rs['message'] = 'Berkas sudah diajukan sebelumnya. Silahkan melihat kembali riwayat di bagian bawah.';
                }
            }
        }

        if($rs['code'] == 0 && $_FILES && $unitkerja && $lockTpp){
            $allowed_extension = ['pdf'];
            $file_array = explode(".", $_FILES["input_tpp"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $uploadPath = 'arsiptpp/usultpp/'.date('Y').'/'.getNamaBulan($input_post['bulan']);
                if(!file_exists('arsiptpp/usultpp/'.date('Y'))){ //create if not exists
                    $oldmask = umask(0);
                    mkdir('arsiptpp/usultpp/'.date('Y'), 0777);
                    umask($oldmask);
                }

                if(!file_exists($uploadPath)){ //create if not exists
                    $oldmask = umask(0);
                    mkdir($uploadPath, 0777);
                    umask($oldmask);
                }

                $file_name = 'Pengajuan TPP '.($lockTpp['nama_param_unitkerja']).' '.getNamaBulan($input_post['bulan']).' '.$input_post['tahun'].'.pdf';
                $file_name = str_replace(' ', '_', $file_name);

                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                // $config['max_size'] = '10000'; // max_size in kb
                $config['file_name'] = date('Ymdhis')."_".($file_name);
                // $filename = $config['file_name'];
                $this->load->library('upload', $config); 
                // if(file_exists($config['upload_path'])."/".$file_name){
                //     move_uploaded_file('overwrited_file', ($config['upload_path']."/".$file_name));
                //     unlink(($config['upload_path'])."/".$file_name);
                // }
                $uploadfile = $this->upload->do_upload('input_tpp');
                
                if($uploadfile){
                    $this->db->insert('t_upload_berkas_tpp', [
                        'id_unitkerja' => $unitkerja['id_unitkerja'],
                        'id_t_lock_tpp' => $lockTpp['id'],
                        'url_upload_file' => $config['upload_path'].'/'.$config['file_name'],
                        'created_by' => $this->general_library->getId(),
                        'keterangan' => 'Menunggu Verifikasi'
                    ]);

                    $this->db->where('id', $lockTpp['id'])
                            ->update('t_lock_tpp', [
                                'flag_upload_berkas_tpp' => 1
                            ]);

                    $this->db->insert('t_cron_wa', [
                        'type' => 'text',
                        // 'sendTo' => GROUP_CHAT_PRAKOM,
                        'sendTo' => GROUP_CHAT_TPP_HARDWORKER,
                        'message' => "Selamat ".greeting()." \n*".$lockTpp['nama_param_unitkerja']."* telah mengupload berkas untuk pengajuan TPP periode *".getNamaBulan($input_post['bulan'])." ".$input_post['tahun']."*."
                     ]);

                } else {
                    $this->upload->display_errors();
                    if($this->general_library->isProgrammer()){
                        // dd($this->upload->data());
                    }
                    $rs['code'] = 1;
                    $rs['message'] = isset($this->upload->error_msg[0]) ? $this->upload->error_msg[0] : 'Gagal upload file';
                }
            }
        } else {
            $rs['code'] = 1;
            // $rs['message'] = 'File yang diupload tidak ditemukan';
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            // $rs['code'] = 1;
            $rs['message'] = $rs['message'] == "" ? 'Terjadi Kesalahan' : $rs['message'];
        } else {
            $this->db->trans_commit();
        }
        return $rs;
    }

    public function loadRiwayatUploadBerkasTpp(){
        $data = $this->input->post();
        
        $skpd = explode(";", $data['skpd']);
        $uksearch = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where('id_unitkerja', $skpd[0])
                                ->get()->row_array();

        $this->db->select('a.*, b.bulan, b.tahun, b.nama_param_unitkerja as nm_unitkerja, trim(d.nama) as nama_verifikator, e.nama as nama_uploader')
                ->from('t_upload_berkas_tpp a')
                ->join('t_lock_tpp b', 'a.id_t_lock_tpp = b.id')
                ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                ->join('m_user e', 'a.created_by = e.id')
                ->where('a.flag_active', 1)
                ->group_by('a.id')
                ->order_by('created_date', 'desc');

        if($this->general_library->isProgrammer()){
            
        } else if(in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)) { // jika kecamatan
            $this->db->where('c.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        } else if($this->general_library->getIdUnitKerjaPegawai() == '3010000') { // jika diknas
            $this->db->where('(b.id_unitkerja = "3010000" OR substring(b.id_unitkerja, 1, 8) = "sekolah_")');
        } else {
            $this->db->where('a.id_unitkerja', $this->general_library->getIdUnitKerjaPegawai());
        }

        return $this->db->get()->result_array();
    }

    public function loadRiwayatVerifBerkasTppByStatus($status){
        $data = json_decode($this->input->post()['params'], true);
        $skpd = explode(";", $data['skpd']);
        $uksearch = $this->db->select('*')
                                ->from('db_pegawai.unitkerja')
                                ->where('id_unitkerja', $skpd[0])
                                ->get()->row_array();

        $this->db->select('a.*, b.bulan, b.tahun, b.nama_param_unitkerja as nm_unitkerja, trim(d.nama) as nama_verifikator, d.id as id_m_user_verifikator, e.nama as nama_uploader')
                ->from('t_upload_berkas_tpp a')
                ->join('t_lock_tpp b', 'a.id_t_lock_tpp = b.id')
                ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                ->join('m_user e', 'a.created_by = e.id')
                ->where('a.flag_active', 1)
                ->where('a.flag_verif', $status)
                ->where('b.bulan', $data['bulan'])
                ->where('b.tahun', $data['tahun'])
                ->group_by('a.id')
                ->order_by('created_date', 'desc');

        if($data['skpd'] != 0){
            $this->db->where('b.id_unitkerja', $skpd[0]);
        }

        // if($this->general_library->isProgrammer()){
            
        // } else if(in_array($skpd[0], LIST_UNIT_KERJA_KECAMATAN_NEW)) { // jika kecamatan
        //     $this->db->where('c.id_unitkerjamaster', $uksearch['id_unitkerjamaster']);
        // } else if($this->general_library->getIdUnitKerjaPegawai() == '3010000') { // jika diknas
        //     $this->db->where('(b.id_unitkerja = "3010000" OR substring(b.id_unitkerja, 1, 8) = "sekolah_")');
        // } else {
        //     $this->db->where('a.id_unitkerja', $this->general_library->getIdUnitKerjaPegawai());
        // }

        return $this->db->get()->result_array();
    }

    public function loadModalVerifUploadBerkasTpp($id){
        return $this->db->select('a.*, b.bulan, b.tahun, b.nama_param_unitkerja as nm_unitkerja, trim(d.nama) as nama_verifikator, d.id as id_m_user_verifikator, e.nama as nama_uploader')
                        ->from('t_upload_berkas_tpp a')
                        ->join('t_lock_tpp b', 'a.id_t_lock_tpp = b.id')
                        ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                        ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                        ->join('m_user e', 'a.created_by = e.id')
                        ->where('a.flag_active', 1)
                        ->where('a.id', $id)
                        ->get()->row_array();
    }
    
    public function saveVerifUploadBerkasTpp(){
        $param = $this->input->post();
        $rs['code'] = 0;
        $rs['message'] = "";

        $this->db->trans_begin();

        $data = $this->db->select('a.*, b.bulan, b.tahun, b.nama_param_unitkerja as nm_unitkerja, trim(d.nama) as nama_verifikator, d.id as id_m_user_verifikator,
                        e.nama as nama_uploader, f.handphone')
                        ->from('t_upload_berkas_tpp a')
                        ->join('t_lock_tpp b', 'a.id_t_lock_tpp = b.id')
                        ->join('db_pegawai.unitkerja c', 'a.id_unitkerja = c.id_unitkerja')
                        ->join('m_user d', 'a.id_m_user_verif = d.id', 'left')
                        ->join('m_user e', 'a.created_by = e.id')
                        ->join('db_pegawai.pegawai f', 'e.username = f.nipbaru_ws')
                        // ->where('a.flag_active', 1)
                        ->where('a.id', $param['id'])
                        ->get()->row_array();
    
        if($data){
            if($data['flag_active'] == 0){
                $rs['code'] = 1;
                $rs['message'] = "Verifikasi tidak dapat dilanjutkan, data telah dihapus";
            } else {
                $exists = $this->db->select('*')
                                    ->from('t_upload_berkas_tpp')
                                    ->where('id_t_lock_tpp', $data['id_t_lock_tpp'])
                                    ->where('id !=', $data['id'])
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
                if($exists) {
                    $rs['code'] = 1;
                    $rs['message'] = "Ada berkas baru yang sudah diupload. Verifikasi tidak dapat dilanjutkan.";
                } else {
                    if($data['flag_verif'] != $param['flag_verif']){
                        $keterangan = $param['keterangan'];
                        if($param['flag_verif'] == 0){
                            $keterangan = 'Menunggu Verifikasi';

                            if($data['flag_verif'] != 0){
                                $keterangan = 'Verifikasi Dibatalkan, '.$param['keterangan'];
                            }
                        }

                        $this->db->where('id', $param['id'])
                                ->update('t_upload_berkas_tpp', [
                                    'keterangan' => $keterangan,
                                    'tanggal_verif' => date('Y-m-d H:i:s'),
                                    'id_m_user_verif' => $this->general_library->getId(),
                                    'flag_verif' => $param['flag_verif'],
                                    'tanggal_balasan' => null,
                                    'url_file_balasan' => null
                                ]);
                    } else {
                        $rs['code'] = 1;
                        $rs['message'] = "Tidak ada perubahan status";
                    }
                }
            }
        } else {
            $rs['code'] = 1;
        }
        
        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            // $rs['code'] = 1;
            $rs['message'] = $rs['message'] == "" ? 'Terjadi Kesalahan' : $rs['message'];
        } else {
            $this->db->trans_commit();
        }
        return $rs;
    }
    
    public function deleteRiwayatUploadBerkasTpp($id){
        $rs['code'] = 0;
        $rs['message'] = '';

        $data = $this->db->select('*')
                        ->from('t_upload_berkas_tpp')
                        ->where('id', $id)
                        ->get()->row_array();

        $this->db->where('id', $id)
                ->update('t_upload_berkas_tpp', [
                    'flag_active' => 0,
                    'updated_by' => $this->general_library->getId()
                ]);

        $this->db->where('id', $data['id_t_lock_tpp'])
                ->update('t_lock_tpp', [
                    'flag_upload_berkas_tpp' => 0
                ]);
                
        return $rs;
    }

    public function rekapKehadiranPeriodik($tahun = 2025){
        // $listJenisDisiplin = null;
        // $jenisDisiplin = $this->db->select('*')
        //                         ->from('m_jenis_disiplin_kerja')
        //                         ->where('flag_active', 1)
        //                         ->get()->result_array();
        // foreach($jenisDisiplin as $jd){
        //     $listJenisDisiplin[$jd['keterangan']]['nama_jenis_disiplin_kerja'] = $jd['nama_jenis_disiplin_kerja'];
        //     $listJenisDisiplin[$jd['keterangan']]['keterangan'] = $jd['keterangan'];
        //     $listJenisDisiplin[$jd['keterangan']]['total'] = 0;
        // }
        
        for($i = 1; $i <= 12; $i++){
            $bulan = formatBulan($i);
            $unitkerja = $this->db->select('a.*')
                                ->from('db_pegawai.unitkerja a')
                                ->join('db_pegawai.pegawai b', 'a.id_unitkerja = b.skpd')
                                ->join("t_rekap_kehadiran_unitkerja c", "a.id_unitkerja = c.id_unitkerja AND c.bulan = ".formatBulan($bulan)." AND c.tahun = ".$tahun." AND c.flag_active = 1", "left")
                                ->where('c.id_unitkerja IS NULL')
                                ->where('a.id_unitkerja !=', 0)
                                ->where('a.id_unitkerja !=', 5)
                                ->where('b.id_m_status_pegawai', 1)
                                ->where_not_in('a.id_unitkerja', [9000001]) // exclude tubel
                                ->where_not_in('a.id_unitkerja', [7005010, 7005020]) // exclude tubel
                                ->group_by('a.id_unitkerja')
                                ->limit(3)
                                ->get()->result_array();
            if($unitkerja){
                $this->general->logCron('cronRekapKehadiran');
                foreach ($unitkerja as $uk){
                    $res = $this->buildDataAbsensi([
                        'id_unitkerja' => $uk['id_unitkerja'],
                        'nm_unitkerja' => $uk['nm_unitkerja'],
                        'skpd' => $uk['id_unitkerja'].";".$uk['nm_unitkerja'],
                        "bulan" => $bulan,
                        "tahun" => $tahun
                    ], 1, 0, 0, 1, 0);

                    $saveData = null;
                    if($res){
                        foreach($res['result'] as $rs){
                            // $lockTpp = $this->db->select('id')
                            //                     ->from('t_lock_tpp')
                            //                     ->where('id_unitkerja', $uk['id_unitkerja'])
                            //                     ->where('flag_active', 1)
                            //                     ->where('bulan', $bulan)
                            //                     ->where('tahun', $tahun)
                            //                     ->get()->row_array();

                            $exists = $this->db->select('*')
                                            ->from('t_rekap_kehadiran')
                                            ->where('nip', $rs['nip'])
                                            ->where('bulan', $bulan)
                                            ->where('tahun', $tahun)
                                            ->where('flag_active', 1)
                                            ->get()->row_array();
                            if($exists){
                                if($exists['bulan'] == date('m') && $exists['tahun'] == date('Y')){ // kalau data sudah ada dan masih pada bulan yang berjalan maka update
                                    $this->db->where('id', $exists['id'])
                                        ->update('t_rekap_kehadiran', [
                                            'meta_data' => json_encode($rs)
                                        ]);
                                }
                            } else {
                                $this->db->insert('t_rekap_kehadiran', [
                                    'nip' => $rs['nip'],
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'meta_data' => json_encode($rs),
                                ]);
                            }
                        }
                        // $this->db->insert_batch('t_rekap_kehadiran', $saveData);
                    }

                    $existsUker = $this->db->select('*')
                                    ->from('t_rekap_kehadiran_unitkerja')
                                    ->where('id_unitkerja', $uk['id_unitkerja'])
                                    ->where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->where('flag_active', 1)
                                    ->get()->row_array();

                    if($existsUker){
                        $this->db->where('id', $existsUker['id'])
                                ->update('t_rekap_kehadiran_unitkerja', [
                                    'flag_active' => 0
                                ]);
                    } else {
                        $this->db->insert('t_rekap_kehadiran_unitkerja', [
                            'id_unitkerja' => $uk['id_unitkerja'],
                            'bulan' => $bulan,
                            'tahun' => $tahun
                        ]);
                    }
                }
            }
        }
    }

    public function rekapKehadiranPeriodikBu($bulan = 0, $tahun = 0, $data = null, $flagRecursive = 1){
        if($flagRecursive == 0){
            dd($data[16]);
        }

        if($tahun == 0){
            $tahun = date('Y');
        }

        if($bulan == 0){
            $bulan = date('m');
        }
        
        $tanggal_awal = $tahun."-".formatBulan($bulan)."-01";
        $tanggal_akhir = date("Y-m-t", strtotime($tanggal_awal));

        $hariKerja = countHariKerjaDateToDate($tanggal_awal, $tanggal_akhir);
        if($hariKerja[3]){
            $temp = null;
            foreach($hariKerja[3] as $hkM){
                $temp[$hkM]['presensi'] = null;
                $temp[$hkM]['keterangan'] = null;
            }
            $hariKerja[3] = $temp;
        }

        $listJenisDisiplin = null;
        $jenisDisiplin = $this->db->select('*')
                                ->from('m_jenis_disiplin_kerja')
                                ->where('flag_active', 1)
                                ->get()->result_array();
        foreach($jenisDisiplin as $jd){
            $listJenisDisiplin[$jd['keterangan']]['nama_jenis_disiplin_kerja'] = $jd['nama_jenis_disiplin_kerja'];
            $listJenisDisiplin[$jd['keterangan']]['keterangan'] = $jd['keterangan'];
            $listJenisDisiplin[$jd['keterangan']]['total'] = 0;
        }

        $listJenisDisiplin["TMK1"]['nama_jenis_disiplin_kerja'] = "Terlambat Masuk Kerja <= 30 menit";
        $listJenisDisiplin["TMK1"]['keterangan'] = "TMK 1";
        $listJenisDisiplin["TMK1"]['total'] = 0;
        $listJenisDisiplin["TMK2"]['nama_jenis_disiplin_kerja'] = "Terlambat Masuk Kerja > 30 menit dan <= 60 menit";
        $listJenisDisiplin["TMK2"]['keterangan'] = "TMK 2";
        $listJenisDisiplin["TMK2"]['total'] = 0;
        $listJenisDisiplin["TMK3"]['nama_jenis_disiplin_kerja'] = "Terlambat Masuk Kerja > 60 Menit";
        $listJenisDisiplin["TMK3"]['keterangan'] = "TMK 3";
        $listJenisDisiplin["TMK3"]['total'] = 0;
        $listJenisDisiplin["PKSW1"]['nama_jenis_disiplin_kerja'] = "Pulang Kerja Sebelum Waktu <= 30 menit";
        $listJenisDisiplin["PKSW1"]['keterangan'] = "PKSW 1";
        $listJenisDisiplin["PKSW1"]['total'] = 0;
        $listJenisDisiplin["PKSW2"]['nama_jenis_disiplin_kerja'] = "Pulang Kerja Sebelum Waktu > 30 menit dan <= 60 menit";
        $listJenisDisiplin["PKSW2"]['keterangan'] = "PKSW 2";
        $listJenisDisiplin["PKSW2"]['total'] = 0;
        $listJenisDisiplin["PKSW3"]['nama_jenis_disiplin_kerja'] = "Pulang Kerja Sebelum Waktu > 60 Menit";
        $listJenisDisiplin["PKSW3"]['keterangan'] = "PKSW 3";
        $listJenisDisiplin["PKSW3"]['total'] = 0;

        $res = null;
        $listIdPegawai = null;
        $pegawai = $this->db->select('a.nipbaru_ws, b.id, a.tmt_hitung_absen')
                        ->from('db_pegawai.pegawai a')
                        ->join('m_user b', 'a.nipbaru_ws = b.username')
                        ->where('b.flag_active', 1)
                        ->where('a.id_m_status_pegawai', 1)
                        ->where_not_in('a.skpd', [9000001]) // exclude tubel
                        ->where_not_in('a.skpd', [7005010, 7005020]) // exclude tubel
                        ->get()->result_array();
        foreach($pegawai as $p){
            $res[$p['id']] = $p;
            $res[$p['id']]['disiplin'] = $listJenisDisiplin;
            $res[$p['id']]['hari_kerja'] = $hariKerja[3];

            $listIdPegawai[$p['id']] = $p['id'];
        }
        // dd($res[16]);

        // $hariLibur = $this->db->select('*')
        //                     ->from('t_hari_libur a')
        //                     ->where('a.tahun', $tahun)
        //                     ->where('flag_active', 1)
        //                     ->where('flag_hari_libur_nasional', 1)
        //                     ->get()->result_array();

        $listDokpen = null;
        $dokpen = $this->db->select('a.id_m_user, a.tanggal, a.bulan, a.tahun, a.id_m_jenis_disiplin_kerja, b.keterangan')
                            ->from('t_dokumen_pendukung a')
                            ->join('m_jenis_disiplin_kerja b', 'a.id_m_jenis_disiplin_kerja = b.id')
                            ->where('a.tahun', $tahun)
                            ->where('a.bulan', $bulan)
                            ->where('a.status', 2)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
                            
        if($dokpen){
            foreach($dokpen as $dok){
                $listDokpen[$dok['id_m_user'].";".$dok['tahun']."-".formatBulan($dok['bulan'])."-".formatTanggal($dok['tanggal'])] = $dok;
            }
        }

        $listPresensi = null;
        $presensi = $this->db->select('a.user_id, a.tgl, a.masuk, a.pulang')
                            ->from('db_sip.absen a')
                            ->where('MONTH(a.tgl)', $bulan)
                            ->where('YEAR(a.tgl)', $tahun)
                            ->get()->result_array();
        if($presensi){
            foreach($presensi as $pres){
                $listPresensi[$pres['user_id'].";".$pres['tgl']] = $pres;
            }
        }

        foreach($hariKerja[3] as $hk){
            if(!isset($listDokpen[$pre['user_id'].";".$pre['tgl']])){ // cek kalau tidak ada dokpen di tanggal itu
                if($pre['pulang'] == null){
                    $pre['pulang'] == "00:00:00";
                }
                $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - ".formatTimeAbsen($pre['pulang']);
            } else {
                if($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'] == "TLP"){
                    $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = "TLP - ".formatTimeAbsen($pre['pulang']);
                } else if($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'] == "TLS"){
                    $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - TLS";
                } else if(in_array($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'], ["SIDAK", "MTTI", "KENEG"])){
                    $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - ".formatTimeAbsen($pre['pulang']);
                }
                $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['keterangan'] = $listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'];
                $res[$pre['user_id']]['disiplin'][$listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan']]['total']++;
            }
        }

        // coba recursive tapi stop di looping pegawai

        // if($presensi){
        //     foreach($presensi as $pre){
        //         if(isset($res[$pre['user_id']])){ // cek jika pegawai masih aktif
        //             if(!isset($listDokpen[$pre['user_id'].";".$pre['tgl']])){ // cek kalau tidak ada dokpen di tanggal itu
        //                 if($pre['pulang'] == null){
        //                     $pre['pulang'] == "00:00:00";
        //                 }
        //                 $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - ".formatTimeAbsen($pre['pulang']);
        //             } else {
        //                 if($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'] == "TLP"){
        //                     $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = "TLP - ".formatTimeAbsen($pre['pulang']);
        //                 } else if($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'] == "TLS"){
        //                     $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - TLS";
        //                 } else if(in_array($listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'], ["SIDAK", "MTTI", "KENEG"])){
        //                     $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['presensi'] = formatTimeAbsen($pre['masuk'])." - ".formatTimeAbsen($pre['pulang']);
        //                 }
        //                 $res[$pre['user_id']]['hari_kerja'][$pre['tgl']]['keterangan'] = $listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan'];
        //                 $res[$pre['user_id']]['disiplin'][$listDokpen[$pre['user_id'].";".$pre['tgl']]['keterangan']]['total']++;
        //             }
        //         }
        //     }
        // }

        $this->rekapKehadiranPeriodik($bulan, $tahun, $res, 0);
    }

    public function searchRekapKehadiranPeriodik($params){
        $result = null;
        $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan, g.updated_date as last_update_rekap,
                        d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.pendidikan, a.jk, a.statuspeg,
                        a.agama, c.kepalaskpd, b.notelp as notelp_uk, b.alamat_unitkerja as alamat_uk, b.emailskpd as email_uk, e.id as id_m_user,
                        a.fotopeg, b.id_unitkerja, a.jabatan, e.id_m_bidang, e.id_m_sub_bidang, c.jenis_jabatan, c.id_jabatanpeg, g.meta_data,
                        g.bulan, g.tahun')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                ->join('m_user e', 'a.nipbaru_ws = e.username')
                ->join('db_pegawai.statuspeg f', 'a.statuspeg = f.id_statuspeg')
                ->join('t_rekap_kehadiran g', 'a.nipbaru_ws = g.nip')
                ->where('a.nipbaru_ws !=', 'guest')
                // ->where('a.skpd', $id_unitkerja)
                ->where('id_m_status_pegawai', 1)
                ->where('e.flag_active', 1)
                ->where('g.tahun', $params['tahun'])
                ->where('g.flag_active', 1)
                ->order_by('c.eselon ASC')
                ->order_by('f.urutan ASC')
                ->order_by('c.jenis_jabatan ASC')
                ->order_by('d.id_pangkat DESC');
                // ->order_by('a.tmtcpns ASC')
                // ->group_by('a.id_peg');

        if($params['skpd'] != 0){
            $explodeUk = explode(";", $params['skpd']);
            $this->db->where('a.skpd', $explodeUk[0]);
        }

        if($params['bulan'] != 0){
            $this->db->where('g.bulan', $params['bulan']);
        }

        // klik tombol refresh, hanya untuk pencarian skpd tertentu
        // ketika klik, set flag active 0 di rekap kehadiran unitkerja
        // buat fungsi baru untuk 1 pintu simpan data rekap kehadiran periodik

        $data = $this->db->get()->result_array();
        if($data){
            foreach($data as $d){
                $metaData = json_decode($d['meta_data'], true);
                if(!isset($result[$d['id_m_user']])){ // jika belum ada, mappingkan
                    $result[$d['id_m_user']] = $d;
                    unset($result[$d['id_m_user']]['meta_data']);
                    $result[$d['id_m_user']]['rekap'] = $metaData['rekap'];
                    $result[$d['id_m_user']]['rekap']['last_update'] = $d['last_update_rekap'];
                } else { // jika sudah ada, tambahkan meta_data
                    foreach($metaData['rekap'] as $k => $v){
                        $result[$d['id_m_user']]['rekap'][$k] += $v;
                    }
                    if($d['last_update_rekap'] > $result[$d['id_m_user']]['rekap']['last_update']){
                        $result[$d['id_m_user']]['rekap']['last_update'] = $d['last_update_rekap'];
                    }
                }
            }
        }

        // remove duplikat data
        return $result;
    }

    public function searchRekapKehadiranPeriodikByIdUser($idUser, $tahun){
        $data = $this->db->select('a.nama, a.gelar1, a.gelar2, a.nipbaru_ws, b.nm_unitkerja, c.nama_jabatan, g.updated_date as last_update_rekap,
                        d.nm_pangkat, a.tgllahir, a.jk, c.eselon, d.id_pangkat, a.nipbaru, a.pendidikan, a.jk, a.statuspeg,
                        a.agama, c.kepalaskpd, b.notelp as notelp_uk, b.alamat_unitkerja as alamat_uk, b.emailskpd as email_uk, e.id as id_m_user,
                        a.fotopeg, b.id_unitkerja, a.jabatan, e.id_m_bidang, e.id_m_sub_bidang, c.jenis_jabatan, c.id_jabatanpeg, g.meta_data, g.bulan')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.unitkerja b', 'a.skpd = b.id_unitkerja')
                        ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                        ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                        ->join('m_user e', 'a.nipbaru_ws = e.username')
                        ->join('db_pegawai.statuspeg f', 'a.statuspeg = f.id_statuspeg')
                        ->join('t_rekap_kehadiran g', 'a.nipbaru_ws = g.nip')
                        ->where('e.id', $idUser)
                        ->where('g.tahun', $tahun)
                        ->order_by('g.bulan')
                        ->where('g.flag_active', 1)
                        ->get()->result_array();

        $result = null;
        if($data){
            foreach($data as $d){
                $metaData = json_decode($d['meta_data'], true);
                $result[$d['bulan']]['rekap'] = $metaData['rekap'];
                $result[$d['bulan']]['rekap']['last_update'] = $d['last_update_rekap'];
                $result['data'] = $d;
            }
        }
        return $result;
    }

}
?>