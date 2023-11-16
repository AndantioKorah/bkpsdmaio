<form method="post" id="form_edit_arsip_lain" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $arsip[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $arsip[0]['gambarsk'];?>">
    
  <div class="form-group">
    <label>File Arsip</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_edit_arsip_lain" name="file"   />
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_arsipl"><i class="fa fa-save"></i> SIMPAN</button>
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



$('#form_edit_arsip_lain').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_arsip_lain');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_edit_arsip_lain').files.length;
    
     document.getElementById('btn_edit_arsipl').disabled = true;
     $('#btn_edit_arsipl').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditArsipLain")?>",
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
             // document.getElementById("form_edit_arsip_lain").reset();
             document.getElementById('btn_edit_arsipl').disabled = false;
            $('#btn_edit_arsipl').html('Simpan')
             setTimeout(function() {$("#modal_edit_arsip_lain").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListArsip, 2000);
             loadRiwayatUsulArsip()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 

     $("#pdf_file_edit_arsip_lain").change(function (e) {

        var extension = pdf_file_edit_arsip_lain.value.split('.')[1];

        var fileSize = this.files[0].size/1024;


        if (extension != "pdf"){
        errortoast("Harus File PDF")

        $(this).val('');
        }



});
</script>