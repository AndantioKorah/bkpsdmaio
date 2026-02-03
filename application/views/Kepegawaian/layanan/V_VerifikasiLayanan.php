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

<style>
  .switch {
  position: relative;
  display: inline-block;
  width: 150px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(115px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
</style>


<?php if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9 || $id_m_layanan == 21 || $id_m_layanan == 29) { ?>

  <?php $status = null; if($status_layanan['status'] == 1) {
    $status = 'checked';
  } 
  ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <table>
            <td><h3>Status Layanan <?=$nm_layanan;?> </h3></td>
            <td>  <label class="switch ml-2"><input type="checkbox" id="togBtn" <?=$status;?>><div class="slider round">
      <span class="on" style="font-size:15px;">Dibuka </span>
      <span class="off" style="font-size:15px;"> Ditutup </span></div></label></td>
          </table>  
        </div>
      </div>
    </div>
  </div>
  </div>
<?php } ?>

<script>
  $('#togBtn').change(function(){
    var id_layanan = "<?= $id_m_layanan ;?>"
    if(this.checked) {
      var status = 1;
      pesan = "Layanan <?=$nm_layanan;?> dibuka";
    } else {
      var status = 0;
        pesan = "Layanan <?=$nm_layanan;?> ditutup";
    }

      $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/updateStatusLayananPangkat/")?>',
      method: 'post',
      data : {status: status, id_layanan : id_layanan},
      success: function(){
      if(status == 1) {
        successtoast(pesan);
       } else  if(status == 0){
        successtoast(pesan);
       }    
      }, error: function(e){
      errortoast('Terjadi Kesalahan')
      }
    })
});
</script>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h5>VERIFIKASI PENGAJUAN LAYANAN <?=strtoupper($nm_layanan);?></h5></div>
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
              <label>Status Pengajuan</label>
              <select  class="form-control select2-navy" style="width: 100%"
              id="status_pengajuan" data-dropdown-css-class="select2-navy" name="status_pengajuan">
              <?php if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16) { ?>
                <option value="" >Semua</option>
                <option selected value="0">Pengajuan</option>
                <option value="1">Verifikasi BKPSDM</option>
                <option value="2">Rekomendasi TPK</option>
                <option value="3">Pengajuan Pertek</option>
                <option value="4">Proses SK Jabatan</option>
                <option value="5">BTL</option>
                <option value="7">TMS</option>
                <option value="6">Selesai</option>

              <?php } else if($id_m_layanan == 6 || $id_m_layanan == 7 || $id_m_layanan == 8 || $id_m_layanan == 9 || $id_m_layanan == 29) { ?>
                  <option value="" >Semua</option>
                  <option value="0" selected>Pengajuan</option>
                  <option value="1" >Selesai verifikasi BKPSDM dan menunggu jadwal pengusulan ke BKN</option>
                  <option value="2" >Tolak Siladen</option>
                  <option value="6" >Tolak BKN</option>
                  <option value="7" >ACC BKN</option>
                  <option value="8" >Proses SK</option>
                  <option value="3" >Usul BKAD</option>
                  <option value="4" >Diterima BKAD</option>
                  <option value="5" >Ditolak BKAD</option>
                  <?php } else { ?>
                  <option value="" >Semua</option>
                  <option value="0" selected>Pengajuan</option>
                  <option value="1" >Diterima</option>
                  <option value="2" >Ditolak</option>
                  <?php if($id_m_layanan == 10 || $id_m_layanan == 21 || $id_m_layanan == 24) { ?>
                  <option value="3" >Selesai</option>
                  <?php } ?>
                  <?php } ?>
              </select>
            </div>
<?php if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16) { ?>
        <div class="col" id="pilih_tahun" style="display:none;">
                <label for="exampleFormControlInput1">Tahun SK</label>
                <input  class="form-control yearpicker customInput" id="tahun" name="tahun" value="<?= date('Y');?>">
              </div>


            <div class="col" id="pilih_bulan" style="display:none;">
                <label>Bulan SK</label>
                <select class="form-control select2-navy customInput" style="width: 100%"
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                 <option selected value="0">- Pilih Bulan -</option>
                 <option  value="1">Januari</option>
                 <option  value="2">Februari</option>
                 <option  value="3">Maret</option>
                 <option  value="4">April</option>
                 <option  value="5">Mei</option>
                 <option  value="6">Juni</option>
                 <option  value="7">Juli</option>
                 <option  value="8">Agustus</option>
                 <option  value="9">September</option>
                 <option  value="10">Oktober</option>
                 <option  value="11">November</option>
                 <option  value="12">Desember</option>
                 </select>
              </div>

                  <?php } ?>

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

    var id_m_layanan = "<?=$id_m_layanan;?>"
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    e.preventDefault()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/searchPengajuanLayanan/")?>'+id_m_layanan,
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

     $('#status_pengajuan').on('change', function(){
      if(this.value == 6){
       $('#pilih_tahun').show('fast')
       $('#pilih_bulan').show('fast')
      } else {
      $('#pilih_tahun').hide()
       $('#pilih_bulan').hide()
      }
        // $(this).val(formatRupiah(this.value));
    });
</script>