<style>
	.sidebar-header{
		padding: 0.5rem 0.5rem 0.375rem !important;
		color: rgba(233,236,239,.5) !important;
		font-size: 1rem !important;
	}

	.sidebar-link{
		padding: 0.125rem 0.625rem !important;
		color: #ababab !important;
		font-size: .9rem;
		font-weight: bold !important;

		white-space: nowrap; 
		overflow: hidden;
		text-overflow: ellipsis; 
	}

	.sidebar-link:hover{
		color: #222e3c !important;
		transition: .1s;
		background-color: white !important;
	}

	.sidebar-link:hover i, .sidebar-link:hover span{
		color: #222e3c !important;
		transition: .1s;
		background-color: white !important;
	}

	.sidebar-link-child{
		padding-left: 1.3rem !important;
	}

	.sidebar-divider{
		margin: 0 !important;
	}

	.div_live_tpp{
		padding-top: 5px;
		padding-bottom: 5px;
		/* display: none; */
	}

	.div_live_tpp:hover{
		cursor: pointer;
		background-color: #37495e;
		transition: .2s;
	}
</style>

<ul class="sidebar-nav">
	<div><hr class="sidebar-divider"></div>
	<div class="div_live_tpp" title="Klik untuk melihat detail">
		<li class="">
			<span class="" style="
				font-size: .7rem !important;
				padding-left: .5rem;
				color: white;
				font-weight: 500;">CAPAIAN TPP</span>
		</li>
		<li class="live_tpp">
			<center>
				<span class="align-middle" style="
					font-size: 1.1rem;
					color: white;
					font-weight: bold;
					margin-top: -5px;
					margin-bottom: 10px;
				">
					<?=formatCurrency($tpp['capaian_tpp'])?>
				</span>
				<span style="
					font-size: .9rem;
					color: #ababab;
					vertical-align: bottom;
				">
					/ <?=formatCurrencyWithoutRp($tpp['pagu_tpp']['pagu_tpp'])?>
				</span>
			</center>			
		</li>
	</div>
	<div><hr class="sidebar-divider"></div>
	<li class="sidebar-header">
		Main
	</li>

	<li class="sidebar-item">
		<a class="sidebar-link" href="#">
			<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
		</a>
	</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="<?=base_url();?>kepegawaian/profil">
             			 <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
            			</a>
					</li>


	<li class="sidebar-header">
		Kepegawaian
	</li>

	<li class="sidebar-item">
		<a class="sidebar-link" href="<?= base_url(); ?>/kepegawaian/upload">
			<i class="align-middle me-2" data-feather="file-text"></i> <span class="align-middle">Dokumen</span>
		</a>
	</li>

	<li class="sidebar-item">
		<a class="sidebar-link" href="#">
			<i class="align-middle me-2" data-feather="grid"></i> <span class="align-middle">Layanan</span>
		</a>
	</li>

	<!-- <li class="sidebar-item">
						<a class="sidebar-link" href="ui-cards.html">
              <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Gaji Berkala</span>
            </a>
					</li> -->

	<!-- <li class="sidebar-item">
						<a class="sidebar-link" href="ui-typography.html">
              <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Pensiun</span>
            </a>
					</li> -->

	<!-- <li class="sidebar-item">
						<a class="sidebar-link" href="icons-feather.html">
              <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Cuti</span>
            </a>
					</li> -->

	<li class="sidebar-header">
		Kinerja
	</li>

	<?php
	$active_role = $this->session->userdata('active_role');
	$list_menu = $this->session->userdata('list_menu');
	if ($list_menu) {
	?>

					<li class="sidebar-item ">
					<?php foreach($list_menu as $l){ ?>
						<?php if(!$l['child']){ ?>
							<li class="sidebar-item">
						
						<a class="sidebar-link" title="<?=$l['nama_menu']?>" href="<?=$l['url'] == '#' || $l['url'] == '' ? '#' : base_url($l['url'])?>">
						<i class="align-middle fas fa-fw <?=$l['icon']?>"></i><span class="align-middle"><?=$l['nama_menu']?></span>
					    </a>
							</li>
							<?php } ?>
							<?php if($l['child']){ ?>
								<a title="<?=$l['nama_menu']?>" data-bs-target="#menu<?=$l['id']?>" data-bs-toggle="collapse" class="sidebar-link">
								<i class="align-middle me-2 fa fa-fw <?=$l['icon']?>"></i> <span class="align-middle">
								<?=trim($l['nama_menu'])?>
								<i class="fa fa-chevron-down" 
								style="
									position: absolute;
									right: 0;
									margin-top: .35rem;"></i>
							<?php } ?>
							</span>
						</a>
						
						<?php if($l['child']){ ?>
							<?php foreach($l['child'] as $ch){ ?>
								<ul id="menu<?=$l['id']?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
								<li class="sidebar-item ">
								<a title="<?=$ch['nama_menu']?>" class="sidebar-link sidebar-link-child" href="<?=base_url($ch['url'])?>">
								<i class="align-middle me-2 far fa-circle"></i><?=$ch['nama_menu']?></a></li>
							</ul>
							<?php } ?>
						<?php } ?>
						<?php } ?>
	<?php } ?>

	</li>
</ul>
<div class="mt-5">
	<p></p>
</div>