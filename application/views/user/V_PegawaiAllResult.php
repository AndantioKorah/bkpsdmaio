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
        </div>
    </div>
    <table class="table table-hover" id="result_all_pegawai">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Eselon</th>
            <th class="text-center">Pangkat</th>
            <?php if($use_masa_kerja == 1){ ?>
                <th class="text-center">Masa Kerja</th>
            <?php } ?>
            <th class="text-center">Unit Kerja</th>
        </thead>
        <tbody>
            <?php if($result){ $no=1; foreach($result as $rs){ ?>
                <tr>
                    <td class="text-center"><?=$no++?></td>
                    <td class="text-left">
                        <span class="fw-bold namapegawai">
                            <a target="_blank" style="color: black !important;" href="<?=base_url('kepegawaian/profil-pegawai/'.$rs['nipbaru_ws'])?>"><?=getNamaPegawaiFull($rs)?></a>
                        </span><br>
                        <span><?=($rs['nama_jabatan'])?></span><br>
                        <span><?="NIP. ".formatNip($rs['nipbaru_ws'])?></span><br>
                        <?php if($rs['id_statuspeg'] == 1){ ?>
                            <span class="badge badge-cpns"><?=$rs['nm_statuspeg']?></span>
                        <?php } else if($rs['id_statuspeg'] == 3){ ?>
                            <span class="badge badge-pppk"><?=$rs['nm_statuspeg']?></span>
                        <?php } ?>
                    </td>
                    <td class="text-center"><?=$rs['eselon']?></td>
                    <td class="text-left"><?=$rs['nm_pangkat']?></td>
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