<!doctype html>
<html lang="en-us">

    <head>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <title>Siladen</title>
        <meta name="description" content="">

        <!-- The compiled CSS file -->
		
        <link rel="stylesheet" href="<?=base_url('')?>assets/login/css/production.css">

        <!-- Web fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700|Source+Serif+Pro:700" rel="stylesheet"> 

        <!-- favicon.ico. Place these in the root directory. -->
        <link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="<?=base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
    <link rel="shortcut icon" href="<?=base_url('')?>assets/adminkit/img/iconSiladen.png" />

    </head>
<style>
.textCustom{
            color:aliceblue;
        }

        .img-hover-zoom {
  height: 300px; /* [1.1] Set it as per your need */
  overflow: hidden; /* [1.2] Hide the overflowing of child elements */
}

/* [2] Transition property for smooth transformation of images */
.img-hover-zoom img {
  transition: transform .5s ease;
}

/* [3] Finally, transforming the image when container gets hovered */
.img-hover-zoom :hover img {
  transform: scale(1.5);
}
.zoom:hover { 
    transform: scale(1.5);
    transition: transform .5s ease;
}

.logoBkd{
    height: auto;max-width: 70%;
}


@media screen and (width> 600px) {
.logoBkd{
    height: auto;max-width: 40%;
}
}

