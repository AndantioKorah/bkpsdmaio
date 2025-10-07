<style>
	.top_header{
		font-weight: bold;
		font-size: 25px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.address_header{
		font-weight: 500;
		font-size: 20px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

	.footer_header{
		font-weight: 500;
		font-size: 14px;
		margin-bottom: 0px;
		margin-top: 0px;
	}

    table {
    font-size: 13px; /* Sets the default font size for all text within the table */
    }
</style>
<body style="font-family: Tahoma; font-size: 13px;">
<table style="width: 100%; height: 300px;">
	<tr>
		<td valign=bottom style="width: 5%;">
			<img style="width: 80px; height: 100px;" src="<?=urlencode('assets/adminkit/img/logo-pemkot-small.png')?>">
		</td>
		<td valign=bottom style="width: 90%; text-align:center;">
			<h5 class="top_header">PEMERINTAH KOTA MANADO</h5>
			<h5 class="top_header">BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h5>
			<h5 class="address_header">Jalan Balai Kota No. 1, Manado, 95124</h5>
			<h5 class="footer_header">website: bkd.manadokota.go.id | email: bkdkotamanado@gmail.com</h5>
		</td>
		<td valign=bottom style="width: 5%;">
			<!-- <img style="width: 90px; height: 100px;" src="<?=urlencode(('assets/adminkit/img/logo-siladen-small.png'))?>"> -->
		</td>
	</tr>
	<tr>
		<td colspan=3 style="border-bottom: 3px solid black;"></td>
	</tr>
</table>

<?php if(isset($skpd)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Unit Kerja Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Unit Kerja</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
           $skpd_total_perempuan = 0; 
            $skpd_total_laki = 0; 
             $skpd_belum_terdata_laki =0;
         foreach($skpd['skpd'] as $rs){ ?>
        <tr>
              <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php  $skpd_total_laki += $rs['laki']; 
         $skpd_total_perempuan += $rs['perempuan']; }  ?>
     <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>100</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span >Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$skpd_total_laki;?></span></p>
            </td>
           <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$skpd_total_perempuan;?></span></p>
            </td>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$skpd_total_laki+$skpd_total_perempuan;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>


<?php if(isset($jabatan)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Jabatan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Jabatan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
            $jab_total_perempuan = 0; 
            $jab_total_laki = 0; 
             $jab_belum_terdata_laki =0;
         foreach($jabatan['jabatan'] as $rs){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
      $jab_total_laki += $rs['laki']; 
         $jab_total_perempuan += $rs['perempuan'];
         }  ?>
     <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>100</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$jab_total_laki;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$jab_total_perempuan;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$jab_total_laki+$jab_total_perempuan;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>


<?php if(isset($pangkat)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Pangkat/Golongan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Pangkat/Golongan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
              $gol_total_perempuan = 0; 
            $gol_total_laki = 0; 
             $gol_belum_terdata_laki =0;
         foreach($pangkat['pangkat'] as $rs){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
       $gol_total_laki += $rs['laki']; 
         $gol_total_perempuan += $rs['perempuan'];
         }  ?>
     <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>100</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$gol_total_laki;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$gol_total_perempuan;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$gol_total_laki+$gol_total_perempuan;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>


<?php if(isset($pendidikan)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Pendidikan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
            $total_perempuan = 0; 
            $total_laki = 0; 
            $belum_terdata_laki =0;
         foreach($pendidikan['pendidikan'] as $rs){ ?>
         <?php if(isset($rs['nama'])){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
        $total_laki += $rs['laki']; 
         $total_perempuan += $rs['perempuan'];
         $belum_terdata_laki = $pendidikan['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan = $pendidikan['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
     <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>11</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Belum Terdata</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_perempuan;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki+$belum_terdata_perempuan;?></span></p>
            </td>
        </tr>
        <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>12</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki+$belum_terdata_laki;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_perempuan+$belum_terdata_perempuan;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki+$total_perempuan+$belum_terdata_laki+$belum_terdata_perempuan;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>


<?php if(isset($pendidikan_pns)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Pegawai Negeri Sipil (PNS) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Pendidikan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
             $total_perempuan_pns = 0; 
            $total_laki_pns = 0; 
             $belum_terdata_laki_pns =0;
         foreach($pendidikan_pns['pendidikan'] as $rs){ ?>
         <?php if(isset($rs['nama'])){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
        $total_laki_pns += $rs['laki']; 
         $total_perempuan_pns += $rs['perempuan'];
         $belum_terdata_laki_pns = $pendidikan_pns['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan_pns = $pendidikan_pns['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
         <?php if($belum_terdata_laki_pns+$belum_terdata_perempuan_pns != 0) { ?>
     <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>11</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Belum Terdata</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki_pns;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_perempuan_pns;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki_pns+$belum_terdata_perempuan_pns;?></span></p>
            </td>
        </tr>
        <?php } ?>
        <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>12</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki_pns+$belum_terdata_laki_pns;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_perempuan_pns+$belum_terdata_perempuan_pns;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki_pns+$total_perempuan_pns+$belum_terdata_laki_pns+$belum_terdata_perempuan_pns;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>

<?php if(isset($pendidikan_pppk)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Pemerintah Kota Manado Menurut Tingkat Pendidikan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Pendidikan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
             $total_perempuan_pppk = 0; 
            $total_laki_pppk = 0; 
             $belum_terdata_laki_pppk =0;
         foreach($pendidikan_pppk['pendidikan'] as $rs){ ?>
         <?php if(isset($rs['nama'])){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
          $total_laki_pppk += $rs['laki']; 
         $total_perempuan_pppk += $rs['perempuan'];
         $belum_terdata_laki_pppk = $pendidikan_pppk['pendidikan']['belum_terdata']['laki'];
         $belum_terdata_perempuan_pppk = $pendidikan_pppk['pendidikan']['belum_terdata']['perempuan'];
         } } ?>
         <?php if($belum_terdata_laki_pppk+$belum_terdata_perempuan_pppk != 0) { ?>
     <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>11</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Belum Terdata</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki_pppk;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_perempuan_pppk;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$belum_terdata_laki_pppk+$belum_terdata_perempuan_pppk;?></span></p>
            </td>
        </tr>
        <?php } ?>
        <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>12</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki_pppk+$belum_terdata_laki_pppk;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_perempuan_pppk+$belum_terdata_perempuan_pppk;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki_pppk+$total_perempuan_pppk+$belum_terdata_laki_pppk+$belum_terdata_perempuan_pppk;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>


<?php if(isset($kecamatan)) { ?>
<br>
<span style='font-family:"Arial",sans-serif;'><b>Jumlah Aparatur Sipil Negara (ASN) Pemerintah Kota Manado per Kecamatan Per Tanggal <?=formatDateNamaBulan(date('Y-m-d'));?></b></span>
<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr style="">
            <td style="width: 5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>No</span></p>
            </td>
            <td style="width: 57.5%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 12.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Kecamatan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Laki-laki</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Perempuan</span></p>
            </td>
            <td style="width: 12.5%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
        </tr>
         <?php $no = 1;  
             $total_perempuan = 0; 
			$total_laki = 0; 
         foreach($kecamatan['unitkerjamaster'] as $rs){ ?>
        <tr>
             <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$rs['nama']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['perempuan']?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$rs['laki']+$rs['perempuan']?></span></p>
            </td>
        </tr>
    <?php 
        $total_laki += $rs['laki']; 
         $total_perempuan += $rs['perempuan'];
         }  ?>
     <tr>
             <td style="color:#fff;width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'>100</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Total</span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_perempuan;?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;'><span style='font-family:"Arial",sans-serif;'><?=$total_laki+$total_perempuan;?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<?php } ?>