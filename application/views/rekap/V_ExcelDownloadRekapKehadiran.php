<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr >
            <th style="text-align: center; " rowspan="2">No</th>
            <th style="text-align: center;  z-index: 400;" rowspan="2">Nama Pegawai</td>
            <th style="text-align: center;"  rowspan="2">Gol/Ruang</td>
            <th style="text-align: center;"  rowspan="2">Jabatan</td>
            <th style="text-align: center;"  rowspan="2">Ess</td>
            <th style="text-align: center;"  rowspan="2">Kelas Jabatan</td>
            <th style="text-align: center; " rowspan="2">JHK</td>
            <th style="text-align: center; " rowspan="2">TARGET CAP. PEN. DISIPLIN KERJA</th>
            <th style="text-align: center; " rowspan="1" colspan="<?=count($rekap_penilaian_tpp['mdisker'])?>">Keterangan</th>
            <th style="text-align: center; " rowspan="2">% H</td>
            <!-- <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN PENILAIAN DISIPLIN KERJA</th> -->
        </tr>
        <tr >
            <?php foreach($rekap_penilaian_tpp['mdisker'] as $m){ ?>
                <th style="text-align: center; " rowspan="1" colspan="1"><?=STRTOUPPER($m['keterangan'])?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $total_presentase_kehadiran = 0;
        foreach($rekap_penilaian_tpp['result'] as $rs){
            $capaian = 0;
            $capaian_bobot = 0;
            // $presentase_hadir_rekap = (floatval($rs['rekap']['hadir']) / floatval($rs['rekap']['jhk'])) * 100;
            $total_presentase_kehadiran += $rs['rekap']['presentase_kehadiran'];
        ?>
            <tr>
                <td style="text-align: center;"><?=$no++;?></td>
                <td style="padding-top: 5px; padding: 5px;">
                    <span class="berkas_tpp_download_nama_pegawai"><?=$rs['nama_pegawai']?></span><br>
                    <span style="">NIP. <?=$rs['nip']?></span>
                </td>
                <td style="width: 6%; text-align: center;"><?=$rs['golongan']?></td>
                <td style="width: 6%; text-align: center;"><?=$rs['nama_jabatan']?></td>
                <td style="width: 6%; text-align: center;"><?=$rs['eselon']?></td>
                <td style="width: 6%; text-align: center;"><?=$rs['kelas_jabatan']?></td>
                <td style="width: 6%; text-align: center;"><?=$rs['rekap']['jhk']?></td>
                <td style="width: 6%; text-align: center;"><?=TARGET_PENILAIAN_DISIPLIN_KERJA.'%'?></td>
                <?php $temp_capaian = 0; foreach($rekap_penilaian_tpp['mdisker'] as $md){
                    $color = '000000';
                    if($rs['rekap'][$md['keterangan']]['total'] == 0){
                        $color = '#dfe2e5';
                    }
                ?>
                    <td style="text-align: center; color: <?=$color?>" rowspan="1" colspan="1"><?=$rs['rekap'][$md['keterangan']]['total']?></td>
                <?php } ?>
                <td style="text-align: center;"><?=formatTwoMaxDecimal($rs['rekap']['presentase_kehadiran']).'%'?></td>
            </tr>
        <?php }
            $total_presentase_kehadiran = $total_presentase_kehadiran / (count($rekap_penilaian_tpp['result']));
        ?>
        <tr>
            <td style="text-align: left;" colspan="27"><strong>RATA-RATA PRESENTASE KEHADIRAN</strong></td>
            <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($total_presentase_kehadiran).' %'?></strong></td>
        </tr>
    </tbody>
</table>