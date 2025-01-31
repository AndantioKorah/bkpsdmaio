<?php if($result){ ?>
    <form id="form_edit">
        <div class="row p-3">
            <!-- <div class="col-lg-12">
                <h2>EDIT DATA PLT PLH</h2>
                <hr>
            </div> -->
            <div class="col-lg-12">
                <label>Nama Pegawai</label><br>
                <h3><?=getNamaPegawaiFull($result)?></h3>
            </div>
            <div class="col-lg-12 mt-2">
                <label>Jenis Jabatan</label><br>
                <select class="form-control select2-navy select2" name="pltplh_jenis_edit" id="pltplh_jenis_edit" >
                    <option <?=$result['jenis'] == "Plt" ? 'selected' : ""?> value="Plt" >Plt </option>
                    <option <?=$result['jenis'] == "Plh" ? 'selected' : ""?> value="Plh" >Plh </option>
                </select>
            </div>
            <div class="col-lg-12 mt-2">
                <label>Nama Jabatan</label><br>
                <select class="form-control select2-navy select2" data-dropdown-css-class="select2-navy" name="pltplh_jabatan_edit" id="pltplh_jabatan_edit">
                    <?php if($nama_jabatan){ foreach($nama_jabatan as $r){ ?>
                        <option <?=$result['id_jabatan_plt_plh'] == $r['id_jabatanpeg'] ? "selected" : ""?>
                            value="<?=$r['id_jabatanpeg']?>,<?=$r['id_unitkerja']?>"><?=$r['nama_jabatan']?> | <?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
                </select>
            </div>
            <div class="col-lg-12 mt-2">
                <label>Tanggal Mulai</label>
                <input value="<?=$result['tanggal_mulai']?>" autocomplete="off" type="text"
                    class="form-control datepicker2" id="pltplh_tgl_mulai_edit" name="pltplh_tgl_mulai_edit">
            </div>
            <div class="col-lg-12 mt-2">
                <label>Tanggal Akhir</label>
                <input value="<?=$result['tanggal_akhir']?>" autocomplete="off" type="text"
                    class="form-control datepicker2" id="pltplh_tgl_akhir_edit" name="pltplh_tgl_akhir_edit">
            </div>
            <div class="col-lg-12 mt-2">
                <label>Presentasi TPP</label>
                <input value="<?=$result['presentasi_tpp']?>" type="number" class="form-control" id="pltplh_presentasi_tpp_edit" name="pltplh_presentasi_tpp_edit">
            </div>
            <div class="col-lg-12 mt-2">
                <label>Flag BPJS</label>
                <select class="form-control select2-navy select2" name="pltplh_bpjs_edit" id="pltplh_bpjs_edit">
                    <option <?=$result['flag_use_bpjs'] == 1 ? "selected" : ""?> value="1" > Ya </option>
                    <option <?=$result['flag_use_bpjs'] == 0 ? "selected" : ""?> value="0" > Tidak </option>
                </select>
            </div>
            <div class="col-lg-12 mt-2 text-right">
                <button type="submit" id="btn_submit" class="btn btn-block btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
                <button type="button" disabled style="display: none;" id="btn_submit_loading" class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
            </div>
        </div>
    </form>

    <script>
        $(function(){
            $(".select2").select2({   
                width: '100%',
                dropdownAutoWidth: true,
                allowClear: true,
            });
            $('.datepicker2').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
            });
        })

        $('#form_edit').on('submit', function(e){
            e.preventDefault()
            $('#btn_submit').hide()
            $('#btn_submit_loading').show()

            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitEditPltPlh/".$result['id_pltplh'])?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(data){
                    successtoast('Data berhasil disimpan')
                    $('#btn_modal_close').click()
                    // $('#modal_edit').modal('hide')
                    window.setTimeout(function(){
                        loadListPltPlh()
                    }, 1000);

                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    $('#btn_submit').show()
                    $('#btn_submit_loading').hide()
                }
            })
        })
    </script>
<?php } else { ?>
    <div class="col-lg-12 text-center p-3">
        <h4><i class="fa fa-exclamation"></i> DATA TIDAK DITEMUKAN</h4>
    </div>
<?php } ?>