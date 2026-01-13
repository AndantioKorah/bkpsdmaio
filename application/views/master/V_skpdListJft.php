<div class="card card-default">



    <div class="card-header" style="margin-bottom:-40px">
        <h4>Jabatan Fungsional</h4>
    </div>
    <div class="card-body" >
        <form id="form_search" class="mt-4">
            <div class="row">
                <div class="col-lg col-md-12">
                    <label>Pilih Unit Kerja</label>
                    <select class="form-control select2-navy" style="width: 100%"
                        id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                        <option selected disabled value="0">Pilih Unit Kerja</option>
                        <?php foreach($unitkerja as $s){ ?>
                            <option <?php if($this->general_library->getUnitKerjaPegawai() == $s['id_unitkerja']) echo 'selected'; else echo ''; ?> value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <!-- <div class="col-lg-2 col-md-9" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                </div> -->
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12" id="result">
    </div>
</div>

<script>
    let active_status = 0

    $(function(){
        $('#bulan').select2()
        $('#id_unitkerja').select2()
        // $('#form_search').submit()
        $('.datepicker3').datepicker({
        format: 'yyyy-mm-dd',
            // viewMode: "years", 
            // minViewMode: "years",
            // orientation: 'bottom',
            autoclose: true
        });
        $('#form_search').submit()
        // $("#sidebar_toggle" ).trigger( "click" );
    })

        $('#id_unitkerja').on('change', function(){
            $('#form_search').submit()
        })


    $('#form_search').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/openListPegawaiDetailSkpdMenuItem")?>',
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