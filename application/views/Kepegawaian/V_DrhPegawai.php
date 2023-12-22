<?php if($result){ ?>
<html>
  <style>
    :root{
      --width-foto: 150px;
    }

    .table_border_drh, .table_border_drh tr, .table_border_drh td{
      border: 1px solid black;
      border-collapse: collapse;
      padding: 5px; 
    }
    
    #profile_pegawai_drh{
      width: var(--width-foto);
      height: calc(var(--width-foto) * 1.5);
    }

    .val_drh{
      text-transform: uppercase;
    }
  </style>
  <body style="font-family: Tahoma;">
    <table style="width: 100%;">
      <tr>
        <td> 
          <img id="profile_pegawai_drh" style="position: relative; float: right;"
            src="<?php
              $path = './assets/fotopeg/'.$result['data_pegawai']['fotopeg'];
              // $path = '../siladen/assets/fotopeg/'.$result['data_pegawai']['fotopeg'];
              if($result['data_pegawai']['fotopeg']){
              if (file_exists($path)) {
                  $src = './assets/fotopeg/'.$result['data_pegawai']['fotopeg'];
                //  $src = '../siladen/assets/fotopeg/'.$result['data_pegawai']['fotopeg'];
              } else {
                $src = './assets/img/user.png';
                // $src = '../siladen/assets/img/user.png';
              }
              } else {
                $src = './assets/img/user.png';
              }
              echo base_url().$src;?>" />
          <center>
            <h4 style="margin-top: calc(var(--width-foto) / 1.5);">DAFTAR RIWAYAT HIDUP</h4>
          </center>
        </td>
      </tr>
    </table>
    <h4 class="sub_title_drh">I. <span style="margin-left: 30px;">KETERANGAN PERORANGAN</span></h4>
    <?php $no = 1; ?>
    <table class="table_border_drh" style="width: 100%;">
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Nama Lengkap</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=getNamaPegawaiFull($result['data_pegawai'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">NIP</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=($result['data_pegawai']['nipbaru_ws'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Tempat/Tgl. Lahir</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=$result['data_pegawai']['tptlahir'].' / '.formatDateNamaBulan($result['data_pegawai']['tgllahir'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Jenis Kelamin</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=$result['data_pegawai']['jk']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Status Perkawinan</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=$result['data_pegawai']['nm_sk']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=5 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=1 rowspan=5 style="width: 20%;">
          <span class="label_drh">Alamat Rumah</span>
        </td>
        <td colspan=1 rowspan=1 style="width: 25%;">
          <span class="label_drh">a. Jalan, RT / RW</span>
        </td>
        <td colspan=1 rowspan=1 style="width: 50%;">
          <span class="val_drh"><?=$result['data_pegawai']['alamat']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">b. Kelurahan / Desa</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"><?=$result['data_pegawai']['nama_kelurahan']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">c. Kecamatan</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"><?=$result['data_pegawai']['nama_kecamatan']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">d. Kabupaten / Kota</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"><?=$result['data_pegawai']['nama_kabupaten_kota']?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">e. Provinsi</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh">Sulawesi Utara</span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=7 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=1 rowspan=7 style="width: 20%;">
          <span class="label_drh">Keterangan Badan</span>
        </td>
        <td colspan=1 rowspan=1 style="width: 25%;">
          <span class="label_drh">a. Tinggi (cm)</span>
        </td>
        <td colspan=1 rowspan=1 style="width: 50%;">
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">b. Berat Badan (kg)</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">c. Rambut</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">d. Bentuk Muka</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">e. Warna Kulit</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">f. Ciri-ciri Khas</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1>
          <span class="label_drh">g. Cacat Tubuh</span>
        </td>
        <td colspan=1 rowspan=1>
          <span class="val_drh"></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 rowspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 rowspan=1 style="width: 45%;">
          <span class="label_drh">Kegemaran (Hobby)</span>
        </td>
        <td colspan=1 rowspan=1 style="width: 50%;">
          <span class="val_drh"></span>
        </td>
      </tr>
    </table>
    <div style="margin-top: 50px;">
      <h4 class="sub_title_drh">II. <span style="margin-left: 30px;">PENDIDIKAN</span></h4>
    </div>
    <table class="table_border_drh" style="width: 100%;">
      <tr>
        <td style="width: 5%; text-align: center;">NO</td>
        <td style="width: 15%; text-align: center;">TINGKAT</td>
        <td style="width: 18%; text-align: center;">NAMA LEMBAGA PENDIDIKAN</td>
        <td style="width: 15%; text-align: center;">JURUSAN</td>
        <td style="width: 15%; text-align: center;">STTB/TANDA LULUS/IJAZAH TAHUN</td>
        <td style="width: 15%; text-align: center;">TEMPAT</td>
        <td style="width: 17%; text-align: center;">NAMA KEPALA SEKOLAH/DIREKTUR/DEKAN/PROMOTOR</td>
      </tr>
      <tbody>
        <?php if($result['riwayat_pendidikan']){ $no = 1; foreach($result['riwayat_pendidikan'] as $pend){ ?>
          <tr>
            <td><?=$no++;?></td>
            <td><span class="val_drh"><?=$pend['nm_tktpendidikanb']?></span></td>
            <td><span class="val_drh"><?=$pend['namasekolah']?></span></td>
            <td style="text-align: center;"><span class="val_drh"><?=$pend['jurusan']?></span></td>
            <td style="text-align: center;"><span class="val_drh"><?=$pend['tahunlulus']?></span></td>
            <td><span class="val_drh"></span></td>
            <td><span class="val_drh"><?=$pend['pimpinansekolah']?></span></td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
    <div style="margin-top: 50px;">
      <h4 class="sub_title_drh">II. <span style="margin-left: 30px;">RIWAYAT PEKERJAAN</span></h4>
    </div>
    <table class="table_border_drh" style="width: 100%;">
      <tr>
        <td style="width: 5%; text-align: center;">NO</td>
        <td style="width: 15%; text-align: center;">TINGKAT</td>
        <td style="width: 18%; text-align: center;">NAMA LEMBAGA PENDIDIKAN</td>
        <td style="width: 15%; text-align: center;">JURUSAN</td>
        <td style="width: 15%; text-align: center;">STTB/TANDA LULUS/IJAZAH TAHUN</td>
        <td style="width: 15%; text-align: center;">TEMPAT</td>
        <td style="width: 17%; text-align: center;">NAMA KEPALA SEKOLAH/DIREKTUR/DEKAN/PROMOTOR</td>
      </tr>
      <tbody>
        <?php if($result['riwayat_pendidikan']){ $no = 1; foreach($result['riwayat_pendidikan'] as $pend){ ?>
          <tr>
            <td><?=$no++;?></td>
            <td><span class="val_drh"><?=$pend['nm_tktpendidikanb']?></span></td>
            <td><span class="val_drh"><?=$pend['namasekolah']?></span></td>
            <td style="text-align: center;"><span class="val_drh"><?=$pend['jurusan']?></span></td>
            <td style="text-align: center;"><span class="val_drh"><?=$pend['tahunlulus']?></span></td>
            <td><span class="val_drh"></span></td>
            <td><span class="val_drh"><?=$pend['pimpinansekolah']?></span></td>
          </tr>
        <?php } } ?>
      </tbody>
    </table>
  </body>
</html>
<?php } ?>