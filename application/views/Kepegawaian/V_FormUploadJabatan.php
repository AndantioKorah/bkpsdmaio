

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>


<!-- Button trigger modal -->
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalJabatan">
  Tambah Data Jabatan
</button>


<button onclick="loadRiwayatUsulJabatan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalJabatan">
  Riwayat Usul Jabatan
</button>


<!-- status pdm -->
<?php  if($this->general_library->isProgrammer() != true  && $this->general_library->isAdminAplikasi() != true){ ?>

<?php if($pdm) {?>
<?php
if($pdm[0]['flag_active'] == 1) {?>
<button onclick="openModalStatusPmd('jabatan')" type="button" class="btn btn-danger mb-2" data-toggle="modal" href="#pdmModal">
  Batal Berkas Sudah Lengkap
</button>
<?php } else if($pdm[0]['flag_active'] == 0) { ?>
  <input type="hidden"  id="jumlahdokjab" value="<?=$dok['total'];?>">
  <button  onclick="openModalStatusPmd('jabatan')" type="button" class="btn btn-success mb-2" data-toggle="modal" href="#pdmModal">
  Berkas Sudah Lengkap
</button>
<?php }  ?>
<?php } else { ?> 
  <input type="hidden"  id="jumlahdokjab" value="<?=$dok['total'];?>">
<button  onclick="openModalStatusPmd('jabatan')"   
data-toggle="modal" class="btn btn-success mb-2" href="#pdmModal"> Berkas Sudah Lengkap </button>
<?php }  ?>
<?php }  ?>
<?php }  ?>
<script>
    function openModalStatusPmd(jenisberkas){
      var jumlah = $('#jumlahdokjab').val()
      if(jumlah == 0){
        jenisberkas = null 
      }
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
<div class="modal fade" id="myModalJabatan">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_jabatan"></div>
        </div>
       
      </div>
    </div>
</div>



<div class="modal fade" id="modal_view_file_jabatan" data-backdrop="static">
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
<div class="modal fade" id="modalJabatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Jabatan</h5>
        <button type="button" id="modal_jabatan_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_jabatan" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    
    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_unitkerja">Unit Kerja </label>
    <select class="form-control select2" data-dropdown-parent="#modalJabatan"  name="jabatan_unitkerja" id="jabatan_unitkerja" required>
                    <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option <?php if($profil_pegawai['skpd'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?> value="<?=$r['id_unitkerja']?>,<?=$r['nm_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>

    </div>

    <script> 
        //      $("#jabatan_unitkerja").change(function() {
        //     var id_unitkerja = $("#jabatan_unitkerja").val();
        //     $("#jabatan_nama").select2({
        //         ajax: {
        //             url: '<?= base_url() ?>kepegawaian/C_Kepegawaian/getDataJabatan/' + id_unitkerja,
        //             type: "post",
        //             dataType: 'json',
        //             delay: 200,
        //             data: function(params) {
        //               console.log(params)
        //                 return {
        //                     searchTerm: params.term
        //                 };
        //             },
        //             processResults: function(response) {
        //                 return {
        //                     results: response
        //                 };
        //             },
        //             cache: true
        //         }
        //     });
        // });
    </script>



    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_jenis">Jenis Jabatan </label>
    <select class="form-control select2" data-dropdown-parent="#modalJabatan" data-dropdown-css-class="select2-navy" name="jabatan_jenis" id="jabatan_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
    </select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_jenis">Nama Jabatan </label>
    <!-- <select id="jabatan_nama" name="jabatan_nama" class="form-control select2">
                        <option value="" selected>Pilih Jabatan</option>
                    </select> -->
    <select class="form-control select2" data-dropdown-parent="#modalJabatan" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option value="<?=$r['id_jabatanpeg']?>,<?=$r['nama_jabatan']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
    </select>
    </div>
    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_jenis">Status Jabatan </label>
    <!-- <select id="jabatan_nama" name="jabatan_nama" class="form-control select2">
                        <option value="" selected>Pilih Jabatan</option>
                    </select> -->
                    <select class="form-control select2" data-dropdown-css-class="" name="jabatan_status" id="jabatan_status" required>
                   <?php if($statusjabatan == 'def') { ?>
                    <option value=1 >Definitif</option>
                   <?php } else { ?>
                    <option value=2 >Plt</option>
                    <option value=3 >Plh</option>
                    <?php } ?>
    </select>
    </div>
   

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control customInput" type="text" id="jabatan_pejabat" name="jabatan_pejabat"  required/>
  </div>

  <div class="form-group">
    <label>TMT Jabatan</label>
    <input autocomplete="off"  class="form-control datepicker"   id="jabatan_tmt" name="jabatan_tmt" readonly required/>
  </div>


  <div class="form-group" style="margin-bottom:10px !important;">
    <label >Eselon </label>
    <select class="form-control select2"  data-dropdown-css-class="select2-navy" name="jabatan_eselon" id="jabatan_eselon" required>
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
    <input autocomplete="off"  class="form-control datepicker"   id="jabatan_tanggal_sk" name="jabatan_tanggal_sk" readonly required/>
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
    <input  class="form-control my-image-field" type="file" id="jabatan_pdf_file" name="file"  />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload_jabatan"><i class="fa fa-save"></i> SIMPAN</button>
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



<div class="modal fade" id="modal_edit_jabatan" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pangkat</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_jabatan_pegawai">
          
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
        var tmtjabatan = $('#jabatan_tmt').val()
        var tglsk = $('#jabatan_tanggal_sk').val()
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

        // document.getElementById('btn_upload_jabatan').disabled = true;
       

        if(tmtjabatan == ""){
          errortoast("tmt jabatan masih kosong")
          document.getElementById("jabatan_tmt").focus();
          return false;
        }

        if(tglsk == ""){
          errortoast("tanggal sk masih kosong")
          document.getElementById("jabatan_tanggal_sk").focus();
          return false;
        }
        

        $('#btn_upload_jabatan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
       
     
      
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
                document.getElementById('btn_upload_jabatan').disabled = false;
               $('#btn_upload_jabatan').html('Simpan')
               setTimeout(function() {$("#modal_jabatan_dismis").trigger( "click" );}, 1500);
              location.reload();
                // loadListJabatan()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListJabatan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
      var statusjabatan = "<?= $statusjabatan?>";
    $('#list_jabatan').html('')
    $('#list_jabatan').append(divLoaderNavy)
    $('#list_jabatan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListJabatan/")?>'+nip+'/1'+'/'+statusjabatan, function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulJabatan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
      var statusjabatan = "<?= $statusjabatan?>";
    $('#riwayat_usul_jabatan').html('')
    $('#riwayat_usul_jabatan').append(divLoaderNavy)
    $('#riwayat_usul_jabatan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListJabatan/")?>'+nip+'/2'+'/'+statusjabatan, function(){
      $('#loader').hide()
    })
  }


  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  $("#jabatan_pdf_file").change(function (e) {

        // var extension = jabatan_pdf_file.value.split('.')[1];
        var doc = jabatan_pdf_file.value.split('.')
        var extension = doc[doc.length - 1]

        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>;
        
     
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
</script>