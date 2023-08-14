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
    color: grey;
  }

  .div_label{
    margin-bottom: -5px;
  }
</style>


<div class="container-fluid pt-2" style="background-color:#fff;">
	<div class="row" style="background-color:#fff;">
		<div class="col-12">
   <div class="12">
   <a href="<?= base_url('kepegawaian/teknis');?>">
    <button  class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
  </a>
  <!-- <div style="margin-top:8px;margin-bottom:8px;background-color:#deb887;" class="col-lg-12 badge  text-dark"> <h5 style="margin-top:5px;"> Verifikasi Layanan <?=$result[0]['nama_layanan'];?> </h5></div> -->
  
  <!-- <?php if($jenis_layanan == 3) { ?>
   <table style="width: 100%;" class="table table_dok_detail">
          <tr>
            <td class="td-lab-dd">Jenis Cuti</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"> <?=$result[0]['nm_cuti'];?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Mulai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result[0]['tanggal_mulai'];?></td>
          </tr>
          <tr>
            <td class="td-lab-dd">Tanggal Selesai</td>
            <td class="td-smc-dd">:</td>
            <td class="td-val-dd"><?=$result[0]['tanggal_selesai'];?></td>
          </tr>
        </table>
        <?php } ?> -->
   </div>


<div class="row">
	<div class="col-md-6" style="border-right: 5px solid black; ">
					<!-- <span class="headerSection">Surat Pengantar</span> -->
  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan " role="presentation">
    <button class="nav-link nav-link-layanan active"  data-bs-toggle="pill" data-bs-target="#pills-supen" type="button" role="tab" aria-controls="pills-supen" aria-selected="false">Surat Pengantar</button>
  </li>
  <?php if($result[0]['jenis_layanan'] == 3) { ?>
    <!-- <?php if($result['0']['surat_keterangan']) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan " id="pills-profil-tab"
    data-bs-toggle="pill" data-bs-target="#pills-suket" type="button" role="tab" aria-controls="pills-suket" aria-selected="false">Surat Keterangan</button>
  </li>
  <?php } ?> -->
  <?php } ?>
  </ul>
      <hr style="margin-top: 10px;">
					
   
  <div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-supen" role="tabpanel" aria-labelledby="pills-supen-tab">
 
  <?php if($result[0]['jenis_layanan'] == 3) { ?>
  <iframe id="" style="width: 100%; height: 100vh;"
						src="<?=base_url();?>dokumen_layanan/<?= $result['0']['nama_layanan'];?>/<?= $result['0']['nip'];?>/<?= $result['0']['file_pengantar'];?>"></iframe>
  <?php } else { ?>
              <iframe id="" style="width: 100%; height: 100vh;"
						src="<?=base_url();?>dokumen_layanan/<?= $result['0']['nip'];?>/<?= $result['0']['file_pengantar'];?>"></iframe>
 <?php } ?>
 </div>

  <div class="tab-pane fade show " id="pills-suket" role="tabpanel" aria-labelledby="pills-suket-tab">
  <iframe id="" style="width: 100%; height: 100vh;"
						src="<?=base_url();?>dokumen_layanan/<?= $result['0']['nama_layanan'];?>/<?= $result['0']['nip'];?>/<?= $result['0']['surat_keterangan'];?>"></iframe>
  </div>


 
  </div>    
          </div>
				<div class="col-md-6" style="height:100px;">



  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="openProfileTab()" class="nav-link nav-link-layanan active" id="pills-profil-tab"
    data-bs-toggle="pill" data-bs-target="#pills-profil" type="button" role="tab" aria-controls="pills-profil" aria-selected="false">Profil</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="openPresensiTab()" class="nav-link nav-link-layanan" id="pills-presensi-tab"
    data-bs-toggle="pill" data-bs-target="#pills-presensi" type="button" role="tab" aria-controls="pills-presensi" aria-selected="false">Presensi</button>
  </li>
  <?php if (in_array($result[0]['jenis_layanan'], $pangkat)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pangkat')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pangkat</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $gaji_berkala)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='gajiberkala')" class="nav-link nav-link-layanan" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-berkala" aria-selected="false">Gaji Berkala</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $pendidikan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="loadRiwayatUsulPendidikan()" class="nav-link nav-link-layanan" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-pendidikan" aria-selected="false">Pendidikan</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $jabatan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='jabatan')" class="nav-link nav-link-layanan" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-jabatan" aria-selected="false">Jabatan</button>
  </li>
  <?php } ?>

 <?php if (in_array($result[0]['jenis_layanan'], $diklat)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='diklat')" class="nav-link nav-link-layanan" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-diklat" aria-selected="false">Diklat</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $organisasi)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormOrganisasi()" class="nav-link nav-link-layanan" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-organisasi" aria-selected="false">Organisasi</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $penghargaan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormPendidikan()" class="nav-link nav-link-layanan" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-penghargaan" aria-selected="false">Penghargaan</button>
  </li>
  <?php } ?>

 <?php if (in_array($result[0]['jenis_layanan'], $sj)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $keluarga)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-keluarga" type="button" role="tab" aria-controls="pills-keluarga" aria-selected="false">Keluarga</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $penugasan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#pills-penugasan" type="button" role="tab" aria-controls="pills-penugasan" aria-selected="false">Penugasan</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $cuti)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan" id="pills-penugasan-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">Cuti</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $skcpns)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skcpns')" class="nav-link nav-link-layanan" id="pills-skcpns-tab" data-bs-toggle="pill" data-bs-target="#pills-skcpns" type="button" role="tab" aria-controls="pills-skcpns" aria-selected="false">SK CPNS</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $skpns)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skpns')" class="nav-link nav-link-layanan" id="pills-skpns-tab" data-bs-toggle="pill" data-bs-target="#pills-skpns" type="button" role="tab" aria-controls="pills-skpns" aria-selected="false">SK PNS</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $skp)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skp')" class="nav-link nav-link-layanan" id="pills-skp-tab" data-bs-toggle="pill" data-bs-target="#pills-skp" type="button" role="tab" aria-controls="pills-skp" aria-selected="false">SKP</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $drp)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='drp')"  class="nav-link nav-link-layanan" id="pills-drp-tab" data-bs-toggle="pill" data-bs-target="#pills-drp" type="button" role="tab" aria-controls="pills-drp" aria-selected="false">DRP</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $honor)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='honor')"  class="nav-link nav-link-layanan" id="pills-honor-tab" data-bs-toggle="pill" data-bs-target="#pills-honor" type="button" role="tab" aria-controls="pills-honor" aria-selected="false">Honor</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $honor)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='suket_lain')"  class="nav-link nav-link-layanan" id="pills-suket_lain-tab" data-bs-toggle="pill" data-bs-target="#pills-suket_lain" type="button" role="tab" aria-controls="pills-suket_lain" aria-selected="false">Suket Lain</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $ibel)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='ibel')"  class="nav-link nav-link-layanan" id="pills-ibel-tab" data-bs-toggle="pill" data-bs-target="#pills-ibel" type="button" role="tab" aria-controls="pills-ibel" aria-selected="false">Ijin Belajar</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $tubel)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='tubel')"  class="nav-link nav-link-layanan" id="pills-tubel-tab" data-bs-toggle="pill" data-bs-target="#pills-tubel" type="button" role="tab" aria-controls="pills-ibel" aria-selected="false">Tugas Belajar</button>
  </li>
  <?php } ?>
  


  <?php if (in_array($result[0]['jenis_layanan'], $forlap)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='forlap')"  class="nav-link nav-link-layanan" id="pills-forlap-tab" data-bs-toggle="pill" data-bs-target="#pills-forlap" type="button" role="tab" aria-controls="pills-forlap" aria-selected="false">Forlap Dikti</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $karya_tulis)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='karya_tulis')"  class="nav-link nav-link-layanan" id="pills-karya_tulis-tab" data-bs-toggle="pill" data-bs-target="#pills-karya_tulis" type="button" role="tab" aria-controls="pills-karya_tulis" aria-selected="false">Karya Tulis</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $mutasi)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='mutasi')"  class="nav-link nav-link-layanan" id="pills-mutasi-tab" data-bs-toggle="pill" data-bs-target="#pills-mutasi" type="button" role="tab" aria-controls="pills-mutasi" aria-selected="false">Mutasi</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $serkom)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='serkom')"  class="nav-link nav-link-layanan" id="pills-serkom-tab" data-bs-toggle="pill" data-bs-target="#pills-serkom" type="button" role="tab" aria-controls="pills-serkom" aria-selected="false">Sertifikat Kompetensi</button>
  </li>
  <?php } ?>
  
  <?php if (in_array($result[0]['jenis_layanan'], $pak)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="getFile(file='pak')"  class="nav-link nav-link-layanan" id="pills-pak-tab" data-bs-toggle="pill" data-bs-target="#pills-pak" type="button" role="tab" aria-controls="pills-pak" aria-selected="false">PAK</button>
  </li>
  <?php } ?>
  


