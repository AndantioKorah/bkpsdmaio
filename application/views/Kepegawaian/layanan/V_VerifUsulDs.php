<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h4>VERIF USUL DS</h4></div>
      </div>
      <div class="card-body">
        <div class="col-lg-12">
        <form id="form_search_usul_ds">
          <div class="row">
              <div class="col-lg-6">
                <label class="bmd-label-floating">Pilih Bulan</label>
                <select class="form-control form-control-sm select2-navy" style="width: 100%"
                    id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                    <option value="0">Semua</option>
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
              <div class="col-lg-6">
                <label class="bmd-label-floating">Pilih Tahun</label>
                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
              </div>  
              <div class="col-lg-12 mt-3 text-right">
                <button class="btn btn-navy"><i class="fa fa-search"></i> Cari</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 mt-3">
    <div class="card card-default">
      <div class="card-body" id="div_search"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_usul_ds" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">VERIFIKASI USUL DS</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_usul_ds_content">
          </div>
      </div>
  </div>
</div>

<script>
  $(function(){
    $('#bulan').select2()
    let list_checked = []
    let terpilih = 0
    $('#form_search_usul_ds').submit()
  })

  $('#form_search_usul_ds').on('submit', function(e){
    e.preventDefault()

    $('#div_search').html('')
    $('#div_search').append(divLoaderNavy)

    $.ajax({
      url: '<?=base_url("kepegawaian/C_Layanan/searchVerifUsulDs")?>',
      method: 'post',
      data: $(this).serialize(),
      success: function(data){
        $('#div_search').html(data)
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
      }
    })
  })
</script>