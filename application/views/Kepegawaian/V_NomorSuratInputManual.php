<?php if($result){ ?>
  <div class="col-lg-12 table-responsive">
    <table class="table table-striped table-hover" id="table_input_nomor_surat_manual">
      <thead>
        <th class="text-center">No</th>
        <th class="text-left">Perihal</th>
        <th class="text-left">Nomor Surat</th>
        <th class="text-center">Jenis File</th>
        <th class="text-center">Dibuat Pada</th>
        <th class="text-center">Pilihan</th>
      </thead>
      <tbody>
        <?php if($result){ $no = 1; foreach($result as $rs){ ?>
          <tr>
            <td class="text-center"><?=$no++;?></td>
            <td class="text-left"><?=$rs['perihal']?></td>
            <td class="text-left"><?=$rs['nomor_surat']?></td>
            <td class="text-left"><?=$rs['nama_jenis_ds']?></td>
            <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
            <th class="text-center"><button href="#modal_nomor_surat_manual" data-toggle="modal" class="btn btn-sm btn-warning"
              onclick="openModalNomorSuratManual('<?=$rs['id']?>')">
              <i class="fa fa-edit"></i> Edit</button></th>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="modal_nomor_surat_manual" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">INPUT NOMOR SURAT MANUAL</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_nomor_surat_manual_content">
            </div>
        </div>
    </div>
  </div>
  <script>
    $(function(){
      $('#table_input_nomor_surat_manual').dataTable()
    })

    function openModalNomorSuratManual(id){
      $('#modal_nomor_surat_manual_content').html('')
      $('#modal_nomor_surat_manual_content').append(divLoaderNavy)
      $('#modal_nomor_surat_manual_content').load('<?=base_url('kepegawaian/C_Kepegawaian/openModalNomorSuratManual/')?>'+id, function(){
        $('#loader').hide()
      })
    }
  </script>
<?php } else { ?>
<?php } ?>