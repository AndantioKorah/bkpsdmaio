

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<table width="100%" border="0" class="" align="left">
<tr>
<td height="8px;" width="20%">Nama</td>
<td width="">:</td>
<td width=""> <?= $profil_pegawai['gelar1'];?> <?= $profil_pegawai['nama'];?> <?= $profil_pegawai['gelar2'];?> </td>
</tr>

<tr>
<td style="vertical-align: top;">NIP</td>
<td style="vertical-align: top;">:</td>
<td style="vertical-align: top;" height="40px;" ><?=$this->general_library->getUserName();?></td>
</tr>


</table>
   <form method="post" id="upload_form_diklat" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Jenis Diklat </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="diklat_jenis" id="diklat_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_diklat){ foreach($jenis_diklat as $r){ ?>
                        <option value="<?=$r['id_diklat']?>"><?=$r['nm_jdiklat']?></option>
                    <?php } } ?>
    </select>
    </div>

  <div class="form-group">
    <label>Nama Diklat</label>
    <input class="form-control customInput" type="text" id="diklat_nama" name="diklat_nama"  required/>
  </div>

  <div class="form-group">
    <label>Tempat Diklat</label>
    <input class="form-control customInput" type="text" id="diklat_tempat" name="diklat_tempat"  required/>
  </div>

  <div class="form-group">
    <label>Penyelenggara</label>
    <input class="form-control customInput" type="text" id="diklat_penyelenggara" name="diklat_penyelenggara"  required/>
  </div>

  <div class="form-group">
    <label>Angkatan</label>
    <input class="form-control customInput" type="text" id="diklat_angkatan" name="diklat_angkatan"  required/>
  </div>

  <div class="form-group">
    <label>Jam</label>
    <input class="form-control customInput" type="text" id="diklat_jam" name="diklat_jam"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  class="form-control datepicker"   id="diklat_tangal_mulai" name="diklat_tangal_mulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input  class="form-control datepicker"   id="diklat_tanggal_selesai" name="diklat_tanggal_selesai" required/>
  </div>

  <div class="form-group">
    <label>No. STTPP</label>
    <input class="form-control customInput" type="text" id="diklat_no_sttpp" name="diklat_no_sttpp"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal STTPP</label>
    <input  class="form-control datepicker"   id="diklat_tanggal_sttpp" name="diklat_tanggal_sttpp" required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="diklat_pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id=""><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
<hr>
<div id="list_pangkat">

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
        $('.select2').select2()
        // loadListPangkat()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_diklat').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_diklat');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('diklat_pdf_file').files.length;
        
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
                document.getElementById("upload_form_diklat").reset();
                loadFormDiklat()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

//     function loadListPangkat(){
//     $('#list_pangkat').html('')
//     $('#list_pangkat').append(divLoaderNavy)
//     $('#list_pangkat').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPangkat/")?>', function(){
//       $('#loader').hide()
//     })
//   }

  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  $("#diklat_pdf_file").change(function (e) {

        var extension = diklat_pdf_file.value.split('.')[1];
        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>;
        
     
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        if (fileSize > MaxSize ){
          errortoast("Maksimal Ukuran File 2 MB")
          $(this).val('');
        }

        });

        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });
</script>