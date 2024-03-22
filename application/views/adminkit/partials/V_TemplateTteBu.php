<style>
	.sp_tte_header{
		color: grey;
		line-height: .7rem;
		/* font-weight: bold; */
		font-family: Arial;
		/* opacity: .8; */
	}


	.sp_tte_header, .sp_tte_jabatan, .sp_tte_nama_pegawai, .sp_tte_nip{
		/* font-weight: bold; */
		font-family: Arial;
		font-size: .6rem !important;
		line-height: .8rem;
		opacity: .8;
	}

	.sp_tte_nama_pegawai, .sp_tte_nip{
		font-weight: bold;
		font-size: .8rem !important;
	}

	.sp_tte_jabatan{
		font-weight: bold;
		color: grey;
		line-height: .7rem;
	}

	img{
		display:table-cell;
	}
</style>
<?php
	$width_table = 100;
	if(isset($width)){
		$width_table = $width;
	}
?>
<table style="display: table; width: <?=$width?>%; height: 50%; border-collapse: collapse; border: 2px dashed rgb(148, 0, 0, .5);">
	<tr>
		<td valign="middle" style="vertical-align: middle; width: 30%; !important;" rowspan=2>
			<center>
				<img style="
					opacity: 1;
					width: 80px;
				"
				src="<?=base_url($qr)?>"></img>
			</center>
		</td>
		<td style="padding-top: 10px; width: 70%; vertical-align: top;" rowspan=1>
			<span class="sp_tte_header">Ditandatangani secara elektronik oleh:</span><br>
			<span class="sp_tte_jabatan">Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado</span><br>
			<!-- <span class="sp_tte_nama_pegawai">Donald Franky Supit, SH., MH</span><br>
			<span class="sp_tte_nip">NIP. 197402061998031008</span> -->
		<td>
		<tr>
			<td style="padding-bottom: 10px; vertical-align: bottom;">
				<span class="sp_tte_nama_pegawai">Donald Franky Supit, SH., MH</span><br>
				<span class="sp_tte_nip">NIP. 197402061998031008</span>
			</td>
		</tr>
	</tr>
</table>