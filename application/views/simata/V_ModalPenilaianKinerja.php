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

    /* .badge{
      box-shadow: 3px 3px 10px #888888;
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
    } */

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
          <div class="col-lg-6">
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
                <a style="color:#495057" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
                            
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
                                </a>
                                <div class="middle">
                                    <!-- <form id="form_profile_pict" action="<?=base_url('kepegawaian/C_Kepegawaian/updateProfilePict')?>" method="post" enctype="multipart/form-data">
                                        <input title="Ubah Foto Profil" class="form-control" accept="image/x-png,image/gif,image/jpeg" type="file" name="profilePict" id="profilePict">
                                    </form> -->
                                </div>
                        </div>
                  
              </div>

             

              <div class="col-lg-12 text-center">
                <span class="sp_profil">
                <a style="color:#495057" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
                <?=getNamaPegawaiFull($profil_pegawai)?>
                  </a>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
                <span class="sp_profil">
                  <!-- <?=formatNip($profil_pegawai['nipbaru_ws'])?> -->
                  <?=$profil_pegawai['nipbaru_ws']?>
                </span>
              </div>
              <div class="col-lg-12 text-center" >
        
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <!-- profil  -->
              <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile active" id="pills-data_kepeg-tab" data-bs-toggle="pill" data-bs-target="#pills-data_kepeg" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Data Kepegawaian</button>
              </li>
              <!-- <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile " id="pills-data_pribadi-tab" data-bs-toggle="pill" data-bs-target="#pills-data_pribadi" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</button>
              </li>
              
              <li class="nav-item nav-item-profile" role="presentation">
                <button class="nav-link nav-link-profile" id="pills-data_lain-tab" data-bs-toggle="pill" data-bs-target="#pills-data_lain" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Data Lainnya</button>
              </li> -->
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
                  $data = explode("|", $profil_pegawai['data_jabatan']);
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


    
  <div class="row">
    <div class="col-lg-12">
        <span><b>Penilaian Kinerja</b></span>
        <hr>
    <form id="form_penilaian_kinerja" method="post" enctype="multipart/form-data" >
      <input type="hidden" name="id_peg" value="<?=($profil_pegawai['id_peg'])?>">
      <!-- <input type="hidden" name="id_t_penilaian" value="<?=$id_t_penilaian?>"> -->
      <input type="hidden" name="jenis_jab" id="jenis_jab" value="<?=$kode?>">

        <div class="table-responsive">
        <table class="table table-bordered" >
            <tr>
                <td style="background-color:#2e4963;color:#fff" style="width:50%" colspan="4"><b>Spesifik</b></td>
            </tr>
            <tr>
            <td style="width:25%">Penilaian Kinerja N-1</td>
                <td style="width:25%">
                <select class="form-select select2" name="kriteria1" required>
                <option value="0,0,0"  selected>-</option>
                    <?php if($kriteria_kinerja_1){ foreach($kriteria_kinerja_1 as $r){ ?>
                     <option  <?php if($nilai_kinerja) { if($nilai_kinerja['kriteria1'] == $r['id']) echo "selected"; else echo "";} else { if($kinerja_n_1 == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                    <?php } } ?>
                </select>
               </td>
            </tr>

            <tr>
            <td style="width:25%">Penilaian Kinerja N-2 </td>
                <td style="width:25%">
                <select class="form-select select2" name="kriteria2" required>
                <option value="0,0,0"  selected>-</option>
                    <?php if($kriteria_kinerja_2){ foreach($kriteria_kinerja_2 as $r){ ?>
                      <option  <?php if($nilai_kinerja) { if($nilai_kinerja['kriteria2'] == $r['id']) echo "selected"; else echo "";}  else { if($kinerja_n_2 == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                    <?php } } ?>
                </select>
               </td>
            </tr>

            <tr>
            <td style="background-color:#2e4963;color:#fff" colspan="2"><b>Generik</b></td>
            </tr>
            <tr>
                
                <td style="width:25%">Inovatif</td>
                <td style="width:25%">
                <select class="form-select select2" name="kriteria3" required>
                <option value="0,0,0"  selected>-</option>
                    <?php if($kriteria_kinerja_3){ foreach($kriteria_kinerja_3 as $r){ ?>
                      <option  <?php if($nilai_kinerja) { if($nilai_kinerja['kriteria3'] == $r['id']) echo "selected"; else echo "";} else { if($inovasi == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                    <?php } } ?>
                </select>
            </td>
            </tr>

            <tr>
                
                <td style="width:25%">Pengalaman dalam Tim</td>
                <td style="width:25%">
                <select class="form-select select2" name="kriteria4" required>
                <option value="0,0,0"  selected>-</option>
                    <?php if($kriteria_kinerja_4){ foreach($kriteria_kinerja_4 as $r){ ?>
                      <option  <?php if($nilai_kinerja) { if($nilai_kinerja['kriteria4'] == $r['id']) echo "selected"; else echo "";} else { if($timkerja == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                    <?php } } ?>
                </select>
            </td>
            </tr>

            <tr>
              
                <td style="width:25%">Penugasan</td>
                <td style="width:25%">
                <select class="form-select select2" name="kriteria5">
                <option value="0,0,0"  selected>-</option>
                    <?php if($kriteria_kinerja_5){ foreach($kriteria_kinerja_5 as $r){ ?>
                      <option  <?php if($nilai_kinerja) { if($nilai_kinerja['kriteria5'] == $r['id']) echo "selected"; else echo "";} else { if($penugasan == $r['id'])  echo "selected"; else echo ""; }?> value="<?=$r['id']?>,<?=$r['skor']?>,<?=$r['bobot']?>">[<?=$r['skor']?> Poin] <?=$r['nm_kriteria']?></option>
                    <?php } } ?>
                </select>
            </td>
            </tr>

        </table>
        </div>
        <div class="modal-footer" style="margin-bottom:5px;">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button class="btn btn-primary float-right">Simpan</button>
      </div>
      
    </form>
    </div>
    </div>
  
<script>
    $(function(){
   

   $(".select2").select2({   
        width: '500px',
        // dropdownAutoWidth: true,
        allowClear: true,
    });


    $('#form_penilaian_kinerja').on('submit', function(e){
      var kode = $('#jenis_jab').val()

      
                e.preventDefault();
                var formvalue = $('#form_penilaian_kinerja');
                var form_data = new FormData(formvalue[0]);
               
                $.ajax({  
                url:"<?=base_url("simata/C_Simata/submitPenilaianKinerja")?>",
                method:"POST",  
                data:form_data,  
                contentType: false,  
                cache: false,  
                processData:false,  
                // dataType: "json",
                success:function(res){ 
                    console.log(res)
                    var result = JSON.parse(res); 
                    console.log(result)
                    if(result.success == true){
                        successtoast(result.msg)
                        setTimeout(function() {$("#modal_penilaian_kinerja").trigger( "click" );}, 500);
                        if(kode == 1){
                          const myTimeout = setTimeout(loadListPegawaiPenilaianKinerja(kode), 1000);
                        } else {
                          const myTimeout = setTimeout(loadListPegawaiPenilaianKinerja(kode), 1000);

                        }
                        // loadListPegawaiPenilaianKinerjaAdm()
                    
                    } else {
                        errortoast(result.msg)
                        return false;
                    } 
                    
                }  
        }); 
             
    }); 
   
    })
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h5>Data Tidak Ditemukan <i class="fa fa-exclamation"></i></h5>
    </div>
  </div>
<?php } ?>

