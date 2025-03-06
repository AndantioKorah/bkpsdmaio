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
            <div id="dropzone">
              <form id="form_dropzone" class="dropzone needsclick">
                <div class="dz-message needsclick">
                  <span class="text" style="color: grey;">Klik atau Drag File</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#btn_add_new').on('click', function(){
    $('#div_form_button').hide()
    $('#div_form_input').show()
  })

  $('#btn_back').on('click', function(){
    $('#div_form_button').show()
    $('#div_form_input').hide()
  })
</script>