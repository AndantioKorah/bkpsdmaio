<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Assesment</th>
          <th class="text-left">File</th>
          <th class="text-left">Keterangan</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_assesment']?></td>
              <td class="text-left">
                <button href="#modal_view_file_assesment" onclick="openFilePangkat('<?=$rs['file']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>

            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  
 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_assesment').attr('src', 'http://localhost/bkpsdmaio/arsipassesment/'+filename)
  }

  
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>