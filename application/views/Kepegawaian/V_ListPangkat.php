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
                <button href="#modal_view_file" onclick="openFilePangkat('<?=$rs['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Lihat <i class="fa fa-search"></i></button>
              </td>
              <?php if($kode == 2) { ?>
                <td><?=formatDateNamaBulan($rs['created_date'])?></td>
              <td><?php if($rs['status'] == 1) echo 'Menunggu Verifikasi BKPSDM'; else if($rs['status'] == 3) echo 'Di Tolak : '.$rs['keterangan']; else echo '';?></td>
              <td>
              <?php if($rs['status'] == 1) { ?>
              <button onclick="deleteKegiatan('<?=$rs['id']?>','<?=$rs['gambarsk']?>' )" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
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

  function openFilePangkat(filename){
    var nip = "<?=$this->general_library->getUserName()?>";
    $('#iframe_view_file').attr('src', '<?=base_url();?>arsipelektronik/'+filename)
  }


  function deleteKegiatan(id,file){
                   
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
                $.ajax({
                    url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegpangkat/'+file,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadRiwayatUsulListPangkat()
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