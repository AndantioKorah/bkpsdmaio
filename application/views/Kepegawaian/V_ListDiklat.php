<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
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
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
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
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <div class="modal fade" id="modal_view_file_diklat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_diklat" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      

 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_diklat').attr('src', 'http://localhost/bkpsdmaio/arsipdiklat/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>