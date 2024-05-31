<style>
    .text-data-pegawai{
        font-size: 12px;
    }
</style>

<?php if($result){ ?>
    <input type="text" class="cd-search table-filter" data-table="rekap-table" placeholder="Cari Pegawai" />
    <div class="col-lg-12 div_maintb">
    <table border=1 class="table table-hover table-striped rekap-table">
        <thead>
            <tr>
                <th rowspan=2 class="text-center">No</th>
                <th rowspan=2 class="text-center">Pegawai</th>
                <th rowspan=2 class="text-center">Gol</th>
                <th rowspan=2 class="text-center">Kelas Jabatan</th>
                <th rowspan=2 class="text-center">Besaran Pagu TPP (Rp)</th>
                <th rowspan=2 class="text-center">% Capaian Produktivitas Kerja</th>
                <th rowspan=2 class="text-center">% Capaian Disiplin Kerja Kerja</th>
                <th rowspan=2 class="text-center">% Penilaian TPP</th>
                <th rowspan=2 class="text-center">Capaian TPP (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">Jumlah TPP Diterima (Rp)</th>
            </tr>
            <tr>
                <th rowspan=1 colspan=1 class="text-center">%</th>
                <th rowspan=1 colspan=1 class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $no = 1;
                $pagu_keseluruhan = 0;
                $jumlah_capaian_keseluruhan = 0;
                $potongan_pajak_keseluruhan = 0;
                $jumlah_setelah_pajak_keseluruhan = 0;
                $jumlah_bobot_produktivitas_kerja = 0;
                $jumlah_bobot_disiplin_kerja = 0;
                
                foreach($result as $r){
                    $pagu_keseluruhan += $r['pagu_tpp'];
                    $jumlah_capaian_keseluruhan += $r['besaran_tpp'];
                    $potongan_pajak_keseluruhan += $r['nominal_pph'];
                    $jumlah_setelah_pajak_keseluruhan += $r['tpp_diterima'];

                    $jumlah_bobot_produktivitas_kerja += $r['bobot_produktivitas_kerja'];
                    $jumlah_bobot_disiplin_kerja += $r['bobot_disiplin_kerja'];
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai">NIP. <?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
                    <td class="align-middle text-center"><?=$r['nomor_golongan']?></td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['pagu_tpp'], 0)?></td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['besaran_tpp'], 0)?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['nominal_pph'], 0)?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['tpp_diterima'], 0)?></td>
                </tr>
            <?php }
                $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);
            ?>
                <tr>
                    <td class="text-center" colspan=2><strong>JUMLAH</strong></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="align-middle text-center"><strong><?=formatCurrencyWithoutRp($pagu_keseluruhan, 0)?></strong></td>
                    <td class="text-center"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_produktivitas).' %'?></strong></td>
                    <td class="text-center"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_disiplin).' %'?></strong></td>
                    <td class="text-center"></td>
                    <td class="align-middle text-center"><strong><?=formatCurrencyWithoutRp($jumlah_capaian_keseluruhan, 0)?></strong></td>
                    <td class="text-center"></td>
                    <td class="align-middle text-center"><strong><?=formatCurrencyWithoutRp($potongan_pajak_keseluruhan, 0)?></strong></td>
                    <td class="align-middle text-center"><strong><?=formatCurrencyWithoutRp($jumlah_setelah_pajak_keseluruhan, 0)?></strong></td>
                </tr>
        </tbody>
    </table>
    </div>
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>
<script>
    $(function(){
    fixedHeaderTable()
    })
</script>