

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalCuti">
  Tambah Data Cuti
</button>



<button onclick="loadRiwayatUsulCuti()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalCuti">
  Riwayat Usul Cuti
</button>


<!-- status pdm -->
<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('cuti')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('cuti')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('cuti')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
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
<div class="modal fade" id="myModalCuti">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_cuti"></div>
        </div>
       
      </div>
    </div>
</div>


<div class="modal fade" id="modal_view_file_cuti" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_cuti" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>
        


<!-- Modal -->
<div class="modal fade" id="modalCuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Cuti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_cuti" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Cuti </label>
    <select class="form-control select2" data-dropdown-parent="#modalCuti"  
			data-dropdown-css-class="select2-navy" name="cuti_jenis" id="cuti_jenis" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_cuti){ foreach($jenis_cuti as $r){ ?>
                        <option value="<?=$r['id_cuti']?>"><?=$r['nm_cuti']?></option>
                    <?php } } ?>
		</select>
    </div>
   



  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglmulai" name="cuti_tglmulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglselesai" name="cuti_tglselesai" required/>
  </div>

  
  <div class="form-group">
    <label>Nomor Surat Ijin</label>
    <input class="form-control customInput" type="text" id="cuti_nosurat" name="cuti_nosurat"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Surat Ijin</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglsurat" name="cuti_tglsurat" required/>
  </div>



  <div class="form-group">
    <label>File Cuti</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_cuti" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_cuti">

</div>


                


<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
      loadListCuti()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_cuti').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_cuti');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_cuti').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
      
      
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
                document.getElementById("upload_form_cuti").reset();
                loadListCuti()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListCuti(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_cuti').html('')
    $('#list_cuti').append(divLoaderNavy)
    $('#list_cuti').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListCuti/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulCuti(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_cuti').html('')
    $('#riwayat_usul_cuti').append(divLoaderNavy)
    $('#riwayat_usul_cuti').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListCuti/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }



  


  $("#pdf_file_cuti").change(function (e) {

        var extension = pdf_file_cuti.value.split('.')[1];
      
        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>
     
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