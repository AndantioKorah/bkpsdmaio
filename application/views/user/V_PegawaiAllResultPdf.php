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

        #body_download_database{
        }
    </style>
    <body id="body_download_database" style="font-family: Tahoma;">
        <?php
            $this->load->view('adminkit/partials/V_HeaderRekapAbsen', '');
        ?>
        <b><center>DAFTAR NOMINATIF<br></center><b>
        <table border=1 style="width: 100%; border-collapse: collapse; padding: 3px; margin-top: 10px;" id="result_all_pegawai">
            <tr>
                <td style="font-weight: bold; text-align: center;">No</td>
                <td style="font-weight: bold; text-align: center;">Pegawai</td>
                <td style="font-weight: bold; text-align: center;">Eselon</td>
                <td style="font-weight: bold; text-align: center;">Unit Kerja</td>
                <td style="font-weight: bold; text-align: center;">NIK</td>
                <td style="font-weight: bold; text-align: center;">No. HP</td>
                <td style="font-weight: bold; text-align: center;">Email</td>
            </tr>
            <tbody>
                <?php if($result){ $no=1; foreach($result as $rs){
                    $nama_jabatan = $rs['nama_jabatan'];
                    if($rs['jenis_plt_plh'] && $rs['jabatan'] == $rs['id_jabatan_plt_plh']){
                        $nama_jabatan = $rs['jenis_plt_plh'].". ".$rs['nama_jabatan'];
                    }
                ?>
                    <tr>
                        <td style="padding: 5px; text-align: center;"><?=$no++?></td>
                        <td style="padding: 5px; text-align: left;">
                            <span style="font-weight: bold; color: black !important;" class="fw-bold namapegawai"><?=getNamaPegawaiFull($rs)?></span><br>
                            <span><?=$nama_jabatan?></span><br>
                            <span><?=$rs['nm_pangkat']?></span><br>
                            <span><?="NIP. ".($rs['nipbaru_ws'])?></span><br>
                        </td>
                        <td style="padding: 5px; text-align: center;"><?=$rs['eselon']?></td>
                        <td style="padding: 5px; text-align: center;"><?=$rs['nm_unitkerja']?></td>
                        <td style="padding: 5px; text-align: center;"><?=$rs['nik']?></td>
                        <td style="padding: 5px; text-align: center;"><?=$rs['handphone']?></td>
                        <td style="padding: 5px; text-align: center;"><?=$rs['email']?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </body>
</html>