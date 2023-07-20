
<!-- <style>
  @media print {

    
@page {
  size: F4;
}

	p {
		font-size: 16pt;
        font-family: "Bookman Old Style";
        color:#000;
	}

    table {
        font-size: 14;
        font-family: "Bookman Old Style";
        color:#000;
    }
}
</style> -->

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

   p {
		font-size: 14pt;
        font-family: "Bookman Old Style";
        color:#000;
	}
 
   p.besar {
    line-height: 30px;
}

span {
        font-size: 14pt;
        font-family: "Bookman Old Style";
        color:#000;
    }

table {
        font-size: 14pt;
        font-family: "Bookman Old Style";
        color:#000;
    }


</style>
</style>
 <title>Surat Hukdis</title>
<div class="header" >
<?php $this->load->view('kepegawaian/surat/V_KopSurat.php');?>
</div>
<center>
        <p style="margin-top:25px;"> SURAT PERNYATAAN<br> 
TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN TINGKAT SEDANG/BERAT </p>
        <p style="margin-top:-20px"> Nomor : <?= $result['0']['nomor_surat'];?></p>
</center>

<p>Yang bertanda-tangan dibawah ini :</p>
<table style="margin-left:50px;width:100%;" border="0">
    <tr>
        <td style="width:22%;">Nama</td>
        <td style="text-align: center;width:1%;">:</td>
        <td style="width:70%;"><?= $kaban['0']['gelar1'];?><?= $kaban['0']['nama'];?><?= $kaban['0']['gelar2'];?></td>
    </tr>
    <tr>
        <td>NIP</td>
        <td style="text-align: center;">:</td>
        <td><?= $kaban['0']['nipbaru'];?></td>
    </tr>
    <tr>
        <td>Pangkat, Gol/Ruang</td>
        <td style="text-align: center;">:</td>
        <td><?= $kaban['0']['nm_pangkat'];?></td>
    </tr>
    <tr>
        <td valign="top">Jabatan</td>
        <td valign="top" style="text-align: center;">:</td>
        <td><?= $kaban['0']['nama_jabatan'];?></td>
    </tr>

</table>


<p>
Dengan ini menyatakan dengan sesungguhnya bahwa Pegawai Negeri Sipil : 
</p>

<table style="margin-left:50px;width:100%;" border="0">
    <tr>
        <td style="width:22%;">Nama</td>
        <td style="text-align: center;width:1%;">:</td>
        <td style="width:70%;"><?= $result['0']['gelar1'];?><?= $result['0']['nama_pegawai'];?><?= $result['0']['gelar2'];?></td>
    </tr>
    <tr>
        <td>NIP</td>
        <td style="text-align: center;">:</td>
        <td><?= $kaban['0']['nipbaru'];?></td>
    </tr>
    <tr>
        <td>Pangkat, Gol/Ruang</td>
        <td style="text-align: center;">:</td>
        <td><?= $kaban['0']['nm_pangkat'];?></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td style="text-align: center;">:</td>
        <td><?= $result['0']['nama_jabatan'];?></td>
    </tr>
    <tr>
        <td>Unit Kerja</td>
        <td style="text-align: center;">:</td>
        <td><?= $result['0']['nm_unitkerja'];?></td>
    </tr>
    <tr>
        <td colspan="3">Dalam satu tahun terakhir tidak pernah dijatuhi hukuman disiplin tingkat sedang/berat. </td>
    </tr>

</table>


<p class="justify besar" style="margin-right:40px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Pernyataan ini saya buat dengan sesungguhnya dengan mengingat 
sumpah jabatan dan apabila dikemudian hari ternyata isi surat pernyataan ini tidak benar yang 
mengakibatkan kerugian negara, maka saya bersedia menanggung kerugian tersebut.</p>


<table border="0" style="width:100%;margin-top:50px;margin-bottom:200px;">
    <tr>
        <td  style="width:50%;"></td>
        <td class="center"  style="width:50%;">Manado, <?= formatDateNamaBulan($result['0']['tanggal_surat']);?>
    </tr>
</table>

<span style="margin-top:900px;">

Tembusan Yth.:<br>
1. Wali Kota Manado;<br>
2. Wakil Wali Kota Manado;<br>
3. Sekretaris Daerah Kota Manado;<br>
4. <?= $this->general_library->getTembusanHukdis($result['0']['id_unitkerjamaster'],$result['0']['nm_unitkerjamaster'],$result['0']['nm_unitkerja']);?>;<br>
5. Arsip.
<img src="<?=base_url();?>assets/images/footer.png" alt="" style="width: 100%;margin-topx: -55px;">
</span>


