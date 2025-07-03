
<style>
    .justify {
		text-align: justify;
	}
</style><p style="text-align: center;margin-top:500px;"><b>SURAT KETERANGAN<br>
UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA</b>
</p>
    <hr style="margin-top:-10px;height:1px;border-width:2px;color:#000;background-color:#000">
<table autosize="1">
    <tr>
        <td>NAMA INSTANSI</td>
        <td>: </td>
        <td><?= strtoupper($kp4['nm_unitkerja']);?></td>
    </tr>
    <tr>
        <td>ALAMAT LENGKAP</td>
        <td>:</td>
        <td><?= strtoupper($kp4['alamat_unitkerja']);?></td>
    </tr>
    <tr>
        <td>INSTANSI INDUK</td>
        <td>:</td>
        <td>PEMERINTAH KOTA MANADO</td>
    </tr>
    <tr>
        <td>BENDAHARA PENGELUARAN</td>
        <td>:</td>
        <td></td>
    </tr>
</table>

<p>I. DATA PEGAWAI</p>
<table autosize="1">
    <tr>
        <td>1.</td>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><?=getNamaPegawaiFull($kp4)?></td>
    </tr>
    <tr>
        <td>2.</td>
        <td>NIP</td>
        <td>:</td>
        <td><?=formatNip($kp4['nipbaru_ws'])?></td>
    </tr>
    <tr>
        <td>3.</td>
        <td>Pangkat Gol / Ruang</td>
        <td>:</td>
        <td><?= $kp4['nm_pangkat'];?></td>
    </tr>
    <tr>
        <td>4.</td>
        <td>TMT Gol / Ruang</td>
        <td>:</td>
        <td><?=formatDateNamaBulan($kp4['tmtpangkat']);?></td>
    </tr>
    <tr>
        <td>5.</td>
        <td>Tempat / Tanggal Lahir</td>
        <td>:</td>
        <td><?=($kp4['tptlahir'].', '.formatDateNamaBulan($kp4['tgllahir']))?></td>
    </tr>
    <tr>
        <td>6.</td>
        <td>AGAMA / KEBANGSAAN</td>
        <td>:</td>
        <td><?=$kp4['nm_agama'];?>/Indonesia</td>
    </tr>
    <tr>
        <td>7.</td>
        <td>Alamat Lengkap</td>
        <td>:</td>
        <td><?php if($kp4['nama_kelurahan']) { ?>Sulawesi Utara, <?=$kp4['nama_kabupaten_kota']?>, Kec. <?=$kp4['nama_kecamatan']?>, Kel. <?=$kp4['nama_kelurahan']?><?php } ?></td>
    </tr>
    <tr>
        <td>8.</td>
        <td>TMT Calon Pegawai</td>
        <td>:</td>
        <td><?=formatDateNamaBulan($kp4['tmtcpns'])?></td>
    </tr>
    <tr>
        <td>9.</td>
        <td>Jenis Kepegawaian</td>
        <td>:</td>
        <td><?=$kp4['nm_jenispeg'];?></td>
    </tr>
    <tr>
        <td>10.</td>
        <td>Status Kepegawaian</td>
        <td>:</td>
        <td><?=$kp4['nm_statuspeg'];?></td>
    </tr>
    <tr>
        <td>11.</td>
        <td>Digaji Menurut (PP/SK)</td>
        <td>:</td>
        <td><?=$kp4['sumber_gaji'];?>   </td>
    </tr>
    <tr>
        <td>12.</td>
        <td>Besarnya Penghasilan</td>
        <td>:</td>
        <td>Rp.<?=$kp4['total_penghasilan'];?>-, Gaji Pokok Rp. <?=$kp4['gaji_pokok'];?></td>
    </tr>
    <tr>
        <td>13.</td>
        <td>Jabatan</td>
        <td>:</td>
        <td><?=$kp4['nama_jabatan'];?></td>
    </tr>
    <tr>
        <td>14.</td>
        <td>Jumlah Keluarga Tertanggung</td>
        <td>:</td>
        <td><?=$kp4['jumlah_kel_tertanggung'];?></td>
    </tr>
    <tr>
        <td>15.</td>
        <td>SK Terahkhir yang dimiliki</td>
        <td>:</td>
        <td><?=$kp4['sk_terakhir'];?></td>
    </tr>
    <tr>
        <td>16.</td>
        <td>Masa Kerja Golongan</td>
        <td>:</td>
        <td><?=countDiffDateLengkap(date('Y-m-d'), $kp4['tmtpangkat'], ['tahun', 'bulan'])?></td>
    </tr>
      <tr>
        <td>17.</td>
        <td>Masa Kerja Keseluruhan</td>
        <td>:</td>
        <td><?=countDiffDateLengkap(date('Y-m-d'), $kp4['tmtcpns'], ['tahun', 'bulan'])?></td>
    </tr>
    
