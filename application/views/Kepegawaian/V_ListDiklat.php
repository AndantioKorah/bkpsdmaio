<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Diklat</th>
         
          <th class="text-left">Nama Diklat</th>
          <th class="text-left">Tempat Diklat</th>
          <th class="text-left">Penyelenggara</th>
          <th class="text-left">Angkatan</th>
          <th class="text-left">Jam</th>
          <th class="text-left">Tanggal Mulai / Tanggal Selesai</th>
          <th class="text-left">No / Tanggal STTPP</th>
          <th class="text-left">Sertifikat STTPP</th>
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
              <td class="text-left"><?=$rs['nm_jdiklat']?></td>
              <td class="text-left"><?=$rs['nm_diklat']?></td>
              <td class="text-left"><?=$rs['tptdiklat']?></td>
              <td class="text-left"><?=$rs['penyelenggara']?></td>
              <td class="text-left"><?=$rs['angkatan']?></td>
              <td class="text-left"><?=$rs['jam']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> / <?= formatDateNamaBulan($rs['tglselesai'])?></td>
              <td class="text-left"><?=$rs['nosttpp']?> / <?=formatDateNamaBulan($rs['tglsttpp'])?></td>
              <td class="text-left">
                <button href="#modal_view_file_diklat" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'Di Tolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteKegiatan('<?=$rs['id']?>','<?=$rs['gambarsk']?>' )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_diklat').attr('src', '<?=base_url();?>arsipdiklat/'+filename)
  }

  function deleteKegiatan(id,file){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdiklat/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadRiwayatUsulDiklat()
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