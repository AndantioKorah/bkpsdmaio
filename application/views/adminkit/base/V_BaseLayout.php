
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
	<link rel="shortcut icon" href="<?=base_url('')?>assets/adminkit/img/logo-siladen-small.png" />

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

  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datetimepicker.js')?>"></script>

  <link rel="stylesheet" href="<?=base_url('assets/js/timepicker/jquery.timepicker.min.css')?>">
  <script src="<?=base_url('assets/js/timepicker/jquery.timepicker.min.js')?>"></script>

  <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal2.css">
  <link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">

	<title><?=TITLES?></title>

  <link rel="stylesheet" src="<?=base_url('assets/css/general.css')?>">
	<link href="<?=base_url('')?>assets/adminkit/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	
  <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datepicker.css')?>">
  <script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script>
  <link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>"> 
	
  <style>

    :root{
      --primary-color: #222e3c;
      --badge-pppk-color: #efa304;
      --badge-cpns-color: #990000;
      --badge-pns-color: #222e3c;
      --badge-aktif-color: #22a74a;
      --badge-pensiun-bup-color: #9c22a7;
      --badge-pensiun-dini-color: #a6a722;
      --badge-diberhentikan-color: #b1220f;
      --badge-mutasi-color: #0fb1ab;
      --badge-meninggal-color: #000000;
      --badge-tidak-aktif-color: #000000;
    }

    .badge-pppk{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-pppk-color);
      border: 2px solid var(--badge-pppk-color);
      color: white;
    }

    .badge-cpns{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-cpns-color);
      border: 2px solid var(--badge-cpns-color);
      color: white;
    }

    .badge-pns{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-pns-color);
      border: 2px solid var(--badge-pns-color);
      color: white;
    }

    .badge-aktif{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-aktif-color);
      border: 2px solid var(--badge-aktif-color);
      color: white;
    }

    .badge-pensiun-bup{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-pensiun-bup-color);
      border: 2px solid var(--badge-pensiun-bup-color);
      color: white;
    }

    .badge-pensiun-dini{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-pensiun-dini-color);
      border: 2px solid var(--badge-pensiun-dini-color);
      color: white;
    }

    .badge-diberhentikan{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-diberhentikan-color);
      border: 2px solid var(--badge-diberhentikan-color);
      color: white;
    }

    .badge-mutasi{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-mutasi-color);
      border: 2px solid var(--badge-mutasi-color);
      color: white;
    }

    .badge-meninggal{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-meninggal-color);
      border: 2px solid var(--badge-meninggal-color);
      color: white;
    }

    .badge-tidak-aktif{
      box-shadow: 3px 3px 10px #888888;
      background-color: var(--badge-meninggal-color);
      border: 2px solid var(--badge-meninggal-color);
      color: white;
    }

    .progress {
      --bs-progress-height: 1rem;
      --bs-progress-font-size: 0.65625rem;
      --bs-progress-bg: #e9ecef;
      --bs-progress-border-radius: 0.2rem;
      --bs-progress-box-shadow: inset 0 1px 2px rgba(0,0,0,.075);
      --bs-progress-bar-color: #fff;
      --bs-progress-bar-bg: #3b7ddd;
      --bs-progress-bar-transition: width 0.6s ease;
      background-color: var(--bs-progress-bg);
      border-radius: var(--bs-progress-border-radius);
      font-size: var(--bs-progress-font-size);
      height: var(--bs-progress-height);
    }

    .progress-bar {
      background-color: var(--bs-progress-bar-bg);
      color: var(--bs-progress-bar-color);
      flex-direction: column;
      justify-content: center;
      text-align: center;
      transition: var(--bs-progress-bar-transition);
      white-space: nowrap;
    }

    .bg-success-light {
      background: #a5f1db;
    }

    .progress, .progress-bar {
      display: flex;
      overflow: hidden;
    }

    .progress-sm {
      height: 0.4rem;
    }

    .content{
      padding: .5rem !important;
    }

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

    .bg-green {
      background-color: #28a745!important;
    }

    .info-box {
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
      border-radius: 0.25rem;
      background: #fff;
      display: -ms-flexbox;
      display: flex;
      margin-bottom: 1rem;
      min-height: 80px;
      padding: 0.5rem;
      position: relative;
      width: 100%;
    }

    .info-box .info-box-content {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-direction: column;
      flex-direction: column;
      -ms-flex-pack: center;
      justify-content: center;
      line-height: 120%;
      -ms-flex: 1;
      flex: 1;
      padding: 0 10px;
    }

    .info-box .info-box-icon {
      border-radius: 0.25rem;
      -ms-flex-align: center;
      align-items: center;
      display: -ms-flexbox;
      display: flex;
      color: white;
      font-size: 1.875rem;
      -ms-flex-pack: center;
      justify-content: center;
      text-align: center;
      width: 70px;
    }

    .info-box .info-box-text, .info-box .progress-description {
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .info-box .info-box-number {
      display: block;
      margin-top: 0.25rem;
      font-weight: 700;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey; 
      border-radius: 5px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: var(--primary-color); 
      border-radius: 5px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #b30000; 
    }
    /* .customInput{
		height:35px; 
		margin-bottom:10px;
		} */

    /* .form-control{
      height: 35px !important;
      margin-bottom:10px !important;
    } */

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      /* line-height: 30px; */
      /* height: 30px !important; */
    }

    .select2-container .select2-selection--single{
      height: 35px !important;
    }
    
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: var(--primary-color) !important;
      color: white;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 35px;
      height: 30px !important;
    }
 
    .btn-primary{
      background-color: var(--primary-color) !important;
      color: white !important;
    }

    .btn-navy-outline{
        color: var(--primary-color) !important;
        background-color: white !important;
        border-color: var(--primary-color) !important;
        text-decoration: none;
    }

    .btn-navy-outline:hover{
        color: white !important;
        background-color: var(--primary-color) !important;
        text-decoration: none;
    }

    .btn-navy{
        color: white;
        background-color: var(--primary-color) !important;
        text-decoration: none;
    }

    .btn-navy:hover{
        color: white;
        background-color: #05519e !important;
        text-decoration: none;
    }

      /* FIXED LEFT COLOUM WITH HEADER */
      .div_maintb {
    /* height: calc(100vh - 180px);
    width: calc(100vw - 100px);
    overflow: scroll;
    border: 1px solid #6f6f6f; */
    overflow-y: auto; height: 600px;

    }

