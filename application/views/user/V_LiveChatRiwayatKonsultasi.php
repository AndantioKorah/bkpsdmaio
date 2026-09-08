
<style>
    .sp_chat_id_rw_konsul{
        font-size: 1rem;
        color: black;
        font-weight: bold;
    }

    .sp_chat_id_rw_konsul_admin{
        font-size: .8rem !important;
    }

    .sp_last_chat_rw_konsul_admin{
        font-size: .65rem;
    }

    .sp_last_chat_rw_konsul{
        font-size: .8rem;
        color: grey;
        font-weight: bold;
        display: -webkit-box; /* Required for older browser compatibility */
        -webkit-box-orient: vertical; /* Required for older browser compatibility */
        -webkit-line-clamp: 1; /* Limits text to 3 lines */
        overflow: hidden;
        text-overflow: ellipsis; /* Ensures the ellipsis appears */
    }

    .sp_last_chat_date_rw_konsul{
        font-size: .65rem;
        color: grey;
        font-weight: bold;
    }

    .div_chat_konsul_item:hover{
        cursor: pointer;
        background-color: #f0f0f0;
    }

    .div_chat_konsul_item{
        border-bottom: 1px solid lightgrey;
    }

    .div_profil_live_chat{
        position: absolute;
        left: -255px;
        width: 250px;
        background-color: white;
        /* height: 300px; */
        border-radius: 10px;
        box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
        -webkit-box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
        -moz-box-shadow: -3px 2px 18px 6px rgba(124,124,124,1);
        padding: 10px;
        line-height: 15px;
        display: none;
    }

    .sp_profil_pegawai_live_chat{
        font-size: .65rem;
        color: grey;
        font-weight: bold;
    }

    .sp_profil_nama_pegawai_live_chat{
        font-size: .8rem;
        color: black;
        font-weight: bold;
    }
</style>
<div id="div_riwayat_konsultasi" class="row">
    
</div>
<script>
    $(function(){
        loadRiwayatKonsultasi(1)
    })

    function loadRiwayatKonsultasi(flag_only_active = 1){
        $('#div_riwayat_konsultasi').html('')
        $('#div_riwayat_konsultasi').append(divLoaderNavy)
        $('#div_riwayat_konsultasi').load('<?=base_url('user/C_User/loadRiwayatKonsultasiItem/')?>'+flag_only_active, function(){
            $('#loader').hide()
        })
    }

    function onHoverChat(id){
        // $('.div_profil_live_chat').hide()
        // $('.profile_chat_'+id).show()
        // $('.profile_chat_'+id).on('mouseleave', function(){
        //     $('.profile_chat_'+id).hide()
        // })
        // $('#div_chat_'+id).on('mouseover', function() {
        //     $('.div_profil_live_chat').hide()
        //     $('.profile_chat_'+id).fadeIn(20)
        // }).on('mouseleave', function() {
        //     $('.profile_chat_'+id).fadeOut(20)
        // });
    }
</script>