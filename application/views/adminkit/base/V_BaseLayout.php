
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?=base_url('')?>assets/adminkit/img/iconSiladen.png" />

	<link rel="stylesheet" href="<?=base_url('plugins/fontawesome-free/css/all.min.css')?>">
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<link rel="stylesheet" href="<?=base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/jqvmap/jqvmap.min.css')?>">
	<!-- <link rel="stylesheet" href="<?=base_url('assets/css/adminlte.min.css')?>"> -->
	<link rel="stylesheet" href="<?=base_url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/daterangepicker/daterangepicker.css')?>">
	<link rel="stylesheet" href="<?=base_url('plugins/summernote/summernote-bs4.css')?>">
	<!-- <link rel="stylesheet" href="<?php// echo base_url('assets/css/font.css')?>"> -->
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>">

	<script src="<?=base_url('plugins/jquery/jquery.js')?>"></script>
	<script src="<?=base_url('plugins/jquery-ui/jquery-ui.js')?>"></script>
  <script src="<?=base_url('plugins/inputmask/inputmask/inputmask.js')?>"></script>
  <script src="<?=base_url('plugins/inputmask/inputmask/jquery.inputmask.js')?>"></script>

  <link href="<?=base_url('assets/css/select2.min.css')?>" rel="stylesheet" />
  <script src="<?=base_url('assets/js/select2.min.js')?>"></script>
  <script src="<?=base_url('assets/css/general.css')?>"></script>

	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
  <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
  <link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">

	<title>Siladen</title>

	<link href="<?=base_url('')?>assets/adminkit/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?=base_url('welcome')?>">
          <span class="align-middle">
		<center>
    <img style="height:auto;width:150px;" src="<?=base_url('')?>assets/adminkit/img/logoSiladen.png" alt="BIDIK - ASN Juara" class="brand-image img-circle elevation-3"
          style="opacity: .8">
    </center>
   
    <span class="brand-text" style="font-weight: bold; color: white; font-size: 16px !important;"></span>

		  </span>
        </a>

        <?php $this->load->view('adminkit/partials/V_SideBar')?> 
		</nav>

		<div class="main">
         <?php $this->load->view('adminkit/partials/V_NavBar')?>      
			

			<main class="content">
            <?php (isset($page_content)) ? $this->load->view($page_content) : ''?>
			</main>

            <?php $this->load->view('adminkit/partials/V_Footer')?>
           
		</div>
	</div>
 
  <!-- <script src="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.js"></script> -->
	<script src="<?=base_url('')?>assets/adminkit/js/app.js"></script>
  
  <!-- <script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>  -->
	
<script src="<?=base_url('plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('plugins/chart.js/Chart.min.js')?>"></script>
<script src="<?=base_url('plugins/sparklines/sparkline.js')?>"></script>
<!-- <script src="<?=base_url('plugins/jqvmap/jquery.vmap.min.js')?>"></script> -->
<!-- <script src="<?=base_url('plugins/jqvmap/maps/jquery.vmap.usa.js')?>"></script> -->
<script src="<?=base_url('plugins/jquery-knob/jquery.knob.min.js')?>"></script>
<script src="<?=base_url('plugins/moment/moment.min.js')?>"></script>
<script src="<?=base_url('plugins/daterangepicker/daterangepicker.js')?>"></script>
<script src="<?=base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>
<script src="<?=base_url('plugins/summernote/summernote-bs4.min.js')?>"></script>
<script src="<?=base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
<script src="<?=base_url('assets/js/adminlte.js')?>"></script>
<!-- <script src="<?=base_url('assets/js/pages/dashboard.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/demo.js')?>"></script> -->
<!-- <script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script> -->
<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>

<script>
 
    
</script>
</body>


</html>