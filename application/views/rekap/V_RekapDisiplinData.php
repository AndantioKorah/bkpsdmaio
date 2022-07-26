<?php $jumlah_hari = getJumlahHariDalamBulan($parameter['bulan'], $parameter['tahun']); ?>
<div class="row">
    <div class="col-12 text-center">
        <h5>Data dari <?=$from?></h5>
    </div>
</div>
<div class="col-12" style="max-width: 100%; overflow-y: scroll;">
    <?php if($result){ ?>
    <table class="table_rekap_disiplin table-hover" border=1 id="table_data_disiplin" style="width: 100%;">
        <thead class="table-header">
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Nama Pegawai</th>
            <th style="text-align: center;">NIP</th>
            <?php for($i = 1; $i <= $jumlah_hari; $i++) {
                $date = date('d-m-Y', strtotime($i.'-'.$parameter['bulan'].'-'.$parameter['tahun']));
                $hari = getNamaHari($date);
            ?>
                <th style="text-align: center;">
                    <span><?=$hari?></span><br>
                    <span><?=$i?></span>
                </th>
            <?php } ?>
            <th style="text-align: center;">Alpa</th>
            <th style="text-align: center;">TMK 1</th>
            <th style="text-align: center;">TMK 2</th>
            <th style="text-align: center;">TMK 3</th>
            <th style="text-align: center;">PKSW 1</th>
            <th style="text-align: center;">PKSW 2</th>
            <th style="text-align: center;">PKSW 3</th>
        </thead>
        <tbody style="overflow: scroll; max-height: 150px;">
        <?php $no=1; foreach($result as $rs){ ?>
            <tr>
                <td style="text-align: center;"><?=$no++;?></td> 
                <td><?=$rs['nama_pegawai']?></td>
                <td><?=$rs['nip']?></td>
                <?php
                    for($i = 1; $i <= $jumlah_hari; $i++){
                        if($i < 10){
                            $i = '0'.$i;
                        }
                ?>
                    <td style="text-align: center; width: 5% !important; vertical-align: middle;">
                        <?php 
                            $tanggal = $i.'-'.$parameter['bulan'].'-'.$parameter['tahun'];
                            $list_keterangan_disiplin = ['S', 'I', 'C', 'TL', 'DISP', 'TB'];
                            if(isset($rs['absensi'][$tanggal])){ 
                                $a = $rs['absensi'][$tanggal];
                                $fcmasuk = '#000000';
                                if(in_array($a['masuk']['data'], $list_keterangan_disiplin)){
                            ?>
                                <span style="color: <?=$fcmasuk?>;font-size: 14px;"><?=$a['masuk']['data']?></span>
                            <?php } else { 
                                if($a['masuk']['keterangan'] == 'tmk1'){
                                    $fcmasuk = '#d3b700';
                                } else if($a['masuk']['keterangan'] == 'tmk2'){
                                    $fcmasuk = '#d37c00';
                                } else if($a['masuk']['keterangan'] == 'tmk3'){
                                    $fcmasuk = '#ff0000';
                                }

                                $fcpulang = '#000000';
                                if($a['pulang']['keterangan'] == 'pksw1'){
                                    $fcpulang = '#d3b700';
                                } else if($a['pulang']['keterangan'] == 'pksw2'){
                                    $fcpulang = '#d37c00';
                                } else if($a['pulang']['keterangan'] == 'pksw3'){
                                    $fcpulang = '#ff0000';
                                }
                            ?>
                                <span style="color: <?=$fcmasuk?>;font-size: 14px;"><?=$a['masuk']['data']?></span>
                                <?php
                                    $jam_pulang = $a['pulang']['data'] ? ' - '.$a['pulang']['data'] : '';
                                ?>
                                <span style="color: <?=$fcpulang?>;font-size: 14px;"><?=$jam_pulang?></span>
                                <!-- <span style="font-size: 12px; color: red;"><?= $a['masuk']['keterangan'] ? json_encode($a['masuk']['keterangan']) : ''?></span><br>
                                <span style="font-size: 12px; color: blue;"><?= $a['pulang']['keterangan'] ? json_encode($a['pulang']['keterangan']) : ''?></span> -->
                        <?php } } else { ?>
                            <span style="font-size: 14px;">-</span>
                        <?php } ?>
                    </td>
                <?php } ?>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['tk']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['tmk1']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['tmk2']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['tmk3']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['pksw1']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['pksw2']?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(isset($rs['rekap_absensi'])){ ?>
                        <?=$rs['rekap_absensi']['pksw3']?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <script>
    
    </script>
    <?php } else { ?>
        <div class="text-center">
            <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
        </div>
    <?php } ?>
</div>