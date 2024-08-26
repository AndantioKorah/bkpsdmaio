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

<style>
	#bodysurat {
		font-family: Arial, Helvetica, sans-serif !important;
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

	table {
		font-family: Arial, Helvetica, sans-serif !important;
		font-size: 17px !important;
	}
</style>
<title>Surat Hukdis</title>
<div id="bodysurat">
	<div class="header" style="margin-top:-40px;margin-right:40px;">
		<?php $this->load->view('adminkit/partials/V_HeaderSKCuti.php');?>
	</div>
		<p class="judul" style="margin-top:5px;text-align: center;"> SURAT PERNYATAAN<br>
			<u>TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN TINGKAT SEDANG/BERAT</u></p>
		<p style="text-align: center;"> Nomor : </p>

	<p>Yang nama bertanda-tangan dibawah ini :</p>
	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:22%;">Nama</td>
			<td style="text-align: center;width:1%;">:</td>
			<td style="width:70%;"><?= $kaban['gelar1'];?><?= strtoupper($kaban['nama']);?><?= $kaban['gelar2'];?></td>
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


	<span>
		Dengan ini menyatakan dengan sesungguhnya bahwa Pegawai Negeri Sipil :
	</span>

	<table style="margin-left:50px;width:100%;" border="0">
		<tr>
			<td style="width:22%;">Nama</td>
			<td style="text-align: center;width:1%;">:</td>
			<td style="width:70%;">
				<?= $profil_pegawai['gelar1'];?><?= $profil_pegawai['nama'];?><?= $profil_pegawai['gelar2'];?></td>
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
		<tr>
			<td colspan="3">Dalam satu tahun terakhir tidak pernah dijatuhi hukuman disiplin tingkat sedang/berat. </td>
		</tr>

	</table>


	<p class="justify besar" style="margin-right:40px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Pernyataan ini saya buat dengan
		sesungguhnya dengan mengingat
		sumpah jabatan dan apabila dikemudian hari ternyata isi surat pernyataan ini tidak benar yang
		mengakibatkan kerugian negara, maka saya bersedia menanggung kerugian tersebut.</p>


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

	<img style="width: 100%;margin-top: 200px;" src="<?=base_url();?>assets/images/footer.png" alt="">

	<!-- <span style="margin-top:900px;">

Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. <?= $this->general_library->getTembusanHukdis($profil_pegawai['id_unitkerjamaster'],$profil_pegawai['nm_unitkerjamaster'],$profil_pegawai['nm_unitkerja']);?>;<br>
5. Arsip.
</span> -->
</div>
