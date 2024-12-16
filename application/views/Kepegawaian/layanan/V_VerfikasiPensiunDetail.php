<style>
  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: #222e3c;
    color: #fff;
  }
  .nav-pills .nav-link {
    color: #000;
    border: 0;
    border-radius: var(--bs-nav-pills-border-radius);
  }

  .nav-link-layanan{
    padding: 5px !important;
    font-size: .7rem;
    color: black;
    border-right: .5px solid var(--primary-color) !important;
    border-radius: 0px !important;
    border-bottom-left-radius: 0px;
  }

  .nav-item-layanan:hover, .nav-link-layanan:hover{
    color: white !important;
    background-color: #222e3c91;
    border-color: 1px solid var(--primary-color) !important;
  }
  .customTextarea { width: 100% !important; height: 75px!important; }

  .sp_profil{
    font-size: .9rem;
    font-weight: bold;
  }

  .sp_profil_sm{
    font-size: .8rem;
    font-weight: bold;
  }

  .sp_label{
    font-size: .6rem;
    font-style: italic;
    font-weight: 600;
    /* color: grey; */
    color: #babfc3;

  }

  .div_label{
    margin-bottom: -5px;
  }

  #profile_pegawai{
      width: 150px;
      height: calc(150px * 1.25);
      background-size: cover;
      object-fit: cover;
      /* box-shadow: 5px 5px 10px #888888; */
      border-radius: 10%;
  }

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


