<?php
class M_Admin extends CI_Model
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

    public function getListDetailPegawai($list, $limit = 'all'){
        $this->db->select('a.*, b.nama_jabatan, c.nm_unitkerja, d.nm_pangkat')
                        ->from('db_pegawai.pegawai a')
                        ->join('db_pegawai.jabatan b', 'a.jabatan = b.id_jabatanpeg')
                        ->join('db_pegawai.unitkerja c', 'a.skpd = c.id_unitkerja')
                        ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                        ->where_in('a.nipbaru_ws', $list)
                        ->order_by('b.eselon', 'asc')
                        ->order_by('d.id_pangkat', 'desc')
                        ->order_by('a.nama', 'asc');
                        // ->limit(10)
                        // ->get()->result_array();
        if($limit != 'all'){
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }

    public function submitBroadcast(){
        $rs['code'] = 0;
        $rs['message'] = null;

        $this->db->trans_begin();

        $data = $this->input->post();
        $file_name = "";
        $randomString = generateRandomString();

        if($data['jenis_pesan'] != 'text'){
            if($_FILES){
                $allowed_extension = ['pdf'];
                $file_array = explode(".", $_FILES["dokumen_broadcast"]["name"]);
                $file_extension = end($file_array);
    
                if(in_array($file_extension, $allowed_extension)){
    
                    $file_name = $randomString."_".str_replace(' ', '_', $data['nama_file']).".pdf";
                    $config['upload_path'] = "arsipbroadcast";
                    $config['allowed_types'] = '*';
                    $config['file_name'] = ($file_name);
                    $this->load->library('upload', $config);
                    // if(file_exists($config['upload_path'])."/".$file_name){
                    //     move_uploaded_file('overwrited_file', ($config['upload_path']."/".$file_name));
                    //     unlink(($config['upload_path'])."/".$file_name);
                    // }
                    $uploadfile = $this->upload->do_upload('dokumen_broadcast');
                    
                    if($uploadfile){
                        $rs['code'] = 0;
                    } else {
                        $rs['code'] = 1;
                        $rs['message'] = 'Gagal upload file';
                    }
                }
            } else {
                $rs['code'] = 1;
            }
        }

        if($rs['code'] == 0){
            $selectedNip = $this->session->userdata('selected_nip_broadcast');
            $filterBroadcast = json_encode($this->session->userdata('filter_broadcast'));

            $this->db->insert('t_broadcast', [
                                'nama_broadcast' => $data['nama_broadcast'],
                                'random_string' => $randomString,
                                'filter_broadcast' => $filterBroadcast,
                                'created_by' => $this->general_library->getId()
                            ]);
            $id_t_broadcast = $this->db->insert_id();

            $pegawai = $this->db->select('*')
                                ->from('db_pegawai.pegawai')
                                ->where_in('nipbaru_ws', $selectedNip)
                                ->get()->result_array();
            if($pegawai){
                $broadcastData = null;
                foreach($pegawai as $p){
                    $broadcastData[$p['nipbaru_ws']]['id_t_broadcast'] = $id_t_broadcast;
                    $broadcastData[$p['nipbaru_ws']]['type'] = $data['jenis_pesan'];
                    $broadcastData[$p['nipbaru_ws']]['sendTo'] = convertPhoneNumber($p['handphone']);
                    $broadcastData[$p['nipbaru_ws']]['message'] = trim($data['pesan_broadcast']);
                    $broadcastData[$p['nipbaru_ws']]['flag_prioritas'] = 0;
                    if($data['jenis_pesan'] != 'text'){
                        $broadcastData[$p['nipbaru_ws']]['fileurl'] = "arsipbroadcast/".$file_name;
                        $broadcastData[$p['nipbaru_ws']]['filename'] = $file_name;
                    }
                    // dd($broadcastData);
                    $this->db->insert('t_cron_wa', $broadcastData[$p['nipbaru_ws']]);
                }

            }
        }

        if($this->db->trans_status() == FALSE || $rs['code'] != 0){
            $this->db->trans_rollback();
            $rs['message'] = $rs['message'] == "" ? 'Terjadi Kesalahan' : $rs['message'];
        } else {
            $this->db->trans_commit();
        }

        return $rs;
    }

    public function loadBroadcastHistory(){
        return $this->db->select('a.*, c.*,
                            (
                                SELECT COUNT(bb.id)
                                FROM t_cron_wa bb
                                WHERE a.id = bb.id_t_broadcast
                                GROUP BY bb.id_t_broadcast
                            ) as jumlah_pegawai
                        ')
                        ->from('t_broadcast a')
                        ->join('m_user b', 'a.created_by = b.id')
                        ->join('db_pegawai.pegawai c', 'c.nipbaru = b.username')
                        ->where('a.flag_active', 1)
                        ->order_by('created_date', 'desc')
                        ->get()->result_array();
    }

    public function loadDetailBroadcast($id){
        $rs['data'] = $this->db->select('a.*, c.*,
                                        (
                                            SELECT COUNT(bb.id)
                                            FROM t_cron_wa bb
                                            WHERE a.id = bb.id_t_broadcast
                                            GROUP BY bb.id_t_broadcast
                                        ) as jumlah_pegawai
                                        ')
                                ->from('t_broadcast a')
                                ->join('m_user b', 'a.created_by = b.id')
                                ->join('db_pegawai.pegawai c', 'c.nipbaru = b.username')
                                ->where('a.flag_active', 1)
                                ->where('a.id', $id)
                                ->order_by('created_date', 'desc')
                                ->get()->result_array();

        $rs['list'] = $this->db->select('a.*')
                            ->from('t_cron_wa a')
                            ->where('a.id_t_broadcast', $id)
                            ->get()->result_array();
    }
}