<style>
.label-filter {
	color: #434242;
	font-weight: bold;
	font-size: 15px;
}

.filter-option {
	overflow: auto;
	white-space: nowrap;
	padding-bottom: 5px;
	padding-top: 5px;
}

.filter-btn {
	display: inline-block;
	text-align: center;
	padding: 5px;
	/* border-radius: 5px; */
	margin-right: 3px;
	transition: .2s;
}

.filter-unselect {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #ea5454; */
	position: relative;
	background-color: #fa8072;
	box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025);
	transition: 0.5s ease-in-out;
	/* border: 3px solid #0a7129; */
	color: #fff;
}

/* .filter-unselect:hover{
        cursor: pointer;
        background-color: #43556b;
        color: white;
    } */

.filter-select {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #0a7129; */
	position: relative;
	background-color: #0ed095;
	/* box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025); */
	/* transition: 0.5s ease-in-out; */
	/* border: 3px solid #0a7129; */
	color: #fff;
}

/* .filter-select:hover{
        cursor: pointer;
        background-color: #222e3c;
        color: white;
    } */

.list-type1 {
	width: 100%;
	margin: 0 auto;
	margin-bottom: -30px;
}

.list-type1 ol {
	counter-reset: li;
	list-style: none;
	*list-style: decimal;
	font-size: 15px;
	font-family: 'Raleway', sans-serif;
	padding: 0;
	margin-bottom: 4em;

}

.list-type1 ol ol {
	margin: 0 0 0 2em;
}

.list-type1 .select {
	position: relative;
	display: block;
	color: #fff;
	padding: .4em .4em .4em 2em;
	*padding: .4em;
	margin: .5em 0;
	background: #0ed095;
	color: #fff;
	text-decoration: none;
	-moz-border-radius: .3em;
	-webkit-border-radius: .3em;
	/* border-radius: 10em; */
	transition: all .2s ease-in-out;
}

.list-type1 .unselect {
	position: relative;
	display: block;
	color: #fff;
	padding: .4em .4em .4em 2em;
	*padding: .4em;
	margin: .5em 0;
	background: #ea5454;
	color: #fff;
	text-decoration: none;
	-moz-border-radius: .3em;
	-webkit-border-radius: .3em;
	/* border-radius: 10em; */
	transition: all .2s ease-in-out;
}

.list-type1 a:hover {
	color: #000;
	background: #d6d4d4;
	text-decoration: none;
	transform: scale(1.01);
	border: 2px solid #000;
}

