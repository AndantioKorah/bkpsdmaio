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
                            <td style="text-align: center;"><?=$rs['rekap']['presentase_kehadiran'].'%'?></td>
                        </tr>
                    <?php }
                        $total_presentase_kehadiran = $total_presentase_kehadiran / count($result);
                    ?>
                    <tr>
                        <td style="text-align: left;" colspan="26"><strong>RATA-RATA PRESENTASE KEHADIRAN</strong></td>
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
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kapus'];
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
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kapus'];
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
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kapus'];
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
                    $data_header['kepalaskpd'] = $pegawai['kepalaskpd'];
                    $data_header['kasubag'] = $pegawai['kapus'];
                }
                $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
            ?>
        </div>
        <div class="div_rekap_perhitungan_tpp">
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
                            <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['pagu_tpp'], 0)?></td>
                            <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                            <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                            <td style="text-align: center;"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                            <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['besaran_tpp'], 0)?></td>
                            <td style="text-align: center;">
                                <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                            </td>
                            <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['nominal_pph'], 0)?></td>
                            <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['tpp_diterima'], 0)?></td>
                        </tr>
                    <?php }
                    $rata_rata_bobot_produktivitas = $jumlah_bobot_produktivitas_kerja / count($result);
                    $rata_rata_bobot_disiplin = $jumlah_bobot_disiplin_kerja / count($result);
                    ?>
                    <tr>
                        <td style="text-align: center;" colspan=2><strong>JUMLAH</strong></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp($pagu_keseluruhan, 0)?></strong></td>
                        <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_produktivitas, 0).' %'?></strong></td>
                        <td style="text-align: center;"><strong><?=formatTwoMaxDecimal($rata_rata_bobot_disiplin, 0).' %'?></strong></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp($jumlah_capaian_keseluruhan, 0)?></strong></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp($potongan_pajak_keseluruhan, 0)?></strong></td>
                        <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp($jumlah_setelah_pajak_keseluruhan, 0)?></strong></td>
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
                }
                // dd($data_header);
                $this->load->view('rekap/V_BerkasTppDownloadFooter', $data_header);
            ?>
        </div>
    </div>
</html>