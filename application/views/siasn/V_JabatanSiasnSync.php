<style>
    .lbl-val{
        font-weight: bold;
        color: black;
        font-size: 1rem;
    }

    .lbl-name{
        font-weight: bold;
        color: grey;
        font-size: .6rem;
        font-style: italic;
    }
</style>

<div class="row">
    <div class="col-lg-6 text-right">
        <label style="font-weight: bold;">Riwayat Jabatan di SILADEN</label>
        <select class="form-control select2-navy" style="width: 100%;"
            id="id_jabatan_siladen" data-dropdown-css-class="select2-navy" name="id_jabatan_siladen">
            <?php if($list_jabatan_siladen){
                foreach($list_jabatan_siladen as $ls){
                ?>
                <option value="<?=$ls['id']?>">
                    <?=$ls['nosk'].' - '.$ls['nama_jabatan']?>
                </option>
            <?php } } ?>
        </select>
        <div class="row">
            <div class="col-lg-12"><hr></div>
            <div class="col-lg-12" id="div_detail_jabatan_siladen" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="lbl-name">Nomor SK</label>
                        <br>
                        <span class="lbl-val lbl_siladen_nomor_sk"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Nama Jabatan</label>
                        <br>
                        <span class="lbl-val lbl_siladen_nama_jabatan"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Eselon</label>
                        <br>
                        <span class="lbl-val lbl_siladen_eselon"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">TMT Jabatan</label>
                        <br>
                        <span class="lbl-val lbl_siladen_tmt_jabatan"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Tanggal SK</label>
                        <br>
                        <span class="lbl-val lbl_siladen_tanggal_sk"></span>
                    </div>
                    <div class="col-lg-12">
                        <iframe class="file_siladen" style="width: 100%; height: 50vh;">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <label style="font-weight: bold;">Riwayat Jabatan di SIASN</label>
        <select class="form-control select2-navy" style="width: 100%;"
            id="id_jabatan_siasn" data-dropdown-css-class="select2-navy" name="id_jabatan_siasn">
            <?php if($list_jabatan_siasn){
                foreach($list_jabatan_siasn['data'] as $ls){
                ?>
                <option value="<?=$ls['id']?>">
                    <?=$ls['nomorSk'].' - '.$ls['namaJabatan']?>
                </option>
            <?php } } ?>
        </select>
        <div class="row">
            <div class="col-lg-12"><hr></div>
            <div class="col-lg-12" id="div_detail_jabatan_siasn" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="lbl-name">Nomor SK</label>
                        <br>
                        <span class="lbl-val lbl_siasn_nomor_sk"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Nama Jabatan</label>
                        <br>
                        <span class="lbl-val lbl_siasn_nama_jabatan"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Eselon</label>
                        <br>
                        <span class="lbl-val lbl_siasn_eselon"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">TMT Jabatan</label>
                        <br>
                        <span class="lbl-val lbl_siasn_tmt_jabatan"></span>
                    </div>
                    <div class="col-lg-12">
                        <label class="lbl-name">Tanggal SK</label>
                        <br>
                        <span class="lbl-val lbl_siasn_tanggal_sk"></span>
                    </div>
                    <div class="col-lg-12">
                        <iframe class="file_siasn" style="width: 100%; height: 50vh;">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 text-center mt-2">
        <hr>
        <button id="btn_sync" class="btn btn-navy" onclick="sinkronkan()"><i class="fa fa-sync"></i> SINKRONKAN</button>
        <button id="btn_sync_loading" disabled class="btn btn-navy" style="display: none;"><i class="fa fa-spin fa-spinner"></i> Loading...</button>
    </div>
</div>
<script>
    $(function(){
        $('.select2-navy').select2()
        loadDivDetailJabatanSiladen()
        loadDivDetailJabatanSiasn()
    })

    $('#id_jabatan_siladen').on('change', function(){
        loadDivDetailJabatanSiladen()
    })

    $('#id_jabatan_siasn').on('change', function(){
        loadDivDetailJabatanSiasn()
    })

    function sinkronkan(){
        $('#btn_sync').hide()
        $('#btn_sync_loading').show()
        $.ajax({
            url: '<?=base_url("siasn/C_Siasn/sinkronIdSiasn/")?>'+$('#id_jabatan_siladen').val()+'/'+$('#id_jabatan_siasn').val(),
            method: 'post',
            data: null,
            success: function(data){
                successtoast('Sinkron ID Berhasil')
                $('#btn_sync').show()
                $('#btn_sync_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_sync').show()
                $('#btn_sync_loading').hide()
            }
        })
    }

    function loadDivDetailJabatanSiladen(){

        $('#div_detail_jabatan_siladen').show()
        $.ajax({
            url: '<?=base_url("siasn/C_Siasn/loadDetailRiwayat/siladen/")?>'+$('#id_jabatan_siladen').val(),
            method: 'post',
            data: null,
            success: function(data){
                let res = JSON.parse(data)
                $('.lbl_siladen_nomor_sk').html(res.nosk)
                $('.lbl_siladen_nama_jabatan').html(res.nama_jabatan)
                $('.lbl_siladen_eselon').html(res.nm_eselon)
                $('.lbl_siladen_tmt_jabatan').html(res.tmtjabatan)
                $('.lbl_siladen_tanggal_sk').html(res.tglsk)
                $('.file_siladen').attr('src', '<?=base_url()?>'+'arsipjabatan/'+res.gambarsk)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function loadDivDetailJabatanSiasn(){
        $('#div_detail_jabatan_siasn').show()
        $.ajax({
            url: '<?=base_url("siasn/C_Siasn/loadDetailRiwayat/siasn/")?>'+$('#id_jabatan_siasn').val(),
            method: 'post',
            data: null,
            success: function(data){
                let res = JSON.parse(data)
                $('.lbl_siasn_nomor_sk').html(res.nomorSk)
                $('.lbl_siasn_nama_jabatan').html(res.namaJabatan)
                $('.lbl_siasn_eselon').html(res.eselon != null && res.eselon != "" ? res.eselon : 'Non Eselon')
                $('.lbl_siasn_tmt_jabatan').html(res.tmtJabatan)
                $('.lbl_siasn_tanggal_sk').html(res.tanggalSk)
                $('.file_siasn').attr('src', "data:application/pdf;base64,"+res.file)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    }
</script>