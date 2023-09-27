
   <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                <button style="color:#fff;"  id="btn_tambah_kriteria" class="btn btn-sm btn-navy" type="submit">TAMBAH KRITERIA</button>
                </div>
        </div>
        <div class="card-body" id="div_form_tambah_kriteria" style="display:none;">
        <form method="post" id="form_tambah_kriteria" enctype="multipart/form-data" >
            <input type="hidden" id="id_m_indikator_penilaian" name="id_m_indikator_penilaian" value="<?=$id_indikator;?>">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Kriteria</label>
                            <textarea class="form-control" name="kriteria" id="kriteria" rows="3" required></textarea>
                            <!-- <input required class="form-control" autocomplete="off" type="text"  required/> -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Skor</label>
                            <input required class="form-control" autocomplete="off" type="number" name="skor" id="skor" required/>
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
                    <h3 class="card-title">LIST KRITERIA</h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-30px;">
        <div id="list_kriteria_item">

        </div>
        </div>
    </div>



  <script>

$(function(){
   

   $(".select2").select2({   
        width: '100%',
        dropdownAutoWidth: true,
        allowClear: true,
    });
   
    loadListKriteria()
    
    })

function loadListKriteria(){
var id = "<?=$id_indikator;?>";
   $('#list_kriteria_item').html('')
   $('#list_kriteria_item').append(divLoaderNavy)
   $('#list_kriteria_item').load('<?=base_url("simata/C_Simata/loadListKriteria/")?>'+id, function(){
     $('#loader').hide()
   })
 }

 $("#btn_tambah_kriteria").click(function() { 
    // assumes element with id='button'
    $("#div_form_tambah_kriteria").toggle('fast');
});

$('#form_tambah_kriteria').on('submit', function(e){  
       
       e.preventDefault();
       var formvalue = $('#form_tambah_kriteria');
       var form_data = new FormData(formvalue[0]);

       $.ajax({  
       url:"<?=base_url("simata/C_Simata/submitTambahKriteria")?>",
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
               document.getElementById("form_tambah_kriteria").reset();
               loadListKriteria()
             } else {
               errortoast(result.msg)
               return false;
             } 
           
       }  
       });  
         
       });
  </script>
  