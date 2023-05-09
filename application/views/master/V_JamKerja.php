<style>
    .label_hr{
        font-size: .9rem;
        font-weight: bold;
        font-style: italic;
    }

    label_jam{
        font-size: .75rem;
        font-weight: 550;
    }
</style>
<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER JAM KERJA</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_tambah_jam_kerja">
            <div class="row">
                <div class="col-lg-4">
                    <label>Jenis SKPD</label>
                    <select class="form-control select2-navy select2_this" style="width: 100%"
                        data-dropdown-css-class="select2-navy" name="id_m_jenis_skpd">
                        <?php foreach($jenis_skpd as $j){ ?>
                            <option value="<?=$j['id']?>">
                                <?=$j['jenis_skpd']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>Nama Jam Kerja</label>
                    <input autocomplete="off" class="form-control" name="nama_jam_kerja" />
                </div>
                <div class="col-lg-4">
                    <label>Jenis Jam Kerja</label>
                    <select class="form-control select2-navy select2_this" style="width: 100%"
                        data-dropdown-css-class="select2-navy" name="flag_event">
                            <option value="0">Jam Kerja Sekarang</option>
                            <option value="1">Jam Kerja Sementara</option>
                            <option value="2">Jam Kerja Lama</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12"><hr></div>
            <div class="col-lg-12">
                <label class="label_hr">Senin - Kamis</label>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Masuk</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfo_masuk" />
                    </div>
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Pulang</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfo_pulang" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                </div>
            </div>
            <div class="col-lg-12">
                <label class="label_hr">Jumat</label>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Masuk</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfoj_masuk" />
                    </div>
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Pulang</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfoj_pulang" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label>Berlaku Dari</label>
                    <input autocomplete="off" class="form-control datepickerthis" name="berlaku_dari" />
                </div>
                <div class="col-lg-6">
                    <label>Berlaku Sampai</label>
                    <input autocomplete="off" class="form-control datepickerthis" name="berlaku_sampai" />
                </div>
            </div>
            <div class="col-lg-12 text-right">
                <button id="btn_save_tambah" type="submit" class="btn btn-navy">Simpan <i class="fa fa-save"></i></button>
                <button id="btn_loading_tambah" type="btn" style="display:none;" disabled class="btn btn-navy">Loading... <i class="fa fa-spin fa-spinner"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST JAM KERJA</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive" id="list_jam_kerja">
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $('.datepickerthis').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true
            // startDate: firstDay,
            // endDate: new Date()
        })

        $('.timepickerthis').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,
            // minTime: '10',
            // maxTime: '6:00pm',
            dynamic: true,
            dropdown: true,
            scrollbar: true,
            use24hours: true,
            pickTime: true,
        })

        $("#range_periode").daterangepicker({
            showDropdowns: true
        });
        loadJamKerja()
    })

    $('#form_tambah_jam_kerja').on('submit', function(e){
        e.preventDefault()
        $('#btn_save_tambah').hide()
        $('#btn_loading_tambah').show()
        $.ajax({
            url: '<?=base_url("master/C_Master/tambahJamKerja")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(res){
                let rs = JSON.parse(res)
                if(rs.code == 0){
                    successtoast('Berhasil')
                    loadJamKerja()
                } else {
                    errortoast(res.message)
                }
                $('#btn_save_tambah').show()
                $('#btn_loading_tambah').hide()
            }, error: function(e){
                $('#btn_save_tambah').show()
                $('#btn_loading_tambah').hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function loadJamKerja(){
        $('#list_jam_kerja').html('')
        $('#list_jam_kerja').append(divLoaderNavy)
        $('#list_jam_kerja').load('<?=base_url("master/C_Master/loadJamKerja")?>', function(){
            $('#loader').hide()
        })
    }

    $('#btn_sync').on('click', function(){
        $('#btn_sync').hide()
        $('#btn_loading_sync').show()
        $.ajax({
            url: '<?=base_url("master/C_Master/downloadApiHariLibur")?>',
            method: 'post',
            data: {},
            success: function(){
                successtoast('Sinkronasi berhasil')
                $('#btn_sync').show()
                $('#btn_loading_sync').hide()
                loadHariLibur()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_sync').show()
                $('#btn_loading_sync').hide()
            }
        })
    })

    $('#form_tambah_hari_libur').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/tambahHariLibur")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                successtoast('Data berhasil ditambahkan')
                loadHariLibur()
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>