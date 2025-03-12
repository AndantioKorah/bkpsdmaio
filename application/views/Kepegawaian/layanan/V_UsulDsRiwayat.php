<table class="table table-hover" id="table_riwayat_usul_ds">
  <thead>
    <th class="text-center">No</th>
    <th class="text-center">Nama Pegawai</th>
    <th class="text-center">Keterangan Usul</th>
    <th class="text-center">Tanggal Usul</th>
    <th class="text-center">Jumlah Dokumen</th>
    <th class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
      <tr>
        <td class="text-center"><?=$no++;?></td>
        <td class="text-left"><?=$rs['nama_pegawai']?></td>
        <td class="text-left"><?=$rs['keterangan']?></td>
        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
    <?php } } ?>
  </tbody>
</table>