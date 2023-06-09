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
          <th class="text-left">Ket</th>
          <th class="text-left">File SK</th>
          <?php if($kode == 2) { ?>
          <th class="text-left">Tanggal Usul</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left">  </th>
          <?php } ?>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr class="<?php if($rs['status'] == 1) echo 'bg-warning'; else echo '';?>">

              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama_jabatan']?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['tmtjabatan'])?></td>
              <td class="text-left"><?=$rs['nm_eselon']?></td>
              <td class="text-left"><?=$rs['angkakredit']?></td>
              <td class="text-left"><?=$rs['skpd']?></td>
              <td class="text-left"><?=$rs['nosk']?> / <?= formatDateNamaBulan($rs['tglsk'])?></td>
              <td class="text-left"><?=$rs['ket']?></td>
              <td class="text-left">
                <button href="#modal_view_file_jabatan" onclick="openFileJabatan('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
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


  <div class="modal fade" id="modal_view_file_jabatan" data-backdrop="static">
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
        <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_file_jabatan" style="width: 100%; height: 80vh;" src=""></iframe>
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
  //   // $('#iframe_view_file_jabatan').attr('src', '<?=base_url();?>arsipjabatan/'+filename)
  //   $('#iframe_view_file_jabatan').attr('src', 'http://simpegserver/adm/arsipjabatan/'+filename)
  // }


  async function openFileJabatan(filename){
    $('#iframe_view_file_jabatan').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    console.log(filename)
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
      method: 'POST',
      data: {
        'username': <?=$this->general_library->getUserName()?>,
        'password': <?=$this->general_library->getPassword()?>,
        'filename': 'arsipjabatan/'+filename
      },
      success: function(data){
        let res = JSON.parse(data)


        if(res == null){
          $('#iframe_loader').show()  
          $('#iframe_loader').html('Tidak ada file SK Gaji Berkala')
        }

        $('#iframe_view_file_jabatan').attr('src', res.data)
        $('#iframe_view_file_jabatan').on('load', function(){
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
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegjabatan/'+file,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               loadRiwayatUsulJabatan()
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