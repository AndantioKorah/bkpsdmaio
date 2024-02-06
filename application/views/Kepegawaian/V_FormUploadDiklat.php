

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalDiklat">
  Tambah Data Diklat
</button> -->



<button onclick="loadRiwayatUsulDiklat()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalDiklat">
  Riwayat Usul Diklat
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('diklat')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('diklat')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('diklat')"   
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

<div class="modal fade" id="modal_view_file_diklat" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_diklat"  frameborder="0" ></iframe>	
      </div>
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
    

    <div class="form-group" style="margin-bottom:10px !important;" >
    <label >Jenis Diklat </label>
    <select class="form-control select2" data-dropdown-parent="#modalDiklat" data-dropdown-css-class="select2-navy" name="diklat_jenis" id="diklat_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_diklat){ foreach($jenis_diklat as $r){ ?>
                        <option value="<?=$r['id_diklat']?>"><?=$r['nm_jdiklat']?></option>
                    <?php } } ?>
    </select>
    </div>

    <div class="form-group" style="display:none" id="inputjd">
      <label>Jenjang Diklat </label>
      <select  class="form-control select2 jdiklat"  data-dropdown-css-class="select2-navy"  name="diklat_jenjang" id="diklat_jenjang">     
    <option selected value="0"></option>
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
    <label>Total Jam Pelatihan</label>
    <input class="form-control customInput" type="number" id="diklat_jam" name="diklat_jam"  required/>
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
    <button class="btn btn-block btn-primary customButton"  id="btn_upload_diklat"><i class="fa fa-save"></i> SIMPAN</button>
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


<!-- Modal -->
<div class="modal fade" id="modal_edit_diklat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Bangkom</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_diklat_pegawai">
          
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
       
        document.getElementById('btn_upload_diklat').disabled = true;
        $('#btn_upload_diklat').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById('btn_upload_diklat').disabled = false;
               $('#btn_upload_diklat').html('Simpan')
                loadListDiklat()
                setTimeout(function() {$("#modalDiklat").trigger( "click" );}, 1000);
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

    

        // var extension = diklat_pdf_file.value.split('.')[1];
        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>;

        var doc = diklat_pdf_file.value.split('.')
        var extension = doc[doc.length - 1]
       

     
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        if (fileSize > MaxSize ){
          errortoast("Maksimal Ukuran File 1 MB")
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

  

  $("#diklat_jenis").change(function() {
      var id = $("#diklat_jenis").val();
      $('#inputjd').show('fast')
      if(id == "00"){
      $('#inputjd').show('fast')
      } else if(id == "10") {
        $('#inputjd').show('fast')
      } else {
        $('#inputjd').hide('fast')
      }
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getJenjangDiklat",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].jenjang_diklat+'</option>';
                      }
                      $('.jdiklat').html(html);
                          }
                  });
  });

</script>