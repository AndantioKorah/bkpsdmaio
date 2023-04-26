<link rel="stylesheet" href="<?php echo base_url()?>assets/siladen/plugins/dropzone/dropzone.css">
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/adminkit/css/modal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url('assets/css/datatable.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/responsive.dataTables.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/datatable.bootstrap.min.css')?>"> -->
    <style>

h2{
  color:#000;
  text-align:center;
  font-size:2em;
}
.warpper{
  display:flex;
  flex-direction: column;
  align-items: left;
  width:100%;
}
.tab{
  cursor: pointer;
  padding:10px 20px;
  margin:0px 2px;
  /* background:#000; */
  background:#222e3c;
  display:inline-block;
  color:#fff;
  border-radius:3px 3px 0px 0px;
  /* box-shadow: 0 0.5rem 0.8rem #00000080; */
  margin-bottom: 10px;
  font-size : 12px;
  border-color : #000;
}
.panels{
  /* background:#f2f4f8; */
  /* box-shadow: 0 2rem 2rem #00000080; */
  min-height:200px;
  width:100%;
  /* max-width:500px; */
  border-radius:3px;
  overflow:hidden;
  padding:20px;  
  margin-top:-20px;
}
.panel{
  display:none;
  animation: fadein .8s;
}
@keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
.panel-title{
  font-size:1.5em;
  /* font-weight:bold */
}
.radio{
  display:none;
}
#pangkat:checked ~ .panels #pangkat-panel,
#gb:checked ~ .panels #gb-panel,
#pendidikan:checked ~ .panels #pendidikan-panel,
#jabatan:checked ~ .panels #jabatan-panel,
#diklat:checked ~ .panels #diklat-panel,
#disiplin:checked ~ .panels #disiplin-panel,
#organisasi:checked ~ .panels #organisasi-panel,
#penghargaan:checked ~ .panels #penghargaan-panel,
#sj:checked ~ .panels #sj-panel,
#keluarga:checked ~ .panels #keluarga-panel,
#penugasan:checked ~ .panels #penugasan-panel,
#cuti:checked ~ .panels #cuti-panel,
#arsip:checked ~ .panels #arsip-panel{
  display:block
}
#pangkat:checked ~ .tabs #pangkat-tab,
#gb:checked ~ .tabs #gb-tab,
#pendidikan:checked ~ .tabs #pendidikan-tab,
#jabatan:checked ~ .tabs #jabatan-tab,
#diklat:checked ~ .tabs #diklat-tab,
#disiplin:checked ~ .tabs #disiplin-tab,
#organisasi:checked ~ .tabs #organisasi-tab,
#penghargaan:checked ~ .tabs #penghargaan-tab,
#sj:checked ~ .tabs #sj-tab,
#keluarga:checked ~ .tabs #keluarga-tab,
#penugasan:checked ~ .tabs #penugasan-tab,
#cuti:checked ~ .tabs #cuti-tab,
#arsip:checked ~ .tabs #arsip-tab{
  background:#fffffff6;
  color:#000;
  border-top: 3px solid #222e3c;
  border-bottom: 2px solid #222e3c;
}
     </style>

<!-- upload dokumen  -->
<div class="container-fluid p-0">
<!-- <h1 class="h3 mb-3">Upload Dokumen</h1> -->

