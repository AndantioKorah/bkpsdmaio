<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Ganti Passowrd</div>
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
                        <div class="col-lg-12 col-md-12 text-right mt-3">
                            <button id="btn_submit" type="submit" class="btn btn-navy"><i class="fa fa-save"></i>&nbsp;&nbsp;Ganti Password</button>
                            <button style="display: none;" id="btn_submit_loading" type="btn" disabled class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i>&nbsp;&nbsp;Mohon Menunggu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
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
                }
                $('#password_lama').val("")
                $('#konfirmasi_password').val("")
                $('#password_baru').val("")

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