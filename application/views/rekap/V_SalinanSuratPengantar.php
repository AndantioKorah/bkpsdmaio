<?php
    $data_header['filename'] = 'SALINAN SURAT PENGANTAR';
    $data_header['skpd'] = $param['nm_unitkerja'];
    $data_header['bulan'] = $param['bulan'];
    $data_header['tahun'] = $param['tahun'];
    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
?>
<div style="width: 100%; margin-top: 30px;">
    <span>A. Hasil Evaluasi Penilaian Pemberian TPP serta capaian pembayaran TPP :</span>
    <table style="width: 100%; border: 1px solid black;" border=1 style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; text-align: center;">No</td>
            <td style="border: 1px solid black; text-align: center;">Jumlah ASN</td>
            <td style="border: 1px solid black; text-align: center;">JHK</td>
            <td style="border: 1px solid black; text-align: center;">% Rata-rata Kehadiran</td>
            <td style="border: 1px solid black; text-align: center;">Nilai Rata-Rata Capaian Bobot Disiplin Kerja (40%)</td>
            <td style="border: 1px solid black; text-align: center;">Nilai Rata-Rata Capaian Bobot Produktifitas Kerja (60%)</td>
            <td style="border: 1px solid black; text-align: center;">Pagu TPP</td>
            <td style="border: 1px solid black; text-align: center;">Selisih Capaian dengan Pagu</td>
            <td style="border: 1px solid black; text-align: center;">Jumlah Pajak PPh</td>
            <td style="border: 1px solid black; text-align: center;">BPJS 1% (TPP)</td>
            <td style="border: 1px solid black; text-align: center;">Jumlah yang diterima</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;">1</td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp($rekap['jumlah_pegawai'], 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp($rekap['jhk'], 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatTwoMaxDecimal($rekap['rata_rata_presentase_kehadiran']).' %'?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatTwoMaxDecimal($rekap['rata_rata_bobot_disiplin_kerja']).' %'?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatTwoMaxDecimal($rekap['rata_rata_bobot_produktivitas_kerja']).' %'?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp(pembulatan($rekap['pagu_tpp']), 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp(pembulatan($rekap['selisih_capaian_pagu']), 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp(pembulatan($rekap['jumlah_pajak_pph']), 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp(pembulatan($rekap['bpjs']), 0)?></td>
            <td style="border: 1px solid black; padding: 5px; font-weight: bold; text-align: center;"><?=formatCurrencyWithoutRp(pembulatan($rekap['jumlah_yang_diterima']), 0)?></td>
        </tr>
    </table>
    <br>
    <span>B.  Penjatuhan Hukuman Disiplin :</span>
    <table style="width: 100%; border: 1px solid black;" border=1 style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; text-align: center;">No</td>
            <td style="border: 1px solid black; text-align: center;">Nama</td>
            <td style="border: 1px solid black; text-align: center;">Pangkat/Gol</td>
            <td style="border: 1px solid black; text-align: center;">Jabatan</td>
            <td style="border: 1px solid black; text-align: center;">Jenis Pelanggaran Disiplin</td>
            <td style="border: 1px solid black; text-align: center;">Keterangan</td>
        </tr>
        <?php $no = 1; if($hukdis){ foreach($hukdis as $h) { ?>
            <tr>
                <td style="border: 1px solid black; text-align: center;"><?=$no++;?></td>
                <td style="border: 1px solid black; text-align: left;"><?=getNamaPegawaiFull($h)?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nm_pangkat']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nama_jabatan']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nama_jhd']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=strtoupper('Hukuman Disiplin '.$h['nama_hd'])?></td>
            </tr>
        <?php } } ?>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center">
                            Mengetahui,<br><br><br><br><br>
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center">
                            Petugas Pemeriksa,<br><br><br><br><br>
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>