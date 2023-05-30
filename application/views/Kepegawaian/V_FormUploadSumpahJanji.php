

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSumpahJanji">
  Tambah Data Sumpah Janji
</button>


<button onclick="loadRiwayatUsulSumpahJanji()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalSumpahJanji">
  Riwayat Usul Sumpah Janji
</button>

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style>
<div class="modal fade" id="myModalSumpahJanji">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_sumpah_janji"></div>
        </div>
       
      </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalSumpahJanji" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Sumpah Janji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" id="upload_form_sumpah_janji" enctype="multipart/form-data" >
   
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">


  
  <div class="form-group">
    <label>Sumpah / Janji</label>
    <select class="form-control " name="sumpahpeg" id="sumpahpeg" required>
			<option value="" disabled selected>Pilih Item</option>
			<?php if($jenis_sumpah){ foreach($jenis_sumpah as $r){ ?>
                        <option value="<?=$r['id_sumpah']?>"><?=$r['nm_sumpah']?></option>
                    <?php } } ?>
		</select>
  </div>

  <div class="form-group">
    <label>Yang Mengambil Sumpah</label>
    <input  class="form-control yearpicker" autocomplete="off"   id="pejabat" name="pejabat" required/>
  </div>

  <div class="form-group">
    <label>Nomor Berita Acara</label>
    <input class="form-control customInput" type="text" id="noba" name="noba"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Berita Acara</label>
    <input class="form-control datepicker" autocomplete="off" type="text" id="tglba" name="tglba"  required/>
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


   

<div id="list_sumpah_janji">

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
        loadListSumpahJanji()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_sumpah_janji').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_form_sumpah_janji');
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
                document.getElementById("upload_form_sumpah_janji").reset();
                loadListSumpahJanji()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListSumpahJanji(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_sumpah_janji').html('')
    $('#list_sumpah_janji').append(divLoaderNavy)
    $('#list_sumpah_janji').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSumpahJanji/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulSumpahJanji(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_sumpah_janji').html('')
    $('#riwayat_usul_sumpah_janji').append(divLoaderNavy)
    $('#riwayat_usul_sumpah_janji').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListSumpahJanji/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }


  


  
</script>