ol {
    counter-reset: li; /* Initiate a counter */
    list-style: none; /* Remove default numbering */
    *list-style: decimal; /* Keep using default numbering for IE6/7 */
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
	margin-bottom: 10px;

  }

  ol ol {
    margin: 0 0 0 2em; /* Add some left margin for inner lists */
  }

  .rectangle-list .select{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    background: #ddd;
    color: #444;
    text-decoration: none;
    transition: all .3s ease-out;
  }

  .rectangle-list .unselect{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    background: #ddd;
    color: #444;
    text-decoration: none;
    transition: all .3s ease-out;
  }

  .rectangle-list a:hover{
    background: #eee;
  }

  .rectangle-list .select:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background: #0ed095;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
  }

  .rectangle-list .unselect:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background: #fa8072;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
  }

  .rectangle-list a:after{
    position: absolute;
    content: '';
    border: .5em solid transparent;
    left: -1em;
    top: 50%;
    margin-top: -.5em;
    transition: all .3s ease-out;
  }

  .rectangle-list .select:hover:after{
    left: -.5em;
    border-left-color: #0ed095;
  }
  .rectangle-list .unselect:hover:after{
    left: -.5em;
    border-left-color: #fa8072;
  }
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<h5>FORM LAYANAN PENSIUN <?=$nama_layanan;?>
          </h5>
				</div>
				<hr>
			</div>

			<div class="card-body">

				<form id="form_pensiun" method="post" enctype="multipart/form-data" id="" style="margin-top: -45px;">

        <input type="hidden" name="jenis_pensiun" id="jenis_pensiun" value="<?=$jenis_layanan;?>">

					<input type="hidden" id="sk_cpns" value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
					<input type="hidden" id="sk_pns" value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
          <input type="hidden" id="sk_pangkat" value="<?php if($sk_pangkat) echo $sk_pangkat['id']; else echo "";?>">
          <input type="hidden" id="sk_jabatan" value="<?php if($sk_jabatan) echo $sk_jabatan['id']; else echo "";?>">
					<input type="hidden" id="akte_nikah" value="<?php if($akte_nikah) echo $akte_nikah['id']; else echo "";?>">
					
        
          <input type="hidden" id="hd" value="<?php if($hd) echo $hd['id']; else echo "";?>">
          <input type="hidden" id="pidana" value="<?php if($pidana) echo $pidana['id']; else echo "";?>">
					<input type="hidden" id="dpcp" value="<?php if($dpcp) echo $dpcp['id']; else echo "";?>">

          <input type="hidden" id="pmk" value="<?php if($pmk) echo $pmk['id']; else echo "";?>">
          <input type="hidden" id="skp" value="<?php if($skp) echo $skp['id']; else echo "";?>">
          <input type="hidden" id="surat_ket_kematian" value="<?php if($surat_ket_kematian) echo $surat_ket_kematian['id']; else echo "";?>">
          <input type="hidden" id="surat_laporan_kronologis" value="<?php if($surat_laporan_kronologis) echo $surat_laporan_kronologis['id']; else echo "";?>">
          <input type="hidden" id="aktecerai" value="<?php if($aktecerai) echo $aktecerai['id']; else echo "";?>">
          <input type="hidden" id="aktekematian" value="<?php if($aktekematian) echo $aktekematian['id']; else echo "";?>">
          <input type="hidden" id="akteanak" value="<?php if($akteanak) echo $akteanak['id']; else echo "";?>">
          <input type="hidden" id="kk" value="<?php if($kk) echo $kk['id']; else echo "";?>">
         
          <input type="hidden" id="ktp" value="<?php if($ktp) echo $ktp['id']; else echo "";?>">
					<input type="hidden" id="jandaduda" value="<?php if($jandaduda) echo $jandaduda['id']; else echo "";?>">
          <input type="hidden" id="spt" value="<?php if($spt) echo $spt['id']; else echo "";?>">
          <input type="hidden" id="surat_berhenti" value="<?php if($surat_berhenti) echo $surat_berhenti['id']; else echo "";?>">
          <input type="hidden" id="surat_rekom_sakit" value="<?php if($surat_rekom_sakit) echo $surat_rekom_sakit['id']; else echo "";?>">
          <input type="hidden" id="visum" value="<?php if($visum) echo $visum['id']; else echo "";?>">
          <input type="hidden" id="berita_acara" value="<?php if($berita_acara) echo $berita_acara['id']; else echo "";?>">
          <input type="hidden" id="npwp" value="<?php if($npwp) echo $npwp['id']; else echo "";?>">
          <input type="hidden" id="buku_rekening" value="<?php if($buku_rekening) echo $buku_rekening['id']; else echo "";?>">


					<span>Berkas Persyaratan :</span>
					<div class="list-type1x">
						<ol class="rectangle-list">

            <!-- <?php $no = 1; foreach($dokumen_layanan as $rs){ ?>
              <li>
								<a class="<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>" <?php if($sk_cpns) { ?>
									onclick="viewBerkas('<?=$rs['dokumen_persyaratan'];?>')" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> <?=$rs['dokumen'];?></a>
							</li>
              <?php } ?> -->

              <?php if (in_array($jenis_layanan, $list_layanan_surat_berhenti)) { ?>
                <?php if($jenis_layanan == 9) { ?>
                  <li><a class="<?php if($surat_berhenti) echo 'select'; else echo 'unselect';?>" <?php if($surat_berhenti) { ?>
									onclick="viewBerkas('<?=$surat_berhenti['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat permohonan berhenti atas permintaan sendiri bermeterai yang ditandatangani oleh PNS ybs mengetahui kepala perangkat daerah*'); ?></a></li>
                  <?php } else if($jenis_layanan == 10){ ?>
                    <li><a class="<?php if($surat_berhenti) echo 'select'; else echo 'unselect';?>" <?php if($surat_berhenti) { ?>
									onclick="viewBerkas('<?=$surat_berhenti['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat permohonan berhenti atas permintaan sendiri karena sakit/uzur bermeterai yang ditandatangani oleh PNS ybs mengetahui kepala perangkat daerah*'); ?></a></li>
                   <?php } ?>
                  
							<li>
						  <?php } ?>
            <?php if (in_array($jenis_layanan, $list_layanan_skcpns)) { ?>
							<li>
								<a class="<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>" <?php if($sk_cpns) { ?>
									onclick="viewBerkas('<?=$sk_cpns['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK CPNS* <i
											class="fas fa-<?php if($sk_cpns) echo ''; else echo '';?>"></i></a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skpns)) { ?>
							<li>
								<a class="<?php if($sk_pns) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
									onclick="viewBerkas('<?=$sk_pns['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK PNS* <i
											class="fas fa-<?php if($sk_pns) echo ''; else echo '';?>"></i></a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skpangak)) { ?>
							<li>
								<a class="<?php if($sk_pangkat) echo 'select'; else echo 'unselect';?>" <?php if($sk_pangkat) { ?>
									onclick="viewBerkas('<?=$sk_pangkat['gambarsk'];?>',2)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK PANGKAT* </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skjabatan)) { ?>
							<li>
								<a class="<?php if($sk_jabatan) echo 'select'; else echo 'unselect';?>" <?php if($sk_jabatan) { ?>
									onclick="viewBerkas('<?=$sk_jabatan['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK JABATAN* </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_dpcp)) { ?>
							<li>
								<a class="<?php if($dpcp) echo 'select'; else echo 'unselect';?>" <?php if($dpcp) { ?>
									onclick="viewBerkas('<?=$dpcp['gambarsk'];?>',4)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('daftar perorangan calon penerima pensiun (dpcp)*'); ?> </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_pmk)) { ?>
							<li>
								<a class="<?php if($pmk) echo 'select'; else echo 'unselect';?>" <?php if($pmk) { ?>
									onclick="viewBerkas('<?=$pmk['gambarsk'];?>',4)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('sk peninjauan masa kerja (PMK)*'); ?> </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skp)) { ?>
							<li>
								<a class="<?php if($skp) echo 'select'; else echo 'unselect';?>" <?php if($skp) { ?>
									onclick="viewBerkas('<?=$skp['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('sasaran kinerja pegawai dan penilaian prestasi kerja 1 tahun terakhir*'); ?> </a>
							</li>
              <?php } ?>
              
              <?php if (in_array($jenis_layanan, $list_layanan_hd)) { ?>
                  <li><a class="<?php if($hd) echo 'select'; else echo 'unselect';?>" <?php if($hd) { ?>
									onclick="viewBerkas('<?=$hd['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i> <?php echo strtoupper('Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/Berat*'); ?> </a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_rekom_sakit)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="viewBerkas('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat Rekomendasi Sakit/Uzur dari tim dokter pemerintah yang ditunjuk oleh menteri kesehatan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_pidana)) { ?>
                  <li><a class="<?php if($pidana) echo 'select'; else echo 'unselect';?>" <?php if($pidana) { ?>
									onclick="viewBerkas('<?=$pidana['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat Pernyataan Tidak Sedang Menjalani Proses Pidana Atau Pernah Dipidana Penjara Berdasarkan Putusan Pengadilan Yang Telah Berkekuatan Hukum Tetap'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_ket_kematian)) { ?>
                  <li><a class="<?php if($surat_ket_kematian) echo 'select'; else echo 'unselect';?>" <?php if($surat_ket_kematian) { ?>
									onclick="viewBerkas('<?=$surat_ket_kematian['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat keterangan kematian dari dokter yang menerangkan secara detail penyebab kematian*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_laporan_kronologis)) { ?>
                  <li><a class="<?php if($surat_laporan_kronologis) echo 'select'; else echo 'unselect';?>" <?php if($surat_laporan_kronologis) { ?>
									onclick="viewBerkas('<?=$surat_laporan_kronologis['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('laporan kronologis kejadian secara detail dan terperinci dibuat oleh pimpinan unit kerja ybs*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktenikah)) { ?>
                <?php if($jenis_layanan != 8) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="viewBerkas('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte perkawinan (bagi yang sudah menikah/ pernah menikah)'); ?></a></li>
							<li>

              <?php } else if($jenis_layanan == 8) { ?>
                <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="viewBerkas('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte perkawinan*'); ?></a></li>
							<li>
              <?php } ?>
                 
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktercerai)) { ?>
                  <li><a class="<?php if($aktecerai) echo 'select'; else echo 'unselect';?>" <?php if($aktecerai) { ?>
									onclick="viewBerkas('<?=$aktecerai['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte cerai (bagi yang pernah bercerai)'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktekematian)) { ?>
                <?php if($jenis_layanan != 8) { ?>
                  <li><a class="<?php if($aktekematian) echo 'select'; else echo 'unselect';?>" <?php if($aktekematian) { ?>
									onclick="viewBerkas('<?=$aktekematian['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte kematian (bagi pasangan yang sudah meninggal)'); ?></a></li>
							<li>
              <?php } ?>
              <?php if($jenis_layanan == 8) { ?>
                  <li><a class="<?php if($aktekematian) echo 'select'; else echo 'unselect';?>" <?php if($aktekematian) { ?>
									onclick="viewBerkas('<?=$aktekematian['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte kematian pns yang bersangkutan*'); ?></a></li>
							<li>
              <?php } ?>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_akteanak)) { ?>
                  <li><a class="<?php if($akteanak) echo 'select'; else echo 'unselect';?>" <?php if($akteanak) { ?>
									onclick="viewBerkas('<?=$akteanak['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte lahir anak (bagi anak kandung yang belum berusia 25 tahun, belum pernah bekerja, belum pernah menikah, dan masih sekolah/kuliah'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_kk)) { ?>
                  <li><a class="<?php if($kk) echo 'select'; else echo 'unselect';?>" <?php if($kk) { ?>
									onclick="viewBerkas('<?=$kk['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('kartu keluarga*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_ket_janda_duda)) { ?>
                  <li><a class="<?php if($jandaduda) echo 'select'; else echo 'unselect';?>" <?php if($jandaduda) { ?>
									onclick="viewBerkas('<?=$jandaduda['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat keterangan janda/duda dari almarhum/almarhumah yang diterbitkan oleh kelurahan/kecamatan*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_spt)) { ?>
                  <li><a class="<?php if($spt) echo 'select'; else echo 'unselect';?>" <?php if($spt) { ?>
									onclick="viewBerkas('<?=$spt['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat perintah tugas (penugasan tertulis) bagi yang meninggal dunia karena menjalankan tugas jabatan dan/atau tugas kedinasan lainnya baik didalam maupun diluar lingkungan kerja*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_visum)) { ?>
                  <li><a class="<?php if($visum) echo 'select'; else echo 'unselect';?>" <?php if($visum) { ?>
									onclick="viewBerkas('<?=$visum['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('visum yang dikeluarkan oleh dokter yang antara lain berisi penyebab kematian bagi yang meninggal dunia karena penganiayaan, penculikan atau kecelakaan*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_berita_acara)) { ?>
                  <li><a class="<?php if($berita_acara) echo 'select'; else echo 'unselect';?>" <?php if($berita_acara) { ?>
									onclick="viewBerkas('<?=$berita_acara['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('Berita Acara kepolisian/laporan polisi yang menyebutkan secara lengkap tentang waktu kejadian, kronologis kejadian, serta kesimpulan bagi pegawai yang meninggal karena kecelakaan*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_ktp)) { ?>
                  <li><a class="<?php if($ktp) echo 'select'; else echo 'unselect';?>" <?php if($ktp) { ?>
									onclick="viewBerkas('<?=$ktp['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('KTP*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_npwp)) { ?>
                  <li><a class="<?php if($npwp) echo 'select'; else echo 'unselect';?>" <?php if($npwp) { ?>
									onclick="viewBerkas('<?=$npwp['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('NPWP*'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_buku_rek)) { ?>
                  <li><a class="<?php if($buku_rekening) echo 'select'; else echo 'unselect';?>" <?php if($buku_rekening) { ?>
									onclick="viewBerkas('<?=$buku_rekening['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('buku rekening*'); ?></a></li>
							<li>
						  <?php } ?>
						</ol>
					</div>


				
				<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
				</form>
				<p class="mt-5">
					Keterangan :<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
					Berkas Sudah diupload<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2">  &nbsp;
					</button> Berkas belum diupload<br>
					Berkas diupload Pada Menu Profil <br>
					Untuk Berkas Selain SK CPNS, SK PNS, SK Jabatan, SK Pangkat<br>
					di upload pada pilihan Arsip Lainnya.
				</p>
				<!-- <a href="<?=base_url('kepegawaian/download');?>"> <i class="fa fa-download"> <i> Download Format Laporan
							Perkawinanan pertama & Daftar keluarga </i></i></a> -->
			</div>
		</div>
	</div>
	<div class="col-lg-12 mt-3">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<div class="card-title">
						<h5>RIWAYAT LAYANAN PENSIUN <?=$nama_layanan;?></h5>
					</div>
					<hr>
				</div>
			</div>
			<div class="card-body">
				<div class="row" style="margin-top: -40px;">
					<div class="col-lg-12 table-responsive" id="list_riwayat_karsu"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="">
				<h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i>
					LOADING...</h5>
				<iframe id="iframe_view_file_berkas_pns" style="width: 100%; height: 80vh;" src=""></iframe>
			</div>

		</div>
	</div>
</div>

<script>

$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  loadListRiwayatPensiun(<?=$jenis_layanan;?>)
    })
    $('#form_pensiun').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_pensiun');
        var form_data = new FormData(formvalue[0]);

        var sk_cpns = $('#sk_cpns').val();
        var sk_pns = $('#sk_pns').val();
        var sk_pangkat = $('#sk_pangkat').val();
        var sk_pangkat = $('#sk_pangkat').val();
        var akte_nikah = $('#akte_nikah').val();

        var hd = $('#hd').val();
        var pidana = $('#pidana').val();
        var dpcp = $('#dpcp').val();
        var pmk = $('#pmk').val();
        var skp = $('#skp').val();
        var surat_ket_kematian = $('#surat_ket_kematian').val();
        var surat_laporan_kronologis = $('#surat_laporan_kronologis').val();
        var aktecerai = $('#aktecerai').val();
        var aktekematian = $('#aktekematian').val();
        var akteanak = $('#akteanak').val();
        var kk = $('#kk').val();
        var ktp = $('#ktp').val();
        var jandaduda = $('#jandaduda').val();
        var spt = $('#spt').val();
        var surat_berhenti = $('#surat_berhenti').val();
        var surat_rekom_sakit = $('#surat_rekom_sakit').val();
        var visum = $('#visum').val();
        var berita_acara = $('#berita_acara').val();
        var npwp = $('#npwp').val();
        var buku_rekening = $('#buku_rekening').val();
        


        var jenis_layanan = "<?=$jenis_layanan;?>"

        if(jenis_layanan == 7 || jenis_layanan == 8 || jenis_layanan == 9){
        if(sk_cpns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
        if(sk_pns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(sk_pangkat == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(hd == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(pidana == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(dpcp == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(sk_jabatan == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(pmk == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(skp == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        // if(akte_nikah == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        // if(aktecerai == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        // if(aktekematian == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        // if(akteanak == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        if(kk == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(ktp == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(npwp == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(buku_rekening == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
      
        }

        if(jenis_layanan == 8){
          if(jandaduda == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
         if(aktekematian == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
         if(akte_nikah == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        }

        if(jenis_layanan == 9 || jenis_layanan == 10){
          if(surat_berhenti == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
        }

        if(jenis_layanan == 11){
          if(surat_ket_kematian == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(spt == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(visum == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(berita_acara == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(surat_laporan_kronologis == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
        }


        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananPensiun")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            if(result.success == true){
                successtoast(result.msg)
                loadListRiwayatPensiun(jenis_layanan)
                window.scrollTo(0, document.body.scrollHeight);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });


    async function viewBerkas(filename,kode){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    var base_url = "<?=base_url();?>";
    var jenis_layanan = "<?=$jenis_layanan;?>";

    // if(id_dokumen == 2 || id_dokumen == 3){
    //       dir = "arsipberkaspns/";
    //     } else if(id_dokumen == 4){
    //       dir = "arsipelektronik/";
    //     } else if(id_dokumen == 18){
    //       dir = "arsiplain/";
    //     }  

    // $.ajax({
    //     type : "POST",
    //     url  : base_url + '/kepegawaian/C_Kepegawaian/getFileLayanan',
    //     dataType : "JSON",
    //     data : {id_dokumen:id_dokumen},
    //     success: function(data){
    //     $('#divloader').html('')
    //     var number = Math.floor(Math.random() * 1000);
    //     var link = "<?=base_url();?>/"+dir+"/"+data[0].gambarsk+"?v="+number;
    //     if(data != ""){
    //       if(data[0].gambarsk != ""){
    //         $('#iframe_view_file_berkas_pns').attr('src', link)
    //        $('#iframe_view_file_berkas_pns').on('load', function(){
    //      $('.iframe_loader').hide()
    //      $(this).show()
    //    })
           
    //       } else {
    //         $('#view_file_verif').attr('src', '')
    //         $('#ket').html('Tidak ada data');
    //       }
    //     } else {
    //     // errortoast('tidak ada data')
    //     $('.iframe_loader').hide()  
    //     $('#view_file_verif').attr('src', '')
    //     $('#ket').html('Tidak ada data');
    //     }
    //     }
    //     });

        if(kode == 1){
          dir = "arsipberkaspns/";
        } else if(kode == 2){
          dir = "arsipelektronik/";
        } else if(kode == 3){
          dir = "arsipjabatan/";
        } else if(kode == 4){
          dir = "arsiplain/";
        } else {
          dir = "arsipskp/"
        }

        
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/"+dir+"/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  async function filterClicked2(filename){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function loadListRiwayatPensiun(jenis_pensiun){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatPensiun/")?>'+jenis_pensiun, function(){
      $('#loader').hide()
    })
    }

</script>