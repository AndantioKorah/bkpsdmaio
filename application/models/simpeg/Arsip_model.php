<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Arsip_model extends CI_Model
{

	var $column_order_verifikasi_opd = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang ada di table user
	var $column_search_verifikasi_opd = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang diizin untuk pencarian 
	var $order_verifikasi_opd = array('dokumen_upload.id_dokumen' => 'desc'); // default order 

	var $column_order_verifikasi_bkd = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang ada di table user
	var $column_search_verifikasi_bkd = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang diizin untuk pencarian 
	var $order_verifikasi_bkd = array('dokumen_upload.id_dokumen' => 'desc'); // default order 


	var $column_order_lihat_dokumen_pns = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang ada di table user
	var $column_search_lihat_dokumen_pns = array('dokumen.nama_dokumen', 'dokumen_upload.nip'); //field yang diizin untuk pencarian 
	var $order_lihat_dokumen_pns = array('dokumen_upload.id_dokumen' => 'desc'); // default order 

	function __construct()
	{
		parent::__construct();
	}



	function getDokumen()
	{
		$this->db->where('aktif', 1);
		return $this->db->get('dokumen');
	}

	function isArsip($data)
	{
		$r = FALSE;
		$find    = $data;

		$query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from dokumen ) a
 WHERE a.result = 1 AND a.aktif IS NOT NULL");
		if ($query->num_rows() > 0) {
			$r 		= TRUE;
		}

		return $r;
	}

	function isFormatOK($file)
	{
		$r = FALSE;
		$raw_file  		= str_replace('.pdf', '', $file);
		$format_file 	= explode("_", $raw_file);

		$sql = "SELECT panjang FROM (SELECT *,locate(nama_dokumen,'$file') result from dokumen ) a
 WHERE a.result = 1 AND a.aktif IS NOT NULL";
		$row = $this->db->query($sql)->row();
		if (count($format_file) === intval($row->panjang)) {
			$r = TRUE;
		}

		return $r;
	}

	function _extract_numbers($string)
	{
		preg_match_all('/([\d]+)/', $string, $match);
		return $match[0];
	}


	function isMinorOK($file)
	{
		$raw_file  		= str_replace('.pdf', '', $file);
		$format_file 	= explode("_", $raw_file);
		$arr1			= array('KODE', 'TAHUN');

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

		$query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$file_name') result from dokumen ) a
 WHERE a.result = 1 AND a.aktif IS NOT NULL");

		if ($query->num_rows() > 0) {

			$row 			= $query->row();
			$file_size      = round($file_size / 1024, 2);

			if ($file_size > $row->file_size) {
				$data['pesan']  		= " File Dokumen Jenis " . $row->nama_dokumen . " Hanya diizinkan Maksimal " . round($row->file_size / 1024, 2) . " MB";
				$data['response'] 		= FALSE;
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

	function _getIdDokumen($data)
	{
		$r = NULL;
		$find    = $data['raw_name'];

		$query = $this->db->query("SELECT * FROM (SELECT *,locate(nama_dokumen,'$find') result from dokumen ) a
 WHERE a.result = 1 AND a.aktif IS NOT NULL ");
		if ($query->num_rows() > 0) {
			$row 	= $query->row();
			$r 		= $row->id_dokumen;
		}

		return $r;
	}

	function insertUpload($data)
	{
		$data['id_dokumen']		= $this->_getIdDokumen($data);
		$data['upload_by']      = $this->session->userdata('user');
		$data['last_unor']      = $this->getLastSKPDByIdPegawai();
		$number 				= $this->_extract_numbers($data['raw_name']);

		foreach ($number as $value) {
			if (strlen($value) == 18) {
				$data['nip']    = $value;
			} else {
				$data['minor_dok']    = $value;
			}
		}


		$db_debug 			= $this->db->db_debug;
		$this->db->db_debug = FALSE;

		if (!$this->db->insert('dokumen_upload', $data)) {
			$error = $this->db->error();
			if (!empty($error)) {
				$data['pesan']		= $error;
				$data['response'] 	= FALSE;
			}
		} else {
			$data['pesan']		= "Dokumen Berhasil Tersimpan";
			$data['response']	= TRUE;
		}
		$this->db->db_debug = $db_debug; //restore setting	
		return $data;
	}

	function  updateFile($data)
	{
		$this->db->where('raw_name', $data['raw_name']);
		$this->db->set('flag_update', 1);
		$this->db->set('update_by', $this->session->userdata('user_id'));
		$this->db->set('update_date', 'NOW()', FALSE);
		return $this->db->update('dokumen_upload');
	}

	function getDokumenUpload()
	{
		$namaFilter    = $this->input->post('namaFilter');
		$filter        = $this->input->post('filter');
		$status        = $this->input->post('status');

		switch ($filter) {
			case 1:
				$sql_filter  = " AND a.nip='$namaFilter' ";
				break;
			default;
				$sql_filter  = " AND a.nip='9999' ";
		}

		if (!empty($status)) {
			$sql_status = " AND a.status_dokumen='$status' ";
		} else {
			$sql_status = " ";
		}

		$sql = "select a.*, b.nama, c.nama_dokumen, d.first_name, e.nama_status
from dokumen_upload a
LEFT JOIN asn b on a.nip = b.nip_baru
LEFT JOIN dokumen c on a.id_dokumen = c.id_dokumen
LEFT JOIN user d ON d.id = a.upload_by
LEFT JOIN dokumen_status e ON e.id_status = a.status_dokumen 
WHERE 1=1 $sql_filter $sql_status";


		return $this->db->query($sql);
	}



	function hapusFile()
	{
		$nip       = $this->input->post('nip');
		$file      = $this->input->post('file');

		$sql = "DELETE FROM dokumen_upload WHERE nip='$nip' AND orig_name='$file'  ";
		return $this->db->query($sql);
	}

	function getArsipAll()
	{
		$namaFilter    = $this->input->get('namaFilter');
		$filter        = $this->input->get('filter');
		$status        = $this->input->get('status');

		switch ($filter) {
			case 1:
				$sql_filter  = " AND a.nip='$namaFilter' ";
				break;
			default;
				$sql_filter  = " AND a.nip='9999' ";
		}

		if (!empty($status)) {
			$sql_status = " AND a.status_dokumen='$status' ";
		} else {
			$sql_status = " ";
		}

		$sql = "select a.*, b.nama, c.nama_dokumen, d.username,e.nama_status
from dokumen_upload a
LEFT JOIN simpeg_manado.pegawai b on a.nip = trim(b.nipbaru)
LEFT JOIN dokumen c on a.id_dokumen = c.id_dokumen
LEFT JOIN user d ON d.id = a.upload_by 
LEFT JOIN dokumen_status e ON e.id_status = a.status_dokumen 
WHERE 1=1  $sql_filter  $sql_status";
		return $this->db->query($sql);
	}


	function getRole()
	{
		$user_id  = $this->session->userdata('user_id');

		$this->db->where('user_id', $user_id);
		$roles    = $this->db->get('users_roles')->row();
		return    $roles->role_id;
	}

	function getNipbaru()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT  REPLACE(TRIM(nipbaru),' ','') nipbaru FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$r  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$r    = $row->nipbaru;
		}

		return $r;
	}

	function getStatusDokumenOPD()
	{

		$sql = "SELECT a.* FROM dokumen_status a WHERE a.id_status < 3";
		return    $this->db->query($sql);
	}

	function getLastSKPDByIdPegawai()
	{
		$id_peg  = $this->session->userdata('id_peg');

		$sql = "SELECT skpd FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";

		$query    = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$row    			= $query->row();
			$skpd        		= $row->skpd;
		} else {
			$skpd           = NULL;
		}

		return $skpd;
	}

	function getLastJabatanByIdPegawai()
	{
		$id_peg  = $this->session->userdata('id_peg');

		$sql = "SELECT jabatan FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";

		$query    = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$row    			= $query->row();
			$lastJabatan        = $row->jabatan;
		} else {
			$lastJabatan           = NULL;
		}

		return $lastJabatan;
	}

	/* Mendapatkan Unit OPD atau KECAMATAN%*/

	function getUnorOPDByLastJabatan($id)
	{
		$sql = "SELECT * FROM simpeg_manado.jabatan WHERE id_jabatanpeg='$id' ";
		$query    = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$row    			= $query->row();
			$lastUnor           = $row->id_unitkerja;
		} else {
			$lastUnor           = NULL;
		}

		return $lastUnor;
	}


	function getUnorOPDByChild($id)
	{

		$sql = "SELECT * FROM (SELECT T2.id, T2.nama, T2.id_eselon
FROM (
    SELECT
        @r AS _id,
        (SELECT @r := id_parent FROM unit_organisasi WHERE id = _id) AS id_parent,
        @l := @l + 1 AS lvl
    FROM
        (SELECT @r := '$id', @l := 0) vars,
        unit_organisasi h
    WHERE @r <> 0) T1
JOIN unit_organisasi T2
ON T1._id = T2.id ) a
WHERE a.id_eselon IN(22) OR a.nama LIKE 'KECAMATAN%' ";

		$query    = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$row    			= $query->row();
			$Unor         		= $row->id;
		} else {
			$Unor           = NULL;
		}

		return $Unor;
	}

	function getUnitOrganisasi()
	{
		$nama		  	= $this->input->get('q');

		$sql = "SELECT a.id_unitkerja id,a.nm_unitkerja nama 
		FROM simpeg_manado.unitkerja a
		WHERE a.nm_unitkerja LIKE '%$nama%' ";
		return $this->db->query($sql);
	}

	function getUnitOrganisasiByOPD()
	{

		$lastUnor          = $this->getUnorOPDByLastJabatan($this->getLastJabatanByIdPegawai());


		$sql = "SELECT a.id_unitkerja id,a.nm_unitkerja nama 
		FROM simpeg_manado.unitkerja a";
		return $this->db->query($sql);
	}

	function getAntrianOPD()
	{
		$sql = "SELECT a.*, b.nama, count(a.nip) jumlah, c.nm_unitkerja nama_unor
FROM dokumen_upload a
LEFT JOIN simpeg_manado.pegawai b ON REPLACE(TRIM(b.nipbaru),' ','') = a.nip
LEFT JOIN simpeg_manado.unitkerja c ON c.id_unitkerja = a.last_unor
WHERE a.status_dokumen < 3
GROUP BY a.nip ";
		return $this->db->query($sql);
	}


	function getAntrianOPDLama()
	{
		$sql = "SELECT c.*,e.kode_unor, f.nama nama_unor FROM (SELECT a.*, b.pns_id, b.nama, count(a.nip) jumlah
FROM dokumen_upload a
LEFT JOIN asn b ON b.nip_baru = a.nip
WHERE a.status_dokumen < 3
GROUP BY a.nip) c
LEFT JOIN (SELECT 
        a.pns_id, MAX(a.tmt_jabatan) max_tmt_jabatan
    FROM
        simpeg_minahasa.jabatan_asn a
    GROUP BY a.pns_id) d ON c.pns_id = d.pns_id 
