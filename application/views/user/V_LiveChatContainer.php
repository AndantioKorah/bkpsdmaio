<?php if($result['detail']){ ?>
    <?php foreach($result['detail'] as $rd){ ?>
        <div class="col-lg-12 pt-2">
            <?php
                $divChat = "div_chat_admin"; 
                $spJam = "sp_jam_pesan_chatkonsul_admin"; 
                if($rd['is_sender_admin'] == 0){ 
                    $divChat = "div_chat_pegawai"; 
                    $spJam = "sp_jam_pesan_chatkonsul_pegawai"; 
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
    <?php } ?>
<?php } ?>