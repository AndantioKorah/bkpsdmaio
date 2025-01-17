

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalPendidikan">
  Tambah Data Pendidikan
</button>

<button onclick="loadRiwayatUsulPendidikan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalPendidikan">
  Riwayat Usul Pendidikan
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm_pendidikan) {?>
<?php
if($pdm_pendidikan[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('ijazah')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm_pendidikan[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('ijazah')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('ijazah')"   
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
<div class="modal fade" id="myModalPendidikan">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_pendidikan"></div>
        </div>
       
      </div>
    </div>
</div>



<div class="modal fade" id="modal_view_file_pendidikan" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_pendidikan"  frameborder="0" ></iframe>	
           
          </div>
        </div>
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalPendidikan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Pendidikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_pendidikan" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Tingkat Pendidikan </label>
    <select class="form-control select2" data-dropdown-parent="#modalPendidikan" data-dropdown-css-class="select2-navy" name="pendidikan_tingkat" id="pendidikan_tingkat" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_tingkat_pendidikan){ foreach($list_tingkat_pendidikan as $r){ ?>
                        <option value="<?=$r['id_tktpendidikanb']?>"><?=$r['nm_tktpendidikanb']?></option>
                    <?php } } ?>
    </select>
    </div>
   

  <div class="form-group">
    <label>Jurusan</label>
    <input class="form-control customInput" type="text" id="pendidikan_jurusan" name="pendidikan_jurusan"  required/>
  </div>

  <div class="form-group">
    <label>Fakultas</label>
    <input class="form-control customInput" type="text" id="pendidikan_fakultas" name="pendidikan_fakultas"  required/>
  </div>

  <div class="form-group">
    <label>Nama Sekolah/Universitas</label>
    <input class="form-control customInput" type="text" id="pendidikan_nama_sekolah_universitas" name="pendidikan_nama_sekolah_universitas"  required/>
  </div>

  <div class="form-group">
    <label>Nama Pimpian</label>
    <input class="form-control customInput" type="text" id="pendidikan_nama_pimpinan" name="pendidikan_nama_pimpinan"  required/>
  </div>

  <div class="form-group">
    <label>Tahun Lulus</label>
    <input autocomplete="off" class="form-control yearpicker" type="text" id="pendidikan_tahun_lulus" name="pendidikan_tahun_lulus"  required/>
  </div>

  <div class="form-group">
    <label>No. STTB/Ijazah</label>
    <input class="form-control customInput" type="text" id="pendidikan_no_ijazah" name="pendidikan_no_ijazah"  required/>
  </div>

  <div class="form-group">
    <label>Tgl. STTB/Ijazah</label>
    <input autocomplete="off"  class="form-control datepicker"   id="pendidikan_tanggal_ijazah" name="pendidikan_tanggal_ijazah" required/>
  </div>

  <div class="form-group">
    <label>File Ijazah</label>
    <input  class="form-control my-image-field" type="file" id="pendidikan_pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_pendidikan"><i class="fa fa-save"></i> SIMPAN</button>
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



  

<div id="list_pendidikan">

</div>


<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
 
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      


<!-- Modal -->
<div class="modal fade" id="modal_edit_pendidikan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pendidikan</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_pendidikan_pegawai">
          
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
        loadListPendidikan()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});


    
        $('#upload_form_pendidikan').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_pendidikan');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pendidikan_pdf_file').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

        document.getElementById('btn_upload_pendidikan').disabled = true;
        $('#btn_upload_pendidikan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
      
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
                document.getElementById("upload_form_pendidikan").reset();
                document.getElementById('btn_upload_pendidikan').disabled = false;
               $('#btn_upload_pendidikan').html('Simpan')
                loadListPendidikan()
                setTimeout(function() {$("#modalPendidikan").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListPendidikan(){
    var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_pendidikan').html('')
    $('#list_pendidikan').append(divLoaderNavy)
    $('#list_pendidikan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPendidikan/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulPendidikan(){
    var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_pendidikan').html('')
    $('#riwayat_usul_pendidikan').append(divLoaderNavy)
    $('#riwayat_usul_pendidikan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPendidikan/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

  

  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  $("#pendidikan_pdf_file").change(function (e) {

        // var extension = pendidikan_pdf_file.value.split('.')[1];
        var doc = pendidikan_pdf_file.value.split('.')
        var extension = doc[doc.length - 1]

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