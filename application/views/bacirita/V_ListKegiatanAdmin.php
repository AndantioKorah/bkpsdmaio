<?php if($result){ ?>
	<div class="row">
		<?php foreach($result as $rs){
			$srcImage = "assets/img/logo-bkpsdm-bacirita.png";
			if($rs['url_banner'] && file_exists('arsipbkpsdmbacirita/banner/'.$rs['url_banner'])){
				$srcImage = $rs['url_banner'];
			}
		?>
			<div class="col-lg-4">
				<div class="card">
					<img style="width" class="card-img-top img-fluid" src="<?=$srcImage?>">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>
						<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>