<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">DATA PEGAWAI NAIK PANGKAT</h5>
        <hr>
    </div>
    <div class="card-body" style="margin-top: -30px;">
        <form id="form_search">
            <div class="row">
                <div class="col-lg-4">
                    <label>Pilih Tahun</label>
                    <input autocomplete="off" value="<?=date('Y')?>" class="form-control tahunpicker" name="tahun" id="tahun" />
                </div>
                <div class="col-lg-4">
                    <label>Eselon</label>
                    <select class="form-control select2-navy" 
                        id="eselon" data-dropdown-css-class="select2-navy" name="eselon" required>
                        <option value="0" selected>Semua</option>
                        <?php foreach($eselon as $e){ ?>
                            <option value="<?=$e['nm_eselon']?>"><?=$e['nm_eselon']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4">
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
            url: '<?=base_url("user/C_User/getListPegawaiNaikPangkatByYear/")?>',
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