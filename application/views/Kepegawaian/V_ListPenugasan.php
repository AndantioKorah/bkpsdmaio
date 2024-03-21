<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Penugasan</th>
          <th class="text-left">Tujuan</th>
          <th class="text-left">Pejabat Yang Menetapkan</th>
          <th class="text-left">Nomor SK</th>
          <th class="text-left">Tanggal SK</th>
          <th class="text-left">Lamanya</th>
          <th></th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
            <?php } ?>
          <?php if($kode == 2) { ?>
            <th class="text-left">Tanggal Usul</th>

          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>


        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">


              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_jenistugas']?></td>
              <td class="text-left"><?= $rs['tujuan']?></td>          
              <td class="text-left"><?= $rs['pejabat']?></td> 
              <td class="text-left"><?= $rs['nosk']?></td> 
              <td class="text-left"><?= $rs['tglsk']?></td> 
              <td class="text-left"><?= $rs['lamanya']?></td> 
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_penugasan" onclick="openFilePenugasan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <td>
              <?php if($kode == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              <?php } ?>
            </td>
               <?php } ?>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>',2)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  async function openFilePenugasan(filename){

$('#iframe_view_file_penugasan').hide()
$('.iframe_loader').show()  
$('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')

var number = Math.floor(Math.random() * 1000);
    // $link = "http://siladen.manadokota.go.id/bidik/arsiporganisasi/"+filename+"?v="+number;
    $link = "<?=base_url();?>/arsippenugasan/"+filename+"?v="+number;


$('#iframe_view_file_penugasan').attr('src', $link)
    $('#iframe_view_file_penugasan').on('load', function(){
      $('.iframe_loader').hide()
      $(this).show()
})

}

  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdatalain/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListPenugasan()
                               } else {
                                loadRiwayatUsulPenugasan()
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