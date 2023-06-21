

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalDiklat">
  Tambah Data Diklat
</button>



<button onclick="loadRiwayatUsulDiklat()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalDiklat">
  Riwayat Usul Diklat
</button>

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalDiklat">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_diklat"></div>
        </div>
       
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalDiklat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Diklat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_diklat" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Diklat </label>
    <select class="form-control select2" data-dropdown-parent="#modalDiklat" data-dropdown-css-class="select2-navy" name="diklat_jenis" id="diklat_jenis" required>
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
    <input autocomplete="off"  class="form-control datepicker"   id="diklat_tangal_mulai" name="diklat_tangal_mulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai</label>
    <input autocomplete="off"  class="form-control datepicker"   id="diklat_tanggal_selesai" name="diklat_tanggal_selesai" required/>
  </div>

  <div class="form-group">
    <label>No. STTPP</label>
    <input class="form-control customInput" type="text" id="diklat_no_sttpp" name="diklat_no_sttpp"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal STTPP</label>
    <input autocomplete="off"  class="form-control datepicker"   id="diklat_tanggal_sttpp" name="diklat_tanggal_sttpp" required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="diklat_pdf_file" name="file"   />
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

  

<div id="list_diklat">

</div>



<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
        loadListDiklat()
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
                loadListDiklat()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListDiklat(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_diklat').html('')
    $('#list_diklat').append(divLoaderNavy)
    $('#list_diklat').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListDiklat/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulDiklat(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_diklat').html('')
    $('#riwayat_usul_diklat').append(divLoaderNavy)
    $('#riwayat_usul_diklat').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListDiklat/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }


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