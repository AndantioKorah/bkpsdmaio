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
      /* text-transform: uppercase; */
    }
  </style>
  <body style="font-family: Tahoma;">
    <table style="width: 100%;">
      <tr>
        <td> 
          <center>
            <h4 >
            DAFTAR RIWAYAT HIDUP <br>
            <u>USULAN TANDA KEHORMATAN SATYALANCANA KARYA SATYA</u>
                        </h4>
          </center>
          <br>
          <br>


        </td>
      </tr>
    </table>
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
          <span class="label_drh">NIP Lama</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=($result['data_pegawai']['niplama'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Pendidikan Terakhir</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=($result['data_pegawai']['nm_tktpendidikan'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Pangkat/Golongan Ruang Terahir (TMT)</span>
        </td>
        <td colspan=1 style="width: 50%;">
          <span class="val_drh"><?=($result['data_pegawai']['nm_pangkat'])?><br><?= formatDateNamaBulan($result['data_pegawai']['tmtpangkat'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">SK CPNS (TMT)</span>
        </td>
        <td colspan=1 style="width: 50%;">
        <span class="val_drh"><?= formatDateNamaBulan($result['data_pegawai']['tmtcpns'])?></span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Jabatan Terakhir (TMT)</span>
        </td>
        <td colspan=1 style="width: 50%;">
        <span class="val_drh"><?= ($result['data_pegawai']['nama_jabatan'])?></span><br>
        <span class="val_drh"><?= formatDateNamaBulan($result['data_pegawai']['tmtjabatan'])?></span>
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
        <?php if($result['data_pegawai']['jk'] == "Laki-Laki") { ?>
            Pria / <s>Wanita</s>  
        <?php } else { ?>
            <s>Pria</s> / Wanita  
        <?php } ?>
        </span>
        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Tanda Kehormatan yang sudah dimiliki</span>
        </td>
        <td colspan=1 style="width: 50%;">
         
        <?php if($result['riwayat_satyalencana']){ $no = 1; foreach($result['riwayat_satyalencana'] as $saty){ ?>
            <span class="val_drh"><?=$saty['nosk']?></span> / <span class="val_drh"><?= formatDateNamaBulan($saty['tglsk'])?></span><br>
        <?php } } else { ?>
        <?php } ?>

        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">Hukuman Disiplin</span>
        </td>
        <td colspan=1 style="width: 50%;">
          
        <?php if($result['riwayat_disiplin']){ $no = 1; foreach($result['riwayat_disiplin'] as $saty){ ?>
            <span class="val_drh"><?=$saty['nosurat']?></span> / <span class="val_drh"><?= formatDateNamaBulan($saty['tglsurat'])?></span><br>
        <?php } } else { ?>
            <span>tidak pernah mendapatkan hukuman disiplin tingkat
            sedang/berat selama masa kerja yang dijalani</span>
        <?php } ?>

        </td>
      </tr>
      <tr>
        <td colspan=1 style="width: 5%; text-align: center;">
          <span class="label_drh"><?=$no++;?></span>
        </td>
        <td colspan=2 style="width: 45%;">
          <span class="label_drh">CLTN</span>
        </td>
        <td colspan=1 style="width: 50%;">
        <?php if($result['riwayat_cuti']){ $no = 1; foreach($result['riwayat_cuti'] as $saty){ ?>
            <span class="val_drh"><?=$saty['nosttpp']?></span> / <span class="val_drh"><?= formatDateNamaBulan($saty['tglsttpp'])?></span>- <span class="val_drh"><?= formatDateNamaBulan($saty['tglselesai'])?></span>
        <?php } } else { ?>
            <span>tidak pernah mengambil Cuti Diluar Tanggungan Negara (CLTN)
            selama masa kerja yang dijalani</span>
        <?php } ?>
        </td>
      </tr>
      
    </table>

    <table border="0" style="width:100%;margin-top:10px;">
		<tr>
			<td style="width:50%;"></td>
			<td class="center"  style="width:50%;text-align: center;">Manado, <?= formatDateNamaBulan(date('Y-m-d'));?></td>
		</tr>
		<tr>
			<td style="text-align: center;"><?=$atasan_pegawai['nama_jabatan']?></td>
			<td class="center" style="width:38%;text-align: center;">
                
            </td>
		</tr>
        <tr>
			<td style="text-align: center;"></td>
			<td class="center" style="width:38%;height:100px;text-align: center;">
                
            </td>
		</tr>
        <tr>
			<td style="text-align: center;"><u><?= getNamaPegawaiFull($atasan_pegawai);?></u><br>NIP.<?=formatNip($atasan_pegawai['nipbaru_ws'])?></td>
			<td class="center" style="width:38%;text-align: center;">
            <u><?= getNamaPegawaiFull($result['data_pegawai']);?></u><br>
            NIP.<?= formatNip($result['data_pegawai']['nipbaru']);?>
            </td>
		</tr>
	</table>

  

            

    
  </body>
</html>
<?php } ?>