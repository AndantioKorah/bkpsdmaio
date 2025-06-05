<div class="row">
  <div class="col-lg-12 p-3">
    <?php if($result['code'] == 0){ ?>
      <div class="row p-3">
        <div class="col-lg-6">
          <iframe src="<?=base_url($result['result']['url_file']).'?v='.generateRandomString()?>" style="width: 100%; height: 75vh;">
          </iframe>
        </div>
        <div class="col-lg-6" style="height: 75vh;">
          <div class="row">
            <div class="col-lg-12">
              <label>Uploader:</label>
              <h4><?=$result['result']['user_inputer']?></h4>
            </div>
            <div class="col-lg-12 mt-3">
              <label>Tanggal Upload:</label>
              <h4><?=formatDateNamaBulanWT($result['result']['created_date'])?></h4>
            </div>
            <div class="col-lg-12 mt-3">
              <label>Keterangan File DS</label>
              <h4><?=$result['result']['keterangan_t_usul_ds']?></h4>
            </div>
            <form id="form_verif_usul_ds">
              <div class="row">
                <div class="col-lg-12 mt-3">
                  <label>Keterangan Verifikasi:</label>
                  <textarea class="form-control" rows=5 name="keterangan_verifikasi"></textarea>
                </div>
                <div class="col-lg-12 mt-3 text-right">
                  <button type="submit" id="btn_tolak" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Tolak Berkas</button>
                  <button id="btn_tolak_loading" disabled style="display: none;" class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menunggu...</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script>
        $('#form_verif_usul_ds').on('submit', function(e){
          e.preventDefault()
          if(confirm('Apakah Anda yakin ingin menolak dokumen tersebut?')){
            $('#btn_tolak').hide()
            $('#btn_tolak_loading').show()
            $.ajax({
              url: '<?=base_url("kepegawaian/C_Layanan/verifUsulDsDetail/".$result['result']['id'].'/2'.'/'.$id_t_usul_ds_detail_progress)?>',
              method: 'post',
              data: $(this).serialize(),
              success: function(data){
                  let resp = JSON.parse(data)
                  if(resp.code == 1){
                    errortoast(resp.message)
                  } else {
                    successtoast('File berhasil ditolak')
                    $('#modal_usul_ds').modal('hide')
                    $('#form_search_usul_ds').submit()
                  }
                  $('#btn_tolak').show()
                  $('#btn_tolak_loading').hide()
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
                  $('#btn_tolak').show()
                  $('#btn_tolak_loading').hide()
              }
            })
          }
        })
      </script>
    <?php } else { ?>
      <div class="col-lg-12 text-center">
        <h5><?=$result['message']?></h5>
      </div>
    <?php } ?>
  </div>
</div>