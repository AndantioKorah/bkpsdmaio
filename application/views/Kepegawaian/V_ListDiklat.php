<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Diklat</th>
         
          <th class="text-left">Nama Diklat</th>
          <th class="text-left">Tempat Diklat</th>
          <th class="text-left">Penyelenggara</th>
          <th class="text-left">Angkatan</th>
          <th class="text-left">Jam</th>
          <th class="text-left">Tanggal Mulai / Tanggal Selesai</th>
          <th class="text-left">No / Tanggal STTPP</th>
          <th class="text-left">Sertifikat STTPP</th>
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
              <td class="text-left"><?=$rs['nm_jdiklat']?></td>
              <td class="text-left"><?=$rs['nm_diklat']?></td>
              <td class="text-left"><?=$rs['tptdiklat']?></td>
              <td class="text-left"><?=$rs['penyelenggara']?></td>
              <td class="text-left"><?=$rs['angkatan']?></td>
              <td class="text-left"><?=$rs['jam']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> / <?= formatDateNamaBulan($rs['tglselesai'])?></td>
              <td class="text-left"><?=$rs['nosttpp']?> / <?=formatDateNamaBulan($rs['tglsttpp'])?></td>
              <td class="text-left">
                <button href="#modal_view_file_diklat" onclick="openFileDiklat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              </td>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'Di Tolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteKegiatan('<?=$rs['id']?>','<?=$rs['gambarsk']?>' )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <div class="modal fade" id="modal_view_file_diklat" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_diklat"  frameborder="0" ></iframe>	
      </div>
        </div>
      </div>
    </div>
</div>


 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  // function openFilePangkat(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_diklat').attr('src', '<?=base_url();?>arsipdiklat/'+filename)
  // }


  async function openFileDiklat(filename){
    $('#iframe_view_file_diklat').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
      method: 'POST',
      data: {
       'username': '<?=$this->general_library->getUserName()?>',
        'password': '<?=$this->general_library->getPassword()?>',
        'filename': 'arsipdiklat/'+filename
      },
      success: function(data){
        let res = JSON.parse(data)


        if(res == null){
          $('iframe_loader').show()  
          $('.iframe_loader').html('Tidak ada file SK')
        }

        $('#iframe_view_file_diklat').attr('src', res.data)
        $('#iframe_view_file_diklat').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
        })
      }, error: function(e){
        errortoast('Terjadi Kesalahan')
      }
    })
  }

  function deleteKegiatan(id,file){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdiklat/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadRiwayatUsulDiklat()
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