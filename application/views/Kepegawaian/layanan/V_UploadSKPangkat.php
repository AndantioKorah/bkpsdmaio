<form method="post" id="upload_form" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="4">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $result[0]['id_peg'];?>">
    <input type="hidden" id="id_usul" name="id_usul" value="<?= $id_usul;?>">

    <div class="form-group " style="margin-bottom:10px !important;">
    <label >Jenis Pengangkatan</label>
    <select  class="form-control select2 " data-dropdown-css-class="select2-navy" name="jenis_pengangkatan" id="jenis_pengangkatan" autocomplete="off" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_pengangkatan){ foreach($jenis_pengangkatan as $r){ ?>
                        <option value="<?=$r['id_jenispengangkatan']?>"><?=$r['nm_jenispengangkatan']?></option>
                    <?php } } ?>
</select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Pangkat - Gol/Ruang </label>
    <select style="width: 100% important!" class="form-control select2" data-dropdown-css-class="select2-navy" name="pangkat" id="pangkat" autocomplete="off" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_pangkat){ foreach($list_pangkat as $r){ ?>
                        <option value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
</select>
    </div>

    
   

   <div class="form-group">
    <label>TMT Pangkat</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tmt_pangkat" name="tmt_pangkat" readonly  required/>
  </div>
  
  <div class="form-group">
    <label>Masa Kerja</label>
    <input class="form-control" type="text" id="masa_kerja" name="masa_kerja" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control" type="text" id="pejabat" name="pejabat" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control" type="text" id="no_sk" name="no_sk" autocomplete="off"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tanggal_sk" name="tanggal_sk" readonly required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : 2 MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-primary float-right"  id="btn_upload_pangkat"><i class="fa fa-save"></i> SIMPAN</button>
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


    $('#upload_form').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file').files.length;
        var tmtpangkat = $('#tmt_pangkat').val()
        var tglskpangkat = $('#tanggal_sk').val()

        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

        if(tmtpangkat == ""){
          errortoast("tmt pangkat masih kosong")
          document.getElementById("tmt_pangkat").focus();
          return false;
        }

        if(tglskpangkat == ""){
          errortoast("tanggal sk masih kosong")
          document.getElementById("tanggal_sk").focus();
          return false;
        }
       
        // document.getElementById('btn_upload_pangkat').disabled = true;
        // $('#btn_upload_pangkat').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

       
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
                document.getElementById("upload_form").reset();
                document.getElementById('btn_upload_pangkat').disabled = false;
                $('#btn_upload_pangkat').hide()
                setTimeout(window.location.reload.bind(window.location), 1000);
                
                  
            //    $('#btn_upload_pangkat').html('Simpan')
               
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

$("#pdf_file").change(function (e) {

// var extension = pdf_file.value.split('.')[1];
var doc = pdf_file.value.split('.')
var extension = doc[doc.length - 1]

var fileSize = this.files[0].size/1024;
var MaxSize = <?=$format_dok['file_size']?>

if (extension != "pdf"){
  errortoast("Harus File PDF")
  $(this).val('');
}

if (fileSize > MaxSize ){
  errortoast("Maksimal Ukuran File 2 MB")
  $(this).val('');
}

});
    </script>