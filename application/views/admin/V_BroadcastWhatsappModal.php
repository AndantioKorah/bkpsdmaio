<style>
    .value_tabel{
        font-size: .8rem;
        color: black;
        font-weight: bold;
    }

    .sec_value{
        font-size: .75rem;
        font-weight: 500;
    }
</style>

<div class="row p-3">
    <div class="col-lg-6" style="max-height: 75vh; overflow-x: auto;">
        <div class="row">
            <div class="col-lg-12">
                BORADCAST TO: <?=formatCurrencyWithoutRpWithDecimal(count($selectedNip), 0)?> Pegawai
                <hr>
            </div>
        </div>
        <?php if($list_pegawai){ ?>
            <div class="col-lg-12" id="list_selected_pegawai">
            </div>
        <?php } ?>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-12">
                FORM BROADCAST:
                <hr>
            </div>
            <div class="col-lg-12">
                <form id="form_broadcast">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Nama Broadcast</label>
                            <input class="form-control" name="nama_broadcast"/>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label>Pilih Jenis Pesan</label>
                            <select class="form-control select2-navy" style="width: 100%"
                            id="jenis_pesan" data-dropdown-css-class="select2-navy" name="jenis_pesan">
                                <option value="text">Text</option>
                                <option value="document">Dokumen</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-3 div_document" style="display: none;">
                            <label>Pilih Dokumen</label>
                            <input class="form-control" type="file" name="dokumen_broadcast" id="dokumen_broadcast" /><br>
                        </div>
                        <div class="col-lg-12 div_document" style="display: none;">
                            <label>Nama File</label>
                            <input class="form-control" name="nama_file"/>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <label>Pesan Broadcast</label>
                            <textarea class="form-control" rows=5 name="pesan_broadcast"></textarea>
                        </div>
                        <div class="col-lg-12 mt-3 text-right">
                            <button id="btn_submit" class="btn btn-navy">SUBMIT BROADCAST</button>
                            <button disabled id="btn_submit_loading" style="display: none;" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#jenis_pesan').select2()
        loadSelectedPegawai(10)
    })

    function loadSelectedPegawai(limit){
        $('#list_selected_pegawai').html('')
        $('#list_selected_pegawai').append(divLoaderNavy)
        $('#list_selected_pegawai').load('<?=base_url("admin/C_Admin/loadSelectedPegawai/")?>'+limit, function(){
            $('#loader').hide()
        })
    }

    $('#form_broadcast').on('submit', function(e){
        $('#btn_submit').hide()
        $('#btn_submit_loading').show()

        var formvalue = $('#form_broadcast');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('dokumen_broadcast').files.length;
        
        if($('#jenis_pesan').val() != "text" && ins == 0){
            $('#btn_submit').show()
            $('#btn_submit_loading').hide()
            errortoast("Silahkan upload file terlebih dahulu");

            return false;
        }

        e.preventDefault()
            $.ajax({
            url: '<?=base_url('admin/C_Admin/submitBroadcast')?>',
            method: 'POST',
            data: form_data,  
            contentType: false,  
            cache: false,  
            processData:false,
            success: function(rs){
                let res = JSON.parse(rs)
                if(res.code == 0){
                    successtoast('Broadcast berhasil dikirim')
                    $('#broadcast_modal').modal('hide')
                    $('#form_search').submit()
                } else {
                    errortoast(res.message)
                }
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
                $('#btn_submit').show()
                $('#btn_submit_loading').hide()
            }
        })
    })

    $('#jenis_pesan').on('change', function(){
        if($(this).val() == "text"){
            $('.div_document').hide()
        } else {
            $('.div_document').show()
        }
    })
</script>