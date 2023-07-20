
  <?php if($result){ ?>
   <div class="table-responsive">
  <table class="table table-striped datatable" id="" border="0">
        <thead>
          <th class="text-left">No </th>
          <th class="text-left">Jenis Layanan</th>
          <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Nama Pegawai</th>
          <th class="text-left">Unit Organisasi</th>
          <th class="text-left">Pengantar </th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class=""><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama_layanan']?></td>
              <td class=""><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <td class="text-left"> <?=getNamaPegawaiFull($rs)?> </td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="">
              <?php if ($rs['jenis_layanan'] == 3) { ?> 
              <a onclick="openDetailLayanan('<?=$rs['file_pengantar']?>','<?=$rs['nip']?>','<?=$rs['nama_layanan']?>','<?=$rs['id_usul']?>')" 
              data-toggle="modal" 
              data-nama_pegawai="<?=getNamaPegawaiFull($rs)?>" 
              data-nip="<?=$rs['nip']?>" title="Input Nomor dan Tanggal Surat" class="open-DetailCuti btn btn-sm btn-info" href="#modal_detail_cuti"><i class="fa fa-search"></i> Lihat</a>
              <?php } else { ?>
                <button href="#modal_view_file" 
                onclick="openFile('<?=$rs['file_pengantar']?>')" 
                data-toggle="modal" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Lihat </button>
                <?php } ?>
              </td>
             
              <td>

              <div class="btn-group" role="group" aria-label="Basic example">
              &nbsp;
             
              <?php if($rs['status'] == 0) { ?> 
              <a href="<?= base_url();?>kepegawaian/verifikasi/<?=$rs['id_usul']?>/<?=$rs['jenis_layanan']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a>
                <?php } ?>

                <?php if($rs['status'] != 0) { ?> 
              
                <button title="Batal Verifikasi" onclick="batalVerif('<?= $rs['id_usul'];?>')"  class="btn btn-sm btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i></button>&nbsp;
              
                <?php } ?>
               
              
              <?php if($rs['jenis_layanan'] == 3) { ?>
              <?php if($rs['status'] == 1) { ?> 
                <button title="Input Nomor dan Tanggal Surat" onclick="openDetailLayanan('<?=$rs['file_pengantar']?>','<?=$rs['nip']?>','<?=$rs['nama_layanan']?>','<?=$rs['id_usul']?>')"   
                data-toggle="modal" class="btn btn-sm btn-info" href="#modal_input_nomor_surat"><i class="fa fa-edit"></i> </button>
                &nbsp;
               
              <a target="_blank" href="<?= base_url();?>kepegawaian/C_Kepegawaian/CetakSurat/<?=$rs['id_usul']?>/<?=$rs['jenis_layanan']?>">
              <button title="Cetak Surat" id="button_pdf" href=""  class="btn btn-sm btn-warning">
               <i class="fa fa-file-pdf"></i></button></a>
               
             <?php } ?>
             <?php } ?>

             <?php if($rs['jenis_layanan'] == 8) { ?>
              <?php if($rs['status'] == 1) { ?> 
                <button title="Input Nomor dan Tanggal Surat" onclick="openDetailLayanan('<?=$rs['file_pengantar']?>','<?=$rs['nip']?>','<?=$rs['nama_layanan']?>','<?=$rs['id_usul']?>')"   
                data-toggle="modal" class="btn btn-sm btn-info" href="#modal_input_nomor_surat"><i class="fa fa-edit"></i> </button>
                &nbsp;
               
              <a target="_blank" href="<?= base_url();?>kepegawaian/C_Kepegawaian/CetakSurat/<?=$rs['id_usul']?>/<?=$rs['jenis_layanan']?>">
              <button title="Cetak Surat Hukdis" id="button_pdf" href=""  class="btn btn-sm btn-warning">
               <i class="fa fa-file-pdf"></i></button>&nbsp;</a>

               <a target="_blank" href="<?= base_url();?>kepegawaian/C_Kepegawaian/CetakSuratPidana/<?=$rs['id_usul']?>/<?=$rs['jenis_layanan']?>">
              <button title="Cetak Surat Pidana" id="button_pdf" href=""  class="btn btn-sm btn-warning">
               <i class="fa fa-file-pdf"></i></button></a>
               
             <?php } ?>
             <?php } ?>
            
             </div>

              </td>
            </tr>
          
          <?php } ?>
        </tbody>
      </table>
      </div>
      <script>
    $(document).on("click", ".open-DetailCuti", function () {
     var jenis = $(this).data('jenis');
     var tgl_mulai = $(this).data('tgl_mulai');
     var tgl_selesai = $(this).data('tgl_selesai');
     var nama_pegawai = $(this).data('nama_pegawai');
     var nip = $(this).data('nip');
     $(".modal-body #jenis_cuti").val( jenis );
     $(".modal-body #tanggal_mulai").val( tgl_mulai );
     $(".modal-body #tanggal_selesai").val( tgl_selesai );
     $(".modal-body #nama_pegawai").html( nama_pegawai );
     $(".modal-body #nip").html( nip );
    });

    function batalVerif(id){
  if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiLayanan")?>',
              method: 'post',
              data: {id_batal:id},
              success: function(datares){
                successtoast('Berhasil batal verifikasi ')
                loadListUsulLayanan(2)
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
        }
    }
              </script>

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
        <input type="hidden" id="jenis_layanan" name="jenis_layanan" >
  <div class="mb-3">
    <label for="nomor_surat" class="form-label">Nomor Surat</label>
    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" >
  </div>
  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
    <input type="text" class="form-control datepicker" id="tanggal_surat" name="tanggal_surat" autocomplete="off">
  </div>
 
  <button id="btn_simpan" class="btn btn-primary" style="float: left;">Simpan</button>
