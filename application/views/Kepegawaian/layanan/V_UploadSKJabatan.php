<form method="post" id="upload_form_jabatan" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    <input type="hidden" id="id_usul" name="id_usul" value="<?= $id_usul;?>">
    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_unitkerja">Unit Kerja </label>
    <select class="form-control select2"   name="jabatan_unitkerja" id="jabatan_unitkerja" required>
                    <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option <?php if($profil_pegawai['skpd'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?> value="<?=$r['id_unitkerja']?>/<?=$r['nm_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>

    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
      <label for="jabatan_unitkerja">Unor SIASN </label>
      <select class="form-control select2"  name="id_unor_siasn" id="id_unor_siasn"   >
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
    <select class="form-control select2"  data-dropdown-css-class="select2-navy" name="jabatan_jenis" id="jabatan_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
                    <option value="40">Lainnya</option>
    </select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important; display:none" id="div_jf">
    <label for="jabatan_jenis">Jenis Fungsional </label>
    <select class="form-control select2"  data-dropdown-css-class="select2-navy" name="jenis_fungsional" id="jenis_fungsional" required>
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
     <select class="form-control select2 nama_jab"  data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" >
                        <option value="" selected>Pilih Jabatan</option>
                    </select>
    <!-- <select class="form-control select2"  data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" >
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
                    <option selected value=1 >Definitif</option>
                    <option value=2 >Plt</option>
                    <option value=3 >Plh</option>
                    
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

<script type="text/javascript">


$(function(){

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

    $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
        // viewMode: "years", 
        // minViewMode: "years",
        // orientation: 'bottom',
        autoclose: true
    });
    
        })

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


// document.getElementById('btn_upload_jabatan').disabled = true;
// $('#btn_upload_jabatan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

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
url:"<?=base_url("kepegawaian/C_Kepegawaian/uploadSKLayanan")?>",
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

    </script>