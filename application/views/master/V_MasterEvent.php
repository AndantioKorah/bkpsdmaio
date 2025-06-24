<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="card-title">MASTER EVENT</h4>
                </div>
                <div class="card-body">
                    <form class="form" id="form_input">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-8">
                                <label>Judul</label>
                                <input required class="form-control" name="judul" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-2">
                                <label>Tanggal</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="tgl" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-2">
                                <label>Radius (m)</label>
                                <input required class="form-control" name="radius" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Buka Masuk</label>
                                <input type="time" required class="form-control" name="buka_masuk" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Batas Masuk</label>
                                <input type="time" required class="form-control" name="batas_masuk" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Buka Pulang</label>
                                <input type="time" required class="form-control" name="buka_pulang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Batas Pulang</label>
                                <input type="time" required class="form-control" name="batas_pulang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Lat</label>
                                <input required class="form-control" name="titik_lat" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Lang</label>
                                <input required class="form-control" name="titik_lang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-12 mt-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="ket" rows=3></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                                <label>Tanggal Batas Input</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="max_input_date">
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                                <label>Tanggal Batas Edit</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="max_change_date">
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                                <label>Surat Tugas</label>
                                <select class="form-control select2-navy" style="width: 100%;"
                                    id="flag_surat_tugas" data-dropdown-css-class="select2-navy" name="flag_surat_tugas">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-3 text-right">
                                <hr>
                                <button class="btn btn-navy" type="submit" id="btn_save"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="float-left">
                        <h4 class="card-title">LIST EVENT</h4>
                    </div>
                    <div class="float-right">
                        <button id="btn_refresh" class="btn btn-navy btn-sm"><i class="fa fa-sync"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body" id="div_list_event">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.datepickerthis').datepicker({
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: true,
            todayBtn: true,
            autoclose: true
        });

        $(".timepicker").datetimepicker({
            pickDate: false,
            minuteStep: 1,
            // pickerPosition: 'bottom-right',
            format: 'HH:ii',
            autoclose: true,
            // showMeridian: true,
            startView: 1,
            maxView: 1,
        });

        $('.timepicker').val('<?=date("H:i")?>')

        loadListEvent()
    })

    $('#btn_refresh').on('click', function(){
        loadListEvent()
    })

    function loadListEvent(){
        btnLoader('btn_refresh')
        $('#div_list_event').html('')
        $('#div_list_event').append(divLoaderNavy)
        $('#div_list_event').load('<?=base_url("master/C_Master/loadListEvent")?>', function(){
            $('#loader').hide()
            btnLoader('btn_refresh')
        })
    }

    $('#form_input').on('submit', function(e){
        e.preventDefault()
        btnLoader('btn_save', 'Menyimpan...')
        $.ajax({
            url: '<?=base_url("master/C_Master/inputDataEvent")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp.code == 1){
                    errortoast(resp.message)
                } else {
                    successtoast('Data Event Berhasil Ditambahkan')
                    loadListEvent()
                }
                btnLoader('btn_save')
            }, error: function(e){
                btnLoader('btn_save')
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>