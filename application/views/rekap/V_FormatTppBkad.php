<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">REKAP TTPP PERMINTAAN BKAD</h3>
    </div>
    <div class="card-body">
        <div class="row" style="margin-top: -20px;">
            <div class="col-lg-12 mb-3">
                <form id="form_search">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                    </div>
                </form>
            <hr>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="div_result"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#bulan').select2()
        // loadDataRekap() 
        $('#form_search').submit()       
    })

    $('#bulan').on('change', function(){
        $('#form_search').submit()       
    })

    $('#tahun').on('change', function(){
        $('#form_search').submit()       
    })

    $('#form_search').on('submit', function(e){
        e.preventDefault()
        $('.div_result').html('')
        $('.div_result').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/loadFormatTppBkadData')?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(rs){
                $('.div_result').html('')
                $('.div_result').html(rs)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })

    })

    // function loadDataRekap(){
    //     $('.div_result').html('')
    //     $('.div_result').append(divLoaderNavy)
    //     $('.div_result').load('<?=base_url("rekap/C_Rekap/loadFormatTppBkadData")?>', function(){
    //         $('#loader').hide()
    //     })
    // }
</script>