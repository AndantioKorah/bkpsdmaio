<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
        
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left">Surat Pengantar</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['created_date'])?></td>
              <td class="text-left">
             <span class="badge badge-<?php if($rs['status'] == '1' || $rs['status'] == '4') echo "success"; else if($rs['status'] == '2') echo "danger"; else echo "primary";?>"><?php if($rs['status'] == '1') echo "Diterima"; else if($rs['status'] == '2') echo "Ditolak"; else if($rs['status'] == '3') echo "Usul BKAD"; else if($rs['status'] == '4')  echo "Diterima BKAD"; else if($rs['status'] == '5') echo "Ditolak BKAD"; else echo "Menunggu Verifikasi BKPSDM" ?>

            </td>
              <td class="text-left"><?=$rs['keterangan']?></td>
            <td>
            <button href="#modal_view_file" onclick="openFilePengantar('<?=$rs['file_pengantar']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
            <i class="fa fa-file-pdf"></i></button>
            </td>
              <td>
              <?php if($rs['status'] == 0) { ?>
              <button title="Hapus" onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              <?php } ?>
              <?php if($rs['status'] == 2) { ?>
              <button title="Hapus" onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> Ubah Surat Pengantar </button> 
              <button onclick="ajukanKembali('<?=$rs['id']?>')" class="btn btn-sm btn-primary">Ajukan Kembali <i class="fa fa-arrow-right"></i></button> 
              <?php } ?>
            </td>
           
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  
 
<div class="modal fade" id="modal_view_file" >
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
           <div id="modal_view_file_content">
            <h5  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file"  frameborder="0" ></iframe>	

          </div>
        </div>
      </div>
    </div>
</div>

<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function deleteData(id){
                  var id_layanan = "<?=$m_layanan;?>"
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteRiwayatLayanan/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
                               loadListRiwayatLayananPangkat()
                               }
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

async function openFilePengantar(filename){

$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 2000);
$link = "<?=base_url();?>dokumen_layanan/pangkat/"+filename+"?v="+number;

$('#iframe_view_file').attr('src', $link)
$('#iframe_view_file').on('load', function(){
  $('.iframe_loader').hide()
  $(this).show()
})
}

function ajukanKembali(id){
                  var id_layanan = "<?=$m_layanan;?>"
                   if(confirm('Ajukan kembali layanan pangkat ?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/ajukanKembaliLayananPangkat/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
                               loadListRiwayatLayananPangkat()
                               }
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