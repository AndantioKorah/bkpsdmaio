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
                <th rowspan=2 class="text-center">Jumlah TPP yang dicapai (Rp)</th>
                <th rowspan=1 colspan=2 class="text-center">Potongan PPh</th>
                <th rowspan=2 class="text-center">BPJS (1%) TPP</th>
                <th rowspan=2 class="text-center">Jumlah yg Diterima</th>
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
                        <span class="text-data-pegawai"><?=($r['nip'])?></span><br>
                    </td>
                    <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                    <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                    <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                    <td style="text-align: center;"><?=$r['eselon']?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp(pembulatan($r['besaran_tpp']), 0)?></td>
                    <td class="align-middle text-center">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp(pembulatan($r['nominal_pph']), 0)?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs']), 0)?></td>
                    <td class="align-middle text-right"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final']), 0)?></td>
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