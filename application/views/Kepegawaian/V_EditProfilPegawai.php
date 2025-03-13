
<style>
  input:read-only {
  background-color: #b4b9c5;
}
</style>
<form method="post" id="form_edit_profil" enctype="multipart/form-data" >
      <input type="hidden" name="edit_id_pegawai" id="edit_id_pegawai" value="<?=$profil_pegawai['id_peg']?>">
      
     
      <div class="row g-3 align-items-center" >
      <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

   

      <div class="col-lg-2" >
        <label for="inputPassword6" class="col-form-label">Nama Lengkap</label>
      </div>
      <div class="col-lg-2">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_gelar1" name="edit_gelar1" class="form-control" value="<?=$profil_pegawai['gelar1']?>">
      </div>
      <div class="col-lg-6">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?>   type="text" id="edit_nama" name="edit_nama" class="form-control" value="<?=$profil_pegawai['nama']?>">
      </div>
      <div class="col-lg-2">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_gelar2" name="edit_gelar2" class="form-control" value="<?=$profil_pegawai['gelar2']?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Lama </label>
      </div>
      <div class="col-lg-10">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="" value="<?=$profil_pegawai['niplama']?>" class="form-control">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Nip Baru </label>
      </div>
      <div class="col-lg-10">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_nip_baru" name="edit_nip_baru" class="form-control" value="<?=$profil_pegawai['nipbaru']?>">
      </div>

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?> >
      <label> Unit Kerja / SKPD  </label>
       
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <select   class="form-control select2 " data-dropdown-parent="#editProfileModal" data-dropdown-css-class="select2-navy" name="edit_unit_kerja" id="edit_unit_kerja" required>     
      <option value="" disabled selected>Pilih Unit Kerja</option>
                    <?php if($unit_kerja){ foreach($unit_kerja as $r){ ?>
                        <option <?php if($profil_pegawai['skpd'] == $r['id_unitkerja']) echo "selected"; else echo ""; ?>   value="<?=$r['id_unitkerja']?>"><?=$r['nm_unitkerja']?></option>
                    <?php } } ?>
    </select>
      </div>


      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Tempat / Tanggal Lahir </label>
      </div>
      <div class="col-lg-5">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_tptlahir" name="edit_tptlahir" class="form-control" value="<?=$profil_pegawai['tptlahir']?>">
      </div>
      <div class="col-lg-5">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_tgllahir" name="edit_tgllahir" class="form-control datepickeronly" value="<?=$profil_pegawai['tgllahir']?>">
      </div>

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Jenis Kelamin </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <div class="form-check form-check-inline">
      <input <?= $profil_pegawai['jk'] == 'Laki-Laki' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_jkelamin" id="inlineRadioL" value="Laki-Laki">
      <label class="form-check-label" for="inlineRadioL">Laki-laki</label>
      </div>
      <div class="form-check form-check-inline">
        <input <?= $profil_pegawai['jk'] == 'Perempuan' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_jkelamin" id="inlineRadioP" value="Perempuan">
        <label class="form-check-label" for="inlineRadioP">Perempuan</label>
      </div>
      </div>

      <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
      </div>
      <?php } ?>

      
  <input type="hidden" name="edit_id_m_user" id="edit_id_m_user" value="<?=$profil_pegawai['id_m_user'];?>">

  <?php if($profil_pegawai['id_unitkerjamaster'] == "8020000" || $profil_pegawai['id_unitkerjamaster'] == "6000000" || $profil_pegawai['id_unitkerjamaster'] == "8010000") {
    $style ="style='display:none'";
    // $style ="";
    $required ="";
  } else if($profil_pegawai['eselon'] == "II B" 
  // || $profil_pegawai['eselon'] == "III A"
  ) {
    $style ="style='display:none'";
    $required ="";
  } else {
    $style ="";
    $required ="required";
  }
  ?>
  <div class="col-lg-2" <?=$style;?>>
      <label> Bidang/Bagian  </label>
      </div>
      <div class="col-lg-10" <?=$style;?>>
      <select class="form-control select2"  data-dropdown-parent="#editProfileModal"  data-dropdown-css-class="select2-navy" name="edit_id_m_bidang" id="edit_id_m_bidang" <?=$style;?>>
                    <option value="" selected>Pilih Item</option>
                    <option <?php if($bidang['id_m_bidang'] == 0) echo "selected"; else echo ""; ?> value="0" >-</option>
                    <?php if($mbidang){ foreach($mbidang as $r){ ?>
                        <option <?php if($bidang['id_m_bidang'] == $r['id']) echo "selected"; else echo ""; ?>  value="<?=$r['id']?>"><?=$r['nama_bidang']?></option>
                    <?php } } ?>
    </select>
      </div>
     
      <div class="col-lg-2" <?=$style;?>>
      <label> Sub Bidang/Sub Bagian/Seksi </label>
      </div>
      <div class="col-lg-10" <?=$style;?>>
      <select class="form-control select2" data-dropdown-parent="#editProfileModal"  data-dropdown-css-class="select2-navy" name="edit_id_m_sub_bidang" id="edit_id_m_sub_bidang">
      <option value="<?=$profil_pegawai['id_m_sub_bidang'];?>"> <?=$profil_pegawai['nama_sub_bidang'];?></option>
    </select>
      </div>

      
      <div class="col-lg-2" >
        <label for="inputPassword6" class="col-form-label"> Golongan Darah </label>
      </div>
      <div class="col-lg-10">
      <div class="form-check form-check-inline">
      <input <?= $profil_pegawai['goldarah'] == 'A' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_goldar" id="inlineRadioA" value="A">
      <label class="form-check-label" for="inlineRadioA">A</label>
      </div>
      <div class="form-check form-check-inline">
        <input <?= $profil_pegawai['goldarah'] == 'B' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_goldar" id="inlineRadioB" value="B">
        <label class="form-check-label" for="inlineRadioB">B</label>
      </div>
      <div class="form-check form-check-inline">
      <input <?= $profil_pegawai['goldarah'] == 'O' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_goldar" id="inlineRadioO" value="O">
      <label class="form-check-label" for="inlineRadioO">O</label>
      </div>
      <div class="form-check form-check-inline">
        <input <?= $profil_pegawai['goldarah'] == 'AB' ? 'checked' : ''; ?>  class="form-check-input" type="radio" name="edit_goldar" id="inlineRadioAB" value="AB">
        <label class="form-check-label" for="inlineRadioAB">AB</label>
      </div>
      </div>

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "style='display:none;'"; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Alamat </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo "style='display:none;'"; else echo "style='display:none;'" ?>>
        <input type="text" id="edit_alamat" name="edit_alamat" class="form-control" value="<?= $profil_pegawai['alamat']?>">
      </div>

      
      <div class="col-lg-2">
      <label> Provinsi  </label>
      </div>
      <div class="col-lg-10">
      <input type="text" id="edit_provinsi" name="edit_provinsi" class="form-control"  placeholder="Sulawesi Utara" disabled>
      
      </div>
      

      <div class="col-lg-2">
      <label> Kabupaten/Kota  </label>
      </div>
      <div class="col-lg-10">
      <select  class="form-control select2" data-dropdown-parent="#editProfileModal"  data-dropdown-css-class="select2-navy" name="edit_kab_kota" id="edit_kab_kota" >     
      <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                    <?php if($kabkota){ foreach($kabkota as $r){ ?>
                        <option <?php if($profil_pegawai['id_m_kabupaten_kota'] == $r['id']) echo "selected"; else echo ""; ?>   value="<?=$r['id']?>"><?=$r['nama_kabupaten_kota']?></option>
                    <?php } } ?>
    </select>
      </div>
     
      <div class="col-lg-2">
      <label> Kecamatan   </label>
      </div>
      <div class="col-lg-10">
      <select  class="form-control select2 kecamatan" data-dropdown-parent="#editProfileModal"  data-dropdown-css-class="select2-navy"  name="edit_kecamatan" id="edit_kecamatan" >     
    <option value="<?=$profil_pegawai['id_m_kecamatan'];?>"> <?=$profil_pegawai['nama_kecamatan'];?></option>
    </select>
      </div>

      <div class="col-lg-2">
      <label> Kelurahan  </label>
      </div>
      <div class="col-lg-10">
      <select  class="form-control select2 kelurahan" data-dropdown-parent="#editProfileModal"  data-dropdown-css-class="select2-navy" name="edit_kelurahan" id="edit_kelurahan" >     
      <option value="<?=$profil_pegawai['id_m_kelurahan'];?>"> <?=$profil_pegawai['nama_kelurahan'];?></option>
    </select>
      </div>

      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Agama </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control" data-dropdown-css-class="" name="edit_agama" id="edit_agama" required>
                    <option value="" disabled selected>Pilih Agama</option>
                    <?php if($agama){ foreach($agama as $r){ ?>
                        <option <?php if($profil_pegawai['id_agama'] == $r['id_agama']) echo "selected"; else echo ""; ?>   value="<?=$r['id_agama']?>"><?=$r['nm_agama']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Status Perkawinan </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control" data-dropdown-css-class="" name="edit_status_kawin" id="edit_status_kawin" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <?php if($status_kawin){ foreach($status_kawin as $r){ ?>
                        <option <?php if($profil_pegawai['id_sk'] == $r['id_sk']) echo "selected"; else echo ""; ?>   value="<?=$r['id_sk']?>"><?=$r['nm_sk']?></option>
                    <?php } } ?>
    </select>
      </div> 

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Status Kepegawaian </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <select class="form-control" data-dropdown-css-class="" name="edit_status_pegawai" id="edit_status_pegawai" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <?php if($status_pegawai){ foreach($status_pegawai as $r){ ?>
                        <option <?php if($profil_pegawai['id_statuspeg'] == $r['id_statuspeg']) echo "selected"; else echo ""; ?>   value="<?=$r['id_statuspeg']?>"><?=$r['nm_statuspeg']?></option>
                    <?php } } ?>
    </select>
      </div> 

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Jenis Kepegawaian </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <select class="form-control" data-dropdown-css-class="" name="edit_jenis_pegawai" id="edit_jenis_pegawai" required>
                    <option value="" disabled selected>Pilih Jenis Pegawai</option>
                    <?php if($jenis_pegawai){ foreach($jenis_pegawai as $r){ ?>
                        <option <?php if($profil_pegawai['id_jenispeg'] == $r['id_jenispeg']) echo "selected"; else echo ""; ?>   value="<?=$r['id_jenispeg']?>"><?=$r['nm_jenispeg']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Jenis Jabatan </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <select class="form-control" data-dropdown-css-class="" name="edit_jenis_jabatan" id="edit_jenis_jabatan" required>
                    <option value="" disabled selected>Pilih Jenis Jabatan</option>
                    <?php if($jenis_jabatan){ foreach($jenis_jabatan as $r){ ?>
                        <option <?php if($profil_pegawai['id_jenisjab'] == $r['id_jenisjab']) echo "selected"; else echo ""; ?>   value="<?=$r['id_jenisjab']?>"><?=$r['nm_jenisjab']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Status Jabatan </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:none;'" ?>>
      <select class="form-control" data-dropdown-css-class="" name="edit_status_jabatan" id="edit_status_jabatan" required>
                    <option value="" disabled selected>Pilih Jenis Jabatan</option>
                    <?php if($status_jabatan){ foreach($status_jabatan as $r){ ?>
                        <option <?php if($profil_pegawai['id_statusjabatan'] == $r['id_statusjabatan']) echo "selected"; else echo ""; ?>   value="<?=$r['id_statusjabatan']?>"><?=$r['nm_statusjabatan']?></option>
                    <?php } } ?>
    </select>
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Pangkat/ Gol. Ruang </label>
      </div>
      <div class="col-lg-10">
      <select class="form-control select2" data-dropdown-css-class="" name="edit_pangkat" id="edit_pangkat" required>
                    <option value="" disabled selected>Pilih Pangkat</option>
                    <?php if($pangkat){ foreach($pangkat as $r){ ?>
                        <option <?php if($profil_pegawai['id_pangkat'] == $r['id_pangkat']) echo "selected"; else echo ""; ?>   value="<?=$r['id_pangkat']?>"><?=$r['nm_pangkat']?></option>
                    <?php } } ?>
      </select>
      </div>

      <!-- <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Pangkat </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_tmt_pangkat" name="edit_tmt_pangkat" class="form-control datepickeronly"  value="<?= $profil_pegawai['tmtpangkat'];?>">
      </div>

       -->

      <!-- <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Gaji Berkala </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_tmt_gjberkala" name="edit_tmt_gjberkala" class="form-control datepickeronly" value="<?= $profil_pegawai['tmtgjberkala'];?>">
      </div> -->

      <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
   <div style="display:none">
   <?php } ?>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT CPNS </label>
      </div>
      <div class="col-lg-10">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_tmt_cpns" name="edit_tmt_cpns" class="form-control datepicker" value="<?= $profil_pegawai['tmtcpns'];?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> TMT Gaji Berkala </label>
      </div>
      <div class="col-lg-10">
        <input <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "readonly" ?> type="text" id="edit_tmt_berkala" name="edit_tmt_berkala" class="form-control datepicker" value="<?= $profil_pegawai['tmtgjberkala'];?>">
      </div>

      <?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>       
      </div>
   <?php } ?>


      <div class="col-lg-2" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:nonex;'" ?>>
        <label for="inputPassword6" class="col-form-label"> Pendidikan Terakhir </label>
      </div>
      <div class="col-lg-10" <?php  if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()) echo ""; else echo "style='display:nonex;'" ?>>
      <select class="form-control" data-dropdown-css-class="" name="edit_pendidikan" id="edit_pendidikan" required>
                    <option value="" disabled selected>Pilih Pendidikan</option>
                    <?php if($pendidikan){ foreach($pendidikan as $r){ ?>
                        <option <?php if($profil_pegawai['id_tktpendidikan'] == $r['id_tktpendidikan']) echo "selected"; else echo ""; ?>   value="<?=$r['id_tktpendidikan']?>"><?=$r['nm_tktpendidikan']?></option>
                    <?php } } ?>
    </select>
      </div>

      
      <!-- <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Diklat Struktural </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="" class="form-control" >
      </div> -->

      
      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> NIK </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_nik" name="edit_nik" class="form-control" value="<?= $profil_pegawai['nik'];?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> No Seri Karpeg </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_karpeg" name="edit_karpeg" class="form-control" value="<?= $profil_pegawai['karpeg'];?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> No Seri Taspen </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_taspen" name="edit_taspen" class="form-control" value="<?= $profil_pegawai['taspen'];?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> No Handphone </label>
      </div>
      <div class="col-lg-10">
        <input type="number" id="edit_no_hp" name="edit_no_hp" class="form-control" value="<?= $profil_pegawai['handphone'];?>">
      </div>

      <div class="col-lg-2">
        <label for="inputPassword6" class="col-form-label"> Email </label>
      </div>
      <div class="col-lg-10">
        <input type="text" id="edit_email" name="edit_email" class="form-control" value="<?= $profil_pegawai['email'];?>">
      </div>

      <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
        <div class="col-lg-2">
          <label for="inputPassword6" class="col-form-label"> Status Pegawai </label>
        </div>
        <div class="col-lg-10">
          <select class="form-control" name="edit_id_m_status_pegawai" id="id_m_status_pegawai">
            <?php foreach($list_status_pegawai as $lsp){ ?>
              <option value="<?=$lsp['id']?>" <?=$lsp['id'] == $profil_pegawai['id_m_status_pegawai'] ? 'selected' : ''?>><?=$lsp['nama_status_pegawai']?></option>
            <?php } ?>
          </select>
        </div>

        <div class="col-lg-2">
          <label for="inputPassword6" class="col-form-label"> Terima TPP </label>
        </div>
        <div class="col-lg-10">
          <select class="form-control" name="edit_flag_terima_tpp" id="flag_terima_tpp">
              <option value="0" <?=$profil_pegawai['flag_terima_tpp'] == 0 ? 'selected' : ''?>>TIDAK</option>
              <option value="1" <?=$profil_pegawai['flag_terima_tpp'] == 1 ? 'selected' : ''?>>YA</option>
          </select>
        </div>
      <?php } ?>
         
    </div>
   
      <!-- <button type="submit" class="btn btn-primary float-right">Submit</button> -->
      <button class="btn btn-block btn-primary float-right"><i class="fa fa-save"></i> SIMPAN</button>
    </form>

    
