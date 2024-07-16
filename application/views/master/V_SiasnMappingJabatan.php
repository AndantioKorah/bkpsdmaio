<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MAPPING JABATAN SIASN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <div class="row">
            <div class="col-lg-6">
                <label class="bmd-label-floating">Pilih Jenis Jabatan</label>
                <select class="form-control select2-navy" style="width: 100%"
                id="jenis_jabatan" data-dropdown-css-class="select2-navy" name="jenis_jabatan">
                    <?php if($jenis_jabatan){
                        foreach($jenis_jabatan as $jj){
                        ?>
                        <option value="<?=$jj['jenis']?>">
                            <?=$jj['nama']?>
                        </option>
                    <?php } } ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label class="bmd-label-floating">SKPD</label>
                <select class="form-control select2-navy" style="width: 100%"
                id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                    <?php if($list_skpd){
                        foreach($list_skpd as $ls){
                        ?>
                        <option value="<?=$ls['id_unitkerja']?>">
                            <?=$ls['nm_unitkerja']?>
                        </option>
                    <?php } } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST JABATAN</h3>
    </div>
    <div class="card-body">
        <div id="list_jabatan" class="row">
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_jabatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">EDIT JABATAN SIASN</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_edit_jabatan_content">
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#jenis_jabatan').select2()
        $('#id_unitkerja').select2()
        loadJabatanForMappingSiasn()
    })

    function loadJabatanForMappingSiasn(){
        $('#list_jabatan').html('')
        $('#list_jabatan').append(divLoaderNavy)
        $('#list_jabatan').load('<?=base_url("master/C_Master/loadJabatanForMappingSiasn")?>'+'/'+$('#jenis_jabatan').val()+'/'+$('#id_unitkerja').val(), function(){
            $('#loader').hide()
        })
    }

    $('#jenis_jabatan').on('change', function(){
        loadJabatanForMappingSiasn()
    })

    $('#id_unitkerja').on('change', function(){
        loadJabatanForMappingSiasn()
    })

    $('#jenis_jabatan').on('change', function(){
        loadJabatanForMappingSiasn()
    })

</script>