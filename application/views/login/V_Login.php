<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=TITLES?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<!-- <link rel="icon" type="image/png" href="assets/new_login/images/icons/favicon.ico"/> -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/new_login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/new_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/new_login/css/main.css">
	<link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
    <link rel="shortcut icon" href="<?=base_url('')?>assets/adminkit/img/iconSiladen.png" />

<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form  validate-form" method="post" action="<?=base_url('login/C_Login/authenticateAdmin')?>">
					<div class="login-form-web">
						<span class="login100-form-title p-b-10">
							SELAMAT DATANG !
						</span>
						<center>
							<img style="height: 10vh; border-radius: 5px;" class="mb-4 bg-light p-1" src="<?=base_url('')?>assets/new_login/images/logoSiladen.png"/>
						</center>
						<div class="wrap-input100 validate-input" data-validate = "Username Anda">
							<input class="input100" type="text" name="username">
							<span class="focus-input100"></span>
							<span class="label-input100">Username</span>
						</div>
						
						
						<div class="wrap-input100 validate-input" data-validate="Password Anda">
							<input class="input100" type="password" name="password">
							<span class="focus-input100"></span>
							<span class="label-input100">Password</span>
						</div>

						<div class="flex-sb-m w-full p-t-3 p-b-32">
							<!-- <div class="contact100-form-checkbox">
								<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
								<label class="label-checkbox100" for="ckb1">
									Remember me
								</label>
							</div>

							<div>
								<a href="assets/new_login/#" class="txt1">
									Forgot Password?
								</a>
							</div> -->
						</div>
				

						<div class="container-login100-form-btn">
							<button type="submit" class="login100-form-btn">
								Login
							</button>
						</div>

						<div class="text-center p-t-30">
							<span class="txt2">
								<?=COPYRIGHT?>
							</span>
						</div>

						<!-- <div class="login100-form-social flex-c-m">
							<a href="assets/new_login/#" class="login100-form-social-item flex-c-m bg1 m-r-5">
								<i class="fa fa-facebook-f" aria-hidden="true"></i>
							</a>

							<a href="assets/new_login/#" class="login100-form-social-item flex-c-m bg2 m-r-5">
								<i class="fa fa-twitter" aria-hidden="true"></i>
							</a>
						</div> -->
					</div>
				</form>
				<div class="login100-more" style="background-image: url('assets/new_login/images/bg-02.png');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/new_login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/new_login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/new_login/js/main.js"></script>

</body>
</html>
<script src="assets/new_login/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="<?=base_url('plugins/sweetalert2/sweetalert2.min.js')?>"></script>

<script>
	$(function(){
	function errortoast(message = '', timertoast = 3000){
		const Toast = Swal.mixin({
		toast: true,
		position: 'top',
		showConfirmButton: false,
		timer: timertoast
		});

		Toast.fire({
		icon: 'error',
		title: message
		})
	}

	console.log('message = <?=$this->session->flashdata('message');?>')

    <?php if($this->session->flashdata('message')){ ?>
		errortoast("<?=$this->session->flashdata('message')?>");
    //   $('#error_div').show()
    //   $('#error_div').append('<label>'+'<?=$this->session->flashdata('message')?>'+'</label>')
    <?php
      $this->session->set_flashdata('message', null);
    } ?>
  })

  function errortoast(message = '', timertoast = 3000){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: timertoast
    });

    Toast.fire({
      icon: 'error',
      title: message
    })
  }
</script>