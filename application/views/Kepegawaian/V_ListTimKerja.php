<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Tim Kerja</th>
          <th class="text-left">Jabatan</th>
          <th class="text-left">Ruang Lingkup Tim Kerja</th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
          <th></th>
            <?php } ?>
          <?php if($kode == 2) { ?>
          <th class="text-left">Keterangan</th>
          <th></th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_timkerja']?></td>
              <td class="text-left"><?=($rs['jabatan'] == '1' ? 'Ketua/Penanggung Jawab' : 'Anggota');?></td>
              <td class="text-left"><?=$rs['nm_lingkup_timkerja']?></td>
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_tk" onclick="openFileTk('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                <td>
              <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </td>
              <?php } ?>
               <?php } ?>
             <?php if($kode == 2) { ?>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>
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

  async function openFileTk(filename){
   
   $('#iframe_view_file_tk').hide()
   $('.iframe_loader').show()  
   console.log(filename)
   $.ajax({
     url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
     method: 'POST',
     data: {
       'username': '<?=$this->general_library->getUserName()?>',
       'password': '<?=$this->general_library->getPassword()?>',
       'filename': 'arsiptimkerja/'+filename
     },
     success: function(data){
       let res = JSON.parse(data)
       console.log(res.data)
       $(this).show()
       $('#iframe_view_file_tk').attr('src', res.data)
       $('#iframe_view_file_tk').on('load', function(){
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
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegtimkerja/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               ifh(kode == 1){
                                loadListTimKerja()
                               } else {
                                loadRiwayatUsulTimKerja;()
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