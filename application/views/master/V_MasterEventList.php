<div class="col-lg-12 table-responsive">
    <table class="table table-hover" id="table_list_event">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Judul</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Absen Masuk</th>
            <th class="text-center">Absen Pulang</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; if($result){ foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=$rs['judul']?></td>
                    <td class="text-center"><?=formatDateNamaBulan($rs['tgl'])?></td>
                    <td class="text-center"><?=formatTimeAbsen($rs['buka_masuk'])?></td>
                    <td class="text-center"><?=formatTimeAbsen($rs['buka_pulang'])?></td>
                    <td class="text-center"></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#table_list_event').dataTable()
    })
</script>