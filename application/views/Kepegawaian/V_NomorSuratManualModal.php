<div class="row p-3">
  <?php if($result){ ?>
    <div class="col-lg-12">
      <form id="form_input_nomor_surat_manual">
        <div class="row">
          <div class="col-lg-12">
            <label>NOMOR SURAT</label>
            <input class="form-control" name="nomor_surat" value="<?=$result['nomor_surat']?>" />
          </div>
          <div class="mt-3 col-lg-12">
            <label>COUNTER NOMOR SURAT</label>
            <input class="form-control" name="counter_nomor_surat" value="<?=$result['counter']?>" />
          </div>
          <div class="col-lg-12 text-right mt-3">
            <button id="btn_save" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
            <button id="btn_save_loading" style="display: none;" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
          </div>
        </div>
      </form>
      <hr>
    </div>
    <div class="col-lg-12">
      <iframe style="width: 100%; min-height: 60vh;" src="<?=base_url().$result['url_file']?>"></iframe>
    </div>

    <script>
      $('#form_input_nomor_surat_manual').on('submit', function(e){
        e.preventDefault()
        $('#btn_save').hide()
        $('#btn_save_loading').show()
        $.ajax({
          url: '<?=base_url("kepegawaian/C_Kepegawaian/saveNomorSuratManual/".$result['id'])?>',
          method:"POST",  
          data: $(this).serialize(),
          success: function(res){
            let rs = JSON.parse(res)
            if(rs.code == 1){
              errortoast(rs.message)
            } else {
              successtoast('Data berhasil disimpan')
              openModalNomorSuratManual('<?=$result['id']?>')
            }
            $('#btn_save').show()
            $('#btn_save_loading').hide()
          }, error: function(err){
            errortoast('Terjadi Kesalahan')
            $('#btn_save').show()
            $('#btn_save_loading').hide()
          }
        })
      })
    </script>
  <?php } else { ?>
  <?php } ?>
</div>