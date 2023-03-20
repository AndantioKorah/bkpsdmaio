<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-striped">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Pendidikan</th>
          <th class="text-center">Jurusan</th>
          <th class="text-center">Fakultas</th>
          <th class="text-center">Nama Sekolah</th>
          <th class="text-center">Tahun Lulus</th>
          <th class="text-center">Nomor /Tgl Ijazah</th>
          <th class="text-center">File</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_tktpendidikanb']?></td>
              <td class="text-left"><?=$rs['jurusan']?></td>
              <td class="text-left"><?=$rs['fakultas']?></td>
              <td class="text-left"><?=$rs['namasekolah']?></td>
              <td class="text-left"><?=$rs['tahunlulus']?></td>
              <td class="text-center"><?=$rs['noijasah']?> / <?=formatDateNamaBulan($rs['tglijasah'])?></td>
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