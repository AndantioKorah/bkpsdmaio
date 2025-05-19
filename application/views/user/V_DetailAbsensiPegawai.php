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
        border: 1px solid grey !important;
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

    .td_edit{
        cursor: pointer;
    }

    .td_edit:hover{
        background-color: #e6e6e6 !important;
        transition: .2s;
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
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($result['jam_kerja']['wfo_masuk'])?></td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($result['jam_kerja']['wfo_pulang'])?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Jumat</td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($result['jam_kerja']['wfoj_masuk'])?></td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($result['jam_kerja']['wfoj_pulang'])?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($result['list_jam_kerja_event'])) { foreach($result['list_jam_kerja_event'] as $jke){ ?>
        <div class="col">
            <div class="card card-default p-3">
                <span style="font-size: 1rem;" class="text-center">JAM KERJA <?=strtoupper($jke['nama_jam_kerja'])?></span>
                <span style="font-size: .8rem;" class="text-center">
                    <?=formatDateNamaBulan($jke['berlaku_dari'])?> - 
                    <?=formatDateNamaBulan($jke['berlaku_sampai'])?>
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
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfo_masuk'])?></td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfo_pulang'])?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; text-align: center;">Jumat</td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfoj_masuk'])?></td>
                            <td style="text-align: center; font-size: 14px;"><?=formatTimeAbsen($jke['wfoj_pulang'])?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } } ?>
</div>
<div class="card card-default p-3 table-responsive">
    <div class="text-center">
        <h4>PRESENSI BULAN <?=strtoupper(getNamaBulan($result['param']['bulan']))?> TAHUN <?=$result['param']['tahun']?></h4>
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
                $pointer = $pointer == 0 ? 7 : $pointer;
                if(count($result['list_hari']) >= 30){
                    if($pointer == 7){
                        $row = 6;
                    } else if ($pointer == 6 && count($result['list_hari']) > 30){
                        $row = 6;
                    }
                }
                $pointer_hari = 0;
                $tanggal = $pointer_hari + 1;
                $temp['dataPegawai'] = $result['dataPegawai'];
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

                        if($flag_tidak_print == 0 && $j == $pointer && !isset($result['hari_libur'][$dates])){
                            if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('edit_presensi')){
                                $class_td = "td_edit";
                            }
                        }
                        if(($this->general_library->isProgrammer() || $this->general_library->isHakAkses('edit_presensi')) && $class_td == "td_edit"){
                                echo '<td data-toggle="modal" data-target="#edit_data_presensi" data-dates="'.$dates.'"
                                onclick=openEditModal("'.$dates.'") class="'.$class_td.'" >';
                        } else {
                            echo '<td class="'.$class_td.'" >';
                        }
                            if($j == $pointer){
                                if(isset($result['list_hari'][$pointer_hari])){
                                    $text_masuk = '';
                                    $text_pulang = '';
                                    $alasan_invalid = '';
                                    $status_invalid = 0;
                                    
                                    if(isset($result['data_absen'][$dates])){
                                        $text_masuk = $result['data_absen'][$dates]['masuk'];
                                        $text_pulang = $result['data_absen'][$dates]['pulang'];
                                        $alasan_invalid = isset($result['data_absen'][$dates]['alasan']) ? $result['data_absen'][$dates]['alasan'] : "";
                                        $status_invalid = isset($result['data_absen'][$dates]['status']) ? $result['data_absen'][$dates]['status'] : "";
                                    }
                                    
                                    $temp['text_masuk'] = formatTimeAbsen($text_masuk);
                                    $temp['text_pulang'] = formatTimeAbsen($text_pulang);
                                    $temp['tanggal'] = $tanggal;
                                    $temp['dates'] = $dates;
                                    $temp['alasan_invalid'] = $alasan_invalid;
                                    $temp['status_invalid'] = $status_invalid;
                                    $temp['keterangan'] = isset($result['data_absen']['keterangan'][$dates]) ? $result['data_absen']['keterangan'][$dates] : null;
                                    $temp['hari_libur'] = isset($result['hari_libur'][$dates]) ? $result['hari_libur'][$dates] : null;
                                    $temp['flag_tidak_print'] = $flag_tidak_print;
                                    $temp['dokpen'] = null;
                                    
                                    if(in_array($status_invalid, [4,5,6])){
                                        if($status_invalid == 4){
                                            $temp['text_masuk'] = "INVALID"; 
                                        } else if($status_invalid == 5){
                                            $temp['text_pulang'] = "INVALID"; 
                                        } else {
                                            $temp['text_masuk'] = "INVALID"; 
                                            $temp['text_pulang'] = "INVALID"; 
                                        }
                                    }

                                    if(isset($result['dokpen'][$dates])){
                                        $temp['dokpen'] = $result['dokpen'][$dates];
                                    }
                                    // if($this->general_library->getUserName() == '196705151994031003'){
                                        
                                    // }
                                    // $temp['keterangan'] = $result['data_absen']['keterangan'][$dates];

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

<script>
    function openEditModal(dates){
        // alert(dates)
        // $('.td_edit').on('click', function(){
            // dates = $(this).data('dates');
            $('#edit_data_presensi_content').html('')
            $('#edit_data_presensi_content').append(divLoaderNavy)
            $('#edit_data_presensi_content').load('<?=base_url('user/C_User/editDataPresensi/'.$nip.'/')?>'+dates, function(){
                $('#loader').hide()
            })
        // })
    }
</script>