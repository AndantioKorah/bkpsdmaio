<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">MASTER HARDCODE NOMINATIF</div>
            </div>
            <div class="card-body">
                <form id="form_hardcode_nominatif">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pegawai</label>
                                <select required class="form-control select2-navy" style="width: 100%"
                                    id="nip" data-dropdown-css-class="select2-navy" name="nip">
                                    <?php foreach($list_pegawai as $lp){ ?>
                                        <option value="<?=$lp['nipbaru_ws']?>"><?=getNamaPegawaiFull($lp)?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Unit Kerja</label>
                                <select required class="form-control select2-navy" style="width: 100%"
                                    id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                                    <?php foreach($unit_kerja as $uk){ ?>
                                        <option value="<?=$uk['id_unitkerja']?>"><?=($uk['nm_unitkerja'])?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Jabatan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="id_jabatan" data-dropdown-css-class="select2-navy" name="id_jabatan">
                                    <option value="">Pilih Jabatan</option>
                                    <?php foreach($nama_jabatan as $nj){ ?>
                                        <option value="<?=$nj['id_jabatanpeg'].";".$nj['nama_jabatan']?>"><?=($nj['nama_jabatan'])?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Ket. Jabatan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="keterangan_jabatan" data-dropdown-css-class="select2-navy" name="keterangan_jabatan">
                                    <option value="def">Definitif</option>
                                    <option value="Plt.">Plt</option>
                                    <option value="Plh.">Plh</option>
                                    <option value="Pj.">PJ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Bulan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                                    <option <?=date('m') == '01' ? 'selected' : ''?> value="01">Januari</option>
                                    <option <?=date('m') == '02' ? 'selected' : ''?> value="02">Feburari</option>
                                    <option <?=date('m') == '03' ? 'selected' : ''?> value="03">Maret</option>
                                    <option <?=date('m') == '04' ? 'selected' : ''?> value="04">April</option>
                                    <option <?=date('m') == '05' ? 'selected' : ''?> value="05">Mei</option>
                                    <option <?=date('m') == '06' ? 'selected' : ''?> value="06">Juni</option>
                                    <option <?=date('m') == '07' ? 'selected' : ''?> value="07">Juli</option>
                                    <option <?=date('m') == '08' ? 'selected' : ''?> value="08">Agustus</option>
                                    <option <?=date('m') == '09' ? 'selected' : ''?> value="09">September</option>
                                    <option <?=date('m') == '10' ? 'selected' : ''?> value="10">Oktober</option>
                                    <option <?=date('m') == '11' ? 'selected' : ''?> value="11">November</option>
                                    <option <?=date('m') == '12' ? 'selected' : ''?> value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Keterangan</label>
                                <select class="form-control select2-navy" style="width: 100%"
                                    id="keterangan" data-dropdown-css-class="select2-navy" name="flag_add">
                                    <option selected value="0">Hilangkan</option>
                                    <option value="1">Tambahkan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button id="btn-save" class="btn btn-navy" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            <button style="display: none;" id="btn-save-loading" class="btn btn-navy" type="button" disabled><i class="fa fa-spin fa-spinner"></i> Menyimpan...</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card card-default">
            <div class="card-header">LIST HARDCODE NOMINATIF</div>
            <div class="card-body p-3 table-responsive" id="list_hardcode_nominatif"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        loadListHardcode()
        $('.select2-navy').select2()
    })

    function loadListHardcode(){
        $('#list_hardcode_nominatif').html('')
        $('#list_hardcode_nominatif').append(divLoaderNavy)
        $('#list_hardcode_nominatif').load('<?=base_url("master/C_Master/loadListHardcodeNominatif")?>', function(){
            $("#loader").hide()
        })
    }

    $('#form_hardcode_nominatif').on('submit', function(e){
        $('#btn-save').hide()
        $('#btn-save-loading').show()
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/inputHardcodeNominatif")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let resp = JSON.parse(data)
                if(resp['code'] == 1){
                    errortoast(resp['message'])
                } else {
                    loadListHardcode()
                    successtoast("Data Berhasil Ditambahkan")
                }
                $('#btn-save').show()
                $('#btn-save-loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn-save').show()
                $('#btn-save-loading').hide()
            }
        })
    })
</script>