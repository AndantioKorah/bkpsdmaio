<div class="row">
    <div class="col-lg-12 table-responsive">
        <table id="result_table" class="table table-striped table-hover">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Verifikator</th>
                <th class="text-center">Total Verifikasi</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $max = 0; $no = 1; foreach($result as $rs){ 
                    if($no == 1){
                        if($rs['total_verif'] > 0){
                            $max = $rs['total_verif'];
                        }
                    }
                    if($max > 0){
                        $presentase = ($rs['total_verif'] / $max) * 100;
                    } else {
                        $presentase = 0;
                    }
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama_pegawai']?></td>
                        <td class="text-center">
                            <span style="color: black; font-weight: bold !important;"><?=formatCurrencyWithoutRp($rs['total_verif'], 0)?></span>
                            <div class="progress progress-sm" style="height: 1rem !important; border-radius: 10px;">
                                <div class="progress-bar" role="progressbar"
                                    aria-valuenow="<?=$presentase?>" aria-valuemin="0" 
                                    aria-valuemax="<?=$max?>" 
                                    style="width: <?=formatTwoMaxDecimal($presentase)?>%; 
                                    background-color: <?=getProgressBarColor($presentase)?>;">
                                </div>
                            </div>
                        </td>
                        <td class="text-center"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#result_table').dataTable()
    })
</script>