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
    <?php if($result[0]['status_layanan'] == 0) { ;?>
      <button id="btn_verifikasi" type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#modelVerif">
        Verifikasi
        </button>
        <?php } ?>
        <?php if($result[0]['status_layanan'] != 0) { ;?>
          <button  type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#modelVerif">
        Update Status
        </button>

        <!-- <button id="btn_tolak_verifikasi" onclick="batalVerifLayanan('<?=$id_usul;?>')" type="button" class="btn btn-sm btn-danger ml-2">
        Batal Verif
        </button> -->
        <?php } ?>
        <?php if($result[0]['status_layanan'] == 4 || $result[0]['status_layanan'] == 6) { ;?>
        <button 
        id="btn_upload_sk"
        data-toggle="modal" 
        href="#modal_upload_sk"
        onclick="loadModalUploadSK('<?=$id_usul;?>','<?=$id_m_layanan;?>')" title="Ubah Data" class="btn btn-sm btn-primary ml-2"> 
        <i class="fa fa-upload" aria-hidden="true"> </i> Upload SK</button>
        <?php } ?>
        <?php if($result[0]['status_layanan'] == 6) { ;?>
        <button  href="#modal_view_file" onclick="openFileJabatan('<?=$result[0]['dokumen_layanan']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
        <i class="fa fa-file-pdf"></i> Lihat Dokumen</button>
        <?php } ?>
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
    
    <button id="btn_lihat_file" href="#modal_view_file" onclick="openFileJabatan('<?=$result[0]['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
    <i class="fa fa-file-pdf"></i> File Jabatan</button>
    <?php if($result[0]['status_layanan'] == 6) { ?>
    <button onclick="deleteFile('<?=$id_usul;?>','<?=$result[0]['reference_id_dok'];?>',<?=$id_m_layanan;?>)"  id="btn_hapus_file"  class="btn btn-sm btn-danger ml-1 ">
    <i class="fa fa-file-trash"></i> Hapus File</button>
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
    </li>
  <?php if($id_m_layanan == 12 || $id_m_layanan == 13) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile('surat_pernyataan_hd')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Surat Pernyataan tidak sedang hukuman disiplin dari atasan langsung</button>
  </li>
  <?php } ?>
   
  <?php if($id_m_layanan == 12 || $id_m_layanan == 13 || $id_m_layanan == 14 ) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='formasi')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Surat Pernyataan Tersedia Formasi</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skp1')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SKP <?=$tahun_1_lalu;?></button>
  </li>
    <?php if($id_m_layanan != 12) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skp2')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SKP <?=$tahun_2_lalu;?></button>
    </li> 
  <?php } ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pak')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">PAK </button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='peta_jabatan')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Peta Jabatan</button>
  </li>
  <?php } ?>
  <?php if($id_m_layanan == 12) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sertiukom')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sertifikat Lulus Uji Komptensi</button>
  </li>
   <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='tangkap_layar_myasn')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tangkap Layar MyASN</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Jabatan Fungsional Terakhir</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='str_serdik')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">STR / Serdik </button>
  </li>
  <?php } ?>
  <?php if($id_m_layanan == 13) { ?>
    <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sertiukom')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sertifikat Lulus Uji Komptensi</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='tangkap_layar_myasn')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tangkap Layar MyASN</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Jabatan Fungsional Terakhir</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='str_serdik')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">STR / Serdik </button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='ijazah')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Ijazah </button>
  </li>
  
<?php } ?>
<?php if($id_m_layanan == 14) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='rekom_instansi_pembina')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Surat Rekomendasi dari Instansi Pembina</button>
  </li>
  <?php } ?>
<?php if($id_m_layanan == 15) { ?>
  
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='surat_pernyataan_bersedia_tidak_diangkat_jabfung_lagi')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Surat peryataan bersedia tidak diangka kembali dalam jabatan fungsional </button>
  </li>
   <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Jabatan Fungsional Terakhir</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pengunduran_diri')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Permohonan Pengunduran Diri </button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='rekom_kepala_pd')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Rekomendasi Kepala Perangkat Daerah </button>
  </li>
