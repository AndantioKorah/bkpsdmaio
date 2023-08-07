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
            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Jumlah Pegawai</h5>
                    </div>
                    <div class="col-auto">
                      <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div>
                    </div>
                  </div>
                  <h1 class="mt-1 mb-3" id="h1_total_pegawai"><?=$chart['total']?></h1>
                  <div class="mb-0">
                    <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                    <span class="text-muted">Per Hari Ini</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="row">
                <div class="col-lg-4">
                  <div onclick="openPensiunCardDetail()" class="card info_card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col mt-0 ml-0">
                          <h5 class="card-title">Pensiun</h5>
                        </div>
                        <div class="col-auto">
                          <div class="stat text-primary">
                            <i class="align-middle fa fa-user-slash" ></i>
                          </div>
                        </div>
                      </div>
                      <h1 class="mt-1 mb-3" id="h1_pensiun"><i class="fa fa-spin fa-spinner"></i></h1>
                      <div class="mb-0">
                        <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                        <span class="text-muted">Tahun <?=date('Y')?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div onclick="openNaikPangkatCardDetail()" class="card info_card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col mt-0 ml-0">
                          <h5 class="card-title">Naik Pangkat</h5>
                        </div>
                        <div class="col-auto">
                          <div class="stat text-primary">
                            <i class="align-middle fa fa-upload" ></i>
                          </div>
                        </div>
                      </div>
                      <h1 class="mt-1 mb-3" id="h1_pangkat"><i class="fa fa-spin fa-spinner"></i></h1>
                      <div class="mb-0">
                        <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                        <span class="text-muted">Tahun <?=date('Y')?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div onclick="openGajiBerkalaCardDetail()" class="card info_card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col mt-0 ml-0">
                          <h5 class="card-title">Gaji Berkala</h5>
                        </div>
                        <div class="col-auto">
                          <div class="stat text-primary">
                            <i class="align-middle fa fa-money-bill" ></i>
                          </div>
                        </div>
                      </div>
                      <h1 class="mt-1 mb-3" id="h1_gaji_berkala"><i class="fa fa-spin fa-spinner"></i></h1>
                      <div class="mb-0">
                        <!-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> -->
                        <span class="text-muted">Tahun <?=date('Y')?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12 mt-0 ml-0">
                      <h5 class="card-title">Jenis Kelamin</h5>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_jenis_kelamin['result'] = $chart['jenis_kelamin'];
                      $data_jenis_kelamin['id_chart'] = 'chart_jenis_kelamin';
                      $this->load->view('login/V_ChartPieDashboard', $data_jenis_kelamin);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Agama</h5>
                    </div>
                    <div class="col-auto">
                      <!-- <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_agama['result'] = $chart['agama'];
                      $data_agama['id_chart'] = 'chart_agama';
                      // dd($data_agama);
                      $this->load->view('login/V_ChartPieDashboard', $data_agama);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Status Pegawai</h5>
                    </div>
                    <div class="col-auto">
                      <!-- <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_statuspeg['result'] = $chart['statuspeg'];
                      $data_statuspeg['id_chart'] = 'chart_statuspeg';
                      $this->load->view('login/V_ChartPieDashboard', $data_statuspeg);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Golongan</h5>
                    </div>
                    <div class="col-auto">
                      <!-- <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_golongan['result'] = $chart['golongan'];
                      $data_golongan['id_chart'] = 'chart_golongan';
                      $this->load->view('login/V_ChartPieDashboard', $data_golongan);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Eselon</h5>
                    </div>
                    <div class="col-auto">
                      <!-- <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_eselon['result'] = $chart['eselon'];
                      $data_eselon['id_chart'] = 'chart_eselon';
                      $this->load->view('login/V_ChartPieDashboard', $data_eselon);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col mt-0 ml-0">
                      <h5 class="card-title">Pendidikan</h5>
                    </div>
                    <div class="col-auto">
                      <!-- <div class="stat text-primary">
                        <i class="align-middle fa fa-users" ></i>
                      </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <?php
                      $data_pendidikan['result'] = $chart['pendidikan'];
                      $data_pendidikan['id_chart'] = 'chart_pendidikan';
                      $this->load->view('login/V_ChartPieDashboard', $data_pendidikan);
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- <script src="<?=base_url('')?>assets/adminkit/js/app.js"></script> -->
          <!-- <script src="js/app.js"></script> -->
          
          <script>
              $(function(){
                getJumlahPensiun()
                getJumlahNaikpangkat()
                getJumlahGajiBerkala()
                // getDataDashboardAdmin()
                renderChart('<?=json_encode($data_jenis_kelamin)?>')
                renderChart('<?=json_encode($data_agama)?>')
                renderChart('<?=json_encode($data_statuspeg)?>')
                renderChart('<?=json_encode($data_golongan)?>')
                renderChart('<?=json_encode($data_eselon)?>')
                renderChart('<?=json_encode($data_pendidikan)?>')

              })

              function renderChart(rs){
                let dt = JSON.parse(rs)
                // document.addEventListener("DOMContentLoaded", function() {
                  let labels = [];
                  let values = [];
                  let temp = Object.keys(dt.result)
                  temp.forEach(function(i) {
                    if(dt.result[i].jumlah > 0){
                      labels.push(dt.result[i].nama)
                      values.push(dt.result[i].jumlah)
                    }
                  })
                  console.log(labels)

                  let colors = JSON.parse('<?=json_encode(CHART_COLORS)?>')                
                  // let data_labels = 
                  new Chart(document.getElementById(dt.id_chart), {
                    type: "doughnut",
                    data: {
                      labels: labels,
                      datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderColor: "transparent"
                      }]
                    },
                    options: {
                      maintainAspectRatio: false,
                      legend: {
                        display: false
                      }
                    }
                  });
                // });
              }

              function openPensiunCardDetail(){
                window.location="<?=base_url('list-pegawai/pensiun')?>"
              }

              function openNaikPangkatCardDetail(){
                window.location="<?=base_url('list-pegawai/naik-pangkat')?>"
              }

              function openGajiBerkalaCardDetail(){
                window.location="<?=base_url('list-pegawai/gaji-berkala')?>"
              }

              function getJumlahPensiun(){
                $('#h1_pensiun').html('<i class="fa fa-spin fa-spinner"></i>')
                $.ajax({
                  url: '<?=base_url("user/C_User/getListPegawaiPensiunByYear/1")?>',
                  method: 'post',
                  data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>'
                  },
                  success: function(data){
                    let rs = JSON.parse(data)
                    console.log(rs)
                    $('#h1_pensiun').html(rs.total)
                  }, error: function(e){
                      errortoast('Terjadi Kesalahan')
                      console.log(e)
                  }
                })
              }

              function getJumlahNaikpangkat(){
                $('#h1_pangkat').html('<i class="fa fa-spin fa-spinner"></i>')
                $.ajax({
                  url: '<?=base_url("user/C_User/getListPegawaiNaikPangkatByYear/1")?>',
                  method: 'post',
                  data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>'
                  },
                  success: function(data){
                    let rs = JSON.parse(data)
                    // console.log(data)
                    $('#h1_pangkat').html(rs.total)
                  }, error: function(e){
                      errortoast('Terjadi Kesalahan')
                      console.log(e)
                  }
                })
              }

              function getJumlahGajiBerkala(){
                $('#h1_gaji_berkala').html('<i class="fa fa-spin fa-spinner"></i>')
                $.ajax({
                  url: '<?=base_url("user/C_User/getListPegawaiGajiBerkalaByYear/1")?>',
                  method: 'post',
                  data: {
                    eselon: 0,
                    pangkat: 0,
                    tahun: '<?=date('Y')?>'
                  },
                  success: function(data){
                    let rs = JSON.parse(data)
                    // console.log(data)
                    $('#h1_gaji_berkala').html(rs.total)
                  }, error: function(e){
                      errortoast('Terjadi Kesalahan')
                      console.log(e)
                  }
                })
              }
          </script>
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
  })
</script>
