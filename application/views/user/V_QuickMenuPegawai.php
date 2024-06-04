<style>
    .menu-container{
        /* max-width: 33vw; */
        border-radius: 10px;
        /* background-color: white; */
        border: 3px solid #eaeaea;
        /* padding: 15px; */
        color: var(--primary-color);
        text-align: center;
        /* height: 30px; */
    }

    .menu-container:hover{
        cursor: pointer;
        background-color: #f5f7fb;
        transition: .2s;
        box-shadow: 5px 5px grey;
    }

    .bg-primary-color{
        background-color: #f5f7fb;
    }

    .text-siladen-red{
        color: #b0141b;
    }
</style>

<div class="row" style="background-color: white; padding: 10px;">
    <div class="col-lg-12 text-center p-3">
        <h4><strong>SASARAN KINERJA BULANAN PEGAWAI</strong></h4>
        <hr>
    </div>
    <div onclick="href('kinerja/rencana')" class="col">
        <div class="card menu-container">
            <div class="bg-primary-color card-header">
                <i class="fa fa-bullseye fa-8x"></i>
            </div>
            <div class="card-body">
                <h4 style="font-weight: bold;">Sasaran Kerja</h4>
            </div>
        </div>
    </div>
    <div onclick="href('kinerja/realisasi')" class="col">
        <div class="card menu-container">
            <div class="bg-primary-color card-header">
                <i class="fa fa-edit fa-8x"></i>
            </div>
            <div class="card-body">
                <h4 style="font-weight: bold;">Realisasi Kerja</h4>
            </div>
        </div>
    </div>
    <div onclick="href('kinerja/rekap')" class="col">
        <div class="card menu-container">
            <div class="bg-primary-color card-header">
                <i class="fa fa-file-alt fa-8x"></i>
            </div>
            <div class="card-body">
                <h4 style="font-weight: bold;">Rekap Sasaran Kerja</h4>
            </div>
        </div>
    </div>
    <?php
    if($this->general_library->isProgrammer() 
    || $this->general_library->isAdminAplikasi() 
    || $this->general_library->isPejabatEselon() 
    || $this->general_library->isKepalaPd()
    || $this->general_library->isWalikota()
    || stringStartWith('Kepala Sekolah', $this->general_library->getNamaJabatan())){
    ?>
    <div onclick="href('kinerja/verifikasi')" class="col">
        <div class="card menu-container">
            <div class="bg-primary-color card-header">
                <i class="fa fa-check-circle fa-8x"></i>
            </div>
            <div class="card-body">
                <h4 style="font-weight: bold;">Verifikasi SKP Pegawai</h4>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<script>
    function href(url){
        window.location = '<?=base_url()?>'+url;
    }
</script>