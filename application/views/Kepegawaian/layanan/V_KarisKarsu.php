<style>
    .label-filter{
        color: #434242;
        font-weight: bold;
        font-size: 15px;
    }
    
    .filter-option{
        overflow: auto;
        white-space: nowrap;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .filter-btn {
        display: inline-block;
        text-align: center;
        padding: 5px;
        border-radius: 5px;
        margin-right: 3px;
        transition: .2s;
    }

    .filter-unselect{
        border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #ea5454;
    }

    /* .filter-unselect:hover{
        cursor: pointer;
        background-color: #43556b;
        color: white;
    } */

    .filter-select{
        border: 1px solid #222e3c;
        color: white;
        font-weight: bold;
        background-color: #0a7129;
    }

    /* .filter-select:hover{
        cursor: pointer;
        background-color: #222e3c;
        color: white;
    } */
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title"><h5>FORM LAYANAN KARIS/KARSU</h5> </div> 
        <hr>
      </div>
      
      <div class="card-body">
       
        <form id="form_karis_karsu" method="post" enctype="multipart/form-data" id="form_cuti" style="margin-top: -45px;">
       
        <input type="hidden" id="sk_cpns" value="<?php if($sk_cpns) echo $sk_cpns['id']; else echo "";?>">
        <input type="hidden" id="sk_pns" value="<?php if($sk_pns) echo $sk_pns['id']; else echo "";?>">
        <input type="hidden" id="data_keluarga" value="<?php if($daftar_keluarga) echo $daftar_keluarga['id']; else echo "";?>">
        <input type="hidden" id="laporan_perkawinan" value="<?php if($laporan_perkawinan) echo $laporan_perkawinan['id']; else echo "";?>">
        <input type="hidden" id="pas_foto" value="<?php if($pas_foto) echo $pas_foto['id']; else echo "";?>">
        <input type="hidden" id="akte_nikah" value="<?php if($akte_nikah) echo $akte_nikah['id']; else echo "";?>">
       
        
        <span>Berkas Persyaratan :</span>
        <div class="col-lg-12 mt-2">
        <div class="filter-option col-lg-12">
        <span style="width:95%"  
        class="filter-btn filter-<?php if($sk_cpns) echo 'select'; else echo 'unselect';?>">SK CPNS <i class="fas fa-<?php if($sk_cpns) echo 'check'; else echo 'times';?>"></i> </span> 
        <?php if($sk_cpns) { ?> 
        <a onclick="filterClicked1('<?=$sk_cpns['gambarsk'];?>')"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> <i class="fa fa-file"></i> </a>
        <?php } ?>
      </div>
    </div>

  <div class="col-lg-12 mt-2">
     <div class="filter-option col-lg-12">
     <span style="width:95%"  onclick="filterClicked()" 
      class="filter-btn filter-<?php if($sk_pns) echo 'select'; else echo 'unselect';?>">SK PNS <i class="fas fa-<?php if($sk_pns) echo 'check'; else echo 'times';?>"></i></span> 
      <?php if($sk_pns) { ?> 
      <a onclick="filterClicked1('<?=$sk_pns['gambarsk'];?>')"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> <i class="fa fa-file"></i> </a>
     </div>
     <?php } ?>
  </div>

  <div class="col-lg-12 mt-2">
     <div class="filter-option col-lg-12">
     <span style="width:95%"  onclick="filterClicked()" 
      class="filter-btn filter-<?php if($laporan_perkawinan) echo 'select'; else echo 'unselect';?>">LAPORAN PERKAWINAN PERTAMA MENGETAHUI ATASAN <i class="fas fa-<?php if($laporan_perkawinan) echo 'check'; else echo 'times';?>"></i></span>
      <?php if($laporan_perkawinan) { ?> 
      <a onclick="filterClicked2('<?=$laporan_perkawinan['gambarsk'];?>')"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> <i class="fa fa-file"></i> </a>
     </div>
     <?php } ?>
  </div>

  <div class="col-lg-12 mt-2">
     <div class="filter-option col-lg-12">
     <span style="width:95%"  onclick="filterClicked()" 
      class="filter-btn filter-<?php if($daftar_keluarga) echo 'select'; else echo 'unselect';?> ">DAFTAR KELUARGA MENGETAHUI ATASAN <i class="fas fa-<?php if($daftar_keluarga) echo 'check'; else echo 'times';?>"></i></span> 
      <?php if($daftar_keluarga) { ?>
      <a onclick="filterClicked2('<?=$daftar_keluarga['gambarsk'];?>')"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> <i class="fa fa-file"></i> </a> 
      <?php } ?>
    </div>
  </div>

  <div class="col-lg-12 mt-2">
     <div class="filter-option col-lg-12">
     <span style="width:95%"  onclick="filterClicked()" 
      class="filter-btn filter-<?php if($akte_nikah) echo 'select'; else echo 'unselect';?> ">BUKU NIKAH / AKTA PERKAWINAN DILEGALISIR <i class="fas fa-<?php if($akte_nikah) echo 'check'; else echo 'times';?>"></i></span> 
      <?php if($akte_nikah) { ?>
      <a onclick="filterClicked2('<?=$akte_nikah['gambarsk'];?>')"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> <i class="fa fa-file"></i> </a> 
      <?php } ?>
    </div>
  </div>

  <div class="col-lg-12 mt-2">
     <div class="filter-option col-lg-12">
     <span style="width:95%"  onclick="filterClicked()" 
      class="filter-btn filter-<?php if($pas_foto) echo 'select'; else echo 'unselect';?> ">PAS FOTO ISTRI 3X4 LATAR MERAH (BAGI PNS LAKI-LAKI) / PAS FOTO SUAMI (BAGI PNS PEREMPUAN) <i class="fas fa-<?php if($pas_foto) echo 'check'; else echo 'times';?>"></i></span> 
     </div>
  </div>
  <button type="submit" class="btn btn-primary float-right mt-2">Ajukan</button>
        </form>
        <p class="mt-5">
        Keterangan :<br>
        <button class="btn btn-sm filter-btn filter-select" > <i class="fas fa-check"></i> </button> Berkas Sudah diupload<br>
        <button class="btn btn-sm filter-btn filter-unselect mt-2" > <i class="fas fa-times"></i> </button> Berkas belum diupload<br>
        Berkas diupload Pada Menu Profil <br>
        Untuk Berkas : <br>
        <i class="fa fa-file"></i> LAPORAN PERKAWINAN PERTAMA MENGETAHUI ATASAN ;<br>
        <i class="fa fa-file"></i> DAFTAR KELUARGA MENGETAHUI ATASAN ;<br>
        <i class="fa fa-file"></i> BUKU NIKAH / AKTA PERKAWINAN DILEGALISIR;<br>
        <i class="fa fa-file"></i> PAS FOTO ISTRI 3X4 LATAR MERAH (BAGI PNS LAKI-LAKI) / PAS FOTO SUAMI (BAGI PNS PEREMPUAN)
        <br>di upload pada bagian Arsip Lainnya.    
    </p>
    <a href="<?=base_url('kepegawaian/download');?>"> <i class="fa fa-download"> <i> Download Format Laporan Perkawinanan pertama & Daftar keluarga </i></i></a>
      </div>
    </div>
  </div>
  <div class="col-lg-12 mt-3">
    <div class="card card-default">
      <div class="card-header">
        <div class="card-title">
          <div class="card-title"><h5>RIWAYAT LAYANAN KARIS/KARSU</h5></div>
          <hr>
        </div>
      </div>
      <div class="card-body">
        <div class="row" style="margin-top: -40px;">
          <div class="col-lg-12 table-responsive" id="list_riwayat_karsu"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
      <h5 id="iframe_loader_gaji_berkala" class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
      <iframe id="iframe_view_file_berkas_pns" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
     
    </div>
  </div>
</div>

<script>

$(function(){
  $(".select2").select2({   
		width: '100%',
		dropdownAutoWidth: true,
		allowClear: true,
	});
  loadListRiwayatKarisKarsu()
    })
    $('#form_karis_karsu').on('submit', function(e){  
        //     document.getElementById('btn_upload').disabled = true;
        // $('#btn_upload').html('SIMPAN.. <i class="fas fa-spinner fa-spin"></i>')
        e.preventDefault();
        var formvalue = $('#form_karis_karsu');
        var form_data = new FormData(formvalue[0]);
        var sk_cpns = $('#sk_cpns').val()
        var sk_pns = $('#sk_pns').val()
        var daftar_keluarga = $('#daftar_keluarga').val()
        var laporan_perkawinan = $('#laporan_perkawinan').val()
        var pas_foto = $('#pas_foto').val()
        var akte_nikah = $('#akte_nikah').val()


        if(sk_cpns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }
        
        if(sk_pns == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(daftar_keluarga == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(laporan_perkawinan == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(pas_foto == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        if(akte_nikah == ""){
            errortoast(' Berkas Belum Lengkap')
            return false;
        }

        $.ajax({  
        url:"<?=base_url("kepegawaian/C_Kepegawaian/insertUsulLayananKarisKarsu")?>",
        method:"POST",  
        data:form_data,  
        contentType: false,  
        cache: false,  
        processData:false,  
        // dataType: "json",
        success:function(res){ 
            console.log(res)
            var result = JSON.parse(res); 
            if(result.success == true){
                successtoast(result.msg)
                loadListRiwayatKarisKarsu()
              } else {
                errortoast(result.msg)
                return false;
              } 
            
        }  
        });  
          
        });


    async function filterClicked1(filename){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/arsipberkaspns/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  async function filterClicked2(filename){
    $('#iframe_view_file_berkas_pns').hide()
    $('.iframe_loader').show()  
    $('.iframe_loader').html('LOADING.. <i class="fas fa-spinner fa-spin"></i>')
    
    
    var number = Math.floor(Math.random() * 1000);
    $link = "<?=base_url();?>/arsiplain/"+filename+"?v="+number;
   
    $('#iframe_view_file_berkas_pns').attr('src', $link)
        $('#iframe_view_file_berkas_pns').on('load', function(){
          $('.iframe_loader').hide()
          $(this).show()
    })

  }

  function loadListRiwayatKarisKarsu(){
    $('#list_riwayat_karsu').html('')
    $('#list_riwayat_karsu').append(divLoaderNavy)
    $('#list_riwayat_karsu').load('<?=base_url("kepegawaian/C_Kepegawaian/loadListRiwayatKarisKarsu/")?>', function(){
      $('#loader').hide()
    })
    }

</script>