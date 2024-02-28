
<form method="post" id="form_tambah_rumpun_jabatan" enctype="multipart/form-data" > 
    <input type="hidden" name="id_jabatan" id="id_jabatan" value="<?= $id_jabatan;?>">
           <div class="row">
               <div class="col-lg-12">
                   <div class="form-group">
                       <label class="bmd-label-floating">Rumpun Jabatan</label>
                       <select class="form-control select2" data-dropdown-parent="#modal_input_rumpun_jabatan"  name="id_m_rumpun_jabatan" id="id_m_rumpun_jabatan" required>
                        <option value="" disabled selected>Pilih Rumpun Jabatan</option>
                        <?php if($rumpun_jabatan){ foreach($rumpun_jabatan as $r){ ?>
                            <option value="<?=$r['id']?>"><?=$r['nm_rumpun_jabatan']?></option>
                        <?php } } ?>
                        </select>
                            </div>
                        </div>

              
               <div class="col-lg-8 col-md-8"></div>
               <div class="col-lg-12 col-md-4 text-right mt-2 mb-2">
                   <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
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
        loadListRumpunJabatan()
	})

    function loadListRumpunJabatan(){
    var id = "<?=$id_jabatan;?>";
    $('#list_rumpun_jabatan').html('')
    $('#list_rumpun_jabatan').append(divLoaderNavy)
    $('#list_rumpun_jabatan').load('<?=base_url("simata/C_Simata/loadListRumpunJabatan/")?>'+id, function(){
        $('#loader').hide()
    })
    }


    $('#form_tambah_rumpun_jabatan').on('submit', function(e){         
       e.preventDefault();
       var formvalue = $('#form_tambah_rumpun_jabatan');
       var form_data = new FormData(formvalue[0]);
       $.ajax({  
       url:"<?=base_url("simata/C_Simata/submitTambahRumpunJabatan")?>",
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
               document.getElementById("form_tambah_rumpun_jabatan").reset();
               loadListRumpunJabatan()
            //    loadListMasterJabatan()
             } else {
               errortoast(result.msg)
               return false;
             } 
           
       }  
       });  
         
       });

</script>
