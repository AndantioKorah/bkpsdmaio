<style>
      .progress {
  		background-color: #d6d6d6;
		}
</style>
<div class="row">
    <div class="col-lg-6">
        <div class="text-center">
            <h5>SASARAN KERJA BULANAN PEGAWAI</h5>
        </div>
        <table style="font-size: .8rem;" border=1 class="table table-sm table-hover">
            <thead>
                <th class="text-center">Sasaran Kerja</th>
                <th class="text-center">Realisasi</th>
            </thead>
            <?php if($list_rekap_kinerja){ ?>
                <tbody>
                    <?php $bobot_rekap = countNilaiSkp($list_rekap_kinerja);
                        $total_progress_kinerja = 0;
                        $no = 1; foreach($list_rekap_kinerja as $lp){
                            // $progress = (floatval($lp['realisasi_target_kuantitas'])/floatval($lp['target_kuantitas'])) * 100;
                            $progress = (floatval($lp['realisasi'])/floatval($lp['target_kuantitas'])) * 100;
                        if($progress > 100){
                            $progress = 100;
                        }
                        $total_progress_kinerja += $progress;
                        $progress = formatTwoMaxDecimal($progress);
                    ?>
                        <tr valign="top">
                            <td style="width: 70%;" class="text-left"><?=$lp['sasaran_kerja']?></td>
                            <td style="width: 30%;">
                                <div class="progress progress-sm" style="height:10px;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100"  style="height:10px; width: <?=$progress;?>%; background-color: <?=getProgressBarColor($progress)?>;">
                                    </div>
                                </div>
                            
                                <small style="font-size: 90% !important; font-weight: bold !important;">
                                    <?=$progress.' %'?>
                                </small>
                            </td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td class="text-right" style="font-weight: bold;">RATA-RATA</td>
                            <td class="text-center" style="font-weight: bold;"><?=formatTwoMaxDecimal($bobot_rekap['capaian']).' %'?></td>
                        </tr>
                        <tr>
                            <td class="text-right" style="font-weight: bold;"><span style="font-size: 1rem;">BOBOT <a style="font-size: 10px;">(= Rata-rata x 30%)</a></span></td>
                            <td class="text-center" style="font-weight: bold; font-size: 1rem;"><?=formatTwoMaxDecimal($bobot_rekap['bobot']).' %'?></td>
                        </tr>
                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan=2 class="text-center" style="font-weight: bold; font-size: 1rem">
                            Belum Ada Data <i class="fa fa-exclamation"></i>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
    <div class="col-lg-6">
        <div class="text-center">
            <h5>KOMPONEN KINERJA</h5>
        </div>
        <table style="font-size: .8rem;" border=1 class="table table-sm table-hover">
            <thead>
                <th class="text-center">Komponen</th>
                <th class="text-center">Nilai</th>
            </thead>
            <?php if($list_rekap_komponen_kinerja){ ?>
                <tbody>
                    <?php $bobot_rekap_komponen = countNilaiKomponen($list_rekap_komponen_kinerja);?>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Berorientasi Pelayanan</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['berorientasi_pelayanan']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Akuntabel</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['akuntabel']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Kompeten</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['kompeten']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Harmonis</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['harmonis']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Loyal</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['loyal']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Adaptif</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['adaptif']?></td>
                        </tr>
                        <tr>
                            <td style="width: 70%; padding-left: .5rem;" class="text-left">Kolaboratif</td>
                            <td style="width: 30%;" class="text-center"><?=$list_rekap_komponen_kinerja['kolaboratif']?></td>
                        </tr>
                        <tr>
                            <td class="text-right" style="font-weight: bold;">Capaian</td>
                            <td class="text-center" style="font-weight: bold;"><?=isset($bobot_rekap_komponen[0]) ? $bobot_rekap_komponen[0] : 0?></td>
                        </tr>
                        <tr>
                            <td class="text-right" style="font-weight: bold;">
                                <span style="font-size: 1rem;">
                                    BOBOT <br>
                                    <a style="font-size: 10px;">*jika capaian < 350, bobot = 0%</a><br>
                                    <a style="font-size: 10px;">*jika capaian >= 350 dan <= 678, bobot = (Capaian / 700) x 30%</a><br>
                                    <a style="font-size: 10px;">*jika capaian >= 679, bobot = 30%</a>
                                </span>
                            </td>
                            <td class="text-center" style="font-weight: bold; font-size: 1rem;"><?=isset($bobot_rekap_komponen[1]) ? $bobot_rekap_komponen[1].' %' : '0 %'?></td>
                        </tr>
                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan=2 class="text-center" style="font-weight: bold; font-size: 1rem">
                            Belum Ada Data <i class="fa fa-exclamation"></i>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
    <div class="col-lg-12 mt-3">
        <table border=1 class="table">
            <tbody style="font-size: .7rem; !important; font-weight: bold;">
                <tr>
                    <td rowspan=2 colspan=1 class="text-center">
                        PAGU TPP
                    </td>
                    <td rowspan=1 colspan=2 class="text-center">
                        SASARAN KINERJA BULANAN PEGAWAI
                    </td>
                    <td rowspan=1 colspan=2 class="text-center">
                        KOMPONEN KINERJA
                    </td>
                    <td rowspan=2 colspan=1 class="text-center">
                        TOTAL
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; important;">(%)</span></td>
                    <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; !important">(Rp)</span></td>
                    <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; important;">(%)</span></td>
                    <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; !important">(Rp)</span></td>
                </tr>
                <tr>
                    <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($tpp['pagu_tpp']['pagu_tpp'])?></td>
                    <td class="text-center" style="font-size: .8rem;"><?=isset($bobot_rekap['bobot']) ? formatTwoMaxDecimal($bobot_rekap['bobot']).' %' : '0 %'?></td>
                    <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($tpp['capaian_skp'])?></td>
                    <td class="text-center" style="font-size: .8rem;"><?=isset($bobot_rekap_komponen[1]) ? formatTwoMaxDecimal($bobot_rekap_komponen[1]).' %' : '0 %'?></td>
                    <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($tpp['capaian_komponen_kinerja'])?></td>
                    <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($tpp['capaian_pk'])?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>