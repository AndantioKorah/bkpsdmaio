

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalBerkasPns">
  Tambah Data SK CPNS & PNS
</button>



<button onclick="loadRiwayatUsulBerkasPns()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalBerkasPns">
  Riwayat Usul SK CPNS & PNS
</button>

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalBerkasPns">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_berkaspns"></div>
        </div>
       
      </div>
    </div>
</div>

<div class="modal fade" id="modal_view_file_berkas_pns" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">cdcs
        <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_berkas_pns" style="width: 100%; height: 80vh;" src="http://localhost/bkpsdmaio/arsipberkaspns/SK_CPNS_199401042020121011.pdf"></iframe>
      </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBerkasPns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data SK CPNS & PNS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_berkas_pns" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    
    <div class="form-group">
    <select class="form-select" aria-label="Default select example" name="jenissk" id="jenissk" required>
    <option  selected>- Pilih Jenis SK -</option>
    <option value="1">SK CPNS</option>
    <option value="2">SK PNS</option>
        </select>
        </div>
        <br>


 
  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="pdf_file_pns" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary customButton"  id="btn_upload"><i class="fa fa-save"></i> SIMPAN</button>
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

   
<div id="list_berkaspns">

</div>


<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
      loadListBerkasPns()
    })

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });

    $('.yearpicker').datepicker({
    format: 'yyyy',
    viewMode: "years", 
    minViewMode: "years",
    orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_berkas_pns').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_berkas_pns');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_pns').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
      
      
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
                document.getElementById("upload_form_berkas_pns").reset();
                loadListBerkasPns()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListBerkasPns(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_berkaspns').html('')
    $('#list_berkaspns').append(divLoaderNavy)
    $('#list_berkaspns').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListBerkasPns/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
    }

    function loadRiwayatUsulBerkasPns(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_berkaspns').html('')
    $('#riwayat_usul_berkaspns').append(divLoaderNavy)
    $('#riwayat_usul_berkaspns').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListBerkasPns/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
    }

    

  $("#pdf_file_pns").change(function (e) {

        var extension = pdf_file_pns.value.split('.')[1];
      
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