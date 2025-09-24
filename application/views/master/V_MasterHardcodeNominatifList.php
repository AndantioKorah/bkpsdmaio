<table class="table table-hover" id="table_hardcode_nominatif">
    <thead>
        <th class="text-center">No</th>
        <th class="text-center">Pegawai</th>
        <th class="text-center">Unit Kerja</th>
        <th class="text-center">Jabatan</th>
        <th class="text-center">Periode</th>
        <th class="text-center">Keterangan</th>
        <th class="text-center">Pilihan</th>
    </thead>
    <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
                <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                <td class="text-left"><?=$rs['nama_jabatan']?></td>
                <td class="text-left"><?=getNamaBulan($rs['bulan'])." ".$rs['tahun']?></td>
                <td class="text-center">
                    <?php if($rs['flag_add'] == 0){ ?>
                        <span class="badge badge-danger">Hilangkan</span>
                    <?php } else { ?>
                        <span class="badge badge-success">Tambahkan</span>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger" type="button" onclick="hapusData('<?=$rs['id']?>')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php } } ?>
    </tbody>
</table>
<script>
    $(function(){
        $('#table_hardcode_nominatif').dataTable()
    })

    function hapusData(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteHardcodeNominatif/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    let resp = JSON.parse(data)
                    if(resp['code'] == 1){
                        errortoast(resp['message'])
                    } else {
                        loadListHardcode()
                        successtoast("Data berhasil dihapus")
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
</script>