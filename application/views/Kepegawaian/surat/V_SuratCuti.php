
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
 <title>Surat Cuti</title>
<div class="header" >
<?php $this->load->view('kepegawaian/surat/V_KopSurat.php');?>
</div>
<center>
        <p style="margin-top:25px;"> SURAT IZIN <?= strtoupper($result['0']['nm_cuti']);?></p>
        <p style="margin-top:-20px"> Nomor : <?= $result['0']['nomor_surat'];?></p>
</center>

<?php if($result['0']['jenis_cuti'] == 4) {  ?>
    <p>Diberikan <?= strtolower($result['0']['nm_cuti']);?> kepada Pegawai Negeri Sipil:</p>
<?php } else if($result['0']['jenis_cuti'] == 3 || $result['0']['jenis_cuti'] == 5) {  ?> 
    <p>Diberikan <?= strtolower($result['0']['nm_cuti']);?> tahun <?= date('Y');?> kepada Pegawai Negeri Sipil:</p>
<?php }  else { ?>
    <p>Diberikan <?= strtolower($result['0']['nm_cuti']);?>, tahun <?= date('Y');?> kepada Pegawai Negeri Sipil:</p>
<?php } ?>
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
        <td style="width:70%;"><?= $result['0']['gelar1'];?><?= $result['0']['nama_pegawai'];?><?= $result['0']['gelar2'];?></td>
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
        <td style="width:50%;"> <?= $result['0']['lama_cuti'] ?> (<?= penyebut($result['0']['lama_cuti']) ?>) <?php if($result['0']['jenis_lama_cuti'] == 1) echo "Hari Kerja"; else echo "Bulan";?></td>
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
    <tr style="margin-bot:-20px;">
        <td valign="top">a.</td>
        <td valign="top" class="justify">
Sebelum menjalankan 
<?php if($result['0']['jenis_cuti'] == 4) {  ?>
    cuti karena alasan penting
<?php }  else if($result['0']['jenis_cuti'] == 3) {  ?>
    cuti melahirkan
<?php } else { ?>
    <?= strtolower($result['0']['nm_cuti']);?>
<?php } ?>

wajib menyerahkan pekerjaannya kepada atasan langsung atau pejabat
lain yang ditunjuk.
</td>
    </tr>
    <tr>
    <td valign="top">b.</td>
        <td valign="top" class="justify">
Setelah selesai menjalankan 
<?php if($result['0']['jenis_cuti'] == 4) {  ?>
    cuti karena alasan penting
<?php } else { ?>
    <?= strtolower($result['0']['nm_cuti']);?>
<?php } ?>
 wajib melaporkan diri kepada atasan langsung dan bekerja
kembali sebagaimana biasanya.

</td>
    </tr>
</table>

<p  style="line-height: 33px;margin-top:5px;">Demikian surat izin 
<?php if($result['0']['jenis_cuti'] == 4) {  ?>
    cuti karena alasan penting
<?php } else { ?>
    <?= strtolower($result['0']['nm_cuti']);?>
<?php } ?>
 ini dibuat untuk digunakan sebagaimana mestinya.</p>


<table border="0" style="width:100%;margin-top:10px;margin-bottom:68px;">
    <tr>
        <td  style="width:50%;"></td>
        <td class="center"  style="width:50%;">Manado, <?= formatDateNamaBulan($result['0']['tanggal_surat']);?>
            <br>a.n. WALI KOTA MANADO</td>
    </tr>
</table>

<span style="margin-top:500px;">
Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. Kepala Badan Keuangan dan Aset Daerah Kota Manado;<br>
5. Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Manado;<br>
6. Arsip.
<img src="<?=base_url();?>assets/images/footer.png" alt="" style="width: 100%;margin-topx: -55px;">
</span>