<?php } ?>
<?php if($id_m_layanan == 16) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_mutasi_instasi')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Mutasi Antar Instansi</button>
  </li>
   <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pak')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">PAK</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skp1')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SKP <?=$tahun_1_lalu;?></button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skp2')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SKP <?=$tahun_2_lalu;?></button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='peta_jabatan')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Peta Jabatan</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional_pertama')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pengangkatan Pertama dalam Jabatan Fungsional</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Jabatan Fungsional Terakhir</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_pemberhentian_dari_jabfung')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pemberhentian dari Jabatan Fungsional</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_pengaktifan_kembali')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pengaktifan Kembali</button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='cltn')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK CLTN</button>
  </li>
 <?php } ?>
 <?php if($id_m_layanan == 30) { ?>
<li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_jabatan_fungsional')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Jabatan Fungsional Terakhir</button>
</li>
<li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pak')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">PAK </button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='sk_tubel')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Tugas Belajar </button>
  </li>
 <?php } ?>

  <?php if($id_m_layanan == 31) { ?>
<li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skpangkat')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pangkat Terakhir</button>
</li>
<li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='ijazahd4s1')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Ijazah DI-V atau S-1 </button>
  </li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='str_serdik')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sertifikat Pendidik </button>
  </li>
 <?php } ?>

<?php if($id_m_layanan != 30) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='dok_lain')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Dokumen lain apabila diperlukan</button>
  </li>
 <?php } ?>

