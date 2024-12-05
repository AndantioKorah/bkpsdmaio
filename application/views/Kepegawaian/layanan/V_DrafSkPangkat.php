
<html>
<style>
	#bodysurat {
		font-family: Tahoma !important;
		font-size: 14px !important;
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

	 */
	.justify {
		text-align: justify !important;
	}

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
		<!-- <?php $this->load->view('adminkit/partials/V_HeaderSKCuti.php');?> -->

	</div>
	<div style="text-align: center;margin-bottom:-10px;">
	<img style="width: 100px;" src="<?=base_url('assets/adminkit/img/pnggaruda.png')?>">

	</div>
	
		<p class="judul"> 
            <b ><br>WALI KOTA MANADO<br>
			<b><br>PETIKAN</b><br>
			KEPUTUSAN WALI KOTA MANADO<br>
			Nomor : <?=$nomorsurat;?> <br>
        TENTANG<br>
    KENAIKAN PANGKAT PEGAWAI NEGERI SIPIL<br><br>
WALI KOTA MANADO</b></p>

	
	<table style="width:100%;" border="0">
	<tr >
			<td valign="top" style="width:15%;align:top">Menimbang</td>
			<td valign="top" style="align:top;text-align: center;width:4%;">:</td>
			<td valign="top" style="width:86%;">
			<p>bahwa Pegawai Negeri Sipil yang namanya tersebut dalam Keputusan ini, memenuhi syarat dan
			dipandang cakap untuk dinaikkan pangkatnya setingkat lebih tinggi</p><br>
		   </td>
		</tr>
		<tr  style="vertical-align:top;">
			<td valign="top" style="width:10%;align:top">Mengingat</td>
			<td valign="top" style="text-align: center;width:4%;">:</td>
			<td valign="top" style="width:86%;vertical-align:top">
			<p>
			1. Undang-Undang Nomor 20 Tahun 2023;<br>
			2. Peraturan Pemerintah Nomor 7 Tahun 1977 jo. Peraturan Pemerintah Nomor 5 Tahun 2024;<br>
			3. Peraturan Pemerintah Nomor 11 Tahun 2017 jo. Peraturan Pemerintah Nomor 17 Tahun 2020;<br>
			4. Keputusan Kepala Badan Kepegawaian Negara Nomor 12 Tahun 2002;
			</p><br>
		   </td>
		</tr>
		<tr>
			<td valign="top" style="width:10%;">Memperhatikan</td>
			<td valign="top" style="text-align: center;width:4%;">:</td>
			<td valign="top" style="width:86%;">
			<p>Pertimbangan teknis Kepala Kantor Regional XI BKN Nomor <?=$nomor_pertek;?> tanggal <?=$tanggal_pertek;?></p>
		   </td>
		</tr>
	</table>

	<p class="judul"><b>M E M U T U S K A N</b></p>
	<table style="width:100%;" border="0">
	<tr valign="top">
			<td valign="top" style="width:15%;">Menetapkan</td>
			<td valign="top" style="text-align: center;width:4%;">:</td>
			<td valign="top" style="width:86%;">
			<p>KEPUTUSAN WALI KOTA MANADO TENTANG KENAIKAN PANGKAT PEGAWAI NEGERI SIPIL</p><br>
		   </td>
		</tr>
	</table>
	<table style="width:100%;" border="0">
		<tr valign="top">
			<td style="width:15%;">KESATU</td>
			<td style="width:4%;text-align: center;">:</td>
			<td style="width:34%;">Pegawai Negeri Sipil, nomor urut : <?=$nomor_urut;?></td>
			<td style="width:4%;text-align: center;"></td>
			<td style="width:48%;"></td>
		</tr>
		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>1. Nama Pegawai </td>
			<td style="text-align: center;">:</td>
			<td><?= getNamaPegawaiFull($profil_pegawai);?></td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>2. Tempat/Tanggal Lahir </td>
			<td style="text-align: center;">:</td>
			<td> <?=$profil_pegawai['tptlahir'];?> / 
			<?php
				$date=date_create($profil_pegawai['tgllahir']);
				echo date_format($date,"d-m-Y");?>
			</td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>3. NIP </td>
			<td style="text-align: center;">:</td>
			<td><?=$profil_pegawai['nipbaru_ws'];?></td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>4. Pendidikan </td>
			<td style="text-align: center;">:</td>
			<td><?=$profil_pegawai['nm_tktpendidikan'];?> <?=$profil_pegawai['jurusan'];?></td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>5. Pangkat Lama / Gol. Ruang/TMT </td>
			<td style="text-align: center;">:</td>
			<td>
			<?= $profil_pegawai['nm_pangkat'];?> / 
			<?php
				$date=date_create($profil_pegawai['tmtpangkat']);
				echo date_format($date,"d-m-Y");?>
			</td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>6. Jabatan </td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nama_jabatan'];?></td>
		</tr>

		<tr valign="top">
			<td></td>
			<td style="text-align: center;"></td>
			<td>7. Unit Kerja </td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nm_unitkerja'];?></td>
		</tr>
	</table>
	<br>
	
	
	
<div class="row">
	<div style="width: 19%; float:left;">
</div>
<div style="width: 81%; float:right;text-align: justify">
Terhitung mulai tanggal <b>01-12-2024</b> dinaikkan pangkatnya menjadi <b>Penata Muda Tingkat I</b> golongan
ruang <b>III/b</b>, <b>Pranata Komputer Ahli Pertama / 50</b> dengan masa kerja golongan <b>4 Tahun 0 Bulan</b>, dan
diberikan gaji pokok sebesar <b>Rp. 3.089.300</b> ditambah dengan penghasilan lain berdasarkan ketentuan
peraturan perundang-undangan yang berlaku. 
</div>
</div>
<br>
<table style="width:100%;" border="0">
	<tr valign="top">
			<td valign="top" style="width:15%;">KEDUA</td>
			<td valign="top" style="text-align: center;width:4%;">:</td>
			<td valign="top" style="width:86%;text-align: justify">
			<p>Apabila dikemudian hari ternyata terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan
			dan penghitungan kembali sebagaimana mestinya</p><br>
		   </td>
		</tr>
	</table>
	<br>
	<br>
	<table border="0" style="width:100%;">
		<tr>
			<td style="width:62%;"></td>
			<td  style="width:38%;">

			<table style="width:100%;">
				<tr><td>Ditetapkan di Manado</td></tr>
				<tr><td>Pada tanggal <?= formatDateNamaBulan(date('Y-m-d'));?></td></tr>
				<tr><td  style="text-align: center;">WALI KOTA MANADO</td></tr>
			</table>
			</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;height:100px;text-align: center;">ttd</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="text-align: center;">Andrei Angouw</td>
		</tr>
	</table>
	<div class="footer-sk-2">
	
	</div>
	<div class="footer-sk">
	<img src="<?=base_url();?>assets/images/footer.png" alt="">
	</div>


	</body>
	</html>
