<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="SimASN 2.0 - Pemerintah Kab. Minahasa">
	<meta name="keywords" content="simpeg,simasn,minahasa">
	<meta name="author" content="Nur Muhamad Holik">
	<meta name="robots" content="noindex, nofollow">
	<title>Antrian OPD - Siladen</title>
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
								<li class="breadcrumb-item">OPD</li>
								<li class="breadcrumb-item active">Antrian Verifikasi Dokumen OPD</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Daftar Antrian Verifikasi Dokumen Pada Setiap OPD</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="table-responsive">
											<table id="table" class="table table-striped dt-responsive">
												<thead>
													<tr>
														<th>NIP</th>
														<th>Nama</th>
														<th>Unit OPD</th>
														<th>Jumlah</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
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
	<!-- dataTables JS -->
	<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap4.min.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			var table = $('#table').DataTable({
				"sAjaxSource": "<?php echo site_url() ?>/arsip/getAntrianOPD",
				"sAjaxDataProp": "",
				"columns": [{
						"data": "nip"
					},
					{
						"data": "nama"
					},
					{
						"data": "nama_unor"
					},
					{
						"data": "jumlah"
					},
				]
			});

		});
	</script>

</body>

</html>