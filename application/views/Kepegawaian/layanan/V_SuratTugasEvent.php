<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Input Surat Tugas Event</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <form id="form_input">
                        <div class="col-lg-12">
                            <label>Pilih Event</label>
                            <select class="form-control select2-navy" style="width: 100%;"
                                id="list_event" data-dropdown-css-class="select2-navy" name="list_event">
                                <?php if($list_event){
                                    foreach($list_event as $le){ if($le['flag_surat_tugas'] == 1){
                                    ?>
                                    <option value="<?=$le['id']?>">
                                        <?=formatDateNamaBulan($le['tgl'])." - ".$le['judul']?>
                                    </option>
                                <?php } } } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-2">
                            <label>Pilih Pegawai</label>
                            <select required multiple="multiple" class="form-control select2-navy" style="width: 100%"
                                id="list_pegawai" data-dropdown-css-class="select2-navy" name="list_pegawai[]">
                                <?php foreach($list_pegawai as $p){ ?>
                                    <option value="<?=$p['skpd'].";".$p['nipbaru_ws'].";".$p['id_m_user']?>"><?=getNamaPegawaiFull($p)?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label>Upload Surat Tugas:</label>
                            <div id="dropzone" class="dropzone text-center">
                                <span class="span_dz"><i class="fa fa-3x fa-upload"></i><br>Klik atau drag file ke area ini<br>*Hanya file pdf yang akan terupload</span>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2 text-right">
                            <hr>
                            <button id="btn_save" class="btn btn-navy"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">
                    <h4>LIST SURAT TUGAS EVENT</h4>
                    <div class="text-right">
                        <button id="btn_refresh" class="btn btn-sm btn-navy"><i class="fa fa-sync"></i> Refresh</button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="div_list_data"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>assets/siladen/plugins/dropzone/min/dropzone.min.js"></script>

<script>
    $(function(){
        $('#list_event').select2()
        $('#list_pegawai').select2()
        loadListSuratTugas()
    })

    $('#btn_refresh').on('click', function(){
        loadListSuratTugas()
    })

    function loadListSuratTugas(){
        btnLoader("btn_refresh")
        $('#div_list_data').html('')
        $('#div_list_data').append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Layanan/loadListSuratTugas")?>',
            method: 'post',
            data: null,
            success: function(data){
                $('#div_list_data').html(data)
                btnLoader("btn_refresh")
            }, error: function(e){
                btnLoader("btn_refresh")
                $('#div_list_data').html('')
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    $('#form_input').on('submit', function(e){
        btnLoader("btn_save")
        e.preventDefault()
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Layanan/getSelectedFileSuratTugasEvent")?>',
            method: 'post',
            data: $(this).serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.count == 0){
                    btnLoader("btn_save")
                    errortoast("Belum ada file yang dipilih")
                } else {
                    submitSaveSuratTugasEvent()
                }
            }, error: function(e){
                btnLoader("btn_save")
                errortoast('Terjadi Kesalahan')
            }
        })
    })

    function submitSaveSuratTugasEvent(){
        $.ajax({
            url: '<?=base_url("kepegawaian/C_Layanan/submitUploadSuratTugasEvent")?>',
            method: 'post',
            data: $('#form_input').serialize(),
            success: function(data){
                let rs = JSON.parse(data)
                if(rs.code != 0){
                    btnLoader("btn_save")
                    errortoast(rs.message)
                } else {
                    successtoast('Data Berhasil Disimpan')
                    window.location=""
                    // btnLoader("btn_save")
                    // loadListSuratTugas()
                }
            }, error: function(e){
                btnLoader("btn_save")
                errortoast('Terjadi Kesalahan')
            }
        })
    }

    function removeAllUploadedFileSuratTugasEvent(){
        $.ajax({
        url: '<?=base_url("kepegawaian/C_Layanan/removeAllUploadFileSuratTugasEvent")?>',
        method: 'post',
        data: null,
        success: function(data){
        }, error: function(e){
            errortoast('Terjadi Kesalahan')
        }
        })
    }

    Dropzone.options.dropzone = {
    url: "<?=base_url("kepegawaian/C_Layanan/uploadFileSuratTugasEvent")?>",
    autoProcessQueue: true,
    paramName: "file",
    clickable: true,
    maxFilesize: 2, //in mb
    maxFiles: 1,
    addRemoveLinks: true,
    acceptedFiles: '.pdf',
    dictDefaultMessage: "",
    init: function() {
      this.on("maxfilesexceeded", function(file){
        errortoast("Hanya dapat mengupload 1 File");
      });
      this.on("sending", function(file, xhr, formData) {
        // console.log("sending file");
      });
      this.on("success", function(file, responseText) {
        console.log('great success');
      });
      this.on("addedfile", function(file){
        $('.span_dz').hide()
        // console.log('file added');
      });
      this.on("removedfile", function(file){
        $.ajax({
          url: '<?=base_url("kepegawaian/C_Layanan/removeuploadSuratTugasEvent")?>',
          method: 'post',
          data: {
            filename: file.name
          },
          success: function(data){
            file.previewElement.remove();
          }, error: function(e){
            errortoast('Terjadi Kesalahan')
          }
        })
      })
    }
  };
</script>