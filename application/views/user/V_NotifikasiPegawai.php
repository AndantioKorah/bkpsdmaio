<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <h3>Notifikasi Pegawai</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4" id="list_notifikasi">
                    </div>
                    <div class="col-lg-8" id="div_isi_notifikasi">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        loadNotifikasi()
    })

    function loadNotifikasi(){
        $('#list_notifikasi').html('')
        $('#list_notifikasi').append(divLoaderNavy)
        $('#list_notifikasi').load('<?=base_url('user/C_User/loadAllNotifikasi')?>', function(){
            $('#loader').hide()
        })
    }
</script>