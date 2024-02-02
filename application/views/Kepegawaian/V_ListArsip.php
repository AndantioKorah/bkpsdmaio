<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable" >
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Arsip</th>
          <th class="text-left">File</th>
          <th></th>
          
          <?php if($kode == 2) { ?>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
     
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?php if($rs['name'] == "") echo $rs['nama_sk']; else echo $rs['keterangan'];?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_arsip" onclick="openFileArsip('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
                 <?php } ?>
              </td>
              <td>

              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_arsip_lain"
                onclick="loadEditArsipLain('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailCuti btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>


              <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip) { ?>

                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_arsip_lain"
                onclick="loadEditArsipLain('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailCuti btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>
                <?php } ?>

                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } ?>
               <?php } ?>
            </td>
              
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
       

<script>
  $(function(){
    $('.datatable').dataTable()
  })


  async function openFileArsip(filename){
    $('#iframe_view_file_arsip').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //    'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsiplain/'+filename
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)


    //     if(res == null){
    //       $('iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK')
    //     }

    //     $('#iframe_view_file_arsip').attr('src', res.data)
    //     $('#iframe_view_file_arsip').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })

    var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsiplain/"+filename+"?v="+number;
    $('#iframe_view_file_arsip').attr('src', $link)
        $('#iframe_view_file_arsip').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
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

            function loadEditArsipLain(id){
              $('#edit_arsip_lain_pegawai').html('')
              $('#edit_arsip_lain_pegawai').append(divLoaderNavy)
              $('#edit_arsip_lain_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditArsipLain")?>'+'/'+id, function(){
                $('#loader').hide()
              })
              }

</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>