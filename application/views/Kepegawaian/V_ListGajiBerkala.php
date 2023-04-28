<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Masa Kerja</th>
          <th class="text-left">Pangkat Gol/Ruang</th>
          <th class="text-left">Pejabat Yang Menetapkan</th>
          <th class="text-left">No SK</th>
          <th class="text-left">Tanggal SK</th>
          <th class="text-left">TMT Gaji Berkala</th>
          <th class="text-left">SK</th>
          <th class="text-left">Keterangan</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['masakerja']?></td>
              <td class="text-left"><?= $rs['nm_pangkat']?></td>
              <td class="text-left"><?=$rs['pejabat']?></td>
              <td class="text-left"><?=$rs['nosk']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tmtgajiberkala'])?></td>

              <td class="text-left">
                <button href="#modal_view_file_gaji_berkala" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>
           <td>
           <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteKegiatan('<?=$rs['id']?>','<?=$rs['gambarsk']?>' )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
           </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- <div class="modal fade" id="modal_view_file_gaji_berkala" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
   
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_gaji_berkala" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                       -->

 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file_gaji_berkala').attr('src', 'http://localhost/bkpsdmaio/arsipgjberkala/'+filename)
  }


  function deleteKegiatan(id,file){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/peggajiberkala/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadRiwayatGajiBerkala()
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }


</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>