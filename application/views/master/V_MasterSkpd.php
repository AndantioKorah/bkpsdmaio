<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER PERANGKAT DAERAH</h3>
        <hr>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_master_pd">
            <div class="row" style="margin-top: -30px;">
                <div class="col-lg-12">
                    <select class="form-control select2-navy" style="width: 100%"
                    id="ukmaster" data-dropdown-css-class="select2-navy" name="ukmaster">
                        <?php if($master){
                            foreach($master as $m){
                            ?>
                            <option value="<?=$m['id_unitkerjamaster']?>">
                                <?=$m['nm_unitkerjamaster']?>
                            </option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST SKPD</h3>
    </div>
    <div class="card-body">
        <div id="list_skpd" class="row">
        </div>
    </div>
</div>


<script>
    $(function(){
        $('#ukmaster').select2()
        refreshUnitKerja()
    })

    function refreshUnitKerja(){
        $('#list_skpd').html('')
        $('#list_skpd').append(divLoaderNavy)
        $('#list_skpd').load('<?=base_url("master/C_Master/loadUnitKerjaByIdUnitKerjaMaster/")?>'+$('#ukmaster').val(), function(){
            $('#loader').hide()
        })
    }

    $('#ukmaster').on('change', function(){
        refreshUnitKerja()
    })
</script>