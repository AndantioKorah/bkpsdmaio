<div class="card card-default">
    <div class="card-header">
        <h4>Sasaran Kerja Bulanan Pegawai (SKBP)</h4>
    </div>
    <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-12">
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
                <div class="col-lg-4 col-md-12">
                    <label>Pilih Tahun</label>  
                    <input style="height:38px;" readonly autocomplete="off" class="form-control yearpicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg-4 col-md-12" style="margin-top: 25px;">
                    <button id="btn_submit" type="button" onclick="inputSkbp(0, 0, 0)" href="#skbp_modal" data-toggle="modal"
                    class="btn btn-block customButton" style="color:#fff;">
                    <i class="fa fa-file-export"></i> Submit</button>
                </div>
            </div>
    </div>
</div>
<div class="modal fade" id="skbp_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title">SKBP</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="skbp_modal_content">
          </div>
      </div>
  </div>
</div>

<div class="row">
    <div class="col-12" id="result">
    </div>
</div>

<script>
    var tahun_ini = '<?=date('Y')?>'
    var bulan_ini = '<?=date('m')?>'
    $(function(){
        $('#bulan').select2();
        loadListSkbp();
    })

    $('#bulan').on('change', function(){
        validator()
    })

    $('#tahun').on('change', function(){
        validator()
    })

    function validator(){
        var tahun = $('#tahun').val()
        var bulan = $('#bulan').val()
        if(parseInt(tahun) > parseInt(tahun_ini)){
            errortoast('Tidak bisa membuat SKBP di atas Bulan dan Tahun berjalan')
            $('#btn_submit').hide()
        } else if(parseInt(tahun_ini) <= parseInt(tahun) && parseInt(bulan_ini) < parseInt(bulan) ){
            errortoast('Tidak bisa membuat SKBP di atas Bulan dan Tahun berjalan')
            $('#btn_submit').hide()
        } else {
            $('#btn_submit').show()
        }
    }

    function loadListSkbp(){
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        $('#result').load('<?=base_url("kinerja/C_Kinerja/loadListSkbpPegawai/").$this->general_library->getId();?>', function(){
            $('#loader').hide()
        })
    }

    function inputSkbp(bulan, tahun, flag_edit){
        if(flag_edit == 0){
            bulan = $('#bulan').val()
            tahun = $('#tahun').val()
        }

        $('#skbp_modal_content').html('')
        $('#skbp_modal_content').append(divLoaderNavy)
        $('#skbp_modal_content').load('<?=base_url("kinerja/C_Kinerja/inputSkbp/").$this->general_library->getId()?>'+'/'+bulan+'/'+tahun, function(){
            $('#loader').hide()
        })
    }
</script>