<style>
    .sp_chat_id_chatkonsul{
        font-size: .9rem;
        color: #f9fbf9;
        font-weight: bold;
    }

    .sp_chat_pesan_chatkonsul{
        font-size: .9rem;
        color: #272727;
        font-weight: 900;
        float: left;
        text-align: left;
    }

    .sp_jam_pesan_chatkonsul{
        font-size: .75rem;
        color: #767676;
        font-weight: 500;
        padding: 0;
        /* float: right; */
    }

    .sp_jam_pesan_chatkonsul_left{
        float: right;
    }

    .sp_jam_pesan_chatkonsul_right{
        float: right;
    }

    .div_chat{
        padding: 10px;
        border-radius: 10px;
        max-width: 240px;
        -webkit-box-shadow: 3px 3px 6px 1px rgba(82,82,82,0.46); 
        box-shadow: 3px 3px 6px 1px rgba(82,82,82,0.46);
        /* position: absolute;
        bottom: 10px; */
    }

    .div_chat_left{
        background-color: #99efe8;
        float: left;
    }

    .div_chat_right{
        background-color: #e6e6e6;
        float: right;
    }

    .lbl_rating_nm{
        font-size: .75rem;
        color: grey;
        font-weight: bold;
    }

    .lbl_rating_val{
        font-size: .9rem;
        color: black;
        font-weight: bold;
    }

    .btn_icon{
        display: flex;
        justify-content: center; /* Centers horizontally */
        align-items: center;
        padding: 0;
    }

    .div_quick_message:hover span{
        /* color: green; */
    }

    .item_quick_message{
        width: 90%;
        background-color: white;
        border: 1px solid grey;
        border-radius: 5px;
        color: black;
        font-size: .7rem;
        font-weight: bold;
        text-align: left;
        padding: 5px;
        margin-bottom: 5px;
    }

    .item_quick_message:hover{
        width: 90%;
        background-color: var(--primary-color);
        border: 1px solid grey;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: .2s;
    }

    .sp-response-cepat:hover{
        color: green;
        transition: .2s;
    }
</style>
<div class="col-lg-7 col-md-7 col-sm-7 text-left">
    <span style="cursor:pointer;" class="sp_chat_id_chatkonsul btn_back_chatkonsul"><i class="fa fa-chevron-left"></i></span>
    <?php
        if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('admin_live_chat_konsultasi')){
            $userAssign = null;
            if($result['chat']['id_m_user_assigned']){
                $userAssign = [
                    'nama' => $result['chat']['nama_assign'],  
                    'gelar1' => $result['chat']['gelar1_assign'],  
                    'gelar2' => $result['chat']['gelar2_assign'],
                ];
            }
    ?>
    <?php if($userAssign){ ?>
        &nbsp;&nbsp;
        <span style="cursor: pointer;" title="<?=getNamaPegawaiFull($userAssign)?>" class="sp_chat_id_chatkonsul">
            <i class="fa fa-headset"></i>&nbsp;&nbsp;<?=getNamaPegawaiFull($userAssign, 1, 1)?>
        </span>
    <?php } } ?>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 text-right">
    <div class="btn-group" role="group">
        <button id="btn-group-konsultasi" type="button" class="btn btn-sm btn-outline-warning dropdown-toggle"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sp_chat_id_chatkonsul">&nbsp;#<?=$result['chat']['chat_id']?></span>
        </button>
        <div class="dropdown-menu" aria-labelledby="btn-group-konsultasi"
            style="
                margin: 0;
                padding: 0;
            "
        >
            <?php if($result['chat']['flag_done'] == 0){ ?>
                <?php if($this->general_library->isHakAkses('admin_live_chat_konsultasi') ||
                    $this->general_library->isProgrammer()){ ?>
                    <a class="dropdown-item" onclick="pilihTeknisLayanan('<?=$result['chat']['id']?>')"><?=(!$result['chat']['id_m_user_assigned']) ? "Assign" : "Ganti"?> Operator</a>
                    <a class="dropdown-item" onclick="gantiJenisLayanan('<?=$result['chat']['id']?>')">Jenis Layanan</a>
                <?php } ?>
                <hr style="margin: 0 !important;">
                <a class="dropdown-item" onclick="endKonsultasi('<?=$result['chat']['id']?>')">Akhiri Konsultasi</a>
            <?php } else { ?>
                <!-- <a class="dropdown-item" onclick="endKonsultasi('<?=$result['chat']['id']?>')" >Akhiri Konsultasi</a> -->
            <?php } ?>
        </div>
    </div>
