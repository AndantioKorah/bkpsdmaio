<?php

// require 'vendor/autoload.php';
require FCPATH . 'vendor/autoload.php';
// use PhpOffice\PhpSpreadSheet\Spreadsheet;
// use PhpOffice\PhpSpreadSheet\IOFactory;
require FCPATH . '/vendor/autoload.php';

// use mpdf\mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function readAbsensiAars($flag_alpha = 0){
        $param = $this->input->post();
        if($flag_alpha == 1){
            $param = [
                'skpd' => '4018000;Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
                'bulan' => '07',
                'tahun' => '2023'
            ];
        }
        $data['result'] = $this->rekap->readAbsensiAars($param, $flag_alpha);
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
        $data['list_skpd'] = $this->user->getAllSkpd();
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
            $this->session->set_userdata('data_penilaian_produktivitas_kerja', $data['result']);
            $this->session->set_userdata('parameter_data_penilaian_produktivitas_kerja', $data['parameter']);
        }

        $this->load->view('rekap/V_RekapPenilaianResult', $data);
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
        render('rekap/V_RekapPenilaianDisiplin', '', '', $data);
    }

    public function rekapPenilaianDisiplinSearch()
    {
        $data = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapPenilaianDisiplinResult', $data);
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
        render('rekap/V_RekapTpp', '', '', $data);
    }

    public function rekapTppSearch()
    {
        
        $this->session->set_userdata('params_rekap_tpp', $this->input->post());
        $data = $this->rekap->rekapTppSearch($this->input->post());
        // dd($data);
        $data['data_search'] = $this->input->post();
        $this->load->view('rekap/V_RekapTppResult', $data);
    }

    public function downloadBerkasTpp(){
        $param = $this->input->post();
        // dd($param);
        $skpd = explode(";", $param['skpd']);
        $data['param']['id_unitkerja'] = $skpd[0];
        $data['param']['nm_unitkerja'] = $skpd[1];
        $data['param']['bulan'] = $param['bulan'];
        $data['param']['tahun'] = $param['tahun'];

        $data['pegawai']['kepalaskpd'] = null;
        $data['pegawai']['kasubag'] = null;

        $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $data['param']['id_unitkerja']], null, 0, 1);
        $list_pagu_tpp = null;
        if($pagu_tpp){
            foreach($pagu_tpp as $pt){
                if($pt['kepalaskpd'] == 1){
                    $data['pegawai']['kepalaskpd'] = $pt;
                } else if(isKasubKepegawaian($pt['nama_jabatan'])){
                    $data['pegawai']['kasubag'] = $pt;
                }
                $list_pagu_tpp[$pt['nipbaru_ws']] = $pt;
            }
        }
        $data_rekap_kehadiran = $this->rekap->rekapPenilaianDisiplinSearch($param, 1);
        $data['rekap_penilaian_tpp'] = $this->rekap->getDaftarPenilaianTpp($data_rekap_kehadiran, $param, 1);
        $data['result'] = $this->rekap->getDaftarPerhitunganTppNew($pagu_tpp, $param, 1);

        $html = $this->load->view('rekap/V_BerkasTppDownload', $data, true);
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
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('Rekap TPP '.$skpd[1].' '.getNamaBulan($data['param']['bulan']).' '.$data['param']['tahun'].'.pdf', 'D'); // download force

        // $this->load->view('rekap/V_BerkasTppDownload', $data);
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
                $data['result'] = $this->fixOrder($data['result']);
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
                // $data['result'] = $this->rekap->rekapPenilaianSearch($param);
                // dd(json_encode($data['result']));
                $data['result'] = $this->rekap->rekapProduktivitasKerja($param, 1);
                $data['result'] = $this->fixOrder($data['result']);
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
                $data_rekap = $this->rekap->readAbsensiAars($param, $flag_alpha = null);
                $explode_param = explode(";", $param['skpd']);
                $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
                $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                $temp['daftar_perhitungan_tpp'] = $data['result'];
                $this->session->set_userdata('rekap_' . $param['bulan'] . '_' . $param['tahun'], $temp);
                // }
                $this->load->view('rekap/V_DaftarPermintaanTpp', $data);
                break;

            case "daftar_pembayaran":
                // if($data_rekap && isset($data_rekap['daftar_perhitungan_tpp'])){
                //     $data['result'] = $data_rekap['daftar_perhitungan_tpp'];
                // } else {
                $data_rekap = $this->rekap->readAbsensiAars($param, $flag_alpha = null);
                $explode_param = explode(";", $param['skpd']);
                $pagu_tpp = $this->kinerja->countPaguTpp(['id_unitkerja' => $explode_param[0]]);
                $data['result'] = $this->rekap->getDaftarPerhitunganTpp($pagu_tpp, $data_rekap, $param);
                $temp['daftar_perhitungan_tpp'] = $data['result'];
                $this->session->set_userdata('rekap_' . $param['bulan'] . '_' . $param['tahun'], $temp);
                // }
                $this->load->view('rekap/V_DaftarPembayaranTpp', $data);
                break;
        }
    }

    public function fixOrder($data){
        // $result = null;
        // function fixOrde1($object1, $object2) {
        //     if(isset($object1['nama'])){
        //         return $object1['nama'] < $object2['nama'];
        //     } else {
        //         return $object1['nama_pegawai'] < $object2['nama_pegawai'];
        //     }
        // }
        // usort($data, 'fixOrde1');
        // $result = $data;
        
        // function fixOrder2($object1, $object2) {
        //     return floatval($object1['kelas_jabatan']) < floatval($object2['kelas_jabatan']);
        // }
        // usort($data, 'fixOrder2');
        // $result = $data;

        // return $result;
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
}
