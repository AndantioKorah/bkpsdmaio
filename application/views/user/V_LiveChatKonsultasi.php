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
    <div class="row" id="live_chat_container">
        
    </div>
</div>
<form id="form_send_message">
    <div class="col-lg-12 mt-2" style="
        width: 100%;
    ">
        <div class="row"
            style="
                display: flex;
                align-items: center;
                background-color: #f9fafb;
                border-radius: 50px;
                padding: 5px 10px 5px 0px;
            "
        >
            <div class="col-lg-10">
                <textarea name="pesan" id="pesan" style="
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
                <button id="btn_send_message" type="submit" style="
                    width: 40px;
                    height: 40px;
                "
                class="btn btn-success rounded-circle p-2">
                    <i class="fa fa-paper-plane"></i>
                </button>
                <button id="btn_send_message_loading" type="button" djsabled style="
                    width: 40px;
                    height: 40px;
                    display: none;
                "
                class="btn btn-success rounded-circle p-2">
                    <i class="fa fa-spin fa-spinner"></i>
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        reloadLiveChatContainer('<?=$result['chat']['id']?>')
    })

    $('.btn_back_chatkonsul').on('click', function(){
        $('#div_start_konsultasi').show()
        $('#div_chat_konsultasi').html('')
        $('#div_chat_konsultasi').hide()
        loadRiwayatChat()
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
        if (e.key === 'Enter' && e.shiftKey) {
            console.log('asdasdsad')
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