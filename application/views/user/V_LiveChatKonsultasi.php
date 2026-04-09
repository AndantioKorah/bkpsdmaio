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
    background-color: #f9fbf9;
    height: <?=$heightChatContainer?>;
    overflow-y: auto;
    display: flex;
    flex-direction: column-reverse;
    padding-bottom: <?=$paddingBottomChat?>;
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
    <form id="form_send_message" style="
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
                <div class="col-lg-12 mt-2" style="
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
                            <input type="file" accept="image/*, .pdf" id="upload_file" style="display: none;" />
                            <button id="btn_add_file" type="button" style="
                                width: 30px;
                                height: 30px;
                                margin-left: -5px;
                            "
                            class="btn btn_icon btn-outline-info rounded-circle p-2">
                                <i class="fa fa-plus"></i>
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
        $('#div_live_chat_container').hide()
        $('#div_assign_operator').show()
        $('#assign_operator_container').html('')
        $('#assign_operator_container').append(divLoaderNavy)
        $('#assign_operator_container').load('<?=base_url("user/C_User/assignOperatorKonsultasi/")?>'+id, function(){
            $('#loader').hide()
        })
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

    $('#form_send_message').on('submit', function(e){
        e.preventDefault()
        $('#btn_send_message').click()
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
        $.ajax({
            url: '<?=base_url("user/C_User/sendMessageKonsultasi")?>',
            method: 'post',
            data: {
                'id' : '<?=$result['chat']['id']?>',
                'pesan' : $('#pesan').val(),
                'id_m_user_sender' : '<?=$this->general_library->getId()?>'
            },
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    reloadLiveChatContainer('<?=$result['chat']['id']?>')
                    $('#pesan').val('')
                }
                $(this).show()
                $('#btn_send_message_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>