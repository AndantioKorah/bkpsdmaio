<?php
    $filename = 'DATA ASN Kota Manado.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
?>

<html>
    <style>
        .badge-cpns{
        /* box-shadow: 3px 3px 10px #888888; */
        background-color: #ed1818;
        border: 2px solid #ed1818;
        color: white;
        }

        .badge-pppk{
        /* box-shadow: 3px 3px 10px #888888; */
        background-color: #8f8657;
        border: 2px solid #8f8657;
        color: white;
        }

        .namapegawai:hover{
            cursor:pointer;
            text-decoration: underline;
            color: #17a2b8 !important;
        }
    </style>
    <body style="font-family: Tahoma;">
        <?php
            // $this->load->view('adminkit/partials/V_HeaderRekapAbsen', '');
        ?>
        <table border=1 style="width: 100%; border-collapse: collapse; padding: 3px; margin-top: 10px;" id="result_all_pegawai">
            <tr>
                <td style="font-weight: bold; text-align: center; width: 10%;">No</td>
                <td style="font-weight: bold; text-align: center; width: 30%;">Pegawai</td>
                <td style="font-weight: bold; text-align: center; width: 15%;">Eselon</td>
                <td style="font-weight: bold; text-align: center; width: 25%;">Pangkat</td>
                <?php if($use_masa_kerja == 1){ ?>
                    <td style="font-weight: bold; text-align: center;">Masa Kerja</td>
                <?php } ?>
                <td style="font-weight: bold; text-align: center; width: 20%;">Unit Kerja</td>
            </tr>
            <tbody>
                <?php if($result){ $no=1; foreach($result as $rs){ ?>
                    <tr>
                        <td style="padding: 10px; text-align: center;"><?=$no++?></td>
                        <td style="padding: 10px; text-align: left;">
                            <span class="fw-bold namapegawai">
                                <a target="_blank" style="font-weight: bold; color: black !important;" href="<?=base_url('kepegawaian/profil-pegawai/'.$rs['nipbaru_ws'])?>"><?=getNamaPegawaiFull($rs)?></a>
                            </span><br>
                            <span><?=($rs['nama_jabatan'])?></span><br>
                            <span><?="NIP. ".formatNip($rs['nipbaru_ws'])?></span><br>
                            <?php if($rs['id_statuspeg'] == 1){ ?>
                                <span class="badge badge-cpns"><?=$rs['nm_statuspeg']?></span>
                            <?php } else if($rs['id_statuspeg'] == 3){ ?>
                                <span class="badge badge-pppk"><?=$rs['nm_statuspeg']?></span>
                            <?php } ?>
                        </td>
                        <td style="padding: 10px; text-align: center;"><?=$rs['eselon']?></td>
                        <td style="padding: 10px; text-align: left;"><?=$rs['nm_pangkat']?></td>
                        <?php if($use_masa_kerja == 1){ ?>
                            <td style="padding: 10px; text-align: center;"><?=$rs['masa_kerja']?></td>
                        <?php } ?>
                        <td style="padding: 10px; text-align: left;"><?=$rs['nm_unitkerja']?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </body>
</html>