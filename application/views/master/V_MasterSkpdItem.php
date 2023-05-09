<style>
    .table_result, .table_result tr, .table_result td{
        border: 1px solid;
    }

    .class_tr:hover{
        cursor: pointer;
    }
</style>

<?php if($result){ ?>
    <?php if($ukmaster == '2000000'){ ?>
    <?php } else { ?>
        <table id="table_result" border=1 class="table table-hover">
            <thead style="font-weight: bold;">
                <tr>
                    <td rowspan=2 class="text-center">No</td>
                    <td rowspan=2 class="text-center">Nama Perangkat Daerah</td>
                    <td rowspan=1 colspan=2 class="text-center">Jumlah Pegawai</td>
                    <td rowspan=2 colspan=1 class="text-center">Jumlah Pegawai</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;" rowspan=1 colspan=1 class="text-center">Laki-laki</td>
                    <td style="border-bottom: 1px solid;" rowspan=1 colspan=1 class="text-center">Perempuan</td>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr border=1 class="class_tr" onclick="openDetailSkpd('<?=$rs['id_unitkerja']?>')">
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                        <td class="text-center"><?=$rs['total_laki']?></td>
                        <td class="text-center"><?=$rs['total'] - $rs['total_laki']?></td>
                        <td class="text-center"><?=$rs['total']?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    <script>
        $(function(){
            $('#table_result').dataTable()
        })

        function openDetailSkpd(id){
            window.location="<?=base_url('master/perangkat-daerah/detail/')?>"+id
        }
    </script>
<?php } ?>