<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <h5 class="card-title">DASHBOARD PENDATAAN DATA MANDIRI</h5>
            </div>
            <div class="card-body">
                <form id="form_pdm">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Pilih Unit Kerja</label>
                            <select class="form-control select2-navy" 
                                id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                <!-- <option value="0" selected>Semua</option> -->
                                <?php $i = 0; foreach($unitkerja as $u){ $i++; ?>
                                    <option <?= $this->general_library->getUnitKerjaPegawai() == $u['id_unitkerja'] ? 'selected' : '';?> value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <button class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row" id="div_result"></div>
    </div>
</div>
<script>
    $(function(){
        $('#unitkerja').select2()
        $('#form_pdm').submit()
    })

    $('#unitkerja').on('change', function(){
        $('#form_pdm').submit()
    })

    $('#form_pdm').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("dashboard/C_Dashboard/searchDataPdm")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_result').html('')
                $('#div_result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    })
</script>