<?php
    $path = './assets/fotopeg/'.$foto['fotopeg'];
    // $path = '../siladen/assets/fotopeg/'.$foto['fotopeg'];
    if($foto['fotopeg']){
    if (file_exists($path)) {
       $result['pas_foto'] = 1;
    } 
    }
   
    $progress_target = 0;
    $jumlah_berkas = 15;
    if($result){
        $progress_target = formatTwoMaxDecimal((count($result) / $jumlah_berkas) * 100);
    }    
?>

<div class="row">
    <div class="col-12 text-center">
        <div class="progress progress-sm" style="height: 1.3rem !important; border-radius: 10px;">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress_target?>" aria-valuemin="0" aria-valuemax="<?=$progress_target?>" style="width: <?=$progress_target == 0 ? 0 : $progress_target?>%; background-color: <?=getProgressBarColor($progress_target)?>;">
            <p class="text-progress"><?=$progress_target.'%'?></p>
            </div>
        </div>
        <hr>
  
    </div>

   

    <!-- <img id="profile_pegawai" class="img-fluid mb-2 b-lazy"
                            src="<?=base_url('assets/fotopeg/')?><?=$foto['fotopeg']?>" />  -->

<div class="card-group">
  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('pangkat')" class="card card-default card-pdm <?=isset($result['pas_foto']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-id-badge fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Pas Foto</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('cpns_pns')" class="card card-default card-pdm <?=isset($result['cpns_pns']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div  class="col-12 text-center">
                    <span  class="card-title-pdm">SK CPNS/PNS</span>
                </div>
                </div>
      </div>
  </div>


  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('pangkat')" class="card card-default card-pdm <?=isset($result['pangkat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Pangkat</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('jabatan')" class="card card-default card-pdm <?=isset($result['jabatan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Jabatan</span>
                </div>
        </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('skp_tahunan')" class="card card-default card-pdm <?=isset($result['skp_tahunan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SKP Tahunan</span>
                </div>
                </div>
      </div>
  </div>

</div>


<div class="card-group">
  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('kgb')" class="card card-default card-pdm <?=isset($result['kgb']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK KGB</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('ijazah')" class="card card-default card-pdm <?=isset($result['ijazah']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Ijazah</span>
                </div>
                </div>
      </div>
  </div>


  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('diklat')" class="card card-default card-pdm <?=isset($result['diklat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sert. Diklat</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('sumpah_janji')" class="card card-default card-pdm <?=isset($result['sumpah_janji']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sumpah Janji</span>
                </div>
        </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('penghargaan')" class="card card-default card-pdm <?=isset($result['penghargaan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Penghargaan</span>
                </div>
        </div>
      </div>
  </div>
</div>


<div class="card-group">
<div class="card">
    <div class="card-body">
    <div onclick="loadPage('cuti')" class="card card-default card-pdm <?=isset($result['cuti']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Cuti</span>
                </div>
                </div>
      </div>
  </div>

<div class="card">
    <div class="card-body">
    <div onclick="loadPage('penugasan')" class="card card-default card-pdm <?=isset($result['penugasan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Penugasan</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('keluarga')" class="card card-default card-pdm <?=isset($result['keluarga']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data Keluarga</span>
                </div>
                </div>
      </div>
  </div>

  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('organisasi')" class="card card-default card-pdm <?=isset($result['organisasi']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Organisasi</span>
                </div>
                </div>
      </div>
  </div>

  
  <div class="card">
    <div class="card-body">
    <div onclick="loadPage('data_lainnya')" class="card card-default card-pdm <?=isset($result['data_lainnya']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
    <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data lainnya</span>
                </div>
                </div>
      </div>
  </div>
</div>


<!-- 
    <div class="col-2">
        <div onclick="loadPage('pangkat')" class="card card-default card-pdm <?=isset($result['pas_foto']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-id-badge fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Pas Foto</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('cpns_pns')" class="card card-default card-pdm <?=isset($result['cpns_pns']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div  class="col-12 text-center">
                    <span  class="card-title-pdm">SK CPNS/PNS</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-2">
        <div onclick="loadPage('pangkat')" class="card card-default card-pdm <?=isset($result['pangkat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Pangkat</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('jabatan')" class="card card-default card-pdm <?=isset($result['jabatan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK Jabatan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div  onclick="loadPage('kgb')" class="card card-default card-pdm <?=isset($result['kgb']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SK KGB</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div  onclick="loadPage('ijazah')" class="card card-default card-pdm <?=isset($result['ijazah']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Ijazah</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div  onclick="loadPage('diklat')" class="card card-default card-pdm <?=isset($result['diklat']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sert. Diklat</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('sumpah_janji')" class="card card-default card-pdm <?=isset($result['sumpah_janji']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Sumpah Janji</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('penghargaan')" class="card card-default card-pdm <?=isset($result['penghargaan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Penghargaan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('keluarga')" class="card card-default card-pdm <?=isset($result['keluarga']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data Keluarga</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('skp_tahunan')" class="card card-default card-pdm <?=isset($result['skp_tahunan']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">SKP Tahunan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div onclick="loadPage('data_lainnya')" class="card card-default card-pdm <?=isset($result['data_lainnya']) ? 'card-lengkap' : 'card-belum-lengkap' ?> p-3">
            <div class="row">
                <div class="col-12 text-center">
                    <i class="text-dark fa fa-file-alt fa-2x"></i>
                </div>
                <div class="col-12 text-center">
                    <span class="card-title-pdm">Data Lainnya</span>
                </div>
            </div>
        </div>
    </div>
     -->

    <script>
        function loadPage(page) {
            window.location.href = "<?=base_url();?>kepegawaian/profil/"+page;
        }
    </script>