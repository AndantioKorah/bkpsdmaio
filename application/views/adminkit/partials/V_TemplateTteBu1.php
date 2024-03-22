<style>
	.sp_tte_nama_pegawai, .sp_tte_nip{
		font-weight: bold;
		font-size: .6rem !important;
		line-height: .6rem;
		font-family: Tahoma;
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
		<td valign="middle" style="vertical-align: middle; width: 30%; !important;" rowspan=1>
			<center>
				<img style="
					opacity: 1;
					width: 80px;
				"
				src="<?=base_url($qr)?>"></img>
			</center>
		</td>
		<td style="width: 70%; vertical-align: middle;" rowspan=1>
			<table>
				<tr>
					<td style="vertical-align: middle;" rowspan=1>
						<img style="
							opacity: 1;
							width: 20px;
						"
						src="<?=base_url('assets/img/logo-kunci-bsre.png')?>"></img>
					</td>
					<td style="vertical-align: middle;">
						<span class="sp_tte_nama_pegawai">Donald Franky Supit, SH., MH</span><br>
						<span class="sp_tte_nip">NIP. 197402061998031008</span>
					</td>
				</tr>
			</table>
		<td>
	</tr>
</table>