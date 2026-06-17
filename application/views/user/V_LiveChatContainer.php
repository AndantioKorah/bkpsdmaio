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
        margin-top: 80px !important;
    }

    .margin-admin-bottom{
        margin-bottom: 10px;
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
            <div class="col-lg-12 text-center mb-2
                <?=($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                || $this->general_library->isProgrammer()
                || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $i==1 ? "margin-admin" : ""?>
                <?=($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                || $this->general_library->isProgrammer()
                || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $i==count($result['detail']) ? "margin-admin-bottom div_chat_last_item" : ""?>
                "style="line-height: 15px;">
                <?php if($rd['flag_only_admin'] == 1 && (
                    $this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                || $this->general_library->isProgrammer()
                || $this->general_library->getId() == $result['chat']['id_m_user_assigned']
                )){ ?>
                    <span style="
                        font-size: .65rem;
                        font-weight: bold;
                        color: beige;
                        padding: 5px;
                        border-radius: 5px;
                        background-color: #dc3545;
                    ">
                        <?=$rd['pesan']?>
                    </span>
                <?php } else { ?>
                    <span style="color: var(--primary-color); margin-bottom: 0; font-size: .6rem; font-style: italic; font-weight: bold;">
                        <?=trim(formatDateNotifikasi($rd['created_date'], 1))?><br>
                    </span>
                    <span style="color: var(--primary-color); font-size: .75rem; font-style: italic; font-weight: bold;">
                        <?=$rd['pesan']?>
                    </span>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="col-lg-12 mb-2
                    <?=($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $i==count($result['detail']) ? "margin-admin-bottom div_chat_last_item" : ""?>
                    "
                style="
                    <?=($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $i==1 ? "margin-top: 80px;" : ""?>
                "
                >
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
                    if(($result['chat']['id_m_user_assigned'] != null &&
                    ($this->general_library->isHakAkses('admin_live_chat_konsultasi') 
                    || $this->general_library->isProgrammer()
                    || $this->general_library->getId() == $result['chat']['id_m_user_assigned']) && $flagSenderChanged == 1)
                    && $rd['is_sender_admin'] == 1){
                ?>
                <div class="col-lg-12 text-right mt-2">
                    <span style="color: var(--primary-color); font-size: .7rem; font-style: italic; font-weight: bold;">
                        <?=getNamaPegawaiFull($rd, 0, 1)?>
                    </span>
                </div>
                <?php } ?>
                <div class="<?=$divChat?> div_chat">
                    <div class="col-lg-12">
                        <?php if($rd['is_file'] == 1){ ?>
                            <div style="
                                    width: 100%;
                                    padding: 10px;
                                    border-radius: 10px;
                                    border: 1px solid #930000;
                                    background-color: #f8dddd;
                                    color: #930000;
                                    font-weight: bold;
                                    cursor: pointer;
                                "
                                class="d-flex align-items-center default_hover mb-1"
                                onclick="openAttachment('<?=str_replace(' ', '_', $rd['url_attachment'])?>')">
                                <i class="fa fa-file-pdf"></i>&nbsp;
                                <span class="ellipsis_this"><?=$rd['attachment_name']?></span>
                            </div>
                        <?php } else if($rd['is_image'] == 1){ ?>
                            <image class="b-lazy default_hover mb-1" style="
                                max-height: 20vh;
                                border-radius: 10px;
                                max-width: 100%;
                                object-fit: cover;
                                cursor: pointer;
                            " src="<?=str_replace(' ', '_', base_url($rd['url_attachment']))?>"
                            onclick="openAttachment('<?=str_replace(' ', '_', $rd['url_attachment'])?>')"/>
                        <?php } else { ?>
                            <span class="sp_chat_pesan_chatkonsul"><?=$rd['pesan']?></span><br>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <span class="sp_jam_pesan_chatkonsul <?=$spJam?>"><?=trim(formatDateNotifikasi($rd['created_date']), 0)?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php $i++; } ?>
    <script>
        function openAttachment(url){
            window.open('<?=base_url()?>'+url, "_blank")
        } 
    </script>
<?php } ?>