<style>
    .divider_col_result{
        border-bottom: 1px solid black;
    }

    .col_result{
        padding: 5px;
    }

    .col_result:hover{
        background-color: var(--primary-color);
        color: white;
        cursor: pointer;
    }

    @media only screen and (max-width: 991px) { /* if mobile */ 
        #search_profile_pic{
            height: 9vh !important;
        }
    }
</style>

<div style="padding: 5px; background-color: #c6c6c6; color: var(--primary-color); font-weight: bold; font-size: .8rem;">
    <span class="title-search-navbar">DATA PEGAWAI</span>
</div>
<?php
    if($result_pegawai){
?>
    <div class="p-0">
        <?php $i = 0; foreach($result_pegawai as $rs){
            $badge_status = 'badge-cpns';
            if($rs['statuspeg'] == 2){
              $badge_status = 'badge-pns';
            } else if($rs['statuspeg'] == 3){
              $badge_status = 'badge-pppk';
            }

            $badge_aktif = 'badge-aktif';
            if($rs['id_m_status_pegawai'] == 2){
              $badge_aktif = 'badge-pensiun-bup';
            } else if($rs['id_m_status_pegawai'] == 3){
              $badge_aktif = 'badge-pensiun-dini';
            } else if($rs['id_m_status_pegawai'] == 4){
              $badge_aktif = 'badge-diberhentikan';
            } else if($rs['id_m_status_pegawai'] == 5){
              $badge_aktif = 'badge-mutasi';
            } else if($rs['id_m_status_pegawai'] == 6){
              $badge_aktif = 'badge-meninggal';
            } else if($rs['id_m_status_pegawai'] == 8){
                $badge_aktif = 'badge-tidak-aktif';
              }
        ?>
            <div onclick="openProfilePegawai('<?=$rs['username']?>')" class="col_result col-lg-12">
                <div class="row" style="line-height: 1rem;">
                    <div class="col-md-4 col-sm-4 col-lg-4 my-auto align-self-center">
                        <!-- <img src="<?=$this->general_library->getFotoPegawai('./assets/fotopeg/'.$rs['fotopeg'])?>"
                        style="border-radius: 30px !important; width: 6vw; object-fit: cover;" /> -->
                        <center>
                        <img id="search_profile_pic" style="border-radius: 100rem !important; width: 100%; height: 12vh; object-fit: cover" class="img-fluid b-lazy"
                            src="<?php
                                $path = './assets/fotopeg/'.$rs['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($rs['fotopeg']){
                                if (file_exists($path)) {
                                   $src = './assets/fotopeg/'.$rs['fotopeg'];
                                  //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                  $src = './assets/img/user.png';
                                  // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                  $src = './assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> 
                        </center>
                    </div>
                    <div class="col-md-8 col-sm-8 col-lg-8 my-auto align-self-center" style="margin-left: -10px; text-align: left;">
                        <span style="font-size: .85rem; font-weight: bold;"><?=getNamaPegawaiFull($rs)?></span><br>
                        <span style="font-size: .70rem; font-weight: bold;"><?=($rs['nama_jabatan'])?></span><br>
                        <span style="font-size: .70rem; font-weight: bold;"><?=($rs['nm_unitkerja'])?></span><br>
                        <span style="font-size: .70rem; font-weight: bold;">NIP. <?=($rs['username'])?></span><br>
                        <span class="badge <?=$badge_status?>"><?=$rs['nm_statuspeg']?></span>&nbsp;
                        <span class="badge <?=$badge_aktif?>"><?=$rs['nama_status_pegawai']?>
                    </div>
                </div>
            </div>
            <?php if($i != count($result_pegawai) - 1){ ?>
                <div class="divider_col_result"></div>
            <?php } ?>
        <?php $i++; } ?>
    </div>
<?php } else { ?>
    <div style="padding: 5px; !important; color: black; font-weight: bold;">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
<?php } ?>
<div style="padding: 5px; background-color: #c6c6c6; color: var(--primary-color); font-weight: bold; font-size: .8rem;">
    <span class="title-search-navbar">PERANGKAT DAERAH</span>
</div>
<?php
    if($result_skpd){
?>
    <div class="p-0">
        <?php $i = 0; foreach($result_skpd as $rs){ ?>
            <div onclick="openSkpd('<?=$rs['id_unitkerja']?>')" class="col_result col-lg-12">
                <span style="font-size: .85rem; font-weight: bold;"><?=($rs['nm_unitkerja'])?></span><br>
            </div>
            <?php if($i != count($result_skpd) - 1){ ?>
                <div class="divider_col_result"></div>
            <?php } ?>
        <?php $i++; } ?>
    </div>
<?php } else { ?>
    <div style="padding: 5px; !important; color: black; font-weight: bold;">Data Tidak Ditemukan <i class="fa fa-exclamation"></i></div>
<?php } ?>

<script>
    $(function(){
        window.bLazy = new Blazy({
            container: '.container',
            success: function(element){
                console.log("Element loaded: ", element.nodeName);
            }, error: function(e){
                console.log('error b-lazy')
            }
        });
    })

    function openProfilePegawai(nip){
        window.location='<?=base_url('kepegawaian/profil-pegawai/')?>'+nip
    }

    function openSkpd(id_unitkerja){
        window.location='<?=base_url('master/perangkat-daerah/detail/')?>'+id_unitkerja
    }
</script>