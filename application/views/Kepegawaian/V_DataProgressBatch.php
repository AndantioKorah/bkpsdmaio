<div class="col-lg-12">
    <table class="table table-hover table-striped">
        <thead>
            <th style="width: 10%;" class="text-center">No</th>
            <th style="width: 20%;" class="text-center">Batch Number</th>
            <th class="text-center">Progress</th>
        </thead>
        <tbody>
            <?php if($result){ $no = 1;
                foreach($result as $rs){
                $progress_target = (floatval($rs['done']) / floatval($rs['total'])) * 100;
                $progress_target = formatTwoMaxDecimal($progress_target);
            ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-center"><?=$rs['random_string']?></td>
                    <td class="text-center">
                        <span style="text-weight: bold; color: black;"><?=$rs['done'].' / '.$rs['total']?></span>
                        <div class="progress progress-sm" style="height: 24px !important; border-radius: 10px;">
                            <div class="progress-bar" role="progressbar"
                                aria-valuenow="<?=$progress_target?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$progress_target?>"
                                style="width: <?=$progress_target == 0 ? 0 : $progress_target?>%; background-color: <?=getProgressBarColor($progress_target)?>;">
                            <p style="margin-top: 15px;" class="text-progress"><?=$progress_target.'%'?></p>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>