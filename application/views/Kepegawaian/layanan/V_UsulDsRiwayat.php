<div class="row">
  <div class="col-lg-12">
    <form id="form_riwayat">
      <div class="row">
        <div class="col-lg-6 col-md-6">
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
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label class="bmd-label-floating">Pilih Tahun</label>
                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
            </div>
        </div>
        <div class="col-lg-12 mt-3 text-right">
          <button id="btn_search" class="btn btn-navy"><i class="fa fa-search"></i> Cari</button>
          <button id="btn_search_loading" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mencari...</button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-lg-12 mt-3" id="div_result_item"></div>
</div>

<script>
  $(function(){
    $('#form_riwayat').submit()
  })

  $('#form_riwayat').on('submit', function(e){
    e.preventDefault()
    $('#div_result_item').html('')
    $('#div_result_item').append(divLoaderNavy)

    $('#btn_search').hide()
    $('#btn_search_loading').show()
    $.ajax({
        url: '<?=base_url("kepegawaian/C_Layanan/loadRiwayatUsulDsData")?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
          $('#btn_search').show()
          $('#btn_search_loading').hide()
          $('#div_result_item').html(data)
        }, error: function(e){
          $('#btn_search').show()
          $('#btn_search_loading').hide()
          errortoast('Terjadi Kesalahan')
        }
    })
  })
</script>