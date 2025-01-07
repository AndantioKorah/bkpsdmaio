<div class="row">
  <div class="col-lg-12 table-responsive">
    <table class="table table-hover table-striped">
      <thead>
        <th class="text-center">No</th>
        <th class="text-center">Pegawai</th>
        <th class="text-center">Tanggal Cuti</th>
        <th class="text-center">Tanggal Usul</th>
        <th class="text-center">Status</th>
        <th class="text-center">Pilihan</th>
      </thead>
      <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
          <tr>
            <td class="text-center"><?=$no++;?></td>
            <td class="text-left">
              <span><?=getNamaPegawaiFull($rs)?></span><br>
              <span style="color: grey; font-weight: bold; font-size: .75rem;">NIP. <?=$rs['nipbaru_ws']?></span>
            </td>
            <td class="text-center">
              <?php 
                $tanggal_cuti_raw = formatDateNamaBulan($rs['tanggal_mulai']);
                if($rs['tanggal_mulai'] != $rs['tanggal_akhir']){
                  $tanggal_cuti_raw = $tanggal_cuti_raw.' - '.formatDateNamaBulan($rs['tanggal_akhir']);
                }
              ?>
              <?=$tanggal_cuti_raw?>
            </td>
            <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
            <td class="text-center"><?=$rs['status_pengajuan_cuti']?></td>
            <td class="text-center">
              <button href="#modal_nomor_surat_manual" data-toggle="modal" class="btn btn-sm btn-warning"
              onclick="openModalPenomoranSkCuti('<?=$rs['id']?>')">
              <i class="fa fa-edit"></i> Edit</button>
            </td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="modal_nomor_surat_manual" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">INPUT NOMOR SURAT SK CUTI</h6>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_nomor_surat_manual_content">
          </div>
      </div>
  </div>
</div>

<script>
  function openModalPenomoranSkCuti(id){
      $('#modal_nomor_surat_manual_content').html('')
      $('#modal_nomor_surat_manual_content').append(divLoaderNavy)
      $('#modal_nomor_surat_manual_content').load('<?=base_url('kepegawaian/C_Kepegawaian/openModalPenomoranSkCuti/')?>'+id, function(){
        $('#loader').hide()
      })
    }
</script>