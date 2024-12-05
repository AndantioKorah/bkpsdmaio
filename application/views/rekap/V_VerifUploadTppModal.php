<?php if($result){ ?>
    <style>
        .lbl_nm_verif{
            font-size: .6rem;
            color: grey;
            font-style: italic;
            font-weight: bold;
        }

        .lbl_val_verif{
            font-size: 1rem;
            color: black;
            font-weight: bold;
        }
    </style>
    <div class="row p-3">
        <div class="col-lg-6">
            <!-- <iframe id="iframe_verif_upload_tpp_modal" style="width: 100%; height: 75vh;" src="<?=base_url($result['url_upload_file'])?>"></iframe> -->
            <iframe id="iframe_verif_upload_tpp_modal" style="width: 100%; height: 75vh;"></iframe>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <label class="lbl_nm_verif">Perangkat Daerah</label><br>
                    <span class="lbl_val_verif"><?=$result['nm_unitkerja']?></span>
                </div>
                <div class="col-lg-12 mt-1">
                    <label class="lbl_nm_verif">Periode</label><br>
                    <span class="lbl_val_verif"><?=getNamaBulan($result['bulan']).' '.$result['tahun']?></span>
                </div>
                <div class="col-lg-12 mt-1">
                    <label class="lbl_nm_verif">Uploader</label><br>
                    <span class="lbl_val_verif"><?=$result['nama_uploader']?></span>
                </div>
                <div class="col-lg-12 mt-1">
                    <label class="lbl_nm_verif">Tanggal Upload</label><br>
                    <span class="lbl_val_verif"><?=formatDateNamaBulanWT($result['created_date'])?></span>
                </div>
                <div class="col-lg-12 mt-1">
                    <label class="lbl_nm_verif">Keterangan</label><br>
                    <textarea rows=5 style="width: 100%;" id="keterangan" name="keterangan"></textarea>
                </div>
                <div class="col-lg-12 mt-1">
                    <label class="lbl_nm_verif">Status Verifikasi</label><br>
                    <select class="form-control select2-navy" style="width: 100%;"
                        id="flag_verif" data-dropdown-css-class="select2-navy" name="flag_verif">
                            <option <?=$result['flag_verif'] == '0' ? 'selected' : ''?> value="0">Batal Verif</option>
                            <option <?=$result['flag_verif'] == '1' ? 'selected' : ''?> value="1">Terima</option>
                            <option <?=$result['flag_verif'] == '2' ? 'selected' : ''?> value="2">Tolak</option>
                    </select>
                </div>
                <div class="col-lg-12 mt-3 text-right">
                    <button id="btn_save_verif" class="btn btn-save btn-navy"><i class="fa fa-save"></i> Simpan</button>
                    <button id="btn_save_verif_loading" disabled style="display: none;" class="btn btn-save btn-navy"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#flag_verif').select2()
            $('#iframe_verif_upload_tpp_modal')[0].contentWindow.location.reload(true)
            $('#iframe_verif_upload_tpp_modal').attr('src', "<?=base_url($result['url_upload_file'])?>")
        })

        $('#btn_save_verif').on('click', function(){
            $('#btn_save_verif').hide()
            $('#btn_save_verif_loading').show()
            $.ajax({
                url: '<?=base_url('rekap/C_Rekap/saveVerifUploadBerkasTpp')?>',
                method: 'POST',
                data: {
                    flag_verif: $('#flag_verif').val(),
                    keterangan: $('#keterangan').val(),
                    id: '<?=$result['id']?>'
                },
                success: function(rs){
                    let res = JSON.parse(rs)
                    if(res.code == 1){
                        errortoast(res.message)
                    } else {
                        $('#btn_modal_close').click()
                        // console.log($('#flag_verif').val()+'     '+'<?=$result['flag_verif']?>')
                        // console.log($('#flag_verif').val() != '<?=$result['flag_verif']?>')
                        // if($('#flag_verif').val() != '<?=$result['flag_verif']?>'){
                            $('.tr_<?=$result['id']?>').hide()
                        // }
                        successtoast('Verifikasi Berhasil')
                    }
                    $('#btn_save_verif').show()
                    $('#btn_save_verif_loading').hide()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        })
    </script>
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>