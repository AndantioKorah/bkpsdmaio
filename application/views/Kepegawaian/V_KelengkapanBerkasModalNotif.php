<style>
    .sp_label{
        font-weight: bold;
        color: gray;
        font-style: italic;
        font-size: .75rem;
    }

    .sp_val{
        font-weight: bold;
        color: black;
        font-size: 1.2rem;
    }
</style>

<form id="form_kirim_pesan">
    <div class="row">
        <div class="col-lg-12">
            <label class="sp_lbl">Nama Pegawai</label><br>
            <span class="sp_val"><?=getNamaPegawaiFull($profil_pegawai)?></span>
        </div>
        <div class="col-lg-12 mt-2">
            <label class="sp_lbl">Nomor HP</label><br>
            <span class="sp_val"><?=($profil_pegawai['handphone'])?></span>
        </div>
        <div class="col-lg-12 mt-2">
            <label class="sp_lbl">Pesan</label><br>
            <textarea id="pesan" rows=15 name="pesan" style="width: 100%"><?=$message?></textarea>
        </div>
        <div class="col-lg-12 mt-2 text-right">
            <button type="submit" id="btn_send" class="btn btn-navy"><i class="fa fa-paper-plane"></i> Kirim</button>
            <button style="display: none;" type="button" disabled id="btn_send_loading"
            class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mengirim...</button>
        </div>
    </div>
</form>

<script>
    $(function(){

    })

    $('#form_kirim_pesan').on('submit', function(e){
        e.preventDefault()
        $('#btn_send').hide()
        $('#btn_send_loading').show()
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Layanan/sendNotif")?>',
            method: 'post',
            data: {
                nohp : '<?=$profil_pegawai['handphone']?>',
                pesan : $('#pesan').val()
            },
            success: function(data){
                successtoast('Pesan berhasil dikirim')
                $('#modal_notif').modal('hide')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_send').show()
                $('#btn_send_loading').hide()
            }
        })
    })
</script>