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
      $jumlah = isset($rs['jumlah']) ? $rs['jumlah'] : $rs['total'];
      if($jumlah > 0){
        $presentase = formatCurrencyWithoutRpWithDecimal((($jumlah / $total_seluruh_pegawai) * 100), 2);
    ?>
      <tr>
          <td colspan="2"><span style="background-color: <?=$colors[$i]?>">&nbsp;&nbsp;</span></td>
          <td colspan="2"><span style="font-size: .7rem;"><?=isset($rs[$nama_label]) ? $rs[$nama_label] : ''?></span></td>
          <td colspan="2"><span style="font-size: .7rem;">:&nbsp;&nbsp;</span></td>
          <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=($presentase)."%"?></span></td>
          <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=" (".formatCurrencyWithoutRp($jumlah,0).")"?></span></td>
      </tr>
    <?php $i++; } } ?>
  </table>
</div>
<script src="<?=base_url('assets/adminkit/js/app.js')?>"></script>
<script>
    $(function(){
        renderChart('<?=json_encode($result)?>')
    })

    function renderChart(rs){
        let dt = JSON.parse(rs)
        // document.addEventListener("DOMContentLoaded", function() {
        let labels = [];
        let values = [];
        let temp = Object.keys(dt.result)
        temp.forEach(function(i) {
            if(dt.result[i].jumlah > 0){
                labels.push(dt.result[i].nama_layanan)
                values.push(dt.result[i].total)
            }
        })

        let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
        // let data_labels = 
        new Chart(document.getElementById(dt.id_chart), {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderColor: "transparent"
                    }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                        display: false
                    }
            }
        });
      // });
    }
</script>