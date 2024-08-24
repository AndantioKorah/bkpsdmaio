<div class="col-lg-12 p-3">
    <?php if($result){ ?>
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item nav-item-profile" role="presentation">
                        <button class="nav-link nav-link-profile active" id="pills-data-dpcp-tab" data-bs-toggle="pill" data-bs-target="#pills-data-dpcp" type="button" role="tab" aria-controls="pills-data-dpcp" aria-selected="false">DPCP</button>
                    </li>
                    <li class="nav-item nav-item-profile" role="presentation">
                        <button class="nav-link nav-link-profile " id="pills-data-hukdis-tab" data-bs-toggle="pill" data-bs-target="#pills-data-hukdis" type="button" role="tab" aria-controls="pills-data-hukdis" aria-selected="true">SP HUKDIS</button>
                    </li>
                    <li class="nav-item nav-item-profile" role="presentation">
                        <button class="nav-link nav-link-profile " id="pills-data-pidana-tab" data-bs-toggle="pill" data-bs-target="#pills-data-pidana" type="button" role="tab" aria-controls="pills-data-pidana" aria-selected="true">SP PIDANA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show active" id="pills-data-dpcp" role="tabpanel" aria-labelledby="pills-data-dpcp">
                        <?php if($result['dpcp']){ if($result['dpcp']['flag_ds_dpcp'] == 1){ ?>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">telah ditandatangani secara digital oleh </label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=$result['dpcp']['nama_ds']?></label>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">pada</label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=formatDateNamaBulanWT($result['dpcp']['tanggal_ds'])?></label>
                        <?php } else { ?>
                            <label style="font-size: .8rem; color: red; font-weight: bold;">Berkas belum dilakukan Digital Signature (DS). Mohon menunggu.</label>
                        <?php } ?>
                            <iframe style="width: 100%; height: 75vh;" src="<?=base_url($result['dpcp']['url_file_dpcp'])?>"></iframe>
                        <?php } else { ?>
                            <h4 class="text-center">DATA TIDAK DITEMUKAN</h4>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="pills-data-hukdis" role="tabpanel" aria-labelledby="pills-data-hukdis">
                        <?php if($result['hukdis']){ if($result['hukdis']['flag_ds_hukdis'] == 1){ ?>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">telah ditandatangani secara digital oleh </label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=$result['hukdis']['nama_ds']?></label>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">pada</label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=formatDateNamaBulanWT($result['hukdis']['tanggal_ds'])?></label>
                        <?php } else { ?>
                            <label style="font-size: .8rem; color: red; font-weight: bold;">Berkas belum dilakukan Digital Signature (DS). Mohon menunggu.</label>
                        <?php } ?>
                            <iframe style="width: 100%; height: 75vh;" src="<?=base_url($result['dpcp']['url_file_hukdis'])?>"></iframe>
                        <?php } else { ?>
                            <h4 class="text-center">DATA TIDAK DITEMUKAN</h4>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="pills-data-pidana" role="tabpanel" aria-labelledby="pills-data-pidana">
                        <?php if($result['pidana']){ if($result['pidana']['flag_ds_pidana'] == 1){ ?>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">telah ditandatangani secara digital oleh </label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=$result['pidana']['nama_ds']?></label>
                            <label style="font-size: .7rem; color: grey; font-style: italic;">pada</label>
                            <label style="font-size: .8rem; color: black; font-weight: bold;"><?=formatDateNamaBulanWT($result['pidana']['tanggal_ds'])?></label>
                        <?php } else { ?>
                            <label style="font-size: .8rem; color: red; font-weight: bold;">Berkas belum dilakukan Digital Signature (DS). Mohon menunggu.</label>
                        <?php } ?>
                            <iframe style="width: 100%; height: 75vh;" src="<?=base_url($result['dpcp']['url_file_pidana'])?>"></iframe>
                        <?php } else { ?>
                            <h4 class="text-center">DATA TIDAK DITEMUKAN</h4>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h4 class="text-center">TERJADI KESALAHAN. DATA TIDAK DITEMUKAN</h4>
    <?php } ?>
</div>