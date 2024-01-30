<html>
  <head>
    <style>
      @page *{
        margin-top: 2.54cm;
        margin-bottom: 2.54cm;
        margin-left: 3.175cm;
        margin-right: 3.175cm;
      }

      body{
        font-family: "Times New Roman", Times, serif;
      }
      
      .header-sk{
        width: 100%;
        margin-top: 0px !important;
      }

      .sp_nama_cuti{
        /* text-decoration: underline; */
        font-size: 1.3rem;
        /* font-weight: bold; */
      }

      .content-sk{
        padding-top: 30px;
      }

      .sp_nomor_cuti{
        font-size: 1.1rem;
        /* font-weight: bold; */
      }

      .div_sp_content{
        padding-top: 30px;
        font-size: 1rem;
        text-align: justify;
        line-height: 1.5rem;
      }

      .div_sp_content table{
        font-size: 1rem;
        line-height: 1.5rem;
      }

      .content_footer{
        line-height: 1.1rem;
        font-size: 1rem;
        /* padding-top: 100px; */
      }
      
      .content_footer table{
        line-height: .9rem;
        font-size: 1rem;
      }

      .footer-sk{
        /* padding-right: 5rem; */
        position: fixed;
        bottom: 0;
        padding-bottom: 10px;
        /* width: 100%; */
      }

      .footer-sk table{
        /* font-size: .8rem; */
      }

      .content-sk-header{
        text-align: center;
      }

      td{
        vertical-align: top;
      }
    </style>
  </head>
  <body>
    <?php 
      if($data){
        $rs = $data;
    ?>
      <div class="header-sk">
        <?php $this->load->view('adminkit/partials/V_HeaderSKCuti', null); ?>
      </div>
      <div class="content-sk">
        <div class="content-sk-header">
          <span class="sp_nama_cuti">SURAT IZIN <?=strtoupper($rs['nm_cuti'])?></span><br>
          <?php 
            $nomor_surat = strtoupper($rs['nomor_cuti']).'/BKPSDM/SK/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date("Y", strtotime($rs['created_date']));
            if(isset($rs['nomor_surat'])){
              $nomor_surat = $rs['nomor_surat']; } ?>
          <span class="sp_nomor_cuti">Nomor: <?=$nomor_surat?></span>
        </div>
        <div class="div_sp_content">
          Diberikan <?=strtolower($rs['nm_cuti'])?>, tahun <?=date("Y", strtotime($rs['created_date']))?> kepada Pegawai Negeri Sipil:
          <table style="width: 100%; padding-left: 30px;">
            <tr valign="top">
              <td style="width: 20%;">Nama</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=getNamaPegawaiFull($rs)?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">NIP</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=$rs['nipbaru_ws']?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Pangkat</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=$rs['nm_pangkat']?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Jabatan</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=$rs['nama_jabatan']?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Unit Kerja</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=$rs['nm_unitkerja']?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Lamanya</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=$rs['lama_cuti']." (".trim(terbilang($rs['lama_cuti'])).") Hari"?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Terhitung Mulai</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=formatDateNamaBulan($rs['tanggal_mulai'])?></td>
            </tr>
            <tr valign="top">
              <td style="width: 20%;">Sampai Dengan</td>
              <td style="width: 5%;">:</td>
              <td style="width: 75%;"><?=formatDateNamaBulan($rs['tanggal_akhir'])?></td>
            </tr>
          </table>
          <br>
          sesuai dengan Peraturan Pemerintah Nomor 17 Tahun 2020 tentang Perubahan atas Peraturan Pemerintah
          Nomor 11 Tahun 2017 tentang Manajemen Pegawai Negeri Sipil dan Peraturan Badan Kepegawaian Negara
          Nomor 7 tahun 2021 tentang Perubahan Atas Peraturan Badan Kepegawaian Negara Nomor 24 Tahun 2017
          tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil, dengan ketentuan sebagai berikut:
          <br>
          <table>
            <tr>
              <td>a.</td>
              <td>Sebelum menjalankan <?=strtolower($rs['nm_cuti'])?> wajib menyerahkan pekerjaannya kepada atasan langsung atau pejabat lain yang ditunjuk.</td>
            </tr>
            <tr>
              <td>b.</td>
              <td>Setelah selesai menjalankan <?=strtolower($rs['nm_cuti'])?> wajib melaporkan diri kepada atasan langsung dan bekerja kembali sebagaimana biasanya</td>
            </tr>
          </table>
          <br>
          Demikian surat izin <?=strtolower($rs['nm_cuti'])?> ini dibuat untuk digunakan sebagaimana mestinya.
          <br>
          <br>
          <table style="width: 100%;">
            <tr>
              <td style="width: 50%;"></td>
              <td style="width: 50%; text-align: center;">
                  Manado, <?=formatDateNamaBulan($rs['created_date'])?><br>
                  a.n. WALI KOTA MANADO
                  <?php
                  $padding_top_content_footer = "100px";
                  if(isset($rs['ds']) && $rs['ds'] == 1){
                  $padding_top_content_footer = "50px";
                  ?>
                    <img style="width: 30%;" src="<?=(base_url('assets/adminkit/img/example-ds.png'))?>">
                  <?php } ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="content_footer"
          style="padding-top: <?=$padding_top_content_footer;?>"
        >
          Tembusan Yth.:
          <table>
            <tr valign="top">
              <td>1.</td>
              <td>Wali Kota Manado;</td>
            </tr>
            <tr valign="top">
              <td>2.</td>
              <td>Wakil Wali Kota Manado;</td>
            </tr>
            <tr valign="top">
              <td>3.</td>
              <td>Sekretaris Daerah Kota Manado;</td>
            </tr>
            <tr valign="top">
              <td>4.</td>
              <td>Kepala Badan Keuangan dan Aset Daerah Kota Manado;</td>
            </tr>
            <tr valign="top">
              <td>5.</td>
              <td>Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado;</td>
            </tr>
            <tr valign="top">
              <td>6.</td>
              <td>Arsip.</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="footer-sk">
        <table style="width: 100%;">
          <tr>
            <td colspan=2 style="width: 100%; text-align: right; font-size: 130px;">
              "Manado Maju dan Sejahtera Sulut Hebat"
            </td>
          </tr>
          <tr>
            <td colspan=1 style="width: 70%;">
              <table style="width: 100%; font-size: 130px;">
                <tr style="vertical-align: top;">
                  <td style="width: 1%;">-</td>
                  <td style="width: 99%;">UU ITE No. 11 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen dan/atau hasil cetaknya merupakan alat bukti hukum yang sah"</td>
                </tr>
                <tr style="vertical-align: top;">
                  <td style="width: 1%;">-</td>
                  <td style="width: 99%;">Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE</td>
                </tr>
              </table>
            </td>
            <td colspan=1 style="width: 30%; vertical-align: middle;">
              <img style="width: 100%;" src="<?=(base_url('assets/adminkit/img/logo-bsre.png'))?>">
            </td>
          </tr>
        </table>
      </div>
    <?php } ?>
  </body>
</html>