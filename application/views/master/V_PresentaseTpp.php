<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER PRESENTASE BESARAN TPP</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_input_presentase_tpp">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <label class="bmd-label-floating">Pilih SKPD</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <?php foreach($unitkerja as $s){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3">
                    <label class="bmd-label-floating">Pilih Kelas Jabatan</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="kelas_jabatan" data-dropdown-css-class="select2-navy" name="kelas_jabatan">
                        <option value="0">Semua</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3">
                    <label class="bmd-label-floating">Pilih Jenis Jabatan</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="jenis_jabatan" data-dropdown-css-class="select2-navy" name="jenis_jabatan">
                        <option value="semua">Semua</option>
                        <option value="jft">JFT</option>
                        <option value="jfu">JFU</option>
                        <option value="eselon_4">Eselon 4</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3">
                    <label autocomplete="off" class="bmd-label-floating">Presentase</label>
                    <input class="form-control format_currency_this" name="presentase" id="presentase" />
                </div>
                
                <div class="col-lg-3 col-md-3 text-left">
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
        <h3 class="card-title">MASTER BESARAN PRESENTASE TPP</h3>
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
        $("#kelas_jabatan").select2();
        $("#jenis_jabatan").select2();
        
        loadTpp()
    })

    function loadTpp(){
        $('#list_tpp').html('')
        $('#list_tpp').append(divLoaderNavy)
        $('#list_tpp').load('<?=base_url("master/C_Master/loadPresentaseTpp")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_input_presentase_tpp').on('submit', function(e){
        $('#btn_save').hide()
        $('#btn_loading').show()
        e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/inputMasterPresentaseTpp")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    let res = JSON.parse(rs)
                    if(res.code == 0){
                        successtoast('Data Berhasil Disimpan')
                        loadTpp()
                    } else {
                        errortoast(res.message)
                    }
                    $('#btn_save').show()
                    $('#btn_loading').hide()
                }, error: function(e){
                    $('#btn_save').show()
                    $('#btn_loading').hide()
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

</script>