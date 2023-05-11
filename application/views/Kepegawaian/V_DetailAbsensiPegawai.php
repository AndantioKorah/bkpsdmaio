<style>
    .table_calendar, .table_calendar th, .table_calendar td{
        border: 1px solid var(--primary-color) !important;
    }

    .table-jam-kerja, .table-jam-kerja th, .table-jam-kerja td{
        /* border: 1px solid var(--primary-color) !important; */
    }
    
    .table_calendar thead{
        font-size: .7rem;
        text-align: center;
        background-color: var(--primary-color);
        color: white;
        font-weight: bold;
    }

    .calendar_date{
        font-size: .6rem;
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
        max-width: 50px !important;
        min-width: 50px !important;
    }

</style>

<div class="row">
    <?php if($result['jam_kerja']){ ?>
        <div class="col">
            <div class="card card-default p-2">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p style="font-size: .7rem; font-weight: bold; margin-bottom: 0px;" class="text-center">JAM KERJA <?=strtoupper($result['jam_kerja']['nama_jam_kerja'])?></p>
                        <p style="font-size: .6rem; margin-bottom: 0px; font-weight: bold;">(sekarang)</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px;">Senin - Kamis</p>
                            </div>
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px; font-weight: bold;">
                                    <?=formatTimeAbsen($result['jam_kerja']['wfo_masuk']).' - '.formatTimeAbsen($result['jam_kerja']['wfo_masuk'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px;">Jumat</p>
                            </div>
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px; font-weight: bold;">
                                    <?=formatTimeAbsen($result['jam_kerja']['wfoj_masuk']).' - '.formatTimeAbsen($result['jam_kerja']['wfoj_masuk'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($result['list_jam_kerja_event'])) { foreach($result['list_jam_kerja_event'] as $jke){ ?>
        <div class="col">
            <div class="card card-default p-2">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p style="font-size: .7rem; font-weight: bold; margin-bottom: 0px;" class="text-center">JAM KERJA <?=strtoupper($jke['nama_jam_kerja'])?></p>
                        <p style="font-size: .6rem; margin-bottom: 0px;"><?=formatDateNamaBulan($jke['berlaku_dari']).' - '.formatDateNamaBulan($jke['berlaku_sampai'])?></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px;">Senin - Kamis</p>
                            </div>
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px; font-weight: bold;">
                                    <?=formatTimeAbsen($jke['wfo_masuk']).' - '.formatTimeAbsen($jke['wfo_masuk'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px;">Jumat</p>
                            </div>
                            <div class="col-lg-12 text-center">
                                <p style="font-size: .6rem; margin-bottom: 0px; font-weight: bold;">
                                    <?=formatTimeAbsen($jke['wfoj_masuk']).' - '.formatTimeAbsen($jke['wfoj_masuk'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } } ?>
</div>
<div class="card card-default p-2 table-responsive">
                

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
                                    
                                    $temp['text_masuk'] = formatTimeAbsen($text_masuk);
                                    $temp['text_pulang'] = formatTimeAbsen($text_pulang);
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

                                    $this->load->view('kepegawaian/V_DetailAbsensiPegawaiItem', $temp);
                                    
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