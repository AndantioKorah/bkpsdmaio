

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalJabatan">
  Tambah Data Jabatan
</button>


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

<!-- Modal -->
<div class="modal fade" id="modalJabatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_jabatan" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Jenis Jabatan </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="jabatan_jenis" id="jabatan_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
    </select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Nama Jabatan </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option value="<?=$r['id_jabatanpeg']?>,<?=$r['nama_jabatan']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
    </select>
    </div>
   

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control customInput" type="text" id="jabatan_pejabat" name="jabatan_pejabat"  required/>
  </div>

  <div class="form-group">
    <label>TMT Jabatan</label>
    <input  class="form-control datepicker"   id="jabatan_tmt" name="jabatan_tmt" required/>
  </div>


  <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Eselon </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="jabatan_eselon" id="jabatan_eselon" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($eselon){ foreach($eselon as $r){ ?>
                        <option value="<?=$r['id_eselon']?>"><?=$r['nm_eselon']?></option>
                    <?php } } ?>
    </select>
    </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control customInput" type="text" id="jabatan_no_sk" name="jabatan_no_sk"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input  class="form-control datepicker"   id="jabatan_tanggal_sk" name="jabatan_tanggal_sk" required/>
  </div>


  <div class="form-group">
    <label>Angka Kredit</label>
    <input class="form-control customInput" type="text" id="jabatan_angka_kredit" name="jabatan_angka_kredit"  />
  </div>

  <div class="form-group">
    <label>Keterangan</label>
    <input class="form-control customInput" type="text" id="jataban_keterangan" name="jataban_keterangan"  />
  </div>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="jabatan_pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id=""><i class="fa fa-save"></i> SIMPAN</button>
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


   

<div id="list_jabatan">

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
        loadListJabatan()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_jabatan').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_jabatan');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('jabatan_pdf_file').files.length;
        
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
                document.getElementById("upload_form_jabatan").reset();
                // loadFormJabatan()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListJabatan(){
    $('#list_jabatan').html('')
    $('#list_jabatan').append(divLoaderNavy)
    $('#list_jabatan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListJabatan/")?>', function(){
      $('#loader').hide()
    })
  }

  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  $("#jabatan_pdf_file").change(function (e) {

        var extension = jabatan_pdf_file.value.split('.')[1];
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