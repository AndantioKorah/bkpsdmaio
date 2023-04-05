dafa<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped datatable" id="datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tingkat Pendidikan</th>
         
          <th class="text-left">Nama Sekolah</th>
          <th class="text-left">Fakultas</th>
          <th class="text-left">Jurusan</th>
          <th class="text-left">Nama Pimpinan</th>
          <th class="text-left">Tahun Lulus</th>
          <th class="text-left">No. STTB/Ijazah</th>
          <th class="text-left">Tgl STTB/Ijazah</th>
          <th class="text-left">Ijazah</th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_tktpendidikan']?></td>
           
              <td class="text-left"><?=$rs['namasekolah']?></td>
              <td class="text-left"><?=$rs['fakultas']?></td>
              <td class="text-left"><?=$rs['jurusan']?></td>
              <td class="text-left"><?=$rs['pimpinansekolah']?></td>
              <td class="text-left"><?=$rs['tahunlulus']?></td>
              <td class="text-left"><?=$rs['noijasah']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglijasah'])?></td>
              <td class="text-left">
                <button href="#modal_view_file_pendidikan" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal_view_file_pendidikan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_pendidikan" style="width: 100%; height: 80vh;" src=""></iframe>
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
    $('#iframe_view_file_pendidikan').attr('src', 'http://localhost/bkpsdmaio/arsippendidikan/'+filename)
  }
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>