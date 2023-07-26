<?php if($result){ ?>
    <table class="table table-hover table-striped data-table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Jenis Layanan</th>
            <th class="text-center">Aktif</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=$rs['nama']?></td>
                    <td class="text-center">
                        <div class="form-check form-switch">
                            <input onchange="toggleChange('<?=$rs['id']?>')" style="width: 100%; height: 28px;" class="form-check-input" 
                            type="checkbox" role="switch" <?=$rs['aktif'] == "YA" ? "checked" : "" ?> id="toggle_<?=$rs['id']?>" >
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('.data-table').dataTable()
        })

        function toggleChange(id){
            console.log($('#toggle_'+id).is(':checked'))
            var state = "TIDAK";
            if($('#toggle_'+id).is(':checked')){
                state = "YA";
            }

            $.ajax({
                url: '<?=base_url("master/C_Master/editMasterJenisLayanan/")?>'+id+'/'+state,
                method: 'post',
                data: null,
                success: function(rs){
                    // loadJenisLayanan()
                    successtoast('Jenis Layanan berhasil diupdate')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h4>
        </div>
    </div>
<?php } ?>