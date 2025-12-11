<?php

// require 'vendor/autoload.php';
require FCPATH . 'vendor/autoload.php';
// use PhpOffice\PhpSpreadSheet\Spreadsheet;
// use PhpOffice\PhpSpreadSheet\IOFactory;
require FCPATH . '/vendor/autoload.php';

// use mpdf\mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use Symfony\Component\HttpFoundation\StreamedResponse;
// use Symfony\Component\HttpFoundation\Response;

class C_Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('user/M_User', 'user');
        $this->load->model('rekap/M_Rekap', 'rekap');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        if (!$this->general_library->isNotMenu()) {
            redirect('logout');
        };
    }

    public function rekapHukdis(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapHukdis', '', '', $data);
    }

    public function searchDataHukdis(){
        $data['result'] = $this->rekap->searchDataHukdis($this->input->post());
        $this->load->view('rekap/V_RekapHukdisResult', $data);
    }

    public function rekapAbsensi()
    {
        $data['jam_kerja'] = $this->general->getAll('t_jam_kerja');
        render('rekap/V_RekapAbsensi', '', '', $data);
    }

    public function rekapAbsensiNew()
    {
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['jam_kerja'] = $this->general->getAll('t_jam_kerja');
        render('rekap/V_RekapAbsensiNew', '', '', $data);
    }

    public function readAbsensiAars($flag_alpha = 0, $flag_rekap_tpp = 0){
        $param = $this->input->post();
        if($flag_alpha == 1){
            $param = [
                'skpd' => '4018000;Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
                'bulan' => '07',
                'tahun' => '2023'
            ];
        }
        $data['result'] = $this->rekap->readAbsensiAars($param, $flag_alpha, $flag_rekap_tpp, 0);
        if($flag_alpha == 1){
            dd($data['result']);
        }
        $data['flag_print'] = 0;
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
        }
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function downloadRekapAbsensiAars($flag_pdf = 0){
        $data = $this->session->userdata('rekap_absen_aars');
        $data['flag_print'] = 1;
        if($flag_pdf == 1){
            $data['flag_pdf'] = 1;
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L',
                'debug' => true
            ]);
            $html = $this->load->view('rekap/V_RekapAbsensiResultNew', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->showImageErrors = true;
            $mpdf->Output('Rekap Absensi '.$data['skpd'].' Bulan '.$data['periode'].'.pdf', 'D');
        } else {
            $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
        }
    }

    public function readAbsensiExcel()
    {
        $data = $this->rekap->readAbsensiExcel();
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function readAbsensiExcelNew()
    {
        $temp = $this->rekap->readAbsensiExcelNew();
        $data = $this->rekap->buildDataAbsensi($temp);
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->rekap->saveDbRekapAbsensi($data);
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function downloadAbsensi()
    {
        $data = $this->session->userdata('data_read_absensi_excel');
        $data['flag_print'] = 1;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function downloadAbsensiNew($flag_pdf = 0)
    {
        $data = $this->session->userdata('data_read_absensi_excel');
        $data['flag_print'] = 1;
        if($flag_pdf == 0){
            $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
        } else {
            $data['flag_pdf'] = 1;
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'Legal-L'
            ]);
            $html = $this->load->view('rekap/V_RekapAbsensiResultNew', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Rekap Absensi '.$data['skpd'].' periode '.$data['periode'].'.pdf', 'D');
        }
    }

    public function readAbsensiFromDb()
    {

        $data = $this->rekap->readAbsensiFromDb($this->input->post());

        // if($temp){
        //     $data = json_decode($temp['json_result'], true);
        // }
        // dd($data);
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
    }

    public function rekapPenilaian()
    {
        $data['list_skpd'] = $this->user->getAllSkpd2();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_RekapPenilaian', '', '', $data);
    }

    public function rekapPenilaianSearch($flag_print = 0)
    {
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;
        if ($flag_print == 1) {
            $data['result'] = $this->session->userdata('data_penilaian_produktivitas_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_penilaian_produktivitas_kerja');
        } else {
            $data['result'] = $this->rekap->rekapPenilaianSearch($this->input->post());
            // $data['result'] = $this->kinerja->rekapPenilaianSearch2($this->input->post());

            $this->session->set_userdata('data_penilaian_produktivitas_kerja', $data['result']);
            $this->session->set_userdata('parameter_data_penilaian_produktivitas_kerja', $data['parameter']);
        }
        // dd($data['result']);

        $this->load->view('rekap/V_RekapPenilaianResult', $data);
    }

    public function rekapPenilaianSearch2($flag_print = 0)
    {
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;
        if ($flag_print == 1) {
            $data['result'] = $this->session->userdata('data_penilaian_produktivitas_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_penilaian_produktivitas_kerja');
        } else {
            // $data['result'] = $this->rekap->rekapPenilaianSearch($this->input->post());
            $data['result'] = $this->kinerja->rekapPenilaianSearch2($this->input->post());

            $this->session->set_userdata('data_penilaian_produktivitas_kerja', $data['result']);
            $this->session->set_userdata('parameter_data_penilaian_produktivitas_kerja', $data['parameter']);
        }
        // dd($data['result']);

        $this->load->view('rekap/V_RekapPenilaianResult2', $data);
    }

    public function rekapDisiplin()
    {
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapDisiplin', '', '', $data);
    }

    public function rekapDisiplinSearch($flag_print = 0)
    {
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;

        $data['result_db'] = null;
        $result_db = $this->rekap->getRekapAbsen($data['parameter']);
        if ($result_db) {
            $data['result_db'] = json_decode($result_db['json_result'], true);
        }
        if ($flag_print == 1) {
            $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        } else {
            $data['result'] = $this->rekap->rekapDisiplinSearch($this->input->post());
        }

        $this->session->set_userdata('data_penilaian_disiplin_kerja', $data['result_db']);
        $this->session->set_userdata('data_penilaian_disiplin_kerja_excel', $data['result']);
        $this->session->set_userdata('parameter_data_disiplin_kerja', $data['parameter']);

        $this->load->view('rekap/V_RekapDisiplinResult', $data);
    }

    public function saveExcelDisiplin()
    {
        $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->load->view('rekap/V_RekapDisiplinExcel', $data);
    }

    public function saveDbRekapDisiplin()
    {
        $excel = $this->session->userdata('data_penilaian_disiplin_kerja_excel');
        if ($excel) {
            $data['result'] = $excel;
        } else {
            $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        }
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->rekap->saveDbRekapDisiplin($data);
    }

    public function rekapPenilaianDisiplin()
    {
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_RekapPenilaianDisiplin', '', '', $data);
    }

    public function rekapPenilaianDisiplinSearch()
    {
        $data = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post(), 0, 0);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapKehadiranResult', $data);
        // $this->load->view('rekap/V_RekapPenilaianDisiplinResult', $data);
    }

    public function rekapPenilaianDisiplinSearchOld()
    {
        $rs = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());
        $data['result'] = json_decode($rs['json_result'], true);
    }

    public function rekapKehadiran()
    {
        $data['result'] = $this->rekap->rekapKehadiran($this->session->userdata('data_penilaian_disiplin_kerja'), $this->session->userdata('parameter_data_disiplin_kerja'));
    }

    public function rekapTpp()
    {
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_RekapTpp', '', '', $data);
    }

    public function rekapTppSearch()
    {
        $this->session->set_userdata('params_rekap_tpp', $this->input->post());
        $data = $this->rekap->rekapTppSearch($this->input->post());
        $data['data_search'] = $this->input->post();
        $data['tpp_tambahan'] = $this->rekap->getTppTambahan($this->input->post());
        $data['data_format_excel'] = $this->rekap->getDataLockTpp($this->input->post());
        $param_lock_tpp = ($this->general->getOne('m_parameter', 'parameter_name', 'PARAM_LOCK_TPP'));
        $data['param_lock_tpp'] = json_decode($param_lock_tpp['parameter_value'], true);
        $this->load->view('rekap/V_RekapTppResult', $data);
    }

    public function downloadBerkasTpp($id_m_tpp_tambahan = 0, $flag_excel = 0){
        $param = $this->input->post();
        $param['id_m_tpp_tambahan'] = $id_m_tpp_tambahan;
        $data['flag_simplified_format'] = 0;

        $time = strtotime('01-'.$param['bulan'].'-'.$param['tahun']);
        $dateFormat = date('Y-m-d', $time);

        $newTime = strtotime('01-09-2024');
        $newDateFormat = date('Y-m-d', $newTime);

        if($time >= $newTime){ // mulai bulan september, di sheets BKAD, dihapuskan untuk PK, BK, KK di BPJS dan PPH
            $data['flag_simplified_format'] = 1;
        }

        // if($this->general_library->isProgrammer()){
        //     echo($dateFormat.' >= '.$newDateFormat);
        //     dd($data);
        // }

        $flag_sekolah_kecamatan = 0;
        // dd($param);
        $skpd = explode(";", $param['skpd']);
        $pd_group = null;
        if(stringStartWith('sekolah_', $skpd[0])){ // jika sekolah per kecamatan, ambil dinas pendidikan punya penandatanganan
            $flag_sekolah_kecamatan = 1;
            $expl = explode('_', $skpd[0]);
            $pd_group = $expl[1];
            $skpd[0] = '3010000';
        }
        $data['param']['id_unitkerja'] = $skpd[0];
        $data['param']['nm_unitkerja'] = $skpd[1];
        $data['param']['bulan'] = $param['bulan'];
        $data['param']['tahun'] = $param['tahun'];
        $data['param']['id_m_tpp_tambahan'] = $id_m_tpp_tambahan;
        $data['param']['presentasi_tpp_tambahan'] = isset($param['presentasi_tpp_tambahan']) ? $param['presentasi_tpp_tambahan'] : null;
        $data['param']['nama_tpp_tambahan'] = isset($param['nama_tpp_tambahan']) ? $param['nama_tpp_tambahan'] : null;;
        $param['id_unitkerja'] = $skpd[0];

        $data['pegawai'] = $this->rekap->getDataPenandatangananBerkasTpp($skpd[0], $param['bulan'], $param['tahun']);
        $pagu_tpp = $this->kinerja->countPaguTpp([
            'id_unitkerja' => $flag_sekolah_kecamatan == 0 ? $data['param']['id_unitkerja'] : $pd_group,
            'bulan' => $data['param']['bulan'],
            'tahun' => $data['param']['tahun']
        ], null, 0, 1, $flag_sekolah_kecamatan);
        
        $data_rekap_kehadiran = $this->rekap->rekapPenilaianDisiplinSearch($param, 1, 1);
        // if($skpd[0] == 4011000){
        //     dd($data_rekap_kehadiran);
        // }
        
        $data['rekap_penilaian_tpp'] = $this->rekap->getDaftarPenilaianTpp($data_rekap_kehadiran, $param, 1);

        foreach ($data['rekap_penilaian_tpp']['result'] as $key => $row) {
            if(isset($row['nama']) || isset($row['nama_pegawai'])){
                $nama_pegawai[$key]  = isset($row['nama_pegawai']) ? $row['nama_pegawai'] : $row['nama'];
                $kelas_jabatan[$key] = $row['kelas_jabatan'];
            }
        }
        array_multisort($kelas_jabatan, SORT_DESC, $nama_pegawai, SORT_ASC, $data['rekap_penilaian_tpp']['result']);
        
        // if($skpd[0] == 3021000){
        //     dd($pagu_tpp);
        // }

        $temp = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
       
        if(isset($temp['flag_use_this']) && isset($temp['flag_use_this']) == 1){
            $data = $temp;
            // unset($temp['flag_use_this']);
        } else {
            $data['result'] = $temp;
            $data['rekap'] = $data['result']['rekap'];
            $data['rekap_pppk'] = $data['result']['rekap_pppk'];
            $data['hukdis'] = $data['result']['hukdis'];
            $data['kepalabkpsdm'] = $data['result']['kepalabkpsdm'];
            $data['pppk'] = isset($data['result']['pppk']) ? $data['result']['pppk'] : null ;
            $data['flag_sekolah_kecamatan'] = $flag_sekolah_kecamatan;
            
            unset($data['result']['rekap_pppk']);
            unset($data['result']['pppk']);
            unset($data['result']['rekap']);
            unset($data['result']['hukdis']);
            unset($data['result']['kepalabkpsdm']);

            foreach($data['result'] as $key => $row) {
                if($row['flag_terima_tpp'] == 0){
                    unset($data['result'][$key]);
                } else {
                    if(isset($row['nama']) || isset($row['nama_pegawai'])){
                        $nama_pegawai_result[$key]  = isset($row['nama_pegawai']) ? $row['nama_pegawai'] : $row['nama'];
                        $kelas_jabatan_result[$key] = $row['kelas_jabatan'];
                    }
                }
            }
            array_multisort($kelas_jabatan_result, SORT_DESC, $nama_pegawai_result, SORT_ASC, $data['result']);
        }


        // jika flag_use_this, gunakan file yang sudah ada. cari sandiri dpe coding 

        // if($flag_excel == 0){
            $html = null;
            if($data['param']['tahun'] >= 2025){
                $html = $this->load->view('rekap/V_BerkasTppDownloadNew', $data, true);
            } else {
                $html = $this->load->view('rekap/V_BerkasTppDownload', $data, true);
            }
            if($this->general_library->isProgrammer()){
                // dd($html);
            }
            // if($data['param']['id_unitkerja'] == '1030550'){
            //     dd($html);   
            // }
            $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
            $this->mpdf->AddPage(
                'L', // L - landscape, P - portrait
                '',
                '',
                '',
                '',
                10, // margin_left
                10, // margin right
                5, // margin top
                10, // margin bottom
                18, // margin header
                12
            ); // margin footer
            // $this->mpdf->setFooter('{PAGENO}');
            $filename = 'Rekap TPP '.$skpd[1].' '.getNamaBulan($data['param']['bulan']).' '.$data['param']['tahun'].'.pdf';
            if($id_m_tpp_tambahan != 0){
                $filename = 'Rekap TPP '.$skpd[1].' '.$data['param']['nama_tpp_tambahan'].'.pdf';
            }

            $folder = 'arsiptpp/'.$data['param']['tahun'].'/'.getNamaBulan($data['param']['bulan']);
            if($id_m_tpp_tambahan != 0){
                $folder = 'arsiptpp/'.$data['param']['nama_tpp_tambahan'];
            }

            if(!file_exists($folder)){
                if(!file_exists('arsiptpp')){
                    $oldmask = umask(0);
                    mkdir('arsiptpp', 0777);
                    umask($oldmask);
                }

                if(!file_exists('arsiptpp/'.$data['param']['tahun']) && $id_m_tpp_tambahan == 0){
                    $oldmask = umask(0);
                    mkdir('arsiptpp/'.$data['param']['tahun'], 0777);
                    umask($oldmask);
                }

                $oldmask = umask(0);
                mkdir($folder, 0777);
                umask($oldmask);
            }

            $data['param']['url_file'] = $folder.'/'.$filename;
            $data['orgiginal_id_unitkerja'] = $param['skpd'];
            if($id_m_tpp_tambahan == 0){
                $this->rekap->lockTpp($data['param'], $data);
            }

            $this->mpdf->WriteHTML($html);
            $this->mpdf->Output($filename, 'D'); // download force
        // }

        $this->mpdf->Output($folder.'/'.$filename, 'F'); // download force
    }

    public function loadViewByJenisFile($jenis_file)
    {
        $data_absen = $this->session->userdata('data_absen_rekap_tpp');
      
        $param = $this->session->userdata('params_rekap_tpp');
        $skpd = explode(";", $param['skpd']);
        $data_absen['unitkerja'] = $skpd[0];
        $data_absen['bulan'] = $param['bulan'];
        $data_absen['tahun'] = $param['tahun']; 
        // dd($this->session->userdata(''));
        // dd($data_absen['raw_data_excel']);
        // $data_rekap = $this->session->userdata('rekap_' . $param['bulan'] . '_' . $param['tahun']);

        switch ($jenis_file) {
            case "kehadiran" :
                $data['skpd'] = $skpd;
                $data = $this->rekap->rekapPenilaianDisiplinSearch($param, 1);
                // $data['result'] = $this->fixOrder($data['result']);
                // $data['result'] = $this->rekap->readAbsensiAars($param, $flag_alpha = null);
                $this->load->view('rekap/V_RekapKehadiranResult', $data);
                break;

            case "penilaian_disiplin_kerja":
                // if($data_rekap && isset($data_rekap['penilaian_disiplin_kerja'])){
                //     $data = $data_rekap['penilaian_disiplin_kerja'];
                // } else {
                $data = $this->rekap->rekapPenilaianDisiplinSearch($param, 1);
                $data['result'] = $this->fixOrder($data['result']);
                $data['flag_print'] = 0;
                $data['use_header'] = 0;
                // }

                $temp['penilaian_disiplin_kerja'] = $data;
                // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);

                $this->load->view('rekap/V_RekapPenilaianDisiplinResult', $data);
                break;

            case "produktivitas_kerja":
                // if($data_rekap && isset($data_rekap['produktivitas_kerja'])){
                //     $data['result'] = $data_rekap['produktivitas_kerja'];
                // } else {
                // $data['result'] = $this->kinerja->rekapPenilaianSearch2($param);
                $data['result'] = $this->rekap->rekapPenilaianSearch($param);

                // dd(json_encode($data['result']));
                // $data['result'] = $this->rekap->rekapProduktivitasKerja($param, 1);
                // $data['result'] = $this->fixOrder($data['result']);
                $data['parameter'] = $param;
                $data['flag_print'] = 0;
                $data['use_header'] = 0;
                // }
               
                $temp['produktivitas_kerja'] = $data;
                // $this->session->set_userdata('rekap_'.$param['bulan'].'_'.$param['tahun'], $temp);

                $this->load->view('rekap/V_RekapPenilaianResult', $data);
                break;

            case "daftar_penilaian_tpp":
                $data['skpd'] = $skpd;
                $data_disiplin = $this->rekap->rekapPenilaianDisiplinSearch($param, 1);
                $data['result'] = $this->rekap->getDaftarPenilaianTpp($data_disiplin, $param, 1);
                $data['result']['result'] = $this->fixOrder($data['result']['result']);
                $this->load->view('rekap/V_RekapPenilaianTppResult', $data);
                break;

            case "daftar_perhitungan_tpp":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {

                $explode_param = explode(";", $param['skpd']);
                $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]], null, 0, 1);
                $param['id_unitkerja'] = $explode_param[0];
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['result'] = $this->fixOrder($data['result']);
                // $data_rekap = $this->rekap->readAbsensiAars($param, $flag_alpha = null);
                // // dd($param);
                // $explode_param = explode(";", $param['skpd']);
                // $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                // $temp['daftar_perhitungan_tpp'] = $data['result'];
                // $this->session->set_userdata('rekap_' . $param['bulan'] . '_' . $param['tahun'], $temp);
                // }

                $this->load->view('rekap/V_RekapPerhitunganTpp', $data);
                break;

            case "absen":
                $data = null;
                $data['result'] = $this->rekap->readAbsensiAars($param, $flag_alpha = null, 1);
                $data['flag_print'] = 0;
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
                    // $this->session->set_userdata('rekap_absen_aars', $data);
                }
                $this->load->view('rekap/V_RekapAbsensiResultNew', $data);
                break;

            case "daftar_permintaan":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                $explode_param = explode(";", $param['skpd']);
                $param['id_unitkerja'] = $explode_param[0];
                $pagu_tpp = $this->kinerja->countPaguTpp($param, null, 0, 1);
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['result'] = $this->fixOrder($data['result']);
                // }
                $this->load->view('rekap/V_DaftarPermintaanTpp', $data);
                break;

            case "daftar_permintaan_bkad":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                $explode_param = explode(";", $param['skpd']);
                $param['id_unitkerja'] = $explode_param[0];
                $pagu_tpp = $this->kinerja->countPaguTpp($param, null, 0, 1);
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['result'] = $this->fixOrder($data['result']);
                // }
                $this->load->view('rekap/V_DaftarPermintaanTppBkad', $data);
                break;

            case "daftar_pembayaran":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                $explode_param = explode(";", $param['skpd']);
                $param['id_unitkerja'] = $explode_param[0];
                $pagu_tpp = $this->kinerja->countPaguTpp($param, null, 0, 1);
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['result'] = $this->fixOrder($data['result']);
                // }
                $this->load->view('rekap/V_DaftarPembayaranTpp', $data);
                break;

            case "surat_pengantar":
                $explode_param = explode(";", $param['skpd']);
                $param['id_unitkerja'] = $explode_param[0];
                $pagu_tpp = $this->kinerja->countPaguTpp($param, null, 0, 1);
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['param'] = $param;
                $data['param']['nm_unitkerja'] = $explode_param[1];
                $data['rekap'] = $data['result']['rekap'];
                $data['hukdis'] = $data['result']['hukdis'];
                $data['pegawai'] = $this->rekap->getDataPenandatangananBerkasTpp($skpd[0]);
                $data['kepalabkpsdm'] = $data['result']['kepalabkpsdm'];
                if(stringStartWith('Puskesmas', $explode_param[1])){
                    $data['kepalabkpsdm'] = $data['pegawai']['kapus'];
                }
                $data['result'] = $this->fixOrder($data['result']);
                // }
                $this->load->view('rekap/V_SuratPengantar', $data);
                break;

            case "salinan_surat_pengantar":
                $explode_param = explode(";", $param['skpd']);
                $param['id_unitkerja'] = $explode_param[0];
                $pagu_tpp = $this->kinerja->countPaguTpp($param, null, 0, 1);
                $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);
                $data['param'] = $param;
                $data['param']['nm_unitkerja'] = $explode_param[1];
                $data['rekap'] = $data['result']['rekap'];
                $data['hukdis'] = $data['result']['hukdis'];
                $data['kepalabkpsdm'] = $data['result']['kepalabkpsdm'];
                $data['result'] = $this->fixOrder($data['result']);
                // }
                $this->load->view('rekap/V_SalinanSuratPengantar', $data);
                break;
        }
    }

    public function fixOrder($data){
        if(isset($data['rekap'])){
            unset($data['rekap']);
        }

        if(isset($data['hukdis'])){
            unset($data['hukdis']);
        }

        if(isset($data['kepalabkpsdm'])){
            unset($data['kepalabkpsdm']);
        }

        if(isset($data['pppk'])){
            unset($data['pppk']);
        }

        if(isset($data['rekap_pppk'])){
            unset($data['rekap_pppk']);
        }
        
        if($data == null){
            return $data;
        }

        $result = null;
        foreach ($data as $key => $row) {
            $nama_pegawai[$key]  = isset($row['nama_pegawai']) ? $row['nama_pegawai'] : $row['nama'];
            $kelas_jabatan[$key] = $row['kelas_jabatan'];
        }
        array_multisort($kelas_jabatan, SORT_DESC, $nama_pegawai, SORT_ASC, $data);
        return $data;
    }

    public function downloadPdf()
    {

        // $data = $this->session->userdata('data_read_absensi_excel');
        // $data['flag_print'] = 1;
        // $this->load->view('rekap/V_RekapAbsensiResultNew', $data);

        // dd($this->input->post());
        $data = $this->rekap->readAbsensiFromDb($this->input->post());
        $data['penilaian'] = $this->rekap->rekapPenilaianSearch($this->input->post());
        $data['parameter'] = $this->input->post();
        $data['disiplin'] = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());

        $explode_param = explode(";", $data['parameter']['skpd']);
        $data_rekap = $this->session->userdata('rekap_' . $data['parameter']['bulan'] . '_' . $data['parameter']['tahun']);
        $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
        $data['perhitungan_tpp'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $data['parameter']);
        $temp['daftar_perhitungan_tpp'] = $data['perhitungan_tpp'];




        // dd($data['disiplin']);

        // $this->load->view('rekap/V_RekapTppPdf', $data);

        // $data['flag_print'] = 1;
        // $html = $this->load->view('rekap/V_RekapTppPdf',$data, true);
        // $mpdf = new \Mpdf\Mpdf([
        //     'format'=>'A4',
        //     'orientation'=>'landscape',
        //     'margin_top'=>5,
        //     'margin_right'=>10,
        //     'margin_left'=>10,
        //     'margin_bottom'=>10,
        // ]);
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();

        $html = $this->load->view('rekap/V_RekapTppPdf', $data, true);
        // $html = $this->load->view('rekap/V_RekapTppPdfNew', $data, true);
        $this->mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215, 330]]);
        // $this->stylesheet = file_get_contents('css/style.css');
        $this->mpdf->AddPage(
            'L', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            5, // margin top
            10, // margin bottom
            18, // margin header
            12
        ); // margin footer
        $this->mpdf->WriteHTML($html);
        $skpd = explode(";", $data['parameter']['skpd']);
        $bulan = getNamaBulan($data['parameter']['bulan']);
        // $this->mpdf->Output('Rekap TPP '.$skpd[1].' '.$bulan.' '.$data['parameter']['tahun'].'.pdf', 'D'); // download force
        $this->mpdf->Output('Rekap TPP ' . $skpd[1] . ' ' . $bulan . ' ' . $data['parameter']['tahun'] . '.pdf', 'I'); // view in the explorer

    }

    public function rekapVerifPdm(){
        render('kepegawaian/V_RekapVerifikasiPdm', '', '', null);
    }

    public function searchRekapVerifPdm(){
        $data['result'] = $this->rekap->searchRekapVerifPdm($this->input->post());
        $this->load->view('kepegawaian/V_RekapVerifikasiPdmResult', $data);
    }

    public function rekapPegawaiPerjabatan($unitkerja = 0){
        $data['result'] = $this->rekap->rekapPegawaiPerjabatan($unitkerja);
        // $this->load->view('kepegawaian/V_RekapPegawaiPerJabatan', $data);
        render('kepegawaian/V_RekapPegawaiPerJabatan', '', '', $data);
    }

    public function cronRekapAbsen(){
        $this->rekap->cronRekapAbsen();
    }

    public function formatTppBkad(){
        render('rekap/V_FormatTppBkad', '', '', null);
    }

    public function loadFormatTppBkadData(){
        $data['result'] = $this->rekap->loadFormatTppBkadData();
        $this->load->view('rekap/V_FormatTppBkadData', $data);
    }

    public function formatTppBkadDownload($id){
        $rs = $this->general->getOne('t_lock_tpp', 'id', $id);
        $data = json_decode($rs['meta_data'], true);
        $data['filename'] = "Berkas TPP Format BKAD - ".preg_replace('/[^A-Za-z0-9\-]/', '', $data['param']['nm_unitkerja'])." Periode ".getNamaBulan($data['param']['bulan'])." ".$data['param']['tahun'].'.xls';

        // $result['filename'] = $data['filename'];
        // $result['result'] = $data['result'];

        if($this->general_library->isProgrammer()){
            // dd($result);
        }
        
        $this->load->view('rekap/V_DownloadFormatTppBkadExcel', $data);
    }

    public function uploadGajiBkad(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_UploadGajiBkad', '', '', $data);
    }

    public function loadGajiPegawai(){
        $data['result'] = $this->rekap->loadGajiPegawai();
        $this->load->view('rekap/V_UploadGajiBkadListGaji', $data);
    }

    public function readUploadGaji(){
        echo json_encode($this->rekap->readUploadGaji());
    }

    public function downloadDataNotFoundUploadGaji(){
        $data = $this->session->userdata('data_not_found');
        $this->load->view('rekap/V_UploadGajiBkadNotFoundExcel', $data);
    }

    public function loadUploadGajiHistory(){
        $data['result'] = $this->rekap->loadUploadGajiHistory();
        $this->load->view('rekap/V_UploadGajiBkadHistory', $data);
    }

    public function verifikasiBerkasTpp(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_VerifUploadTpp', '', '', $data);
    }

    public function loadRiwayatVerifBerkasTpp(){
        // $data['result'] = $this->rekap->loadRiwayatUploadBerkasTpp();
        $data['params'] = json_encode($this->input->post());
        $this->load->view('rekap/V_VerifUploadTppList', $data);
    }

    public function loadRiwayatVerifBerkasTppByStatus($status){
        $data['result'] = $this->rekap->loadRiwayatVerifBerkasTppByStatus($status);
        $this->load->view('rekap/V_VerifUploadTppListData', $data);
    }

    public function loadModalVerifUploadBerkasTpp($id){
        $data['result'] = $this->rekap->loadModalVerifUploadBerkasTpp($id);
        $this->load->view('rekap/V_VerifUploadTppModal', $data);
    }

    public function loadModalBalasanVerifTpp($id){
        $data['result'] = $this->rekap->loadModalVerifUploadBerkasTpp($id);
        $this->load->view('rekap/V_VerifUploadTppModalBalasan', $data);
    }

    public function saveVerifUploadBerkasTpp(){
        echo json_encode($this->rekap->saveVerifUploadBerkasTpp());
    }

    public function saveUploadBerkasTppBalasan($id){
        echo json_encode($this->rekap->saveUploadBerkasTppBalasan($id));
    }

    public function deleteBerkasTppBalasan($id){
        echo json_encode($this->rekap->deleteBerkasTppBalasan($id));
    }

    public function uploadBerkasTpp(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        $data['skpd_diknas'] = $this->user->getUnitKerjaKecamatanDiknas();
        render('rekap/V_UploadTpp', '', '', $data);
    }

    public function checkStatusUploadBerkasTpp(){
        echo json_encode($this->rekap->checkStatusUploadBerkasTpp());
    }

    public function saveUploadBerkasTpp(){
        echo json_encode($this->rekap->saveUploadBerkasTpp());
    }

    public function loadRiwayatUploadBerkasTpp(){
        $data['result'] = $this->rekap->loadRiwayatUploadBerkasTpp();
        $this->load->view('rekap/V_UploadTppRiwayat', $data);
    }

    public function deleteRiwayatUploadBerkasTpp($id){
        echo json_encode($this->rekap->deleteRiwayatUploadBerkasTpp($id));
    }

    public function openFileUploadBerkasTpp($id){
        $data = $this->input->post();
        $this->load->view('rekap/V_UploadTppOpenFile', $data);
    }

    public function testDropzone(){
        dd($_FILES);
    }

    public function rekapKehadiranPeriodik(){
        $data['unitkerja'] = $this->general->getAll('db_pegawai.unitkerja', 0);
        render('rekap/V_RekapKehadiranPeriodik', '', '', $data);
    }

    public function searchRekapKehadiranPeriodik(){
        $data['params'] = $this->input->post();
        $data['result'] = $this->rekap->searchRekapKehadiranPeriodik($this->input->post());
        $data['jenisdisiplin'] = $this->general->getAll('m_jenis_disiplin_kerja', 1);
        $this->load->view('rekap/V_RekapKehadiranPeriodikResult', $data);
    }

    public function loadDetailRekapKehadiran($id_m_user, $tahun){
        $data['result'] = $this->rekap->searchRekapKehadiranPeriodikByIdUser($id_m_user, $tahun);
        $data['jenisdisiplin'] = $this->general->getAll('m_jenis_disiplin_kerja', 1);
        $this->load->view('rekap/V_RekapKehadiranPeriodikDetail', $data);
    }
}
