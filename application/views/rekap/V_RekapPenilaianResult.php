
<?php if($result){
    $skpd = explode(";",$parameter['skpd']);
    if($flag_print == 1){
        $filename = 'REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA '.$skpd[1].' Periode '.getNamaBulan($parameter['bulan']).' '.$parameter['tahun'].'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
    }
?>
        <div class="col-lg-12" style="width: 100%;">
            <form action="<?=base_url('rekap/C_Rekap/rekapPenilaianSearch/1')?>" method="post" target="_blank">
                <?php if(isset($use_header) && $use_header == 1){ ?>
                    <center><h5><strong>REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA</strong></h5></center>
                <?php } ?>
                <br>
                <?php if($flag_print == 1){ ?>
                    <button type="submit" class="text-right float-right btn btn-navy btn-sm"><i class="fa fa-download"></i> Simpan sebagai Excel</button>
                <?php } ?>
                <?php if(isset($use_header) && $use_header == 1){ ?>
                    <table style="width: 100%;">
                        <tr>
                            <td>SKPD</td>
                            <td>:</td>
                            <td><?=$skpd[1]?></td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>:</td>
                            <td><?=getNamaBulan($parameter['bulan']).' '.$parameter['tahun']?></td>
                        </tr>
                    </table>
                <?php } ?>
                <!-- tes -->
              <style>
               
              </style>
                <!-- tutup tes -->
                <input type="text" class="cd-search table-filter" data-table="rekap-table" placeholder="Cari Pegawai" />
                <div class="div_maintb">
                    <table class="cd-table rekap-table table" border="1" id="table_rekap_penilaianx">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5px;" rowspan="2">No</th>
                                <th style="text-align: center;z-index: 400; width: 10px;" rowspan="2">Nama Pegawai</th>
                                <th style="text-align: center;" rowspan="2">Target Bobot Produktivitas Kerja</th>
                                <th style="text-align: center;" rowspan="1" colspan="2">Penilaian Sasaran Kerja Bulanan Pegawai</th>
                                <th style="text-align: center;" rowspan="1" colspan="9">Penilaian Komponen Kinerja</th>
                                <th style="text-align: center;" rowspan="2">Capaian Bobot Produktivitas Kerja</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;" rowspan="1" colspan="1">% Capaian</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Berorientasi Pelayanan</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Akuntabel</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Kompeten</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Harmonis</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Loyal</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Adaptif</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Kolaboratif</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Nilai Capaian</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($result as $rs){
                                $bobot_capaian_produktivitas = isset($rs['kinerja']) && $rs['kinerja'] ? $rs['kinerja']['rekap_kinerja']['bobot'] : 0;
                                if(isset($rs['komponen_kinerja'])){
                                    $bobot_capaian_produktivitas += $rs['komponen_kinerja'][1];
                                }
                            ?>
                                <tr >
                                    <td  style="text-align: center;"><?=$no++;?></td>
                                    <td scope="row" style="padding-top: 5px; padding-bottom: 5px;">
                                        <span style="font-size: 14px; font-weight: bold;"><?=$rs['nama']?></span><br>
                                        NIP. <?=$rs['nip']?>
                                    </td>
                                    <td style="width: 6%; text-align: center;"><?=TARGET_BOBOT_PRODUKTIVITAS_KERJA.'%'?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['capaian']) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['bobot']) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['berorientasi_pelayanan'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['akuntabel'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['kompeten'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['harmonis'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['loyal'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['adaptif'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['kolaboratif'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? ($rs['komponen_kinerja'][0]) : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? formatTwoMaxDecimal($rs['komponen_kinerja'][1]) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=formatTwoMaxDecimal($bobot_capaian_produktivitas)?>%</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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

    $('#table_rekap_penilaian').DataTable({
    "ordering": false,
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            left: 2
        }
     });


  

</script>