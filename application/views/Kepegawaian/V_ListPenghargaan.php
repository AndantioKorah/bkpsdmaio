<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Penghargaan</th>
          <th class="text-left">No. SK</th>
          <th class="text-left">Tgl SK</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Asal Perolehan</th>
          <th class="text-left">Keterangan</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_pegpenghargaan']?></td>
              <td class="text-left"><?=$rs['nosk']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?=$rs['tahun_penghargaan']?></td>
              <td class="text-left"><?=$rs['asal']?></td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>

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