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

    .nav-link-simata{
      /* padding: 5px !important; */
      font-size: .9rem;
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

        <script>
    $(function() {
      // activaTab('ccc');
    });

    function activaTab(tab){
  $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };
    </script>



        <!-- <form class="form-custom" id="form_penilaian_talenta" method="post"> -->
          <input type="hidden" id="jenis_pengisian"  name="jenis_pengisian" value="<?=$jenis_pengisian;?>">
        <div class="row">
          <div class="col-lg-6">
            <label>Unit Kerja</label>
            <select class="form-control form-custom-input select2-navy select2" style="width: 100%"
                id="unitkerjamaster" data-dropdown-css-class="select2-navy" name="unitkerjamaster">
                <?php if($this->general_library->isProgrammer()){ ?>
                  <option selected value="0">Semua</option>
                <?php } ?>
                <option selected value="0">Semua</option>
                <?php foreach($list_skpd_master as $skpd){ ?>
                    <option value="<?=$skpd['id_unitkerjamaster']?>"><?=$skpd['nm_unitkerjamaster']?></option>
                <?php } ?>
                <option value="5000000">Kecamatan</option>
                <option value="8000000">Sekolah</option>

            </select>
          </div>
          <div class="col-lg-6" >
            <label>Eselon</label>
            <select class="form-control form-custom-input select2-navy select2" style="width: 100%"
                id="eselon" data-dropdown-css-class="select2-navy" name="eselon">
                
                <?php if($jenis_pengisian == 1) { ?>
        
        <?php } ?>
        <?php if($jenis_pengisian == 2) { ?>
          <option value="6">III A</option>
          <option value="7">III B</option>
          <option value="8">IV A</option>
          <option value="9">IV B</option>
        <?php } ?>
        <?php if($jenis_pengisian == 3) { ?>
          <option value="4">II A</option>
          <option value="5">II B</option>
          <option value="6">III A</option>
          <option value="7">III B</option>
        <?php } ?>

                   
            </select>
          </div>
          
          <div class="col-lg-12 mt-3 text-right">
            <button id="btn_nilai" type="button" style="width: 25% !important; height: 35px !important; font-size: .8rem;"
            class="btn btn-navy btn-sm"> 
            <label class="form-check-label" for="flexCheckChecked" style="color:#fff;">
          <i class="fa fa-sync"></i> Penilaian 
        </label>
          </button>
          <?php if($this->general_library->isProgrammer()) { ?>
          <button id="btn_hitung_masa_kerja" type="button" style="width: 25% !important; height: 35px !important; font-size: .8rem;"
            class="btn btn-navy btn-sm"> 
            <label class="form-check-label" for="flexCheckChecked">
          <i class="fa fa-sync"></i> Hitung Masa Kerja 
        </label>
          </button>
          <?php } ?>

          </div>
        </div>
      <!-- </form> -->

   
      
<ul class="nav nav-tabs">
        <?php if($jenis_pengisian == 1 ) { ?>
        <li class="nav-item" role="presentation">
            <a onclick="loadListPegawaiPenilaianPotensialJpt(4,<?=$jenis_pengisian;?>,0,0,0)" class="nav-link nav-link-simata"  id="pengawas-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" href="#pngws">Pelaksana</a>
        </li>
        <?php } ?>
        <?php if($jenis_pengisian == 1 || $jenis_pengisian == 2) { ?>
        <li class="nav-item" role="presentation">
            <a onclick="loadListPegawaiPenilaianPotensialJpt(3,<?=$jenis_pengisian;?>,0,0,0)" class="nav-link nav-link-simata"  id="pengawas-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" href="#pngws">Pengawas</a>
        </li>
        <?php } ?>
        <?php if($jenis_pengisian == 3 || $jenis_pengisian == 2) { ?>
          <li class="nav-item"><a onclick="loadListPegawaiPenilaianPotensialJpt(1,<?=$jenis_pengisian;?>,0,0,0)" class="nav-link nav-link-simata"  id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="profile" aria-selected="false" href="#adm">Administrator</a></li>

        <!-- <li class="nav-item" role="presentation">
            <button onclick="loadListPegawaiPenilaianPotensialJpt(1,<?=$jenis_pengisian;?>,0)" class="nav-link nav-link-simata" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Administrator</button>
        </li> -->
        <?php } ?>
        <?php if($jenis_pengisian == 3) { ?>
          <li class="nav-item"><a onclick="loadListPegawaiPenilaianPotensialJpt(2,<?=$jenis_pengisian;?>,0,0,0)" class="nav-link nav-link-simata"  id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" href="#jpt">JPT Pratama</a></li>

        <!-- <li class="nav-item" role="presentation">
            <button onclick="loadListPegawaiPenilaianPotensialJpt(2,<?=$jenis_pengisian;?>,0)" class="nav-link nav-link-simata" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">JPT Pratama</button>
        </li> -->
        <?php } ?>
      </ul>
        

        <!-- <div class="form-check ml-2 mt-2"> -->

      <!-- <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
      <label class="form-check-label" for="inlineRadio1"> <i class="fa fa-sync"></i> Nilai Assesment </label>
      </div> -->

      <!-- <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
        <label class="form-check-label" for="inlineRadio2"><i class="fa fa-sync"></i> Rekam Jejak</label>
      </div> -->

          <!-- <button style="margin-top:-5px;" class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-sync"></i> Rekam Jejak
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
            <label class="form-check-label ml-1" for="inlineRadio2"> Pendidikan Formal</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3">
            <label class="form-check-label ml-1" for="inlineRadio3"> Pangkat/Golongan Ruang</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="4">
            <label class="form-check-label ml-1" for="inlineRadio4"> Masa Kerja Jabatan</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="5">
            <label class="form-check-label ml-1" for="inlineRadio5"> Pendidikan dan Pelatihan Kepemimpinan</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio6" value="6">
            <label class="form-check-label ml-1" for="inlineRadio6"> Pengembangan Kompetensi 20 JP</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio7" value="7">
            <label class="form-check-label ml-1" for="inlineRadio7"> Penghargaan</label>
            </a>
            <a class="dropdown-item" href="#">
            <input class="form-check-input ml-1" type="radio" name="inlineRadioOptions" id="inlineRadio8" value="8">
            <label class="form-check-label ml-1" for="inlineRadio8"> Riwayat Hukuman Disiplin </label>
            </a>
          </div> -->

      <!-- <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
        <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
      </div> -->


  <!-- <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" >
        <label class="form-check-label" for="flexCheckChecked">
         <h4>  <i class="fa fa-sync"></i> Penilaian </h4>
        </label>
      </div> -->

        
        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show " id="pengawas" role="tabpanel" aria-labelledby="pengawas-tab">
         <br> <div id="list_pegawai_penilaian_kinerja_jptx" class="list_pegawai_penilaian_kinerja_jpt"></div>
        </div>

        <div class="tab-pane fade show " id="home" role="tabpanel" aria-labelledby="home-tab">
         <br> <div id="list_pegawai_penilaian_kinerja_jptx" class="list_pegawai_penilaian_kinerja_jpt"></div>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <br> <div id="list_pegawai_penilaian_kinerja_jptx" class="list_pegawai_penilaian_kinerja_jpt"></div>
        </div>
        </div>


       
        </div>
    </div>
    


    
<!-- modal detail indikator -->
<div class="modal fade" id="modal_penilaian_potensial" tabindex="-1" role="dialog" aria-labelledby="table-admModalLabelIndikator" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="table-admModalLabelIndikator"><span id="nm_indikator"></span></h3>
        <button type="button" id="modal_dismis" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="div_modal_penilaian_potensial">
      
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
   
    // loadListPegawaiPenilaianPotensialJpt(1)
    })

    $('#form_penilaian_talentax').on('submit', function(e){
 
              
      $('.list_pegawai_penilaian_kinerja_jpt').append(divLoaderNavy)
      
                e.preventDefault();
                var formvalue = $('#form_penilaian_talenta');
                var form_data = new FormData(formvalue[0]);

                var eselon = $('#eselon').val()
                
                if(eselon == 4 || eselon == 5){
                  var id = 2;
                  activaTab('jpt');
                } else if(eselon == 6 || eselon == 7) {
                  var id = 1;
                  activaTab('adm');
                } else {
                  alert(0)
                  var id = 3;
                  activaTab('pngws');
                }
              
               
                $.ajax({  
                url:"<?=base_url("simata/C_Simata/submitloadListPegawaiPenilainPotensialJpt")?>",
                method:"POST",  
                data:form_data,  
                contentType: false,  
                cache: false,  
                processData:false,  
                // dataType: "json",
                success:function(res){ 
                    console.log(res)
                    loadListPegawaiPenilaianPotensialJpt(id,3,1,eselon);
                  

                        // successtoast(result.msg)
                        // setTimeout(function() {$("#modal_penilaian_kinerja").trigger( "click" );}, 500);
                        // if(kode == 1){
                        //   const myTimeout = setTimeout(loadListPegawaiPenilaianKinerja(kode), 1000);
                        // } else {
                        //   const myTimeout = setTimeout(loadListPegawaiPenilaianKinerja(kode), 1000);

                        // }
            
                    
                     
                    
                }  
        }); 
             
    }); 

    $("#btn_nilai").click(function(){
    
      var eselon = $('#eselon').val()
      var jenis_pengisian = $('#jenis_pengisian').val()
      var skpd = $('#unitkerjamaster').val()
     
      if(eselon == 4 || eselon == 5){
        var id = 2;
        activaTab('jpt');
      } else if(eselon == 6 || eselon == 7) {
        var id = 1;
        activaTab('adm');
      } else {
        var id = 3;
        activaTab('pngws');
      }
    
     
      loadListPegawaiPenilaianPotensialJpt(id,jenis_pengisian,1,eselon,skpd);
         
    });


    $("#btn_hitung_masa_kerja").click(function(){
    
    var eselon = $('#eselon').val()
    var jenis_pengisian = $('#jenis_pengisian').val()
    var skpd = $('#unitkerjamaster').val()
   
    if(eselon == 4 || eselon == 5){
      var id = 2;
      activaTab('jpt');
    } else if(eselon == 6 || eselon == 7) {
      var id = 1;
      activaTab('adm');
    } else {
      var id = 3;
      activaTab('pngws');
    }
  
   
    loadListPegawaiPenilaianPotensialMasaKerja(id,jenis_pengisian,1,eselon,skpd);
       
  });
    

    



    function loadListPegawaiPenilaianPotensialAdm(){
   var id = $('#unit_kerja').val()
   $('.list_pegawai_penilaian_kinerja').html('')
   $('.list_pegawai_penilaian_kinerja').append(divLoaderNavy)
   $('.list_pegawai_penilaian_kinerja').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainPotensialAdm/")?>'+id, function(){
     $('#loader').hide()
   })
  }

  function loadListPegawaiPenilaianPotensialJpt(id,jenis_pengisian,penilaian,eselon,skpd){
    var radios = document.getElementsByName('inlineRadioOptions');
    // var penilaian = 0;
    for (var i = 0, length = radios.length; i < length; i++) {
      if (radios[i].checked) {
        // do whatever you want with the checked radio
        var penilaian = radios[i].value;

        // only one radio can be logically checked, don't check the rest
        break;
      }
    }

  
  //  return false;

  //  if($('#flexCheckChecked').prop('checked')){
  //   var penilaian = 1;
  //  } else {
  //   var penilaian = 0;
  //  }

   $('.list_pegawai_penilaian_kinerja_jpt').html('')
   $('.list_pegawai_penilaian_kinerja_jpt').append(divLoaderNavy)
   $('.list_pegawai_penilaian_kinerja_jpt').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainPotensialJpt/")?>'+id+'/'+jenis_pengisian+'/'+penilaian+'/'+eselon+'/'+skpd, function(){
     $('#loader').hide()
   })
  }

  function loadListPegawaiPenilaianPotensialMasaKerja(id,jenis_pengisian,penilaian,eselon,skpd){
    var radios = document.getElementsByName('inlineRadioOptions');
    // var penilaian = 0;
    for (var i = 0, length = radios.length; i < length; i++) {
      if (radios[i].checked) {
        // do whatever you want with the checked radio
        var penilaian = radios[i].value;

        // only one radio can be logically checked, don't check the rest
        break;
      }
    }

  
  //  return false;

  //  if($('#flexCheckChecked').prop('checked')){
  //   var penilaian = 1;
  //  } else {
  //   var penilaian = 0;
  //  }

   $('.list_pegawai_penilaian_kinerja_jpt').html('')
   $('.list_pegawai_penilaian_kinerja_jpt').append(divLoaderNavy)
   $('.list_pegawai_penilaian_kinerja_jpt').load('<?=base_url("simata/C_Simata/loadListPegawaiPenilainPotensialMasaKerja/")?>'+id+'/'+jenis_pengisian+'/'+penilaian+'/'+eselon+'/'+skpd, function(){
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
var jenispengisian = $(this).data('jenispengisian');


$('#div_modal_penilaian_potensial').html('')
$('#div_modal_penilaian_potensial').append(divLoaderNavy)
$('#div_modal_penilaian_potensial').load('<?=base_url("simata/C_Simata/loadModalPenilaianPotensial/")?>'+id+'/'+nip+'/'+kode+'/'+jenispengisian, function(){
  $('#loader').hide()
})

});


</script>