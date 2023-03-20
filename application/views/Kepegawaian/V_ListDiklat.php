<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Diklat</th>
          <th class="text-center">Penyelenggara</th>
          <th class="text-center">Jam</th>
          <th class="text-center">Tgl Mulai/Selesai</th>
          <th class="text-center">No /Tgl STTPL</th>
          <th class="text-center">File</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_diklat']?></td>
              <td class="text-left"><?=$rs['penyelenggara']?></td>
              <td class="text-left"><?=$rs['jam']?></td>
              <td class="text-center"><?=formatDateNamaBulan($rs['tglmulai'])?>/ <?=formatDateNamaBulan($rs['tglselesai'])?></td>
              <td class="text-center"><?=$rs['nosttpp']?>/ <?=formatDateNamaBulan($rs['tglsttpp'])?></td>
              <td class="text-center">
                <button href="#modal_view_file" onclick="openFileDiklat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

<script>
  function openFilePendidikan(filename){
    $('#iframe_view_file').attr('src', 'http://bkd.manadokota.go.id/simpegonline/adm/arsipelektronik/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>