<div class="row">
  <div class="col-lg-12 p-3">
    <div class="card card-default">
      <div class="modal-header">
        <h5 clsas="modal-title">LOCK TPP</h5>
      </div>
      <div class="modal-body">
        <form id="form_lock_tpp">
          <div class="row">
            <!-- <div class="col-lg-6 col-md-12">
              <label>Unit Kerja</label>
              <select class="form-control select2-navy" style="width: 100%;"
                  id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                  <?php if($unit_kerja){
                      foreach($unit_kerja as $uk){ if($uk['id_unitkerja'] != 0 && $uk['id_unitkerja'] != 5){
                      ?>
                      <?php if($this->general_library->isProgrammer() ||
                      $this->general_library->isAdminAplikasi() ||
                      $this->general_library->getBidangUser() == ID_BIDANG_PEKIN){ ?>
                        <option value="<?=$uk['id_unitkerja']?>">
                            <?=$uk['nm_unitkerja']?>
                        </option>
                      <?php } else { if($uk['id_unitkerja'] == $this->general_library->getIdUnitKerjaPegawai()){ ?>
                        <option value="<?=$uk['id_unitkerja']?>">
                            <?=$uk['nm_unitkerja']?>
                        </option>
                      <?php } } ?>
                  <?php } } } ?>
              </select>
            </div> -->
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Pilih Bulan</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                        <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                        <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                        <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                        <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                        <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                        <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                        <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                        <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                        <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                        <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                        <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                        <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Pilih Tahun</label>
                    <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
            </div>
          </div>
          <div class="col-lg-12 mt-2 text-right">
            <!-- <button type="submit" class="btn btn-navy btn-block"><i class="fa fa-lock"></i> LOCK</button> -->
            <button type="submit" class="btn btn-navy btn-block"><i class="fa fa-search"></i> Cari</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-12 p-3" style="margin-top: -25px;">
    <div class="card card-default">
      <div class="modal-body" id="result"></div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $('#id_unitkerja').select2()
    $('#bulan').select2()
    // $('#tahun').select2()
    loadListLockTpp()
  })

  function loadListLockTpp(){
    $('#result').html('')
    $('#result').append(divLoaderNavy)
    $('#result').load('<?=base_url("master/C_Master/loadLockTpp/")?>'+$('#bulan').val()+'/'+$('#tahun').val(), function(){
      $('#loader').hide()
    })
  }

  $('#form_lock_tpp').on('submit', function(e){
    e.preventDefault()
    $('#result').html('')
    $('#result').append(divLoaderNavy)
    $.ajax({
        url: '<?=base_url("master/C_Master/inputLockTpp")?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
          loadListLockTpp()
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
    })
  })
</script>