<?php
  if($profil_pegawai){
?>
<style>
	/* .sp_profil {
		font-size: .9rem;
		font-weight: bold;
	}

	.sp_profil_sm {
		font-size: .9rem;
		font-weight: bold;
	}

	.hr_class {
		margin-top: 0px;
		margin-bottom: 0px;
		border: .05rem solid black;
	}


	.sp_label {
		font-size: .8rem;
		font-style: italic;
		font-weight: 600;
		color: grey;
	} */

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
		/* height: auto; */
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

	/* .foto_container:hover .middle {
		opacity: 1;
		cursor: pointer;
	}

	label{
		color:#222e3c;
		font-weight:bold
	} */

</style>



<div class="row">
	<div class="col-lg-12">
		<div class="card card-default" style="background-color:#e1e1e1;">
			<div class="row p-3">
				<div class="col-lg-4">
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
								<img id="profile_pegawai" class="img-fluid mb-2 b-lazy" style="height: 220px; width: 200px; margin-right: 1px;"  src="<?php
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
				<div class="col-lg-8" >
					<div class="row">
						<!-- profil  -->
						<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
							<li class="nav-item nav-item-profile" role="presentation">
								<button class="nav-link nav-link-profile active" id="pills-kinerja-tab"
									data-bs-toggle="pill" data-bs-target="#pills-kinerja" type="button" role="tab"
									aria-controls="pills-profile" aria-selected="false">Kinerja</button>
							</li>
                        <li class="nav-item nav-item-profile" role="presentation">
                            <button class="nav-link nav-link-profile " id="pills-mt-assesment-tab" data-bs-toggle="pill" data-bs-target="#pills-assesment-mt" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Assesment</button>
                        </li>
                        
                        <li class="nav-item nav-item-profile" role="presentation">
                            <button class="nav-link nav-link-profile" id="pills-rj-tab" data-bs-toggle="pill" data-bs-target="#pills-rj" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Rekam Jejak</button>
                        </li>
                        <li class="nav-item nav-item-profile" role="presentation">
                            <button class="nav-link nav-link-profile" id="pills-pl-tab" data-bs-toggle="pill" data-bs-target="#pills-pl" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pertimbangan lainnya</button>
                        </li>
						</ul>

						<div class="col-lg-12">
							<div class="tab-content" id="pills-tabContent">
                                    <!-- data kepegawaian  -->
								<div class="tab-pane show active" id="pills-kinerja" role="tabpanel"
									aria-labelledby="pills-kinerja-tab">
                                    <div class="table-responsive">
                                        <table class="table" >
                                            <tr>
                                            <td style="width:50%" colspan="4"><span class="sp_profil_sm">Spesifik</span>
                                            </td>
                                            </tr>
                                            <tr>
                                                <?php
                                                 $currentYear = date('Y'); 
                                                 $previous1Year = $currentYear - 1;   
                                                 $previous2Year = $currentYear - 2; 
                                                 ?>
                                            <td style="width:25%"><span class="sp_label">Penilaian Kinerja N-1 <br>(SKP Tahun <?=$previous1Year;?>)</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_kinerja['skor1'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_kinerja['skor1'];?> Point] <?=$nilai_kinerja['kinerja1'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>

                                            <tr>
                                            <td style="width:25%"><span class="sp_label">Penilaian Kinerja N-2<br>(SKP Tahun <?=$previous2Year;?>)</span></td>
                                                <td style="width:25%">
                                                <?php if(isset($nilai_kinerja['skor2'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_kinerja['skor2'];?> Point] <?=$nilai_kinerja['kinerja2'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>

                                            <tr>
                                            <td style="width:50%" colspan="4"><span class="sp_profil_sm">Generik</span>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Inovatif</span></td>
                                                <td style="width:25%">
                                                <?php if(isset($nilai_kinerja['skor3'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_kinerja['skor3'];?> Point] <?=$nilai_kinerja['kinerja3'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pengalaman dalam Tim</span></td>
                                                <td style="width:25%">
                                                <?php if(isset($nilai_kinerja['skor4'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_kinerja['skor4'];?> Point] <?=$nilai_kinerja['kinerja4'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Penugasan</span></td>
                                                <td style="width:25%">
                                                <?php if(isset($nilai_kinerja['skor5'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_kinerja['skor5'];?> Point] <?=$nilai_kinerja['kinerja5'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                        </table>
                                        </div>
                                    
								</div>
                                <!-- tutup kinerja  -->
                                <!-- assesment  -->
                                <div class="tab-pane show " id="pills-assesment-mt" role="tabpanel"
									aria-labelledby="pills-mt-assesment-tab">
                                    <table class="table" >
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Nilai Assement</span></td>
                                                <td style="width:75%">
                                                <span class="sp_profil_sm">
                                                <?php if(isset($nilai_potensial['nilai_assesment'])) { ?>
                                                        <?=$nilai_potensial['nilai_assesment'];?>
                                                <?php } ?>
                                                </span>
                                            </td>
                                            </tr>
                                        </table>
								</div>
                                <!-- tutup assesment  -->

                                 <!-- Rekam Jejak  -->
                                 <div class="tab-pane show " id="pills-rj" role="tabpanel"
									aria-labelledby="pills-rj-tab">
                                    <table class="table" >
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pedidikan Terakhir</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor1'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor1'];?> Point] <?=$nilai_potensial['potensial1'];?></span>
                                                <?php } ?>

                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pangkat/Golongan Ruang</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor2'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor2'];?> Point] <?=$nilai_potensial['potensial2'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Masa Kerja Jabatan</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor3'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor3'];?> Point] <?=$nilai_potensial['potensial3'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pendidikan dan Pelatihan Kepemimpinan</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor4'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor4'];?> Point] <?=$nilai_potensial['potensial4'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pengembangan Kompetensi 20 JP Tahun 2023</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor5'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor5'];?> Point] <?=$nilai_potensial['potensial5'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Penghargaan</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor6'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor6'];?> Point] <?=$nilai_potensial['potensial6'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Riwayat Hukuman Disiplin</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor7'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor7'];?> Point] <?=$nilai_potensial['potensial7'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                        </table>
								</div>
                                <!-- tutup Rekam Jejak  -->

                                 <!-- Pertimbangan Lainnya  -->
                                 <div class="tab-pane show " id="pills-pl" role="tabpanel"
									aria-labelledby="pills-pl-tab">
									<table class="table" >
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pengalaman dalam Kepemimpinan Organisasi</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor8'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor8'];?> Point] <?=$nilai_potensial['potensial8'];?></span>
                                                <?php } ?>

                                            </td>
                                            </tr>

                                            <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() != $profil_pegawai['nipbaru_ws']){ ?>

                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Pertimbangan Pimpinan</span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor9'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor9'];?> Point] <?=$nilai_potensial['potensial9'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="width:25%"><span class="sp_label">Survey Pegawai ASN </span></td>
                                                <td style="width:75%">
                                                <?php if(isset($nilai_potensial['skor10'])) { ?>
                                                <span class="sp_profil_sm">[<?=$nilai_potensial['skor10'];?> Point] <?=$nilai_potensial['potensial10'];?></span>
                                                <?php } ?>
                                            </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
								</div>
                                <!-- tutup Pertimbangan Lainnya  -->

							</div>
						</div>

						<!-- tutup profil  -->
					</div>
				</div>
			</div>
		</div>
	</div>




    <!-- <div class="modal-footer" style="margin-bottom:5px;">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div> -->

	<script>
	


	</script>
	<?php } else { ?>
	<div class="row">
		<div class="col-lg-12 text-center">
			<h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
		</div>
	</div>
	<?php } ?>
