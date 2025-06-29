<style>
    .span_absen{
        padding: 3px;
        border-radius: 3px;
        font-size: .7rem;
        font-weight: bold;
        /* position: relative;
        top: 20%; */
    }

    .span_green{
        background-color: green;
        color: white;
    }

    .span_light_blue{
        background-color: #35e6ff;
        color: black;
        padding: 5px;
    }

    .span_tmk1{
        background-color: #f4fc07;
        color: black;
    }

    .span_tmk2{
        background-color: #f1a702;
        color: black;
    }

    .span_tmk3{
        background-color: #f10202;
        color: white;
    }

    .span_pksw1{
        background-color: #f4fc07;
        color: black;
    }

    .span_pksw2{
        background-color: #f1a702;
        color: black;
    }

    .span_pksw3{
        background-color: #f10202;
        color: white;
    }

    .span_tk{
        /* background-color: black; */
        color: red;
        font-weight: bold;
    }

    .span_invalid{
        color: white;
        font-weight: bold;
        background-color:rgb(184, 0, 221);
    }

    .text_invalid{
        font-weight: bold;
        color:rgb(184, 0, 221);
        font-size: .75rem;
    }

    .span_libur{
        color: red;
        font-weight: bold;
        display: inline-block;
        line-height: 1rem;
    }

    .today_text{
        color: white !important;
        background-color: var(--primary-color);
        padding: 5px !important;
        border-radius: 15px !important;
        font-size: .7rem;
        font-weight: bold;
    }

    .today_div{
        margin-top: 5px;
    }

    .col-date-calendar{
        padding: 0px;
        margin-bottom: -10px;
    }
</style>
<?php
    
?>

<div style="width: 100%; height: 70px; padding: 3px;">
    <div class="col-12 col-date-calendar <?=date('Y-m-d') == $dates ? 'today_div' : '' ?>"><span class="calendar_date <?=date('Y-m-d') == $dates ? 'today_text' : '' ?>"><?=$tanggal?></span></div>
    <?php
        $span_masuk = 'span_green';
        $span_pulang = 'span_green';
        if($keterangan){
            if(in_array('tmk1', $keterangan)){
                $span_masuk = 'span_tmk1';
            } else if(in_array('tmk2', $keterangan)){
                $span_masuk = 'span_tmk2';
            } else if(in_array('tmk3', $keterangan)){
                $span_masuk = 'span_tmk3';
            }

            if(in_array('pksw1', $keterangan)){
                $span_pulang = 'span_pksw1';
            } else if(in_array('pksw2', $keterangan)){
                $span_pulang = 'span_pksw2';
            } else if(in_array('pksw3', $keterangan) || $text_pulang == '00:00' || $text_pulang == ''){
                $span_pulang = 'span_pksw3';
                if($text_pulang == ''){
                    $text_pulang = '00:00';
                }
            }
        }

        if(in_array($status_invalid, [4,5,6])){
            if($status_invalid == 4){
                $span_masuk = 'span_invalid';
            } else if($status_invalid == 5){
                $span_pulang = 'span_invalid';
            } else {
                $span_masuk = 'span_invalid';
                $span_pulang = 'span_invalid';
            }
        }
    ?>
    <div style="position: relative;
            height: 55px;
            display: table-cell;
            vertical-align: middle;
            width: 100vw;" class="col-12 text-right">
        <?php if($dates > $dataPegawai['tmt_hitung_absen']){ ?>
            <?php if(in_array($status_invalid, [4,5,6])){ ?>
                <div class="row">
                    <div class="col-lg-6 text-left mt-2" style="line-height: 15px;">
                        <h6 class="span_absen text_invalid p-1"><?=trim($alasan_invalid)?></h6>
                    </div>
                    <div class="col-lg-6">
                        <span title="<?=$alasan_invalid?>" class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                        <span title="<?=$alasan_invalid?>" class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                    </div>
                </div>
            <?php
                } else if($dokpen && $flag_tidak_print == 0){ //cek jika ada dokumen pendukung 
                    if($dokpen['keterangan'] == 'Tugas Luar Pagi'){
            ?>  
                        <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span><br>
                        <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                    <?php } else if($dokpen['keterangan'] == 'Tugas Luar Sore') { ?>
                        <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                        <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span>
                    <?php } else if($dokpen['id_m_jenis_disiplin_kerja'] == 4 ||
                                    $dokpen['id_m_jenis_disiplin_kerja'] == 5 ||
                                    $dokpen['id_m_jenis_disiplin_kerja'] == 6) {
                        // jika MTTI, SIDAK atau Kenegaraan
                    ?>
                        <div class="row">
                            <div class="col-lg-6 text-left mt-2">
                                <span class="span_absen span_light_blue"><?=$dokpen['kode_dokpen']?></span>
                            </div>
                            <div class="col-lg-6">
                                <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                                <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                            </div>
                        </div>
                    <?php } else { ?>
                <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span>
            <?php } } else { ?>
                <?php if(!$keterangan && !$hari_libur && $flag_tidak_print == 0){ //tidak ada pelanggaran absensi ?> 
                    <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                    <?php if(($dates != date('Y-m-d')) || ($text_pulang != '' && $text_pulang != '00:00')){ //cek jika bukan hari ini dan jam pulang sudah ada ?>
                        <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                    <?php } ?>
                <?php } if($keterangan && !in_array('TK', $keterangan)){ //jika ada pelanggaran absensi dan bukan alpa ?>
                    <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                    <?php if(($text_pulang != '00:00' || $text_pulang != '')){ ?>
                        <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                    <?php } ?>
                <?php } else if($keterangan && in_array('TK', $keterangan)) { //jika alpa ?>
                    <span class="span_absen span_tk">Tidak Masuk Kerja</span>
                <?php } ?>
            <?php } ?>
        <?php } if($hari_libur){ ?>
            <span class="span_absen span_libur"><?=$hari_libur['keterangan']?></span>
        <?php } ?>
    </div>
</div>