   <style>
    
    .sp_profil{
      font-size: .9rem;
      font-weight: bold;
    }

    .sp_profil_sm{
      font-size: .8rem;
      font-weight: bold;
    }
    
    .hr_class{
      margin-top: 0px;
      margin-bottom: 0px;
      border: .05rem solid black;
    }

    .sp_profil_alamat{
      /* line-height: 100px; */
    }
    
    .sp_label{
      font-size: .6rem;
      font-style: italic;
      font-weight: 600;
      color: grey;
    }

    .div_label{
      margin-bottom: -5px;
    }

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

    .div.dataTables_wrapper div.dataTables_length select{
      height: 10px !important;
      width: 40px !important;
    }

    .div.dataTables_wrapper div.dataTables_filter input{
      height: 10px !important;
    }

    #profile_pegawai{
      width: 250px;
      height: calc(250px * 1.25);
      background-size: cover;
      /* object-fit: contain; */
      box-shadow: 5px 5px 10px #888888;
      border-radius: 10%;
    }

    /* .badge{
      box-shadow: 3px 3px 10px #888888;
      background-color: #ed1818;
      border: 2px solid #ed1818;
      color: white;
    } */

    .foto_container {
  position: relative;
  /* width: 50%; */
}

.image-settings {
  opacity: 1;
  display: block;
  /* width: 100%; */
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.foto_container:hover .image {
  opacity: 0.3;
  cursor:pointer;
}

.foto_container:hover .middle {
  opacity: 1;
  cursor:pointer;
}


  </style>

 

   


    <div class="card card-default">
        <div class="card-header">
                <div class="col-3">
                    <h3 class="card-title"></h3>
                </div>
        </div>
        <div class="card-body" style="margin-top:-20px;">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button onclick="loadListPegawaiPenilaianKinerjaJpt(1)" class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Administrator</button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="loadListPegawaiPenilaianKinerjaJpt(2)" class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">JPT Pratama</button>
        </li>
       
        </ul>
        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
         <br> <div id="list_pegawai_penilaian_kinerjax" class="list_pegawai_penilaian_kinerja_jpt"></div>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <br> <div id="list_pegawai_penilaian_kinerja_jptx"  class="list_pegawai_penilaian_kinerja_jpt"></div>
        </div>
        </div>


       
        </div>
    </div>

    
<!-- modal detail indikator -->
<div class="modal fade" id="modal_penilaian_kinerja" tabindex="-1" role="dialog" aria-labelledby="table-admModalLabelIndikator" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="table-admModalLabelIndikator"><span id="nm_indikator"></span></h3>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="div_modal_penilaian_kinerja">
      
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<!-- tutup modal detail indikator -->


<script>

$(function(){
   

   $(".select2").select2({   
        width: '100%',
        dropdownAutoWidth: true,
        allowClear: true,
    });
   
    loadListPegawaiPenilaianKinerjaJpt(1)
    })

    function loadListPegawaiPenilaianKinerjaAdm(id){

  //  var id = $('#unit_kerja').val()
   $('.list_pegawai_penilaian_kinerja_jpt').html('')
   $('.list_pegawai_penilaian_kinerja_jpt').append(divLoaderNavy)
   $('.list_pegawai_penilaian_kinerja_jpt').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainKinerjaAdm/")?>'+id, function(){
     $('#loader').hide()
   })
  }

  function loadListPegawaiPenilaianKinerjaJpt(id){

  //  var id = $('#unit_kerja').val()
   $('.list_pegawai_penilaian_kinerja_jpt').html('')
   $('.list_pegawai_penilaian_kinerja_jpt').append(divLoaderNavy)
   $('.list_pegawai_penilaian_kinerja_jpt').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainKinerjaJpt/")?>'+id, function(){
     $('#loader').hide()
   })
  }

  $('#form_cari').on('submit', function(e){  

        e.preventDefault();
        var formvalue = $('#form_cari');
        var form_data = new FormData(formvalue[0]);
        loadListPegawaiDinilai()

  
}); 

$(document).on("click", ".open-DetailPenilaian", function () {

var id = $(this).data('id');
var nip = $(this).data('nip');
var kode = $(this).data('kode');

$('#div_modal_penilaian_kinerja').html('')
$('#div_modal_penilaian_kinerja').append(divLoaderNavy)
$('#div_modal_penilaian_kinerja').load('<?=base_url("simata/C_Simata/loadModalPenilaianKinerja/")?>'+id+'/'+nip+'/'+kode, function(){
  $('#loader').hide()
})

});


</script>