

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
<td style="vertical-align: top;">NIP</td>
<td style="vertical-align: top;">:</td>
<td style="vertical-align: top;" height="40px;" ><?=$this->general_library->getUserName();?></td>
</tr>


</table>
   <form method="post" id="upload_form_organisasi" enctype="multipart/form-data" >
   
   <input type="hidden" id="id_pegorganisasi" name="id_pegorganisasi" value="">
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?=$this->general_library->getIdPegSimpeg();?>">

    <div class="form-group" style="margin-bottom:10px !important;">
    <label for="exampleFormControlInput1">Jenis Organisasi </label>
    <select class="form-control select2" data-dropdown-css-class="select2-navy" name="jenis_organisasi" id="jenis_organisasi" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jenis_organisasi){ foreach($jenis_organisasi as $r){ ?>
                        <option value="<?=$r['id_organisasi']?>"><?=$r['nm_organisasi']?></option>
                    <?php } } ?>
    </select>
    </div>

  <div class="form-group">
    <label>Nama Organisasi</label>
    <input class="form-control customInput" type="text" id="nama_organisasi" name="nama_organisasi"  required/>
  </div>

  <div class="form-group">
    <label>Kedudukan / Jabatan</label>
    <input class="form-control customInput" type="text" id="jabatan_organisasi" name="jabatan_organisasi"  required/>
  </div>

  
  <div class="form-group">
    <label>Tanggal Mulai</label>
    <input  class="form-control datepicker"   id="tglmulai" name="tglmulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berakhir</label>
    <input  class="form-control datepicker"   id="tglselesai" name="tglselesai" required/>
  </div>

  <div class="form-group">
    <label>Nama Pimpinan</label>
    <input class="form-control customInput" type="text" id="pemimpin" name="pemimpin"  required/>
  </div>

  <div class="form-group">
    <label>Tempat</label>
    <input class="form-control customInput" type="text" id="tempat" name="tempat"  required/>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id=""><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
<hr>
<div id="list_pangkat">

</div>





<div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      


<script type="text/javascript">


$(function(){
        $('.select2').select2()
        // loadListPangkat()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_organisasi').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_organisasi');
        var form_data = new FormData(formvalue[0]);
        // var ins = document.getElementById('organisasi_pdf_file').files.length;
        
        // if(ins == 0){
        // errortoast("Silahkan upload file terlebih dahulu");
        // return false;
        // }
       
      
      
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
                document.getElementById("upload_form_organisasi").reset();
                loadFormOrganisasi()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

//     function loadListPangkat(){
//     $('#list_pangkat').html('')
//     $('#list_pangkat').append(divLoaderNavy)
//     $('#list_pangkat').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPangkat/")?>', function(){
//       $('#loader').hide()
//     })
//   }

  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  

        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });
</script>