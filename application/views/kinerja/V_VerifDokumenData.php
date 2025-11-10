<?php if($result){ ?>
    <style>
        .col-checkbox{
            /* width: 50px; */
            cursor: pointer;
        }
    </style>
    <table border=1 class="table table-hover" id="table_disiplin_kerja_result_data">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">Nama Pegawai</th>
            <th class="text-left">Unit Kerja</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Tanggal Usul</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Dokumen</th>
            <th class="text-center">Keterangan Verif</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; foreach($result as $r){ ?>
                <tr id="tr_<?=$r['id']?>">
                    <td class="text-center"><?=$no?></td>
                    <td class="text-left"><?=getNamaPegawaiFull($r).'<br>NIP. '.$r['nipbaru']?></td>
                    <td class="text-left"><?=($r['nm_unitkerja'])?></td>
                    <?php
                        $tanggal_dokumen = formatDateNamaBulan($r['dari_tanggal']);
                        if($r['dari_tanggal'] != $r['sampai_tanggal']){
                            $tanggal_dokumen = formatDateNamaBulan($r['dari_tanggal']).' - '.formatDateNamaBulan($r['sampai_tanggal']);
                        }
                    ?>
                    <td class="text-center"><?= $tanggal_dokumen ?></td>
                    <td class="text-center"><?= formatDateNamaBulanWT($r['created_date']) ?></td>
                    <td class="text-center"><?= ($r['nama_jenis_disiplin_kerja']) ?></td>
                    <td class="text-center">
                        <?php if($r['url_outside']){ ?>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-navy btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_blank" href="<?=base_url($r['url_outside'])?>">Dokumen</a>
                                </div>
                            </div>
                        <?php } else if($r['dokumen_pendukung']) { $dokpen = json_decode($r['dokumen_pendukung']); if($dokpen[0] != "") { $nodok = 1; ?>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-navy btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <?php foreach($dokpen as $dk){ ?>
                                        <a class="dropdown-item" target="_blank" href="<?=base_url(DOKUMEN_PENDUKUNG_DISIPLIN_KERJA.'/'.$dk)?>">Dokumen <?=$nodok++;?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            -
                        <?php } } ?>
                    </td>
                    <td>
                        <?php if($status == 2 || $status == 3){ ?>
                            <span><strong><?=$r['keterangan_verif']?></strong></span><br>
                            <!-- <span style="font-size: 14px;"><?='(oleh '.$r['nama_verif'].' pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span> -->
                            <span style="font-size: 14px;"><?='(pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } else if($status == 1) { ?> 
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                        <?php } else if($status == 4){ ?>
                            <input class="form-control" id="ket_verif_<?=$r['id']?>" />
                            <span style="font-size: 14px;"><?='(DIBATALKAN pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(2, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i> Terima</button>
                            <!-- <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(3, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'block' : 'none'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-danger" title="Tolak"><i class="fa fa-times"></i></button> -->
                            <button data-list_id='<?=json_encode($r['list_id'])?>'style="display: <?=$status == 1 || $status == 4 ? 'block' : 'none'?>"
                            class="btn_verif_<?=$r['id']?> btn btn-sm btn-danger" title="Tolak" href="#modal_verif_dokumen_pendukung"
                            data-toggle="modal" onclick="modalVerifDokumen('<?=$r['random_string']?>', '<?=$r['id']?>')">
                                <i class="fa fa-times"></i>Tolak
                            </button>
                            
                            <button data-list_id='<?=json_encode($r['list_id'])?>' onclick="verifDokumen(4, '<?=$r['id']?>')" style="display: <?=$status == 1 || $status == 4 ? 'none' : 'block'?>" class="btn_verif_<?=$r['id']?> btn btn-sm btn-warning" title="Batal"><i class="fa fa-trash"></i></button>
                            <button disabled style="display: none;" id="btn_loading_<?=$r['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
                        </div>
                    </td>
                </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
    <div class="modal fade" id="modal_verif_dokumen_pendukung" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">TOLAK VERIFIKASI</h6>
                    <button id="btn_close_modal" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row" id="modal_verif_dokumen_pendukung_content">
                    <form id="form_verif_modal">
                        <div class="form-group col-lg-12">
                            <label style="font-weight: bold;">KETERANGAN</label>
                            <textarea name="" style="width: 100%;" id='modal_ket_verif' rows=5></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label style="font-weight: bold;">DATA YANG DAPAT DIUBAH</label>
                            <div class="row">
                                <input style="display: none;" id="id_modal_verif" value="" />
                                
                                <div class="col-lg-4 col-md-12 col-sm-12 col-checkbox">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="flag_fix_tanggal" id="flag_fix_tanggal" checked>
                                        <label class="form-check-label" for="flag_fix_tanggal">
                                            Periode
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-checkbox">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="flag_fix_jenis_disiplin" id="flag_fix_jenis_disiplin" checked>
                                        <label class="form-check-label" for="flag_fix_jenis_disiplin">
                                            Jenis Disiplin
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-checkbox">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="flag_fix_dokumen_upload" id="flag_fix_dokumen_upload" checked>
                                        <label class="form-check-label" for="flag_fix_dokumen_upload">
                                            Dokumen
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3 text-right">
                            <button type="submit" class="btn btn-navy btn-block"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-12 text-center">
        <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>
<script>
    $(function(){
        $('#count_pengajuan').html('<?=$count['pengajuan']?>')
        $('#count_diterima').html('<?=$count['diterima']?>')
        $('#count_ditolak').html('<?=$count['ditolak']?>')
        $('#count_batal').html('<?=$count['batal']?>')

        $('#table_disiplin_kerja_result_data').dataTable()
    })

    function modalVerifDokumen(random_string, id){
        $('#modal_ket_verif').html($('#ket_verif_'+id).val())
        $('#id_modal_verif').val(id)
    }

    $('#form_verif_modal').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/verifDokumen/")?>'+'/'+$('#id_modal_verif').val()+'/3',
            method: 'post',
            data: {
                list_id : $('.btn_verif_'+$('#id_modal_verif').val()).data('list_id'),
                keterangan: $('#modal_ket_verif').html(),
                flag_fix_tanggal: $('#flag_fix_tanggal').is(":checked"),
                flag_fix_jenis_disiplin: $('#flag_fix_jenis_disiplin').is(":checked"),
                flag_fix_dokumen_upload: $('#flag_fix_dokumen_upload').is(":checked")
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Data Berhasil Diverifikasi')
                    // openListData(active_status)
                    $('#count_pengajuan').html(rs.data.pengajuan)
                    $('#count_diterima').html(rs.data.diterima)
                    $('#count_ditolak').html(rs.data.ditolak)
                    $('#count_batal').html(rs.data.batal)
                    $('#tr_'+$('#id_modal_verif').val()).hide();
                    $(this).modal('hide')
                    $('#btn_close_modal').click()
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function verifDokumen(status, id){
        $('.btn_verif_'+id).hide()
        $('#btn_loading_'+id).show()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/verifDokumen/")?>'+'/'+id+'/'+status,
            method: 'post',
            data: {
                list_id : $('.btn_verif_'+id).data('list_id'),
                keterangan: $('#ket_verif_'+id).val(),
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    // successtoast('Data Berhasil Diverifikasi')
                    // openListData(active_status)
                    $('#count_pengajuan').html(rs.data.pengajuan)
                    $('#count_diterima').html(rs.data.diterima)
                    $('#count_ditolak').html(rs.data.ditolak)
                    $('#count_batal').html(rs.data.batal)
                    $('#tr_'+id).hide();
                } else {
                    errortoast(rs.message)
                }
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
            }, error: function(e){
                $('.btn_verif_'+id).show()
                $('#btn_loading_'+id).hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>