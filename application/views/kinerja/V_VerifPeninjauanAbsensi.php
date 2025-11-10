<div class="card card-default">



    <div class="card-header" style="margin-bottom:-40px">
        <h4>Verifikasi Peninjauan Absensi</h4>
    </div>
    <div class="card-body" >
    <?php if($this->general_library->isProgrammer()) { ?>
    Verifikasi Kolektif
        <form id="form_verifikasi_kolektif">
        <div class="row">
                <div class="col-lg col-md-12">
                    <label>Pilih Tanggal</label>  
                <input class="form-control customInput datepicker3" type="text" id="tanggal_kolektif" name="tanggal_kolektif" readonly  required/>
                </div>

                <div class="form-group mt-2">
         <label class="bmd-label-floating">Jenis Absensi </label>
         <select  class="form-control select2-navy select2" name="jenis_absensi" id="jenis_absensi"  required>
         <option value="" selected disabled>- Pilih Jenis Absen -</option>
         <option value="1" >Absen Pagi </option>
         <option value="2" >Absen Pulang </option>
         </select>
         </div>

                <div class="col-lg col-md-12" style="margin-top: 20px;">
                    <button class="btn btn-block btn-navy" id="btn_verif_kolektif"> Verifikasi</button>
                </div>

                
            </div>

            
        </form>
        <?php } ?>
        <form id="form_search_verif_dokumen" class="mt-4">
            <!-- <div class="row">
                <div class="col-lg col-md-12">
                    <label>Pilih Unit Kerja</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <option selected value="0">Semua</option>
                        <?php foreach($unitkerja as $s){ ?>
                            <option value="<?=$s['id_unitkerjamaster']?>"><?=$s['nm_unitkerjamaster']?></option>
                        <?php } ?>
                    </select>
                </div> -->
                <div class="row">
                <div class="col-lg-4 col-md-12">
                    <label>Verifikator</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja" required>
                        <option selected value="0">Semua</option>
                        <?php foreach($verifikator as $s){ ?>
                            <option value="<?=$s['id_m_user']?>"><?= strtoupper($s['nama'])?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-lg-4 col-md-12">
                    <label>Pilih Bulan</label>  
                    <select class="form-control select2-navy" style="width: 100%"
                        id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                        <option <?=date('m') == '01' ? 'selected' : ''?> value="0">Semua</option>
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
                <div class="col-lg col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg-2 col-md-9" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="tambah_data_disiplin_kerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">Data Dokumen Pendukung</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="tambah_data_disiplin_kerja_content">
          </div>
      </div>
  </div>
</div>
<div class="row">
    <div class="col-12" id="result">
    </div>
</div>

<script>
    let active_status = 0

    $(function(){
        $('#bulan').select2()
        $('#id_unitkerja').select2()
        // $('#form_search_verif_dokumen').submit()
        $('.datepicker3').datepicker({
        format: 'yyyy-mm-dd',
            // viewMode: "years", 
            // minViewMode: "years",
            // orientation: 'bottom',
            autoclose: true
        });

        // $("#sidebar_toggle" ).trigger( "click" );
    })

    $('#form_verifikasi_kolektif').submit(function(e){
        var tgl = $('#tanggal_kolektif').val()

        document.getElementById('btn_verif_kolektif').disabled = true;
        $('#btn_verif_kolektif').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

        if(tgl == ""){
            errortoast("Pilih tanggal terlebih dahulu")
            document.getElementById('btn_verif_kolektif').disabled = false;
            $('#btn_verif_kolektif').html('Verifikasi')
            return false;
        }

        

        e.preventDefault()

       
        
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/submitPeninjauanKolektif")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                successtoast('Berhasi')
                document.getElementById('btn_verif_kolektif').disabled = false;
               $('#btn_verif_kolektif').html('Verifikasi')
                $('#form_search_verif_dokumen').submit()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#form_search_verif_dokumen').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/searchVerifTinjauAbsensi")?>',
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