<style>
	.top_header{
		font-weight: bold;
		font-size: 25px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.top_header_secondary{
		font-weight: bold;
		font-size: 20px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.address_header{
		font-weight: 500;
		font-size: 18px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.footer_header{
		font-weight: 500;
		font-size: 15px;
		margin-bottom: 0px;
		margin-top: 0px;
	}
</style>
<table style="width: 100%;">
	<tr>
		<td valign=bottom style="width: 5%;">
			<img style="width: 100px;" src="<?=base_url('assets/adminkit/img/logo-pemkot-small.png')?>">
		</td>
		<td valign=bottom style="width: 95%; text-align:center;">
			<h5 class="top_header_secondary">PEMERINTAH KOTA MANADO</h5>
			<h5 class="top_header"><?=strtoupper($skpd['nm_unitkerja'])?></h5>
			<h5 class="address_header"><?=$skpd['alamat_unitkerja']?></h5>
			<h5 class="footer_header"><?=$skpd['notelp'] ? $skpd['notelp'].' | ' : $skpd['emailskpd']?></h5>
		</td>
	</tr>
	<tr>
		<td colspan=3 style="border-bottom: 3px solid black;"></td>
	</tr>
</table>