
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
            <h1 class="h3 mb-3">Usul Layanan</h1>

            <?php if($result){ ?>
  <div class="row">
    <div class="col-lg-12 table-responsive">
      <table class="table table-striped" id="datatable" border="0">
        <thead>
          <th class="">No</th>
          <th class="">Jenis Layanan</th>
          <th class="">Tanggal Usul</th>
          <th class="">Nama Pegawai</th>
          <th class="">Unit Organisasi</th>
          <th class="">Pengantar</th>
          <th></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class=""><?=$no++;?></td>
              <td class="text-left"><?=$rs['nama_layanan']?></td>
              <td class=""><?=formatDateNamaBulan($rs['tanggal_usul'])?></td>
              <td class="text-left"><?=$rs['nama_pegawai']?></td>
              <td class="text-left"><?=$rs['nm_unitkerja']?></td>
              <td class="">
                <button href="#modal_view_file" onclick="openFile('<?=$rs['file_pengantar']?>','<?=$rs['nip']?>','<?=$rs['nama_layanan']?>')" data-toggle="modal" class="btn btn-sm btn-success">
                Lihat <i class="fa fa-search"></i></button>
                
              </td>
             
              <td>
                <a href="<?= base_url();?>kepegawaian/verifikasi/<?=$rs['id_usul']?>">
                <button  class="btn btn-sm btn-primary">
                Verifikasi</button>
                </a>
              
                <!-- <a href="<?= base_url();?>Kepegawaian/C_Kepegawaian/CetakSurat/<?=$rs['id_usul']?>" target="_blank">View in PDF</a></td> -->
              <!-- <button href="#modal_cetak_file" onclick="LoadModalcetakSurat('<?=$rs['id_usul']?>','<?=$rs['nip']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
                Cetak Surat Cuti <i class="fa fa-print"></i></button> -->
              </td>
            </tr>
          
          <?php } ?>
        </tbody>
      </table>
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
        <iframe id="iframe_view_file" style="width: 100%; height: 80vh;" src=""></iframe>
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
        <script>

 </script>

      </div>
    </div>
  </div>
</div>                      




<script>
  $(function(){
    $('#datatable').dataTable()
  })

  function openFile(filename,nip,layanan){
    var url = "http://localhost/bkpsdmaio/dokumen_layanan/"+layanan+"/"
    $('#iframe_view_file').attr('src', url+nip+'/'+filename)
  }

  function LoadModalcetakSurat(id_usul,nip){
    $('#printableArea').html('')
    $('#printableArea').append(divLoaderNavy)
    $('#printableArea').load('<?=base_url("Kepegawaian/C_Kepegawaian/CetakSurat/")?>'+id_usul+'/'+nip, function(){
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

  
 

</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>

</div>
</div>
</div>
</div>
</div>