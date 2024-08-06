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
        color: grey;
    }

    .sp_profil_sm{
        font-size: 1rem;
        font-weight: bold;
    }

    .card-belum-lengkap{
        border: 2px solid rgba(0, 0, 0, .3);
        background-color: transparent;
    }

    .card-title-pdm{
        font-size: 15px;
        font-weight: bold;
        color: black;
        vertical-align: middle;
    }
</style>

<div class="card card-default">
    <div class="card-header" style="margin-bottom: -15px;">
        <h4 class="card-title" style="color: black !important;">KELENGKAPAN BERKAS PENSIUN</h4>
        <hr>
    </div>
    <div class="card-body">
        <div class="row" style="margin-bottom: -15px;">
            <div class="col-lg-3">
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
            <div class="col-lg-9">
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
                </div>
            </div>
            <div class="col-lg-12">
                <hr>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-default card-pdm p-3 card-belum-lengkap">
                            <div class="col-12 text-center">
                                <i class="text-dark fa fa-file fa-3x"></i>
                            </div>
                            <hr>
                            <div class="col-12 text-center">
                                <span class="card-title-pdm">SK CPNS</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-default card-pdm p-3 card-belum-lengkap">
                            <div class="col-12 text-center">
                                <i class="text-dark fa fa-file fa-3x"></i>
                            </div>
                            <hr>
                            <div class="col-12 text-center">
                                <span class="card-title-pdm">SK PNS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#sidebar_toggle').click()
    })
</script>