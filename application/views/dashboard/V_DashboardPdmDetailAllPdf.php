<html>
    <body style="font-family: Tahoma;">
        <?php
            $this->load->view('adminkit/partials/V_HeaderRekapAbsen', '');
        ?>
        <div style="margin-top: 10px; margin-bottom: 5px; text-align: center; font-weight: bold">
            <h2>PROGRES PENDATAAN DATA MANDIRI</h2>
            <h4><?=formatDateNamaBulanWT(date('Y-m-d H:i:s'))?></h4>
        </div>
        <table style="width: 100%; border-collapse: collapse;" border=1>
            <tr>
                <td style="font-weight: bold; text-align: center; width: 5%;">No</td>
                <td style="font-weight: bold; text-align: left; width: 65%;">Perangkat Daerah</td>
                <td style="font-weight: bold; text-align: center; width: 10%;">Jumlah Pegawai</td>
                <td style="font-weight: bold; text-align: center; width: 20%;">Progress</td>
            </tr>
            <tbody>
                <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td style="text-align: center"><?=$no++;?></td>
                        <td style="text-align: left"><?=$rs['nm_unitkerja'];?></td>
                        <td style="text-align: center"><?=formatCurrencyWithoutRp($rs['jumlah_pegawai'], 0)?></td>
                        <td style="text-align: center; background-color: <?=getProgressBarColor($rs['presentase'])?>; color: white; font-weight: bold;">
                            <span style="font-weight: bold !important;"><?=formatTwoMaxDecimal($rs['presentase']).' %'?></span>
                        </td>
                    </tr>
                <?php } } ?>
                </tbody>
        </table>
    </body>
</html>