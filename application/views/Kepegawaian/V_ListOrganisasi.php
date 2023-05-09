<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Organisasi</th>
          <th class="text-left">Nama Organisasi</th>
          <th class="text-left">Kedudukan / Jabatan</th>
          <th class="text-left">Tanggal Mulai - Selesai</th>
          <th class="text-left">Pemimpin</th>
          <th class="text-left">Tempat</th>
          <?php if($kode == 2) { ?>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>

        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_organisasi']?></td>
              <td class="text-left"><?= $rs['nama_organisasi']?></td>    
              <td class="text-left"><?= $rs['jabatan_organisasi']?></td>          
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> - <?= formatDateNamaBulan($rs['tglselesai'])?></td>          
              <td class="text-left"><?= $rs['pemimpin']?></td> 
              <td class="text-left"><?= $rs['tempat']?></td>  
              <?php if($kode == 2) { ?>        
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteKegiatan('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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

  function deleteKegiatan(id,file){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegorganisasi/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadRiwayatUsulOrganisasi()
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