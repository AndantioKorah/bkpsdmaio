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
  .customTextarea { width: 100% !important; height: 125px!important; }

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
   <a href="<?= base_url('kepegawaian/verifikasi-layanan');?>/<?=$id_m_layanan;?>" >
    <button  class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
  </a>
  <?php if($result[0]['reference_id_dok'] == null) { ;?>
  <!-- <button 
  id="btn_upload_sk"
  data-toggle="modal" 
  href="#modal_upload_sk"
  onclick="loadModalUploadSK('<?=$id_usul;?>','<?=$id_m_layanan;?>')" title="Ubah Data" class="btn btn-sm btn-primary ml-2"> 
  <i class="fa fa-upload" aria-hidden="true"> </i> Upload SK</button> -->
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
  Download Draf SK
  </button> -->
  <?php if($result[0]['verifikator'] == 0) { ;?>
  <!-- <button id="btn_kerjakan" onclick="kerjakanPengajuan('<?=$id_usul;?>',1)" type="button" class="btn btn-sm btn-primary ml-2">
        Kerjakan Pengajuan ini
        </button> -->
<?php } else { ?>
  <?php if($result[0]['status_layanan'] == 0) { ;?>
  <!-- <button id="btn_kerjakan" onclick="kerjakanPengajuan('<?=$id_usul;?>',0)" type="button" class="btn btn-sm btn-danger ml-2">
        Batal Kerjakan Pengajuan ini
        </button> -->
  <?php } ?>
<?php } ?>
  <button id="btn_verifikasi" type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#modelVerif">
        Verifikasi
        </button>

        <button id="btn_tolak_verifikasi" onclick="batalVerifLayanan('<?=$id_usul;?>')" type="button" class="btn btn-sm btn-danger ml-2">
        Batal Verif
        </button>
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="post" enctype="multipart/form-data" action="<?=base_url('kepegawaian/C_Kepegawaian/downloadDrafSKPangkat/'.$id_usul.'/'.$id_m_layanan.'')?>" target="_blank">
          <div class="form-group">
          <label for="exampleInputEmail1">Nomor Surat</label>
          <input type="text" class="form-control" id="nomor_sk" name="nomor_sk" >
          </div>
          <div class="form-group">
          <label >Nomor Pertek BKN</label>
          <input type="text" class="form-control" id="nomor_pertek" name="nomor_pertek" >
          </div>
          <div class="form-group">
          <label >Nomor Urut</label>
          <input type="text" class="form-control" id="nomor_urut" name="nomor_urut" >
          </div>
          <div class="form-group">
          <label >TMT Pangkat</label>
          <input type="text" class="form-control datepickerr"  id="tmtpangkat" name="tmtpangkat" >
          </div>
          <div class="form-group">
          <label >Gaji</label>
          <input type="text" class="form-control" id="gaji" name="gaji" >
          </div>
          <div class="form-group">
          <label >Angka Kredit</label>
          <input type="number" class="form-control" id="ak" name="ak" >
          </div>
          <button type="submit" class="btn btn-sm btn-info float-right mt-2"><i class="fa fa-file-pdf"></i> Download</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <?php } else { ?>
    
    <button id="btn_lihat_file" href="#modal_view_file" onclick="openFilePangkat('<?=$result[0]['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
    <i class="fa fa-file-pdf"></i> File Pangkat</button>
    <?php if($result[0]['status_layanan'] <= 2) { ?>
    <button onclick="deleteFile('<?=$id_usul;?>','<?=$result[0]['reference_id_dok'];?>',<?=$id_m_layanan;?>)"  id="btn_hapus_file"  class="btn btn-sm btn-danger ml-1 ">
    <i class="fa fa-file-trash"></i> Hapus File</button>
    <?php } ?>
    <?php if($result[0]['status_layanan'] == 1) { ?>
    <button onclick="kirimBkad('<?=$id_usul;?>',3)" id="btn_lihat_file" class="btn btn-sm btn-navy-outline ml-1">
    Teruskan ke BKAD <i class="fa fa-arrow-right"></i></button>
    <?php } else if($result[0]['status_layanan'] == 3) { ?>
    <button onclick="kirimBkad('<?=$id_usul;?>',1)" id="btn_lihat_file" class="btn btn-sm btn-outline-danger ml-1">
    Batal Teruskan ke BKAD <i class="fa fa-arrow-left"></i></button>
    <?php } ?>
    <?php } ?>



   </div>


