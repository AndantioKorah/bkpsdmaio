<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Cuti</th>
          <th class="text-left">Tanggal Mulai/ Tanggal Selesai</th>
          <th class="text-left">No / Tanggal Surat Ijin</th>
          <th class="text-left">File</th>
          <th></th>
         
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
              <td class="text-left"><?=$rs['nm_cuti']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> / <?= formatDateNamaBulan($rs['tglselesai'])?></td>
              <td class="text-left"><?=$rs['nosttpp']?> / <?= formatDateNamaBulan($rs['tglsttpp'])?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_cuti" onclick="openFileCuti('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button>
                <?php } ?>
              </td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip) { ?>

                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_cuti"
                onclick="loadEditCuti('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailCuti btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
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
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
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

  // function openFileCuti(filename){
  //   var number = Math.floor(Math.random() * 1000);
  //   $link = "http://siladen.manadokota.go.id/bidik/arsipcuti/"+filename+"?v="+number;
  //   $('#iframe_view_file_cuti').attr('src', '<?=base_url();?>arsipcuti/'+filename)
  // }

  async function openFileCuti(filename){
    $('#iframe_view_file_cuti').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //     'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsipcuti/'+filename
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)
        

    //     if(res == null){
    //       $('.iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK Gaji Berkala')
    //     }

    //     $('#iframe_view_file_cuti').attr('src', res.data)
    //     $('#iframe_view_file_cuti').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })

    var number = Math.floor(Math.random() * 1000);
    // $link = "http://siladen.manadokota.go.id/bidik/arsipcuti/"+filename+"?v="+number;
    $link = "<?=base_url();?>/arsipcuti/"+filename+"?v="+number;

    $('#iframe_view_file_cuti').attr('src', $link)
        $('#iframe_view_file_cuti').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegcuti/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListCuti()
                               } else {
                                loadRiwayatUsulCuti()
                               }
                               
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

        function loadEditCuti(id){
              $('#edit_cuti_pegawai').html('')
              $('#edit_cuti_pegawai').append(divLoaderNavy)
              $('#edit_cuti_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditCuti")?>'+'/'+id, function(){
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