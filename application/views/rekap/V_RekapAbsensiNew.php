<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">Rekap Absensi</h3>
    </div>
    <div class="card-body" style="display: block;">
        <!-- <form id="form_upload_file" enctype="multipart/form-data" method="post"> -->
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-database-tab" data-toggle="pill" 
                href="#custom-content-below-database" role="tab" aria-controls="custom-content-below-database" aria-selected="true">Database</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-content-below-excel-tab" data-toggle="pill" 
                href="#custom-content-below-excel" role="tab" aria-controls="custom-content-below-excel" aria-selected="false">Excel</a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-database" role="tabpanel" aria-labelledby="custom-content-below-database-tab">
                <form id="search_form" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih SKPD</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                                    <?php foreach($list_skpd as $s){ ?>
                                        <option value="<?=$s['id_unitkerja'].';'.$s['nm_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Bulan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                                    <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                                    <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                                    <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                                    <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                                    <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                                    <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                                    <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                                    <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                                    <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                                    <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                                    <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                                    <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" style="margin-top: 8px;" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-12">
                    <hr>
                    <div id="result_search" class="row mt-3 table-responsive">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-content-below-excel" role="tabpanel" aria-labelledby="custom-content-below-excel-tab">
                <form id="form_upload_file" enctype="multipart/form-data" method="post" action="<?=base_url("rekap/C_Rekap/readAbsensiExcelNew")?>">
                    <div class="row">
                        <div class="col-4">
                            <label>Pilih File</label>
                            <input type="file" class="form-control" name="file_excel" id="file_excel" />
                        </div>
                        <!-- <div class="col-4">
                            <label>Pilih Jam Kerja</label>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="jam_kerja" data-dropdown-css-class="select2-navy" name="jam_kerja">
                                <?php foreach($jam_kerja as $j){ ?>
                                    <option value="<?=$j['id']?>"><?=$j['nama_jam_kerja']?></option>
                                <?php } ?>
                            </select>
                        </div> -->
                        <div class="col-4 text-left">
                            <br>
                            <button id="btn_upload" class="btn btn-sm btn-navy" style="margin-top: 12px;" type="submit"><i class="fa fa-save"></i> UPLOAD</button>
                            <button disabled id="btn_upload_loading" class="btn btn-sm btn-navy" style="margin-top: 12px; display: none;" type="button"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
                        </div>
                    </div>
                </form>
                <div class="col-12">
                    <hr>
                    <div id="result-div" class="row mt-3 table-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#jam_kerja').select2()
        loadMenu()
    })

    function loadMenu(){
        // $('#list_menu').html('')
        // $('#list_menu').append(divLoaderNavy)
        // $('#list_menu').load('<?=base_url("user/C_User/loadMenu")?>', function(){
        //     $('#loader').hide()
        // })
    }

    $('#search_form').on('submit', function(e){
        $('#result_search').html('')
        $('#result_search').append(divLoaderNavy)
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/readAbsensiFromDb")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result_search').html('')
                $('#result_search').html(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    $('#form_upload_file').on('submit', function(e){
        $('#btn_upload').hide()
        $('#btn_upload_loading').show()
        $('#result-div').html('')
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/readAbsensiExcelNew")?>',
            method: 'post',
            data: new FormData(this),
            contentType: false,  
            cache: false,  
            processData:false,  
            success: function(data){
                $('#result-div').html('')
                $('#result-div').html(data)

                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
            }, error: function(e){
                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>