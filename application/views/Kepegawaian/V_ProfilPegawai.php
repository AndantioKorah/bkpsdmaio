<?php
  if($profil_pegawai){
?>
  <style>
    .sp_profil{
      font-size: 1rem;
      font-weight: bold;
    }

    .sp_profil_nip{
      font-size: .9rem;
      font-weight: bold;
    }

    .sp_profil_sm{
      font-size: .8rem;
      font-weight: bold;
    }
    
    .hr_class{
      margin-top: 0px;
      margin-bottom: 0px;
      border: .05rem solid black;
    }

    .sp_profil_alamat{
      /* line-height: 100px; */
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

    .nav-link-profile{
      padding: 5px !important;
      font-size: .7rem;
      color: black;
      border: .5px solid var(--primary-color) !important;
      border-bottom-left-radius: 0px;
    }

    .nav-item-profile:hover, .nav-link-profile:hover{
      color: white !important;
      background-color: #222e3c91;
    }

    .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
      /* border-radius: 3px; */
      background-color: var(--primary-color);
      color: white;
    }

    .div.dataTables_wrapper div.dataTables_length select{
      height: 10px !important;
      width: 40px !important;
    }

    .div.dataTables_wrapper div.dataTables_filter input{
      height: 10px !important;
    }

    #profile_pegawai{
      aspect-ratio: 3 / 4;
      width: 100%;
      /* height: calc(350px * 1.25); */
      background-size: cover;
      object-fit: cover;
      box-shadow: 5px 5px 10px #888888;
      border-radius: 5%;
      /* border-color: green; */

    }
    
    .foto_container {
      position: relative;
      /* width: 50%; */
    }

