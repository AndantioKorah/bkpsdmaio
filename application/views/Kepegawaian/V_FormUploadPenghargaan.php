

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


<button onclick="loadRiwayatUsulPenghargaan()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalPenghargaan">
  Riwayat Usul Penghargaan
</button>

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalPenghargaan">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_penghargaan"></div>
        </div>
       
      </div>
    </div>
</div>
<div class="modal fade" id="modal_view_file_penghargaan" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_penghargaan" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>



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
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">


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
    <input autocomplete="off"  class="form-control datepicker"   id="tglsk" name="tglsk" required/>
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


   

<div id="list_penghargaan">

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
        // $('.select2').select2()

   $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  
        $('#datatable').dataTable()
        loadListPenghargaan()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_penghargaan').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_penghargaan');
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
                document.getElementById("upload_form_penghargaan").reset();
                loadListPenghargaan()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListPenghargaan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_penghargaan').html('')
    $('#list_penghargaan').append(divLoaderNavy)
    $('#list_penghargaan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPenghargaan/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulPenghargaan(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_penghargaan').html('')
    $('#riwayat_usul_penghargaan').append(divLoaderNavy)
    $('#riwayat_usul_penghargaan').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPenghargaan/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

  
  function openFilePenghargaan(filename){
    var nip = <?=$this->general_library->getUserName()?>;
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+nip+'/'+filename)
  }

  $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });
  
</script>