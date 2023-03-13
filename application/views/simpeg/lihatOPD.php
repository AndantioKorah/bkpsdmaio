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
	<title>Lihat Dokumen - Siladen</title>
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
								<li class="breadcrumb-item active">OPD</li>
								<li class="breadcrumb-item active">Lihat Dokumen Kepegawaian OPD</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="card">
					<div class="card-header">
						<h4 class="card-title mb-0">Lihat Dokumen Kepegawaian Berdasarkan NIP pada setiap OPD</h4>
					</div>
					<div class="col-md-12">
						<form name="frmDaftar" action="#" class="">
							<div class="card-body">
								<input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Filter</label>
									<div class="col-lg-4">
										<select class="form-control" name="cariBy" id="cariBy">
											<option value="1">NIP</option>
										</select>
									</div>
									<div class="col-md-6">
										<input type="text" name="cariName" id="cariName" class="form-control" placeholder="Masukan Filter" value="">
									</div>

								</div>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label">Unit OPD</label>
									<div class="col-lg-8">
										<select id="unor" name="unor" class="form-control floating">
											<option value="">--</option>
											<?php foreach ($data['unor']->result() as $value) : ?>
												<option value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-lg-2">
										<button type="button" class="btn btn-primary btn-block" id="btnTampil">Tampil</button>
									</div>
								</div>

							</div>

						</form>
					</div>

					<div class="col-md-12">
						<div class="table-responsive">
							<table id="table" class="table table-striped dt-responsive nowrap">
								<thead>
									<tr>
										<th>Dokumen</th>
										<th>NIP</th>
										<th>Time</th>
										<th>Oleh</th>
										<th>Aksi</th>

									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div> <!-- container-fluid-->

		</div>
		<!-- /Page Wrapper -->
	</div>
	<!-- /Main Wrapper -->
	<div class="modal fade" id="skModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg md-dialog ">
			<div class="modal-content md-content">
				<div class="modal-header">
					<h4 class="modal-title">Dokumen Kepegawaian</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body md-body">
					<div class="embed-responsive z-depth-1-half" style="height:100%">
						<iframe id="frame" width="100%" height="100%" frameborder="0"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="dskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><span id="msg"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="nfrmdsk">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" style="display: none">
						<p>Anda Yakin akan menghapus dokumen SK ini ?</p>
						<input type="hidden" name="nip" />
						<input type="hidden" name="file" />
						<input type="hidden" name="path" />

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="nBtnHapus">OK Hapus !</button>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
	<!-- Bootstrap Core JS -->
	<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<!-- dataTables JS -->
	<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap4.min.js"></script>
	<!-- Slimscroll JS -->
	<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			var table = $('#table').DataTable({
				"processing": true,
				"serverSide": true,
				"searching": false,
				"deferLoading": 0,
				"ajax": {
					"url": '<?php echo site_url() ?>/arsip/getLihatDokumenPNS/',
					"data": function(d) {
						d.cariBy = $('#cariBy').val();
						d.cariName = $('#cariName').val();
						d.unor = $('#unor').val();
					},
					"dataType": "json",
					"type": "GET"
				},
				"columns": [{
						"data": "nama_dokumen",
						"searchable": false,
						"orderable": true
					},
					{
						"data": "nip",
						"searchable": false,
						"orderable": true
					},
					{
						"data": "nama_status",
						"searchable": false,
						"orderable": false
					},
					{
						"data": "first_name",
						"searchable": false,
						"orderable": false
					},
					{
						"data": null,
						"searchable": false,
						"orderable": false,
						"render": function(data, type, full, meta) {
							var buttonID = full.nip_encode;
							var file = full.file_encode;
							var path = full.path_encode;
							var status = full.status_dokumen;

							return '<div class="dropdown dropdown-action"><a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
								'<div class="dropdown-menu dropdown-menu-right">' +
								'<?php if (hasPermission("arsip", "getInline")) : ?><a class="dropdown-item" href="#" data-id="?id=' + buttonID + '&f=' + file + '" data-toggle="modal" data-target="#skModal"><i class="fa fa-search m-r-5"></i> Lihat</a><?php endif ?>' +
								(status == '1' ? '<?php if (hasPermission("arsip", "hapus")) : ?><a class="dropdown-item" href="#" data-nip="' + buttonID + '" data-file="' + file + '" data-path="' + path + '" data-toggle="modal" data-target="#dskModal"><i class="fa fa-remove m-r-5"></i> Hapus</a><?php endif ?>' : '') +
								'</div></div>';
						}
					}
				]
			});


			$("#btnTampil").on("click", function(e) {
				refreshTable();
			});

			$('[data-tooltip="tooltip"]').tooltip();

			$('#skModal').on('show.bs.modal', function(e) {
				var id = $(e.relatedTarget).attr('data-id');
				var iframe = $('#frame');
				iframe.attr('src', '<?php echo site_url() ?>' + '/arsip/getInline/' + id);
			});

			$('#dskModal').on('show.bs.modal', function(e) {
				$('#dskModal #msg').text('Konfirmasi Hapus Dokumen Kepegawaian')
					.removeClass("text-success")
					.removeClass("text-danger")
					.removeClass("text-info");

				var nip = $(e.relatedTarget).attr('data-nip'),
					file = $(e.relatedTarget).attr('data-file'),
					path = $(e.relatedTarget).attr('data-path');

				$('#dskModal input[name=nip]').val(nip);
				$('#dskModal input[name=file]').val(file);
				$('#dskModal input[name=path]').val(path);
			});

			$("#nBtnHapus").on("click", function(e) {
				e.preventDefault();
				var data = $('#nfrmdsk').serialize();

				$('#dskModal #msg').text('Updating Please Wait.....')
					.removeClass("text-success")
					.addClass("text-info");

				$.ajax({
					type: "POST",
					url: "<?php echo site_url() ?>/arsip/hapus",
					data: data,
					success: function(r) {
						$('#dskModal #msg').text(r.pesan)
							.removeClass("text-info")
							.addClass("text-success");

						$('[name=<?php echo $this->security->get_csrf_token_name() ?>]').val(r.token);
						refreshTable();
					}, // akhir fungsi sukses
					error: function(r) {
						$('#dskModal #msg').text(r.responseJSON.pesan)
							.removeClass("text-info")
							.removeClass("text-success")
							.addClass("text-danger");

						$('[name=<?php echo $this->security->get_csrf_token_name() ?>]').val(r.responseJSON.token);
					}
				});
				return false;
			});

			function refreshTable() {
				var table = $('#table').DataTable();
				table.ajax.reload();
			}
		});
	</script>

</body>

</html>