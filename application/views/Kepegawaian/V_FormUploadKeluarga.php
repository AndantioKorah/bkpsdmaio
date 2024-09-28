

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalKeluarga">
  Tambah Data Keluarga
</button>


<button onclick="loadRiwayatUsulKeluarga()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalKeluarga">
  Riwayat Usul Keluarga
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('keluarga')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('keluarga')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('keluarga')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>
<script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>


<!-- <style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style> -->
<div class="modal fade" id="myModalKeluarga">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_keluarga"></div>
        </div>
       
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalKeluarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Keluarga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_keluarga" enctype="multipart/form-data" >
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    
  <div class="form-group">
    <label>Hubungan Keluarga</label>
    <select onchange="onChangeHubkel()"  class="form-control " data-dropdown-css-class="select2-navy" name="hubkel" id="hubkel" required>
                    <option value="" disabled selected>Pilih Item</option>
                    
                    <?php if($hubungan_keluarga){ foreach($hubungan_keluarga as $r){ ?>
                        <option value="<?=$r['id_keluarga']?>"><?=$r['nm_keluarga']?></option>
                    <?php } } ?>
</select>
  </div>

  <div class="form-group" id="pas_ke" style="display:none;">
    <label>Pasangan Ke</label>
    <input autocomplete="off" class="form-control " type="number" id="pasangan_ke" name="pasangan_ke"  />
  </div>

  <div class="form-group" id="tgl_nikah" style="display:none;">
    <label>Tanggal Menikah</label>
    <input autocomplete="off" class="form-control datepicker" type="text" id="tglnikah" name="tglnikah"  />
  </div>

  <div class="form-group" id="stts_anak" style="display:none;">
    <label>Status Anak</label>
    <select  class="form-control " data-dropdown-css-class="select2-navy" name="statusanak" id="statusanak" >
                    <option value="" disabled selected>Pilih Item</option>
                    <option value="1">Anak Kandung</option>
                    <option value="2">Anak Tiri</option>              
    </select>
  </div>

  <div class="form-group" id="ortu_anak" style="display:none;">
    <label>Nama Ayah/Ibu Anak</label>
    <input class="form-control customInput" type="text" id="nama_ortu_anak" name="nama_ortu_anak"/>
  </div>

  <div class="form-group">
    <label>Nama</label>
    <input class="form-control customInput" type="text" id="namakel" name="namakel"  required/>
  </div>

  <div class="form-group">
    <label>Tempat Lahir</label>
    <input class="form-control customInput" type="text" id="tptlahir" name="tptlahir"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Lahir</label>
    <input autocomplete="off" class="form-control datepicker" type="text" id="tgllahir" name="tgllahir"  required/>
  </div>

  <div class="form-group">
    <label>Pendidikan</label>
    <input class="form-control customInput" type="text" id="pendidikan" name="pendidikan"  required/>
  </div>

  <div class="form-group">
    <label>Pekerjaan</label>
    <input class="form-control customInput" type="text" id="pekerjaan" name="pekerjaan"  required/>
  </div>

  <div class="form-group" id="akte" style="display:none;">
    <label>Akte Nikah / Akte Anak</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_keluarga" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_keluarga"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_keluarga">

</div>


<div class="modal fade" id="modal_view_file_keluarga" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_jabatan"  frameborder="0" ></iframe>	
      </div>
        </div>
      </div>
    </div>
</div>
 

<!-- Modal -->
<div class="modal fade" id="modal_edit_keluarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Keluarga</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_keluarga_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">


$(function(){
        // $('.select2').select2()

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  
  $('#datatable').dataTable()
  loadListKeluarga()

  })


// $(function(){

//   $(".select2").select2();

//     loadListKeluarga()

//     })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
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

    
        $('#upload_form_keluarga').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_keluarga');
        var form_data = new FormData(formvalue[0]);


        var hubkel = $('#hubkel').val()
        var tgl_nikah = $('#tglnikah').val()
        var paske = $('#pasangan_ke').val()
        var stts_anak = $('#statusanak').val()
        var ortu_anak = $('#nama_ortu_anak').val()
        var ins = document.getElementById('pdf_file_keluarga').files.length;
       

        if(hubkel == 20 || hubkel == 30){
          if(paske == "") {
            errortoast("Pasagan Ke berapa belum di sisi")
            return false;
          }
          if(tgl_nikah == "") {
            errortoast("Tanggal Menikah belum di sisi")
            return false;
          }
          if(ins == 0){
          errortoast("Silahkan upload file terlebih dahulu");
          return false;
          }
        } else if(hubkel == 40){
          if(stts_anak == "" || stts_anak == null) {
            errortoast("Status Anak belum di sisi")
            return false;
          }
          if(ortu_anak == "") {
            errortoast("Nama orang tua anak belum di sisi")
            return false;
          }
          if(ins == 0){
          errortoast("Silahkan upload file terlebih dahulu");
          return false;
          }
        }
  
       
        document.getElementById('btn_upload_keluarga').disabled = true;
        $('#btn_upload_keluarga').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUploadKeluarga")?>",
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
                document.getElementById("upload_form_keluarga").reset();
                document.getElementById('btn_upload_keluarga').disabled = false;
               $('#btn_upload_keluarga').html('Simpan')
                loadListKeluarga()
                setTimeout(function() {$("#modalKeluarga").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListKeluarga(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_keluarga').html('')
    $('#list_keluarga').append(divLoaderNavy)
    $('#list_keluarga').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListKeluarga/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulKeluarga(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_keluarga').html('')
    $('#riwayat_usul_keluarga').append(divLoaderNavy)
    $('#riwayat_usul_keluarga').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListKeluarga/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }


    function onChangeHubkel(val) {
    var val = $('#hubkel').val()
    if(val == 20 || val == 30){
    $('#akte').show('fast')
    $('#pas_ke').show('fast')
    $('#tgl_nikah').show('fast')
    $('#stts_anak').hide('fast')
    $('#ortu_anak').hide('fast')
    } else if(val == 40){
      $('#pas_ke').hide('fast')
      $('#tgl_nikah').hide('fast')  
      $('#stts_anak').show('fast')
      $('#ortu_anak').show('fast')
      $('#akte').show('fast')

    } else {
      $('#pas_ke').hide('fast')
      $('#tgl_nikah').hide('fast')
      $('#stts_anak').hide('fast')
      $('#ortu_anak').hide('fast')
      $('#akte').hide('fast')

    }
    }


    $("#pdf_file_keluarga").change(function (e) {

      var doc = pdf_file_keluarga.value.split('.');
      var MaxSize = 1024;
      var fileSize = this.files[0].size/1024;
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

</script>