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
                                <input class="form-control" name="judul" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-2">
                                <label>Tanggal</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="tgl" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-2">
                                <label>Radius (m)</label>
                                <input class="form-control" name="radius" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Buka Masuk</label>
                                <input class="form-control timepicker" name="buka_masuk" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Batas Masuk</label>
                                <input class="form-control timepicker" name="batas_masuk" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Buka Pulang</label>
                                <input class="form-control timepicker" name="buka_pulang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Batas Pulang</label>
                                <input class="form-control timepicker" name="batas_pulang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Lat</label>
                                <input class="form-control" name="titik_lat" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Lang</label>
                                <input class="form-control" name="titik_lang" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-12 mt-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows=3></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Tanggal Batas Input</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="max_input_date">
                            </div>
                            <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                                <label>Tanggal Batas Edit</label>
                                <input class="form-control datepickerthis" value="<?=date('Y-m-d')?>" name="max_change_date">
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
            minuteStep: 15,
            // pickerPosition: 'bottom-right',
            format: 'HH:ii',
            autoclose: true,
            showMeridian: true,
            startView: 1,
            maxView: 1,
        });

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
</script>