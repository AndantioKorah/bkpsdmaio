<?php if($result){ ?>
    <div class="row p-3" style="
        border: 1px solid grey;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    ">
        <div class="col-lg-9 text-left">
            <?php if($result['fa_icon']){?>
                <i class="<?=$result['fa_icon']?> fa-2x" style="color: <?=$result['icon_color']?>"></i>
            <?php } ?>
            <h3><?=($result['judul_notifikasi'])?></h3>
        </div>
        <div class="col-lg-3 text-right text-muted">
            <?=formatDateNotifikasi($result['created_date'])?>
        </div>
        <div class="col-lg-12 mt-3">
            <h4><?=$result['pesan']?></h4>
        </div>
    </div>
<?php } ?>