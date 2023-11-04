

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalArsipLainnya">
  Tambah Data Arsip Lainnya
</button>



<button onclick="loadRiwayatUsulArsip()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalArsip">
  Riwayat Usul Arsip Lainnya
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('data_lainnya')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('data_lainnya')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('data_lainnya')"   
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
<div class="modal fade" id="myModalArsip">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_arsip_lainnya"></div>
        </div>
       
      </div>
    </div>
</div>


<div class="modal fade" id="modal_view_file_arsip" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_arsip"  frameborder="0" ></iframe>
     
          </div>
        </div>
      </div>
    </div>
</div>
         


<!-- Modal -->
<div class="modal fade" id="modalArsipLainnya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Arsip Lainnya</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_arsip_lainnya" enctype="multipart/form-data" >
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg']?>">
    
    <div class="form-group">
    <label>Jenis Arsip</label>
    <select class="form-control select2" data-dropdown-parent="#modalArsipLainnya"   data-dropdown-css-class="select2-navy" name="jenis_arsip" id="jenis_arsip" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_arsip){ foreach($jenis_arsip as $r){ ?>
                        <option value="<?=$r['id_dokumen']?>"><?=$r['name']?></option>
                    <?php } } ?>
		</select>
  </div>


  <!-- <div class="form-group">
    <label>Nama Arsip</label>
    <input class="form-control customInput" type="text" id="nama_arsip" name="nama_arsip"  required/>
  </div> -->





  <div class="form-group">
    <label>File Arsip</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_arsip_lainnya" name="file"   />
    <!-- <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br> -->
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_arsip"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_arsip_lainnya">

</div>



<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		// dropdownAutoWidth: true,
		allowClear: true,
	});
    loadListArsip()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_arsip_lainnya').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_arsip_lainnya');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_arsip_lainnya').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_arsip').disabled = true;
        $('#btn_upload_arsip').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUploadArsipLainnya")?>",
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
                document.getElementById("upload_form_arsip_lainnya").reset();
                document.getElementById('btn_upload_arsip').disabled = false;
               $('#btn_upload_arsip').html('Simpan')
                loadListArsip()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListArsip(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_arsip_lainnya').html('')
    $('#list_arsip_lainnya').append(divLoaderNavy)
    $('#list_arsip_lainnya').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListArsip/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulArsip(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_arsip_lainnya').html('')
    $('#riwayat_usul_arsip_lainnya').append(divLoaderNavy)
    $('#riwayat_usul_arsip_lainnya').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListArsip/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

  


  $("#pdf_file_arsip_lainnya").change(function (e) {

        // var extension = pdf_file_arsip_lainnya.value.split('.')[1];
        var doc = pdf_file_arsip_lainnya.value.split('.')
        var extension = doc[doc.length - 1]
      
        var fileSize = this.files[0].size/1024;
       
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        });
</script>