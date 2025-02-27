<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER PRESENTASE BESARAN TPP</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_input_presentase_tpp">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <label class="bmd-label-floating">Pilih SKPD</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <?php foreach($unitkerja as $s){ if($s['id_unitkerja'] != 0){ ?>
                            <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-lg-12 mt-3 text-right">
                    <button type="submit" class="btn btn-navy">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">MASTER BESARAN PRESENTASE TPP</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_tpp">
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $("#id_unitkerja").select2();
        loadTpp()
    })

    $('#id_unitkerja').on('change', function(){
        loadTpp()
    })

    function loadTpp(){
        $('#list_tpp').html('')
        $('#list_tpp').append(divLoaderNavy)
        $('#list_tpp').load('<?=base_url("master/C_Master/loadMasterPresentaseTppNew/")?>'+$('#id_unitkerja').val(), function(){
            $('#loader').hide()
        })
    }

    $('#form_input_presentase_tpp').on('submit', function(e){
        e.preventDefault()
        loadTpp()  
    })
</script>