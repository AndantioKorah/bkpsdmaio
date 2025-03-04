<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tanggal Pengajuan</th>
          <!-- <th class="text-left">Status</th> -->
          <!-- <th class="text-left">Keterangan</th> -->

          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['created_date'])?></td>
              <!-- <td class="text-left">
              <span class="badge badge-<?php if($rs['status'] == '1') echo "success"; else if($rs['status'] == '2') echo "danger"; else echo "primary";?>"><?php if($rs['status'] == '1') echo "Diterima"; else if($rs['status'] == '2') echo "Ditolak"; else echo "Menunggu Verifikasi BKPSDM";?>

              </td> -->
              <!-- <td class="text-left"><?=$rs['keterangan']?></td> -->
            
              <td>
              <?php if($rs['status'] == 0) { ?>
              <button onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              <?php } ?>
            </td>
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

  function deleteData(id){
                  
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deletePengajuanPensiun/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadListRiwayatPensiun()
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