</div>
<?php
    $heightChatContainer = "90vh";
    $paddingBottomChat = "70px";
    if($result['chat']['flag_done'] == 1 && $result['chat']['flag_rating'] == 1){
        $paddingBottomChat = "0px";
    }
?>
<div id="div_live_chat_container" class="col-lg-12 mt-2" style="
    /* background-color: #f9fbf9; */
    background-image: url('<?=base_url('assets/img/bg-live-chat.png')?>');
    background-repeat: no-repeat;
    height: <?=$heightChatContainer?>;
    overflow-y: auto;
    display: flex;
    flex-direction: column-reverse;
    padding-bottom: <?=$paddingBottomChat?>;
    background-position: center;
    background-repeat: repeat;
    background-size: 50%;
">  
    <div class="row" id="live_chat_container">
    </div>
</div>

<div class="col-lg-12 mt-2" id="div_assign_operator" style="
        display: none;
        background-color: #f9fbf9;
        height: <?=$heightChatContainer?>;
    ">
    <div class="row p-3" id="assign_operator_container">
    </div>
</div>
<div class="profile_live_chat_container" style="
    background-color: #f9fbf9;
    position: absolute;
    line-height: 12px;
    padding: 10px;
    top: 60px;
    width: 326px;
    box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);
    -webkit-box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);
    -moz-box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);">
    <table id="mini_profile_live_chat_cotainer" style="cursor: pointer; border: 0;">
        <tr>
            <td rowspan=4 style="width: 15%;">
                <img style="
                    border-radius: 50% !important;
                    width: 100%;
                    aspect-ratio: 1;
                    object-fit: cover" class="img-fluid b-lazy"
                        src="<?php
                            $path = './assets/fotopeg/'.$result['chat']['fotopeg'];
                            // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                            if($result['chat']['fotopeg']){
                            if (file_exists($path)) {
                            $src = './assets/fotopeg/'.$result['chat']['fotopeg'];
                            //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                            } else {
                            $src = './assets/img/user.png';
                            // $src = '../siladen/assets/img/user.png';
                            }
                            } else {
                            $src = './assets/img/user.png';
                            }
                            echo base_url().$src;?>" /> 
            </td>
            <td class="text-left" rowspan=1 style="width: 85%;">
                <span class="sp_profil_nama_pegawai_live_chat ellipsis_this"><?=getNamaPegawaiFull($result['chat'])?></span><br>
                <span class="sp_profil_pegawai_live_chat ellipsis_this" style="
                    font-style: italic;
                    margin-top: -10px;
                "><?=($result['chat']['nama_layanan'])?></span>
            </td>
        </tr>
    </table>
    <div style="cursor: pointer; display: none;" id="detail_profile_live_chat_cotainer" class="col-lg-12">
        <img style="
            border-radius: 50% !important;
            width: 35%;
            aspect-ratio: 1;
            object-fit: cover" class="img-fluid b-lazy"
                src="<?php
                    $path = './assets/fotopeg/'.$result['chat']['fotopeg'];
                    // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                    if($result['chat']['fotopeg']){
                    if (file_exists($path)) {
                    $src = './assets/fotopeg/'.$result['chat']['fotopeg'];
                    //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                    } else {
                    $src = './assets/img/user.png';
                    // $src = '../siladen/assets/img/user.png';
                    }
                    } else {
                    $src = './assets/img/user.png';
                    }
                    echo base_url().$src;?>" /><br><br>
        <span class="sp_profil_nama_pegawai_live_chat"><?=getNamaPegawaiFull($result['chat'])?></span><br>
        <span class="sp_profil_pegawai_live_chat">NIP. <?=($result['chat']['nipbaru_ws'])?></span><br>
        <span style="line-height: 10px !important;" class="sp_profil_pegawai_live_chat"><?=($result['chat']['nama_jabatan'])?></span><br>
        <span style="line-height: 10px !important;" class="sp_profil_pegawai_live_chat"><?=($result['chat']['nm_unitkerja'])?></span>
    </div>
