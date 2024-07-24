<style>
    .lbl-val{
        font-weight: bold;
        color: black;
        font-size: 1rem;
    }

    .lbl-name{
        font-weight: bold;
        color: grey;
        font-size: .6rem;
        font-style: italic;
    }
</style>

<div class="col-lg-12 text-right">
  <button id="btn_sync" class="btn btn-success" onclick="syncSiasn()" type="button"><i class="fa fa-sync"></i> Sinkron dengan SIASN</button>
  <button id="btn_sync_loading" disabled class="btn btn-success" type="button" style="display: none;"><i class="fa fa-spin fa-sync"></i> Mohon Menunggu</button>
</div>
<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
    <li class="nav-item nav-item-profile" role="presentation">
        <button class="nav-link nav-link-profile active" id="nav-edit-jabatan-tab"
        data-bs-toggle="pill" data-bs-target="#nav-edit-jabatan" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Edit Jabatan</button>
    </li>
    <li class="nav-item nav-item-profile" role="presentation">
        <button class="nav-link nav-link-profile" id="nav-jabatan-siasn-tab"
        data-bs-toggle="pill" data-bs-target="#nav-jabatan-siasn" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Jabatan SIASN</button>
    </li>
</ul>
<div class="col-lg-12">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane show active" id="nav-edit-jabatan" role="tabpanel" aria-labelledby="nav-edit-jabatan-tab">
          <form method="post" id="form_edit_jabatann" enctype="multipart/form-data" >
            <input type="hidden" id="id" name="id" value="<?= $jabatan[0]['id'];?>">
            <input type="hidden" id="id_peg" name="id_peg" value="<?= $jabatan[0]['id_pegawai'];?>">
            <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $jabatan[0]['gambarsk'];?>">
            <!-- <input type="text" id="edit_jabatan_unit_kerja" name="edit_jabatan_unit_kerja" value="<?= $jabatan[0]['id_unitkerja'];?>/<?= $jabatan[0]['skpd'];?>"> -->


            <?php if($jabatan[0]['status']==2){ ?>       
          
            <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
            <div style="display:none">
            <?php } else { ?> 
            <div>
            <?php } ?>
            <?php }?>

            <div class="form-group" style="margin-bottom:10px !important;">
              <label for="jabatan_unitkerja">Unit Kerja </label>
              <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan"  name="edit_jabatan_unit_kerja" id="edit_jabatan_unit_kerja"  <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?> >
                              <option value="" disabled selected>Pilih Unit Kerja</option>
                              <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                                  <option <?php if($jabatan[0]['id_unitkerja'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?> value="<?=$r['id_unitkerja']?>/<?=$r['nm_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                              <?php } } ?>
              </select>

              <label for="jabatan_unitkerja">Unor SIASN </label>
              <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan"  name="id_unor_siasn" id="id_unor_siasn"  <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?> >
                              <option value="" disabled selected>Pilih Unor SIASN</option>
                              <?php if($unor_siasn){ foreach($unor_siasn as $r){ ?>
                                  <option <?php if($jabatan[0]['id_unor_siasn'] == $r['id']) echo "selected"; else echo ""; ?> value="<?=$r['id']?>"><?=$r['nama']?></option>
                              <?php } } ?>
              </select>

              <div class="form-group" style="margin-bottom:10px !important;">
              <label for="jabatan_jenis">Jenis Jabatan </label>
              <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="edit_jabatan_jenis" id="edit_jabatan_jenis" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                              <option value="" disabled selected>Pilih Item</option>
                              <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                                  <option <?php if($jabatan[0]['jenisjabatan'] == $r['id_jenisjab']) echo "selected"; else echo ""; ?> value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                              <?php } } ?>
              </select>
              </div>


              <div class="form-group" style="margin-bottom:10px !important; display:none" id="edit_div_jf">
              <label for="jabatan_jenis">Jenis Fungsional </label>
              <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="edit_jenis_fungsional" id="edit_jenis_fungsional" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                              <option value="1" selected>JFT</option>
                              <option value="2" >JFU</option>
                            
              </select>
              </div>


              

              <div class="form-group" style="margin-bottom:10px !important;">
              <label for="jabatan_jenis">Status Jabatan </label>

                              <select class="form-control select2" data-dropdown-css-class="" name="edit_jabatan_status" id="edit_jabatan_status" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                              <option <?php if($jabatan[0]['statusjabatan'] == 1) echo "selected"; else echo ""; ?> value=1 >Definitif</option>
                              <option <?php if($jabatan[0]['statusjabatan'] == 2) echo "selected"; else echo ""; ?> value=2 >Plt</option>
                              <option <?php if($jabatan[0]['statusjabatan'] == 3) echo "selected"; else echo ""; ?> value=3 >Plh</option>
              </select>
              </div>
            



            <div class="form-group" style="margin-bottom:10px !important;">
              <label >Eselon </label>
              <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan"  data-dropdown-css-class="select2-navy" name="edit_jabatan_eselon" id="edit_jabatan_eselon" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                              <option value="" disabled selected>Pilih Item</option>
                              <?php if($eselon){ foreach($eselon as $r){ ?>
                                  <option <?php if($jabatan[0]['eselon'] == $r['id_eselon']) echo "selected"; else echo ""; ?>  value="<?=$r['id_eselon']?>"><?=$r['nm_eselon']?></option>
                              <?php } } ?>
              </select>
              </div>

          

              <div class="form-group" style="margin-bottom:10px !important;" id="jabatan_baru">
              <label for="jabatan_jenis">Nama Jabatan </label>
              <select class="form-control select2 edit_nama_jab" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                              <option value="" disabled selected>Pilih Item</option>
                              <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                                  <option <?php if($r['id_jabatanpeg'] == $jabatan[0]['id_jabatan']) echo "selected"; else echo "";?> value="<?=$r['id_jabatanpeg']?>,<?=$r['nama_jabatan']?>"><?=$r['nama_jabatan']?></option>
                              <?php } } ?>
              </select>
              </div>

              <!-- <div class="form-group" style="margin-bottom:10px !important;" id="div_jabatan_siasn">
                <label for="jabatan_jenis">Nama Jabatan SIASN </label>
                <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="list_jabatan_siasn" id="list_jabatan_siasn" <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "Required"; else echo ""; ?>>
                                <option value="" disabled selected>Pilih Item</option>
                </select>
              </div> -->


            <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?> 
              </div>
            <?php } ?>

            <div class="form-group" style="margin-bottom:10px !important;">
              <!-- <label for="jabatan_jenis">Nama Jabatan </label>
              <input class="form-control customInput" type="text" id="edit_jabatan_nama" name="edit_jabatan_nama"  value="<?=$jabatan[0]['nama_jabatan']?>"/> -->
              </div>
              </div>



              <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?> 
                <div class="form-group">
              <label>Nama Jabatan</label>
              <input class="form-control customInput" type="text" id="teks_jabatan" name="teks_jabatan"  value="<?=$jabatan[0]['nama_jabatan']?>" readonly>
            </div>
                <?php } ?>
          

            <div class="form-group">
              <label>Pejabat Yang Menetapkan</label>
              <input class="form-control customInput" type="text" id="edit_jabatan_pejabat" name="edit_jabatan_pejabat"  value="<?=$jabatan[0]['pejabat']?>"/>
            </div>

            <div class="form-group">
              <label>TMT Jabatan</label>
              <input autocomplete="off"  class="form-control datepicker"   id="edit_jabatan_tmt" name="edit_jabatan_tmt"  value="<?=$jabatan[0]['tmtjabatan']?>"/>
            </div>


            <div class="form-group">
              <label>Nomor SK</label>
              <input class="form-control customInput" type="text" id="edit_jabatan_no_sk" name="edit_jabatan_no_sk"  value="<?=$jabatan[0]['nosk']?>"/>
            </div>

            <div class="form-group">
              <label>Tanggal SK</label>
              <input autocomplete="off"  class="form-control datepicker"   id="edit_jabatan_tanggal_sk" name="edit_jabatan_tanggal_sk" readonly value="<?=$jabatan[0]['tglsk']?>"/>
            </div>

            <div class="form-group">
              <label>Angka Kredit</label>
              <input class="form-control customInput" type="text" id="edit_jabatan_angka_kredit" name="edit_jabatan_angka_kredit"  value="<?=$jabatan[0]['angkakredit']?>"/>
            </div>

            <div class="form-group">
              <label>Keterangan</label>
              <input class="form-control customInput" type="text" id="edit_jataban_keterangan" name="edit_jataban_keterangan"  value="<?=$jabatan[0]['ket']?>"/>
            </div>

            <div class="form-group">
              <label>File SK</label>
              <input  class="form-control my-image-field" type="file" id="pdf_file_jab" name="file"/>
              <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
            </div>

            <div class="form-group col-lg-12">
              <br>
              <button class="btn btn-block btn-primary float-right"  id="btn_edit_jabatan"><i class="fa fa-save"></i> SIMPAN</button>
            </div>
          </form>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane hide" id="nav-jabatan-siasn" role="tabpanel" aria-labelledby="nav-jabatan-siasn-tab">
          <?php if($jabatan_siasn){ ?>
            <div class="row">
              <div class="col-lg-6">
                <iframe style="width: 100%; height: 70vh;" id="iframe_file_siasn"></iframe>
              </div>
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-12">
                    <label class="lbl-name">Nomor SK</label>
                    <br>
                    <span class="lbl-val lbl_siasn_nomor_sk"><?=$jabatan_siasn['nomorSk']?></span>
                  </div>
                  <div class="col-lg-12">
                      <label class="lbl-name">Nama Jabatan</label>
                      <br>
                      <span class="lbl-val lbl_siasn_nama_jabatan"><?=$jabatan_siasn['namaJabatan']?></span>
                  </div>
                  <div class="col-lg-12">
                      <label class="lbl-name">UNOR</label>
                      <br>
                      <span class="lbl-val lbl_siasn_nama_jabatan"><?=$jabatan_siasn['unorNama']?></span>
                  </div>
                  <div class="col-lg-12">
                      <label class="lbl-name">Eselon</label>
                      <br>
                      <span class="lbl-val lbl_siasn_eselon"><?=$jabatan_siasn['eselon'] ? $jabatan_siasn['eselon'] : 'Non Eselon'?></span>
                  </div>
                  <div class="col-lg-12">
                      <label class="lbl-name">TMT Jabatan</label>
                      <br>
                      <span class="lbl-val lbl_siasn_tmt_jabatan"><?=formatDateNamaBulan($jabatan_siasn['tmtJabatan'])?></span>
                  </div>
                  <div class="col-lg-12">
                      <label class="lbl-name">Tanggal SK</label>
                      <br>
                      <span class="lbl-val lbl_siasn_tanggal_sk"><?=formatDateNamaBulan($jabatan_siasn['tanggalSk'])?></span>
                  </div>
                  <div class="col-lg-12">
                      <iframe class="file_siasn" style="width: 100%; height: 50vh;">
                      </iframe>
                  </div>
                </div>
              </div>
            </div>
          <?php } else { ?>
            <h5><i class="fa fa-exclamation"></i> Data belum tersinkronasi</h5>
          <?php } ?>
        </div>
    </div>
