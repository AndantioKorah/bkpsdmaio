

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<button onclick="loadRiwayatUsulSkp()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalSkp">
  Riwayat Usul SKP
</button>

<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSkp">
  Tambah Data SKP
</button>



<!-- <button onclick="loadRiwayatUsulSkp()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalSkp">
  Riwayat Usul SKP
</button> -->

<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('skp_tahunan')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <input type="hidden"  id="jumlahdokskp" value="<?php if($profil_pegawai['statuspeg'] == "3")  echo "1"; else echo $dok['total'];?>">
  <button  onclick="openModalStatusPmd('skp_tahunan')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 
<input type="hidden"  id="jumlahdokskp" value="<?php if($profil_pegawai['statuspeg'] == "3")  echo "1"; else echo $dok['total'];?>">
<button  onclick="openModalStatusPmd('skp_tahunan')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>
<?php 
// if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ 
  ?>
  <button onclick="syncRiwayatSkpSiasn('<?=$profil_pegawai['id_m_user']?>')" class="btn btn-block text-right float-right btn-info ml-2">
    <i class="fa fa-file-download"></i> Sinkron Riwayat SKP SIASN
  </button><br>
  <?php $messageSinkron = "";
    $txtcolor = "grey";
    if($sinkronSiasn){
      if($sinkronSiasn['flag_done'] == 1){
        $txtcolor = "green";
        $messageSinkron = "Sinkronisasi SKP SIASN sudah selesai";
      } else {
        $log = json_decode($sinkronSiasn['log'], true);
        $logMessage = null;
        if($log && isset($log['data']) && $log['data']){
          $logMessage = json_decode($log['data'], true);
        }
        $errMessage = "";
        if(isset($logMessage['data']['message'])){
          $errMessage = isset($logMessage['data']['message']) ? $logMessage['data']['message'] : $logMessage['data'];
        }
        $errMessageFooter = "<br>Last try sinkron: ".formatDateNamaBulanWT($sinkronSiasn['last_try_date'])."<br>Log: ".$errMessage;
        if($sinkronSiasn['temp_count'] == 3){
          $txtcolor = "red";
          $messageSinkron = "Sinkronisasi SKP SIASN gagal".$errMessageFooter;
        } else {
          $txtcolor = "blue";
          $messageSinkron = "sedang dilakukan sinkronisasi dengan ".$sinkronSiasn['temp_count']." kali percobaan".$errMessageFooter;
        }
      }
    } else {
      $messageSinkron = "Belum dilakukan sinkronisasi SKP SIASN";
    }
  ?>
  <div class="row">
    <div class="col-lg-12 text-right" style="margin-bottom: 15px;">
      <span style="color: <?=$txtcolor?>; font-size: .7rem; font-weight: bold; font-style: italic;"><?=$messageSinkron?></span>
    </div>
  </div>
  <!-- <button data-toggle="modal" onclick="openSiasn('SKP', '<?=$profil_pegawai['id_m_user']?>')" href="#modal_sync_siasn" class="btn btn-block text-right float-right btn-navy">
    <i class="fa fa-users-cog"></i> SIASN
  </button> -->
<?php 
// } 
?>


<script>
  function syncRiwayatSkpSiasn(id_m_user){
    $('#list_skp').html('')
    $('#list_skp').append(divLoaderNavy)
    $.ajax({
      url: '<?=base_url("siasn/C_Siasn/syncRiwayatSkpSiasn/")?>'+id_m_user,
      method: 'POST',
      data: null,
      success: function(data){
        $('#list_skp').html('')
        let rs = JSON.parse(data)
        if(rs.code == 0){
          successtoast(rs.message)
        } else {
          errortoast(rs.message)
        }
        loadListSkp()
      }, error: function(err){
        $('#list_skp').html('')
        loadListSkp()
      }
    })

    loadListSkp()
  }

  function openModalStatusPmd(jenisberkas){
    var jumlahskp = $('#jumlahdokskp').val()
    if(jumlahskp == 0){
      jenisberkas = null 
    }
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
<div class="modal fade" id="myModalSkp">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_skp"></div>
        </div>
       
      </div>
    </div>
</div>

<div class="modal fade" id="modal_view_file_skp" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
        <iframe id="iframe_view_file_skp" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>


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
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    
  <div class="form-group">
    <label>Tahun</label>
    <input class="form-control yearpicker" type="text" id="gb_masa_kerja" name="skp_tahun" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Nilai</label>
    <input min=0 step=0.01 class="form-control customInput" type="number" id="skp_nilai" name="skp_nilai" />
  </div>

  <!-- <div class="form-group">
    <label>Predikat</label>
    <input class="form-control customInput" type="text" id="skp_predikat" name="skp_predikat"  required/>
  </div> -->

  <div class="form-group " style="margin-bottom:10px !important;">
<label >Predikat</label>
<select  class="form-control  "  name="skp_predikat" id="skp_predikat" required>
                <option value="" disabled selected>Pilih Predikat</option>
                <option value="Sangat Baik">Sangat Baik</option>
                <option value="Baik">Baik</option>
                <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                <option value="Kurang">Kurang</option>
                <option value="Sangat Kurang">Sangat Kurang</option>
                <?php if($jenis_penugasan){ foreach($jenis_penugasan as $r){ ?>
                  <option value="<?=$r['id_jenistugas']?>"><?=$r['nm_jenistugas']?></option>
                <?php } } ?>
</select>
</div>

 
  <div class="form-group">
    <label>File SKP</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_skp" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_skp"><i class="fa fa-save"></i> SIMPAN</button>
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



<!-- Modal -->
<div class="modal fade" id="modal_edit_skp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail SKP</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_skp_pegawai">
          
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
      loadListSkp()
    })

    


    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });

    var statuspeg = "<?= $profil_pegawai['statuspeg']?>";
    var end = new Date();
    end.setFullYear(end.getFullYear() - 2);
    if(statuspeg == 1 || statuspeg == 2){
    $('.yearpicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    endDate: end,
    autoclose: true
    });
    } else {
      $('.yearpicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    // endDate: end,
    autoclose: true
    });
    }
   

    
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
       
        document.getElementById('btn_upload_skp').disabled = true;
        $('#btn_upload_skp').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById('btn_upload_skp').disabled = false;
               $('#btn_upload_skp').html('Simpan')
                // loadListSkp()
                // setTimeout(function() {$("#modalSkp").trigger( "click" );}, 1000);
                setTimeout(function() {$("#modalSkp").trigger( "click" );}, 1000);
                setTimeout(function() {$("#pills-skp-tab").trigger( "click" );}, 2000);

              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListSkp(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_skp').html('')
    $('#list_skp').append(divLoaderNavy)
    $('#list_skp').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSkp/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulSkp(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_skp').html('')
    $('#riwayat_usul_skp').append(divLoaderNavy)
    $('#riwayat_usul_skp').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSkp/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }

    

  $("#pdf_file_skp").change(function (e) {

        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>

        var doc = pdf_file_skp.value.split('.')
        var extension = doc[doc.length - 1]
     
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