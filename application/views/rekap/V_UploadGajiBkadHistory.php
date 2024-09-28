<div class="col-lg-12 p-3">
    <?php if($result){ ?>
        <table class="table table-hover table-striped" id="table_history_upload">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal Upload</th>
                <th class="text-center">Uploader</th>
                <th class="text-center">File</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
                        <td class="text-left"><?=$rs['nama']?></td>
                        <td class="text-center">
                            <button onclick="openLink('<?=base_url($rs['url_file'])?>')" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="text-center">
            Data Tidak Ditemukan <i class="fa fa-exclamation"></i>
        </div>
    <?php } ?>
</div>
<script>
    $(function(){
        $('#table_history_upload').dataTable()
    })

    function openLink(url){
        window.open(url, '_blank');
    }
</script>