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
					<h5>FORM LAYANAN KARIS/KARSU</h5>
				</div>
				<hr>
			</div>

			<div class="card-body">

				<form id="form_karis_karsu" method="post" enctype="multipart/form-data" id="form_cuti"
					style="margin-top: -45px;">

					<input type="hidden" id="sk_cpns" value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
					<input type="hidden" id="sk_pangkat" value="<?php if($sk_pangkat) echo $sk_pangkat['id']; else echo "";?>">
					<input type="hidden" id="skp1" value="<?php if($skp1) echo $skp1['id']; else echo "";?>">
					<input type="hidden" id="skp2" value="<?php if($skp2) echo $skp2['id']; else echo "";?>">
					

					<span>Berkas Persyaratan :</span>
					<div class="list-type1x">
						<ol class="rectangle-list">
                        <li>
								<a class="<?php if($pak) echo 'select'; else echo 'unselect';?>" <?php if($pak) { ?>
									onclick="viewBerkasPangkat('<?=$pak['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> Asli Penilaian Angka Kredit (PAK) dan Klarifikasi PAK <i
											class="fas fa-<?php if($pak) echo ''; else echo '';?>"></i></a>
							</li>
							<li>
								<a class="<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>" <?php if($sk_cpns) { ?>
									onclick="viewBerkasPangkat('<?=$sk_cpns['gambarsk'];?>',1)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK CPNS <i
											class="fas fa-<?php if($sk_cpns) echo ''; else echo '';?>"></i></a>
							</li>
                            <li>
								<a class="<?php if($sk_pangkat) echo 'select'; else echo 'unselect';?>" <?php if($sk_pangkat) { ?>
									onclick="viewBerkasPangkat('<?=$sk_pangkat['gambarsk'];?>',2)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SK Pangkat <i
											class="fas fa-<?php if($sk_pangkat) echo ''; else echo '';?>"></i></a>
							</li>

                            <li>
								<a class="<?php if($skp1) echo 'select'; else echo 'unselect';?>" <?php if($skp1) { ?>
									onclick="viewBerkasPangkat('<?=$skp1['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SKP Tahun <?=$tahun_1_lalu;?> <i
											class="fas fa-<?php if($skp1) echo ''; else echo '';?>"></i></a>
							</li>
                            <li>
								<a class="<?php if($skp2) echo 'select'; else echo 'unselect';?>" <?php if($skp2) { ?>
									onclick="viewBerkasPangkat('<?=$skp2['gambarsk'];?>',3)" data-toggle="modal" data-target="#exampleModal"
									<?php } ?>> <i class="fa fa-file-pdf"></i> SKP Tahun <?=$tahun_2_lalu;?> <i
											class="fas fa-<?php if($skp2) echo ''; else echo '';?>"></i></a>
							</li>

							

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
					
				</p>
				
			</div>
		</div>
	</div>
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
  loadListRiwayatLayananPangkat()
    })
    $('#form_karis_karsu').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_karis_karsu');
        var form_data = new FormData(formvalue[0]);
        var sk_cpns = $('#sk_cpns').val()
        var sk_pns = $('#sk_pns').val()
        var daftar_keluarga = $('#daftar_keluarga').val()
        var laporan_perkawinan = $('#laporan_perkawinan').val()
        var pas_foto = $('#pas_foto').val()
        var akte_nikah = $('#akte_nikah').val()


        if(sk_cpns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
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

        

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananPangkat/7")?>",
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
                window.scrollTo(0, document.body.scrollHeight);
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
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatLayanan/7")?>', function(){
      $('#loader').hide()
    })
    }

</script>