<form method="post" id="form_edit_berkala" enctype="multipart/form-data" >
    <input type="hidden" id="id" name="id" value="<?= $berkala[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $berkala[0]['gambarsk'];?>">

    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Pangkat - Gol/Ruang </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_berkala" data-dropdown-css-class="select2-navy" name="edit_gb_pangkat" id="edit_gb_pangkat" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_pangkat){ foreach($list_pangkat as $r){ ?>
                        <option <?php if($berkala[0]['pangkat'] == $r['id_pangkat']) echo "selected"; else echo ""; ?> value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
    </select>
    </div>
   

  <div class="form-group">
    <label>Masa Kerja</label>
    <input class="form-control customInput" type="text" id="edit_gb_masa_kerja" name="edit_gb_masa_kerja" value="<?= $berkala[0]['masakerja'];?>"  required/>
  </div>

 
  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control customInput" type="text" id="edit_gb_no_sk" name="edit_gb_no_sk" value="<?= $berkala[0]['nosk'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_gb_tanggal_sk" name="edit_gb_tanggal_sk" value="<?= $berkala[0]['tglsk'];?>" required/>
  </div>

  <div class="form-group">
    <label>TMT Gaji Berkala</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_tmt_gaji_berkala" name="edit_tmt_gaji_berkala" value="<?= $berkala[0]['tmtgajiberkala'];?>" required/>
  </div>


   <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control customInput" type="text" id="edit_gb_pejabat" name="edit_gb_pejabat" value="<?= $berkala[0]['pejabat'];?>"  required/>
  </div>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_edit_berkala" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_berkala"><i class="fa fa-save"></i> SIMPAN</button>
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




$('#form_edit_berkala').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_berkala');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_edit_berkala').files.length;
    
     document.getElementById('btn_edit_berkala').disabled = true;
     $('#btn_edit_berkala').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditBerkala")?>",
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
             // document.getElementById("form_edit_berkala").reset();
             document.getElementById('btn_edit_berkala').disabled = false;
            $('#btn_edit_berkala').html('Simpan')
             setTimeout(function() {$("#modal_edit_berkala").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListGajiBerkala, 2000);
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


        $("#pdf_file_edit_berkala").change(function (e) {

        var extension = pdf_file_edit_berkala.value.split('.')[1];

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