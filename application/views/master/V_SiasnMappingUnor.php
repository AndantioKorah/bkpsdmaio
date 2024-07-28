<div class="row">
    <div class="col-lg-12">
        <div class="card p-3 card-default">
            <div class="card-title"><h4>MAPPING UNOR SIASN</h4></div>
            <div class="card-body">
                <table style="width: 100%;" id="table_mapping_unor" class="table table-hover table-striped">
                    <thead>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 40%;" class="text-center">Unit Kerja Siladen</th>
                        <th style="width: 40%;" class="text-center">UNOR SIASN</th>
                        <th style="width: 15%;" class="text-center">Pilihan</th>
                    </thead>
                    <?php if($result){ ?>
                        <tbody>
                            <?php $no = 1; foreach($result as $rs){ ?>
                                <tr>
                                    <td class="text-center"><?=$no++;?></td>
                                    <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                                    <td class="text-left"><label id="id_label_unor_<?=$rs['id_unitkerja']?>"><?=$rs['nama_unor']?></label></td>
                                    <td class="text-center">
                                        <button href="#modal_edit_unor" data-toggle="modal" onclick="editUnorSiasn('<?=$rs['id_unitkerja']?>')"
                                        class="btn btn-sm btn-navy">
                                            Edit
                                        </button>
                                        <button onclick="deleteUnorSiasn('<?=$rs['id_unitkerja']?>')"
                                        class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?> 
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_edit_unor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">EDIT UNOR SIASN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_edit_unor_content">
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#table_mapping_unor').dataTable()
    })

    function deleteUnorSiasn(id){
        if(confirm('Apakah Anda yakin ingin menghapus data tersebut?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteMappingUnor/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    $('#id_label_unor_'+id).html('')
                    successtoast('Hapus Unor Berhasil')
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    function editUnorSiasn(id){
        $('#modal_edit_unor_content').html('')
        $('#modal_edit_unor_content').append(divLoaderNavy)
        $('#modal_edit_unor_content').load('<?=base_url("master/C_Master/editMappingUnor/")?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>