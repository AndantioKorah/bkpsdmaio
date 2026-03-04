<?php if($result){ $rs = $result; ?>
	<style>
		.nav-link-bacirita{
			padding: 5px !important;
			font-size: .7rem;
			color: black;
			border: .5px solid var(--primary-color) !important;
			border-bottom-left-radius: 0px;
		}

		.nav-item-bacirita:hover, .nav-link-bacirita:hover{
			color: white !important;
			background-color: #222e3c91;
		}

		.nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
			/* border-radius: 3px; */
			background-color: var(--primary-color);
			color: white;
		}
	</style>
	<div class="row p-3">
		<div class="col-lg-12">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
				<li class="nav-item nav-item-bacirita" role="presentation">
					<button class="nav-link nav-link-bacirita active" id="pills-kegiatan-tab"
					data-bs-toggle="pill" data-bs-target="#pills-kegiatan" type="button" role="tab" aria-selected="true">Kegiatan</button>
				</li>
				<li class="nav-item nav-item-bacirita" role="presentation">
					<button class="nav-link nav-link-bacirita" id="pills-sertifikat-tab"
					data-bs-toggle="pill" data-bs-target="#pills-sertifikat" type="button" role="tab" aria-selected="true">Sertifikat</button>
				</li>
			</ul>
		</div>
		<div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
				<div class="tab-pane show active" id="pills-kegiatan" role="tabpanel" aria-labelledby="pills-kegiatan-tab">
					<form method="post" id="form_edit_kegiatan" enctype="multipart/form-data" >
						<input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?=$rs['id']?>">
						<div class="row">
							<div class="col-lg-9">
								<label cass="lbl-form-input-kegiatan">Topik:</label>
								<input value="<?=$rs['topik']?>" required id="topik_edit" class="form-control" name="topik" />
							</div>
							<div class="col-lg-3">
								<label class="lbl-form-input-kegiatan">Tipe Kegiatan:</label>
								<select class="form-control select2-navy" style="width: 100%"
									id="tipe_kegiatan_edit" data-dropdown-css-class="select2-navy" name="tipe_kegiatan">
									<option <?=$rs['id_m_tipe_kegiatan'] == 1 ? "selected" : ""?> value="1">Internal</option>
									<option <?=$rs['id_m_tipe_kegiatan'] == 2 ? "selected" : ""?> value="2">Umum</option>
								</select>
							</div>
							<div class="col-lg-12 mt-3">
								<label class="lbl-form-divider">Waktu Pelaksanaan</label>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Tanggal:</label>
								<input required class="form-control" name="tanggal" id="tanggal_edit" readonly value="<?=$rs['tanggal']?>" />
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Jam Mulai</label>
								<input required class="form-control" type="time" name="jam_mulai" id="jam_mulai_edit" value="<?= substr($rs['jam_mulai'], 0, 5);?>" />
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Jam Selesai</label>
								<input class="form-control" type="time" name="jam_selesai" id="jam_selesai_edit" value="<?= substr($rs['jam_selesai'], 0, 5); ?>" />
								<div>
									<input style="accent-color: green;" type="checkbox" id="chck_selesai_edit" name="chck_selesai" <?=formatTimeAbsen($rs['jam_selesai']) == "00:00" ? "checked" : ""?> />
									<label for="chck_selesai" id="lbl_sampai_selesai_edit"><i>Sampai Selesai</i></label>
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
								<input required class="form-control" name="tanggal_batas_absensi" id="tanggal_batas_absensi_edit" readonly value="<?=$rs['tanggal_batas_absensi']?>" />
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Jam Buka Absensi</label>
								<input required class="form-control" type="time" name="jam_buka_absensi" id="jam_buka_absensi_edit" value="<?= substr($rs['jam_buka_absensi'], 0, 5);?>"/>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Jam Tutup Absensi</label>
								<input required class="form-control" type="time" name="jam_batas_absensi" id="jam_batas_absensi_edit" value="<?= substr($rs['jam_batas_absensi'], 0, 5);?>"/>
							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-lg-12">
								<label class="lbl-form-divider">Batas Pendaftaran</label>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Tanggal:</label>
								<input required class="form-control" name="tanggal_batas_pendaftaran" id="tanggal_batas_pendaftaran_edit" readonly value="<?=$rs['tanggal_batas_pendaftaran']?>"/>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Jam Batas Pendaftaran</label>
								<input required class="form-control" type="time" name="jam_batas_pendaftaran" id="jam_batas_pendaftaran_edit" value="<?= substr($rs['jam_batas_pendaftaran'], 0, 5);?>"/>
							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-lg-12">
								<label class="lbl-form-divider">Zoom</label>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Link Zoom:</label>
								<input class="form-control" name="link_zoom" id="link_zoom_edit" value="<?=$rs['link_zoom']?>"/>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Meeting ID:</label>
								<input class="form-control" name="meeting_id_zoom" id="meeting_id_zoom_edit" value="<?=$rs['meeting_id_zoom']?>"/>
							</div>
							<div class="col-lg-4 mt-1">
								<label class="lbl-form-input-kegiatan">Passcode:</label>
								<input class="form-control" name="passcode_zoom" id="passcode_zoom_edit" value="<?=$rs['passcode_zoom']?>"/>
							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-lg-12">
								<label class="lbl-form-divider">Media Sosial Lainnya</label>
							</div>
							<div class="col-lg-6 mt-1">
								<label class="lbl-form-input-kegiatan">Link YouTube:</label>
								<input class="form-control" name="link_youtube" id="link_youtube_edit" value="<?=$rs['link_youtube']?>"/>
							</div>
							<div class="col-lg-6 mt-1">
								<label class="lbl-form-input-kegiatan">Link Facebook:</label>
								<input class="form-control" name="link_facebook" id="link_facebook_edit" value="<?=$rs['link_facebook']?>"/>
							</div>
							<div class="col-lg-12 mt-2">
								<label class="lbl-form-divider">Banner</label>
							</div>
							<div class="col-lg-12 mt-1">
								<input class="form-control" type="file" id="banner_file_edit" name="file"  />
							</div>
							<div class="col-lg-12 text-right">
								<hr>
								<button id="btn_simpan_edit" class="btn btn-navy btn-block" ><i class="fa fa-save"></i> Simpan</button>
								<button id="btn_simpan_loading_edit" style="display: none;" disabled class="btn btn-navy btn-block" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan Data</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="pills-sertifikat" role="tabpanel" aria-labelledby="pills-sertifikat-tab">
					<form method="post" id="form_upload_template_sertifikat" enctype="multipart/form-data" >
						<input type="hidden" name="id_kegiatan_template" id="id_kegiatan_template" value="<?=$rs['id']?>">
							<div class="col-lg-12 mt-2">
								<label class="lbl-form-divider">Template Sertifikat</label>
							</div>
							<div class="col-lg-12 mt-1">
								<input class="form-control" type="file" id="template_file_edit" name="file"  />
							</div>
							<div class="col-lg-12 text-right">
								<hr>
								<button id="btn_simpan_edit" class="btn btn-navy btn-block" ><i class="fa fa-save"></i> Simpan</button>
								<button id="btn_simpan_loading_edit" style="display: none;" disabled class="btn btn-navy btn-block" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan Data</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<script>
	$(function(){
		$('#tipe_kegiatan_edit').select2()
		refreshDatePicker()
		// loadListKegiatan()
	})

	function refreshDatePicker(){
		$('#tanggal_edit').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			todayBtn: true
		})

		$('#tanggal_batas_absensi_edit').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			startDate: $('#tanggal_edit').val()
		})

		$('#tanggal_batas_pendaftaran_edit').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			endDate: $('#tanggal_edit').val()
		})
	}

	$('#form_edit_kegiatan').on('submit', function(e){
		e.preventDefault()
		// $('#btn_simpan').hide()
		// $('#btn_simpan_loading').show()
		var formvalue = $('#form_edit_kegiatan');
		var form_data = new FormData(formvalue[0]);

		$.ajax({  
        url: '<?=base_url("bacirita/C_Bacirita/editDataKegiatan")?>',
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
					$('#div_form_edit_kegiatan').hide()
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

	$('#form_upload_template_sertifikat').on('submit', function(e){
		e.preventDefault()
		// $('#btn_simpan').hide()
		// $('#btn_simpan_loading').show()
		var formvalue = $('#form_upload_template_sertifikat');
		var form_data = new FormData(formvalue[0]);

		$.ajax({  
        url: '<?=base_url("bacirita/C_Bacirita/updloadTemplateSertifikat")?>',
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
					$('#div_form_edit_kegiatan').hide()
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