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

		.lbl_field_name{
			font-weight: bold;
			font-size: 1rem;
		}

		.lbl_field_detail{
			font-weight: bold;
			font-size: .7rem;
			font-style: italic;
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
								<label class="lbl-form-divider">Absensi</label>
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
								<div class="form-check form-switch">
									<input style="cursor: pointer;" class="form-check-input" type="checkbox" role="switch" <?=$rs['flag_buka_absen'] == 1 ? 'checked' : ''?> id="flag_buka_absen">
									<label class="form-check-label" for="flag_buka_absen">Buka Presensi</label>
								</div>
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
					<div class="row">
						<div class="col-lg-12">
							<form method="post" id="form_upload_template_sertifikat" enctype="multipart/form-data" >
								<input type="hidden" name="id_kegiatan_template" id="id_kegiatan_template" value="<?=$rs['id']?>">
									<div class="col-lg-12 mt-2">
										<label class="lbl-form-divider">Template Sertifikat</label>
									</div>
									<div class="col-lg-12 mt-1">
										<input class="form-control" type="file" id="template_file_edit" name="file"  />
									</div>
									<div class="col-lg-12 mt-2 text-right">
										<button id="btn_simpan_edit" class="btn btn-navy btn-block" ><i class="fa fa-save"></i> Simpan</button>
										<button id="btn_simpan_loading_edit" style="display: none;" disabled class="btn btn-navy btn-block" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan Data</button>
										<hr>
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-12 mt-2">
							<?php
								$srcIframe = base_url().$rs['template_sertifikat'];
								if($rs['template_sertifikat']){
									$coordinate = null;
									if($rs['meta_coordinate']){
										$coordinate = json_decode($rs['meta_coordinate'], true);
									}
									$explode = explode(".", $rs['template_sertifikat']);
									$previewFile = base_url().$explode[0]."_preview.pdf";
									$srcIframe = $previewFile;
							?>
								<div class="row">
									<div class="col-lg-8">
										<div class="form-check form-switch">
											<input style="cursor: pointer;" class="form-check-input" type="checkbox" role="switch" <?=$rs['flag_download_sertifikat'] == 1 ? 'checked' : ''?> id="flag_download_sertifikat">
											<label class="form-check-label" for="flag_download_sertifikat">Download Sertifikat</label>
										</div>
										<iframe id="iframe_preview" src="<?=$srcIframe."?v=".generateRandomNumber(6)?>" style="
											width: 100%;
											height: 80vh;
										"></iframe>
									</div>
									<div class="col-lg-4">
										<form id="form_preview_sertifikat">
											<div class="row">
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('nomor_surat', 0)" id="icon_nomor_surat_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['nomor_surat']) && $coordinate['nomor_surat']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('nomor_surat', 1)" id="icon_nomor_surat_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['nomor_surat']) && $coordinate['nomor_surat']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														Nomor Surat 
													</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nomor_surat"]['margin-top']) ? ($coordinate["nomor_surat"]['margin-top']) : 0 ;?>" name="nomor_surat[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nomor_surat"]['margin-left']) ? ($coordinate["nomor_surat"]['margin-left']) : 0 ;?>" name="nomor_surat[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nomor_surat"]['font-size']) ? ($coordinate["nomor_surat"]['font-size']) : 0 ;?>" name="nomor_surat[font-size]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('nama_lengkap', 0)" id="icon_nama_lengkap_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['nama_lengkap']) && $coordinate['nama_lengkap']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('nama_lengkap', 1)" id="icon_nama_lengkap_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['nama_lengkap']) && $coordinate['nama_lengkap']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														Nama Pegawai</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nama_lengkap"]['margin-top']) ? ($coordinate["nama_lengkap"]['margin-top']) : 0 ;?>" name="nama_lengkap[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nama_lengkap"]['margin-left']) ? ($coordinate["nama_lengkap"]['margin-left']) : 0 ;?>" name="nama_lengkap[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nama_lengkap"]['font-size']) ? ($coordinate["nama_lengkap"]['font-size']) : 0 ;?>" name="nama_lengkap[font-size]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('nip', 0)" id="icon_nip_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['nip']) && $coordinate['nip']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('nip', 1)" id="icon_nip_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['nip']) && $coordinate['nip']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														NIP</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nip"]['margin-top']) ? ($coordinate["nip"]['margin-top']) : 0 ;?>" name="nip[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nip"]['margin-left']) ? ($coordinate["nip"]['margin-left']) : 0 ;?>" name="nip[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["nip"]['font-size']) ? ($coordinate["nip"]['font-size']) : 0 ;?>" name="nip[font-size]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('jabatan', 0)" id="icon_jabatan_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['jabatan']) && $coordinate['jabatan']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('jabatan', 1)" id="icon_jabatan_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['jabatan']) && $coordinate['jabatan']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														Jabatan</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["jabatan"]['margin-top']) ? ($coordinate["jabatan"]['margin-top']) : 0 ;?>" name="jabatan[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["jabatan"]['margin-left']) ? ($coordinate["jabatan"]['margin-left']) : 0 ;?>" name="jabatan[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["jabatan"]['font-size']) ? ($coordinate["jabatan"]['font-size']) : 0 ;?>" name="jabatan[font-size]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('unit_kerja', 0)" id="icon_unit_kerja_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['unit_kerja']) && $coordinate['unit_kerja']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('unit_kerja', 1)" id="icon_unit_kerja_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['unit_kerja']) && $coordinate['unit_kerja']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														Unit Kerja</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["unit_kerja"]['margin-top']) ? ($coordinate["unit_kerja"]['margin-top']) : 0 ;?>" name="unit_kerja[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["unit_kerja"]['margin-left']) ? ($coordinate["unit_kerja"]['margin-left']) : 0 ;?>" name="unit_kerja[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["unit_kerja"]['font-size']) ? ($coordinate["unit_kerja"]['font-size']) : 0 ;?>" name="unit_kerja[font-size]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12">
													<label class="lbl_field_name">
														<i onclick="toggleFieldPreview('qr', 0)" id="icon_qr_show" class="fa fa-eye" style="margin-top: 4px; padding-right: 5px;float: left; color: green; cursor: pointer; display: <?=isset($coordinate['qr']) && $coordinate['qr']['flag_show'] == 1 ? 'block' : 'none';?>"></i>
														<i onclick="toggleFieldPreview('qr', 1)" id="icon_qr_hide" class="fa fa-eye-slash" style="margin-top: 4px; padding-right: 5px;float: left; color: grey; cursor: pointer; display: <?=isset($coordinate['qr']) && $coordinate['qr']['flag_show'] == 1 ? 'none' : 'block';?>"></i>
														QR</label>
													<div class="row">
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Top</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["qr"]['margin-top']) ? ($coordinate["qr"]['margin-top']) : 0 ;?>" name="qr[margin-top]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Left</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["qr"]['margin-left']) ? ($coordinate["qr"]['margin-left']) : 0 ;?>" name="qr[margin-left]"/>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4">
															<label class="lbl_field_detail">Size</label>
															<input class="form-control form-control-sm" value="<?=isset($coordinate["qr"]['width']) ? ($coordinate["qr"]['width']) : 0 ;?>" name="qr[width]"/>
														</div>
													</div>
													<hr>
												</div>
												<div class="col-lg-12 text-right">
													<button id="btn_simpan_preview" type="submit" class="btn btn-navy btn-sm">Preview</button>
													<button id="btn_simpan_preview_loading" style="display: none;" type="button" disabled class="btn btn-navy btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							<?php } else { ?>
								<div class="text-center">
									<h5 style="color: red; font-style: italic;">Belum Ada Template Sertifikat <i class="fa fa-exclamation"></i></h5>
								</div>
							<?php } ?>
						</div>
					</div>
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
		refreshIframePreview()
	})

	function refreshIframePreview(){
		$('#iframe_preview')[0].contentWindow.location.reload(true)
	}

	$('#flag_buka_absen').on('change', function(){
		id = '<?=$rs['id']?>'
		state_download_sertifikat = 0
		if($('#flag_buka_absen').is(':checked')){
			state_download_sertifikat = 1
		}
		$.ajax({  
		url: '<?=base_url("bacirita/C_Bacirita/toggleBukaAbsensi/")?>'+id+'/'+state_download_sertifikat,
		method:"POST",  
		success: function(data){
				let resp = JSON.parse(data)
				if(resp.code == 0){
					successtoast('Berhasil disimpan')
				} else {
					errortoast(resp.message)
				}
			}, error: function(e){
				errortoast('Terjadi Kesalahan')
			}  
		})
	})

	$('#flag_download_sertifikat').on('change', function(){
		id = '<?=$rs['id']?>'
		state_download_sertifikat = 0
		if($('#flag_download_sertifikat').is(':checked')){
			state_download_sertifikat = 1
		}
		$.ajax({  
		url: '<?=base_url("bacirita/C_Bacirita/toggleDownloadSertifikat/")?>'+id+'/'+state_download_sertifikat,
		method:"POST",  
		success: function(data){
				let resp = JSON.parse(data)
				if(resp.code == 0){
					successtoast('Berhasil disimpan')
				} else {
					errortoast(resp.message)
				}
			}, error: function(e){
				errortoast('Terjadi Kesalahan')
			}  
		})
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

	function toggleFieldPreview(nama_field, flag_show){
		id = '<?=$rs['id']?>'
		$.ajax({  
		url: '<?=base_url("bacirita/C_Bacirita/toggleFieldPreview/")?>'+nama_field+'/'+flag_show+'/'+id,
		method:"POST",  
		success: function(data){
				let resp = JSON.parse(data)
				if(resp.code == 0){
					refreshIframePreview()
					if(flag_show == 1){
						$('#icon_'+nama_field+'_hide').hide()
						$('#icon_'+nama_field+'_show').show()
					} else {
						$('#icon_'+nama_field+'_hide').show()
						$('#icon_'+nama_field+'_show').hide()
					}
				} else {
					errortoast(resp.message)
				}
			}, error: function(e){
				errortoast('Terjadi Kesalahan')
			}  
		})
	}

	$('#form_preview_sertifikat').on('submit', function(e){
		// $('#btn_simpan_preview').hide()
		// $('#btn_simpan_preview_loading').show()
		e.preventDefault()
		$.ajax({  
		url: '<?=base_url("bacirita/C_Bacirita/saveCoordinateSertifikat/".$rs['id'])?>',
		method:"POST",  
		data: $(this).serialize(),  
		success: function(data){
				let resp = JSON.parse(data)
				if(resp.code == 0){
					refreshIframePreview()
					successtoast('Data Berhasil Disimpan')
				} else {
					errortoast(resp.message)
				}
				$('#btn_simpan_preview').show()
				$('#btn_simpan_preview_loading').hide()
			}, error: function(e){
				errortoast('Terjadi Kesalahan')
				$('#btn_simpan_preview').show()
				$('#btn_simpan_preview_loading').hide()
			}  
		});
	})

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
					openDetailModal('<?=$rs["id"]?>')
                    // $('#topik').val('')
					// $('#div_form_edit_kegiatan').hide()
					// successtoast('Data berhasil disimpan')
					// loadListKegiatan()
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