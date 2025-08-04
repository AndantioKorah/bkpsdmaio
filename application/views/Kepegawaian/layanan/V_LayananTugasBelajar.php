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
	background-color: #d41e24;
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
    /* text-shadow: 0 1px 0 rgba(255,255,255,.5); */
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
    color : #0ed095;

  }

  .rectangle-list .unselect:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    background: #d41e24;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
    color : #d41e24;
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
    color:rgb(239, 255, 8);

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
    border-left-color: #d41e24;
  }
</style>


<div class="row">
<div class="col-lg-12 mt-3">
		<div class="card card-default">
			<div class="card-header">
				<div class="card-title">
					<div class="card-title">
						<h5>RIWAYAT LAYANAN</h5>
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
      <span><b>Berkas Persyaratan :</b></span>
			</div>
			<div class="card-body mt-2">

				<form id="form_layanan_tugas_belajar" method="post" enctype="multipart/form-data" id="form_cuti"
					style="margin-top: -35px;">
          <?php if($id_m_layanan == 25 || $id_m_layanan == 26) { ?>
         <div class="form-group mb-2">
            <label>SURAT PERMOHONAN PNS YANG BERSANGKUTAN MENGETAHUI KEPALA PD DITUJUKAN KE WALIKOTA</label>
            <input  class="form-control my-image-field" type="file" id="pdf_surat_pengantar" name="file" required />
          </div>
          <div class="form-group mt-2">
            <label>SURAT PERNYATAAN TIDAK SEDANG MENJALANI HUKDIS TINGKAT SEDANG ATAUPUN BERAT DITANDATANGANI KEPALA PERANGKAT DAERAH</label>
            <input  class="form-control my-image-field" type="file" id="pdf_surat_hd" name="file2" required />
         </div>
         <div class="form-group mt-2">
            <label>SURAT PERNYATAAN TIDAK SEDANG MENJALANI CUTI LUAR TANGGUNGAN NEGARA (CLTN) DITANDATANGANI KEPALA PERANGKAT DAERAH</label>
            <input  class="form-control my-image-field" type="file" id="pdf_surat_pidana" name="file3" required />
         </div>
  
      <input type="hidden" id="nip" name="nip" value="<?= $this->general_library->getUserName();?>">
		  <input type="hidden" id="sk_pangkat" value="<?php if($sk_pangkat) echo $sk_pangkat['id']; else echo "";?>">
		  <input type="hidden" id="skp1" value="<?php if($skp1 && $skp1['gambarsk'] != null) echo $skp1['id']; else echo "";?>">
		  <input type="hidden" id="skp2" value="<?php if($skp2 && $skp2['gambarsk'] != null) echo $skp2['id']; else echo "";?>">
		  <input type="hidden" id="surat_permohonan_walikota" value="<?php if($surat_permohonan_walikota) echo $surat_permohonan_walikota['id']; else echo "";?>">
		  <input type="hidden" id="surat_rekom_masuk_pt" value="<?php if($surat_rekom_masuk_pt) echo $surat_rekom_masuk_pt['id']; else echo "";?>">
		  <input type="hidden" id="akreditasi" value="<?php if($akreditasi) echo $akreditasi['id']; else echo "";?>">
		  <input type="hidden" id="transkrip_nilai" value="<?php if($transkrip_nilai) echo $transkrip_nilai['id']; else echo "";?>">
		  <input type="hidden" id="ijazah" value="<?php if($ijazah) echo $ijazah['id']; else echo "";?>">
		  <input type="hidden" id="surat_ket_lulus_mhs" value="<?php if($surat_ket_lulus_mhs) echo $surat_ket_lulus_mhs['id']; else echo "";?>">
		  <input type="hidden" id="surat_rencana_kompetensi" value="<?php if($surat_rencana_kompetensi) echo $surat_rencana_kompetensi['id']; else echo "";?>">
		  <input type="hidden" id="suket_kuliah_online" value="<?php if($suket_kuliah_online) echo $suket_kuliah_online['id']; else echo "";?>">
		  <input type="hidden" id="krs" value="<?php if($krs) echo $krs['id']; else echo "";?>">
		  <input type="hidden" id="suket_beasiswa" value="<?php if($suket_beasiswa) echo $suket_beasiswa['id']; else echo "";?>">
		  <input type="hidden" id="rencana_pengembangan_diri" value="<?php if($rencana_pengembangan_diri) echo $rencana_pengembangan_diri['id']; else echo "";?>">

          
          
          <?php } ?>
        
				
					<div class="list-type1x">
						<ol class="rectangle-list">
              <?php if($id_m_layanan == 25 || $id_m_layanan == 26) { ?>
							<li>
								<a class="<?php if($skp1){ if($skp1['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($skp1) { ?>
									onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SKP TAHUN <?=$tahun_1_lalu;?>* <i
											class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
							</li>
                            	<li>
								<a class="<?php if($skp2){ if($skp2['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($skp2) { ?>
									onclick="viewBerkasPangkat('<?=$skp2['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SKP TAHUN <?=$tahun_2_lalu;?>* <i
											class="fas fa-<?php if($skp2) echo ''; else echo '';?>"></i></a>
							</li>
               <li>
			    <a class="<?php if($sk_pangkat){ if($sk_pangkat['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($sk_pangkat) { ?>
					onclick="viewBerkasPangkat('<?=$sk_pangkat['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SK PANGKAT <i
					class="fas fa-<?php if($sk_pangkat) echo ''; else echo '';?>"></i></a>
			  </li>
               <li>
			    <a class="<?php if($surat_rekom_masuk_pt){ if($surat_rekom_masuk_pt['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($surat_rekom_masuk_pt) { ?>
					onclick="viewBerkasPangkat('<?=$surat_rekom_masuk_pt['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT REKOMENDASI YANG DITANDATANGANI KEPALA BKPSDM <i
					class="fas fa-<?php if($surat_rekom_masuk_pt) echo ''; else echo '';?>"></i></a>
			  </li>
                <li>
			    <a class="<?php if($akreditasi){ if($akreditasi['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($akreditasi) { ?>
					onclick="viewBerkasPangkat('<?=$akreditasi['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SERTIFIKAT AKREDITASI PROGRAM STUDI Min. “BAIK SEKALI” DARI LEMBAGA TERAKREDITASI
                    <i class="fas fa-<?php if($akreditasi) echo ''; else echo '';?>"></i></a>
			  </li>
               <li>
			    <a class="<?php if($surat_ket_lulus_mhs){ if($surat_ket_lulus_mhs['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($surat_ket_lulus_mhs) { ?>
					onclick="viewBerkasPangkat('<?=$surat_ket_lulus_mhs['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT KETERANGAN DARI PERGURUAN TINGGI (LULUS SEBAGAI MAHASISWA)
                    <i class="fas fa-<?php if($surat_ket_lulus_mhs) echo ''; else echo '';?>"></i></a>
			  </li>
               <li>
			    <a class="<?php if($surat_rencana_kompetensi){ if($surat_rencana_kompetensi['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($surat_rencana_kompetensi) { ?>
					onclick="viewBerkasPangkat('<?=$surat_rencana_kompetensi['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT RENCANA KEBUTUHAN KOMPETENSI DARI PERANGKAT DAERAH
                    <i class="fas fa-<?php if($surat_rencana_kompetensi) echo ''; else echo '';?>"></i></a>
			  </li>
               <li>
			    <a class="<?php if($krs){ if($krs['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($krs) { ?>
					onclick="viewBerkasPangkat('<?=$krs['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> KRS
                    <i class="fas fa-<?php if($krs) echo ''; else echo '';?>"></i></a>
			  </li>
              <li>
			    <a class="<?php if($rencana_pengembangan_diri){ if($rencana_pengembangan_diri['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($rencana_pengembangan_diri) { ?>
					onclick="viewBerkasPangkat('<?=$rencana_pengembangan_diri['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> RENCANA TAHUNAN KEBUTUHAN PENGEMBANGAN DIRI
                    <i class="fas fa-<?php if($rencana_pengembangan_diri) echo ''; else echo '';?>"></i></a>
			  </li>
              <?php } ?>
              <?php if($id_m_layanan == 25) { ?>
              
              <li>
			    <a class="<?php if($surat_permohonan_walikota){ if($surat_permohonan_walikota['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($surat_permohonan_walikota) { ?>
					onclick="viewBerkasPangkat('<?=$surat_permohonan_walikota['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT PERMOHONAN PNS YANG BERSANGKUTAN MENGETAHUI KEPALA PD DITUJUKAN KE WALIKOTA <i
					class="fas fa-<?php if($surat_permohonan_walikota) echo ''; else echo '';?>"></i></a>
			  </li>
              <li>
			    <a class="<?php if($surat_rekom_masuk_pt){ if($surat_rekom_masuk_pt['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($surat_rekom_masuk_pt) { ?>
					onclick="viewBerkasPangkat('<?=$surat_rekom_masuk_pt['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT REKOMENDASI MENGIKUTI SELEKSI MASUK PT YANG DITANDATANGANI KEPALA BKPSDM <i
					class="fas fa-<?php if($surat_rekom_masuk_pt) echo ''; else echo '';?>"></i></a>
			  </li>
             <li>
			    <a class="<?php if($suket_beasiswa){ if($suket_beasiswa['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($suket_beasiswa) { ?>
					onclick="viewBerkasPangkat('<?=$suket_beasiswa['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT KETERANGAN ATAU SEJENISNYA DARI PEMBERI BEASISWA <i
					class="fas fa-<?php if($suket_beasiswa) echo ''; else echo '';?>"></i></a>
			  </li>
              <?php } ?>
              <?php if($id_m_layanan == 26) { ?>
              <li>
			    <a class="<?php if($suket_kuliah_online){ if($suket_kuliah_online['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>" <?php if($suket_kuliah_online) { ?>
					onclick="viewBerkasPangkat('<?=$suket_kuliah_online['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
					<?php } ?>> <i class="fa fa-file-pdf"></i> SURAT KETERANGAN DARI PERGURUAN TINGGI BAGI YANG PERKULIAHAN ONLINE
                    <i class="fas fa-<?php if($suket_kuliah_online) echo ''; else echo '';?>"></i></a>
			  </li>
              <?php } ?>
              
              
						</ol>
					</div>


          <?php if($status_layanan['status'] == 1) { ;?>
					<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
          <?php } else { ?>
            <p>
              <h4>
            <b style="color:red;">
              Layanan kenaikan pangkat sudah ditutup dan akan dibuka kembali pada periode kenaikan pangkat berikutnya.<br>
              periode kenaikan pangkat oktober 2025 (dibuka pada tanggal 22 juli - 19 agustus 2025)
            </b>
          </h4>
          </p>
          <?php }  ?>
				</form>

            <a href="<?=base_url('kepegawaian/download');?>"> <i class="fa fa-download">  Download Format Rencana Tahunan Kebutuhan Pengembangan Diri</i></a> 

				<p class="mt-5">
					Keterangan :<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
					Berkas Sudah diupload<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2">  &nbsp;
					</button> Berkas belum diupload<br>
          <button style="width:3%" class="btn btn-sm filter-btn filter-warning mt-2">  &nbsp;
					</button> Menunggu Verifikasi BKPSDM<br><br>
          <span class="mt-2">Berkas dengan tanda * Wajib diupload</span><br>
					Berkas diupload Pada Menu Profil <br>
          <?php if($id_m_layanan == 25) { ?>
          Untuk Berkas : <br>
					Selain SKP dan SK Pangkat di upload pada pilihan Arsip Lainnya.
				</p>
        <?php } ?>
          <?php if($id_m_layanan == 26) { ?>

          Untuk Berkas : <br>
					<i class="fa fa-file-pdf"></i> PAK<br>
					<i class="fa fa-file-pdf"></i> Ijin Belajar<br>
					<i class="fa fa-file-pdf"></i> Sertifikat Uji Kompetensi <br>
					<i class="fa fa-file-pdf"></i> SK Peninjauan Masa Kerja <br>
					<i class="fa fa-file-pdf"></i> Peta Jabatan <br>
					<i class="fa fa-file-pdf"></i> Ijazah terakhir/transkrip nilai dan tampilan layar Pangkalan Data/Forlap Dikti
					<br>di upload pada pilihan Arsip Lainnya.
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
				<h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i>
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
  loadListRiwayatLayananPangkat()
    })
    $('#form_layanan_tugas_belajar').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_layanan_tugas_belajar');
        var form_data = new FormData(formvalue[0]);

        var ins = document.getElementById('pdf_surat_pengantar').files.length;

        var skp1 = $('#skp1').val()
        var skp2 = $('#skp2').val()
        var sk_pangkat = $('#sk_pangkat').val()
        var surat_permohonan_walikota = $('#surat_permohonan_walikota').val()
        var surat_rekom_masuk_pt = $('#surat_rekom_masuk_pt').val()
        var transkrip_nilai = $('#transkrip_nilai').val()
        var ijazah = $('#ijazah').val()
        var akreditasi = $('#akreditasi').val()
        var surat_ket_lulus_mhs = $('#surat_ket_lulus_mhs').val()
        var surat_rencana_kompetensi = $('#surat_rencana_kompetensi').val()
        var suket_kuliah_online = $('#suket_kuliah_online').val()
        var krs = $('#krs').val()
        var suket_beasiswa = $('#suket_beasiswa').val()



        if(id_m_layanan == 25 || id_m_layanan == 26){
          if(skp1 == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(skp2 == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
           if(sk_pangkat == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
           if(surat_rekom_masuk_pt == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
           if(akreditasi == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(surat_ket_lulus_mhs == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(surat_rencana_kompetensi == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(ijazah == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
          if(transkrip_nilai == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
        }
        if(id_m_layanan == 25){
          if(suket_beasiswa == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
          }
        
        }

        
        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananTugasBelajar/")?>"+id_m_layanan,
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
                loadListRiwayatLayananPangkat()
                // window.scrollTo(0, document.body.scrollHeight);
                window.scrollTo(0, 0);
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });


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

  function loadListRiwayatLayananPangkat(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatLayanan/")?>'+id_m_layanan, function(){
      $('#loader').hide()
    })
    }


    $("#pdf_surat_pengantar").change(function (e) {

    // var extension = pdf_surat_pengantar.value.split('.')[1];
    var doc = pdf_surat_pengantar.value.split('.')
    var extension = doc[doc.length - 1]
    var fileSize = this.files[0].size/1024;
    var MaxSize = 1024;

    if (extension != "pdf"){
      errortoast("Harus File PDF")
      $(this).val('');
    }

    if (fileSize > MaxSize ){
      errortoast("Maksimal Ukuran File 1 MB")
      $(this).val('');
    }


    });
</script>