<div class="card card-default">
    <div class="card-header">
        <h3>UPLOAD GAJI PEGAWAI</h3>
    </div>
    <div class="card-body">
        <div class="col-lg-12 mb-3">
            <button href="#modal_upload_gaji_history" data-toggle="modal" onclick="loadUploadGajiHistory()"
            class="btn btn-warning"><i class="fa fa-clock"></i> Upload History</button>
        </div>
        <div class="col-lg-12">
            <form method="post" id="form_upload_gaji" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <input id="file_gaji" class="form-control" type="file" name="file_gaji" />
                    </div>
                    <div class="col-lg-4">
                        <button id="btn_upload" class="btn btn-navy"><i class="fa fa-upload"></i> Upload</button>
                        <button type="button" id="btn_upload_loading" disabled style="display: none;" class="btn btn-navy"><i class="fa fa-spin fa-spinner"></i> Mohon Menunggu...</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <form id="form_data_not_found" target="_blank" action="<?=base_url('rekap/C_Rekap/downloadDataNotFoundUploadGaji')?>">
            </form>
            <hr>
        </div>
        <div class="col-lg-12">
            <form id="form_load_list_gaji">
                <div class="row">
                    <div class="col-lg-9">
                        <select class="form-control select2-navy" style="width: 100%;"
                        id="skpd" data-dropdown-css-class="select2-navy" name="skpd">
                            <option value="0">Semua</option>
                            <?php $i = 0; foreach($list_skpd as $ls){ ?>
                                <option <?=$i == 1 ? 'selected' : ''?> value="<?=$ls['id_unitkerja']?>"><?=$ls['nm_unitkerja']?></option>
                            <?php $i++; } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btm-sm btn-navy"><i class="fa fa-search"></i> Cari</button>
                    </div>
                    <div class="col-lg-12 mt-3" id="div_result"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload_gaji_history" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">UPLOAD GAJI HISTORY</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_upload_gaji_history_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        $('#skpd').select2()
        loadGajiPegawai()
    })

    function loadGajiPegawai(){
        $('#form_load_list_gaji').submit()
    }

    $('#form_load_list_gaji').on('submit', function(e){
        e.preventDefault()
        $('#div_result').html('')
        $('#div_result').append(divLoaderNavy)

        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/loadGajiPegawai')?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(rs){
                $('#div_result').html('')
                $('#div_result').append(rs)
            }, error: function(e){
                $('#div_result').html('')
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    })

    function loadUploadGajiHistory(){
        $('#modal_upload_gaji_history_content').html('')
        $('#modal_upload_gaji_history_content').append(divLoaderNavy)
        $('#modal_upload_gaji_history_content').load('<?=base_url("rekap/C_Rekap/loadUploadGajiHistory")?>', function(){
            $('#loader').hide()
        })
    }

    $('#form_upload_gaji').on('submit', function(e){
        e.preventDefault()
        $('#btn_upload').hide()
        $('#btn_upload_loading').show()

        var formvalue = $('#form_upload_gaji');
        var form_data = new FormData(formvalue[0]);
        var ins = document.getElementById('file_gaji').files.length;
        
        if(ins == 0){
            errortoast("Silahkan memilih file terlebih dahulu");
            return false;
        }

        $.ajax({  
            url: "<?=base_url('rekap/C_Rekap/readUploadGaji')?>",
            method: "POST",  
            data: form_data,  
            contentType: false,  
            cache: false,  
            processData:false,  
            // dataType: "json",
            success:function(res){ 
                let rs = JSON.parse(res)
                if(rs.code == 0){
                    successtoast('Berhasil')
                    if(rs.flag_not_found == 1){
                        $('#form_data_not_found').submit()
                    }
                } else {
                    errortoast(rs.message)
                }
                loadGajiPegawai()
                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
            }, error: function(err){
                errortoast('Terjadi Kesalahan')
                $('#btn_upload').show()
                $('#btn_upload_loading').hide()
            }
        });
    })
</script>