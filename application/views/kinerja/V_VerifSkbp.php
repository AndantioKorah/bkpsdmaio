<style>
    .nav-link-kinerja{
      padding: 5px !important;
      font-size: .8rem;
      color: black;
      border: .5px solid var(--primary-color) !important;
      border-bottom-left-radius: 0px;
    }

    .nav-item-kinerja:hover, .nav-link-kinerja:hover{
      color: white !important;
      background-color: #222e3c91;
    }

    .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
      /* border-radius: 3px; */
      background-color: var(--primary-color);
      color: white;
    }

    .lblspan{
        font-size: .7rem;
        font-style: italic;
        font-weight: 600;
        color: grey;
    }

    .valspan{
        font-size: .9rem;
        /* font-style: ; */
        font-weight: bold;
        color: black;
    }
</style>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3">
            <span class="lblspan">Nama</span><br>
            <span class="valspan"><?=getNamaPegawaiFull($pegawai)?></span>
        </div>
        <div class="col-lg-3">
            <span class="lblspan">Unit Kerja</span><br>
            <span class="valspan"><?=$pegawai['nm_unitkerja']?></span>
        </div>
        <div class="col-lg-3">
            <span class="lblspan">Pangkat</span><br>
            <span class="valspan"><?=$pegawai['nm_pangkat']?></span>
        </div>
        <div class="col-lg-3">
            <span class="lblspan">Jabatan</span><br>
            <span class="valspan"><?=$pegawai['nama_jabatan']?></span>
        </div>
    </div>
</div>

<div class="col-lg-12 mt-2 mb-2">
    <ul class="nav nav-tabs" id="pills-tab" role="tablist">
        <li class="nav-item nav-item-kinerja" role="presentation">
            <button onclick="loadKinerjaUser()" class="nav-link nav-link-kinerja active" id="pills-kinerja-tab" data-bs-toggle="pill" data-bs-target="#pills-kinerja" 
                type="button" role="tab" aria-controls="pills-home" aria-selected="true">Kinerja</button>
        </li>
        <li class="nav-item nav-item-kinerja" role="presentation">
            <button onclick="loadKomponenKinerja()" class="nav-link nav-link-kinerja" id="pills-komponen-kinerja-tab" data-bs-toggle="pill" data-bs-target="#pills-komponen-kinerja" 
                type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Komponen Kinerja</button>
        </li>
        <li class="nav-item nav-item-kinerja" role="presentation">
            <button onclick="loadLembarSkp()" class="nav-link nav-link-kinerja" id="pills-lembar-skp-tab" data-bs-toggle="pill" data-bs-target="#pills-lembar-skp" 
                type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Lembar SKP</button>
        </li>
    </ul>
</div>

<div class="col-lg-12">
    <div class="tab-content" id="pills-tabContent" style="margin-bottom: 0px;">
        <div class="tab-pane show active" id="pills-kinerja" role="tabpanel" aria-labelledby="pills-kinerja-tab">
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent" style="margin-bottom: 0px;">
        <div class="tab-pane show active" id="pills-komponen-kinerja" role="tabpanel" aria-labelledby="pills-komponen-kinerja-tab">
        </div>
    </div>
</div>

<script>
    $(function(){
        loadKinerjaUser()
    })

    function loadKinerjaUser(){
        $('#pills-kinerja').html('')
        $('#pills-kinerja').append(divLoaderNavy)
        $('#pills-kinerja').load('<?=base_url("kinerja/C_Kinerja/openRekapKinerjaPegawai/".$periode['id_user'].'/'.$periode['bulan'].'/'.$periode['tahun'])?>', function(){
            $('#loader').hide()
        })
    }

    function loadKomponenKinerja(){
        $('#pills-komponen-kinerja').html('')
        $('#pills-komponen-kinerja').append(divLoaderNavy)
        $('#pills-komponen-kinerja').load('<?=base_url("kinerja/C_Kinerja/openKomponenKinerjaPegawai/".$periode['id_user'].'/'.$periode['bulan'].'/'.$periode['tahun'])?>', function(){
            $('#loader').hide()
        })
    }

    function loadLembarSkp(){
        $('#pills-komponen-kinerja').html('')
        $('#pills-komponen-kinerja').append(divLoaderNavy)
        $('#pills-komponen-kinerja').load('<?=base_url("kinerja/C_Kinerja/createSkpBulananVerifNew/".$periode['id_user'].'/'.$periode['bulan'].'/'.$periode['tahun'])?>', function(){
            $('#loader').hide()
        })
    }
</script>