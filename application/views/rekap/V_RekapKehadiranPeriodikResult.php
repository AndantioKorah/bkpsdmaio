<style>
    .text-nama{
        font-size: 1rem;
        color: black;
        font-weight: bold;
    }

    .text-etc{
        font-size: .75rem;
        color: #676a6a;
        /* font-weight: bold; */
    }

    th{
        font-size: .75rem;
    }

    .classNotZero{
        /* color: black; */
        opacity: 1;
        font-weight: bold;
    }

    .classZero{
        /* color: grey; */
        opacity: .3;
    }

    /* Styles for .tr_data elements when they ARE hovered (optional, but often used for contrast) */
    .tr_data:hover {
        background-color: #9afded !important;
        transition: .2s;
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h3>REKAP KEHADIRAN PERIODIK</h3>
        <?php
            $periode = "Tahun ".$params['tahun'];
            if($params['bulan'] != 0){
                $periode = "Periode:  ".getNamaBulan($params['bulan'])." ".$params['tahun'];
            }

            $uker = "Semua Unit Kerja";
            if($params['skpd'] != 0){
                $explodeUk = explode(";", $params['skpd']);
                $uker = $explodeUk[1];
            }
        ?>
        <h3><?=$uker?></h3>
        <h4><?=$periode?></h4>
        <br>
        <input type="text" class="cd-search table-filter" data-table="table_result" placeholder="Cari Pegawai" />
        <div class="div_freeze_table">
            <table style="width: 2000px; margin-top : -10px" border="1" id="table_result" class="table_result table-sm cd-table table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">No</th>
                        <th rowspan="2" class="text-center">Pegawai</th>
                        <?php if($params['skpd'] == 0){ ?>
                            <th rowspan="2" class="text-center">Unit Kerja</th>
                        <?php } ?>
                        <th rowspan="1" colspan=18 class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" class="text-center">TMK 1</th>
                        <th rowspan="1" colspan="1" class="text-center">TMK 2</th>
                        <th rowspan="1" colspan="1" class="text-center">TMK 3</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 1</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 2</th>
                        <th rowspan="1" colspan="1" class="text-center">PKSW 3</th>
                        <?php foreach($jenisdisiplin as $jd){ ?>
                            <th rowspan="1" colspan="1" class="text-center"><?=$jd['keterangan']?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result){ $no = 1; foreach($result as $rs){
                        $bgTr = "white;";
                        if($rs['rekap']['TK'] >= 3){
                            $bgTr = "#fdf59a;";
                        }

                        if($rs['rekap']['TK'] >= 10){
                            $bgTr = "#f8b057;";
                        }

                        if($rs['rekap']['TK'] >= 28){
                            $bgTr = "#ff707d;";
                        }
                    ?>
                        <tr onclick="openDetail('<?=$rs['id_m_user']?>')" class="tr_data" style="background-color: <?=$bgTr?>; cursor: pointer;">
                            <td class="text-center"><?=$no++;?></td>
                            <td style="background-color: <?=$bgTr?>;" class="text-left tr_data">
                                <span class="text-nama"><?=getNamaPegawaiFull($rs)?></span><br>
                                <span class="text-etc">NIP. <?=$rs['nipbaru_ws']?></span><br>
                                <span class="text-etc"><?=$rs['nm_pangkat']?></span><br>
                                <span class="text-etc"><?=$rs['nama_jabatan']?></span>
                            </td>
                            <?php if($params['skpd'] == 0){ ?>
                                <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                            <?php } ?>
                            <td class="text-center <?=$rs['rekap']['tmk1'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['tmk1']?></td>
                            <td class="text-center <?=$rs['rekap']['tmk2'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['tmk2']?></td>
                            <td class="text-center <?=$rs['rekap']['tmk3'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['tmk3']?></td>
                            <td class="text-center <?=$rs['rekap']['pksw1'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['pksw1']?></td>
                            <td class="text-center <?=$rs['rekap']['pksw2'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['pksw2']?></td>
                            <td class="text-center <?=$rs['rekap']['pksw3'] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap']['pksw3']?></td>
                            <?php foreach($jenisdisiplin as $jd){ ?>
                                <td class="text-center <?=$rs['rekap'][$jd['keterangan']] > 0 ? 'classNotZero' : 'classZero'?>"><?=$rs['rekap'][$jd['keterangan']]?></td>
                            <?php } ?>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        fixedHeaderTable()
        // $('#table_result').dataTable()
    })

    function openDetail(id){
        alert(id)
    }
</script>