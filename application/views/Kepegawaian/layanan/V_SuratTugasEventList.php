<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-hover" id="tabel_list_event">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Event</th>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Inputer</th>
                <th class="text-center">Tanggal Input</th>
                <th class="text-center">File ST</th>
                <th class="text-center">Pilihan</th>
            </thead>
            <tbody>
                <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$rs['judul']."<br>".formatDateNamaBulan($rs['tgl'])?></td>
                        <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                        <td class="text-left"><?=($rs['inputer'])?></td>
                        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
                        <td class="text-center">
                            <a target="_blank" href="<?=base_url($rs['url_file'])?>" class="btn btn-sm btn-outline-danger"><i class="fa fa-file"></i></a>
                        </td>
                        <td class="text-left">
                            <button onclick="editData('<?=$rs['id']?>')" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                            <button id="btn_delete_<?=$rs['id']?>" onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_edit_st" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT SURAT TUGAS</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_edit_st_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        $('#tabel_list_event').dataTable()
    })

    function editData(id){
        $('#modal_edit_st').modal('show')
        $('#modal_edit_st_content').html('')
        $('#modal_edit_st_content').append(divLoaderNavy)
        $('#modal_edit_st_content').load('<?=base_url('kepegawaian/C_Layanan/loadDetailSuratTugasEvent/')?>'+id, function(){
            $('#loader').hide()
        })
        
    }

    function deleteData(id){
        if(confirm('Apakah Anda yakin ingin menghapus data?')){
            btnLoader('btn_delete_'+id)
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Layanan/deleteSuratTugasEvent/")?>'+id,
                method: 'post',
                data: null,
                success: function(data){
                    btnLoader('btn_delete_'+id)
                    loadListSuratTugas()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        }
    }
</script>