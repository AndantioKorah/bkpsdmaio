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
</style>
<a href="<?=base_url('bacirita/list-webinar')?>">
<button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-arrow-left"></i> Kembali</button>
</a>
<div class="mt-3 card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
                <?php $month = date("m", strtotime($webinar['tanggal'])); ?>
				<h3><b>BKPSDM BACIRITA EDISI <?= strtoupper(getNamaBulan($month));?> <?=date('Y');?></b></h3>
				<h4><i><?= strtoupper($webinar['topik']);?></i></h4>
                <br>
                <h4><b>(2 JP)</b> Badan Kepegawaian dan Pengembangan Sumber Daya Manusia</h4>
                <?= formatDateNamaBulan($webinar['tanggal']);?>  <?= substr($webinar['jam_mulai'], 0, 8);?> - <?= substr($webinar['jam_selesai'], 0, 8);?> <br>

                <?php 
                $badgeStatusDaftar = "btn-info";
			    $statusDaftar = "<i class='fa fa-plus'></i> Daftar Webinar";
			    $onclick = "daftar()";

			
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
			    }
                if(date('Y-m-d') > $webinar['tanggal']){ 
                $badgeStatusDaftar = "btn-success";
                $statusDaftar = "Selesai";
                $onclick = "-";
                }
                ?>

				<button onclick= <?=$onclick;?>  type="button" class="btn mt-3 <?=$badgeStatusDaftar;?>"> <?=$statusDaftar;?></button>
                
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
      <td><?=$webinar['link_zoom'];?></i></td>
    </tr>
    <tr>
      <td>Youtube</td>
      <td><?=$webinar['link_youtube'];?></i></td>
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
    
    function daftar(){
                   if(confirm('Daftar Webinar?')){
                    //    $.ajax({
                    //        url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteData/")?>'+id+'/pegdiklat/'+file,
                    //        method: 'post',
                    //        data: null,
                    //        success: function(){
                    //            successtoast('Data sudah terhapus')
                    //            if(kode == 1){
                    //             loadListDiklat()
                    //            } else {
                    //             loadRiwayatUsulDiklat()
                    //            }
                               
                    //        }, error: function(e){
                    //            errortoast('Terjadi Kesalahan')
                    //        }
                    //    })
                   }
               }
</script>