<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Penghargaan</th>
          <th class="text-left">No. SK</th>
          <th class="text-left">Tgl SK</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Asal Perolehan</th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
            <?php } ?>
          <?php if($kode == 2) { ?>
            <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">


              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_pegpenghargaan']?></td>
              <td class="text-left"><?=$rs['nosk']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?=$rs['tahun_penghargaan']?></td>
              <td class="text-left"><?=$rs['nm_pemberipenghargaan']?></td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <td>
              <?php if($kode == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              <?php } ?>  
            </td>
               <?php } ?>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>

                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'Di Tolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>',2)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php } ?>
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


  function openFilePendidikan(filename){
    $('#iframe_view_file').attr('src', 'http://bkd.manadokota.go.id/simpegonline/adm/arsipelektronik/'+filename)
  }

  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpenghargaan/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1) {
                                loadListPenghargaan()
                               } else {
                                loadRiwayatUsulPenghargaan()
                               }
                              
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