<style>
    #profile_pegawai{
        width: 200px;
        height: calc(200px * 1.25);
        background-size: cover;
        object-fit: cover;
        box-shadow: 5px 5px 10px #888888;
        border-radius: 10%;
    }

    .sp_label{
        font-size: .7rem;
        font-style: italic;
        font-weight: 600;
        color: white;
    }

    .sp_profil_sm{
        font-size: 1rem;
        font-weight: bold;
        color: white;
    }

    .card-belum-lengkap{
        border: 2px solid rgba(0, 0, 0, .3);
        background-color: transparent;
    }

    .card-belum-lengkap:hover{
        background-color: #f3eded;
        transition: .2s;
    }

    .card-lengkap:hover{
        background-color: #35475c;
        transition: .2s;
    }

    .card-lengkap{
        border: 2px solid #15654d;
        background-color: #0a7958;
    }

    .card-lengkap span, .card-lengkap i{
        color: white !important;
    }

    .card-title-pdm{
        font-size: 15px;
        font-weight: bold;
        color: black;
        vertical-align: middle;
    }

    .card-berkas:hover{
        cursor: pointer;
    }

    #text_no_hp:hover{
        color: green !important;
        transition: .2s;
        cursor: pointer;
    }

    .icon-berkas{
        width: 40px;
        height: 40px;
    }

    .list-group-item{
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .list-group-item:hover{
        cursor: pointer;
        background-color: #efefef;
        transition: .2s;
    }

    .icon-berkas-lengkap{
        background-color: green;
        color: white;
    }

    .icon-berkas-belum-verif{
        background-color: yellow;
        color: black;
    }

    .icon-berkas-belum-lengkap{
        background-color: red;
        color: white;
    }

    .nav-link-profile{
      padding: 5px !important;
      font-size: .7rem;
      color: black;
      border: .5px solid var(--primary-color) !important;
      border-bottom-left-radius: 0px;
    }

    .nav-item-profile:hover, .nav-link-profile:hover{
      color: white !important;
      background-color: #222e3c91;
    }

    .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
      /* border-radius: 3px; */
      background-color: var(--primary-color);
      color: white;
    }
</style>

