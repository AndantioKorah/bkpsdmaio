<div class="card card-default">
    <div class="card-header">
        <h5>Data Disiplin Kerja</h5>
    </div>
    <div class="card-body">
        <?php if($result){ ?>
            <table class="table table-hover" id="table_disiplin_kerja_result">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-left">Nama Pegawai</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Pilihan</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $r){ ?>
                        <tr>
                            <td class="text-center"><?=$no?></td>
                            <td class="text-left"><?=getNamaPegawaiFull($r)?></td>
                            <td class="text-center"><?=formatNip($r['username'])?></td>
                            <td class="text-center"><?=formatDateOnly($r['tahun'].'-'.$r['bulan'].'-'.$r['tanggal'])?></td>
                            <td class="text-center"><?=$r['keterangan']?></td>
                            <td class="text-center">
                                <button onclick="deleteDisiplinKerja('<?=$r['id']?>')" type="button" id="btn_delete_<?=$r['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                <button type="button" disabled style="display: none;" id="btn_loading_<?=$r['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="col-12 text-center">
                <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    $(function(){
        $('#table_disiplin_kerja_result').dataTable()
    })

    function deleteDisiplinKerja(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $.ajax({
                url: '<?=base_url("kinerja/C_Kinerja/deleteDataDisiplinKerja")?>'+'/'+id,
                method: 'post',
                data: null,
                success: function(data){
                    successtoast('Berhasil Menghapus Data Disiplin Kerja')
                    $('#form_search_disiplin_kerja').submit()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    // $('#form_search_disiplin_kerja').submit(function(e){
    //     $('#result').show()
    //     $('#result').html('')
    //     $('#result').append(divLoaderNavy)
    //     e.preventDefault()
    //     $.ajax({
    //         url: '<?=base_url("kinerja/C_Kinerja/searchDisiplinKerja")?>',
    //         method: 'post',
    //         data: $(this).serialize(),
    //         success: function(data){
    //             $('#result').html('')
    //             $('#result').append(data)
    //         }, error: function(e){
    //             errortoast('Terjadi Kesalahan')
    //         }
    //     })
    // })
</script>