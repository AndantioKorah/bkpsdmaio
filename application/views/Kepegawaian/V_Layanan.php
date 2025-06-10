<style>
  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: #222e3c;
    color: #fff;
    border-radius: 5px !important;
  }
  .nav-pills .nav-link {
    color: #000;
    border: 0;
    border-radius: var(--bs-nav-pills-border-radius);
  }

  .nav-link-layanan{
    padding: 5px !important;
    font-size: .8rem;
    color: black;
    /* border-right: .5px solid var(--primary-color) !important; */
    border-radius: 0px !important;
    border-bottom-left-radius: 0px;
  }

  .nav-item-layanan:hover, .nav-link-layanan:hover{
    color: white !important;
    background-color: #222e3c91;
    border-color: 1px solid var(--primary-color) !important;
    border-radius: 5px !important;
  }
</style>


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

<div class="container-fluid p-0">

<div class="col-md-12" >
					<!-- <span class="headerSection">Surat Pengantar</span> -->

          <div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">

  <!-- <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan " role="presentation">
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan active" id="pills-usul-tab" data-bs-toggle="pill" data-bs-target="#pills-usul" type="button" role="tab" aria-controls="pills-usul" aria-selected="false">Usul Layanan</button>
  </li>
  </li>
  <li class="nav-item nav-item-layanan " role="presentation">
  <button onclick="loadListUsulLayanan()" class="nav-link nav-link-layanan" id="pills-monitor-tab" data-bs-toggle="pill" data-bs-target="#pills-monitor" type="button" role="tab" aria-controls="pills-monitor" aria-selected="false">Monitor Usul Layanan</button>
  </li>
  </ul> -->
      <hr style="margin-top: 10px;">
      
  <div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-usul" role="tabpanel" aria-labelledby="pills-usul-tab">
  <div id="" style="margin-left:10px;">
  
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Jenis Layanan </label>
    <select onchange="formdetaillayanan(this.value)"   class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_layanan" id="jenis_layanan" required>
    <option value="0" selected>- Pilih Layanan - </option>
                    <?php if($jenis_layanan){ foreach($jenis_layanan as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['nama_layanan']?></option>
                    <?php } } ?>
  </select>
  </div>


  <div id="form_layanan">
  </div>
  </div>
  </div>

  <div class="tab-pane fade show " id="pills-monitor" role="tabpanel" aria-labelledby="pills-monitor-tab">
  <div id="" style="margin-left:10px;">
  <div class="mb-3">
  <!-- <label for="exampleInputEmail1" class="form-label">Jenis Layanan </label>
    <select onchange="loadListUsulLayanan(this.value)"   class="form-control select22" data-dropdown-css-class="select2-navy" name="monitor_jenis_layanan" id="monitor_jenis_layanan" required>
    <option value="0" selected>- Pilih Layanan - </option>
    <?php if($jenis_layanan){ foreach($jenis_layanan as $r){ ?>
                        <option value="<?=$r['kode']?>"><?=$r['nama']?></option>
                    <?php } } ?>
  </select> -->
  </div>
            <div id="list_usul_layanan"></div>
 </div>
</div>
  </div>

				</div>
	</div>	</div>	</div>	</div>


<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_pengantar" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      



<script>
    $(function(){
      // loadListUsulLayanan()
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

  $(".select22").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

        $('#datatable').dataTable()
        
    })


      

  function formdetaillayanan(val){
    $('#form_layanan').html('')
    $('#form_layanan').append(divLoaderNavy)

    if(val == 1){
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-karis-karsu/")?>', function(){
      $('#loader').hide()
    })
    } else if(val == 2){
      var id = 8
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 3){
      var id = 9
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 4){
      var id = 10
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 5){
      var id = 11
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 6) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPangkat/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 7) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPangkat/")?>'+val, function(){
      $('#loader').hide()
    })
    }  else if(val == 8) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPangkat/")?>'+val, function(){
      $('#loader').hide()
    })
    }  else if(val == 9) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPangkat/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 10) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPerbaikanData/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 11) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPerbaikanData/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 12) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananJabatanFungsional/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 13) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananJabatanFungsional/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 14) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananJabatanFungsional/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 15) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananJabatanFungsional/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 16) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananJabatanFungsional/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 17) {
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 18) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananUjianDinas/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 19) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananUjianDinas/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 20) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananUjianDinas/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 21) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananPeningkatanPenambahanGelar/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 22) {
      $('#form_layanan').load('<?=base_url("kepegawaian/layanan-pensiun/")?>'+val, function(){
      $('#loader').hide()
    })
    } else if(val == 23) {
      $('#form_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/layananSuratPidanaHukdis/")?>'+val, function(){
      $('#loader').hide()
    })
    }    else {
      $('#form_layanan').html('')
    }

 
  }

  // function loadListUsulLayanan(val){
   
  //   var mystr = val;

  // var myarr = mystr.split(",");

  // var myvar = myarr[0] + ":" + myarr[1];


  
  //   $('#list_usul_layanan').html('')
  //   $('#list_usul_layanan').append(divLoaderNavy)
  //   $('#list_usul_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListUsulLayanan/")?>'+val, function(){
  //     $('#loader').hide()
  //   })
  // }

  function loadListUsulLayanan(){
   
   

   
   $('#list_usul_layanan').html('')
   $('#list_usul_layanan').append(divLoaderNavy)
   $('#list_usul_layanan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListUsulLayanan/")?>', function(){
     $('#loader').hide()
   })
 }

</script>