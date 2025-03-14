<style>
    .body_berkas_tpp_download{
        font-family: Tahoma;
    }

    .berkas_tpp_download_nama_pegawai{
        /* font-size: 14px; */
        font-weight: bold;
    }
    
    span{
        font-size: 16px !important;
    }
</style>
<html>
    <body>
        <div class="body_berkas_tpp_download">
            <?php $this->load->view('adminkit/partials/V_HeaderRekapAbsen', null) ?>
            <div style="page-break-after: always;" class="div_rekap_kehadiran">
                <?php 
                    $data_header['filename'] = 'REKAPITULASI KEHADIRAN PEGAWAI';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $data_header['flag_bagian'] = $pegawai['flag_bagian'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
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
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kasubag'];
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['kepsek'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kasubag'];
                        $data_header['kasubag'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_rekap_penilaian_disiplin_kerja">
                <?php 
                    $data_header['filename'] = 'REKAPITULASI PENILAIAN DISIPLIN KERJA';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table style="border-collapse: collapse;" border=1>
                    <thead>
                        <tr>
                            <th style="text-align: center;  width: 3%;" rowspan="2">No</th>
                            <th style="text-align: center;  z-index: 400; width: 20%;" rowspan="2">Nama Pegawai</td>
                            <th style="text-align: center;  width: 3%;" rowspan="2">JHK</td>
                            <th style="text-align: center;  width: 8%;" rowspan="2">TARGET CAP. PEN. DISIPLIN KERJA</th>
                            <th style="text-align: center; " rowspan="1" colspan="<?=count($rekap_penilaian_tpp['mdisker'])?>">Keterangan</th>
                            <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN PENILAIAN DISIPLIN KERJA</th>
                            <th style="text-align: center;  width: 8%;" rowspan="2">CAPAIAN BOBOT PENILAIAN DISIPLIN KERJA</td>
                        </tr>
                        <tr >
                            <?php foreach($rekap_penilaian_tpp['mdisker'] as $m){ ?>
                                <th style="text-align: center; " rowspan="1" colspan="1"><?=STRTOUPPER($m['keterangan'])?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($rekap_penilaian_tpp['result'] as $rs){
                            $capaian = 0;
                            $capaian_bobot = 0;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?=$no++;?></td>
                                <td style="padding-top: 15px; padding: 5px;">
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$rs['nama_pegawai']?></span><br>
                                    <span style="">NIP. <?=$rs['nip']?></span>
                                </td>
                                <td style="width: 6%; text-align: center;"><?=$rs['rekap']['jhk']?></td>
                                <td style="width: 6%; text-align: center;"><?=TARGET_PENILAIAN_DISIPLIN_KERJA.'%'?></td>
                                <?php $temp_capaian = 0; foreach($rekap_penilaian_tpp['mdisker'] as $md){
                                    $color = '000000';
                                    if($rs['rekap'][$md['keterangan']]['pengurangan'] == 0){
                                        $color = '#dfe2e5';
                                    }
                                ?>
                                    <td style="text-align: center; color: <?=$color?>" rowspan="1" colspan="1"><?=$rs['rekap'][$md['keterangan']]['pengurangan'].'%'?></td>
                                <?php } ?>
                                <td style="text-align: center;"><?=$rs['rekap']['capaian_disiplin_kerja'].'%'?></td>
                                <td style="text-align: center;"><?=$rs['rekap']['capaian_bobot_disiplin_kerja'].'%'?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kasubag'];
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['kepsek'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kasubag'];
                        $data_header['kasubag'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_rekap_penilaian_produktivitas_kerja">
                <?php 
                    $data_header['filename'] = 'REKAPITULASI PRODUKTIVITAS KERJA';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table border="1" style="border-collapse: collapse">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;" rowspan="2">No</th>
                            <th style="text-align: center;z-index: 400; width: 10%;" rowspan="2">Nama Pegawai</th>
                            <th style="text-align: center;" rowspan="2">Target Bobot Produktivitas Kerja</th>
                            <th style="text-align: center;" rowspan="1" colspan="2">Penilaian Sasaran Kerja Bulanan Pegawai</th>
                            <th style="text-align: center;" rowspan="1" colspan="9">Penilaian Komponen Kinerja</th>
                            <th style="text-align: center;" rowspan="2">Capaian Bobot Produktivitas Kerja</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" rowspan="1" colspan="1">% Capaian</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Berorientasi Pelayanan</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Akuntabel</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Kompeten</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Harmonis</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Loyal</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Adaptif</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Kolaboratif</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Nilai Capaian</th>
                            <th style="text-align: center;" rowspan="1" colspan="1">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($rekap_penilaian_tpp['result'] as $rs){
                            $bobot_capaian_produktivitas = isset($rs['kinerja']) && $rs['kinerja'] ? $rs['kinerja']['rekap_kinerja']['bobot'] : 0;
                            if(isset($rs['komponen_kinerja'])){
                                $bobot_capaian_produktivitas += $rs['komponen_kinerja'][1];
                            }
                        ?>
                            <tr >
                                <td  style="text-align: center;"><?=$no++;?></td>
                                <td scope="row" style="padding-top: 5px; padding-bottom: 5px;">
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$rs['nama_pegawai']?></span><br>
                                    NIP. <?=$rs['nip']?>
                                </td>
                                <td style="width: 6%; text-align: center;"><?=TARGET_BOBOT_PRODUKTIVITAS_KERJA.'%'?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['capaian']) : 0;?>%</td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['kinerja']) && $rs['kinerja'] ? formatTwoMaxDecimal($rs['kinerja']['rekap_kinerja']['bobot']) : 0;?>%</td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['berorientasi_pelayanan'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['akuntabel'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['kompeten'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['harmonis'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['loyal'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['adaptif'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? $rs['komponen_kinerja']['list']['kolaboratif'] : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? ($rs['komponen_kinerja'][0]) : 0;?></td>
                                <td style="width: 6%; text-align: center;"><?=isset($rs['komponen_kinerja']) ? formatTwoMaxDecimal($rs['komponen_kinerja'][1]) : 0;?>%</td>
                                <td style="width: 6%; text-align: center;"><?=formatTwoMaxDecimal($bobot_capaian_produktivitas)?>%</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kasubag'];
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['kepsek'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kasubag'];
                        $data_header['kasubag'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_rekap_penilaian_tpp">
                <?php 
                    $data_header['filename'] = 'REKAPITULASI PENILAIAN TPP';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table style="border-collapse: collapse" border="1">
                    <thead>
                        <tr >
                            <th style="text-align: center; width: 5%" rowspan="1">No</th>
                            <th style="text-align: center; width: 10%; z-index: 400;" rowspan="1">Nama Pegawai</td>
                            <th style="text-align: center; width: 17%;"  rowspan="1">% PENILAIAN SASARAN KERJA BULANAN PEGAWAI</td>
                            <th style="text-align: center; width: 17%;"  rowspan="1">% PENILAIAN KOMPONEN KINERJA</td>
                            <th style="text-align: center; width: 17%;"  rowspan="1">% CAPAIAN PRODUKTIFITAS KERJA</td>
                            <th style="text-align: center; width: 17%;"  rowspan="1">% CAPAIAN PENILAIAN DISIPLIN KERJA</td>
                            <th style="text-align: center; width: 17%; " rowspan="1">% TOTAL PENILAIAN TPP</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($rekap_penilaian_tpp['result'] as $rs){
                            $nilai_komponen_kinerja = isset($rs['komponen_kinerja'][1]) ? $rs['komponen_kinerja'][1] : 0;
                            $bobot_rekap_kinerja = isset($rs['kinerja']) && $rs['kinerja'] ? $rs['kinerja']['rekap_kinerja']['bobot'] : 0; 
                            $capaian_produktivitas_kerja = floatval($bobot_rekap_kinerja) + floatval($nilai_komponen_kinerja);
                            $total_penilaian_tpp = $capaian_produktivitas_kerja + floatval($rs['rekap']['capaian_bobot_disiplin_kerja']);
                            if($rs['rekap']['presentase_kehadiran'] < 25){
                                $total_penilaian_tpp = 0;
                            } else if($rs['rekap']['presentase_kehadiran'] >= 25 && $rs['rekap']['presentase_kehadiran'] < 50){
                                $total_penilaian_tpp *= 0.5;
                            }
                        ?>
                            <tr>
                                <td style="text-align: center;"><?=$no++;?></td>
                                <td>
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$rs['nama_pegawai']?></span><br>
                                    <span style="">NIP. <?=$rs['nip']?></span>
                                </td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($bobot_rekap_kinerja).'%'?></td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($nilai_komponen_kinerja).'%'?></td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($capaian_produktivitas_kerja).'%'?></td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($rs['rekap']['capaian_bobot_disiplin_kerja']).'%'?></td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($total_penilaian_tpp).'%'?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kasubag'];
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['kepsek'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kasubag'];
                        $data_header['kasubag'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_rekap_perhitungan_tpp">
                <?php 
                    $data_header['filename'] = 'DAFTAR PERHITUNGAN TAMBAHAN PENGHASILAN PEGAWAI';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table border=1 style="border-collapse: collapse;">
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
                            $potongan_pajak_keseluruhan += pembulatan($r['nominal_pph']);
                            $jumlah_setelah_pajak_keseluruhan += ($r['tpp_diterima']);

                            $jumlah_bobot_produktivitas_kerja += $r['bobot_produktivitas_kerja'];
                            $jumlah_bobot_disiplin_kerja += $r['bobot_disiplin_kerja'];
                        ?>
                            <tr>
                                <td style="text-align: center;"><?=$no++;?></td>
                                <td style="text-align: left;">
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$r['nama_pegawai']?></span><br>
                                    <span>NIP. <?=($r['nip'])?></span><br>
                                </td>
                                <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['pagu_tpp'], 0)?></td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                                <td style="text-align: center;"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                <td style="text-align: center;">
                                    <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                </td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_diterima']), 0)?></td>
                            </tr>
                        <?php }
                        $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                        $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);

                        $jumlah_setelah_pajak_keseluruhan = (pembulatan($jumlah_capaian_keseluruhan) - pembulatan($potongan_pajak_keseluruhan));
                        ?>
                        <tr>
                            <td style="text-align: center;" colspan=2><strong>JUMLAH</strong></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew($pagu_keseluruhan, 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_produktivitas, 0).' %'?></strong></td>
                            <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_disiplin, 0).' %'?></strong></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['bendahara'];
                    $data_header['flag_bendahara'] = 1;
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kadis'];
                    }
                    // dd($data_header);
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_daftar_permintaan">
                <?php 
                    $data_header['filename'] = 'DAFTAR PERMINTAAN TPP';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table border=1 style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th rowspan=2 style="text-align: center;">No</th>
                            <th rowspan=2 style="text-align: center;">Pegawai</th>
                            <th rowspan=2 style="text-align: center;">Gol</th>
                            <th rowspan=2 style="text-align: center;">Jabatan</th>
                            <th rowspan=2 style="text-align: center;">Kelas Jabatan</th>
                            <th rowspan=2 style="text-align: center;">ESS</th>
                            <th rowspan=2 style="text-align: center;">Jumalah Capaian TPP (Rp)</th>
                            <th rowspan=1 colspan=2 style="text-align: center;">Potongan PPh</th>
                            <th rowspan=2 style="text-align: center;">Jumlah Setelah Dipotong Pph (Rp)</th>
                            <th rowspan=2 style="text-align: center;">Gaji (Rp)</th>
                            <th rowspan=2 style="text-align: center;">BPJS (1%)</th>
                            <th rowspan=2 style="text-align: center;">Jumlah TPP yg Diterima</th>
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
                        $jumlah_gaji = 0;
                        $jumlah_bpjs = 0;
                        $jumlah_tpp_diterima = 0;

                        foreach($result as $r){
                            $pagu_keseluruhan += $r['pagu_tpp'];
                            $jumlah_capaian_keseluruhan += $r['besaran_tpp'];
                            $potongan_pajak_keseluruhan += pembulatan($r['nominal_pph']);
                            $jumlah_setelah_pajak_keseluruhan += $r['tpp_diterima'];
                            $jumlah_gaji += $r['besaran_gaji'] ? $r['besaran_gaji'] : 0;
                            $jumlah_bpjs += pembulatan($r['bpjs']);
                            $jumlah_tpp_diterima += pembulatan($r['tpp_final']);
                        ?>
                            <tr>
                                <td style="text-align: center;"><?=$no++;?></td>
                                <td style="text-align: left;">
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$r['nama_pegawai']?></span><br>
                                    <span><?=($r['nip'])?></span><br>
                                </td>
                                <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                                <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                <td style="text-align: center;"><?=$r['eselon']?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                <td style="text-align: center;">
                                    <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                </td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_diterima']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_gaji'] ? $r['besaran_gaji'] : 0), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                            </tr>
                        <?php }
                        $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                        $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);

                        $jumlah_setelah_pajak_keseluruhan = (pembulatan($jumlah_capaian_keseluruhan) - pembulatan($potongan_pajak_keseluruhan));
                        $jumlah_tpp_diterima = pembulatan($jumlah_setelah_pajak_keseluruhan) - pembulatan($jumlah_bpjs);
                        ?>
                        <tr>
                            <td style="text-align: center;" colspan=2><strong>JUMLAH</strong></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_gaji), 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_bpjs), 0)?></strong></td>
                            <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_tpp_diterima), 0)?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['bendahara'];
                    $data_header['flag_bendahara'] = 1;
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_bagian'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['setda'];
                        $data_header['kasubag'] = $pegawai['bendahara_setda'];
                    }
                    // dd($data_header);
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_daftar_permintaan_bkad">
                <?php 
                    $data_header['filename'] = 'DAFTAR PERMINTAAN TPP (BKAD)';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                    $colspan_pph = 4;
                    $colspan_bpjs = 3;
                    $colspan_jumlah_setelah_pph = 3;

                    // if($flag_simplified_format == 1){
                    //     $colspan_pph = 1;
                    //     $colspan_bpjs = 1;
                    //     $colspan_jumlah_setelah_pph = 1;
                    // }
                ?>
                <table border=1 style="border-collapse: collapse;" class="table table-hover table-striped">
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
                            <th rowspan=1 colspan=<?=$colspan_pph?> style="text: align: center;">Potongan PPh</th>
                            <th rowspan=1 colspan=<?=$colspan_jumlah_setelah_pph?> style="text: align: center;">Jumlah Setelah Dipotong PPh</th>
                            <th rowspan=2 style="text: align: center;">Gaji (Rp)</th>
                            <th rowspan=1 colspan=<?=$colspan_bpjs?> style="text: align: center;">BPJS 1% (TPP)</th>
                            <th rowspan=1 colspan=4 style="text: align: center;">TPP Yang Diterima</th>
                        </tr>
                        <tr>
                            <!-- pph -->
                            <th rowspan=1 colspan=1 style="text: align: center;">%</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                            <!-- jumlah setelah dipotong pph -->
                            <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                            <!-- bpjs -->
                            <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                            <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                            <!-- tpp yang diterima -->
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
                            $bpjs_prestasi_kerja += excelRoundDown($r['bpjs_prestasi_kerja'], 1);
                            $bpjs_beban_kerja += excelRoundDown($r['bpjs_beban_kerja'], 1);
                            $bpjs_kondisi_kerja += excelRoundDown($r['bpjs_kondisi_kerja'], 1);
                            $tpp_final_prestasi_kerja += $r['tpp_final_prestasi_kerja'];
                            $tpp_final_beban_kerja += $r['tpp_final_beban_kerja'];
                            $tpp_final_kondisi_kerja += $r['tpp_final_kondisi_kerja'];
                            $tpp_final_permintaan_bkad += $r['tpp_final'];
                            $total_besaran_gaji += $r['besaran_gaji'] ? $r['besaran_gaji'] : 0;
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
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['besaran_tpp'], 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_prestasi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_beban_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_kondisi_kerja']), 0)?></td>
                                <td style="text-align: center;">
                                    <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                </td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_prestasi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_beban_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_kondisi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_prestasi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_beban_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_kondisi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['besaran_gaji'] ? $r['besaran_gaji'] : 0, 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_prestasi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_beban_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_kondisi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_prestasi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_beban_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_kondisi_kerja']), 0)?></td>
                                <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                                <!-- <td style="text-align: right;"><?=$r['tpp_final_permintaan_bkad'] != $r['tpp_final'] ? 'ini' : formatCurrencyWithoutRpNew($r['tpp_final_permintaan_bkad'], 0)?></td> -->

                            </tr>
                        <?php }
                        // $tpp_final_permintaan_bkad = $jumlah_tpp_diterima;
                        $total_pph_prestasi_kerja = 
                            pembulatan($potongan_pajak_keseluruhan) -
                            (pembulatan($total_pph_kondisi_kerja) +
                            pembulatan($total_pph_beban_kerja));

                        $total_jumlah_setelah_pph_prestasi_kerja = 
                            pembulatan($jumlah_setelah_pajak_keseluruhan) -
                            (pembulatan($total_jumlah_setelah_pph_beban_kerja) +
                            pembulatan($total_jumlah_setelah_pph_kondisi_kerja));

                        $bpjs_prestasi_kerja = 
                            pembulatan($jumlah_bpjs) -
                            (pembulatan($bpjs_beban_kerja) +
                            pembulatan($bpjs_kondisi_kerja));

                        $tpp_final_prestasi_kerja = 
                            pembulatan($tpp_final_permintaan_bkad) -
                            (pembulatan($tpp_final_beban_kerja) +
                            pembulatan($tpp_final_kondisi_kerja));

                        $total_capaian_tpp_prestasi_kerja = 
                            pembulatan($total_capaian_tpp) -
                            (pembulatan($total_capaian_tpp_beban_kerja) +
                            pembulatan($total_capaian_tpp_kondisi_kerja));
                        
                        ?>
                        <tr>
                            <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_capaian_tpp_prestasi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_beban_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_kondisi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_pph_prestasi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_beban_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_kondisi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_beban_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_kondisi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew($total_besaran_gaji, 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($bpjs_prestasi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_beban_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_kondisi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($tpp_final_prestasi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_beban_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_kondisi_kerja), 0)?></td>
                            <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_permintaan_bkad), 0)?></td>
                        </tr>
                        <?php if($this->general_library->isProgrammer()){ ?>
                            <tr>
                                <td colspan=7 style="text-align: center; font-weight: bold;">TOTAL</td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja), 0)?></td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja?></td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja), 0)?></td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=$bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja?></td>
                                <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_prestasi_kerja?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_beban_kerja?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_kondisi_kerja?></td>
                                <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_beban_kerja + $tpp_final_kondisi_kerja + $tpp_final_prestasi_kerja), 0)?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['bendahara'];
                    $data_header['flag_bendahara'] = 1;
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_bagian'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['setda'];
                        $data_header['kasubag'] = $pegawai['bendahara_setda'];
                    }
                    // dd($data_header);
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_daftar_pembayaran">
                <?php 
                    $data_header['filename'] = 'DAFTAR PEMBAYARAN TPP';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                    <table border=1 style="border-collapse: collapse;" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th rowspan=2 style="text: align: center;">No</th>
                                <th rowspan=2 style="text: align: center;">Nama / NIP</th>
                                <th rowspan=2 style="text: align: center;">Gol / Rg</th>
                                <th rowspan=2 style="text: align: center;">Jabatan</th>
                                <th rowspan=2 style="text: align: center;">Kls. Jab.</th>
                                <th rowspan=2 style="text: align: center;">Ess</th>
                                <th rowspan=2 style="text-align: center">Jumlah TPP yang dicapai (Rp)</th>
                                <th rowspan=1 colspan=2 style="text-align: center">Potongan PPh</th>
                                <th rowspan=2 style="text-align: center">BPJS (1%) TPP</th>
                                <th rowspan=2 style="text-align: center">Jumlah yg Diterima</th>
                            </tr>
                            <tr>
                                <th rowspan=1 colspan=1 style="text-align: center">%</th>
                                <th rowspan=1 colspan=1 style="text-align: center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $total_jumlah_yang_dicapai = 0;
                            $total_potongan_pph = 0;
                            $total_bpjs = 0;
                            $total_jumlah_yang_diterima = 0;

                            foreach($result as $r){
                                $total_jumlah_yang_dicapai += $r['besaran_tpp'];
                                $total_potongan_pph += pembulatan($r['nominal_pph']);
                                $total_bpjs += pembulatan($r['bpjs']);
                                $total_jumlah_yang_diterima += pembulatan($r['tpp_final']);
                            ?>
                                <tr>
                                    <td style="text-align: center"><?=$no++;?></td>
                                    <td style="text-align: left">
                                        <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                                        <span class="text-data-pegawai"><?=($r['nip'])?></span><br>
                                    </td>
                                    <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                    <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                                    <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                    <td style="text-align: center;"><?=$r['eselon']?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                    <td style="text-align: center">
                                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                    </td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                    <?php // if($this->general_library->isProgrammer()){ ?>
                                        <!-- <td style="text-align: right;"><?=($r['bpjs'])?></td> -->
                                    <?php // } else { ?>
                                        <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs']), 0)?></td>
                                    <?php // } ?>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                                </tr>
                            <?php }
                            // $total_jumlah_yang_diterima = $jumlah_tpp_diterima;
                            ?>
                            <tr>
                                <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_yang_dicapai), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_potongan_pph), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_bpjs), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_yang_diterima), 0)?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['bendahara'];
                    $data_header['flag_bendahara'] = 1;
                    if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_puskesmas'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                    } else if($pegawai['flag_bagian'] == 1){
                        $data_header['kepalaskpd'] = $pegawai['setda'];
                        $data_header['kasubag'] = $pegawai['bendahara_setda'];
                    }
                    // dd($data_header);
                    $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                ?>
            </div>
            <div style="page-break-after: always;" class="div_surat_pengantar">
                <?php
                    $rekap['jumlah_pajak_pph'] = $potongan_pajak_keseluruhan;
                    $rekap['bpjs'] = $jumlah_bpjs;
                    $rekap['jumlah_yang_diterima'] = $total_jumlah_yang_diterima;
                    $rekap['selisih_capaian_pagu'] = $rekap['pagu_tpp'] - pembulatan($rekap['jumlah_pajak_pph']) - pembulatan($rekap['bpjs']) - pembulatan($rekap['jumlah_yang_diterima']);

                    $data_rekap['result'] = $result;
                    $data_rekap['rekap'] = $rekap;
                    $data_rekap['hukdis'] = $hukdis;
                    $data_rekap['kepalabkpsdm'] = $pegawai['kepalaskpd'];
                    if($pegawai['flag_puskesmas'] == 1){
                        $data_rekap['kepalabkpsdm'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalabkpsdm'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_SuratPengantar', $data_rekap);
                ?>
            </div>
            <div style="<?=$pppk ? 'page-break-after: always;' : '' ?>" class="div_salinan_surat_pengantar">
                <?php
                    $data_rekap['result'] = $result;
                    $data_rekap['rekap'] = $rekap;
                    $data_rekap['hukdis'] = $hukdis;
                    $data_rekap['kepalabkpsdm'] = $pegawai['kepalaskpd'];
                    if($pegawai['flag_puskesmas'] == 1){
                        $data_rekap['kepalabkpsdm'] = $pegawai['kapus'];
                    } else if($pegawai['flag_rs'] == 1){
                        $data_header['kepalabkpsdm'] = $pegawai['kadis'];
                    }
                    $this->load->view('rekap/V_SalinanSuratPengantar', $data_rekap);
                ?>
            </div>
            <?php if($pppk){ $result = $pppk;
            ?>
                <div style="page-break-after: always;" class="div_rekap_perhitungan_tpp">
                    <?php 
                        $data_header['filename'] = 'DAFTAR PERHITUNGAN TAMBAHAN PENGHASILAN PEGAWAI';
                        $data_header['skpd'] = $param['nm_unitkerja'];
                        $data_header['bulan'] = $param['bulan'];
                        $data_header['tahun'] = $param['tahun'];
                        $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                    ?>
                    <table border=1 style="border-collapse: collapse;">
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
                                    <td style="text-align: center;"><?=$no++;?></td>
                                    <td style="text-align: left;">
                                        <span class="berkas_tpp_download_nama_pegawai"><?=$r['nama_pegawai']?></span><br>
                                        <span>NIP. <?=($r['nip'])?></span><br>
                                    </td>
                                    <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                    <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['pagu_tpp'], 0)?></td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                    <td style="text-align: center;">
                                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                    </td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_diterima']), 0)?></td>
                                </tr>
                            <?php }
                            $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                            $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);
                            ?>
                            <tr>
                                <td style="text-align: center;" colspan=2><strong>JUMLAH</strong></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew($pagu_keseluruhan, 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_produktivitas, 0).' %'?></strong></td>
                                <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_disiplin, 0).' %'?></strong></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                        $data_header['flag_bendahara'] = 1;
                        if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_puskesmas'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_rs'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['kadis'];
                        }
                        // dd($data_header);
                        $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                    ?>
                </div>
                <div style="page-break-after: always;" class="div_daftar_permintaan">
                    <?php 
                        $data_header['filename'] = 'DAFTAR PERMINTAAN TPP';
                        $data_header['skpd'] = $param['nm_unitkerja'];
                        $data_header['bulan'] = $param['bulan'];
                        $data_header['tahun'] = $param['tahun'];
                        $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                    ?>
                    <table border=1 style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th rowspan=2 style="text-align: center;">No</th>
                                <th rowspan=2 style="text-align: center;">Pegawai</th>
                                <th rowspan=2 style="text-align: center;">Gol</th>
                                <th rowspan=2 style="text-align: center;">Jabatan</th>
                                <th rowspan=2 style="text-align: center;">Kelas Jabatan</th>
                                <th rowspan=2 style="text-align: center;">ESS</th>
                                <th rowspan=2 style="text-align: center;">Jumalah Capaian TPP (Rp)</th>
                                <th rowspan=1 colspan=2 style="text-align: center;">Potongan PPh</th>
                                <th rowspan=2 style="text-align: center;">Jumlah Setelah Dipotong Pph (Rp)</th>
                                <th rowspan=2 style="text-align: center;">Gaji (Rp)</th>
                                <th rowspan=2 style="text-align: center;">BPJS (1%)</th>
                                <th rowspan=2 style="text-align: center;">Jumlah TPP yg Diterima</th>
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
                            $jumlah_gaji = 0;
                            $jumlah_bpjs = 0;
                            $jumlah_tpp_diterima = 0;

                            foreach($result as $r){
                                $pagu_keseluruhan += $r['pagu_tpp'];
                                $jumlah_capaian_keseluruhan += $r['besaran_tpp'];
                                $potongan_pajak_keseluruhan += pembulatan($r['nominal_pph']);
                                $jumlah_setelah_pajak_keseluruhan += $r['tpp_diterima'];
                                $jumlah_gaji += $r['besaran_gaji'] ? $r['besaran_gaji'] : 0;
                                $jumlah_bpjs += pembulatan($r['bpjs']);
                                $jumlah_tpp_diterima += pembulatan($r['tpp_final']);
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?=$no++;?></td>
                                    <td style="text-align: left;">
                                        <span class="berkas_tpp_download_nama_pegawai"><?=$r['nama_pegawai']?></span><br>
                                        <span><?=($r['nip'])?></span><br>
                                    </td>
                                    <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                    <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                                    <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                    <td style="text-align: center;"><?=$r['eselon']?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                    <td style="text-align: center;">
                                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                    </td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_diterima']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_gaji'] ? $r['besaran_gaji'] : 0), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                                </tr>
                            <?php }
                            $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                            $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);

                            $jumlah_setelah_pajak_keseluruhan = (pembulatan($jumlah_capaian_keseluruhan) - pembulatan($potongan_pajak_keseluruhan));
                            $jumlah_tpp_diterima = pembulatan($jumlah_setelah_pajak_keseluruhan) - pembulatan($jumlah_bpjs);
                            ?>
                            <tr>
                                <td style="text-align: center;" colspan=2><strong>JUMLAH</strong></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_gaji), 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_bpjs), 0)?></strong></td>
                                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRpNew(pembulatan($jumlah_tpp_diterima), 0)?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                        $data_header['flag_bendahara'] = 1;
                        if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_puskesmas'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_bagian'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['setda'];
                            $data_header['kasubag'] = $pegawai['bendahara_setda'];
                        }
                        // dd($data_header);
                        $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                    ?>
                </div>
                <div style="page-break-after: always;" class="div_daftar_permintaan_bkad">
                    <?php 
                        $data_header['filename'] = 'DAFTAR PERMINTAAN TPP (BKAD)';
                        $data_header['skpd'] = $param['nm_unitkerja'];
                        $data_header['bulan'] = $param['bulan'];
                        $data_header['tahun'] = $param['tahun'];
                        $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                        $colspan_pph = 4;
                        $colspan_bpjs = 3;
                        $colspan_jumlah_setelah_pph = 3;

                        // if($flag_simplified_format == 1){
                        //     $colspan_pph = 1;
                        //     $colspan_bpjs = 1;
                        //     $colspan_jumlah_setelah_pph = 1;
                        // }
                    ?>
                    <table border=1 style="border-collapse: collapse;" class="table table-hover table-striped">
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
                                <th rowspan=1 colspan=<?=$colspan_pph?> style="text: align: center;">Potongan PPh</th>
                                <th rowspan=1 colspan=<?=$colspan_jumlah_setelah_pph?> style="text: align: center;">Jumlah Setelah Dipotong PPh</th>
                                <th rowspan=2 style="text: align: center;">Gaji (Rp)</th>
                                <th rowspan=1 colspan=<?=$colspan_bpjs?> style="text: align: center;">BPJS 1% (TPP)</th>
                                <th rowspan=1 colspan=4 style="text: align: center;">TPP Yang Diterima</th>
                            </tr>
                            <tr>
                                <!-- pph -->
                                <th rowspan=1 colspan=1 style="text: align: center;">%</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                                <!-- jumlah setelah dipotong pph -->
                                <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                                <!-- bpjs -->
                                <th rowspan=1 colspan=1 style="text: align: center;">Prestasi Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Beban Kerja</th>
                                <th rowspan=1 colspan=1 style="text: align: center;">Kondisi Kerja</th>
                                <!-- tpp yang diterima -->
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
                                $bpjs_prestasi_kerja += excelRoundDown($r['bpjs_prestasi_kerja'], 1);
                                $bpjs_beban_kerja += excelRoundDown($r['bpjs_beban_kerja'], 1);
                                $bpjs_kondisi_kerja += excelRoundDown($r['bpjs_kondisi_kerja'], 1);
                                $tpp_final_prestasi_kerja += $r['tpp_final_prestasi_kerja'];
                                $tpp_final_beban_kerja += $r['tpp_final_beban_kerja'];
                                $tpp_final_kondisi_kerja += $r['tpp_final_kondisi_kerja'];
                                $tpp_final_permintaan_bkad += $r['tpp_final'];
                                $total_besaran_gaji += $r['besaran_gaji'] ? $r['besaran_gaji'] : 0;
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
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['besaran_tpp'], 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_prestasi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_beban_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['capaian_tpp_kondisi_kerja']), 0)?></td>
                                    <td style="text-align: center;">
                                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                    </td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_prestasi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_beban_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['pph_kondisi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_prestasi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_beban_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['jumlah_setelah_pph_kondisi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew($r['besaran_gaji'] ? $r['besaran_gaji'] : 0, 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_prestasi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_beban_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs_kondisi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_prestasi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_beban_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final_kondisi_kerja']), 0)?></td>
                                    <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                                    <!-- <td style="text-align: right;"><?=$r['tpp_final_permintaan_bkad'] != $r['tpp_final'] ? 'ini' : formatCurrencyWithoutRpNew($r['tpp_final_permintaan_bkad'], 0)?></td> -->

                                </tr>
                            <?php }
                            // $tpp_final_permintaan_bkad = $jumlah_tpp_diterima;
                            $total_pph_prestasi_kerja = 
                                pembulatan($potongan_pajak_keseluruhan) -
                                (pembulatan($total_pph_kondisi_kerja) +
                                pembulatan($total_pph_beban_kerja));

                            $total_jumlah_setelah_pph_prestasi_kerja = 
                                pembulatan($jumlah_setelah_pajak_keseluruhan) -
                                (pembulatan($total_jumlah_setelah_pph_beban_kerja) +
                                pembulatan($total_jumlah_setelah_pph_kondisi_kerja));

                            $bpjs_prestasi_kerja = 
                                pembulatan($jumlah_bpjs) -
                                (pembulatan($bpjs_beban_kerja) +
                                pembulatan($bpjs_kondisi_kerja));

                            $tpp_final_prestasi_kerja = 
                                pembulatan($tpp_final_permintaan_bkad) -
                                (pembulatan($tpp_final_beban_kerja) +
                                pembulatan($tpp_final_kondisi_kerja));

                            $total_capaian_tpp_prestasi_kerja = 
                                pembulatan($total_capaian_tpp) -
                                (pembulatan($total_capaian_tpp_beban_kerja) +
                                pembulatan($total_capaian_tpp_kondisi_kerja));
                            
                            ?>
                            <tr>
                                <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_capaian_tpp_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_beban_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_kondisi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_pph_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_beban_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_kondisi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_beban_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_kondisi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew($total_besaran_gaji, 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($bpjs_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_beban_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_kondisi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(($tpp_final_prestasi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_beban_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_kondisi_kerja), 0)?></td>
                                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_permintaan_bkad), 0)?></td>
                            </tr>
                            <?php if($this->general_library->isProgrammer()){ ?>
                                <tr>
                                    <td colspan=7 style="text-align: center; font-weight: bold;">TOTAL</td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja), 0)?></td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja?></td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja), 0)?></td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja?></td>
                                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja), 0)?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_prestasi_kerja?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_beban_kerja?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_kondisi_kerja?></td>
                                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($tpp_final_beban_kerja + $tpp_final_kondisi_kerja + $tpp_final_prestasi_kerja), 0)?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                        $data_header['flag_bendahara'] = 1;
                        if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_puskesmas'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_bagian'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['setda'];
                            $data_header['kasubag'] = $pegawai['bendahara_setda'];
                        }
                        // dd($data_header);
                        $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                    ?>
                </div>
                <div style="page-break-after: always;" class="div_daftar_pembayaran">
                    <?php 
                        $data_header['filename'] = 'DAFTAR PEMBAYARAN TPP';
                        $data_header['skpd'] = $param['nm_unitkerja'];
                        $data_header['bulan'] = $param['bulan'];
                        $data_header['tahun'] = $param['tahun'];
                        $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                    ?>
                        <table border=1 style="border-collapse: collapse;" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th rowspan=2 style="text: align: center;">No</th>
                                    <th rowspan=2 style="text: align: center;">Nama / NIP</th>
                                    <th rowspan=2 style="text: align: center;">Gol / Rg</th>
                                    <th rowspan=2 style="text: align: center;">Jabatan</th>
                                    <th rowspan=2 style="text: align: center;">Kls. Jab.</th>
                                    <th rowspan=2 style="text: align: center;">Ess</th>
                                    <th rowspan=2 style="text-align: center">Jumlah TPP yang dicapai (Rp)</th>
                                    <th rowspan=1 colspan=2 style="text-align: center">Potongan PPh</th>
                                    <th rowspan=2 style="text-align: center">BPJS (1%) TPP</th>
                                    <th rowspan=2 style="text-align: center">Jumlah yg Diterima</th>
                                </tr>
                                <tr>
                                    <th rowspan=1 colspan=1 style="text-align: center">%</th>
                                    <th rowspan=1 colspan=1 style="text-align: center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $total_jumlah_yang_dicapai = 0;
                                $total_potongan_pph = 0;
                                $total_bpjs = 0;
                                $total_jumlah_yang_diterima = 0;

                                foreach($result as $r){
                                    $total_jumlah_yang_dicapai += $r['besaran_tpp'];
                                    $total_potongan_pph += pembulatan($r['nominal_pph']);
                                    $total_bpjs += pembulatan($r['bpjs']);
                                    $total_jumlah_yang_diterima += pembulatan($r['tpp_final']);
                                ?>
                                    <tr>
                                        <td style="text-align: center"><?=$no++;?></td>
                                        <td style="text-align: left">
                                            <span style="font-size: 14px; font-weight: bold"><?=$r['nama_pegawai']?></span><br>
                                            <span class="text-data-pegawai"><?=($r['nip'])?></span><br>
                                        </td>
                                        <td style="text-align: center;"><?=$r['nomor_golongan']?></td>
                                        <td style="text-align: center;"><?=$r['nama_jabatan']?></td>
                                        <td style="text-align: center;"><?=$r['kelas_jabatan']?></td>
                                        <td style="text-align: center;"><?=$r['eselon']?></td>
                                        <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['besaran_tpp']), 0)?></td>
                                        <td style="text-align: center">
                                            <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                                        </td>
                                        <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['nominal_pph']), 0)?></td>
                                        <?php // if($this->general_library->isProgrammer()){ ?>
                                            <!-- <td style="text-align: right;"><?=($r['bpjs'])?></td> -->
                                        <?php // } else { ?>
                                            <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['bpjs']), 0)?></td>
                                        <?php // } ?>
                                        <td style="text-align: right;"><?=formatCurrencyWithoutRpNew(pembulatan($r['tpp_final']), 0)?></td>
                                    </tr>
                                <?php }
                                // $total_jumlah_yang_diterima = $jumlah_tpp_diterima;
                                ?>
                                <tr>
                                    <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_yang_dicapai), 0)?></td>
                                    <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_potongan_pph), 0)?></td>
                                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_bpjs), 0)?></td>
                                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRpNew(pembulatan($total_jumlah_yang_diterima), 0)?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php
                        $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                        $data_header['kasubag'] = $pegawai['bendahara'];
                        $data_header['flag_bendahara'] = 1;
                        if($pegawai['flag_sekolah'] == 1){ // jika sekolah, yang TTD 
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_puskesmas'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                            $data_header['kasubag'] = $pegawai['bendahara'];
                        } else if($pegawai['flag_bagian'] == 1){
                            $data_header['kepalaskpd'] = $pegawai['setda'];
                            $data_header['kasubag'] = $pegawai['bendahara_setda'];
                        }
                        // dd($data_header);
                        $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
                    ?>
                </div>
                <div style="page-break-after: always;" class="div_surat_pengantar">
                    <?php
                        $rekap_pppk['jumlah_pajak_pph'] = $potongan_pajak_keseluruhan;
                        $rekap_pppk['bpjs'] = $jumlah_bpjs;
                        $rekap_pppk['jumlah_yang_diterima'] = $total_jumlah_yang_diterima;
                        $rekap_pppk['selisih_capaian_pagu'] = $rekap_pppk['pagu_tpp'] - pembulatan($rekap_pppk['jumlah_pajak_pph']) - pembulatan($rekap_pppk['bpjs']) - pembulatan($rekap_pppk['jumlah_yang_diterima']);
                        $rekap_pppk['unitkerja'] = $rekap['unitkerja'];
                        $rekap_pppk['flag_pppk'] = 1;

                        $data_rekap['result'] = $result;
                        $data_rekap['rekap'] = $rekap_pppk;
                        $data_rekap['hukdis'] = $hukdis;
                        $data_rekap['kepalabkpsdm'] = $pegawai['kepalaskpd'];
                        if($pegawai['flag_puskesmas'] == 1){
                            $data_rekap['kepalabkpsdm'] = $pegawai['kapus'];
                        } else if($pegawai['flag_rs'] == 1){
                            $data_header['kepalabkpsdm'] = $pegawai['kadis'];
                        }
                        $this->load->view('rekap/V_SuratPengantar', $data_rekap);
                    ?>
                </div>
                <div class="div_salinan_surat_pengantar">
                    <?php
                        $data_rekap['result'] = $result;
                        $data_rekap['rekap'] = $rekap_pppk;
                        $data_rekap['hukdis'] = $hukdis;
                        $data_rekap['kepalabkpsdm'] = $pegawai['kepalaskpd'];
                        if($pegawai['flag_puskesmas'] == 1){
                            $data_rekap['kepalabkpsdm'] = $pegawai['kapus'];
                        } else if($pegawai['flag_rs'] == 1){
                            $data_header['kepalabkpsdm'] = $pegawai['kadis'];
                        }
                        $this->load->view('rekap/V_SalinanSuratPengantar', $data_rekap);
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </body>
</html>