<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER JAM KERJA</h3>
    </div>
    <div class="card-body" style="display: block;">
        <!-- <form id="form_tambah_hari_libur">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="bmd-label-floating">Pilih Range Tanggal</label>
                    <input class="form-control" id="range_periode" readonly name="range_periode"/>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label class="bmd-label-floating">Keterangan Hari Libur</label>
                        <input class="form-control" autocomplete="off" name="keterangan" id="keterangan"/>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 text-left">
                    <label class="bmd-label-floating" style="color: white;">..</label>
                    <button class="btn btn-block btn-navy" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
                </div>
            </div>
        </form> -->
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST JAM KERJA</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_jam_kerja">
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $("#range_periode").daterangepicker({
            showDropdowns: true
        });
        loadJamKerja()
    })

    function loadJamKerja(){
        $('#list_jam_kerja').html('')
        $('#list_jam_kerja').append(divLoaderNavy)
        $('#list_jam_kerja').load('<?=base_url("master/C_Master/loadJamKerja")?>', function(){
            $('#loader').hide()
        })
    }

    $('#btn_sync').on('click', function(){
        $('#btn_sync').hide()
        $('#btn_loading_sync').show()
        $.ajax({
            url: '<?=base_url("master/C_Master/downloadApiHariLibur")?>',
            method: 'post',
            data: {},
            success: function(){
                successtoast('Sinkronasi berhasil')
                $('#btn_sync').show()
                $('#btn_loading_sync').hide()
                loadHariLibur()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                $('#btn_sync').show()
                $('#btn_loading_sync').hide()
            }
        })
    })

    $('#form_tambah_hari_libur').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("master/C_Master/tambahHariLibur")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(){
                successtoast('Data berhasil ditambahkan')
                loadHariLibur()
                $('#keterangan').val('')
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>