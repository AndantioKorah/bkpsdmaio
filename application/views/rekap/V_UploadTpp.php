<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">UPLOAD BERKAS TPP</h3>
                <hr>
            </div>
            <div class="card-body">
                <form method="post" id="form_upload_berkas_tpp" enctype="multipart/form-data">
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih SKPD</label>
                                    <select class="form-control select2-navy" style="width: 100%;"
                                    id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                                        <?php if($list_skpd){
                                            foreach($list_skpd as $uk){ if($uk['id_unitkerja'] != 0 && $uk['id_unitkerja'] != 5){
                                            ?>
                                            <?php if($this->general_library->isProgrammer() 
                                            || $this->general_library->isAdminAplikasi() 
                                            || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN){ ?>
                                            <option value="<?=$uk['id_unitkerja'].';'.$uk['nm_unitkerja']?>">
                                                <?=$uk['nm_unitkerja']?>
                                            </option>
                                            <?php } else if($this->general_library->getIdUnitKerjaPegawai() == 1030525){
                                                $list_uk_bagian_umum = [1030525, 1000001, 2000100]; //jika Bagian UMUM, buka akses untuk bagian umum, setda, staf ahli
                                                if(in_array($uk['id_unitkerja'], $list_uk_bagian_umum)){
                                            ?> 
                                                <option value="<?=$uk['id_unitkerja'].';'.$uk['nm_unitkerja']?>">
                                                    <?=$uk['nm_unitkerja']?>
                                                </option>
                                            <?php } } else { if($uk['id_unitkerja'] == $this->general_library->getIdUnitKerjaPegawai()){ ?>
                                            <option value="<?=$uk['id_unitkerja'].';'.$uk['nm_unitkerja']?>">
                                                <?=$uk['nm_unitkerja']?>
                                            </option>
                                            <?php } } ?>
                                        <?php } } ?>
                                        <?php 
                                            if($this->general_library->isProgrammer() 
                                            || $this->general_library->isAdminAplikasi() 
                                            || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
                                            || $this->general_library->getIdUnitKerjaPegawai() == 3010000) //jika diknas, buka akses untuk Sekolah per Kecamatan
                                            { 
                                                foreach($skpd_diknas as $sd){
                                        ?>
                                            <option value="<?='sekolah_'.$sd['id_unitkerja'].';'.$sd['nm_unitkerja']?>">
                                                <?=$sd['nm_unitkerja']?>
                                            </option>
                                        <?php } } ?>
                                    <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
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
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div style="display: none;" id="div_upload_button">
                            <div class="col-lg-12 mt-3">
                                <label>Pilih Berkas</label>
                                <input class="form-control" type="file" id="input_tpp" name="input_tpp" />
                            </div>
                            <div class="col-lg-12 mt-3 text-right">
                                <button id="btn_upload" class="btn btn-navy" type="submit"><i class="fa fa-upload"></i> Upload</button>
                                <button style="display: none;" id="btn_upload_loading" class="btn btn-navy" disabled><i class="fa fa-spin fa-spinner"></i> Uploading...</button>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mt-3" id="div_upload_check">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">RIWAYAT UPLOAD BERKAS TPP</h3>
                <hr>
            </div>
            <div class="card-body" id="div_riwayat_upload">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload_tpp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">UPLOAD BERKAS TPP</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_upload_tpp_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        $('#bulan').select2()
        $('#skpd').select2()
        // $('#tahun').select2()
        checkStatusUploadBerkasTpp()
        loadRiwayatUpload()
    })

    function loadRiwayatUpload(){
        
        // $('#div_riwayat_upload').load('<?=base_url('rekap/C_Rekap/loadRiwayatUploadBerkasTpp')?>', function(){
        //     $('#loader').hide()
        // })

        $('#div_riwayat_upload').html('')
        $('#div_riwayat_upload').append(divLoaderNavy)

        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/loadRiwayatUploadBerkasTpp')?>',
            method: 'POST',
            data: {
                bulan: $('#bulan').val(),
                tahun: $('#tahun').val(),
                skpd: $('#skpd').val()
            },
            success: function(rs){
                // let res = JSON.parse(rs)
                $('#div_riwayat_upload').html('')
                $('#div_riwayat_upload').html(rs)
            }, error: function(e){
                $('#div_upload_button').hide()
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }

    $('#skpd').on('change', function(){
        checkStatusUploadBerkasTpp()
    })

    $('#bulan').on('change', function(){
        checkStatusUploadBerkasTpp()
    })

    $('#tahun').on('change', function(){
        checkStatusUploadBerkasTpp()
    })

    $('#form_upload_berkas_tpp').on('submit', function(e){
        e.preventDefault()
        
        $('#btn_upload').hide()
        $('#btn_upload_loading').show()

        var formvalue = $('#form_upload_berkas_tpp');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('input_tpp').files.length;
        
        if(ins == 0){
            $('#btn_upload').show()
            $('#btn_upload_loading').hide()
            errortoast("Silahkan upload file terlebih dahulu");
            return false;
        }

        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/saveUploadBerkasTpp')?>',
            method: 'POST',
            data: form_data,  
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(rs){
                let res = JSON.parse(rs)
                if(res.code == 0){
                    successtoast('Upload berhasil, silahkan menunggu proses verifikasi oleh bidang terkait.')                    
                    document.getElementById("form_upload_berkas_tpp").reset();
                    loadRiwayatUpload()
                } else {
                    errortoast(res.message)
                }
                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
            }
        })
    })

    function checkStatusUploadBerkasTpp(){
        $('#div_upload_check').html('')
        $('#div_upload_check').append(divLoaderNavy)
        $('#div_upload_button').hide()

        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/checkStatusUploadBerkasTpp')?>',
            method: 'POST',
            data: {
                bulan: $('#bulan').val(),
                tahun: $('#tahun').val(),
                skpd: $('#skpd').val()
            },
            success: function(rs){
                let res = JSON.parse(rs)
                if(res.code == 0){
                    $('#div_upload_check').html('')
                    $('#div_upload_check').hide('')
                    $('#div_upload_button').show()
                } else {
                    $('#div_upload_button').hide()
                    $('#div_upload_check').html('<h3 style="color: red;">'+res.message+'</h3>')
                }
            }, error: function(e){
                $('#div_upload_button').hide()
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }

    $("#input_tpp").change(function (e) {

        var doc = input_tpp.value.split('.')
        var extension = doc[doc.length - 1]

        var fileSize = this.files[0].size/1024;
        var MaxSize = '20000'

        if (extension != "pdf"){
            errortoast("Harus File PDF")
            $(this).val('');
        }

        if (fileSize > MaxSize ){
            errortoast("Maksimal Ukuran File 20 MB")
            $(this).val('');
        }

    });
</script>