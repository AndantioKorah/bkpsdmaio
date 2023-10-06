<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->getRole() == 'admin_aplikasi') { ?>
<style>
	.sp_profil {
		font-size: .9rem;
		font-weight: bold;
	}

	.sp_profil_sm {
		font-size: .8rem;
		font-weight: bold;
	}

	.hr_class {
		margin-top: 0px;
		margin-bottom: 0px;
		border: .05rem solid black;
	}

	.sp_profil_alamat {
		/* line-height: 100px; */
	}

	.sp_label {
		font-size: .6rem;
		font-style: italic;
		font-weight: 600;
		color: grey;
	}

	.div_label {
		margin-bottom: -5px;
	}

	.nav-link-profile {
		padding: 5px !important;
		font-size: .7rem;
		color: black;
		border: .5px solid var(--primary-color) !important;
		border-bottom-left-radius: 0px;
	}

	.nav-item-profile:hover,
	.nav-link-profile:hover {
		color: white !important;
		background-color: #222e3c91;
	}

	.nav-tabs .nav-link.active,
	.nav-tabs .show>.nav-link {
		/* border-radius: 3px; */
		background-color: var(--primary-color);
		color: white;
	}

	.div.dataTables_wrapper div.dataTables_length select {
		height: 10px !important;
		width: 40px !important;
	}

	.div.dataTables_wrapper div.dataTables_filter input {
		height: 10px !important;
	}

	#profile_pegawai {
		width: 250px;
		height: calc(250px * 1.25);
		background-size: cover;
		/* object-fit: contain; */
		box-shadow: 5px 5px 10px #888888;
		border-radius: 10%;
	}

	/* .badge{
      box-shadow: 3px 3px 10px #888888;
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
    } */

	.foto_container {
		position: relative;
		/* width: 50%; */
	}

	.image-settings {
		opacity: 1;
		display: block;
		/* width: 100%; */
		height: auto;
		transition: .5s ease;
		backface-visibility: hidden;
	}

	.middle {
		transition: .5s ease;
		opacity: 0;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		text-align: center;
	}

	.foto_container:hover .image {
		opacity: 0.3;
		cursor: pointer;
	}

	.foto_container:hover .middle {
		opacity: 1;
		cursor: pointer;
	}

</style>
<div class="card card-default">

	<div class="card-body div_form_tambah_interval" id="div_form_tambah_interval">
		<form method="post" id="form_cari" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-12 col-md-4">
					<div class="form-group">
						<label class="bmd-label-floating">Pilih Unit Kerja </label>
						<select class="form-control select2 " data-dropdown-css-class="select2-navy" name="unit_kerja"
							id="unit_kerja" required>
							<option value="0" disabled selected>Pilih Unit kerja</option>
							<?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
							<option value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
							<?php } } ?>
						</select>
					</div>
				</div>




				<div class="col-lg-8 col-md-8"></div>
				<div class="col-lg-12 col-md-4 text-right mt-2">
					<button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-search"></i> CARI</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div class="card card-default">
	<div class="card-header">
		<div class="col-3">
			<h3 class="card-title"></h3>
		</div>
	</div>
	<div class="card-body" style="margin-top:-20px;">
		<div id="list_pegawai">

		</div>
	</div>
</div>

<?php } ?>

<script>
	$(function () {


		$(".select2").select2({
			width: '100%',
			dropdownAutoWidth: true,
			allowClear: true,
		});

		loadListPegawaiDinilai(tab = null)
	})

	function loadListPegawaiDinilai(tab = null) {

		var id = $('#unit_kerja').val()
		$('#list_pegawai').html('')
		$('#list_pegawai').append(divLoaderNavy)
		$('#list_pegawai').load('<?=base_url("simata/C_Simata/loadListPegawaiDinilai/")?>' + id + '/' + tab, function () {
			$('#loader').hide()
		})

	}

	$('#form_cari').on('submit', function (e) {

		e.preventDefault();
		var formvalue = $('#form_cari');
		var form_data = new FormData(formvalue[0]);
		loadListPegawaiDinilai()


	});

</script>
