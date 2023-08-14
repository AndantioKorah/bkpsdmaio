<?php
    $progress_target = 0;
    $jumlah_berkas = 12;
    if($result){
        $progress_target = formatTwoMaxDecimal((count($result) / $jumlah_berkas) * 100);
    }    
?>
<div class="row">
    <div class="col-12 text-center">
        <div class="progress progress-sm" style="height: 1.3rem !important; border-radius: 10px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress_target?>" aria-valuemin="0" aria-valuemax="<?=$progress_target?>" style="width: <?=$progress_target == 0 ? 0 : $progress_target?>%; background-color: <?=getProgressBarColor($progress_target)?>;">
            <p class="text-progress"><?=$progress_target.'%'?></p>
            </div>
        </div>
        <hr>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm <?=isset($result['pas_foto']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['cpns_pns']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['pangkat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['jabatan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['kgb']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['ijazah']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['diklat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['sumpah_janji']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sumpah Janji</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card card-default card-pdm <?=isset($result['penghargaan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['keluarga']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['skp_tahunan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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
        <div class="card card-default card-pdm <?=isset($result['data_lainnya']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
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