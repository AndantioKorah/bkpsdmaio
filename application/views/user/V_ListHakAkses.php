<?php if($result){ ?>
    <table class="table table-hover table-striped">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Hak Akses</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=$rs['nama_hak_akses']?></td>
                    <td class="text-center">
                        <button id="btn_delete_<?=$rs['id_t_hak_akses']?>" onclick="deleteHakAkses('<?=$rs['id_t_hak_akses']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        <button id="btn_delete_<?=$rs['id_t_hak_akses']?>_loading" disabled style="display: none;" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        function deleteHakAkses(id){
            if(confirm('Apakah Anda yaking ingin menghapus data?')){
                $('#btn_deletet_'+id).hide()
                $('#btn_deletet_'+id+'_loading').show()
                $.ajax({
                    url: '<?=base_url("user/C_User/deleteHakAkses/")?>'+id,
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data){
                        successtoast('Berhasil menghapus Hak Akses')
                        $('#btn_deletet_'+id).show()
                        $('#btn_deletet_'+id+'_loading').hide()
                        refreshHakAkses()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                        $('#btn_deletet_'+id).show()
                        $('#btn_deletet_'+id+'_loading').hide()
                    }
                });
            }
        }
    </script>
<?php } ?>