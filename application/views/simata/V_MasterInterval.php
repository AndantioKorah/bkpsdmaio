<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->isHakAkses('akses_profil_pegawai')) { ?>
    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                <button style="color:#fff;"  id="btn_tambah_indikator" class="btn btn-sm  btn-navy" type="submit"><i class="fa fa-plus"></i> TAMBAH INTERVAL</button>
                <!-- <h3 class="card-title">TAMBAH INDIKATOR</h3> -->
                </div>
        </div>
        <div class="card-body div_form_tambah_interval" id="div_form_tambah_interval" style="display:none;">
        <form method="post" id="form_tambah_interval" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Unsur Penilaian </label>
                            <select   class="form-control select2 " data-dropdown-css-class="select2-navy" name="id_m_unsur_penilaian" id="id_m_unsur_penilaian" required>     
                            <option value="" disabled selected>Pilih Unsur Penilaian</option>
                                            <?php if($unsur){ foreach($unsur as $r){ ?>
                                                <option value="<?=$r['id']?>"><?=$r['nm_unsur']?></option>
                                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Kriteria</label>
                            <input required class="form-control" autocomplete="off" type="text" name="kriteria" id="kriteria" required/>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">dari</label>
                            <input min=0 step=0.01  required class="form-control" autocomplete="off" type="number" name="dari" id="dari" required/>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">sampai</label>
                            <input min=0 step=0.01 required class="form-control" autocomplete="off" type="number" name="sampai" id="sampai" required/>
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
                <div class="col-3">
                    <h3 class="card-title">LIST INTERVAL</h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-20px;">
        <div id="list_interval">

        </div>
        </div>
    </div>

<?php } ?>

  
<script type="text/javascript">

$(function(){
   

$(".select2").select2({   
     width: '100%',
     dropdownAutoWidth: true,
     allowClear: true,
 });

 loadListInterval()
 })



  $('#form_tambah_interval').on('submit', function(e){  
       
        e.preventDefault();
        var formvalue = $('#form_tambah_interval');
        var form_data = new FormData(formvalue[0]);

        $.ajax({  
        url:"<?=base_url("simata/C_Simata/submitTambahInterval")?>",
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
                document.getElementById("form_tambah_interval").reset();
                // loadListPangkat()
                location.reload()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

     
$("#btn_tambah_indikator").click(function() { 
    // assumes element with id='button'
    $("#div_form_tambah_interval").toggle('fast');
});

$(window).scroll(function() {
  if ($(this).scrollTop() > 0) {
    $('.div_form_tambah_interval').fadeOut();
  } else {
    // $('.div_form_tambah_interval').fadeIn();
  }
});

function loadListInterval(){
   
   $('#list_interval').html('')
   $('#list_interval').append(divLoaderNavy)
   $('#list_interval').load('<?=base_url("simata/C_Simata/loadListInterval/")?>', function(){
     $('#loader').hide()
   })
 }
</script>