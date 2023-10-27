<form method="post" id="form_edit_sumjan" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $sumjan[0]['id'];?>">
<input type="hidden" id="gambarsk" name="gambarsk" value="<?= $sumjan[0]['gambarsk'];?>">


<?php if($sumjan[0]['status']==2){ ?>       
   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  <div style="display:none">
  <?php } else { ?> 
   <div>
  <?php } ?>
  <?php }?>

  
  <div class="form-group">
    <label>Sumpah / Janji</label>
    <select class="form-control " name="edit_sumpahpeg" id="edit_sumpahpeg" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_sumpah){ foreach($jenis_sumpah as $r){ ?>
                        <option <?php if($sumjan[0]['sumpahpeg'] == $r['id_sumpah']) echo "selected"; else echo ""; ?> value="<?=$r['id_sumpah']?>"><?=$r['nm_sumpah']?></option>
                    <?php } } ?>
		</select>
  </div>

  <div class="form-group">
    <label>Yang Mengambil Sumpah</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="edit_pejabat" name="edit_pejabat"  value="<?= $sumjan[0]['pejabat'];?>" required/>
  </div>

  <div class="form-group">
    <label>Nomor Berita Acara</label>
    <input class="form-control customInput" type="text" id="edit_noba" name="edit_noba"  value="<?= $sumjan[0]['noba'];?>" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berita Acara</label>
    <input class="form-control datepicker" autocomplete="off" type="text" id="edit_tglba" name="edit_tglba"  value="<?= $sumjan[0]['tglba'];?>" readonly  required/>
  </div>

  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

  <div class="form-group">
    <label>File Sumpah Janji</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_sumjam_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_sumjan"><i class="fa fa-save"></i> SIMPAN</button>
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


$('#form_edit_sumjan').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_sumjan');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_sumjam_edit').files.length;
    
     document.getElementById('btn_edit_sumjan').disabled = true;
     $('#btn_edit_sumjan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditSumjan")?>",
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
             // document.getElementById("form_edit_sumjan").reset();
             document.getElementById('btn_edit_sumjan').disabled = false;
            $('#btn_edit_sumjan').html('Simpan')
             setTimeout(function() {$("#modal_edit_sumjan").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListSumpahJanji, 2000);
             loadRiwayatUsulSumpahJanji()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 



$("#pdf_file_sumjam_edit").change(function (e) {

var doc = pdf_file_sumjam_edit.value.split('.')
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