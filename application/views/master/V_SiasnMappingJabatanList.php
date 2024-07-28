<table id="table_list_jabatan" class="table table-striped table-hover">
    <thead>
        <th style="width: 5%;" class="text-center">No</th>
        <th style="width: 35%;" class="text-left">Nama Jabatan Siladen</th>
        <th style="width: 35%;" class="text-left">Nama Jabatan SIASN</th>
        <th style="width: 10%;" class="text-left">Jenis Jabatan</th>
        <th style="width: 15%;" class="text-left">Pilihan</th>
    </thead>
    <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td class="text-left"><?=$rs['nama_jabatan']?></td>
                <td class="text-left"><?=$rs['nama_jabatan_siasn']?></td>
                <td class="text-left"><?=$rs['jenis_jabatan']?></td>
                <td class="text-left">
                    <button href="#modal_edit_jabatan" data-toggle="modal" onclick="editUnorBidang('<?=$rs['id_jabatanpeg']?>')"
                    class="btn btn-sm btn-navy">
                        Edit
                    </button>
                    <button onclick="deleteMappingBidang('<?=$rs['id_jabatanpeg']?>')" class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
        <?php } } ?>
    </tbody>
</table>
<script>
    $(function(){
        $('#table_list_jabatan').dataTable()
    })

    function editUnorBidang(id){
        $('#modal_edit_jabatan_content').html('')
        $('#modal_edit_jabatan_content').append(divLoaderNavy)
        $('#modal_edit_jabatan_content').load('<?=base_url("master/C_Master/loadDetailJabatanMapping")?>'+'/'+id, function(){
            $('#loader').hide()
        })
    }
</script>