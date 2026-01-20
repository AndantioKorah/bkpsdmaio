<?php if($result){ $rs = $result; ?>
	<div class="row p-3">
		<div class="col-lg-12">
			<form method="post" id="form_input_kegiatan_edit" enctype="multipart/form-data" >
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
						<input required class="form-control" type="time" name="jam_mulai" id="jam_mulai_edit" value="<?=$rs['jam_mulai']?>" />
					</div>
					<div class="col-lg-4 mt-1">
						<label class="lbl-form-input-kegiatan">Jam Selesai</label>
						<input class="form-control" type="time" name="jam_selesai" id="jam_selesai_edit" value="<?=$rs['jam_selesai']?>" />
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
						<label class="lbl-form-input-kegiatan">Jam Batas Absensi</label>
						<input required class="form-control" type="time" name="jam_batas_absensi" id="jam_batas_absensi_edit" value="<?=$rs['jam_batas_absensi']?>"/>
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
						<input required class="form-control" type="time" name="jam_batas_pendaftaran" id="jam_batas_pendaftaran_edit" value="<?=$rs['jam_batas_pendaftaran']?>"/>
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
						<button id="btn_simpan_edit" class="btn btn-navy btn-block" type="submit"><i class="fa fa-save"></i> Simpan</button>
						<button id="btn_simpan_loading_edit" style="display: none;" disabled class="btn btn-navy btn-block" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan Data</button>
					</div>
				</div>
			</form>
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
</script>