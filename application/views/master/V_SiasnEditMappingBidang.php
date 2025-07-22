<?php if($result){ ?>
    <div class="row p-3">
        <div class="col-lg-12 form-group">
            <form id="form_submit_edit">
                <div class="row">
                    <div class="col-lg-12">
                        <label>BIDANG</label><br>
                        <label style="font-weight: bold; font-size: 1.5rem;"><?=$result['nama_bidang']?></label>
                        <br>
                        <label style="color: grey; font-weight: bold; font-size: 1rem;">
                            <?= $result['id_unor_siasn'] ? $result['id_unor_siasn'] : "" ?>
                        </label>
                        <input class="form-control" value="<?=$result['id_m_bidang']?>" name="id_m_bidang" style="display: none;" />
                    </div>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg-12">
                        <label>UNOR SIASN</label>
                        <select class="form-control select2-navy" style="width: 100%;"
                            id="id_unor_siasn" data-dropdown-css-class="select2-navy" name="id_unor_siasn">
                            <option selected disabled>Pilih Unor</option>
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
        <div class="col-lg-12"><hr></div>
        <div class="col-lg-12 form-group">
            <table class="table table-hover table-striped" id="table_list_sub_bidang">
                <thead>
                    <th style="width: 10%;" class="text-center">No</th>
                    <th style="width: 35%;" class="text-center">Sub Bidang</th>
                    <th style="width: 35%;" class="text-center">Unor SIASN</th>
                    <th style="width: 10%;" class="text-center">Edit</th>
                    <th style="width: 10%;" class="text-center">Hapus</th>
                </thead>
                <tbody>
                    <?php if($list_sub_bidang){ $no = 1; foreach($list_sub_bidang as $lsb){ ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left"><?=$lsb['nama_sub_bidang']?></td>
                            <td class="text-left">
                                <label id="label_unor_sub_bidang_<?=$lsb['id']?>"><?=$lsb['nama_unor']?></label>
                                <br>
                                <label style="color: grey; font-weight: bold; font-size: .75rem;">
                                    <?=$lsb['id_unor_siasn']?>
                                </label>
                            </td>
                            <td class="text-left">
                                <select class="form-control select2-unor select2-navy" style="width: 100%;"
                                    id="id_unor_siasn_<?=$lsb['id']?>" data-dropdown-css-class="select2-navy" name="id_unor_siasn">
                                    <option selected disabled>Pilih Unor</option>
                                    <?php if($list_unor_siasn_sub_bidang){
                                        foreach($list_unor_siasn_sub_bidang as $ls){
                                        ?>
                                        <option <?=$ls['id'] == $lsb['id_unor_siasn'] ? 'selected' : '';?> value="<?=$ls['id']?>">
                                            <?=$ls['nama_unor']?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </td>
                            <td>
                                <button onclick="saveMappingSubBidang('<?=$lsb['id']?>')" class="btn btn-sm btn-navy">Simpan</button>
                            </td>
                            <td>
                                <button onclick="deleteMappingSubBidang('<?=$lsb['id']?>')" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
<?php } ?>
<script>
    $(function(){
        $('#id_unor_siasn').select2()
        $('.select2-unor').select2()
    })

    function deleteMappingSubBidang(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteMappingSubBidang/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    $('#label_unor_sub_bidang_'+id).html('')
                    successtoast('Data sudah terhapus')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    function saveMappingSubBidang(id){
        $.ajax({
            url: '<?=base_url("master/C_Master/saveEditMappingSubBidang/")?>'+id,
            method: 'post',
            data: {
                id_unor_siasn: $('#id_unor_siasn_'+id).val()
            },
            success: function(data){
                let rs = JSON.parse(data)
                $('#label_unor_sub_bidang_'+id).html(rs.nama_unor)
                successtoast('Edit Berhasil')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#form_submit_edit').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/saveEditMappingBidang/")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                $('#label_unor_siasn_<?=$id_unitkerja?>').html(rs.nama_unor)
                successtoast('Edit Berhasil')
                $('#modal_edit_unor').modal('hide')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>