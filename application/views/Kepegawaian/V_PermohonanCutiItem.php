<style>
  .lbl_status_pengajuan_1, .lbl_status_pengajuan_2{
    padding: 5px;
    border-radius: 5px;
    background-color: yellow;
    font-weight: bold;
    font-size: .7rem;
  }

  .lbl_status_pengajuan_3, .lbl_status_pengajuan_5{
    padding: 5px;
    border-radius: 5px;
    background-color: red;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }

  .lbl_status_pengajuan_4{
    padding: 5px;
    border-radius: 5px;
    background-color: green;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }

  .lbl_status_pengajuan_6{
    padding: 5px;
    border-radius: 5px;
    background-color: #0077af;
    font-weight: bold;
    font-size: .7rem;
    color: white;
  }

  .badge{
    max-width: 15vw;
  }
</style>
<table class="table table-hover table-striped" id="table_riwayat_cuti">
  <thead>
    <th class="text-center">No</th>
    <th class="text-center">Jenis Cuti</th>
    <th class="text-center">Tanggal Pengajuan</th>
    <th class="text-center">Tanggal Cuti</th>
    <th class="text-left">Lama Cuti</th>
    <th class="text-center">Status</th>
    <th class="text-center">Pilihan</th>
  </thead>
  <tbody>
    <?php if($result){
      $no = 1;
      foreach($result as $rs){
    ?>
      <tr>
        <td class="text-center"><?=$no++;?></td>
        <td class="text-center"><?=$rs['nm_cuti']?></td>
        <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
        <td class="text-center"><?=formatDateNamaBulan($rs['tanggal_mulai']).' - '.formatDateNamaBulan($rs['tanggal_akhir'])?></td>
        <td class="text-left"><?=$rs['lama_cuti'].' hari'?></td>
        <td style="width: 25%;" class="text-center">
          <?php
            $statusPengajuanCuti = $rs['status_pengajuan_cuti'];
            $badge = "badge-warning";
<<<<<<< HEAD
            if($rs['flag_ds_cuti'] == 1){
=======
            if(isset($rs['flag_ds_cuti']) && $rs['flag_ds_cuti'] == 1){
>>>>>>> 8f3a18ef1f18ab2c4b0e80fc1f221ea03c64c89e
              $badge = "badge-success";
              $rs['status_pengajuan_cuti'] = "Selesai";
              $statusPengajuanCuti = $rs['status_pengajuan_cuti'];
            } else if((isset($rs['flag_ditolak']) && $rs['flag_ditolak'] == 1) || isset($rs['flag_operator_verif']) && $rs['status_verifikasi_operator'] == 2){
              $badge = "badge-danger";
              $statusPengajuanCuti = "Ditolak, ".$statusPengajuanCuti;
            } else {
              $rs['status_pengajuan_cuti'] = "Menunggu ".$rs['status_pengajuan_cuti'];
              $statusPengajuanCuti = $rs['status_pengajuan_cuti'];
            }
            // if(stringStartWith("Digital Signature", $rs['status_pengajuan_cuti'])){
            //   if($rs['flag_ds_cuti'] == 1){
            //     $badge = "badge-success";
            //     $rs['status_pengajuan_cuti'] = "Selesai";
            //   } else {
            //     $rs['status_pengajuan_cuti'] = "Menunggu ".$rs['status_pengajuan_cuti'];
            //   }
            // } else if((isset($rs['flag_ditolak']) && $rs['flag_ditolak'] == 1) || isset($rs['flag_operator_verif']) && $rs['status_verifikasi_operator'] == 2){
            //   $badge = "badge-danger";
            //   $statusPengajuanCuti = "Ditolak, ".$statusPengajuanCuti;
            // }
          ?>
          <span style="text-wrap: pretty;" class="badge <?=$badge?>"><?=($statusPengajuanCuti)?></span></td>
        <td class="text-center">
          <?php if(!isset($rs['flag_operator_verif'])){ ?>
            <button type="button" href="#modal_detail_cuti" onclick="loadDetailCuti('<?=$rs['id']?>')"
            data-toggle="modal" class="btn btn-sm btn-navy">Detail</button>
            <?php
                // if(!$rs['id_progress_cuti']){
                if((!$rs['id_t_nomor_surat'] && $rs['flag_ds_cuti'] != 1) || ($rs['id_t_nomor_surat'] && $rs['flag_active_usul_ds'] != 1)){ // jika belum input nomor surat dan belum selesai, bisa dihapus
            ?>
              <button onclick="deletePermohonanCuti('<?=$rs['id']?>')" type="button" class="btn btn-sm btn-danger">Hapus </button>
            <?php } ?>
          <?php } else { ?>
            <?php if(isset($rs['status_verifikasi_operator']) && $rs['status_verifikasi_operator'] == 0){ ?>
              <button onclick="deleteOperatorPermohonanCuti('<?=$rs['id']?>')" type="button" class="btn btn-sm btn-danger">Hapus</button>
            <?php } ?>
          <?php } ?>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
<div class="modal fade" id="modal_detail_cuti" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-md">
		<div class="modal-content" id="content_modal_detail_cuti">
		</div>
	</div>
</div>
<script>
  $(function(){
    $('#table_riwayat_cuti').dataTable()
  })

  function loadDetailCuti(id){
    $('#content_modal_detail_cuti').html('')
    $('#content_modal_detail_cuti').append(divLoaderNavy)
    $('#content_modal_detail_cuti').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCuti/')?>'+id, function(){
      $('#loader').hide()
    })
  }

  function deletePermohonanCuti(id){
    if(confirm('Apakah Anda yakin ingin menghapus data permohonan cuti?')){
      $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/deletePermohonanCuti/")?>'+id,
        method:"POST",  
        data: [],
        success: function(res){
          successtoast('Data berhasil dihapus')
          window.location=""
        }, error: function(err){
          errortoast('Terjadi Kesalahan')
        }
      })
    }
  }

  function deleteOperatorPermohonanCuti(id){
    if(confirm('Apakah Anda yakin ingin menghapus data permohonan cuti?')){
      $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteOperatorPermohonanCuti/")?>'+id,
        method:"POST",  
        data: [],
        success: function(res){
          successtoast('Data berhasil dihapus')
          window.location=""
        }, error: function(err){
          errortoast('Terjadi Kesalahan')
        }
      })
    }
  }
</script>