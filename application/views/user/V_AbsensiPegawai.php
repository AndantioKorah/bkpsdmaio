<div class="card p-3">
    <form id="form_detail_absen">
        <div class="row">
            <div class="col-lg-4">
                <label>Bulan</label>
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
            <div class="col-lg-4">
                <label>Tahun</label>
                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
            </div>
            <div class="col-lg-4">
                <label style="color: white;">.</label><br>
                <button class="btn btn-navy" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

<div class="mt-3" id="result_search">

</div>

<script>
    $(function(){
        $('#bulan').select2()
        $('#form_detail_absen').submit()
    })

    $('#tahun').on('change', function(){
        $('#form_detail_absen').submit()
    })

    $('#bulan').on('change', function(){
        $('#form_detail_absen').submit()
    })

    $('#form_detail_absen').on('submit', function(e){
        e.preventDefault()
        $('#result_search').html('')
        $('#result_search').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("user/C_User/searchDetailAbsenPegawai")?>',
            method: 'post',
            // data: $(this).serialize(),
            data: $(this).serialize(),
            success: function(data){
                $('#result_search').html('')
                $('#result_search').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>