<?php if($result){ ?>
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover table-striped" id="tableResult">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Perangkat Daerah</th>
                <th class="text-center">Periode</th>
                <th class="text-center">Download</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['nama_param_unitkerja']?></td>
                        <td class="text-left"><?=getNamaBulan($rs['bulan']).' '.$rs['tahun']?></td>
                        <td class="text-center">
                            <form action="<?=base_url('rekap/C_Rekap/formatTppBkadDownload/'.$rs['id'])?>" method="post" target="_blank">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="col-lg-12 text-center">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>
<script>
    $(function(){
        $('#tableResult').dataTable()
    })
</script>