<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover table-striped" id="table_history">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Nama Broadcast</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Broadcast By</th>
                <th class="text-center">Jumlah Pegawai</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-left"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama_broadcast']?></td>
                        <td class="text-left"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
                        <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
                        <td class="text-center"><?=formatCurrencyWithoutRpWithDecimal($rs['jumlah_pegawai'], 0)?></td>
                        <td class="text-center">
                            <button type="button" href="#broadcast_monitoring_modal" onclick="detailBroadcast('<?=$rs['id']?>')"
                            class="btn btn-sm btn-info">Detail</button>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#table_history').dataTable()
    })

    function detailBroadcast(id){
        $('#broadcast_monitoring_modal_content').html('')
        $('#broadcast_monitoring_modal_content').append(divLoaderNavy)
        $('#broadcast_monitoring_modal_content').load('<?=base_url('admin/C_Admin/detailBroadcast/')?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>