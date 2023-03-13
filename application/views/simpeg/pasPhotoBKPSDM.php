<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Siladen - Pemerintah Kota. Manado">
	<meta name="keywords" content="siladen,manado">
	<meta name="author" content="Nur Muhamad Holik">
	<meta name="robots" content="noindex, nofollow">
	<title>ID Card - Siladen</title>
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
	<style type="text/css">
		<!--
		.style1 {
			color: #FF0000;
			font-size: 16px;
			font-weight: bold;
		}
		-->
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
			<!-- Page Content -->
			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Welcome <?php echo $this->session->userdata('name') ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item ">Admin</li>
								<li class="breadcrumb-item active">Lihat Daftar Usul ID Card</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Usul ID Card </h4>
							</div>
							<div align="center"><span class="style1"><?php echo $data['pesan'] ?> </span> </div>
							<table class="table table-striped table-sm">
								<thead class="thead-dark">
									<tr>
										<th>No</th>
										<th>Tanggal Usul</th>
										<th>Nama</th>
										<th>Perangakat Daerah </th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($data['dokumen']->result() as $value) : ?>
										<tr>
											<td><?php echo $i ?></td>
											<td><?php echo format_indo(date($value->created_date)); ?></td>
											<td><?php echo $value->name ?></td>
											<td><?php echo $value->nm_unitkerja ?></td>
											<td><?php echo $value->usul_status ?></td>
											<td><?php

												if ($value->usul_status == 'DIKIRIM') {
													echo "<a href=prosesPasPhoto/$value->id_usul target=_parent><i class=\"fa fa-check m-r-5\"></i>Proses</a> ";
												}

												?></td>
										</tr>
									<?php $i++;
									endforeach; ?>
								</tbody>
							</table>

						</div>



					</div><!-- card body!-->




				</div> <!-- card !-->
			</div> <!-- col!-->
		</div> <!-- row!-->
	</div>
	<!-- /Page Content -->



	</div>
	<!-- /Page Wrapper -->
	</div>
	<!-- /Main Wrapper -->

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