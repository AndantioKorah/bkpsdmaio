<html>
<style>
	#body_dpcp{
	font-family: Tahoma !important;
    }

	#bodysurat {
		/* font-family: Arial, Helvetica, sans-serif !important; */
		font-family: Tahoma !important;
		font-size: 17px !important;
		/* line-height: 20px !important; */
	}

	/* td {
		text-align: left;
	}

	th,
	td {
		padding: 1px;
	}

	.left {
		text-align: left;
	}

	.right {
		text-align: right;
	} */

	/* .center {
		text-align: center;
	} */

	.justify {
		text-align: justify;
	}

	/* p {
		font-family: Arial, Helvetica, sans-serif !important;
		font-size: 17px !important;
		line-height: 20px !important;
	} */

	p.judul {
		text-align: center;
	}

	/* span {
		font-family: "Bookman Old Style";
		color: #000;
	} */

	/* table {
		font-family: Tahoma !important;
		font-size: 17px !important;
	} */

	
	.table_footer_sk{
            font-size: .95rem !important;
			/* font-size: 17px !important; */
    }

	.footer-sk{
        /* padding-right: 5rem; */
        position: fixed;
        bottom: 0;
        /* margin-top: 50px; */
        /* padding-bottom: 60px; */
        /* display: none; */
        /* width: 100%; */
		width: 100%;
		margin-top: 90px;
      }
	  .footer-sk-2{
        /* padding-right: 5rem; */
        position: fixed;
        bottom: 80;
        /* margin-top: 50px; */
        /* padding-bottom: 60px; */
        /* display: none; */
        /* width: 100%; */
		width: 100%;
		margin-top: 90px;
      }
</style>
<body id="bodysurat">

	<div class="header" style="margin-top:-40px;margin-right:40px;">
		<?php $this->load->view('adminkit/partials/V_HeaderSKCuti.php');?>
	</div>
    <?php 
			$ns = isset($data['nomor_surat']) ? $data['nomor_surat'] : "";
			if(isset($nomor_surat)){
				$ns = $nomor_surat;
			}
		?>
		<p class="judul" style="margin-top:5px;text-align: center;"><u>SURAT KETERANGAN TIDAK SEDANG TUGAS BELAJAR/IKATAN DINAS</u><br></p>
		<p style="margin-left:195px;">Nomor :  ${nomor_naskah}</p>
	

	<p>Yang nama bertanda-tangan dibawah ini :</p>
	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:25%;">Nama</td>
			<td style="width:5%;text-align: center;">:</td>
			<td style="width:70%;"><?= $kaban['gelar1'];?><?= getNamaPegawaiFull($kaban);?></td>
		</tr>
		<tr>
			<td>NIP</td>
			<td style="text-align: center;">:</td>
			<td><?= $kaban['nipbaru'];?></td>
		</tr>
		<tr>
			<td>Pangkat, Gol/Ruang</td>
			<td style="text-align: center;">:</td>
			<td><?= $kaban['nm_pangkat'];?></td>
		</tr>
		<tr>
			<td valign="top">Jabatan</td>
			<td valign="top" style="text-align: center;">:</td>
			<td><?= $kaban['nama_jabatan'];?></td>
		</tr>
        <tr>
			<td valign="top">Unit Kerja</td>
			<td valign="top" style="text-align: center;">:</td>
			<td><?= $kaban['nm_unitkerja'];?></td>
		</tr>

	</table>


	<span>
		Dengan ini menerangkan bahwa :
	</span>

	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:25%;">Nama</td>
			<td style="width:5%;text-align: center;">:</td>
			<td style="width:70%;">
			<?= getNamaPegawaiFull($profil_pegawai);?>
			</td>
		</tr>
		<tr>
			<td>NIP</td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nipbaru'];?></td>
		</tr>
		<tr>
			<td>Pangkat, Gol/Ruang</td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nm_pangkat'];?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nama_jabatan'];?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nm_unitkerja'];?></td>
		</tr>
		

	</table>


	<p class="justify" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah Benar Pegawai Negeri Sipil Kota Manado dan saat ini tidak sedang menjalani 
        Tugas Belajar/Ikatan Dinas di Pemerintah Kota Manado.</p>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian surat keterangan dibuat untuk kelengkapan administrasi 
    <!-- Pindah tugas dari Pemerintah Kota Manado ke <?=$instansi_tujuan;?>. -->
    penyesuaian/inpassing.

     </p>

	<table border="0" style="width:100%;margin-top:140px;">
		<tr>
			<td style="width:62%;"></td>
			<td class="center"  style="width:38%;text-align: left;">Manado, ${tanggal_naskah}<br>a.n. WALI KOTA
				MANADO<br>Kepala Badan,</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;height:130px;text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ${ttd_pengirim}</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;text-align: left;"> ${nama_pengirim}<br>
Pembina<br>
NIP. ${nip_pengirim}</td>
		</tr>
	</table>

	<div class="footer-sk-2">
	<!-- <table border="0" style="width:100%;">
		<tr>
			<td style="width:100%;">
			Tembusan Yth. :<br>
			1. Wali Kota Manado (sebagai laporan);<br>
			2. Wakil Wali Kota Manado;<br>
			3. Pj. Sekretaris Daerah Kota Manado;<br>
			<?php if(stringStartWith('Guru', $profil_pegawai['nama_jabatan'])) { ?>
				4. Kepala Dinas Pendidikan dan Kebudayaan<br>
			<?php } else { ?>
				4. Kepala <?= $profil_pegawai['nm_unitkerja'];?><br>
			<?php } ?>
			5. Arsip.
			</td>
			
		</tr>
	</table> -->
	</div>
	<div class="footer-sk">
	<!-- <img src="<?=base_url();?>assets/images/footer.png" alt=""> -->
	</div>
	<?php
        // $this->load->view('adminkit/partials/V_FooterBsre');
    ?>

	<!-- <span style="margin-top:900px;">

Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. <?= $this->general_library->getTembusanHukdis($profil_pegawai['id_unitkerjamaster'],$profil_pegawai['nm_unitkerjamaster'],$profil_pegawai['nm_unitkerja']);?>;<br>
5. Arsip.
</span> -->
</body>
</html>
