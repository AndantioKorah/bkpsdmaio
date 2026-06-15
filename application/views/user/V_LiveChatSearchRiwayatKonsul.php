<style>
    .label_search_riwayat_live_chat{
        color: grey;
        font-weight: bold;
        font-size: .65rem;
        font-style: italic;
        margin-top: 10px;
    }
</style>
<div class="row" style="overflow-y: auto;">
    <form id="form_search_live_chat_riwayat">
        <div class="col-lg-12">
            <span class="label_search_riwayat_live_chat">Status</span>
            <select class="form-control select2-navy" style="width: 100%"
                id="status" data-dropdown-css-class="select2-navy" name="status">
                <option value="semua" selected>Semua</option>
                <option value="0">Aktif</option>
                <option value="1">Selesai</option>
            </select>
        </div>
        <div class="col-lg-12 mt-1">
            <span class="label_search_riwayat_live_chat">Perangkat Daerah</span>
            <select class="form-control select2-navy" style="width: 100%"
                id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                <option value="0" selected>Semua</option>
                <?php foreach($skpd as $s){ ?>
                    <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-12 mt-1">
            <span class="label_search_riwayat_live_chat">Jenis Konsultasi</span>
            <select class="form-control select2-navy" style="width: 100%"
                id="jenis_layanan" data-dropdown-css-class="select2-navy" name="jenis_layanan">
                <option value="0" selected>Semua</option>
                <?php foreach($jenis_layanan as $jl){ ?>
                    <?php foreach($jl['layanan'] as $jll){ ?>
                        <option value="<?=$jll['nama_layanan']?>"><?=$jll['nama_layanan']?></option>
                <?php } } ?>
            </select>
        </div>
        <div class="col-lg-12 mt-1">
            <span class="label_search_riwayat_live_chat">Custom</span>
            <input class="form-control" name="search" />
        </div>
        <div class="text-right col-lg-12 mt-1">
            <hr>
            <div class="row">
                <div class="col-lg-6 text-left">
                    <button id="btn_reset_filter_riwayat_konsul" type="button" class="btn btn-sm btn-light"><i class="fa fa-reset"></i> Reset</button>
                </div>
                <div class="col-lg-6 text-right">
                    <button id="btn_submit_search_riwayat_live_chat" type="submit" class="btn btn-sm btn-navy"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('.select2-navy').select2()
    })

    $('#form_search_live_chat_riwayat').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("user/C_User/searchRiwayatKonsul")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('.icon_search_riwayat_konsul').addClass('icon_search_riwayat_konsul_actived')
                hidePopupLiveChat()
                $('.div_riwayat_chat').html('')
                $('.div_riwayat_chat').append(divLoaderNavy)
                $('#loader').hide()
                $('.div_riwayat_chat').html(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#btn_reset_filter_riwayat_konsul').on('click', function(){
        $('.icon_search_riwayat_konsul').removeClass('icon_search_riwayat_konsul_actived')
        hidePopupLiveChat()
        loadRiwayatChat()
    })
</script>