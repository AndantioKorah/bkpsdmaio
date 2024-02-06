

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalInovasi">
  Tambah Data Inovasi
</button> -->

<button onclick="loadRiwayatUsulInovasi()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalInovasi">
  Riwayat Usul Inovasi
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('inovasi')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('inovasi')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('inovasi')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>

<script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>


<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalInovasi">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_inovasi"></div>
        </div>
       
      </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalInovasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Inovasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_inovasi" enctype="multipart/form-data" >
      <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $profil_pegawai['id_peg']?>">
 
  <div class="form-group">
    <label>Nama Inovasi</label>
    <input  class="form-control" type="text" id="nm_inovasi" name="nm_inovasi" autocomplete="off"  required/>
  </div>

  

  
  <div class="form-group">
    <label>Kriteria Inovasi</label>
    <select class="form-control select2" data-dropdown-parent="#modalInovasi" data-dropdown-css-class="select2-navy" name="kriteria_inovasi" id="kriteria_inovasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($kriteria_inovasi){ foreach($kriteria_inovasi as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['kriteria_inovasi']?></option>
                    <?php } } ?>
    </select>
  </div>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_inovasi" name="file"   />
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_inovasi"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

   
<div id="list_inovasi">

</div>



<div class="modal fade" id="modal_view_file_inovasi" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_inovasi" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>

<style>
  .smalldrop {
    min-width: 1513px !important;
    max-width: 1936px !important;
}

</style>

<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		// dropdownAutoWidth: true,
		allowClear: true
	});
    loadListInovasi()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });

    $('.yearpicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_inovasi').on('submit', function(e){  
        
        e.preventDefault();
        var formvalue = $('#upload_form_inovasi');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_inovasi').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_inovasi').disabled = true;
        $('#btn_upload_inovasi').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUploadInovasi")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
                successtoast(result.msg)
                document.getElementById("upload_form_inovasi").reset();
                document.getElementById('btn_upload_inovasi').disabled = false;
               $('#btn_upload_inovasi').html('Simpan')
                loadListInovasi()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListInovasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_inovasi').html('')
    $('#list_inovasi').append(divLoaderNavy)
    $('#list_inovasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListInovasi/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulInovasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_inovasi').html('')
    $('#riwayat_usul_inovasi').append(divLoaderNavy)
    $('#riwayat_usul_inovasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListInovasi/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }

    
  $("#pdf_file_inovasi").change(function (e) {

        // var extension = pdf_file_inovasi.value.split('.')[1];
        var doc = pdf_file_inovasi.value.split('.')
        var extension = doc[doc.length - 1]
        var fileSize = this.files[0].size/1024;
        
    
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }
        });
</script>