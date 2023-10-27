

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSumpahJanji">
  Tambah Data Sumpah Janji
</button>


<button onclick="loadRiwayatUsulSumpahJanji()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalSumpahJanji">
  Riwayat Usul Sumpah Janji
</button>


<!-- status pdm -->
<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('sumpah_janji')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('sumpah_janji')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('sumpah_janji')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
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
<div class="modal fade" id="myModalSumpahJanji">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_sumpah_janji"></div>
        </div>
       
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalSumpahJanji" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Sumpah Janji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" id="upload_form_sumpah_janji" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="41">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">


  
  <div class="form-group">
    <label>Sumpah / Janji</label>
    <select class="form-control " name="sumpahpeg" id="sumpahpeg" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_sumpah){ foreach($jenis_sumpah as $r){ ?>
                        <option value="<?=$r['id_sumpah']?>"><?=$r['nm_sumpah']?></option>
                    <?php } } ?>
		</select>
  </div>

  <div class="form-group">
    <label>Yang Mengambil Sumpah</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="pejabat" name="pejabat" required/>
  </div>

  <div class="form-group">
    <label>Nomor Berita Acara</label>
    <input class="form-control customInput" type="text" id="noba" name="noba"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berita Acara</label>
    <input class="form-control datepicker" autocomplete="off" type="text" id="tglba" name="tglba" readonly  required/>
  </div>

  <div class="form-group">
    <label>File Sumpah Janji</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_sumjam" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_sj"><i class="fa fa-save"></i> SIMPAN</button>
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


   

<div id="list_sumpah_janji">

</div>





<div class="modal fade" id="modal_view_file_sumjan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
      <div class="modal-body" id="modal_view_file_content">
      <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_sumjan" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>     

<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
     
    </div>
  </div>
</div>                      



<!-- Modal -->
<div class="modal fade" id="modal_edit_sumjan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Sumpah Janji</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_sumjan_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


$(function(){
        // $('.select2').select2()

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  
        $('#datatable').dataTable()
        loadListSumpahJanji()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_sumpah_janji').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_sumpah_janji');
        var form_data = new FormData(formvalue[0]);

        var ins = document.getElementById('pdf_file_sumjam').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
   
        document.getElementById('btn_upload_sj').disabled = true;
        $('#btn_upload_sj').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUpload2")?>",
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
                document.getElementById("upload_form_sumpah_janji").reset();
                document.getElementById('btn_upload_sj').disabled = false;
               $('#btn_upload_sj').html('Simpan')
                loadListSumpahJanji()
                setTimeout(function() {$("#modalSumpahJanji").trigger( "click" );}, 1000);

              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListSumpahJanji(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_sumpah_janji').html('')
    $('#list_sumpah_janji').append(divLoaderNavy)
    $('#list_sumpah_janji').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSumpahJanji/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulSumpahJanji(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_sumpah_janji').html('')
    $('#riwayat_usul_sumpah_janji').append(divLoaderNavy)
    $('#riwayat_usul_sumpah_janji').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSumpahJanji/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }


  $("#pdf_file_sumjam").change(function (e) {

// var extension = pdf_file_sumjam.value.split('.')[1];
var doc = pdf_file_sumjam.value.split('.')
var extension = doc[doc.length - 1]

var fileSize = this.files[0].size/1024;
var MaxSize = 1024;

if (extension != "pdf"){
  errortoast("Harus File PDF")
  $(this).val('');
}

if (fileSize > MaxSize ){
  errortoast("Maksimal Ukuran File 1 MB")
  $(this).val('');
}

});
  


  
</script>