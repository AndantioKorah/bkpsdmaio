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

  #profile_pegawai{
      width: 150px;
      height: calc(150px * 1.25);
      background-size: cover;
      object-fit: cover;
      box-shadow: 5px 5px 10px #888888;
      border-radius: 10%;
  }
</style>


<div class="container-fluid pt-2" style="background-color:#fff;">
	<div class="row" style="background-color:#fff;">
		<div class="col-12">
   <div class="12">
   <!-- <a href="<?= base_url('kepegawaian/verifikasi-karis-karsu');?>"> -->
   <a href="<?= base_url('kepegawaian/verifikasi-layanan/');?><?=$id_m_layanan;?>">

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
	
				<div class="col-md-12">



  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="openProfileTab()" class="nav-link nav-link-layanan active" id="pills-profil-tab"
    data-bs-toggle="pill" data-bs-target="#pills-profil" type="button" role="tab" aria-controls="pills-profil" aria-selected="false">Profil</button>
  </li>
  <!-- <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="openPresensiTab()" class="nav-link nav-link-layanan" id="pills-presensi-tab"
    data-bs-toggle="pill" data-bs-target="#pills-presensi" type="button" role="tab" aria-controls="pills-presensi" aria-selected="false">Presensi</button>
  </li> -->
 
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skcpns')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK CPNS</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skpns')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK PNS</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='laporan_perkawinan')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Laporan Perkawinan Pertama</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='daftar_keluarga')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Daftar Keluarga</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='akte_nikah')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Bukuh Nikah / Akte Perkawinan</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pas_foto')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pas Foto Suami/Istri</button>
  <li>



        <button id="btn_verifikasi" type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modelVerif">
        Verifikasi
        </button>
        <form method="post" id="form_batal_verifikasi_layanan" enctype="multipart/form-data" >
        <input type="hidden" name="id_batal" id="id_batal" value="<?= $result[0]['id_pengajuan'];?>">
        <button  id="btn_tolak_verifikasi"  class="btn btn-danger ml-2" style="display:none;">
        Batal Verif
        </button>
        </form>
        </li>


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
    
          <img id="profile_pegawai" class="img-fluidx mb-2 b-lazy"
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
                                echo base_url().$src;?>" /> 

           
          </div>
          <div class="col-lg-12 text-center">
            <span class="sp_profil">
            <?=getNamaPegawaiFull($result[0])?>
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
                  Alamat
                </span>
              </div>
              <div class="col-lg-12 text-left">
                <span class="sp_profil_sm">
                <?=($result[0]['alamat'])?>
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
            <iframe style="display: none; width: 100vh; height: 80vh;" type="application/pdf"  id="view_file_verif"  frameborder="0" ></iframe>	
				</div>
			</div>
      
	

<!-- <button id="btn_verifikasi" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelVerif">
Verifikasi
</button>
<form method="post" id="form_batal_verifikasi_layanan" enctype="multipart/form-data" >
<input type="hidden" name="id_batal" id="id_batal" value="<?= $result[0]['id_pengajuan'];?>">
<button  id="btn_tolak_verifikasi"  class="btn btn-danger" >
Batal Verif
</button>
</form> -->
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
      <form method="post" id="form_verifikasi_layanan_karis_karsu" enctype="multipart/form-data" >
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

    


		
<script>

var nip = "<?= $result[0]['nipbaru_ws'];?>"; 
var status = "<?= $result[0]['status'];?>"; 

$(function(){
  // $( "#sidebar_toggle" ).trigger( "click" );

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



        $('#form_verifikasi_layanan_karis_karsu').on('submit', function(e){
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
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiPengajuanKarisKarsu")?>',
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
                url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiPengajuanKarisKarsu")?>',
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


  


</script>
