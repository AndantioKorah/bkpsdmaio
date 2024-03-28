<style>
  .header_title{
    font-weight: bold;
    padding: 0;
  }

  .sp_sign_count{
    color: #009900;
    font-size: 1rem;
    font-weight: bold;
  }

  @media only screen and (max-device-width: 640px) {
    .div_pdf_mobile{
      display: block;
    }

    .div_pdf_desktop{
      display: none;
    }
  }

  @media (pointer: fine), (pointer: none) {
    /* desktop */
    .div_pdf_mobile{
      display: none;
    }

    .div_pdf_desktop{
      display: block;
    }
  }
</style>
<div class="row mt-3 p-0">
  <div class="col-lg-12">
    <?php if($file_exists == 0){ ?>
      <div class="text-center">
        <h2 style="color: red; font-weight: bold;"><i class="fa fa-times"></i> FILE TIDAK DITEMUKAN</h2>
      </div>
    <?php } else {
      if($result){
      $header = 'DOKUMEN TERVERIFIKASI <i class="fa fa-check"></i>';
      $sub_header = $result['description'];
      $header_color = '#009900';
      if($result['conclusion'] != 'VALID'){
        $header = 'DOKUMEN TIDAK VALID <i class="fa fa-times"></i>';
        $header_color = '#cc2900';
      }
    ?>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 text-left">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="header_title card-header" style="padding-bottom: 5px; color: <?=$header_color?>"><?=$header?></h3>
              <h6 class="header_title card-subtitle text-muted" style="color: <?=$header_color?>"><?=$sub_header?></h6>
              <hr>
            </div>
            <div class="card-body" style="padding-top: 0;">
              <?php if($result['conclusion'] == 'VALID'){ ?>
                <div class="row">
                  <div class="col-lg-12" style="margin-top: -20px;">
                    <span class="sp_label sp_sign_count">Dokumen ini memiliki <?=$result['signatureCount'].' ('.trim(terbilang($result['signatureCount'])).') TTE'?></span>
                    <!-- <br><small>Klik untuk melihat detail TTE</small> -->
                    <div class="row mt-2">
                      <?php
                        for($i = 0 ; $i < $result['signatureCount'] ; $i++){
                          ?>
                            <div class="col">
                              <button data-toggle="collapse" href="#div_detail_signer_<?=$i+1?>" class="btn btn-info w-100">Signer #<?=$i+1;?></button>
                            </div>
                            <?php foreach($result['signatureInformations'] as $si){ ?>
                              <div style="display: <?=$i == 0 ? 'block' : 'none'?>" class="col-lg-12 mt-3">
                                <div class="card card-default" style="background-color: #d0ffd0;">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <table style="width: 100%;">
                                          <tr valign=top>
                                            <td style="width: 35%;">Ditandatangani oleh</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 60%;" class="fw-bold"><?=$si['signerName']?></td>
                                          </tr>
                                          <tr valign=top>
                                            <td style="width: 35%;">Tanggal Tanda Tangan</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 60%;" class="fw-bold"><?=formatDateNamaBulanWithTime($si['signatureDate'])?></td>
                                          </tr>
                                          <tr valign=top>
                                            <td style="width: 35%;">Lokasi</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 60%;" class="fw-bold"><?=$si['location'] == null ? '' : $si['location']?></td>
                                          </tr>
                                          <tr valign=top>
                                            <td style="width: 35%;">Alasan</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 60%;" class="fw-bold"><?=$si['reason'] == null ? '' : $si['reason']?></td>
                                          </tr>
                                          <tr>
                                            <td colspan=3><hr></td>
                                          </tr>
                                          <tr valign=top>
                                            <td style="width: 35%;">Detail Sertifikat</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 60%;">
                                              <div class="row">
                                                <?php foreach($si['certificateDetails'] as $cd){ ?>
                                                  <div class="col-lg-12" style="margin-bottom: 5px;">
                                                    <h4 style="margin-bottom: -5px;"><span class="badge badge-success"><?=$cd['commonName']?></span></h4>
                                                    <span style="
                                                      font-weight: bold;
                                                      margin-bottom: 15px;
                                                      font-size: 10px;
                                                      line-height: .5rem;
                                                    "><?=formatDateNamaBulanWithTime($cd['notBeforeDate']).' - '.formatDateNamaBulanWithTime($cd['notAfterDate'])?></span>
                                                  </div>
                                                <?php } ?>
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                          <?php
                        }
                      ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
          <div id="div_pdf_desktop">
            <iframe src="<?=base_url($filePath)?>" width="100%" height="500px">
          </div>
          <div id="div_pdf_mobile">
            <a href="<?=base_url($filePath)?>" target="_blank" class="btn btn-block btn-navy w-100">SHOW PDF</a>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="text-center">
        <h2 style="color: red; font-weight: bold;"><i class="fa fa-times"></i> TERJADI KESALAHAN</h2>
        <?php dd($result); ?>
      </div>
    <?php } } ?>
  </div>
</div>