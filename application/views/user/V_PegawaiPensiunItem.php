<?php if($result){ ?>
    <style>
        .text-nama{
            font-size: .9rem;
            font-weight: bold;
        }

        .text-small{
            font-size: .8rem;
            /* color: gray; */
        }

        #table_result, #table_result thead, #table_result th, #table_result tr, #table_result td{
            border: 1px solid gray;
        }
    </style>
    

<div id="tess">

</div>
    <div class="row p-3">
        <div class="col-lg-12 pb-3 text-right float-right">
            <!-- <button class="btn btn-sm btn-navy" id="dl-png" data-toggle="modal" data-target="#exampleModalx">PNG</button> -->
            <form target="_blank" action="<?=base_url('user/C_User/cetakPensiun')?>">
                <button type='submit' class="btn btn-sm btn-navy"><i class="fa fa-download"></i> Download File</button>
                <!-- <button type='button' onclick="cetak()" class="btn btn-sm btn-navy"><i class="fa fa-print"></i> Cetak</button> -->
            </form>
        </div>
        <div class="col-lg-12 table-responsive" id="example">
            <table border=1 id="table_result" class="table datatable">
                <thead>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 35%;" class="text-center">Nama Pegawai</th>
                    <th style="width: 10%;" class="text-center">Eselon</th>
                    <th style="width: 10%;" class="text-center">Jenis Jabatan</th>
                    <th style="width: 20%;" class="text-center">Unit Kerja</th>
                    <th style="width: 10%;" class="text-center">BUP</th>
                    <th style="width: 10%;" class="text-center">TMT Pensiun</th>
                    <th style="width: 20%;" class="text-center">Detail</th>
                    <th style="width: 20%;" class="text-center">Verifikator</th>
                    <th style="width: 20%;" class="text-center">Selesai</th>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($result as $rs){ ?>
                        <?php if(isset($list_checklist_pensiun[$rs['nipbaru_ws']])){ ?>
                            <tr style="background-color: <?=$list_checklist_pensiun[$rs['nipbaru_ws']]['bg-color']?>;
                                color: <?=$list_checklist_pensiun[$rs['nipbaru_ws']]['txt-color']?> !important; font-weight: bold;">
                        <?php } else { ?>
                            <tr>
                        <?php } ?>
                            <td class="text-center"><?=$no++;?></td>
                            <td class="text-left">
                                <span class="text-nama"><?=getNamaPegawaiFull($rs)?></span><br>
                                <span class="text-small"><?=($rs['nipbaru_ws'])?></span><br>
                                <span class="text-small fw-bold"><?=($rs['nama_jabatan'])?></span><br>
                                <span class="text-small"><?=($rs['nm_pangkat'])?></span>
                            </td>
                            <td class="text-center"><?=($rs['eselon'])?></td>
                            <td class="text-center"><?=($rs['jenis_jabatan'])?></td>
                            <td class="text-left"><?=($rs['nm_unitkerja'])?></td>
                            <td class="text-center"><?=($rs['umur'])?></td>                            
                            <td class="text-center"><?=formatDateNamaBulan($rs['tmt_pensiun'])?></td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-navy" target="_blank" href="<?=base_url('kepegawaian/pensiun/kelengkapan-berkas/'.$rs['nipbaru_ws'])?>">
                                    <i class="fa fa-file"></i> Berkas
                                </a>
                            </td>
                            <td class="text-center">
                                <span style="font-size: .75rem;"><?=isset($list_checklist_pensiun[$rs['nipbaru_ws']]) ? $list_checklist_pensiun[$rs['nipbaru_ws']]['nama_verifikator'] : ''?></span>
                            </td>
                            <td>
                                <span style="font-size: .75rem;"><?=isset($list_checklist_pensiun[$rs['nipbaru_ws']]) && $list_checklist_pensiun[$rs['nipbaru_ws']]['flag_selesai'] == 1 ? getNamaPegawaiFull($list_checklist_pensiun[$rs['nipbaru_ws']])." pada ".formatDateNamaBulanWT($list_checklist_pensiun[$rs['nipbaru_ws']]['date_flag_selesai']) : ''?></span>
                            </td>
                        </tr>
                        <!-- <?php if(isset($list_checklist_pensiun[$rs['nipbaru_ws']])){ ?>
                            <tr style="background-color: <?=$list_checklist_pensiun[$rs['nipbaru_ws']]['bg-color']?>;
                            color: <?=$list_checklist_pensiun[$rs['nipbaru_ws']]['txt-color']?>">
                                <td colspan=8 class="text-center">
                                    Verifikator: <?=$list_checklist_pensiun[$rs['nipbaru_ws']]['nama']?>
                                </td>
                            </tr>
                        <?php } ?> -->
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <img id="img" style="width:100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>




<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
	document.getElementById("dl-png").onclick = function() {
		const screenShotTarget = document.getElementById('tess');
		html2canvas(screenShotTarget).then((canvas) => {
			const base64image = canvas.toDataURL("image/png");
			var anchor = document.createElement('a');
            // $("#img").attr("src", base64image);
			anchor.setAttribute("href", base64image);
			anchor.setAttribute("download", "img.png");
			anchor.click();
			anchor.remove();
		})
	}


</script>

<?php } else { ?>
    <div class="p-3">
        <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
    </div>
<?php } ?>

<script>
    $(function(){
        $('.datatable').dataTable()
    })
</script>