.image-settings {
  opacity: 1;
  display: block;
  /* width: 100%; */
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.foto_container:hover .image {
  opacity: 0.3;
  cursor:pointer;
}

.foto_container:hover .middle {
  opacity: 1;
  cursor:pointer;
}

.select2.select2-container {
  /* width: 100% !important; */
  margin-bottom: 15px;
}

.badge_satyalencana{
  width: 3vw;
  cursor: pointer;
  padding: 0 !important;
  margin-left: -10px !important;
  margin-right: -10px !important;
}

.sp_whatsapp{
  color: #50575e !important;
  cursor: pointer;
  text-decoration: none;
}

.sp_whatsapp:hover{
  color: green !important;
  text-decoration: none;
  transition: .2s;
}

.badge-penerima-tpp{
  box-shadow: 3px 3px 10px #888888;
  background-color: #327ba8;
  border: 2px solid #327ba8;
  color: white;
}



  </style>


<?php
	$tpp = $this->session->userdata('live_tpp');
  // $jenis_jabatan = $tpp[0]['jenis_jabatan'];
?>


  <div class="row">
    <div class="col-lg-12">
      <div class="card card-default">
        <div class="row p-3">
          <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="row">
              <?php if(($this->general_library->isProgrammer() || $this->general_library->isHakAkses('login_another_user'))
                && !in_array($profil_pegawai['nipbaru_ws'], EXCLUDE_NIP_SWITCH_ACCOUNT)){ ?>
                <div class="col-lg-12 text-center mb-2">
                  <button class="btn btn-sm btn-outline-success" id="btn_login" onclick="loginAs('<?=$profil_pegawai['nipbaru_ws']?>')" type="button">
                    <i class="fa fa-key"></i> LOGIN</button>
                  <button disabled style="display: none;" class="btn btn-sm btn-outline-success" id="btn_login_loading" type="button">
                    <i class="fa fa-spin fa-spinner"></i> Loading...</button>
                </div>
              <?php } ?>
              <?php
                $badge_status = 'badge-cpns';
                if($profil_pegawai['statuspeg'] == 2){
                  $badge_status = 'badge-pns';
                } else if($profil_pegawai['statuspeg'] == 3){
                  $badge_status = 'badge-pppk';
                }

                $badge_aktif = 'badge-aktif';
                if($profil_pegawai['id_m_status_pegawai'] == 2){
                  $badge_aktif = 'badge-pensiun-bup';
                } else if($profil_pegawai['id_m_status_pegawai'] == 3){
                  $badge_aktif = 'badge-pensiun-dini';
                } else if($profil_pegawai['id_m_status_pegawai'] == 4){
                  $badge_aktif = 'badge-diberhentikan';
                } else if($profil_pegawai['id_m_status_pegawai'] == 5){
                  $badge_aktif = 'badge-mutasi';
                } else if($profil_pegawai['id_m_status_pegawai'] == 6){
                  $badge_aktif = 'badge-meninggal';
                } else if($profil_pegawai['id_m_status_pegawai'] == 8){
                  $badge_aktif = 'badge-tidak-aktif';
                }
              ?>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12 text-left">
                <span class="badge <?=$badge_status?>"><?=$profil_pegawai['nm_statuspeg']?></span>
                <span class="badge <?=$badge_aktif?>"><?=$profil_pegawai['nama_status_pegawai']?></span>
                <?php if($profil_pegawai['flag_terima_tpp'] == 1 && $profil_pegawai['id_m_status_pegawai'] == 1){?>
                    <span class="badge badge-penerima-tpp float-right"><i class="fa fa-check"></i> Penerima TPP</span>
                <?php } ?>
              </div>

              <div class="col-lg-12 text-center">
                <!-- <img style="width: 240px; height: 240px" class="img-fluid rounded-circle mb-2 b-lazy"
                  src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== 
                  data-src="<?=$this->general_library->getFotoPegawai($profil_pegawai['fotopeg'])?>" /> -->
              
                  <!-- <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                  src="<?=base_url('fotopeg/')?><?=$profil_pegawai['fotopeg']?>" />  -->

                  <div class="foto_containerx">
                            <img id="profile_pegawai" class="img-fluidx mb-2 b-lazy"
                           data-src="
                            <?php
                                $path = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($profil_pegawai['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  if($profil_pegawai['jk'] == "Laki-Laki" || $profil_pegawai['jk'] == "Laki-laki"){
                                    $src = 'assets/img/user-icon-male.png';
                                } else {
                                    $src = 'assets/img/user-icon-woman.png';
                                }
                                }
                                } else {
                                if($profil_pegawai['jk'] == "Laki-Laki" || $profil_pegawai['jk'] == "Laki-laki"){
                                    $src = 'assets/img/user-icon-male.png';
                                } else {
                                    $src = 'assets/img/user-icon-woman.png';
                                }
                                }
                                echo base_url().$src;?>
                                "
                                /> 
                                <div class="middle">
                                    <!-- <form id="form_profile_pict" action="<?=base_url('kepegawaian/C_Kepegawaian/updateProfilePict')?>" method="post" enctype="multipart/form-data">
                                        <input title="Ubah Foto Profil" class="form-control" accept="image/x-png,image/gif,image/jpeg" type="file" name="profilePict" id="profilePict">
                                    </form> -->
                                </div>
                        </div>
                  
              </div>

             
              <div class="col-lg-12 text-center" >
                <?php if(isset($satyalencana) && $satyalencana){ foreach($satyalencana as $sl){
                  if($sl['id_m_satyalencana'] == 1){
                ?>
                  <img title="<?=$sl['nama_satya_lencana']?>" class="badge_satyalencana b-lazy" data-src="<?=base_url('assets/img/satyalencana10.png')?>" />
                <?php } if($sl['id_m_satyalencana'] == 2){ ?>
                  <img title="<?=$sl['nama_satya_lencana']?>" class="badge_satyalencana b-lazy" data-src="<?=base_url('assets/img/satyalencana20.png')?>" />
                <?php } if($sl['id_m_satyalencana'] == 3){ ?>
                  <img title="<?=$sl['nama_satya_lencana']?>" class="badge_satyalencana b-lazy" data-src="<?=base_url('assets/img/satyalencana30.png')?>" />
                <?php } } } ?>
              </div>
              <div class="col-lg-12 text-center">
                <span class="sp_profil">
                  <?=getNamaPegawaiFull($profil_pegawai)?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
                <span class="sp_profil_nip">
                  <!-- <?=formatNip($profil_pegawai['nipbaru_ws'])?> -->
                  NIP. <?=$profil_pegawai['nipbaru_ws']?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getUserName() == $nip){ ?>
                
             
                <button data-toggle="modal" onclick="loadEditProfilModal('<?=$profil_pegawai['nipbaru_ws']?>')" class="btn btn-block btn-navy mb-2"  data-toggle="modal" data-target="#editProfileModal">
                  <i class="fa fa-edit"></i> Edit Profil 
                </button>
                <button data-toggle="modal"  class="btn btn-block btn-navy mb-2"  data-toggle="modal" data-target="#modalFotoProfil">
                  <i class="fa fa-user"></i> Ubah Foto Profil
                </button>
                <!-- <button data-toggle="modal" href="#modal_drh" onclick="loadDrh('<?=$profil_pegawai['nipbaru_ws']?>')" class="btn btn-block btn-navy mb-2">
                  <i class="fa fa-id-badge"></i> DRH
                </button> -->

               <!-- Example split danger button -->
              <div class="btn-group mb-2">
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-id-badge"></i> DRH <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                  <!-- <a class="dropdown-item" data-toggle="modal" href="#modal_drh" onclick="loadDrh('<?=$profil_pegawai['nipbaru_ws']?>')">DRH Umum</a> -->
                  <a class="dropdown-item" data-toggle="modal" href="#modal_drh" onclick="loadDrhSatyalencana('<?=$profil_pegawai['nipbaru_ws']?>')">DRH Untuk Satyalancana</a>
                  </div>
              </div>

              
            
                <?php } ?>
                <?php if(($this->general_library->isKasubagKepegawaianDiknas() && $profil_pegawai['skpd'] != '3010000')
                || ($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi())){ ?>
                  <hr>
                  <div style="margin-left: 30px; margin-right: 30px !important; " class="form-check form-switch">
                    <input style="cursor: pointer; float: none; margin-right: -30px; width: 45px; height: 25px;"
                    name="radio_button_sertifikasi" class="form-check-input" type="checkbox" id="radio_button_sertifikasi" 
                    <?=$profil_pegawai['flag_sertifikasi'] == 1 ? "checked" : ""?>>
                    <label class="form-check-label" for="radio_button_sertifikasi" style="
                      font-weight: bold;
                      font-size: 1rem;
                      margin-top: 4px;
                      margin-left: 30px;">GURU SERTIFIKASI</label>
                  </div>
                <?php } if($this->general_library->isHakAkses('verifikasi_pengajuan_kenaikan_gaji_berkala')){ ?>
                 

                  <div style="margin-left: 30px; margin-right: 30px !important; " class="form-check form-switch">
                    <input style="cursor: pointer; float: none; margin-right: -30px; width: 45px; height: 25px;"
                    name="radio_button_berkala" class="form-check-input" type="checkbox" id="radio_button_berkala" 
                    <?=$profil_pegawai['flag_terima_berkala'] == 1 ? "checked" : ""?>>
                    <label class="form-check-label" for="radio_button_berkala" style="
                      font-weight: bold;
                      font-size: 1rem;
                      margin-top: 4px;
                      margin-left: 30px;">Pegawai Terima Berkala</label>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="row">
              <!-- profil  -->
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile active" id="pills-data_kepeg-tab" data-bs-toggle="pill" data-bs-target="#pills-data_kepeg" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Data Kepegawaian</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile " id="pills-data_pribadi-tab" data-bs-toggle="pill" data-bs-target="#pills-data_pribadi" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</button>
              </li>
              
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile" id="pills-data_lain-tab" data-bs-toggle="pill" data-bs-target="#pills-data_lain" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Data Lainnya</button>
              </li>
            </ul>

            <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade" id="pills-data_pribadi" role="tabpanel" aria-labelledby="pills-data_pribadi-tab">
                <div id="">
                 <!-- data pribadi  -->
              <!-- <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Nama Lengkap
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?=getNamaPegawaiFull($profil_pegawai)?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                 NIP
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?=formatNip($profil_pegawai['nipbaru_ws'])?>
                </span>
              </div> -->
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  NIK (Nomor Induk Kependudukan)
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nik'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Agama
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_agama'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Tempat, Tanggal Lahir
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['tptlahir'].', '.formatDateNamaBulan($profil_pegawai['tgllahir']))?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Jenis Kelamin / Umur
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                  <?=$profil_pegawai['jk'].' / '.countDiffDateLengkap(date('Y-m-d'), $profil_pegawai['tgllahir'], ['tahun', 'bulan'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Golongan Darah
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                  <?= $profil_pegawai['goldarah']?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Alamat
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm sp_profil_alamat">
                <?php if($profil_pegawai['nama_kelurahan']) { ?>
                  Sulawesi Utara, <?=$profil_pegawai['nama_kabupaten_kota']?>, Kec. <?=$profil_pegawai['nama_kecamatan']?>, Kel. <?=$profil_pegawai['nama_kelurahan']?></td>
                  <?php } ?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Pendidikan Terakhir
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm sp_profil_alamat">
                  <?=($profil_pegawai['nm_tktpendidikan'])?>
                </span>
              </div>
              
         
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Status Perkawinan
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm sp_profil_alamat">
                  <?=($profil_pegawai['nm_sk'])?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  No Telepon
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm sp_profil_alamat">
                  <?php if($profil_pegawai['handphone'] != null) { ?>
                    <a target="_blank" class="sp_whatsapp" href="https://wa.me/<?=convertPhoneNumber($profil_pegawai['handphone'])?>">
                      <?= $profil_pegawai['handphone'] != null ? $profil_pegawai['handphone'] : '-'; ?>
                      <i class="fab fa-whatsapp"></i></a>
                  <?php } else { ?>
                    <?= $profil_pegawai['handphone'] != null ? $profil_pegawai['handphone'] : '-'; ?>
                  <?php } ?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Email
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm sp_profil_alamat">
                  <?=($profil_pegawai['email'])?>
                </span>
              </div>

             
               <!-- end data pribadi  -->
                </div>
              </div>
              <div class="tab-pane show active" id="pills-data_kepeg" role="tabpanel" aria-labelledby="pills-data_kepeg-tab">
                <div id="">
                 <!-- data kepegawaian  -->
                <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Perangkat Daerah
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_unitkerja'])?>
                </span>
              </div>
              <?php
                  $data = explode("|", $profil_pegawai['data_jabatan']);
                // if($data[0] == "Pelaksana" || $data[0] == "Staff" || $data[0] == "Staf") 
                 { ?> 
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Bidang/Bagian
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nama_bidang'])?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Sub Bidang/Sub Bagian/Seksi
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nama_sub_bidang'])?>
                </span>
              </div>
              <?php } ?> 
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Jenis Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_jenisjab'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?=($profil_pegawai['nama_jabatan'])?>
                  <!-- <?php
                  $data = explode("|", $profil_pegawai['data_jabatan']);
                  echo $data[0];
                  ?> -->
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Status Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <!-- <?php
                  $data = explode("|", $profil_pegawai['data_jabatan']);
                  if(isset($data[2])) { 
                    if($data[2] == 1) {
                    echo "Definitif"; 
                  } else if($data[2] == 2) {
                    echo "Plt"; 
                  } else if($data[2] == 3) {
                    echo "Plh"; 
                  } else {
                    echo $profil_pegawai['nm_statusjabatan'];
                  }
                  }  
                  ?> -->
                  <?= $profil_pegawai['nm_statusjabatan'];?>
                 
                </span>
              </div>

              <!-- <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Tunjangan Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
              Dalam Pengembangan
              </span>
              </div> -->


              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?php 
                   $data = explode("|", $profil_pegawai['data_jabatan']);
                   if(isset($data[1])) echo formatDateNamaBulan($data[1]);?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Eselon
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['eselon'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Status Kepegawaian
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_statuspeg'])?>
                </span>
              </div>

             

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Pangkat / Gol. Ruang
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?= $profil_pegawai['nm_pangkat'];?>
                  <?php if($profil_pegawai['data_pangkat']) {
                    // $data = explode("|", $profil_pegawai['data_pangkat']);
                    // echo $data[0];
                  } else {
                    // echo $profil_pegawai['nm_pangkat'];
                  }
                    ?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Pangkat
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?php 
                // if($profil_pegawai['data_pangkat']) {
                //     $data = explode("|", $profil_pegawai['data_pangkat']);
                //     echo formatDateNamaBulan($data[1]);
                //   } else {
                //     echo formatDateNamaBulan($profil_pegawai['tmtpangkat']);
                //   }
                  echo formatDateNamaBulan($profil_pegawai['tmtpangkat']);
                    ?>
                
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT CPNS/PPPK
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($profil_pegawai['tmtcpns'])?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Gaji Berkala Terakhir
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?=formatDateNamaBulan($profil_pegawai['tmtgjberkala'])?>
                </span>
              </div>

              <!-- <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Masa Kerja Pegawai
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?= countDiffDateLengkap(date('Y-m-d'), $profil_pegawai['tmtcpns'], ['tahun', 'bulan'])?>
              </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Gaji Pokok
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
              Dalam Pengembangan
              </span>
              </div> -->

                 <!-- end data kepegawaian  -->

             
                </div>
              </div>
              <div class="tab-pane fade" id="pills-data_lain" role="tabpanel" aria-labelledby="pills-data_lain-tab">
                <div id="">
              <!--  data lainnya  -->

                <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  No Seri Karpeg
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?= $profil_pegawai['karpeg'] != null ? $profil_pegawai['karpeg'] : '-'; ?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  No Taspen
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?= $profil_pegawai['taspen'] != null ? $profil_pegawai['taspen'] : '-'; ?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  No Kartu Karis
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?= $profil_pegawai['karis'] != null ? $profil_pegawai['karis'] : '-'; ?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  NPWP
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?= $profil_pegawai['npwp'] != null ? $profil_pegawai['npwp'] : '-'; ?>
                </span>
              </div>

             <!-- end data lainnya  -->
                </div>
              </div>
            
            
              
             
            </div>
          </div>

              

               <!-- tutup profil  -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card card-default">
        <div class="row p-3">
          <div class="col-lg-12">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPangkat()" class="nav-link nav-link-profile active" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pangkat</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button  onclick="loadFormGajiBerkala()" class="nav-link nav-link-profile" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Gaji Berkala</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPendidikan()" class="nav-link nav-link-profile" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pendidikan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormJabatan('def')" class="nav-link nav-link-profile" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormJabatan('plt')" class="nav-link nav-link-profile" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan Plt/Plh, Penjabat</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormDiklat()" class="nav-link nav-link-profile" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Bangkom</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormOrganisasi()" class="nav-link nav-link-profile" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Sosial Kultural</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPenghargaan()" class="nav-link nav-link-profile" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Penghargaan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormSumpahJanji()" class="nav-link nav-link-profile" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
              </li>
              <!-- <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPelanggaran()" class="nav-link nav-link-profile" id="pills-pelanggaran-tab" data-bs-toggle="pill" data-bs-target="#pills-pelanggaran" type="button" role="tab" aria-controls="pills-pelanggaran" aria-selected="false">Pelanggaran</button>
              </li> -->
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormKeluarga()"  class="nav-link nav-link-profile" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#pills-keluarga" type="button" role="tab" aria-controls="pills-keluarga" aria-selected="false">Keluarga</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPenugasan()" class="nav-link nav-link-profile" id="pills-penugasan-tab" data-bs-toggle="pill" data-bs-target="#pills-penugasan" type="button" role="tab" aria-controls="pills-penugasan" aria-selected="false">Penugasan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormCuti()" class="nav-link nav-link-profile" id="pills-cuti-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">Cuti</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormDisiplin()" class="nav-link nav-link-profile" id="pills-disiplin-tab" data-bs-toggle="pill" data-bs-target="#pills-disiplin" type="button" role="tab" aria-controls="pills-disiplin" aria-selected="false">Disiplin</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormSkp()" class="nav-link nav-link-profile" id="pills-skp-tab" data-bs-toggle="pill" data-bs-target="#pills-skp" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">SKP</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormAssesment()" class="nav-link nav-link-profile" id="pills-assesment-tab" data-bs-toggle="pill" data-bs-target="#pills-assesment" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Hasil Assesment</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormBerkasPns()" class="nav-link nav-link-profile" id="pills-berkaspns-tab" data-bs-toggle="pill" data-bs-target="#pills-berkaspns" type="button" role="tab" aria-controls="pills-berkaspns" aria-selected="false">SK CPNS, PNS & PPPK</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormTimKerja()" class="nav-link nav-link-profile" id="pills-tk-tab" data-bs-toggle="pill" data-bs-target="#pills-tk" type="button" role="tab" aria-controls="pills-tk" aria-selected="false">Tim Kerja</button>
              </li>

              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormInovasi()" class="nav-link nav-link-profile" id="pills-inovasi-tab" data-bs-toggle="pill" data-bs-target="#pills-inovasi" type="button" role="tab" aria-controls="pills-inovasi" aria-selected="false">Inovasi</button>
              </li>
<!-- 
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormMutasi()" class="nav-link nav-link-profile" id="pills-mutasi-tab" data-bs-toggle="pill" data-bs-target="#pills-mutasi" type="button" role="tab" aria-controls="pills-mutasi" aria-selected="false">Mutasi</button>
              </li> -->
            
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormArsip()" class="nav-link nav-link-profile" id="pills-arsip-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadPresensiPegawai()" class="nav-link nav-link-profile" id="pills-presensi-tab" data-bs-toggle="pill" data-bs-target="#pills-presensi" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Presensi</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormKp4()" class="nav-link nav-link-profile" id="pills-kp4-tab" data-bs-toggle="pill" data-bs-target="#pills-kp4" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">KP4</button>
              </li>
              <?php 
              // if(
                // $this->general_library->getIdEselon() < 8 && 
              // $this->general_library->getIdEselon() != 1 || 
              // $this->general_library->isHakAkses('manajemen_talenta')){ 
                ?>
              <?php 
              // if($profil_pegawai['eselon'] == "III A" || $profil_pegawai['eselon'] == "III B") {
              if($profil_pegawai['jenis_jabatan'] == "Struktural" || $profil_pegawai['jenis_jabatan'] == "JFU") {
              ?>
              <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() ||  $this->general_library->isHakAkses('manajemen_talenta') || $this->general_library->getUserName() == $nip){ ?>
              <?php if($profil_pegawai['statuspeg'] != 1) { ?>
                <li class="nav-item nav-item-profile" role="presentation"> 
                <button onclick="LoadViewTalenta()"  class="nav-link nav-link-profile" id="pills-mt-tab" data-bs-toggle="pill" data-bs-target="#pills-mt" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Manajemen Talenta</button>
              </li>
               <?php } ?>
              <?php } ?>
              <?php 
               } 
              ?>
              <?php 
              //  }  
               ?>
            </ul>
          </div>
          <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane show active" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
                <div id="form_pangkat"></div>
              </div>
              <div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
                <div id="form_gaji_berkala"></div>
              </div>
              <div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-pendidikan-tab">
                <div id="form_pendidikan"></div>
              </div>
              <div class="tab-pane fade" id="pills-jabatan" role="tabpanel" aria-labelledby="pills-jabatan-tab">
                <div id="form_jabatan"></div>
              </div>
              <div class="tab-pane fade" id="pills-jabatanplt" role="tabpanel" aria-labelledby="pills-jabatanplt-tab">
                <div id="form_jabatan_plt"></div>
              </div>
              <div class="tab-pane fade" id="pills-diklat" role="tabpanel" aria-labelledby="pills-diklat-tab">
                <div id="form_diklat"></div>
              </div>
              <div class="tab-pane fade" id="pills-organisasi" role="tabpanel" aria-labelledby="pills-organisasi-tab">
                <div id="form_organisasi"></div>
              </div>
              <div class="tab-pane fade" id="pills-penghargaan" role="tabpanel" aria-labelledby="pills-penghargaan-tab">
                <div id="form_penghargaan"></div>
              </div>
              <div class="tab-pane fade" id="pills-sj" role="tabpanel" aria-labelledby="pills-sj-tab">
                  <div id="form_sumpah_janji"></div>
              </div>
              <div class="tab-pane fade" id="pills-pelanggaran" role="tabpanel" aria-labelledby="pills-pelanggaran-tab">
                  <div id="form_pelanggaran"></div>
              </div>
              <div class="tab-pane fade" id="pills-keluarga" role="tabpanel" aria-labelledby="pills-keluarga-tab">
                  <div id="form_keluarga"></div>
              </div>
              <div class="tab-pane fade" id="pills-penugasan" role="tabpanel" aria-labelledby="pills-penugasan-tab">
                <div id="form_penugasan"></div>
              </div>
              <div class="tab-pane fade" id="pills-cuti" role="tabpanel" aria-labelledby="pills-cuti-tab">
                <div id="form_cuti"></div>
              </div>
              <div class="tab-pane fade" id="pills-disiplin" role="tabpanel" aria-labelledby="pills-disiplin-tab">
              <div id="form_disiplin"></div>
              </div>
              <div class="tab-pane fade" id="pills-skp" role="tabpanel" aria-labelledby="pills-skp-tab">
                <div id="form_skp"></div>
              </div>
              <div class="tab-pane fade" id="pills-assesment" role="tabpanel" aria-labelledby="pills-assesment-tab">
                <div id="form_assesment"></div>
              </div>
              <div class="tab-pane fade" id="pills-berkaspns" role="tabpanel" aria-labelledby="pills-berkaspns-tab">
              <div id="form_berkaspns"></div>
              </div>
              <div class="tab-pane fade" id="pills-tk" role="tabpanel" aria-labelledby="pills-tk-tab">
                <div id="form_tk"></div>
              </div>

              <div class="tab-pane fade" id="pills-inovasi" role="tabpanel" aria-labelledby="pills-inovasi-tab">
                <div id="form_inovasi"></div>
              </div>

              <div class="tab-pane fade" id="pills-mutasi" role="tabpanel" aria-labelledby="pills-mutasi-tab">
                <div id="form_mutasi"></div>
              </div>
              
              <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab">
                <div id="form_arsip"></div>
              </div>
                <div class="tab-pane fade" id="pills-kp4" role="tabpanel" aria-labelledby="pills-kp4-tab">
                <div id="form_kp4"></div>
              </div>
              <div class="tab-pane fade" id="pills-presensi" role="tabpanel" aria-labelledby="pills-presensi-tab">
                <div class="row">
                  <form id="form_presensi_pegawai">
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Bulan</label>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                                <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                                <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                                <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                                <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                                <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                                <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                                <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                                <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                                <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                                <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                                <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                                <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>Tahun</label>
                            <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                        </div>
                        <div class="col-lg-4">
                            <label style="color: white;">.</label><br>
                            <button class="btn btn-navy" type="submit">Submit</button>
                        </div>
                    </div>
                  </form>
                  <div class="mt-3" id="div_presensi_result"></div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-mt" role="tabpanel" aria-labelledby="pills-mt-tab">
                <div id="div_manajamen_talenta"></div>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>

  <?php 
  if($this->general_library->getUserName() == $nip){
    $nm_jab = substr($profil_pegawai['nama_jabatan'], 0, 6);
   
    if($bidang){
      if($profil_pegawai['id_unitkerjamaster'] == "8020000" || $profil_pegawai['id_unitkerjamaster'] == "6000000" || $profil_pegawai['id_unitkerjamaster'] == "8010000" || $profil_pegawai['id_unitkerjamaster'] == "1000000" || $profil_pegawai['id_unitkerjamaster'] == "8000000"){
        $idBidang = 99;
      } else if($profil_pegawai['eselon'] == "II B" || $profil_pegawai['eselon'] == "III B" || $profil_pegawai['eselon'] == "III A") {
        $idBidang = 99;
      } else if($nm_jab == "Kepala"){
        $idBidang = 99;
      } else {
        $idBidang = $bidang['id_m_bidang'];
      }
   
    } else {
    $idBidang = 99;
    }
    } else {
    $idBidang = 99;
    }
    ?>

<input type="hidden" id="bidangPegawai" value="<?=$idBidang;?>">



<!-- modal ubah foto profil -->
<div class="modal fade" id="modalFotoProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Foto Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form_profile_pict" action="<?=base_url('kepegawaian/C_Kepegawaian/updateProfilePict')?>" method="post" enctype="multipart/form-data">
                                        <input title="Ubah Foto Profil" class="form-control" accept="image/x-png,image/gif,image/jpeg" type="file" name="profilePict" id="profilePict" required>
                                        <input type="hidden" name="nip" value="<?=$profil_pegawai['nipbaru_ws']?>">
      
      <hr>        
      <span>
      <b>Keterangan Penting</b><br>
      Foto Memakai Seragam Khaki dengan atribut lengkap
      Foto Jelas (tidak kabur/blur)
      Tipe File JPG/PNG
      Maximal Ukuran File Foto 1 MB
      Ukuran Foto 3x4 atau 4x6<br><br>
      <b>Warna Background Foto</b><br>
      JPT : Merah<br>
      Administrator : Biru<br>
      Pengawas : Hijau<br>
      Fungisonal Tertentu : Abu-Abu<br>
      Fungional Umum : Orange<br>
      PPPK : Kuning
      </span>
      <hr>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- tutup modal ubah foto profil  -->

<div class="modal fade" id="modal_drh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DAFTAR RIWAYAT HIDUP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_drh_content">
     
      </div>
      <div class="modal-footer">
            <a style="display:none;" id="btn_download_drh_sl" href="<?=base_url('kepegawaian/C_Kepegawaian/downloadDrhSatyalencana/'.$profil_pegawai['nipbaru'])?>" target="_blank">
            <button class="btn btn-primary mt-2 float-right"> <li class="fa fa-download"></li> Download</button>
            </a>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal edit profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit_profil_pegawai">
     
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- end Modal edit profil -->

<!-- Modal -->

<!-- Button trigger modal -->
<button style="display:none" id="btnstatic" type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
      <?php if($tpp['pagu_tpp']['jenis_jabatan'] == "jft") { ?>
        <button type="button" class="close"  data-dismiss="modal"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <?php } ?>
      </div><br>
      <center><h3>Harap Mengisi Data Bidang/Bagian </h3></center>

      <div class="modal-body">
      <form action="<?=base_url('kepegawaian/C_Kepegawaian/submiDataBidang');?>" method="post">
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Bidang/Bagian</label>
    <select class="form-control select2" data-dropdown-parent="#staticBackdrop" data-dropdown-css-class="select2-navy" name="id_m_bidang" id="id_m_bidang" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <option value="0">-</option>
                    <?php if($mbidang){ foreach($mbidang as $r){ ?>
                        <option  value="<?=$r['id']?>"><?=$r['nama_bidang']?></option>
                    <?php } } ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Sub Bidang/Sub Bagian/Seksi</label>
    <select class="form-control select2" data-dropdown-parent="#staticBackdrop" data-dropdown-css-class="select2-navy" name="id_m_sub_bidang" id="id_m_sub_bidang">
      <option value="0" selected>-</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary float-right">Simpan</button>
</form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Modal edit profil -->
<div class="modal fade" id="fotoProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- end Modal edit profil -->

<div class="modal fade" id="edit_data_presensi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">EDIT DATA JAM PRESENSI</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="edit_data_presensi_content">
          </div>
      </div>
  </div>
</div>

<!-- Modal Status PDM -->
<div class="modal fade" id="pdmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelPdm" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelPdm"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Simpan Perubahan Status Berkas ?
      <form method="post" id="form_status_berkas" enctype="multipart/form-data" >
      <input type="hidden" name="jenis_berkas" id="jenis_berkas">
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="modal_dismis_pdm" data-dismiss="modal">Batal</button>
        <button class="btn btn-block btn-primary" >Ya</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Button trigger modal -->


<!-- Modal -->

<script>
    $('#form_status_berkas').on('submit', function(e){  
      
        e.preventDefault();
        var formvalue = $('#form_status_berkas');
        var form_data = new FormData(formvalue[0]);
        var jb = $('#jenis_berkas').val();
        if(jb == ""){
          errortoast("belum ada berkas yg diupload")
          return false;
        }


        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/updateStatusBerkas")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            console.log(result)
            if(result.success == true){
                successtoast(result.msg)
                setTimeout(function() {$("#modal_dismis_pdm").trigger( "click" );}, 1000);
                if(jb == "pangkat"){
                setTimeout(loadFormPangkat, 1500);
                } else if(jb == "kgb"){
                setTimeout(loadFormGajiBerkala, 1500);
                } else if(jb == "ijazah"){
                setTimeout(loadFormPendidikan, 1500);
                } else if(jb == "jabatan"){
                setTimeout($('#pills-jabatan-tab').click(), 1500);
                } else if(jb == "diklat"){
                setTimeout(loadFormDiklat, 1500);
                } else if(jb == "organisasi"){
                setTimeout(loadFormOrganisasi, 1500);
                } else if(jb == "penghargaan"){
                setTimeout(loadFormPenghargaan, 1500);
                } else if(jb == "sumpah_janji"){
                setTimeout(LoadFormSumpahJanji, 1500);
                } else if(jb == "keluarga"){
                setTimeout(loadFormKeluarga, 1500);
                } else if(jb == "penugasan"){
                setTimeout(loadFormPenugasan, 1500);
                } else if(jb == "cuti"){
                setTimeout(loadFormCuti, 1500);
                } else if(jb == "skp_tahunan"){
                setTimeout(loadFormSkp, 1500);
                } else if(jb == "assesment"){
                setTimeout(loadFormAssesment, 1500);
                } else if(jb == "cpns_pns"){
                setTimeout(loadFormBerkasPns, 1500);
                } else if(jb == "data_lainnya"){
                setTimeout(LoadFormArsip, 1500);
                } else if(jb == "inovasi"){
                setTimeout(LoadFormInovasi, 1500);
                } else if(jb == "tim_kerja"){
                setTimeout(LoadFormTimKerja, 1500);
                } else if(jb == "disiplin"){
                setTimeout(loadFormDisiplin, 1500);
                }
              } else {
                errortoast(result.msg)
                return false;
              } 
        }  
        });  
          
        });

        $('#radio_button_sertifikasi').on('click', function(){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/changeFlagSertifikasi/")?>'+$(this).is(':checked')+'/'+'<?=$profil_pegawai['nipbaru_ws']?>',
              method: 'post',
              data: $(this).serialize(),
              success: function(data){
                  successtoast('Berhasil')
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
        })

        $('#radio_button_berkala').on('click', function(){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/changeFlagBerakala/")?>'+$(this).is(':checked')+'/'+'<?=$profil_pegawai['nipbaru_ws']?>',
              method: 'post',
              data: $(this).serialize(),
              success: function(data){
                  successtoast('Berhasil')
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })
        })
