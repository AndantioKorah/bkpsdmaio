<?php

    $filename = 'DATA Jumlah ASN Kota Manado '.formatDateNamaBulan(date('Y-m-d')).'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>
<div class="row">
	<?php if($result){ ?>
		<style>
			.sp_val_main{
				font-weight: bold;
				color: black;
				font-size: 1.1rem;
			}

			.sp_val_sec{
				font-weight: bold;
				color: grey;
				font-size: .8rem;
			}

			/* #table_list_peserta_rekap{
				
			} */
		</style>
		<div style="text-align: center;">
			Rekap Peserta Kegiatan:<br>
			<span style="font-weight: bold; font-size: 1rem; color: black;"><?=strtoupper($result[0]['topik'])?></span><br>
			<span style="font-weight: bold; font-size: .75rem; color: grey;"><?=formatDateNamaBulanWithTime(date('Y-m-d H:i:s'))?></span>
		</div>
		<br><br>
		<table style="width: 100%; border: 1px solid black; border-collapse: collapse;" class="table table-sm table-hover table-striped" id="table_list_peserta_rekap">
			<thead>
				<th style="border: 1px solid black; text-align: center;" class="text-center">No</th>
				<th style="border: 1px solid black; text-align: left;" class="text-left">Nama</th>
				<th style="border: 1px solid black; text-align: left;" class="text-left">NIP</th>
				<th style="border: 1px solid black; text-align: left;" class="text-left">Jabatan</th>
				<th style="border: 1px solid black; text-align: left;" class="text-left">Unit Kerja</th>
				<th style="border: 1px solid black; text-align: center;" class="text-center">Pendaftaran</th>
				<th style="border: 1px solid black; text-align: center;" class="text-center">Absen</th>
				<!-- <th style="border: 1px solid black; text-align: center;" class="text-center">Sertifikat</th> -->
			</thead>
			<tbody>
				<?php $no = 1; foreach($result as $rs){ ?>
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black; text-align: center;" class="text-center"><?=$no++?></td>
						<td style="border: 1px solid black; text-align: left;" class="text-left">
							<span class="sp_val_main"><?=getNamaPegawaiFull($rs)?></span><br>
						</td>
                        <td>
                           '<?=($rs['nipbaru_ws'])?> 
                        </td>
                        <td><?=($rs['nama_jabatan'])?></td>
                        <td><?=($rs['nm_unitkerja'])?></td>
						<td style="border: 1px solid black; text-align: center;" class="text-center"><?=formatDateNamaBulanWithTime($rs['created_date'])?></td>
						<td style="border: 1px solid black; text-align: center;" class="text-center"><?=$rs['flag_absen'] == 1 ? formatDateNamaBulanWithTime($rs['date_absen']) : "-" ?></td>
						<!-- <td style="border: 1px solid black; text-align: center;" class="text-center">
							<?php if($rs['flag_generate_sertifikat'] == 1){ ?>
								<?=formatDateNamaBulanWithTime($rs['date_generate_sertifikat'])?>
							<?php } else { ?>
								-
							<?php } ?>
						</td> -->
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="col-lg-12 text-center">
			<h5>Belum ada peserta</h5>
		</div>
	<?php } ?>
</div>