</table>
<p>II. DATA KELUARGA (YANG MENJADI TANGGUNGAN PEGAWAI)</p>
<p>A.	Kawin Sah dengan <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></p>
<table style="border-collapse: collapse;border: none;width: 111px;">
    <tbody>
        <tr>
            <td style="width: 26.7pt;border: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>NO</span></p>
            </td>
            <td style="width: 77.95pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>Nama <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></span></p>
            </td>
            <td style="width: 2cm;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Tempat Lahir</span></p>
            </td>
            <td style="width: 73.55pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Tgl. Lahir</span></p>
            </td>
            <td style="width: 49.5pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>NIP/NII</span></p>
            </td>
            <td style="width: 47.05pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Pekerjaan</span></p>
            </td>
            <td style="width: 63.8pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>Tgl. Kawin</span></p>
            </td>
            <td style="width: 42.5pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?> Ke</span></p>
            </td>
            <td style="width: 94.15pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'>Penghasilan</span></p>
            </td>
        </tr>
        <?php if($pasangan) { ?>
            <tr>
            <td style="width: 26.7pt;border-right: 1pt solid black;border-bottom: 1pt solid black;border-left: 1pt solid black;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'>1</span></p>
            </td>
            <td style="width: 77.95pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=$pasangan[0]['namakel'];?></span></p>
            </td>
            <td style="width: 2cm;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=$pasangan[0]['tptlahir'];?></span></p>
            </td>
            <td style="width: 73.55pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=($pasangan[0]['tgllahir']);?></span></p>
            </td>
            <td style="width: 49.5pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'><?=$kp4['nip_nii'];?></span></p>
            </td>
            <td style="width: 47.05pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=$pasangan[0]['pekerjaan'];?></span></p>
            </td>
            <td style="width: 63.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=($pasangan[0]['tglnikah']);?></span></p>
            </td>
            <td style="width: 42.5pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=$pasangan[0]['pasangan_ke'];?></span></p>
            </td>
            <td style="width: 94.15pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'><?=$pasangan[0]['penghasilan'];?></span></p>
            </td>
        </tr>
        <?php } else { ?>
        <tr>
            <td style="width: 26.7pt;border-right: 1pt solid black;border-bottom: 1pt solid black;border-left: 1pt solid black;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 77.95pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 2cm;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 73.55pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 49.5pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 47.05pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 63.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 42.5pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 94.15pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Arial",sans-serif;'></span></p>
            </td>
        </tr>
         <?php } ?>
    </tbody>
</table>
<p>III. ANAK - ANAK YANG MENJADI TANGGUNGAN</p>

