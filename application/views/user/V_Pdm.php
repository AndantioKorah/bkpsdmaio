<style>
    .card-title-pdm{
        font-size: 15px;
        font-weight: bold;
        color: black;
        vertical-align: middle;
    }

    .card-belum-lengkap{
        border: 2px solid grey;
    }

    .card-pdm{
        /* min-height: 120px; */
    }

    .text-progress{
        color: white;
        font-weight: bold;
        font-size: 15px;
        margin-top: 15px;
    }

    .progress-bar{
        transition: .2s;
    }
</style>
<?php $progress_target = 100; ?>
<div class="row">
    <div class="col-lg-12 text-center">
        <br>
        <div class="row"></div>
        <h4 class="font-weight-bold">PEMUTAKHIRAN DATA MANDIRI</h4>
        <div class="progress progress-sm" style="height: 1.3rem !important; border-radius: 10px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress_target?>" aria-valuemin="0" aria-valuemax="<?=$progress_target?>" style="width: <?=$progress_target == 0 ? 0 : $progress_target?>%; background-color: <?=getProgressBarColor($progress_target)?>;">
            <p class="text-progress"><?=$progress_target.'%'?></p>
            </div>
        </div>
        <hr>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-id-badge fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Pas Foto</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK CPNS/PNS</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Pangkat</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Jabatan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK KGB</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Ijazah</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sert. Diklat</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Penghargaan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data Keluarga</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SKP Tahunan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm card-belum-lengkap p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data Lainnya</span>
                </div>
            </div>
        </div>
    </div>
</div>