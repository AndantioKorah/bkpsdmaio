<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <tr><button class="btn"><i class="fa fa-plus"></i> Tambah</button></tr>
      <table class="table table-striped" id="datatable">
        <thead>
          <th class="text-center">No</th>
          <th class="text-center">Jenis</th>
          <th class="text-center">Masa Kerja</th>
          <th class="text-center">Pangkat, Gol/Ruang</th>
          <th class="text-center">TMT Pangkat</th>
          <th class="text-center">Pejabat</th>
          <th class="text-center">No. SK</th>
          <th class="text-center">Tanggal SK</th>
          <th class="text-center">Dokumen</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-center"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_jenispengangkatan']?></td>
              <td class="text-left"><?=$rs['masakerjapangkat']?></td>
              <td class="text-left"><?=$rs['nm_pangkat']?></td>
              <td class="text-center"><?=formatDateNamaBulan($rs['tmtpangkat'])?></td>
              <td class="text-left"><?=strtoupper($rs['pejabat'])?></td>
              <td class="text-center"><?=($rs['nosk'])?></td>
              <td class="text-center"><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-center">
                <button href="#modal_view_file" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
 
<script>
  $(function(){
    $('#datatable').dataTable()
  })

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+nip+'/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>