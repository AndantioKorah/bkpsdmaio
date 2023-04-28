<?php if($result){ ?>
  <table class="table table-hover data_table">
    <thead>
      <th class="text-center">No</th>
      <th class="text-center">NIP</th>
      <th class="text-center">Nama</th>
      <th class="text-center">Tgl. Usul</th>
      <th class="text-center">Detail</th>
      <!-- <th class="text-center">Verif</th> -->
    </thead>
    <tbody>
      <?php $no=1; foreach($result as $rs){ ?>
        <tr>
          <td class="text-center"><?=$no++;?></td>
          <td class="text-center"><?=formatNip($rs['nipbaru_ws'])?></td>
          <td class="text-center"><?=getNamaPegawaiFull($rs)?></td>
          <td class="text-center"><?=formatDateNamaBulan($rs['created_date'])?></td>
          <td class="text-center">
            <button href="#edit_data" data-toggle="modal" onclick="openDetail('<?=$rs['id_dokumen']?>', '<?=$param['jenisdokumen']['value']?>')"
            class="btn btn-navy btn-sm">Detail <i class="fa fa-search"></i></button>
          </td>
          <!-- <td>
            <?php if($rs['status'] == 2 || $rs['status'] == 3){ ?>
                <span><strong><?=$rs['keterangan_verif']?></strong></span><br>
                <span style="font-size: .8rem;"><?='(pada '.formatDateNamaBulanWT($rs['tanggal_verif']).')'?></span>
            <?php } else if($rs['status'] == 1) { ?> 
                <input class="form-control" id="ket_verif_<?=$rs['id_dokumen']?>" />
            <?php } else if($rs['status'] == 4){ ?>
                <input class="form-control" id="ket_verif_<?=$rs['id_dokumen']?>" />
                <span style="font-size: .8rem;"><?='(DIBATALKAN pada '.formatDateNamaBulanWT($r['tanggal_verif']).')'?></span>
            <?php } ?>
          </td> -->
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="modal fade" id="edit_data" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" ss class="modal-dialog modal-xl">
        <div class="modal-content" id="edit_data_content">
        </div>
    </div>
  </div>

  <script>
    $(function(){
      $('.data_table').dataTable()
    })

    function openDetail(id, jenisdok){
      $('#edit_data_content').html('')
      $('#edit_data_content').append(divLoaderNavy)
      $('#edit_data_content').load('<?=base_url('Kepegawaian/C_Kepegawaian/openDetailDokumen/')?>'+id+'/'+jenisdok, function(){
        $('#loader').hide()
      })
    }
  </script>
<?php } else { ?>
  <div class="col-lg-12 text-center">
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
  </div>
<?php } ?>