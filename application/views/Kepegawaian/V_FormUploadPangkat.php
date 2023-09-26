<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
  Tambah Data Pangkat
</button>
<button onclick="loadRiwayatUsulListPangkat()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModal">
  Riwayat Usul Pangkat
</button>



<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>
  
<?php if($pdm_pangkat) {?>
<?php
if($pdm_pangkat[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('pangkat')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm_pangkat[0]['flag_active'] == 0) { ?>
  <button  onclick="openModalStatusPmd('pangkat')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 

<button  onclick="openModalStatusPmd('pangkat')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }?>
  
  <script>
    function openModalStatusPmd(jenisberkas){
        $(".modal-body #jenis_berkas").val( jenisberkas );
  }
</script>
  
  
<!-- Modal -->
<!-- <div class="modal fade" id="pdmPangkatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Simpan Perubahan Status Berkas ?
      </div>
      <form method="post" id="form_status_berkas" enctype="multipart/form-data" >
      <input type="hidden" name="jenis_berkas" id="jenis_berkas" value="pangkat">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="modal_dismis" data-dismiss="modal">Batal</button>
        <button class="btn btn-block btn-primary" >Ya</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    $('#form_status_berkas').on('submit', function(e){  
      
        e.preventDefault();
        var formvalue = $('#form_status_berkas');
        var form_data = new FormData(formvalue[0]);

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/updateStatusBerkas")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
                successtoast(result.msg)
                setTimeout(function() {$("#modal_dismis").trigger( "click" );}, 1000);
                setTimeout(loadFormPangkat, 1500);
              } else {
                errortoast(result.msg)
                return false;
              } 
        }  
        });  
          
        });

  
</script> -->


<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModal">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_pangkat"></div>
        </div>
       
      </div>
    </div>
</div>
<div class="modal fade" id="modal_view_file" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
           <div id="modal_view_file_content">
            <h5 id="iframe_loader" class="text-center"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file"  frameborder="0" ></iframe>	
         </div>
        </div>
      </div>
    </div>
</div>




<!-- <tr>
<td>Pangkat Terakhir </td>
<td>:</td>
<td><?= $profil_pegawai['nm_pangkat'];?></td>
</tr>

<tr>
<td style="vertical-align: top;">TMT Pangkat </td>
<td style="vertical-align: top;">:</td>
<td style="vertical-align: top;" height="40px;" ><?= formatDateNamaBulan($profil_pegawai['tmtpangkat']);?></td>
</tr>  -->
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Data Pangkat</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       

   <form method="post" id="upload_form" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">

    <div class="form-group " style="margin-bottom:10px !important;">
    <label >Jenis Pengangkatan</label>
    <select  class="form-control select2 " data-dropdown-css-class="select2-navy" name="jenis_pengangkatan" id="jenis_pengangkatan" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_pengangkatan){ foreach($jenis_pengangkatan as $r){ ?>
                        <option value="<?=$r['id_jenispengangkatan']?>"><?=$r['nm_jenispengangkatan']?></option>
                    <?php } } ?>
</select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Pangkat - Gol/Ruang </label>
    <select style="width: 100% important!" class="form-control select2" data-dropdown-css-class="select2-navy" name="pangkat" id="pangkat" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_pangkat){ foreach($list_pangkat as $r){ ?>
                        <option value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
</select>
    </div>

    
   

   <div class="form-group">
    <label>TMT Pangkat</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tmt_pangkat" name="tmt_pangkat" required/>
  </div>
  
  <div class="form-group">
    <label>Masa Kerja</label>
    <input class="form-control" type="text" id="masa_kerja" name="masa_kerja"  required/>
  </div>

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control" type="text" id="pejabat" name="pejabat"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control" type="text" id="no_sk" name="no_sk"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tanggal_sk" name="tanggal_sk" required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary"  id="btn_upload_pangkat"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- tutup modal  -->

<div id="list_pangkat">

</div>


<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <!-- <div class="modal-body" id="modal_view_file_content">
        <iframe  style="width: 100%; height: 80vh;"   id="iframe_view_file"  frameborder="0" ></iframe>	
      </div> -->
    </div>
  </div>
</div>                      


<div class="modal fade" id="modalRiwayatUsulPangkat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="">
       
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
  
    $('#datatable').dataTable()
        loadListPangkat()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        document.getElementById('btn_upload_pangkat').disabled = true;
        $('#btn_upload_pangkat').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById("upload_form").reset();
                document.getElementById('btn_upload_pangkat').disabled = false;
               $('#btn_upload_pangkat').html('Simpan')
                loadListPangkat()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListPangkat(){
    var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_pangkat').html('')
    $('#list_pangkat').append(divLoaderNavy)
    $('#list_pangkat').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPangkat/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulListPangkat(){
    var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_pangkat').html('')
    $('#riwayat_usul_pangkat').append(divLoaderNavy)
    $('#riwayat_usul_pangkat').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPangkat/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }


  $("#pdf_file").change(function (e) {

        var extension = pdf_file.value.split('.')[1];
      
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