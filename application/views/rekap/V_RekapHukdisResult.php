<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover" id="table_result">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Pegawai</th>
                <th class="text-center">Perangkat Daerah</th>
                <th class="text-center">Nomor SK</th>
                <th class="text-center">Tanggal SK</th>
                <th class="text-center">Jenis Hukdis</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">File</th>
            </thead>
            <tbody>
                <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++?></td>
                        <td class="text-left">
                            <strong><?=getNamaPegawaiFull($rs)?></strong><br>
                            <?="NIP. ".$rs['nipbaru_ws']?>
                        </td>
                        <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                        <td class="text-center"><?=$rs['nosurat']?></td>
                        <td class="text-center"><?=formatDateNamaBulan($rs['tglsurat'])?></td>
                        <td class="text-center"><?=$rs['nama_hd']?></td>
                        <td class="text-left"><?=$rs['nama_jhd']?></td>
                        <td class="text-center">
                            <?php if($rs['gambarsk']){ ?>
                            <a class="btn btn-warning" target="_blank" href="<?=base_url('arsipdisiplin/'.$rs['gambarsk'])?>"><i class="fa fa-file"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#table_result').dataTable()
    })
</script>