<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER ANNOUNCEMENT </h3>
    </div>
    <div class="card-body" style="display: block;">
    <form method="post" id="upload_form_announcement" enctype="multipart/form-data" >
  <!-- <div class="form-group">
    <label for="exampleInputEmail1">Nama</label>
    <input type="text" class="form-control" id="" name="">
  </div> -->
  <div class="form-group mt-2 mb-2">
    <label for="exampleInputPassword1">File Gambar</label>
    <input  class="form-control my-image-field" type="file" id="png_file" name="file"   />
  </div>
  
  <button class="btn btn-block btn-primary customButton"  id="btn_upload_announcement"><i class="fa fa-save"></i> SIMPAN</button>
</form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_master_syarat_layanan">
            </div>
        </div>
    </div>
</div>


<script>
     $('#upload_form_announcement').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_announcement');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('png_file').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_announcement').disabled = true;
        $('#btn_upload_announcement').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("master/C_Master/doUploadAnnouncement")?>",
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
                document.getElementById("upload_form_announcement").reset();
                document.getElementById('btn_upload_announcement').disabled = false;
               $('#btn_upload_announcement').html('Simpan')
                // loadListArsip()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

   $("#png_file").change(function (e) {
   
   var jenis_arsip = $('#jenis_arsip').val()
   // var extension = png_file.value.split('.')[1];
   var doc = png_file.value.split('.')
   var extension = doc[doc.length - 1]
 
   var fileSize = this.files[0].size/1024;

  
     if (extension == "jpg" || extension == "png"){
     
     } else {
        errortoast("Harus File Gambar")
        $(this).val('');
     }

    

   });
</script>