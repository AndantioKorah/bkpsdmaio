
<?php if($result){
    $skpd = explode(";",$parameter['skpd']);
    if($flag_print == 1){
        $filename = 'REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA '.$skpd[1].' Periode '.getNamaBulan($parameter['bulan']).' '.$parameter['tahun'].'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
    }
?>
        <div class="col-lg-12" style="width: 100%;">
            <form action="<?=base_url('rekap/C_Rekap/rekapPenilaianSearch2/1')?>" method="post" target="_blank">
               
            <?php if(isset($use_header) && $use_header == 1){ ?>
                    <center><h5><strong>REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA</strong></h5></center>
                <?php } ?>
                <br>
                <?php if($flag_print == 0){ ?>
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
              
                <table class="table table-bordered" border="1" style="margin-top:-50px;">
                    <?php 
                   
                   $no = 1; 
                   $diatasekspektasi = 0;
                   $sesuaisekspektasi = 0;
                   $dibawahekspektasi = 0;
                   
                   foreach($result as $rs){
                    $no++ ; 
                       $capaian_pk = (isset($rs['nilai_skp']) ? formatTwoMaxDecimal($rs['nilai_skp']['bobot']) : 0) + (isset($rs['komponen_kinerja']) ? formatTwoMaxDecimal($rs['komponen_kinerja']['bobot']) : 0);
                       $bobot_capaian_produktivitas = $capaian_pk;
                       

                       if($bobot_capaian_produktivitas == 60){
                           $diatasekspektasi++;
                       }
                       if($bobot_capaian_produktivitas >= 48 && $bobot_capaian_produktivitas < 60){
                           $sesuaisekspektasi++;
                       }
                       if($bobot_capaian_produktivitas <= 47){
                           $dibawahekspektasi++;
                       }
                    }

                    $jumlah = $no-1;
                    $presentase = ($diatasekspektasi + $sesuaisekspektasi) / $jumlah;
                    $presentaseFix = $presentase * 100;
                    ?>
                <thead style="background-color:#464646;color:#fff;font-size:10px;" >
                                <th style="text-align: center;" rowspan="1" colspan="1">JMLH, PEGAWAI</th>                             </th>
                                <th style="text-align: center;" rowspan="1" colspan="1">DI ATAS EKSPEKTASI <br>(NILAI PRODUKTIVITAS 60)</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">SESUAI EKSPEKTASI <br>(NILAI PRODUKTIVITAS 48-59)</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">DI BAWAH EKSPEKTASI <br>(NILAI PRODUKTIVITAS 0-47)</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">% PEGAWAI BERPREDIKAT <br>SESUAI/DI ATAS EKSPEKTASI</th>
                                </thead>
                            <tr>
                                <tbody>
                                    <td style="text-align: center;" rowspan="1" colspan="1"><?= $no-1;?></td>
                                    <td style="text-align: center;" rowspan="1" colspan="1"><?= $diatasekspektasi;?></td>
                                    <td style="text-align: center;" rowspan="1" colspan="1"><?= $sesuaisekspektasi;?></td>
                                    <td style="text-align: center;" rowspan="1" colspan="1"><?= $dibawahekspektasi;?></td>
                                    <td style="text-align: center;" rowspan="1" colspan="1"><?= formatTwoMaxDecimal($presentaseFix);?>%</td>
                                </tbody>
                </table>
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
                            <?php $no = 1; 
                            // $diatasekspektasi = 0;
                            // $sesuaisekspektasi = 0;
                            // $dibawahekspektasi = 0;
                            
                         
                            foreach($result as $rs){
                                // $bobot_capaian_produktivitas = isset($rs['kinerja']) && $rs['kinerja'] ? $rs['kinerja']['rekap_kinerja']['bobot'] : 0;
                                if(isset($rs['komponen_kinerja'])){
                                    // $bobot_capaian_produktivitas += $rs['komponen_kinerja']['capaian'];
                                }
                                $capaian_pk = (isset($rs['nilai_skp']) ? formatTwoMaxDecimal($rs['nilai_skp']['bobot']) : 0) + (isset($rs['komponen_kinerja']) ? formatTwoMaxDecimal($rs['komponen_kinerja']['bobot']) : 0);
                                // dd($capaian_pk);
                                // $bobot_capaian_produktivitas = ($capaian_pk / 60) * 100;
                                $bobot_capaian_produktivitas = $capaian_pk;
                            
                              
                                $badge_status = 'badge-cpns';
                                if($rs['statuspeg'] == 2){
                                  $badge_status = 'badge-pns';
                                } else if($rs['statuspeg'] == 3){
                                  $badge_status = 'badge-pppk';
                                }
                 

                              

                            
                            ?>
                                <tr >
                                    <td  style="text-align: center;"><?=$no++;?></td>
                                    <td scope="row" style="padding-top: 5px; padding-bottom: 5px;">
							        <a style="color:#495057" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$rs['nip']?>" target="_blank">
                                        <span style="font-size: 14px; font-weight: bold;"><?= getNamaPegawaiFull($rs)?></span></a><br>
                                        NIP. <?=$rs['nip']?> 
                                            <span class="badge <?=$badge_status?>"> <?php if($rs['statuspeg'] == 1) echo "CPNS"; else if($rs['statuspeg'] == 2) echo "PNS"; else echo "PPPK"; ?></span>
                                    </td>
                                    <td style="width: 6%; text-align: center;"><?=TARGET_BOBOT_PRODUKTIVITAS_KERJA.'%'?></td>
                                    <!-- <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['capaian']) : 0;?>%</td> -->
                                    <!-- <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['bobot']) : 0;?>%</td> -->
                                    <!-- <td style="width: 6%; text-align: center;"><?=$rs['nilai_skp']['capaian'];?>%</td> -->
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['nilai_skp']) ? formatTwoMaxDecimal($rs['nilai_skp']['capaian']) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['nilai_skp']) ? formatTwoMaxDecimal($rs['nilai_skp']['bobot']) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['berorientasi_pelayanan'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['akuntabel'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['kompeten'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['harmonis'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['loyal'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['adaptif'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['kolaboratif'] : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? ($rs['komponen_kinerja']['capaian']) : 0;?></td>
                                    <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? formatTwoMaxDecimal($rs['komponen_kinerja']['bobot']) : 0;?>%</td>
                                    <td style="width: 6%; text-align: center;"><?=formatTwoMaxDecimal($bobot_capaian_produktivitas)?>%</td>
                                </tr>
                            <?php } ?>
                              
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                
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