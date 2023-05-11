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
</style>



<div class="container-fluid pt-2" style="background-color:#fff;">
	<div class="row" style="background-color:#fff;">
		<div class="col-12">
   <div class="12">
   <a href="<?= base_url('kepegawaian/teknis');?>">
    <button  class="btn btn-primary nav-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
  </a>
  <div class="row pt-2">
      <div class="col-lg-6 text-left">
        <span style="color: grey; font-size .8rem; font-style: italic;">Nama</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=getNamaPegawaiFull($result[0])?></span>
      </div>
      <div class="col-lg-6 text-right">
        <span style="color: grey; font-size .8rem; font-style: italic;">NIP</span><br>
        <span style="font-size: 1rem; font-weight: bold;"><?=$result[0]['nip'];?></span>
      </div>
      <div class="col-lg-12"><hr></div>
    </div>
  <?php if($jenis_layanan == 3) { ?>
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
        <?php } ?>
   </div>


			<div class="row">
				<div class="col-md-6" style="border-right: 5px solid black;">
					<!-- <span class="headerSection">Surat Pengantar</span> -->
  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <li class="nav-item nav-item-layanan " role="presentation">
    <button class="nav-link nav-link-layanan active"  data-bs-toggle="pill" type="button" role="tab"  aria-selected="true">File Pengantar</button>
  </li>
  </ul>
      <hr style="margin-top: 10px;">
      
					<iframe id="" style="width: 100%; height: 80vh;"
						src="<?=base_url();?>dokumen_layanan/<?= $result['0']['nama_layanan'];?>/<?= $result['0']['nip'];?>/<?= $result['0']['file_pengantar'];?>"></iframe>

				</div>
				<div class="col-md-6" >
  
<!-- upload dokumen  -->

<style>
  .nav-link{
    font-size: 12px;
    padding: 8px 22px;
  }
</style>

  <ul class="nav nav-pills pt-2" id="pills-tab" role="tablist">
  <?php if (in_array($result[0]['jenis_layanan'], $pangkat)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='pangkat')" class="nav-link nav-link-layanan" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pangkat</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $gaji_berkala)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button  onclick="loadFormGajiBerkala()" class="nav-link nav-link-layanan" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Gaji Berkala</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $pendidikan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormPendidikan()" class="nav-link nav-link-layanan" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Pendidikan</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $jabatan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="getFile(file='jabatan')" class="nav-link nav-link-layanan" id="pills-jabatan-tab" data-bs-toggle="pill" data-bs-target="#pills-jabatan" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jabatan</button>
  </li>
  <?php } ?>

 <?php if (in_array($result[0]['jenis_layanan'], $diklat)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormDiklat()" class="nav-link nav-link-layanan" id="pills-diklat-tab" data-bs-toggle="pill" data-bs-target="#pills-diklat" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Diklat</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $organisasi)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormOrganisasi()" class="nav-link nav-link-layanan" id="pills-organisasi-tab" data-bs-toggle="pill" data-bs-target="#pills-organisasi" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Organisasi</button>
  </li>
  <?php } ?>

  <?php if (in_array($result[0]['jenis_layanan'], $penghargaan)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button onclick="loadFormPenghargaan()" class="nav-link nav-link-layanan" id="pills-penghargaan-tab" data-bs-toggle="pill" data-bs-target="#pills-penghargaan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Penghargaan</button>
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

  <?php if (in_array($result[0]['jenis_layanan'], $arsip)) { ?>
  <li class="nav-item nav-item-layanan" role="presentation">
    <button class="nav-link nav-link-layanan" id="pills-cuti-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip Lainnya</button>
  </li>
  <?php } ?>

</ul>
<hr style="margin-top: 10px;">
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <div id="form_pangkat" style="margin-left:10px;"></div>
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
  <div class="tab-pane fade" id="pills-sj" role="tabpanel" aria-labelledby="pills-sj-tab">...</div>
  <div class="tab-pane fade" id="pills-keluarga" role="tabpanel" aria-labelledby="pills-keluarga-tab">...</div>
  <div class="tab-pane fade" id="pills-penugasan" role="tabpanel" aria-labelledby="pills-penugasan-tab">...</div>
  <div class="tab-pane fade" id="pills-cuti" role="tabpanel" aria-labelledby="pills-cuti-tab">...</div>
  <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab">...</div>
</div>
<span id="ket"></span>
<div id="divloader" class="col-lg-12 text-center">
</div>
<iframe id="view_file_verif" style="width: 100%; height: 80vh;"></iframe>

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


  function getFile(file) {
        $('#divloader').append(divLoaderNavy)
        $('#view_file_verif').attr('src','');
        var jenis_layanan = "<?=$result[0]['jenis_layanan'];?>";
        var id_peg = "<?=$result[0]['id_peg'];?>";
        var base_url = "<?= base_url();?>";

        if(file == "pangkat"){
          dir = "arsipelektronik/";
        } else if(file == "jabatan"){
          dir = "arsipjabatan/";
        } else {
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
            $('#view_file_verif').attr('src', base_url+dir+data[0].gambarsk)
          // $('#tes').val(base_url+'uploads/'+nip+'/'+data[0].gambarsk)
          $('#ket').html('');
          } else {
            $('#view_file_verif').attr('src', '')
            $('#ket').html('Tidak ada data');
          }
        } else {
        // errortoast('tidak ada data')
        $('#view_file_verif').attr('src', '')
        $('#ket').html('Tidak ada data');
        }
        }
        });
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

function loadFormPendidikan(){
 $('#form_gaji_berkala').html(' ')
   $('#form_pendidikan').append(divLoaderNavy)
   $('#form_pendidikan').load('<?=base_url('kepegawaian/C_Kepegawaian/LoadFormPendidikan/')?>', function(){
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
