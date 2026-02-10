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
</style>
<div class="col-lg-8 text-left">
    <span style="cursor:pointer;" class="sp_chat_id_chatkonsul btn_back_chatkonsul"><i class="fa fa-chevron-left"></i></span>
    <span class="sp_chat_id_chatkonsul">&nbsp;&nbsp;#<?=$result['chat']['chat_id']?></span>
</div>
<div class="col-lg-4 text-right">
    <div class="btn-group" role="group">
        <button id="btn-group-konsultasi" type="button" class="btn btn-outline-warning dropdown-toggle"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Pilihan
        </button>
        <div class="dropdown-menu" aria-labelledby="btn-group-konsultasi">
            <?php if($result['chat']['flag_done'] == 0){ ?>
                <a class="dropdown-item" onclick="endKonsultasi('<?=$result['chat']['id']?>')" >Akhiri Konsultasi</a>
            <?php } else { ?>
                <!-- <a class="dropdown-item" onclick="endKonsultasi('<?=$result['chat']['id']?>')" >Akhiri Konsultasi</a> -->
            <?php } ?>
        </div>
    </div>
</div>
<?php
    $heightChatContainer = "75vh";
    if($result['chat']['flag_done'] == 1){
        $heightChatContainer = "65vh";
    }
?>
<div class="col-lg-12 mt-2" style="
    background-color: #f9fbf9;
    height: <?=$heightChatContainer?>;
    overflow-y: auto;
    display: flex;
    flex-direction: column-reverse;
    padding-top: 10px;
    padding-bottom: 10px;
">  
    <div class="row" id="live_chat_container">
        
    </div>
</div>
<?php if($result['chat']['flag_done'] == 0){ ?>
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
<?php } else { ?>
    <div class="col-lg-12 mt-3" style="
            width: 100%;
            max-height: 25vh;
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            overflow-y: auto;
            overflow-x: hidden;
        ">
        <div class="row">
            <div class="col-lg-6 text-left">
                <span class="lbl_rating_nm">Waktu Respon</span><br>
                <?php for($i = 1; $i <= $result['chat']['rating_kecepatan']; $i++){ ?>
                    <i class="text-warning fa fa-star"></i>
                <?php } ?>
            </div>
            <div class="col-lg-6 text-left">
                <span class="lbl_rating_nm">Ketepatan Informasi</span><br>
                <?php for($i = 1; $i <= $result['chat']['rating_ketepatan']; $i++){ ?>
                    <i class="text-warning fa fa-star fa-2x"></i>
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
<?php } ?>
<script>
    $(function(){
        reloadLiveChatContainer('<?=$result['chat']['id']?>')
    })
    
    function endKonsultasi(id){
        if(confirm('Apakah Anda yakin?')){
            // $.ajax({
            //     url: '<?=base_url("user/C_User/endKonsultasi/")?>'+id,
            //     method: 'post',
            //     success: function(data){
            //         let rs = JSON.parse(data)
            //         if(rs.code == 1){
            //             errortoast(rs.message)
            //         } else {
            //             backToStartView()
            //         }
            //     }, error: function(e){
            //         errortoast('Terjadi Kesalahan')
            //     }
            // })
            $('#div_start_konsultasi').hide()
            $('#div_chat_konsultasi').show()
            $('#div_chat_konsultasi').html('')
            $('#div_chat_konsultasi').append(divLoaderNavy)
            $('#div_chat_konsultasi').load('<?=base_url('user/C_User/ratingKonsultasi/')?>'+id, function(){
                $('#loader').hide()
            })
        }
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