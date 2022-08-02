<?php

require 'vendor/autoload.php';
// use PhpOffice\PhpSpreadSheet\Spreadsheet;
// use PhpOffice\PhpSpreadSheet\IOFactory;

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
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function rekapAbsensi(){
        $data['jam_kerja'] = $this->general->getAll('t_jam_kerja');
        render('rekap/V_RekapAbsensi', '', '', $data);
    }

    public function readAbsensiExcel(){
        // $url = base_url('assets/rekapabsen/RekapAbsensi.xls');
        // $url = base_url('assets/rekapabsen/test.txt');
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HEADER, false);
        // $data = curl_exec($curl);
        // curl_close($curl);
        // $handle = fopen($url, "r");
        // if ($handle) {
        //     while (($line = fgets($handle)) !== false) {
        //         echo $line;
        //     }
        
        //     fclose($handle);
        // } else {
        //     // error opening the file.
        // } 
        // dd($handle);
        $data = $this->rekap->readAbsensiExcel();
        $this->session->set_userdata('data_read_absensi_excel', $data);
        $data['flag_print'] = 0;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function downloadAbsensi(){
        $data = $this->session->userdata('data_read_absensi_excel');
        $data['flag_print'] = 1;
        $this->load->view('rekap/V_RekapAbsensiResult', $data);
    }

    public function rekapPenilaian(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapPenilaian', '', '', $data);
    }

    public function rekapPenilaianSearch($flag_print = 0){
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;
        if($flag_print == 1){
            $data['result'] = $this->session->userdata('data_penilaian_produktivitas_kerja');
            $data['parameter'] = $this->session->userdata('parameter_data_penilaian_produktivitas_kerja');
        } else {
            $data['result'] = $this->rekap->rekapPenilaianSearch($this->input->post());
            $this->session->set_userdata('data_penilaian_produktivitas_kerja', $data['result']);
            $this->session->set_userdata('parameter_data_penilaian_produktivitas_kerja', $data['parameter']);
        }
        $this->load->view('rekap/V_RekapPenilaianResult', $data);
    }

    public function rekapDisiplin(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapDisiplin', '', '', $data);
    }

    public function rekapDisiplinSearch($flag_print = 0){
        $data['parameter'] = $this->input->post();
        $data['flag_print'] = $flag_print;

        $data['result_db'] = null;
        $result_db = $this->rekap->getRekapAbsen($data['parameter']);
        if($result_db){
            $data['result_db'] = json_decode($result_db['json_result'], true);
        }
        if($flag_print == 1){
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

    public function saveExcelDisiplin(){
        $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->load->view('rekap/V_RekapDisiplinExcel', $data);
    }

    public function saveDbRekapDisiplin(){
        $excel = $this->session->userdata('data_penilaian_disiplin_kerja_excel');
        if($excel){
            $data['result'] = $excel;
        } else {
            $data['result'] = $this->session->userdata('data_penilaian_disiplin_kerja');
        }
        $data['parameter'] = $this->session->userdata('parameter_data_disiplin_kerja');
        $this->rekap->saveDbRekapDisiplin($data);
    }

    public function rekapPenilaianDisiplin(){
        $data['list_skpd'] = $this->user->getAllSkpd();
        render('rekap/V_RekapPenilaianDisiplin', '', '', $data);
    }

    public function rekapPenilaianDisiplinSearch(){
        $rs = $this->rekap->rekapPenilaianDisiplinSearch($this->input->post());
        $data['result'] = json_decode($rs['json_result'], true);
    }

    public function rekapKehadiran(){
        $data['result'] = $this->rekap->rekapKehadiran($this->session->userdata('data_penilaian_disiplin_kerja'), $this->session->userdata('parameter_data_disiplin_kerja'));
    }

}
