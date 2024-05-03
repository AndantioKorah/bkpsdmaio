<?php if($result){ ?>
    <table class="table table-hover table-striped data-table">
        <thead>
            <th class="text-left">No</th>
            <th class="text-left">Jenis Layanan</th>
            <th class="text-left">Dokumen Persyaratan</th>
            <th class="text-left">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td style="width: 10%;" class="text-left"><?=$no++;?></td>
                    <td style="width: 30%;" class="text-left"><?=$rs['nama']?></td>
                    <td style="width: 30%;" class="text-left"><?=$rs['dokumen']?></td>
                    <td style="width: 30%;" class="text-left">
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



        function deleteMasterHakAkses(id){
            if(confirm('Apakah Anda yakin?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteMasterSyaratLayanan/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(rs){
                        loadSyaratLayanan()
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