/* @media screen and (width< 600px) {
.logoBkd{
    height: auto;max-width: 70%;
}
} */




    </style>
    <body class="has-animations">


    <!-- Header -->
    <header class="align--center pt2">
        <div class="container--lg border--bottom pb2">
            <img class="logo mb-1 reveal-on-scroll is-revealing  logoBkd" src="<?=base_url('')?>assets/adminkit/img/logoSiladen.png">
        </div>
    </header>

    <main>

        <!-- Feature list -->
        <!-- <div class="container pt3 mt2 text--gray align--center"> -->

            <!-- <div class=" bg--dark-gray align--center textCustom">
            <div class="grid-row pt3">
               
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing">
                    <a href="http://siladen.manadokota.go.id/">
                    <img  class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/connected.svg" alt="Assign to others">
                </a>
                    <p>Layanan Kepegawaian</p>
               
                </div>
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing " >
                    <a href="http://siladen.manadokota.go.id/bidik">
                    <img class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/assign.svg" alt="Stay connected">
                    </a>
                    <p>Pelaporan Kinerja</p>
                </div>
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing">
                    <img class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/search.svg" alt="Powerful search">
                    <p>Sistem Informasi Kepegawaian</p>
                </div>
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing">
                    <img class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/vault.svg" alt="Put in a vault">
                    <p>Put in a vault</p>
                </div>
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing">
                    <img class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/messaging.svg" alt="Fast messaging">
                    <p>Fast messaging</p>
                </div>
                <div class="grid-column span-one-third mb3 reveal-on-scroll is-revealing">
                    <img class="illustration--small mb1 zoom" src="<?=base_url()?>assets/img/mail.svg" alt="Share with others">
                    <p>Share with others</p>
                </div>
            </div>
        </div> -->

        <!-- Focus -->
        <!-- <div class="container--lg pt1 pb1">

            <div class="grid-row grid-row--center">
                <div class="grid-column mt3 mb2 order-2">
                    <div class="border--bottom pb2 mb2">
                        <h2>Usage data</h2>
                        <p>Quis istud possit, inquit, negare? Videamus animi partes, quarum est conspectus illustrior; Illa sunt similia: hebes acies est cuipiam oculorum, corpore alius senescit; Non enim, si omnia non&nbsp;sequebatur.</p>
                    </div>
                    <p class="italic text--gray mb1">Quae quo sunt excelsiores, eo dant clariora indicia naturae. Causa autem fuit huc veniendi ut quosdam&nbsp;hinc.</p>
                    <p class="bold">Carry Andersen, COO at&nbsp;Stripe</p>
                </div>
                <div class="grid-column span-1"></div>
                <div class="grid-column mt3 mb2 order-1 reveal-on-scroll is-revealing">
                    <img src="img/data.svg" alt="Usage data">
                </div>
            </div>

            <div class="grid-row grid-row--center">
                <div class="grid-column mt3 mb2 reveal-on-scroll is-revealing">
                    <img src="img/security.svg" alt="Absolute security">
                </div>
                <div class="grid-column span-1"></div>
                <div class="grid-column mt3 mb2">
                    <div class="border--bottom pb2 mb2">
                        <h2>Absolute security</h2>
                        <p>Itaque his sapiens semper vacabit. Qualis ista philosophia est, quae non interitum afferat pravitatis, sed sit contenta mediocritate vitiorum? Quid de Platone aut de Democrito loquar? Quis istud possit, inquit&nbsp;negare?</p>
                    </div>
                    <p class="italic text--gray mb1">Estne, quaeso, inquam, sitienti in bibendo voluptas? Duo Reges: constructio&nbsp;interrete.</p>
                    <p class="bold">Josh Blenton, Product Manager at&nbsp;Blinkist</p>
                </div>
            </div>
        </div> -->

        <!-- Mentioned -->
        <!-- <div class="container--lg pt3 pb3 mb2 align--center">
            <p class="mb2">Mentioned in</p>
            <span><img class="mentioned" src="img/mentioned.svg" alt="New York Times, TC, Product Hunt, Recode"></span>
        </div> -->

        <!-- CTA -->
        <div class="bg--dark-gray align--center pt1 pb1" style="height:500px;">
            <div class="container pt2 pb2">
                <!-- <img class="cta-image mb1 reveal-on-scroll is-revealing" src="<?=base_url()?>assets/login/img/logo_pemkot.png" alt="Text the app"> -->
            
             <center>
             <p style="margin-left:-10px;" class="h3 text--white mb3 pt2 bold">Selamat Datang</p>
             </center>
                
                <!-- <p class="text--white mb1">Silahkan Login untuk :)</p> -->
                <!-- <p class="text--white  mb2"> <?= $this->session->flashdata('message');?></p> -->
                <!-- <form action="<?= base_url();?>C_Login/home"> -->
                <form class="login100-form validate-form" action="<?=base_url('login/C_Login/authenticateAdmin')?>" method="post">
				<div class="inline-block mr1 no-mr-on-mobile mb1" style="width:280px;max-width:100%">

              
                            <input class="form-control mb2"  name="username"  placeholder="Username">
                
					

                   
                        
                            <input class="form-control mb2" type="password"  name="password"  placeholder="Password">
                
							
						
               
                <button class="btn btn--secondary inline-block mr1 no-mr-on-mobile" >Login</button>
                </form>
				</div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="pt2 pb1 align--center-on-mobile">
        <div class="container">
            <div class="grid-row">
                <div class="grid-column mt2 span-half">
                    <div class="mb1">
                       
                    </div>
                    <p class="small">Copyright © 2023 BKPSDM Manado</p>
                </div>
                <div class="grid-column mt2 span-half align--right align--center-on-mobile">
                    <ul class="no-bullets list--inline">
                        <li class="mr1"><a href="" class="link"><img class="icon" src="<?=base_url()?>assets/login/img/youtube.svg" alt="YouTube"></a></li>
                        <li class="mr1"><a href="" class="link"><img class="icon" src="<?=base_url()?>assets/login/img/instagram.svg" alt="Twitter"></a></li>
                        <li><a href="" class="link"><img class="icon" src="<?=base_url()?>assets/login/img/facebook.svg" alt="Facebook"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll reveal -->
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

    <!-- The compiled JavaScript file -->
    <script src="<?=base_url('')?>assets/login/js/production.js"></script>

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

  $('#showpassword').on('click', function(){
	  $('#div_showpassword').show()
	  $('#div_notshowpassword').hide()
  })

  $('#notshowpassword').on('click', function(){
	$('#div_showpassword').hide()
	  $('#div_notshowpassword').show()
  })

  $('#input_notshowpassword').on('input', function(){
	  $('#input_showpassword').val($(this).val())
  })

  $('#input_showpassword').on('input', function(){
	  $('#input_notshowpassword').val($(this).val())
  })

</script>