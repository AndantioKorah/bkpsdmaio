<h1 class="h3 mb-3">Upload Dokumen Pendukung Absensi</h1>  
<div class="card card-default">
    <!-- <div class="card-header">
        <h4>Upload Dokumen Pendukung Absensi</h4>
    </div> -->
    <div class="card-body">
        <form id="form_input_hukdis">
            <div class="row mt-3">
                <div class="col-lg-4 col-3 col-md-12">
                    <label>Pilih Pegawai</label>
                    <select class="select_pegawai form-control form-control-sm select2-navy" style="width: 100%"
                        id="select_pegawai" data-dropdown-css-class="select2-navy" name="nip">
                        <?php foreach($pegawai as $p){ ?>
                            <option value="<?=$p['nipbaru_ws']?>"><?=getNamaPegawaiFull($p)?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-3 col-md-12">
                    <label>Pilih Jenis Hukdis</label>
                    <select class="id_m_hukdis form-control form-control-sm select2-navy" style="width: 100%"
                        id="id_m_hukdis" data-dropdown-css-class="select2-navy" name="id_m_hukdis">
                        <?php foreach($hukdis as $h){ ?>
                            <option value="<?=$h['id']?>"><?=($h['nama_hukdis'])?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-3 col-md-12">
                    <label>TMT Hukdis</label>  
                    <input class="form-control" name="tmt_hukdis" id="tmt_hukdis" value="<?=date('Y-m-d')?>" />
                </div>
                <div class="col-lg-4 col-3 col-md-12">
                    <label>SK Hukdis</label>  
                    <!-- <input class="form-control" name="tmt_hukdis" id="tmt_hukdis" value="<?=date('Y-m-d')?>" /> -->
                </div>
                <div class="col-lg-4 col-4 col-md-12" style="margin-top: 23px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // let active_status = 0

    $(function(){
        $('#select_pegawai').select2()
        $('#tmt_hukdis').datepicker({
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayBtn: true,
            autoclose: true
        })
    })

    $('#form_input_hukdis').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/inputHukdis")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#result').html('')
                $('#result').append(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })
</script>