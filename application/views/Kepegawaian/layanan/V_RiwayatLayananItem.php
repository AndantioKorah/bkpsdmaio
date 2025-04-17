<?php if($result){ ?>
  <div class="row">
    <div class="card-body table-responsive">
        
      <table class="table table-hover datatable" style="width:100%;">
        <thead>
          <th class="text-left">No</th>
          <th class="text-left">Tanggal Pengajuan</th>
          <th class="text-left">Status</th>
          <th class="text-left">Keterangan</th>
          <th class="text-left">Surat Pengantar</th>
          <?php if($m_layanan == 10) { ?>
          <th class="text-left">SK Perbaikan Data</th>
          <?php } ?>
          <th style="width:40%;"></th>
        </thead>
        <tbody>
          <?php $no = 1; foreach($result as $rs){ ?>
            <tr>
              <td class="text-left"><?=$no++;?></td>
              <td class="text-left"><?= formatDateNamaBulan($rs['created_date'])?></td>
              <td class="text-left">
             <span class="badge badge-<?php if($rs['status'] == '1' || $rs['status'] == '4') echo "success"; else if($rs['status'] == '2' || $rs['status'] == '5') echo "danger"; else echo "primary";?>"><?php if($rs['status'] == '1') echo "Diterima"; else if($rs['status'] == '2') echo "Ditolak"; else if($rs['status'] == '3') echo "Usul BKAD"; else if($rs['status'] == '4')  echo "Diterima BKAD"; else if($rs['status'] == '5') echo "BTL / Berkas Tidak Lengkap"; else echo "Menunggu Verifikasi BKPSDM" ?>

            </td>
              <td class="text-left"><?=$rs['keterangan']?></td>
            <td>
            <button href="#modal_view_file" onclick="openFilePengantar('<?=$rs['file_pengantar']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
            <i class="fa fa-file-pdf"></i></button>
            </td>
            <?php if($m_layanan == 10) { ?>
          <td class="text-left">
          <button href="#modal_view_file" onclick="openFileSK('<?=$rs['dokumen_layanan']?>')" data-toggle="modal" class="btn btn-sm btn-navy-outline">
          <i class="fa fa-file-pdf"></i></button>
          </td>
          <?php } ?>
              <td>
              <?php if($rs['status'] == 0 AND $rs['keterangan'] == "") { ?>
              <button title="Hapus" onclick="deleteData('<?=$rs['id']?>')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> 
              <?php } ?>
              <?php if($rs['status'] == 2) { ?>
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">
                <button
                data-id="<?=$rs['id'];?>"
                data-file_pengantar="<?=$rs['file_pengantar'];?>" 
                id="btn_verifikasi" type="button" class="btn btn-sm btn-info ml-2" data-toggle="modal" data-target="#modalUbahSp">
                <i class="fa fa-edit"></i> Ubah Surat Pengantar 
                </button>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                <button onclick="ajukanKembali('<?=$rs['id']?>')" class="btn btn-sm btn-primary">Ajukan Kembali <i class="fa fa-arrow-right"></i></button> 

                </div>
                
              </div>
              
               
              <?php } ?>
              <?php if($rs['id_m_layanan'] == 12) { ?>
                <?php if($rs['status'] == 5) { ?>
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">
                <button
                data-id="<?=$rs['id'];?>"
                data-file_pengantar="<?=$rs['file_pengantar'];?>" 
                id="btn_verifikasi" type="button" class="btn btn-sm btn-info ml-2" data-toggle="modal" data-target="#modalUbahSp">
                <i class="fa fa-edit"></i> Ubah Surat Pengantar 
                </button>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                <button onclick="ajukanKembali('<?=$rs['id']?>')" class="btn btn-sm btn-primary">Ajukan Kembali <i class="fa fa-arrow-right"></i></button> 

                </div>
                
              </div>
              
               
              <?php } ?>
                <?php } ?>
            </td>
           
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  
 
<div class="modal fade" id="modal_view_file" >
<div id="modal-dialog" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
        <div class="modal-body">
           <div id="modal_view_file_content">
            <h5  class="text-center iframe_loader"><i class="fa fa-spin fa-spinner"></i> LOADING...</h5>
            <iframe style="display: none; width: 100%; height: 80vh;" type="application/pdf"  id="iframe_view_file"  frameborder="0" ></iframe>	

          </div>
        </div>
      </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalUbahSp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" id="form_ubah_surat_pengantar" enctype="multipart/form-data" >
        <input type="hidden" name="id_pengajuan" id="id_pengajuan">
        <input type="hidden" name="file_pengantar" id="file_pengantar">
        <div class="form-group">
        <label>Surat Pengantar</label>
        <input  class="form-control my-image-field" type="file" id="pdf_surat_pengantar_ubah" name="file"   />
        <span style="color:red;">* Maksimal Ukuran File : 1 MB</span><br>
      </div>
    
      <button id="btn_submit_sp" class="btn btn-primary" style="float: right;">Simpan</button>
    </form>
      </div>
    </div>
  </div>
</div>


<script>
  $(function(){ 
    $('.datatable').dataTable()
  })

  function deleteData(id){
                  var id_layanan = "<?=$m_layanan;?>"
                   if(confirm('Apakah Anda yakin ingin menghapus data?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/deleteRiwayatLayanan/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Data sudah terhapus')
                               if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
                               loadListRiwayatLayananPangkat()
                               }
                               if(id_layanan == 10){
                                loadListRiwayatPerbaikanData()
                               }
                               if(id_layanan == 18 || id_layanan == 19 || id_layanan == 20){
                                loadListRiwayatUjianDinas()
                               }
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

async function openFilePengantar(filename){
 var id_layanan = "<?=$m_layanan;?>"
$('#iframe_view_file').hide()
$('.iframe_loader').show()  

var number = Math.floor(Math.random() * 2000);
if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
  $link = "<?=base_url();?>dokumen_layanan/pangkat/"+filename+"?v="+number;
} else if(id_layanan == 10){
  $link = "<?=base_url();?>dokumen_layanan/perbaikan_data/"+filename+"?v="+number;
} else if(id_layanan == 11){
  $link = "<?=base_url();?>dokumen_layanan/permohonan_salinan_sk/"+filename+"?v="+number;
} else if(id_layanan == 18 || id_layanan == 19 || id_layanan == 20){
  $link = "<?=base_url();?>dokumen_layanan/ujian_dinas/"+filename+"?v="+number;
} else if(id_layanan == 12){
  $link = "<?=base_url();?>dokumen_layanan/jabatan_fungsional/"+filename+"?v="+number;
}

$('#iframe_view_file').attr('src', $link)
$('#iframe_view_file').on('load', function(){
  $('.iframe_loader').hide()
  $(this).show()
})
}

async function openFileSK(filename){
 var id_layanan = "<?=$m_layanan;?>"
$('#iframe_view_file').hide()
$('.iframe_loader').show()  
var number = Math.floor(Math.random() * 2000);
$link = "<?=base_url();?>arsipperbaikandata/"+filename+"?v="+number;
$('#iframe_view_file').attr('src', $link)
$('#iframe_view_file').on('load', function(){
  $('.iframe_loader').hide()
  $(this).show()
})
}

function ajukanKembali(id){
                  var id_layanan = "<?=$m_layanan;?>"
                   if(confirm('Ajukan kembali layanan pangkat ?')){
                       $.ajax({
                           url: '<?=base_url("kepegawaian/C_Kepegawaian/ajukanKembaliLayananPangkat/")?>'+id,
                           method: 'post',
                           data: null,
                           success: function(){
                               successtoast('Layanan diajukan kembali')
                              //  if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
                               loadListRiwayatLayananPangkat()
                              //  }
                           }, error: function(e){
                               errortoast('Terjadi Kesalahan')
                           }
                       })
                   }
               }

               $("#pdf_surat_pengantar_ubah").change(function (e) {

                var doc = pdf_surat_pengantar_ubah.value.split('.')
                var extension = doc[doc.length - 1]

                var fileSize = this.files[0].size/1024;
                var MaxSize = 2048;

                if (extension != "pdf"){
                  errortoast("Harus File PDF")
                  $(this).val('');
                }

                if (fileSize > MaxSize ){
                  errortoast("Maksimal Ukuran File 1 MB")
                  $(this).val('');
                }

                });


                $('#modalUbahSp').on('show.bs.modal', function (event) {
    
                var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
                var modal = $(this)
                modal.find('#file_pengantar').attr("value",div.data('file_pengantar'));
                modal.find('#id_pengajuan').attr("value",div.data('id'));
            });

    $('#form_ubah_surat_pengantar').on('submit', function(e){  
     
     e.preventDefault();
     var formvalue = $('#form_ubah_surat_pengantar');
     var form_data = new FormData(formvalue[0]);
     var ins = document.getElementById('pdf_surat_pengantar_ubah').files.length;
     var id_layanan = "<?=$m_layanan;?>"
    //  document.getElementById('btn_submit_sp').disabled = true;
    //  $('#btn_submit_sp').html('Loading.... <i class="fas fa-spinner fa-spin"></i>')
   
     $.ajax({  
     url:"<?=base_url("kepegawaian/C_Kepegawaian/submitEditSPLayanan")?>",
     method:"POST",  
     data:form_data,  
     contentType: false,  
     cache: false,  
     processData:false,  
     // dataType: "json",
     success:function(res){ 
         console.log(res)
         var result = JSON.parse(res); 
         console.log(result)
         if(result.success == true){
             successtoast(result.msg)
             if(id_layanan == 6 || id_layanan == 7 || id_layanan == 8 || id_layanan == 9){
                // loadListRiwayatLayananPangkat()
                setTimeout(function() {$("#modalUbahSp").trigger( "click" );}, 1000);
                const myTimeout = setTimeout(loadListRiwayatLayananPangkat, 2000);
            }
           } else {
             errortoast(result.msg)
             return false;
           } 
         
     }  
     });  
       
     }); 
</script>
<?php } else { ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h4>TIDAK ADA RIWAYAT LAYANAN <i class="fa fa-exclamation"></i></h4>
    </div>
  </div>
<?php } ?>