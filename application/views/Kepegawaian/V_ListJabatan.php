<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Jabatan</th>
          <th class="text-center">TMT Jabatan</th>
          <th class="text-center">PD</th>
          <th class="text-center">Nomor SK</th>
          <th class="text-center">Tanggal SK</th>
          <th class="text-center">File</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_jabatan']?></td>
              <td class="text-left"><?=$rs['tmtjabatan']?></td>
              <td class="text-left"><?=$rs['skpd']?></td>
              <td class="text-left"><?=$rs['nosk']?></td>
              <td><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-center">
                <button href="#modal_view_file" onclick="openFilePendidikan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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