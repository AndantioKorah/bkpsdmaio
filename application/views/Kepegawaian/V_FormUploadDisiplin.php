

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<!-- Button trigger modal -->
	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() 
	|| $this->general_library->isHakAkses('menu_bidang_pekin') 
	|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN ){ ?>
<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalDisiplin">
  Tambah Data Disiplin
</button>
<!-- 
<button onclick="loadRiwayatUsulDisiplin()"  type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModalDiklat">
  Riwayat Usul Disiplin
</button> -->
<?php } ?> 

<!-- 

<style>
  .modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
   
</style> -->
<div class="modal fade" id="myModalDiklat">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Riwayat Usul</h4>    
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div><div class="container"></div>
        <div class="modal-body">
        <div id="riwayat_usul_disiplin"></div>
        </div>
       
      </div>
    </div>
</div>

<div class="modal fade" id="modal_view_file_disiplin" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_disiplin"  frameborder="0" ></iframe>	
      </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDisiplin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Diklat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="upload_form_disiplin" enctype="multipart/form-data" >
    <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?= $format_dok['id_dokumen'];?>">
    <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
    

    <div class="form-group" style="margin-bottom:10px !important;" >
    <label >Hukuman Disiplin </label>
    <select class="form-control select2" data-dropdown-parent="#modalDisiplin" data-dropdown-css-class="select2-navy" name="disiplin_hd" id="disiplin_hd" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($hd){ foreach($hd as $r){ ?>
                        <option value="<?=$r['idk']?>"><?=$r['nama']?></option>
                    <?php } } ?>
    </select>
    </div>

    <div class="form-group">
      <label>Jenjang Hukuman Disiplin </label>
      <select class="form-control select2" data-dropdown-parent="#modalDisiplin" data-dropdown-css-class="select2-navy" name="disiplin_jhd" id="disiplin_jhd" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($jhd){ foreach($jhd as $r){ ?>
                        <option value="<?=$r['id_jhd']?>"><?=$r['nama_jhd']?></option>
                    <?php } } ?>
    </select>
      </div>

  <div class="form-group">
    <label>Jenis Pelanggaran</label>
    <input class="form-control customInput" type="text" id="disiplin_jp" name="disiplin_jp"  required/>
  </div>

  <!-- <div class="form-group">
    <label>Tanggal Mulai Berlaku</label>
    <input class="form-control customInput datepicker" type="text" id="disiplin_tglmulai" name="disiplin_tglmulai" readonly required/>
  </div>

  <div class="form-group">
    <label>Tanggal Selesai Berlaku</label>
    <input class="form-control customInput datepicker" type="text" id="disiplin_tglselesai" name="disiplin_tglselesai" readonly  required/>
  </div> -->

  <div class="form-group">
    <label>No Surat</label>
    <input class="form-control customInput" type="text" id="disiplin_nosurat" name="disiplin_nosurat"  required/>
  </div>

  <div class="form-group">
    <label>Tanggal Surat</label>
    <input class="form-control customInput datepicker" type="text" id="disiplin_tglsurat" name="disiplin_tglsurat" readonly  required/>
  </div>

  
  <div class="form-group">
    <label>File SK</label>
    <input  class="form-control my-image-field" type="file" id="disiplin_pdf_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
    <button class="btn btn-block btn-primary customButton"  id="btn_upload_disiplin"><i class="fa fa-save"></i> SIMPAN</button>
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

  

<div id="list_disiplin">

</div>


<!-- Modal -->
<div class="modal fade" id="modal_edit_disiplin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Disiplin</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_disiplin_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
        loadListDisiplin()
    })

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});

    
        $('#upload_form_disiplin').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#upload_form_disiplin');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('disiplin_pdf_file').files.length;
        
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }
       
        // document.getElementById('btn_upload_disiplin').disabled = true;
        // $('#btn_upload_disiplin').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
      
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
                document.getElementById("upload_form_disiplin").reset();
                document.getElementById('btn_upload_disiplin').disabled = false;
               $('#btn_upload_disiplin').html('Simpan')
                loadListDisiplin()
                setTimeout(function() {$("#modalDisiplin").trigger( "click" );}, 1000);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

    function loadListDisiplin(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#list_disiplin').html('')
    $('#list_disiplin').append(divLoaderNavy)
    $('#list_disiplin').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListDisiplin/")?>'+nip+'/1', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayatUsulDisiplin(){
      var nip = "<?= $profil_pegawai['nipbaru_ws']?>";
    $('#riwayat_usul_disiplin').html('')
    $('#riwayat_usul_disiplin').append(divLoaderNavy)
    $('#riwayat_usul_disiplin').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListDisiplin/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }


  function openFilePangkat(filename){
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }

  $("#disiplin_pdf_file").change(function (e) {

    

        // var extension = disiplin_pdf_file.value.split('.')[1];
        var fileSize = this.files[0].size/1024;
        var MaxSize = <?=$format_dok['file_size']?>;

        var doc = disiplin_pdf_file.value.split('.')
        var extension = doc[doc.length - 1]
       

     
        if (extension != "pdf"){
          errortoast("Harus File PDF")
          $(this).val('');
        }

        if (fileSize > MaxSize ){
          errortoast("Maksimal Ukuran File 1 MB")
          $(this).val('');
        }

        });

        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
            orientation: 'bottom',
            autoclose: true
        });

  

  $("#disiplin_jenis").change(function() {
      var id = $("#disiplin_jenis").val();
      $('#inputjd').show('fast')
      if(id == "00"){
      $('#inputjd').show('fast')
      } else if(id == "10") {
        $('#inputjd').show('fast')
      } else {
        $('#inputjd').hide('fast')
      }
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getJenjangDiklat",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].jenjang_disiplin+'</option>';
                      }
                      $('.jdisiplin').html(html);
                          }
                  });
  });

</script>