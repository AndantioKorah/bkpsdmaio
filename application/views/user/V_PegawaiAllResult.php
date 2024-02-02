<style>
    .badge-cpns{
      /* box-shadow: 3px 3px 10px #888888; */
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
    }

    .badge-pppk{
      /* box-shadow: 3px 3px 10px #888888; */
      background-color: #8f8657;
      border: 2px solid #8f8657;
      color: white;
    }

    .namapegawai:hover{
        cursor:pointer;
        text-decoration: underline;
        color: #17a2b8 !important;
    }
</style>
<div class="col-lg-12 p-3">
    <div class="row mb-3">
        <div class="col-lg-12 text-right">
            <form action="<?=base_url('user/C_User/downloadDataSearch')?>" target="_blank">
                <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Download as Pdf</button>
            </form>
            <form class="mt-2" action="<?=base_url('user/C_User/downloadDataSearch/1')?>" target="_blank">
                <button type="submit" class="btn btn-success"><i class="fa fa-file-pdf"></i> Download as Excel</button>
            </form>
        </div>
    </div>
    <table class="table table-hover" id="result_all_pegawai">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Eselon</th>
            <th class="text-center">Pangkat</th>
            <th class="text-center">TMT Pangkat</th>
            <th class="text-center">TMT Jabatan</th>
            <?php if($use_masa_kerja == 1){ ?>
                <th class="text-center">Masa Kerja</th>
            <?php } ?>
            <th class="text-center">Unit Kerja</th>
        </thead>
        <tbody>
            <?php if($result){ $no=1; foreach($result as $rs){
                    $badge_status = 'badge-cpns';
                if($rs['statuspeg'] == 2){
                    $badge_status = 'badge-pns';
                } else if($rs['statuspeg'] == 3){
                    $badge_status = 'badge-pppk';
                }

                $badge_aktif = 'badge-aktif';
                if($rs['id_m_status_pegawai'] == 2){
                    $badge_aktif = 'badge-pensiun-bup';
                } else if($rs['id_m_status_pegawai'] == 3){
                    $badge_aktif = 'badge-pensiun-dini';
                } else if($rs['id_m_status_pegawai'] == 4){
                    $badge_aktif = 'badge-diberhentikan';
                } else if($rs['id_m_status_pegawai'] == 5){
                    $badge_aktif = 'badge-mutasi';
                } else if($rs['id_m_status_pegawai'] == 6){
                    $badge_aktif = 'badge-meninggal';
                } else if($rs['id_m_status_pegawai'] == 8){
                    $badge_aktif = 'badge-tidak-aktif';
                }
            ?>
                <tr>
                    <td class="text-center"><?=$no++?></td>
                    <td class="text-left">
                        <span class="fw-bold namapegawai">
                            <a target="_blank" style="color: black !important;" href="<?=base_url('kepegawaian/profil-pegawai/'.$rs['nipbaru_ws'])?>"><?=getNamaPegawaiFull($rs)?></a>
                        </span><br>
                        <span><?=($rs['nama_jabatan'])?></span><br>
                        <span><?="NIP. ".formatNip($rs['nipbaru_ws'])?></span><br>
                        <span class="badge <?=$badge_status?>"><?=$rs['nm_statuspeg']?></span>
                        <span class="badge <?=$badge_aktif?>"><?=$rs['nama_status_pegawai']?></span>
                    </td>
                    <td class="text-center"><?=$rs['eselon']?></td>
                    <td class="text-left"><?=$rs['nm_pangkat']?></td>
                    <td class="text-left"><?=formatDateNamaBulan($rs['tmtpangkat'])?></td>
                    <td class="text-left"><?=formatDateNamaBulan($rs['tmtjabatan'])?></td>
                    <?php if($use_masa_kerja == 1){ ?>
                        <td class="text-center"><?=$rs['masa_kerja']?></td>
                    <?php } ?>
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