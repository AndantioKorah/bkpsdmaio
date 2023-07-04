<?php
    $i = 1;
    if($kinerja){ foreach($kinerja as $rs) {
    $presentase = ($rs['total_realisasi'] / $rs['target_kuantitas']) * 100;
    $presentase = formatTwoMaxDecimal($presentase);
    if($presentase > 100){
        $presentase = 100;
    }
?>
    <tr class="p-3 text-center">
        <td class="text-center"><?=$i++?></td>
        <td class="p-2 text-center">
            <textarea class="form-control form-control-sm" id="deskripsi_kegiatan_<?=$rs['id']?>" name="deskripsi_kegiatan"><?=$rs['sasaran_kerja']?></textarea>
        </td>
        <td class="p-2 text-center">
            <textarea class="form-control form-control-sm" id="tugas_jabatan_<?=$rs['id']?>" name="tugas_jabatan"><?=$rs['tugas_jabatan']?></textarea>
        </td>
        <td class="p-2 text-center">
            <input oninput="oninputtarget('<?=$rs['id']?>')" class="form-control" id="target_kuantitas_<?=$rs['id']?>" name="target_kuantitas" value="<?=$rs['target_kuantitas']?>" />
        </td>
        <td class="p-2 text-center">
            <input oninput="oninputsatuan('<?=$rs['id']?>')" class="form-control" id="satuan_<?=$rs['id']?>" name="satuan" value="<?=$rs['satuan']?>" />
        </td>
        <td class="p-2 text-center">
            <input oninput="oninputrealisasi('<?=$rs['id']?>')" class="form-control" id="realisasi_target_<?=$rs['id']?>" name="realisasi_target" value="<?=$rs['total_realisasi']?>" />
        </td>
        <td class="p-2 text-center">
            <span class="satuan_realisasi_<?=$rs['id']?> text-center"><?=$rs['satuan']?></span>
        </td>
        <td class="p-2 text-center">
            <span class="total_realisasi_<?=$rs['id']?> text-center"><?=$presentase.' %'?></span>
        </td>
        <td class="p-2 text-center">
            <button onclick="updateSkbpRow('<?=$rs['id']?>')" style="font-size: 10px; padding: 3px;"
            id="btn_update_<?=$rs['id']?>" class="btn btn-sm btn-warning">
                <i class="fa fa-save"></i> Simpan
            </button>
            <button style="display: none;" disabled id="btn_update_<?=$rs['id']?>_loading" class="btn btn-sm btn-warning"><i class="fa fa-spin fa-spinner"></i> Loading</button>
            <button onclick="deleteSkbpRow('<?=$rs['id']?>')" style="font-size: 10px; padding: 3px;"
            id="btn_delete_<?=$rs['id']?>" class="btn btn-sm btn-danger">
                <i class="fa fa-save"></i> Hapus
            </button>
            <button style="display: none;" disabled id="btn_delete_<?=$rs['id']?>_loading" class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Loading</button>
        </td>
    </tr>
<?php } } ?>
<tr class="p-3 text-center">
    <td class="text-center"><?=$i++?></td>
    <td class="p-2 text-center">
        <textarea class="form-control form-control-sm" id="deskripsi_kegiatan" name="deskripsi_kegiatan"></textarea>
    </td>
    <td class="p-2 text-center">
        <textarea class="form-control form-control-sm" id="tugas_jabatan" name="tugas_jabatan"></textarea>
    </td>
    <td class="p-2 text-center">
        <input class="form-control" id="target_kuantitas" name="target_kuantitas" />
    </td>
    <td class="p-2 text-center">
        <input class="form-control" id="satuan" name="satuan" />
    </td>
    <td class="p-2 text-center">
        <span class="kuantitas_realisasi text-center"></span>
    </td>
    <td class="p-2 text-center">
        <span class="satuan_realisasi text-center"></span>
    </td>
    <td class="p-2 text-center">
        <span class="total_realisasi text-center">100 %</span>
    </td>
    <td class="p-2 text-center">
        <button style="font-size: 10px; padding: 3px;" onclick="createSkbpRow()" id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</button>
        <button style="display: none; font-size: 10px; padding: 3px;" disabled id="btn_loading" class="btn btn-sm btn-success"><i class="fa fa-spin fa-spinner"></i> Loading</button>
    </td>
</tr>

