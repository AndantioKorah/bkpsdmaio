<center>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%; text-align: center;">
                <span style="font-size: 12px;">Mengetahui,</span>
                <table style="width: 100%;">
                    <?php if($kepalaskpd){ ?>
                        <tr>
                            <td style="text-align: center;"><?=$kepalaskpd['nama_jabatan'].','?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 30px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=getNamaPegawaiFull($kepalaskpd)?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=($kepalaskpd['nm_pangkat'])?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?="NIP. ".$kepalaskpd['nipbaru_ws']?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan=5 style="text-align: center;">(Data Kepala SKPD Tidak Ada)</td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td valign="top" style="text-align: center;">
                <span style="font-size: 12px;">Manado, <?=formatDateNamaBulan(date('Y-m-d'))?></span>
                <table style="width: 100%;">
                    <?php if(isset($flag_bagian) && $flag_bagian == 1){
                        if(isset($flag_bendahara) && $flag_bendahara == 1){
                    ?>
                        <tr>
                            <td style="text-align: center;"><?=isset($flag_bendahara) && $flag_bendahara == 1 ? 'Bendahara' : $kasubag['nama_jabatan'].','?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 30px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=getNamaPegawaiFull($kasubag)?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=($kasubag['nm_pangkat'])?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?="NIP. ".$kasubag['nipbaru_ws']?></td>
                        </tr>
                    <?php } } else if($kasubag){ ?>
                        <tr>
                            <td style="text-align: center;"><?=isset($flag_bendahara) && $flag_bendahara == 1 ? 'Bendahara' : $kasubag['nama_jabatan'].','?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding: 30px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=getNamaPegawaiFull($kasubag)?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?=($kasubag['nm_pangkat'])?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><?="NIP. ".$kasubag['nipbaru_ws']?></td>
                        </tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan=5 style="text-align: center;">(Data Tidak Ditemukan)</td>
                    </tr>
                <?php } ?>
                </table>
            </td>
        </tr>
    </table>
</center>