</ul>
<hr style="margin-top: 10px;">
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show " id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <!-- <div style="margin-left:10px;" class="col-lg-12">
  </div> -->
  </div>
  
  <div style="border-style:solid;border-color: #222e3c;padding:10px;background-color:#e1e1e1;" class="tab-pane show active" id="pills-profil" role="tabpanel" aria-labelledby="pills-profil-tab">
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
              <?=($result[0]['nipbaru_ws'])?>
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
              <?php if($result[0]['handphone'] != null) { ?>
                    <a target="_blank" class="sp_whatsapp" href="https://wa.me/<?=convertPhoneNumber($result[0]['handphone'])?>">
                      <?= $result[0]['handphone'] != null ? $result[0]['handphone'] : '-'; ?>
                      <i class="fab fa-whatsapp"></i></a>
                  <?php } else { ?>
                    <?= $result[0]['handphone'] != null ? $result[0]['handphone'] : '-'; ?>
                  <?php } ?>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->

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
        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $result[0]['id_pengajuan'];?>">
        <input type="hidden" name="formasi" id="formasi" value="<?php if(isset($formasi)) echo $formasi['id']; else echo "";?>">
		<input type="hidden" name="sertiukom" id="sertiukom" value="<?php if(isset($sertiukom)) echo $sertiukom['id']; else echo "";?>">
		<input type="hidden" name="peta_jabatan" id="peta_jabatan" value="<?php if(isset($peta_jabatan)) echo $peta_jabatan['id']; else echo "";?>">
		<input type="hidden" name="skp1" value="<?php if($skp1) echo $skp1['id']; else echo "";?>">
    <input type="hidden" name="skp2" value="<?php if($skp2) echo $skp2['id']; else echo "";?>">
		<input type="hidden" name="pak" value="<?php if(isset($pak)) echo $pak['id']; else echo "";?>">
		<input type="hidden" name="sk_jabatan_fungsional" value="<?php if($sk_jabatan_fungsional) echo $sk_jabatan_fungsional['id']; else echo "";?>">
		<input type="hidden" name="sk_jabatan_fungsional_pertama" value="<?php if($sk_jabatan_fungsional_pertama) echo $sk_jabatan_fungsional_pertama['id']; else echo "";?>">

		<input type="hidden" name="dok_lain" value="<?php if($dok_lain) echo $dok_lain['id']; else echo "";?>">
		<input type="hidden" name="ijazah" value="<?php if(isset($ijazah)) echo $ijazah['id']; else echo "";?>">
		<input type="hidden" name="str_serdik" value="<?php if(isset($str_serdik)) echo $str_serdik['id']; else echo "";?>">
		<input type="hidden" name="rekom_instansi_pembina" value="<?php if(isset($rekom_instansi_pembina)) echo $rekom_instansi_pembina['id']; else echo "";?>">
		<input type="hidden" name="surat_usul_pyb" value="<?php if(isset($surat_usul_pyb)) echo $surat_usul_pyb['id']; else echo "";?>">
		<input type="hidden" name="pengunduran_diri" value="<?php if(isset($pengunduran_diri)) echo $pengunduran_diri['id']; else echo "";?>">
		<input type="hidden" name="sk_pemberhentian_dari_jabfung" value="<?php if(isset($sk_pemberhentian_dari_jabfung)) echo $sk_pemberhentian_dari_jabfung['id']; else echo "";?>">
		<input type="hidden" name="sk_pengaktifan_kembali" value="<?php if(isset($sk_pengaktifan_kembali)) echo $sk_pengaktifan_kembali['id']; else echo "";?>">
		<input type="hidden" name="cltn" value="<?php if(isset($cltn)) echo $cltn['id']; else echo "";?>">
     
    
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example" name="status" id="status">
        <option >--</option>
        <option <?php if($result[0]['status_layanan'] == 1) echo "selected";?> value="1">Verifikasi BKPSDM</option>
        <option <?php if($result[0]['status_layanan'] == 2) echo "selected";?> value="2">Rekomendasi TPK</option>
        <option <?php if($result[0]['status_layanan'] == 3) echo "selected";?> value="3">Pengajuan Pertek</option>
        <option <?php if($result[0]['status_layanan'] == 4) echo "selected";?> value="4">Proses SK Jabatan</option>
        <option <?php if($result[0]['status_layanan'] == 5) echo "selected";?> value="5">BTL</option>
        <option <?php if($result[0]['status_layanan'] == 7) echo "selected";?> value="7">TMS</option>

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
var dok = "<?= $result[0]['dokumen_layanan'];?>";
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
    $('#btn_upload_dok').hide()
    $('#btn_verifikasi').show()
    $('#btn_lihat_dok').hide()
   } else if(status == 1) {
    $('#btn_upload_sk').show()
    if(dok == null || dok == ""){
      $('#btn_tolak_verifikasi').show()
      $('#btn_lihat_dok').hide()
    } else {
      $('#btn_tolak_verifikasi').hide()
      $('#btn_upload_dok').show()
      $('#btn_lihat_dok').show()
    } 
    // $('#btn_upload_dok').show()
    $('#btn_verifikasi').hide()
   } else if(status == 2) {
    $('#btn_tolak_verifikasi').show()
    $('#btn_upload_dok').hide()
    $('#btn_upload_sk').hide()
    $('#btn_verifikasi').hide()
    $('#btn_lihat_dok').hide()
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
        } else if(file == "sk_tubel" || file == "tangkap_layar_myasn" || file =="sk_pengaktifan_kembali" || file == "sk_mutasi_instasi" || file == "rekom_kepala_pd" || file =="sk_pemberhentian_dari_jabfung" || file =="pengunduran_diri" || file =="surat_usul_pyb" || file =="rekom_instansi_pembina" || file =="str_serdik" || file == "dok_lain" || file == "formasi" || file == "pak" || file == "ibel" || file == "sertiukom" || file == "forlap" || file== "stlud" || file== "uraiantugas" || file== "pmk" || file == "skjabterusmenerus" || file == "peta" || file == "akreditasi" || file == "peta_jabatan"){
          dir = "arsiplain/";
        } else if(file == "diklat"){
          dir = "arsipdiklat/";
        } else if(file == "skjabatan" || file == "sk_jabatan_fungsional" || file == "sk_jabatan_fungsional_pertama"){
          dir = "arsipjabatan/";
        } else if(file == "suratpengantar"){
            dir = "./dokumen_layanan/jabatan_fungsional/";
        } else if(file == "ijazah" || file == "ijazahd4s1"){
          dir = "./arsippendidikan/";
        } else if(file == "surat_pernyataan_hd" || file == 'surat_pernyataan_bersedia_tidak_diangkat_jabfung_lagi') {
          dir = "./dokumen_layanan/jabatan_fungsional/surat_ket_hd/";
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
            } else if(file == "surat_pernyataan_hd" || file == "surat_pernyataan_bersedia_tidak_diangkat_jabfung_lagi"){
              var link = "<?=base_url();?>/"+dir+"/"+data[0].surat_pernyataan_tidak_hd+"?v="+number;
            }  else {
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
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitVerifikasiPengajuanLayananFungsional")?>',
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
                  location.reload()
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

  async function openFileJabatan(filename){

$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 1000);
$link = "<?=base_url();?>arsipjabatan/"+filename+"?v="+number;

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

        $('#upload_dok_form').on('submit', function(e){  
        document.getElementById('btn_uploadkgb').disabled = true;
        $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_dok_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_dok').files.length;
       
        if(ins == 0){
        errortoast("Silahkan upload file terlebih dahulu");
        return false;
        }

      
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/uploadSKLayanan")?>",
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
                document.getElementById("upload_dok_form").reset();
                setTimeout(window.location.reload.bind(window.location), 1000);
                
                  
            //    $('#btn_upload_pangkat').html('Simpan')
               
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });
        
               $("#pdf_file_dok").change(function (e) {

              // var extension = pdf_file_dok.value.split('.')[1];
              var doc = pdf_file_dok.value.split('.')
              var extension = doc[doc.length - 1]

              var fileSize = this.files[0].size/1024;
              var MaxSize = 1024;

              if (extension != "pdf"){
                errortoast("Harus File PDF")
                $(this).val('');
              }

              if (fileSize > MaxSize ){
                errortoast("Maksimal Ukuran File 2 MB")
                $(this).val('');
              }

              });

</script>
