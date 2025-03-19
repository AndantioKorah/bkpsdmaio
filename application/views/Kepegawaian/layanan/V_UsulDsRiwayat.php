<style>
  .div_nama_layanan{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 25vw;
  }

  .div_nama_layanan:hover{
    white-space: wrap;
    width: 25vw;
    cursor: pointer;
  }
</style>

<table class="table table-hover" id="table_riwayat_usul_ds">
  <thead>
    <th class="text-center">No</th>
    <?php if($this->general_library->isProgrammer()){ ?>
      <th class="text-center">Nama Pegawai</th>
    <?php } ?>
    <th class="text-center">Jenis Layanan</th>
    <th class="text-center">Status</th>
    <th class="text-center">Tanggal Usul</th>
    <th class="text-center">Jumlah Dokumen</th>
    <th class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($result){ $no = 1; foreach($result as $rs){ ?>
      <tr>
        <td class="text-center"><?=$no++;?></td>
        <?php if($this->general_library->isProgrammer()){ ?>
          <td class="text-left"><?=$rs['nama_pegawai']?></td>
        <?php } ?>
        <td class="text-left">
          <div class="div_nama_layanan">
            <?=$rs['id_m_jenis_layanan'] == 104 ? $rs['nama_layanan'] : $rs['nama_layanan'].' / '.$rs['keterangan']?>
          </div>
        </td>
        <td class="text-center">
          <badge style="overflow: wrap; white-space: wrap;" class="badge <?=$rs['flag_done'] == 0 ? "badge-warning" : "badge-success"?>">
            <?=($rs['flag_done'] == 1 ? "Selesai" : "Belum Selesai")?>
          </badge>
        </td>
        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td class="text-center"><?=$rs['jumlah_dokumen']?></td>
        <td class="text-center">
          <button class="btn btn-navy btn-sm" href="#modal_detail" onclick="openDetailModal('<?=$rs['id']?>')"><i class="fa fa-list"></i> Detail</button>
          <?php if($rs['flag_done'] == 0){ ?>
            <button class="btn btn-danger btn-sm" onclick="deleteData('<?=$rs['id']?>')"><i class="fa fa-trash"></i> Hapus</button>
          <?php } ?>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $(function(){
    $('#table_riwayat_usul_ds').dataTable()
  })

  function openDetailModal(id){
    $('#modal_detail').modal('show')
    $('#modal_detail_content').html('')
    $('#modal_detail_content').append(divLoaderNavy)
    $('#modal_detail_content').load('<?=base_url("kepegawaian/C_Layanan/loadDetailUsulDs/")?>'+id, function(){
      $('#loader').hide()
    })
  }

  function deleteData(id){
    if(confirm("Apakah Anda yakin ingin menghapus Usul DS tersebut?")){
      $.ajax({
        url: '<?=base_url("kepegawaian/C_Layanan/deleteUsulDs/")?>'+id,
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
          $('#modal_detail').modal('hide')
          $('#btn_refresh').click()
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
      })
    }
  }
</script>