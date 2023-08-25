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
            <?php $no = 1; foreach($result as $r){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai">NIP. <?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
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
            <?php } ?>
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