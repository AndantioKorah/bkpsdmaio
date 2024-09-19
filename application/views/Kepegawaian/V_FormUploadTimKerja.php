

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
    .select2.select2-container {
  /* width: 100% !important; */
  margin-bottom: 15px;
}

</style>
<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalTimKerja">
  Tambah Data Tim Kerja
</button>

<button onclick="loadRiwayatUsulTimKerja()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalTimKerja">
  Riwayat Usul Tim Kerja
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('tim_kerja')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('tim_kerja')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('tim_kerja')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>

<script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>


<!-- <style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style> -->
<div class="modal fade" id="myModalTimKerja">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_tim_kerja"></div>
        </div>
       
      </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalTimKerja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Tim Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_tk" enctype="multipart/form-data" >
      <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $profil_pegawai['id_peg']?>">
 
  <div class="form-group">
    <label>Nama Tim Kerja</label>
    <input  class="form-control" type="text" id="nm_timkerja" name="nm_timkerja" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Peran dalam Tim Kerja</label>
    <select class="form-control select2" data-dropdown-parent="#modalTimKerja" data-dropdown-css-class="select2-navy" name="jabatan" id="jabatan" required>
                    <option value="" disabled selected>Pilih Item</option>
                   <option value="1">Ketua/Penanggung Jawab</option>
                   <option value="2">Anggota</option>

    </select>
  </div>

  
  <div class="form-group">
    <label>Ruang Lingkup Tim Kerja</label>
    <select class="form-control select2" data-dropdown-parent="#modalTimKerja" data-dropdown-css-class="select2-navy" name="lingkup_timkerja" id="lingkup_timkerja" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($lingkup_tim){ foreach($lingkup_tim as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['nm_lingkup_timkerja']?></option>
                    <?php } } ?>
    </select>
  </div>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_tk" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 2 MB</span><br>

  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_tk"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_tim_kerja">

</div>



<div class="modal fade" id="modal_view_file_tk" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_tk" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_edit_tim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Tim Kerja</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_tim_kerja_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
    loadListTimKerja()
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

    
        $('#upload_form_tk').on('submit', function(e){  
        
        e.preventDefault();
        var formvalue = $('#upload_form_tk');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_tk').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_tk').disabled = true;
        $('#btn_upload_tk').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUploadTk")?>",
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
                document.getElementById("upload_form_tk").reset();
                document.getElementById('btn_upload_tk').disabled = false;
               $('#btn_upload_tk').html('Simpan')
                loadListTimKerja()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListTimKerja(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_tim_kerja').html('')
    $('#list_tim_kerja').append(divLoaderNavy)
    $('#list_tim_kerja').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListTimKerja/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulTimKerja(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_tim_kerja').html('')
    $('#riwayat_usul_tim_kerja').append(divLoaderNavy)
    $('#riwayat_usul_tim_kerja').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListTimKerja/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }

    
  $("#pdf_file_tk").change(function (e) {

        // var extension = pdf_file_tk.value.split('.')[1];
        var doc = pdf_file_tk.value.split('.')
        var extension = doc[doc.length - 1]
      
        var fileSize = this.files[0].size/1024;
        var MaxSize = 2048;
        
     
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        if (fileSize > MaxSize ){
          errortoast("Maksimal Ukuran File 2 MB")
          $(this).val('');
        }

     

        });
</script>