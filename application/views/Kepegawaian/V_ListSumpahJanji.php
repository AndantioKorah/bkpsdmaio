<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Sumpah Janji</th>
          <th class="text-left">Yang Mengambil Sumpah</th>
          <th class="text-left">No Berita Acara </th>
          <th class="text-left">Tanggal Berita Acara</th>
          <th></th>
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
          <th></th>
            <?php } ?>
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
              <td class="text-left"><?=$rs['nm_sumpah']?></td>
              <td class="text-left"><?= $rs['pejabat']?></td>
              <td class="text-left"><?=$rs['noba']?></td>
              <td class="text-left"><?=$rs['tglba']?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_sumjan" onclick="openFileSumjan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
              <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_sumjan"
                onclick="loadEditSumjan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailOrganisasi btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
                <?php } ?>

                <?php if($kode == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_sumjan"
                onclick="loadEditSumjan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailSumjan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
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
                <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <input style="width:100px;" class="form-control " id="ket_verif_<?=$rs['id']?>"/>&nbsp;
                <div class="btn-group" role="group" aria-label="Basic example">
                <button onclick="verifDokumen(2, '<?=$rs['id']?>','db_pegawai.pegsumpah','<?=$rs['id_peg']?>')"  class="btn_verif_<?=$rs['id']?> btn btn-sm btn-success" title="Terima"><i class="  fa fa-check"></i></button>
                <button onclick="verifDokumen(3, '<?=$rs['id']?>','db_pegawai.pegsumpah','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-warning" title="Tolak"><i class=" fa fa-times"></i></button>
                <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
               
                <?php } ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } else { ?>
              <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <button onclick="verifDokumen(1, '<?=$rs['id']?>','db_pegawai.pegsumpah','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-dark" title="Batal Verif"><i class=" fa fa-times"></i></button>
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

  async function openFileSumjan(filename){
   $('#iframe_view_file_sumjan').hide()
   $('.iframe_loader').show()  
   console.log(filename)
  //  $.ajax({
  //    url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
  //    method: 'POST',
  //    data: {
  //      'username': '<?=$this->general_library->getUserName()?>',
  //      'password': '<?=$this->general_library->getPassword()?>',
  //      'filename': 'arsipsumpah/'+filename
  //    },
  //    success: function(data){
  //      let res = JSON.parse(data)
  //      console.log(res.data)
  //      $(this).show()
  //      $('#iframe_view_file_sumjan').attr('src', res.data)
  //      $('#iframe_view_file_sumjan').on('load', function(){
  //        $('.iframe_loader').hide()
  //        $(this).show()
  //      })
  //    }, error: function(e){
  //        errortoast('Terjadi Kesalahan')
  //    }
  //  })
  var number = Math.floor(Math.random() * 1000);
  // $link = "http://siladen.manadokota.go.id/bidik/arsipsumpah/"+filename+"?v="+number;
  $link = "<?=base_url();?>/arsipsumpah/"+filename+"?v="+number;

$('#iframe_view_file_sumjan').attr('src', $link)
    $('#iframe_view_file_sumjan').on('load', function(){
      $('.iframe_loader').hide()
      $(this).show()
})

 }


  function deleteData(id,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegsumpah/',
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListSumpahJanji()
                               } else {
                                loadRiwayatUsulSumpahJanji()
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
                  loadListSumpahJanji()
                  loadRiwayatUsulSumpahJanji()
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

        function loadEditSumjan(id){
              $('#edit_sumjan_pegawai').html('')
              $('#edit_sumjan_pegawai').append(divLoaderNavy)
              $('#edit_sumjan_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditSumjan")?>'+'/'+id, function(){
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