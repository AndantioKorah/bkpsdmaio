<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">DATA PEGAWAI KENAIKAN GAJI BERKALA</h5>
        <hr>
    </div>
    <div class="card-body" style="margin-top: -30px;">
        <form id="form_search">
            <div class="row">
                <div class="col-lg-3">
                    <label>Pilih Tahun</label>
                    <input autocomplete="off" value="<?=date('Y')?>" class="form-control tahunpicker" name="tahun" id="tahun" />
                </div>
                <div class="col-lg-3">
                    <label>Pilih Bulan</label>
                    <select class="form-control select2-navy customInput" style="width: 100%"
                        id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                        <option value="0" selected>Semua</option>
                        <option <?=date('m') == 1 ? '' : '';?> value="1">Januari</option>
                        <option <?=date('m') == 2 ? '' : '';?> value="2">Feburari</option>
                        <option <?=date('m') == 3 ? '' : '';?> value="3">Maret</option>
                        <option <?=date('m') == 4 ? '' : '';?> value="4">April</option>
                        <option <?=date('m') == 5 ? '' : '';?> value="5">Mei</option>
                        <option <?=date('m') == 6 ? '' : '';?> value="6">Juni</option>
                        <option <?=date('m') == 7 ? '' : '';?> value="7">Juli</option>
                        <option <?=date('m') == 8 ? '' : '';?> value="8">Agustus</option>
                        <option <?=date('m') == 9 ? '' : '';?> value="9">September</option>
                        <option <?=date('m') == 10 ? '' : '';?> value="10">Oktober</option>
                        <option <?=date('m') == 11 ? '' : '';?> value="11">November</option>
                        <option <?=date('m') == 12 ? '' : '';?> value="12">Desember</option>
                        </select>
                </div>
                <div class="col-lg-3">
                    <label>Eselon</label>
                    <select class="form-control select2-navy" 
                        id="eselon" data-dropdown-css-class="select2-navy" name="eselon" required>
                        <option value="0" selected>Semua</option>
                        <?php foreach($eselon as $e){ ?>
                            <option value="<?=$e['nm_eselon']?>"><?=$e['nm_eselon']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>Pangkat</label>
                    <select class="form-control select2-navy" 
                        id="pangkat" data-dropdown-css-class="select2-navy" name="pangkat" required>
                        <option value="0" selected>Semua</option>
                        <?php foreach($pangkat as $p){ ?>
                            <option value="<?=$p['id_pangkat']?>"><?=$p['nm_pangkat']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-12 float-right text-right mt-2">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default" id="div_result">
</div>
<script>
    $(function(){
        $('.select2-navy').select2()

        $('.tahunpicker').datepicker({
            autoClose: true,
            format: 'yyyy',
            viewMode: "years", 
            minViewMode: "years",
        })

        $('#form_search').submit()
    })

    $('#tahun').on('change', function(){
        $('#form_search').submit()
    })

    $('#form_search').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("user/C_User/getListPegawaiGajiBerkalaByYear/")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(divLoaderNavy)
                $('#div_result').html('')
                $('#div_result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    })
</script>