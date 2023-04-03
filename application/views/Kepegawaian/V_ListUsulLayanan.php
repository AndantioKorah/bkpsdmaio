<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Jenis Layanan</th>
          <th class="text-center">Tanggal Usul</th>
          <th class="text-center">Lama Hari Cuti</th>
          <th class="text-center">Tanggal Mulai</th>
          <th class="text-center">Tanggal Selesai</th>
          <th class="text-center">Surat Pengantar</th>
          <th class="text-center">Status</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama']?></td>
              <td class="text-center"><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <td class="text-left"><?=$rs['lama_cuti']?></td>
              <td class="text-left"><?=$rs['tanggal_mulai']?></td>
              <td class="text-left"><?=$rs['tanggal_selesai']?></td>
              <td class="text-center">
                <button href="#modal_view_file" onclick="openFile('<?=$rs['file_pengantar']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
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
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>