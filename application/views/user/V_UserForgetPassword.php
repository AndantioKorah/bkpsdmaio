<div class="row">
    <div class="col-lg-4 text-left">
        <a style="text-decoration: none; cursor: pointer;" href="<?=base_url('login')?>"><h3><i class="fa fa-chevron-left"></i> LOGIN</h3></a>
    </div>
    <div class="col-lg-4 text-center">
        <h3>LUPA PASSWORD</h3>
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">
                    Silahkan mengisi NIP dan Nomor Handphone yang terdaftar di akun Siladen Anda
                </div>
            </div>
            <div class="card-body">
                <form id="form_lupa_password">
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <label class="form-label">NIP</label>
                            <input class="form-control form-control-lg" autocomplete="off" id="form_nip" name="form_nip" />
                        </div>
                        <div class="col-lg-12 mt-3 text-left">
                            <label class="form-label">Nomor Handphone</label>
                            <input class="form-control form-control-lg" autocomplete="off" id="form_no_hp" name="form_no_hp" />
                        </div>
                        <div class="col-lg-12 mt-3">
                            <button type="submmit" id="btn_submit" class="btn btn-block btn-navy">SUBMIT</button>
                            <button disabled type="button" id="btn_submit_loading" style="display: none;"
                                class="btn btn-block btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu
                            </button>

                            <h4 id="message_success" style="display: none; color: green; font-size: 1rem; font-weight: bold">
                                Password Anda sudah direset menjadi Tanggal Lahir Anda. Halaman akan dipindahkan ke halaman Login dalam beberapa detik lagi.
                            </h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4"></div>
</div>
<script>
    $('#form_lupa_password').on('submit', function(e){
        e.preventDefault()

        $('#btn_submit').hide()
        $('#btn_submit_loading').show()

        $.ajax({
            url: '<?=base_url("user/C_UserWOSession/submitForgetPassword")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let res = JSON.parse(data)
                if(res.code == 1){
                    errortoast(res.message)
                } else {
                    successtoast('Password Anda berhasil direset menjadi Tanggal Lahir Anda')
                    $('#form_nip').val('')
                    $('#form_no_hp').val('')
                    $('#message_success').show()
                    window.setTimeout(function(){
                        window.location.replace("<?=base_url('login')?>")
                    }, 5000);
                }
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