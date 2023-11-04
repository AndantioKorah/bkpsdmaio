<table class="table table-hover table-striped data_table">
    <thead>
        <th class="text-center">No</th>
        <th class="text-center">Nama Pelanggaran</th>
        <th class="text-center">Pilihan</th>
    </thead>
    <tbody>
        <?php if($result) { $no=1; foreach($result as $rs){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td class="text-left"><?=$rs['nama_pelanggaran']?></td>
                <td class="text-center">
                    <button href="#modal_pelanggaran_detail" data-toggle="modal" onclick="detailPelanggaran('<?=$rs['id']?>')" 
                    class="btn btn-sm btn-navy"><i class="fa fa-list"></i> Detail</button>
                    <button onclick="deleteHukdis('<?=$rs['id']?>')" 
                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </td>
            </tr>
        <?php } } ?>
    </tbody>
</table>
<script>
    $(function(){
        $('.data_table').dataTable()
    })

    function detailPelanggaran(id){
        $('#modal_pelanggaran_detail_content').html('')   
        $('#modal_pelanggaran_detail_content').append(divLoaderNavy)   
        $('#modal_pelanggaran_detail_content').load('<?=base_url('master/C_Master/loadDetailPelanggaran/')?>'+id, function(){
            $('#loader').hide()
        })   
    }

    function deletePelanggaran(id){
        if(confirm('Apakah Anda yakin?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deletePelanggaran/")?>'+id,
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    successtoast('Data Berhasil Dihapus')
                    loadPelanggaran()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
</script>