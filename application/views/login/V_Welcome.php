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


<?php 
if(!$this->general_library->isWalikota() || !$this->general_library->isGuest()){
  if($this->general_library->getUserName() == $nip){
    $nm_jab = substr($profil_pegawai['nama_jabatan'], 0, 6);
    $eselon = 0;
    $idSubBidang = 0;
    // dd($bidang);
    if($bidang){
      if($profil_pegawai['id_unitkerjamaster'] == "8020000" || $profil_pegawai['id_unitkerjamaster'] == "6000000" || $profil_pegawai['id_unitkerjamaster'] == "8010000" || $profil_pegawai['id_unitkerjamaster'] == "1000000" || $profil_pegawai['id_unitkerjamaster'] == "8000000"){
        $idBidang = 99;
      } else if($profil_pegawai['eselon'] == "II B" || $profil_pegawai['eselon'] == "III A") {
        $idBidang = 99;
      }else if($nm_jab == "walikota"){
        $idBidang = 99;
      } else if($profil_pegawai['eselon'] == "IV A"){
        $idBidang = 99;
       $nm_jab2 = trim($nm_jab," ");
      //  dd($nm_jab2);
         if($nm_jab2 != "Lurah"){
          if($bidang['id_m_sub_bidang'] == 0){
            $idSubBidang = 0;
            $eselon = 1;
          } else {
            $idSubBidang = 99;
          }
         } else {
          $eselon = 0;
          $idBidang = 99;
         }
      } else {        
        if($this->general_library->isGuest()){
        $idBidang = 99;
        } else {
        $idBidang = $bidang['id_m_bidang'];
        }
      }
    } else {
     $idBidang = 99;
    }
    } else if($this->general_library->isWalikota()) {
    $idBidang = 99;
    } else {
      $idBidang = 99;
    }
  } else {
    $idBidang = 99;
  }

  if($bidang){
    // dd($eselon);
    if($bidang['id_unitkerja'] != NULL){
      if($profil_pegawai['skpd'] != $bidang['id_unitkerja']){
        $idBidang = 0;
      }
    }  else {
      $idBidang = $idBidang;
    }
    
  }

  
    ?>

<input type="hidden" id="bidangPegawai" value="<?=$idBidang;?>">
<input type="hidden" id="subBidangPegawai" value="<?=$idSubBidang;?>">
<input type="hidden" id="eselon" value="<?=$eselon;?>">

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
        <?php if($this->general_library->getRole() == 'programmer' || 
        $this->general_library->isAdminAplikasi() || 
        $this->general_library->isWalikota() ||
        $this->general_library->isGuest()
        // || $this->general_library->isPegawaiBkpsdm()
        || $this->general_library->isKepalaBkpsdm()
        )
        { ?>
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
          <div class="p-3">
            <h4><?="Selamat ".greeting().","?></h4>
            <strong><h1 class="nmuser font-weight-bold"><?=$this->general_library->getNamaUser()?></h1></strong>
            <?php
              $this->load->view('user/V_QuickMenuPegawai', null); 
              // $this->load->view('user/V_Pdm', null);
            ?>
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
        </div>
        <?php } ?>
      </div>
      <!-- <div class="col-12 text-center">
          <h4 style="font-weight: bold;" id="live_date_time_welcome" class="nav-link"></h4>
      </div> -->
      
  </div>
</div>

<!-- Button trigger modal -->
<button style="display:none" id="btnstatic" type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<button style="display:none" id="btnannouncement" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-announcement">
  Launch static backdrop modal
</button>

  <div class="modal fade" id="modal-announcement" tabindex="-1" data-backdrop="static" data-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="col-lg-12 float-right text-right">
    <button type="button" class="btn-close btn-close-modal-announcement btn-light" style="width: 50px; height: 50px; background-color: white;" data-dismiss="modal"><i class="fa fa-3x fa-times"></i></button>
  </div>
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div id="modal-announcement-content">
            <!-- <image id="modal-announcement-image" /> -->
        </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>

      </div><br>
      <center><h3>Harap Mengisi Data Bidang/Bagian </h3></center>

      <div class="modal-body">
      <form action="<?=base_url('kepegawaian/C_Kepegawaian/submiDataBidang2');?>" method="post">
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Bidang/Bagian</label>
    <select class="form-control select2" data-dropdown-parent="#staticBackdrop" data-dropdown-css-class="select2-navy" name="id_m_bidang" id="id_m_bidang" required>
                    <option value="" disabled selected>Pilih Item</option>
                    <option value="0">-</option>
                    <?php if($mbidang){ foreach($mbidang as $r){ ?>
                        <option  value="<?=$r['id']?>"><?=$r['nama_bidang']?></option>
                    <?php } } ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Sub Bidang/Sub Bagian/Seksi</label>
    <select class="form-control select2" data-dropdown-parent="#staticBackdrop" data-dropdown-css-class="select2-navy" name="id_m_sub_bidang" id="id_m_sub_bidang">
      <option value="0" selected>-</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary float-right">Simpan</button>
</form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


<script>
  $(function(){
    <?php // if($this->general_library->isProgrammer()){ if($announcement){ ?>
      $('#btnannouncement').click()
      $('#modal-announcement-content').load('<?=base_url('login/C_Login/loadAnnouncement')?>')
    <?php // } } ?>

    <?php if($this->session->userdata('apps_error')){ ?>
			errortoast("<?=$this->session->userdata('apps_error')?>");
		//   $('#error_div').show()
		//   $('#error_div').append('<label>'+'<?=$this->session->userdata('apps_error')?>'+'</label>')
		<?php
		$this->session->set_userdata('apps_error', null);
		} ?>
    loadDashboardPdmWelcome();

    var bidang = $('#bidangPegawai').val()
    var eselon = $('#eselon').val()
    var subBidang = $('#subBidangPegawai').val()

    if(bidang == "" || bidang == 0){
    $('#btnstatic').click()  
    }

    if(eselon == 1){
      if(subBidang == "" || subBidang == 0){
    $('#btnstatic').click()  
    }
    }

    $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	})


  })

  $('.btn-close-modal-announcement').on('click', function(){
    $('#modal-announcement').hide()
  })

  function loadDashboardPdmWelcome(){
      $('#dashboard_pdm_welcome').html('')
      $('#dashboard_pdm_welcome').append(divLoaderNavy)
      $('#dashboard_pdm_welcome').load('<?=base_url('dashboard/C_Dashboard/getDashboardPdmAll')?>', function(){
          $('#loader').hide()
      })
  }


  $("#id_m_bidang").change(function() {
      var id = $("#id_m_bidang").val();
      $.ajax({
              url : "<?php echo base_url();?>kepegawaian/C_Kepegawaian/getMasterSubBidang",
              method : "POST",
              data : {id: id},
              async : false,
              dataType : 'json',
              success: function(data){
              var html = '<option value=>-</option>';
                      var i;
                      for(i=0; i<data.length; i++){
                          html += '<option value='+data[i].id+'>'+data[i].nama_sub_bidang+'</option>';
                      }
                      $('#id_m_sub_bidang').html(html);
                          }
                  });
  });
</script>
