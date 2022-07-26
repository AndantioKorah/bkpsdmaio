<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER BESARAN TPP</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_input_master_tpp">
            <div class="row">
                <div class="col-lg-3 col-md-2">
                    <label class="bmd-label-floating">Pilih SKPD</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <option value="0">Umum</option>
                        <?php foreach($unitkerja as $s){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="bmd-label-floating">Pilih Golongan</label>
                    <select multiple="multiple" class="form-control select2-navy" style="width: 100%"
                        id="id_pangkat" data-dropdown-css-class="select2-navy" name="id_pangkat[]">
                        <?php foreach($pangkat as $p){ ?>
                            <option value="<?=$p['id_pangkat']?>"><?=$p['nm_pangkat']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-2">
                    <label class="bmd-label-floating">Pilih Jabatan</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_jabatan" data-dropdown-css-class="select2-navy" name="id_jabatan">
                    </select>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label autocomplete="off" class="bmd-label-floating">Nominal</label>
                    <input class="form-control format_currency_this" name="nominal" id="nominal" />
                </div>
                
                <div class="col-lg-2 col-md-2 text-left">
                    <label class="bmd-label-floating" style="color: white;">..</label>
                    <button id="btn_save" class="btn btn-block btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                    <button id="btn_loading" style="display: none;" disabled class="btn btn-block btn-navy" type="button"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">MASTER BESARAN TPP</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_tpp">
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $("#id_unitkerja").select2();
        $("#id_pangkat").select2();
        $("#id_jabatan").select2();
        loadTpp()
        refreshJabatan();
    })

    function loadTpp(){
        $('#list_tpp').html('')
        $('#list_tpp').append(divLoaderNavy)
        $('#list_tpp').load('<?=base_url("master/C_Master/loadTpp")?>', function(){
            $('#loader').hide()
        })
    }

    $('#id_unitkerja').on('change', function(){
        refreshJabatan()
    })

    function refreshJabatan(){
        $('#id_jabatan')
            .find('option')
            .remove()
            .end()
        $.ajax({
            url: '<?=base_url("master/C_Master/getJabatanByUnitKerja")?>'+'/'+$('#id_unitkerja').val(),
            method: 'post',
            data: {},
            success: function(result){
                let rs = JSON.parse(result)
                $('#id_jabatan').append('<option selected value="0">Pilih Jabatan</option>')
                rs.forEach(function(item) {
                    $('#id_jabatan').append('<option value="'+item.id_jabatanpeg+'">('+item.eselon+') '+item.nama_jabatan+'</option>')
                });
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#form_input_master_tpp').on('submit', function(e){
        $('#btn_save').hide()
        $('#btn_loading').show()
        e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/inputMasterTpp")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    $('#btn_save').show()
                    $('#btn_loading').hide()
                    successtoast('Data Berhasil Disimpan')
                    loadTpp()
                }, error: function(e){
                    $('#btn_save').show()
                    $('#btn_loading').hide()
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

</script>