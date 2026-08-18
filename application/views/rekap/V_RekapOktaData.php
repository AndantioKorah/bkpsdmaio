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
                        <?php
                            $jenis_konsul['result'] = $result['data']['rekap']['jenis_konsul'];
                            $jenis_konsul['id_chart'] = 'jenis_layanan_konsul';
                            $jenis_konsul['nama_label'] = 'nama_layanan';
                            $jenis_konsul['total_seluruh_pegawai'] = $result['data']['rekap']['total'];
                            $this->load->view('login/V_ChartPieDashboardRekapOkta', $jenis_konsul);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>