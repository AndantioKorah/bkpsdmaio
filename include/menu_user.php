<? include ('session.php'); ?>
<?php include ('koneksi.inc.php'); ?>
<?php
$sesi=$_SESSION['SES_USER'];
$sqluser = "SELECT * FROM user WHERE userID = '$sesi'";
$qryuser = mysql_query($sqluser, $koneksi) or die ("Gagal query user".mysql_error());
$datauser = mysql_fetch_array($qryuser);
 $status=$datauser['status'];
  $eselonuser=$datauser['eselonuser'];	
 ?>

<link href="../CSS/contoh.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style5 {font-size: 14px}
-->
</style>
<link href="../../CSS/contoh.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style7 {font-size: 16px}
-->
</style>
<link href="../CSS/user.css" rel="stylesheet" type="text/css" />
<div id="masterdiv"> 
 

  
	<?
	if($status=='admin')
	{
    echo "
	 <div class=style7 onclick=SwitchMenu('sub2')><img src=images/datapegawai.jpg width=171 height=37 class=style5 /></div>
	<div align=left><span class=submenu id=sub2> <span class=style5>
	 - <a href=?page=tambahDataPegawai class=normalTxt4>Tambah Data </a><br>
    - <a href=?page=ubahDataPegawai class=normalTxt4>Ubah Data </a><br>
    - <a href=?page=cariDataPegawai class=normalTxt4>Cari Data Pegawai </a><br>
	- <a href=?page=hapusDataPegawai class=normalTxt4>Hapus Data Pegawai</a></span></span></div>";  
	}
	  ?>
   
	
    <div class="style5" onclick="SwitchMenu('sub3')"><img src="images/skpd.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub3"> <span class="style5">
  - <a href="?page=pemkot" class="normalTxt4">Walikota &amp; Wakil</a><br>
    - <a href="?page=stafahli" class="normalTxt4">Staf Ahli Walikota  </a><br>
  - <a href="?page=sekda" class="normalTxt4">Sekretariat Daerah  </a><br>
    - <a href="?page=dinas" class="normalTxt4">Dinas</a><br>
    - <a href="?page=lembagateknis" class="normalTxt4">Lembaga Teknis</a><br>
    - <a href="?page=kecamatan" class="normalTxt4">Kecamatan/Kelurahan</a><br>
    - <a href="?page=puskesmas" class="normalTxt4">Puskesmas</a><br>
     - <a href="?page=upt" class="normalTxt4">UPT </a><br>
	 - <a href="?page=sekolah" class="normalTxt4">Sekolah </a><br>
    - <a href="?page=lainlain" class="normalTxt4">Lain - Lain</a></span></span></div>
	
<div class="style5" onclick="SwitchMenu('sub4')"><img src="images/caridata.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub4"> <span class="style5">
	 - <a href="?page=cariDataPegawai" class="normalTxt4">Cari Pegawai</a><br>
	- <a href="?page=skpdCari" class="normalTxt4">Cari Unit Kerja / Sekolah </a><br>
    - <a href="?page=jabatanCari" class="normalTxt4">Cari Jabatan </a></span></span></div>
	
	     <div class="style5" onclick="SwitchMenu('sub5')"><img src="images/mutasi.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub5"> <span class="style5">
  - <a href="?page=mutasiCari" class="normalTxt4">Cari Pegawai </a> <br>
  - <a href="?page=pensiun" class="normalTxt4">Pensiun</a> <br>
  - <a href="?page=pindah" class="normalTxt4">Pindah Kab/Kota Lain</a> <br>
  - <a href="?page=pegmeninggal" class="normalTxt4">Meninggal Dunia </a> <br>
  - <a href="?page=pegberhenti" class="normalTxt4">Diberhentikan</a> <br></span></span></div>
	<?
	if($eselonuser<>'non')
	{
	echo"
    <div class=style5 onclick=SwitchMenu('sub6')><img src=images/surat.jpg width=171 height=37 class=style5 /></div>
<div align=left><span class=submenu id=sub6> <span class=style5>
  - <a href=?page=suratMasuk class=normalTxt4>Surat Masuk </a> <br>
    - <a href=?page=suratKeluar class=normalTxt4>Surat Keluar </a></span></span></div>";
	}
	?>
	
	 <div class="style5" onclick="SwitchMenu('sub7')"><img src="images/laporan.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub7"> <span class="style5">
  - <a href="?page=laporanPriode" class="normalTxt4">Per Priode </a> <br>
    - <a href="?page=laporanKatagori" class="normalTxt4">Per Kategori </a></span></span></div>
    
   <div class="style5" onclick="SwitchMenu('sub8')"><img src="images/peraturan.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub8"> <span class="style5">
  - <a href="?page=uu" class="normalTxt4">Undang-Undang </a> <br>
   - <a href="?page=pp" class="normalTxt4">Peraturan Pemerintah </a> <br>
    - <a href="?page=kepres" class="normalTxt4">Keputusan Presiden </a> <br>
    - <a href="?page=permen" class="normalTxt4">Peraturan Menteri </a> <br>
     - <a href="?page=perka" class="normalTxt4">Perka BKN </a> <br>
       - <a href="?page=perda" class="normalTxt4">Peraturan Daerah </a> <br>
         - <a href="?page=perwako" class="normalTxt4">Perwako </a> <br>
    - <a href="?page=pplain" class="normalTxt4">Peraturan Lainnya </a></span></span></div>
	

  <div class="style5" onclick="SwitchMenu('sub9')"><img src="images/batuan.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub9"><span class="style5">
  - <a href="?page=caraMenggunakan" class="normalTxt4">Cara Menggunakan</a><br>
   - <a href="?page=caraKoneksi" class="normalTxt4">Cara Install Aplikasi </a></span></span></div>
   
     <div class="style5" onclick="SwitchMenu('sub10')"><img src="images/pengaturan.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub10"> <span class="style5">
  - <a href="?page=#" class="normalTxt4">Not Definied Yet </a> <br>
    - <a href="?page=#" class="normalTxt4">Not Definied Yet </a></span></span></div>
	
   
    <div class="style5" onclick="SwitchMenu('sub11')"><img src="images/datauser.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub11"><span class="style5">
  - <a href="?page=userLihat" class="normalTxt4">Lihat Data User</a><br>
- <a href="?page=userEdit" class="normalTxt4">Ubah Data User </a></span></span></div>
  
  
 <div class="style5" onclick="SwitchMenu('sub12')"><img src="images/logout.jpg" width="171" height="37" class="style5" /></div>
<div align="left"><span class="submenu" id="sub12"><span class="style5">
- <a href="logout.php" class="normalTxt4">Logout </a></span></span></div>
  
