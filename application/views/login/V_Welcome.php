<?php
  $params_exp_app = $this->general_library->getParams('PARAM_EXP_APP');
  $list_role = $this->general_library->getListRole();
  $active_role = $this->general_library->getActiveRole();
?>
<style>
  #profile_pict {
      max-width: 150px;
      max-height: 150px;
      animation: zoom-in-zoom-out 5s ease infinite;
  }

  @keyframes zoom-in-zoom-out {
    0% {
      transform: scale(1, 1);
    }
    50% {
      transform: scale(1.1, 1.1);
    }
    100% {
      transform: scale(1, 1);
    }
  }

  .info_card:hover{
    cursor: pointer;
    transition: .2s;
    background-color: #ececed;
  }
</style>

<div class="container-fluid p-0">
  <div class="row">
      <div class="col-12">
        <style>

          img.logo {
            height: 200px; width: 400px; margin-bottom:20px;
          }
          @media screen and (max-width: 600px) {
          h4 {
            font-size: 17px;
          /* display:none; */
          }

          img.logo {
            /* height: 150px;  */
            height : auto;
            width: 2509px; 
            /* height: 100%; 
            width: 200%; */
            /* margin-left: 50;  */
            margin-bottom:20px;
            /* display:none; */
          }
      
        }
        </style>
        <?php if($this->general_library->getRole() == 'programmer'){ ?>
          <div class="row">
            <div class="col-lg-12">
              <?php
                $data['chart'] = $chart; 
                $this->load->view('dashboard/V_DashboardKepegawaian', $data);
              ?>
            </div>
            <div class="col-lg-12 mt-2" id="dashboard_pdm_welcome">
            </div>
          </div>
        <?php } else { ?>
          <h4><?="Selamat ".greeting().","?></h4>
          <strong><h1 class="nmuser font-weight-bold"><?=$this->general_library->getNamaUser()?></h1></strong>
          <?php $this->load->view('user/V_Pdm', null); ?>
          <!-- <center>
            <h3>Welcome to</h3>
              <div style="z-index:0;">
                <img style="height : auto;
                          width: 300px; 
                            margin-bottom:20px;"  class="" src="assets/adminkit/img/logo-siladen-new-with-text.png" />
              </div>
          
            <h4><strong class="nmuser"><?=$this->general_library->getNamaUser();?></strong></h4>
            <img class="img-circle elevation-2" id="profile_pict" style="max-width: 100px; max-height: 100px;" src="<?=$this->general_library->getProfilePicture()?>" alt="User Image">
          </center> -->
        <?php } ?>
      </div>
      <!-- <div class="col-12 text-center">
          <h4 style="font-weight: bold;" id="live_date_time_welcome" class="nav-link"></h4>
      </div> -->
      
  </div>
</div>
<script>
  $(function(){
    <?php if($this->session->userdata('apps_error')){ ?>
			errortoast("<?=$this->session->userdata('apps_error')?>");
		//   $('#error_div').show()
		//   $('#error_div').append('<label>'+'<?=$this->session->userdata('apps_error')?>'+'</label>')
		<?php
		$this->session->set_userdata('apps_error', null);
		} ?>
    loadDashboardPdmWelcome();
  })

  function loadDashboardPdmWelcome(){
      $('#dashboard_pdm_welcome').html('')
      $('#dashboard_pdm_welcome').append(divLoaderNavy)
      $('#dashboard_pdm_welcome').load('<?=base_url('dashboard/C_Dashboard/getDashboardPdmAll')?>', function(){
          $('#loader').hide()
      })
  }
</script>
