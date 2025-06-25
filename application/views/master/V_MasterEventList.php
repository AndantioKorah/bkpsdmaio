<div class="col-lg-12 table-responsive">
    <table class="table table-hover" id="table_list_event">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Judul</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Absen Masuk</th>
            <th class="text-center">Absen Pulang</th>
            <th class="text-center">Radius</th>
            <th class="text-center">Surat Tugas</th>
            <th class="text-center">Pilihan</th>
        </thead>
        <tbody>
            <?php $no = 1; if($result){ foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++;?></td>
                    <td class="text-left"><?=$rs['judul']?></td>
                    <td class="text-center"><?=formatDateNamaBulan($rs['tgl'])?></td>
                    <td class="text-center"><?=formatTimeAbsen($rs['buka_masuk'])?></td>
                    <td class="text-center"><?=formatTimeAbsen($rs['buka_pulang'])?></td>
                    <td class="text-center"><?=($rs['radius'])?></td>
                    <td class="text-center"><?=($rs['flag_surat_tugas'] == 1 ? "Ya" : "Tidak")?></td>
                    <td class="text-center">
                        <button onclick="openModalEdit('<?=$rs['id']?>')" id="btn_edit_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                        <button onclick="deleteEvent('<?=$rs['id']?>')" id="btn_delete_<?=$rs['id']?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modal_edit_event" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT DATA EVENT</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_edit_event_content">
          </div>
      </div>
  </div>
</div>
<script>
    $(function(){
        $('#table_list_event').dataTable()
    })

    function deleteEvent(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            $.ajax({
                url: '<?=base_url("master/C_Master/deleteDataEvent/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    let resp = JSON.parse(data)
                    if(resp.code == 1){
                        errortoast(resp.message)
                    } else {
                        successtoast('Data Event Berhasil Dihapus')
                        loadListEvent()
                    }
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }

    function openModalEdit(id){
        $('#modal_edit_event').modal('show')    
        $('#modal_edit_event_content').html('')    
        $('#modal_edit_event_content').append(divLoaderNavy)    
        $('#modal_edit_event_content').load('<?=base_url("master/C_Master/editDataEvent/")?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>