<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">REKAP HUKUMAN DISIPLIN</div>
            </div>
            <div class="card-body" style="margin-top: -25px;">
                <form id="form_search">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <label>Perangkat Daerah</label>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja">
                                <option value="0">Semua</option>
                                <?php foreach($list_skpd as $ls){ ?>
                                    <option value="<?=$ls['id_unitkerja']?>"><?=$ls['nm_unitkerja']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4">
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
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4 mt-3 text-right">
                            <button class="btn btn-navy" type="submit" id="button_search"><i class="fa fa-search"></i> Cari Data</button>
                            <button class="btn btn-navy" disabled style="display: none;" id="button_search_loading"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">
                    LIST REKAP HUKUMAN DISIPLIN
                </div>
            </div>
            <div class="card-body" id="div_result" style="margin-top: -25px;"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#unitkerja').select2()
        $('#bulan').select2()
        $('#skpd').select2()
    })

    $('#form_search').on('submit', function(e){
        e.preventDefault()
        $('#button_search').hide()
        $('#button_search_loading').show()
        $('#div_result').html('')
        $('#div_result').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/searchDataHukdis")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_result').html(data)
                $('#button_search').show()
                $('#button_search_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#button_search').show()
                $('#button_search_loading').hide()
            }
        })
    })
</script>