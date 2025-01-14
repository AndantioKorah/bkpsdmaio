
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
		<?php $this->load->view('kepegawaian/surat/V_KopSurat.php');?>
		<!-- <?php $this->load->view('adminkit/partials/V_HeaderSKCuti.php');?> -->

	</div>
	<!-- <div style="text-align: center;margin-bottom:-10px;">
	<img style="width: 100px;" src="<?=base_url('assets/adminkit/img/pnggaruda.png')?>">
	</div> -->
	
	<table style="width:100%;" border="0">
        <tr>
        <td></td>
            <td style="width:55%;"> </td>
            <td> </td>
            <td>Manado,16 Oktober 2024</td> 
        </tr>
        <tr>
            <td>Nomor</td>
            <td>: 800.1.11.13/BKPSDM/SK/5428/2024      </td>
            <td></td>
            <td>Kepada</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>: Penting</td>
            <td> Yth.</td>
            <td>KEPALA BADAN KEUANGAN DAN</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: -</td>
            <td></td>
            <td>ASET DAERAH KOTA MANADO</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>: Kenaikan Gaji Berkala a.n</td>
            <td></td>
            <td>di - </td>
        </tr>
        <tr>
            <td></td>
            <td><b>&nbsp;&nbsp;YOURI JANUARDY BASSELO TOREH, S.Kom</b></td>
            <td></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;MANADO</td>
        </tr>
    </table>
	
	<p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini diberitahukan bahwa berhubung dengan telah dipenuhinya masa kerja dan syarat-syarat
    lainnya kepada :
    </p>

	<table style="width:100%;" border="0">
	
		<tr valign="top">
			<td style="width:25%;">1. Nama Pegawai </td>
			<td style="text-align: center;">:</td>
			<td><?= getNamaPegawaiFull($profil_pegawai);?></td>
		</tr>

		<!-- <tr valign="top">
			<td>2. Tempat/Tanggal Lahir </td>
			<td style="text-align: center;">:</td>
			<td> <?=$profil_pegawai['tptlahir'];?> / 
			<?php
				$date=date_create($profil_pegawai['tgllahir']);
				echo date_format($date,"d-m-Y");?>
			</td>
		</tr> -->

		<tr valign="top">
			<td>2. NIP </td>
			<td style="text-align: center;">:</td>
			<td><?=$profil_pegawai['nipbaru_ws'];?></td>
		</tr>

		<tr valign="top">
			<td>3. Pangkat </td>
			<td style="text-align: center;">:</td>
			<td>
			<?= $profil_pegawai['nm_pangkat'];?> 
			</td>
		</tr>

		<tr valign="top">
			<td>4. Jabatan </td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nama_jabatan'];?></td>
		</tr>

		<tr valign="top">
			<td>5. Unit Kerja </td>
			<td style="text-align: center;">:</td>
			<td><?= $profil_pegawai['nm_unitkerja'];?></td>
		</tr>
		<tr valign="top">
			<td>6. Gaji Pokok Lama </td>
			<td style="text-align: center;">:</td>
			<td>Rp. <?= $gaji_lama;?>,-</td>
		</tr>
		<tr valign="top">
			<td></td>
			<td ></td>
			<td>
			(Atas dasar Surat Keputusan terakhir tentang Gaji/Pangkat yang ditetapkan)
			<table border="0">
				<tr>
					<td>a. Oleh Pejabat</td>
					<td>: Wali Kota</td>
				</tr>
				<tr>
					<td>b. Tanggal/Nomor</td>
					<td>: 12 Februari 2021 / 813.23/BKPSDM/SK/01/2021</td>
				</tr>
				<tr>
					<td>c. Tanggal mulai berlaku<br>&nbsp; &nbsp; gaji tersebut</td>
					<td valign="top">: 01 Desember 2020</td>
				</tr>
				<tr>
					<td>d. Masa Kerja Golongan<br>&nbsp; &nbsp; pada tanggal tersebut</td>
					<td valign="top">:  00 TAHUN 00 BULAN</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr valign="top">
			<td colspan="3">&nbsp;&nbsp;&nbsp;Diberikan Kenaikan Gaji Berkala hingga memperoleh :</td>
		</tr>
		<tr valign="top">
			<td>7. Gaji Pokok Baru </td>
			<td style="text-align: center;">:</td>
			<td>Rp. <?= $gaji_baru;?>,-<br>
			(Dua Juta Sembilan Ratus Enam Puluh Empat Ribu Rupiah)</td>
		</tr>
		<tr valign="top">
			<td>8. Berdasarkan Masa Kerja </td>
			<td style="text-align: center;">:</td>
			<td>4 Tahun</td>
		</tr>
		<tr valign="top">
			<td>9. Dalam Golongan Ruang </td>
			<td style="text-align: center;">:</td>
			<td>III/a</td>
		</tr>
		<tr valign="top">
			<td>10. Terhitung Mulai Tanggal</td>
			<td style="text-align: center;">:</td>
			<td>01 Desember 2024</td>
		</tr>
		<tr valign="top">
			<td>11. Berkala Berikutnya</td>
			<td style="text-align: center;">:</td>
			<td>01 Desember 2026</td>
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
