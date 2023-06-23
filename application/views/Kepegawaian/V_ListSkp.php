<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Predikat</th>
          <th class="text-left">File</th>
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
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['tahun']?></td>
              <td class="text-left"><?= $rs['predikat']?></td>          
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_skp" onclick="openFileSKP('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
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

  // function openFileSKP(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_skp').attr('src', '<?=base_url();?>arsipskp/'+filename)
  // }

  async function openFileSKP(filename){
   
   $('#iframe_view_file_skp').hide()
   $('.iframe_loader').show()  
   console.log(filename)
   $.ajax({
     url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
     method: 'POST',
     data: {
       'username': '<?=$this->general_library->getUserName()?>',
       'password': '<?=$this->general_library->getPassword()?>',
       'filename': 'arsipskp/'+filename
     },
     success: function(data){
       let res = JSON.parse(data)
       console.log(res.data)
       $(this).show()
       $('#iframe_view_file_skp').attr('src', res.data)
       $('#iframe_view_file_skp').on('load', function(){
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
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegskp/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListSkp()
                               } else {
                                loadRiwayatUsulSkp()
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