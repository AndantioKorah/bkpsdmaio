<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>

<html>
    <head>
    </head>
    <body>
        <table border=1 style="width: 100%; border-collapse: collapse;">
            <thead>
                <th style="text-align: center; width: 5%;">No</th>
                <th style="text-align: center; width: 40%;">NIP</th>
                <th style="text-align: center; width: 15%;">Gaji</th>
                <th style="text-align: center; width: 40%;">Keterangan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td style="text-align: center;"><?=$no++;?></td>
                        <td style="text-align: left;"><?=($rs['nip'])?></td>
                        <td style="text-align: left;"><?=formatCurrencyWithoutRp($rs['gaji'])?></td>
                        <td style="text-align: left;"><?=$rs['keterangan']?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>