<div class="row">
    <div class="col-lg-12">
        <div class="card- card-default">
            <div class="card-header">
                <div class="card-title">Input Surat Tugas Event</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <form id="form_input">
                        <div class="col-lg-12">
                            <select class="form-control select2-navy" style="width: 100%;"
                                id="list_event" data-dropdown-css-class="select2-navy" name="list_event">
                                <?php if($list_event){
                                    foreach($list_event as $le){ if($le['flag_surat_tugas'] == 1){
                                    ?>
                                    <option value="<?=$le['id']?>">
                                        <?=formatDateNamaBulan($le['tgl'])." - ".$le['judul']?>
                                    </option>
                                <?php } } } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-2">
                            <label>Pilih Pegawai</label>
                            <select required multiple="multiple" class="form-control select2-navy" style="width: 100%"
                                id="pegawai" data-dropdown-css-class="select2-navy" name="pegawai[]">
                                <?php foreach($list_pegawai as $p){ ?>
                                    <option value="<?=$p['nipbaru_ws']?>"><?=getNamaPegawaiFull($p)?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>