<style>
    .sp-isi-notif{
        display: -webkit-box; /* Required for older browser compatibility */
		-webkit-box-orient: vertical; /* Required for older browser compatibility */
		-webkit-line-clamp: 2; /* Limits text to 3 lines */
		overflow: hidden;
		text-overflow: ellipsis; /* Ensures the ellipsis appears */
		line-height: 15px;
		font-size: 0.85rem;
		color: #333333;
    }

    .col-notifikasi-left:hover{
        cursor: pointer;
        background-color: #dcdcdc !important;
        transition: .2s;
    }

    .col-notifikasi-left{
        padding: .5rem;
        border-bottom: 1px solid grey;
    }

    .col-notif-selected{
        background-color: #dcdcdc !important;
    }

    .notif-pegawai-not-read{
		background-color: #e6fdff;
	}
</style>
<div class="row" style="
        border: 1px solid grey;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        max-height: 70vh;
        overflow-x: hidden;
        overflow-y: auto;">
    <?php if($result){ ?>
        <?php foreach($result as $rs){ ?>
            <!-- <div class="col-lg-12 col-notifikasi-left <?=$rs['flag_read'] == 0 ? 'notif-pegawai-not-read' : 'bg-white'?>" -->
            <div class="col-lg-12 col-notifikasi-left bg-white"
            id="id_col_notif_left_<?=$rs['id']?>" onclick="loadDetailNotif('<?=$rs['id']?>')">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="text-dark"><?=$rs['judul_notifikasi']?></span>
                    </div>
                    <div class="col-lg-12">
                        <span class="sp-isi-notif"><?=$rs['pesan']?></span>
                    </div>
                    <div class="col-lg-12 text-right">
                        <!-- <span class="text-muted small"><?=$rs['created_date']?></span> -->
                        <span class="text-muted small mt-1 text-right"><?=formatDateNotifikasi($rs['created_date'])?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-lg-12 text-center">
            <i><b>Tidak ada notifikasi</b></i>
        </div>        
    <?php } ?>
</div>
<script>
    function loadDetailNotif(id){
        $('.col-notifikasi-left').removeClass('col-notif-selected')
        $('#id_col_notif_left_'+id).addClass('col-notif-selected')

        $('#div_isi_notifikasi').html('')
        $('#div_isi_notifikasi').append(divLoaderNavy)
        $('#div_isi_notifikasi').load('<?=base_url('user/C_User/loadDetailNotif/')?>'+id, function(){
            $('#loader').hide()
        })
    }
</script>