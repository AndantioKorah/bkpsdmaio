<style>.label-filter {
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

.filter-warning {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #0a7129; */
	position: relative;
	background-color:rgb(239, 255, 8);
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

  .rectangle-list .warning{
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

  .rectangle-list .warning:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background-color:rgb(239, 255, 8);
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

  .rectangle-list .warning:hover:after{
    left: -.5em;
    border-left-color:rgb(187, 255, 14);
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
					<h5>FORM LAYANAN JABATAN FUNGSIONAL</h5>
				</div>
				<hr>
      <span><b>Berkas Persyaratan :</b></span>
  
			</div>
			<div class="card-body mt-2">

				<form id="form_layanan_pangkat" method="post" enctype="multipart/form-data" id="form_cuti"
					style="margin-top: -35px;">
          <?php if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 || $id_m_layanan == 15 || $id_m_layanan == 16) { ?>
          <div class="form-group">
            <label>Surat Pengantar dari Kepala Perangkat Daerah / Kepala Sekolah / Kepala Puskesmas / Direktur Rumah Sakit</label>
            <input  class="form-control my-image-field" type="file" id="pdf_surat_pengantar" name="file" required />
            <!-- <input class="form-control" type="file" id="surat_pengantar" name="surat_pengantar" autocomplete="off"  /> -->
          </div>
          <input type="hidden" id="nip" name="nip" value="<?= $this->general_library->getUserName();?>">
			<?php } ?>
          <?php if($id_m_layanan == 12) { ?>
					<input type="hidden" id="formasi" value="<?php if($formasi) echo $formasi['id']; else echo "";?>">
					<input type="hidden" id="sertiukom" value="<?php if($sertiukom) echo $sertiukom['id']; else echo "";?>">
					<input type="hidden" id="peta_jabatan" value="<?php if($peta_jabatan) echo $peta_jabatan['id']; else echo "";?>">
					<input type="hidden" id="skp1" value="<?php if($skp1) echo $skp1['id']; else echo "";?>">
					<input type="hidden" id="pak" value="<?php if($pak) echo $pak['id']; else echo "";?>">
					<input type="hidden" id="sk_jabatan_fungsional" value="<?php if($sk_jabatan_fungsional) echo $sk_jabatan_fungsional['id']; else echo "";?>">
					<input type="hidden" id="dok_lain" value="<?php if($dok_lain) echo $dok_lain['id']; else echo "";?>">

          <?php } ?>
          <?php if($id_m_layanan == 8) { ?>
					<input type="hidden" id="stlud" value="<?php if($stlud) echo $stlud['id']; else echo "";?>">
					<input type="hidden" id="diklat" value="<?php if($diklat) echo $diklat['id']; else echo "";?>">
					<input type="hidden" id="skjabterusmenerus" value="<?php if($skjabterusmenerus) echo $skjabterusmenerus['id']; else echo "";?>">
          <?php } else if($id_m_layanan == 9) { ?>
          <input type="hidden" id="stlud" value="<?php if($stlud) echo $stlud['id']; else echo "";?>">
					<input type="hidden" id="ibel" value="<?php if($ibel) echo $ibel['id']; else echo "";?>">
					<input type="hidden" id="pangkalandata" value="<?php if($pangkalandata) echo $pangkalandata['id']; else echo "";?>">
					<input type="hidden" id="uraiantugas" value="<?php if($uraiantugas) echo $uraiantugas['id']; else echo "";?>">
					<input type="hidden" id="akreditasi" value="<?php if($akreditasi) echo $akreditasi['id']; else echo "";?>">
          
          <?php } ?>
				
					<div class="list-type1x">
						<ol class="rectangle-list">
              <?php if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14) { ?>
							<li>
								<a class="<?php if($formasi){ if($formasi['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($formasi) { ?>
									onclick="viewBerkasPangkat('<?=$formasi['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Surat Pernyataan Tersedia Formasi* <i
											class="fas fa-<?php if($formasi) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($pak){ if($pak['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($pak) { ?>
									onclick="viewBerkasPangkat('<?=$pak['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> PAK* <i
											class="fas fa-<?php if($pak) echo ''; else echo '';?>"></i></a>
							</li>
              
              <?php } ?>
              <?php if($id_m_layanan == 12) { ?>
                <li>
				<a class="<?php if($skp1){ if($skp1['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($skp1) { ?>
				onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> SKP tahun <?=$tahun_1_lalu;?> (hasil unduh aplikasi e-kinerja, telah sinkron SIASN)* <i
				class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
				</li>
        <li>
				<a class="<?php if($sertiukom){ if($sertiukom['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($sertiukom) { ?>
				onclick="viewBerkasPangkat('<?=$sertiukom['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Sertifikat Lulus Uji Kompetensi (maximal 3 bulan sebelum expired)* <i
				class="fas fa-<?php if($sertiukom) echo ''; else echo '';?>"></i></a>
				</li>
                <li>
				<a class="<?php if($peta_jabatan){ if($peta_jabatan['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($peta_jabatan) { ?>
				onclick="viewBerkasPangkat('<?=$peta_jabatan['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Peta Jabatan* <i
				class="fas fa-<?php if($peta_jabatan) echo ''; else echo '';?>"></i></a>
				</li>
                <li>
				<a class="<?php if($sk_jabatan_fungsional) echo 'select'; else echo 'unselect';?>" <?php if($sk_jabatan_fungsional) { ?>
				onclick="viewBerkasPangkat('<?=$sk_jabatan_fungsional['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> SK Jabatan Fungsional Terakhir* <i
				class="fas fa-<?php if($sk_jabatan_fungsional) echo ''; else echo '';?>"></i></a>
                </li>
                
                <li>
				<a class="<?php if($dok_lain) echo 'select'; else echo 'unselect';?>" <?php if($dok_lain) { ?>
				onclick="viewBerkasPangkat('<?=$dok_lain['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Dokumen lain yang apabila diperlukan <i
				class="fas fa-<?php if($dok_lain) echo ''; else echo '';?>"></i></a>
                </li>
        <?php } ?>
        <?php if($id_m_layanan == 13) { ?>
          <li>
				<a class="<?php if($skp1){ if($skp1['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($skp1) { ?>
				onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> SKP tahun <?=$tahun_1_lalu;?> (hasil unduh aplikasi e-kinerja, telah sinkron SIASN)* <i
				class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
				</li>
        <li>
				<a class="<?php if($skp1){ if($skp1['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($skp1) { ?>
				onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> SKP tahun <?=$tahun_2_lalu;?> (hasil unduh aplikasi e-kinerja, telah sinkron SIASN)* <i
				class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
				</li>
          <li>
				<a class="<?php if($sertiukom){ if($sertiukom['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($sertiukom) { ?>
				onclick="viewBerkasPangkat('<?=$sertiukom['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Sertifikat Lulus Uji Kompetensi (maximal 3 bulan sebelum expired)* <i
				class="fas fa-<?php if($sertiukom) echo ''; else echo '';?>"></i></a>
				</li>
        <li>
				<a class="<?php if($peta_jabatan){ if($peta_jabatan['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($peta_jabatan) { ?>
				onclick="viewBerkasPangkat('<?=$peta_jabatan['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Peta Jabatan* <i
				class="fas fa-<?php if($peta_jabatan) echo ''; else echo '';?>"></i></a>
				</li>
        <li>
				<a class="<?php if($sk_jabatan_fungsional) echo 'select'; else echo 'unselect';?>" <?php if($sk_jabatan_fungsional) { ?>
				onclick="viewBerkasPangkat('<?=$sk_jabatan_fungsional['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> SK Jabatan Fungsional Terakhir* <i
				class="fas fa-<?php if($sk_jabatan_fungsional) echo ''; else echo '';?>"></i></a>
        </li>
        <li>
				<a class="<?php if($str_serdik) echo 'select'; else echo 'unselect';?>" <?php if($str_serdik) { ?>
				onclick="viewBerkasPangkat('<?=$str_serdik['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> STR (kersehatan) / Serdik (pendidikan) <i
				class="fas fa-<?php if($str_serdik) echo ''; else echo '';?>"></i></a>
        </li>
        <li>
				<a class="<?php if($skp1){ if($ijazah['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($ijazah) { ?>
				onclick="viewBerkasPangkat('<?=$ijazah['gambarsk'];?>',7)" data-toggle="modal" data-target="#exampleModal"
				<?php } ?>> <i class="fa fa-file-pdf"></i> Ijazah* <i
				class="fas fa-<?php if($ijazah) echo ''; else echo '';?>"></i></a>
				</li>
              <?php } ?>
              <?php if($id_m_layanan == 8) { ?>
                <li>
								<a class="<?php if($skjabterusmenerus) echo 'select'; else echo 'unselect';?>" <?php if($skjabterusmenerus) { ?>
									onclick="viewBerkasPangkat('<?=$skjabterusmenerus['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK Jabatan Struktural secara terus menerus dan Surat Pernyataan Pelantikan Jabatan Struktural*<i
											class="fas fa-<?php if($skjabterusmenerus) echo ''; else echo '';?>"></i></a>
							</li>
                <li>
								<a class="<?php if($stlud) echo 'select'; else echo 'unselect';?>" <?php if($stlud) { ?>
									onclick="viewBerkasPangkat('<?=$stlud['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i>  Sertifikat Ujian Dinas (STLUD) (bagi PNS yang pindah dari golongan III ke IV) <i
											class="fas fa-<?php if($stlud) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($diklat) echo 'select'; else echo 'unselect';?>" <?php if($diklat) { ?>
									onclick="viewBerkasPangkat('<?=$diklat['gambarsk'];?>',4)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Sertifikat Diklat PIM III (bagi PNS yang pindah dari golongan III ke IV) <i
											class="fas fa-<?php if($diklat) echo ''; else echo '';?>"></i></a>
							</li>
             
             
              <?php } ?>
              <?php if($id_m_layanan == 9) { ?>
                <li>
								<a class="<?php if($uraiantugas) echo 'select'; else echo 'unselect';?>" <?php if($uraiantugas) { ?>
									onclick="viewBerkasPangkat('<?=$uraiantugas['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Asli Surat Keterangan Uraian Tugas sesuai dengan Ijazah yang diperoleh dan ditandatangani oleh serendah-rendahnya Pejabat Eselon II definitif (Khusus Pelaksana)<i
											class="fas fa-<?php if($uraiantugas) echo ''; else echo '';?>"></i></a>
							</li>
                <li>
								<a class="<?php if($pangkalandata) echo 'select'; else echo 'unselect';?>" <?php if($pangkalandata) { ?>
									onclick="viewBerkasPangkat('<?=$pangkalandata['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i>  Ijazah terakhir/transkrip nilai dan tampilan layar Pangkalan Data/Forlap Dikti*<i
											class="fas fa-<?php if($pangkalandata) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($ibel) echo 'select'; else echo 'unselect';?>" <?php if($ibel) { ?>
									onclick="viewBerkasPangkat('<?=$ibel['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Ijin Belajar atau fotokopi legalisir SK Tugas Belajar*<i
											class="fas fa-<?php if($ibel) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($stlud) echo 'select'; else echo 'unselect';?>" <?php if($stlud) { ?>
									onclick="viewBerkasPangkat('<?=$stlud['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Surat Tanda Lulus Kenaikan Pangkat Penyesuaian Ijazah*<i
											class="fas fa-<?php if($stlud) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($sertiukom) echo 'select'; else echo 'unselect';?>" <?php if($sertiukom) { ?>
									onclick="viewBerkasPangkat('<?=$sertiukom['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Sertifikat Uji Kompetensi (bagi PNS yang pindah jenjang jabatan fungsional) <i
											class="fas fa-<?php if($sertiukom) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($sk_jabatan_fungsional) echo 'select'; else echo 'unselect';?>" <?php if($sk_jabatan_fungsional) { ?>
									onclick="viewBerkasPangkat('<?=$sk_jabatan_fungsional['gambarsk'];?>',5)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK Jabatan Fungsional<i
											class="fas fa-<?php if($sk_jabatan_fungsional) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($akreditasi) echo 'select'; else echo 'unselect';?>" <?php if($akreditasi) { ?>
									onclick="viewBerkasPangkat('<?=$akreditasi['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Akreditasi Program Studi*<i
											class="fas fa-<?php if($akreditasi) echo ''; else echo '';?>"></i></a>
							</li>
              <li>
								<a class="<?php if($pak) echo 'select'; else echo 'unselect';?>" <?php if($pak) { ?>
									onclick="viewBerkasPangkat('<?=$pak['gambarsk'];?>',6)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> PAK (Khusus pejabat fungsional) <i
											class="fas fa-<?php if($pak) echo ''; else echo '';?>"></i></a>
							</li>
              <?php } ?>
						</ol>
					</div>


          <?php if($status_layanan['status'] == 1) { ;?>
					<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
          <?php } else { ?>
            <p>
              <h4>
            <b style="color:red;">
              Layanan kenaikan pangkat sudah ditutup dan akan dibuka kembali pada periode kenaikan pangkat berikutnya.<br>
              periode kenaikan pangkat april 2025 (dibuka pada tanggal 22 januari - 19 februari 2025)
            </b>
          </h4>
          </p>
          <?php }  ?>
				</form>
				<p class="mt-5">
					Keterangan :<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
					Berkas Sudah diupload<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2">  &nbsp;
					</button> Berkas belum diupload<br>
          <button style="width:3%" class="btn btn-sm filter-btn filter-warning mt-2">  &nbsp;
		  </button> Menunggu Verifikasi BKPSDM<br><br>
          <span class="mt-2">Berkas dengan tanda * Wajib diupload</span><br>
					Berkas diupload Pada Menu Profil <br>
          <?php if($id_m_layanan == 12) { ?>
          Untuk Berkas : <br>
                    <i class="fa fa-file-pdf"></i> Surat Pernyataan Tersedia Formasi<br>
					<i class="fa fa-file-pdf"></i> PAK<br>
					<i class="fa fa-file-pdf"></i> Sertifikat Uji Kompetensi <br>
					<i class="fa fa-file-pdf"></i> Peta Jabatan <br>
					<i class="fa fa-file-pdf"></i> Dokumen lain
					<br>di upload pada pilihan Arsip Lainnya.
				</p>
        <?php } ?>
        <?php if($id_m_layanan == 13) { ?>
          
        <?php } ?>
        <?php if($id_m_layanan == 14) { ?>
        
        <?php } ?>
        <?php if($id_m_layanan == 15) { ?>
         
        <?php } ?>
        <?php if($id_m_layanan == 16) { ?>
         
         <?php } ?>	
			</div>
		</div>
	</div>
	<div class="col-lg-12 mt-3">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<div class="card-title">
						<h5>RIWAYAT LAYANAN</h5>
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
var id_m_layanan = "<?=$id_m_layanan;?>"
$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  loadListRiwayatLayananPangkat()
    })
    $('#form_layanan_pangkat').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_layanan_pangkat');
        var form_data = new FormData(formvalue[0]);

        var ins = document.getElementById('pdf_surat_pengantar').files.length;
        var skp1 = $('#skp1').val()
        var skp2 = $('#skp2').val()
        var pak = $('#pak').val()
        var formasi = $('#formasi').val()
        var peta_jabatan = $('#peta_jabatan').val()
        var sk_jabatan_fungsional = $('#sk_jabatan_fungsional').val()
        var sertiukom = $('#sertiukom').val()

        var id_m_layanan = "<?=$id_m_layanan;?>"
       
        if(id_m_layanan == 12 ){
        if(skp1 == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(formasi == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(pak == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(peta_jabatan == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(sk_jabatan_fungsional == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(sertiukom == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
        }

        if(id_m_layanan == 13){
      
        }

        if(id_m_layanan == 14){
      
        }

        if(id_m_layanan == 15){
       
        }
        
        if(id_m_layanan == 16){
       
        }

        
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananPangkat/")?>"+id_m_layanan,
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
                loadListRiwayatLayananPangkat()
                window.scrollTo(0, document.body.scrollHeight);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });


    function viewBerkasPangkat(filename,id){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    var number = Math.floor(Math.random() * 1000);
    if(id == 1){
        $link = "<?=base_url();?>/arsipberkaspns/"+filename+"?v="+number;

    } else if(id == 2){
        $link = "<?=base_url();?>/arsipelektronik/"+filename+"?v="+number;

    } else if(id == 3){
        $link = "<?=base_url();?>/arsipskp/"+filename+"?v="+number;
    } else if(id == 4){
        $link = "<?=base_url();?>/arsipdiklat/"+filename+"?v="+number;
    } else if(id == 5){
        $link = "<?=base_url();?>/arsipjabatan/"+filename+"?v="+number;
    } else if(id == 6){
        $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
    } else if(id == 7){
        $link = "<?=base_url();?>/arsippendidikan/"+filename+"?v="+number;
    }
   
   
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

  function loadListRiwayatLayananPangkat(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatLayanan/")?>'+id_m_layanan, function(){
      $('#loader').hide()
    })
    }


    $("#pdf_surat_pengantar").change(function (e) {

    // var extension = pdf_surat_pengantar.value.split('.')[1];
    var doc = pdf_surat_pengantar.value.split('.')
    var extension = doc[doc.length - 1]
    var fileSize = this.files[0].size/1024;
    var MaxSize = 1024;

    if (extension != "pdf"){
      errortoast("Harus File PDF")
      $(this).val('');
    }

    if (fileSize > MaxSize ){
      errortoast("Maksimal Ukuran File 1 MB")
      $(this).val('');
    }


    });
</script>