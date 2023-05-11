<div class="container-fluid p-0">

<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">
            <h1 class="h3 mb-3">Usul Layanan</h1>


            <!-- card list  -->
            <!-- <style>
              .bg-primary {
                background: #222e3c !important;
                color: #d1d1d1;
              }

              h5 {
                color: #d1d1d1 !important;
              }
            </style>
      
            <div class="row">
								<div class="col-md-2 text-center">
                <a href="index.html">
									<div class="card bg-primary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>

								<div class="col-md-2 text-center">
                <a href="index.html">
									<div class="cprimary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>

								<div class="col-md-2 text-center">
                <a href="index.html">
									<div class="cprimary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>

								
                <div class="col-md-2 text-center">
                <a href="index.html">
									<div class="cprimary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>

								<div class="col-md-2 text-center">
                <a href="index.html">
									<div class="cprimary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>

								<div class="col-md-2 text-center">
                <a href="index.html">
									<div class="cprimary py-2 py-md-3 border">
										<div class="card-body">
                    <img src="<?=base_url('')?>assets/adminkit/img/avatars/user.png" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      <h5 style="margin-top:10px;">Kenaikan Pangkat </h5>
										</div>
									</div>
                </a>
								</div>
                
							</div>            -->
              <!-- card list  -->




<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Jenis Layanan </label>
    <select onchange="formdetaillayanan(this.value)"   class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_layanan" id="jenis_layanan" required>
    <option value="0" selected>- Pilih Layanan - </option>
                    <?php if($jenis_layanan){ foreach($jenis_layanan as $r){ ?>
                        <option value="<?=$r['kode']?>"><?=$r['nama']?></option>
                    <?php } } ?>
  </select>
  </div>


 <div id="form_layanan" >

  </div>


 



<!-- tutup body q -->
</div>
</div>
</div>
</div>

<!-- monitor layanan  -->
<div class="row">
    <div class="col-12">  
        <div class="card">
            <div class="card-body">
            <h1 class="h3 mb-3">Monitor Usul Layanan</h1>
            <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Jenis Layanan </label>
    <select onchange="loadListUsulLayanan(this.value)"   class="form-control select2" data-dropdown-css-class="select2-navy" name="monitor_jenis_layanan" id="monitor_jenis_layanan" required>
    <option value="0" selected>- Pilih Layanan - </option>
    <?php if($jenis_layanan){ foreach($jenis_layanan as $r){ ?>
                        <option value="<?=$r['kode']?>"><?=$r['nama']?></option>
                    <?php } } ?>
  </select>
  </div>
            <div id="list_usul_layanan"></div>
      

<!-- tutup body q -->
</div>
</div>
</div>
</div>



<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_filex" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      



<script>
    $(function(){
      // loadListUsulLayanan()
        $('.select2').select2()
        $('#datatable').dataTable()
        
    })


      

  function formdetaillayanan(val){
    $('#form_layanan').html('')
    $('#form_layanan').append(divLoaderNavy)

    $('#form_layanan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadFormLayanan/")?>'+val, function(){
      $('#loader').hide()
    })
  }

  function loadListUsulLayanan(val){
  
    $('#list_usul_layanan').html('')
    $('#list_usul_layanan').append(divLoaderNavy)
    $('#list_usul_layanan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListUsulLayanan/")?>'+val, function(){
      $('#loader').hide()
    })
  }

</script>