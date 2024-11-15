<div class="row">
    <div class="col-lg-12 table-responsive">
        <table id="result_table" class="table table-striped table-hover">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Verifikator</th>
                <th class="text-center">Total Verifikasi</th>
            </thead>
            <tbody>
                <?php $max = 0; $no = 1; foreach($result as $rs){  
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama']?></td>
                        <td class="text-center">
                            <span style="color: black; font-weight: bold !important;"><?=formatCurrencyWithoutRp($rs['total_verif'], 0)?></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#result_table').dataTable()
    })
</script>