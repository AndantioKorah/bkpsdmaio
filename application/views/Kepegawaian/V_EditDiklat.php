<form method="post" id="form_edit_diklat" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $diklat[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $diklat[0]['gambarsk'];?>">
    
    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Diklat </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_diklat" data-dropdown-css-class="select2-navy" name="edit_diklat_jenis" id="edit_diklat_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_diklat){ foreach($jenis_diklat as $r){ ?>
                        <option <?php if($diklat[0]['jenisdiklat'] == $r['id_diklat']) echo "selected"; else echo ""; ?>  value="<?=$r['id_diklat']?>"><?=$r['nm_jdiklat']?></option>
                    <?php } } ?>
    </select>
    </div>
 
    <?php if($diklat[0]['jenisdiklat'] == "00" || $diklat[0]['jenisdiklat'] == "10") { ?>
    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenjang Diklat </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_diklat" data-dropdown-css-class="select2-navy" name="edit_diklat_jenjang" id="edit_diklat_jenjang" required>
                    <option value="0"  selected>Pilih Item</option>
                    <?php if($jenjang_diklat){ foreach($jenjang_diklat as $r){ ?>
                        <option <?php if($diklat[0]['jenjang_diklat'] == $r['id']) echo "selected"; else echo ""; ?>  value="<?=$r['id']?>"><?=$r['jenjang_diklat']?></option>
                    <?php } } ?>
    </select>
    </div>
    <?php } ?>

  <div class="form-group">
    <label>Nama Diklat</label>
    <input class="form-control customInput" type="text" id="edit_diklat_nama" name="edit_diklat_nama" value="<?= $diklat[0]['nm_diklat'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tempat Diklat</label>
    <input class="form-control customInput" type="text" id="edit_diklat_tempat" name="edit_diklat_tempat" value="<?= $diklat[0]['tptdiklat'];?>"   required/>
  </div>

  <div class="form-group">
    <label>Penyelenggara</label>
    <input class="form-control customInput" type="text" id="edit_diklat_penyelenggara" name="edit_diklat_penyelenggara" value="<?= $diklat[0]['penyelenggara'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Angkatan</label>
    <input class="form-control customInput" type="text" id="edit_diklat_angkatan" name="edit_diklat_angkatan" value="<?= $diklat[0]['angkatan'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Total Jam Pelatihan</label>
    <input class="form-control customInput" type="text" id="edit_diklat_jam" name="edit_diklat_jam" value="<?= $diklat[0]['jam'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_diklat_tangal_mulai" name="edit_diklat_tangal_mulai" value="<?= $diklat[0]['tglmulai'];?>" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_diklat_tanggal_selesai" name="edit_diklat_tanggal_selesai" value="<?= $diklat[0]['tglselesai'];?>" required/>
  </div>

  <div class="form-group">
    <label>No. STTPP</label>
    <input class="form-control customInput" type="text" id="edit_diklat_no_sttpp" name="edit_diklat_no_sttpp" value="<?= $diklat[0]['nosttpp'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal STTPP</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_diklat_tanggal_sttpp" name="edit_diklat_tanggal_sttpp" value="<?= $diklat[0]['tglsttpp'];?>" required/>
  </div>



  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_edit_diklat" name="file"/>
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
    <button class="btn btn-block btn-primary float-right"  id="btn_edit_diklat"><i class="fa fa-save"></i> SIMPAN</button>
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



$('#form_edit_diklat').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_diklat');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_edit_diklat').files.length;
    
     document.getElementById('btn_edit_diklat').disabled = true;
     $('#btn_edit_diklat').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditDiklat")?>",
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
             document.getElementById('btn_edit_diklat').disabled = false;
            $('#btn_edit_diklat').html('Simpan')
             setTimeout(function() {$("#modal_edit_diklat").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListDiklat, 2000);
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 

     $("#pdf_file_edit_diklat").change(function (e) {

        var extension = pdf_file_edit_diklat.value.split('.')[1];

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