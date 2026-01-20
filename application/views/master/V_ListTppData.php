<table class="table table-hover table-striped" id="table_list_tpp">
  <thead>
    <th class="text-center">No</th>
    <th class="text-left">Pegawai</th>
    <th class="text-center">Kelas Jabatan</th>
    <?php if($this->general_library->isProgrammer()){ ?>
      <th class="text-center">Basic TPP</th>
      <th class="text-center">Prestasi Kerja</th>
      <th class="text-center">Beban Kerja</th>
      <th class="text-center">Kondisi Kerja</th>
      <th class="text-center">Besaran Presentasi</th>
    <?php } ?>
    <th class="text-left">Besaran TPP</th>
  </thead>
  <tbody>
    <?php if($result){
      $pagu_tpp = $this->session->userdata('list_tpp_kelas_jabatan_new');
      $no = 1; foreach($result as $rs){ ?>
      <tr>
        <td class="text-center"><?=$no++;?></td>
        <td class="text-left" style="line-height: 15px;">
          <span style="font-size: 14px; color: black; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
          <span style="font-size: 12px; color: black;">NIP. <?=$rs['nipbaru_ws']?></span><br>
          <span style="font-size: 12px; color: black; font-weight: bold;"><?=$rs['nama_jabatan']?></span><br>
          <span style="font-size: 12px; color: black;"><?=$rs['nm_pangkat']?></span>
        </td>
        <td class="text-center"><?=$rs['kelas_jabatan']?></td>
        <?php if($this->general_library->isProgrammer()){ ?>
          <td class="text-center"><?=isset($pagu_tpp[$rs['kelas_jabatan']]) ? formatCurrencyWithoutRp(($pagu_tpp[$rs['kelas_jabatan']]), 0) : 0?></td>
          <td class="text-center"><?=(floatval($rs['prestasi_kerja'])).'%'?></td>
          <td class="text-center"><?=(floatval($rs['beban_kerja'])).'%'?></td>
          <td class="text-center"><?=(floatval($rs['kondisi_kerja'])).'%'?></td>
          <td class="text-center"><?=floatval($rs['prestasi_kerja']) + floatval($rs['beban_kerja']) + floatval($rs['kondisi_kerja']).'%'?></td>
        <?php } ?>
        <!-- <td class="text-left" style="font-weight: bold;"><?='Rp '.formatCurrencyWithoutRp(($rs['pagu_tpp']), 0)?></td> -->
        <td class="text-left" style="font-weight: bold;"><?='Rp '.formatCurrencyWithoutRpNew(pembulatan($rs['pagu_tpp']), 0)?></td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $('#table_list_tpp').dataTable()
</script>