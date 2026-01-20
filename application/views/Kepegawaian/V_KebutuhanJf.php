    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                <!-- <button style="color:#fff;"  id="btn_tambah_indikator" class="btn btn-sm  btn-navy" type="submit"><i class="fa fa-plus"></i> TAMBAH INDIKATOR</button> -->
                <!-- <h3 class="card-title">TAMBAH INDIKATOR</h3> -->
                </div>
        </div>
        <div class="card-body div_form_tambah_kebutuhan" id="div_form_tambah_kebutuhan" style="display:nonex;">
        <form method="post" id="form_tambah_kebutuhan" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Unit Kerja </label>
                            <select   class="form-control select2 " data-dropdown-css-class="select2-navy" name="id_unitkerja" id="id_unitkerja" required>     
                            <option value="" disabled selected>Pilih Unit Kerja</option>
                                            <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                                                <option value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Jabatan Fungsional</label>
                             <select   class="form-control select2 " data-dropdown-css-class="select2-navy" name="id_jabatan" id="id_jabatan" required>     
                            <option value="" disabled selected>Pilih Jabatan</option>
                                            <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                                                <option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">kebutuhan</label>
                            <input required class="form-control" autocomplete="off" type="number" name="kebutuhan" id="kebutuhan"value="0" required/>
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

 loadListkebutuhanJf()
 
 })





  $('#form_tambah_kebutuhan').on('submit', function(e){  
       
        e.preventDefault();
        var formvalue = $('#form_tambah_kebutuhan');
        var form_data = new FormData(formvalue[0]);

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitTambahkebutuhanJf")?>",
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
                // document.getElementById("form_tambah_kebutuhan").reset();
                loadListkebutuhanJf()
                // location.reload()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

     
 function loadListkebutuhanJf(){
   
    $('#list_indikator').html('')
    $('#list_indikator').append(divLoaderNavy)
    $('#list_indikator').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListkebutuhanJf/")?>', function(){
      $('#loader').hide()
    })
  }

  $("#btn_tambah_indikator").click(function() { 
    // assumes element with id='button'
    $("#div_form_tambah_kebutuhan").toggle('fast');
});

// $(window).scroll(function() {
//   if ($(this).scrollTop() > 0) {
//     $('.div_form_tambah_kebutuhan').fadeOut();
//   } else {
//     // $('.div_form_tambah_kebutuhan').fadeIn();
//   }
// });
</script>