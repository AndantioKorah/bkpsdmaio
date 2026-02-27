<style>
    :root{
      --primary-color-live-chat: #222e3c;
    }

    .div_riwayat_live_chat{
        background-color: white;
        margin-top: 10px;
        border-radius: 10px;
        min-height: 70vh;
    }

    .div_riwayat_live_chat_admin{
        min-height: 75vh !important;
    }
</style>

<?php if($this->general_library->isHakAkses('admin_live_chat_konsultasi')){ ?> 
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
<script>
    $(function(){
        loadRiwayatChat()
    })

    function loadRiwayatChat(){
        $('.div_riwayat_chat').html('')
        $('.div_riwayat_chat').append(divLoaderNavy)
        $('.div_riwayat_chat').load('<?=base_url("user/C_User/loadRiwayatKonsultasi")?>', function(){
            $('#loader').hide()
        })
    }

    $('.btn_konsultasi').on('click', function(){
        $('.btn_konsultasi_loader').show()
        $('.btn_konsultasi').hide()
        $.ajax({
            url: '<?=base_url("user/C_User/startKonsultasi")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code == 1){
                    errortoast(rs.message)
                } else {
                    
                }
                $('.btn_konsultasi_loader').hide()
                $('.btn_konsultasi').show()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function openKonsultasiDetail(id){
        $('#div_start_konsultasi').hide()
        $('#div_chat_konsultasi').show()
        $('#div_chat_konsultasi').html('')
        $('#div_chat_konsultasi').append(divLoaderNavy)
        $('#div_chat_konsultasi').load('<?=base_url("user/C_User/openKonsultasiDetail/")?>'+id, function(){
            $("#loader").hide
        })
    }
</script>