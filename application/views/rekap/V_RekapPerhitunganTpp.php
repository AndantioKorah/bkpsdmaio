<style>
    .text-data-pegawai{
        font-size: 12px;
    }
</style>

<?php if($result){ ?>
    <div class="col-lg-12 table-responsive">
    <table border=1 class="table table-hover table-striped">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Kelas Jabatan</th>
            <th class="text-center">Besaran Pagu TPP</th>
            <th class="text-center">% Capaian Produktivitas Kerja</th>
            <th class="text-center">% Capaian Disiplin Kerja Kerja</th>
            <th class="text-center">% Penilaian TPP</th>
            <th class="text-center">Capaian TPP</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left">
                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                        <span class="text-data-pegawai">NIP. <?=formatNip($r['nip'])?></span><br>
                        <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span>
                    </td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-right"><?=formatCurrency($r['pagu_tpp'])?></td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                    <td class="align-middle text-center"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                    <td class="align-middle text-right"><?=formatCurrency($r['besaran_tpp'])?></td>
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