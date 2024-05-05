<center>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%; text-align: center;">
                <span style="font-size: 12px;">Mengetahui,</span>
                <table style="width: 100%;">
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
                </table>
            </td>
            <td valign="top" style="text-align: center;">
                <span style="font-size: 12px;">Manado, <?=formatDateNamaBulan(date('Y-m-d'))?></span>
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center;"><?=$kasubag['nama_jabatan'].','?></td>
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
                </table>
            </td>
        </tr>
    </table>
</center>