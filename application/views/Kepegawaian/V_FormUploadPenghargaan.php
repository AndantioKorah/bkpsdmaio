

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalPenghargaan">
  Tambah Data Penghargaan
</button>

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


<!-- Modal -->
<div class="modal fade" id="modalPenghargaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Penghargaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_penghargaan" enctype="multipart/form-data" >
   
   <input type="hidden" id="id_pegpenghargaan" name="id_pegpenghargaan" value="">
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?=$this->general_library->getIdPegSimpeg();?>">


  <div class="form-group">
    <label>Nama Penghargaan</label>
    <input class="form-control customInput" type="text" id="nm_pegpenghargaan" name="nm_pegpenghargaan"  required/>
  </div>

  <div class="form-group">
    <label>Nomor SK</label>
    <input class="form-control customInput" type="text" id="nosk" name="nosk"  required/>
  </div>

  
  <div class="form-group">
    <label>Tanggal SK</label>
    <input  class="form-control datepicker"   id="tglsk" name="tglsk" required/>
  </div>

  <div class="form-group">
    <label>Tahun</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="tahun_penghargaan" name="tahun_penghargaan" required/>
  </div>

  <div class="form-group">
    <label>Asal Perolehan</label>
    <input class="form-control customInput" type="text" id="asal" name="asal"  required/>
  </div>


  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id=""><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form> 
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


   

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

    
        $('#upload_form_penghargaan').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_penghargaan');
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
                document.getElementById("upload_form_penghargaan").reset();
                loadFormPenghargaan()
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