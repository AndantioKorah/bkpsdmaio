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
        <div class="card-title"><h5>VERIFIKASI OPERATOR PERMOHONAN CUTI</h5></div>
        <hr>
      </div>
      <div class="card-body">
        <form id="form_search">
          <div class="row" style="margin-top: -40px;">
            <div class="col-lg-6 col-md-12">
              <label>PERANGKAT DAERAH</label>
              <select class="form-control select2-navy" style="width: 100%"
                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                    <option value="0" selected>Semua</option>
                  <?php 
                    foreach($unitkerja as $uk){
                  ?>
                    <option value="<?=$uk['id_unitkerja']?>">
                        <?=$uk['nm_unitkerja']?>
                    </option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-lg-3 col-md-12">
              <label>Pilih Bulan</label>  
              <select class="form-control select2-navy" style="width: 100%"
                  id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                  <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                  <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Februari</option>
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
            <div class="col-lg-3 col-md-12">
              <label>Pilih Tahun</label>  
              <input style="height:38px;" readonly autocomplete="off" class="form-control yearpicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
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
    <div class="card card-detail p-3" id="result_search"></div>
  </div>
</div>
<script>
  $(function(){
    $('#id_unitkerja').select2()
    $('#bulan').select2()
    $('#id_m_status_pengajuan_cuti').select2()
    $('#form_search').submit()
  })

  $('#id_unitkerja').on('change', function(){
    $('#form_search').submit()  
  })

  $('#form_search').on('submit', function(e){
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    e.preventDefault()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/searchOperatorPermohonanCuti")?>',
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