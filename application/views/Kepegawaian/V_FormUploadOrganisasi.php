

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalOrganisasi">
  Tambah Data Organisasi
</button>


<button onclick="loadRiwayatUsulOrganisasi()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalOrganisasi">
  Riwayat Usul Organisasi
</button>

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalOrganisasi">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_organisasi"></div>
        </div>
       
      </div>
    </div>
</div>
<div class="modal fade" id="modal_view_file_organisasi" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_organisasi" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
        </div>
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalOrganisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Organisasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_organisasi" enctype="multipart/form-data" >
   
   <input type="hidden" id="id_pegorganisasi" name="id_pegorganisasi" value="">
   <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">

    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Jenis Organisasi </label>
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
    <input  autocomplete="off"  class="form-control datepicker"   id="tglmulai" name="tglmulai" required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berakhir</label>
    <input autocomplete="off"  class="form-control datepicker"   id="tglselesai" name="tglselesai" required/>
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
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


   

<div id="list_organisasi">

</div>



<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
        loadListOrganisasi()
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
                loadListOrganisasi()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListOrganisasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_organisasi').html('')
    $('#list_organisasi').append(divLoaderNavy)
    $('#list_organisasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListOrganisasi/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulOrganisasi(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_organisasi').html('')
    $('#riwayat_usul_organisasi').append(divLoaderNavy)
    $('#riwayat_usul_organisasi').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListOrganisasi/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

  

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