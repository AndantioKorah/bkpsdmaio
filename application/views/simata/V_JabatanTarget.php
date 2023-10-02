<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->getRole() == 'admin_aplikasi') { ?>
    <div class="card card-default">
        
        <div class="card-body div_form_tambah_interval" id="div_form_tambah_interval" >
        <form method="post" id="form_cari" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Pilih Unit Kerja </label>
                            <select   class="form-control select2 " data-dropdown-css-class="select2-navy" name="unit_kerja" id="unit_kerja" required>     
                            <option value="0" disabled selected>Pilih Unit kerja</option>
                                            <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                                                <option value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                

                   
                        <div class="col-lg-8 col-md-8"></div>
                    <div class="col-lg-12 col-md-4 text-right mt-2">
                        <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-search"></i> CARI</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                    <h3 class="card-title"></h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-20px;">
        <div id="list_pegawai">

        </div>
        </div>
    </div>

<?php } ?>

<script>

$(function(){
   

   $(".select2").select2({   
        width: '100%',
        dropdownAutoWidth: true,
        allowClear: true,
    });
   
    loadListPegawaiDinilai()
    })

    function loadListPegawaiDinilai(){
   var id = $('#unit_kerja').val()
   $('#list_pegawai').html('')
   $('#list_pegawai').append(divLoaderNavy)
   $('#list_pegawai').load('<?=base_url("simata/C_Simata/loadListPegawaiDinilai/")?>'+id, function(){
     $('#loader').hide()
   })
  }

  $('#form_cari').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#form_cari');
        var form_data = new FormData(formvalue[0]);
        loadListPegawaiDinilai()

  
}); 

</script>