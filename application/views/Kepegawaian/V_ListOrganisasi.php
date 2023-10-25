<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Organisasi</th>
          <th class="text-left">Nama Organisasi</th>
          <th class="text-left">Kedudukan / Jabatan</th>
          <th class="text-left">Tanggal Mulai - Selesai</th>
          <th class="text-left">Pemimpin</th>
          <th class="text-left">Tempat</th>
          <th></th>
          <th></th>
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
              <td class="text-left"><?=$rs['nm_organisasi']?></td>
              <td class="text-left"><?= $rs['nama_organisasi']?></td>    
              <td class="text-left"><?php  if($rs['nm_jabatan_organisasi'] == "-") echo $rs['jabatan_organisasi']; else echo $rs['nm_jabatan_organisasi'];   ?></td>          
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> - <?= formatDateNamaBulan($rs['tglselesai'])?></td>          
              <td class="text-left"><?= $rs['pemimpin']?></td> 
              <td class="text-left"><?= $rs['tempat']?></td> 
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_organisasi" onclick="openFileOrganisasi('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td> 
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_pegorganisasi']?>"
                href="#modal_edit_organisasi"
                onclick="loadEditOrganisasi('<?=$rs['id_pegorganisasi']?>')" title="Ubah Data" class="open-DetailOrganisasi btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
                <?php } ?>

              <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip) { ?>

                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_pegorganisasi']?>"
                href="#modal_edit_organisasi"
                onclick="loadEditOrganisasi('<?=$rs['id_pegorganisasi']?>')" title="Ubah Data" class="open-DetailOrganisasi btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>
                <?php } ?>

                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                  <button onclick="deleteData('<?=$rs['id_pegorganisasi']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 

              </div>
             
             
              </td>
              <?php } ?>
               <?php } ?>
              <?php if($kode == 2) { ?>  
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>      
                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteData('<?=$rs['id_pegorganisasi']?>',2)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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


async function openFileOrganisasi(filename){

$('#iframe_view_file_organisasi').hide()
$('.iframe_loader').show()  
$('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')

var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsiporganisasi/"+filename+"?v="+number;


$('#iframe_view_file_organisasi').attr('src', $link)
    $('#iframe_view_file_organisasi').on('load', function(){
      $('.iframe_loader').hide()
      $(this).show()
})

}

  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegorganisasi/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListOrganisasi()
                               } else {
                                loadRiwayatUsulOrganisasi()
                               }
                               
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

        function loadEditOrganisasi(id){
              $('#edit_organisasi_pegawai').html('')
              $('#edit_organisasi_pegawai').append(divLoaderNavy)
              $('#edit_organisasi_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditOrganisasi")?>'+'/'+id, function(){
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