LEFT JOIN jabatan_asn e ON (e.pns_id = c.pns_id AND d.max_tmt_jabatan = e.tmt_jabatan)  
LEFT JOIN unit_organisasi f ON f.id = e.kode_unor  ";
		return $this->db->query($sql);
	}

	private function _get_datatables_query_lihat_dokumen_pns($cariBy, $cariName, $unor)
	{


		$this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, users.first_name,dokumen_status.nama_status ');
		$this->db->from('dokumen_upload');
		$this->db->join('simpeg_manado.pegawai ', 'REPLACE(TRIM(pegawai.nipbaru)," ","") = dokumen_upload.nip', 'left');
		$this->db->join('dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
		$this->db->join('users', 'users.id = dokumen_upload.upload_by', 'left');
		$this->db->join('dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');

		$i = 0;

		foreach ($this->column_search_lihat_dokumen_pns as $item) // loop column 
		{
			if ($_GET['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_GET['search']['value']);
				} else {
					$this->db->or_like($item, $_GET['search']['value']);
				}

				if (count($this->column_search_lihat_dokumen_pns) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_GET['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_lihat_dokumen_pns[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
		} else if (isset($this->order_lihat_dokumen_pns)) {
			$order = $this->order_lihat_dokumen_pns;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}
	}

	function get_datatables_lihat_dokumen_pns($cariBy, $cariName, $unor)
	{
		$this->_get_datatables_query_lihat_dokumen_pns($cariBy, $cariName, $unor);
		if ($_GET['length'] != -1)
			$this->db->limit($_GET['length'], $_GET['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_lihat_dokumen_pns($cariBy, $cariName, $unor)
	{
		$this->_get_datatables_query_lihat_dokumen_pns($cariBy, $cariName, $unor);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_lihat_dokumen_pns($cariBy, $cariName, $unor)
	{
		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}

		$this->db->from("dokumen_upload");
		return $this->db->count_all_results();
	}


	/* verifikasi dokumen OPD */

	private function _get_datatables_query_verifikasi_opd($cariBy, $cariName, $status, $unor)
	{


		$this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, users.first_name,dokumen_status.nama_status ');
		$this->db->from('dokumen_upload');
		$this->db->join('simpeg_manado.pegawai', 'REPLACE(TRIM(pegawai.nipbaru)," ","") = dokumen_upload.nip', 'left');
		$this->db->join('dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
		$this->db->join('users', 'users.id = dokumen_upload.upload_by', 'left');
		$this->db->join('dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');

		$i = 0;

		foreach ($this->column_search_verifikasi_opd as $item) // loop column 
		{
			if ($_GET['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_GET['search']['value']);
				} else {
					$this->db->or_like($item, $_GET['search']['value']);
				}

				if (count($this->column_search_verifikasi_opd) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_GET['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_verifikasi_opd[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
		} else if (isset($this->order_verifikasi_opd)) {
			$order = $this->order_verifikasi_opd;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($status)) {
			$this->db->where('dokumen_upload.status_dokumen', $status);
		} else {
			$this->db->where_in('dokumen_upload.status_dokumen', array(1, 2));
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}
	}

	function get_datatables_verifikasi_opd($cariBy, $cariName, $status, $unor)
	{
		$this->_get_datatables_query_verifikasi_opd($cariBy, $cariName, $status, $unor);
		if ($_GET['length'] != -1)
			$this->db->limit($_GET['length'], $_GET['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_verifikasi_opd($cariBy, $cariName, $status, $unor)
	{
		$this->_get_datatables_query_verifikasi_opd($cariBy, $cariName, $status, $unor);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_verifikasi_opd($cariBy, $cariName, $status, $unor)
	{
		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($status)) {
			$this->db->where('dokumen_upload.status_dokumen', $status);
		} else {
			$this->db->where_in('dokumen_upload.status_dokumen', array(1, 2));
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}

		$this->db->from("dokumen_upload");
		return $this->db->count_all_results();
	}

	function validasiOPD($id)
	{
		$user_id  = $this->session->userdata('user_id');

		$this->db->set('status_dokumen', 2);
		$this->db->set('approve_opdby', $user_id);
		$this->db->set('approve_opddate', 'NOW()', FALSE);
		$this->db->where('raw_name', $id);
		return $this->db->update('dokumen_upload');
	}

	function approveOPD($id)
	{
		$user_id  = $this->session->userdata('user_id');

		$this->db->set('status_dokumen', 3);
		$this->db->set('approve_opdby', $user_id);
		$this->db->set('approve_opddate', 'NOW()', FALSE);
		$this->db->where('raw_name', $id);
		return $this->db->update('dokumen_upload');
	}

	function getAntrianBKD()
	{
		$sql = "SELECT a.*, b.nama, count(a.nip) jumlah, c.nama_status, d.nm_unitkerja nama_unor, CONCAT_WS('<br/>',a.nip,b.nama) nama_nip
		FROM dokumen_upload a
		LEFT JOIN simpeg_manado.pegawai b ON REPLACE(TRIM(b.nipbaru),' ','')= a.nip
		LEFT JOIN dokumen_status c ON c.id_status = a.status_dokumen 
		LEFT JOIN simpeg_manado.unitkerja d ON d.id_unitkerja = a.last_unor
		WHERE a.status_dokumen IN(1,2,3,4)
		GROUP BY a.nip, a.status_dokumen";
		return $this->db->query($sql);
	}


	function getStatusDokumenBKD()
	{

		$sql = "SELECT a.* FROM dokumen_status a where a.id_status IN(1,2,3,4,5,6)";
		return    $this->db->query($sql);
	}


	private function _get_datatables_query_verifikasi_bkd($cariBy, $cariName, $status, $unor)
	{


		$this->db->select('dokumen_upload.*,pegawai.nama, dokumen.nama_dokumen, users.name,dokumen_status.nama_status ');
		$this->db->from('dokumen_upload');
		$this->db->join('simpeg_manado.pegawai', 'pegawai.nipbaru = dokumen_upload.nip', 'left');
		$this->db->join('dokumen', 'dokumen.id_dokumen = dokumen_upload.id_dokumen', 'left');
		$this->db->join('users', 'users.id = dokumen_upload.upload_by', 'left');
		$this->db->join('dokumen_status', 'dokumen_status.id_status = dokumen_upload.status_dokumen', 'left');

		$i = 0;

		foreach ($this->column_search_verifikasi_bkd as $item) // loop column 
		{
			if ($_GET['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_GET['search']['value']);
				} else {
					$this->db->or_like($item, $_GET['search']['value']);
				}

				if (count($this->column_search_verifikasi_bkd) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_GET['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_verifikasi_bkd[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
		} else if (isset($this->order_verifikasi_bkd)) {
			$order = $this->order_verifikasi_bkd;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($status)) {
			$this->db->where('dokumen_upload.status_dokumen', $status);
		} else {
			$this->db->where_in('dokumen_upload.status_dokumen', array(1, 2, 3, 4, 5, 6));
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}
	}

	function get_datatables_verifikasi_bkd($cariBy, $cariName, $status, $unor)
	{
		$this->_get_datatables_query_verifikasi_bkd($cariBy, $cariName, $status, $unor);
		if ($_GET['length'] != -1)
			$this->db->limit($_GET['length'], $_GET['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_verifikasi_bkd($cariBy, $cariName, $status, $unor)
	{
		$this->_get_datatables_query_verifikasi_bkd($cariBy, $cariName, $status, $unor);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_verifikasi_bkd($cariBy, $cariName, $status, $unor)
	{
		if ($cariBy == 1) {
			$this->db->where('dokumen_upload.nip', $cariName);
		}

		if (!empty($status)) {
			$this->db->where('dokumen_upload.status_dokumen', $status);
		}

		if (!empty($unor)) {
			$this->db->where('dokumen_upload.last_unor', $unor);
		}

		$this->db->from("dokumen_upload");
		return $this->db->count_all_results();
	}


	function validasiBKD($id)
	{
		$user_id  = $this->session->userdata('user_id');

		$this->db->set('status_dokumen', 4);
		$this->db->set('approve_bkdby', $user_id);
		$this->db->set('approve_bkddate', 'NOW()', FALSE);
		$this->db->where('raw_name', $id);
		return $this->db->update('dokumen_upload');
	}

	function approveBKD($id)
	{
		$user_id  = $this->session->userdata('user_id');

		$this->db->set('status_dokumen', 5);
		$this->db->set('approve_bkdby', $user_id);
		$this->db->set('approve_bkddate', 'NOW()', FALSE);
		$this->db->where('raw_name', $id);
		return $this->db->update('dokumen_upload');
	}
}
