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
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="<?=base_url('assets/img/logo-simponi-asn.png')?>" style="width: 300px;" />
                    </div>
                    <div class="col-lg-6 text-right">
                        <?php if($berkas['data_hukdis']){ ?>
                            <span style="color: red; font-weight: bold; font-style: italic; font-size: .65rem;">*pegawai sedang dalam masa menjalani hukuman disiplin sedang/berat mulai <?=formatDateNamaBulan($berkas['data_hukdis']['tglsurat'])?> sampai <?=formatDateNamaBulan($berkas['data_hukdis']['tmt_akhir'])?></span><br>
                        <?php } ?>
                        <?php if($progress['data']['url_file_dpcp'] == null){ ?>
                            <form id="form_create_dpcp">
                                <button id="btn_create_dpcp" type="submit" class="btn btn-block btn-danger float-right"><i class="fa fa-input"></i> BUAT BERKAS PENSIUN DAN AJUKAN DS</button>
                                <button id="btn_create_dpcp_loading" style="display: none;" disabled type="button" class="btn btn-block btn-danger float-right"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...</button>
                            </form>
                        <?php } else { ?>
                            <!-- <form id="form_show_dpcp" action="<?=base_url('kepegawaian/C_Layanan/showDpcp/'.$id_t_checklist_pensiun)?>" target="_blank"> -->
                                <button id="btn_show_dpcp" href="#modal_berkas" data-toggle="modal" onclick="showDpcp('<?=$id_t_checklist_pensiun?>')"
                                class="btn btn-block btn-success float-right"><i class="fa fa-eye"></i> LIHAT BERKAS PENSIUN</button>

                                <button id="btn_delete_berkas_pensiun" onclick="deleteBerkas('<?=$id_t_checklist_pensiun?>')"
                                class="btn btn-block btn-danger float-right mr-3"><i class="fa fa-trash"></i> HAPUS BERKAS</button>
                                <button id="btn_delete_berkas_pensiun_loading" style="display: none;" disabled
                                class="btn btn-block btn-danger float-right"><i class="fa fa-spin fa-spinner"></i> Menghapus Data...</button>
                            <!-- </form> -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <button class="nav-link nav-link-profile " id="pills-data-lainnya-tab" data-bs-toggle="pill" data-bs-target="#pills-data-lainnya" type="button" role="tab" aria-controls="pills-data-lainnya" aria-selected="true">DATA LAINNYA</button>
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
                                                    <span style="display: <?=isset($progress['cpns']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-cpns badge-success text-right float-right">
                                                        <?php if(isset($progress['cpns'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['cpns']['verifikator']).' pada '.formatDateNamaBulanWT($progress['cpns']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
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
                                                    <span style="display: <?=isset($progress['pns']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-pns badge-success text-right float-right">
                                                        <?php if(isset($progress['pns'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['pns']['verifikator']).' pada '.formatDateNamaBulanWT($progress['pns']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_pns" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('sk_pangkat')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['sk_pangkat']){
                                                if($berkas['sk_pangkat']['status'] == 2){
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
                                                <span class="card-title-pdm">SK Pangkat Terakhir</span>
                                                    <span style="display: <?=isset($progress['sk_pangkat']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-sk_pangkat badge-success text-right float-right">
                                                        <?php if(isset($progress['sk_pangkat'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['sk_pangkat']['verifikator']).' pada '.formatDateNamaBulanWT($progress['sk_pangkat']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_sk_pangkat" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('hukdis')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['hukdis']){
                                                if($berkas['hukdis']['status'] == 2){
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
                                                <span class="card-title-pdm">SURAT PERNYATAAN TIDAK PERNAH DIJATUHI HUKUMAN DISIPLIN SEDANG/BERAT DALAM 1 TAHUN TERAKHIR</span>
                                                    <span style="display: <?=isset($progress['hukdis']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-hukdis badge-success text-right float-right">
                                                        <?php if(isset($progress['hukdis'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['hukdis']['verifikator']).' pada '.formatDateNamaBulanWT($progress['hukdis']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_hukdis" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('pidana')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['pidana']){
                                                if($berkas['pidana']['status'] == 2){
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
                                                <span class="card-title-pdm">SURAT PERNYATAAN TIDAK SEDANG DIPIDANA ATAU PERNAH DIPIDANA PENJARA</span>
                                                    <span style="display: <?=isset($progress['pidana']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-pidana badge-success text-right float-right">
                                                        <?php if(isset($progress['pidana'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['pidana']['verifikator']).' pada '.formatDateNamaBulanWT($progress['pidana']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_pidana" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('sk_jabatan')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['sk_jabatan']){
                                                if($berkas['sk_jabatan']['status'] == 2){
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
                                                <span class="card-title-pdm">SK JABATAN STRUKTURAL TERAKHIR</span>
                                                    <span style="display: <?=isset($progress['sk_jabatan']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-sk_jabatan badge-success text-right float-right">
                                                        <?php if(isset($progress['sk_jabatan'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['sk_jabatan']['verifikator']).' pada '.formatDateNamaBulanWT($progress['sk_jabatan']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_sk_jabatan" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('pmk')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['pmk']){
                                                if($berkas['pmk']['status'] == 2){
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
                                                <span class="card-title-pdm">SK PENINJAUAN MASA KERJA</span>
                                                    <span style="display: <?=isset($progress['pmk']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-pmk badge-success text-right float-right">
                                                        <?php if(isset($progress['pmk'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['pmk']['verifikator']).' pada '.formatDateNamaBulanWT($progress['pmk']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_pmk" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('skp')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['skp']){
                                                if($berkas['skp']['status'] == 2){
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
                                                <span class="card-title-pdm">SASARAN KERJA PEGAWAI</span>
                                                    <span style="display: <?=isset($progress['skp']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-skp badge-success text-right float-right">
                                                        <?php if(isset($progress['skp'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['skp']['verifikator']).' pada '.formatDateNamaBulanWT($progress['skp']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_skp" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('akte_nikah')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['akte_nikah']){
                                                if($berkas['akte_nikah']['status'] == 2){
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
                                                <span class="card-title-pdm">AKTE PERKAWINAN</span>
                                                    <span style="display: <?=isset($progress['akte_nikah']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-akte_nikah badge-success text-right float-right">
                                                        <?php if(isset($progress['akte_nikah'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['akte_nikah']['verifikator']).' pada '.formatDateNamaBulanWT($progress['akte_nikah']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="akte_nikah" style="display: none;">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('akte_nikah')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['akte_nikah']){
                                                foreach($berkas['akte_nikah'] as $aa){
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
                                                <span class="card-title-pdm">Akte Perkawinan</span>
                                                    <span style="display: <?=isset($progress['akte_nikah']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-akte_nikah badge-success text-right float-right">
                                                        <?php if(isset($progress['akte_nikah'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['akte_nikah']['verifikator']).' pada '.formatDateNamaBulanWT($progress['akte_nikah']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_akte_nikah" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('akte_cerai')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['akte_cerai']){
                                                if($berkas['akte_cerai']['status'] == 2){
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
                                                <span class="card-title-pdm">AKTE CERAI</span>
                                                    <span style="display: <?=isset($progress['akte_cerai']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-akte_cerai badge-success text-right float-right">
                                                        <?php if(isset($progress['akte_cerai'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['akte_cerai']['verifikator']).' pada '.formatDateNamaBulanWT($progress['akte_cerai']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_akte_cerai" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('akte_kematian')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['akte_kematian']){
                                                if($berkas['akte_kematian']['status'] == 2){
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
                                                <span class="card-title-pdm">AKTE KEMATIAN</span>
                                                    <span style="display: <?=isset($progress['akte_kematian']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-akte_kematian badge-success text-right float-right">
                                                        <?php if(isset($progress['akte_kematian'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['akte_kematian']['verifikator']).' pada '.formatDateNamaBulanWT($progress['akte_kematian']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_akte_kematian" style="display: none;">
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
                                                    <span style="display: <?=isset($progress['akte_anak']) ? 'block' : 'none'?>" class="badge badge-progress-pensiun badge-progress-akte_anak badge-success text-right float-right">
                                                        <?php if(isset($progress['akte_anak'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['akte_anak']['verifikator']).' pada '.formatDateNamaBulanWT($progress['akte_anak']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_akte_anak" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('kartu_keluarga')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['kartu_keluarga']){
                                                if($berkas['kartu_keluarga']['status'] == 2){
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
                                                <span class="card-title-pdm">KARTU KELUARGA</span>
                                                    <span style="display: <?=isset($progress['kartu_keluarga']) ? 'block' : 'none'?>" class="badge badge-progress-pensiun badge-progress-kartu_keluarga badge-success text-right float-right">
                                                        <?php if(isset($progress['kartu_keluarga'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['kartu_keluarga']['verifikator']).' pada '.formatDateNamaBulanWT($progress['kartu_keluarga']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_kartu_keluarga" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('ktp')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['ktp']){
                                                if($berkas['ktp']['status'] == 2){
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
                                                <span class="card-title-pdm">KARTU TANDA PENDUDUK</span>
                                                    <span style="display: <?=isset($progress['ktp']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-ktp badge-success text-right float-right">
                                                        <?php if(isset($progress['ktp'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['ktp']['verifikator']).' pada '.formatDateNamaBulanWT($progress['ktp']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_ktp" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('npwp')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['npwp']){
                                                if($berkas['npwp']['status'] == 2){
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
                                                <span class="card-title-pdm">NPWP</span>
                                                    <span style="display: <?=isset($progress['npwp']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-npwp badge-success text-right float-right">
                                                        <?php if(isset($progress['npwp'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['npwp']['verifikator']).' pada '.formatDateNamaBulanWT($progress['npwp']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_npwp" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item" style="cursor: pointer;" onclick="showBerkas('rekening')">
                                        <?php
                                            $icon = 'fa-times';
                                            $icon_berkas = 'icon-berkas-belum-lengkap';
                                            if($berkas['rekening']){
                                                if($berkas['rekening']['status'] == 2){
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
                                                <span class="card-title-pdm">BUKU REKENING</span>
                                                    <span style="display: <?=isset($progress['rekening']) ? 'block' : 'none'?>" class="badge-progress-pensiun badge badge-progress-rekening badge-success text-right float-right">
                                                        <?php if(isset($progress['rekening'])){ ?>
                                                            Telah divalidasi oleh <?=trim($progress['rekening']['verifikator']).' pada '.formatDateNamaBulanWT($progress['rekening']['created_date'])?>
                                                        <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="col-lg-12 div_berkas" id="div_berkas_rekening" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="tab-pane" id="pills-data-lainnya" role="tabpanel" aria-labelledby="pills-data-lainnya">
                                <form id="form_data_lainnya">
                                    <div class="row">
                                        <div class="col-lg-12 mt-2">
                                            <label>BUP</label>
                                            <input class="form-control" id="bup" name="bup" value="<?=$data_checklist_pensiun['bup']?>" />
                                        </div>
                                        <div class="col-lg-12">
                                            <label>GAJI POKOK TERAKHIR</label>
                                            <input type="number" class="form-control" name="gaji_pokok_pensiun" value="<?=$data_checklist_pensiun['gaji_pokok_pensiun']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>MASA KERJA GOLONGAN</label>
                                            <input class="form-control" id="masa_kerja_golongan" name="masa_kerja_golongan" value="<?=$data_checklist_pensiun['masa_kerja_golongan']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>MASA KERJA PENSIUN</label>
                                            <input class="form-control" id="masa_kerja_pensiun" name="masa_kerja_pensiun" value="<?=$data_checklist_pensiun['masa_kerja_pensiun']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>MASA KERJA SEBELUM DIANGKAT SEBAGAI PNS</label>
                                            <input class="form-control" id="masa_kerja_sebelum_pns" name="masa_kerja_sebelum_pns" value="<?=$data_checklist_pensiun['masa_kerja_sebelum_pns']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>PENDIDIKAN SEBAGAI DASAR PENGANGKATAN PERTAMA</label>
                                            <input class="form-control" id="pendidikan_pertama" name="pendidikan_pertama" value="<?=$data_checklist_pensiun['pendidikan_pertama']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>ALAMAT SEKARANG</label>
                                            <input class="form-control" id="alamat_sekarang" name="alamat_sekarang" value="<?=$data_checklist_pensiun['alamat_sekarang']?>" />
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label>ALAMAT SETELAH PENSIUN</label>
                                            <input class="form-control" id="alamat_setelah_pensiun" name="alamat_setelah_pensiun" value="<?=$data_checklist_pensiun['alamat_setelah_pensiun']?>" />
                                        </div>
                                        <div class="col-lg-12 text-right mt-3">
                                            <button type="submit" class="btn btn-navy"><i class="fa fa-save"></i> SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-12" id="qr_here" style="display: none;">
        <?php $this->load->view('adminkit/partials/V_QrTte', $dataQr); ?>
    </div> -->
</div>
<div class="modal fade" id="modal_berkas" tabindex="-1" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">BERKAS PENSIUN</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_berkas_content">
            </div>
        </div>
    </div>
  </div>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
    let list_anak;
                                                            
    $(function(){
        $('#sidebar_toggle').click()
        $('#mulai_masuk_pns').datepicker({
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            autoclose: true,
            todayBtn: true
        })
    })

    function deleteBerkas(id){
        if(confirm('Apakah Anda yakin ingin menghapus berkas?')){
            $('#btn_delete_berkas_pensiun').hide()
            $('#btn_delete_berkas_pensiun_loading').show()
            $.ajax({
                url: '<?=base_url('kepegawaian/C_Layanan/deleteBerkasPensiun/')?>'+id,
                method: 'POST',
                data: null,
                success: function(data){
                    $('#btn_delete_berkas_pensiun').hide()
                    $('#btn_delete_berkas_pensiun_loading').hide()
                    $('#btn_create_dpcp').show()
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        $('#btn_delete_berkas_pensiun').hide()
                        $('#btn_delete_berkas_pensiun_loading').hide()
                        $('#btn_create_dpcp').show()
                        $('#btn_show_dpcp').hide()
                        successtoast('Berkas berhasil dihapus')
                        window.location=""
                    } else {
                        $('#btn_delete_berkas_pensiun').show()
                        $('#btn_delete_berkas_pensiun_loading').hide()
                        errortoast(rs.message)
                    }
                }, error: function(err){
                    errortoast(err)
                    $('#btn_delete_berkas_pensiun').show()
                    $('#btn_delete_berkas_pensiun_loading').hide()
                }
            })
        }
    }

    function showDpcp(id){
        $('#modal_berkas_content').html('')
        $('#modal_berkas_content').append(divLoaderNavy)
        $('#modal_berkas_content').load('<?=base_url("kepegawaian/C_Layanan/showDpcp/")?>'+id, function(){
            $('#loader').hide()
        })
    }

    $('#form_create_dpcp').on('submit', function(e){
        e.preventDefault()
        // $('#qr_here').show()
        // var base64image;
        // const screenShotTarget = document.getElementById('qr_here');
		// html2canvas(screenShotTarget).then((canvas) => {
			// base64image = canvas.toDataURL("image/png");
            // $('#qr_here').hide()
            $('#btn_create_dpcp').hide()
            $('#btn_create_dpcp_loading').show()
            $.ajax({
                url: '<?=base_url('kepegawaian/C_Layanan/createDpcp/'.$profil_pegawai['nipbaru_ws'])?>',
                method: 'POST',
                data: null,
                success: function(data){
                    $('#btn_create_dpcp').show()
                    $('#btn_create_dpcp_loading').hide()
                    let rs = JSON.parse(data)
                    if(rs.code == 0){
                        $('#form_create_dpcp').hide()
                        $('#btn_show_dpcp').show()
                        successtoast('DPCP berhasil dibuat dan sudah diajukan untuk dilakukan Digital Signature')
                        window.location=""
                    } else {
                        errortoast(rs.message)
                    }
                }, error: function(err){
                    errortoast(err)
                    $('#btn_create_dpcp').show()
                    $('#btn_create_dpcp_loading').hide()
                }
            })
        // })
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

    $('#form_data_lainnya').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url('kepegawaian/C_Layanan/simpanDataLainnya/'.$id_t_checklist_pensiun)?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    successtoast('Data Berhasil Disimpan')
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    })
</script>