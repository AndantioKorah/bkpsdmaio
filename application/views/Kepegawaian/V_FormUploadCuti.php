

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalCuti">
  Tambah Data Cuti
</button>

<!-- Modal -->
<div class="modal fade" id="modalCuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Cuti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_cuti" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Jenis Cuti </label>
    <select class="form-control select2"
			data-dropdown-css-class="select2-navy" name="cuti_jenis" id="cuti_jenis" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_cuti){ foreach($jenis_cuti as $r){ ?>
                        <option value="<?=$r['id_cuti']?>"><?=$r['nm_cuti']?></option>
                    <?php } } ?>
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

   
<div id="list_gaji_berkala">

</div>


<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      


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
                document.getElementById("upload_form_cuti").reset();
                loadListCuti()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListCuti(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_gaji_berkala').html('')
    $('#list_gaji_berkala').append(divLoaderNavy)
    $('#list_gaji_berkala').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListCuti/")?>'+nip, function(){
      $('#loader').hide()
    })
  }



  $("#pdf_file_cuti").change(function (e) {

        var extension = pdf_file_cuti.value.split('.')[1];
      
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