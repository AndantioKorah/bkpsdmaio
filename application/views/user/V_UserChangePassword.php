<div class="row">
    <div class="col-lg-12">
        <?php if($otp["message"] && FLAG_RESET_PASSWORD_USE_OTP == 1) { ?>
            <h4 id="blue_message" style="
                font-weight: bold;
                font-size: .85rem;
                color: blue;
            "><?=$otp['message']?></h4>
        <?php } ?>
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Ganti Password</div>
                <hr>
            </div>
            <div class="card-body">
                <form id="form_change_password" style="margin-top: -30px;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <label>Password Lama</label>
                            <input class="form-control" autocomplete="off" type="password" id="password_lama" name="password_lama"/>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <label>Password Baru</label>
                            <input class="form-control" autocomplete="off" type="password" id="password_baru" name="password_baru"/>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <label>Konfirmasi Password Baru</label>
                            <input class="form-control" autocomplete="off" type="password" id="konfirmasi_password" name="konfirmasi_password"/>
                        </div>
                        <?php if(FLAG_RESET_PASSWORD_USE_OTP == 1){ ?>
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9">
                                        <label>Kode OTP</label>
                                        <input class="form-control" autocomplete="off" type="number" id="kode_otp" name="kode_otp"/>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <button class="btn btn-info" type="button" style="margin-top: 21px;" id="btn_otp" onclick="requestSendOtp()">Resend OTP</button>
                                        <button class="btn btn-info" style="display: none; margin-top: 21px;" id="btn_otp_loading" disabled><i class="fa fa-spin fa-spinner"></i> Mohon menunggu...</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-lg-12 col-md-12 text-right mt-3">
                            <button id="btn_submit" type="submit" class="btn btn-navy"><i class="fa fa-save"></i>&nbsp;&nbsp;Ganti Password</button>
                            <button style="display: none;" id="btn_submit_loading" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i>&nbsp;&nbsp;Mohon Menunggu</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if(isset($flag_need_reset_pass) && $flag_need_reset_pass == 1){ ?>
                <div class="card-footer">
                    <h5 style="
                        font-weight: bold;
                        color: red;
                    ">
                        <?=ERROR_MESSAGE_RESET_PASSWORD?>
                    </h5>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        <?php if(isset($flag_need_reset_pass) && $flag_need_reset_pass == 1){ ?>
            $('#sidebar').hide()
            $('#search_navbar').hide()
            $('#sidebar_toggle').hide()
        <?php } ?>

        <?php if($this->session->userdata('apps_error')){ ?>
			errortoast("<?=$this->session->userdata('apps_error')?>");
		//   $('#error_div').show()
		//   $('#error_div').append('<label>'+'<?=$this->session->userdata('apps_error')?>'+'</label>')
		<?php
		    $this->session->set_userdata('apps_error', null);
		} ?>
    })

    function requestSendOtp(){
        $('#btn_otp').hide()
        $('#btn_otp_loading').show()
        $.ajax({
            url: '<?=base_url("user/C_User/requestSendOtp")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp['code'] == 1){
                    errortoast(resp['message'])
                } else {
                    successtoast("OTP Berhasil dikirim. Mohon menunggu.")
                    // window.location.("<?=base_url('welcome')?>")
                }
                $('#btn_otp').show()
                $('#btn_otp_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_otp').show()
                $('#btn_otp_loading').hide()
            }
        })
    }

    $('#form_change_password').on('submit', function(e){
        $('#btn_submit').hide()
        $('#btn_submit_loading').show()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("user/C_User/personalChangePasswordSubmit")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp['message'] != 0){
                    errortoast(resp['message'])
                } else {
                    successtoast("Password Berhasil Diubah")
                    // window.location.("<?=base_url('welcome')?>")
                }
                $('#password_lama').val("")
                $('#konfirmasi_password').val("")
                $('#password_baru').val("")
                $('#kode_otp').val("")
                $('#blue_message').hide()

                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }
        })
    })
</script>