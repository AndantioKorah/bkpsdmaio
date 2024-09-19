<div class="col-lg-12 table-responsive">
    <table class="table table-hover table-striped" id="result_table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">NIP</th>
            <th class="text-center">Perangkat Daerah</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Gaji</th>
            <th class="text-center">Last Update</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
                    <td class="text-left"><?=($rs['nipbaru_ws'])?></td>
                    <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                    <td class="text-left"><?=$rs['nama_jabatan']?></td>
                    <td class="text-center"><?=formatCurrencyWithoutRp($rs['besaran_gaji'], 0)?></td>
                    <td class="text-center"><?=$rs['created_date'] ? formatDateNamaBulanWT($rs['created_date']) : ''?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#result_table').dataTable()
    })
</script>