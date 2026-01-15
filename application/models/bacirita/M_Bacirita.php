<?php
class M_Bacirita extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('general/M_General', 'general');
		$this->load->model('kinerja/M_Kinerja', 'kinerja');
        $this->load->model('simata/M_Simata', 'simata');
        // $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function loadListKegiatan(){
        return $this->db->select('a.*, c.nama_tipe_kegiatan')
                    ->from('db_bacirita.t_kegiatan a')
                    ->join('m_user b', 'a.created_by = b.id')
                    ->join('db_bacirita.m_tipe_kegiatan c', 'a.id_m_tipe_kegiatan = c.id')
                    ->order_by('a.created_date', 'desc')
                    ->where('a.flag_active', 1)
                    ->get()->result_array();
    }

    public function saveDataKegiatan($data){
        $res = [
            'code' => 0,
            'message' => null
        ];

        $data['topik'] = trim($data['topik']);
        $data['link_url'] = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $data['topik']);
        $data['link_url'] = strtolower(str_replace(" ", "-", $data['link_url']));

        if(!$data['jam_mulai']){
            $res['message'] = "Jam Mulai belum diinput";
        }

        if(!isset($data['chck_selesai']) && !$data['jam_selesai']){
            $res['message'] = "Jam Selesai belum diinput";
        }

        if(isset($data['chck_selesai']) && $data['chck_selesai'] == "on"){
            unset($data['chck_selesai']);
            $data['jam_selesai'] = 0;
        }

        if(!$data['jam_batas_absensi']){
            $res['message'] = "Jam Batas Absensi belum diinput";
        }

        if(!$data['jam_batas_pendaftaran']){
            $res['message'] = "Jam Batas Pendaftaran belum diinput";
        }

        $data['id_m_tipe_kegiatan'] = $data['tipe_kegiatan'];
        unset($data['tipe_kegiatan']);
        $data['created_by'] = $this->general_library->getId();
        
        $target_dir = 'arsipbkpsdmbacirita/banner_kegiatan/';
        
        // dd($this->input->post());
        // dd($_FILES['file']['name']);

        $nama_file =  $_FILES['file']['name'];

        if($_FILES['file']['name'] != ""){
            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = '*';
            $config['encrypt_name']			= FALSE;
            $config['overwrite']			= TRUE;
            $config['detect_mime']			= TRUE; 
            $config['file_name']            = $nama_file;

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('file')) {
                $data['error']    = strip_tags($this->upload->display_errors());
                $res['code'] = 1;
                $res['message'] = "Terjadi Kesalahan";
                return $res;

            } else {
                $dataFile 			= $this->upload->data();
                $data['url_banner'] = $target_dir.$nama_file;

            }
            $this->insert('db_bacirita.t_kegiatan', $data);
        } else {
            $this->insert('db_bacirita.t_kegiatan', $data);

        }

        
        
        return $res;
    }

}