</ul>
<hr style="margin-top: 10px;">
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <div style="margin-left:10px;"></div>
  </div>
  <div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
  <div id=""></div>
  </div>
  <div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-pendidikan-tab">
  <div id=""></div>
  </div>
  <div class="tab-pane fade" id="pills-jabatan" role="tabpanel" aria-labelledby="pills-jabatan-tab">
  <div id=""></div>
  </div>
  <div class="tab-pane fade" id="pills-diklat" role="tabpanel" aria-labelledby="pills-diklat-tab">
  <div id=""></div>
  </div>
  <div class="tab-pane fade" id="pills-organisasi" role="tabpanel" aria-labelledby="pills-organisasi-tab">
  <div id=""></div>
  </div>
  <div class="tab-pane fade" id="pills-penghargaan" role="tabpanel" aria-labelledby="pills-penghargaan-tab">
  <div id="form_penghargaan"></div>
  </div>
  <div class="tab-pane fade" id="pills-sj" role="tabpanel" aria-labelledby="pills-sj-tab">...</div>
  <div class="tab-pane fade" id="pills-keluarga" role="tabpanel" aria-labelledby="pills-keluarga-tab">...</div>
  <div class="tab-pane fade" id="pills-penugasan" role="tabpanel" aria-labelledby="pills-penugasan-tab">...</div>
  <div class="tab-pane fade" id="pills-cuti" role="tabpanel" aria-labelledby="pills-cuti-tab">...</div>
  <div class="tab-pane fade" id="pills-skcpns" role="tabpanel" aria-labelledby="pills-skcpns-tab">
  </div>
  <div class="tab-pane fade" id="pills-skpns" role="tabpanel" aria-labelledby="pills-skpns-tab">
  </div>
  <div class="tab-pane fade" id="pills-skp" role="tabpanel" aria-labelledby="pills-skp-tab">
  </div>
  <div class="tab-pane fade" id="pills-drp" role="tabpanel" aria-labelledby="pills-drp-tab">
  </div>
  <div class="tab-pane fade" id="pills-honor" role="tabpanel" aria-labelledby="pills-honor-tab">
  </div>
  <div class="tab-pane fade" id="pills-suket_lain" role="tabpanel" aria-labelledby="pills-suket_lain-tab">
  </div>
  <div class="tab-pane fade" id="pills-ibel" role="tabpanel" aria-labelledby="pills-ibel-tab">
  </div>
  <div class="tab-pane fade" id="pills-tubel" role="tabpanel" aria-labelledby="pills-tubel-tab">
  </div>
  <div class="tab-pane fade" id="pills-forlap" role="tabpanel" aria-labelledby="pills-forlap-tab">
  </div>
  <div class="tab-pane fade" id="pills-karya_tulis" role="tabpanel" aria-labelledby="pills-karya_tulis-tab">
  </div>
  <div class="tab-pane fade" id="pills-mutasi" role="tabpanel" aria-labelledby="pills-mutasi-tab">
  </div>
  <div class="tab-pane fade" id="pills-serkom" role="tabpanel" aria-labelledby="pills-serkom-tab">
  </div>
  <div class="tab-pane fade" id="pills-pak" role="tabpanel" aria-labelledby="pills-pak-tab">
  </div>
  <div class="tab-pane fade" id="pills-presensi" role="tabpanel" aria-labelledby="pills-presensi-tab"></div>
  <div class="tab-pane show active" id="pills-profil" role="tabpanel" aria-labelledby="pills-profil-tab">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <?php if($result[0]['statuspeg'] == 1){ ?>
            <div class="col-lg-12 text-left">
              <h3><span class="badge badge-danger">CPNS</span></h3>
            </div>
          <?php } ?>
          <div class="col-lg-12 text-center">
            <img style="width: 120px; height: 120px" class="img-fluid rounded-circle mb-2 b-lazy"
              src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== 
              data-src="<?=$this->general_library->getFotoPegawai($result[0]['fotopeg'])?>" />
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
          </div>
          <div class="col-lg-12 div_label text-left">
            <span class="sp_label">
              Alamat
            </span>
          </div>
          <div class="col-lg-12 text-left">
            <span class="sp_profil_sm sp_profil_alamat">
              <?=($result[0]['alamat'])?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<span id="ket"></span>
