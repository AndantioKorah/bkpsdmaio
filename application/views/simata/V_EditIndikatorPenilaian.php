<form method="post" id="form_edit_indikator" enctype="multipart/form-data" >
      <input type="hidden" class="form-control" id="edit_id" name="edit_id" value="<?= $indikator['id'];?>">
  <div class="mb-3">
    <label class="form-label">Nama Indikator</label>
    <input autocomplete="off" type="text" class="form-control" id="edit_nm_indikator" name="edit_nm_indikator" value="<?= $indikator['nm_indikator'];?>">
  </div>
  <div class="mb-3">
    <label  class="form-label">Bobot</label>
    <input type="number" class="form-control datepicker" id="edit_bobot" name="edit_bobot" value="<?= $indikator['bobot'];?>">
  </div>

  <button  class="btn btn-primary float-right">Simpan</button>
</form>

<script>
   $('#form_edit_indikator').on('submit', function(e){  

e.preventDefault();
var formvalue = $('#form_edit_indikator');
var form_data = new FormData(formvalue[0]);

$.ajax({  
url:"<?=base_url("simata/C_Simata/updateIndikator")?>",
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
        setTimeout(function() {$("#modal_dismis").trigger( "click" );}, 1500);
        // setTimeout(loadListJabatan, 1500);
        location.reload();
       
      } else {
        errortoast(result.msg)
        return false;
      } 
    
}  
});  
  
}); 
</script>