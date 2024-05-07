<table class="table table-hover table-striped" id="table_list_tpp">
  <thead>
    <th class="text-left">No</th>
    <th class="text-left">Pegawai</th>
    <th>Pangkat/Gol.Ruang</th>
    <th>Jabatan</th>
    <th>Unit Kerja</th>
    
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
      <tr>
        <td class="text-left"><?=$no++;?></td>
        <td class="text-left" style="line-height: 15px;">
        <a href="<?= base_url('kepegawaian/pegawai/')?><?=$rs['id_peg'];?>" target="_blank">
          <span style="font-size: 14px; color: black; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
          <span style="font-size: 12px; color: black;">NIP. <?=$rs['nipbaru_ws']?></span><br>
          </a>
         
        </td>
        <td class="text-left"><?=$rs['nm_pangkat']?></td>
        <td class="text-left"><?=$rs['nama_jabatan']?></td>
        <td class="text-left"><?=$rs['nm_unitkerja']?></td>
       
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $('#table_list_tpp').dataTable()
</script>