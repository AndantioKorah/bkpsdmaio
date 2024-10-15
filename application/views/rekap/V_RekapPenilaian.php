<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">Rekapitulasi Penilaian Produktivitas Kerja</h3>
    </div>
    <div class="card-body" style="display: block;">
        <!-- <form id="form_upload_file" enctype="multipart/form-data" method="post"> -->
        <form id="search_form">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Pilih SKPD</label>
                        <select class="form-control select2-navy" style="width: 100%"
                            id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                            <?php foreach($list_skpd as $s){ ?>
                                <option value="<?=$s['id_unitkerja'].';'.$s['nm_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                            <?php } ?>
                            <?php 
                                foreach($skpd_diknas as $sd){
                                ?>
                                    <option value="<?='sekolah_'.$sd['id_unitkerja'].';'.$sd['nm_unitkerja']?>">
                                        <?=$sd['nm_unitkerja']?>
                                    </option>
                                <?php }  ?>
                                <option value="8000118">
                                       TK Negeri Pembina
                                    </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
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
                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Kriteria</label>
                        <select class="form-control select2-navy" style="width: 100%"
                            id="kriteria" data-dropdown-css-class="select2-navy" name="kriteria">
                            <option value="1" selected>Semua</option>
                            <option value="2">Diatas Ekspektasi</option>
                            <option value="3">Sesuai Ekspektasi</option>
                            <option value="4">Dibawah Ekspektasi</option>
                           
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
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
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">REKAPITULASI PENILAIAN PRODUKTIVITAS KERJA</h3>
    </div>
    <div class="card-body">
        <div id="div_result" class="row">
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#bulan').select2()
        $('#skpd').select2()
    })

    $('#search_form').on('submit', function(e){
        e.preventDefault();
        $('#div_result').html('')
        $('#div_result').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/rekapPenilaianSearch2")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>