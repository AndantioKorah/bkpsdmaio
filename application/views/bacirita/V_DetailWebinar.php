<style>
	.lbl-form-input-kegiatan{
		font-size: .8rem;
		color: grey;
		font-weight: bold;
		font-style: italic;
	}

	.lbl-form-divider{
		font-size: .9rem;
		color: black;
		font-weight: bold;
	}

    .progress-container{
        width: 100%;
        display: flex;
        justify-content: space-between;
        gap: 100px;
        margin-top: 50px;
        margin-bottom: 50px;
        align-items: center;
    }

    .path{
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    .path_keterangan{
        margin-top: 5px;
        display: flex;
        flex-direction: column;
        text-align: left;
        line-height: 15px;
    }

    .sp_keterangan_date{
        font-size: .65rem;
        font-weight: 550;
        font-style: italic;
        color: grey;
    }

    .sp_keterangan{
        font-size: .85rem;
        font-weight: bold;
    }

    .txt_ditutup{
        color: rgba(84, 84, 84, 0.7) !important;
    }

    .icon-after::after{
        content: "";
        display: block;
        height: 2px;
        width: 50%;
        background: black;
        position: relative;
        left: 65%;
        top: -70%;
        transform: translateY(-50%);
    }



</style>
<a href="<?=base_url('bacirita/list-webinar')?>">
    <button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-arrow-left"></i> Kembali</button>
</a>
<div class="mt-3 card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
                <?php $month = date("m", strtotime($webinar['tanggal'])); ?>
				<h3><b>WEBINAR <?= strtoupper(getNamaBulan($month));?> <?=date('Y');?></b></h3>
				<h4><i><?= strtoupper($webinar['topik']);?></i></h4>
                <br>
                <h4><b>(<?=$webinar['jumlah_jp']?> JP)</b> Badan Kepegawaian dan Pengembangan Sumber Daya Manusia</h4>
                <?= formatDateNamaBulan($webinar['tanggal']);?>  <?= substr($webinar['jam_mulai'], 0, 8);?> - <?= substr($webinar['jam_selesai'], 0, 8);?> <br>

                <?php 
                $badgeStatusDaftar = "btn-info";
			    $statusDaftar = "<i class='fa fa-plus'></i> Daftar Webinar";
			    $onclick = "daftar()";
                $stylePresensi = "-";
			
			    if($webinar['tanggal'] == date('Y-m-d')){ 
				if(date('H:i:s') < $webinar['jam_mulai']) {
                    $badgeStatusDaftar = "btn-info";
                    $statusDaftar = "<i class='fa fa-plus'></i> Daftar Webinar";
				}
				if(date('H:i:s') > $webinar['jam_mulai']) {
                    if(date('H:i:s') > $webinar['jam_batas_pendaftaran']) {
                        $badgeStatusDaftar = "btn-danger";
                        $statusDaftar = "Pendaftaran telah ditutup";
                        $onclick = "-";
                    } 
                }
				if(date('H:i:s') > $webinar['jam_selesai']) {
                    $badgeStatusDaftar = "btn-success";
                    $statusDaftar = "Selesai";
                    $onclick = "-";
				} 
                
                // if(date('H:i:s') < $webinar['jam_buka_absensi']) {
                //     $stylePresensi ="display:none;";
				// }

                // if(date('H:i:s') > $webinar['jam_batas_absensi']) {
                //     $stylePresensi ="display:none;";
				// }

                if($webinar['flag_buka_absen'] == 0) {
                    $stylePresensi ="display:none;";
				}


			    }
                if(date('Y-m-d') > $webinar['tanggal']){ 
                    $badgeStatusDaftar = "btn-success";
                    $statusDaftar = "Selesai";
                    $onclick = "-";
                }

                ?>
                
                <?php // if($this->general_library->isProgrammer()){
                    $jamWaktuSelesai = $webinar['tanggal']." ".$webinar['jam_selesai'];
                    $flagHariSama = $webinar['tanggal'] == date('Y-m-d') ? 1 : 0;
                ?>
                    <div class="row">
                        <div class="col-lg-12 progress-container">
                            <div class="path">
                                <?php if($webinar['id_daftar']){ ?> 
                                    <!-- sudah daftar -->
                                    <i class="fa fa-4x fa-user-plus text-success"></i>
                                    <div class="path_keterangan">
                                        <span class="sp_keterangan text-success">Sudah terdaftar </span>
                                        <span class="sp_keterangan_date text-success">(<?=formatDateNamaBulanWithTime($webinar['created_date'])?>)</span>
                                    </div>
                                <?php } else { ?>
                                    <!-- belum daftar -->
                                     <?php if($flagHariSama == 1){ ?>
                                        <!-- masih pada hari yang sama -->
                                        <i class="fa fa-3x fa-user-plus text-warning"></i>
                                        <div class="path_keterangan">
                                            <span class="sp_keterangan">Belum terdaftar</span>
                                        </div>
                                        <!-- button daftar di sini -->
                                    <?php } else { ?>
                                        <!-- tidak pada hari yang sama -->
                                        <i class="fa fa-2x fa-user-plus text-grey"></i>
                                        <div class="path_keterangan">
                                            <span class="sp_keterangan txt_ditutup">Pendaftaran ditutup</span>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="path">
                                <?php if($webinar['flag_absen'] == 1){ ?>
                                    <!-- sudah absen -->
                                    <i class="fa fa-4x fa-file-signature text-success"></i>
                                    <div class="path_keterangan">
                                        <span class="sp_keterangan text-success">Sudah absen</span>
                                        <span class="sp_keterangan_date text-success">(<?=formatDateNamaBulanWithTime($webinar['date_absen'])?>)</span>
                                    </div>
                                <?php } else { ?>
                                    <!-- belum absen -->
                                    <?php if($flagHariSama == 1){ ?>
                                        <!-- hari yang sama -->
                                        <?php if($webinar['flag_buka_absen'] == 1){ ?>
                                            <!-- absen sudah dibuka -->
                                            <?php if($webinar['id_daftar']){ ?>
                                                <!-- sudah daftar -->
                                                <i class="fa fa-3x fa-file-signature text-warning"></i>
                                                <div class="path_keterangan">
                                                    <span class="sp_keterangan text-warning">Belum absen</span>
                                                    <!-- button absen di sini -->
                                                </div>
                                            <?php } else { ?>
                                            <i class="fa fa-2x fa-file-signature text-grey"></i>
                                                <!-- belum daftar -->
                                                <div class="path_keterangan">
                                                    <span class="sp_keterangan txt_ditutup">Belum terdaftar</span>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <!-- flag_buka_absen == 0 -->
                                            <?php if(date('H:i:s') <= $webinar['jam_batas_absensi']){ ?>
                                                <!-- masih dalam batas absen -->
                                                <i class="fa fa-2x fa-file-signature text-grey"></i>
                                                <div class="path_keterangan">
                                                    <span class="sp_keterangan">Absen belum dibuka</span>
                                                </div>
                                            <?php } else { ?>
                                                <i class="fa fa-2x fa-file-signature text-grey"></i>
                                                <div class="path_keterangan">
                                                    <span class="sp_keterangan txt_ditutup">Absen sudah ditutup</span>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <!-- beda hari -->
                                        <?php if(date('Y-m-d') < $webinar['tanggal']){ ?>
                                            <!-- belum harinya -->
                                            <i class="fa fa-2x fa-file-signature text-grey"></i>
                                            <div class="path_keterangan">
                                                <span class="sp_keterangan">Absen belum dibuka</span>
                                            </div>
                                        <?php } else { ?>
                                            <!-- lewat hari -->
                                            <i class="fa fa-2x fa-file-signature text-grey"></i>
                                            <div class="path_keterangan">
                                                <span class="sp_keterangan txt_ditutup">Absen sudah ditutup</span>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="path">
                                <?php if($webinar['flag_download_sertifikat'] == 1){ ?>
                                    <!-- generate sertifikat sudah dibuka -->
                                    <?php if($webinar['flag_generate_sertifikat']){ ?>
                                        <!-- sertifikat sudah digenerate -->
                                        <i class="fa fa-4x fa-certificate text-success"></i>
                                        <div class="path_keterangan">
                                            <span class="sp_keterangan text-success">Sertifikat sudah tersedia</span>
                                            <span class="sp_keterangan_date text-success">(<?=formatDateNamaBulanWithTime($webinar['date_generate_sertifikat'])?>)</span>
                                        </div>
                                    <?php } else { ?>
                                        <!-- sertifikat belum digenerate -->
                                        <?php if($webinar['flag_absen']){ ?>
                                            <!-- sudah absen -->
                                            <i class="fa fa-3x fa-certificate text-warning"></i>
                                            <div class="path_keterangan">
                                                <!-- button generate sertifikat di sini -->
                                                <span class="sp_keterangan text-warning">Sertifikat belum tersedia</span>
                                            </div>
                                        <?php } else { ?>
                                            <!-- belum absen -->
                                            <i class="fa fa-2x fa-certificate text-grey"></i>
                                            <div class="path_keterangan">
                                                <span class="sp_keterangan txt_ditutup">Belum absen</span>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <i class="fa fa-2x fa-certificate text-grey"></i>
                                    <div class="path_keterangan">
                                        <span class="sp_keterangan text-grey">Sertifikat dalam proses</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="path">
                                <?php if($webinar['url_sertifikat_peserta']){ ?>
                                    <!-- sertifikat sudah dapat didownload -->
                                    <i class="fa fa-4x fa-upload text-success"></i>
                                    <div class="path_keterangan">
                                        <span class="sp_keterangan text-success">Terupload di Siladen</span>
                                    </div>
                                <?php } else { ?>
                                    <i class="fa fa-2x fa-upload text-grey"></i>
                                    <div class="path_keterangan">
                                        <span class="sp_keterangan txt_ditutup">Sertifikat tidak tersedia</span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php // } ?>
                <?php if($webinar['id_daftar'] == null) { ?>
                    <button id="btn_daftar" onclick= <?=$onclick;?>  type="button" class="btn mt-3 <?=$badgeStatusDaftar;?>"> <?=$statusDaftar;?></button>
                <?php } else { ?>
                    <span style="font-size: 1rem; font-weight: bold; font-style: italic; color: green;"><i class="fa fa-check"></i> Anda sudah terdaftar</span><br>
                    <?php if(($webinar['tanggal'] == date('Y-m-d') &&
                        $webinar['flag_absen'] == 0 &&
                        (formatTimeAbsen($webinar['jam_mulai']) >= date('H:i:s') && formatTimeAbsen($webinar['jam_selesai']) <= date('H:i:s'))) || 
                        $webinar['flag_buka_absen'] == 1){ ?>
                        <?php if($webinar['flag_absen'] == 0 && date('H:i:s') < formatTimeAbsen($webinar['jam_batas_absensi'])){ ?>
                            <button onclick= "presensiKegiatan()"  id="btn_presensi"  type="button" class="btn mt-3 btn-dark"> Presensi Seminar</button>
                            <?php } ?>
                        <?php } ?>

                    <?php if($webinar['flag_absen'] == 1) { ?>
                        <span style="font-size: 1rem; font-weight: bold; font-style: italic; color: green;"><i class="fa fa-check"></i> Anda Sudah Melakukan Presensi</span><br>
                        <?php
                            $jamWaktuSelesai = $webinar['tanggal']." ".$webinar['jam_selesai'];
                            if(date('Y-m-d H:i:s') > $jamWaktuSelesai){ ?>
                            <br>
                            <?php if($webinar['flag_download_sertifikat'] == 1
                            ){ ?>
                                <?php // if($this->general_library->isProgrammer()){ ?>
                                    <button style="display: <?=$webinar['flag_generate_sertifikat'] == 0 ? 'block' : 'none'?>" id="btn_generate_sertifikat" type="button" class="btn mt-3 btn-primary">Generate Sertifikat</button>
                                <?php  // } ?>
                                <button style="display: <?=$webinar['url_sertifikat_peserta'] ? 'block' : 'none'?>" id="btn_download_sertifikat" type="button" class="btn mt-3 btn-primary"><i class="fa fa-download"></i> Download Sertifikat</button><br>
                                <span style="color: green; font-size: .65rem; margin-top: -15px; font-style: italic; font-weight: bold; display: <?=$webinar['url_sertifikat_peserta'] ? 'block' : 'none'?>" class="download_sertifikat_label"><i class="fa fa-check"></i> Sertifikat sudah dapat didownload</span><br>
                                <span style="color: green; font-size: .65rem; margin-top: -15px; font-style: italic; font-weight: bold; display: <?=$webinar['url_sertifikat_peserta'] ? 'block' : 'none'?>" class="download_sertifikat_label">Sertifikat sudah terisi secara otomatis di data Bangkom Anda</span>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                
                <h4 class="mt-4">LINK</h4>
                <hr>
                <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Media</th>
      <th scope="col">Link</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Zoom Meeting <br>ID : <?=$webinar['meeting_id_zoom'];?> Passcode : <?=$webinar['passcode_zoom'];?></td>
      <td>
        <a class="btn btn-info btn-sm" href="<?=$webinar['link_zoom'];?>" role="button" target="_blank">
            <?=$webinar['link_zoom'];?>
        </a>
    </td>
    </tr>
    <tr>
      <td>Youtube</td>
       <td>
        <a class="btn btn-info btn-sm" href="<?=$webinar['link_youtube'];?>" role="button" target="_blank">
            <?=$webinar['link_youtube'];?>
        </a>
    </td>
    </tr>
     </tbody>
</table>
			</div>
			<div id="div_list_kegiatan" class="col-lg-12">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_detail_kegiatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">DETAIL KEGIATAN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_detail_kegiatan_content">
            </div>
        </div>
    </div>
</div>
<script>
	$(function(){
		$('#tipe_kegiatan').select2()
		refreshDatePicker()
	})

	function refreshDatePicker(){
		$('#tanggal').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			todayBtn: true
		})

		$('#tanggal_batas_absensi').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			startDate: $('#tanggal').val()
		})

		$('#tanggal_batas_pendaftaran').datepicker({
			format: 'yyyy-mm-dd',
			orientation: 'bottom',
			autoclose: true,
			// todayBtn: true,
			endDate: $('#tanggal').val()
		})
    }
    
    $('#btn_generate_sertifikat').on('click', function(){
        // $('#btn_generate_sertifikat').html('<i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...')
        // $('#btn_generate_sertifikat').prop('disabled', true)
        $.ajax({
            url: '<?=base_url("bacirita/C_Bacirita/generateSertifikat/".$webinar['id_kegiatan'])?>',
            method: 'post',
            data: {
                'id_t_kegiatan': '<?=$webinar['id_kegiatan']?>',
                'id_m_user': '<?=$this->general_library->getId()?>'
            },
            success: function(res){
                var result = JSON.parse(res); 
                if(result.code == 0){
                    $('#btn_generate_sertifikat').hide()
                    $('#btn_download_sertifikat').show()
                    $('.download_sertifikat_label').show()
                    successtoast('Berhasil membuat sertifikat')
                } else {
                    errortoast(result.message)
                } 
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#btn_download_sertifikat').on('click', function(){
        $.ajax({
            url: '<?=base_url("bacirita/C_Bacirita/downloadSertifikat")?>',
            method: 'post',
            data: {
                'id_t_kegiatan': '<?=$webinar['id_kegiatan']?>',
                'id_m_user': '<?=$this->general_library->getId()?>'
            },
            success: function(res){
                var result = JSON.parse(res); 
                if(result.code == 0){
                    console.log(result.url)
                    window.open(result.url, "_blank")
                } else {
                    errortoast(result.message)
                } 
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function daftar(){
        document.getElementById('btn_daftar').disabled = true;
        $('#btn_daftar').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

        var id_webinar = "<?=$webinar['id_kegiatan'];?>"
        var id_m_user = "<?=$this->general_library->getId();?>"
                   if(confirm('Daftar Webinar?')){
                       $.ajax({
                           url: '<?=base_url("bacirita/C_Bacirita/submitDaftarKegiatan/")?>'+id_webinar+'/'+id_m_user,
                           method: 'post',
                           success: function(res){
                            var result = JSON.parse(res); 
                            console.log(result)
                           if(result.success == true){
                            const myTimeout = setTimeout(successtoast(result.message), 2000);
                            setTimeout(function() {location.reload();}, 1000);
                            } else {
                            errortoast(result.message)
                            return false;
                            } 
                               
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

    function presensiKegiatan(){
        var id_webinar = "<?=$webinar['id_kegiatan'];?>"
        var id_m_user = "<?=$this->general_library->getId();?>"
        document.getElementById('btn_presensi').disabled = true;
        $('#btn_presensi').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')

                   if(confirm('Absen Seminar?')){
                       $.ajax({
                           url: '<?=base_url("bacirita/C_Bacirita/presensiKegiatan/")?>'+id_webinar+'/'+id_m_user,
                           method: 'post',
                           success: function(res){
                            var result = JSON.parse(res); 
                            console.log(result)
                           if(result.success == true){
                            const myTimeout = setTimeout(successtoast(result.message), 2000);
                            setTimeout(function() {location.reload();}, 1000);
                            } else {
                            errortoast(result.message)
                            return false;
                            } 
                               
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }
</script>