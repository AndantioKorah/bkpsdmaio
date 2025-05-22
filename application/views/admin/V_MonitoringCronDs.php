<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">MONITORING CRON DIGITAL SIGNATURE</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <form id="form_search">
                        <div class="col-lg-12">
                            <label>Pilih Tanggal</label>  
                            <input class="form-control form-control-sm" id="range_periode" readonly name="range_periode"/>
                        </div>
                        <div class="col-lg-12 mt-2 text-right">
                            <button id="btn_submit" type="submit" class="btn btn-navy"><i class="fa fa-search"></i> Cari</button>
                            <button id="btn_submit_loading" disabled style="display: none;" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Menunggu...</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-2">
        <div id="result"></div>
    </div>
</div>

<script>
    $(function(){
        $("#range_periode").daterangepicker({
            format: 'DD/MM/YYYY',
            showDropdowns: true,
            // minDate: firstDay
        });
    })

    $("#range_periode").on('change', function(){
        $('#form_search').submit()        
    })

    $('#form_search').on('submit', function(e){
        e.preventDefault()
        $('#btn_submit').hide()
        $('#btn_submit_loading').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("admin/C_Admin/getMonitoringDsData")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result').html(data)
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }, error: function(e){
                $('#result').html('')
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>