<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable" >
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Arsip</th>
          <th class="text-left">File</th>
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
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?php if($rs['name'] == "") echo $rs['nama_sk']; else echo $rs['name'];?></td>
              <td class="text-left">
                <button href="#modal_view_file_arsip" onclick="openFileArsip('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              </td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <td>
              <?php if($kode == 1) { ?>
              <button onclick="deleteArsip('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </td>
               <?php } ?>
               <?php } ?>
              <?php if($kode == 2) { ?>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteArsip('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal_view_file_arsip" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_arsip"  frameborder="0" ></iframe>
      </div>
        </div>
      </div>
    </div>
</div>
                

 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  // function openFileArsip(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_arsip').attr('src', '<?=base_url();?>arsiplain/'+filename)
  // }

  
  async function openFileArsip(filename){
    $('#iframe_view_file_arsip').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
      method: 'POST',
      data: {
       'username': '<?=$this->general_library->getUserName()?>',
        'password': '<?=$this->general_library->getPassword()?>',
        'filename': 'arsiplain/'+filename
      },
      success: function(data){
        let res = JSON.parse(data)


        if(res == null){
          $('iframe_loader').show()  
          $('.iframe_loader').html('Tidak ada file SK')
        }

        $('#iframe_view_file_arsip').attr('src', res.data)
        $('#iframe_view_file_arsip').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
        })
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
      }
    })
  }

  function deleteArsip(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegarsip/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListArsip()
                               } else {
                                loadRiwayatUsulArsip()
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