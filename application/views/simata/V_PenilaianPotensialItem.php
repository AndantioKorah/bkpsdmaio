<?php if($result){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}

</style>

<div class="table-responsive">


	<table id="table-adm" class="table table-hover table-striped table-bordered datatable" style="width:100%;">
		<thead>
			<th class="text-center" style="width:5%;">No</th>
			<th style="width:50%;">Jabatan Target</th>
			<th style="width:15%;">Nilai Assesment</th>
			<th style="width:15%;">Nilai Rekam Jejak</th>
			<th style="width:15%;">Nilai Pertimbangan Lainnya</th>
<th>Total Nilai</th>
<th style="width:20%;">Pemeringkatan Kinerja</th>

			<!-- <th style="width:6%;"></th> -->
			<th style="width:5%;"></th>

		</thead>
		<tbody>

			<?php $nomor = 1; foreach($result as $rs){ ?>
			<tr style="background-color:#f8f9fa;">
				<td colspan="8"><b><?=$nomor++;?>. <?=$rs['gelar1'];?><?=$rs['nama'];?> <?=$rs['gelar2'];?> /
						<?=$rs['nipbaru'];?></b><br>
					<table class="table table-hover" style="width:102%;margin-left:-8px;margin-bottom:-8px;" border="0">
						<tbody>
							<?php foreach($result2 as $rs2){ ?>
							<?php if($rs2['id_peg'] == $rs['id_peg']) { ?>
							<tr style="border-bottom:0.5pt solid #e9eaee;border-top:0.5pt solid #e9eaee;">
								<td style="width:5%;">-</td>
								<td style="width:48%"><?=$rs2['nama_jabatan'];?></td>
								<td style="width:15%;"> 1</td>
                                <td style="width:15%;"> 2</td>
                                <td style="width:15%;"> 3</td>
                                <td style="width:15%;"> 4</td>

								<td style="width:20%;"><?= pemeringkatanKriteriaKinerja($rs2['res_kinerja'])?></td>
								<!-- <td style="width:5%;"><span class="badge bg-success">0/5</span></td> -->
								<td style="width:5%;">
									<button data-toggle="modal" data-id="<?=$rs2['id']?>" data-nip="<?=$rs2['nipbaru']?>" data-kode="1"
										href="#modal_penilaian_potensial" title="Ubah Data" class="open-DetailPenilaian btn btn-sm btn-info">
										<i class="fa fa-edit"></i></button>
								</td>
							</tr>
						</tbody>
						<?php } ?>
						<?php } ?>
					</table>

				</td>
				<td style="display:none"></td>
				<td style="display:none"></td>
				<td style="display:none"></td>
				<td style="display:none"></td>
				<td style="display:none"></td>

				<td style="display:none"></td>

				<td style="display:none"></td>

			</tr>



			<?php } ?>
		</tbody>
	</table>
</div>
</div>



<script>
	$(function () {
		$('#table-adm').dataTable({
			"ordering": false
		});

	})

	function deleteDataJt(id) {
		if (confirm('Apakah Anda yakin ingin menghapus data?')) {
			$.ajax({
				url: '<?=base_url("simata/C_Simata/deleteDataJabatanTarget/")?>' + id,
				method: 'post',
				data: null,
				success: function () {
					successtoast('Data sudah terhapus')
					location.reload()
				},
				error: function (e) {
					errortoast('Terjadi Kesalahan')
				}
			})
		}
	}



</script>
<?php } else { ?>
<div class="col-12 text-center">
	<h5>DATA TIDAK DITEMUKAN !</h5>
</div>
<?php } ?>