<script type="text/javascript">

$(function(){
   

$(".select2").select2({   
     width: '100%',
     dropdownAutoWidth: true,
     allowClear: true,
 });

 $('#datatable').dataTable()
     loadListPangkat()
 })

 $('#form_edit_profil').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_edit_profil');
        var form_data = new FormData(formvalue[0]);

        // if (!$("input[name='edit_goldar']:checked").val()) {
        //     alert('Silahkan Pilih Golongan Darah!');
        //       return false;
        // }

      

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditProfil")?>",
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
                // document.getElementById("form_edit_profil").reset();
                // loadListPangkat()
                location.reload()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });
    

         // Kecamatan
     $("#edit_kab_kota").change(function() {
      var id = $("#edit_kab_kota").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatakec",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_kecamatan+'</option>';
                      }
                      $('.kecamatan').html(html);
                          }
                  });
  });

        // Kelurahan 
      $("#edit_kecamatan").change(function() {
      var id = $("#edit_kecamatan").val();
      $.ajax({
             url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getdatakel",
             method : "POST",
             data : {id: id},
             async : false,
             dataType : 'json',
                          success: function(data){
                                  var html = '';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_kelurahan+'</option>';
                      }
                      $('.kelurahan').html(html);
                          }
                  });
      });

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
          // viewMode: "years", 
          // minViewMode: "years",
          // orientation: 'bottom',
          autoclose: true
      });


      $("#edit_id_m_bidang").change(function() {
      var id = $("#edit_id_m_bidang").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getMasterSubBidang",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '<option value=>-</option>';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_sub_bidang+'</option>';
                      }
                      $('#edit_id_m_sub_bidang').html(html);
                          }
                  });
  });

    
</script>