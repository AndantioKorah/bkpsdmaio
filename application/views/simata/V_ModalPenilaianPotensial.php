<?php
  if($profil_pegawai){
?>
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

	label{
		color:#222e3c;
		font-weight:bold
	}

</style>



<div class="row">
	<div class="col-lg-12">
		<div class="card card-default">
			<div class="row p-3">
				<div class="col-lg-6">
					<div class="row">
						<?php if($profil_pegawai['statuspeg'] == 1){ ?>
						<div class="col-lg-12 text-left">
							<h3><span class="badge">CPNS</span></h3>
						</div>
						<?php } ?>


						<div class="col-lg-12 text-center">
							<!-- <img style="width: 240px; height: 240px" class="img-fluid rounded-circle mb-2 b-lazy"
                  src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== 
                  data-src="<?=$this->general_library->getFotoPegawai($profil_pegawai['fotopeg'])?>" /> -->

							<!-- <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                  src="<?=base_url('fotopeg/')?><?=$profil_pegawai['fotopeg']?>" />  -->

							<div class="foto_container">
								<!-- <img src="<?=$this->general_library->getProfilePicture()?>" style="height: 350px; width: 350px; margin-right: 1px;" 
                            class="img-circle elevation-2 image-settings" alt="User Image"> -->
							<a href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
								<img id="profile_pegawai" class="img-fluid mb-2 b-lazy" src="<?php
                                $path = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($profil_pegawai['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                  //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  $src = './assets/img/user.png';
                                  // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                  $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" />
								</a>
								<div class="middle">
									<!-- <form id="form_profile_pict" action="<?=base_url('kepegawaian/C_Kepegawaian/updateProfilePict')?>" method="post" enctype="multipart/form-data">
                                        <input title="Ubah Foto Profil" class="form-control" accept="image/x-png,image/gif,image/jpeg" type="file" name="profilePict" id="profilePict">
                                    </form> -->
								</div>
							</div>

						</div>



						<div class="col-lg-12 text-center">
							<span class="sp_profil">
							<a style="color:#495057" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
								<?=getNamaPegawaiFull($profil_pegawai)?>
							</a>
								
							</span>
						</div>
						<div class="col-lg-12 text-center">
							<span class="sp_profil">
								<!-- <?=formatNip($profil_pegawai['nipbaru_ws'])?> -->
								<?=$profil_pegawai['nipbaru_ws']?>
							</span>
						</div>
						<div class="col-lg-12 text-center">

						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<!-- profil  -->
						<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
							<li class="nav-item nav-item-profile" role="presentation">
								<button class="nav-link nav-link-profile active" id="pills-data_kepeg-tab"
									data-bs-toggle="pill" data-bs-target="#pills-data_kepeg" type="button" role="tab"
									aria-controls="pills-profile" aria-selected="false">Data Kepegawaian</button>
							</li>
							<!-- <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile " id="pills-data_pribadi-tab" data-bs-toggle="pill" data-bs-target="#pills-data_pribadi" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</button>
              </li>
              
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile" id="pills-data_lain-tab" data-bs-toggle="pill" data-bs-target="#pills-data_lain" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Data Lainnya</button>
              </li> -->
						</ul>

						<div class="col-lg-12">
							<div class="tab-content" id="pills-tabContent">

								<div class="tab-pane show active" id="pills-data_kepeg" role="tabpanel"
									aria-labelledby="pills-data_kepeg-tab">
									<div id="">
										<!-- data kepegawaian  -->
										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Perangkat Daerah
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['nm_unitkerja'])?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Status Kepegawaian
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['nm_statuspeg'])?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Jenis Kepegawaian
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['nm_jenispeg'])?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Pangkat / Gol. Ruang
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['nm_pangkat'])?>
											</span>
										</div>
										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												TMT Pangkat
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=formatDateNamaBulan($profil_pegawai['tmtpangkat'])?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												TMT CPNS
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=formatDateNamaBulan($profil_pegawai['tmtcpns'])?>
											</span>
										</div>


										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Jenis Jabatan
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['nm_jenisjab'])?>
											</span>
										</div>


										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Jabatan
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?php
                  $data = explode("|", $profil_pegawai['data_jabatan']);
                  echo $data[0];
                  ?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Status Jabatan
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?php
                  $data = explode("|", $profil_pegawai['data_jabatan']);
                  if(isset($data[2])) { 
                    if($data[2] == 1) {
                    echo "Definitif"; 
                  } else if($data[2] == 2) {
                    echo "Plt"; 
                  } else if($data[2] == 3) {
                    echo "Plh"; 
                  } else {
                    echo $profil_pegawai['nm_statusjabatan'];
                  }
                  }  
                  ?>

											</span>
										</div>


										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												TMT Jabatan
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?php
                   $data = explode("|", $profil_pegawai['data_jabatan']);
                   if(isset($data[1])) echo formatDateNamaBulan($data[1]);?>
											</span>
										</div>

										<div class="col-lg-12 div_label text-left">
											<span class="sp_label">
												Eselon
											</span>
										</div>
										<div class="col-lg-12 text-left">
											<span class="sp_profil_sm">
												<?=($profil_pegawai['eselon'])?>
											</span>
										</div>
										<!-- end data kepegawaian  -->


									</div>
								</div>


							</div>
						</div>

						<!-- tutup profil  -->
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
				<li class="nav-item nav-item-profile" role="presentation">
					<button style="width:150px;" class="nav-link nav-link-profile active" id="pills-cerdas-tab" data-bs-toggle="pill"
						data-bs-target="#pills-cerdas" type="button" role="tab" aria-controls="pills-profile"
						aria-selected="false">Cerdas</button>
				</li>
				<li class="nav-item nav-item-profile" role="presentation">
					<button style="width:150px;" class="nav-link nav-link-profile " id="pills-data_rj-tab" data-bs-toggle="pill"
						data-bs-target="#pills-rj" type="button" role="tab" aria-controls="pills-home"
						aria-selected="true">Rekam Jejak</button>
				</li>

				<li class="nav-item nav-item-profile" role="presentation">
					<button style="width:150px;" class="nav-link nav-link-profile" id="pills-pertimbangan-tab" data-bs-toggle="pill"
						data-bs-target="#pills-pertimbangan" type="button" role="tab" aria-controls="pills-contact"
						aria-selected="false">Pertimbangan Lainnya</button>
				</li>
			</ul>

			<div class="col-lg-12">
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane show active" id="pills-cerdas" role="tabpanel"
						aria-labelledby="pills-cerdas-tab">
			<form id="form_penilaian_potensial_cerdas" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_peg" value="<?=($profil_pegawai['id_peg'])?>">
				<!-- <input type="hidden" name="id_t_penilaian" value="<?=$id_t_penilaian?>"> -->
				<input type="hidden" name="jenis_jab" id="jenis_jab" value="<?=$kode?>">
				<!-- <input type="hidden" name="jabatan_target" value="<?=$jabatan_target?>"> -->
				<input type="hidden" name="jenis_pengisian" id="jenis_jab" value="<?=$jenis_pengisian?>">

                <?php
                if($nilai_assesment){
                    $nilai = $nilai_assesment['nilai_assesment'];
                } else {
					if($nilai_potensial){
						$nilai = $nilai_potensial['nilai_assesment'];
					} else {
						$nilai = "";
					}
                }
                ?>
                        <label for="exampleInputEmail1" class="form-label">Nilai Assesment</label>

				<input class="form form-control"  type="text" name="nilai_assesment" id="nilai_assesment" value="<?=$nilai;?>" placeholder="Masukkan Nilai" readonly>
				<!-- <button class="btn btn-primary float-right mt-3 mb-3">Simpan</button> -->
			   </form>
					</div>

					<div class="tab-pane show" id="pills-rj" role="tabpanel" aria-labelledby="pills-rj-tab">
					<form id="form_penilaian_potensial_rj" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="rj_id_peg" value="<?=($profil_pegawai['id_peg'])?>">
					<!-- <input type="hidden" name="rj_id_t_penilaian" value="<?=$id_t_penilaian?>"> -->
					<input type="hidden" name="rj_jenis_jab" id="rj_jenis_jab" value="<?=$kode?>">
					<!-- <input type="hidden" name="rj_jabatan_target" value="<?=$jabatan_target?>"> -->
					<input type="hidden" name="rj_jenis_pengisian" id="rj_jenis_pengisian" value="<?=$jenis_pengisian?>">

					<div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pendidikan Formal  </label>
                        <select class="form-select select2" name="rekamjjk1" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
                        <?php if($list_pendidikan_formal){ foreach($list_pendidikan_formal as $r){ ?>
                        <option  <?php if(isset($nilai_potensial['pendidikan_formal'])) { if($nilai_potensial['pendidikan_formal'] == $r['id']) echo "selected"; else if($pendidikan_formal == $r['id'])  echo "selected"; else echo "";} else { if($pendidikan_formal == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pangkat/Golongan Ruang</label>
                        <select class="form-select select2" name="rekamjjk2" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
						<?php if($pangkat_gol){ foreach($pangkat_gol as $r){ ?>
                        <option  <?php if(isset($nilai_potensial['pangkat_gol'])) { if($nilai_potensial['pangkat_gol'] == $r['id']) echo "selected"; else if($pangkatgol == $r['id'])  echo "selected"; else echo "";}  else { if($pangkatgol == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Masa Kerja Jabatan</label>
                        <select class="form-select select2" name="rekamjjk3" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
                        <?php if($masa_kerja_jabatan){ foreach($masa_kerja_jabatan as $r){ ?>
							<option  <?php if(isset($nilai_potensial['masa_kerja_jabatan'])) { if($nilai_potensial['masa_kerja_jabatan'] == $r['id']) echo "selected"; else if($masa_kerja == $r['id'])  echo "selected"; else echo "";}  else { if($masa_kerja == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pendidikan dan Pelatihan Kepemimpinan</label>
                        <select class="form-select select2" name="rekamjjk4" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
						<?php if($diklat){ foreach($diklat as $r){ ?>
							<option  <?php if(isset($nilai_potensial['diklat'])) { if($nilai_potensial['diklat'] == $r['id']) echo "selected"; else if($dklt == $r['id'])  echo "selected"; else echo "";}  else { if($dklt == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pengembangan Kompetensi 20 JP</label>
                        <select class="form-select select2" name="rekamjjk5" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
                        <?php if($kompetensi20_jp){ foreach($kompetensi20_jp as $r){ ?>
                        	<option <?php if(isset($nilai_potensial['kompetensi20_jp'])) { if($nilai_potensial['kompetensi20_jp'] == $r['id']) echo "selected"; else echo "";} else { if($jp_kompetensi == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Penghargaan </label>
                        <select class="form-select select2" name="rekamjjk6" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
						<?php if($penghargaan){ foreach($penghargaan as $r){ ?>
                        <option  <?php if(isset($nilai_potensial['penghargaan'])) { if($nilai_potensial['penghargaan'] == $r['id']) echo "selected"; else if($id_penghargaan == $r['id'])  echo "selected"; else echo "";} else { if($id_penghargaan == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Riwayat Hukuman Disiplin </label>
                        <select class="form-select select2" name="rekamjjk7" required>
                        <option value="0,0,0"  selected>Pilih Item</option>
                        <?php if($riwayat_hukdis){ foreach($riwayat_hukdis as $r){ ?>
							<option  <?php if(isset($nilai_potensial['riwayat_hukdis'])) { if($nilai_potensial['riwayat_hukdis'] == $r['id']) echo "selected"; else if($hukdis == $r['id'])  echo "selected"; else echo "";} else { if($hukdis == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                      
                        <?php } } ?>
                        </select>
                    </div>
                    

                    <button type="submit" class="btn btn-primary float-right mb-3">Simpan</button>
                    </form>
					</div>

                    <div class="tab-pane show" id="pills-pertimbangan" role="tabpanel" aria-labelledby="pills-pertimbangan-tab">
					<form id="form_penilaian_potensial_lainnya" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="lainnya_id_peg" value="<?=($profil_pegawai['id_peg'])?>">
					<!-- <input type="hidden" name="lainnya_id_t_penilaian" value="<?=$id_t_penilaian?>"> -->
					<input type="hidden" name="lainnya_jenis_jab" id="lainnya_jenis_jab" value="<?=$kode?>">
					<!-- <input type="hidden" name="lainnya_jabatan_target" value="<?=$jabatan_target?>"> -->
					<input type="hidden" name="lainnya_jenis_pengisian" id="lainnya_jenis_pengisian" value="<?=$jenis_pengisian?>">

					<div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pengalaman dalam Kepemimpinan Organisasi</label>
						<select class="form-select select2" name="lainnya1" >
                        <option  value="0,0,0"  selected>Pilih Item</option>
                        <?php if($pengalaman_org){ foreach($pengalaman_org as $r){ ?>
                        <option  <?php if($nilai_potensial) { if($nilai_potensial['pengalaman_organisasi'] == $r['id']) echo "selected"; else if($porganisasi == $r['id'])  echo "selected"; else echo "";} else { if($porganisasi == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pertimbangan Pimpinan</label>
                        <select class="form-select select2" name="lainnya2" >
                        <option  value="0,0,0"  selected>Pilih Item</option>
                        <?php if($aspirasi_karir){ foreach($aspirasi_karir as $r){ ?>
                        <option  <?php if($nilai_potensial) { if($nilai_potensial['aspirasi_karir'] == $r['id']) echo "selected"; else echo "";}?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Survey Pegawai ASN</label>
                        <select class="form-select select2" name="lainnya3" >
                        <option  value="0,0,0"  selected>Pilih Item</option>
                        <?php if($asn_ceria){ foreach($asn_ceria as $r){ ?>
                        <option  <?php if($nilai_potensial) { if($nilai_potensial['asn_ceria'] == $r['id']) echo "selected"; else echo "";}?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                        <?php } } ?>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary float-right mb-3">Simpan</button>
                    </form>
					</div>

				</div>
			</div>
			
		</div>
	</div>

    <!-- <div class="modal-footer" style="margin-bottom:5px;">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div> -->

	<script>
		// // blok enter 
		// $(document).ready(function() {
		// $(window).keydown(function(event){
		// 	if(event.keyCode == 13) {
		// 	event.preventDefault();
		// 	return false;
		// 	}
		// });
		// });
		// // blok enter 

		$(function () {


			$(".select2").select2({
				width: '100%',
				// dropdownAutoWidth: true,
				allowClear: true,
			});

		})

			$('#form_penilaian_potensial_cerdas').on('submit', function (e) {
				var kode = $('#jenis_jab').val()

				e.preventDefault();
				var formvalue = $('#form_penilaian_potensial_cerdas');
				var form_data = new FormData(formvalue[0]);

				$.ajax({
					url: "<?=base_url("simata/C_Simata/submitPenilaianPotensialCerdas")?>",
					method: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					// dataType: "json",
					success: function (res) {
						console.log(res)
						var result = JSON.parse(res);
						console.log(result)
						if (result.success == true) {
							successtoast(result.msg)
							// setTimeout(function () {
							// 	$("#modal_penilaian_kinerja").trigger("click");
							// }, 500);
							if (kode == 1) {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode),
									1000);
							} else {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode),
									1000);
							}
						

						} else {
							errortoast(result.msg)
							return false;
						}

					}
				});

			});


			$('#form_penilaian_potensial_rj').on('submit', function (e) {
			
				var kode = $('#rj_jenis_jab').val()
				var jenis_pengisian = $('#rj_jenis_pengisian').val()
				e.preventDefault();
				var formvalue = $('#form_penilaian_potensial_rj');
				var form_data = new FormData(formvalue[0]);
				// const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialAdm,1000);
				
				$.ajax({
					url: "<?=base_url("simata/C_Simata/submitPenilaianPotensialRj")?>",
					method: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					// dataType: "json",
					success: function (res) {
						console.log(res)
						var result = JSON.parse(res);
						console.log(result)
						if (result.success == true) {
							successtoast(result.msg)
							if (kode == 1) {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode,jenis_pengisian),
									1000);
							} else {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode,jenis_pengisian),
									1000);
							}
						
						} else {
							errortoast(result.msg)
							return false;
						}

					}
				});

			});

	
			$('#form_penilaian_potensial_lainnya').on('submit', function (e) {
			
			var kode = $('#lainnya_jenis_jab').val()
			var jenis_pengisian = $('#lainnya_jenis_pengisian').val()

			e.preventDefault();
			var formvalue = $('#form_penilaian_potensial_lainnya');
			var form_data = new FormData(formvalue[0]);
			// const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialAdm,1000);
			
			$.ajax({
				url: "<?=base_url("simata/C_Simata/submitPenilaianPotensialLainnya")?>",
				method: "POST",
				data: form_data,
				contentType: false,
				cache: false,
				processData: false,
				// dataType: "json",
				success: function (res) {
					console.log(res)
					var result = JSON.parse(res);
					console.log(result)
					if (result.success == true) {
						successtoast(result.msg)
						if (kode == 1) {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode,jenis_pengisian),
									1000);
							} else {
								const myTimeout = setTimeout(loadListPegawaiPenilaianPotensialJpt(kode,jenis_pengisian),
									1000);
							}
						
					} else {
						errortoast(result.msg)
						return false;
					}

				}
			});

		});

		

	</script>
	<?php } else { ?>
	<div class="row">
		<div class="col-lg-12 text-center">
			<h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
		</div>
	</div>
	<?php } ?>
