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
                  <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                  src="http://simpegserver/adm/fotopeg/<?=$profil_pegawai['fotopeg']?>" /> 
                  
              </div>

              

              <div class="col-lg-12 text-center">
                <span class="sp_profil">
                  <?=getNamaPegawaiFull($profil_pegawai)?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
                <span class="sp_profil">
                  <?=formatNip($profil_pegawai['nipbaru_ws'])?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
                <button data-toggle="modal" onclick="loadEditProfilModal()" class="btn btn-block btn-navy"  data-toggle="modal" data-target="#editProfileModal">
                  <i class="fa fa-edit"></i> Edit Profil
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="row">
              <!-- profil  -->
              <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile active" id="pills-data_pribadi-tab" data-bs-toggle="pill" data-bs-target="#pills-data_pribadi" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile" id="pills-data_kepeg-tab" data-bs-toggle="pill" data-bs-target="#pills-data_kepeg" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Data Kepegawaian</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile" id="pills-data_lain-tab" data-bs-toggle="pill" data-bs-target="#pills-data_lain" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Data Lainnya</button>
              </li>
            </ul>

            <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane show active" id="pills-data_pribadi" role="tabpanel" aria-labelledby="pills-data_pribadi-tab">
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
              <div class="tab-pane fade" id="pills-data_kepeg" role="tabpanel" aria-labelledby="pills-data_kepeg-tab">
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
                  <?=($profil_pegawai['nama_jabatan'])?>
                </span>
              </div>
              <div class="col-lg-12 div_label text-left">
                <span class="sp_label">
                  TMT Jabatan
                </span>
              </div>
              <div class="col-lg-12 text-left" >
                <span class="sp_profil_sm">
                  <?=formatDateNamaBulan($profil_pegawai['tmtjabatan'])?>
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
                <button onclick="loadFormJabatan()" class="nav-link nav-link-profile" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan</button>
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
                <button onclick="LoadFormSumpahJanji()" class="nav-link nav-link-profile" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormKeluarga()"  class="nav-link nav-link-profile" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-keluarga" type="button" role="tab" aria-controls="pills-keluarga" aria-selected="false">Keluarga</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormPenugasan()" class="nav-link nav-link-profile" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#pills-penugasan" type="button" role="tab" aria-controls="pills-penugasan" aria-selected="false">Penugasan</button>
              </li>
              <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadFormCuti()" class="nav-link nav-link-profile" id="pills-penugasan-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">Cuti</button>
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
                <button  onclick="LoadFormArsip()" class="nav-link nav-link-profile" id="pills-cuti-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
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
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>


  
<!-- Modal edit profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="row g-3 align-items-center">
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label">Nama Lengkap</label>
      </div>
      <div class="col-lg-2">
        <input type="text" id="gelar1" name="gelar1" class="form-control" value="<?=$profil_pegawai['gelar1']?>">
      </div>
      <div class="col-lg-6">
        <input type="text" id="nama" name="nama" class="form-control" value="<?=$profil_pegawai['nama']?>">
      </div>
      <div class="col-lg-2">
        <input type="text" id="gelar2" name="gelar2" class="form-control" value="<?=$profil_pegawai['gelar2']?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Lama </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" value="<?=$profil_pegawai['niplama']?>" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Baru </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="inputPassword6" class="form-control" value="<?=$profil_pegawai['nipbaru']?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Tempat / Tanggal Lahir </label>
      </div>
      <div class="col-lg-5">
        <input type="text" id="" class="form-control" value="<?=$profil_pegawai['tptlahir']?>">
      </div>
      <div class="col-lg-5">
        <input type="text" id="" class="form-control" value="<?=$profil_pegawai['tgllahir']?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Kelamin </label>
      </div>
      <div class="col-lg-10">
      <div class="form-check form-check-inline">
      <input <?= $profil_pegawai['jk'] == 'Laki-Laki' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Laki-Laki">
      <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
      </div>
      <div class="form-check form-check-inline">
        <input <?= $profil_pegawai['jk'] == 'Perempuan' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Perempuan">
        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
      </div>

      </div>
      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Golongan Darah </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="inputPassword6" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Alamat </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="inputPassword6" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Unit Kerja / SKPD </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="inputPassword6" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Agama </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Perkawinan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div> 

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Kepegawaian </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div> 

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Kepegawaian </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Jabatan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Jabatan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Pangkat </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Gaji Berkala </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT CPNS </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Pendidikan Terakhir </label>
      </div>
      <div class="col-lg-10">
        <input type="password" id="" class="form-control" >
      </div>

      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Jabatan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jabatan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Jabatan </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Eselon </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div>


      
    </div>
   
      <button type="submit" class="btn btn-primary float-right">Submit</button>
    </form>
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
  var nip = "<?= $nip;?>"; 
  $(function(){
    $('#pills-pangkat-tab').click()
  })

  function loadEditProfilModal(){
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

 function loadFormJabatan(){
  $('#form_jabatan').html(' ')
    $('#form_jabatan').append(divLoaderNavy)
    $('#form_jabatan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormJabatan/')?>'+nip, function(){
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
 

 

 





 




</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
  </div>
<?php } ?>