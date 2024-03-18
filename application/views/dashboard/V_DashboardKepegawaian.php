<style>
  .info_card:hover{
    cursor: pointer;
    transition: .2s;
    background-color: #ececed;
  }
</style>

<div class="row">
  <div class="col-lg-4">
    <div onclick="openSearchPegawai()" class="card info_card">
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

  <!-- <div class="col-lg-4">
    <div  class="card info_card">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0 ml-0">
            <h5 class="card-title">Jabatan Struktural</h5>
          </div>
          <div class="col-auto">
            <div class="stat text-primary">
              <i class="align-middle fa fa-users" ></i>
            </div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?=$chart['jenis_jabatan']['struktural']['jumlah']?></h1>
        <div class="mb-0">
          <span class="text-muted">Per Hari Ini</span>
        </div>
      </div>
    </div>
  </div> -->
  
  <!-- <div class="col-lg-4">
    <div  class="card info_card">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0 ml-0">
            <h5 class="card-title">Jabatan Fungsional Tertentu</h5>
          </div>
          <div class="col-auto">
            <div class="stat text-primary">
              <i class="align-middle fa fa-users" ></i>
            </div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?=$chart['jenis_jabatan']['jft']['jumlah']?></h1>
        <div class="mb-0">
          <span class="text-muted">Per Hari Ini</span>
        </div>
      </div>
    </div>
  </div>
   -->

  <!-- <div class="col-lg-4">
    <div  class="card info_card">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0 ml-0">
            <h5 class="card-title">Jabatan Fungsional Umum</h5>
          </div>
          <div class="col-auto">
            <div class="stat text-primary">
              <i class="align-middle fa fa-users" ></i>
            </div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?=$chart['jenis_jabatan']['jfu']['jumlah']?></h1>
        <div class="mb-0">
          <span class="text-muted">Per Hari Ini</span>
        </div>
      </div>
    </div>
  </div>
   -->

  
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
      console.log("yor")
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

        console.log(values)
       

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

    function openSearchPegawai(){
      window.location="<?=base_url('list-pegawai')?>"
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