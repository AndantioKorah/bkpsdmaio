<style>.label-filter {
	color: #434242;
	font-weight: bold;
	font-size: 15px;
}

.filter-option {
	overflow: auto;
	white-space: nowrap;
	padding-bottom: 5px;
	padding-top: 5px;
}

.filter-btn {
	display: inline-block;
	text-align: center;
	padding: 5px;
	/* border-radius: 5px; */
	margin-right: 3px;
	transition: .2s;
}

.filter-unselect {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #ea5454; */
	position: relative;
	background-color: #fa8072;
	box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025);
	transition: 0.5s ease-in-out;
	/* border: 3px solid #0a7129; */
	color: #fff;
}

/* .filter-unselect:hover{
        cursor: pointer;
        background-color: #43556b;
        color: white;
    } */

.filter-select {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #0a7129; */
	position: relative;
	background-color: #0ed095;
	/* box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025); */
	/* transition: 0.5s ease-in-out; */
	/* border: 3px solid #0a7129; */
	color: #fff;
}

.filter-warning {
	/* border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #0a7129; */
	position: relative;
	background-color:rgb(239, 255, 8);
	/* box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025); */
	/* transition: 0.5s ease-in-out; */
	/* border: 3px solid #0a7129; */
	color: #fff;
}

/* .filter-select:hover{
        cursor: pointer;
        background-color: #222e3c;
        color: white;
    } */

.list-type1 {
	width: 100%;
	margin: 0 auto;
	margin-bottom: -30px;
}

.list-type1 ol {
	counter-reset: li;
	list-style: none;
	*list-style: decimal;
	font-size: 15px;
	font-family: 'Raleway', sans-serif;
	padding: 0;
	margin-bottom: 4em;

}

.list-type1 ol ol {
	margin: 0 0 0 2em;
}

.list-type1 .select {
	position: relative;
	display: block;
	color: #fff;
	padding: .4em .4em .4em 2em;
	*padding: .4em;
	margin: .5em 0;
	background: #0ed095;
	color: #fff;
	text-decoration: none;
	-moz-border-radius: .3em;
	-webkit-border-radius: .3em;
	/* border-radius: 10em; */
	transition: all .2s ease-in-out;
}

.list-type1 .unselect {
	position: relative;
	display: block;
	color: #fff;
	padding: .4em .4em .4em 2em;
	*padding: .4em;
	margin: .5em 0;
	background: #ea5454;
	color: #fff;
	text-decoration: none;
	-moz-border-radius: .3em;
	-webkit-border-radius: .3em;
	/* border-radius: 10em; */
	transition: all .2s ease-in-out;
}

.list-type1 a:hover {
	color: #000;
	background: #d6d4d4;
	text-decoration: none;
	transform: scale(1.01);
	border: 2px solid #000;
}

ol {
    counter-reset: li; /* Initiate a counter */
    list-style: none; /* Remove default numbering */
    *list-style: decimal; /* Keep using default numbering for IE6/7 */
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
	margin-bottom: 10px;

  }

  ol ol {
    margin: 0 0 0 2em; /* Add some left margin for inner lists */
  }

  .rectangle-list .select{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    background: #ddd;
    color: #444;
    text-decoration: none;
    transition: all .3s ease-out;
  }

  .rectangle-list .warning{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    background: #ddd;
    color: #444;
    text-decoration: none;
    transition: all .3s ease-out;
  }

  .rectangle-list .unselect{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    background: #ddd;
    color: #444;
    text-decoration: none;
    transition: all .3s ease-out;
  }

  .rectangle-list a:hover{
    background: #eee;
  }

  .rectangle-list .select:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background: #0ed095;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
  }

  .rectangle-list .unselect:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background: #fa8072;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
  }

  .rectangle-list .warning:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background-color:rgb(239, 255, 8);
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
  }

  .rectangle-list a:after{
    position: absolute;
    content: '';
    border: .5em solid transparent;
    left: -1em;
    top: 50%;
    margin-top: -.5em;
    transition: all .3s ease-out;
  }

  .rectangle-list .select:hover:after{
    left: -.5em;
    border-left-color: #0ed095;
  }

  .rectangle-list .warning:hover:after{
    left: -.5em;
    border-left-color:rgb(187, 255, 14);
  }

  .rectangle-list .unselect:hover:after{
    left: -.5em;
    border-left-color: #fa8072;
  }
