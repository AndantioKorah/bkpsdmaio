
<style>
  @media print {
    body * {
        visibility: hidden;
    }
    .printme, .printme * {
        visibility: visible;
    }
    .printme {
        position: absolute;
        left: 0;
        top: 0;
    }
    .printme, .printme:last-child {
        page-break-after: avoid;
    }

    .display-none-on, .display-none-on * {
        display: none !important;
    }
    html, body {
        height: auto;
        font-size: 130%; /* changing to 10pt has no impact */
    }

}
</style>
<div class="container-fluid p-0">
  

<div class="row">
    <div class="col-12">
        
        <div class="card">
       
            <div class="card-body">
            <h1 class="h3 mb-3">Verifikasi Layanan</h1>
            <style>
              .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
              background-color: #222e3c;
              color: #fff;
              }
              .nav-pills .nav-link {
              color: #000;
              border: 0;
              border-radius: var(--bs-nav-pills-border-radius);
          }
            </style>

  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button onclick="loadListUsulLayanan(0)" class="nav-link active" id="pills-pangkat-tab" data-bs-toggle="pill" data-bs-target="#pills-pangkat" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Belum diverifikasi</button>
  </li>
  <li class="nav-item" role="presentation">
    <button  onclick="loadListUsulLayanan(1)" class="nav-link" id="pills-berkala-tab" data-bs-toggle="pill" data-bs-target="#pills-berkala" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Sudah diverifikasi</button>
  </li>
  <li class="nav-item" role="presentation">
    <button onclick="loadListUsulLayanan(2)" class="nav-link" id="pills-pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pills-pendidikan" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Ditolak</button>
  </li>
 
</ul>
<hr>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-pangkat" role="tabpanel" aria-labelledby="pills-pangkat-tab">
  <div id="belum_verif"></div>
  </div>
  <div class="tab-pane fade" id="pills-berkala" role="tabpanel" aria-labelledby="pills-berkala-tab">
  <div id="sudah_verif"></div>
  </div>
  <div class="tab-pane fade" id="pills-pendidikan" role="tabpanel" aria-labelledby="pills-pendidikan-tab">
  <div id="tolak">bds</div>
  </div>
  
</div>



	
	<!-- Script to print the content of a div -->
	
			
  <div class="modal fade" id="modal_view_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
        <iframe id="iframe_view_filex" style="width: 100%; height: 80vh;" src=""></iframe>
      </div>
    </div>
  </div>
</div>  

<div class="modal fade" id="modal_cetak_file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- <div class="modal-header">
        DOKUMEN
      </div> -->
      <div class="modal-body" id="modal_view_file_content">
      <div id="printableArea" style="display:nonex">
      </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="cetak()" value="Test print"/> <i class="fa fa-print"></i> Print</button>
      </div>
    </div>
  </div>
</div>                      



<div class="modal fade" tabindex="-1" role="dialog" id="modal_detail_cuti">
<div id="modal-dialog" class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Cuti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
      <div class="col-lg-6 text-left">
        <span style="color: grey; font-size .8rem; font-style: italic;">Nama</span><br>
        <span id="nama_pegawai" style="font-size: 1rem; font-weight: bold;"></span>
      </div>
      <div class="col-lg-6 text-right">
        <span style="color: grey; font-size .8rem; font-style: italic;">NIP</span><br>
        <span id="nip" style="font-size: 1rem; font-weight: bold;"></span>
      </div>
      <div class="col-lg-12"><hr></div>
    </div>

        <div class="row">
        <div class="col-lg-6">
        <form method="post" id="form_nomor_surat" enctype="multipart/form-data" >
        <input type="hidden" id="id_usul" name="id_usul" >
  <div class="mb-3">
    <label for="nomor_surat" class="form-label">Jenis Cuti</label>
    <input type="text" class="form-control" id="jenis_cuti" name="jenis_cuti" readonly>
  </div>
  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Mulai</label>
    <input type="text" class="form-control " id="tanggal_mulai" name="tanggal_mulai" readonly>
  </div>

  <div class="mb-3">
    <label for="tanggal_surat" class="form-label">Tanggal Selesai</label>
    <input type="text" class="form-control " id="tanggal_selesai" name="tanggal_selesai" readonly>
  </div>
 
</form>
        </div>
        <div class="col-lg-6">
        <iframe id="iframe_view_file" style="height: 50vh; width: 100%;" src=""></iframe>
        </div>
        </div>
     
      
      </div>
    </div>
  </div>
</div>



<script>
  $(function(){
    $('#datatable').dataTable()
    loadListUsulLayanan(0)
  })

  function openFile(filename,nip,layanan){
    var url = "<?=base_url();?>dokumen_layanan/"+layanan+"/"
    $('#iframe_view_file').attr('src', url+nip+'/'+filename)
  }

  function LoadModalcetakSurat(id_usul,nip){
    $('#printableArea').html('')
    $('#printableArea').append(divLoaderNavy)
    $('#printableArea').load('<?=base_url("kepegawaian/C_Kepegawaian/CetakSurat/")?>'+id_usul+'/'+nip, function(){
      $('#loader').hide()
    })

    // const myTimeout = setTimeout(printDiv, 1000);
 
  }

  function printDiv() {
     var printContents = document.getElementById('printableArea').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
      
     window.print();
     document.body.innerHTML = originalContents;
}

function printGrid() {
        var gridData = document.getElementById('printableArea');
            var windowUrl = ' ';
            //set print document name for gridview
            var uniqueName = new Date();
            var windowName = 'Print_' + uniqueName.getTime();
            var prtWindow = window.open(windowUrl, windowName, 'left=0,top=0,right=0,bottom=0,width=screen.width,height=screen.height,margin=0,0,0,0');
            prtWindow.document.write('<html><head><font size="5">TITLE</font></head>');
            prtWindow.document.write('<body style="background:none !important; font-size:10pt !important">');
            prtWindow.document.write(gridData.outerHTML);
            prtWindow.document.write('</body></html>');
            prtWindow.document.close();
            prtWindow.focus();
            prtWindow.print();
            prtWindow.close();
        }


  function cetak(){
    window.frames["printf"].print();
  }

  function loadListUsulLayanan(val){
  
  if(val == 0){
    var div = '#belum_verif';
  } else if(val == 1){
    var div = '#sudah_verif';
  }  else {
    var div = '#tolak';
  }
 
  $(div).html('')
  $(div).append(divLoaderNavy)
  $(div).load('<?=base_url("kepegawaian/C_Kepegawaian/getAllUsulLayananAdmin/")?>'+val, function(){
    $('#loader').hide()
  })
}

</script>

</div>
</div>
</div>
</div>
</div>