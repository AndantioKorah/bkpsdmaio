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

  input[readonly] {
    background-color:rgb(204, 204, 207);
}

    input[readonly]:focus{
    outline: 2px solid grey;
    background-color : rgb(204, 204, 207);   /* oranges! yey */
    }
</style>


<div class="container-fluid pt-2" style="background-color:#fff;">
	<div class="row" style="background-color:#fff;">
	<div class="col-12">
    <?php if(!$result){ ?>
        <button id="btn_verifikasi" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modelVerif">
        Verifikasi
        </button>
    <?php } else { ?>
      <?php if($result[0]['status'] < 2){ ?>
        <button id="btn_tolak_verifikasi" onclick="batalVerifProsesKgb('<?=$result[0]['id'];?>')" type="button" class="btn btn-sm btn-danger">
        Batal Verif
        </button>
       
        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
        Download Draf SK
        </button>
       
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUploadSKKgb">
        Upload SK 
        </button>
       <?php } ?>
       <?php if($result[0]['status'] == 2){ ?>
       
       <button id="btn_lihat_file" href="#modal_view_file" onclick="openFileKgb('<?=$result[0]['gambarsk']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
       <i class="fa fa-file-pdf"></i> File SK Kenaikan Berkala</button>
       <button onclick="deleteFile('')"  id="btn_hapus_file"  class="btn btn-sm btn-danger ml-1 ">
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
    <button onclick="getFile(file='skpangkat')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Pangkat Akhir</button>
  <li>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='skkgb')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SK Kenaikan Gaji Berkala Terakhir
    </button>
  <li>
  



</ul>
<hr style="margin-top: 10px;">
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show " id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <div style="margin-left:10px;" class="col-lg-12">
  <div id="divloader" class="col-lg-12 text-center">
</div>
<span id="ket_file"></span>
  <h5 style="display: none;"  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <!-- <iframe style="display: none; width: 100vh; height: 80vh;" type="application/pdf"  id="view_file_verif_kgb"  frameborder="0" ></iframe>	 -->
            <iframe style="display: none; width: 100%;height: 90vh;" type="application/pdf"  id="view_file_verif_kgb"  frameborder="0" ></iframe>	
  </div>
  </div>
  
  <div class="tab-pane show active" id="pills-profil" role="tabpanel" aria-labelledby="pills-profil-tab">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <?php if($profil_pegawai['statuspeg'] == 1){ ?>
            <div class="col-lg-12 text-left">
              <h3><span class="badge badge-danger">CPNS</span></h3>
            </div>
          <?php } ?>
          <div class="col-lg-12 text-center">
          <a href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
          <img id="profile_pegawai" class="img-fluidx mb-2 b-lazy"
                            data-src="<?php
                                $path = './assets/fotopeg/'. $profil_pegawai['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'. $profil_pegawai['fotopeg'];
                                if( $profil_pegawai['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'. $profil_pegawai['fotopeg'];
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
          <a style="color:#495057;" href="<?=base_url()?>kepegawaian/profil-pegawai/<?=$profil_pegawai['nipbaru_ws']?>" target="_blank">
            <span class="sp_profil">
            <?=getNamaPegawaiFull($profil_pegawai)?>
            </span>
          </a>
          </div>
          <div class="col-lg-12 text-center" >
            <span class="sp_profil">
              <?=formatNip($profil_pegawai['nipbaru_ws'])?>
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
              <?=($profil_pegawai['nm_unitkerja'])?>
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
                    <?=($profil_pegawai['nm_pangkat'])?>
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
                  <?=formatDateNamaBulan($profil_pegawai['tmtpangkat'])?>
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
                  <?=($profil_pegawai['nama_jabatan'])?>
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
                  <?=formatDateNamaBulan($profil_pegawai['tmtjabatan'])?>
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
                  <?=($profil_pegawai['nik'])?>
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
                  <?=($profil_pegawai['nm_agama'])?>
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
                  <?=($profil_pegawai['tptlahir'].', '.formatDateNamaBulan($profil_pegawai['tgllahir']))?>
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
                  <?=$profil_pegawai['jk'].' / '.countDiffDateLengkap(date('Y-m-d'), $profil_pegawai['tgllahir'], ['tahun', 'bulan'])?>
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
                <?=($profil_pegawai['alamat'])?>
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
                <?=($profil_pegawai['handphone'])?>
                </span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>



<h5 style="display: none;"  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <!-- <iframe style="display: none; width: 100vh; height: 80vh;" type="application/pdf"  id="view_file_verif_kgb"  frameborder="0" ></iframe>	 -->
            <iframe style="display: none; width: 100%;height: 90vh;" type="application/pdf"  id="view_file_verif_kgb"  frameborder="0" ></iframe>	
          </div>
			</div>
    
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
      <form method="post" id="form_verifikasi_layanan_kgb" enctype="multipart/form-data" >
        <input type="text" name="id_pegawai" id="id_pegawai" value="<?= $profil_pegawai['id_peg'];?>">
        <input type="tahun" name="tahun" id="tahun" value="<?= $tahun;?>">

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example" name="status" id="status">
        <option selected>--</option>
        <option value="1">ACC</option>
        <option value="0">TOLAK</option>
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
    
<?php if($result){ ?>
<!-- Modal -->
<div style="display:none" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="post" enctype="multipart/form-data" action="<?=base_url('kepegawaian/C_Kepegawaian/downloadDrafSKKgb')?>" target="_blank">
         <div class="form-group">
          <input type="hidden" class="form-control" id="id_pegawai" name="id_pegawai" value="<?=$profil_pegawai['id_peg']?>" readonly>
          <input type="hidden" class="form-control" id="nip" name="nip" value="<?=$profil_pegawai['nipbaru_ws']?>" readonly>
          <input type="hidden" class="form-control" id="id" name="id" value="<?=$result[0]['id'];?>" readonly>

          
          <label for="exampleInputEmail1">Nama Lengkap</label>
          <input type="text" class="form-control" id="" name="" value="<?=getNamaPegawaiFull($profil_pegawai)?>" readonly>
          </div> 
          <div class="form-group">
          <label for="exampleInputEmail1">NIP</label>
          <input type="text" class="form-control" id="" name="" readonly value="<?= $profil_pegawai['nipbaru_ws'];?>">
          </div> 
          <div class="form-group">
          <label for="exampleInputEmail1">Pangkat Gol/Ruang</label>
          <input type="text" class="form-control" id="" name="" value="<?=($profil_pegawai['nm_pangkat'])?>" readonly>
          <input type="hidden" class="form-control" id="edit_gb_pangkat" name="edit_gb_pangkat" value="<?=($profil_pegawai['pangkat'])?>" readonly>
          
        </div> 
        
          <div class="form-group">
          <label for="exampleInputEmail1">Nomor SK Pangkat</label>
          <input type="text" class="form-control" id="pangkat_nosk" name="pangkat_nosk" value="<?php 
                    $data = explode("|", $profil_pegawai['data_pangkat']);
                    echo $data[4];
                    ?>" readonly>
          </div> 
          <div class="form-group">
          <label for="exampleInputEmail1">TMT SK Pangkat</label>
          <input type="text" class="form-control" id="pangkat_tmt" name="pangkat_tmt" value="<?=$profil_pegawai['tmtpangkat'];?>" readonly>
          </div> 
          <div class="form-group">
          <label for="exampleInputEmail1">Masa Kerja</label>
          <input type="text" class="form-control" id="pangkat_mkg" name="pangkat_mkg" value="<?php 
                    $data = explode("|", $profil_pegawai['data_pangkat']);
                    echo $data[5];
                    ?>" readonly>
          </div>
          <div class="form-group">
          <label for="exampleInputEmail1">Pejabat</label>
          <input type="text" class="form-control" id="pangkat_pejabat" name="pangkat_pejabat" value="<?php 
                    $data = explode("|", $profil_pegawai['data_pangkat']);
                    echo $data[3];
                    ?>" >
          </div> 

          <!-- <div class="form-group">
          <label for="exampleInputEmail1">Golongan Awal</label>
          <input type="text" class="form-control" id="" name="" readonly>
          </div>  -->

          
         
         <div class="form-group">
          <label for="exampleInputEmail1">Gaji Pokok Lama</label>
          <input  type="text" class="form-control rupiah"  id="gajilama" name="gajilama" value="<?=$result[0]['gajilama'];?>" >
          </div>
          <div class="form-group">
          <label >Gaji Pokok Baru</label>
          <input type="text" class="form-control rupiah" id="gajibaru" name="gajibaru" value="<?=$result[0]['gajibaru'];?>">
          </div>
          <div class="form-group">
          <label >Masa Kerja PNS</label>
          <input type="text" class="form-control" id="edit_gb_masa_kerja" name="edit_gb_masa_kerja" value="<?=$result[0]['masakerja'];?>">
          </div>
          <div class="form-group">
          <label >TMT Gaji Berkala</label>
          <input type="text" class="form-control datepickerr"  id="edit_tmt_gaji_berkala" name="edit_tmt_gaji_berkala" value="<?php if($result[0]['tmtgajiberkala'] != "0000-00-00") echo $result[0]['tmtgajiberkala']; else echo "";?>">
          </div>
          <div class="form-group">
          <label >Nomor SK Gaji Berkala</label>
          <input type="text" class="form-control" id="edit_gb_no_sk" name="edit_gb_no_sk"  value="<?php if($result[0]['nosk'] != "") echo $result[0]['nosk']; else echo "800.1.11.13/BKPSDM/SK/xxxx/2025";?>">
        <!-- <div class="row">
            <div class="col-sm-4">
          <input type="text" class="form-control" id="" name=""  value="800.1.11.13/BKPSDM/SK/" readonly>
            </div>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="" name=""  value="<?php if($result[0]['nosk'] != "") echo $result[0]['nosk']; else echo "";?>">
            </div>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="" name=""  value="<?php if($result[0]['nosk'] != "") echo $result[0]['nosk']; else echo "";?>">
            </div> -->
        <!-- </div>  -->
        </div>
         
          <div class="form-group">
          <label >Tgl SK Gaji Berkala</label>
          <input type="text" class="form-control datepickerr"  id="edit_gb_tanggal_sk" name="edit_gb_tanggal_sk" value="<?php if($result[0]['tglsk'] != "0000-00-00") echo $result[0]['tglsk']; else echo "";?>">
          </div>
          <button type="submit" class="btn btn-sm btn-info float-right mt-2"><i class="fa fa-file-pdf"></i> Download</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<!-- Modal -->
<div class="modal fade" id="modalUploadSKKgb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="upload_sk_kgb_form" method="post" enctype="multipart/form-data">
         <div class="form-group">
          <input type="hidden" class="form-control" id="id_pegawai" name="id_pegawai" value="<?=$profil_pegawai['id_peg']?>" readonly>
          <input type="hidden" class="form-control" id="nip" name="nip" value="<?=$profil_pegawai['nipbaru_ws']?>" readonly>
          <input type="hidden" class="form-control" id="id_dokumen" name="id_dokumen" value="7" readonly>
          <input type="hidden" class="form-control" id="id_tkgb" name="id_tkgb" value="<?=$result[0]['id'];?>" readonly>

        
          <div class="form-group">
          <label >File SK</label>
          <input type="file" class="form-control"  id="pdf_file_berkala" name="file">
          </div>
          <button class="btn btn-primary float-right"  id=""><i class="fa fa-save"></i> SIMPAN</button>
        </form>
      </div>
    </div>
  </div>
</div>

		
<script>


var nip = "<?= $profil_pegawai['nipbaru_ws'];?>"; 

$(function(){
  // $( "#sidebar_toggle" ).trigger( "click" );
  
  $('.datepickerr').datepicker({
     format: 'yyyy-mm-dd',
    // viewMode: "years", 
    // minViewMode: "years",
    // orientation: 'bottom',
    autoclose: true
    });
    
  
  })


    $('.rupiah').on('keyup', function(){
        $(this).val(formatRupiah(this.value));
    });

 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

function openProfileTab(){
  $('#view_file_verif_kgb').hide()
}

function openPresensiTab(){
  $('#view_file_verif_kgb').hide()
  $('#pills-presensi').html('')
  $('#pills-presensi').append(divLoaderNavy)
  $('#pills-presensi').load('<?=base_url("kepegawaian/C_Kepegawaian/openPresensiTab/".$profil_pegawai['id_m_user'])?>', function(){
    $('#loader').hide()
  })
}

  
  async function getFile(file){
    
    $('#view_file_verif_kgb').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    $('#ket').html('');
   
    if(file == "skcpns" || file == "skpns"){
          dir = "arsipberkaspns/";
        } else if(file == "skpangkat"){
          dir = "arsipelektronik/";
        } else if(file == "skp1" || file == "skp2"){
          dir = "arsipskp/";
        } else if(file == "pak" || file == "ibel" || file == "sertiukom" || file == "forlap" || file== "stlud" || file== "uraiantugas" || file== "pmk" || file == "skjabterusmenerus" || file == "peta" || file == "akreditasi"){
          dir = "arsiplain/";
        } else if(file == "skkgb"){
          dir = "arsipgajiberkala/";
        } else if(file == "skjabatan"){
          dir = "arsipjabatan/";
        } else if(file == "suratpengantar"){
          dir = "./dokumen_layanan/pangkat/";
        }  else {
          dir = "uploads/";
        }

   var id_usul = null;
   var id_peg = "<?=$profil_pegawai['id_peg'];?>";
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
              var link = "<?=base_url();?>/"+dir+"/"+data[0].gambarsk+"?v="+number;
              console.log(link)
            $('#view_file_verif_kgb').attr('src', link)
           $('#view_file_verif_kgb').on('load', function(){
         $('.iframe_loader').hide()
         $('#view_file_verif_kgb').show()
       })
    // $('.iframe_loader').hide()  
    // $('#view_file_verif_kgb').attr('src', '')
    // $('#ket_file').html('Tidak ada data');
           
          } else {
            $('#view_file_verif_kgb').attr('src', '')
            $('#ket_file').html('Tidak ada data');
          }
        } else {
        // errortoast('tidak ada data')
        $('.iframe_loader').hide()  
        $('#view_file_verif_kgb').attr('src', '')
        $('#ket_file').html('Tidak ada data');
        }
        }
        });
 }



        $('#form_verifikasi_layanan_kgb').on('submit', function(e){
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
                url: '<?=base_url("kepegawaian/C_Kepegawaian/submitProsesKenaikanGajiBerkala")?>',
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


          function batalVerifProsesKgb(id_usul){
          
            if(confirm('Apakah Anda yakin ingin batal verifikasi?')){
            $.ajax({
                url: '<?=base_url("kepegawaian/C_Kepegawaian/batalVerifikasiProsesKgb")?>',
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

  async function openFileKgb(filename){

$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 1000);
$link = "<?=base_url();?>/arsipgjberkala/"+filename+"?v="+number;

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
                   if(status == 3){
                    var pesan = "kirim Data ke BKAD ?";
                   } else {
                    var pesan = "Batal kirim Data ke BKAD ?";
                   }
                   if(confirm(pesan)){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/kirimBkad/")?>'+id+'/'+status,
                           method: 'post',
                           data: null,
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

    $('#upload_sk_kgb_form').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#upload_sk_kgb_form');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('pdf_file_berkala').files.length;
       
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
                document.getElementById("upload_sk_kgb_form").reset();
                setTimeout(window.location.reload.bind(window.location), 1000);
                
                  
            //    $('#btn_upload_pangkat').html('Simpan')
               
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        }); 

               $("#pdf_file_berkala").change(function (e) {

                // var extension = pdf_file_berkala.value.split('.')[1];
                var doc = pdf_file_berkala.value.split('.')
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
