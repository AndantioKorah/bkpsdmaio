<div class="row p-3">
    <div class="col-lg-12 text-right mb-3">
        <button class="btn btn-success"><i class="fa fa-check"></i> VALIDASI</button>
    </div>
    <?php if($result){ ?>
        <div class="col-lg-12">
            <iframe src="<?=$url?>" style="width: 100%; height: 75vh;"></i>
        </div>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <h5 style="font-style: italic;">FILE TIDAK DITEMUKAN</h5>
        </div>
    <?php } ?>
</div>