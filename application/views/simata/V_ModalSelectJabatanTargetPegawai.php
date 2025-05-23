
<form method="post" id="form_tambah_jabatan_target" enctype="multipart/form-data" > 
    <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $id_pegawai;?>">
           <div class="row">
               <div class="col-lg-12">
                   <div class="form-group">
                       <!-- <label class="bmd-label-floating">Rumpun Jabatan</label> -->
                       <select class="form-control select2"   name="jabatan_target" id="jabatan_target" required>
                        <option value="" disabled selected>Pilih Jabatan Target</option>
                        <?php if($jabatan_target){ foreach($jabatan_target as $r){ ?>
                            <option value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                        <?php } } ?>
                        </select>
                            </div>
                        </div>

              
               <div class="col-lg-8 col-md-8"></div>
               <div class="col-lg-12 col-md-4 text-right mt-2 mb-2">
                   <button id="btn_tambah_rumpun" class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
               </div>
         
       </form>

       <div id="list_rumpun_jabatan">
        
       </div>

<script>
	$(function () {
		$(".select2").select2({
			width: '100%',
			dropdownAutoWidth: true,
			allowClear: true,
		});
        loadListJabatanTargetPegawai()
	})

    function loadListJabatanTargetPegawai(){
    var id = "<?=$id_pegawai;?>";
    $('#list_rumpun_jabatan').html('')
    $('#list_rumpun_jabatan').append(divLoaderNavy)
    $('#list_rumpun_jabatan').load('<?=base_url("simata/C_Simata/loadListJabatanTargetPegawai/")?>'+id, function(){
        $('#loader').hide()
    })
    }


    $('#form_tambah_jabatan_target').on('submit', function(e){         
       e.preventDefault();
       var formvalue = $('#form_tambah_jabatan_target');
       var form_data = new FormData(formvalue[0]);
       document.getElementById('btn_tambah_rumpun').disabled = true;
        $('#btn_tambah_rumpun').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

       $.ajax({  
       url:"<?=base_url("simata/C_Simata/submitJabatanTargetNew")?>",
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
               document.getElementById("form_tambah_jabatan_target").reset();
               document.getElementById('btn_tambah_rumpun').disabled = false;
               $('#btn_tambah_rumpun').html('<i class="fa fa-save"></i> Simpan')
               loadListJabatanTargetPegawai()
            //    loadListMasterJabatan()
             } else {
                document.getElementById('btn_tambah_rumpun').disabled = false;
                $('#btn_tambah_rumpun').html('<i class="fa fa-save"></i> Simpan')
               errortoast(result.msg)
               return false;
             } 
           
       }  
       });  
         
       });

</script>