<div class="row">
    <div class="col-lg-12">
      <div class="card card-default">
        <div class="card-body">
          <h4>PROFIL PEGAWAI</h4>
          <hr>
          <table width="100%" border="0">
            <p>
              <tr>
                <td width="152">Nama</td>
                <td width="13">:</td>
                <td width="806" style="font-size: 1rem; font-weight: bold;">
                <?= getNamaPegawaiFull($profil_pegawai) ?></td>
              </tr>
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td style="font-size: 1rem; font-weight: bold;"><?= $profil_pegawai['nipbaru']?></td>
              </tr>
              <tr>
                <td>Tempat/Tgl Lahir </td>
                <td>:</td>
                <td><?= $profil_pegawai['tptlahir']?> / <?= formatDateNamaBulan($profil_pegawai['tgllahir'])?><td>
              </tr>
              <tr>
                <td>Jenis Kelamin </td>
                <td>:</td>
                <td><?= $profil_pegawai['jk']?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $profil_pegawai['alamat']?></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= $profil_pegawai['nm_agama']?></td>
              </tr>
              <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $profil_pegawai['nm_tktpendidikan']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

              </tr>
              <tr>
                <td>Pangkat / TMT </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nm_pangkat']?> /
                  <?php 
                        if ($profil_pegawai['tmtpangkat'] =='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan(date($profil_pegawai['tmtpangkat'])); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>TMT Gaji Berkala </td>
                <td>:</td>
                <td><?php 
                        if ($profil_pegawai['tmtgjberkala']=='0000-00-00')
                        {
                        
                          echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($profil_pegawai['tmtgjberkala']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Jabatan / TMT </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nama_jabatan']?> /
                  <?php 
                        if ($profil_pegawai['tmtjabatan']=='0000-00-00')
                        {
                        echo "-";
                        }
                        else
                        {
                        echo formatDateNamaBulan($profil_pegawai['tmtjabatan']); 
                        }
                        ?></td>
              </tr>
              <tr>
                <td>Unit Kerja </td>
                <td>:</td>
                <td><?php echo $profil_pegawai['nm_unitkerja']?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>NIK </td>
                <td>:</td>
                <td><?= $profil_pegawai['nik']?></td>
              </tr>
              <tr>
                <td>No HP </td>
                <td>:</td>
                <td><?= $profil_pegawai['handphone']?></td>
              </tr>
              <tr>
                <td>Email </td>
                <td>:</td>
                <td><?= $profil_pegawai['email'] ?></td>
              </tr>
            </p>
          </table>
        </div>
      </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">

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
            </style>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <!-- <li class="nav-item" role="presentation">
    <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true">Profil</a>
  </li> -->
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPangkat()" class="nav-link active" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pangkat</button>
  </li>
  <li class="nav-item" role="presentation">
    <button  onclick="loadFormGajiBerkala()" class="nav-link" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Gaji Berkala</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPendidikan()" class="nav-link" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pendidikan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormJabatan()" class="nav-link" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormDiklat()" class="nav-link" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormOrganisasi()" class="nav-link" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Organisasi</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPenghargaan()" class="nav-link" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Penghargaan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="LoadFormSumpahJanji()" class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-sj" type="button" role="tab" aria-controls="pills-sj" aria-selected="false">Sumpah/Janji</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormKeluarga()"  class="nav-link" id="pills-sj-tab" data-bs-toggle="pill" data-bs-target="#pills-keluarga" type="button" role="tab" aria-controls="pills-keluarga" aria-selected="false">Keluarga</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormPenugasan()" class="nav-link" id="pills-keluarga-tab" data-bs-toggle="pill" data-bs-target="#pills-penugasan" type="button" role="tab" aria-controls="pills-penugasan" aria-selected="false">Penugasan</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormCuti()" class="nav-link" id="pills-penugasan-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">Cuti</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormSkp()" class="nav-link" id="pills-skp-tab" data-bs-toggle="pill" data-bs-target="#pills-skp" type="button" role="tab" aria-controls="pills-cuti" aria-selected="false">SKP</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadFormAssesment()" class="nav-link" id="pills-assesment-tab" data-bs-toggle="pill" data-bs-target="#pills-assesment" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Hasil Assesment</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-cuti-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
  </li>
</ul>
<hr>
<div class="tab-content" id="pills-tabContent">
  <!-- <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
      
  </div> -->
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
  <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab">...</div>
</div>       
            </div>
        </div>
    </div>
        </div>
        </div>
<!-- tutup upload dokumen  -->
<script>



var nip = "<?= $nip;?>"; 
$(function(){
  $('#pills-pangkat-tab').click()
  // $('#form_pangkat').html(' ')
  //   $('#form_pangkat').append(divLoaderNavy)
  //   $('#form_pangkat').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormDokPangkat/')?>'+jenis_user, function(){
  //   $('#loader').hide()    
  //   })

        
  })

 

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

 





 




</script>