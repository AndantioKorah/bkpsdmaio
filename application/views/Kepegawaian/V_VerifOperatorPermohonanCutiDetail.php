<?php if($result){ $dt = json_decode($result['meta_data'], true); ?>
  <div class="col-lg-12" style="padding: 1.5rem;">
    <div class="row">
      <div class="col-lg-12">
        <h3><?=$result['nm_cuti'].' '.getNamaPegawaiFull($result)?></h3>
        <h4><?=formatDateNamaBulan($dt['tanggal_mulai']).' s/d '.formatDateNamaBulan($dt['tanggal_akhir']).' ('.$dt['lama_cuti'].')'?></h4>
        <hr>
      </div>
      <div class="col-lg-12">
        <form id="form_verif_sisa_cuti">
          <div class="row">
            <?php if($result['id_cuti'] == 00){ ?>
              <div class="col-lg-6">
                <h5>PEMAKAIAN JATAH CUTI</h5>
                <table class="table table-sm" style="border: none !important;">
                  <?php foreach($dt['keterangan_cuti'] as $k => $v){ ?>
                    <tr>
                      <td style="width: 35%;">
                        <?=$k?>
                      </td>
                      <td style="width: 5%;">:</td>
                      <td style="width: 60%;">
                        <input style="font-size: 1rem;" readonly class="form-control form-control-sm" value="<?=$v?>" />
                      </td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
              <div class="col-lg-6">
                <h5>SISA CUTI</h5>
                <table class="table table-sm" style="border: none !important;">
                  <?php $sc = null; $i = 1; foreach($sisa_cuti as $kSc => $vSc){?>
                    <tr>
                      <td style="width: 35%;">
                        <?=$kSc?>
                      </td>
                      <td style="width: 5%;">:</td>
                      <td style="width: 60%;">
                        <input type="number" style="font-size: 1rem;" class="form-control form-control-sm" value="<?=$vSc['sisa']?>" id="sisa_cuti_<?=$kSc?>" name="sisa_cuti_<?=$kSc?>" />
                      </td>
                    </tr>
                  <?php $i++; } ?>
                </table>
              </div>
            <?php } ?>
              <div class="col-lg-12">
                <label>Keterangan</label>
                <textarea style="width: 100%;" name="keterangan" rows="3"></textarea>
              </div>
              <div class="col-lg-12 mt-3 text-right">
                <?php if($result['status_verifikasi'] == 0){ ?>
                  <button onclick="saveVerifikasi(1)" type="button" class="btn btn_verif btn-success"><i class="fa fa-check"></i> Terima</button>
                  <button onclick="saveVerifikasi(2)" type="button" class="btn btn_verif btn-danger"><i class="fa fa-times"></i> Tolak</button>
                  <button disabled class="btn btn_verif_loader btn-navy" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                <?php } else { ?>
                  <i><h6>Telah <?=$result['status_verifikasi'] == 1 ? "DISETUJUI" : "DITOLAK" ?> oleh <?=$result['nama_verifikator']?> pada <?=formatDateNamaBulanWT($result['tanggal_verif'])?> </h6></i>
                <?php } ?>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="col-lg-12 text-center">
    <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
  </div>
<?php } ?>

<script>
  $(function(){
    <?php $this->session->set_userdata('data_verif_sisa_cuti', $result); ?>
  })

  function saveVerifikasi(statusVerif){
    $('.btn_verif').hide()
    $('.btn_verif_loader').show()
    $.ajax({
      url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifOperatorCuti/")?>'+statusVerif,
      method: 'post',
      data : $('#form_verif_sisa_cuti').serialize(),
      success: function(data){
          let resp = JSON.parse(data)
          if(resp.code != 0){
            errortoast(resp.message)
            $('.btn_verif').show()
            $('.btn_verif_loader').hide()
          } else {
            successtoast(resp.message)
            $('#modal_detail_cuti').modal('hide')
            $('#form_search').submit()
          }
      }, error: function(e){
          errortoast('Terjadi Kesalahan')
          $('.btn_verif').show()
          $('.btn_verif_loader').hide()
      }
    })
  }
</script>