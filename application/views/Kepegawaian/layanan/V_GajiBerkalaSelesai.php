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
        <div class="card-title"><h5>VERIFIKASI PENGAJUAN LAYANAN</h5></div>
        <hr>
      </div>
      <div class="card-body">
        <form id="form_search">
          <div class="row" style="margin-top: -40px;">
          
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
         

              <div class="col">
              <label>Status</label>
              <select class="form-control select2-navy" style="width: 100%"
              id="status" data-dropdown-css-class="select2-navy" name="status">
                  <option value="0" selected>Semua</option>
                  <option value="3" >Selesai BKPSDM</option>
                  <option value="6" >ACC Operator SIMGAJI</option>
                  <option value="4" >Diterima BKAD</option>
                  <option value="5" >Ditolak BKAD</option>
                
              </select>
            </div>

            <div class="col">
              <label>Tahun</label>
              <input class="form-control select2-navy yearpicker" style="width: 100%"
              id="gb_tahun" data-dropdown-css-class="select2-navy" name="gb_tahun" value="<?=date('Y');?>">
              </input>
            </div>

           

          </div>
            
          <div class="row mt-3">
            <div class="col-lg-12 text-right">
              <button class="btn btn-navy" type="submit"><i class="fa fa-search"></i> Cari</button>
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
      url: '<?=base_url("kepegawaian/C_Kepegawaian/loadListGajiBerkalaSelesaiItem/")?>',
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