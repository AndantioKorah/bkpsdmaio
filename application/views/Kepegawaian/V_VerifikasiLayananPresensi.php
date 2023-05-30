<form id="form_search_presensi">
  <div class="row">
    <div class="col-lg-6">
      <div class="form-group">
        <label class="bmd-label-floating">Bulan</label>
        <select class="form-control select2-navy" style="width: 100%"
            data-dropdown-css-class="select2-navy" name="bulan">
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
    <div class="col-lg-6">
      <div class="form-group">
        <label class="bmd-label-floating">Tahun</label>
        <input readonly autocomplete="off" class="form-control yearpicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
      </div>
    </div>
    <div class="col-lg-8"></div>
    <div class="col-lg-4 text-right mt-2">
      <div class="form-group">
        <!-- <label class="bmd-label-floating"></label> -->
        <button class="btn btn-navy" type="submit"><i class="fa fa-search"></i> Cari</button>
      </div>
    </div>
    <div id="div_result" class="col-lg-12 mt-3"></div>
  </div>
</form>
<script>
  $(function(){
    $('.select2-navy').select2()

    $('#form_search_presensi').submit()

    $('.yearpicker').datepicker({
      format: 'yyyy',
      viewMode: "years", 
      minViewMode: "years",
      orientation: 'bottom',
      autoclose: true
    });
  })

  $('#form_search_presensi').on('submit', function(e){
    $('#div_result').html('')
    $('#div_result').append(divLoaderNavy)
    e.preventDefault()
    $.ajax({
      url: '<?=base_url('kepegawaian/C_Kepegawaian/getDataPresensiPegawai/'.$id_pegawai)?>',
      method: 'POST',
      data: $(this).serialize(),
      success: function(data){
        $('#div_result').html('')
        $('#div_result').html(data)
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
      }
    })
  })
</script>