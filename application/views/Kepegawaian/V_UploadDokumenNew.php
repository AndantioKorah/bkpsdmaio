<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>"> -->
    <style>

h2{
  color:#000;
  text-align:center;
  font-size:2em;
}
.warpper{
  display:flex;
  flex-direction: column;
  align-items: left;
  width:100%;
}
.tab{
  cursor: pointer;
  padding:10px 20px;
  margin:0px 2px;
  /* background:#000; */
  background:#222e3c;
  display:inline-block;
  color:#fff;
  border-radius:3px 3px 0px 0px;
  /* box-shadow: 0 0.5rem 0.8rem #00000080; */
  margin-bottom: 10px;
  font-size : 12px;
  border-color : #000;
}
.panels{
  /* background:#f2f4f8; */
  /* box-shadow: 0 2rem 2rem #00000080; */
  min-height:200px;
  width:100%;
  /* max-width:500px; */
  border-radius:3px;
  overflow:hidden;
  padding:20px;  
  margin-top:-20px;
}
.panel{
  display:none;
  animation: fadein .8s;
}
@keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
.panel-title{
  font-size:1.5em;
  /* font-weight:bold */
}
.radio{
  display:none;
}
#pangkat:checked ~ .panels #pangkat-panel,
#gb:checked ~ .panels #gb-panel,
#pendidikan:checked ~ .panels #pendidikan-panel,
#jabatan:checked ~ .panels #jabatan-panel,
#diklat:checked ~ .panels #diklat-panel,
#disiplin:checked ~ .panels #disiplin-panel,
#organisasi:checked ~ .panels #organisasi-panel,
#penghargaan:checked ~ .panels #penghargaan-panel,
#sj:checked ~ .panels #sj-panel,
#keluarga:checked ~ .panels #keluarga-panel,
#penugasan:checked ~ .panels #penugasan-panel,
#cuti:checked ~ .panels #cuti-panel,
#arsip:checked ~ .panels #arsip-panel{
  display:block
}
#pangkat:checked ~ .tabs #pangkat-tab,
#gb:checked ~ .tabs #gb-tab,
#pendidikan:checked ~ .tabs #pendidikan-tab,
#jabatan:checked ~ .tabs #jabatan-tab,
#diklat:checked ~ .tabs #diklat-tab,
#disiplin:checked ~ .tabs #disiplin-tab,
#organisasi:checked ~ .tabs #organisasi-tab,
#penghargaan:checked ~ .tabs #penghargaan-tab,
#sj:checked ~ .tabs #sj-tab,
#keluarga:checked ~ .tabs #keluarga-tab,
#penugasan:checked ~ .tabs #penugasan-tab,
#cuti:checked ~ .tabs #cuti-tab,
#arsip:checked ~ .tabs #arsip-tab{
  background:#fffffff6;
  color:#000;
  border-top: 3px solid #222e3c;
  border-bottom: 2px solid #222e3c;
}
     </style>

<!-- upload dokumen  -->
<div class="container-fluid p-0">
<!-- <h1 class="h3 mb-3">Upload Dokumen</h1> -->
<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">

            <style>
              .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
              background-color: #222e3c;
              color: #fff;
              }
              .nav-pills .nav-link {
              color: #000;
              border: 0;
              border-radius: var(--bs-nav-pills-border-radius);
          }
            </style>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPangkat()" class="nav-link active" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pangkat</button>
  </li>
  <li class="nav-item" role="presentation">
    <button  onclick="loadFormGajiBerkala()" class="nav-link" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Gaji Berkala</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPendidikan()" class="nav-link" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pendidikan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormJabatan()" class="nav-link" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormDiklat()" class="nav-link" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormOrganisasi()" class="nav-link" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Organisasi</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPenghargaan()" class="nav-link" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Penghargaan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-keluarga" type="button" role="tab" aria-controls="pills-keluarga" aria-selected="false">Keluarga</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#pills-penugasan" type="button" role="tab" aria-controls="pills-penugasan" aria-selected="false">Penugasan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-penugasan-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">Cuti</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-cuti-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
  </li>
</ul>
<hr>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <div id="form_pangkat"></div>
  </div>
  <div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
  <div id="form_gaji_berkala"></div>
  </div>
  <div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-pendidikan-tab">
  <div id="form_pendidikan"></div>
  </div>
  <div class="tab-pane fade" id="pills-jabatan" role="tabpanel" aria-labelledby="pills-jabatan-tab">
  <div id="form_jabatan"></div>
  </div>
  <div class="tab-pane fade" id="pills-diklat" role="tabpanel" aria-labelledby="pills-diklat-tab">
  <div id="form_diklat"></div>
  </div>
  <div class="tab-pane fade" id="pills-organisasi" role="tabpanel" aria-labelledby="pills-organisasi-tab">
  <div id="form_organisasi"></div>
  </div>
  <div class="tab-pane fade" id="pills-penghargaan" role="tabpanel" aria-labelledby="pills-penghargaan-tab">
  <div id="form_penghargaan"></div>
  </div>
  <div class="tab-pane fade" id="pills-sj" role="tabpanel" aria-labelledby="pills-sj-tab">...</div>
  <div class="tab-pane fade" id="pills-keluarga" role="tabpanel" aria-labelledby="pills-keluarga-tab">...</div>
  <div class="tab-pane fade" id="pills-penugasan" role="tabpanel" aria-labelledby="pills-penugasan-tab">...</div>
  <div class="tab-pane fade" id="pills-cuti" role="tabpanel" aria-labelledby="pills-cuti-tab">...</div>
  <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab">...</div>
