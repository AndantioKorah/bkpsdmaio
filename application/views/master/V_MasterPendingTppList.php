<table class="table table-sm table-hover table-striped">
    <thead>
        <th class="text-center">No</th>
        <th class="text-center">Pegawai</th>
        <th class="text-center">Unit Kerja</th>
        <th class="text-center">Periode</th>
        <th class="text-center">Keterangan</th>
        <th class="text-center">Pilihan</th>
    </thead>
    <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td class="text-left">
                    <span style="color: black; font-size: .9rem; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span>
                    <br>
                    <span style="color: grey; font-size: .65rem; font-weight: bold;">NIP. <?=($rs['nip'])?></span>
                    <br>
                    <span style="color: grey; font-size: .65rem; font-weight: bold;"><?=($rs['nama_jabatan'])?></span>
                </td>
                <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                <td class="text-left"><?=getNamaBulan($rs['bulan'])." ".$rs['tahun']?></td>
                <td class="text-left"><?=$rs['keterangan']?></td>
                <td class="text-center">
                    <button onclick="deleteDataPendingTpp('<?=$rs['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php } } ?>
    </tbody>
</table>
<script>
    function deleteDataPendingTpp(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteDataPendingTpp/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    let resp = JSON.parse(data)
                    if(resp.code == 0){
                        loadDataListPending()
                        successtoast('Data Berhasil Dihapus')
                    } else {
                        errortoast(resp.message)
                    }
                    $('#btn_save').show()
                    $('#btn_save_loading').hide()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                    $('#btn_save').show()
                    $('#btn_save_loading').hide()
                }
            })
        }
    }
</script>