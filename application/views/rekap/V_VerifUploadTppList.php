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
<div class="row" style="margin-top: -30px;">
    <div class="col-lg-12">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadListData('0')" class="nav-link nav-link-profile active" id="pills-belum-verif-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-belum-verif" type="button" role="tab"
                    aria-controls="pills-home" aria-selected="true">Belum Verif
                </button>
            </li>
            <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadListData('1')" class="nav-link nav-link-profile" id="pills-diterima-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-diterima" type="button" role="tab"
                    aria-controls="pills-home" aria-selected="true">Diterima
                </button>
            </li>
            <li class="nav-item nav-item-profile" role="presentation">
                <button onclick="loadListData('2')" class="nav-link nav-link-profile" id="pills-ditolak-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-ditolak" type="button" role="tab"
                    aria-controls="pills-home" aria-selected="true">Ditolak
                </button>
            </li>
        </ul>
    </div>
    <div class="col-lg-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-belum-verif" role="tabpanel" aria-labelledby="pills-belum-verif-tab">
                <div id="div_result_belum_verif"></div>
            </div>
            <div class="tab-pane" id="pills-diterima" role="tabpanel" aria-labelledby="pills-diterima-tab">
                <div id="div_result_diterima"></div>
            </div>
            <div class="tab-pane" id="pills-ditolak" role="tabpanel" aria-labelledby="pills-ditolak-tab">
                <div id="div_result_ditolak"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_verif_upload_berkas_tpp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">VERIFIKASI UPLOAD BERKAS TPP</h6>
              <button type="button" class="close" id="btn_modal_close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_verif_upload_berkas_tpp_content">
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_upload_balasan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">UPLOAD FILE BALASAN BERKAS TPP</h6>
              <button type="button" class="close" id="btn_modal_balasan_close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_upload_balasan_content">
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_file_balasan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title">FILE BALASAN BERKAS TPP</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="modal_file_balasan_content">
          </div>
      </div>
  </div>
</div>

<script>
    $(function(){
        loadListData('0')
    })

    function loadListData(status){
        active_status = status
        let div_id = 'div_result_belum_verif';
        if(status == '1' || status == 1){
            div_id = 'div_result_diterima';
        } else if(status == '2' || status == 2){
            div_id = 'div_result_ditolak';
        }

        $('#'+div_id).html('')
        $('#'+div_id).append(divLoaderNavy)
        $.ajax({
            url: '<?=base_url('rekap/C_Rekap/loadRiwayatVerifBerkasTppByStatus/')?>'+status,
            method: 'POST',
            data: {
                params: '<?=$params?>'
            },
            success: function(rs){
                $('#'+div_id).html('')
                $('#'+div_id).html(rs)
            }, error: function(e){
                errortoast('Terjadi Kesalahan')
                console.log(e)
            }
        })
    }
</script>