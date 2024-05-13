<form method="post" id="form_edit_disiplin" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $disiplin[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $disiplin[0]['gambarsk'];?>">
    
    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Hukuman Disiplin</label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_disiplin" data-dropdown-css-class="select2-navy" name="edit_disiplin_jenis" id="edit_disiplin_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($hd){ foreach($hd as $r){ ?>
                        <option <?php if($disiplin[0]['hd'] == $r['idk']) echo "selected"; else echo ""; ?>  value="<?=$r['idk']?>"><?=$r['nama']?></option>
                    <?php } } ?>
    </select>
    </div>
 
    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Hukuman Disiplin </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_disiplin" data-dropdown-css-class="select2-navy" name="edit_disiplin_jenjang" id="edit_disiplin_jenjang" required>
                    <option value="0" disabled selected>Pilih Item</option>
                    <?php if($jhd){ foreach($jhd as $r){ ?>
                        <option <?php if($disiplin[0]['jhd'] == $r['id_jhd']) echo "selected"; else echo ""; ?>  value="<?=$r['id_jhd']?>"><?=$r['nama_jhd']?></option>
                    <?php } } ?>
    </select>
    </div>

    <div class="form-group">
    <label>Jenis Pelanggaran</label>
    <input class="form-control customInput" type="text" id="edit_disiplin_nama" name="edit_disiplin_nama" value="<?= $disiplin[0]['jp'];?>"  required/>
  </div>


  <!-- <div class="form-group">
    <label>Tanggal Mulai Berlaku</label>
    <input class="form-control customInput" type="text" id="edit_disiplin_nama" name="edit_disiplin_nama" value="<?= $disiplin[0]['tgl_mulai'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai Berlaku</label>
    <input class="form-control customInput" type="text" id="edit_disiplin_tempat" name="edit_disiplin_tempat" value="<?= $disiplin[0]['tgl_selesai'];?>"   required/>
  </div> -->

  <div class="form-group">
    <label>No Surat</label>
    <input class="form-control customInput" type="text" id="edit_disiplin_nosurat" name="edit_disiplin_nosurat" value="<?= $disiplin[0]['nosurat'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Surat</label>
    <input class="form-control customInput datepicker" type="text" id="edit_disiplin_tglsurat" name="edit_disiplin_tglsurat" value="<?= $disiplin[0]['tglsurat'];?>"  required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_edit_disiplin" name="file"/>
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
    <button class="btn btn-block btn-primary float-right"  id="btn_edit_disiplin"><i class="fa fa-save"></i> SIMPAN</button>
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



$('#form_edit_disiplin').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_disiplin');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_edit_disiplin').files.length;
    
     document.getElementById('btn_edit_disiplin').disabled = true;
     $('#btn_edit_disiplin').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditDisiplin")?>",
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
             document.getElementById('btn_edit_disiplin').disabled = false;
            $('#btn_edit_disiplin').html('Simpan')
             setTimeout(function() {$("#modal_edit_disiplin").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListDisiplin, 2000);
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 

     $("#pdf_file_edit_disiplin").change(function (e) {

        var extension = pdf_file_edit_disiplin.value.split('.')[1];

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