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
                    <center><h5><strong>REKAPITULASI PRESENTASE CAPAIAN TPP</strong></h5></center>
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
                                <th style="text-align: center; " rowspan="1">No</th>
                                <th style="text-align: center;  z-index: 400;" rowspan="1">Nama Pegawai</td>
                                <th style="text-align: center;"  rowspan="1">% PENILAIAN SASARAN KERJA BULANAN PEGAWAI</td>
                                <th style="text-align: center;"  rowspan="1">% PENILAIAN KOMPONEN KINERJA</td>
                                <th style="text-align: center;"  rowspan="1">% CAPAIAN PRODUKTIFITAS KERJA</td>
                                <th style="text-align: center;"  rowspan="1">% CAPAIAN PENILAIAN DISIPLIN KERJA</td>
                                <th style="text-align: center; " rowspan="1">% TOTAL PENILAIAN TPP</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($result['result'] as $rs){
                                $nilai_komponen_kinerja = isset($rs['komponen_kinerja'][1]) ? $rs['komponen_kinerja'][1] : 0;
                                $capaian_produktivitas_kerja = floatval($rs['kinerja']['rekap_kinerja']['bobot']) + floatval($nilai_komponen_kinerja);
                                $total_penilaian_tpp = $capaian_produktivitas_kerja + floatval($rs['rekap']['capaian_bobot_disiplin_kerja']);
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?=$no++;?></td>
                                    <td style="width: 15%; padding-top: 5px; padding: 5px;">
                                        <span style=""><?=$rs['nama_pegawai']?></span><br>
                                        <span style="">NIP. <?=$rs['nip']?></span>
                                    </td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['bobot']).'%'?></td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($nilai_komponen_kinerja).'%'?></td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($capaian_produktivitas_kerja).'%'?></td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($rs['rekap']['capaian_bobot_disiplin_kerja']).'%'?></td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($total_penilaian_tpp).'%'?></td>
                                </tr>
                            <?php } ?>
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