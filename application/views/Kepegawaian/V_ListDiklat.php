<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Jenis Diklat</th>
          <th class="text-left">Jenjang Diklat</th>
          <th class="text-left">Nama Diklat</th>
          <th class="text-left">Tempat Diklat</th>
          <th class="text-left">Penyelenggara</th>
          <th class="text-left">Angkatan</th>
          <th class="text-left">Jam</th>
          <th class="text-left">Tanggal Mulai / Tanggal Selesai</th>
          <th class="text-left">No / Tanggal STTPP</th>
          <th class="text-left">Sertifikat STTPP</th>
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
              <td class="text-left"><?=$rs['nm_jdiklat']?></td>
              <td class="text-left"><?=$rs['jenjang_diklat']?></td>
              <td class="text-left"><?=$rs['nm_diklat']?></td>
              <td class="text-left"><?=$rs['tptdiklat']?></td>
              <td class="text-left"><?=$rs['penyelenggara']?></td>
              <td class="text-left"><?=$rs['angkatan']?></td>
              <td class="text-left"><?=$rs['jam']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglmulai'])?> / <?= formatDateNamaBulan($rs['tglselesai'])?></td>
              <td class="text-left"><?=$rs['nosttpp']?> / <?=formatDateNamaBulan($rs['tglsttpp'])?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_diklat" onclick="openFileDiklat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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
                href="#modal_edit_diklat"
                onclick="loadEditDiklat('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailDiklat btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>
                <?php } ?>

                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              </td>
               <?php } ?>
               <?php } ?>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
                <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'ditolak : '.$rs['keterangan']; else echo '';?></td>

              <td>
              <?php if($rs['status'] == 1) { ?>
                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <input style="width:100px;" class="form-control " id="ket_verif_<?=$rs['id']?>"/>&nbsp;
                <div class="btn-group" role="group" aria-label="Basic example">
                <button onclick="verifDokumen(2, '<?=$rs['id']?>','db_pegawai.pegdiklat','<?=$rs['id_peg']?>')"  class="btn btn-sm btn-success" title="Terima"><i class="btn_verif_<?=$rs['id']?>  fa fa-check"></i></button>
                <button onclick="verifDokumen(3, '<?=$rs['id']?>','db_pegawai.pegdiklat','<?=$rs['id_peg']?>')"  class="btn btn-sm btn-warning" title="Tolak"><i class="btn_tolak_<?=$rs['id']?> fa fa-times"></i></button>
                <?php } ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } else { ?>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <button onclick="verifDokumen(1, '<?=$rs['id']?>','db_pegawai.pegdiklat','<?=$rs['id_peg']?>')"  class="btn btn-sm btn-dark" title="Batal Verif"><i class="btn_tolak_<?=$rs['id']?> fa fa-times"></i></button>
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

  // function openFilePangkat(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_diklat').attr('src', '<?=base_url();?>arsipdiklat/'+filename)
  // }


  async function openFileDiklat(filename){

    $('#iframe_view_file_diklat').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')

    // $.ajax({
      
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //    'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsipdiklat/'+filename
    //     // 'filename': 'arsipdiklat/1010131diklat prajab.pdf'
        
    //   },
      
      
    //   success: function(data){
    //     let res = JSON.parse(data)
    //     console.log(res.data)

    //     if(res == null){
    //       $('iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK')
    //     }

    //     $('#iframe_view_file_diklat').attr('src', $link)
    //     $('#iframe_view_file_diklat').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })
    var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsipdiklat/"+filename+"?v="+number;
    $link = "<?=base_url();?>/arsipdiklat/"+filename+"?v="+number;

    $('#iframe_view_file_diklat').attr('src', $link)
        $('#iframe_view_file_diklat').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdiklat/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListDiklat()
                               } else {
                                loadRiwayatUsulDiklat()
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
                  loadListDiklat()
                  loadRiwayatUsulDiklat()
                } else {
                    errortoast(rs.message)
                }
              
            }, error: function(e){
               
                errortoast('Terjadi Kesalahan')
            }
        })
    }

     function loadEditDiklat(id){
              $('#edit_diklat_pegawai').html('')
              $('#edit_diklat_pegawai').append(divLoaderNavy)
              $('#edit_diklat_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditDiklat")?>'+'/'+id, function(){
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