<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER SYARAT LAYANAN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_syarat_layanan">
            <div class="row">
                <div class="col-lg-6">
                    <label>Jenis Layanan</label>
                    <select class="form-control select2-navy select2" style="width: 100%"
                            id="jenis_layanan" data-dropdown-css-class="select2-navy" name="jenis_layanan">
                            <option value="" selected disable>Pilih</option>
                                <?php if($layanan){
                                    foreach($layanan as $lay){
                                    ?>
                                    <option value="<?=$lay['kode']?>">
                                        <?=$lay['nama']?>
                                    </option>
                                <?php } } ?>
                            </select>
                </div>
                <div class="col-lg-6">
                    <label>Berkas Layanan</label>
                    <select class="form-control select2-navy select2" style="width: 100%"
                            id="dokumen_persyaratan" data-dropdown-css-class="select2-navy" name="dokumen_persyaratan" >
                            <option value=""  selected disable>Pilih</option>
                                <?php if($dokumen){
                                    foreach($dokumen as $dok){
                                    ?>
                                    <option value="<?=$dok['id_dokumen']?>">
                                        <?=$dok['dokumen']?>
                                    </option>
                                <?php } } ?>
                            </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-right">
                    <button class="btn btn-block btn-navy" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">LIST SYARAT LAYANAN</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_master_syarat_layanan">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">TAMBAH HAK AKSES USER</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div id="modal_tambah_user_content">
            </div>
          </div>
      </div>
  </div>
</div>

<script>

    
    $(function(){
        $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
        loadSyaratLayanan()
    })

    function loadSyaratLayanan(){
        $('#list_master_syarat_layanan').html('')
        $('#list_master_syarat_layanan').append(divLoaderNavy)
        $('#list_master_syarat_layanan').load('<?=base_url("master/C_Master/loadMasterSyaratLayanan")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_syarat_layanan').on('submit', function(e){
        var jenis_layanan = $('#jenis_layanan').val();
        var dokumen_persyaratan = $('#dokumen_persyaratan').val();

        if(jenis_layanan == ""){
            errortoast("Jenis Layanan belum dipilih")
            return false;
        }

        if(dokumen_persyaratan == ""){
            errortoast("Berkas Layanan belum dipilih")
            return false;
        }
       
        e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/inputMasterSyaratLayanan")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    successtoast('Data Berhasil Disimpan')
                    $('#nama_hak_akses').val("")
                    $('#meta_name').val("")
                    loadSyaratLayanan()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

</script>