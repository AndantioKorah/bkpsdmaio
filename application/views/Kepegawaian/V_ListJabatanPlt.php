<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-hover datatable">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Nama Jabatan</th>
          <th class="text-left">TMT Jabatan</th>
          <th class="text-left">Eselon</th>
          <th class="text-left">Angkat Kredit</th>
          <th class="text-left">Unit Kerja</th>
          <th class="text-left">No / Tanggal SK</th>
          <th class="text-left">Status Jabatan</th>
          <th class="text-left">Ket</th>
          <th class="text-left">File SK</th>
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
              <td class="text-left"><?=$rs['nama_jabatan']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tmtjabatan'])?></td>
              <td class="text-left"><?=$rs['nm_eselon']?></td>
              <td class="text-left"><?=$rs['angkakredit']?></td>
              <td class="text-left"><?=$rs['skpd']?></td>
              <td class="text-left"><?=$rs['nosk']?> / <?= formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left">
                <?php
                   if($rs['statusjabatan'] == 1) {
                    echo "Definitif"; 
                  } else if($rs['statusjabatan'] == 2) {
                    echo "Plt"; 
                  } else if($rs['statusjabatan'] == 3) {
                    echo "Plh"; 
                  }
                ?>
              </td>
              <td class="text-left"><?=$rs['ket']?></td>
              <td class="text-left"> 
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file_jabatan" onclick="openFileJabatan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                 <i class="fa fa-file-pdf"></i></button>
              <?php } ?>
              </td>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
              <td>
              <?php if($kode == 1) { ?>
                <div class="btn-group" role="group" aria-label="Basic example">
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                data-nm_jabatan="<?=$rs['nama_jabatan']?>"
                data-tmt_jabatan="<?=$rs['tmtjabatan']?>"
                data-skpd="<?=$rs['skpd']?>"
                href="#modal_edit_jabatan"
                onclick="editData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" title="Ubah Data" class="open-DetailJabatan btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',1 )" title="Hapus Data"  class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              </div>
             

              <?php } ?>
              </td>
               <?php } ?>
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


<!-- Modal -->
<div class="modal fade" id="modal_edit_jabatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Jabatan</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_edit_jabatan" enctype="multipart/form-data" >
      <input type="hidden" class="form-control" id="edit_jabatan_id" name="edit_jabatan_id">
  <div class="mb-3">
    <label class="form-label">Nama Jabatan</label>
    <input autocomplete="off" type="text" class="form-control" id="edit_jabatan_nama" name="edit_jabatan_nama">
  </div>
  <div class="mb-3">
    <label  class="form-label">TMT Jabatan</label>
    <input type="text" class="form-control datepicker" id="edit_jabatan_tmt" name="edit_jabatan_tmt">
  </div>

  <div class="mb-3">
    <label class="form-label">Unit Kerja</label>
    <input type="text" class="form-control" id="edit_jabatan_skpd" name="edit_jabatan_skpd">

  </div>

  <button  class="btn btn-primary float-right">Simpan</button>
</form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
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

  $(document).on("click", ".open-DetailJabatan", function () {
     var id = $(this).data('id');
     var nm_jabatan = $(this).data('nm_jabatan');
     var tmt_jabatan = $(this).data('tmt_jabatan');
     var skpd = $(this).data('skpd');
     
     $(".modal-body #edit_jabatan_id").val( id );
     $(".modal-body #edit_jabatan_nama").val( nm_jabatan );
     $(".modal-body #edit_jabatan_tmt").val( tmt_jabatan );
     $(".modal-body #edit_jabatan_skpd").val( skpd );
    //  $(".modal-body #nama_pegawai").html( nama_pegawai );
    //  $(".modal-body #nip").html( nip );
    });

    $('#form_edit_jabatan').on('submit', function(e){  

      e.preventDefault();
      var formvalue = $('#form_edit_jabatan');
      var form_data = new FormData(formvalue[0]);

      $.ajax({  
      url:"<?=base_url("kepegawaian/C_Kepegawaian/updateJabatanPeg")?>",
      method:"POST",  
      data:form_data,  
      contentType: false,  
      cache: false,  
      processData:false,  
      // dataType: "json",
      success:function(res){ 
          console.log(res)
          var result = JSON.parse(res); 
          console.log(result)
          if(result.success == true){
              successtoast(result.msg)
              setTimeout(function() {$("#modal_dismis").trigger( "click" );}, 1500);
              // setTimeout(loadListJabatan, 1500);
              location.reload();
             
            } else {
              errortoast(result.msg)
              return false;
            } 
          
      }  
      });  
        
      }); 

  // function openFileJabatan(filename){
  //   var nip = "<?=$this->general_library->getUserName()?>";
  //   // $('#iframe_view_file_jabatan').attr('src', '<?=base_url();?>arsipjabatan/'+filename)
  //   $('#iframe_view_file_jabatan').attr('src', 'http://simpegserver/adm/arsipjabatan/'+filename)
  // }


  async function openFileJabatan(filename){
    $('#iframe_view_file_jabatan').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //    'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsipjabatan/'+filename
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)


    //     if(res == null){
    //       $('iframe_loader').show()  
    //       $('.iframe_loader').html('Tidak ada file SK')
    //     }

    //     $('#iframe_view_file_jabatan').attr('src', res.data)
    //     $('#iframe_view_file_jabatan').on('load', function(){
    //       $('.iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //     errortoast('Terjadi Kesalahan')
    //   }
    // })
    var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsipjabatan/"+filename+"?v="+number;


    $('#iframe_view_file_jabatan').attr('src', $link)
        $('#iframe_view_file_jabatan').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })
  }

  function deleteData(id,file,kode){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegjabatan/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                              if(kode == 1){
                                loadListJabatan()
                                location.reload()
                              } else {
                                loadRiwayatUsulJabatan()
                              }
                              
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