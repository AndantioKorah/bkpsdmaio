<style>
  .lbl_status_pengajuan_1, .lbl_status_pengajuan_2{
    padding: 5px;
    border-radius: 5px;
    background-color: yellow;
    font-weight: bold;
    font-size: .7rem;
  }

  .lbl_status_pengajuan_3, .lbl_status_pengajuan_5{
    padding: 5px;
    border-radius: 5px;
    background-color: red;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }

  .lbl_status_pengajuan_4{
    padding: 5px;
    border-radius: 5px;
    background-color: green;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h5>VERIFIKASI PERMOHONAN CUTI</h5></div>
        <hr>
      </div>
      <div class="card-body">
        <form id="form_search">
          <div class="row" style="margin-top: -40px;">
            <?php if($this->general_library->isKepalaBkpsdm() || $this->general_library->isAdminAplikasi() || $this->general_library->isProgrammer()){?>
              <div class="col">
                <label>Unit Kerja</label>
                <select class="form-control select2-navy" style="width: 100%"
                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                    <option value="0" selected>Semua</option>
                    <?php if($unitkerja){
                        foreach($unitkerja as $uk){ if($uk['id_unitkerja'] != "0") {
                        ?>
                        <option value="<?=$uk['id_unitkerja']?>">
                            <?=$uk['nm_unitkerja']?>
                        </option>
                    <?php } } } ?>
                </select>
              </div>
            <?php } ?>
            <div class="col">
              <label>Status Pengajuan</label>
              <select class="form-control select2-navy" style="width: 100%"
              id="id_m_status_pengajuan_cuti" data-dropdown-css-class="select2-navy" name="id_m_status_pengajuan_cuti">
                  <option value="0" selected>Semua</option>
                  <?php if($master_status){
                      foreach($master_status as $ms){
                      ?>
                      <option 
                      <?php
                        if($this->general_library->isKepalaBkpsdm()){
                          if($ms['id'] == 2){
                            echo "selected";
                          }
                        } else if($this->general_library->isKepalaPd() && !$this->general_library->isKepalaBkpsdm()){
                          if($ms['id'] == 1){
                            echo "selected";
                          }
                        }
                      ?>
                      value="<?=$ms['id']?>">
                          <?=$ms['nama_status']?>
                      </option>
                  <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 text-right">
              <button class="btn btn-navy" type="submit"><i class="fa fa-search"></i> Submit Pencarian</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-12 mt-2">
    <div class="card card-detail" id="result_search"></div>
  </div>
</div>
<script>
  $(function(){
    $('#id_unitkerja').select2()
    $('#id_m_status_pengajuan_cuti').select2()
    $('#form_search').submit()
  })

  $('#form_search').on('submit', function(e){
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    e.preventDefault()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/searchPermohonanCuti")?>',
      method:"POST",  
      data: $(this).serialize(),
      success: function(res){
        $('#result_search').html('')        
        $('#result_search').append(res)        
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
      }
    })
  })
</script>