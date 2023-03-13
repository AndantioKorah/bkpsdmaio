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
	<title>Lihat Dokumen - SimASN</title>
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
		<?php $this->load->view('vheader'); ?>
		<!-- Header -->
		<!-- Sidebar -->
		<?php $this->load->view('vsidebar'); ?>
		<!-- /Sidebar -->
		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Welcome <?php echo $name ?>!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">e-Arsip ASN</li>
								<li class="breadcrumb-item active">Lihat Dokumen Kepegawaian</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-0">Lihat Dokumen Kepegawaian</h4>
							</div>
							<form name="frmDaftar" method="POST" action="<?php echo site_url() ?>arsip/doLihat" class="">
								<div class="card-body">
									<input type="hidden" id="token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
									<div class="form-group row">
										<label class="col-md-1 col-form-label">Filter</label>
										<div class="col-md-3">
											<select class="form-control <?php echo (!empty(form_error('filter')) ? 'is-invalid' : '') ?>" name="filter">
												<option value="">--</option>
												<option value="1" <?php echo  set_select('filter', 1); ?>>NIP</option>
											</select>
											<div class="invalid-feedback"><?php echo form_error('filter'); ?></div>
										</div>
										<div class="col-md-6">
											<input type="text" <?php echo ($role == 5 ? 'readonly' : '') ?> name="namaFilter" class="form-control  <?php echo (!empty(form_error('namaFilter')) ? 'is-invalid' : '') ?>" placeholder="Masukan Filter" value="<?php echo ($role == 5 ? $nip_baru : set_value('namaFilter')); ?>">
											<div class="invalid-feedback"><?php echo form_error('namaFilter'); ?></div>
										</div>
										<div class="col-md-2">
											<button type="submit" class="btn btn-primary">Tampil</button>
										</div>
									</div>
								</div>

							</form>
							<?php if ($dokumen->num_rows() > 0) : ?>
								<div class="table-responsive">
									<table id="tbDaftar" class="table table-sm">
										<thead class="thead-dark">
											<tr>
												<th>Aksi</th>
												<th>Dokumen</th>
												<th>NIP</th>
												<th>Time</th>
												<th>Oleh</th>
											</tr>
										</thead>
										<tbody>

											<?php foreach ($dokumen->result() as $value) : ?>
												<?php
												$jenis_sk     = $value->nama_dokumen;

												if ($jenis_sk != "IJAZAH" &&	$jenis_sk != "IBEL" && $jenis_sk != "MOU") {
													switch ($value->minor_dok) {
														case 45:
															$n = "IV/e";
															break;
														case 44:
															$n = "IV/d";
															break;
														case 43:
															$n = "IV/c";
															break;
														case 42:
															$n = "IV/b";
															break;
														case 41:
															$n = "IV/a";
															break;
														case 34:
															$n = "III/d";
															break;
														case 33:
															$n = "III/c";
															break;
														case 32:
															$n = "III/b";
															break;
														case 31:
															$n = "III/a";
															break;
														case 24:
															$n = "II/d";
															break;
														case 23:
															$n = "II/c";
															break;
														case 22:
															$n = "II/b";
															break;
														case 21:
															$n = "II/a";
															break;
														case 14:
															$n = "I/d";
															break;
														case 13:
															$n = "I/c";
															break;
														case 12:
															$n = "I/b";
															break;
														case 11:
															$n = "I/a";
															break;
														case 1:
															$n = "Tk.I";
															break;
														case 2:
															$n = "Tk.II";
															break;
														case 3:
															$n = "PI";
															break;
														default:
															$n = $value->minor_dok;
													}
												} else {

													switch ($value->minor_dok) {
														case 50:
															$n = "S-3/Doktor";
															break;
														case 45:
															$n = "S-2";
															break;
														case 40:
															$n = "S-1/Sarjana";
															break;
														case 35:
															$n = "Diploma IV";
															break;
														case 30:
															$n = "Diploma III/Sarjana Muda";
															break;
														case 25:
															$n = "Diploma II";
															break;
														case 20:
															$n = "Diploma I";
															break;
														case 18:
															$n = "SLTA Keguruan";
															break;
														case 17:
															$n = "SLTA Kejuruan";
															break;
														case 15:
															$n = "SLTA";
															break;
														case 12:
															$n = "SLTP Kejuruan";
															break;
														case 10:
															$n = "SLTP";
															break;
														case 05:
															$n = "Sekolah Dasar";
															break;
														default:
															$n = $value->minor_dok;
													}
												}

												?>
												<tr>
													<td width="100px;"><button class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Lihat SK" data-toggle="modal" data-target="#skModal" data-id="?id=<?php echo $this->myencrypt->encode($value->nip) ?>&f=<?php echo $this->myencrypt->encode($value->orig_name) ?>"><i class="fa fa-search"></i></button>&nbsp;

														<?php if ($value->status_dokumen < 3) { ?>
															<?php if (hasPermission('arsip', 'hapus')) : ?>
																<button class="btn btn-danger btn-sm" data-tooltip="tooltip" title="Delete SK" data-toggle="modal" data-target="#dskModal" data-nip="<?php echo $this->myencrypt->encode($value->nip) ?>" data-file="<?php echo $this->myencrypt->encode($value->orig_name) ?>" data-path="<?php echo $this->myencrypt->encode($value->file_path) ?>"><i class="fa fa-remove"></i></button>&nbsp;
																<?php endif; ?><?php } ?>
													</td>
													<td><?php echo $value->nama_dokumen ?>&nbsp;<?php echo $n ?></td>
													<td><?php echo $value->nip . '<br/>' . $value->nama ?></td>
													<td><?php echo '<b>' . $value->nama_status . '</b><br/>' . $value->update_date ?></td>
													<td><?php echo $value->first_name ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<?php endif; ?>
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
	<!-- Slimscroll JS -->
	<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
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
					url: "<?php echo site_url() ?>arsip/hapus",
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
				$.ajax({
					type: 'GET',
					url: '<?php echo site_url() ?>arsip/getArsipAll',
					data: $('form[name=frmDaftar]').serialize(),
					success: function(res) {
						$("#tbDaftar").html(res);

					},
				});
			}
		});
	</script>

</body>

</html>