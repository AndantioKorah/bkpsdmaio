<table class="table table-hover table-striped" id="table_list_tpp">
  <thead>
    <th class="text-center">No</th>
    <th class="text-left">Pegawai</th>
    <th class="text-center">Kelas Jabatan</th>
    <th class="text-center">Prestasi Kerja</th>
    <th class="text-center">Beban Kerja</th>
    <th class="text-center">Kondisi Kerja</th>
    <th class="text-center">Besaran Presentasi</th>
    <th class="text-left">Besaran TPP</th>
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
      <tr>
        <td class="text-center"><?=$no++;?></td>
        <td class="text-left" style="line-height: 15px;">
          <span style="font-size: 14px; color: black; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
          <span style="font-size: 12px; color: black;">NIP. <?=$rs['nipbaru_ws']?></span><br>
          <span style="font-size: 12px; color: black; font-weight: bold;"><?=$rs['nama_jabatan']?></span><br>
          <span style="font-size: 12px; color: black;"><?=$rs['nm_pangkat']?></span>
        </td>
        <td class="text-center"><?=$rs['kelas_jabatan']?></td>
        <td class="text-center"><?=formatCurrencyWithoutRp(floatval($rs['prestasi_kerja'])).'%'?></td>
        <td class="text-center"><?=formatCurrencyWithoutRp(floatval($rs['beban_kerja'])).'%'?></td>
        <td class="text-center"><?=formatCurrencyWithoutRp(floatval($rs['kondisi_kerja'])).'%'?></td>
        <td class="text-center"><?=floatval($rs['prestasi_kerja']) + floatval($rs['beban_kerja']) + floatval($rs['kondisi_kerja']).'%'?></td>
        <td class="text-left" style="font-weight: bold;"><?='Rp '.formatCurrencyWithoutRp($rs['pagu_tpp'], 0)?></td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $('#table_list_tpp').dataTable()
</script>