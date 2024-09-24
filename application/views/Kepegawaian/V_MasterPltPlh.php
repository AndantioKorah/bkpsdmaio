<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER ANNOUNCEMENT </h3>
    </div>
    <div class="card-body" style="display: block;">
    <form method="post" id="upload_form_pltplh" enctype="multipart/form-data" >

    <div class="form-group mb-2">
    <label for="exampleInputEmail1">Pegawai</label>
    <select class="form-control select2-navy select2" style="width: 100%"
                    id="pltplh_id_m_user" data-dropdown-css-class="select2-navy" name="pltplh_id_m_user">
                        <?php if($list_pegawai){
                            foreach($list_pegawai as $lp){
                            ?>
                            <option value="<?=$lp['id_m_user']?>">
                                <?=getNamaPegawaiFull($lp)?>
                            </option>
                        <?php } } ?>
                    </select>
  </div>

  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Jenis</label>
    <select class="form-control select2-navy select2" name="pltplh_jenis" id="pltplh_jenis"  required>
         <option value="" selected disabled>- Pilih Jenis -</option>
         <option value="Plt" >Plt </option>
         <option value="Plh" >Plh </option>
         </select>
  </div>

  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Unit Kerja</label>
    <select class="form-control select2"  name="pltplh_unitkerja" id="pltplh_unitkerja" required>
                    <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option  value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>
  </div>
  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Jabatan</label>
     <select class="form-control select2" data-dropdown-css-class="select2-navy" name="pltplh_jabatan" id="pltplh_jabatan" >
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
    </select>
  </div>
  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Tanggal Mulai</label>
    <input type="text" class="form-control datepicker2" id="pltplh_tgl_mulai" name="pltplh_tgl_mulai">
  </div>
  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Tanggal Selesai</label>
    <input type="text" class="form-control datepicker2" id="pltplh_tgl_akhir" name="pltplh_tgl_akhir">
  </div>
  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Presentasi TPP</label>
    <input type="number" class="form-control" id="pltplh_presentasi_tpp" name="pltplh_presentasi_tpp">
  </div>
  <div class="form-group mb-2">
    <label for="exampleInputEmail1">Flag BPJS</label>
    <input type="number" class="form-control" id="pltplh_bpjs" name="pltplh_bpjs">
  </div>
 
  
  <button class="btn btn-block btn-primary customButton"  id="btn_upload_pltplh"><i class="fa fa-save"></i> SIMPAN</button>
</form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_pltplh">

            </div>
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
    loadListPltPlh()
    })

    $('.datepicker2').datepicker({
    format: 'yyyy-mm-dd',
    // startDate: '-0d',
    // todayBtn: true,
    todayHighlight: true,
    autoclose: true,
});

    function loadListPltPlh(){
        $('#list_pltplh').html('')
        $('#list_pltplh').append(divLoaderNavy)
        $('#list_pltplh').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPltPlh")?>', function(){
            $('#loader').hide()
        })
    }

     $('#upload_form_pltplh').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_pltplh');
        var form_data = new FormData(formvalue[0]);
       
       
        document.getElementById('btn_upload_pltplh').disabled = true;
        $('#btn_upload_pltplh').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitPltPlh")?>",
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
                document.getElementById("upload_form_pltplh").reset();
                document.getElementById('btn_upload_pltplh').disabled = false;
               $('#btn_upload_pltplh').html('Simpan')
               loadListPltPlh()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });

        $("#png_file").change(function (e) {
        
        var jenis_arsip = $('#jenis_arsip').val()
        // var extension = png_file.value.split('.')[1];
        var doc = png_file.value.split('.')
        var extension = doc[doc.length - 1]
      
        var fileSize = this.files[0].size/1024;

        
          if (extension == "jpeg" ||extension == "jpg" || extension == "png"){
          
          } else {
              errortoast("Harus File Gambar")
              $(this).val('');
          }

          

        });

        
</script>