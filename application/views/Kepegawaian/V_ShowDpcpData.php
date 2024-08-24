<div class="col-lg-12 p-3">
    <?php if($result){ ?>
        <div class="row">
            <div class="col-lg-12">
                <?php if($result['flag_ds_dpcp'] == 1){ ?>
                    <label style="font-size: .7rem; color: grey; font-style: italic;">telah ditandatangani secara digital oleh </label>
                    <label style="font-size: .8rem; color: black; font-weight: bold;"><?=$result['nama_ds']?></label>
                    <label style="font-size: .7rem; color: grey; font-style: italic;">pada</label>
                    <label style="font-size: .8rem; color: black; font-weight: bold;"><?=formatDateNamaBulanWT($result['tanggal_ds'])?></label>
                <?php } else { ?>
                    <label style="font-size: .8rem; color: red; font-weight: bold;">Berkas belum dilakukan Digital Signature (DS). Mohon menunggu.</label>
                <?php } ?>
            </div>
        </div>
        <iframe style="width: 100%; height: 75vh;" src="<?=base_url($result['url_file_dpcp'])?>"></iframe>
    <?php } else { ?>
        <h4 class="text-center">TERJADI KESALAHAN. DATA TIDAK DITEMUKAN</h4>
    <?php } ?>
</div>