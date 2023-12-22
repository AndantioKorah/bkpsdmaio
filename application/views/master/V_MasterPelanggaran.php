<style>
    .form-check-input:hover{
        cursor:pointer;
    }
</style>

<div class="card card-default">
    <div class="card-header"  style="display: block;">
        <h3 class="card-title">MASTER PELANGGARAN</h3>
    </div>
    <div class="card-body" style="display: block;">
        <form id="form_pelanggaran">
            <div class="row">
                <div class="col-lg-12">
                    <label>Nama Pelanggaran</label>
                    <input autocomplete="off" id="nama_pelanggaran" name="nama_pelanggaran" class="form-control" />
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
        <h3 class="card-title">LIST MASTER PELANGGARAN</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12" id="list_master_pelanggaran">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pelanggaran_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">TAMBAH PELANGGARAN DETAIL</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div id="modal_pelanggaran_detail_content">
            </div>
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        loadPelanggaran()
    })

    function loadPelanggaran(){
        $('#list_master_pelanggaran').html('')
        $('#list_master_pelanggaran').append(divLoaderNavy)
        $('#list_master_pelanggaran').load('<?=base_url("master/C_Master/loadMasterPelanggaran")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_pelanggaran').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("master/C_Master/inputMasterPelanggaran")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(rs){
                successtoast('Data Berhasil Disimpan')
                $('#nama_pelanggaran').val("")
                $('#meta_name').val("")
                loadPelanggaran()
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
            }
        })
    })

</script>