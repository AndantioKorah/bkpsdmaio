<?php if($user){ ?>
	<table>
		<tr>
			<td colspan=2>
				<center>
					<img src="<?=$qr?>" style="width: 150px;"/>
				</center>
			</td>
		</tr>
		<tr style="vertical-align: middle;">
			<td colspan=1>
				<img style="width: 35px;" src="<?=base_url('assets/img/logo-kunci-bsre.png')?>">
			</td>
			<td colspan=1>
				<span style="font-size: 1rem; font-weight: bold; font-family: Tahoma;"><?=getNamaPegawaiFull($user)?></span><br>
				<span style="font-size: 1rem; font-weight: bold; font-family: Tahoma;">NIP. <?=($user['nipbaru_ws'])?></span>
			</td>
		</tr>
	</table>
<?php } else { ?>
	Data User tidak ditemukan
<?php } ?>