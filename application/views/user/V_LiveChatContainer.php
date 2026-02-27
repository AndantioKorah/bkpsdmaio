<?php if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){ ?>
<style>
    .ellipsis_this{
        display: -webkit-box; /* Required for older browser compatibility */
        -webkit-box-orient: vertical; /* Required for older browser compatibility */
        -webkit-line-clamp: 1; /* Limits text to 3 lines */
        overflow: hidden;
        text-overflow: ellipsis; /* Ensures the ellipsis appears */
    }

    .profile_live_chat_container:hover{
        background-color: #cacaca !important;
    }

    .margin-admin{
        margin-top: 80px;
    }
</style>
<div class="profile_live_chat_container" style="
    background-color: #f9fbf9;
    position: fixed;
    line-height: 12px;
    padding: 10px;
    top: 64px;
    width: 326px;
    box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);
    -webkit-box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);
    -moz-box-shadow: 0px 5px 7px 0px rgba(0,0,0,0.64);
">
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
                <span class="sp_profil_nama_pegawai_live_chat ellipsis_this"><?=getNamaPegawaiFull($result['chat'])?></span>
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
<script>
    $('#mini_profile_live_chat_cotainer').on('click', function(){
        $(this).hide()
        $('#detail_profile_live_chat_cotainer').show()
    })

    $('#detail_profile_live_chat_cotainer').on('click', function(){
        $(this).hide()
        $('#mini_profile_live_chat_cotainer').show()
    })
</script>
<?php } ?>
<?php if($result['detail']){ $i = 1; ?>
    <?php foreach($result['detail'] as $rd){ ?>
        <div class="col-lg-12 pt-2 <?=$this->general_library->isHakAkses('admin_live_chat_konsultasi') && $i==1 ? "margin-admin" : ""?>">
            <?php
                $divChat = "div_chat_left"; 
                $spJam = "sp_jam_pesan_chatkonsul_left"; 
                if($rd['is_sender_admin'] == 0){ 
                    $divChat = "div_chat_right"; 
                    $spJam = "sp_jam_pesan_chatkonsul_right"; 
                }

                if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){
                    if($rd['is_sender_admin'] == 1){ 
                        $divChat = "div_chat_right"; 
                        $spJam = "sp_jam_pesan_chatkonsul_right"; 
                        if($i == 1){
                            $divChat.=" margin-admin";
                        }
                    } else {
                        $divChat = "div_chat_left";
                        $spJam = "sp_jam_pesan_chatkonsul_left";
                    }
                }
            ?>
            <div class="<?=$divChat?> div_chat">
                <div class="col-lg-12">
                    <span class="sp_chat_pesan_chatkonsul"><?=$rd['pesan']?></span><br>
                </div>
                <div class="col-lg-12">
                    <span class="sp_jam_pesan_chatkonsul <?=$spJam?>"><?=trim(formatDateNotifikasi($rd['created_date']), 0)?></span>
                </div>
            </div>
        </div>
    <?php $i++; } ?>
<?php } ?>