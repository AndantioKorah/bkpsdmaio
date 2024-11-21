

    <!-- <div class="card-header">
        <h3 class="card-title">List Realisasi Kerja</h3>
    </div> -->
    <div class="card-body">
    <div class="col-12">
   
     <br>
    </div>
        <div id="" class="row">
        <?php if($list_peninjauan){ ?>
        <div class="col-12 table-responsive">
        <table  class="table table-striped table-bordered" id="table_data" width="100%">
            <thead>
                <th class="text-center ">No</th>
                <th class="text-left ">Tanggal Absensi</th>
                <th class="text-left ">Jenis Absensi</th>
                <th class="text-left ">Jenis Bukti Absensi</th>
                <th class="text-left ">Teman Absensi</th>
                <th class="text-left ">Status</th>
                <th class="text-left ">Keterangan</th>  
                <th class="text-left ">Bukti Dokumen</th>               
                <th></th>
            </thead>
            <tbody>
            <?php $no=1; foreach($list_peninjauan as $lp){ ?>
                    <tr>
                        <td class="text-center"><?=$no++;?></td>
                        <td class="text-left"><?=$lp['tanggal_absensi']?></td>
                        <td class="text-left">
                          <?php if($lp['jenis_absensi'] == 1) echo "Absen Pagi"; else echo "Absen Sore";?>
                        </td>
                        <td class="text-left">
                          <?php if($lp['jenis_bukti'] == 1) echo "Foto Bersama Teman"; else echo "Screenshot Whatsapp";?>
                        </td>
                        <td class="text-left"><?=$lp['gelar1']?><?=$lp['nama']?><?=$lp['gelar2']?></td>

                        <td class="text-left"> 
                        <?php if($lp['status'] == 0) echo  "Menunggu Verifikasi BKPSDM";
                                                    else if($lp['status'] == 1) echo "diterima";
                                                    else if($lp['status'] == 2) echo "ditolak";
                                                    else if($lp['status'] == 3) echo "Menunggu Verifikasi BKPSDM"; ?></td>
                      
                       <td class="text-left">
                       <?php if($lp['status'] == 2) echo$lp['keterangan_verif'];?>
                       </td>
                      
                       <td class="text-center">  
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-file"></i> Lihat File
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php 
                            
                            $file = json_decode($lp['bukti_kegiatan']);
                            $nodok = 1;
                            $tanggal = new DateTime($lp['tanggal_absensi']);
                            $tahun = $tanggal->format("Y");
                            $bulan = $tanggal->format("m");
                            if($file) {
                            foreach($file as $file_name)
                                {
                                  $data = $file_name;    
                                  // $ekstension = substr($data, strpos($data, ".") + 1); 
                                  $ekstension = pathinfo($data, PATHINFO_EXTENSION);
                                  
                                    if($file_name == null){
                                        echo "<a class='dropdown-item' >Tidak Ada File</a>";
                                    } else {
                                      if($ekstension == "png" || $ekstension == "jpg" || $ekstension == "jpeg"){
                                        // echo "<a class='dropdown-item' href=".base_url('assets/bukti_kegiatan/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        echo "<a class='dropdown-item'  href='javascript:;' data-id='".$lp['id']."' data-bulan='".$bulan."' data-tahun='".$tahun."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";

                                      } else {
                                        echo "<a class='dropdown-item' href=".base_url('assets/peninjauan_absensi/'.$file_name.'')." target='_blank'>Dokumen ".$nodok."</a>";
                                        // echo "<a class='dropdown-item'  href='javascript:;' data-id='".$lp['id']."'  data-gambar='".$file_name."' data-toggle='modal' data-target='#edit-data'>Dokumen ".$nodok."</a>";
                                      }
                                    }
                                   $nodok++;
                                } 
                              } else {
                                echo "<a class='dropdown-item' >Tidak Ada File</a>";
                              }
                            ?>
   
                        </div>
                           
                        </td>
                        <style>
                          .customWidthTD{
                            width:10%;
                          }
                        </style>
                        <td class="customWidthTD" >
                       
                        <div class="btn-group" role="group" aria-label="Basic example">
                        <?php if($lp['status'] != 1){ ?>
                          <button onclick="deleteKegiatan('<?=$lp['id']?>','<?=$lp['tanggal_absensi']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash" ></i></button>     
                          <?php } ?>
                          <?php if($lp['status'] == 2){ ?>
                          <button 
                          data-toggle="modal" 
                          data-id="<?=$lp['id']?>"
                           data-jenis_absensi="<?=$lp['jenis_absensi']?>"
                            data-tanggal_absensi="<?=$lp['tanggal_absensi']?>"
                          href="#exampleModalz"
                          title="Ubah Data" class="open-ModalAjukanKembali btn btn-sm btn-primary"> Ajukan Kembali</button>
                          <?php } ?> 
                      </div>

                      
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>


    
<!-- Modal -->
<div class="modal fade" id="exampleModalz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengajuan Kembali</h5>
        <button id="btncm" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form method="post" id="form_pengajuan_kembali" enctype="multipart/form-data" >
   
  <input autocomplete="off" type="hidden" class="form-control" id="id_peninjauan" name="id_peninjauan">

  <div class="mb-3">
    <label class="form-label">Tanggal Absensi</label>
    <input autocomplete="off" type="text" class="form-control" id="p_tanggal_absensi" name="p_tanggal_absensi"  readonly>
  </div>

  <div class="mb-3">
    <label class="form-label">Jenis Absensi</label>
    <input autocomplete="off" type="text" class="form-control" id="p_jenis_absensi"  readonly>
  </div>
  
  <div class="mb-3">
    <label class="form-label">Dokumen Bukti Baru</label>
    <input autocomplete="off" type="file" class="form-control" id="p_image_file" name="file"  required>
  </div>

  <button id="btn_pengajuan_kembali" class="btn btn-primary float-right">Simpan</button>
</form>
      </div>
      
    </div>
  </div>
</div>

   
<?php } else { ?>
    <div class="row">
        <div class="col-12">
            <h5 style="text-center">DATA TIDAK DITEMUKAN <i class="fa fa-exclamation"></i></h5>
        </div>
    </div>
<?php } ?>



<div aria-hidden="true" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal modal-fullscreen fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          
            <div class="modal-body">
           
              <style>
                .button_wrapper {
                  width: 33%;
                  float: left;
              }

              .button {
                  display: inline-block;
                  /* background-color: yellow; */
              }
              </style>
               <div class="button_wrapper">
            <div class="button">
              
            <button onClick="rotateImgLeft()"   type="button" class="next btn btn-info alignleft" value=""> <i class="fa fa-undo" aria-hidden="true"></i> </button>
            </div>
            </div>
            <div class="button_wrapper" style="text-align: center;">
                <div class="button">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-window-close" aria-hidden="true"></i>
                </button>
                </div>
            </div>
            <div class="button_wrapper" style="text-align: right;">
                <div class="button">
            <button onClick="rotateImgRight()"  type="button" class="next btn btn-info alignright" value=""> <i class="fa fa-redo" aria-hidden="true"></i> </button>

                </div>
            </div>

            <div id="textbox">
            <!-- <button onClick="rotateImgLeft()"   type="button" class="next btn btn-info alignleft" value=""> <i class="fa fa-undo" aria-hidden="true"></i> </button>
            <button onClick="rotateImgRight()"  type="button" class="next btn btn-info alignright" value=""> <i class="fa fa-redo" aria-hidden="true"></i> </button> -->
           
            </div>
            <style>
                .alignleft {
                    float: left;
                }
                .alignright {
                    text-align: right;
                }
                .aligncenter {
                  text-align: center;
                    display: inline-block;
                }
            </style>

           
                <center>
                        <div class="container" style="margin-top:50px;">
                        <div id="gambar_lama"></div>
                        </div>
                 </center>      
         </div>
                
         

            </div>
        </div>
    </div>
</div>


<script>

$(function(){
       $('#table_data').dataTable()
   })


// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
// img.onclick = function(){
//   modal.style.display = "block";
//   modalImg.src = this.src;
//   captionText.innerHTML = this.alt;
// }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
// span.onclick = function() { 
//   modal.style.display = "none";
// }
</script>
<script>
    let rotation = 0;
    function rotateImgRight() {
      rotation += 90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }

    function rotateImgLeft() {
      // let rotation = 0;
      rotation += -90; // add 90 degrees, you can change this as you want
      if (rotation === 360) { 
        // 360 means rotate back to 0
        rotation = 0;
      }
      document.querySelector("#img").style.transform = `rotate(${rotation}deg)`;
    }

    function closeModal() {
      $('#edit-data').modal('hide');
    }

   
  </script>

<script>
           $('#edit-data').on('show.bs.modal', function (event) {
            $('#gambar_lama').html('');
          
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
           
            // Isi nilai pada field
            modal.find('#id').attr("value",div.data('id'));

            modal.find('#img2').attr("src","http://placekitten.com/120/120/");
            // console.log(div.data('gambar'))
            $('#gambar_lama').append('<img id="img" class="img-fluid" alt="Responsive image"  src="<?php echo base_url();?>/assets/peninjauan_absen/'+div.data('tahun')+'/'+div.data('bulan')+'/'+div.data('gambar')+'?=t'+new Date().getTime()+'" class="thumb">');
            
        });
</script>

<script>
        // $(document).ready(function () {
        // $('#table_realisasi_kinerja').DataTable({
        // "scrollX": true
        // });
        // $('.dataTables_length').addClass('bs-select');
        // });

        function deleteKegiatan(id,tgl){
           
           var d = new Date(tgl);

            var bulan = d.getMonth() + 1;
            var tahun = d.getFullYear();

            // $('[data-toggle="tooltip"]').tooltip({
            //     trigger : 'hover'
            // })
            // $('[data-toggle="tooltip"]').tooltip('hide');
          
            if(confirm('Apakah Anda yakin ingin menghapus data?')){
   
                $.ajax({
                    url: '<?=base_url("kinerja/C_Kinerja/deletePeninjauanAbsensi/")?>'+id,
                    method: 'post',
                    data: null,
                    success: function(){
                        successtoast('Data sudah terhapus')
                        loadListPeninjauan()
                        cekPengajuan()
                        $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
            })
            $('[data-toggle="tooltip"]').tooltip('hide');
                    }, error: function(e){
                        errortoast('Terjadi Kesalahan')
                    }
                })
            }
        }


        $(document).on("click", ".open-ModalAjukanKembali", function () {
        var id = $(this).data('id');
        var tanggal_absensi = $(this).data('tanggal_absensi');
        var jenis_absensi = $(this).data('jenis_absensi');

        if(jenis_absensi == 1){
         jns_absen = "Pagi";
        } else {
          jns_absen = "Sore";
        }
     
     
        $(".modal-body #id_peninjauan").val( id );
        $(".modal-body #p_tanggal_absensi").val( tanggal_absensi );
        $(".modal-body #p_jenis_absensi").val( jns_absen );
    });


    $("#p_image_file").change(function (e) {
    
    var fileSize = this.files[0].size/1024;
    
    var doc = image_file.value.split('.')
    var extension = doc[doc.length - 1]
    const  fileType = this.files[0].type;
    
    
    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
    if (!validImageTypes.includes(fileType)) {
        errortoast("Harus File Gambar")
        $(this).val('');
    }
    
    if (extension == "jfif"){
      errortoast("Harus File Gambar")
      $(this).val('');
    }
    
    });


    $('#form_pengajuan_kembali').on('submit', function(e){  
       
       e.preventDefault();
       
       var formvalue = $('#form_pengajuan_kembali');
       var form_data = new FormData(formvalue[0]);
       var ins = document.getElementById('p_image_file').files.length;


       if(ins == 0){
       errortoast("Silahkan upload bukti kegiatan terlebih dahulu");
      //  document.getElementById('btn_pengajuan_kembali').disabled = false;
      //  $('#btn_pengajuan_kembali').html('<i class="fa fa-save"></i>  SIMPAN')
       return false;
       }
      
      
       $.ajax({  
       url:"<?=base_url("kinerja/C_Kinerja/pengajuanKembaliPeninjauanAbsensi")?>",
       method:"POST",  
       data:form_data,  
       contentType: false,  
       cache: false,  
       processData:false,  
       // dataType: "json",
       success:function(res){ 
           var result = JSON.parse(res); 
           console.log(result);
           // console.log(result.msg);
           // return false;
           
             if(result.success == true){
              $('#btncm').click()
              const myTimeout = setTimeout(loadListPeninjauan, 500);
             } else {
               errortoast(result.msg)
               return false;
             }
               document.getElementById("form_tinjau_absen").reset();
               document.getElementById('btn_upload').disabled = false;
       }  
       });  
         
       });
        
    </script>
