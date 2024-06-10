<table class="table table-hover table-striped" id="table_list_tpp">
  <thead>
    <th class="text-center">No</th>
    <th class="text-left">Pegawai</th>
    <?php if($flag_show_unitkerja == 1){ ?>
      <th class="text-center">Unit Kerja</th>
    <?php } ?>
    <th class="text-center">Besaran Gaji</th>
    <th class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
      <form class="form_gaji_<?=$rs['nipbaru_ws']?>">
        <tr>
          <td class="text-center"><?=$no++;?></td>
          <td class="text-left" style="line-height: 15px;">
            <span style="font-size: 14px; color: black; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
            <span style="font-size: 12px; color: black;">NIP. <?=$rs['nipbaru_ws']?></span><br>
            <span style="font-size: 12px; color: black; font-weight: bold;"><?=$rs['nama_jabatan']?></span><br>
            <span style="font-size: 12px; color: black;"><?=$rs['nm_pangkat']?></span>
          </td>
          <?php if($flag_show_unitkerja == 1){ ?>
            <td class="text-left"><?=$rs['nm_unitkerja']?></td>
          <?php } ?>
          <td class="text-center">
            <input class="form-control" id="gaji_<?=$rs['nipbaru_ws']?>" type="number" value="<?=$rs['besaran_gaji']?>" />        
          </td>
          <td class="text-center">
            <button onclick="saveGaji('<?=$rs['nipbaru_ws']?>')" type="button" class="btn btn-navy"><i class="fa fa-save"></i> Simpan</button>
          </td>
        </tr>
      </form>
    <?php } } ?>
  </tbody>
</table>
<script>
  $('#table_list_tpp').dataTable()

  
  function saveGaji(id){
    $.ajax({
        url: '<?=base_url("master/C_Master/saveInputGaji")?>',
        method: 'post',
        data: {
          nip: id,
          gaji: $('#gaji_'+id).val()
        },
        success: function(data){
            successtoast('Berhasil Menyimpan Data')
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
    })
  }
</script>