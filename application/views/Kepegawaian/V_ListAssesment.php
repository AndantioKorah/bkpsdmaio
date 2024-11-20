<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Nilai Assesment</th>
          <th class="text-left">Tanggal Mulai Berlaku</th>
          <th class="text-left">Tanggal Selesai Berlaku</th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
            <?php } ?>
          <?php if($kode == 2) { ?>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['tahun']?></td>
              <td class="text-left"><?=$rs['nilai_assesment']?></td>
              <td class="text-left"><?=$rs['tgl_mulaiberlaku']?></td>
              <td class="text-left"><?=$rs['tgl_selesaiberlaku']?></td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                <td>
              <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </td>
              <?php } ?>
               <?php } ?>
             <?php if($kode == 2) { ?>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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


  async function openFileAssesment(filename){
   
   $('#iframe_view_file_assesment').hide()
   $('.iframe_loader').show()  
   console.log(filename)
   $.ajax({
     url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
     method: 'POST',
     data: {
       'username': '<?=$this->general_library->getUserName()?>',
       'password': '<?=$this->general_library->getPassword()?>',
       'filename': 'arsipassesment/'+filename
     },
     success: function(data){
       let res = JSON.parse(data)
       console.log(res.data)
       $(this).show()
       $('#iframe_view_file_assesment').attr('src', res.data)
       $('#iframe_view_file_assesment').on('load', function(){
         $('.iframe_loader').hide()
         $(this).show()
       })
     }, error: function(e){
         errortoast('Terjadi Kesalahan')
     }
   })

   
 }
  
  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegassesment/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListAssesment()
                               } else {
                                loadRiwayatUsulAssesment()
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