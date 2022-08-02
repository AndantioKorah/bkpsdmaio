<html>
    <head>
        <style>
            body{
                font-family: Tahoma;
            }
            
            .normal{
                color: black;
                text-align: center;
            }

            .tr_odd{
                /* background-color: #dfdfdf; */
                background-color: #f1f1f1;
            }

            table{
                /* font-size: 14px; */
            }

            .content{
                font-size: 13px;
                text-align: center;
            }
        </style>
    <head>
    <?php
        if($flag_print == 1){
            $filename = $nama_file;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=$filename"); 
        }
    ?>
    <body>
        <div style="width: 100%;">
            <center>
            <h5 style="font-size: 20px;">
                REKAP ABSENSI <?=strtoupper($skpd)?><br>
                <?=strtoupper($periode)?>
            </h5>
            <?php if($flag_print == 0){ ?>
                <form target="blank" action="<?=base_url('rekap/C_Rekap/downloadAbsensi')?>">
                    <button class="btn btn-sm btn-navy" type="submit"><i class="fa fa-download"></i> Download as Excel</button>
                </form>
                <span style="font-size: 14px; font-weight: bold;">Jadwal Jam Kerja <?=$jam_kerja['nama_jam_kerja']?></span>
                <table style="width: 50%; margin-bottom: 10px;" border=1>
                    <thead>
                        <th style="text-align: center; font-size: 14px;">Hari</th>
                        <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                        <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                            <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfo_pulang']?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Jumat</td>
                            <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$jam_kerja['wfoj_pulang']?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
            </center>
            <table border=1 style="width: 100%;">
                <thead>
                    <?php $i=0; foreach($header[0] as $h){
                        $val = $h;
                        $rowspan = 1;
                        if($i !=0 || $i != 1){
                            $val = $val.'<br>'.$header[1][$i];
                        }
                    ?>
                        <th style="text-align: center; font-size: 13px;"><?=$val?></th>
                    <?php $i++; } ?>
                    <th style="text-align: center; font-size: 13px;">TMK 1</th>
                    <th style="text-align: center; font-size: 13px;">TMK 2</th>
                    <th style="text-align: center; font-size: 13px;">TMK 3</th>
                    <th style="text-align: center; font-size: 13px;">PKSW 1</th>
                    <th style="text-align: center; font-size: 13px;">PKSW 2</th>
                    <th style="text-align: center; font-size: 13px;">PKSW 3</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ 
                    $bgtr = fmod($no, 2) == 0 ? "tr_even" : "tr_odd";
                    ?>
                        <tr class="<?=$bgtr?>">
                            <td style="text-align: center; font-size: 12px;"><?=$no++;?></td>
                            <td style="width: 300px; font-size: 12px;"><a><?=$rs['nama_pegawai']?></a></td>
                            <?php
                            
                            $tmk1 = 0;
                            $tmk2 = 0;
                            $tmk3 = 0;
                            $pksw1 = 0;
                            $pksw2 = 0;
                            $pksw3 = 0;

                            foreach($rs['absen'] as $a){
                                $bgcolor = '';
                                $textcolor = 'black';
                                $txtcolormasuk = 'black';
                                $txtcolorpulang = 'black';

                                if($a['ket'] == "A"){
                                    // $bgcolor = 'a3f0ec';
                                    $textcolor = '#05ada5';
                                } else if($a['ket_masuk'] == 'tmk1'){
                                    $tmk1++;
                                    $txtcolormasuk = '#d3b700';
                                } else if($a['ket_masuk'] == 'tmk2'){
                                    $tmk2++;
                                    $txtcolormasuk = '#d37c00';
                                } else if($a['ket_masuk'] == 'tmk3'){
                                    $tmk3++;
                                    $txtcolormasuk = '#ff0000';
                                }

                                if($a['ket_pulang'] == 'pksw1'){
                                    $pksw1++;
                                    $txtcolorpulang = '#d3b700';
                                } else if($a['ket_pulang'] == 'pksw2'){
                                    $pksw2++;
                                    $txtcolorpulang = '#d37c00';
                                } else if($a['ket_pulang'] == 'pksw3'){
                                    $pksw3++;
                                    $txtcolorpulang = '#ff0000';
                                }
                            ?>
                            <td class="content" bgcolor="<?=$bgcolor?>">
                                <?php if($a['ket'] == "A"){ ?>
                                    <span style="color: <?=$textcolor?>;"><?=$a['ket']?></span>
                                <?php } else { ?>
                                    <span style="color: <?=$txtcolormasuk?>"><?=$a['jam_masuk']?></span> - <span style="color: <?=$txtcolorpulang?>"><?=$a['jam_pulang']?></span>
                                <?php } ?>
                            </td>
                            <?php } ?>
                            <td style="font-size: 13px; text-align: center; color: <?= $tmk1 > 0 ? '#d3b700;' : '#efefef;' ?> font-weight: bold;"><?=$tmk1?></td>
                            <td style="font-size: 13px; text-align: center; color: <?= $tmk2 > 0 ? '#d37c00;' : '#efefef;' ?> font-weight: bold;"><?=$tmk2?></td>
                            <td style="font-size: 13px; text-align: center; color: <?= $tmk3 > 0 ? '#ff0000;' : '#efefef;' ?> font-weight: bold;"><?=$tmk3?></td>
                            <td style="font-size: 13px; text-align: center; color: <?= $pksw1 > 0 ? '#d3b700;' : '#efefef;' ?> font-weight: bold;"><?=$pksw1?></td>
                            <td style="font-size: 13px; text-align: center; color: <?= $pksw2 > 0 ? '#d37c00;' : '#efefef;' ?> font-weight: bold;"><?=$pksw2?></td>
                            <td style="font-size: 13px; text-align: center; color: <?= $pksw3 > 0 ? '#ff0000;' : '#efefef;' ?> font-weight: bold;"><?=$pksw3?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <span style="font-size: 12px;">printed by: </span><span style="font-size: 12px; font-weight: bold;"><?=$this->general_library->getNamaUser()?></span>
            <br>
            <span style="font-size: 12px;">date: </span><span style="font-size: 12px; font-weight: bold;"><?=date('d/m/Y H:i:s')?></span>
        </div>
    </body>
</html>