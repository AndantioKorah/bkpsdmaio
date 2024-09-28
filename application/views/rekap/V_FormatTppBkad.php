<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">REKAP TTPP PERMINTAAN BKAD</h3>
    </div>
    <div class="card-body">
        <div class="div_result"></div>
    </div>
</div>
<script>
    $(function(){
        loadDataRekap()        
    })

    function loadDataRekap(){
        $('.div_result').html('')
        $('.div_result').append(divLoaderNavy)
        $('.div_result').load('<?=base_url("rekap/C_Rekap/loadFormatTppBkadData")?>', function(){
            $('#loader').hide()
        })
    }
</script>