<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="row">
          <div class="col-lg-6">
            <div class="card-title"><h5>INPUT NOMOR SURAT</h5></div>
          </div>
          <div class="col-lg-3 text-right">
            <button id="btn_input_manual" class="btn btn-navy"><i class="fa fa-edit"></i> Input Manual</button>
          </div>
          <div class="col-lg-3 text-right">
            <button style="display: block;" id="btn_riwayat_nomor_surat" onclick="loadRiwayat()" class="btn btn-navy"><i class="fa fa-clock"></i> Riwayat Nomor Surat</button>
          </div>
        </div>
        <hr>
      </div>
      <div class="card-body">
        <form id="form_input" style="margin-top: -30px;">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <label>Jenis Layanan</label>
              <select class="form-control select2-navy" style="width: 100%"
              id="id_m_jenis_layanan" data-dropdown-css-class="select2-navy" name="id_m_jenis_layanan">
                  <?php if($jenis_layanan){
                      foreach($jenis_layanan as $mc){
                      ?>
                      <option value="<?=$mc['id']?>">
                          <?='('.$mc['nomor_surat'].') '.$mc['nama_layanan']?>
                      </option>
                  <?php } } ?>
              </select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <label>Tanggal</label>
              <input readonly class="form-control" name="tanggal_surat" value="<?=date('Y-m-d')?>" id="tanggal_surat" />
            </div>
            <div class="col-lg-12">
              <label>Perihal</label>
              <input class="form-control" name="perihal" id="perihal" />
            </div>
            <div class="col-lg-12 mt-2 text-right">
              <button id="btn_submit" class="btn btn-navy" type="submit"><i class="fa fa-save"></i> Simpan</button>
              <button style="display: none;" id="btn_submit_loading" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="div_riwayat_nomor_surat" class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <h5>RIWAYAT NOMOR SURAT</h5>
        </div>
        <hr>
      </div>
      <div class="card-body" id="div_riwayat" style="margin-top: -40px;">
      </div>
    </div>
  </div>

  <div id="div_input_manual_nomor_surat" style="display: none;" class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <h5>INPUT MANUAL NOMOR SURAT FILE</h5>
        </div>
        <hr>
      </div>
      <div class="card-body" id="div_list_manual_nomor_surat" style="margin-top: -40px;">
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $('#id_m_jenis_layanan').select2()
    loadRiwayat()
  })

  $('#btn_input_manual').on('click', function(){
    // loadRiwayat()
    // $('#btn_riwayat_nomor_surat').show()
    $('#div_input_manual_nomor_surat').show()
    $('#div_riwayat_nomor_surat').hide()
    loadListFileInputManualNomorSurat()
  })

  function loadListFileInputManualNomorSurat(){
    $('#div_input_manual_nomor_surat').html('')
    $('#div_input_manual_nomor_surat').append(divLoaderNavy)
    $('#div_input_manual_nomor_surat').load('<?=base_url('kepegawaian/C_Kepegawaian/loadListFileInputManualNomorSurat')?>', function(){
      $('#loader').hide()
    })
  }

  function loadRiwayat(){
    // $('#btn_riwayat_nomor_surat').hide()
    $('#div_input_manual_nomor_surat').hide()
    $('#div_riwayat_nomor_surat').show()

    $('#div_riwayat').html('')
    $('#div_riwayat').append(divLoaderNavy)
    $('#div_riwayat').load('<?=base_url('kepegawaian/C_Kepegawaian/loadNomorSurat')?>', function(){
      $('#loader').hide()
    })
  }

  $('#tanggal_surat').datepicker({
    format: 'yyyy-mm-dd',
    orientation: 'bottom',
    autoclose: true,
    todayBtn: true
  })

  $('#form_input').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit').hide()
    $('#btn_submit_loading').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/saveNomorSurat")?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        successtoast('Data berhasil disimpan')
        $('#btn_submit').show()
        $('#btn_submit_loading').hide()
        $('#perihal').val("")
        loadRiwayat()
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
        $('#btn_submit').show()
        $('#btn_submit_loading').hide()
      }
    })
  })
</script>