<div id="divloader" class="col-lg-12 text-center">
  
</div>
<!-- <iframe id="view_file_verif" style="width: 100%; height: 100vh;"></iframe> -->
<h5 style="display: none;"  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 100vh;" type="application/pdf"  id="view_file_verif"  frameborder="0" ></iframe>	

				</div>
			</div>
      
	

<button id="btn_verifikasi" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelVerif">
Verifikasi
</button>
<form method="post" id="form_batal_verifikasi_layanan" enctype="multipart/form-data" >
<input type="hidden" name="id_batal" id="id_batal" value="<?= $result[0]['id_usul'];?>">
<button  id="btn_tolak_verifikasi"  class="btn btn-danger" >
Batal Verif
</button>
</form>
<style>
</style>

    

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
        <input type="hidden" name="id_usul" id="id_usul" value="<?= $result[0]['id_usul'];?>">
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
        <textarea class="form-control customTextarea" name="keterangan" id="keterangan" rows="3"></textarea>
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
<script>

var jenis_user = 2; 
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

  // function getFileOld(file) {
  //       $('#view_file_verif').show()
  //       $('#divloader').append(divLoaderNavy)
  //       $('#view_file_verif').attr('src','');
  //       var jenis_layanan = "<?=$result[0]['jenis_layanan'];?>";
  //       var id_peg = "<?=$result[0]['id_peg'];?>";
  //       var base_url = "<?= base_url();?>";

  //       if(file == "pangkat"){
  //         dir = "arsipelektronik/";
  //       } else if(file == "jabatan"){
  //         dir = "arsipjabatan/";
  //       } else if(file == "pendidikan"){
  //         dir = "arsippendidikan/";
  //       } else if(file == "skcpns"){
  //         dir = "arsipberkaspns/";
  //       } else if(file == "skpns"){
  //         dir = "arsipberkaspns/";
  //       } else if(file == "gajiberkala"){
  //         dir = "arsipgjberkala/";
  //       } else if(file == "skp"){
  //         dir = "arsipskp/";
  //       } else if(file == "diklat"){
  //         dir = "arsipdiklat/";
  //       } else if(file == "drp" || file == "honor" || file == "suket_lain" || file == "ibel" || file == "forlap" || file == "karya_tulis" || file == "tubel" || file == "mutasi" || file == "serkom" || file == "pak"){
  //         dir = "arsiplain/";
  //       }    else {
  //         dir = "uploads/";
  //       }

        
  //       $.ajax({
  //       type : "POST",
  //       url  : base_url + '/kepegawaian/C_Kepegawaian/getFile',
  //       dataType : "JSON",
  //       data : {id_peg:id_peg,jenis_layanan:jenis_layanan,file:file},
  //       success: function(data){
  //       $('#divloader').html('')
  //       console.log(data)
  //       if(data != ""){
  //         if(data[0].gambarsk != ""){
  //           $('#view_file_verif').attr('src', base_url+dir+data[0].gambarsk)
  //         // $('#tes').val(base_url+'uploads/'+nip+'/'+data[0].gambarsk)
  //         $('#ket').html('');
  //         } else {
  //           $('#view_file_verif').attr('src', '')
  //           $('#ket').html('Tidak ada data');
  //         }
  //       } else {
  //       // errortoast('tidak ada data')
  //       $('#view_file_verif').attr('src', '')
  //       $('#ket').html('Tidak ada data');
  //       }
  //       }
  //       });
  //       }


  async function getFile(file){
    $('#view_file_verif').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    var jenis_layanan = "<?=$result[0]['jenis_layanan'];?>";
        var id_peg = "<?=$result[0]['id_peg'];?>";
        var base_url = "<?= base_url();?>";
    var filename = "";
    if(file == "pangkat"){
          dir = "arsipelektronik/";
        } else if(file == "jabatan"){
          dir = "arsipjabatan/";
        } else if(file == "pendidikan"){
          dir = "arsippendidikan/";
        } else if(file == "skcpns"){
          dir = "arsipberkaspns/";
        } else if(file == "skpns"){
          dir = "arsipberkaspns/";
        } else if(file == "gajiberkala"){
          dir = "arsipgjberkala/";
        } else if(file == "skp"){
          dir = "arsipskp/";
        } else if(file == "diklat"){
          dir = "arsipdiklat/";
        } else if(file == "drp" || file == "honor" || file == "suket_lain" || file == "ibel" || file == "forlap" || file == "karya_tulis" || file == "tubel" || file == "mutasi" || file == "serkom" || file == "pak"){
          dir = "arsiplain/";
        }    else {
          dir = "uploads/";
        }
  

   $.ajax({
        type : "POST",
        url  : base_url + '/kepegawaian/C_Kepegawaian/getFile',
        dataType : "JSON",
        data : {id_peg:id_peg,jenis_layanan:jenis_layanan,file:file},
        success: function(data){
        $('#divloader').html('')
        console.log(data)
        if(data != ""){
          if(data[0].gambarsk != ""){
            tes(data[0].gambarsk,dir)
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


 function tes(filename,dir){
  $.ajax({
     url: '<?=base_url("kepegawaian/C_Kepegawaian/fetchDokumenWs/")?>',
     method: 'POST',
     data: {
       'username': '<?=$this->general_library->getUserName()?>',
       'password': '<?=$this->general_library->getPassword()?>',
       'filename': dir+filename
     },
     success: function(data){
       let res = JSON.parse(data)
       console.log(res)
       $(this).show()
       $('#view_file_verif').attr('src', res.data)
       $('#view_file_verif').on('load', function(){
         $('.iframe_loader').hide()
         $(this).show()
       })
       
     }, error: function(e){
         errortoast('Terjadi Kesalahan')
     }
   })
 }




        $('#form_verifikasi_layanan').on('submit', function(e){
          var status = $('#status').val()
        
          if(status == "--"){
            errortoast('Silahkan Pilih Status')
          return false;
        }

            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiLayanan")?>',
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
                url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiLayanan")?>',
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


  


function loadFormPangkat(){
 $('#form_pangkat').html(' ')
   $('#form_pangkat').append(divLoaderNavy)
   $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>'+jenis_user+'/'+nip, function(){
   $('#loader').hide()    
   })
}

function loadFormGajiBerkala(){
 $('#form_gaji_berkala').html(' ')
   $('#form_gaji_berkala').append(divLoaderNavy)
   $('#form_gaji_berkala').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormGajiBerkala/')?>', function(){
   $('#loader').hide()    
   })
}

function loadRiwayatUsulPendidikan(){
  $('#divloader').append(divLoaderNavy)
  $('#view_file_verif').attr('src','');
    var nip = "<?= $result['0']['nip'];?>";
    $('#divloader').html('')
    $('#divloader').append(divLoaderNavy)
    $('#divloader').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListPendidikan/")?>'+nip+'/2', function(){
      $('#loader').hide()
    })
  }

function loadFormJabatan(){
 $('#form_jabatan').html(' ')
   $('#form_jabatan').append(divLoaderNavy)
   $('#form_jabatan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormJabatan/')?>'+jenis_user+'/'+nip, function(){
   $('#loader').hide()    
   })
}

function loadFormDiklat(){
 $('#form_diklat').html(' ')
   $('#form_diklat').append(divLoaderNavy)
   $('#form_diklat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDiklat/')?>', function(){
   $('#loader').hide()    
   })
}

function loadFormOrganisasi(){
 $('#form_organisasi').html(' ')
   $('#form_organisasi').append(divLoaderNavy)
   $('#form_organisasi').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormOrganisasi/')?>', function(){
   $('#loader').hide()    
   })
}

function loadFormPenghargaan(){
 $('#form_penghargaan').html(' ')
   $('#form_penghargaan').append(divLoaderNavy)
   $('#form_penghargaan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPenghargaan/')?>', function(){
   $('#loader').hide()    
   })
}

</script>
