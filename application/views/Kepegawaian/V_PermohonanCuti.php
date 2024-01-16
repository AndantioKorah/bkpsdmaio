<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h5>FORM PERMOHONAN CUTI</h5></div>
        <hr>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="form_cuti" style="margin-top: -45px;">
          <div class="row">
            <div class="col">
              <label>Jenis Cuti</label>
              <select class="form-control select2-navy" style="width: 100%"
              id="id_cuti" data-dropdown-css-class="select2-navy" name="id_cuti">
                  <?php if($master_jenis_cuti){
                      foreach($master_jenis_cuti as $mc){
                      ?>
                      <option value="<?=$mc['id_cuti']?>">
                          <?=$mc['nm_cuti']?>
                      </option>
                  <?php } } ?>
              </select>
            </div>
            <div class="col" id="div_surat_pendukung" style="display: none;">
              <label>Surat Pendukung</label>
              <input name="surat_pendukung" id="surat_pendukung" class="form-control" type="file" />
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-6">
              <label>Tanggal Mulai</label>
              <input class="form-control" name="tanggal_mulai" id="tanggal_mulai" readonly value="<?=date('d-m-Y')?>" />
            </div>
            <div class="col-lg-6">
              <label>Tanggal Akhir</label>
              <input class="form-control" name="tanggal_akhir" id="tanggal_akhir" readonly value="<?=date('d-m-Y')?>" />
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-6">
              <label>Alasan Cuti</label>
              <textarea class="form-control" rows=3 name="alasan"></textarea>
            </div>
            <div class="col-lg-6">
              <label>Alamat Selama Melaksanakan Cuti</label>
              <textarea class="form-control" rows=3 name="alamat"></textarea>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-6"></div>
            <div class="col-lg-6 text-right">
              <!-- <button id="btn_submit" type="submit" class="btn btn-block btn-navy">Ajukan Cuti</button> -->
              <button id="btn_submit" class="btn btn-block btn-navy">Ajukan Cuti</button>
              <button style="display: none;" disabled id="btn_loading_submit" type="btn" class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $('#id_cuti').select2()
    $('#tanggal_mulai').datepicker({
      format: 'dd-mm-yyyy',
      orientation: 'bottom',
      autoclose: true
    })
    $('#tanggal_akhir').datepicker({
      format: 'dd-mm-yyyy',
      orientation: 'bottom',
      autoclose: true
    })
  })

  $('#id_cuti').on('change', function(){
    if($(this).val() == "20" || $(this).val() == "30" || $(this).val() == "40"){
      $('#div_surat_pendukung').show()
    } else {
      $('#div_surat_pendukung').hide()
    }
  })

  $('#form_cuti').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit').hide()
    $('#btn_loading_submit').show()
    var formvalue = $('#form_cuti');
    var form_data = new FormData(formvalue[0]);

    var ins = document.getElementById('surat_pendukung').files.length;
    if(ins == 0 && ($(this).val() == "20" || $(this).val() == "30" || $(this).val() == "40")){
      errortoast("Silahkan melampirkan Surat Pendukung");
      $('#btn_submit').show()
      $('#btn_loading_submit').hide()
      return false;
    }

    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/submitPermohonanCuti")?>',
      method:"POST",  
      data:form_data,  
      contentType: false,  
      cache: false,  
      processData:false,
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(res.message)
        } else {
          successtoast(res.message)
        }
        $('#btn_submit').show()
        $('#btn_loading_submit').hide()
      }, error: function(err){
        $('#btn_submit').show()
        $('#btn_loading_submit').hide()
        errortoast('Terjadi Kesalahan')
      }
    })

    $('#btn_submit').show()
    $('#btn_loading_submit').hide()
  })
</script>