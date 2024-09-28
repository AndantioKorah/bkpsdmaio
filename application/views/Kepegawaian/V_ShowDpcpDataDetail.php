<?php if($result[$jenis_file]){ if($result[$jenis_file]['flag_ds_'.$jenis_file] == 1){ ?>
    <?php if(isset($result[$jenis_file]['flag_sedang_hukdis']) && isset($result[$jenis_file]['flag_sedang_hukdis']) == 1){ ?>
        <label style="font-size: .8rem; color: red; font-weight: bold;">Pegawai sedang menjalani Hukuman Disiplin</label>
    <?php } else { ?>
        <label style="font-size: .7rem; color: grey; font-style: italic;">telah ditandatangani secara digital oleh </label>
        <label style="font-size: .8rem; color: black; font-weight: bold;"><?=$result[$jenis_file]['nama_ds']?></label>
        <label style="font-size: .7rem; color: grey; font-style: italic;">pada</label>
        <label style="font-size: .8rem; color: black; font-weight: bold;"><?=formatDateNamaBulanWT($result[$jenis_file]['tanggal_ds'])?></label>
    <?php } ?>
<?php } else { ?>
    <?php if(isset($result[$jenis_file]['flag_sedang_hukdis']) && isset($result[$jenis_file]['flag_sedang_hukdis']) == 1){ ?>
        <label style="font-size: .8rem; color: red; font-weight: bold;">Pegawai sedang menjalani Hukuman Disiplin</label>
    <?php } else { ?>
        <label style="font-size: .8rem; color: red; font-weight: bold;">Berkas belum dilakukan Digital Signature (DS). Mohon menunggu.</label>
    <?php } ?>
<?php } ?>
    <iframe style="width: 100%; height: 75vh;" src="<?=base_url($result[$jenis_file]['url_file_'.$jenis_file])?>"></iframe>
<?php } else { ?>
    <h4 class="text-center">DATA TIDAK DITEMUKAN</h4>
<?php } ?>