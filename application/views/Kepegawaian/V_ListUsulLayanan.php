<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Layanan</th>
          <th class="text-left">Tanggal Usul</th>
          <!-- <th class="text-left">Lama Hari Cuti</th>
          <th class="text-left">Tanggal Mulai</th>
          <th class="text-left">Tanggal Selesai</th> -->
          <th class="text-left">Surat Pengantar</th>
          <th class="text-left">Status</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <!-- <td class="text-left"><?=$rs['lama_cuti']?></td>
              <td class="text-left"><?=$rs['tanggal_mulai']?></td>
              <td class="text-left"><?=$rs['tanggal_selesai']?></td> -->
              <td class="text-left">
              <?php if($rs['jenis_layanan'] == 3) { ?>
                <button href="#modal_view_file" onclick="openFileCuti('<?=$rs['file_pengantar']?>')" 
                data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
                <?php } else { ?>
                <button href="#modal_view_file" onclick="openFile('<?=$rs['file_pengantar']?>')" 
                data-toggle="modal" class="btn btn-sm btn-navy-outline">   Lihat <i class="fa fa-search"></i></button>
                  <?php } ?>
              </td>
              <td><?=$rs['status_verif']?></td>
              <td>
              <?php if($rs['jenis_layanan'] == 3) { ?>
              <a data-toggle="modal" data-jenis="<?=$rs['nm_cuti']?>" data-tgl_mulai="<?=$rs['tanggal_mulai']?>" data-tgl_selesai="<?=$rs['tanggal_selesai']?>" class="open-DetailCuti btn btn-sm btn-info" href="#modal_detail_cuti"><i class="fa fa-search"></i> </a>
              <?php } else if($rs['jenis_layanan'] == 12) { ?>
              <!-- <a data-toggle="modal" data-ket="<?=$rs['keterangan_perbaikan']?>" class="open-DetailPerbaikanDataKepeg btn btn-sm btn-info" href="#modal_detail_perbaikan_data"><i class="fa fa-search"></i> </a> -->
              <?php } ?>
              <?php if($rs['status'] == 0) { ?>
              
              <div class="btn-group" role="group" aria-label="Basic example">
                        <!-- <span href="#modal_detail_layanan" data-toggle="modal"  >
                                <button href="#modal_detail_layanan" data-toggle="tooltip" class="btn btn-sm btn-info mr-1"  data-placement="top" title="Edit" 
                                 onclick="openModalDetailUsulLayanan('<?=$rs['id_usul']?>')"><i class="fa fa-search"></i> </button>
                                 </span> -->
                            
                                <button onclick="deleteUsulLayanan('<?=$rs['id_usul']?>','<?=$rs['jenis_layanan']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> </button>
                            </div>
                  <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <!-- <div class="modal fade" id="modal_detail_layanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">Detail Layanan</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="detail_layanan">
          </div>
      </div>
  </div>
</div> -->

<!-- cuti -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_detail_cuti">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Cuti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_nomor_surat" enctype="multipart/form-data" >
        <input type="hidden" id="id_usul" name="id_usul" >
  <div class="mb-3">
    <label for="nomor_surat" class="form-label">Jenis Cuti</label>
    <input type="text" class="form-control" id="jenis_cuti" name="jenis_cuti" readonly>
  </div>
  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Mulai</label>
    <input type="text" class="form-control " id="tanggal_mulai" name="tanggal_mulai" readonly>
  </div>

  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Selesai</label>
    <input type="text" class="form-control " id="tanggal_selesai" name="tanggal_selesai" readonly>
  </div>
 
</form>
      </div>
    </div>
  </div>
</div>
<!-- tutup cuti  -->

<!-- perbaikan data  -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_detail_perbaikan_data">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Perbaikan Data Kepagawaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
  <div class="mb-3">
    <label for="nomor_surat" class="form-label">Perbaikan data yang dimaksud</label>
    <textarea rows="3" class="form-control" id="keterangan_perbaikan" name="keterangan_perbaikan" readonly></textarea>
  </div>


      </div>
    </div>
  </div>
</div>
<!-- tutup perbaikan data  -->
 
<script>
  $(function(){
    $('#datatable').dataTable()
  })

  function openFileCuti(filename){
    var url = "<?=base_url();?>dokumen_layanan/cuti/"
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_pengantar').attr('src', url+nip+'/'+filename)
  }

  function openFile(filename){
    var url = "<?=base_url();?>dokumen_layanan/"
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_pengantar').attr('src', url+nip+'/'+filename)
  }

  function deleteUsulLayanan(id,jenis_layanan){
           
           if(confirm('Apakah Anda yakin ingin menghapus data?')){
               $.ajax({
                   url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteUsulLayanan/")?>'+id,
                   method: 'post',
                   data: null,
                   success: function(){
                       successtoast('Data sudah terhapus')
                       loadListUsulLayanan(jenis_layanan)
                   }, error: function(e){
                       errortoast('Terjadi Kesalahan')
                   }
               })
           }
       }

       function openModalDetailUsulLayanan(id = 0){
        $('#detail_layanan').html('')
        $('#detail_layanan').append(divLoaderNavy)
        $('#detail_layanan').load('<?=base_url("kinerja/C_Kinerja/loadEditRencanaKinerja")?>'+'/'+id, function(){
          $('#loader').hide()
        })
      }

    $(document).on("click", ".open-DetailCuti", function () {
     var jenis = $(this).data('jenis');
     var tgl_mulai = $(this).data('tgl_mulai');
     var tgl_selesai = $(this).data('tgl_selesai');
     $(".modal-body #jenis_cuti").val( jenis );
     $(".modal-body #tanggal_mulai").val( tgl_mulai );
     $(".modal-body #tanggal_selesai").val( tgl_selesai );
    });

    $(document).on("click", ".open-DetailPerbaikanDataKepeg", function () {
     var ket = $(this).data('ket');
     $(".modal-body #keterangan_perbaikan").val( ket );
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

    


</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>