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

	.icon-live{
		font-size: .5rem;
		border: 1px solid;
		padding: 3px;
	}

	.sub-sidebar-item {
				margin-left:15px;
	}
</style>

<?php
	$tpp = $this->session->userdata('live_tpp');
?>


<ul class="sidebar-nav">
<?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi() AND !$this->general_library->isWalikota() AND !$this->general_library->isGuest()){ ?>
	<div><hr class="sidebar-divider"></div>
	<div  onclick="openDetailTppPegawai()" class="div_live_tpp" title="Klik untuk melihat detail">
		<li class="">
			<span class="" style="
				font-size: .7rem !important;
				padding-left: .5rem;
				color: white;
				font-weight: 500;">CAPAIAN TPP</span>
		</li>
		<li class="live_tpp">
			<center>
				<span id="span_capaian_tpp" class="align-middle" style="
					font-size: 1.1rem;
					color: white;
					font-weight: bold;
					margin-top: -5px;
					margin-bottom: 10px;
				">
					<?php if($tpp){ ?>
						<?=formatCurrencyWithoutRp($tpp['capaian_tpp'])?>
					<?php } else { ?>
						<i class="fa fa-spin fa-spinner"></i>
					<?php } ?>
				</span>
				<span id="pagu_tpp" style="
					font-size: .9rem;
					color: #ababab;
					vertical-align: bottom;
				">
					<?php if($tpp){ ?>
						/ <?=formatCurrencyWithoutRp($tpp['pagu_tpp']['pagu_tpp'])?>
					<?php } else { ?>
						<!-- <i class="fa fa-spin fa-spinner"></i> -->
					<?php } ?>
				</span>
			</center>			
		</li>
		
	</div>
	<div><hr class="sidebar-divider"></div>
	<?php } ?>
	<?php if(!$this->general_library->isGuest()) { ?>
	<li class="sidebar-header">
		Main
	</li>

	<!-- <li class="sidebar-item">
		<a class="sidebar-link" href="#">
			<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
		</a>
	</li> -->
	<?php if(!$this->general_library->isWalikota() AND !$this->general_library->isGuest()) { ?>
	<li class="sidebar-item">
		<a class="sidebar-link" href="<?=base_url();?>kepegawaian/profil">
			<i class="fa fa-user"></i> <span class="align-middle">Profile</span>
		</a>
	</li>
	<?php } ?>
	<li class="sidebar-item">
		<a class="sidebar-link" href="<?=base_url();?>master/list-tpp">
		<!-- <a title="Layanan" data-bs-target="#layanan" data-bs-toggle="collapse" class="sidebar-link"> -->
			<i class="align-middle me-2 fa fa-money-bill"></i> 
			<span class="align-middle">List Pemberian TPP</span>
		</a>
	</li>
	<?php if($this->general_library->isProgrammer() 
				|| $this->general_library->isAdminAplikasi()
				|| isKasubKepegawaian($this->general_library->getNamaJabatan(), $this->general_library->getEselon())
				|| stringStartWith('Kepala Puskesmas', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatan())
				|| $this->general_library->isHakAkses('input_gaji_pegawai')
				|| $this->general_library->isHakAkses('pengurusan_tpp_perangkat_daerah')){ ?>
	<li class="sidebar-item">
		<a class="sidebar-link" href="<?=base_url();?>master/input-gaji">
			<i class="align-middle me-2 fa fa-money-bill"></i> 
			<span class="align-middle">Input Gaji Pegawai</span>
		</a>
	</li>

	<li class="sidebar-item">
		<a class="sidebar-link" href="<?=base_url();?>master/nominatif-pegawai">
			<i class="align-middle me-2 fa fa-users"></i> 
			<span class="align-middle">Nominatif Pegawai</span>
		</a>
	</li>
	<?php } ?>
	<!-- MENU MAIN UNTUK PROGRAMMER -->
	<?php if($this->general_library->isHakAkses('akses_profil_pegawai') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() AND !$this->general_library->isWalikota()){ ?>
		<li class="sidebar-item ">
			<a title="Master" data-bs-target="#master" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa-database"></i> 
				<span class="align-middle">
					Master
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="master" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				<?php if($this->general_library->isHakAkses('akses_profil_pegawai') || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
				<li class="sidebar-item ">
					<a title="Perangkat Daerah" class="sidebar-link sidebar-link-child" href="<?=base_url('master/perangkat-daerah')?>">
						<i class="align-middle me-2 far fa-circle"></i>Perangkat Daerah
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
				<li class="sidebar-item ">
					<a title="Bidang/Bagian" class="sidebar-link sidebar-link-child" href="<?=base_url('master/bidang')?>">
						<i class="align-middle me-2 far fa-circle"></i>Bidang/Bagian
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Sub Bidang/Sub Bagian" class="sidebar-link sidebar-link-child" href="<?=base_url('master/bidang/sub')?>">
						<i class="align-middle me-2 far fa-circle"></i>Sub Bidang/Sub Bagian
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Hak Akses" class="sidebar-link sidebar-link-child" href="<?=base_url('master/hak-akses')?>">
						<i class="align-middle me-2 far fa-circle"></i>Hak Akses
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Jam Kerja" class="sidebar-link sidebar-link-child" href="<?=base_url('master/jam-kerja')?>">
						<i class="align-middle me-2 far fa-circle"></i>Jam Kerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Hari Libur" class="sidebar-link sidebar-link-child" href="<?=base_url('master/hari-libur')?>">
						<i class="align-middle me-2 far fa-circle"></i>Hari Libur
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Hari Libur" class="sidebar-link sidebar-link-child" href="<?=base_url('master/lock-tpp')?>">
						<i class="align-middle me-2 far fa-circle"></i>Lock TPP
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Hari Libur" class="sidebar-link sidebar-link-child" href="<?=base_url('master/syarat-layanan')?>">
						<i class="align-middle me-2 far fa-circle"></i>Syarat Layanan
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Hari Libur" class="sidebar-link sidebar-link-child" href="<?=base_url('master/announcement')?>">
						<i class="align-middle me-2 far fa-circle"></i>Announcement
					</a>
				</li>
				
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>	
		<li class="sidebar-item ">
			<a title="Manajemen User" data-bs-target="#user-management" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa-users"></i> 
				<span class="align-middle">
					Manajemen User
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="user-management" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				<li class="sidebar-item ">
					<a title="User" class="sidebar-link sidebar-link-child" href="<?=base_url('users')?>">
						<i class="align-middle me-2 far fa-circle"></i>User
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Roles" class="sidebar-link sidebar-link-child" href="<?=base_url('roles')?>">
						<i class="align-middle me-2 far fa-circle"></i>Roles
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="Roles" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/tambah')?>">
						<i class="align-middle me-2 far fa-circle"></i>Tambah Pegawai
					</a>
				</li>
			</ul>
		</li>
	<?php } ?>
	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
		<a title="SIASN" data-bs-target="#siasn" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-users-cog"></i> 
			<span class="align-middle">SIASN
				<i class="fa fa-chevron-down" 
				style="
					position: absolute;
					right: 0;
					margin-top: .35rem;"></i>
			</span>
		</a>
		<ul id="siasn" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
			<li class="sidebar-item ">
				<a title="Mapping Unor" class="sidebar-link sidebar-link-child" href="<?=base_url('siasn/mapping/unor')?>">
					<i class="align-middle me-2 far fa-circle"></i>Mapping Unor
				</a>
			</li>
			<li class="sidebar-item ">
				<a title="Mapping Bidang" class="sidebar-link sidebar-link-child" href="<?=base_url('siasn/mapping/bidang')?>">
					<i class="align-middle me-2 far fa-circle"></i>Mapping Bidang
				</a>
			</li>
			<li class="sidebar-item ">
				<a title="Mapping Jabatan" class="sidebar-link sidebar-link-child" href="<?=base_url('siasn/mapping/jabatan')?>">
					<i class="align-middle me-2 far fa-circle"></i>Mapping Jabatan
				</a>
			</li>
		</ul>
	<?php } ?>

	<li class="sidebar-header">
		Kepegawaian
	</li>
	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->getId() == 193){ ?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>walikota/dashboard">
				<i class="fa fa-desktop"></i> <span class="align-middle">Live Absen Event</span>
			</a>
		</li>
	<?php } ?>
	<?php if($this->general_library->isProgrammer() 
	|| $this->general_library->isAdminAplikasi() 
	// || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
	|| $this->general_library->isPegawaiBkpsdm() || $this->general_library->isWalikota()
	){ ?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>database">
				<i class="fa fa-database"></i> <span class="align-middle">Database</span>
			</a>
		</li>
		<li class="sidebar-item">
			<a title="Perangkat Daerah" class="sidebar-link" href="<?=base_url('master/perangkat-daerah')?>">
				<i class="fa fa-database"></i> <span class="align-middle">Perangkat Daerah</span>
			</a>
		</li>
		<?php if(!$this->general_library->isWalikota()){ ?>
		<li class="sidebar-item">
			<a title="Nomor Surat" class="sidebar-link" href="<?=base_url('kepegawaian/nomor-surat')?>">
				<i class="fa fa-database"></i> <span class="align-middle">Nomor Surat</span>
			</a>
		</li>
		<?php } ?>
	<?php } ?>
	<?php
		if($this->general_library->isProgrammer() 
		|| $this->general_library->isAdminAplikasi() 
		|| $this->general_library->isWalikota() 
		// || $this->general_library->isWakilWalikota()
		|| isKasubKepegawaian($this->general_library->getNamaJabatan(), $this->general_library->getEselon())
		){ 
	?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>pdm/dashboard">
				<i class="fas fa-fw fas fa-tachometer-alt"></i> <span class="align-middle">Dashboard PDM</span>
			</a>
		</li>
	<?php
		}
	?>
	<?php if(!$this->general_library->isWalikota()){ ?>
	<li class="sidebar-item">
		<!-- <a class="sidebar-link" href="<?=base_url();?>kepegawaian/layanan"> -->
		<a title="Layanan" data-bs-target="#layanan" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-folder-open"></i> 
			<span class="align-middle">Layanan
				<i class="fa fa-chevron-down" 
				style="
					position: absolute;
					right: 0;
					margin-top: .35rem;"></i>
			</span>
		</a>
			<ul id="layanan" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
		<?php 
			if(
				$this->general_library->isProgrammer()
				// || $this->general_library->isPegawaiBkpsdm()
			)
			{ ?>
				
			<li class="sidebar-item ">
				<a title="Permohonan Cuti" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/permohonan-cuti')?>">
					<i class="align-middle me-2 far fa-circle"></i>Permohonan Cuti
				</a>
			</li>
		
		<?php } ?>
		<li class="sidebar-item ">
					<a title="Layanan Karis Karsu" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/layanan-karis-karsu')?>">
						<i class="align-middle me-2 far fa-circle"></i>Karis/Karsu
					</a>
		</li>

   <?php if($this->general_library->isAdminAplikasi()) { ?>
		<li class="sidebar-item">
								<a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link sidebar-link-child" aria-expanded="true">
								<i class="align-middle me-2 far fa-circle"></i>Pensiun <i class="fa fa-chevron-down" 
				style="position: absolute;
					right: 0;
					margin-top: .35rem;"></i></a>
								<ul id="multi-2" class="sidebar-dropdown list-unstyled collapse" style="">
									
									<li class="sidebar-item sub-sidebar-item">
									<a class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/layanan-pensiun/8')?>"><i class="fa fa-minus"></i>Pensiun Janda/Duda</a>
									</li>
									<li class="sidebar-item sub-sidebar-item">
									<a class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/layanan-pensiun/9')?>"><i class="fa fa-minus"></i>Pensiun Atas Permintaan Sendiri</a>
									</li>
									<li class="sidebar-item sub-sidebar-item">
									<a class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/layanan-pensiun/10')?>"><i class="fa fa-minus"></i>Pensiun Sakit/Uzur</a>
									</li>
									<li class="sidebar-item sub-sidebar-item">
									<a class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/layanan-pensiun/11')?>"><i class="fa fa-minus"></i>Pensiun Tewas</a>
									</li>
								</ul>
							</li>
		<?php } ?>
		</ul>
	</li>
	<?php } ?>
	<!-- <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() 
	|| $this->general_library->isHakAkses('menu_bidang_pekin') 
	|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN ){ ?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>pelanggaran">
				<i class="fa fa-user-shield"></i><span class="align-middle">Pelanggaran</span>
			</a>
		</li>
	<?php } ?> -->
	<?php
	if($this->general_library->isProgrammer() ||
	$this->general_library->isAdminAplikasi() ||
	$this->general_library->isHakAksesVerifLayanan() ||
	$this->general_library->isHakAkses('verifikasi_pendataan_mandiri') ||
	$this->general_library->isHakAkses('verifikasi_permohonan_cuti') ||
	$this->general_library->isHakAkses('verifikasi_pengajuan_karis_karsu') ||
	$this->general_library->isVerifPermohonanCuti() ||
	$this->general_library->isKepalaPd()) { ?>
		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#verifikasi" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa-check-square"></i> 
				<span class="align-middle">Verifikasi
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="verifikasi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAksesVerifLayanan()){ ?>
				<li class="sidebar-item ">
					<a title="Layanan" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/teknis')?>">
						<i class="align-middle me-2 far fa-circle"></i>Layanan
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('verifikasi_pendataan_mandiri')){ ?>
					<li class="sidebar-item ">
						<a title="Pendataan Data Mandiri" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/dokumen/verifikasi')?>">
							<i class="align-middle me-2 far fa-circle"></i>Pendataan Data Mandiri
						</a>
					</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() ||
				$this->general_library->isAdminAplikasi() || 
				$this->general_library->isHakAkses('verifikasi_permohonan_cuti') ||
				$this->general_library->isKepalaPd() ||
				$this->general_library->isVerifPermohonanCuti()){ ?>
					<?php if($this->general_library->isProgrammer()){ ?>
						<li class="sidebar-item ">
							<a title="Permohonan Cuti" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/verifikasi-permohonan-cuti')?>">
								<i class="align-middle me-2 far fa-circle"></i>Permohonan Cuti
							</a>
						</li>
					<?php } ?>
				<?php } ?>
				<?php if($this->general_library->isHakAkses('verifikasi_pengajuan_karis_karsu')){ ?>
				<li class="sidebar-item ">
						<a title="Permohonan Cuti" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/verifikasi-karis-karsu')?>">
							<i class="align-middle me-2 far fa-circle"></i>Karis/Karsu
				</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isHakAkses('verifikasi_permohonan_pensiun')){ ?>

				<li class="sidebar-item ">
						<a title="Permohonan Cuti" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/verifikasi-pensiun')?>">
							<i class="align-middle me-2 far fa-circle"></i>Pensiun
				</a>
				</li>
				<?php } ?>
				
			</ul>
		</li>
		<?php if($this->general_library->isKepalaBkpsdm() || $this->general_library->isProgrammer()){ ?>
			<li class="sidebar-item">
				<a class="sidebar-link" href="<?=base_url();?>kepegawaian/digital-signature">
				<!-- <a title="Layanan" data-bs-target="#layanan" data-bs-toggle="collapse" class="sidebar-link"> -->
					<i class="align-middle me-2 fa fa-signature"></i> 
					<span class="align-middle">Digital Sign (DS)</span>
				</a>
			</li>
		<?php } ?>
	<?php } ?>

	

	<li class="sidebar-header">
		<!-- Kinerja -->
		 BIDIK ASN JUARA
	</li>

	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>		
	<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>dashboard" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fas fa-tachometer-alt"></i> 
				<span class="align-middle">
				Dashboard
				</span>
			</a>	
		</li>
		<?php } ?>
		<?php if(!$this->general_library->isWalikota()){ ?>
		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#ketpresensi" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-folder"></i> 
				<span class="align-middle">
					Keterangan Presensi
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="ketpresensi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('dokumen-pendukung-absensi/upload')?>">
						<i class="align-middle me-2 far fa-circle"></i>Upload
					</a>
				</li>
				
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('dokumen-pendukung-absensi/tinjau')?>">
						<i class="align-middle me-2 far fa-circle"></i>Peninjauan Absensi
					</a>
				</li>

				<?php if($this->general_library->isHakAkses('verifikasi_peninjauan_absensi')) { ?>

				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('dokumen-pendukung-absensi/verifikasi-tinjau')?>">
						<i class="align-middle me-2 far fa-circle"></i>Verifikasi Peninjauan <br><span class="ml-4">Absensi</span>
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() 
				|| $this->general_library->isHakAkses('menu_bidang_pekin') 
				|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
				|| $this->general_library->isHakAkses('verifikasi_keterangan_presensi') ){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('dokumen-pendukung-absensi/verifikasi')?>">
						<i class="align-middle me-2 far fa-circle"></i>Verifikasi
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() 
				|| $this->general_library->isHakAkses('menu_bidang_pekin') 
				|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
				|| $this->general_library->isHakAkses('verifikasi_keterangan_presensi') ){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('dokumen-pendukung-absensi/hukdis/input')?>">
						<i class="align-middle me-2 far fa-circle"></i>Hukuman Disiplin
					</a>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#rekapitulasi" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-file-archive"></i> 
				<span class="align-middle">
					Rekapitulasi
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="rekapitulasi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
			
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() 
				|| $this->general_library->isHakAkses('menu_bidang_pekin') 
				|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN
				|| $this->general_library->isHakAkses('rekap_absensi_aars') 
				|| $this->general_library->isWalikota()){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekapitulasi/absensi')?>">
						<i class="align-middle me-2 far fa-circle"></i>Absensi
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>		
					<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekapitulasi/realisasi-kinerja')?>">
						<i class="align-middle me-2 far fa-circle"></i>Realisasi Kinerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekapitulasi/penilaian/produktivitas')?>">
						<i class="align-middle me-2 far fa-circle"></i>Penilaian Produktivitas Kerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekapitulasi/penilaian/disiplin')?>">
						<i class="align-middle me-2 far fa-circle"></i>Penilaian Disiplin Kerja
					</a>
				</li>
				<?php } if($this->general_library->getBidangUser() == ID_BIDANG_PEKIN 
				|| $this->general_library->isProgrammer() 
				|| $this->general_library->isAdminAplikasi()
				|| isKasubKepegawaian($this->general_library->getNamaJabatan(), $this->general_library->getEselon())
				|| stringStartWith('Kepala Puskesmas', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Taman', $this->general_library->getNamaJabatan())
				|| $this->general_library->isHakAkses('pengurusan_tpp_perangkat_daerah')
				){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekapitulasi/tpp')?>">
						<i class="align-middle me-2 far fa-circle"></i>TPP
					</a>
				</li>
				<?php } ?>
				<?php if(!$this->general_library->isWalikota()){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('rekap/presensi-pegawai')?>">
						<i class="align-middle me-2 far fa-circle"></i>Presensi
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAkses('verifikasi_pendataan_mandiri')){ ?>		
					<li class="sidebar-item ">
						<a title="Verifikasi PDM" class="sidebar-link sidebar-link-child" href="<?=base_url('rekap/verif-pdm')?>">
							<i class="align-middle me-2 far fa-circle"></i>Verifikasi PDM
						</a>
					</li>
				<?php } ?>
				
				
			</ul>
		</li>
		

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#skbp" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-folder"></i> 
				<span class="align-middle">
					SKBP
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="skbp" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				<?php if(!$this->general_library->isWalikota()){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/rencana')?>">
						<i class="align-middle me-2 far fa-circle"></i>Sasaran Kerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/realisasi')?>">
						<i class="align-middle me-2 far fa-circle"></i>Realisasi Kerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/rekap')?>">
						<i class="align-middle me-2 far fa-circle"></i>Rekap Sasaran Kerja
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/skp-bulanan')?>">
						<i class="align-middle me-2 far fa-circle"></i>Hasil SKBP
					</a>
				</li>
				<?php } ?>
				<?php
				if($this->general_library->isProgrammer() 
				|| $this->general_library->isAdminAplikasi() 
				|| $this->general_library->isPejabatEselon() 
				|| $this->general_library->isKepalaPd()
				|| $this->general_library->isWalikota()
				|| stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Taman', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatanTambahan())
				|| stringStartWith('Kepala Taman', $this->general_library->getNamaJabatanTambahan())
				){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/verifikasi')?>">
						<i class="align-middle me-2 far fa-circle"></i>Verifikasi SKP Pegawai
					</a>
				</li>
				<?php } ?>
				<?php if($this->general_library->isProgrammer() 
				|| $this->general_library->isAdminAplikasi()
				|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN){ ?>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('kinerja/skbp-perangkatdaerah')?>">
						<i class="align-middle me-2 far fa-circle"></i>SKBP Perangkat Daerah
					</a>
				</li>
				<?php } ?>
			</ul>
		</li>

	<!-- <?php
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
						<?php } if($l['child']){ ?>
							<a title="<?=$l['nama_menu']?>" data-bs-target="#menu<?=$l['id']?>" data-bs-toggle="collapse" class="sidebar-link">
							<i class="align-middle me-2 fa fa-fw <?=$l['icon']?>"></i> 
							<span class="align-middle">
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
	</li> -->
	<?php } ?>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
	
    <li class="sidebar-header">
		<!-- Manajemen Talenta -->
		 SIPANTAS
	</li>
	<?php if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('manajemen_talenta') || $this->general_library->isGuest()){ ?>
	
	<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#datamaster" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-database"></i> 
				<span class="align-middle">
					Data Master
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="datamaster" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/data-master-indikator')?>">
						<i class="align-middle me-2 far fa-circle"></i>Indikator
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/data-master-interval')?>">
						<i class="align-middle me-2 far fa-circle"></i>Interval
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/data-master-jabatan')?>">
						<i class="align-middle me-2 far fa-circle"></i>Jabatan
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/data-rumpun')?>">
						<i class="align-middle me-2 far fa-circle"></i>Rumpun Jabatan
					</a>
				</li>
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-kosong')?>">
						<i class="align-middle me-2 far fa-circle"></i>Jabatan Kosong
					</a>
				</li>
				 -->
				
			</ul>
		</li>

	

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#datapkinerja" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-check-square"></i> 
				<span class="align-middle">
					Penilaian Kinerja
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="datapkinerja" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-kinerja/1')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Pengawas
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-kinerja/2')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Administrator
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-kinerja/3')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian JPT
					</a>
				</li>
			
	
				
			</ul>
		</li>

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#datappotensial" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-tasks"></i> 
				<span class="align-middle">
					Penilaian Potensial
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="datappotensial" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-potensial/1')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Pengawas
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-potensial/2')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Administrator
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/penilaian-potensial/3')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian JPT
					</a>
				</li>
		
			</ul>
		</li>


		<!-- <li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-kinerja" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-check-square"></i> 
				<span class="align-middle">
				Penilaian Kinerja
				</span>
			</a>	
		</li> -->
		<!-- <li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-potensial" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fas fa-tasks"></i> 
				<span class="align-middle">
				Penilaian Potensial
				</span>
			</a>	
		</li> -->

		<!-- <li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/ninebox" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-th"></i> 
				<span class="align-middle">
				Talent Pool
				</span>
			</a>	
		</li> -->

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#talentpool" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-tasks"></i> 
				<span class="align-middle">
				Talent Pool
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="talentpool" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/ninebox/1')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Pengawas
					</a>
				</li> -->
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/ninebox/2')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Administrator
					</a>
				</li>
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/ninebox/3')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian JPT
					</a>
				</li>
		
			</ul>
		</li>

		<!-- <li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/jabatan-target" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-id-badge"></i> 
				<span class="align-middle">
				Jabatan Target
				</span>
			</a>	
		</li> -->

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#jatar" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-tasks"></i> 
				<span class="align-middle">
					Jabatan Target
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="jatar" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-target/1')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Pengawas
					</a>
				</li> -->
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-target/2')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Administrator
					</a>
				</li> -->
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-target/3')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian JPT
					</a>
				</li>
			</ul>
		</li>

		<!-- <li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/profil-talenta" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-user"></i> 
				<span class="align-middle">
				Profil Talenta
				</span>
			</a>	
		</li> -->

		<li class="sidebar-item ">
			<a title="Verifikasi" data-bs-target="#ptalenta" data-bs-toggle="collapse" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-tasks"></i> 
				<span class="align-middle">
				Profil Talenta
					<i class="fa fa-chevron-down" 
					style="
						position: absolute;
						right: 0;
						margin-top: .35rem;"></i>
				</span>
			</a>
			<ul id="ptalenta" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
				
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-target/1')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Pengawas
					</a>
				</li> -->
				<!-- <li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/jabatan-target/2')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian Administrator
					</a>
				</li> -->
				<li class="sidebar-item ">
					<a title="indikator" class="sidebar-link sidebar-link-child" href="<?=base_url('mt/profil-talenta/3')?>">
						<i class="align-middle me-2 far fa-circle"></i>Pengisian JPT
					</a>
				</li>
			</ul>
		</li>

		<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-kompetensi" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-users"></i> 
				<span class="align-middle">
				Rencana Suksesi
				</span>
			</a>	
		</li>
		<?php } ?>
		<?php
				if($this->general_library->isProgrammer() 
				|| $this->general_library->isAdminAplikasi() 
				|| $this->general_library->isPejabatEselon() 
				|| $this->general_library->isKepalaPd()
				|| $this->general_library->isWalikota()
				|| stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatan())
				|| stringStartWith('Kepala Taman', $this->general_library->getNamaJabatan())
				){ ?>

			<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-pimpinan/" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-edit"></i> 
				<span class="align-middle">
				Pertimbangan Pimpinan
					</span>
				</a>	
			</li>

			
				<?php } ?>
				
			<?php if($this->general_library->isHakAkses('manajemen_talenta'))
			// { 
			?>
			<?php if(!$this->general_library->isWalikota()) { ?>
			<li class="sidebar-item ">
				<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-sejawat/" class="sidebar-link">
				<i class="align-middle me-2 fa fa-fw fa fa-edit"></i> 
					<span class="align-middle">
					Penilaian Sejawat
					</span>
				</a>	
			</li>
			<?php 
		    // }
		    ?>
			<?php } ?>	
			<?php if($this->general_library->isHakAkses('admin_simponi_asn'))
			{ 
			?>	
				<li class="sidebar-header">
					Simponi ASN
				</li>
				<li class="sidebar-item ">
					<a title="Verifikasi" href="<?=base_url();?>list-pegawai/pensiun" class="sidebar-link">
					<i class="align-middle me-2 fa fa-fw fa fa-users"></i> 
						<span class="align-middle">
						Data Pensiun
						</span>
					</a>	
				</li>
			<?php 
		    }
		    ?>
			<?php if($this->general_library->isHakAkses('download_berkas_tpp_bkad') || $this->general_library->isProgrammer()){?>
				<li class="sidebar-header">
					Menu BKAD
				</li>
				<li class="sidebar-item">
					<a title="Menu BKAD" href="<?=base_url();?>bkad/rekapitulasi/tpp/format-bkad" class="sidebar-link">
					<i class="align-middle me-2 fa fa-fw fa fa-file"></i> 
						<span class="align-middle">
							Format TPP BKAD
						</span>
					</a>	
				</li>
				<li class="sidebar-item">
					<a title="Menu BKAD" href="<?=base_url();?>bkad/upload-gaji" class="sidebar-link">
					<i class="align-middle me-2 fa fa-fw fa fa-file-upload"></i> 
						<span class="align-middle">
							Upload Gaji
						</span>
					</a>	
				</li>
			<?php } ?>
		

		

	


			

</ul>
<div class="mt-5">
	<p></p>
</div>

<script>
	$(function(){
		<?php if(!$tpp && !$this->general_library->isWalikota()){ ?>
			loadLiveTpp()
		<?php } ?>
	})

	function loadLiveTpp(){
		$.ajax({
			url: '<?=base_url("login/C_Login/loadLiveTpp")?>',
			method: 'post',
			data: $(this).serialize(),
			success: function(rs){
				let data = JSON.parse(rs)
				$('#span_capaian_tpp').html((data.capaian_tpp))
				$('#pagu_tpp').html(' / '+data.pagu_tpp.pagu_tpp)
			}, error: function(e){
				errortoast('Terjadi Kesalahan')
			}
		})
	}

	function formatRupiah(angka, prefix = "Rp ") {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }
	
	function openDetailTppPegawai(){
		window.location = "<?=base_url('pegawai/tpp/detail')?>"
	}
</script>