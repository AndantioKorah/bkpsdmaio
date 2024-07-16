<?php if($list_master_bidang){ ?>
    <div class="col-12">
        <table class="table table-hover table-striped" id="table_master_bidang">
            <thead>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 40%;" class="text-left">Bidang/Bagian</th>
                <th style="width: 40%;" class="text-left">Unor SIASN</th>
                <th style="width: 15%;" class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no=1; foreach($list_master_bidang as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['nama_bidang']?></td>
                        <td class="text-left"><label id="label_unor_siasn_<?=$lp['id']?>"><?=$lp['nama_unor']?></label></td>
                        <td class="text-center">
                            <button href="#modal_edit_unor" data-toggle="modal" onclick="editUnorBidang('<?=$lp['id']?>')"
                            class="btn btn-sm btn-navy">
                                Edit
                            </button>
                            <button onclick="deleteMappingBidang('<?=$lp['id']?>')" class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function(){
            $('#table_master_bidang').DataTable({
                responsive: false
            });
        })

        function editUnorBidang(id){
            $('#modal_edit_unor_content').html('')
            $('#modal_edit_unor_content').append(divLoaderNavy)
            $('#modal_edit_unor_content').load('<?=base_url("master/C_Master/editUnorBidang/")?>'+id, function(){
                $('#loader').hide()
            })
        }

        function deleteMappingBidang(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteMappingBidang/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        $('#label_unor_siasn_'+id).html('')
                        loadBidangForMappingUnor()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>