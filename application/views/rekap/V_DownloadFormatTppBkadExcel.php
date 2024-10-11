<?php
    if(!$this->general_library->isProgrammer()){
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
    }

?>
<html>
    <head>
        <body>
            <table style="width: 100%; border-collapse: collapse;" border=1>
                <thead>
                    <th style="width: 5%;text-align: center">No</th>
                    <th style="width: 15%;text-align: center">Nama Pegawai</th>
                    <th style="width: 15%;text-align: center">NIP</th>
                    <th style="width: 20%;text-align: center">Jumlah TPP</th>
                    <th style="width: 20%;text-align: center">Jumlah Potongan BPJS</th>
                    <th style="width: 20%;text-align: center">Jumlah Pajak</th>
                    <th style="width: 20%;text-align: center">Jumlah yang Diterima</th>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $total_potongan_pph = 0;
                    $total_bpjs = 0;
                    $total_jumlah_yang_diterima = 0;
                    $total_besaran_tpp = 0;

                    foreach($result as $rs){
                        $total_potongan_pph += $rs['nominal_pph'];
                        $total_bpjs += ($rs['bpjs']);
                        // $total_jumlah_yang_diterima += $rs['tpp_final'];
                        $total_besaran_tpp += $rs['besaran_tpp'];
                    ?>
                        <tr>
                            <td style="text-align: center"><?=$no++;?></td>
                            <td style="text-algign: left"><?=($rs['nama_pegawai'])?></td>
                            <td style="text-algign: left">`<?=($rs['nip'])?></td>
                            <!-- <td style="text-align: right;"><?=formatCurrency($rs['besaran_tpp'], 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['nominal_pph']), 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['bpjs']), 0)?></td> -->
                            <!-- <td style="text-align: right;"><?=formatCurrency(pembulatan($rs['tpp_final']), 0)?></td> -->
                            <td style="text-align: right;"><?=($rs['besaran_tpp'])?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['bpjs']))?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['nominal_pph']))?></td>
                            <td style="text-align: right;"><?=(pembulatan($rs['tpp_final']))?></td>
                    </tr>
                    <?php }
                        $total_jumlah_yang_diterima = pembulatan($total_besaran_tpp) - pembulatan($total_bpjs) - pembulatan($total_potongan_pph);
                    ?>
                    <tr>
                        <td style="font-weight: bold; text-align: center;" colspan=3>TOTAL</td>
                        <td style="font-weight: bold; text-align: right"><?=pembulatan($total_besaran_tpp)?></td>
                        <td style="font-weight: bold; text-align: right"><?=pembulatan($total_bpjs)?></td>
                        <td style="font-weight: bold; text-align: right"><?=pembulatan($total_potongan_pph)?></td>
                        <td style="font-weight: bold; text-align: right"><?=pembulatan($total_jumlah_yang_diterima)?></td>
                    </tr>
                </tbody>
            </table>
        </body>
    </head>
</html>