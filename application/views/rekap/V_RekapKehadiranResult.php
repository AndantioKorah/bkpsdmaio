<?php if(isset($skpd)){
    // $skpd = explode(";", $skpd);
    // if($flag_print == 1){
    //     $filename = 'REKAPITULASI PENILAIAN DISIPLIN KERJA '.$skpd[1].' Periode '.getNamaBulan($bulan).' '.$tahun.'.xls';
    //     header("Content-type: application/vnd-ms-excel");
    //     header("Content-Disposition: attachment; filename=$filename");
    // }
?>
        <div class="col-lg-12" style="width: 100%;">
            <form action="<?=base_url('rekap/C_Rekap/rekapPenilaianSearch/1')?>" method="post" target="_blank">
                <?php if(isset($use_header) && $use_header == 1){ ?>
                    <center><h5><strong>REKAPITULASI KEHADIRAN PEGAWAI</strong></h5></center>
                <?php } ?>
                <br>
                <?php if(isset($flag_print) && $flag_print == 0){ ?>
                    <button style="display: none;" type="submit" class="text-right float-right btn btn-navy btn-sm"><i class="fa fa-download"></i> Simpan sebagai Excel</button>
                <?php } ?>
                <?php if(isset($use_header) && $use_header == 1){ ?>
                    <table style="width: 100%; position: relative;">
                        <tr>
                            <td>SKPD</td>
                            <td>:</td>
                            <td><?=$skpd[0]?></td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>:</td>
                            <td><?=getNamaBulan($bulan).' '.$tahun?></td>
                        </tr>
                    </table>
                <?php } ?>
                <div>
                <input type="text" class="cd-search table-filter" data-table="rekap-table" placeholder="Cari Pegawai" />
                <div class="div_maintb">
                    <table class="cd-table rekap-table table" style="width: 2000px; margin-top : -10px" border="1" id="table_rekap_penilaianx">
                        <thead>
                            <tr >
                                <th style="text-align: center; " rowspan="2">No</th>
                                <th style="text-align: center;  z-index: 400;" rowspan="2">Nama Pegawai</td>
                                <th style="text-align: center;"  rowspan="2">Gol/Ruang</td>
                                <th style="text-align: center;"  rowspan="2">Jabatan</td>
                                <th style="text-align: center;"  rowspan="2">Ess</td>
                                <th style="text-align: center;"  rowspan="2">Kelas Jabatan</td>
                                <th style="text-align: center; " rowspan="2">JHK</td>
                                <th style="text-align: center; " rowspan="2">TARGET CAP. PEN. DISIPLIN KERJA</th>
                                <th style="text-align: center; " rowspan="1" colspan="<?=count($mdisker)?>">Keterangan</th>
                                <th style="text-align: center; " rowspan="2">% H</td>
                                <!-- <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN PENILAIAN DISIPLIN KERJA</th> -->
                            </tr>
                            <tr >
                                <?php foreach($mdisker as $m){ ?>
                                    <th style="text-align: center; " rowspan="1" colspan="1"><?=STRTOUPPER($m['keterangan'])?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $total_presentase_kehadiran = 0;
                                foreach($result as $rs){
                                $capaian = 0;
                                $capaian_bobot = 0;
                                $presentase_hadir = (floatval($rs['rekap']['hadir']) / floatval($rs['rekap']['jhk'])) * 100;
                                $total_presentase_kehadiran += $presentase_hadir;
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?=$no++;?></td>
                                    <td style="padding-top: 5px; padding: 5px;">
                                        <span style="font-size: 14px; font-weight: bold;"><?=$rs['nama_pegawai']?></span><br>
                                        <span style="">NIP. <?=$rs['nip']?></span>
                                    </td>
                                    <td style="width: 6%; text-align: center;"><?=$rs['golongan']?></td>
                                    <td style="width: 6%; text-align: center;"><?=$rs['nama_jabatan']?></td>
                                    <td style="width: 6%; text-align: center;"><?=$rs['eselon']?></td>
                                    <td style="width: 6%; text-align: center;"><?=$rs['kelas_jabatan']?></td>
                                    <td style="width: 6%; text-align: center;"><?=$rs['rekap']['jhk']?></td>
                                    <td style="width: 6%; text-align: center;"><?=TARGET_PENILAIAN_DISIPLIN_KERJA.'%'?></td>
                                    <?php $temp_capaian = 0; foreach($mdisker as $md){
                                        $color = '000000';
                                        if($rs['rekap'][$md['keterangan']]['total'] == 0){
                                            $color = '#dfe2e5';
                                        }
                                    ?>
                                        <td style="text-align: center; color: <?=$color?>" rowspan="1" colspan="1"><?=$rs['rekap'][$md['keterangan']]['total']?></td>
                                    <?php } ?>
                                    <td style="text-align: center;"><?=$presentase_hadir.'%'?></td>
                                </tr>
                            <?php }
                                $total_presentase_kehadiran = $total_presentase_kehadiran / count($result);
                            ?>
                            <tr>
                                <td style="text-align: left;" colspan="26"><strong>RATA-RATA PRESENTASE KEHADIRAN</strong></td>
                                <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($total_presentase_kehadiran).' %'?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </form>
        </div>
<?php } else { ?>
    <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
<?php } ?>
<script>
     $(function(){
    fixedHeaderTable()
    })
</script>