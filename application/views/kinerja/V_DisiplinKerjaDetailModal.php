<?php if($result){ ?>
    <div class="modal-header">
        <h5>Detail Disiplin Kerja</h5><br>
        <h6><?=getNamaPegawaiFull($result[0])?></h6>
    </div>
    <div class="modal-body">
        <table class="table table-hover" id="table_modal_detail">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-left">Keterangan</th>
                <th class="text-center">Dokumen Pendukung</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $rs){ 
                    $tanggal = $rs['tanggal'] < 10 ? '0'.$rs['tanggal'] : $rs['tanggal'];
                    $bulan = $rs['bulan'] < 10 ? '0'.$rs['bulan'] : $rs['bulan'];
                ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-center"><?=$tanggal.'/'.$bulan.'/'.$rs['tahun']?></td>
                        <td class="text-left"><?=$rs['keterangan']?></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-navy btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Lihat Dokumen
                                </button>
                                <div class="dropdown-menu">
                                    <?php if($rs['dokumen_pendukung']) { $dokpen = json_decode($rs['dokumen_pendukung']); $nodok = 1;
                                        foreach($dokpen as $dk){  ?>
                                        <a class="dropdown-item" target="_blank" href="<?=base_url(DOKUMEN_PENDUKUNG_DISIPLIN_KERJA.'/'.$dk)?>">Dokumen <?=$nodok++;?></a>
                                    <?php } } ?>
                                </div>
                            </div>
                            <!-- <button class="btn btn-sm btn-navy">Lihat Dokumen <i class='fa fa-arrow-down'></i></button> -->
                        </td>
                        <td class="text-center">
                            <button onclick="deleteDataDisiplinKerja('<?=$rs['id']?>')" type="button" id="btn_delete_detail_<?=$rs['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            <button type="button" disabled style="display: none;" id="btn_loading_detail_<?=$rs['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('#table_modal_detail').dataTable()
        })

        function deleteDataDisiplinKerja(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $('#btn_delete_detail_'+id).hide()
                $('#btn_loading_detail_'+id).show()
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deleteDataDisiplinKerja")?>'+'/'+id,
                    method: 'post',
                    data: null,
                    success: function(data){
                        successtoast('Berhasil Menghapus Data Disiplin Kerja')
                        // $('#form_search_disiplin_kerja').submit()
                        openDetailModalDataDisiplinKerja('<?=$result[0]['id_m_user']?>')
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="row col-12 text-center">
        <h6>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h6>
    </div>
<?php } ?>