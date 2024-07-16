<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MAPPING BIDANG SIASN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <div class="row">
            <div class="col-lg-12">
                <label class="bmd-label-floating">Pilih SKPD</label>
                <select class="form-control select2-navy" style="width: 100%"
                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                    <?php if($list_skpd){
                        foreach($list_skpd as $ljp){
                        ?>
                        <option value="<?=$ljp['id_unitkerja']?>">
                            <?=$ljp['nm_unitkerja']?>
                        </option>
                    <?php } } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST MASTER BIDANG/BAGIAN</h3>
    </div>
    <div class="card-body">
        <div id="list_master_bidang" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_unor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">EDIT UNOR SIASN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_edit_unor_content">
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#id_unitkerja').select2()
        loadBidangForMappingUnor()
    })

    function loadBidangForMappingUnor(){
        $('#list_master_bidang').html('')
        $('#list_master_bidang').append(divLoaderNavy)
        $('#list_master_bidang').load('<?=base_url("master/C_Master/loadBidangForMappingUnor")?>'+'/'+$('#id_unitkerja').val(), function(){
            $('#loader').hide()
        })
    }

    $('#id_unitkerja').on('change', function(){
        loadBidangForMappingUnor()
    })

</script>