<table style="border-collapse: collapse; border: none; width: 100%;border: 1pt solid black;" class="fr-table-selection-hover">
    <tbody>
        <tr>
            <td style="width: 4.9635%; border: 1pt solid black; padding: 0cm 5.4pt; height: 42.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>NO</span></p>
            </td>
            <td style="width: 7.0073%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 42.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Nama Anak</span></p>
            </td>
            <td style="width: 8.0292%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 42.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Tempat Lahir</span></p>
            </td>
            <td style="width: 31.4pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Tgl. Lahir</span></p>
            </td>
            <td style="width: 41.05pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Status Anak</span></p>
            </td>
            <td style="width: 42.55pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Dari <?php if($kp4['jk'] == "Laki-laki" || $kp4['jk'] == "Laki-Laki") echo "Istri"; else echo "Suami"; ?></span></p>
            </td>
            <td style="width: 29.8pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Jenis Kelamin</span></p>
            </td>
            <td style="width: 11.6788%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 42.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Dapat/Tidak Tunjangan</span></p>
            </td>
            <td style="width: 8.9051%; border-top: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid black; border-image: initial; border-left: none; padding: 0cm 5.4pt; height: 42.3pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Sudah/ Belum Menikah</span></p>
            </td>
            <td style="width: 43.3pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Belum Kerja</span></p>
            </td>
            <td style="width: 45pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Masih/Tidak Sekolah / Kuliah</span></p>
            </td>
            <td style="width: 54pt;border-top: 1pt solid black;border-right: 1pt solid black;border-bottom: 1pt solid black;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 42.3pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'>Keputusan Pengadilan</span></p>
            </td>
        </tr>
         <?php $no = 1; if($anak) { foreach($anak as $r) { ?>

        <tr>
             <td style="width: 1.9635%;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$no++;?></span></p>
            </td>
            <td style="width: 4.9635%; border-right: 1pt solid black; border-bottom: 1pt solid black; border-left: 1pt solid black; border-image: initial; border-top: none; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['namakel'];?></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['tptlahir'];?></span></p>
            </td>
            <td style="width: 8.0292%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=formatDateNamaBulan($r['tgllahir']);?></span></p>
            </td>
            <td style="width:31.4pt;border-top:none;border-left: 1pt solid black;border-bottom: 1pt solid black;border-right: 1pt solid black;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?php if($r['statusanak'] == 1) echo "Anak Kandung"; else echo "Anak Tiri"; ?></span></p>
            </td>
            <td style="width: 41.05pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['nama_ortu_anak'];?></span></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['jenis_kelamin'];?></span></p>
            </td>
            <td style="width: 29.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['status_tunjangan'];?></span></p>
            </td>
            <td style="width: 11.6788%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['status_kawin'];?></span></p>
            </td>
            <td style="width: 8.9051%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['status_kerja'];?></span></p>
            </td>
            <td style="width: 43.3pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['status_pendidikan'];?></span></p>
            </td>
            <td style="width: 45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'><?=$r['keputusan_pengadilan'];?></span></p>
            </td>
           
        </tr>
    <?php } }  else { ?>
     <tr>
            <td style="width: 4.9635%; border-right: 1pt solid black; border-bottom: 1pt solid black; border-left: 1pt solid black; border-image: initial; border-top: none; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 7.0073%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 8.0292%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width:31.4pt;border-top:none;border-left:none;border-bottom:  solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 41.05pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 29.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 11.6788%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 8.9051%; border-top: none; border-left: none; border-bottom: 1pt solid black; border-right: 1pt solid black; padding: 0cm 5.4pt; vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 43.3pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
            <td style="width: 54pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:12px;font-family:"Arial",sans-serif;'></span></p>
            </td>
        </tr>
    <?php } ?>
        
       
    </tbody>
</table>
<p  class="justify">
    Keterangan ini saya buat dengan sesungguhnya dan apabila ini tidak benar (palsu), saya bersedia dituntut dimuka pengadilan berdasarkan undang – undang yang berlaku dan bersedia mengembalikan semua tunjangan yang telah saya terima yang seharusnya bukan menjadi hak saya.
</p>
<!-- <pagebreak type="NEXT-ODD" resetpagenum="1" pagenumstyle="i" suppress="off" /> -->

<table border="0" style="width:100%;margin-top:18px;">
		<tr>
			<td style="width:62%;"></td>
			<td class="center"  style="width:38%;text-align: center;">Manado, <?= formatDateNamaBulan(date('Y-m-d'));?>
            <br>Pegawai yang bersangkutan,
				</td>
		</tr>
		<tr>
			<td style="width:62%;"></td>
			<td valign="bottom" class="center" style="width:38%;height:130px;text-align: center;">
                <?php $pangkat = explode(",",$kp4['nm_pangkat']);?>
                <u><?=getNamaPegawaiFull($kp4)?></u><br><?=$pangkat[0];?><br>NIP. <?= $kp4['nipbaru_ws'];?>
            </td>
            <td></td>
		</tr>
	</table>