<script>
    function oninputsatuan(id){
        $('.satuan_realisasi_'+id).text($('#satuan_'+id).val())
    }

    function oninputtarget(id){
        $('#realisasi_target_'+id).val($('#target_kuantitas_'+id).val())
        $('.total_realisasi_'+id).text('100 %')
    }

    function oninputrealisasi(id){
        var total_realisasi = (parseInt($('#realisasi_target_'+id).val()) / parseInt($('#target_kuantitas_'+id).val()) * 100);
        total_realisasi = total_realisasi.toFixed(2);
        if(isNaN(total_realisasi)){
            total_realisasi = 0;
        }
        if(total_realisasi >= 100){
            total_realisasi = 100;
        }

        $('.total_realisasi_'+id).text(total_realisasi + ' %')
    }

    $('#target_kuantitas').on('input', function(){
        $('.kuantitas_realisasi').text($('#target_kuantitas').val())
    })

    $('#satuan').on('input', function(){
        $('.satuan_realisasi').text($('#satuan').val())
    })

    $('#form_row_skbp').on('submit', function(e){
        e.preventDefault()
        alert('asd')
    })

    function updateSkbpRow(id){
        $('#btn_update_'+id).hide()
        $('#btn_update_'+id+'_loading').show()
        var uraian_tugas = $('#deskripsi_kegiatan_'+id).val()
        var tugas_jabatan = $('#tugas_jabatan_'+id).val()
        var target_kuantitas = $('#target_kuantitas_'+id).val()
        var output = $('#satuan_'+id).val()
        var realisasi = $('#realisasi_target_'+id).val()
        if(uraian_tugas == ""){
            errortoast('Uraian Tugas tidak boleh kosong')
            return
        }

        if(tugas_jabatan == ""){
            errortoast('Sasaran Kerja tidak boleh kosong')
            return
        }

        if(target_kuantitas == ""){
            errortoast('Target Kuantitas tidak boleh kosong')
            return
        }

        if(output == ""){
            errortoast('Target Output tidak boleh kosong')
            return
        }

        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/updateRowSkbp/")?>'+id,
            method: 'post',
            data:{
                uraian_tugas: uraian_tugas, 
                tugas_jabatan: tugas_jabatan,
                target_kuantitas: target_kuantitas,
                satuan: output,
                realisasi: realisasi,
                id: '<?=$id?>',
            }, 
            success: function(result){
                var rs = JSON.parse(result);
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    loadSkbpDetail(false)
                    successtoast(rs.message)
                    loadListSkbp()
                }
            }, error: function(e){

            }
        })
    }

    function createSkbpRow(){
        $('#btn_save').hide()
        $('#btn_loading').show()
        var uraian_tugas = $('#deskripsi_kegiatan').val()
        var tugas_jabatan = $('#tugas_jabatan').val()
        var target_kuantitas = $('#target_kuantitas').val()
        var output = $('#satuan').val()
        if(uraian_tugas == ""){
            errortoast('Uraian Tugas tidak boleh kosong')
            return
        }

        if(tugas_jabatan == ""){
            errortoast('Sasaran Kerja tidak boleh kosong')
            return
        }

        if(target_kuantitas == ""){
            errortoast('Target Kuantitas tidak boleh kosong')
            return
        }

        if(output == ""){
            errortoast('Target Output tidak boleh kosong')
            return
        }

        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/inputRowSkbp")?>',
            method: 'post',
            data:{
                uraian_tugas: uraian_tugas, 
                tugas_jabatan: tugas_jabatan,
                target_kuantitas: target_kuantitas,
                satuan: output,
                id: '<?=$id?>',
                bulan: '<?=$bulan?>',
                tahun: '<?=$tahun?>'
            }, 
            success: function(result){
                var rs = JSON.parse(result);
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    loadSkbpDetail(false)
                    successtoast(rs.message)
                    loadListSkbp()
                }
            }, error: function(e){

            }
        })
    }

    function deleteSkbpRow(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete_'+id).hide()
            $('#btn_delete_'+id+'_loading').show()
            $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/deleteRowSkbp/")?>'+id,
            method: 'post',
            data: null, 
            success: function(result){
                var rs = JSON.parse(result);
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    loadSkbpDetail(false)
                    successtoast(rs.message)
                    loadListSkbp()
                }
            }, error: function(e){

            }
        })
        }
    }
</script>