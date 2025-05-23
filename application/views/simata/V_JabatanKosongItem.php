<?php if($result_jpt){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}

    .tdnama {
		background-color: #2e4963 !important;
		color: #fff;
	}
</style>

<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item" role="presentation">
		<!-- <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
			role="tab" aria-controls="home" aria-selected="true">Administrator</button> -->
			<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
			role="tab" aria-controls="home" aria-selected="true">List Pegawai</button>
	</li>
	</li>
	<!-- <li class="nav-item" role="presentation">
		<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
			role="tab" aria-controls="profile" aria-selected="false">JTP Pratama</button>
	</li> -->

</ul>
<div class="tab-content" id="myTabContent">
	<!-- administrator -->
	<br>
	<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

		<div class="table-responsive">
			<table id="table_jt" class="display table table-bordered datatable" style="width:100%;">
				<thead>
					<th class="text-center" style="width:5%;">No </th>
					<th class="" style="width:40%;">Nama/ NIP</th>
					<th style="width:55%;">Jabatan Target</th>
				</thead>
				<tbody>
					<?php $nomor = 1; foreach($result_adm as $rs){ ?>
					<tr>
						<td class="align-top tdnama" align="center"><?=$nomor++;?></td>
						<td class="align-top tdnama">
							<a target="_blank" href="<?= base_url('kepegawaian/profil-pegawai/')?><?=$rs['nipbaru_ws'];?>" style="color:#fff"><b><?=$rs['gelar1'];?><?=$rs['nama'];?> <?=$rs['gelar2'];?></b> <br><?=formatNip($rs['nipbaru']);?></a>
							<br>
							Pangkat :
							<b><?=$rs['nm_pangkat'];?></b><br>

							<!-- Jabatan Sekarang :<br> -->
							<i><?=$rs['nama_jabatan'];?></i><br>

						</td>
						<td class="align-top">
							<!-- <form method="post"  action="submit-jabatan-target" enctype="multipart/form-data" > -->
							<!-- <form method="post" id="submit_jabatan_target" class="submit_jabatan_target" enctype="multipart/form-data"> -->

								<div class="mb-3">
									<div class="row">
										<div class="col-lg-9 col-md-4">
											<!-- <div class="form-group">
												<input type="hidden" name="tab" value="adm">
												<input type="hidden" name="id_pegawai" value="<?=$rs['id_peg'];?>">
												<select class="form-control js-example-basic-multiple hsl"
													name="jabatan_target[]" multiple="multiple" required>
													<?php if($jabatan_jpt){ foreach($jabatan_jpt as $r){ ?>
													<option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?>
														Pada <?=$r['nm_unitkerja']?> </option>
													<?php } } ?>
												</select>
											</div> -->
										</div>

										<div class="col-lg-3 col-md-4">
											<div class="form-group">
												<!-- <button class="btn btn-sm btn-navy float-right btn_simpan_jab_target"
													type="submit"><i class="fa fa-edit"></i> Tambah Jabatan Target</button> -->
													<button 
													data-toggle="modal" 
													data-id_pegawai="<?=$rs['id_peg']?>"
													data-nm_jabatan="<?=$rs['nama_jabatan']?>"
													href="#modal_input_jabatan_target"
													onclick="loadModalInputJT('<?=$rs['id_peg']?>','<?=$jenis_jabatan;?>')"
													class="open-DetailJabatanx btn btn-sm btn-info mb-2 float-right col-4" > <i class="fa fa-edit"></i> </button>

											</div>
										</div>

									</div>
									<!-- <span class="mt-2">Jabatan Target :</span><br> -->
									<?php  foreach($jabatan_target as $jt){ ?>
									<?php if($rs['id_peg'] == $jt['id_peg']) { ?>
									<table class="table table-hover table-striped table-bordered">
										<tr>
											<td style="width:5%;" valign="top">-</td>
											<td style="width:90%;"> <b><?=$jt['nama_jabatan'];?> Pada
													<?=$jt['nm_unitkerja'];?></b>
											</td>
											<td>
												<a onclick="deleteDataJt('<?=$jt['id']?>','adm')" class="btn btn-sm"> <i
														style="color:red;" class="fa fa-trash"></i> </a>
											</td>
										</tr>
									</table>

									


									<?php } ?>
									<?php } ?>
							</form>
						</td>
					</tr>

					<?php } ?>
				</tbody>
			</table>

		</div>


	</div>
</div>

<div class="modal fade" id="modal_input_jabatan_target" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jabatan Target</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="form_tambah_rumpun">

            </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<!-- tutup administrator -->

<!-- jpt -->

