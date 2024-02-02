<div class="row">
    <div class="col-lg-12">
        <div class="card card-table p-3">
            <table class="table table-striped table-hover" id="table-rekap">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Unit Kerja</th>
                    <th class="text-center">Eselon 2</th>
                    <th class="text-center">Eselon 3</th>
                    <th class="text-center">Eselon 4</th>
                    <th class="text-center">JF Utama</th>
                    <th class="text-center">JF Madya</th>
                    <th class="text-center">JF Muda</th>
                    <th class="text-center">JF Pertama</th>
                    <th class="text-center">JF Terampil</th>
                    <th class="text-center">Pelaksana</th>
                    <th class="text-center">Total</th>
                </thead>
                <tbody>
                    <?php if($result){ $no = 1; foreach($result as $rs){?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                            <td class="text-center"><?=$rs['eselon_2']?></td>
                            <td class="text-center"><?=$rs['eselon_3']?></td>
                            <td class="text-center"><?=$rs['eselon_4']?></td>
                            <td class="text-center"><?=$rs['jf_utama']?></td>
                            <td class="text-center"><?=$rs['jf_madya']?></td>
                            <td class="text-center"><?=$rs['jf_muda']?></td>
                            <td class="text-center"><?=$rs['jf_pertama']?></td>
                            <td class="text-center"><?=$rs['jf_terampil']?></td>
                            <td class="text-center"><?=$rs['pelaksana']?></td>
                            <td class="text-center"><?=$rs['total']?><td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#table-rekap').dataTable()
    })
</script>