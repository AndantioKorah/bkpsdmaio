<div class="row">
    <div class="col-lg-12 card card-default">
        <div class="card-header">
            <h5 class="card-title">DIGITAL SIGNATURE</h5>
            <hr>
        </div>
        <div class="card-body" style="margin-top: -30px;">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-form-cari-tab" data-toggle="tab" href="#nav-form-cari" role="tab" aria-controls="nav-form-cari" aria-selected="true">Cari Data</a>
                <a class="nav-item nav-link" id="nav-batch-tab" data-toggle="tab" href="#nav-batch" role="tab" aria-controls="nav-batch" aria-selected="false">Batch</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-form-cari" role="tabpanel" aria-labelledby="nav-form-cari-tab">
                <form id="form_load_ds">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Jenis Layanan</label>
                            <select class="form-control select2-navy" style="width: 100%;"
                                id="jenis_layanan" data-dropdown-css-class="select2-navy" name="jenis_layanan">
                                    <option value="0" selected>Semua</option>
                                    <?php if($list){ foreach($list as $l){ ?>
                                        <option value="<?=$l['id']?>"><?=$l['nama_jenis_ds']?></option>
                                    <?php } } ?>
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
            <div class="tab-pane fade" id="nav-batch" role="tabpanel" aria-labelledby="nav-batch-tab"></div>
        </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3" id="result">

    </div>
</div>
<script>
    let list_checked = []
    let terpilih
    let jenis_layanan = $('#jenis_layanan').val()

    $(function(){
        $('#jenis_layanan').select2()
        $('#form_load_ds').submit()
    })

    $('#nav-batch-tab').on('click', function(){
        $('#nav-batch').html('')
        $('#nav-batch').append(divLoaderNavy)
        $('#nav-batch').load('<?=base_url('kepegawaian/C_Kepegawaian/loadBatchDs')?>', function(){
            $('#loader').hide()
        })
    })

    $('#jenis_layanan').on('change', function(){
        jenis_layanan = $('#jenis_layanan').val()
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