<style>
  .sp_catatan{
    font-style: italic;
    font-weight: bold;
    color: grey;
    font-size: .7rem;
  }

  .lbl_input{
    font-weight: bold;
    font-size: .9rem;
    color: black;
  }

  .lbl_jumlah_hari_cuti, .lbl_cuti_option{
    font-weight: bold;
    font-size: 1rem;
    color: black;
  }

  .lbl_cuti_year{
    font-weight: bold;
    color: black;
    font-size: .8rem;
  }

  .form_cuti_option{
    text-align: center;
    font-size: .9rem;
  }
</style>
<?php
  $arrCuti = [
    00,
    // 10, // cuti besar
    20,
    30,
    40, 
    // 50, // CLTN
  ];

  if(!$this->general_library->isBisaAmbilCutiTahunan()){
    $arrCuti = [20, 30, 40,]; // tanpa cuti tahunan
  }
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h5>FORM PERMOHONAN CUTI</h5></div>
        <hr>
      </div>
      <?php // if($this->general_library->isProgrammer()){ ?>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="form_cuti" style="margin-top: -45px;">
          <div class="row">
            <div class="col-lg-12">
              
            </div>
            <div class="col">
              <label class="lbl_input">Jenis Cuti</label>
              <select class="form-control select2-navy" style="width: 100%"
              id="id_cuti" data-dropdown-css-class="select2-navy" name="id_cuti">
                  <?php if($master_jenis_cuti){
                      foreach($master_jenis_cuti as $mc){ 
                        if(in_array($mc['id_cuti'], $arrCuti)){ // cuti besar dan CLTN tahan dulu
                        // if((!$this->general_library->isBisaAmbilCutiTahunan() && !$mc['id_cuti'] == 00) ||
                        //   $this->general_library->isBisaAmbilCutiTahunan()
                        // ){
                      ?>
                      <option value="<?=$mc['id_cuti']?>">
                          <?=$mc['nm_cuti']?>
                      </option>
                  <?php // } 
                } } } ?>
              </select>
            </div>
            <div class="col" id="div_surat_pendukung" style="display: block;">
              <label class="lbl_input">Surat Pendukung</label>
              <input name="surat_pendukung" id="surat_pendukung" class="form-control" type="file" />
              <label style="font-style: italic; color: red; font-size: .75rem; font-weight: bold;" id="lbl_keterangan_surat_pendukung">*surat pendukung dibutuhkan jika hendak bepergian ke luar negeri</label>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-5">
              <label class="lbl_input">Tanggal Mulai</label>
              <input class="form-control" name="tanggal_mulai" id="tanggal_mulai" readonly value="<?=date('Y-m-d')?>" />
            </div>
            <div class="col-lg-5">
              <label class="lbl_input">Tanggal Akhir</label>
              <input class="form-control" name="tanggal_akhir" id="tanggal_akhir" readonly value="<?=date('Y-m-d')?>" />
            </div>
            <div class="col-lg-2">
              <label class="lbl_input">Lamanya Cuti</label><br>
              <input class="lbl_jumlah_hari_cuti form-control" name="lama_cuti" readonly value="1 Hari" />
            </div>
            <div class="col-lg-12">
              <span id="lbl_catatan_satu_hari" class="sp_catatan">*catatan: Jika cuti hanya 1 hari gunakan Tanggal Mulai dan Tanggal Akhir yang sama</span>
            </div>
          </div>
          <div class="row mt-2" id="div_cuti_option">
            <div class="col-lg-6 text-center">
              <label class="lbl_cuti_option">Sisa Cuti</label>
              <div class="row">
                <?php foreach($sisa_cuti as $sc){ ?>
                  <div class="col-lg-4 col-md-4 col-sm-4 text-center">
                    <label class="lbl_cuti_year"><?=$sc['tahun']?></label>
                    <input class="form-control form_cuti_option" name="sisa_cuti[<?=$sc['tahun']?>]" readonly value="<?=$sc['sisa']?>" />
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 text-center">
              <label class="lbl_cuti_option">Keterangan Cuti</label>
              <div class="row">
                <?php foreach($sisa_cuti as $sct){ ?>
                  <div class="col-lg-4 col-md-4 col-sm-4 text-center">
                    <label class="lbl_cuti_year"><?=$sct['tahun']?></label>
                    <input class="form-control form_cuti_option" name="keterangan_cuti[<?=$sct['tahun']?>]" value="" />
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-12"><hr></div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-6">
              <label class="lbl_input">Alasan Cuti</label>
              <textarea id="alasan" class="form-control" rows=3 name="alasan"></textarea>
            </div>
            <div class="col-lg-6">
              <label class="lbl_input">Alamat Selama Melaksanakan Cuti</label>
              <textarea id="alamat" class="form-control" rows=3 name="alamat"></textarea>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-6"></div>
            <div class="col-lg-6 text-right">
              <!-- <button id="btn_submit" type="submit" class="btn btn-block btn-navy">Ajukan Cuti</button> -->
              <?php //if($atasan['kepala']){ ?>
                <button id="btn_submit" class="btn btn-block btn-navy">Ajukan Cuti</button>
                <button style="display: none;" disabled id="btn_loading_submit" type="btn" class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
              <?php // } else { ?>
                  <!-- <h5 style="color: red;">*Data atasan tidak ditemukan, silahkan menghubungi Admin Siladen</h5> -->
              <?php //} ?>
            </div>
          </div>
        </form>
      </div>
      <?php // } else { ?>
        <!-- <h5 style="color: red; font-weight: bold; font-size: 1.2rem;">Fitur permohonan cuti sedang dalam maintenance</h5> -->
      <?php // } ?>
    </div>
  </div>
  <div class="col-lg-12 mt-3">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <div class="card-title"><h5>RIWAYAT PERMOHONAN CUTI</h5></div>
          <hr>
        </div>
      </div>
      <div class="card-body">
        <div class="row" style="margin-top: -40px;">
          <div class="col-lg-12 table-responsive" id="riwayat_cuti"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    loadRiwayatCuti()
    $('#id_cuti').select2()
    $('#tanggal_mulai').datepicker({
      format: 'yyyy-mm-dd',
      orientation: 'bottom',
      autoclose: true,
      todayBtn: true
    })
    $('#tanggal_akhir').datepicker({
      format: 'yyyy-mm-dd',
      orientation: 'bottom',
      autoclose: true,
      todayBtn: true
    })
  })

  function loadRiwayatCuti(){
    $('#riwayat_cuti').html('')
    $('#riwayat_cuti').append(divLoaderNavy)
    $('#riwayat_cuti').load('<?=base_url('kepegawaian/C_Kepegawaian/loadRiwayatPermohonanCuti')?>', function(){
      $('#loader').hide()
    })
  }

  function countTanggalAkhirCutiBersalin(){
    if($('#id_cuti').val() == "30"){
      tglMulai = $('#tanggal_mulai').val()
      tglAkhir = new Date(tglMulai).setMonth(new Date().getMonth() + 3)
      tglAkhir = new Date(tglAkhir)

      offset = tglAkhir.getTimezoneOffset()
      tglAkhir = new Date(tglAkhir.getTime() - (offset*60*1000))
      
      $('#tanggal_akhir').val(tglAkhir.toISOString().split('T')[0])

      countJumlahHariCuti()

      $('#lbl_catatan_satu_hari').hide()
    } else {
      $('#lbl_catatan_satu_hari').show()
    }
  }

  $('#id_cuti').on('change', function(){
    if($(this).val() == "30"){
      // $('#tanggal_akhir').attr('disabled', true)
      countTanggalAkhirCutiBersalin()
    } else {
      // $('#tanggal_akhir').attr('disabled', false)
      $('#tanggal_akhir').val($('#tanggal_mulai').val())
    }

    countJumlahHariCuti()

    if($(this).val() == "00"){
      $('#lbl_keterangan_surat_pendukung').show()
      $('#div_cuti_option').show()
    } else {
      $('#lbl_keterangan_surat_pendukung').hide()
      $('#div_cuti_option').hide()
    }

    if($(this).val() == "10"){

    }
  })

  $('#tanggal_mulai').on('change', function(){
    countTanggalAkhirCutiBersalin()
    countJumlahHariCuti()
  })

  $('#tanggal_akhir').on('change', function(){
    countJumlahHariCuti()
  })

  function countJumlahHariCuti(){
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/countJumlahHariCuti")?>',
      method:"POST",  
      data:{
        tanggal_mulai: $('#tanggal_mulai').val(),
        tanggal_akhir: $('#tanggal_akhir').val(),
        id_cuti: $('#id_cuti').val()
      },
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
          $('#tanggal_mulai').val('<?=date('d-m-Y')?>')
          $('#tanggal_akhir').val($('#tanggal_mulai').val())
          $('.lbl_jumlah_hari_cuti').val("1 Hari")
        } else {
          $('.lbl_jumlah_hari_cuti').val(rs.data[0]+" Hari")
        }
      }, error: function(err){
        errortoast('Terjadi Kesalahan')
      }
    })
  }

  $('#form_cuti').on('submit', function(e){
    e.preventDefault()
    $('#btn_submit').hide()
    $('#btn_loading_submit').show()
    var formvalue = $('#form_cuti');
    var form_data = new FormData(formvalue[0]);

    var ins = document.getElementById('surat_pendukung').files.length;
    if(ins == 0 && ($(this).val() == "10" || $(this).val() == "20" || $(this).val() == "30" || $(this).val() == "40")){
      errortoast("Silahkan melampirkan Surat Pendukung");
      $('#btn_submit').show()
      $('#btn_loading_submit').hide()
      return false;
    }

    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/submitPermohonanCuti")?>',
      method:"POST",  
      data:form_data,  
      contentType: false,  
      cache: false,  
      processData:false,
      success: function(res){
        let rs = JSON.parse(res)
        if(rs.code == 1){
          errortoast(rs.message)
        } else {
          successtoast(rs.message)
          $('#tanggal_mulai').val('<?=date('d-m-Y')?>')
          $('#tanggal_akhir').val('<?=date('d-m-Y')?>')
          $('#alamat').val('')
          $('#alasan').val('')
          $('.lbl_jumlah_hari_cuti').val("1 Hari")
          window.location=""
        }
        $('#btn_submit').show()
        $('#btn_loading_submit').hide()
      }, error: function(err){
        $('#btn_submit').show()
        $('#btn_loading_submit').hide()
        errortoast('Terjadi Kesalahan')
      }
    })
    $('#btn_submit').show()
    $('#btn_loading_submit').hide()
  })
</script>