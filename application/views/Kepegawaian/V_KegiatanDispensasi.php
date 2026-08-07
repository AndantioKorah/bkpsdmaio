    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                <!-- <button style="color:#fff;"  id="btn_tambah_indikator" class="btn btn-sm  btn-navy" type="submit"><i class="fa fa-plus"></i> TAMBAH INDIKATOR</button> -->
                <!-- <h3 class="card-title">TAMBAH INDIKATOR</h3> -->
                </div>
        </div>
        <div class="card-body div_form_tambah_kegiatan_dispensasi" id="div_form_tambah_kegiatan_dispensasi" style="display:nonex;">
        <form method="post" id="form_tambah_kegiatan_dispensasi" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nama Organisasi </label>
                            <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" required>
                        </div>
                    </div>

                       <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nomor Surat Permohonan </label>
                            <input type="text" class="form-control" id="nomor_surat_permohonan" name="nomor_surat_permohonan" required>
                        </div>
                    </div>
                       <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Tanggal Surat Permohonan </label>
                            <input type="text" class="form-control datepickerr" id="tanggal_surat_permohonan" name="tanggal_surat_permohonan" required>
                        </div>
                    </div>
                      <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nama Kegiatan </label>
                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                        </div>
                    </div>

                     <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Tanggal Mulai Kegiatan </label>
                            <input type="text" class="form-control datepickerr" id="tanggal_mulai_kegiatan" name="tanggal_mulai_kegiatan" required>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating" >Tanggal Selesai Kegiatan </label>
                            <input type="text" class="form-control datepickerr" id="tanggal_selesai_kegiatan" name="tanggal_selesai_kegiatan" required>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Tempat Kegiatan </label>
                            <input type="text" class="form-control" id="tempat_kegiatan" name="tempat_kegiatan" required>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Provinsi Kegiatan </label>
                        <select  class="form-control select2"  data-dropdown-css-class="select2-navy" name="provinsi_kegiatan" id="provinsi_kegiatan" required>     
                        <option value="" disabled selected>Pilih Provinsi</option>
                                        <?php if($provinsi){ foreach($provinsi as $r){ ?>
                                            <option <?php if($r['id'] == "71") echo "selected"; else echo ""; ?> value="<?=$r['id']?>"><?=$r['nama_provinsi']?></option>
                                        <?php } } ?>
                        </select>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Kota/Kabutapaten Kegiatan </label>
                             <select  class="form-control select2 kota_kab"  data-dropdown-css-class="select2-navy"  name="kota_kab_kegiatan" id="kota_kab_kegiatan" >     
                             <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                    <?php if($kabkota){ foreach($kabkota as $r){ ?>
                        <option  value="<?=$r['id']?>"><?=$r['nama_kabupaten_kota']?></option>
                    <?php } } ?>
                            </select>
                        </div>
                    </div>


                     <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Kecamatan Kegiatan </label>
                             <select  class="form-control select2 kecamatan"   data-dropdown-css-class="select2-navy"  name="kecamatan_kegiatan" id="kecamatan_kegiatan" >     
                        <option value="" disabled selected>Pilih Kecamatan</option>
                        </select>
                        </div>
                    </div>

                   
                        <div class="col-lg-8 col-md-8"></div>
                    <div class="col-lg-12 col-md-4 text-right mt-2">
                        <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-header">
                <div class="col-6">
                    <h3 class="card-title">DAFTAR KEBUTUHAN JABATAN FUNGSIONAL</h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-20px;">
        <div id="list_indikator">

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

  $('.datepickerr').datepicker({
     format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });


 loadListKegiatanDispensasi()
 
 })





  $('#form_tambah_kegiatan_dispensasi').on('submit', function(e){  
       
        e.preventDefault();
        var formvalue = $('#form_tambah_kegiatan_dispensasi');
        var form_data = new FormData(formvalue[0]);

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitTambahKegiatanDispensasi")?>",
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
                // document.getElementById("form_tambah_kegiatan_dispensasi").reset();
                loadListKegiatanDispensasi()
                // location.reload()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

     
 function loadListKegiatanDispensasi(){
   
    $('#list_indikator').html('')
    $('#list_indikator').append(divLoaderNavy)
    $('#list_indikator').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListKegiatanDispensasi/")?>', function(){
      $('#loader').hide()
    })
  }

  $("#btn_tambah_indikator").click(function() { 
    // assumes element with id='button'
    $("#div_form_tambah_kegiatan_dispensasi").toggle('fast');
});

// $(window).scroll(function() {
//   if ($(this).scrollTop() > 0) {
//     $('.div_form_tambah_kegiatan_dispensasi').fadeOut();
//   } else {
//     // $('.div_form_tambah_kegiatan_dispensasi').fadeIn();
//   }
// });


$("#provinsi_kegiatan").change(function() {
      var id = $("#provinsi_kegiatan").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatakotakab",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_kabupaten_kota+'</option>';
                      }
                      $('.kota_kab').html(html);
                          }
                  });
  });


     $("#kota_kab_kegiatan").change(function() {
      var id = $("#kota_kab_kegiatan").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatakec",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_kecamatan+'</option>';
                      }
                      $('.kecamatan').html(html);
                          }
                  });
  });
</script>