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
            <td class="text-center"><?=formatDateNamaBulan($rs['created_date'])?></td>
            <td class="text-center"><?=$rs['status_pengajuan_cuti']?></td>
            <td class="text-center"></td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>