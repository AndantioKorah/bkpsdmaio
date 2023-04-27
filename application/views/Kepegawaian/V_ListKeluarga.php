<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Hubungan Keluarga</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Tempat/Tanggal Lahir</th>
          <th class="text-left">Pendidikan</th>
          <th class="text-left">Pekerjaan</th>
          <th class="text-left">Keterangan</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_keluarga']?></td>
              <td class="text-left"><?=$rs['namakel']?></td>
              <td class="text-left"><?= $rs['tptlahir']?></td>  
              <td class="text-left"><?= $rs['pendidikan']?></td>               
              <td class="text-left"><?= $rs['pekerjaan']?></td> 
              <td></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal_view_file_skp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_skp" style="width: 100%; height: 80vh;" src=""></iframe>
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
    $('#iframe_view_file_skp').attr('src', 'http://localhost/bkpsdmaio/arsipskp/'+filename)
  }

  
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>