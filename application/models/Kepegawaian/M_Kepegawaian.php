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
            return $this->db->select('d.nm_tktpendidikanb, c.jurusan, c.fakultas, c.namasekolah, c.tahunlulus, c.noijasah, c.tglijasah, c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegpendidikan c', 'b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.tktpendidikanb d','c.tktpendidikan = d.id_tktpendidikanb')
                            ->where('a.id', $this->general_library->getId())
                            ->order_by('c.tglijasah','desc')
                            ->get()->result_array();
        }

        function getJabatan(){
            return $this->db->select('c.nm_jabatan, c.tmtjabatan, c.skpd, c.nosk, c.tglsk, c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegjabatan c','b.id_peg = c.id_pegawai')
                            ->join('db_pegawai.jabatan d','c.id_jabatan = d.id_jabatanpeg')
                            ->where('a.id', $this->general_library->getId())
                            ->order_by('c.tmtjabatan','desc')
                            ->get()->result_array();
        }

        function getDiklat(){
            return $this->db->select('c.nm_diklat, c.penyelenggara, c.jam , c.tglmulai, c.tglselesai, c.nosttpp, c.tglsttpp, c.gambarsk')
                            ->from('m_user a')
                            ->join('db_pegawai.pegawai b','a.username = b.nipbaru_ws')
                            ->join('db_pegawai.pegdiklat c','b.id_peg = c.id_pegawai')
                            ->where('a.id', $this->general_library->getId())
                            ->order_by('c.tglselesai','desc')
                            ->get()->result_array();
        }

        function isArsip($data, $id_dok)
	{
	    $r = FALSE;
		$find    = $data;
		
	    $query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from db_siladen.dokumen ) a
            WHERE a.result = 1 and a.id_dokumen = $id_dok AND a.aktif IS NOT NULL"); 
            
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

    function isAllowSize($file, $id_dok)
    {
        $file_name  = $file['name'];
        $file_size  = $file['size'];

        $query = $this->db->query("SELECT * FROM  db_siladen.dokumen  a
        WHERE a.id_dokumen = $id_dok  AND a.aktif IS NOT NULL");
        // dd($query->num_rows());

        if ($query->num_rows() > 0) {

            $row             = $query->row();
            $file_size      = round($file_size / 1024, 2);
            if ($file_size > $row->file_size) {
                $data['pesan']          = " File Dokumen Hanya diizinkan Maksimal " . round($row->file_size / 1024, 2) . " MB";
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
            $query = $this->db->select('b.id_peg')
            ->from('m_user a')
            ->join('db_pegawai.pegawai b', 'a.username = b.nipbaru_ws')
            ->where('a.id', $this->general_library->getId())
            ->get()->row_array();
            $id_peg =  $query['id_peg'];
        $id_dok  = $this->input->post('id_dokumen');
        // dd($id_dok);
        if($id_dok == 4){
             //PANGKAT   
        $tgl_sk = date("Y-m-d", strtotime($this->input->post('tanggal_sk')));
        $tmt_pangkat = date("Y-m-d", strtotime($this->input->post('tmt_pangkat')));
        $dataInsert['id_pegawai']     = $id_peg;
        $dataInsert['jenispengangkatan']      = $this->input->post('jenis_pengangkatan');
        $dataInsert['pangkat']      = $this->input->post('pangkat');
        $dataInsert['masakerjapangkat']     =$this->input->post('masa_kerja');
        $dataInsert['pejabat']      = $this->input->post('pejabat');
        $dataInsert['nosk']      = $this->input->post('no_sk');
        $dataInsert['tglsk']      = $tgl_sk;
        $dataInsert['gambarsk']      = $data['nama_file'];
        $dataInsert['tmtpangkat']      = $tmt_pangkat;
        $result = $this->db->insert('db_pegawai.pegpangkat', $dataInsert);
          // PANGKAT
        } else if($id_dok == 7){
            $tgl_sk = date("Y-m-d", strtotime($this->input->post('gb_tanggal_sk')));
            $tmt_gaji_berkala = date("Y-m-d", strtotime($this->input->post('tmt_gaji_berkala')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['pangkat']      = $this->input->post('gb_pangkat');
            $dataInsert['masakerja']     =$this->input->post('gb_masa_kerja');
            $dataInsert['pejabat']      = $this->input->post('gb_pejabat');
            $dataInsert['nosk']      = $this->input->post('gb_no_sk');
            $dataInsert['tglsk']      = $tgl_sk;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $dataInsert['tmtgajiberkala']      = $tmt_gaji_berkala;
            $result = $this->db->insert('db_pegawai.peggajiberkala', $dataInsert);
        } else if($id_dok == 6){
            $tgl_ijazah = date("Y-m-d", strtotime($this->input->post('pendidikan_tanggal_ijazah')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['tktpendidikan']      = $this->input->post('pendidikan_tingkat');
            $dataInsert['jurusan']      = $this->input->post('pendidikan_jurusan');
            $dataInsert['fakultas']     =$this->input->post('pendidikan_fakultas');
            $dataInsert['namasekolah']      = $this->input->post('pendidikan_nama_sekolah_universitas');
            $dataInsert['pimpinansekolah']      = $this->input->post('pendidikan_nama_pimpinan');
            $dataInsert['tahunlulus']      = $this->input->post('pendidikan_tahun_lulus');
            $dataInsert['noijasah']      = $this->input->post('pendidikan_tahun_lulus');
            $dataInsert['tglijasah']      = $tgl_ijazah;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $result = $this->db->insert('db_pegawai.pegpendidikan', $dataInsert);
        } else if($id_dok == 8){

            $str = $this->input->post('jabatan_nama');
            $newStr = explode(",", $str);
            $id_jabatan = $newStr[0];
            $nama_jabatan = $newStr[1];
            
            $tgl_sk = date("Y-m-d", strtotime($this->input->post('jabatan_tanggal_sk')));
            $tmt_jabatan = date("Y-m-d", strtotime($this->input->post('jabatan_tmt')));
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['nm_jabatan']      = $nama_jabatan;
            $dataInsert['id_jabatan']      = $id_jabatan;
            $dataInsert['tmtjabatan']     =$tmt_jabatan;
            $dataInsert['jenisjabatan']      = $this->input->post('jabatan_jenis');
            $dataInsert['pejabat']      = $this->input->post('jabatan_pejabat');
            $dataInsert['eselon']      = $this->input->post('jabatan_eselon');
            $dataInsert['nosk']      = $this->input->post('jabatan_no_sk');
            $dataInsert['tglsk']      = $tgl_sk;
            $dataInsert['skpd']      = $this->general_library->getNamaSKPDUser();
            $dataInsert['alamatskpd']      = "";
            $dataInsert['gambarsk']      = $data['nama_file'];
            $result = $this->db->insert('db_pegawai.pegjabatan', $dataInsert);
        } else if($id_dok == 20){            
            $tgl_sttpp = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_sttpp')));
            $tgl_mulai = date("Y-m-d", strtotime($this->input->post('diklat_tangal_mulai')));
            $tgl_selesai = date("Y-m-d", strtotime($this->input->post('diklat_tanggal_selesai')));
           
            $dataInsert['id_pegawai']     = $id_peg;
            $dataInsert['jenisdiklat']      = $this->input->post('diklat_jenis');
            $dataInsert['nm_diklat']      = $this->input->post('diklat_nama');
            $dataInsert['tptdiklat']     = $this->input->post('diklat_tempat');
            $dataInsert['penyelenggara']      = $this->input->post('diklat_penyelenggara');
            $dataInsert['angkatan']      = $this->input->post('diklat_angkatan');
            $dataInsert['jam']      = $this->input->post('diklat_jam');
            $dataInsert['tglmulai']      = $tgl_mulai;
            $dataInsert['tglselesai']      = $tgl_selesai;
            $dataInsert['nosttpp']      =$this->input->post('diklat_no_sttpp');
            $dataInsert['tglsttpp']      = $tgl_sttpp;
            $dataInsert['gambarsk']      = $data['nama_file'];
            $result = $this->db->insert('db_pegawai.pegdiklat', $dataInsert);
        }
      

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

    public function getOne($tableName, $fieldName, $fieldValue)
    {
        $this->db->select('*')
        ->from($tableName)
        ->where($fieldName, $fieldValue);
        return $this->db->get()->row_array();
    }

    public function doUpload()
	{

        $this->db->trans_begin();
        if($_FILES){         
        $id_dok = $this->input->post('id_dokumen');
        $nama_file =  $this->prosesName($id_dok);
       
		// cek file size apa diperbolehkan		
		$cekFile	= $this->isAllowSize($_FILES['file'], $id_dok);
		$response   = $cekFile['response'];
		if (!$response) {
                $res = array('msg' => $cekFile['pesan'], 'success' => false);
                return $res;
		}

		$target_dir						= './uploads/' . $this->general_library->getUserName();
		$config['upload_path']          = $target_dir;
		$config['allowed_types']        = 'pdf';
		$config['encrypt_name']			= FALSE;
		$config['overwrite']			= TRUE;
		$config['detect_mime']			= TRUE;
        $config['file_name']            = "$nama_file.pdf";

		$this->load->library('upload', $config);

		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777);
		}

		// coba upload file		
		if (!$this->upload->do_upload('file')) {

			$data['error']    = strip_tags($this->upload->display_errors());
			$data['token']    = $this->security->get_csrf_hash();
            $res = array('msg' => 'Data gagal disimpan', 'success' => false);
            return $res;
			// $this->output
			// 	->set_status_header(406)
			// 	->set_content_type('application/json', 'utf-8')
			// 	->set_output(json_encode($data));
		} else {
			$dataFile 			= $this->upload->data();
            $dataFile['nama_file'] =  "$nama_file.pdf";
			$result		        = $this->insertUpload($dataFile);
            $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
            return $res;
		}
    } else {
        $dataPost = $this->input->post();
        if($this->input->post('jenis_organisasi')){
            $result = $this->insert('db_pegawai.pegorganisasi',$dataPost);
        } else if($this->input->post('nm_pegpenghargaan')){
            $result = $this->insert('db_pegawai.pegpenghargaan',$dataPost);
        }
        $res = array('msg' => 'Data berhasil disimpan', 'success' => true);
      
    }

    if($this->db->trans_status() == FALSE){
        $this->db->trans_rollback();
        $rs['code'] = 1;
        $rs['message'] = 'Terjadi Kesalahan';
    } else {
        $this->db->trans_commit();
    }

    return $res;
        

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

    function prosesName($id_dok)
    {
       
        $query = $this->db->select('*')
        ->from('db_siladen.dokumen a')
        ->where('a.id_dokumen', $id_dok)
        ->get()->row_array();

        $name = null;
        if($query){
            $format = $query['format'];
            $nip = $this->general_library->getUserName();
        if($id_dok == 4){
            $pangkat = $this->input->post('pangkat');
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("KODE",$pangkat,$name);
        } else if($id_dok == 7){
            $date = $this->input->post('tmt_gaji_berkala');
            $tahun = explode('-', $date);
            $tahun = $tahun[2];
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$tahun,$name);
        } else if($id_dok == 6){
            $tkt_pendidikan = $this->input->post('pendidikan_tingkat');
            if($tkt_pendidikan == "0000"){
                $kode = "05";
            } else if($tkt_pendidikan == "1000"){
                $kode = "10";
            } else if($tkt_pendidikan == "2000"){
                $kode = "15";
            } else if($tkt_pendidikan == "3000"){
                $kode = "20";
            } else if($tkt_pendidikan == "4000"){
                $kode = "25";
            } else if($tkt_pendidikan == "5000"){
                $kode = "30";
            } else if($tkt_pendidikan == "6000"){
                $kode = "35";
            } else if($tkt_pendidikan == "7000"){
                $kode = "40";
            } else if($tkt_pendidikan == "8000"){
                $kode = "45";
            } else if($tkt_pendidikan == "9000"){
                $kode = "50";
            }
            
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("KODE",$kode,$name);
        } else if($id_dok == 8){
            $date = $this->input->post('jabatan_tmt');
            $tahun = explode('-', $date);
            $tahun = $tahun[2];
            $name = str_replace("NIP",$nip,$format);
            $name = str_replace("TAHUN",$tahun,$name);
        } else if($id_dok == 20){
            $name = str_replace("NIP",$nip,$format);
        }  

        

       }
    return $name;
    }

}
