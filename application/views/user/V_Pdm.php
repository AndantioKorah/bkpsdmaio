<style>
    /* .card{
        background-color: #f5f7fb; 
    } */
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
        border: 2px solid #15654d;
        background-color: #0a7958;
    }

    .card-lengkap span, .card-lengkap i{
        color: white !important;
    }

    .card-pdm:hover{
        cursor:pointer;
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

    .card-belum-lengkap:hover{
        background-color: #e5e5e5;
        transition: .2s;
    }

    .card-lengkap:hover{
        background-color: #35475c;
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
    <div class="col-lg-12 mt-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-body" id="dashboard_pdm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        loadDetailPdm();
        loadDashboardPdm();
    })

    function loadDetailPdm(){
        $('#detail_pdm').html('')
        $('#detail_pdm').append(divLoaderNavy)
        $('#detail_pdm').load('<?=base_url('user/C_User/detailPdmUser')?>', function(){
            $('#loader').hide()
        })
    }

    function loadDashboardPdm(){
        $('#dashboard_pdm').html('')
        $('#dashboard_pdm').append(divLoaderNavy)
        $('#dashboard_pdm').load('<?=base_url('dashboard/C_Dashboard/getDashboardPdmAll')?>', function(){
            $('#loader').hide()
        })
    }
</script>