</div>
<?php if($result['chat']['flag_done'] == 0){ ?>
    <!-- <div class="div_file_option" style="
        position: absolute;
        bottom: 65px;
        z-index: 1;
        left: 18px;
        width: 15vw;
        text-align: left;
        background-color: red;
    ">
    </div> -->
    <form id="form_send_message" method="post" enctype="multipart/form-data" style="
        position: absolute;
        bottom: 0;
        left: 0;
    ">
        <center>
            <div style="
                background-color: #d9d9d9;
                padding: 1px 5px 5px 5px;
                margin-bottom: 8px;
                box-shadow: 0 -10px 10px -10px rgba(0, 0, 0, 0.5);
                border-radius: 10px 10px 0 0;
            ">
                <?php if($this->general_library->isProgrammer() ||
                    $this->general_library->isHakAkses('admin_live_chat_konsultasi') ||
                    $this->general_library->getId() == $result['chat']['id_m_user_assigned']
                    ) {?>
                    <div class="col-lg-12 div_quick_message">
                        <span id="sp_tampil_response_cepat" class="sp-response-cepat" style="
                            font-weight: bold;
                            font-size: .65rem;
                            cursor: pointer;
                        ">Tampilkan Response Cepat <i class="fa fa-chevron-up"></i></span>
                        <span id="sp_simpan_response_cepat" class="sp-response-cepat" style="
                            font-weight: bold;
                            font-size: .65rem;
                            cursor: pointer;
                            display: none;
                        ">Sembunyikan <i class="fa fa-chevron-down"></i></span>
                        <div id="div_list_quick_message" style="display: none;" class="col-lg-12">
                            <div class="row">
                                <center>
                                <div class="col-lg-12 item_quick_message">
                                    <a onclick="sendQuickResponseMessage('quick_message_1')" id="quick_message_1">Selamat <?=greeting()?> <?=$result['chat']['jk'] == "Perempuan" ? "ibu" : "bapak"?> <?=getNamaPegawaiFull($result['chat'], 0, 1)?>, ada yang bisa kami bantu?</a>
                                </div>
                                <div class="col-lg-12 item_quick_message">
                                    <a onclick="sendQuickResponseMessage('quick_message_2')" id="quick_message_2">Baik <?=$result['chat']['jk'] == "Perempuan" ? "ibu" : "bapak"?>, silahkan menunggu untuk kami tindak lanjuti.</a>
                                </div>
                                <div class="col-lg-12 item_quick_message">
                                    <a onclick="sendQuickResponseMessage('quick_message_3')" id="quick_message_3">Apakah penjelasan yang diberikan sudah jelas? Apakah masih ada yang ingin ditanyakan?</a>
                                </div>
                                <div class="col-lg-12 item_quick_message">
                                    <a onclick="sendQuickResponseMessage('quick_message_4')" id="quick_message_4">
                                        Terima kasih <?=$result['chat']['jk'] == "Perempuan" ? "ibu" : "bapak"?> <?=getNamaPegawaiFull($result['chat'], 0, 1)?> sudah menghubungi BKPSDM. Semoga penjelasan yang diberikan dapat membantu kendala yang <?=$result['chat']['jk'] == "Perempuan" ? "ibu" : "bapak"?> temui.<br><br>Mohon berkenan untuk memberikan penilaian dan komentar serta masukkan jika ada yang <?=$result['chat']['jk'] == "Perempuan" ? "ibu" : "bapak"?> rasakan masih kurang.
                                    </a>
                                </div>
                                </center>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-lg-12" style="
                    width: 90%;">
                    <div class="row"
                        style="
                            display: flex;
                            align-items: center;
                            background-color: #f9fafb;
                            border-radius: 50px;
                            padding: 3px 0px 3px 0px;
                        ">   
                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center">
                            <input type="file" accept="image/*, .pdf" name="file" id="upload_file" style="position: absolute; z-index: -10000;" />
                            <button id="btn_add_file" type="button" style="
                                width: 30px;
                                height: 30px;
                                margin-left: -5px;"
                                class="btn btn_icon btn-outline-info rounded-circle p-2">
                                <i class="fa fa-plus"></i>
                            <button id="btn_cancel_add_file" type="button" style="
                                width: 30px;
                                height: 30px;
                                margin-left: -5px;
                                display: none;"
                                class="btn btn_icon btn-outline-danger rounded-circle p-2">
                                <i class="fa fa-times"></i>
                            </button>
                            <textarea name="pesan" id="pesan" style="
                                resize: none;
                                width: 100%;
                                height: 30px;
                                margin-top: 5px;
                                background-color: #f9fafb;
                                overflow: hidden;
                                padding: 1px 0px 0px 3px;
                                outline: none;
                                font-size: 1rem;
                                border: 0;
                                line-height: 20px;
                                margin-left: 3px;
                            "
                            placeholder="Tulis pesan disini..."></textarea>
                            <div class="div_file_uploaded w-100 d-none align-items-center p-2"
                                style="">
                                <i style="font-size: 1.3rem;" id="fa_file_icon" class="text-info fa fa-file"></i>
                                <i style="font-size: 1.3rem;" id="fa_file_image" class="text-info fa fa-image"></i>
                                <span class="ml-2 ellipsis_this fw-bold text-left" id="file_name_uploaded"></span>
                            </div>
                            <button id="btn_send_message" type="submit" style="
                                width: 30px;
                                height: 30px;
                                margin-right: -5px;
                            "
                            class="btn btn_icon btn-success rounded-circle p-2">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                            <button id="btn_send_message_loading" type="button" disabled style="
                                width: 30px;
                                height: 30px;
                                display: none;
                                margin-right: -5px;
                            "
                            class="btn btn_icon btn-success rounded-circle p-2">
                                <i class="fa fa-spin fa-spinner"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </form>
<?php } else { ?>
    <?php if($this->general_library->isProgrammer() ||
        $this->general_library->isHakAkses('admin_live_chat_konsultasi') ||
        $this->general_library->getId() == $result['chat']['id_m_user_assigned']
        ) {?>
        <?php if($result['chat']['flag_rating_pegawai'] == 1){ ?>
            <div class="col-lg-12 mt-3" style="
                    width: 100%;
                    max-height: 25vh;
                    background-color: white;
                    border-radius: 10px;
                    padding: 10px;
                    overflow-y: auto;
                    overflow-x: hidden;
                ">
                RATING PEGAWAI
                <div class="row">
                    <div class="col-lg-12 text-left">
                        <span class="lbl_rating_nm">Waktu Respon</span><br>
                        <?php // for($i = 1; $i <= $result['chat']['rating_kecepatan']; $i++){ ?>
                        <?php for($i = 1; $i <= 5; $i++){ ?>
                            <?php if($i <= $result['chat']['rating_kecepatan_pegawai']){ ?>
                                <i style="font-size: 1rem;" class="text-warning fa fa-star"></i>
                            <?php } else { ?>
                                <i style="font-size: 1rem;" class="text-muted fa fa-star"></i>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 text-left">
                        <span class="lbl_rating_nm">Bahasa yang Digunakan</span><br>
                        <?php for($i = 1; $i <= 5; $i++){ ?>
                            <?php if($i <= $result['chat']['rating_bahasa_pegawai']){ ?>
                                <i style="font-size: 1rem;" class="text-warning fa fa-star"></i>
                            <?php } else { ?>
                                <i style="font-size: 1rem;" class="text-muted fa fa-star"></i>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 mt-1 text-right">
                        <span class="lbl_rating_nm"><?=formatDateNamaBulanWT($result['chat']['date_rating_pegawai'])?></span><br>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-lg-12 mt-3">
                <button onclick="endKonsultasi('<?=$result['chat']['id']?>')" style="width: 100% !important;"
                    class="btn btn-block btn-warning"><i class="fa fa-input"></i> Berikan Penilaian</button>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if($result['chat']['flag_rating'] == 1){ ?>
        <div class="col-lg-12 mt-3" style="
                width: 100%;
                max-height: 25vh;
                background-color: white;
                border-radius: 10px;
                padding: 10px;
                overflow-y: auto;
                overflow-x: hidden;
            ">
            RATING KONSULTASI
            <div class="row">
                <div class="col-lg-6 text-left">
                    <span class="lbl_rating_nm">Waktu Respon</span><br>
                    <?php // for($i = 1; $i <= $result['chat']['rating_kecepatan']; $i++){ ?>
                    <?php for($i = 1; $i <= 5; $i++){ ?>
                        <?php if($i <= $result['chat']['rating_kecepatan']){ ?>
                            <i style="font-size: 1rem;" class="text-warning fa fa-star"></i>
                        <?php } else { ?>
                            <i style="font-size: 1rem;" class="text-muted fa fa-star"></i>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="col-lg-6 text-left">
                    <span class="lbl_rating_nm">Ketepatan Informasi</span><br>
                    <?php for($i = 1; $i <= 5; $i++){ ?>
                        <?php if($i <= $result['chat']['rating_ketepatan']){ ?>
                            <i style="font-size: 1rem;" class="text-warning fa fa-star"></i>
                        <?php } else { ?>
                            <i style="font-size: 1rem;" class="text-muted fa fa-star"></i>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="col-lg-12 mt-3 text-left">
                    <span class="lbl_rating_nm">Kritik dan Saran</span><br>
                    <span class="lbl_rating_val"><?=$result['chat']['kritik_saran']?></span><br>
                </div>
                <div class="col-lg-12 mt-1 text-right">
                    <span class="lbl_rating_nm"><?=formatDateNamaBulanWT($result['chat']['date_rating'])?></span><br>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <?php if(!$this->general_library->isProgrammer() &&
            !$this->general_library->isHakAkses('admin_live_chat_konsultasi') &&
            $this->general_library->getId() != $result['chat']['id_m_user_assigned']
            ) { ?>
        <div class="col-lg-12 mt-3">
            <button onclick="endKonsultasi('<?=$result['chat']['id']?>')" style="width: 100% !important;"
                class="btn btn-block btn-warning"><i class="fa fa-input"></i> Berikan Penilaian</button>
        </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
<script>
    $(function(){
        reloadLiveChatContainer('<?=$result['chat']['id']?>')
    })

    $('#sp_tampil_response_cepat').on('click', function(){
        $('#div_list_quick_message').show()
        $('#sp_tampil_response_cepat').hide()
        $('#sp_simpan_response_cepat').show()
    })

    $('#sp_simpan_response_cepat').on('click', function(){
        $('#div_list_quick_message').hide()
        $('#sp_tampil_response_cepat').show()
        $('#sp_simpan_response_cepat').hide()
    })

    $('#upload_file').change(function(){
        if (this.files && this.files.length > 0) {
            if(this.files[0].size > 1000000){
                errortoast('Max. Ukuran File adalah 1 MB')
                return false
            }
            $('#btn_cancel_add_file').show()
            $('#btn_add_file').hide()
            let fileName = this.files[0].name;
            $('#file_name_uploaded').html(fileName)
            $('#pesan').hide()
            $('.div_file_uploaded').removeClass('d-none')
            $('.div_file_uploaded').addClass('d-flex')
            if (this.files[0].type === "application/pdf") {
                $('#fa_file_icon').show()
                $('#fa_file_image').hide()
            } else {
                $('#fa_file_icon').hide()
                $('#fa_file_image').show()
            }
        } else {
            $('#btn_cancel_add_file').click()
        }
    })

    $('#btn_cancel_add_file').on('click', function(){
        $('#btn_cancel_add_file').hide()    
        $('#btn_add_file').show()
        $('#pesan').show()
        $('.div_file_uploaded').removeClass('d-flex')
        $('.div_file_uploaded').addClass('d-none')
        $('#upload_file').val('')
    })

    $('#btn_add_file').on('click', function(){
        $('#upload_file').click()
    })

    $('#mini_profile_live_chat_cotainer').on('click', function(){
        $(this).hide()
        $('#detail_profile_live_chat_cotainer').show()
    })

    $('#detail_profile_live_chat_cotainer').on('click', function(){
        $(this).hide()
        $('#mini_profile_live_chat_cotainer').show()
    })

    function gantiJenisLayanan(id){
        showPopupLiveChat('Ganti Jenis Layanan')
        $('.popup_body').html('')
        $('.popup_body').append(divLoaderNavy)
        $('.popup_body').load('<?=base_url("user/C_User/loadLayananKonsultasi/")?>'+id+'/1', function(){
            $('#loader').hide()
        })
    }

    function pilihTeknisLayanan(id){
        showPopupLiveChat('Pilih Teknis Layanan')
        $('.popup_body').html('')
        $('.popup_body').append(divLoaderNavy)
        $('.popup_body').load('<?=base_url("user/C_User/assignOperatorKonsultasi/")?>'+id+'/1', function(){
            $('#loader').hide()
        })

        // $('#div_live_chat_container').hide()
        // $('#div_assign_operator').show()
        // $('#assign_operator_container').html('')
        // $('#assign_operator_container').append(divLoaderNavy)
        // $('#assign_operator_container').load('<?=base_url("user/C_User/assignOperatorKonsultasi/")?>'+id, function(){
        //     $('#loader').hide()
        // })
    }
    
    function endKonsultasi(id){
        $.ajax({
            url: '<?=base_url("user/C_User/endKonsultasi/")?>'+id,
            method: 'post',
            data: null,
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    if(confirm('Apakah Anda yakin?')){
                        $('#div_start_konsultasi').hide()
                        $('#div_chat_konsultasi').show()
                        $('#div_chat_konsultasi').html('')
                        $('#div_chat_konsultasi').append(divLoaderNavy)
                        $('#div_chat_konsultasi').load('<?=base_url('user/C_User/ratingKonsultasi/')?>'+id, function(){
                            $('#loader').hide()
                        })
                    }
                } else {
                    successtoast('Konsultasi dihapus karena belum terjadi percakapan')
                    backToStartView()
                }
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function backToStartView(){
        $('#div_start_konsultasi').show()
        $('#div_chat_konsultasi').html('')
        $('#div_chat_konsultasi').hide()
        loadRiwayatChat()
    }

    $('.btn_back_chatkonsul').on('click', function(){
        backToStartView()
    })

    function sendQuickResponseMessage(id){
        $('#pesan').val($('#'+id).html())
        $('#form_send_message').submit()
        $('#sp_simpan_response_cepat').click()
        // $.ajax({
        //     url: '<?=base_url("user/C_User/sendMessageKonsultasi/".$result['chat']['id'])?>',
        //     method: 'POST',
        //     data: {
        //         'pesan' : $('#'+id).html(),
        //     },
        //     success: function(data){
        //         let rs = JSON.parse(data)
        //         if(rs.code == 1){
        //             errortoast(rs.message)
        //         } else {
        //             $('#sp_simpan_response_cepat').click()
        //             reloadLiveChatContainer('<?=$result['chat']['id']?>')
        //             // $('#pesan').val('')
        //         }
        //         // $(this).show()
        //         // $('#btn_cancel_add_file').click()
        //         // $('#btn_send_message').show()
        //         // $('#btn_send_message_loading').hide()
        //     }, error: function(e){
        //         errortoast('Terjadi Kesalahan')
        //     }
        // })
    }

    $('#form_send_message').on('submit', function(e){
        e.preventDefault()
        // $('#btn_send_message').click()
        var formvalue = $('#form_send_message');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('upload_file').files.length;

        if(ins === 0 && $('#pesan').val() === ""){
            return false
        }

        $('#btn_send_message').hide()
        $('#btn_send_message_loading').show()

        if(ins !== 0 && document.getElementById('upload_file').files[0].size > 1000000){
            errortoast('Max. Ukuran File adalah 1 MB')
            return false
        }

        $.ajax({
            url: '<?=base_url("user/C_User/sendMessageKonsultasi/".$result['chat']['id'])?>',
            method: "POST",
            contentType: false,  
            cache: false,  
            processData: false, 
            // data: {
            //     'id' : '<?=$result['chat']['id']?>',
            //     'pesan' : $('#pesan').val(),
            //     'id_m_user_sender' : '<?=$this->general_library->getId()?>'
            // },
            data: form_data,  
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    reloadLiveChatContainer('<?=$result['chat']['id']?>')
                    $('#pesan').val('')
                }
                $(this).show()
                $('#btn_cancel_add_file').click()
                $('#btn_send_message').show()
                $('#btn_send_message_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function reloadLiveChatContainer(id){
        // $('#live_chat_container').html('')
        $('#live_chat_container').load('<?=base_url('user/C_User/reloadChatContainer/')?>'+id)
    }

    $('#pesan').on('keydown', function(e){
        console.log($('#pesan').val().split('\n').length)
        if (e.key === 'Enter' && e.shiftKey) {
            e.preventDefault(); // Mencegah perilaku default
            const cursorPosition = this.selectionStart;
            const text = this.value;
            // Menambahkan baris baru pada posisi kursor
            this.value = text.substring(0, cursorPosition) + "\n" + text.substring(this.selectionEnd);
            this.selectionStart = this.selectionEnd = cursorPosition + 1;
        } else if(e.key === "Enter"){
            e.preventDefault()
            $('#form_send_message').submit()
        }
    })

    $('#btn_send_message').on('click', function(){
        // $(this).hide()
        // $('#btn_send_message_loading').show()
    })
</script>