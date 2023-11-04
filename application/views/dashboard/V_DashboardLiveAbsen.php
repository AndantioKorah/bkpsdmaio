<style>
    .lbl_under_nama{
        font-size: 1rem;
        font-weight: bold;
        color: grey;
    }

    table, thead, th, tr, td{
        border: 1px solid black;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h4>LIVE ABSEN</h4>
        <h2><?=$agenda['judul']?></h2>
        <h4><?=formatDateNamaBulan($agenda['tgl'])?></h4>
    </div>
</div>
<table class="table table_dashboard_live">
    <thead>
        <th class="text-center">No</th>
        <th colspan=2 class="text-left">Nama</th>
        <!-- <th class="text-center">Eselon</th> -->
        <th class="text-left">Jabatan</th>
        <th class="text-center">Absen</th>
    </thead>
    <tbody>
        <?php if($result){ ?>
            <?php $no=1; foreach($result as $rs){ ?>   
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <!-- <td colspan=1 style="border: 0px !important;">
                        asdasdsa
                    </td> -->
                    <td colspan=2 class="text-left">
                        <span style="color: black; font-size: 1.3rem; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
                        <span class="lbl_under_nama"><?=formatNip($rs['nip'])?></span><br>
                        <span class="lbl_under_nama"><?=($rs['nm_pangkat'])?></span>
                    </td>
                    <!-- <td class="text-center"><?=$rs['eselon']?></td> -->
                    <td class="text-left">
                        <span style="font-size: 1.3rem; font-weight: bold;"><?=$rs['nama_jabatan']?></span><br>
                        <span style="font-size: 1.3rem; font-weight: 500;"><?=$rs['nm_unitkerja']?></span>
                    </td>
                    <td style="font-size: 1.3rem;" class="text-center fw-bold"><?=$rs['pulang'] ? $rs['pulang'] : $rs['masuk']?></td>
                    <!-- <td class="text-center fw-bold"><?=$rs['pulang'] ? countDiffDateLengkap(date('Y-m-d H:i:s'), $rs['pulang'], ['menit']) : countDiffDateLengkap(date('Y-m-d H:i:s'), $rs['masuk'], ['menit'])?> yang lalu</td> -->
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<script>
    $(function(){
        // $('.table_dashboard_live').dataTable()
    })
</script>