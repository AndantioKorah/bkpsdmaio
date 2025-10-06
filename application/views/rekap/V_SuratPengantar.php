<?php
    $data['skpd'] = $rekap['unitkerja'][0];
    $this->load->view('adminkit/partials/V_HeaderSuratGeneralDynamic', $data);
?>
<table style="width: 100%;">
    <tr valign=top>
        <td style="width: 70%;">
            <table style="width: 100%;">
                <tr valign=top>
                    <td style="width: 15%;">Nomor</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr valign=top>
                    <td style="width: 15%;">Sifat</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr valign=top>
                    <td style="width: 15%;">Lamp.</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr valign=top>
                    <td style="width: 15%;">Hal</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 80%;">Permintaan pembayaran TPP dan Hasil Evaluasi Penilaian Pemberian TPP</td>
                </tr>
            </table>
        </td>
        <td style="width: 30%;">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: right;"><span style="text-align: right;">Manado, <?=formatDateNamaBulan(date('d-m-Y'))?></span></td>
                </tr>
                <tr>
                    <td>
                        <span>Kepada</span><br>
                        Yth, <span style="font-weight: bold;">SEKRETARIS DAERAH KOTA MANADO</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="margin-left: 20px;">di-</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <span style="text-align: center;">Tempat</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="width: 100%;">
    <span>Dengan Hormat,</span><br>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Bersama ini kami sampaikan Permintaan Pembayaran TPP dengan mencantumkan hasil evaluasi penilaian pemberian TPP pada Perangkat Daerah <strong><?=$param['nm_unitkerja']?></strong> bulan <?=getNamaBulan($param['bulan'])?> tahun <?=$param['tahun']?>, sebagai berikut :									
    </span>
    <br>
    <span>A. Hasil Evaluasi Penilaian Pemberian TPP serta capaian pembayaran TPP :</span>
    <table style="width: 100%; border: 1px solid black;" border=1 style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; text-align: center;">No</td>
            <td style="border: 1px solid black; text-align: center;">Jumlah <?=isset($flag_pppk) ? 'PPPK' : 'ASN'?></td>
            <td style="border: 1px solid black; text-align: center;">Rata-rata Presentase Kehadiran</td>
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
        <?php $no = 1; if($hukdis){ foreach($hukdis as $h) { 
                // if((isset($rekap['flag_pppk']) && $h['statuspeg'] == 3) || !isset($rekap['flag_pppk']) && $h['statuspeg'] != 3){
            ?>
            <tr>
                <td style="border: 1px solid black; text-align: center;"><?=$no++;?></td>
                <td style="border: 1px solid black; text-align: left;"><?=getNamaPegawaiFull($h)?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nm_pangkat']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nama_jabatan']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=$h['nama_jhd']?></td>
                <td style="border: 1px solid black; text-align: left;"><?=strtoupper('Hukuman Disiplin '.$h['nama_hd'])?></td>
            </tr>
        <?php } }
            //} ?>
    </table>
    <!-- <span>C. Pemberhentian TPP</span>
    <table style="width: 100%;" border=1 style="border-collapse: collapse;">
        <tr>
            <td style="text-align: center;">No</td>
            <td style="text-align: center;">Nama</td>
            <td style="text-align: center;">Pangkat/Gol</td>
            <td style="text-align: center;">Jabatan</td>
            <td style="text-align: center;">Jenis Pelanggaran Disiplin</td>
            <td style="text-align: center;">Keterangan</td>
        </tr>
    </table> -->
    <br>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Demikian dapat kami sampaikan, sambil menunggu petunjuk lebih lanjut atasnya diucapkan terima kasih.
    </span>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">
                <table style="width: 100%; text-align: center;">
                    <tr>
                        <td>
                            <?=$kepalabkpsdm['nama_jabatan']?>
                        </td>
                    </tr>
                    <tr>
                        <td><br><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td><?=getNamaPegawaiFull($kepalabkpsdm)?></td>
                    </tr>
                    <tr>
                        <td><?=($kepalabkpsdm['nm_pangkat'])?></td>
                    </tr>
                    <tr>
                        <td>NIP. <?=($kepalabkpsdm['nipbaru_ws'])?></td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</div>