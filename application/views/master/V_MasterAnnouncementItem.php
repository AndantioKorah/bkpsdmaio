<?php if($list_announcement){ ?>
<style>
    .zoom:hover {
        transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        cursor: pointer;
    }
</style>
    <div class="col-12">
        <table class="table table-hover" id="table_announcement">
            <thead>
                <th class="text-center">No</th>
                <th class="text-left">Nama Anouncement</th>
                <th class="text-center">Gambar</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php $no=1; foreach($list_announcement as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['nama_announcement']?></td>
                        <td class="text-center"> 
                            <img onclick="loadAnnouncement('<?=$lp['id']?>')" data-toggle="modal" data-target="#exampleModal" style="height: 100px; width: 100px" src="<?=base_url();?><?=$lp['url_file']?>" alt="">
                        </td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button onclick="deleteAnnouncement('<?=$lp['id']?>')" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                </div>
                                <div class="col-lg-6">
                                    <button id="btn_hide_<?=$lp['id']?>" onclick="showAnnouncement('<?=$lp['id']?>', 'hide')" style="display: <?=$lp['flag_show'] == 0 ? 'none' : 'block'?>"
                                    class="btn btn-secondary"><i class="fa fa-eye-slash"></i> Hide</button>

                                    <button id="btn_show_<?=$lp['id']?>" onclick="showAnnouncement('<?=$lp['id']?>', 'show')" style="display: <?=$lp['flag_show'] == 1 ? 'none' : 'block'?>"
                                    class="btn btn-success"><i class="fa fa-eye"></i> Show</button>

                                    <button id="btn_loading_show_<?=$lp['id']?>" style="display: none;" disabled class="btn btn-warning"><i class="fa fa-spin fa-spinner"></i> Loading....</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="col-lg-12 float-right text-right">
    <button type="button" class="btn-close btn-close-modal-announcement btn-light" style="width: 50px; height: 50px; background-color: white;" data-dismiss="modal"><i class="fa fa-3x fa-times"></i></button>
  </div>
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div id="modal-announcement-content">
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

        function loadAnnouncement(id){
            $('#modal-announcement-content').html('')
            $('#modal-announcement-content').append(divLoaderNavy)
            $('#modal-announcement-content').load('<?=base_url('master/C_Master/loadAnnouncement/')?>'+id)
        }

        function deleteAnnouncement(id){
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("master/C_Master/deleteAnnouncement/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListAnouncement()
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }
        
        function showAnnouncement(id, status){
            $('#btn_hide_'+id).hide()
            $('#btn_show_'+id).hide()
            $('#btn_loading_show_'+id).show()
            $.ajax({
                url: '<?=base_url("master/C_Master/toggleShowAnnouncement/")?>'+id,
                method: 'post',
                data: null,
                success: function(){
                    successtoast('Data berhasil disimpan')
                    $('#btn_loading_show_'+id).hide()
                    if(status == 'hide'){
                        $('#btn_show_'+id).show()
                    } else {
                        $('#btn_hide_'+id).show()
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
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