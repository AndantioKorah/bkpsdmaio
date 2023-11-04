<form method="post" id="form_edit_pangkat" enctype="multipart/form-data" >
    <input type="hidden" id="id" name="id" value="<?= $pangkat[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $pangkat[0]['gambarsk'];?>">
  
    <!-- <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?> -->

     <?php if($pangkat[0]['status']==2){ ?>       
   
    <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } else { ?> 
    <div>
   <?php } ?>
   <?php }?>

   
    <div class="form-group " style="margin-bottom:10px !important;">
    <label >Jenis Pengangkatan</label>
    <select  class="form-control select2" data-dropdown-parent="#modal_edit_pangkat" data-dropdown-css-class="select2-navy" name="edit_jenis_pengangkatan" id="edit_jenis_pengangkatan" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_pengangkatan){ foreach($jenis_pengangkatan as $r){ ?>
                        <option <?php if($pangkat[0]['id_jenispengangkatan'] == $r['id_jenispengangkatan']) echo "selected"; else echo ""; ?> value="<?=$r['id_jenispengangkatan']?>"><?=$r['nm_jenispengangkatan']?></option>
                    <?php } } ?>
</select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Pangkat - Gol/Ruang </label>
    <select style="width: 100% important!" class="form-control select2" data-dropdown-parent="#modal_edit_pangkat" data-dropdown-css-class="select2-navy" name="edit_pangkat" id="edit_pangkat" required>
    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_pangkat){ foreach($list_pangkat as $r){ ?>
                        <option <?php if($pangkat[0]['pangkat'] == $r['id_pangkat']) echo "selected"; else echo ""; ?> value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>     
</select>
    </div>

    
   

   <div class="form-group">
    <label>TMT Pangkat</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_tmt_pangkat" name="edit_tmt_pangkat" value="<?=$pangkat[0]['tmtpangkat'];?>" readonly required/>
  </div>
  
  <div class="form-group">
    <label>Masa Kerja</label>
    <input class="form-control" type="text" id="edit_masa_kerja" name="edit_masa_kerja" value="<?=$pangkat[0]['masakerjapangkat'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control" type="text" id="edit_pejabat" name="edit_pejabat" value="<?=$pangkat[0]['pejabat'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control" type="text" id="edit_no_sk" name="edit_no_sk" value="<?=$pangkat[0]['nosk'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input autocomplete="off"  class="form-control datepicker" id="edit_tanggal_sk" name="edit_tanggal_sk" value="<?=$pangkat[0]['tglsk'];?>" readonly required/>
  </div>
  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?> 
    </div>
   <?php } ?>

 
  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_pangkat" name="file"/>
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_pangkat"><i class="fa fa-save"></i> SIMPAN</button>
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


$('#form_edit_pangkat').on('submit', function(e){  
     
        e.preventDefault();
        var formvalue = $('#form_edit_pangkat');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_pangkat').files.length;
       
        document.getElementById('btn_edit_pangkat').disabled = true;
        $('#btn_edit_pangkat').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditPangkat")?>",
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
                // document.getElementById("form_edit_pangkat").reset();
                document.getElementById('btn_edit_pangkat').disabled = false;
               $('#btn_edit_pangkat').html('Simpan')
                setTimeout(function() {$("#modal_edit_pangkat").trigger( "click" );}, 1000);
                const myTimeout = setTimeout(loadListPangkat, 2000);
                loadRiwayatUsulListPangkat()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 


$("#pdf_file_pangkat").change(function (e) {

var extension = pdf_file_pangkat.value.split('.')[1];

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