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
</style>

<?php
	$tpp = $this->session->userdata('live_tpp');
?>


<ul class="sidebar-nav">
<?php if(!$this->general_library->isProgrammer() AND !$this->general_library->isAdminAplikasi()){ ?>
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
	<li class="sidebar-header">
		Main
	</li>

	<!-- <li class="sidebar-item">
		<a class="sidebar-link" href="#">
			<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
		</a>
	</li> -->
	<li class="sidebar-item">
		<a class="sidebar-link" href="<?=base_url();?>kepegawaian/profil">
			<i class="fa fa-user"></i> <span class="align-middle">Profile</span>
		</a>
	</li>
	<!-- MENU MAIN UNTUK PROGRAMMER -->
	<?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
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
				<li class="sidebar-item ">
					<a title="Perangkat Daerah" class="sidebar-link sidebar-link-child" href="<?=base_url('master/perangkat-daerah')?>">
						<i class="align-middle me-2 far fa-circle"></i>Perangkat Daerah
					</a>
				</li>
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
					<a title="Hari Libur" class="sidebar-link sidebar-link-child" href="<?=base_url('master/hukuman-dinas')?>">
						<i class="align-middle me-2 far fa-circle"></i>Hukuman Dinas
					</a>
				</li>
			</ul>
		</li>
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
	|| $this->general_library->isPegawaiBkpsdm()
	){ ?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>list-pegawai">
				<i class="fa fa-database"></i> <span class="align-middle">Database Pegawai</span>
			</a>
		</li>
		<li class="sidebar-item">
		<a title="Perangkat Daerah" class="sidebar-link" href="<?=base_url('master/perangkat-daerah')?>">
				<i class="fa fa-database"></i> <span class="align-middle">Perangkat Daerah</span>
			</a>
		</li>
	<?php } ?>
	<?php if($this->general_library->isProgrammer() 
	|| $this->general_library->isAdminAplikasi() 
	|| $this->general_library->isWalikota() 
	// || $this->general_library->isWakilWalikota()
	){ ?>
		<li class="sidebar-item">
			<a class="sidebar-link" href="<?=base_url();?>pdm/dashboard">
				<i class="fas fa-fw fas fa-tachometer-alt"></i> <span class="align-middle">Dashboard PDM</span>
			</a>
		</li>
	<?php } ?>
	<li class="sidebar-item">
		<!-- <a class="sidebar-link" href="<?=base_url();?>kepegawaian/layanan"> -->
		<a class="sidebar-link" href="#">
			<i class="fa fa-folder-open"></i> <span class="align-middle">Layanan</span>
		</a>
	</li>
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
	if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isHakAksesVerifLayanan() || $this->general_library->isHakAkses('verifikasi_pendataan_mandiri')) { ?>
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
					<a title="Dokumen Upload" class="sidebar-link sidebar-link-child" href="<?=base_url('kepegawaian/dokumen/verifikasi')?>">
						<i class="align-middle me-2 far fa-circle"></i>Dokumen Upload
					</a>
				</li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
	

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

	</li>
	<?php if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('manajemen_talenta')){ ?>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> -->
	
		<li class="sidebar-header">
		Manajemen Talenta
	</li>
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
				
				
			</ul>
		</li>

		<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/jabatan-target" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-id-badge"></i> 
				<span class="align-middle">
				Jabatan Target
				</span>
			</a>	
		</li>
		<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-kinerja" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-check-square"></i> 
				<span class="align-middle">
				Penilaian Kinerja
				</span>
			</a>	
		</li>
		<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/penilaian-potensial" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fas fa-tasks"></i> 
				<span class="align-middle">
				Penilaian Potensial
				</span>
			</a>	
		</li>
		<li class="sidebar-item ">
			<a title="Verifikasi" href="<?=base_url();?>mt/ninebox" class="sidebar-link">
			<i class="align-middle me-2 fa fa-fw fa fa-th"></i> 
				<span class="align-middle">
				Nine Box
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
		<?php if(!$tpp){ ?>
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