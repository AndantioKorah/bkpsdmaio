<?php if($list_disiplin_kerja){ ?>
    <div class="row">
        <div class="col-lg-12">
            <table style="width: 100%" border=1 class="table table-sm table-hover">
                <thead style="font-weight: bold;">
                    <tr valign="middle">
                        <td rowspan=2 colspan=1 class="text-center">Jenis Disiplin Kerja</td>
                        <td rowspan=2 colspan=1 class="text-center">Bobot<br>Pengurangan</td>
                        <td rowspan=2 colspan=1 class="text-center">Jumlah</td>    
                        <td rowspan=1 colspan=2 class="text-center">Pengurangan</td>
                    </tr>
                    <tr>
                        <td colspan=1 class="text-center">%</td>
                        <td colspan=1 class="text-center">Rp</td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php foreach($list_disiplin_kerja as $l){
                        $bgcolor = '';
                        if(isset($result['rincian_pengurangan_dk'][$l['keterangan']])){
                            $bgcolor = '#ffc0c0';
                        }
                        $pengurangan = 0;
                        $pengurangan_rp = 0;
                        if(isset($result['rincian_pengurangan_dk'][$l['keterangan']])){
                            $pengurangan = ($result['rincian_pengurangan_dk'][$l['keterangan']]) * $l['pengurangan'];
                            $pengurangan_rp = ($pengurangan / 100) * $result['pagu_dk'];
                        }
                    ?>
                        <tr style="background-color: <?=$bgcolor;?>">
                            <td class="text-left"><?=$l['nama_jenis_disiplin_kerja']?></td>
                            <td class="text-center"><?=$l['pengurangan']?></td>
                            <td class="text-center">
                                <?=isset($result['rincian_pengurangan_dk'][$l['keterangan']]) ? $result['rincian_pengurangan_dk'][$l['keterangan']] : '0';?>
                            </td>
                            <td class="text-center"><?=$pengurangan.' %'?></td>
                            <td class="text-center"><?=formatCurrency($pengurangan_rp)?></td>
                        </tr>
                    <?php } ?>
                    <tr 
                        style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['tmk1']) > 0) ? '#ffc0c0' : ''?>;"
                    >
                        <?php
                            $pengurangan_tmk1 = 1 * ($result['rincian_pengurangan_dk']['tmk1']);
                            $pengurangan_rp_tmk1 = ($pengurangan_tmk1 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">TMK 1 <span style="font-weight: bold; font-size: .6rem;">(terlambat masuk kerja <= 30 menit)</span></td>
                        <td class="text-center">1</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['tmk1']) ? $result['rincian_pengurangan_dk']['tmk1'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_tmk1.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_tmk1)?></td>
                    </tr>
                    <tr style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['tmk2']) > 0) ? '#ffc0c0' : ''?>">
                        <?php
                            $pengurangan_tmk2 = 2 * ($result['rincian_pengurangan_dk']['tmk2']);
                            $pengurangan_rp_tmk2 = ($pengurangan_tmk2 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">TMK 2 <span style="font-weight: bold; font-size: .6rem;">(terlambat masuk kerja > 30 menit dan <= 60 menit)</span></td>
                        <td class="text-center">2</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['tmk2']) ? $result['rincian_pengurangan_dk']['tmk2'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_tmk2.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_tmk2)?></td>
                    </tr>
                    <tr style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['tmk3']) > 0) ? '#ffc0c0' : ''?>">
                        <?php
                            $pengurangan_tmk3 = 3 * ($result['rincian_pengurangan_dk']['tmk3']);
                            $pengurangan_rp_tmk3 = ($pengurangan_tmk3 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">TMK 3 <span style="font-weight: bold; font-size: .6rem;">(terlambat masuk kerja > 60 menit)</span></td>
                        <td class="text-center">3</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['tmk3']) ? $result['rincian_pengurangan_dk']['tmk3'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_tmk3.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_tmk3)?></td>
                    </tr>
                    <tr style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['pksw1']) > 0) ? '#ffc0c0' : '';?>">
                        <?php
                            $pengurangan_pksw1 = 1 * ($result['rincian_pengurangan_dk']['pksw1']);
                            $pengurangan_rp_pksw1 = ($pengurangan_pksw1 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">PKSW 1 <span style="font-weight: bold; font-size: .6rem;">(pulang kerja sebelum waktu <= 30 menit)</span></td>
                        <td class="text-center">1</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['pksw1']) ? $result['rincian_pengurangan_dk']['pksw1'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_pksw1.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_pksw1)?></td>
                    </tr>
                    <tr style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['pksw2']) > 0) ? '#ffc0c0' : '';?>">
                        <?php
                            $pengurangan_pksw2 = 2 * ($result['rincian_pengurangan_dk']['pksw2']);
                            $pengurangan_rp_pksw2 = ($pengurangan_pksw2 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">PKSW 2 <span style="font-weight: bold; font-size: .6rem;">(pulang kerja sebelum waktu > 30 menit dan <= 60 menit)</span></td>
                        <td class="text-center">2</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['pksw2']) ? $result['rincian_pengurangan_dk']['pksw2'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_pksw2.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_pksw2)?></td>
                    </tr>
                    <tr style="background-color: <?=(floatval($result['rincian_pengurangan_dk']['pksw3']) > 0) ? '#ffc0c0' : '';?>">
                        <?php
                            $pengurangan_pksw3 = 3 * ($result['rincian_pengurangan_dk']['pksw3']);
                            $pengurangan_rp_pksw3 = ($pengurangan_pksw3 / 100) * $result['pagu_dk'];
                        ?>
                        <td class="text-left">PKSW 3 <span style="font-weight: bold; font-size: .6rem;">(pulang kerja sebelum waktu > 60 menit)</span></td>
                        <td class="text-center">3</td>
                        <td class="text-center">
                            <?=isset($result['rincian_pengurangan_dk']['pksw3']) ? $result['rincian_pengurangan_dk']['pksw3'] : '0';?>
                        </td>
                        <td class="text-center"><?=$pengurangan_pksw3.' %'?></td>
                        <td class="text-center"><?=formatCurrency($pengurangan_rp_pksw3)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <div class="col-lg-4">
            <table style="font-size: .8rem; font-weight: bold;" border=1 class="table table-sm table-hover">
                <tr>
                    <td>Pagu</td>
                    <td><?=formatCurrency($result['pagu_dk'])?></td>
                </tr>
                <tr>
                    <td>Jumlah Hari Kerja</td>
                    <td><?=$result['jhk']?></td>
                </tr>
                <tr>
                    <td>Pagu Harian</td>
                    <td><?=formatCurrency($result['pagu_harian'])?></td>
                </tr>
                <tr>
                    <td>Capaian Tanpa Pengurangan</td>
                    <td><?=formatCurrency($result['capaian_dk_tanpa_pengurangan'])?></td>
                </tr>
                <tr>
                    <td>Total Pengurangan (%)</td>
                    <td><?=($result['pengurangan_dk'])?>%</td>
                </tr>
                <tr>
                    <td>Total Pengurangan (Rp)</td>
                    <td><?=formatCurrency($result['rupiah_pengurangan_dk'])?></td>
                </tr>
            </table>
        </div> -->
        <div class="col-lg-12 mt-3">
            <table border=1 class="table">
                <tbody style="font-size: .7rem; !important; font-weight: bold;">
                    <tr>
                        <td rowspan=2 colspan=1 class="text-center" title="40% x <?=formatCurrencyWithoutRp($result['pagu_tpp']['pagu_tpp'])?>">
                            PAGU DISIPLIN KERJA
                        </td>
                        <td rowspan=2 colspan=1 class="text-center" title="Jumlah Hari Kerja dalam 1 bulan">
                            JHK
                        </td>
                        <td rowspan=2 colspan=1 class="text-center" title="Pagu Disiplin Kerja / JHK">
                            PAGU HARIAN
                        </td>
                        <td rowspan=2 colspan=1 class="text-center" title="Jumlah Hari Kerja sampai hari ini">
                            HARI KERJA
                        </td>
                        <td rowspan=2 colspan=1 class="text-center" title="Pagu Harian x Hari Kerja">
                            CAPAIAN HARIAN
                        </td>
                        <td rowspan=1 colspan=2 class="text-center" title="Total Pengurangan dari pelanggaran absensi">
                            TOTAL PENGURANGAN
                        </td>
                        <td rowspan=2 colspan=1 class="text-center" title="Total Capaian Disiplin Kerja">
                            TOTAL
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; important;" title="Presentase pelanggaran absensi">(%)</span></td>
                        <td style="padding: 0px !important;" class="text-center"><span style="font-size: .6rem; !important" title="Presentase x Pagu Disiplin Kerja">(Rp)</span></td>
                    </tr>
                    <tr>
                        <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($result['pagu_dk'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=($result['jhk'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($result['pagu_harian'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=($result['hari_kerja'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($result['capaian_harian'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=formatTwoMaxDecimal($result['pengurangan_dk']).' %'?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($result['rupiah_pengurangan_dk'])?></td>
                        <td class="text-center" style="font-size: .8rem;"><?=formatCurrency($result['capaian_dk'])?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>