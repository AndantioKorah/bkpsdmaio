<table class="table table-hover table-striped table_lock_tpp" border=1 style="border-collapse: collapse;">
  <thead>
    <th class="text-center">No</th>
    <th class="text-center">Perangkat Daerah</th>
    <th class="text-center">Periode</th>
    <th class="text-center">Tanggal Rekap</th>
    <th class="text-center">Pegawai</th>
    <th class="text-center">Lock</th>
    <th class="text-center">Upload Berkas</th>
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){
      $periode = explode('-', $rs['created_date']);
    ?>
      <tr style="cursor: pointer;">
        <td class="text-center"><?=$no++;?></td>
        <td class="text-left"><?=$rs['nama_param_unitkerja'] == "" ? $rs['nm_unitkerja'] : $rs['nama_param_unitkerja']?></td>
        <td class="text-center"><?=getNamaBulan($rs['bulan']).' '.$periode[0]?></td>
        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td class="text-left">
          <?=getNamaPegawaiFull($rs)?><br>
          NIP. <?=$rs['nipbaru_ws']?>
        </td>
        <td class="text-center">
          <div class="form-check">
            <input style="cursor: pointer; width: 25px; height: 25px;" onclick="lockTpp('<?=$rs['id']?>')" 
            class="form-check-input" <?=$rs['flag_active'] == 1 ? 'checked' : ''?> type="checkbox" id="checkbox_<?=$rs['id']?>">
          </div>
        </td>
        <td class="text-center">
          <?php if($rs['flag_upload_berkas_tpp'] == 1){ ?>
            <span style="
                background-color: green;
                padding: 10px;
                border-radius: 1000px;
                color: white;
              ">
              <i class="fa fa-check fa-1x"></i>
            </span>
          <?php } else { ?>
          <?php } ?>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $(function(){
    $('.table_lock_tpp').dataTable()
  })

  function lockTpp(id){
    $.ajax({
      url: '<?=base_url("master/C_Master/updateLockTpp/")?>'+id,
      method: 'post',
      data: null,
      success: function(data){
        successtoast('Update Berhasil')
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
      }
  })
  }
</script>