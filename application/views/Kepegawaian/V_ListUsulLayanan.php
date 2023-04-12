<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Jenis Layanan</th>
          <th class="text-center">Tanggal Usul</th>
          <!-- <th class="text-center">Lama Hari Cuti</th>
          <th class="text-center">Tanggal Mulai</th>
          <th class="text-center">Tanggal Selesai</th> -->
          <th class="text-center">Surat Pengantar</th>
          <th class="text-center">Status</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama']?></td>
              <td class="text-center"><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <!-- <td class="text-left"><?=$rs['lama_cuti']?></td>
              <td class="text-left"><?=$rs['tanggal_mulai']?></td>
              <td class="text-left"><?=$rs['tanggal_selesai']?></td> -->
              <td class="text-center">
                <button href="#modal_view_file" onclick="openFile('<?=$rs['file_pengantar']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
              <td><?=$rs['status_verif']?></td>
              <td>

              <div class="btn-group" role="group" aria-label="Basic example">
                        <span href="#modal_detail_layanan" data-toggle="modal"  >
                                <button href="#modal_detail_layanan" data-toggle="tooltip" class="btn btn-sm btn-primary mr-1"  data-placement="top" title="Edit" 
                                 onclick="openModalDetailUsulLayanan('<?=$rs['id_usul']?>')"><i class="fa fa-edit"></i> </button>
                                 </span>
                            
                                <button onclick="deleteUsulLayanan('<?=$rs['id_usul']?>','<?=$rs['jenis_layanan']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> </button>
                            </div>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <div class="modal fade" id="modal_detail_layanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
</div>

 
<script>
  $(function(){
    $('#datatable').dataTable()
  })

  function openFile(filename){
    var url = "http://localhost/bkpsdmaio/dokumen_layanan/cuti/"
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file').attr('src', url+nip+'/'+filename)
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


</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>