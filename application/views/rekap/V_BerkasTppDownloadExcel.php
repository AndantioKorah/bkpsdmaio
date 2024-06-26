<!DOCTYPE html>
    <body>
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

            td, th{
                width: 25px !important;
                height: 10px !important;
            }
        </style>
        <div class="body_berkas_tpp_download">
            <div style="page-break-after: always;" class="div_rekap_kehadiran">
                <?php 
                    $data_header['filename'] = 'REKAPITULASI KEHADIRAN PEGAWAI';
                    $data_header['skpd'] = $param['nm_unitkerja'];
                    $data_header['bulan'] = $param['bulan'];
                    $data_header['tahun'] = $param['tahun'];
                    $data_header['flag_bagian'] = $pegawai['flag_bagian'];
                    // $this->load->view('rekap/V_BerkasTppDownloadHeader', $data_header);
                ?>
                <table border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="1" style="text-align: center; " rowspan="2">No</th>
                            <th colspan="1" style="text-align: center;  z-index: 400;" rowspan="2">Nama Pegawai</th>
                            <th colspan="1" style="text-align: center;"  rowspan="2">Gol/Ruang</th>
                            <th colspan="1" style="text-align: center;"  rowspan="2">Jabatan</th>
                            <th colspan="1" style="text-align: center;"  rowspan="2">Ess</th>
                            <th colspan="1" style="text-align: center;"  rowspan="2">Kelas Jabatan</th>
                            <th colspan="1" style="text-align: center; " rowspan="2">JHK</th>
                            <th colspan="1" style="text-align: center; " rowspan="2">TARGET CAP. PEN. DISIPLIN KERJA</th>
                            <th style="text-align: center; " rowspan="1" colspan="<?=count($rekap_penilaian_tpp['mdisker'])?>">Keterangan</th>
                            <th colspan="1" style="text-align: center; " rowspan="2">% H</th>
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
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$no++;?></td>
                                <td rowspan="1" colspan="1" style="padding-top: 5px; padding: 5px;">
                                    <span class="berkas_tpp_download_nama_pegawai"><?=$rs['nama_pegawai']?></span><br>
                                    <span style="">NIP. <?=$rs['nip']?></span>
                                </td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$rs['golongan']?></td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$rs['nama_jabatan']?></td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$rs['eselon']?></td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$rs['kelas_jabatan']?></td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=$rs['rekap']['jhk']?></td>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=TARGET_PENILAIAN_DISIPLIN_KERJA.'%'?></td>
                                <?php $temp_capaian = 0; foreach($rekap_penilaian_tpp['mdisker'] as $md){
                                    $color = '000000';
                                    if($rs['rekap'][$md['keterangan']]['total'] == 0){
                                        $color = '#dfe2e5';
                                    }
                                ?>
                                    <td style="text-align: center; color: <?=$color?>" rowspan="1" colspan="1"><?=$rs['rekap'][$md['keterangan']]['total']?></td>
                                <?php } ?>
                                <td rowspan="1" colspan="1" style="text-align: center;"><?=formatTwoMaxDecimal($rs['rekap']['presentase_kehadiran']).'%'?></td>
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
        </div>
    </body>
</html>