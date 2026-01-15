<style>
	.lbl-form-input-kegiatan{
		font-size: .8rem;
		color: grey;
		font-weight: bold;
		font-style: italic;
	}

	.lbl-form-divider{
		font-size: .9rem;
		color: black;
		font-weight: bold;
	}
</style>
<div class="card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
				<h4>Manage Kegiatan</h4>
				<button onclick="$('#div_form_input_kegiatan').toggle(300)" class="btn btn-block btn-navy" type="button"><i class="fa fa-plus"></i> Tambah Kegiatan Baru</button>
				<hr>
			</div>
			<div id="div_form_input_kegiatan" style="display:none;" class="col-lg-12">
					 <form method="post" id="form_input_kegiatan" enctype="multipart/form-data" >
					<div class="row">
						<div class="col-lg-9">
							<label  cass="lbl-form-input-kegiatan">Topik:</label>
							<input required id="topik" class="form-control" name="topik" />
						</div>
						<div class="col-lg-3">
							<label class="lbl-form-input-kegiatan">Tipe Kegiatan:</label>
							<select class="form-control select2-navy" style="width: 100%"
								id="tipe_kegiatan" data-dropdown-css-class="select2-navy" name="tipe_kegiatan">
								<option value="1">Internal</option>
								<option value="2">Umum</option>
							</select>
						</div>
						<div class="col-lg-12 mt-3">
							<label class="lbl-form-divider">Waktu Pelaksanaan</label>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Tanggal:</label>
							<input required class="form-control" name="tanggal" id="tanggal" readonly value="<?=date('Y-m-d')?>" />
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Jam Mulai</label>
							<input required class="form-control" type="time" name="jam_mulai" id="jam_mulai"/>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Jam Selesai</label>
							<input class="form-control" type="time" name="jam_selesai" id="jam_selesai"/>
							<div>
								<input style="accent-color: green;" type="checkbox" id="chck_selesai" name="chck_selesai" />
								<label for="chck_selesai" id="lbl_sampai_selesai"><i>Sampai Selesai</i></label>
							</div>
						</div>
						<div class="col-lg-12">
							<hr>
						</div>
						<div class="col-lg-12">
							<label class="lbl-form-divider">Batas Absensi</label>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Tanggal:</label>
							<input required class="form-control" name="tanggal_batas_absensi" id="tanggal_batas_absensi" readonly value="<?=date('Y-m-d')?>" />
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Jam Batas Absensi</label>
							<input required class="form-control" type="time" name="jam_batas_absensi" id="jam_batas_absensi"/>
						</div>
						<div class="col-lg-12">
							<hr>
						</div>
						<div class="col-lg-12">
							<label class="lbl-form-divider">Batas Pendaftaran</label>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Tanggal:</label>
							<input required class="form-control" name="tanggal_batas_pendaftaran" id="tanggal_batas_pendaftaran" readonly value="<?=date('Y-m-d')?>" />
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Jam Batas Pendaftaran</label>
							<input required class="form-control" type="time" name="jam_batas_pendaftaran" id="jam_batas_pendaftaran"/>
						</div>
						<div class="col-lg-12">
							<hr>
						</div>
						<div class="col-lg-12">
							<label class="lbl-form-divider">Zoom</label>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Link Zoom:</label>
							<input class="form-control" name="link_zoom" id="link_zoom"/>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Meeting ID:</label>
							<input class="form-control" name="meeting_id_zoom" id="meeting_id_zoom"/>
						</div>
						<div class="col-lg-4 mt-1">
							<label class="lbl-form-input-kegiatan">Passcode:</label>
							<input class="form-control" name="passcode_zoom" id="passcode_zoom"/>
						</div>
						<div class="col-lg-12">
							<hr>
						</div>
						<div class="col-lg-12">
							<label class="lbl-form-divider">Media Sosial Lainnya</label>
						</div>
						<div class="col-lg-6 mt-1">
							<label class="lbl-form-input-kegiatan">Link YouTube:</label>
							<input class="form-control" name="link_youtube" id="link_youtube"/>
						</div>
						<div class="col-lg-6 mt-1">
							<label class="lbl-form-input-kegiatan">Link Facebook:</label>
							<input class="form-control" name="link_facebook" id="link_facebook"/>
						</div>
						

						<div class="col-lg-12 mt-2">
							<label class="lbl-form-divider">Banner</label>
						</div>
						
						<div class="col-lg-12 mt-1">
						 <input class="form-control" type="file" id="banner_file" name="file"  />
						</div>
						<div class="col-lg-12 text-right">
							<hr>
							<button id="btn_simpan" class="btn btn-navy btn-block" type="submit"><i class="fa fa-save"></i> Simpan Kegiatan</button>
							<button id="btn_simpan_loading" style="display: none;" disabled class="btn btn-navy btn-block" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan Data</button>
						</div>

						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="mt-3 card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
				<h4>List Kegiatan</h4>
				<hr>
			</div>
			<div id="div_list_kegiatan" class="col-lg-12">
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){
		$('#tipe_kegiatan').select2()
		refreshDatePicker()
		loadListKegiatan()
	})

	function refreshDatePicker(){
		$('#tanggal').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			todayBtn: true
		})

		$('#tanggal_batas_absensi').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			startDate: $('#tanggal').val()
		})

		$('#tanggal_batas_pendaftaran').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			endDate: $('#tanggal').val()
		})
	}

	function loadListKegiatan(){
		$('#div_list_kegiatan').html()
		$('#div_list_kegiatan').append(divLoaderNavy)
		$('#div_list_kegiatan').load('<?=base_url("bacirita/C_Bacirita/loadListKegiatan")?>', function(){
			$('#loader').hide()
		})
	}

	$('#form_input_kegiatan').on('submit', function(e){
		e.preventDefault()
		// $('#btn_simpan').hide()
		// $('#btn_simpan_loading').show()
		var formvalue = $('#form_input_kegiatan');
		var form_data = new FormData(formvalue[0]);

		$.ajax({  
        url: '<?=base_url("bacirita/C_Bacirita/saveDataKegiatan")?>',
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
           success: function(data){
                let resp = JSON.parse(data)
                if(resp.code == 0){
                    $('#topik').val('')
					$('#div_form_input_kegiatan').hide()
					successtoast('Data berhasil disimpan')
					loadListKegiatan()
                } else {
                    errortoast(resp.message)
                }
				$('#btn_simpan').show()
				$('#btn_simpan_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
				$('#btn_simpan').show()
				$('#btn_simpan_loading').hide()
            }  
        });
	})
</script>