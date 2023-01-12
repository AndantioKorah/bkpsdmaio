<?php if($result){ ?>
    <table class="table datatable">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">SKPD</th>
            <th class="text-left">Kelas Jabatan</th>
            <th class="text-left">Jenis Jabatan</th>
            <th class="text-center">Presentase</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td><?=$rs['nm_unitkerja']?></td>
                    <td><?=$rs['kelas_jabatan'] == 0 ? 'Semua' : $rs['kelas_jabatan'];?></td>
                    <td><?=strtoupper($rs['jenis_jabatan'])?></td>
                    <td><?=$rs['presentase'].'%'?></td>
                    <td class="text-center">
                        <button onclick="hapusMasterTpp('<?=$rs['id']?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(function(){
            $('.datatable').dataTable()
        })

        function hapusMasterTpp(id){
            if(confirm('Apakah Anda yakin?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/hapusMasterPresentaseTpp")?>'+'/'+id,
                    method: 'post',
                    data: null,
                    success: function(rs){
                        successtoast('Data Berhasil Dihapus')
                        loadTpp()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } ?>