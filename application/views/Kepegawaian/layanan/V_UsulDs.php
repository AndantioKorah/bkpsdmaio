<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <h4>USUL DIGITAL SIGNATURE</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12 text-center" id="div_form_button">
            <button style="width: 300px; height: 100px; font-size: 1.1rem;" id="btn_add_new" class="btn btn-sm btn-navy">
              <i class="fa fa-plus"></i> TAMBAH USUL DS
            </button>
          </div>
          <div class="col-lg-12" id="div_form_input" style="display: none;">
            <div class="row">
              <div class="col-lg-12 text-left">
                <button id="btn_back" class="btn btn-sm btn-warning"><i class="fa fa-chevron-left"></i> Kembali</button>
              </div>
              <div class="col-lg-12">
                <form id="form_usul_ds">
                  <div class="row">
                    <div class="col-lg-6 mt-3">
                      <label>Jenis Layanan</label>
                      <select class="form-control select2-navy" style="width: 100%;"
                          id="id_m_jenis_layanan" data-dropdown-css-class="select2-navy" name="id_m_jenis_layanan">
                          <?php if($layanan_ds){
                              foreach($layanan_ds as $ld){
                              ?>
                              <option value="<?=$ld['id']?>">
                                  <?="(".$ld['nomor_surat'].") ".$ld['nama_layanan']?>
                              </option>
                          <?php } } ?>
                      </select>
                    </div>
                    <div class="col-lg-3 mt-3">
                      <label>Keterangan:</label>
                      <input class="form-control" value="" id="keterangan" name="keterangan" />
                    </div>
                    <div class="col-lg-3 mt-3">
                      <label>Kode Unik DS:</label>
                      <input class="form-control" value="" id="ds_code" name="ds_code" />
                    </div>
                  </div>
                  <div class="col-lg-12 mt-3">
                    <label>Upload File:</label>
                    <div id="dropzone" class="dropzone text-center">
                      <span class="span_dz"><i class="fa fa-3x fa-upload"></i><br>Klik atau drag file ke area ini<br>*Hanya file pdf yang akan terupload</span>
                    </div>
                  </div>
                  <div class="col-lg-12 text-right mt-3">
                    <button id="btn_submit" class="btn btn-navy"><i class="fa fa-save"></i> Simpan</button>
                    <button style="display: none;" id="btn_submit_loadings" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 mt-3">
    <div class="card card-default">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12 text-right">
            <button id="btn_refresh" class="btn btn-warning"><i class="fa fa-sync"></i> Refresh</button>
          </div>
          <div class="col-lg-12 mt-3 table-responsive" id="div_result"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url()?>assets/siladen/plugins/dropzone/min/dropzone.min.js"></script>

<script>
  $(function(){
    $('#btn_refresh').click()  
    $('#id_m_jenis_layanan').select2()
  })

  $('#btn_refresh').on('click', function(){
    $('#div_result').html('')
    $('#div_result').append(divLoaderNavy)
    $('#div_result').load('<?=base_url('kepegawaian/C_Layanan/loadRiwayatUsulDs')?>', function(){
      $('#loader').hide()
    })
  })

  $('#form_usul_ds').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit').hide()
    $('#btn_submit_loading').show()

    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/getSelectedFile")?>',
      method: 'post',
      data: null,
      success: function(data){
        let rs = JSON.parse(data)
        if(rs.count == 0){
          errortoast("Belum ada file yang dipilih")
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
        } else {
          submitSaveUsulDs()
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
        }
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
      }
    })
  })

  function submitSaveUsulDs(){
    $('#btn_submit').hide()
    $('#btn_submit_loading').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/submitUploadFileUsulDs")?>',
      method: 'post',
      data: {
        keterangan: $('#keterangan').val(),
        ds_code: $('#ds_code').val(),
        id_m_jenis_layanan: $('#id_m_jenis_layanan').val()
      },
      success: function(data){
        let rs = JSON.parse(data)
        if(rs.code == 0){
          successtoast("Data berhasil disimpan")
          window.location=""
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
        } else {
          errortoast(rs.message)
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
        }
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
          $('#btn_submit').show()
          $('#btn_submit_loading').hide()
      }
    })
  }

  $('#btn_add_new').on('click', function(){
    removeAllUploadedFileDs()
    $('#div_form_button').hide()
    $('#div_form_input').show()
  })

  $('#btn_back').on('click', function(){
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/getSelectedFile")?>',
      method: 'post',
      data: null,
      success: function(data){
        let rs = JSON.parse(data)
        if(rs.count > 0){
          if(confirm('File yang sudah terpilih akan terhapus, apakah Anda yakin untuk melanjutkan?')){
            removeAllUploadedFileDs()
            window.location=""
            // $('#div_form_button').show()
            // $('#div_form_input').hide()
          }
        } else {
          $('#div_form_button').show()
          $('#div_form_input').hide()
          removeAllUploadedFileDs()
        }
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
      }
    })
  })

  function removeAllUploadedFileDs(){
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/removeAllUploadedFileDs")?>',
      method: 'post',
      data: null,
      success: function(data){
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
      }
    })
  }

  Dropzone.options.dropzone = {
    url: "<?=base_url("kepegawaian/C_Layanan/uploadFileUsulDs")?>",
    autoProcessQueue: true,
    paramName: "file",
    clickable: true,
    maxFilesize: 5, //in mb
    maxFiles: 100,
    addRemoveLinks: true,
    acceptedFiles: '.pdf',
    dictDefaultMessage: "",
    init: function() {
      this.on("maxfilesexceeded", function(file){
        errortoast("Maksimal jumlah file dalam satu kali usul adalah 100 file");
      });
      this.on("sending", function(file, xhr, formData) {
        // console.log("sending file");
      });
      this.on("success", function(file, responseText) {
        console.log('great success');
      });
      this.on("addedfile", function(file){
        $('.span_dz').hide()
        // console.log('file added');
      });
      this.on("removedfile", function(file){
        $.ajax({
          url: '<?=base_url("kepegawaian/C_Layanan/removeUploadedFileDs")?>',
          method: 'post',
          data: {
            filename: file.name
          },
          success: function(data){
            file.previewElement.remove();
          }, error: function(e){
            errortoast('Terjadi Kesalahan')
          }
        })
      })
    }
  };
</script>