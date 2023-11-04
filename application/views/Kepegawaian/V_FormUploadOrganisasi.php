

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }

    
.select2.select2-container {
  /* width: 100% !important; */
  margin-bottom: 15px;
}

/*
.select2.select2-container .select2-selection {
  border: 1px solid #ccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  height: 34px; 
  margin-bottom: 15px;
  outline: none !important;
  transition: all .15s ease-in-out;
}

 .select2.select2-container .select2-selection .select2-selection__rendered {
  color: #333;
  line-height: 32px;
  padding-right: 33px;
}

.select2.select2-container .select2-selection .select2-selection__arrow {
  background: #f8f8f8;
  border-left: 1px solid #ccc;
  -webkit-border-radius: 0 3px 3px 0;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
  height: 32px;
  width: 33px;
}

.select2.select2-container.select2-container--open .select2-selection.select2-selection--single {
  background: #f8f8f8;
}

.select2.select2-container.select2-container--open .select2-selection.select2-selection--single .select2-selection__arrow {
  -webkit-border-radius: 0 3px 0 0;
  -moz-border-radius: 0 3px 0 0;
  border-radius: 0 3px 0 0;
}

.select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
  border: 1px solid #34495e;
}

.select2.select2-container .select2-selection--multiple {
  height: auto;
  min-height: 34px;
}

.select2.select2-container .select2-selection--multiple .select2-search--inline .select2-search__field {
  margin-top: 0;
  height: 32px;
}

.select2.select2-container .select2-selection--multiple .select2-selection__rendered {
  display: block;
  padding: 0 4px;
  line-height: 29px;
}

.select2.select2-container .select2-selection--multiple .select2-selection__choice {
  background-color: #f8f8f8;
  border: 1px solid #ccc;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  margin: 4px 4px 0 0;
  padding: 0 6px 0 22px;
  height: 24px;
  line-height: 24px;
  font-size: 12px;
  position: relative;
}

.select2.select2-container .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
  position: absolute;
  top: 0;
  left: 0;
  height: 22px;
  width: 22px;
  margin: 0;
  text-align: center;
  color: #e74c3c;
  font-weight: bold;
  font-size: 16px;
}

.select2-container .select2-dropdown {
  background: transparent;
  border: none;
  margin-top: -5px;
}

.select2-container .select2-dropdown .select2-search {
  padding: 0;
}

.select2-container .select2-dropdown .select2-search input {
  outline: none !important;
  border: 1px solid #34495e !important;
  border-bottom: none !important;
  padding: 4px 6px !important;
}

.select2-container .select2-dropdown .select2-results {
  padding: 0;
}

.select2-container .select2-dropdown .select2-results ul {
  background: #fff;
  border: 1px solid #34495e;
}

.select2-container .select2-dropdown .select2-results ul .select2-results__option--highlighted[aria-selected] {
  background-color: #3498db;
} */
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalOrganisasi">
  Tambah Data Organisasi
</button>


<button onclick="loadRiwayatUsulOrganisasi()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalOrganisasi">
  Riwayat Usul Organisasi
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('organisasi')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('organisasi')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('organisasi')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>

<script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>


<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalOrganisasi">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_organisasi"></div>
        </div>
       
      </div>
    </div>
</div>
<div class="modal fade" id="modal_view_file_organisasi" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_organisasi" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalOrganisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Organisasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_organisasi" enctype="multipart/form-data" >
   
   <input type="hidden" id="id_pegorganisasi" name="id_pegorganisasi" value="">
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
   <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">

    <div class="form-group" >
    <label >Jenis Organisasi </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_organisasi" id="jenis_organisasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_organisasi){ foreach($jenis_organisasi as $r){ ?>
                        <option value="<?=$r['id_organisasi']?>"><?=$r['nm_organisasi']?></option>
                    <?php } } ?>
    </select>
    </div>

  <div class="form-group">
    <label>Nama Organisasi</label>
    <input class="form-control customInput" type="text" id="nama_organisasi" name="nama_organisasi"  required/>
  </div>


  <div class="form-group">
    <label>Kedudukan / Jabatan</label>
    <select class="form-control select2" data-dropdown-parent="#modalOrganisasi" data-dropdown-css-class="select2-navy" name="id_jabatan_organisasi" id="id_jabatan_organisasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jabatan_organisasi){ foreach($jabatan_organisasi as $r){ ?>
                        <option value="<?=$r['id']?>"><?=$r['nm_jabatan_organisasi']?></option>
                    <?php } } ?>
    </select>
  </div>

  
  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  autocomplete="off"  class="form-control datepicker"   id="tglmulai" name="tglmulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berakhir</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tglselesai" name="tglselesai" required/>
  </div>

  <div class="form-group">
    <label>Nama Pimpinan</label>
    <input class="form-control customInput" type="text" id="pemimpin" name="pemimpin"  required/>
  </div>

  <div class="form-group">
    <label>Tempat</label>
    <input class="form-control customInput" type="text" id="tempat" name="tempat"  required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_organisasi" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_organisasi"><i class="fa fa-save"></i> SIMPAN</button>
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



<div class="modal fade" id="modal_view_file_organisasi" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_organisasi"  frameborder="0" ></iframe>	
      </div>
        </div>
      </div>
    </div>
</div>

   

<div id="list_organisasi">

</div>



<!-- Modal -->
<div class="modal fade" id="modal_edit_organisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Organisasi</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_organisasi_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
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
    marginBottom:'500px;'
	});
        loadListOrganisasi()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_organisasi').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_organisasi');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_organisasi').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_organisasi').disabled = true;
        $('#btn_upload_organisasi').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById("upload_form_organisasi").reset();
                document.getElementById('btn_upload_organisasi').disabled = false;
               $('#btn_upload_organisasi').html('Simpan')
                loadListOrganisasi()
                setTimeout(function() {$("#modalOrganisasi").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListOrganisasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_organisasi').html('')
    $('#list_organisasi').append(divLoaderNavy)
    $('#list_organisasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListOrganisasi/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulOrganisasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_organisasi').html('')
    $('#riwayat_usul_organisasi').append(divLoaderNavy)
    $('#riwayat_usul_organisasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListOrganisasi/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

  

  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });

        $("#pdf_file_organisasi").change(function (e) {

        // var extension = pdf_file_organisasi.value.split('.')[1];
        var doc = pdf_file_organisasi.value.split('.')
        var extension = doc[doc.length - 1]


        var MaxSize = <?=$format_dok['file_size']?>;
        var fileSize = this.files[0].size/1024;

        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        if (fileSize > MaxSize ){
          errortoast("Maksimal Ukuran File 1 MB")
          $(this).val('');
        }

        });

</script>