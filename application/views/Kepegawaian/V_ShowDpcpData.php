<div class="col-lg-12 p-3">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item nav-item-profile" role="presentation">
                    <button onclick="loadFile('dpcp')" class="nav-link nav-link-profile active" id="tab-data-dpcp-tab" data-bs-toggle="pill" data-bs-target="#pills-data-dpcp" type="button" role="tab" aria-controls="pills-data-dpcp" aria-selected="false">DPCP</button>
                </li>
                <li class="nav-item nav-item-profile" role="presentation">
                    <button onclick="loadFile('hukdis')" class="nav-link nav-link-profile " id="tab-data-hukdis-tab" data-bs-toggle="pill" data-bs-target="#pills-data-hukdis" type="button" role="tab" aria-controls="pills-data-hukdis" aria-selected="true">SP HUKDIS</button>
                </li>
                <li class="nav-item nav-item-profile" role="presentation">
                    <button onclick="loadFile('pidana')" class="nav-link nav-link-profile " id="tab-data-pidana-tab" data-bs-toggle="pill" data-bs-target="#pills-data-pidana" type="button" role="tab" aria-controls="pills-data-pidana" aria-selected="true">SP PIDANA</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show active" id="pills-data-dpcp" role="tabpanel" aria-labelledby="pills-data-dpcp">
                </div>
                <div class="tab-pane" id="pills-data-hukdis" role="tabpanel" aria-labelledby="pills-data-hukdis">
                </div>
                <div class="tab-pane" id="pills-data-pidana" role="tabpanel" aria-labelledby="pills-data-pidana">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#tab-data-dpcp-tab').click()
    })

    function loadFile(jenis){
        $('#pills-data-'+jenis).html('')
        $('#pills-data-'+jenis).append(divLoaderNavy)
        $('#pills-data-'+jenis).load('<?=base_url("kepegawaian/C_Layanan/loadBerkasPensun/".$id)?>'+'/'+jenis, function(){
            $('#loader').hide()
        })
    }
</script>