<div class="row">
<div class="col-md-12">
  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="openProfileTab()" class="nav-link nav-link-layanan active" id="pills-profil-tab"
    data-bs-toggle="pill" data-bs-target="#pills-profil" type="button" role="tab" aria-controls="pills-profil" aria-selected="false">Profil</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='suratpengantar')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Surat Pengantar</button>
  <li>
  <?php if($id_m_layanan == 10 || $id_m_layanan == 11) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skcpns')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK CPNS</button>
  <li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skpns')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK PNS</button>
  <li>

  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skpangkat')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pangkat Akhir</button>
  <li>
  <?php } ?>
  <?php if($id_m_layanan == 10) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='ijazah_cpns')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Ijazah saat melamar CPNS</button>
  <li>
  <?php } ?>
  

        </li>


</ul>
<hr style="margin-top: 10px;">
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show " id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <!-- <div style="margin-left:10px;" class="col-lg-12">
  </div> -->
  </div>
  
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
          <a href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$result[0]['nipbaru_ws']?>" target="_blank">
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
                                </a>
          </div>
          <div class="col-lg-12 text-center">
          <a style="color:#495057;" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$result[0]['nipbaru_ws']?>" target="_blank">
            <span class="sp_profil">
            <?=getNamaPegawaiFull($result[0])?>
            </span>
          </a>
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
                  <?=formatDateNamaBulan($result[0]['tmt_pangkat'])?>
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
<h5 style="display: none;"  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <!-- <iframe style="display: none; width: 100vh; height: 80vh;" type="application/pdf"  id="view_file_verif"  frameborder="0" ></iframe>	 -->
            <iframe style="display: none; width: 100%;height: 90vh;" type="application/pdf"  id="view_file_verif"  frameborder="0" ></iframe>	
          </div>
			</div>
    
<style>
</style>



<!-- Modal -->
<div class="modal fade" id="modelVerif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_verifikasi_layanan" enctype="multipart/form-data" >
        <input type="text" name="id_pengajuan" id="id_pengajuan" value="<?= $result[0]['id_pengajuan'];?>">
        <input type="text" id="sk_cpns" name="sk_cpns"  value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
        <input type="text" id="sk_pns" name="sk_pns"  value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
        <input type="text" id="sk_pangkat" name="sk_pangkat"  value="<?php if($sk_pangkat) echo $sk_pangkat['id']; else echo "";?>">
        <input type="text" id="ijazah_cpns" name="ijazah_cpns"  value="<?php if($ijazah_cpns) echo $ijazah_cpns['id']; else echo "";?>">
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
    </div>
  </div>
</div>



		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_upload_sk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        ...
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="modal_view_file" >
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
           <div id="modal_view_file_content">
            <h5  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file"  frameborder="0" ></iframe>	
          </div>
        </div>
      </div>
    </div>
</div>
    


		
<script>


var nip = "<?= $result[0]['nipbaru_ws'];?>"; 
var status = "<?= $result[0]['status_layanan'];?>";

