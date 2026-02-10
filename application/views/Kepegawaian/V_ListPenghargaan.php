<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Penghargaan</th>
          <th class="text-left">No. SK</th>
          <th class="text-left">Tgl SK</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Lingkup Penghargaan</th>
          <th></th>
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
              <td class="text-left"><?=$rs['nm_pegpenghargaan']?></td>
              <td class="text-left"><?=$rs['nosk']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?=$rs['tahun_penghargaan']?></td>
              <td class="text-left">

                <?php if($rs['lingkup_penghargaan'] == 1) echo "Penghargaan di lingkup Internasional";
                else if($rs['lingkup_penghargaan'] == 2) echo "Penghargaan di lingkup Nasional";
                else if($rs['lingkup_penghargaan'] == 3) echo "Penghargaan di lingkup lintas Instansi";
                else if($rs['lingkup_penghargaan'] == 4) echo "Penghargaan di lingkup Instansi";
                else echo "-";
                ?>
              
              </td>
              <td>
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_penghargaan" onclick="openFilePenghargaan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_penghargaan"
                onclick="loadEditPenghargaan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPenghargaan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
                <?php } ?>

              <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_penghargaan"
                onclick="loadEditPenghargaan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPenghargaan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>
                <?php } ?>

                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                  <button onclick="deleteData('<?=$rs['id']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>

              </div>
              
             
               
            </td>
            <?php } ?> 
               <?php } ?>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>

                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
                <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <input style="width:100px;" class="form-control " id="ket_verif_<?=$rs['id']?>"/>&nbsp;
                <div class="btn-group" role="group" aria-label="Basic example">
                <button onclick="verifDokumen(2, '<?=$rs['id']?>','db_pegawai.pegpenghargaan','<?=$rs['id_peg']?>')"  class="btn_verif_<?=$rs['id']?> btn btn-sm btn-success" title="Terima"><i class="  fa fa-check"></i></button>
                <button onclick="verifDokumen(3, '<?=$rs['id']?>','db_pegawai.pegpenghargaan','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-warning" title="Tolak"><i class=" fa fa-times"></i></button>
                <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
                
                <?php } ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } else { ?>
              <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <button onclick="verifDokumen(1, '<?=$rs['id']?>','db_pegawai.pegpenghargaan','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-dark" title="Batal Verif"><i class=" fa fa-times"></i></button>
              <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
              
              <?php } ?>
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


  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpenghargaan/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1) {
                                loadListPenghargaan()
                               } else {
                                loadRiwayatUsulPenghargaan()
                               }
                              
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

      function verifDokumen(status, id,tabel,id_peg){
        
        if(status == 3){
          if($('#ket_verif_'+id).val() == "" || $('#ket_verif_'+id).val() == null){
            errortoast('Alasan Tolak belum diisi')
            return false;
          }
        }
        $('.btn_verif_'+id).hide()
        $('.btn_tolak_'+id).hide()
        $('#btn_loading_'+id).show()
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/verifDokumenPdm")?>'+'/'+id+'/'+status,
            method: 'post',
            data: {
               id_pegawai: id_peg,
               tabel: tabel,
               keterangan: $('#ket_verif_'+id).val()
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                  loadListPenghargaan()
                  loadRiwayatUsulPenghargaan()
                  $('.btn_verif_'+id).show()
                  $('.btn_tolak_'+id).show()
                  $('#btn_loading_'+id).hide()
                } else {
                    errortoast(rs.message)
                }
              
            }, error: function(e){
               
                errortoast('Terjadi Kesalahan')
            }
        })
    }

               async function openFilePenghargaan(filename){

              $('#iframe_view_file_penghargaan').hide()
              $('.iframe_loader').show()  
              $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')

              var number = Math.floor(Math.random() * 1000);
              // $link = "http://siladen.manadokota.go.id/bidik/arsippenghargaan/"+filename+"?v="+number;
              $link = "<?=base_url();?>/arsippenghargaan/"+filename+"?v="+number;

              $('#iframe_view_file_penghargaan').attr('src', $link)
                  $('#iframe_view_file_penghargaan').on('load', function(){
                    $('.iframe_loader').hide()
                    $(this).show()
              })

              }
              

              function loadEditPenghargaan(id){
              $('#edit_penghargaan_pegawai').html('')
              $('#edit_penghargaan_pegawai').append(divLoaderNavy)
              $('#edit_penghargaan_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditPenghargaan")?>'+'/'+id, function(){
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