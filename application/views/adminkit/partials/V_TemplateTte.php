<style>
	#tabel_pejabat_tte td{
		font-weight: bold !important;
		font-size: .6rem !important;
		font-family: Tahoma !important;
		line-height: .4rem !important;
	}

	img{
		display:table-cell;
	}
</style>
<?php
	$width_table = 120;
	if(isset($width)){
		$width_table = $width;
	}
?>
<table style="display: table; width: <?=$width?>%; height: 50%;
	text-align: center;
	/* border-collapse: collapse; border: 2px dashed rgb(148, 0, 0, .5); */
	"
>
	<tr>
		<td>
			<center>
				<img style="opacity: 1; width: <?=$width_table?>px; padding: 5px;"
				src="<?=($qr)?>"></img>
			</center>
		</td>
	</tr>
	<tr>
		<td style="width: 100%; vertical-align: middle; text-align: left !important;" rowspan=1>
			<center>
			<table id="tabel_pejabat_tte">
				<tr>
					<td style="vertical-align: middle; text-align: left !important;" rowspan=2>
						<img style="
							opacity: 1;
							width: 20px;
						"
						src="<?=base_url('assets/img/logo-kunci-bsre.png')?>"></img>
					</td>
					<td style="vertical-align: middle; text-align: left !important;" rowspan=1>
						
						<span class="sp_tte_nama_pegawai"><?= getNamaPegawaiFull($this->general_library->getDataKabanBkpsdm()) ?></span>
					</td>
				</tr>
				<tr>
					<td style="vertical-align: middle; text-align: left !important;" rowspan=1>
						<span class="sp_tte_nip">NIP. <?= ($this->general_library->getDataKabanBkpsdm()['nipbaru_ws']) ?></span>
					</td>
				</tr>
			</table>
			</center>
		<td>
	</tr>
</table>