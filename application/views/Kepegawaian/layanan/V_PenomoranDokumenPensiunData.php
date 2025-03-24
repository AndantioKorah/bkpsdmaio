<style>
  .tr_selesai{
    display: none;
  }
</style>

<div class="row">
  <div class="col-lg-12 table-responsive">
    <div style="cursor: pointer;" class="form-check float-right text-right mb-5">
      <input style="cursor: pointer; width: 25px; height: 25px;" class="form-check-input" type="checkbox" value="" id="checkTampilSemua">
      <label style="cursor: pointer; padding: 5px; font-size: 1rem;" class="form-check-label" for="checkTampilSemua">
        Tampilkan Semua
      </label>
    </div>
    <table class="table table-hover table-striped" id="table_res">
      <thead>
        <th class="text-center">No</th>
        <th class="text-center">Pegawai</th>
        <th class="text-center">Nama Dokumen</th>
        <th class="text-center">Tanggal Usul</th>
        <th class="text-center">Status</th>
        <th class="text-center">Pilihan</th>
      </thead>
      <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){
          $status = "";
          $class = "badge badge-danger";
          $classSelesai = "";

          if($rs['nomor_surat'] == null && $rs['id_m_jenis_layanan'] != 104){
            $status = "Nomor Surat belum diinput";
          } else {
            if($rs[$rs['nama_kolom_ds']] == 0){
              $class = "badge badge-warning";
              $status = "File DS belum diupload";
            } else {
              $status = "File DS sudah diupload";
              $class = "badge badge-success";
              $classSelesai = "tr_selesai";
            }
          }  
        ?>
          <tr class="<?=$classSelesai?>">
            <td class="text-center"><?=$rs['id'].' '.$no++;?></td>
            <td class="text-left">
              <span style="font-weight: bold; font-size: .9rem;"><?=getNamaPegawaiFull($rs)?></span><br>
              <span style="color: grey; font-weight: bold; font-size: .75rem;">NIP. <?=$rs['nipbaru_ws']?></span>
            </td>
            <td class="text-center"><?=$rs['nama_layanan'].' / '.$rs['keterangan']?></td>
            <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
            <td class="text-center">
              <span class="<?=$class?>"><?=$status?></span>
            </td>
            <td class="text-center">
              <button href="#modal_nomor_surat_manual" data-toggle="modal" class="btn btn-sm btn-warning"
              onclick="openModalPenomoranDokumenPensiun('<?=$rs['id_t_usul_ds']?>')">
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
              <h6 class="modal-title">INPUT NOMOR SURAT DOKUMEN PENSIUN</h6>
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
  $(function(){
    $('#table_res').dataTable()
  })

  function openModalPenomoranDokumenPensiun(id){
    $('#modal_nomor_surat_manual_content').html('')
    $('#modal_nomor_surat_manual_content').append(divLoaderNavy)
    $('#modal_nomor_surat_manual_content').load('<?=base_url('kepegawaian/C_Layanan/openModalPenomoranDokumenPensiun/')?>'+id, function(){
      $('#loader').hide()
    })
  }

  $('#checkTampilSemua').on('change', function(){
  if($(this).is(':checked')){
    $('.tr_selesai').show()
  } else {
    $('.tr_selesai').hide()
  }
})
</script>