</div>

<script>

    
$(function(){
  loadFileSiasn()
  // loadJabatanSiasn('<?=$jabatan[0]['id_jabatan']?>')

  $(".select2").select2({   
      width: '100%',
      dropdownAutoWidth: true,
      allowClear: true,
  });

  $('#datatable').dataTable()
      loadListPangkat()
 })

 $('.datepicker').datepicker({
     format: 'yyyy-mm-dd',
 // viewMode: "years", 
 // minViewMode: "years",
 // orientation: 'bottom',
 autoclose: true
});

$('#jabatan_nama').on('change', function(){
  // loadJabatanSiasn($(this).val())
})

function loadJabatanSiasn(id){
  $.ajax({
    url: '<?=base_url("kepegawaian/C_Kepegawaian/loadListJabatanSiasn/")?>'+id,
    method: 'post',
    data: null,
    success: function(data){
      $('#list_jabatan_siasn').empty()
      let rs = JSON.parse(data)
      console.log(rs)
      rs.forEach(function(item) {
        $('#list_jabatan_siasn').append('<option value="'+item.id+'">'+item.nama+'</option>')
      })
    }, error: function(e){
      errortoast('Terjadi Kesalahan')
    }
  })
}

function loadFileSiasn(){
  <?php if($jabatan_siasn && isset($jabatan_siasn['path'][872]['dok_uri'])){ ?>
    $.ajax({
      url: '<?=base_url("siasn/C_Siasn/downloadFileSiasn")?>',
      method: 'post',
      data: {
        url: '<?=$jabatan_siasn['path'][872]['dok_uri']?>'
      },
      success: function(data){
        $('#iframe_file_siasn').attr('src', "data:application/pdf;base64,"+data)
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
      }
    })
  <?php } ?>
}

