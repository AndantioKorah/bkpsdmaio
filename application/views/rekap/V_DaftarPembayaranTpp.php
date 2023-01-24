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
                <th rowspan=2 class="text-center">No</th>
                <th rowspan=2 class="text-center">Nama / NIP</th>
                <th rowspan=2 class="text-center">Kls. Jab.</th>
                <th rowspan=2 class="text-center">Ess</th>
                <th rowspan=2 class="text-center">Jumlah TPP yang dicapai (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">Jumlah Setelah Dipotong PPh (Rp)</th>
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
                        <span class="text-data-pegawai"><?=formatNip($r['nip'])?></span><br>
                        <!-- <span class="text-data-pegawai"><?=$r['pangkat']?></span><br>
                        <span class="font-weight-bold text-data-pegawai"><?=$r['nama_jabatan']?></span> -->
                    </td>
                    <td class="align-middle text-center"><?=$r['kelas_jabatan']?></td>
                    <td class="align-middle text-center"><?=$r['eselon']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['besaran_tpp'])?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['nominal_pph'])?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp($r['tpp_diterima'])?></td>
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