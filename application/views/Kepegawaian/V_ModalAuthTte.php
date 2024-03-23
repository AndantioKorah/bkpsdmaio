<?php //dd($user); ?>
<form autocomplete="off" id="form_auth_tte">
  <input autocomplete="false" name="hidden" type="text" style="display:none;">
  <div class="row p-3">
    <div class="col-lg-12 form-group">
      <label>NIK:</label>
      <input name="nik" id="nik" value="<?=$user['nik']?>" class="form-control" />
      <small autocomplete="false" <?=$user['nik'] ? 'autofocus' : ''?> class="form-text text-muted">Jika NIK kosong, harap mengisi NIK Anda</small>
    </div>
    <div class="col-lg-12 mt-2 form-group">
      <label>Passphrase:</label>
      <input autocomplete="false" <?=!$user['nik'] ? 'autofocus' : ''?> type="password" name="passphrase" id="passphrase" class="form-control" />
    </div>
    <div class="col-lg-12 mt-2 text-right">
      <button type="submit" class="btn btn-navy" id="btn_submit_auth">SUBMIT</button>
      <button style="display: none;" type="button" disabled class="btn btn-navy" id="btn_submit_auth_loader"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...</button>
    </div>
  </div>  
</form>

<script>
  $('#form_auth_tte').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit_auth').hide()
    $('#btn_submit_auth_loader').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/dsCuti/")?>'+'<?=$id?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
        } else {
          successtoast('DS Berhasil')
          // $('#auth_modal_tte').modal('hide')
          $("#auth_modal_tte .close").click()
          loadDetailCutiVerif('<?=$id?>')
        }
        $('#btn_submit_auth').show()
        $('#btn_submit_auth_loader').hide()
        // $('#auth_modal_tte').modal('hide')
        $("#auth_modal_tte .close").click()
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#btn_submit_auth').show()
        $('#btn_submit_auth_loader').hide()
      }
    })
  })
</script>
