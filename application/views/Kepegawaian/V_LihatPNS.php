<style>
  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: var(--primary-color);
    color: white;
  }

  .nav-link{
    color: var(--primary-color);
  }
  
  .nav-link:hover{
    background-color: #e2e2e2;
    transition: .1s;
  }
</style>
 
<div class="card p-3">
  <div class="tabs-to-dropdown">
    <div class="nav-wrapper d-flex align-items-center justify-content-between">
      <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" onclick = "loadListProfil()" id="" data-toggle="pill" href="#tab_profil" role="tab" aria-controls="pills-product" aria-selected="true">Profil</a>
        </li>
        <li class="nav-item" role="presentation">
          <a onclick="loadListPangkat()" class="nav-link" id="" data-toggle="pill" href="#tab_pangkat" role="tab" aria-controls="pills-product" aria-selected="false">Pangkat</a>
        </li>
        <li class="nav-item" role="presentation">
          <a onclick="loadListPendidikan()" class="nav-link" id="" data-toggle="pill" href="#tab_pendidikan" role="tab" aria-controls="pills-product" aria-selected="false">Pendidikan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a onclick="loadListJabatan()" class="nav-link" id="" data-toggle="pill" href="#tab_jabatan" role="tab" aria-controls="pills-product" aria-selected="false">Jabatan</a>
        </li>
        <li class="nav-item" role="presentation">
          <a onclick="loadListDiklat()" class="nav-link" id="" data-toggle="pill" href="#tab_diklat" role="tab" aria-controls="pills-product" aria-selected="false">Diklat</a>
        </li>

      </ul>
    </div>
    <hr>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="tab_profil" role="tabpanel" aria-labelledby="pills-company-tab">
      </div>
      <div class="tab-pane fade" id="tab_pangkat" role="tabpanel" aria-labelledby="pills-company-tab">
      </div>
      <div class="tab-pane fade" id="tab_pendidikan" role="tabpanel" aria-labelledby="pills-company-tab">
      </div>
      <div class="tab-pane fade" id="tab_jabatan" role="tabpanel" aria-labelledby="pills-company-tab">
      </div>
      <div class="tab-pane fade" id="tab_diklat" role="tabpanel" aria-labelledby="pills-company-tab">
      </div>
    </div>
  </div>
</div>

<script>
  $(function(){
    // loadListProfil()
  })

  function loadListProfil(){ 
    $('#tab_profil').html('')
    $('#tab_profil').append(divLoaderNavy)
    $('#tab_profil').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListProfil/")?>', function(){
      $('#loader').hide()
    })
  }
  function loadListPangkat(){
    $('#tab_pangkat').html('')
    $('#tab_pangkat').append(divLoaderNavy)
    $('#tab_pangkat').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPangkat/")?>', function(){
      $('#loader').hide()
    })
  }

  function loadListPendidikan(){
    $('#tab_pendidikan').html('')
    $('#tab_pendidikan').append(divLoaderNavy)
    $('#tab_pendidikan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListPendidikan/")?>', function(){
      $('#loader').hide()
    })
  }

  function loadListJabatan(){
    $('#tab_jabatan').html('')
    $('#tab_jabatan').append(divLoaderNavy)
    $('#tab_jabatan').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListJabatan/")?>', function(){
      $('#loader').hide()
    })
  }

  function loadListDiklat(){
    $('#tab_diklat').html('')
    $('#tab_diklat').append(divLoaderNavy)
    $('#tab_diklat').load('<?=base_url("Kepegawaian/C_Kepegawaian/loadListDiklat/")?>', function(){
      $('#loader').hide()
    })
  }
</script>
