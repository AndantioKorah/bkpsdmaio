<form method="post" id="form_edit_jabatann" enctype="multipart/form-data" >
    <input type="hidden" id="id" name="id" value="<?= $jabatan[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $jabatan[0]['gambarsk'];?>">

 
  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_jab" name="file"/>
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_jabatan"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 

<script>
    
$('#form_edit_jabatann').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_jabatann');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_jab').files.length;
    
     document.getElementById('btn_edit_jabatan').disabled = true;
     $('#btn_edit_jabatan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditJabatan")?>",
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
             // document.getElementById("form_edit_jabatann").reset();
             document.getElementById('btn_edit_jabatan').disabled = false;
            $('#btn_edit_jabatan').html('Simpan')
             setTimeout(function() {$("#modal_edit_jabatan").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListJabatan, 2000);
             loadRiwayatUsulJabatan()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


        $("#pdf_file_jab").change(function (e) {

        var doc = pdf_file_jab.value.split('.')
        var extension = doc[doc.length - 1]

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