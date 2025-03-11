<style>
  .tr_verif_done{
    display: none;
  }
</style>

<div class="text-right">
  <div style="cursor: pointer;" class="form-check float-right text-right mb-5">
    <input style="cursor: pointer; width: 25px; height: 25px;" class="form-check-input" type="checkbox" value="" id="checkTampilSemua">
    <label style="cursor: pointer; padding: 5px; font-size: 1rem;" class="form-check-label" for="checkTampilSemua">
      Tampilkan Semua
    </label>
  </div>
</div>

<table style="border: 1px solid grey; width: 100%;" class="table table-hover table-striped table_riwayat_verif_cuti">
  <thead>
    <th style="border: 1px solid grey;" class="text-center">No</th>
    <th style="border: 1px solid grey;" class="text-left">Pegawai</th>
    <?php if(isset($param['id_unitkerja']) && $param['id_unitkerja'] == "0"){ ?>
      <th style="border: 1px solid grey;" class="text-center">Unit Kerja</th>
    <?php } ?>
    <th style="border: 1px solid grey;" class="text-center">Tanggal Pengajuan</th>
    <th style="border: 1px solid grey;" class="text-center">Status</th>
    <th style="border: 1px solid grey;" class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($result){
      $no = 1;
      foreach($result as $rs){
        $badge = "badge-warning";
        $statusVerifikasi = "Belum Verifikasi";
        if($rs['status_verifikasi'] == 1){
          $badge = "badge-success";
          $statusVerifikasi = "Disetujui";
        } else if($rs['status_verifikasi'] == 2){
          $badge = "badge-danger";
          $statusVerifikasi = "Ditolak, ".$rs['keterangan'];
        }
        $dt = json_decode($rs['meta_data'], true);
    ?>
      <tr class="<?=$rs['status_verifikasi'] != 0 ? 'tr_verif_done' : ''?>">
        <td style="border: 1px solid grey;" class="text-center"><?=$no++;?></td>
        <td style="border: 1px solid grey;" class="text-left">
          <span class="fw-bold"><?=getNamaPegawaiFull($rs)?></span><br>
          <span style="font-size: .7rem; font-weight: bold;"><?=$rs['nama_jabatan']?></span><br>
          <span style="font-size: .7rem; font-weight: bold;">NIP. <?=$rs['nipbaru_ws']?></span>
        </td>
        <?php if(isset($param['id_unitkerja']) && $param['id_unitkerja'] == "0"){ ?>
          <td style="border: 1px solid grey;" class="text-left"><?=($rs['nm_unitkerja'])?></td>
        <?php } ?>
        <td style="border: 1px solid grey;" class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td style="border: 1px solid grey;" class="text-center">
          <span class="badge <?=$badge?>"><?=$statusVerifikasi?></span>
        </td>

        <td style="border: 1px solid grey;" class="text-center">
          <button type="button" href="#modal_detail_cuti"
            onclick="loadDetailCutiVerifOperator('<?=$rs['id']?>')" class="btn btn-navy">Detail</button>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>

<script>
  $(function(){
    $('.table_riwayat_verif_cuti').dataTable()
  })

  function loadDetailCutiVerifOperator(id){
    $('#modal_detail_cuti').modal('show')
    $('#modal_detail_cuti_content').html('')
    $('#modal_detail_cuti_content').append(divLoaderNavy)
    $('#modal_detail_cuti_content').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCutiVerifOperator/')?>'+id, function(){
      $('#loader').hide()
    })
  }

  $('#checkTampilSemua').on('change', function(){
    if($(this).is(':checked')){
      $('.tr_verif_done').show()
    } else {
      $('.tr_verif_done').hide()
    }
  })
</script>