function syncSiasn(){
  $('#btn_sync').hide()
  $('#btn_sync_loading').show()
  $.ajax({
    url: '<?=base_url("kepegawaian/C_Kepegawaian/syncSiasnJabatan/".$jabatan[0]['id'])?>',
    method: 'post',
    data: null,
    success: function(data){
      let rs = JSON.parse(data)
      if(rs.code == 0){
        successtoast('Sinkronisasi dengan SIASN berhasil')
      } else {
        errortoast('Terjadi Kesalahan. '+rs.data)
      }
      $('#btn_sync').show()
      $('#btn_sync_loading').hide()
    }, error: function(e){
      errortoast('Terjadi Kesalahan')
      $('#btn_sync').show()
      $('#btn_sync_loading').hide()
    }
  })
}
    
$('#form_edit_jabatann').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_jabatann');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_file_jab').files.length;
    
     document.getElementById('btn_edit_jabatan').disabled = true;
     $('#btn_edit_jabatan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditJabatan")?>",
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
             // document.getElementById("form_edit_jabatann").reset();
             document.getElementById('btn_edit_jabatan').disabled = false;
            $('#btn_edit_jabatan').html('Simpan')
             setTimeout(function() {$("#modal_edit_jabatan").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListJabatan, 2000);
             loadRiwayatUsulJabatan()
             location.reload()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


        $("#pdf_file_jab").change(function (e) {

        var doc = pdf_file_jab.value.split('.')
        var extension = doc[doc.length - 1]

        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>

        if (extension != "pdf"){
        errortoast("Harus File PDF")
        $(this).val('');
        }

        if (fileSize > MaxSize ){
        errortoast("Maksimal Ukuran File 1 MB")
        $(this).val('');
        }

        });


        $("#edit_jabatan_jenis").change(function() {
                var id = $("#edit_jabatan_jenis").val();
                var skpd = $("#edit_jabatan_unit_kerja").val();
                var jnsfung = $("#edit_jenis_fungsional").val();

                if(id == "00"){
                  $("#edit_div_jf").hide('fast');
                } else {
                  $("#edit_div_jf").show('fast');
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
                                  html += '<option value="'+data[i].id+','+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                                }
                                $('.edit_nama_jab').html(html);
                                    }
                            });
            });

            $("#edit_jenis_fungsional").change(function() {
              var id = $("#edit_jabatan_jenis").val();
                var skpd = $("#edit_jabatan_unit_kerja").val();
                var jnsfung = $("#edit_jenis_fungsional").val();
     
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
                        html += '<option value="'+data[i].id+','+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                      }
                      $('.edit_nama_jab').html(html);
                          }
                  });
            });

            $("#edit_jabatan_unit_kerja").change(function() {
              var id = $("#edit_jabatan_jenis").val();
                var skpd = $("#edit_jabatan_unit_kerja").val();
                var jnsfung = $("#edit_jenis_fungsional").val();

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
                                  html += '<option value="'+data[i].id+','+data[i].nama_jabatan+'">'+data[i].nama_jabatan+'</option>';
                                }
                                $('.edit_nama_jab').html(html);
                                    }
                            });
            });

</script>