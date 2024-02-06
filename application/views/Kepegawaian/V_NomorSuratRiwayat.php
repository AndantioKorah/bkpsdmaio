<div class="col-lg-12 table-responsive">
  <table class="table table-striped table-hover" id="table_riwayat_surat">
    <thead>
      <th class="text-center">No</th>
      <th class="text-left">Perihal</th>
      <th class="text-left">Nomor Surat</th>
      <th class="text-center">Tanggal</th>
      <th class="text-left">Dibuat Oleh</th>
      <th class="text-center">Dibuat Pada</th>
      <!-- <th class="text-center">Pilihan</th> -->
    </thead>
    <tbody>
      <?php if($result){ $no = 1; foreach($result as $rs){ ?>
        <tr>
          <td class="text-center"><?=$no++;?></td>
          <td class="text-left"><?=$rs['perihal']?></td>
          <td class="text-left"><?=$rs['nomor_surat']?></td>
          <td class="text-center"><?=formatDateNamaBulan($rs['tanggal_surat'])?></td>
          <td class="text-left"><?=getNamaPegawaiFull($rs)?></td>
          <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
          <!-- <th class="text-center">Pilihan</th> -->
        </tr>
      <?php } } ?>
    </tbody>
  </table>
</div>
<script>
  $(function(){
    $('#table_riwayat_surat').dataTable()
  })
</script>