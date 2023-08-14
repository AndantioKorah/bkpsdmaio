<style>
    .card-title-pdm{
        font-size: 15px;
        font-weight: bold;
        color: black;
        vertical-align: middle;
    }

    .card-belum-lengkap{
        border: 2px solid rgba(0, 0, 0, .3);
        background-color: transparent;
    }

    .card-lengkap{
        border: 2px solid #222e3c;
        background-color: #222e3c;
    }

    .card-lengkap span, .card-lengkap i{
        color: white !important;
    }

    .card-pdm{
        /* min-height: 120px; */
    }

    .text-progress{
        color: white;
        font-weight: bold;
        font-size: 15px;
        margin-top: 15px;
    }

    .progress-bar{
        transition: .2s;
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <br>
        <div class="row"></div>
        <h4 class="font-weight-bold">PEMUTAKHIRAN DATA MANDIRI</h4>
    </div>
    <div class="col-lg-12" id="detail_pdm">
    </div>
</div>
<script>
    $(function(){
        loadDetailPdm();
    })

    function loadDetailPdm(){
        $('#detail_pdm').html('')
        $('#detail_pdm').append(divLoaderNavy)
        $('#detail_pdm').load('<?=base_url('user/C_User/detailPdmUser')?>', function(){
            $('#loader').hide()
        })
    }
</script>