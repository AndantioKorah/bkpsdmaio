<?php if($result){ ?>
    <div class="row p-3">
        <div class="col-lg-12 form-group">
            <form id="form_submit_edit">
                <div class="row">
                    <div class="col-lg-12">
                        <label>UNIT KERJA SILADEN</label><br>
                        <label style="font-weight: bold; font-size: 1.5rem;"><?=$result['nm_unitkerja']?></label>
                        <input class="form-control" value="<?=$result['id_unitkerja']?>" name="id_unitkerja" style="display: none;" />
                        <br>
                        <label style="color: grey; font-weight: bold; font-size: 1rem;">
                            <?= $result['id_unor_siasn'] ? $result['id_unor_siasn'] : "" ?>
                        </label>
                    </div>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg-12">
                        <label>UNOR SIASN</label>
                        <select class="form-control select2-navy" style="width: 100%;"
                            id="id_unor_siasn" data-dropdown-css-class="select2-navy" name="id_unor_siasn">
                            <?php if($list_unor_siasn){
                                foreach($list_unor_siasn as $ls){
                                ?>
                                <option <?=$ls['id'] == $result['id_unor_siasn'] ? 'selected' : '';?> value="<?=$ls['id']?>">
                                    <?=$ls['nama_unor']?>
                                </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-lg-12 mt-3 text-right">
                        <button class="btn btn-navy btn-block" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
<?php } ?>
<script>
    $(function(){
        $('#id_unor_siasn').select2()
    })

    $('#form_submit_edit').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/saveEditMappingUnor/")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                $('#id_label_unor_<?=$id_unitkerja?>').html(rs.nama_unor)
                successtoast('Edit Berhasil')
                $('#modal_edit_unor').modal('hide')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>