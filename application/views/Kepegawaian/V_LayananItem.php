
  <?php if($result){ ?>
   
  <table class="table table-striped datatable" id="" border="0">
        <thead>
          <th class="">No </th>
          <th class="">Jenis Layanan</th>
          <th class="">Tanggal Usul</th>
          <th class="">Nama Pegawai</th>
          <th class="">Unit Organisasi</th>
          <th class="">Pengantar</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class=""><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama_layanan']?></td>
              <td class=""><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <td class="text-left"><?=$rs['nama_pegawai']?></td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="">
                <button href="#modal_view_file" onclick="openFile('<?=$rs['file_pengantar']?>','<?=$rs['nip']?>','<?=$rs['nama_layanan']?>')" data-toggle="modal" class="btn btn-sm btn-success">
                Lihat <i class="fa fa-search"></i></button>
              </td>
             
              <td>

              <div class="btn-group" role="group" aria-label="Basic example">
              <a data-toggle="modal" data-jenis="<?=$rs['nm_cuti']?>" data-tgl_mulai="<?=$rs['tanggal_mulai']?>" data-tgl_selesai="<?=$rs['tanggal_selesai']?>" title="Input Nomor dan Tanggal Surat" class="open-DetailCuti btn btn-sm btn-info" href="#modal_detail_cuti"><i class="fa fa-search"></i> </a>
              &nbsp;
              <?php if($rs['status'] == 0) { ?> 
              <a href="<?= base_url();?>kepegawaian/verifikasi/<?=$rs['id_usul']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a>
                <?php } ?>
                <?php if($rs['jenis_layanan'] == 3) { ?>
              <?php if($rs['status'] == 1) { ?> 
                  
                <form method="post" id="form_batal_verifikasi_layanan" enctype="multipart/form-data" >
              <input type="hidden" name="id_batal" id="id_batal" value="<?= $rs['id_usul'];?>">
              <button title="Batal Verifikasi"  id="btn_tolak_verifikasi"  class="btn btn-sm btn-danger" >
              <i class="fa fa-times" aria-hidden="true"></i>
              </button>
              </form>  &nbsp;

                <a data-toggle="modal" data-id="<?=$rs['id_usul']?>" data-nomor="<?=$rs['nomor_surat']?>" data-tanggal="<?=$rs['tanggal_surat']?>" title="Input Nomor dan Tanggal Surat" class="open-AddBookDialog btn btn-sm btn-info" href="#modal_input_nomor_surat"><i class="fa fa-edit"></i> </a>
                &nbsp;
                <?php if($rs['nomor_surat'] != "") { ?>
              <a target="_blank" href="<?= base_url();?>Kepegawaian/C_Kepegawaian/CetakSurat/<?=$rs['id_usul']?>">
              <button href=""  class="btn btn-sm btn-warning">
               <i class="fa fa-file-pdf"></i></button></a>
               <?php } ?>
             <?php } ?>
             <?php } ?>
             </div>

              </td>
            </tr>
          
          <?php } ?>
        </tbody>
      </table>

<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>

</div>
</div>
</div>
</div>
</div>


<?php if($result){ ?>
<?php if($rs['status'] == 1) { ?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_input_nomor_surat">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Nomor dan Tanggal Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_nomor_surat" enctype="multipart/form-data" >
        <input type="hidden" id="id_usul" name="id_usul" >
  <div class="mb-3">
    <label for="nomor_surat" class="form-label">Nomor Surat</label>
    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" >
  </div>
  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
    <input type="text" class="form-control datepicker" id="tanggal_surat" name="tanggal_surat" autocomplete="off">
  </div>
 
  <button id="btn_simpan" class="btn btn-primary" style="float: right;">Simpan</button>
</form>
      </div>
    </div>
  </div>
</div>


<script>
  
  $('#form_batal_verifikasi_layanan').on('submit', function(e){
          e.preventDefault()
          if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiLayanan")?>',
              method: 'post',
              data: $(this).serialize(),
              success: function(datares){
                successtoast('Berhasil batal verifikasi ')
                loadListUsulLayanan(1)
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
        }
      })
    
</script>
<?php } ?>
<?php } ?>

<script>

$(function(){
    $('.datatable').dataTable()
  })

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: true,
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
        autoclose: true
});



$('#form_nomor_surat').on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitNomorTglSurat")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  successtoast('Data Berhasil Diverifikasi')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })


      $('#modal_input_nomor_surat').on('hidden.bs.modal', function () {
          loadListUsulLayanan(1)
      });


    $(document).on("click", ".open-AddBookDialog", function () {
     var nomor = $(this).data('nomor');
     var tanggal = $(this).data('tanggal');
     var id = $(this).data('id');
     $(".modal-body #nomor_surat").val( nomor );
     $(".modal-body #tanggal_surat").val( tanggal );
     $(".modal-body #id_usul").val( id );
    });

    $(document).on("click", ".open-DetailCuti", function () {
     var jenis = $(this).data('jenis');
     var tgl_mulai = $(this).data('tgl_mulai');
     var tgl_selesai = $(this).data('tgl_selesai');
     $(".modal-body #jenis_cuti").val( jenis );
     $(".modal-body #tanggal_mulai").val( tgl_mulai );
     $(".modal-body #tanggal_selesai").val( tgl_selesai );
    });



</script>