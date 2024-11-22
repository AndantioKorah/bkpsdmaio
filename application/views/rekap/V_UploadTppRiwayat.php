<div class="table-responsive">
    <table class="table table-hover table-striped" id="tabel_riwayat_upload_berkas_tpp">
    <thead>
        <th class="text-center">No</th>
        <th class="text-left">Perangkat Daerah</th>
        <th class="text-center">Periode</th>
        <th class="text-left">Uploader</th>
        <th class="text-left">Verifikator</th>
        <th class="text-left">Status</th>
        <th class="text-center">Pilihan</th>
    </thead>
    <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
            <tr>
                <td class="text-center"><?=$no++;?></td>
                <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                <td class="text-center">
                    <?=getNamaBulan($rs['bulan']).' '.$rs['tahun']?>
                </td>
                <td class="text-left">
                    <span><?=$rs['nama_uploader']?></span><br>
                    <span style="
                        color: grey;
                        font-size: .8rem;
                        font-weight: bold;
                    ">pada: <?=formatDateNamaBulanWT($rs['created_date'])?></span><br>
                    <button class="btn btn-sm btn-outline-danger" href="#modal_upload_tpp" data-toggle="modal"
                        onclick="detailUploadBerkasTpp('<?=$rs['id']?>', '<?=$rs['url_upload_file']?>')">
                        <i class="fa fa-file-pdf"></i> Lihat File
                    </button>
                </td>
                <td class="text-left">
                    <?php if($rs['nama_verifikator']){ ?>
                        <span><?=$rs['nama_verifikator']?></span><br>
                        <span style="
                            color: grey;
                            font-size: .8rem;
                            font-weight: bold;
                        ">pada: <?=formatDateNamaBulanWT($rs['tanggal_verif'])?></span>
                    <?php } ?>
                </td>
                <td class="text-left"><?=$rs['keterangan']?></td>
                <td class="text-center">
                    <?php if($rs['flag_verif'] == 0){ ?>
                        <button id="btn_delete" class="btn btn-sm btn-danger" onclick="hapusUploadTpp('<?=$rs['id']?>')"><i class="fa fa-trash"></i> Hapus</button>
                        <button style="display: none;" id="btn_delete_loading" disabled class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } } ?>
    </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#tabel_riwayat_upload_berkas_tpp').dataTable()
    })

    function detailUploadBerkasTpp(id, url){
        $('#modal_upload_tpp_content').html('')
        $('#modal_upload_tpp_content').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/openFileUploadBerkasTpp/')?>'+id,
            method: 'POST',
            data: {
                url: url
            },
            success: function(rs){
                $('#modal_upload_tpp_content').html(rs)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }

    function hapusUploadTpp(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $('#btn_delete').hide()
            $('#btn_delete_loading').show()
            $.ajax({
                url: '<?=base_url('rekap/C_Rekap/deleteRiwayatUploadBerkasTpp/')?>'+id,
                method: 'POST',
                data: null,
                success: function(rs){
                    let res = JSON.parse(rs)
                    if(res.code == 0){
                        successtoast('Data berhasil dihapus')
                        loadRiwayatUpload()
                    } else {
                        errortoast(res.message)
                    }
                }, error: function(e){
                    $('#div_upload_button').hide()
                    errortoast('Terjadi Kesalahan')
                    console.log(e)
                }
            })
        }
    }
</script>