

<style>
    .form-control{
		height:35px !important;
		margin-bottom:10px !important;
    }
</style>

<div class="container-fluid p-0">

<div class="col-md-12" >
					<!-- <span class="headerSection">Surat Pengantar</span> -->

          <div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">

<form method="post" id="form_profil" enctype="multipart/form-data" >

      <div class="row g-3 align-items-center">
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label">Nama Lengkap</label>
      </div>
      <div class="col-lg-2">
        <input type="text" id="gelar1" name="gelar1" class="form-control" >
      </div>
      <div class="col-lg-6">
        <input type="text" id="nama" name="nama" class="form-control" required>
      </div>
      <div class="col-lg-2">
        <input type="text" id="gelar2" name="gelar2" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Lama </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="niplama" name="niplama" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Baru </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="nipbaru" name="nipbaru" class="form-control" required>
      </div>



      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Tempat / Tanggal Lahir </label>
      </div>
      <div class="col-lg-5">
        <input type="text" id="tptlahir" name="tptlahir" class="form-control " required>
      </div>
      <div class="col-lg-5">
        <input type="text" id="tgllahir" name="tgllahir" class="form-control datepickeronly" required>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Kelamin </label>
      </div>
      <div class="col-lg-10">
      <div class="form-check form-check-inline">
      <input  class="form-check-input" type="radio" name="jk" id="inlineRadioL" value="Laki-Laki">
      <label class="form-check-label" for="inlineRadioL">Laki-laki</label>
      </div>
      <div class="form-check form-check-inline">
        <input  class="form-check-input" type="radio" name="jk" id="inlineRadioP" value="Perempuan">
        <label class="form-check-label" for="inlineRadioP">Perempuan</label>
      </div>
      </div>
      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Golongan Darah </label>
      </div>
      <div class="col-lg-10">
      <div class="form-check form-check-inline">
      <input   class="form-check-input" type="radio" name="goldarah" id="inlineRadioA" value="A">
      <label class="form-check-label" for="inlineRadioA">A</label>
      </div>
      <div class="form-check form-check-inline">
        <input   class="form-check-input" type="radio" name="goldarah" id="inlineRadioB" value="B">
        <label class="form-check-label" for="inlineRadioB">B</label>
      </div>
      <div class="form-check form-check-inline">
      <input   class="form-check-input" type="radio" name="goldarah" id="inlineRadioO" value="O">
      <label class="form-check-label" for="inlineRadioO">O</label>
      </div>
      <div class="form-check form-check-inline">
        <input  class="form-check-input" type="radio" name="goldarah" id="inlineRadioAB" value="AB">
        <label class="form-check-label" for="inlineRadioAB">AB</label>
      </div>
      </div>
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Alamat </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="alamat" name="alamat" class="form-control" required>
      </div>

    
      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Agama </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="agama" id="agama" required>
                    <option value="" disabled selected>Pilih Agama</option>
                    <?php if($agama){ foreach($agama as $r){ ?>
                        <option   value="<?=$r['id_agama']?>"><?=$r['nm_agama']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Perkawinan </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="status" id="status" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <?php if($status_kawin){ foreach($status_kawin as $r){ ?>
                        <option   value="<?=$r['id_sk']?>"><?=$r['nm_sk']?></option>
                    <?php } } ?>
    </select>
      </div> 

    
      <div class="col-lg-2">
      <label> Unit Kerja / SKPD  </label>
       
      </div>
      <div class="col-lg-10">
      <select class="form-control select2"  data-dropdown-css-class="select2-navy" name="skpd" id="skpd" required>
                    <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>
      </div>


      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Kepegawaian </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="statuspeg" id="statuspeg" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <?php if($status_pegawai){ foreach($status_pegawai as $r){ ?>
                        <option value="<?=$r['id_statuspeg']?>"><?=$r['nm_statuspeg']?></option>
                    <?php } } ?>
    </select>
      </div> 

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Kepegawaian </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="jenispeg" id="jenispeg" required>
                    <option value="" disabled selected>Pilih Jenis Pegawai</option>
                    <?php if($jenis_pegawai){ foreach($jenis_pegawai as $r){ ?>
                        <option  value="<?=$r['id_jenispeg']?>"><?=$r['nm_jenispeg']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Jenis Jabatan </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="jenisjabpeg" id="jenisjabpeg" required>
                    <option value="" disabled selected>Pilih Jenis Jabatan</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option  value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Jabatan </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="statusjabatan" id="statusjabatan" required>
                    <option value="" disabled selected>Pilih Status Jabatan</option>
                    <?php if($status_jabatan){ foreach($status_jabatan as $r){ ?>
                        <option   value="<?=$r['id_statusjabatan']?>"><?=$r['nm_statusjabatan']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Pangkat </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="pangkat" id="pangkat" required>
                    <option value="" disabled selected>Pilih Pangkat</option>
                    <?php if($pangkat){ foreach($pangkat as $r){ ?>
                        <option   value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Pangkat </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="tmtpangkat" name="tmtpangkat" class="form-control datepickeronly" required>
      </div>

      

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Gaji Berkala </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="tmtgjberkala" name="tmtgjberkala" class="form-control datepickeronly">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT CPNS </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="tmtcpns" name="tmtcpns" class="form-control datepickeronly" required>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Pendidikan Terakhir </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="pendidikan" id="pendidikan" required>
                    <option value="" disabled selected>Pilih Pendidikan</option>
                    <?php if($pendidikan){ foreach($pendidikan as $r){ ?>
                        <option value="<?=$r['id_tktpendidikan']?>"><?=$r['nm_tktpendidikan']?></option>
                    <?php } } ?>
    </select>
      </div>

  
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> NIK </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="nik" name="nik" class="form-control" >
      </div>


      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> No Seri Taspen </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="taspen" name="taspen" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> No Handphone </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="handphone" name="handphone" class="form-control" >
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Email </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="email" name="email" class="form-control" >
      </div>

         
    </div>
   
      <button class="btn btn-block btn-primary float-right"><i class="fa fa-save"></i> SIMPAN</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        $(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});

    $('.datepickeronly').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
        });
  
});


$('#form_profil').on('submit', function(e){

  var base_url = "<?= base_url();?>"
     
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Kepegawaian/tambahPegawai")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(res){
             
            var result = JSON.parse(res); 
            console.log(result.nip)
            if(result.success == true){
                successtoast(result.msg)
                location.href = base_url+"kepegawaian/profil-pegawai/"+result.nip;
              } else {
                errortoast(result.msg)
                return false;
              } 
            // document.getElementById("form_profil").reset();
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    </script>

