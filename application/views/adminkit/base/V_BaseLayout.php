
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
<script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal2.css">
<link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">

	<title>Siladen</title>

	<link href="<?=base_url('')?>assets/adminkit/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
  <link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>"> 
	<style>
.tableFixHead { overflow-y: auto; height: 600px; }

.content_table{
                   font-size: 13px;
                   /* text-align: center; */
                      }

.tableFixHead table { 
            border: 1px solid #fff;
            font-size: 13px;
          } 
          
  .tableFixHead th { 
            background-color: #464646;
            color: #d1d1d1;
            border-top: 5px;
            padding: 8px 15px; 
            font-weight: normal;
          } 


      .tableFixHead tr:nth-child(even) th[scope=row] {
      background-color: #f2f2f2;
      color: black;
      }

  
      .tableFixHead tr:nth-child(odd) th[scope=row] {
      background-color: #fff;
      
      }

      .tableFixHead tr:nth-child(even) {
      background-color: rgba(0, 0, 0, 0.05);
      }

      .tableFixHead tr:nth-child(odd) {
      background-color: rgba(255, 255, 255, 0.05);
      }

      .tableFixHead td:nth-of-type(2) {
      width: 100px;
      }

      .tableFixHead th:nth-of-type(3),
      td:nth-of-type(3) {
      /* text-align: center; */
      } 

      .cd-search{
      padding: 10px;
      border: 1px solid #ccc;
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 10px;
      border-radius: 0px;
                 }

      .tableFixHead tr:nth-child(odd) td {
          background: white;
         
      }

      .tableFixHead tr:nth-child(even) td {
          background: #f2f2f2;
      }

   
     .cd-search{
        padding: 10px;
        border: 1px solid #ccc;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 10px;
        border-radius: 0px;
        }

        .customButton {
            background-color: #222e3c;
            --bs-btn-hover-bg: #20364a;
        }

        .customButton:hover {
        background-color: #20364a; /* Green */
        color: white;
        }

		.progress {
  		background-color: #d6d6d6;
		}


    .customInput{
		height:35px; 
		margin-bottom:10px;
		}

 
    .btn-primary{
      background-color: #20364a !important;
      color: white !important;
    }

    .btn-navy{
      background-color: #20364a !important;
      color: white !important;
    }
  

	</style>
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
<!-- <script src="<?=base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script> -->
<script src="<?=base_url('plyearpickugins/summernote/summernote-bs4.min.js')?>"></script>
<script src="<?=base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
<!-- <script src="<?=base_url('assets/js/adminlte.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/pages/dashboard.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/demo.js')?>"></script> -->
<!-- <script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script> -->
<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>

<script>

$(function(){

    startTime()
    // startRealTimeDate()
    // startCountDownExpireApp()
  })
   function divLoaderNavy(message = 'Loading'){
 
    return '<div class="col-12 text-center" style="height: 100%; id="loader"> <i style="color: #001f3f;" class="fas fa-3x fa-spin fa-sync-alt"></i> </div>'
  }

  function getFirstDayOfMonth(year, month) {
  return new Date(year, month, 1);
}

  var date = new Date();
var firstDay = getFirstDayOfMonth(
  date.getFullYear(),
  date.getMonth(),
);

  $('.datetimepickerthis').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    todayBtn: true,
    startDate: firstDay,
    endDate: new Date()
  })

  $('.yearpicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});

$('.datepicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});

  



  
  var live_date_time = ''
  var timertoast = 2500

  function errortoast(message = ''){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'error',
      title: message
    })
  }

  function successtoast(message = ''){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'success',
      title: message
    })
  }


  function startTime() {
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";

    var monthName = new Array(12);
    monthName[1] = "Januari";
    monthName[2] = "Februari";
    monthName[3] = "Maret";
    monthName[4] = "April";
    monthName[5] = "Mei";
    monthName[6] = "Juni";
    monthName[7] = "Juli";
    monthName[8] = "Agustus";
    monthName[9] = "September";
    monthName[10] = "Oktober";
    monthName[11] = "November";
    monthName[12] = "Desember";

    var today = new Date();
    var D = String(today.getDate()).padStart(2, '0');
    var M = String(today.getMonth() + 1).padStart(2, '0');
    var Y = today.getFullYear();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    h = checkTime(h);
    live_date_time = weekday[today.getDay()] + ', ' + D + ' ' + monthName[today.getMonth() + 1] + ' ' + Y + ' / ' + h + ":" + m + ":" + s
    $('#live_date_time').html(live_date_time)
    $('#live_date_time_welcome').html(live_date_time)
    var t = setTimeout(startTime, 500);
    
  }

  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }


    
</script>
</body>


</html>