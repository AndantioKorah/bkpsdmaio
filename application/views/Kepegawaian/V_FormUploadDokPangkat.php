

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>
<table width="100%" border="0" class="" align="left">
<tr>
<td height="8px;" width="20%">Nama</td>
<td width="">:</td>
<td width=""> <?= $profil_pegawai['gelar1'];?> <?= $profil_pegawai['nama'];?> <?= $profil_pegawai['gelar2'];?> </td>
</tr>
 <tr>
<td>NIP</td>
<td>:</td>
<td>199401042020121011</td>
</tr>

<tr>
<td>Pangkat Terakhir </td>
<td>:</td>
<td><?= $profil_pegawai['nm_pangkat'];?></td>
</tr>

<tr>
<td style="vertical-align: top;">TMT Pangkat </td>
<td style="vertical-align: top;">:</td>
<td style="vertical-align: top;" height="40px;" ><?= formatDateNamaBulan($profil_pegawai['tmtpangkat']);?></td>
</tr> 
</table>
   <form method="post" id="upload_form" enctype="multipart/form-data" >
    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Jenis Pengangkatan</label>
    <select  class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_pengangkatan" id="jenis_pengangkatan" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_pengangkatan){ foreach($jenis_pengangkatan as $r){ ?>
                        <option value="<?=$r['id_jenispengangkatan']?>"><?=$r['nm_jenispengangkatan']?></option>
                    <?php } } ?>
</select>
    </div>

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Pangkat - Gol/Ruang </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="pangkat" id="pangkat" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_pangkat){ foreach($list_pangkat as $r){ ?>
                        <option value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
</select>
    </div>
   

   <div class="form-group">
    <label>TMT Pangkat</label>
    <input  class="form-control datepicker"   id="tmt_pangkat" name="tmt_pangkat" required/>
  </div>
  
  <div class="form-group">
    <label>Masa Kerja</label>
    <input class="form-control customInput" type="text" id="masa_kerja" name="masa_kerja"  required/>
  </div>

  <div class="form-group">
    <label>Pejabat Yang Menetapkan</label>
    <input class="form-control customInput" type="text" id="pejabat" name="pejabat"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control customInput" type="text" id="no_sk" name="no_sk"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal SK</label>
    <input  class="form-control datepicker"   id="tanggal_sk" name="tanggal_sk" required/>
  </div>

  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="image_file" name="file"   />
    <span style="color:red;">* Format Penamaan File : SK_KP_NIP_KODE</span>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 


<script type="text/javascript">


$(function(){
        $('.select2').select2()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form');
        var form_data = new FormData(formvalue[0]);
      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/doUpload2")?>",
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
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 


</script>