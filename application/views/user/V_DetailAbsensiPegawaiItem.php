<style>
    .span_absen{
        padding: 3px;
        border-radius: 3px;
        font-size: .7rem;
        font-weight: bold;
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

    .span_libur{
        color: red;
        font-weight: bold;
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
</style>
<?php
    
?>

<div style="width: 100%; height: 70px; padding: 3px;">
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
            } else if(in_array('pksw3', $keterangan) || $text_pulang == '00:00:00' || $text_pulang == ''){
                $span_pulang = 'span_pksw3';
                if($text_pulang == ''){
                    $text_pulang = '00:00:00';
                }
            }
        }
    ?>
    <div class="col-12 text-right">
        <?php
            if($dokpen){ //cek jika ada dokumen pendukung
                if($dokpen['keterangan'] == 'Tugas Luar Pagi'){
        ?>  
                    <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span><br>
                    <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                <?php } else if($dokpen['keterangan'] == 'Tugas Luar Sore') { ?>
                    <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                    <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span>
                <?php } else {?>
            <span class="span_absen span_light_blue"><?=$dokpen['keterangan']?></span>
        <?php } } else { ?>
            <?php if(!$keterangan && !$hari_libur && $flag_tidak_print == 0){ //tidak ada pelanggaran absensi ?> 
                <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                <?php if(($dates != date('Y-m-d')) || ($text_pulang != '' && $text_pulang != '00:00:00')){ //cek jika bukan hari ini dan jam pulang sudah ada ?>
                    <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                <?php } ?>
            <?php } if($keterangan && !in_array('TK', $keterangan)){ //jika ada pelanggaran absensi dan bukan alpa ?>
                <span class="span_absen <?=$span_masuk?>"><?=$text_masuk?></span><br>
                <?php if(($text_pulang != '00:00:00' || $text_pulang != '')){ ?>
                    <span class="span_absen <?=$span_pulang?>"><?=$text_pulang?></span>
                <?php } ?>
            <?php } else if($keterangan && in_array('TK', $keterangan)) { //jika alpa ?>
                <span class="span_absen span_tk">Alpa</span>
            <?php } else if($hari_libur){ //jika hari libur ?>
                <span class="span_absen span_libur"><?=$hari_libur['keterangan']?></span>
            <?php } ?>
        <?php } ?>
    </div>
</div>