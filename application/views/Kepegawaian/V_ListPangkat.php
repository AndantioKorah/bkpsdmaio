<?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <!-- <tr><button class="btn"><i class="fa fa-plus" ></i> Tambah</button></tr> -->
      
      <table class="table table-hover datatable">
        <thead>
        <th class="text-left">No</th>
         
          <th class="text-left">Jenis</th>
          <th class="text-left">Pangkat, Gol/Ruang</th>
          <th class="text-left">TMT Pangkat</th>
          <th class="text-left">Pejabat</th>
          <th class="text-left">Masa Kerja</th>
          <th class="text-left">No. SK</th>
          <th class="text-left">Tanggal SK</th>
          <th class="text-left">Dokumen</th>
          <th></th>
         
       
          <?php if($kode == 2) { ?>
            <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ 
          ?>
          
            <tr  style="background-color:<?php if($rs['status'] == 1) echo '#e3ab3b'; else if($rs['status'] == 3) echo '#f98080'; else echo '';?>"  class="">
              <td class="text-left"><?=$no++;?></td>
            
              <td class="text-left"><?=$rs['nm_jenispengangkatan']?></td>
              <td class="text-left"><?=$rs['nm_pangkat']?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tmtpangkat'])?></td>
              <td class="text-left"><?=strtoupper($rs['pejabat'])?></td>
              <td class="text-left"><?=$rs['masakerjapangkat']?></td>
              <td class="text-left"><?=($rs['nosk'])?></td>
              <td class="text-left"><?=formatDateNamaBulan($rs['tglsk'])?></td>

              <td class="text-left">
              <?php if($rs['gambarsk'] != "") { ?>
                <button href="#modal_view_file" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                <i class="fa fa-file-pdf"></i></button> 
                
                <?php } ?>
              </td>
           
                <td>

                <div class="btn-group" role="group" aria-label="Basic example">

                <?php if($rs['status'] == 1) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                data-nm_jabatan="<?=$rs['nm_pangkat']?>"
                data-tmt_jabatan="<?=$rs['tmtpangkat']?>"
                href="#modal_edit_pangkat"
                onclick="loadEditPangkat('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPangkat btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
                <?php } ?>

                <?php if($kode == 1) { ?>
                  <?php if($this->general_library->getUserName() == $nip) { ?>
                <button 
                data-toggle="modal" 
                data-id="<?=$rs['id']?>"
                data-nm_jabatan="<?=$rs['nm_pangkat']?>"
                data-tmt_jabatan="<?=$rs['tmtpangkat']?>"
                href="#modal_edit_pangkat"
                onclick="loadEditPangkat('<?=$rs['id']?>')" title="Ubah Data" class="open-DetailPangkat btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
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
              <button onclick="deleteData('<?=$rs['id']?>','<?=$rs['gambarsk']?>',2 )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
               <?php } ?>
              </td>
              <?php  } ?>
              
              </tr>
            
          <?php  } ?>
        </tbody>
      </table>
    </div>
  </div>





  
 
<script>
  $(function(){
    $('.datatable').dataTable()
  })

  
  async function openFilePangkat(filename){

    $('#iframe_view_file').hide()
    $('.iframe_loader').show()  
    // $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    // $.ajax({
    //   url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
    //   method: 'POST',
    //   data: {
    //     'username': '<?=$this->general_library->getUserName()?>',
    //     'password': '<?=$this->general_library->getPassword()?>',
    //     'filename': 'arsipelektronik/'+filename
    //   },
    //   success: function(data){
    //     let res = JSON.parse(data)
    //     console.log(res.data)
    //     $(this).show()
    //     $('#iframe_view_file').attr('src', res.data)
    //     $('#iframe_view_file').on('load', function(){
    //       $('#iframe_loader').hide()
    //       $(this).show()
    //     })
    //   }, error: function(e){
    //       errortoast('Terjadi Kesalahan')
    //   }
    // })
    var number = Math.floor(Math.random() * 1000);
    $link = "http://siladen.manadokota.go.id/bidik/arsipelektronik/"+filename+"?v="+number; 
    $('#iframe_view_file').attr('src', $link)
    $('#iframe_view_file').on('load', function(){
      $('.iframe_loader').hide()
      $(this).show()
    })
  }

  // function openFilePangkatbu1(filename) async () => {
  //   const response = await fetch('http://siladen.manadokota.go.id/bidik/api/api/getDokumen', {
  //     method: 'POST',
  //     body: {
  //       username: 'prog',
  //       password: '742141189Bidik.',
  //       filename: 'arsipelektronik/'.filename
  //     }, // string or object
  //     headers: {
  //       'Content-Type': 'application/json'
  //     }
  //   });
  //   const myJson = await response.json(); //extract JSON from the http response
  //   console.log(myJson);
  // }

  // function openFilePangkat(filename){
  
  //   $('#iframe_view_file').attr('src', filename)
  //   $('#iframe_view_file').on('load', function(){
  //     $('#iframe_loader').hide()
  //         $(this).show()
  //       })
  // }


  function deleteData(id,file,kode){
                   
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpangkat/'+file,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        if(kode == 1){
                          loadListPangkat()
                        } else {
                          loadRiwayatUsulListPangkat()

                        }
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }


        function loadEditPangkat(id){
 
        $('#edit_pangkat_pegawai').html('')
        $('#edit_pangkat_pegawai').append(divLoaderNavy)
        $('#edit_pangkat_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditPangkaPegawai")?>'+'/'+id, function(){
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