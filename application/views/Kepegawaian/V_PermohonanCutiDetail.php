<style>
  .lbl_value_detail_cuti{
    font-weight: bold;
    font-size: .9rem;
    color: black;
  }
</style>
<div class="modal-header">
    <h5 class="modal-title">Detail Cuti</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
  <div class="row">
    <?php if($result){ ?>
      <div class="col-lg-12 text-left mb-3">
        <?php foreach($progress as $p){ ?>
          <span style="
            background-color: <?=$p['bg-color']?>;
            padding: 2px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: .9rem;
            color: <?=$p['font-color']?>
          "><i class="fa <?=$p['icon']?>"></i> <?=$p['keterangan']?></span><br>
        <?php } ?>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <span>Jenis Cuti</span>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-1 text-center">
        <span>:</span>
      </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
        <span class="lbl_value_detail_cuti"><?=$result['nm_cuti']?></span>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <span>Tanggal Pengajuan</span>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-1 text-center">
        <span>:</span>
      </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
        <span class="lbl_value_detail_cuti"><?=formatDateNamaBulanWT($result['created_date'])?></span>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <span>Lama Cuti</span>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-1 text-center">
        <span>:</span>
      </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
        <span class="lbl_value_detail_cuti"><?=($result['lama_cuti']).' hari'?></span>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <span>Tanggal Cuti</span>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-1 text-center">
        <span>:</span>
      </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
        <?php 
          $tanggal_cuti = formatDateNamaBulan($result['tanggal_mulai']).' - '.formatDateNamaBulan($result['tanggal_akhir']);
          if($result['lama_cuti'] == 1){
            $tanggal_cuti = formatDateNamaBulan($result['tanggal_mulai']);
          }
        ?>
        <span class="lbl_value_detail_cuti"><?=$tanggal_cuti?></span>
      </div>
      <?php if($result['id_cuti'] == "00"){ ?>
      <div class="col-lg-12 mt-2">
        <div class="row">
          <div class="col-lg-12 text-center">
            <span>Keterangan Cuti</span>
          </div>
          <?php foreach($result['detail'] as $d){ ?>
            <div class="col">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <span><?=$d['tahun']?></span>
                </div>
                <div class="col-lg-12 text-center">
                  <span class="lbl_value_detail_cuti"><?=$d['jumlah']?></span>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php } else if($result['id_cuti'] != "00" && $result['id_cuti'] != "10"){ ?>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <span>Surat Pendukung</span>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 text-center">
          <span>:</span>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7">
          <a href="<?=base_url('assets/dokumen_pendukung_cuti/'.$result['surat_pendukung'])?>" target="_blank" class="">
            Lihat Surat Pendukung <i class="fas fa-external-link-alt"></i>
          </a>
        </div>
      <?php } ?>
      <?php if($result['flag_ds_cuti'] == 1){ ?>
        <hr>
        <div class="col-lg-12 text-center">
          <a class="btn btn-navy" target="_blank" href="<?=base_url($result['url_sk'])?>"><fa class="fa fa-file-signature"></fa> LIHAT SK CUTI</a>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="col-lg-12">
        <h5><i class="fa fa-exclamation"></i> Data Tidak Ditemukan</h5>
      </div>
    <?php } ?>
  </div>
</div>
<?php if($progress[0]['flag_verif'] == 0 && $result && $result['id_m_user'] == $this->general_library->getId()){ ?>
  <div class="modal-footer">
    <button onclick="deletePermohonanCuti('<?=$result['id']?>')" class="btn btn-danger">Hapus</button>
  </div>
<?php } ?>