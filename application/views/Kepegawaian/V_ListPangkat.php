<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis</th>
         
          <th class="text-left">Pangkat, Gol/Ruang</th>
          <th class="text-left">TMT Pangkat</th>
          <th class="text-left">Pejabat</th>
          <th class="text-left">Masa Kerja</th>
          <th class="text-left">No. SK</th>
          <th class="text-left">Tanggal SK</th>
          <th class="text-left">Dokumen</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_jenispengangkatan']?></td>
           
              <td class="text-left"><?=$rs['nm_pangkat']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tmtpangkat'])?></td>
              <td class="text-left"><?=strtoupper($rs['pejabat'])?></td>
              <td class="text-left"><?=$rs['masakerjapangkat']?></td>
              <td class="text-left"><?=($rs['nosk'])?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left">
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
    $('#iframe_view_file').attr('src', '<?= URL_FILE ?>'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>