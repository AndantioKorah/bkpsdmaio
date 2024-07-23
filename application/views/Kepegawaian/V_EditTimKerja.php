<form method="post" id="form_edit_timkerja" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $timkerja[0]['id'];?>">
<input type="hidden" id="gambarsk" name="gambarsk" value="<?= $timkerja[0]['gambarsk'];?>">


<?php if($timkerja[0]['status']==2){ ?>       
   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  <div style="display:none">
  <?php } else { ?> 
   <div>
  <?php } ?>
  <?php }?>


  
  <div class="form-group">
    <label>Nama Tim Kerja</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="edit_nama_timkerja" name="edit_nama_timkerja"  value="<?= $timkerja[0]['nm_timkerja'];?>" required/>
  </div>


  <div class="form-group">
    <label>Peran dalam tim kerja</label>
    <select class="form-control select2"  name="edit_jabatan_timkerja" id="edit_jabatan_timkerja" required>
                    <option value="" disabled selected>Pilih Item</option>
                   <option <?php if($timkerja[0]['jabatan'] == 1) echo "selected"; else echo ""; ?> value="1">Ketua/Penanggung Jawab</option>
                   <option <?php if($timkerja[0]['jabatan'] == 2) echo "selected"; else echo ""; ?> value="2">Anggota</option>

    </select>
  </div>

  
  <div class="form-group">
    <label>Ruang lingkup tim kerja</label>
    <select class="form-control select2" name="edit_ruanglingkup" id="edit_ruanglingkup" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($lingkup_tim){ foreach($lingkup_tim as $r){ ?>
                        <option <?php if($timkerja[0]['lingkup_timkerja'] == $r['id']) echo "selected"; else echo ""; ?> value="<?=$r['id']?>"><?=$r['nm_lingkup_timkerja']?></option>
                    <?php } } ?>
		</select>
  </div>


  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

  <div class="form-group">
    <label>File Sumpah Janji</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_timkerja_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_timkerja"><i class="fa fa-save"></i> SIMPAN</button>
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


$('#form_edit_timkerja').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_timkerja');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_timkerja_edit').files.length;
    
     document.getElementById('btn_edit_timkerja').disabled = true;
     $('#btn_edit_timkerja').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditTimKerja")?>",
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
             // document.getElementById("form_edit_timkerja").reset();
             document.getElementById('btn_edit_timkerja').disabled = false;
            $('#btn_edit_timkerja').html('Simpan')
             setTimeout(function() {$("#modal_edit_tim").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListTimKerja, 2000);
             loadRiwayatUsulTimKerja()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 



$("#pdf_file_timkerja_edit").change(function (e) {

var doc = pdf_file_timkerja_edit.value.split('.')
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