

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() ){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalAssesment">
  Tambah Data Assesment
</button>




<button onclick="loadRiwayatUsulAssesment()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalAssesment">
  Riwayat Usul Assesment
</button>

<?php }  ?>
<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('assesment')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('assesment')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('assesment')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
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
<div class="modal fade" id="myModalAssesment">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_assesment"></div>
        </div>
       
      </div>
    </div>
</div>


<div class="modal fade" id="modal_view_file_assesment" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_assesment" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAssesment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Assesment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_assesment" enctype="multipart/form-data" >
      <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $profil_pegawai['id_peg']?>">
 
      <!-- <div class="form-group">
        <label>Tahun</label>
        <input min=0 step=0.01 class="form-control yearpicker" type="text" id="tahun" name="tahun" autocomplete="off"  required/>
      </div> -->

   

  <div class="form-group">
    <label>Nilai Assesment Manajerial dan Sosial Kultural</label>
    <input min=0 step=0.01 class="form-control" type="number" id="nilai_assesment" name="nilai_assesment" autocomplete="off"  required/>
  </div>


  <div class="form-group">
    <label>Tanggal Mulai Berlaku</label>
    <input autocomplete="off" class="form-control customInput datepicker" type="text" id="assesment_tglmulai" name="assesment_tglmulai" />
    </div>

    <div class="form-group">
      <label>Tanggal Selesai Berlaku</label>
      <input readonly autocomplete="off" class="form-control customInput " type="text" id="assesment_tglselesai" name="assesment_tglselesai" />
    </div>


  <!-- <div class="form-group">
    <label>File Assesment</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_assesment" name="file"   />
  </div> -->

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_assesment"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_assesment">

</div>


<script type="text/javascript">


$(function(){

      

  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
    loadListAssesment()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
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

    
        $('#upload_form_assesment').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_assesment');
        var form_data = new FormData(formvalue[0]);
        // var ins = document.getElementById('pdf_file_assesment').files.length;
        
        // if(ins == 0){
        // errortoast("Silahkan upload file terlebih dahulu");
        // return false;
        // }
       
        document.getElementById('btn_upload_assesment').disabled = true;
        $('#btn_upload_assesment').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUploadAssesment")?>",
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
                document.getElementById("upload_form_assesment").reset();
                document.getElementById('btn_upload_assesment').disabled = false;
               $('#btn_upload_assesment').html('Simpan')
                loadListAssesment()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListAssesment(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_assesment').html('')
    $('#list_assesment').append(divLoaderNavy)
    $('#list_assesment').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListAssesment/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulAssesment(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_assesment').html('')
    $('#riwayat_usul_assesment').append(divLoaderNavy)
    $('#riwayat_usul_assesment').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListAssesment/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }

    
  $("#pdf_file_assesment").change(function (e) {

        // var extension = pdf_file_assesment.value.split('.')[1];
        var doc = pdf_file_assesment.value.split('.')
        var extension = doc[doc.length - 1]
      
        var fileSize = this.files[0].size/1024;
     
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

     

        });

        $('#assesment_tglmulai').on('change', function() {
        var result = this.value.split('-');
        console.log(result[0])

        var year  = result[0]
        var month  = result[1]
        var date = result[2]
      
        let tgl_selesai = parseInt(year) + 3 + "-" + month + "-" + date;
        $('#assesment_tglselesai').val(tgl_selesai)


      });
</script>