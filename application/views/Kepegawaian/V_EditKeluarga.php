<form method="post" id="form_edit_keluarga" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $keluarga[0]['id'];?>">
<input type="hidden" id="gambarsk" name="gambarsk" value="<?= $keluarga[0]['gambarsk'];?>">

<div class="form-group">
    <label>Hubungan Keluarga</label>
    <select onchange="onChangeHubkelEdit()"  class="form-control " data-dropdown-css-class="select2-navy" name="hubkel_edit" id="hubkel_edit" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($hubungan_keluarga){ foreach($hubungan_keluarga as $r){ ?>
                        <option <?php if($keluarga[0]['hubkel'] == $r['id_keluarga']) echo "selected"; else echo ""; ?>  value="<?=$r['id_keluarga']?>"><?=$r['nm_keluarga']?></option>
                    <?php } } ?>
</select>
  </div>

  <div class="form-group" id="pas_ke_edit" style="display:none;">
    <label>Pasangan Ke</label>
    <input autocomplete="off" class="form-control " type="number" id="pasangan_ke_edit" name="pasangan_ke_edit" value="<?= $keluarga[0]['pasangan_ke'];?>"  />
  </div>

  <div class="form-group" id="tgl_nikah_edit" style="display:none;">
    <label>Tanggal Menikah</label>
    <input autocomplete="off" class="form-control datepicker" type="text" id="tglnikah_edit" name="tglnikah_edit" value="<?= $keluarga[0]['tglnikah'];?>" />
  </div>

  <div class="form-group" id="stts_anak_edit" style="display:none;">
    <label>Status Anak</label>
    <select  class="form-control " data-dropdown-css-class="select2-navy" name="statusanak_edit" id="statusanak_edit" >
                    <option value="" disabled selected>Pilih Item</option>
                    <option <?php if($keluarga[0]['statusanak'] == 1) echo "selected"; else echo ""; ?> value="1">Anak Kandung</option>
                    <option <?php if($keluarga[0]['statusanak'] == 2) echo "selected"; else echo ""; ?> value="2">Anak Tiri</option>              
    </select>
  </div>

  <div class="form-group" id="ortu_anak_edit" style="display:none;">
    <label>Nama Ayah/Ibu Anak</label>
    <input class="form-control customInput" type="text" id="nama_ortu_anak_edit" name="nama_ortu_anak_edit" value="<?= $keluarga[0]['nama_ortu_anak'];?>" />
  </div>

  <div class="form-group">
    <label>Nama</label>
    <input class="form-control customInput" type="text" id="namakel_edit" name="namakel_edit" value="<?= $keluarga[0]['namakel'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tempat Lahir</label>
    <input class="form-control customInput" type="text" id="tptlahir_edit" name="tptlahir_edit" value="<?= $keluarga[0]['tptlahir'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Lahir</label>
    <input autocomplete="off" class="form-control datepicker" type="text" id="tgllahir_edit" name="tgllahir_edit" value="<?= $keluarga[0]['tgllahir'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Pendidikan</label>
    <input class="form-control customInput" type="text" id="pendidikan_edit" name="pendidikan_edit" value="<?= $keluarga[0]['pendidikan'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Pekerjaan</label>
    <input class="form-control customInput" type="text" id="pekerjaan_edit" name="pekerjaan_edit" value="<?= $keluarga[0]['pekerjaan'];?>"  required/>
  </div>

  <div class="form-group" id="akte_edit" style="display:none;">
    <label>Akte Nikah / Akte Anak</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_keluarga_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_keluarga"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form>

<script>
    
    $(function(){

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  

    var val = $('#hubkel_edit').val()
    if(val == 20 || val == 30){
    $('#akte_edit').show('fast')
    $('#pas_ke_edit').show('fast')
    $('#tgl_nikah_edit').show('fast')
    $('#stts_anak_edit').hide('fast')
    $('#ortu_anak_edit').hide('fast')
    } else if(val == 40){
      $('#pas_ke_edit').hide('fast')
      $('#tgl_nikah_edit').hide('fast')  
      $('#stts_anak_edit').show('fast')
      $('#ortu_anak_edit').show('fast')
      $('#akte_edit').show('fast')

    } else {
      $('#pas_ke_edit').hide('fast')
      $('#tgl_nikah_edit').hide('fast')
      $('#stts_anak_edit').hide('fast')
      $('#ortu_anak_edit').hide('fast')
      $('#akte_edit').hide('fast')
    }
      
    })

$('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});


$('#form_edit_keluarga').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_keluarga');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_keluarga_edit').files.length;
    
     document.getElementById('btn_edit_keluarga').disabled = true;
     $('#btn_edit_keluarga').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditkeluarga")?>",
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
             // document.getElementById("form_edit_keluarga").reset();
             document.getElementById('btn_edit_keluarga').disabled = false;
            $('#btn_edit_keluarga').html('Simpan')
             setTimeout(function() {$("#modal_edit_keluarga").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListKeluarga, 2000);
             loadRiwayatUsulkeluarga()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 



$("#pdf_file_keluarga_edit").change(function (e) {

var doc = pdf_file_keluarga_edit.value.split('.')
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


function onChangeHubkelEdit(val) {
   
    var val = $('#hubkel_edit').val()
    if(val == 20 || val == 30){
    $('#akte_edit').show('fast')
    $('#pas_ke_edit').show('fast')
    $('#tgl_nikah_edit').show('fast')
    $('#stts_anak_edit').hide('fast')
    $('#ortu_anak_edit').hide('fast')
    } else if(val == 40){
      $('#pas_ke_edit').hide('fast')
      $('#tgl_nikah_edit').hide('fast')  
      $('#stts_anak_edit').show('fast')
      $('#ortu_anak_edit').show('fast')
      $('#akte').show('fast')
    } else {
      $('#pas_ke_edit').hide('fast')
      $('#tgl_nikah_edit').hide('fast')
      $('#stts_anak_edit').hide('fast')
      $('#ortu_anak_edit').hide('fast')
      $('#akte_edit').hide('fast')
    }
    }
</script>