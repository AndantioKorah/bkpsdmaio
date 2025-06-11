<!-- <style>
  @media print {

    
@page {
  size: F4;
}

	p {
		font-size: 16pt;
        font-family: "Bookman Old Style";
        color:#000;
	}

    table {
        font-size: 14;
        font-family: "Bookman Old Style";
        color:#000;
    }
}
</style> -->
<html>
<style>
	#bodysurat {
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
	}

	.justify {
		text-align: justify;
	} */

	p {
		/* text-align: center; */
	}

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
		<!-- <?php $this->load->view('kepegawaian/surat/V_KopSurat.php');?> -->
		<?php $this->load->view('adminkit/partials/V_HeaderSKCuti.php');?>

	</div>
		<p class="judul" style="margin-top:5px;"> SURAT PERNYATAAN<br>
			TIDAK SEDANG MENJALANI PROSES PIDANA ATAU PERNAH DIPIDANA PENJARA<br>
			<u>BERDASARKAN PUTUSAN PENGADILAN YANG TELAH BERKEKUATAN HUKUM TETAP</u> </p>
		<p class="judul" style="margin-top:-18px;"> Nomor : <?php if(isset($data['nomor_surat'])) echo $data['nomor_surat']; else echo "";?> </p>

	<p>Yang bertanda-tangan dibawah ini :</p>
	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:22%;">Nama</td>
			<td style="text-align: center;width:1%;">:</td>
			<td style="width:70%;">
			<?= getNamaPegawaiFull($kaban);?>
		</td>
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

	</table>


	<p>
		Dengan ini menyatakan dengan sesungguhnya bahwa Pegawai Negeri Sipil :
	</p>

	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:22%;">Nama</td>
			<td style="text-align: center;width:1%;">:</td>
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
			<td valign="top">Jabatan</td>
			<td valign="top" style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nama_jabatan'];?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nm_unitkerja'];?></td>
		</tr>


	</table>


	<p class="justify besar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;Tidak sedang menjalani proses pidana atau pernah dipidana penjara
		berdasarkan putusan pengadilan yang telah berkekuatan hukum tetap karena
		melakukan tindak pidana kejahatan jabatan atau tindak pidana kejahatan yang
		ada hubungannya dengan jabatan dan/atau pidana umum. </p>

	<p class="justify besar">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;Demikian Surat Pernyataan ini saya buat dengan sesungguhnya dengan
		mengingat sumpah jabatan, dan apabila dikemudian hari ternyata isi surat
		pernyataan ini tidak benar yang mengakibatkan kerugian bagi negara maka saya
		bersedia menanggung kerugian negara sesuai dengan ketentuan peraturan
		perundang-undangan.
	</p>


	<table border="0" style="width:100%;margin-top:10px;">
		<tr>
			<td style="width:62%;"></td>
			<td class="center"  style="width:38%;text-align: center;">Manado, <?= formatDateNamaBulan(date('Y-m-d'));?><br>a.n. WALI KOTA
				MANADO</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;height:150px;text-align: center;">^</td>
		</tr>
	</table>
	<div class="footer-sk-2">
	<table border="0" style="width:100%;">
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
		
	</table>
	</div>
	<div class="footer-sk">
	<img src="<?=base_url();?>assets/images/footer.png" alt="">
	</div>
	<?php
        // $this->load->view('adminkit/partials/V_FooterBsre');
    ?>
	<!-- <img style="width: 100%;margin-top: 90px;" src="<?=base_url();?>assets/images/footer.png" alt=""> -->
	<!-- <span >

Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. <?= $this->general_library->getTembusanHukdis($profil_pegawai['id_unitkerjamaster'],$profil_pegawai['nm_unitkerjamaster'],$profil_pegawai['nm_unitkerja']);?>;<br>
5. Arsip.
</span> -->
	</body>
	</html>
