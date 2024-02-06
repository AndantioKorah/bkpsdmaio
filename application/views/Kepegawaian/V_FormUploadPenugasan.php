<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_penugasan">
  Tambah Data Penugasan
</button> -->


<button onclick="loadRiwayatUsulPenugasan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalPenugasan">
  Riwayat Usul Penugasan
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('penugasan')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('penugasan')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('penugasan')"   
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
<div class="modal fade" id="myModalPenugasan">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_penugasan"></div>
        </div>
       
      </div>
    </div>
</div>



<div class="modal fade" id="modal_penugasan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Upload Data Penugasan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
      <form method="post" id="upload_form_penugasan" enctype="multipart/form-data" >
        
      <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">

<div class="form-group " style="margin-bottom:10px !important;">
<label >Jenis Penugasan</label>
<select  class="form-control  "  name="jenispenugasan" id="jenispenugasan" required>
                <option value="" disabled selected>Pilih Jenis Penugasan</option>
                <?php if($jenis_penugasan){ foreach($jenis_penugasan as $r){ ?>
                  <option value="<?=$r['id_jenistugas']?>"><?=$r['nm_jenistugas']?></option>
                <?php } } ?>
</select>
</div>

<div class="form-group">
<label>Tempat/Negara Tujuan</label>
<input  class="form-control"   id="tujuan" name="tujuan" required/>
</div>

<div class="form-group">
<label>Pejabat Yang Menetapkan</label>
<input class="form-control" type="text" id="pejabat" name="pejabat"  required/>
</div>

<div class="form-group">
<label>Nomor SK</label>
<input class="form-control" type="text" id="nosk" name="nosk"  required/>
</div>

<div class="form-group">
<label>Tanggal SK</label>
<input autocomplete="off"  class="form-control datepicker"   id="tglsk" name="tglsk" required/>
</div>

<div class="form-group">
<label>Lamanya</label>
<input class="form-control" type="text" id="lamanya" name="lamanya"  required/>
</div>

<div class="form-group col-lg-12">
<br>
 <button class="btn btn-block btn-primary"  id="btn_upload_penugasan"><i class="fa fa-save"></i> SIMPAN</button>
</div>
</form> 
      </div>
    </div>
  </div>
</div>                      


<div id="list_penugasan">

</div>



<script type="text/javascript">


$(function(){
        $('.select2penugasan').select2()

  //  $(".select2").select2({   
	// 	width: '100%',
	// 	dropdownAutoWidth: true,
	// 	allowClear: true,
	// });
  
        $('#datatable').dataTable()
        loadListPenugasan()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_penugasan').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_penugasan');
        var form_data = new FormData(formvalue[0]);
        // var ins = document.getElementById('pdf_file').files.length;
        
        // if(ins == 0){
        // errortoast("Silahkan upload file terlebih dahulu");
        // return false;
        // }
        document.getElementById('btn_upload_penugasan').disabled = true;
        $('#btn_upload_penugasan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById("upload_form_penugasan").reset();
                document.getElementById('btn_upload_penugasan').disabled = false;
               $('#btn_upload_penugasan').html('Simpan')
                loadListPenugasan()
                setTimeout(function() {$("#modal_penugasan").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListPenugasan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_penugasan').html('')
    $('#list_penugasan').append(divLoaderNavy)
    $('#list_penugasan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPenugasan/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulPenugasan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_penugasan').html('')
    $('#riwayat_usul_penugasan').append(divLoaderNavy)
    $('#riwayat_usul_penugasan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPenugasan/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }
  

  
</script>