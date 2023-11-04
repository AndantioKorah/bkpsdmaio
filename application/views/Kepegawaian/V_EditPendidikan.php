<form method="post" id="form_edit_pendidikan" enctype="multipart/form-data" >
<input type="hidden" id="id" name="id" value="<?= $pendidikan[0]['id'];?>">
    <input type="hidden" id="gambarsk" name="gambarsk" value="<?= $pendidikan[0]['gambarsk'];?>">
    
    
    <!-- <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?> -->

   <?php if($pendidikan[0]['status']==2){ ?>       
   <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  <div style="display:none">
  <?php } else { ?> 
   <div>
  <?php } ?>
  <?php }?>


    <div class="form-group" style="margin-bottom:10px !important;">
    <label >Tingkat Pendidikan </label>
    <select class="form-control select2" data-dropdown-parent="#modal_edit_pendidikan" data-dropdown-css-class="select2-navy" name="edit_pendidikan_tingkat" id="edit_pendidikan_tingkat" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <?php if($list_tingkat_pendidikan){ foreach($list_tingkat_pendidikan as $r){ ?>
                        <option <?php if($pendidikan[0]['tktpendidikan'] == $r['id_tktpendidikanb']) echo "selected"; else echo ""; ?> value="<?=$r['id_tktpendidikanb']?>"><?=$r['nm_tktpendidikanb']?></option>
                    <?php } } ?>
    </select>
    </div>
   

  <div class="form-group">
    <label>Jurusan</label>
    <input class="form-control customInput" type="text" id="edit_pendidikan_jurusan" name="edit_pendidikan_jurusan" value="<?= $pendidikan[0]['jurusan'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Fakultas</label>
    <input class="form-control customInput" type="text" id="edit_pendidikan_fakultas" name="edit_pendidikan_fakultas" value="<?= $pendidikan[0]['fakultas'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Nama Sekolah/Universitas</label>
    <input class="form-control customInput" type="text" id="edit_pendidikan_nama_sekolah_universitas" name="edit_pendidikan_nama_sekolah_universitas" value="<?= $pendidikan[0]['namasekolah'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Nama Pimpian</label>
    <input class="form-control customInput" type="text" id="edit_pendidikan_nama_pimpinan" name="edit_pendidikan_nama_pimpinan" value="<?= $pendidikan[0]['pimpinansekolah'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tahun Lulus</label>
    <input autocomplete="off" class="form-control yearpicker" type="text" id="edit_pendidikan_tahun_lulus" name="edit_pendidikan_tahun_lulus" value="<?= $pendidikan[0]['tahunlulus'];?>"  required/>
  </div>

  <div class="form-group">
    <label>No. STTB/Ijazah</label>
    <input class="form-control customInput" type="text" id="edit_pendidikan_no_ijazah" name="edit_pendidikan_no_ijazah" value="<?= $pendidikan[0]['noijasah'];?>"  required/>
  </div>

  <div class="form-group">
    <label>Tgl. STTB/Ijazah</label>
    <input autocomplete="off"  class="form-control datepicker"   id="edit_pendidikan_tanggal_ijazah" name="edit_pendidikan_tanggal_ijazah" value="<?= $pendidikan[0]['tglijasah'];?>" required/>
  </div>
  <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
  </div>
   <?php } ?>


  <div class="form-group">
    <label>File Ijazah</label>
    <input  class="form-control my-image-field" type="file" id="pendidikan_pdf_edit_file" name="file"   />
    <span style="color:red;">* Maksimal Ukuran File : <?= round($format_dok['file_size']/1024)?> MB</span><br>
  </div>

  <div class="form-group col-lg-12">
    <br>
     <button class="btn btn-block btn-primary float-right"  id="btn_edit_pendidikan"><i class="fa fa-save"></i> SIMPAN</button>
 </div>
</form>

<script>
        $(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
   
    })


    $('#form_edit_pendidikan').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_edit_pendidikan');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pendidikan_pdf_edit_file').files.length;
    
     document.getElementById('btn_edit_pendidikan').disabled = true;
     $('#btn_edit_pendidikan').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditPendidikan")?>",
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
             // document.getElementById("form_edit_pendidikan").reset();
             document.getElementById('btn_edit_pendidikan').disabled = false;
            $('#btn_edit_pendidikan').html('Simpan')
             setTimeout(function() {$("#modal_edit_pendidikan").trigger( "click" );}, 1000);
             const myTimeout = setTimeout(loadListPendidikan, 2000);
             loadRiwayatUsulPendidikan()
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 


            $("#pendidikan_pdf_edit_file").change(function (e) {

            var extension = pendidikan_pdf_edit_file.value.split('.')[1];

            var fileSize = this.files[0].size/1024;
            var MaxSize = <?=$format_dok['file_size']?>;
            var MaxMb = MaxSize/1024;

            if (extension != "pdf"){
            errortoast("Harus File PDF")

            $(this).val('');
            }

            if (fileSize > MaxSize ){
                errortoast("Maksimal Ukuran File "+MaxMb+" MB")
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

</script>