<form method="post" id="form_edit_organisasi" enctype="multipart/form-data" >
   
   <input type="hidden" id="id" name="id" value="<?= $organisasi[0]['id_pegorganisasi'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $organisasi[0]['gambarsk'];?>">

    <!-- <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?> -->

   <?php if($organisasi[0]['status']==2){ ?>       
   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  <div style="display:none">
  <?php } else { ?> 
   <div>
  <?php } ?>
  <?php }?>


    <div class="form-group" >
    <label >Jenis Organisasi </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_organisasi" data-dropdown-css-class="select2-navy" name="edit_jenis_organisasi" id="edit_jenis_organisasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_organisasi){ foreach($jenis_organisasi as $r){ ?>
                        <option <?php if($organisasi[0]['jenis_organisasi'] == $r['id_organisasi']) echo "selected"; else echo ""; ?> value="<?=$r['id_organisasi']?>"><?=$r['nm_organisasi']?></option>
                    <?php } } ?>
    </select>
    </div>

  <div class="form-group">
    <label>Nama Organisasi</label>
    <input class="form-control customInput" type="text" id="edit_nama_organisasi" name="edit_nama_organisasi" value="<?= $organisasi[0]['nama_organisasi'];?>"  required/>
  </div>


  <div class="form-group">
    <label>Kedudukan / Jabatan</label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_organisasi" data-dropdown-css-class="select2-navy" name="edit_id_jabatan_organisasi" id="edit_id_jabatan_organisasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jabatan_organisasi){ foreach($jabatan_organisasi as $r){ ?>
                        <option <?php if($organisasi[0]['id_jabatan_organisasi'] == $r['id']) echo "selected"; else echo ""; ?> value="<?=$r['id']?>"><?=$r['nm_jabatan_organisasi']?></option>
                    <?php } } ?>
    </select>
  </div>

  
  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  autocomplete="off"  class="form-control datepicker"   id="edit_tglmulai" name="edit_tglmulai" value="<?= $organisasi[0]['tglmulai'];?>" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berakhir</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_tglselesai" name="edit_tglselesai" value="<?= $organisasi[0]['tglselesai'];?>" required/>
  </div>

  <div class="form-group">
    <label>Nama Pimpinan</label>
    <input class="form-control customInput" type="text" id="edit_pemimpin" name="edit_pemimpin" value="<?= $organisasi[0]['pemimpin'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tempat</label>
    <input class="form-control customInput" type="text" id="edit_tempat" name="edit_tempat" value="<?= $organisasi[0]['tempat'];?>"  required/>
  </div>

  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_organisasi_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_organisasi"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

<script>
        $(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
   
    })
       $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});



$('#form_edit_organisasi').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_organisasi');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_organisasi_edit').files.length;
    
     document.getElementById('btn_edit_organisasi').disabled = true;
     $('#btn_edit_organisasi').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditOrganisasi")?>",
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
             // document.getElementById("form_edit_organisasi").reset();
             document.getElementById('btn_edit_organisasi').disabled = false;
            $('#btn_edit_organisasi').html('Simpan')
             setTimeout(function() {$("#modal_edit_organisasi").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListOrganisasi, 2000);
             loadRiwayatUsulOrganisasi()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


$("#pdf_file_organisasi_edit").change(function (e) {

var fileSize = this.files[0].size/1024;
var MaxSize = <?=$format_dok['file_size']?>;
var MaxMb = MaxSize/1024;

var doc = pdf_file_organisasi_edit.value.split('.')
var extension = doc[doc.length - 1]

if (extension != "pdf"){
errortoast("Harus File PDF")

$(this).val('');
}

if (fileSize > MaxSize ){
    errortoast("Maksimal Ukuran File "+MaxMb+" MB")
$(this).val('');
}

});

</script>