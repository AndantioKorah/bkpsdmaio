<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">PENDING TPP</div>
            </div>
            <div class="card-body">
                <form id="form_pending_tpp">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Pegawai</label>
                            <select required multiple="multiple" class="form-control select2-navy" style="width: 100%"
                                id="pegawai" data-dropdown-css-class="select2-navy" name="pegawai[]">
                                <?php foreach($list_pegawai as $p){ ?>
                                    <option value="<?=$p['nipbaru_ws']?>"><?=getNamaPegawaiFull($p)?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label class="bmd-label-floating">Bulan</label>
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
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label class="bmd-label-floating">Tahun</label>
                            <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                        </div>
                        <div class="mt-3 col-lg-12 col-md-12 col-sm-12 text-right">
                            <button id="btn_save" class="btn btn-navy"><i class="fa fa-save"></i> Simpan</button>
                            <button id="btn_save_loading" style="display: none;" class="btn btn-navy" disabled><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">LIST PENDING TPP</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive" id="div_list_pending_tpp">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#pegawai').select2()
        $('#bulan').select2()
        loadDataListPending()
    })

    function loadDataListPending(){
        $('#div_list_pending_tpp').html('')
        $('#div_list_pending_tpp').append(divLoaderNavy)
        $('#div_list_pending_tpp').load('<?=base_url("master/C_Master/getListPendingTpp")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_pending_tpp').on('submit', function(e){
        e.preventDefault()
        $('#btn_save').hide()
        $('#btn_save_loading').show()
        $.ajax({
            url: '<?=base_url("master/C_Master/savePendingTpp")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp.code == 0){
                    loadDataListPending()
                    successtoast('Data Berhasil Disimpan')
                } else {
                    errortoast(resp.message)
                }
                $('#btn_save').show()
                $('#btn_save_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_save').show()
                $('#btn_save_loading').hide()
            }
        })
    })
</script>