<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

	<div class="table-responsive">
		<table id="table_jt" class="table table-hover table-striped table-bordered datatable" style="width:100%;">
			<thead>
				<th class="text-center" style="width:5%;">No</th>
				<th style="width:40%;">Nama/ NIP</th>
				<th style="width:55%;">Jabatan Target</th>
			</thead>
			<tbody>
				<?php $nomor = 1; foreach($result_jpt as $rs){ ?>

				<tr>
					<td class="align-top" align="center"><?=$nomor++;?></td>
					<td class="align-top">
						<?=$rs['gelar1'];?><?=$rs['nama'];?><?=$rs['gelar2'];?> /<br><?=$rs['nipbaru'];?>
						<br>
						Pangkat :
						<b><?=$rs['nm_pangkat'];?></b><br>

						Jabatan Sekarang :<br>
						<b><?=$rs['nama_jabatan'];?></b><br>

					</td>
					<td class="align-top">
						<!-- <form method="post"  action="submit-jabatan-target" enctype="multipart/form-data" > -->
						<form method="post" id="submit_jabatan_target" class="submit_jabatan_target"
							enctype="multipart/form-data">

							<div class="mb-3">
								<div class="row">

									<div class="col-lg-9 col-md-4">
										<div class="form-group">
											<input type="hidden" name="tab" value="jpt">

											<input type="hidden" name="id_pegawai" value="<?=$rs['id_peg'];?>">
											<!-- <select class="form-control js-example-basic-multiple hsl"
												name="jabatan_target[]" multiple="multiple" required>
												<?php if($jabatan_jpt){ foreach($jabatan_jpt as $r){ ?>
												<option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?>
												</option>
												<?php } } ?>
											</select> -->
										</div>
									</div>

									<div class="col-lg-3 col-md-4">
										<div class="form-group">
											<button class="btn btn-sm btn-navy float-right btn_simpan_jab_target"
												type="submit"><i class="fa fa-save"></i> SIMPAN</button>
										</div>
									</div>

								</div>
								<span class="mt-2">Jabatan Target :</span><br>
								<?php  foreach($jabatan_target as $jt){ ?>
								<?php if($rs['id_peg'] == $jt['id_peg']) { ?>
								<table class="table table-hover table-striped table-bordered">
									<tr>
										<td valign="top">-</td>
										<td> <b><?=$jt['nama_jabatan'];?> Pada <?=$jt['nm_unitkerja'];?></b>
										</td>
										<td>
											<a onclick="deleteDataJt('<?=$jt['id']?>','jpt')" class="btn btn-sm"> <i
													style="color:red;" class="fa fa-trash"></i> </a>
										</td>
									</tr>
								</table>
								<?php } ?>
								<?php } ?>
						</form>
					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>

	</div>


</div>
</div>
</div>
<!-- tutup jpt -->



<script>
	$(function () {

		$('.js-example-basic-multiple').select2();
		// $('.datatable').dataTable()
		// var tab = "<?= $tab;?>"
		// alert(tab)
		// if (tab == "adm") {
		// 	$('#home-tab').click()
		// } else if (tab == "jpt") {
		// 	$('#profile-tab').click()
		// }
		// $('#profile-tab').click()

	$('.datatable').DataTable({
    displayLength: 25,
	});

	})

	function deleteDataJt(id, tab) {
		if (confirm('Apakah Anda yakin ingin menghapus data?')) {
			$.ajax({
				url: '<?=base_url("simata/C_Simata/deleteDataJabatanTarget/")?>' + id,
				method: 'post',
				data: null,
				success: function () {
					successtoast('Data sudah terhapus')
					loadListPegawaiDinilai(tab)
				},
				error: function (e) {
					errortoast('Terjadi Kesalahan')
				}
			})
		}
	}


	$('.submit_jabatan_target').on('submit', function (event) {
		var base_url = "<?=base_url();?>";
		var count_data = 0;
		event.preventDefault();
       
		$('.hsl').each(function () {
			count_data = count_data + 1;
		});
		console.log(count_data)
		if (count_data > 0) {
			var form_data = $(this).serialize();
			$.ajax({
				url: base_url + "simata/C_Simata/submitJabatanTarget",
				// url:"insert.php",
				method: "post",
				data: form_data,

				success: function (res) {
					console.log(res)
					var result = JSON.parse(res);
					console.log(result)
					if (result.success == true) {
						successtoast(result.msg)
						loadListPegawaiDinilai(result.tab)
					} else {
						errortoast(result.msg)
						return false;
					}

				}
			})
		} else {
			$('#action_alert').html('<p>Please Add atleast one data</p>');
			$('#action_alert').dialog('open');
		}
	});


	// var table = $('.datatable').DataTable();

	//     $('.dataTables_filter input')

	//     .on( 'keyup', function () {
	//         table.column(2).search( this.value ).draw();
	//     } );


    function loadModalInputJT(id,jenis_jabatan){
    $('#form_tambah_rumpun').html('')
    $('#form_tambah_rumpun').append(divLoaderNavy)
    $('#form_tambah_rumpun').load('<?=base_url("simata/C_Simata/loadSelectJabatanTargetPegawai/")?>'+id+'/'+jenis_jabatan, function(){
      $('#loader').hide()
    })
    }

</script>
<?php } else { ?>
<div class="col-12 text-center">
	<h5>DATA TIDAK DITEMUKAN !</h5>
</div>
<?php } ?>