</form>
<form id="my-form" action="#" method="post">
  <button id="btn_pdf" class="btn btn-warning" style="float: right;"> <i class="fa fa-file-pdf"></i> Download PDF</button>
</form>
<script>

</script>
      </div>
    </div>
  </div>
</div>




<script>

function batalVerif(id){
  if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiLayanan")?>',
              method: 'post',
              data: {id_batal:id},
              success: function(datares){
                successtoast('Berhasil batal verifikasi ')
                loadListUsulLayanan(1)
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
        }
    }
  
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
    $('#btn_pdf').hide(); 
  })

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
        autoclose: true
});

var form = document.getElementById('my-form');
var base_url = "<?=base_url();?>"
   
    form.addEventListener('submit', function(event) {
      var id_usul =   $('#id_usul').val(); 
      var jenis_layanan =   $('#jenis_layanan').val(); 
    event.preventDefault();
    window.open(base_url+'kepegawaian/C_Kepegawaian/CetakSurat/'+id_usul+'/'+jenis_layanan, '_blank');
  });

$('#form_nomor_surat').on('submit', function(e){
  
            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitNomorTglSurat")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  successtoast('Data Berhasil disimpan')
                  $('#btn_pdf').show();
                  // loadListUsulLayanan()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })


      $('#modal_input_nomor_surat').on('hidden.bs.modal', function () {
          // loadListUsulLayanan(1)
      });


    // $(document).on("click", ".open-AddBookDialog", function () {
    // var base_url = "<?=base_url();?>"
    //  var nomor = $(this).data('nomor');
    //  var tanggal = $(this).data('tanggal');
    //  var id = $(this).data('id');
    
    
    //  $(".modal-body #id_usul").val( id );
   
    //  $.ajax({
    //     type : "POST",
    //     url  : base_url + 'kepegawaian/C_Kepegawaian/getNomorTanggalSurat',
    //     dataType : "JSON",
    //     data : {id:id},
    //     success: function(data){
    //       if(data[0].nomor_surat == null){
    //         $('#btn_pdf').hide();
    //       } else {
    //         $('#btn_pdf').show();
    //       }

    //       $(".modal-body #nomor_surat").val( data[0].nomor_surat );
    //       $(".modal-body #tanggal_surat").val( data[0].tanggal_surat );
    //      }
    //     });
        
    // });

    $(document).on("click", ".open-DetailCuti", function () {
     var jenis = $(this).data('jenis');
     var tgl_mulai = $(this).data('tgl_mulai');
     var tgl_selesai = $(this).data('tgl_selesai');
     $(".modal-body #jenis_cuti").val( jenis );
     $(".modal-body #tanggal_mulai").val( tgl_mulai );
     $(".modal-body #tanggal_selesai").val( tgl_selesai );
    });



    function openDetailLayanan(filename,nip,layanan,id_usul){
    // alert(id_usul)

    $.ajax({
        type : "POST",
        url  : base_url + 'kepegawaian/C_Kepegawaian/getDetailLayanan',
        dataType : "JSON",
        data : {id_usul:id_usul,layanan:layanan},
        success: function(data){
       
        $(".modal-body #jenis_cuti").val( data[0].nm_cuti );
        $(".modal-body #tanggal_mulai").val( data[0].tanggal_mulai );
        $(".modal-body #tanggal_selesai").val( data[0].tanggal_selesai );
        $(".modal-body #nomor_surat").val( data[0].nomor_surat );
        $(".modal-body #tanggal_surat").val( data[0].tanggal_surat );
        $('.modal-body #id_usul').val(data[0].id_usul); 
        $('.modal-body #jenis_layanan').val(data[0].jenis_layanan);   
         }
        });

    var url = "<?=base_url();?>dokumen_layanan/"+layanan+"/"
    $('#iframe_view_file').attr('src', url+nip+'/'+filename)
  }

  function openFile(filename){
    var path = "<?=base_url();?>dokumen_layanan/"
    var nip = "<?=$this->general_library->getUserName()?>";
    var url =  "<?=base_url();?>dokumen_layanan/"+nip+'/'+filename
    console.log(url)
    $('#iframe_view_file_pengantar').attr('src', url)
  }

</script>