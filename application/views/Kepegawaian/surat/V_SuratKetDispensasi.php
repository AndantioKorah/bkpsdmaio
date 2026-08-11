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

        <table style="width:100%;" border="0">
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;">Manado, <?= formatDateNamaBulan(date('Y-m-d'));?></td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><?= $ns;?></td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Biasa</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td>Dispensasi</td>
            </tr>
           </table>
           <table>
            <tr>
                <td>Yth.</td>
                <td></td>
                <td>
            <?php if(stringStartWith('Guru', $profil_pegawai['nama_jabatan'])) { ?>
				Kepala Dinas Pendidikan dan Kebudayaan<br>
			<?php }  else if(substr($profil_pegawai['nm_unitkerja'], 0, 9) == "Kelurahan")  { ?>
				<?php if(substr($profil_pegawai['nama_jabatan'], 0, 5) == "Lurah") { ?>
				Camat <?= substr($profil_pegawai['nm_unitkerjamaster'], 9) ;?> <br>
				<?php } else { ?>
				Lurah <?= substr($profil_pegawai['nm_unitkerja'], 9) ;?><br>
				<?php } ?>
			<?php } if(substr($profil_pegawai['nm_unitkerja'], 0, 9) == "Kecamatan") { ?>
			    <?php if(substr($profil_pegawai['nama_jabatan'], 0, 5) == "Camat") { ?>
				Sekrataris Daerah Kota Manado <br>
				<?php } else { ?>
				Camat <?= substr($profil_pegawai['nm_unitkerja'], 9) ;?><br>
				<?php } ?>
			<?php } else { ?>
				Kepala <?= $profil_pegawai['nm_unitkerja'];?><br>
			<?php } ?>
                </td>
            </tr>
        </table>
	
        

	<p class="justify" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Menindaklanjuti Surat <?= $detail_kegiatan['nama_organisasi']; ?> 
        Nomor: <?= $detail_kegiatan['nomor_surat_permohonan']; ?> tanggal <?= formatDateNamaBulan($detail_kegiatan['tanggal_surat_permohonan']); ?> 
        hal Permohonan Izin/Dispensasi, maka berdasarkan Pasal 29 ayat (5) Peraturan Wali Kota Manado Nomor 30 Tahun 2023 
        tentang Perubahan Atas Peraturan Wali Kota  Manado Nomor 1 Tahun 2022 tentang Tambahan Penghasilan Bagi Aparatur Sipil Negara, 
        dengan ini memberikan dispensasi untuk tidak masuk kerja/melaksanakan tugas kedinasan kepada ASN tersebut dibawah ini:.
    </p>


	<table style="width:100%;" border="0">
		<tr>
			<td style="width:25%;">Nama</td>
			<td style="width:5%;text-align: center;">:</td>
			<td style="width:70%;text-transform: capitalize;">
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
			<td valign="top"><?php if(substr($profil_pegawai['nama_jabatan'], 0, 5) == "Lurah") echo "Lurah"; else if(substr($profil_pegawai['nama_jabatan'], 0, 5) == "Camat") echo "Camat"; else if(substr($profil_pegawai['nama_jabatan'], 0, 5) == "Sekre") echo "Sekretaris"; else echo $profil_pegawai['nama_jabatan'];?> Pada <?= $profil_pegawai['nm_unitkerja'];?> Kota Manado</td>
		</tr>
		
		

	</table>

    <p class="justify" style="text-indent: 5px;">
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dalam rangka mengikuti kegiatan <?= $detail_kegiatan['nama_kegiatan']; ?> yang dilaksanakan
         <?php if($tanggal_mulai_kegiatan == $tanggal_selesai_kegiatan) { ?>
         pada tanggal <?= formatDateNamaBulan($tanggal_mulai_kegiatan);?> 
		 <?php } else { ?>
         pada tanggal <?= formatDateNamaBulan($tanggal_mulai_kegiatan);?> s.d <?= formatDateNamaBulan($tanggal_selesai_kegiatan);?> 
		 <?php }  ?>

         di <?= $detail_kegiatan['tempat_kegiatan']; ?>, Kecamatan <?= $detail_kegiatan['nama_kecamatan']; ?>, <span style="text-transform: capitalize;"><?= strtolower($detail_kegiatan['nama_kabupaten_kota']); ?></span> , <?= $detail_kegiatan['nama_provinsi']; ?>. 
        </p>
        <p class="justify" style="text-indent: 4px;">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian disampaikan atasnya diucapkan terima kasih.
        </p>

      

	<table border="0" style="width:100%;margin-top:20px;">
		<tr>
			<td style="width:62%;"></td>
			<td class="center"  style="width:38%;text-align: left;">a.n. WALI KOTA MANADO,<br><br></td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;height:130px;text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td class="center" style="width:38%;text-align: left;"> </td>
		</tr>
	</table>

	<div class="footer-sk-2">
	<table border="0" style="width:100%;">
		<tr>
			<td style="width:100%;">
			Tembusan Yth. :<br>
			1. Wali Kota Manado (sebagai laporan);<br>
			2. Wakil Wali Kota Manado;<br>
			3. Sekretaris Daerah Kota Manado.<br>
			
			</td>
			
		</tr>
	</table>
	</div>
	<div class="footer-sk">
	<!-- <img src="<?=base_url();?>assets/images/footer.png" alt=""> -->
	</div>
	<?php
        $this->load->view('adminkit/partials/V_FooterBsre');
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
