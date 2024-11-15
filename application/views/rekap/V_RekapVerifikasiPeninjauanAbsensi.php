<div class="row">
  <div class="col-lg-12">
    <div class="card card-default p-3">
      <form class="form-custom" id="form_search_dokumen_verif">
        <div class="row">
          <div class="col-lg-12">
            <label>Tanggal</label>
            <input class="form-control form-custom-input daterangepickerthis" id="tanggal" readonly name="tanggal"/>
          </div>
          <div class="col-lg-12">
            <div class="form-check">
              <input name="all" style="cursor: pointer;" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              <label style="cursor: pointer;" class="form-check-label" for="flexCheckDefault">
                Semua
              </label>
            </div>
          </div>
          <div class="col-lg-12 mt-3 text-right">
            <button type="submit" style="width: 25% !important; height: 35px !important; font-size: .8rem;"
            class="btn btn-navy btn-sm">SUBMIT PENCARIAN <i class="fa fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  <div class="col-lg-12 p-3" style="display: none;" id="wrapper_result">
    <div id="result" class="card card-default p-3">
                  
    </div>
  </div>
</div>
<script>
  $(function(){
    // $('#form_search_dokumen_verif').submit()
  })

  $('#form_search_dokumen_verif').on('submit', function(e){
    $('#wrapper_result').show()
    $('#result').html('')
    $('#result').append(divLoaderNavy)
    e.preventDefault()
    $.ajax({
      url: '<?=base_url('kepegawaian/C_Kepegawaian/searchRekapVerifPeninjauanAbsensi')?>',
      method: 'post',
      data: $(this).serialize(),
      success: function(data){
        $('#result').html('')
        $('#result').append(data)
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
        console.log(e)
      }
    })
  })
</script>