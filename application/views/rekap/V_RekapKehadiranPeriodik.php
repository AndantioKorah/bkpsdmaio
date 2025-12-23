<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">
                    <h5>REKAP KEHADIRAN PERIODIK</h5>
                </div>
            </div>
            <div class="card-body">
                <form id="form_rekap_kehadiran_periodik">
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Pilih Bulan</label>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                                <option selected value="0">Semua</option>
                                <option value="01">Januari</option>
                                <option value="02">Feburari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pilih Tahun</label>
                                <input readonly autocomplete="off" class="form-control datepicker" id="tahun" name="tahun" value="<?=date('Y')?>" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label>Pilih Unit Kerja</label>
                            <select class="form-control select2-navy" style="width: 100%"
                                id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                                <option selected value="0">Semua</option>
                                <?php foreach($unitkerja as $u){ ?>
                                    <option value="<?=$u['id_unitkerja'].';'.$u['nm_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 text-right mt-3">
                            <button type="submit" class="btn btn-navy">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card card-default">
            <div class="card-body p-3">
                <div id="div_rekap_kehadiran_periodik_result"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail_rekap_kehadiran_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" 
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">DETAIL REKAP KEHADIRAN PEGAWAI</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="detail_rekap_kehadiran_modal_content">
            </div>
        </div>
    </div>
  </div>
<script>
    $(function(){
        $('#bulan').select2()
        $('#skpd').select2()
    })

    $('#form_rekap_kehadiran_periodik').on('submit', function(e){
        e.preventDefault()
        $('#div_rekap_kehadiran_periodik_result').html('')
        $('#div_rekap_kehadiran_periodik_result').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("rekap/C_Rekap/searchRekapKehadiranPeriodik")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                $('#div_rekap_kehadiran_periodik_result').html(data)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    
</script>