<?php if($jabatan){ ?>
<style>
	.list-group-item.active {
		background-color: #222e3c;
		border-color: var(--bs-list-group-active-border-color);
		color: var(--bs-list-group-active-color);
		z-index: 2;
	}


    .badge-kesehatan{
      box-shadow: 3px 3px 10px #888888;
      background-color: #4169E1;
      border: 2px solid #4169E1;
      color: white;
    }

    .badge-ti{
      box-shadow: 3px 3px 10px #888888;
      background-color: #00008B;
      border: 2px solid #00008B;
      color: white;
    }

    .badge-pendidikan{
      box-shadow: 3px 3px 10px #888888;
      background-color: #8B4513;
      border: 2px solid #8B4513;
      color: white;
    }





</style>

	<div class="table-responsive" id="example">
		<table class="table table-hover table-striped table-bordered datatablex" style="width:100%;">
			<thead>
				<th class="text-center" style="width:5%;">No</th>
				<th style="width:40%;">Nama Jabatan</th>
				<th style="width:55%;">Rumpun Jabatan</th>
                <th></th>
			</thead>
			<tbody>
				<?php $nomor = 1; foreach($jabatan as $rs){ ?>
				<tr>
					<td class="align-top" align="center"><?=$nomor++;?></td>
					<td class="align-top">
						<?=$rs['nama_jabatan'];?>
					</td>
          <td>
          <h4>
          <?php foreach($rs['rumpun'] as $rj){ ?>
            <?php 
            // if($rj['id_m_rumpun_jabatan'] == 1){
            //   $color = "#007bff";
            // } else if($rj['id_m_rumpun_jabatan'] == 2) {
            //   $color = "#6c757d";
            // } else if($rj['id_m_rumpun_jabatan'] == 3) {
            //   $color = "#28a745";
            // } else if($rj['id_m_rumpun_jabatan'] == 4) {
            //   $color = "#dc3545";
            // } else if($rj['id_m_rumpun_jabatan'] == 5) {
            //   $color = "#ffc107";
            // } else if($rj['id_m_rumpun_jabatan'] == 6) {
            //   $color = "#17a2b8";
            // } else if($rj['id_m_rumpun_jabatan'] == 7) {
            //   $color = "#602d66";
            // } else if($rj['id_m_rumpun_jabatan'] == 8) {
            //   $color = "#343a40";
            // }
            $badge_aktif = 'badge-aktif';
            if($rj['id_m_rumpun_jabatan'] == 2){
                $badge_aktif = 'badge-pensiun-bup';
            } else if($rj['id_m_rumpun_jabatan'] == 3){
                $badge_aktif = 'badge-diberhentikan';
            } else if($rj['id_m_rumpun_jabatan'] == 4){
                $badge_aktif = 'badge-ti';
            } else if($rj['id_m_rumpun_jabatan'] == 5){
                $badge_aktif = 'badge-mutasi';
            } else if($rj['id_m_rumpun_jabatan'] == 6){
                $badge_aktif = 'badge-pensiun-dini';
            } else if($rj['id_m_rumpun_jabatan'] == 7){
              $badge_aktif = 'badge-pppk';
            } else if($rj['id_m_rumpun_jabatan'] == 8){
                $badge_aktif = 'badge-meninggal';
            } else if($rj['id_m_rumpun_jabatan'] == 9){
              $badge_aktif = 'badge-kesehatan';
            } else if($rj['id_m_rumpun_jabatan'] == 10){
              $badge_aktif = 'badge-pendidikan';
            }
            ;?>
            <span style="margin-bottom:5px"  class="badge <?=$badge_aktif;?>"><?=$rj['nm_rumpun_jabatan'];?></span>
            <!-- <table class="table table-hover table-striped table-bordered">
										<tr>	
											<td style="width:90%;"> <b><?=$rj['nm_rumpun_jabatan'];?> 
											</td>
											<td>
												<a onclick="deleteRumpunJabatan('<?=$rj['id']?>','adm')" class="btn btn-sm"> <i
														style="color:red;" class="fa fa-trash"></i> </a>
											</td>
										</tr>
									</table> -->
            <?php } ?>
            </h4>
          </td>
					<td class="align-top">
              <button 
                data-toggle="modal" 
                data-id="<?=$rs['id_jabatanpeg']?>"
                data-nm_jabatan="<?=$rs['nama_jabatan']?>"
                href="#modal_input_rumpun_jabatan"
                onclick="loadDetail('<?=$rs['id_jabatanpeg']?>')"
                class="open-DetailJabatanx btn btn-sm btn-info"> <i class="fa fa-edit"></i> </button> 
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</div>


 
<div class="modal fade" id="modal_input_rumpun_jabatan" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rumpun Jabatan</h5>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="form_tambah_rumpun">

            </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>


<script>
	$(function () {

		$('.js-example-basic-multiple').select2();
		$('.datatable').dataTable()
	})


    function loadDetail(id){
    $('#form_tambah_rumpun').html('')
    $('#form_tambah_rumpun').append(divLoaderNavy)
    $('#form_tambah_rumpun').load('<?=base_url("simata/C_Simata/loadFormTambahRumpun/")?>'+id, function(){
      $('#loader').hide()
    })
    }

 



</script>
<?php } else { ?>
<div class="col-12 text-center">
	<h5>DATA TIDAK DITEMUKAN !</h5>
</div>
<?php } ?>
