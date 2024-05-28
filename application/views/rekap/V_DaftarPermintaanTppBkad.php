<style>
    .text-data-pegawai{
        font-size: 12px;
    }
</style>

<?php if($result){ ?>
    <div class="col-lg-12 table-responsive">
        <table border=1 class="table table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan=2 style="text: align: center;">No</th>
                    <th rowspan=2 style="text: align: center;">Nama / NIP</th>
                    <th rowspan=2 style="text: align: center;">Gol / Rg</th>
                    <th rowspan=2 style="text: align: center;">Jabatan</th>
                    <th rowspan=2 style="text: align: center;">Kls. Jab.</th>
                    <th rowspan=2 style="text: align: center;">Ess</th>
                    <th rowspan=2 style="text: align: center;">Jumlah Capaian TPP (Rp)</th>
                    <th rowspan=2 style="text: align: center;">Capaian TPP Prestasi Kerja</th>
                    <th rowspan=2 style="text: align: center;">Capaian TPP Beban Kerja</th>
                    <th rowspan=2 style="text: align: center;">Capaian TPP Kondisi Kerja</th>
                    <th rowspan=1 colspan=4 style="text: align: center;">Potongan PPh</th>
                    <th rowspan=1 colspan=3 style="text: align: center;">Jumlah Setelah Dipotong PPh</th>
                    <th rowspan=2 style="text: align: center;">Gaji (Rp)</th>
                    <th rowspan=1 colspan=3 style="text: align: center;">BPJS 1% (TPP)</th>
                    <th rowspan=1 colspan=4 style="text: align: center;">TPP Yang Diterima</th>
                </tr>
                <tr>
                    <th rowspan=1 colspan=1 style="text: align: center;">%</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                    <th rowspan=1 colspan=1 style="text: align: center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                
                $total_capaian_tpp = 0;
                $total_capaian_tpp_prestasi_kerja = 0;
                $total_capaian_tpp_beban_kerja = 0;
                $total_capaian_tpp_kondisi_kerja = 0;
                $total_pph_prestasi_kerja = 0;
                $total_pph_beban_kerja = 0;
                $total_pph_kondisi_kerja = 0;
                $total_jumlah_setelah_pph_prestasi_kerja = 0;
                $total_jumlah_setelah_pph_beban_kerja = 0;
                $total_jumlah_setelah_pph_kondisi_kerja = 0;
                $bpjs_prestasi_kerja = 0;
                $bpjs_beban_kerja = 0;
                $bpjs_kondisi_kerja = 0;
                $tpp_final_prestasi_kerja = 0;
                $tpp_final_beban_kerja = 0;
                $tpp_final_kondisi_kerja = 0;
                $tpp_final_permintaan_bkad = 0;
                $total_besaran_gaji = 0;
                
                foreach($result as $r){

                    $total_capaian_tpp += $r['besaran_tpp'];
                    $total_capaian_tpp_prestasi_kerja += $r['capaian_tpp_prestasi_kerja'];
                    $total_capaian_tpp_beban_kerja += $r['capaian_tpp_beban_kerja'];
                    $total_capaian_tpp_kondisi_kerja += $r['capaian_tpp_kondisi_kerja'];
                    $total_pph_prestasi_kerja += ($r['pph_prestasi_kerja']);
                    $total_pph_beban_kerja += ($r['pph_beban_kerja']);
                    $total_pph_kondisi_kerja += ($r['pph_kondisi_kerja']);
                    $total_jumlah_setelah_pph_prestasi_kerja += $r['jumlah_setelah_pph_prestasi_kerja'];
                    $total_jumlah_setelah_pph_beban_kerja += $r['jumlah_setelah_pph_beban_kerja'];
                    $total_jumlah_setelah_pph_kondisi_kerja += $r['jumlah_setelah_pph_kondisi_kerja'];
                    $bpjs_prestasi_kerja += $r['bpjs_prestasi_kerja'];
                    $bpjs_beban_kerja += $r['bpjs_beban_kerja'];
                    $bpjs_kondisi_kerja += $r['bpjs_kondisi_kerja'];
                    $tpp_final_prestasi_kerja += $r['tpp_final_prestasi_kerja'];
                    $tpp_final_beban_kerja += $r['tpp_final_beban_kerja'];
                    $tpp_final_kondisi_kerja += $r['tpp_final_kondisi_kerja'];
                    $tpp_final_permintaan_bkad += $r['tpp_final'];
                    $total_besaran_gaji += floatval($r['besaran_gaji']);
                ?>
                    <tr>
                        <td style="text: align: center;"><?=$no++;?></td>
                        <td style="text-left">
                            <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                            <span class="text-data-pegawai"><?=($r['nip'])?></span><br>
                        </td>
                        <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                        <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                        <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                        <td style="text-align: center;"><?=$r['eselon']?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['besaran_tpp'], 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_prestasi_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_beban_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_kondisi_kerja']), 0)?></td>
                        <td style="text-align: center;">
                            <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                        </td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_prestasi_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_beban_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_kondisi_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_prestasi_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_beban_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_kondisi_kerja']), 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['besaran_gaji'], 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRpWithDecimal($r['bpjs_prestasi_kerja'], 2)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRpWithDecimal($r['bpjs_beban_kerja'], 2)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRpWithDecimal($r['bpjs_kondisi_kerja'], 2)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['tpp_final_prestasi_kerja'], 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['tpp_final_beban_kerja'], 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['tpp_final_kondisi_kerja'], 0)?></td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['tpp_final_permintaan_bkad'], 0)?></td>
                        <!-- <td style="text-align: right;"><?=$r['tpp_final_permintaan_bkad'] != $r['tpp_final'] ? 'ini' : formatCurrencyWithoutRp($r['tpp_final_permintaan_bkad'], 0)?></td> -->

                    </tr>
                <?php } ?>
                <!-- <tr>
                    <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($total_capaian_tpp, 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_prestasi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_beban_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_kondisi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_prestasi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_beban_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_kondisi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_beban_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_kondisi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($total_besaran_gaji, 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_prestasi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_beban_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_kondisi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($tpp_final_prestasi_kerja, 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($tpp_final_beban_kerja, 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($tpp_final_kondisi_kerja, 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($tpp_final_permintaan_bkad, 0)?></td>
                </tr> -->
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>