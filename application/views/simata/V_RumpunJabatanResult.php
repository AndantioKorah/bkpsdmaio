<style>
  .badge-kesehatan{
      box-shadow: 3px 3px 10px #888888;
      background-color: #4169E1;
      border: 2px solid #4169E1;
      color: white;
    }

    .badge-ti{
      box-shadow: 3px 3px 10px #888888;
      background-color: #00008B;
      border: 2px solid #00008B;
      color: white;
    }

    .badge-pendidikan{
      box-shadow: 3px 3px 10px #888888;
      background-color: #8B4513;
      border: 2px solid #8B4513;
      color: white;
    }


</style>

    <table class="table table-hover" id="result_all_pegawai">
        <thead>
            <th class="text-left">No</th>
            <th class="text-left">Rumpun Jabatan</th>
            <th class="text-left">Nama Jabatan</th>
            <th class="text-left">Eselon</th>
            <th class="text-left">SKPD</th>
            
        </thead>
        <tbody>
            <?php if($result){ $no=1; foreach($result as $rs){
          $badge_aktif = 'badge-aktif';
          if($rs['id_m_rumpun_jabatan'] == 2){
              $badge_aktif = 'badge-pensiun-bup';
          } else if($rs['id_m_rumpun_jabatan'] == 3){
              $badge_aktif = 'badge-pensiun-dini';
          } else if($rs['id_m_rumpun_jabatan'] == 4){
              $badge_aktif = 'badge-ti';
          } else if($rs['id_m_rumpun_jabatan'] == 5){
              $badge_aktif = 'badge-mutasi';
          } else if($rs['id_m_rumpun_jabatan'] == 6){
              $badge_aktif = 'badge-meninggal';
          } else if($rs['id_m_rumpun_jabatan'] == 7){
            $badge_aktif = 'badge-pppk';
          } else if($rs['id_m_rumpun_jabatan'] == 8){
              $badge_aktif = 'badge-tidak-aktif';
          } else if($rs['id_m_rumpun_jabatan'] == 9){
            $badge_aktif = 'badge-kesehatan';
          } else if($rs['id_m_rumpun_jabatan'] == 10){
            $badge_aktif = 'badge-pendidikan';
          } 
            ?>
                <tr>
                    <td class="text-center"><?=$no++?></td>
                    <td class="text-left">
                    <span class="badge <?=$badge_aktif?>"><?=$rs['nm_rumpun_jabatan']?></span>
                      
                    </td>
                    <td class="text-left"><?=$rs['nama_jabatan']?></td>
                    <td class="text-left"><?=$rs['eselon']?></td>
                    <td class="text-left"><?=$rs['nm_unitkerja']?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#result_all_pegawai').dataTable()
    })
</script>