<div class="container-fluid pt-2" style="background-color:#fff;">
	<div class="row" style="background-color:#fff;">
		<div class="col-12">

    <table>
      <td>
      <a href="<?= base_url('kepegawaian/verifikasi-pensiun');?>">
        <button  class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
      </a>
      </td>
      <td>
      <button id="btn_verifikasi" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modelVerif">
        Verifikasi
        </button>
        <form method="post" id="form_batal_verifikasi_layanan" enctype="multipart/form-data" >
        <input type="hidden" name="id_batal" id="id_batal" value="<?= $result[0]['id_pengajuan'];?>">
        <button  id="btn_tolak_verifikasi"  class="btn btn-danger ml-2" style="display:nonex;">
        Batal Verif
        </button>
        </form>
      </td>
    </table>
  
  
        
        <br>
  <!-- <div style="margin-top:8px;margin-bottom:8px;background-color:#deb887;" class="col-lg-12 badge  text-dark"> <h5 style="margin-top:5px;"> Verifikasi Layanan <?=$result[0]['nama_layanan'];?> </h5></div> -->
  
  



   <div class="row">
     <!-- profil -->
   <div class="col-md-4" style="background-color:#222e3c;color:#fff;">
   <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <?php if($result[0]['statuspeg'] == 1){ ?>
            <div class="col-lg-12 text-left">
              <h3><span class="badge badge-danger">CPNS</span></h3>
            </div>
          <?php } ?>
          <div class="col-lg-12 text-center mt-2">
          <a href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$result[0]['nipbaru_ws']?>" target="_blank">
          <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                            data-src="<?php
                                $path = './assets/fotopeg/'. $result[0]['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'. $result[0]['fotopeg'];
                                if( $result[0]['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'. $result[0]['fotopeg'];
                                  //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  $src = './assets/img/user.png';
                                  // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                  $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> </a>

           
          </div>
          <div class="col-lg-12 text-center">
            <span class="sp_profil">
              <?=$result[0]['gelar1'] != '' ? $result[0]['gelar1'].' ' : ''.$result[0]['nama_pegawai'].$result[0]['gelar2']?>
            </span>
          </div>
          <div class="col-lg-12 text-center" >
            <span class="sp_profil">
              <?=formatNip($result[0]['nipbaru_ws'])?>
            </span>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 div_label text-left">
            <span class="sp_label">
              Perangkat Daerah
            </span>
          </div>
          <div class="col-lg-12 text-left" >
            <span class="sp_profil_sm">
              <?=($result[0]['nm_unitkerja'])?>
            </span>
          </div>
          <div class="col-lg-12"></div>
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-12 div_label text-left">
                  <span class="sp_label">
                    Pangkat / Gol. Ruang
                  </span>
                </div>
                <div class="col-lg-12 text-left" >
                  <span class="sp_profil_sm">
                    <?=($result[0]['nm_pangkat'])?>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-right">
                <span class="sp_label">
                  TMT Pangkat
                </span>
              </div>
              <div class="col-lg-12 text-right" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($result[0]['tmtpangkat'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($result[0]['nama_jabatan'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-right">
                <span class="sp_label">
                  TMT Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-right" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($result[0]['tmtjabatan'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  NIK (Nomor Induk Kependudukan)
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($result[0]['nik'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-right">
                <span class="sp_label">
                  Agama
                </span>
              </div>
              <div class="col-lg-12 text-right" >
                <span class="sp_profil_sm">
                  <?=($result[0]['nm_agama'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Tempat, Tanggal Lahir
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                  <?=($result[0]['tptlahir'].', '.formatDateNamaBulan($result[0]['tgllahir']))?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-right">
                <span class="sp_label">
                  Jenis Kelamin / Umur
                </span>
              </div>
              <div class="col-lg-12 text-right">
                <span class="sp_profil_sm">
                  <?=$result[0]['jk'].' / '.countDiffDateLengkap(date('Y-m-d'), $result[0]['tgllahir'], ['tahun', 'bulan'])?>
                </span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Email
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                <?=($result[0]['email'])?>
                </span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-lg-12 div_label text-right">
                <span class="sp_label">
                  No Handphone/WA
                </span>
              </div>
              <div class="col-lg-12 text-right">
                <span class="sp_profil_sm">
                <?=($result[0]['handphone'])?>
                </span>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Alamat
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                <?=($result[0]['alamat'])?>
                </span>
              </div>
            </div>

            

          </div>
        </div>
      </div>
    </div>
   </div>
    <!-- tutup profil -->

   <!-- berkas -->
   <div class="col-md-8">
    <!-- berkas persyaratan -->
<span>Berkas Persyaratan  <?php if($jenis_layanan == 1) { ?>
   <b>Pensiun BUP</b>
    <?php } else if($jenis_layanan == 2) { ?>
     <b>Pensiun Janda/Duda</b>
      <?php } else if($jenis_layanan == 3) { ?>
       <b>Pensiun Atas Permintaan Sendiri</b>
      <?php } else if($jenis_layanan == 4) { ?>
        <b>Pensiun Sakit/Uzur</b>
        <?php } else if($jenis_layanan == 5) { ?>
          <b>Pensiun Tewas</b>
          <?php } ?></span>
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
								<a class="<?php if($sk_pangkat) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
									onclick="viewBerkas('<?=$sk_pangkat['gambarsk'];?>',2)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK PANGKAT* </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skjabatan)) { ?>
							<li>
								<a class="<?php if($sk_jabatan) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
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
<!-- berkas persyaratan -->
   </div>
 <!-- tutup berkas -->

   </div>



<!-- Modal -->
<div class="modal fade" id="modelVerif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_verifikasi_layanan" enctype="multipart/form-data" >
        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $result[0]['id_pengajuan'];?>">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example" name="status" id="status">
        <option selected>--</option>
        <option value="1">ACC</option>
        <option value="2">TOLAK</option>
        <!-- <option value="3">TMS</option> -->
      </select>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Catatan</label>
        <textarea class="form-control customTextarea" name="keterangan" id="keterangan" rows="3" ></textarea>
      </div>
    
      <button id="btn_verif" class="btn btn-primary" style="float: right;">Simpan</button>
    </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
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

var nip = "<?= $result[0]['nip'];?>"; 
var status = "<?= $result[0]['status'];?>"; 

$(function(){
  $( "#sidebar_toggle" ).trigger( "click" );

   if(status == 0){
    $('#btn_tolak_verifikasi').hide()
    $('#btn_verifikasi').show()
   } else if(status == 1) {
    $('#btn_tolak_verifikasi').show()
    $('#btn_verifikasi').hide()
   } else if(status == 2) {
    $('#btn_tolak_verifikasi').show()
    $('#btn_verifikasi').hide()
   }
  })

function openProfileTab(){
  $('#view_file_verif').hide()
}

function openPresensiTab(){
  $('#view_file_verif').hide()
  $('#pills-presensi').html('')
  $('#pills-presensi').append(divLoaderNavy)
  $('#pills-presensi').load('<?=base_url("kepegawaian/C_Kepegawaian/openPresensiTab/".$result[0]['id_m_user'])?>', function(){
    $('#loader').hide()
  })
}

  
  async function getFile(file){
    $('#view_file_verif').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    $('#ket').html('');
   
    if(file == "skcpns"){
          dir = "arsipberkaspns/";
        } else if(file == "skpns"){
          dir = "arsipberkaspns/";
        } else if(file == "laporan_perkawinan" || file == "daftar_keluarga" || file == "pas_foto" || file == "akte_nikah"){
          dir = "arsiplain/";
        }  else {
          dir = "uploads/";
        }

    //     var number = Math.floor(Math.random() * 1000);
    //     var link = "<?=base_url();?>/arsipberkaspns/11250SK_PNS_199401042020121011.pdf?v="+number;
    //     $('#view_file_verif').attr('src', link)
    //        $('#view_file_verif').on('load', function(){
    //      $('.iframe_loader').hide()
    //      $(this).show()
    //    })

   var id_peg = "<?=$result[0]['id_peg'];?>";
   $.ajax({
        type : "POST",
        url  : "<?=base_url();?>" + '/kepegawaian/C_Kepegawaian/getFileForKarisKarsu',
        dataType : "JSON",
        data : {id_peg:id_peg,file:file},
        success: function(data){
        $('#divloader').html('')
      
        if(data != ""){
          if(data[0].gambarsk != ""){
            var number = Math.floor(Math.random() * 1000);
            var link = "<?=base_url();?>/"+dir+"/"+data[0].gambarsk+"?v="+number;
            // var link = "<?=base_url();?>/arsipberkaspns/tes.jpg?v="+number;
            $('#view_file_verif').attr('src', link)
           $('#view_file_verif').on('load', function(){
         $('.iframe_loader').hide()
         $(this).show()
       })
           
          } else {
            $('#view_file_verif').attr('src', '')
            $('#ket').html('Tidak ada data');
          }
        } else {
        // errortoast('tidak ada data')
        $('.iframe_loader').hide()  
        $('#view_file_verif').attr('src', '')
        $('#ket').html('Tidak ada data');
        }
        }
        });
 }



        $('#form_verifikasi_layanan').on('submit', function(e){
          var status = $('#status').val()
          var catatan = $('#keterangan').val()
          if(status == "--"){
            errortoast('Silahkan Pilih Status')
            return false;
           }

           if(status == "2"){
           if(catatan == ""){
            errortoast('Silahkan mengisi catatan')
            return false;
           }
           }


            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiPengajuanPensiun")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  successtoast('Data Berhasil Diverifikasi')
                  // loadListUsulLayanan(1)
                  $('#btn_tolak_verifikasi').show()
                  $('#btn_verifikasi').hide()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

        $('#form_batal_verifikasi_layanan').on('submit', function(e){
          
            e.preventDefault()
            if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiPengajuanPensiun")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  successtoast('Berhasil batal verifikasi ')
                  $('#btn_tolak_verifikasi').hide()
                  $('#btn_verifikasi').show()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
          }
        })


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


 
  $('#bulan').on('change', function(){
  $('#form_presensi_pegawai').submit();
 })

 $('#tahun').on('change', function(){
  $('#form_presensi_pegawai').submit();
})

 $('#form_presensi_pegawai').on('submit', function(e){
    e.preventDefault()
    $('#div_presensi_result').html('')
    $('#div_presensi_result').append(divLoaderNavy)
    $.ajax({
        url: '<?=base_url("user/C_User/searchDetailAbsenPegawai/1/".$result[0]['id_m_user'])?>',
        method: 'post',
        data: $(this).serialize(),
        success: function(data){
            $('#div_presensi_result').html('')
            $('#div_presensi_result').append(data)
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
    })
})

 function loadPresensiPegawai(){
  $('#form_presensi_pegawai').submit();
 }

</script>
