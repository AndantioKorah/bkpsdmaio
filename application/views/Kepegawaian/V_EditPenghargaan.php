<form method="post" id="form_edit_penghargaan" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $penghargaan[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $penghargaan[0]['gambarsk'];?>">


    <?php if($penghargaan[0]['status']==2){ ?>       
   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  <div style="display:none">
  <?php } else { ?> 
   <div>
  <?php } ?>
  <?php }?>


  <div class="form-group">
    <label>Nama Penghargaan</label>
    <input class="form-control customInput" type="text" id="edit_nm_pegpenghargaan" name="edit_nm_pegpenghargaan" value="<?= $penghargaan[0]['nm_pegpenghargaan'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control customInput" type="text" id="edit_nosk" name="edit_nosk" value="<?= $penghargaan[0]['nosk'];?>"   required/>
  </div>

  
  <div class="form-group">
    <label>Tanggal SK</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_tglsk" name="edit_tglsk" value="<?= $penghargaan[0]['tglsk'];?>" readonly required/>
  </div>

  <div class="form-group">
    <label>Tahun</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="edit_tahun_penghargaan" name="edit_tahun_penghargaan" value="<?= $penghargaan[0]['tahun_penghargaan'];?>" readonly required/>
  </div>

  <div class="form-group">
    <label>Asal Perolehan</label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_penghargaan" data-dropdown-css-class="select2-navy" name="edit_pemberi" id="edit_pemberi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($pemberi){ foreach($pemberi as $r){ ?>
                        <option  <?php if($penghargaan[0]['pemberi'] == $r['id']) echo "selected"; else echo ""; ?> value="<?=$r['id']?>"><?=$r['nm_pemberipenghargaan']?></option>
                    <?php } } ?>
    </select>
  </div>

  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_penghargaan_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_penghargaan"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

<script>
    
$(function(){
        // $('.select2').select2()

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


$('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });



$('#form_edit_penghargaan').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_penghargaan');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_penghargaan_edit').files.length;
    
     document.getElementById('btn_edit_penghargaan').disabled = true;
     $('#btn_edit_penghargaan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditPenghargaan")?>",
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
             // document.getElementById("form_edit_penghargaan").reset();
             document.getElementById('btn_edit_penghargaan').disabled = false;
            $('#btn_edit_penghargaan').html('Simpan')
             setTimeout(function() {$("#modal_edit_penghargaan").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListPenghargaan, 2000);
             loadRiwayatUsulPenghargaan()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


            $("#pdf_file_penghargaan_edit").change(function (e) {

            var fileSize = this.files[0].size/1024;
            var MaxSize = <?=$format_dok['file_size']?>;
            var MaxMb = MaxSize/1024;

            var doc = pdf_file_penghargaan_edit.value.split('.')
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