</div>

<!--          
<div class="warpper" style="background-color:#fff;">
  <input  class="radio" id="pangkat" name="group" type="radio" checked>
  <input class="radio" id="gb" name="group" type="radio">
  <input  class="radio" id="pendidikan" name="group" type="radio">
  <input  class="radio" id="jabatan" name="group" type="radio">
  <input  class="radio" id="diklat" name="group" type="radio">
  <input  class="radio" id="organisasi" name="group" type="radio">
  <input class="radio" id="penghargaan" name="group" type="radio">
  <input class="radio" id="sj" name="group" type="radio">
  <input class="radio" id="keluarga" name="group" type="radio">
  <input class="radio" id="penugasan" name="group" type="radio">
  <input class="radio" id="cuti" name="group" type="radio">
  <input class="radio" id="arsip" name="group" type="radio">
  
  <div class="tabs">
  <label class="tab" id="pangkat-tab" for="pangkat">Pangkat</label>
  <label class="tab" id="gb-tab" for="gb">Gaji Berkala</label>
  <label class="tab" id="pendidikan-tab" for="pendidikan">Pendidikan</label>
  <label class="tab" id="jabatan-tab" for="jabatan">Jabatan</label>
  <label class="tab" id="diklat-tab" for="diklat">Diklat</label>
  <label class="tab" id="organisasi-tab" for="organisasi">Organisasi</label>
  <label class="tab" id="penghargaan-tab" for="penghargaan">Penghargaan</label>
  <label class="tab" id="sj-tab" for="sj">Sumpah/Janji</label>
  <label class="tab" id="keluarga-tab" for="keluarga">Keluarga</label>
  <label class="tab" id="penugasan-tab" for="penugasan">Penugasan</label>
  <label class="tab" id="cuti-tab" for="cuti">Cuti</label>
  <label class="tab" id="arsip-tab" for="arsip">Arsip Lainnya</label>
    </div>
    <hr>
  <div class="panels">
  <div class="panel" id="pangkat-panel">
    <div class="panel-title">Pangkat</div>
   
  </div>

  <div class="panel" id="gb-panel">
    <div class="panel-title">Gaji Berkala</div>
  
  </div>

  <div class="panel" id="pendidikan-panel">
    <div class="panel-title">Pendidikan</div>
   
  </div>

  <div class="panel" id="jabatan-panel">
    <div class="panel-title">Jabatan</div>
  
  </div>

  <div class="panel" id="diklat-panel">
    <div class="panel-title">Diklat</div>
  
  </div>


  <div class="panel" id="organisasi-panel">
    <div class="panel-title">Organisasi</div>
   
  </div>

  <div class="panel" id="penghargaan-panel">
    <div class="panel-title">Penghargaan</div>
  </div>

  <div class="panel" id="sj-panel">
    <div class="panel-title">Sumpah/Janji</div>
  </div>

  <div class="panel" id="keluarga-panel">
    <div class="panel-title">Keluarga</div>
  </div>

  <div class="panel" id="penugasan-panel">
    <div class="panel-title">Penugasan</div>
  </div>

  <div class="panel" id="cuti-panel">
    <div class="panel-title">Cuti</div>
  </div>

  <div class="panel" id="arsip-panel">
    <div class="panel-title">Arsip Lainnya</div>
  </div>

  </div>
</div>
 -->





          
            </div>
        </div>
    </div>
</div>
</div>
<!-- tutup upload dokumen  -->

<script>


var jenis_user = 1; 
$(function(){
 
  $('#form_pangkat').html(' ')
    $('#form_pangkat').append(divLoaderNavy)
    $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>'+jenis_user, function(){
    $('#loader').hide()    
    })

        
  })

 

 function loadFormPangkat(){
  $('#form_pangkat').html(' ')
    $('#form_pangkat').append(divLoaderNavy)
    $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>'+jenis_user, function(){
    $('#loader').hide()    
    })
 }

 function loadFormGajiBerkala(){
  $('#form_gaji_berkala').html(' ')
    $('#form_gaji_berkala').append(divLoaderNavy)
    $('#form_gaji_berkala').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormGajiBerkala/')?>', function(){
    $('#loader').hide()    
    })
 }

 function loadFormPendidikan(){
  $('#form_gaji_berkala').html(' ')
    $('#form_pendidikan').append(divLoaderNavy)
    $('#form_pendidikan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPendidikan/')?>', function(){
    $('#loader').hide()    
    })
 }

 function loadFormJabatan(){
  $('#form_jabatan').html(' ')
    $('#form_jabatan').append(divLoaderNavy)
    $('#form_jabatan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormJabatan/')?>', function(){
    $('#loader').hide()    
    })
 }

 function loadFormDiklat(){
  $('#form_diklat').html(' ')
    $('#form_diklat').append(divLoaderNavy)
    $('#form_diklat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDiklat/')?>', function(){
    $('#loader').hide()    
    })
 }

 function loadFormOrganisasi(){
  $('#form_organisasi').html(' ')
    $('#form_organisasi').append(divLoaderNavy)
    $('#form_organisasi').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormOrganisasi/')?>', function(){
    $('#loader').hide()    
    })
 }

 function loadFormPenghargaan(){
  $('#form_penghargaan').html(' ')
    $('#form_penghargaan').append(divLoaderNavy)
    $('#form_penghargaan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPenghargaan/')?>', function(){
    $('#loader').hide()    
    })
 }



 




</script>