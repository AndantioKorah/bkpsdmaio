

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<button onclick="loadRiwayatUsulJabatan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalJabatan">
  Riwayat Usul Jabatan
</button>


<?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() == false AND $this->general_library->isHakAkses('akses_profil_pegawai') AND $this->general_library->getUserName() != $nip AND $this->general_library->isAdminAplikasi() == false){ ?>
  <!-- <button onclick="loadRiwayatUsulJabatan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalJabatan">
  Riwayat Usul Jabatan
  </button> -->
<?php }  ?>

<!-- Button trigger modal -->
<?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalJabatan">
  Tambah Data Jabatan
</button>


<!-- <button onclick="loadRiwayatUsulJabatan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalJabatan">
  Riwayat Usul Jabatan
</button> -->


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
<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) { ?>
  <button onclick="syncRiwayatJabatanSiasn('<?=$profil_pegawai['id_m_user']?>')" class="btn btn-block text-right float-right btn-info ml-2">
    <i class="fa fa-file-download"></i> Sinkron Riwayat Jabatan SIASN
  </button>
  <button data-toggle="modal" onclick="openSiasn('jabatan', '<?=$profil_pegawai['id_m_user']?>')" href="#modal_sync_siasn" class="btn btn-block text-right float-right btn-navy">
    <i class="fa fa-users-cog"></i> SIASN
  </button><br>
  <?php $messageSinkron = "";
    $txtcolor = "grey";
    if($sinkronSiasn){
      if($sinkronSiasn['flag_done'] == 1){
        $txtcolor = "green";
        $messageSinkron = "Sinkronisasi Jabatan SIASN sudah selesai";
      } else {
        $log = json_decode($sinkronSiasn['log'], true);
        $logMessage = null;
        if($log && isset($log['data']) && $log['data']){
          $logMessage = json_decode($log['data'], true);
        }
        $errMessage = "";
        if($logMessage){
          $errMessage = isset($logMessage['message']) ? $logMessage['message'] : $logMessage['data'];
        }
        $errMessageFooter = "<br>Last try sinkron: ".formatDateNamaBulanWT($sinkronSiasn['last_try_date'])."<br>Log: ".$errMessage;
        if($sinkronSiasn['temp_count'] == 3){
          $txtcolor = "red";
          $messageSinkron = "Sinkronisasi Jabatan SIASN gagal".$errMessageFooter;
        } else {
          $txtcolor = "blue";
          $messageSinkron = "sedang dilakukan sinkronisasi dengan ".$sinkronSiasn['temp_count']." kali percobaan".$errMessageFooter;
        }
      }
    } else {
      $messageSinkron = "Belum dilakukan sinkronisasi Jabatan SIASN";
    }
  ?>
  <div class="row">
    <div class="col-lg-12 text-right" style="margin-bottom: 15px;">
      <span style="color: <?=$txtcolor?>; font-size: .7rem; font-weight: bold; font-style: italic;"><?=$messageSinkron?></span>
    </div>
  </div>
<?php } ?>
<script>
    function openModalStatusPmd(jenisberkas){
      var jumlah = $('#jumlahdokjab').val()
      if(jumlah == 0){
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

<div class="modal fade" id="modal_sync_siasn" data-backdrop="static">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">RIWAYAT JABATAN SIASN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body" id="modal_sync_siasn_content">
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
                        <option <?php if($profil_pegawai['skpd'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?> value="<?=$r['id_unitkerja']?>/<?=$r['nm_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>

    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
      <label for="jabatan_unitkerja">Unor SIASN </label>
      <select class="form-control select2" data-dropdown-parent="#modalJabatan"  name="id_unor_siasn" id="id_unor_siasn"   >
                      <option value="" disabled selected>Pilih Unor SIASN</option>
                      <?php if($unor_siasn){ foreach($unor_siasn as $r){ ?>
                          <option value="<?=$r['id']?>"><?=$r['nama']?></option>
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
                    <option value="40">Lainnya</option>
    </select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important; display:none" id="div_jf">
    <label for="jabatan_jenis">Jenis Fungsional </label>
    <select class="form-control select2" data-dropdown-parent="#modalJabatan" data-dropdown-css-class="select2-navy" name="jenis_fungsional" id="jenis_fungsional" required>
                    <option value="1" selected>JFT</option>
                    <option value="2" >JFU</option>           
    </select>
    </div>


    <div class="form-check" style="display:none">
      <input class="form-check-input" type="checkbox" value="1" name="myCheck" id="myCheck" onclick="myFunction()">
      <label class="form-check-label" for="myCheck">
        Jabatan Lama
      </label>
    </div>


 

    <div class="form-group" style="display:none" id="text">
    <label>Nama Jabatan</label>
    <input autocomplete="off"  class="form-control"  id="jabatan_lama" name="jabatan_lama"/>
    </div>

    <script>
      function myFunction() {
        // Get the checkbox
        var checkBox = document.getElementById("myCheck");
        // Get the output text
        var text = document.getElementById("text");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true){
          text.style.display = "block";
          $('#jabatan_baru').hide('fast')
        } else {
          text.style.display = "none";
          $('#jabatan_baru').show('fast')
        }
      }
      </script>


    <div class="form-group" style="margin-bottom:10px !important;" id="jabatan_baru">
    <label for="jabatan_jenis">Nama Jabatan </label>
     <select class="form-control select2 nama_jab" data-dropdown-parent="#modalJabatan" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" >
                        <option value="" selected>Pilih Jabatan</option>
                    </select>
    <!-- <select class="form-control select2" data-dropdown-parent="#modalJabatan" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" >
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option value="<?=$r['id_jabatanpeg']?>,<?=$r['nama_jabatan']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
    </select> -->
    </div>

    <script>
      function syncRiwayatJabatanSiasn(id_m_user){
        // $('#list_jabatan').html('')
        // $('#list_jabatan').append(divLoaderNavy)
        // $('#list_jabatan').load('<?=base_url("siasn/C_Siasn/syncRiwayatJabatanSiasn/")?>'+id_m_user, function(){
        //   $('#loader').hide()
        // })
        $('#list_jabatan').html('')
        $('#list_jabatan').append(divLoaderNavy)
        $.ajax({
          url: '<?=base_url("siasn/C_Siasn/syncRiwayatJabatanSiasn/")?>'+id_m_user,
          method: 'POST',
          data: null,
          success: function(data){
            $('#list_jabatan').html('')
            let rs = JSON.parse(data)
            if(rs.code == 0){
              successtoast(rs.message)
            } else {
              errortoast(rs.message)
            }
            loadListJabatan()
          }, error: function(err){
            $('#list_jabatan').html('')
            loadListJabatan()
          }
        })

        loadListJabatan()
      }
      
      function openSiasn(jenis, id){
        $('#modal_sync_siasn_content').html('')
        $('#modal_sync_siasn_content').append(divLoaderNavy)
        $('#modal_sync_siasn_content').load('<?=base_url("siasn/C_Siasn/siasnJabatan/")?>'+id, function(){
          $('#loader').hide()
        })
      }

       $("#jenis_fungsional").change(function() {
      var id = $("#jabatan_jenis").val();
      var skpd = $("#jabatan_unitkerja").val();
      var jnsfung = $("#jenis_fungsional").val();
     
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatajab",
              method : "POST",
              data : {id: id, skpd: skpd, jnsfung: jnsfung},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                        html += '<option value="'+data[i].id+';'+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                      }
                      $('.nama_jab').html(html);
                          }
                  });
            });

            $("#jabatan_jenis").change(function() {
                var id = $("#jabatan_jenis").val();
                var skpd = $("#jabatan_unitkerja").val();
                var jnsfung = $("#jenis_fungsional").val();

                if(id == "00"){
                  $("#div_jf").hide('fast');
                } else if(id == "40") {
                  $("#div_jf").hide('fast');
                } else {
                  $("#div_jf").show('fast');
                }

                $.ajax({
                        url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatajab",
                        method : "POST",
                        data : {id: id, skpd: skpd, jnsfung: jnsfung},
                        async : false,
                        dataType : 'json',
                        success: function(data){
                        var html = '';
                                var i;
                                for(i=0; i<data.length; i++){
                                  html += '<option value="'+data[i].id+';'+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                                }
                                $('.nama_jab').html(html);
                                    }
                            });
            });

            $("#jabatan_unitkerja").change(function() {
                var id = $("#jabatan_jenis").val();
                var skpd = $("#jabatan_unitkerja").val();
                var jnsfung = $("#jenis_fungsional").val();

                if(id == "00"){
                  $("#div_jf").hide('fast');
                } else {
                  $("#div_jf").show('fast');
                }

                $.ajax({
                        url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatajab",
                        method : "POST",
                        data : {id: id, skpd: skpd, jnsfung: jnsfung},
                        async : false,
                        dataType : 'json',
                        success: function(data){
                        var html = '';
                                var i;
                                for(i=0; i<data.length; i++){
                                  html += '<option value="'+data[i].id+';'+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                                }
                                $('.nama_jab').html(html);
                                    }
                            });
            });
    </script>
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
    <input class="form-control customInput" type="text" id="jabatan_keterangan" name="jabatan_keterangan"  />
  </div>


  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="jabatan_pdf_file" name="file"  />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group">
    <!-- <label>File SK</label> -->
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" name="flag_upload_siasn" id="flag_upload_siasn">
      <label class="form-check-label" for="flag_upload_siasn">
        Upload SIASN
      </label>
    </div>
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


<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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




<div class="modal fade" id="modal_edit_jabatan" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Jabatan</h5>
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
        var checkBox = document.getElementById("myCheck")
        var jabatan_lama = $('#jabatan_lama').val()
        var jabatan_nama = $('#jabatan_nama').val()
       
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

      
        document.getElementById('btn_upload_jabatan').disabled = true;
        $('#btn_upload_jabatan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

        if (checkBox.checked == true){
         if(jabatan_lama == ""){
          errortoast("Silahkan isi nama jabatan  terlebih dahulu");
          document.getElementById('btn_upload_jabatan').disabled = false;
          $('#btn_upload_jabatan').html('Simpan')
          return false
         }
        } else {
          if(jabatan_nama == ""){
          errortoast("Silahkan isi nama jabatan  terlebih dahulu");
          document.getElementById('btn_upload_jabatan').disabled = false;
          $('#btn_upload_jabatan').html('Simpan')
          return false
         }

         if(jabatan_nama == null){
          errortoast("Silahkan isi nama jabatan  terlebih dahulu");
          document.getElementById('btn_upload_jabatan').disabled = false;
          $('#btn_upload_jabatan').html('Simpan')
          return false
         }
        }


        if(tmtjabatan == ""){
          document.getElementById('btn_upload_jabatan').disabled = false;
          $('#btn_upload_jabatan').html('Simpan')
          errortoast("tmt jabatan masih kosong")
          document.getElementById("jabatan_tmt").focus();
          return false;
        }

        if(tglsk == ""){
          document.getElementById('btn_upload_jabatan').disabled = false;
          $('#btn_upload_jabatan').html('Simpan')
          errortoast("tanggal sk masih kosong")
          document.getElementById("jabatan_tanggal_sk").focus();
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