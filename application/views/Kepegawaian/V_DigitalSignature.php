<div class="row">
    <div class="col-lg-12 card card-default">
        <div class="card-header">
            <h5 class="card-title">DIGITAL SIGNATURE</h5>
            <hr>
        </div>
        <div class="card-body" style="margin-top: -30px;">
            <form id="form_load_ds">
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Jenis Layanan</label>
                        <select class="form-control select2-navy" style="width: 100%;"
                            id="jenis_layanan" data-dropdown-css-class="select2-navy" name="jenis_layanan">
                                <option value="permohonan_cuti">Permohonan Cuti</option>
                        </select>
                    </div>
                    <!-- <div class="col-lg-12 form-group">
                        <label>Tanggal Usul</label>
                    </div> -->
                    <div class="col-lg-12 text-right mt-3">
                        <button class="btn btn-navy btn-block">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12 mt-3" id="result">

    </div>
</div>
<script>
    let list_checked = []
    let terpilih

    $(function(){
        $('#form_load_ds').submit()
    })

    $('#form_load_ds').on('submit', function(e){
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/loadDataForDs")?>',
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