.div_maintb table { 
      border: 1px solid #fff;
      font-size: 12px;
      width: 100%;
  } 
  
.div_maintb thead {
            position: sticky;
            top: 0;
            z-index: 400;
            }

.div_maintb td {
             font-size: 12px;
            } 
   

.div_maintb th {
        background: #464646;
        color: #d1d1d1;
        width: 100px;
        min-width: 100px;
        padding: 6px;
        /* outline: 1px solid #7a7a7a; */
        font-weight: normal;
        margin-bottom:50px;
    }

    /* .div_maintb td {
        padding: 6px;
        outline: 1px solid #c3c3c3;
    } */

        /* .div_maintb th:nth-child(1),
        .div_maintb td:nth-child(1) {
            position: sticky;
            left: 0;
            width: 130px;
            min-width: 130px;
        } */

   @media screen and (width> 600px) {
          .div_maintb th:nth-child(2),
          .div_maintb td:nth-child(2) {
            position: sticky;
            left: 0;
            width: 50px;
            min-width: 50px;
        }
         }


        
    .div_maintb td:nth-child(2) {
              z-index: 200;
              min-width: 20em;
          }

      .div_maintb th:nth-child(1),
      .div_maintb th:nth-child(2) {
          z-index: 300;
      }

      .div_maintb tr:nth-child(odd) td {
      background: white;
    
      }

      .div_maintb tr:nth-child(even) td {
          background: #f2f2f2;
      }
        /* TUTUP FIXED LEFT COLOUM WITH HEADER  */

  

	</style>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?=base_url('welcome')?>">
          <span class="align-middle">
		<center>
    <img style="height:auto;width:150px;" src="<?=base_url('')?>assets/adminkit/img/logo-siladen-new-with-text.png" alt="BIDIK - ASN Juara" class="brand-image img-circle elevation-3"
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
  <div class="modal fade" id="auth_modal_tte" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">MASUKKAN PASSPHRASE TANDA TANGAN ELEKTRONIK (TTE) ANDA</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="auth_modal_tte_content">
            </div>
        </div>
    </div>
  </div>
  <div id="print_div" style="display:none;"></div>
  <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
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
<!-- <script src="<?=base_url('plyearpickugins/summernote/summernote-bs4.min.js')?>"></script> -->
<script src="<?=base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
<!-- <script src="<?=base_url('assets/js/adminlte.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/pages/dashboard.js')?>"></script> -->
<!-- <script src="<?=base_url('assets/js/demo.js')?>"></script> -->
<!-- <script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script> -->
<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<script src="<?=base_url('assets/js/blazy-master/blazy.js')?>"></script>
<script src="<?=base_url('assets/js/blazy-master/polyfills/closest.js')?>"></script>

