<div class="row">
    <?php if($this->general_library->getBidangUser() == ID_BIDANG_PEKIN || $this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi() || $this->general_library->isWalikota() || isKasubKepegawaian($this->general_library->getNamaJabatan())){ ?>
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h5 class="card-title">DASHBOARD PENDATAAN DATA MANDIRI</h5>
                </div>
                <div class="card-body">
                    <form id="form_pdm">
                        <div class="row" style="margin-top: -30px;">
                            <div class="col-lg-12">
                                <label>Pilih Unit Kerja</label>
                                <select class="form-control select2-navy" 
                                    id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                    <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()
                                    || $this->general_library->isWalikota() || $this->general_library->getBidangUser() == ID_BIDANG_PEKIN){ ?>
                                        <option value="0" selected>Semua</option>
                                    <?php } ?>
                                    <?php $i = 0; foreach($unitkerja as $u){ $i++; ?>
                                        <option <?=$u['id_unitkerja'] == $this->general_library->getUnitKerjaPegawai() ? 'selected' : ''?>
                                        value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
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
    <?php } else { ?>
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class=""><h4 class="font-weight-bold">DASHBOARD PDM <?=strtoupper($this->general_library->getNamaSKPDUser())?></h4></div>
                </div>
                <form id="form_pdm" style="display: none;">
                    <input name="unitkerja" value="<?=$this->general_library->getUnitKerjaPegawai()?>" />
                </form>
            </div>
        </div>
    <?php } ?>
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