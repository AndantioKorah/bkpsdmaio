<ul class="sidebar-nav">
					<li class="sidebar-header">
						Main
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="#">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
            </a>
					</li>


					<li class="sidebar-header">
						Kepegawaian
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url();?>/kepegawaian/upload">
						<i class="align-middle me-2" data-feather="file-text"></i> <span class="align-middle">Upload Dokumen</span>
            			</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="ui-forms.html">
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
if($list_menu){  
    ?>

					<li class="sidebar-item ">
					<?php foreach($list_menu as $l){ ?>
						<?php if(!$l['child']){ ?>
							<li class="sidebar-item">
						<a class="sidebar-link" href="<?=$l['url'] == '#' || $l['url'] == '' ? '#' : base_url($l['url'])?>">
						<i class="align-middle me-2" data-feather="bar-chart-2"></i><span class="align-middle"><?=$l['nama_menu']?></span>
					</a>
							</li>
							<?php } ?>
							<?php if($l['child']){ ?>
								<a  data-bs-target="#menu<?=$l['id']?>" data-bs-toggle="collapse" class="sidebar-link">
							<i class="align-middle" data-feather="layers"></i> <span class="align-middle">
							<?=$l['nama_menu']?>
							<i class="align-middle me-2" style="border: solid;
                                                        border-width: 0 0.075rem 0.075rem 0;
                                                        content: 
                                                        display: inline-block;
                                                        padding: 2px;
                                                        position: absolute;
                                                        right: 1.5rem;
                                                        top: 1.2rem;
                                                        transform: rotate(45deg);
                                                        transition: all .2s ease-out;" ></i>
							<?php } ?>
							</span>
						</a>
						
						<?php if($l['child']){ ?>
                        <?php foreach($l['child'] as $ch){ ?>
						<ul id="menu<?=$l['id']?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
						<li class="sidebar-item "><a class="sidebar-link" href="<?=base_url($ch['url'])?>">
                        <i class="align-middle me-2" data-feather="circle"></i><?=$ch['nama_menu']?></a></li>
						</ul>
						<?php } ?>
						<?php } ?>
						<?php } ?>

					</li>

					<?php } ?>
					<!-- <li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url();?>kinerja/rencana">
					<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Sasaran Kerja</span>
					</a>
					</li> -->



					<!-- <li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url();?>kinerja/realisasi">
					<i class="align-middle" data-feather="map"></i> <span class="align-middle">Realisasi Kerja</span>
					</a>
					</li>
                    <li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url();?>kinerja/rekap">
					<i class="align-middle" data-feather="map"></i> <span class="align-middle">Rekap Sasaran Kerja</span>
					</a>
					</li>
                    <li class="sidebar-item">
						<a class="sidebar-link" href="<?= base_url();?>kinerja/skp-bulanan">
					<i class="align-middle" data-feather="map"></i> <span class="align-middle">Hasil SKBP</span>
					</a>
					</li> -->
				</ul>