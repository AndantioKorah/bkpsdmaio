<style>
    .span_label{
        font-size: 16px;
    }

    .span_value{
        font-size: 20px;
        font-weight: bold
    }
</style>
<div class="row p-3">
    <?php if($result){ ?>
        <div class="col-lg-4">
            <span class="span_label">Unit Kerja</span>
        </div>
        <div class="col-lg-4">
            <span class="span_label">Pangkat</span>
        </div>
        <div class="col-lg-4">
            <span class="span_label">Jabatan</span>
        </div>
        <div class="col-lg-4">
            <span class="span_value"><?=$result['nm_unitkerja']?></span>
        </div>
        <div class="col-lg-4">
            <span class="span_value"><?=$result['nm_pangkat']?></span>
        </div>
        <div class="col-lg-4">
            <span class="span_value"><?=$result['nama_jabatan']?></span>
        </div>
        <br>
        <br>
        <div class="col-lg-12">
            <span class="span_value">Nominal</span>
        </div>
        <div class="col-lg-12">
            <input class="form-control" value="<?=$result['nominal']?>" />
        </div>
    <?php } ?>  
</div>