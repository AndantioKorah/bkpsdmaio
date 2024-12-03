<div class="card-body table-responsive">
<table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-center">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th class="text-left">Keterangan</th>
          <?php if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_pangkat')) { ?>
            <th class="text-center">Upload SK</th>
          <?php }?>
          <th></th>
          
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="text-left">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"> <?=getNamaPegawaiFull($rs);?><br>
               <span>NIP. <?=$rs['nipbaru_ws']?></span> </td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tanggal_pengajuan'])?></td>
              <td class="text-left">
              <span class="badge badge-<?php if($rs['status_pengajuan'] == '1') echo "success"; else if($rs['status_pengajuan'] == '2') echo "danger"; else echo "primary";?>"><?php if($rs['status_pengajuan'] == '1') echo "Diterima"; else if($rs['status_pengajuan'] == '2') echo "Ditolak"; else echo "Menunggu Verifikasi BKPSDM";?>
              </span>
            </td>
            <td class="text-left"><?=$rs['keterangan']?></td>
           
          <?php if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_pangkat')) { ?>
            <td class="text-center">
            <?php if($rs['status_layanan'] == 1) { ?>
            <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_pengajuan']?>"
                href="#modal_upload_sk"
                onclick="loadModalUploadSK('<?=$rs['id_pengajuan']?>','<?=$rs['id_m_layanan']?>')" title="Ubah Data" class="btn btn-sm btn-primary"> 
                <i class="fa fa-upload" aria-hidden="true"></i></button>
                <?php } ?>
              </td>
            <?php }?>
             <td>
             <a href="<?= base_url();?>kepegawaian/verifikasi-layanan-detail/<?=$rs['id_pengajuan']?>/<?=$rs['id_m_layanan']?>">
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

<!-- Modal -->
<div class="modal fade" id="modal_upload_sk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        ...
      </div>
     
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


  function loadModalUploadSK(id,id_m_layanan){
  $('#modal_body').html('')
  $('#modal_body').append(divLoaderNavy)
  $('#modal_body').load('<?=base_url("kepegawaian/C_Kepegawaian/loadModalUploadSK")?>'+'/'+id+'/'+id_m_layanan, function(){
    $('#loader').hide()
  })
  }

  
</script>