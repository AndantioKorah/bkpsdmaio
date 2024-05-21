<style>
.label-filter {
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
  .rectangle-list .unselect:hover:after{
    left: -.5em;
    border-left-color: #fa8072;
  }
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<h5>FORM LAYANAN PENSIUN <?=$nama_layanan;?>
          </h5>
				</div>
				<hr>
			</div>

			<div class="card-body">

				<form id="form_pensiun" method="post" enctype="multipart/form-data" id="" style="margin-top: -45px;">

        <input type="hidden" name="jenis_pensiun" id="jenis_pensiun" value="<?=$jenis_layanan;?>">

					<input type="hidden" id="sk_cpns" value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
					<input type="hidden" id="sk_pns" value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
					<input type="hidden" id="akte_nikah" value="<?php if($akte_nikah) echo $akte_nikah['id']; else echo "";?>">
					<input type="hidden" id="dpcp" value="<?php if($dpcp) echo $dpcp['id']; else echo "";?>">
					<input type="hidden" id="jandaduda" value="<?php if($dpcp) echo $dpcp['id']; else echo "";?>">


					<span>Berkas Persyaratan :</span>
					<div class="list-type1x">
						<ol class="rectangle-list">

            <!-- <?php $no = 1; foreach($dokumen_layanan as $rs){ ?>
              <li>
								<a class="<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>" <?php if($sk_cpns) { ?>
									onclick="filterClicked1('<?=$rs['dokumen_persyaratan'];?>')" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> <?=$rs['dokumen'];?></a>
							</li>
              <?php } ?> -->

              <?php if (in_array($jenis_layanan, $list_layanan_surat_berhenti)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat permohonan berhenti atas permintaan sendiri bermeterai yang ditandatangani oleh PNS ybs mengetahui kepala perangkat daerah'); ?></a></li>
							<li>
						  <?php } ?>
            <?php if (in_array($jenis_layanan, $list_layanan_skcpns)) { ?>
							<li>
								<a class="<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>" <?php if($sk_cpns) { ?>
									onclick="filterClicked1('<?=$sk_cpns['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK CPNS <i
											class="fas fa-<?php if($sk_cpns) echo ''; else echo '';?>"></i></a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skpns)) { ?>
							<li>
								<a class="<?php if($sk_pns) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
									onclick="filterClicked1('<?=$sk_pns['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK PNS <i
											class="fas fa-<?php if($sk_pns) echo ''; else echo '';?>"></i></a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skpangak)) { ?>
							<li>
								<a class="<?php if($sk_pangkat) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
									onclick="filterClicked1('<?=$sk_pangkat['gambarsk'];?>',2)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK PANGKAT </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skjabatan)) { ?>
							<li>
								<a class="<?php if($sk_jabatan) echo 'select'; else echo 'unselect';?>" <?php if($sk_pns) { ?>
									onclick="filterClicked1('<?=$sk_jabatan['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> SK JABATAN </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_dpcp)) { ?>
							<li>
								<a class="<?php if($dpcp) echo 'select'; else echo 'unselect';?>" <?php if($dpcp) { ?>
									onclick="filterClicked1('<?=$dpcp['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('daftar perorangan calon penerima pensiun (dpcp)'); ?> </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_pmk)) { ?>
							<li>
								<a class="<?php if($pmk) echo 'select'; else echo 'unselect';?>" <?php if($pmk) { ?>
									onclick="filterClicked1('<?=$pmk['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('sk peninjauan masa kerja (PMK)'); ?> </a>
							</li>
              <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_skp)) { ?>
							<li>
								<a class="<?php if($skp) echo 'select'; else echo 'unselect';?>" <?php if($skp) { ?>
									onclick="filterClicked1('<?=$skp['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>><i class="fa fa-file-pdf"></i> <?php echo strtoupper('sasaran kinerja pegawai dan penilaian prestasi kerja 1 tahun terakhir'); ?> </a>
							</li>
              <?php } ?>
              
              <?php if (in_array($jenis_layanan, $list_layanan_hd)) { ?>
                  <li><a class="<?php if($hd) echo 'select'; else echo 'unselect';?>" <?php if($hd) { ?>
									onclick="filterClicked1('<?=$hd['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i> <?php echo strtoupper('Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/Berat'); ?> </a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_rekom_sakit)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat Rekomendasi Sakit/Uzur dari tim dokter pemerintah yang ditunjuk oleh menteri kesehatan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_pidana)) { ?>
                  <li><a class="<?php if($pidana) echo 'select'; else echo 'unselect';?>" <?php if($pidana) { ?>
									onclick="filterClicked1('<?=$pidana['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper(' Surat Pernyataan Tidak Sedang Menjalani Proses Pidana Atau Pernah Dipidana Penjara Berdasarkan Putusan Pengadilan Yang Telah Berkekuatan Hukum Tetap'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_ket_kematian)) { ?>
                  <li><a class="<?php if($surat_ket_kematian) echo 'select'; else echo 'unselect';?>" <?php if($surat_ket_kematian) { ?>
									onclick="filterClicked1('<?=$surat_ket_kematian['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat keterangan kematian dari dokter yang menerangkan secara detail penyebab kematian'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_surat_laporan_kronologis)) { ?>
                  <li><a class="<?php if($surat_laporan_kronologis) echo 'select'; else echo 'unselect';?>" <?php if($surat_laporan_kronologis) { ?>
									onclick="filterClicked1('<?=$surat_laporan_kronologis['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('laporan kronologis kejadian secara detail dan terperinci dibuat oleh pimpinan unit kerja ybs'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktenikah)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte perkawinan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktercerai)) { ?>
                  <li><a class="<?php if($aktecerai) echo 'select'; else echo 'unselect';?>" <?php if($aktecerai) { ?>
									onclick="filterClicked1('<?=$aktecerai['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte cerai (bagi yang pernah bercerai'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_aktekematian)) { ?>
                  <li><a class="<?php if($aktekematian) echo 'select'; else echo 'unselect';?>" <?php if($aktekematian) { ?>
									onclick="filterClicked1('<?=$aktekematian['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte kematian yang bersangkutan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_akteanak)) { ?>
                  <li><a class="<?php if($akteanak) echo 'select'; else echo 'unselect';?>" <?php if($akteanak) { ?>
									onclick="filterClicked1('<?=$akteanak['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('akte lahir anak (bagi anak kandung yang belum berusia 25 tahun, belum pernah bekerja, belum pernah menikah, dan masih sekolah/kuliah'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_kk)) { ?>
                  <li><a class="<?php if($kk) echo 'select'; else echo 'unselect';?>" <?php if($kk) { ?>
									onclick="filterClicked1('<?=$kk['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('kartu keluarga'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_ket_janda_duda)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat keterangan janda/duda dari almarhum/almarhumah yang diterbitkan oleh kelurahan/kecamatan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_spt)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('surat perintah tugas (penugasan tertulis) bagi yang meninggal dunia karena menjalankan tugas jabatan dan/atau tugas kedinasan lainnya baik didalam maupun diluar lingkungan kerja'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_visum)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('visum yang dikeluarkan oleh dokter yang antara lain berisi penyebab kematian bagi yang meninggal dunia karena penganiayaan, penculikan atau kecelakaan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_berita_acara)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('Berita Acara kepolisian/laporan polisi yang menyebutkan secara lengkap tentang waktu kejadian, kronologis kejadian, serta kesimpulan bagi pegawai yang meninggal karena kecelakaan'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_ktp)) { ?>
                  <li><a class="<?php if($ktp) echo 'select'; else echo 'unselect';?>" <?php if($ktp) { ?>
									onclick="filterClicked1('<?=$ktp['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('KTP'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_npwp)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('NPWP'); ?></a></li>
							<li>
						  <?php } ?>
              <?php if (in_array($jenis_layanan, $list_layanan_buku_rek)) { ?>
                  <li><a class="<?php if($akte_nikah) echo 'select'; else echo 'unselect';?>" <?php if($akte_nikah) { ?>
									onclick="filterClicked1('<?=$akte_nikah['gambarsk'];?>',4)" data-toggle="modal"
									data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i>
                  <?php echo strtoupper('buku rekening'); ?></a></li>
							<li>
						  <?php } ?>
						</ol>
					</div>


				
				<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
				</form>
				<p class="mt-5">
					Keterangan :<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
					Berkas Sudah diupload<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2">  &nbsp;
					</button> Berkas belum diupload<br>
					Berkas diupload Pada Menu Profil <br>
					Untuk Berkas Selain SK CPNS, SK PNS, SK Jabatan, SK Pangkat<br>
					di upload pada pilihan Arsip Lainnya.
				</p>
				<!-- <a href="<?=base_url('kepegawaian/download');?>"> <i class="fa fa-download"> <i> Download Format Laporan
							Perkawinanan pertama & Daftar keluarga </i></i></a> -->
			</div>
		</div>
	</div>
	<div class="col-lg-12 mt-3">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<div class="card-title">
						<h5>RIWAYAT LAYANAN PENSIUN <?=$nama_layanan;?></h5>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="">
				<h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i>
					LOADING...</h5>
				<iframe id="iframe_view_file_berkas_pns" style="width: 100%; height: 80vh;" src=""></iframe>
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
  loadListRiwayatPensiun()
    })
    $('#form_pensiun').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_pensiun');
        var form_data = new FormData(formvalue[0]);
        var sk_cpns = $('#sk_cpns').val();
        var sk_pns = $('#sk_pns').val();
        var akte_nikah = $('#akte_nikah').val();
        var dpcp = $('#dpcp').val();
        var jandaduda = $('#jandaduda').val();
        


        // var jenis_layanan = "<?=$jenis_layanan;?>"

        // if(jenis_layanan == 7 || jenis_layanan == 8 || jenis_layanan == 9){
        // if(sk_cpns == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        
        // if(sk_pns == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }

        // if(dpcp == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        // }

        // if(jenis_layanan == 8){
        //   if(jandaduda == ""){
        //     errortoast(' Berkas Belum Lengkap')
        //     return false;
        // }
        // }


        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananPensiun")?>",
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
                loadListRiwayatKarisKarsu()
                window.scrollTo(0, document.body.scrollHeight);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });


    async function filterClicked1(filename,kode){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    var base_url = "<?=base_url();?>";
    var jenis_layanan = "<?=$jenis_layanan;?>";

    // if(id_dokumen == 2 || id_dokumen == 3){
    //       dir = "arsipberkaspns/";
    //     } else if(id_dokumen == 4){
    //       dir = "arsipelektronik/";
    //     } else if(id_dokumen == 18){
    //       dir = "arsiplain/";
    //     }  

    // $.ajax({
    //     type : "POST",
    //     url  : base_url + '/kepegawaian/C_Kepegawaian/getFileLayanan',
    //     dataType : "JSON",
    //     data : {id_dokumen:id_dokumen},
    //     success: function(data){
    //     $('#divloader').html('')
    //     var number = Math.floor(Math.random() * 1000);
    //     var link = "<?=base_url();?>/"+dir+"/"+data[0].gambarsk+"?v="+number;
    //     if(data != ""){
    //       if(data[0].gambarsk != ""){
    //         $('#iframe_view_file_berkas_pns').attr('src', link)
    //        $('#iframe_view_file_berkas_pns').on('load', function(){
    //      $('.iframe_loader').hide()
    //      $(this).show()
    //    })
           
    //       } else {
    //         $('#view_file_verif').attr('src', '')
    //         $('#ket').html('Tidak ada data');
    //       }
    //     } else {
    //     // errortoast('tidak ada data')
    //     $('.iframe_loader').hide()  
    //     $('#view_file_verif').attr('src', '')
    //     $('#ket').html('Tidak ada data');
    //     }
    //     }
    //     });

        if(kode == 1){
          dir = "arsipberkaspns/";
        } else if(kode == 2){
          dir = "arsipelektronik/";
        } else if(kode == 3){
          dir = "arsipjabatan/";
        } else if(kode == 4){
          dir = "arsiplain/";
        }
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/"+dir+"/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  async function filterClicked2(filename){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function loadListRiwayatPensiun(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatPensiun/")?>', function(){
      $('#loader').hide()
    })
    }

</script>