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
    color: #0ed095;
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
    color: #d41e24;

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

				<form id="form_perbaikan_data" method="post" enctype="multipart/form-data" id="form_cuti"
					style="margin-top: -45px;">
            <input type="hidden" id="sk_pns" value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
		
    
          <span><b>Berkas Persyaratan :</b></span>
					<div class="list-type1x mt-2">
          <div class="form-group">
            <label>Surat Pengantar dari Kepala Perangkat Daerah / Kepala Sekolah / Kepala Puskesmas / Direktur Rumah Sakit</label>
            <input  class="form-control my-image-field" type="file" id="pdf_surat_pengantar" name="file" required />
            <!-- <input class="form-control" type="file" id="surat_pengantar" name="surat_pengantar" autocomplete="off"  /> -->
          </div>
						<ol class="rectangle-list">
            <li>
            	<a class="<?php if($sk_pns){ if($sk_pns['status'] == 1) echo "warning"; else echo "select"; } else echo "unselect" ;?>"
            		<?php if($sk_pns) { ?> onclick="viewBerkasPangkat('<?=$sk_pns['gambarsk'];?>',1)"
            		data-toggle="modal" data-target="#exampleModal" <?php } ?>> <i class="fa fa-file-pdf"></i> SK
            		PNS* <i class="fas fa-<?php if($sk_pns) echo ''; else echo '';?>"></i></a>
            </li>
            
           
						</ol>
					</div>


				
					<!-- <button type="submit" class="btn btn-primary float-right ">Ajukan</button> -->
          <?php if($status_layanan['status'] == 1) { ;?>
					<button type="submit" class="btn btn-primary float-right ">Ajukan</button>
          <?php } else { ?>
            <p>
              <h4>
            <b style="color:red;">
              Layanan Peningkatan Pendidikan / Penambahan Gelar sudah ditutup dan akan dibuka kembali pada periode berikutnya.<br>
            </b>
          </h4>
          </p>
          <?php }  ?>
				</form>
				<p class="mt-5">
					Keterangan :<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-select"> &nbsp; </button>
					Berkas Sudah diupload<br>
					<button style="width:3%" class="btn btn-sm filter-btn filter-unselect mt-2">  &nbsp;
					</button> Berkas belum diupload<br>
          <button style="width:3%" class="btn btn-sm filter-btn filter-warning mt-2">  &nbsp;
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
  loadListRiwayatPeningkatanPenambahanGelar()
    })
    $('#form_perbaikan_data').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_perbaikan_data');
        var form_data = new FormData(formvalue[0]);
        var sk_cpns = $('#sk_cpns').val()
        var sk_pangkat = $('#sk_pangkat').val()
        var ijazah = $('#ijazah').val()
        var ibel = $('#ibel').val()
        var transkrip = $('#transkrip').val()
        var akreditasi_prodi = $('#akreditasi_prodi').val()
        var pangkalandata = $('#pangkalandata').val()
        var id_m_layanan = "<?=$id_m_layanan;?>"

       
        if(sk_cpns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
        if(ijazah == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(sk_pangkat == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(ibel == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(transkrip == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(akreditasi_prodi == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        if(pangkalandata == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
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
                loadListRiwayatPeningkatanPenambahanGelar()
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
        $link = "<?=base_url();?>/arsippendidikan/"+filename+"?v="+number;
    } else {
        $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
    }  
   
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  // function loadListRiwayatPeningkatanPenambahanGelar(){
  //   $('#list_riwayat_karsu').html('')
  //   $('#list_riwayat_karsu').append(divLoaderNavy)
  //   $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatPeningkatanPenambahanGelar/")?>', function(){
  //     $('#loader').hide()
  //   })
  //   }

  function loadListRiwayatPeningkatanPenambahanGelar(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatLayanan/")?>'+id_m_layanan, function(){
      $('#loader').hide()
    })
    }


    $("#pdf_surat_pengantar").change(function (e) {
      var fileSize = this.files[0].size/1024;
      var MaxSize = 1024

      var doc = pdf_surat_pengantar.value.split('.')
      var extension = doc[doc.length - 1]

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