<div class="card-body table-responsive">
<table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th></th>
          
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status_pengajuan'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['tanggal_pengajuan']?></td>
              <td class="text-left"><?=($rs['status_pengajuan'] == '1' ? 'Sudah diverifikasi BKPSDM' : 'Menunggu Verifikasi BKPSDM');?></td>
             <td>
              <button onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
             </td>
              
            </tr>
          <?php } ?>
        </tbody>
      </table>
</div>
<div class="modal fade" id="modal_detail_cuti" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content" id="content_modal_detail_cuti">
		</div>
	</div>
</div>
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function loadDetailCutiVerif(id){
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    $('#result_search').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCutiVerif/')?>'+id, function(){
      $('#loader').hide()
    })
  }
</script>