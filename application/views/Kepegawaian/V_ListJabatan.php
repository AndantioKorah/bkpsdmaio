<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Jabatan</th>
          <th class="text-left">TMT Jabatan</th>
          <th class="text-left">Eselon</th>
          <th class="text-left">Angkat Kredit</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-left">No / Tanggal SK</th>
          <th class="text-left">Ket</th>
          <th class="text-left">File SK</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama_jabatan']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tmtjabatan'])?></td>
              <td class="text-left"><?=$rs['nm_eselon']?></td>
              <td class="text-left"><?=$rs['angkakredit']?></td>
              <td class="text-left"><?=$rs['skpd']?></td>
              <td class="text-left"><?=$rs['nosk']?> / <?= formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?=$rs['ket']?></td>
              <td class="text-left">
                <button href="#modal_view_file_jabatan" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal_view_file_jabatan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_jabatan" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      

 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_jabatan').attr('src', 'http://localhost/bkpsdmaio/arsipjabatan/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>