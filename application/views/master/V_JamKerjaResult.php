<?php if($result){ ?>
    <table class="table table-hover" id="table_jam_keraj">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Jenis SKPD</th>
            <th class="text-left">Nama Jam Kerja</th>
            <th class="text-center">Jam Kerja</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){ dd(json_encode($rs));?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-center"><?=$rs['jenis_skpd']?></td>
                    <td class="text-left"><?=$rs['nama_jam_kerja']?></td>
                    <td class="text-center"><?=$rs['jam_kerja']?></td>
                    <td class="text-center">
                        <!-- <button onclick="deleteJamKerja('<?=$rs['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button> -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('#table_jam_keraj').dataTable()
        })

        function deleteJamKerja(id){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteJamKerja")?>'+'/'+id,
                method: 'post',
                data: {},
                success: function(){
                    successtoast('Berhasil')
                    loadJamKerja()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>