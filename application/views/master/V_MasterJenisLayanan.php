<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER PRESENTASE BESARAN TPP</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_jenis_layanan">
            <div class="row">
                <div class="col-lg-10">
                    <label>Nama Jenis Layanan</label>
                    <input id="jenis_layanan" name="nama" class="form-control" />
                </div>
                <div class="col-lg-2">
                    <label>Aktif</label>
                    <div class="form-check form-switch">
                        <input style="width: 100%; height: 28px;" name="aktif" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-right">
                    <button class="btn btn-block btn-navy" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">MASTER JENIS LAYANAN</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_jenis_layanan">
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        loadJenisLayanan()
    })

    function loadJenisLayanan(){
        $('#list_jenis_layanan').html('')
        $('#list_jenis_layanan').append(divLoaderNavy)
        $('#list_jenis_layanan').load('<?=base_url("master/C_Master/loadJenisLayanan")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_jenis_layanan').on('submit', function(e){
        e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/inputMasterJenisLayanan")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    successtoast('Jenis Layanan berhasil disimpan')
                    $('#jenis_layanan').val("")
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

</script>