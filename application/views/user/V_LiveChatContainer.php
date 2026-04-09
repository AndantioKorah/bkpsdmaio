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
<script>
    
</script>
<?php } ?>
<?php if($result['detail']){ $i = 1; ?>
    <?php $flagSenderChanged = 0; $userSender = 0; 
        foreach($result['detail'] as $rd){
        if($userSender != $rd['id_m_user_sender']){
            $flagSenderChanged = 1;
            $userSender = $rd['id_m_user_sender'];
        } else {
            $flagSenderChanged = 0;
        }
    ?>
        <?php if($rd['is_sistem'] == 1){ ?>
            <div class="col-lg-12 text-center mt-2" style="line-height: 15px;">
                <span style="color: grey; margin-bottom: 0; font-size: .6rem; font-style: italic; font-weight: bold;">
                    <?=trim(formatDateNotifikasi($rd['created_date'], 1))?><br>
                </span>
                <span style="color: grey; font-size: .75rem; font-style: italic; font-weight: bold;">
                    <?=$rd['pesan']?>
                </span>
            </div>
        <?php } else { ?>
            <div class="col-lg-12 pt-2 <?=($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $i==1 ? "margin-admin" : ""?>">
                <?php
                    $divChat = "div_chat_left"; 
                    $spJam = "sp_jam_pesan_chatkonsul_left"; 
                    if($rd['is_sender_admin'] == 0){ 
                        $divChat = "div_chat_right"; 
                        $spJam = "sp_jam_pesan_chatkonsul_right"; 
                    }
                    
                    if(($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                        || $this->general_library->isProgrammer()
                        || $this->general_library->getId() == $result['chat']['id_m_user_assigned'])){
                        if($rd['is_sender_admin'] == 1){ 
                            $divChat = "div_chat_right"; 
                            $spJam = "sp_jam_pesan_chatkonsul_right"; 
                            // if($i == 1){
                            //     $divChat.=" margin-admin";
                            // }
                        } else {
                            $divChat = "div_chat_left";
                            $spJam = "sp_jam_pesan_chatkonsul_left";
                        }
                    }
                ?>
                <?php
                    if($result['chat']['id_m_user_assigned'] != null &&
                    ($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $flagSenderChanged == 1){
                ?>
                <div class="col-lg-12 text-right mt-2">
                    <span style="color: grey; font-size: .7rem; font-style: italic; font-weight: bold;">
                        <?=getNamaPegawaiFull($rd, 0, 1)?>
                    </span>
                </div>
                <?php } ?>
                <div class="<?=$divChat?> div_chat">
                    <div class="col-lg-12">
                        <span class="sp_chat_pesan_chatkonsul"><?=$rd['pesan']?></span><br>
                    </div>
                    <div class="col-lg-12">
                        <span class="sp_jam_pesan_chatkonsul <?=$spJam?>"><?=trim(formatDateNotifikasi($rd['created_date']), 0)?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php $i++; } ?>
<?php } ?>