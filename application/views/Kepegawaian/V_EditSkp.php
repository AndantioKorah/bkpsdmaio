<form method="post" id="form_edit_skp" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $skp[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $skp[0]['gambarsk'];?>">


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_skp_edit" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 2 MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_skp"><i class="fa fa-save"></i> SIMPAN</button>
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



$('#form_edit_skp').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_skp');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_skp_edit').files.length;
    
     document.getElementById('btn_edit_skp').disabled = true;
     $('#btn_edit_skp').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditSkp")?>",
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
             // document.getElementById("form_edit_skp").reset();
             document.getElementById('btn_edit_skp').disabled = false;
            $('#btn_edit_skp').html('Simpan')
             setTimeout(function() {$("#modal_edit_skp").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListPenghargaan, 2000);
             loadRiwayatUsulSkp()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


            $("#pdf_file_skp_edit").change(function (e) {

            var fileSize = this.files[0].size/1024;
            var MaxSize = 2048;
            var MaxMb = MaxSize/1024;

            var doc = pdf_file_skp_edit.value.split('.')
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