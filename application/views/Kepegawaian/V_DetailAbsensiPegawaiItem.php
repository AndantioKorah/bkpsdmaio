<style>
    .span_absen{
        padding: 0px;
        padding-right: 2px !important;
        border-radius: 3px;
        font-size: .5rem;
        margin-bottom: 3px;
        font-weight: bold;
    }

    .span_green{
        background-color: green;
        color: white;
    }

    .span_light_blue{
        background-color: #35e6ff;
        color: black;
        padding: 0px;
        padding-right: 2px !important;
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

    .span_libur{
        color: red;
        font-weight: bold;
        line-height: 9px;
    }

    .today_text{
        color: white !important;
        background-color: var(--primary-color);
        padding: 3px !important;
        border-radius: 15px !important;
        font-size: .6rem;
        font-weight: bold;
    }

    .today_div{
        margin-top: 5px;
    }
</style>
<?php
    
?>

<div style="width: 100%; height: 60px; padding: 0px;">
    <div class="col-12 <?=date('Y-m-d') == $dates ? 'today_div' : '' ?>"><span class="calendar_date <?=date('Y-m-d') == $dates ? 'today_text' : '' ?>"><?=$tanggal?></span></div>
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
    ?>
    <div class="col-12 text-right">
        <?php
            if($dokpen){ //cek jika ada dokumen pendukung
                if($dokpen['keterangan'] == 'Tugas Luar Pagi'){
        ?>  
                    <p class="span_absen span_light_blue"><?=$dokpen['keterangan']?></p>
                    <p class="span_absen <?=$span_pulang?>"><?=$text_pulang?></p>
                <?php } else if($dokpen['keterangan'] == 'Tugas Luar Sore') { ?>
                    <p class="span_absen <?=$span_masuk?>"><?=$text_masuk?></p>
                    <p class="span_absen span_light_blue"><?=$dokpen['keterangan']?></p>
                <?php } else {?>
            <p class="span_absen span_light_blue"><?=$dokpen['keterangan']?></p>
        <?php } } else { ?>
            <?php if(!$keterangan && !$hari_libur && $flag_tidak_print == 0){ //tidak ada pelanggaran absensi ?> 
                <p class="span_absen <?=$span_masuk?>"><?=$text_masuk?></p>
                <?php if(($dates != date('Y-m-d')) || ($text_pulang != '' && $text_pulang != '00:00')){ //cek jika bukan hari ini dan jam pulang sudah ada ?>
                    <p class="span_absen <?=$span_pulang?>"><?=$text_pulang?></p>
                <?php } ?>
            <?php } if($keterangan && !in_array('TK', $keterangan)){ //jika ada pelanggaran absensi dan bukan alpa ?>
                <p class="span_absen <?=$span_masuk?>"><?=$text_masuk?></p>
                <?php if(($text_pulang != '00:00' || $text_pulang != '')){ ?>
                    <p class="span_absen <?=$span_pulang?>"><?=$text_pulang?></p>
                <?php } ?>
            <?php } else if($keterangan && in_array('TK', $keterangan)) { //jika alpa ?>
                <p class="span_absen span_tk">Tidak Masuk Kerja</p>
            <?php } else if($hari_libur){ //jika hari libur ?>
                <p class="span_absen span_libur"><?=$hari_libur['keterangan']?></p>
            <?php } ?>
        <?php } ?>
    </div>
</div>