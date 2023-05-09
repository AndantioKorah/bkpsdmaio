<?php if($result){ ?>
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

        .ui-timepicker-container{ 
            z-index:1151 !important; 
        }
    </style>
    <div class="row p-3">
        <div class="col-lg-12">
            <h4>EDIT JAM KERJA</h4>
            <hr>
        </div>
        <form id="form_edit_jam">
            <div class="row">
                <div class="col-lg-4">
                    <label>Jenis SKPD</label>
                    <select class="form-control select2-navy select2_this" style="width: 100%"
                        data-dropdown-css-class="select2-navy" name="id_m_jenis_skpd">
                        <?php foreach($jenis_skpd as $j){ ?>
                            <option <?=$j['id'] == $result['id_m_jenis_skpd'] ? 'selected' : ''?> value="<?=$j['id']?>">
                                <?=$j['jenis_skpd']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>Nama Jam Kerja</label>
                    <input autocomplete="off" class="form-control" name="nama_jam_kerja" value="<?=$result['nama_jam_kerja']?>" />
                </div>
                <div class="col-lg-4">
                    <label>Jenis Jam Kerja</label>
                    <select class="form-control select2-navy select2_this" style="width: 100%"
                        data-dropdown-css-class="select2-navy" name="flag_event">
                            <option <?=$result['flag_event'] == 0 ? 'selected' : ''?> value="0">Jam Kerja Sekarang</option>
                            <option <?=$result['flag_event'] == 1 ? 'selected' : ''?> value="1">Jam Kerja Sementara</option>
                            <option <?=$result['flag_event'] == 2 ? 'selected' : ''?> value="2">Jam Kerja Lama</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12"><hr></div>
            <div class="col-lg-12">
                <label class="label_hr">Senin - Kamis</label>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Masuk</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfo_masuk" value="<?=$result['wfo_masuk']?>" />
                    </div>
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Pulang</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfo_pulang" value="<?=$result['wfo_pulang']?>" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                </div>
            </div>
            <div class="col-lg-12">
                <label class="label_hr">Jumat</label>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Masuk</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfoj_masuk" value="<?=$result['wfoj_masuk']?>" />
                    </div>
                    <div class="col-lg-6">
                        <label class="label_jam">Jam Pulang</label>
                        <input autocomplete="off" class="form-control timepickerthis" name="wfoj_pulang" value="<?=$result['wfoj_pulang']?>" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label>Berlaku Dari</label>
                    <input autocomplete="off" class="form-control datepickerthis" name="berlaku_dari" value="<?=$result['berlaku_dari']?>" />
                </div>
                <div class="col-lg-6">
                    <label>Berlaku Sampai</label>
                    <input autocomplete="off" class="form-control datepickerthis" name="berlaku_sampai" value="<?=$result['berlaku_sampai']?>" />
                </div>
            </div>
            <div class="col-lg-12 text-right">
                <button id="btn_save" type="submit" class="btn btn-navy">Simpan <i class="fa fa-save"></i></button>
                <button id="btn_loading" type="btn" style="display:none;" disabled class="btn btn-navy">Loading... <i class="fa fa-spin fa-spinner"></i></button>
            </div>
        </form>
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
                timeFormat: 'hh:mm:ss',
                interval: 15,
                // minTime: '10',
                // maxTime: '6:00pm',
                dynamic: true,
                dropdown: true,
                scrollbar: true
            })

            $('.select2_this').select2()
        })

        function deleteJamKerja(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteJamKerja")?>'+'/'+id,
                    method: 'post',
                    data: {},
                    success: function(){
                        successtoast('Berhasil')
                        loadJamKerja()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }

        $('#form_edit_jam').on('submit', function(e){
            e.preventDefault()
            $('#btn_save').hide()
            $('#btn_loading').show()
            $.ajax({
                url: '<?=base_url("master/C_Master/saveEditJamKerja/").$result['id']?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(res){
                    let rs = JSON.parse(res)
                    if(rs.code == 0){
                        $('#edit_modal').modal('hide')
                        successtoast('Berhasil')
                        // loadJamKerja()
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
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>