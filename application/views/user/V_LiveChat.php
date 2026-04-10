<style>
    :root{
      --primary-color-live-chat: #222e3c;
    }

    .div_riwayat_live_chat, .div_pilih_layanan_konsultasi{
        background-color: white;
        margin-top: 10px;
        border-radius: 10px;
        min-height: 70vh;
    }

    .div_riwayat_live_chat_admin{
        min-height: 75vh !important;
    }

    .ellipsis_this{
        display: -webkit-box; /* Required for older browser compatibility */
        -webkit-box-orient: vertical; /* Required for older browser compatibility */
        -webkit-line-clamp: 1; /* Limits text to 3 lines */
        overflow: hidden;
        text-overflow: ellipsis; /* Ensures the ellipsis appears */
    }

    .popup_live_chat_container{
        position: absolute;
        width: 100%;
        top: 15%;
        padding-left: 30px;
        padding-right: 30px;
        display: none;
    }

    .popup_live_chat_body{
        max-height: 60vh;
        background-color: white;
        border-radius: 10px;
    }

    .overlay_for_popup{
        filter: brightness(60%); 
        pointer-events: none; 
        cursor: not-allowed;
        user-select: none; /* Prevents text selection */
        opacity: 0.7; 
    }

    .popup_title{
        color: black;
        font-weight: bold;
        font-size: 1rem;
    }
</style>

<div class="container_live_chat">
    <?php if($this->general_library->isHakAkses('admin_live_chat_konsultasi') || $this->general_library->isProgrammer()){ ?> 
        <div class="row p-4">
            <div class="col-lg-12 text-center" style="height: 100%;">
                <div class="row" id="div_start_konsultasi">
                    <center><img src="<?=base_url('assets/img/icon-siladen-new.png')?>" style="width: 100px;" /></center>
                    <br>
                    <!-- <button class="mt-3 btn btn-info btn_konsultasi">Mulai Konsultasi</button>
                    <button style="display:none;" class="mt-3 btn btn-info btn_konsultasi_loader"><i class="fa fa-spinner"></i> Menunggu...</button> -->
                    <div class="col-lg-12 div_riwayat_live_chat div_riwayat_live_chat_admin">
                        <div class="row">
                            <div class="col-lg-12 pt-3" style="border-bottom: 1px solid grey;">
                                <h4>Admin Konsultasi Online</h4>
                            </div>
                            <div class="col-lg-12 div_riwayat_chat"></div>
                        </div>
                    </div>
                </div>
                <div style="display: none;" class="row" id="div_chat_konsultasi"></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row p-4">
            <div class="col-lg-12 text-center" style="height: 100%;">
                <div class="row" id="div_start_konsultasi">
                    <center><img src="<?=base_url('assets/img/icon-siladen-new.png')?>" style="width: 100px;" /></center>
                    <br>
                    <button class="mt-3 btn btn-info btn_konsultasi">Mulai Konsultasi</button>
                    <button style="display:none;" class="mt-3 btn btn-info btn_konsultasi_loader"><i class="fa fa-spinner"></i> Menunggu...</button>

                    <div style="display: none;" class="col-lg-12 div_pilih_layanan_konsultasi">
                    </div>

                    <div class="col-lg-12 div_riwayat_live_chat">
                        <div class="row">
                            <div class="col-lg-12 pt-3" style="border-bottom: 1px solid grey;">
                                <h4>Riwayat Konsultasi Online</h4>
                            </div>
                            <div class="col-lg-12 div_riwayat_chat"></div>
                        </div>
                    </div>
                </div>
                <div style="display: none;" class="row" id="div_chat_konsultasi"></div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="popup_live_chat_container">
    <div class="popup_live_chat_body p-3">
        <div class="row">
            <div class="col-lg-12 popup_header d-flex align-items-center">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <span class="popup_title">POP UP DIV</span>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                    <span class=""><i style="cursor:pointer;" onclick="hidePopupLiveChat()" class="fa fa-times"></i></span>
                </div>
            </div>
            <div class="col-lg-12">
                <hr style="margin-bottom: 0 !important;">
            </div>
            <div class="col-lg-12 popup_body">
            </div>
        </div>
    </div>
</div>

<script>
    var cekWaktuKerja;
    $(function(){
        loadRiwayatChat()
    })

    function showPopupLiveChat(title = ""){
        if(title != ""){
            $('.popup_title').html(title)
        }
        $('.popup_live_chat_container').show(300)
        $('.container_live_chat').addClass('overlay_for_popup')
    }

    function hidePopupLiveChat(){
        $('.popup_live_chat_container').hide(300)
        $('.container_live_chat').removeClass('overlay_for_popup')
    }

    function loadRiwayatChat(){
        $('.div_riwayat_chat').html('')
        $('.div_riwayat_chat').append(divLoaderNavy)
        $('.div_riwayat_chat').load('<?=base_url("user/C_User/loadRiwayatKonsultasi")?>', function(){
            $('#loader').hide()
        })
    }

    function startKonsultasi(){
        // $.ajax({
        //     url: '<?=base_url("user/C_User/startKonsultasi")?>',
        //     method: 'post',
        //     data: $(this).serialize(),
        //     success: function(data){
        //         let rs = JSON.parse(data)
        //         if(rs.code == 1){
        //             errortoast(rs.message)
        //         } else {
        //             openKonsultasiDetail(rs.id)
        //         }
        //         // $('.btn_konsultasi_loader').hide()
        //         // $('.btn_konsultasi').show()
        //     }, error: function(e){
        //         errortoast('Terjadi Kesalahan')
        //     }
        // })
    }

    function cekJamKerjaKonsultasi(){
        $.ajax({
            url: '<?=base_url("user/C_User/cekWaktuKerjaKonsultasi")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 0){
                    showPopupLiveChat('Pilih Jenis Layanan')
                    $('.popup_body').html('')
                    $('.popup_body').append(divLoaderNavy)
                    $('.popup_body').load('<?=base_url("user/C_User/loadLayananKonsultasi/0/1")?>', function(){
                        $('#loader').hide()
                    })
                } else {
                    errortoast(rs.message)
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('.btn_konsultasi').on('click', function(){
        // $('.div_riwayat_live_chat').hide()
        // $('.div_pilih_layanan_konsultasi').show()
        // $('.div_pilih_layanan_konsultasi').html('')
        // $('.div_pilih_layanan_konsultasi').append(divLoaderNavy)
        // $('.div_pilih_layanan_konsultasi').load('<?=base_url("user/C_User/loadLayananKonsultasi")?>', function(){
        //     $('#loader').hide()
        // })
        cekJamKerjaKonsultasi()
    })

    function openKonsultasiDetail(id){
        $('#div_start_konsultasi').hide()
        $('#div_chat_konsultasi').show()
        $('#div_chat_konsultasi').html('')
        $('#div_chat_konsultasi').append(divLoaderNavy)
        $('#div_chat_konsultasi').load('<?=base_url("user/C_User/openKonsultasiDetail/")?>'+id, function(){
            $("#loader").hide()
        })
    }
</script>