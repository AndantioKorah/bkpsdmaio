
<style>
    .justify {
		text-align: justify;
	}
</style><p style="text-align: center"><b>SURAT KETERANGAN<br>
UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA</b>
</p>

    <hr style="margin-top:-10px;height:1px;border-width:2px;color:#000;background-color:#000">
<table>
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
<table>
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
<p>III. ANAK - ANAK YANG MENJADI TANGGUNGAN</p>

<p  class="justify">
    Keterangan ini saya buat dengan sesungguhnya dan apabila ini tidak benar (palsu), saya bersedia dituntut dimuka pengadilan berdasarkan undang – undang yang berlaku dan bersedia mengembalikan semua tunjangan yang telah saya terima yang seharusnya bukan menjadi hak saya.
</p>