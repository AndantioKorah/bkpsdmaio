<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->getRole() == 'admin_aplikasi') { ?>
   

    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                    <h3 class="card-title"></h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-20px;">
        <div id="list_pegawai_penilaian_kinerja">

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
   
    loadListPegawaiPenilaianKinerja()
    })

    function loadListPegawaiPenilaianKinerja(){
   var id = $('#unit_kerja').val()
   $('#list_pegawai_penilaian_kinerja').html('')
   $('#list_pegawai_penilaian_kinerja').append(divLoaderNavy)
   $('#list_pegawai_penilaian_kinerja').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainKinerja/")?>'+id, function(){
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