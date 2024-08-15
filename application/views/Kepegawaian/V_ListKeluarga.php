<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Hubungan Keluarga</th>
          <th class="text-left">Nama</th>
          <th class="text-left">Tempat/Tanggal Lahir</th>
          <th class="text-left">Pendidikan</th>
          <th class="text-left">Pekerjaan</th>
          <th></th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
            <?php } ?>
          <?php if($kode == 2) { ?>
            <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left"></th>
          <?php } ?>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">


              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nm_keluarga']?></td>
              <td class="text-left"><?=$rs['namakel']?></td>
              <td class="text-left"><?= $rs['tptlahir']?>, <?= formatDateNamaBulan($rs['tgllahir'])?></td>  
              <td class="text-left"><?= $rs['pendidikan']?></td>               
              <td class="text-left"><?= $rs['pekerjaan']?></td> 
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_keluarga" onclick="openFileJabatan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteData('<?=$rs['id']?>',2)" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php } ?>
              <td>
              <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_keluarga"
                onclick="loadEditKeluarga('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailOrganisasi btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal_view_file_skp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_skp" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>                      


<div class="modal fade" id="modal_view_file_keluarga" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <h5 id="" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file_jabatan"  frameborder="0" ></iframe>	
      </div>
        </div>
      </div>
    </div>
</div>
 

<!-- Modal -->
<div class="modal fade" id="modal_edit_keluarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Keluarga</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_keluarga_pegawai">
          
        </div>
    
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>


<script>
  $(function(){
    $('.datatable').dataTable()
  })

  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegkeluarga/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListKeluarga()
                               } else {
                                loadRiwayatUsulKeluarga()
                               }
                              
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

               async function openFileJabatan(filename){
    $('#iframe_view_file_jabatan').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    var number = Math.floor(Math.random() * 1000);
    // $link = "http://siladen.manadokota.go.id/bidik/arsipjabatan/"+filename+"?v="+number;
    $link = "<?=base_url();?>/arsipkeluarga/"+filename+"?v="+number;


    $('#iframe_view_file_jabatan').attr('src', $link)
        $('#iframe_view_file_jabatan').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })
  }

  function loadEditKeluarga(id){
              $('#edit_keluarga_pegawai').html('')
              $('#edit_keluarga_pegawai').append(divLoaderNavy)
              $('#edit_keluarga_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditKeluarga")?>'+'/'+id, function(){
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