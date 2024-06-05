<form id="form_komponen_kinerja">
    <table border=1 style="width: 100%;" class="table table-bordered table-hover table-striped">
        <tr>
            <td style="padding: 5px; font-weight: bold; width: 5%; text-align: center;">NO</td>
            <td style="padding: 5px; font-weight: bold; width: 70%; text-align: center;">KOMPONEN KINERJA</td>
            <td style="padding: 5px; font-weight: bold; width: 25%; text-align: center;">NILAI</td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">1</td>
            <td style="padding: 5px;">Berorientasi Pelayanan</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="berorientasi_pelayanan" value="<?=$komponen_kinerja ? $komponen_kinerja['berorientasi_pelayanan'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">2</td>
            <td style="padding: 5px;">Akuntabel</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="akuntabel" value="<?=$komponen_kinerja ? $komponen_kinerja['akuntabel'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">3</td>
            <td style="padding: 5px;">Kompeten</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="kompeten" value="<?=$komponen_kinerja ? $komponen_kinerja['kompeten'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">4</td>
            <td style="padding: 5px;">Harmonis</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="harmonis" value="<?=$komponen_kinerja ? $komponen_kinerja['harmonis'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">5</td>
            <td style="padding: 5px;">Loyal</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="loyal" value="<?=$komponen_kinerja ? $komponen_kinerja['loyal'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">6</td>
            <td style="padding: 5px;">Adaptif</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="adaptif" value="<?=$komponen_kinerja ? $komponen_kinerja['adaptif'] : '97'?>" />
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 5px;">7</td>
            <td style="padding: 5px;">Kolaboratif</td>
            <td class="text-center" style="padding: 5px;">
                <input class="form-control form-control-sm" name="kolaboratif" value="<?=$komponen_kinerja ? $komponen_kinerja['kolaboratif'] : '97'?>" />
            </td>
        </tr>
    </table>
    <div class="col-lg-12 text-right class_button_verif" style="display: none;">
        <?php if($komponen_kinerja) { ?>
            <button onclick="hapusKomponenKinerja('<?=$komponen_kinerja['id']?>')" id="btn_delete_komponen_kinerja" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
            <button style="display:none;" disabled id="btn_delete_loading_komponen_kinerja" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading</button>
        <?php } ?>
        <button type="submit" id="btn_save_komponen_kinerja" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
        <button style="display:none;" disabled id="btn_loading_komponen_kinerja" class="btn btn-success btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading</button>
    </div>
</form>
<div class="col-lg-12">
    <h5 id="error_labels" style="color: red; font-weight: bold; display: none;"></h5>
</div>

<script>
    var id_komponen = '<?=$komponen_kinerja ? $komponen_kinerja['id'] : '0'?>';
    
    $(function(){
        checkLockTpp() 
    })

    function checkLockTpp(){
        $('.class_button_verif').hide()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/checkLockTpp")?>',
            method: 'post',
            data: {
                bulan: '<?=$bulan?>',
                tahun: '<?=$tahun?>',
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    $('.class_button_verif').show()
                    $('#error_labels').hide()
                } else {
                    $('.class_button_verif').hide()
                    $('#error_labels').show()
                    $('#error_labels').html(rs.message)
                }
            }, error: function(e){
                $('.class_button_verif').show()
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function hapusKomponenKinerja(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete_komponen_kinerja').hide()
            $('#btn_delete_loading_komponen_kinerja').show()
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteKomponenKinerja/")?>'+id,
                method: 'post',
                data:$(this).serialize(), 
                success: function(result){
                    var rs = JSON.parse(result);
                    if(rs.code == 1){
                        errortoast(rs.message)
                    } else {
                        successtoast(rs.message)
                        $('#btn_delete_loading_komponen_kinerja').hide()
                        loadKomponenKinerja()
                    }
                }, error: function(e){
                    errortoast(e)
                }
            })
        }
    }

    $('#form_komponen_kinerja').on('submit', function(e){
        $('#btn_save_komponen_kinerja').hide()
        $('#btn_loading_komponen_kinerja').show()
        e.preventDefault()
        if(id_komponen == 0){
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/inputKomponenKinerja/".$id.'/'.$bulan.'/'.$tahun)?>',
                method: 'post',
                data:$(this).serialize(), 
                success: function(result){
                    var rs = JSON.parse(result);
                    if(rs.code == 1){
                        errortoast(rs.message)
                    } else {
                        successtoast(rs.message)
                        id_komponen = rs.data
                        loadKomponenKinerja()
                    }
                }, error: function(e){
                    errortoast(e)
                }
            })
        } else {
            $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/updateKomponenKinerja/".$id.'/'.$bulan.'/'.$tahun.'/')?>'+id_komponen,
            method: 'post',
            data:$(this).serialize(), 
            success: function(result){
                var rs = JSON.parse(result);
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    successtoast(rs.message)
                    id_komponen = rs.data
                    loadListSkbp()
                }
            }, error: function(e){
                errortoast(e)
            }
        })
        }
        $('#btn_save_komponen_kinerja').show()
        $('#btn_loading_komponen_kinerja').hide()
    })
</script>