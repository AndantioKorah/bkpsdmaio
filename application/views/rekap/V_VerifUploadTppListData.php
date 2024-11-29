<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover table-striped tabel_riwayat_upload_berkas_tpp">
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
                    <tr class="tr_<?=$rs['id']?>">
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
                            ">pada: <?=formatDateNamaBulanWT($rs['created_date'])?></span>
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
                        <td class="text-left">
                            <?php
                                $keterangan_verif = $rs['keterangan'];
                                if($rs['flag_verif'] == 1){
                                    $keterangan_verif = 'DITERIMA';
                                } else if($rs['flag_verif'] == 2){
                                    $keterangan_verif = 'DITOLAK';
                                }
                            ?>
                            <?=$keterangan_verif?><br>
                            <?php if($rs['flag_verif'] != 0){ ?>
                                <span style="
                                        color: grey;
                                        font-size: .8rem;
                                        font-weight: bold;
                                    "><?='('.($rs['keterangan']).')'?>
                            <?php } ?>
                            <?php if($rs['url_file_balasan']){ ?>
                                <br>
                                <button class="btn btn-sm btn-outline-success" href="#modal_file_balasan" data-toggle="modal"
                                    onclick="detailUploadBerkasTpp('<?=$rs['id']?>', '<?=$rs['url_file_balasan']?>')">
                                    <i class="fa fa-file-pdf"></i> File Balasan Sudah Diupload
                                </button>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php
                                // jika belum verif, munculkan tombol verif
                                if($rs['flag_verif'] == 0 
                                || ($this->general_library->isProgrammer() || ($rs['flag_verif'] != 0 
                                && $rs['id_m_user_verifikator'] == $this->general_library->getId()))){ // jika belum verif atau verifikator adalah yang login
                            ?>
                                    <button class="btn btn-sm btn-info" data-toggle="modal" href="#modal_verif_upload_berkas_tpp" onclick="openVerifDialog('<?=$rs['id']?>')">
                                        <i class="fa fa-edit"></i> Verif
                                    </button>
                                    <!-- <button id="btn_delete" class="btn btn-sm btn-danger" onclick="hapusUploadTpp('<?=$rs['id']?>')"><i class="fa fa-trash"></i> Hapus</button> -->
                                    <!-- <button style="display: none;" id="btn_delete_loading" disabled class="btn btn-sm btn-danger"><i class="fa fa-spin fa-spinner"></i> Menghapus...</button> -->
                            <?php
                                }
                                if($rs['flag_verif'] == 1 
                                && ($this->general_library->isProgrammer() || $rs['id_m_user_verifikator'] == $this->general_library->getId())){ // jika diterima dan verifikator adalah yang login
                            ?>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" href="#modal_upload_balasan" onclick="uploadFileBalasan('<?=$rs['id']?>')">
                                        <i class="fa fa-upload"></i> Upload File Balasan
                                    </button>
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
        $('.tabel_riwayat_upload_berkas_tpp').dataTable()
    })

    function detailUploadBerkasTpp(id, url){
        $('#modal_file_balasan_content').html('')
        $('#modal_file_balasan_content').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/openFileUploadBerkasTpp/')?>'+id,
            method: 'POST',
            data: {
                url: url
            },
            success: function(rs){
                $('#modal_file_balasan_content').html(rs)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }

    function uploadFileBalasan(id){
        $('#modal_upload_balasan_content').html('')
        $('#modal_upload_balasan_content').append(divLoaderNavy)
        $('#modal_upload_balasan_content').load('<?=base_url("rekap/C_Rekap/loadModalBalasanVerifTpp/")?>'+id, function(){
            $('#loader').hide()
        })
    }

    function openVerifDialog(id){
        $('#modal_verif_upload_berkas_tpp_content').html('')
        $('#modal_verif_upload_berkas_tpp_content').append(divLoaderNavy)
        $('#modal_verif_upload_berkas_tpp_content').load('<?=base_url("rekap/C_Rekap/loadModalVerifUploadBerkasTpp/")?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>