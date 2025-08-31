<div class="col-lg-7">
  <div class="chart chart-sm" style="max-height: 150px !important; min-height: 150px !important;">
    <canvas id="<?=$id_chart?>"></canvas>
  </div>
</div>
<div class="col-lg-5">
  <table>
    <?php 
    
    $i = 0;
    $colors = CHART_COLORS;
    // $total_seluruh_pegawai = $this->session->userdata('total_seluruh_pegawai');
    foreach($result as $rs){
      if($rs['jumlah'] > 0){
        $presentase = formatCurrencyWithoutRpWithDecimal((($rs['jumlah'] / $total_seluruh_pegawai) * 100), 2);
    ?>
      <tr>
          <td colspan="2"><span style="background-color: <?=$colors[$i]?>">&nbsp;&nbsp;</span></td>
          <td colspan="2"><span style="font-size: .7rem;"><?=isset($rs['nama']) ? $rs['nama'] : ''?></span></td>
          <td colspan="2"><span style="font-size: .7rem;">:&nbsp;&nbsp;</span></td>
          <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=($presentase)."%"?></span></td>
          <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=" (".formatCurrencyWithoutRp($rs['jumlah'],0).")"?></span></td>
      </tr>
    <?php $i++; } } ?>
  </table>
</div>