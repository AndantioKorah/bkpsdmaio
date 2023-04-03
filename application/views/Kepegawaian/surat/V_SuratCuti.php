
<style>
  /* @media print {

    
@page {
  size: F4;
}

	p {
		font-size: 16pt;
        font-family: "Bookman Old Style";
        color:#000;
	}

    table {
        font-size: 16pt;
        font-family: "Bookman Old Style";
        color:#000;
    }
} */
.header{
    /* margin-top:-10px; */
}
</style>
<div class="header" >
<?php $this->load->view('Kepegawaian/surat/V_Kopsurat.php');?>
</div>
<center>
        <p style="margin-top:30px;"> SURAT IZIN CUTI TAHUNAN</p>
        <p style="margin-top:-20px"> Nomor : 850/BKPSDM/SK/9999/2023</p>
</center>

<p>Diberikan cuti tahunan, tahun 2023 kepada Pegawai Negeri Sipil:</p>
<style>
    td{
        text-align: left;
    }

    th, td {
  padding: 1px;
}

    .left    { text-align: left;}
   .right   { text-align: right;}
   .center  { text-align: center;}
   .justify { text-align: justify;}

   p.besar {
    line-height: 20px;
}

</style>
<table style="margin-left:50px;" border="0">
    <tr>
        <td style="width:25%;">Nama</td>
        <td style="text-align: center;">:</td>
        <td style="width:70%;"><?= $result['0']['nama_pegawai'];?></td>
    </tr>
    <tr>
        <td style="width:25%;">NIP</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"><?= $result['0']['nip'];?></td>
    </tr>
    <tr>
        <td style="width:25%;">Pangkat, Gol/Ruang</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"><?= $result['0']['nm_pangkat'];?></td>
    </tr>
    <tr>
        <td style="width:25%;">Jabatan</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"><?= $result['0']['nama_jabatan'];?></td>
    </tr>
    <tr>
        <td style="width:25%;">Unit Kerja</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"><?= $result['0']['nm_unitkerja'];?></td>
    </tr>
    <tr>
        <td style="width:25%;">Lamanya</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"> <?= $result['0']['lama_hari'] ?> (<?= penyebut($result['0']['lama_hari']) ?>) Hari Kerja</td>
    </tr>
    <tr>
        <td style="width:25%;">Terhitung Mulai</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;"><?= formatDateNamaBulan($result['0']['tanggal_mulai']);?></td>
    </tr>
    <tr>
        <td style="width:25%;">Sampai Dengan</td>
        <td style="text-align: center;">:</td>
        <td style="width:50%;" ><?= formatDateNamaBulan($result['0']['tanggal_selesai']);?></td>
    </tr>
</table>


<p class="justify besar" >
sesuai dengan Peraturan Pemerintah Nomor 17 Tahun 2020 tentang Perubahan atas Peraturan Pemerintah
Nomor 11 Tahun 2017 tentang Manajemen Pegawai Negeri Sipil dan Peraturan Badan Kepegawaian Negara
Nomor 7 tahun 2021 tentang Perubahan Atas Peraturan Badan Kepegawaian Negara Nomor 24 Tahun 2017
tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil, dengan ketentuan sebagai berikut:
</p>


<table border="0">
    <tr>
        <td valign="top">a.</td>
        <td valign="top"><p class="justify besar" style="margin-top:1px;">
Sebelum menjalankan cuti tahunan wajib menyerahkan pekerjaannya kepada atasan langsung atau pejabat
lain yang ditunjuk.
</p></td>
    </tr>
    <tr>
    <td valign="top">b.</td>
        <td valign="top"><p class="justify besar" style="margin-top:1px;">
Setelah selesai menjalankan cuti tahunan wajib melaporkan diri kepada atasan langsung dan bekerja
kembali sebagaimana biasanya.
</p>
</td>
    </tr>
</table>

<p  style="line-height: 33px;margin-top:10px;">Demikian surat izin cuti tahunan ini dibuat untuk digunakan sebagaimana mestinya.</p>


<table border="0" style="width:100%;margin-top:10px;">
    <tr>
        <td  style="width:50%;"></td>
        <td class="center"  style="width:50%;">Manado, <?= formatDateNamaBulan(date("Y-m-d"));?>
            <br>a.n. WALI KOTA MANADO</td>
    </tr>
</table>

<p style="margin-top:60px;">
Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. Kepala Badan Keuangan dan Aset Daerah Kota Manado;<br>
5. Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado;<br>
6. Arsip.
<img src="http://localhost/bkpsdmaio/assets/images/footer.png" alt="" style="width: 100%;margin-topx: -55px;">
</p>


