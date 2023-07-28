<?php if($result){ ?>
    <table class="table table-hover table-striped data-table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Hak Akses</th>
            <th class="text-center">Meta Name</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td style="width: 10%;" class="text-center"><?=$no++;?></td>
                    <td style="width: 30%;" class="text-left"><?=$rs['nama_hak_akses']?></td>
                    <td style="width: 30%;" class="text-left"><?=$rs['meta_name']?></td>
                    <td style="width: 30%;" class="text-center">
                        <button onclick="openModalHakAkses('<?=$rs['id']?>')" class="btn btn-warning btn-sm" href="#modal_tambah_user"
                        data-toggle="modal"><i class="fa fa-plus"></i> User</button>
                        <button onclick="deleteMasterHakAkses('<?=$rs['id']?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('.data-table').dataTable()
        })

        function openModalHakAkses(id){
            $('#modal_tambah_user_content').html('')
            $('#modal_tambah_user_content').append(divLoaderNavy)
            $('#modal_tambah_user_content').load('<?=base_url("master/C_Master/loadUserHakAkses/")?>'+id, function(){
                $('#loader').hide()
            })
        }

        function deleteMasterHakAkses(id){
            if(confirm('Apakah Anda yakin?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteMasterHakAkses/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(rs){
                        loadHakAkses()
                        successtoast('Berhasil Menghapus Data')
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h4>
        </div>
    </div>
<?php } ?>