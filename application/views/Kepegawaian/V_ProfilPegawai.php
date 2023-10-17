<?php
  if($profil_pegawai){
?>
  <style>
    .sp_profil{
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
      width: 250px;
      height: calc(250px * 1.25);
      background-size: cover;
      /* object-fit: contain; */
      box-shadow: 5px 5px 10px #888888;
      border-radius: 10%;
    }

    .badge{
      box-shadow: 3px 3px 10px #888888;
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
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


  </style>



  <div class="row">
    <div class="col-lg-12">
      <div class="card card-default">
        <div class="row p-3">
          <div class="col-lg-4">
            <div class="row">
              <?php if($profil_pegawai['statuspeg'] == 1){ ?>
                <div class="col-lg-12 text-left">
                  <h3><span class="badge">CPNS</span></h3>
                </div>
              <?php } ?>
            

              <div class="col-lg-12 text-center">
                <!-- <img style="width: 240px; height: 240px" class="img-fluid rounded-circle mb-2 b-lazy"
                  src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== 
                  data-src="<?=$this->general_library->getFotoPegawai($profil_pegawai['fotopeg'])?>" /> -->
              
                  <!-- <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                  src="<?=base_url('fotopeg/')?><?=$profil_pegawai['fotopeg']?>" />  -->

                  <div class="foto_container">
                            <!-- <img src="<?=$this->general_library->getProfilePicture()?>" style="height: 350px; width: 350px; margin-right: 1px;" 
                            class="img-circle elevation-2 image-settings" alt="User Image"> -->
                            <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                            src="<?php
                                $path = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($profil_pegawai['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                  //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  $src = './assets/img/user.png';
                                  // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                  $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> 
                                <div class="middle">
                                    <!-- <form id="form_profile_pict" action="<?=base_url('kepegawaian/C_Kepegawaian/updateProfilePict')?>" method="post" enctype="multipart/form-data">
                                        <input title="Ubah Foto Profil" class="form-control" accept="image/x-png,image/gif,image/jpeg" type="file" name="profilePict" id="profilePict">
                                    </form> -->
                                </div>
                        </div>
                  
              </div>

             

              <div class="col-lg-12 text-center">
                <span class="sp_profil">
                  <?=getNamaPegawaiFull($profil_pegawai)?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
                <span class="sp_profil">
                  <!-- <?=formatNip($profil_pegawai['nipbaru_ws'])?> -->
                  <?=$profil_pegawai['nipbaru_ws']?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
          <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                
                <?php }?>
                <button data-toggle="modal" onclick="loadEditProfilModal('<?=$profil_pegawai['id_peg']?>')" class="btn btn-block btn-navy mb-2"  data-toggle="modal" data-target="#editProfileModal">
                  <i class="fa fa-edit"></i> Edit Profil
                </button>
                <button data-toggle="modal"  class="btn btn-block btn-navy mb-2"  data-toggle="modal" data-target="#modalFotoProfil">
                  <i class="fa fa-user"></i> Ubah Foto Profil
                </button>
            

              </div>
            </div>
          </div>
          <div class="col-lg-8">
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
                  <?=($profil_pegawai['alamat'])?>
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
                  <?= $profil_pegawai['handphone'] != null ? $profil_pegawai['handphone'] : '-'; ?>
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
                  Jenis Kepegawaian
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_jenispeg'])?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Pangkat / Gol. Ruang
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=($profil_pegawai['nm_pangkat'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Pangkat
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($profil_pegawai['tmtpangkat'])?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT CPNS
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($profil_pegawai['tmtcpns'])?>
                </span>
              </div>


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
                  <?php
                  $data = explode("/", $profil_pegawai['data_jabatan']);
                  echo $data[0];
                  ?>
                </span>
              </div>

              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  Status Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                <?php
                  $data = explode("/", $profil_pegawai['data_jabatan']);
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
                  ?>
                 
                </span>
              </div>


              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?php
                   $data = explode("/", $profil_pegawai['data_jabatan']);
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
                <button onclick="loadFormJabatan('plt')" class="nav-link nav-link-profile" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan Plt/Plh</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormDiklat()" class="nav-link nav-link-profile" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormOrganisasi()" class="nav-link nav-link-profile" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Organisasi</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPenghargaan()" class="nav-link nav-link-profile" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Penghargaan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormSumpahJanji()" class="nav-link nav-link-profile" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPelanggaran()" class="nav-link nav-link-profile" id="pills-pelanggaran-tab" data-bs-toggle="pill" data-bs-target="#pills-pelanggaran" type="button" role="tab" aria-controls="pills-pelanggaran" aria-selected="false">Pelanggaran</button>
              </li>
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
                <button onclick="loadFormSkp()" class="nav-link nav-link-profile" id="pills-skp-tab" data-bs-toggle="pill" data-bs-target="#pills-skp" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">SKP</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormAssesment()" class="nav-link nav-link-profile" id="pills-assesment-tab" data-bs-toggle="pill" data-bs-target="#pills-assesment" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Hasil Assesment</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormBerkasPns()" class="nav-link nav-link-profile" id="pills-berkaspns-tab" data-bs-toggle="pill" data-bs-target="#pills-berkaspns" type="button" role="tab" aria-controls="pills-berkaspns" aria-selected="false">SK CPNS & PNS</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="LoadFormArsip()" class="nav-link nav-link-profile" id="pills-arsip-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadPresensiPegawai()" class="nav-link nav-link-profile" id="pills-presensi-tab" data-bs-toggle="pill" data-bs-target="#pills-presensi" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Presensi</button>
              </li>
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
              <div class="tab-pane fade" id="pills-skp" role="tabpanel" aria-labelledby="pills-skp-tab">
                <div id="form_skp"></div>
              </div>
              <div class="tab-pane fade" id="pills-assesment" role="tabpanel" aria-labelledby="pills-assesment-tab">
                <div id="form_assesment"></div>
              </div>
              <div class="tab-pane fade" id="pills-berkaspns" role="tabpanel" aria-labelledby="pills-berkaspns-tab">
              <div id="form_berkaspns"></div>
              </div>
              <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab">
                <div id="form_arsip"></div>
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
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>


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

<script>


</script>


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

<script>
    $('#form_status_berkas').on('submit', function(e){  
      
        e.preventDefault();
        var formvalue = $('#form_status_berkas');
        var form_data = new FormData(formvalue[0]);
        var jb = $('#jenis_berkas').val();
  
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
                setTimeout(loadFormJabatan, 1500);
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
                }
              } else {
                errortoast(result.msg)
                return false;
              } 
        }  
        });  
          
        });
</script>

  <script>
  var nip = "<?= $nip;?>"; 
  var page = "<?= $page;?>"
  $(function(){

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
    }  else {
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
  })
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

 function loadFormBerkasPns(){
  $('#form_berkaspns').html(' ')
    $('#form_berkaspns').append(divLoaderNavy)
    $('#form_berkaspns').load('<?=base_url('kepegawaian/C_Kepegawaian/loadFormBerkasPns/')?>'+nip, function(){
    $('#loader').hide()    
    })
 }

//  $('#profilePict').on('change', function(){
//         $('#form_profile_pict').submit()
//     })
 

 

 





 




</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
  </div>
<?php } ?>

