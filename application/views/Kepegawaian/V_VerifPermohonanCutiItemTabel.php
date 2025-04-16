<table style="border: 1px solid grey; width: 100%;" class="table table-hover table-striped table_riwayat_verif_cuti">
  <thead>
    <th style="border: 1px solid grey;" class="text-center">No</th>
    <th style="border: 1px solid grey;" class="text-left">Pegawai</th>
    <?php if(isset($param['id_unitkerja']) && $param['id_unitkerja'] == "0"){ ?>
      <th style="border: 1px solid grey;" class="text-center">Unit Kerja</th>
    <?php } ?>
    <th style="border: 1px solid grey;" class="text-center">Jenis Cuti</th>
    <th style="border: 1px solid grey;" class="text-center">Tanggal Pengajuan</th>
    <th style="border: 1px solid grey;" class="text-center">Tanggal Cuti</th>
    <th style="border: 1px solid grey;" class="text-center">Lama Cuti</th>
    <th style="border: 1px solid grey;" class="text-center">Status</th>
    <th style="border: 1px solid grey;" class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($item){
      $no = 1;
      foreach($item as $rs){
    ?>
      <tr>
        <td style="border: 1px solid grey;" class="text-center"><?=$no++;?></td>
        <td style="border: 1px solid grey;" class="text-left">
          <span class="fw-bold"><?=getNamaPegawaiFull($rs)?></span><br>
          <span style="font-size: .7rem; font-weight: bold;">NIP. <?=$rs['nipbaru_ws']?></span>
        </td>
        <?php if(isset($param['id_unitkerja']) && $param['id_unitkerja'] == "0"){ ?>
          <td style="border: 1px solid grey;" class="text-left"><?=($rs['nm_unitkerja'])?></td>
        <?php } ?>
        <td style="border: 1px solid grey;" class="text-center"><?=($rs['nm_cuti'])?></td>
        <td style="border: 1px solid grey;" class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td style="border: 1px solid grey;" class="text-center"><?=formatDateNamaBulan($rs['tanggal_mulai']).' - '.formatDateNamaBulan($rs['tanggal_akhir'])?></td>
        <td style="border: 1px solid grey;" class="text-center"><?=$rs['lama_cuti'].' hari'?></td>
        <td style="border: 1px solid grey;" class="text-center">
          <?php
            $badge = "badge-warning";
            if(stringStartWith("Digital Signature", $rs['status_pengajuan_cuti'])){
              if($rs['flag_ds_cuti'] == 1){
                $badge = "badge-success";
                $rs['status_pengajuan_cuti'] = "Selesai";
              } else {
                $rs['status_pengajuan_cuti'] = "Menunggu ".$rs['status_pengajuan_cuti'];
              }
            } else if(isset($rs['flag_ditolak']) && $rs['flag_ditolak'] == 1){
              $badge = "badge-danger";
            }
          ?>
          <span style="max-width: 25vw; text-wrap: pretty;" class="badge <?=$badge?>"><?=($rs['status_pengajuan_cuti'])?></span>
        </td>
        <td style="border: 1px solid grey;" class="text-center">
          <!-- <button type="button" href="#modal_detail_cuti" onclick="loadDetailCutiVerif('<?=$rs['id']?>')"
          data-toggle="modal" class="btn btn-navy">Detail</button> -->
          <button type="button"onclick="loadDetailCutiVerif('<?=$rs['id']?>')" class="btn btn-navy">Detail</button>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>

<script>
  $(function(){
    $('.table_riwayat_verif_cuti').dataTable()
  })
</script>