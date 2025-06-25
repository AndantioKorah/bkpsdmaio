<style>
	#search_navbar{
		color: var(--primary-color) !important;
		font-weight: bold !important;
		width: 200px;
		transition: .2s;
	}

	#search_navbar:focus{
		color: var(--primary-color) !important;
		background-color: rgb(255, 255, 255, .1) !important;
		font-weight: bold !important;
		font-size: 1rem !important;
		font-family: Arial !important;
		width: 300px !important;
		transition: .2s;
		box-shadow: 0 0 10px #888888;
	}

	#div_search_result{
		position: fixed;
		width: 300px;
		background-color: white;
		border-top-right-radius: 3px;
		border-top-left-radius: 3px;
		border-bottom-right-radius: 5px;
		border-bottom-right-radius: 5px;
		z-index: 10;
		top: 7%;
		margin-left: 0px;
		box-shadow: 5px 10px 20px #888888;
		max-height: 100vh;
		overflow-y: scroll;
		-ms-overflow-style: none;  /* IE and Edge */
		scrollbar-width: none;  /* Firefox */
	}

	#div_search_result::-webkit-scrollbar {
		display: none;
	}

	.text-dark{
		font-weight: bold;
		color: var(--primary-color);
	}

	.form-control-navbar {
		/* border-right-width: 0; */
	}

	.form-control-navbar + .input-group-append {
		margin-left: 0;
	}

	.form-control-navbar,
	.btn-navbar {
		transition: none;
	}

	.navbar-dark .form-control-navbar,
	.navbar-dark .btn-navbar {
		background-color: rgba(255, 255, 255, 0.2);
		border: 0;
	}

	.navbar-dark .form-control-navbar::-webkit-input-placeholder {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar::-moz-placeholder {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar:-ms-input-placeholder {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar::-ms-input-placeholder {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar::placeholder {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar + .input-group-append > .btn-navbar {
		color: rgba(255, 255, 255, 0.6);
	}

	.navbar-dark .form-control-navbar:focus,
	.navbar-dark .form-control-navbar:focus + .input-group-append .btn-navbar {
		background-color: rgba(255, 255, 255, 0.6);
		border: 0 !important;
		color: #343a40;
	}

	.navbar-light .form-control-navbar,
	.navbar-light .btn-navbar {
		background-color: #f2f4f6;
		border: 0;
	}

	.navbar-light .form-control-navbar::-webkit-input-placeholder {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar::-moz-placeholder {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar:-ms-input-placeholder {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar::-ms-input-placeholder {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar::placeholder {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar + .input-group-append > .btn-navbar {
		color: rgba(0, 0, 0, 0.6);
	}

	.navbar-light .form-control-navbar:focus,
	.navbar-light .form-control-navbar:focus + .input-group-append .btn-navbar {
		background-color: #e9ecef;
		border: 0 !important;
		color: #343a40;
		transition: .2s;
	}
	.list-group{
            overflow-y: initial !important
        }
</style>

<?php
  $list_role = $this->general_library->getListRole();
  $list_notif_layanan = $this->general_library->getListAdminLayanan();
  $list_notif_layanan_pensiun = $this->general_library->getListAdminLayananPensiun();
//   dd( $list_notif_layanan);
  $active_role = $this->general_library->getActiveRole();
?>

<?php if($this->session->userdata('programmer_session')){ ?>
	<div style="
			background-color: #2a7f30;
		" class="row">
		<div class="col-lg-12 p-3 text-right">
			<button id="btn_switch" type="button" onclick="switchToAdmin()" class="btn btn-block btn-warning">
				<i class="fa fa-retweet"></i> SWITCH TO ADMIN</button>
			<button id="btn_switch_loading" disabled type="button" style="display: none;" class="btn btn-block btn-warning">
				<i class="fa fa-spin fa-spinner"></i> Loading...</button>
		</div>
	</div>
<?php } ?>

<nav class="navbar navbar-expand navbar-light navbar-bgx">
	<a class="sidebar-toggle js-sidebar-toggle">
		<button style="border: 1px solid #f5f7fb;background-color: transparent;" id="sidebar_toggle"> <i class="hamburger align-self-center"></i></button>
	</a>
	<?php if(!$this->general_library->isGuest()) { ?>
	<?php if($this->general_library->getRole() == 'programmer' 
	|| $this->general_library->getRole() == 'admin_aplikasi' 
	|| $this->general_library->isHakAkses('akses_profil_pegawai') 
	|| $this->general_library->isKasubagKepegawaianDiknas()
	|| $this->general_library->getBidangUser() == ID_BIDANG_PEKIN 
	|| $this->general_library->getRole() == 'walikota') { ?>
		<?php
			// $number = excelRoundDown(30665.78, 5);
			// echo $number;
		?>
		<form id="form_search_navbar" class="form-inline mr-3">
			<div class="row">
				<div class="div_search_bar">
				<input id="search_navbar" name="search_navbar;" style="width: 300px" autocomplete="off" class="form-control form-control-navbar" type="text" placeholder="Cari Pegawai / Perangkat Daerah" aria-label="Search">
					<!-- <div class="input-group-append"> -->
						<!-- <button id="button_fa_search" class="btn btn-navbar" type="button">
						<i class="fas fa-search"></i>
						</button> -->
						<!-- <button style="display: none;" id="button_fa_loading" class="btn btn-navbar" type="button">
						<i class="fas fa-spin fa-spinner"></i>
						</button> -->
					<!-- </div> -->
				</div>
			</div>
			<div class="row" id="div_search_result">
			</div>
		</form>
	<?php } ?>
	<?php } ?>
	<span style="font-weight: bold; color: var(--primary-color);" id="live_date_time"></span>
	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<!-- <li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<span class="indicator">4</span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
						4 New Notifications
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-danger" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Update completed</div>
									<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
									<div class="text-muted small mt-1">30m ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li> -->
			
			<!-- <li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="message-square"></i>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
					<div class="dropdown-menu-header">
						<div class="position-relative">
							4 New Messages
						</div>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="<?=base_url('')?>assets/adminkit/img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Vanessa Tucker</div>
									<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
									<div class="text-muted small mt-1">15m ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="<?=base_url('')?>assets/adminkit/img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">William Harris</div>
									<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
									<div class="text-muted small mt-1">2h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="<?=base_url('')?>assets/adminkit/img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Christina Mason</div>
									<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
									<div class="text-muted small mt-1">4h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="<?=base_url('')?>assets/adminkit/img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Sharon Lessman</div>
									<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
									<div class="text-muted small mt-1">5h ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all messages</a>
					</div>
				</div>
			</li> -->
			
			<!-- role  -->

			<?php if($this->general_library->isPegawaiBkpsdm()) { ?>
				<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<?php 
									$layanan = 0;
									$layanan2 = 0;
									if($list_notif_layanan){
										$layanan = count($list_notif_layanan);
									}
									if($list_notif_layanan_pensiun){
										$layanan2 = count($list_notif_layanan_pensiun);
									} 
									$total = $layanan + $layanan2;  
									;?>
									
									<?php if($total > 0) { ?>
									<span class="indicator" ><?= $total;?></span>
									<?php } ?>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 tss" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									Notifikasi Baru
								</div>
								<div class="list-group" style="
									width: 100%;
									height: 400px;
									overflow: scroll;">
								<?php foreach($list_notif_layanan as $ly){ ?>
									<a href="<?php echo base_url('kepegawaian/verifikasi-layanan-detail/');?><?=$ly['id_t_layanan']?>/<?=$ly['id_m_layanan']?>" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark"><?=$ly['nama_layanan']?></div>
												<div class="text-muted small mt-1">Pengajuan layanan belum diverifikasi. <br>a.n. <?=$ly['nama']?></div>
												<div class="text-muted small mt-1"><?=formatDateNamaBulan($ly['tanggal_pengajuan'])?></div>
											</div>
										</div>
									</a>
									<?php } ?>
									<?php foreach($list_notif_layanan_pensiun as $ly){ ?>
									<a href="<?php echo base_url('kepegawaian/pensiun/kelengkapan-berkas/');?><?=$ly['username']?>" class="list-group-item">
									<!-- <a href="<?php echo base_url('kepegawaian/verifikasi-pensiun-detail/');?><?=$ly['id_t_layanan']?>/<?=$ly['jenis_pensiun']?>" class="list-group-item"> -->

										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark"><?=$ly['nama_layanan']?></div>
												<div class="text-muted small mt-1">Pengajuan layanan belum diverifikasi. <br>a.n. <?=$ly['nama']?></div>
												<div class="text-muted small mt-1"><?=formatDateNamaBulan($ly['tanggal_pengajuan'])?></div>
											</div>
										</div>
									</a>
									<?php } ?>
								</div>
							</div>
				</li>
				<?php } ?>	
			<?php 
			$cari_role = array_search("admin_aplikasi", array_column($list_role, 'role_name'));
			if($cari_role == false){ ?>	
			
				<a class="nav-link  d-none d-sm-inline-block" href="#" >
				<i class="align-middle" data-feather="user-check"></i> <span class="text-dark"> <?php if($this->general_library->isWalikota()) echo $active_role['nama']; else echo "Pegawai"  ?>  </span>
				</a>
			<?php } else { ?>
				
				<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="align-middle" data-feather="user-check"></i>
				</a>

				
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
				<i class="align-middle" data-feather="user-check"></i> <span class="text-dark"> <?=$active_role['nama']?>  </span>
				</a>

				<div class="dropdown-menu dropdown-menu-end">
				<?php foreach($list_role as $lr){ ?>
					<a onclick="setActiveRole('<?=$lr['id']?>')" class="dropdown-item">
					<?=$lr['id'] == $this->session->userdata('active_role_id') ? '<i class="fa fa-check-circle"></i> '.$lr['nama'] : $lr['nama']?>
				</a>
					<?php } ?>
				</div>
			</li>
			<?php } ?>
				
			

			

			<!-- tutup role  -->

			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
				<i class="align-middle" data-feather="settings"></i>
			</a>
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
				<img src="<?=$this->general_library->getProfilePicture()?>" style="border-radius: 50% !important; object-fit: cover;" 
				class="avatar img-fluid rounded me-1" alt="" /> 
				<!-- <span class="text-dark"><?=$this->general_library->getNamaUser();?></span> -->
			</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="#"><i class="align-middle me-1"></i><?=$this->general_library->getNamaUser();?> </a>
						<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?=base_url('user/password/change')?>"><i class="align-middle me-1 fa fa-key"></i> Ubah Password</a>
					<!-- <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
					<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
					<div class="dropdown-divider"></div> -->
					<!-- <a class="dropdown-item" href="<?=base_url('logout')?>">
						<i class="align-middle me-2 fa fa-sign-out-alt"></i> <span class="align-middle"><?=greeting()?></span>
					</a> -->
					<a class="dropdown-item" href="<?=base_url('logout')?>">
						<i class="align-middle me-2 fa fa-sign-out-alt"></i> <span class="align-middle">Log Out</span>
					</a>
				</div>
			</li>
		</ul>
	</div>
</nav>

<script>
	$(function(){

	})

	function switchToAdmin(){
		$('#btn_switch').hide()
		$('#btn_switch_loading').show()
		$.ajax({
			url : "<?php echo base_url('login/C_Login/switchToAdmin');?>",
			method : "POST",
			dataType : 'json',
			success: function(data){
				$('#btn_switch').show()
				$('#btn_switch_loading').hide()
				window.location.href = "<?=base_url('welcome')?>";
			}, error: function(err){
				$('#btn_switch').show()
				$('#btn_switch_loading').hide()
				// errortoast(err)
				window.location.href = "<?=base_url('welcome')?>";
			}
		});
	}

	$(document).mouseup(function(e) 
    {
        var container = $("#search_navbar");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
          $('#div_search_result').hide()
        } else {
          $('#div_search_result').show()
        }
    });

	function setActiveRole(id){
      $.ajax({
          url: '<?=base_url("user/C_User/setActiveRole")?>'+'/'+id,
          method: 'post',
          data: $(this).serialize(),
          success: function(data){
              window.location=data.trim()
          }, error: function(e){
              errortoast('Terjadi Kesalahan')
          }
      })
    }

	$('#search_navbar').on('input', function(){
		$('#div_search_result').html('')
		setTimeout(()=> {
			if($(this).val() != ''){
				// $('#button_fa_search').hide()
				// $('#button_fa_loading').show()
				$.ajax({
					url: '<?=base_url("user/C_User/searchPegawaiNavbar")?>',
					method: 'post',
					data: {
					search_param: $(this).val()
					},
					success: function(datares){
						$('#div_search_result').html('')
						$('#div_search_result').append(datares)
						// $('#button_fa_search').show()
						// $('#button_fa_loading').hide()
					}, error: function(e){
						errortoast('Terjadi Kesalahan')
					}
				})
			}
		}
      ,500);
    })

	$('#form_search_navbar').on('submit', function(e){
		let base_url = '<?=base_url()?>'
		e.preventDefault()
		window.location = base_url + 'database/'+$('#search_navbar').val()
	})
</script>