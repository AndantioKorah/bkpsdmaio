<div class="row p-3">
  <div class="col-lg-12">
    <?php if($res){ ?>
      <div class="row">
        <?php if($res['user_id_telegram']){ ?>
          <div class="col-lg-12 text-center">
            <span style="
              font-size: 1.5rem;
              color: black;
              font-weight: bold;
            "><?=$res['user_id_telegram']?></span>
          </div>
          <div class="col-lg-12 text-right mt-2">
            <hr>
            <button id="btn_delete_integrasi" type="button" onclick="deleteUserIdTelegram('<?=$res['id']?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
            <button disabled style="display: none;" id="btn_delete_integrasi_loading" type="button" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button>
          </div>
        <?php } else { ?>
          <form id="form_integrasi_telegram">
            <div class="col-lg-12">
              <label>KODE INTEGRASI TELEGRAM</label>
              <input class="form-control" style="
                width: 100%;
                font-size: 1rem;
                font-weight: bold;
                text-align: center;
              " name="user_id_telegram" />
            </div>
            <div class="col-lg-12 text-right mt-2">
              <button id="btn_submit_integrasi" type="submit" class="btn btn-navy btn-sm"><i class="fa fa-save"></i> Simpan</button>
              <button style="display: none;" id="btn_submit_integrasi_loading" type="button" disabled class="btn btn-navy btn-sm"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
            </div>
          </form>
        <?php } ?>
      </div>
    <?php } else { ?>
      <div class="text-center">
        <h5>Terjadi Kesalahan</h5>
      </div>
    <?php } ?>
  </div>
</div>

<script>
  $('#form_integrasi_telegram').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit_integrasi').hide()
    $('#btn_submit_integrasi_loading').show()
    $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/saveUserIdTelegram/".$res['id'])?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
            let resp = JSON.parse(data)
            if(resp.code == 0){
              successtoast('Integrasi Akun Telegram berhasil')
              openModalIntegrasiTelegram('<?=$res['id']?>')
            } else {
              errortoast(resp.message)
            }
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
    })
  })

  function deleteUserIdTelegram(id){
    if(confirm('Apakah Anda ingin menghapus integrasi akun Telegram?')){
      $('#btn_delete_integrasi').hide()
      $('#btn_delete_integrasi_loading').show()
      $.ajax({
          url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteUserIdTelegram/")?>'+id,
          method: 'post',
          data: null,
          success: function(data){
              let resp = JSON.parse(data)
              if(resp.code == 0){
                successtoast('Hapus Integrasi Akun Telegram berhasil')
                openModalIntegrasiTelegram('<?=$res['id']?>')
              } else {
                errortoast(resp.message)
              }
          }, error: function(e){
              errortoast('Terjadi Kesalahan')
          }
      })
    }
  }
</script>