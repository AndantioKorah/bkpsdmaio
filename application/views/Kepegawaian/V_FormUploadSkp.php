

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSkp">
  Tambah Data SKP
</button>

<!-- Modal -->
<div class="modal fade" id="modalSkp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data SKP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_skp" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    
  <div class="form-group">
    <label>Tahun</label>
    <input class="form-control yearpicker" type="text" id="gb_masa_kerja" name="skp_tahun" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Predikat</label>
    <input class="form-control customInput" type="text" id="gb_pejabat" name="skp_predikat"  required/>
  </div>

 
  <div class="form-group">
    <label>File SKP</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_skp" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

   
<div id="list_skp">

</div>


<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
      loadListSkp()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
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

    
        $('#upload_form_skp').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_skp');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_skp').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
      
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUpload2")?>",
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
                document.getElementById("upload_form_skp").reset();
                loadListSkp()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListSkp(){
    $('#list_skp').html('')
    $('#list_skp').append(divLoaderNavy)
    $('#list_skp').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListSkp/")?>', function(){
      $('#loader').hide()
    })
    }

  $("#pdf_file_skp").change(function (e) {

        var extension = pdf_file_skp.value.split('.')[1];
      
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