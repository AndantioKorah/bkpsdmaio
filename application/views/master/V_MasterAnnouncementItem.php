<?php if($list_announcement){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped" id="table_master_bidang">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Anouncement</th>
                <th class="text-left">Gambar</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no=1; foreach($list_announcement as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['nama_announcement']?></td>
                        <td class="text-left"> 
                            <img style="height: 100px; width: 100px" src="<?=base_url();?><?=$lp['url_file']?>" alt="">
                        </td>
                        <td class="text-center">
                            <button onclick="deleteAnnouncement('<?=$lp['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('#table_master_bidang').DataTable({
                responsive: false
            });
        })

        function deleteAnnouncement(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteAnnouncement/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListAnouncement()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>