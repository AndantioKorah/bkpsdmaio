<?php

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class C_Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_User', 'user');
		$this->load->model('admin/M_Admin', 'admin');
		       
		if (!$this->general_library->isNotMenu()) {
			redirect('logout');
		};
	}

	public function broadcastWhatsapp(){
		$data['pangkat'] = $this->m_general->getAll('db_pegawai.pangkat', 0);
        $data['eselon'] = $this->m_general->getAll('db_pegawai.eselon', 0);
        $data['statuspeg'] = $this->m_general->getAll('db_pegawai.statuspeg', 0);
        $data['tktpendidikan'] = $this->m_general->getAll('db_pegawai.tktpendidikan', 0);
        $data['agama'] = $this->m_general->getAll('db_pegawai.agama', 0);
        $data['keteranganpegawai'] = $this->m_general->getAll('m_status_pegawai', 0);
        $data['unitkerja'] = $this->m_general->getAllWithOrderGeneral('db_pegawai.unitkerja', 'nm_unitkerja', 'asc');
        $data['jft'] = $this->user->getListJabatanByJenis('JFT');
        $data['satyalencana'] = $this->m_general->getAllWithOrderGeneral('m_satyalencana', 'nama_satya_lencana', 'asc');
        $data['golongan'] = [
            1 => [
                'id_golongan' => 'golongan_1',
                'nm_golongan' => 'Golongan I'
            ],
            2 => [
                'id_golongan' => 'golongan_2',
                'nm_golongan' => 'Golongan II'
            ],
            3 => [
                'id_golongan' => 'golongan_3',
                'nm_golongan' => 'Golongan III'
            ],
            4 => [
                'id_golongan' => 'golongan_4',
                'nm_golongan' => 'Golongan IV'
            ],
            5 => [
                'id_golongan' => 'golongan_5',
                'nm_golongan' => 'Golongan V'
            ],
            6 => [
                'id_golongan' => 'golongan_7',
                'nm_golongan' => 'Golongan VII'
            ],
            7 => [
                'id_golongan' => 'golongan_9',
                'nm_golongan' => 'Golongan IX'
            ],
            8 => [
                'id_golongan' => 'golongan_10',
                'nm_golongan' => 'Golongan X'
            ],
        ];
        $data['jenis_kelamin'] = [
            1 => [
                'id_jenis_kelamin' => 'Laki-laki',
                'nm_jenis_kelamin' => 'Laki-Laki'
            ],
            2 => [
                'id_jenis_kelamin' => 'Perempuan',
                'nm_jenis_kelamin' => 'Perempuan'
            ]
        ];
        $data['jenis_jabatan'] = [
            'Struktural' => [
                'id_jenis_jabatan' => 'Struktural',
                'nm_jenis_jabatan' => 'Struktural'
            ],
            'JFT' => [
                'id_jenis_jabatan' => 'JFT',
                'nm_jenis_jabatan' => 'JFT'
            ],
            'JFU' => [
                'id_jenis_jabatan' => 'JFU',
                'nm_jenis_jabatan' => 'JFU'
            ],
        ];

        render('admin/V_BroadcastWhatsapp', '', '', $data);
	}

	public function searchAllPegawai(){
        $this->session->set_userdata('filter_broadcast', $this->input->post());
		list($data['result'], $data['use_masa_kerja']) = $this->user->searchAllPegawai($this->input->post());
        $this->session->set_userdata('data_search_database', $data);
        $this->load->view('admin/V_BroadcastWhatsappListPegawai', $data);
	}

	public function loadModalBroadcast(){
		$data['selectedNip'] = $this->input->post('list_nip');
        $this->session->set_userdata('selected_nip_broadcast', $data['selectedNip']);
		$data['list_pegawai'] = $this->admin->getListDetailPegawai($data['selectedNip']);
        $data['sisa'] = 0;
        if(count($data['selectedNip']) > 10){
            $data['sisa'] = count($data['selectedNip']) - 10;
        }
        $this->load->view('admin/V_BroadcastWhatsappModal', $data);
	}

    public function submitBroadcast(){
        echo json_encode($this->admin->submitBroadcast());
    }
}
