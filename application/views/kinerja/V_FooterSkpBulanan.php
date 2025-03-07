<?php if($flag_komponen_kinerja){ ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; text-align: center;">
                Pegawai Yang Dinilai,
            </td>
            <td style="width: 50%; text-align: center;">
                Pejabat Penilai,
            </td>
        </tr>
        <tr>
            <td><br><br><br></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <u><?=strtoupper(getNamaPegawaiFull($pegawai))?></u><br>
                NIP. <?=formatNip($pegawai['nipbaru_ws'])?>
            </td>
            <td style="width: 50%; text-align: center;">
                <u><?=strtoupper(getNamaPegawaiFull($atasan_pegawai))?></u><br>
                NIP. <?=formatNip($atasan_pegawai['nipbaru_ws'])?>
            </td>
        </tr>
    </table>
    <center>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 100%; text-align: center;">Menyetujui,</td>
            </tr>
           
            <?php  if($atasan_pegawai['id_unitkerja'] == "3017000") { ?>
            <tr>
                <!-- <td style="width: 100%; text-align: center;">Kepala Perangkat Daerah</td> -->
                <td style="width: 100%; text-align: center;">Plt. Kepala Dinas Komunikasi dan Informatika</td>
            </tr>
            <tr>
                <td><br><br><br></td>
            </tr>
            <?php // if($atasan_pegawai['nipbaru_ws'] != $kepala_pd['nipbaru_ws']){ ?>
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <u>Reintje Abraham Heydemans, SE, M.Si</u><br>
                        NIP. 19660619 199003 1 009
                    </td>
                </tr>
            <?php // } ?>
            <?php } else {
                $menyetujui = $kepala_pd;
                if($kepala_pd['nipbaru_ws'] == $pegawai['nipbaru_ws']){
                    $menyetujui = $atasan_pegawai;
                }
            ?>
                <tr>
                <!-- <td style="width: 100%; text-align: center;">Kepala Perangkat Daerah</td> -->
                <td style="width: 100%; text-align: center;">
                    <?=$menyetujui['nama_jabatan']?>
                </td>
            </tr>
            <tr>
                <td><br><br><br></td>
            </tr>
            <?php // if($atasan_pegawai['nipbaru_ws'] != $kepala_pd['nipbaru_ws']){ ?>
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <u><?=strtoupper(getNamaPegawaiFull($menyetujui))?></u><br>
                        NIP. <?=formatNip($menyetujui['nipbaru_ws'])?>
                    </td>
                </tr>
            <?php // } ?>
            <?php  } ?>

        </table>
    </center>
<?php } else { ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; text-align: center;">
                Atasan Langsung,
            </td>
            <td style="width: 50%; text-align: center;">
                Pegawai Yang Bersangkutan,
            </td>
        </tr>
        <tr>
            <td><br><br><br></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <u><?=strtoupper(getNamaPegawaiFull($atasan_pegawai))?></u><br>
                NIP. <?=formatNip($atasan_pegawai['nipbaru_ws'])?>
            </td>
            <td style="width: 50%;" class="text-center">
                <u><?=strtoupper(getNamaPegawaiFull($pegawai))?></u><br>
                NIP. <?=formatNip($pegawai['nipbaru_ws'])?>
            </td>
        </tr>
    </table>
<?php } ?>