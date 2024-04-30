<div class="card card-default">
    <div class="card-header">
        <h4>SKBP Perangkat Daerah</h4>
    </div>
    <div class="card-body">
        <form id="form_search_skbppd">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <label>Pilih Perangkat Daerah</label>  
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <?php foreach($skpd as $s){ if($s['id_unitkerja'] != 0 && $s['id_unitkerja'] != 5){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    <label>Pilih Bulan</label>  
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
                <div class="col-lg-3 col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg-3 col-md-12" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-file-export"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-12 card card-default p-3" id="result">
</div>
<div class="modal fade" id="modal_skbp_pd" tabindex="-1"role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="modal_skbp_pd_content">
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#bulan').select2()
        $('#id_unitkerja').select2()
        $('#form_search_skbppd').submit()    
    })

    $('#form_search_skbppd').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/searchSkbpPd")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result').html('')
                $('#result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>