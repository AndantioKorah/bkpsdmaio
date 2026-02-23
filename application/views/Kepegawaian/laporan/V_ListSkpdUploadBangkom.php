<div class="card card-default">



    <div class="card-header" style="margin-bottom:-40px">
        <h4>Data Upload Bangkom Pegawai</h4>
    </div>
    <div class="card-body" >
        <form id="form_search" class="mt-4">
        <?php if(isKasubKepegawaian($this->general_library->getNamaJabatan(), $this->general_library->getEselon())) { ?> 
         <div class="row">
                  <div class="col-lg-12">
                                <label>Pilih Unit Kerja</label>
                                <select class="form-control select2-navy" 
                                    id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                    <?php $i = 0; foreach($unitkerja as $u){ $i++; ?>
                                        <option <?=$u['id_unitkerja'] == $this->general_library->getUnitKerjaPegawai() ? 'selected' : ''?>
                                        value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                    <?php } ?>
                                </select>
                            </div>
        <?php } else { ?>
            <div class="row">
              <div class="col-lg-12">
                            <label class="label-filter">Unit Kerja</label>
                            <div class="">
                                <select class="form-control select2-navy" 
                                    id="unitkerja" data-dropdown-css-class="select2-navy" name="unitkerja" required>
                                    <option value="0" selected>Semua</option>
                                    <?php foreach($unitkerja as $u){ ?>
                                        <option value="<?=$u['id_unitkerja']?>"><?=$u['nm_unitkerja']?></option>
                                    <?php } ?>
                                    <option value="990" >Semua TK</option>
                                    <option value="991" >Semua SD</option>
                                    <option value="992" >Semua SMP</option>
                                    <option value="993" >Semua UPTD Dinas kesehatan</option>
                                </select>
                            </div>
                        </div>
            <?php } ?>

               <div class="form-group" >
    <label for="exampleFormControlInput1">Tahun</label>
    <input  class="form-control yearpicker customInput" id="tahun" name="tahun" value="<?= date('Y');?>">
  </div>

    <div class="form-group" >
    <label for="exampleFormControlInput1">Bulan</label>
    <select class="form-control select2-navy customInput" style="width: 100%"
                 id="bulan" data-dropdown-css-class="select2-navy" name="bulan">
                 <option selected>- Pilih Bulan -</option>
                 <option <?=date('m') == 1 ? 'selected' : '';?> value="1">Januari</option>
                 <option <?=date('m') == 2 ? 'selected' : '';?> value="2">Februari</option>
                 <option <?=date('m') == 3 ? 'selected' : '';?> value="3">Maret</option>
                 <option <?=date('m') == 4 ? 'selected' : '';?> value="4">April</option>
                 <option <?=date('m') == 5 ? 'selected' : '';?> value="5">Mei</option>
                 <option <?=date('m') == 6 ? 'selected' : '';?> value="6">Juni</option>
                 <option <?=date('m') == 7 ? 'selected' : '';?> value="7">Juli</option>
                 <option <?=date('m') == 8 ? 'selected' : '';?> value="8">Agustus</option>
                 <option <?=date('m') == 9 ? 'selected' : '';?> value="9">September</option>
                 <option <?=date('m') == 10 ? 'selected' : '';?> value="10">Oktober</option>
                 <option <?=date('m') == 11 ? 'selected' : '';?> value="11">November</option>
                 <option <?=date('m') == 12 ? 'selected' : '';?> value="12">Desember</option>
                 </select>
  </div>
                
                <div class="col-lg-12 col-md-9" style="margin-top: 28px;">
                    <button type="submit" class="btn btn-block btn-navy float-right"><i class="fa fa-search"></i> Cari</button>
                </div>
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
           $('.select2-navy').select2()
        // $('#form_search').submit()
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
            url: '<?=base_url("kepegawaian/C_Kepegawaian/openListUploadBangkomSkpdItem")?>',
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