<script>
function fixedHeaderTable() {
  var $th = $('.tableFixHead').find('thead th')
  $('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
  $th.css('zIndex', '60');
  $th.css({ 'position': 'relative' });
  });



// Search table
'use strict';

var TableFilter = (function() {
 var Arr = Array.prototype;
		var input;
  
		function onInputEvent(e) {
			input = e.target;
			var table1 = document.getElementsByClassName(input.getAttribute('data-table'));
			Arr.forEach.call(table1, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, filter);
				});
			});
		}

		function filter(row) {
			var text = row.textContent.toLowerCase();
       //console.log(text);
      var val = input.value.toLowerCase();
      //console.log(val);
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = onInputEvent;
				});
			}
		};
 
	})();
 TableFilter.init(); 
 // Tutup Search table
}

$(function(){
  $(".daterangepickerthis").daterangepicker({
      showDropdowns: true
  });

  $('.select2_this').select2()

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
  var tanggal = new Date().getDate();
  var bulan = date.getMonth();
  var tahun = date.getFullYear();

  var firstDay = getFirstDayOfMonth(
    date.getFullYear(),
    date.getMonth(),
  );

  var fd = tahun+'-'+bulan+'-01';

  if(tanggal <= 3) {
    $('.datetimepickerthis').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    todayBtn: true,
    startDate: fd, 
    endDate: new Date()
  })
  } else {
    $('.datetimepickerthis').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    todayBtn: true,
    startDate: firstDay, 
    endDate: new Date()
  })
  }

  // $('.datetimepickerthis').datetimepicker({
  //   format: 'yyyy-mm-dd hh:ii:ss',
  //   autoclose: true,
  //   todayHighlight: true,
  //   todayBtn: true,
  //   startDate: firstDay, 
  //   //  startDate:'2024-08-30',
  //   endDate: new Date()
  // })


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

  function questiontoast(title = 'Apakah anda yakin?', text = '', icon = 'question', confirmbuttontext = 'Ya', cancelbuttontext = 'Tidak'){
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#222e3c",
        cancelButtonColor: "grey",
        cancelButtonText: cancelbuttontext,
        confirmButtonText: confirmbuttontext,
    }).then((result) => {
        if (result.value == true) {
            return 1;
        } else {
          return 0;
        }
    });
  }

  $("#daterangepickerthis").daterangepicker({
      showDropdowns: true
  });

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

    // var today = new Date('<?=$this->general_library->getServerDateTime()?>');
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

  window.bLazy = new Blazy({
    container: '.container',
    success: function(element){
        console.log("Element loaded: ", element.nodeName);
    }
  });

  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }


    
</script>
</body>


</html>