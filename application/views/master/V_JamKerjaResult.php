<?php if($result){ ?>
    <table class="table table-hover" id="table_jam_kerja" style="font-size: .8rem !important;">
        <thead>
            <tr>
                <th colspan=1 rowspan=2 class="text-center">No</th>
                <th colspan=1 rowspan=2 class="text-center">Jenis SKPD</th>
                <th colspan=1 rowspan=2 class="text-left">Nama Jam Kerja</th>
                <th colspan=2 rowspan=1 class="text-center">Jam Kerja</th>
                <th colspan=1 rowspan=2 class="text-center">Tgl. Berlaku</th>
                <th colspan=1 rowspan=2 class="text-center">Tipe</th>
                <th colspan=1 rowspan=2 class="text-center">Pilihan</th>
            </tr>
            <tr>
                <th colspan=1 rowspan=1 class="text-center">Senin - Kamis</th>
                <th colspan=1 rowspan=1 class="text-center">Jumat</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-center"><?=$rs['jenis_skpd']?></td>
                    <td class="text-left"><?=$rs['nama_jam_kerja']?></td>
                    <td class="text-center"><?=$rs['wfo_masuk'].' - '.$rs['wfo_pulang']?></td>
                    <td class="text-center"><?=$rs['wfoj_masuk'].' - '.$rs['wfoj_pulang']?></td>
                    <?php
                        $tanggal_berlaku = $rs['berlaku_dari'];
                        if($rs['berlaku_dari'] == null || $rs['berlaku_dari'] == "0000:00:00"){
                            $tanggal_berlaku = '<span style="font-weight: bold;">Sekarang</span>';
                        } else {
                            $tanggal_berlaku = formatDateNamaBulan($tanggal_berlaku);
                            if($rs['berlaku_sampai'] == null){
                                $tanggal_berlaku = $tanggal_berlaku.' s/d <span style="font-weight: bold;">Sekarang</span>';
                            } else if($rs['berlaku_sampai'] == '0000-00-00'){
                                $tanggal_berlaku = $tanggal_berlaku.' s/d <span style="font-weight: bold;">Sekarang</span>';
                            } else {
                                $tanggal_berlaku = $tanggal_berlaku.' s/d '.formatDateNamaBulan($rs['berlaku_sampai']);
                            }
                        }
                    ?>
                    <td class="text-center"><?=$tanggal_berlaku?></td>
                    <?php
                        $tipe = 'Sekarang';
                        if($rs['flag_event'] == 1){
                            $tipe = 'Sementara';
                        } else if($rs['flag_event'] == 2){
                            $tipe = 'Lama';
                        }
                    ?>
                    <td class="text-left"><?=$tipe?></td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button title="Edit" href="#edit_modal" data-toggle="modal"
                                onclick="editJamKerja('<?=$rs['id']?>')"
                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            <button title="Hapus" onclick="deleteJamKerja('<?=$rs['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content" id="edit_modal_content">
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#table_jam_kerja').dataTable()
        })

        function editJamKerja(id){
            $('#edit_modal_content').html('')
            $('#edit_modal_content').append(divLoaderNavy)
            $('#edit_modal_content').load('<?=base_url("master/C_Master/editJamKerja/")?>'+id, function(){
                $('#loader').hide()
            })
        }

        function deleteJamKerja(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteJamKerja")?>'+'/'+id,
                    method: 'post',
                    data: {},
                    success: function(){
                        successtoast('Berhasil')
                        loadJamKerja()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="col-12 text-center">
        <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>