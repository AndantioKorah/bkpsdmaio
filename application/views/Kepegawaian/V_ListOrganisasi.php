<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Organisasi</th>
          <th class="text-left">Nama Organisasi</th>
          <th class="text-left">Kedudukan / Jabatan</th>
          <th class="text-left">Tanggal Mulai - Selesai</th>
          <th class="text-left">Pemimpin</th>
          <th class="text-left">Tempat</th>


        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_organisasi']?></td>
              <td class="text-left"><?= $rs['nama_organisasi']?></td>    
              <td class="text-left"><?= $rs['jabatan_organisasi']?></td>          
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> - <?= formatDateNamaBulan($rs['tglselesai'])?></td>          
              <td class="text-left"><?= $rs['pemimpin']?></td> 
              <td class="text-left"><?= $rs['tempat']?></td>          

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