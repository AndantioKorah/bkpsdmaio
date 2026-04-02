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
		</style>
		<table class="table table-sm table-hover table-striped" id="table_list_peserta">
			<thead>
				<th class="text-center">No</th>
				<th class="text-left">Peserta</th>
				<th class="text-left">Pendaftaran</th>
				<th class="text-left">Absen</th>
				<th class="text-left">Sertifikat</th>
			</thead>
			<tbody>
				<?php $no = 1; foreach($result as $rs){ ?>
					<tr>
						<td class="text-center"><?=$no++?></td>
						<td class="text-left">
							<span class="sp_val_main"><?=getNamaPegawaiFull($rs)?></span><br>
							<span class="sp_val_sec"><?=($rs['nipbaru_ws'])?></span><br>
							<span class="sp_val_sec"><?=($rs['nama_jabatan'])?></span><br>
							<span class="sp_val_sec"><?=($rs['nm_unitkerja'])?></span>
						</td>
						<td class="text-left"><?=formatDateNamaBulanWithTime($rs['created_date'])?></td>
						<td class="text-left"><?=$rs['flag_absen'] == 1 ? formatDateNamaBulanWithTime($rs['date_absen']) : "-" ?></td>
						<td class="text-left">
							<?php if($rs['flag_generate_sertifikat'] == 1){ ?>
								<a target="_blank" href="<?=base_url($rs['url_sertifikat'])?>" class="btn btn-navy btn-sm"><i class="fa fa-file"></i> Sertifikat</a><br>
								<?=formatDateNamaBulanWithTime($rs['date_generate_sertifikat'])?>
							<?php } else { ?>
								-
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<script>
			$(function(){
				$('#table_list_peserta').dataTable()
			})

			function openSertifikat(link){
				
			}
		</script>
	<?php } else { ?>
		<div class="col-lg-12 text-center">
			<h5>Belum ada peserta</h5>
		</div>
	<?php } ?>
</div>