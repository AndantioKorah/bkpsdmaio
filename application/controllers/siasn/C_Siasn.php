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

class C_Siasn extends CI_Controller
{
    public $oauth_token;
    public $sso_token;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('siasn/M_Siasn', 'siasn');
        $this->load->model('kepegawaian/M_Kepegawaian', 'kepegawaian');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        if (!$this->general_library->isNotMenu()) {
            redirect('logout');
        };
    }

    public function siasnJabatan($id_m_user){
        $data['id_m_user'] = $id_m_user;
        $this->load->view('siasn/V_JabatanSiasn', $data);
    }

    public function loadListJabatanSiasn($id_m_user){
        $pegawai = $this->general->getOne('m_user', 'id', $id_m_user, 1);
        $result = $this->siasnlib->getJabatanByNip($pegawai['username']);
        $data['result'] = null;
        $data['id_m_user'] = $id_m_user;
        if($result['code'] == 0){
            $data['result'] = json_decode($result['data'], true);
        }
        $this->load->view('siasn/V_JabatanSiasnList', $data);
    }

    public function loadSyncJabatan($id_m_user){
        $pegawai = $this->general->getOne('m_user', 'id', $id_m_user, 1);
        $result = $this->siasnlib->getJabatanByNip($pegawai['username']);

        $riwayat['siladen'] = null;
        $riwayat['siasn'] = null;

        $data['list_jabatan_siasn'] = null;
        $data['id_m_user'] = $id_m_user;
        
        if($result['code'] == 0){
            $data['list_jabatan_siasn'] = json_decode($result['data'], true);
        }
        $data['list_jabatan_siladen'] = $this->kepegawaian->getJabatan($pegawai['username'], 1);
        if($data['list_jabatan_siladen']){
            foreach($data['list_jabatan_siladen'] as $dsil){
                $riwayat['siladen'][$dsil['id']] = $dsil;
            }
        }

        if($data['list_jabatan_siasn']){
            foreach($data['list_jabatan_siasn']['data'] as $dsia){
                $riwayat['siasn'][$dsia['id']] = $dsia;
            }
        }

        $this->session->set_userdata('riwayat_jabatan', $riwayat);
        
        $this->load->view('siasn/V_JabatanSiasnSync', $data);
    }

    public function loadDetailRiwayat($base, $id){
        $data = $this->session->userdata('riwayat_jabatan');
        $file = null;
        
        if($base == 'siasn'){
            dd($data[$base][$id]['path'][872]['dok_uri']);
            $downloadFile = $this->siasnlib->downloadDokumen($data[$base][$id]['path'][872]['dok_uri']);
            if($downloadFile['code'] == 0){
                $fileName = generateRandomNumber(20).'.pdf';
                file_put_contents('temp_pdf_from_api_siasn/'.$fileName, $downloadFile['data']);
                $file = convertToBase64('temp_pdf_from_api_siasn/'.$fileName);
                unlink('temp_pdf_from_api_siasn/'.$fileName);
            }
        }

        $data[$base][$id]['file'] = $file;

        echo json_encode($data[$base][$id]);
    }

    public function sinkronIdSiasn($id_siladen, $id_siasn){
        $data = $this->session->userdata('riwayat_jabatan');
        $this->siasn->sinkronIdSiasn($id_siladen, $id_siasn, $data);
    }

    public function downloadFileSiasn(){
        $data = $this->general_library->downloadFileSiasn($this->input->post('url'));
        echo $data;
    }

    public function mappingJabatanFungsional($flag_only_show){
        $this->siasn->mappingJabatanFungsional($flag_only_show);
    }

    public function revertMappingJabatan($jenis = 'Struktural', $percent, $flag_only_show){
        $this->siasn->revertMappingJabatan($jenis, $percent, $flag_only_show);
    }

    public function syncRiwayatJabatanSiasn($id_m_user){
        echo json_encode($this->siasn->syncRiwayatJabatanSiasn($id_m_user));
    }
    
}
