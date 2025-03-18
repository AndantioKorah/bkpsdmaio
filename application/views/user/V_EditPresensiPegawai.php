<style>
    .label{
      font-size: .8rem;
      font-style: italic;
      font-weight: bold;
      color: grey;
    }

    .vallabel{
      font-size: 1.2rem;
      font-weight: bold;
      color: black;
    }

    .select2-time-picker{
      font-weight: bold !important;
      font-size: 2.5rem !important;
      text-align: center !important;
      height: 60px !important;
      line-height: 50px !important; 
      border-radius: 5px;
      cursor: pointer;
    }

    .select2-time-picker option{
      font-size: .9rem !important;
    }

    .select2-time-picker option:hover{
      cursor: pointer;
    }

</style>

<?php
  $ex_masuk = null;
  $ex_pulang = null;
  if($result){
    $ex_masuk = explode(":", $result['masuk']);
    $ex_pulang = explode(":", $result['pulang']);
  }
?>
  <div class="col-lg-12 p-3">
    <div class="col-lg-12 text-center">
      <h4><strong><?=formatDateNamaBulan($date)?></strong></h4>
    </div>
    <div class="row">
      <div class="col-lg-5">
        <center>
          <div class="row">
            <div class="col-lg-12 text-center">
              <h4>ABSEN MASUK</h4>
            </div>
            <div class="col-sm-4">
              <center><label class="label">Jam</label></center>
              <select class="select2-time-picker" style="width: 100%"
                id="jam_masuk" name="jam_masuk">
                <?php for($i = 0; $i <= 23; $i++){
                  $jam_masuk = $i < 10 ? '0'.$i : $i;
                  $selected = '';
                  if(count($ex_masuk) > 1){
                    $selected = $ex_masuk[0] == $jam_masuk ? "selected" : "";
                  }
                ?>
                  <option <?= $selected ?> value="<?=$jam_masuk?>"><?=$jam_masuk?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-4">
              <center><label class="label">Menit</label></center>
              <select class="select2-time-picker" style="width: 100%"
                id="menit_masuk" name="menit_masuk">
                <?php for($i = 0; $i <= 59; $i++){
                  $menit_masuk = $i < 10 ? '0'.$i : $i;
                  $selected = '';
                  if(count($ex_masuk) > 1){
                    $selected = $ex_masuk[1] == $menit_masuk ? "selected" : "";
                  }
                ?>
                  <option <?= $selected ?> value="<?=$menit_masuk?>"><?=$menit_masuk?></option>
                <?php } ?>
              </select>
              </div>
            <div class="col-sm-4">
              <center><label class="label">Detik</label></center>
              <select class="select2-time-picker" style="width: 100%"
                id="detik_masuk" name="detik_masuk">
                <?php for($i = 0; $i <= 59; $i++){
                  $detik_masuk = $i < 10 ? '0'.$i : $i;
                  $selected = '';
                  if(count($ex_masuk) > 1){
                    $selected = $ex_masuk[2] == $detik_masuk ? "selected" : "";
                  }
                ?>
                  <option <?= $selected ?> value="<?=$detik_masuk?>"><?=$detik_masuk?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-lg-12 mt-3">
              <?php if($result['path_masuk']){ ?>
                <img src="http://203.175.10.90/sip/upload/<?=$result['path_masuk']?>" />
              <?php } ?>
            </div>
          </div>
        </center>
      </div>
      <div class="col-lg-2"></div>
      <div class="col-lg-5">
        <center>
          <div class="row">
            <div class="col-lg-12 text-center">
              <h4>ABSEN PULANG</h4>
            </div>
            <div class="col-sm-4">
              <center><label class="label">Jam</label></center>
              <select class="select2-time-picker" style="width: 100%"
                id="jam_pulang" name="jam_pulang">
                <?php for($i = 0; $i <= 23; $i++){
                  $jam_pulang = $i < 10 ? '0'.$i : $i;
                  $selected = '';
                  if(count($ex_pulang) > 1){
                    $selected = $ex_pulang[0] == $jam_pulang ? "selected" : "";
                  }
                ?>
                  <option <?= $selected ?> value="<?=$jam_pulang?>"><?=$jam_pulang?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-4">
              <center><label class="label">Menit</label></center>
                <select class="select2-time-picker" style="width: 100%"
                  id="menit_pulang" name="menit_pulang">
                  <?php for($i = 0; $i <= 59; $i++){
                    $menit_pulang = $i < 10 ? '0'.$i : $i;
                    $selected = '';
                    if(count($ex_pulang) > 1){
                      $selected = $ex_pulang[1] == $menit_pulang ? "selected" : "";
                    }
                  ?>
                    <option <?= $selected ?> value="<?=$menit_pulang?>"><?=$menit_pulang?></option>
                  <?php } ?>
                </select>
              </div>
            <div class="col-sm-4">
              <center><label class="label">Detik</label></center>
              <select class="select2-time-picker" style="width: 100%"
                id="detik_pulang" name="detik_pulang">
                <?php for($i = 0; $i <= 59; $i++){
                  $detik_pulang = $i < 10 ? '0'.$i : $i;
                  $selected = '';
                  if(count($ex_pulang) > 1){
                    $selected = $ex_pulang[2] == $detik_pulang ? "selected" : "";
                  }
                ?>
                  <option <?= $selected ?> value="<?=$detik_pulang?>"><?=$detik_pulang?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-lg-12 mt-3">
              <?php if($result['path_pulang']){ ?>
                <img src="http://203.175.10.90/sip/upload/<?=$result['path_pulang']?>" />
              <?php } ?>
            </div>
          </div>
        </center>
      </div>
    </div>
  </div>
  <?php if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('edit_presensi')){ ?>
    <div class="modal-footer">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-sm-6 text-left">
            <!-- <button id="btn_delete" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
            <button style="display: none;" id="btn_delete_loading" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button> -->
          </div>
          <div class="col-sm-6 text-right">
            <button id="btn_save" onclick="simpan()" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button style="display: none;" id="btn_save_loading" disabled class="btn btn-success"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <script>
    $(function(){
    })

    function simpan(){
      $('#btn_save').hide()
      $('#btn_save_loading').show()
      $.ajax({
          url: '<?=base_url("user/C_User/saveEditPresensi/".$nip.'/'.$date)?>',
          method: 'post',
          // data: $(this).serialize(),
          data: {
            jam_masuk: $('#jam_masuk').val(),
            menit_masuk: $('#menit_masuk').val(),
            detik_masuk: $('#detik_masuk').val(),
            jam_pulang: $('#jam_pulang').val(),
            menit_pulang: $('#menit_pulang').val(),
            detik_pulang: $('#detik_pulang').val(),
          },
          success: function(data){
              successtoast('Data Berhasil Disimpan')
              $('#form_presensi_pegawai').submit();
              $('#btn_save').show()
              $('#btn_save_loading').hide()
          }, error: function(e){
              errortoast('Terjadi Kesalahan')
              $('#btn_save').show()
              $('#btn_save_loading').hide()
          }
      })
    }
  </script>