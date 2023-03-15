<?php
class M_Kepegawaian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->db = $this->load->database('main', true);
    }

    public function insert($tablename, $data)
    {
        $this->db->insert($tablename, $data);
    }

    public function get_datatables_lihat_dokumen_pns($cariBy,$cariName,$unor)
        {
            
            // $idunor  = $this->arsip->getIdPerangkatDaerah();
            $idunor  = $this->general_library->getUnitKerjaPegawai();
       
            $this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, m_user.nama,dokumen_status.nama_status ');
            // $this->db->from('dokumen_upload');
            $this->db->join('db_pegawai.pegawai ', 'REPLACE(TRIM(pegawai.nipbaru)," ","") = dokumen_upload.nip', 'left');
            $this->db->join('db_siladen.dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
            // $this->db->join('db_siladen.users', 'users.id = dokumen_upload.upload_by', 'left');
            $this->db->join('m_user', 'm_user.id = dokumen_upload.upload_by', 'left');
            $this->db->join('db_siladen.dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');	
            $this->db->or_where('dokumen_upload.nip',$cariName);
            if ($idunor <> NULL)
            {
            $this->db->where('pegawai.skpd',$idunor);
            }
            if ($idunor =='4018000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "0000000" AND "9900000"');
            }
            else if ($idunor =='3010000')
            {
            $this->db->where('pegawai.skpd',"3010000");
            $this->db->or_where('pegawai.skpd BETWEEN "7000000" AND "8400000"');
    
            }
            else if ($idunor =='3012000')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "6000000" AND "7900000"');
            }
            else if ($idunor =='1030525')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "1000000" AND "2900000"');
            }
            else if ($idunor =='5001001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5001000" AND "5001100"');
            }	
            else if ($idunor =='5002001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5002000" AND "5002100"');
            }
            else if ($idunor =='5003001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5003000" AND "5003100"');
            }
            else if ($idunor =='5004001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5004000" AND "5004100"');
            }
            else if ($idunor =='5005001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005009" AND "5005013"');
            }
            else if ($idunor =='5006001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5006000" AND "5006100"');
            }
            else if ($idunor =='5007001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5007000" AND "5007100"');
            }
            else if ($idunor =='5008001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5008000" AND "5008100"');
            }
            else if ($idunor =='5009001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5009000" AND "5009100"');
            }
            else if ($idunor =='5010001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5005002" AND "5005008"');
            }	
            else if ($idunor =='5011001')
            {
            $this->db->or_where('pegawai.skpd BETWEEN "5011001" AND "5011101"');
            }
    
            $i = 0;		
        
            // foreach ($this->column_search_lihat_dokumen_pns as $item) // loop column 
            // {
            //     if($_GET['search']['value']) // if datatable send POST for search
            //     {				
            //         if($i===0) // first loop
            //         {
            //             $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
            //             $this->db->like($item, $_GET['search']['value']);
            //         }
            //         else
            //         {
            //             $this->db->or_like($item, $_GET['search']['value']);
            //         }
    
            //         if(count($this->column_search_lihat_dokumen_pns) - 1 == $i) //last loop
            //             $this->db->group_end(); //close bracket
            //     }
            //     $i++;
            // }
            
            // if(isset($_GET['order'])) // here order processing
            // {
            //     $this->db->order_by($this->column_order_lihat_dokumen_pns[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
            // } 
            // else if(isset($this->order_lihat_dokumen_pns))
            // {
            //     $order = $this->order_lihat_dokumen_pns;
            //     $this->db->order_by(key($order), $order[key($order)]);
            // }
            
            if($cariBy == 1)
            {
                $this->db->where('dokumen_upload.nip',$cariName);	
            }
            
            if(!empty($unor))
            {
                $this->db->where('dokumen_upload.last_unor',$unor);
            }
            $query = $this->db->get('db_siladen.dokumen_upload');
            return $query->result();
            
        }


        function getDokumen()
        {
            $this->db->where('aktif',1);
            $this->db->ORDER_BY('nama_dokumen');
            return $this->db->get('db_siladen.dokumen');	
        }
        function getProfilPegawai(){
            $username = $this->general_library->getUserName();
            $this->db->select('a.*, b.nm_agama, c.nm_tktpendidikan, d.nm_pangkat, e.nama_jabatan, f.nm_unitkerja')
                ->from('db_pegawai.pegawai a')
                ->join('db_pegawai.agama b', 'a.agama = b.id_agama')
                ->join('db_pegawai.tktpendidikan c', 'a.pendidikan = c.id_tktpendidikan')
                ->join('db_pegawai.pangkat d', 'a.pangkat = d.id_pangkat')
                ->join('db_pegawai.jabatan e', 'a.jabatan = e.id_jabatanpeg')
                ->join('db_pegawai.unitkerja f', 'a.skpd = f.id_unitkerja')
                ->where('a.nipbaru_ws', $username)
                ->limit(1);
            return $this->db->get()->row_array();
        }

        function getPangkatPegawai(){
            return $this->db->select('e.nm_jenispengangkatan, c.masakerjapangkat, d.nm_pangkat, c.tmtpangkat, c.pejabat,
                            c.nosk, c.tglsk, c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpangkat c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.pangkat d','c.pangkat = d.id_pangkat')
                            ->join('db_pegawai.jenispengangkatan e','c.jenispengangkatan = e.id_jenispengangkatan')
                            ->where('a.id', $this->general_library->getId())
                            ->order_by('c.tglsk', 'desc')
                            ->get()->result_array();
        }

        function getPendidikan(){
            return $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpendidikan c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.tktpendidikan d','c.tktpendidikan = d.id_tktpendidikan')
                            ->where('a.id', 193)
                            ->order_by('c.tglijasah','desc')
                            ->get()->result_array();
        }

        function getJabatan(){
            return $this->db->select('*')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
                            ->where('a.id', 193)
                            ->order_by('c.tmtjabatan','desc')
                            ->get()->result_array();
        }

        function isArsip($data)
	{
	    $r = FALSE;
		$find    = $data;
		
	    $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from db_siladen.dokumen ) a
            WHERE a.result = 1 AND a.aktif IS NOT NULL"); 
            
		if($query->num_rows() > 0){
		    $r 		= TRUE;
		}
        return $r;
    }

    function isFormatOK($file)
    {
        $r = FALSE;
        $raw_file          = str_replace('.pdf', '', $file);
        $format_file     = explode("_", $raw_file);

        $sql = "SELECT panjang FROM (SELECT *,locate(nama_dokumen,'$file') result from db_siladen.dokumen ) a
        WHERE a.result = 1 AND a.aktif IS NOT NULL";
        $row = $this->db->query($sql)->row();
        if (count($format_file) === intval($row->panjang)) {
            $r = TRUE;
        }

        return $r;
    }

    function isMinorOK($file)
    {
        $raw_file          = str_replace('.pdf', '', $file);
        $format_file     = explode("_", $raw_file);
        $arr1            = array('KODE', 'TAHUN');

        $r = TRUE;
        if (count($format_file) == 4) {
            $number  = $this->_extract_numbers($format_file[3]);
            if (count($number) > 0) {
                $r = TRUE;
            } else {
                $r = FALSE;
            }
        }


        return $r;
    }

    function isAllowSize($file)
    {
        $file_name  = $file['name'];
        $file_size  = $file['size'];

        $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$file_name') result from db_siladen.dokumen ) a
        WHERE a.result = 1 AND a.aktif IS NOT NULL");

        if ($query->num_rows() > 0) {

            $row             = $query->row();
            $file_size      = round($file_size / 1024, 2);

            if ($file_size > $row->file_size) {
                $data['pesan']          = " File Dokumen Jenis " . $row->nama_dokumen . " Hanya diizinkan Maksimal " . round($row->file_size / 1024, 2) . " MB";
                $data['response']         = FALSE;
            } else {
                $data['pesan']     = " File diizinkan";
                $data['response']  = TRUE;
            }
        } else {
            $data['pesan']     = " File bukan arsip kepegawaian yang disyaratkan";
            $data['response']  = FALSE;
        }

        return $data;
    }

    function insertUpload($data)
    {
        
       	
        $tgl_sk = date("Y-m-d", strtotime($this->input->post('tanggal_sk')));
        $tmt_pangkat = date("Y-m-d", strtotime($this->input->post('tmt_pangkat')));

        $dataInsert['id_pegawai']     = "1";
        $dataInsert['jenispengangkatan']      = $this->input->post('jenis_pengangkatan');
        $dataInsert['pangkat']      = $this->input->post('pangkat');
        $dataInsert['masakerjapangkat']     =$this->input->post('masa_kerja');
        $dataInsert['pejabat']      = $this->input->post('pejabat');
        $dataInsert['nosk']      = $this->input->post('no_sk');
        $dataInsert['tglsk']      = $tgl_sk;
        $dataInsert['gambarsk']      = $data['file_name'];
        $dataInsert['tmtpangkat']      = $tmt_pangkat;

        $result = $this->db->insert('db_pegawai.pegpangkat', $dataInsert);
        return $result;
    }

    function  updateFile($data)
    {
        $this->db->where('raw_name', $data['raw_name']);
        $this->db->set('flag_update', 1);
        $this->db->set('update_by', $this->general_library->getId());
        $this->db->set('update_date', 'NOW()', FALSE);
        return $this->db->update('db_siladen.dokumen_upload');
    }

    function _getIdDokumen($data)
    {
        $r = NULL;
        $find    = $data['raw_name'];


        $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from db_siladen.dokumen) a
         WHERE a.result = 1 AND a.aktif IS NOT NULL ");

        // $query = $this->db->select('*')
        // ->from('db_siladen.dokumen a')
        // ->where('a.aktif is not null')
        // ->like('a.nama_dokumen', $find)
        // ->get()->num_rows();

        if ($query->num_rows() > 0) {
            $row     = $query->row();
            $r         = $row->id_dokumen;
        }

        return $r;
    }

    // function _getIdPeg()
    // {

    //         $username = $this->general_library->getUserName();
    //         $this->db->select('a.id')
    //             ->from('db_siladen.users as a')
    //             ->where('a.username', $username)
    //             ->where('a.active', 1)
    //             ->limit(1);
    //             $query = $this->db->get();
    //             foreach ($query->result() as $row)
    //                 {
    //                         $idPeg = $row->id;

    //                 }
    //             return $idPeg;

    // }


    // function getLastSKPDByIdPegawai()
    // {
    // 	$id_peg  = $this->session->userdata('id_peg');

    // 	$sql="SELECT skpd FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";

    // 	$query    = $this->db->query($sql);

    // 	if($query->num_rows() > 0)
    // 	{
    // 		$row    			= $query->row();
    // 		$skpd        		= $row->skpd;			
    // 	}
    // 	else
    // 	{
    // 		$skpd           = NULL;	
    // 	}		

    // 	return $skpd;
    // }

    function _extract_numbers($string)
    {
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }

    public function getAllWithOrder($tableName, $orderBy = 'created_date', $whatType = 'desc')
    {
        $this->db->select('*')
        // ->where('id !=', 0)
        // ->where('flag_active', 1)
        ->order_by($orderBy, $whatType)
        ->from($tableName);
        return $this->db->get()->result_array(); 
    }

    public function doUpload()
	{

		// dd($_FILES['file']['name']);	
		// validasi NIP
		if (!$this->_isAdaNIP($_FILES['file']['name'])) {
			// $data['error']    = 'Dokumen harus terdapat NIP';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
			// return FALSE;
			$res = array('msg' => 'Dokumen harus terdapat NIP', 'success' => false);
			return $res;
		}

		// validasi NIP apakah terdapat nip saya
		if (!$this->_isAdaNIPSaya($_FILES['file']['name'])) {
			// $data['error']    = 'Dokumen harus  NIP Saya, cek ulang NIP di nama Dokumen';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
			$res = array('msg' => 'Dokumen harus  NIP Saya, cek ulang NIP di nama Dokumen', 'success' => false);
			return $res;
		}
		// dd($_FILES['file']['name']);
		// cek apakah ada dalam daftar arsip

		if (!$this->isArsip($_FILES['file']['name'])) {

			// $data['error']    = 'File ini tidak ada dalam daftar arsip';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
                $res = array('msg' => 'File ini tidak ada dalam daftar arsip', 'success' => false);
                return $res;
		}


		// cek apakah sudah sesuai format
		if (!$this->isFormatOK($_FILES['file']['name'])) {

			// $data['error']    = 'File ini belum sesuai format';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
                $res = array('msg' => 'File ini belum sesuai format', 'success' => false);
                return $res;
		}


		// cek minor tidak ada kode atau tahun
		if (!$this->isMinorOK($_FILES['file']['name'])) {
			// $data['error']    = 'File ini KODE atau TAHUN belum sesuai format';
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
                $res = array('msg' => 'File ini KODE atau TAHUN belum sesuai format', 'success' => false);
                return $res;
		}

		// cek file size apa diperbolehkan		
		$cekFile	= $this->isAllowSize($_FILES['file']);
		$response   = $cekFile['response'];
		if (!$response) {
			// $data['error']    = $cekFile['pesan'];
			// $data['token']    = $this->security->get_csrf_hash();
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
                $res = array('msg' => $cekFile['pesan'], 'success' => false);
                return $res;
		}

		$target_dir						= './uploads/' . $this->_getNip($_FILES['file']['name']);
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		//$config['max_size']             = 2048;
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;

		$this->load->library('upload', $config);

		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777);
		}

		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
			$this->output
				->set_status_header(406)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data));
		} else {
			$dataFile 			= $this->upload->data();
			$result		        = $this->insertUpload($dataFile);
			// $result['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            return $res;

			// if ($result['response']) {
			// 	$this->output
			// 		->set_status_header(200)
			// 		->set_content_type('application/json', 'utf-8')
			// 		->set_output(json_encode($result));
			// } else {
			// 	$result['updated']  = $this->kepegawaian->updateFile($result);
			// 	$result['error'] 	= 'File ini sudah ada, update file';
			// 	$result['token']    = $this->security->get_csrf_hash();
			// 	$this->output
			// 		->set_status_header(200)
			// 		->set_content_type('application/json', 'utf-8')
			// 		->set_output(json_encode($result));
			// }
		}
	}

    function _isAdaNIP($string)
	{
		$number = $this->_extract_numbers($string);
		$cek  = 0;
		foreach ($number as $value) {
			if (strlen($value) == 18) {
				$cek |= TRUE;
			} else {
				$cek |= FALSE;
			}
		}

		return boolval($cek);
	}

    function _isAdaNIPSaya($string)
	{


		$user_id  = $this->general_library->getUserName();

		$number = $this->_extract_numbers($string);
		$cek  = 0;
		foreach ($number as $value) {
			if ($value == $user_id) {
				$cek |= TRUE;
			} else {
				$cek |= FALSE;
			}
		}

		return boolval($cek);
	}

    function _getNip($string)
	{
		$number = $this->_extract_numbers($string);
		$r      = 0;
		foreach ($number as $value) {
			if (strlen($value) == 18) {
				$r  = $value;
			}
		}

		return $r;
	}
}
