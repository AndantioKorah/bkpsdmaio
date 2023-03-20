<style>
    .card-default{
        min-height: 48vh;
    }
</style>
<h4>DETAIL TPP PEGAWAI BULAN <?=strtoupper(getNamaBulan(date('m')))?> TAHUN <?=date('Y')?></h4>
<?php if($tpp){ ?>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mt-0 text-center">
                            <h5 class="card-title" style="color: var(--primary-color) !important;">JUMLAH CAPAIAN TPP</h5>
                        </div>
                        <div class="col-lg-12">
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <center style="mb-2">
                                <span style="
                                    font-weight: bold;
                                    font-size: 1.1rem;
                                ">
                                    <?=formatCurrency($tpp['capaian_tpp'])?>
                                </span>
                                <span style="
                                    font-weight: 400;
                                ">
                                    / <?=formatCurrencyWithoutRp($tpp['pagu_tpp']['pagu_tpp'])?>
                                </span>
                            </center>
                            <div class="progress w-100">
                                <div class="progress-bar" role="progressbar" 
                                style="
                                    width: <?=$tpp['presentase_capaian_tpp']?>%;
                                    background-color: <?=getProgressBarColor($tpp['presentase_capaian_tpp'])?>
                                "></div>
                            </div>
                            <center>
                                <span class="mt-2"><?=formatTwoMaxDecimal($tpp['presentase_capaian_tpp']).'%'?> / 100%</span>
                            </center>
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <div class="col-lg-12">
                                <div class="row">
                                    <table style="width: 100%; font-size: .7rem;">
                                        <tr>
                                            <td colspan=2>
                                                <span style="font-size: .7rem;">INFORMASI:</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Jumlah di atas belum termasuk potongan Pph 21</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Jumlah di atas belum termasuk potongan BPJS</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mt-0 text-center">
                            <h5 class="card-title" style="color: var(--primary-color) !important;">PRODUKTIVITAS KERJA</h5>
                        </div>
                        <div class="col-lg-12">
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <center style="mb-2">
                                <span style="
                                    font-weight: bold;
                                    font-size: 1.1rem;
                                ">
                                    <?=formatCurrency($tpp['capaian_pk'])?>
                                </span>
                                <span style="
                                    font-weight: 400;
                                ">
                                    / <?=formatCurrencyWithoutRp($tpp['pagu_pk'])?>
                                </span>
                            </center>
                            <div class="progress w-100">
                                <div class="progress-bar" role="progressbar" 
                                style="
                                    width: <?=$tpp['presentase_pk'].'%'?>;
                                    background-color: <?=getProgressBarColor($tpp['presentase_pk'])?>
                                "></div>
                            </div>
                            <center>
                                <span class="mt-2"><?=formatTwoMaxDecimal($tpp['presentase_pk']).'% / 100%'?></span>
                            </center>
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <div class="col-lg-12">
                                <div class="row">
                                    <table style="width: 100%; font-size: .7rem;">
                                        <tr>
                                            <td colspan=2>
                                                <span style="font-size: .7rem;">INFORMASI:</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Pagu Produktivitas Kerja adalah 60% dari Pagu TPP</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <center>
                                <button onclick="openDetailProduktivitasKerja()" class="btn btn-sm btn-navy-outline mt-2">Detail <i class="fa fa-search"></i></button>
                            </center>
                            <!-- <div class="col-lg-12">
                                <div class="row">
                                    <table style="width: 100%; font-size: .7rem;">
                                        <tr>
                                            <td colspan=2>
                                                <span style="font-size: .7rem;">INFORMASI:</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Bobot Produktivitas Kerja terdiri dari 30% SKBP dan 30% Komponen Kinerja</td>
                                        </tr>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mt-0 text-center">
                            <h5 class="card-title" style="color: var(--primary-color) !important;">DISIPLIN KERJA</h5>
                        </div>
                        <div class="col-lg-12">
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <center style="mb-2">
                                <span style="
                                    font-weight: bold;
                                    font-size: 1.1rem;
                                ">
                                    <?=formatCurrency($tpp['capaian_dk'])?>
                                </span>
                                <span style="
                                    font-weight: 400;
                                ">
                                    / <?=formatCurrencyWithoutRp($tpp['pagu_dk'])?>
                                </span>
                            </center>
                            <div class="progress w-100">
                                <div class="progress-bar" role="progressbar" 
                                style="
                                    width: <?=$tpp['presentase_dk'].'%'?>;
                                    background-color: <?=getProgressBarColor($tpp['presentase_dk'])?>
                                "></div>
                            </div>
                            <center>
                                <span class="mt-2"><?=formatTwoMaxDecimal($tpp['presentase_dk']).'% / 100%'?></span>
                            </center>
                            <hr style="
                                margin-top: .5rem !important;
                                margin-bottom: .5rem !important;
                            ">
                            <div class="col-lg-12">
                                <div class="row">
                                    <table style="width: 100%; font-size: .7rem;">
                                        <tr>
                                            <td colspan=2>
                                                <span style="font-size: .7rem;">INFORMASI:</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Pagu Disiplin Kerja adalah 40% dari Pagu TPP</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Jumlah di atas adalah perhitungan absensi pada hari kerja yang sudah lewat</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <center>
                                <button onclick="openDetailDisiplinKerja()" class="btn btn-sm btn-navy-outline mt-2">Detail <i class="fa fa-search"></i></button>
                            </center>
                            <!-- <div class="col-lg-12">
                                <div class="row">
                                    <table style="width: 100%; font-size: .7rem;">
                                        <tr>
                                            <td colspan=2>
                                                <span style="font-size: .7rem;">INFORMASI:</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="width: 5%;"><i class="fa fa-dot-circle"></i></td>
                                            <td valign="top" style="width: 95%;">Bobot Produktivitas Kerja terdiri dari 30% SKBP dan 30% Komponen Kinerja</td>
                                        </tr>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="div_detail" style="display: none;">
        <div class="card card-default">
            <div class="card-body" id="detail_content"></div>
        </div>
    </div>
    <script>
        function openDetailDisiplinKerja(){
            $('#div_detail').show()
            $('#detail_content').html('')
            $('#detail_content').append(divLoaderNavy)
            $('#detail_content').load('<?=base_url('kinerja/C_Kinerja/loadRekapDisiplinKerjaUser/')?>'+$('#bulan').val()+'/'+$('#tahun').val(), function(){
                $('#loader').hide()
            })
        }

        function openDetailProduktivitasKerja(){
            $('#div_detail').show()
            $('#detail_content').html('')
            $('#detail_content').append(divLoaderNavy)
            $('#detail_content').load('<?=base_url('kinerja/C_Kinerja/loadRekapKinerjaUser/')?>'+$('#bulan').val()+'/'+$('#tahun').val(), function(){
                $('#loader').hide()
            })
        }
    </script>
<?php } else { ?>
    <div class="card card-default">
        <div class="card-content">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4>TERJADI KESALAHAN <i class="fa fa-exclamation"></i></h4>
                </div>
            </div>
        </div>
    </div>
<?php } ?>