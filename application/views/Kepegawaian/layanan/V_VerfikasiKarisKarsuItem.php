<div class="card-body table-responsive">
<table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-left">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th></th>
          
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="text-left">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['gelar1']?> <?=$rs['nama']?> <?=$rs['gelar2']?><br>
               <span>NIP. <?=$rs['nipbaru']?></span> </td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="text-left"><?=$rs['created_date']?></td>
              <td class="text-left">
              <span class="badge badge-<?php if($rs['status_pengajuan'] == '1') echo "success"; else if($rs['status_pengajuan'] == '2') echo "danger"; else echo "primary";?>"><?php if($rs['status_pengajuan'] == '1') echo "Diterima"; else if($rs['status_pengajuan'] == '2') echo "Ditolak"; else echo "Menunggu Verifikasi BKPSDM";?>
              </span>
            </td>
             <td>
             <a href="<?= base_url();?>kepegawaian/verifikasi-detail/<?=$rs['id_pengajuan']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a>
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