<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER HAK AKSES</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_hak_akses">
            <div class="row">
                <div class="col-lg-6">
                    <label>Nama Hak Akses</label>
                    <input id="nama_hak_akses" name="nama_hak_akses" class="form-control" />
                </div>
                <div class="col-lg-6">
                    <label>Meta Name</label>
                    <input id="meta_name" name="meta_name" class="form-control" />
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
        <h3 class="card-title">LIST MASTER HAK AKSES</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_master_hak_akses">
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
        loadHakAkses()
    })

    function loadHakAkses(){
        $('#list_master_hak_akses').html('')
        $('#list_master_hak_akses').append(divLoaderNavy)
        $('#list_master_hak_akses').load('<?=base_url("master/C_Master/loadMasterHakAkses")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_hak_akses').on('submit', function(e){
        e.preventDefault()
            $.ajax({
                url: '<?=base_url("master/C_Master/inputMasterHakAkses")?>',
                method: 'post',
                data: $(this).serialize(),
                success: function(rs){
                    successtoast('Data Berhasil Disimpan')
                    $('#nama_hak_akses').val("")
                    $('#meta_name').val("")
                    loadHakAkses()
                }, error: function(e){
                    errortoast('Terjadi Kesalahan')
                }
            })
        })

</script>