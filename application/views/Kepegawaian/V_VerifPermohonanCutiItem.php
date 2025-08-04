<style>
  .nav-link-profile{
    padding: 5px !important;
    font-size: .7rem;
    color: black;
    border: .5px solid var(--primary-color) !important;
    border-bottom-left-radius: 0px;
  }

  .nav-item-profile:hover, .nav-link-profile:hover{
    color: white !important;
    background-color: #222e3c91;
  }

  .nav-tabs .nav-link.active, .nav-tabs .show>.nav-link{
    /* border-radius: 3px; */
    background-color: var(--primary-color);
    color: white;
  }
</style>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-body">
      <?php if($this->general_library->isProgrammer() || $this->general_library->isHakAkses('admin_pengajuan_cuti')){ ?>
        <div class="row">
          <div class="col-lg-12 table-responsive">
            <?php
              $list_data['item'] = $result ? $result : null;
              $this->load->view('kepegawaian/V_VerifPermohonanCutiItemTabel', $list_data)
            ?>
          </div>
        </div>
      <?php } else { ?>
      <div class="row">
        <div class="col-lg-12">
          <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item nav-item-profile" role="presentation">
              <button class="nav-link nav-link-profile active" id="pills-bisa_verif-tab" data-bs-toggle="pill" data-bs-target="#pills-bisa_verif" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Bisa Verif</button>
            </li>
            <li class="nav-item nav-item-profile" role="presentation">
              <button class="nav-link nav-link-profile" id="pills-tidak_bisa_verif-tab" data-bs-toggle="pill" data-bs-target="#pills-tidak_bisa_verif" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tidak Bisa Verif</button>
            </li>
          </ul>
        </div>
        <div class="col-lg-12">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-bisa_verif" role="tabpanel" aria-labelledby="pills-bisa_verif-tab">
              <div class="table-responsive" style="width: 100%;">
                <?php
                  $list_data['item'] = isset($result['list_bisa_verif']) ? $result['list_bisa_verif'] : null;
                  $this->load->view('kepegawaian/V_VerifPermohonanCutiItemTabel', $list_data)
                ?>
              </div>
            </div>
            <div class="tab-pane show" id="pills-tidak_bisa_verif" role="tabpanel" aria-labelledby="pills-tidak_bisa_verif-tab">
              <div class="table-responsive" style="width: 100%;">
                <?php
                  $list_data['item'] = isset($result['list_tidak_bisa_verif']) ? $result['list_tidak_bisa_verif'] : null;
                  $this->load->view('kepegawaian/V_VerifPermohonanCutiItemTabel', $list_data)
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_detail_cuti" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="modal-dialog" class="modal-dialog modal-xl">
		<div class="modal-content" id="content_modal_detail_cuti">
		</div>
	</div>
</div>

<script>
  $(function(){
  })

  function loadDetailCutiVerif(id){
    $('#result_search').html('')
    $('#result_search').append(divLoaderNavy)
    $('#result_search').load('<?=base_url('kepegawaian/C_Kepegawaian/loadDetailCutiVerif/')?>'+id, function(){
      $('#loader').hide()
    })
  }
</script>