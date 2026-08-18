<div class="row">
    <div class="col-lg-12">
        <h5>REKAPITULASI OKTA</h5>
    </div>
    <div class="col-lg-3">
        <div class="card card-default">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <form id="form_rekap_okta">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Periode</label>
                                        <?php
                                            $listPeriode = getMonthsBetweenDate("2026-02-01", date('Y-m-d'));
                                        ?>
                                        <select class="form-control select2-navy" style="width: 100%;"
                                            id="periode" data-dropdown-css-class="select2-navy" name="periode">
                                            <option value="0" selected>
                                                Semua
                                            </option>
                                            <?php 
                                                foreach($listPeriode as $lp){
                                                $expl = explode("-", $lp);
                                                ?>
                                                <option value="<?=$lp?>">
                                                    <?=getNamaBulan($expl[0])." ".$expl[1]?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>Jenis Layanan</label>
                                        <select class="form-control select2-navy" style="width: 100%;"
                                            id="id_m_layanan_konsul" data-dropdown-css-class="select2-navy" name="id_m_layanan_konsul">
                                            <option value="0" selected>
                                                Semua
                                            </option>
                                            <?php 
                                                foreach($jenis_layanan as $jl){
                                                ?>
                                                <option value="<?=$jl['id']?>">
                                                    <?=$jl['nama_layanan']?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>Unit Kerja</label>
                                        <select class="form-control select2-navy" style="width: 100%;"
                                            id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                                            <option value="0" selected>
                                                Semua
                                            </option>
                                            <?php 
                                                foreach($unitkerja as $jl){
                                                ?>
                                                <option value="<?=$jl['id_unitkerja']?>">
                                                    <?=$jl['nm_unitkerja']?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>Status</label>
                                        <select class="form-control select2-navy" style="width: 100%;"
                                            id="status" data-dropdown-css-class="select2-navy" name="status">
                                            <option value="0" selected>
                                                Semua
                                            </option>
                                            <option value=1>
                                                Aktif
                                            </option>
                                            <option value=2>
                                                Selesai - Belum Rating
                                            </option>
                                            <option value=3>
                                                Selesai - Sudah Rating
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2 text-right">
                                        <button type="submit" class="btn btn-navy">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9" id="div_rekap_data">
    </div>
</div>

<script>
    $(function(){
        $('#periode').select2()
        $('#id_unitkerja').select2()
        $('#id_m_layanan_konsul').select2()
        $('#status').select2()
    })

    $('#form_rekap_okta').on('submit', function(e){
        $('#div_rekap_data').html('')
        $('#div_rekap_data').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/searchRekapOkta")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_rekap_data').html(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>