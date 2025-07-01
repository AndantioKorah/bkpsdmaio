<?php if($result){ ?>
    <div class="col-lg-12 p-3">
        <form class="form" id="form_edit_event">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-8">
                    <label>Judul</label>
                    <input required class="form-control" name="judul" value="<?=$result['judul']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-2">
                    <label>Tanggal</label>
                    <input class="form-control datepickerthisedit" value="<?=date('Y-m-d')?>" name="tgl" value="<?=$result['tgl']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-2">
                    <label>Radius (m)</label>
                    <input required class="form-control" name="radius" value="<?=$result['radius']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Buka Masuk</label>
                    <input type="time" required class="form-control" name="buka_masuk" value="<?=$result['buka_masuk']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Batas Masuk</label>
                    <input type="time" required class="form-control" name="batas_masuk" value="<?=$result['batas_masuk']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Buka Pulang</label>
                    <input type="time" required class="form-control" name="buka_pulang" value="<?=$result['buka_pulang']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Batas Pulang</label>
                    <input type="time" required class="form-control" name="batas_pulang" value="<?=$result['batas_pulang']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Lat</label>
                    <input required class="form-control" name="titik_lat" value="<?=$result['titik_lat']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-6 mt-3">
                    <label>Lang</label>
                    <input required class="form-control" name="titik_lang" value="<?=$result['titik_lang']?>" />
                </div>
                <div class="col-md-12 col-sm-12 col-lg-12 mt-3">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="ket" rows=3><?=$result['ket']?></textarea>
                </div>
                <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                    <label>Tanggal Batas Input</label>
                    <input class="form-control datepickerthisedit" name="max_input_date" value="<?=$result['max_input_date']?>">
                </div>
                <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                    <label>Tanggal Batas Edit</label>
                    <input class="form-control datepickerthisedit" name="max_change_date" value="<?=$result['max_change_date']?>">
                </div>
                <div class="col-md-12 col-sm-12 col-lg-4 mt-3">
                    <label>Surat Tugas</label>
                    <select class="form-control select2-navy" style="width: 100%;"
                        id="flag_surat_tugas" data-dropdown-css-class="select2-navy" name="flag_surat_tugas">
                        <option <?=$result['flag_surat_tugas'] == 0 ? "selected" : ""?> value="0">Tidak</option>
                        <option <?=$result['flag_surat_tugas'] == 1 ? "selected" : ""?> value="1">Ya</option>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 mt-3 text-right">
                    <hr>
                    <button class="btn btn-navy" type="submit" id="btn_save_edit"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            $('.datepickerthisedit').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
                todayHighlight: true,
                todayBtn: true,
                autoclose: true
            });
        })

        $('#form_edit_event').on('submit', function(e){
            e.preventDefault()
            btnLoader('btn_save_edit')
            $.ajax({
                url: '<?=base_url("master/C_Master/saveEditDataEvent/".$result['id'])?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    let resp = JSON.parse(data)
                    if(resp.code == 1){
                        errortoast(resp.message)
                    } else {
                        successtoast('Data Event Berhasil Diubah')
                    }
                    btnLoader('btn_save_edit')
                }, error: function(e){
                    btnLoader('btn_save_edit')
                    errortoast('Terjadi Kesalahan')
                }
            })
        })
    </script>
<?php } ?>