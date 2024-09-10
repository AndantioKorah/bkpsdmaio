<html>
<style>

	#bodysurat {
		/* font-family: Arial, Helvetica, sans-serif !important; */
		font-family: Tahoma !important;
		font-size: 13px !important;
		/* line-height: 20px !important; */
	}

	
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

	  table {
		width: 100%;
		font-size: 13px !important;
		border-collapse: collapse;
	  }
	

</style>
<body id="bodysurat">

	

		<p style="text-align: right;"> Manado, <?= formatDateNamaBulan(date('Y-m-d'));?></p>
		<table border="0" >
			<tr>
			<td style="width: 50%;"></td>
			<td >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kepada :<br>
		    Yth. Bapak Wali Kota Manado<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cq. Kepala Badan Kepegawaian dan Pengembangan 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sumber Daya Manusia<br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di - <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manado
		
		    </td>
			</tr>
		</table>

	<p style="text-align: center;"><b>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</b></p>
	
	<table border="1">
    <tr>
		<td colspan="4">I. DATA PEGAWAI</td>
	</tr>
	<tr>
		<td style="width: 10%;">Nama</td>
		<td style="width: 40%;"><?= getNamaPegawaiFull($cuti);?></td>
		<td style="width: 10%;">NIP</td>
		<td style="width: 40%;"><?= formatNip($cuti['nipbaru']);?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td><?= $cuti['nama_jabatan'];?></td>
		<td>Masa Kerja</td>
		<td></td>
	</tr>
	<tr>
		<td >Unit Kerja </td>
		<td colspan="3"><?= $cuti['nm_unitkerja'];?></td>
	</tr>
	
	</table>
	  <br>
	<table border="1">
	<tr>
		<td colspan="4">II. JENIS CUTI YANG DIAMBIL**</td>
	</tr>
	<tr>
		<td style="width: 30%;">1. Cuti Tahunan</td>
		<td style="width: 20%;">&nbsp;&#8730;
		</td>
		<td style="width: 30%;">2. Cuti Besar</td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td>3. Cuti Sakit</td>
		<td></td>
		<td>4. Cuti Melahirkan</td>
		<td></td>
	</tr>
	<tr>
		<td>5. Cuti Karena Alasan Penting</td>
		<td></td>
		<td>6. Cuti di Luar Tanggungan Negara</td>
		<td></td>
	</tr>
	</table>
	<br>
	<table border="1">
	<tr>
		<td colspan="4">III. ALASAN CUTI</td>
	</tr>
	<tr>
		<td td colspan="4"> <?=$cuti['alasan'];?> </td>
	</tr>
	</table>
	<br>
	<table border="1">
	<tr>
		<td colspan="8">IV. LAMANYA CUTI</td>
	</tr>
	<tr>
		<td style="width: 10%;text-align: center;"><?=$cuti['lama_cuti'];?></td>
		<td style="width: 20%;text-align: center;" colspan="3">hari</td>
		<td style="width: 20%;text-align: center;">mulai tanggal</td>
		<td style="width: 20%;text-align: center;"><?=$cuti['tanggal_mulai'];?></td>
		<td style="width: 10%;text-align: center;">s/d</td>
		<td style="width: 20%;text-align: center;"><?=$cuti['tanggal_akhir'];?></td>
	</tr>
	</table>
	<br>
	<table border="1">
		<tr>
			<td colspan="8">V. CATATAN CUTI**</td>
		</tr>
	<tr>
		<td colspan="2" style="width: 20%;">1. CUTI TAHUNAN</td>
		<td style="width: 15%;"></td>
		<td colspan="4" style="width: 20%;">2. CUTI BESAR</td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td>Tahun</td>
		<td>Sisa </td>
		<td>Keterangan</td>
		<td colspan="4">3. CUTI SAKIT</td>
		<td></td>
	</tr>
	<tr>
		<td>N-2</td>
		<td> </td>
		<td></td>
		<td colspan="4">4. CUTI MELAHIRKAN</td>
		<td></td>
	</tr>
	<tr>
		<td>N-1</td>
		<td> </td>
		<td></td>
		<td colspan="4">4. CUTI KARENA ALASAN PENTING</td>
		<td></td>
	</tr>
	<tr>
		<td>N</td>
		<td> </td>
		<td></td>
		<td colspan="4">4. CUTI DI LUAR TANGGUNGAN NEGARA</td>
		<td></td>
	</tr>
	</table>
	<br>
	<table border="1">
	<tr>
		<td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
	</tr>
	<tr>
		<td style="width: 60%;"></td>
		<td style="width: 10%;">TELP :</td>
		<td style="width: 30%;"> <?= $cuti['handphone'];?></td>
	</tr>
	<tr>
	<td style="width: 60%;"><?=$cuti['alamat_cuti'];?></td>
	<td colspan="2" style="width: 40%;text-align: center;">
		Hormat Saya,
	  	<br><br><br><br>

		<?= getNamaPegawaiFull($cuti);?><br>
		NIP.<?= formatNip($cuti['nipbaru']);?>
	</td>
	</tr>
	</table>
	<br>
	<table border="1">
	<tr>
		<td colspan="4">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
	</tr>
	<tr>
		<td style="width: 20%;text-align: center;">DISETUJUI</td>
		<td style="width: 20%;text-align: center;">PERUBAHAN****</td>
		<td style="width: 20%;text-align: center;">DITANGGUHKAN****</td>
		<td style="width: 40%;text-align: center;">TIDAK DISETUJUI****</td>
	</tr>
	<tr>
		<td style="text-align: center;color:#fff;">a</td>
		<td style="text-align: center;"></td>
		<td style="text-align: center;"></td>
		<td style="text-align: center;"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td style="text-align: center;">
		<?=$atasan_pegawai['nama_jabatan']?>
	  	<br><br><br><br><br>
		<?= getNamaPegawaiFull($atasan_pegawai);?><br>
		NIP.<?=formatNip($atasan_pegawai['nipbaru_ws'])?>
		</td>
	</tr>
	</table>
	<br>
	<table border="1">
	<tr>
		<td colspan="4">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI****</td>
	</tr>
	<tr>
		<td style="width: 20%;text-align: center;">DISETUJUI</td>
		<td style="width: 20%;text-align: center;">PERUBAHAN****</td>
		<td style="width: 20%;text-align: center;">DITANGGUHKAN****</td>
		<td style="width: 40%;text-align: center;">TIDAK DISETUJUI****</td>
	</tr>
	<tr>
		<td style="text-align: center;color:#fff;">a</td>
		<td style="text-align: center;"></td>
		<td style="text-align: center;"></td>
		<td style="text-align: center;"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td style="text-align: center;">
		Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia
	  	<br><br><br><br><br>
		<?= getNamaPegawaiFull($kaban);?><br>
		NIP.<?=formatNip($kaban['nipbaru_ws'])?>
		</td>
	</tr>
	</table>
	<div class="footer-sk">
	<img src="<?=base_url();?>assets/images/footer.png" alt="">
	</div>
</body>
</html>
