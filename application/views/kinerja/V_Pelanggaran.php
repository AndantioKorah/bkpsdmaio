<div class="card card-default">
    <div class="card-header">
        <div class="card-title"><h3>PELANGGARAN</h3></div>
        <hr>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <form id="form_pelanggaran">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>NAMA PEGAWAI</label>
                            <select class="form-control select2-navy" style="width: 100%"
                            id="id_m_user" data-dropdown-css-class="select2-navy" name="id_m_user">
                                <?php if($list_pegawai){
                                    foreach($list_pegawai as $lp){
                                    ?>
                                    <option value="<?=$lp['id_m_user']?>">
                                        <?=getNamaPegawaiFull($lp)?>
                                    </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#id_m_user').select2()
    })
</script>