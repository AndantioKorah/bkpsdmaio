<form method="post" id="upload_form_cuti" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    <input type="hidden" id="id_usul" name="id_usul" value="<?= $id_usul;?>">

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Cuti </label>
    <select class="form-control select2" data-dropdown-parent="#modalCuti"  
			data-dropdown-css-class="select2-navy" name="cuti_jenis" id="cuti_jenis" required>
			<option value="10" selected>Cuti Besar</option>
		</select>
    </div>
   



  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglmulai" name="cuti_tglmulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglselesai" name="cuti_tglselesai" required/>
  </div>

  
  <div class="form-group">
    <label>Nomor Surat Ijin</label>
    <input class="form-control customInput" type="text" id="cuti_nosurat" name="cuti_nosurat"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Surat Ijin</label>
    <input  class="form-control datepicker" autocomplete="off"   id="cuti_tglsurat" name="cuti_tglsurat" required/>
  </div>



  <div class="form-group">
    <label>File Cuti</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_cuti" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_cuti"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 


<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
      loadListCuti()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_cuti').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_cuti');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_cuti').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_cuti').disabled = true;
        $('#btn_upload_cuti').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/uploadSKLayanan")?>",
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
                document.getElementById("upload_form_cuti").reset();
                document.getElementById('btn_upload_cuti').disabled = false;
               $('#btn_upload_cuti').html('Simpan')
                location.reload();
                setTimeout(function() {$("#modalCuti").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 




  


  $("#pdf_file_cuti").change(function (e) {

        // var extension = pdf_file_cuti.value.split('.')[1];
        var doc = pdf_file_cuti.value.split('.')
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