<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <h3 class="card-title col-md-10">Pas Photo / Usul ID Card</h3>

          <div class="col-md-2">
            <a href="<?php echo site_url() ?>kepegawaian/C_pasphoto/tambahUsulIDCard" class="btn btn-block btn-danger btn-sm"><i class="fa fa-plus"></i> Usul ID Card</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php echo $pesan ?>
        <form action="<?php echo site_url() ?>kepegawaian/C_pasphoto/update" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <input type="hidden" name="idUsul" value="<? $id_peg  = $this->session->userdata('id_peg'); ?>">
          <input type="hidden" name="oldFile" value="<?= $id_pasphoto ?>">

          <table width="965" border="0">
            <tr>
              <td colspan="3">
                <div class="form-group row">
                  <label class="control-label col-md-2">Pas Photo<br><br><br>
                  </label>
                  <div class="col-lg-8">
                    <input type="file" name="filePengantar" class="form-control" placeholder="File Pengantar">
                  </div>

                </div>
              </td>
              <td width="777" rowspan="7">

                <div align="center"><img style="background-color:powderblue;" src="<?php echo base_url() ?>uploads/<?= $nip_baru ?>/<?= $id_pasphoto ?>" alt="" width="200" align="top"></div>
              </td>
            </tr>


            <tr>
              <td>
                <div>
                  <button type="submit" class="btn btn-danger">UPLOAD PHOTO</button>
                </div>
              </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3">*Foto Memakai Seragam Khaki dengan atribut lengkap </td>
            </tr>
            <tr>
              <td colspan="3">*Tipe File JPG </td>
            </tr>
            <tr>
              <td colspan="3">*Maximal Ukuran File 1 MB </td>
            </tr>
            <tr>
              <td colspan="3">*Ukuran Foto 3x4 atau 4x6</td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><span class="style1">
                  <font color="red">Warna Latar Belakang Pas Foto</font>
                </span></td>
            </tr>
            <tr>
              <td width="277">JPT / Eselon II</td>
              <td width="3">:</td>
              <td width="409">Warna Merah </td>
            </tr>
            <tr>
              <td>Administrator / Eselon III</td>
              <td>:</td>
              <td>Warna Biru </td>
            </tr>
            <tr>
              <td>Pengawas / Eselon IV</td>
              <td>:</td>
              <td>Warna Hijau </td>
            </tr>
            <tr>
              <td>Fungsional Tertentu </td>
              <td>:</td>
              <td>Warna Abu-Abu </td>
            </tr>
            <tr>
              <td>Fungsional Umum/Pelaksana </td>
              <td>:</td>
              <td>Warna Oranye </td>
            </tr>
            <tr>
              <td>PPPK</td>
              <td>:</td>
              <td>Warna Kuning </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><span class="style1"><strong>
                    <font color="red">Untuk Proses Pengangkatan CPNS ke PNS, latar belakang foto warna Merah</font>
                  </strong></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>


        </form>
      </div>
    </div><!-- card body!-->
  </div> <!-- card !-->
</div> <!-- col!-->
</div> <!-- row!-->
</div>
<!-- /Page Content -->