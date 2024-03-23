<html>
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
</style>
<body style="font-family: Tahoma; font-size: 12px;">
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

   
<p style="font-size:14px;text-align: center;">Suksesor Pada Jabatan <b><?=$result[0]['nama_jabatan'];?></b> Pemerintah Kota Manado Tahun <?= date('Y');?></p>

        <table border=1 style="width: 100%; border-collapse: collapse; padding: 3px; margin-top: 10px;" id="result_all_pegawai">
            <tr>
                <td style="font-weight: bold; text-align: center; width: 10%;">No</td>
                <td style="font-weight: bold; text-align: center; width: 25%;">Nama</td>
                <!-- <td style="font-weight: bold; text-align: center; width: 15%;">Jabatan Target</td> -->
                <td style="font-weight: bold; text-align: center; width: 15%;">Nilai (80% Nilai Talent Pool)</td>
                <td style="font-weight: bold; text-align: center; width: 15%;">Nilai Kompetensi Teknis Bidang (20%)</td>
                <td style="font-weight: bold; text-align: center; width: 15%;">Total Nilai</td>
                <td style="font-weight: bold; text-align: center; width: 10%;">Keterangan</td>
            </tr>
            <tbody>
                <?php if($result){ $no=1; foreach($result as $rs2){ ?>
                    <?php 
                $total = $rs2['total']/2;
                $total = $total * 80 / 100;
                $total_kompentesi = $rs2['res_kompetensi'] * 20 / 100;
                $total_nilai = $total + $total_kompentesi;
                
                if($jenis_jabatan == 2){
                    if($rs2['es_jabatan'] == "II A" || $rs2['es_jabatan'] == "II B"){
                        $keterangan = "Rotasi";
                    } else {
                        $keterangan = "Promosi";
                    }
                }

                if($jenis_jabatan == 1){
                    if($rs2['es_jabatan'] == "III A" || $rs2['es_jabatan'] == "III B"){
                        $keterangan = "Rotasi";
                    } else {
                        $keterangan = "Promosi";
                    }
                }
                  ?>
                    <tr>
                        <td style="padding: 10px; text-align: center;"><?=$no++?></td>
                        <td style="padding: 10px; text-align: left;">
                        <?=$rs2['gelar1'];?> <?=$rs2['nama'];?> <?=$rs2['gelar2'];?></b><br> NIP. <?=formatNip($rs2['nipbaru_ws']);?><br><?=$rs2['jabatan_sekarang'];?> 
                        </td>
                        <!-- <td style="padding: 10px; text-align: center;"><?=$rs2['nama_jabatan'];?></td> -->
                        <td style="padding: 10px; text-align: center;"><?=$total;?></td>
                        <td style="padding: 10px; text-align: center;"><?=$total_kompentesi;?></td>
                        <td style="padding: 10px; text-align: center;"><?=$total_nilai;?></td>
                        <td style="padding: 10px; text-align: left;"><?=$keterangan;?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </body>
</html>