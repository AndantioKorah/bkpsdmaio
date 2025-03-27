<div class="row p-3">
  <?php if($result){
    $url = $result['url_sk'];
    if($result['flag_ds_manual']){
      $url = $result['url_sk_manual'];
    }  
  ?>
    <div class="col-lg-6">
      <iframe id="iframe_view_file" style="width: 100%; min-height: 75vh;" src="<?=base_url().$url?>"></iframe>
    </div>
    <div class="col-lg-6">
      <div class="row">
        <div class="col-lg-12">
          <form id="form_input_nomor_surat_manual">
            <div class="row">
              <div class="col-lg-12">
                <label>NOMOR SURAT</label>
                <input required class="form-control" id="nomor_surat_input" name="nomor_surat" value="<?=$result['nomor_surat']?>" />
              </div>
              <div class="mt-3 col-lg-12">
                <label>COUNTER NOMOR SURAT</label>
                <input required class="form-control" id="counter_nomor_surat_input" name="counter_nomor_surat" value="<?=$result['counter']?>" />
              </div>
              <?php if($result['flag_ds_cuti'] == 0){ ?>
                <div class="col-lg-6 text-left mt-3">
                  <?php if($result['id_t_nomor_surat']){ ?>
                    <button id="btn_delete" type="button" class="btn btn-danger"><i class="fa fa-trash"></i> HAPUS</button>
                    <button id="btn_delete_loading" style="display: none;" type="btn" disabled class="btn btn-danger"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                  <?php } ?>
                </div>
                <div class="col-lg-6 text-right mt-3">
                  <button id="btn_save" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
                  <button id="btn_save_loading" style="display: none;" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                </div>
              </div>
            <?php } ?>
          </form>
        </div>
        <div class="col-lg-12">
          <hr>
          <?php if($result['flag_ds_manual'] == 0 && $result['flag_ds_cuti'] == 0){ ?>
          <form id="form_upload_dokumen_ds">
            <div class="row">
              <div class="col-lg-12">
                <label>UPLOAD FILE DS MANUAL</label><br>
                <input class="form-control" type="file" name="file_ds_manual" id="file_ds_manual" />
              </div>
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-6"></div>
                  <div class="col-lg-6 text-right mt-2">
                    <button id="btn_upload_file" type="submit" class="btn btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
                    <button id="btn_upload_file_loading" style="display: none;" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                  </div>
                </div>
              </div>
          </form>
          <?php } else {
            $fileUrl = $result['url_sk'];
            $keterangan = "File sudah dilakukan Digital Signature oleh Kepala BKPSDM";
            if($result['flag_ds_manual'] == 1){
              $fileUrl = $result['url_sk_manual'];
            }  
          ?>
            <div class="row">
              <div class="col-lg-12 text-center">
                <span style="font-weight: bold; color: green; size: .8rem;"><?=$keterangan?></span>
              </div>
              <div class="col-lg-6">
                <?php if($result['flag_ds_manual'] == 1){ ?>
                  <button id="btn_delete_file" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                  <button id="btn_delete_file_loading" style="display: none;" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                <?php } ?>
              </div>
              <div class="col-lg-6 text-right">
                <a class="btn btn-sm btn-success" target="_blank" href="<?=base_url().$fileUrl?>"><i class="fa fa-file"></i> LIHAT SK CUTI</a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <script>
      $('#btn_delete_file').on('click', function(){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
          $('#btn_delete_file').hide()
          $('#btn_delete_file_loading').show()
          $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteFileDsManual/".$result['id_t_usul_ds'])?>',
            method:"POST",  
            data: $(this).serialize(),
            success: function(res){
              $('#btn_delete_file').show()
              $('#btn_delete_file_loading').hide()

              let rs = JSON.parse(res)
              if(rs.code == 1){
                errortoast(rs.message)
              } else {
                openModalPenomoranSkCuti('<?=$result['id_t_pengajuan_cuti']?>')
                successtoast('Data berhasil dihapus')
              }
            }, error: function(err){
              errortoast('Terjadi Kesalahan')
              $('#btn_delete_file').show()
              $('#btn_delete_file_loading').hide()
            }
          })
        }
      })

      $('#form_upload_dokumen_ds').on('submit', function(e){
          e.preventDefault()
          $('#btn_upload_file').hide()
          $('#btn_upload_file_loading').show()

          var formvalue = $('#form_upload_dokumen_ds');
          var form_data = new FormData(formvalue[0]);
          var ins = document.getElementById('file_ds_manual').files.length;
          
          if(ins == 0){
              $('#btn_upload_file').show()
              $('#btn_upload_file_loading').hide()
              errortoast("Silahkan upload file terlebih dahulu");

              return false;
          }

          e.preventDefault()
              $.ajax({
              url: '<?=base_url('kepegawaian/C_Kepegawaian/saveUploadFileDsPenomoranSkCuti/'.$result['id_t_usul_ds'])?>',
              method: 'POST',
              data: form_data,  
              contentType: false,  
              cache: false,  
              processData:false,
              success: function(rs){
                  let res = JSON.parse(rs)
                  if(res.code == 0){
                      successtoast('Upload Dokumen DS Berhasil')
                      openModalPenomoranSkCuti('<?=$result['id_t_pengajuan_cuti']?>')
                      // $('#btn_modal_balasan_close').click()
                  } else {
                      errortoast(res.message)
                  }
                  $('#btn_upload_file').show()
                  $('#btn_upload_file_loading').hide()
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
                  console.log(e)
                  $('#btn_upload_file').show()
                  $('#btn_upload_file_loading').hide()
              }
          })
      })

      $('#form_input_nomor_surat_manual').on('submit', function(e){
        e.preventDefault()
        $('#btn_save').hide()
        $('#btn_save_loading').show()
        $.ajax({
          url: '<?=base_url("kepegawaian/C_Kepegawaian/saveNomorSuratManualSkCuti/".$result['id_t_usul_ds'])?>',
          method:"POST",  
          data: $(this).serialize(),
          success: function(res){
            let rs = JSON.parse(res)
            if(rs.code == 1){
              errortoast(rs.message)
            } else {
              successtoast('Data berhasil disimpan')
              $('#iframe_view_file')[0].contentWindow.location.reload(true);
              // openModalPenomoranSkCuti('<?=$result['id_t_usul_ds']?>')
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

      $('#btn_delete').on('click', function(){
        if(confirm('Apakah Anda yakin ingin menghapus Nomor Surat?')){
          $('#btn_delete').hide()
          $('#btn_delete_loading').show()
          $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteNomorSuratManualSkCuti/".$result['id'])?>',
            method:"POST",  
            data: $(this).serialize(),
            success: function(res){
              let rs = JSON.parse(res)
              if(rs.code == 1){
                errortoast(rs.message)
              } else {
                // openModalPenomoranSkCuti('<?=$result['id_t_usul_ds']?>')
                successtoast('Data berhasil dihapus')
                $('#nomor_surat_input').val("")
                $('#counter_nomor_surat_input').val("")
                $('#iframe_view_file')[0].contentWindow.location.reload(true);
              }
              $('#btn_delete').show()
              $('#btn_delete_loading').hide()
            }, error: function(err){
              errortoast('Terjadi Kesalahan')
              $('#btn_delete').show()
              $('#btn_delete_loading').hide()
            }
          })
        }
      })
    </script>
  <?php } else { ?>
  <?php } ?>
</div>