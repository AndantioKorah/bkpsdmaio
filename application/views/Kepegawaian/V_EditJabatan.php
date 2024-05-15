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
    <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan"  name="edit_jabatan_unit_kerja" id="edit_jabatan_unit_kerja" required>
                    <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option <?php if($jabatan[0]['id_unitkerja'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?> value="<?=$r['id_unitkerja']?>/<?=$r['nm_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>


    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_jenis">Jenis Jabatan </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="edit_jabatan_jenis" id="edit_jabatan_jenis" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option <?php if($jabatan[0]['jenisjabatan'] == $r['id_jenisjab']) echo "selected"; else echo ""; ?> value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
    </select>
    </div>


    <div class="form-group" style="margin-bottom:10px !important; display:none" id="edit_div_jf">
    <label for="jabatan_jenis">Jenis Fungsional </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="edit_jenis_fungsional" id="edit_jenis_fungsional" required>
                    <option value="1" selected>JFT</option>
                    <option value="2" >JFU</option>
                  
    </select>
    </div>


    

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="jabatan_jenis">Status Jabatan </label>

                    <select class="form-control select2" data-dropdown-css-class="" name="edit_jabatan_status" id="edit_jabatan_status" >
                    <option <?php if($jabatan[0]['statusjabatan'] == 1) echo "selected"; else echo ""; ?> value=1 >Definitif</option>
                    <option <?php if($jabatan[0]['statusjabatan'] == 2) echo "selected"; else echo ""; ?> value=2 >Plt</option>
                    <option <?php if($jabatan[0]['statusjabatan'] == 3) echo "selected"; else echo ""; ?> value=3 >Plh</option>
    </select>
    </div>
   



  <div class="form-group" style="margin-bottom:10px !important;">
    <label >Eselon </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_jabatan"  data-dropdown-css-class="select2-navy" name="edit_jabatan_eselon" id="edit_jabatan_eselon" >
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($eselon){ foreach($eselon as $r){ ?>
                        <option <?php if($jabatan[0]['eselon'] == $r['id_eselon']) echo "selected"; else echo ""; ?>  value="<?=$r['id_eselon']?>"><?=$r['nm_eselon']?></option>
                    <?php } } ?>
    </select>
    </div>

 




  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?> 
    </div>
   <?php } ?>

   <div class="form-group" style="margin-bottom:10px !important;">
    <!-- <label for="jabatan_jenis">Nama Jabatan </label>
    <input class="form-control customInput" type="text" id="edit_jabatan_nama" name="edit_jabatan_nama"  value="<?=$jabatan[0]['nama_jabatan']?>"/> -->
    </div>



    </div>

    <div class="form-group" style="margin-bottom:10px !important;" id="jabatan_baru">
    <label for="jabatan_jenis">Nama Jabatan </label>
    <select class="form-control select2 edit_nama_jab" data-dropdown-parent="#modal_edit_jabatan" data-dropdown-css-class="select2-navy" name="jabatan_nama" id="jabatan_nama" >
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option <?php if($r['id_jabatanpeg'] == $jabatan[0]['id_jabatan']) echo "selected"; else echo "";?> value="<?=$r['id_jabatanpeg']?>,<?=$r['nama_jabatan']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
    </select>
    </div>

 

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

<script>

    
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
     format: 'yyyy-mm-dd',
 // viewMode: "years", 
 // minViewMode: "years",
 // orientation: 'bottom',
 autoclose: true
});
    
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

</script>