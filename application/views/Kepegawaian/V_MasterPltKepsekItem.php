<?php if($list_pltkepsek){ ?>
<style>
    /* .zoom:hover {
    transform: scale(1.2); 
} */
</style>
    <div class="col-12 table-responsive">
        <table class="table table-hover" id="table_announcement">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Pegawai</th>
                <th class="text-center">Sekolah Definitif</th>
                <th class="text-center">Sekolah PLT</th>
                <th class="text-center">Tanggal Mulai</th>
                <th class="text-center">Tanggal Akhir</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no=1; foreach($list_pltkepsek as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?= getNamaPegawaiFull($lp)?></td>
                        <td class="text-left"><?=$lp['sekolah_def']?></td>
                        <td class="text-left"><?=$lp['sekolah_plt']?></td>
                        <td class="text-left"><?= formatDateNamaBulan($lp['tanggal_mulai'])?></td>
                        <td class="text-left"><?= formatDateNamaBulan($lp['tanggal_akhir'])?></td>
                        <td class="text-center">
                            <!-- <button onclick="editPltPlh('<?=$lp['id_plt']?>')" href="#modal_edit" data-toggle="modal" 
                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</button> -->
                            <button onclick="deletePltPlh('<?=$lp['id_plt']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div id="modal-dialog" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">EDIT DATA PLT PLH</h2>
                    <button type="button" class="close" id="btn_modal_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_edit_content">
                </div>
            </div>
        </div>
    </div>

    <script>

$(document).ready( function () {

} );

        $(function(){
            // $('#table_announcement').DataTable({
            //     responsive: false
            // });
            var table = $('#table_announcement').DataTable({
                columnDefs: [
                {
                    targets: 2,
                    className: 'zoom'
                }
                ]
            });
        })  

       

        function deletePltPlh(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("kepegawaian/C_Kepegawaian/deletePltKepsek/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListPltPlh()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }

        function editPltPlh(id){
            $('#modal_edit_content').html('')
            $('#modal_edit_content').append(divLoaderNavy)
            $('#modal_edit_content').load('<?=base_url('kepegawaian/C_Kepegawaian/loadEditPltPlh/')?>'+id, function(){
                $('#loader').hide()
            })
        }

    </script>
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>