<div class="row">
    <div class="col-lg-4">
        <div class="card card-default" style="background-color: var(--primary-color);">
            <div class="card-body">
                <div class="col-lg-12">
                    <center>
                        <div class="foto_containerx">
                            <img id="profile_pegawai" class="img-fluidx mb-2 b-lazy"
                                src="<?php
                                
                                $path = 'assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                if($profil_pegawai['fotopeg']){
                                if (file_exists($path)) {
                                    $src = 'assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                    //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                } else {
                                    $src = 'assets/img/user.png';
                                    // $src = '../siladen/assets/img/user.png';
                                }
                                } else {
                                    $src = 'assets/img/user.png';
                                }
                                echo base_url().$src;?>" /> 
                        </div>
                    </center>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                            Nama Pegawai
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                            <?=getNamaPegawaiFull($profil_pegawai)?>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                            NIP
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                            <?=($profil_pegawai['nipbaru_ws'])?>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                            Jabatan
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                            <?=($profil_pegawai['nama_jabatan'])?>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                            Pangkat
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                            <?=($profil_pegawai['nm_pangkat'])?>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                            Perangkat Daerah
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                            <?=($profil_pegawai['nm_unitkerja'])?>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                                No. HP
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                                <a id="text_no_hp" style="text-decoration: none; cursor: pointer; color: white;"
                                href="https://wa.me/<?=convertPhoneNumber($profil_pegawai['handphone'])?>" target="_blank">
                                    <?=($profil_pegawai['handphone'])?> <i class="fab fa-whatsapp"></i>
                                </a>
                            </span>
                        </div>
                        <div class="col-lg-12 div_label text-left">
                            <span class="sp_label">
                                Alamat
                            </span>
                        </div>
                        <div class="col-lg-12 text-left" >
                            <span class="sp_profil_sm">
                                <?=($profil_pegawai['alamat'])?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item nav-item-profile" role="presentation">
                                <button class="nav-link nav-link-profile active" id="pills-data-berkas-tab" data-bs-toggle="pill" data-bs-target="#pills-data-berkas" type="button" role="tab" aria-controls="pills-data-berkas" aria-selected="false">CHECKLIST BERKAS</button>
                            </li>
                            <li class="nav-item nav-item-profile" role="presentation">
                                <button class="nav-link nav-link-profile " id="pills-data-pribadi-tab" data-bs-toggle="pill" data-bs-target="#pills-data-pribadi" type="button" role="tab" aria-controls="pills-data-pribadi" aria-selected="true">DATA PRIBADI</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane show active" id="pills-data-berkas" role="tabpanel" aria-labelledby="pills-data-berkas">
                                <ul class="list-group mx-auto">
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('cpns')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['cpns']){
                                                if($berkas['cpns']['status'] == 2){
                                                    $icon = 'fa-check';
                                                    $icon_berkas = 'icon-berkas-lengkap';
                                                } else {
                                                    $icon = 'fa-minus';
                                                    $icon_berkas = 'icon-berkas-belum-verif';
                                                }
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="icon-berkas d-inline-flex <?=$icon_berkas?>
                                                align-items-center justify-content-center rounded-circle m-1 me-2">
                                                    <i class="fas <?=$icon?> fa-lg"></i>
                                                </span>
                                                <span class="card-title-pdm">SK CPNS</span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_cpns" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('pns')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['pns']){
                                                if($berkas['pns']['status'] == 2){
                                                    $icon = 'fa-check';
                                                    $icon_berkas = 'icon-berkas-lengkap';
                                                } else {
                                                    $icon = 'fa-minus';
                                                    $icon_berkas = 'icon-berkas-belum-verif';
                                                }
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="icon-berkas d-inline-flex <?=$icon_berkas?>
                                                align-items-center justify-content-center rounded-circle m-1 me-2">
                                                    <i class="fas <?=$icon?> fa-lg"></i>
                                                </span>
                                                <span class="card-title-pdm">SK PNS</span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_pns" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('akte_anak')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['akte_anak']){
                                                foreach($berkas['akte_anak'] as $aa){
                                                    if($aa['status'] == 2){
                                                        $icon = 'fa-check';
                                                        $icon_berkas = 'icon-berkas-lengkap';
                                                    } else if($aa['status'] == 1) {
                                                        $icon = 'fa-minus';
                                                        $icon_berkas = 'icon-berkas-belum-verif';
                                                    }
                                                }
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="icon-berkas d-inline-flex <?=$icon_berkas?>
                                                align-items-center justify-content-center rounded-circle m-1 me-2">
                                                    <i class="fas <?=$icon?> fa-lg"></i>
                                                </span>
                                                <span class="card-title-pdm">Akte Lahir Anak</span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_akte_anak" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="tab-pane" id="pills-data-pribadi" role="tabpanel" aria-labelledby="pills-data-berkas">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_berkas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">BERKAS PENSIUN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_berkas_content">
            </div>
        </div>
    </div>
  </div>

<script>
    $(function(){
        $('#sidebar_toggle').click()
    })

    function showBerkas(berkas){
        // $('.div_berkas').hide()
        // $('#div_berkas_'+berkas).toggle()
        // $('#div_berkas_'+berkas).html('')
        // $('#div_berkas_'+berkas).append(divLoaderNavy)
        // $('#div_berkas_'+berkas).load('<?=base_url("kepegawaian/C_Layanan/loadBerkasPensiun/")?>'+berkas, function(){
        //     $('#loader.hide')
        // })
        
        $('#modal_berkas').modal('show')
        $('#modal_berkas_content').html('')
        $('#modal_berkas_content').append(divLoaderNavy)
        $('#modal_berkas_content').load('<?=base_url("kepegawaian/C_Layanan/loadBerkasPensiun/")?>'+berkas, function(){
            $('#loader.hide')
        })
    }
</script>