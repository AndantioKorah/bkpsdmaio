<?php if($result){
$filename = 'List Pegawai yang akan Pensiun.xls';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename");    

?>
    <style>
        .text-nama{
            font-size: 1rem;
            font-weight: bold;
        }

        .text-small{
            font-size: 1rem;
            /* color: gray; */
        }

        #table_result, #table_result thead, #table_result th, #table_result tr, #table_result td{
            border: 1px solid gray;
        }
    </style>
    <div class="row p-3">
        <div class="col-lg-12">
            <table border=1 id="table_result" class="table table-hover datatable">
                <thead>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama Pegawai</th>
                    <th style="text-align: center;">NIP</th>
                    <th style="text-align: center;">Pangkat</th>
                    <th style="text-align: center;">Jabatan</th>
                    <th style="text-align: center;">Jenis Jabatan</th>
                    <th style="text-align: center;">Unit Kerja</th>
                    <th style="text-align: center;">Umur</th>
                    <th style="text-align: center;" class="text-center">TMT Pensiun</th>
                    <!-- <th style="text-align: center";>TMT Naik Pangkat</th> -->
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ ?>
                        <tr>
                            <td style="text-align: center" class="text-center"><?=$no++;?></td>
                            <td style="text-align: left" class="text-left">
                                <span class="text-nama"><?=getNamaPegawaiFull($rs)?></span><br>
                            </td>
                            <td style="text-align: center">
                                <span class="text-small"><?=formatNip($rs['nipbaru_ws'])?></span><br>
                            </td>
                            <td style="text-align: left">
                                <span class="text-small"><?=($rs['nm_pangkat'])?></span><br>
                            </td>
                            <td style="text-align: left" class="text-center"><?=($rs['nama_jabatan'])?></td>
                            <td style="text-align: left" class="text-center"><?=($rs['jenis_jabatan'])?></td>
                            <td style="text-align: left" class="text-left"><?=($rs['nm_unitkerja'])?></td>
                            <td style="text-align: center" class="text-left"><?=($rs['umur'])?></td>
                            <td style="text-align: center;"><?=formatDateOnly($rs['tmt_pensiun'])?></td>
                            <!-- <td style="text-align: left" class="text-center"><?=formatDateOnly($rs['tmtpangkat'])?></td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="p-3">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>

<script>
    $(function(){
        $('.datatable').dataTable()
    })
</script>