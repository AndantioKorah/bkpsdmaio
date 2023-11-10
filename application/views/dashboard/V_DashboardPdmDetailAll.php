<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header text-center">
                <h4 class="font-weight-bold">PROGRES PDM TIAP SKPD</h4>
            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <?php if($this->general_library->isProgrammer() || $this->general_library->isAdminAplikasi()){ ?>
                        <div class="col-lg-12 text-right">
                            <form action="<?=base_url('dashboard/C_Dashboard/downloadDataPdm')?>" target="_blank">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Download as Pdf</button>
                            </form>
                        </div>
                    <?php } ?>
                    <div class="col-lg-12 mt-2">
                        <table class="table table-hover table-striped table_pdm_detail_all">
                            <thead>
                                <th class="text-center" style="width: 5%;">No</th>
                                <th class="text-left" style="width: 35%;">Perangkat Daerah</th>
                                <th class="text-center" style="width: 10%;">Jumlah Pegawai</th>
                                <th class="text-center" style="width: 50%;">Progress</th>
                            </thead>
                            <tbody>
                                <?php if($result){ $no = 1; foreach($result as $rs){ ?>
                                    <tr>
                                        <td class="text-center"><?=$no++;?></td>
                                        <td class="text-left"><?=$rs['nm_unitkerja'];?></td>
                                        <td class="text-center"><?=formatCurrencyWithoutRp($rs['jumlah_pegawai'], 0)?></td>
                                        <td class="text-left">
                                            <span style="color: black; font-weight: bold !important;"><?=formatTwoMaxDecimal($rs['presentase']).' %'?></span>
                                            <div class="progress progress-sm" style="height: 1rem !important; border-radius: 10px;">
                                                <div class="progress-bar" role="progressbar"
                                                    aria-valuenow="<?=$rs['presentase']?>" aria-valuemin="0" 
                                                    aria-valuemax="100" 
                                                    style="width: <?=formatTwoMaxDecimal($rs['presentase'])?>%; 
                                                    background-color: <?=getProgressBarColor($rs['presentase'])?>;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.table_pdm_detail_all').dataTable()
    })
</script>