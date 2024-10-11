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
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['pagu_tpp'], 0)?></td>
                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_produktivitas_kerja'])?> %</td>
                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['bobot_disiplin_kerja'])?> %</td>
                    <td style="text-align: center;"><?=formatTwoMaxDecimal($r['presentase_tpp'])?> %</td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['besaran_tpp']), 0)?></td>
                    <td style="text-align: center;">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['nominal_pph']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_diterima']), 0)?></td>
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
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
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
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['besaran_tpp']), 0)?></td>
                    <td style="text-align: center;">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['nominal_pph']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_diterima']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['besaran_gaji'] ? $r['besaran_gaji'] : 0), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final']), 0)?></td>
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
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_capaian_keseluruhan), 0)?></strong></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($potongan_pajak_keseluruhan), 0)?></strong></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_setelah_pajak_keseluruhan), 0)?></strong></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_gaji), 0)?></strong></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_bpjs), 0)?></strong></td>
                <td style="text-align: center;"><strong><?=formatCurrencyWithoutRp(pembulatan($jumlah_tpp_diterima), 0)?></strong></td>
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
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['besaran_tpp'], 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_prestasi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_beban_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['capaian_tpp_kondisi_kerja']), 0)?></td>
                    <td style="text-align: center;">
                        <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                    </td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_prestasi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_beban_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['pph_kondisi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_prestasi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_beban_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['jumlah_setelah_pph_kondisi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp($r['besaran_gaji'] ? $r['besaran_gaji'] : 0, 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs_prestasi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs_beban_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs_kondisi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final_prestasi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final_beban_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final_kondisi_kerja']), 0)?></td>
                    <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final']), 0)?></td>
                    <!-- <td style="text-align: right;"><?=$r['tpp_final_permintaan_bkad'] != $r['tpp_final'] ? 'ini' : formatCurrencyWithoutRp($r['tpp_final_permintaan_bkad'], 0)?></td> -->

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
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(($total_capaian_tpp_prestasi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_beban_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_kondisi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(($total_pph_prestasi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_beban_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_kondisi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(($total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_beban_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_kondisi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp($total_besaran_gaji, 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(($bpjs_prestasi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_beban_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_kondisi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(($tpp_final_prestasi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($tpp_final_beban_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($tpp_final_kondisi_kerja), 0)?></td>
                <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($tpp_final_permintaan_bkad), 0)?></td>
            </tr>
            <?php if($this->general_library->isProgrammer()){ ?>
                <tr>
                    <td colspan=7 style="text-align: center; font-weight: bold;">TOTAL</td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_capaian_tpp_beban_kerja + $total_capaian_tpp_kondisi_kerja + $total_capaian_tpp_prestasi_kerja), 0)?></td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja?></td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_pph_beban_kerja + $total_pph_kondisi_kerja + $total_pph_prestasi_kerja), 0)?></td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_setelah_pph_beban_kerja + $total_jumlah_setelah_pph_kondisi_kerja + $total_jumlah_setelah_pph_prestasi_kerja), 0)?></td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=$bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja?></td>
                    <td colspan=2 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($bpjs_beban_kerja + $bpjs_kondisi_kerja + $bpjs_prestasi_kerja), 0)?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_prestasi_kerja?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_beban_kerja?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=$tpp_final_kondisi_kerja?></td>
                    <td colspan=1 style="text-align: center; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($tpp_final_beban_kerja + $tpp_final_kondisi_kerja + $tpp_final_prestasi_kerja), 0)?></td>
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
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['besaran_tpp']), 0)?></td>
                        <td style="text-align: center">
                            <?= $r['pph'] > 0 ? $r['pph'].'%' : ''; ?>
                        </td>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['nominal_pph']), 0)?></td>
                        <?php // if($this->general_library->isProgrammer()){ ?>
                            <!-- <td style="text-align: right;"><?=($r['bpjs'])?></td> -->
                        <?php // } else { ?>
                            <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['bpjs']), 0)?></td>
                        <?php // } ?>
                        <td style="text-align: right;"><?=formatCurrencyWithoutRp(pembulatan($r['tpp_final']), 0)?></td>
                    </tr>
                <?php }
                // $total_jumlah_yang_diterima = $jumlah_tpp_diterima;
                ?>
                <tr>
                    <td colspan=6 style="text-align: center; font-weight: bold;">JUMLAH</td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_yang_dicapai), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_potongan_pph), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_bpjs), 0)?></td>
                    <td colspan=1 style="text-align: right; font-weight: bold;"><?=formatCurrencyWithoutRp(pembulatan($total_jumlah_yang_diterima), 0)?></td>
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
<div class="div_salinan_surat_pengantar">
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