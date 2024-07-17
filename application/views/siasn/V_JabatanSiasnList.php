<?php if($result){
?>
    <table border=1 class="table table-hover table-striped" id="table_jabatan_siasn">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Jabatan</th>
            <th class="text-center">Nomor SK</th>
            <th class="text-center">Eselon</th>
            <th class="text-center">TMT Jabatan</th>
            <th class="text-center">Tanggal SK</th>
            <th class="text-center">File</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php if($result['data']){ $no = 1; foreach($result['data'] as $d){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=$d['namaJabatan']?></td>
                    <td class="text-center"><?=$d['nomorSk']?></td>
                    <td class="text-center"><?=$d['eselon'] ? $d['eselon'] : 'Non Eselon'?></td>
                    <td class="text-center"><?=formatDateNamaBulan($d['tmtJabatan'])?></td>
                    <td class="text-center"><?=formatDateNamaBulan($d['tanggalSk'])?></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
<?php } else { ?>
    <h3 class="text-center"><?=$result['data']?></h3>
<?php } ?>

<script>
    $('#table_jabatan_siasn').dataTable()
</script>