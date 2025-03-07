<div class="card card-default">
  <div class="card-header">
    <div class="card-title">
      <h4>USUL DIGITAL SIGNATURE</h4>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 text-center" id="div_form_button">
        <button style="width: 300px; height: 100px; font-size: 1.1rem;" id="btn_add_new" class="btn btn-sm btn-navy">
          <i class="fa fa-plus"></i> TAMBAH USUL DS
        </button>
      </div>
      <div class="col-lg-12" id="div_form_input" style="display: none;">
        <div class="row">
          <div class="col-lg-12 text-left">
            <button id="btn_back" class="btn btn-sm btn-warning"><i class="fa fa-chevron-left"></i> Kembali</button>
          </div>
          <div class="col-lg-12">
            <div id="dropzone" class="dropzone text-center">
              <span class="span_dz"><i class="fa fa-3x fa-upload"></i><br>Klik atau drag file ke area ini</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url()?>assets/siladen/plugins/dropzone/min/dropzone.min.js"></script>

<script>
  $('#btn_add_new').on('click', function(){
    $('#div_form_button').hide()
    $('#div_form_input').show()
  })

  $('#btn_back').on('click', function(){
    $('#div_form_button').show()
    $('#div_form_input').hide()
  })

  Dropzone.options.dropzone = {
    url: "<?=base_url("kepegawaian/C_Layanan/uploadFileUsulDs")?>",
    autoProcessQueue: false,
    paramName: "file",
    clickable: true,
    maxFilesize: 5, //in mb
    addRemoveLinks: true,
    acceptedFiles: '.pdf',
    dictDefaultMessage: "",
    init: function() {
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
    }
  };
</script>