</style>

<div class="row">

	<div class="col-lg-12 mt-3">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<div class="card-title">
						<h5>RIWAYAT LAYANAN <?= strtoupper($nm_layanan);?></h5>
					</div>
					<hr>
				</div>
			</div>
			<div class="card-body">
				<div class="row" style="margin-top: -40px;">
					<div class="col-lg-12 table-responsive" id="list_riwayat_karsu"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-12">
	<div class="card card-default">
		<div class="card-header">
			<div class="card-title">
				<h5>FORM LAYANAN <?= strtoupper($nm_layanan);?></h5>
			</div>
			<hr>
		</div>

		<div class="card-body">

			<form id="form_ujian_dinas" method="post" enctype="multipart/form-data" id="form_cuti"
				style="margin-top: -45px;">
				
				<input type="hidden" id="sk_cpns" value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
				<input type="hidden" id="sk_pns" value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
				<input type="hidden" id="sk_pangkat" value="<?php if($sk_pangkat) echo $sk_pangkat['id']; else echo "";?>">
				<input type="hidden" id="ijazah" value="<?php if($ijazah) echo $ijazah['id']; else echo "";?>">
				<input type="hidden" id="sk_jabatan" value="<?php if($sk_jabatan) echo $sk_jabatan['id']; else echo "";?>">
				<input type="hidden" id="ijazah_s_penyesuaian" value="<?php if($ijazah_s_penyesuaian) echo $ijazah_s_penyesuaian['id']; else echo "";?>">
				<input type="hidden" id="ijazah_penyesuaian" value="<?php if($ijazah_penyesuaian) echo $ijazah_penyesuaian['id']; else echo "";?>">
				<input type="hidden" id="ibel" value="<?php if($ibel) echo $ibel['id']; else echo "";?>">
				<input type="hidden" id="skp1" value="<?php if($skp1) echo $skp1['id']; else echo "";?>">
				<input type="hidden" id="karya_tulis" value="<?php if($karya_tulis) echo $karya_tulis['id']; else echo "";?>">
				
				<span><b>Berkas Persyaratan :</b></span>
				<div class="list-type1x mt-2">
					<div class="form-group">
						<label>Surat Pengantar dari Kepala Perangkat Daerah </label>
						<input class="form-control my-image-field" type="file" id="pdf_surat_pengantar" name="file"
							required />
						<!-- <input class="form-control" type="file" id="surat_pengantar" name="surat_pengantar" autocomplete="off"  /> -->
					</div>
					<ol class="rectangle-list">
						<li>
							<a class="<?php if($sk_cpns){ if($sk_cpns['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($sk_cpns) { ?> onclick="viewBerkasPangkat('<?=$sk_cpns['gambarsk'];?>',1)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> SK CPNS* <i
									class="fas fa-<?php if($sk_cpns) echo ''; else echo '';?>"></i></a>
						</li>
						<li>
							<a class="<?php if($sk_pns){ if($sk_pns['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($sk_pns) { ?> onclick="viewBerkasPangkat('<?=$sk_pns['gambarsk'];?>',1)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> SK PNS* <i
									class="fas fa-<?php if($sk_pns) echo ''; else echo '';?>"></i></a>
						</li>
						<li>
							<a class="<?php if($sk_pangkat){ if($sk_pangkat['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($sk_pangkat) { ?>
								onclick="viewBerkasPangkat('<?=$sk_pangkat['gambarsk'];?>',2)" data-toggle="modal"
								data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i> SK Pangkat Akhir*
								<i class="fas fa-<?php if($sk_pangkat) echo ''; else echo '';?>"></i></a>
						</li>
						<li>
							<a class="<?php if($skp1){ if($skp1['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($skp1) { ?> onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',3)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> SKP Tahun <?=$tahun_1_lalu;?>* <i
									class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
						</li>

						<?php if($id_m_layanan == 18 || $id_m_layanan == 19) { ?>
						<li>
							<a class="<?php if($ijazah){ if($ijazah['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($ijazah) { ?> onclick="viewBerkasPangkat('<?=$ijazah['gambarsk'];?>',3)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Ijazah Terakhir* <i
									class="fas fa-<?php if($ijazah) echo ''; else echo '';?>"></i></a>
						</li>
						<?php } ?>
						<?php if($id_m_layanan == 19) { ?>
                            <li>
							<a class="<?php if($sk_jabatan){ if($sk_jabatan['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($sk_jabatan) { ?> onclick="viewBerkasPangkat('<?=$sk_jabatan['gambarsk'];?>',5)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> SK Jabatan* <i
									class="fas fa-<?php if($sk_jabatan) echo ''; else echo '';?>"></i></a>
						</li>
                        <li>
							<a class="<?php if($karya_tulis){ if($karya_tulis['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($karya_tulis) { ?> onclick="viewBerkasPangkat('<?=$karya_tulis['gambarsk'];?>',6)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Karya Tulis tentang Tugas Pokok* <i
									class="fas fa-<?php if($karya_tulis) echo ''; else echo '';?>"></i></a>
						</li>
                        <?php } ?>
                        <?php if($id_m_layanan == 20) { ?>
                        
                        <li>
							<a class="<?php if($ijazah_s_penyesuaian){ if($ijazah_s_penyesuaian['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($ijazah_s_penyesuaian) { ?> onclick="viewBerkasPangkat('<?=$ijazah_s_penyesuaian['gambarsk'];?>',7  )"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Ijazah Sebelum Penyesuaian / Transkrip Nilai* <i
									class="fas fa-<?php if($ijazah_s_penyesuaian) echo ''; else echo '';?>"></i></a>
						</li>
                        <li>
							<a class="<?php if($ijazah_penyesuaian){ if($ijazah_penyesuaian['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($ijazah_penyesuaian) { ?> onclick="viewBerkasPangkat('<?=$ijazah_penyesuaian['gambarsk'];?>',7)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Ijazah Penyesuaian/ Transkrip Nilai* <i
									class="fas fa-<?php if($ijazah_penyesuaian) echo ''; else echo '';?>"></i></a>
						</li>
                        <li>
							<a class="<?php if($ibel){ if($ibel['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($ibel) { ?> onclick="viewBerkasPangkat('<?=$ibel['gambarsk'];?>',6)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Surat Izin Belajar dan/atau Tugas Belajar Biaya Mandiri* <i
									class="fas fa-<?php if($ibel) echo ''; else echo '';?>"></i></a>
						</li>
                       
                        <li>
							<a class="<?php if($karya_tulis){ if($karya_tulis['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
								<?php if($karya_tulis) { ?> onclick="viewBerkasPangkat('<?=$karya_tulis['gambarsk'];?>',6)"
								data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i
									class="fa fa-file-pdf"></i> Karya Tulis tentang Tugas Pokok* <i
									class="fas fa-<?php if($karya_tulis) echo ''; else echo '';?>"></i></a>
						</li>
                        <?php } ?>

					</ol>
				</div>



				<!-- <button type="submit" class="btn btn-primary float-right ">Ajukan</button> -->
        <?php if($status_layanan['status'] == 1) { ;?>
					<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
          <?php } else { ?>
            <p>
              <h4>
            <b style="color:red;">
              Layanan Ujian Dinas dan Ujian Penyesuaian Kenaikan Pangkat sudah ditutup dan akan dibuka kembali pada periode berikutnya.<br>
            </b>
          </h4>
          </p>
          <?php }  ?>
			</form>
			<p class="mt-5">
				Keterangan :<br>
				<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
				Berkas Sudah diupload<br>
				<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2"> &nbsp;
				</button> Berkas belum diupload<br>
				<button style="width:3%" class="btn btn-sm filter-btn filter-warning mt-2"> &nbsp;
				</button> Menunggu Verifikasi BKPSDM<br><br>
				Berkas diupload Pada Menu Profil <br>
				<?php if($id_m_layanan == 10) { ?>
				Untuk Berkas : <br>
				<i class="fa fa-file-pdf"></i> <b>Ijazah Saat Melamar CPNS.</b>
				<br>Centang Ijazah yang dipakai melamar CPNS pada riwayat pendidikan dimenu Profil.
			</p>
			<?php } ?>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="">
				<h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i
						class="fa fa-spin fa-spinner"></i>
					LOADING...</h5>
				<iframe id="iframe_view_file_berkas_pns" style="width: 100%; height: 80vh;" src=""></iframe>
			</div>

		</div>
	</div>
</div>

<script>
var id_m_layanan = "<?=$id_m_layanan;?>"
$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  loadListRiwayatUjianDinas()
    })


    function viewBerkasPangkat(filename,id){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    var number = Math.floor(Math.random() * 1000);
    if(id == 1){
        $link = "<?=base_url();?>/arsipberkaspns/"+filename+"?v="+number;

    } else if(id == 2){
        $link = "<?=base_url();?>/arsipelektronik/"+filename+"?v="+number;

    } else if(id == 3){
        $link = "<?=base_url();?>/arsipskp/"+filename+"?v="+number;
    } else if(id == 4){
        $link = "<?=base_url();?>/arsipdiklat/"+filename+"?v="+number;
    } else if(id == 5){
        $link = "<?=base_url();?>/arsipjabatan/"+filename+"?v="+number;
    } else if(id == 6){
        $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
    } else if(id == 7){
        $link = "<?=base_url();?>/arsippendidikan/"+filename+"?v="+number;
    }
   
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  $('#form_ujian_dinas').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_ujian_dinas');
        var form_data = new FormData(formvalue[0]);
        var sk_cpns = $('#sk_cpns').val()
        var sk_pns = $('#sk_pns').val()
        var sk_pangkat = $('#sk_pangkat').val()
        var ijazah = $('#ijazah').val()
        var sk_jabatan = $('#sk_jabatan').val()
        var ijazah_s_penyesuaian = $('#ijazah_s_penyesuaian').val()
        var ijazah_penyesuaian = $('#ijazah_penyesuaian').val()
        var ibel = $('#ibel').val()
        var skp1 = $('#skp1').val()
        var karya_tulis = $('#karya_tulis').val()

        var id_m_layanan = "<?=$id_m_layanan;?>"

       
        if(sk_cpns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
        if(sk_pns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(sk_pangkat == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(skp1 == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(id_m_layanan == 18){
        if(sk_jabatan == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
       }

       if(id_m_layanan == 19){
        if(karya_tulis == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
       }
        
        

        if(id_m_layanan == 18 || id_m_layanan == 19){
        if(ijazah == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
       }

       if(id_m_layanan == 20){
        if(ijazah_s_penyesuaian == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(ijazah_penyesuaian == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(karya_tulis == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
       }


        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananNew/")?>"+id_m_layanan,
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            if(result.success == true){
                successtoast(result.msg)
                loadListRiwayatUjianDinas()
                window.scrollTo(0, 0);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });
   
function loadListRiwayatUjianDinas(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatLayanan/")?>'+id_m_layanan, function(){
      $('#loader').hide()
    })
    }

</script>