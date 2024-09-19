<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>
<html>
    <head>
        <body>
            <table style="width: 100%; border-collapse: collapse;" border=1>
                <thead>
                    <th style="width: 5%;text-align: center">No</th>
                    <th style="width: 15%;text-align: center">Nama Pegawai</th>
                    <th style="width: 20%;text-align: center">Jumlah TPP</th>
                    <th style="width: 20%;text-align: center">Jumlah Potongan BPJS</th>
                    <th style="width: 20%;text-align: center">Jumlah Pajak</th>
                    <th style="width: 20%;text-align: center">Jumlah yang Diterima</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td style="text-align: center"><?=$no++;?></td>
                            <td style="text-algign: left"><?=($rs['nama_pegawai'])?></td>
                            <!-- <td style="text-align: right;"><?=formatCurrency($rs['besaran_tpp'], 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['nominal_pph']), 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['bpjs']), 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['tpp_final']), 0)?></td> -->
                            <td style="text-align: right;"><?=($rs['besaran_tpp'])?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['nominal_pph']))?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['bpjs']))?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['tpp_final']))?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </body>
    </head>
</html>