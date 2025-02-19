<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Hukuman Disiplin</th>
          <th class="text-left">Jenis Hukuman Disiplin</th>
          <th class="text-left">Jenis Pelanggaran</th>
          <th class="text-left">Tanggal Mulai Berlaku</th>
          <th class="text-left">Tanggal Selesai Berlaku</th>
          <th class="text-left">No Surat</th>
          <th class="text-left">Tanggal Surat</th>
          <th class="text-left">TMT</th>

          <th></th>
          <th></th>
          <?php if($kode == 2) { ?>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">


              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama']?></td>
              <td class="text-left"><?=$rs['nama_jhd']?></td>
              <td class="text-left"><?=$rs['jp']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tgl_mulaiberlaku'])?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tgl_selesaiberlaku'])?></td>
              <td class="text-left"><?=$rs['nosurat']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsurat'])?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tmt'])?></td>

              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_disiplin" onclick="openFileDisiplin('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() ||  $this->general_library->getBidangUser() == ID_BIDANG_PEKIN) { ?>

                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_disiplin"
                onclick="loadEditDisiplin('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailDiklat btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>
                <?php } ?>

                <?php  if($this->general_library->isProgrammer()  
                || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
                || isKasubKepegawaian($this->general_library->getNamaJabatan())){ ?>
                <?php if($kode == 1) { ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
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
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
});


  })

  // function openFilePangkat(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_disiplin').attr('src', '<?=base_url();?>arsipdiklat/'+filename)
  // }


  async function openFileDisiplin(filename){
    $('#iframe_view_file_disiplin').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')

    var number = Math.floor(Math.random() * 1000);
    // $link = "http://siladen.manadokota.go.id/bidik/arsipdisiplin/"+filename+"?v="+number;
    $link = "<?=base_url();?>arsipdisiplin/"+filename+"?v="+number;

    $('#iframe_view_file_disiplin').attr('src', $link)
        $('#iframe_view_file_disiplin').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdisiplin/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListDisiplin()
                               } else {
                                loadRiwayatUsulDisiplin()
                               }
                               
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

     function loadEditDisiplin(id){
              $('#edit_disiplin_pegawai').html('')
              $('#edit_disiplin_pegawai').append(divLoaderNavy)
              $('#edit_disiplin_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditDisiplin")?>'+'/'+id, function(){
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