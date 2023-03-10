<h1 class="h3 mb-3">Upload Dokumen Pendukung Absensi</h1>  
<div class="card card-default">
    <!-- <div class="card-header">
        <h4>Upload Dokumen Pendukung Absensi</h4>
    </div> -->
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-12">
                <button  data-toggle="modal" onclick="tambahData()" href="#tambah_data_disiplin_kerja" class="btn btn-primary "><i class="align-middle me-2 fas fa-fw fa-plus-circle"></i> Tambah</button>           
            </div>
        </div>
        <form id="form_search_disiplin_kerja">
            <div class="row mt-3">
                <?php if($this->general_library->isProgrammer() || $this->general_library->getUnitKerjaPegawai() == ID_BIDANG_PEKIN){ ?>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg col-md-12">
                        <label>Pilih Unit Kerja</label>
                        <select class="form-control select2-navy" style="width: 100%"
                            id="id_unitkerja" data-dropdown-css-class="select2-navy" name="id_unitkerja">
                            <?php foreach($skpd as $s){ ?>
                                <option value="<?=$s['id_unitkerja']?>"><?=$s['nm_unitkerja']?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="col-lg col-md-12">
                    <label>Pilih Bulan</label>  
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
                <div class="col-lg col-md-12">
                    <label>Pilih Tahun</label>  
                    <input readonly autocomplete="off" class="form-control datepicker customInput"  id="tahun" name="tahun" value="<?=date('Y')?>" />
                </div>
                <div class="col-lg col-md-12" style="margin-top: 23px;">
                    <button type="submit" class="btn btn-block btn-navy"><i class="fa fa-search"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="tambah_data_disiplin_kerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">Data Dokumen Pendukung</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          
          <div id="tambah_data_disiplin_kerja_content">
          </div>
      </div>
  </div>
</div>
<div class="row">
<h1 class="h3 mb-3">Data Dokumen Pendukung</h1>  

    <div class="col-12" id="result">
    </div>
</div>

<script>
    let active_status = 0

    $(function(){
        $('#bulan').select2()
        $('#id_unitkerja').select2()
        $('#form_search_disiplin_kerja').submit()
    })

    function tambahData(){
        var id_unitkerja = '<?=$this->general_library->getUnitKerjaPegawai()?>'
        <?php if($this->general_library->isProgrammer() || $this->general_library->getUnitKerjaPegawai() == ID_BIDANG_PEKIN){ ?>
            id_unitkerja = $('#id_unitkerja').val()
        <?php } ?>
        $('#tambah_data_disiplin_kerja_content').html('')
        $('#tambah_data_disiplin_kerja_content').append(divLoaderNavy)
        $('#tambah_data_disiplin_kerja_content').load('<?=base_url("kinerja/C_Kinerja/modalTambahDataDisiplinKerja")?>'+'/'+id_unitkerja, function(){
            $('#loader').hide()
        })
    }

    $('#form_search_disiplin_kerja').submit(function(e){
        $('#result').show()
        $('#result').html('')
        $('#result').append(divLoaderNavy)
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kinerja/C_Kinerja/searchDisiplinKerja")?>',
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