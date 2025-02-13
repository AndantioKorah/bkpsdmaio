<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tahun</th>
          <th class="text-left">Nilai</th>
          <th class="text-left">Predikat</th>
          <th class="text-left">File</th>
          
          <?php if($kode == 2) { ?>
            <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Keterangan</th>
         
          <th class="text-left"> Pilihan </th>
          <?php } else { ?>
            <th></th>
            <th></th>
            <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left">
                <?=$rs['tahun']?><br>
                <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                  <?php if($rs['flag_from_siasn'] == 1){ ?> 
                    <span class="badge badge-info" title="Data yang disinkronisasi dari SIASN">SIASN</span><br>
                  <?php } ?>
                  <?php if($rs['id_siasn']){ ?> 
                    <span class="badge badge-success" title="Data ini sudah tersinkronisasi dengan SIASN"><i class="fa fa-check"></i> Sinkron SIASN</span>
                  <?php } else { ?>
                    <span class="badge badge-danger" title="Data ini belum tersinkronisasi dengan SIASN"><i class="fa fa-times"></i> Belum Sinkron SIASN</span>
                  <?php } ?>
                <?php } ?>
              </td>
              <td class="text-left"><?= $rs['nilai']?></td>          
              <td class="text-left"><?= $rs['predikat']?></td>   
              <td class="text-left">
                <?php if($rs['gambarsk'] != "") { ?>
                  <button href="#modal_view_file_skp" onclick="openFileSKP('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                  <i class="fa fa-file-pdf"></i></button>
                <?php } ?>
              </td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <?php if($kode == 1) { ?>
                <td>
              <!-- <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>  -->
              </td>
              <?php } ?>
               <?php } ?>
               <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo "ditolak : ".$rs['keterangan']; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
                <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <input style="width:100px;" class="form-control " id="ket_verif_<?=$rs['id']?>"/>&nbsp;
                <div class="btn-group" role="group" aria-label="Basic example">
                <button onclick="verifDokumen(2, '<?=$rs['id']?>','db_pegawai.pegskp','<?=$rs['id_peg']?>')"  class="btn_verif_<?=$rs['id']?> btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i></button>
                <button onclick="verifDokumen(3, '<?=$rs['id']?>','db_pegawai.pegskp','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-warning" title="Tolak"><i class=" fa fa-times"></i></button>
                <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
               
                <?php } ?>
                
                <button onclick="deleteDataSKP('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } else { ?>
              <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <button onclick="verifDokumen(1, '<?=$rs['id']?>','db_pegawai.pegskp','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-dark" title="Batal Verif"><i class=" fa fa-times"></i></button>
              <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
              <?php } ?>
              <?php } ?>
              </td>
              <?php } else { ?>
                <td>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_skp"
                onclick="loadEditSkp('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPenghargaan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
                
                <button onclick="deleteDataSKP('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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

  $("#myModalSkp").on('hide.bs.modal', function(){
    $("#pills-skp-tab").trigger( "click" )
  });


  // function openFileSKP(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_skp').attr('src', '<?=base_url();?>arsipskp/'+filename)
  // }

  async function openFileSKP(filename){
   
   $('#iframe_view_file_skp').hide()
   $('.iframe_loader').show()  
   console.log(filename)
  //  $.ajax({
  //    url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
  //    method: 'POST',
  //    data: {
  //      'username': '<?=$this->general_library->getUserName()?>',
  //      'password': '<?=$this->general_library->getPassword()?>',
  //      'filename': 'arsipskp/'+filename
  //    },
  //    success: function(data){
  //      let res = JSON.parse(data)
  //      console.log(res.data)
  //      $(this).show()
  //      $('#iframe_view_file_skp').attr('src', res.data)
  //      $('#iframe_view_file_skp').on('load', function(){
  //        $('.iframe_loader').hide()
  //        $(this).show()
  //      })
  //    }, error: function(e){
  //        errortoast('Terjadi Kesalahan')
  //    }
  //  })
  var number = Math.floor(Math.random() * 1000);
  //  $link = "http://siladen.manadokota.go.id/bidik/arsipskp/"+filename; 
   $link = "<?=base_url();?>/arsipskp/"+filename+"?v="+number;


$('#iframe_view_file_skp').attr('src', $link)
    $('#iframe_view_file_skp').on('load', function(){
      $('.iframe_loader').hide()
      $(this).show()
})


 }

  function deleteDataSKP(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegskp/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListSkp()
                               } else {
                                loadListSkp()
                                loadRiwayatUsulSkp()
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
                  loadListSkp()
                  loadRiwayatUsulSkp()
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

    function loadEditSkp(id){
              $('#edit_skp_pegawai').html('')
              $('#edit_skp_pegawai').append(divLoaderNavy)
              $('#edit_skp_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditSkp")?>'+'/'+id, function(){
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