</script>

  <script>
  var nip = "<?= $nip;?>"; 
  var page = "<?= $page;?>"
  $(function(){
    window.bLazy = new Blazy({
      container: '.container',
      success: function(element){
        console.log("Element loaded: ", element.nodeName);
      }, error: function(e){
        console.log(e)
      }
    });

    if(page == "cpns_pns"){
      $('#pills-berkaspns-tab').click()
    } else if(page == "pangkat"){
      $('#pills-pangkat-tab').click()
    } else if(page == "jabatan"){
      $('#pills-jabatan-tab').click()
    } else if(page == "kgb"){
      $('#pills-berkala-tab').click()
    } else if(page == "ijazah"){
      $('#pills-pendidikan-tab').click()
    } else if(page == "diklat"){
      $('#pills-diklat-tab').click()
    } else if(page == "sumpah_janji"){
      $('#pills-sj-tab').click()
    } else if(page == "penghargaan"){
      $('#pills-penghargaan-tab').click()
    } else if(page == "keluarga"){
      $('#pills-keluarga-tab').click()
    } else if(page == "skp_tahunan"){
      $('#pills-skp-tab').click()
    } else if(page == "data_lainnya"){
      $('#pills-arsip-tab').click()
    } else if(page == "penugasan"){
      $('#pills-penugasan-tab').click()
    } else if(page == "cuti"){
      $('#pills-cuti-tab').click()
    } else if(page == "organisasi"){
      $('#pills-organisasi-tab').click()
    } else if(page == "tim_kerja"){
      $('#pills-tk-tab').click()
    } else if(page == "inovasi"){
      $('#pills-inovasi-tab').click()
    } else if(page == "assesment"){
      $('#pills-assesment-tab').click()
    } else {
      $('#pills-pangkat-tab').click()
    }
    
    $(".select2x").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	})

  $('.datepickeronly').datepicker({
          format: 'yyyy-mm-dd'
        });

  // var bidang = $('#bidangPegawai').val()
  // if(bidang == ""){
  // $('#btnstatic').click()  
  // }


  })



 function loadDrh(nip){
  $('#btn_download_drh_sl').hide()
  $('#modal_drh_content').html('')
    $('#modal_drh_content').append(divLoaderNavy)
    $('#modal_drh_content').load('<?=base_url("kepegawaian/C_Kepegawaian/loadDataDrh")?>'+'/'+nip, function(){
      $('#loader').hide()
    })
 }

 function loadDrhSatyalencana(nip){
  $('#btn_download_drh_sl').show()
  $('#modal_drh_content').html('')
    $('#modal_drh_content').append(divLoaderNavy)
    $('#modal_drh_content').load('<?=base_url("kepegawaian/C_Kepegawaian/loadDataDrhSatyalencana")?>'+'/'+nip, function(){
      $('#loader').hide()
    })
 }
  
 function loadEditProfilModal(id){
 
    $('#edit_profil_pegawai').html('')
    $('#edit_profil_pegawai').append(divLoaderNavy)
    $('#edit_profil_pegawai').load('<?=base_url("kepegawaian/C_Kepegawaian/loadEditProfilPegawai")?>'+'/'+id, function(){
      $('#loader').hide()
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
        url: '<?=base_url("user/C_User/searchDetailAbsenPegawai/1/".$profil_pegawai['id_m_user'])?>',
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

   
  function loadFormPangkat(){
    $('#form_pangkat').html(' ')
      $('#form_pangkat').append(divLoaderNavy)
      $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>'+nip, function(){
      $('#loader').hide()    
    })
 }

 function loadFormPenugasan(){
  $('#form_penugasan').html(' ')
    $('#form_penugasan').append(divLoaderNavy)
    $('#form_penugasan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPenugasan/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormGajiBerkala(){
  $('#form_gaji_berkala').html(' ')
    $('#form_gaji_berkala').append(divLoaderNavy)
    $('#form_gaji_berkala').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormGajiBerkala/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormPendidikan(){
   $('#form_pendidikan').html(' ')
    $('#form_pendidikan').append(divLoaderNavy)
    $('#form_pendidikan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPendidikan/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormJabatan(val){
 var status = val;
  $('#form_jabatan').html(' ')
    $('#form_jabatan').append(divLoaderNavy)
    $('#form_jabatan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormJabatan/')?>'+nip+'/'+status, function(){
    $('#loader').hide()    
    })
 }

 function loadFormJabatanPlt(){
  $('#form_jabatan_plt').html(' ')
    $('#form_jabatan_plt').append(divLoaderNavy)
    $('#form_jabatan_plt').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormJabatanPlt/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormDiklat(){
  $('#form_diklat').html(' ')
    $('#form_diklat').append(divLoaderNavy)
    $('#form_diklat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDiklat/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormOrganisasi(){
  $('#form_organisasi').html(' ')
    $('#form_organisasi').append(divLoaderNavy)
    $('#form_organisasi').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormOrganisasi/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormPenghargaan(){
  $('#form_penghargaan').html(' ')
    $('#form_penghargaan').append(divLoaderNavy)
    $('#form_penghargaan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPenghargaan/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }


 function loadFormSkp(){
  $('#form_skp').html(' ')
    $('#form_skp').append(divLoaderNavy)
    $('#form_skp').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormSkp/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormAssesment(){
  $('#form_assesment').html(' ')
    $('#form_assesment').append(divLoaderNavy)
    $('#form_assesment').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormAssesment/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 
 function loadFormKeluarga(){
  $('#form_keluarga').html(' ')
    $('#form_keluarga').append(divLoaderNavy)
    $('#form_keluarga').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormKeluarga/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormCuti(){
  $('#form_cuti').html(' ')
    $('#form_cuti').append(divLoaderNavy)
    $('#form_cuti').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormCuti/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadFormSumpahJanji(){
  $('#form_sumpah_janji').html(' ')
    $('#form_sumpah_janji').append(divLoaderNavy)
    $('#form_sumpah_janji').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormSumpahJanji/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormPelanggaran(){
  $('#form_pelanggaran').html(' ')
    $('#form_pelanggaran').append(divLoaderNavy)
    $('#form_pelanggaran').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormPelanggaran/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadFormArsip(){
  $('#form_arsip').html(' ')
    $('#form_arsip').append(divLoaderNavy)
    $('#form_arsip').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormArsip/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

  function LoadFormKp4(){
  $('#form_kp4').html(' ')
    $('#form_kp4').append(divLoaderNavy)
    $('#form_kp4').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormKp4/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadViewTalenta(){
  $('#div_manajamen_talenta').html(' ')
    $('#div_manajamen_talenta').append(divLoaderNavy)
    $('#div_manajamen_talenta').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadViewTalenta/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadFormTimKerja(){
  $('#form_tk').html(' ')
    $('#form_tk').append(divLoaderNavy)
    $('#form_tk').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormTimKerja/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadFormInovasi(){
  $('#form_inovasi').html(' ')
    $('#form_inovasi').append(divLoaderNavy)
    $('#form_inovasi').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormInovasi/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function LoadFormMutasi(){
  $('#form_mutasi').html(' ')
    $('#form_mutasi').append(divLoaderNavy)
    $('#form_mutasi').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormTimKerja/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormBerkasPns(){
  $('#form_berkaspns').html(' ')
    $('#form_berkaspns').append(divLoaderNavy)
    $('#form_berkaspns').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormBerkasPns/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

 function loadFormDisiplin(){
  $('#form_disiplin').html(' ')
    $('#form_disiplin').append(divLoaderNavy)
    $('#form_disiplin').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormDisiplin/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

  function loginAs(nip){
    $('#btn_login').hide()
    $('#btn_login_loading').show()
    $.ajax({
        url : "<?php echo base_url('login/C_Login/authenticateAdmin/1/'.$nip);?>",
        method : "POST",
        dataType : 'json',
        success: function(data){
            $('#btn_login').show()
            $('#btn_login_loading').hide()
            window.location.href = "<?=base_url('welcome')?>";
        }, error: function(err){
            $('#btn_login').show()
            $('#btn_login_loading').hide()
            // errortoast(err)
            window.location.href = "<?=base_url('welcome')?>";
        }
    });
  }

//  $('#profilePict').on('change', function(){
//         $('#form_profile_pict').submit()
//     })
 

$("#id_m_bidang").change(function() {
      var id = $("#id_m_bidang").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getMasterSubBidang",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '<option value=>-</option>';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_sub_bidang+'</option>';
                      }
                      $('#id_m_sub_bidang').html(html);
                          }
                  });
  });

 





 




</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
  </div>
<?php } ?>

