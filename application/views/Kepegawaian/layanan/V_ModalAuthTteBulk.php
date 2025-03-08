<?php //dd($user); ?>
<div class="row p-3">
  <form method="POST" class="form_auth_tte_bulk">
    <div style="display: none;" class="col-lg-12 form-group">
      <label>NIK:</label>
      <input name="nik" id="nik" value="<?=$user['nik']?>" class="form-control" />
      <small autocomplete="off" <?=$user['nik'] ? 'autofocus' : ''?> class="form-text text-muted">Jika NIK kosong, harap mengisi NIK Anda</small>
    </div>
    <div class="col-lg-12 mt-2 form-group">
      <label>Passphrase:</label>
      <input required autocomplete="off" <?=$user['nik'] ? '' : 'autofocus'?> type="password" name="passphrase" id="passphrase" class="form-control" />
    </div>
    <div class="col-lg-12 mt-2 text-right">
      <button type="submit" class="btn btn-navy" id="btn_submit_auth">SUBMIT</button>
      <button style="display: none;" type="button" disabled class="btn btn-navy" id="btn_submit_auth_loader"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...</button>
    </div>
    <div class="col-lg-12 mt-3" id="div_message">
      <hr>
      <span style="font-weight:bold; font-style: italic; color: grey; font-size: .75rem;" class="Pesan:"></span>
      <span style="font-weight:bold; font-size: 1rem;" class="message_text"></span>
    </div>
  </form>
</div>  

<script>
  $('.form_auth_tte_bulk').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit_auth').hide()
    $('#btn_submit_auth_loader').show()
    $('#div_message').hide()
    // $('#auth_modal_tte').modal('hide')
    // return false
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/dsBulk")?>',
      method:"POST",
      data: {
        list_checked: list_checked,
        passphrase: $('#passphrase').val(),
        nik: '<?=$user['nik']?>',
        table_ref: '<?=isset($table_ref) ? $table_ref : 't_usul_ds_detail_progress'?>',
        jenis_layanan : '<?=$jenis_layanan?>'
      },
      success: function(res){
        let rs = JSON.parse(res)
        $('#div_message').show()
        if(rs.code != 0){
          errortoast(rs.message)
          $('#btn_submit_auth').show()
          $('#btn_submit_auth_loader').hide()
          $('.message_text').html(rs.message)
          $('.message_text').text(rs.message)
          $('.message_text').css("color", "red")
        } else {
          $('#form_load_ds').submit()
          successtoast('File sudah berhasil ditambahkan ke dalam antrian untuk dilakukan Digital Signature secara otomatis.')
          $("#auth_modal_tte .close").click()
          $('#auth_modal_tte').modal('hide')
          $('.message_text').html('File sudah berhasil ditambahkan ke dalam antrian untuk dilakukan Digital Signature secara otomatis.')
          $('.message_text').text('File sudah berhasil ditambahkan ke dalam antrian untuk dilakukan Digital Signature secara otomatis.')
          $('.message_text').css("color", "green")
        }
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#btn_submit_auth').show()
        $('#btn_submit_auth_loader').hide()
      }
    })
    // $('#btn_submit_auth').show()
    // $('#btn_submit_auth_loader').hide()
  })
</script>
