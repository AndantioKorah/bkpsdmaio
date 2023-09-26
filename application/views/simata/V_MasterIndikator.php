<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->getRole() == 'admin_aplikasi') { ?>
    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                    <h3 class="card-title">TAMBAH INDIKATOR</h3>
                </div>
        </div>
        <div class="card-body">
        <form method="post" id="form_tambah_indikator" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Unsur Penilaian </label>
                            <select   class="form-control select2 " data-dropdown-css-class="select2-navy" name="unsur_penilaian" id="unsur_penilaian" required>     
                            <option value="" disabled selected>Pilih Unsur Penilaian</option>
                                            <?php if($unsur){ foreach($unsur as $r){ ?>
                                                <option value="<?=$r['id']?>"><?=$r['nm_unsur']?></option>
                                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Sub Unsur Penilaian</label>
                            <select class="form-control select2 sub_unsur_penilaian" data-dropdown-css-class="select2-navy" name="sub_unsur_penilaian" id="sub_unsur_penilaian" required>     
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Indikator</label>
                            <input required class="form-control" autocomplete="off" type="text" name="indikator" id="indikator" required/>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Bobot</label>
                            <input required class="form-control" autocomplete="off" type="number" name="bobot" id="bobot" required/>
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
                    <h3 class="card-title">LIST INDIKATOR</h3>
                </div>
        </div>
        <div class="card-body">
        <div id="list_indikator">

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

 loadListindikator()
 
 })


     $("#unsur_penilaian").change(function() {
      var id = $("#unsur_penilaian").val();
      $.ajax({
              url : "<?php echo base_url();?>simata/C_Simata/getDataSubUnsurPenilaian",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nm_sub_unsur_penilaian+'</option>';
                      }
                      $('.sub_unsur_penilaian').html(html);
                          }
                  });
  });


  $('#form_tambah_indikator').on('submit', function(e){  
       
        e.preventDefault();
        var formvalue = $('#form_tambah_indikator');
        var form_data = new FormData(formvalue[0]);

        $.ajax({  
        url:"<?=base_url("simata/C_Simata/submitTambahIndikator")?>",
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
                document.getElementById("form_tambah_indikator").reset();
                // loadListPangkat()
                location.reload()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

     
 function loadListindikator(){
   
    $('#list_indikator').html('')
    $('#list_indikator').append(divLoaderNavy)
    $('#list_indikator').load('<?=base_url("simata/C_Simata/loadListIndikator/")?>', function(){
      $('#loader').hide()
    })
  }
</script>