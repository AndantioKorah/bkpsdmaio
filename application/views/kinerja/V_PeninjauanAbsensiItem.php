

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
                                                    else if($lp['status'] == 2) echo "ditolak";  ?></td>
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
                        <?php if($lp['status'] == 2){ ?>
                          <?php } ?>
                            <span href="#edit_realisasi_kinerja" data-toggle="modal" style="display: inline;">
                            <!-- <button href="#edit_realisasi_kinerja" data-toggle="tooltip" class="btn btn-sm btn-primary mr-1" data-placement="top" title="Edit" 
                             onclick="openModalEditRealisasiKinerja('<?=$lp['id']?>')"><i class="fa fa-edit"></i> </button> -->
                            </span>  
                            <button onclick="deleteKegiatan('<?=$lp['id']?>','<?=$lp['tanggal_absensi']?>')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash" ></i></button>     
                           
                      </div>

                      
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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

        
    </script>
