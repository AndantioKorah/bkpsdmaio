<?php if($result){ ?>dsfs
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Sumpah Janji</th>
          <th class="text-left">Yang Mengambil Sumpah</th>
          <th class="text-left">No Berita Acara </th>
          <th class="text-left">Tanggal Berita Acara</th>
          <th></th>
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
              <td class="text-left"><?=$rs['nm_sumpah']?></td>
              <td class="text-left"><?= $rs['pejabat']?></td>
              <td class="text-left"><?=$rs['noba']?></td>
              <td class="text-left"><?=$rs['tglba']?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_sumjan" onclick="openFileSumjan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
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

  async function openFileSumjan(filename){
   
   $('#iframe_view_file_sumjan').hide()
   $('.iframe_loader').show()  
   console.log(filename)
   $.ajax({
     url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
     method: 'POST',
     data: {
       'username': '<?=$this->general_library->getUserName()?>',
       'password': '<?=$this->general_library->getPassword()?>',
       'filename': 'arsipsumpah/'+filename
     },
     success: function(data){
       let res = JSON.parse(data)
       console.log(res.data)
       $(this).show()
       $('#iframe_view_file_sumjan').attr('src', res.data)
       $('#iframe_view_file_sumjan').on('load', function(){
         $('.iframe_loader').hide()
         $(this).show()
       })
     }, error: function(e){
         errortoast('Terjadi Kesalahan')
     }
   })
 }


  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegsumpah/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListSumpahJanji()
                               } else {
                                loadRiwayatUsulSumpahJanji()
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