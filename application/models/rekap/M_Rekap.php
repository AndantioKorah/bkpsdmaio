<?php
    // require 'vendor/autoload.php';
    require FCPATH . 'vendor/autoload.php';
    // use PhpOffice\PhpSpreadSheet\Spreadsheet;
    // use PhpOffice\PhpSpreadSheet\IOFactory;
    require FCPATH . '/vendor/autoload.php';

    // use mpdf\mpdf;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	class M_Rekap extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
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
        }

        public function getProduktivitasKerjaPegawai($id, $bulan, $tahun){
            $result['komponen_kinerja'] = $this->getKomponenKinerja($id, $bulan, $tahun);
            $result['kinerja'] = $this->getKinerjaPegawai($id, $bulan, $tahun);
            return $result;
        }

        public function rekapPenilaianSearch($data){
           
            $result = null;
            $skpd = explode(";",$data['skpd']);
            $list_pegawai = $this->db->select('b.username as nip, trim(b.nama) as nama_pegawai, b.id, c.nama_jabatan, c.eselon')
                                    ->from('db_pegawai.pegawai a')
                                    ->join('m_user b', 'a.nipbaru_ws = b.username')
                                    ->join('db_pegawai.jabatan c', 'a.jabatan = c.id_jabatanpeg', 'left')
                                    ->where('a.skpd', $skpd[0])
                                    ->where('b.flag_active', 1)
                                    ->order_by('c.eselon, b.username')
                                    ->where('id_m_status_pegawai', 1)
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
                    // dd($temp['komponen_kinerja']);
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

    public function buildDataAbsensi($data, $flag_absen_aars = 0, $flag_alpha = 0, $flag_rekap_personal = 0){
        // dd($flag_alpha);
        $rs = null;
        $periode = null;
        $list_hari = null;
        $raw_data_excel = json_encode($data);
        
        if($flag_absen_aars == 1){
            $this->db->select('a.nipbaru_ws as nip, a.gelar1, a.gelar2, a.nama, c.nm_unitkerja, c.id_unitkerja')
                            ->from('db_pegawai.pegawai a')
                            ->join('db_pegawai.jabatan b', 'b.id_jabatanpeg = a.jabatan')
                            ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                            ->where('id_m_status_pegawai', 1)
                            ->order_by('b.eselon', 'desc')
                            ->order_by('a.nama')
                            ->group_by('a.nipbaru_ws');
            if($flag_alpha == 0 && $flag_rekap_personal == 0){
                $this->db->where('a.skpd', $data['id_unitkerja']);
            } else if($flag_alpha == 1){
                $this->db->where('c.id_unitkerjamaster', 8010000);
            }

            if($flag_rekap_personal == 1){
                $this->db->join('m_user d', 'a.nipbaru_ws = d.username')
                        ->where('d.id', $data['id_m_user']);
            }

            $list_pegawai = $this->db->get()->result_array();
        }

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
            foreach($list_pegawai as $lpw){
                $tlp[$lpw['nip']]['nama_pegawai'] = getNamaPegawaiFull($lpw);
                $tlp[$lpw['nip']]['nip'] = ($lpw['nip']);
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
                $this->db->where('c.skpd', $data['id_unitkerja']); 
            }

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
                return null;
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
        if(in_array($uker['id_unitkerja'], LIST_UNIT_KERJA_KHUSUS)){
            $jskpd = 2;
        } else if(in_array($uker['id_unitkerjamaster'], LIST_UNIT_KERJA_MASTER_SEKOLAH)){
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
                    if($lhr == $tjke['berlaku_dari'] || $lhr == $tjke['berlaku_sampai']){ //cek jika tanggal masuk dalam range tanggal jam kerja event
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
            }
        }
        $data['hari_libur'] = $hari_libur;

        $data['disiplin_kerja'] = $this->db->select('keterangan')
                ->from('m_jenis_disiplin_kerja')
                ->where('flag_active', 1)
                ->where_not_in('id', [7, 8, 9, 10, 11, 12])
                ->get()->result_array();

        $this->db->select('b.username as nip, a.tanggal, a.bulan, a.tahun, a.pengurangan, d.keterangan, a.keterangan as keterngn')
                ->from('t_dokumen_pendukung a')
                ->join('m_user b', 'a.id_m_user = b.id')
                ->join('db_pegawai.pegawai c','b.username = c.nipbaru_ws')
                ->join('m_jenis_disiplin_kerja d', 'a.id_m_jenis_disiplin_kerja = d.id')
                ->where('a.bulan', floatval($data['bulan']))
                ->where('a.tahun', floatval($data['tahun']))
                ->where('a.flag_active', 1)
                ->where('c.skpd', $uker['id_unitkerja'])
                ->where('id_m_status_pegawai', 1)
                ->where('a.status', 2);
        $tmp_dokpen = $this->db->get()->result_array();
        $dokpen = null;
        if($tmp_dokpen){
            foreach($tmp_dokpen as $dok){
               
                $tanggal_dok = $dok['tanggal'] < 10 ? '0'.$dok['tanggal'] : $dok['tanggal'];
                $bulan_dok = $dok['bulan'] < 10 ? '0'.$dok['bulan'] : $dok['bulan'];
                $date_dok = $dok['tahun'].'-'.$bulan_dok.'-'.$tanggal_dok;
               
                $dokpen[$dok['nip']]['nip'] = $dok['nip'];
                $dokpen[$dok['nip']][$date_dok] = $dok['keterangan'];
                $dokpen[$dok['nip']]["ket_".$date_dok]= $dok['keterngn'];
                
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
                // $lp[$tr['nip']]['rekap']['hadir_mk'] = 0;
                if($data['disiplin_kerja']){
                    foreach($data['disiplin_kerja'] as $dk){
                        $lp[$tr['nip']]['rekap'][$dk['keterangan']] = 0;
                    }
                }
                foreach($list_hari as $l){
                    if($l <= date('Y-m-d')){

                    if($format_hari[$l]['jam_masuk'] != '' && !isset($hari_libur[$l])){ //bukan hari libur atau hari sabtu / minggu
                        
                        $lp[$tr['nip']]['rekap']['jhk']++;
                    
                // Surat Tugas
                        if(isset($dokpen[$tr['nip']][$l])){  
                            if($dokpen[$tr['nip']][$l] == "TLS"){
                                $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = $dokpen[$tr['nip']][$l];
                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLS';
                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                            } else if($dokpen[$tr['nip']][$l] == "TLP"){
                                $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = $dokpen[$tr['nip']][$l];
                                $lp[$tr['nip']]['absen'][$l]['ket_masuk'] = '';
                                $lp[$tr['nip']]['absen'][$l]['ket_pulang'] = 'TLP';
                                $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
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
                                $lp[$tr['nip']]['rekap']['TK']++;
                                if($lp[$tr['nip']]['rekap']['TK'] > 10 && !isset($list_alpha[$tr['nip']])){
                                    $list_alpha[$tr['nip']] = $tr['nip'];
                                }
                            }
                            $flag_check = 0;
                        } else if($flag_absen_aars == 1){
                            if(isset($dokpen[$tr['nip']][$l]) &&
                                $dokpen[$tr['nip']][$l] != "TLS" && $dokpen[$tr['nip']][$l] != "TLP"){
                                    $lp[$tr['nip']]['absen'][$l]['ket'] = $dokpen[$tr['nip']][$l];
                                    $lp[$tr['nip']]['rekap'][$dokpen[$tr['nip']][$l]]++;
                                    $lp[$tr['nip']]['absen'][$l]['jam_masuk'] = "";
                                    $lp[$tr['nip']]['absen'][$l]['jam_pulang'] = "";
                                    $flag_check = 0;
                                    if($dokpen[$tr['nip']][$l] == "TL"){
                                        $lp[$tr['nip']]['rekap']['hadir']++;
                                    }
                            } else {
                                if((!$lp[$tr['nip']]['absen'][$l]['jam_masuk'] || 
                                    $lp[$tr['nip']]['absen'][$l]['jam_masuk'] == "")){
                                    $lp[$tr['nip']]['absen'][$l]['ket'] = 'TK';
                                    $lp[$tr['nip']]['rekap']['TK']++;
                                    if($lp[$tr['nip']]['rekap']['TK'] > 10 && !isset($list_alpha[$tr['nip']])){
                                        $list_alpha[$tr['nip']] = $tr['nip'];
                                    }
                                    $flag_check = 0;
                                }
                            }
                        }
                        
                        if($flag_check == 1) {
                            $lp[$tr['nip']]['rekap']['hadir']++;
                            // if(isset($dokpen[$tr['nip']][$l]) && $dokpen[$tr['nip']][$l] == 'TLP'){
                            //     dd($lp[$tr['nip']]['absen'][$l]);
                            // }
                            if($lp[$tr['nip']]['absen'][$l]['jam_masuk'] != "TLP" && $lp[$tr['nip']]['absen'][$l]['jam_masuk'] != "Invalid"){
                                $diff_masuk = strtotime($lp[$tr['nip']]['absen'][$l]['jam_masuk']) - strtotime($format_hari[$l]['jam_masuk'].'+ 59 seconds');
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
                            }

                            if($lp[$tr['nip']]['absen'][$l]['jam_pulang'] != "TLS" && $lp[$tr['nip']]['absen'][$l]['jam_pulang'] != "Invalid"){
                                // if($tr['nip'] == '198307212010012005' && $l == '2023-06-08'){
                                //     dd($lp[$tr['nip']]['absen'][$l]);
                                // }
                                $diff_keluar = strtotime($format_hari[$l]['jam_pulang']) - strtotime($lp[$tr['nip']]['absen'][$l]['jam_pulang']);
                                if($diff_keluar > 0){
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
                            }
                            
                            if(isset($dokpen[$tr['nip']][$l])){
                                if($dokpen[$tr['nip']][$l] == "TLS"){

                                } else if ($dokpen[$tr['nip']][$l] == "TLP"){

                                }
                            }
                        }   
                    }
                }
                } 
            }
        }
      
        $data['result'] = $lp;
        // dd(json_encode($lp));
        $rs['json_result'] = json_encode($lp);
        if($flag_absen_aars == 0){
            $data['raw_data_excel'] = $raw_data_excel;
        }
        if($flag_alpha == 1){
            return $list_alpha;
        }        
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

    public function rekapPenilaianDisiplinSearch($data){
        $result = null;

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

        foreach($disiplin_kerja as $dk){
            $mdisker[$dk['keterangan']]['nama'] = $dk['nama_jenis_disiplin_kerja'];
            $mdisker[$dk['keterangan']]['keterangan'] = $dk['keterangan'];
            $mdisker[$dk['keterangan']]['pengurangan'] = $dk['pengurangan'];
        }
                    
        $skpd = explode(";", $data['skpd']);
        $param['bulan'] = $data['bulan'];
        $param['tahun'] = $data['tahun'];
        $param['skpd'] = $skpd[0];
        // dd($data);
        // $temp = $this->readAbsensiFromDb($param);
        $temp = $this->readAbsensiAars($data, $flag_alpha = 0);
        
        // $data_absen = $this->db->select('*')
        //             ->from('t_rekap_absen')
        //             ->where('bulan', $param['bulan'])
        //             ->where('tahun', $param['tahun'])
        //             ->where('id_unitkerja', $param['skpd'])
        //             ->where('flag_active', 1)
        //             ->get()->row_array();
        if($temp){
            $result['skpd'] = $temp['skpd'];
            $result['periode'] = $temp['periode'];
            $result['bulan'] = $temp['bulan'];
            $result['tahun'] = $temp['tahun'];
            $result['mdisker'] = $mdisker;
            foreach($temp['result'] as $tr){
                if(isset($tr['nama_pegawai'])){
                    $result['result'][$tr['nip']]['nama_pegawai'] = $tr['nama_pegawai'];
                    $result['result'][$tr['nip']]['nip'] = $tr['nip'];
                    $result['result'][$tr['nip']]['rekap']['jhk'] = $tr['rekap']['jhk'];
                    $result['result'][$tr['nip']]['rekap']['hadir'] = $tr['rekap']['hadir'];
                    
                    $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] = 0;
                    $result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja'] = 0;
                    $total_pengurangan = 0;
                    foreach($mdisker as $m){
                        $total = $tr['rekap'][$m['keterangan']];
                        $pengurangan = floatval($total) * floatval($m['pengurangan']);
                        $total_pengurangan += $pengurangan;

                        $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['total'] = $total;
                        $result['result'][$tr['nip']]['rekap'][$m['keterangan']]['pengurangan'] = $pengurangan;
                    }

                    if($total_pengurangan <= 100){
                        $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] = 100 - $total_pengurangan;
                        $result['result'][$tr['nip']]['rekap']['capaian_bobot_disiplin_kerja'] = $result['result'][$tr['nip']]['rekap']['capaian_disiplin_kerja'] * floatval(TARGET_BOBOT_DISIPLIN_KERJA/100);
                    }
                }
            }
        }

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
    
    public function getDaftarPerhitunganTpp($pagu_tpp, $rekap, $param){
        $data_disiplin_kerja = null;
        // if(isset($data_rekap['penilaian_disiplin_kerja'])){
        //     $data_disiplin_kerja = null;
        //     $data_disiplin_kerja = $data_rekap['penilaian_disiplin_kerja'];
        // } else {
            $data_disiplin_kerja = $this->rekapPenilaianDisiplinSearch($param);
            $data_disiplin_kerja['flag_print'] = 0;
            $data_disiplin_kerja['use_header'] = 0;
            $temp['penilaian_disiplin_kerja'] = $data_disiplin_kerja;
            // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $data_disiplin_kerja);
        // }
        $temp_disiplin_kerja = $data_disiplin_kerja;
        $data_disiplin_kerja = null;
        foreach($temp_disiplin_kerja['result'] as $tdk){
            if(isset($tdk['nip'])){
                $data_disiplin_kerja[$tdk['nip']] = $tdk;
            }
        }

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
                $explode_golongan_number = explode("/", $explode_golongan_all[1]);
                $result[$p['nipbaru_ws']]['nama_pegawai'] = getNamaPegawaiFull($p);
                $result[$p['nipbaru_ws']]['nip'] = $p['nipbaru_ws'];
                $result[$p['nipbaru_ws']]['pangkat'] = $p['nm_pangkat'];
                $result[$p['nipbaru_ws']]['id_pangkat'] = $p['id_pangkat'];
                $result[$p['nipbaru_ws']]['nama_jabatan'] = $p['nama_jabatan'];
                $result[$p['nipbaru_ws']]['kelas_jabatan'] = $p['kelas_jabatan'];
                $result[$p['nipbaru_ws']]['nomor_golongan'] = $explode_golongan_number[0];
                $result[$p['nipbaru_ws']]['eselon'] = $data_kinerja[$p['nipbaru_ws']]['eselon'];
                $result[$p['nipbaru_ws']]['pagu_tpp'] = $p['pagu_tpp'];
                $result[$p['nipbaru_ws']]['bobot_produktivitas_kerja'] = $data_kinerja[$p['nipbaru_ws']]['bobot_capaian_produktivitas_kerja'];
                $result[$p['nipbaru_ws']]['bobot_disiplin_kerja'] = $data_disiplin_kerja[$p['nipbaru_ws']]['rekap']['capaian_bobot_disiplin_kerja'];
                $result[$p['nipbaru_ws']]['presentase_tpp'] = floatval($result[$p['nipbaru_ws']]['bobot_produktivitas_kerja']) + $result[$p['nipbaru_ws']]['bobot_disiplin_kerja'];
                $result[$p['nipbaru_ws']]['besaran_tpp'] = (floatval($result[$p['nipbaru_ws']]['presentase_tpp']) * floatval($p['pagu_tpp'])) / 100;
                $result[$p['nipbaru_ws']]['besaran_tpp'] = roundDown($result[$p['nipbaru_ws']]['besaran_tpp'], 3);
                $result[$p['nipbaru_ws']]['pph'] = getPphByIdPangkat($p['id_pangkat']);
                $result[$p['nipbaru_ws']]['nominal_pph'] = ((floatval($result[$p['nipbaru_ws']]['pph']) / 100) * $result[$p['nipbaru_ws']]['besaran_tpp']);
                $result[$p['nipbaru_ws']]['tpp_diterima'] = $result[$p['nipbaru_ws']]['besaran_tpp'] - $result[$p['nipbaru_ws']]['nominal_pph'];

            }
        }

        return $result;
    }

    public function readAbsensiAars($param, $flag_alpha = 0){
        $result = null;
        $skpd = explode(";", $param['skpd']);

        $param['id_unitkerja'] = $skpd[0];
        $param['nm_unitkerja'] = $skpd[1];
        return $this->buildDataAbsensi($param, 1, $flag_alpha);
        
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
                        $data['result'] = $this->rekap->readAbsensiAars($params);
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
                    $sendWa = $this->maxchatlibrary->sendFile($c['no_hp'], $fileurl, $filename, $filename);

                    if($sendWa == true){
                        $this->db->where('id', $c['id'])
                            ->update('t_cron_rekap_absen', [
                                'flag_sent' => 1,
                                'done_date' => date('Y-m-d H:i:s'),
                                'response' => 'success'
                            ]);
                    } else {
                        $this->db->where('id', $c['id'])
                            ->update('t_cron_rekap_absen', [
                                'response' => $sendWa
                            ]);
                    }
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
                    ->where('a.status', 2)
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
}
?>