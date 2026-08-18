<style>
    .sp_rating_total{
        font-size: 6rem;
        font-weight: bold;
    }

    .box-rating{
        border-radius: 10px;
        border: 1px solid lightgrey;
        padding: 5px;
    }

    .sp_rating_lbl{
        color: grey;
        font-size: .75rem;
        font-weight: bold;
        font-style: italic;
        line-height: 50px;
    }

    .sp_rating_sec{
        font-size: 3.75rem;
        font-weight: bold;
    }

    .card-header-rekap-okta{
        padding-top: 10px !important;
        padding-bottom: 0px !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .card-header-rekap-okta > .card-title{ 
        font-size: .85rem !important;
        white-space: nowrap;     /* Prevents text from wrapping to a new line */
        overflow: hidden;        /* Hides the text that spills out */
        text-overflow: ellipsis;
    }

    .card-body-rekap-okta{
        margin-top: -10px !important;
        padding-top: 0px !important;
        padding-bottom: 5px !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .sp_val_lbl{
        text-align: center !important;
        color: #4b4b4b;
        font-weight: bold;
        font-size: 2.3rem;
    }
</style>
<?php
    function getColorRating($rating){
        if($rating == 5){
            return "#096600";
        } else if($rating < 5 && $rating >= 4){
            return "#4cc501";
        } else if($rating < 4 && $rating >= 3){
            return "#fff700";
        } else if($rating < 3 && $rating >= 2){
            return "#d48f04";
        } else if($rating < 2 && $rating >= 1){
            return "#d42704";
        } else {
            return "#000000";
        }
    }
?>
<div class="row">
    <div class="col-lg-12 text-center">
        <div class="card card-default">
            <div class="card-body">
                <?php $colorRatingTotal = getColorRating(formatTwoMaxDecimal($result['data']['rating']['total'])) ?>
                <div class="row">
                    <div class="col-lg-12" style="line-height: 50px;">
                        <span class="sp_rating_lbl">RATING</span>
                        <br>
                        <span class="sp_rating_total" style="color: <?=$colorRatingTotal?>"><?=formatTwoMaxDecimal($result['data']['rating']['total'])?></span>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6" style="line-height: 30px;">
                        <?php $colorRatingKetepatan = getColorRating(formatTwoMaxDecimal($result['data']['rating']['ketepatan']['rerata'])) ?>
                        <span class="sp_rating_lbl">KETEPATAN</span>
                        <br>
                        <span class="sp_rating_sec" style="color: <?=$colorRatingKetepatan?>"><?=formatTwoMaxDecimal($result['data']['rating']['ketepatan']['rerata'])?></span>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6" style="line-height: 30px;">
                        <?php $colorRatingKecepatan = getColorRating(formatTwoMaxDecimal($result['data']['rating']['kecepatan']['rerata'])) ?>
                        <span class="sp_rating_lbl">KECEPATAN</span>
                        <br>
                        <span class="sp_rating_sec" style="color: <?=$colorRatingKecepatan?>"><?=formatTwoMaxDecimal($result['data']['rating']['kecepatan']['rerata'])?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card card-default">
            <div class="card-header card-header-rekap-okta text-center">
                <div class="card-title">
                    Total Konsultasi
                </div>
            </div>
            <div class="card-body card-body-rekap-okta text-center">
                <span class="sp_val_lbl"><?=($result['data']['rekap']['total'])?></span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-default">
            <div class="card-header card-header-rekap-okta text-center">
                <div class="card-title">
                    Selesai
                </div>
            </div>
            <div class="card-body card-body-rekap-okta text-center">
                <span class="sp_val_lbl"><?=($result['data']['rekap']['selesai']['total'])?></span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-default">
            <div class="card-header card-header-rekap-okta text-center">
                <div class="card-title">
                    Sudah Rating
                </div>
            </div>
            <div class="card-body card-body-rekap-okta text-center">
                <span class="sp_val_lbl"><?=($result['data']['rekap']['sudah_rating']['total'])?></span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-default">
            <div class="card-header card-header-rekap-okta text-center">
                <div class="card-title">
                    Belum Rating
                </div>
            </div>
            <div class="card-body card-body-rekap-okta text-center">
                <span class="sp_val_lbl"><?=($result['data']['rekap']['belum_rating']['total'])?></span>
            </div>
        </div>
    </div>
     <div class="col">
        <div class="card card-default">
            <div class="card-header card-header-rekap-okta text-center">
                <div class="card-title">
                    Aktif
                </div>
            </div>
            <div class="card-body card-body-rekap-okta text-center">
                <span class="sp_val_lbl"><?=($result['data']['rekap']['aktif']['total'])?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-rekap-okta">
                <div class="card-title text-left">
                    Jenis Layanan Konsul
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="chart chart-sm" style="width: 100%;">
                                <canvas id="chart_jenis_konsul"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <table>
                                <?php 
                                
                                $i = 0;
                                $colors = CHART_COLORS;
                                // $total_seluruh_pegawai = $this->session->userdata('total_seluruh_pegawai');
                                foreach($result['data']['rekap']['jenis_konsul'] as $rs){
                                $jumlah = isset($rs['jumlah']) ? $rs['jumlah'] : $rs['total'];
                                if($jumlah > 0){
                                    $presentase = formatCurrencyWithoutRpWithDecimal((($jumlah / $result['data']['rekap']['total']) * 100), 2);
                                ?>
                                <tr>
                                    <td colspan="2"><span style="background-color: <?=$colors[$i]?>">&nbsp;&nbsp;</span></td>
                                    <td colspan="2"><span style="font-size: .7rem;"><?=$rs['nama_layanan']?></span></td>
                                    <td colspan="2"><span style="font-size: .7rem;">:&nbsp;&nbsp;</span></td>
                                    <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=($presentase)."%"?></span></td>
                                    <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=" (".formatCurrencyWithoutRp($jumlah,0).")"?></span></td>
                                </tr>
                                <?php $i++; } } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header card-header-rekap-okta">
                <div class="card-title text-left">
                    Bidang
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="chart chart-sm" style="width: 100%;">
                                <canvas id="chart_bidang"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <table>
                                <?php 
                                
                                $i = 0;
                                $colors = CHART_COLORS;
                                // $total_seluruh_pegawai = $this->session->userdata('total_seluruh_pegawai');
                                foreach($result['data']['rekap']['list_bidang'] as $rs){
                                $jumlah = isset($rs['jumlah']) ? $rs['jumlah'] : $rs['total'];
                                if($jumlah > 0){
                                    $presentase = formatCurrencyWithoutRpWithDecimal((($jumlah / $result['data']['rekap']['total']) * 100), 2);
                                ?>
                                <tr>
                                    <td colspan="2"><span style="background-color: <?=$colors[$i]?>">&nbsp;&nbsp;</span></td>
                                    <td colspan="2"><span style="font-size: .7rem;"><?=$rs['nama_bidang']?></span></td>
                                    <td colspan="2"><span style="font-size: .7rem;">:&nbsp;&nbsp;</span></td>
                                    <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=($presentase)."%"?></span></td>
                                    <td colspan="1" class="text-right"><span style="font-size: .7rem; font-weight: bold;"><?=" (".formatCurrencyWithoutRp($jumlah,0).")"?></span></td>
                                </tr>
                                <?php $i++; } } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        renderChartJenisLayananKonsul('<?=json_encode($result['data']['rekap']['jenis_konsul'])?>')
        renderChartBidang('<?=json_encode($result['data']['rekap']['list_bidang'])?>')
    })

    function renderChartBidang(rs){
        let dt = JSON.parse(rs)
        let labels = [];
        let values = [];
        let temp = Object.keys(dt)
        temp.forEach(function(i) {
            if(dt[i].total > 0){
                labels.push(dt[i].nama_bidang)
                values.push(dt[i].total)
            }
        })

        let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
        new Chart(document.getElementById('chart_bidang'), {
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
    }

    function renderChartJenisLayananKonsul(rs){
        let dt = JSON.parse(rs)
        let labels = [];
        let values = [];
        let temp = Object.keys(dt)
        temp.forEach(function(i) {
            if(dt[i].total > 0){
                labels.push(dt[i].nama_layanan)
                values.push(dt[i].total)
            }
        })

        let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
        new Chart(document.getElementById('chart_jenis_konsul'), {
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
    }
</script>