<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="SimASN 2.0 - Pemerintah Kab. Minahasa">
	<meta name="keywords" content="simpeg,simasn,minahasa">
	<meta name="author" content="Nur Muhamad Holik">
	<meta name="robots" content="noindex, nofollow">
	<title>Data Simpeg - Siladen</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/favicon.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
	<!-- dataTablese CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.min.css">
	<!-- Main CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
			<script src="<?php echo base_url() ?>assets/js/html5shiv.min.js"></script>
			<script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
		<![endif]-->
	<style>
		/*Bootstrap modal size iframe*/
		@media (max-width: 1280px) {
			.md-dialog {
				height: 630px;
				width: 800px;
			}

			.md-body {
				height: 500px;
			}
		}

		@media screen and (min-width:1281px) and (max-width:1600px) {
			.md-dialog {
				height: 700px;
				width: 1000px;
			}

			.md-body {
				height: 550px;
			}
		}

		@media screen and (min-width:1601px) and (max-width:1920px) {
			.md-dialog {
				height: 830px;
				width: 1200px;
			}

			.md-body {
				height: 700px;
			}
		}

		.style1 {
			color: #FF0000
		}
	</style>
</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!-- Header-->
		<?php $this->load->view('header'); ?>
		<!-- Header -->
		<!-- Sidebar -->
		<?php $this->load->view('sidebar'); ?>
		<!-- /Sidebar -->
		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Welcome <?php echo $this->session->userdata('name') ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">ASN</li>
								<li class="breadcrumb-item active">Lihat Data Simpeg </li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="card">
					<table width="1101" border="0" align="left">

						<tr>
							<td width="29">&nbsp;</td>
							<td width="1062" colspan="3">&nbsp;</td>
						</tr>

						<tr>
							<td>&nbsp;</td>
							<td colspan="3">
								<div class="tabs-to-dropdown">
									<div class="nav-wrapper d-flex align-items-center justify-content-between">
										<ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">

											<li class="nav-item" role="presentation">
												<a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true"><i class="la la-user"></i> Profil</a>
											</li>
											<li class="nav-item" role="presentation">
												<a class="nav-link" id="pills-pangkat-tab" data-toggle="pill" href="#pills-pangkat" role="tab" aria-controls="pills-pangkat" aria-selected="false"><i class="la la-star"></i> Pangkat</a>
											</li>
											<li class="nav-item" role="presentation">
												<a class="nav-link" id="pills-product-tab" data-toggle="pill" href="#pills-product" role="tab" aria-controls="pills-product" aria-selected="false"><i class="la la-graduation-cap"></i> Pendidikan</a>
											</li>
											<li class="nav-item" role="presentation">
												<a class="nav-link" id="pills-news-tab" data-toggle="pill" href="#pills-news" role="tab" aria-controls="pills-news" aria-selected="false"><i class="la la-building"></i> Jabatan</a>
											</li>
											<li class="nav-item" role="presentation">
												<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="la la-certificate"></i> Diklat</a>
											</li>
											<li class="nav-item" role="presentation">
												<a class="nav-link" id="pills-berkala-tab" data-toggle="pill" href="#pills-berkala" role="tab" aria-controls="pills-berkala" aria-selected="false"><i class="la la-money"></i> Gaji Berkala</a>
											</li>
										</ul>
									</div>

									<div class="tab-content" id="pills-tabContent">
										<div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
											<div class="container-fluid">
												<div class="table-responsive">

													<table width="985" border="0">
														<tr>
															<td width="152">Nama</td>
															<td width="13">:</td>
															<td width="806"><?php echo $data['asn']->gelar1; ?> <?php echo $data['asn']->nama; ?> <?php echo $data['asn']->gelar2; ?></td>
														</tr>
														<tr>
															<td>Tempat/Tgl Lahir </td>
															<td>:</td>
															<td><?php echo $data['asn']->tptlahir; ?> /
																<?php
																if ($data['asn']->tgllahir == '0000-00-00') {
																	echo "-";
																} else {
																	echo format_indo(date($data['asn']->tgllahir));
																}
																?></td>
														</tr>
														<tr>
															<td>NIP</td>
															<td>:</td>
															<td><?php echo $data['nip_baru'] ?></td>
														</tr>
														<tr>
															<td>Jenis Kelamin </td>
															<td>:</td>
															<td><?php echo $data['asn']->jk; ?></td>
														</tr>
														<tr>
															<td>Alamat</td>
															<td>:</td>
															<td><?php echo $data['asn']->alamat; ?></td>
														</tr>
														<tr>
															<td>Agama</td>
															<td>:</td>
															<td><?php echo $data['agama'] ?></td>
														</tr>
														<tr>
															<td>Pendidikan</td>
															<td>:</td>
															<td><?php echo $data['pendidikan'] ?></td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td>Pangkat / TMT </td>
															<td>:</td>
															<td><?php echo $data['nm_pangkat'] ?> /
																<?php
																if ($data['asn']->tmtpangkat == '0000-00-00') {
																	echo "-";
																} else {
																	echo format_indo(date($data['asn']->tmtpangkat));
																}
																?></td>
														</tr>
														<tr>
															<td>TMT Gaji Berkala </td>
															<td>:</td>
															<td><?php
																if ($data['asn']->tmtgjberkala == '0000-00-00') {

																	echo "-";
																} else {
																	echo format_indo(date($data['asn']->tmtgjberkala));
																}
																?></td>
														</tr>
														<tr>
															<td>Jabatan / TMT </td>
															<td>:</td>
															<td><?php echo $data['nama_jabatan'] ?> /
																<?php
																if ($data['asn']->tmtjabatan == '0000-00-00') {
																	echo "-";
																} else {
																	echo format_indo(date($data['asn']->tmtjabatan));
																}
																?></td>
														</tr>
														<tr>
															<td>Unit Kerja </td>
															<td>:</td>
															<td><?php echo $data['nm_unitkerja'] ?></td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td>NIK </td>
															<td>:</td>
															<td><?php echo $data['asn']->nik; ?></td>
														</tr>
														<tr>
															<td>No HP </td>
															<td>:</td>
															<td><?php echo $data['asn']->handphone; ?></td>
														</tr>
														<tr>
															<td>Email </td>
															<td>:</td>
															<td><?php echo $data['asn']->email; ?></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
											<div class="container-fluid">
												<div class="table-responsive">
													<table class="table table-striped table-sm">
														<thead class="thead-dark">
															<tr>
																<th width="20">No</th>
																<th width="258">Pangkat</th>
																<th width="185">TMT Pangkat </th>
																<th width="205">Masa Kerja </th>
																<th width="96">Nomor SK </th>
																<th width="184">Tanggal SK </th>
																<th width="60">File</th>
															</tr>
														</thead>
														<tbody>
															<?php $i = 1;
															foreach ($data['rpangkat']->result() as $value) : ?>
																<tr>
																	<td><?php echo $i ?></td>
																	<td><?php echo $value->nm_pangkat ?></td>
																	<td>
																		<?php
																		if ($value->tmtpangkat == '0000-00-00') {
																			echo "-";
																		} else {
																			echo format_indo(date($value->tmtpangkat));
																		}
																		?> </td>
																	<td><?php echo $value->masakerjapangkat ?></td>
																	<td><?php echo $value->nosk ?></td>
																	<td><?php
																		if ($value->tglsk == '0000-00-00') {
																			echo "-";
																		} else {
																			echo format_indo(date($value->tglsk));
																		}
																		?></td>
																	<td>
																		<?php
																		if ($value->gambarsk == NULL) {
																			echo "";
																		} else {
																			echo "<a target=_blank href=";
																			echo base_url() . "arsipelektronik/" . $value->gambarsk;
																			echo ">Download</a>";
																		}
																		?> </td>
																</tr>
															<?php $i++;
															endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
											<div class="container-fluid">
												<table width="758" class="table table-striped table-sm">
													<thead class="thead-dark">
														<tr>
															<th width="22">No</th>
															<th width="83">Pendidikan</th>
															<th width="60">Jurusan</th>
															<th width="70">Fakultas </th>
															<th width="115">Nama Sekolah </th>
															<th width="98">Tahun Lulus </th>
															<th width="210">Nomor /Tgl Ijazah </th>
															<th width="64">File</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														foreach ($data['rpendidikan']->result() as $value) : ?>
															<tr>
																<td><?php echo $i ?></td>
																<td><?php echo $value->nm_tktpendidikanb ?></td>
																<td><?php echo $value->jurusan ?></td>
																<td><?php echo $value->fakultas ?></td>
																<td><?php echo $value->namasekolah ?></td>
																<td><?php echo $value->tahunlulus ?></td>
																<td><?php echo $value->noijasah ?> /
																	<?php
																	if ($value->tglijasah == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglijasah));
																	}
																	?></td>
																<td><?php
																	if ($value->gambarsk == NULL) {
																		echo "";
																	} else {
																		echo "<a target=_blank href=";
																		echo base_url() . "arsippendidikan/" . $value->gambarsk;
																		echo ">Download</a>";
																	}
																	?> </td>
															</tr>
														<?php $i++;
														endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-news" role="tabpanel" aria-labelledby="pills-news-tab">
											<div class="container-fluid">
												<table class="table table-striped table-sm">
													<thead class="thead-dark">
														<tr>
															<th width="20">No</th>
															<th width="244">Jabatan</th>
															<th width="97">TMT Jabatan </th>
															<th width="251">PD </th>
															<th width="121">Nomor SK </th>
															<th width="113">Tanggal SK </th>
															<th width="67">File</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														foreach ($data['rjabatan']->result() as $value) : ?>
															<tr>
																<td><?php echo $i ?></td>
																<td><?php echo $value->nm_jabatan ?></td>
																<td><?php
																	if ($value->tmtjabatan == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tmtjabatan));
																	}
																	?> </td>
																<td><?php echo $value->skpd ?></td>
																<td><?php echo $value->nosk ?></td>
																<td><?php
																	if ($value->tglsk == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglsk));
																	}
																	?></td>
																<td>
																	<?php
																	if ($value->gambarsk == NULL) {
																		echo "";
																	} else {
																		echo "<a target=_blank href=";
																		echo base_url() . "arsipjabatan/" . $value->gambarsk;
																		echo ">Download</a>";
																	}
																	?>
																</td>
															</tr>
														<?php $i++;
														endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
											<div class="container-fluid">
												<table width="1044" class="table table-striped table-sm">
													<thead class="thead-dark">
														<tr>
															<th width="21">No</th>
															<th width="291">Diklat</th>
															<th width="223"> Penyelenggara </th>
															<th width="74">Jam </th>
															<th width="151">Tgl Mulai/Selesai </th>
															<th width="188">No /Tgl STTPL </th>
															<th width="64">File</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														foreach ($data['rdiklat']->result() as $value) : ?>
															<tr>
																<td><?php echo $i ?></td>
																<td><?php echo $value->nm_diklat ?></td>
																<td><?php echo $value->penyelenggara ?></td>
																<td><?php echo $value->jam ?></td>
																<td><?php
																	if ($value->tglmulai == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglmulai));
																	}
																	?> /
																	<?php
																	if ($value->tglselesai == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglselesai));
																	}
																	?></td>
																<td><?php echo $value->nosttpp ?> /
																	<?php
																	if ($value->tglsttpp == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglsttpp));
																	}
																	?></td>
																<td><?php
																	if ($value->gambarsk == NULL) {
																		echo "";
																	} else {
																		echo "<a target=_blank href=";
																		echo base_url() . "arsipdiklat/" . $value->gambarsk;
																		echo ">Download</a>";
																	}
																	?> </td>
															</tr>
														<?php $i++;
														endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
											<div class="container-fluid">
												<table width="964" class="table table-striped table-sm">
													<thead class="thead-dark">
														<tr>
															<th width="24">No</th>
															<th width="254">Pangkat</th>
															<th width="179">TMT Gaji Berkala </th>
															<th width="70">Masa Kerja </th>
															<th width="164">Nomor SK </th>
															<th width="178">Tanggal SK </th>
															<th width="63">File</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1;
														foreach ($data['rberkala']->result() as $value) : ?>
															<tr>
																<td><?php echo $i ?></td>
																<td><?php echo $value->nm_pangkat ?></td>
																<td><?php
																	if ($value->tmtgajiberkala == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tmtgajiberkala));
																	}
																	?>
																</td>
																<td><?php echo $value->masakerja ?></td>
																<td><?php echo $value->nosk ?></td>
																<td><?php
																	if ($value->tglsk == '0000-00-00') {
																		echo "-";
																	} else {
																		echo format_indo(date($value->tglsk));
																	}
																	?></td>
																<td><?php
																	if ($value->gambarsk == NULL) {
																		echo "";
																	} else {
																		echo "<a target=_blank href=";
																		echo base_url() . "arsipgjberkala/" . $value->gambarsk;
																		echo ">Download</a>";
																	}
																	?></td>
															</tr>
														<?php $i++;
														endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="3"><span class="style1">Bila ada kesalahan pada data diatas, silakan menghubungi BKPSDM Kota Manado </span></td>
						</tr>
					</table>
					<div class="col-md-12">
						<form name="frmDaftar" action="#" class="">
							<div class="card-body">
								<input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
								<div class="form-group row">

									<div class="col-md-3"></div>
									<div class="col-md-6">


									</div>

								</div>
							</div>

						</form>
					</div>

					<div class="col-md-12">
						<div class="table-responsive"></div>
					</div>
				</div>
			</div> <!-- container-fluid-->

		</div>
		<!-- /Page Wrapper -->
	</div>

	</div>

	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
	<!-- Bootstrap Core JS -->
	<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<!-- Slimscroll JS -->
	<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/moment-with-locales.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			$(".unor").select2({
				placeholder: 'Masukan Nama Unit Organisasi',
				width: '100%',
				minimumInputLength: 6,
				ajax: {
					url: "<?php echo site_url() ?>/layanan/getUnitOrganisasi",
					dataType: 'json',
					type: 'GET',
					cache: "true",
					delay: 250,
					processResults: function(data) {
						return {
							results: $.map(data, function(obj) {
								return {
									id: obj.id,
									text: obj.nama
								};
							})
						};
					}
				}
			});

			<?php if ($data['show']) : ?>
				$("#unor").append("<option value='" + '<?php echo $UnitOrganisasiById->id ?>' + "' selected>" + '<?php echo $UnitOrganisasiById->parent . ' - ' . $UnitOrganisasiById->nama ?>' + "</option>");
				$('#unor').trigger('change');
			<?php endif ?>
		});
	</script>
</body>

</html>