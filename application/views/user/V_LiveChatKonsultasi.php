<style>
    .sp_chat_id_chatkonsul{
        font-size: 1.3rem;
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

    .sp_jam_pesan_chatkonsul_admin{
        float: right;
    }

    .sp_jam_pesan_chatkonsul_pegawai{
        float: right;
    }

    .div_chat{
        padding: 10px;
        border-radius: 10px;
        max-width: 240px;
        /* position: absolute;
        bottom: 10px; */
    }

    .div_chat_admin{
        background-color: #99efe8;
        float: left;
    }

    .div_chat_pegawai{
        background-color: #e6e6e6;
        float: right;
    }
</style>
<div class="col-lg-12 text-left">
    <span style="cursor:pointer;" class="sp_chat_id_chatkonsul btn_back_chatkonsul"><i class="fa fa-chevron-left"></i></span>
    <span class="sp_chat_id_chatkonsul">&nbsp;&nbsp;&nbsp;&nbsp;#<?=$result['chat']['chat_id']?></span>
</div>
<div class="col-lg-12" style="
    background-color: #f9fbf9;
    height: 75vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column-reverse;
    padding-top: 10px;
    padding-bottom: 10px;
">  
    <div class="row">
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
    </div>
</div>
<div class="col-lg-12 mt-2" style="
    width: 100%;
">
    <div class="row"
        style="
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 50px;
            padding: 5px 10px 5px 0px;
        "
    >
        <div class="col-lg-10">
            <textarea style="
                resize: none;
                width: 100%;
                height: 40px;
                margin-top: 5px;
                background-color: #f9fafb;
                overflow: hidden;
                padding: 10px 0px 5px 0px;
                outline: none;
                font-size: 1rem;
                border: 0;
            "
                placeholder="Tulis pesan disini..."></textarea>
        </div>
        <div class="col-lg-2">
            <button id="btn_send_message" type="button" style="
                width: 40px;
                height: 40px;
            "
            class="btn btn-success rounded-circle p-2">
                <i class="fa fa-paper-plane"></i>
            </button>
            <button id="btn_send_message_loading" type="button" style="
                width: 40px;
                height: 40px;
            "
            class="btn btn-success rounded-circle p-2">
                <i class="fa fa-spin fa-spinner"></i>
            </button>
        </div>
    </div>
</div>
<script>
    $('.btn_back_chatkonsul').on('click', function(){
        $('#div_start_konsultasi').show()
        $('#div_chat_konsultasi').html('')
        $('#div_chat_konsultasi').hide()
        loadRiwayatChat()
    })

    $('#btn_send_message').on('click', function(){
        $(this).hide()
        $('#btn_send_message_loading').show()
        $.ajax({
            url: '<?=base_url("user/C_User/sendMessageKonsultasi/")?>',
            method: 'post',
            data: [
                
            ],
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    
                }
                $(this).show()
                $('#btn_send_message_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>