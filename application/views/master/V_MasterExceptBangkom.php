<div class="row">
    <div class="col-lg-12 p-3">
        <div class="card card-default">
            <div class="modal-header">
                <h5 clsas="modal-title">Except Bangkom</h5>
            </div>
            <div class="modal-body">
                <form id="form_except_bangkom">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Bulan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                                    <option <?=date('m') == '0' ? 'selected' : ''?> value="0">Semua</option>
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
                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="bmd-label-floating">Unit Kerja</label>
                            <select class="form-control select2-navy" style="width: 100%;"
                                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                                    <option value="0">
                                        Semua
                                    </option>
                                <?php if($unit_kerja){
                                    foreach($unit_kerja as $ls){
                                    ?>
                                    <option value="<?=$ls['id_unitkerja']?>">
                                        <?=$ls['nm_unitkerja']?>
                                    </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label class="bmd-label-floating">Keterangan</label>
                            <input class="form-control" name="keterangan" />
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2 text-right">
                        <!-- <button type="submit" class="btn btn-navy btn-block"><i class="fa fa-lock"></i> LOCK</button> -->
                        <button type="submit" id="btn_save" class="btn btn-navy btn-block"><i class="fa fa-save"></i> Simpan</button>
                        <button style="display: none;" type="button" disabled id="btn_save_loader" class="btn btn-navy btn-block"><i class="fa fa-spin fa-spinner"></i> Menunggu...</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 p-3" style="margin-top: -25px;">
        <div class="card card-default">
            <div class="modal-body" id="div_list_except_bangkom"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#id_unitkerja').select2()
        $('#bulan').select2()
        // $('#tahun').select2()
        loadListExceptBangkom()
    })

  function loadListExceptBangkom(){
    $('#div_list_except_bangkom').html('')
    $('#div_list_except_bangkom').append(divLoaderNavy)
    $('#div_list_except_bangkom').load('<?=base_url("master/C_Master/loadExceptBangkom")?>', function(){
        $('#loader').hide()
    })
  }

  $('#form_except_bangkom').on('submit', function(e){
    $('#btn_save').hide()
    $('#btn_save_loader').show()
    e.preventDefault()
    $('#div_list_except_bangkom').html('')
    $('#div_list_except_bangkom').append(divLoaderNavy)
    $.ajax({
        url: '<?=base_url("master/C_Master/inputExceptBangkom")?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
            loadListExceptBangkom()
            $('#btn_save').show()
            $('#btn_save_loader').hide()
            succestoast('Data berhasil ditambahkan')
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
            $('#btn_save').show()
            $('#btn_save_loader').hide()
        }
    })
  })
</script>