$(function(){
  // $( "#sidebar_toggle" ).trigger( "click" );
  
  $('.datepickerr').datepicker({
     format: 'dd-mm-yyyy',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });


   if(status == 0){
    $('#btn_upload_sk').hide()
    $('#btn_tolak_verifikasi').hide()
    $('#btn_verifikasi').show()
   } else if(status == 1) {
    $('#btn_upload_sk').show()
    $('#btn_tolak_verifikasi').show()
    $('#btn_verifikasi').hide()
   } else if(status == 2) {
    $('#btn_tolak_verifikasi').show()
    $('#btn_upload_sk').hide()
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
   
    var id_layanan = "<?=$id_m_layanan;?>";

    if(file == "skcpns" || file == "skpns"){
          dir = "arsipberkaspns/";
        } else if(file == "skpangkat"){
          dir = "arsipelektronik/";
        } else if(file == "skp1" || file == "skp2"){
          dir = "arsipskp/";
        } else if(file == "pak" || file == "ibel" || file == "sertiukom" || file == "forlap" || file== "stlud" || file== "uraiantugas" || file== "pmk" || file == "skjabterusmenerus" || file == "peta" || file == "akreditasi"){
          dir = "arsiplain/";
        } else if(file == "diklat"){
          dir = "arsipdiklat/";
        } else if(file == "skjabatan"){
          dir = "arsipjabatan/";
        } else if(file == "suratpengantar"){
          if(id_layanan == 10){
            dir = "./dokumen_layanan/perbaikan_data/";
          } else {
            dir = "./dokumen_layanan/permohonan_salinan_sk/";
          }
        } else if(file == "ijazah_cpns"){
          dir = "./arsippendidikan/";
        }  else {
          dir = "uploads/";
        }

  var id_usul = "<?=$id_usul;?>";
   var id_peg = "<?=$result[0]['id_peg'];?>";
   $.ajax({
        type : "POST",
        url  : "<?=base_url();?>" + '/kepegawaian/C_Kepegawaian/getFileForVerifLayanan',
        dataType : "JSON",
        data : {id_peg:id_peg,file:file,id_usul:id_usul},
        success: function(data){
        $('#divloader').html('')
      
        if(data != ""){
          if(data[0].gambarsk != ""){
            var number = Math.floor(Math.random() * 1000);

            if(file == "suratpengantar"){
            var link = "<?=base_url();?>/"+dir+"/"+data[0].file_pengantar+"?v="+number;
            } else {
              var link = "<?=base_url();?>/"+dir+"/"+data[0].gambarsk+"?v="+number;

            }

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

          //  if(status == "2"){
           if(catatan == ""){
            errortoast('Silahkan mengisi catatan')
            return false;
           }
          //  }


            e.preventDefault()
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiPengajuanLayanan")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(datares){
                  successtoast('Data Berhasil Diverifikasi')
                  if(status == 1){
                    $('#btn_upload_sk').show()
                  } else {
                    $('#btn_upload_sk').hide()

                  }
                  // loadListUsulLayanan(1)
                  $('#btn_tolak_verifikasi').show()
                  // $('#btn_upload_sk').show()
                  $('#btn_verifikasi').hide()
                //   location.reload()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })


        function loadModalUploadSK(id_usul,id_m_layanan){
        $('#modal_body').html('')
        $('#modal_body').append(divLoaderNavy)
        $('#modal_body').load('<?=base_url("kepegawaian/C_Kepegawaian/loadModalUploadSK")?>'+'/'+id_usul+'/'+id_m_layanan, function(){
          $('#loader').hide()
        })
        }


          function batalVerifLayanan(id_usul){
          
            if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiPengajuanLayanan")?>',
                method: 'post',
                // data: $(this).serialize(),
                data: {
                id_batal: id_usul
            },
                success: function(data){
                  successtoast('Berhasil batal verifikasi ')
                  location.reload()
                  // $('#btn_tolak_verifikasi').hide()
                  //$('#btn_upload_sk').hide()
                  //$('#btn_verifikasi').show()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })

            
          }
  }

  function kerjakanPengajuan(id_usul,id){

    if(id == 1){
      var pesan = "Kerjakan Pengajuan Pangkat ini ?";
    } else {
      var pesan = "Batal Kerjakan Pengajuan Pangkat ini ?";
    }
          
          if(confirm(pesan)){
          $.ajax({
              url: '<?=base_url("kepegawaian/C_Kepegawaian/kerjakanPengajuanLayanan")?>',
              method: 'post',
              // data: $(this).serialize(),
              data: {
                id_usul: id_usul, id : id
          },
              success: function(data){
                location.reload()
              }, error: function(e){
                  errortoast('Terjadi Kesalahan')
              }
          })

          
        }
}

  async function openFilePangkat(filename){

$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 1000);
$link = "<?=base_url();?>/arsipelektronik/"+filename+"?v="+number;

$('#iframe_view_file').attr('src', $link)
$('#iframe_view_file').on('load', function(){
  $('.iframe_loader').hide()
  $(this).show()
})
}


function deleteFile(id,reference_id_dok,id_m_layanan){
                   
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteFileLayanan/")?>'+id+'/'+reference_id_dok+'/'+id_m_layanan,
                           method: 'post',
                           data: null,
                           success: function(){

                               successtoast('Data sudah terhapus')
                               setTimeout(window.location.reload.bind(window.location), 1000);
                               
                              //  const myTimeout = setTimeout(location.reload(), 2000);
                            
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

function kirimBkad(id,status){
                  // var tanggal =  new Date();
                  // alert(tanggal)
                  // return false;
                   if(status == 3){
                    var pesan = "kirim Data ke BKAD ?";
                   } else {
                    var pesan = "Batal kirim Data ke BKAD ?";
                   }
                   if(confirm(pesan)){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/kirimBkad/")?>'+id+'/'+status,
                           method: 'post',
                           data: { tanggalkirim : tanggal},
                           success: function(){
                               successtoast('Data berhasil terkirim')
                               setTimeout(window.location.reload.bind(window.location), 1000);
                              //  const myTimeout = setTimeout(location.reload(), 2000);
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }



</script>
