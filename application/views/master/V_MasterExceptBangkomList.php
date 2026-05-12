<?php if($result){ ?>
    <div class="p-3">
        <div class="row">
            <div class="col-lg-12">
                <table id="data_table_except_bangkom" class="table table-sm table-hover table-striped">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">Unit Kerja</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Flag Terima Semua</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Pilihan</th>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($result as $rs){ ?>
                            <tr>
                                <td class="text-center"><?=$no++;?></td>
                                <td class="text-left"><?=$rs['id_unitkerja'] != 0 ? $rs['nm_unitkerja'] : "Semua"?></td>
                                <td class="text-center"><?=$rs['bulan'] != "0" ? getNamaBulan($rs['bulan'])." ".$rs['tahun'] : "Semua"?></td>
                                <td class="text-center">
                                    <input onclick="changeFlagTerimaSemua('<?=$rs['id']?>')" class="form-check-input" type="checkbox"
                                    style="
                                        width: 20px;
                                        height: 20px;
                                        cursor: pointer;
                                    "
                                    value="" id="checkTerimaSemua_<?=$rs['id']?>" <?=$rs['flag_terima_tpp_semua'] == 1 ? "checked" : ""?>/>
                                </td>
                                <td class="text-left"><?=$rs['keterangan']?></td>
                                <td class="text-center">
                                    <button onclick="deleteExceptBangkom('<?=$rs['id']?>')" type="button" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#data_table_except_bangkom').dataTable()
        })

        function deleteExceptBangkom(id){
            if(confirm("Apakah Anda yakin?")){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteExceptBangkom/")?>'+id,
                    method: 'post',
                    success: function(data){
                        loadListExceptBangkom()
                        successtoast('Data berhasil dihapus')
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }

        function changeFlagTerimaSemua(id){
            let state = 0
            if($('#checkTerimaSemua_'+id).is(':checked')){
                state = 1
            }
            $.ajax({
                url: '<?=base_url("master/C_Master/changeFlagTerimaSemua/")?>'+id+'/'+state,
                method: 'post',
                success: function(data){
                    successtoast('Data berhasil diganti')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    </script>
<?php } ?>