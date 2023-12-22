<form method="post" id="form_edit_cuti" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $cuti[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $cuti[0]['gambarsk'];?>">
    

    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Cuti </label>
    <select class="form-control select2" data-dropdown-parent="#modalCuti"  
			data-dropdown-css-class="select2-navy" name="edit_cuti_jenis" id="edit_cuti_jenis"  required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_cuti){ foreach($jenis_cuti as $r){ ?>
                        <option  <?php if($cuti[0]['jeniscuti'] == $r['id_cuti']) echo "selected"; else echo ""; ?> value="<?=$r['id_cuti']?>"><?=$r['nm_cuti']?></option>
                    <?php } } ?>
		</select>
    </div>
   



  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="edit_cuti_tglmulai" name="edit_cuti_tglmulai" value="<?= $cuti[0]['tglmulai'];?>" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="edit_cuti_tglselesai" name="edit_cuti_tglselesai" value="<?= $cuti[0]['tglselesai'];?>" required/>
  </div>

  
  <div class="form-group">
    <label>Nomor Surat Ijin</label>
    <input class="form-control customInput" type="text" id="edit_cuti_nosurat" name="edit_cuti_nosurat" value="<?= $cuti[0]['nosttpp'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Surat Ijin</label>
    <input  class="form-control datepicker" autocomplete="off"   id="edit_cuti_tglsurat" name="edit_cuti_tglsurat" value="<?= $cuti[0]['tglsttpp'];?>" required/>
  </div>

    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   </div>
   <?php } ?>

  <div class="form-group">
    <label>File Cuti</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_edit_cuti" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_cuti"><i class="fa fa-save"></i> SIMPAN</button>
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



$('#form_edit_cuti').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_cuti');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_edit_cuti').files.length;
    
     document.getElementById('btn_edit_cuti').disabled = true;
     $('#btn_edit_cuti').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditCuti")?>",
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
             // document.getElementById("form_edit_cuti").reset();
             document.getElementById('btn_edit_cuti').disabled = false;
            $('#btn_edit_cuti').html('Simpan')
             setTimeout(function() {$("#modal_edit_cuti").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListCuti, 2000);
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 

     $("#pdf_file_edit_cuti").change(function (e) {

var extension = pdf_file_edit_cuti.value.split('.')[1];

var fileSize = this.files[0].size/1024;
var MaxSize = <?=$format_dok['file_size']?>;
var MaxMb = MaxSize/1024;

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