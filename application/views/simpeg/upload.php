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
	<title>Arsip - Siladen</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/favicon.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
	<!-- dataTablese CSS -->
	<!-- Main CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropzone/dropzone.css">
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

			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Welcome <?php echo $this->session->userdata('name') ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">ASN</li>
								<li class="breadcrumb-item active">Upload Dokumen</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Upload Dokumen</h4>
							</div>

							<div class="card-body">
								<form id="upload" action="<?php echo site_url() ?>/arsip/doUpload" class="dropzone">
									<input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">

								</form>

							</div>
							<div class="table-responsive">
								<table class="table table-striped table-sm">
									<thead class="thead-dark">
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Format</th>
											<th>Limit</th>
											<th>File</th>
											<th>Keterangan</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach ($data['dokumen']->result() as $value) : ?>
											<tr>
												<td><?php echo $i ?></td>
												<td><?php echo $value->nama_dokumen ?></td>
												<td><?php echo $value->format ?></td>
												<td><?php echo ROUND($value->file_size / 1024) . " MB" ?></td>
												<td>pdf</td>
												<td><?php echo $value->keterangan ?></td>
											</tr>
										<?php $i++;
										endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div> <!--container-fluid-->

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
	<script src="<?php echo base_url() ?>assets/plugins/dropzone/dropzone.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<script type="text/javascript">
		Dropzone.options.upload = {
			addRemoveLinks: true,
			dictDefaultMessage: "Click atau Letakkan file disini",
			success: function(file, response) {
				$('#token').val(response.token);
				if (file.previewElement) {
					$(file.previewElement).addClass("dz-success").find('.dz-error-message').text(response.error);
				}
			},
			error: function(file, response) {
				$('#token').val(response.token);
				if (file.previewElement) {
					$(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.error);

				}
			}
		};

		$('[data-tooltip="tooltip"]').tooltip();
	</script>

</body>

</html>