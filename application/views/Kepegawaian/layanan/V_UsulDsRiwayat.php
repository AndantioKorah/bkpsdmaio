<table class="table table-hover" id="table_riwayat_usul_ds">
  <thead>
    <th class="text-center">No</th>
    <?php if($this->general_library->isProgrammer()){ ?>
      <th class="text-center">Nama Pegawai</th>
    <?php } ?>
    <th class="text-center">Jenis Layanan</th>
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
          <div style="
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 25vw;
          ">
            <span title="<?=$rs['id_m_jenis_layanan'] == 104 ? $rs['nama_layanan'] : $rs['nama_layanan'].' / '.$rs['keterangan']?>">
              <?=$rs['id_m_jenis_layanan'] == 104 ? $rs['nama_layanan'] : $rs['nama_layanan'].' / '.$rs['keterangan']?>
            </span>
          </div>
        </td>
        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td class="text-center"><?=$rs['jumlah_dokumen']?></td>
        <td class="text-center">
          <button class="btn btn-navy" href="#modal_detail" onclick="openDetailModal('<?=$rs['id']?>')"><i class="fa fa-detail"></i> Detail</button>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
  $(function(){{
    $('#table_riwayat_usul_ds').dataTable()
  }})

  function openDetailModal(id){
    $('#modal_detail').modal('show')
    $('#modal_detail_content').html('')
    $('#modal_detail_content').append(divLoadernavy)
    $('#modal_detail_content').load('<?=base_url("kepegawaian/C_Layanan/loadDetailUsulDs/")?>'+id, function(){
      $('#loader').hide()
    })
  }
</script>