<style>
    thead:hover{
        cursor: pointer;
    }

    tbody:hover{
        cursor: pointer;
    }

    .small_text_pegawai{
        font-size: 12px;
        font-weight: 500;
        margin-top: -10px;
    }
</style>
<?php if($result){ ?>
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover table-striped" style="width: 100%;">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Pegawai</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Kelas Jabatan</th>
                <th class="text-center">Pagu TPP</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td style="vertical-align: middle;" class="text-center"><?=$no++;?></td>
                        <td style="vertical-align: middle;" class="text-left">
                            <b><?=getNamaPegawaiFull($rs)?></b>
                            <br>
                            <span class="small_text_pegawai"><?=formatNip($rs['nipbaru_ws'])?></span>
                            <br>
                            <span class="small_text_pegawai"><?=$rs['nm_pangkat']?></span>
                        </td>
                        <td style="vertical-align: middle;" class="text-left"><?=($rs['nama_jabatan'])?></td>
                        <td style="vertical-align: middle;" class="text-center"><?=$rs['kelas_jabatan']?></td>
                        <td style="vertical-align: middle;" class="text-center"><?=formatCurrency($rs['pagu_tpp'])?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="col-lg-12 text-center"><h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5></div>
<?php } ?>