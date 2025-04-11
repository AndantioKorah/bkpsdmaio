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
                  <?php foreach($sisa_cuti as $kSc => $vSc){ ?>
                    <tr>
                      <td style="width: 35%;">
                        <?=$kSc?>
                      </td>
                      <td style="width: 5%;">:</td>
                      <td style="width: 60%;">
                        <input type="number" style="font-size: 1rem;" class="form-control form-control-sm" value="<?=$vSc['sisa']?>" name="sisa_cuti_<?=$kSc?>" />
                      </td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
            <?php } ?>
            
              <div class="col-lg-12 mt-3 text-right">
                <?php if($result['status_verifikasi'] == 0){ ?>
                  <button id="btn_simpan" class="btn btn-navy" type="submit"><i class="fa fa-save"></i> Simpan</button>
                  <button id="btn_simpan_loading" disabled class="btn btn-navy" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
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
  $('#form_verif_sisa_cuti').on('submit', function(e){
    <?php $this->session->set_userdata('data_verif_sisa_cuti', $result); ?>
    e.preventDefault()
    $('#btn_simpan').hide()
    $('#btn_simpan_loading').show()
    $.ajax({
        url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifOperatorCuti")?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
            let resp = JSON.parse(data)
            if(resp.code != 0){
              errortoast(resp.message)
              $('#btn_simpan').show()
              $('#btn_simpan_loading').hide()
            } else {
              successtoast(resp.message)
              $('#modal_detail_cuti').modal('hide')
              $('#form_search').submit()
            }
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
            $('#btn_simpan').show()
            $('#btn_simpan_loading').hide()
        }
    })
  })
</script>