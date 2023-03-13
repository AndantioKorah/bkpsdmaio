<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Simpeg_model extends CI_Model
{


	function __construct()
	{
		parent::__construct();
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



	function getIDPasPhoto()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT pasphoto FROM users WHERE id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->pasphoto;
		}
		return $s;
	}

	function getNama()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.pegawai WHERE id_peg='$id_peg'";
		return $this->db->query($sql);
	}


	function getNamaAdminIdCard($id)
	{
		$id_peg  = $this->simpeg->getIdPegawai($id);
		$sql = "SELECT *
		FROM simpeg_manado.pegawai a, simpeg_manado.jabatan b, simpeg_manado.unitkerja c
		WHERE a.skpd = c.id_unitkerja AND a.jabatan = b.id_jabatanpeg AND a.id_peg='$id_peg'";
		return $this->db->query($sql);
	}

	function getIdPegawai($id)
	{
		$sql = "SELECT users.id_peg FROM users,usul_idcard WHERE users.id = usul_idcard.usul_by AND usul_idcard.id_usul='$id' ";
		$query      = $this->db->query($sql);

		$s  = NULL;
		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->id_peg;
		}
		return $s;
	}

	function getIDPasPhotoAdminIdCard($id)
	{
		$id_peg  = $this->simpeg->getIdPegawai($id);
		$sql = "SELECT pasphoto FROM users WHERE id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->pasphoto;
		}
		return $s;
	}

	function getNipbaruAdminIdCard($id)
	{

		$id_peg  = $this->simpeg->getIdPegawai($id);
		$sql = "SELECT  REPLACE(TRIM(nipbaru),' ','') nipbaru FROM simpeg_manado.pegawai WHERE id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$r  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$r    = $row->nipbaru;
		}
		return $r;
	}

	function getPangkat()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT nm_pangkat FROM simpeg_manado.pegawai,simpeg_manado.pangkat WHERE pangkat=id_pangkat AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->nm_pangkat;
		}
		return $s;
	}

	function getNamaPerangkatDaerah()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT nm_unitkerja FROM simpeg_manado.pegawai,simpeg_manado.unitkerja WHERE skpd=id_unitkerja AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->nm_unitkerja;
		}
		return $s;
	}

	function getJabatan()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT nama_jabatan FROM simpeg_manado.pegawai,simpeg_manado.jabatan WHERE jabatan=id_jabatanpeg AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->nama_jabatan;
		}
		return $s;
	}

	function getAgama()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT nm_agama FROM simpeg_manado.pegawai,simpeg_manado.agama WHERE agama=id_agama AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->nm_agama;
		}
		return $s;
	}

	function getPendidikan()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT nm_tktpendidikan FROM simpeg_manado.pegawai,simpeg_manado.tktpendidikan WHERE pendidikan=id_tktpendidikan AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->nm_tktpendidikan;
		}
		return $s;
	}

	function getIdPerangkatDaerah()
	{

		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT id_unitkerja FROM simpeg_manado.pegawai,simpeg_manado.unitkerja WHERE skpd=id_unitkerja AND id_peg='$id_peg' ";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->id_unitkerja;
		}
		return $s;
	}

	function updateUsul()
	{
		$id_peg  = $this->session->userdata('id_peg');

		$data['pasphoto']     = $fileupload['file_name'];


		$this->db->where('id_peg', $id_peg);
		return $this->db->update('users', $data);
	}

	function updateUsulWithFile($fileupload)
	{
		$id_peg  = $this->session->userdata('id_peg');

		$data['pasphoto']     = $fileupload['file_name'];


		$this->db->where('id_peg', $id_peg);
		return $this->db->update('users', $data);
	}

	function tambahUsulIDCard()
	{
		$idunor  = $this->simpeg->getIdPerangkatDaerah();
		$data['unit_organisasi']	= $idunor;
		$data['usul_by']			= $this->session->userdata('user_id');


		return $this->db->insert('usul_idcard', $data);
	}

	function getDokumen()
	{

		$user_id  			= $this->session->userdata('user_id');
		$this->db->where('usul_by', $user_id);
		$this->db->order_by('created_date', 'DESC');
		return $this->db->get('usul_idcard');
	}

	function getDokumenBKPSDM()
	{
		$sql = "SELECT usul_idcard.created_date,users.name, a.nm_unitkerja, usul_idcard.usul_status, usul_idcard.id_usul
		FROM usul_idcard,users,simpeg_manado.unitkerja a
		WHERE usul_idcard.usul_by = users.id AND a.id_unitkerja = usul_idcard.unit_organisasi AND usul_idcard.usul_status = 'DIKIRIM'";
		return $this->db->query($sql);
	}

	function getDokumenBKPSDMSelesai()
	{
		$sql = "SELECT usul_idcard.created_date,users.name, a.nm_unitkerja, usul_idcard.usul_status, usul_idcard.id_usul, usul_idcard.keterangan, users.first_name
		FROM usul_idcard,users,simpeg_manado.unitkerja a
		WHERE usul_idcard.usul_by = users.id AND a.id_unitkerja = usul_idcard.unit_organisasi AND usul_idcard.usul_status <> 'DIKIRIM'";
		return $this->db->query($sql);
	}

	function delete($id)
	{
		$user_id  = $this->session->userdata('user_id');
		$this->db->where('id_usul', $id);
		$this->db->where('usul_by', $user_id);
		$this->db->where('usul_status', 'DIKIRIM');
		return $this->db->delete('usul_idcard');
	}

	function cekSudahUsul()
	{

		$user_id  			= $this->session->userdata('user_id');
		$sql = "SELECT id_usul FROM usul_idcard WHERE usul_status = 'DIKIRIM' AND usul_by ='$user_id'";
		$query      = $this->db->query($sql);

		$s  = NULL;

		if ($query->num_rows() > 0) {
			$row  = $query->row();
			$s    = $row->id_usul;
		}
		return $s;
	}


	function updateUsulIdCard($id)
	{
		$data['keterangan']		= $this->input->post('keterangan');
		$data['usul_status']		= $this->input->post('status');
		$data['revisi_by']			= $this->session->userdata('user_id');

		$this->db->where('id_usul', $id);
		return $this->db->update('usul_idcard', $data);
	}

	function getRPangkat()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.pegpangkat a, simpeg_manado.pangkat b
		WHERE a.pangkat = b.id_pangkat AND a.id_pegawai = '$id_peg' ORDER BY id_pangkat, tmtpangkat";
		return $this->db->query($sql);
	}

	function getRBerkala()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.peggajiberkala a, simpeg_manado.pangkat b
		WHERE a.pangkat = b.id_pangkat AND a.id_pegawai = '$id_peg' ORDER BY id_pangkat, tmtgajiberkala";
		return $this->db->query($sql);
	}

	function getRPendidikan()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.pegpendidikan a, simpeg_manado.tktpendidikanb b
		WHERE a.tktpendidikan = b.id_tktpendidikanb AND a.id_pegawai = '$id_peg'";
		return $this->db->query($sql);
	}

	function getRJabatan()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.pegjabatan
		WHERE  id_pegawai = '$id_peg' ORDER BY tmtjabatan";
		return $this->db->query($sql);
	}

	function getRDiklat()
	{
		$id_peg  = $this->session->userdata('id_peg');
		$sql = "SELECT *
		FROM simpeg_manado.pegdiklat
		WHERE id_pegawai = '$id_peg' ORDER BY tglmulai";
		return $this->db->query($sql);
	}
}
