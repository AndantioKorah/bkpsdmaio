<style>
  .tr_selesai{
    display: none;
  }
</style>

<div class="row">
  <?php if($param['status'] == 'belum_upload_file_ds'){ ?>
    <div class="colg-lg-12 text-right">
      <button id="button_download_all" class="btn btn-success"><i class="fa fa-download"></i> Download All File</button>
      <button style="display: none;" id="button_download_all_loading" class="btn btn-success"><i class="fa fa-spin fa-spinner"></i> Mohon menunggu...</button>
    </div>
  <?php } ?>
  <div class="col-lg-12 mt-3 table-responsive">
    <!-- <div style="cursor: pointer;" class="form-check float-right text-right mb-5">
      <input style="cursor: pointer; width: 25px; height: 25px;" class="form-check-input" type="checkbox" value="" id="checkTampilSemua">
      <label style="cursor: pointer; padding: 5px; font-size: 1rem;" class="form-check-label" for="checkTampilSemua">
        Tampilkan Semua
      </label>
    </div> -->
    <table class="table table-hover table-striped" id="table_res">
      <thead>
        <th class="text-center">No</th>
        <th class="text-center">Pegawai</th>
        <th class="text-center">Tanggal Cuti</th>
        <th class="text-center">Tanggal Usul</th>
        <th class="text-center">Tanggal Verif</th>
        <th class="text-center">Status</th>
        <th class="text-center">Pilihan</th>
      </thead>
      <tbody>
        <?php $filenames = null;
        if($result){ $no = 1; foreach($result as $rs){
          if($rs['flag_ds_manual'] == 0){
            $filenames[] = $rs['url_sk'];
          } else {
            $filenames[] = $rs['url_sk_manual'];
          }
          $classSelesai = "";
          $status = "";
          $status_pengajuan_cuti = $rs['status_pengajuan_cuti'];
          $class = "badge badge-danger";
          if($rs['nomor_surat'] == null){
            $status = "Nomor Surat belum diinput";
          } else {
            if($rs['flag_ds_cuti'] == 0){
              $class = "badge badge-warning";
              $status = "File DS belum diupload";
            } else {
              $status_pengajuan_cuti = "Selesai";
              $status = "File DS sudah diupload";
              $class = "badge badge-success";
              $classSelesai = "tr_selesai";
            }
          }
        ?>
          <!-- <tr class="<?=$classSelesai?>"> -->
          <tr>
            <td class="text-center"><?=$no++;?></td>
            <td class="text-left">
              <span><?=getNamaPegawaiFull($rs)?></span><br>
              <span style="color: grey; font-weight: bold; font-size: .75rem;">NIP. <?=$rs['nipbaru_ws']?></span>
            </td>
            <td class="text-center">
              <?php 
                $tanggal_cuti_raw = formatDateNamaBulan($rs['tanggal_mulai']);
                if($rs['tanggal_mulai'] != $rs['tanggal_akhir']){
                  $tanggal_cuti_raw = $tanggal_cuti_raw.' - '.formatDateNamaBulan($rs['tanggal_akhir']);
                }
              ?>
              <?=$tanggal_cuti_raw?>
            </td>
            <td class="text-center"><?=formatDateNamaBulanWT($rs['created_date'])?></td>
            <td class="text-center"><?=formatDateNamaBulanWT($rs['tanggal_verif'])?></td>
            <td class="text-center">
              <?=$status_pengajuan_cuti?><br>
              <span class="<?=$class?>"><?=$status?></span>
            </td>
            <td class="text-center">
              <button href="#modal_nomor_surat_manual" data-toggle="modal" class="btn btn-sm btn-warning"
              onclick="openModalPenomoranSkCuti('<?=$rs['id']?>')">
              <i class="fa fa-edit"></i> Edit</button>
            </td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="modal_nomor_surat_manual" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">INPUT NOMOR SURAT SK CUTI</h6>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_nomor_surat_manual_content">
          </div>
      </div>
  </div>
</div>

<script>
  $(function(){
    $('#table_res').dataTable()
  })

  function openModalPenomoranSkCuti(id){
    $('#modal_nomor_surat_manual_content').html('')
    $('#modal_nomor_surat_manual_content').append(divLoaderNavy)
    $('#modal_nomor_surat_manual_content').load('<?=base_url('kepegawaian/C_Kepegawaian/openModalPenomoranSkCuti/')?>'+id, function(){
      $('#loader').hide()
    })
  }

  $('#button_download_all').on('click', function(){
    $('#button_download_all_loading').show()
    $('#button_download_all').hide()
    $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/downloadAllSkCuti")?>',
        method: 'post',
        data: {
          filenames:  '<?=json_encode($filenames)?>'
        },
        success: function(data){
          $('#button_download_all').show()
          $('#button_download_all_loading').hide()
        }, error: function(e){
          errortoast('Terjadi Kesalahan')
          $('#button_download_all').show()
          $('#button_download_all_loading').hide()
        }
    })
  })

  $('#checkTampilSemua').on('change', function(){
    if($(this).is(':checked')){
      $('.tr_selesai').show()
    } else {
      $('.tr_selesai').hide()
    }
  })
</script>