<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
    <li class="nav-item nav-item-profile" role="presentation">
        <button onclick="loadListJabatan()" class="nav-link nav-link-profile active" id="nav-list-jabatan-tab"
        data-bs-toggle="pill" data-bs-target="#nav-list-jabatan" type="button" role="tab" aria-controls="pills-home" aria-selected="true">RIWAYAT</button>
    </li>
    <li class="nav-item nav-item-profile" role="presentation">
        <button onclick="loadSync()" class="nav-link nav-link-profile" id="nav-sync-tab"
        data-bs-toggle="pill" data-bs-target="#nav-sync" type="button" role="tab" aria-controls="pills-home" aria-selected="true">SINKRONISASI</button>
    </li>
</ul>
<div class="col-lg-12">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane show active" id="nav-list-jabatan" role="tabpanel" aria-labelledby="nav-list-jabatan-tab">
            <div id="div_list_jabatan"></div>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane hide" id="nav-sync" role="tabpanel" aria-labelledby="nav-sync-tab">
            <div id="div_sync"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        loadListJabatan()
    })

    function loadListJabatan(){
        $('#div_list_jabatan').html('')
        $('#div_list_jabatan').append(divLoaderNavy)
        $('#div_list_jabatan').load('<?=base_url("siasn/C_Siasn/loadListJabatanSiasn/".$id_m_user)?>', function(){
            $('#loader').hide()
        })
    }

    function loadSync(){
        $('#div_sync').html('')
        $('#div_sync').append(divLoaderNavy)
        $('#div_sync').load('<?=base_url("siasn/C_Siasn/loadSyncJabatan/".$id_m_user)?>', function(){
            $('#loader').hide()
        })
    }
</script>