<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis SK</th>
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
              <td class="text-left"><?php if($rs['jenissk'] == 1) echo 'SK CPNS'; else echo 'SK PNS';?></td>
              <td class="text-left">

              <button href="#modal_view_file_berkas_pns" onclick="openFileBerkasPns('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
              <i class="fa fa-file-pdf"></i></button>
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

  // function openFileBerkasPns(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_berkas_pns').attr('src', '<?=base_url();?>arsipberkaspns/'+filename)
  // }

  async function openFileBerkasPns(filename){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
      method: 'POST',
      data: {
       'username': '<?=$this->general_library->getUserName()?>',
        'password': '<?=$this->general_library->getPassword()?>',
        'filename': 'arsipberkaspns/'+filename
      },
      success: function(data){
        let res = JSON.parse(data)


        if(res == null){
          $('iframe_loader').show()  
          $('.iframe_loader').html('Tidak ada file SK')
        }

        $('#iframe_view_file_berkas_pns').attr('src', res.data)
        $('#iframe_view_file_berkas_pns').on('load', function(){
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
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegberkaspns/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListBerkasPns()
                               } else {
                                loadRiwayatUsulBerkasPns()
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