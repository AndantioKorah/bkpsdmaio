<style>
	.card-list-kegiatan{
		box-shadow: 4px 4px 7px 0px rgba(0,0,0,0.75);
		-webkit-box-shadow: 4px 4px 7px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 4px 4px 7px 0px rgba(0,0,0,0.75);
		border: 1px solid rgba(0,0,0,0.75);
		border-radius: 10px;
		height: 30rem;
	}

	.img-kegiatan{
		border-radius: 10px 10px 0 0;
		box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.75);
		-webkit-box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.75);
		width: 100%;
		aspect-ratio: 1/1;
		object-fit: contain;
	}

	.title-kegiatan{
		color: black !important;
		font-weight: bold;
		font-size: 1rem !important;
		display: -webkit-box; /* Required for older browser compatibility */
		-webkit-box-orient: vertical; /* Required for older browser compatibility */
		-webkit-line-clamp: 6; /* Limits text to 3 lines */
		overflow: hidden;
		text-overflow: ellipsis; /* Ensures the ellipsis appears */
	}

	.div-button{
		position: absolute;
		bottom: 0;
		right: 0;
		margin-bottom: 10px;
	}

	.lbl-detail-kegiatan{
		color: rgba(53, 52, 52, 1);
		font-weight: bold;
		font-style: italic;
		font-size: .8rem;
	}

	.card-list-kegiatan:hover{
		cursor: pointer;
		/* background-color: grey; */
		border-color: var(--primary-color);
		border: 5px solid var(--primary-color);
		transition: .2s;
	}

	.badge-kegiatan{
		max-width: 100px;
		position: absolute;
		right: -10px;
		top: -10px;
		font-size: .8rem;
	}
</style>
<?php if($result){ ?>
	<div class="row">
		<?php foreach($result as $rs){
			$srcImage = "assets/img/logo-bkpsdm-bacirita.png";
			if($rs['url_banner'] && file_exists($rs['url_banner'])){
				$srcImage = $rs['url_banner'];
			}

			$jamSelesai = formatTimeAbsen($rs['jam_selesai']);
			if($jamSelesai == "00:00"){
				$jamSelesai = "Selesai";
			}

			$badgeKegiatan = "badge-info";
			if($rs['id_m_tipe_kegiatan'] == 2){ // jika umum
				$badgeKegiatan = "badge-success";
			}
		?>
			<div class="col-lg-3 p-3">
				<div class="card card-list-kegiatan">
					<a class="badge-kegiatan badge badge-sm <?=$badgeKegiatan?>"><?=$rs['nama_tipe_kegiatan']?></a>
					<img class="card-img-top img-fluid img-kegiatan" src="<?=base_url($srcImage)?>">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12 div-title">
								<h5 class="title-kegiatan card-title"><?=($rs['topik'])?></h5>
							</div>
							<div class="col-lg-12 div-button">
								<div class="row">
									<div class="col-lg-6">
										<span class="lbl-detail-kegiatan">
											<?=formatDateNamaBulan($rs['tanggal'])?><br>
											<?=formatTimeAbsen($rs['jam_mulai'])." - ".$jamSelesai?>
										</span>
									</div>
									<div class="col-lg-6 text-right">
										<a href="#modal_detail_kegiatan" data-toggle="modal" onclick="openDetailModal('<?=$rs['id']?>')"
										class="text-right btn btn-navy">Detail</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<script>
	function openDetailModal(id){
		$('#modal_detail_kegiatan_content').html('')
		$('#modal_detail_kegiatan_content').append(divLoaderNavy)
		$('#modal_detail_kegiatan_content').load('<?=base_url("bacirita/C_Bacirita/modalLoadDetailKegiatan/")?>'+id, function(){
			$('#loader').hide()
		})
	}
</script>