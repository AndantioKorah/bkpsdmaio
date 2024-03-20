<?php if($this->general_library->getRole() == 'programmer' || $this->general_library->isHakAkses('akses_profil_pegawai')) { ?>

<div class="card card-default">

	<div class="card-body div_form_tambah_interval" id="div_form_tambah_interval">
	<form method="post" id="form_jabatan" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Jenis Jabatan</label>
        <select class="form-select select2" name="jenis_jabatan" id="jenis_jabatan"  required>
        <option value=""  selected>Pilih Jenis Jabatan</option>
        <option <?php if($post) { if($post['jenis_jabatan'] == 2) echo "selected"; else echo "";}?> value="2">JPT</option>
        <option <?php if($post) { if($post['jenis_jabatan'] == 1) echo "selected"; else echo "";}?> value="1">Administrator</option>
      </select>
      </div>
      <div class="mb-3" style='<?php if($post) { if($post['jenis_jabatan'] == 1) echo ""; else echo "display:none";} else echo "display:none";?>' id="adm">
        <label for="exampleInputPassword1" class="form-label">Jabatan Target</label>
        <select class="form-select select2" name="jabatan_target_adm" id="jabatan_target_adm" >
                <!-- <option value=""  selected>Semua</option> -->
                    <?php if($jabatan_target_adm){ foreach($jabatan_target_adm as $r){ ?>
                     <option <?php if($jt_adm) { if($jt_adm == $r['id_jabatanpeg']) echo "selected"; else echo "";}?> value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
                </select>
      </div>
      
      <div class="mb-3" style='<?php if($post) { if($post['jenis_jabatan'] == 2) echo ""; else echo "display:none";} else echo "display:none";?>' id="jpt">
        <label for="exampleInputPassword1" class="form-label">Jabatan Target</label>
        <select class="form-select select2" name="jabatan_target_jpt" id="jabatan_target_jpt" >
                <!-- <option value=""  selected>Semua</option> -->
                    <?php if($jabatan_target_jpt){ foreach($jabatan_target_jpt as $r){ ?>
                     <option <?php if($jt_jpt) { if($jt_jpt == $r['id_jabatanpeg']) echo "selected"; else echo "";}?> value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
                </select>
      </div>

      <button type="submit" class="btn btn-primary float-right mb-2">Lihat</button>
    </form>
	</div>
</div>


<div class="card card-default">
	<div class="card-header">
		<div class="col-3">
			<h3 class="card-title"></h3>
		</div>
	</div>
	<div class="card-body" style="margin-top:-20px;">
		<div id="list_pegawai">

		</div>
	</div>
</div>

<?php } ?>

<script>

$(function(){          
    // loadChartNineBox()
    $(".select2").select2({   
		width: '100%',
		// dropdownAutoWidth: true,
		allowClear: true
	});
  })



 $('#jenis_jabatan').on('change', function() {
  if(this.value == 1) {
   $('#adm').show('fast')
   $('#jpt').hide()
  } else {
    $('#jpt').show('fast')
    $('#adm').hide()
  }
});


		function loadListSuksesor(tab = null) {

		var jenis_jabatan = $('#jenis_jabatan').val()
		var jabatan_target_jpt = $('#jabatan_target_jpt').val()
		var jabatan_target_adm = $('#jabatan_target_adm').val()
		
		$('#list_pegawai').html('')
		$('#list_pegawai').append(divLoaderNavy)
		$('#list_pegawai').load('<?=base_url("simata/C_Simata/loadListSuksesor/")?>' + jenis_jabatan +'/'+jabatan_target_jpt, function () {
			$('#loader').hide()
		})

		}

		$('#form_jabatan').on('submit', function (e) {
		e.preventDefault();
		var formvalue = $('#form_jabatan');
		var form_data = new FormData(formvalue[0]);
		loadListSuksesor()
		});



</script>
