<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Inovasi</th>
          <th class="text-left">Kriteria Inovasi</th>
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
              <td class="text-left"><?=$rs['nm_inovasi']?></td>
              <td class="text-left"><?=$rs['kriteria_inovasi']?></td>
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_inovasi" onclick="openFileInovasi('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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

  async function openFileInovasi(filename){
   
   $('#iframe_view_file_inovasi').hide()
   $('.iframe_loader').show()  
  //  $.ajax({
  //    url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
  //    method: 'POST',
  //    data: {
  //      'username': '<?=$this->general_library->getUserName()?>',
  //      'password': '<?=$this->general_library->getPassword()?>',
  //      'filename': 'arsipinovasi/'+filename
  //    },
  //    success: function(data){
  //      let res = JSON.parse(data)
  //      console.log(res.data)
  //      $(this).show()
  //      $('#iframe_view_file_inovasi').attr('src', res.data)
  //      $('#iframe_view_file_inovasi').on('load', function(){
  //        $('.iframe_loader').hide()
  //        $(this).show()
  //      })
  //    }, error: function(e){
  //        errortoast('Terjadi Kesalahan')
  //    }
  //  })

   var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsipinovasi/"+filename+"?v="+number;
    $('#iframe_view_file_inovasi').attr('src', $link)
        $('#iframe_view_file_inovasi').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })
 }
  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/peginovasi/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListInovasi()
                               } else {
                                loadRiwayatUsulInovasi()
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