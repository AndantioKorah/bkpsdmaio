<div class="row">
  <div class="col-lg-12 p-3">
    <div class="card card-default">
      <div class="modal-header">
        <h5 clsas="modal-title">LIST PEMBERIAN TPP</h5>
      </div>
      <div class="modal-body">
        <form id="form_list_tpp">
          <div class="col-lg-12">
            <select class="form-control select2-navy" style="width: 100%;"
                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                <?php if($unit_kerja){
                    foreach($unit_kerja as $uk){ if($uk['id_unitkerja'] != 0 && $uk['id_unitkerja'] != 5){
                    ?>
                    <?php if($this->general_library->isProgrammer() 
                    || $this->general_library->isAdminAplikasi()
                    || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN){ ?>
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
          </div>
          <div class="col-lg-12 mt-2 text-right">
            <button type="submit" class="btn btn-navy btn-block">SUBMIT</button>
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

    $('#form_list_tpp').submit()
  })

  $('#form_list_tpp').on('change', function(){
    $('#form_list_tpp').submit()
  })

  $('#form_list_tpp').on('submit', function(e){
    e.preventDefault()
    $('#result').html('')
    $('#result').append(divLoaderNavy)
    $.ajax({
        url: '<?=base_url("master/C_Master/loadListNominatifPegawai")?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
            $('#result').html('')
            $('#result').append(data)
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
    })
  })
</script>