<!-- <div class="row">
    <div class="col-lg-3 p-3">
        <div class="card card-default">
            <div class="card-header" style="border-bottom: 1px solid black;">
                List Konsultasi
            </div>
            <div class="card-body" style="
                max-height: 70vh;
                overflow-y: auto;
                overflow-x: hidden;
                padding: 0;
            ">
                <?php if($riwayat_konsul){
                    $data['result'] = $riwayat_konsul;
                    $this->load->view('user/V_MonitoringOktaRiwayatKonsultasi', $data);
                ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9 p-3">

    </div>
</div> -->
<style>
    .sec_lbl_profile_top_monitoring_okta{
        font-weight: bold;
        color: grey;
        font-size: .6rem;
        font-style: italic;
    }

    .height-full{
        height: 75vh;
    }

    .height-not-full{
        height: 62vh;
    }

    #nama_profile_top_monitoring_okta:hover{
        cursor: pointer;
        color: green !important;
        text-decoration: underline !important;
    }
</style>

<div class="card card-default"
    style="border: 1px solid #efefef;
    border-radius: 5px;"
>
    <div class="card-header"
        style="
            background-color: #efefef;
        "
    >
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-9" style="
                padding: 5px !important;
            ">
                <div class="card-title" style="color: black;">MONITORING ONLINE KONSULTASI ASN (OKTA)</div>
            </div>
            <div class="col-lg-3 text-right float-right">
                <button class="btn-light btn btn-sm" id="btn_refresh_monitoring_okta" style="width: 30px; height: 30px;"><i class="fa fa-redo"></i></button>
                <button onclick="filterRiwayatKonsul()" id="btn_filter_monitoring_okta" class="btn-light btn btn-sm" style="width: 30px; height: 30px;">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0" style="
        -webkit-box-shadow: 0px 0px 7px 2px rgba(0,0,0,0.41); 
        box-shadow: 0px 0px 7px 2px rgba(0,0,0,0.41);
        border-radius: 10px;
    ">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3" id="list_riwayat_konsul_monitoring"
                style="
                    height: 75vh;
                    overflow-y: auto;
                    overflow-x: hidden;
                "
            >
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 pl-0" style="height: 75vh;">
                <div class="w-100" style="
                    background-image: url('<?=base_url('assets/img/bg-live-chat.png')?>');
                    background-size: 10vw;
                    width: 100%;
                    border-radius: 10px;
                    position: relative;
                ">
                    <div class="w-100 align-items-center div_profile_live_chat_monitoring" style="
                        background-color: #f1f3f1;
                        border-top-right-radius: 10px;
                        height: 13vh;
                        padding: 10px;
                        line-height: 10px;
                        -webkit-box-shadow: 0px 5px 14px 0px rgba(0,0,0,0.87); 
                        box-shadow: 0px 5px 14px 0px rgba(0,0,0,0.87);
                        display: none;
                    ">
                        <table style="width: 100%;">
                            <tr>
                                <td class="text-center" rowspan=5 style="width: 10%;">
                                    <img style="
                                        width: 70%;
                                        border-radius: 50%;
                                        aspect-ratio: 1;
                                        object-fit: cover;
                                    "
                                        src="" id="foto_profile_top_monitoring_okta" />
                                </td>
                                <td rowspan=1 style="width: 90%;">
                                    <span style="
                                        font-size: .7rem;
                                        font-weight: bold;
                                        color: black;
                                    " id="nama_profile_top_monitoring_okta"></span>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=1>
                                    <span class="sec_lbl_profile_top_monitoring_okta" id="nip_profile_top_monitoring_okta"></span>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=1>
                                    <span class="sec_lbl_profile_top_monitoring_okta" id="jabatan_profile_top_monitoring_okta"></span>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=1>
                                    <span class="sec_lbl_profile_top_monitoring_okta" id="skpd_profile_top_monitoring_okta"></span>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=1>
                                    <span class="sec_lbl_profile_top_monitoring_okta" style="
                                        font-style: normal !important;
                                        font-size: .6rem;
                                    "
                                        id="jenis_layanan_profile_top_monitoring_okta"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="w-100 wrapper_div_monitoring_konsultasi_detail height-full" 
                        style="
                            overflow-y: auto;
                            display: flex;
                            overflow-x: hidden;
                            flex-direction: column-reverse;
                            padding: 15px;
                        "
                    >
                        <div class="row div_monitoring_konsultasi_detail">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_filter" tabindex="-1" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">FILTER RIWAYAT KONSULTASI</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_filter_content" class="p-3">
                <?php
                    $data['skpd'] = $skpd;
                    $data['jenis_layanan'] = $jenis_layanan;
                    $this->load->view('user/V_MonitoringOktaSearchRiwayat', $data);
                ?>
            </div>
        </div>
    </div>
  </div>

<script>
    let id_konsul_aktif = '<?= isset($id_konsul_aktif) ? $id_konsul_aktif : 0 ?>'

    $(function(){
        loadRiwayatChatMonitoringOkta()
        $('.wrapper_div_monitoring_konsultasi_detail').addClass('height-full')
    })

    function filterRiwayatKonsul(){
        $('#modal_filter').modal('show')
    }

    function loadRiwayatChatMonitoringOkta(id_konsul = 0){
        $('#list_riwayat_konsul_monitoring').html('')
        $('#list_riwayat_konsul_monitoring').append(divLoaderNavy)
        $('#list_riwayat_konsul_monitoring').load('<?=base_url("user/C_User/loadRiwayatKonsultasiMonitoringOkta/")?>'+id_konsul, function(){
            $('#loader').hide()
        })
    }
    
    $('#btn_refresh_monitoring_okta').on('click', function(){
        if(id_konsul_aktif !== 0){
            openKonsultasiDetailMonitoring(id_konsul_aktif)
        }
        loadRiwayatChatMonitoringOkta()
    })
</script>