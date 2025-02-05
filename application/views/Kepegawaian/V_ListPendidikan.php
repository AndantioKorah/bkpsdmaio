<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">

  

<script>
  
</script>
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Ijazah Saat Melamar CPNS</th>
          <th class="text-left">Tingkat Pendidikan</th>
          <th class="text-left">Nama Sekolah</th>
          <th class="text-left">Fakultas</th>
          <th class="text-left">Jurusan</th>
          <th class="text-left">Nama Pimpinan</th>
          <th class="text-left">Tahun Lulus</th>
          <th class="text-left">No. STTB/Ijazah</th>
          <th class="text-left">Tgl STTB/Ijazah</th>
          <th class="text-left">Ijazah</th>
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
              <td class="text-left">
              <div class="form-check">
              <input <?= $rs['ijazah_cpns'] == '1' ? 'checked' : ''; ?>
               onclick="pilihIjazah('<?=$rs['id']?>','<?=$rs['id_peg']?>')" type="radio" class="radio" value="1" name="fooby[1][]" 
               <?php if($this->general_library->getUserName() != $nip) echo "disabled"; else echo "";?> /></label>
            </div>
              </td>
              <td class="text-left"><?=$rs['nm_tktpendidikan']?></td>
           
              <td class="text-left"><?=$rs['namasekolah']?></td>
              <td class="text-left"><?=$rs['fakultas']?></td>
              <td class="text-left"><?=$rs['jurusan']?></td>
              <td class="text-left"><?=$rs['pimpinansekolah']?></td>
              <td class="text-left"><?=$rs['tahunlulus']?></td>
              <td class="text-left"><?=$rs['noijasah']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tglijasah'])?></td>
              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_pendidikan" onclick="openFilePendidikan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_pendidikan"
                onclick="loadEditPendidikan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPendidikan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button>
                <?php } ?>

                <?php if($kode == 1) { ?>
                <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip) { ?>
                
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                href="#modal_edit_pendidikan"
                onclick="loadEditPendidikan('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPendidikan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
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
                <td>
                  <?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'Di Tolak : '.$rs['keterangan']; else echo '';?></td>
              <td >
              <?php if($rs['status'] == 1) { ?>
                <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                <input style="width:100px;" class="form-control " id="ket_verif_<?=$rs['id']?>"/>&nbsp;
                <div class="btn-group" role="group" aria-label="Basic example">
                <button onclick="verifDokumen(2, '<?=$rs['id']?>','db_pegawai.pegpendidikan','<?=$rs['id_peg']?>')"  class="btn_verif_<?=$rs['id']?> btn btn-sm btn-success" title="Terima"><i class="  fa fa-check"></i></button>
                <button onclick="verifDokumen(3, '<?=$rs['id']?>','db_pegawai.pegpendidikan','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?> btn btn-sm btn-warning" title="Tolak"><i class=" fa fa-times"></i></button>
                <button disabled style="display: none;" id="btn_loading_<?=$rs['id']?>" class="btn btn-sm btn-info"><i class="fa fa-spin fa-spinner"></i></button>
               
                <?php } ?>
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
              <?php } else { ?>
              <?php  if($this->general_library->isHakAkses('verifikasi_pendataan_mandiri') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <button onclick="verifDokumen(1, '<?=$rs['id']?>','db_pegawai.pegpendidikan','<?=$rs['id_peg']?>')"  class="btn_tolak_<?=$rs['id']?>  btn btn-sm btn-dark" title="Batal Verif"><i class="fa fa-times"></i></button>
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



  <!-- <div class="modal fade" id="modal_view_file_pendidikan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_pendidikan" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>      -->
 


  

<script>
  $(function(){
    $('.datatable').dataTable()
  })

  // function openFilePendidikan(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   $('#iframe_view_file_pendidikan').attr('src', '<?=base_url();?>arsippendidikan/'+filename)
  // }


  async function openFilePendidikan(filename){
    $('#iframe_view_file_pendidikan').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs")?>',
    //   method: 'POST',
    //   data: {
    //     'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsippendidikan/'+filename
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)


    //     if(res == null){
    //       $('.iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK Gaji Berkala')
    //     }

    //     $('#iframe_view_file_pendidikan').attr('src', res.data)
    //     $('#iframe_view_file_pendidikan').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })


    var number = Math.floor(Math.random() * 1000);
    // $link = "http://siladen.manadokota.go.id/bidik/arsippendidikan/"+filename+"?v="+number;
    $link = "<?=base_url();?>/arsippendidikan/"+filename+"?v="+number;

    
  $('#iframe_view_file_pendidikan').attr('src', $link)
  
      $('#iframe_view_file_pendidikan').on('load', function(){
        $('.iframe_loader').hide()
        $(this).show()
  })

  }


  
  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpendidikan/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(kode == 1){
                                loadListPendidikan()

                               } else {
                                loadRiwayatUsulPendidikan()

                               }
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

    
        function loadEditPendidikan(id){
              $('#edit_pendidikan_pegawai').html('')
              $('#edit_pendidikan_pegawai').append(divLoaderNavy)
              $('#edit_pendidikan_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditPendidikan")?>'+'/'+id, function(){
                $('#loader').hide()
              })
         }

      function verifDokumen(status, id, tabel,id_peg){
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
                  loadListPendidikan()
                  loadRiwayatUsulPendidikan()
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


    $("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
  // alert($(this).val())

 
  // $.ajax({
  //                          url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpendidikan/'+file,
  //                          method: 'post',
  //                          data: null,
  //                          success: function(){
  //                              successtoast('Data sudah terhapus')
  //                              if(kode == 1){
  //                               loadListPendidikan()

  //                              } else {
  //                               loadRiwayatUsulPendidikan()

  //                              }
  //                          }, error: function(e){
  //                              errortoast('Terjadi Kesalahan')
  //                          }
  //                      })
 

});

function pilihIjazah(id,id_pegawai){

   $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/checkListIjazahCpns/")?>'+id+'/'+id_pegawai,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Berhasil ubah data')
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
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