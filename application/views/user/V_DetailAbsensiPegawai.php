<style>
    .table_calendar, .table_calendar th, .table_calendar td{
        border: 1px solid var(--primary-color) !important;
    }

    .table-jam-kerja, .table-jam-kerja th, .table-jam-kerja td{
        border: 1px solid var(--primary-color) !important;
    }
    
    .table_calendar thead{
        font-size: .9rem;
        text-align: center;
        background-color: var(--primary-color);
        color: white;
        font-weight: bold;
    }

    .calendar_date{
        font-size: .7rem;
        font-weight: bold;
        color: #9d9b9b;
    }

    .td_hari_libur{
        background-color: #f9050517;
    }

    .td_sabtu_minggu{
        background-color: #f9050517;
    }
    
    .td_sabtu_minggu span{
        color: red !important;
    }

    .td_hari_libur span{
        color: red !important;
    }

    .table_calendar td{
        max-width: 70px !important;
        min-width: 70px !important;
    }

</style>

<div class="row">
    <?php if($result['jam_kerja']){ ?>
        <div class="col">
            <div class="card card-default p-3">
                <span style="font-size: 1rem;" class="text-center">JAM KERJA <?=strtoupper($result['jam_kerja']['nama_jam_kerja'])?></span>
                <span style="font-size: .8rem; color: white;" class="text-center">s</span>
                <table class="table-jam-kerja">
                    <thead>
                        <th style="text-align: center; font-size: 14px;">Hari</th>
                        <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                        <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja']['wfo_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja']['wfo_pulang']?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Jumat</td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja']['wfoj_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja']['wfoj_pulang']?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if($result['jam_kerja_event']){ ?>
        <div class="col">
            <div class="card card-default p-3">
                <span style="font-size: 1rem;" class="text-center">JAM KERJA <?=strtoupper($result['jam_kerja_event'][0]['nama_jam_kerja'])?></span>
                <span style="font-size: .8rem;" class="text-center">
                    <?=formatDateNamaBulan($result['jam_kerja_event'][0]['berlaku_dari'])?> - 
                    <?=formatDateNamaBulan($result['jam_kerja_event'][0]['berlaku_sampai'])?>
                </span>
                <table class="table-jam-kerja">
                    <thead>
                        <th style="text-align: center; font-size: 14px;">Hari</th>
                        <th style="text-align: center; font-size: 14px;">Jam Masuk</th>
                        <th style="text-align: center; font-size: 14px;">Jam Pulang</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Senin - Kamis</td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja_event'][0]['wfo_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja_event'][0]['wfo_pulang']?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Jumat</td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja_event'][0]['wfoj_masuk']?></td>
                            <td style="text-align: center; font-size: 14px;"><?=$result['jam_kerja_event'][0]['wfoj_pulang']?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>
<div class="card card-default p-3 table-responsive">
    <div class="text-center">
        <h4>REKAP ABSENSI BULAN <?=strtoupper(getNamaBulan($result['param']['bulan']))?> TAHUN <?=$result['param']['tahun']?></h4>
    </div>
    <table class="table_calendar">
        <thead>
            <th>Senin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Kamis</th>
            <th>Jumat</th>
            <th>Sabtu</th>
            <th>Minggu</th>
        </thead>
        <tbody>
            <?php
                $pointer = date('w', strtotime($result['list_hari'][0]));
                $col = 7;
                $row = 5;
                if(count($result['list_hari']) >= 30){
                    if($pointer == 7){
                        $row = 6;
                    } else if ($pointer == 6 && count($result['list_hari']) > 30){
                        $row = 6;
                    }
                }
                $pointer_hari = 0;
                $tanggal = $pointer_hari + 1;
                for($i = 1; $i <= $row; $i++){
                    echo "<tr>";
                    for($j = 1; $j <= $col; $j++){
                        $class_td = '';
                        $date_tanggal = $tanggal;
                        $flag_tidak_print = 0;
                        if($tanggal < 10){
                            $date_tanggal = '0'.$date_tanggal;
                        }
                        $dates = $result['param']['tahun'].'-'.$result['param']['bulan'].'-'.$date_tanggal;

                        if($dates > date('Y-m-d')){
                            $flag_tidak_print = 1;
                        }

                        if(($pointer == 6 || $pointer == 7) && $tanggal <= count($result['list_hari'])){
                            $flag_tidak_print = 1;
                            $class_td = 'td_sabtu_minggu';    
                        }
                        
                        if(isset($result['hari_libur'][$dates]) && $class_td == ''){
                            $class_td = 'td_hari_libur';
                        }
                        if($pointer > $j){
                            $class_td = '';
                        }
                        echo "<td class='".$class_td."'>";
                            if($j == $pointer){
                                if(isset($result['list_hari'][$pointer_hari])){
                                    $text_masuk = '';
                                    $text_pulang = '';
                                    
                                    if(isset($result['data_absen'][$dates])){
                                        $text_masuk = $result['data_absen'][$dates]['masuk'];
                                        $text_pulang = $result['data_absen'][$dates]['pulang'];
                                    }
                                    
                                    $temp['text_masuk'] = $text_masuk;
                                    $temp['text_pulang'] = $text_pulang;
                                    $temp['tanggal'] = $tanggal;
                                    $temp['dates'] = $dates;
                                    $temp['keterangan'] = $result['data_absen']['keterangan'][$dates];
                                    $temp['hari_libur'] = isset($result['hari_libur'][$dates]) ? $result['hari_libur'][$dates] : null;
                                    $temp['flag_tidak_print'] = $flag_tidak_print;
                                    $temp['dokpen'] = null;
                                    if(isset($result['dokpen'][$dates])){
                                        $temp['dokpen'] = $result['dokpen'][$dates];
                                    }
                                    $temp['keterangan'] = $result['data_absen']['keterangan'][$dates];

                                    $this->load->view('user/V_DetailAbsensiPegawaiItem', $temp);
                                    
                                    $tanggal++;
                                    $pointer_hari++;
                                    $pointer++;
                                }
                            }
                        echo "</td>";
                    }
                    $pointer = 1;
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>