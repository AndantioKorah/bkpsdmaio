<?php if($result){ ?>
  <style>
    .td-lab-dd{
      font-size: .8rem;
      font-weight: 800;
      width: 25%;
    }

    .td-smc-dd{
      font-size: .7rem;
      font-weight: 800;
      width: 5%;
    }

    .td-val-dd{
      font-size: .9rem;
      font-weight: bold;
      width: 70%;
    }
  </style>
  <div class="modal-header pt-3 pl-3">
    <h3 class="modal-title">VERIFIKASI DOKUMEN <?=strtoupper($param['jenisdokumen']['nama'])?></h3>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-lg-6 text-left">
        <span style="color: grey; font-size .8rem; font-style: italic;">Nama</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=getNamaPegawaiFull($result)?></span>
      </div>
      <div class="col-lg-6 text-right">
        <span style="color: grey; font-size .8rem; font-style: italic;">NIP</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=formatNip($result['nipbaru_ws'])?></span>
      </div>
      <div class="col-lg-12"><hr></div>
    </div>
    <!-- HERE -->
    <?php if($param['jenisdokumen']['value'] == 'pangkat') { ?>
    <div class="row">
      <div class="col-lg-6">
        <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_jenispengangkatan']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pangkat/Gol.Ruang</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nm_pangkat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">TMT Pangkat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tmtpangkat'])?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Pejabat</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['pejabat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Masa Kerja</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['masakerjapangkat']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">No. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result['nosk']?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tgl. SK</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=formatDateNamaBulan($result['tglsk'])?></td>
          </tr>
        </table>
      </div>
      <div class="col-lg-6">
        <span style="font-weight: bold;">GAMBAR SK</span>
        <iframe style="height: 50vh; width: 100%;" src="<?=URL_FILE.$result['gambarsk']?>"></iframe>
      </div>
    </div>
    <?php } ?>
    <div class="ro">
      <div class="col-lg-12"><hr></div>
      <!-- KOLOM KETERANGAN DAN VERIF -->
    </div>
  </div>
  <script>
    $(function(){
    })
  </script>
<?php } else { ?>
  <div class="col-lg-12 text-center">
    <h5>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
  </div>
<?php } ?>